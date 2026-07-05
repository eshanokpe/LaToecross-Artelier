<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use App\Notifications\NewVisitorNotification;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TrackVisitors
{
    public function handle(Request $request, Closure $next)
    {
        // Skip admin, non-GET requests and bots
        if (
            str_starts_with($request->path(), 'admin') ||
            !$request->isMethod('GET') ||
            $this->isBot($request->userAgent())
        ) {
            return $next($request);
        }

        $ip = $request->ip();
        $pageUrl = $request->fullUrl();

        // Avoid duplicate entries for the same page from the same IP within 10 minutes
        if (Visitor::where('ip_address', $ip)
            ->where('page_url', $pageUrl)
            ->where('created_at', '>', Carbon::now()->subMinutes(10))
            ->exists()
        ) {
            return $next($request);
        }

        // Fetch geo data ONCE and reuse for both fields
        // (previously this called the API twice per visitor, which frequently
        // got rate-limited by ipapi.co and caused missing/wrong values)
        $geo = $this->getGeo($ip);

        // Save visitor data
        $visitor = Visitor::create([
            'ip_address' => $ip,
            'country'    => $geo['country'],
            'city'       => $geo['city'],
            'page_url'   => $pageUrl,
            'user_agent' => $request->userAgent(),
            'device'     => $this->getDevice($request->userAgent()),
            'browser'    => $this->getBrowser($request->userAgent()),
        ]);

        // Send alert to MULTIPLE emails
        $recipients = array_map('trim', explode(',', config('mail.admin_alerts')));
        Notification::route('mail', $recipients)
            ->notify(new NewVisitorNotification($visitor));

        return $next($request);
    }

    /**
     * Detect bots/crawlers
     */
    private function isBot(string $userAgent): bool
    {
        return (bool)preg_match('/bot|crawl|spider|slurp|curl|wget|preview|headless/i', strtolower($userAgent));
    }

    /**
     * Simple device detection
     */
    private function getDevice(string $userAgent): string
    {
        $ua = strtolower($userAgent);
        if (str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone')) {
            return 'Mobile';
        }
        if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
            return 'Tablet';
        }
        if (str_contains($ua, 'windows') || str_contains($ua, 'macintosh') || str_contains($ua, 'linux')) {
            return 'Desktop';
        }
        return 'Unknown';
    }

    /**
     * Simple browser detection
     */
    private function getBrowser(string $userAgent): string
    {
        $ua = strtolower($userAgent);
        $browsers = [
            'Chrome', 'Firefox', 'Safari', 'Edge', 'Opera', 'Internet Explorer'
        ];
        foreach ($browsers as $name) {
            if (str_contains($ua, strtolower($name))) {
                return $name;
            }
        }
        return 'Unknown';
    }

    /**
     * Get Country & City from ipapi.co (free, HTTPS) in a SINGLE request.
     *
     * @return array{country: ?string, city: ?string}
     */
    private function getGeo(string $ip): array
    {
        $fallback = ['country' => null, 'city' => null];

        // Skip private/local IPs
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return ['country' => 'Local/Testing', 'city' => 'Local/Testing'];
        }

        try {
            $url = "https://ipapi.co/{$ip}/json/";

            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_TIMEOUT => 3,
                CURLOPT_FOLLOWLOCATION => true,
                // ipapi.co can reject/deprioritize requests with no User-Agent
                CURLOPT_USERAGENT => 'Laravel-Visitor-Tracker/1.0',
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError || $httpCode !== 200 || !$response) {
                return $fallback;
            }

            $data = json_decode($response, true);

            if (!is_array($data)) {
                return $fallback;
            }

            // ipapi.co returns HTTP 200 even when rate-limited/erroring,
            // with an "error" flag in the body instead of a non-200 status.
            if (!empty($data['error'])) {
                return $fallback;
            }

            return [
                'country' => $data['country_name'] ?? null,
                'city'    => $data['city'] ?? null,
            ];

        } catch (\Exception $e) {
            return $fallback;
        }
    }
}
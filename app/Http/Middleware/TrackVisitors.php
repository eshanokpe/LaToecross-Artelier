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

        // Save visitor data
        $visitor = Visitor::create([
            'ip_address' => $ip,
            'country'    => $this->getGeo($ip, 'country'),
            'city'       => $this->getGeo($ip, 'city'),
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
     * Get Country & City from ipapi.co (free, HTTPS)
     */
    private function getGeo(string $ip, string $field): ?string
    {
        // Skip private/local IPs
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return 'Local/Testing';
        }

        try {
            $url = "https://ipapi.co/{$ip}/json/";

            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_TIMEOUT => 3,
                CURLOPT_FOLLOWLOCATION => true
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200 || !$response) {
                return null;
            }

            $data = json_decode($response, true);

            return match ($field) {
                'country' => $data['country_name'] ?? null,
                'city'    => $data['city'] ?? null,
                default   => null
            };

        } catch (\Exception $e) {
            return null;
        }
    }
}
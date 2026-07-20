<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
// use App\Notifications\NewVisitorNotification; // ❌ Comment this out or remove if not used elsewhere
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Notification; // ❌ Comment this out
use Illuminate\Support\Facades\Log;
use Wasender\Wasender; // ✅ Use Wasender instead of UltraMsg

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

        $ip = $this->resolveIp($request);
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

        // ❌ DISABLE EMAIL NOTIFICATION TO PREVENT 500 ERRORS
        // $recipients = array_map('trim', explode(',', config('mail.admin_alerts')));
        // Notification::route('mail', $recipients)
        //     ->notify(new NewVisitorNotification($visitor));

        // ✅ WhatsApp notification using Wasender
        $this->sendWhatsAppAlert($visitor);

        return $next($request);
    }

    /**
     * Send a WhatsApp alert for the new visitor via Wasender.
     */
    private function sendWhatsAppAlert(Visitor $visitor): void
    {
        try {
            // Add these to your .env file:
            // WASENDER_API_URL=https://wasenderapi.com/api/send-message
            // WASENDER_BEARER_TOKEN=9b2c787349d305f72c0fc247f37e25684bbfac4af87ce195e042a4d729dd9eb1
            // WASENDER_ADMIN_PHONE=+1234567890
            
            $apiUrl     = config('services.wasender.api_url');
            $token      = config('services.wasender.bearer_token');
            $adminPhone = config('services.wasender.admin_phone');

            if (empty($apiUrl) || empty($token) || empty($adminPhone)) {
                Log::warning('Wasender credentials missing for visitor alert.');
                return;
            }

            $whatsappMessage = "📢 *New Visitor on Latocross*\n\n"
                . "🌐 *Page:* {$visitor->page_url}\n"
                . "📍 *Location:* {$visitor->country}, {$visitor->city}\n"
                . "💻 *Device:* {$visitor->device} / {$visitor->browser}\n"
                . "🕒 *Time:* {$visitor->created_at->format('H:i')}";

            // Send Request using Laravel HTTP Client
            \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ])->post($apiUrl, [
                'to'   => $adminPhone,
                'text' => $whatsappMessage
            ]);

        } catch (\Exception $e) {
            Log::error('Visitor Alert WhatsApp Error: ' . $e->getMessage());
        }
    }

    /**
     * Resolve the real visitor IP
     */
    private function resolveIp(Request $request): string
    {
        if ($cfIp = $request->header('CF-Connecting-IP')) {
            return $cfIp;
        }
        if ($forwarded = $request->header('X-Forwarded-For')) {
            $ips = array_map('trim', explode(',', $forwarded));
            if (filter_var($ips[0], FILTER_VALIDATE_IP)) {
                return $ips[0];
            }
        }
        return $request->ip();
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
        return 'Desktop';
    }

    /**
     * Simple browser detection
     */
    private function getBrowser(string $userAgent): string
    {
        $ua = strtolower($userAgent);
        if (str_contains($ua, 'chrome')) return 'Chrome';
        if (str_contains($ua, 'firefox')) return 'Firefox';
        if (str_contains($ua, 'safari')) return 'Safari';
        if (str_contains($ua, 'edge')) return 'Edge';
        return 'Unknown';
    }

    /**
     * Get Country & City from ipapi.co
     */
    private function getGeo(string $ip): array
    {
        $fallback = ['country' => null, 'city' => null];
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return ['country' => 'Local', 'city' => 'Local'];
        }

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(3)->get("https://ipapi.co/{$ip}/json/");
            if ($response->successful()) {
                $data = $response->json();
                if (!empty($data['country_name'])) {
                    return [
                        'country' => $data['country_name'],
                        'city'    => $data['city'] ?? 'Unknown',
                    ];
                }
            }
        } catch (\Exception $e) {
            // Ignore geo errors
        }
        return $fallback;
    }
}
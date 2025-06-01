<?php

namespace App\Http\Middleware;

use App\Models\VisitorActivity;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class LogVisitorActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $browser = $this->getBrowser($userAgent);
        $device = $this->getDevice($userAgent);

        // Use a free IP geolocation API (e.g., ip-api.com)
        $location = cache()->remember("ip-location-{$ip}", 60*60, function() use ($ip) {
            $response = Http::get("http://ip-api.com/json/{$ip}");
            return $response->json();
        });

        VisitorActivity::create([
            'user_id' => Auth::id(),
            'ip_address' => $ip,
            'country' => $location['country'] ?? null,
            'region' => $location['regionName'] ?? null,
            'city' => $location['city'] ?? null,
            'browser' => $browser,
            'device' => $device,
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_agent' => $userAgent,
        ]);
        return $next($request);
    }
    private function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) return 'Internet Explorer';
        return 'Other';
    }

    private function getDevice($userAgent)
    {
        if (preg_match('/mobile/i', $userAgent)) return 'Mobile';
        if (preg_match('/tablet/i', $userAgent)) return 'Tablet';
        return 'Desktop';
    }
}

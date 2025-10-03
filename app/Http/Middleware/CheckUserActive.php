<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Check if the user account is deactivated
            if (!$user->is_active) {
                Auth::logout();
                
                // For API requests, return JSON response
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Your account has been deactivated. Please contact support or admin for assistance.',
                        'error' => 'account_deactivated'
                    ], 403);
                }
                
                // For web requests, redirect to login with error message
                return redirect()->route('login')->withErrors([
                    'email' => 'Your account has been deactivated. Please contact support or admin for assistance.'
                ]);
            }
        }

        return $next($request);
    }
}
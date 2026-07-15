<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Flight\Models\Partner;
use Modules\Flight\Models\ReferralClick;
use Illuminate\Support\Str;

class TrackReferral
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('ref')) {
            $refCode = $request->input('ref');
            $partner = Partner::where('referral_code', $refCode)->where('status', 'active')->first();

            if ($partner) {
                // Generate a session token if none exists
                $sessionToken = $request->cookie('referral_token') ?: Str::uuid()->toString();

                // Log the click
                ReferralClick::create([
                    'partner_id' => $partner->id,
                    'landing_page' => $request->fullUrl(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'session_token' => $sessionToken
                ]);

                // Set cookies for 30 days (43200 minutes)
                $response = $next($request);
                return $response->withCookie(cookie('partner_id', $partner->id, 43200))
                                ->withCookie(cookie('referral_token', $sessionToken, 43200));
            }
        }

        return $next($request);
    }
}

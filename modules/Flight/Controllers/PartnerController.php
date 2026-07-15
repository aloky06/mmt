<?php

namespace Modules\Flight\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Flight\Models\Partner;
use Modules\Flight\Models\Commission;
use Modules\Flight\Models\PayoutRequest;
use Modules\Flight\Models\ReferralClick;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.login');
        }

        $partner = Partner::where('user_id', $user->id)->first();
        if (!$partner) {
            return view('Flight::frontend.partner.register');
        }

        $totalClicks = ReferralClick::where('partner_id', $partner->id)->count();
        $totalBookings = Commission::where('partner_id', $partner->id)->count();
        $pendingCommission = Commission::where('partner_id', $partner->id)->where('status', 'pending')->sum('commission_amount');
        $confirmedCommission = Commission::where('partner_id', $partner->id)->where('status', 'confirmed')->sum('commission_amount');
        
        $payouts = PayoutRequest::where('partner_id', $partner->id)->orderBy('id', 'desc')->get();

        return view('Flight::frontend.partner.dashboard', compact(
            'partner', 'totalClicks', 'totalBookings', 'pendingCommission', 'confirmedCommission', 'payouts'
        ));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:partners,email',
            'pan_number' => 'nullable'
        ]);

        $partner = Partner::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'referral_code' => Str::upper(Str::random(8)),
            'pan_number' => $request->pan_number,
            'status' => 'active'
        ]);

        return redirect()->route('flight.partner.dashboard')->with('success', 'Partner account created successfully!');
    }

    public function requestPayout(Request $request)
    {
        $partner = Partner::where('user_id', Auth::id())->first();
        if (!$partner) return redirect()->back()->with('error', 'Partner not found');

        $amount = $request->input('amount');
        $confirmedCommission = Commission::where('partner_id', $partner->id)->where('status', 'confirmed')->sum('commission_amount');

        if ($amount < 500) {
            return redirect()->back()->with('error', 'Minimum payout request is ₹500');
        }

        if ($amount > $confirmedCommission) {
            return redirect()->back()->with('error', 'Insufficient confirmed commission balance');
        }

        // Deduct by changing confirmed to processing/paid or we can just keep a tally
        // A simple way: create payout request, admin will handle deduct
        PayoutRequest::create([
            'partner_id' => $partner->id,
            'amount' => $amount,
            'status' => 'requested'
        ]);

        return redirect()->back()->with('success', 'Payout requested successfully!');
    }
}

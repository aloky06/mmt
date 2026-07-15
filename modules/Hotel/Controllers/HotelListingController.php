<?php
namespace Modules\Hotel\Controllers;

use Modules\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Hotel\Models\Hotel;
use Modules\Location\Models\Location;

class HotelListingController extends FrontendController
{
    public function landing(Request $request)
    {
        $data = [
            'page_title' => __('List Your Hotel Property'),
            'seo_type'   => 'page',
        ];
        return view('Hotel::frontend.listing.landing', $data);
    }

    public function register(Request $request)
    {
        $data = [
            'page_title'      => __('Register Your Property'),
            'hotel_locations' => Location::where('status', 'publish')->get()->toTree(),
        ];
        return view('Hotel::frontend.listing.wizard', $data);
    }

    public function submit(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'title'   => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        $row = new Hotel();
        $row->status       = 'pending';
        $row->create_user  = Auth::id();

        // Auto-grant hotel vendor permissions to this user
        $user = Auth::user();
        if (!$user->hasRole('vendor')) {
            $user->assignRole('vendor');
        }
        foreach (['hotel_view', 'hotel_create', 'hotel_update', 'hotel_delete'] as $perm) {
            if (!$user->hasPermissionTo($perm)) {
                $user->givePermissionTo($perm);
            }
        }

        $dataKeys = [
            'title', 'content', 'address', 'map_lat', 'map_lng',
            'star_rate', 'check_in_time', 'check_out_time',
            'price', 'allow_full_day',
        ];

        foreach ($dataKeys as $key) {
            if ($request->has($key)) {
                $row->$key = $request->input($key);
            }
        }

        // Store wizard data in policy JSON field
        $wizardData = [
            'property_type'   => $request->input('property_type', 'hotel'),
            'star_rating'     => $request->input('star_rate', ''),
            'facilities'      => $request->input('facilities', []),
            'languages'       => $request->input('languages', []),
            'breakfast'       => $request->input('breakfast', 'no'),
            'parking'         => $request->input('parking', 'no'),
            'allow_children'  => $request->input('allow_children', 'yes'),
            'allow_pets'      => $request->input('allow_pets', 'no'),
            'channel_manager' => $request->input('channel_manager', 'no'),
            'gst_registered'  => $request->input('gst_registered', 'no'),
            'gstin'           => $request->input('gstin', ''),
            'pan'             => $request->input('pan', ''),
            'invoice_name'    => $request->input('invoice_name', ''),
            'owner_type'      => $request->input('owner_type', 'individual'),
            'owner_name'      => $request->input('owner_name', ''),
            'room_details'    => $request->input('rooms', []),
        ];
        $row->policy = $wizardData;

        if ($row->save()) {
            return redirect()->route('hotel.list.success', ['hotel_id' => $row->id]);
        }

        return back()->withErrors(['error' => __('Failed to save hotel. Please try again.')]);
    }

    public function success(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $hotel = null;
        if ($hotel_id && Auth::check()) {
            $hotel = Hotel::where('id', $hotel_id)->where('create_user', Auth::id())->first();
        }

        $data = [
            'page_title' => __('Property Submitted Successfully'),
            'hotel'      => $hotel,
        ];
        return view('Hotel::frontend.listing.success', $data);
    }
}

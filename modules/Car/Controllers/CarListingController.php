<?php
namespace Modules\Car\Controllers;

use Modules\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Car\Models\Car;
use Modules\Location\Models\Location;

class CarListingController extends FrontendController
{
    public function landing(Request $request)
    {
        $data = [
            'page_title' => __('Attach Your Taxi'),
            'seo_type'   => 'page',
        ];
        return view('Car::frontend.listing.landing', $data);
    }

    public function register(Request $request)
    {
        $data = [
            'page_title'      => __('Attach Your Taxi'),
            'car_locations'   => Location::where('status', 'publish')->get()->toTree(),
        ];
        return view('Car::frontend.listing.wizard', $data);
    }

    public function submit(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'title'   => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        $row = new Car();
        $row->status       = 'pending';
        $row->create_user  = Auth::id();

        // Auto-grant car vendor permissions to this user
        $user = Auth::user();
        if (!$user->hasRole('vendor')) {
            $user->assignRole('vendor');
        }
        
        foreach (['car_view', 'car_create', 'car_update', 'car_delete'] as $perm) {
            if (!$user->hasPermissionTo($perm)) {
                $user->givePermissionTo($perm);
            }
        }

        $dataKeys = [
            'title', 'content', 'address', 'map_lat', 'map_lng',
            'price', 'number', 'passenger', 'gear', 'baggage', 'door'
        ];

        foreach ($dataKeys as $key) {
            if ($request->has($key)) {
                $row->$key = $request->input($key);
            }
        }

        if ($row->save()) {
            return redirect()->route('car.list.success', ['car_id' => $row->id]);
        }

        return back()->withErrors(['error' => __('Failed to save taxi. Please try again.')]);
    }

    public function success(Request $request)
    {
        $car_id = $request->query('car_id');
        $car = null;
        if ($car_id && Auth::check()) {
            $car = Car::where('id', $car_id)->where('create_user', Auth::id())->first();
        }

        $data = [
            'page_title' => __('Taxi Submitted Successfully'),
            'car'        => $car,
        ];
        return view('Car::frontend.listing.success', $data);
    }
}

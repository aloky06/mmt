<?php
namespace Modules\Vendor\Controllers;

use App\Helpers\ReCaptchaEngine;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Matrix\Exception;
use Modules\FrontendController;
use Modules\User\Events\NewVendorRegistered;
use Modules\User\Events\SendMailUserRegistered;
use Modules\Vendor\Models\VendorRequest;
use Modules\Booking\Models\Booking;


class VendorController extends FrontendController
{
    protected $bookingClass;
    public function __construct()
    {
        $this->bookingClass = Booking::class;
        parent::__construct();
    }
    public function register(Request $request)
    {
        $rules = [
            'first_name' => [
                'required',
                'string',
                'max:255'
            ],
            'last_name'  => [
                'required',
                'string',
                'max:255'
            ],
            'email'      => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],
            'password'   => [
                'required',
                'string'
            ],
            'phone'      => ['required', 'string'],
            'city_location'  => ['required', 'string'],
            'no_of_cars'     => ['required', 'integer', 'min:1'],
            'vehicle_rc'     => ['required', 'string'],
            'driver_license' => ['required', 'string'],
            'aadhar_number'  => ['required', 'string'],
            'vehicle_rc_file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:5120'],
            'driver_license_file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:5120'],
            'aadhar_file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:5120'],
            'term'       => ['required'],
        ];
        $messages = [
            'email.required'      => __('Email is required field'),
            'email.email'         => __('Email invalidate'),
            'password.required'   => __('Password is required field'),
            'first_name.required' => __('The first name is required field'),
            'last_name.required'  => __('The last name is required field'),
            'phone.required'      => __('Phone number is required'),
            'city_location.required'  => __('City is required'),
            'no_of_cars.required'     => __('Number of cars is required'),
            'vehicle_rc.required'     => __('Vehicle RC is required'),
            'driver_license.required' => __('Driver License is required'),
            'aadhar_number.required'  => __('Aadhar Number is required'),
            'term.required'       => __('The terms and conditions field is required'),
        ];
        if (ReCaptchaEngine::isEnable() and setting_item("user_enable_register_recaptcha")) {
            $messages['g-recaptcha-response.required'] = __('Please verify the captcha');
            $rules['g-recaptcha-response'] = ['required'];
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors()
            ], 200);
        } else {
            if (ReCaptchaEngine::isEnable() and setting_item("user_enable_register_recaptcha")) {
                $codeCapcha = $request->input('g-recaptcha-response');
                if (!ReCaptchaEngine::verify($codeCapcha)) {
                    $errors = new MessageBag(['message_error' => __('Please verify the captcha')]);
                    return response()->json([
                        'error'    => true,
                        'messages' => $errors
                    ], 200);
                }
            }
            $user = new \App\User();

            $user = $user->fill([
                'first_name'=>$request->input('first_name'),
                'last_name'=>$request->input('last_name'),
                'email'=>$request->input('email'),
                'password'=>Hash::make($request->input('password')),
                'business_name'=>$request->input('business_name'),
                'phone'=>$request->input('phone'),
            ]);
            $user->status = 'publish';

            $user->save();
            
            // Save Driver Meta Data
            $user->addMeta('driver_city_location', $request->input('city_location'));
            $user->addMeta('driver_no_of_cars', $request->input('no_of_cars'));
            $user->addMeta('driver_vehicle_rc', $request->input('vehicle_rc'));
            $user->addMeta('driver_license', $request->input('driver_license'));
            $user->addMeta('driver_aadhar_number', $request->input('aadhar_number'));

            // Handle File Uploads securely
            if ($request->hasFile('vehicle_rc_file')) {
                $path = $request->file('vehicle_rc_file')->store('vendor_documents', 'public');
                $user->addMeta('vehicle_rc_file_path', $path);
            }
            if ($request->hasFile('driver_license_file')) {
                $path = $request->file('driver_license_file')->store('vendor_documents', 'public');
                $user->addMeta('driver_license_file_path', $path);
            }
            if ($request->hasFile('aadhar_file')) {
                $path = $request->file('aadhar_file')->store('vendor_documents', 'public');
                $user->addMeta('aadhar_file_path', $path);
            }

            if (empty($user)) {
                return $this->sendError(__("Can not register"));
            }

            // check vendor auto approved (Forced to false as per Savaari manual approval flow)
            $vendorAutoApproved = false; 
            $dataVendor['role_request'] = setting_item('vendor_role');
            if ($vendorAutoApproved) {
                if ($dataVendor['role_request']) {
                    $user->assignRole($dataVendor['role_request']);
                }
                $dataVendor['status'] = 'approved';
                $dataVendor['approved_time'] = now();
            } else {
                $dataVendor['status'] = 'pending';
                $user->assignRole('customer');
            }
            $vendorRequestData = $user->vendorRequest()->save(new VendorRequest($dataVendor));
            Auth::loginUsingId($user->id);
            try {
                event(new NewVendorRegistered($user, $vendorRequestData));
            } catch (Exception $exception) {
                Log::warning("NewVendorRegistered: " . $exception->getMessage());
            }
            if ($vendorAutoApproved) {
                return $this->sendSuccess([
                    'redirect' => route('vendor.dashboard'),
                ]);
            } else {
                return $this->sendSuccess([
                    'redirect' => route('user.profile.index'),
                ], __("Application submitted successfully. Please wait for admin approval."));
            }
        }
    }

    public function bookingReport(Request $request)
    {
        $data = [
            'bookings'    => $this->bookingClass::getBookingHistory($request->input('status'), false, Auth::id()),
            'statues'     => config('booking.statuses'),
            'breadcrumbs' => [
                [
                    'name'  => __('Booking Report'),
                    'class' => 'active'
                ],
            ],
            'page_title'  => __("Booking Report"),
        ];
        return view('Vendor::frontend.bookingReport.index', $data);
    }
}

@section('head')
    <link href="{{ asset('module/vendor/css/vendor-register.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <style>
        .driver-onboarding-wrapper { background: #f8f9fa; }
        .driver-form-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-top: 4px solid #ff6d38;
        }
        .driver-form-container h1 { font-size: 28px; font-weight: 700; color: #000; margin-bottom: 5px; }
        .driver-form-container .sub-heading { font-size: 15px; color: #666; margin-bottom: 25px; }
        .driver-form-container .form-control { border-radius: 4px; border: 1px solid #ddd; padding: 10px 15px; }
        .driver-form-container .btn-primary { background: #ff6d38; border-color: #ff6d38; font-weight: 600; padding: 12px; font-size: 16px; }
        .driver-form-container .btn-primary:hover { background: #e65a28; border-color: #e65a28; }
        .driver-form-container .btn-secondary { background: #fff; color: #333; border: 1px solid #ccc; font-weight: 600; padding: 12px; font-size: 16px; }
        .section-title { font-size: 14px; font-weight: 700; text-transform: uppercase; color: #999; margin-top: 10px; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        
        .step-indicator { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .step-dot { width: 48%; text-align: center; padding: 8px; border-bottom: 3px solid #eee; color: #999; font-weight: 600; font-size: 14px; }
        .step-dot.active { border-color: #ff6d38; color: #ff6d38; }
        
        .custom-file-upload { display: inline-block; padding: 10px 15px; cursor: pointer; border: 1px dashed #ccc; border-radius: 4px; width: 100%; text-align: center; background: #fafafa; color: #666; transition: 0.3s; }
        .custom-file-upload:hover { background: #f0f0f0; border-color: #999; }
        .custom-file-upload input[type="file"] { display: none; }
        .file-name-display { display: block; font-size: 12px; color: #22c55e; margin-top: 5px; font-weight: bold; }
    </style>
@endsection
<div class="driver-onboarding-wrapper py-5">
    <div class="container">
        <div class="bravo-vendor-form-register @if(!empty($layout)) {{ $layout }} @endif">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-7 mb-5 mb-lg-0">
                    <div class="driver-form-container">
                        <div class="text-center mb-4">
                            <h1>Attach Your Taxi</h1>
                            <p class="sub-heading">Partner with us and earn more. Drive when you want.</p>
                        </div>
                        
                        <div class="step-indicator">
                            <div class="step-dot active" id="indicator-step-1">1. Basic Details</div>
                            <div class="step-dot" id="indicator-step-2">2. Documents</div>
                        </div>

                        <form class="form bravo-form-register-vendor" method="post" action="{{route('vendor.register')}}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- STEP 1 -->
                            <div id="form-step-1">
                                <div class="section-title">Personal Details</div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <input type="text" class="form-control" name="first_name" autocomplete="off" placeholder="{{__("First Name")}}">
                                        <span class="invalid-feedback error error-first_name"></span>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="text" class="form-control" name="last_name" autocomplete="off" placeholder="{{__("Last Name")}}">
                                        <span class="invalid-feedback error error-last_name"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <input type="text" class="form-control" name="phone" autocomplete="off" placeholder="{{__("Mobile Number")}}">
                                        <span class="invalid-feedback error error-phone"></span>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="email" class="form-control" name="email" autocomplete="off" placeholder="{{__("Email Address")}}">
                                        <span class="invalid-feedback error error-email"></span>
                                    </div>
                                </div>
                                
                                <div class="section-title mt-4">Location & Fleet</div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="city_location" name="city_location" autocomplete="off" placeholder="Home City (e.g., Varanasi)">
                                    <span class="invalid-feedback error error-city_location"></span>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="no_of_cars" autocomplete="off" placeholder="Number of Cars you own" min="1" value="1">
                                    <span class="invalid-feedback error error-no_of_cars"></span>
                                </div>
                                
                                <button type="button" class="btn btn-primary btn-block w-100 mt-4" onclick="goToStep(2)">Next Step <i class="fa fa-arrow-right"></i></button>
                            </div>
                            
                            <!-- STEP 2 -->
                            <div id="form-step-2" style="display: none;">
                                <div class="section-title">Vehicle & Documents</div>
                                
                                <div class="form-group">
                                    <input type="text" class="form-control" name="vehicle_rc" autocomplete="off" placeholder="Vehicle RC Number (e.g., UP65AB1234)">
                                    <span class="invalid-feedback error error-vehicle_rc"></span>
                                </div>
                                
                                <div class="form-group">
                                    <label class="custom-file-upload">
                                        <input type="file" name="vehicle_rc_file" accept="image/*,.pdf" onchange="showFileName(this, 'rc-name')"/>
                                        <i class="fa fa-upload"></i> Upload RC Document
                                    </label>
                                    <span id="rc-name" class="file-name-display"></span>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="driver_license" autocomplete="off" placeholder="Driver's License No.">
                                    <span class="invalid-feedback error error-driver_license"></span>
                                </div>
                                
                                <div class="form-group">
                                    <label class="custom-file-upload">
                                        <input type="file" name="driver_license_file" accept="image/*,.pdf" onchange="showFileName(this, 'dl-name')"/>
                                        <i class="fa fa-upload"></i> Upload Driving License
                                    </label>
                                    <span id="dl-name" class="file-name-display"></span>
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" class="form-control" name="aadhar_number" autocomplete="off" placeholder="Aadhar Number">
                                    <span class="invalid-feedback error error-aadhar_number"></span>
                                </div>

                                <div class="form-group">
                                    <label class="custom-file-upload">
                                        <input type="file" name="aadhar_file" accept="image/*,.pdf" onchange="showFileName(this, 'aadhar-name')"/>
                                        <i class="fa fa-upload"></i> Upload Aadhar Card
                                    </label>
                                    <span id="aadhar-name" class="file-name-display"></span>
                                </div>
                                
                                <div class="section-title mt-4">Security</div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" autocomplete="off" placeholder="{{__("Create Password")}}">
                                    <span class="invalid-feedback error error-password"></span>
                                </div>
                                
                                <!-- Hidden Business Name for backwards compatibility with VendorController -->
                                <input type="hidden" name="business_name" value="Independent Driver">

                                <div class="form-group mt-4">
                                    <label for="term">
                                        <input id="term" type="checkbox" name="term" class="mr5">
                                        {!! __("I accept the <a href=':link' target='_blank'>Terms & Conditions</a>",['link'=>get_page_url(setting_item('vendor_term_conditions'))]) !!}
                                        <span class="checkmark fcheckbox"></span>
                                    </label>
                                    <div><span class="invalid-feedback error error-term"></span></div>
                                </div>

                                @if(setting_item("user_enable_register_recaptcha"))
                                    <div class="form-group">
                                        {{recaptcha_field($captcha_action ?? 'register_vendor')}}
                                        <div><span class="invalid-feedback error error-g-recaptcha-response"></span></div>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button" class="btn btn-secondary" style="width: 30%;" onclick="goToStep(1)"><i class="fa fa-arrow-left"></i> Back</button>
                                    <button type="submit" class="btn btn-primary form-submit" style="width: 65%;">
                                        Submit Application
                                        <span class="spinner-grow spinner-grow-sm icon-loading" role="status" aria-hidden="true" style="display: none"></span>
                                    </button>
                                </div>
                                <div class="message-error mt-2"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('footer')
    <!-- Google Maps API for Places Autocomplete -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6Z7gwQbJUhzSkEve9U_FDPzXxeFimlEQ&libraries=places"></script>
    
    <script>
        // Multi-step logic
        function goToStep(step) {
            if(step === 1) {
                document.getElementById('form-step-1').style.display = 'block';
                document.getElementById('form-step-2').style.display = 'none';
                document.getElementById('indicator-step-1').classList.add('active');
                document.getElementById('indicator-step-2').classList.remove('active');
            } else if(step === 2) {
                document.getElementById('form-step-1').style.display = 'none';
                document.getElementById('form-step-2').style.display = 'block';
                document.getElementById('indicator-step-1').classList.remove('active');
                document.getElementById('indicator-step-2').classList.add('active');
            }
        }
        
        // Show file name on upload
        function showFileName(input, displayId) {
            if (input.files && input.files[0]) {
                document.getElementById(displayId).innerText = input.files[0].name;
            }
        }

        // Initialize Google Maps Places Autocomplete for City Location
        function initAutocomplete() {
            var input = document.getElementById('city_location');
            var autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['(cities)'],
                componentRestrictions: { 'country': 'in' } // Restrict to India as requested
            });
            
            // Prevent form submit on Enter key in autocomplete
            input.addEventListener('keydown', function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                }
            });
        }
        
        // Run init on load
        window.addEventListener('load', initAutocomplete);
    </script>
    <script type="text/javascript" src="{{ asset("/module/vendor/js/vendor-register.js?_ver=".config('app.version')) }}"></script>
@endsection

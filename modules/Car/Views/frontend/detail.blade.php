@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/car/css/car.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>
@endsection
@section('content')
    <div class="bravo_detail_car goibibo-review-booking-page" style="background: #f4f5f5; padding-top: 20px; padding-bottom: 50px;">
        <div class="bravo_content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <h1 style="font-size: 28px; font-weight: 700; color: #000; margin: 0;">Review booking</h1>
                    </div>
                </div>
                <div class="row">
                    <!-- The entire booking form and details are now handled inside form-book to keep Vue scope active -->
                    <div class="col-md-12">
                        @include('Car::frontend.layouts.details.form-book')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        var bravo_booking_data = {!! json_encode($booking_data) !!}
        // Override number if distance is passed for outstation
        @if(Request::query('distance') && Request::query('trip_type') != 'hourly')
            bravo_booking_data.number = {{ (int)Request::query('distance') }};
            bravo_booking_data.package_type = 'per_km';
        @elseif(Request::query('hourly_package') == '4hr')
            bravo_booking_data.number = 1;
            bravo_booking_data.package_type = '4hr';
        @elseif(Request::query('hourly_package') == '8hr')
            bravo_booking_data.number = 1;
            bravo_booking_data.package_type = '8hr';
        @endif
        
        @if(Request::query('pickup_date'))
            @php 
                $date_obj = \DateTime::createFromFormat('d/m/Y h:i a', Request::query('pickup_date').' '.Request::query('pickup_time'));
                if(!$date_obj) $date_obj = \DateTime::createFromFormat('Y-m-d', Request::query('pickup_date')); // Fallback
                if($date_obj) {
                    $start_date_str = $date_obj->format('Y-m-d H:i:s');
                    $end_date_str = $date_obj->modify('+1 day')->format('Y-m-d H:i:s'); // Just default to next day for end
                }
            @endphp
            @if(isset($start_date_str))
                bravo_booking_data.start_date = '{{ $start_date_str }}';
                bravo_booking_data.end_date = '{{ $end_date_str }}';
                bravo_booking_data.start_date_html = '{{ date("d/m/Y", strtotime($start_date_str)) }}';
            @endif
        @endif
        
        bravo_booking_data.price_per_km = {{ $row->price_per_km ?? 0 }};
        bravo_booking_data.price_4hr = {{ $row->price_4hr ?? 0 }};
        bravo_booking_data.price_8hr = {{ $row->price_8hr ?? 0 }};

        var bravo_booking_i18n = {
			no_date_select:'{{__('Please select Start and End date')}}',
            no_guest_select:'{{__('Please select at least one number')}}',
            load_dates_url:'{{route('car.vendor.availability.loadDates')}}',
            name_required:'{{ __("Name is Required") }}',
            email_required:'{{ __("Email is Required") }}',
        };
    </script>
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/fotorama/fotorama.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/sticky/jquery.sticky.js") }}"></script>
    <script type="text/javascript" src="{{ asset('module/car/js/single-car.js?_ver='.config('app.version')) }}"></script>
@endsection

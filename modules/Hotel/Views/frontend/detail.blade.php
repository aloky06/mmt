@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/hotel/css/hotel.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- TAILWIND & ALPINE INJECTION -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        corePlugins: { preflight: false },
        theme: {
          extend: {
            colors: {
              brand: {
                DEFAULT: '#e6521f',
                dark: '#c94518',
                light: '#ffeadf'
              }
            }
          }
        }
      }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <style>
        .bravo_detail_hotel { font-family: 'Inter', sans-serif; background: #f7f9fc; }
    </style>
@endsection
@section('content')
    <div class="bravo_detail_hotel pb-12">
        @include('Hotel::frontend.layouts.details.hotel-banner')
        
        <div class="bravo_content mt-6">
            <div class="container mx-auto px-4" style="max-width: 1200px;">
                <div class="flex flex-col gap-8">
                    <!-- Main Content (Full Width) -->
                    <div class="w-full flex flex-col gap-6">
                        @php $review_score = $row->review_data @endphp
                        @include('Hotel::frontend.layouts.details.hotel-detail')
                        @include('Hotel::frontend.layouts.details.hotel-review')
                        
                        @include('Tour::frontend.layouts.details.vendor')
                        @include('Hotel::frontend.layouts.details.hotel-related-list')
                    </div>
                </div>
            </div>
        </div>
        
        @include('Hotel::frontend.layouts.details.hotel-form-enquiry-mobile')
    </div>
@endsection

@section('footer')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        jQuery(function ($) {
            @if($row->map_lat && $row->map_lng)
            new BravoMapEngine('map_content', {
                disableScripts: true,
                fitBounds: true,
                center: [{{$row->map_lat}}, {{$row->map_lng}}],
                zoom:{{$row->map_zoom ?? "8"}},
                ready: function (engineMap) {
                    engineMap.addMarker([{{$row->map_lat}}, {{$row->map_lng}}], {
                        icon_options: {
                            iconUrl:"{{get_file_url(setting_item("hotel_icon_marker_map"),'full') ?? url('images/icons/png/pin.png') }}"
                        }
                    });
                }
            });
            @endif
        })
    </script>
    <script>
        var bravo_booking_data = {!! json_encode($booking_data) !!}
        var bravo_booking_i18n = {
			no_date_select:'{{__('Please select Start and End date')}}',
            no_guest_select:'{{__('Please select at least one guest')}}',
            load_dates_url:'{{route('space.vendor.availability.loadDates')}}',
            name_required:'{{ __("Name is Required") }}',
            email_required:'{{ __("Email is Required") }}',
        };
    </script>
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/fotorama/fotorama.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/sticky/jquery.sticky.js") }}"></script>
    <script type="text/javascript" src="{{ asset('module/hotel/js/single-hotel.js?_ver='.config('app.version')) }}"></script>
@endsection

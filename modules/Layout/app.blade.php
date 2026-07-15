<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{$html_class ?? ''}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php event(new \Modules\Layout\Events\LayoutBeginHead()); @endphp
    @php
        $favicon = setting_item('site_favicon');
    @endphp
    @if($favicon)
        @php
            $file = (new \Modules\Media\Models\MediaFile())->findById($favicon);
        @endphp
        @if(!empty($file))
            <link rel="icon" type="{{$file['file_type']}}" href="{{asset('uploads/'.$file['file_path'])}}" />
        @else:
            <link rel="icon" type="image/png" href="{{url('images/favicon.png')}}" />
        @endif
    @endif

    @include('Layout::parts.seo-meta')
    <link href="{{ asset('libs/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/frontend/css/notification.css') }}" rel="newest stylesheet">
    <link href="{{ asset('dist/frontend/css/app.css?_ver='.config('app.version')) }}" rel="stylesheet">
    
    <!-- Tailwind & Bootstrap Icons -->
    <link href="{{ asset('dist/frontend/css/tailwind.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" type="text/css" href="{{ asset("libs/daterange/daterangepicker.css") }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset("dist/frontend/css/custom-offer.css?_ver=".config('app.version')) }}" >
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel='stylesheet' id='google-font-css-css'  href='https://fonts.googleapis.com/css?family=Poppins%3A300%2C400%2C500%2C600' type='text/css' media='all' />
    {!! \App\Helpers\Assets::css() !!}
    {!! \App\Helpers\Assets::js() !!}
    <script>
        var bookingCore = {
            url:'{{url( app_get_locale() )}}',
            url_root:'{{ url('') }}',
            booking_decimals:{{(int)get_current_currency('currency_no_decimal',2)}},
            thousand_separator:'{{get_current_currency('currency_thousand')}}',
            decimal_separator:'{{get_current_currency('currency_decimal')}}',
            currency_position:'{{get_current_currency('currency_format')}}',
            currency_symbol:'{{currency_symbol()}}',
			currency_rate:'{{get_current_currency('rate',1)}}',
            date_format:'{{get_moment_date_format()}}',
            map_provider:'{{setting_item('map_provider')}}',
            map_gmap_key:'{{setting_item('map_gmap_key')}}',
            map_options:{
                map_lat_default:'{{setting_item('map_lat_default')}}',
                map_lng_default:'{{setting_item('map_lng_default')}}',
                map_clustering:'{{setting_item('map_clustering')}}',
                map_fit_bounds:'{{setting_item('map_fit_bounds')}}',
            },
            routes:{
                login:'{{route('auth.login')}}',
                register:'{{route('auth.register')}}',
                checkout:'{{is_api() ? route('api.booking.doCheckout') : route('booking.doCheckout')}}'
            },
            module:{
                hotel:'{{route('hotel.search')}}',
                car:'{{route('car.search')}}',
                tour:'{{route('tour.search')}}',
                space:'{{route('space.search')}}',
                flight:"{{route('flight.search')}}"
            },
            currentUser: {{(int)Auth::id()}},
            isAdmin : {{is_admin() ? 1 : 0}},
            rtl: {{ setting_item_with_lang('enable_rtl') ? "1" : "0" }},
            markAsRead:'{{route('core.notification.markAsRead')}}',
            markAllAsRead:'{{route('core.notification.markAllAsRead')}}',
            loadNotify : '{{route('core.notification.loadNotify')}}',
            pusher_api_key : '{{setting_item("pusher_api_key")}}',
            pusher_cluster : '{{setting_item("pusher_cluster")}}',
        };
        var i18n = {
            warning:"{{__("Warning")}}",
            success:"{{__("Success")}}",
        };
        var daterangepickerLocale = {
            "applyLabel": "{{__('Apply')}}",
            "cancelLabel": "{{__('Cancel')}}",
            "fromLabel": "{{__('From')}}",
            "toLabel": "{{__('To')}}",
            "customRangeLabel": "{{__('Custom')}}",
            "weekLabel": "{{__('W')}}",
            "first_day_of_week": {{ setting_item("site_first_day_of_the_weekin_calendar","1") }},
            "daysOfWeek": [
                "{{__('Su')}}",
                "{{__('Mo')}}",
                "{{__('Tu')}}",
                "{{__('We')}}",
                "{{__('Th')}}",
                "{{__('Fr')}}",
                "{{__('Sa')}}"
            ],
            "monthNames": [
                "{{__('January')}}",
                "{{__('February')}}",
                "{{__('March')}}",
                "{{__('April')}}",
                "{{__('May')}}",
                "{{__('June')}}",
                "{{__('July')}}",
                "{{__('August')}}",
                "{{__('September')}}",
                "{{__('October')}}",
                "{{__('November')}}",
                "{{__('December')}}"
            ],
        };
    </script>
    <!-- Styles -->
    @yield('head')
    
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/@googlemaps/extended-component-library/0.6.11/index.min.js"></script>
    <gmpx-api-loader key="AIzaSyC6Z7gwQbJUhzSkEve9U_FDPzXxeFimlEQ" solution-channel="GMP_GE_mapsandplacesautocomplete_v2"></gmpx-api-loader>
    {{--Custom Style--}}
    <link href="{{ route('core.style.customCss') }}" rel="stylesheet">
    <link href="{{ asset('libs/carousel-2/owl.carousel.css') }}" rel="stylesheet">
    @if(setting_item_with_lang('enable_rtl'))
        <link href="{{ asset('dist/frontend/css/rtl.css') }}" rel="stylesheet">
    @endif
    @if(!is_demo_mode())
        {!! setting_item('head_scripts') !!}
        {!! setting_item_with_lang_raw('head_scripts') !!}
    @endif

    @php event(new \Modules\Layout\Events\LayoutEndHead()); @endphp

    <style id="premium-design-system">
        /* --- Premium App-Like Global Design System --- */
        
        /* 1. Global Typography & Background */
        body.frontend-page {
            font-family: 'Poppins', sans-serif !important;
            background-color: #f7f9fa !important; /* Sleek off-white for depth */
            color: #333;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif !important;
            font-weight: 600;
            letter-spacing: -0.02em;
            line-height: 1.4 !important; /* Fix overlapping text */
        }

        
        /* 2. Breathable Section Spacing (Reduced to fix excessive white space) */
        .bravo-list-item, .bravo-offer, .bravo-how-it-work, .bravo-testimonial, .bravo-list-tour {
            padding: 40px 0 !important;
        }
        
        /* 3. Modern Titles */
        .title, .sec-title {
            font-size: 32px !important;
            font-weight: 700 !important;
            margin-bottom: 40px !important;
            color: #1a2b49 !important;
        }
        /* Destination block overrides (make text white over images) */
        .destination-item .title,
        .bravo-location .item-title,
        .bravo-location .title-location {
            color: #ffffff !important;
            font-size: 24px !important;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }
        /* Tour names font size smaller */
        .item-loop .item-title, 
        .item-loop .item-title a {
            font-size: 16px !important;
            line-height: 1.4 !important;
            margin-bottom: 5px;
            display: inline-block;
        }
        .desc-text, .sub-title {
            font-size: 16px !important;
            color: #667 !important;
        }
        
        /* 4. Floating Modern Cards (Hotels, Tours, Cars, etc.) */
        .item-loop {
            border-radius: 16px !important;
            border: 1px solid rgba(0,0,0,0.03) !important; /* Subtle border instead of forced white background */
            box-shadow: 0 4px 15px rgba(0,0,0,0.04) !important;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
            margin-bottom: 30px;
            background-color: #fff; /* Removed !important so Events can use their dark theme */
        }
        .item-loop:hover {
            transform: translateY(-8px) !important;
            box-shadow: 0 15px 35px rgba(0,0,0,0.12) !important;
        }
        .item-loop .thumb-image {
            border-radius: 16px 16px 0 0 !important;
            overflow: hidden;
            position: relative;
        }
        .item-loop .thumb-image img {
            width: 100%;
            object-fit: cover;
        }

        
        /* 5. Premium Buttons */
        .btn, .btn-primary {
            border-radius: 50px !important; /* Pill shape */
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #008cff 0%, #0066cc 100%) !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(0, 140, 255, 0.3) !important;
            color: #fff !important;
        }
        .btn-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(0, 140, 255, 0.5) !important;
            background: linear-gradient(135deg, #007ae6 0%, #005bb5 100%) !important;
            color: #fff !important;
        }
        
        /* 6. Testimonial / Offer Cards */
        .bravo-testimonial .item {
            border-radius: 16px !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
            transition: all 0.3s ease !important;
            background: #fff;
            border: none !important;
        }
        .bravo-offer .item {
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
            transition: all 0.4s ease !important;
            background-size: cover !important;
            background-position: center !important;
            border: none !important;
            position: relative;
            overflow: hidden;
            padding: 40px 30px !important;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #2a3b5c; /* Gentle fallback so text is visible, but not an overpowering gradient */
        }
        /* Add background image on hover */
        .bravo-offer .item:hover {
            transform: translateY(-8px) !important;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important;
            background-image: linear-gradient(135deg, rgba(26,43,73,0.85) 0%, rgba(42,67,116,0.85) 100%), url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') !important;
        }
        .bravo-offer .item .item-title {
            font-size: 24px !important;
            font-weight: 700 !important;
            margin-bottom: 10px !important;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .bravo-offer .item .item-sub-title {
            font-size: 16px !important;
            opacity: 0.9;
            margin-bottom: 20px !important;
        }
        .bravo-offer .item .btn {
            margin-top: auto;
        }
        .bravo-offer .item:hover, .bravo-testimonial .item:hover {
            transform: translateY(-8px) !important;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        }
        
        /* 7. Footer Upgrade */
        .bravo_footer {
            background-color: #1a2b49 !important;
            color: #a0aec0 !important;
            padding-top: 70px !important;
            border-top: none !important;
        }
        .bravo_footer .title {
            color: #ffffff !important;
            font-size: 18px !important;
            margin-bottom: 25px !important;
        }
        .bravo_footer a {
            color: #a0aec0 !important;
            transition: color 0.2s ease;
        }
        .bravo_footer a:hover {
            color: #ffffff !important;
            text-decoration: none;
        }
        
        /* 8. Badges / Tags */
        .featured-text, .sale_info, .badge {
            border-radius: 20px !important;
            font-weight: 600;
            padding: 4px 12px !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        /* 9. Seamless Mobile Responsiveness */
        @media (max-width: 768px) {
            .bravo-list-item, .bravo-offer, .bravo-how-it-work, .bravo-testimonial, .bravo-list-tour {
                padding: 40px 0 !important;
            }
            .title, .sec-title {
                font-size: 26px !important;
                margin-bottom: 25px !important;
            }
            .item-loop {
                margin-bottom: 20px !important;
            }
        }

        /* --- Premium Page Loader --- */
        #premium-page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: #ffffff;
            z-index: 999999;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }
        #premium-page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }
        .loader-logo {
            max-width: 200px;
            animation: pulse 1.5s infinite ease-in-out;
            margin-bottom: 20px;
        }
        .loader-text {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, #ff5f1f 0%, #ff8e53 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: pulse 1.5s infinite ease-in-out;
        }
        .loader-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #fff0ea;
            border-top: 4px solid #ff5f1f;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="frontend-page {{ !empty($row->header_style) ? "header-".$row->header_style : "header-normal" }} {{$body_class ?? ''}} @if(setting_item_with_lang('enable_rtl')) is-rtl @endif @if(is_api()) is_api @endif">
    
    <!-- Make My Travels Loader -->
    <div id="premium-page-loader">
        @php $logo_id = setting_item("logo_id"); @endphp
        @if(!empty($logo_id))
            <img src="{{get_file_url($logo_id,'full')}}" class="loader-logo" alt="Make My Travels">
        @else
            <div class="loader-text mb-3">Make My Travels</div>
        @endif
        <div class="loader-spinner"></div>
    </div>
    
    <script>
        // Hide loader once the page is fully loaded
        window.addEventListener('load', function() {
            var loader = document.getElementById('premium-page-loader');
            if (loader) {
                loader.classList.add('hidden');
                setTimeout(function() {
                    loader.style.display = 'none';
                }, 400); // match transition duration
            }
        });
        
        // Also show loader before navigating away
        window.addEventListener('beforeunload', function() {
            var loader = document.getElementById('premium-page-loader');
            if (loader) {
                loader.style.display = 'flex';
                loader.classList.remove('hidden');
            }
        });
    </script>
    @php event(new \Modules\Layout\Events\LayoutBeginBody()); @endphp

    @if(!is_demo_mode())
        {!! setting_item('body_scripts') !!}
        {!! setting_item_with_lang_raw('body_scripts') !!}
    @endif
    <div class="bravo_wrap">
        @if(!is_api())
            @include('Layout::parts.topbar')
            @include('Layout::parts.header')
        @endif

        @yield('content')

        @include('Layout::parts.footer')
    </div>
    @if(!is_demo_mode())
        {!! setting_item('footer_scripts') !!}
        {!! setting_item_with_lang_raw('footer_scripts') !!}
    @endif
    @php event(new \Modules\Layout\Events\LayoutEndBody()); @endphp

</body>
</html>

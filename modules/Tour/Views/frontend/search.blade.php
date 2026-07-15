@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/tour/css/tour.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
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
    /* ============================================================
       GLOBAL
    ============================================================ */
    .ht-landing-page { font-family: 'Inter', sans-serif; background: #f7f9fc; overflow-x: hidden; }

    /* ============================================================
       HERO — Full Width
    ============================================================ */
    .ht-hero {
        background: linear-gradient(135deg, #ff5f1f 0%, #ff8c00 50%, #ff5f1f 100%);
        background-size: 300% 300%;
        animation: heroGradient 8s ease infinite;
        position: relative;
        overflow: hidden;
        padding: 40px 0 95px;
        min-height: 460px;
    }
    @keyframes heroGradient {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    /* Decorative circles */
    .ht-hero::after {
        content: '';
        position: absolute;
        bottom: -2px; left: 0; right: 0;
        height: 90px;
        background: #f7f9fc;
        clip-path: ellipse(55% 100% at 50% 100%);
    }
    .hero-deco {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }
    .hero-deco-1 { width: 400px; height: 400px; top: -150px; right: -100px; }
    .hero-deco-2 { width: 250px; height: 250px; bottom: 20px; left: -80px; }
    .hero-deco-3 { width: 120px; height: 120px; top: 40px; left: 40%; }

    /* Hero Text */
    .ht-hero-text {
        text-align: center;
        margin-bottom: 36px;
    }
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(255,255,255,0.18);
        border: 1px solid rgba(255,255,255,0.35);
        border-radius: 30px;
        padding: 6px 18px;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        letter-spacing: 0.8px;
        margin-bottom: 16px;
        text-transform: uppercase;
    }
    .ht-hero-text h1 {
        font-size: 38px;
        font-weight: 900;
        color: #fff;
        line-height: 1.15;
        margin-bottom: 10px;
        letter-spacing: -1px;
        text-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    .ht-hero-text p {
        font-size: 16px;
        color: rgba(255,255,255,0.88);
        font-weight: 400;
        margin: 0;
    }
    @media (max-width: 768px) {
        .ht-hero-text h1 { font-size: 26px; }
        .ht-hero-text p  { font-size: 13px; }
        .ht-hero { padding: 35px 0 85px; }
    }

    /* ============================================================
       WHY CHOOSE US
    ============================================================ */
    .why-us-section { padding: 70px 0; background: #fff; }
    .section-title  { font-size: 28px; font-weight: 800; color: #1a1a2e; margin-bottom: 8px; text-align: center; }
    .section-subtitle { text-align: center; color: #999; font-size: 15px; margin-bottom: 45px; }
    .feature-card {
        background: #f7f9fc;
        border-radius: 18px;
        padding: 32px 22px;
        text-align: center;
        transition: all 0.35s ease;
        border: 2px solid transparent;
        height: 100%;
    }
    .feature-card:hover {
        background: #fff;
        border-color: #ffd5c2;
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(255,95,31,0.12);
    }
    .feature-icon {
        width: 68px; height: 68px;
        background: linear-gradient(135deg, #ff5f1f, #ff8c00);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px; color: #fff;
        box-shadow: 0 8px 25px rgba(255,95,31,0.35);
        transition: transform 0.3s ease;
    }
    .feature-card:hover .feature-icon { transform: scale(1.12) rotate(6deg); }
    .feature-card h5 { font-size: 16px; font-weight: 700; color: #1a1a2e; margin-bottom: 10px; }
    .feature-card p  { font-size: 13px; color: #777; margin: 0; line-height: 1.65; }

    /* ============================================================
       STATS SECTION
    ============================================================ */
    .stats-section {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 55px 0;
    }
    .stat-item { text-align: center; }
    .stat-number {
        font-size: 44px; font-weight: 900;
        background: linear-gradient(135deg, #ff5f1f, #ff8c00);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        line-height: 1.1; display: block;
    }
    .stat-label { font-size: 14px; color: rgba(255,255,255,0.65); font-weight: 500; margin-top: 8px; }

    /* ============================================================
       HOW IT WORKS
    ============================================================ */
    .how-section { padding: 70px 0; background: #f7f9fc; }
    .step-card {
        background: #fff;
        border-radius: 18px;
        padding: 34px 22px;
        text-align: center;
        position: relative;
        box-shadow: 0 4px 25px rgba(0,0,0,0.06);
        transition: transform 0.3s ease;
        height: 100%;
    }
    .step-card:hover { transform: translateY(-6px); }
    .step-num {
        width: 54px; height: 54px;
        background: linear-gradient(135deg, #ff5f1f, #ff8c00);
        border-radius: 50%;
        font-size: 22px; font-weight: 900; color: #fff;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 18px;
        box-shadow: 0 8px 25px rgba(255,95,31,0.35);
    }
    .step-card h5 { font-size: 16px; font-weight: 700; color: #1a1a2e; margin-bottom: 10px; }
    .step-card p  { font-size: 13px; color: #777; margin: 0; line-height: 1.65; }
    .step-arrow { position: absolute; right: -22px; top: 50%; transform: translateY(-50%); font-size: 22px; color: #ff5f1f; z-index: 5; }

    /* ============================================================
       POPULAR DESTINATIONS
    ============================================================ */
    .routes-section { padding: 70px 0; background: #fff; }
    .route-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f7f9fc;
        border: 1.5px solid #e9ecef;
        border-radius: 30px;
        padding: 10px 20px;
        font-size: 13px; font-weight: 600; color: #333;
        margin: 5px; text-decoration: none;
        transition: all 0.28s ease;
    }
    .route-chip:hover {
        background: #fff5f0; border-color: #ff5f1f; color: #ff5f1f;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(255,95,31,0.15);
        text-decoration: none;
    }
    .route-chip i { color: #ff5f1f; }

    /* ============================================================
       FORM SEARCH REDESIGN (MMT Style)
    ============================================================ */
    .bravo_form_search {
        margin-top: 30px !important;
        position: relative !important;
        z-index: 20 !important;
        transform: none !important;
        top: auto !important;
        bottom: auto !important;
        padding-bottom: 25px !important; /* Space for the search button */
    }
    .bravo_form_search .bravo_form {
        background: #fff !important;
        border-radius: 10px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
        display: flex !important;
        flex-direction: column !important;
        padding: 20px !important;
        position: relative !important;
        border: none !important;
    }
    .bravo_form_search .g-field-search {
        flex: 1 !important;
        display: flex !important;
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
    }
    .bravo_form_search .g-field-search .row {
        margin: 0 !important;
        width: 100% !important;
        display: flex !important;
        align-items: stretch !important;
        gap: 15px !important;
    }
    /* The individual field boxes */
    .bravo_form_search .g-field-search .row > div {
        flex: 1 !important;
        border: 1px solid #e7e7e7 !important;
        border-radius: 8px !important;
        padding: 15px 20px !important;
        position: relative !important;
        transition: all 0.2s ease !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        background: #fff !important;
    }
    .bravo_form_search .g-field-search .row > div:hover {
        background: #f4faff !important;
    }
    .bravo_form_search .g-field-search .row > div:focus-within {
        border-color: #008cff !important;
        box-shadow: 0 0 0 1px #008cff !important;
    }
    
    /* Floating Labels */
    .bravo_form_search label {
        position: absolute !important;
        top: -10px !important;
        left: 15px !important;
        background: #fff !important;
        padding: 0 5px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        color: #4a4a4a !important;
        text-transform: none !important;
        margin: 0 !important;
        display: block !important;
        z-index: 2 !important;
    }
    .bravo_form_search .g-field-search .row > div:focus-within label {
        color: #008cff !important;
    }

    /* Icon adjustments */
    .bravo_form_search .form-group i.field-icon { 
        display: none !important; /* Hide old icons to match MMT */
    }
    .bravo_form_search .form-group { margin-bottom: 0 !important; border: none !important; padding: 0 !important; position: static !important; }
    .bravo_form_search .form-content { padding-left: 0 !important; }
    
    /* Inputs */
    .bravo_form_search .form-control, .bravo_form_search .smart-search {
        border: none !important; padding: 0 !important; height: auto !important; font-size: 20px !important; font-weight: 900 !important; color: #000 !important; box-shadow: none !important; background: transparent !important;
    }
    
    /* Override gmpx-place-picker input to match MMT style */
    gmpx-place-picker::part(input) {
        font-size: 20px !important;
        font-weight: 900 !important;
        color: #000 !important;
    }
    
    .bravo_form_search .render {
        font-size: 20px !important; font-weight: 900 !important; color: #000 !important;
    }
    
    /* Subtext for dates/guests (optional, but we'll mimic the big text) */
    .bravo_form_search .form-group .sub-text {
        font-size: 13px !important; color: #4a4a4a !important; font-weight: 500 !important; display: block !important; margin-top: 5px !important;
    }

    /* The Search Button */
    .bravo_form_search .g-button-submit {
        position: absolute !important;
        bottom: -25px !important; /* Hangs off the bottom */
        left: 50% !important;
        transform: translateX(-50%) !important;
        margin: 0 !important;
        padding: 0 !important;
        z-index: 10 !important;
    }
    .bravo_form_search .btn-search {
        background: linear-gradient(93deg, #53b2fe, #065af3) !important; /* MMT Blue Gradient */
        border: none !important;
        border-radius: 34px !important; /* Pill shape */
        height: 50px !important;
        padding: 0 50px !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        color: #fff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: 0 4px 10px rgba(6,90,243,0.3) !important;
        width: auto !important;
        min-width: 200px !important;
    }
    /* If user wants orange, let's use the orange gradient to match the Hero */
    .bravo_form_search .btn-search {
        background: linear-gradient(93deg, #ff7a1f, #e55a00) !important;
        box-shadow: 0 4px 10px rgba(229,90,0,0.3) !important;
    }
    
    .bravo_form_search .btn-search:hover {
        transform: scale(1.05) !important;
        transition: transform 0.2s ease !important;
    }
    
    @media(max-width: 991px) {
        .bravo_form_search .bravo_form { padding: 15px !important; padding-bottom: 30px !important; }
        .bravo_form_search .g-field-search .row { flex-direction: column !important; gap: 20px !important; }
        .bravo_form_search .g-button-submit { bottom: -20px !important; }
        .bravo_form_search .btn-search { height: 45px !important; padding: 0 40px !important; font-size: 16px !important; }
    }

    /* ============================================================
       FAQ SECTION
    ============================================================ */
    .faq-section { padding: 70px 0; background: #f7f9fc; }
    .faq-item {
        background: #fff; border-radius: 14px;
        margin-bottom: 12px;
        box-shadow: 0 2px 18px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: box-shadow 0.3s;
    }
    .faq-item:hover { box-shadow: 0 6px 30px rgba(0,0,0,0.1); }
    .faq-question {
        padding: 20px 24px;
        font-size: 15px; font-weight: 700; color: #1a1a2e;
        cursor: pointer;
        display: flex; justify-content: space-between; align-items: center;
        user-select: none;
    }
    .faq-question i { color: #ff5f1f; transition: transform 0.3s; }
    .faq-question.active i { transform: rotate(180deg); }
    .faq-answer {
        display: none;
        padding: 0 24px 20px;
        font-size: 14px; color: #666; line-height: 1.75;
        border-top: 1px solid #f5f5f5;
    }
    .faq-question.active + .faq-answer { display: block; }

    /* ============================================================
       CITIES / SEO
    ============================================================ */
    .cities-section { padding: 45px 0; background: #fff; border-top: 1px solid #f0f0f0; }
    .cities-section h5 { font-size: 14px; font-weight: 800; color: #1a1a2e; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px; }
    .cities-section a { display: block; color: #ff5f1f; font-size: 13px; margin-bottom: 9px; text-decoration: none; transition: all 0.2s; }
    .cities-section a:hover { color: #c94500; padding-left: 6px; }
    </style>
@endsection

@section('content')
<div class="ht-landing-page bravo_search_tour">

    @php
        $is_search = request()->has('location_id') || request()->has('start') || request()->has('date') || request()->has('terms') || !empty(request()->query());
    @endphp

    @if(!$is_search)
    {{-- ================================================================
         HERO — Full Width (Only on Landing Page)
    ================================================================ --}}
    <div class="ht-hero">
        {{-- Decorative circles --}}
        <div class="hero-deco hero-deco-1"></div>
        <div class="hero-deco hero-deco-2"></div>
        <div class="hero-deco hero-deco-3"></div>

        <div class="container-fluid px-4 px-md-5" style="position:relative;z-index:10;max-width:1200px;margin:0 auto;">

            {{-- Title --}}
            <div class="ht-hero-text">
                <div class="hero-badge"><i class="fa fa-star"></i> Top Rated Tours Worldwide</div>
                <h1>{{setting_item_with_lang("tour_page_search_title") ?: "Book Your Adventure Online"}}</h1>
                <p>Guided Tours &nbsp;·&nbsp; Day Trips &nbsp;·&nbsp; Excursions — Best prices, expert local guides, instant confirmation.</p>
            </div>

            {{-- Full-Width Search Form --}}
            <div class="bravo_form_search">
                @include('Tour::frontend.layouts.search.form-search')
            </div>

        </div>
    </div>
    @else
        @include('Tour::frontend.layouts.search.search-summary-bar')
    @endif

    @if(!$is_search)

    {{-- ================================================================
         WHY CHOOSE US
    ================================================================ --}}
    <section class="why-us-section">
        <div class="container">
            <h2 class="section-title">Why Choose Us?</h2>
            <p class="section-subtitle">Your trusted tour booking platform — safe, affordable & memorable adventures</p>
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa fa-tag"></i></div>
                        <h5>Best Prices</h5>
                        <p>We offer the best deals and transparent pricing with no hidden charges.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa fa-check-circle"></i></div>
                        <h5>Verified Guides</h5>
                        <p>All tours are personally verified and rated by real customers for your safety.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa fa-bolt"></i></div>
                        <h5>Instant Booking</h5>
                        <p>Get instant confirmation on your bookings without any waiting time.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa fa-headphones"></i></div>
                        <h5>24/7 Support</h5>
                        <p>Our customer support is available round-the-clock to assist you anytime.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         STATS SECTION
    ================================================================ --}}
    <section class="stats-section">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">100K+</span>
                        <div class="stat-label">Happy Guests</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <div class="stat-label">Cities Covered</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">10K+</span>
                        <div class="stat-label">Verified Tours</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">4.8★</span>
                        <div class="stat-label">Average Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         HOW IT WORKS
    ================================================================ --}}
    <section class="how-section">
        <div class="container">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Book your perfect adventure in 3 simple steps</p>
            <div class="row g-4 position-relative">
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-num">1</div>
                        <h5>Enter Destination</h5>
                        <p>Enter your destination city, check-in and check-out dates, and guest details.</p>
                        <div class="step-arrow d-none d-md-block"><i class="fa fa-chevron-right"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-num">2</div>
                        <h5>Choose Your Tour</h5>
                        <p>Browse available tours, compare itineraries, check reviews and find your match.</p>
                        <div class="step-arrow d-none d-md-block"><i class="fa fa-chevron-right"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-num">3</div>
                        <h5>Confirm & Stay</h5>
                        <p>Pay securely online, receive your booking voucher instantly, and enjoy your tour!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         POPULAR DESTINATIONS
    ================================================================ --}}
    <section class="routes-section">
        <div class="container">
            <h2 class="section-title">Popular Destinations</h2>
            <p class="section-subtitle">Thousands of travellers book hotels in these cities every day</p>
            <div class="text-center">
                <a href="#" class="route-chip"><i class="fa fa-map-marker"></i> Tours in Goa</a>
                <a href="#" class="route-chip"><i class="fa fa-map-marker"></i> Tours in Delhi</a>
                <a href="#" class="route-chip"><i class="fa fa-map-marker"></i> Tours in Mumbai</a>
                <a href="#" class="route-chip"><i class="fa fa-map-marker"></i> Tours in Jaipur</a>
                <a href="#" class="route-chip"><i class="fa fa-map-marker"></i> Tours in Bangalore</a>
                <a href="#" class="route-chip"><i class="fa fa-map-marker"></i> Tours in Udaipur</a>
                <a href="#" class="route-chip"><i class="fa fa-map-marker"></i> Tours in Shimla</a>
                <a href="#" class="route-chip"><i class="fa fa-map-marker"></i> Tours in Manali</a>
                <a href="#" class="route-chip"><i class="fa fa-map-marker"></i> Tours in Chennai</a>
                <a href="#" class="route-chip"><i class="fa fa-map-marker"></i> Tours in Kolkata</a>
            </div>
        </div>
    </section>

    {{-- ================================================================
         FAQ
    ================================================================ --}}
    <section class="faq-section">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Everything you need to know about tour booking</p>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="faq-item">
                        <div class="faq-question">How do I book a tour online? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">Simply enter your destination city, dates, and number of guests. Click "Search" to see available options. Choose your preferred tour and confirm your booking.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">What documents do I need to carry for check-in? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">You need to carry a valid government-issued photo ID (Aadhar, Passport, Driving License, or Voter ID) and your booking confirmation voucher.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">Is my payment secure? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">Yes! We use industry-standard SSL encryption and support multiple secure payment methods including credit/debit cards, UPI, and net banking.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">Can I cancel or reschedule my booking? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">Yes, you can cancel or reschedule your booking based on the tour's cancellation policy. Please refer to your booking details for the specific policy applied to your reservation.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         CITIES / SEO LINKS
    ================================================================ --}}
    <section class="cities-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5><i class="fa fa-building mr-2" style="color:#ff5f1f;"></i> Top Cities</h5>
                    <a href="#">Delhi Tours</a>
                    <a href="#">Mumbai Tours</a>
                    <a href="#">Bangalore Tours</a>
                    <a href="#">Pune Tours</a>
                    <a href="#">Hyderabad Tours</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h5><i class="fa fa-star mr-2" style="color:#ff5f1f;"></i> Luxury Tours</h5>
                    <a href="#">Private Tours in Goa</a>
                    <a href="#">Luxury Tours in Delhi</a>
                    <a href="#">Private Tours in Mumbai</a>
                    <a href="#">Helicopter Rides in Udaipur</a>
                    <a href="#">Heritage Tours in Jaipur</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h5><i class="fa fa-compass mr-2" style="color:#ff5f1f;"></i> Adventure Stays</h5>
                    <a href="#">Trekking in Delhi</a>
                    <a href="#">Hiking in Mumbai</a>
                    <a href="#">Scuba Diving in Goa</a>
                    <a href="#">Skiing in Manali</a>
                    <a href="#">Camping in Shimla</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h5><i class="fa fa-tree mr-2" style="color:#ff5f1f;"></i> Tour Types</h5>
                    <a href="#">Day Trips</a>
                    <a href="#">Multi-day Tours</a>
                    <a href="#">Private Tours</a>
                    <a href="#">Group Tours</a>
                    <a href="#">Boat Tours</a>
                </div>
            </div>
        </div>
    </section>

    @endif

    @if($is_search)
        @include('Tour::frontend.layouts.search.list-item')
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Accordion
    document.querySelectorAll('.faq-question').forEach(function(q) {
        q.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });
});
</script>
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset('module/tour/js/tour.js?_ver='.config('app.version')) }}"></script>
@endsection
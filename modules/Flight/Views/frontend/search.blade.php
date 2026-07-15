@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/flight/css/flight.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
    /* ============================================================
       GLOBAL
    ============================================================ */
    .flight-landing-page { font-family: 'Inter', sans-serif; background: #f7f9fc; overflow-x: hidden; }

    /* ============================================================
       HERO — Full Width
    ============================================================ */
    .flight-hero {
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
    .flight-hero::after {
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
    .flight-hero-text {
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
    .flight-hero-text h1 {
        font-size: 38px;
        font-weight: 900;
        color: #fff;
        line-height: 1.15;
        margin-bottom: 10px;
        letter-spacing: -1px;
        text-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    .flight-hero-text p {
        font-size: 16px;
        color: rgba(255,255,255,0.88);
        font-weight: 400;
        margin: 0;
    }
    @media (max-width: 768px) {
        .flight-hero-text h1 { font-size: 26px; }
        .flight-hero-text p  { font-size: 13px; }
        .flight-hero { padding: 35px 0 85px; }
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
       POPULAR ROUTES
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
<div class="flight-landing-page bravo_search_flight">

    {{-- ================================================================
         HERO — Full Width
    ================================================================ --}}
    <div class="flight-hero">
        {{-- Decorative circles --}}
        <div class="hero-deco hero-deco-1"></div>
        <div class="hero-deco hero-deco-2"></div>
        <div class="hero-deco hero-deco-3"></div>

        <div class="container-fluid px-4 px-md-5" style="position:relative;z-index:10;max-width:1200px;margin:0 auto;">

            {{-- Title --}}
            <div class="flight-hero-text">
                <div class="hero-badge"><i class="fa fa-star"></i> India's Trusted Flight Booking</div>
                <h1>{{setting_item_with_lang("flight_page_search_title") ?: "Book a Flight Online"}}</h1>
                <p>Domestic &nbsp;·&nbsp; International — All flights, best prices, zero hassle.</p>
            </div>

            {{-- Full-Width Search Form --}}
            @include('Flight::frontend.layouts.search.form-search')

        </div>
    </div>

    @if(!request()->query('location_id') && !request()->query('destination_id'))

    {{-- ================================================================
         WHY CHOOSE US
    ================================================================ --}}
    <section class="why-us-section">
        <div class="container">
            <h2 class="section-title">Why Choose Us?</h2>
            <p class="section-subtitle">India's most trusted flight booking platform — safe, affordable & fast</p>
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa fa-rupee"></i></div>
                        <h5>Best Prices</h5>
                        <p>Transparent pricing with no hidden charges. What you see is what you pay.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa fa-shield"></i></div>
                        <h5>Safe & Secure</h5>
                        <p>All payments are securely processed. We guarantee a safe booking experience.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa fa-plane"></i></div>
                        <h5>Live Inventory</h5>
                        <p>We connect directly to airlines globally ensuring real-time seat availability.</p>
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
                        <span class="stat-number">10M+</span>
                        <div class="stat-label">Happy Flyers</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">800+</span>
                        <div class="stat-label">Airlines Connected</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">5000+</span>
                        <div class="stat-label">Daily Bookings</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">4.9★</span>
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
            <p class="section-subtitle">Book your flight in 3 simple steps</p>
            <div class="row g-4 position-relative">
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-num">1</div>
                        <h5>Enter Your Destination</h5>
                        <p>Enter your departure & arrival city, select travel date and passengers.</p>
                        <div class="step-arrow d-none d-md-block"><i class="fa fa-chevron-right"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-num">2</div>
                        <h5>Choose Your Flight</h5>
                        <p>Browse available flights with transparent pricing. Filter by airline, stops and more.</p>
                        <div class="step-arrow d-none d-md-block"><i class="fa fa-chevron-right"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-num">3</div>
                        <h5>Confirm & Fly</h5>
                        <p>Pay securely online, receive e-ticket instantly, and enjoy your flight!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         POPULAR ROUTES
    ================================================================ --}}
    <section class="routes-section">
        <div class="container">
            <h2 class="section-title">Popular Flight Routes</h2>
            <p class="section-subtitle">Thousands of travellers book these routes every day</p>
            <div class="text-center">
                <a href="#" class="route-chip"><i class="fa fa-plane"></i> Delhi → Mumbai</a>
                <a href="#" class="route-chip"><i class="fa fa-plane"></i> Bangalore → Delhi</a>
                <a href="#" class="route-chip"><i class="fa fa-plane"></i> Mumbai → Goa</a>
                <a href="#" class="route-chip"><i class="fa fa-plane"></i> Delhi → Dubai</a>
                <a href="#" class="route-chip"><i class="fa fa-plane"></i> Bangalore → Pune</a>
                <a href="#" class="route-chip"><i class="fa fa-plane"></i> Hyderabad → Chennai</a>
                <a href="#" class="route-chip"><i class="fa fa-plane"></i> Chennai → Port Blair</a>
                <a href="#" class="route-chip"><i class="fa fa-plane"></i> Pune → Delhi</a>
                <a href="#" class="route-chip"><i class="fa fa-plane"></i> Kolkata → Bangkok</a>
                <a href="#" class="route-chip"><i class="fa fa-plane"></i> Delhi → London</a>
                <a href="#" class="route-chip"><i class="fa fa-plane"></i> Kolkata → Bagdogra</a>
                <a href="#" class="route-chip"><i class="fa fa-plane"></i> Ahmedabad → Mumbai</a>
            </div>
        </div>
    </section>

    {{-- ================================================================
         FAQ
    ================================================================ --}}
    <section class="faq-section">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Everything you need to know about flight booking</p>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="faq-item">
                        <div class="faq-question">How do I book a flight online? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">Simply enter your origin city, destination city, and travel date. Click "Search" to see available flights with transparent pricing. Choose your preferred flight and confirm your booking.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">What is web check-in? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">Web check-in allows you to select your seat and get your boarding pass online before arriving at the airport. It saves time and is mandatory for most domestic flights.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">Is my payment secure? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">Yes! We use industry-standard SSL encryption and support multiple secure payment methods including credit/debit cards, UPI, and net banking.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">Can I cancel or reschedule my booking? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">Yes, you can cancel or reschedule your flight. Cancellation charges apply based on airline policies. Please refer to your ticket for exact details.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">What baggage allowance is included? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">Most domestic flights include 15kg check-in baggage and 7kg cabin baggage. However, this varies by airline and fare type. Always check the baggage details during booking.</div>
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
                    <h5><i class="fa fa-road mr-2" style="color:#ff5f1f;"></i> Top Routes</h5>
                    <a href="#">Delhi To Mumbai Flights</a>
                    <a href="#">Delhi To Goa Flights</a>
                    <a href="#">Mumbai To Pune Flights</a>
                    <a href="#">Delhi To Bangalore Flights</a>
                    <a href="#">Bangalore To Hyderabad Flights</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h5><i class="fa fa-building mr-2" style="color:#ff5f1f;"></i> Top Cities</h5>
                    <a href="#">Flights to Delhi</a>
                    <a href="#">Flights to Mumbai</a>
                    <a href="#">Flights to Bangalore</a>
                    <a href="#">Flights to Pune</a>
                    <a href="#">Flights to Hyderabad</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h5><i class="fa fa-plane mr-2" style="color:#ff5f1f;"></i> Top Airlines</h5>
                    <a href="#">IndiGo Flights</a>
                    <a href="#">Air India Flights</a>
                    <a href="#">Vistara Flights</a>
                    <a href="#">SpiceJet Flights</a>
                    <a href="#">Go First Flights</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h5><i class="fa fa-globe mr-2" style="color:#ff5f1f;"></i> International</h5>
                    <a href="#">Delhi to Dubai</a>
                    <a href="#">Mumbai to London</a>
                    <a href="#">Bangalore to Singapore</a>
                    <a href="#">Chennai to Kuala Lumpur</a>
                    <a href="#">Kolkata to Bangkok</a>
                </div>
            </div>
        </div>
    </section>

    @endif

    @if(request()->query('location_id') || request()->query('destination_id'))
        <div class="container mt-5">
            @include('Flight::frontend.layouts.search.list-item')
        </div>
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
    <script src="{{asset('libs/custombox/custombox.min.js')}}"></script>
    <script src="{{asset('libs/custombox/custombox.legacy.min.js')}}"></script>
    <script src="{{ asset('libs/custombox/window.modal.js') }}"></script>

    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset('module/flight/js/flight.js?_ver='.config('app.version')) }}"></script>
    <script>
        $(document).ready(function () {
            $.BCoreModal.init('[data-modal-target]');
        })
    </script>
@endsection
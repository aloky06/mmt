@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/car/css/car.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
    /* ============================================================
       GLOBAL
    ============================================================ */
    .cab-landing-page { font-family: 'Inter', sans-serif; background: #f7f9fc; overflow-x: hidden; }

    /* ============================================================
       HERO — Full Width
    ============================================================ */
    .cab-hero {
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
    .cab-hero::after {
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
    .cab-hero-text {
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
    .cab-hero-text h1 {
        font-size: 38px;
        font-weight: 900;
        color: #fff;
        line-height: 1.15;
        margin-bottom: 10px;
        letter-spacing: -1px;
        text-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    .cab-hero-text p {
        font-size: 16px;
        color: rgba(255,255,255,0.88);
        font-weight: 400;
        margin: 0;
    }
    @media (max-width: 768px) {
        .cab-hero-text h1 { font-size: 26px; }
        .cab-hero-text p  { font-size: 13px; }
        .cab-hero { padding: 35px 0 85px; }
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
<div class="cab-landing-page bravo_search_car">

    {{-- ================================================================
         HERO — Full Width
    ================================================================ --}}
    <div class="cab-hero">
        {{-- Decorative circles --}}
        <div class="hero-deco hero-deco-1"></div>
        <div class="hero-deco hero-deco-2"></div>
        <div class="hero-deco hero-deco-3"></div>

        <div class="container-fluid px-4 px-md-5" style="position:relative;z-index:10;max-width:1200px;margin:0 auto;">

            {{-- Title --}}
            <div class="cab-hero-text">
                <div class="hero-badge"><i class="fa fa-star"></i> India's Trusted Cab Service</div>
                <h1>{{setting_item_with_lang("car_page_search_title") ?: "Book a Cab Online"}}</h1>
                <p>Outstation &nbsp;·&nbsp; Airport &nbsp;·&nbsp; Hourly — All rides, best prices, zero hassle.</p>
            </div>

            {{-- Full-Width Search Form --}}
            @include('Car::frontend.layouts.search.form-search')

        </div>
    </div>

    @if(!request()->query('trip_type') && !request()->query('pickup_name'))

    {{-- ================================================================
         WHY CHOOSE US
    ================================================================ --}}
    <section class="why-us-section">
        <div class="container">
            <h2 class="section-title">Why Choose Us?</h2>
            <p class="section-subtitle">India's most trusted cab booking platform — safe, affordable & on-time</p>
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
                        <p>All drivers are background verified, trained, and rated by real customers.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa fa-clock-o"></i></div>
                        <h5>On-Time Always</h5>
                        <p>We guarantee on-time pick-up. Your time matters as much as your journey.</p>
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
                        <span class="stat-number">50K+</span>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">200+</span>
                        <div class="stat-label">Cities Covered</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">5000+</span>
                        <div class="stat-label">Verified Drivers</div>
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
            <p class="section-subtitle">Book your cab in 3 simple steps</p>
            <div class="row g-4 position-relative">
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-num">1</div>
                        <h5>Enter Your Route</h5>
                        <p>Enter your pickup & drop location, select travel date and your preferred trip type.</p>
                        <div class="step-arrow d-none d-md-block"><i class="fa fa-chevron-right"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-num">2</div>
                        <h5>Choose Your Cab</h5>
                        <p>Browse available cabs with transparent pricing. Filter by car type, AC/Non-AC and more.</p>
                        <div class="step-arrow d-none d-md-block"><i class="fa fa-chevron-right"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-num">3</div>
                        <h5>Confirm & Ride</h5>
                        <p>Pay securely online, receive booking confirmation instantly, and enjoy your ride!</p>
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
            <h2 class="section-title">Popular Cab Routes</h2>
            <p class="section-subtitle">Thousands of travellers book these routes every day</p>
            <div class="text-center">
                <a href="#" class="route-chip"><i class="fa fa-car"></i> Delhi → Agra</a>
                <a href="#" class="route-chip"><i class="fa fa-car"></i> Delhi → Jaipur</a>
                <a href="#" class="route-chip"><i class="fa fa-car"></i> Delhi → Chandigarh</a>
                <a href="#" class="route-chip"><i class="fa fa-car"></i> Mumbai → Pune</a>
                <a href="#" class="route-chip"><i class="fa fa-car"></i> Bangalore → Mysore</a>
                <a href="#" class="route-chip"><i class="fa fa-car"></i> Hyderabad → Vijayawada</a>
                <a href="#" class="route-chip"><i class="fa fa-car"></i> Chennai → Pondicherry</a>
                <a href="#" class="route-chip"><i class="fa fa-car"></i> Pune → Mumbai Airport</a>
                <a href="#" class="route-chip"><i class="fa fa-car"></i> Jaipur → Jodhpur</a>
                <a href="#" class="route-chip"><i class="fa fa-car"></i> Delhi → Manali</a>
                <a href="#" class="route-chip"><i class="fa fa-car"></i> Kolkata → Digha</a>
                <a href="#" class="route-chip"><i class="fa fa-car"></i> Ahmedabad → Surat</a>
            </div>
        </div>
    </section>

    {{-- ================================================================
         FAQ
    ================================================================ --}}
    <section class="faq-section">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Everything you need to know about cab booking</p>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="faq-item">
                        <div class="faq-question">How do I book a cab online? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">Simply enter your pickup city, drop city, travel date, and time. Click "Search Cabs" to see available options with transparent pricing. Choose your preferred cab and confirm your booking.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">What is an Outstation One-Way trip? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">An outstation one-way trip is when you travel from one city to another and do not need a return cab. You only pay for the one-way distance, making it very economical.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">Is my payment secure? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">Yes! We use industry-standard SSL encryption and support multiple secure payment methods including credit/debit cards, UPI, and net banking.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">Can I cancel or reschedule my booking? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">Yes, you can cancel or reschedule your booking up to a few hours before departure. Cancellation charges may apply based on timing. Please refer to our cancellation policy for details.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">What does the fare include? <i class="fa fa-chevron-down"></i></div>
                        <div class="faq-answer">The fare includes base fare, fuel charges, and driver allowance. Toll charges, state border taxes, and parking fees may be additional and are paid at actuals during the trip.</div>
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
                    <a href="#">Delhi To Chandigarh Cab</a>
                    <a href="#">Delhi To Agra Cab</a>
                    <a href="#">Mumbai To Pune Cab</a>
                    <a href="#">Delhi To Jaipur Cab</a>
                    <a href="#">Bangalore To Mysore Cab</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h5><i class="fa fa-building mr-2" style="color:#ff5f1f;"></i> Top Cities</h5>
                    <a href="#">Delhi Cabs</a>
                    <a href="#">Mumbai Cabs</a>
                    <a href="#">Bangalore Cabs</a>
                    <a href="#">Pune Cabs</a>
                    <a href="#">Hyderabad Cabs</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h5><i class="fa fa-plane mr-2" style="color:#ff5f1f;"></i> Airport Cabs</h5>
                    <a href="#">Delhi Airport Cab</a>
                    <a href="#">Mumbai Airport Cab</a>
                    <a href="#">Bangalore Airport Cab</a>
                    <a href="#">Chennai Airport Cab</a>
                    <a href="#">Hyderabad Airport Cab</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h5><i class="fa fa-car mr-2" style="color:#ff5f1f;"></i> Cab Types</h5>
                    <a href="#">Sedan Cabs</a>
                    <a href="#">SUV Cabs</a>
                    <a href="#">Luxury Cabs</a>
                    <a href="#">Mini Cabs</a>
                    <a href="#">Tempo Traveller</a>
                </div>
            </div>
        </div>
    </section>

    @endif

    @if(request()->query('trip_type') || request()->query('pickup_name'))
        @include('Car::frontend.layouts.search.list-item')
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
    <script type="text/javascript" src="{{ asset('module/car/js/car.js?_ver='.config('app.version')) }}"></script>
@endsection

@extends('Layout::app')
@section('head')
<title>{{ __('Attach Your Taxi') }} — {{ setting_item('site_title','BookingCore') }}</title>
<meta name="description" content="Attach Your Taxi on our platform. Start accepting bookings and reach thousands of travelers today.">
<style>
:root {
    --navy: #003580;
    --blue: #0071c2;
    --gold: #f5a623;
    --white: #ffffff;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-600: #475569;
    --gray-800: #1e293b;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Poppins', sans-serif; }

/* HERO */
.lp-hero {
    background: linear-gradient(135deg, var(--navy) 0%, #1a4fa0 50%, #0071c2 100%);
    color: var(--white); padding: 80px 40px; text-align: center;
    position: relative; overflow: hidden;
}
.lp-hero::before {
    content: ''; position: absolute; top: -50%; left: -50%;
    width: 200%; height: 200%;
    background: radial-gradient(circle at 30% 50%, rgba(245,166,35,0.08) 0%, transparent 60%),
                radial-gradient(circle at 70% 30%, rgba(0,113,194,0.15) 0%, transparent 50%);
}
.lp-hero-content { position: relative; z-index: 1; max-width: 800px; margin: 0 auto; }
.lp-hero h1 {
    font-size: clamp(32px, 5vw, 56px); font-weight: 800; line-height: 1.1;
    margin-bottom: 20px;
}
.lp-hero h1 span { color: var(--gold); }
.lp-hero p { font-size: 18px; opacity: 0.85; margin-bottom: 36px; line-height: 1.6; }
.lp-hero-btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
.lp-btn-primary {
    background: var(--gold); color: #1a1a1a; padding: 16px 36px;
    border-radius: 10px; font-size: 16px; font-weight: 700;
    text-decoration: none; transition: all 0.3s;
    box-shadow: 0 4px 20px rgba(245,166,35,0.4);
}
.lp-btn-primary:hover { background: #e6951a; transform: translateY(-2px); color: #1a1a1a; }
.lp-btn-secondary {
    background: rgba(255,255,255,0.1); color: var(--white); padding: 16px 36px;
    border-radius: 10px; font-size: 16px; font-weight: 600;
    text-decoration: none; border: 2px solid rgba(255,255,255,0.3);
    transition: all 0.3s;
}
.lp-btn-secondary:hover { background: rgba(255,255,255,0.2); color: var(--white); }

/* STATS BAR */
.lp-stats {
    background: var(--white); border-bottom: 1px solid var(--gray-200);
    padding: 28px 40px;
}
.lp-stats-inner {
    display: flex; justify-content: center; gap: 60px; flex-wrap: wrap;
    max-width: 900px; margin: 0 auto;
}
.lp-stat { text-align: center; }
.lp-stat-num { font-size: 32px; font-weight: 800; color: var(--navy); }
.lp-stat-label { font-size: 13px; color: var(--gray-600); margin-top: 2px; }

/* HOW IT WORKS */
.lp-section { padding: 72px 40px; }
.lp-section-title {
    text-align: center; font-size: 30px; font-weight: 800;
    color: var(--gray-800); margin-bottom: 12px;
}
.lp-section-sub { text-align: center; font-size: 16px; color: var(--gray-600); margin-bottom: 48px; }

.lp-steps {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px;
    max-width: 900px; margin: 0 auto;
}
.lp-step {
    text-align: center; padding: 32px 24px;
    background: var(--white); border-radius: 16px;
    border: 1.5px solid var(--gray-200);
    box-shadow: 0 2px 16px rgba(0,53,128,0.06);
    transition: all 0.3s;
}
.lp-step:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,53,128,0.1); }
.lp-step-icon {
    width: 64px; height: 64px; border-radius: 16px;
    background: linear-gradient(135deg, var(--navy), var(--blue));
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; margin: 0 auto 20px;
}
.lp-step-num {
    width: 28px; height: 28px; border-radius: 50%;
    background: var(--gold); color: #1a1a1a;
    font-size: 13px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
}
.lp-step h3 { font-size: 16px; font-weight: 700; color: var(--gray-800); margin-bottom: 8px; }
.lp-step p { font-size: 13px; color: var(--gray-600); line-height: 1.6; }

/* BENEFITS */
.lp-benefits-bg { background: var(--gray-50); }
.lp-benefits {
    display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;
    max-width: 860px; margin: 0 auto;
}
.lp-benefit {
    display: flex; align-items: flex-start; gap: 16px;
    background: var(--white); border-radius: 12px; padding: 24px;
    border: 1px solid var(--gray-200);
}
.lp-benefit-icon { font-size: 28px; flex-shrink: 0; }
.lp-benefit h4 { font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 4px; }
.lp-benefit p { font-size: 13px; color: var(--gray-600); line-height: 1.5; }

/* CTA */
.lp-cta {
    background: linear-gradient(135deg, var(--navy), var(--blue));
    color: var(--white); padding: 72px 40px; text-align: center;
}
.lp-cta h2 { font-size: 34px; font-weight: 800; margin-bottom: 16px; }
.lp-cta p { font-size: 16px; opacity: 0.85; margin-bottom: 36px; }

/* Responsive */
@media (max-width: 768px) {
    .lp-hero { padding: 60px 20px; }
    .lp-steps { grid-template-columns: 1fr; }
    .lp-benefits { grid-template-columns: 1fr; }
    .lp-stats-inner { gap: 32px; }
    .lp-section { padding: 48px 20px; }
}
</style>
@endsection

@section('content')

<!-- HERO -->
<section class="lp-hero">
    <div class="lp-hero-content">
        <h1>Attach Your Taxi &amp; <span>Start Earning</span></h1>
        <p>Join thousands of property owners on our platform. Reach millions of travelers, manage bookings easily, and grow your business.</p>
        <div class="lp-hero-btns">
            <a href="{{ route('car.list.register') }}" class="lp-btn-primary">🚀 Get Started — It's Free</a>
            <a href="#how-it-works" class="lp-btn-secondary">Learn More</a>
        </div>
    </div>
</section>

<!-- STATS -->
<div class="lp-stats">
    <div class="lp-stats-inner">
        <div class="lp-stat">
            <div class="lp-stat-num">10,000+</div>
            <div class="lp-stat-label">Properties Listed</div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-num">500K+</div>
            <div class="lp-stat-label">Happy Travelers</div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-num">₹2Cr+</div>
            <div class="lp-stat-label">Revenue Generated</div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-num">150+</div>
            <div class="lp-stat-label">Cities Covered</div>
        </div>
    </div>
</div>

<!-- HOW IT WORKS -->
<section class="lp-section" id="how-it-works">
    <h2 class="lp-section-title">How It Works</h2>
    <p class="lp-section-sub">Get your hotel listed in just 3 simple steps</p>
    <div class="lp-steps">
        <div class="lp-step">
            <div class="lp-step-num">1</div>
            <div class="lp-step-icon">📝</div>
            <h3>Fill the Form</h3>
            <p>Complete our step-by-step registration wizard with your property details, rooms, and pricing.</p>
        </div>
        <div class="lp-step">
            <div class="lp-step-num">2</div>
            <div class="lp-step-icon">🔍</div>
            <h3>Admin Review</h3>
            <p>Our team reviews your submission within 24–48 hours to ensure quality standards.</p>
        </div>
        <div class="lp-step">
            <div class="lp-step-num">3</div>
            <div class="lp-step-icon">🎉</div>
            <h3>Go Live &amp; Earn</h3>
            <p>Once approved, your property goes live and you start receiving bookings immediately.</p>
        </div>
    </div>
</section>

<!-- BENEFITS -->
<section class="lp-section lp-benefits-bg">
    <h2 class="lp-section-title">Why Partner With Us?</h2>
    <p class="lp-section-sub">Everything you need to manage your property successfully</p>
    <div class="lp-benefits">
        <div class="lp-benefit">
            <div class="lp-benefit-icon">📊</div>
            <div>
                <h4>Powerful Dashboard</h4>
                <p>Manage bookings, track revenue, update availability — all from one beautiful dashboard.</p>
            </div>
        </div>
        <div class="lp-benefit">
            <div class="lp-benefit-icon">💰</div>
            <div>
                <h4>Instant Payouts</h4>
                <p>Receive payments directly to your bank account with transparent commission structure.</p>
            </div>
        </div>
        <div class="lp-benefit">
            <div class="lp-benefit-icon">📱</div>
            <div>
                <h4>Mobile Friendly</h4>
                <p>Manage your property on the go with our fully responsive interface.</p>
            </div>
        </div>
        <div class="lp-benefit">
            <div class="lp-benefit-icon">🛡️</div>
            <div>
                <h4>Verified &amp; Trusted</h4>
                <p>Admin verification ensures only quality properties are listed, building guest trust.</p>
            </div>
        </div>
        <div class="lp-benefit">
            <div class="lp-benefit-icon">📅</div>
            <div>
                <h4>Smart Calendar</h4>
                <p>Set availability, block dates, and manage rates with our intuitive calendar tool.</p>
            </div>
        </div>
        <div class="lp-benefit">
            <div class="lp-benefit-icon">⭐</div>
            <div>
                <h4>Guest Reviews</h4>
                <p>Build your reputation with verified guest reviews that help attract more bookings.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="lp-cta">
    <h2>Ready to Start?</h2>
    <p>Join our growing community of taxi owners. It's free to Attach Your Taxi.</p>
    <a href="{{ route('car.list.register') }}" class="lp-btn-primary" style="display:inline-block;">
        🏨 Attach Your Taxi Now
    </a>
</section>

@endsection
@section('footer')
@endsection

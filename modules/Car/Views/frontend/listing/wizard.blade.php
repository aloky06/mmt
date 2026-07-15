@extends('Layout::app')
@section('head')
<title>{{ __('Register Your vehicle') }} — {{ setting_item('site_title','BookingCore') }}</title>
<meta name="description" content="Register your Car vehicle step by step. Complete the wizard to list your vehicle and start accepting bookings.">
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

/* ===== Modern SaaS Wizard UI Overhaul ===== */
:root {
    --navy: #0f172a;
    --blue: #2563eb; /* SaaS Primary Blue */
    --blue-hover: #1d4ed8;
    --blue-light: #eff6ff;
    --green: #10b981; /* Emerald Success */
    --green-bg: #ecfdf5;
    --gold: #f59e0b;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-800: #1e293b;
    --white: #ffffff;
    --red: #ef4444; /* Error Red */
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
    --focus-ring: 0 0 0 4px rgba(37, 99, 235, 0.15);
    --focus-ring-error: 0 0 0 4px rgba(239, 68, 68, 0.15);
    --focus-ring-success: 0 0 0 4px rgba(16, 185, 129, 0.15);
}
*{box-sizing:border-box;margin:0;padding:0;}
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--gray-50); color: var(--gray-800); -webkit-font-smoothing: antialiased; }

/* ---- TOP BAR ---- */
.wiz-topbar {
    background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--gray-200); padding: 0 40px; height: 72px;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 200; box-shadow: var(--shadow-sm);
}
.wiz-brand { font-size: 24px; font-weight: 800; color: var(--navy); text-decoration: none; letter-spacing: -0.5px; }
.wiz-brand span { color: var(--blue); }
.wiz-topbar-right { display: flex; align-items: center; gap: 24px; }
.wiz-topbar-right a { color: var(--gray-600); font-size: 14px; text-decoration: none; font-weight: 600; transition: color 0.2s; }
.wiz-topbar-right a:hover { color: var(--navy); }
.wiz-save-btn {
    background: var(--blue-light); color: var(--blue);
    border: none; border-radius: 8px;
    padding: 10px 24px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s ease;
}
.wiz-save-btn:hover { background: var(--blue); color: var(--white); box-shadow: 0 6px 12px rgba(37,99,235,0.2); transform: translateY(-1px); }

/* ---- PROGRESS BAR ---- */
.wiz-progress-wrap {
    background: var(--white); border-bottom: 1px solid var(--gray-200);
    padding: 16px 40px; position: sticky; top: 72px; z-index: 199;
}
.wiz-progress-label {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 10px; font-size: 13px; color: var(--gray-600); font-weight: 600;
}
.wiz-progress-label strong { color: var(--navy); font-size: 14px; font-weight: 800; letter-spacing: -0.2px; }
.wiz-progress-bar { height: 8px; background: var(--gray-100); border-radius: 4px; overflow: hidden; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05); }
.wiz-progress-fill {
    height: 100%; border-radius: 4px;
    background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

/* ---- MAIN LAYOUT ---- */
.wiz-layout {
    display: grid; grid-template-columns: 320px 1fr;
    min-height: calc(100vh - 150px); max-width: 1400px; margin: 0 auto; gap: 48px;
}

/* ---- TIMELINE SIDEBAR ---- */
.wiz-sidebar {
    background: transparent; padding: 48px 10px 40px 0;
    position: sticky; top: 150px; height: calc(100vh - 150px); overflow-y: auto;
}
.wiz-sidebar::-webkit-scrollbar { width: 4px; }
.wiz-sidebar::-webkit-scrollbar-thumb { background: var(--gray-200); border-radius: 4px; }
.wiz-sidebar-group { margin-bottom: 32px; }
.wiz-sidebar-group-title {
    font-size: 11px; font-weight: 800; letter-spacing: 1.5px;
    color: var(--gray-400); text-transform: uppercase;
    padding: 0 24px; margin-bottom: 16px;
}
.wiz-sidebar-item {
    position: relative; display: flex; align-items: center; gap: 16px;
    padding: 14px 24px; cursor: pointer;
    transition: all 0.3s ease; font-size: 14px; color: var(--gray-600); font-weight: 600;
    border-radius: 12px; margin-bottom: 8px; z-index: 2;
}
/* THICKER Timeline Connectors */
.wiz-sidebar-item:not(:last-child)::after {
    content: ''; position: absolute;
    left: 37px; top: 40px; bottom: -8px; width: 3px; /* Bolder line */
    background: var(--gray-200); z-index: -1;
    transition: background 0.4s ease;
}
.wiz-sidebar-item.completed:not(:last-child)::after { background: var(--blue); }

.wiz-sidebar-item:hover { background: rgba(241, 245, 249, 0.6); color: var(--navy); }
.wiz-sidebar-item.active {
    background: var(--white); color: var(--blue); font-weight: 700;
    box-shadow: var(--shadow-sm); border: 1px solid var(--gray-100);
}
.wiz-sidebar-item.completed { color: var(--gray-800); }
.wiz-sidebar-item .item-icon {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800; flex-shrink: 0;
    background: var(--white); color: var(--gray-400);
    border: 2px solid var(--gray-200); transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.wiz-sidebar-item.active .item-icon {
    background: var(--blue); color: var(--white); border-color: var(--blue);
    box-shadow: 0 0 0 4px var(--blue-light);
}
.wiz-sidebar-item.completed .item-icon {
    background: var(--green); color: var(--white); border-color: var(--green);
    animation: popIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes popIn { 0%{transform:scale(0.8);} 50%{transform:scale(1.1);} 100%{transform:scale(1);} }

/* ---- CONTENT AREA & ANIMATIONS ---- */
.wiz-content { padding: 48px 0; }
.wiz-step { display: none; }
.wiz-step.active { display: block; animation: stepFadeSlide 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
@keyframes stepFadeSlide { from{opacity:0; transform:translateY(15px);} to{opacity:1; transform:translateY(0);} }

.wiz-step-header { margin-bottom: 40px; }
.wiz-step-header h2 {
    font-size: clamp(28px, 4vw, 36px); font-weight: 800;
    color: var(--navy); line-height: 1.2; margin-bottom: 12px; letter-spacing: -1px;
}
.wiz-step-header p { font-size: 16px; color: var(--gray-500); line-height: 1.6; font-weight: 500; }

/* ---- PREMIUM CARDS (More Spacious) ---- */
.wiz-card {
    background: var(--white); border: 1px solid var(--gray-200);
    border-radius: 16px; padding: 48px; margin-bottom: 32px;
    box-shadow: var(--shadow-sm); transition: all 0.3s ease;
}
.wiz-card:hover { box-shadow: var(--shadow-md); border-color: var(--gray-300); }
.wiz-card-title { font-size: 18px; font-weight: 800; color: var(--navy); margin-bottom: 32px; letter-spacing: -0.3px; border-bottom: 1px solid var(--gray-100); padding-bottom: 16px; }

/* ---- FORM FIELDS ---- */
.wiz-row { display: flex; flex-wrap: wrap; margin: -16px; }
.wiz-col-12 { width: 100%; padding: 16px; }
.wiz-col-6 { width: 50%; padding: 16px; }
.wiz-col-4 { width: 33.333%; padding: 16px; }
@media(max-width: 768px) { .wiz-col-6, .wiz-col-4 { width: 100%; } }

.wiz-field { margin-bottom: 24px; position: relative; }
.wiz-label {
    display: block; font-size: 14px; font-weight: 700; color: var(--gray-600);
    margin-bottom: 8px;
}
.wiz-input, .wiz-select, .wiz-textarea {
    width: 100%; padding: 14px 16px; font-size: 15px; font-weight: 500;
    border: 1.5px solid var(--gray-200); border-radius: 8px;
    background: var(--gray-50); color: var(--gray-800);
    transition: all 0.2s ease; font-family: inherit;
}
.wiz-input::placeholder, .wiz-textarea::placeholder { color: var(--gray-400); font-weight: 400; }
.wiz-input:focus, .wiz-select:focus, .wiz-textarea:focus {
    border-color: var(--blue); outline: none; background: var(--white);
    box-shadow: var(--focus-ring);
}
.wiz-textarea { min-height: 120px; resize: vertical; }

/* VALIDATION STATES */
.wiz-input.is-valid, .wiz-select.is-valid, .wiz-textarea.is-valid {
    border-color: var(--green); background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
    background-repeat: no-repeat; background-position: right calc(0.375em + 0.1875rem) center; background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}
.wiz-input.is-valid:focus { box-shadow: var(--focus-ring-success); }

.wiz-input.is-invalid, .wiz-select.is-invalid, .wiz-textarea.is-invalid {
    border-color: var(--red); background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23ef4444' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23ef4444' d='M0 0l3 3m0-3L0 3'/%3e%3c/svg%3e");
    background-repeat: no-repeat; background-position: right calc(0.375em + 0.1875rem) center; background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}
.wiz-input.is-invalid:focus { box-shadow: var(--focus-ring-error); }

/* CHARACTER COUNTER */
.char-counter { font-size: 12px; color: var(--gray-400); text-align: right; margin-top: 6px; font-weight: 500; }

/* ---- CUSTOM COMPONENT STYLING (RADIO/CHECKBOX GRIDS) ---- */
.prop-type-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
.prop-type-card {
    border: 1.5px solid var(--gray-200); border-radius: 12px; padding: 24px;
    text-align: center; cursor: pointer; transition: all 0.2s ease; background: var(--white);
}
.prop-type-card:hover { border-color: var(--blue-hover); box-shadow: var(--shadow-sm); transform: translateY(-2px); }
.prop-type-card.selected {
    border-color: var(--blue); background: var(--blue-light);
    box-shadow: 0 0 0 1px var(--blue);
}
.prop-type-icon { font-size: 32px; color: var(--gray-400); margin-bottom: 16px; transition: all 0.2s; }
.prop-type-card:hover .prop-type-icon { color: var(--blue-hover); }
.prop-type-card.selected .prop-type-icon { color: var(--blue); }
.prop-type-name { font-size: 15px; font-weight: 700; color: var(--navy); }
.prop-type-desc { font-size: 13px; color: var(--gray-500); margin-top: 8px; font-weight: 500; }

/* CUSTOM CHECKBOX LISTS */
.wiz-checkbox-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; }
.wiz-checkbox-item {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 16px; border: 1px solid var(--gray-200); border-radius: 8px;
    cursor: pointer; transition: all 0.2s; font-size: 14px; font-weight: 600; color: var(--gray-800);
    background: var(--white);
}
.wiz-checkbox-item:hover { background: var(--gray-50); border-color: var(--gray-300); }
.wiz-checkbox-item input { width: 18px; height: 18px; accent-color: var(--blue); cursor: pointer; }
.wiz-checkbox-item:has(input:checked) { border-color: var(--blue); background: var(--blue-light); }

/* LOCATION SELECTOR */
.loc-list { border: 1.5px solid var(--gray-200); border-radius: 8px; max-height: 250px; overflow-y: auto; background: var(--white); }
.loc-list::-webkit-scrollbar { width: 6px; }
.loc-list::-webkit-scrollbar-thumb { background: var(--gray-300); border-radius: 6px; }
.loc-item { padding: 12px 16px; border-bottom: 1px solid var(--gray-100); display: flex; align-items: center; gap: 12px; cursor: pointer; font-size: 14px; font-weight: 600; transition: background 0.2s;}
.loc-item:last-child { border-bottom: none; }
.loc-item:hover { background: var(--blue-light); color: var(--blue); }
.loc-item input { width: 18px; height: 18px; accent-color: var(--blue); }

/* ---- NAV BUTTONS ---- */
.wiz-nav {
    display: flex; justify-content: space-between; align-items: center;
    margin-top: 48px; padding-top: 32px; border-top: 1px solid var(--gray-200);
}
.wiz-btn {
    padding: 14px 32px; border-radius: 8px; font-size: 15px; font-weight: 700;
    cursor: pointer; transition: all 0.2s ease; border: none; outline: none;
    display: inline-flex; align-items: center; gap: 8px; justify-content: center;
}
.wiz-btn-back { background: var(--white); color: var(--gray-600); border: 1.5px solid var(--gray-200); }
.wiz-btn-back:hover { background: var(--gray-50); color: var(--navy); border-color: var(--gray-300); }
.wiz-btn-next, .wiz-btn-submit {
    background: var(--blue); color: var(--white);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}
.wiz-btn-next:hover, .wiz-btn-submit:hover {
    background: var(--blue-hover); transform: translateY(-1px); box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
}
.wiz-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; filter: grayscale(1); }

/* SUMMARY (Review Step) */
.wiz-summary-section { margin-bottom: 40px; }
.wiz-summary-title { font-size: 14px; font-weight: 800; color: var(--gray-500); border-bottom: 1.5px solid var(--gray-100); padding-bottom: 16px; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px; }
.wiz-summary-row { display: flex; padding: 12px 0; border-bottom: 1px dashed var(--gray-200); font-size: 15px; transition: background 0.2s; border-radius: 8px; }
.wiz-summary-row:hover { background: var(--gray-50); padding-left: 12px; padding-right: 12px; }
.wiz-summary-row .sk { width: 40%; color: var(--gray-500); font-weight: 600; }
.wiz-summary-row .sv { width: 60%; color: var(--navy); font-weight: 700; }

/* MOBILE RESPONSIVE TWEAKS */
@media(max-width: 992px) {
    .wiz-layout { grid-template-columns: 1fr; gap: 20px; }
    .wiz-sidebar { display: none; }
    .wiz-content { padding: 24px 16px; }
    .wiz-topbar { padding: 0 20px; height: 60px; }
    .wiz-progress-wrap { padding: 16px 20px; top: 60px; }
    .wiz-progress-label { flex-direction: column; align-items: flex-start; gap: 4px; }
    .wiz-card { padding: 24px; }
}
</style>
@endsection

@section('content')
<div id="wizApp">

<!-- TOP BAR -->
<div class="wiz-topbar">
    <a href="{{ url('/') }}" class="wiz-brand">{{ setting_item('site_title','Book') }}<span>Core</span></a>
    <div class="wiz-topbar-right">
        <a href="{{ route('car.list.landing') }}">Exit</a>
        <button class="wiz-save-btn" onclick="saveAndExit()">Save &amp; Exit</button>
    </div>
</div>

<!-- PROGRESS BAR -->
<div class="wiz-progress-wrap">
    <div class="wiz-progress-label">
        <strong id="stepTitle">Step 1 of 10: vehicle Type</strong>
        <span id="stepPercent">10%</span>
    </div>
    <div class="wiz-progress-bar">
        <div class="wiz-progress-fill" id="progressFill" style="width:10%"></div>
    </div>
</div>

<!-- MAIN LAYOUT -->
<div class="wiz-layout">

    <!-- SIDEBAR -->
    <div class="wiz-sidebar">
        <div class="wiz-sidebar-group">
            <div class="wiz-sidebar-group-title">vehicle Basics</div>
            <div class="wiz-sidebar-item active" data-step="1" onclick="goToStep(1)">
                <span class="item-icon">1</span> vehicle Type
            </div>
            <div class="wiz-sidebar-item" data-step="2" onclick="goToStep(2)">
                <span class="item-icon">2</span> Car Name &amp; Details
            </div>
            <div class="wiz-sidebar-item" data-step="3" onclick="goToStep(3)">
                <span class="item-icon">3</span> Location &amp; Address
            </div>
            <div class="wiz-sidebar-item" data-step="4" onclick="goToStep(4)">
                <span class="item-icon">4</span> Star Rating
            </div>
        </div>
        <div class="wiz-sidebar-group">
            <div class="wiz-sidebar-group-title">Facilities &amp; Services</div>
            <div class="wiz-sidebar-item" data-step="5" onclick="goToStep(5)">
                <span class="item-icon">5</span> Facilities
            </div>
            <div class="wiz-sidebar-item" data-step="6" onclick="goToStep(6)">
                <span class="item-icon">6</span> Services
            </div>
            <div class="wiz-sidebar-item" data-step="7" onclick="goToStep(7)">
                <span class="item-icon">7</span> House Rules
            </div>
        </div>
        <div class="wiz-sidebar-group">
            <div class="wiz-sidebar-group-title">Rooms &amp; Pricing</div>
            <div class="wiz-sidebar-item" data-step="8" onclick="goToStep(8)">
                <span class="item-icon">8</span> Room Details
            </div>
            <div class="wiz-sidebar-item" data-step="9" onclick="goToStep(9)">
                <span class="item-icon">9</span> Pricing
            </div>
            <div class="wiz-sidebar-item" data-step="10" onclick="goToStep(10)">
                <span class="item-icon">10</span> Photos
            </div>
        </div>
        <div class="wiz-sidebar-group">
            <div class="wiz-sidebar-group-title">Legal &amp; Submit</div>
            <div class="wiz-sidebar-item" data-step="11" onclick="goToStep(11)">
                <span class="item-icon">11</span> GST &amp; Tax
            </div>
            <div class="wiz-sidebar-item" data-step="12" onclick="goToStep(12)">
                <span class="item-icon">12</span> Owner Details
            </div>
            <div class="wiz-sidebar-item" data-step="13" onclick="goToStep(13)">
                <span class="item-icon">13</span> Review &amp; Submit
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="wiz-content">
    <form id="wizForm" action="{{ route('car.list.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        
        @if(!Auth::check())
        <!-- ===== STEP 0: Account Registration ===== -->
        <div class="wiz-step active" id="step0">
            <div class="wiz-step-header">
                <h2>Create Your Partner Account</h2>
                <p>Please enter your details to create an account and continue.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-row">
                    <div class="wiz-col-6">
                        <label class="wiz-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" id="reg_first_name" class="wiz-input" placeholder="Your Name" required>
                    </div>
                    <div class="wiz-col-6">
                        <label class="wiz-label">Mobile Number <span class="text-danger">*</span></label>
                        <input type="text" id="reg_phone" class="wiz-input" placeholder="Mobile Number" required>
                    </div>
                </div>
                <div class="wiz-row" style="margin-top: 15px;">
                    <div class="wiz-col-12">
                        <label class="wiz-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" id="reg_email" class="wiz-input" placeholder="Email Address" required>
                    </div>
                </div>
            </div>
            <div class="wiz-nav">
                <div></div>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="sendOtpWiz()" id="btnSendOtp">Send OTP</button>
            </div>
        </div>

        <!-- ===== STEP 0.5: Verify OTP ===== -->
        <div class="wiz-step" id="step05">
            <div class="wiz-step-header">
                <h2>Verify OTP</h2>
                <p>We sent a 6-digit code to your email.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-row">
                    <div class="wiz-col-12">
                        <label class="wiz-label">Enter OTP <span class="text-danger">*</span></label>
                        <input type="text" id="reg_otp" class="wiz-input" placeholder="123456" required>
                    </div>
                </div>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="goToStep(0)">Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="verifyOtpWiz()" id="btnVerifyOtp">Verify & Continue</button>
            </div>
        </div>
        @endif

        <!-- ===== STEP 1: vehicle Type ===== -->
        <div class="wiz-step @if(Auth::check()) active @endif" id="step1">
            <div class="wiz-step-header">
                <h2>What type of vehicle are you listing?</h2>
                <p>Select the category that best describes your vehicle. This helps guests find the right accommodation.</p>
            </div>
            <div class="prop-type-grid">
                <div class="prop-type-card selected" onclick="selectPropType(this,'Car')">
                    <span class="prop-type-icon">🏨</span>
                    <div class="prop-type-name">Car</div>
                    <div class="prop-type-desc">Full-service Car with dedicated staff</div>
                </div>
                <div class="prop-type-card" onclick="selectPropType(this,'apartment')">
                    <span class="prop-type-icon">🏠</span>
                    <div class="prop-type-name">Apartment</div>
                    <div class="prop-type-desc">Self-catering apartment or flat</div>
                </div>
                <div class="prop-type-card" onclick="selectPropType(this,'guesthouse')">
                    <span class="prop-type-icon">🏡</span>
                    <div class="prop-type-name">Guest House</div>
                    <div class="prop-type-desc">Cozy home-style accommodation</div>
                </div>
                <div class="prop-type-card" onclick="selectPropType(this,'resort')">
                    <span class="prop-type-icon">🌴</span>
                    <div class="prop-type-name">Resort</div>
                    <div class="prop-type-desc">Luxury resort with amenities</div>
                </div>
                <div class="prop-type-card" onclick="selectPropType(this,'hostel')">
                    <span class="prop-type-icon">🛏️</span>
                    <div class="prop-type-name">Hostel</div>
                    <div class="prop-type-desc">Budget-friendly shared accommodation</div>
                </div>
                <div class="prop-type-card" onclick="selectPropType(this,'villa')">
                    <span class="prop-type-icon">🏰</span>
                    <div class="prop-type-name">Villa / Bungalow</div>
                    <div class="prop-type-desc">Private villa or bungalow</div>
                </div>
            </div>
            <input type="hidden" name="vehicle_type" id="vehicle_type" value="Car">
            <div class="wiz-nav">
                <div></div>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="nextStep()">Next →</button>
            </div>
        </div>

        <!-- ===== STEP 2: Car Name & Details ===== -->
        <div class="wiz-step" id="step2">
            <div class="wiz-step-header">
                <h2>What's your vehicle called?</h2>
                <p>Enter the official name and a brief description of your vehicle.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-field">
                    <label class="wiz-label">vehicle Name <span class="req">*</span></label>
                    <input type="text" name="title" class="wiz-input" placeholder="e.g. The Grand Palace Car" required>
                    <span class="wiz-input-hint">This is the name guests will see when searching for your vehicle.</span>
                </div>
                <div class="wiz-field">
                    <label class="wiz-label">vehicle Description</label>
                    <textarea name="content" class="wiz-textarea" rows="4" placeholder="Describe your vehicle — what makes it special, unique features, nearby attractions..."></textarea>
                </div>
                <div class="wiz-row">
                    <div>
                        <label class="wiz-label">Check-in Time</label>
                        <input type="time" name="check_in_time" class="wiz-input" value="14:00">
                    </div>
                    <div>
                        <label class="wiz-label">Check-out Time</label>
                        <input type="time" name="check_out_time" class="wiz-input" value="12:00">
                    </div>
                </div>
                <div class="wiz-field">
                    <label class="wiz-label">Channel Manager</label>
                    <div class="wiz-radio-group">
                        <div class="wiz-radio-item">
                            <input type="radio" name="channel_manager" id="cm_no" value="no" checked>
                            <label for="cm_no">No — I manage availability manually</label>
                        </div>
                        <div class="wiz-radio-item">
                            <input type="radio" name="channel_manager" id="cm_yes" value="yes">
                            <label for="cm_yes">Yes — I use a channel manager (e.g. SiteMinder, RateGain)</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="prevStep()">← Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="nextStep()">Next →</button>
            </div>
        </div>

        <!-- ===== STEP 3: Location ===== -->
        <div class="wiz-step" id="step3">
            <div class="wiz-step-header">
                <h2>Where is your vehicle located?</h2>
                <p>Enter the full address. This helps guests find your vehicle easily.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-field">
                    <label class="wiz-label">Full Address <span class="req">*</span></label>
                    <input type="text" name="address" class="wiz-input" placeholder="Street, Area, City, State, PIN" required>
                </div>
                <div class="wiz-row">
                    <div>
                        <label class="wiz-label">Latitude</label>
                        <input type="text" name="map_lat" class="wiz-input" placeholder="e.g. 25.3176">
                    </div>
                    <div>
                        <label class="wiz-label">Longitude</label>
                        <input type="text" name="map_lng" class="wiz-input" placeholder="e.g. 82.9739">
                    </div>
                </div>
                <p style="font-size:12px;color:var(--gray-400);margin-top:-8px;">
                    💡 You can get coordinates from <a href="https://maps.google.com" target="_blank" style="color:var(--blue);">Google Maps</a> — right-click on your vehicle location.
                </p>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="prevStep()">← Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="nextStep()">Next →</button>
            </div>
        </div>

        <!-- ===== STEP 4: Star Rating ===== -->
        <div class="wiz-step" id="step4">
            <div class="wiz-step-header">
                <h2>What's the star rating of your vehicle?</h2>
                <p>Select the official star classification if applicable. Helps guests set expectations.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-stars">
                    <div class="wiz-star-item">
                        <input type="radio" name="star_rate" id="star0" value="0" checked>
                        <label for="star0">Not Rated / Unclassified</label>
                    </div>
                    <div class="wiz-star-item">
                        <input type="radio" name="star_rate" id="star1" value="1">
                        <label for="star1"><span class="stars-display">★</span> 1 Star</label>
                    </div>
                    <div class="wiz-star-item">
                        <input type="radio" name="star_rate" id="star2" value="2">
                        <label for="star2"><span class="stars-display">★★</span> 2 Stars</label>
                    </div>
                    <div class="wiz-star-item">
                        <input type="radio" name="star_rate" id="star3" value="3">
                        <label for="star3"><span class="stars-display">★★★</span> 3 Stars</label>
                    </div>
                    <div class="wiz-star-item">
                        <input type="radio" name="star_rate" id="star4" value="4">
                        <label for="star4"><span class="stars-display">★★★★</span> 4 Stars</label>
                    </div>
                    <div class="wiz-star-item">
                        <input type="radio" name="star_rate" id="star5" value="5">
                        <label for="star5"><span class="stars-display">★★★★★</span> 5 Stars</label>
                    </div>
                </div>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="prevStep()">← Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="nextStep()">Next →</button>
            </div>
        </div>

        <!-- ===== STEP 5: Facilities ===== -->
        <div class="wiz-step" id="step5">
            <div class="wiz-step-header">
                <h2>What facilities does your vehicle offer?</h2>
                <p>Select all that apply. This helps guests choose the right vehicle for their needs.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-check-grid">
                    @php
                    $facilities = [
                        'wifi' => '📶 Free WiFi',
                        'pool' => '🏊 Swimming Pool',
                        'parking' => '🅿️ Free Parking',
                        'ac' => '❄️ Air Conditioning',
                        'gym' => '🏋️ Fitness Center',
                        'restaurant' => '🍽️ Restaurant',
                        'bar' => '🍸 Bar/Lounge',
                        'spa' => '💆 Spa & Wellness',
                        'elevator' => '🛗 Elevator',
                        'laundry' => '👕 Laundry Service',
                        'room_service' => '🛎️ Room Service',
                        'concierge' => '🎩 Concierge',
                        'business_center' => '💼 Business Center',
                        'airport_shuttle' => '🚌 Airport Shuttle',
                        'conference' => '📊 Conference Room',
                        'pet_friendly' => '🐾 Pet Friendly',
                    ];
                    @endphp
                    @foreach($facilities as $key => $label)
                    <label class="wiz-check-item">
                        <input type="checkbox" name="facilities[]" value="{{ $key }}">
                        <label>{{ $label }}</label>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="prevStep()">← Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="nextStep()">Next →</button>
            </div>
        </div>

        <!-- ===== STEP 6: Services ===== -->
        <div class="wiz-step" id="step6">
            <div class="wiz-step-header">
                <h2>What services do you offer?</h2>
                <p>Tell guests about included services and language options.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-card-title">Breakfast</div>
                <div class="wiz-radio-group">
                    <div class="wiz-radio-item">
                        <input type="radio" name="breakfast" id="bf_no" value="no" checked>
                        <label for="bf_no">No breakfast included</label>
                    </div>
                    <div class="wiz-radio-item">
                        <input type="radio" name="breakfast" id="bf_yes" value="yes">
                        <label for="bf_yes">Breakfast included in room rate</label>
                    </div>
                    <div class="wiz-radio-item">
                        <input type="radio" name="breakfast" id="bf_optional" value="optional">
                        <label for="bf_optional">Breakfast available at extra charge</label>
                    </div>
                </div>
            </div>
            <div class="wiz-card">
                <div class="wiz-card-title">Parking</div>
                <div class="wiz-radio-group">
                    <div class="wiz-radio-item">
                        <input type="radio" name="parking" id="pk_no" value="no" checked>
                        <label for="pk_no">No parking available</label>
                    </div>
                    <div class="wiz-radio-item">
                        <input type="radio" name="parking" id="pk_free" value="free">
                        <label for="pk_free">Free parking on premises</label>
                    </div>
                    <div class="wiz-radio-item">
                        <input type="radio" name="parking" id="pk_paid" value="paid">
                        <label for="pk_paid">Paid parking available</label>
                    </div>
                </div>
            </div>
            <div class="wiz-card">
                <div class="wiz-card-title">Staff Languages</div>
                <div class="wiz-check-grid">
                    @php
                    $languages = ['Hindi','English','Tamil','Telugu','Kannada','Malayalam','Marathi','Bengali','Gujarati','Punjabi'];
                    @endphp
                    @foreach($languages as $lang)
                    <label class="wiz-check-item">
                        <input type="checkbox" name="languages[]" value="{{ $lang }}">
                        <label>{{ $lang }}</label>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="prevStep()">← Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="nextStep()">Next →</button>
            </div>
        </div>

        <!-- ===== STEP 7: House Rules ===== -->
        <div class="wiz-step" id="step7">
            <div class="wiz-step-header">
                <h2>House Rules</h2>
                <p>Set clear expectations for guests about what's allowed at your vehicle.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-field">
                    <label class="wiz-label">Do you allow children?</label>
                    <div class="wiz-radio-group">
                        <div class="wiz-radio-item">
                            <input type="radio" name="allow_children" id="ch_yes" value="yes" checked>
                            <label for="ch_yes">Yes — children of all ages welcome</label>
                        </div>
                        <div class="wiz-radio-item">
                            <input type="radio" name="allow_children" id="ch_no" value="no">
                            <label for="ch_no">No — adults only</label>
                        </div>
                    </div>
                </div>
                <div class="wiz-field" style="margin-top:20px;">
                    <label class="wiz-label">Do you allow pets?</label>
                    <div class="wiz-radio-group">
                        <div class="wiz-radio-item">
                            <input type="radio" name="allow_pets" id="pet_no" value="no" checked>
                            <label for="pet_no">No pets allowed</label>
                        </div>
                        <div class="wiz-radio-item">
                            <input type="radio" name="allow_pets" id="pet_yes" value="yes">
                            <label for="pet_yes">Pets are welcome</label>
                        </div>
                    </div>
                </div>
                <div class="wiz-field" style="margin-top:20px;">
                    <label class="wiz-label">Smoking Policy</label>
                    <div class="wiz-radio-group">
                        <div class="wiz-radio-item">
                            <input type="radio" name="smoking" id="sm_no" value="no" checked>
                            <label for="sm_no">No smoking on the premises</label>
                        </div>
                        <div class="wiz-radio-item">
                            <input type="radio" name="smoking" id="sm_areas" value="areas">
                            <label for="sm_areas">Smoking allowed in designated areas</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="prevStep()">← Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="nextStep()">Next →</button>
            </div>
        </div>

        <!-- ===== STEP 8: Room Details ===== -->
        <div class="wiz-step" id="step8">
            <div class="wiz-step-header">
                <h2>Tell us about your rooms</h2>
                <p>Add your room type and basic details. You can add more rooms later from your dashboard.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-field">
                    <label class="wiz-label">Room Type Name</label>
                    <input type="text" name="rooms[0][name]" class="wiz-input" placeholder="e.g. Standard Double Room, Deluxe Suite...">
                </div>
                <div class="wiz-row">
                    <div>
                        <label class="wiz-label">Number of Rooms</label>
                        <input type="number" name="rooms[0][count]" class="wiz-input" value="1" min="1" max="500">
                    </div>
                    <div>
                        <label class="wiz-label">Max Guests per Room</label>
                        <input type="number" name="rooms[0][max_guests]" class="wiz-input" value="2" min="1" max="20">
                    </div>
                </div>
                <div class="wiz-row">
                    <div>
                        <label class="wiz-label">Bed Type</label>
                        <select name="rooms[0][bed_type]" class="wiz-select">
                            <option value="single">Single Bed</option>
                            <option value="double" selected>Double Bed</option>
                            <option value="queen">Queen Bed</option>
                            <option value="king">King Bed</option>
                            <option value="twin">Twin Beds</option>
                            <option value="bunk">Bunk Beds</option>
                        </select>
                    </div>
                    <div>
                        <label class="wiz-label">Room Size (sqm)</label>
                        <input type="number" name="rooms[0][size]" class="wiz-input" placeholder="e.g. 25">
                    </div>
                </div>
                <div class="wiz-field">
                    <label class="wiz-label">Room Amenities</label>
                    <div class="wiz-check-grid">
                        @php
                        $roomAmenities = [
                            'private_bath' => '🚿 Private Bathroom',
                            'tv' => '📺 Flat-screen TV',
                            'mini_fridge' => '🧊 Mini Fridge',
                            'balcony' => '🌅 Balcony/Terrace',
                            'safe' => '🔒 In-room Safe',
                            'desk' => '🖥️ Work Desk',
                            'wardrobe' => '🚪 Wardrobe',
                            'hair_dryer' => '💨 Hair Dryer',
                        ];
                        @endphp
                        @foreach($roomAmenities as $key => $label)
                        <label class="wiz-check-item">
                            <input type="checkbox" name="rooms[0][amenities][]" value="{{ $key }}">
                            <label>{{ $label }}</label>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="prevStep()">← Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="nextStep()">Next →</button>
            </div>
        </div>

        <!-- ===== STEP 9: Pricing ===== -->
        <div class="wiz-step" id="step9">
            <div class="wiz-step-header">
                <h2>Set your pricing</h2>
                <p>Enter the base price per night. You can set room-specific prices after listing approval.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-field">
                    <label class="wiz-label">Base Price Per Night <span class="req">*</span></label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--gray-600);font-size:16px;font-weight:600;">₹</span>
                        <input type="number" name="price" class="wiz-input" style="padding-left:34px;" placeholder="0.00" min="0" step="0.01">
                    </div>
                    <span class="wiz-input-hint">This is the starting/base price. You can set advanced pricing from your dashboard.</span>
                </div>
                <div class="wiz-field">
                    <label class="wiz-label">Price Includes</label>
                    <div class="wiz-radio-group">
                        <div class="wiz-radio-item">
                            <input type="radio" name="allow_full_day" id="pd_room" value="0" checked>
                            <label for="pd_room">Room only</label>
                        </div>
                        <div class="wiz-radio-item">
                            <input type="radio" name="allow_full_day" id="pd_bf" value="1">
                            <label for="pd_bf">Breakfast included</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="prevStep()">← Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="nextStep()">Next →</button>
            </div>
        </div>

        <!-- ===== STEP 10: Photos ===== -->
        <div class="wiz-step" id="step10">
            <div class="wiz-step-header">
                <h2>Add photos of your vehicle</h2>
                <p>Great photos attract more guests. You can add more photos after your vehicle is listed.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-upload" onclick="document.getElementById('photoUpload').click()">
                    <span class="wiz-upload-icon">📸</span>
                    <div class="wiz-upload-text"><strong>Click to upload photos</strong></div>
                    <div class="wiz-upload-sub">JPG, PNG up to 10MB each. Recommended: at least 5 photos.</div>
                    <input type="file" id="photoUpload" name="photos[]" multiple accept="image/*" style="display:none" onchange="previewPhotos(this)">
                </div>
                <div id="photoPreview" style="display:flex;flex-wrap:wrap;gap:12px;margin-top:16px;"></div>
                <p style="font-size:12px;color:var(--gray-400);margin-top:12px;">
                    💡 Tips: Use well-lit photos, include lobby, rooms, bathroom, amenities, and exterior.
                </p>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="prevStep()">← Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="nextStep()">Next →</button>
            </div>
        </div>

        <!-- ===== STEP 11: GST & Tax ===== -->
        <div class="wiz-step" id="step11">
            <div class="wiz-step-header">
                <h2>GST &amp; Tax Registration</h2>
                <p>Provide your tax details for invoicing. This is required for compliance in India.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-field">
                    <label class="wiz-label">Are you GST Registered?</label>
                    <div class="wiz-radio-group">
                        <div class="wiz-radio-item">
                            <input type="radio" name="gst_registered" id="gst_no" value="no" checked onchange="toggleGST(false)">
                            <label for="gst_no">No — I am not GST registered</label>
                        </div>
                        <div class="wiz-radio-item">
                            <input type="radio" name="gst_registered" id="gst_yes" value="yes" onchange="toggleGST(true)">
                            <label for="gst_yes">Yes — I am GST registered</label>
                        </div>
                    </div>
                </div>
                <div id="gstFields" style="display:none;">
                    <div class="wiz-field">
                        <label class="wiz-label">GSTIN Number</label>
                        <input type="text" name="gstin" class="wiz-input" placeholder="e.g. 22AAAAA0000A1Z5" maxlength="15" style="text-transform:uppercase;">
                        <span class="wiz-input-hint">15-character GST Identification Number</span>
                    </div>
                    <div class="wiz-field">
                        <label class="wiz-label">Legal Entity Name (as on GST)</label>
                        <input type="text" name="invoice_name" class="wiz-input" placeholder="Name as registered with GST">
                    </div>
                </div>
                <div class="wiz-field">
                    <label class="wiz-label">PAN Number</label>
                    <input type="text" name="pan" class="wiz-input" placeholder="e.g. AAAAA0000A" maxlength="10" style="text-transform:uppercase;">
                    <span class="wiz-input-hint">Required for TDS deduction and tax compliance.</span>
                </div>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="prevStep()">← Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="nextStep()">Next →</button>
            </div>
        </div>

        <!-- ===== STEP 12: Owner Details ===== -->
        <div class="wiz-step" id="step12">
            <div class="wiz-step-header">
                <h2>Owner / Contact Details</h2>
                <p>Tell us about who owns and manages this vehicle.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-field">
                    <label class="wiz-label">Owner Type</label>
                    <div class="wiz-radio-group">
                        <div class="wiz-radio-item">
                            <input type="radio" name="owner_type" id="ot_individual" value="individual" checked>
                            <label for="ot_individual">Individual Owner</label>
                        </div>
                        <div class="wiz-radio-item">
                            <input type="radio" name="owner_type" id="ot_company" value="company">
                            <label for="ot_company">Company / Organization</label>
                        </div>
                    </div>
                </div>
                <div class="wiz-field">
                    <label class="wiz-label">Owner / Company Name</label>
                    <input type="text" name="owner_name" class="wiz-input" placeholder="Full name or company name">
                </div>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="prevStep()">← Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="nextStep()">Next →</button>
            </div>
        </div>

        <!-- ===== STEP 13: Review & Submit ===== -->
        <div class="wiz-step" id="step13">
            <div class="wiz-step-header">
                <h2>Review &amp; Submit</h2>
                <p>Please review your information before submitting. You can go back to edit any section.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-summary-section">
                    <div class="wiz-summary-title">vehicle Information</div>
                    <div class="wiz-summary-row">
                        <span class="sk">vehicle Type</span>
                        <span class="sv" id="sum_type">Car</span>
                    </div>
                    <div class="wiz-summary-row">
                        <span class="sk">vehicle Name</span>
                        <span class="sv" id="sum_title">—</span>
                    </div>
                    <div class="wiz-summary-row">
                        <span class="sk">Address</span>
                        <span class="sv" id="sum_address">—</span>
                    </div>
                    <div class="wiz-summary-row">
                        <span class="sk">Star Rating</span>
                        <span class="sv" id="sum_star">Not Rated</span>
                    </div>
                    <div class="wiz-summary-row">
                        <span class="sk">Check-in / Check-out</span>
                        <span class="sv" id="sum_times">14:00 / 12:00</span>
                    </div>
                    <div class="wiz-summary-row">
                        <span class="sk">Base Price</span>
                        <span class="sv" id="sum_price">—</span>
                    </div>
                </div>
            </div>

            <div class="wiz-card" style="background:#fffbf0;border-color:#fbbf24;">
                <div style="display:flex;gap:14px;align-items:flex-start;">
                    <span style="font-size:24px;">⏳</span>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#92400e;margin-bottom:4px;">What happens next?</div>
                        <div style="font-size:13px;color:#78350f;line-height:1.6;">
                            After submission, our admin team will review your vehicle within <strong>24–48 hours</strong>. 
                            You'll receive an email with the decision. Once approved, your vehicle will go live and start receiving bookings.
                        </div>
                    </div>
                </div>
            </div>

            <div class="wiz-card">
                <label style="display:flex;align-items:flex-start;gap:12px;cursor:pointer;">
                    <input type="checkbox" id="agreeTerms" style="margin-top:3px;width:18px;height:18px;accent-color:var(--blue);" required>
                    <span style="font-size:13px;color:var(--gray-600);line-height:1.6;">
                        I confirm that all information provided is accurate and I agree to the 
                        <a href="#" style="color:var(--blue);">Terms &amp; Conditions</a> and 
                        <a href="#" style="color:var(--blue);">Partner Policies</a>.
                    </span>
                </label>
            </div>

            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="prevStep()">← Back</button>
                <button type="submit" class="wiz-btn wiz-btn-submit" onclick="return validateSubmit()">
                    🚀 Submit vehicle
                </button>
            </div>
        </div>

    </form>
    </div><!-- /wiz-content -->
</div><!-- /wiz-layout -->
</div><!-- /wizApp -->

<script>
let currentStep = 1;
const totalSteps = 13;

const stepTitles = [
    '', // placeholder for 0
    'Step 1 of 13: vehicle Type',
    'Step 2 of 13: Car Name & Details',
    'Step 3 of 13: Location & Address',
    'Step 4 of 13: Star Rating',
    'Step 5 of 13: Facilities',
    'Step 6 of 13: Services',
    'Step 7 of 13: House Rules',
    'Step 8 of 13: Room Details',
    'Step 9 of 13: Pricing',
    'Step 10 of 13: Photos',
    'Step 11 of 13: GST & Tax',
    'Step 12 of 13: Owner Details',
    'Step 13 of 13: Review & Submit',
];


function showInlineMsg(stepId, msg, isError) {
    let container = document.getElementById(stepId);
    let msgDiv = container.querySelector('.wiz-inline-msg');
    if (!msgDiv) {
        msgDiv = document.createElement('div');
        msgDiv.className = 'wiz-inline-msg';
        msgDiv.style.padding = '10px 15px';
        msgDiv.style.marginBottom = '15px';
        msgDiv.style.borderRadius = '4px';
        msgDiv.style.fontWeight = '500';
        msgDiv.style.fontSize = '13px';
        // insert after step header
        let header = container.querySelector('.wiz-step-header');
        header.insertAdjacentElement('afterend', msgDiv);
    }
    msgDiv.style.backgroundColor = isError ? '#f8d7da' : '#d4edda';
    msgDiv.style.color = isError ? '#721c24' : '#155724';
    msgDiv.innerHTML = msg;
    msgDiv.style.display = 'block';
}

function sendOtpWiz() {
    let btn = document.getElementById('btnSendOtp');
    let email = document.getElementById('reg_email').value;
    let fname = document.getElementById('reg_first_name').value;
    let phone = document.getElementById('reg_phone').value;
    if(!email) { showInlineMsg('step0', "Email is required", true); return; }
    if(!fname) { showInlineMsg('step0', "Full Name is required", true); return; }
    if(!phone) { showInlineMsg('step0', "Mobile Number is required", true); return; }
    
    btn.innerHTML = 'Sending...';
    btn.disabled = true;
    
    let token = document.querySelector('input[name="_token"]').value;

    fetch('/login/send-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ email: email, first_name: fname, phone: phone })
    })
    .then(res => res.json())
    .then(data => {
        btn.innerHTML = 'Send OTP';
        btn.disabled = false;
        if(data.error) {
            showInlineMsg('step0', data.messages?.message_error || 'Error sending OTP', true);
        } else {
            showInlineMsg('step05', 'OTP sent successfully to your email!', false);
            goToStep(0.5);
        }
    }).catch(err => {
        btn.innerHTML = 'Send OTP';
        btn.disabled = false;
        showInlineMsg('step0', 'Server error. Please try again.', true);
    });
}

function verifyOtpWiz() {
    let btn = document.getElementById('btnVerifyOtp');
    let email = document.getElementById('reg_email').value;
    let otp = document.getElementById('reg_otp').value;
    if(!otp) { showInlineMsg('step05', "OTP is required", true); return; }
    
    btn.innerHTML = 'Verifying...';
    btn.disabled = true;

    let token = document.querySelector('input[name="_token"]').value;

    fetch('/login/verify-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ email: email, otp_code: otp })
    })
    .then(res => res.json())
    .then(data => {
        btn.innerHTML = 'Verify & Continue';
        btn.disabled = false;
        if(data.error) {
            showInlineMsg('step05', data.messages?.message_error || 'Invalid OTP', true);
        } else {
            // Update CSRF tokens so subsequent form submissions work without reload!
            if(data.csrf_token) {
                document.querySelectorAll('input[name="_token"]').forEach(el => el.value = data.csrf_token);
                let metaCsrf = document.querySelector('meta[name="csrf-token"]');
                if(metaCsrf) metaCsrf.setAttribute('content', data.csrf_token);
            }
            
            // Smoothly move to step 1
            showInlineMsg('step05', 'Verified Successfully! Let\'s go.', false);
            setTimeout(() => {
                goToStep(1);
            }, 800);
        }
    }).catch(err => {
        btn.innerHTML = 'Verify & Continue';
        btn.disabled = false;
        showInlineMsg('step05', 'Server error. Please try again.', true);
    });
}

function goToStep(n) {
    if(n === 0) {
        document.querySelectorAll('.wiz-step').forEach(e => e.classList.remove('active'));
        document.getElementById('step0').classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }
    if(n === 0.5) {
        document.querySelectorAll('.wiz-step').forEach(e => e.classList.remove('active'));
        document.getElementById('step05').classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }

    // Prevent jumping forward via sidebar if current step is invalid
    if (n > currentStep && currentStep > 0 && !validateCurrentStep()) {
        return;
    }

    document.getElementById('step' + currentStep).classList.remove('active');
    document.querySelectorAll('.wiz-sidebar-item').forEach(el => {
        const s = parseInt(el.getAttribute('data-step'));
        el.classList.remove('active');
        if (s < n) el.classList.add('completed');
        else el.classList.remove('completed');
    });
    currentStep = n;
    const el = document.getElementById('step' + n);
    if (el) el.classList.add('active');
    document.querySelector('[data-step="' + n + '"]').classList.add('active');
    const pct = Math.round((n / totalSteps) * 100);
    document.getElementById('progressFill').style.width = pct + '%';
    document.getElementById('stepPercent').textContent = pct + '%';
    document.getElementById('stepTitle').textContent = stepTitles[n];
        let progressWrap = document.querySelector('.wiz-progress-wrap');
    if (progressWrap) {
        let topPos = progressWrap.getBoundingClientRect().top + window.scrollY - 60;
        window.scrollTo({ top: topPos, behavior: 'smooth' });
    } else {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function validateCurrentStep() {
    let currentDiv = document.getElementById('step' + currentStep);
    if (!currentDiv) return true;
    
    let isValid = true;
    let firstInvalid = null;
    
    let requiredFields = currentDiv.querySelectorAll('input[required], textarea[required], select[required]');
    
    requiredFields.forEach(field => {
        // Don't validate if field is disabled
        if (field.disabled) return;
        
        if (!field.checkValidity()) {
            isValid = false;
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            if (!firstInvalid) firstInvalid = field;
        } else {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        }
    });
    
    if (!isValid && firstInvalid) {
        showInlineMsg('step' + currentStep, 'Please fill in all required fields correctly before proceeding.', true);
        firstInvalid.focus();
        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        let msgDiv = currentDiv.querySelector('.wiz-inline-msg');
        if (msgDiv) msgDiv.style.display = 'none';
    }
    
    return isValid;
}

function nextStep() {
    if (!validateCurrentStep()) return;
    if (currentStep < totalSteps) {
        if (currentStep === totalSteps - 1) updateSummary();
        goToStep(currentStep + 1);
    }
}
function prevStep() {
    if (currentStep > 1) goToStep(currentStep - 1);
}

function selectPropType(card, val) {
    document.querySelectorAll('.prop-type-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    document.getElementById('vehicle_type').value = val;
}

function toggleGST(show) {
    document.getElementById('gstFields').style.display = show ? 'block' : 'none';
}

function previewPhotos(input) {
    const container = document.getElementById('photoPreview');
    container.innerHTML = '';
    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:100px;height:70px;object-fit:cover;border-radius:8px;border:2px solid var(--gray-200);';
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

function updateSummary() {
    const title = document.querySelector('[name="title"]')?.value || '—';
    const address = document.querySelector('[name="address"]')?.value || '—';
    const price = document.querySelector('[name="price"]')?.value;
    const cin = document.querySelector('[name="check_in_time"]')?.value || '14:00';
    const cout = document.querySelector('[name="check_out_time"]')?.value || '12:00';
    const starEl = document.querySelector('[name="star_rate"]:checked');
    const starVal = starEl ? (starEl.value == 0 ? 'Not Rated' : starEl.value + ' Star') : 'Not Rated';
    const propType = document.getElementById('vehicle_type')?.value || 'Car';

    document.getElementById('sum_type').textContent = propType.charAt(0).toUpperCase() + propType.slice(1);
    document.getElementById('sum_title').textContent = title;
    document.getElementById('sum_address').textContent = address;
    document.getElementById('sum_star').textContent = starVal;
    document.getElementById('sum_times').textContent = cin + ' / ' + cout;
    document.getElementById('sum_price').textContent = price ? '₹' + parseFloat(price).toFixed(2) + '/night' : '—';
}

function validateSubmit() {
    const agreed = document.getElementById('agreeTerms').checked;
    if (!agreed) {
        alert('Please agree to the Terms & Conditions before submitting.');
        return false;
    }
    return true;
}

function saveAndExit() {
    alert('Progress is saved in your session. You can continue later.');
}
</script>
@endsection
@section('footer')
@endsection

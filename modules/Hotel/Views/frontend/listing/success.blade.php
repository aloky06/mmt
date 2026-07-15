@extends('Layout::app')
@section('head')
<title>{{ __('Property Submitted Successfully') }} — {{ setting_item('site_title','BookingCore') }}</title>
<style>
* { box-sizing: border-box; }
body { font-family: 'Poppins', sans-serif; background: #f8fafc; }
.success-wrap {
    min-height: 80vh; display: flex; align-items: center; justify-content: center;
    padding: 40px 20px;
}
.success-card {
    background: #fff; border-radius: 20px; padding: 56px 48px;
    text-align: center; max-width: 580px; width: 100%;
    box-shadow: 0 8px 40px rgba(0,53,128,0.10);
    border: 1px solid #e2e8f0;
}
.success-icon {
    width: 96px; height: 96px; border-radius: 50%;
    background: linear-gradient(135deg, #e8f4e8, #d1fae5);
    display: flex; align-items: center; justify-content: center;
    font-size: 48px; margin: 0 auto 28px;
    animation: popIn 0.5s ease;
}
@keyframes popIn {
    0% { transform: scale(0); opacity: 0; }
    80% { transform: scale(1.1); }
    100% { transform: scale(1); opacity: 1; }
}
.success-card h1 { font-size: 26px; font-weight: 800; color: #008009; margin-bottom: 12px; }
.success-card .subtitle { font-size: 15px; color: #475569; line-height: 1.7; margin-bottom: 28px; }

.timeline {
    background: #f8fafc; border-radius: 12px; padding: 20px 24px;
    text-align: left; margin-bottom: 28px; border: 1px solid #e2e8f0;
}
.timeline-item {
    display: flex; align-items: flex-start; gap: 14px; padding: 10px 0;
    border-bottom: 1px solid #f1f5f9;
}
.timeline-item:last-child { border-bottom: none; }
.timeline-dot {
    width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700;
}
.timeline-dot.done { background: #d1fae5; color: #008009; }
.timeline-dot.pending { background: #fff8e1; color: #d97706; }
.timeline-dot.upcoming { background: #f1f5f9; color: #94a3b8; }
.timeline-text strong { display: block; font-size: 13px; font-weight: 700; color: #1e293b; }
.timeline-text span { font-size: 12px; color: #64748b; }

.success-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.btn-primary-custom {
    background: #0071c2; color: #fff; padding: 12px 28px;
    border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 700;
    transition: all 0.2s;
}
.btn-primary-custom:hover { background: #005fa3; color: #fff; }
.btn-outline-custom {
    border: 1.5px solid #e2e8f0; color: #475569; padding: 12px 28px;
    border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600;
    transition: all 0.2s;
}
.btn-outline-custom:hover { border-color: #0071c2; color: #0071c2; }

@if($hotel)
.hotel-preview {
    background: #fff; border: 1.5px solid #e2e8f0; border-radius: 10px;
    padding: 16px 20px; margin-bottom: 20px; text-align: left;
    display: flex; align-items: center; gap: 14px;
}
.hotel-preview-icon { font-size: 32px; }
.hotel-preview-name { font-size: 15px; font-weight: 700; color: #1e293b; }
.hotel-preview-sub { font-size: 12px; color: #64748b; }
@endif
</style>
@endsection

@section('content')
<div class="success-wrap">
    <div class="success-card">
        <div class="success-icon">🎉</div>
        <h1>Property Submitted!</h1>
        <p class="subtitle">
            Congratulations! Your hotel has been successfully submitted for review.<br>
            Our admin team will verify your listing within <strong>24–48 hours</strong>.
        </p>

        @if($hotel)
        <div class="hotel-preview">
            <div class="hotel-preview-icon">🏨</div>
            <div>
                <div class="hotel-preview-name">{{ $hotel->title }}</div>
                <div class="hotel-preview-sub">{{ $hotel->address ?? 'Address not provided' }}</div>
            </div>
            <span style="margin-left:auto;background:#fff8e1;color:#92400e;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;">⏳ Pending Review</span>
        </div>
        @endif

        <!-- Timeline -->
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-dot done">✓</div>
                <div class="timeline-text">
                    <strong>Property Submitted</strong>
                    <span>Your application has been received successfully.</span>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot pending">2</div>
                <div class="timeline-text">
                    <strong>Admin Review (24–48 hrs)</strong>
                    <span>Our team will verify your property details and documents.</span>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot upcoming">3</div>
                <div class="timeline-text">
                    <strong>Approval &amp; Go Live</strong>
                    <span>Once approved, your property will appear in search results.</span>
                </div>
            </div>
        </div>

        <div class="success-actions">
            @if($hotel)
            <a href="{{ route('hotel.vendor.dashboard', ['id' => $hotel->id]) }}" class="btn-primary-custom">
                🏠 Go to Dashboard
            </a>
            @endif
            <a href="{{ route('hotel.vendor.index') }}" class="btn-outline-custom">
                📋 My Properties
            </a>
            <a href="{{ route('hotel.list.landing') }}" class="btn-outline-custom">
                + List Another
            </a>
        </div>

        <p style="font-size:12px;color:#94a3b8;margin-top:24px;">
            📧 You will receive an email notification once your property is approved or if additional information is needed.
        </p>
    </div>
</div>
@endsection
@section('footer')
@endsection

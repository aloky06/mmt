@extends('layouts.user')
@section('head')
<style>
/* ===== Hotel Owner Dashboard ===== */
:root {
    --navy: #003580;
    --blue: #0071c2;
    --blue-light: #e8f0fe;
    --green: #008009;
    --green-bg: #e8f4e8;
    --gold: #f5a623;
    --red: #dc2626;
    --red-bg: #fef2f2;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-600: #475569;
    --gray-800: #1e293b;
    --white: #ffffff;
}
* { box-sizing: border-box; }
body { font-family: 'Poppins', sans-serif; }

/* ---- DASHBOARD TOP TABS ---- */
.hd-tabs {
    background: var(--navy);
    display: flex; gap: 0; overflow-x: auto;
    padding: 0 24px;
}
.hd-tab {
    color: rgba(255,255,255,0.7); padding: 16px 20px;
    font-size: 13px; font-weight: 500; cursor: pointer;
    border-bottom: 3px solid transparent; text-decoration: none;
    white-space: nowrap; transition: all 0.2s;
}
.hd-tab:hover, .hd-tab.active {
    color: var(--white);
    border-bottom-color: var(--gold);
}

/* ---- PROPERTY HEADER ---- */
.hd-property-header {
    background: linear-gradient(135deg, var(--navy) 0%, #004a9e 100%);
    color: var(--white); padding: 28px 40px;
    display: flex; align-items: center; gap: 24px;
}
.hd-property-img {
    width: 80px; height: 80px; border-radius: 12px;
    overflow: hidden; flex-shrink: 0;
    border: 2px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.1);
    display: flex; align-items: center; justify-content: center; font-size: 32px;
}
.hd-property-img img { width:100%; height:100%; object-fit: cover; }
.hd-property-info h1 {
    font-size: 22px; font-weight: 700; margin-bottom: 4px;
}
.hd-property-meta {
    display: flex; flex-wrap: wrap; gap: 16px; margin-top: 8px;
}
.hd-meta-item {
    display: flex; align-items: center; gap: 6px;
    font-size: 13px; color: rgba(255,255,255,0.75);
}
.hd-status-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 14px; border-radius: 20px;
    font-size: 12px; font-weight: 700;
}
.hd-status-badge.pending {
    background: rgba(245,166,35,0.2); color: var(--gold);
    border: 1px solid rgba(245,166,35,0.4);
}
.hd-status-badge.live {
    background: rgba(0,128,9,0.2); color: #4ade80;
    border: 1px solid rgba(0,128,9,0.4);
}
.hd-property-actions { margin-left: auto; display: flex; gap: 10px; }
.hd-action-btn {
    background: rgba(255,255,255,0.1); border: 1.5px solid rgba(255,255,255,0.3);
    color: var(--white); padding: 10px 18px; border-radius: 8px;
    font-size: 13px; font-weight: 600; text-decoration: none;
    transition: all 0.2s; cursor: pointer; white-space: nowrap;
}
.hd-action-btn:hover { background: rgba(255,255,255,0.2); color: var(--white); }
.hd-action-btn.primary {
    background: var(--blue); border-color: var(--blue);
}

/* Pending Verification Banner */
.hd-pending-banner {
    background: linear-gradient(90deg, #fffbf0, #fff8e1);
    border: 1.5px solid #fbbf24; border-radius: 12px;
    padding: 18px 24px; margin: 24px;
    display: flex; align-items: center; gap: 16px;
}
.hd-pending-banner .icon { font-size: 28px; }
.hd-pending-banner h4 { font-size: 15px; font-weight: 700; color: #92400e; margin-bottom: 4px; }
.hd-pending-banner p { font-size: 13px; color: #78350f; margin: 0; }

/* ---- MAIN CONTENT ---- */
.hd-main { padding: 24px; background: var(--gray-50); min-height: calc(100vh - 280px); }

/* ---- STATS GRID ---- */
.hd-stats-grid {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 16px; margin-bottom: 24px;
}
.hd-stat-card {
    background: var(--white); border-radius: 14px;
    padding: 24px; border: 1px solid var(--gray-200);
    box-shadow: 0 1px 8px rgba(0,0,0,0.04);
    position: relative; overflow: hidden; transition: all 0.3s;
}
.hd-stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,53,128,0.1); }
.hd-stat-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0;
    height: 3px;
}
.hd-stat-card.blue::before { background: var(--blue); }
.hd-stat-card.green::before { background: var(--green); }
.hd-stat-card.gold::before { background: var(--gold); }
.hd-stat-card.red::before { background: var(--red); }
.hd-stat-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
.hd-stat-icon {
    width: 44px; height: 44px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
}
.hd-stat-card.blue .hd-stat-icon { background: var(--blue-light); }
.hd-stat-card.green .hd-stat-icon { background: var(--green-bg); }
.hd-stat-card.gold .hd-stat-icon { background: #fffbf0; }
.hd-stat-card.red .hd-stat-icon { background: var(--red-bg); }
.hd-stat-change {
    font-size: 11px; font-weight: 700; padding: 3px 8px;
    border-radius: 6px;
}
.hd-stat-change.up { background: var(--green-bg); color: var(--green); }
.hd-stat-change.neutral { background: var(--gray-100); color: var(--gray-600); }
.hd-stat-num { font-size: 28px; font-weight: 800; color: var(--gray-800); line-height: 1; }
.hd-stat-label { font-size: 13px; color: var(--gray-600); margin-top: 4px; }

/* ---- QUICK ACTIONS ---- */
.hd-quick-actions {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 12px; margin-bottom: 24px;
}
.hd-quick-btn {
    background: var(--white); border: 1.5px solid var(--gray-200);
    border-radius: 12px; padding: 20px; text-align: center;
    text-decoration: none; color: var(--gray-800);
    transition: all 0.3s; cursor: pointer;
}
.hd-quick-btn:hover {
    border-color: var(--blue); background: var(--blue-light);
    color: var(--blue); transform: translateY(-2px);
}
.hd-quick-btn .qb-icon { font-size: 28px; display: block; margin-bottom: 10px; }
.hd-quick-btn .qb-label { font-size: 13px; font-weight: 600; }

/* ---- MAIN GRID ---- */
.hd-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; }

/* ---- TABLES ---- */
.hd-card {
    background: var(--white); border-radius: 14px;
    border: 1px solid var(--gray-200);
    box-shadow: 0 1px 8px rgba(0,0,0,0.04);
    overflow: hidden;
}
.hd-card-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 20px 24px; border-bottom: 1px solid var(--gray-200);
}
.hd-card-header h3 { font-size: 16px; font-weight: 700; color: var(--gray-800); }
.hd-card-header a {
    font-size: 13px; color: var(--blue); text-decoration: none; font-weight: 600;
}
.hd-table { width: 100%; border-collapse: collapse; }
.hd-table th {
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.5px; color: var(--gray-600);
    padding: 12px 20px; text-align: left; background: var(--gray-50);
    border-bottom: 1px solid var(--gray-200);
}
.hd-table td {
    padding: 14px 20px; font-size: 13px; color: var(--gray-800);
    border-bottom: 1px solid var(--gray-100);
}
.hd-table tr:last-child td { border-bottom: none; }
.hd-table tr:hover td { background: var(--gray-50); }
.booking-status {
    display: inline-block; padding: 3px 10px; border-radius: 6px;
    font-size: 11px; font-weight: 700; text-transform: uppercase;
}
.booking-status.completed { background: var(--green-bg); color: var(--green); }
.booking-status.pending { background: #fffbf0; color: #92400e; }
.booking-status.cancelled { background: var(--red-bg); color: var(--red); }
.booking-status.confirmed { background: var(--blue-light); color: var(--blue); }
.no-data-wrap { padding: 40px; text-align: center; }
.no-data-wrap p { font-size: 14px; color: var(--gray-600); margin-top: 8px; }

/* ---- SIDEBAR CARDS ---- */
.hd-sidebar-card {
    background: var(--white); border-radius: 14px;
    border: 1px solid var(--gray-200); margin-bottom: 20px;
    overflow: hidden;
}
.hd-sidebar-card-title {
    font-size: 14px; font-weight: 700; color: var(--gray-800);
    padding: 16px 20px; border-bottom: 1px solid var(--gray-200);
}
.hd-info-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 12px 20px; border-bottom: 1px solid var(--gray-100);
    font-size: 13px;
}
.hd-info-row:last-child { border-bottom: none; }
.hd-info-row .key { color: var(--gray-600); }
.hd-info-row .val { font-weight: 600; color: var(--gray-800); }

/* Performance bar */
.hd-perf-item { padding: 14px 20px; border-bottom: 1px solid var(--gray-100); }
.hd-perf-item:last-child { border-bottom: none; }
.hd-perf-label { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px; }
.hd-perf-label span:first-child { color: var(--gray-600); }
.hd-perf-label span:last-child { font-weight: 700; color: var(--gray-800); }
.hd-perf-bar { height: 8px; background: var(--gray-200); border-radius: 4px; overflow: hidden; }
.hd-perf-fill { height: 100%; border-radius: 4px; transition: width 1s ease; }
.hd-perf-fill.blue { background: var(--blue); }
.hd-perf-fill.green { background: var(--green); }
.hd-perf-fill.gold { background: var(--gold); }

/* Responsive */
@media (max-width: 1100px) {
    .hd-grid { grid-template-columns: 1fr; }
    .hd-stats-grid { grid-template-columns: 1fr 1fr; }
    .hd-quick-actions { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 640px) {
    .hd-stats-grid { grid-template-columns: 1fr 1fr; }
    .hd-quick-actions { grid-template-columns: 1fr 1fr; }
    .hd-property-header { flex-direction: column; padding: 20px; }
    .hd-property-actions { margin-left: 0; }
    .hd-main { padding: 16px; }
    .hd-tabs { padding: 0 12px; }
}
</style>
@endsection

@section('content')

<!-- DASHBOARD TABS (Booking.com Extranet style) -->
<nav class="hd-tabs">
    <a class="hd-tab active" href="{{ route('hotel.vendor.dashboard', ['id' => $row->id]) }}">🏠 Home</a>
    <a class="hd-tab" href="{{ route('hotel.vendor.room.availability.index', ['hotel_id' => $row->id]) }}">📅 Rates &amp; Availability</a>
    <a class="hd-tab" href="{{ route('hotel.vendor.index') }}">📋 Reservations</a>
    <a class="hd-tab" href="{{ route('hotel.vendor.edit', ['id' => $row->id]) }}">🏨 Property</a>
    <a class="hd-tab" href="{{ route('hotel.vendor.room.index', ['hotel_id' => $row->id]) }}">🛏️ Rooms</a>
    <a class="hd-tab" href="{{ route('hotel.vendor.index') }}">💰 Finance</a>
</nav>

<!-- PROPERTY HEADER -->
<div class="hd-property-header">
    <div class="hd-property-img">
        @if($row->image_id)
            <img src="{{ \Modules\Media\Helpers\FileHelper::url($row->image_id, 'thumb') }}" alt="{{ $row->title }}">
        @else
            🏨
        @endif
    </div>
    <div class="hd-property-info">
        <h1>{{ $row->title }}</h1>
        <div class="hd-property-meta">
            @if($row->address)
            <span class="hd-meta-item">📍 {{ Str::limit($row->address, 50) }}</span>
            @endif
            @if($row->star_rate > 0)
            <span class="hd-meta-item">
                @for($i=0;$i<$row->star_rate;$i++)⭐@endfor
                {{ $row->star_rate }}-star hotel
            </span>
            @endif
            <span class="hd-status-badge {{ $row->status == 'publish' ? 'live' : 'pending' }}">
                {{ $row->status == 'publish' ? '🟢 Live' : '⏳ Pending Approval' }}
            </span>
        </div>
    </div>
    <div class="hd-property-actions">
        <a href="{{ route('hotel.vendor.edit', ['id' => $row->id]) }}" class="hd-action-btn">✏️ Edit Property</a>
        <a href="{{ route('hotel.vendor.room.create', ['hotel_id' => $row->id]) }}" class="hd-action-btn primary">+ Add Room</a>
    </div>
</div>

<!-- PENDING VERIFICATION BANNER -->
@if($row->status == 'pending')
<div class="hd-pending-banner">
    <span class="icon">⏳</span>
    <div>
        <h4>Your property is under review</h4>
        <p>Our admin team is reviewing your submission. This typically takes 24–48 hours. You'll receive an email once approved.</p>
    </div>
</div>
@endif

<!-- MAIN DASHBOARD -->
<div class="hd-main">

    <!-- STATS GRID -->
    <div class="hd-stats-grid">
        <div class="hd-stat-card blue">
            <div class="hd-stat-top">
                <div class="hd-stat-icon">📅</div>
                <span class="hd-stat-change up">Total</span>
            </div>
            <div class="hd-stat-num">{{ $totalBookings }}</div>
            <div class="hd-stat-label">Total Bookings</div>
        </div>
        <div class="hd-stat-card green">
            <div class="hd-stat-top">
                <div class="hd-stat-icon">✅</div>
                <span class="hd-stat-change up">Completed</span>
            </div>
            <div class="hd-stat-num">{{ $confirmedCount }}</div>
            <div class="hd-stat-label">Completed Stays</div>
        </div>
        <div class="hd-stat-card gold">
            <div class="hd-stat-top">
                <div class="hd-stat-icon">💰</div>
                <span class="hd-stat-change neutral">Revenue</span>
            </div>
            <div class="hd-stat-num">{{ format_money($totalRevenue) }}</div>
            <div class="hd-stat-label">Total Revenue</div>
        </div>
        <div class="hd-stat-card red">
            <div class="hd-stat-top">
                <div class="hd-stat-icon">⏰</div>
                <span class="hd-stat-change neutral">Pending</span>
            </div>
            <div class="hd-stat-num">{{ $pendingCount }}</div>
            <div class="hd-stat-label">Pending Bookings</div>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="hd-quick-actions">
        <a href="{{ route('hotel.vendor.room.create', ['hotel_id' => $row->id]) }}" class="hd-quick-btn">
            <span class="qb-icon">🛏️</span>
            <span class="qb-label">Add Room</span>
        </a>
        <a href="{{ route('hotel.vendor.room.availability.index', ['hotel_id' => $row->id]) }}" class="hd-quick-btn">
            <span class="qb-icon">📅</span>
            <span class="qb-label">Update Availability</span>
        </a>
        <a href="{{ route('hotel.vendor.edit', ['id' => $row->id]) }}" class="hd-quick-btn">
            <span class="qb-icon">✏️</span>
            <span class="qb-label">Edit Property</span>
        </a>
        <a href="{{ route('hotel.vendor.index') }}" class="hd-quick-btn">
            <span class="qb-icon">📊</span>
            <span class="qb-label">All Properties</span>
        </a>
    </div>

    <!-- MAIN GRID -->
    <div class="hd-grid">
        <!-- LEFT: Bookings Table -->
        <div>
            <div class="hd-card">
                <div class="hd-card-header">
                    <h3>📋 Recent Reservations</h3>
                    <a href="{{ route('hotel.vendor.index') }}">View all →</a>
                </div>
                @if($recentBookings->count() > 0)
                <table class="hd-table">
                    <thead>
                        <tr>
                            <th>Booking #</th>
                            <th>Guest</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                        <tr>
                            <td><strong>#{{ $booking->id }}</strong></td>
                            <td>
                                @if($booking->customer)
                                    {{ $booking->customer->name ?? '—' }}
                                @else
                                    Guest
                                @endif
                            </td>
                            <td>{{ $booking->start_date ? \Carbon\Carbon::parse($booking->start_date)->format('d M Y') : '—' }}</td>
                            <td>{{ $booking->end_date ? \Carbon\Carbon::parse($booking->end_date)->format('d M Y') : '—' }}</td>
                            <td><strong>{{ format_money($booking->total ?? 0) }}</strong></td>
                            <td>
                                <span class="booking-status {{ $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="no-data-wrap">
                    <div style="font-size:48px;">📭</div>
                    <p>No bookings yet.<br>Once your property is approved, bookings will appear here.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- RIGHT: Sidebar -->
        <div>
            <!-- Property Info -->
            <div class="hd-sidebar-card">
                <div class="hd-sidebar-card-title">🏨 Property Details</div>
                <div class="hd-info-row">
                    <span class="key">Status</span>
                    <span class="val">
                        @if($row->status == 'publish')
                        <span style="color:var(--green);">● Live</span>
                        @elseif($row->status == 'pending')
                        <span style="color:#d97706;">● Pending Review</span>
                        @else
                        <span style="color:#94a3b8;">● Draft</span>
                        @endif
                    </span>
                </div>
                @if($row->star_rate)
                <div class="hd-info-row">
                    <span class="key">Star Rating</span>
                    <span class="val">
                        @for($i=0;$i<$row->star_rate;$i++)⭐@endfor
                    </span>
                </div>
                @endif
                @if($row->check_in_time)
                <div class="hd-info-row">
                    <span class="key">Check-in</span>
                    <span class="val">{{ $row->check_in_time }}</span>
                </div>
                @endif
                @if($row->check_out_time)
                <div class="hd-info-row">
                    <span class="key">Check-out</span>
                    <span class="val">{{ $row->check_out_time }}</span>
                </div>
                @endif
                @if($row->price)
                <div class="hd-info-row">
                    <span class="key">Base Price</span>
                    <span class="val">{{ format_money($row->price) }}/night</span>
                </div>
                @endif
                <div class="hd-info-row" style="padding:16px 20px;">
                    <a href="{{ route('hotel.vendor.edit', ['id' => $row->id]) }}"
                       style="color:var(--blue);font-size:13px;font-weight:600;text-decoration:none;width:100%;text-align:center;display:block;">
                       ✏️ Edit property details →
                    </a>
                </div>
            </div>

            <!-- Performance -->
            <div class="hd-sidebar-card">
                <div class="hd-sidebar-card-title">📈 Performance</div>
                @php
                    $total = max($totalBookings, 1);
                    $occupancyRate = $totalBookings > 0 ? min(100, round(($confirmedCount / $total) * 100)) : 0;
                    $complete = 0;
                    if($row->title) $complete += 20;
                    if($row->address) $complete += 20;
                    if($row->content) $complete += 20;
                    if($row->image_id) $complete += 20;
                    if($row->price) $complete += 20;
                @endphp
                <div class="hd-perf-item">
                    <div class="hd-perf-label">
                        <span>Confirmed Rate</span>
                        <span>{{ $occupancyRate }}%</span>
                    </div>
                    <div class="hd-perf-bar">
                        <div class="hd-perf-fill blue" style="width:{{ $occupancyRate }}%"></div>
                    </div>
                </div>
                <div class="hd-perf-item">
                    <div class="hd-perf-label">
                        <span>Profile Completeness</span>
                        <span>{{ $complete }}%</span>
                    </div>
                    <div class="hd-perf-bar">
                        <div class="hd-perf-fill green" style="width:{{ $complete }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="hd-sidebar-card">
                <div class="hd-sidebar-card-title">🔗 Quick Links</div>
                @foreach([
                    ['icon' => '🛏️', 'label' => 'Manage Rooms', 'url' => route('hotel.vendor.room.index', ['hotel_id' => $row->id])],
                    ['icon' => '📅', 'label' => 'Room Availability', 'url' => route('hotel.vendor.room.availability.index', ['hotel_id' => $row->id])],
                    ['icon' => '✏️', 'label' => 'Edit Property', 'url' => route('hotel.vendor.edit', ['id' => $row->id])],
                    ['icon' => '📋', 'label' => 'All My Hotels', 'url' => route('hotel.vendor.index')],
                    ['icon' => '🏨', 'label' => 'List New Property', 'url' => route('hotel.list.landing')],
                ] as $link)
                <div class="hd-info-row" style="cursor:pointer;" onclick="window.location='{{ $link['url'] }}'">
                    <span>{{ $link['icon'] }} {{ $link['label'] }}</span>
                    <span style="color:var(--gray-600);">›</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
// Animate performance bars
document.querySelectorAll('.hd-perf-fill').forEach(bar => {
    const width = bar.style.width;
    bar.style.width = '0%';
    setTimeout(() => { bar.style.width = width; }, 300);
});

// Animate stat numbers
document.querySelectorAll('.hd-stat-num').forEach(el => {
    const text = el.textContent.trim();
    const num = parseFloat(text.replace(/[^0-9.]/g, ''));
    if (!isNaN(num) && num > 0) {
        el.style.opacity = '0';
        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transition = 'opacity 0.4s';
        }, 200);
    }
});
</script>
@endsection

@section('footer')
@endsection

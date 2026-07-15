{{-- ================================================================
     FULL-WIDTH CAB SEARCH FORM
================================================================ --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Premium Orange Theme for Flatpickr */
    .flatpickr-calendar.arrowTop:before { border-bottom-color: #ff5f1f !important; }
    .flatpickr-calendar.arrowTop:after { border-bottom-color: #ff5f1f !important; }
    .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange, .flatpickr-day.selected.inRange, .flatpickr-day.startRange.inRange, .flatpickr-day.endRange.inRange, .flatpickr-day.selected:focus, .flatpickr-day.startRange:focus, .flatpickr-day.endRange:focus, .flatpickr-day.selected:hover, .flatpickr-day.startRange:hover, .flatpickr-day.endRange:hover, .flatpickr-day.selected.prevMonthDay, .flatpickr-day.startRange.prevMonthDay, .flatpickr-day.endRange.prevMonthDay, .flatpickr-day.selected.nextMonthDay, .flatpickr-day.startRange.nextMonthDay, .flatpickr-day.endRange.nextMonthDay {
        background: #ff5f1f !important;
        border-color: #ff5f1f !important;
    }
    .flatpickr-day.inRange { box-shadow: -5px 0 0 #fff0ea, 5px 0 0 #fff0ea !important; background: #fff0ea !important; border-color: #fff0ea !important; }
    .flatpickr-day:hover { background: #fff0ea !important; border-color: #fff0ea !important; color: #1a1a2e !important; }
    .flatpickr-months .flatpickr-month { background: #ff5f1f !important; color: #fff !important; fill: #fff !important; }
    .flatpickr-current-month .flatpickr-monthDropdown-months { background: #ff5f1f !important; color: #fff !important; }
    .flatpickr-current-month .numInputWrapper span.arrowUp:after { border-bottom-color: #fff !important; }
    .flatpickr-current-month .numInputWrapper span.arrowDown:after { border-top-color: #fff !important; }
    .flatpickr-weekdays { background: #ff5f1f !important; }
    span.flatpickr-weekday { color: #fff !important; }
</style>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<form action="{{ route('car.search') }}" class="csf-form" method="get" id="goibibo-cab-form">

    {{-- ── TRIP TYPE TABS ──────────────────────────────── --}}
    <div class="csf-tabs-bar">
        <label class="csf-tab">
            <input type="radio" name="trip_type" value="outstation_one_way" checked>
            <span class="csf-tab-label"><i class="fa fa-arrow-right"></i> One-Way</span>
        </label>
        <label class="csf-tab">
            <input type="radio" name="trip_type" value="outstation_round_trip">
            <span class="csf-tab-label"><i class="fa fa-exchange"></i> Round Trip</span>
        </label>
        <label class="csf-tab">
            <input type="radio" name="trip_type" value="airport_transfer">
            <span class="csf-tab-label"><i class="fa fa-plane"></i> Airport Transfer</span>
        </label>
        <label class="csf-tab">
            <input type="radio" name="trip_type" value="hourly_rental">
            <span class="csf-tab-label"><i class="fa fa-clock-o"></i> Hourly Rental</span>
        </label>
    </div>

    {{-- ── MAIN FIELDS ROW ─────────────────────────────── --}}
    <div class="csf-fields-row" id="csf-main-row">

        {{-- FROM --}}
        <div class="csf-field csf-field-from" id="pickup_group">
            <div class="csf-field-inner" style="position:relative;" id="car-pickup-wrapper" onclick="document.getElementById('car-pickup-input').focus()">
                <span class="csf-label"><i class="fa fa-map-marker csf-dot csf-dot-blue"></i> From</span>
                <input type="text" id="car-pickup-input" class="csf-loc-input" placeholder="Pickup City or Area" autocomplete="off" onkeyup="searchCarLoc(this.value, 'pickup')" onclick="searchCarLoc(this.value, 'pickup')" value="{{ request()->query('pickup_name') }}">
                <input type="hidden" name="location_id" id="car_pickup_id" value="{{ request()->query('location_id') }}">
                <input type="hidden" name="pickup_name" id="car_pickup_name" value="{{ request()->query('pickup_name') }}">
                <div class="premium-autocomplete-dropdown" id="car-pickup-dropdown"></div>
            </div>
        </div>

        {{-- SWAP --}}
        <button type="button" class="csf-swap" id="swap_locations" title="Swap cities">
            <i class="fa fa-exchange"></i>
        </button>

        {{-- TO --}}
        <div class="csf-field csf-field-to" id="dropoff_group">
            <div class="csf-field-inner" style="position:relative;" id="car-dropoff-wrapper" onclick="document.getElementById('car-dropoff-input').focus()">
                <span class="csf-label"><i class="fa fa-map-marker csf-dot csf-dot-orange"></i> To</span>
                <input type="text" id="car-dropoff-input" class="csf-loc-input" placeholder="Dropoff City or Area" autocomplete="off" onkeyup="searchCarLoc(this.value, 'dropoff')" onclick="searchCarLoc(this.value, 'dropoff')" value="{{ request()->query('dropoff_name') }}">
                <input type="hidden" name="dropoff_location_id" id="car_dropoff_id" value="{{ request()->query('dropoff_location_id') }}">
                <input type="hidden" name="dropoff_name" id="car_dropoff_name" value="{{ request()->query('dropoff_name') }}">
                <div class="premium-autocomplete-dropdown" id="car-dropoff-dropdown"></div>
            </div>
        </div>

        {{-- DIVIDER --}}
        <div class="csf-vdivider" id="date-divider-1"></div>

        {{-- PICKUP DATE --}}
        <div class="csf-field csf-field-date" id="pickup_date_wrapper" style="cursor: pointer;">
            <div class="csf-field-inner" style="position:relative;">
                <span class="csf-label"><i class="fa fa-calendar csf-dot csf-dot-grey"></i> Pickup Date</span>
                <div class="csf-date-row-inner">
                    <span id="pickup_date_display" class="csf-date-val">{{ date('d M, Y', strtotime('+1 day')) }}</span>
                    <i class="fa fa-calendar-o csf-cal-icon"></i>
                    <input type="hidden" name="pickup_date" id="pickup_date_input" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>
            </div>
        </div>

        {{-- DIVIDER --}}
        <div class="csf-vdivider" id="date-divider-2"></div>

        {{-- PICKUP TIME --}}
        <div class="csf-field csf-field-time" id="pickup_time_wrapper" style="cursor: pointer;">
            <div class="csf-field-inner" style="position:relative;">
                <span class="csf-label"><i class="fa fa-clock-o csf-dot csf-dot-grey"></i> Pickup Time</span>
                <div class="csf-date-row-inner">
                    <span id="pickup_time_display" class="csf-date-val">10:00 AM</span>
                    <i class="fa fa-clock-o csf-cal-icon"></i>
                    <input type="hidden" name="pickup_time" id="pickup_time_input" value="10:00" required>
                </div>
            </div>
        </div>

        {{-- RETURN DATE (Round trip) --}}
        <div class="csf-field csf-field-date" id="return_date_field" style="display:none; cursor: pointer;">
            <div class="csf-field-inner" style="position:relative;">
                <span class="csf-label"><i class="fa fa-calendar-check-o csf-dot csf-dot-green"></i> Return Date</span>
                <div class="csf-date-row-inner">
                    <span id="return_date_display" class="csf-date-val" style="color:#aaa;">Select Date</span>
                    <i class="fa fa-calendar-o csf-cal-icon" style="color:#27ae60;"></i>
                    <input type="hidden" name="return_date" id="return_date">
                </div>
            </div>
        </div>

        {{-- SEARCH BUTTON --}}
        <button type="submit" class="csf-search-btn" id="csf-search-btn">
            <i class="fa fa-search"></i>
            <span>Search</span>
        </button>

    </div>

    {{-- ── HOURLY PACKAGES (shows when Hourly selected) ── --}}
    <div class="csf-hourly-bar" style="display:none;">
        <span class="csf-label" style="color:#fff; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; margin-right:16px;">Select Package:</span>
        <div class="csf-hourly-scroll">
            @php
                $packages = [
                    ['hr'=>1,'km'=>10],['hr'=>2,'km'=>20],['hr'=>3,'km'=>30],
                    ['hr'=>4,'km'=>40],['hr'=>5,'km'=>50],['hr'=>6,'km'=>60],
                    ['hr'=>8,'km'=>80],['hr'=>10,'km'=>100],['hr'=>12,'km'=>120]
                ];
            @endphp
            @foreach($packages as $i => $pkg)
                <label class="csf-pkg-pill">
                    <input type="radio" name="hourly_package" value="{{ $pkg['hr'] }}" {{ $i==3 ? 'checked' : '' }}>
                    <span class="csf-pill-inner"><strong>{{ $pkg['hr'] }}hr</strong><small>{{ $pkg['km'] }}km</small></span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Hidden Fields for Location Data --}}
    <input type="hidden" name="pickup_lat"   id="car_pickup_lat" value="{{ request()->query('pickup_lat') }}">
    <input type="hidden" name="pickup_lng"   id="car_pickup_lng" value="{{ request()->query('pickup_lng') }}">
    <input type="hidden" name="dropoff_lat"  id="car_dropoff_lat" value="{{ request()->query('dropoff_lat') }}">
    <input type="hidden" name="dropoff_lng"  id="car_dropoff_lng" value="{{ request()->query('dropoff_lng') }}">
</form>

{{-- ================================================================
     STYLES
================================================================ --}}
<style>
/* ============================================================
   FORM WRAPPER
============================================================ */
.csf-form {
    font-family: 'Inter', 'Poppins', sans-serif;
    width: 100%;
}

/* ============================================================
   TRIP TYPE TABS
============================================================ */
.csf-tabs-bar {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 0;
    padding: 0;
    gap: 3px;
}
.csf-tab {
    margin: 0;
    cursor: pointer;
}
.csf-tab input { display: none; }
.csf-tab-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 16px;
    font-size: 12px;
    font-weight: 700;
    color: rgba(255,255,255,0.7);
    background: rgba(255,255,255,0.12);
    border-radius: 10px 10px 0 0;
    border-bottom: 3px solid transparent;
    cursor: pointer;
    transition: all 0.25s ease;
    user-select: none;
    white-space: nowrap;
}
.csf-tab-label i { font-size: 12px; }
.csf-tab input:checked + .csf-tab-label {
    background: #fff;
    color: #ff5f1f;
    border-bottom-color: #ff5f1f;
    font-weight: 800;
}
.csf-tab:hover .csf-tab-label {
    background: rgba(255,255,255,0.22);
    color: #fff;
}

/* ============================================================
   MAIN FIELDS ROW — the white full-width bar
============================================================ */
.csf-fields-row {
    display: flex;
    align-items: stretch;
    background: #fff;
    border-radius: 0 12px 12px 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18);
    overflow: visible;
    position: relative;
    min-height: 80px;
}
@media (max-width: 1199px) {
    .csf-tabs-bar { flex-wrap: wrap; }
    .csf-tab-label { padding: 8px 12px; font-size: 11px; }
    .csf-fields-row {
        flex-direction: column;
        border-radius: 0 10px 10px 10px;
    }
    .csf-vdivider { display: none !important; }
    .csf-swap { display: none !important; }
    .csf-field {
        border-right: none !important;
        border-bottom: 1px solid #f0f0f0 !important;
        border-radius: 0 !important;
    }
    .csf-field:last-of-type { border-bottom: none !important; }
    .csf-search-btn {
        width: 100% !important;
        border-radius: 0 0 10px 10px !important;
        padding: 16px 20px !important;
        flex-direction: row !important;
        gap: 10px !important;
        font-size: 15px !important;
    }
    .csf-search-btn i { font-size: 18px !important; margin-bottom: 0 !important; }
}

/* ============================================================
   INDIVIDUAL FIELD CELLS
============================================================ */
.csf-field {
    flex: 1;
    min-width: 0;
    border-right: 1px solid #f0f0f0;
    position: relative;
    cursor: pointer;
    transition: background 0.2s ease;
}
.csf-field:hover { background: #fffaf8; }
.csf-field:focus-within { background: #fff8f5; box-shadow: inset 0 0 0 2px #ff5f1f; }

.csf-field-inner {
    padding: 14px 16px 12px;
    display: flex;
    flex-direction: column;
    height: 100%;
    min-width: 0;
}

.csf-loc-input {
    border: none;
    outline: none;
    background: transparent;
    font-size: 17px;
    font-weight: 700;
    color: #1a1a2e;
    width: 100%;
    padding: 0;
    box-shadow: none;
}
.csf-loc-input:focus {
    outline: none;
    box-shadow: none;
}

.csf-label {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 10px;
    font-weight: 800;
    color: #bbb;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 6px;
    white-space: nowrap;
}

/* Colored dots for labels */
.csf-dot { font-size: 11px; }
.csf-dot-blue   { color: #2276e3; }
.csf-dot-orange { color: #ff5f1f; }
.csf-dot-grey   { color: #999; }
.csf-dot-green  { color: #27ae60; }

/* Field sizing */
.csf-field-from,
.csf-field-to   { flex: 2; min-width: 160px; }
.csf-field-date { flex: 1.3; min-width: 120px; }
.csf-field-time { flex: 1.1; min-width: 100px; }

/* ============================================================
   GMPX PLACE PICKER inside field
============================================================ */
gmpx-place-picker {
    --gmpx-color-surface: transparent;
    --gmpx-font-family: 'Inter', 'Poppins', sans-serif;
    width: 100%;
    flex: 1;
    min-width: 0;
    overflow: hidden;
}
gmpx-place-picker::part(container) {
    border: none !important;
    box-shadow: none !important;
    background: transparent !important;
    padding: 0 !important;
    margin: 0 !important;
}
gmpx-place-picker::part(icon) { display: none !important; }
gmpx-place-picker::part(input) {
    font-family: 'Inter', 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 17px;
    color: #1a1a2e;
    padding: 0;
    border: none !important;
    outline: none !important;
    background: transparent !important;
    box-shadow: none !important;
    cursor: pointer;
    line-height: 1.3;
    width: 100%;
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* ============================================================
   DATE / TIME DISPLAY
============================================================ */
.csf-date-row-inner {
    display: flex;
    align-items: center;
    gap: 6px;
    min-width: 0;
}
.csf-date-val {
    font-size: 17px;
    font-weight: 700;
    color: #1a1a2e;
    flex: 1;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    min-width: 0;
}
.csf-cal-icon {
    color: #ff5f1f;
    font-size: 14px;
    flex-shrink: 0;
}

/* ============================================================
   SWAP BUTTON (between From and To)
============================================================ */
.csf-swap {
    width: 40px;
    flex-shrink: 0;
    background: #fff;
    border: none;
    border-left: 1px solid #f0f0f0;
    border-right: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #ff5f1f;
    font-size: 16px;
    transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    z-index: 2;
}
.csf-swap:hover {
    background: #fff5f0;
    transform: rotate(180deg);
}

/* ============================================================
   VERTICAL DIVIDERS
============================================================ */
.csf-vdivider {
    width: 1px;
    background: #f0f0f0;
    flex-shrink: 0;
    align-self: stretch;
}

/* ============================================================
   SEARCH BUTTON
============================================================ */
.csf-search-btn {
    background: linear-gradient(135deg, #ff5f1f 0%, #ff8c00 100%);
    border: none;
    border-radius: 0 12px 12px 0;
    padding: 0 28px;
    min-width: 110px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 3px;
    cursor: pointer;
    color: #fff;
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.csf-search-btn i { font-size: 22px; }
.csf-search-btn::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, #ff8c00 0%, #ff5f1f 100%);
    opacity: 0;
    transition: opacity 0.3s;
}
.csf-search-btn:hover::before { opacity: 1; }
.csf-search-btn i,
.csf-search-btn span { position: relative; z-index: 2; }
.csf-search-btn:hover {
    box-shadow: 0 15px 40px rgba(255,95,31,0.5);
    transform: scale(1.02);
}

/* ============================================================
   HOURLY BAR (below main row)
============================================================ */
.csf-hourly-bar {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.15);
    border-radius: 0 0 14px 14px;
    padding: 14px 20px;
    margin-top: 3px;
    backdrop-filter: blur(10px);
    flex-wrap: wrap;
    gap: 8px;
}
.csf-hourly-scroll {
    display: flex; gap: 8px;
    overflow-x: auto; padding-bottom: 2px;
    scrollbar-width: none; flex: 1;
}
.csf-hourly-scroll::-webkit-scrollbar { display: none; }
.csf-pkg-pill { margin: 0; cursor: pointer; flex-shrink: 0; }
.csf-pkg-pill input { display: none; }
.csf-pill-inner {
    display: flex; flex-direction: column; align-items: center;
    padding: 8px 18px;
    border: 1.5px solid rgba(255,255,255,0.4);
    border-radius: 30px;
    background: rgba(255,255,255,0.2);
    font-size: 14px; font-weight: 700; color: #fff;
    transition: all 0.22s ease;
    line-height: 1.2;
    backdrop-filter: blur(6px);
}
.csf-pill-inner small { font-size: 11px; color: rgba(255,255,255,0.75); font-weight: 500; }
.csf-pkg-pill input:checked + .csf-pill-inner {
    background: #fff;
    border-color: #fff;
    color: #ff5f1f;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}
.csf-pkg-pill input:checked + .csf-pill-inner small { color: #ff8c00; }

/* ============================================================
   PHOTON API AUTOCOMPLETE — Premium Dropdown
============================================================ */
.premium-autocomplete-dropdown {
    position: absolute;
    top: calc(100% + 5px);
    left: 0;
    width: 100%;
    background: #fff;
    border: 1px solid #eaeaea;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    z-index: 100000;
    display: none;
    max-height: 320px;
    overflow-y: auto;
    padding: 10px 0;
    font-family: 'Inter', 'Poppins', sans-serif;
    animation: pacFadeIn 0.2s ease;
}
@keyframes pacFadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.prem-dropdown-item {
    padding: 14px 20px;
    cursor: pointer;
    border-bottom: 1px solid #f5f5f5;
    display: flex;
    align-items: center;
    transition: background 0.2s;
}
.prem-dropdown-item:last-child {
    border-bottom: none;
}
.prem-dropdown-item:hover {
    background: linear-gradient(90deg, #fff8f5 0%, #fff3ee 100%);
    border-left: 3px solid #ff5f1f;
    padding-left: 17px;
}
.prem-dropdown-item .icon {
    width: 38px;
    height: 38px;
    background: #fff0ea;
    color: #ff5f1f;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    margin-right: 15px;
    flex-shrink: 0;
}
.prem-dropdown-item .details {
    flex: 1;
}
.prem-dropdown-item .city {
    font-size: 15px;
    font-weight: 700;
    color: #333;
    line-height: 1.2;
    text-align: left;
}
.prem-dropdown-item .country {
    font-size: 12px;
    color: #888;
    margin-top: 4px;
    text-align: left;
}
.prem-dropdown-loading {
    padding: 20px;
    text-align: center;
    color: #999;
    font-size: 14px;
}
</style>

{{-- ================================================================
     SCRIPTS
================================================================ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tripRadios  = document.querySelectorAll('input[name="trip_type"]');
    const dropGrp     = document.getElementById('dropoff_group');
    const swapBtn     = document.getElementById('swap_locations');
    const hourlyBar   = document.querySelector('.csf-hourly-bar');
    const returnField = document.getElementById('return_date_field');
    const returnDate  = document.getElementById('return_date');
    const divider1    = document.getElementById('date-divider-1');
    const divider2    = document.getElementById('date-divider-2');

    // ── Date / Time Formatters ─────────────────────────────
    function fmtDate(val) {
        if (!val) return 'Select Date';
        const d = new Date(val + 'T00:00:00');
        return d.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
    }
    function fmtTime(val) {
        if (!val) return 'Select Time';
        const [h, m] = val.split(':');
        const hr = parseInt(h), ampm = hr >= 12 ? 'PM' : 'AM';
        return ((hr % 12) || 12) + ':' + m + ' ' + ampm;
    }

    // ── FLATPICKR INITIALIZATION (MMT Premium Style) ──────
    // 1. Pickup Date
    flatpickr("#pickup_date_wrapper", {
        minDate: "today",
        dateFormat: "Y-m-d",
        defaultDate: new Date().fp_incr(1), // Tomorrow
        onChange: function(selectedDates, dateStr, instance) {
            document.getElementById('pickup_date_display').textContent = fmtDate(dateStr);
            document.getElementById('pickup_date_input').value = dateStr;
            // Also update Return Date minDate
            returnPicker.set('minDate', dateStr);
        }
    });

    // 2. Pickup Time
    flatpickr("#pickup_time_wrapper", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        defaultDate: "10:00",
        onChange: function(selectedDates, dateStr, instance) {
            document.getElementById('pickup_time_display').textContent = fmtTime(dateStr);
            document.getElementById('pickup_time_input').value = dateStr;
        }
    });

    // 3. Return Date
    const returnPicker = flatpickr("#return_date_field", {
        minDate: "today",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            const el = document.getElementById('return_date_display');
            if (el) { 
                el.textContent = fmtDate(dateStr); 
                el.style.color = '#1a1a2e'; 
            }
            document.getElementById('return_date').value = dateStr;
        }
    });

    // ── Swap Button ───────────────────────────────────────
    if (swapBtn) {
        swapBtn.addEventListener('click', function () {
            // 1. Save pickup values
            const pId   = document.getElementById('car_pickup_id').value;
            const pName = document.getElementById('car_pickup_name').value;
            const pVal  = document.getElementById('car-pickup-input').value;
            const pLat  = document.getElementById('car_pickup_lat').value;
            const pLng  = document.getElementById('car_pickup_lng').value;

            // 2. Save dropoff values
            const dId   = document.getElementById('car_dropoff_id').value;
            const dName = document.getElementById('car_dropoff_name').value;
            const dVal  = document.getElementById('car-dropoff-input').value;
            const dLat  = document.getElementById('car_dropoff_lat').value;
            const dLng  = document.getElementById('car_dropoff_lng').value;

            // 3. Swap pickup to dropoff
            document.getElementById('car_pickup_id').value = dId;
            document.getElementById('car_pickup_name').value = dName;
            document.getElementById('car-pickup-input').value = dVal;
            document.getElementById('car_pickup_lat').value = dLat;
            document.getElementById('car_pickup_lng').value = dLng;

            // 4. Swap dropoff to pickup
            document.getElementById('car_dropoff_id').value = pId;
            document.getElementById('car_dropoff_name').value = pName;
            document.getElementById('car-dropoff-input').value = pVal;
            document.getElementById('car_dropoff_lat').value = pLat;
            document.getElementById('car_dropoff_lng').value = pLng;

            // 5. Animate swap button
            this.style.transform = 'rotate(180deg)';
            setTimeout(() => { this.style.transform = ''; }, 400);
        });
    }

    // ── Trip type state ───────────────────────────────────
    function show(el, v) { if (el) el.style.display = v; }

    function updateState() {
        const val = document.querySelector('input[name="trip_type"]:checked').value;

        if (val === 'hourly_rental') {
            show(dropGrp,     'none');
            show(swapBtn,     'none');
            show(divider1,    'none');
            show(divider2,    'none');
            show(hourlyBar,   'flex');
            show(returnField, 'none');
            if (returnDate) returnDate.required = false;
        } else if (val === 'outstation_round_trip') {
            show(dropGrp,     'flex');
            show(swapBtn,     'flex');
            show(divider1,    'block');
            show(divider2,    'block');
            show(hourlyBar,   'none');
            show(returnField, 'flex');
            if (returnDate) returnDate.required = true;
        } else {
            show(dropGrp,     'flex');
            show(swapBtn,     'flex');
            show(divider1,    'block');
            show(divider2,    'block');
            show(hourlyBar,   'none');
            show(returnField, 'none');
            if (returnDate) returnDate.required = false;
        }
    }
    tripRadios.forEach(r => r.addEventListener('change', updateState));
    updateState();
    
    // Hide dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        let pWrapper = document.getElementById('car-pickup-wrapper');
        let pDropdown = document.getElementById('car-pickup-dropdown');
        if (pWrapper && pDropdown && !pWrapper.contains(e.target)) {
            pDropdown.style.display = 'none';
        }
        
        let dWrapper = document.getElementById('car-dropoff-wrapper');
        let dDropdown = document.getElementById('car-dropoff-dropdown');
        if (dWrapper && dDropdown && !dWrapper.contains(e.target)) {
            dDropdown.style.display = 'none';
        }
    });
});

// ── Local Autocomplete Logic ─────────────────────────────
// Debounce function to limit API calls
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

// Fetch user country on load
window.userCountry = '';
fetch('https://get.geojs.io/v1/ip/geo.json')
    .then(res => res.json())
    .then(data => { if(data.country) window.userCountry = data.country; })
    .catch(e => console.log('Could not fetch user country'));

const searchCarLoc = debounce(async function(query, type) {
    const dropdown = document.getElementById(`car-${type}-dropdown`);
    dropdown.innerHTML = '';
    
    let q = query.trim();
    
    if (q.length < 2) {
        dropdown.style.display = 'none';
        return;
    }

    dropdown.innerHTML = '<div class="prem-dropdown-loading">Searching...</div>';
    dropdown.style.display = 'block';

    // Append user country to bias results
    let finalQuery = q;
    if (window.userCountry) finalQuery += ' ' + window.userCountry;

    try {
        // Photon API endpoint (OpenStreetMap) - No API key required
        let res = await fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(finalQuery)}&limit=5`);
        let data = await res.json();
        
        dropdown.innerHTML = '';

        if (data.features && data.features.length > 0) {
            data.features.forEach(feature => {
                let prop = feature.properties;
                let geom = feature.geometry.coordinates; // [lng, lat]
                
                let name = prop.name;
                let subtitle = [];
                if(prop.city && prop.city !== name) subtitle.push(prop.city);
                if(prop.state) subtitle.push(prop.state);
                if(prop.country) subtitle.push(prop.country);
                
                let subText = subtitle.join(', ');

                let item = document.createElement('div');
                item.className = 'prem-dropdown-item';
                item.onclick = function(e) {
                    e.stopPropagation();
                    // geom[1] = lat, geom[0] = lng
                    selectCarLoc(name, geom[1], geom[0], type, subText);
                };

                item.innerHTML = `
                    <div class="icon"><i class="fa fa-map-marker"></i></div>
                    <div class="details">
                        <div class="city">${name}</div>
                        <div class="country">${subText || 'Location'}</div>
                    </div>
                `;
                dropdown.appendChild(item);
            });
        } else {
            dropdown.innerHTML = '<div class="prem-dropdown-loading">No locations found.</div>';
        }
    } catch(e) {
        dropdown.innerHTML = '<div class="prem-dropdown-loading">Error loading results.</div>';
    }
}, 400);

function selectCarLoc(name, lat, lng, type, subtitle) {
    document.getElementById(`car-${type}-input`).value = name;
    document.getElementById(`car_${type}_name`).value = name;
    document.getElementById(`car_${type}_lat`).value = lat;
    document.getElementById(`car_${type}_lng`).value = lng;
    
    // Clear location_id since we are using lat/lng coordinates directly
    const idField = document.getElementById(`car_${type}_id`);
    if(idField) idField.value = '';
    
    document.getElementById(`car-${type}-dropdown`).style.display = 'none';
}
</script>

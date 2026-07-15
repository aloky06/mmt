@php
    $translation = $row->translateOrOrigin(app()->getLocale());
    $distance = isset($distance_km) && $distance_km > 0 ? $distance_km : 1;
    $base_price = $row->price_per_km ? ($row->price_per_km * $distance) : $row->price;
    if (isset($trip_type) && $trip_type == 'hourly_rental' && isset($hourly_package)) {
        if ($hourly_package <= 4 && $row->price_4hr) $base_price = $row->price_4hr;
        elseif ($hourly_package <= 8 && $row->price_8hr) $base_price = $row->price_8hr;
        else $base_price = $row->price_per_km * ($hourly_package * 10);
    }
    $strike_price = $base_price * 1.18;
    $taxes        = $base_price * 0.05;
    $detailUrl    = $row->getDetailUrl($include_param ?? true);
    
    // Append all search queries to the detail URL so checkout works
    $queryParams = request()->query();
    unset($queryParams['page']); 
    $queryParams['distance_km'] = $distance;
    if (isset($hourly_package)) $queryParams['hourly_package'] = $hourly_package;
    
    $detailUrl .= (strpos($detailUrl, '?') !== false ? '&' : '?') . http_build_query($queryParams);
@endphp

<div class="cr-card">

    {{-- IMAGE --}}
    <div class="cr-img-col">
        @if($row->image_url)
            <img src="{{ $row->image_url }}" alt="{{ $row->title }}">
        @else
            <img src="{{ asset('images/default-car.jpg') }}" alt="Car">
        @endif
        <span class="cr-fuel-tag">{{ $row->baggage ?? 'AC' }}</span>
    </div>

    {{-- DETAILS --}}
    <div class="cr-details-col">
        <div class="cr-head">
            <h3 class="cr-title">{!! clean($translation->title) !!}</h3>
            <span class="cr-similar">or similar</span>
            @if($row->review_score)
                <span class="cr-rating"><i class="fa fa-star"></i> {{ $row->review_score }}</span>
            @endif
        </div>

        <ul class="cr-amenities">
            @if($row->passenger)
                <li><i class="fa fa-users"></i> {{ $row->passenger }} Seater</li>
            @endif
            @if($row->gear)
                <li><i class="fa fa-cogs"></i> {{ $row->gear }}</li>
            @endif
            @if($row->door)
                <li><i class="fa fa-car"></i> {{ $row->door }} Doors</li>
            @endif
        </ul>

        <div class="cr-tags">
            <span class="cr-tag cr-tag-green"><i class="fa fa-check-circle"></i> {{ $distance }} kms included</span>
            <span class="cr-tag cr-tag-blue"><i class="fa fa-shield"></i> Insured</span>
            <span class="cr-tag cr-tag-grey"><i class="fa fa-clock-o"></i> Free Cancellation</span>
        </div>
    </div>

    {{-- PRICE + CTA --}}
    <div class="cr-price-col">
        <div class="cr-discount-badge">15% OFF</div>
        <div class="cr-strike">{{ format_money($strike_price) }}</div>
        <div class="cr-price">{{ format_money($base_price) }}</div>
        <div class="cr-tax">+ {{ format_money($taxes) }} taxes & fees</div>
        <button
            onclick="directBookCab({{ $row->id }}, '{{ Request::query('pickup_date') }}', '{{ Request::query('pickup_time') }}', this)"
            class="cr-book-btn">
            SELECT CAB <i class="fa fa-arrow-right ml-1"></i>
        </button>
        <a href="{{ $detailUrl }}" class="cr-detail-link">View Details</a>
    </div>

</div>

<style>
/* ============================================================
   CAR RESULT CARD
============================================================ */
.cr-card {
    display: flex;
    align-items: stretch;
    background: #fff;
    border-radius: 16px;
    border: 1.5px solid #f0f0f0;
    overflow: hidden;
    transition: all 0.3s ease;
    font-family: 'Inter', sans-serif;
    gap: 0;
}
.cr-card:hover {
    border-color: #ffcbb5;
    box-shadow: 0 8px 40px rgba(255,95,31,0.12);
    transform: translateY(-2px);
}

/* IMAGE */
.cr-img-col {
    flex: 0 0 200px;
    position: relative;
    background: linear-gradient(135deg, #f8f9fa, #f0f0f0);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    border-right: 1.5px solid #f5f5f5;
}
.cr-img-col img {
    width: 100%;
    height: 130px;
    object-fit: contain;
    transition: transform 0.35s ease;
}
.cr-card:hover .cr-img-col img { transform: scale(1.05); }
.cr-fuel-tag {
    position: absolute;
    bottom: 12px;
    left: 12px;
    background: #e8f0fe;
    color: #2276e3;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
}

/* DETAILS */
.cr-details-col {
    flex: 1;
    padding: 22px 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.cr-head {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}
.cr-title {
    font-size: 20px;
    font-weight: 800;
    color: #1a1a2e;
    margin: 0;
    line-height: 1.2;
}
.cr-similar {
    font-size: 12px;
    color: #aaa;
    font-weight: 500;
}
.cr-rating {
    background: linear-gradient(135deg, #00b09b, #26b5a9);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 6px;
}
.cr-rating i { font-size: 10px; }

.cr-amenities {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}
.cr-amenities li {
    font-size: 13px;
    color: #555;
    display: flex;
    align-items: center;
    gap: 6px;
}
.cr-amenities li i { color: #ff5f1f; font-size: 13px; }

.cr-tags {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: auto;
}
.cr-tag {
    font-size: 11.5px;
    font-weight: 600;
    padding: 5px 11px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.cr-tag-green { background: #e6f8f0; color: #1a9e6b; }
.cr-tag-blue  { background: #e8f0fe; color: #2276e3; }
.cr-tag-grey  { background: #f5f5f5; color: #777; }

/* PRICE */
.cr-price-col {
    flex: 0 0 200px;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: center;
    padding: 22px 24px;
    border-left: 1.5px dashed #f0f0f0;
    background: linear-gradient(180deg, #fff 0%, #fffaf8 100%);
    gap: 4px;
}
.cr-discount-badge {
    background: linear-gradient(90deg, #e52b50, #c9184a);
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: 20px;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}
.cr-strike {
    color: #bbb;
    font-size: 14px;
    text-decoration: line-through;
}
.cr-price {
    font-size: 30px;
    font-weight: 900;
    color: #1a1a2e;
    line-height: 1;
}
.cr-tax {
    font-size: 11px;
    color: #999;
    margin-bottom: 14px;
}
.cr-book-btn {
    background: linear-gradient(135deg, #ff5f1f, #ff8c00);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 12px 24px;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    text-align: center;
    text-transform: uppercase;
    position: relative;
    overflow: hidden;
}
.cr-book-btn::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, #ff8c00, #ff5f1f);
    opacity: 0; transition: opacity 0.3s;
}
.cr-book-btn:hover::before { opacity: 1; }
.cr-book-btn:hover { box-shadow: 0 8px 25px rgba(255,95,31,0.4); transform: translateY(-1px); color: #fff; }
.cr-book-btn i, .cr-book-btn span { position: relative; z-index: 2; }
.cr-detail-link {
    font-size: 12px;
    color: #ff5f1f;
    text-decoration: none;
    font-weight: 600;
    text-align: center;
    margin-top: 6px;
    transition: color 0.2s;
}
.cr-detail-link:hover { color: #c94500; text-decoration: underline; }

/* RESPONSIVE */
@media (max-width: 900px) {
    .cr-card { flex-direction: column; }
    .cr-img-col { flex: 0 0 auto; border-right: none; border-bottom: 1.5px solid #f5f5f5; padding: 20px; }
    .cr-img-col img { height: 120px; width: auto; max-width: 200px; }
    .cr-price-col { flex: 0 0 auto; border-left: none; border-top: 1.5px dashed #f0f0f0; align-items: flex-start; }
}
@media (max-width: 576px) {
    .cr-title { font-size: 18px; }
    .cr-price  { font-size: 26px; }
    .cr-book-btn { padding: 12px 18px; }
}
</style>

<script>
function directBookCab(carId, date, time, btn) {
    if (!date) { alert("Please select a date first"); return; }
    $(btn).html('BOOKING... <i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
    var start_date = date;
    if (time) start_date += ' ' + time + ':00';
    $.ajax({
        url: '{{ url("/booking/addToCart") }}',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            service_id: carId, service_type: 'car',
            start_date: start_date, end_date: start_date,
            number: 1, extra_price: [],
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            if (res.status) {
                var url = res.url
                    + '?pickup_name='   + encodeURIComponent('{{ Request::query("pickup_name") }}')
                    + '&dropoff_name='  + encodeURIComponent('{{ Request::query("dropoff_name") }}')
                    + '&pickup_date='   + encodeURIComponent('{{ Request::query("pickup_date") }}')
                    + '&pickup_time='   + encodeURIComponent('{{ Request::query("pickup_time") }}')
                    + '&distance='      + encodeURIComponent('{{ Request::query("distance") }}')
                    + '&trip_type='     + encodeURIComponent('{{ Request::query("trip_type") }}')
                    + '&hourly_package='+ encodeURIComponent('{{ Request::query("hourly_package") }}');
                window.location.href = url;
            } else {
                alert(res.message || "Error adding to cart");
                $(btn).html('SELECT CAB <i class="fa fa-arrow-right ml-1"></i>').prop('disabled', false);
            }
        },
        error: function(err) {
            var msg = err.responseJSON?.message ?? "System error, please try again";
            alert(msg);
            $(btn).html('SELECT CAB <i class="fa fa-arrow-right ml-1"></i>').prop('disabled', false);
        }
    });
}
</script>

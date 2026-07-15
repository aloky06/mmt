@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp

<div class="ht-card">

    {{-- IMAGE --}}
    <div class="ht-img-col">
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}" class="d-block w-100 h-100">
            @if($row->image_url)
                <img src="{{$row->image_url}}" loading="lazy" class="img-responsive" alt="{{$translation->title}}">
            @else
                <img src="{{ asset('images/default-hotel.svg') }}" loading="lazy" class="img-responsive" alt="Hotel">
            @endif
        </a>
        
        @if($row->is_featured == "1")
            <span class="ht-featured-tag">{{__("Featured")}}</span>
        @endif
        
        <div class="ht-wishlist service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
            <i class="fa fa-heart"></i>
        </div>
    </div>

    {{-- DETAILS --}}
    <div class="ht-details-col">
        <div class="ht-head">
            <h3 class="ht-title">
                <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}">
                    @if($row->is_instant)
                        <i class="fa fa-bolt" style="color: #ff9800;"></i>
                    @endif
                    {!! clean($translation->title) !!}
                </a>
            </h3>
            @if($row->star_rate)
                <span class="ht-stars">
                    @for ($star = 1 ;$star <= $row->star_rate ; $star++)
                        <i class="fa fa-star"></i>
                    @endfor
                </span>
            @endif
        </div>

        <div class="ht-location">
            @if(!empty($row->location->name))
                @php $location =  $row->location->translateOrOrigin(app()->getLocale()) @endphp
                <i class="fa fa-map-marker"></i> {{$location->name ?? ''}}
            @endif
        </div>

        @if(!empty($attribute = $row->getAttributeInListingPage()))
            @php
                $translate_attribute =  $attribute->translateOrOrigin(app()->getLocale());
                $termsByAttribute = $row->termsByAttributeInListingPage
            @endphp
            <ul class="ht-amenities">
                @foreach($termsByAttribute as $term)
                    @php $translate_term = $term->translateOrOrigin(app()->getLocale()) @endphp
                    <li><i class="fa fa-check"></i> {{$translate_term->name}}</li>
                @endforeach
            </ul>
        @endif

        <div class="ht-tags">
            @if(setting_item('hotel_enable_review') && !empty($reviewData = $row->getScoreReview()) && !empty($reviewData['total_review']))
                <span class="ht-tag ht-tag-green"><i class="fa fa-thumbs-up"></i> {{$reviewData['review_text']}} ({{$reviewData['total_review']}})</span>
            @endif
        </div>
    </div>

    {{-- PRICE + CTA --}}
    <div class="ht-price-col">
        @if(setting_item('hotel_enable_review') && !empty($reviewData = $row->getScoreReview()) && !empty($reviewData['score_total']))
            <div class="ht-rating-badge">
                <div class="score">{{$reviewData['score_total']}}</div>
                <div class="text">
                    <div class="word">{{$reviewData['review_text']}}</div>
                    <div class="count">{{__(":number reviews",['number'=>$reviewData['total_review']])}}</div>
                </div>
            </div>
        @else
            <div class="ht-rating-placeholder"></div>
        @endif

        <div class="ht-price-wrap">
            <div class="ht-prefix">{{__("from")}}</div>
            <div class="ht-price">{{ $row->display_price }}</div>
            <div class="ht-tax">{{__("per night")}}</div>
        </div>

        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}" class="ht-book-btn">
            {{__("VIEW HOTEL")}} <i class="fa fa-arrow-right ml-1"></i>
        </a>
    </div>

</div>

<style>
/* ============================================================
   HOTEL RESULT CARD
============================================================ */
.ht-card {
    display: flex;
    align-items: stretch;
    background: #fff;
    border-radius: 16px;
    border: 1.5px solid #f0f0f0;
    overflow: hidden;
    transition: all 0.3s ease;
    font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
    gap: 0;
    margin-bottom: 16px;
}
.ht-card:hover {
    border-color: #ffcbb5;
    box-shadow: 0 8px 40px rgba(255,95,31,0.12);
    transform: translateY(-2px);
}

/* IMAGE */
.ht-img-col {
    flex: 0 0 240px;
    position: relative;
    background: linear-gradient(135deg, #f8f9fa, #f0f0f0);
    overflow: hidden;
    border-right: 1.5px solid #f5f5f5;
}
.ht-img-col a {
    display: block;
    width: 100%;
    height: 100%;
    position: absolute;
    inset: 0;
}
.ht-img-col img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s ease;
}
.ht-card:hover .ht-img-col img { transform: scale(1.05); }

.ht-featured-tag {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(90deg, #ff5f1f, #ff8c00);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    box-shadow: 0 4px 10px rgba(255,95,31,0.3);
    text-transform: uppercase;
}

.ht-wishlist {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(255,255,255,0.9);
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #999;
    font-size: 14px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: all 0.2s;
}
.ht-wishlist:hover { color: #e52b50; transform: scale(1.1); }
.ht-wishlist.active { color: #e52b50; }

/* DETAILS */
.ht-details-col {
    flex: 1;
    padding: 22px 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.ht-head {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}
.ht-title {
    font-size: 20px;
    font-weight: 800;
    margin: 0;
    line-height: 1.2;
}
.ht-title a {
    color: #1a1a2e;
    text-decoration: none;
    transition: color 0.2s;
}
.ht-title a:hover { color: #ff5f1f; }
.ht-stars {
    color: #ff9800;
    font-size: 12px;
    display: flex;
    gap: 2px;
}

.ht-location {
    font-size: 13px;
    color: #555;
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
}
.ht-location i { color: #2276e3; }

.ht-amenities {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}
.ht-amenities li {
    font-size: 13px;
    color: #555;
    display: flex;
    align-items: center;
    gap: 6px;
}
.ht-amenities li i { color: #1a9e6b; font-size: 12px; }

.ht-tags {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: auto;
}
.ht-tag {
    font-size: 11.5px;
    font-weight: 600;
    padding: 5px 11px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.ht-tag-green { background: #e6f8f0; color: #1a9e6b; }
.ht-tag-blue  { background: #e8f0fe; color: #2276e3; }

/* PRICE */
.ht-price-col {
    flex: 0 0 200px;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: space-between;
    padding: 22px 24px;
    border-left: 1.5px dashed #f0f0f0;
    background: linear-gradient(180deg, #fff 0%, #fffaf8 100%);
    gap: 16px;
}

.ht-rating-badge {
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: flex-end;
    width: 100%;
}
.ht-rating-badge .text {
    text-align: right;
}
.ht-rating-badge .text .word {
    font-size: 13px;
    font-weight: 700;
    color: #1a1a2e;
}
.ht-rating-badge .text .count {
    font-size: 11px;
    color: #777;
}
.ht-rating-badge .score {
    background: #1a1a2e;
    color: #fff;
    font-size: 16px;
    font-weight: 800;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px 8px 8px 0;
}
.ht-rating-placeholder {
    height: 36px; /* reserve space if no review */
}

.ht-price-wrap {
    text-align: right;
}
.ht-prefix {
    font-size: 12px;
    color: #777;
    margin-bottom: 2px;
}
.ht-price {
    font-size: 26px;
    font-weight: 900;
    color: #1a1a2e;
    line-height: 1;
}
.ht-tax {
    font-size: 11px;
    color: #999;
    margin-top: 4px;
}

.ht-book-btn {
    display: inline-block;
    background: linear-gradient(135deg, #ff5f1f, #ff8c00);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 12px 24px;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 0.5px;
    text-decoration: none;
    transition: all 0.3s ease;
    width: 100%;
    text-align: center;
    text-transform: uppercase;
    position: relative;
    overflow: hidden;
}
.ht-book-btn::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, #ff8c00, #ff5f1f);
    opacity: 0; transition: opacity 0.3s;
}
.ht-book-btn:hover::before { opacity: 1; }
.ht-book-btn:hover { box-shadow: 0 8px 25px rgba(255,95,31,0.4); transform: translateY(-1px); color: #fff; }
.ht-book-btn i, .ht-book-btn span { position: relative; z-index: 2; }

/* RESPONSIVE */
@media (max-width: 900px) {
    .ht-card { flex-direction: column; }
    .ht-img-col { flex: 0 0 200px; border-right: none; border-bottom: 1.5px solid #f5f5f5; }
    .ht-price-col { flex: 0 0 auto; border-left: none; border-top: 1.5px dashed #f0f0f0; align-items: flex-start; }
    .ht-rating-badge { justify-content: flex-start; flex-direction: row-reverse; }
    .ht-rating-badge .text { text-align: left; }
    .ht-price-wrap { text-align: left; }
}
@media (max-width: 576px) {
    .ht-title { font-size: 18px; }
    .ht-price  { font-size: 24px; }
    .ht-book-btn { padding: 12px 18px; }
}
</style>

@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp
<div class="item">
    @if($row->is_featured == "1")
        <div class="featured">
            {{__("Featured")}}
        </div>
    @endif
    <div class="header-thumb">
        @if($row->discount_percent)
            <div class="sale_info">{{$row->discount_percent}}</div>
        @endif
        @if($row->image_url)
            @if(!empty($disable_lazyload))
                <img src="{{$row->image_url}}" class="img-responsive" alt="{{$location->name ?? ''}}">
            @else
                {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive','alt'=>$row->title]) !!}
            @endif
        @endif
        <a class="st-btn st-btn-primary tour-book-now" href="{{$row->getDetailUrl()}}">{{__("Book now")}}</a>
        <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
            <i class="fa fa-heart"></i>
        </div>
    </div>
    <div class="caption clear" style="padding: 15px;">
        <div class="title-address" style="margin-bottom: 10px; width: 100%;">
            <h3 class="title" style="font-size: 16px; font-weight: 500; margin: 0; line-height: 1.4; white-space: normal;">
                <a href="{{$row->getDetailUrl()}}" style="color: #1a2b48; text-decoration: none;"> {!! clean($translation->title) !!} </a>
            </h3>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: flex-end; width: 100%;">
            <div class="duration" style="color: #5e6d77; font-size: 14px;">
                <i class="fa fa-clock-o"></i>
                <span>
                    {{duration_format($row->duration)}}
                </span>
                @if(!empty($row->location->name))
                    -
                    <i>
                        @php $location =  $row->location->translateOrOrigin(app()->getLocale()) @endphp
                        {{$location->name ?? ''}}
                    </i>
                @endif
            </div>
            <div class="g-price" style="text-align: right;">
                <div class="price">
                    <span class="onsale" style="text-decoration: line-through; font-size: 13px; color: #c03 !important;">{{ $row->display_sale_price }}</span>
                    <span class="text-price" style="font-size: 17px; color: #1a2b48; font-weight: 600;">{{ $row->display_price }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
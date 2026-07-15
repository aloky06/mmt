<style>
    .goibibo-filters {
        background: #fff;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        font-family: 'Inter', sans-serif;
    }
    .goibibo-filters .filter-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #e0e0e0;
        font-size: 16px;
        font-weight: 700;
        color: #000;
        background: transparent;
        margin: 0;
    }
    .goibibo-filters .filter-title a.clear-all {
        font-size: 12px;
        color: #777;
        text-transform: uppercase;
        font-weight: 600;
        text-decoration: none;
    }
    .goibibo-filters .g-filter-item {
        padding: 15px 20px;
        border-bottom: 1px solid #f1f1f1;
        margin: 0;
    }
    .goibibo-filters .g-filter-item:last-child {
        border-bottom: none;
    }
    .goibibo-filters .item-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        margin-bottom: 15px;
    }
    .goibibo-filters .item-title h3 {
        font-size: 14px;
        font-weight: 700;
        color: #4a4a4a;
        margin: 0;
    }
    .goibibo-filters .item-title i {
        color: #999;
        font-size: 18px;
        transition: 0.3s;
    }
    .goibibo-filters .item-content ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .goibibo-filters .item-content ul li {
        margin-bottom: 12px;
    }
    .goibibo-filters .item-content ul li:last-child {
        margin-bottom: 0;
    }
    .goibibo-filters .bravo-checkbox label {
        display: flex;
        align-items: center;
        font-size: 13px;
        color: #4a4a4a;
        cursor: pointer;
        margin: 0;
        padding-left: 28px;
        position: relative;
    }
    .goibibo-filters .bravo-checkbox .checkmark {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 18px;
        width: 18px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
    }
    .goibibo-filters .bravo-checkbox input:checked ~ .checkmark {
        background-color: #ff6d38;
        border-color: #ff6d38;
    }
    .goibibo-filters .bravo-checkbox input:checked ~ .checkmark:after {
        content: "";
        position: absolute;
        display: block;
        left: 5px;
        top: 2px;
        width: 6px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    .goibibo-filters .term-count {
        margin-left: auto;
        font-weight: 700;
        color: #000;
    }
</style>

<div class="bravo_filter goibibo-filters">
    <form action="{{url(app_get_locale(false,false,'/').config('car.car_route_prefix'))}}" class="bravo_form_filter">
        @if( !empty(Request::query('location_id')) )
            <input type="hidden" name="location_id" value="{{Request::query('location_id')}}">
        @endif
        
        <!-- Preserve Goibibo Cabs Search Fields -->
        @if(Request::query('trip_type'))
            <input type="hidden" name="trip_type" value="{{Request::query('trip_type')}}">
        @endif
        @if(Request::query('pickup_lat'))
            <input type="hidden" name="pickup_lat" value="{{Request::query('pickup_lat')}}">
            <input type="hidden" name="pickup_lng" value="{{Request::query('pickup_lng')}}">
            <input type="hidden" name="pickup_name" value="{{Request::query('pickup_name')}}">
        @endif
        @if(Request::query('dropoff_lat'))
            <input type="hidden" name="dropoff_lat" value="{{Request::query('dropoff_lat')}}">
            <input type="hidden" name="dropoff_lng" value="{{Request::query('dropoff_lng')}}">
            <input type="hidden" name="dropoff_name" value="{{Request::query('dropoff_name')}}">
        @endif
        @if(Request::query('pickup_date'))
            <input type="hidden" name="pickup_date" value="{{Request::query('pickup_date')}}">
            <input type="hidden" name="pickup_time" value="{{Request::query('pickup_time')}}">
        @endif
        @if(Request::query('hourly_package'))
            <input type="hidden" name="hourly_package" value="{{Request::query('hourly_package')}}">
        @endif

        @if( !empty(Request::query('start')) and !empty(Request::query('end')) )
            <input type="hidden" value="{{Request::query('start',date("d/m/Y",strtotime("today")))}}" name="start">
            <input type="hidden" value="{{Request::query('end',date("d/m/Y",strtotime("+1 day")))}}" name="end">
            <input type="hidden" name="date" value="{{Request::query('date')}}">
        @endif
        <div class="filter-title">
            <span>{{__("Filters")}}</span>
            <a href="{{url(app_get_locale(false,false,'/').config('car.car_route_prefix'))}}" class="clear-all">CLEAR ALL</a>
        </div>
        <div class="g-filter-item">
            <div class="item-title">
                <h3>{{__("Filter Price")}}</h3>
                <i class="fa fa-angle-up" aria-hidden="true"></i>
            </div>
            <div class="item-content">
                <div class="bravo-filter-price">
                    <?php
                    $price_min = $pri_from = floor ( App\Currency::convertPrice($car_min_max_price[0]) );
                    $price_max = $pri_to = ceil ( App\Currency::convertPrice($car_min_max_price[1]) );
                    if (!empty($price_range = Request::query('price_range'))) {
                        $pri_from = explode(";", $price_range)[0];
                        $pri_to = explode(";", $price_range)[1];
                    }
                    $currency = App\Currency::getCurrency( App\Currency::getCurrent() );
                    ?>
                    <input type="hidden" class="filter-price irs-hidden-input" name="price_range"
                           data-symbol=" {{$currency['symbol'] ?? ''}}"
                           data-min="{{$price_min}}"
                           data-max="{{$price_max}}"
                           data-from="{{$pri_from}}"
                           data-to="{{$pri_to}}"
                           readonly="" value="{{$price_range}}">
                    <button type="submit" class="btn btn-link btn-apply-price-range">{{__("APPLY")}}</button>
                </div>
            </div>
        </div>
        <div class="g-filter-item">
            <div class="item-title">
                <h3>{{__("Review Score")}}</h3>
                <i class="fa fa-angle-up" aria-hidden="true"></i>
            </div>
            <div class="item-content">
                <ul>
                    @for ($number = 5 ;$number >= 1 ; $number--)
                        <li>
                            <div class="bravo-checkbox">
                                <label>
                                    <input name="review_score[]" type="checkbox" value="{{$number}}" @if(  in_array($number , request()->query('review_score',[])) )  checked @endif>
                                    <span class="checkmark"></span>
                                    @for ($review_score = 1 ;$review_score <= $number ; $review_score++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                </label>
                            </div>
                        </li>
                    @endfor
                </ul>
            </div>
        </div>
        @php
            $selected = (array) Request::query('terms');
        @endphp
        @foreach ($attributes as $item)
            @if(empty($item['hide_in_filter_search']))
                @php
                    $translate = $item->translateOrOrigin(app()->getLocale());
                @endphp
                <div class="g-filter-item">
                    <div class="item-title">
                        <h3> {{$translate->name}} </h3>
                        <i class="fa fa-angle-up" aria-hidden="true"></i>
                    </div>
                    <div class="item-content">
                        <ul>
                            @foreach($item->terms as $key => $term)
                                @php $translate = $term->translateOrOrigin(app()->getLocale()); @endphp
                                <li @if($key > 2 and empty($selected)) class="hide" @endif>
                                    <div class="bravo-checkbox">
                                        <label>
                                            <input @if(in_array($term->id,$selected)) checked @endif type="checkbox" name="terms[]" value="{{$term->id}}" onchange="this.form.submit()">
                                            <span class="checkmark"></span>
                                            {!! $translate->name !!}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @if(count($item->terms) > 3 and empty($selected))
                            <button type="button" class="btn btn-link btn-more-item">{{__("More")}} <i class="fa fa-caret-down"></i></button>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </form>
</div>



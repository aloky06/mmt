@php $lang_local = app()->getLocale(); @endphp
<style>
    .goibibo-itinerary-header {
        background: #f4f5f5;
        padding-bottom: 20px;
    }
    .goibibo-itinerary-header .banner {
        background: #ff6d38;
        color: #fff;
        padding: 15px 20px;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        border-radius: 8px 8px 0 0;
    }
    .itinerary-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #e0e0e0;
    }
    .itinerary-details .col-itinerary {
        display: flex;
        flex-direction: column;
    }
    .itinerary-details .col-itinerary.center {
        align-items: center;
    }
    .itinerary-details h4 { margin: 0; font-size: 16px; font-weight: 700; color: #000; }
    .itinerary-details p { margin: 5px 0 0 0; font-size: 12px; color: #757575; }
    .itinerary-details .date-time { margin-top: 10px; font-size: 13px; font-weight: 600; color: #4a4a4a; display: flex; align-items: center; gap: 5px;}
    
    .review-block {
        background: #fff;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #e0e0e0;
    }
    
    .car-meta-flex { display: flex; align-items: center; }
    .car-meta-flex img { width: 140px; border-radius: 4px; margin-right: 20px; }
    .car-meta-flex h3 { font-size: 18px; font-weight: 700; margin: 0 0 8px 0; }
    .car-meta-flex p { color: #757575; font-size: 13px; margin: 0; }
    
    .inclusions-list { list-style: none; padding: 0; margin: 15px 0 0 0; }
    .inclusions-list li { position: relative; padding-left: 24px; margin-bottom: 12px; font-size: 13px; color: #4a4a4a; }
    .inclusions-list li strong { color: #000; display: block; font-size: 14px; }
    .inclusions-list li::before {
        content: "✓";
        position: absolute;
        left: 0;
        top: 2px;
        color: #22c55e;
        font-weight: bold;
        background: #e6f8ec;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
    }
    
    .right-fare-breakup {
        background: #fff;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #e0e0e0;
    }
    .right-fare-breakup h4 { font-size: 16px; font-weight: 700; margin-bottom: 15px; }
    .fare-item { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #4a4a4a; }
    .fare-item.total { font-size: 18px; font-weight: 700; color: #000; border-top: 1px solid #eee; padding-top: 15px; margin-top: 5px; }
    
    .btn-pay-now {
        background: #ff6d38;
        color: #fff;
        font-weight: 700;
        font-size: 16px;
        padding: 14px;
        border-radius: 6px;
        width: 100%;
        border: none;
        margin-top: 20px;
    }
</style>

<div class="form-checkout booking-form" id="form-checkout">
    <input type="hidden" name="code" value="{{$booking->code}}">
    
    <div class="goibibo-itinerary-header">
        <div class="banner">Review booking</div>
        <div class="itinerary-details">
            <div class="col-itinerary">
                <p>{{ Request::query('trip_type') == 'hourly_rental' ? 'Hourly Rental' : 'Outstation One Way Trip' }}</p>
                <h4>{{ Request::query('pickup_name') ?? $service->title }}</h4>
                <div class="date-time"><i class="fa fa-calendar"></i> {{ Request::query('pickup_date') }} {{ Request::query('pickup_time') }}</div>
            </div>
            
            @if(Request::query('dropoff_name'))
            <div class="col-itinerary center">
                <div style="color: #ccc;">------------ <i class="fa fa-car" style="color: #ff6d38;"></i> ------------</div>
            </div>
            <div class="col-itinerary text-right">
                <p>&nbsp;</p>
                <h4>{{ Request::query('dropoff_name') }}</h4>
                <div class="date-time justify-content-end">{{ Request::query('distance') }} kms</div>
            </div>
            @endif
        </div>
    </div>
    
    <div class="row">
        <!-- LEFT COLUMN -->
        <div class="col-md-8">
            <div class="review-block">
                <div class="car-meta-flex">
                    <img src="{{ $service->image_url ?? asset('images/default-car.jpg') }}" alt="{{ $service->title }}">
                    <div>
                        <h3>{{ $service->title }}</h3>
                        <p>or similar</p>
                        <p class="mt-2 text-dark font-weight-bold">
                            @if($service->passenger) {{ $service->passenger }} Seats • @endif AC
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="review-block">
                <h4 style="font-size: 14px; color: #757575; font-weight: 600; text-transform: uppercase; margin-bottom: 15px;">Inclusions</h4>
                <ul class="inclusions-list">
                    <li>
                        <strong>{{ Request::query('distance') ?? '40' }} Km included</strong>
                        ₹15.0/km will apply beyond the included kms
                    </li>
                    <li>
                        <strong>Toll, tax and other charges</strong>
                        Toll, State Tax, Airport Entry, Parking charges are included
                    </li>
                    <li>
                        <strong>Driver allowance</strong>
                        Driver food and accommodation(stay) charges are included
                    </li>
                    <li>
                        <strong>Fuel charges included</strong>
                        Fuel cost for your trip is included in the fare
                    </li>
                </ul>
            </div>
            
            <div class="review-block">
                <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 20px;">Traveller Details</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-size: 12px; font-weight: 600; color: #4a4a4a;">FIRST NAME <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" value="{{$user->first_name ?? ''}}" placeholder="Enter first name" style="background: #f4f5f5; border: none; border-radius: 4px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-size: 12px; font-weight: 600; color: #4a4a4a;">LAST NAME <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" value="{{$user->last_name ?? ''}}" placeholder="Enter last name" style="background: #f4f5f5; border: none; border-radius: 4px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-size: 12px; font-weight: 600; color: #4a4a4a;">MOBILE NUMBER <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" value="{{$user->phone ?? ''}}" placeholder="+91" style="background: #f4f5f5; border: none; border-radius: 4px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-size: 12px; font-weight: 600; color: #4a4a4a;">EMAIL ID <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{$user->email ?? ''}}" placeholder="Enter email" style="background: #f4f5f5; border: none; border-radius: 4px;">
                        </div>
                    </div>
                    <input type="hidden" name="country" value="IN">
                </div>
            </div>
            
        </div>
        
        <!-- RIGHT COLUMN -->
        <div class="col-md-4">
            <div class="right-fare-breakup mb-4">
                <h4>Payment options</h4>
                @include ('Booking::frontend/booking/checkout-deposit')
                @include ($service->checkout_form_payment_file ?? 'Booking::frontend/booking/checkout-payment')
            </div>
            
            <div class="right-fare-breakup">
                <a href="#" style="float: right; font-size: 13px; color: #2276e3; font-weight: 600; text-decoration: none;">Hide Fare Break up <i class="fa fa-angle-up"></i></a>
                <h4 style="margin-bottom: 20px;">Fare Details</h4>
                
                <div class="fare-item">
                    <span>Base Fare</span>
                    <span class="text-dark">{{ format_money($booking->total_before_extra_price ?? $booking->total) }}</span>
                </div>
                <div class="fare-item text-success">
                    <span>GST & Taxes</span>
                    <span>Included</span>
                </div>
                
                @php $extra_price = $booking->getJsonMeta('extra_price') @endphp
                @if(!empty($extra_price))
                    @foreach($extra_price as $type)
                        <div class="fare-item">
                            <span>{{$type['name_'.$lang_local] ?? $type['name']}}</span>
                            <span>{{format_money($type['price'])}}</span>
                        </div>
                    @endforeach
                @endif
                
                <div class="fare-item total">
                    <span>To Pay</span>
                    <span>{{ format_money($booking->total) }}</span>
                </div>
                
                <div class="form-group mt-3">
                    <label class="term-conditions-checkbox" style="font-size: 12px;">
                        <input type="checkbox" name="term_conditions" checked> I agree to the <a target="_blank" href="#">Terms and Conditions</a>
                    </label>
                </div>
                
                <p class="alert-text mt10" v-show=" message.content" v-html="message.content" :class="{'danger':!message.type,'success':message.type}"></p>
                
                <button class="btn-pay-now" @click="doCheckout">
                    PAY NOW <i class="fa fa-spin fa-spinner" v-show="onSubmit"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .goibibo-review-wrapper {
        font-family: 'Inter', sans-serif;
    }
    .goibibo-review-wrapper .review-block {
        background: #fff;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #e0e0e0;
    }
    .goibibo-review-wrapper .trip-summary-block h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #000;
    }
    .goibibo-review-wrapper .trip-summary-block p {
        color: #4a4a4a;
        margin: 0;
        font-size: 14px;
    }
    .goibibo-review-wrapper .car-details-block img {
        width: 140px;
        height: auto;
        border-radius: 4px;
        margin-right: 20px;
    }
    .goibibo-review-wrapper .car-details-block h3 {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    .goibibo-review-wrapper .car-details-block p {
        color: #777;
        margin: 0;
        font-size: 14px;
    }
    .goibibo-review-wrapper .inclusions-block h4,
    .goibibo-review-wrapper .extra-prices-block h4,
    .goibibo-review-wrapper .fare-breakup-block h4 {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #000;
    }
    .goibibo-review-wrapper .inclusions-block ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .goibibo-review-wrapper .inclusions-block ul li {
        position: relative;
        padding-left: 20px;
        margin-bottom: 10px;
        font-size: 14px;
        color: #4a4a4a;
    }
    .goibibo-review-wrapper .inclusions-block ul li::before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #22c55e;
        font-weight: bold;
    }
    .goibibo-review-wrapper .extra-prices-block label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f9f9f9;
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 10px;
        cursor: pointer;
        border: 1px solid #eaeaea;
        font-weight: 500;
    }
    .goibibo-review-wrapper .extra-prices-block input[type=checkbox] {
        margin-right: 10px;
        width: 18px;
        height: 18px;
    }
    .goibibo-review-wrapper .fare-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
        color: #4a4a4a;
    }
    .goibibo-review-wrapper .total-amount {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        font-size: 20px;
        font-weight: 700;
        color: #000;
    }
    .goibibo-review-wrapper .btn-pay {
        background: #ff6d38;
        border: none;
        color: #fff;
        font-weight: 700;
        font-size: 16px;
        padding: 14px;
        border-radius: 6px;
        margin-top: 20px;
        transition: 0.3s;
    }
    .goibibo-review-wrapper .btn-pay:hover {
        background: #e65a28;
    }
    .goibibo-review-wrapper .sticky-right {
        position: sticky;
        top: 20px;
    }
    
    /* We must hide original inputs to let Vue submit properly */
    .d-none-form { display: none; }
</style>

<div id="bravo_car_book_app" v-cloak class="goibibo-review-wrapper">
    <!-- Hidden inputs for Vue to work internally -->
    <div class="d-none-form">
        <input type="text" class="start_date" ref="start_date">
    </div>

    <div class="row">
        <!-- LEFT COLUMN -->
        <div class="col-md-8">
            
            <!-- Trip Summary -->
            <div class="review-block trip-summary-block">
                @if(Request::query('trip_type') == 'hourly')
                    <h4>Hourly Rental: {{ Request::query('pickup_name') }}</h4>
                    <p>{{ Request::query('pickup_date') }} | {{ Request::query('pickup_time') }} • {{ Request::query('hourly_package') == '4hr' ? '4 Hrs / 40 Kms' : '8 Hrs / 80 Kms' }}</p>
                @elseif(Request::query('trip_type') == 'airport')
                    <h4>Airport Transfer: {{ Request::query('pickup_name') }}</h4>
                    <p>{{ Request::query('pickup_date') }} | {{ Request::query('pickup_time') }}</p>
                @else
                    <h4>{{ Request::query('pickup_name') }} <i class="fa fa-long-arrow-right mx-2 text-muted"></i> {{ Request::query('dropoff_name') }}</h4>
                    <p>{{ Request::query('pickup_date') }} | {{ Request::query('pickup_time') }} • {{ Request::query('distance') }} Kms Approx</p>
                @endif
            </div>

            <!-- Car Details -->
            <div class="review-block car-details-block">
                <div class="d-flex align-items-center">
                    <img src="{{ $row->image_url }}" alt="{{ $row->title }}">
                    <div>
                        <h3>{{ $row->title }}</h3>
                        <p>
                            @if($row->passenger) {{ $row->passenger }} Seats • @endif
                            @if($row->baggage) {{ $row->baggage }} Bags • @endif
                            @if($row->door) {{ $row->door }} Doors • @endif
                            AC
                        </p>
                    </div>
                </div>
            </div>

            <!-- Inclusions -->
            <div class="review-block inclusions-block">
                <h4>Inclusions</h4>
                <div class="row">
                    <div class="col-md-6">
                        <ul>
                            @if(Request::query('trip_type') == 'hourly')
                                <li>{{ Request::query('hourly_package') == '4hr' ? '40 Kms' : '80 Kms' }} included</li>
                            @else
                                <li>{{ Request::query('distance') }} Kms included</li>
                            @endif
                            <li>Base Fare</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li>Driver Allowance</li>
                            <li>State Tax & Tolls (if applicable)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Special Requests / Extra Prices -->
            <div class="review-block extra-prices-block" v-if="extra_price.length">
                <h4>Special Requests</h4>
                <div class="row">
                    <div class="col-md-6" v-for="(type,index) in extra_price" :key="index">
                        <label>
                            <span>
                                <input type="checkbox" true-value="1" false-value="0" v-model="type.enable"> @{{type.name}}
                            </span>
                            <span class="text-primary">@{{type.price_html}}</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="review-block">
                <h4>Important Information</h4>
                <ul class="text-muted" style="font-size: 13px; padding-left: 15px;">
                    <li>Your cab details will be shared 30 mins before pickup.</li>
                    <li>For airport pickups, parking charges are usually extra.</li>
                    <li>Night charges may apply if traveling between 10 PM and 6 AM.</li>
                </ul>
            </div>
            
            <!-- Message from server -->
            <div class="alert mt-3" v-if="message.content" :class="{'alert-danger':!message.type,'alert-success':message.type}">
                @{{message.content}}
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-md-4">
            <div class="sticky-right">
                <div class="review-block fare-breakup-block">
                    <h4>Fare Breakup</h4>
                    
                    <div class="fare-item">
                        <span>Base Fare</span>
                        <span class="text-dark font-weight-bold">@{{ price_html }}</span>
                    </div>
                    
                    <div class="fare-item text-success">
                        <span>Taxes & Surcharges</span>
                        <span>Included</span>
                    </div>

                    <div class="fare-item" v-for="(type,index) in extra_price" v-if="type.enable" :key="index">
                        <span>@{{ type.name }}</span>
                        <span>@{{ type.price_html }}</span>
                    </div>

                    <hr>

                    <div class="total-amount">
                        <span>Total Amount</span>
                        <span>@{{ total_price_html }}</span>
                    </div>
                    
                    <button @click="doSubmit($event)" class="btn btn-pay w-100" :class="{'disabled':onSubmit}">
                        CONTINUE TO BOOK <i class="fa fa-spinner fa-spin" v-if="onSubmit"></i>
                    </button>
                    <p class="text-center text-muted mt-3" style="font-size: 12px;">You will enter Traveller Details next.</p>
                </div>
            </div>
        </div>
    </div>
</div>

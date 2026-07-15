<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Invoice</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            width: 100%;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #d4441c;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #d4441c;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #666;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #d4441c;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }
        .table th {
            text-align: left;
            background-color: #f9fafb;
            color: #64748b;
        }
        .val-right {
            text-align: right;
            font-weight: bold;
        }
        .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #d4441c;
        }
        .list-item {
            display: inline-block;
            width: 48%;
            margin-bottom: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            @if( !empty($logo_id = setting_item('logo_invoice_id') ?? setting_item('logo_id') ))
                @php $logo_url = get_file_url($logo_id, 'full'); @endphp
                <img src="{{ $logo_url }}" alt="{{ setting_item('site_title', 'MakeMyTravels') }}" style="max-width: 200px; height: auto;"/>
            @else
                <h1>{{ setting_item('site_title', 'MakeMyTravels') }}</h1>
            @endif
            <p style="margin-top: 10px;">Official Booking Invoice</p>
        </div>

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div class="section-title">Customer Information</div>
                    <strong>{{ $booking->first_name }} {{ $booking->last_name }}</strong><br>
                    Email: {{ $booking->email }}<br>
                    Phone: {{ $booking->phone }}<br>
                    Address: {{ $booking->address }} {{ $booking->address2 ? ', ' . $booking->address2 : '' }}<br>
                    {{ $booking->city }}, {{ $booking->state }} - {{ $booking->zip_code }}<br>
                    {{ $booking->country }}
                </td>
                <td style="width: 50%; vertical-align: top; text-align: right;">
                    <div class="section-title" style="text-align: right;">Booking Summary</div>
                    <strong>Booking ID:</strong> #{{ $booking->id }}<br>
                    <strong>Status:</strong> {{ $booking->statusName }}<br>
                    <strong>Payment Method:</strong> {{ $booking->gatewayObj ? $booking->gatewayObj->getOption('name') : 'N/A' }}<br>
                    @if($booking->wallet_transaction_id)
                        <strong>Transaction ID:</strong> TXN-{{ $booking->wallet_transaction_id }}<br>
                    @endif
                    <strong>Booking Date:</strong> {{ display_date($booking->created_at) }}
                </td>
            </tr>
        </table>

        <div class="section-title">Hotel & Stay Details</div>
        <table class="table">
            <tr>
                <th>Hotel Name</th>
                <td class="val-right">{{ $service->title ?? '' }}</td>
            </tr>
            @if($translation = $service->translateOrOrigin(app()->getLocale()))
                @if($translation->address)
                    <tr>
                        <th>Address</th>
                        <td class="val-right">{{ $translation->address }}</td>
                    </tr>
                @endif
            @endif
            @if($service->map_lat && $service->map_lng)
                <tr>
                    <th>Geo Location</th>
                    <td class="val-right">
                        <a href="https://www.google.com/maps/search/?api=1&query={{$service->map_lat}},{{$service->map_lng}}" target="_blank" style="color: #0284c7; text-decoration: none;">View on Map ({{$service->map_lat}}, {{$service->map_lng}})</a>
                    </td>
                </tr>
            @endif
            @if($service->author && $service->author->phone)
                <tr>
                    <th>Hotel Contact</th>
                    <td class="val-right">{{ $service->author->phone }}</td>
                </tr>
            @endif
            <tr>
                <th>Check-In</th>
                <td class="val-right">{{ display_date($booking->start_date) }}</td>
            </tr>
            <tr>
                <th>Check-Out</th>
                <td class="val-right">{{ display_date($booking->end_date) }}</td>
            </tr>
            <tr>
                <th>Nights</th>
                <td class="val-right">{{ $booking->duration_nights }}</td>
            </tr>
            <tr>
                <th>Guests</th>
                <td class="val-right">
                    {{ $booking->getMeta('adults') }} Adults
                    @if($booking->getMeta('children'))
                        , {{ $booking->getMeta('children') }} Children
                    @endif
                </td>
            </tr>
        </table>

        <!-- Facilities -->
        @php
            $terms_ids = $service->terms->pluck('term_id');
            $attributes = \Modules\Core\Models\Terms::getTermsById($terms_ids);
        @endphp
        @if(!empty($terms_ids) and !empty($attributes))
            <div class="section-title">Facilities & Amenities</div>
            <div style="margin-bottom: 20px;">
                @foreach($attributes as $key => $attribute )
                    @if(!empty($attribute['child']))
                        <div style="margin-bottom: 10px;">
                            <strong>{{ $attribute['parent']->name }}:</strong>
                            <div style="margin-top: 5px;">
                                @php $term_names = []; @endphp
                                @foreach($attribute['child'] as $term)
                                    @php $term_names[] = $term->name; @endphp
                                @endforeach
                                {{ implode(', ', $term_names) }}
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="section-title">Pricing Breakdown</div>
        <table class="table">
            @php $rooms = \Modules\Hotel\Models\HotelRoomBooking::getByBookingId($booking->id) @endphp
            @if(!empty($rooms))
                @foreach($rooms as $room)
                    <tr>
                        <th style="font-weight: 500;">{{$room->room->title}} (x{{$room->number}})</th>
                        <td class="val-right">{{format_money($room->price * $room->number)}}</td>
                    </tr>
                @endforeach
            @endif
            
            <!-- Extra Prices -->
            @php $extra_price = $booking->getJsonMeta('extra_price') @endphp
            @if(!empty($extra_price))
                @foreach($extra_price as $type)
                    <tr>
                        <th style="font-weight: 500;">{{$type['name']}}</th>
                        <td class="val-right">{{format_money($type['total'] ?? 0)}}</td>
                    </tr>
                @endforeach
            @endif

            <!-- Subtotal before taxes/fees -->
            @if($booking->total_before_fees)
            <tr>
                <th style="font-size: 15px; color: #1e293b; padding-top: 15px; border-top: 1px solid #e2e8f0;">Subtotal</th>
                <td class="val-right" style="padding-top: 15px; border-top: 1px solid #e2e8f0; font-weight: bold;">{{format_money($booking->total_before_fees)}}</td>
            </tr>
            @endif

            <!-- Fees -->
            @php
                $list_all_fee = [];
                if(!empty($booking->buyer_fees)){
                    $list_all_fee = json_decode($booking->buyer_fees , true);
                }
                if(!empty($vendor_service_fee = $booking->vendor_service_fee)){
                    $list_all_fee = array_merge($list_all_fee , $vendor_service_fee);
                }
            @endphp
            @if(!empty($list_all_fee))
                @foreach ($list_all_fee as $item)
                    @php
                        $fee_price = $item['price'];
                        if(!empty($item['unit']) and $item['unit'] == "percent"){
                            $fee_price = ( $booking->total_before_fees / 100 ) * $item['price'];
                        }
                    @endphp
                    <tr>
                        <th style="color: #64748b; font-weight: normal; font-size: 12px;">
                            {{$item['name_'.app()->getLocale()] ?? $item['name']}}
                            @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                (x{{$booking->total_guests}} Guests)
                            @endif
                            @if(!empty($item['unit']) and $item['unit'] == "percent")
                                ({{$item['price']}}%)
                            @endif
                        </th>
                        <td class="val-right" style="color: #64748b; font-size: 12px;">
                            @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                {{ format_money( $fee_price * $booking->total_guests ) }}
                            @else
                                {{ format_money( $fee_price ) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th style="color: #64748b; font-weight: normal; font-size: 12px;">Taxes & Fees</th>
                    <td class="val-right" style="color: #64748b; font-size: 12px;">{{format_money(0)}}</td>
                </tr>
            @endif

            <tr>
                <th style="font-size: 16px; color: #1e293b; padding-top: 15px; border-top: 2px solid #e2e8f0;">Grand Total</th>
                <td class="val-right grand-total" style="padding-top: 15px; border-top: 2px solid #e2e8f0;">{{format_money($booking->total)}}</td>
            </tr>
            @if($booking->total > $booking->paid)
                <tr>
                    <th>Amount Paid</th>
                    <td class="val-right" style="color: #16a34a;">{{format_money($booking->paid)}}</td>
                </tr>
                <tr>
                    <th>Remaining Balance</th>
                    <td class="val-right" style="color: #ef4444;">{{format_money($booking->total - $booking->paid)}}</td>
                </tr>
            @endif
        </table>

        <!-- Terms and Policy -->
        @if($translation = $service->translateOrOrigin(app()->getLocale()))
            @if($translation->policy)
                <div class="section-title">Hotel Policies & Terms</div>
                <ul style="margin: 0; padding-left: 20px; font-size: 12px; color: #555;">
                    @foreach($translation->policy as $key => $item)
                        @if(is_array($item) && isset($item['title']))
                            <li style="margin-bottom: 5px;">
                                <strong>{{$item['title']}}</strong>: {!! $item['content'] !!}
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        @endif

        <!-- Footer -->
        <div class="footer">
            Thank you for booking with {{ setting_item('site_title', 'MakeMyTravels') }}!<br>
            If you have any questions, please contact our support team.
        </div>
    </div>
</body>
</html>

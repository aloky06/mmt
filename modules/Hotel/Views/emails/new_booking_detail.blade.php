<?php
$translation = $service->translateOrOrigin(app()->getLocale());
$lang_local = app()->getLocale();
?>
<div class="b-panel-title" style="font-size: 20px; font-weight: bold; margin: 0 0 20px 0; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
    {{__('Hotel Information & Invoice')}}
</div>
<div class="b-table-wrap">
    <table class="b-table" style="width: 100%; border-collapse: collapse; text-align: left; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;" cellspacing="0" cellpadding="0">
        <tr>
            <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Booking Number')}}</td>
            <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold; text-align: right;">#{{$booking->id}}</td>
        </tr>
        <tr>
            <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Booking Status')}}</td>
            <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold; text-align: right;">{{$booking->statusName}}</td>
        </tr>
        @if($booking->gatewayObj)
            <tr>
                <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Payment method')}}</td>
                <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold; text-align: right;">{{$booking->gatewayObj->getOption('name')}}</td>
            </tr>
        @endif
        @if($booking->gatewayObj and $note = $booking->gatewayObj->getOption('payment_note'))
            <tr>
                <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Payment Note')}}</td>
                <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; text-align: right;">{!! clean($note) !!}</td>
            </tr>
        @endif
        <tr>
            <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Hotel name')}}</td>
            <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #d4441c; font-weight: bold; text-align: right;">
                <a href="{{$service->getDetailUrl()}}" style="color: #d4441c; text-decoration: none;">{!! clean($translation->title) !!}</a>
            </td>
        </tr>
        <tr>
            @if($translation->address)
                <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Address')}}</td>
                <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold; text-align: right;">
                    {{$translation->address}}
                </td>
            @endif
        </tr>
        @if($service->map_lat && $service->map_lng)
            <tr>
                <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Geo Location')}}</td>
                <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold; text-align: right;">
                    <a href="https://www.google.com/maps/search/?api=1&query={{$service->map_lat}},{{$service->map_lng}}" target="_blank" style="color: #0284c7; text-decoration: none;">View on Map ({{$service->map_lat}}, {{$service->map_lng}})</a>
                </td>
            </tr>
        @endif
        @if($service->author && $service->author->phone)
            <tr>
                <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Hotel Contact')}}</td>
                <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold; text-align: right;">
                    {{$service->author->phone}}
                </td>
            </tr>
        @endif
        @if($booking->start_date && $booking->end_date)
            <tr>
                <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Start date')}}</td>
                <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold; text-align: right;">{{display_date($booking->start_date)}}</td>
            </tr>
            <tr>
                <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('End date:')}}</td>
                <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold; text-align: right;">
                    {{display_date($booking->end_date)}}
                </td>
            </tr>
            <tr>
                <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Nights:')}}</td>
                <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold; text-align: right;">
                    {{$booking->duration_nights}}
                </td>
            </tr>
        @endif

        @if($meta = $booking->getMeta('adults'))
            <tr>
                <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Adults')}}:</td>
                <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; text-align: right;">
                    <strong>{{$meta}}</strong>
                </td>
            </tr>
        @endif
        @if($meta = $booking->getMeta('children'))
            <tr>
                <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Children')}}:</td>
                <td class="val" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; text-align: right;">
                    <strong>{{$meta}}</strong>
                </td>
            </tr>
        @endif
        <tr>
            <td class="label" style="padding: 20px 10px 12px 10px; border-bottom: 1px solid #e2e8f0; color: #1e293b; font-weight: bold; font-size: 16px;">{{__('Pricing Breakdown')}}</td>
            <td class="val" style="padding: 20px 10px 12px 10px; border-bottom: 1px solid #e2e8f0;"></td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 0;">
                <table class="pricing-list" style="width: 100%; border-collapse: collapse;">
                    @php $rooms = \Modules\Hotel\Models\HotelRoomBooking::getByBookingId($booking->id) @endphp
                    @if(!empty($rooms))
                        @foreach($rooms as $room)
                            <tr>
                                <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-weight: 500;">{{$room->room->title}} (x{{$room->number}}):</td>
                                <td class="val no-r-padding" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; text-align: right;">
                                    <strong>{{format_money($room->price * $room->number)}}</strong>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    @php $extra_price = $booking->getJsonMeta('extra_price')@endphp

                    @if(!empty($extra_price))
                        <tr>
                            <td colspan="2" class="label-title" style="padding: 15px 10px 5px 10px; color: #1e293b;"><strong>{{__("Extra Prices:")}}</strong></td>
                        </tr>
                        <tr class="">
                            <td colspan="2" class="no-r-padding no-b-border" style="padding: 0;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    @foreach($extra_price as $type)
                                        <tr>
                                            <td class="label" style="padding: 8px 10px; color: #1e293b; font-weight: 500; border-bottom: 1px solid #f1f5f9;">{{$type['name']}}:</td>
                                            <td class="val no-r-padding" style="padding: 8px 10px; color: #0f172a; text-align: right; border-bottom: 1px solid #f1f5f9;">
                                                <strong>{{format_money($type['total'] ?? 0)}}</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    @endif

                    <!-- Subtotal before taxes/fees -->
                    @if($booking->total_before_fees)
                    <tr>
                        <td class="label" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-weight: 500; font-size: 15px;">{{__('Subtotal')}}</td>
                        <td class="val no-r-padding" style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; text-align: right; font-weight: bold; font-size: 15px;">
                            {{format_money($booking->total_before_fees)}}
                        </td>
                    </tr>
                    @endif

                    @php
                        $list_all_fee = [];
                        if(!empty($booking->buyer_fees)){
                            $buyer_fees = json_decode($booking->buyer_fees , true);
                            $list_all_fee = $buyer_fees;
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
                                <td class="label" style="padding: 8px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: normal; font-size: 13px;">
                                    {{$item['name_'.$lang_local] ?? $item['name']}}
                                    @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                        : {{$booking->total_guests}} * {{format_money( $fee_price )}}
                                    @endif
                                    @if(!empty($item['unit']) and $item['unit'] == "percent")
                                        ({{$item['price']}}%)
                                    @endif
                                </td>
                                <td class="val" style="padding: 8px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; text-align: right; font-size: 13px;">
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
                            <td class="label" style="padding: 8px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: normal; font-size: 13px;">{{__('Taxes & Fees')}}</td>
                            <td class="val no-r-padding" style="padding: 8px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; text-align: right; font-size: 13px;">
                                {{format_money(0)}}
                            </td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <td class="label fsz21" style="padding: 20px 10px; font-size: 20px; font-weight: bold; color: #1e293b;">{{__('Grand Total')}}</td>
            <td class="val fsz21" style="padding: 20px 10px; font-size: 20px; font-weight: bold; text-align: right; color: #d4441c;">
                <strong>{{format_money($booking->total)}}</strong>
            </td>
        </tr>
        @if($booking->total > $booking->paid)
        <tr>
            <td class="label fsz21" style="padding: 10px 10px; font-size: 18px; font-weight: bold; color: #64748b; border-top: 1px dashed #cbd5e1;">{{__('Amount Paid')}}</td>
            <td class="val fsz21" style="padding: 10px 10px; font-size: 18px; font-weight: bold; text-align: right; color: #16a34a; border-top: 1px dashed #cbd5e1;">
                <strong>{{format_money($booking->paid)}}</strong>
            </td>
        </tr>
        <tr>
            <td class="label fsz21" style="padding: 10px 10px; font-size: 18px; font-weight: bold; color: #1e293b;">{{__('Remaining Balance')}}</td>
            <td class="val fsz21" style="padding: 10px 10px; font-size: 18px; font-weight: bold; text-align: right; color: #ef4444;">
                <strong>{{format_money($booking->total - $booking->paid)}}</strong>
            </td>
        </tr>
        @endif
    </table>
</div>
<div class="text-center mt20" style="text-align: center; margin-top: 30px;">
    <a href="{{ route("user.booking_history") }}" target="_blank" class="btn btn-primary manage-booking-btn" style="display: inline-block; background-color: #d4441c; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: bold; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">{{__('Manage Bookings')}}</a>
</div>

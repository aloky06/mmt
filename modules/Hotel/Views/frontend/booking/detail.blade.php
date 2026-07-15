@php $lang_local = app()->getLocale() @endphp
<div class="booking-review bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
    <!-- Header -->
    <div class="p-6 bg-gradient-to-br from-gray-50 to-white border-b border-gray-100">
        <h4 class="text-xl font-black text-gray-900 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            {{__("Booking Summary")}}
        </h4>
        
        <div class="flex gap-4">
            <!-- Thumbnail -->
            <div class="w-24 h-24 shrink-0 rounded-lg overflow-hidden shadow-sm">
                @if($image_url = $service->image_url)
                    @if(!empty($disable_lazyload))
                        <img src="{{$service->image_url}}" class="w-full h-full object-cover" alt="{!! clean($service_translation->title) !!}">
                    @else
                        {!! get_image_tag($service->image_id,'medium',['class'=>'w-full h-full object-cover','alt'=>$service_translation->title]) !!}
                    @endif
                @endif
            </div>
            
            <!-- Details -->
            <div class="flex-1">
                @php
                    $service_translation = $service->translateOrOrigin($lang_local);
                @endphp
                <h3 class="text-base font-bold text-gray-900 leading-tight mb-2 hover:text-brand transition-colors">
                    <a href="{{$service->getDetailUrl()}}">{!! clean($service_translation->title) !!}</a>
                </h3>
                
                @if($service_translation->address)
                    <p class="text-xs text-gray-500 flex items-start gap-1">
                        <svg class="w-4 h-4 text-brand shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{$service_translation->address}}
                    </p>
                @endif
                
                @php $vendor = $service->author; @endphp
                @if($vendor->hasPermissionTo('dashboard_vendor_access') and !$vendor->hasPermissionTo('dashboard_access'))
                    <div class="mt-2 text-xs text-gray-600 bg-gray-100 rounded px-2 py-1 inline-block">
                        <i class="icofont-info-circle text-brand"></i>
                        {{ __("Vendor") }}: <a href="{{route('user.profile',['id'=>$vendor->id])}}" target="_blank" class="font-bold hover:underline">{{$vendor->getDisplayName()}}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Dates & Guests -->
    <div class="p-6 border-b border-gray-100 bg-white">
        <ul class="space-y-3">
            @if($booking->start_date)
                <li class="flex justify-between items-center text-sm">
                    <div class="text-gray-500 font-semibold">{{__('Check-in:')}}</div>
                    <div class="font-bold text-gray-900">{{display_date($booking->start_date)}}</div>
                </li>
                <li class="flex justify-between items-center text-sm">
                    <div class="text-gray-500 font-semibold">{{__('Check-out:')}}</div>
                    <div class="font-bold text-gray-900">{{display_date($booking->end_date)}}</div>
                </li>
                <li class="flex justify-between items-center text-sm">
                    <div class="text-gray-500 font-semibold">{{__('Duration:')}}</div>
                    <div class="font-bold text-gray-900">{{$booking->duration_nights}} {{__('Nights')}}</div>
                </li>
            @endif
            
            @if($meta = $booking->getMeta('adults'))
                <li class="flex justify-between items-center text-sm">
                    <div class="text-gray-500 font-semibold">{{__('Adults:')}}</div>
                    <div class="font-bold text-gray-900">{{$meta}}</div>
                </li>
            @endif
            
            @if($meta = $booking->getMeta('children'))
                <li class="flex justify-between items-center text-sm">
                    <div class="text-gray-500 font-semibold">{{__('Children:')}}</div>
                    <div class="font-bold text-gray-900">{{$meta}}</div>
                </li>
            @endif
        </ul>
    </div>
    
    <!-- Cost Breakdown -->
    <div class="p-6 bg-gray-50">
        <ul class="space-y-4">
            
            <!-- Rooms -->
            @php $rooms = \Modules\Hotel\Models\HotelRoomBooking::getByBookingId($booking->id) @endphp
            @if(!empty($rooms))
                @foreach($rooms as $room)
                    <li class="flex justify-between items-start text-sm pb-3 border-b border-gray-200 border-dashed last:border-0 last:pb-0">
                        <div class="text-gray-700 font-semibold pr-4">
                            {{$room->room->title}} <span class="text-gray-400 font-normal">x {{$room->number}}</span>
                        </div>
                        <div class="font-bold text-gray-900 whitespace-nowrap">
                            {{format_money($room->price * $room->number)}}
                        </div>
                    </li>
                @endforeach
                
                <li class="pt-2 text-center">
                    <a href="#" class="text-brand text-xs font-bold uppercase tracking-wider hover:underline flex justify-center items-center gap-1" data-toggle="modal" data-target="#detailBookingDate{{$booking->code}}" aria-expanded="false" aria-controls="detailBookingDate{{$booking->code}}">
                        <i class="icofont-list"></i> {{__('View Room Details')}}
                    </a>
                </li>
            @endif
            
            <!-- Extras -->
            @php $extra_price = $booking->getJsonMeta('extra_price') @endphp
            @if(!empty($extra_price))
                <li class="pt-4 mt-4 border-t border-gray-200">
                    <div class="text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">{{__("Add-ons:")}}</div>
                    <ul class="space-y-2">
                        @foreach($extra_price as $type)
                            <li class="flex justify-between items-start text-sm">
                                <div class="text-gray-600">
                                    {{$type['name_'.$lang_local] ?? $type['name']}}
                                </div>
                                <div class="font-bold text-gray-900 whitespace-nowrap">
                                    {{format_money($type['total'] ?? 0)}}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            
            <!-- Fees -->
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
                <li class="pt-4 mt-4 border-t border-gray-200">
                    <div class="text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">{{__("Taxes & Fees:")}}</div>
                    <ul class="space-y-2">
                        @foreach ($list_all_fee as $item)
                            @php
                                $fee_price = $item['price'];
                                if(!empty($item['unit']) and $item['unit'] == "percent"){
                                    $fee_price = ( $booking->total_before_fees / 100 ) * $item['price'];
                                }
                            @endphp
                            <li class="flex justify-between items-start text-sm">
                                <div class="text-gray-600 flex items-center gap-1">
                                    {{$item['name_'.$lang_local] ?? $item['name']}}
                                    <i class="icofont-info-circle text-gray-400 cursor-help" data-toggle="tooltip" data-placement="top" title="{{ $item['desc_'.$lang_local] ?? $item['desc'] }}"></i>
                                    @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                        <span class="text-xs">({{$booking->total_guests}}x)</span>
                                    @endif
                                </div>
                                <div class="font-bold text-gray-900 whitespace-nowrap">
                                    @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                        {{ format_money( $fee_price * $booking->total_guests ) }}
                                    @else
                                        {{ format_money( $fee_price ) }}
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            
            <!-- Coupon -->
            @includeIf('Coupon::frontend/booking/checkout-coupon')
            
            <!-- Total Final -->
            <li class="pt-6 mt-4 border-t-2 border-gray-900">
                <div class="flex justify-between items-end mb-2">
                    <div class="text-lg font-black text-gray-900 uppercase tracking-wide">{{__("Grand Total:")}}</div>
                    <div class="text-3xl font-black text-brand leading-none">{{format_money($booking->total)}}</div>
                </div>
                
                @if($booking->status !='draft')
                    <div class="flex justify-between items-center text-sm text-gray-500 mt-3">
                        <div>{{__("Amount Paid:")}}</div>
                        <div class="font-bold">{{format_money($booking->paid)}}</div>
                    </div>
                    @if($booking->paid < $booking->total )
                        <div class="flex justify-between items-center text-sm text-red-600 mt-1">
                            <div>{{__("Amount Due:")}}</div>
                            <div class="font-bold">{{format_money($booking->total - $booking->paid)}}</div>
                        </div>
                    @endif
                @endif
            </li>
            
            <!-- Deposit -->
            @include ('Booking::frontend/booking/checkout-deposit-amount')
            
        </ul>
    </div>
</div>

<?php
$dateDetail = $service->detailBookingEachDate($booking);
;?>
<!-- Room Detail Modal -->
<div class="modal fade" id="detailBookingDate{{$booking->code}}" tabindex="-1" role="dialog" aria-hidden="true" style="background-color: rgba(0,0,0,0.6)">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-xl border-0 overflow-hidden shadow-2xl">
            <div class="modal-header bg-gray-50 border-b border-gray-100">
                <h5 class="modal-title font-black text-gray-900 w-full text-center">{{__('Room Details')}}</h5>
                <button type="button" class="close absolute right-4 top-4 text-gray-400 hover:text-gray-900 outline-none" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-6">
                @if(!empty($rooms))
                    <ul class="space-y-6">
                    @foreach($rooms as $room)
                        <li class="pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                            <h6 class="font-bold text-gray-900 text-lg mb-3">{{$room->room->title}} <span class="text-gray-400 font-normal">x {{$room->number}}</span></h6>
                            @if(!empty($dateDetail[$room->room_id]))
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    @includeIf("Hotel::frontend.booking.detail-room",['roomDate'=>$dateDetail[$room->room_id]])
                                </div>
                            @endif
                            <div class="flex justify-between items-center font-black text-brand text-lg mt-4 px-2">
                                <span>{{__("Total:")}}</span>
                                <span>{{format_money($room->price * $room->number)}}</span>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

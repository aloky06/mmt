@extends('layouts.app')
@section('head')
    <link href="{{ asset('module/booking/css/checkout.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <style>
        /* Disable native style overrides, let Tailwind take over */
        .bravo-booking-page { padding-top: 40px; padding-bottom: 80px; }
        .bravo-booking-page svg { width: 1.5rem; height: 1.5rem; }
    </style>
@endsection
@section('content')
    <!-- TAILWIND CSS COMPILED -->
    <link href="{{ asset('css/checkout-tailwind.css') }}" rel="stylesheet">
    <div class="bravo-booking-page bg-[#f4f5f5] min-h-screen font-sans" >
        <div class="container mx-auto px-4" style="max-width:1200px;">
            <div id="bravo-checkout-page" >
                @if($service->type == 'car')
                    @include('Car::frontend.booking.checkout-layout')
                @else
                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Left Column: Traveller Details & Payment -->
                        <div class="lg:w-2/3">
                            <div class="booking-form bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
                                <h3 class="text-2xl font-black text-gray-900 mb-6 pb-4 border-b border-gray-100">{{__('Traveller Details')}}</h3>
                                @include ($service->checkout_form_file ?? 'Booking::frontend/booking/checkout-form')
                            </div>
                        </div>
                        
                        <!-- Right Column: Booking Summary -->
                        <div class="lg:w-1/3">
                            <div class="sticky top-[100px] z-20">
                                <div class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                                    @include ($service->checkout_booking_detail_file ?? '')
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('module/booking/js/checkout.js') }}"></script>
    <script type="text/javascript">
        jQuery(function () {
            $.ajax({
                'url': bookingCore.url + '{{$is_api ? '/api' : ''}}/booking/{{$booking->code}}/check-status',
                'cache': false,
                'type': 'GET',
                success: function (data) {
                    if (data.redirect !== undefined && data.redirect) {
                        window.location.href = data.redirect
                    }
                }
            });
        })

        $('.deposit_amount').on('change', function(){
            checkPaynow();
        });

        $('input[type=radio][name=how_to_pay]').on('change', function(){
            checkPaynow();
        });

        function checkPaynow(){
            var credit_input = $('.deposit_amount').val();
            var how_to_pay = $("input[name=how_to_pay]:checked").val();
            var convert_to_money = credit_input * {{ setting_item('wallet_credit_exchange_rate',1)}};

            if(how_to_pay == 'full'){
                var pay_now_need_pay = parseFloat({{floatval($booking->total)}}) - convert_to_money;
            }else{
                var pay_now_need_pay = parseFloat({{floatval($booking->deposit == null ? $booking->total : $booking->deposit)}}) - convert_to_money;
            }

            if(pay_now_need_pay < 0){
                pay_now_need_pay = 0;
            }
            $('.convert_pay_now').html(bravo_format_money(pay_now_need_pay));
            $('.convert_deposit_amount').html(bravo_format_money(convert_to_money));
        }


        jQuery(function () {
            $(".bravo_apply_coupon").click(function () {
                var parent = $(this).closest('.section-coupon-form');
                parent.find(".group-form .fa-spin").removeClass("d-none");
                parent.find(".message").html('');
                $.ajax({
                    'url': bookingCore.url + '/booking/{{$booking->code}}/apply-coupon',
                    'data': parent.find('input,textarea,select').serialize(),
                    'cache': false,
                    'method':"post",
                    success: function (res) {
                        parent.find(".group-form .fa-spin").addClass("d-none");
                        if (res.reload !== undefined) {
                            window.location.reload();
                        }
                        if(res.message && res.status === 1)
                        {
                            parent.find('.message').html('<div class="alert alert-success">' + res.message+ '</div>');
                        }
                        if(res.message && res.status === 0)
                        {
                            parent.find('.message').html('<div class="alert alert-danger">' + res.message+ '</div>');
                        }
                    }
                });
            });
            $(".bravo_remove_coupon").click(function (e) {
                e.preventDefault();
                var parent = $(this).closest('.section-coupon-form');
                var parentItem = $(this).closest('.item');
                parentItem.find(".fa-spin").removeClass("d-none");
                $.ajax({
                    'url': bookingCore.url + '/booking/{{$booking->code}}/remove-coupon',
                    'data': {
                        coupon_code:$(this).attr('data-code')
                    },
                    'cache': false,
                    'method':"post",
                    success: function (res) {
                        parentItem.find(".fa-spin").addClass("d-none");
                        if (res.reload !== undefined) {
                            window.location.reload();
                        }
                        if(res.message && res.status === 0)
                        {
                            parent.find('.message').html('<div class="alert alert-danger">' + res.message+ '</div>');
                        }
                    }
                });
            });
        })
    </script>
@endsection

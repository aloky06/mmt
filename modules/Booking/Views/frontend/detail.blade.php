@extends('layouts.app')
@section('head')
    <link href="{{ asset('css/checkout-tailwind.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="bravo-booking-page bg-[#f4f5f5] min-h-screen font-sans py-12" >
        <div class="container mx-auto px-4" style="max-width:1200px;">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column: Success Message & Booking Info -->
                <div class="lg:w-2/3 space-y-8">
                    <!-- Success Banner -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 flex items-start gap-6">
                        <div class="w-16 h-16 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-gray-900 mb-2">
                                <span>{{$booking->first_name}},</span> {{__('your order was submitted successfully!')}}
                            </h2>
                            <p class="text-gray-600 text-sm mb-4">
                                {{__('Booking details has been sent to:')}} <span class="font-bold text-gray-900">{{$booking->email}}</span>
                            </p>
                            @if($note = $gateway->getOption("payment_note"))
                                <div class="bg-blue-50 text-blue-800 text-sm p-4 rounded-lg border border-blue-100">
                                    {!! clean($note) !!}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Customer Info File Inclusion -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
                        @include ($service->booking_customer_info_file ?? 'Booking::frontend/booking/booking-customer-info')
                        
                        <div class="mt-8 pt-8 border-t border-gray-100 flex gap-4">
                            <a href="{{route('user.booking_history')}}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-brand hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand transition-colors w-full sm:w-auto">
                                {{__('View Booking History')}}
                            </a>
                            <a href="{{url('/')}}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand transition-colors w-full sm:w-auto">
                                {{__('Back to Home')}}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Booking Summary & Details -->
                <div class="lg:w-1/3 space-y-6">
                    <!-- Quick Details -->
                    <div class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 p-4 border-b border-gray-100">
                            <h4 class="text-lg font-bold text-gray-900">{{__('Quick Info')}}</h4>
                        </div>
                        <ul class="p-6 space-y-4 text-sm">
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500">{{__('Booking Number')}}</span>
                                <span class="font-bold text-gray-900">#{{$booking->id}}</span>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500">{{__('Booking Date')}}</span>
                                <span class="font-bold text-gray-900">{{display_date($booking->created_at)}}</span>
                            </li>
                            @if(!empty($gateway))
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500">{{__('Payment Method')}}</span>
                                    <span class="font-bold text-gray-900">{{$gateway->name}}</span>
                                </li>
                            @endif
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500">{{__('Booking Status')}}</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($booking->status == 'completed') bg-green-100 text-green-800 
                                    @elseif($booking->status == 'processing') bg-blue-100 text-blue-800 
                                    @elseif($booking->status == 'cancelled') bg-red-100 text-red-800 
                                    @else bg-gray-100 text-gray-800 @endif
                                ">
                                    {{ $booking->status_name }}
                                </span>
                            </li>
                        </ul>
                    </div>

                    <!-- Summary Inclusion -->
                    <div class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                        @include ($service->checkout_booking_detail_file ?? '')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
@endsection

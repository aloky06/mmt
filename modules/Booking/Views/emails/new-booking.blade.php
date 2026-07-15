@extends('Email::layout')
@section('content')

    <div class="b-container" style="max-width: 600px; margin: 0 auto; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
        <div class="b-panel" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            
            <!-- Header Banner -->
            <div style="background-color: #d4441c; color: #ffffff; padding: 40px 30px; text-align: center;">
                @switch($to)
                    @case ('admin')
                        <h2 style="margin: 0; font-size: 28px; font-weight: bold; letter-spacing: -0.5px;">{{__('New Booking Alert')}}</h2>
                        <p style="margin: 12px 0 0 0; font-size: 16px; opacity: 0.9;">{{__('A new booking has been made on the platform.')}}</p>
                    @break
                    @case ('vendor')
                        <h2 style="margin: 0; font-size: 28px; font-weight: bold; letter-spacing: -0.5px;">{{__('New Booking Received!')}}</h2>
                        <p style="margin: 12px 0 0 0; font-size: 16px; opacity: 0.9;">{{__('Hello :name',['name'=>$booking->vendor->nameOrEmail ?? ''])}}, {{__('your property has a new booking.')}}</p>
                    @break
                    @case ('customer')
                        <h2 style="margin: 0; font-size: 28px; font-weight: bold; letter-spacing: -0.5px;">{{__('Booking Confirmed')}}</h2>
                        <p style="margin: 12px 0 0 0; font-size: 16px; opacity: 0.9;">{{__('Hello :name',['name'=>$booking->first_name ?? ''])}}, {{__('thank you for booking with us. Here is your official invoice.')}}</p>
                    @break
                @endswitch
            </div>

            <!-- Booking Details / Invoice -->
            <div style="padding: 30px;">
                @include($service->email_new_booking_file ?? '')
            </div>
        </div>

        <!-- Customer Panel -->
        <div style="margin-top: 24px;">
            @include('Booking::emails.parts.panel-customer')
        </div>
        
        <!-- Footer Note -->
        <div style="text-align: center; padding: 20px; color: #64748b; font-size: 13px;">
            <p style="margin: 0;">{{__('If you have any questions about this invoice, simply reply to this email or reach out to our support team for help.')}}</p>
        </div>
    </div>

@endsection

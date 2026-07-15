<div class="b-panel" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <div class="b-panel-title" style="background-color: #f8fafc; padding: 20px 30px; border-bottom: 1px solid #e2e8f0; font-size: 20px; font-weight: bold; margin: 0; color: #1e293b;">
        {{__('Customer Information')}}
    </div>
    <div class="b-table-wrap" style="padding: 10px 30px 30px 30px;">
        <table class="b-table" style="width: 100%; border-collapse: collapse; text-align: left;" cellspacing="0" cellpadding="0">
            <tr>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500; width: 40%;">{{__('Full Name')}}</td>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold;">{{$booking->first_name}} {{$booking->last_name}}</td>
            </tr>
            <tr>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Email')}}</td>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold;">{{$booking->email}}</td>
            </tr>
            <tr>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Phone')}}</td>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold;">{{$booking->phone}}</td>
            </tr>
            @if($booking->address)
            <tr>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Address line 1')}}</td>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold;">{{$booking->address}}</td>
            </tr>
            @endif
            @if($booking->address2)
            <tr>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Address line 2')}}</td>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold;">{{$booking->address2}}</td>
            </tr>
            @endif
            @if($booking->city)
            <tr>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('City')}}</td>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold;">{{$booking->city}}</td>
            </tr>
            @endif
            @if($booking->state)
            <tr>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('State/Province/Region')}}</td>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold;">{{$booking->state}}</td>
            </tr>
            @endif
            @if($booking->zip_code)
            <tr>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('ZIP code/Postal code')}}</td>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold;">{{$booking->zip_code}}</td>
            </tr>
            @endif
            @if($booking->country)
            <tr>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Country')}}</td>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold;">{{get_country_name($booking->country)}}</td>
            </tr>
            @endif
            @if($booking->customer_notes)
            <tr>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-weight: 500;">{{__('Special Requirements')}}</td>
                <td style="padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: bold;">{{$booking->customer_notes}}</td>
            </tr>
            @endif
        </table>
    </div>
</div>

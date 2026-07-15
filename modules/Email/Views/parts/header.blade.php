<div class="" style="">
    <div class="b-container">
        <div class="b-header">
            @php 
                $email_header = setting_item_with_lang('email_header');
                $logo_id = setting_item('logo_id');
            @endphp
            @if($email_header)
                {!! $email_header !!}
            @elseif($logo_id)
                @php $logo_url = get_file_url($logo_id, 'full'); @endphp
                <div style="text-align: center;">
                    <img src="{{ $logo_url }}" alt="{{ setting_item('site_title','Booking Core') }}" style="max-width: 200px; height: auto;" />
                </div>
            @else
                {!! sprintf('<h1 class="site-title">%s</h1>',setting_item('site_title','Booking Core')) !!}
            @endif
        </div>
    </div>
</div>

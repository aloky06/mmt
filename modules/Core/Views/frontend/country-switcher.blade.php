@php
    $current_country = get_user_country();
    $countries = get_country_lists();
    
    // Fetch unique countries from active locations
    $active_countries = \Modules\Location\Models\Location::where('status', 'publish')
        ->whereNotNull('country')
        ->where('country', '!=', '')
        ->distinct()
        ->pluck('country')
        ->toArray();
    
    // If no locations have countries assigned, show default
    if (empty($active_countries)) {
        $active_countries = ['IN'];
    }
    
    // Always include current country in the list of active ones if it isn't already
    if (!in_array($current_country, $active_countries)) {
        $active_countries[] = $current_country;
    }
@endphp
@if(!empty($active_countries) and count($active_countries) > 0)
    <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="is_login">
            <i class="fa fa-globe"></i> {{ strtoupper($countries[$current_country] ?? $current_country) }}
            <i class="fa fa-angle-down"></i>
        </a>
        <ul class="dropdown-menu text-left width-auto" style="max-height: 300px; overflow-y: auto;">
            @foreach($active_countries as $code)
                @if($current_country != $code)
                    <li>
                        <a href="{{ route('set_country', ['country' => $code]) }}" class="is_login">
                            {{ strtoupper($countries[$code] ?? $code) }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </li>
@endif

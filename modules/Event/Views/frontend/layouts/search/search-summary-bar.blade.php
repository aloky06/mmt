@php
    $location_name = "";
    if(Request::query('location_id')){
        $location = \Modules\Location\Models\Location::find(Request::query('location_id'));
        if($location) $location_name = $location->name;
    }
    if(empty($location_name) && Request::query('map_place')) {
        $location_name = Request::query('map_place');
    }

    $start = Request::query('start') ? \Carbon\Carbon::parse(Request::query('start'))->format('d M y') : '';
    $end = Request::query('end') ? \Carbon\Carbon::parse(Request::query('end'))->format('d M y') : '';
    $date_text = $start ? ($start . ' - ' . $end) : 'Any Dates';
    
    $adults = Request::query('adults', 1);
    $children = Request::query('children', 0);
    $rooms = Request::query('room', 1);
    $guest_text = $rooms . ' Room, ' . $adults . ' Adult' . ($adults > 1 ? 's' : '') . ($children ? ', ' . $children . ' Child' . ($children > 1 ? 'ren' : '') : '');
@endphp

<div class="sticky top-0 z-50 bg-brand text-white shadow-md" x-data="{ openSearch: false }">
    <div class="container mx-auto px-4 py-3 flex flex-wrap md:flex-nowrap items-center justify-between gap-4" style="max-width: 1200px;">
        <div class="flex flex-1 items-center gap-4 md:gap-8 overflow-hidden w-full md:w-auto">
            <div class="flex flex-col min-w-0">
                <span class="text-[10px] text-brand-light uppercase font-bold tracking-wider opacity-80">DESTINATION OR EVENT</span>
                <span class="font-bold text-base md:text-lg truncate">{{ $location_name ?: 'Anywhere' }}</span>
            </div>
            
            <div class="h-8 w-px bg-white/30 hidden md:block"></div>
            
            <div class="flex flex-col whitespace-nowrap">
                <span class="text-[10px] text-brand-light uppercase font-bold tracking-wider opacity-80">CHECK-IN - CHECK-OUT</span>
                <span class="font-bold text-base md:text-lg">{{ $date_text }}</span>
            </div>

            <div class="h-8 w-px bg-white/30 hidden md:block"></div>
            
            <div class="flex flex-col whitespace-nowrap">
                <span class="text-[10px] text-brand-light uppercase font-bold tracking-wider opacity-80">GUESTS</span>
                <span class="font-bold text-base md:text-lg">{{ $adults }} Adult{{ $adults > 1 ? 's' : '' }}{{ $children ? ', ' . $children . ' Child' . ($children > 1 ? 'ren' : '') : '' }}</span>
            </div>
        </div>
        
        <button @click="openSearch = !openSearch" class="bg-white/10 hover:bg-white/20 transition-colors border border-white/30 rounded-full px-5 py-2 text-sm font-bold uppercase tracking-wider flex-shrink-0 text-white backdrop-blur-sm">
            Modify Search
        </button>
    </div>

    <!-- Inline Dropdown Form -->
    <div x-show="openSearch" style="display: none;" x-collapse class="bg-gray-50 border-b border-gray-200">
        <div class="container mx-auto px-4 py-8" style="max-width: 1200px;">
            <div class="bravo_form_search" style="margin-top:0 !important; padding-bottom:0 !important; position: static !important; z-index: auto !important;">
                @include('Event::frontend.layouts.search.form-search')
            </div>
        </div>
    </div>
</div>

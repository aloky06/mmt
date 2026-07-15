@php
    $param = request()->input();
    $orderby = request()->input("orderby");
    $current_sort = __("Recommended");
    switch($orderby) {
        case "price_low_high": $current_sort = __("Price (Low to high)"); break;
        case "price_high_low": $current_sort = __("Price (High to low)"); break;
        case "rate_high_low": $current_sort = __("Rating (High to low)"); break;
    }
    
    // Sort URLs
    $param['orderby'] = "";
    $url_recommended = route("hotel.search", $param);
    $param['orderby'] = "price_low_high";
    $url_price_low = route("hotel.search", $param);
    $param['orderby'] = "price_high_low";
    $url_price_high = route("hotel.search", $param);
    $param['orderby'] = "rate_high_low";
    $url_rate = route("hotel.search", $param);
@endphp

<div class="flex flex-col md:flex-row items-start md:items-center justify-between bg-white rounded-xl shadow-[0_2px_12px_rgba(0,0,0,0.06)] border border-gray-100 p-4 mb-5">
    <div class="text-lg md:text-xl font-bold text-gray-800 mb-4 md:mb-0">
        <span class="text-brand">{{ $rows->total() }}</span> {{ $rows->total() == 1 ? 'property' : 'properties' }} found
    </div>
    
    <div class="flex items-center gap-4 w-full md:w-auto">
        <!-- Sort Dropdown -->
        <div class="relative w-full md:w-auto" x-data="{ openSort: false }">
            <button @click="openSort = !openSort" @click.outside="openSort = false" class="w-full md:w-64 flex items-center justify-between bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-800 px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors">
                <span><span class="font-medium text-gray-500 mr-1">Sort By:</span> {{ $current_sort }}</span>
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <div x-show="openSort" x-transition style="display: none;" class="absolute z-40 right-0 mt-2 w-full md:w-64 bg-white border border-gray-100 rounded-lg shadow-xl overflow-hidden">
                <a href="{{ $url_recommended }}" class="block px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-brand/5 hover:text-brand transition-colors {{ !$orderby ? 'bg-brand/5 text-brand' : '' }}">{{ __("Recommended") }}</a>
                <a href="{{ $url_price_low }}" class="block px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-brand/5 hover:text-brand transition-colors {{ $orderby == 'price_low_high' ? 'bg-brand/5 text-brand' : '' }}">{{ __("Price (Low to high)") }}</a>
                <a href="{{ $url_price_high }}" class="block px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-brand/5 hover:text-brand transition-colors {{ $orderby == 'price_high_low' ? 'bg-brand/5 text-brand' : '' }}">{{ __("Price (High to low)") }}</a>
                <a href="{{ $url_rate }}" class="block px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-brand/5 hover:text-brand transition-colors {{ $orderby == 'rate_high_low' ? 'bg-brand/5 text-brand' : '' }}">{{ __("Rating (High to low)") }}</a>
            </div>
        </div>
        
        <!-- View Toggle -->
        <a href="{{ route("hotel.search", ['_layout'=>'map']) }}" class="hidden md:flex items-center gap-2 bg-white hover:bg-gray-50 border border-gray-200 text-brand px-4 py-2.5 rounded-lg text-sm font-bold transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
            Map
        </a>
    </div>
</div>

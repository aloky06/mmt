@extends('Layout::app-mmt')

@section('content')
<div class="bg-mmt-gradient pb-32 pt-20 relative">
    <div class="container relative z-10">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-white mb-2">Book Your Next Journey</h1>
                    <div class="text-xl text-white/80">Discover great places to stay, eat, shop, or visit from local experts.</div>
                </div>

                @php
                    $service_types = array_keys(get_bookable_services());
                    $list_location = \Modules\Location\Models\Location::where("status","publish")->limit(1000)->orderBy('name', 'asc')->with(['translations'])->get()->toTree();
                    $tour_location = $list_location;
                    if(class_exists('\Modules\Flight\Models\SeatType')) {
                        $seatType = \Modules\Flight\Models\SeatType::get();
                    } else {
                        $seatType = [];
                    }
                @endphp

                <div class="relative mt-12 z-10 w-full max-w-6xl mx-auto bravo-form-search-all">
                    <!-- Search Form Container -->
                    <div class="g-form-control bg-white rounded-3xl shadow-travel-widget pb-12 relative">
                        
                        <!-- MakeMyTrip Style Tabs -->
                        <div class="px-8 pt-6 pb-4 border-b border-gray-100 flex justify-center">
                            <ul class="flex space-x-2 sm:space-x-4" role="tablist" style="border: none !important; margin: 0;">
                                @if(!empty($service_types))
                                    @php $number = 0; @endphp
                                    @foreach ($service_types as $service_type)
                                        @php
                                            $allServices = get_bookable_services();
                                            if(empty($allServices[$service_type])) continue;
                                            $module = new $allServices[$service_type];
                                        @endphp
                                        <li role="bravo_{{$service_type}}">
                                            <a href="#bravo_{{$service_type}}" class="travel-tab transition-all flex items-center space-x-2 px-4 sm:px-6 py-2 sm:py-3 rounded-full font-bold text-gray-500 hover:text-gray-800 hover:bg-gray-50 @if($number == 0) bg-blue-50 text-blue-600 active @endif" aria-controls="bravo_{{$service_type}}" role="tab" data-toggle="tab" style="border: none !important; margin: 0 !important;">
                                                <i class="{{ $module->getServiceIconFeatured() }} text-lg sm:text-xl"></i>
                                                <span class="text-sm sm:text-base">{{ $module->getModelName() }}</span>
                                            </a>
                                        </li>
                                        @php $number++; @endphp
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <!-- Form Content -->
                        <div class="tab-content p-8 pt-8">
                            @if(!empty($service_types))
                                @php $number = 0; @endphp
                                @foreach ($service_types as $service_type)
                                    @php
                                        $allServices = get_bookable_services();
                                        if(empty($allServices[$service_type])) continue;
                                        $module = new $allServices[$service_type];
                                    @endphp
                                    <div role="tabpanel" class="tab-pane @if($number == 0) active @endif" id="bravo_{{$service_type}}">
                                        @include(ucfirst($service_type).'::frontend.layouts.search.form-search')
                                    </div>
                                    @php $number++; @endphp
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Below Content: Offers and Wonder Destinations (MMT Style) -->
<div class="bg-gray-50 pt-16 pb-24">
    <div class="container max-w-6xl mx-auto">
        
        <!-- Offers Section -->
        <div class="bg-white rounded-2xl shadow-sm p-8 mb-12 border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-900 flex items-center">
                    <span class="text-red-500 mr-3 text-4xl leading-none">&bull;</span> Offers
                </h2>
                <div class="flex space-x-4">
                    <button class="px-6 py-2 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition">All Offers</button>
                    <button class="px-6 py-2 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition">Bank Offers</button>
                    <button class="px-6 py-2 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition">Flights</button>
                    <button class="px-6 py-2 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition">Hotels</button>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Offer Card 1 -->
                <div class="flex border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition bg-white">
                    <img src="https://images.unsplash.com/photo-1542314831-c6a4d27eceb0?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Offer" class="w-1/3 object-cover">
                    <div class="p-4 w-2/3">
                        <div class="text-xs font-bold text-gray-500 uppercase mb-1">DOMESTIC HOTELS</div>
                        <h3 class="text-base font-bold text-gray-900 mb-2 leading-tight">Up to 30% OFF* on Domestic Hotels</h3>
                        <div class="text-xs text-gray-500 mb-3">Limited time offer for summer holidays!</div>
                        <div class="text-blue-600 text-sm font-bold mt-auto uppercase">BOOK NOW</div>
                    </div>
                </div>
                <!-- Offer Card 2 -->
                <div class="flex border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition bg-white">
                    <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Offer" class="w-1/3 object-cover">
                    <div class="p-4 w-2/3">
                        <div class="text-xs font-bold text-gray-500 uppercase mb-1">INTERNATIONAL FLIGHTS</div>
                        <h3 class="text-base font-bold text-gray-900 mb-2 leading-tight">Get Flat 10% Cashback on International Flights</h3>
                        <div class="text-xs text-gray-500 mb-3">Valid with Visa Credit Cards</div>
                        <div class="text-blue-600 text-sm font-bold mt-auto uppercase">BOOK NOW</div>
                    </div>
                </div>
                <!-- Offer Card 3 -->
                <div class="flex border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition bg-white">
                    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Offer" class="w-1/3 object-cover">
                    <div class="p-4 w-2/3">
                        <div class="text-xs font-bold text-gray-500 uppercase mb-1">HOLIDAY PACKAGES</div>
                        <h3 class="text-base font-bold text-gray-900 mb-2 leading-tight">Buy 1 Get 1 Free on Select Tour Packages</h3>
                        <div class="text-xs text-gray-500 mb-3">Explore Europe with your loved ones.</div>
                        <div class="text-blue-600 text-sm font-bold mt-auto uppercase">BOOK NOW</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Explore Destinations -->
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Handpicked Collections for You</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Dest Card -->
                <div class="relative rounded-2xl overflow-hidden group cursor-pointer h-64">
                    <img src="https://images.unsplash.com/photo-1524492412937-b28074a5d7da?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-bold mb-1">Stays in & around Delhi</h3>
                        <div class="text-sm text-white/80">Explore luxury resorts</div>
                    </div>
                </div>
                <!-- Dest Card -->
                <div class="relative rounded-2xl overflow-hidden group cursor-pointer h-64">
                    <img src="https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-bold mb-1">Beach Escapes</h3>
                        <div class="text-sm text-white/80">Goa, Maldives, Bali</div>
                    </div>
                </div>
                <!-- Dest Card -->
                <div class="relative rounded-2xl overflow-hidden group cursor-pointer h-64">
                    <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-bold mb-1">Mountain Retreats</h3>
                        <div class="text-sm text-white/80">Manali, Shimla, Ooty</div>
                    </div>
                </div>
                <!-- Dest Card -->
                <div class="relative rounded-2xl overflow-hidden group cursor-pointer h-64">
                    <img src="https://images.unsplash.com/photo-1473186578172-c141e6798f2c?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-bold mb-1">International Wonders</h3>
                        <div class="text-sm text-white/80">Dubai, Singapore, London</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* Header Overrides for MMT Look */
.bravo_header { background: transparent !important; border: none !important; position: absolute !important; width: 100%; top: 0; z-index: 50; }
.bravo_header .bravo-menu a { color: white !important; font-weight: 500 !important; }
.bravo_header .bravo-logo { background-color: transparent !important; padding: 0 !important; }
.bravo_header .bravo-logo img { max-height: 50px; filter: brightness(0) invert(1); } /* Makes the dark logo white! */

/* MakeMyTrip Background Gradient */
.bg-mmt-gradient {
    background: linear-gradient(to bottom, #0a1128 0%, #162a5c 100%) !important;
}

/* Force Horizontal Flex Layout for MMT Widget */
.bravo-form-search-all .g-field-search .row { 
    display: flex !important; 
    flex-wrap: nowrap !important; 
    border-radius: 1rem !important;
    border: 1px solid #e5e7eb !important;
    overflow: visible !important;
    background: white !important;
}
.bravo-form-search-all .g-field-search [class*="col-md-"] {
    flex: 1 1 0% !important;
    max-width: none !important;
    border-right: 1px solid #e5e7eb !important;
    padding: 1rem 1.25rem !important;
    min-width: 0; 
    background: transparent !important;
}
.bravo-form-search-all .g-field-search .border-right:last-child { border-right: none !important; }

/* Strip Inner Formatting */
.bravo-form-search-all .form-group,
.bravo-form-search-all .form-content,
.bravo-form-search-all .item-title {
    border: none !important;
    background: transparent !important;
    margin: 0 !important;
    padding: 0 !important;
}

/* Large Typography for Inputs like MMT */
.bravo-form-search-all .form-control, 
.bravo-form-search-all .render {
    font-size: 1.125rem !important;
    font-weight: 700 !important;
    border: none !important;
    padding: 0 !important;
    height: auto !important;
    box-shadow: none !important;
    background: transparent !important;
}
.bravo-form-search-all label {
    font-size: 0.875rem !important;
    color: #6b7280 !important;
    margin-bottom: 0.25rem !important;
    text-transform: uppercase;
    font-weight: 600;
}
.bravo-form-search-all .field-icon { display: none !important; }

/* Goibibo Style Search Button */
.g-button-submit { position: absolute !important; bottom: -28px !important; left: 50% !important; transform: translateX(-50%) !important; width: auto !important; z-index: 50 !important; margin: 0 !important; }
.g-button-submit .btn-search { background: linear-gradient(90deg, #ff6d38 0%, #ff4155 100%) !important; color: white !important; border-radius: 9999px !important; padding: 1rem 3.5rem !important; font-size: 1.25rem !important; font-weight: bold !important; border: none !important; box-shadow: 0 10px 20px -5px rgba(255, 65, 85, 0.5) !important; display: inline-block !important; text-transform: uppercase; letter-spacing: 1px; white-space: nowrap !important; }
.g-button-submit .btn-search:hover { transform: translateY(-2px) !important; box-shadow: 0 15px 25px -5px rgba(255, 65, 85, 0.6) !important; }

/* Tabs Override */
.bravo-form-search-all .travel-tab.active { background-color: #eff6ff !important; color: #2563eb !important; }
.g-form-control .tab-pane { display: none; }
.g-form-control .tab-pane.active { display: block; }
</style>
@endsection

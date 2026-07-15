@php
    $translation = $row->translateOrOrigin(app()->getLocale());
    
    // Process Images for Carousel
    $images = [];
    if ($row->image_id) {
        $images[] = get_file_url($row->image_id, 'medium');
    }
    if (!empty($row->gallery)) {
        $gallery_ids = explode(',', $row->gallery);
        foreach ($gallery_ids as $id) {
            if ($id != $row->image_id) {
                $images[] = get_file_url($id, 'medium');
            }
        }
    }
    if(empty($images)) {
        $images[] = asset('images/default-hotel.jpg');
    }
    
    // Amenities
    $amenities = [];
    if(!empty($attribute = $row->getAttributeInListingPage())){
        $termsByAttribute = $row->termsByAttributeInListingPage;
        foreach($termsByAttribute as $term){
            $translate_term = $term->translateOrOrigin(app()->getLocale());
            $amenities[] = [
                'name' => $translate_term->name,
                'icon' => $term->icon ?? 'fa fa-check'
            ];
        }
    }
    
    // Review Data
    $reviewData = setting_item('hotel_enable_review') ? $row->getScoreReview() : null;
@endphp

<div class="bg-white rounded-xl shadow-sm hover:shadow-[0_8px_30px_rgba(230,82,31,0.15)] border border-gray-100 overflow-hidden transition-all duration-300 mb-5 flex flex-col md:flex-row group">
    
    <!-- Image Carousel (Left) -->
    <div class="relative w-full md:w-[35%] h-56 md:h-auto bg-gray-100 flex-shrink-0" x-data="{ activeSlide: 0, slides: {{ json_encode($images) }} }">
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}" class="block w-full h-full relative overflow-hidden">
            <template x-for="(slide, index) in slides" :key="index">
                <img x-show="activeSlide === index" :src="slide" alt="{{$translation->title}}" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300 group-hover:scale-105" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            </template>
        </a>
        
        <!-- Wishlist -->
        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur rounded-full p-2 text-gray-400 hover:text-red-500 cursor-pointer shadow-sm transition-colors z-10 service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
        </div>
        
        @if($row->is_featured == "1")
            <div class="absolute top-3 left-3 bg-gradient-to-r from-brand to-brand-dark text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-sm z-10">
                Featured
            </div>
        @endif

        <!-- Carousel Controls -->
        <div x-show="slides.length > 1" class="absolute inset-0 flex items-center justify-between px-2 opacity-0 group-hover:opacity-100 transition-opacity z-10 pointer-events-none">
            <button @click.prevent="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1" class="pointer-events-auto bg-black/40 hover:bg-black/60 text-white rounded-full p-1.5 backdrop-blur">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button @click.prevent="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1" class="pointer-events-auto bg-black/40 hover:bg-black/60 text-white rounded-full p-1.5 backdrop-blur">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
        
        <!-- Indicators -->
        <div x-show="slides.length > 1" class="absolute bottom-3 left-0 right-0 flex justify-center gap-1.5 z-10">
            <template x-for="(slide, index) in slides" :key="index">
                <div class="w-1.5 h-1.5 rounded-full transition-colors" :class="activeSlide === index ? 'bg-white' : 'bg-white/50'"></div>
            </template>
        </div>
    </div>
    
    <!-- Details (Middle & Right) -->
    <div class="flex-1 flex flex-col md:flex-row p-5 gap-6">
        
        <!-- Middle: Info -->
        <div class="flex-1 flex flex-col justify-between border-b md:border-b-0 md:border-r border-gray-100 pb-5 md:pb-0 md:pr-6">
            <div>
                <div class="flex items-start justify-between mb-1">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">
                        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}" class="hover:text-brand transition-colors">
                            {!! clean($translation->title) !!}
                        </a>
                    </h3>
                </div>
                
                <div class="flex items-center gap-2 mb-3">
                    @if($row->star_rate)
                        <div class="flex text-yellow-400 text-xs">
                            @for ($star = 1 ;$star <= $row->star_rate ; $star++)
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                    @endif
                    
                    @if(!empty($row->location->name))
                        @php $location = $row->location->translateOrOrigin(app()->getLocale()) @endphp
                        <a href="{{ route('hotel.search', ['location_id' => $row->location->id]) }}" class="text-sm text-blue-600 hover:underline flex items-center gap-1 font-medium">
                            {{$location->name ?? ''}}
                        </a>
                    @endif
                </div>

                @if(!empty($amenities))
                    <div class="flex flex-wrap gap-3 mt-4">
                        @foreach(array_slice($amenities, 0, 5) as $amenity)
                            <div class="text-gray-400 flex items-center gap-1.5 tooltip" title="{{ $amenity['name'] }}">
                                <i class="{{ $amenity['icon'] }} text-sm"></i>
                                <span class="text-xs text-gray-500 hidden xl:inline">{{ $amenity['name'] }}</span>
                            </div>
                        @endforeach
                        @if(count($amenities) > 5)
                            <span class="text-xs text-brand font-medium tooltip" title="More amenities available">
                                +{{ count($amenities) - 5 }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Tags row -->
            <div class="mt-4 flex flex-wrap gap-2">
                @if($row->is_instant)
                    <span class="bg-yellow-50 text-yellow-700 text-xs font-bold px-2.5 py-1 rounded-md flex items-center gap-1 border border-yellow-200">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd"></path></svg>
                        Instant Booking
                    </span>
                @endif
                <span class="bg-green-50 text-green-700 text-xs font-bold px-2.5 py-1 rounded-md border border-green-200">
                    Free Cancellation
                </span>
            </div>
        </div>
        
        <!-- Right: Price & CTA -->
        <div class="md:w-48 flex flex-col justify-between">
            
            <!-- User Rating Badge -->
            <div class="flex justify-end mb-4">
                @if($reviewData && !empty($reviewData['score_total']))
                    <div class="flex items-center gap-2 text-right">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-900">{{$reviewData['review_text']}}</span>
                            <span class="text-[11px] text-gray-500">{{__(":number reviews",['number'=>$reviewData['total_review']])}}</span>
                        </div>
                        <div class="bg-[#0b875b] text-white text-base font-bold w-10 h-10 flex items-center justify-center rounded-lg rounded-tr-sm">
                            {{$reviewData['score_total']}}
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Price Area -->
            <div class="text-right mt-auto">
                <div class="text-xs text-gray-500 font-medium mb-1 line-through opacity-70">
                    {{ format_money($row->tmp_price * 1.3) }} <!-- Faux discount for Goibibo feel -->
                </div>
                <div class="text-2xl font-black text-gray-900 leading-none">
                    {{ $row->display_price }}
                </div>
                <div class="text-[10px] text-gray-500 mt-1 uppercase font-semibold">
                    + Taxes & Fees
                </div>
                <div class="text-xs text-brand mt-1 font-medium">
                    per room / night
                </div>
                
                <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}" class="mt-4 block w-full bg-gradient-to-r from-brand to-brand-dark hover:from-brand-dark hover:to-[#a93210] text-white text-center font-bold py-3 rounded-lg uppercase tracking-wide text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    Book Now
                </a>
            </div>
            
        </div>
    </div>
</div>

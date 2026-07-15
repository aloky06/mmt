<div x-data="{ showMobileFilters: false }" class="relative">
    
    <!-- Mobile Filter Toggle Button -->
    <button @click="showMobileFilters = true" class="lg:hidden w-full flex items-center justify-center gap-2 bg-white border border-gray-200 text-gray-800 font-bold py-3 px-4 rounded-xl shadow-sm mb-4">
        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
        Filter Results
    </button>

    <!-- Overlay for Mobile -->
    <div x-show="showMobileFilters" style="display: none;" @click="showMobileFilters = false" class="fixed inset-0 bg-black/60 z-[60] lg:hidden" x-transition.opacity></div>

    <!-- Sidebar / Bottom Sheet -->
    <div :class="showMobileFilters ? 'translate-y-0' : 'translate-y-full lg:translate-y-0'" class="fixed lg:sticky lg:top-[120px] bottom-0 left-0 w-full lg:w-auto h-[85vh] lg:h-auto bg-white lg:bg-transparent z-[70] lg:z-auto transition-transform duration-300 rounded-t-3xl lg:rounded-none overflow-hidden flex flex-col shadow-2xl lg:shadow-none">
        
        <!-- Mobile Header -->
        <div class="lg:hidden flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-white">
            <h3 class="text-lg font-bold text-gray-900">Filters</h3>
            <button @click="showMobileFilters = false" class="text-gray-400 hover:text-gray-700 bg-gray-100 rounded-full p-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Filter Content -->
        <div class="flex-1 overflow-y-auto lg:overflow-visible p-6 lg:p-0 bg-white lg:bg-transparent lg:border lg:border-gray-200 lg:rounded-xl lg:shadow-sm">
            <form action="{{ route("hotel.search") }}" class="bravo_form_filter lg:bg-white lg:p-5 lg:rounded-xl">
                
                <div class="flex items-center justify-between mb-5 pb-4 border-b border-gray-100">
                    <span class="font-bold text-gray-900 text-lg hidden lg:block">{{__("Filters")}}</span>
                    <a href="{{ route("hotel.search") }}" class="text-sm font-semibold text-brand hover:text-brand-dark hidden lg:block">{{__("Clear All")}}</a>
                </div>

                @if( !empty(Request::query('location_id')) )
                    <input type="hidden" name="location_id" value="{{Request::query('location_id')}}">
                @endif
                @if( !empty(Request::query('start')) and !empty(Request::query('end')) )
                    <input type="hidden" value="{{Request::query('start',date("d/m/Y",strtotime("today")))}}" name="start">
                    <input type="hidden" value="{{Request::query('end',date("d/m/Y",strtotime("+1 day")))}}" name="end">
                    <input type="hidden" name="date" value="{{Request::query('date')}}">
                @endif

                <!-- Filter: Price -->
                <div class="mb-6 pb-6 border-b border-gray-100" x-data="{ open: true }">
                    <div @click="open = !open" class="flex items-center justify-between cursor-pointer group">
                        <h4 class="font-bold text-gray-800 group-hover:text-brand transition-colors">{{__("Price Range")}}</h4>
                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div x-show="open" x-collapse class="pt-4">
                        <div class="bravo-filter-price">
                            <?php
                            $price_min = $pri_from = floor ( App\Currency::convertPrice($hotel_min_max_price[0]) );
                            $price_max = $pri_to = ceil ( App\Currency::convertPrice($hotel_min_max_price[1]) );
                            $price_range = Request::query('price_range');
                            if (!empty($price_range)) {
                                $pri_from = explode(";", $price_range)[0];
                                $pri_to = explode(";", $price_range)[1];
                            }
                            $currency = App\Currency::getCurrency( App\Currency::getCurrent() );
                            ?>
                            <input type="hidden" class="filter-price irs-hidden-input" name="price_range"
                                   data-symbol=" {{$currency['symbol'] ?? ''}}"
                                   data-min="{{$price_min}}"
                                   data-max="{{$price_max}}"
                                   data-from="{{$pri_from}}"
                                   data-to="{{$pri_to}}"
                                   readonly="" value="{{$price_range}}">
                            <div class="text-right mt-3">
                                <button type="submit" class="text-xs font-bold bg-brand text-white px-3 py-1.5 rounded hover:bg-brand-dark transition-colors">{{__("APPLY")}}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter: Star Rating -->
                <div class="mb-6 pb-6 border-b border-gray-100" x-data="{ open: true }">
                    <div @click="open = !open" class="flex items-center justify-between cursor-pointer group">
                        <h4 class="font-bold text-gray-800 group-hover:text-brand transition-colors">{{__("Star Category")}}</h4>
                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div x-show="open" x-collapse class="pt-3">
                        <ul class="space-y-2">
                            @for ($number = 5 ;$number >= 1 ; $number--)
                                <li>
                                    <label class="flex items-center gap-3 cursor-pointer group/label">
                                        <input name="star_rate[]" type="checkbox" value="{{$number}}" @if(in_array($number, request()->query('star_rate',[]))) checked @endif class="w-4 h-4 text-brand bg-gray-100 border-gray-300 rounded focus:ring-brand accent-brand cursor-pointer">
                                        <div class="flex gap-0.5 text-yellow-400">
                                            @for ($star = 1 ;$star <= $number ; $star++)
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-600 group-hover/label:text-gray-900 transition-colors ml-auto">{{ $number }} Star</span>
                                    </label>
                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>

                <!-- Filter: User Rating -->
                <div class="mb-6 pb-6 border-b border-gray-100" x-data="{ open: true }">
                    <div @click="open = !open" class="flex items-center justify-between cursor-pointer group">
                        <h4 class="font-bold text-gray-800 group-hover:text-brand transition-colors">{{__("User Rating")}}</h4>
                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div x-show="open" x-collapse class="pt-3">
                        <ul class="space-y-2">
                            @for ($number = 5 ;$number >= 1 ; $number--)
                                <li>
                                    <label class="flex items-center gap-3 cursor-pointer group/label">
                                        <input name="review_score[]" type="checkbox" value="{{$number}}" @if(in_array($number, request()->query('review_score',[]))) checked @endif class="w-4 h-4 text-brand bg-gray-100 border-gray-300 rounded focus:ring-brand accent-brand cursor-pointer">
                                        <div class="flex items-center gap-2">
                                            <span class="bg-[#0b875b] text-white text-xs font-bold px-1.5 py-0.5 rounded">{{ $number }}+</span>
                                            <span class="text-sm text-gray-600 group-hover/label:text-gray-900">
                                                @if($number == 5) Excellent @elseif($number == 4) Very Good @elseif($number == 3) Good @else Pleasant @endif
                                            </span>
                                        </div>
                                    </label>
                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>

                <!-- Dynamic Attributes (Property Type, Facilities, etc) -->
                @php $selected = (array) Request::query('terms'); @endphp
                @foreach ($attributes as $item)
                    @if(empty($item['hide_in_filter_search']))
                        @php $translate = $item->translateOrOrigin(app()->getLocale()); @endphp
                        <div class="mb-6 pb-6 border-b border-gray-100 last:border-0 last:pb-0 last:mb-0" x-data="{ open: true, showAll: false }">
                            <div @click="open = !open" class="flex items-center justify-between cursor-pointer group">
                                <h4 class="font-bold text-gray-800 group-hover:text-brand transition-colors">{{$translate->name}}</h4>
                                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                            <div x-show="open" x-collapse class="pt-3">
                                <ul class="space-y-2">
                                    @foreach($item->terms as $key => $term)
                                        @php $translate_term = $term->translateOrOrigin(app()->getLocale()); @endphp
                                        <li x-show="showAll || {{ $key < 5 ? 'true' : 'false' }}">
                                            <label class="flex items-start gap-3 cursor-pointer group/label">
                                                <input @if(in_array($term->id,$selected)) checked @endif type="checkbox" name="terms[]" value="{{$term->id}}" class="mt-0.5 w-4 h-4 text-brand bg-gray-100 border-gray-300 rounded focus:ring-brand accent-brand cursor-pointer">
                                                <span class="text-sm text-gray-600 group-hover/label:text-gray-900 leading-snug">{!! $translate_term->name !!}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                                @if(count($item->terms) > 5)
                                    <button type="button" @click="showAll = !showAll" class="mt-3 text-sm font-semibold text-brand hover:text-brand-dark flex items-center gap-1">
                                        <span x-text="showAll ? 'Show Less' : '+ Show {{ count($item->terms) - 5 }} More'"></span>
                                    </button>
                                @endif
                            </div>
                        </div>
                     @endif
                @endforeach

            </form>
        </div>

        <!-- Mobile Footer (Apply Button) -->
        <div class="lg:hidden p-4 border-t border-gray-100 bg-white">
            <button type="button" onclick="document.querySelector('.bravo_form_filter').submit()" class="w-full bg-brand text-white font-bold py-3.5 rounded-xl text-center hover:bg-brand-dark transition-colors shadow-lg">
                Apply Filters
            </button>
        </div>

    </div>
</div>

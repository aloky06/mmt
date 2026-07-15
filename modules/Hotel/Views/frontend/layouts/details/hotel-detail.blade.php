<!-- HEADER CARD -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 relative">
    <div class="flex flex-col md:flex-row justify-between gap-6">
        
        <!-- Left: Title, Stars, Address -->
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-2">
                @if($row->star_rate)
                    <div class="flex text-yellow-400 text-sm">
                        @for ($star = 1 ;$star <= $row->star_rate ; $star++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                @endif
            </div>
            
            <h1 class="text-3xl font-black text-gray-900 leading-tight mb-3">
                {!! clean($translation->title) !!}
            </h1>
            
            @if($translation->address)
                <p class="text-gray-600 flex items-start gap-2 text-sm md:text-base font-medium">
                    <svg class="w-5 h-5 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{$translation->address}}
                </p>
            @endif
        </div>
        
        <!-- Right: Ratings and Actions -->
        <div class="flex flex-col items-start md:items-end gap-4 shrink-0">
            <!-- Base Price -->
            <div class="text-left md:text-right w-full">
                <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">{{__("Starting from")}}</div>
                <div class="flex items-end gap-2 md:justify-end">
                    @if($row->display_sale_price)
                        <div class="text-sm text-gray-400 line-through mb-1">{{ $row->display_sale_price }}</div>
                    @endif
                    <div class="text-3xl font-black text-brand leading-none">{{ $row->display_price }}</div>
                </div>
                <div class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mt-1">
                    {{__("Per Room / Night")}}
                </div>
            </div>

            @if($row->getReviewEnable() && $review_score)
                <div class="flex items-center gap-3 mt-2">
                    <div class="text-right">
                        <div class="text-base font-bold text-gray-900">{{$review_score['score_text']}}</div>
                        <div class="text-xs text-gray-500">{{__(":number reviews",['number'=>$review_score['total_review']])}}</div>
                    </div>
                    <div class="bg-[#0b875b] text-white text-xl font-bold w-12 h-12 flex items-center justify-center rounded-lg rounded-tr-sm shadow-md">
                        {{$review_score['score_total']}}
                    </div>
                </div>
            @endif
            
            <!-- Actions -->
            <div class="flex items-center gap-3 w-full md:w-auto">
                <!-- Wishlist -->
                <div class="flex-1 md:flex-none border border-gray-200 rounded-lg px-4 py-2 flex items-center justify-center gap-2 cursor-pointer hover:bg-gray-50 transition-colors service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
                    <i class="fa fa-heart-o text-gray-500"></i>
                    <span class="text-sm font-semibold text-gray-700">Save</span>
                </div>
                
                <!-- Share -->
                <div class="relative flex-1 md:flex-none border border-gray-200 rounded-lg px-4 py-2 flex items-center justify-center gap-2 cursor-pointer hover:bg-gray-50 transition-colors group">
                    <i class="icofont-share text-gray-500"></i>
                    <span class="text-sm font-semibold text-gray-700">Share</span>
                    
                    <div class="absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 p-2 hidden group-hover:block z-20">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded-md text-gray-700">
                            <i class="fa fa-facebook text-blue-600"></i> Facebook
                        </a>
                        <a href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded-md text-gray-700">
                            <i class="fa fa-twitter text-blue-400"></i> Twitter
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- ROOMS -->
@include('Hotel::frontend.layouts.details.hotel-rooms')

<!-- OVERVIEW CARD -->
@if($translation->content)
    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border-0 p-6 md:p-8 mb-8">
        <h3 class="text-2xl font-black text-gray-900 mb-6 border-b border-gray-100 pb-4 tracking-tight">{{__("About this Property")}}</h3>
        <div class="prose prose-sm md:prose-base max-w-none text-gray-600">
            <?php echo $translation->content ?>
        </div>
    </div>
@endif

<!-- ATTRIBUTES -->
@include('Hotel::frontend.layouts.details.hotel-attributes')

<!-- RULES CARD -->
<div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border-0 p-6 md:p-8 mb-8">
    <h3 class="text-2xl font-black text-gray-900 mb-6 border-b border-gray-100 pb-4 tracking-tight">{{__("Hotel Policies")}}</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 bg-gray-50 p-4 rounded-lg">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-brand">
                <i class="icofont-login"></i>
            </div>
            <div>
                <div class="text-xs text-gray-500 font-semibold uppercase tracking-wide">{{__("Check In")}}</div>
                <div class="text-lg font-bold text-gray-900">{{$row->check_in_time}}</div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-brand">
                <i class="icofont-logout"></i>
            </div>
            <div>
                <div class="text-xs text-gray-500 font-semibold uppercase tracking-wide">{{__("Check Out")}}</div>
                <div class="text-lg font-bold text-gray-900">{{$row->check_out_time}}</div>
            </div>
        </div>
    </div>
    
    @if($translation->policy)
        <div class="space-y-4" x-data="{ showAll: false }">
            @foreach($translation->policy as $key => $item)
                @if(is_array($item) && isset($item['title']))
                <div class="flex flex-col md:flex-row gap-2 md:gap-6 border-b border-gray-100 pb-4 last:border-0 last:pb-0" x-show="showAll || {{ $key < 2 ? 'true' : 'false' }}">
                    <div class="md:w-1/3 font-bold text-gray-900">{{$item['title']}}</div>
                    <div class="md:w-2/3 text-gray-600 prose-sm">{!! $item['content'] !!}</div>
                </div>
                @endif
            @endforeach
            
            @if(count($translation->policy) > 2)
                <button @click="showAll = !showAll" class="text-brand font-bold text-sm hover:underline mt-2">
                    <span x-text="showAll ? 'Show Less' : 'Show All Policies'"></span>
                </button>
            @endif
        </div>
    @endif
</div>

@includeIf("Hotel::frontend.layouts.details.hotel-surrounding")

<!-- MAP CARD -->
@if($row->map_lat && $row->map_lng)
    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border-0 p-6 md:p-8 mb-8">
        <h3 class="text-2xl font-black text-gray-900 mb-6 border-b border-gray-100 pb-4 tracking-tight">{{__("Location")}}</h3>
        @if($translation->address)
            <p class="text-gray-600 flex items-start gap-1 text-sm mb-4">
                <i class="icofont-location-arrow text-brand mt-0.5"></i>
                {{$translation->address}}
            </p>
        @endif
        <div class="w-full h-80 rounded-xl overflow-hidden shadow-inner relative z-0">
            <div id="map_content" class="w-full h-full"></div>
        </div>
    </div>
@endif

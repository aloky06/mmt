<div id="hotel-rooms" class="hotel_rooms_form bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border-0 p-6 md:p-8 mb-8" v-cloak="" :class="{'hidden':enquiry_type!='book'}">
    
    <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
        <h3 class="text-2xl font-black text-gray-900 tracking-tight">{{__('Select Rooms')}}</h3>
        <div class="nav-enquiry text-sm font-semibold flex gap-4" v-if="is_form_enquiry_and_book">
            <div class="enquiry-item active text-brand cursor-pointer border-b-2 border-brand pb-1">
                <span>{{ __("Book") }}</span>
            </div>
            <div class="enquiry-item text-gray-500 hover:text-gray-900 cursor-pointer pb-1" data-toggle="modal" data-target="#enquiry_form_modal">
                <span>{{ __("Enquiry") }}</span>
            </div>
        </div>
    </div>
    
    <div class="form-book">
        
        <!-- Search Form -->
        <div class="form-search-rooms bg-gray-50 rounded-xl p-4 md:p-4 border border-gray-200 mb-8">
            <div class="flex flex-col md:flex-row items-stretch gap-4">
                
                <!-- Date Picker -->
                <div class="w-full md:w-5/12 h-16 bg-white rounded-lg px-4 shadow-sm border border-gray-100 relative cursor-pointer group flex items-center" @click="openStartDate" data-format="{{get_moment_date_format()}}">
                    <input type="text" class="start_date absolute opacity-0 w-0 h-0" ref="start_date">
                    <div class="flex items-center justify-between w-full gap-3">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-brand shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <div class="flex-1">
                                <label class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block mb-0.5 cursor-pointer leading-none">{{__("Check In - Out")}}</label>
                                <div class="font-bold text-gray-900 text-sm check-in-render leading-tight" v-html="start_date_html"></div>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-brand transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                
                <!-- Guests -->
                <div class="w-full md:w-4/12 h-16 bg-white rounded-lg px-4 shadow-sm border border-gray-100 relative group form-group flex items-center">
                    <div class="flex items-center justify-between w-full gap-3 cursor-pointer dropdown-toggle" data-toggle="dropdown">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-brand shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <div class="flex-1">
                                <label class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block mb-0.5 cursor-pointer leading-none">{{__('Guests')}}</label>
                                <div class="font-bold text-gray-900 text-sm leading-tight">
                                    <span class="adults" >@{{adults}} <span v-if="adults < 2">{{__('Adult')}}</span><span v-else>{{__('Adults')}}</span></span> - 
                                    <span class="children" >@{{children}} <span v-if="children < 2">{{__('Child')}}</span><span v-else>{{__('Children')}}</span></span>
                                </div>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-brand transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    
                    <div class="dropdown-menu w-full p-4 mt-2 shadow-xl border-0 rounded-xl" >
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                            <div class="font-semibold text-gray-800">{{__('Adults')}}</div>
                            <div class="flex items-center gap-3 bg-gray-50 p-1 rounded-lg border border-gray-200">
                                <span class="w-8 h-8 flex items-center justify-center bg-white rounded-md cursor-pointer hover:text-brand shadow-sm font-bold text-xl" @click="minusPersonType('adults')">-</span>
                                <span class="font-bold text-gray-900 w-4 text-center">@{{adults}}</span>
                                <span class="w-8 h-8 flex items-center justify-center bg-white rounded-md cursor-pointer hover:text-brand shadow-sm font-bold text-xl" @click="addPersonType('adults')">+</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="font-semibold text-gray-800">{{__('Children')}}</div>
                            <div class="flex items-center gap-3 bg-gray-50 p-1 rounded-lg border border-gray-200">
                                <span class="w-8 h-8 flex items-center justify-center bg-white rounded-md cursor-pointer hover:text-brand shadow-sm font-bold text-xl" @click="minusPersonType('children')">-</span>
                                <span class="font-bold text-gray-900 w-4 text-center">@{{children}}</span>
                                <span class="w-8 h-8 flex items-center justify-center bg-white rounded-md cursor-pointer hover:text-brand shadow-sm font-bold text-xl" @click="addPersonType('children')">+</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit -->
                <div class="w-full md:w-3/12 h-16">
                    <button class="w-full h-full bg-gradient-to-r from-brand to-[#ff8c42] shadow-lg shadow-brand/30 hover:shadow-brand/50 hover:-translate-y-0.5 text-white font-black rounded-xl transition-all uppercase tracking-wide text-sm flex justify-center items-center gap-2" @click="checkAvailability" :class="{'opacity-75 cursor-not-allowed':onLoadAvailability}">
                        {{__("Update")}}
                        <i v-show="onLoadAvailability" class="fa fa-spinner fa-spin"></i>
                    </button>
                </div>
                
            </div>
        </div>
        
        <div class="start_room_sticky"></div>
        
        <!-- Room List -->
        <div class="hotel_list_rooms relative min-h-[150px]" :class="{'opacity-50 pointer-events-none':onLoadAvailability}">
            
            <div class="absolute inset-0 z-10 flex items-center justify-center" v-show="onLoadAvailability">
                 <div class="w-10 h-10 border-4 border-gray-200 border-t-brand rounded-full animate-spin"></div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="room-item bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col md:flex-row group items-stretch" v-for="room in rooms">
                    
                    <!-- Room Image -->
                    <div class="md:w-1/3 relative cursor-pointer overflow-hidden" @click="showGallery($event,room.id,room.gallery)">
                        <img :src="room.image || 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=800&auto=format&fit=crop'" alt="Room Image" class="w-full h-48 md:h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute bottom-3 left-3 bg-black/70 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1" v-if="typeof room.gallery !='undefined' && room.gallery && room.gallery.length > 1">
                            <i class="fa fa-picture-o"></i>
                            @{{room.gallery.length}} {{__("Photos")}}
                        </div>
                        <div class="absolute inset-0 bg-black/0 hover:bg-black/10 transition-colors pointer-events-none"></div>
                        
                        <!-- Modal Gallery -->
                        <div class="modal fade" :id="'modal_room_'+room.id" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content border-0 rounded-xl overflow-hidden shadow-2xl">
                                    <div class="modal-header border-b border-gray-100 bg-white">
                                        <h5 class="modal-title font-bold text-gray-900 text-xl">@{{ room.title }}</h5>
                                        <button type="button" class="close text-gray-400 hover:text-gray-900" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div class="fotorama" data-nav="thumbs" data-width="100%" data-auto="false" data-allowfullscreen="true">
                                            <a v-for="g in room.gallery" :href="g.large"></a>
                                        </div>
                                        <div class="p-6 bg-gray-50">
                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                                <div v-for="term in room.terms">
                                                    <h4 class="font-bold text-gray-900 mb-2 border-b border-gray-200 pb-1">@{{ term.parent.title }}</h4>
                                                    <ul v-if="term.child" class="space-y-1">
                                                        <li v-for="term_child in term.child.slice(0,5)" class="text-sm text-gray-600 flex items-center gap-2">
                                                            <i class="text-brand w-4 text-center" v-bind:class="term_child.icon" data-toggle="tooltip" data-placement="top" :title="term_child.title"></i>
                                                            @{{ term_child.title }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Room Info -->
                    <div class="md:w-2/3 flex flex-col md:flex-row p-5 gap-6 items-center">
                        
                        <!-- Details -->
                        <div class="flex-1 flex flex-col justify-center pl-2">
                            <h3 class="text-2xl font-black text-gray-900 mb-4 hover:text-brand cursor-pointer transition-colors tracking-tight" @click="showGallery($event,room.id,room.gallery)">@{{room.title}}</h3>
                            
                            <div class="flex flex-wrap gap-3 mb-6">
                                <div v-if="room.size_html" class="flex items-center gap-2 text-sm font-semibold text-brand bg-brand/5 px-3 py-1.5 rounded-lg border border-brand/10" data-toggle="tooltip" data-placement="top" title="{{__('Room Footage')}}">
                                    <i class="icofont-ruler-compass-alt text-brand"></i>
                                    <span v-html="room.size_html"></span>
                                </div>
                                <div v-if="room.beds_html" class="flex items-center gap-2 text-sm font-semibold text-brand bg-brand/5 px-3 py-1.5 rounded-lg border border-brand/10" data-toggle="tooltip" data-placement="top" title="{{__('No. Beds')}}">
                                    <i class="icofont-hotel text-brand"></i>
                                    <span v-html="room.beds_html"></span>
                                </div>
                                <div v-if="room.adults_html" class="flex items-center gap-2 text-sm font-semibold text-brand bg-brand/5 px-3 py-1.5 rounded-lg border border-brand/10" data-toggle="tooltip" data-placement="top" title="{{__('No. Adults')}}">
                                    <i class="icofont-users-alt-4 text-brand"></i>
                                    <span v-html="room.adults_html"></span>
                                </div>
                                <div v-if="room.children_html" class="flex items-center gap-2 text-sm font-semibold text-brand bg-brand/5 px-3 py-1.5 rounded-lg border border-brand/10" data-toggle="tooltip" data-placement="top" title="{{__('No. Children')}}">
                                    <i class="fa-child fa text-brand"></i>
                                    <span v-html="room.children_html"></span>
                                </div>
                            </div>
                            
                            <div v-if="room.term_features" class="mt-auto">
                                <div class="text-[10px] uppercase font-black text-gray-400 tracking-[0.1em] mb-3">{{__("Amenities")}}</div>
                                <div class="flex flex-wrap gap-2">
                                    <span v-for="term_child in room.term_features" class="text-brand hover:bg-brand hover:text-white transition-colors bg-brand/5 w-10 h-10 rounded-full flex items-center justify-center shadow-sm" data-toggle="tooltip" data-placement="top" :title="term_child.title">
                                        <i v-bind:class="term_child.icon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Price & Selection -->
                        <div class="md:w-56 flex flex-col justify-center gap-6 border-t md:border-t-0 md:border-l border-gray-100 pt-5 md:pt-0 md:pl-8" v-if="room.number">
                            <div class="text-right">
                                <div class="text-[10px] text-gray-400 uppercase font-black tracking-[0.1em] mb-1">
                                    {{__("Per Room / Night")}}
                                </div>
                                <div class="text-3xl font-black text-gray-900 leading-none mb-1 tracking-tight">
                                    <span v-html="room.price_html"></span>
                                </div>
                                <div class="text-[10px] text-gray-400 mt-0.5">
                                    {{__("Excludes taxes & fees")}}
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <label class="block text-[10px] font-black text-gray-400 tracking-[0.1em] mb-2 uppercase">{{__("Select Rooms")}}</label>
                                <div class="relative">
                                    <select v-if="room.number" v-model="room.number_selected" class="w-full bg-white border-2 border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-brand focus:border-brand block p-3 pr-8 shadow-sm outline-none cursor-pointer font-bold transition-all hover:border-brand appearance-none">
                                        <option value="0">0</option>
                                        <option v-for="i in (1,room.number)" :value="i">@{{i}} @{{(i > 1 ? i18n.rooms  : i18n.room)}} - @{{formatMoney(i*room.price)}}</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Total Price & Extras Bar -->
        <div class="mt-6 bg-gradient-to-br from-gray-900 to-[#1a1a2e] text-white rounded-xl shadow-lg overflow-hidden" v-if="total_price" x-transition>
            
            <!-- Extras Area -->
            <div class="p-6 border-b border-gray-800" v-if="extra_price.length">
                <label class="block text-brand font-bold uppercase tracking-wider text-sm mb-4">{{__('Add-on Services')}}</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-800/50 rounded-lg p-3 border border-gray-700 hover:border-brand/50 transition-colors" v-for="(type,index) in extra_price">
                        <label class="flex items-center justify-between cursor-pointer w-full mb-0">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" true-value="1" false-value="0" v-model="type.enable" class="w-5 h-5 text-brand bg-gray-900 border-gray-600 rounded focus:ring-brand focus:ring-2 accent-brand cursor-pointer"> 
                                <div>
                                    <div class="font-bold text-sm">@{{type.name}}</div>
                                    <div class="text-xs text-gray-400" v-if="type.price_type">(@{{type.price_type}})</div>
                                </div>
                            </div>
                            <div class="font-bold text-brand-light">@{{type.price_html}}</div>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Totals Area -->
            <div class="p-6 flex flex-col md:flex-row justify-between items-center gap-6">
                
                <!-- Breakdown -->
                <div class="w-full md:w-1/2 space-y-2">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-400">{{__("Total Rooms Selected")}}:</span>
                        <span class="font-bold text-lg">@{{total_rooms}}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm" v-for="(type,index) in buyer_fees">
                        <span class="text-gray-400 flex items-center gap-1">
                            @{{type.type_name}}
                            <span v-if="type.price_type">(@{{type.price_type}})</span>
                            <i class="icofont-info-circle text-gray-500 cursor-help" v-if="type.desc" data-toggle="tooltip" data-placement="top" :title="type.type_desc"></i>
                        </span>
                        <span class="font-bold">
                            <span v-if='type.unit == "percent"'>@{{ type.price }}%</span>
                            <span v-else>@{{ formatMoney(type.price) }}</span>
                        </span>
                    </div>
                </div>
                
                <!-- Final Price & CTA -->
                <div class="w-full md:w-1/2 flex flex-col md:flex-row items-center justify-end gap-6 border-t md:border-t-0 md:border-l border-gray-800 pt-4 md:pt-0 md:pl-6">
                    <div class="text-right">
                        <div class="text-gray-400 text-sm uppercase tracking-widest font-semibold mb-1">{{__("Total Price")}}</div>
                        <div class="text-4xl font-black text-white leading-none">@{{total_price_html}}</div>
                        
                        <div v-if="is_deposit_ready" class="mt-2 text-sm">
                            <span class="text-gray-400">{{__("Pay now:")}}</span>
                            <span class="font-bold text-green-400">@{{pay_now_price_html}}</span>
                        </div>
                    </div>
                    
                    <button type="button" class="w-full md:w-auto px-10 bg-gradient-to-r from-brand to-[#ff8c42] shadow-[0_8px_20px_rgba(238,107,26,0.3)] hover:shadow-[0_12px_25px_rgba(238,107,26,0.4)] hover:-translate-y-0.5 text-white font-black py-4 rounded-xl transition-all uppercase tracking-wide text-lg flex items-center justify-center gap-2" @click="doSubmit($event)" :class="{'opacity-75 cursor-not-allowed':onSubmit}">
                        <span>{{__("Book Now")}}</span>
                        <i v-show="onSubmit" class="fa fa-spinner fa-spin"></i>
                        <svg v-show="!onSubmit" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
                
            </div>
        </div>
        
        <div class="end_room_sticky"></div>
        
        <div class="mt-6 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg p-4 flex items-center gap-3 font-semibold shadow-sm" v-if="!firstLoad && !rooms.length">
            <svg class="w-6 h-6 text-yellow-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{__("No rooms available for your selected dates. Please adjust your search criteria.")}}
        </div>
        
    </div>
</div>

@include("Booking::frontend.global.enquiry-form",['service_type'=>'hotel'])

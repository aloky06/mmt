<div class="form-checkout" id="form-checkout" >
    <input type="hidden" name="code" value="{{$booking->code}}">
    <div class="form-section">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="form-group">
                <label class="block text-sm font-bold text-gray-700 mb-1">{{__("First Name")}} <span class="text-red-500">*</span></label>
                <input type="text" placeholder="{{__("First Name")}}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block p-3 outline-none transition-colors" value="{{$user->first_name ?? ''}}" name="first_name">
            </div>
            
            <div class="form-group">
                <label class="block text-sm font-bold text-gray-700 mb-1">{{__("Last Name")}} <span class="text-red-500">*</span></label>
                <input type="text" placeholder="{{__("Last Name")}}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block p-3 outline-none transition-colors" value="{{$user->last_name ?? ''}}" name="last_name">
            </div>
            
            <div class="form-group field-email">
                <label class="block text-sm font-bold text-gray-700 mb-1">{{__("Email")}} <span class="text-red-500">*</span></label>
                <input type="email" placeholder="{{__("email@domain.com")}}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block p-3 outline-none transition-colors" value="{{$user->email ?? ''}}" name="email">
            </div>
            
            <div class="form-group">
                <label class="block text-sm font-bold text-gray-700 mb-1">{{__("Phone")}} <span class="text-red-500">*</span></label>
                <input type="text" placeholder="{{__("Your Phone")}}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block p-3 outline-none transition-colors" value="{{$user->phone ?? ''}}" name="phone">
            </div>
            
            <div class="form-group field-address-line-1 md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-1">{{__("Address line 1")}} </label>
                <input type="text" placeholder="{{__("Address line 1")}}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block p-3 outline-none transition-colors" value="{{$user->address ?? ''}}" name="address_line_1">
            </div>
            
            <div class="form-group field-address-line-2 md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-1">{{__("Address line 2")}} </label>
                <input type="text" placeholder="{{__("Address line 2")}}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block p-3 outline-none transition-colors" value="{{$user->address2 ?? ''}}" name="address_line_2">
            </div>
            
            <div class="form-group field-city">
                <label class="block text-sm font-bold text-gray-700 mb-1">{{__("City")}} </label>
                <input type="text" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block p-3 outline-none transition-colors" value="{{$user->city ?? ''}}" name="city" placeholder="{{__("Your City")}}">
            </div>
            
            <div class="form-group field-state">
                <label class="block text-sm font-bold text-gray-700 mb-1">{{__("State/Province/Region")}} </label>
                <input type="text" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block p-3 outline-none transition-colors" value="{{$user->state ?? ''}}" name="state" placeholder="{{__("State/Province/Region")}}">
            </div>
            
            <div class="form-group field-zip-code">
                <label class="block text-sm font-bold text-gray-700 mb-1">{{__("ZIP code/Postal code")}} </label>
                <input type="text" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block p-3 outline-none transition-colors" value="{{$user->zip_code ?? ''}}" name="zip_code" placeholder="{{__("ZIP code/Postal code")}}">
            </div>
            
            <div class="form-group field-country">
                <label class="block text-sm font-bold text-gray-700 mb-1">{{__("Country")}} <span class="text-red-500">*</span> </label>
                <select name="country" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block p-3 outline-none transition-colors cursor-pointer">
                    <option value="">{{__('-- Select --')}}</option>
                    @foreach(get_country_lists() as $id=>$name)
                        <option @if(($user->country ?? '') == $id) selected @endif value="{{$id}}">{{$name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-1">{{__("Special Requirements")}} </label>
                <textarea name="customer_notes" cols="30" rows="4" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block p-3 outline-none transition-colors" placeholder="{{__('Special Requirements')}}"></textarea>
            </div>
        </div>
    </div>
    
    @include ('Booking::frontend/booking/checkout-deposit')
    @include ($service->checkout_form_payment_file ?? 'Booking::frontend/booking/checkout-payment')

    @php
    $term_conditions = setting_item('booking_term_conditions');
    @endphp

    <div class="form-group mt-6 p-4 bg-blue-50 border border-blue-100 rounded-lg">
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="term_conditions" class="w-5 h-5 text-brand bg-white border-gray-300 rounded focus:ring-brand focus:ring-2 accent-brand">
            <span class="text-gray-700 text-sm">
                {{__('I have read and accept the')}}  <a target="_blank" href="{{get_page_url($term_conditions)}}" class="text-brand font-bold hover:underline">{{__('terms and conditions')}}</a>
            </span>
        </label>
    </div>
    
    @if(setting_item("booking_enable_recaptcha"))
        <div class="form-group mt-4">
            {{recaptcha_field('booking')}}
        </div>
    @endif
    <div class="html_before_actions"></div>

    <p class="mt-4 p-4 rounded-lg text-sm font-bold" v-show="message.content" v-html="message.content" :class="{'bg-red-50 text-red-700 border border-red-200':!message.type,'bg-green-50 text-green-700 border border-green-200':message.type}"></p>

    <div class="mt-8 border-t border-gray-100 pt-6">
        <button class="w-full md:w-auto px-10 py-4 bg-gradient-to-r from-brand to-brand-dark hover:from-brand-dark hover:to-[#a93210] text-white font-black rounded-lg shadow-lg hover:shadow-xl transition-all uppercase tracking-wide text-lg flex justify-center items-center gap-3 ml-auto" @click="doCheckout">
            {{__('Complete Booking')}}
            <i class="fa fa-spin fa-spinner" v-show="onSubmit"></i>
            <svg v-show="!onSubmit" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </button>
    </div>
</div>

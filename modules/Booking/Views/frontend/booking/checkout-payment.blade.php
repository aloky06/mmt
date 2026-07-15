<div class="form-section mt-8 pt-8 border-t border-gray-100">
    <h4 class="text-2xl font-black text-gray-900 mb-6">{{__('Select Payment Method')}}</h4>
    <div class="gateways-table accordion space-y-4" id="accordionExample">
        @foreach($gateways as $k=>$gateway)
            <div class="card bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:border-brand/50 transition-colors">
                <div class="card-header bg-gray-50 border-b border-gray-100 p-0">
                    <h4 class="mb-0">
                        <label class="cursor-pointer flex items-center p-4 m-0 w-full" data-toggle="collapse" data-target="#gateway_{{$k}}" >
                            <input type="radio" name="payment_gateway" value="{{$k}}" class="w-5 h-5 text-brand bg-white border-gray-300 focus:ring-brand focus:ring-2 accent-brand shrink-0">
                            
                            <div class="ml-4 flex items-center gap-3 font-bold text-gray-900 flex-1">
                                @if($logo = $gateway->getDisplayLogo())
                                    <img src="{{$logo}}" alt="{{$gateway->getDisplayName()}}" class="h-8 object-contain">
                                @endif
                                {{$gateway->getDisplayName()}}
                            </div>
                            
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </label>
                    </h4>
                </div>
                <div id="gateway_{{$k}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body p-5 text-gray-600 prose-sm bg-white">
                        <div class="gateway_name font-bold text-gray-900 mb-2 pb-2 border-b border-gray-100">
                            {!! $gateway->getDisplayName() !!}
                        </div>
                        {!! $gateway->getDisplayHtml() !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

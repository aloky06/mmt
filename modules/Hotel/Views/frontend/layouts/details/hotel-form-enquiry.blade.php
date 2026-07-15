<div class="sticky top-[100px] z-20">
    <div class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden mb-6">
        
        <!-- Header / Price -->
        <div class="p-6 border-b border-gray-100 bg-gradient-to-br from-gray-50 to-white">
            @if($row->discount_percent)
                <div class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded inline-block mb-3">
                    {{$row->discount_percent}} {{__("OFF")}}
                </div>
            @endif
            
            <div class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-1">{{__("Starting from")}}</div>
            <div class="flex items-end gap-2">
                @if($row->display_sale_price)
                    <div class="text-sm text-gray-400 line-through mb-1">{{ $row->display_sale_price }}</div>
                @endif
                <div class="text-3xl font-black text-gray-900 leading-none">{{ $row->display_price }}</div>
            </div>
            <div class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mt-2">
                {{__("Per Room / Night")}}
            </div>
        </div>
        
        <!-- Body / Actions -->
        <div class="p-6">
            @if($row->getBookingEnquiryType() === "enquiry")
                <button class="w-full bg-brand hover:bg-brand-dark text-white font-black py-4 rounded-lg shadow-md hover:shadow-lg transition-all uppercase tracking-wide text-sm flex justify-center items-center gap-2" data-toggle="modal" data-target="#enquiry_form_modal">
                    <i class="fa fa-envelope-o text-lg"></i>
                    {{ __("Contact Property") }}
                </button>
            @else
                <a href="#hotel-rooms" class="w-full bg-gradient-to-r from-brand to-brand-dark hover:from-brand-dark hover:to-[#a93210] text-white font-black py-4 rounded-lg shadow-md hover:shadow-lg transition-all uppercase tracking-wide text-sm flex justify-center items-center gap-2">
                    {{ __("Select Room") }}
                    <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                </a>
            @endif
            
            <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-500 font-medium">
                <i class="fa fa-check-circle text-green-500"></i>
                {{__("Best Price Guarantee")}}
            </div>
        </div>
        
    </div>
</div>

<script>
    // Smooth scroll to rooms
    document.addEventListener('DOMContentLoaded', function() {
        const selectRoomBtn = document.querySelector('a[href="#hotel-rooms"]');
        if (selectRoomBtn) {
            selectRoomBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector('#hotel-rooms');
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        }
    });
</script>
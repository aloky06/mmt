@php
    $gallery = $row->getGallery();
    if (empty($gallery)) {
        if ($row->image_id) {
            $gallery = [['large' => get_file_url($row->image_id, 'full'), 'thumb' => get_file_url($row->image_id, 'thumb')]];
        }
    }
@endphp

@if(!empty($gallery))
<div class="container mx-auto px-4 mt-6" style="max-width: 1200px;">
    
    <!-- DESKTOP MOSAIC GRID -->
    <div class="hidden md:flex gap-2 h-[450px] rounded-2xl overflow-hidden relative group">
        
        <!-- Main Large Image -->
        <div class="w-2/3 h-full relative cursor-pointer overflow-hidden">
            <a href="{{ $gallery[0]['large'] }}" data-thumb="{{ $gallery[0]['thumb'] }}" class="fotorama-trigger block w-full h-full" data-index="0">
                <img src="{{ $gallery[0]['large'] }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" alt="{{ $translation->title ?? 'Hotel Image' }}">
            </a>
            
            <!-- Video Overlay if available -->
            @if($row->video)
                <a href="#" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/50 hover:bg-brand/90 transition-colors w-16 h-16 flex items-center justify-center rounded-full backdrop-blur-sm z-10" data-toggle="modal" data-src="{{ handleVideoUrl($row->video) }}" data-target="#myModal">
                    <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </a>
            @endif
        </div>
        
        <!-- Right Side Smaller Images -->
        <div class="w-1/3 flex flex-col gap-2 h-full">
            @if(count($gallery) > 1)
                <!-- Top Right -->
                <div class="flex gap-2 h-1/2">
                    <div class="w-full h-full relative cursor-pointer overflow-hidden">
                        <a href="{{ $gallery[1]['large'] }}" data-thumb="{{ $gallery[1]['thumb'] }}" class="fotorama-trigger block w-full h-full" data-index="1">
                            <img src="{{ $gallery[1]['large'] }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" alt="Gallery Image 2">
                        </a>
                    </div>
                </div>
            @endif
            
            @if(count($gallery) > 2)
                <!-- Bottom Right -->
                <div class="flex gap-2 h-1/2">
                    <div class="w-1/2 h-full relative cursor-pointer overflow-hidden">
                        <a href="{{ $gallery[2]['large'] }}" data-thumb="{{ $gallery[2]['thumb'] }}" class="fotorama-trigger block w-full h-full" data-index="2">
                            <img src="{{ $gallery[2]['large'] }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" alt="Gallery Image 3">
                        </a>
                    </div>
                    
                    @if(count($gallery) > 3)
                        <div class="w-1/2 h-full relative cursor-pointer overflow-hidden">
                            <a href="{{ $gallery[3]['large'] }}" data-thumb="{{ $gallery[3]['thumb'] }}" class="fotorama-trigger block w-full h-full" data-index="3">
                                <img src="{{ $gallery[3]['large'] }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" alt="Gallery Image 4">
                            </a>
                            
                            @if(count($gallery) > 4)
                                <!-- View All Overlay -->
                                <div class="absolute inset-0 bg-black/40 hover:bg-black/60 transition-colors flex items-center justify-center pointer-events-none">
                                    <span class="text-white font-bold text-lg pointer-events-auto cursor-pointer" onclick="document.querySelector('.fotorama-trigger').click()">+{{ count($gallery) - 4 }} Photos</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </div>
        
    </div>

    <!-- MOBILE CAROUSEL -->
    <div class="md:hidden relative h-64 rounded-xl overflow-hidden" x-data="{ activeSlide: 0, slides: {{ json_encode($gallery) }} }">
        <template x-for="(slide, index) in slides" :key="index">
            <img x-show="activeSlide === index" :src="slide.large" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        </template>
        
        <div x-show="slides.length > 1" class="absolute inset-0 flex items-center justify-between px-3">
            <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1" class="bg-black/40 hover:bg-black/60 text-white rounded-full p-2 backdrop-blur">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1" class="bg-black/40 hover:bg-black/60 text-white rounded-full p-2 backdrop-blur">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
        
        <div class="absolute bottom-3 right-3 bg-black/60 text-white text-xs font-bold px-2 py-1 rounded backdrop-blur">
            <span x-text="activeSlide + 1"></span> / <span x-text="slides.length"></span>
        </div>
    </div>
    
    <!-- Hidden Fotorama container for lightbox functionality -->
    <div class="hidden">
        <div class="fotorama" data-width="100%" data-thumbwidth="135" data-thumbheight="135" data-thumbmargin="15" data-nav="thumbs" data-allowfullscreen="true">
            @foreach($gallery as $item)
                <a href="{{$item['large']}}" data-thumb="{{$item['thumb']}}" data-alt="{{ __("Gallery") }}"></a>
            @endforeach
        </div>
    </div>

</div>

<!-- Video Modal -->
@if($row->video)
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item bravo_embed_video" src="" allowscriptaccess="always" allow="autoplay"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    /* Prevent fotorama from breaking layout when hidden */
    .fotorama--fullscreen { z-index: 9999 !important; }
</style>

<script>
    // Link grid images to fotorama lightbox
    document.addEventListener('DOMContentLoaded', function() {
        const triggers = document.querySelectorAll('.fotorama-trigger');
        triggers.forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const index = this.getAttribute('data-index');
                const fotoramaApi = $('.fotorama').data('fotorama');
                if (fotoramaApi) {
                    fotoramaApi.show(parseInt(index));
                    fotoramaApi.requestFullScreen();
                }
            });
        });
    });
</script>
@endif

<div class="goibibo-search-container py-5" style="background-image: url('{{ $bg_image_url ?? 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80' }}'); background-size: cover; background-position: center;">
    <div class="search-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- EMT Style Top Text -->
                <div class="mb-4 text-left">
                    <h1 class="text-white font-weight-bold" style="font-size: 48px; letter-spacing: -0.5px; text-shadow: 0 4px 15px rgba(0,0,0,0.4); margin-bottom: 8px;">Explore the World for Less</h1>
                    <h3 class="text-white" style="font-size: 20px; font-weight: 400; text-shadow: 0 2px 10px rgba(0,0,0,0.3); opacity: 0.9;">India's #1 trusted platform for hotels, homes, and endless adventures.</h3>
                </div>
                
                @if(empty($hide_form_search))
                    <div class="g-form-control goibibo-form-widget">
                        <!-- Visible Tabs attached to top of search bar -->
                        <ul class="nav nav-tabs custom-hero-tabs" role="tablist" id="goibibo-hidden-tabs">
                            @if(!empty($service_types))
                                @php 
                                    if(in_array('car', $service_types)) {
                                        $service_types = array_diff($service_types, ['car']);
                                        array_unshift($service_types, 'car');
                                    }
                                    $number = 0; 
                                @endphp
                                @foreach ($service_types as $service_type)
                                    @php
                                        $allServices = get_bookable_services();
                                        if(empty($allServices[$service_type])) continue;
                                        $module = new $allServices[$service_type];
                                        $tab_title = !empty($modelBlock["title_for_".$service_type]) ? $modelBlock["title_for_".$service_type] : $module->getModelName();
                                        
                                        $icon = "";
                                        $display_name = $tab_title;
                                        switch($service_type){
                                            case 'hotel': 
                                                $icon = 'fa fa-building-o'; 
                                                $display_name = 'HOTELS';
                                                break;
                                            case 'tour': 
                                                $icon = 'icofont-globe'; 
                                                $display_name = 'TOURS';
                                                break;
                                            case 'space': 
                                                $icon = 'icofont-building-alt'; 
                                                $display_name = 'SPACE';
                                                break;
                                            case 'car': 
                                                $icon = 'icofont-car-alt-4'; 
                                                $display_name = 'CABS';
                                                break;
                                            case 'event': 
                                                $icon = 'icofont-ui-calendar'; 
                                                $display_name = 'EVENT';
                                                break;
                                            case 'flight': 
                                                $icon = 'icofont-ui-flight'; 
                                                $display_name = 'FLIGHT';
                                                break;
                                            case 'boat': 
                                                $icon = 'icofont-ship'; 
                                                $display_name = 'CRUISE';
                                                break;
                                        }
                                    @endphp
                                    <li role="bravo_{{$service_type}}">
                                        <a href="#bravo_{{$service_type}}" class="@if($number == 0) active @endif" aria-controls="bravo_{{$service_type}}" role="tab" data-toggle="tab" data-title="Search for {{$tab_title}}">
                                            @if(!empty($icon)) <i class="{{$icon}}"></i> @endif {{ $display_name }}
                                        </a>
                                    </li>
                                    @php $number++; @endphp
                                @endforeach
                            @endif
                        </ul>
                        
                        <!-- Search Forms -->
                        <div class="tab-content">
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
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Only run this script if we are on a page with the Goibibo search container (e.g. Homepage)
    if (document.querySelector('.goibibo-search-container')) {
        
        const headerLinks = document.querySelectorAll('.bravo_header .bravo-menu .main-menu > li > a');
        const hiddenTabs = document.querySelectorAll('#goibibo-hidden-tabs a[data-toggle="tab"]');
        const dynamicTitle = document.getElementById('goibibo-dynamic-title');
        
        // Map header URLs to internal tab IDs
        // E.g. URL '/flight' -> Tab '#bravo_flight'
        function activateTabFromUrl(url) {
            let matched = false;
            hiddenTabs.forEach(tab => {
                const targetId = tab.getAttribute('href'); // e.g. #bravo_flight
                const service = targetId.replace('#bravo_', ''); // e.g. flight
                
                if (url.includes('/' + service)) {
                    // Click the hidden tab to trigger Booking Core's native tab switching JS
                    $(tab).tab('show');
                    
                    // Update Title
                    dynamicTitle.innerText = tab.getAttribute('data-title');
                    matched = true;
                }
            });
            return matched;
        }

        // Set initial active state based on the first tab
        if(hiddenTabs.length > 0) {
            let activeTab = document.querySelector('#goibibo-hidden-tabs a.active');
            if(activeTab) {
                dynamicTitle.innerText = activeTab.getAttribute('data-title');
            }
        }

        // Intercept Header Menu Clicks
        headerLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // If the link matches a service in our search widget, prevent navigation and switch tab instead
                if (activateTabFromUrl(href)) {
                    e.preventDefault();
                    
                    // Update header visual active state
                    document.querySelectorAll('.bravo_header .bravo-menu .main-menu > li').forEach(li => li.classList.remove('active'));
                    this.parentElement.classList.add('active');
                }
            });
        });
    }
});
</script>

<style>
/* --- Modern Tabbed Hero Styling --- */
.bravo_wrap .page-template-content .bravo-form-search-all {
    padding: 0 !important; /* Force remove standard Booking Core padding */
}
.goibibo-search-container {
    min-height: 85vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-top: -1px; 
    position: relative;
    border: none;
    z-index: 1;
}
.search-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.25); /* Lighter overlay like screenshot */
    z-index: -1;
}

.goibibo-form-widget {
    position: relative;
    z-index: 10;
}

/* Tabs styling exactly like screenshot */
.custom-hero-tabs {
    border-bottom: none;
    display: flex;
    flex-wrap: nowrap;
    margin: 0 0 15px 0; /* Space between tabs and search box */
    padding: 0;
    justify-content: flex-start;
}
.custom-hero-tabs li {
    margin-right: 12px;
}
.custom-hero-tabs li a {
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    align-items: center !important;
    padding: 10px 24px !important;
    background: transparent !important;
    color: #fff !important;
    font-size: 15px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    border-radius: 12px !important;
    text-decoration: none !important;
    border: none !important;
    transition: all 0.3s ease !important;
}
.custom-hero-tabs li a i {
    font-size: 26px;
    margin-right: 0;
    margin-bottom: 6px;
    color: rgba(255, 255, 255, 0.9);
    transition: all 0.3s ease;
}
.custom-hero-tabs li a:hover {
    background: rgba(255, 255, 255, 0.1);
}
.custom-hero-tabs li a.active {
    background: #ffffff !important; /* Crisp white for active state */
    color: #1a2b49 !important; /* Deep premium blue text */
    box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important;
}
.custom-hero-tabs li a.active i {
    color: #5191fa; /* Bright blue icon for active state */
}

.goibibo-form-widget .tab-content {
    background: #fff !important;
    border-radius: 12px !important;
    box-shadow: 0 15px 40px rgba(0,0,0,0.15) !important;
    width: 100% !important;
    position: relative !important;
    margin-bottom: 35px !important;
    overflow: visible !important;
}
.goibibo-form-widget .tab-content .tab-pane {
    width: 100% !important;
    height: 100% !important;
    overflow: visible !important;
}

.goibibo-form-widget form.bravo_form {
    display: flex !important;
    flex-wrap: nowrap !important;
    align-items: stretch !important;
    justify-content: flex-start !important;
    min-height: 90px !important;
    width: 100% !important;
    margin: 0 !important;
    overflow: visible !important;
}
.goibibo-form-widget .g-field-search {
    flex: 1 1 0; /* min-width 0 is essential to prevent flex child overflow */
    min-width: 0;
    border: none;
    background: transparent;
    width: 100%;
}
.goibibo-form-widget .g-field-search .row {
    margin: 0;
    height: 100%;
}
.goibibo-form-widget .g-field-search [class*="col-"] {
    border-right: 1px solid #eaeef3;
    padding: 15px 25px;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    transition: background 0.2s ease;
}
.goibibo-form-widget .g-field-search [class*="col-"]:hover {
    background: #f8fafc;
    cursor: pointer;
}
.goibibo-form-widget .g-field-search [class*="col-"]:last-child {
    border-right: none;
}
.goibibo-form-widget .form-group {
    margin: 0 !important;
    border: none !important;
    padding-left: 0; 
}
.goibibo-form-widget .form-control {
    border: none !important;
    padding-left: 0 !important;
    font-size: 18px !important;
    font-weight: 500 !important;
    color: #5191fa !important; /* Match active tab color */
    background: transparent !important;
    height: auto !important;
}
.goibibo-form-widget label {
    font-size: 14px;
    color: #454545;
    text-transform: none;
    font-weight: 500;
    margin-bottom: 2px;
    display: block;
    white-space: nowrap;
}

/* Prevent text overflow in render and inputs */
.goibibo-form-widget .form-content .render,
.goibibo-form-widget .form-content .smart-search-location {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
    width: 100%;
    max-width: 100%;
}

/* Submit Button fixed layout */
.goibibo-form-widget .g-button-submit {
    position: absolute !important;
    bottom: -25px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    width: 220px !important; 
    height: 50px !important;
    padding: 0 !important;
    display: flex !important;
    z-index: 9999 !important;
}
.goibibo-form-widget .g-button-submit .btn-search {
    background: #5191fa !important; /* Match active tab */
    border-radius: 25px !important; /* Pill shape */
    padding: 0 !important;
    font-size: 20px !important;
    font-weight: 700 !important;
    border: none !important;
    text-transform: uppercase;
    color: #fff !important;
    width: 100%;
    height: 100%;
    box-shadow: 0 4px 15px rgba(81, 145, 250, 0.4) !important;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease !important;
}
.goibibo-form-widget .g-button-submit .btn-search:hover {
    background: #3b7ced !important;
}

/* Adjusting icons in the form */
.goibibo-form-widget .g-field-search i.field-icon {
    font-size: 24px;
    color: #5191fa;
    margin-right: 15px;
    display: inline-block;
}
.goibibo-form-widget .form-group {
    display: flex;
    align-items: center;
}

/* Responsive Fixes */
@media (max-width: 991px) {
    .goibibo-search-container {
        padding-top: 60px; 
        padding-bottom: 80px;
    }
    .custom-hero-tabs {
        overflow-x: auto;
        padding-bottom: 15px; /* Room for scroll/shadow */
        -webkit-overflow-scrolling: touch;
    }
    .custom-hero-tabs::-webkit-scrollbar {
        display: none; /* Clean horizontal scroll */
    }
    .goibibo-form-widget .tab-content {
        border-radius: 12px;
    }
    .goibibo-form-widget form.bravo_form {
        flex-direction: column;
    }
    .goibibo-form-widget .g-field-search [class*="col-"] {
        border-right: none;
        border-bottom: 1px solid #eaeef3;
    }
    .goibibo-form-widget .g-field-search [class*="col-"]:last-child {
        border-bottom: none;
    }
    .goibibo-form-widget .g-button-submit {
        position: static;
        width: 100%;
        height: 60px;
        transform: none;
        margin-top: 15px;
    }
    .goibibo-form-widget .g-button-submit .btn-search {
        border-radius: 12px !important;
        box-shadow: none !important;
    }
}
</style>
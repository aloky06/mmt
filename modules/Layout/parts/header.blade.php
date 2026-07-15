<div class="bravo_header">
    <div class="{{$container_class ?? 'container'}}">
        <div class="content">
            <div class="header-left">
                <a href="{{url(app_get_locale(false,'/'))}}" class="bravo-logo">
                    @php
                        $logo_id = setting_item("logo_id");
                        if(!empty($row->custom_logo)){
                            $logo_id = $row->custom_logo;
                        }
                    @endphp
                    @if($logo_id)
                        <?php $logo = get_file_url($logo_id,'full') ?>
                        <img src="{{$logo}}" alt="{{setting_item("site_title")}}">
                    @endif
                </a>
                <div class="bravo-menu">
                    <?php generate_menu('primary') ?>
                </div>
            </div>
            <div class="header-right">
                <ul class="topbar-items">
                    @if(!Auth::id())
                        <li style="display: flex; align-items: center; margin-left: 5px;">
                            <a href="#login" data-toggle="modal" data-target="#login" class="btn-login-brand">
                                <div class="login-brand-content">
                                    <span class="user-brand-icon"><img src="https://cdn-icons-png.flaticon.com/512/1144/1144760.png" style="width: 18px" alt="User"></span>
                                    <span class="login-text">
                                        <div style="font-size:10px; line-height:1.1; font-weight:600; text-transform:uppercase;">Login or</div>
                                        <div style="font-size:13px; line-height:1.1; font-weight:700;">Create Account</div>
                                    </span>
                                </div>
                            </a>
                        </li>
                    @else
                        <li class="login-item dropdown">
                            <a href="#" data-toggle="dropdown" class="is_login">
                                @if($avatar_url = Auth::user()->getAvatarUrl())
                                    <img class="avatar" src="{{$avatar_url}}" alt="{{ Auth::user()->getDisplayName()}}">
                                @else
                                    <span class="avatar-text">{{ucfirst( Auth::user()->getDisplayName()[0])}}</span>
                                @endif
                                {{__("Hi, :Name",['name'=>Auth::user()->getDisplayName()])}}
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu text-left">
                                @if(Auth::user()->hasPermissionTo('dashboard_vendor_access'))
                                    <li><a href="{{route('vendor.dashboard')}}"><i class="icon ion-md-analytics"></i> {{__("Vendor Dashboard")}}</a></li>
                                @endif
                                <li class="@if(Auth::user()->hasPermissionTo('dashboard_vendor_access')) menu-hr @endif">
                                    <a href="{{route('user.profile.index')}}"><i class="icon ion-md-construct"></i> {{__("My profile")}}</a>
                                </li>
                                @if(setting_item('inbox_enable'))
                                <li class="menu-hr"><a href="{{route('user.chat')}}"><i class="fa fa-comments"></i> {{__("Messages")}}</a></li>
                                @endif
                                <li class="menu-hr"><a href="{{route('user.booking_history')}}"><i class="fa fa-clock-o"></i> {{__("Booking History")}}</a></li>
                                <li class="menu-hr"><a href="{{route('user.change_password')}}"><i class="fa fa-lock"></i> {{__("Change password")}}</a></li>
                                @if(Auth::user()->hasPermissionTo('dashboard_access'))
                                    <li class="menu-hr"><a href="{{url('/admin')}}"><i class="icon ion-ios-ribbon"></i> {{__("Admin Dashboard")}}</a></li>
                                @endif
                                <li class="menu-hr">
                                    <a  href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> {{__('Logout')}}</a>
                                </li>
                            </ul>
                            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endif
                </ul>
                <button class="bravo-more-menu">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="bravo-menu-mobile" style="display:none;">
        <div class="user-profile">
            <div class="b-close"><i class="icofont-scroll-left"></i></div>
            <div class="avatar"></div>
            <ul>
                @if(!Auth::id())
                    <li>
                        <a href="#login" data-toggle="modal" data-target="#login" class="login">{{__('Login')}}</a>
                    </li>
                    <li>
                        <a href="#register" data-toggle="modal" data-target="#register" class="signup">{{__('Sign Up')}}</a>
                    </li>
                @else
                    <li>
                        <a href="{{route('user.profile.index')}}">
                            <i class="icofont-user-suited"></i> {{__("Hi, :Name",['name'=>Auth::user()->getDisplayName()])}}
                        </a>
                    </li>
                    @if(Auth::user()->hasPermissionTo('dashboard_vendor_access'))
                        <li><a href="{{route('vendor.dashboard')}}"><i class="icon ion-md-analytics"></i> {{__("Vendor Dashboard")}}</a></li>
                    @endif
                    @if(Auth::user()->hasPermissionTo('dashboard_access'))
                        <li>
                            <a href="{{url('/admin')}}"><i class="icon ion-ios-ribbon"></i> {{__("Admin Dashboard")}}</a>
                        </li>
                    @endif
                    <li>
                        <a href="{{route('user.profile.index')}}">
                            <i class="icon ion-md-construct"></i> {{__("My profile")}}
                        </a>
                    </li>
                    <li>
                        <a  href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                            <i class="fa fa-sign-out"></i> {{__('Logout')}}
                        </a>
                        <form id="logout-form-mobile" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
            </ul>
            <ul class="multi-lang">
                @include('Core::frontend.currency-switcher')
            </ul>
            <ul class="multi-lang">
                @include('Language::frontend.switcher')
            </ul>
        </div>
        <div class="g-menu">
            <?php generate_menu('primary') ?>
        </div>
    </div>
</div>
<style>
/* --- MakeMyTrip Premium Header Styles --- */

/* Base Header */
.bravo_header {
    background-color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border-bottom: 1px solid #eaeaea !important;
}

/* --- Desktop Menu (MakeMyTrip Stacked Icons) --- */
@media (min-width: 992px) {
    .bravo_header .content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .bravo_header .header-left {
        flex: 1 1 auto;
        display: flex;
        align-items: center;
    }
    .bravo_header .header-left .bravo-logo {
        flex-shrink: 0;
        display: block;
        margin-right: 20px;
    }
    .bravo_header .header-right {
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }
    .bravo_header .bravo-menu {
        flex: 1;
        display: flex;
        justify-content: center;
    }
    .bravo_header .bravo-menu .main-menu {
        display: flex;
        justify-content: center;
        margin: 0 auto;
    }
    .bravo_header .bravo-menu .main-menu > li > a {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        line-height: 1.2;
        padding: 15px 25px 8px 25px !important; /* Increased horizontal space */
        color: #4a4a4a;
        position: relative;
        transition: all 0.2s ease;
        background: transparent !important;
        text-align: center;
        min-width: 90px; /* Wider hit area */
    }
    .bravo_header .bravo-menu .main-menu > li > a:hover {
        color: #008cff;
    }
    .bravo_header .bravo-menu .main-menu > li > a .menu-icon {
        font-size: 26px; /* Slightly refined size */
        margin-right: 0 !important;
        margin-bottom: 8px;
        color: #5a6872; /* Premium muted color for inactive state */
        display: block;
        transition: all 0.2s ease;
    }
    .bravo_header .bravo-menu .main-menu > li > a .custom-menu-icon {
        width: 32px;
        height: 32px;
        object-fit: contain;
        margin-bottom: 8px;
        display: block;
    }
    .bravo_header .bravo-menu .main-menu > li > a .menu-text {
        font-size: 12.5px; /* Slightly smaller for elegance */
        font-weight: 700; /* Bold */
        text-transform: uppercase; /* Professional ALL CAPS */
        letter-spacing: 0.5px; /* Breathable tracking */
        white-space: normal;
        max-width: 85px; 
        display: block;
    }
    .bravo_header .bravo-menu .main-menu > li > a .caret {
        display: none; 
    }
    
    /* Active State - Bright Blue text and underline directly below */
    .bravo_header .bravo-menu .main-menu > li.active > a,
    .bravo_header .bravo-menu .main-menu > li > a.active {
        color: #008cff !important;
    }
    .bravo_header .bravo-menu .main-menu > li.active > a .menu-icon,
    .bravo_header .bravo-menu .main-menu > li > a.active .menu-icon,
    .bravo_header .bravo-menu .main-menu > li > a:hover .menu-icon {
        color: #008cff !important;
    }
    .bravo_header .bravo-menu .main-menu > li.active > a::after,
    .bravo_header .bravo-menu .main-menu > li > a.active::after {
        content: '';
        position: absolute;
        bottom: 0px; /* Sit gracefully at the bottom padding */
        left: 50%;
        transform: translateX(-50%);
        width: 60%; /* More elegant, shorter underline */
        height: 3px;
        background-color: #008cff;
        border-radius: 3px 3px 0 0;
        display: block !important;
    }

    /* Topbar items inside Header Right */
    .bravo_header .header-right .topbar-items {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        justify-content: flex-end !important;
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
        gap: 15px !important;
    }
    .bravo_header .header-right .topbar-items > li {
        display: flex !important;
        align-items: center !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .bravo_header .header-right .topbar-items > li > a {
        color: #4a4a4a !important;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        transition: color 0.2s;
        display: flex;
        align-items: center;
    }
    .bravo_header .header-right .topbar-items > li > a:hover {
        color: #ff6d38;
    }
    .btn-partner-outline {
        border: 1px dashed #a0a9b6 !important;
        background: transparent !important;
        font-weight: 600 !important;
        border-radius: 4px !important;
        padding: 0 14px !important;
        margin: 0 !important;
        color: #4a4a4a !important;
        display: flex !important;
        align-items: center !important;
        font-size: 13px !important;
        height: 42px !important;
        box-sizing: border-box !important;
        text-decoration: none !important;
    }
    .btn-partner-outline:hover {
        border-color: #ff6d38 !important;
        color: #ff6d38 !important;
    }
    .btn-login-brand {
        background: linear-gradient(93deg, #53b2fe, #065af3) !important;
        border: none !important;
        border-radius: 6px !important;
        padding: 0 16px !important;
        margin: 0 !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
        transition: all 0.3s ease !important;
        display: flex !important;
        align-items: center !important;
        height: 44px !important;
        color: #ffffff !important;
        text-decoration: none !important;
    }
    .bravo_header .header-right .topbar-items > li > a.btn-login-brand {
        color: #ffffff !important;
    }
    .btn-login-brand:hover {
        box-shadow: 0 4px 10px rgba(6,90,243,0.3) !important;
        transform: translateY(-1px) !important;
        color: #ffffff !important;
    }
    .login-brand-content {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }
    .user-brand-icon img {
        filter: invert(1) brightness(200%);
    }
    .user-brand-icon {
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .user-brand-icon img {
        filter: brightness(0) invert(1);
    }
    .login-text {
        text-align: left;
    }
}

/* --- Mobile Menu (Horizontal List) --- */
@media (max-width: 991px) {
    .bravo_header .header-right .topbar-items {
        display: none !important;
    }
    .bravo-menu-mobile .g-menu .main-menu > li > a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: 500;
        color: #333;
    }
    .bravo-menu-mobile .g-menu .main-menu > li > a .menu-icon {
        font-size: 20px;
        margin-right: 15px;
        color: #888;
        display: inline-block !important; /* Force icons back to inline block */
    }
    .bravo-menu-mobile .g-menu .main-menu > li > a .menu-text {
        font-size: 15px; /* Reset font size */
        font-weight: 500; /* Reset font weight */
        text-transform: none; /* Reset uppercase */
        letter-spacing: normal;
        max-width: none; 
        display: inline-block;
    }
    .bravo-menu-mobile .g-menu .main-menu > li.active > a,
    .bravo-menu-mobile .g-menu .main-menu > li > a:hover {
        background-color: #f5f5f5;
        color: #008cff;
    }
    .bravo-menu-mobile .g-menu .main-menu > li.active > a .menu-icon,
    .bravo-menu-mobile .g-menu .main-menu > li > a:hover .menu-icon {
        color: #008cff;
    }
    .bravo-menu-mobile .g-menu .main-menu > li.active > a::after {
        display: none !important; /* Hide the underline */
    }
}
</style>

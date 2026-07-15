<?php
$checkNotify = \Modules\Core\Models\NotificationPush::query();
if(is_admin()){
    $checkNotify->where(function($query){
        $query->where('data', 'LIKE', '%"for_admin":1%');
        $query->orWhere('notifiable_id', Auth::id());
    });
}else{
    $checkNotify->where('data', 'LIKE', '%"for_admin":0%');
    $checkNotify->where('notifiable_id', Auth::id());
}
$notifications = $checkNotify->orderBy('created_at', 'desc')->limit(5)->get();
$countUnread = $checkNotify->where('read_at', null)->count();
?>
<style>
    /* =========================================================
       PREMIUM TOPBAR
       ========================================================= */
    .bravo_topbar {
        background-color: #f7f9fa !important; 
        border-bottom: 1px solid #eaeaea;
        padding: 5px 0;
        min-height: 38px;
    }
    .bravo_topbar .content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .bravo_topbar .topbar-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .bravo_topbar .topbar-left a, .bravo_topbar .topbar-left span {
        color: #4a4a4a !important;
        text-decoration: none !important;
        font-weight: 500;
        transition: color 0.2s;
    }
    .bravo_topbar .topbar-left a:hover {
        color: #ff5f1f !important;
    }
    .bravo_topbar .topbar-right {
        flex-shrink: 0;
    }
    .bravo_topbar .topbar-right .topbar-items {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        justify-content: flex-end !important;
        margin: 0 !important;
        padding: 0 !important;
        list-style: none !important;
        gap: 15px !important;
    }
    .bravo_topbar .topbar-right .topbar-items > li {
        display: flex !important;
        align-items: center !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .bravo_topbar .topbar-right .topbar-items > li > a {
        color: #4a4a4a !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        transition: color 0.2s;
        display: flex !important;
        align-items: center !important;
        gap: 5px !important;
        font-size: 13px !important;
    }
    .bravo_topbar .topbar-right .topbar-items > li > a:hover {
        color: #ff5f1f !important;
    }
    .bravo_topbar .btn-partner {
        background: transparent !important;
        color: #4a4a4a !important;
        border: none !important;
        padding: 0 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        box-shadow: none !important;
        transition: color 0.2s ease !important;
    }
    .bravo_topbar .btn-partner:hover {
        color: #ff5f1f !important;
        transform: none;
        box-shadow: none !important;
    }
    .bravo_topbar .login-item a, .bravo_topbar .signup-item a {
        font-weight: 600 !important;
    }
    .bravo_topbar .dropdown-menu {
        background-color: #ffffff !important;
        border-radius: 8px !important;
        border: 1px solid #eaeaea !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
        padding: 8px 0 !important;
        margin-top: 10px !important;
        min-width: 180px !important;
    }
    .bravo_topbar .dropdown-menu li {
        background-color: transparent !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .bravo_topbar .dropdown-menu li a {
        color: #333333 !important;
        padding: 8px 20px !important;
        font-weight: 500 !important;
        display: block !important;
        font-size: 14px !important;
        text-decoration: none !important;
    }
    .bravo_topbar .dropdown-menu li a:hover {
        background-color: #f7f9fa !important;
        color: #ff5f1f !important;
    }
    .bravo_topbar .fa-angle-down {
        font-size: 12px;
        opacity: 0.7;
    }
    
    /* Ensure the list resets don't override bootstrap defaults badly on mobile */
    @media (max-width: 991px) {
        .bravo_topbar .content { flex-direction: column; gap: 10px; }
        .bravo_topbar .topbar-right .topbar-items { flex-wrap: wrap; justify-content: center; gap: 15px; }
    }
</style>
<div class="bravo_topbar">
    <div class="container">
        <div class="content">
            <div class="topbar-left">

                {!! clean(setting_item_with_lang("topbar_left_text")) !!}


            </div>
            <div class="topbar-right">
                <ul class="topbar-items">
                    @include('Core::frontend.country-switcher')
                    @include('Core::frontend.currency-switcher')
                    @include('Language::frontend.switcher')
                    <li class="dropdown" style="display: flex; align-items: center;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #4a4a4a !important; font-weight: 600; text-decoration: none; font-size: 13px; display: flex; align-items: center; gap: 4px;">
                            <img src="https://cdn-icons-png.flaticon.com/512/3233/3233483.png" style="width:14px; margin-right:4px;"> Partner With Us <i class="fa fa-angle-down" style="font-size:12px; margin-left:4px;"></i>
                        </a>
                        <ul class="dropdown-menu text-left">
                            <li><a href="{{ url('/attach-taxi') }}"><i class="fa fa-car"></i> Attach Your Taxi</a></li>
                            <li class="menu-hr"><a href="{{ route('hotel.list.landing') }}"><i class="fa fa-building"></i> List Your Property</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

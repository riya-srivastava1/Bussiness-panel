<!-- BEGIN #sidebar -->
<div id="sidebar" class="app-sidebar app-sidebar-transparent">
    <!-- BEGIN scrollbar -->
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <!-- BEGIN menu -->
        <div class="menu">
            <div class="menu-search mb-n3">
                <input type="text" class="form-control" placeholder="Sidebar menu filter..."
                    data-sidebar-search="true" />
            </div>
            <div id="appSidebarProfileMenu" class="collapse">
                <div class="menu-item pt-5px">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-cog"></i></div>
                        <div class="menu-text">Settings</div>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-pencil-alt"></i></div>
                        <div class="menu-text"> Send Feedback</div>
                    </a>
                </div>
                <div class="menu-item pb-5px">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-question-circle"></i></div>
                        <div class="menu-text"> Helps</div>
                    </a>
                </div>
                <div class="menu-divider m-0"></div>
            </div>
            <div class="menu-header">Navigation</div>
            <div class="menu-item {{ request()->routeIs('business.dashboard') ? 'active' : '' }}">
                <a href="{{ route('business.dashboard') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-dashboard"></i>
                    </div>
                    <div class="menu-text">Dashboard</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('business.dashboard.user.booking') ? 'active' : '' }}">
                <a href="{{ route('business.dashboard.user.booking') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-book-open-reader"></i>
                    </div>
                    <div class="menu-text">User Booking</div>
                </a>
            </div>
            <div
                class="menu-item has-sub {{ request()->routeIs('business.dashboard.myaccount') ? 'active' : '' }} {{ request()->routeIs('amenities') ? 'active' : '' }}">
                <a href="javascript:;" class="menu-link">
                    <div class="menu-icon">
                        <i class="far fa-id-badge"></i>
                    </div>
                    <div class="menu-text">Profile</div>
                    <div class="menu-caret"></div>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item {{ request()->routeIs('business.dashboard.myaccount') ? 'active' : '' }}">
                        <a href="{{ route('business.dashboard.myaccount') }}" class="menu-link">
                            <div class="menu-text">My Account</div>
                        </a>
                    </div>
                    <div class="menu-item {{ request()->routeIs('amenities') ? 'active' : '' }}">
                        <a href="{{ route('amenities') }}" class="menu-link">
                            <div class="menu-text">Amenities</div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="menu-item {{ request()->routeIs('business.dashboard.services') ? 'active' : '' }}">
                <a href="{{ route('business.dashboard.services') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-wrench"></i>
                    </div>
                    <div class="menu-text">Services</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('vendor.time.management') ? 'active' : '' }}">
                <a href="{{ route('vendor.time.management') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div class="menu-text">Manage date and time</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('vendor.branch') ? 'active' : '' }}">
                <a href="{{ route('vendor.branch') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-code-branch"></i>
                    </div>
                    <div class="menu-text">Manage Branches</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('vendor.add.stylist') ? 'active' : '' }}">
                <a href="{{ route('vendor.add.stylist') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-scissors"></i>
                    </div>
                    <div class="menu-text">Manage Stylists</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('business.dashboard.sliders') ? 'active' : '' }}">
                <a href="{{ route('business.dashboard.sliders') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-sliders"></i>
                    </div>
                    <div class="menu-text">Sliders</div>
                </a>
            </div>
            @php
                $vendorProfile = Auth::guard('business')->user()->vendor_profile;
                           $category_name = 'profile';
                if ($vendorProfile->category_type) {
                    $category = explode(',', $vendorProfile->category_type);
                    $category_name = $category[0];
                }
            @endphp
            <div class="menu-item">
                <a href="https://www.zoylee.com/zoylee-crm/?crm={{ Auth::guard('business')->user()->vendor_id }}"
                    class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-suitcase-rolling"></i>
                    </div>
                    <div class="menu-text">CRM</div>
                </a>
            </div>
            <div class="menu-item">
                <a href="https://www.zoylee.com/{{ ucfirst($category_name) }}/{{ $vendorProfile->slug }}"
                    class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-link"></i>
                    </div>
                    <div class="menu-text">Your Public URL</div>
                </a>
            </div>
            <!-- BEGIN minify-button -->
            <div class="menu-item d-flex">
                <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i
                        class="fa fa-angle-double-left"></i></a>
            </div>
            <!-- END minify-button -->
        </div>
        <!-- END menu -->
    </div>
    <!-- END scrollbar -->
</div>
<div class="app-sidebar-bg"></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile"
        class="stretched-link"></a>
</div>
<!-- END #sidebar -->

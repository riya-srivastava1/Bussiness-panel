<aside class="app-side" id="app-side">

    <!-- BEGIN .side-content -->
    <div class="side-content ">
        <!-- BEGIN .logo -->
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ asset('zoy-asset/img/logo.png') }}" alt="Zoylee" />
        </a>
        <!-- END .logo -->
        <!-- BEGIN .side-nav -->
        <nav class="side-nav">
            <!-- BEGIN: side-nav-content -->
            <ul class="bluemoonNav" id="bluemoonNav">
                <li class="@yield('dashboard-active-tab')">
                    <a href="{{ route('dashboard') }}">
                        <span class="has-icon">
                            <i class="icon-laptop_windows"></i>
                        </span>
                        <span class="nav-title">Dashboard</span>
                    </a>
                </li>
                <li class="@yield('dashboard-user-booking-tab')">
                    <a href="{{ route('business.dashboard.user.booking') }}">
                        <span class="has-icon">
                            <i class="icon-assignment_turned_in"></i>
                        </span>
                        <span class="nav-title">User Bookings</span>
                    </a>
                </li>
                <li class="@yield('dashboard-myAccount-tab')">
                    <a href="#" class="has-arrow" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-contact_mail"></i>
                        </span>
                        <span class="nav-title">Profile</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a href='{{ route('business.dashboard.myaccount') }}'>My Account</a>
                        </li>
                        <li>
                            <a href='{{ route('amenities') }}'>Amenities</a>
                        </li>
                    </ul>
                </li>

                <li class="@yield('dashboard-services-tab')">
                    <a href="{{ route('business.dashboard.services') }}">
                        <span class="has-icon">
                            <i class="icon-flash-outline"></i>
                        </span>
                        <span class="nav-title">Services</span>
                    </a>
                </li>

                <li class="@yield('dashboard-time-manage-tab')">
                    <a href="{{ route('vendor.time.management') }}">
                        <span class="has-icon">
                            <i class="icon-event_available"></i>
                        </span>
                        <span class="nav-title">Manage Date and Time</span>
                    </a>
                </li>

                <li class="@yield('dashboard-add-branch-tab')">
                    <a href="{{ route('vendor.branch') }}">
                        <span class="has-icon">
                            <i class="icon-domain"></i>
                        </span>
                        <span class="nav-title">Manage Branches</span>
                    </a>
                </li>

                <li class="@yield('dashboard-manage-stylist')">
                    <a href="{{ route('vendor.add.stylist') }}">
                        <span class="has-icon">
                            <i class="icon-accessibility"></i>
                        </span>
                        <span class="nav-title">Manage Stylists</span>
                    </a>
                </li>
                <li class="@yield('dashboard-sliders')">
                    <a href="{{ route('business.dashboard.sliders') }}">
                        <span class="has-icon">
                            <i class="icon-camera"></i>
                        </span>
                        <span class="nav-title">Sliders</span>
                    </a>
                </li>
                <li class="@yield('dashboard-manage-stylist')">
                    <a href="https://www.zoylee.com/zoylee-crm/?crm={{ Auth::guard('business')->user()->vendor_id }}"
                        target="_blank" class="text-white">
                        <span class="has-icon">
                            <i class="icon-card_travel"></i>
                        </span>
                        <span class="nav-title"><strong>CRM</strong></span>
                    </a>
                </li>

                <li>
                    @php
                        $vendorProfile = Auth::guard('business')->user()->vendor_profile;
                        $category_name = 'profile';
                        if ($vendorProfile->category_type) {
                            $category = explode(',', $vendorProfile->category_type);
                            $category_name = $category[0];
                        }
                    @endphp
                    <a href="https://www.zoylee.com/{{ ucfirst($category_name) }}/{{ $vendorProfile->slug }}"
                        target="_blank" class="text-white">
                        <span class="has-icon ">
                            <i class="icon-eye"></i>
                        </span>
                        <span class="nav-title"><strong>Your Public URL</strong></span>
                    </a>
                </li>
            </ul>
            <!-- END: side-nav-content -->
        </nav>
        <!-- END: .side-nav -->

    </div>
    <!-- END: .side-content -->

</aside>

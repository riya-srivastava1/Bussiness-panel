<header class="app-header">
    <div class="container-fluid">
        <div class="row gutters">
            <div class="col-xl-7 col-lg-7 col-md-6 col-sm-7 col-4">
                <a class="mini-nav-btn" href="#" id="app-side-mini-toggler">
                    <i class="icon-menu5"></i>
                </a>
                <a href="#app-side" data-toggle="onoffcanvas" class="onoffcanvas-toggler" aria-expanded="true">
                    <i class="icon-menu5"></i>
                </a>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-6 col-sm-5 col my-auto">
                <ul class="header-actions">
                    <li class="dropdown">
                        <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                            <span class="text-white">
                             {{ Auth::guard('business')->user()->vendor_profile->business_name ?? "UnNamed" }}
                            </span>
                            <i class="icon-chevron-small-down"></i>
                        </a>
                        <div class="dropdown-menu lg dropdown-menu-right" aria-labelledby="userSettings">
                            <ul class="user-settings-list">
                                <li>
                                    <a href="{{route('business.dashboard.myaccount')}}">
                                        <span >My Profile</span>
                                        {{-- <span class="badge badge-secondary">7</span> --}}
                                    </a>
                                </li>
                                <hr />
                                <li>
                                    {{-- <a   href="{{ route('business.logout') }}">
                                        <span>Logout</span>
                                    </a> --}}
                                </li>
                                <hr />
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

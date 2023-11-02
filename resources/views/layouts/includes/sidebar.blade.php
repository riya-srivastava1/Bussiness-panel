<div id="sidebar" class="app-sidebar">
    <!-- BEGIN scrollbar -->
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <!-- BEGIN menu -->
        <div class="menu">
            <div class="menu-profile">
                <a class="menu-profile-link" data-toggle="app-sidebar-profile" data-target="#appSidebarProfileMenu">
                    <div class="menu-profile-cover with-shadow"></div>
                    <div class="menu-profile-image">
                        @if (Auth::user()->image)
                            <img src="{{ asset('') }}{{ Auth::user()->image ?? '' }}"
                                alt="{{ asset('assets/img/person-dummy-e1553259379744.jpg') }}" />
                        @else
                            <img src="{{ asset('assets/img/person-dummy-e1553259379744.jpg') }}" alt="" />
                        @endif
                    </div>
                    <div class="menu-profile-info">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="menu-header">Navigation</div>
           
        </div>
        <!-- BEGIN minify-button -->
        <div class="menu-item d-flex">
            <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i
                    class="fa fa-angle-double-left"></i></a>
        </div>
        <!-- END minify-button -->
    </div>
    <!-- END scrollbar -->
</div>
<div class="app-sidebar-bg"></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a>
</div>

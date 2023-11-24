<!DOCTYPE html>
<html lang="en">

<head>
  <title>Zoylee Business</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="base_url" content="{{ URL::to('/') }}">
  {{-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> --}}
  <link rel="stylesheet" href="{{asset('business-lib/dashboard/css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('business-lib/dashboard/css/bootstrap-responsive.min.css')}}" />
  <link rel="stylesheet" href="{{asset('business-lib/dashboard/css/fullcalendar.css')}}" />
  <link rel="stylesheet" href="{{asset('business-lib/dashboard/css/matrix-style.css')}}" />
  <link rel="stylesheet" href="{{asset('business-lib/dashboard/css/matrix-media.css')}}" />
  <link href="{{asset('business-lib/dashboard/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="{{asset('business-lib/dashboard/css/jquery.gritter.css')}}" />
  <link rel="stylesheet" href="{{asset('business-lib/dashboard/custom.css')}}" />
  <link href="{{ asset('css/toastr.css')}}" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
  <link rel="icon" type="image/png" href="https://zoycdn.zoylee.com/favicon.png" sizes="16x16">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
  
  
  @yield('styles')
  <style>
    body{
      font-size:101% !important;
    }
    .toast-top-center{top: 40%;border-radius:0px;}
    /*
 ##Device = Desktops
 ##Screen = 1281px to higher resolution desktops
*/
  @media (min-width: 1281px) {
    .logo {
      width:150px;
      height:90px;
    }
  }

  /*
  ##Device = Laptops, Desktops
  ##Screen = B/w 1025px to 1280px
  */

  @media (min-width: 1025px) and (max-width: 1280px) {
  .logo {
      width:150px;
      height:90px;
  }

  }

  /*
  ##Device = Tablets, Ipads (portrait)
  ##Screen = B/w 768px to 1024px
  */

  @media (min-width: 768px) and (max-width: 1024px) {

  .logo {
      width:150px;
      height:100px;
  }

  }

  /*
  ##Device = Tablets, Ipads (landscape)
  ##Screen = B/w 768px to 1024px
  */

  @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
    .logo {
        width:50px;
        height:30px;
    }
  }

  /*
  ##Device = Low Resolution Tablets, Mobiles (Landscape)
  ##Screen = B/w 481px to 767px
  */

  @media (min-width: 481px) and (max-width: 767px) {
    .logo {
        width:50px;
        height:30px;
    }
  }

  /*
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
  */

  @media (min-width: 320px) and (max-width: 480px) {
    .logo {
        width:50px;
        height:30px;
    }
  }

 .msg-body-modal {
   /* Hidden by default */
  position: fixed !important; /* Stay in place */
  z-index: 1500 !important; /* Sit on top */
  /* padding-top: 20px !important; Location of the box */
  left: 0;
  top: 0 !important;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  display: none;
}
/* msg-body-Modal Content */
.msg-body-modal-content {
  background-color: #fefefe;
  margin: 2px !important;
  /* padding: 20px; */
  border: 1px solid #888;
  max-width: 325px !important;
  width: 100%;
  float:left;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}
.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.border{
  border: 1px solid lightgray;}
.p-2{
  padding: 2% !important;
}
.p-3{
  padding: 3% !important;
}
.my-2{
  margin: 2% 0px !important; 
}
.mx-2{
  margin: 0px 2% !important;
}.bg-light{
  background: lightgrey;
}
.mr-2{
  margin-right: 2% !important;
}
.ml-2{
  margin-left: 2% !important;
}.m-2{
  margin: 2%;
}.mt-2{
  margin-top: 2% !important;
}.mb-2{
  margin-bottom: 2% !important;
}
  </style>
</head>

<body>
  <div id="app"></div>
  <!--Header-part-->
  <div id="header">
    {{-- <h1 style=" url({{asset('logo.png')}}) no-repeat scroll 0 0 transparent" style=""></h1> --}}
    <img src="{{asset('business-lib/assets/logo.png')}}" alt="zoylee" class="logo">
  </div>
 
  <!--close-Header-part-->

  <!--top-Header-menu-->
  <div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
        @if(Auth::guard('business')->check())
          <input type="hidden" id="pusher_vendor_id" value="{{ Auth::guard('business')->user()->vendor_id ?? 'UnNamed' }}">
          <li class="dropdown" id="profile-messages">
            <a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle">
              <i class="icon icon-user"></i>  
              <span class="text">Welcome {{ Auth::guard('business')->user()->vendor_profile->business_name ?? "UnNamed" }}</span>
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{route('business.dashboard.myaccount')}}"><i class="icon-user"></i> My Profile</a></li>
              <li class="divider"></li>
              <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
              <li class="divider"></li>
              <li>
                <a  title="Logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="icon-key"></i>Log Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>
              </li>
            </ul>
          </li>
        @endif
     {{-- <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
          <li class="divider"></li>
          <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
          <li class="divider"></li>
          <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
          <li class="divider"></li>
          <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
        </ul>
      </li>
      <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>--}}
      <li>
        <a  title="Logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="icon icon-share-alt"></i> Log Out
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        </form>
      </li>
    </ul>
  </div>
  <!--close-top-Header-menu-->
  <!--start-top-serch-->
  <div id="search">
    <input type="text" placeholder="Search here..." />
    <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
  </div>
  <!--close-top-serch-->
  <!--sidebar-menu-->
  
  <div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
      
      <li class="@yield('dashboard-active-tab')"><a href="{{route('business.dashboard')}}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
      <li class="@yield('dashboard-user-booking-tab')"><a href="{{route('business.dashboard.user.booking')}}"><i class="icon icon-home"></i> <span>User Booking</span></a> </li>
      <li class="submenu @yield('dashboard-myAccount-tab')"> <a href="#"><i class="icon icon-info-sign"></i> <span>Profile</span></a>
        <ul>
          <li class=""> <a href="{{route('business.dashboard.myaccount')}}"><i class="icon icon-signal"></i> <span>My account</span></a> </li>
          <li><a href="{{route('amenities')}}"> <i class="icon icon-signal"></i>  Amenities</a></li>
        
        </ul>
      </li>  
      <li class="@yield('dashboard-services-tab')"> <a href="{{route('business.dashboard.services')}}"><i class="icon icon-inbox"></i> <span>Services</span></a> </li>
      <li class="@yield('dashboard-slider-tab')"><a href="{{route('business.dashboard.sliders')}}"><i class="icon icon-th"></i> <span>Slider</span></a></li>
      <li class="@yield('dashboard-time-manage-tab')"><a href="{{route('vendor.time.management')}}"><i class="icon icon-th"></i> <span>Manage date time</span></a></li>
      @if(Auth::guard('business')->check() && Auth::guard('business')->user()->label==1)
      <li class="@yield('dashboard-add-branch-tab')"><a href="{{route('vendor.add.branch')}}"><i class="icon icon-th"></i> <span>Manage branch</span></a></li>
      <li class="@yield('dashboard-manage-stylist')"><a href="{{route('vendor.add.stylist')}}"><i class="icon icon-th"></i> <span>Manage stylist</span></a></li>
      @endif
    </ul>
  </div>
  <!--sidebar-menu-->



  <div id="content">
    @section('content')
    @show
  </div>








  <!--Footer-part-->

  <div class="row-fluid">
    <div id="footer" class="span12"> 2019 &copy; Zoylee Business. </div>
  </div>



  <!--end-Footer-part-->

 
<div class="row" >
  <div id="msg-body"  class="msg-body-modal">
    <!-- msg-body-Modal content -->
   
    
    


  </div>
</div>
  

  <script src="{{asset('js/app.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/excanvas.min.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/jquery.min.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/jquery.ui.custom.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/jquery.flot.min.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/jquery.flot.resize.min.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/matrix.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/matrix.dashboard.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/matrix.interface.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/jquery.validate.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/matrix.form_validation.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/jquery.wizard.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/jquery.uniform.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/matrix.popover.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('business-lib/dashboard/js/matrix.tables.js')}}"></script>
  <script src="{{asset('js/lodash.js')}}"></script>
  <script src="{{asset('js/validation.js')}}"></script>
  <script src="{{asset('js/toastr.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
  <script type="text/javascript">
  
    // This function is called from the pop-up menus to transfer to
    // a different page. Ignore if the value returned is a null string:
    function goPage(newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {

        // if url is "-", it is this page -- reset the menu:
        if (newURL == "-") {
          resetMenu();
        }
        // else, send page to designated URL            
        else {
          document.location.href = newURL;
        }
      }
    }

    // resets the menu selection upon entry to this page:
    function resetMenu() {
      document.gomenu.selector.selectedIndex = 2;
    }
  </script>

<script type="text/javascript">
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "10000",
    "hideDuration": "10000",
    "timeOut": "10000",
    "extendedTimeOut": "10000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }

  @if(Session::has('success'))
  toastr.success("{{ Session::get('success') }}");
  @endif


  @if(Session::has('info'))
  toastr.info("{{ Session::get('info') }}");
  @endif


  @if(Session::has('warning'))
  toastr.warning("{{ Session::get('warning') }}");
  @endif


  @if(Session::has('error'))
  toastr.error("{{ Session::get('error') }}");
  @endif

  @if ($errors ->any())
    @foreach($errors ->all() as $err)
  toastr.error("{{ $err }}");
  @endforeach
  @endif


  $('.msg-body-modal').click(function(){
     $(this).css({'background-color':'rgba(0,0,0,0.0)','height':'auto'});
  });
  $('.js-example-basic-single').select2();

</script>
<script src="{{asset('business-lib/dashboard/autoload_notify.js')}}"></script>
@yield('scripts')
</body>

</html>
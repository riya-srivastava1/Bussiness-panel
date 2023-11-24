<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Cache-control" content="public">
    <meta name="theme-color" content="#631D65" />
    <meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=11,IE=edge" />
    <meta name="description"
        content="Partner with Zoylee for your salon, spa & parlor business. It will enhance your brand visibility & help to grow your revenue.">
    <meta name="base_url" content="{{ URL('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Partner with US | Zoylee Business </title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}" sizes="16x16">

    <link rel="canonical" href="https://business.zoylee.com/">


    <link rel="stylesheet" href="{{ asset('business-lib/assets/css/font-style.css') }}">
    <link rel="stylesheet" href="{{ asset('business-lib/assets/icons/css/all.min.css') }}">
    <link href="{{ asset('business-lib/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('business-lib/assets/css/floating.css') }}">
    {{-- <link rel="stylesheet" href="{{asset('business-lib/assets/css/animate.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('business-lib/assets/css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <link href="{{ asset('css/toastr.css')}}" rel="stylesheet"> --}}

    @yield('styles')
    <style>
        .swal2-popup {
            max-width: 300px !important;
        }
    </style>
</head>

<body class="">

    <header id="Header">
        <nav class="navbar navbar-white bg-white shadow"
            style=" background-image: linear-gradient(to right, black,rgba(0, 0, 0, 0.801));" data-wow-duration="1s"
            data-wow-delay="1s">
            <div class="container px-0  my-0 py-0">
                {{-- style="position: fixed;top:0px;background: rgba(255, 255, 255, 0.753)" --}}
                <a class="navbar-brand  py-0 my-0" href="{{ route('index') }}" id="logo">
                    <img src="{{ asset('logo.svg') }}" alt="logo" height="50">
                </a>
                <span>
                    @if (Auth::guard('business')->check())
                        {{-- {!! Auth::guard('business')->user()->vendor_profile->business_name ?? "<a href='/business/sign-up' >Register</a>" !!} --}}
                        <a class="btn btn-danger ml-4" title="Logout" href="{{ route('business.logout') }}">
                            <i class="fas fa-sign-out-alt  f-120 "></i>
                        </a>
                    @else
                        {{-- <strong class="cursor-pointer d-lg-none text-white"  data-toggle="modal" data-target="#loginModal">Login</strong> --}}
                        <strong class="cursor-pointer d-lg-none text-white login-modal-btn">Login</strong>
                    @endif
                </span>
            </div>
        </nav>
    </header>



    @section('content')

    @show




    <footer class="pt-5 pb-5" id="footer">
        <div class="container">
            <div class="row footer">
                <div class=" col-lg-3 col-md-3  col-sm-6 col-12 mt-2">
                    <h5>COMPANY</h5>
                    <ul>
                        <li><a href="https://www.zoylee.com/about-us">About Us</a></li>
                        {{-- <li><a href="">Careers</a></li> --}}
                        {{-- <li><a href="">Blog</a></li> --}}
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12 mt-2">
                    <h5>CONTACT</h5>
                    <ul>
                        <li><a href="https://www.zoylee.com/contact-us">Contact Us</a></li>
                        {{-- <li><a href="{{route('support')}}">Help and Support</a></li> --}}
                        <li><a href="https://business.zoylee.com">Partner With Us</a></li>
                        <li><a href="{{ route('artist.register') }}">Artist Signup</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12 mt-2">
                    <h5>LEGAL</h5>
                    <ul>
                        <li><a href="https://www.zoylee.com/terms-and-conditions">Terms and Conditions</a></li>
                        <li><a href="https://www.zoylee.com/cancellation-and-refund">Refund and Cancellation</a></li>
                        {{-- <li><a href="">User Acceptance Policy</a></li> --}}
                        <li><a href="https://www.zoylee.com/privacy-policy">Privacy Policy</a></li>
                        <li><a href="https://www.zoylee.com/cookie-policy">Cookie Policy</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12 my-2" style="line-height:2">
                    <a target="blank" href="https://apps.apple.com/us/app/zoylee-business/id1529111896"
                        class="btn"><img src="{{ cdn('assets/images/ios_icon.png') }}" class="img-fluid"></a>
                    <a target="blank" href="https://play.google.com/store/apps/details?id=com.zoylee_business"
                        class="btn"><img src="{{ cdn('assets/images/android_icon.png') }}" class="img-fluid"></a>
                </div>
            </div>
        </div>
    </footer>


    <footer id="footer2">
        <div class="py-2" style="background:#333333;color:#808080">
            <div class="col-md text-center">Copyright © {{ date('Y') }} <a href="https://www.zoylee.com"
                    target="blank">Zoylee</a> All Rights Reserved.</div>
        </div>
    </footer>


    <!--Overlay-->
    <div class="overlay" style="display: none" id="overlay" onclick="off()"></div>
    <!--End Overlay-->

    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-body-login">

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>





    <script src="{{ asset('business-lib/assets/js/jquery.js') }}"></script>
    <script src="{{ asset('business-lib/assets/js/bootstrap.min.js') }}"></script>
    {{-- <script src="{{asset('business-lib/assets/js/bootstrap.bundle.min.js')}}"></script> --}}
    {{-- <script src="{{asset('business-lib/assets/icons/js/fontawesome.min.js')}}"></script> --}}
    {{-- <script src="{{asset('business-lib/assets/js/wow.min.js')}}"></script> --}}
    {{-- <script src="{{asset('business-lib/assets/js/scripts.js')}}"></script> --}}
    <script src="{{ asset('js/validation.js') }}"></script>
    {{-- <script src="{{asset('js/toastr.min.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".dropdown-toggle").dropdown();
        });

        $('.header-search-btn').click(function() {
            $('#header-search-bar').addClass('wow slideInUp animated');
            $('#header-search-bar').show();
        });
        $('#close-btn-modal-for-header').click(function() {
            $('#header-search-bar').removeClass('wow slideInUp animated');
            $('#header-search-bar').fadeOut(1000);
        });

        $(document).on('submit', '.business_login_form', function(e) {
            // e.preventDefault();
            if (grecaptcha.getResponse() == "") {
                e.preventDefault();
                $('#captchaErr').html("Please chacked I'm not a robot checkbox");
                $('.captchaErr').html("Please chacked I'm not a robot checkbox");
                // alert("You can't proceed!");
            } else {
                $.ajax({
                    type: "GET",
                    url: "{{ route('google.re.v2') }}",
                    data: {
                        token: grecaptcha.getResponse()
                    },
                    success: function(data) {
                        data = JSON.parse(data);
                        console.log(data);
                        console.log(data.success);
                        // $(this).submit();
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
        });
        $('.login-modal-btn').click(function() {
            $('.modal-body-login').html('');
            $('.modal-body-login').html($('.clone-signin-data').clone(true));
            $('#loginModal').modal('show');
        });
    </script>
    <script type="text/javascript">
        @if (Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: "{{ Session::get('success') }}",
                showConfirmButton: true,
                timer: 30000
            });
        @endif

        @if (Session::has('info'))
            Swal.fire({
                icon: 'info',
                title: "{{ Session::get('info') }}",
                showConfirmButton: true,
                timer: 30000
            });
        @endif

        @if (Session::has('warning'))
            Swal.fire({
                icon: 'warning',
                title: "{{ Session::get('warning') }}",
                showConfirmButton: true,
                timer: 30000
            });
        @endif

        @if (Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: "{{ Session::get('error') }}",
                showConfirmButton: true,
                timer: 30000
            });
        @endif

        @if ($errors->any())
            var msg = '';
            @foreach ($errors->all() as $err)
                msg += "{{ $err }}";
            @endforeach
            if ($('#pageName').val() !== 'no-show') {
                Swal.fire({
                    icon: 'error',
                    text: msg,
                    showConfirmButton: true,
                    timer: 30000
                });
            }
        @endif
    </script>
    @yield('scripts')

    <!--Begin Comm100 Live Chat Code-->
    <div id="comm100-button-62042cb3-c82e-49f1-85eb-52c53f2d325d"></div>
    <script type="text/javascript">
        var Comm100API = Comm100API || {};
        (function(t) {
            function e(e) {
                var a = document.createElement("script"),
                    c = document.getElementsByTagName("script")[0];
                a.type = "text/javascript", a.async = !0, a.src = e + t.site_id, c.parentNode.insertBefore(a, c)
            }
            t.chat_buttons = t.chat_buttons || [], t.chat_buttons.push({
                code_plan: "62042cb3-c82e-49f1-85eb-52c53f2d325d",
                div_id: "comm100-button-62042cb3-c82e-49f1-85eb-52c53f2d325d"
            }), t.site_id = 40001615, t.main_code_plan = "62042cb3-c82e-49f1-85eb-52c53f2d325d", e(
                "https://vue.comm100.com/livechat.ashx?siteId="), setTimeout(function() {
                t.loaded || e("https://standby.comm100vue.com/livechat.ashx?siteId=")
            }, 5e3)
        })(Comm100API || {})
    </script>
    <!--End Comm100 Live Chat Code-->

</body>

</html>

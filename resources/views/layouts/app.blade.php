<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Business Panel</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- ================== BEGIN core-css ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/default/app.min.css') }}" rel="stylesheet" />
    {{-- <link href="{{ asset('zoy-asset/css/bootstrap.min.css') }}" rel="stylesheet" /> --}}
    <!--=================== for toaster ================== -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!--=================== for toaster ================== -->

    @yield('styles')

</head>

<body>
    <!-- BEGIN #loader -->
    <div id="loader" class="app-loader">
        <span class="spinner"></span>
    </div>
    <!-- END #loader -->

    <!-- BEGIN #app -->
    <div id="app" class="app app-header-fixed app-sidebar-fixed">

        @include('layouts.includes.header')
        @include('layouts.includes.sidebar')

        @yield('content')


        <!-- BEGIN scroll-top-btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top"
            data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
        <!-- END scroll-top-btn -->
    </div>
    <!-- END #app -->
    @yield('scripts')


    <script>
        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>


    <!-- ================== BEGIN core-js ================== -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- ================== END core-js ================== -->

    <!-- ================== BEGIN page-js ================== -->
    <script src="{{ asset('assets/plugins/@highlightjs/cdn-assets/highlight.min.js') }}"></script>
    <script src="{{ asset('assets/js/demo/render.highlight.js') }}"></script>
    <!-- ================== END page-js ================== -->
     {{-- <script src="{{ asset('zoy-asset/js/jquery.js') }}"></script> --}}

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    {{-- <script src="{{ asset('zoy-asset/js/tether.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('zoy-asset/vendor/bluemoonNav/bluemoonNav.js') }}"></script> --}}
    {{-- <script src="{{ asset('zoy-asset/vendor/onoffcanvas/onoffcanvas.js') }}"></script> --}}
    {{-- <script src="{{ asset('zoy-asset/js/bootstrap.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('zoy-asset/js/moment.js') }}"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> --}}
    <!-- Slimscroll JS -->
    {{-- <script src="{{ asset('zoy-asset/vendor/slimscroll/slimscroll.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('zoy-asset/vendor/slimscroll/custom-scrollbar.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/lodash.js') }}"></script>
    <script src="{{ asset('js/validation.js') }}"></script> --}}


    <!-- Common JS -->
    {{-- <script src="{{ asset('zoy-asset/js/common.js') }}"></script> --}}
    {{-- <script src="{{ asset('business-lib/dashboard/autoload_notify.js') }}"></script> --}}
</body>

</html>

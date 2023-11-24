<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="Cache-control" content="public">
		<meta name="theme-color" content="#631D65" />
		<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=11,IE=edge" />
		<meta name="description" content="Zoylee Business">
		<meta name="base_url" content="{{URL('/')}}"/>
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>Zoylee | Business</title>
		<!-- Common CSS -->

		<link rel="stylesheet" href="{{asset('zoy-asset/css/bootstrap.min.css')}}" />
		<link rel="stylesheet" href="{{asset('zoy-asset/fonts/icomoon/icomoon.css')}}" />
		<link rel="stylesheet" href="{{asset('zoy-asset/css/main.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('zoy-asset/css/style.css')}}">
		<!-- Morris CSS -->
		<link rel="stylesheet" href="{{asset('zoy-asset/vendor/morris/morris.css')}}" />
		<link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}" sizes="16x16">
		@yield('styles')
		<style>
			a.logo img {
				max-width: 150px;
				max-height: 100px;
				margin: 0 auto;
			}
		</style>
	</head>
	<body>
		<input type="hidden" id="pusher_vendor_id" value="{{ Auth::guard('business')->user()->vendor_id ?? 'UnNamed' }}">
		<div id="app"></div>

		<!-- Loading starts -->
		<div id="loading-wrapper" style="display:none">
			<div id="loader">
				<div class="line1"></div>
				<div class="line2"></div>
				<div class="line3"></div>
				<div class="line4"></div>
				<div class="line5"></div>
				<div class="line6"></div>
			</div>
    	</div>

		<!-- BEGIN .app-wrap -->
		<div class="app-wrap">
			<!-- BEGIN .app-heading -->
			{{-- @include('business.layouts.head') --}}
			<!-- END: .app-heading -->

			<!-- BEGIN .app-container -->
			<div class="app-container">

				<!-- BEGIN .app-side -->
				{{-- @include('business.layouts.left-nav') --}}
				<!-- END: .app-side -->

				<!-- BEGIN .app-main -->
				<div class="app-main">
					@section('content')
					@show
				</div>
				<!-- END: .app-main -->
			</div>
			<!-- END: .app-container -->

    		<!-- BEGIN .main-footer -->
			<footer class="main-footer fixed-btm">
				Copyright Zoylee {{date('Y')}}.
			</footer>
			<!-- END: .main-footer -->
		</div>
		<!-- END: .app-wrap -->


		<div class="row fixed-top text-center" style="z-index:10000;background:rgba(0, 0, 0, 0.178)">
			<div class="col-sm show_notify_data px-1" style="overflow: auto;max-height: 500px;">
			</div>
		</div>
		<div class="modal user-auth-modal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
			  <div class="modal-content rounded-0">
				<div class="modal-header">
				  <h5 class="modal-title">User Authneticate</h5>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			  </div>
			</div>
		</div>

		<!-- jQuery first, then Tether, then other JS. -->
		<script src="{{asset('zoy-asset/js/jquery.js')}}"></script>

		<script src="{{asset('js/app.js')}}"></script>
		<script src="{{asset('zoy-asset/js/tether.min.js')}}"></script>
		<script src="{{asset('zoy-asset/vendor/bluemoonNav/bluemoonNav.js')}}"></script>
		<script src="{{asset('zoy-asset/vendor/onoffcanvas/onoffcanvas.js')}}"></script>
		<script src="{{asset('zoy-asset/js/bootstrap.min.js')}}"></script>
		<script src="{{asset('zoy-asset/js/moment.js')}}"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
		<!-- Slimscroll JS -->
		<script src="{{asset('zoy-asset/vendor/slimscroll/slimscroll.min.js')}}"></script>
		<script src="{{asset('zoy-asset/vendor/slimscroll/custom-scrollbar.js')}}"></script>
		<script src="{{asset('js/lodash.js')}}"></script>
		<script src="{{asset('js/validation.js')}}"></script>


		<!-- Common JS -->
		<script src="{{asset('zoy-asset/js/common.js')}}"></script>
		<script src="{{asset('business-lib/dashboard/autoload_notify.js')}}"></script>
		@include('business.layouts.common-notification')

		@yield('scripts')

	</body>
</html>

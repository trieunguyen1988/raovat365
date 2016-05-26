<!DOCTYPE html>
<!-- Template Name: Clip-Two - Responsive Admin Template build with Twitter Bootstrap 3.x | Author: ClipTheme -->
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>{{trans('common.SITE_NAME').' - '.$title}}</title>
		<!-- start: META -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="{!!URL::asset('vendor/bootstrap/css/bootstrap.min.css')!!}">
		<link rel="stylesheet" href="{!!URL::asset('vendor/fontawesome/css/font-awesome.min.css')!!}">
		<link rel="stylesheet" href="{!!URL::asset('vendor/themify-icons/themify-icons.min.css')!!}">
		<link href="{!!URL::asset('vendor/animate.css/animate.min.css')!!}" rel="stylesheet" media="screen">
		<link href="{!!URL::asset('vendor/perfect-scrollbar/perfect-scrollbar.min.css')!!}" rel="stylesheet" media="screen">
		<link href="{!!URL::asset('vendor/switchery/switchery.min.css')!!}" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="{!!URL::asset('assets/css/styles.css')!!}">
		<link rel="stylesheet" href="{!!URL::asset('assets/css/plugins.css')!!}">
		<link rel="stylesheet" href="{!!URL::asset('assets/css/themes/theme-1.css')!!}" id="skin_color" />
		<script src="{!!URL::asset('vendor/jquery/jquery.min.js')!!}"></script>
		<script src="{!!URL::asset('vendor/bootstrap/js/bootstrap.min.js')!!}"></script>
		<script src="{!!URL::asset('vendor/modernizr/modernizr.js')!!}"></script>
		<script src="{!!URL::asset('vendor/jquery-cookie/jquery.cookie.js')!!}"></script>
		<script src="{!!URL::asset('vendor/perfect-scrollbar/perfect-scrollbar.min.js')!!}"></script>
		<script src="{!!URL::asset('vendor/switchery/switchery.min.js')!!}"></script>
		<script src="{!!URL::asset('vendor/jquery-validation/jquery.validate.min.js')!!}"></script>
		<script src="{!!URL::asset('assets/js/main.js')!!}"></script>
        <script src="{!!URL::asset('vendor/autosize/autosize.min.js')!!}"></script>
        <script src="{!!URL::asset('vendor/selectFx/classie.js')!!}"></script>
        <script src="{!!URL::asset('vendor/selectFx/selectFx.js')!!}"></script>
        <!--<script src="{!!URL::asset('vendor/select2/select2.min.js')!!}"></script>-->
	</head>
	<!-- end: HEAD -->
    <body style="background-color: white;">
		<div id="app">
			<!-- sidebar -->
			<div class="sidebar app-aside" id="sidebar">
                @include('elements.sidebar')
			</div>
			<!-- / sidebar -->
			<div class="app-content">
				<!-- start: TOP NAVBAR -->
                    @include('elements.header')
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
                    @yield('content')
				</div>
			</div>
            @include('elements.footer')
		</div>
		<script>
			jQuery(document).ready(function() {
				Main.init();
			});
		</script>
	</body>
</html>

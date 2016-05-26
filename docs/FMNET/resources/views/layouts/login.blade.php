<!DOCTYPE html>
<html lang="en">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<!-- start: HEAD -->
	<head>
		<title>{{trans('common.SITE_NAME').' - '.$title}}</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link rel="stylesheet" href="{!!URL::asset('vendor/bootstrap/css/bootstrap.min.css')!!}">
		<link rel="stylesheet" href="{!!URL::asset('vendor/fontawesome/css/font-awesome.min.css')!!}">
		<link rel="stylesheet" href="{!!URL::asset('vendor/themify-icons/themify-icons.min.css')!!}">
		<link href="{!!URL::asset('vendor/animate.css/animate.min.css')!!}" rel="stylesheet" media="screen">
		<link href="{!!URL::asset('vendor/perfect-scrollbar/perfect-scrollbar.min.css')!!}" rel="stylesheet" media="screen">
		<link href="{!!URL::asset('vendor/switchery/switchery.min.css')!!}" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="{!!URL::asset('assets/css/styles.css')!!}">
		<link rel="stylesheet" href="{!!URL::asset('assets/css/plugins.css')!!}">
		<link rel="stylesheet" href="{!!URL::asset('assets/css/themes/theme-1.css')!!}" id="skin_color" />
	</head>
	<body class="login">
        @yield('content')
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="{!!URL::asset('vendor/jquery/jquery.min.js')!!}"></script>
		<script src="{!!URL::asset('vendor/bootstrap/js/bootstrap.min.js')!!}"></script>
		<script src="{!!URL::asset('vendor/modernizr/modernizr.js')!!}"></script>
		<script src="{!!URL::asset('vendor/jquery-cookie/jquery.cookie.js')!!}"></script>
		<script src="{!!URL::asset('vendor/perfect-scrollbar/perfect-scrollbar.min.js')!!}"></script>
		<script src="{!!URL::asset('vendor/switchery/switchery.min.js')!!}"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="{!!URL::asset('vendor/jquery-validation/jquery.validate.min.js')!!}"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="{!!URL::asset('vendor/jquery/jquery.min.js')!!}"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="{!!URL::asset('assets/js/login.js')!!}"></script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
	<!-- end: BODY -->
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('pagetitle')</title>
    <!--Meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="@yield('pagedescription')">
    <meta name="description" content="@yield('pagedescription')">

    <meta name="theme-color" content="#ffffff">
	
	<link href="{{ URL::asset('public/backend/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
	<link href="{{ URL::asset('public/backend/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" media="screen">
	<link href="{{ URL::asset('public/backend/assets/styles.css') }}" rel="stylesheet" media="screen">
	<link href="{{ URL::asset('public/backend/assets/DT_bootstrap.css') }}" rel="stylesheet" media="screen">
	<link rel="shortcut icon" type="image/png" href="{{ URL::asset('public/backend/images/favicon.png') }}"/>

	<script src="{{ URL::asset('vendors/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
	
    @yield('stylesheets')

</head>
<body id="login">
	
	@yield('content')		
	
	<!--Start Scripts-->
	<script src="{{ URL::asset('public/backend/vendors/jquery-1.9.1.js') }}"></script>
	<script src="{{ URL::asset('public/backend/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ URL::asset('public/backend/vendors/datatables/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('public/backend/assets/scripts.js') }}"></script>
	<script src="{{ URL::asset('public/backend/assets/DT_bootstrap.js') }}"></script>

    @yield('scripts')
	
</body>
</html>
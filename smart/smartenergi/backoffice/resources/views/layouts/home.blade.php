<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('pagetitle')</title>
    <!--Meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="@yield('pagedescription')">
    <meta name="description" content="@yield('pagedescription')">

    <link rel="apple-touch-icon" sizes="144x144" href="{{ URL::asset('public/frontend/images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ URL::asset('public/frontend/images/favicons/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ URL::asset('public/frontend/images/favicons/favicon-16x16.png') }}" sizes="16x16">
    <link rel="manifest" href="{{ URL::asset('public/frontend/images/favicons/manifest.json') }}">
    <link rel="mask-icon" href="{{ URL::asset('public/frontend/images/favicons/safari-pinned-tab.svg') }}" >
    <meta name="theme-color" content="#ffffff">

    <link href="{{ URL::asset('public/frontend/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/frontend/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/frontend/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/frontend/css/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/frontend/css/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ URL::asset('public/frontend/css/vegas.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/frontend/css/styles.css') }}" rel="stylesheet" type="text/css" />

</head>
<body>
	
	@include('layouts.partials.login')
	
	@yield('content')

    <!--Start Scripts-->
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/jquery.js') }}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('constants.googlemapapikey') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/modernizr.custom.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/jquery.matchHeight-min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/isotope.pkgd.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/jquery.nicescroll.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/vegas.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/infobox.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/markerclusterer.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/custom.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/frontend/js/jquery.form.min.js') }}"></script>
    <script>
	jQuery(document).ready( function($) {
		$(".splash-inner-media").vegas({
			overlay: true,
			slides: [
				{
					src: '{{ URL::asset("public/frontend/images/pexels-photo-243722.jpeg") }}',
					video: {
						src: [
							'{{ URL::asset("public/frontend/videos/houzez-video.mp4") }}',
							'{{ URL::asset("public/frontend/videos/houzez-video.webm") }}',
							'{{ URL::asset("public/frontend/videos/houzez-video.ogv") }}'
						],
						loop: true,
						mute: true
					}
				}
			]
		});
	});
    </script>
	
	@yield('scripts')
	
</body>
</html>
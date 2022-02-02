<!DOCTYPE html>
<html>
    
    <head>
        <title>@yield('pagetitle')</title>
        <meta name="description" content="@yield('pagedescription')">
        <!-- Bootstrap -->
        <link href="{{ URL::asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
        <link href="{{ URL::asset('bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" media="screen">
        <link href="{{ URL::asset('assets/styles.css') }}" rel="stylesheet" media="screen">
        <link href="{{ URL::asset('assets/DT_bootstrap.css') }}" rel="stylesheet" media="screen">

        <script src="{{ URL::asset('vendors/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
		
		@yield('stylesheets')
		
    </head>
    
    <body>
        
		@if( Route::currentRouteName() != 'login' )
		
			@include('layouts.admin.partials.toplinks')
		
		@endif
		
		<div class="container-fluid">
            <div class="row-fluid">
                
                <div class="span12" id="content">
                    
					@yield('content')
                     
                </div>
            </div>
            <hr>            
			
			@include('layouts.admin.partials.footer')
			
        </div>
        <!--/.fluid-container-->

        <script src="{{ URL::asset('vendors/jquery-1.9.1.js') }}"></script>
        <script src="{{ URL::asset('bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('vendors/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::asset('assets/scripts.js') }}"></script>
        <script src="{{ URL::asset('assets/DT_bootstrap.js') }}"></script>
		
		@yield('scripts')
       
		
    </body>

</html>
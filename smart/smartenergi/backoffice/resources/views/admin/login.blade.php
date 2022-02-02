@extends('layouts.admin.login')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	@php

	$flashdata = Session::get('action');
	
	@endphp
	
	
	<div class="container">
		
		<img src="{{URL::asset('public/backend/images/logo_black.png')}}" class="logo">
		
		<form class="form-signin" name="frmaddedit" action="{{ URL::route('adminlogin') }}" method="post">
			
			@if($flashdata == 'invalid')
			
				<div class="alert alert-danger">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Failed!</strong> Invalid Username or Password
				</div>

			@endif
			
			<h2 class="form-signin-heading">{{ $sectionname }}</h2>		

			<input type="hidden" name="act" value="dologin">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			
			<input type="text" class="input-block-level" placeholder="Username" id="username" name="username" autocomplete="off">
			
			<input type="password" class="input-block-level" placeholder="Password" id="password" name="password" autocomplete="off">
			
			<button class="btn btn-large btn-primary" type="submit">Sign in</button>
			
			<div style="margin:30px 0 0 0; text-align:center;">&copy; {{ config('constants.project_name') }} {{ date('Y') }}</div>
			
		</form>

    </div>

@stop


@section('stylesheets')
	<link href="{{ URL::asset('public/backend/vendors/uniform.default.css') }}" rel="stylesheet" media="screen">
	<link href="{{ URL::asset('public/backend/vendors/chosen.min.css') }}" rel="stylesheet" media="screen">
@stop

@section('scripts')
	<script src="{{ URL::asset('public/backend/vendors/jquery.uniform.min.js') }}"></script>
	<script src="{{ URL::asset('public/backend/vendors/chosen.jquery.min.js') }}"></script>
	
	<script>
		
	$(function() {
		$(".uniform_on").uniform();
		$(".chzn-select").chosen();
		var now = new Date();
now.setTime(now.getTime()+(-1*24*60*60*1000));
var expires = "=;"+" path=/; expires="+now.toUTCString();
document.cookie = "lastpage"+expires;
	});
		
	</script>
@stop
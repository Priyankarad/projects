@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	<div class="row-fluid">
		<!-- block -->
		
		{{--*/ 

		$flashdata = Session::get('action');
		
		/*--}}
		
		@if($flashdata == 'invalid')
			
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">×</button>
				<strong>Failed!</strong> Invalid Username or Password
			</div>
		
		@endif
		
		<!-- block -->
		<div class="block">
		
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">{{ $sectionname }}</div>
			</div>
			
			<div class="block-content collapse in">
				<div class="span4" style="margin:0 auto; float:none">
					<form class="form-horizontal" name="frmaddedit" action="{{ URL::route('login') }}" method="post">
					  <input type="hidden" name="act" value="dologin">
					  <input type="hidden" name="_token" value="{{ csrf_token() }}">
					  <fieldset>
												
						<div class="control-group">
						  <label class="control-label" for="username">Username </label>
						  <div class="controls">
							<input type="text" class="span6" id="username" name="username" required value="">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="password">Password </label>
						  <div class="controls">
							<input type="password" class="span6" id="password" name="password" required value="">
						  </div>
						</div>
						
						<div class="form-actions">
						  <button type="submit" class="btn btn-primary">Login</button>
						</div>
						
					  </fieldset>
					</form>

				</div>
			</div>
			
		</div>
		<!-- /block -->
	</div>

@stop


@section('stylesheets')
	<link href="{{ URL::asset('vendors/uniform.default.css') }}" rel="stylesheet" media="screen">
	<link href="{{ URL::asset('vendors/chosen.min.css') }}" rel="stylesheet" media="screen">
@stop

@section('scripts')
	<script src="{{ URL::asset('vendors/jquery.uniform.min.js') }}"></script>
	<script src="{{ URL::asset('vendors/chosen.jquery.min.js') }}"></script>
	
	<script>
		
	$(function() {
		$(".uniform_on").uniform();
		$(".chzn-select").chosen();
	});
		
	</script>
@stop
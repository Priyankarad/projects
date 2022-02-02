@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')	
	
	<div class="row-fluid">
		<!-- block -->
		
		@php

		$flashdata = Session::get('action');
		
		@endphp
		
		@if($flashdata == 'updated')
		
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">×</button>
				<strong>Success!</strong> Password changed successfully
			</div>
		
		@endif

		<!-- block -->
		<div class="block">
		
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">🔑 {{ $sectionname }}</div>
			</div>
			
			<div class="block-content collapse in">
				<div class="span12">
					
				    @if(count($errors))
			
						<div class="alert alert-error alert-block">
							
							<ul>
								
								@foreach($errors as $error)
								
									<li>{{$error}}</li>
								
								@endforeach
								
							</ul>
							
						</div>
					
					@endif
					
					<form class="form-horizontal" name="frmaddedit" action="{{ URL::route('adminchangepassword') }}" method="post" enctype="multipart/form-data">
					  <input type="hidden" name="act" value="changepassword">
					  <input type="hidden" name="_token" value="{{ csrf_token() }}">
					  <fieldset>
					  
						<div class="control-group">
						  <label class="control-label" for="oldpass">Old Password </label>
						  <div class="controls">
							<input type="password" class="span6" name="oldpass" id="oldpass" value="">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="newpass">New Password </label>
						  <div class="controls">
							<input type="password" class="span6" name="newpass" id="newpass" value="">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="conpass">Confirm Password </label>
						  <div class="controls">
							<input type="password" class="span6" name="conpass" id="conpass" value="">
						  </div>
						</div>
						
						<div class="form-actions">
						  <button type="submit" class="btn btn-primary">Change</button>
						  <button type="reset" class="btn" onclick="location.href='{{ URL::route('admindashboard') }}'">Cancel</button>
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
	<link href="{{ URL::asset('public/backend/vendors/uniform.default.css') }}" rel="stylesheet" media="screen">
	<link href="{{ URL::asset('public/backend/vendors/chosen.min.css') }}" rel="stylesheet" media="screen">
@stop

@section('scripts')
	<script src="{{ URL::asset('public/backend/vendors/jquery.uniform.min.js') }}"></script>
	<script src="{{ URL::asset('public/backend/vendors/chosen.jquery.min.js') }}"></script>
@stop
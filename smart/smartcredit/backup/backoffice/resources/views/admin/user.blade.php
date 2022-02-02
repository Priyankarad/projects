@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	@if ($mode == '')		
	
	<div class="row-fluid">
		<!-- block -->
		
		{{--*/ 

		$flashdata = Session::get('action');
		
		/*--}}
		
		@if($flashdata == 'added')
			
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">×</button>
				<strong>Success!</strong> Record added successfully
			</div>
			
		@elseif($flashdata == 'updated')
		
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">×</button>
				<strong>Success!</strong> Record updated successfully
			</div>
			
		@elseif($flashdata == 'deleted')
		
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">×</button>
				<strong>Success!</strong> Record(s) deleted successfully
			</div>
		
		@endif
		
		<div class="block">
		
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">{{ ucfirst($mode).' '.$sectionname }}</div>
			</div>
			
			<div class="block-content collapse in">
			
				<div class="span12">
				   <div class="table-toolbar">
					  <div class="btn-group">
						 <a href="{{ URL::route('adminuser', array('mode'=>'add')) }}"><button class="btn btn-success">Add New <i class="icon-plus icon-white"></i></button></a>
					  </div>
					  <div class="btn-group pull-right">
						 <button data-toggle="dropdown" class="btn dropdown-toggle">Tools <span class="caret"></span></button>
						 <ul class="dropdown-menu">
							<li><a href="#">Print</a></li>
							<li><a href="#">Save as PDF</a></li>
							<li><a href="#">Export to Excel</a></li>
						 </ul>
					  </div>
				   </div>
					
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Username</th>
								<th>Password</th>
								<th>Active</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							
							@if (count($records) > 0)
								
								{{--*/ $sl = 1 /*--}}
								
								@foreach($records as $data)
									
									<tr class="odd gradeX">
										<td>{{$sl}}</td>
										<td>{{$data->name}}</td>
										<td>{{$data->username}}</td>
										<td>{{$data->password}}</td>
										<td class="center">{{$data->active}}</td>
										<td class="center">
											<a href="{{ URL::route('adminuser', array('mode'=>'edit','id'=>$data->id)) }}"><button class="btn btn-warning">Edit</button></a>
											<a href="{{ URL::route('adminuser', array('mode'=>'delete','id'=>$data->id)) }}" class="delclass"><button class="btn btn-danger">Delete</button></a>
										</td>
									</tr>
									
									{{--*/ $sl++ /*--}}
								
								@endforeach
							
							@endif
							
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
		<!-- /block -->
		
	</div>
	
	@elseif ($mode == 'add' || $mode == 'edit')
	
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
		
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">{{ $sectionname }}</div>
			</div>
			
			<div class="block-content collapse in">
				<div class="span12">
					<form class="form-horizontal" name="frmaddedit" action="{{ URL::route('adminuser') }}" method="post">
					  <input type="hidden" name="act" value="do{{$mode}}">
					  <input type="hidden" name="id" value="{{$id}}">
					  <input type="hidden" name="_token" value="{{ csrf_token() }}">
					  <fieldset>
						<legend>{{ ucfirst($mode).' '.$sectionname }}</legend>
						
						<div class="control-group">
						  <label class="control-label" for="studname">Name </label>
						  <div class="controls">
							<input type="text" class="span6" name="studname" id="studname" required value="{{$recorddetails->name or ''}}">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="username">Username </label>
						  <div class="controls">
							<input type="text" class="span6" id="username" name="username" required value="{{$recorddetails->username or ''}}">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="password">Password </label>
						  <div class="controls">
							<input type="text" class="span6" id="password" name="password" required value="{{$recorddetails->password or ''}}">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="active">Active</label>
						  <div class="controls">
							<select id="active" class="chzn-select" required name="active">
							  <option value="Yes" {{ isset($recorddetails) ? ($recorddetails->active == 'Yes' ? 'selected' : '') : '' }} >Yes</option>
							  <option value="No" {{ isset($recorddetails) ? ($recorddetails->active == 'No' ? 'selected' : '') : '' }} >No</option>
							</select>
						  </div>
						</div>
						
						<div class="form-actions">
						  <button type="submit" class="btn btn-primary">{{ $mode == 'add' ? 'Add' : 'Update' }}</button>
						  <button type="reset" class="btn" onclick="location.href='{{ URL::route('adminuser') }}'">Cancel</button>
						</div>
						
					  </fieldset>
					</form>

				</div>
			</div>
			
		</div>
		<!-- /block -->
	</div>
	
	@endif
	

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
	
	$(document).ready(function(){
		
		$('.delclass').click(function(e){
			
			e.preventDefault();
			
			var cnf = confirm("Are you sure?");
			var redirectto = $(this).attr('href');
			
			if(cnf){
				location.href = redirectto;
			}
		});
		
	});
		
	</script>
@stop
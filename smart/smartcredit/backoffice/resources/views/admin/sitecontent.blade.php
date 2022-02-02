@extends('layouts.admin.master')
@section('content')
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			@if ($id != '')		
			{{--*/ 
				$englishName=trim(stripslashes($records[0]->term_english));
				$spanishName=trim(stripslashes($records[0]->term_spanish));
			/*--}}
			<div class="block-content collapse in">
				<div class="span12">
			<form class="form-horizontal" name="" action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="term_id" value="{{$id}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="control-group">
						  <label class="control-label" for="term_name">Term Name</label>
						  <div class="controls">
							{{$records[0]->term or ''}}
						  </div>
						</div>
				<div class="control-group">
						  <label class="control-label" for="term_english">Term English Name</label>
						  <div class="controls">
							<input type="text" class="span6" name="term_english" id="term_english" value="{{$englishName or ''}}">
						  </div>
						</div>
				<div class="control-group">
						  <label class="control-label" for="term_spanish">Term Spanish Name</label>
						  <div class="controls">
							<input type="text" class="span6" name="term_spanish" id="term_spanish" value="{{$spanishName or ''}}">
						  </div>
						</div>	
				<div class="form-actions">
							<input type="submit" class="btn btn-primary" name="doedit" value="Update">
							
						</div>				

			</form>
			</div>
			@else
				<div class="span12">
				   <div class="table-toolbar">
					  
					  <div class="btn-group pull-right">
						 
						 <span style="font-size:15px; vertical-align:middle">Jump to:</span>
							<select style="margin-bottom:0; width:56px;" class="jumptopage">
							
							<?php
							for($i=1;$i<=$records->lastPage();$i++){
									
								?>
								<option value="{{$i}}" {{ $currentPage == $i ? 'selected' : '' }}>{{ $i }}</option>
								<?php
							}
							?>
							
						 </select>
						 
					  </div>
				   </div>
					
					<form class="form-horizontal" name="frmlisting" id="frmlisting" action="#" method="post" enctype="multipart/form-data">
					    
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
							<thead>
								<tr>
									<th>#</th>
									<th>Term Name</th>
									<th>English Name</th>
									<th>Spanish Name</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								
								@if (count($records) > 0)
									
									{{--*/ 
										
										$sl = $currentPage == 1 ? 1 : ($currentPage*$per_page-$per_page)+1; 
										
									/*--}}
									
									@foreach($records as $data)
										
										{{--*/
										$id = $data->id;
										/*--}}
										
										<tr class="odd gradeX">
											<td>{{$sl}}</td>
											<td>{{$data->term}}</td>
											<td>{{trim(stripslashes($data->term_english))}}</td>
											<td>{{trim(stripslashes($data->term_spanish))}}</td>
											<td><a href="{{ URL::route('siteContent', array('id'=>$id)) }}">Edit</a></td>
											
										</tr>
										
										{{--*/ $sl++ /*--}}
									
									@endforeach
									
									@else
										
									<tr class="odd gradeX">
										<td colspan="12">No Record(s)</td>
									</tr>
								
								@endif
								
							</tbody>
						</table>
						
					</form>
					
				</div>
				
				<div class="span12">
					
					<div class="dataTables_wrapper form-inline">
						<div class="row">
							<div class="span12">
								@include('pagination.admin.default', ['paginator' => $records, 'link_limit' => 5])
							</div>							
						</div>
					</div>
					
				</div>
				@endif
			</div>
		</div>
		<!-- /block -->
		
	</div>
@stop


@section('stylesheets')
	<link href="{{ URL::asset('public/backend/vendors/uniform.default.css') }}" rel="stylesheet" media="screen">
	<link href="{{ URL::asset('public/backend/vendors/chosen.min.css') }}" rel="stylesheet" media="screen">
@stop
@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	@if ($mode == '')		
	
	<div class="row-fluid">
		<!-- block -->
		
		@php 

		$flashdata = Session::get('action');
		
		switch($type){
			
			case "pending":
				$badgeclass = "badge-warning";
				break;
			case "approved":
				$badgeclass = "badge-success";
				break;
			case "rejected":
				$badgeclass = "badge-important";
				break;
			case "closed":
				$badgeclass = "badge-primary";
				break;
			
		}
		
		@endphp
		
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
				<div class="muted pull-left"><span class="badge {{$badgeclass}}">{{ $totcount }}</span> {{ ucfirst($type).' '.$sectionname }}</div>
				<div class="muted pull-right"> Total Count: <strong>{{ $totcount }}</strong></div>
			</div>
			
			<div class="block-content collapse in">
			
				<div class="span12">
				   <div class="table-toolbar">
				   	@if($loggedinadminid==1)
					  <div class="btn-group">
						 
						 <a href="{{ URL::route('adminlender', array('mode'=>'add','id'=>'','type'=>$type)) }}"><button class="btn btn-success">Add New <i class="icon-plus icon-white"></i></button></a>
						 
						 {{{--<a href="javascript:void(0);" style="margin-left:10px"><button class="btn btn-danger" class="truncatedb" onclick="truncate()">Truncate Database</button></a>--}}}
					  </div>
					  @endif
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
						 @if($loggedinadminid==1)
						 <button data-toggle="dropdown" class="btn dropdown-toggle">Tools <span class="caret"></span></button>
						 <ul class="dropdown-menu">
							<li><a href="javascript:void(0);" onclick="delsel()">Delete Selected</a></li>
						 </ul>
						 @endif
					  </div>
				   </div>
					@if($loggedinadminid==1)
					<form class="form-horizontal" name="frmlisting" id="frmlisting" action="#" method="post" enctype="multipart/form-data">
					 @endif   
						<input type="hidden" name="act" value="">
						<input type="hidden" name="type" value="{{$type}}">
					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
					  
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
							<thead>
								<tr>
									@if($loggedinadminid==1)
									<th><label class="uniform"><input type="checkbox" class="uniform_on" value="" id="check-all" ></label></th>
									@endif
									<th>#</th>
									<th>Lender Name</th>
									<th>Email</th>
									<th>Mobile</th>
									<th>Automatic Investment</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								
								@if (count($records) > 0)
									
									@php
										
										$sl = $currentPage == 1 ? 1 : ($currentPage*$per_page-$per_page)+1; 
										
									@endphp
									
									@foreach($records as $data)
										
										@php
											
										$id = $data->id;
										$email = $data->email;
										$lender_name = $data->lender_name;
										$mobile_no = $data->mobile_no;

										@endphp

										@if($data->invest_automatically==0)
											@php
										  		$invest_automatically="No";
										  	@endphp
										@else
											@php
										   		$invest_automatically="Yes" ;
										    @endphp
										@endif
										@php
										
										$status = $data->status;
										
										switch($status){
											
											case "pending":
												$statusclass = 'label-warning';
												break;
											case "approved":
												$statusclass = 'label-success';
												break;
											
										}
										
										@endphp
										
										<tr class="odd gradeX">
											@if($loggedinadminid==1)
											<td><label class="uniform"><input type="checkbox" value="{{$data->id}}" name="chk_id[]" class="chkall uniform_on"></label></td>
											@endif
											<td>{{$sl}}</td>
											<td>{{$lender_name}}</td>
											<td>{{$email}}</td>
											<td>{{$mobile_no}}</td>
											<td>{{$invest_automatically}}</td>
											<td class="center"><span class="label {{$statusclass}}">{{ucfirst($status)}}</td>

											
											<td class="center">
												@if($loggedinadminid==1)	
												<a href="{{ URL::route('adminlender',array('id'=>$id, 'mode'=>'edit', 'type'=>$type)) }}"><input type="button" value="Edit" class="btn btn-warning"></a>
												
												<a href="{{ URL::route('adminlender',array('id'=>$id, 'mode'=>'delete', 'type'=>$type)) }}" class="delclass"><input type="button" value="Delete" class="btn btn-danger"></a>
												@else
												<a href="{{ URL::route('adminlender',array('id'=>$id, 'mode'=>'edit', 'type'=>$type)) }}"><input type="button" value="View" class="btn btn-warning"></a>
												@endif
											</td>
											
										</tr>
										
										@php $sl++ @endphp
									
									@endforeach
									
									@else
										
									<tr class="odd gradeX">
										<td colspan="12">No Record(s)</td>
									</tr>
								
								@endif
								
							</tbody>
						</table>
					@if($loggedinadminid==1)	
					</form>
					@endif
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
				
			</div>
		</div>
		<!-- /block -->
		
	</div>
	
	
	@else
		
	
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
		
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">{{ $sectionname }}</div>
			</div>
			
			<div class="block-content collapse in">
				<div class="span12">
					@php 
					$flashdata = Session::get('action');
					@endphp

					@if($flashdata == 'error')
		
						<div class="alert alert-error">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Error !</strong> {{ Session::get('errorMsg') }}
						</div>	
					
					@endif

					@if(count($errors))
			
						<div class="alert alert-error alert-block">
							
							<ul>
								
								@foreach($errors as $error)
								
									<li>{{$error}}</li>
								
								@endforeach
								
							</ul>
							
						</div>
					
					@endif
					@if($loggedinadminid==1)

					<form class="form-horizontal" name="frmaddedit" action="" method="post" enctype="multipart/form-data">
						@else
						<div class="form-horizontal">
					@endif
					  <input type="hidden" name="act" value="do{{$mode}}">
					  <input type="hidden" name="id" value="{{$id}}">
					  <input type="hidden" name="_token" value="{{ csrf_token() }}">
					  
					  <fieldset>
					  	@if($loggedinadminid==1)
						<legend>{{ ucfirst($mode).' '.$sectionname }}</legend>
							@endif
						
						<div class="control-group">
						  <label class="control-label" for="email">Email</label>
						  <div class="controls">
							<input type="text" class="span6" name="email" id="email" value="{{$recorddetails->email or ''}}">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="password">Password</label>
						  <div class="controls">
							<input type="password" class="span6" name="password" id="password" value="">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="lender_name">Lender Name</label>
						  <div class="controls">
							<input type="text" class="span6" name="lender_name" id="lender_name" value="{{$recorddetails->lender_name or ''}}">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="mobile_no">Mobile Number</label>
						  <div class="controls">
							<input type="text" class="span6" name="mobile_no" id="mobile_no" value="{{$recorddetails->mobile_no or ''}}">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="mobile_no">Date Of Birth</label>
						  <div class="controls">
							<select id="birth_day" name="birth_day" class="date_sel" >
			               	<option value="">Day</option>
			               	@if(isset($recorddetails->dob))
			               	@php										
									$spiltVal=	explode('/', $recorddetails->dob);
									@endphp
									@endif
			                @if(count($monthdates) > 0)
			               	   @foreach($monthdates as $datekey=>$datenumber)			               	      
                                  <option {{ !empty($spiltVal[0]) ? ($spiltVal[0] == $datenumber ? 'selected' : '') : (isset($recorddetails->birth_day) && ($recorddetails->birth_day==$datenumber)  ? 'selected' : '' ) }} value="{{ $datenumber }}">{{ $datenumber }}</option>
			               	   @endforeach
			               	@endif
			               	
			               </select>

			               <select id="birth_month" name="birth_month" class="date_sel" >
			               	<option value="">Month</option>			               	
			               	@if(count($monthlist) > 0)
			               	   @foreach($monthlist as $monthkey=>$monthname)
                                  <option {{ !empty($spiltVal[1]) ? ($spiltVal[1] == $monthkey ? 'selected' : '') : (isset($recorddetails->birth_month) && ($recorddetails->birth_month==$monthkey)  ? 'selected' : '' ) }} value="{{ $monthkey }}">{{ $monthname }}</option>
			               	   @endforeach
			               	@endif  

			               </select>
			               <select id="birth_year" name="birth_year" class="date_sel" >
			               	<option value="">Year</option>
			               	@if(count($yearlist) > 0)
			               	   @foreach($yearlist as $list)
                                  <option {{ !empty($spiltVal[2]) ? ($spiltVal[2] == $list ? 'selected' : '') : (isset($recorddetails->birth_year) && ($recorddetails->birth_year==$list)  ? 'selected' : '' ) }} value="{{ $list }}">{{ $list }}</option>
			               	   @endforeach
			               	@endif
			               	
			               </select> 
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="gender">Gender</label>
						  <div class="controls">
						  	<label class="radio-inline" for="Smale">
						  		<input type="radio" name="gender" value="male" id="Smale" {{ isset($recorddetails->gender) ? ("male" == $recorddetails->gender ? 'checked' : '') : '' }}>Male
						    </label>
						    <label class="radio-inline" for="SFemale">
						  		<input type="radio" name="gender" value="female" id="SFemale" {{ isset($recorddetails->gender) ? ("female" == $recorddetails->gender ? 'checked' : '') : '' }}>Female
						    </label>
				</div>
						</div>

						<div class="control-group">
						  	<label class="control-label" for="dninie">DNI/NIEr</label>
						  	<div class="controls">
						  		<select name="dninie" id="dninie">
									<option value="">Select Type</option>
									<option {{ isset($recorddetails->dninie) ? ("dni" == $recorddetails->dninie ? 'selected' : '') : '' }} value="dni">DNI</option>
									<option {{ isset($recorddetails->dninie) ? ("nie" == $recorddetails->dninie ? 'selected' : '') : '' }} value="nie">NIE</option>					
								</select>
							</div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="nationalid">National ID Number</label>
						  <div class="controls">
						<input type="text" id="nationalid" name="nat_id_num" placeholder="National ID Number" value="{{$recorddetails->nat_id_num or ''}}">
				</div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="country_of_residence">Country of Residence</label>
						  <div class="controls">
						<select id="country_of_residence" name="country_of_residence" >
			               	<option value="">Country of Residence</option>
			               	@if(count($countriesData) > 0)
			               	    @foreach($countriesData as $values)
<option value="{{ $values->code }}" {{ isset($recorddetails->country_of_residence) ? ($values->code == $recorddetails->country_of_residence ? 'selected' : '') : '' }}>{{ $values->name }}</option>
			               	    @endforeach
			               	@endif    
			               	
			               </select>
				</div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="address">Address</label>
						  <div class="controls">
						<input type="text" id="address" name="address"  placeholder="Address" value="{{$recorddetails->address or ''}}">
				</div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="city">City</label>
						  <div class="controls">
						<input type="text" value="{{$recorddetails->city or ''}}" id="city" name="city" placeholder="City" />
				</div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="postal_code">Postal code</label>
						  <div class="controls">
						<input value="{{$recorddetails->postal_code or ''}}" type="text" id="postal_code" name="postal_code" placeholder="Postal code"/>
				</div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="area_of_activity">Area of activity</label>
						  <div class="controls">
						<select id="area_of_activity" name="area_of_activity">
				               	<option value="">Area of activity</option>

				               @if(count($activity_type) > 0)
				                   @foreach($activity_type as $values)
<option {{ isset($recorddetails->area_of_activity) ? ($values->id == $recorddetails->area_of_activity ? 'selected' : '') : '' }} value="{{ $values->id }}">{{$values->value}}
</option>
				                   @endforeach
				                @endif 	
				               	
			               </select>
				</div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="occupation">Occupation</label>
						  <div class="controls">
						<input type="text" id="occupation" name="occupation"  placeholder="Occupation" value="{{$recorddetails->occupation or ''}}">
				</div>
						</div>

						<div class="control-group" >
						  <label class="control-label" for="passports">Is your Passport / ID document issued in a different country than your Country of Residence?</label>
						  <div class="controls">
						  <label for="passY"> 	
						<input type="radio" onchange="showsection(this)" name="issued_diff_country" id="passY" class="pass_id1" value="1" {{ isset($recorddetails->issued_diff_country) ? (1 == $recorddetails->issued_diff_country ? 'checked' : '') : '' }}>Yes</label>
						<label for="passN">
						<input onchange="showsection(this)" type="radio" name="issued_diff_country" id="passN" class="pass_id1" value="0" {{ isset($recorddetails->issued_diff_country) ? (0 == $recorddetails->issued_diff_country ? 'checked' : '') : '' }}>No</label>
				</div>
						</div>
						<div class="control-group show_bon" {{ isset($recorddetails->issued_diff_country) ? (1 == $recorddetails->issued_diff_country ? '' : 'style=display:none') : 'style=display:none' }}>
						  <label class="control-label" for="passports">Country of document origin</label>
						  <div class="controls">
						  <select id="country_of_doc_origin" name="country_of_doc_origin">
			               	<option value="">Country of document origin </option>
			               	@if(count($countriesData) > 0)
			               	    @foreach($countriesData as $values)
<option value="{{ $values->code }}" {{ isset($recorddetails->country_of_doc_origin) ? ($values->code == $recorddetails->country_of_doc_origin ? 'selected' : '') : '' }}>{{ $values->name }}</option>
			               	    @endforeach
			               	@endif
			               </select>
				</div>
						</div>
						<div class="control-group">
						  <label class="control-label" for="pep">Are you a Politically Exposed Person (PEP), a family member of a PEP, or closely associated to a PEP with prominent public functions in the Republic of Latvia, European Union, or any other foreign or international institution?</label>
						  <div class="controls">
						  	<label for="expY">
						<input type="radio" name="pep" id="expY" value="1" {{ isset($recorddetails->pep) ? ("1" == $recorddetails->pep ? 'checked' : '') : '' }}>Yes</label>
						<label for="expN">
						<input type="radio" value="0" name="pep" {{ isset($recorddetails->pep) ? (0 == $recorddetails->pep ? 'checked' : '') : '' }} id="expN">
						No</label>
				</div>
						</div>

						@if($mode == 'edit' && $recorddetails->status == 'pending')
						
						<div class="control-group">
						  <label class="control-label" for="status">Status </label>
						  <div class="controls">
							<select id="status" name="status" class="chzn-select">
							  <option value="">Choose</option>
							  
								  @if(count($statusarr))
										
									@foreach($statusarr as $kstat=>$status)
										
										<option value="{{ $kstat }}" {{ isset($recorddetails->status) ? ($kstat == $recorddetails->status ? 'selected' : '') : '' }} >{{ $status }}</option>
										
									@endforeach
								
								  @endif
							  
							</select>
						  </div>
						</div>
						
						@endif
						<div class="control-group">
						  <label class="control-label" for="investor_identity">Upload Proof</label>
						  <div class="controls">
							<input class="input-file uniform_on" name="investor_identity" type="file">
							
							@php
								
			$investor_proof = isset($recorddetails->investor_id) ? $recorddetails->investor_id : '';
								
							@endphp
							
							


							@if($investor_proof)
							@php

                          $fileType= \File::extension($investor_proof);
                         
							@endphp

							@if($fileType!="docx" && $fileType!="doc")
								  @php
								  	$target = "target='_blank'";
								  @endphp
							@else 
								  @php
								     $target="";
								  @endphp	
							@endif  

								
<a href="{{URL::asset('investor_proof/'.$investor_proof)}}" {{$target}}>{{$investor_proof}}</a>
							
							@endif
<input type="hidden" name="proofVal" value="{{$investor_proof}}">							
						  </div>
						</div>
											
						
						<div class="form-actions">
							@if($loggedinadminid==1)
						  <button type="submit" class="btn btn-primary">{{ $mode == 'add' ? 'Add' : 'Update' }}</button>
						  @endif
						  <button type="reset" class="btn" onclick="location.href='{{ URL::route('adminlender', array('mode'=>'','id'=>'','type'=>$type)) }}'">Cancel</button>
						</div>
						
					  </fieldset>
					  @if($loggedinadminid==1)
					</form>
					@endif

				</div>
			</div>
			
		</div>
		<!-- /block -->
	</div>
	
	
	@endif
	

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
		
		
		$('#check-all').click(function(){
			
			var checked = $(this).is(':checked');
			
			$('.chkall').prop('checked', checked);
			
			$(".chkall").uniform();
			
		});
		
		$('.jumptopage').change(function(){
			
			var page = $(this).val();
			
			location.href = "{{ URL::route('adminlender') }}"+"?page="+page;
			
		});
		
	});
	
	function delsel(){
	
		var element = document.getElementsByName('chk_id[]');
		ln = element.length;
		
		var flag = 0;
			
		for(i=0;i<ln;i++){
			
			//alert(element[i].checked);
			
			if(element[i].checked){
				
				flag = 1;
				break;
			}
		}
		
		if(flag == 0){
			
			alert('You must select atleast one item');
		}
		else{
			
			var cnf = confirm('Are you sure?');
			if(cnf){
				
				document.frmlisting.act.value = 'delsel';
				document.frmlisting.submit();
			}
			
		}
	}
	
	function truncate(){
		
		var cnf = confirm('Are you sure?');
		if(cnf){
			
			document.frmlisting.act.value = 'truncate';
			document.frmlisting.submit();
		}
	}
		
	function showsection(currentsection){

		if(currentsection.value==1){
			currentsection.parentNode.parentNode.parentNode.nextElementSibling.style.display='block';
		}else
		   currentsection.parentNode.parentNode.parentNode.nextElementSibling.style.display='none';
	}	
	</script>
@stop
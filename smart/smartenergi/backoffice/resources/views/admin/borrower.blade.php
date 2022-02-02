@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	@if ($mode == '')		
	
	<div class="row-fluid">
		<!-- block -->
		
		@php

		$flashdata = Session::get('action');
		
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
				<div class="muted pull-left">{{ ucfirst($mode).' '.$sectionname }}</div>
				<div class="muted pull-right"> Total Count: <strong>{{ $totcount }}</strong></div>
			</div>
			
			<div class="block-content collapse in">
			
				<div class="span12">
				   <div class="table-toolbar">
 @if($loggedinadminid==1) 
					  <div class="btn-group">
						 <a href="{{ URL::route('adminborrower', array('mode'=>'add')) }}"><button class="btn btn-success">Add New <i class="icon-plus icon-white"></i></button></a>
						 
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
					
					<form class="form-horizontal" name="frmlisting" id="frmlisting" action="#" method="post" enctype="multipart/form-data">
					    
						<input type="hidden" name="act" value="">
					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
					  
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
							<thead>
								<tr>
									@if($loggedinadminid==1)
									<th><label class="uniform"><input type="checkbox" class="uniform_on" value="" id="check-all" ></label></th>
									@endif
									<th>#</th>
									<th>Name</th>
									<th>Email</th>
									<th>Mobile</th>
									<th>Address</th>
									<th>Verification</th>
									<th>Registered On</th>
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
											
										$firstname = $data->firstname;
										$middlename = $data->middlename;
										$surname = $data->surname;
										
										$name = ucwords($firstname.' '.(!empty($middlename) ? $middlename : '').' '.$surname);
										
										$address = '';
										
										$housenumber = $data->housenumber;
										$streetname = $data->streetname;
										$suburb = $data->suburb;
										$city = $data->city;
										$province = $data->province;
										$postcode = $data->postcode;
										
										$address = $housenumber.' '.$streetname.', '.$city.', '.$province.', '.$postcode;
										
										$registeredon = date('d/m/Y h:i:s A', $data->createdate);
										
										$mobileverified = $data->mobile_verified;
										
										switch($mobileverified){
											
											case "0":
												$mobileverifiedclass = 'label-important';
												$mobileverifiedtxt = 'Mobile Not Verified';
												break;
											case "1":
												$mobileverifiedclass = 'label-success';
												$mobileverifiedtxt = 'Mobile Verified';
												break;
											
										}
										
										$emailverified = $data->email_verified;
										
										switch($emailverified){
											
											case "0":
												$emailverifiedclass = 'label-important';
												$emailverifiedtxt = 'Email Not Verified';
												break;
											case "1":
												$emailverifiedclass = 'label-success';
												$emailverifiedtxt = 'Email Verified';
												break;
											
										}
										@endphp
										
										<tr class="odd gradeX">
											@if($loggedinadminid==1)
											<td><label class="uniform"><input type="checkbox" value="{{$data->id}}" name="chk_id[]" class="chkall uniform_on"></label></td>
											@endif
											<td>{{$sl}}</td>
											<td>{{$name}}</td>
											<td>{{$data->emailaddress}}</td>
											<td>{{$data->cellphonenumber}}</td>
											<td>{{$address}}</td>
											<td>
												<div><span class="label {{$mobileverifiedclass}}">{{$mobileverifiedtxt}}</span></div>
												<!--<div><span class="label {{$emailverifiedclass}}">{{$emailverifiedtxt}}</span></div>-->
											</td>
											<td class="center">{{$registeredon}}</td>
											@if($loggedinadminid==1)
											<td class="center">
												<a href="{{ URL::route('adminborrowerdetails', array('id' => $data->id)) }}"><input type="button" value="View" class="btn btn-primary"></a>
												<a href="{{ URL::route('adminborrower',array('mode'=>'delete','id'=>$data->id)) }}" class="delclass"><input type="button" value="Delete" class="btn btn-danger"></a>
											</td>
											@else
											<td class="center">
												<a href="{{ URL::route('adminborrowerdetails', array('id' => $data->id)) }}"><input type="button" value="View" class="btn btn-primary"></a>
											</td>
											@endif
										</tr>
										
										@php $sl++ @endphp
									
									@endforeach
									
									@else
										
									<tr class="odd gradeX">
										<td colspan="11">No Record(s)</td>
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
				
			</div>
		</div>
		<!-- /block -->
		
	</div>
	
	@else
		
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
		
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">{{ ucfirst($mode).' '.$sectionname }}</div>
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
					
					<form class="form-horizontal" name="frmaddedit" action="" method="post" enctype="multipart/form-data">
					
					  <input type="hidden" name="act" value="do{{$mode}}">
					  <input type="hidden" name="id" value="{{$id}}">
					  <input type="hidden" name="_token" value="{{ csrf_token() }}">
					  
					  <fieldset>
						<legend>Personal Details</legend>
						
						<div class="control-group">
						  <label class="control-label" for="firstname">First Name</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="firstname" name="firstname" value="{{$recorddetails->firstname or ''}}" type="text">
						  </div>
						</div>

						<!--<div class="control-group">
						  <label class="control-label" for="middlename">Middle Name</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="middlename" name="middlename" value="{{$recorddetails->middlename or ''}}" type="text">
						  </div>
						</div>-->
						
						<div class="control-group">
						  <label class="control-label" for="surname">Surname</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="surname" name="surname" value="{{$recorddetails->surname or ''}}" type="text">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="second_surname">Second Surname</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="second_surname" name="second_surname" value="{{$recorddetails->second_surname or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="dob">Date of Birth</label>
						  <div class="controls">
							<input class="input-xlarge focused datepicker" id="dob" name="dob" value="{{$recorddetails->dob or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="emailaddress">Email Address</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="emailaddress" name="emailaddress" value="{{$recorddetails->emailaddress or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="cellphonenumber">Contact Number</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="cellphonenumber" name="cellphonenumber" value="{{$recorddetails->cellphonenumber or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="alternatenumber">Alternate Number</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="alternatenumber" name="alternatenumber" value="{{$recorddetails->alternatenumber or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="idnumber">ID Number</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="idnumber" name="idnumber" value="{{$recorddetails->idnumber or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="homelanguage">Home Language</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="homelanguage" name="homelanguage" value="{{$recorddetails->homelanguage or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="status">Status</label>
						  <div class="controls">
							<select id="status" name="status">
							  <option value="">Choose</option>
							  
								  @if(count($variables['status']))
										
									@foreach($variables['status'] as $status)
										
										<option value="{{ $status }}" {{ isset($recorddetails->status) ? ($status == $recorddetails->status ? 'selected' : '') : '' }} >{{ $status }}</option>
										
									@endforeach
								
								  @endif
							  
							</select>
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="maritalstatus">Marital Status</label>
						  <div class="controls">
							
							<select id="maritalstatus" name="maritalstatus">
							  <option value="">Choose</option>
							  
								  @if(count($variables['marital_status']))
										
									@foreach($variables['marital_status'] as $marital_status)
										
										<option value="{{ $marital_status }}" {{ isset($recorddetails->maritalstatus) ? ($marital_status == $recorddetails->maritalstatus ? 'selected' : '') : '' }} >{{ $marital_status }}</option>
										
									@endforeach
								
								  @endif
							  
							</select>
							
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="noofdependants">No of Dependants</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="noofdependants" name="noofdependants" value="{{$recorddetails->noofdependants or ''}}" type="text">
						  </div>
						</div>
						
						
						<legend>Account Details</legend>
						
						<div class="control-group">
						  <label class="control-label" for="username">Username</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="username" name="username" value="{{$recorddetails->username or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="password">Password</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="password" name="password" value="{{$recorddetails->password or ''}}" type="password">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="secretquestion">Secret Question</label>
						  <div class="controls">
							
							<select id="secretquestion" name="secretquestion">
							  <option value="">Choose</option>
							  
								  @if(count($variables['security_questions']))
										
									@foreach($variables['security_questions'] as $security_questions)
										
										<option value="{{ $security_questions }}" {{ isset($recorddetails->secretquestion) ? ($security_questions == $recorddetails->secretquestion ? 'selected' : '') : '' }} >{{ $security_questions }}</option>
										
									@endforeach
								
								  @endif
							  
							</select>
							
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="secretanswer">Secret Answer</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="secretanswer" name="secretanswer" value="{{$recorddetails->secretanswer or ''}}" type="text">
						  </div>
						</div>
						
						
						<legend>Employment Details</legend>
								
						<div class="control-group">
						  <label class="control-label" for="employmenttype">Employment Type</label>
						  <div class="controls">
							
							<select id="employmenttype" name="employmenttype">
							  <option value="">Choose</option>
							  
								  @if(count($variables['employment_status']))
										
									@foreach($variables['employment_status'] as $employment_status)
										
										<option value="{{ $employment_status }}" {{ isset($recorddetails->employmenttype) ? ($employment_status == $recorddetails->employmenttype ? 'selected' : '') : '' }} >{{ $employment_status }}</option>
										
									@endforeach
								
								  @endif
							  
							</select>
							
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="employercompanyname">Employer Company</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="employercompanyname" name="employercompanyname" value="{{$recorddetails->employercompanyname or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="grossmonthlyincome">Gross Monthly Income</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="grossmonthlyincome" name="grossmonthlyincome" value="{{$recorddetails->grossmonthlyincome or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="netmonthlyincome">Net Monthly Income</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="netmonthlyincome" name="netmonthlyincome" value="{{$recorddetails->netmonthlyincome or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="servicetype">Service Type</label>
						  <div class="controls">
							
							<select id="servicetype" name="servicetype">
							  <option value="">Choose</option>
							  
								  @if(count($variables['service_type']))
										
									@foreach($variables['service_type'] as $service_type)
										
										<option value="{{ $service_type }}" {{ isset($recorddetails->servicetype) ? ($service_type == $recorddetails->servicetype ? 'selected' : '') : '' }} >{{ $service_type }}</option>
										
									@endforeach
								
								  @endif
							  
							</select>
							
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="timewithemployer">Time with Employer (in Years)</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="timewithemployer" name="timewithemployer" value="{{$recorddetails->timewithemployer or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="workphonenumber">Work Phone Number</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="workphonenumber" name="workphonenumber" value="{{$recorddetails->workphonenumber or ''}}" type="text">
						  </div>
						</div>
						
						<!--<div class="control-group">
						  <label class="control-label" for="lastpayslip">Last Payslip</label>
						  <div class="controls">
							<input class="input-file uniform_on" name="lastpayslip" type="file">
						  </div>
						</div>-->
						
						
						<legend>Address Details</legend>
								
						<div class="control-group">
						  <label class="control-label" for="housenumber">House Number</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="housenumber" name="housenumber" value="{{$recorddetails->housenumber or ''}}" type="text">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="streetname">Street Name</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="streetname" name="streetname" value="{{$recorddetails->streetname or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="suburb">Suburb</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="suburb" name="suburb" value="{{$recorddetails->suburb or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="city">City</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="city" name="city" value="{{$recorddetails->city or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="province">Province</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="province" name="province" value="{{$recorddetails->province or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="postcode">Postcode</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="postcode" name="postcode" value="{{$recorddetails->postcode or ''}}" type="text">
						  </div>
						</div>
						
						
						<legend>Bank Details</legend>
								
						<div class="control-group">
						  <label class="control-label" for="bankname">Bank Name</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="bankname" name="bankname" value="{{$recorddetails->bankname or ''}}" type="text">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="street_bank_branch">Bank Branch Street</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="street_bank_branch" name="street_bank_branch" value="{{$recorddetails->street_bank_branch or ''}}" type="text">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="accountnumber">Account Number</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="accountnumber" name="accountnumber" value="{{$recorddetails->accountnumber or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="nameofaccountholder">Name of Account Holder</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="nameofaccountholder" name="nameofaccountholder" value="{{$recorddetails->nameofaccountholder or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="nameoncard">Name on Card</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="nameoncard" name="nameoncard" value="{{$recorddetails->nameoncard or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="cardnumber">Card Number</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="cardnumber" name="cardnumber" value="{{$recorddetails->cardnumber or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="expirymonth">Card Expiry Month</label>
						  <div class="controls">
							
							<select id="expirymonth" name="expirymonth">
							  <option value="">Choose</option>
							  
								  @foreach($variables['months'] as $kemonth=>$months)
										
									<option value="{{ $kemonth+1 }}" {{ isset($recorddetails->expirymonth) ? ($kemonth+1 == $recorddetails->expirymonth ? 'selected' : '') : '' }} >{{ $months }}</option>
									
								  @endforeach
							  
							</select>
							
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="expiryyear">Card Expiry Year</label>
						  <div class="controls">
							
							<select id="expiryyear" name="expiryyear">
							  <option value="">Choose</option>
							  
								  @for($y=date('Y');$y<(date('Y')+10);$y++){
										
									<option value="{{ $y }}" {{ isset($recorddetails->expiryyear) ? ($y == $recorddetails->expiryyear ? 'selected' : '') : '' }} >{{ $y }}</option>
									
								  @endfor
							  
							</select>
							
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="cvvnumber">Card CVV</label>
						  <div class="controls">
							<input class="input-xlarge focused" id="cvvnumber" name="cvvnumber" value="{{$recorddetails->cvvnumber or ''}}" type="text">
						  </div>
						</div>
						
						<!--<div class="control-group">
						  <label class="control-label" for="bankcertificate">Bank Certificate</label>
						  <div class="controls">
							<input class="input-file uniform_on" name="bankcertificate" type="file">
						  </div>
						</div>-->
								
						
						<div class="form-actions">
						  <button type="submit" class="btn btn-primary">{{ $mode == 'add' ? 'Add' : 'Update' }}</button>
						  <button type="reset" class="btn" onclick="location.href='{{ URL::route('adminborrower') }}'">Cancel</button>
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
	<link href="{{ URL::asset('public/backend/vendors/uniform.default.css') }}" rel="stylesheet" media="screen">
	<link href="{{ URL::asset('public/backend/vendors/chosen.min.css') }}" rel="stylesheet" media="screen">
	<link href="{{ URL::asset('public/backend/vendors/datepicker.css') }}" rel="stylesheet" media="screen">
@stop

@section('scripts')
	<script src="{{ URL::asset('public/backend/vendors/jquery.uniform.min.js') }}"></script>
	<script src="{{ URL::asset('public/backend/vendors/chosen.jquery.min.js') }}"></script>
	<script src="{{ URL::asset('public/backend/vendors/bootstrap-datepicker.js') }}"></script>
	
	<script>
		
	$(function() {
		$(".uniform_on").uniform();
		$(".chzn-select").chosen();
		$(".datepicker").datepicker({
			format: 'dd/mm/yyyy',
		});
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
			
			location.href = "{{ URL::route('adminborrower') }}"+"?page="+page;
			
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
		
	</script>
@stop
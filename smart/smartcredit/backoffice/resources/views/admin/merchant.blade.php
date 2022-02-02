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
						 <a href="{{ URL::route('adminmerchant', array('mode'=>'add','id'=>'','type'=>$type)) }}"><button class="btn btn-success">Add New <i class="icon-plus icon-white"></i></button></a>
						 
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
					<form style="overflow-x: scroll;" class="form-horizontal" name="frmlisting" id="frmlisting" action="#" method="post" enctype="multipart/form-data">
					@endif    
						<input type="hidden" name="act" value="">
						<input type="hidden" name="type" value="{{$type}}">
					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
					  
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
							<thead>
								<tr>
									@if($loggedinadminid==1)
									<th style="width: 3%;"><label class="uniform"><input type="checkbox" class="uniform_on" value="" id="check-all" ></label></th>
									@endif
									<th style="width: 2%;">#</th>
									<th>Merchant Name</th>
									<th>Company Name</th>
									<th>Email</th>
									<th>Contact Person</th>
									<th>Application received</th>
									<th>Applications approved</th>
									<th style="width: 5%;">Wallet balance</th>
									<th>Mobile</th>
									<th>CIF</th>
									<th>Sector</th>
									<th>Bank Details</th>
									<th>Registered On</th>
									<th>Status</th>
									<th style="width: 8%;">Action</th>
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
										$merchant_name = $data->merchant_name;
										$company_name = $data->company_name;
										$contact_person = $data->contact_person;
										$mobile_no = $data->mobile_no;
										$merchant_cif = $data->merchant_cif;
										$sector = $data->sector;
										$bank_name = $data->bank_name;
										$bank_account_no = $data->bank_account_no;
										$registeredon = date('d/m/Y h:i:s A', $data->createdate);
										$total_sales = $data->total_sales;
										$total_approved_sales=$data->total_approved_sales;
										$wallet_balance=$data->wallet_balance;
										
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
											<td>{{$merchant_name}}</td>
											<td>{{$company_name}}</td>
											<td>{{$email}}</td>
											<td>{{$contact_person}}</td>
											<td>
											@if($total_sales)
												<a href="{{ URL::route('adminloanpayments', array('id'=>$id)) }}">{{$total_sales}}</a>
												@else
												  {{$total_sales}}
												@endif
												</td>
											<td>
												@if($total_approved_sales)
												<a href="{{ URL::route('adminloanpayments', array('id'=>$id)) }}">{{$total_approved_sales}}</a>
												@else
												  {{$total_approved_sales}}
												@endif
											</td>
											<td>{{$wallet_balance}}</td>
											<td>{{$mobile_no}}</td>
											<td>{{$merchant_cif}}</td>
											<td>{{$sector}}</td>
											<td>
												<div>{{$bank_name}}</div>
												<div>A/C No: {{$bank_account_no}}</div>
											</td>
											<td class="center">{{$registeredon}}</td>
											<td class="center"><span class="label {{$statusclass}}">{{ucfirst($status)}}</td>
											<td class="center">
												@if($loggedinadminid==1)
												<a href="{{ URL::route('adminmerchant',array('id'=>$id, 'mode'=>'edit', 'type'=>$type)) }}"><input type="button" value="Edit" class="btn btn-warning"></a>
												
												<a href="{{ URL::route('adminmerchant',array('id'=>$id, 'mode'=>'delete', 'type'=>$type)) }}" class="delclass"><input type="button" value="Delete" class="btn btn-danger"></a>
												
												<a href="{{ URL::route('adminmerchantprocessedloans',array('id'=>$id)) }}" class=""><input type="button" value="Processed Loans" class="btn btn-info"></a>

												<a href="{{ URL::route('adminmerchanttransaction',array('id'=>$id)) }}" class=""><input type="button" value="Transactions" class="btn btn-primary"></a>
												@else
												<a href="{{ URL::route('adminmerchant',array('id'=>$id, 'mode'=>'edit', 'type'=>$type)) }}"><input type="button" value="View" class="btn btn-warning"></a>
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
							<input type="text" class="span6" name="email" id="email" @if(!empty($recorddetails->email ) && count($errors)==0) readonly @endif value="{{$recorddetails->email or ''}}">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="password">Password</label>
						  <div class="controls">
							<input type="password" class="span6" name="password" id="password" value="">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="merchant_name">Merchant First Name</label>
						  <div class="controls">
							<input type="text" class="span6" name="merchant_name" id="merchant_name" value="{{$recorddetails->merchant_name or ''}}">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="merchant_surname">Merchant Surname</label>
						  <div class="controls">
							<input type="text" class="span6" name="merchant_surname" id="merchant_surname" value="{{$recorddetails->merchant_surname or ''}}">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="collegiate_number">Collegiate number</label>
						  <div class="controls">
							<input type="text" class="span6" name="collegiate_number" id="collegiate_number" value="{{$recorddetails->collegiate_number or ''}}">
						  </div>
						</div>

						<div class="control-group">		
						    <label class="control-label" for="select_type">Select Type</label>				
							<div class="controls">
								<select name="dninie" id="dninie">
									<option value="">Select Type</option>
									<option {{ (isset($recorddetails->dninie) && $recorddetails->dninie=="dni") ? "selected" : ''}} value="dni">DNI</option>
									<option {{ (isset($recorddetails->dninie) && $recorddetails->dninie=="nie") ? "selected" : ''}} value="nie">NIE</option>
								</select>
							</div>						
					    </div>
						<div class="control-group">
						  <label class="control-label" for="merchant_nie">DNI/NIE</label>
						  <div class="controls">
							<input type="text" class="span6" name="merchant_nie" id="merchant_nie" value="{{$recorddetails->merchant_nie or ''}}">
						  </div>
						</div>						
						
						<div class="control-group">
						  <label class="control-label" for="contact_person">Contact Person</label>
						  <div class="controls">
							<input type="text" class="span6" name="contact_person" id="contact_person" value="{{$recorddetails->contact_person or ''}}">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="company_name">Company Name</label>
						  <div class="controls">
							<input type="text" class="span6" name="company_name" id="company_name" value="{{$recorddetails->company_name or ''}}">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="company_email">Company Email</label>
						  <div class="controls">
							<input type="text" class="span6" name="company_email" id="company_email" value="{{$recorddetails->company_email or ''}}">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="company_phone">Company Phone</label>
						  <div class="controls">
							<input type="text" class="span6" name="company_phone" id="company_phone" value="{{$recorddetails->company_phone or ''}}">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="company_address">Contact Address</label>
						  <div class="controls">
						  	<textarea class="span6" name="company_address" id="company_address">{{$recorddetails->company_address or ''}}</textarea>
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="shop_address">Shop Address</label>
						  <div class="controls">
						  	<textarea class="span6" name="shop_address" id="shop_address">{{$recorddetails->shop_address or ''}}</textarea>
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="shop_phone">Shop Phone</label>
						  <div class="controls">
						  	<textarea class="span6" name="shop_phone" id="shop_phone">{{$recorddetails->shop_phone or ''}}</textarea>
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="mobile_no">Mobile Number</label>
						  <div class="controls">
							<input type="text" class="span6" name="mobile_no" id="mobile_no" value="{{$recorddetails->mobile_no or ''}}">
						  </div>
						</div>

						<div class="control-group">
							<label class="control-label" for="merchant_cif">Are you self employed ?</label>
							<div class="controls" id="self_employed">
									  	<label class="radio-inline" for="Smale">
									  		<input type="radio" name="self_employed" value="yes" id="self_employed1" {{ (isset($recorddetails->self_employed) && $recorddetails->self_employed=="yes") ? "checked" : ''}}/> Yes
									    </label>
									    <label class="radio-inline" for="SFemale">
									  		<input type="radio" name="self_employed" value="no" id="self_employed2" {{ (isset($recorddetails->self_employed) && $recorddetails->self_employed=="no") ? "checked" : ''}}>No
									    </label>
							</div>
							
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="merchant_cif">CIF/ID</label>
						  <div class="controls">
							<input type="text" class="span6" name="merchant_cif" id="merchant_cif" value="{{$recorddetails->merchant_cif or ''}}">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="sector">Sector</label>
						  <div class="controls">
							
							<select id="sector" name="sector">
							  <option value="">Choose</option>
							  
								  @if(count($variables['merchant_prod_type']))
										
									@foreach($variables['merchant_prod_type'] as $key=>$merchant_prod_type)
										
										<option value="{{ $key }}" {{ isset($recorddetails->sector) ? ($key == $recorddetails->sector ? 'selected' : '') : '' }} >{{ $merchant_prod_type }}</option>
										
									@endforeach
								
								  @endif
							  
							</select>
							
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="sector">Country Of Residence</label>
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
						  <label class="control-label" for="dob">Date of Birth</label>
						  <div class="controls">
								<input class="input-xlarge focused datepicker" id="dob" name="dob" value="{{$recorddetails->dob or ''}}" type="text">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="url">URL</label>
						  <div class="controls">
							<input type="text" class="span6" name="url" id="url" value="{{$recorddetails->url or ''}}">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="address">Address</label>
						  <div class="controls">
							<input type="text" class="span6" name="address" id="address" value="{{$recorddetails->address or ''}}">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="bank_branch">Name of the bank branch</label>
						  <div class="controls">
							<input type="text" class="span6" name="bank_branch" id="bank_branch" value="{{$recorddetails->bank_branch or ''}}">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="street_bank_branch">Street of the bank branch</label>
						  <div class="controls">
							<input type="text" class="span6" name="street_bank_branch" id="street_bank_branch" value="{{$recorddetails->street_bank_branch or ''}}">
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="account_holder">IBAN Holder</label>
						  <div class="controls">
							<input type="text" class="span6" name="account_holder" id="account_holder" value="{{$recorddetails->account_holder or ''}}">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="iban_number">Bank Account Number</label>
						  <div class="controls">
							<input type="text" class="span6" name="iban_number" id="iban_number" value="{{$recorddetails->iban_number or ''}}">
						  </div>
						</div>

						<!----<div class="control-group">
						  <label class="control-label" for="iban_number">IBAN Number</label>
						  <div class="controls">
							<input type="text" class="span6" name="iban_number" id="iban_number" value="{{$recorddetails->iban_number or ''}}">
						  </div>
						</div>---->
						@if(!empty($recorddetails->agreement))

						@php
												
								$document_path = URL::asset('merchantgeneratedfiles/'.$recorddetails->agreement);
								
							@endphp
						<div class="control-group">
						  <label class="control-label" for="bank_account_no">Terms Agreement</label>
						  <div class="controls">
							<label><a href="{{$document_path}}"> {{$recorddetails->agreement}}</a></label>
						  </div>
						</div>
						@endif
						
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
						
						
						
						<div class="form-actions">
						@if($loggedinadminid==1)
						  <button type="submit" class="btn btn-primary">{{ $mode == 'add' ? 'Add' : 'Update' }}</button>
						  @endif
						  <button type="reset" class="btn" onclick="location.href='{{ URL::route('adminmerchant', array('mode'=>'','id'=>'','type'=>$type)) }}'">Cancel</button>
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
	});
	
	$(document).ready(function(){
		$(".datepicker").datepicker({
			format: 'dd/mm/yyyy',
		});

		/*$('input[name="self_employed"]').change(function(){		
			var val = $(this).val();
			if(val == 'no'){		

				$('#merchant_cif').parents('.control-group').show();
			}
			else if(val == 'yes'){			
				$('#merchant_cif').parents('.control-group').hide();
			}		
		});*/
		
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
			
			location.href = "{{ URL::route('adminmerchant') }}"+"?page="+page;
			
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
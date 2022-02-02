@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	<!-- wizard -->
	<div class="row-fluid section">
		 <!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">Borrower Details</div>
				<div class="muted pull-right">
					
					<a href="{{ URL::route('adminborrower') }}"><button class="btn btn-danger">&laquo;&nbsp;Back</button></a>
					
				</div>
			</div>
			<div class="block-content collapse in">
				<div class="span12">
					
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
					
					<h2 style="margin:0 0 20px 0">{{ ucfirst($borrowerdata->firstname.' '.$borrowerdata->surname) }} <span class="label label-info" style="vertical-align:middle">Borrower ID: {{ $borrowerdata->id }}</span>
<span class="label label-info" style="vertical-align:middle">Wallet balance: {{ $borrowerdata->wallet_balance }}</span>
					</h2>
					
					<div class="navbar">
						
						<div class="navbar-inner">
						
							<div class="container">
							
								<ul class="nav nav-pills borrowerdatatab">
									<li class="active"><a data-toggle="pill" href="#personaldetails">👤 Personal Details</a></li>
									<li><a data-toggle="pill" href="#employmentdetails">💼 Employment Details</a></li>
									<li><a data-toggle="pill" href="#addressdetails">🚩 Address Details</a></li>
									<li><a data-toggle="pill" href="#bankdetails">💶 Bank Details</a></li>
									<li><a data-toggle="pill" href="#attachments">📎 Attachments</a></li>
									<li><a data-toggle="pill" href="#documents">📋 Documents</a></li>
									<li><a data-toggle="pill" href="#creditrisk">👉 Credit Risk Area</a></li>
									<li><a data-toggle="pill" href="#loanapplications">👉 Loan Applications</a></li>
									<li><a data-toggle="pill" href="#accountrecovery">🔑 Account Recovery</a></li>
									<li><a data-toggle="pill" href="#payments">💳 Payments</a></li>
									<li><a data-toggle="pill" href="#notedetails">🖋️ Note</a></li>
								</ul>
							
							</div>
							
						</div>
						
					</div>
				  
					<div class="tab-content">
					
						<div id="personaldetails" class="tab-pane fade in active">
						  @if($loggedinadminid==1)
						   <form class="form-horizontal" method="post" action="{{ URL::route('adminborrowerdetails', array('id'=>$id)) }}">
						   	@else
						   	<div class="form-horizontal">
						   	@endif
						   
							  <input type="hidden" name="act" value="personaldetails">
							  <input type="hidden" name="_token" value="{{ csrf_token() }}">
						   
							  <fieldset>
								<legend>Personal Details</legend>
								
								<div class="control-group">
								  <label class="control-label" for="firstname">First Name</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="firstname" name="firstname" value="{{$borrowerdata->firstname}}" type="text">
								  </div>
								</div>

								<!--<div class="control-group">
								  <label class="control-label" for="middlename">Middle Name</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="middlename" name="middlename" value="{{$borrowerdata->middlename}}" type="text">
								  </div>
								</div>-->
								
								<div class="control-group">
								  <label class="control-label" for="surname">Surname</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="surname" name="surname" value="{{$borrowerdata->surname}}" type="text">
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="second_surname">Second Surname</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="second_surname" name="second_surname" value="{{$borrowerdata->second_surname}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="dob">Date of Birth</label>
								  <div class="controls">
									<input class="input-xlarge focused datepicker" id="dob" name="dob" value="{{$borrowerdata->dob}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="username">Username</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="username" name="username" value="{{$borrowerdata->username}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="emailaddress">Email Address</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="emailaddress" name="emailaddress" value="{{$borrowerdata->emailaddress}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="cellphonenumber">Contact Number</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="cellphonenumber" name="cellphonenumber" value="{{$borrowerdata->cellphonenumber}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="alternatenumber">Alternate Number</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="alternatenumber" name="alternatenumber" value="{{$borrowerdata->alternatenumber}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="idnumber">ID Number</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="idnumber" name="idnumber" value="{{$borrowerdata->idnumber}}" type="text">
								  </div>
								</div>
								
								<!--<div class="control-group">
								  <label class="control-label" for="homelanguage">Home Language</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="homelanguage" name="homelanguage" value="{{$borrowerdata->homelanguage}}" type="text">
								  </div>
								</div>-->
								
								<div class="control-group">
								  <label class="control-label" for="status">Status</label>
								  <div class="controls">
									<select id="status" name="status">
									  <option value="">Choose</option>
									  
										  @if(count($variables['status']))
												
											@foreach($variables['status'] as $key=>$status)
												
												<option value="{{ $key }}" {{ $borrowerdata->status == $key ? 'selected' : '' }}>{{ $status }}</option>
												
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
												
											@foreach($variables['marital_status'] as $key=>$marital_status)
												
												<option value="{{ $key }}" {{ $borrowerdata->maritalstatus == $key ? 'selected' : '' }} >{{ $marital_status }}</option>
												
											@endforeach
										
										  @endif
									  
									</select>
									
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="noofdependants">No of Dependants</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="noofdependants" name="noofdependants" value="{{$borrowerdata->noofdependants}}" type="text">
								  </div>
								</div>
								@if($loggedinadminid==1)
								<div class="form-actions">
								  <button type="submit" class="btn btn-primary">Save changes</button>
								</div>
								@endif
								
							  </fieldset>
							 @if($loggedinadminid==1) 
						    </form>
						    @else
						    </div>
						    @endif
						  
						</div>
						
						<div id="employmentdetails" class="tab-pane fade">
						  @if($loggedinadminid==1) 
						  <form class="form-horizontal" method="post" action="{{ URL::route('adminborrowerdetails', array('id'=>$id)) }}">
						  	 @else
						    <div class="form-horizontal">
						    @endif
							  
							  <input type="hidden" name="act" value="employmentdetails">
							  <input type="hidden" name="_token" value="{{ csrf_token() }}">
							  
							  <fieldset>
								<legend>Employment Details</legend>
								
								<div class="control-group">
								  <label class="control-label" for="employmenttype">Employment Type</label>
								  <div class="controls">
									
									<select id="employmenttype" name="employmenttype">
									  <option value="">Choose</option>
									  
										  @if(count($variables['employment_status']))
												
											@foreach($variables['employment_status'] as $key=>$employment_status)
												
												<option value="{{ $key }}" {{ $borrowerdata->employmenttype == $key ? 'selected' : '' }} >{{ $employment_status }}</option>
												
											@endforeach
										
										  @endif
									  
									</select>
									
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="employercompanyname">Employer Company</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="employercompanyname" name="employercompanyname" value="{{$borrowerdata->employercompanyname}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="grossmonthlyincome">Gross Monthly Income</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="grossmonthlyincome" name="grossmonthlyincome" value="{{$borrowerdata->grossmonthlyincome}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="netmonthlyincome">Net Monthly Income</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="netmonthlyincome" name="netmonthlyincome" value="{{$borrowerdata->netmonthlyincome}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="servicetype">Service Type</label>
								  <div class="controls">
									
									<select id="servicetype" name="servicetype">
									  <option value="">Choose</option>
									  
										  @if(count($variables['service_type']))
												
											@foreach($variables['service_type'] as $key=>$service_type)
												
												<option value="{{ $key }}" {{ $borrowerdata->servicetype == $key ? 'selected' : '' }} >{{ $service_type }}</option>
												
											@endforeach
										
										  @endif
									  
									</select>
									
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="timewithemployer">Time with Employer (in Years)</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="timewithemployer" name="timewithemployer" value="{{$borrowerdata->timewithemployer}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="workphonenumber">Work Phone Number</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="workphonenumber" name="workphonenumber" value="{{$borrowerdata->workphonenumber}}" type="text">
								  </div>
								</div>
								@if($loggedinadminid==1) 
								<div class="form-actions">
								  <button type="submit" class="btn btn-primary">Save changes</button>
								</div>
								@endif
							  </fieldset>
							  
						    @if($loggedinadminid==1) 
						    </form>
						    @else
						    </div>
						    @endif
						  
						</div>
						
						<div id="addressdetails" class="tab-pane fade">
						  @if($loggedinadminid==1) 
						  <form class="form-horizontal" method="post" action="{{ URL::route('adminborrowerdetails', array('id'=>$id)) }}">
						  	 @else
						    <div class="form-horizontal">
						    @endif

							  <input type="hidden" name="act" value="addressdetails">
							  <input type="hidden" name="_token" value="{{ csrf_token() }}">
							  
							  <fieldset>
								<legend>Address Details</legend>
								
								<div class="control-group">
								  <label class="control-label" for="housenumber">House Number</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="housenumber" name="housenumber" value="{{$borrowerdata->housenumber}}" type="text">
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="streetname">Street Name</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="streetname" name="streetname" value="{{$borrowerdata->streetname}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="suburb">Suburb</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="suburb" name="suburb" value="{{$borrowerdata->suburb}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="city">City</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="city" name="city" value="{{$borrowerdata->city}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="province">Province</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="province" name="province" value="{{$borrowerdata->province}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="postcode">Postcode</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="postcode" name="postcode" value="{{$borrowerdata->postcode}}" type="text">
								  </div>
								</div>
								@if($loggedinadminid==1) 
								<div class="form-actions">
								  <button type="submit" class="btn btn-primary">Save changes</button>
								</div>
								@endif
							  </fieldset>
							  
						    @if($loggedinadminid==1) 
						    </form>
						    @else
						    </div>
						    @endif
						  
						</div>
						
						<div id="bankdetails" class="tab-pane fade">
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
							<form class="form-horizontal" method="post" action="{{ URL::route('adminborrowerdetails', array('id'=>$id)) }}">
								@else
								<div class="form-horizontal" >
						   @endif   
							  <input type="hidden" name="act" value="bankdetails">
							  <input type="hidden" name="_token" value="{{ csrf_token() }}">
							  <input type="hidden"  name="wallet_id" value="{{$borrowerdata->wallet_id}}"/>
							  <fieldset>
								<legend>Bank Details</legend>
								
								<div class="control-group">
								  <label class="control-label" for="bankname">Bank Name</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="bankname" name="bankname" value="{{$borrowerdata->bankname}}" type="text">
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="street_bank_branch">Street bank branch</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="street_bank_branch" name="street_bank_branch" value="{{$borrowerdata->street_bank_branch}}" type="text">
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="accountnumber">Account Number</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="accountnumber" name="accountnumber" value="{{$borrowerdata->ibannumber}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="nameofaccountholder">Name of Account Holder</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="nameofaccountholder" name="nameofaccountholder" value="{{$borrowerdata->nameofaccountholder}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="nameoncard">Name on Card</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="nameoncard" name="nameoncard" value="{{$borrowerdata->nameoncard}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="cardnumber">Card Number</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="cardnumber" name="cardnumber" value="{{$borrowerdata->cardnumber}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="expirymonth">Card Expiry Month</label>
								  <div class="controls">
									
									<select id="expirymonth" name="expirymonth">
									  <option value="">Choose</option>
									  
										  @foreach($variables['months'] as $kemonth=>$months)
												
											<option value="{{ $kemonth+1 }}" {{ $borrowerdata->expirymonth == $kemonth+1 ? 'selected' : '' }} >{{ $months }}</option>
											
										  @endforeach
									  
									</select>
									
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="expiryyear">Card Expiry Year</label>
								  <div class="controls">
									
									<select id="expiryyear" name="expiryyear">
									  <option value="">Choose</option>
									  
										  @for($y=date('Y');$y<(date('Y')+10);$y++)
												
											<option value="{{ $y }}" {{ $borrowerdata->expiryyear == $y ? 'selected' : '' }} >{{ $y }}</option>
											
										  @endfor
									  
									</select>
									
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="cvvnumber">Card CVV</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="cvvnumber" name="cvvnumber" value="{{$borrowerdata->cvvnumber}}" type="text">
								  </div>
								</div>
								@if($loggedinadminid==1) 
								<div class="form-actions">
								  <button type="submit" class="btn btn-primary">Save changes</button>
								</div>
								@endif   
							  </fieldset>
							 @if($loggedinadminid==1)  
						    	</form>
						    @else
								</div>
						    @endif 

							
						</div>
						
						<div id="attachments" class="tab-pane fade">
						   @if($loggedinadminid==1)  
						  <form class="form-horizontal" id="frmattachment" method="post" action="{{ URL::route('adminborrowerdetails', array('id'=>$id)) }}" enctype="multipart/form-data">
						   @else
								<div class="form-horizontal">
						    @endif 

							  <input type="hidden" name="act" value="">
							  <input type="hidden" name="id" value="">
							  <input type="hidden" name="_token" value="{{ csrf_token() }}">
							  
							  @if(count($attachments))
								  
								@foreach($attachments as $kattach=>$attachment)
									
									@php
										
										$loan_id = $kattach;										
										
									@endphp
									
									<fieldset style="margin-bottom:30px;">
										<legend>Loan #: {{ $loan_id }} 
											@if($loggedinadminid==1)  
											<a href="#loanattachmentmodal{{$loan_id}}" data-toggle="modal"><input type="button" value="Update" class="btn btn-info btn-mini"></a>
											@endif
										</legend>
										
										@php
										
											$sl = 1; 
											$documents = $attachment;
											
										@endphp
											
										<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" style="width:60%">
											<thead>
												<tr>
													<th>#</th>
													<th>File</th>
													<th>Uploaded On</th>
													@if($loggedinadminid==1)  
													<th>Action</th>
													@endif
												</tr>
											</thead>
											<tbody>
												
												@if(count($documents))
											
													@foreach($documents as $doc)
														
														@php
												
															$document_type = $doc->document_type;
															$document_path = URL::asset('userfiles/'.$doc->document_path);
															$createdate = date('d/m/Y h:i:s A',$doc->createdate);
															
															$documentTypeText = '';								
															
															switch($document_type){
																
																case "lastpayslip":
																	$documentTypeText = 'Last Payslip';
																	break;
																case "bankcertificate":
																	$documentTypeText = 'Bank Account Certificate';
																	break;
																case "idproof":
																	$documentTypeText = 'ID Proof';
																	break;
																case "budgetattachment":
																	$documentTypeText = 'Budget Attachment';
																	break;
															}
														
														
															$docExtArr = explode('.',$doc->document_path);
															$docExt = $docExtArr[1];
														
														@endphp
														
														<tr class="odd gradeX">
															<td>{{$sl}}</td>
															<td align="center" valign="middle"><img src="{{ URL::asset('public/backend/images/'.$docExt.'.png') }}"><a href="{{$document_path}}" target="_blank"> {{$documentTypeText}}</a></td>
															<td align="center" valign="middle">{{$createdate}}</td>
															@if($loggedinadminid==1)  
															<td><a href="javascript:void(0);" class="delclassattachment" data-id="{{$doc->id}}"><input type="button" value="Delete" class="btn btn-danger"></a></td>
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

										<div id="loanattachmentmodal{{$loan_id}}" class="modal fade">
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">&times;</button>
												<h3>Update Attachments</h3>
											</div>
											<div class="modal-body">
												
												<fieldset>
													<legend>Loan #: {{$loan_id}}</legend>
													
													<div class="control-group">
													  <label class="control-label" for="lastpayslip">Last Payslip</label>
													  <div class="controls">
														<input class="input-file uniform_on" name="lastpayslip_{{$loan_id}}" type="file">
														<a href="{{URL::asset('userfiles/'.$attachmentsbytype[$loan_id]['lastpayslip'])}}" target="_blank">{{$attachmentsbytype[$loan_id]['lastpayslip']}}</a>
													  </div>
													</div>
													
													<div class="control-group">
													  <label class="control-label" for="bankcertificate">Bank Certificate</label>
													  <div class="controls">
														<input class="input-file uniform_on" name="bankcertificate_{{$loan_id}}" type="file">
														<a href="{{URL::asset('userfiles/'.$attachmentsbytype[$loan_id]['bankcertificate'])}}" target="_blank">{{$attachmentsbytype[$loan_id]['bankcertificate']}}</a>
													  </div>
													</div>
													
													<div class="control-group">
													  <label class="control-label" for="idproof">ID Proof</label>
													  <div class="controls">
														<input class="input-file uniform_on" name="idproof_{{$loan_id}}" type="file">
														<a href="{{URL::asset('userfiles/'.$attachmentsbytype[$loan_id]['idproof'])}}" target="_blank">{{$attachmentsbytype[$loan_id]['idproof']}}</a>
													  </div>
													</div>
													
													<div class="control-group">
													  <label class="control-label" for="budgetattachment">Budget Attachment</label>
													  <div class="controls">
														<input class="input-file uniform_on" name="budgetattachment_{{$loan_id}}" type="file">
														<a href="{{URL::asset('userfiles/'.$attachmentsbytype[$loan_id]['budgetattachment'])}}" target="_blank">{{$attachmentsbytype[$loan_id]['budgetattachment']}}</a>
													  </div>
													</div>
													
												</fieldset>
												
											</div>
											<div class="modal-footer">
												<a data-dismiss="modal" class="btn btn-primary updateattachment" href="javascript:void(0);" data-loanid="{{$loan_id}}">Update</a>
												<a data-dismiss="modal" class="btn" href="#">Cancel</a>
											</div>
										</div>
										
									  </fieldset>
									
									@endforeach
									
									@else
										
									<fieldset style="margin-bottom:30px;">
										<legend>No Records</legend>
									</fieldset>
							  
								@endif
							 @if($loggedinadminid==1)   
						    </form>
						    @else
						</div>
						  @endif
						</div>
						
						<div id="creditrisk" class="tab-pane fade">
							
							  @if(count($creditriskarea) > 0)
							  	<ul style="list-style:none; margin-left:0">
								@foreach($creditriskarea as $key=> $riskdata)
								@php
								  $loanid=$key;
								  @endphp
								  <h3>{{$loanid}}</h3>

							      @if(!empty($riskdata[0]))
							      
									  @foreach($riskdata[0] as $key=> $riskdata1)
									  
									    @if($key!="id" && $key!="loan_id")
											<li class="{{$key}}"><strong>{{ ucfirst(str_replace("_"," ",$key)) }} : </strong><span>{{$riskdata1}}</span></li>
										@endif	
									   @endforeach
								   @else
								       <p style="color: red;">No Data available</p>
								   @endif
								@endforeach
								<ul style="list-style:none; margin-left:0">
							@endif
						  
								
								
							</ul>
							
						  
						</div>

						<div id="documents" class="tab-pane fade">
						   @if($loggedinadminid==1)   
						  <form class="form-horizontal" id="frmdocument" method="post" action="{{ URL::route('adminborrowerdetails', array('id'=>$id)) }}" enctype="multipart/form-data">
						  	@else
						  	<div class="form-horizontal">
						  @endif
							  <input type="hidden" name="act" value="">
							  <input type="hidden" name="id" value="">
							  <input type="hidden" name="_token" value="{{ csrf_token() }}">
							  
							  @if(count($genfiles))
								  
								@foreach($genfiles as $kdoc=>$doc)
									
									@php
										
										$loan_id = $kdoc;										
										
									@endphp
									
									<fieldset style="margin-bottom:30px;">
										<legend>Loan #: {{ $loan_id }}</legend>
										
										@php
										
											$sl = 1; 
											$genfilesdata = $doc;
											
										@endphp
											
										<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" style="width:60%">
											<thead>
												<tr>
													<th>#</th>
													<th>File</th>
													<th>Generated On</th>
												</tr>
											</thead>
											<tbody>
												
												@if(count($genfilesdata))
											
													@foreach($genfilesdata as $doc)
														
														@php
												
															$document_type = $doc->document_type;
															$document_path = URL::asset('generatedfiles/'.$doc->document_path);
															$createdate = date('d/m/Y h:i:s A',$doc->createdate);
															
															$documentTypeText = '';								
															switch($document_type){
																
																case "contractual_document":
																	$documentTypeText = 'Contractual Document';
																	break;
																case "closure_certificate":
																	$documentTypeText = 'Closure Certificate';
																	break;
															}
														
															
															switch($document_type){
																
																case "pre_contractual_document":
																	$documentTypeText = 'Pre Contractual Document';
																	break;
																case "seccis_document":
																	$documentTypeText = 'SECCIS Document';
																	break;
															}
														
														
															$docExtArr = explode('.',$doc->document_path);
															$docExt = $docExtArr[1];
														
														@endphp
														
														<tr class="odd gradeX">
															<td>{{$sl}}</td>
															<td align="center" valign="middle"><img src="{{ URL::asset('public/backend/images/'.$docExt.'.png') }}"><a href="{{$document_path}}" target="_blank">{{$documentTypeText}}</a></td>
															<td align="center" valign="middle">{{$createdate}}</td>
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
										
									  </fieldset>
									
									@endforeach
									
									@else
										
									<fieldset style="margin-bottom:30px;">
										<legend>No Records</legend>
									</fieldset>
							  
								@endif
							  @if($loggedinadminid==1)    
						    </form>
						    @else
						</div>
						  @endif
						</div>
						
						<div id="loanapplications" class="tab-pane fade">
						  
							<fieldset>
								<legend>Loan Applications</legend>
								
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
									<thead>
										<tr>
											<th>#</th>
											<th>Loan ID</th>
											<th>Loan Amount</th>
											<th>Loan Duration</th>
											<th>APR(%)</th>
											<th>Merchant Name</th>
											<th>Product Name</th>
											<th>Applied On</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										
										@if (count($loans) > 0)
											
											@php
												
												$sl = 1; 
												
											@endphp
											
											@foreach($loans as $data)
												
												@php
													$loan_id = $data->id;
													$unique_id = $data->unique_id;
													$loan_amount = $data->loan_amount;
													$loan_terms = $data->loan_terms.' months';
													$loan_apr = $data->loan_apr;
													
													$appliedon = date('d/m/Y h:i:s A', $data->createdate);
												
												$status = $data->status;
												
												
												switch($status){
													
													case "pending":
														$statusclass = 'label-warning';
														break;
													case "approved":
														$statusclass = 'label-success';
														break;
													case "rejected":
														$statusclass = 'label-important';
														break;
													case "closed":
														$statusclass = 'label-primary';
														break;
													default:
														$statusclass = 'label-warning';
														break;
												}
											
													$merchant_id = $data->merchant_id;
													
													$merchant_name = !empty($data->merchant_name) ? $data->merchant_name : 'N/A';
													$merchant_cif = !empty($data->merchant_name) ? 'ID:'.$data->merchant_cif : '';
													
													$product_name = !empty($data->product_name) ? $data->product_name : 'N/A';		
												@endphp
												
												<tr class="odd gradeX">
													<td>{{$sl}}</td>
													<td><a href="{{ URL::route('adminloanapplicationmodify',array('id'=>$loan_id, 'mode'=>'edit')) }}">{{$unique_id}}</a></td>
													<td>&euro;{{$loan_amount}}</td>
													<td>{{$loan_terms}}</td>
													<td>{{$loan_apr}}</td>
													<td>
														<div>{{$merchant_name}}</div>
														<div>{{$merchant_cif}}</div>
													</td>
													<td>{{$product_name}}</td>
													<td class="center">{{$appliedon}}</td>
													<td class="center"><span class="label {{$statusclass}}">{{ucfirst($status)}}</td>
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
								
							  </fieldset>
						  
						</div>
						
						<div id="accountrecovery" class="tab-pane fade">
						  @if($loggedinadminid==1)
						  <form class="form-horizontal" method="post" action="{{ URL::route('adminborrowerdetails', array('id'=>$id)) }}">
						  	@else
						  	<div class="form-horizontal">
						    @endif  
							  <input type="hidden" name="act" value="accountrecovery">
							  <input type="hidden" name="_token" value="{{ csrf_token() }}">
							  
							  <fieldset>
								<legend>Account Recovery</legend>
								
								<div class="control-group">
								  <label class="control-label" for="secretquestion">Secret Question</label>
								  <div class="controls">
									
									<select id="secretquestion" name="secretquestion">
									  <option value="">Choose</option>
									  
										  @if(count($variables['security_questions']))
												
											@foreach($variables['security_questions'] as $key=>$security_questions)
												
												<option value="{{ $key }}" {{ $borrowerdata->secretquestion == $key ? 'selected' : '' }} >{{ $security_questions }}</option>
												
											@endforeach
										
										  @endif
									  
									</select>
									
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="secretanswer">Secret Answer</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="secretanswer" name="secretanswer" value="{{$borrowerdata->secretanswer}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="password">Password</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="password" name="password" value="" type="password">
								  </div>
								</div>
								@if($loggedinadminid==1)   
								<div class="form-actions">
								  <button type="submit" class="btn btn-primary">Save changes</button>
								</div>
								@endif
							  </fieldset>
							 @if($loggedinadminid==1)    
						    </form>
						    @else
						</div>
						    @endif
						  
						</div>
						
						<div id="payments" class="tab-pane fade">
						  <div class="form-horizontal">
							 <?php //echo "<pre>"; print_r($payments); echo "</pre>"; ?>
							  @if(count($payments))
								@foreach($payments as $kpay=>$payment)
									
									@php
										
										$loan_id = $kpay;	
										if($status=="breach_of_contract")
										   $status="Breach of contract";
										       
										
									@endphp
									
									<fieldset style="margin-bottom:30px;">
										<legend>Loan #: {{ $loan_id }} [ {{ ucfirst($status) }} ]</legend>
										
										@php
										
											$sl = 1; 
											$paydata = $payment;
											
										@endphp	
											
										<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" style="width:60%">
											<thead>
												<tr>
													<th style="width: 93px">#</th>
													<th style="width: 193px">Installment Amount</th>
													<th style="width: 193px">Installment Date (dd/mm/yyyy)</th>
													<th style="width: 100px">Paid (Y/N)</th>
													<th style="width: 93px">Default Interest ( % )</th>
													<th style="width: 93px">Unpaid Blance</th>
													<th style="width: 93px">Paid Blance</th>
													<th style="width: 93px">Late days</th>
												</tr>
											</thead>
											<tbody>
												
												@if(count($paydata))
													
													@php $sl = 1; @endphp
												
													@foreach($paydata as $pdata)
														
														@php
											
															$emi_amount = $pdata->emi_amount;
															$default_interest = $pdata->default_interest;
															$emi_date = date('d/m/Y',$pdata->emi_timestamp);
															$emi_paid = $pdata->emi_paid;

															if($pdata->emi_late_days)
																$emi_late_days = $pdata->emi_late_days;
															else
																$emi_late_days =0;

															if($pdata->paid_balance)
																$paid_balance = $pdata->paid_balance;
															else
																$paid_balance ="0.00";

															if($pdata->unpaid_balance)
																$unpaid_balance = $pdata->unpaid_balance;
															else
																$unpaid_balance ="0.00";
															
															switch($emi_paid){
																
																case "1":
																	$payclass = 'label-success';
																	$paytext = 'Paid';
																	break;
																case "0":
																	$payclass = 'label-warning';
																	$paytext = 'Due';
																	break;
															}
														
														@endphp
														
														<tr class="odd gradeX">
															<td>{{$sl}}</td>
															<td>&euro;{{$emi_amount}}</td>
															<td>{{$emi_date}}</td>
															<td class="center"><span class="label {{$payclass}}">{{$paytext}}</td>
															<td>{{$default_interest}}</td>
															<td>&euro;{{$unpaid_balance}}</td>
															<td>&euro;{{$paid_balance}}</td>
															<td>{{$emi_late_days}}</td>	

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
										
									  </fieldset>
									
									@endforeach
									
									@else
										
									<fieldset style="margin-bottom:30px;">
										<legend>No Records</legend>
									</fieldset>
							  
								@endif
						    </div>
						</div>
						
						<div id="notedetails" class="tab-pane fade">
						   @if($loggedinadminid==1)
						    <form class="form-horizontal" method="post" action="{{ URL::route('adminborrowerdetails', array('id'=>$id)) }}">
						   @else
						   	<div class="form-horizontal">
						   @endif
							  <input type="hidden" name="act" value="notedetails">
							  <input type="hidden" name="_token" value="{{ csrf_token() }}">
						   
							  <fieldset>
								<legend>Note</legend>
								
								<textarea class="input-xlarge focused" id="note" name="note">{{$borrowerdata->note}}</textarea>
								 @if($loggedinadminid==1) 
								<div class="form-actions">
								  <button type="submit" class="btn btn-primary">Save changes</button>
								</div>
								@endif
							  </fieldset>
							 @if($loggedinadminid==1) 
						    </form>
						  @else
						   	</div>
						   @endif
						</div>
						
					</div>
					
				</div>
			
			</div>
		</div>
		<!-- /block -->
	</div>
<!-- /wizard -->

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
	<script src="{{ URL::asset('public/backend/vendors/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ URL::asset('public/backend/vendors/ckeditor/adapters/jquery.js') }}"></script>
	
	<script>
	
	$(function() {
		$( 'textarea#note' ).ckeditor({width:'98%', height: '250px'});
	});
		
	</script>
	
	<script>
		
	$(function() {
		$(".uniform_on").uniform();
		$(".chzn-select").chosen();
		$(".datepicker").datepicker({
			format: 'dd/mm/yyyy',
		});
	});
	
	$('.delclassattachment').click(function(){
		
		var cnf = confirm("Are you sure to delete this attachment?");
		
		if(cnf){
			
			var dataid = $(this).attr('data-id');
		
			$('#frmattachment').find('input[name="act"]').val('attachmentdelete');
			$('#frmattachment').find('input[name="id"]').val(dataid);
			$('#frmattachment').submit();
		}
		
	});
	
	$('.updateattachment').click(function(){
		
		var dataloanid = $(this).attr('data-loanid');
		
		$('#frmattachment').find('input[name="act"]').val('attachmentupdate');
		$('#frmattachment').find('input[name="id"]').val(dataloanid);
		$('#frmattachment').submit();
		
	});
	
	var hashtag = window.location.hash;
	
	var hash = hashtag.substring(1);
	
	if(hash != ''){
		
		$('.borrowerdatatab a[href="#'+hash+'"]').click();
	}
	
	</script>
@stop
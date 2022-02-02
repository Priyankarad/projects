@if(!is_object($records))
   <h1>{{$records}}</h1>
@else

<div class="ajaxResponse">
<div class="navbar">
						
						<div class="navbar-inner">
						
							<div class="container">
							
								<ul class="nav nav-pills $recordstab">
									<li><a data-toggle="pill" href="#personaldetails">👤 Personal Details</a></li>
									<li><a data-toggle="pill" href="#riskscore">👤 Risk Score</a></li>
									<li><a data-toggle="pill" href="#employmentdetails">💼 Employment Details</a></li>
									<li><a data-toggle="pill" href="#addressdetails">🚩 Address Details</a></li>
									<li><a data-toggle="pill" href="#bankdetails">💶 Bank Details</a></li>
									<li><a data-toggle="pill" href="#attachments">📎 Attachments</a></li>
									<li><a data-toggle="pill" href="#documents">📋 Documents</a></li>
									<li><a data-toggle="pill" href="#accountrecovery">🔑 Account Recovery</a></li>
									<li class="active"><a data-toggle="pill" href="#payments">💳 Payments</a></li>
									<li><a data-toggle="pill" href="#notedetails">🖋️ Note</a></li>

								<!---	<li><a data-toggle="pill" href="#payments_registration">💳 Payment registration</a></li>-->
								</ul>
							
							</div>
							
						</div>
						
					</div>


<!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#paymentModal">
  Payment registration
</button>


<div class="modal fade" id="paymentModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form id="" action="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Manual payment registration</h4>
      </div>
      <div class="modal-body">

<div class="row form-group">
	<div class="col-md-5">
	  <p class="text-right"><label>payment date</label></p>
	</div>
	<div class="col-md-7">
	  <input type="text" name="" class="form-control" value="12.03.2018"/>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-5">
	  <p class="text-right"><label>Amount</label></p>
	</div>
	<div class="col-md-7">
	  <input type="text" name="" class="form-control" value="190.64"/>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-5">
	  <p class="text-right"><label>Manual payment registration reason</label></p>
	</div>
	<div class="col-md-7">
	  <textarea class="form-control" rows="5"></textarea>
	</div>
</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Register</button>
      </div>
  	</form>
    </div>
  </div>
</div> -->


<div class="tab-content">
					
						<div id="personaldetails" class="tab-pane fade">
						   
							  <fieldset>
								<legend>Personal Details</legend>
								
	

								<div class="control-group">
								  
								  <ul class="listBstW">
								  	<li class="row-fluid">
								  		<span class="span3"> <b>First Name</b></span>
								  		<span class="span4"><span>{{$records->firstname}}</span></span>
								  	</li>
					                <li class="row-fluid">
								  		<span class="span3"> <b>Surname</b></span>
								  		<span class="span4"><span>{{$records->surname}}</span></span>
								  	</li>
                                    <li class="row-fluid">
								  		<span class="span3"> <b>Date of Birth</b></span>
								  		<span class="span4"><span>{{$records->dob}}</span></span>
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span3"> <b>Username</b></span>
								  		<span class="span4"><span>{{$records->username}}</span></span>
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span3"> <b>Email Address</b></span>
								  		<span class="span4"><span>{{$records->emailaddress}}</span></span>
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span3"> <b>Contact Number</b></span>
								  		<span class="span4"><span>{{$records->cellphonenumber}}</span></span>
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span3"> <b>Alternate Number</b></span>
								  		<span class="span4"><span>{{$records->alternatenumber}}</span></span>
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span3"> <b>ID Number</b></span>
								  		<span class="span4"><span>{{$records->idnumber}}</span></span>
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span3"> <b>Status</b></span>
								  		<span class="span4">
								  			<label class="control-label">
								  		 @if(count($variables['status']))
														
													@foreach($variables['status'] as $key=>$status)
														@if($records->status == $key)
												 <strong>{{ $status }}</strong>
														@endif
													@endforeach
												
												  @endif

								  	     </label>
									  		
								  		</span>
								  	</li>

								  	<li class="row-fluid">
								  		<span class="span3"> <b>Marital Status</b></span>
								  		<label class="control-label">
								  		 @if(count($variables['marital_status']))
														
													@foreach($variables['marital_status'] as $key=>$marital_status)
														@if($records->maritalstatus == $key)
												 <strong>{{ $marital_status }}</strong>
														@endif
													@endforeach
												
												  @endif

								  	     </label>
								  		
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span3"> <b>No of Dependants</b></span>
								  		<span class="span4"><span>{{$records->noofdependants}}</span></span>
								  	</li>
				
								  </ul>
								</div>
							  </fieldset>
							  
						</div>
					
						<div id="employmentdetails" class="tab-pane fade">
						  
							  
							  <fieldset>
								<legend>Employment Details</legend>
								
								<div class="control-group">
								  <label class="control-label" for="employmenttype">Employment Type</label>
								  <div class="controls">
								  	<label class="control-label">
								  		 @if(count($variables['employment_status']))
												
											@foreach($variables['employment_status'] as $key=>$employment_status)
												@if($records->employmenttype == $key)
												 <strong>{{ $employment_status }}</strong>
												@endif
											@endforeach
										
										  @endif

								  	</label>
									
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="employercompanyname">Employer Company</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="employercompanyname" name="employercompanyname" value="{{$records->employercompanyname}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="grossmonthlyincome">Gross Monthly Income</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="grossmonthlyincome" name="grossmonthlyincome" value="{{$records->grossmonthlyincome}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="netmonthlyincome">Net Monthly Income</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="netmonthlyincome" name="netmonthlyincome" value="{{$records->netmonthlyincome}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="servicetype">Service Type</label>
								  <div class="controls">
								  	<label class="control-label">
								  		 @if(count($variables['service_type']))
												
											@foreach($variables['service_type'] as $key=>$service_type)
												@if($records->servicetype == $key)
												 <strong>{{ $service_type }}</strong>
												@endif
											@endforeach
										
										  @endif
								  		
								  	</label>
									
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="timewithemployer">Time with Employer (in Years)</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="timewithemployer" name="timewithemployer" value="{{$records->timewithemployer}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="workphonenumber">Work Phone Number</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="workphonenumber" name="workphonenumber" value="{{$records->workphonenumber}}" type="text">
								  </div>
								</div>
								
							  </fieldset>
							  
						    
						  
						</div>
						
						<div id="addressdetails" class="tab-pane fade">
						  
						  
							  <fieldset>
								<legend>Address Details</legend>
								
								<div class="control-group">
								  <label class="control-label" for="housenumber">House Number</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="housenumber" name="housenumber" value="{{$records->housenumber}}" type="text">
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="streetname">Street Name</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="streetname" name="streetname" value="{{$records->streetname}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="suburb">Suburb</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="suburb" name="suburb" value="{{$records->suburb}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="city">City</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="city" name="city" value="{{$records->city}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="province">Province</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="province" name="province" value="{{$records->province}}" type="text">
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="postcode">Postcode</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="postcode" name="postcode" value="{{$records->postcode}}" type="text">
								  </div>
								</div>
								
								
							  </fieldset>
							  
						  
						</div>
						
						<div id="bankdetails" class="tab-pane fade">
						  
							  <fieldset>
								<legend>Bank Details</legend>
								
								<div class="control-group">
								  <label class="control-label" for="bankname">Bank Name</label>
								  <div class="controls">
								  	<label class="control-label">
								  		<strong>{{ $records->bankname }}</strong>
								  	</label>
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="accountnumber">Account Number</label>
								  <div class="controls">
								  	<label class="control-label">
								  		<strong>{{ $records->accountnumber }}</strong>
								  	</label>
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="nameofaccountholder">Name of Account Holder</label>
								  <div class="controls">
								  	<label class="control-label">
								  		<strong>{{ $records->nameofaccountholder }}</strong>
								  	</label>
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="nameoncard">Name on Card</label>
								  <div class="controls">
								  	<label class="control-label">
								  		<strong>{{ $records->nameoncard }}</strong>
								  	</label>
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="cardnumber">Card Number</label>
								  <div class="controls">
								  	<label class="control-label">
								  		<strong>{{ $records->cardnumber }}</strong>
								  	</label>
									
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="expirymonth">Card Expiry Month</label>
								  <div class="controls">
								  	<label class="control-label">
								  		<strong>{{ $records->expirymonth }}</strong>
								  	</label>
									
								  </div>
								 
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="expiryyear">Card Expiry Year</label>
								  <div class="controls">
								  	<label class="control-label">
								  		<strong>{{ $records->expiryyear }} </strong>
								  	</label>
									
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="cvvnumber">Card CVV</label>
								  <div class="controls">
									<input class="input-xlarge focused" id="cvvnumber" name="cvvnumber" value="{{$records->cvvnumber}}" type="text">
								  </div>
								</div>
								
							  </fieldset>
							  
							
						</div>
						
						<div id="attachments" class="tab-pane fade">
						  
							  @if(count($attachments))
								  
								@foreach($attachments as $kattach=>$attachment)
									
									@php
										
										$loan_id = $kattach;										
										
									@endphp
									
									<fieldset style="margin-bottom:30px;">

										
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
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												
												@if(count($documents))
											
													@foreach($documents as $doc)
													    @if(!empty($doc))
														
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
															<td><a href="javascript:void(0);" class="delclassattachment" data-id="{{$doc->id}}"><input type="button" value="Delete" class="btn btn-danger"></a></td>
														</tr>
														
														@php $sl++ @endphp
														@endif
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
						
						
						<div id="documents" class="tab-pane fade">
						  
						  
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
							  
						  
						</div>
												
						<div id="accountrecovery" class="tab-pane fade">
						  <div class="form-horizontal">
						  
							  <fieldset>
								<legend>Account Recovery</legend>
								
								<div class="control-group">
								  <label class="control-label" for="secretquestion">Secret Question :</label>

								  <div class="controls">
								  	<label class="control-label" for="secretquestion">
								  		<strong>{{$records->secretquestion}}</strong>
								  	</label>
									
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="secretanswer">Secret Answer</label>
								  <div class="controls">
								  	<label class="control-label" for="secretquestion">
								  		<strong>{{$records->secretanswer}}</strong>
								  	</label>
									
								  </div>
								  
								</div>

								
							  </fieldset>
							  
						  </div>
						</div>
	
						
						<div id="payments" class="tab-pane fade in active">
							  
							  @if(count($payments))
								  
								@foreach($payments as $kpay=>$payment)
									
									@php
										
										$loan_id = $kpay;
										if($status=="breach_of_contract")
										   $status="Breach of contract";										
										
									@endphp
									
									<fieldset style="margin-bottom:30px;">
										@php
											if($records->loan_status=="breach_of_contract")
											    $records->loan_status="breach of contract";
										@endphp
										<legend>Loan #: {{ $loan_id }} [ {{ ucfirst($records->loan_status) }} ]</legend>
										
										@php
										
											$sl = 1; 
											$paydata = $payment;
											
										@endphp
											
										<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" style="width:60%">
											<thead>
												<tr>
													<th style="width: 25px">#</th>
													<th style="width: 70px">Installment Amount</th>
													<th style="width: 93px">Installment Date (dd/mm/yyyy)</th>
													<th style="width: 70px">Paid (Y/N)</th>
													<th style="width: 50px">Payment Status</th>
													<th style="width: 50px">Default Interest ( % )</th>
													<th style="width: 70px">Unpaid Balance</th>
													<th style="width: 70px">Paid Balance</th>
													<!---<th style="width: 70px">Manual Paid Amount</th>--->
													<th style="width: 67px">Late days</th>
													<th style="width: 67px">Paid date</th>
												</tr>
											</thead>
											<tbody>
												
												@if(count($paydata))
													
													@php $sl = 1; @endphp
												
													@foreach($paydata as $pdata)
														
														@php
											
															$emi_amount = $pdata->emi_amount;
															$emi_date = date('d/m/Y',$pdata->emi_timestamp);
															$emi_paid = $pdata->emi_paid;
															$default_interest = $pdata->default_interest;

															if($pdata->manual_paid_amount!=NULL)
																$manual_paid_amount = $pdata->manual_paid_amount;
															else 
																$manual_paid_amount ="";

															if($pdata->emi_paid_date!=NULL)
																$emi_paid_date = date("m/d/Y",$pdata->emi_paid_date);
															else 
																$emi_paid_date ="";

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
															
														
															$payment_staus=$pdata->payment_status;
															switch($emi_paid){
																
																case "1":
																	$payclass = 'label-success';
																	$paytext = 'Yes';
																	break;
																case "0":
																	$payclass = 'label-warning';
																	$paytext = 'No';
																	break;
															}


															 switch ($payment_staus) {

															    case $payment_staus == '':
																    $payment_staus1 = 'fgfdgfdgdg';
																        break;


																    case $payment_staus == 'on_due':
																    $payment_staus1 = 'on due';
																        break;

																    case  $payment_staus == 'paid':
																    $payment_staus1 = 'paid';
																        break;

																    case  $payment_staus == 'overdue_default':
																    $payment_staus1 = 'Overdue(default)';
																        break;

																    case $payment_staus == 'arrears':
																    		$payment_staus1 = 'Arrears less 3 months overdue';
																        break;    

																    case  $payment_staus == 'breach_of_contract':
																    		$payment_staus1 = 'Breach of contract + 3 months overdue';
																        break;    

																    default:
																        $payment_staus1 = "";
																        break;
																}
														
														@endphp
														
														<tr class="odd gradeX">
															<td>{{$sl}}</td>
															<td>{{'&euro; '.$emi_amount}}</td>
															<td>{{$emi_date}}</td>
															<td class="center"><span class="label {{$payclass}}">{{$paytext}}</td>
															<td>@if($payment_staus){{$payment_staus1}} @endif</td>								
															<td>{{$default_interest}}</td>
															<td>{{$unpaid_balance}}</td>
															<td>{{$paid_balance}}</td>
															<!----<td>{{$manual_paid_amount}}</td>--->
															<td>{{$emi_late_days}}</td>	
															<td>{{$emi_paid_date}}</td>	
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


						<div id="riskscore" class="tab-pane fade">
							<ul class="listBstW">
								@if(!empty($records))
								  	<li class="row-fluid">
								  		<span class="span4"><b>Debt recovery companies queries</b></span>
								  		<span class="span4"><span>
								  			@if($records->debt_recovery_companies_queries!=NULL)
								  				{{$records->debt_recovery_companies_queries}}
								  			@endif
									  		</span>
									  	</span>
								  	</li>
					                <li class="row-fluid">
								  		<span class="span4"> <b>Default probability</b></span>
								  		<span class="span4"><span>
											@if($records->default_probability!=NULL)
								  				{{$records->default_probability}}
								  			@endif
								  		</span></span>
								  	</li>
                                    <li class="row-fluid">
								  		<span class="span4"> <b>Familiar help probability</b></span>
								  		<span class="span4"><span>
								  			@if($records->familiar_help_probability!=NULL)
								  				{{$records->familiar_help_probability}}
								  			@endif

								  		</span></span>
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span4"><b>Scoring numeric</b></span>
								  		<span class="span4"><span>
								  			@if($records->scoring_numeric!=NULL)
								  				{{$records->scoring_numeric}}
								  			@endif
								  		</span></span>
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span4"> <b>Credit companies queries</b></span>
								  		<span class="span4"><span>
								  			@if($records->credit_companies_queries!=NULL)
								  				{{$records->credit_companies_queries}}
								  			@endif
								  		</span></span>
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span4"> <b>Phone contact probability</b></span>
								  		<span class="span4"><span>
								  			
								  			@if($records->phone_contact_probability!=NULL)
								  				{{$records->phone_contact_probability}}
								  			@endif
								  		</span></span>
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span4"><b>Last address stay duration</b></span>
								  		<span class="span4"><span>
								  			@if($records->last_address_stay_duration!=NULL)
								  				{{$records->last_address_stay_duration}}
								  			@endif
								  		</span>
								  	</span>
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span4"> <b>Scoring</b></span>
								  		<span class="span4"><span>
								  			@if($records->scoring!=NULL)
								  				{{$records->scoring}}
								  			@endif
								  		</span></span>
								  	</li>
								  	<li class="row-fluid">
								  		<span class="span4"><b>Known addresses</b></span>
								  		<span class="span4"><span>
								  			@if($records->known_addresses!=NULL)
								  				{{$records->known_addresses}}
								  			@endif
								  		</span></span>
								  	</li>
								  	@else
								  		<li class="row-fluid"><span class="span3"><b>Data not Found</b></span>
								  		</span></li>
									@endif
								  </ul>
							
						</div>
						
						<div id="notedetails" class="tab-pane fade">
						  
						    
							  <fieldset>
								<legend>Note</legend>
								
								{{$records->note}}
								
							  </fieldset>
							  
						  
						</div>

					</div>
				</div>

				<style type="text/css">
					.datepicker {
						    z-index: 100000;
						}
					.navbar-fixed-top, .navbar-fixed-bottom{
						z-index: 10301;
					}	
					.formerrors{
						padding: 20px;
					}
				</style>
<script type="text/javascript">
	jQuery(function() {
		  var datepicker = $('#myModal .datepicker');

		  if (datepicker.length > 0) {
		    datepicker.datepicker({
		      format: "mm/dd/yyyy",
		      startDate: new Date()
		    });
		  }
	});
	    

	/*$("#manual_payment_register").on("submit",function(e){
		$(".formerrors").html("");
		e.preventDefault();
		$("#manual_payment_register .loadingImage").show();
		$.ajax({
	            type: "POST",
	            url:'{{ URL::route("savemanualpayment") }}',
	            data: $(this).serialize(),
	            success: function(response) {
	            	
	            	$("#manual_payment_register .loadingImage").hide();
	            	if(response.result==1){
	            		$('#manual_payment_register')[0].reset();
	                	$(".manual_payment_html").html(response.html);
	                	$(".formerrors").html("Manual payment added successfully.");
	                	$("#myModal #modal-content").scrollTop(0);
	            	}else if(response.result==0){
	            		var errors="";
	            		$.each($(response.html), function(index, val){
	            			errors +="<p>"+val+"</p>";
						});
	            		$(".formerrors").css({"color":"red"}).html(errors);
	            		$("#myModal #modal-content").scrollTop(0);
	            		
	            	}
	            },
	            error: function(){

	            }
	        });
	})

	*/
</script>
@endif
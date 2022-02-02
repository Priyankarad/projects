@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
		<?php //echo '<pre>'; print_r($recorddetails);echo '</pre>'; ?>
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
					<div class="span12">
						@if(!empty($recorddetails))
						<div class="span12"><h3>Borrower basic info</h3></div>
						<div class="span6">
							<ul class="listBstW">
								<li class="row-fluid">
							  		<span class="span4">First Name</b></span>
							  		<span class="span4"><span>{{ $recorddetails->firstname or ''}}</span>
								  	</span>
							  	</li>

							  	<li class="row-fluid">
							  		<span class="span4">Surname</b></span>
							  		<span class="span4"><span>{{ $recorddetails->surname or ''}}</span>
								  	</span>
							  	</li>

							  	<li class="row-fluid">
							  		<span class="span4">DNI/Number</b></span>
							  		<span class="span4"><span>{{ $recorddetails->idnumber or '' }}</span>
								  	</span>
							  	</li>


							  	<li class="row-fluid">
							  		<span class="span4">Date of birth</b></span>
							  		<span class="span4"><span>@if(!empty($recorddetails->dob)) {{ date("d M , Y",strtotime($recorddetails->dob)) }} @else '' @endif</span>
								  	</span>
							  	</li>

							  	<li class="row-fluid">
							  		<span class="span4">Cell number</b></span>
							  		<span class="span4"><span>{{ $recorddetails->cellphonenumber or '' }}</span>
								  	</span>
							  	</li>

							</ul>
						</div>
						<div class="span6">
							<h3></h3>
							<ul class="listBstW">
				
								  	<li class="row-fluid">
								  		<span class="span4">Email</b></span>
								  		<span class="span4"><span>{{ $recorddetails->emailaddress or ''}}</span>
									  	</span>
								  	</li>

								  	<li class="row-fluid">
								  		<span class="span4">City</b></span>
								  		<span class="span4"><span>{{ $recorddetails->city or ''}}</span>
									  	</span>
								  	</li>

								  	<li class="row-fluid">
								  		<span class="span4">Province</b></span>
								  		<span class="span4"><span>{{ $recorddetails->province or ''}}</span>
									  	</span>
								  	</li>

								  	<li class="row-fluid">
								  		<span class="span4">Postcode</b></span>
								  		<span class="span4"><span>{{ $recorddetails->postcode or ''}}</span>
									  	</span>
								  	</li>


								</ul>
						</div>
			</div>
<div class="span12">
	
					<div class="span6">
						<h3>Business rules</h3>
						@if(!empty($recorddetails->noofdependants))
							@if($recorddetails->noofdependants > 3)
								@php
									$noofdependants = 0;
								@endphp
							@else
							    @php
									$noofdependants = 2;
								@endphp
							@endif			
						@endif
						<ul class="listBstW">
							<li class="row-fluid">
						  		<span class="span7">Service Value <b>( {{ $recorddetails->servicename or ''}} )</b></span>
						  		<span class="span4"><span>{{ $recorddetails->servicebusinessrule or ''}}</span>
							  	</span>
						  	</li>
			                <li class="row-fluid">
						  		<span class="span7">Residential Value<b> ( {{ $recorddetails->residetialname or ''}} )</b></span>
						  		<span class="span4"><span>{{ $recorddetails->livingstatus or ''}}</span></span>
						  	</li>
                            <li class="row-fluid">
						  		<span class="span7">No. of independents Value<b> ( {{ $recorddetails->noofdependants or 0}} Dependents )</b></span>
						  		<span class="span4">{{ $noofdependants or 0 }} <span>
						  			
						  		</span></span>
						  	</li>
						  	<li class="row-fluid">
						  		<span class="span7">Maritial Value<b> ( {{ $recorddetails->maritialtname or ''}} )</b></span>
						  		<span class="span4"><span>{{ $recorddetails->maritialtbusinessrule or ''}}</span></span>
						  	</li>
						  	<li class="row-fluid">
						  		<span class="span7">Employment Value  <b>( {{ $recorddetails->employmentname or ''}} )</b></span>
						  		<span class="span4"><span>{{ $recorddetails->employmentbusinessrule or ''}}</span></span>
						  	</li>
						  	<!---<li class="row-fluid">
						  		<span class="span4"> <b>Phone contact probability</b></span>
						  		<span class="span4"><span></span></span>
						  	</li>
						  	<li class="row-fluid">
						  		<span class="span4"><b>Last address stay duration</b></span>
						  		<span class="span4"><span></span>
						  	</span>
						  	</li>
						  	<li class="row-fluid">
						  		<span class="span4"> <b>Scoring</b></span>
						  		<span class="span4"><span></span></span>
						  	</li>
						  	<li class="row-fluid">
						  		<span class="span4"><b>Known addresses</b></span>
						  		<span class="span4"><span></span></span>
						  	</li>--->
						</ul>
					</div>
				<div class="span6">
					<h3>Incofisa rules</h3>
					<ul class="listBstW">
							<li class="row-fluid">
						  		<span class="span4"><b>Service Value</b></span>
						  		<span class="span4"><span>{{ $recorddetails->debt_recovery_companies_queries}}</span>
							  	</span>
						  	</li>
			                <li class="row-fluid">
						  		<span class="span4"> <b>Default probability</b></span>
						  		<span class="span4"><span>{{ $recorddetails->default_probability}}</span></span>
						  	</li>
                            <li class="row-fluid">
						  		<span class="span4"> <b>Familiar help probability</b></span>
						  		<span class="span4"><span>
						  			{{ $recorddetails->familiar_help_probability}}
						  		</span></span>
						  	</li>
						  	<li class="row-fluid">
						  		<span class="span4"><b>Scoring numeric</b></span>
						  		<span class="span4"><span>{{ $recorddetails->scoring_numeric}}</span></span>
						  	</li>
						  	<li class="row-fluid">
						  		<span class="span4"> <b>Credit companies queries</b></span>
						  		<span class="span4"><span>{{ $recorddetails->credit_companies_queries}}</span></span>
						  	</li>
						  	<li class="row-fluid">
						  		<span class="span4"> <b>Phone contact probability</b></span>
						  		<span class="span4"><span>{{ $recorddetails->phone_contact_probability}}</span></span>
						  	</li>
						  	<li class="row-fluid">
						  		<span class="span4"><b>Last address stay duration</b></span>
						  		<span class="span4"><span>{{ $recorddetails->last_address_stay_duration}}</span>
						  	</span>
						  	</li>
						  	<li class="row-fluid">
						  		<span class="span4"> <b>Scoring</b></span>
						  		<span class="span4"><span>{{ $recorddetails->scoring}}</span></span>
						  	</li>
						  	<li class="row-fluid">
						  		<span class="span4"><b>Known addresses</b></span>
						  		<span class="span4"><span>{{ $recorddetails->known_addresses}}</span></span>
						  	</li>
						</ul>
				</div>
					</div>
					@endif	
					
					 @if($loggedinadminid==1)   
					<form class="form-horizontal frmloanaddedit" name="frmaddedit" action="" method="post" enctype="multipart/form-data">

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
						  <label class="control-label" for="borrower_id">Borrower </label>
						  <div class="controls">
							<select id="borrower_id" name="borrower_id" class="chzn-select">
							  <option value="">Choose</option>
							  
								  @if(count($borrowers))
										
									@foreach($borrowers as $borrower)
										
										@php
											
											$borrower_name = ucwords($borrower->firstname.' '.$borrower->surname);
											
										@endphp
										
										<option value="{{ $borrower->id }}" {{ isset($recorddetails->borrower_id) ? ($borrower->id == $recorddetails->borrower_id ? 'selected' : '') : '' }} >{{ $borrower_name }}</option>
										
									@endforeach
								
								  @endif
							  
							</select>
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="loan_amount">Loan Amount</label>
						  <div class="controls">
							<input type="text" class="span6" name="loan_amount" id="loan_amount" value="{{$recorddetails->loan_amount or ''}}">
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="loan_terms">Loan Terms </label>
						  <div class="controls">
							<select id="loan_terms" name="loan_terms" class="chzn-select">
							  <option value="">Choose</option>
							  
								  @if(count($terms))
										
									@foreach($terms as $term)
										
										<option value="{{ $term }}" {{ isset($recorddetails->loan_terms) ? ($term == $recorddetails->loan_terms ? 'selected' : '') : '' }} >{{ $term }} months</option>
										
									@endforeach
								
								  @endif
							  
							</select>
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="loan_apr">Loan APR (%) </label>
						  <div class="controls">
							<input type="text" class="span6" name="loan_apr" id="loan_apr" value="{{$recorddetails->loan_apr or ''}}">
						  </div>
						</div>
						
						
						<div class="control-group">
						  <label class="control-label" for="merchant_id">Merchant </label>
						  <div class="controls">
							<select id="merchant_id" name="merchant_id" class="chzn-select">
							  <option value="">Choose</option>
							  
								  @if(count($merchants))
										
									@foreach($merchants as $merchant)
										@if($merchant->merchant_cif)
										@php
											    $merchant_name = ucwords($merchant->merchant_name.' [ ID: '.$merchant->merchant_cif.' ]');
										@endphp
										@else
										@php
												$merchant_name = ucwords($merchant->merchant_name.' [ ID: '.$merchant->merchant_nie.' ]');
										@endphp

										@endif
										
	<option value="{{ $merchant->id }}" {{ isset($recorddetails->merchant_id) ? ($merchant->id == $recorddetails->merchant_id ? 'selected' : '') : '' }} >{{ $merchant_name }}</option>
										
									@endforeach
								
								  @endif
							  
							</select>
						  </div>
						</div>
						
						
						<div class="control-group">
						  <label class="control-label" for="product_name">Product Name </label>
						  <div class="controls">
							<input type="text" class="span6" name="product_name" id="product_name" value="{{$recorddetails->product_name or ''}}">
						  </div>
						</div>
						
						
						<div class="control-group">
						  <label class="control-label" for="lastpayslip">Last Payslip</label>
						  <div class="controls">
							<input class="input-file uniform_on" name="lastpayslip" type="file">
							
							@php
								
								$lastpayslip = isset($recorddetails->attachments['lastpayslip']) ? $recorddetails->attachments['lastpayslip'] : '';
								
							@endphp
							
							@if($lastpayslip)
								
								<a href="{{URL::asset('userfiles/'.$lastpayslip)}}" target="_blank">📎 Last Payslip</a>
							
							@endif
							
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="bankcertificate">Bank Certificate</label>
						  <div class="controls">
							<input class="input-file uniform_on" name="bankcertificate" type="file">
							
							@php
								
								$bankcertificate = isset($recorddetails->attachments['bankcertificate']) ? $recorddetails->attachments['bankcertificate'] : '';
								
							@endphp
							
							@if($bankcertificate)
								
								<a href="{{URL::asset('userfiles/'.$bankcertificate)}}" target="_blank">📎 Bank Certificate</a>
							
							@endif
							
						  </div>
						</div>

						<div class="control-group">
						  <label class="control-label" for="Invoice">Invoice</label>
						  <div class="controls">
							
							@php
								
								$file = isset($recorddetails->upload_invoice) ? $recorddetails->upload_invoice : '';
								
							@endphp
							
							@if($file)
								
								<a href="{{ URL::route('adminloanapplicationmodify', array('file'=>$file,'mode'=>'edit','id'=>8)) }}">Download Invoice</a>
							
							@endif
							
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="idproof">ID Proof</label>
						  <div class="controls">
							<input class="input-file uniform_on" name="idproof" type="file">
							
							@php
								
								$idproof = isset($recorddetails->attachments['idproof']) ? $recorddetails->attachments['idproof'] : '';
								
							@endphp
							
							@if($idproof)
								
								<a href="{{URL::asset('userfiles/'.$idproof)}}" target="_blank">📎 ID Proof</a>
							
							@endif
							
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label" for="budgetattachment">Budget Attachment</label>
						  <div class="controls">
							<input class="input-file uniform_on" name="budgetattachment" type="file">
							
							@php
								
								$budgetattachment = isset($recorddetails->attachments['budgetattachment']) ? $recorddetails->attachments['budgetattachment'] : '';
								
							@endphp
							
							@if($budgetattachment)
								
								<a href="{{URL::asset('userfiles/'.$budgetattachment)}}" target="_blank">📎 Budget Attachment</a>
							
							@endif
							
						  </div>
						</div>
						<!---- Pixlr ---->
						@if($mode == 'edit' && $recorddetails->status == 'approved')
						<div class="control-group">
						  <label class="control-label" for="payment_sent">Payment Sent</label>
						  <div class="controls">
							<select id="payment_sent" name="payment_sent" class="chzn-select">
							  <option value="">Select option</option>
							  <option {{ isset($recorddetails->payment_sent) ? ($recorddetails->payment_sent == "yes" ? 'selected' : '') : '' }} value="yes">Yes</option>
							  <option {{ isset($recorddetails->payment_sent) ? ($recorddetails->payment_sent == "no" ? 'selected' : '') : '' }} value="no">No</option>
								 
							</select>
						  </div>
						</div>
						@else
						<input name="payment_sent" type="hidden" value="{{$recorddetails->payment_sent or ''}}" />

						@endif
						<div class="control-group">
						  <label class="control-label" for="status">Pending to be paid </label>
						  <div class="controls">
							  <textarea name="pending_to_be_paid">{{$recorddetails->pending_to_be_paid or ''}}</textarea>
						  </div>
						</div>

						<div class="control-group" >
						    <label class="control-label" for="status">Amount transfer or not</label>
						    <div class="controls">
								  	<label class="radio-inline" for="Smale">
								  		<input disabled="" type="radio" name="checkmoneyout" {{ (isset($recorddetails->checkmoneyout) && $recorddetails->checkmoneyout==$recorddetails->loan_id) ? 'checked' : '' }}>Yes
								    </label>
								    <label  class="radio-inline" for="SFemale">
								  		<input disabled="" type="radio" name="checkmoneyout" {{ empty($recorddetails->checkmoneyout) ? 'checked' : '' }}>No
								    </label>
							</div>
						</div>

						<!---- Pixlr ---->

						@if($mode == 'edit' && $recorddetails->status == 'pending')
						
						<div class="control-group">
						  <label class="control-label" for="status">Status </label>
						  <div class="controls">
							<select id="status" name="status" class="chzn-select">
							  <option value="">Choose</option>
							  
								  @if(count($statusarr))
										
									@foreach($statusarr as $kstat=>$status)
										
										<option value="{{ $kstat }}" {{ isset($recorddetails->status) ? ($status == $recorddetails->status ? 'selected' : '') : '' }} >{{ $status }}</option>
										
									@endforeach
								
								  @endif
							  
							</select>
						  </div>
						</div>
						@else
<input name="status" type="hidden" value="{{$recorddetails->status or ''}}" />

						@endif
						@if($loggedinadminid==1) 
						<div class="form-actions">
						  <button type="button" class="btn btn-primary loanappedit">{{ $mode == 'add' ? 'Add' : 'Update' }}</button>
						  <button type="reset" class="btn" onclick="location.href='{{ URL::route('adminloanapplication', array('type'=>'pending')) }}'">Cancel</button>
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
	
	<script>
		
	$(function() {
		$(".uniform_on").uniform();
		$(".chzn-select").chosen();
	});
	
		
	$(document).ready(function(){
		
		$('.loanappedit').click(function(){
			
			@if($mode == 'edit')
			
			var cnf = confirm("Are you sure?");
			
			if(cnf){
				
				$(this).html('Please wait...');
				setTimeout(function(){
					$('.loanappedit').prop('disabled',true);
				},50);
				
				$('.frmloanaddedit').submit();
			}	
			
			@else
			
			$(this).html('Please wait...');
			setTimeout(function(){
				$('.loanappedit').prop('disabled',true);
			},50);
			$('.frmloanaddedit').submit();

			@endif
			
		});
		
	});
	
	</script>

@stop
@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	<div class="row-fluid">
		<!-- block -->
		
		<div class="span5">
			
			<div class="block Smt-10">
		
				<div class="navbar navbar-inner block-header">
					<div class="muted pull-left">🔎 Search Panel</div>
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
						<!-----
						<form class="form-horizontal" name="frmaddedit" action="" method="post" enctype="multipart/form-data">
						
						  <input type="hidden" name="act" value="search">
						  <input type="hidden" name="_token" value="{{ csrf_token() }}">
						  
						  <fieldset>
							
							<div class="control-group">
							  <label class="control-label" for="loan_unique_id"># Loan ID</label>
							  <div class="controls">
								<input type="text" class="span6" name="id" id="loan_unique_id" value="{{$loan_unique_id or ''}}">
							  </div>
							</div>
							
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Search</button>
							  <button type="reset" class="btn" onclick="location.href='{{ URL::route('adminloanpayments') }}'">Cancel</button>
							</div>
							
						  </fieldset>
						</form>
---->
						@if(isset($approved_loans) && count($approved_loans) > 0)
						<table border="0" cellspacing="5" cellpadding="5">
						        <tbody>
						        	<td><strong>Search Status</strong></td>
						        	<td>
						           <select id="filterDays">
						           	    <option value="">Select days</option>
							           	<option min="0" value="0">Default status</option>
							           	<option min="1" value="7">Default loan D+7</option>
							           	<option min="8" value="15">Default loan D+15</option>
							           	<option min="16" value="30">Default + 1 intalment (30 days)</option>
							           	<option min="31" value="60">Default +2 instalment (60days)</option>
							           	<option min="61" value="89">Default + 3 instalment (90days)</option>
							           	<option min="90" value="360">BREACH OF CONTRACT</option>
						           </select>
						       </td>
						    </tbody>
						</table>

        					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatable_smartcredit filter_table">

								<thead>
									<tr>
										<th>ID</th>
										<th>Borrower Name</th>
										<th>Loan Term</th>
										<th>Loan Amount</th>
										<th>Outst. Balance</th>
										<th>Days past due</th>
										<th>Next action date</th>
									</tr>
								</thead>
								<tbody>

										@php $sl = 1; @endphp
										@foreach($approved_loans as $loans_record)
											
											@php
											
												$id = $loans_record->unique_id;
												$borrower_name=$loans_record->firstname." ".$loans_record->surname;

												if(isset($loans_record->next_payment_date) && !empty ($loans_record->next_payment_date))
												   $next_payment_date=date("d-M-Y",$loans_record->next_payment_date);
												else  
												   $next_payment_date=0;

												if(isset($loans_record->total_debit_amount) &&  !empty ($loans_record->total_debit_amount))
												   $total_debit_amount=$loans_record->total_debit_amount;
												else  
												   $total_debit_amount=0;


												if(isset($loans_record->total_past_days) && !empty ($loans_record->total_past_days))
												   $total_past_days=$loans_record->total_past_days;
												else  
												   $total_past_days=0;
												
											@endphp
											
											<tr class="odd gradeX">
												<td>{{$id}}</td>
												<td>{{$borrower_name}}</td>
												<td>{{$loans_record->loan_terms}}</td>
												<td>{{$loans_record->loan_amount}}</td>
												<td>{{ $total_debit_amount }}</td>
												<td>{{ $total_past_days }}</td>
												<td>{{ $next_payment_date }}</td>
											</tr>
											
											@php $sl++ @endphp
										
										@endforeach
									
								</tbody>
								<!----<tfoot>
								            <tr>
								                <th>ID</th>
												<th>Name</th>
												<th>Outst. Balance</th>
												<th>Days past due</th>
												<th>Next action date</th>
								            </tr>
								        </tfoot>--->
							</table>
							@endif
						@if(!empty($loandetails))
						
						@php
							
							$loan_id = $loandetails->unique_id;
							$loan_amount = &euro;$loandetails->loan_amount;
							$loan_terms = $loandetails->loan_terms.' months';
							$loan_apr = $loandetails->loan_apr.'%';
							$loan_date = date('d/m/Y',$loandetails->createdate);
							$loan_status = ucfirst($loandetails->status);
							$loan_borrower = ucfirst($loandetails->firstname.' '.$loandetails->surname);
							$borrower_id = $loandetails->borrower_id;
							
						@endphp
						
						<div class="alert alert-info alert-block">
							
							<ul style="list-style:none; margin-left:0">
								<li><strong>Loan ID: </strong><span>{{$loan_id}}</span></li>
								<li><strong>Loan Amount: </strong><span>{{$loan_amount}}</span></li>
								<li><strong>Borrower: </strong><span><a href="{{ URL::route('adminborrowerdetails',array('id'=>$borrower_id)) }}">{{$loan_borrower}}</a></span></li>
								<li><strong>Terms: </strong><span>{{$loan_terms}}</span></li>
								<li><strong>APR: </strong><span>{{$loan_apr}}</span></li>
								<li><strong>Applied On: </strong><span>{{$loan_date}}</span></li>
								<li><strong>Current Status: </strong><span>{{$loan_status}}</span></li>
							</ul>
							
						</div>

						<div class="alert alert-info alert-block">
							
							<ul style="list-style:none; margin-left:0">
								<li><strong>Bank Name: </strong><span>{{$loandetails->bankname}}</span></li>
								<li><strong>Bank Account No.: {{$loandetails->accountnumber}}</strong><span></span></li>
								<li><strong>Account Holder:</strong> {{$loandetails->nameofaccountholder}}<span></span></li>
								<li><strong>IBAN Number: </strong><span>{{$loandetails->ibannumber}}</span></li>
								<li><strong>Bank Branch Name: </strong><span>{{$loandetails->bank_branch}}</span></li>
								<li><strong>Bank Branch Street: {{$loandetails->street_bank_branch}}</strong><span></span></li>
								
							</ul>
							
						</div>
						@endif

						

					</div>
				</div>
				
			</div>
			<!-- /block -->
			
		</div>
		<img class="loadingImage" style="display: none;" src="{{URL::asset('public/backend/images/page-loading-gif-3.gif')}}"/>
		<div class="span7 loanPayments">
			
			@if(count($records) > 0)
			<div class="block">
		
				<div class="navbar navbar-inner block-header">
					<div class="muted pull-left">💳 {{$sectionname}}</div>
				</div>
				
				<div class="block-content collapse in">
				
					<div class="span12">
						
						@php

						$flashdata = Session::get('action');
						
						@endphp
						
						@if($flashdata == 'updated')
						
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert">×</button>
								<strong>Success!</strong> Record updated successfully
							</div>
							
						@elseif($flashdata == 'closed')
						
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert">×</button>
								<strong>Success!</strong> Loan account closed successfully
							</div>
						
						@endif						
						
						<form class="form-horizontal" name="frmlisting" id="frmlisting" action="" method="post" enctype="multipart/form-data">
							
							<input type="hidden" name="act" value="">
							<input type="hidden" name="id" value="{{$loan_unique_id}}">
							<input type="hidden" name="loan_id" value="{{$loanid}}">
							<input type="hidden" name="emi_id" value="">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						  
							<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
								<thead>
									<tr>
										<th>#</th>
										<th>Installment Amount</th>
										<th>Installment Date (dd/mm/yyyy)</th>
										<th>Default Interest ( % )</th>
										<th>Unpaid Blance</th>
										<th>Paid Blance</th>
										<th>Late days</th>
									</tr>
								</thead>
								<tbody>
									
										
										@php $sl = 1; @endphp
									
										@foreach($records as $record)
											
											@php
											
												$id = $record->id;
												$emi_amount = $record->emi_amount;
												$emi_date = date('d/m/Y',$record->emi_timestamp);
												$emi_paid = $record->emi_paid;
												
												$checkedClass = $emi_paid == '1' ? 'checked disabled' : '';

												if($record->default_interest)
													$default_interest = $record->default_interest;
												else
													$default_interest =0;

												if($record->emi_late_days)
													$emi_late_days = $record->emi_late_days;
												else
													$emi_late_days =0;

												if($record->paid_balance)
													$paid_balance = $record->paid_balance;
												else
													$paid_balance ="0.00";

												if($record->unpaid_balance)
													$unpaid_balance = $record->unpaid_balance;
												else
													$unpaid_balance ="0.00";
												
											@endphp
											
											<tr class="odd gradeX">
												<td>{{$sl}}</td>
												<td>&euro;{{$emi_amount}}</td>
												<td>{{$emi_date}}</td>
												<td>{{$default_interest}}</td>
												<td>{{$unpaid_balance}}</td>
												<td>{{$paid_balance}}</td>
												<td>{{$emi_late_days}}</td>	
											</tr>
											
											@php $sl++ @endphp
										
										@endforeach
									<!--<td><input type="checkbox" class="installmentpaid" value="{{$id}}" {{$checkedClass}}></td>---->
								</tbody>
							</table>
							<!-----
							<div style="margin:30px 0 0 0">
							  
								@if($all_install_cleared == '1' && $loan_closed == '0')
								
									<button type="button" class="btn btn-success closeloanaccount">Close Loan Account</button>
									
								@elseif($loan_closed == '1')
								
									<button type="button" class="btn btn-success closeloanaccount" disabled>Close Loan Account</button>
									
								@else
									
									<button type="button" class="btn btn-success closeloanaccount" disabled>Close Loan Account</button>
								
								@endif						  
							  
							</div>---->
							
						</form>
						
					</div>
					
				</div>

			</div>
			@endif
			<!-- /block -->
			
		</div>
		
	</div>

@stop


@section('stylesheets')
	<!---<link href="{{ URL::asset('public/backend/bootstrapswitch/bootstrap-switch.min.css') }}" rel="stylesheet" media="screen">--->
	<link href="{{ URL::asset('public/backend/vendors/datepicker.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('scripts')
	<script src="{{ URL::asset('public/backend/bootstrapswitch/bootstrap-switch.min.js') }}"></script>
	<script src="{{ URL::asset('public/backend/vendors/bootstrap-datepicker.js') }}"></script>				
	
	<script>
		
	$(document).ready(function(){
	/*	
		$(".installmentpaid").bootstrapSwitch({
			onText: 'Yes',
			offText: 'No',
			onColor: 'success',
			offColor: 'danger'
		});
		
		$('.installmentpaid').on('switchChange.bootstrapSwitch', function(event, state) {
			
			//console.log(this); // DOM element
			//console.log(event); // jQuery event
			console.log(state); // true | false
			
			var attrid = $(this).val();
			
			if(state){
				
				var cnf = confirm("Are you sure to mark this installment paid? This process can't be undone.");
				
				if(cnf){
					
					//$('.installmentpaid[value="'+ attrid +'"]').bootstrapSwitch('disabled', true, true);
					
					$('#frmlisting').find('input[name="act"]').val('markpaid');
					$('#frmlisting').find('input[name="emi_id"]').val(attrid);
					$('#frmlisting').submit();
				}
				else{
					
					$('.installmentpaid').bootstrapSwitch('state', false, true);
				}
			}
			
		});*/
		
		/*$('.closeloanaccount').click(function(){
			
			var cnf = confirm("Are you sure to close this loan account? This process can't be undone.");
				
			if(cnf){
				
				$('#frmlisting').find('input[name="act"]').val('markclose');
				$('#frmlisting').submit();
			}
			
		});*/
		
		/*$(".datatable_smartcredit tbody tr").on("click",function(){
			$(".ajaxResponse").html("");
			$(".datatable_smartcredit tbody td").css({"background": "transparent"});
			$(this).find('td').css({"background": "#b8c0ca"});
			$(".loadingImage").show();
			$.ajax({
		            type: "POST",
		            url:'{{ URL::route("getLoandetails") }}',
		            data: {_token: "{{ csrf_token() }}",loan_id: $(this).find("td:first-child").text()},
		            success: function(msg) {
		            	$(".loadingImage").hide();
		                $(".loanPayments").html(msg);

		            },
		            error: function(){

		            }
		        });
		})*/
		
	});
	$(document).on("click",".datatable_smartcredit tbody tr",function(){
			$(".ajaxResponse").html("");
			$(".datatable_smartcredit tbody td").css({"background": "transparent"});
			$(this).find('td').css({"background": "#b8c0ca"});
			$(".loadingImage").show();
			$.ajax({
		            type: "POST",
		            url:'{{ URL::route("getLoandetails") }}',
		            data: {_token: "{{ csrf_token() }}",loan_id: $(this).find("td:first-child").text()},
		            success: function(msg) {
		            	$(".loadingImage").hide();
		                $(".loanPayments").html(msg);

		            },
		            error: function(errorThrown){
		            	alert("There is some error.Try again.");
		            }
		        });
		});
	
	</script>
@stop
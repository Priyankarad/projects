@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	<div class="row-fluid">
		
			<div class="block">
		
				<div class="navbar navbar-inner block-header">
					<div class="muted pull-left">
						<p><strong>{{$sectionname}}</strong></p>
						<p><strong>{{$total_investors}}</strong></p>
						<p><strong>{{$total_funded_amount}}</strong></p>
						<p><strong>{{$loan_amount}}</strong></p>
					</div>
					<div class="muted pull-right">
						<a class="btn btn-success" href="{{ URL::route('investoradmininvestment')}}">Back to Automatic investment</a>
					</div>
				</div>
				
				<div class="block-content collapse in">
				
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
						@php 
							$flashdata = Session::get('action');
							@endphp

							@if($flashdata == 'success')
				
								<div class="alert alert-success">
									<button class="close" data-dismiss="alert">×</button>
									<strong>Success !</strong> {{ Session::get('successMsg') }}
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
							@if(count($records) > 0)
							<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
								<thead>
									<tr>
										<th>#</th>
										<th>Investor Wallet</th>
										<th>Investor Name</th>
										<th>Amount Funded</th>
										<th>Investment Date</th>
									</tr>
								</thead>
								<tbody>
									
									    @foreach($records as $records1)
										    @php
												$remaining_amount="";
										    @endphp
										   
                                             <tr>
												<td>#</td>
												<td>{{ ($records1->wallet_id) }}</td>
												<td>{{ ucfirst($records1->lender_name) }}</td>
												<td>€{{ $records1->bid_amount }}</td>
												<td>{{ date("M d, Y",strtotime($records1->investment_date)) }}</td>
											</tr>
									    @endforeach
									
								</tbody>
							</table>
							@else
							   <h1>There is no investor for this loan.</h1>
							@endif
						
					</div>
					
				</div>

			</div>
			<!-- /block -->
			
		
	</div>

@stop


@section('stylesheets')
	<link href="{{ URL::asset('public/backend/vendors/chosen.min.css') }}" rel="stylesheet" media="screen">
@stop

@section('scripts')
	<script src="{{ URL::asset('public/backend/vendors/bootstrap-datepicker.js') }}"></script>	
	<script src="{{ URL::asset('public/backend/vendors/chosen.jquery.min.js') }}"></script>
	<script>
		
	$(function() {
		$(".chzn-select").chosen();
	});
	$(document).ready(function(){
		$('.jumptopage').change(function(){
				
				var page = $(this).val();
				var loanid = <?=$loanid?>;
				
				location.href = "{{ URL::route('loaninvestors') }}/"+loanid+"?page="+page;
				
			});
	});
	</script>			
@stop
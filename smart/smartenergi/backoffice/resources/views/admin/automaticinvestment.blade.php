@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	<div class="row-fluid">
		
			<div class="block">
		
				<div class="navbar navbar-inner block-header">
					<div class="muted pull-left">💳 {{$sectionname}}</div>
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
							<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
								<thead>
									<tr>
										<th>#</th>
										<th>Loan ID</th>
										<th>Terms</th>
										<th>Amount to Fund</th>
										<th>Loan APR</th>
										<th>Score</th>
										<th>Product Name</th>
										<th>Total Investors</th>
										<th>Loan Investors list</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@if(count($records) > 0)
									    @foreach($records as $records1)
										    @php
												$remaining_amount=""
										    @endphp
										    @if($records1->total_bid > 0)
										    @php				 
				$remaining_amount =  ($records1->loan_amount) - ($records1->total_bid) 
			@endphp
												@endif
                                             <tr>
												<td>#</td>
												<td>{{ $records1->unique_id }}</td>
												<td>{{ $records1->loan_terms }}</td>
												<td>€{{ $records1->loan_amount }}</td>
												<td>{{ $records1->loan_apr }}</td>
												
												<td>
												
												@php
											$percent = intval(($records1->total_bid/$records1->loan_amount) * 100)
												@endphp
												<div class="progressD">
													<div class="progress-bar progress-bar-striped active" role="progressbar" style="width:{{$percent }}%">{{$percent }}%</div>
												</div>
													@if($records1->status=="approved") 
													    Only € {{ $remaining_amount }} is missing
													@endif    
												</td>
												<td>{{ $records1->product_name }}</td>
												<td><i class="fa fa-user"></i>{{ $records1->total_investor }}</td>
												<td><a class="btn btn-success" href="{{ URL::route('loaninvestors',array('loan_id'=>$records1->id)) }}">Investors List</a></td>
												<td>
								@if($records1->status=="approved")
								<form class="form-horizontal" action="{{ URL::route('investoradmininvestment') }}" method="post">
										<input type="hidden" name="act" value="doadd">
										<input type="hidden" name="loan_id" value="{{ $records1->id }}">
										<input type="hidden" name="remaining_amount" value="{{ $records1->loan_amount - $records1->total_bid }}"/>
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
															  <fieldset>
										<div class="control-group">
											<div class="">
												<select name="investorid" class="chzn-select">
													@if(count($investorlist) > 0)
													    @foreach($investorlist as $investorlist1)
													    	<option value="{{$investorlist1->id}}">{{$investorlist1->lender_name}}</option>
													    @endforeach
												    @endif
												</select>
											</div>
										</div>
										<div class="control-group">
											<div class="">
												<select name="loan_bid_amount" class="chzn-select">
													<option value="100">€ 100</option>
													<option value="200">€ 200</option>
													<option value="300">€ 300</option>
													<option value="400">€ 400</option>
													<option value="500">€ 500</option>
												</select>
											</div>
										</div>
															  </fieldset>
									<input type="submit" name="to_invest" value="To invest" class="btn btn-success">
								</form>
							@else
							 {{$records1->status}} loan

							@endif
							</td>	
												
											</tr>
									    @endforeach
									@endif
								</tbody>
							</table>
							
						
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
				
				location.href = "{{ URL::route('investoradmininvestment') }}"+"?page="+page;
				
			});
		jQuery("input[name='to_invest']").parent().submit(function(e){  
			e.preventDefault();
			var loaderimage = '<div class="loaderimage"><div class="innerdiv"></div></div>';
			 jQuery('body').append(loaderimage);
	         $.ajax({
                url: jQuery(this).attr('action'),
                type: 'post',
                //dataType: 'application/json',
                data: jQuery(this).serialize(),
                success: function(data) {
                	jQuery('.loaderimage').remove();
                	var data = jQuery.parseJSON(data);

                	if(data.status==1){
                		
                		window.location.href=data.redirecturl;
                	}else{
                		var listring='';
                		jQuery.each(data.errors, function( index, value ){
						    listring += '<li>'+value+'</li>';
						});
						if(jQuery('.errordynamic').length==0)
							jQuery('<div class="alert alert-error alert-block errordynamic"><ul>'+listring+'</ul></div>').insertBefore('table');
						else
							jQuery('.errordynamic').html('<ul>'+listring+'</ul>');
                	}
                   //  
                },error: function (errorThrown) {
		           jQuery('.loaderimage').remove(); 
		           alert("There is some error.Try again.");
		        }
        });
	    });
	});
    
	</script>			
@stop
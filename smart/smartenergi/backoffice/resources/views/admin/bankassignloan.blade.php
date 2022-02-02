@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	@if ($mode == '')		
	
	<div class="row-fluid">
		
		
		<div class="block">
		
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><span class="badge">{{ $totcount }}</span>{{ ucfirst($mode).' '.$sectionname }}</div>
				<div class="muted pull-right"> Total Count: <strong>{{ $totcount }}</strong></div>
			</div>
			
			<div class="block-content collapse in">
			
				<div class="span12">
				   <div class="table-toolbar">
					  <div class="btn-group">
						 
						 {{{--<a href="javascript:void(0);" style="margin-left:10px"><button class="btn btn-danger" class="truncatedb" onclick="truncate()">Truncate Database</button></a>--}}}
					  </div>
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
						 
						 <button data-toggle="dropdown" class="btn dropdown-toggle">Tools <span class="caret"></span></button>
						 <ul class="dropdown-menu">
							<li><a href="javascript:void(0);" onclick="delsel()">Delete Selected</a></li>
						 </ul>
					  </div>
				   </div>
					
					<form class="form-horizontal" name="frmlisting" id="frmlisting" action="#" method="post" enctype="multipart/form-data">
					    
						<input type="hidden" name="act" value="">
					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
					  
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
							<thead>
								<tr>
									<th><label class="uniform"><input type="checkbox" class="uniform_on" value="" id="check-all" ></label></th>
									<th>#</th>
									<th>Loan ID</th>
									<th>Loan Amount</th>
									<th>Loan Duration</th>
									<th>APR (%)</th>
									<th>Borrower Name</th>
									<th>Merchant Info</th>
									<th>Product/Loan Purpose</th>
									<th>Date of application</th>
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
										$surname = $data->surname;
										
										$name = ucwords($firstname.' '.$surname);	
										
										$address = '';
										
										$loan_id = $data->id;
										$unique_id = $data->unique_id;
										$loan_amount = '&euro; '.$data->loan_amount;
										$loan_terms = $data->loan_terms.' months';
										$loan_apr = $data->loan_apr;
										
										$appliedon = date('d/m/Y h:i:s A', $data->createdate);
										
										$borrower_id = $data->borrower_id;
										
											
										$merchant_id = $data->merchant_id;
										
										$merchant_name = !empty($data->merchant_name) ? $data->merchant_name : 'N/A';
										$merchant_cif = !empty($data->merchant_name) ? 'ID: '.$data->merchant_cif : '';
										$payment_sent=$data->payment_sent;
										$product_name = !empty($data->product_name) ? $data->product_name : 'N/A';										
										
										@endphp
										
										<tr class="odd gradeX">
											<td><label class="uniform"><input type="checkbox" class="chkall uniform_on" value="{{$data->id}}" name="chk_id[]"></label></td>
											<td>{{$sl}}</td>
											<td><a href="{{ URL::route('adminloanapplicationmodify',array('id'=>$loan_id, 'mode'=>'edit')) }}">{{$unique_id}}</a></td>
											<td>{{$loan_amount}}</td>
											<td>{{$loan_terms}}</td>
											<td>{{$loan_apr}}</td>
											<td><a href="{{ URL::route('adminborrowerdetails',array('id'=>$borrower_id)) }}">{{$name}}</a></td>
											<td>
												<div>{{$merchant_name}}</div>
												<div>{{$merchant_cif}}</div>
											</td>
											<td>{{$product_name}}</td>
											<td class="center">{{$appliedon}}</td>
											
											    
											
										</tr>
										
										@php $sl++ @endphp
									
									@endforeach
									
									@else
										
									<tr class="odd gradeX">
										<td colspan="13">No Record(s)</td>
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
           // $('.table.table-striped.table-bordered').DataTable();
        });
    </script>
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
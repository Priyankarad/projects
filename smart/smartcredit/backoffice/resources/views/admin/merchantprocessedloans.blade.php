@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	<div class="row-fluid">
		<!-- block -->
		
		<div class="block">
		
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><span class="badge">{{ $totcount }}</span> {{ $sectionname }}</div>
				<div class="muted pull-right"> &nbsp; | &nbsp;Total Count: <strong>{{ $totcount }}</strong></div>
				<div class="muted pull-right"> <a href="{{ URL::route('adminmerchant', ['id'=>'', 'mode'=>'', 'type'=>$merchant_status]) }}">&laquo;&nbsp;Back to Merchants</a></div>
			</div>
			
			<div class="block-content collapse in">
			
				<div class="span12">
				   <div class="table-toolbar">
					  
					  
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
									<th>Product/Loan Purpose</th>
									<th>Applied On</th>
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
										
										
											
											$from_merchant = $data->from_merchant;
											
											switch($from_merchant){
											
												case "0":
													$frommerchantclass = 'label-important';
													$frommerchanttxt = 'No';
													break;
												case "1":
													$frommerchantclass = 'label-success';
													$frommerchanttxt = 'Yes';
													break;												
											}										
										
										@endphp
										
										<tr class="odd gradeX">
											<td><label class="uniform"><input type="checkbox" class="chkall uniform_on" value="{{$data->id}}" name="chk_id[]"></label></td>
											<td>{{$sl}}</td>
											<td><a href="{{ URL::route('adminloanapplicationmodify',array('id'=>$loan_id, 'mode'=>'edit')) }}">{{$unique_id}}</a></td>
											<td>{{$loan_amount}}</td>
											<td>{{$loan_terms}}</td>
											<td>{{$loan_apr}}</td>
											<td><a href="{{ URL::route('adminborrowerdetails',array('id'=>$borrower_id)) }}">{{$name}}</a></td>
											<td>{{$product_name}}</td>
											<td class="center">{{$appliedon}}</td>
											<td class="center"><span class="label {{$statusclass}}">{{ucfirst($status)}}</td>
											<td class="center">
												
												<a href="{{ URL::route('adminloanapplicationmodify',array('id'=>$loan_id, 'mode'=>'edit')) }}"><input type="button" value="Edit" class="btn btn-warning"></a>
												
												<a href="{{ URL::route('adminloanpayments',array('id'=>$unique_id)) }}"><input type="button" value="Payments" class="btn btn-info"></a>
												
												<a href="{{ URL::route('adminloanapplication',array('type'=>$data->status, 'id'=>$loan_id, 'mode'=>'delete')) }}" class="delclass"><input type="button" value="Delete" class="btn btn-danger"></a>
												
											</td>
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
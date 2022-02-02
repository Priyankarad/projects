@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')	
	
	<div class="row-fluid">
		<!-- block -->
		
		<div class="block">
		
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">📊 {{ $sectionname }}</div>
			</div>
			
			<div class="block-content collapse in">
			
				<div class="span12">
					
					<div style="height: 80px; line-height: 80px; text-align:center; font-size:30px">
						Welcome to {{ config('constants.project_name') }} Dashboard
					</div>
					
				</div>
			</div>
		</div>
		<!-- /block -->
		
	</div>
	
	
	
	<div class="row-fluid">
		<!-- block -->
		
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><span class="badge badge-warning">{{ $pendinglendercount }}</span> {{ 'Pending '.$lendersectionname }}</div>
			</div>

			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><span class="badge badge-important">{{ $pendingloancount }}</span> {{ 'Pending '.$Loansectionname }}</div>
			</div>
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">🗓️ Last 5 Loan Applications</div>
			</div>
			
			<div class="block-content collapse in">
			
				<div class="span12">
				 
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
						<thead>
							<tr>
								<th>#</th>
								<th>Loan ID</th>
								<th>Loan Amount</th>
								<th>Loan Duration</th>
								<th>APR (%)</th>
								<th>Borrower Name</th>
								<th>Merchant Name</th>
								<th>Product</th>
								<th>Applied On</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							
							@if (count($records) > 0)
								
								@php
									
									$sl = 1; 
									
								@endphp
								
								@foreach($records as $data)
									
									@php
										
									$firstname = $data->firstname;
									$surname = $data->surname;
									
									$name = ucwords($firstname.' '.$surname);									
									
									$address = '';
									
									$loan_id = $data->id;
									$unique_id = $data->unique_id;
									$loan_amount ="€ ".$data->loan_amount;
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
									
									@endphp
									
									<tr class="odd gradeX">
										<td>{{$sl}}</td>
										<td><a href="{{URL::route('adminloanapplicationmodify',array('id'=>$loan_id, 'mode'=>'edit'))}}">{{$unique_id}}</a></td>
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
					
				</div>
			</div>
		</div>
		<!-- /block -->
		
	</div>

		<!-- morris bar & donut charts -->
	<div class="row-fluid section">
		 <!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">📈 Loan Statistics</div>
			</div>
			<div class="block-content collapse in">
				<div class="span6 chart">
					<h5>Bar Graph</h5>
					<div id="hero-bar" style="height: 250px;"></div>
				</div>
				<div class="span6 chart">
					<h5>Donut Chart</h5>
					<div id="hero-donut" style="height: 250px;"></div>    
				</div>
			</div>
		</div>
		<!-- /block -->
	</div>


@stop


@section('stylesheets')
	<link href="{{ URL::asset('public/backend/vendors/morris/morris.css') }}" rel="stylesheet" media="screen">
	<link href="{{ URL::asset('public/backend/vendors/chosen.min.css') }}" rel="stylesheet" media="screen">
@stop

@section('scripts')
	<script src="{{ URL::asset('public/backend/vendors/raphael-min.js') }}"></script>
	<script src="{{ URL::asset('public/backend/vendors/morris/morris.min.js') }}"></script>
	
	<script>
	
        $(function() {
			
			// Morris Bar Chart
			Morris.Bar({
				element: 'hero-bar',
				data: [
					{type: 'Pending', loans: {{$statuscount->pending}} },
					{type: 'Approved', loans: {{$statuscount->approved}} },
					{type: 'Rejected', loans: {{$statuscount->rejected}} },
					{type: 'Closed', loans: {{$statuscount->closed}} }
				],
				xkey: 'type',
				ykeys: ['loans'],
				labels: ['Loans'],
				barRatio: 0.4,
				xLabelMargin: 10,
				hideHover: 'auto',
				//barColors: ["#F89406", "#468847", "#B94A48", "#999999"],
				barColors: function (row, series, type) {
					if(row.label == "Pending") return "#F89406";
					else if(row.label == "Approved") return "#468847";
					else if(row.label == "Rejected") return "#B94A48";
					else if(row.label == "Closed") return "#999999";
				},
				resize: true
			});


			// Morris Donut Chart
			Morris.Donut({
				element: 'hero-donut',
				data: [
					{label: 'Pending', value: {{$statuscountper->pending}} },
					{label: 'Approved', value: {{$statuscountper->approved}} },
					{label: 'Rejected', value: {{$statuscountper->rejected}} },
					{label: 'Closed', value: {{$statuscountper->closed}} }
				],
				colors: ["#F89406", "#468847", "#B94A48", "#999999"],
				formatter: function (y) { return y + "%" }
			});
			
		});
		
	</script>
@stop
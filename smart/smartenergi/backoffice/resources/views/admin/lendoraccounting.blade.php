@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
<div class="row-fluid">
<div class="block">
	<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><span class="badge">{{ $totcount }}</span>{{ $sectionname }}</div>
				<div class="muted pull-right"> Total Count: <strong>{{ $totcount }}</strong></div>
			</div>
	<div class="block-content collapse in">
			
				<div class="span12">
					<div class="table-toolbar">
					 
					  <div class="btn-group pull-right">
					  	@if (count($records) > 0)
						 <a href="{{ URL::to('downloadExcel2/xls') }}"><button class="btn btn-success">Download Excel xls</button></a>
						 @endif
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
				   
				   
				   <p><b>Filter By Wallet ID : </b><select id="walletfilter"></select></p>
				   <p><b>Filter By Loan ID : </b><select id="loanfilter"></select></p>

<table cellpadding="0" cellspacing="0" border="0" class="cash table table-striped table-bordered" >
							<thead>
								<tr>
									<th style="width: 4%;">#</th>
									<th>Wallet ID</th>
									<th>Loan Id</th>
									<th>Investor Name</th>
									<th>Investment Amount</th>
									<th>Investment Date</th>
									<th>Loan Status</th>
									<th>Expected Return </th>
									<th>Date of Return</th>
									
								</tr>
							</thead>
							<tbody>
								
								@if (count($records) > 0)
									
									@php
										$wallethtml="";
										$loanhtml="";
										$sl = $currentPage == 1 ? 1 : ($currentPage*$per_page-$per_page)+1; 
										
									@endphp
									
									@foreach($records as $data)

										@php
										      $wallethtml .='<option value="'.$data->wallet_id.'">'.$data->wallet_id.'</option>,';
									    @endphp

										@if($data->unique_id)
											@php
											$loanhtml .='<option value="'.$data->unique_id.'">'.$data->unique_id.'</option>,';
											@endphp
										@endif
										
										<tr class="odd gradeX">
											<td>{{$sl}}</td>
											<td class="walletrow">{{$data->wallet_id}}</td>
											<td class="loanrow">{{$data->unique_id}}</td>
											<td>{{ucfirst($data->lender_name)}}</td>
											<td>{{$data->bid_amount}}</td>
											<td>{{date("Y-m-d",strtotime($data->investment_date))}}</td>
											<td>{{ucfirst($data->status)}}</td>
											<td></td>
											<td></td>
											
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
					</div>
				</div>
					</div>
				</div>

@stop


@section('stylesheets')
	<link href="{{ URL::asset('public/backend/vendors/uniform.default.css') }}" rel="stylesheet" media="screen">
	<link href="{{ URL::asset('public/backend/vendors/chosen.min.css') }}" rel="stylesheet" media="screen">
@stop

@section('scripts')
<?php

if(!empty($wallethtml)){
	$wallethtml = implode(',',array_unique(explode(',', rtrim($wallethtml,","))));
    $wallethtml=str_replace(",", "", $wallethtml);
}else{
	$wallethtml="";
}
?>

<script type="text/javascript"> $("#walletfilter").html('<option value="all">All</option><?=$wallethtml?>');</script>
<?php 

if(!empty($loanhtml)){
$loanhtml = implode(',',array_unique(explode(',', rtrim($loanhtml,","))));
$loanhtml=str_replace(",", "", $loanhtml);
}else{
	$loanhtml="";
}
?>
<script type="text/javascript"> $("#loanfilter").html('<option value="all">All</option><?=$loanhtml?>');</script>
<script type="text/javascript">
	
	$('.jumptopage').change(function(){
            
            var page = $(this).val();
            
            location.href = "{{ URL::route('admininvestoraccounting') }}"+"?page="+page;
            
        });
</script>
	<script src="{{ URL::asset('public/backend/vendors/jquery.uniform.min.js') }}"></script>
	<script src="{{ URL::asset('public/backend/vendors/chosen.jquery.min.js') }}"></script>

@stop
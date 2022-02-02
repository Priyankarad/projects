@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
		
	
	<div class="row-fluid">
		<!-- block -->
		
		
		<div class="block">
		<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><span class="badge">{{ $totcount }}</span>{{ $sectionname }}</div>
				<div class="muted pull-right"> Total Count: <strong>{{ $totcount }}</strong></div>
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
				   <p><b>Filter By Wallet ID : </b><select id="walletfilter"></select></p>
				   <p><b>Filter By Loan ID : </b><select id="loanfilter"></select></p>
						<table cellpadding="0" cellspacing="0" border="0" class="cash table table-striped table-bordered" >
							<thead>
								<tr>
									<th style="width: 4%;">#</th>
									<th>Payment date</th>
									<th>Lender Name</th>
									<th>Amount</th>
									<th>Payment Type</th>
									<th>Payment Mode</th>
									<th>Wallet Id</th>
									<th>Loan Id</th>
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
											<td>{{date('d M Y H:i:s', strtotime($data->create_date))}}</td>
											<td>{{ucfirst($data->lender_name)}}</td>
											<td>&euro;{{$data->amount}}</td>
											<td>{{ucfirst($data->payment_type)}}</td>
											<td>{{ucfirst($data->payment_mode)}}</td>
											<td class="walletrow">{{$data->wallet_id}}</td>
											<td class="loanrow">@if($data->unique_id) {{ $data->unique_id }}@endif</td>
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
            
            location.href = "{{ URL::route('adminlendercashin') }}"+"?page="+page;
            
        });
</script>
	<script src="{{ URL::asset('public/backend/vendors/jquery.uniform.min.js') }}"></script>
	<script src="{{ URL::asset('public/backend/vendors/chosen.jquery.min.js') }}"></script>
	
	
@stop
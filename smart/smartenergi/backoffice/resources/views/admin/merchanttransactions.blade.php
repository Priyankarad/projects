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
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
							<thead>
								<tr>
									<th>#</th>
									<th>Sender Wallet</th>
									<th>Receiver Wallet</th>
									<th>Debited</th>
									<th>Credited</th>
									<th>Msg</th>
									<th>Transaction Date</th>
									
								</tr>
							</thead>
							<tbody>
								
								@if (count($records) > 0)
									
									@php
										
										$sl = $currentPage == 1 ? 1 : ($currentPage*$per_page-$per_page)+1; 
										
									@endphp
									
									@foreach($records as $data)
										
										@php
										
										$sender_wallet = $data->SEN;
										$receiver_wallet = $data->REC;
										$debited = '&euro; '.$data->DEB;
										$credited = '&euro; '.$data->CRED;
										$MSG = $data->MSG;
										$trans_date = $data->DATE;
										
										@endphp
										
			<tr class="odd gradeX">
				<td>{{$sl}}</td>
				<td>{{$sender_wallet}}</td>
				<td>{{$receiver_wallet}}</td>
				<td>{{$debited}}</td>
				<td>{{$credited}}</td>
				<td>{{$MSG}}</td>
				<td class="center">{{$trans_date}}</td>
				
			</tr>
										
										@php $sl++ @endphp
									
									@endforeach
									
									@elseif($errors)
										
										<tr class="odd gradeX">
											<td colspan="13">{{$errors}}</td>
										</tr>
									@else
										<tr class="odd gradeX">
											<td colspan="13">No records(s)</td>
										</tr>
									@endif
								
							</tbody>
						</table>
				</div>
				
				<div class="span12">
					
					<div class="dataTables_wrapper form-inline">
						<div class="row">
							<div class="span12">
								@if(count($records) > 0)
								@include('pagination.admin.default', ['paginator' => $records, 'link_limit' => 5])
								@endif
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
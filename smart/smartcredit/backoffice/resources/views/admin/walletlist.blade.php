@extends('layouts.admin.master')

@section('pagetitle', $pagetitle)
@section('pagedescription', $pagedescription)

@section('content')
	
	<div class="row-fluid">
		<!-- block -->
		
		
		<div class="block">
		
			<div class="block-content collapse in">
			
				<div class="span12">
				   <p>
Filter By Role: 
<select id="table-filter">
<option value="">All</option>
<option>Merchant</option>
<option>Lender</option>
<option>Borrower</option>
</select>
</p>
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
							<thead>
								<tr>
									<th style="width: 4%;">#</th>
									<th>Wallet Id</th>
									<th>Description</th>
									<th style="display: none;"></th>
								</tr>
							</thead>
							<tbody>
								@php $sl=1 @endphp
								@if (count($merchant_wallets) > 0)
									
									@foreach($merchant_wallets as $merchant_wallets_values)
										
										<tr class="odd gradeX">
											<td>{{$sl}}</td>
											<td>{{$merchant_wallets_values->wallet_id}}</td>
											<td>Merchant wallet, Email : <b>{{$merchant_wallets_values->email}}</b></td>
											<td style="display: none">Merchant</td>
										</tr>
										@php $sl++ @endphp
									@endforeach
								@endif

								@if (count($borrower_wallets) > 0)
									
									@foreach($borrower_wallets as $borrower_wallets_values)
										
										<tr class="odd gradeX">
											<td>{{$sl}}</td>
											<td>{{$borrower_wallets_values->wallet_id}}</td>
											<td>Borrower wallet, Email : <b>{{$borrower_wallets_values->emailaddress}}</b></td>
											<td style="display: none">Borrower</td>
										</tr>
										@php $sl++ @endphp
									@endforeach
								@endif

								@if (count($lender_wallets) > 0)
									
									@foreach($lender_wallets as $lender_wallets_values)
										
										<tr class="odd gradeX">
											<td>{{$sl}}</td>
											<td>{{$lender_wallets_values->wallet_id}}</td>
											<td>Lender wallet, Email : <b>{{$lender_wallets_values->email}}</b></td>
											<td style="display: none">Lender</td>
										</tr>
										@php $sl++ @endphp
									@endforeach
								@endif

								@if(empty($merchant_wallets) && empty($borrower_wallets) && empty($lender_wallets))
										
									<tr class="odd gradeX">
										<td colspan="12">No Record(s)</td>
									</tr>
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
	
		
		$('.jumptopage').change(function(){
			
			var page = $(this).val();
			
			location.href = "{{ URL::route('adminlender') }}"+"?page="+page;
			
		});
		
	});
		
	function truncate(){
		
		var cnf = confirm('Are you sure?');
		if(cnf){
			
			document.frmlisting.act.value = 'truncate';
			document.frmlisting.submit();
		}
	}
		
	function showsection(currentsection){

		if(currentsection.value==1){
			currentsection.parentNode.parentNode.parentNode.nextElementSibling.style.display='block';
		}else
		   currentsection.parentNode.parentNode.parentNode.nextElementSibling.style.display='none';
	}	

  $(document).ready(function() {
    //$('.table').DataTable();
    var table = $('.table').DataTable({
    	"oLanguage": {
        "sSearch": "Filter By Wallet ID : "
    }
	  // dom: 'lrtip'
	})


	$('#table-filter').on('change', function(){
	   table.search(this.value).draw();   
	});


		table.columnFilter({
		  sPlaceHolder: "head:before",
		  aoColumns: [
		      { type: "select" },  
		      { type: "select" },        
		      { type: "select" },  
		      { type: "select" },  
		      { type: "select" }
		  ]
		});

} );

  
	</script>
@stop
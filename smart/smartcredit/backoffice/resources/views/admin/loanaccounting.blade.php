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
							<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
								<thead>
									<tr>
										<th>#</th>
										<th>Loan ID</th>
										<th>Amount money out to merchant Account</th>
										<th>Where money out(IBAN)</th>
										
									</tr>
								</thead>
								<tbody>
									@if(count($records) > 0)
									    @foreach($records as $records1)
                                             <tr>
												<th>#</th>
												<th>{{ $records1->unique_id }}</th>
												<th>&euro;{{ $records1->bid_amount }}</th>
												<th>{{ $records1->wallet_id }}</th>		
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
	<link href="{{ URL::asset('public/backend/bootstrapswitch/bootstrap-switch.min.css') }}" rel="stylesheet" media="screen">
	<link href="{{ URL::asset('public/backend/vendors/datepicker.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('scripts')
	<script src="{{ URL::asset('public/backend/bootstrapswitch/bootstrap-switch.min.js') }}"></script>
	<script src="{{ URL::asset('public/backend/vendors/bootstrap-datepicker.js') }}"></script>				
@stop
<?php

$loggedinadminid = Session::get('adminid');
$loggedinUserDetails = Adminlogin::loggedinadmindetails($loggedinadminid);

//dd($loggedinUserDetails);

$currentRoute = Route::getCurrentRoute()->getName();

switch($currentRoute){
	
	case 'adminborrower':
		$activeclass['adminborrower'] = 'class="dropdown active"';
		break;
		
	case 'admindashboard':
		$activeclass['admindashboard'] = 'class="active"';
		break;
		
	case 'adminloanapplication':
		$activeclass['adminloanapplication'] = 'class="dropdown active"';
		break;
		
	case 'adminloanpayments':
		$activeclass['adminloanpayments'] = 'class="dropdown active"';
		break;
		
	case 'adminmerchant':
		$activeclass['adminmerchant'] = 'class="dropdown active"';
		break;
	case 'adminlender':
		$activeclass['adminlender'] = 'class="dropdown active"';
		break;	
	case 'siteContent':
		$activeclass['siteContent'] = 'class="dropdown active"';
		break;

	case 'getwalletlist':
		$activeclass['getwalletlist'] = 'class="dropdown active"';
		break;
	case 'investoradmininvestment':
		$activeclass['investoradmininvestment'] = 'class="dropdown active"';
		break;		
}

?>

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
			</a>
			<a class="brand" href="{{ URL::route('admindashboard') }}"><img src="{{URL::asset('public/backend/images/logo_black.png')}}" style="height:60px;"></a>
			<div class="nav-collapse collapse">
				<ul class="nav pull-right">
					<li class="dropdown">
						<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> {{ $loggedinUserDetails->username }} <i class="caret"></i>

						</a>
						<ul class="dropdown-menu">
							<li>
								<a tabindex="-1" href="{{ URL::route('adminchangepassword') }}">Change Password</a>
							</li>
							<li class="divider"></li>
							<li>
								<a tabindex="-1" href="{{ URL::route('adminlogout') }}"><i class="icon-off"></i> Logout</a>
							</li>
						</ul>
					</li>
				</ul>
				<ul class="nav">
					<li <?php echo(isset($activeclass['admindashboard']) ? $activeclass['admindashboard'] : ''); ?>>
						<a href="{{ URL::route('admindashboard') }}">📊 Dashboard</a>
					</li>
					<li <?php echo(isset($activeclass['adminborrower']) ? $activeclass['adminborrower'] : 'class="dropdown"'); ?>>
						<a href="{{ URL::route('adminborrower') }}" data-toggle="dropdown" class="dropdown-toggle">👥 Borrowers <b class="caret"></b></a>
						
						<ul class="dropdown-menu">
							@if($loggedinadminid==1)
							<li>								
								<a href="{{ URL::route('adminborrower', array('mode'=>'add')) }}"><i class="icon-plus icon-black"></i> Add Borrower</a>
							</li>
							<li class="divider"></li>
							@endif
							<li>
								<a href="{{ URL::route('adminborrower') }}">Borrowers</a>
							</li>
						</ul>
						
					</li>
					<li <?php echo(isset($activeclass['adminloanapplication']) ? $activeclass['adminloanapplication'] : 'class="dropdown"'); ?>>
						<a href="#" data-toggle="dropdown" class="dropdown-toggle">💵 Loan Applications <b class="caret"></b></a>
						<ul class="dropdown-menu">
							@if($loggedinadminid==1)
							<li>
								<a href="{{ URL::route('adminloanapplicationmodify', array('mode'=>'add')) }}"><i class="icon-plus icon-black"></i> Add Loan Application</a>
							</li>
							<li class="divider"></li>
							@endif
							<li>
								<a href="{{ URL::route('adminloanapplication', array('type'=>'pending')) }}">Pending Loans</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{ URL::route('adminloanapplication', array('type'=>'approved')) }}">Approved Loans</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{ URL::route('adminloanapplication', array('type'=>'closed')) }}">Closed Loans</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{ URL::route('adminloanapplication', array('type'=>'rejected')) }}">Rejected Loans</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{ URL::route('adminloanapplication', array('type'=>'covered')) }}">Covered Loans</a>
							</li>
						</ul>
					</li>
					<li <?php echo(isset($activeclass['adminloanpayments']) ? $activeclass['adminloanpayments'] : ''); ?>>
						<a href="{{ URL::route('adminloanpayments') }}">💳 Payments</a>
					</li>

					<li <?php echo(isset($activeclass['adminloanaccounting']) ? $activeclass['adminloanaccounting'] : ''); ?>>
						<a href="{{ URL::route('adminloanaccounting') }}">💳 Accounting</a>
					</li>

					<li <?php echo(isset($activeclass['adminbankagregator']) ? $activeclass['adminbankagregator'] : ''); ?>>
						<a href="{{ URL::route('adminbankagregator') }}">💳 Bank Agregator</a>
					</li>

					<li <?php echo(isset($activeclass['adminmerchant']) ? $activeclass['adminmerchant'] : 'class="dropdown"'); ?>>
						<a href="#" data-toggle="dropdown" class="dropdown-toggle">👨‍💻 Merchants <b class="caret"></b></a>
						
						<ul class="dropdown-menu">
							@if($loggedinadminid==1)
							<li>
								<a href="{{ URL::route('adminmerchant', array('mode'=>'add','id'=>'','type'=>'pending')) }}"><i class="icon-plus icon-black"></i> Add Merchant</a>
							</li>
							<li class="divider"></li>
							@endif
							<li>
								<a href="{{ URL::route('adminmerchant', array('mode'=>'','id'=>'','type'=>'pending')) }}">Pending Merchants</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{ URL::route('adminmerchant', array('mode'=>'','id'=>'','type'=>'approved')) }}">Approved Merchants</a>
							</li>
						</ul>
						
					</li>

					<li <?php echo(isset($activeclass['adminlender']) ? $activeclass['adminlender'] : 'class="dropdown"'); ?>>
						<a href="#" data-toggle="dropdown" class="dropdown-toggle">👨‍💻 Investors <b class="caret"></b></a>
						
						<ul class="dropdown-menu">
							@if($loggedinadminid==1)
							<li>
								<a href="{{ URL::route('adminlender', array('mode'=>'add','id'=>'','type'=>'pending')) }}"><i class="icon-plus icon-black"></i> Add Investor</a>
							</li>
							<li class="divider"></li>
							@endif
							<li>
								<a href="{{ URL::route('adminlender', array('mode'=>'','id'=>'','type'=>'pending')) }}">Pending Investors</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{ URL::route('adminlender', array('mode'=>'','id'=>'','type'=>'approved')) }}">Approved Investors</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{ URL::route('adminlendercashin') }}">Cash In</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{ URL::route('adminlendercashout') }}">Cash Out</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{ URL::route('admininvestoraccounting') }}">Investor Accounting</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{ URL::route('investoradmininvestment') }}">Investor Automatic Investment</a>
							</li>
						</ul>
					</li>
					<li <?php echo(isset($activeclass['getwalletlist']) ? $activeclass['getwalletlist'] : ''); ?>>
						<a href="{{ URL::route('getwalletlist') }}">💳 Wallets</a>
					</li>
					
					<!---
					<li <?php //echo(isset($activeclass['siteContent']) ? $activeclass['siteContent'] : 'class="dropdown"'); ?>>
							<a href="{{URL::route('siteContent')}}">Site Content</a>
					</li>-->
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
</div>
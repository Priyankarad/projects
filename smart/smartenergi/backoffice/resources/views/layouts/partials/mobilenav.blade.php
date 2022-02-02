{{--*/
	
	$loggedinuserid = Session::get('userid');
	$loggedinUserDetails = Login::loggedinuserdetails($loggedinuserid);

	//dd($loggedinUserDetails);
	
	$userName = $loggedinUserDetails ? $loggedinUserDetails->firstname.( !empty($loggedinUserDetails->lastname) ? ' '.$loggedinUserDetails->lastname : '' ) : '';
	
/*--}}

<div class="header-mobile visible-sm visible-xs">
	<div class="container">
		<!--start mobile nav-->
		<div class="mobile-nav">
			<span class="nav-trigger"><i class="fa fa-navicon"></i></span>
			<div class="nav-dropdown main-nav-dropdown"></div>
		</div>
		<!--end mobile nav-->
		<div class="header-logo">
			<a href="{{ URL::route('home') }}"><img src="{{ URL::asset('public/frontend/images/logo-houzez-white.png') }}" alt="logo"></a>
		</div>
		<div class="header-user">
			
			@if(empty($loggedinuserid))
				
				<div class="user">
					<a href="#" data-toggle="modal" data-target="#pop-login"><i class="fa fa-user"></i></a>
				</div>
				
			@else
			
				<ul class="account-action">
					<li>
						<span class="user-icon"><i class="fa fa-user"></i></span>
						<div class="account-dropdown">
							<ul>
								<li> <a href="{{ URL::route('myaccountdashboard') }}"> <i class="fa fa-user"></i>Dashboard</a></li>
								<li> <a href="{{ URL::route('myaccountprofile') }}"> <i class="fa fa-user"></i>My Profile</a></li>
								<li><a href="{{ URL::route('logout') }}"> <i class="fa fa-unlock"></i>Log out</a></li>
							</ul>
						</div>
					</li>
				</ul>
			
			@endif
			
		</div>
	</div>
</div>
{{--*/ 

$loggedinadminid = Session::get('adminid');
$loggedinUserDetails = Login::loggedinadmindetails($loggedinadminid);

//dd($loggedinUserDetails);

/*--}}

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
			</a>
			<a class="brand" href="#">Admin Panel</a>
			<div class="nav-collapse collapse">
				<ul class="nav pull-right">
					<li class="dropdown">
						<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> {{ $loggedinUserDetails->username }} <i class="caret"></i>

						</a>
						<ul class="dropdown-menu">
							<li>
								<a tabindex="-1" href="#">Profile</a>
							</li>
							<li class="divider"></li>
							<li>
								<a tabindex="-1" href="{{ URL::route('logout') }}">Logout</a>
							</li>
						</ul>
					</li>
				</ul>
				<ul class="nav">
					<li class="active">
						<a href="#">Dashboard</a>
					</li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle">Link <b class="caret"></b>

						</a>
						<ul class="dropdown-menu" id="menu1">
							
							<li>
								<a href="#">Link</a>
							</li>
							<li>
								<a href="#">Link</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#">Link</a>
							</li>
							<li>
								<a href="#">Link</a>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle">Link <b class="caret"></b>

						</a>
						<ul class="dropdown-menu" id="menu1">
							
							<li>
								<a href="#">Link</a>
							</li>
							<li>
								<a href="#">Link</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#">Link</a>
							</li>
							<li>
								<a href="#">Link</a>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle">Link <b class="caret"></b>

						</a>
						<ul class="dropdown-menu" id="menu1">
							
							<li>
								<a href="#">Link</a>
							</li>
							<li>
								<a href="#">Link</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#">Link</a>
							</li>
							<li>
								<a href="#">Link</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
</div>
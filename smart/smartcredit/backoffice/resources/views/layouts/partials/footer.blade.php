<!--start footer section-->
<footer class="footer-v2">
	<!--<div class="footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="footer-widget widget-about">
						<div class="widget-top">
							<h3 class="widget-title">About Site</h3>
						</div>
						<div class="widget-body">
							<p>Houzez is a premium WordPress theme for real estate where modern aesthetics are combined with tasteful simplicity.</p>
							<p class="read"><a href="about-us.html">Read more <i class="fa fa-caret-right"></i></a></p>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="footer-widget widget-contact">
						<div class="widget-top">
							<h3 class="widget-title">Contact Us</h3>
						</div>
						<div class="widget-body">
							<ul class="list-unstyled">
								<li><i class="fa fa-location-arrow"></i> 121 King Street, Melbourne VIC 3000</li>
								<li><i class="fa fa-phone"></i> +1 (877) 987 3487</li>
								<li><i class="fa fa-envelope-o"></i> <a href="#">info@housez.com</a></li>
							</ul>
							<p class="read"><a href="contact-us.html">Contact us <i class="fa fa-caret-right"></i></a></p>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="footer-widget widget-newsletter">
						<div class="widget-top">
							<h3 class="widget-title">Newsletter Subscribe</h3>
						</div>
						<div class="widget-body">
							<form>
								<div class="table-list">
									<div class="form-group table-cell">
										<div class="input-email input-icon">
											<input class="form-control" placeholder="Enter your email">
										</div>
									</div>
									<div class="table-cell">
										<button class="btn btn-primary">Submit</button>
									</div>
								</div>
							</form>
							<p>Houzez is a premium WordPress theme for real estate agents.<br>Don?t forget to fullow us on:</p>
							<ul class="social">
								<li>
									<a href="#" class="btn-facebook"><i class="fa fa-facebook-square"></i></a>
								</li>
								<li>
									<a href="#" class="btn-twitter"><i class="fa fa-twitter-square"></i></a>
								</li>
								<li>
									<a href="#" class="btn-google-plus"><i class="fa fa-google-plus-square"></i></a>
								</li>
								<li>
									<a href="#" class="btn-linkedin"><i class="fa fa-linkedin-square"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>-->
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<div class="footer-col">
						<p>&copy; {{ config('constants.project_name').'&nbsp;'.date('Y') }}. All rights reserved</p>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="footer-col">
						<div class="navi">
							<ul id="footer-menu" class="">
								<li><a href="{{ URL::route('privacy') }}">Privacy</a></li>
								<li><a href="{{ URL::route('terms') }}">Terms and Conditions</a></li>
								<li><a href="{{ URL::route('contactus') }}">Contact</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3">
					<div class="footer-col foot-social">
						<p>
							Follow us
							<a target="_blank" class="btn-facebook" href="{{ config('constants.fb_url') }}"><i class="fa fa-facebook-square"></i></a>

							<a target="_blank" class="btn-twitter" href="{{ config('constants.twitter_url') }}"><i class="fa fa-twitter-square"></i></a>

							<a target="_blank" class="btn-linkedin" href="{{ config('constants.linkedin_url') }}"><i class="fa fa-linkedin-square"></i></a>

							<a target="_blank" class="btn-google-plus" href="{{ config('constants.gplus_url') }}"><i class="fa fa-google-plus-square"></i></a>

							<a target="_blank" class="btn-instagram" href="{{ config('constants.instagram_url') }}"><i class="fa fa-instagram"></i></a>
						</p>
					</div>
				</div>
			</div>
			
			<!--<div class="row">
				
				<div class="col-md-12 col-sm-12">
					<div class="footer-col" style="text-align:center; margin-top:20px;">
						<p>Powered By: <a href="http://www.microservicestechnology.com" target="_blank">microservicestechnology.com</a></p>
					</div>
				</div>
				
			</div>-->
			
		</div>
	</div>
</footer>
<!--end footer section-->
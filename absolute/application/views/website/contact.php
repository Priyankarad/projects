<!--========header=============-->

<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">

    <div class="link_section">
        <h1>CONTACT US</h1>
    </div>

</section>



<!--=============== Contact Section Start============ -->
<section class="main_contact pd_all">
	<div class="container contain_new">
		<div class="main_form">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">
					<p class="contact_head">For booking or any other information, feel free to get in touch!</p>
				</div>
			</div>
			<div class="row mz_xs">
                <div class="col-md-7 col-sm-12 col-12 pz">
                <div class="iframe-maps">
                    
                    <iframe src="https://absolute-emc.com/map/test.html" frameborder="0" allowfullscreen></iframe>
                </div>
					
				</div>

				<div class="col-md-5 col-sm-12 col-12 pz">
				<?php echo alert(); ?>
					<div class="frm_section">
						<form action="<?php echo site_url('users/insertcontact') ?>" method="post" enctype='multipart/form-data'>
							<div class="row">
								<div class="form-group col-md-6 col-sm-6 col-12">
									<input type="text" name="fname" placeholder="First Name" class="form-control" required="">
								</div>
								<div class="form-group col-md-6 col-sm-6 col-12">
									<input type="text" name="lastname" placeholder="Last Name" class="form-control" required="">
								</div>
								<div class="form-group col-md-6 col-sm-6 col-12">
									<input type="text" name="company" placeholder="Company Name" class="form-control" required="">
								</div>

								<div class="form-group col-md-6 col-sm-6 col-12">
									<input type="email" name="email" placeholder="Email" class="form-control" required="">
								</div>

								<div class="form-group col-md-12 col-sm-12 col-12">
									<input type="text" name="address" class="form-control" placeholder="Address" required="">
								</div>

                                <div class="form-group col-md-4 col-sm-4 col-12">
									<input type="text" name="city" placeholder="City" class="form-control" required="">
								</div>

								<div class="form-group col-md-4 col-sm-4 col-12">
									<input type="text" name="zipcode" placeholder="Zip code" class="form-control" required="">
								</div>

								<div class="form-group col-md-4 col-sm-4 col-12">
									<input type="text" name="phone" placeholder="Phone" class="form-control" required="">
								</div>

								<div class="form-group col-md-12 col-sm-12 col-12">
									<textarea class="form-control" name="message" rows="4" placeholder="Message" required=""></textarea>
								</div>

								<div class="form-group col-md-12 col-sm-6 col-12 text-right">
									<button type="submit" class="btn_sub btn">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</section>
<!--=============== Contact Section Start============ -->

<!--========banner Start=============-->

<section class="slide_banner" style="background: url(<?php echo BASEURL; ?>assets/web/images/bg-back.png)">
	<div class="container">
		<div class="row">
			<div class="owl-carousel owl-theme banner-slide">
				<?php 
				if(!empty($imageData['result'])){
					foreach ($imageData['result'] as $img) { ?>
						<div class="item banner_bg">
							<div class="item banner_bg">
<!-- <div class="banner_content">
<h1>Having Fun With EMC!</h1>
<p>Offering full Consulting Services and Equipment forEMC testing to meet the ever changing standards</p>
<a href="<?php echo site_url('contact'); ?>">CONTACT US</a>
</div> -->

<a href="<?php echo $img->url; ?>"><img src="<?php echo base_url().$img->image;?>"></a>
</div>
</div>
<?php		}

}

?>

  				<!-- <div class="item banner_bg">
					<div class="banner_content">
						<h1>Having Fun With EMC!</h1>
						<p>Offering full Consulting Services and Equipment forEMC testing to meet the ever changing standards</p>
						<a href="<?php echo site_url('contact'); ?>">CONTACT US</a>
					</div>
  				</div> -->
  			</div>
		</div>
	</div>
</section>
<!--========banner End=============-->

<section class="opening_section pd_all">
    <div class="container contain_new">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-12 opn_width">
               <div class="opening_pic">
                 <a href="<?php echo site_url('products'); ?>">Products</a>
               </div>
            </div>

            <div class="col-md-3 col-sm-3 col-12 opn_width">
               <div class="opening_pic">
                 <a href="<?php echo site_url('services'); ?>">Services</a>
               </div>
            </div>

            <div class="col-md-3 col-sm-3 col-12 opn_width">
               <div class="opening_pic">
                 <a href="<?php echo site_url('partners'); ?>">Partners</a>
               </div>
            </div>

            <div class="col-md-3 col-sm-3 col-12 opn_width">
               <div class="opening_pic">
                 <a href="<?php echo site_url('markets'); ?>">Markets</a>
               </div>
            </div>

            <div class="col-md-3 col-sm-3 col-12 opn_width">
               <div class="opening_pic">
                 <a href="<?php echo site_url('standards'); ?>">Standards</a>
               </div>
            </div>

        </div>
     </div>
 </section>
<!--========Ouer Services Start=============-->
<section class="ouer_services pd_all">
    <div class="container contain_new">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-12">
                <div class="heading">

                    <h2>Our Expertise</h2>

                </div>
            </div>
        </div>

        <div class="row services_section mar_top">
           
               

                    <div class="col-md-4 aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">

                        <div class="section_connect">

                            <div class="thumb_cir">

                                <img src="<?php echo BASEURL.(!empty($homeData[1]->value)?$homeData[1]->value:'');?>" alt="images" class="img-fluid">

                            </div>

                            <div class="box_content">

                                <h3>FAST RESPONSE</h3>
                                <?php echo !empty($homeData[0]->value)?$homeData[0]->value:'';?>
                                <a href="<?php echo site_url('about') ?>" class="btn_public">Read more</a>
                            </div>

                        </div>
                    </div>


                        <div class="col-md-4 aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">

                        <div class="section_connect">

                            <div class="thumb_cir">

                                <img src="<?php echo BASEURL.(!empty($homeData[3]->value)?$homeData[3]->value:'');?>" alt="images" class="img-fluid">

                            </div>

                            <div class="box_content">

                                <h3>ATTENTION TO DETAIL</h3>

                                <?php echo !empty($homeData[2]->value)?$homeData[2]->value:'';?>
                                <a href="<?php echo site_url('about') ?>" class="btn_public">Read more</a>
                            </div>

                        </div>

                    </div>


                    <div class="col-md-4 aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">

                        <div class="section_connect">

                            <div class="thumb_cir">

                                <img src="<?php echo BASEURL.(!empty($homeData[5]->value)?$homeData[5]->value:'');?>" alt="images" class="img-fluid">

                            </div>

                            <div class="box_content">

                                <h3>CUT THROUGH IT ALL</h3>
                                <?php echo !empty($homeData[4]->value)?$homeData[4]->value:'';?>
                                
                                <a href="<?php echo site_url('about') ?>" class="btn_public">Read more</a>
                            </div>

                        </div>

                    </div>
					
				</div>
        </div>
    </div>
</section>
<!--========Ouer Services End=============-->


<!--========Offer Section Start=============-->
<section class="pd_all">
	<div class="container contain_new">
		
				<div class="row">
					<div class="col-md-6 col-sm-6 col-12 aos-init aos-animate" data-aos="fade-right" data-aos-duration="1200">
						<div class="offset_set">
							<img src="<?php echo BASEURL.(!empty($homeData[6]->value)?$homeData[6]->value:'');?>" alt="image" class="img-fluid w-100">
							<div class="content_offer">
							<!--	<h3>Weekend</h3>
								<h4><span class="percent">30%</span> <span class="off">OFF</span></h4>-->
							</div>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-12 aos-init aos-animate" data-aos="fade-left" data-aos-duration="1200">
						<div class="offset_set">
							<img src="<?php echo BASEURL.(!empty($homeData[7]->value)?$homeData[7]->value:'');?>" alt="image" class="img-fluid w-100">
							<div class="content_offer1">
							<!--	<h3><span>50%</span> off from best sellers</h3>-->
								
							</div>
						</div>
					</div>
				</div>
			
	</div>
</section>
<!--========Offer Section End=============-->


<!--========Products Section Start=============-->
<section class="pd_all">
	<div class="container contain_new">

		<div class="row">
            <div class="col-md-12 col-sm-12 col-12">
                <div class="heading">

                    <h2>Products Knowledge</h2>

                </div>
            </div>
        </div>
       <!-------------
		<div class="row mar_top">
		<?php if(!empty($categories)){ foreach($categories as $cats){ ?>
			<div class="col-md-3 col-sm-3 col-12 product_col aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">
				<div class="product_content">
					<div class="img_thumb">
						<img src="<?php echo BASEURL; ?>assets/web/images/product1.png" alt="images" class="img-fluid w-100">
					</div>
					<div class="content">
						<p><?php echo $cats->category; ?></p>
					</div>
				</div>
			</div>
		<?php } } ?>
		</div>
		------------------>
	</div>
</section>
<!--========Products Section End=============-->

<!--========EMC Section Start=============-->
<section>
	<div class="container contain_new">
		<div class="row emx_box">
			<div class="col-md-6 col-sm-6 col-12 aos-init aos-animate" data-aos="fade-right" data-aos-duration="1200">
				<img src="<?php echo BASEURL.(!empty($homeData[9]->value)?$homeData[9]->value:'');?>" class="img-fluid" alt="image">
			</div>

			<div class="col-md-6 col-sm-6 col-12 aos-init aos-animate" data-aos="fade-left" data-aos-duration="1200">
				<div class="content_emc">
					<h3>EMC & RF Market Knowledge</h3>
					<?php echo !empty($homeData[8]->value)?$homeData[8]->value:'';?>
					<a href="<?php echo site_url('information'); ?>" class="btn_public">Read more</a>
				</div>
			</div>
		</div>
               
                <div class="image_top_set">
		<div class="row emx_box">
			<div class="col-md-6 col-sm-6 col-12 aos-init aos-animate" data-aos="fade-right" data-aos-duration="1200" id="banner-text">
				<div class="content_emc">
					<h3>Standards & Equipment</h3>
					<?php echo !empty($homeData[10]->value)?$homeData[10]->value:'';?>
					<a href="<?php echo site_url('information'); ?>" class="btn_public">Read more</a>
				</div>
			</div>

			<div class="col-md-6 col-sm-6 col-12 aos-init aos-animate" data-aos="fade-left" data-aos-duration="1200" id="banner-image">
                           <div>
				<img src="<?php echo BASEURL.(!empty($homeData[11]->value)?$homeData[11]->value:'');?>" class="img-fluid" alt="image">
                          </div>
			</div>
		</div>
             </div>

		<div class="row emx_box">
			<div class="col-md-6 col-sm-6 col-12 aos-init aos-animate" data-aos="fade-right" data-aos-duration="1200">
				<img src="<?php echo BASEURL.(!empty($homeData[13]->value)?$homeData[13]->value:'');?>" class="img-fluid" alt="image">
			</div>

			<div class="col-md-6 col-sm-6 col-12 aos-init aos-animate" data-aos="fade-left" data-aos-duration="1200">
				<div class="content_emc">
					<h3>Test Setup Products</h3>
					<?php echo !empty($homeData[12]->value)?$homeData[12]->value:'';?>
					<a href="<?php echo site_url('information'); ?>" class="btn_public">Read more</a>
				</div>
			</div>
		</div>


	</div>
</section>
<!--========EMC Section End=============-->

<!--========EMC Section End=============-->
<section class="get_support aos-init aos-animate" data-aos="zoom-in-up" data-aos-duration="1200">
	<div class="container contain_new">
		<div class="row">
			<div class="col-md-9 col-sm-6 col-12">
				<h3>GET THE SUPPORT YOU DESERVE TODAY</h3>
			</div>

			<div class="col-md-3 col-sm-6 col-12">
				<a href="<?php echo site_url('contact'); ?>" class="btn_public">Contact Us</a>
			</div>
		</div>
	</div>
</section>
<!--========EMC Section End=============-->


<!--========Services Section End=============-->
<!-- <section class="pd_all">
	<div class="container contain_new">

		<div class="row">
            <div class="col-md-12 col-sm-12 col-12">
                <div class="heading">

                    <h2>Services</h2>

                </div>
            </div>
        </div>

		<div class="row mar_top">
			<div class="col-md-3 col-sm-6 col-12 my_services aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">
				<div class="service_content">
					<div class="img_thumb">
						<img src="<?php echo BASEURL; ?>assets/web/images/sevices1.png" alt="images" class="img-fluid">
					</div>
					<div class="content">
						<h3>INVESTMENT</h3>
						<p>Test Equipment costs are high so make best use of your investment without waist. We can help you use what you have to it fullest potential. Or give direction for where to save $.</p>
					</div>
				</div>
			</div>
            
            <div class="col-md-3 col-sm-6 col-12 my_services aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">
				<div class="service_content">
					<div class="img_thumb">
						<img src="<?php echo BASEURL; ?>assets/web/images/sevices2.png" alt="images" class="img-fluid">
					</div>
					<div class="content">
						<h3>PROVE YOUR SETUP</h3>
						<p>Is your pre-compliance setup good enough or is your full compliant setup not rely 100%. Learn from from our experience, what is the best way to use the equipment you have.</p>
					</div>
				</div>
			</div>


			<div class="col-md-3 col-sm-6 col-12 my_services aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">
				<div class="service_content">
					<div class="img_thumb">
						<img src="<?php echo BASEURL; ?>assets/web/images/sevices3.png" alt="images" class="img-fluid">
					</div>
					<div class="content">
						<h3>ONSITE OR REMOTE</h3>
						<p>We travel to you for hands on support and help. This gives you the best dedicated quick response. In some cases we offer remote support which is sufficient and more economical.</p>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-12 my_services aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">
				<div class="service_content">
					<div class="img_thumb">
						<img src="<?php echo BASEURL; ?>assets/web/images/sevices4.png" alt="images" class="img-fluid">
					</div>
					<div class="content">
						<h3>TAKE THE NEXT STEP</h3>
						<p>Unsure how or where to start your EMC testing and/or need assistance to grow to the next level. You need our unbiased experience on your side. Please contact us!</p>
					</div>
				</div>
			</div>

		</div>
	</div>
</section> -->
<!--========Services Section End=============-->
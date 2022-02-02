<!--========header=============-->
<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">

    <div class="link_section">
        <h1>Partners</h1>
    </div>
</section>
<!--=============== Contact Section Start============ -->
<section class="partmer_section pd_all">
	<div class="container contain_new">
		
		<div class="partners">
			<?php if(!empty($partners)){ foreach($partners as $partnersval){ ?>

				<div class="row">
			<div class="col-md-4 col-sm-4 col-12 partners_col">
				<div class="log_brand zoom">
					<a href="<?php echo site_url('partners/'.encoding($partnersval->id)); ?>" ><img src="<?php echo BASEURL; ?><?=$partnersval->images;?>" alt="images" class="img-fluid"></a>
				</div>
			</div>

			<div class="col-md-8 col-sm-8 col-12 partners_col">
				<div class="log_brand">
					<?=  substr(strip_tags($partnersval->content),0,200) . "... ";?><a href="<?php echo site_url('partners/'.encoding($partnersval->id)); ?>" > Read more</a>
				</div>
			</div>
		</div>

                          
                          <?php } } ?> 
		
	</div>
	</div>
</section>

<!--=============== Contact Section Start============ -->

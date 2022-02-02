<!--========header=============-->
<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">

    <div class="link_section">
        <h1>Download</h1>
    </div>
</section>
<!--=============== Contact Section Start============ -->
<section class="partmer_section pd_all pdbtm60px">
	<div class="container contain_new">
		<?php 
		$documents = !empty($documents['result'])?$documents['result']:array();
		?>
		<div class="partners">
		<div class="row">
			<div class="col-md-3 col-sm-3 col-12 partners_col">
				<div class="log_brand zoom">
					<a href="<?php echo BASEURL.'document/'.encoding(1);?>"><img src="<?php echo !empty($documents[0]->image)?BASEURL.$documents[0]->image:'';?>" class="img-fluid"> </a>
					 Brochures
				</div>
			</div>

			<div class="col-md-3 col-sm-3 col-12 partners_col">
				<div class="log_brand zoom">
					<a href="<?php echo BASEURL.'document/'.encoding(2);?>"><img src="<?php echo !empty($documents[1]->image)?BASEURL.$documents[1]->image:'';?>" alt="manuals" class="img-fluid"></a>
					Manuals
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-12 partners_col">
				<div class="log_brand zoom">
					<a href="<?php echo BASEURL.'document/'.encoding(3);?>"><img src="<?php echo !empty($documents[2]->image)?BASEURL.$documents[2]->image:'';?>" alt="software-firmware" class="img-fluid"></a>
					Software/Firmware
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-12 partners_col">
				<div class="log_brand zoom">
					<a href="<?php echo BASEURL.'document/'.encoding(4);?>"><img src="<?php echo !empty($documents[3]->image)?BASEURL.$documents[3]->image:'';?>" alt="Fliers" class="img-fluid"></a>
					Fliers
				</div>
			</div>
			
		</div>
	</div>
	</div>
</section>

<!--=============== Contact Section Start============ -->

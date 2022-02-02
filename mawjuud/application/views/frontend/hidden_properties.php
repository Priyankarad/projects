<?php include APPPATH.'views/frontend/includes/header.php'; 
?>

<div class="compares-pma">
	<div class="container">
		<h2><span class="ti-plus"></span> Hidden Properties</h2>
		<h4 class="heding-cps"><a onclick="goBack();"><span class="ti-angle-left"></span> Back</a>
		</h4>
		<div class="row">
			<?php if(!empty($propertyData['result'])){ 
				foreach($propertyData['result'] as $property){
				 $property = (array)$property; ?>
					<div class="col s4 compare_div<?php echo $property['id'];?>">
						<div class="in_box">
							<div class="box_img1">
								<?php 
								$img = base_url().DEFAULT_PROPERTY_IMAGE;
								if(isset($property['thumbnail_photo_media'])){
									$imgArray = explode('|',$property['thumbnail_photo_media']); 
									$img = $imgArray[0];
								}
								?>
								<div class="remove-cmpres" onclick="removeProperty('hidden',<?php echo $property['id'];?>)"><span class="ti-trash"></span> Remove</div>
								<a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank" class="waves-effect waves-light"><img src="<?php echo $img;?>" alt="images">
								<span class="ForSale <?php echo ($property['property_type']=='sale')?'SGC1':'SGC';?>">For <?php echo isset($property['property_type'])?ucfirst($property['property_type']):'';?></span>


								<div class="box_cnts">
									<div class="bed_bath">
										<p>
											<?php if(isset($property['bathselect'])){ ?>
												<img src="<?php echo base_url();?>assets/images/bath.png" alt="images"> <?php echo $property['bathselect']?> 
											<?php } 

											if(isset($property['bedselect'])){ ?>
												|
												<img src="<?php echo base_url();?>assets/images/bed.png" alt="images"> <?php echo ($property['bedselect']==100)?"Studio":$property['bedselect'];?>
											<?php } ?>
											|<img src="<?php echo base_url();?>assets/images/size.png" alt="images"> <?php echo number_format($property['square_feet'])." Sq. ft.";?>
										</p>
									</div>
									<h4><?php echo isset($property['name'])?$property['name']:''; ?></h4>
									<h6><span class="ti-location-pin"></span> <?php echo isset($property['property_address'])?ucfirst($property['property_address']):'';?></h6>
									<h5>Price- Start From / <span><?php echo isset($property['property_price'])?number_format($property['property_price']):'';?> AED</span></h5>
								</div>
								</a>
							</div>
							<div class="compares_box">
								<div class="row">
									<div class="col s6">
										<p><b>Price:</b> <span>AED<?php echo isset($property['property_price'])?number_format($property['property_price']):'';?></span></p>
									</div>
									<div class="col s6">
										<p><b>Sq Ft:</b> <span><?php echo number_format($property['square_feet'])." Sq. ft.";?></span></p>
									</div>
									<div class="col s6">
										<p><b>Beds:</b> <span><?php if(isset($property['bedselect'])){  echo (($property['bedselect']==100)?"Studio":$property['bedselect']." ")." Beds"; } 
										?></span></p>
									</div>
									<div class="col s6">
										<p><b>Baths:</b> <span><?php echo $property['bathselect']?>  Bath</span></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php }
			}else{
				echo '<div style="color:red;text-align:center;">No properties found</div>';
			} ?>
		</div>
	</div>
</div>


<?php include APPPATH.'views/frontend/includes/footer.php'; ?>
<?php include APPPATH.'views/frontend/includes/footer_script.php'; ?>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/login.js?<?php echo $timeStamp;?>"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/compare_property.js?<?php echo $timeStamp;?>"></script>

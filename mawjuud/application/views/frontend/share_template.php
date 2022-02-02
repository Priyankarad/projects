<table style="font-family:tahoma;width:560px;margin:0 auto;border:1px solid #eeeeee;border-collapse:collapse;text-align:center;">
	<tr>
		<td>
			<a href="<?php echo base_url()?>" target="_blank" style="display: inline-block;width: 100%;padding: 20px;box-sizing: border-box;">
				<img src="<?php echo base_url();?>assets/images/logo.png" width="102" alt="mawjuud_img"/>
			</a>
		</td>
	</tr>
	<tr>
		<td style="padding-top: 15px;">
			<h3 style="font-size: 25px;letter-spacing: 0.5px;margin: 0;padding: 20px;">Hi <span>there!</span></h3>
		</td>
	</tr>
	<tr>
		<td style="padding-bottom: 24px;">
		
		<p style="font-size: 15px;padding: 0 60px;"><a href="#"><?php echo isset($sent_by)?$sent_by:'';?></a> wants to share a property on Mawjuud.com with you</p>

		<!-- <h5 style="font-size: 21px;font-weight: 400;letter-spacing: 0.4px;padding: 0 95px;margin: 0 0 15px 0;">I found this property on Mawjuud, Check it out!</h5> -->
		<h5 style="font-size: 21px;font-weight: 400;letter-spacing: 0.4px;padding: 0 95px;margin: 0 0 15px 0;"><?php echo isset($note)?$note:'';?></h5>
	
		<div class="hover_property" style="width: 100%;max-width: 340px;margin: 0 auto;"> 
		   <div style="box-shadow: 0px 0px 20px 0px #e6e6e6;text-align: left;transition: all 0.5s;margin-bottom: 25px;background: #fff;margin: 4px 4px;">
		      <div style="position:relative;height: 224px;background:#000;transition:all 0.5s;overflow: hidden;">
		         <a href="" target="_blank" style="display: inline-block;width: 100%;height: 100%;transition: all 0.5s;">
		            <img src="<?php echo isset($firstImg)?$firstImg:'';?>" alt="images" style="width:100%;height: 100%;object-fit: cover;transition: all 0.5s;opacity: 0.7;">
		            <span style="position: absolute;top: 0;z-index: 2;left: -26px;background: #00b050;display: inline-block;padding: 4px 20px 4px 35px;border-radius: 30px;color: #fff;transition: all 0.5s;font-size: 12px;" class="ForSale <?php echo ($propertyData->property_type=='sale')?'SGC1':'SGC';?>">For <?php echo isset($propertyData->property_type)?ucfirst($propertyData->property_type):'';?></span>
		            <div style="padding: 0px 42px 13px 14px;position: absolute;bottom: 0;left: 0;right: 0;width: 100%;z-index: 8;color: #fff;">
		               <div >
		                  <p style="color: #fff;line-height: 21px;font-size: 13px;margin-bottom: 0;">
                            <?php if(isset($propertyData->bathselect)){?>
                                <img src="<?php echo base_url();?>assets/images/bath.png" alt="images" style="width: 25px !important;display: inline-block !important;position: relative;top: 4px;">  <?php if($propertyData->bathselect!=0 && isset($propertyData->bathselect)){ 
                                    ?>
                                    <?php echo isset($propertyData->bathselect)?number_format($propertyData->bathselect):'';
                                }else{
                                    echo '-';
                                }
                                ?> 
                            <?php } 

                            if(isset($propertyData->bedselect)){ ?>
                                |
                                <img src="<?php echo base_url();?>assets/images/bed.png" alt="images" 
		                     style="width: 25px !important;display: inline-block !important;position: relative;top: 4px;">
                                <?php if(isset($propertyData->bedselect)){
                                    if($propertyData->bedselect == 100){
                                        echo 'Studio';
                                    }else if($propertyData->bedselect == 0){
                                        echo "-";
                                    }else{
                                        echo $propertyData->bedselect;
                                    }
                                }
                                ?>
                            <?php } ?>
                            |<img src="<?php echo base_url();?>assets/images/size.png" alt="images" style="    width: 25px !important;display: inline-block !important;position: relative;top: 4px;"> <?php echo number_format($propertyData->square_feet)." Sq. ft.";?>
                        </p>

		               </div>
		               <h4 style="font-size: 18px;margin: 6px 0;"><?php echo isset($propertyData->name)?$propertyData->name:''; ?></h4>
		               <h6 style="font-size: 14px;letter-spacing: 0.3px;color: #ffffff;width: 100%;overflow: hidden;max-width: 276px;margin: 0 0 9px 0;line-height: 17px;font-weight: 500;"> <span class="ti-location-pin" style="    position: absolute;left: -3px;top: 2px;"></span> <?php echo isset($propertyData->property_address)?ucfirst($propertyData->property_address):'';?> </h6>
		               <h5 style="font-size: 25px;font-weight: bold;margin-top: 5px;margin: 0;"><span class="PriceSp"><?php echo isset($propertyData->property_price)?number_format($propertyData->property_price):'';?> AED</span></h5>
		            </div>
		         </a>
		      </div>
		   </div>
		</div>
		<p><a href="<?php echo base_url();?>single_property?id=<?php echo encoding($propertyID);?>" target="_blank"><?php echo base_url();?>single_property?id=<?php echo encoding($propertyID);?></a>
		</p>
		<p style="font-size: 15px;line-height: 23px;padding:0 24px 0px 24px;letter-spacing: 0.3px;margin: 0;color: #515151;"><b>Thanks & Regards</b>
		</p>
		<p style="font-size: 15px;line-height: 23px;padding:0 24px 0px 24px;letter-spacing: 0.3px;margin: 0;color: #515151;">
				<b>Mawjuud Team</b>
		</p>
		</td>
	</tr>
</table>









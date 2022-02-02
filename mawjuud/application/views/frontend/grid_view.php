<div class="hover_property" data-prop_id="<?php echo $property['id'];?>">
    <div class="in_box">
        <div class="box_img1">
            <div class="compareX">
                <span class="ti-heart <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $property['id'];?>,this);">
                </span>
            </div>
            <div class="Mhideproperty" data-property = "<?php echo $property['id'];?>">
                <!-- <img src="<?php echo base_url();?>assets/images/map-icon/hide-icon.png" alt="images"/> -->
                <svg height="21px" width="21px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="512px" height="512px">
<g>
    <g>
        <g>
            <polygon points="353.574,176.526 313.496,175.056 304.807,412.34 344.885,413.804    " fill="#FFFFFF"/>
            <rect x="235.948" y="175.791" width="40.104" height="237.285" fill="#FFFFFF"/>
            <polygon points="207.186,412.334 198.497,175.049 158.419,176.52 167.109,413.804    " fill="#FFFFFF"/>
            <path d="M17.379,76.867v40.104h41.789L92.32,493.706C93.229,504.059,101.899,512,112.292,512h286.74     c10.394,0,19.07-7.947,19.972-18.301l33.153-376.728h42.464V76.867H17.379z M380.665,471.896H130.654L99.426,116.971h312.474     L380.665,471.896z" fill="#FFFFFF"/>
        </g>
    </g>
</g>
<g>
    <g>
        <path d="M321.504,0H190.496c-18.428,0-33.42,14.992-33.42,33.42v63.499h40.104V40.104h117.64v56.815h40.104V33.42    C354.924,14.992,339.932,0,321.504,0z" fill="#FFFFFF"/>
    </g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>

            </div>
            <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" class="waves-effect waves-light" target="_blank">
                <?php 
                $img = base_url().DEFAULT_PROPERTY_IMAGE;
                // if(!empty($property['thumbnail_photo_media'])){
                //     $imgArray = explode('|',$property['thumbnail_photo_media']); 
                //     $img = $imgArray[0];
                // }
                if(!empty($property['photo_media'])){
                    $imgArray = explode('|',$property['photo_media']); 
                    $img = $imgArray[0];
                }
                ?>
                <img src="<?php echo $img;?>" alt="images">
                <span class="ForSale <?php echo ($property['property_type']=='sale')?'SGC1':'SGC';?>">For <?php echo !empty($property['property_type'])?ucfirst($property['property_type']):'';?></span>

                <div class="box_cnts">
                    <div class="bed_bath">
                        <p>
                            <?php if(!empty($property['bathselect'])){?>
                                <img src="<?php echo base_url();?>assets/images/bath.png" alt="images"> 
                                <?php
                                if($property['bathselect'] == 0){
                                    echo '-';
                                }else{
                                    echo $property['bathselect'];
                                }
                                ?> 
                            <?php } 

                            if(!empty($property['bedselect'])){ ?>
                                |
                                <img src="<?php echo base_url();?>assets/images/bed.png" alt="images"> <?php 
                                if($property['bedselect']==100){
                                    echo "Studio";
                                }else if($property['bedselect'] == 0){
                                    echo "-";
                                }else{
                                    echo $property['bedselect'];
                                }
                                ?>
                            <?php } ?>
                            <img src="<?php echo base_url();?>assets/images/size.png" alt="images"><?php echo number_format($property['square_feet'])." Sq. ft.";?>
                        </p>
                    </div>
                    <h4><?php echo !empty($property['name'])?$property['name']:''; ?></h4>
                    <h6><span class="ti-location-pin"></span> <?php echo !empty($property['property_address'])?ucfirst($property['property_address']):'';?></h6>
                    <h5><span class="PriceSp"><?php echo !empty($property['property_price'])?number_format($property['property_price']):'';?> AED</span></h5>
                </div>
            </a>
            <?php 
            $img = 0;
            $images = !empty($property['photo_media'])?explode("|",$property['photo_media']):0;
            if($images){
                $img = count($images);
            }
            ?>
            <div class="MtotalPicsList">
                <i><?php echo $img;?></i>
                <span class="ti-camera"></span>
            </div>
        </div>
    </div>
</div>
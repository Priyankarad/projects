<?php include APPPATH.'views/frontend/includes/header.php'; ?>
<!--===========BANNER=================-->
<div class="banner_main">
    <div class="owl-carousel owl-theme" id="bannerSlider">
        <div class="item">
            <div class="height400" style="background:url('<?php echo base_url();?>assets/images/rent.jpg');">
            </div>
        </div>
        <div class="item">
            <div class="height400" style="background:url('<?php echo base_url();?>assets/images/sale.jpg');">
            </div>
        </div>
    </div>

    <div class="banner_form">
        <h3>Your Personal Property Portal in the UAE</h3>
        <div class="tab_3Tops">
            <ul class="tabs">
                <li class="tab"><a class="active waves-effect waves-light" href="#test1" id="clickRent">RENT</a></li>
                <li class="tab"><a class="waves-effect waves-light" href="#test2" id="clickBuy">BUY</a></li>
            </ul>
        </div>
        <div class="banner_frmS">
            <div id="test1">
                <div class="form_inner">
                    <form method="post" id="searchPropertyRentForm" action="<?php echo base_url();?>search_properties">
                        <div class="myinput_filds">
                            <div class="input-field">
                                <span class="ti-location-pin"></span>
                                <input type="hidden" name="property_rent" value="rent">
                                <input name="rent_address" id="rent_address" type="text" placeholder="City, Address, Neighbourhood, Buildings" class="validate">
                            </div>
                            <div class="input-field psoi_ups">
                                <button type="submit" class="srchbtn waves-effect waves-light rent_btn"><img src="<?php echo base_url()?>assets/images/searchicon.png"/> Search </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="test2">
                <div class="form_inner">
                    <form method="post" id="searchPropertySaleForm" action="<?php echo base_url();?>search_properties">
                        <div class="myinput_filds">
                            <div class="input-field">
                                <span class="ti-location-pin"></span>
                                <input type="hidden" name="property_sale" value="sale">
                                <input name="sale_address" id="sale_address" type="text" required="" placeholder="City, Address, Neighbourhood, Buildings" class="validate">
                            </div>
                            <div class="input-field psoi_ups">
                                <button type="submit" class="srchbtn waves-effect waves-light sale_btn"><img src="<?php echo base_url()?>assets/images/searchicon.png"/> Search </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="Coll_2actionS">
        <div class="container">
            <div class="row">
                <div class="col s8">
                    <p><b>List a Rental For Free,</b> Post your listings on the fastest growing Property Portal in the UAE</p>
                </div>
                <div class="col s4">
                    <div class="lern_moresX right"><a href="<?php echo base_url();?>add_property" target="_blank" class="btnblock waves-effect waves-light">Start Here</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===========BANNER=================-->


<!--===========WE MAKE HELP=================-->
<div class="wemake_help">
    <div class="container">
        <div class="we_help">
            <h1>We Help You</h1>
            <div class="row">
                <div class="col s6">
                    <div class="find_img">
                        <img src="<?php echo base_url()?>assets/images/home-parallax-2-1.jpg" alt="images" class="aves-effect waves-light" />
                    </div>
                </div>
                <div class="col s6">
                    <div class="find_cnt_im">
                        <div class="row"> 
                            <div class="col s6" style="border-bottom: 1px solid #f1f1f1;border-right: 1px solid #f1f1f1;">
                                <div class="my_field" >
                                    <a href="<?php echo base_url();?>property/setNearBy/rent" target="_blank">
                                        <span class="ti-location-pin"></span>  
                                        <h3>Find your property on the map</h3>
                                    </a>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="my_field">
                                    <a href="<?php echo base_url();?>agents" target="_blank">
                                        <span class="ti-user"></span> 
                                        <h3>Find trusted agents with experience</h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col s6">
                                <div class="my_field">
                                    <a href="<?php echo base_url();?>search_properties" target="_blank">
                                        <span class="ti-home"></span>  
                                        <h3>Pick and compare properties to rent or buy</h3>
                                    </a>
                                </div>
                            </div>
                            <div class="col s6" style="border-left: 1px solid #f1f1f1;border-top: 1px solid #f1f1f1;">
                                <div class="my_field" >
                                    <a href="<?php echo base_url();?>add_property" target="_blank">
                                        <span class="ti-export"></span> 
                                        <h3>List your properties online For FREE!!</h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===========WE MAKE HELP=================-->


<!--===========BOX_image=================-->
<div class="box-3in">
    <div class="container">
        <div class="heading_to">
            <h1>Recently Listed Properties</h1>
            <p>These are the most recent properties added, with featured listed first</p>
        </div>


        <div class="owl-carousel owl-theme" id="listproperty">
            <?php
            $randomIndex = array();
            for($i=0;$i<10;$i++){
                $randomIndex[] = mt_rand(0,49);
            }

            if(!empty($recentlyListed['result'])){
                foreach($randomIndex as $row){
                        $property = (array)$recentlyListed['result'][$row];
                        $favourite = ''; 
                        if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                            $favourite = 'fillHearts';
                        }
                    ?>
                    <div class="item">
                        <div class="in_box">
                            <div class="box_img1">
                                <div class="compareX">
                                    <span class="ti-heart <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $property['id'];?>,this);">
                                    </span>
                                </div>
                                <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" class="waves-effect waves-light" target="_blank">
                                    <?php 
                                    $img = base_url().DEFAULT_PROPERTY_IMAGE;
                                    if(isset($property['thumbnail_photo_media'])){
                                        $imgArray = explode('|',$property['thumbnail_photo_media']); 
                                        $img = $imgArray[0];
                                    }
                                    ?>
                                    <img src="<?php echo $img;?>" alt="images"/>
                                    <span class="ForSale <?php echo ($property['property_type']=='sale')?'SGC1':'SGC';?>">For <?php echo isset($property['property_type'])?ucfirst($property['property_type']):'';?></span>
                                    
                                    <div class="box_cnts">
                                        <div class="bed_bath">
                                            <p>
                                                <?php if(isset($property['bathselect'])){?>
                                                    <img src="<?php echo base_url();?>assets/images/bath.png" alt="images"> 
                                                    <?php
                                                    if($property['bathselect'] == 0){
                                                        echo '-';
                                                    }else{
                                                        echo $property['bathselect'];
                                                    }
                                                    ?> 
                                                <?php } 

                                                if(isset($property['bedselect'])){ ?>
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
                                        <h4><?php echo isset($property['title'])?substr($property['title'], 0, 30).'...':''; ?></h4>
                                        <h6><span class="ti-location-pin"></span> <?php echo isset($property['property_address'])?ucfirst($property['property_address']):'';?></h6>
                                        <h5><span class="PriceSp"><?php echo isset($property['property_price'])?number_format($property['property_price']):'';?> AED</span></h5>
                                    </div>
                                </a>
                            </div>
                        </div>   
                    </div>
                <?php 
                }
            }
            ?>
        </div>
    </div>
</div>
<!--===========BOX_image=================-->





<!--===========BOX_image=================-->
<div class="box-3in gray_bgsX">
    <div class="container">
        <div class="heading_to">
            <h1>Most Viewed Properties</h1>
            <p>These are the Most Viewed Properties added, with featured listed first</p>
        </div>

        <div class="owl-carousel owl-theme" id="listproperty1">
            <?php
            if(!empty($mostViewed['result'])){
                foreach($randomIndex as $row){
                    $property = (array)$mostViewed['result'][$row];
                    $favourite = ''; 
                    if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                        $favourite = 'fillHearts';
                    }
                    ?>
                    <div class="item">
                        <div class="in_box">
                            <div class="box_img1">
                                <div class="compareX">
                                    <span class="ti-heart <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $property['id'];?>,this);">
                                    </span>
                                </div>
                                <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" class="waves-effect waves-light" target="_blank">
                                    <?php 
                                    $img = base_url().DEFAULT_PROPERTY_IMAGE;
                                    if(isset($property['thumbnail_photo_media'])){
                                        $imgArray = explode('|',$property['thumbnail_photo_media']); 
                                        $img = $imgArray[0];
                                    }
                                    ?>
                                    <img src="<?php echo $img;?>" alt="images"/>
                                    <span class="ForSale <?php echo ($property['property_type']=='sale')?'SGC1':'SGC';?>">For <?php echo isset($property['property_type'])?ucfirst($property['property_type']):'';?></span>
                                    
                                    <div class="box_cnts">
                                        <div class="bed_bath">
                                            <p>
                                                <?php if(isset($property['bathselect'])){?>
                                                    <img src="<?php echo base_url();?>assets/images/bath.png" alt="images"> 
                                                    <?php
                                                    if($property['bathselect'] == 0){
                                                        echo '-';
                                                    }else{
                                                        echo $property['bathselect'];
                                                    }
                                                    ?> 
                                                <?php } 

                                                if(isset($property['bedselect'])){ ?>
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
                                        <h4><?php echo isset($property['title'])?substr($property['title'], 0, 30).'...':''; ?></h4>
                                        <h6><span class="ti-location-pin"></span> <?php echo isset($property['property_address'])?ucfirst($property['property_address']):'';?></h6>
                                        <h5><span class="PriceSp"><?php echo isset($property['property_price'])?number_format($property['property_price']):'';?> AED</span></h5>
                                    </div>
                                </a>
                            </div>
                        </div>   
                    </div>
                <?php }
            }
            ?>
        </div>

    </div>
</div>
<!--===========BOX_image=================-->


<!--===========BOX_image=================-->
<div class="box-3in largest_vivewsX">
    <div class="container">
        <div class="heading_to">
            <h1>Largest Properties</h1>
            <p>These are the Largest Homes added, with featured listed first</p>
        </div>

        <div class="owl-carousel owl-theme" id="listproperty1">
            <?php
            if(!empty($largestPropeties['result'])){
                foreach($randomIndex as $row){
                    $property = (array)$largestPropeties['result'][$row];
                    $favourite = ''; 
                    if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                        $favourite = 'fillHearts';
                    }
                    ?>
                    <div class="item">
                        <div class="in_box">
                            <div class="box_img1">
                                <div class="compareX">
                                    <span class="ti-heart <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $property['id'];?>,this);">
                                    </span>
                                </div>
                                <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" class="waves-effect waves-light" target="_blank">
                                    <?php 
                                    $img = base_url().DEFAULT_PROPERTY_IMAGE;
                                    if(isset($property['thumbnail_photo_media'])){
                                        $imgArray = explode('|',$property['thumbnail_photo_media']); 
                                        $img = $imgArray[0];
                                    }
                                    ?>
                                    <img src="<?php echo $img;?>" alt="images"/>
                                    <span class="ForSale <?php echo ($property['property_type']=='sale')?'SGC1':'SGC';?>">For <?php echo isset($property['property_type'])?ucfirst($property['property_type']):'';?></span>
                                    
                                    <div class="box_cnts">
                                        <div class="bed_bath">
                                            <p>
                                                <?php if(isset($property['bathselect'])){?>
                                                    <img src="<?php echo base_url();?>assets/images/bath.png" alt="images"> 
                                                    <?php
                                                    if($property['bathselect'] == 0){
                                                        echo '-';
                                                    }else{
                                                        echo $property['bathselect'];
                                                    }
                                                    ?> 
                                                <?php } 

                                                if(isset($property['bedselect'])){ ?>
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
                                        <h4><?php echo isset($property['title'])?substr($property['title'], 0, 30).'...':''; ?></h4>
                                        <h6><span class="ti-location-pin"></span> <?php echo isset($property['property_address'])?ucfirst($property['property_address']):'';?></h6>
                                        <h5><span class="PriceSp"><?php echo isset($property['property_price'])?number_format($property['property_price']):'';?> AED</span></h5>
                                    </div>
                                </a>
                            </div>
                        </div>   
                    </div>
                <?php }
            }
            ?>
        </div>
    </div>
</div>
<!--===========BOX_image=================-->


<!--===========BOX_image=================-->
<div class="box-3in gray_bgsX">
    <div class="container">
        <div class="heading_to">
            <h1>High-End Properties</h1>
            <p>These are the Most Viewed Properties added, with featured listed first</p>
        </div>

       <div class="owl-carousel owl-theme" id="listproperty3">
            <?php
            if(!empty($highEnd['result'])){
                foreach($randomIndex as $row){
                    if(isset($highEnd['result'][$row]) && !empty($highEnd['result'][$row])){
                        $property = (array)$highEnd['result'][$row];
                        $favourite = ''; 
                        if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                            $favourite = 'fillHearts';
                        }
                    ?>
                        <div class="item">
                            <div class="in_box">
                                <div class="box_img1">
                                    <div class="compareX">
                                        <span class="ti-heart <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $property['id'];?>,this);">
                                        </span>
                                    </div>
                                    <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" class="waves-effect waves-light" target="_blank">
                                        <?php 
                                        $img = base_url().DEFAULT_PROPERTY_IMAGE;
                                        if(isset($property['thumbnail_photo_media'])){
                                            $imgArray = explode('|',$property['thumbnail_photo_media']); 
                                            $img = $imgArray[0];
                                        }
                                        ?>
                                        <img src="<?php echo $img;?>" alt="images"/>
                                        <span class="ForSale <?php echo ($property['property_type']=='sale')?'SGC1':'SGC';?>">For <?php echo isset($property['property_type'])?ucfirst($property['property_type']):'';?></span>
                                        
                                        <div class="box_cnts">
                                            <div class="bed_bath">
                                                <p>
                                                    <?php if(isset($property['bathselect'])){?>
                                                        <img src="<?php echo base_url();?>assets/images/bath.png" alt="images"> 
                                                        <?php
                                                        if($property['bathselect'] == 0){
                                                            echo '-';
                                                        }else{
                                                            echo $property['bathselect'];
                                                        }
                                                        ?> 
                                                    <?php } 

                                                    if(isset($property['bedselect'])){ ?>
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
                                            <h4><?php echo isset($property['title'])?substr($property['title'], 0, 30).'...':''; ?></h4>
                                            <h6><span class="ti-location-pin"></span> <?php echo isset($property['property_address'])?ucfirst($property['property_address']):'';?></h6>
                                            <h5><span class="PriceSp"><?php echo isset($property['property_price'])?number_format($property['property_price']):'';?> AED</span></h5>
                                        </div>
                                    </a>
                                </div>
                            </div>   
                        </div>
                <?php }
                }
            }
            ?>
        </div>

    </div>
</div>
<!--===========BOX_image=================-->



<!--==============car===========-->
<!--===========BOX_image=================-->
<div class="car_rent">
    <div class="container">
        <div class="rentcarmain">
            <div class="row">
                <div class="col s6">
                    <div class="car_rentimg">
                        <img src="<?php echo base_url()?>assets/images/HOTEL.png" alt="images">
                        <h5 class="waves-effect waves-light"> <span class="ti-home"></span> MAWJUUD</h5>
                    </div>
                </div>
                <div class="col s6">
                    <div class="car_cntfull">
                        <h3>Your desired property from Mawjuud</h3>
                        <p>Mawjuud displays a fantastic selection of properties from multiple agencies and developers based in the region. We facilitate the listings on our portal for FREE! Giving you more choice to find your dream home as a property seeker than any other website in the region. Browse our search today for a fine selection of UAE's real estate properties showcased from the top Agencies & Brokers in the country. </p>
<!--                         <a class="btnblock waves-effect waves-light" href="javascript:void(0)">View More Offers</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  



<!--===========BOX_image=================-->
<!-- <div class="logo_slider">
    <div class="container">
        <div class="row">
            <div class="col s6">
                <div class="logo_im">
                    <h2><span>Featured Agents & Agencies</span></h2>
                    <div class="our_agentS row">
                        <div class="col s6">
                            <img src="https://www.mawjuud.com/wp-content/uploads/2018/06/Mylo-Real-Estate-Dubai.png?189db0&189db0">
                            <div class="find_bn">
                                <a href="">Find out more</a>
                            </div>
                        </div>
                        <div class="col s6">
                            <img src="https://www.mawjuud.com/wp-content/uploads/2018/04/banke-real-estate-1.jpg?189db0&189db0">
                            <div class="find_bn">
                                <a href="">Find out more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s6">
                <div class="logo_im">
                    <h2><span>Featured Developers</span></h2>
                    <div class="our_agentS row">
                        <div class="col s6">
                            <img src="https://mawjuud.com/wp-content/themes/realeswp/Alef_Brand-Identity_RGB.png">
                            <div class="find_bn">
                                <a href="">Find out more</a>
                            </div>
                        </div>
                        <div class="col s6">
                            <img src="https://mawjuud.com/wp-content//themes/realeswp/damac-logo.png">
                            <div class="find_bn">
                                <a href="">Find out more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->


<?php include APPPATH.'views/frontend/includes/footer.php'; ?>
<?php include APPPATH.'views/frontend/includes/footer_script.php'; ?>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyB1msoSFExJ6QVhosWAT9U30xQ7CbwvuM0"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/login.js?<?php echo $timeStamp;?>"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/home.js?<?php echo $timeStamp;?>"></script>



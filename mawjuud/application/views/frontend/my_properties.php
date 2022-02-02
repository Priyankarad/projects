<?php include APPPATH.'views/frontend/includes/header.php'; 
?>
<section id="serch_prprty">
    <div class="container-fluid">
        <!--=============main_left-right============-->
        <div class="row">
            <div class="col s7 pd_rgtzero pd_lftzero">
                <!--=============main_left-right============-->
                <div class="srch_rsltlft scroll">

                    <!--==============Property_list================-->
                    <div class="property_searchI">
                        <div class="row">
                            <?php 
                            $location = array();
                            if(!empty($propertyData)){ 
                                $count = 0;
                                foreach($propertyData as $property){ 
                                    $location[$count][] = $property['property_address'];
                                    $location[$count][] = $property['latitude'];
                                    $location[$count][] = $property['longitude'];
                                    $count++;
                                    ?>
                                    <div class="col s6 box_div">
                                        <div class="in_box">
                                            <div class="box_img1">
                                                
                                                <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank" class="waves-effect waves-light">
                                                    <?php 
                                                    $img = base_url().DEFAULT_PROPERTY_IMAGE;
                                                    if(isset($property['thumbnail_photo_media'])){
                                                        $imgArray = explode('|',$property['thumbnail_photo_media']); 
                                                        $img = $imgArray[0];
                                                    }
                                                    ?>
                                                    <img src="<?php echo $img;?>" alt="images">
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
                                                                |<img src="<?php echo base_url();?>assets/images/size.png" alt="images"> <?php echo number_format($property['square_feet'])." Sq. ft.";?></p>
                                                            </div>
                                                            <h4><?php echo isset($property['name'])?$property['name']:''; ?></h4>
                                                            <h6><span class="ti-location-pin"></span> <?php echo isset($property['property_address'])?ucfirst($property['property_address']):'';?></h6>
                                                            <h5><span class="PriceSp"><?php echo isset($property['property_price'])?number_format($property['property_price']):'';?> AED</span></h5>
                                                        </div>
                                                    </a>
                                                    <?php 
                                                    $img = 0;
                                                    $images = isset($property['thumbnail_photo_media'])?explode("|",$property['thumbnail_photo_media']):0;
                                                    if($images){
                                                        $img = count($images);
                                                    }
                                                    ?>
                                                    <div class="MtotalPicsList"><i><?php echo $img;?></i> <span class="ti-camera"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <div class="signin_error card-panel red lighten-3">
                                        <strong>No properties found</strong>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                        <!--==============Property_list================-->
                        <div class="photoclktopH">
                        </div>
                        <!--=============main_left-right============-->
                    </div>
                </div>
                <div class="col s5 pd_lftzero pd_rgtzero">
                    <div id="search_map" class="custom_search_map" width="100%">  
                    </div>
                </div>
            </div>
            <!--=============main_left-right============-->
        </div>
    </section>
    <?php include APPPATH.'views/frontend/includes/footer_script.php'; ?>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=AIzaSyBFzzVfXfUc91Eb1CWCfPVZZzgMB0U5xVU"></script>
    <script type="text/javascript">
        /*For google map*/
        var markers = [];
        var locations = <?php echo isset($location)?json_encode($location):'' ?>;
        var map = new google.maps.Map(document.getElementById('search_map'), {
            zoom: 12,
            center: new google.maps.LatLng(25.276987, 55.296249),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        for (i = 0; i < locations.length; i++) {  
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][0]+"<br>coordinates: "+locations[i][1]+" , "+locations[i][2]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            markers.push(marker);
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

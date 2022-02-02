<?php include APPPATH.'views/frontend/includes/header.php'; 
$sessionData = '';
if($this->session->userdata('sessionData')){
    $sessionData = $this->session->userdata('sessionData');
}
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fancybox.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/lightslider.min.css" />

<!--===================single search ===================-->
<div class="m-singlepage">
    <div class="container">
        <div class="m-singleproperty">
            <div class="row">
                <div class="col s5">
                    <input type="hidden" name="latitude" id="latitude" value="<?php echo isset($propertyData->latitude)?$propertyData->latitude:'';?>">
                    <input type="hidden" name="longitude" id="longitude" value="<?php echo isset($propertyData->longitude)?$propertyData->longitude:'';?>">
                    <input type="hidden" name="property_address" id="property_address" value="<?php echo isset($propertyData->property_address)?$propertyData->property_address:'';?>">
                    <!-- <span class="ti-home"> </span> -->
                   <img src="<?php echo base_url();?>assets/images/<?php echo $propertyData->cat_img;?>" class="singlehomepg" alt=""/> 
                    <h3><?php echo isset($propertyData->title)?$propertyData->title:'';?></h3>
                    <div class="m-rentBuy <?php echo ($propertyData->property_type == 'sale')?'SGC1':'SGC';?>"><?php echo isset($propertyData->property_type)?ucfirst($propertyData->property_type):'';?></div>
                </div>
                <div class="col s3">
                    <ul class="selectBedBtAed">
                        <li> <?php echo isset($propertyData->property_price)?number_format($propertyData->property_price):'';?><p>AED</p>
                        </li>
                        <li>
                            <?php 
                            if(isset($propertyData->bedselect)){
                                if($propertyData->bedselect == 100){
                                    echo 'Studio';
                                }else if($propertyData->bedselect == 0){
                                    echo "-";
                                }else{
                                    echo $propertyData->bedselect;
                                }
                            }
                            ?> 
                            <p>Beds</p>
                        </li>
                        <li>
                            <?php if($propertyData->bathselect!=0 && isset($propertyData->bathselect)){ 
                                ?>
                                <?php echo isset($propertyData->bathselect)?number_format($propertyData->bathselect):'';
                            }else{
                                echo '-';
                            } ?>
                            <p>Baths</p>
                        </li>
                    </ul>
                </div>
                <div class="col s4">
                    <ul class="m-shares">
                        <?php 
                        $favourite = '';
                        if(!empty($favouriteProperties)){
                            $favourite = 'fillHearts';
                        }

                        $compare = '';
                        if(!empty($compareProperties)){
                            $compare = 'style="color:#ff8787"';
                        }
                        ?>
                        <!-- <li><a class="modal-trigger" href="#loginmodal"><span class="ti-heart"></span></a></li> -->
                        <li><a><span class="ti-heart <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $propertyData->id;?>,this);"></span></a></li>
                        <li><a><span class="ti-plus" onclick="compareProperty(<?php echo $propertyData->id;?>,this);" <?php echo $compare;?>></span></a></li>
                        <li><a class="modal-trigger" href="#sharelisting"><span class="ti-share"></span></a></li>
                    </ul>
                </div>
            </div>

            <!--===============sharelisting================-->
            <!--===============sharelisting================-->
            <div id="sharelisting" class="modal custompopupdesign sharelisting">
                <a href="#!" class="modal-close waves-effect modal_closeA">×</a>    
                <form id="shareForm" method="post">   
                    <h4 class="modal-title">Share</h4>
                    <div class="row">
                        <div class="col s12">
                            <textarea class="materialize-textarea" placeholder="Enter Your Note" id="note" name="note" style="height: 45px;"></textarea>
                            <input type="hidden" name="property_ids" value="<?php echo $propertyData->id;?>">
                            <input type="email" name="email[]" class="form-control" placeholder="Email Address">
                            <input type="email" name="email[]" class="form-control hiddenAdemail" placeholder="Additional Email Address">
                            <div class="addnewEm">Add additional email adddress <span class="ti-plus"></span></div>
                            <div class="btn-group-p">
                                <button type="submit" class="sharesubbtn waves-effect waves-light">Submit</button>
                                <button type="submit" class="cancelbshare">Cancel</button>
                            </div>
                            <?php $photos = isset($propertyData->thumbnail_photo_media)?$propertyData->thumbnail_photo_media:'';
                            $photoArray = explode("|",$photos);
                            ?>
                            <div class="footer-share-sc">
                                <a href="javascript:void(0)"  onclick="submitAndShare('<?php if(!empty($photoArray[0]) && isset($photoArray[0])){ echo $photoArray[0];}?>','<?php echo $propertyData->title;?>','<?php echo base_url();?>single_property?id=<?php echo encoding($propertyData->id);?>')" target="_blank"><span class="ti-facebook"></span></a>
                                <a href="http://pinterest.com/pin/create/button/?url=<?php echo base_url();?>single_property?id=<?php echo encoding($propertyData->id);?>&media=<?php if(!empty($photoArray[0]) && isset($photoArray[0])){ echo $photoArray[0];}?>&description=<?php echo $propertyData->title;?>" class="pin-it-button" count-layout="horizontal" target="_blank"><span class="ti-pinterest"></span></a>
                                <a href="https://twitter.com/share?url=<?php echo base_url();?>single_property?id=<?php echo encoding($propertyData->id);?>" target="_blank"><span class="ti-twitter"></span></a>
                                <a href="https://plus.google.com/share?url=<?php echo base_url();?>single_property?id=<?php echo encoding($propertyData->id);?>" target="_blank"><span class="ti-google"></span></a>
                                <a href="whatsapp://send?text=<?php echo base_url();?>single_property?id=<?php echo encoding($propertyData->id);?>" data-action="share/whatsapp/share"><span><img src="<?php echo base_url();?>assets/images/whatsappicon.png"></span></a>

                            </div>
                            <?php 
                            $img = base_url().DEFAULT_PROPERTY_IMAGE;
                            if(isset($propertyData->thumbnail_photo_media)){
                                $imgArray = explode('|',$propertyData->thumbnail_photo_media); 
                                $img = $imgArray[0];
                            }
                            ?>
                            <input type="hidden" name="first_img" value="<?php echo $img;?>">
                        </div>
                    </div>
                </form>
            </div>
            <!--===============sharelisting================-->
            <!--===============sharelisting================-->


            <!--===============slider-img==============-->
            <div class="row">
                <div class="col s8 pdright0">
                    <div class="single-left">
                        <div class="cover-bothslider">
                            <div id="topcar" class="owl-carousel owl-theme slider_select">
                                <?php $photos = isset($propertyData->photo_media)?$propertyData->photo_media:'';
                                $photoArray = explode("|",$photos);
                                if(!empty($photoArray[0]) && isset($photoArray[0])){ 
                                    foreach($photoArray as $photo){ ?>
                                        <div class="item">
                                            <a href="<?php echo $photo;?>" data-fancybox="images">
                                                <div class="big-img-slider">
                                                    <img src="<?php echo $photo;?>" class="img-responsive" alt="images">
                                                </div>
                                            </a>
                                        </div>
                                    <?php }
                                }else { ?>
                                    <div class="item">
                                        <a href="<?php echo base_url().DEFAULT_PROPERTY_IMAGE;?>" data-fancybox="images">
                                            <div class="big-img-slider">
                                                <img src="<?php echo base_url().DEFAULT_PROPERTY_IMAGE;?>" class="img-responsive" alt="images">
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>  

                            <div id="topcarthumb" class="owl-carousel owl-theme slider_select ">
                                <?php $photos = isset($propertyData->photo_media)?$propertyData->photo_media:'';
                                $photoArray = explode("|",$photos);
                                if(!empty($photoArray[0]) && isset($photoArray[0])){ 
                                    foreach($photoArray as $photo){ ?>
                                        <div class="item">
                                            <div class="big-img-slider1">
                                                <img src="<?php echo $photo;?>" class="img-responsive" alt="images">
                                            </div>
                                        </div>
                                    <?php }
                                }else { ?>
                                    <div class="item">
                                        <div class="big-img-slider1">
                                            <img src="<?php echo base_url().DEFAULT_PROPERTY_IMAGE;?>" class="img-responsive" alt="images">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>    
                            <!-- <div class="static-sl-rimg"><img src="<?php echo base_url(); ?>assets/images/streetview.png" alt=""/></div> -->
                        </div>

                        <div class="inner-mbedbath">
                            <ul class="selectBedBtAed">
                                <li>
                                    <img src="<?php echo base_url(); ?>assets/images/bed1.png" alt="">
                                    <p>
                                        <?php if(isset($propertyData->bedselect)){ 

                                            if($propertyData->bedselect == 100){
                                                echo 'Studio Bedrooms';
                                            }else if($propertyData->bedselect == 0){
                                                echo "- Bedrooms";
                                            }else{
                                                echo $propertyData->bedselect." Bedrooms";
                                            }
                                            ?>
                                        <?php } ?>
                                    </p>
                                </li>
                                <li>

                                    <img src="<?php echo base_url(); ?>assets/images/bath1.png" alt="">
                                    <p>
                                        <?php if($propertyData->bathselect!=0 && isset($propertyData->bathselect)){ ?>
                                            <?php echo isset($propertyData->bathselect)?number_format($propertyData->bathselect)." Bathrooms":'';?> 

                                        <?php }else{
                                            echo "- Bathrooms";
                                        } ?>
                                    </p>
                                </li>
                                <li><img src="<?php echo base_url(); ?>assets/images/squares.png" alt=""> <p><?php echo isset($propertyData->square_feet)?number_format($propertyData->square_feet)." Sq. ft.":'';?></p></li>
                                <!-- <li><span>Building Name</span> <p>Damac Park Towers</p></li> -->
                                <li><span>Address</span> <p><?php echo isset($propertyData->property_address)?$propertyData->property_address:'';?></p></li>
                            </ul>
                            <ul class="selectBedBtAed">
                                <li><?php 
                                if(isset($propertyData->property_price)){
                                    echo number_format($propertyData->property_price).'/'.$propertyData->rent_duration;
                                }
                                ?><p>AED</p></li>
                                <li>Published <p><?php echo (isset($propertyData->publish_date) && $propertyData->publish_date !='0000-00-00')?date("d-m-Y",strtotime($propertyData->publish_date)):'';?></p></li>
                                <li>Available <p><?php echo isset($propertyData->date_available)?date("d-m-Y",strtotime($propertyData->date_available)):'';?></p></li>
                                <li>View <p><?php echo isset($propertyData->view_type)?ucwords($propertyData->view_type)." View":'-';?></p></li>
                            </ul>
                            <div class="quick-vew mp-viwedsa">
                                <span><?php echo isset($propertyData->page_view)?($propertyData->page_view+1):'-';?></span>
                                <img src="<?php echo base_url(); ?>assets/images/serchV.png" alt="">
                            </div>
                            <div class="Furnishings-single">
                                <p><b>Furnishings</b> <b><?php echo isset($propertyData->furnishing)?ucwords($propertyData->furnishing):'-';?></b></p>
                            </div>
                        </div>

                        <div class="collaspe-mmenu">
                            <ul class="collapsible1">
                                <li class="">
                                    <div class="collapsible-header">About this Property  <span class="ti-angle-down rotateicon-m"></span></div>
                                    <div class="collapsible-body">
                                        <div class="collapsible-iner">
                                            <h6><?php echo isset($propertyData->title)?$propertyData->title:'';?></h6>
                                            <p class="show-read-more"><?php echo (isset($propertyData->description) && $propertyData->description!='Add your Description here')?$propertyData->description:'';?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php 
                                $amenities = isset($propertyData->amenities)?unserialize($propertyData->amenities):'';
                                if(!empty($amenities)){ ?>
                                    <li class="">
                                        <div class="collapsible-header">Property Features <span class="ti-angle-down rotateicon-m"></span></div>
                                        <div class="collapsible-body">
                                            <div class="collapsible-iner">
                                                <div class="row">
                                                    <?php 
                                                    foreach($amenities as $ame){
                                                        if(in_array($ame,$amenities_id)){
                                                            ?>
                                                            <div class="col s3">
                                                                <div class="fet-propertys">
                                                                    <img src="<?php echo base_url();?>assets/images/amenities/<?php echo $amenities_img[$ame];?>" alt="icons" style="cursor: default; width: 36px;">
                                                                    <p><?php echo $amenities_name[$ame];?></p>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    } 
                                                    ?>
                                                </div>
                                            </div>  
                                        </div>
                                    </li>
                                <?php } ?>
<?php /*                           
<li class="">
<div class="collapsible-header">Activity <span class="ti-angle-down rotateicon-m"></span></div>
<div class="collapsible-body">
<div class="collapsible-iner daysviwed2">
<div class="row">
<div class="col s4">
<div class="quick-vew">
<img src="<?php echo base_url(); ?>assets/images/calendari.png" alt="">
<span>
<?php
$publishDate = isset($propertyData->publish_date)?date('Y-m-d',strtotime($propertyData->publish_date)):'';
if($publishDate!=''){
$dateToday = date('Y-m-d');
$date1 = date_create($publishDate);
$date2 = date_create($dateToday);
$diff1 = date_diff($date1,$date2);
$daysdiff = $diff1->format("%R%a");
$daysdiff = abs($daysdiff);
echo $daysdiff;
}else{
echo "-";
}
?>
</span>
<p>Days on Mawjuud</p>
</div>
</div>
<div class="col s4">
<div class="quick-vew">
<img src="<?php echo base_url(); ?>assets/images/serchV.png" alt="">
<span><?php echo isset($propertyData->page_view)?$propertyData->page_view:'';?></span>
<p>Viewed</p>
</div>
</div>
<div class="col s4">
<div class="quick-vew">
<img src="<?php echo base_url(); ?>assets/images/save-v.png" alt="">
<span><?php echo isset($totalSaved['total_count'])?$totalSaved['total_count']:''; ?></span>
<p>Saved</p>
</div>
</div>
</div>
</div>
</div>
</li>
*/?>

<?php if($propertyData->property_type=='sale'){ ?>

    <li class="">
        <div class="collapsible-header">Mortgage and Affordability <span class="ti-angle-down rotateicon-m"></span></div>
        <div class="collapsible-body">
            <div class="collapsible-iner mortgage-mj">
                <form>
                    <div class="row">
                        <div class="col s4">
                            <div class="input-field dollerLeft-m">
                                <label>Home price</label>
                                <input name="home_price" id="home_price"type="text" value="<?php echo isset($propertyData->property_price)?number_format($propertyData->property_price):'';?>" onkeyup="emiCalculation();">
                                <span class="dlrPs"><img src="<?php echo base_url(); ?>assets/images/aed-img.png" alt="images" /></span>
                            </div>
                            <div class="input-field dollerLeft-m2">
                                <div class="row">
                                    <div class="col s8">
                                        <label class="active">Down payment</label>
                                        <input name="down_payment" id="down_payment" type="text" value="0" onkeyup="downPaymentCalc('payment');">
                                        <span class="dlrPs"><img src="<?php echo base_url(); ?>assets/images/aed-img.png" alt="images" /></span>
                                    </div>
                                    <div class="col s4 rightpdbk">
                                        <input name="percent" id="percent" type="text" value="0" onkeyup="downPaymentCalc('percent');">
                                        <span><img src="<?php echo base_url(); ?>assets/images/prtshit.png" alt="images" /></span>
                                    </div>
                                </div>

                            </div>
                            <div class="input-field slctimg8">
                                <select id="years" name="years" onchange="emiCalculation();">
                                    <option value="10">10 year </option>
                                    <option value="5">5 year </option>  
                                    <option value="20">20 year </option>

                                </select>
                                <label>Loan program</label>
                            </div>
                            <div class="input-field rightpdbk">
                                <label>Interest rate</label>
                                <input name="interest_rate" id="interest_rate" type="text" value="5" onkeyup="emiCalculation();">
                                <span class="pfixedjh"><img src="<?php echo base_url(); ?>assets/images/prtshit.png" alt="images"></span>
                            </div>
                            <div class="input-field EMItop20">
                                <label>EMI</label>
                                <input name="emi" id="emi" type="text" value="<?php echo isset($emi)?number_format($emi,2):0;?>" readonly="">
                                <span class="dlrPs"><img src="<?php echo base_url(); ?>assets/images/aed-img.png" alt="images" /></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </li><?php } ?>
        <li class="">
            <div class="collapsible-header">Estimated Home Expenses <span class="ti-angle-down rotateicon-m"></span></div>
            <div class="collapsible-body">
                <div class="collapsible-iner">
                    <div class="row customcsspms">
                        <div class="col s3">
                            <div class="quick-vew">
                                <img src="<?php echo base_url(); ?>assets/images/estimated-icon/estimate1.png" alt="">
                                <h5>230 AED / Month </h5>
                            </div>
                        </div>
                        <div class="col s3">
                            <div class="quick-vew">
                                <img src="<?php echo base_url(); ?>assets/images/estimated-icon/estimate2.png" alt="">
                                <h5>230 AED / Month </h5>
                            </div>
                        </div>
                        <div class="col s3">
                            <div class="quick-vew">
                                <img src="<?php echo base_url(); ?>assets/images/estimated-icon/estimate3.png" alt="">
                                <h5>50 AED / Month </h5>
                            </div>
                        </div>
                        <div class="col s3">
                            <div class="quick-vew">
                                <img src="<?php echo base_url(); ?>assets/images/estimated-icon/estimate4.png" alt="">
                                <h5>150 AED / Month</h5>
                            </div>
                        </div>
                        <div class="col s3">
                            <div class="quick-vew">
                                <img src="<?php echo base_url(); ?>assets/images/estimated-icon/estimate5.png" alt="">
                                <h5>150 AED / Month</h5>
                            </div>
                        </div>
                    </div>
                    <p class="grayfclr">* Estimated based on a residential property size of 1000 – 1500 Sq. Ft.</p>
                </div>
            </div>
        </li>
        <li class="">
            <div class="collapsible-header">Nearby Similar Properties <span class="ti-angle-down rotateicon-m"></span></div>
            <div class="collapsible-body">
                <div class="collapsible-iner">
                    <?php if(!empty($nearByPropertyData)){ ?>
                        <div class="owl-carousel owl-theme" id="listproperty1">
                            <?php
                            foreach($nearByPropertyData as $prop){
                                if($prop['id'] != $propertyData->id){
                                    $favourite = '';
                                    if(!empty($favourite_properties) && in_array($prop['id'],$favourite_properties)){
                                        $favourite = 'fillHearts';
                                    }
                                    ?>
                                    <div class="item">
                                        <div class="in_box">
                                            <div class="box_img1">
                                                <div class="compareX"><span class="ti-heart <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $prop['id'];?>,this);"></span></div>
                                                <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($prop['id']);?>" class="waves-effect waves-light">
                                                    <?php 
                                                    $img = base_url().DEFAULT_PROPERTY_IMAGE;
                                                    if(isset($prop['thumbnail_photo_media'])){
                                                        $imgArray = explode('|',$prop['thumbnail_photo_media']); 
                                                        $img = $imgArray[0];
                                                    }
                                                    ?>
                                                    <img src="<?php echo $img;?>" alt="images"/></a>
                                                    <span class="ForSale <?php echo ($prop['property_type']=='sale')?'SGC1':'SGC';?>">For <?php echo isset($prop['property_type'])?ucfirst($prop['property_type']):'';?></span>
                                                    <div class="box_cnts">
                                                        <div class="bed_bath">
                                                            <p>
                                                                <?php if(isset($prop['bathselect'])){?>
                                                                    <img src="<?php echo base_url();?>assets/images/bath.png" alt="images"> <?php if($propertyData->bathselect!=0 && isset($propertyData->bathselect)){ 
                                                                        ?>
                                                                        <?php echo isset($propertyData->bathselect)?number_format($propertyData->bathselect):'';
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                    ?> 
                                                                <?php } 

                                                                if(isset($prop['bedselect'])){ ?>
                                                                    |
                                                                    <img src="<?php echo base_url();?>assets/images/bed.png" alt="images"> 
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
                                                                |<img src="<?php echo base_url();?>assets/images/size.png" alt="images"> <?php echo number_format($prop['square_feet'])." Sq. ft.";?>
                                                            </p>
                                                        </div>
                                                        <h4><?php echo isset($prop['name'])?$prop['name']:''; ?></h4>
                                                        <h6><span class="ti-location-pin"></span> <?php echo isset($prop['property_address'])?ucfirst($prop['property_address']):'';?></h6>
                                                        <?php if($prop['property_type'] == 'rent' && $prop['rent_duration']!=''){ ?>
                                                        <h5>Price- Per <?php echo $prop['rent_duration'] ?> / <span>AED <?php echo isset($prop['property_price'])?number_format($prop['property_price']):'';?></span></h5>
                                                    <?php }else{ ?>
                                                        <h5>Price- <span>AED <?php echo isset($prop['property_price'])?number_format($prop['property_price']):'';?></span></h5>

                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    <?php }
                                }
                                ?>
                            </div>
                        <?php }else{ 
                            echo "No nearby similar properties";
                        } ?>
                    </div>
                </div>
            </li>

<!-- <li class="">
<div class="collapsible-header">Comments <span class="ti-angle-down rotateicon-m"></span></div>
<div class="collapsible-body">
<div class="comment-reviews">
<div class="revfirstH">
<img src="<?php echo base_url(); ?>assets/images/clients.jpg" alt="images"/>
<h4>Catherine Brown</h4>
<div class="rev-our">
<a href=""><span class="ti-star"></span></a>
<a href=""><span class="ti-star"></span></a>
<a href=""><span class="ti-star"></span></a>
<a href=""><span class="ti-star"></span></a>
<a href=""><span class="ti-star"></span></a>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vestibulum,
sem ut sollicitudin consectetur, augue diam ornare massa, ac vehicula leo
turpis eget purus. Nunc</p>
</div>
<div class="revfirstH">
<img src="<?php echo base_url(); ?>assets/images/clients.jpg" alt="images"/>
<h4>Catherine Brown</h4>
<div class="rev-our">
<a href=""><span class="ti-star"></span></a>
<a href=""><span class="ti-star"></span></a>
<a href=""><span class="ti-star"></span></a>
<a href=""><span class="ti-star"></span></a>
<a href=""><span class="ti-star"></span></a>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vestibulum,
sem ut sollicitudin consectetur, augue diam ornare massa, ac vehicula leo
turpis eget purus. Nunc</p>
</div>
</div>
</div> 
</li> -->


<li class="">
    <div class="collapsible-header">Near By Places <span class="ti-angle-down rotateicon-m"></span>
    </div>
    <div class="collapsible-body sellectsbxdgn">
        <select id="gmap_type" onchange="findPlaces();">
            <option value="atm">ATM</option>
            <option value="bank">Bank</option>
            <option value="cafe" selected="">Restaurants and Coffee Shops</option>
            <option value="hospital">Hospital</option>
            <option value="store">Store</option>
        </select>
        <select id="changekm" onchange="findPlaces();">
            <option value="1000">1KM</option>
            <option value="1500">1.5KM</option>
            <option value="2000" selected="">2KM</option>   
            <option value="3000">3KM</option>   
        </select>
        <div class="mycustomslider">
            <div class="slideControls">
                <a class="slidePrev">
                  <span class="ti-angle-left"></span>
                 </a>
                <a class="slideNext">
                  <span class="ti-angle-right"></span>
                </a>
            </div> 
            <div id="startbucks">

            </div>
            <!-- <a class="lSPrevCustom"><span class="ti-angle-left"></span></a>
            <a class="lSNextCustom"><span class="ti-angle-right"></span></a> -->
        </div>
    </div> 
</li>


<li class="">
    <div class="collapsible-header">People Also Viewed <span class="ti-angle-down rotateicon-m"></span></div>
    <div class="collapsible-body">
        <div class="collapsible-iner">
            <div class="owl-carousel owl-theme" id="listproperty3">
                <?php 
                if(!empty($viewdProperties['result'])){
                    foreach($viewdProperties['result'] as $property){
                        if($property->id != $propertyData->id){
                            $favourite = '';
                            if(!empty($favourite_properties) && in_array($property->id,$favourite_properties)){
                                $favourite = 'fillHearts';
                            }
                            ?>
                            <div class="item">
                                <div class="in_box">
                                    <div class="box_img1">
                                        <div class="compareX"><span class="ti-heart <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $property->id;?>,this)"></span></div>
                                        <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property->id);?>" class="waves-effect waves-light">
                                            <?php 
                                            $img = base_url().DEFAULT_PROPERTY_IMAGE;
                                            if(isset($property->thumbnail_photo_media)){
                                                $imgArray = explode('|',$property->thumbnail_photo_media); 
                                                $img = $imgArray[0];
                                            }
                                            ?>
                                            <img src="<?php echo $img;?>" alt="images">
                                            <span class="ForSale <?php echo ($property->property_type=='sale')?'SGC1':'SGC';?>">For <?php echo isset($property->property_type)?ucfirst($property->property_type):'';?></span>
                                            <div class="box_cnts">
                                                <div class="bed_bath">
                                                    <p>
                                                        <?php if(isset($property->bathselect)){ ?>
                                                            <img src="<?php echo base_url();?>assets/images/bath.png" alt="images"> 
                                                            <?php 
                                                            if($propertyData->bathselect!=0 && isset($propertyData->bathselect)){ 
                                                                ?>
                                                                <?php echo isset($propertyData->bathselect)?number_format($propertyData->bathselect):'';
                                                            }else{
                                                                echo '-';
                                                            }
                                                            ?> 
                                                        <?php } 

                                                        if(isset($property->bedselect)){ ?>
                                                            |
                                                            <img src="<?php echo base_url();?>assets/images/bed.png" alt="images"> 
                                                            <?php if(isset($propertyData->bedselect)){
                                                                if($propertyData->bedselect == 100){
                                                                    echo 'Studio';
                                                                }else if($propertyData->bedselect == 0){
                                                                    echo "-";
                                                                }else{
                                                                    echo $propertyData->bedselect;
                                                                }
                                                            }?>
                                                        <?php } ?>
                                                        |<img src="<?php echo base_url();?>assets/images/size.png" alt="images"> <?php echo number_format($property->square_feet)." Sq. ft.";?></p>
                                                    </div>
                                                    <h4><?php echo isset($property->name)?$property->name:''; ?></h4>
                                                    <h6><span class="ti-location-pin"></span><?php echo isset($property->property_address)?$property->property_address:''; ?> </h6>

                                                     <?php if($property->property_type == 'rent' && $property->rent_duration!=''){ ?>
                                                        <h5>Price- Per <?php echo $property->rent_duration ?> / <span>AED <?php echo isset($property->property_price)?number_format($property->property_price):'';?></span></h5>
                                                    <?php }else{ ?>
                                                        <h5>Price- <span>AED <?php echo isset($property->property_price)?number_format($property->property_price):'';?></span></h5>

                                                    <?php } ?>

                                                </div>
                                            </a>
                                        </div>

                                    </div> 
                                </div>
                            <?php }
                        } 
                    } ?>

                </div>
            </div>
        </div>
    </li>
</ul>
</div>


</div>
</div>
<div class="col s4">
    <div class="right-msingleP">
        <div id="property_map" width="100%">  
        </div>
        <div class="m-agentcnt">
            <h4>CONTACT AGENT / OWNER</h4>
            <form id="contactOwner" method="post">
                <input type="hidden" name="property_id" value="<?php echo $propertyData->id;?>">
                <div class="input-field">
                    <input name="name" type="text" placeholder="Your Name" value="<?php echo 
                    (isset($sessionData['first_name'])&&isset($sessionData['last_name']))?ucwords($sessionData['first_name']." ".$sessionData['last_name']):'';
                    ?>">
                </div>
                <div class="input-field">
                    <input name="email" type="email" placeholder="Email" value="<?php echo isset($sessionData['username'])?$sessionData['username']:'';?>">
                </div>
                <div class="input-field">
                    <?php 
                        $number='';
                        if(isset($sessionData['user_number'])){
                            $number = (int)$sessionData['user_number'];
                        }
                        if($number == 0){
                          $number='';  
                        }
                    ?>
                    <!--<input name="phone_number" type="text" placeholder="Phone No.">-->
                    <input class="phone" name="phone_number" type="tel" placeholder="Phone No." value="<?php echo isset($sessionData['user_number'])?$sessionData['code'].$number:'';?>">
                </div>
                <input type="hidden" name="phone_code" id="phone_code" value="971">
                <div class="input-field">

                    <p class="onlyredsB">I am interested in this Property <b><span>'<?php echo isset($propertyData->title)?substr($propertyData->title,0,100).'...':'';?>'</span> <?php echo isset($propertyData->mawjuud_reference)?$propertyData->mawjuud_reference:'';?><?php echo isset($propertyData->property_reference)?'(Reference numbers Mawjuud-'.$propertyData->property_reference.')':'';?></b> and would like to schedule a viewing. Please Let me know when this would be possible</p>

                </div>
<!-- <div class="input-field">
<textarea placeholder="Add your message here" name="message" class="materialize-textarea"></textarea>
</div> -->
<div class="input-field">
    <div class="g-recaptcha" data-sitekey="6Lf52JoUAAAAAAbx6W7jgWCBYZuX1r3k4pndJTt-
"></div>
</div>
<div class="input-field">
    <?php if(!empty($propertyQuestions['total_count']) && $propertyQuestions['total_count']!=0){ ?>
        <a class="modal-trigger cntagents contactOwner waves-effect waves-light modal-close" href="#questionModal">Send Message</a>

        <!-----------Question Modal------------>
        <div id="questionModal" class="modal custompopupdesign">
            <a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
            <img class="logoTopFix" src="<?php echo base_url();?>assets/images/logo.png" alt="img" />
            <div class="my-signup">
                <div class="signup_error card-panel red lighten-3" style="display:none">
                    <strong></strong>
                </div>
                <div class="signup_success card-panel teal accent-3" style="display:none">
                    <strong></strong>
                </div>
                <h5 class="modal-title">
                 <!--The agent is asking to answer a few questions to better understand your inquiry!-->
                The agent you are trying to Contact is asking you to answer the below questions to help better understand your requests.  
                </h5>
                <div class="row">
                    <div class="col s12">
                        <?php 
                        if(!empty($propertyQuestions['result'])){
                            $count = 1;
                            foreach($propertyQuestions['result'] as $row){ ?>
                                <div class="input-field">
                                    Ques <?php echo $count;?>: <?php echo $row->question;?>
                                    <textarea placeholder="Add your answer" name="answer[<?php echo $row->id;?>]" class="materialize-textarea" required></textarea>
                                </div>
                                <?php 
                                $count++;
                            }
                        }
                        ?>

                        <div class="input-field">
                            <button type="submit" class="cntagents contactOwner simplecontinues">Submit answers Continue <span class="ti-arrow-right"></span></button>
                        </div>
                    </div>
                </div>     
            </div>
        </div>
    <?php }else{ ?>
        <button type="submit" class="cntagents contactOwner waves-effect waves-light">Send Message</button>
    <?php } ?>
</div>
<div class="input-field">
    <a class="modal-trigger cntagents grenbtnscall waves-effect waves-light modal-close" href="#callModal" data-property_id="<?php echo $propertyData->id;?>">
    Call</a>
    <div id="callModal" class="modal custompopupdesign">
        <a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
        <div class="my-signup"> 
            <div>Reference Number - <?php echo isset($propertyData->mawjuud_reference)?$propertyData->mawjuud_reference:'';?></div>
            <p>Phone number 1: <?php if(isset($propertyData->phone) && (strlen($propertyData->phone)>5)){
                echo $propertyData->phone;
            }else{
                echo '-';
            }?></p>
            <p>Other contact #: <?php if(isset($propertyData->other_contact) && (strlen($propertyData->other_contact)>5)){
                echo $propertyData->other_contact;
            }else{
                echo '-';
            }?></p>

        </div>
    </div>
</div>

<div class="input-field fixbxt">
    <label><input type="checkbox" name=""><span>Keep Me informed about Similar Properties</span></label>
</div>
</form>
<hr/>
<div class="simpleTxtP"><b>By Sending you Agree to the</b> Terms of Service</div>

<div class="my-agentsi">
    <div class="agnt-ImgFull">
        <img src="<?php echo isset($propertyOwnerDetails[0]['profile_thumbnail'])?$propertyOwnerDetails[0]['profile_thumbnail']:base_url().DEFAULT_IMAGE;?>" alt=""/>
        <!-- <img src="<?php echo isset($propertyOwnerDetails[0]['profile_thumbnail'])?$propertyOwnerDetails[0]['profile_thumbnail']:base_url().DEFAULT_IMAGE;?>" alt=""/> -->
    </div>

    <ul class="agent-namesingles">
        <li><b>Agent:</b> <span><a href=""><?php echo isset($propertyOwnerDetails[0]['firstname'])?ucwords($propertyOwnerDetails[0]['firstname']." ".$propertyOwnerDetails[0]['lastname']):'';?></a></span></li>
        <li><b>Company:</b> <span><?php echo isset($propertyOwnerDetails[0]['agency_name'])?ucwords($propertyOwnerDetails[0]['agency_name']):'';?></span></li>
    </ul>
    <p><a href="">View Properties from Agent</a></p>
</div>
<div class="agent-rels">
</div>
<?php 
$availabilityDays = isset($propertyData->availability_days)?unserialize($propertyData->availability_days):'';
if(!empty($availabilityDays)){
    ?>
    <div class="requestTour">
        <h4>REQUEST A TOUR</h4>
        <form id="tourRequest" method="post">
            <input type="hidden" name="property_id" value="<?php echo $propertyData->id;?>">
            <?php 

            $weekOfdays = array();
            $current_date = time(); 
            $next = strtotime('+6 days');
            $index = 0; ?>
            <select id="tourSelect" name="tour_select">
                <option value="" selected="" disabled="">Select Tour Day</option>
                <?php 
                $dayCount = 0;
                while($current_date <= $next) { 
                    $index++;
                    $day = date('l', $current_date); 
                    $day1 = $day;
                    $day = lcfirst($day)."s";
                    $date = date('M j', $current_date); 
                    if(array_key_exists($day, $availabilityDays)){
                        $dayValue = $availabilityDays[$day];
                        $dayValue = implode('-', $dayValue);
                        $dayCount++;
                        ?>
                        <?php
                        if($dayCount<4){

                            $tourDay = '';
                            if($index == 1)
                                $tourDay = "Today, ".$date;
                            else if($index == 2)
                                $tourDay = "Tomorrow, ".$date;
                            else
                                $tourDay = $day1.", ".$date;
                            ?>
                            <option value="<?php echo $tourDay;?>" data-checks="<?php echo $dayValue;?>" data-day_name="<?php echo $day;?>"><?php echo $tourDay;?></option>
                            <?php 
                        }
                    }
                    $current_date = strtotime('+1 day', $current_date); 
                }
                ?>
            </select>
            <div class="input-field dayCheckbox">

            </div>

            <div class="input-field">
                <textarea placeholder="Message" name="tour_message" class="materialize-textarea"></textarea>
            </div>
            <div class="input-field">
                <button type="submit" class="cntagents waves-effect waves-light">Send tour request</button>
            </div>
        </form>
        <hr/>

    </div>
<?php } ?>
<?php if(get_current_user_id()){ ?>
    <div class="pst-commentsNew">
        <h5>Post a Comment</h5>
        <form method="post" id="commentForm">
            <input type="hidden" id="property_id" name="property_id" value="<?php echo $propertyData->id;?>">
            <textarea placeholder="Comment" id="comment" name="comment" class="materialize-textarea"></textarea> 
            <button type="submit" class="cntagents redbgnewsImp waves-effect waves-light">Post Comment</button>
        </form>
    </div>
<?php } ?>
<div class="Logged-commentsNew">
    <?php if(get_current_user_id()){ ?>
        <p><span>Logged in as</span> <?php echo (isset($sessionData['first_name']) && isset($sessionData['last_name']))?ucwords($sessionData['first_name']." ".$sessionData['last_name']):'';?>? <a href="<?php echo base_url();?>user/logout?<?php echo $timeStamp;?>">Log Out</a>?</p>
    <?php } ?>
    <ul id="user_comments">
        <?php
        if(!empty($propertyComments['result'])){
            $html = '';
            foreach ($propertyComments['result'] as $comment) {
                $html.='<li><span><img src="'.$comment->profile_thumbnail.'"></span>'.$comment->comment.'</li>';
            }
            echo $html;
        }
        ?>
    </ul>
</div>
</div>
</div>
</div>
</div>
<!--===============slider-img==============-->

</div>
</div>
<!--===============Ask Modal================-->
<div id="askModal" class="modal custompopupdesign">
    <a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
    <img class="logoTopFix" src="<?php echo base_url();?>assets/images/imglogopop.png" alt="img" />
    <div class="my-signup">
        <div class="signup_error card-panel red lighten-3" style="display:none">
            <strong></strong>
        </div>
        <div class="signup_success card-panel teal accent-3" style="display:none">
            <strong></strong>
        </div>
        <h4 class="modal-title"><center>Ask a question</center></h4>

        <div class="row">
            <div class="col s12">
                <form id="askQuestion" method="post">
                    <!-- <input type="hidden" name="property_id" value="<?php echo $propertyData->id;?>"> -->
                    <div class="input-field">
                        <textarea placeholder="Add your question" name="question" class="materialize-textarea"></textarea>
                    </div>
                    <div class="input-field">
                        <input name="name" type="text" placeholder="Your Name">
                    </div>
                    <div class="input-field">
                        <input name="phone_number" type="text" placeholder="Phone No.">
                    </div>
                    <div class="input-field">
                        <input name="email" type="email" placeholder="Email" value="<?php echo isset($sessionData['username'])?$sessionData['username']:'';?>">
                    </div>
                    <div class="input-field">
                        <button type="submit" class="cntagents contactOwner waves-effect waves-light">Send question</button>
                    </div>
                </form>
            </div>
        </div>     
    </div>
</div>

</div>
<!--===================single search ===================-->


<?php include APPPATH.'views/frontend/includes/footer.php'; ?>
<?php include APPPATH.'views/frontend/includes/footer_script.php'; ?>
<script src="<?php echo base_url();?>assets/js/jquery.fancybox.min.js"></script>
<script src="<?php echo base_url();?>assets/js/lightslider.min.js"></script>
<script type="text/javascript">
    $(window).load(function(){
        var sliderCustom = $("#startbucks").lightSlider({
            loop:true,
            item:3,
            keyPress:true
        }); 
        $('.slideControls .slidePrev').click(function() {
            sliderCustom.goToPrevSlide();
        });

        $('.slideControls .slideNext').click(function() {
            sliderCustom.goToNextSlide();
        });   
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyB1msoSFExJ6QVhosWAT9U30xQ7CbwvuM0"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/single_property.js?<?php echo $timeStamp;?>"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/login.js?<?php echo $timeStamp;?>"></script>
<!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->
<script src="https://www.recaptcha.net/recaptcha/api.js" async defer></script>
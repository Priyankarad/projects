<?php include APPPATH.'views/frontend/includes/header.php'; 
?>
<section id="serch_prprty">
    <div class="container-fluid">
        <!--=============mini-search-bar============-->
        <div class="list_search_area">
            <form id="searchProperty" method="post" onsubmit="return false">
                <ul>
                    <li class="PsaveBtnS-lft2">
                        <div class="search_kew">
                            <input type="search" class="form-control" placeholder="Enter City & Area, Address, Neighborhood, Buildings" name="area" id="area" value="<?php echo isset($searched_term)?$searched_term:'';?>" onkeyup="searchProperty();">
                            <button type="button" class="search_btn" onclick="searchProperty();"><span class="ti-search"></span></button>
                        </div>
                    </li>
                    <li class="sameSizeBli2">
                        <div class="sale-rent-icon">
                            <span>S</span>
                            <span>R</span>
                        </div>
                        <select class="form-control myrslist" name="listing" id="listing" onchange="searchProperty();">
                            <?php 
                                $sale_selected = '';
                                $rent_selected = '';
                                if(isset($propertyType)){
                                    if($propertyType == 'sale'){
                                        $sale_selected = 'selected=selected';
                                    }else{
                                        $rent_selected = 'selected=selected';
                                    }
                                }
                            ?>
                            <option selected="" disabled="">Listing:</option>
                            <option value="sale" <?php echo $sale_selected;?>>Sale</option>
                            <option value="rent" <?php echo $rent_selected;?>>Rent</option>
                        </select>
                    </li>
                    <li class="sameSizeBli maxminp-mw">
<!--                         <select class="form-control" id="price" name="price" onchange="searchProperty();">
                            <option selected="" disabled="">Max Price</option>
                            <option value="0">0 AED</option>
                            <option value="50000">50,000 AED</option>
                            <option value="75000">75,000 AED</option>
                            <option value="100000">100,000 AED</option>
                            <option value="150000">150,000 AED</option>
                            <option value="200000">200,000 AED</option>
                            <option value="250000">250,000 AED</option>
                            <option value="300000">300,000 AED</option>
                            <option value="400000">400,000 AED</option>
                            <option value="500000">500,000 AED</option>
                        </select>  -->
                        <p><span>Any Price</span> <svg class="caret" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg></p>
                        <div class="maxminp-submenu">
                            <div class="input-controls">
                                <input type="text" name="min_price" id="min_price" placeholder="Min" class="minvalues" onkeyup="priceChange();" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                <input type="text" name="max_price" id="max_price" placeholder="Max" class="maxvalues" onkeyup="priceChange();" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                            </div>

                            <ul id="minpriceappend" class="openmaxminlst">
                                <li data-value="0">
                                 <a class="option">0</a>
                                </li>
                                <li data-value="50000">
                                 <a class="option">AED 50,000</a>
                                </li>
                                <li data-value="75000">
                                 <a class="option">AED 75,000</a>
                                </li>
                                <li data-value="100000">
                                 <a class="option">AED 100,000</a>
                                </li>
                                <li data-value="150000">
                                 <a class="option">AED 150,000</a>
                                </li>
                                <li data-value="200000">
                                 <a class="option">AED 200,000</a>
                                </li>
                                <li data-value="250000">
                                 <a class="option">AED 250,000</a>
                                </li>
                                <li data-value="300000">
                                 <a class="option">AED 300,000</a>
                                </li>
                                <li data-value="400000">
                                 <a class="option">AED 400,000</a>
                                </li>
                                <li data-value="500000">
                                 <a class="option">AED 500,000</a>
                                </li>
                            </ul>

                            <ul id="maxpriceappend">
                                <li data-value="25,000">
                                 <a class="option">AED 25,000</a>
                                </li>
                                <li data-value="50,000">
                                 <a class="option">AED 50,000</a>
                                </li>
                                <li data-value="75,000">
                                 <a class="option">AED 75,000</a>
                                </li>
                                <li data-value="100,000">
                                 <a class="option">AED 100,000</a>
                                </li>
                                <li data-value="125,000">
                                 <a class="option">AED 125,000</a>
                                </li>
                                <li data-value="150,000">
                                 <a class="option">AED 150,000</a>
                                </li>
                                <li data-value="175,000">
                                 <a class="option">AED 175,000</a>
                                </li>
                                <li data-value="250,000">
                                 <a class="option">AED 250,000</a>
                                </li>
                                <li data-value="275,000">
                                 <a class="option">AED 275,000</a>
                                </li>
                                <li data-value="any">
                                 <a class="option">Any Price</a>
                                </li>
                            </ul>        
                        </div>
                    </li>
                    <li class="sameSizeBli">
                        <select class="form-control" id="beds" name="beds" onchange="searchProperty();">
                            <option selected="" disabled="">Beds</option>
                            <option value="100">Studio</option>
                            <option value="0">0+</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                            <option value="5">5+</option>
                            <option value="6">6+</option>
                        </select> 
                    </li>
                    <li class="sameSizeBli mw-typeselects">
                        <select class="form-control" multiple id="category" name="category[]" onchange="searchProperty();">
                            <option selected="" disabled="">Type</option>
                            <?php 
                            if(!empty($categories['result'])){ 
                                $catArr = array(1,12,4,8,2,3,5,6,7,9,10,11);
                                $checkedArr = array(1,12,4,8);
                                foreach($catArr as $row){
                                    foreach($categories['result'] as $category){ 
                                        $checked='';
                                        if($row == $category->id){
                                            if(in_array($category->id,$checkedArr)){
                                                $checked = 'selected';
                                            } ?>
                                            <option value="<?php echo $category->id;?>" <?php echo $checked;?>><?php echo $category->name;?></option>
                                    <?php }
                                    }
                                }
                            } ?>
                            
                        </select> 
                    </li>

                    <li class="sameSizeBli">
                        <div class="moremanyopt">
                            <div class="MoreBnts">
                                More <svg class="caret" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>
                            </div>
                            <!-- ============MORE OPTION===== -->
                            <div class="MoreSmBox">
                                <div class="row">
                                    <div class="col s4">
                                        <label>Baths</label>
                                    </div>
                                    <div class="col s4">
                                        <select class="form-control" name="baths" id="baths">
                                            <option selected="" disabled="">Bath</option>
                                            <option value="0">0+</option>
                                            <option value="1">1+</option>
                                            <option value="2">2+</option>
                                            <option value="3">3+</option>
                                            <option value="4">4+</option>
                                            <option value="5">5+</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s4">
                                        <label>Square Feet</label>
                                    </div>
                                    <div class="col s4">
                                        <input type="text" id="min_sqft" name="min_sqft" placeholder="Min" />    
                                    </div>
                                    <div class="col s4">
                                        <input type="text" id="max_sqft" name="max_sqft" placeholder="Max" />    
                                    </div>
                                </div>

                              <!--   <div class="row">
                                    <div class="col s4">
                                        <label>Lot Size</label>
                                    </div>
                                    <div class="col s8">
                                        <select class="form-control">
                                            <option selected="" disabled="">Lot Size</option>
                                            <option value="any">Any</option>
                                            <option value="2000">2,000+ sqft</option>
                                            <option value="3000">3,000+ sqft</option>
                                            <option value="4000">4,000+ sqft</option>
                                            <option value="5000">5,000+ sqft</option>
                                            <option value="7500">75,00+ sqft</option>
                                            <option value="10890">10,890+ sqft</option>
                                            <option value="21780">21,780+ sqft</option>
                                        </select>    
                                    </div>
                                </div> -->

                               <!--  <div class="row">
                                    <div class="col s4">
                                        <label>Price</label>
                                    </div>
                                    <div class="col s4">
                                        <input type="text" id="min_price" name="min_price" placeholder="Min" />    
                                    </div>
                                    <div class="col s4">
                                        <input type="text" id="max_price" name="max_price" placeholder="Max" />    
                                    </div>
                                </div> -->


                                <!-- <div class="row">
                                    <div class="col s4">
                                        <label>Days on Mawjuud</label>
                                    </div>
                                    <div class="col s8">
                                        <select class="form-control" id="days_zillow" name="days_zillow">
                                            <option selected="" disabled="">Days</option>
                                            <option value="any">Any</option>
                                            <option value="1">1 days</option>
                                            <option value="7">7 days</option>
                                            <option value="14">14 days</option>
                                            <option value="30">30 days</option>
                                            <option value="90">90 days</option>
                                            <option value="180">6 months</option>
                                            <option value="365">12 months</option>
                                            <option value="730">24 months</option>
                                            <option value="1095">36 months</option>
                                        </select>    
                                    </div>
                                </div> -->

                                <div class="row">
                                    <div class="col s4">
                                        <label>Keywords</label>
                                    </div>
                                    <div class="col s8">
                                        <textarea placeholder="property,uae,..." id="keywords" name="keywords" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                        <button type="button" class="custombtnA waves-effect waves-light" onclick="searchProperty();"> Apply </button>   <button type="button" class="custombtnA clearbtndsn waves-effect waves-light"> Clear </button>
                                    </div>
                                </div>              

                            </div> 
                        </li>
                        <li class="sameSizeBli">
                            <p class="short_Xb"><span class="ti-exchange-vertical"></span>Sort</p>
                            <div class="Sort-subbox">
                              <ul>
                                  <li><a href="javascript:void(0);" class="sortBy" data-sort="new">Newest first</a></li>
                                  <li><a href="javascript:void(0);" class="sortBy" data-sort="cheap">Cheapest first</a></li>
                                  <li><a href="javascript:void(0);" class="sortBy" data-sort="size">Largest size</a></li>
                                  <li><a href="javascript:void(0);" class="sortBy" data-sort="image">More images first</a></li>
                              </ul>    
                            </div>   
                            
                        </li> 
                        <li class="sameSizeBli">
                            <a href="<?php echo base_url();?>search_properties" class="clearfilter">Clear <span>x</span> Search </a>
                        </li> 
                    </ul>
                    <ul class="Fgrid_listF">
                        
                        
                        <li class="breakrow2">
                            <p class="view" data-type="grid"><img src="assets/images/grid-view.png?<?php echo $timeStamp;?>" class="tooltipped" data-position="top" data-tooltip="Grid View"/></p>
                        </li>
                        <li class="breakrow2">
                            <p class="view MpicView" data-type="photo"><img src="assets/images/photo-view.png?<?php echo $timeStamp;?>" class="tooltipped" data-position="top" data-tooltip="Photo View"/></p>
                        </li>
                        <li class="breakrow2">
                            <p class="view" data-type="table"><img src="assets/images/table-view.png?<?php echo $timeStamp;?>" class="tooltipped" data-position="top" data-tooltip="Table View"/></p>
                        </li>
                        <li class="PsaveBtnS">
                            <button class="modelsubmitBtns">Save Search</button>
                        </li>
                        <li>
                            <!-- <div class="propertysaveprnt">
                                <span class="Sshow">0</span>
                                <input type="submit" value="Saved Properties" class="modelsubmitBtns">
                            </div> -->
                            <div class="propertysaveprnt">
                                <button type="submit" value="Saved Properties" class="modelsubmitBtns">
                                    <span class="Sshow" id="saved_properties"><?php echo isset($favourite_properties)?"(".count($favourite_properties).")":'';?></span> Saved Properties
                                </button>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
            <!--=============mini-search-bar============-->

            <!--=============main_left-right============-->
            <div class="row">
                <div class="mapbtnhide">
                  <button class="M-mapmore tooltipped" data-position="bottom" data-tooltip="More Map"><i class="ti-plus"></i> Map</button>
                  <button class="M-mapless tooltipped" data-position="bottom" data-tooltip="Less Map"><i class="ti-minus"></i> Map </button>
                  <button class="M-maphide tooltipped" data-position="bottom" data-tooltip="Hide Map"><i class="ti-na"></i> Map</button>   
                </div>
                <div class="col s7 pd_rgtzero pd_lftzero M-listedfixedsec">
                    <!--=============main_left-right============-->
                    <div class="srch_rsltlft scroll">
                        <!--==============filter_form================-->
                        <div class="srch_abvfrm">
                            <form id="srch_prprt" method="post">
                                <div class="row">
                                    <div class="col s4 sft">
                                        <select class="form-control">
                                            <option selected="" disabled="">Type</option>
                                            <option value="">For Rent</option>
                                            <option value="">For Sale</option>
                                        </select>   
                                    </div>
                                    <div class="col s4 sft">
                                        <select class="form-control">
                                            <option selected="" disabled="">Bedrooms</option>
                                            <option value="">1+</option>
                                            <option value="">2+</option>
                                        </select>   
                                    </div>
                                    <div class="col s4 sft">
                                        <select class="form-control">
                                            <option selected="" disabled="">Bathrooms</option>
                                            <option value="">1+</option>
                                            <option value="">2+</option>
                                        </select>   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s4 sft">
                                        <div class="cover_range">  
                                            <input type="text" class="rangeX" value="" name="range" />
                                            <label>Price Range</label>
                                        </div>
                                    </div>
                                    <div class="col s4 sft">
                                        <div class="cover_range">    
                                            <input type="text" class="rangeX" value="" name="range" />
                                            <label>Area Range</label>
                                        </div>
                                    </div>
                                    <div class="col s4 sft">
                                        <select class="form-control">
                                            <option selected="" disabled="">Amenities </option>
                                            <option value="">1+</option>
                                            <option value="">2+</option>
                                            <option value="">1+</option>
                                            <option value="">2+</option>
                                            <option value="">1+</option>
                                            <option value="">2+</option>
                                            <option value="">1+</option>
                                            <option value="">2+</option>
                                            <option value="">1+</option>
                                            <option value="">2+</option>
                                            <option value="">1+</option>
                                            <option value="">2+</option>
                                            <option value="">1+</option>
                                            <option value="">2+</option>
                                        </select>   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s8 sft">
                                        <div class="filter_btnsopt">
                                            <input type="submit" name="" id="applyfilter" value="Apply Filter" class="modelsubmitBtns"> 
                                            <a href="javascript:void(0)" class="hide_filter_btn"> Hide Filter</a>
                                            <a href="javascript:void(0)" class="hide_filter_btn"> More Map</a>
                                            <a href="javascript:void(0)" class="hide_filter_btn">No Map</a>
                                        </div>
                                    </div>
                                </div>  
                            </form>
                        </div>
                        <!--==============filter_form================-->

                        <!--==============Property_list================-->
                        <div class="property_searchI">
                            <div class="row">
                                <?php 
                                $location = array();
                                if(!empty($propertyData)){ 
                                    
                                    $count = 0;
                                    foreach($propertyData as $property){ 
                                        $favourite = '';
                                        $location[$count][] = $property['property_address'];
                                        $location[$count][] = $property['latitude'];
                                        $location[$count][] = $property['longitude'];
                                        $location[$count][] = $property['id'];
                                        if(isset($property['thumbnail_photo_media'])){
                                            $imgArray = explode('|',$property['thumbnail_photo_media']); 
                                            $location[$count][] = $imgArray[0];
                                        }else{
                                            $location[$count][] = base_url().DEFAULT_PROPERTY_IMAGE;
                                        }

                                        if($property['property_type']=='sale'){
                                            $location[$count][] = 'SGC1';
                                        }else{
                                            $location[$count][] = 'SGC';
                                        }

                                        $location[$count][] = isset($property['property_type'])?ucfirst($property['property_type']):'';
                                        $location[$count][] = isset($property['bathselect'])?$property['bathselect']:'';

                                        if(isset($property['bedselect'])){
                                            if($property['bedselect']==100)
                                                $location[$count][] = 'Studio';
                                            else
                                                $location[$count][] = $property['bedselect'];
                                        }

                                        $location[$count][] = isset($property['square_feet'])?number_format($property['square_feet'])." Sq. ft.":'';
                                        $location[$count][] =isset($property['name'])?$property['name']:'';

                                        $location[$count][] =isset($property['property_address'])?ucfirst($property['property_address']):'';

                                        $location[$count][] = isset($property['property_price'])?number_format($property['property_price']).' AED':'';

                                        $images = isset($property['thumbnail_photo_media'])?explode("|",$property['thumbnail_photo_media']):0;
                                        if($images){
                                            $location[$count][] = count($images);
                                        }else{
                                            $location[$count][] = 0;
                                        }
                                        if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                                            $favourite = 'fillHearts';
                                            $location[$count][] = 'fillHearts';
                                        }else{
                                            $location[$count][] = '';
                                        }
                                        $location[$count][] = encoding($property['id']);
                                        if(isset($property['title']) && !empty($property['title']))
                                            $location[$count][] = substr($property['title'], 0, 100).'...';
                                        else
                                            $location[$count][] = '';
                                        $count++;
                                        ?>
                                        <div class="col s6 box_div property_hover" data-prop_id="<?php echo $property['id'];?>">
                                            <div class="in_box">
                                                <div class="box_img1">
                                                    <div class="compareX"><span class="ti-heart <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $property['id'];?>,this);"></span></div>

                                                    <div class="Mhideproperty" data-property = "<?php echo $property['id'];?>">
                                                        <img src="<?php echo base_url();?>assets/images/map-icon/hide-icon.png?<?php echo $timeStamp;?>" alt="images"/>
                                                    </div>
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
                                                                        <img src="<?php echo base_url();?>assets/images/bath.png?<?php echo $timeStamp;?>" alt="images"> <?php echo $property['bathselect']?> 
                                                                    <?php } 

                                                                    if(isset($property['bedselect'])){ ?>
                                                                        |
                                                                        <img src="<?php echo base_url();?>assets/images/bed.png?<?php echo $timeStamp;?>" alt="images"> <?php echo ($property['bedselect']==100)?"Studio":$property['bedselect'];?>
                                                                    <?php } ?>
                                                                    |<img src="<?php echo base_url();?>assets/images/size.png?<?php echo $timeStamp;?>" alt="images"> <?php echo number_format($property['square_feet'])." Sq. ft.";?></p>
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
                    <div class="col s5 pd_lftzero pd_rgtzero M-mapfixedsec">
                        <div class="srch_rsltmap">
                            <div class="map-controller-icon">
                                <button class="clear tooltipped" data-position="right" data-tooltip="Clear"> <img src="<?php echo base_url();?>assets/images/map-icon/ClearSelections.png?<?php echo $timeStamp;?>" alt=""/> Clear</button>
                               <!--  <button onclick="circle();">  <img src="<?php echo base_url();?>assets/images/map-icon/radius.png" alt=""/> Radius</button> -->
                                <button class="ti-slice tooltipped" data-position="right" data-tooltip="Hand Draw">  <img src="<?php echo base_url();?>assets/images/map-icon/handdraw.png?<?php echo $timeStamp;?>" alt=""/> Draw</button>
                                <button class="tooltipped" data-position="right" data-tooltip="Near by"> <img src="<?php echo base_url();?>assets/images/map-icon/nearby.png?<?php echo $timeStamp;?>" alt=""/></button>
                                <button class="tooltipped" data-position="right" data-tooltip="Transport"> <img src="<?php echo base_url();?>assets/images/map-icon/transport.png?<?php echo $timeStamp;?>" alt=""/></button>
                                <button class="tooltipped" data-position="right" data-tooltip="School"> <img src="<?php echo base_url();?>assets/images/map-icon/school.png?<?php echo $timeStamp;?>" alt=""/></button>
                            </div>
                            <div id="search_map" class="custom_search_map" width="100%">  
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="latlng" id="latlng">
                <!--=============main_left-right============-->
            </div>
        </section>







        <?php include APPPATH.'views/frontend/includes/footer_script.php'; ?>
        <script src="<?php echo base_url()?>assets/js/GDouglasPeuker.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=AIzaSyBFzzVfXfUc91Eb1CWCfPVZZzgMB0U5xVU"></script>
           <!--   <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=drawing"></script> -->
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/datatables.min.js?<?php echo $timeStamp;?>"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/search_property.js?<?php echo $timeStamp;?>"></script>
        <script type="text/javascript">
            /*For google map*/
            var markers = [];
            var hoverMarker = [];
            var locations = <?php echo isset($location)?json_encode($location):'' ?>;
            var map = new google.maps.Map(document.getElementById('search_map'), {
                zoom: 10,
                zoomControl:true,
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
                google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
                    return function() {
                        var html = '<div class="col s12 box_div box_map"><div class="in_box"><div class="box_img1"><a href="'+baseUrl+'single_property?id='+locations[i][15]+'" target="_blank" class="waves-effect waves-light"><img src="'+locations[i][4]+'" alt="images"><span class="ForSale '+locations[i][5]+'">For '+locations[i][6]+'</span><div class="box_cnts"><h4>'+locations[i][10]+'</h4><h6><span class="ti-location-pin"></span>'+locations[i][11]+'</h6><h5><span class="PriceSp">'+locations[i][12]+'</span></h5></div></a><div class="MtotalPicsList"><i>'+locations[i][13]+'</i> <span class="ti-camera"></span></div></div></div>      <div class="mapbox-btmsec"><h4><a href="">'+locations[i][16]+'</a></h4><ul> <li> <img src="https://pixlritllc.com/mawjuud/assets/images/size.png" alt=""> <i>'+locations[i][9]+'</i> <span>Sq. ft</span> </li><li> <img src="https://pixlritllc.com/mawjuud/assets/images/bed.png" alt=""> <span>'+locations[i][8]+'</span> </li><li> <img src="https://pixlritllc.com/mawjuud/assets/images/bath.png" alt=""> <span>'+locations[i][7]+'</span> </li></ul><h5><span class="PriceSp">'+locations[i][12]+'</span></h5></div>  </div>';
                        infowindow.setContent(html);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
                markers.push(marker);
                hoverMarker[locations[i][3]] = marker;

                google.maps.event.addListener(map, 'click', (function() {
                    infowindow.close(map, marker);
                }));
            }
            google.maps.event.addDomListener(window, 'load', initialize);
            function disable(){
                map.setOptions({
                    draggable: false, 
                    zoomControl: false, 
                    scrollwheel: false, 
                    disableDoubleClickZoom: false
                });
            }
            function initialize() {
                $(".ti-slice").click(function(e) {
                    e.preventDefault();
                    disable();
                    google.maps.event.addDomListener(map.getDiv(),'mousedown',function(e){
                        drawFreeHand();
                    });
                });
            }

            $('.property_hover').hover(function(){
                var property_id = $(this).data('prop_id');
                google.maps.event.trigger(hoverMarker[property_id],'mouseover');
            });
        </script>
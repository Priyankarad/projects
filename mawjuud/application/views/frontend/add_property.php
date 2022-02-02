<?php include APPPATH.'views/frontend/includes/header.php'; 
$sessionData = '';
if($this->session->userdata('sessionData')){
    $sessionData = $this->session->userdata('sessionData');
}
?>
<!--===========add listing ==================-->
<div class="addListingP" id="topViewAdd">
    <div class="container">
        <div class="addListingParent">
            <form id="addPropertyForm" method="post" class="addPropertyForm" enctype="multipart/form-data">
                <div class="custom-pro-right">
                    <div class="hideItems" id="first_ShowF">
                        <h3>Post a Property on Mawjuud. it’s Free! </h3>
                        <p>Choose your listing option</p>
                        <div class="select_optBy">
                            <label>
                                <input name="property_type" class="prev_property" type="radio" value="rent" checked="" />
                                <span>Rent</span>
                            </label>
                            <label>
                                <input name="property_type" class="prev_property" type="radio" value="sale"/>
                                <span>Sale</span>
                            </label>
                        </div>  
                        <button type="button" class="next_btnListing waves-effect waves-light" id="first_cont">Continue</button>
                        <!-- <div class="next_btnListing skipBtns skipToLast">Skip To Last<span class="ti-angle-right"></span></div> -->
                    </div>

                    <div class="hideItems category_1">
                        <h4>Post a Property on Mawjuud. it’s Free! </h4>
                        <p>Choose your listing type to post </p>
                        <div class="select_optBy">
                            <div class="owl-carousel owl-theme slider_select" id="Mcategorysliders">
                                <?php 
                                $catArr = array(1,12,4,8,2,3,5,6,7,9,10,11);
                                if(!empty($categories['result'])){
                                    foreach($catArr as $row){ 
                                        foreach($categories['result'] as $category){
                                            if($row == $category->id){
                                                $checked='';
                                                if($category->id == 1)
                                                    $checked = 'checked=checked';
                                                ?>
                                                <div class="item">
                                                    <label>
                                                        <?php 

                                                        ?>
                                                        <input name="listing" class="category_list" type="radio" value="<?php echo $category->id;?>" data-listing="<?php echo $category->name;?>" data-image="<?php echo base_url();?>assets/images/<?php echo $category->image;?>" <?php echo $checked;?>/>
                                                        <span><?php echo $category->name;?></span>
                                                    </label>
                                                </div>
                                                <?php 
                                            }
                                        }
                                    }
                                } ?>
                            </div>
                        </div>  
                        <div class="other_type"></div>
                        <button type="button" class="next_btnListing waves-effect waves-light" id="category_cont">Continue</button>
                        <div class="row bottomNextPrev">
                            <div class="col s12">
                                <div class="backBtnList"><span class="ti-angle-left"></span><span class="ti-angle-left"></span> Back</div> 
                            </div>
                        </div>
                    </div>

                    <div class="hideItems map_1 onlymapSectionAdd">
                        <h4>Post a Property on Mawjuud. it’s Free! </h4>
                        <p>Select your property location </p>
                        <div class="search_optByL">
                            <div id="map_canvas" width="100%">  
                            </div>
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                        </div> 
                        <p class="maxPara0">Find your Property using location on the map, building name, house/complex name... etc.</p>
                        <div class="enter_otherT">
                            <div class="input-field">
                                <input id="searchLocationS" name="search_location" type="text" class="validate" >
                                <input id="city" name="city" type="hidden">
                                <label for="searchLocationS">Search for property location </label>
                            </div>
                            <button type="button" class="addBtnOT codeAddress" onclick="codeAddress()"><span class="ti-search"></span></button>
                        </div> 

                        <div class="enter_otherT">
                            <div class="input-field">
                                <input id="neighbourhood" name="neighbourhood" type="text" class="validate">
                                <label for="searchLocationS">Building / Complex / Neighbourhood </label>
                            </div>
                        </div> 

                        <button type="button" class="next_btnListing waves-effect waves-light" id="map_cont">Continue</button>
                        <div class="row bottomNextPrev">
                            <div class="col s12">
                                <div class="backBtnList"><span class="ti-angle-left"></span><span class="ti-angle-left"></span> Back</div> 
                            </div>
                        </div>
                    </div>


                    <!--=========Select beds/ baths ==================-->
                    <div class="hideItems bed_bath_hide">
                        <h4>Let us Help You!</h4>
                        <p>Select Number of Beds & Baths</p>
                        <div class="selectBed">
                            <div class="owl-carousel owl-theme slider_select" id="bedselect">
                                <div class="item">
                                    <div class="select_optBy">
                                        <label>
                                            <input name="bedselect" type="radio" value="100" class="bed_1" checked="" />
                                            <span>
                                                Studio
                                            </span>
                                        </label>  
                                    </div>
                                </div>
                                <?php for($i=1; $i<=10; $i++){ ?>
                                    <div class="item">
                                        <div class="select_optBy">
                                            <label>
                                                <input name="bedselect" type="radio" value="<?php echo $i;?>" class="bed_1"/>
                                                <span>
                                                    <?php if($i == 1){
                                                        echo '1 Bed';
                                                    }else if($i>1 && $i<10){
                                                        echo $i.' Beds';
                                                    }else{
                                                        echo '10+ Beds';
                                                    }
                                                    ?>
                                                </span>
                                            </label>  
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="owl-carousel owl-theme slider_select" id="bathselect">
                                <?php for($i=1; $i<=10; $i++){ 
                                    $checked='';
                                    if($i == 1){
                                        $checked='checked';
                                    }
                                    ?>
                                    <div class="item">
                                        <div class="select_optBy">
                                            <label>
                                                <input name="bathselect" type="radio" value="<?php echo $i;?>" class="bath_1" <?php echo $checked;?>/>
                                                <span>
                                                    <?php if($i == 1){
                                                        echo '1 Bath';
                                                    }else if($i>1 && $i<10){
                                                        echo $i.' Baths';
                                                    }else{
                                                        echo '10+ Baths';
                                                    }
                                                    ?>
                                                </span>
                                            </label>  
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <button type="button" class="next_btnListing waves-effect waves-light" id="bed_bath_cont">Continue</button>
                        <div class="row bottomNextPrev">
                            <div class="col s12">
                                <div class="backBtnList"><span class="ti-angle-left"></span><span class="ti-angle-left"></span> Back</div> 
                            </div>
                        </div>
                    </div>
                    <!--=========Select beds/ baths ==================-->

                    <!--=========Select your Property Area Size ==================-->
                    <div class="hideItems area_1">
                        <h4>Let us Help You!</h4>
                        <p>Select your Property Area Size</p>
                        <div class="row">
                            <div class="col s8 offset-s2 rangle_sliderareaS">
                                <div class="cover_range2"> 
                                    <button type="button" class="A-minus"><img src="assets/images/minius-slider.png"/></button>
                                    <button type="button" class="A-add"><img src="assets/images/plus-slider.png"/></button>   
                                    <input type="text" class="rangeX" id="propertyrange" value="" name="property_range" />
                                </div>     
                            </div>
                        </div>
                        <button type="button" class="next_btnListing waves-effect waves-light" id="area_cont">Continue</button>
                        <div class="row bottomNextPrev">
                            <div class="col s12">
                                <div class="backBtnList"><span class="ti-angle-left"></span><span class="ti-angle-left"></span> Back</div> 
                            </div>
                        </div>
                    </div>
                    <!--=========Select your Property Area Size ==================-->


                    <!--=========Select your Property Price ==================-->
                    <div class="hideItems price_1">
                        <h4>Let us Help You!</h4>
                        <p>Select your Property <span class="changesaleS">Rent</span> Price</p>
                        <div class="row rent_div">
                            <div class="col s8 offset-s2 rangle_sliderareaS2">
                                <div class="cover_range2">    
                                    <button type="button" class="M-minus"><img src="assets/images/minius-slider.png"/></button>
                                    <button type="button" class="M-add"><img src="assets/images/plus-slider.png"/></button>
                                    <input type="text" class="rangeX" id="propertypriceR" value="" name="property_price" />
                                    <!-- <label>Sq. ft</label> -->
                                </div>     
                            </div>
                        </div>

                        <div class="row sale_div hide">
                            <div class="col s8 offset-s2 rangle_sliderareaS2">
                                <div class="cover_range2">    
                                    <button type="button" class="M-minusS"><img src="assets/images/minius-slider.png"/></button>
                                    <button type="button" class="M-addS"><img src="assets/images/plus-slider.png"/></button>
                                    <input type="text" class="rangeX" id="propertypriceS" value="" name="property_price" />
                                    <!-- <label>Sq. ft</label> -->
                                </div>     
                            </div>
                        </div>

                        <a href="#topViewAdd" class="next_btnListing2 waves-effect waves-light" onclick="markerActive();" id="price_cont">Continue</a>

                        <div class="row bottomNextPrev">
                            <div class="col s12">
                                <div class="backBtnList rent_sale_back"><span class="ti-angle-left"></span><span class="ti-angle-left"></span> Back</div> 
                            </div>
                        </div>
                    </div>
                    <!--=========Select your Property Price ==================-->
                </div>

                <div class="add_maps_list">
                    <h5>My Properties</h5>
                    <div class="map_setX">
                        <div id="map_canvas_1" width="100%">  
                        </div>

                        <div class="mapEditOption">
                            <div class="groupMapPin">
                                <span class="ti-location-pin"></span>
                                <input id="searchLocationS1" name="search_location1" type="text" class="validate" placeholder="Enter a location" autocomplete="off">
                                <button type="button" class="addBtnOT codeAddressDetail" onclick="codeAddressDetail()"><span class="ti-search"></span></button>
                            </div>
                        </div>
                        <div class="mapEditOption2">
                            <div class="input-groupMapPin">
                                <input id="neighbourhood1" name="neighbourhood1" type="text" class="validate">
                                <label for="searchLocationS">Building / Complex / Neighbourhood </label>
                            </div>
                        </div> 

                    </div>
                    <div class="addPlistingS">  
                        <ul class="tabs">
                            <li class="tab"><a class="active" href="#addlistP1">Listing</a></li>
                            <li class="tab"><a href="#addlistP2">Contacts</a></li>
                            <li class="tab"><a href="#addlistP3">Applications</a></li>
                            <li class="tab"><a href="#addlistP4">Payments</a></li>
                        </ul>
                        <div id="addlistP1">
                            <div class="listingSM">
                                <div class="hideDivSkip">
                                    <!-- <h5>Listing features</h5> -->
                                    <div class="row">
                                        <div class="col s2">
                                            <h5>Listing features</h5>
                                        </div>
                                        <div class="list_f">
                                        </div>
                                    </div>
                                    <div class="row MawjuudlisTopl">
                                        <div class="col s4">
                                            <div class="inlineTxts">
                                                <div id="aed"></div>
                                                <div id="duration">/Yr.</div>
                                            </div>
                                        </div>
                                        <div class="col s4 bed_bath">
                                            <div class="UlinlineTxts">
                                                <div id="bed1"></div>
                                                <div id="bath1"></div>
                                            </div>
                                        </div>
                                        <div class="col s4 square_feet">
                                            <div class="aedPriceAqaures"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="details_2">
                                    <h5>Details and description 
                                        <span class="selectcat-imgs"><img src="assets/images/category-icons/home.png" alt="images"/> House / Villa</span>
                                    </h5>
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="input-field">
                                                <label>Property Title</label>
                                                <input id="titleproperty" name="property_title" type="text"  placeholder="Add property title here" maxlength="60"/>
                                            </div>       
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s6 full_rent">
                                            <div class="input-field Sale-price9">
                                                <label>Price (AED)</label>
                                                <input id="sale_price" name="sale_price" type="text"  placeholder="Property Pricee">
                                            </div>                                           
                                        </div>
                                        <div class="col s6 RntFullCol half_rent">
                                            <div class="RntFullColMain">
                                                <div class="input-field RntSelect">
                                                    <label>Price (AED)</label>
                                                    <input id="rent_price" name="rent_price" type="text"  placeholder="Rent price">
                                                    <select name="rent_duration" id="rent_duration">
                                                        <!-- <option value="" disabled selected >Rent duration </option> -->
                                                        <option value="Yr">/Yr.</option>
                                                        <option value="Mo">/Mo.</option>
                                                        <option value="Wk">/Wk.</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col s6">
                                            <div class="input-field">
                                                <label>Size (Sq. Ft.)</label>
                                                <input name="square_feet" id="square_feet" type="text" class="" placeholder="Property Size">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s6">

                                            <div class="input-field" id="bed_details">
                                                <select name="beds" id="beds">
                                                    <option value="" disabled selected >Beds</option>
                                                    <option value="100">Studio</option>
                                                    <?php 
                                                    $bed = '';
                                                    for($i=1; $i<=10; $i++){ 
                                                        if($i == 1){
                                                            $bed = '1 Bed';
                                                        }else if($i>1 && $i<10){
                                                            $bed = $i.' Beds';
                                                        }else{
                                                            $bed = '10+ Beds';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $i;?>"><?php echo $bed;?></option>
                                                    <?php } ?>
                                                </select>
                                                <label>Bed(s)</label>
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <div class="input-field" id="bath_details">
                                                <select name="baths" id="baths">
                                                    <option value="" disabled selected >Baths</option>
                                                    <?php 
                                                    $bath = '';
                                                    for($i=1; $i<=10; $i++){ 
                                                        if($i == 1){
                                                            $bath = '1 Bath';
                                                        }else if($i>1 && $i<10){
                                                            $bath = $i.' Baths';
                                                        }else{
                                                            $bath = '10+ Baths';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $i;?>"><?php echo $bath;?></option>
                                                    <?php } ?>
                                                </select>
                                                <label>Bath(s)</label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col s6">
                                            <div class="input-field RntSelect">
                                                <label>Date Available</label>
                                                <input id="DateAvb" name="date_available" type="text" class="datepicker" placeholder="Date Available">
                                                <span class="ti-calendar"></span>
                                            </div><br/><br/>
                                            <div class="input-field mtop5">
                                                <label>Property Reference #</label>
                                                <input id="leaseTrms" name="property_reference" type="text" class="" placeholder="Add property reference #">
                                            </div><br/><br/>
                                            <div class="input-field securtyDsptb mtop5">
                                                <label>Security Deposit</label>
                                                <input id="security_dps" name="security_deposit" type="text"  placeholder="Security Deposit">
                                            </div>
                                        </div>

                                        <div class="col s6">
                                            <div class="input-field mawjuud-tnspc">
                                                <select id="view_type" name="view_type">
                                                    <option value="no">No View</option>
                                                    <option value="sea">Sea View</option>
                                                    <option value="community">Community View</option>
                                                    <option value="park">Park View</option>
                                                    <option value="street">Street View</option>
                                                    <option value="partial_sea">Partial Sea View</option>
                                                    <option value="city">City View</option>
                                                    <option value="pool">Pool View</option>
                                                </select>
                                                <label>View</label>
                                            </div>
                                            <div class="input-field mawjuud-tnspc">
                                                <select id="furnishing" name="furnishing">
                                                    <option value="unfurnished">Unfurnished</option>
                                                    <option value="furnished">Furnished</option>
                                                    <option value="partial">Partial</option>
                                                </select>
                                                <label>Furnishings</label>
                                            </div>
                                            <div class="input-field">
                                                <label>Property Terms & Options</label>
                                                <textarea type="text" name="property_terms" id="property_terms" class="" placeholder="Add property terms here like , 4 cheque payment, One month free rent,. pay 5% down payment. Etc"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="input-field">
                                                <label class="active">Description</label>
                                                <textarea type="text" name="description" class="textareaeditors" placeholder="Add Property Description here" id="desctxtareas">Add your Description here</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row hide" id="options_term">
                                        <div class="col s12">
                                            <div class="input-field">
                                                <label>Property Terms & Options</label>
                                                <div id="term_text"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="details_2">
                                <h5>Contact information</h5>
                                <div class="row">
                                    <div class="col s6">
                                        <div class="input-field">
                                            <label>Name </label>
                                            <input name="user_name" type="text"  placeholder="Your name here" value="<?php echo (isset($sessionData['first_name']) && $sessionData['last_name'])?$sessionData['first_name'].' '.$sessionData['last_name']:'';?>">
                                        </div>
                                    </div>
                                    <div class="col s6">
                                        <div class="input-field">
                                            <label>Email </label>
                                            <input type="email" name="email" placeholder="demo@gmail.com" value="<?php echo isset($sessionData['username'])?$sessionData['username']:'';?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s6">
                                        <div class="input-field">
                                            <label class="contact_numbers">Phone </label>
                                            <input type="text" class="phone" id="user_number" name="phone"  placeholder="(123) 456-7890" value="<?php echo isset($sessionData['user_number'])?$sessionData['user_number']:'';?>"/>
                                            <input type="hidden" name="number_code" id="number_code">
                                        </div>
                                        <label class="hide_P"><input type="checkbox" name="hide_property_address" /><span>Hide property address on listing</span></label>
                                    </div>
                                    <div class="col s6">
                                        <div class="input-field">
                                            <label class="contact_numbers">Other Contact Number </label>
                                            <input type="text" class="phone" id="other_contact" name="other_contact"  placeholder="(123) 456-7890"/>
                                            <input type="hidden" name="other_code" id="other_code">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="details_2">
                                <h5>Amenities and rules</h5>
                                <h3 class="asLabelF">Amenities</h3>  
                                <div class="row checkboxspaceF">
                                    <?php if(!empty($amenities['result'])){
                                        foreach ($amenities['result'] as $row) {  ?> 
                                            <div class="col s4">
                                                <div class="group-checkbox labelimgnews">
                                                    <label class="hide_P">
                                                        <img src="<?php echo base_url();?>assets/images/amenities/<?php echo $row->image;?>" alt="icons">
                                                        <input type="checkbox" value="<?php echo $row->id?>" name="amenities[]" value="" />
                                                        <span><?php echo $row->name?></span>
                                                    </label>
                                                </div>
                                            </div>  
                                        <?php }
                                    } ?>


                                </div>
                                <div class="row checkboxspaceF">
                                    <div class="col s12 input-field">
                                        <h3 class="asLabelF">Additional Amenities </h3>
                                        <div class="newAmntsAppend"></div>
                                        <div class="positionrelt">
                                            <input type="text" name="additional_amenities" placeholder="Enter an amenity" id="additional_amenities" class="additional_amenities">

                                            <input type="hidden" name="additional_amenities1" placeholder="Enter an amenity" id="additional_amenities1" class="additional_amenities">
                                            <button type="button" id="newAddAminities" class="addBtnOT waves-effect waves-light"> Add </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="details_2">
                                <h5>Photo & media</h5>
                                <div class="row">
                                    <div class="col s12 imageUploadN">
                                        <div id="dragimgappend"></div>
                                        <input type="file" id="filesss" multiple class="upload-fileS" accept="image/*" />
                                        <div class="documentUploadS">
                                            <label class="chsimg_btn fullsizeUpd" for="filesss"><span class="ti-plus"></span></label>
                                        </div> 
                                        <label>Select area to add photos.</label>
                                    </div>
                                </div>
                            </div>

                            <div class="details_2">
                                <h5>Showing availability</h5>
                                <div class="dayselecttimeC">
                                    <?php 
                                    $index = 0;
                                    $days = array('Mondays','Tuesdays','Wednesdays','Thursdays','Fridays','Saturdays','Sundays');
                                    foreach($days as $day){ ?>
                                        <div class="row">
                                            <div class="col s2">
                                                <p><?php echo $day;?></p>
                                            </div>
                                            <div class="col s6">
                                                <ul class="checkmultipleD">
                                                    <li>
                                                        <div class="group-checkbox">
                                                            <label class="hide_P">
                                                                <input type="checkbox" name="<?php echo lcfirst($day);?>[0]" value="1" />
                                                                <span>Morning</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="group-checkbox">
                                                            <label class="hide_P"><input type="checkbox" name="<?php echo lcfirst($day);?>[1]" value="2"/>
                                                                <span>Afternoon</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="group-checkbox">
                                                            <label class="hide_P">
                                                                <input type="checkbox" name="<?php echo lcfirst($day);?>[2]" value="3"/>
                                                                <span>Evening</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php $index++; } ?>
                                    </div>
                                </div>


                                <div class="details_2">
                                    <h5>Rental applications</h5>
                                    <div class="row">
                                        <div class="col s7">
                                            <div class="switch">
                                                <!-- <p class="inheritX">Allow renters to apply for this property directly from this listing <span class="ti-help"></span></p> -->
                                                <p class="inheritX">Ask people to to answer some questions before they send me? 
                                                    <div class="hvrAllcnts">
                                                        <div class="whenHDvShow">
                                                            <h5>When Off,</h5>
                                                            <p>Applicants can directly send you a request to apply</p>
                                                            <hr/>

                                                            <h5>When On, </h5>
                                                            <p>you will have the option to add screening questions, which applicants will have to answer before applying to the Property Listing</p>
                                                            <hr/>
                                                            <p><a href="">Contact us for more info </a></p>
                                                        </div>
                                                    </div>
                                                </p>
                                                <label> 
                                                    Off
                                                    <input type="checkbox" name="directly_listing" class="switchCheck">
                                                    <span class="lever"></span>
                                                    On
                                                </label>
                                                <input type="hidden" name="property_draft" id="property_draft">
                                            </div>
                                            <div class="activelistingS">
                                                <button type="submit" class="activelistingbtn greenClrs waves-effect waves-light add_property" data-btn_name="activate"> Activate listing </button>
                                                <button type="submit" class="activelistingbtn gClrImp waves-effect waves-light add_property" data-btn_name="draft"> Save Draft Property </button>
                                                <a href="<?php echo base_url();?>add_property" class="activelistingbtn waves-effect waves-light add_property"> Delete Property </a>
                                                <p class="fontBB"> 
                                                    By clicking Activate Listing, you agree to Mawjuud’s <a href="">Terms</a> and <a href="">Privacy Policy</a></p>
                                                </div>
                                            </div>
                                            <div class="col s5">
                                                <div class="questionAnswer">
                                                    <div class="addQuestionM">
                                                        <!-- <input type="text" id="typetext" placeholder="Enter your question here.."> -->
                                                        <button  type="button" class="addBtnOT addQuestionT waves-effect waves-light"><span class="ti-plus"></span> Add Questions</button>
                                                        <div id="questionsList"></div>
                                                    </div>
                                                </div>
                                                <div id="questionsArray">
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                            <div id="addlistP2">There are no Contacts yet for this property</div>


                            <!--=================Completed applications==================-->  
                            <!--=================Completed applications==================-->  
                            <div id="addlistP3">
                                <div class="payment-activelisting completeApplication">
                                    <h1>Completed Applications</h1>
                                    <p>You haven't received any applications yet, but you can activate your listings or invite a renter to apply.</p>
                                    <div class="activelistingS">
                                        <a class="activelistingbtn waves-effect waves-light btn modal-trigger" href="#applicationCmpt">Invite someone to apply</a>
                                    </div>
                                </div>    
                            </div>
                            <!--=================Completed applications==================-->  
                            <!--=================Completed applications==================-->  


                            <!--=================payment==================--> 
                            <!--=================payment==================--> 
                            <div id="addlistP4">
                                <div class="payment-activelisting">
                                    <img src="https://pixlritllc.com/mawjuud/assets/images/online-payment.png" class="mw-100" alt="images"/>
                                    <h1>Say Hello to Online Rent Payments</h1>
                                    <p>You get a free, secure way to collect rent right into your bank account. Your tenant gets more flexible ways to pay. You both get freedom from checks.</p>
                                    <p><a href="">Learn More</a></p>
                                    <button type="button" class="collectingrent waves-effect waves-light"> Start collecting rent </button>
                                    <p class="fontBB">By clicking "Start collecting rent" you agree to comply with the <a href="">Terms of Use. Rental User Terms,</a> and our third-party payment processor's  <a href="">Payment Terms</a> and <a href="">Authorization Terms.</a></p>
                                </div>
                            </div>
                            <!--=================payment==================--> 
                            <!--=================payment==================--> 
                        </div>
                    </form>
                </div>

                <div id="questionModal" class="modal custompopupdesign">
                    <a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
                    <img class="logoTopFix" src="https://pixlritllc.com/mawjuud/assets/images/imglogopop.png" alt="img" />
                    <div class="my-signup">
                        <h4 class="modal-title"><center>Edit question</center></h4>

                        <div class="row">
                            <div class="col s12">
                                <div class="input-field">
                                    <input name="ques" id="ques" type="text" placeholder="Question">
                                </div>
                                <div class="input-field">
                                    <button type="submit" class="cntagents addQuestion waves-effect waves-light">Save</button>
                                </div>
                            </div>
                        </div>     
                    </div>
                </div>

            </div>
        </div>

        <!--===========add listing ==================-->

        <?php include APPPATH.'views/frontend/includes/footer.php'; ?>
        <?php include APPPATH.'views/frontend/includes/footer_script.php'; ?>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyB1msoSFExJ6QVhosWAT9U30xQ7CbwvuM0"></script>
        <script src="<?php echo base_url(); ?>assets/js/frontend/google.js?<?php echo $timeStamp;?>"></script>
        <script src="<?php echo base_url(); ?>assets/js/richtext.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/property.js?<?php echo $timeStamp;?>"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>

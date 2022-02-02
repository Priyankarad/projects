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
                        <p><span>Any Price</span> <svg class="caret" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg></p>
                        <div class="maxminp-submenu">
                            <div class="input-controls">
                                <input type="text" name="min_price" id="min_price" placeholder="Min" class="minvalues" onkeyup="priceChange();" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                <input type="text" name="max_price" id="max_price" placeholder="Max" class="maxvalues" onkeyup="priceChange();" oninput="this.value = this.value. replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
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
                        <li class="sameSizeBli sortDiv">
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
                            <p class="view m-grids tooltipped" data-type="grid" data-position="bottom" data-tooltip="Grid View">
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                width="18px" height="18px" viewBox="0 0 51 51" enable-background="new 0 0 51 51" xml:space="preserve">
                                <g>
                                    <g>
                                        <g>
                                            <rect x="19.125" y="19.125" width="12.75" height="12.75"/>
                                            <rect width="12.75" height="12.75"/>
                                            <rect x="19.125" y="38.25" width="12.75" height="12.75"/>
                                            <rect y="19.125" width="12.75" height="12.75"/>
                                            <rect y="38.25" width="12.75" height="12.75"/>
                                            <rect x="38.25" width="12.75" height="12.75"/>
                                            <rect x="19.125" width="12.75" height="12.75"/>
                                            <rect x="38.25" y="19.125" width="12.75" height="12.75"/>
                                            <rect x="38.25" y="38.25" width="12.75" height="12.75"/>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </p>
                    </li>
                    <li class="breakrow2">
                        <p class="view MpicView m-photo tooltipped" data-type="photo" data-position="bottom" data-tooltip="Photo View">
                            <svg height="22px" viewBox="0 -52 512.00001 512" width="22px" xmlns="http://www.w3.org/2000/svg"><path d="m0 113.292969h113.292969v-113.292969h-113.292969zm30.003906-83.289063h53.289063v53.289063h-53.289063zm0 0"/><path d="m149.296875 0v113.292969h362.703125v-113.292969zm332.699219 83.292969h-302.695313v-53.289063h302.695313zm0 0"/><path d="m0 260.300781h113.292969v-113.292969h-113.292969zm30.003906-83.292969h53.289063v53.289063h-53.289063zm0 0"/><path d="m149.296875 260.300781h362.703125v-113.292969h-362.703125zm30.003906-83.292969h302.695313v53.289063h-302.695313zm0 0"/><path d="m0 407.308594h113.292969v-113.296875h-113.292969zm30.003906-83.292969h53.289063v53.289063h-53.289063zm0 0"/><path d="m149.296875 407.308594h362.703125v-113.296875h-362.703125zm30.003906-83.292969h302.695313v53.289063h-302.695313zm0 0"/></svg>
                        </p>
                    </li>
                    <li class="breakrow2">
                        <p class="view m-table tooltipped" data-type="table" data-position="bottom" data-tooltip="Table View">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            width="22px" height="22px" viewBox="0 0 475.082 475.081" style="enable-background:new 0 0 475.082 475.081;"
                            xml:space="preserve">
                            <g>
                                <path d="M461.667,49.963c-8.949-8.947-19.698-13.418-32.265-13.418H45.682c-12.562,0-23.317,4.471-32.264,13.418
                                C4.473,58.912,0,69.663,0,82.228V392.86c0,12.566,4.473,23.309,13.418,32.261c8.947,8.949,19.701,13.415,32.264,13.415h383.72
                                c12.566,0,23.315-4.466,32.265-13.415c8.945-8.952,13.415-19.701,13.415-32.261V82.228
                                C475.082,69.663,470.612,58.909,461.667,49.963z M146.183,392.85c0,2.673-0.859,4.856-2.574,6.571
                                c-1.712,1.711-3.899,2.562-6.567,2.562h-91.36c-2.662,0-4.853-0.852-6.567-2.562c-1.713-1.715-2.568-3.898-2.568-6.571V338.03
                                c0-2.669,0.855-4.853,2.568-6.56c1.714-1.719,3.905-2.574,6.567-2.574h91.363c2.667,0,4.858,0.855,6.567,2.574
                                c1.711,1.707,2.57,3.891,2.57,6.56V392.85z M146.183,283.221c0,2.663-0.859,4.854-2.574,6.564
                                c-1.712,1.714-3.899,2.569-6.567,2.569h-91.36c-2.662,0-4.853-0.855-6.567-2.569c-1.713-1.711-2.568-3.901-2.568-6.564v-54.819
                                c0-2.664,0.855-4.854,2.568-6.567c1.714-1.709,3.905-2.565,6.567-2.565h91.363c2.667,0,4.854,0.855,6.567,2.565
                                c1.711,1.713,2.57,3.903,2.57,6.567V283.221z M146.183,173.587c0,2.666-0.859,4.853-2.574,6.567
                                c-1.712,1.709-3.899,2.568-6.567,2.568h-91.36c-2.662,0-4.853-0.859-6.567-2.568c-1.713-1.715-2.568-3.901-2.568-6.567V118.77
                                c0-2.666,0.855-4.856,2.568-6.567c1.714-1.713,3.905-2.568,6.567-2.568h91.363c2.667,0,4.854,0.855,6.567,2.568
                                c1.711,1.711,2.57,3.901,2.57,6.567V173.587z M292.362,392.85c0,2.673-0.855,4.856-2.563,6.571c-1.711,1.711-3.9,2.562-6.57,2.562
                                H191.86c-2.663,0-4.853-0.852-6.567-2.562c-1.713-1.715-2.568-3.898-2.568-6.571V338.03c0-2.669,0.855-4.853,2.568-6.56
                                c1.714-1.719,3.904-2.574,6.567-2.574h91.365c2.669,0,4.859,0.855,6.57,2.574c1.704,1.707,2.56,3.891,2.56,6.56v54.819H292.362z
                                M292.362,283.221c0,2.663-0.855,4.854-2.563,6.564c-1.711,1.714-3.9,2.569-6.57,2.569H191.86c-2.663,0-4.853-0.855-6.567-2.569
                                c-1.713-1.711-2.568-3.901-2.568-6.564v-54.819c0-2.664,0.855-4.854,2.568-6.567c1.714-1.709,3.904-2.565,6.567-2.565h91.365
                                c2.669,0,4.859,0.855,6.57,2.565c1.704,1.713,2.56,3.903,2.56,6.567v54.819H292.362z M292.362,173.587
                                c0,2.666-0.855,4.853-2.563,6.567c-1.711,1.709-3.9,2.568-6.57,2.568H191.86c-2.663,0-4.853-0.859-6.567-2.568
                                c-1.713-1.715-2.568-3.901-2.568-6.567V118.77c0-2.666,0.855-4.856,2.568-6.567c1.714-1.713,3.904-2.568,6.567-2.568h91.365
                                c2.669,0,4.859,0.855,6.57,2.568c1.704,1.711,2.56,3.901,2.56,6.567v54.817H292.362z M438.536,392.85
                                c0,2.673-0.855,4.856-2.562,6.571c-1.718,1.711-3.908,2.562-6.571,2.562h-91.354c-2.673,0-4.862-0.852-6.57-2.562
                                c-1.711-1.715-2.56-3.898-2.56-6.571V338.03c0-2.669,0.849-4.853,2.56-6.56c1.708-1.719,3.897-2.574,6.57-2.574h91.354
                                c2.663,0,4.854,0.855,6.571,2.574c1.707,1.707,2.562,3.891,2.562,6.56V392.85z M438.536,283.221c0,2.663-0.855,4.854-2.562,6.564
                                c-1.718,1.714-3.908,2.569-6.571,2.569h-91.354c-2.673,0-4.862-0.855-6.57-2.569c-1.711-1.711-2.56-3.901-2.56-6.564v-54.819
                                c0-2.664,0.849-4.854,2.56-6.567c1.708-1.709,3.897-2.565,6.57-2.565h91.354c2.663,0,4.854,0.855,6.571,2.565
                                c1.707,1.713,2.562,3.903,2.562,6.567V283.221z M438.536,173.587c0,2.666-0.855,4.853-2.562,6.567
                                c-1.718,1.709-3.908,2.568-6.571,2.568h-91.354c-2.673,0-4.862-0.859-6.57-2.568c-1.711-1.715-2.56-3.901-2.56-6.567V118.77
                                c0-2.666,0.849-4.856,2.56-6.567c1.708-1.713,3.897-2.568,6.57-2.568h91.354c2.663,0,4.854,0.855,6.571,2.568
                                c1.707,1.711,2.562,3.901,2.562,6.567V173.587z"/>
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

                    </p>
                </li>
                <li class="PsaveBtnS">
                    <button class="modelsubmitBtns">Save Search</button>
                </li>
                <li>
                    <div class="propertysaveprnt">
                        <a href="<?php echo base_url();?>favourite_properties">
                            <button type="button" value="Saved Properties" class="modelsubmitBtns">
                                <span class="Sshow" id="saved_properties"><?php echo isset($favourite_properties)?"(".count($favourite_properties).")":'';?></span> Saved Properties
                            </button>
                        </a>
                    </div>
                </li>
            </ul>
        </form>
        <div class="openInquiryBlock">
        </div>
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
                        <div class="col-md-12">
                            <table class="table table-bordered" id="properties">
                                <thead>
                                    <th></th>
                                    <th></th>
                                </thead>        
                            </table>
                        </div>

                    </div><!---class="row"-->
                    <!--==============Property_list================-->
                </div>
                <div class="photoclktopH">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="propertiesPhotoView">
                                <thead>
                                    <th></th>
                                    <th></th>
                                </thead>        
                            </table>
                        </div>

                    </div><!---class="row"-->
                </div>
                <!--=============main_left-right============-->
                <div class="tableView">

                </div>
                <!--=============main_left-right============-->
            </div>
        </div>
        <div class="col s5 pd_lftzero pd_rgtzero M-mapfixedsec">
            <div class="srch_rsltmap">
                <div class="map-controller-icon">
                    <button class="clear clearActive tooltipped exceptNearby" data-position="right" data-tooltip="Clear"> 
                        <img src="<?php echo base_url();?>assets/images/map-icon/newsvgicon/clearselection.svg?<?php echo $timeStamp;?>">
                        Clear
                    </button>

                    <!--  <button onclick="circle();">  <img src="<?php echo base_url();?>assets/images/map-icon/radius.png" alt=""/> Radius</button> -->
                    <button class="ti-slice tooltipped exceptNearby drawActive" data-position="right" data-tooltip="Hand Draw"> 
                        <img src="<?php echo base_url();?>assets/images/map-icon/newsvgicon/handdraw.svg?<?php echo $timeStamp;?>">
                        Draw
                    </button>
                    <button class="tooltipped nearby nearbyActive" data-position="right" data-tooltip="Near by"> 
                        <img src="<?php echo base_url();?>assets/images/map-icon/newsvgicon/nearby.svg?<?php echo $timeStamp;?>">
                    </button>
                    <button class="tooltipped facilities exceptNearby transportActive" data-type="transport" data-position="right" data-tooltip="Transport"> 
                        <img src="<?php echo base_url();?>assets/images/map-icon/newsvgicon/transport.svg?<?php echo $timeStamp;?>">
                    </button>
                    <button class="tooltipped facilities exceptNearby schoolActive" data-type="school" data-position="right" data-tooltip="School"> 
                        <img src="<?php echo base_url();?>assets/images/map-icon/newsvgicon/school.svg?<?php echo $timeStamp;?>">
                    </button>
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
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/datatables.min.js?<?php echo $timeStamp;?>"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/search_property.js?<?php echo $timeStamp;?>"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/login.js?<?php echo $timeStamp;?>"></script>

<?php include APPPATH.'views/frontend/includes/header.php'; 
$userSession = $this->session->userdata('sessionData');
$userType = $userSession['user_role'];
?>

<div class="myaccountX">
  <div class="container">
    <div class="row">
      <div class="col s3">
        <div class="top_barAccount">
          <div class="profilFix">
            <img src="<?php echo (isset($userData->profile_thumbnail) && !empty($userData->profile_thumbnail))?$userData->profile_thumbnail:base_url().DEFAULT_IMAGE; ?>" />
            <p><?php echo isset($userData->email)?$userData->email:'';?></p>
            <p><a href="javascript:void(0)" class="editPs editRmyaccount">Edit profile <i class="ti-angle-right"></i></a></p>
          </div>
          <ul class="tabs">
            <li class="tab"><a class="<?php echo isset($tab)?'':'active';?>" href="#overview"><i class="ti-home"></i> Overview</a></li>
            <li class="tab"><a href="#dashboard"><i class="ti-dashboard"></i> Dashboard</a></li>
            <li class="tab"><a href="#my_profile" class="eclickrmv <?php echo (isset($tab) && ($tab == 'settings'))?'active':'';?>"><i class="ti-user"></i> My Profile </a></li>
            <?php if($userType == 'agent'){ ?>
              <li class="pdL20 "><a href="<?php echo base_url();?>add_property" target="_blank"><i class="ti-plus"></i> Add Property </a></li>
            <?php } ?>
            <?php if($userType == 'agent'){ ?>
              <li class="tab"><a href="#mproperty" class="<?php echo (isset($tab)&&$tab == 'my_propeties')?'active':'';?>"><i class="ti-home"></i>  My Properties </a></li>    
            <?php } ?>
            <li class="pdL20 "><a href="<?php echo base_url();?>favourite_properties" target="_blank"><i class="ti-heart"></i>  Favourite Properties </a></li>
              <li class="pdL20 "><a href="<?php echo base_url();?>compare_properties" target="_blank"><i class="ti-plus"></i>  Compare Properties </a></li>
            <?php if($userType == 'owner'){ ?>
              <li class="tab"><a href="#alerts" class="<?php echo (isset($tab) && ($tab == 'searches'))?'active':'';?>"><i class="ti-bell"></i>  Alerts & Searches</a></li>
              <li class="tab"><a href="#emailpreference"><i class="ti-email"></i>  Email Preferences </a></li>
            <?php } ?>
            <?php if($userType == 'agent'){ ?>
              <li class="tab"><a href="<?php echo base_url();?>hidden_properties" target="_blank"><i class="ti-power-off"></i>  Hidden Properties</a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <div class="col s9">
        <?php if($this->session->flashdata('success')){ ?>
          <div class="success card-panel teal accent-3">
            <strong><?php echo $this->session->flashdata('success'); ?></strong>
          </div>
        <?php } ?>
        <div class="all_cnt_accountS">
          <div id="overview" class="<?php echo isset($tab)?'':'active';?>">
            <div class="myOverviewsG">
              <h2>Welcome <span><?php echo (isset($userSession['first_name'])&&isset($userSession['last_name']))?$userSession['first_name']." ".$userSession['last_name']:''; ?></span></h2>
              <p>You can now personalise your properly search with Mawjuud.</p>
              <!-- <div class="enhanceP">
                <h3>Enhance your property search</h3>
                <div class="row">
                  <div class="col s6">
                    <div class="enhancePBox">
                      <i class="ti-user"></i>
                      <h4>Recent searches </h4> 
                      <p>Lorem ipsum dolor sit amet, <br/> adipisicing elit. Molestiae</p>
                    </div>
                  </div>
                  <div class="col s6">
                    <div class="enhancePBox">
                      <i class="ti-user"></i>
                      <h4>Recent searches </h4> 
                      <p>Lorem ipsum dolor sit amet, <br/> adipisicing elit. Molestiae</p>
                    </div>
                  </div>
                  <div class="col s6">
                    <div class="enhancePBox">
                      <i class="ti-user"></i>
                      <h4>Recent searches </h4> 
                      <p>Lorem ipsum dolor sit amet, <br/> adipisicing elit. Molestiae</p>
                    </div>
                  </div>
                  <div class="col s6">
                    <div class="enhancePBox">
                      <i class="ti-user"></i>
                      <h4>Recent searches </h4> 
                      <p>Lorem ipsum dolor sit amet, <br/> adipisicing elit. Molestiae</p>
                    </div>
                  </div>
                </div>
              </div> -->
              <ul class="viewsItemShow">
                <li>
                  <h3>100</h3>
                  <span>Items viewed</span>
                </li>
                <li>
                  <h3>10</h3>
                  <span>Items Saved</span>
                </li>
                <li>
                  <h3>5</h3>
                  <span>Searches Saved</span>
                </li>
                <li>
                  <h3>5</h3>
                  <span>Requests sent</span>
                </li>
              </ul>
            </div>
          </div>
          <div id="dashboard">
            <div class="activity_table">
              <h5>Call Activity</h5>
              <table class="responsive-table callActivity striped">
                <thead>
                  <tr>
                    <th>S No.</th>
                    <th>Called By</th>
                    <th>Property Reference ID</th>
                    <th>Beds</th>
                    <th>Baths</th>
                    <th>Square Feet</th>
                    <th>Call Date</th>
                    <th>Call Time</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  if(!empty($callActivities['result'])){
                    $count = 0;
                    foreach($callActivities['result'] as $call){
                      $count++; ?>
                      <tr>
                        <td><?php echo $count;?></td>
                        <td><?php echo isset($call->firstname)?ucwords($call->firstname." ".$call->lastname):'';?></td>
                        <td><a href="<?php echo base_url();?>single_property?id=<?php echo encoding($call->prop_id);?>" target="_blank"><?php echo isset($call->mawjuud_reference)?$call->mawjuud_reference:'';?></a></td>
                        <td><?php echo ($call->bedselect==100)?"Studio":$call->bedselect;?></td>
                        <td><?php echo isset($call->bathselect)?$call->bathselect:'';?></td>
                        <td><?php echo isset($call->square_feet)?$call->square_feet:'';?></td>
                        <td><?php echo isset($call->call_timing)?date('d-m-y', strtotime($call->call_timing)):'';?></td>
                        <td><?php echo isset($call->call_timing)?date('H:i A', strtotime($call->call_timing)):'';?></td>
                      </tr>
                    <?php }
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <div class="activity_table">
              <h5>Contact Messages</h5>
              <table class="responsive-table callActivity striped">
                <thead>
                  <tr>
                    <th>S No.</th>
                    <th>Message By</th>
                    <th>Property Reference ID</th>
                    <th>Beds</th>
                    <th>Baths</th>
                    <th>Square Feet</th>
                    <th>Message Date</th>
                    <th>Message Time</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  if(!empty($contactMessages['result'])){
                    $count = 0;
                    foreach($contactMessages['result'] as $msg){
                      $count++; ?>
                      <tr>
                        <td><?php echo $count;?></td>
                        <td><?php echo isset($msg->name)?ucwords($msg->name):'';?></td>
                        <td><a href="<?php echo base_url();?>single_property?id=<?php echo encoding($msg->prop_id);?>" target="_blank"><?php echo isset($msg->mawjuud_reference)?$msg->mawjuud_reference:'';?></a></td>
                        <td><?php echo ($msg->bedselect==100)?"Studio":$msg->bedselect;?></td>
                        <td><?php echo isset($msg->bathselect)?$msg->bathselect:'';?></td>
                        <td><?php echo isset($msg->square_feet)?$msg->square_feet:'';?></td>
                        <td><?php echo isset($msg->contact_date)?date('d-m-y', strtotime($msg->contact_date)):'';?></td>
                        <td><?php echo isset($msg->contact_date)?date('H:i A', strtotime($msg->contact_date)):'';?></td>
                      </tr>
                    <?php }
                  }
                  ?>
                </tbody>
              </table> 
            </div>

          </div>
          <div id="my_profile" class="<?php echo (isset($tab) && ($tab == 'settings'))?'active':'';?>">
            <div class="myOverviewsG userFrmX"> 

              <ul class="tabs accountmawjuudsa">
                <li class="tab col s3"><a class="active activedefault" href="#mydetails">My details</a></li>
                <li class="tab col s3"><a href="#chagepasswords">Change Password</a></li>
                <li class="tab col s3"><a href="#chageemails">Change Email</a></li>
              </ul>
              <div class="row">
                <!---======= MY Details =================-->
                <div id="mydetails" class="col s12">
                  <form id="accountForms" method="post" class="accountForms" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col s4">
                        <h6>Full Name</h6>
                      </div>
                      <div class="col s8">
                        <div class="row">
                          <div class="input-field col s6">
                            <input id="first_name" name="first_name" type="text" class="validate"  value="<?php echo isset($userData->firstname)?$userData->firstname:'';?>"/>
                            <label for="first_name">First Name</label>
                          </div>
                          <div class="input-field col s6">
                            <input id="last_name" name="last_name" type="text" class="validate"  value="<?php echo isset($userData->lastname)?$userData->lastname:'';?>"/>
                            <label for="last_name">Last Name</label>
                          </div>
                        </div>
                      </div>  
                    </div>
                    <div class="row">
                      <div class="col s4">
                        <h6>Professional Category</h6>
                      </div>
                      <div class="col s8">
                        <div class="row">
                          <div class="input-field col s12">
                            <select id="category_agent" name="category_agent">
                              <!--  <option value="" disabled selected >Select your category </option> -->
                              <option value="owner" <?php echo ($userData->user_type == 'owner')?'selected':'';    ?>>Renter/Buyer/Property Owner </option>
                              <option value="agent" <?php echo ($userData->user_type == 'agent')?'selected':''; ?>>Real Estate Agent/Broker</option>
                            </select>
                            <!-- <label>Materialize Select</label> -->
                          </div>
                        </div>
                      </div>  
                    </div>
                    <div class="row agency_name">
                      <div class="col s4">
                        <h6>Agency Name <span>(optional)</span></h6>
                      </div>
                      <div class="col s8">
                        <div class="row">
                          <div class="input-field col s12">
                            <input id="agency_name" name="agency_name" type="text" class="validate" value="<?php echo isset($userData->agency_name)?$userData->agency_name:'';?>"/>
                            <label for="agency_name">Agency Name</label>
                          </div>
                        </div>
                      </div>  
                    </div>
                    <div class="row">
                      <div class="col s4">
                        <h6>Nationality <span>(optional)</span></h6>
                      </div>
                      <div class="col s8">
                        <div class="row">
                          <div class="input-field col s12">
                            <input id="nationality" name="nationality" type="text" class="validate" value="<?php echo isset($userData->nationality)?$userData->nationality:'';?>"/>
                            <label for="nationality">Nationality</label>
                          </div>
                        </div>
                      </div>  
                    </div>
                    <div class="row">
                      <div class="col s4">
                        <h6>Cell Phone <span>(optional)</span></h6>
                      </div>
                      <div class="col s8">
                        <div class="row">
                          <div class="input-field col s4">
                            <input type="tel" id="user_country_code" name="user_country_code" class="validate phone" value="<?php echo isset($userData->user_country_code)?$userData->user_country_code:'';?>"/>
                            <!-- <label for="user_country_code">Country Code</label> -->
                          </div>
                          <div class="input-field col s8">
                            <input id="user_number" name="user_number" type="text" class="validate" value="<?php echo isset($userData->user_number)?$userData->user_number:'';?>"/>
                            <label for="user_number">Number</label>
                          </div>
                        </div>
                      </div>  
                    </div>

                    <!--===========Agancy-cell phone optionals==============-->
                    <div class="row agentBrokerSelect">
                      <div class="col s4">
                        <h6>Cell Phone</h6>
                      </div>
                      <div class="col s8">
                        <div class="row">
                          <div class="input-field col s4">
                            <input type="tel" id="agency_cell_code" name="agency_cell_code" class="validate phone" value="<?php echo isset($userData->agency_cell_code)?$userData->agency_cell_code:'';?>" />
                            <!-- <label for="agency_cell_code">Country Code</label> -->
                          </div>
                          <div class="input-field col s8">
                            <input id="agency_cell" name="agency_cell" type="text" class="validate" value="<?php echo isset($userData->agency_cell)?$userData->agency_cell:'';?>"/>
                            <label for="agency_cell">Number</label>
                          </div>
                        </div>
                      </div>  
                    </div>
                    <!--===========Agancy-cell phone optionals==============-->

                    <!--===========Agancy-phone==============-->
                    <div class="row agentBrokerSelect">
                      <div class="col s4">
                        <h6>Agency Phone <span>(optional)</span></h6>
                      </div>
                      <div class="col s8">
                        <div class="row">
                          <div class="input-field col s4">
                            <input type="tel" id="agency_phone_code" name="agency_phone_code" class="validate phone" value="<?php echo isset($userData->agency_phone_code)?$userData->agency_phone_code:'';?>"/>
                            <!-- <label for="agency_phone_code">Country Code</label> -->
                          </div>
                          <div class="input-field col s8">
                            <input id="agency_phone" name="agency_phone" type="text" class="validate" value="<?php echo isset($userData->agency_phone)?$userData->agency_phone:'';?>"/>
                            <label for="agency_phone">Number</label>
                          </div>
                        </div>
                      </div>  
                    </div>
                    <!--===========Agancy-phone==============-->

                    <div class="row">
                      <div class="col s4">
                        <h6>Profile Photo <span>(optional)</span></h6>
                      </div>
                      <div class="col s8">
                        <div class="file-field input-field">
                          <div class="choosePi">
                            <span>Choose File</span>
                            <input type="file" id="profile_img" name="profile_img">
                          </div>
                          <div class="file-path-wrapper">
                            <input class="file-path validate" id="img_name" name="img_name" type="text" value="<?php echo isset($userData->img_name)?$userData->img_name:'';?>">
                          </div>
                          <div class="file-path-wrapper2">
                            <button type="button" class="uploadProfile" disabled="">
                              Upload
                            </button>
                          </div>
                        </div>
                      </div>  
                    </div>


                    <div class="row agency_name">
                      <div class="col s4">
                        <h6>Agency Logo <span>(optional)</span></h6>
                      </div>
                      <div class="col s8">
                        <div class="file-field input-field">
                          <div class="choosePi">
                            <span>Choose File</span>
                            <input type="file" id="agency_logo" name="agency_logo">
                          </div>
                          <div class="file-path-wrapper">
                            <input class="file-path validate" id="logo_name" name="logo_name" type="text" value="<?php echo isset($userData->logo_name)?$userData->logo_name:'';?>">
                          </div>
                          <div class="file-path-wrapper2">
                            <button type="button" class="uploadProfile" disabled="">
                              Upload
                            </button>
                          </div>
                        </div>
                      </div>  
                    </div>

                    <!--===========Agancy-Professional Licenses==============-->
                    <div class="row agentBrokerSelect">
                      <div class="col s4">
                        <h6>Professional Licenses <span>(optional)</span></h6>
                      </div>
                      <div class="col s8">
                        <div class="row">
                          <div class="col s3">
                            <div class="input-field">
                              <span class="titleDst">Description:</span>
                            </div>
                          </div>
                          <div class="col s9">
                            <div class="input-field">
                              <input id="license_description" name="license_description" type="text" class="validate" value="<?php echo isset($userData->license_description)?$userData->license_description:'';?>"/>
                              <label for="license_description">Enter licenses title and/or state issued</label>
                            </div>
                          </div>
                        </div>

                        <div class="LicensesRepeat">
                          <?php 
                          $licenses_number = isset($userData->licenses_number)?explode(",",$userData->licenses_number):array();
                          if(!empty($licenses_number)){
                            $count = 0;
                            foreach($licenses_number as $lic){
                              $count++;
                              ?>
                              <div class="row"> 
                                <div class="col s3">
                                  <div class="input-field">
                                    <span class="titleDst">Licenses #:</span> 
                                  </div>
                                </div>
                                <div class="col s7">
                                  <div class="input-field"> 
                                    <input name="licenses_number[]" type="text" class="validate" value="<?php echo $lic;?>"/>
                                    <label>
                                      Enter licenses number
                                    </label> 
                                  </div>
                                </div>
                                <?php if($count == 1){ ?>
                                  <div class="col s2">
                                    <div class="input-field">
                                      <button type="button" class="addMoreField waves-effect waves-light">Add More</button>
                                    </div>
                                  </div>
                                <?php }else{ ?>
                                  <div class="col s2"> 
                                    <div class="input-field"> 
                                      <button type="button" class="closeField waves-effect waves-light">Close</button>
                                    </div>
                                  </div>
                                <?php } ?>
                              </div>
                            <?php } 
                          }

                          else{ ?>
                            <div class="row">
                              <div class="col s3">
                                <div class="input-field">
                                  <span class="titleDst">Licenses #:</span>
                                </div>
                              </div>
                              <div class="col s7">
                                <div class="input-field">
                                  <input id="licenses_number" name="licenses_number[]" type="text" class="validate"/>
                                  <label for="licenses_number">Enter licenses number</label>
                                </div>
                              </div>
                              <div class="col s2">
                                <div class="input-field">
                                  <button type="button" class="addMoreField waves-effect waves-light">Add More</button>
                                </div>
                              </div>
                            </div>
                          <?php } ?>
                        </div>

                        <p class="grayP">To add multiple licenses, enter your first license # and description and then click "add more" Repeat until you're done adding licenses.</p>
                      </div>  
                    </div>
                    <!--===========Agancy-Professional Licenses==============-->


                    <!--===========Agancy-services area=============-->
                    <div class="row agentBrokerSelect">
                      <div class="col s4">
                        <h6>Services Areas <span>(optional)</span></h6>
                      </div>
                      <div class="col s8">
                        <div class="servicesRepeat">
                          <?php 
                          $services_area = isset($userData->services_area)?explode(",",$userData->services_area):array();
                          if(!empty($services_area)){
                            $count = 0;
                            foreach($services_area as $ser){
                              $count++;
                              ?>
                              <div class="row"> 
                                <div class="col s10">
                                  <div class="input-field">
                                    <input id="services_area" name="services_area[]" type="text" class="validate" value="<?php echo $ser;?>"/>
                                    <label for="services_area">Neighbourhood, city, country, ZIP, etc.</label>
                                  </div>  
                                </div>
                                <?php if($count == 1){ ?>
                                  <div class="col s2">
                                    <div class="input-field text-right">
                                      <button type="button" class="addMoreField2 waves-effect waves-light">Add More</button>
                                    </div>
                                  </div>
                                <?php }else{ ?>
                                  <div class="col s2"> 
                                    <div class="input-field"> 
                                      <button type="button" class="closeField waves-effect waves-light">Close</button>
                                    </div>
                                  </div>
                                <?php } ?>
                              </div>
                            <?php } 
                          }

                          else{ ?>
                            <div class="row">
                              <div class="col s10">
                                <div class="input-field">
                                  <input id="services_area" name="services_area[]" type="text" class="validate"/>
                                  <label for="services_area">Neighbourhood, city, country, ZIP, etc.</label>
                                </div>  
                              </div> 
                              <div class="col s2">
                                <div class="input-field text-right">
                                  <button type="button" class="addMoreField2 waves-effect waves-light">Add More</button>
                                </div>
                              </div> 
                            </div>
                          <?php } ?>
                        </div>
                        <p class="grayP">Enter the areas you serve. To add multiple areas, enter your first area in the box and "Add more." Then repeat width your next service area.</p>
                      </div>
                    </div>  
                    <!--===========Agancy-services area=============-->

                    <!--===========Agancy-Language Fluency=============-->
                    <div class="row agentBrokerSelect">
                      <div class="col s4">
                        <h6>Language Fluency <span>(optional)</span></h6>
                      </div>
                      <?php $languages = isset($userData->language)?explode(",",$userData->language):array();?>
                      <div class="col s8">
                        <div class="input-field">
                          <div class="row mtop20">
                            <div class="col s4">
                              <label class="oue_checkboxS">
                                <input type="checkbox" id="language" name="language[]" value="Spanish" <?php echo (in_array("Spanish",$languages))?'checked':''; ?>>
                                <span>Spanish</span>
                              </label>
                              <label class="oue_checkboxS">
                                <input type="checkbox" id="language1" name="language[]" value="Mandarin" <?php echo (in_array("Mandarin",$languages))?'checked':''; ?>>
                                <span>Mandarin</span>
                              </label>
                            </div>  
                            <div class="col s4">
                              <label class="oue_checkboxS">
                                <input type="checkbox" id="language2" name="language[]" value="French" <?php echo (in_array("French",$languages))?'checked':''; ?>>
                                <span>French</span>
                              </label>
                              <label class="oue_checkboxS">
                                <input type="checkbox" id="language" name="language[]" value="Russian" <?php echo (in_array("Russian",$languages))?'checked':''; ?>>
                                <span>Russian</span>
                              </label>
                            </div> 
                            <div class="col s4">
                              <label class="oue_checkboxS">
                                <input type="checkbox" id="language2" name="language[]" value="Arabic" <?php echo (in_array("Arabic",$languages))?'checked':''; ?>>
                                <span>Arabic</span>
                              </label>
                              <label class="oue_checkboxS">
                                <input type="checkbox" id="language" name="language[]" value="English" <?php echo (in_array("English",$languages))?'checked':''; ?>>
                                <span>English</span>
                              </label>
                            </div>   
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--===========Agancy-Language Fluency=============-->

                    <!--===========Agancy-Profile video==============-->
                    <div class="row agentBrokerSelect">
                      <div class="col s4">
                        <h6>Profile Video <span>(optional)</span></h6>
                      </div>
                      <div class="col s8">
                        <div class="input-field">
                          <input id="profile_video" name="profile_video" type="text" class="validate" value="<?php echo isset($userData->profile_video)?$userData->profile_video:'';?>"/>
                          <label for="profile_video">Paste "share" URL from YouTube.</label>
                        </div>
                      </div>  
                    </div>
                    <!--===========Agancy-Profile video==============-->

                    <!--===========Agancy-Website==============-->
                    <div class="row agentBrokerSelect">
                      <div class="col s4">
                        <h6>Website <span>(optional)</span></h6>
                      </div>
                      <div class="col s8">
                        <div class="input-field">
                          <input id="website_url" name="website_url" type="text" class="validate" value="<?php echo isset($userData->website_url)?$userData->website_url:'';?>"/>
                          <label for="website_url">website URL</label>
                        </div>
                      </div>  
                    </div>
                    <!--===========Agancy-Website==============-->

                    <!--===========Agancy-Blog==============-->
<!--   <div class="row agentBrokerSelect">
<div class="col s4">
<h6>Blog <span>(optional)</span></h6>
</div>
<div class="col s8">
<div class="input-field">
<input id="blog" name="blog" type="text" class="validate" value="<?php echo isset($userData->blog)?$userData->blog:'';?>"/>
<label for="blog">Your blog</label>
</div>
</div>  
</div> -->
<!--===========Agancy-Blog==============-->


<!--===========Agancy-Facebook==============-->
<!--   <div class="row agentBrokerSelect">
<div class="col s4">
<h6>Facebook <span>(optional)</span></h6>
</div>
<div class="col s8">
<div class="input-field">
<input id="fb_url" name="fb_url" type="text" class="validate" value="<?php echo isset($userData->facebook_profile_url)?$userData->facebook_profile_url:'';?>"/>
<label for="fb_url">www.facebook.com</label>
</div>
</div>  
</div> -->
<!--===========Agancy-Facebook==============-->


<!--===========Agancy-Facebook==============-->
<!--  <div class="row agentBrokerSelect">
<div class="col s4">
<h6>Twitter <span>(optional)</span></h6>
</div>
<div class="col s8">
<div class="input-field">
<input id="twitter_url" name="twitter_url" type="text" class="validate" value="<?php echo isset($userData->twitter_profile_url)?$userData->twitter_profile_url:'';?>"/>
<label for="twitter_url">www.twitter.com</label>
</div>
</div>  
</div> -->
<!--===========Agancy-Facebook==============-->

<!--===========Agancy-Facebook==============-->
<div class="row agentBrokerSelect">
  <div class="col s4">
    <h6>Linkedin <span>(optional)</span></h6>
  </div>
  <div class="col s8">
    <div class="input-field">
      <input id="linkedin_url" name="linkedin_url" type="text" class="validate" value="<?php echo isset($userData->linkedin_profile_url)?$userData->linkedin_profile_url:'';?>"/>
      <label for="linkedin_url">www.linkedin.com/in</label>
    </div>
  </div>  
</div>
<!--===========Agancy-Facebook==============-->

<div class="row">
  <div class="col s4">
    <input type="submit" id="submitProfilebtn" value="Save Profile" class="submitProfilebtn">
  </div>
</div>
</form>
</div>
<!---======= MY Details =================-->

<!---======= chagepasswords =================-->
<div id="chagepasswords" class="col s9">
  <form id="changepwdForm" method="post">
    <div class="input-field">
      <input type="password" id="crntpwd" name="crntpwd"/>
      <label for="crntpwd" class="active">Current password</label>
      <a href="#forgotpwd" class="modal-trigger newforgotpwds">Forgotten password?</a>
    </div>
    <div class="input-field">
      <input type="password" id="newpwd" name="newpwd" />
      <label for="newpwd" class="active">New password</label>
    </div>
    <div class="input-field">
      <input type="password" id="cnpwd" name="cnpwd"/>
      <label for="cnpwd" class="active">Confirm new password</label>
    </div>
    <div class="input-field">
      <input type="submit" value="Change password" class="submitPassword submitProfilebtn">
    </div>
  </form>    
</div>
<!---======= chagepasswords =================-->


<!---======= chageemails =================-->
<div id="chageemails" class="col s9">
  <form id="changemailform" method="post">
    <div class="input-field">
      <input type="text" id="crntpwd" value="<?php echo isset($userData->email)?$userData->email:'';?>" readonly="" />
      <label for="crntpwd" class="active">Current email address</label>
    </div>
    <div class="input-field">
      <input type="text" id="newemail" name="newemail" />
      <label for="newpwd" class="active">New email address</label>
    </div>
    <div class="input-field">
      <input type="submit" value="Change email address" class="submitProfilebtn submitEmailbtn">
    </div>
  </form>    
</div>
<!---======= chageemails =================-->
</div>



</div>
</div>
<!--============mproperty==============-->
<div id="mproperty" class="<?php echo (isset($tab) && ($tab == 'my_propeties')?'active':'');?>">
  <div class="mproperty-db">
    <h2>My Properties</h2>
    <form>
      <div class="m-proertyyflt">
        <div class="row">
          <div class="col s3">
            <select class="form-control" multiple id="category" name="category[]" onchange="searchProperty();">
              <option selected="" disabled="">Type</option>
              <?php 
              if(!empty($categories['result'])){ 

                foreach($categories['result'] as $category){ ?>
                 <option value="<?php echo $category->id;?>" ><?php echo $category->name;?></option>   

               <?php }   
             } ?>
           </select> 
         </div>
         <div class="col s2">
          <select id="status" name="status" onchange="searchProperty();">
            <option selected="" disabled="">Status</option>
            <option value="active">Active</option>
            <option value="draft">Draft</option>
          </select>
        </div>
        <div class="col s3">
          <select id="property_type" name="property_type" onchange="searchProperty();">
            <option selected="" disabled="">Show all</option>
            <option value="featured">Featured</option>
            <option value="rented">Rented</option>
            <option value="sold">Sold</option>
            <option value="open">Open</option>
          </select>
        </div>
        <div class="col s4">
          <ul class="item-inlinesm">
            <li>
              <p class="short_Xb"><span class="ti-exchange-vertical"></span>Sort</p>
              <div class="Sort-subbox">
                <ul>
                  <li>
                    <a href="javascript:void(0);" class="sortBy" data-sort="recent_publish">Recently Published</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="sortBy" data-sort="recent_added">Recently Added</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="sortBy" data-sort="high_low">High-Low Price</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="sortBy" data-sort="low_high">Low-High Price</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="sortBy" data-sort="size">Largest Size</a>
                  </li>
                </ul>    
              </div>   
            </li>
            <li><a class="view" data-type="photo"><img src="<?php echo base_url();?>assets/images/photo-view.png" class="tooltipped" data-position="top" data-tooltip="Photo View"></a></li>
            <li><a class="view" data-type="table"><img src="<?php echo base_url();?>assets/images/table-view.png" class="tooltipped" data-position="top" data-tooltip="Table View"></a></li>
            <li><a href="" class="checkout-mj">Checkout</a></li>
          </ul>
        </div>
      </div>
    </div>
    <hr/>
  </form>
  <div class="d-propertylist">
    <table class="responsive-table propertyPhotoTable">
      <thead style="display:none;"><tr><th></th></tr></thead>
    </table>
  </div>
<div class="d-propertytable hide">
  <div class="row">
    <div class="col s12">
      <table id="property_table" class="propertyTableView">
        <thead>
          <tr>
           <!--  <th>
              <label>
                <input type="checkbox" />
                <span class="spaceblnkM"></span>
              </label>
            </th> -->
            <th><b>R / S</b></th>
            <th><b>Type</b></th>
            <th><b>Ref #</b></th>
            <th><b>Title</b></th>
            <th><b>Address</b></th>
            <th><b>Price (AED)</b></th>
            <th><b>Bed</b></th>
            <th><b>Bath</b></th>
            <th><b>Size (Sq.ft.)</b></th>
            <th><b>Date Added</b></th>
            <th><b>Date Published</b></th>
            <th><b>Status</b></th>
           <!--  <th><b>Featured</b></th> -->
            <th><b>Activity</b></th>
            <th><b>Mark</b></th>
            <th><b>E.S.D.</b></th>
          </tr>
        </thead>
       
      </table>
    </div>
  </div>
</div>

<div class="addnewPdsh"><a href="<?php echo base_url();?>add_property" target="_blank"><span class="ti-plus"></span> Add New</a></div>
</div>  
</div>
<!--============mproperty==============-->

<div id="alerts" class="<?php echo (isset($tab) && ($tab == 'searches'))?'active':'';?>">
  <table id="titleTable" class="table responsive-table striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        if(!empty($searchedProperty['result'])){
          $count = 0;
          foreach($searchedProperty['result'] as $title){
            $count++; ?>
            <tr id="<?php echo $title->id;?>">
              <td>#</td>
              <td><?php echo $title->title;?></td>
              <td>
                <a class="btnblock waves-effect waves-light EdtbBtn EdtbBtn2 modal-trigger deleteRecord" href="#deleteModal" data-record_id="<?php echo $title->id?>" data-table="<?php echo PROPERTY_SEARCH;?>">Delete</a>
                
                <a href="<?php echo base_url().'property/viewMySearch/'.encoding($title->id);?>"><img src="<?php echo base_url();?>assets/images/view.svg" alt=""></a>
              </td>
            </tr>
          <?php }
        }
      ?>
    </tbody>
  </table>
</div>
<div id="deleteModal" class="modal">
  <div class="modal-content">
    <h4>Delete</h4>
    <p>Do you really want to delete this record ?</p>
  </div>
  <div class="modal-footer">
    <form id="deleteForm" method="post">
      <input type="hidden" id="record_id">
      <input type="hidden" id="redirect_url">
      <input type="hidden" id="table">
    </form>
    <a href="#!" class="waves-effect waves-green btn-flat" onclick="deleteRecord();">Delete</a>
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
  </div>
</div>
<!--========= EMAIL PREFERENCE ===========-->
<div id="emailpreference">
  <div class="email-inners">
    <h2>Email Preferences</h2>
    <h5>Manage your Email Preferences</h5>
    <p>You can now select how do you want to receive updates form Mawjuud.</p>
    <ul class="email-prelists">
      <li>
        <div class="yesnobtns">
          <div class="switch">
            <label>
              Off
              <input type="checkbox" class="switches" name="mawjuud_news" data-option="mawjuud_news" <?php echo ($userData->mawjuud_news == 1)?'checked':'';?>>
              <span class="lever"></span>
              On
            </label>
          </div>
        </div>
        <h4>Mawjuud News & Updates</h4>  
        <p>Exciting property news, surveys and offers from Mawjuud.</p>     
      </li>
      <li>
        <div class="yesnobtns">
          <div class="switch">
            <label>
              Off
              <input type="checkbox" class="switches" name="news_property_offers" data-option="news_property_offers" <?php echo ($userData->news_property_offers == 1)?'checked':'';?>>
              <span class="lever"></span>
              On
            </label>
          </div>
        </div>
        <h4>New Property Offers</h4>  
        <p>Updates on new build properties in your search area from new property offers.</p>     
      </li>
      <li>
        <div class="yesnobtns">
          <div class="switch">
            <label>
              Off
              <input type="checkbox" class="switches" name="partner_offers" data-option="partner_offers" <?php echo ($userData->partner_offers == 1)?'checked':'';?>>
              <span class="lever"></span>
              On
            </label>
          </div>
        </div>
        <h4>Partner Offers</h4>  
        <p>Latest money-saving offers from Mawjuud top chosen property and financial partners.</p>     
      </li>
      <li>
        <div class="yesnobtns">
          <div class="switch">
            <label>
              Off
              <input type="checkbox" class="switches" name="mawjuud_survey" data-option="mawjuud_survey" <?php echo ($userData->mawjuud_survey == 1)?'checked':'';?>>
              <span class="lever"></span>
              On
            </label>
          </div>
        </div>
        <h4>Mawjuud Survey</h4>  
        <p>Occasional survey to help us understand/report on the housing market.</p>     
      </li>
      <li>
        <div class="yesnobtns">
          <div class="switch">
            <label>
              Off
              <input type="checkbox" class="switches" name="q_a" data-option="q_a" <?php echo ($userData->q_a == 1)?'checked':'';?>>
              <span class="lever"></span>
              On
            </label>
          </div>
        </div>
        <h4>Q & A</h4>  
        <p>I would like to know if my questions or comments have been replied to.</p>     
      </li>
      <li>
        <div class="yesnobtns">
          <div class="switch">
            <label>
              Off
              <input type="checkbox" class="switches" name="move" data-option="move" <?php echo ($userData->move == 1)?'checked':'';?>>
              <span class="lever"></span>
              On
            </label>
          </div>
        </div>
        <h4>Move</h4>  
        <p>Moving home in the coming months? Receive updates and offers personalised to your move.</p>     
      </li>
    </ul>
  </div>
</div>
<!--========= EMAIL PREFERENCE ===========-->

<div id="test4">Test 4</div>
</div>
</div>
</div>
</div>
</div>

<?php $this->session->unset_userdata('my_account'); ?>
<?php include APPPATH.'views/frontend/includes/footer.php'; ?>
<?php include APPPATH.'views/frontend/includes/footer_script.php'; ?>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/myaccount.js?<?php echo $timeStamp;?>"></script>
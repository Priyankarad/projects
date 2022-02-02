<input type="hidden" id="user_login_type" value="<?php if($this->session->userdata('user_login_type') && $user_data->basic_info == 0){ echo "performer";}else{ echo 0;}  ?>"> 
<input type="hidden" id="business" value="0">
<input type="hidden" name="profileSet" id="profileSet" value="1">
<input type="hidden" name="last_folder" id="last_folder" value="0">
<?php
   $imgs =""; 
   
   $usernamefb = "";
   
   $imgs = ($user_data->profile !=  'assets/images/default_image.jpg')? $user_data->profile: base_url().'/assets/images/icon-facebook.gif';;
   
   if(!empty($user_data) ) {
   
   // $usernamefb =  $user_data->firstname." ".$user_data->lastname;
   
   	if($user_data->business_name!=''){
   
   		$usernamefb = $user_data->business_name." on WorkAdvisor.co";
   
   	}else{
   
   		$usernamefb = $user_data->firstname." ".$user_data->lastname." on WorkAdvisor.co";
   
   	}
   
   } else {
   
   	$usernamefb = '';
   
   }
   
   ?>
<style type="text/css">
   #share-buttons img {
   width: 35px;
   padding: 5px;
   border: 0;
   box-shadow: 0;
   display: inline;
   }
   video {
   cursor: pointer;
   }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/dropzone.css">
<section class="profile_tab" >
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-12 pl_inlft">
            <div class="tab_list">
               <div class="card lc-wz">
                  <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="bell notification_toggle">
                        <a> <i class="fa fa-bell" ></i><span class="rivew-bell notification_bell">0</span> Notification </a>
                        <ul id="notifications_ul"></ul>
                     </li>
                     <li role="presentation" class="taskopens">
                       <!--  <a> 
                        <i class="fa fa-check-square" aria-hidden="true"></i> Tasks
                        </a> -->
                        <a> <i class="fa fa-bell" ></i><span class="rivew-bell task_bell">0</span> Tasks </a>
                        <ul id="my_tasks">
                        </ul>
                     </li>
                     <li role="presentation">
                        <a href="<?php echo base_url()?>user/favourites_list"> <i class="fa fa-heart" aria-hidden="true"></i> Favorites </a>
                     </li>
                     <li role="presentation">
                        <a  aria-controls="ShareProfile" role="tab" data-toggle="tab">
                        <i class="fa fa-share-square-o"></i> Share Profile
                        </a>
                     </li>
                     <div id="share-buttons" title="Share Profile">
                        <?php /*<a href="http://www.facebook.com/sharer.php?u=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
                        <i class="fa fa-facebook"></i>
                        </a> */ ?>
                        <?php $shareurl = '';
                           $shareurl = site_url()."/viewdetails/profile/".encoding(get_current_user_id());
                           
                           ?>
                        <a href="javascript:void(0)" onclick="submitAndShare('<?php echo $imgs; ?>','<?php echo $usernamefb; ?>','<?php echo $shareurl; ?>')" target="_blank">  
                        <i class="fa fa-facebook"></i>
                        </a>
                        <a href="https://plus.google.com/share?url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
                        <i class="fa fa-google-plus"></i>
                        </a>
                        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
                        <i class="fa fa-linkedin"></i>
                        </a>
                     </div>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
   <input type="hidden" id="base_url" value="<?php echo base_url() ?>">
</section>
<section class="chery1">
   <!-- The Modal -->
   <div class="modal fade" id="qr_code_modal">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">QR Code</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body qr_modal" id="printThis">
            </div>
         </div>
      </div>
   </div>
   <div class="container">
      <div class="row pl_inlft">
         <!--col-3-div start-->
         <div class="col-md-3 col-sm-6 col-12">
            <div class="chery11 profile-img newfixedsizeX">
               <img src="<?php echo (!empty($user_data->profile))? $user_data->profile:DEFAULT_IMAGE; ?>" alt="profile image">
               <a class="update-profileimg" onclick="uploadModal();">
               <i class="fa fa-camera" aria-hidden="true"></i>
               &nbsp;Upload Profile Picture
               </a>
            </div>
            <!--================mobile_social_icons=================-->
            <!--================mobile_social_icons=================-->
            <div id="share-buttons" class="mobile_opens" title="Share Profile">
               <a href="javascript:void(0)" onclick="submitAndShare('<?php echo $imgs; ?>','<?php echo $usernamefb; ?>','<?php echo $shareurl; ?>')" target="_blank">  
               <i class="fa fa-facebook"></i>
               </a>
               <a href="https://plus.google.com/share?url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
               <i class="fa fa-google-plus"></i>
               </a>
               <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
               <i class="fa fa-linkedin"></i>
               </a>
            </div>
            <!--================mobile_social_icons=================-->
            <!--================mobile_social_icons=================-->
            <div id="uploadModal" class="modal fade" role="dialog">
            </div>
         </div>
         <!--col-3-div close-->
         <!--col-8-div start-->
         <div class="col-md-8 col-sm-6 col-12">
            <!--chery 2 strat-->
            <div class="Chery2">
               <?php 
                  $userData = $this->session->userdata();
                  
                  $uemail = $userData['userData']['email'];
                  
                  $uname = $userData['userData']['firstname']." ".$userData['userData']['lastname'];
                  
                  ?>
               <input type="hidden" id="uname" value="<?php echo ucwords($uname);?>">
               <input type="hidden" id="uemail" value="<?php echo $uemail;?>">
               <h2><?php if(!empty($user_data->firstname)) { echo $user_data->firstname; } ?> <?php if(!empty($user_data->lastname)) { echo $user_data->lastname; } ?></h2>
               <p>
                  <?php if(!empty($user_data->city)) { echo trim($user_data->city).', '; } ?>
                  <?php if(!empty($user_data->state)) { echo trim($user_data->state).', '; } ?>
                  <?php if(!empty($user_data->country)) { echo trim($user_data->country).', '; } ?>
                  <?php if(!empty($user_data->zip)) { echo trim($user_data->zip); } ?>
               </p>
               <p>
                  <a href="<?php echo site_url('user/history') ?>">
                  <span class="quyntity"><?php echo $starRating;?></span>
                  </a>
               </p>
               <li class="his_img extr nav-item mbdshow7">
                  <a class="nav-link" data-toggle="tab" href="#menu7">
                     <div class="his_img">
                        <i class="fa fa-calendar"></i>
                     </div>
                     Member Since <?php
                        if(!empty($user_data->reg_date)) { 
                        
                        	$date = date("Y-m-d",strtotime($user_data->reg_date));
                        
                        	$convert_date = strtotime($date);
                        
                        	$month = date('F',$convert_date);
                        
                        	$year = date('Y',$convert_date);
                        
                        	echo $month.", ".$year; } ?>
                  </a>
               </li>
               <?php if($user_data->display_phone == 1){ ?>
               <div class="callno col_chn">
                  <i class="fa fa-phone"></i>
                  <a href="tel:(707)500-8711" class="OnClrX"><?php echo $user_data->phone; ?></a> 
               </div>
               <?php } ?>
               <?php if($user_data->display_website == 1){
                  $urls = '';
                  
                  $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                  
                  $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                  
                  $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                  
                  $regex .= "(\:[0-9]{2,5})?"; // Port 
                  
                  $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                  
                  $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                  
                  $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                  
                  
                  
                  if(preg_match("/^$regex$/i", $user_data->website_link)) 
                  
                  {         
                  
                  if(strpos($user_data->website_link, 'http://') !== 0) {
                  
                  $urls =  'http://' . $user_data->website_link;
                  
                  } else {
                  
                  $urls = $user_data->website_link;
                  
                  }
                  
                  } ?>
               <!-- <p>
                  Website URL : <?php echo $user_data->website_link; ?>
                  
                  </p> -->
               <div class="callno col_chn">
                  <i class="fa fa-link"></i>
                  <a href="<?php echo $urls; ?>" target="_blank" class="OnClrX"> <?php echo $user_data->website_link; ?> </a>
               </div>
               <?php } ?>
               <div class="callno col_chn">
                  <i class="fa fa-envelope"></i>
                  <a href="mailto:<?php echo $user_data->email; ?>" class="OnClrX"><?php echo $user_data->email; ?> </a>
               </div>
               <div class="current">
                  <p class="fl_lft">Current Position  - </p>
                  <span class="Paul">
                  <strong>
                  <?php if(!empty($user_data->current_position)) { echo ucwords($user_data->current_position); } ?>
                  </strong> 
                  <strong> <?php if(!empty($workingAt->business_name)) { 
                     $companyProfileURL = site_url('viewdetails/profile/'.encoding($workingAt->id));
                     
                     echo '<b class="at"> At </b><a href="'.$companyProfileURL.'"> '.ucwords($workingAt->business_name).'</a>'; } ?>
                  </strong>
                  </span>
               </div>
            </div>
            <!--chery 2 close-->
         </div>
         <!--col-8-div close-->
      </div>
   </div>
</section>
<!--profil close-->
<div class="only_mobileSo">
   <div class="mypbusinessopen">
      <span></span>
      <span></span>
      <span></span>
   </div>
   <div class="proileLeftopens">
      <ul class="nav nav-tabs">
         <!-- <li class="his_img extr nav-item">
            <a class="nav-link" data-toggle="tab" href="#promot1">
            
            <div class="his_img">
            
            <img src="<?php //echo base_url();?>assets/images/h11.png"> 
            
            </div>
            
            Promote Your Page
            
            </a>
            
            </li> -->
         <li class="his_img extr nav-item"  onclick="getPosT('community');">
            <a class="nav-link  <?php if($this->session->userdata('friends_redirect') || $this->session->userdata('my_tasks')){}else{echo 'active';} ?> " data-toggle="tab" href="#menu1">
               <div class="his_img">
                  <img src="<?php echo base_url();?>assets/images/h8.png">
               </div>
               My Profile
            </a>
         </li>
         <li class="his_img extr nav-item" data-link="home">
            <a class="nav-link " data-toggle="tab" href="#home">
               <div class="his_img">
                  <i class="fa fa-users"></i>
               </div>
               My Settings
            </a>
         </li>
         <li class="his_img extr nav-item" data-link="friends">
            <a class="nav-link <?php if($this->session->userdata('friends_redirect')){echo 'active';}else{} ?>" data-toggle="tab" href="#menu3">
               <div class="his_img">
                  <img src="<?php echo base_url();?>assets/images/h10.png">
               </div>
               Friends 
               <span class="2_green"><?php  if(!empty($allFriends)){ echo count($allFriends); }else{ echo 0;} ?></span>
            </a>
         </li>
         <li class="his_img extr nav-item" data-link="community">
            <a class="nav-link" data-toggle="tab" href="#menu11" onclick="getPosT('highlights');">
               <div class="his_img">
                  <img src="<?php echo base_url();?>assets/images/h8.png">
               </div>
               My Community
            </a>
         </li>
         <li class="his_img extr nav-item">
            <a class="nav-link" href="<?php echo site_url('user/message') ?>">
               <div class="his_img">
                  <img src="<?php echo base_url();?>assets/images/h6.png">
               </div>
               Messages
            </a>
         </li>
         <li class="his_img extr nav-item">
           <a class="nav-link <?php if($this->session->userdata('my_tasks')){echo 'active';}else{} ?>" data-toggle="tab" href="#mytask">
                <div class="his_img">
                 <i class="fa fa-check-square" aria-hidden="true"></i>
                </div>
                My Tasks
            </a>
        </li>
         <li class="his_img extr nav-item" data-link="album">
            <a class="nav-link" data-toggle="tab" href="#menu4">
               <div class="his_img">
                  <img src="<?php echo base_url();?>assets/images/h3.png">
               </div>
               Albums / Documents
            </a>
         </li>
         <li class="his_img extr nav-item" data-link="rank">
            <a class="nav-link" data-toggle="tab" href="#menuR1">
               <div class="his_img">
                  <i class="fa fa-star"></i>
               </div>
               Rank
            </a>
         </li>
         <li class="his_img extr nav-item" data-link="rating">
            <a class="nav-link" data-toggle="tab" href="#menu2">
               <div class="his_img">
                  <i class="fa fa-history"></i>
               </div>
               Rating History
            </a>
         </li>
         <li class="his_img extr nav-item mbdNone7">
            <a class="nav-link" data-toggle="tab" href="#menu7">
               <div class="his_img">
                  <img src="<?php echo base_url();?>assets/images/h7.png">
               </div>
               Member Since <?php
                  if(!empty($user_data->reg_date)) { 
                  
                  	$date = date("Y-m-d",strtotime($user_data->reg_date));
                  
                  	$convert_date = strtotime($date);
                  
                  	$month = date('F',$convert_date);
                  
                  	$year = date('Y',$convert_date);
                  
                  	echo $month.", ".$year; } ?>
            </a>
         </li>
         <li class="his_img extr nav-item">
            <a class="nav-link"  href="<?php echo site_url(); ?>logout">
               <div class="his_img">
                  <img src="<?php echo base_url();?>assets/images/h9.png">
               </div>
               Logout
            </a>
         </li>
      </ul>
   </div>
</div>
<section class="history" id="MclickInsX">
   <div class="container">
   <div class="row">
   <!--tab list start-->
   <div class="col-md-3 col-12 pl_inlft sidebar-expanded" id="sidebar-container">
      <div class="sticky-top sticky-offset">
         <div class="icon_fclick Xmobilenone">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
         </div>
         <div class="history_cont Xmobilenone">
            <ul class="nav nav-tabs">
               <!-- <li class="his_img extr nav-item">
                  <a class="nav-link" data-toggle="tab" href="#promot1">
                  
                  <div class="his_img">
                  
                  <img src="<?php echo base_url();?>assets/images/h11.png"> 
                  
                  </div>
                  
                  Promote Your Page
                  
                  </a>
                  
                  </li> -->
               <li class="his_img extr nav-item"  onclick="getPosT('community');">
                  <a class="nav-link  <?php if($this->session->userdata('friends_redirect')||$this->session->userdata('my_tasks')){}else{echo 'active';} ?> " data-toggle="tab" href="#menu1">
                     <div class="his_img">
                        <img src="<?php echo base_url();?>assets/images/h8.png">
                     </div>
                     My Profile
                  </a>
               </li>
               <li class="his_img extr nav-item" data-link="home">
                  <a class="nav-link " data-toggle="tab" href="#home">
                     <div class="his_img">
                        <i class="fa fa-users"></i>
                     </div>
                     My Settings
                  </a>
               </li>
               <li class="his_img extr nav-item" data-link="friends">
                  <a class="nav-link <?php if($this->session->userdata('friends_redirect')){echo 'active';}else{} ?>" data-toggle="tab" href="#menu3">
                     <div class="his_img">
                        <img src="<?php echo base_url();?>assets/images/h10.png">
                     </div>
                     Friends 
                     <span class="2_green"><?php  if(!empty($allFriends)){ echo count($allFriends); }else{ echo 0;} ?></span>
                  </a>
               </li>
               <li class="his_img extr nav-item" data-link="community">
                  <a class="nav-link" data-toggle="tab" href="#menu11" onclick="getPosT('highlights');">
                     <div class="his_img">
                        <img src="<?php echo base_url();?>assets/images/h8.png">
                     </div>
                     My Community
                  </a>
               </li>
               <li class="his_img extr nav-item">
                  <a class="nav-link" href="<?php echo site_url('user/message') ?>">
                     <div class="his_img">
                        <img src="<?php echo base_url();?>assets/images/h6.png">
                     </div>
                     Messages
                  </a>
               </li>
               <li class="his_img extr nav-item">
                  <a class="nav-link <?php if($this->session->userdata('my_tasks')){echo 'active';}else{} ?>" data-toggle="tab" href="#mytask">
                     <div class="his_img">
                        <i class="fa fa-check-square" aria-hidden="true"></i>
                     </div>
                     My Tasks
                  </a>
               </li>
               <li class="his_img extr nav-item" data-link="album">
                  <a class="nav-link" data-toggle="tab" href="#menu4">
                     <div class="his_img">
                        <img src="<?php echo base_url();?>assets/images/h3.png">
                     </div>
                     Albums / Documents
                  </a>
               </li>
               <li class="his_img extr nav-item" data-link="rank">
                  <a class="nav-link" data-toggle="tab" href="#menuR1">
                     <div class="his_img">
                        <i class="fa fa-star"></i>
                     </div>
                     Rank
                  </a>
               </li>
               <li class="his_img extr nav-item" data-link="rating">
                  <a class="nav-link" data-toggle="tab" href="#menu2">
                     <div class="his_img">
                        <i class="fa fa-history"></i>
                     </div>
                     Rating History
                  </a>
               </li>
               <li class="his_img extr nav-item mbdNone7">
                  <a class="nav-link" data-toggle="tab" href="#menu7">
                     <div class="his_img">
                        <img src="<?php echo base_url();?>assets/images/h7.png">
                     </div>
                     Member Since <?php
                        if(!empty($user_data->reg_date)) { 
                        
                        	$date = date("Y-m-d",strtotime($user_data->reg_date));
                        
                        	$convert_date = strtotime($date);
                        
                        	$month = date('F',$convert_date);
                        
                        	$year = date('Y',$convert_date);
                        
                        	echo $month.", ".$year; } ?>
                  </a>
               </li>
               <!-- <li class="his_img extr nav-item">
                  <a class="nav-link" data-toggle="tab" href="#payment">
                  
                  <div class="his_img">
                  
                  <i class="fa fa-cc-stripe" aria-hidden="true"></i>
                  
                  </div>&nbsp;
                  
                  Payment History
                  
                  </a>
                  
                  </li> -->
               <!--   <li class="his_img extr nav-item">
                  <a class="nav-link" data-toggle="tab" href="#menu7">
                  
                  <div class="his_img">
                  
                  <img src="<?php echo base_url();?>assets/images/h7.png">
                  
                  </div>
                  
                  Report Profile
                  
                  </a>
                  
                  </li> -->
               <li class="his_img extr nav-item">
                  <a class="nav-link"  href="<?php echo site_url(); ?>logout">
                     <div class="his_img">
                        <img src="<?php echo base_url();?>assets/images/h9.png">
                     </div>
                     Logout
                  </a>
               </li>
            </ul>
         </div>
      </div>
   </div>
   <!--==tab list close=====-->
   <!--tab main contant start-->
   <div class="col-md-9 col-12">
   <div class="tab-content">
      <!--====================promote your pages first tab link start=====================--> 
      <div class="tab-pane container" id="promot1">
         <div class="row">
            <div class="col-md-6 col-12">
               <div class="main_with over xdg">
                  <div class="Chose_your ">
                     <div class="poromote_fx">
                        <ul>
                           <input type="hidden" id="promote_type">
                           <li class="promot_choos special_bord">
                              <div class="pro_choos">
                                 <h1>Pre selected promotions</h1>
                                 <!-- <p> Lorem ipsum dolor sit amet, eu vis antiopam
                                    mediocrem.</p> -->
                              </div>
                           </li>
                           <div class="threeShows">
                              <li class="promot_choos agin">
                                 <div class="promotsa">
                                    <div class="form-group">
                                       <label class="promot_one">
                                       <input type="radio" checked="checked"  name="radio" class="promot_ones" onclick="selectPromoteType('option');" value="20">
                                       <span class="checkmark_opne on_onenot"></span>
                                       </label>
                                    </div>
                                 </div>
                                 <div class="autem blandit">
                                    <h3>Front page exposure (top 6)  </h3>
                                    <p>27 days</p>
                                 </div>
                                 <div class="rat"> $20 </div>
                              </li>
                              <li class="promot_choos agin">
                                 <div class="promotsa">
                                    <div class="form-group">
                                       <label class="promot_one">
                                       <input type="radio" checked="un-chacked" name="radio" class="promot_ones" onclick="selectPromoteType('option');" value="10">
                                       <span class="checkmark_opne on_onenot"></span>
                                       </label>
                                    </div>
                                 </div>
                                 <div class="autem blandit">
                                    <h3>Front page exposure (top 6) </h3>
                                    <p>15 days</p>
                                 </div>
                                 <div class="rat"> $10 </div>
                              </li>
                              <li class="promot_choos agin">
                                 <div class="promotsa">
                                    <div class="form-group">
                                       <label class="promot_one">
                                       <input type="radio" checked="un-chacked" name="radio" class="promot_ones"  onclick="selectPromoteType('option');" value="5">
                                       <span class="checkmark_opne on_onenot"></span>
                                       </label>
                                    </div>
                                 </div>
                                 <div class="autem blandit">
                                    <h3>Front page exposure (top 6)  </h3>
                                    <p>7 days</p>
                                 </div>
                                 <div class="rat"> $5 </div>
                              </li>
                           </div>
                           <h4 class="click_Dts7"> choose custom date <i class="fa fa-angle-down" aria-hidden="true"></i></h4>
                           <div class="click_Dts7Shows">
                              <li class="promot_choos">
                                 <input type="hidden" id="public_live_key" value="<?php echo PUBLIC_LIVE_KEY;?>"> 
                                 <div class="form-group">
                                    <label class="lanll"></label>
                                    <!-- <input type="text" name="dollar" id="dollar" class="form-control" placeholder="5" required=""  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"> -->
                                    <span class="prdy">$1 per day</span> 
                                    <br/>
                                    <input type="text" class="form-control" name="start_date" id="start_date" placeholder="Start Date" readonly="" onclick="selectPromoteType('date');">
                                    <input type="text" class="form-control" name="end_date" id="end_date" placeholder="End Date" readonly="" onclick="selectPromoteType('date');">
                                    <div id="error_date"></div>
                                 </div>
                              </li>
                           </div>
                           <li class="promot_choos">
                              <button type="start" class="start_btn" onclick="checkDateDiff();">
                              Start Promotion
                              </button>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div id="stripe" class="modal fade">
                     <div class="modal-dialog modal-confirm">
                        <div class="modal-content">
                           <div id="success"></div>
                           <div class="modal-header">
                              <h4 class="modal-title">Stripe Payment</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                           </div>
                           <form action="<?php echo site_url('payment');?>" method="POST" id="payment-form">
                              <div class="modal-body">
                                 <div id="total_amount"></div>
                                 <span class="payment-errors"></span>
                                 <div class="form-row">
                                    <label>
                                    <span>Card Number</span>
                                    <input type="text" size="20" data-stripe="number">
                                    </label>
                                 </div>
                                 <div class="form-row">
                                    <label>
                                    <span>Expiration (YY/MM)</span>
                                    <input type="text" size="2" data-stripe="exp_month">
                                    </label>
                                    <span> / </span>
                                    <input type="text" size="2" data-stripe="exp_year">
                                 </div>
                                 <div class="form-row">
                                    <label>
                                    <span>CVC</span>
                                    <input type="text" size="4" data-stripe="cvc">
                                    </label>
                                 </div>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                 <button type="submit" class="btn btn-danger">Pay</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <p>By clicking promote you agree to <a href="https://stripe.com/docs/payment-request-api">Terms of use</a></p>
               <p><a href="https://support.stripe.com/">FAQ's here</a></p>
            </div>
            <div class="col-md-6 col-12">
               <div class="Chose_your chnaf">
                  <ul>
                     <li class="promot_choos bormse ">
                        <div class="pro_choos">
                           <h1>Read Guidelines here</h1>
                           <b>Get noticed</b>
                        </div>
                     </li>
                     <li>
                        <div class="card-body">
                           Invite 10 of your friends to create profiles on Workadvisor.co, to receive one month feature on homepage.
                           <div class="row">
                              <div class="serch-fn-up">
                                 <!-- <div class="fb-tz bordr" data-toggle="modal" data-target="#fbmodalsecond">
                                    <p><i class="fa fa-facebook-square"></i>On Facebook</p>
                                    
                                    </div> -->
                                 <div class="ml-tz e-ml bordr" data-toggle="modal" data-target="#emailmodalsecond">
                                    <p><i class="fa fa-envelope"></i>In Your Email Contacts</p>
                                 </div>
                                 <div class="invt-tz in-te bordr">
                                    <a href="<?php echo base_url()?>user/invite_gmail_contacts">
                                       <p><i class="fa fa-user-plus"></i> Invite Friends to WorkAdvisor</p>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </li>
                  </ul>
               </div>
               <!-- first Modal close -->
               <div class="thre-popup">
                  <div class="modal fade" id="fbmodalsecond">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                           </div>
                           <h4 class="modal-title">adding your Facebook friends to WorkAdvisor. </h4>
                           <!-- Modal body strat-->
                           <!-- Modal body -->
                           <div class="modal-body">
                              <div class="only-bkvlr">
                                 <p class="emil-cntnt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua.
                                 </p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- third Modal start -->
                  <div class="modal fade" id="emailmodalsecond">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <!-- Modal Header -->
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                           </div>
                           <h4 class="modal-title">Send Invites</h4>
                           <div class="modal-body">
                              <div class="only-bkvlr">
                                 <div class="row">
                                    <div class="col-md-3 col-sm-3 col-12">
                                       <div class="imgs-emil mail-img-click">
                                          <a href="https://accounts.google.com/o/oauth2/auth?client_id=252607257150-kr5at3658jl7mtoef6boer0ign6ue3fk.apps.googleusercontent.com&redirect_uri=https://workadvisor.co/user/google&scope=https://www.google.com/m8/feeds/&response_type=code">
                                          <img src="<?php echo base_url();?>assets/images/b3c993e.png">
                                          </a>
                                       </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-12">
                                       <div class="imgs-emil mail-img-click">
                                          <a href="<?php echo isset($yahooURL)?$yahooURL:'';?>" ><img src="<?php echo base_url();?>assets/images/yahoo.png"></a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- Modal body close-->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!--======================payment_page========================-->
         <!--======================payment_page========================-->
         <button class="p_clickments">Payment History</button>
         <div class="team_Spaymetns">
            <div class="row">
               <div class="col-md-12 pdR01">
                  <!-- <h3>Payment History</h3> -->
                  <div class="main_with coutm-wit">
                     <table id="team_salary" class="table table-striped table-bordered table-responsive">
                        <thead>
                           <tr>
                              <th>S.No</th>
                              <th>Amount(in USD)</th>
                              <th>Payment Type</th>
                              <th>Start Date</th>
                              <th>End Date</th>
                              <th>Number Of Days</th>
                              <th>Payment Status</th>
                              <th>Payment Date</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                              if(!empty($paymentData)){
                              
                              
                              
                              	$count = 0;
                              
                              	foreach($paymentData as $row){
                              
                              		$count++;?>
                           <tr>
                              <td>
                                 <?php echo $count;?>
                              </td>
                              <td>
                                 <?php echo $row['amount'];?>
                              </td>
                              <td>
                                 <?php echo $row['payment_type'];?>
                              </td>
                              <td>
                                 <?php 
                                    if(isset($row['start_date']))
                                    
                                    	echo date('d-m-Y',strtotime($row['start_date']));
                                    
                                    ?>
                              </td>
                              <td>
                                 <?php 
                                    if(isset($row['end_date']))
                                    
                                    	echo date('d-m-Y',strtotime($row['end_date']));
                                    
                                    ?>
                              </td>
                              <td>
                                 <?php echo $row['no_of_days'];?>
                              </td>
                              <td>
                                 <?php echo $row['status'];?>
                              </td>
                              <td>
                                 <?php echo date("d-m-y H:i:s",strtotime($row['created_date']));?>
                              </td>
                           </tr>
                           <?php }
                              }
                              
                              ?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="col-md-2">
               </div>
            </div>
         </div>
         <!--======================payment_page========================-->
         <!--======================payment_page========================-->
      </div>
      <!--====================promot your page first tab link end=====================--> 
      <div class="tab-pane container" id="home">
      </div>
      <!--profile edit pages tab link close====================================
         ==============================================================--> 
      <!--====================overview page first tab link start=====================--> 
      <div class="tab-pane container <?php if($this->session->userdata('friends_redirect')||$this->session->userdata('my_tasks')){}else{echo 'active';} ?>" id="menu1">
         <?php if($this->session->flashdata('success')){ echo $this->session->flashdata('success'); } ?>
         <?php 
            if($this->session->flashdata('updatemsg')){ ?>
         <?php echo $this->session->flashdata('updatemsg');?>
         <?php }
            ?>
         <div class="row">
            <div class="col-md-8 full_fillBx">
               <div class="main_with over">
                  <?php if($this->session->flashdata('success_payment')){ echo $this->session->flashdata('success_payment'); } ?>
                  <div id="errorDivId"></div>
                  <h1>Share your thoughts here</h1>
                  <div class="share_your">
                     <form action="javascript:void(0)" method="post" enctype="multipart/form-data">
                        <div class="form-group pdno">
                           <textarea name="post_content" placeholder="Share your thoughts here." class="form-control" 
                              id="post_contentNew" data-toggle="modal" data-target="#myModal"></textarea>
                        </div>
                        <div class="post_bx">
                           <div class="form-group">
                              <input class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" value="Post" type="button">
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="userposts" >
                     <div id="responseDiv"></div>
                     <?php if(!empty($posts_details['result'])){ $md = 0; foreach($posts_details['result'] as $post){ $md++; 
                        $imgsert = '';?> 
                     <input type="hidden" name="table_name" id="table_name" value="<?php echo POSTS;?>">
                     <div class="main_blog post-id" id="<?php echo $post->id; ?>" data-uid="<?php echo get_current_user_id(); ?>">
                        <?php if($post->post_image!=""){
                           $imgsert=$post->post_image;
                           
                           $postimgarr=explode(',',$imgsert);
                           
                           if(count($postimgarr)>1){ ?>
                        <div class = "row pdbothS">
                           <?php foreach($postimgarr as $postim){ ?>
                           <div class = "col-sm-3 col-md-3 thumb_upx2">
                              <div class="fansy-gallry">  
                                 <a class="thumbnail" data-fancybox="gallery1<?php echo $md; ?>" href="<?php echo $postim; ?>">
                                 <img src="<?php echo $postim; ?>">
                                 </a>
                              </div>
                           </div>
                           <?php } ?>
                        </div>
                        <div class="col-tz">
                           <div id="myModal00<?php echo $md; ?>" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="row">
                                          <?php foreach($postimgarr as $postim){
                                             ?>
                                          <div class="col-md-3">
                                             <div class="fansy-gallry">  
                                                <a class="fancybox" data-fancybox="gallery1<?php echo $md; ?>" href="<?php echo $postim; ?>">
                                                <img src="<?php echo $postim; ?>">
                                                </a>
                                             </div>
                                          </div>
                                          <?php  }  ?>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php }else{ ?>
                        <div class = "over_viewimg">
                           <a class="img-fluid" data-fancybox="gallery111<?php echo $md; ?>" href="<?php echo $imgsert; ?>">
                           <img src="<?php echo $imgsert; ?>">
                           </a>
                        </div>
                        <div class="col-tz">
                           <div id="myModal002<?php echo $md; ?>" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="row">
                                          <?php foreach($postimgarr as $postim){
                                             ?>
                                          <div class="col-md-3">
                                             <div class="fansy-gallry">  
                                                <a class="fancybox" data-fancybox="gallery111<?php echo $md; ?>" href="<?php echo $postim; ?>">
                                                <img src="<?php echo $postim; ?>">
                                                </a>
                                             </div>
                                          </div>
                                          <?php  }  ?>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php  } } ?>
                        <?php if($post->post_video!=''){ ?>
                        <div class="row">
                           <div>
                              <video width="320" height="240"  controls class="videos">
                                 <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type='video/mp4; codecs="avc1.4D401E, mp4a.40.2, vp8, vorbis"'>
                                 <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/webm">
                                 <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/ogg">
                                 <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/mts">
                              </video>
                           </div>
                        </div>
                        <?php } ?>
                        <div class="contant_overviw esdu" onclick="setID(<?php echo $post->id;?>);">
                           <h1 class="datess"><?php echo date('d-m-Y H:i A',strtotime($post->post_date)); ?></h1>
                           <div class="btnns">
                              <a href="#" class="linke" data-toggle="modal" data-target="#sharePostModal<?php echo $md; ?>"><img src="<?php echo base_url();?>assets/images/share.png">
                              <i class="fa fa-thumbs-up"></i>
                              </a>
                              <a href="" class="editss" data-toggle="modal" data-target="#myModal2" onclick="editPost(<?php echo $post->id;?>)">
                              <img src="<?php echo base_url();?>assets/images/edit.png">
                              </a>
                              <a href="" class="editss" data-toggle="modal" data-target="#modalDelete">
                              <i class="fa fa fa-trash-o"></i>
                              </a>
                              <div class="modal fade" id="sharePostModal<?php echo $md; ?>">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h4 class="modal-title">Boost Visibility</h4>
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <?php  $currentURL = current_url(); 
                                             $params = $_SERVER['QUERY_STRING']; 
                                             
                                             $fullURL = $currentURL . '?' . $params;
                                             
                                             ?>
                                       </div>
                                       <div class="modal-body">
                                          <div id="share-buttons" title="Share Profile">
                                             <a href="https://twitter.com/share?url=<?php echo $fullURL;?>" target="_blank">
                                             <i class="fa fa-twitter"></i>
                                             </a>
                                             <?php if($imgsert == '') {
                                                $imgsert = '';
                                                
                                                } else {
                                                
                                                $imgsert = $imgsert;
                                                
                                                } 
                                                
                                                
                                                
                                                if($post->post_video!=''){ 
                                                
                                                $video = "'".base_url()."uploads/videos/".$post->post_video."'";
                                                
                                                if($user_data->user_role == 'Employer'){
                                                
                                                	$name = ucwords($user_data->business_name);
                                                
                                                }else{
                                                
                                                	$name = ucwords($user_data->firstname)." ".ucwords($user_data->lastname);
                                                
                                                }
                                                
                                                $urlP = base_url().'viewdetails/profile/'.encoding(get_current_user_id());
                                                
                                                ?>
                                             <a href="javascript:void(0)" class="PIXLRIT1" onclick="publish(<?php echo $video ?>,'<?php echo $name. ' status'; ?>','<?php echo $urlP;?>');">
                                             <i class="fa fa-facebook"></i>
                                             </a>
                                             <?php } 
                                                else if($imgsert!=''){ 
                                                
                                                	$imgsert1 = explode(',',$imgsert);
                                                
                                                	$imgsert2 = $imgsert1[0];
                                                
                                                	if($user_data->user_role == 'Employer'){
                                                
                                                		$name = ucwords($user_data->business_name);
                                                
                                                	}else{
                                                
                                                		$name = ucwords($user_data->firstname)." ".ucwords($user_data->lastname);
                                                
                                                	}
                                                
                                                	$urlP = base_url().'viewdetails/profile/'.encoding(get_current_user_id());
                                                
                                                	?>
                                             <a href="javascript:void(0)" class="PIXLRIT1" onclick="submitAndShare('<?php echo $imgsert2; ?>','<?php echo $name. ' status'; ?>','<?php echo $urlP;?>')" target="_blank">
                                             <i class="fa fa-facebook"></i>
                                             </a>
                                             <?php } ?>
                                             <a href="https://plus.google.com/share?url=<?php echo $fullURL;?>" target="_blank">
                                             <i class="fa fa-google-plus"></i>
                                             </a>
                                             <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $fullURL;?>" target="_blank">
                                             <i class="fa fa-linkedin"></i>
                                             </a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="contant_overviw">
                           <p><?php
                              $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                              
                              $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                              
                              $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                              
                              $regex .= "(\:[0-9]{2,5})?"; // Port 
                              
                              $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                              
                              $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                              
                              $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                              
                              
                              
                              if(preg_match("/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i", $post->post_content)) 
                              
                              { 
                              
                              	$urls = '';
                              
                              	echo '<a href="'.$post->post_content.'" target="_blank">'.$post->post_content.'</a>'; 
                              
                              }else{
                              
                              	echo $post->post_content;
                              
                              }
                              
                              ?>    
                           </p>
                        </div>
                        <div class="commentSection">
                           <div id="all_comments<?php echo $post->id;?>">
                              <?php $oldComments = getComments($post->id);
                                 if(!empty($oldComments)){
                                 
                                 	foreach($oldComments as $comment){
                                 
                                 		$html = '';
                                 
                                 		$html.= '<div class="wa_app_comm">';
                                 
                                 		if(!empty($comment->profile)){
                                 
                                 			$html.='<img src="'.$comment->profile.'">';
                                 
                                 		}else{
                                 
                                 			$html.='<img src="'.DEFAULT_IMAGE.'">';
                                 
                                 		}
                                 
                                 		$html.='<h4>'.$comment->firstname.' '.$comment->lastname.'</h4>';
                                 
                                       $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
                                       $text = $comment->comments;
                                       if(preg_match($reg_exUrl, $text, $url)) {
                                          $comments = preg_replace($reg_exUrl, "<a href='".$url[0]."' target='_blank'>{$url[0]}</a>", $text);
                                       } else {
                                          $comments = $text;
                                       }

                                       $html.='<p>'.$comments.'</p>';
                                 
                                 		if(get_current_user_id() == $comment->user_id){
                                 
                                 			$html.='<i class="fa fa fa-trash-o" data-comment_id="'.$comment->id.'" data-toggle="modal" data-target="#modalDeleteComment"></i>';
                                 
                                 		}
                                 
                                 		$html.='</div>';
                                 
                                 		echo $html;
                                 
                                 	}
                                 
                                 }
                                 
                                 ?>
                           </div>
                           <?php if(get_current_user_id()){ ?>
                           <form method="post" class="commentForm">
                              <textarea type="text" class="comment form-control" name="comment" placeholder="Enter your comment" data-comment="<?php echo $post->id;?>"></textarea>
                              <input type="submit" name="post" value="POST" class="post_comment">
                           </form>
                           <?php } ?>
                        </div>
                     </div>
                     <?php  } } ?>
                  </div>
                  <div id="lastresponse"></div>
                  <button class="scrol_loding">
                  <img src="<?php echo base_url();?>assets/images/giphy.gif">
                  </button>
               </div>
            </div>
            <div class="col-md-4 col-12 sidebar-expanded" id="sidebar-container">
               <div class="sticky-top sticky-offset">
                  <?php if(isset($user_data->user_role) && $user_data->user_role == 'Performer') { 
                     $record_num = encoding(get_current_user_id());
                     
                     ?>
                  <div class="progrs">
                     <h1>Performance</h1>
                     <?php if(isset($percentarray[5])) {?>
                     <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/5">
                     <?php }else{ ?>
                     <a href="#">
                        <?php }?>
                        <div class="bar-one">
                           <span class="quntit"><?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?></span>
                           <div data-percent="<?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?>" style="width:<?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?>"></div>
                           <span class="star_rigth">5&nbsp;&nbsp;stars</span>
                        </div>
                     </a>
                     <?php if(isset($percentarray[4])) {?>
                     <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/4">
                     <?php }else{ ?>
                     <a href="#">
                        <?php }?>
                        <div class="bar-one">
                           <span class="quntit"><?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?></span>
                           <div style="width:<?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?>"></div>
                           <span class="star_rigth">4&nbsp;&nbsp;stars</span>
                        </div>
                     </a>
                     <?php if(isset($percentarray[3])) {?>
                     <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/3">
                     <?php }else{ ?>
                     <a href="#">
                        <?php }?>
                        <div class="bar-one">
                           <span class="quntit"><?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?></span>
                           <div style="width:<?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?>"></div>
                           <span class="star_rigth">3&nbsp;&nbsp;stars</span>
                        </div>
                     </a>
                     <?php if(isset($percentarray[2])) {?>
                     <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/2">
                     <?php }else{ ?>
                     <a href="#">
                        <?php }?>
                        <div class="bar-one">
                           <span class="quntit"><?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?></span>
                           <div style="width:<?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?>"></div>
                           <span class="star_rigth">2&nbsp;&nbsp;stars</span>
                        </div>
                     </a>
                     <?php if(isset($percentarray[1])) {?>
                     <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/1">
                     <?php }else{ ?>
                     <a href="#">
                        <?php }?>
                        <div class="bar-one">
                           <span class="quntit"><?php echo isset($percentarray[1])?number_format($percentarray[1],1).'%':'0%';?></span>
                           <div style="width:<?php echo isset($percentarray[1])?number_format($percentarray[1],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[1])?number_format($percentarray[1],1):'0%';?>"></div>
                           <span class="star_rigth">1&nbsp;&nbsp;stars</span>
                        </div>
                     </a>
                  </div>
                  <?php } ?>
                  <!--Qr-code start-->
                  <div class="Qr-code">
                     <p> QR Code</p>
                     <p>Scan My Code</p>
                     <a href="#" id="qrCodeImg">
                        <!-- <img src="<?php echo base_url();?>assets/images/code.png"> -->
                        <img class="qr_code1" src="<?php echo isset($qr_image)?$qr_image:'';?>">
                     </a>
                     <input type="button" class="btn btn-info" id="btnPrint" value="Click To Print"><span class="qrCodeQuestion"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                  </div>
                  <!-- workadv -->
                  <!-- work_advisor_profile1 
                     <ins class="adsbygoogle"
                     
                     style="display:block"
                     
                     data-ad-client="ca-pub-3979824042791728"
                     
                     data-ad-slot="2979875967"
                     
                     data-ad-format="auto"
                     
                     data-full-width-responsive="true"></ins>
                     
                     <script>
                     
                     (adsbygoogle = window.adsbygoogle || []).push({});
                     
                     </script>
                     
                     -->
               </div>
            </div>
            <!--progresh bar close-->
         </div>
      </div>
      <!--================overview page first tab link close===================--> 
      <!--====================highlights=====================--> 
      <div class="tab-pane container" id="menu11" >
      </div>
      <!--================overview page first tab link close===================--> 
      <!--====================history page first tab link =====================--> 
      <div class="tab-pane container" id="menu2">
      </div>
      <!--====================history page first tab link close =====================--> 
      <!--====================rank page six tab link  =====================--> 
      <div class="tab-pane container" id="menuR1">
      </div>
      <!--====================rank page six  tab link close =====================--> 
      <!--====================Friends page first tab link  =====================--> 
      <div class="tab-pane container <?php if($this->session->userdata('friends_redirect')){echo 'active';}else{} ?>" id="menu3">
      </div>
      <!--====================Friends page first tab link close =====================--> 
      <!-- <div class="tab-pane container" id="payment">
         </div> -->
      <!--Video-photo doc tab link --> 
      <div class="tab-pane container" id="menu4">
         <div class="row">
            <div class="col-md-9 col-12 full_fillBx">
               <h1>Albums  &nbsp;<span class="albums_profile"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h1>
               <div class="bx_shdImg">
                  <!--start row--> 
                  <div class="row albums">
                  </div>
                  <div class="bor_btm"></div>
                  <div class="row mar_tp">
                     <h2 class="Cher">Documents-Files  &nbsp;<span class="doc_file"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h2>
                     <div class="container">
                        <form id="fileupload" action="#" method="POST" enctype="multipart/form-data">
                           <div class="row files" id="files1">
                              <span class="btn btn-default btn-file">
                              Browse  <input type="file" name="files1[]" multiple accept=".pdf,.doc,.docs,.docx,.xlsx" />
                              </span>
                              <br />
                              <ul class="fileList"></ul>
                           </div>
                           <div class="row">
                              <button type="button" id="uploadBtn" class="btn primary start">Upload</button>
                           </div>
                        </form>
                     </div>
                     <div class="cover_FxPx">
                        <input type="text" placeholder = "Search here" onkeyup="getDocuments()" id="search_doc">
                        <select class="arrange">
                           <option value="asc">A-Z</option>
                           <option value="desc">Z-A</option>
                        </select>
                        <input type="hidden" id="user_id" value="<?php echo get_current_user_id();?>">
                        <input type="hidden" id="directoryId" value="">
                        <div onclick="addDirectory(this)" class="gr-lst-vie-add"><i class="fa fa-plus"></i></div>
                        <div tp="list" class="gr-lst-vie"><i class="fa fa-bars"></i></div>
                        <div tp="grid" class="gr-lst-vie"><i class="fa fa-th-large"></i></div>
                     </div>
                     <div id="fileSuccess" class="grid">
                        <div id="fileSuccessmain">
                           <?php 
                              $html='';
                              
                              /* html of directory */
                              
                              if(!empty($albumFolderData)) {
                              
                              	foreach($albumFolderData['result'] as $folderDatas) {
                              
                              		$checked11 = '';
                              
                              		$checked22 = '';
                              
                              		if($folderDatas->dir_view_type == 2){
                              
                              			$checked22 = 'checked=checked';
                              
                              		}else{
                              
                              			$checked11 = 'checked=checked';
                              
                              		}
                              
                              
                              
                              // javascript onclick error while "enterInFolder" 
                              
                              // change >a tag to >div 
                              
                              		$inverted = "&#39;";
                              
                              		$html.='
                              
                              		<div class="col-md-3 col-12 folders documents_drag  '.$folderDatas->id.'" onclick="setIdDir('.$folderDatas->id.')" id="'.$folderDatas->id.'" data-doc_type="folder">
                              
                              		<div class="album_icon">
                              
                              		<div onclick="enterInFolder('.$folderDatas->id.','.get_current_user_id().',&#39;&#39;,'.$inverted.$folderDatas->dir_name.$inverted.')">
                              
                              		<div class="jerry documents_drag_folder" data-fid="'.$folderDatas->id.'" data-doc_type="folder">
                              
                              		<div class="cat_img but_imgsize">
                              
                              		<img src="'.base_url().'/assets/images/folder_image.png">
                              
                              		</div><span class="Zdoc_content">'.$folderDatas->dir_name.'</span></div>
                              
                              		</div>
                              
                              
                              
                              
                              
                              		<input class="view_type" type="radio" value="1" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'"  data-vid="'.$folderDatas->id.'" '.$checked11.' data-views="folders">Public
                              
                              		<input class="view_type" type="radio" value="2" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked22.' data-vid="'.$folderDatas->id.'" data-views="folders">Private
                              
                              		</div>
                              
                              		</div>
                              
                              		';
                              
                              	}
                              
                              }
                              
                              
                              
                              /* html of directory end */
                              
                              if(!empty($albumData['result'])){
                              
                              	foreach($albumData['result'] as $row){
                              
                              		$checked1 = '';
                              
                              		$checked2 = '';
                              
                              		if($row->view_type == 2){
                              
                              			$checked2 = 'checked=checked';
                              
                              		}else{
                              
                              			$checked1 = 'checked=checked';
                              
                              		}
                              
                              		$file_ext = pathinfo($row->name,PATHINFO_EXTENSION);
                              
                              		if($file_ext == 'doc' || $file_ext == 'docs' || $file_ext == 'docx'){
                              
                              			$image = base_url().'assets/images/doc.png';
                              
                              		}
                              
                              		else if($file_ext == 'xlsx'){
                              
                              			$image = base_url().'assets/images/xlsx.png';
                              
                              		}else if($file_ext == 'pdf'){
                              
                              			$image = base_url().'assets/images/pdf.png';
                              
                              		}
                              
                              		$html.='
                              
                              		<div class="col-md-3 col-12  documents_drag file_'.$row->id.'" data-doc_type="file" id="'.$row->id.'" onclick="setID('.$row->id.');">
                              
                              		<div class="album_icon">
                              
                              		<a href="'.base_url().$row->albums.'" >
                              
                              		<div class="jerry documents_drag_file" data-fid="'.$row->id.'" data-doc_type="file">
                              
                              		<div class="cat_img but_imgsize">
                              
                              		<img src="'.$image.'">
                              
                              		</div><span class="Zdoc_content">'.$row->name.'</span></div>
                              
                              		</a>
                              
                              
                              
                              		<input class="view_type" type="radio" value="1" name="view_'.$row->id.'" id="view_'.$row->id.'"  data-vid="'.$row->id.'" '.$checked1.' data-views="files">Public
                              
                              		<input class="view_type" type="radio" value="2" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked2.' data-vid="'.$row->id.'" data-views="files">Private
                              
                              		</div>
                              
                              		</div>
                              
                              		';
                              
                              	}
                              
                              
                              
                              } 
                              
                              echo $html;?>
                        </div>
                        <div id="fileSuccessDir">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-3 col-12">
               <div class="Qr-code">
                  <p> QR Code</p>
                  <p>Scan My Code</p>
                  <a href="#" id="qrCodeImg">
                     <!--  <img src="<?php echo isset($qr_image)?$qr_image:'';?>"> -->
                     <img class="qr_code1" src="<?php echo isset($qr_image)?$qr_image:'';?>">
                  </a>
                  <input type="button" class="btn btn-info" id="btnPrint" value="Click To Print"><span class="qrCodeQuestion"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
               </div>
               <br/> <br/>
               <!-- profile_album -->
            </div>
         </div>
         <!--Video-photo doc tab link close--> 
      </div>
      <div class="tab-pane container <?php if($this->session->userdata('my_tasks')){echo 'active';}else{} ?>" id="mytask">
         <div class="row">
         	<div class="col-md-12">
            <h3>My Tasks</h3>
        </div>
         </div>
         <div class="main_blog wa-mytasks">
         <table class="tableData table table-bordered table-responsive">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Title</th>
                  <th>Assigned By</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
               </tr>
            </thead>
            <tbody>
            	<?php
            		if(!empty($taskList['result'])){
            			$sno=0;
            			foreach($taskList['result'] as $task){
            			$sno++; ?>
            				<tr>
            					<td><?php echo $sno;?></td>
            					<td><a class="myTaskList" data-toggle="modal" data-target="#addtasksfill" data-mytask_id="<?php echo $task->task_id;?>" data-assigned_to="0" data-notification="0"><?php echo ucfirst($task->title);?></a></td>
            					<td><?php echo ucwords($task->business_name);?></td>
            					<td><?php echo date('d-m-Y',strtotime($task->start_date));?></td>
            					<td><?php echo date('d-m-Y',strtotime($task->end_date));?></td>
            					<td>
            						<?php 
            							$status = $task->status;
            							if($status == 0){
            								echo 'Pending';
            							}
            							else if($status == 1){
            								echo 'Process';
            							}else if($status == 2){
            								echo 'Completed';
            							}else if($status == 3){
            								echo 'Incomplete';
            							}
            						?>
            					</td>
            				</tr>
            			<?php }
            		}
            	 ?>
            </tbody>
         </table>
     </div>
      </div>
   </div>
</section>
<!------>
<!-- The Modal -->
<div class="form_popup">
   <div class="modal fade" id="myModal">
      <div class="modal-dialog">
         <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="">
               <div class="tabsupphoto">
                  <ul class="nav nav-pills">
                     <li class="active" ><a data-toggle="tab" href="#Post" class="active show">
                        <label class="upld_lbl"><i class="fa fa-edit"></i><label> Post</label></label>
                        </a>
                     </li>
                     <li><a data-toggle="tab" href="#PhotoUpload">
                        <label class="upld_lbl img_upload_label"><i class="fa fa-image"></i><label>Photo Upload</label></label></a>
                     </li>
                     <li><a data-toggle="tab" href="#VideoUpload">
                        <label class="upld_lbl video_upload_label"><i class="fa fa-video-camera" aria-hidden="true"></i><label>Video Upload</label></label></a>
                     </li>
                  </ul>
                  <div class="tab-content">
                     <div id="Post" class="tab-pane in active">
                        <form id="dataPost1" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                           <input type="hidden" name="site_url" id="act_url1" value="<?php echo site_url('user/wallpost'); ?>" >
                           <input type="hidden" name="post_title" id="post_title1" value="" >
                           <div class="form-group pdno">
                              <textarea name="post_content" placeholder="Share your thoughts here." class="form-control check_empty" id="post_content1"></textarea>
                              <div class="input_error_msg">Please fill this field.</div>
                           </div>
                           <div class="post_bx">
                              <div class="form-group">
                                 <input class="btn btn-success btn-sm post_add" onclick="saveData('dataPost1','<?php echo site_url('user/wallpost'); ?>','responseDiv','errorDivId')" value="Post" type="button">
                              </div>
                           </div>
                        </form>
                     </div>
                     <div id="PhotoUpload" class="tab-pane fade">
                        <form id="dataPost" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                           <input type="hidden" name="site_url" id="act_url" value="<?php echo site_url('user/wallpost'); ?>" >
                           <input type="hidden" name="post_title" id="post_title" value="" >
                           <div class="my_upload_pics_t">
                              <div class="img_div"></div>
                              <div class="my_plus_i89">
                                 <a href="javascript:void(0)" class="plusicon">
                                 <i class="fa fa-plus"></i>
                                 <input class="files check_empty" name="post_image[]" multiple accept=".png, .jpg, .jpeg, .gif" type="file">
                                 </a>
                              </div>
                           </div>
                           <div class="form-group pdno">
                              <textarea name="post_content" placeholder="Share your thoughts here." class="form-control " id="post_content2"></textarea>
                              <div class="input_error_msg">Please fill this field.</div>
                           </div>
                           <div class="post_bx">
                              <div class="form-group">
                                 <input class="btn btn-success btn-sm post_add" onclick="saveData('dataPost','<?php echo site_url('user/wallpost'); ?>','responseDiv','errorDivId')" value="Post" type="button">
                              </div>
                           </div>
                        </form>
                     </div>
                     <div id="VideoUpload" class="tab-pane fade">
                        <form class="dropzone" action="<?php echo site_url('user/wallpost2'); ?>" method="post" enctype="multipart/form-data">
                           <input type="hidden" name="site_url" id="act_url3" value="<?php echo site_url('user/wallpost2'); ?>" >
                           <input type="hidden" name="post_title" id="post_title3" value="" >
                           <!--  <div class="form-group">
                              <div class="video_upload" style="margin:5px;">
                              
                              <div class="fallback">
                              
                              <input name="file" type="file" accept="video/mp4" />
                              
                              </div>
                              
                              </div>
                              
                              </div> -->
                           <!------>
                           <div class="form-group pdno">
                              <textarea name="post_content" placeholder="Share your thoughts here." class="form-control " id="post_content3"></textarea>
                              <div class="input_error_msg">Please fill this field.</div>
                           </div>
                           <div class="post_bx">
                              <div class="form-group">
                                 <input class="btn btn-success btn-sm" id="submit-all" value="Post" type="button" disabled="disabled">
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <!--post_bx start-->
               <!--post_bx close-->
            </div>
            <!--div share_your close-->
            <!--div share_your close-->
         </div>
      </div>
   </div>
</div>
<!-- The Modal edit 2 strat -->
<div class="form_popup" id="modalEdit">
</div>
<div id="modalUnfriend" class="modal fade">
   <div class="modal-dialog modal-confirm">
      <div class="modal-content">
         <div id="success1"></div>
         <div class="modal-header">
            <h4 class="modal-title">Are you sure?</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         </div>
         <div class="modal-body">
            <p>You want to unfriend this friend ?</p>
         </div>
         <div class="modal-footer">
            <input type="hidden" id="friend_id">
            <input type="hidden" id="unfriend_url" value="<?php echo base_url() ?>profile/unfriend">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" onclick="unfriend()">Unfriend</button>
         </div>
      </div>
   </div>
</div>
<div id="modalLeave" class="modal fade">
   <div class="modal-dialog modal-confirm">
      <div class="modal-content">
         <div id="success2"></div>
         <div class="modal-header">
            <h4 class="modal-title">Are you sure?</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         </div>
         <div class="modal-body">
            <p>You want to leave this job ?</p>
         </div>
         <div class="modal-footer">
            <input type="hidden" id="leave_job">
            <input type="hidden" id="leave_job_url" value="<?php echo base_url() ?>profile/leaveJob">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" onclick="leaveJob()">Leave</button>
         </div>
      </div>
   </div>
</div>
<div id="modalDeleteComment" class="modal fade">
   <div class="modal-dialog modal-confirm">
      <div class="modal-content">
         <div id="success"></div>
         <div class="modal-header">
            <h4 class="modal-title">Are you sure?</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         </div>
         <div class="modal-body">
            <p>Do you really want to delete this comment ?</p>
         </div>
         <div class="modal-footer">
            <input type="hidden" id="record_id">
            <input type="hidden" id="folderrecord_id">
            <input type="hidden" id="delete_url" value="<?php echo base_url() ?>profile/deleteData">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger del_comment">Delete</button>
         </div>
      </div>
   </div>
</div>
<div id="modalDelete" class="modal fade">
   <div class="modal-dialog modal-confirm">
      <div class="modal-content">
         <div id="success"></div>
         <div class="modal-header">
            <h4 class="modal-title">Are you sure?</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         </div>
         <div class="modal-body">
            <p>Do you really want to delete this record ?</p>
         </div>
         <div class="modal-footer">
            <input type="hidden" id="record_id">
            <input type="hidden" id="folderrecord_id">
            <input type="hidden" id="delete_url" value="<?php echo base_url() ?>profile/deleteData">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" onclick="deleteData()">Delete</button>
         </div>
      </div>
   </div>
</div>
<div id="modalAlbumDelete" class="modal fade">
   <div class="modal-dialog modal-confirm">
      <div class="modal-content">
         <div id="success_"></div>
         <div class="modal-header">
            <h4 class="modal-title">Are you sure?</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         </div>
         <div class="modal-body">
            <p>Do you really want to delete this document ?</p>
         </div>
         <div class="modal-footer">
            <input type="hidden" id="record_id">
            <input type="hidden" id="folderrecord_id">
            <input type="hidden" id="delete_album_url" value="<?php echo base_url() ?>profile/deleteAlbumData">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" onclick="deleteAlbumData()">Delete</button>
         </div>
      </div>
   </div>
</div>
<div id="foldermodalAlbumDelete" class="modal fade">
   <div class="modal-dialog modal-confirm">
      <div class="modal-content">
         <div id="success1_"></div>
         <div class="modal-header">
            <h4 class="modal-title">Are you sure?</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         </div>
         <div class="modal-body">
            <p>Do you really want to delete this document ?</p>
         </div>
         <div class="modal-footer">
            <input type="hidden" id="record_id">
            <input type="hidden" id="folderrecord_id">
            <input type="hidden" id="delete_album_url" value="<?php echo base_url() ?>profile/deleteAlbumData">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" onclick="deleteAlbumfolderData()">Delete</button>
         </div>
      </div>
   </div>
</div>
<div id="foldermodalAlbumEdit" class="modal fade">
   <div class="modal-dialog modal-confirm">
      <div class="modal-content">
         <div id="success_rename"></div>
         <div class="modal-header">
            <h4 class="modal-title">Rename Folder</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         </div>
         <div class="modal-body">
            <div class="modal-body">
               <input type="text" class="form-control" name="rename_folder" id="rename_folder">
               <input type="hidden" class="form-control" name="folder_id" id="folder_id">
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" onclick="renameFolder()">Rename</button>
         </div>
      </div>
   </div>
</div>
<div id="filemodalAlbumEdit" class="modal fade">
   <div class="modal-dialog modal-confirm">
      <div class="modal-content">
         <div id="success_renames"></div>
         <div class="modal-header">
            <h4 class="modal-title">Rename File</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         </div>
         <div class="modal-body">
            <div class="modal-body">
               <input type="text" class="form-control" name="rename_file" id="rename_file">
               <input type="hidden" class="form-control" name="file_id" id="file_id">
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" onclick="renameFile()">Rename</button>
         </div>
      </div>
   </div>
</div>
<div class="loader" style="transform:scale(0)">
   <img src="<?php echo base_url();?>assets/images/giphy.gif" alt="Loading">
</div>
<!-- The Modal start 22march -->
<div class="modal fade" id="myModal5">
   <div class="modal-dialog">
      <div class="modal-content crox set_work">
         <!-- Modl Header -->
         <button type="button" class="close crox" data-dismiss="modal">&times;</button>
         <h1 class="Reviews0">Your Reviews</h1>
         <div class="witreview">
            <div class="row">
               <div class="col-md-12 col-sm-12">
                  <div class="mw">
                     <?php if(!empty($category_questions)){ ?>
                     <
                     <ul>
                        <li class="ful_cntant">
                           <div class="howwas">
                              <i class="fa fa-check"></i>
                              <h2><?php echo $category_questions->que_1; ?></h2>
                           </div>
                           <?php echo $historyRating[0];?>
                        </li>
                        <li class="ful_cntant">
                           <div class="howwas">
                              <i class="fa fa-check"></i>
                              <h2><?php echo $category_questions->que_2; ?></h2>
                           </div>
                           <?php echo $historyRating[1];?>
                        </li>
                        <li class="ful_cntant">
                           <div class="howwas">
                              <i class="fa fa-check"></i>
                              <h2><?php echo $category_questions->que_3; ?></h2>
                           </div>
                           <!--   <img src="<?php echo base_url();?>assets/images/s5.png"> -->
                           <?php echo $historyRating[2];?>
                        </li>
                        <li class="ful_cntant">
                           <div class="howwas">
                              <i class="fa fa-check"></i>
                              <h2><?php echo $category_questions->que_4; ?></h2>
                           </div>
                           <!--  <img src="<?php echo base_url();?>assets/images/s6.png"> -->
                           <?php echo $historyRating[3];?>
                        </li>
                        <li class="ful_cntant">
                           <div class="howwas">
                              <i class="fa fa-check"></i>
                              <h2><?php echo $category_questions->que_5; ?></h2>
                           </div>
                           <!--      <img src="<?php echo base_url();?>assets/images/s7.png"> -->
                           <?php echo $historyRating[4];?>
                        </li>
                     </ul>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--model close-->
<!--  add directory modal -->
<div class="modal fade" id="addDirectory" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add Folder</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <label for="pwd">Folder name:</label>
               <input type="text" class="form-control" id="dir-name">
               <div id="dnger-msg">
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <div class="row">
               <button onclick="directoryCreate(this,<?php echo get_current_user_id();?>)" type="button" class="btn primary start">Create</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- add directory modal end -->
<?php $this->session->set_userdata('friends_redirect',''); ?>
<style>
   .mw{
   width: 100%;
   }
   .mw ul {
   list-style: none;
   padding-left: 0 ;
   }
   .ful_cntant {
   border: 1px solid #e4ebf1;
   padding-left: 24px;
   padding-top: 9px;
   padding-bottom: 9px;
   box-shadow: 0px 0px 7px 0px #e4ebf1;
   margin-bottom: 9px;
   }
   .modal-content.crox.set_work {
   padding: 7px 20px;
   padding-bottom: 7px;
   padding-bottom: 12px;
   }
   .modal-dialog .Reviews0 {
   font-size: 21px;
   margin-top: -20px;
   margin-bottom: 15px;
   font-family: "Open Sans", sans-serif;
   font-weight: 600;
   }
   .blank-start{
   position: relative;
   }
   .blank-start::before {
   content: '\f006';
   font-family: FontAwesome;
   font-style: normal;
   color: #51c821;
   }
   .staress i {
   color: #51c821;
   }
   div.stars.aginstart {
   width: auto;
   display: inline-block;
   float: right;
   line-height: 20px;
   }
   .Reviews0 {
   font-size: 18px;
   margin-top: -20px;
   margin-bottom: 15px;
   font-weight: 600;
   }
</style>
<!--     <script type="text/javascript"></script>
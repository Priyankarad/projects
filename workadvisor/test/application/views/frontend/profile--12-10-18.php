<input type="hidden" id="user_login_type" value="<?php if($this->session->userdata('user_login_type') && $user_data->basic_info == 0){ echo "performer";}else{ echo 0;}  ?>"> 

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
                <a> <i class="fa fa-bell" ></i><span class="rivew-bell notification_bell">0</span> Notification </a><ul id="notifications_ul"></ul>
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
		<?php /*<div class="chery11 profile-img">
			<img width='190' src='<?php echo (!empty($user_data->profile))? $user_data->profile:DEFAULT_IMAGE; ?>' >
          <a data-toggle="modal" class="update-profileimg" data-target="#uploadModal">
            <i class="fa fa-camera" aria-hidden="true"></i>
            &nbsp;Upload Your Profile
          </a>
        </div> */ ?>
<!--================mobile_social_icons=================-->
<!--================mobile_social_icons=================-->
<div id="share-buttons" class="mobile_opens" title="Share Profile">
<a href="javascript:void(0)" onclick="submitAndShare('<?php echo $imgs; ?>','<?php echo $usernamefb; ?>')" target="_blank">  
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
          <input type="hidden" id="uname" value="<?php echo ucfirst($uname);?>">
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
            <!-- <p>
              Phone No. : <?php echo $user_data->phone; ?>
            </p> -->
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
                <?php if(!empty($user_data->current_position)) { echo $user_data->current_position; } ?></strong> 
                <strong> <?php if(!empty($workingAt->business_name)) { 
                  $companyProfileURL = site_url('viewdetails/profile/'.encoding($workingAt->id));
                  echo '<small> At </small><a href="'.$companyProfileURL.'"> '.$workingAt->business_name.'</a>'; } ?>

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
         <!--<li class="his_img extr nav-item">
            <a class="nav-link" data-toggle="tab" href="#promot1">
               <div class="his_img">
                  <img src="<?php //echo base_url();?>assets/images/h11.png"> 
               </div>
               Promote Your Page
            </a>
         </li>-->
         <li class="his_img extr nav-item">
            <a class="nav-link " data-toggle="tab" href="#home">
               <div class="his_img">
                  <i class="fa fa-users"></i>
               </div>
               My Account
            </a>
         </li>
         <li class="his_img extr nav-item">
            <a class="nav-link  <?php if($this->session->userdata('friends_redirect')){}else{echo 'active';} ?> " data-toggle="tab" href="#menu1">
               <div class="his_img">
                  <img src="<?php echo base_url();?>assets/images/h8.png">
               </div>
               Highlights
            </a>
         </li>
         <li class="his_img extr nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu2">
               <div class="his_img">
                  <i class="fa fa-history"></i>
               </div>
                Rating History
            </a>
         </li>
         <li class="his_img extr nav-item">
            <a class="nav-link <?php if($this->session->userdata('friends_redirect')){echo 'active';}else{} ?>" data-toggle="tab" href="#menu3">
               <div class="his_img">
                  <img src="<?php echo base_url();?>assets/images/h10.png">
               </div>
               Friends 
               <span class="2_green"><?php  if(!empty($allFriends)){ echo count($allFriends); }else{ echo 0;} ?></span>
            </a>
         </li>
         <li class="his_img extr nav-item">
            <a class="nav-link" data-toggle="tab" href="#menuR1">
               <div class="his_img">
                  <i class="fa fa-star"></i>
               </div>
               Rank
            </a>
         </li>
         <li class="his_img extr nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu4">
               <div class="his_img">
                  <img src="<?php echo base_url();?>assets/images/h3.png">
               </div>
               Albums / Documents
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
              <!--
              <li class="his_img extr nav-item">
                <a class="nav-link" data-toggle="tab" href="#promot1">
                  <div class="his_img">
                    <img src="<?php echo base_url();?>assets/images/h11.png"> 
                  </div>
                  Promote Your Page
                </a>
              </li>-->

              <li class="his_img extr nav-item">
                <a class="nav-link " data-toggle="tab" href="#home">
                  <div class="his_img">
                    <i class="fa fa-users"></i>
                  </div>
                  My Account
                </a>
              </li>

              <li class="his_img extr nav-item">
                <a class="nav-link  <?php if($this->session->userdata('friends_redirect')){}else{echo 'active';} ?> " data-toggle="tab" href="#menu1">
                  <div class="his_img">
                    <img src="<?php echo base_url();?>assets/images/h8.png">
                  </div>
                  Highlights
                </a>
              </li>

              <li class="his_img extr nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu2">
                  <div class="his_img">
                    <i class="fa fa-history"></i>
                  </div>
                  Rating History
                </a>
              </li>


              <li class="his_img extr nav-item">
                <a class="nav-link <?php if($this->session->userdata('friends_redirect')){echo 'active';}else{} ?>" data-toggle="tab" href="#menu3">
                  <div class="his_img">
                    <img src="<?php echo base_url();?>assets/images/h10.png">
                  </div>Friends 
<!-- <span class="2_green">
<?php if(!empty($pendingRequest)){ echo count($pendingRequest); } ?>

</span> -->
<span class="2_green"><?php  if(!empty($allFriends)){ echo count($allFriends); }else{ echo 0;} ?></span>
</a>
</li>

<li class="his_img extr nav-item">
  <a class="nav-link" data-toggle="tab" href="#menuR1">
    <div class="his_img">
      <i class="fa fa-star"></i>
    </div>
    Rank
  </a>
</li>



<li class="his_img extr nav-item">
  <a class="nav-link" data-toggle="tab" href="#menu4">
    <div class="his_img">
      <img src="<?php echo base_url();?>assets/images/h3.png">
    </div>
    Albums / Documents
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
                  <!-- <input type="hidden" id="public_test_key" value="<?php echo PUBLIC_TEST_KEY;?>"> -->
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
                    <span>Expiration (MM/YY)</span>
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
                    tempor incididunt ut labore et dolore magna aliqua.</p>
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
  
	<div class="row">
		<div class="col-md-8">
			<?php echo $this->session->flashdata('updatemsg'); ?>
    
    <form method="post" action="<?php echo site_url(); ?>Profile/Editprofile" class="userprofile-form">
      <div class="row">


        <!--first Basic start-->
        <div class="Basic Aft_mleft">
          <div id="accordion">
            <div class="card">
              <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                  <div class="collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Basic Information</h1>
                  </div>
                </h5>
              </div>

              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
                <div class="card-body">
                  <!--row start-->
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <div class="slesh"></div>
                      <div class="form-group">
                        <label class="ener-name">Name</label>
                        <input name="firstname" class="form-control chinput dulinput ag1" placeholder="first name" type="text" value="<?php if(!empty($user_data->firstname)) { echo $user_data->firstname; } ?>" >
                        <input name="lastname" class="form-control chinput dulinput ag2" placeholder="last name" type="text" value="<?php if(!empty($user_data->lastname)) { echo $user_data->lastname; } ?>" >
                      </div>
                    </div>

                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label class="ener-name">Email </label>
                        <input type="text" class="form-control chinput" name="Cheryl" value="<?php if(!empty($user_data->email)) { echo $user_data->email; } ?>" disabled required>
                      </div>
                    </div>
                  </div>
                  <!--row close-->
                  <!--row start-->
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label class="ener-name">Zip</label>
                        <input type="text" name="zip"  class="form-control chinput zip" placeholder="Your zipcode" value="<?php if(!empty($user_data->zip)) { echo $user_data->zip; } ?>" required>
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label class="ener-name">City</label>
                        <input type="text" name="city" class="form-control chinput city" placeholder="Your City" value="<?php if(!empty($user_data->city)) { echo $user_data->city; } ?>" required>
                      </div>
                    </div>

                    
                  </div>
                  <!--row close-->
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label class="ener-name">State</label>
                        <input type="text" name="state" class="form-control chinput state" placeholder="Your State" value="<?php if(!empty($user_data->state)) { echo $user_data->state; } ?>" required>
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label class="ener-name">Country</label>
                        <input type="text" name="country"  class="form-control chinput country" placeholder="Your Country" value="<?php if(!empty($user_data->country)) { echo $user_data->country; } ?>" required>
                      </div>
                    </div>
                  
                  </div>
                  <!--row close-->

                  <div class="row">
                      <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label class="ener-name">Phone 
                          <?php 
                          $checked = '';
                          if(!empty($user_data->display_phone)) {
                            $checked ='checked=checked';
                          }
                          ?>
                          <input type="checkbox" id="mycheckbox12" name="display_phone" <?php echo $checked;?>>
                          <small> click to display </small>
                        </label>
                        <input type="text" name="phone" id="mycontact" class="form-control chinput" placeholder="Contact" value="<?php if(!empty($user_data->phone)) { echo $user_data->phone; } ?>" >
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label class="ener-name">Website
                          <?php 
                          $checked = '';
                          if(!empty($user_data->display_website)) {
                            $checked ='checked=checked';
                          }
                          ?>
                          <input type="checkbox" id="mycheckbox12" name="display_website" <?php echo $checked;?>>
                          <small> click to display </small></label>
                          <input type="text" name="website_link" class="form-control chinput" placeholder="Website link" value="<?php if(!empty($user_data->website_link)) { echo $user_data->website_link; } ?>">
                        </div>
                      </div>
                    </div>
                    <!--row close-->
                  </div>
                </div>
              </div>


              <!--second card start-->
              <div class="card">
                <div class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                    <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                      <h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Category Information</h1>
                    </div>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="">
                  <div class="card-body">       
                    <!--category strat-->
                    <div class="row">
                      <div class="col-md-7 col-12">
                        <div class="form-group">
                          <label class="ener-name">Select your category</label>
                          <select class="form-control chinput" name="user_category">
                            <!-- <option value="<?php if(!empty($user_data->user_category)) { echo $user_data->user_category; } ?>" style="color: #fff;"><?php if(!empty($user_data->user_category)) { echo $user_data->user_category; } ?></option> -->
                            <?php if(!empty($category_details['result'])){
                              foreach($category_details['result'] as $categories){ ?>
                                <?php
                                $cateStatus = ($categories->id == $user_data->user_category) ? "selected": ""; 
                                ?>
                                <option value="<?php echo $categories->id; ?>" <?php echo $cateStatus; ?> ><?php echo $categories->name; ?></option>

                              <?php } } ?>

                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--category close-->
                  </div>
                </div>

                <!--second card start-->


                <!--third card start-->
                <div class="card">
                  <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                      <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        <h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Current Position</h1>
                      </div>
                    </h5>
                  </div>
                  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion" style="">
                    <div class="card-body">     
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label class="ener-name">Current Position</label>
                            <input type="text" name="current_position" id="current_position" class="form-control chinput" placeholder="Current Position" value="<?php if(!empty($user_data->current_position)) { echo $user_data->current_position; } ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!--third card close-->

                <!--fourth card strat-->
                <div class="card">
                  <div class="card-header" id="headingfour">
                    <h5 class="mb-0">
                      <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                        <h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Professional Skills <span class="professional_qmark"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h1>
                      </div>
                    </h5>
                  </div>
                  <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordion" style="">
                    <div class="card-body extra-linow">
                      <div class="row">
                        <div class="col-md-12 col-12">
                          <div id="bootstrapTagsInputForm" method="post" class="form-horizontal">
                            <div class="form-group">

                              <input type="text" name="newprofessional_skill" class="form-control chinput"
                              value="" data-role="tagsinput" placeholder="eg - Cook , Artist , ....">
                              <div class="ddaa">
                                <i class="fa fa-plus"></i>
                              </div>

                              <div class="bootstrap-tagsinput1">
                                <?php if(!empty($user_data->professional_skill)) {  
                                  $skills = explode(",",$user_data->professional_skill); 
                                  foreach ($skills as $skill) {
                                    ?>               
                                    <span class="tag label label-info"><?php echo $skill; ?>
                                    <input type="hidden" name="oldprofessional_skill[]" value="<?php echo $skill; ?>">
                                    <span data-role="remove" class="removetag">

                                    </span>
                                  </span>               
                                <?php  } } ?>
                              </div>

                            </div>
                          </div>
                          <!--new contant close-->
                        </div>
                      </div>
                    </div>
                    <!--category close--> 
                  </div>
                </div>
                <!--fourth card close-->

                <!--five card strat-->

                <div class="card">
                  <div class="card-header" id="headingfive">
                    <h5 class="mb-0">
                      <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="true" aria-controls="collapsefive">
                        <h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Additional Services <span class="additional_qmark"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h1>
                      </div>
                    </h5>
                  </div>
                  <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordion" style="">
                    <div class="card-body extra-linow">
                      <!--new contant aad-->

                      <div class="row">
                        <div class="col-md-12 col-12">
                          <div id="bootstrapTagsInputForm" method="post" class="form-horizontal">
                            <div class="form-group">
                              <input type="text" name="newadditional_services" class="form-control chinput"
                              value="" data-role="tagsinput" placeholder="eg - Delivery , Pickup , ....">
                              <div class="ddaa"><i class="fa fa-plus"></i></div>
                              <div class="bootstrap-tagsinput1">
                                <?php if(!empty($user_data->additional_services)) {  
                                  $services = explode(",",$user_data->additional_services); 
                                  foreach ($services as $service) {
                                    ?>
                                    <span class="tag label label-info"><?php echo $service; ?>
                                    <input type="hidden" name="oldadditional_services[]" value="<?php echo $service; ?>">
                                    <span data-role="remove" class="removetag"></span></span>
                                  <?php  } } ?>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--new contant close-->
                    </div>
                  </div>
                  <!--five card close--> 

                  <div class="card">
                    <div class="card-header" id="headingfives">
                      <h5 class="mb-0">
                        <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse_settings" aria-expanded="true" aria-controls="collapse_settings">
                          <h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Email Notification Settings</h1>
                        </div>
                      </h5>
                    </div>
                    <div id="collapse_settings" class="collapse" aria-labelledby="headingfive" data-parent="#accordion" style="">
                      <div class="card-body extra-linow">
                        <!--new contant aad-->

                        <div class="row">
                          <div class="col-md-12 col-12">
                            <div id="bootstrapTagsInputForm" method="post" class="form-horizontal switch_onOff">
                              <div class="form-group">
                                <p>Notification for received messages</p>
                                <label class="switch">
                                  <input type="checkbox" name="noti_msg" id="noti_msg"
                                  <?php 
                                  if(isset($user_data->message_notification) && $user_data->message_notification!=0)
                                  {
                                    echo "checked=checked";
                                  }
                                  ?>
                                  >
                                  <span class="slider round"></span>
                                </label>
                              </div>
                              
                              <div class="form-group">
                                <p>Notification for reviews</p>
                                <label class="switch">
                                  <input type="checkbox" name="review_notification" id="review_notification"
                                  <?php 
                                  if(isset($user_data->review_notification) && $user_data->review_notification!=0)
                                  {
                                    echo "checked=checked";
                                  }
                                  ?>
                                  >
                                  <span class="slider round"></span>
                                </label>
                              </div>
                              
                              <!-- <div class="form-group">
                                <label class="switch">
                                  <input type="checkbox" name="noti_job" id="noti_job">
                                  <span class="slider round"></span>
                                </label>
                              </div>
                              Notification for receiving messages -->

                              <div class="form-group">
                                <p>Notification for friend request received</p>
                                <label class="switch">
                                  <input type="checkbox" name="noti_fr_req" id="noti_fr_req"
                                  <?php 
                                  if(isset($user_data->friend_request_received_notification) && $user_data->friend_request_received_notification!=0)
                                  {
                                    echo "checked=checked";
                                  }
                                  ?>
                                  >
                                  <span class="slider round"></span>
                                </label>
                              </div>
                              

                              <div class="form-group">
                                <p>Notification for friend request acceptance</p>
                                <label class="switch">
                                  <input type="checkbox" name="noti_fr_ac" id="noti_fr_ac"
                                  <?php 
                                  if(isset($user_data->friend_request_acceptance_notification) && $user_data->friend_request_acceptance_notification!=0)
                                  {
                                    echo "checked=checked";
                                  }
                                  ?>>
                                  <span class="slider round"></span>
                                </label>
                              </div>
                              

                              <div class="form-group">
                                <p> Notification for job request acceptance</p>
                                <label class="switch">
                                  <input type="checkbox" name="noti_job_ac" id="noti_job_ac"
                                  <?php 
                                  if(isset($user_data->job_request_acceptance_notification) && $user_data->job_request_acceptance_notification!=0)
                                  {
                                    echo "checked=checked";
                                  }
                                  ?>>
                                  <span class="slider round"></span>
                                </label>
                              </div>
                             
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--new contant close-->
                    </div>
                  </div>
                  <!--five card close--> 


                  <!--19april start new tab add do it.-->

                  <div class="card">
                    <div class="card-header" id="heading7">
                      <h5 class="mb-0">
                        <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                          <h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Search Friends</h1>
                        </div>
                      </h5>
                    </div>
                    <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion" style="">
                      <div class="card-body">     
                        <div class="row">
                          <div class="serch-fn-up">
                           <!--  <div class="fb-tz bordr" data-toggle="modal" data-target="#fbmodal">
                              <p><i class="fa fa-facebook-square"></i>On Facebook</p>
                            </div> -->
                            <div class="ml-tz e-ml bordr" data-toggle="modal" data-target="#emailmodal">
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
                    </div>

                    <div class="thre-popup">
                      <!--model-start 30april-->
                      <!-- first Modal start -->
                      <div class="modal fade" id="fbmodal">
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
                                tempor incididunt ut labore et dolore magna aliqua.</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- first Modal close -->


                      <!-- second Modal start -->
                      <div class="modal fade" id="emailmodal">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <h4 class="modal-title">Send Invites</h4>
                            <!-- Modal body strat-->
                            <div class="modal-body">
                              <div class="only-bkvlr">
                                <div class="row">
                                  <div class="col-md-3 col-sm-3 col-12">
                                    <div class="imgs-emil mail-img-click">
                                      <a href="https://accounts.google.com/o/oauth2/auth?client_id=252607257150-kr5at3658jl7mtoef6boer0ign6ue3fk.apps.googleusercontent.com&redirect_uri=https://workadvisor.co/user/google&scope=https://www.google.com/m8/feeds/&response_type=code"><img src="<?php echo base_url();?>assets/images/b3c993e.png"></a>
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
                      <!-- second Modal close -->


                      <!-- third Modal start -->
                      <div class="modal fade" id="invitemodal">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <h4 class="modal-title">Send WorkAdvisor Invites To These Email Addresses.</h4>

                            <!-- Modal body -->
                            <!-- Modal body strat-->
                            <div class="modal-body">
                              <div class="only-bkvlr">
                                <form method="post"  action="<?php echo base_url();?>user/send_invitation">
                                  <div id="friend_invitation1" >
                                    <div class="form-group">
                                      <input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email">
                                    </div>
                                    <div class="form-group">
                                      <input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email">
                                    </div>
                                    <div class="form-group">
                                      <input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email">
                                    </div>
                                    <a class="emil-cntnt" style="cursor: pointer;" onclick = "addMore(1);">add another email address</a>
                                  </div>
                                  <button type="submit" class="invite-emil find">invitation email</button>
                                </form>
                              </div>
                            </div>
                            <!-- Modal body close-->
                          </div>
                        </div>
                      </div>
                      <!-- third Modal close -->
                    </div>
                    <!--model-close 30april-->

                  </div>
                  <!--19april close new tab add do it.-->

                  <!--last card div strat-->
                  <div class="card">
                    <div class="card-header" id="headingsix">
                      <h5 class="mb-0">
                        <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">
                          <h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Reset Password</h1>
                        </div>
                      </h5>
                    </div>
                    <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordion" style="">
                      <div class="card-body">
                        <!--category strat-->
                        <div class="row">
                          <?php if(!empty($user_data->password)) { ?>
                            <div class="col-md-4 col-12">
                              <div class="form-group">
                                <label class="ener-name">Current Password</label>
                                <input type="Password" name="oldpassword" id="oldpassword" class="form-control chinput" placeholder="Current Password">
                              </div>
                            </div>
                          <?php } ?>
                          <div class="col-md-4 col-12">
                            <div class="form-group">
                              <label class="ener-name">New Password</label>
                              <input type="Password" name="newpassword" id="newpassword" class="form-control chinput" placeholder="New Password">
                            </div>
                          </div>
                          <div class="col-md-4 col-12">
                            <div class="form-group">
                              <label class="ener-name">Confirm Password</label>
                              <input type="Password" name="cnewpassword" id="cnewpassword" class="form-control chinput" placeholder="Confirm Password"><span id='message1'></span>
                            </div>
                          </div>

                          <div class="col-md-4 col-12">
                            <div class="delet-formt">
                              <a class="nav-link"  onclick="return confirm('Are you sure you want to delete this account?');" href="<?php echo site_url('user/deleteaccount'); ?>">
                                <div class="his_img">
                                  <i class="fa fa-trash" aria-hidden="true"></i>
                                </div>
                                DELETE PROFILE
                              </a>
                            </div>      
                          </div>


                        </div>
                      </div>


                      <!--category close-->
                    </div>
                  </div>
                </div>
                <!--last card div close-->  

              </div>
              <!--row close-->
              <!--first Basic close-->
              <div class="enter_name">
                <button type="submit" class="find extra">
                  Save
                </button>
              </div>
            </div>
          </form>
		</div>
		<div class="col-md-4">
			
<!-- work_advisor_profile4 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3979824042791728"
     data-ad-slot="2846184025"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
		</div>
	</div>
  
    
        </div>

<!--profile edit pages tab link close====================================
  ==============================================================--> 



  <!--====================overview page first tab link start=====================--> 
  <div class="tab-pane container <?php if($this->session->userdata('friends_redirect')){}else{echo 'active';} ?>" id="menu1">
    <?php if($this->session->flashdata('success')){ echo $this->session->flashdata('success'); } ?>
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
            <?php if(!empty($posts_details['result'])){ $md = 0; foreach($posts_details['result'] as $post){ $md++; ?> 
              <input type="hidden" name="table_name" id="table_name" value="<?php echo POSTS;?>">
              <div class="main_blog post-id" id="<?php echo $post->id; ?>" data-uid="<?php echo get_current_user_id(); ?>">

                <?php if($post->post_image!=""){
                  $imgsert=$post->post_image;
                  $postimgarr=explode(',',$imgsert);
                  if(count($postimgarr)>1){ ?>
                    <div class = "row pdbothS">
                      <?php foreach($postimgarr as $postim){ ?>
                        <div class = "col-sm-3 col-md-3 thumb_upx2">
                          <a href = "#" class = "thumbnail" data-toggle="modal" data-target="#myModal00<?php echo $md; ?>">
                            <img src = "<?php echo $postim; ?>" alt= "Post Image">
                          </a>
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
                            <!--  <h4 class="modal-title"><?php echo $newkey; ?></h4> -->
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
                    <div class="over_viewimg" data-toggle="modal" data-target="#myModal002<?php echo $md; ?>">
                      <img src="<?php echo $imgsert; ?>" class="img-fluid">
                      <div class="bl-box">
                        <img src="<?php echo base_url();?>assets/images/scrl.png">
                      </div>
                    </div>
                    <div class="col-tz">    
                      <div id="myModal002<?php echo $md; ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <!--  <h4 class="modal-title"><?php echo $newkey; ?></h4> -->
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
                        <video width="320" height="240" controls id="videos">
                          <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type='video/mp4; codecs="avc1.4D401E, mp4a.40.2, vp8, vorbis"'>
                            <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/webm">
                              <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/ogg">
                                <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/mts">
                                </video>
                              </div>
                            </div><!-- 
                                                <div class="col-tz">    
                      <div id="myModal002<?php echo $md; ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>

                            <div class="modal-body">
                              <div class="row">
                                  <div class="col-md-3">
                                    <div class="fansy-gallry">  
                                      <a class="fancybox" data-fancybox="gallery111<?php echo $md; ?>" href="<?php echo base_url().'uploads/videos/'.$post->post_video; ?>">
                                       <video width="320" height="240"  controls>
                                        <source src="<?php echo base_url().'uploads/videos/'.$post->post_video; ?>" type='video/mp4; codecs="avc1.4D401E, mp4a.40.2, vp8, vorbis"'>
                                          <source src="<?php echo base_url().'uploads/videos/'.$post->post_video; ?>" type="video/webm">
                                            <source src="<?php echo base_url().'uploads/videos/'.$post->post_video; ?>" type="video/ogg">
                                              <source src="<?php echo base_url().'uploads/videos/'.$post->post_video; ?>" type="video/mts">
                                              </video>

                                            </a>
                                          </div>
                                        </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> -->
                          <?php } ?>
                          <div class="contant_overviw esdu" onclick="setID(<?php echo $post->id;?>);">
                            <h1 class="datess"><?php echo date('d-m-Y H:i A',strtotime($post->post_date)); ?></h1>
                            <div class="btnns">
<!--  <div class="form-group">
<a href="#" class="linke"><img src="<?php echo base_url();?>assets/images/like.png">
  <i class="fa fa-thumbs-up"></i>
</a>
</div> -->
<?php if($post->post_video==''){ ?>
  <a href="#" class="linke" data-toggle="modal" data-target="#sharePostModal<?php echo $md; ?>"><img src="<?php echo base_url();?>assets/images/share.png">
    <i class="fa fa-thumbs-up"></i>
  </a>
<?php } ?>
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
                    } ?>
                    <a href="javascript:void(0)" class="PIXLRIT1" onclick="submitAndShare('<?php echo $imgsert; ?>','<?php echo $user_data->firstname. ' ' .$user_data->lastname. ' status'; ?>')" target="_blank">
                        <i class="fa fa-facebook"></i>
                    </a> 
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

      if(preg_match("/^$regex$/i", $post->post_content)) 
      { 
        $urls = '';
        if(strpos($post->post_content, 'http://') !== 0) {
          $urls =  'http://' . $post->post_content;
        } else {
          $urls = $post->post_content;
        }
        echo '<a href="'.$urls.'" target="_blank">'.$post->post_content.'</a>'; 
      }else{
        echo $post->post_content;
      }
?>    
</p>
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


      <!--====================history page first tab link =====================--> 
      <div class="tab-pane container" id="menu2">
        <div class="row">
          <div class="col-md-8">
            <h3>Rating History &nbsp;<span class="history_"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h3>
            <div class="main_with coutm-wit">
              <ul>
                <?php 

                if(!empty($MyhistoryRating)){ foreach($MyhistoryRating as $key=>$historyratings){
                  $upid=encoding($user_data->id);
                  $compid=encoding($MyhistoryRating[$key][0]['company_id']);
                  ?>        
                  <li class="ful_cntant min-pdn">
                    <div class="lin-higthdiv">
                      <a href="<?php echo site_url('user/indivisualhistory/'.$upid.'/'.$compid) ?>">  <?php //echo ($key!="" && isset($category_questions->name)) ? $key : $category_questions->name ;
                      if($key!=''){
                        echo $key;
                      }else if(isset($category_questions->name)){
                        echo $category_questions->name ;
                      }else{
                        echo 'Unknown';
                      }
                       ?> (<?php echo count($historyratings); 
                       ?> Ratings) 
                      </a>
                    </div>
                  </li>
                <?php } } ?>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
           
<!-- Work_advisor_profile2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3979824042791728"
     data-ad-slot="5769690836"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>  
          </div>         
        </div>
      </div>

      <!--====================history page first tab link close =====================--> 


      <!--====================rank page six tab link  =====================--> 
      <div class="tab-pane container" id="menuR1">
        <div class="rankPshadows">
        <div class="row">
          <h1 class="you-sm">Your Ranking <span class="ranking"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                      
                    </span></h1>
          <?php if(!empty($userRankRatings)){
            foreach($userRankRatings as $row){
              if($row['id'] == get_current_user_id()){?>
                <div class="col-md-3 col-sm-3 col-6">
                  <a href="<?php echo base_url() ?>profile">
                    <div class="nam-tz">

                      <div class="us-tz">
                        <?php if($row['profile']!='assets/images/default_image.jpg'){?>
                          <img src="<?php echo $row['profile'];?>" alt="Post Image" class="img-fluid">
                        <?php } else{ ?>
                          <img src="<?php echo base_url().$row['profile'];?>" alt="Post Image" class="img-fluid">
                        <?php } ?>
                      </div>
                      <p class="pro_name8"><?php echo $row['firstname']." ".$row['lastname'];?></p>
                      <div class="combaine-sstx-z">
                        <?php echo $row['star_rating'];?>
                      </div>
                      <p>Rank - <span><?php echo $row['rank'];?></span> </p>
                    </div>
                  </a>
                </div>

              <?php       }
            }
          } ?>
        </div>

        <div class="top-usr">
          <div class="row">
            <h1 class="you-sm text-center">Top 5 Rankings</h1>
            <?php if(!empty($userRankRatings)){
              $count = 1;
              foreach($userRankRatings as $row){
                if($row['id'] == get_current_user_id()){
                  $url = base_url().'profile';
                }else{
                  $url = base_url().'viewdetails/profile/'.encoding($row['id']);
                }
                if($count <= 5){
                  ?>
                  <div class="col-md-3 col-sm-3 col-6">
                    <a href="<?php echo $url;?>">
                      <div class="nam-tz">

                        <div class="us-tz">
                          <?php if($row['profile']!='assets/images/default_image.jpg'){?>
                            <img src="<?php echo $row['profile'];?>" alt="Post Image" class="img-fluid">
                          <?php } else{ ?>
                            <img src="<?php echo base_url().$row['profile'];?>" alt="Post Image" class="img-fluid">
                          <?php } ?>
                        </div>
                        <p class="pro_name8"><?php echo $row['firstname']." ".$row['lastname'];?></p>
                        <div class="combaine-sstx-z">
                          <?php echo $row['star_rating'];?>
                        </div>
                        <p>Rank - <span><?php echo $row['rank'];?></span> </p>
                      </div>
                    </a>
                  </div>

                <?php     }else{
                  break;
                }
                $count++;
              }
            } ?>
          </div>
        </div>
		<div>
<!-- work_advisor_profile4 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3979824042791728"
     data-ad-slot="2846184025"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
		</div>
      </div>
      </div>
      <!--====================rank page six  tab link close =====================--> 
      <!--====================Friends page first tab link  =====================--> 
      <div class="tab-pane container <?php if($this->session->userdata('friends_redirect')){echo 'active';}else{} ?>" id="menu3">
        <div class="main_div_width">
          <div class="row">
            <div class="col-md-7 col-12">

              <h2 class="Cher">Friend Requests</h2>
              <?php
              if(!empty($pendingRequest)){ $a=1; foreach($pendingRequest as $req){if($req['user_role'] == 'Employer'){
                  $userProfileUrl = site_url('viewdetails/profile/'.encoding($req['id'])."?type=emp");
                } 
                else{
                  $userProfileUrl = site_url('viewdetails/profile/'.encoding($req['id']));
                }
                if($a%2==1){ echo '<ul class="new_friends">';}
                ?>
                <li id="<?php echo 'FR'.$req['id']; ?>">
                  <div class="jerry">
                    <h1><?php 

                    if(isset($req['business_name']) && $req['business_name']!='')
                      echo $req['business_name'];
                    else
                      echo $req['firstname'].' '.$req['lastname']; ?></h1>
                    <a href="<?php echo $userProfileUrl; ?>">
                      <div class="cat_img">
                        <img src="<?php echo (!empty($req['profile']))? $req['profile']:DEFAULT_IMAGE; ?>" alt="<?php echo $req['firstname'].' '.$req['lastname']; ?>" alt="">
                      </div>
                    </a>
                    <p><?php echo $req['city'].', '.$req['state'].', '.$req['country']; ?></p>
                    <p>
                      <?php if($req['user_role'] == 'Employer'){ ?>
                        <button class="btn btn-sm btn-success" onclick="jobRequest('<?php echo encoding($req['id']); ?>','Accept','<?php echo 'FR'.$req['id']; ?>',this,'per')">Accept</button>
                            &nbsp; <button class="btn btn-sm btn-danger" onclick="jobRequest('<?php echo encoding($req['id']); ?>','Reject','<?php echo 'FR'.$req['id']; ?>',this,'per')">Reject</button>
                      <?php }else{ ?>
                      <button class="btn btn-sm btn-success" onclick="friendRequest('<?php echo encoding($req['id']); ?>','Accept','<?php echo 'FR'.$req['id']; ?>')">Accept</button> &nbsp; <button class="btn btn-sm btn-danger" onclick="friendRequest('<?php echo encoding($req['id']); ?>','Reject','<?php echo 'FR'.$req['id']; ?>')">Reject</button>
                    <?php } ?>

                    </p>
                    <?php $userRating = userOverallRatings($req['id']);
                    if(!empty($userRating['starRating'])){

                      echo preg_replace("/\([^)]+\)/","",$userRating['starRating']);
                    }
                    ?>
                  </div>
                </li> 

                <?php if($a%2==0){ echo '</ul>';}
                $a++;
              } } ?>
            </div>



            <!--freindpage serch friend box start-->
            <div class="col-md-5 col-sm-5 col-12">
              <h2 class="cher">Search Friends</h2>
              <div class="serch-fn-up">
                <!-- <div class="fb-tz bordr" data-toggle="modal" data-target="#fbmodalone">
                  <p><i class="fa fa-facebook-square"></i>On Facebook</p>
                </div> -->
                <div class="ml-tz e-ml bordr" data-toggle="modal" data-target="#emailmodalone">
                  <p><i class="fa fa-envelope"></i>In Your Email Contacts</p>
                </div>
                <div class="invt-tz in-te bordr">
                  <a href="<?php echo base_url()?>user/invite_gmail_contacts">
                    <p><i class="fa fa-user-plus"></i> Invite Friends to WorkAdvisor</p>
                  </a>
                </div> 
              </div> 



              <div class="thre-popup">
                <!--model-start 30april-->
                <!-- first Modal start -->
                <div class="modal fade" id="fbmodalone">
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
                          tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <!-- second Modal start -->
                <div class="modal fade" id="emailmodalone">
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



                <!-- second Modal close -->
                <!-- third Modal start -->
                <div class="modal fade" id="invitemodalone">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <h4 class="modal-title">Send WorkAdvisor Invites To These Email Addresses.</h4>
                      <!-- Modal body -->
                      <!-- Modal body strat-->
                      <div class="modal-body">
                        <div class="only-bkvlr" >
                          <form method="post" action="<?php echo base_url();?>user/send_invitation">
                            <div id="friend_invitation2" >
                              <div class="form-group">
                                <input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email">
                              </div>
                              <div class="form-group">
                                <input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email">
                              </div>
                              <div class="form-group">
                                <input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email">
                              </div>
                              <a class="emil-cntnt" style="cursor: pointer;" onclick = "addMore(2);">add another email address</a>
                            </div>
                            <button type="submit" class="invite-emil find">invitation email</button>
                          </form>
                        </div>
                      </div>
                      <!-- Modal body close-->
                    </div>
                  </div>
                </div>
                <!-- third Modal close -->
              </div>
              <!--model-close 30april-->
            </div>
            <!--freindpage serch friend box close-->
          </div>
         <!-- <div class="bor_btm"></div> -->

        <!--   <div class="row mar_tp F_allfnds">
            <h2 class="Cher">Job Requests</h2>
              <?php
                  if(!empty($pendingRequestByCompany)){ $a=0; foreach($pendingRequestByCompany as $req){ $a++;
                    $userProfileUrl = site_url('viewdetails/profile/'.encoding($req['id']));
                    ?>
                    <div class="col-md-3 col-12" id="<?php echo 'FR'.$req['id']; ?>">
                      <a href="#">
                        <div class="jerry">
                          <h1><?php echo $req['business_name']; ?></h1>
                          <a href="<?php echo $userProfileUrl; ?>">
                            <div class="cat_img">
                              <img src="<?php echo (!empty($req['profile']))? $req['profile']:DEFAULT_IMAGE; ?>" alt="<?php echo $req['firstname'].' '.$req['lastname']; ?>" alt="<?php echo $req['firstname'].' '.$req['lastname']; ?>">     
                            </div>
                          </a>
                          <p><?php echo $req['city'].', '.$req['state'].', '.$req['country']; ?></p>
                          <p>
                            <button class="btn btn-sm btn-success" onclick="jobRequest('<?php echo encoding($req['id']); ?>','Accept','<?php echo 'FR'.$req['id']; ?>',this)">Accept</button>
                            &nbsp; <button class="btn btn-sm btn-danger" onclick="jobRequest('<?php echo encoding($req['id']); ?>','Reject','<?php echo 'FR'.$req['id']; ?>',this)">Reject</button>
                          </p>
                          <img src="<?php echo base_url();?>assets/images/s4.png" class="star_img2">
                        </div>
                      </a>
                    </div> 
                    <?php if($a%4==0){?> </div><div class="row mar_tp"> <?php } } }if($a==0){
            echo '<div class="alert alert-danger">No data exist</div>';
          }   ?>

                  </div> -->




        <div class="bor_btm"></div>

          <div class="row mar_tp F_allfnds">
            <h2 class="Cher">All Friends</h2>
            <?php
            $a=0;
     // pr($allFriends);
            if(!empty($allFriends)){  foreach($allFriends as $frie){ 
             if($frie['user_role']!='Employer'){
                $a++;
                $userProfileUrl1 = site_url('viewdetails/profile/'.encoding($frie['id']));
                ?>
                <div class="col-md-3 col-6 my_allfloatsF" id="<?php echo 'AF'.$frie['id']; ?>">
                  <div class="jerry">
                    <h1><?php 
                    if(isset($frie['business_name']) && $frie['business_name']!=''){
                      echo $frie['business_name'];
                    }else{
                      echo $frie['firstname'].' '.$frie['lastname'];
                      } ?></h1>
                    <a href="<?php echo $userProfileUrl1; ?>">
                      <div class="cat_img">
                        <img src="<?php echo (!empty($frie['profile']) && $frie['profile']!='assets/images/default_image.jpg') ? $frie['profile'] : base_url().DEFAULT_IMAGE; ?>" alt="<?php echo $frie['firstname'].' '.$frie['lastname']; ?>">
                      </div>
                    </a>
                    <p><?php 
                    $address = array();
                    if(isset($frie['city']) && !empty($frie['city']))
                      $address[] = trim($frie['city']);
                    if(isset($frie['country']) && !empty($frie['country']))
                      $address[] = trim($frie['country']);
                    if(isset($frie['zip']) && !empty($frie['zip']))
                      $address[] = trim($frie['zip']);
                    if(!empty($address)){
                      $address = implode(", ", $address);
                      echo $address;
                    }
                    ?></p>
                    <p>
                      <?php if($frie['user_role']!='Employer'){?>
                      <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalUnfriend" onclick="setFriendID(<?php echo $frie['id']?>)">Unfriend</button> &nbsp; <button class="btn btn-sm btn-danger" onclick="friendRequest('<?php echo encoding($frie['id']); ?>','Block','<?php echo 'AF'.$frie['id']; ?>')">Block</button>
                    <?php } ?>
                    </p>
                    <?php $userRating = userOverallRatings($frie['id']);
                    if(!empty($userRating['starRating'])){

                      echo preg_replace("/\([^)]+\)/","",$userRating['starRating']);
                    }
                    ?>
                  </div>

                </div> 
                <?php if($a%4==0){?> </div>


                <div class="row mar_tp"> <?php }
              }
            }
          }
          if($a==0){
            echo '<div class="alert alert-danger">No data exist</div>';
          }  ?>
        </div>

        <div class="row mar_tp F_allfnds">
          <h2 class="Cher">Working At</h2>
          <?php
          $a=0;
     // pr($allFriends);
          if(!empty($workingAt1)){  foreach($workingAt1 as $frie){ 
            if($frie['user_role']!='Performer'){
              $a++;
              $userProfileUrl1 = site_url('viewdetails/profile/'.encoding($frie['id']));
              ?>
              <div class="col-md-3 col-6 my_allfloatsF" id="<?php echo 'AF'.$frie['id']; ?>">
                <div class="jerry">
                  <h1><?php echo $frie['business_name']; ?></h1>
                  <a href="<?php echo $userProfileUrl1; ?>">
                    <div class="cat_img">
                      <img src="<?php echo (!empty($frie['profile']) && $frie['profile']!='assets/images/default_image.jpg') ? $frie['profile'] : base_url().DEFAULT_IMAGE; ?>" alt="<?php echo $frie['firstname'].' '.$frie['lastname']; ?>">
                    </div>
                  </a>
                  <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalLeave" onclick="setFriendID(<?php echo $frie['id']?>)">Leave Job</button>
                  <p><?php 
                  $address = array();
                  if(isset($frie['city']) && !empty($frie['city']))
                    $address[] = trim($frie['city']);
                  if(isset($frie['country']) && !empty($frie['country']))
                    $address[] = trim($frie['country']);
                  if(isset($frie['zip']) && !empty($frie['zip']))
                    $address[] = trim($frie['zip']);
                  if(!empty($address)){
                    $address = implode(", ", $address);
                    echo $address;
                  }
                  ?></p>
                  <!--  <p><button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalUnfriend" onclick="setFriendID(<?php echo $frie['id']?>)">Unfriend</button> &nbsp; <button class="btn btn-sm btn-danger" onclick="friendRequest('<?php echo encoding($frie['id']); ?>','Block','<?php echo 'AF'.$frie['id']; ?>')">Block</button></p> -->
                </div>

              </div> 
              <?php if($a%4==0){?> </div>


              <div class="row mar_tp"> <?php }
            }
          }
        }
        if($a==0){
          echo '<div class="alert alert-danger">No data exist</div>';
        }  ?>
      </div>
<div style="height: 113px;">
<!-- work_advisor_profile4 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3979824042791728"
     data-ad-slot="2846184025"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

    </div>
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
        <div class="row">
          <?php if(!empty($postbycompany)){ $md=0;  foreach($postbycompany as$newkey=>$newvalue){ $md++;
            $picarr=array();
            $vidarray = array();
            $latest_image1=base_url()."assets/images/p1.png";
            $latest_image2=base_url()."assets/images/ph.png";
            $latest_image3=base_url()."assets/images/v.png";
            ?>
            <div class="col-tz">    
              <div id="myModal001<?php echo $md; ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <h4 class="modal-title"><?php echo $newkey; ?></h4>
                    <div class="modal-body">
                      <div class="row">
                        <?php foreach($newvalue['result'] as $pst){
                          if($pst->post_image!=""){
                            $multiple=explode(',',$pst->post_image);
                            foreach($multiple as $img){

                              $picarr[]= $img;
                              $latest_image1=$img;
                              $latest_image2=$img;
                              $latest_image3=$img;

                              ?>

                              <div class="col-md-3">
                                <div class="fansy-gallry">  
                                  <a data-fancybox="gallery1<?php echo $md; ?>" href="<?php echo $img; ?>">
                                    <img src="<?php echo $img; ?>">
                                  </a>
                                </div>
                              </div>
                            <?php } } } ?>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-tz">    
                  <div id="myModal00v<?php echo $md; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <h4 class="modal-title"><?php echo $newkey; ?></h4>
                        <div class="modal-body">
                          <div class="row">
                            <?php foreach($newvalue['result'] as $pst){
                              if($pst->post_video!=""){
                                $multiple=explode(',',$pst->post_video);
                                foreach($multiple as $video){
                                  $vidarray[]= "uploads/videos/".$video;
                                  $latest_video1="uploads/videos/".$video;
                                  $latest_video2="uploads/videos/".$video;
                                  $latest_video3="uploads/videos/".$video;
                                  ?>
                                  <div class="col-md-3">
                                    <div class="fansy-gallry">  
                                      <a class="fancybox" data-fancybox="gallery2<?php echo $md; ?>" href="<?php echo base_url().'uploads/videos/'.$video; ?>">
                                       <video width="320" height="240" preload="metadata">
                                        <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type='video/mp4; codecs="avc1.4D401E, mp4a.40.2, vp8, vorbis"'>
                                          <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type="video/webm">
                                            <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type="video/ogg">
                                              <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type="video/mts">
                                              </video>

                                            </a>
                                          </div>
                                        </div>
                                      <?php } } } ?>
                                    </div>
                                  </div>

                                </div>
                              </div>
                            </div>
                          </div>


                          <div class="col-md-4 col-12">
                            <a href="#">
                              <div class="jerry">
                                <h1><?php echo $newkey; ?></h1>

                                <div class="cat_img photss">

                                  <div class="atin_photos">
                                    <?php if(!empty($picarr) && count($picarr)>0){?>
                                      <img src="<?php echo $latest_image1; ?>">
                                      <a href="" class="bod_btm"><?php echo count($picarr)?> Photos</a><br>
                                    <?php } ?>
                                    <?php if(!empty($vidarray) && count($vidarray)>0){?>
                                     <video width="320" height="240"  controls id="videos">
                                      <source src="<?php echo base_url().$latest_video1; ?>#t=1" type='video/mp4; codecs="avc1.4D401E, mp4a.40.2, vp8, vorbis"'>
                                        <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/webm">
                                          <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/ogg">
                                            <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/mts">
                                            </video>
                                            <a href="" class="bod_btm"><?php echo count($vidarray)?> Videos</a>
                                          <?php } ?>
                                        </div>
                                      </div>

                                      <div class="jhiga">
                                        <span><?php echo $newkey; ?></span>
                                        <?php if(!empty($picarr) && count($picarr)>0){?>
                                          <div class="pho_cnt">
                                            <div class="photos1">
                                              <img src="<?php echo $latest_image2; ?>">
                                            </div>
                                            <a href="" data-toggle="modal" data-target="#myModal001<?php echo $md; ?>" class="bod_btm"><?php echo count($picarr)?> Photos</a>
                                          </div>
                                        <?php } ?>
                                        <?php if(!empty($vidarray) && count($vidarray)>0){?>
                                          <div class="pho_cnt">
                                            <div class="photos1 mar_lft">

                                              <video width="320" height="240"  preload="metadata">
                                                <source src="<?php echo base_url().$latest_video1; ?>#t=1" type='video/mp4; codecs="avc1.4D401E, mp4a.40.2, vp8, vorbis"'>
                                                  <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/webm">
                                                    <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/ogg">
                                                      <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/mts">
                                                      </video>

                                                    </div>
                                                    <a href="" data-toggle="modal" data-target="#myModal00v<?php echo $md; ?>" class="bod_btm"><?php echo count($vidarray)?> Videos</a>
                                                  </div>
                                                <?php } ?>
                                              </div>
                                            </div>
                                          </a>
                                        </div> 
                                      <?php } } ?>
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
                                            <?php 
                        // $selected = '';
                        // if(isset($albumData['result'][0]->view_type) && $albumData['result'][0]->view_type==2){
                        //   $selected = 'selected="selected"';
                        // }
                                            ?>
                        <!-- <select id="view_type" name="view_type">
                          <option value="1">Public</option>
                          <option value="2" <?php echo $selected;?>>Private</option>
                        </select> -->
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
			  <div>
<!-- work_advisor_profile4 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3979824042791728"
     data-ad-slot="2846184025"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
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
<!-- work_advisor_profile3 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3979824042791728"
     data-ad-slot="6353388032"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

             </div>

           </div> 
         </div>
         <!--Video-photo doc tab link close--> 

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
                </a></li>
                <li><a data-toggle="tab" href="#PhotoUpload">
                  <label class="upld_lbl img_upload_label"><i class="fa fa-image"></i><label>Photo Upload</label></label></a></li>

                  <li><a data-toggle="tab" href="#VideoUpload">
                    <label class="upld_lbl video_upload_label"><i class="fa fa-video-camera" aria-hidden="true"></i><label>Video Upload</label></label></a></li>
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
                      <<ul>
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
<!--     <script type="text/javascript">
  
    </script> 
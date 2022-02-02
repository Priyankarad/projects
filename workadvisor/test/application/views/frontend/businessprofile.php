<!--section log_inheder start-->
<input type="hidden" name="table_name" id="table_name" value="<?php echo POSTS;?>">
<input type="hidden" name="profileSet" id="profileSet" value="1">

<input type="hidden" id="business" value="1">

<style type="text/css">

.dulinput { text-transform: capitalize; }

</style>

<input type="hidden" id="user_login_type" value="<?php if($this->session->userdata('user_login_type') && $user_data->basic_info == 0){ echo "employer";}else{ echo 0;}  ?>">

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

<?php

$imgs =""; 

$usernamefb = "";

$imgs = ($user_data->profile !=  'assets/images/default_image.jpg'  && (checkRemoteFile($user_data->profile)))? $user_data->profile: base_url().'/assets/images/icon-facebook.gif';

if($user_data->business_name!=''){

  $usernamefb = $user_data->business_name." on WorkAdvisor.co";

}else{

  $usernamefb = $user_data->firstname." ".$user_data->lastname." on WorkAdvisor.co";

}

?>

</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/dropzone.css">

<section class="profile_tab">

  <div class="container">

    <div class="row">

      <div class="col-md-12 col-12 pl_inlft">

        <div class="tab_list">

          <!-- Nav tabs --><div class="card">

            <ul class="nav nav-tabs" role="tablist">

<!-- <li role="presentation" class="active">

<a href="#home" aria-controls="home" role="tab" data-toggle="tab">My account</a>

</li> -->

<li role="presentation" class="bell notification_toggle">

  <a> <i class="fa fa-bell" ></i><span class="rivew-bell notification_bell">0</span> Notification </a><ul id="notifications_ul"></ul>

</li>

<li role="presentation">

  <a href="<?php echo base_url()?>user/favourites_list"> <i class="fa fa-heart" aria-hidden="true"></i> Favorites </a>

</li>   

<li role="presentation"><a  aria-controls="ShareProfile" role="tab" data-toggle="tab">

  <i class="fa fa-share-square-o"></i> Share Profile</a>

</li>

<div id="share-buttons" title="Share Profile">

<?php /* <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">

<img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />

</a> */?>

<?php 

$shareurl = '';

$shareurl = site_url()."/viewdetails/profile/".encoding(get_current_user_id());

?>

<a href="javascript:void(0)" onclick="submitAndShare('<?php echo $imgs; ?>','<?php echo $usernamefb; ?>','<?php echo $shareurl; ?>')" target="_blank"> <i class="fa fa-facebook"></i></a>



<a href="https://plus.google.com/share?url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">

  <img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" />

</a>



<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">

  <img src="https://simplesharebuttons.com/images/somacro/linkedin.png" alt="LinkedIn" />

</a>

</div>



<!-- <li role="presentation">

<a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Create Category</a>

</li> -->

</ul>

<!-- Tab panes -->



</div>

</div>

</div>

</div>

</div>

</section>

<!--log_inheder start-->



<!--profil start-->

<!-- The Modal -->

<div class="modal fade" id="myModalbell">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title">Notifications</h4>

        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>

      <div class="modal-body notification_modal">

      </div>

    </div>

  </div>

</div>

<section class="chery1">

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

    <div class="row">

      <div class="col-md-8 col-12 pl_inlft pd0Lefts">

        <div class="chery11 profile-img newfixedsizeX">

          <img src="<?php echo (!empty($user_data->profile) && checkRemoteFile($user_data->profile))? $user_data->profile:DEFAULT_IMAGE; ?>" alt="profile image"/>

          <a class="update-profileimg" onclick="uploadModal();"><i class="fa fa-camera" aria-hidden="true"></i>&nbsp;Upload Your Profile</a>

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



        <div class="Chery2">

          <?php 

          $userData = $this->session->userdata();

          $uemail = $userData['userData']['email'];

          $uname = $userData['userData']['firstname']." ".$userData['userData']['lastname'];

          ?>

          <input type="hidden" id="uname" value="<?php echo $uname;?>">

          <input type="hidden" id="uemail" value="<?php echo $uemail;?>">

          <h2><?php if(!empty($user_data->business_name)) { echo $user_data->business_name; } ?> </h2>

          <p><?php

//if(!empty($user_data->business_address)){ echo $user_data->business_address; }

          $address = array();

          if(isset($user_data->business_address) && !empty($user_data->business_address))

            $address[] = $user_data->business_address;

          if(isset($user_data->city) && !empty($user_data->city))

            $address[] = trim($user_data->city);

          if(isset($user_data->state) && !empty($user_data->state))

            $address[] = trim($user_data->state);

          if(isset($user_data->country) && !empty($user_data->country))

            $address[] = trim($user_data->country);

          if(isset($user_data->zip) && !empty($user_data->zip))

            $address[] = trim($user_data->zip);

          if(!empty($address)){

            $address = implode(", ", $address);

            echo $address;

          }

          ?>

        </p>



        <li class="his_img extr nav-item mbdshow7">

          <a class="nav-link" data-toggle="tab" href="#menu5">

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



          <?php if(!empty($user_data->phone)) {   ?>

            <div class="callno col_chn">

              <i class="fa fa-phone"></i>

              <a class="OnClrX" href="tel:(707)500-8711"></a><?php echo $user_data->phone; ?></a> 

            </div>

          <?php  } 

          if(!empty($user_data->website_link)) {



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

}





?>

<div class="callno col_chn">

  <i class="fa fa-link"></i>

  <a href="<?php echo $urls; ?>" target="_blank" class="OnClrX"><?php echo $user_data->website_link; ?> </a>

</div>

<?php  } ?>

<div class="callno col_chn">

  <i class="fa fa-envelope"></i>

  <a href="mailto:<?php echo $user_data->email; ?>" class="OnClrX"><?php echo $user_data->email; ?> </a>

</div>

<!--  <div class="current">

<p class="fl_lft">Current  - </p>

<span class="Paul">Paul Wayne Haggerty Road New Orleans

<img src="images/star3.png">

</span>

</div> -->



</div>

</div>

</div>

</div>

</section>





<div class="only_mobileSo">

  <div class="mypbusinessopen">

    <span></span>

    <span></span>

    <span></span>

  </div>

  <div class="proileLeftopens">

    <ul class="nav nav-tabs">



      <li class="his_img extr nav-item" data-link="my_account">

        <a class="nav-link " data-toggle="tab" href="#menu1">

          <div class="his_img">

            <i class="fa fa-file"></i>

            <!--    <img src="<?php echo base_url();?>assets/images/h8.png"> -->

          </div>

          My Account 

        </a>

      </li>





      <li class="his_img <?php if($this->session->userdata('request_redirect')||$this->session->userdata('my_tasks')){}else{echo 'active';} ?> extr nav-item" onclick="getPosT('community');">

        <a class="nav-link" data-toggle="tab" href="#menuo">

          <div class="his_img">

            <img src="<?php echo base_url();?>assets/images/h2.png">

          </div>

          My Profile

        </a>

      </li>





      <li class="his_img extr nav-item" onclick="getPosT('highlights');" data-link="community">

        <a class="nav-link" data-toggle="tab" href="#menuo1">

          <div class="his_img">

            <img src="<?php echo base_url();?>assets/images/h2.png">

          </div>

          My Community

        </a>

      </li>





      <li class="his_img extr nav-item">

        <a class="nav-link <?php if($this->session->userdata('request_redirect')){echo 'active';}else{} ?>" data-toggle="tab" href="#menu2">

          <!--   <li class="his_img extr"> -->

            <div class="his_img">

              <i class="fa fa-users"></i>

              <!--   <img src="<?php echo base_url();?>assets/images/h10.png"> -->

            </div>Employees <!-- <span class="2_green"><?php if(!empty($pendingRequest)){ echo count($pendingRequest); } ?></span> -->

            <span class="2_green"><?php  if(!empty($allEmployee)){ echo count($allEmployee); }else{ echo 0;} ?></span>

            <!--     </li> -->

          </a>

        </li>





        <li class="his_img extr nav-item" data-link="ablum_doc">

          <a class="nav-link" data-toggle="tab" href="#menu3">

            <!--   <li class="his_img extr"> -->

              <div class="his_img">

                <img src="<?php echo base_url();?>assets/images/h3.png">

              </div>

              Albums / Documents

              <!-- </li> -->

            </a>

          </li>





          <li class="his_img extr nav-item">

            <a class="nav-link" href="<?php echo site_url('user/message') ?>">

              <!--   <li class="his_img extr"> -->

                <div class="his_img">

                  <img src="<?php echo base_url();?>assets/images/h6.png">

                </div>

                Messages

                <!-- </li> -->

              </a>

            </li>

            <li class="his_img extr nav-item">
                  <a class="nav-link <?php if($this->session->userdata('my_tasks')){echo 'active';}else{} ?>" data-toggle="tab" href="#mytask">
                     <div class="his_img">
                        <i class="fa fa-check-square" aria-hidden="true"></i>
                     </div>
                     
                     Tasks
                  </a>
               </li>


            <li class="his_img extr nav-item">

              <a class="nav-link" data-toggle="tab" href="#menu5">

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

                <a class="nav-link" href="<?php echo site_url(); ?>logout">

                  <div class="his_img">

                    <img src="<?php echo base_url();?>assets/images/h9.png">

                  </div>

                  Logout

                </a>

              </li>



            </ul>

          </div>

        </div>













        <!--profil close-->

        <section class="history" id="MclickInsX">

          <div class="container">

            <div class="row">

              <!--tab list start-->

              <div class="col-md-3 col-12 pl_inlft"> 

                <div class="icon_fclick Xmobilenone">

                  <span></span>

                  <span></span>

                  <span></span>

                  <span></span>

                </div>

                <div class="history_cont">

                  <ul class="nav nav-tabs">



                    <li class="his_img extr nav-item" data-link="my_account">

                      <a class="nav-link " data-toggle="tab" href="#menu1">

                        <div class="his_img">

                          <i class="fa fa-file"></i>

                          <!--    <img src="<?php echo base_url();?>assets/images/h8.png"> -->

                        </div>

                        My Account 

                      </a>

                    </li>





                    <li class="his_img <?php if($this->session->userdata('request_redirect')||$this->session->userdata('my_tasks')){}else{echo 'active';} ?> extr nav-item" onclick="getPosT('community');">

                      <a class="nav-link" data-toggle="tab" href="#menuo">

                        <div class="his_img">

                          <img src="<?php echo base_url();?>assets/images/h2.png">

                        </div>

                        My Profile

                      </a>

                    </li>



                    <li class="his_img extr nav-item" onclick="getPosT('highlights');" data-link="community">

                      <a class="nav-link" data-toggle="tab" href="#menuo1">

                        <div class="his_img">

                          <img src="<?php echo base_url();?>assets/images/h2.png">

                        </div>

                        My Community

                      </a>

                    </li>





                    <li class="his_img extr nav-item">

                      <a class="nav-link <?php if($this->session->userdata('request_redirect')){echo 'active';}else{} ?>" data-toggle="tab" href="#menu2">

                        <!--   <li class="his_img extr"> -->

                          <div class="his_img">

                            <i class="fa fa-users"></i>

                            <!--   <img src="<?php echo base_url();?>assets/images/h10.png"> -->

                          </div>Employees <!-- <span class="2_green"><?php if(!empty($pendingRequest)){ echo count($pendingRequest); } ?></span> -->

                          <span class="2_green"><?php  if(!empty($allEmployee)){ echo count($allEmployee); }else{ echo 0;} ?></span>

                          <!--     </li> -->

                        </a>

                      </li>





                      <li class="his_img extr nav-item" data-link="ablum_doc">

                        <a class="nav-link" data-toggle="tab" href="#menu3">

                          <!--   <li class="his_img extr"> -->

                            <div class="his_img">

                              <img src="<?php echo base_url();?>assets/images/h3.png">

                            </div>

                            Albums / Documents

                            <!-- </li> -->

                          </a>

                        </li>





                        <li class="his_img extr nav-item">

                          <a class="nav-link" href="<?php echo site_url('user/message') ?>">

                            <!--   <li class="his_img extr"> -->

                              <div class="his_img">

                                <img src="<?php echo base_url();?>assets/images/h6.png">

                              </div>

                              Messages

                              <!-- </li> -->

                            </a>

                          </li>
                          <li class="his_img extr nav-item">
                            <a class="nav-link <?php if($this->session->userdata('my_tasks')){echo 'active';}else{} ?>" data-toggle="tab" href="#mytask">
                              <div class="his_img">
                                <i class="fa fa-check-square" aria-hidden="true"></i>
                              </div>
                              Tasks
                            </a>
                          </li>


                          <li class="his_img extr nav-item mbdNone7">

                            <a class="nav-link" data-toggle="tab" href="#menu5">

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

                              <a class="nav-link" href="<?php echo site_url(); ?>logout">

                                <div class="his_img">

                                  <img src="<?php echo base_url();?>assets/images/h9.png">

                                </div>

                                Logout

                              </a>

                            </li>



                          </ul>

                        </div>

                      </div>

                      <!--==tab list close=====-->

                      <!--tab main contant start-->





                      <div class="col-md-9 col-12">

                        <div class="tab-content">   

                          <!--bussiness profile pages tab link start--> 



                          <!--profile edit pages tab link strat--> 

                          <div class="tab-pane container" id="menu1">

                            <!-- <div class="tab-pane container active show" id="homeover"> -->

                         

</div>

<!-- overwiew start-->

<!--profile edit pages tab link close--> 







<input type="hidden" id="base_url" value="<?php echo base_url() ?>">



<!--bussiness profile pages tab link close--> 

<!-- overwiew start-->

<div class="tab-pane container <?php if($this->session->userdata('request_redirect')||$this->session->userdata('my_tasks')){}else{echo 'active';} ?>" id="menuo">

  <?php 

  if($this->session->flashdata('updatemsg')){ ?>

    

    <?php echo $this->session->flashdata('updatemsg');?>

    

  <?php }

  ?>

  <!-- <div class="tab-pane container active show" id="homeover"> -->

    <div class="row">

      <div class="col-md-8 full_fillBx">

        <div class="main_with over">

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

            <?php 

            $imgsert='';

            if(!empty($posts_details['result'])){ $md = 0; foreach($posts_details['result'] as $post){ $md++; ?> 

              

              <div class="main_blog post-id" id="<?php echo $post->id; ?>" data-uid="<?php echo get_current_user_id(); ?>">



                <?php if($post->post_image!=""){

                  $imgsert=$post->post_image;

                  $postimgarr=explode(',',$imgsert);

                  if(count($postimgarr)>1){ ?>

                    <div class = "row pdbothS">

                      <?php foreach($postimgarr as $postim){ ?>

                        <div class = "col-sm-3 col-md-3 thumb_upx2">

                          <!-- <a href = "#" class = "thumbnail" data-toggle="modal" data-target="#myModal00<?php echo $md; ?>">

                            <img src = "<?php echo $postim; ?>" alt= "Post Image">

                          </a> -->

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

                   <!--  <div class="over_viewimg" data-fancybox="gallery111<?php echo $md; ?>">

                      <img src="<?php echo $imgsert; ?>" class="img-fluid">

                      <div class="bl-box">

                        <img src="<?php echo base_url();?>assets/images/scrl.png">

                      </div>

                    </div> -->

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

                        <video width="320" height="240" controls class="videos">

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

                              <?php //if($post->post_video==''){ ?>

                                <a href="#" class="linke" data-toggle="modal" data-target="#sharePostModal<?php echo $md; ?>"><img src="<?php echo base_url();?>assets/images/share.png">

                                  <i class="fa fa-thumbs-up"></i>

                                </a>

                              <?php //} ?>

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

                                          <a href="javascript:void(0)" class="PIXLRIT1" onclick="publish(<?php echo $video ?>,'<?php echo $name. ' status'; ?>','<?php echo $urlP;?>');" target="_blank">

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

?>    </p>

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

<div class="col-md-4 col-12"> 

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



  <!-- work_advisor_business2 -->

  <!-- <ins class="adsbygoogle"

  style="display:block"

  data-ad-client="ca-pub-3979824042791728"

  data-ad-slot="7785372281"

  data-ad-format="auto"

  data-full-width-responsive="true"></ins>

  <script>

    (adsbygoogle = window.adsbygoogle || []).push({});

  </script> -->





  <!--================ NEW functionality ============-->

  <div class="wa-calendarother">

    <input type="text" class="simpleflatepicker" data-input>

    <p><button class="onlymainbtn taskAdd" data-toggle="modal" data-target="#addtasks">Add Task</button></p>
    <div class="list-takss">
      <h4>Task list</h4>
      <ul>
        <?php if(!empty($taskList['result'])){ 
          foreach($taskList['result'] as $task){ ?>
            <li>
              <i class="fa fa-circle" aria-hidden="true" >
              </i> <span data-toggle="modal" data-target="#addtasks" data-task_id="<?php echo $task->id;?>" class="taskEdits"><?php echo ucfirst($task->title);?> </span>
            <!--   <a data-toggle="modal" data-target="#addtasks" data-task_id="<?php echo $task->id;?>" class="taskEdits">
                <img src="https://www.workadvisor.co/assets/images/edit.png">
              </a> -->
             <!--  <a href="" class="editss" data-toggle="modal" data-target="#modalDelete" onclick="setID(<?php echo $task->id;?>,'<?php echo TASK;?>');"> -->
                <i class="fa fa fa-trash-o"></i>
              </a>
            </li>
          <?php }
        }else{
          echo '<li><i class="fa fa-circle" aria-hidden="true">
              </i> No task found</li>';
        } ?>
      </ul>
    </div>
  </div> 

  <!--================ NEW functionality ============-->





</div>

<!--progresh bar close-->

</div>

</div>

<!-- overwiew start-->









<!-- overwiew start-->

<div class="tab-pane container" id="menuo1">



</div>

<!-- overwiew start-->

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





<!--second tab link start--> 

<div class="tab-pane container  <?php if($this->session->userdata('request_redirect')){echo 'active';}else{} ?>" id="menu2">

  <div class="main_div_width">

    <div class="row">

      <h2 class="Cher mediapdl">Employee Requests</h2>

      <?php

      if(!empty($pendingRequest)){ $a=0; foreach($pendingRequest as $req){ $a++;

        $userProfileUrl = site_url('viewdetails/profile/'.encoding($req['id']));

        ?>

        <div class="col-md-3 col-12" id="<?php echo 'FR'.$req['id']; ?>">

          <a href="#">

            <div class="jerry">

              <h1><?php echo $req['firstname'].' '.$req['lastname']; ?></h1>

              <a href="<?php echo $userProfileUrl; ?>">

                <div class="cat_img">

                  <img src="<?php echo (!empty($req['profile']))? $req['profile']:DEFAULT_IMAGE; ?>" alt="<?php echo $req['firstname'].' '.$req['lastname']; ?>" alt="<?php echo $req['firstname'].' '.$req['lastname']; ?>">     

                </div>

              </a>

              <p><?php echo trim($req['city']).', '.trim($req['state']).', '.trim($req['country']); ?></p>

              <p>

                <button class="btn btn-sm btn-success" onclick="jobRequest('<?php echo encoding($req['id']); ?>','Accept','<?php echo 'FR'.$req['id']; ?>',this)">Accept</button>

                &nbsp; <button class="btn btn-sm btn-danger" onclick="jobRequest('<?php echo encoding($req['id']); ?>','Reject','<?php echo 'FR'.$req['id']; ?>',this)">Reject</button>

              </p>

              <!-- <img src="<?php echo base_url();?>assets/images/s4.png" class="star_img2"> -->

              <?php

              $ratingData =  userOverallRatings($req['id']);

              if(isset($ratingData['starRating'])){

                echo preg_replace("/\([^)]+\)/","",$ratingData['starRating']);

              }?>

            </div>

          </a>

        </div> 

        <?php if($a%4==0){?> 

        </div>

        <div class="row mar_tp"> <?php } } } ?>



      </div>

      <div class="col-md-5 col-sm-5 col-12  float-right">

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



<!-------------

<div class="row mar_tp">

<div class="col-md-4 col-12">

<ul class="pagination">

<li class="page-item"><a class="page-link b_chn" href="#">1</a></li>

<li class="page-item"><a class="page-link" href="#">2</a></li>

<li class="page-item"><a class="page-link" href="#">3</a></li>

<li class="page-item"><a class="page-link" href="#">4</a></li>

<li class="page-item"><a class="page-link" href="#">5</a></li>

<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-double-right"></i></a></li>

</ul> 

</div> 

</div>

---------------->



<!--pagination row close-->

<div class="bor_btm"></div>

<div class="row mar_tp">

  <h2 class="Cherall_e_fits">All Employees</h2>

  <?php

  if(!empty($allEmployee)){ $a=0; foreach($allEmployee as $frie){ $a++;

    $userProfileUrl1 = site_url('viewdetails/profile/'.encoding($frie['id']));

    ?>

    <div class="col-md-3 col-12" id="<?php echo 'AF'.$frie['id']; ?>">

      <div class="jerry">

        <h1><?php echo $frie['firstname'].' '.$frie['lastname']; ?></h1>

        <a href="<?php echo $userProfileUrl1; ?>">

          <div class="cat_img">

            <img src="<?php echo (!empty($frie['profile']))? $frie['profile']:DEFAULT_IMAGE; ?>" alt="<?php echo $frie['firstname'].' '.$frie['lastname']; ?>">

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

        ?>                                  

      </p>



      <p>

        <button class="btn btn-sm btn-warning" onclick="jobRequest('<?php echo encoding($frie['id']); ?>','Unfriend','<?php echo 'AF'.$frie['id']; ?>',this)" >Remove</button>

        &nbsp;

        <button class="btn btn-sm btn-danger" onclick="jobRequest('<?php echo encoding($frie['id']); ?>','Block','<?php echo 'AF'.$frie['id']; ?>',this)">Block</button>

      </p>

      <!-- <img src="<?php echo base_url();?>assets/images/s4.png" class="star_img2"> -->

      <?php

      $ratingData =  userOverallRatings($frie['id']);

      if(isset($ratingData['starRating'])){

        echo preg_replace("/\([^)]+\)/","",$ratingData['starRating']);

      }?>

    </div>

  </div> 

  <?php if($a%4==0){?> </div><div class="row mar_tp"> <?php } } } ?>

</div>

<!--tab-content close-->

</div> 

</div>

<!--second tab link close--> 





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

        <input type="text" class="form-control" name="rename_folder" id="rename_folder">

        <input type="hidden" class="form-control" name="folder_id" id="folder_id">

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





<!--====================first tab link close=====================--> 



<!--second tab link start--> 

<div class="tab-pane container" id="menu6">

<!--  <div class="main_div_width">

<div class="row">



<div class="col-md-3 col-12">

<a href="#">

<div class="jerry">

<h1>Jerry  Smith</h1>

<div class="cat_img">

<img src="images/cat.png">

</div>

<p>3401 Cedar Lane</p>

<img src="images/s4.png" class="star_img2">

</div>

</a>

</div> 



<div class="col-md-3 col-12">

<a href="#">

<div class="jerry">

<h1>Jerry  Smith</h1>

<div class="cat_img">

<img src="images/cat.png">

</div>

<p>3401 Cedar Lane</p>

<img src="images/s4.png" class="star_img2">

</div>

</a>

</div>



<div class="col-md-3 col-12">

<a href="#">

<div class="jerry">

<h1>Jerry  Smith</h1>

<div class="cat_img">

<img src="images/cat.png">

</div>

<p>3401 Cedar Lane</p>

<img src="images/s4.png" class="star_img2">

</div>

</a>

</div>



<div class="col-md-3 col-12">

<a href="#">

<div class="jerry">

<h1>Jerry  Smith</h1>

<div class="cat_img">

<img src="images/cat.png">

</div>

<p>3401 Cedar Lane</p>

<img src="images/s5.png" class="star_img2">

</div>

</a>

</div>

</div>



<div class="row mar_tp">



<div class="col-md-3 col-12">

<a href="#">

<div class="jerry">

<h1>Jerry  Smith</h1>

<div class="cat_img">

<img src="images/cat.png">

</div>

<p>3401 Cedar Lane</p>

<img src="images/s5.png" class="star_img2">

</div>

</a>

</div> 



<div class="col-md-3 col-12">

<a href="#">

<div class="jerry">

<h1>Jerry  Smith</h1>

<div class="cat_img">

<img src="images/cat.png">

</div>

<p>3401 Cedar Lane</p>

<img src="images/s10.png" class="star_img2">

</div>

</a>

</div>



<div class="col-md-3 col-12">

<a href="#">

<div class="jerry">

<h1>Jerry  Smith</h1>

<div class="cat_img">

<img src="images/cat.png">

</div>

<p>3401 Cedar Lane</p>

<img src="images/s10.png" class="star_img2">

</div>

</a>

</div>



<div class="col-md-3 col-12">

<a href="#">

<div class="jerry">

<h1>Jerry  Smith</h1>

<div class="cat_img">

<img src="images/cat.png">

</div>

<p>3401 Cedar Lane</p>

<img src="images/s10.png" class="star_img2">

</div>

</a>

</div>

</div>



<div class="row mar_tp">



<div class="col-md-4 col-12">

<ul class="pagination">

<li class="page-item"><a class="page-link b_chn" href="#">1</a></li>

<li class="page-item"><a class="page-link" href="#">2</a></li>

<li class="page-item"><a class="page-link" href="#">3</a></li>

<li class="page-item"><a class="page-link" href="#">4</a></li>

<li class="page-item"><a class="page-link" href="#">5</a></li>

<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-double-right"></i></a></li>

</ul> 



</div> 



</div>





<!-pagination row close-->

<!-- <div class="bor_btm"></div>

<div class="row mar_tp">

<h2 class="Cher">Suggested Friends</h2>

<div class="col-md-3 col-12">

<a href="#">

<div class="jerry">

<h1>Donna</h1>

<div class="cat_img">

<img src="images/g1.png">

</div>

<p>3401 Cedar Lane</p>

<img src="images/s10.png" class="star_img2">

</div>

</a>

</div> 



<div class="col-md-3 col-12">

<a href="#">

<div class="jerry">

<h1>Robert</h1>

<div class="cat_img">

<img src="images/g3.png">

</div>

<p>3401 Cedar Lane</p>

<img src="images/s10.png" class="star_img2">

</div>

</a>

</div>



<div class="col-md-3 col-12">

<a href="#">

<div class="jerry">

<h1>Richard</h1>

<div class="cat_img">

<img src="images/g2.png">

</div>

<p>3401 Cedar Lane</p>

<img src="images/s10.png" class="star_img2">

</div>

</a>

</div>



<div class="col-md-3 col-12">

<a href="#">

<div class="jerry">

<h1>David Glasgow</h1>

<div class="cat_img">

<img src="images/cat.png">

</div>

<p>3401 Cedar Lane</p>

<img src="images/s10.png" class="star_img2">

</div>

</a>

</div>

</div>



</div>   -->

</div>

<!--second tab link close--> 





<!--third tab link strat--> 

<!--<div class="tab-pane container" id="menu3">

<div class="row">

<div class="col-md-8 col-12"> 



<div class="row">





<div class="col-md-4 col-12">

<a href="#">

<div class="jerry">

<h1>Kingsport</h1>

<div class="cat_img photss">

<img src="<?php echo base_url();?>assets/images/p1.png">

<div class="atin_photos">

<a href="" class="bod_btm">18 Photos</a><br>

<a href="" class="bod_btm">3 Videos</a>

</div>

</div>

<div class="jhiga">

<span>Cassandra M. Figueroa</span>

<div class="pho_cnt">

<div class="photos1">

<img src="<?php echo base_url();?>assets/images/ph.png">

</div>

<a href="" class="bod_btm">8 videos</a>

</div>

<div class="pho_cnt">

<div class="photos1 mar_lft">

<img src="<?php echo base_url();?>assets/images/v.png">

</div>

<a href="" class="bod_btm">8 videos</a>

</div>

</div>

</div>

</a>

</div> 



<div class="col-md-4 col-12">

<a href="#">

<div class="jerry">

<h1>Kingsport</h1>

<div class="cat_img photss">

<img src="<?php echo base_url();?>assets/images/p1.png">

<div class="atin_photos">

<a href="" class="bod_btm">18 Photos</a><br>

<a href="" class="bod_btm">3 Videos</a>

</div>

</div>

<div class="jhiga">

<span> Cassandra M. Figueroa</span>

<div class="pho_cnt">

<div class="photos1">

<img src="<?php echo base_url();?>assets/images/ph.png">

</div>

<a href="" class="bod_btm">8 videos</a>

</div>

<div class="pho_cnt">

<div class="photos1 mar_lft">

<img src="vimages/v.png">

</div>

<a href="" class="bod_btm">8 videos</a>

</div>

</div>

</div>

</a>

</div> 



<div class="col-md-4 col-12">

<a href="#">

<div class="jerry">

<h1>Kingsport</h1>

<div class="cat_img photss">

<img src="<?php echo base_url();?>assets/images/p1.png">

<div class="atin_photos">

<a href="" class="bod_btm">18 Photos</a><br>

<a href="" class="bod_btm">3 Videos</a>

</div>

</div>

<div class="jhiga">

<span> Cassandra M. Figueroa</span>

<div class="pho_cnt">

<div class="photos1">

<img src="<?php echo base_url();?>assets/images/ph.png">

</div>

<a href="" class="bod_btm">8 videos</a>

</div>

<div class="pho_cnt">

<div class="photos1 mar_lft">

<img src="<?php echo base_url();?>assets/images/v.png">

</div>

<a href="" class="bod_btm">8 videos</a>

</div>

</div>

</div>

</a>

</div> 





<div class="col-md-4 col-12">

<a href="#">

<div class="jerry">

<h1>Kingsport</h1>

<div class="cat_img photss">

<img src="<?php echo base_url();?>assets/images/p1.png">

<div class="atin_photos">

<a href="" class="bod_btm">18 Photos</a><br>

<a href="" class="bod_btm">3 Videos</a>

</div>

</div>

<div class="jhiga">

<span> Cassandra M. Figueroa</span>

<div class="pho_cnt">

<div class="photos1">

<img src="<?php echo base_url();?>assets/images/ph.png">

</div>

<a href="" class="bod_btm">8 videos</a>

</div>

<div class="pho_cnt">

<div class="photos1 mar_lft">

<img src="<?php echo base_url();?>assets/images/v.png">

</div>

<a href="" class="bod_btm">8 videos</a>

</div>

</div>

</div>

</a>

</div> 





<div class="col-md-4 col-12">

<a href="#">

<div class="jerry">

<h1>Kingsport</h1>

<div class="cat_img photss">

<img src="<?php echo base_url();?>assets/images/p1.png">

<div class="atin_photos">

<a href="" class="bod_btm">18 Photos</a><br>

<a href="" class="bod_btm">3 Videos</a>

</div>

</div>

<div class="jhiga">

<span> Cassandra M. Figueroa</span>

<div class="pho_cnt">

<div class="photos1">

<img src="<?php echo base_url();?>assets/images/ph.png">

</div>

<a href="" class="bod_btm">8 videos</a>

</div>

<div class="pho_cnt">

<div class="photos1 mar_lft">

<img src="<?php echo base_url();?>assets/images/v.png">

</div>

<a href="" class="bod_btm">8 videos</a>

</div>

</div>

</div>

</a>

</div> 



<div class="col-md-4 col-12">

<a href="#">

<div class="jerry">

<h1>Kingsport</h1>

<div class="cat_img photss">

<img src="<?php echo base_url();?>assets/images/p1.png">

<div class="atin_photos">

<a href="" class="bod_btm">18 Photos</a><br>

<a href="" class="bod_btm">3 Videos</a>

</div>

</div>



<div class="jhiga">

<span> Cassandra M. Figueroa</span>

<div class="pho_cnt">

<div class="photos1">

<img src="<?php echo base_url();?>assets/images/ph.png">

</div>

<a href="" class="bod_btm">8 videos</a>

</div>

<div class="pho_cnt">

<div class="photos1 mar_lft">

<img src="<?php echo base_url();?>assets/images/v.png">

</div>

<a href="" class="bod_btm">8 videos</a>

</div>

</div>



</div>

</a>

</div> 

</div>



</div>



<div class="col-md-4 col-12"> 

<div class="progrs">

<h1>Performace</h1>

<div class="bar-one bar-con">

<span class="quntit">10</span>

<div class="bar" data-percent="20" style="width: 20%;"></div>

<span class="star_rigth">5&nbsp;&nbsp;stars</span>

</div>



<div class="bar-one bar-con">

<span class="quntit">20</span>

<div class="bar blkue" data-percent="20" style="width: 20%;"></div>

<span class="star_rigth">4&nbsp;&nbsp;stars</span>

</div>

<div class="bar-one bar-con">

<span class="quntit">5</span>

<div class="bar blkue_chnc" data-percent="20" style="width: 20%;"></div>

<span class="star_rigth">3&nbsp;&nbsp;stars</span>

</div>

<div class="bar-one bar-con">

<span class="quntit">4</span>

<div class="bar blkue_red" data-percent="20" style="width: 20%;"></div>

<span class="star_rigth">2&nbsp;&nbsp;stars</span>

</div>



<div class="bar-three bar-con">

<span class="quntit">15</span>

<div class="bar blkue_yellow" data-percent="70" style="width: 70%;"></div>

<span class="star_rigth">1&nbsp;&nbsp;stars</span>

</div> 

</div>



<div class="Qr-code">

<p> QR Code</p>

<a href="#">

<img src="images/code.png">

</a>

</div>

</div>



</div> 

</div>-->
      <div class="tab-pane container <?php if($this->session->userdata('my_tasks')){echo 'active';}else{} ?>" id="mytask">
         <div class="row">
          <div class="col-md-12">
            <h3>Tasks</h3>
        </div>
         </div>
         <div class="main_blog wa-mytasks">
         <table class="tableData table table-bordered table-responsive">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Title</th>
                  <th>Assigned To</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
               </tr>
            </thead>
            <tbody>
              <?php
                if(!empty($taskListAssigned['result'])){
                  $sno=0;
                  foreach($taskListAssigned['result'] as $task){
                  $sno++; ?>
                    <tr>
                      <td><?php echo $sno;?></td>
                      <td><a class="myTaskList" data-toggle="modal" data-target="#addtasksfill" data-mytask_id="<?php echo $task->task_id;?>" data-assigned_to="<?php echo $task->user_id;?>" data-notification="0"><?php echo ucfirst($task->title);?></a></td>
                      <td><?php echo ucwords($task->firstname.' '.$task->lastname);?></td>
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
<div class="tab-pane container" id="menu3">

  <div class="row">

    <div class="col-md-8 col-12 full_fillBx"> 



      <div class="bx_shdImg">

        <h5>Albums  &nbsp;<span class="albums_businessprofile"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h5>

        <!--start row--> 

        <div class="row albums">



                                    </div>

                                    <!-- </div> -->



                                    <!-- <div class="bor_btm"></div> -->

                                    <div class="row mar_tp">

                                      <div class="col-md-12">



                                        <h2 class="Cher">Document-Files  &nbsp;<span class="doc_files"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h2>

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

<!--  <select id="view_type" name="view_type">

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

<div id="fileSuccess" class="grid">

  <div id="fileSuccessmain">

    <?php 



    $html='';

    /* html of directory */

    if(!empty($albumFolderData)) {

      foreach($albumFolderData['result'] as $folderDatas) {

        $checked11 = '';

        $checked22 = '';

        $checked33 = '';

        if($folderDatas->dir_view_type == 3){

          $checked33 = 'checked=checked';

        } else if($folderDatas->dir_view_type == 2){

          $checked22 = 'checked=checked';

        } else{

          $checked11 = 'checked=checked';

        } 

        $inverted = "&#39;";

        $html.='

        <div class="col-md-3 col-12  documents_drag folders  '.$folderDatas->id.'" data-doc_type="folder" onclick="setIdDir('.$folderDatas->id.')"  id="'.$folderDatas->id.'">

        <div class="album_icon">

        <div onclick="enterInFolder('.$folderDatas->id.','.get_current_user_id().',&#39;&#39;,'.$inverted.$folderDatas->dir_name.$inverted.')"">

        <div class="jerry documents_drag_folder" data-fid="'.$folderDatas->id.'" data-doc_type="folder">

        <div class="cat_img but_imgsize">

        <img src="'.base_url().'/assets/images/folder_image.png">

        </div><span class="Zdoc_content">'.$folderDatas->dir_name.'</span></div>

        </div>





        <p>

        <input class="view_type" type="radio" value="1" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'"  data-vid="'.$folderDatas->id.'" '.$checked11.' data-views="folders">Public

        </p>

        <p>

        <input class="view_type" type="radio" value="2" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked22.' data-vid="'.$folderDatas->id.'" data-views="folders">Private

        </p>

        <p>

        <input class="view_type" type="radio" value="3" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked33.' data-vid="'.$folderDatas->id.'" data-views="folders" data-views="folders">Employee</p>



        </div>

        </div>

        '; 

      }

    }

//$albumFolderData['result'];

    /* html of directory end */



    if(!empty($albumData['result'])){

      $image ='';

      foreach($albumData['result'] as $row){

        $checked1 = '';

        $checked2 = '';

        $checked3 = '';

        if($row->view_type == 3){

          $checked3 = 'checked=checked';

        }

        else if($row->view_type == 2){

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

        <div class="col-md-3 col-12 documents_drag file_'.$row->id.'" data-doc_type="file" id="'.$row->id.'" onclick="setID('.$row->id.');">

        <div class="album_icon">

        <a href="'.base_url().$row->albums.'" >

        <div class="jerry documents_drag_file" data-fid="'.$row->id.'" data-doc_type="file">

        <div class="cat_img but_imgsize">

        <img src="'.$image.'">

        </div><div class="this_is_N">'.$row->name.'</div></div>

        </a>



        <p>

        <input class="view_type" type="radio" value="1" name="view_'.$row->id.'" id="view_'.$row->id.'"  data-vid="'.$row->id.'" '.$checked1.' data-views="files">Public</p>

        <p>

        <input class="view_type" type="radio" value="2" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked2.' data-vid="'.$row->id.'" data-views="files">Private</p>

        <p>

        <input class="view_type" type="radio" value="3" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked3.' data-vid="'.$row->id.'" data-views="files">Employee</p>

        </div>

        </div>

        ';

      }

    } 

    echo $html; ?>

  </div>

  <div id="fileSuccessDir">

  </div>

</div>

</div>

</div>

</div>

</div>

<div class="col-md-4 col-12"> 



  <div class="Qr-code">

    <p> QR Code</p>

    <p>Scan My Code</p>

    <a href="#" id="qrCodeImg">

      <!-- <img src="<?php echo base_url();?>assets/images/code.png"> -->

      <img class="qr_code1" src="<?php echo isset($qr_image)?$qr_image:'';?>">

    </a>

    <input type="button" class="btn btn-info" id="btnPrint" value="Click To Print"><span class="qrCodeQuestion"><i class="fa fa-question-circle" aria-hidden="true"></i></span>

  </div>

  <br/>

  <br/>

  <!-- work_advisor_business3 -->

<!--   <ins class="adsbygoogle"

  style="display:block"

  data-ad-client="ca-pub-3979824042791728"

  data-ad-slot="9321815238"

  data-ad-format="auto"

  data-full-width-responsive="true"></ins>

  <script>

    (adsbygoogle = window.adsbygoogle || []).push({});

  </script> -->

</div>



</div> 

</div>

<!--third tab link close--> 



<!--third tab link strat--> 

<!-- <div class="tab-pane container" id="menu4">

<div class="row">

<div class="col-md-7 col-12">

<div class="chat_box">





<div class="fil_ds">

<div class="pro_img">

<img src="<?php echo base_url();?>assets/images/cht.png">

</div>

<div class="msg_bx">Donec pede justo, fringilla vel</div>

<span class="date">

12:06

</span>

</div>

<div class="fil_ds wid_ri">

<span class="date">

12:06

</span>

<div class="msg_bx bg_chng">Etiam sit amet orci eget eros faucibus </div>



<div class="pro_img">

<img src="<?php echo base_url();?>assets/images/chtg.png">

</div>

</div>











<div class="form-group">

<textarea class="form-control tetx_bx"  placeholder="Type Something ...">

</textarea>

<a href="#"><div class="icon_shap">

<img src="<?php echo base_url();?>assets/images/m1.png">

<img src="<?php echo base_url();?>assets/images/m2.png">

</div>

</a>

<button type="submit" class="sandss">

Sand

</button>

</div>

</div>









</div>









<div class="col-md-5 col-12">

<div class="serch_profile">

<form>

<div class="form-group">

<input type="search" name="search" class="form-control prile" placeholder="Search">

<img src="<?php echo base_url();?>assets/images/shrc.png" class="po_right">

</div>

<ul>

<li>

<div class="pro_img">

<img src="<?php echo base_url();?>assets/images/Jaime.png">

</div>

<div class="pro_img comt">

<h1>Nikolaj Coster</h1>

<p>Are you free to talk?</p>

</div>

<div class="pro_img fl_ri">

<span class="cuircl"> 12:30</span>

<span class="cuircl2">2</span>

</div>

</li>



<li>

<div class="pro_img">

<img src="<?php echo base_url();?>assets/images/Jaime1.png">

</div>

<div class="pro_img comt">

<h1>Nikolaj Coster</h1>

<p>Are you free to talk?</p>

</div>

<div class="pro_img fl_ri">

<span class="cuircl"> 12:30</span>

<span class="cuircl2">3</span>

</div>

</li>



<li>

<div class="pro_img">

<img src="<?php echo base_url();?>assets/images/Jaime.png">

</div>

<div class="pro_img comt">

<h1>Nikolaj Coster</h1>

<p>Are you free to talk?</p>

</div>

<div class="pro_img fl_ri">

<span class="cuircl"> 12:30</span>

<span class="cuircl2">1</span>

</div>

</li>



<li>

<div class="pro_img">

<img src="<?php echo base_url();?>assets/images/Jaime1.png">

</div>

<div class="pro_img comt">

<h1>Nikolaj Coster</h1>

<p>Are you free to talk?</p>

</div>

<div class="pro_img fl_ri">

<span class="cuircl">Yesterday</span>



</div>

</li>



<li>

<div class="pro_img">

<img src="<?php echo base_url();?>assets/images/Jaime.png">

</div>

<div class="pro_img comt">

<h1>Nikolaj Coster</h1>

<p>Are you free to talk?</p>

</div>

<div class="pro_img fl_ri">

<span class="cuircl"> 10.09.2014</span>



</div>

</li>



<li>

<div class="pro_img">

<img src="<?php echo base_url();?>assets/images/Jaime1.png">

</div>

<div class="pro_img comt">

<h1>Nikolaj Coster</h1>

<p>Are you free to talk?</p>

</div>

<div class="pro_img fl_ri">

<span class="cuircl"> 10.09.2014</span>



</div>

</li>



<li>

<div class="pro_img">

<img src="<?php echo base_url();?>assets/images/Jaime.png">

</div>

<div class="pro_img comt">

<h1>Nikolaj Coster</h1>

<p>Are you free to talk?</p>

</div>

<div class="pro_img fl_ri">

<span class="cuircl"> 10.09.2014</span>



</div>

</li>

</ul>







</form>  

</div>

</div>





</div>

</div> -->



<!--third tab link close--> 

</div>

</div>

</section>

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

                        <textarea name="post_content" placeholder="Share your thoughts here." class="form-control" id="post_content2"></textarea>

                        <div class="input_error_msg">Please fill this field.</div>

                      </div>

                      <div class="post_bx">

                        <div class="form-group">

                          <input class="btn btn-success btn-sm post_add" onclick="saveData('dataPost','<?php echo site_url('user/wallpost'); ?>','responseDiv','errorDivId')" value="Post" type="button">

                        </div>

                      </div>

                    </form>

                  </div>

                  <?php $this->session->set_userdata('request_redirect',''); ?>

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

  <textarea name="post_content" placeholder="Share your thoughts here." class="form-control" id="post_content3"></textarea> 

  <div class="input_error_msg">Please fill this field.</div>

</div>



<div class="post_bx">

  <div class="form-group">

    <input class="btn btn-success btn-sm" id="submit-all" value="Post" type="button">

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

<!-- The Modal edit 2 strat -->

<div class="form_popup" id="modalEdit">



</div>

<div class="modal fade" id="skills" data-backdrop="static" data-keyboard="false" >

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title">Skills</h4>

        <h5>Step 2 of 2</h5>

      </div>

      <div class="modal-body">

        <div class="card-body">

          <form  class="userprofile-form" method="post" action="<?php echo base_url()?>BusinessProfile/saveProfileData">       

            <!--second card start-->

            <div class="card">

              <div class="card-header" id="headingTwo">

                <h5 class="mb-0">

                  <div>

                    <h1 class="Basic-grn"><i class="fa fa-asterisk" aria-hidden="true"></i> Professional Skills (Enter all tags that apply to your profession for better search results)<span class="professional_qmark"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h1>

                  </div>

                </h5>

              </div>       

              <div class="row">

                <div class="col-md-12 col-12">

                  <!--new contant aad-->

                  <div id="bootstrapTagsInputForm" method="post" class="form-horizontal">

                    <div class="form-group">

                      <!-- <label class="ener-name">Professional skills</label> -->

                      <input type="text" name="newprofessional_skills" class="form-control chinput"

                      value="" data-role="tagsinput" placeholder="eg - Cook , Artist , ....">

                      <div class="ddaa extrsposin"><i class="fa fa-plus"></i></div>

                      <div class="bootstrap-tagsinput1">

                        <?php if(!empty($user_data->professional_skill)) {  

                          $skills = explode(",",$user_data->professional_skill); 

                          foreach ($skills as $skill) {

                            ?>               

                            <span class="tag label label-info"><?php echo $skill; ?>

                            <input type="hidden" name="oldprofessional_skill[]" value="<?php echo $skill; ?>">

                            <span data-role="remove" class="removetag"></span></span>               

                          <?php  } } ?>

                        </div>

                      </div>

                    </div>

                    <!--new contant close-->

                  </div>

                </div>

              </div>

              <!--second card start-->



              <!--third card start-->

              <div class="card">

                <div class="card-header" id="headingthree">

                  <h5 class="mb-0">

                    <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">

                      <h1 class="Basic-grn"><i class="fa fa-asterisk" aria-hidden="true"></i> Additional Services <span class="additional_qmark"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h1>

                    </div>

                  </h5>

                </div>



                <div class="row">

                  <div class="col-md-12 col-12">

                    <div id="bootstrapTagsInputForm" method="post" class="form-horizontal">

                      <div class="form-group">

                        <!-- <label class="ener-name">Additional Services</label> -->

                        <input type="text" name="newadditional_servicess" class="form-control chinput"

                        value="" data-role="tagsinput" placeholder="eg - Delivery , Pickup , ....">

                        <div class="ddaa extrsposin"><i class="fa fa-plus"></i></div>

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

                <!--third card close-->

                <!--second close-->

                <div class="enter_name">

                  <button type="submit" class="find extra">

                    Submit

                  </button>

                </div>

              </form>

            </div>

          </div>

        </div>

      </div>

    </div>



    <div class="modal fade" id="basic_information" data-backdrop="static" data-keyboard="false" method="post">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <h4 class="modal-title">Basic Information</h4>

            <h5>Step 1 of 2</h5>

          </div>

          <div class="modal-body">

            <div class="card-body">

              <form method="post" action="<?php echo site_url(); ?>BusinessProfile/saveBusinessProfileData" class="userprofile-form" id="profile_form_modal">       

                <!--first start-->

                <div class="row">

                  <div class="col-md-6 col-12">

                    <div class="form-group">

                      <label class="ener-name">Business name</label>

                      <input type="text" name="business_name" class="form-control chinput" placeholder="Business name" 

                      value="<?php if(!empty($user_data->business_name)) { echo $user_data->business_name; } ?>" required>

                    </div>

                  </div>

                  <div class="col-md-6 col-12">

                    <div class="form-group let_bt">

                      <label class="ener-name">Business Email</label>

                      <input type="text" class="form-control chinput" name="Cheryl" value="<?php if(!empty($user_data->email)) { echo $user_data->email; } ?>" disabled required>

                    </div>

                  </div>

                </div>

                <!--first close-->



                <!--second start-->

                <div class="row">

                  <div class="col-md-6 col-12">

                    <div class="slesh"></div>

                    <div class="form-group">

                      <label class="ener-name">Contact name</label>

                      <input name="firstname" class="form-control chinput dulinput ag1" placeholder="first name" type="text" value="<?php if(!empty($user_data->firstname)) { echo $user_data->firstname; } ?>" required>

                      <input name="lastname" class="form-control chinput dulinput ag2" placeholder="last name" type="text" value="<?php if(!empty($user_data->lastname)) { echo $user_data->lastname; } ?>" required>

                    </div>

                  </div>

                  <div class="col-md-6 col-12">

                    <div class="form-group let_bt">

                      <label class="ener-name">Website link</label>

                      <input type="text" class="form-control chinput" name="website_link" placeholder="Website link"

                      value="<?php if(!empty($user_data->website_link)) { echo $user_data->website_link; } ?>" >

                    </div>

                  </div>

                </div>

                <!--second close-->



                <!--third start-->

                <div class="row">

                  <div class="col-md-6 col-12">

                    <div class="form-group">

                      <label class="ener-name">Business address</label>

                      <input type="text" name="business_address" class="form-control chinput" placeholder="Business address"

                      value="<?php if(!empty($user_data->business_address)) { echo $user_data->business_address; } ?>" required>

                    </div>

                  </div>

                  <div class="col-md-6 col-12">

                    <div class="form-group let_bt">

                      <label class="ener-name">Phone number</label>

                      <input type="text" name="phone" class="form-control chinput" placeholder="+1234567890" value="<?php if(!empty($user_data->phone)) { echo $user_data->phone; } ?>" required>

                    </div>

                  </div>

                </div>

                <!--third close-->



                <!--fourth start-->

                <div class="row">

                  <div class="col-md-6 col-12">

                    <div class="form-group">

                      <label class="ener-name">Select category</label>

                      <select class="form-control chinput" name="user_category" required>

                        <!-- <option value="<?php if(!empty($user_data->user_category)) { echo $user_data->user_category; } ?>" style="color: #fff;"><?php if(!empty($user_data->user_category)) { echo $user_data->user_category; } ?></option> -->

                        <option value="">Select Category</option>

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

                    <div class="col-md-6 col-12">

                      <div class="form-group let_bt">

                        <label class="ener-name">Zip Code</label>

                        <input type="text" name="zip" class="form-control chinput zip" placeholder="Your Zip Code" value="<?php if(!empty($user_data->zip)) { echo $user_data->zip; } ?>" required>        

                      </div>

                    </div>

                  </div>

                  <!--fourth close-->





                  <!--five start-->

                  <div class="row">

                    <div class="col-md-6 col-12">

                      <div class="form-group">

                        <label class="ener-name">City</label>

                        <input type="text" name="city"  class="form-control chinput city" placeholder="Your City" value="<?php if(!empty($user_data->city)) { echo trim($user_data->city); } ?>" required>

                      </div>

                    </div>

                    <div class="col-md-6 col-12">

                      <div class="form-group let_bt">

                        <label class="ener-name">State</label>

                        <input type="text" name="state" class="form-control chinput state" placeholder="Your State" value="<?php if(!empty($user_data->state)) { echo trim($user_data->state); } ?>" required>

                      </div>

                    </div>

                  </div>

                  <!--five close-->



                  <!--six strat-->

                  <div class="row">

                    <div class="col-md-6 col-12">

                      <div class="form-group">

                        <label class="ener-name">Country</label>

                        <input type="text" name="country"  class="form-control chinput country" placeholder="Your Country" value="<?php if(!empty($user_data->country)) { echo $user_data->country; } ?>" required>

                      </div>

                    </div> 



<!--  <div class="col-md-6 col-12">

<div class="form-group">

<label class="ener-name">Select category</label>

<select class="form-control chinput" name="user_category" required>

<option value="<?php if(!empty($user_data->user_category)) { echo $user_data->user_category; } ?>" style="color: #fff;"><?php if(!empty($user_data->user_category)) { echo $user_data->user_category; } ?></option>

<?php if(!empty($category_details['result'])){

foreach($category_details['result'] as $categories){ ?>

<?php

$cateStatus = ($categories->id == $user_data->user_category) ? "selected": ""; 

?>

<option value="<?php echo $categories->id; ?>" <?php echo $cateStatus; ?> ><?php echo $categories->name; ?></option>



<?php } } ?>



</select>

</div>

</div>   -->  

</div>

<?php if($user_data->profile == '' || $user_data->profile=='assets/images/default_image.jpg' ) { ?>

  <div class="row">

    <div class="col-md-6 col-12">

      <div class="form-group">

        <label class="ener-name">Profile Image</label>

        <input type="file" name="profileimg" id="profileimg" class="form-control chinput" required>

      </div>

    </div> 

    <div class="col-md-6 col-12 hide" id="img_div">

      <img src="" id="profile_img_" height="100%" width="50%">

    </div> 

  </div>

<?php } ?>

<!--six close-->

<!--row close-->

<div class="enter_name">

  <button type="submit" class="find extra">

    Next

  </button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

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



<script type="text/javascript">$('#zips').keyup(function() {

  var len = $.trim(this.value).match(/\d/g).length;

  if (len >= 5 && len <= 7) {

    getGeo();

  }

});

function getGeo(e) {

  alert();

  var zipnew = document.getElementById('zips').value;

  var base_url = $('#base_url').val();

  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_url+'user/getZipLocation',

    data: {zip:zipnew},

    success: function (data) {

      if(data.city)

        $('#citys').val(data.city);

      if(data.state)

        $('#states').val(data.state);

      if(data.country){

        $('.countryss').val(data.country);

      }

    }

  });</script>
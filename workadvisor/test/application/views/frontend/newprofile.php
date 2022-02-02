<!--section log_inheder start-->
<style type="text/css">
  #share-buttons img {
    width: 35px;
    padding: 5px;
    border: 0;
    box-shadow: 0;
    display: inline;
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
              <input type="hidden" id="base_url" value="<?php echo base_url() ?>">
              <li role="presentation">
                <a  aria-controls="ShareProfile" role="tab" data-toggle="tab">
                  <i class="fa fa-share-square-o"></i> Share Profile
                </a>
              </li>
              <div id="share-buttons" title="Share Profile">
                <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
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
      <div class="col-md-3 col-sm-3 col-12">
        <div class="chery11 profile-img" style="background:url('<?php echo (!empty($user_data->profile))? $user_data->profile:DEFAULT_IMAGE; ?>'); background-position: center;">
          <a data-toggle="modal" class="update-profileimg" data-target="#uploadModal">
            <i class="fa fa-camera" aria-hidden="true"></i>
            &nbsp;Upload Your Profile
          </a>
        </div>
        <div id="uploadModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <!-- Form -->
                <form method='post' action='<?php echo site_url(); ?>Profile/Update_profileimg' enctype="multipart/form-data">
                  Select file : 
                  <input type='file' name='profileimg' id='file' class='form-control' required='required'><br>
                  <input type='submit' class='btn btn-info' value='Upload' id='upload'>
                </form>
                <!-- Preview-->
                <div id='preview'>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--col-3-div close-->


      <!--col-8-div start-->
      <div class="col-md-8 col-sm-8 col-12">
        <!--chery 2 strat-->
        <div class="Chery2">
        <?php 
        $userData = $this->session->userdata();
        $uemail = $userData['userData']['email'];
        $uname = $userData['userData']['firstname']." ".$userData['userData']['lastname'];
        ?>
          <input type="hidden" id="uname" value="<?php echo $uname;?>">
          <input type="hidden" id="uemail" value="<?php echo $uemail;?>">
          <h2><?php if(!empty($user_data->firstname)) { echo $user_data->firstname; } ?> <?php if(!empty($user_data->lastname)) { echo $user_data->lastname; } ?></h2>
          <p>
            <?php if(!empty($user_data->city)) { echo $user_data->city.','; } ?>
            <?php if(!empty($user_data->state)) { echo $user_data->state.','; } ?>
            <?php if(!empty($user_data->country)) { echo $user_data->country.','; } ?>
            <?php if(!empty($user_data->zip)) { echo $user_data->zip; } ?>

          </p>
          <a href="<?php echo site_url('user/history') ?>">
            <span class="quyntity"><?php echo $starRating;?></span>
          </a>
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


  <section class="history">
    <div class="container">
      <div class="row">
        <!--tab list start-->
        <div class="col-md-3 col-12 pl_inlft"> 
          <div class="history_cont">
            <ul class="nav nav-tabs">

              <li class="his_img extr nav-item">
                <a class="nav-link" data-toggle="tab" href="#promot1">
                  <div class="his_img">
                    <img src="<?php echo base_url();?>assets/images/h11.png"> 
                  </div>
                  Promote your page
                </a>
              </li>

              <li class="his_img extr nav-item">
                <a class="nav-link " data-toggle="tab" href="#home">
                  <div class="his_img">
                    <i class="fa fa-users"></i>
                  </div>
                  My account
                </a>
              </li>

              <li class="his_img extr nav-item">
                <a class="nav-link active" data-toggle="tab" href="#menu1">
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
                  History
                </a>
              </li>


              <li class="his_img extr nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu3">
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
                  Albums/Documents
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
                <a class="nav-link" data-toggle="tab" href="#menu7">
                  <div class="his_img">
                    <img src="<?php echo base_url();?>assets/images/h7.png">
                  </div>
                  Member since <?php
                  if(!empty($user_data->reg_date)) { 
                    $date = date("Y-m-d",strtotime($user_data->reg_date));
                    $convert_date = strtotime($date);
                    $month = date('F',$convert_date);
                    $year = date('Y',$convert_date);
                    echo $month.", ".$year; } ?>
                  </a>
                </li>


                <li class="his_img extr nav-item">
                  <a class="nav-link" data-toggle="tab" href="#menu7">
                    <div class="his_img">
                      <img src="<?php echo base_url();?>assets/images/h7.png">
                    </div>
                    Report Profile
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
          <!--==tab list close=====-->
          <!--tab main contant start-->


          <div class="col-md-9 col-12">
            <div class="tab-content">   
              <!--====================promote your pages first tab link start=====================--> 
  <div class="tab-pane container" id="promot1">
    <div class="row">
      <div class="col-md-6">
        <div class="main_with over xdg">

          <div class="Chose_your ">
            <ul>
              <li class="promot_choos special_bord">
                <div class="pro_choos">
                  <h1>Choose your budget</h1>
                  <p> Lorem ipsum dolor sit amet, eu vis antiopam
                    mediocrem.</p>
                  </div>
                </li>
                <li class="promot_choos agin">
                  <div class="promotsa">
                    <div class="form-group">
                      <label class="promot_one">
                        <input type="radio" checked="checked" name="radio">
                        <span class="checkmark_opne on_onenot"></span>
                      </label>
                    </div>
                  </div>
                  <div class="autem blandit">
                    <h3>Autem blandit accusamus </h3>
                    <p>Validity: 6 Month</p>
                  </div>
                  <div class="rat"> $19 </div>
                </li>
                <li class="promot_choos agin">
                  <div class="promotsa">
                    <div class="form-group">
                      <label class="promot_one">
                        <input type="radio" checked="un-chacked" name="radio">
                        <span class="checkmark_opne on_onenot"></span>
                      </label>
                    </div>
                  </div>
                  <div class="autem blandit">
                    <h3>Autem blandit accusamus </h3>
                    <p>Validity: 6 Month</p>
                  </div>
                  <div class="rat"> $19 </div>
                </li>


                <li class="promot_choos agin">
                  <div class="promotsa">
                    <div class="form-group">
                      <label class="promot_one">
                        <input type="radio" checked="un-chacked" name="radio">
                        <span class="checkmark_opne on_onenot"></span>
                      </label>
                    </div>
                  </div>
                  <div class="autem blandit">
                    <h3>Autem blandit accusamus </h3>
                    <p>Validity: 6 Month</p>
                  </div>
                  <div class="rat"> $19 </div>
                </li>



                <li class="promot_choos">
                  <div class="form-group">
                    <label class="lanll">Choose your own price</label>
                    <input type="text" name="dolor" class="form-control" placeholder="$5">
                    <span class="prdy">(per day)</span>
                  </div>
                </li>
                <li class="promot_choos">
                  <button type="start" class="start_btn">
                    Start Promotion
                  </button>
                </li>

              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-5 col-12"> 
          <div class="Chose_your chnaf">
            <ul>
              <li class="promot_choos bormse ">
                <div class="pro_choos">
                  <h1>Read Guidelines here</h1>
                  <p>Lorem ipsum dolor sit amet, eu vis antiopam
                    mediocrem.</p>
                  </div>
                </li>

                <li class="promot_choos pdn_rt">
                  <div class="integrer">
                    <i class="fa fa-check"></i>
                    <p>Integer at turpis id orci laoreet sollicitudin ac sed diam</p>
                  </div>
                </li>

                <li class="promot_choos pdn_rt">
                  <div class="integrer">
                    <i class="fa fa-check"></i>
                    <p>Probo integre scribentur vis ad. Eum cu brute delicata, sint theophrastus at sit.</p>
                  </div>
                </li>
                <li class="promot_choos pdn_rt">
                  <div class="integrer">
                    <i class="fa fa-check"></i>
                    <p>Ea eum lucilius tacimates voluptatibus, causae sanctus cu quo. Mel vero fugit denique at, quo ut ludus ubique molestiae.</p>
                  </div>
                </li>
                <li class="promot_choos pdn_rt">
                  <div class="integrer">
                    <i class="fa fa-check"></i>
                    <p>Sea expetenda percipitur an, quaeque dissentiunt ne vel, eam partiendo neglegentur ad.</p>
                  </div>
                </li>
                <li class="promot_choos pdn_rt">
                  <div class="integrer">
                    <i class="fa fa-check"></i>
                    <p> Vis error corpora an, ut dicunt doctus fierent mel, eum te lorem volumus suscipiantur</p>
                  </div>
                </li>
                <li class="promot_choos pdn_rt">
                  <div class="integrer">
                    <i class="fa fa-check"></i>
                    <p>Integer at turpis id orci laoreet sollicitudin ac sed diam</p>
                  </div>
                </li>

                <li class="promot_choos pdn_rt">
                  <div class="integrer">
                    <i class="fa fa-check"></i>
                    <p>Case magna utinam usu ad, affert nemore ei sed, pro no simul accumsan constituam.</p>
                  </div>
                </li>
              </ul>
            </div>

          </div>
        </div>
      </div>
      <!--====================promot your page first tab link end=====================--> 


      <div class="tab-pane container" id="home">
  <?php echo $this->session->flashdata('updatemsg'); ?>
  <?php if($this->session->flashdata('success')){ echo $this->session->flashdata('success'); } ?>
  <form method="post" action="<?php echo site_url(); ?>Profile/Editprofile" class="userprofile-form">
    <div class="row">


      <!--first Basic start-->
      <div class="Basic">
        <div id="accordion">
          <div class="card">
            <div class="card-header" id="headingOne">
              <h5 class="mb-0">
                <div class="collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  <h1 class="Basic-grn">Basic Information</h1>
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
                      <input name="firstname" class="form-control chinput dulinput ag1" placeholder="first name" type="text" value="<?php if(!empty($user_data->firstname)) { echo $user_data->firstname; } ?>">
                      <input name="lastname" class="form-control chinput dulinput ag2" placeholder="last name" type="text" value="<?php if(!empty($user_data->lastname)) { echo $user_data->lastname; } ?>">
                    </div>
                  </div>

                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="ener-name">Email </label>
                      <input type="text" class="form-control chinput" name="Cheryl" value="<?php if(!empty($user_data->email)) { echo $user_data->email; } ?>" disabled>
                    </div>
                  </div>
                </div>
                <!--row close-->
                <!--row start-->
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="ener-name">City</label>
                      <input type="text" name="city" id="city" class="form-control chinput" placeholder="Your City" value="<?php if(!empty($user_data->city)) { echo $user_data->city; } ?>">
                    </div>
                  </div>

                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="ener-name">State</label>
                      <input type="text" name="state" id="state" class="form-control chinput" placeholder="Your State" value="<?php if(!empty($user_data->state)) { echo $user_data->state; } ?>">
                    </div>
                  </div>
                </div>
                <!--row close-->
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="ener-name">Zip</label>
                      <input type="text" name="zip" id="zip" class="form-control chinput" placeholder="Your zipcode" value="<?php if(!empty($user_data->  zip)) { echo $user_data-> zip; } ?>">
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="ener-name">Phone 
                        <input type="checkbox" class="mycheckbox12">
                        <small> click to display </small>
                      </label>
                      <input type="text" name="phone" id="mycontact" class="form-control chinput" placeholder="Contact" value="<?php if(!empty($user_data->phone)) { echo $user_data->phone; } ?>">
                    </div>
                  </div>
                </div>
                <!--row close-->

                <div class="row">
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="ener-name">Country</label>
                      <input type="text" name="country" id="country" class="form-control chinput" placeholder="Your Country" value="<?php if(!empty($user_data->country)) { echo $user_data->country; } ?>">
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="ener-name">Website
                        <input type="checkbox" class="mycheckbox12">
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
                  <h1 class="Basic-grn">Category Information</h1>
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
                    <h1 class="Basic-grn">Current Position</h1>
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
                    <h1 class="Basic-grn">Professional skills</h1>
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
                          value="" data-role="tagsinput" placeholder="Professional skills">
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
                        <h1 class="Basic-grn">Additional Services</h1>
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
                              value="" data-role="tagsinput" placeholder="Additional Services">
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


                      <!--19april start new tab add do it.-->

                      <div class="card">
                        <div class="card-header" id="heading7">
                          <h5 class="mb-0">
                            <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                              <h1 class="Basic-grn">Search Friends</h1>
                            </div>
                          </h5>
                        </div>
                        <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion" style="">
                          <div class="card-body">     
                            <div class="row">
                              <div class="serch-fn-up">
                                <div class="fb-tz bordr" data-toggle="modal" data-target="#fbmodal">
                                  <p><i class="fa fa-facebook-square"></i>On Facebook</p>
                                </div>
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
                                            <a href="https://accounts.google.com/o/oauth2/auth?client_id=758763789707-04pg43rrkkml6ab4r9gts376ufqjbcfn.apps.googleusercontent.com&redirect_uri=http://workadvisor.co/test/user/google&scope=https://www.google.com/m8/feeds/&response_type=code"><img src="<?php echo base_url();?>assets/images/b3c993e.png"></a>
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
                                <h1 class="Basic-grn">Reset Password</h1>
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

<!--profile edit pages tab link close====================================
  ==============================================================--> 



   <!--====================overview page first tab link start=====================--> 
      <div class="tab-pane container active" id="menu1">
        <div class="row">
          <div class="col-md-8">
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
                <?php if(!empty($posts_details['result'])){ foreach($posts_details['result'] as $post){ ?> 
                <input type="hidden" name="table_name" id="table_name" value="<?php echo POSTS;?>">
                <div class="main_blog post-id" id="<?php echo $post->id; ?>" data-id="<?php echo encoding(get_current_user_id()); ?>">
                  <?php if($post->post_image!=""){
                    $imgsert=$post->post_image;
                    $postimgarr=explode(',',$imgsert);
                    if(count($postimgarr)>1){ ?>
                    <div class = "row">
                      <?php foreach($postimgarr as $postim){ ?>
                      <div class = "col-sm-4 col-md-4">
                        <a href = "#" class = "thumbnail">
                          <img src = "<?php echo $postim; ?>" alt= "Post Image">
                        </a>
                      </div>
                      <?php } ?>
                    </div>
                    <?php }else{ ?>
                    <div class="over_viewimg">
                      <img src="<?php echo $imgsert; ?>" class="img-fluid">
                      <div class="bl-box">
                        <img src="<?php echo base_url();?>assets/images/scrl.png">
                      </div>
                    </div>
                    <?php  } } ?>
					<?php if($post->post_video!=''){ ?>
					<div class="row">
					<div style=" width:450;height:330px;padding:10px;">
					<video width="450" autoplay controls="false">
					<source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>" type="video/mp4">
					<source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>" type="video/webm">
					<source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>" type="video/ogg">
					<source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>" type="video/mts">
					</video>
					</div>
					</div>
					<?php } ?>
                    <div class="contant_overviw esdu" onclick="setID(<?php echo $post->id;?>);">
                      <h1 class="datess"><?php echo date('d-m-Y H:i A',strtotime($post->post_date)); ?></h1>
                      <div class="btnns">
                        <div class="form-group">
                          <a href="#" class="linke"><img src="<?php echo base_url();?>assets/images/like.png">
                            <i class="fa fa-thumbs-up"></i>
                          </a>
                        </div>
                        <a href="" class="editss" data-toggle="modal" data-target="#myModal2" onclick="editPost(<?php echo $post->id;?>)">
                          <img src="<?php echo base_url();?>assets/images/edit.png">
                        </a>
                        <a href="" class="editss" data-toggle="modal" data-target="#modalDelete">
                          <i class="fa fa fa-trash-o"></i>
                        </a>

                      </div>
                    </div>
                    <div class="contant_overviw">
                      <p><?php echo $post->post_content; ?></p>
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
                      <div class="bar-one bar-con">
                        <span class="quntit"><?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?></span>
                        <div class="bar" data-percent="<?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?>"></div>
                        <span class="star_rigth">5&nbsp;&nbsp;stars</span>
                      </div>
                    </a>

                    <?php if(isset($percentarray[4])) {?>
                    <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/4">
                      <?php }else{ ?>
                      <a href="#">
                        <?php }?>
                        <div class="bar-one bar-con">
                          <span class="quntit"><?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?></span>
                          <div class="bar blkue" data-percent="<?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?>"></div>
                          <span class="star_rigth">4&nbsp;&nbsp;stars</span>
                        </div>
                      </a>

                      <?php if(isset($percentarray[3])) {?>
                      <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/3">
                        <?php }else{ ?>
                        <a href="#">
                          <?php }?>
                          <div class="bar-one bar-con">
                            <span class="quntit"><?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?></span>
                            <div class="bar blkue_chnc" data-percent="<?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?>"></div>
                            <span class="star_rigth">3&nbsp;&nbsp;stars</span>
                          </div>
                        </a>

                        <?php if(isset($percentarray[2])) {?>
                        <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/2">
                          <?php }else{ ?>
                          <a href="#">
                            <?php }?>
                            <div class="bar-one bar-con">
                              <span class="quntit"><?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?></span>
                              <div class="bar blkue_red" data-percent="<?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?>"></div>
                              <span class="star_rigth">2&nbsp;&nbsp;stars</span>
                            </div>
                          </a>

                          <?php if(isset($percentarray[1])) {?>
                          <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/1">
                            <?php }else{ ?>
                            <a href="#">
                              <?php }?>
                              <div class="bar-three bar-con">
                                <span class="quntit"><?php echo isset($percentarray[1])?number_format($percentarray[1],1).'%':'0%';?></span>
                                <div class="bar blkue_yellow" data-percent="<?php echo isset($percentarray[1])?number_format($percentarray[1],1):'0%';?>"></div>
                                <span class="star_rigth">1&nbsp;&nbsp;stars</span>
                              </div>
                            </a>
                          </div>
                          <?php } ?>
                          <!--Qr-code start-->
                          <div class="Qr-code">
                            <p> QR Code</p>
                            <a href="#">
                              <!-- <img src="<?php echo base_url();?>assets/images/code.png"> -->
                              <img class="qr_code1" src="<?php echo isset($qr_image)?$qr_image:'';?>">
                            </a>
                          </div>
                          <!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
                          <!-- workadv -->
                          <!-- <ins class="adsbygoogle"
                          style="display:inline-block;width:160px;height:600px"
                          data-ad-client="ca-pub-3979824042791728"
                          data-ad-slot="1270897105"></ins>
                          <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                          </script>  -->
                        </div>
                        <!--progresh bar close-->
                      </div>
                    </div>
                    <!--================overview page first tab link close===================--> 


                      <!--====================history page first tab link =====================--> 
                    <div class="tab-pane container" id="menu2">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="main_with coutm-wit">
                            <ul>
                              <?php if(!empty($MyhistoryRating)){ foreach($MyhistoryRating as $key=>$historyratings){
                                $upid=encoding($user_data->id);
                                $compid=encoding($MyhistoryRating[$key][0]['company_id']);
                                ?>        
                                <li class="ful_cntant min-pdn">
                                  <div class="lin-higthdiv">
                                    <a href="<?php echo site_url('user/indivisualhistory/'.$upid.'/'.$compid) ?>">  <?php echo ($key!="") ? $key : 'Not joined' ; ?> (<?php echo count($historyratings);  ?> Ratings) 
                                    </a>
                                  </div>
                                </li>
                                <?php } } ?>
                              </ul>
                            </div>
                          </div>
                          <div class="col-md-2">
                          </div>         
                        </div>
                      </div>

                      <!--====================history page first tab link close =====================--> 


                      <!--====================rank page six tab link  =====================--> 
                      <div class="tab-pane container" id="menuR1">
                        <div class="row">
                          <h1 class="you-sm">Your Ranking</h1>
                          <?php if(!empty($userRankRatings)){
                            foreach($userRankRatings as $row){
                              if($row['id'] == get_current_user_id()){?>
                              <div class="col-md-3 col-sm-3 col-12">
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
                                  <div class="col-md-3 col-sm-3 col-12">
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
                        </div>
                        <!--====================rank page six  tab link close =====================--> 
   <!--====================Friends page first tab link  =====================--> 
                        <div class="tab-pane container" id="menu3">
                          <div class="main_div_width">
                            <div class="row">
                              <div class="col-md-7 col-12">

                                <h2 class="Cher">Friend Requests</h2>
                                <?php
                                if(!empty($pendingRequest)){ $a=1; foreach($pendingRequest as $req){ 
                                  $userProfileUrl = site_url('viewdetails/profile/'.encoding($req['id']));
                                  if($a%2==1){ echo '<ul class="new_friends">';}
                                  ?>
                                  <li id="<?php echo 'FR'.$req['id']; ?>">
                                    <div class="jerry">
                                      <h1><?php echo $req['firstname'].' '.$req['lastname']; ?></h1>
                                      <a href="<?php echo $userProfileUrl; ?>">
                                        <div class="cat_img">
                                          <img src="<?php echo (!empty($req['profile']))? $req['profile']:DEFAULT_IMAGE; ?>" alt="<?php echo $req['firstname'].' '.$req['lastname']; ?>" alt="">
                                        </div>
                                      </a>
                                      <p><?php echo $req['city'].', '.$req['state'].', '.$req['country']; ?></p>
                                      <p><button class="btn btn-sm btn-success" onclick="friendRequest('<?php echo encoding($req['id']); ?>','Accept','<?php echo 'FR'.$req['id']; ?>')">Accept</button> &nbsp; <button class="btn btn-sm btn-danger" onclick="friendRequest('<?php echo encoding($req['id']); ?>','Reject','<?php echo 'FR'.$req['id']; ?>')">Reject</button></p>
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
                              <div class="col-md-5 col-sm-5 col-2">
                                <h2 class="cher">Search Friends</h2>
                                <div class="serch-fn-up">
                                  <div class="fb-tz bordr" data-toggle="modal" data-target="#fbmodalone">
                                    <p><i class="fa fa-facebook-square"></i>On Facebook</p>
                                  </div>
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

                                    <!-- first Modal close -->


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
                                                    <a href="https://accounts.google.com/o/oauth2/auth?client_id=758763789707-04pg43rrkkml6ab4r9gts376ufqjbcfn.apps.googleusercontent.com&redirect_uri=http://workadvisor.co/test/user/google&scope=https://www.google.com/m8/feeds/&response_type=code">
                                                      <img src="<?php echo base_url();?>assets/images/b3c993e.png">
                                                    </a>
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
                                  <div class="col-md-3 my_allfloatsF" id="<?php echo 'AF'.$frie['id']; ?>">
                                    <div class="jerry">
                                      <h1><?php echo $frie['firstname'].' '.$frie['lastname']; ?></h1>
                                      <a href="<?php echo $userProfileUrl1; ?>">
                                        <div class="cat_img">
                                          <img src="<?php echo (!empty($frie['profile']) && $frie['profile']!='assets/images/default_image.jpg') ? $frie['profile'] : base_url().DEFAULT_IMAGE; ?>" alt="<?php echo $frie['firstname'].' '.$frie['lastname']; ?>">
                                        </div>
                                      </a>
                                      <p><?php 
                                         $address = array();
                                          if(isset($frie['city']) && !empty($frie['city']))
                                            $address[] = $frie['city'];
                                          if(isset($frie['country']) && !empty($frie['country']))
                                            $address[] = $frie['country'];
                                          if(isset($frie['zip']) && !empty($frie['zip']))
                                            $address[] = $frie['zip'];
                                          if(!empty($address)){
                                            $address = implode(",", $address);
                                            echo $address;
                                          }
                                          ?></p>
                                      <p><button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalUnfriend" onclick="setFriendID(<?php echo $frie['id']?>)">Unfriend</button> &nbsp; <button class="btn btn-sm btn-danger" onclick="friendRequest('<?php echo encoding($frie['id']); ?>','Block','<?php echo 'AF'.$frie['id']; ?>')">Block</button></p>
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
                                  <div class="col-md-3 my_allfloatsF" id="<?php echo 'AF'.$frie['id']; ?>">
                                    <div class="jerry">
                                      <h1><?php echo $frie['business_name']; ?></h1>
                                      <a href="<?php echo $userProfileUrl1; ?>">
                                        <div class="cat_img">
                                          <img src="<?php echo (!empty($frie['profile']) && $frie['profile']!='assets/images/default_image.jpg') ? $frie['profile'] : base_url().DEFAULT_IMAGE; ?>" alt="<?php echo $frie['firstname'].' '.$frie['lastname']; ?>">
                                        </div>
                                      </a>
                                      <p><?php 
                                         $address = array();
                                          if(isset($frie['city']) && !empty($frie['city']))
                                            $address[] = $frie['city'];
                                          if(isset($frie['country']) && !empty($frie['country']))
                                            $address[] = $frie['country'];
                                          if(isset($frie['zip']) && !empty($frie['zip']))
                                            $address[] = $frie['zip'];
                                          if(!empty($address)){
                                            $address = implode(",", $address);
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

                              </div>
                          </div>
                          <!--====================Friends page first tab link close =====================--> 

                           <!--Video-photo doc tab link --> 
                          <div class="tab-pane container" id="menu4">
                            <div class="row">
                              <div class="col-md-8 col-12"> 
                                <!--start row--> 
                                <div class="row">
                                  <?php if(!empty($postbycompany)){ $md=0;  foreach($postbycompany as $newkey=>$newvalue){ $md++;
                                    $picarr=array();
                                    $latest_image1=base_url()."assets/images/p1.png";
                                    $latest_image2=base_url()."assets/images/ph.png";
                                    $latest_image3=base_url()."assets/images/v.png"; ?>
                                    <div class="col-tz">    
                                      <div id="myModal00<?php echo $md; ?>" class="modal fade" role="dialog">
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
                                                          <a data-fancybox="gallery<?php echo $md; ?>" href="<?php echo $img; ?>">
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
                                          <div class="col-md-4 col-12">
                                            <a href="#">
                                              <div class="jerry">
                                                <h1><?php echo $newkey; ?></h1>
                                                <div class="cat_img photss">
                                                  <img src="<?php echo $latest_image1; ?>">
                                                  <div class="atin_photos">
                                                    <a href="" class="bod_btm"><?php echo count($picarr)?> Photos</a><br>
                                                    <a href="" class="bod_btm">0 Videos</a>
                                                  </div>
                                                </div>
                                                <div class="jhiga">
                                                  <span><?php echo $newkey; ?></span>
                                                  <div class="pho_cnt">
                                                    <div class="photos1">
                                                      <img src="<?php echo $latest_image2; ?>">
                                                    </div>
                                                    <a href="" data-toggle="modal" data-target="#myModal00<?php echo $md; ?>" class="bod_btm"><?php echo count($picarr)?> Photos</a>
                                                  </div>
                                                  <div class="pho_cnt">
                                                    <div class="photos1 mar_lft">
                                                      <img src="<?php echo $latest_image3; ?>">
                                                    </div>
                                                    <a href="" class="bod_btm">0 videos</a>
                                                  </div>
                                                </div>
                                              </div>
                                            </a>
                                          </div> 
                                          <?php } } ?>
                                        </div>


                                        <div class="bor_btm"></div>
                                        <div class="row mar_tp">
                                          <h2 class="Cher">Document-Files</h2>
                                          <div class="col-md-3 col-12">
                                            <a href="#">
                                              <div class="jerry">
                                                <div class="cat_img but_imgsize">
                                                  <img src="<?php echo base_url();?>assets/images/doc.png">
                                                </div>
                                              </div>
                                            </a>
                                          </div> 

                                          <div class="col-md-3 col-12">
                                            <a href="#">
                                              <div class="jerry">
                                                <div class="cat_img but_imgsize">
                                                  <img src="<?php echo base_url();?>assets/images/doc.png">
                                                </div>
                                              </div>
                                            </a>
                                          </div>

                                          <div class="col-md-3 col-12">
                                            <a href="#">
                                              <div class="jerry">
                                                <div class="cat_img but_imgsize">
                                                  <img src="<?php echo base_url();?>assets/images/doc.png">
                                                </div>
                                              </div>
                                            </a>
                                          </div>
                                          <div class="col-md-3 col-12">
                                            <a href="#">
                                              <div class="jerry">
                                                <div class="cat_img but_imgsize">
                                                  <img src="<?php echo base_url();?>assets/images/doc.png">
                                                </div>

                                              </div>
                                            </a>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4 col-12"> 

                                        <div class="Qr-code">
                                          <p> QR Code</p>
                                          <a href="#">
                                           <!--  <img src="<?php echo isset($qr_image)?$qr_image:'';?>"> -->
                                           <img class="qr_code1" src="<?php echo isset($qr_image)?$qr_image:'';?>">
                                          </a>
                                        </div>
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
   <li class="active" ><a data-toggle="tab" href="#Post">
   <label class="upld_lbl"><i class="fa fa-edit"></i><label> Post</label></label>
   </a></li>
  <li><a data-toggle="tab" href="#PhotoUpload">
  <label class="upld_lbl img_upload_label"><i class="fa fa-image"></i><label>Photo Upload</label></label></a></li>
  
  <li><a data-toggle="tab" href="#VideoUpload">
  <label class="upld_lbl video_upload_label"><i class="fa fa-video-camera" aria-hidden="true"></i><label>Video Upload</label></label></a></li>
</ul>
<div class="tab-content">

  <div id="Post" class="tab-pane fade in active">
  <form id="dataPost1" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" name="site_url" id="act_url1" value="<?php echo site_url('user/wallpost'); ?>" >
    <input type="hidden" name="post_title" id="post_title1" value="" >
		<div class="form-group pdno">
            <textarea name="post_content" placeholder="Share your thoughts here." class="form-control check_empty" id="post_content1"></textarea>
            <div class="input_error_msg">Please fill this field.</div>
        </div>
		<div class="post_bx">
               <div class="form-group">
                 <input class="btn btn-success btn-sm" onclick="saveData('dataPost1','<?php echo site_url('user/wallpost'); ?>','responseDiv','errorDivId')" value="Post" type="button">
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
                <input class="files" name="post_image[]" multiple accept=".png, .jpg, .jpeg, .gif" type="file">
                </a>
                </div>
    </div>
    <div class="form-group pdno">
            <textarea name="post_content" placeholder="Share your thoughts here." class="form-control check_empty" id="post_content2"></textarea>
            <div class="input_error_msg">Please fill this field.</div>
    </div>
	<div class="post_bx">
               <div class="form-group">
                 <input class="btn btn-success btn-sm" onclick="saveData('dataPost','<?php echo site_url('user/wallpost'); ?>','responseDiv','errorDivId')" value="Post" type="button">
               </div>
    </div>
	</form>
  </div>
  
  <div id="VideoUpload" class="tab-pane fade">
  <form class="dropzone" action="<?php echo site_url('newprofile/wallpost2'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="site_url" id="act_url3" value="<?php echo site_url('user/wallpost2'); ?>" >
    <input type="hidden" name="post_title" id="post_title3" value="" >
	<div class="form-group">
    <div class="video_upload" style="marhin:5px;">
	<div class="fallback">
       <input name="file" type="file" accept="video/*" />
    </div>
	</div>
	</div>
		<!------>
		<div class="form-group pdno">
   <textarea name="post_content" placeholder="Share your thoughts here." class="form-control check_empty" id="post_content3"></textarea> 
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
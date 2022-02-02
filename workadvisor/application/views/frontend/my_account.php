     <div class="row">
                                <div class="col-md-9 form-data full_fillBx">
                                  <?php echo $this->session->flashdata('updatemsg'); ?>
                                  <form method="post" action="<?php echo site_url(); ?>BusinessProfile/Editprofile" class="bprofile-form">
                                    <div class="row">

<!--==============main basic start============
  ====================================================-->
  <div class="Basic new_pdFx">
    <div id="accordion">
      <div class="card">
        <div class="card-header" id="headingone">
          <h5 class="mb-0">
            <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseone" aria-expanded="true" aria-controls="collapseone">
              <h1 class="Basic-grn"><i class="fa fa-asterisk" aria-hidden="true"></i> Basic Information</h1>
            </div>
          </h5>
        </div>
        <div id="collapseone" class="collapse" aria-labelledby="headingone" data-parent="#accordion" style="">
          <div class="card-body">       
            <!--first start-->
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label class="ener-name">Business name</label>
                  <input type="text" name="business_name" class="form-control chinput" placeholder="Business name" 
                  value="<?php if(!empty($user_data->business_name)) { echo ucwords($user_data->business_name); } ?>" required>
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
                  <input name="firstname" class="form-control chinput dulinput ag1" placeholder="first name" type="text" value="<?php if(!empty($user_data->firstname)) { echo ucwords($user_data->firstname); } ?>" required>
                  <input name="lastname" class="form-control chinput dulinput ag2" placeholder="last name" type="text" value="<?php if(!empty($user_data->lastname)) { echo ucwords($user_data->lastname); } ?>" required >
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
                    <input type="text" name="zip"  class="form-control chinput zip" placeholder="Your Zip Code" value="<?php if(!empty($user_data->zip)) { echo $user_data->zip; } ?>" required>        
                  </div>
                </div>
              </div>
              <!--fourth close-->


              <!--five start-->
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="ener-name">City</label>
                    <input type="text" name="city" class="form-control chinput city" placeholder="Your City" value="<?php if(!empty($user_data->city)) { echo $user_data->city; } ?>" required>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group let_bt">
                    <label class="ener-name">State</label>
                    <input type="text" name="state" class="form-control chinput state" placeholder="Your State" value="<?php if(!empty($user_data->state)) { echo $user_data->state; } ?>" required>
                  </div>
                </div>
              </div>
              <!--five close-->

              <!--six strat-->
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label class="ener-name">Country</label>
                    <input type="text" name="country" class="form-control chinput country" placeholder="Your Country" value="<?php if(!empty($user_data->country)) { echo $user_data->country; } ?>" required>
                  </div>
                </div>     
              </div>
              <!--six close-->
            </div>
          </div>
          <!-- /div> -->
        </div>
        <!--second card start-->

        <!--category strat-->

        <!--second card start-->
        <div class="card">
          <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
              <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <h1 class="Basic-grn"><i class="fa fa-asterisk" aria-hidden="true"></i> Professional Skills <span class="professional_qmark"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h1>
              </div>
            </h5>
          </div>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="">
            <div class="card-body extra-linow">       
              <div class="row">
                <div class="col-md-12 col-12">
                  <!--new contant aad-->
                  <div id="bootstrapTagsInputForm" method="post" class="form-horizontal">
                    <div class="form-group">
                      <!-- <label class="ener-name">Professional skills</label> -->
                      <input type="text" name="newprofessional_skill" class="form-control chinput"
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
            <div id="collapsethree" class="collapse" aria-labelledby="headingthree" data-parent="#accordion" style="">
              <div class="card-body extra-linow">       
                <div class="row">
                  <div class="col-md-12 col-12">
                    <div id="bootstrapTagsInputForm" method="post" class="form-horizontal">
                      <div class="form-group">
                        <!-- <label class="ener-name">Additional Services</label> -->
                        <input type="text" name="newadditional_services" class="form-control chinput"
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
              </div>
            </div>         
            <!--third card close-->
            <div class="card">
              <div class="card-header" id="headingsix">
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
                          <p>Notification for job request</p>
                          <label class="switch">
                            <input type="checkbox" name="noti_job" id="noti_job"
                            <?php 
                            if(isset($user_data->job_request_received_notification) && $user_data->job_request_received_notification!=0)
                            {
                              echo "checked=checked";
                            }
                            ?>
                            >
                            >
                            <span class="slider round"></span>
                          </label>
                        </div>

                        <div class="form-group">
                          <p>Notification for task status</p>
                          <label class="switch">
                            <input type="checkbox" name="new_task_notification" id="new_task_notification"
                            <?php 
                            if(isset($user_data->new_task_notification) && $user_data->new_task_notification!=0)
                            {
                              echo "checked=checked";
                            }
                            ?>
                            >
                            >
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
<!-- <div class="card">
<div class="card-header" id="headingsevn">
<h5 class="mb-0">
<div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesevn" aria-expanded="false" aria-controls="collapsesevn">
<h1 class="Basic-grn">Search Friends</h1>
</div>
</h5>
</div>
<div id="collapsesevn" class="collapse" aria-labelledby="headingsevn" data-parent="#accordion" style="">
<div class="card-body">     
<div class="row">
<div class="col-md-6 col-12">
<div class="form-group">
<label class="ener-name">Search Friends</label>
<input type="text" name="current_position" id="current_position" class="form-control chinput" placeholder="Current Position" value="">
</div>
</div>
</div>
</div>
</div>
</div> -->
<!--19april close new tab add do it.-->



<!--fouth card start-->
<div class="card">
  <div class="card-header" id="headingfourth">
    <h5 class="mb-0">
      <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefourth" aria-expanded="true" aria-controls="collapsefourth">
        <h1 class="Basic-grn"><i class="fa fa-asterisk" aria-hidden="true"></i> Reset Password </h1>
      </div>
    </h5>
  </div>
  <div id="collapsefourth" class="collapse" aria-labelledby="headingfourth" data-parent="#accordion" style="">
    <div class="card-body">       
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
  </div>
</div>
<!--fourth card start-->



</div>
</div>
<!--==============main basic close============
  ====================================================-->





  <div class="enter_name">
    <button type="submit" class="find extra but_agi">
      Save
    </button>
  </div>
</div>
</form>
</div>

<div class="col-md-3 col-12 pla-ld"> 
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
  <br/> <br/>
  <!-- employee_myaccount -->
<!-- work_advisor_business 
<ins class="adsbygoogle"
style="display:block"
data-ad-client="ca-pub-3979824042791728"
data-ad-slot="9509517493"
data-ad-format="auto"
data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
-->
</div>
<!--progresh bar close-->
</div>
<!--===============Welcome================-->
<!-- Modal Structure -->
<div id="loginmodal" class="modal custompopupdesign">
    <a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
    <img class="logoTopFix" src="<?php echo base_url();?>assets/images/imglogopop.png" alt="img" />
    <form id="login_frm" method="post">   
        
        <h4 class="modal-title"><center>Welcome to Mawjuud</center></h4>
        <p><center>Sign in or Register</center></p>
        <div class="signin_error card-panel red lighten-3" style="display:none">
            <strong></strong>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="mdl_fld">
                    <a class="fbbtn" href="<?php echo $authUrl; ?>">
                        <img src="<?php echo base_url()?>assets/images/fb_sign.png" alt="images" class="aves-effect waves-light" />
                    </a>
                    <a class="fbbtn google" href="<?php echo $loginURL; ?>">
                        <img src="<?php echo base_url()?>assets/images/google_sign.png" alt="images" class="aves-effect waves-light" />
                    </a>
                </div>
            </div>
            <div class="col s12">
                <h5 class="orseprate">OR</h5>
            </div>
            <div class="col s12">
                <input type="email" name="user_email" class="form-control mdl_eml login_user_email" placeholder="Email Id">
                <input type="button" value="Submit" class="login_frm waves-effect waves-light">
            </div>
        </div>
        <div class="accpetIagree">I accept Mawjuud <a href="">Terms of Use</a> & <a href="">Privacy Policy</a></div>
    </form>
</div>
<!--===============Welcome================-->


<!--===============Create Password================-->
<!-- Modal Structure -->
<div id="create_password_modal" class="modal custompopupdesign">
    <a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
    <img class="logoTopFix" src="<?php echo base_url();?>assets/images/imglogopop.png" alt="img" />
    <form id="create_frm" method="post">   
        
        <h4 class="modal-title"><center>Create a Password</center></h4>
        <div class="signin_error card-panel red lighten-3 create_frm_pass" style="display:none">
            <strong></strong>
        </div>
        <div class="row">
            <div class="col s12">
                <input type="password" id="create_password" name="create_password" class="form-control mdl_eml login_user_email" placeholder="Password">
                <input type="button" value="Continue" class="create_frm waves-effect waves-light">
            </div>
        </div>
    </form>
</div>
<!--===============Create Password================-->



<!--===============Enter Password================-->
<!-- Modal Structure -->
<div id="enter_password_modal" class="modal custompopupdesign">
    <a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
    <img class="logoTopFix" src="<?php echo base_url();?>assets/images/imglogopop.png" alt="img" />
    <form id="enter_frm" method="post">   
        
        <h4 class="modal-title"><center>Welcome Back!</center></h4>
        <p><center>Enter your Password</center></p>
        <div class="signin_error card-panel red lighten-3 enter_frm_pass" style="display:none">
            <strong></strong>
        </div>
        <div class="row">
            <div class="col s12">
                <input type="password" id="enter_password" name="enter_password" class="form-control mdl_eml" placeholder="Password">
                <input type="button" value="Sign In" class="enter_frm waves-effect waves-light">
                 <div class="recover_psw">
                    <p><a class="modal-trigger accpetIagree5 modal-close" href="#forgotpwd">Forgot your password? <span class="ti-arrow-right"></span></a></p>
                </div>
            </div>
        </div>
    </form>
</div>
<!--===============Create Password================-->


<!--===============SignUp================-->
<div id="signupmodal" class="modal custompopupdesign">
    <a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
    <img class="logoTopFix" src="<?php echo base_url();?>assets/images/imglogopop.png" alt="img" />
    <form id="signup_frm" method="post" action="javascript:void(0);">
        
        <div class="my-signup">
            <div class="signup_error card-panel red lighten-3" style="display:none">
                <strong></strong>
            </div>
            <div class="signup_success card-panel teal accent-3" style="display:none">
                <strong></strong>
            </div>
            <h4 class="modal-title"><center>Select Type of User </center></h4>

            <div class="row">
                <div class="col s12">
                    <select name="register_as_agent" id="register_as_agent">
                        <option selected="">Select your category</option>
                        <option value="owner">Buyer / Seller / Property Owner</option>
                        <option value="agent">Real Estate Agent / Agency</option> 
                    </select>

                    <input type="text" name="firstnameSignup" id="firstnameSignup" placeholder="First Name" class="form-control">

                    <input type="text" name="lastnameSignup" id="lastnameSignup" placeholder="Last Name" class="form-control">

                    <input type="text" name="emailSignup" id="emailSignup" placeholder="Email Address" class="form-control">

                    <div style="margin-top:5px;"><span>*</span>
                        <span style="padding-left:3px;"> Your email address will be your user id</span>
                    </div>

                    <input type="text" name="emailSignup1" id="emailSignup1" placeholder="Confirm Email Address" class="form-control">

                    <input type="password" name="pass1Signup" id="pass1Signup" placeholder="Password" class="form-control">

                    <input type="password" name="pass2Signup" id="pass2Signup" placeholder="Confirm Password" class="form-control">

                    <div id="div_agent_details" style="display:none;">
                        <input type="text" name="agent_linekdin" id="agent_linekdin" placeholder="ORN /RERA ID Number" class="form-control">
                    </div>

                    <input type="text" name="mobile_no" id="mobile_no" placeholder="Mobile Number" class="form-control">

                    <div id="div_phone" style="display:none;">
                        <dl id="sample" class="dropdown" style="float:left;">
                            <dt><a href="#"><img class="flag" src="https://www.mawjuud.com/wp-content/themes/realeswp/united-arab-emirates-flag.png?189db0&amp;189db0" alt=""><span style="padding: 0px;
                            margin-top: -14px;
                            margin-left: 19px;">+971</span></a></dt>
                        </dl>
                        <div style="float:left;"> <input type="text" name="phoneSignup" id="phoneSignup" placeholder="Enter Mobile Number" class="form-control"></div>
                    </div>
                    <button type="submit" class="signin_frm waves-effect waves-light" name="Sign Up" value="Sign Up">Sign Up</button>
                </div>
                <div class="col s12">
                    <div class="mdl_fld">
                        <a class="fbbtn waves-effect waves-light" href="<?php echo $authUrl; ?>"><img src="<?php echo base_url();?>assets/images/fb_sign.png" alt="images" class="aves-effect waves-light" /></a>
                        <a class="fbbtn google waves-effect waves-light" href="<?php echo $loginURL; ?>"><img src="<?php echo base_url();?>assets/images/google_sign.png" alt="images" class="aves-effect waves-light" /></a>
                        <p>Already have an account?<a href="#loginmodal" class="lgn_btn hoverredD modal-trigger modal-close">Sign in</a></p>
                    </div>

                </div>
            </div>     
        </div>
    </form>
</div>
<!--===============SignUp================-->


<!--===============Forgot Password================-->
<!--===============Forgot Password================-->
<div id="forgotpwd" class="modal custompopupdesign">
    <a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
    <img class="logoTopFix" src="<?php echo base_url();?>assets/images/imglogopop.png" alt="img" />
    <form id="forgot_frm" method="post" action="javascript:void(0);">
        
        <h4 class="modal-title"><center>Forgot Password?</center></h4>
        <div class="signup_error card-panel red lighten-3" style="display:none">
            <strong></strong>
        </div>
        <div class="signup_success card-panel teal accent-3" style="display:none">
            <strong></strong>
        </div>
        <input type="email" name="resetemail" id="resetemail" placeholder="Email Address" class="form-control">
        <button type="submit" value="Send" class="reset_frm waves-effect waves-light">Send</button>
    </form>
</div>
<!--===============Forgot Password================-->
<!--===============Forgot Password================-->

<!--===============LOGIN After GOOGLE & FB Show Catergory Choose Popup================-->
<input type="hidden" id="user_logged_in" value="<?php if(!empty($sessionData)){ if($sessionData['user_role'] == ''){ echo 1;}  else { echo 0;} }?>">
<div id="chooseCategory" class="modal custompopupdesign">
    <div class="selectCfullcover">
        <img class="logoTopFix" src="<?php echo base_url();?>assets/images/imglogopop.png" alt="img" />
        <form method="post" id="category_frm" action="<?php echo base_url()?>user/update_category">
            <h4 class="modal-title"><center>Please Select Your Category</center></h4>
            <select id="usercategory" name="usercategory">
                <option value="owner">Buyer / Seller / Property Owner</option> 
                <option value="agent">Real Estate Agent / Agency</option>
            </select>
            <input type="submit" value="Save" id="CategorySave" class="modelsubmitBtns waves-effect waves-light">
            <a href="<?php echo base_url()?>user/logout" id="CategoryLogout" class="modelsubmitBtns waves-effect waves-light">Logout</a>
        </form>
    </div>
</div>

<!-- <a class="waves-effect waves-light btn modal-trigger" href="#chooseCategory">Modal</a> -->
<!--===============LOGIN After GOOGLE & FB Show Catergory Choose Popup================-->


<!--===============Completed applications================-->
<div id="applicationCmpt" class="modal">
<a href="#!" class="modal-close waves-effect modal_closeA">×</a>
<div class="applicationCmptInner">
    <h4 class="modal-title"><center>INVITE TO APPLY</center></h4>
    <div class="completeAppForms">
        <form>
            <div class="row">
                <div class="col s6">
                    <div class="input-field">
                      <input type="text" name="" id="appfname"/>  
                      <label for="appfname">First Name</label>
                    </div>    
                </div>
                <div class="col s6">
                    <div class="input-field">
                      <input type="text" name="" id="applname"/>  
                      <label for="applname">Last Name</label>
                    </div>    
                </div>
                <div class="col s12">
                    <div class="input-field">
                      <input type="text" name="" id="appemail"/>  
                      <label for="appemail">Email</label>
                    </div>         
                </div>
                <div class="col s12">
                    <div class="input-field">
                      <textarea id="textarea1" class="materialize-textarea"></textarea>
                      <label for="textarea1">Message</label>
                    </div>
                </div>

                <div class="col s12">
                    <div class="input-field">
                      <div class="socialInvi">
                        <a href=""><img src="<?php echo base_url();?>assets/images/whatsapp.png" alt="images"/></a>
                        <a href=""><img src="<?php echo base_url();?>assets/images/fbn.png" alt="images"/></a>
                        <a href=""><img src="<?php echo base_url();?>assets/images/linkedin.png" alt="images"/></a>
                        <a href=""><img src="<?php echo base_url();?>assets/images/twittern.png" alt="images"/></a>
                      </div>
                    </div>
                </div>


                <div class="col s12">
                    <button type="submit" id="" class="activelistingbtn waves-effect waves-light">Send invitation</button>
                </div>
            </div>
        </form>
    </div>
  </div>
</div>
<!--===============Completed applications================-->





<!--===============Confirmation Email================-->
<!--===============Confirmation Email================-->
<div id="confirmationemail" class="modal">
    <a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
    <div class="confirmationemail-inner text-center">
        <h4 class="modal-title"><center>We've Sent You a Confirmation Email</center></h4>
        <p>Time to Check Your Email.</p>
        <img src="<?php echo base_url()?>assets/images/updated.png">
        <p>Click the link in your email to confirm your account.</p>
        <p>If you can't find the email check your spam folder or click the link below to resend</p>
        <input type="hidden" id="resend_email">
        <h5><a href="javascript:void(0)" id="resend">Resend Confirmation Email</a></h5>
    </div>
</div>
<!--===============Confirmation Email================-->
<!--===============Confirmation Email================-->










<!--  Scripts-->
<script src="<?php echo base_url()?>assets/js/jquery-2.1.1.min.js?ver=<?php echo $timeStamp;?>"></script>
<script src="<?php echo base_url()?>assets/js/materialize.min.js?ver=<?php echo $timeStamp;?>"></script>
<script src="<?php echo base_url()?>assets/js/owl.carousel.min.js?ver=<?php echo $timeStamp;?>"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js?ver=<?php echo $timeStamp;?>"></script>
<script src="<?php echo base_url()?>assets/js/smoothscroll.js?ver=<?php echo $timeStamp;?>"></script>
 <script src="<?php echo base_url()?>assets/js/nicescroll.js?ver=<?php echo $timeStamp;?>"></script>
<script src="<?php echo base_url()?>assets/js/ion.rangeSlider.js?ver=<?php echo $timeStamp;?>"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/intlTelInput.js?<?php echo $timeStamp;?>"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/datatables.min.js?<?php echo $timeStamp;?>"></script>
<script src="<?php echo base_url()?>assets/js/custom.js?ver=<?php echo $timeStamp;?>"></script>
<script src="<?php echo base_url()?>assets/js/ply.js?ver=<?php echo $timeStamp;?>"></script>
<script>
    var baseUrl = '<?php echo base_url();?>';
    var loader_ajax='<div class="loader_outer"><div class="loader_inner"><img src="<?php echo base_url('assets/images/home-loader.gif'); ?>" alt="loading..." /></div></div>';
    $(document).ready(function(){
        $('.modal').modal();
        $('select').formSelect();
    });  
</script>
<script>
  $(document).ready(function(){
    $('.barsicon').click(function(){
      $(this).toggleClass('menuOpen');
      $('.my_allmenus').toggleClass('my_allmenusOpen');
    });
  });
</script>



</body>
</html>

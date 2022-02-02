
<!--log in form start-->
<?php $this->session->unset_userdata('actual_link');
$this->session->unset_userdata('message_link');?>
<footer class="log_instat">

 <div class="container">

    <form method="post" id="" action="<?php echo site_url('user/loginprocess');?>">

  <div class="row">



  <div class="col-md-6 col-12">

    <div class="form_start">

     <?php echo $this->session->flashdata('loginmsg'); ?>

    <h2>Login to WorkAdvisor.co</h2>
 
 <!--<h3 class="aim_strs">Aim for the stars</h3>-->
 <h3 class="aim_strs">Grow Awareness. Increase Profits.</h3>
    

<a href="<?php echo $authUrl; ?>" class="fbbtn">

<i class="fa fa-facebook-f"></i><span>Sign in with Facebook</span></a>


<!-- 
<a href="javascript:void(0)" onclick="linkedinAuth();" class="fbbtn link_in">

<img src="<?php echo base_url(); ?>assets/images/googl1e.png"> <span>Sign in with LinkedIn</span></a>
 -->
 <div class="linkedin_btn"><a class="fbbtn link_in" href="<?php  echo $oauthURL;?>">
<img src="<?php echo base_url(); ?>assets/images/googl1e.png"> <span>Sign in with LinkedIn</span>
</a>
</div>


<a href="<?php echo $loginURL; ?>" class="fbbtn google">

<img src="<?php echo base_url(); ?>assets/images/google.png">

<span>Sign in with Google plus</span></a>


<div class="or_imag">

  <img src="<?php echo base_url(); ?>assets/images/or.png">

</div>

<?php 
$cookieuser = '';
$cookiepass = '';
if(isset($_COOKIE['usernamecookie'])) {
	$cookieuser = $_COOKIE['usernamecookie'];
	
}
if(isset($_COOKIE['passcookie'])) {
	$cookiepass = $_COOKIE['passcookie'];
}  ?>

<div class="form-group">

<input type="email" name="email" value="<?php echo $cookieuser; ?>" class="form-control" placeholder="youremail@example.com" required>

</div>

<div class="form-group">

<input type="password" name="password" value="<?php echo $cookiepass; ?>" class="form-control" placeholder="password" required>

</div>
<a id="keepLoggedIn" class="forget_pss" href="javascript:void(0)" >
   <input name="keepMeLoggedin" type="checkbox" >  Keep me logged in
</a>
<a class="forget_pss" href="#" data-target="#pwdModal" data-toggle="modal">
  Forgot Password?
</a>
<button type="login" class="log_inbtn">
 login
</button>
<p>

Don’t have an account? <a href="<?php echo site_url(); ?>register" class="sin_up">Sign up</a></p>

<p>By logging in, you agree to our <a href="#">Terms of Service</a> and

<a href="#">Privacy Policy</a></p>

    </div>

  </div>





<div class="col-md-6 col-12 back_imgs">
<div class="img_contntd"><h1 class="conec_txt">'connect with colleagues and businesses on WorkAdvisor.Co'</h1>
<p class="link_upld chngpding1">
<img src="<?php echo base_url()?>assets/images/reviews.png">
Rate and review employees in any workplace</p>


<p class="link_upld chngpding1">
<img src="<?php echo base_url()?>assets/images/uplode.png">
Upload your work to <span class="litcolor">your profile</span></p><br>
<p class="link_upld chngpding1">
<img src="<?php echo base_url()?>assets/images/promot.png">Promote your profile <span class="litcolor">to the world</span></p><br>
<p class="link_upld chngpding1"><img src="<?php echo base_url()?>assets/images/chat.png">Chat with <span class="litcolor">Prospective colleagues or employers</span></p>
</div>
</div>



  </div>

    </form> 

 </div>

</footer>

<!--log in form start-->

<!-- The Modal -->
<!-- <div class="modal fade" id="myModal">
  <div class="modal-dialog chang_popup">
    <div class="modal-content">

         <button type="button" class="close" data-dismiss="modal">&times;</button>  
         <p class="lav_tetx">Forget Password</p>
         <form  method="post" action="<?php echo base_url();?>User/ForgotPassword">
             <div class="form-group">      
                  <input type="email" name="email" id="email" placeholder="Enter Your Email Id" required>
             </div>
             <div class="form-group">      
                  <input type="submit" value="submit" class="button">
             </div>
        </form>
     </div>
   </div>
</div> -->

<!--modal-->
<div id="pwdModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h1 class="text-center">What's My Password?</h1>
      </div>
      <div class="modal-body">
          <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                          
                          <p>If you have forgotten your password you can reset it here.</p>
                            <div class="panel-body">
                                 <form  method="post" action="<?php echo base_url();?>User/ForgotPasswordProcess">
                                      <fieldset>
                                          <div class="form-group">
                                              <input class="form-control input-lg" placeholder="E-mail Address" name="email" type="email" required>
                                          </div>
                                          <input class="btn btn-lg btn-primary btn-block" value="Send My Password" type="submit">
                                      </fieldset>
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
          <div class="col-md-12">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
      </div>  
      </div>
  </div>
  </div>
</div>
<style>
#keepLoggedIn {
	float: left;	
}
</style>
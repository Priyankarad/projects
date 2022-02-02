<!--log in form start-->

<footer class="log_instat">

 <div class="container">

   

  <div class="row">



  <div class="col-md-6 col-12">

    <div class="form_start">

     <?php echo $this->session->flashdata('loginmsg'); ?>

    <h2>Reset Your New Password</h2>

 <form method="post" id="" action="<?php echo site_url('user/UpdateResetPassword');?>" class="reset-form">

<div class="form-group">

  <label class="ener-name">New Password</label>
  <input type="Password" name="newpassword" id="newpassword" class="form-control chinput" placeholder="New Password"><span id='message'></span>

</div>

<div class="form-group">

<label class="ener-name">Confirm Password</label>
          <input type="Password" name="cnewpassword" id="cnewpassword" class="form-control chinput" placeholder="Confirm Password"><span id='message1'></span>
        <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
</div>



<button type="login" class="log_inbtn">

  Update Password

</button>

</form>

    </div>

  </div>





<div class="col-md-6 col-12 back_imgs">
<div class="img_contntd">
 <h1 class="conec_txt">connect with colleagues and businesses on WorkAdvisor.Co</h1>
<a href="#" class="link_upld">Upload Your Work to Your Profile</a><br>
<a href="#" class="link_upld">Promote Your Profile to the world</a><br>
<a href="#" class="link_upld">Chet with prospective colleagues or employers</a>
</div>
</div>



  </div>

     

 </div>

</footer>

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
                                 <form  method="post" action="<?php echo base_url();?>User/ForgotPassword">
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
    <!--========header=============-->

<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">

    <div class="link_section">
        <h1>Login / SignUp</h1>
    </div>

</section>



<!--=============== Sign in / sign up Section Start============ -->
<section class="sign_ups">
  <div class="container">
  <div class="myloginsignp">
    <div class="myloginsignp23">
    <div class="row">
      <div class="col col-md-5">
        <div class="lafet_log">
          <div class="log_fade">
          	<img src="<?php echo BASEURL; ?>assets/web/images/login-emc1.png">
          </div>
        </div>
      </div>
      <div class="col col-md-7">
        <div class="my_sinlog">
          <div class="tabs-wrapper">
            <ul class="nav classic-tabs tabs-cyan" role="tablist">
              <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#panel51" role="tab">LogIn</a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#panel52" role="tab">SignUp</a> </li>
            </ul>
          </div>
          <div class="tab-content card">
            <div class="tab-pane fade in show active" id="panel51" role="tabpanel"> 
              <form>
              <!--Form without header-->
              <div class="row loginfrms"> 
                
                <!--Body-->
                <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-email1">Email Address</label>
                  <input type="email" id="Form-email1" class="form-control" required="">
                  
                </div>
                <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-pass1">Password</label>
                  <input type="password" id="Form-pass1" class="form-control" required="">
                  
                </div>
                <div class="col-md-12 col-sm-12 col-12 form-group btnsrem">
                    <label>
                        <input type="checkbox" name=""> Remember Me
                    </label>
                    <a class="linksbtms" href="javascript:void(0;)"  data-toggle="modal" data-target="#modalLoginForm">Forget Password?</a>
                </div>
                <div class="col-md-12 col-sm-12 col-12 groupNotBts">
                  <button class="custom-btn btn_public" type="submit">Login</button>
                </div>
              </div>
              </form>
            </div>
            <div class="tab-pane fade" id="panel52" role="tabpanel">
              <form>
              <!--Form without header-->
              <div class="row loginfrms"> 
                
                <!--Body-->
                <div class="col-md-6 col-sm-6 col-12 form-group">
                  <label for="Form-first">First Name*</label>
                  <input type="text" id="Form-first" class="form-control">
                  
                </div>
                <div class="col-md-6 col-sm-6 col-12 form-group">
                  <label for="Form-sec">Last Name*</label>
                  <input type="text" id="Form-sec" class="form-control">
                  
                </div>
                <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-email1">Email Address*</label>
                  <input type="email" id="Form-email1" class="form-control">
                  
                </div>
                <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-pass1">Password*</label>
                  <input type="password" id="Form-pass1" class="form-control">
                  
                </div>

                 <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-pass1">Confirm Password*</label>
                  <input type="password" id="Form-pass1" class="form-control">
                  
                </div>
                <div class="col-md-12 col-sm-12 col-12 form-group btnsrem">
                    <label>
                        <input type="checkbox" name=""> I agree to terms &amp; Conditions
                    </label>
                    
                </div>
                <div class="col-md-12 col-sm-12 col-12 groupNotBts">
                  <button class="custom-btn btn_public" type="submit">Signup</button>
                </div>
                
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</div></section>
<!--=============== Sign in / sign up Section Start============ -->

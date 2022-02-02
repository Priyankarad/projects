<footer class="log_instat">
    <div class="container">
        <form method="post" id="" action="<?php echo site_url('user/registerprocess');?>">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="form_start lrf_t">
                        <?php echo $this->session->flashdata('registermsg'); ?>
                        <h2>Sign Up</h2>
                        <h3 class="aim_strs">Grow Awareness. Increase Profits.</h3>

                        <a href="<?php echo $authUrl; ?>" class="fbbtn">

                            <i class="fa fa-facebook-f"></i><span>Sign up with Facebook</span></a>

                            <div class="linkedin_btn"><a class="fbbtn link_in" href="<?php  echo $oauthURL;?>">
                                <img src="<?php echo base_url(); ?>assets/images/googl1e.png"> <span>Sign in with LinkedIn</span>
                            </a>
                        </div>


                        <a href="<?php echo $loginURL; ?>" class="fbbtn google">
                            <img src="<?php echo base_url(); ?>assets/images/google.png">
                            <span>Sign up with Google plus</span></a>

                            <div class="or_imag">
                                <img src="<?php echo base_url(); ?>assets/images/or.png" class="img-fluid">
                            </div>

                            <div class="form-group">
                                <input type="text" name="firstname" class="form-control" placeholder="First Name">
                            </div>

                            <div class="form-group">
                                <input type="text" name="lastname" class="form-control" placeholder="Last Name">
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="johndoe@donutandpixels.com" required="">
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="password" required="">
                            </div>

                            <button type="login" class="log_inbtn">
                                Sign up
                            </button>
                            <p>
                                Already have an account?  <a href="<?php echo site_url(); ?>login" class="sin_up">Sign in</a></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 back_imgs">
                            <div class="img_contntd">
                                <h1 class="conec_txt">'connect with colleagues and businesses on WorkAdvisor.Co'</h1>

                                <span  class="link_upld">
                                    <img src="<?php echo base_url()?>assets/images/reviews.png">
                                Rate and review employees in any workplace</span><br>
                                <p class="link_upld chngpding1">
                                    <img src="<?php echo base_url()?>assets/images/uplode.png">
                                    Upload Your Work to <span class="litcolor">Your Profile</span></p><br>
                                    <p class="link_upld chngpding1">
                                        <img src="<?php echo base_url()?>assets/images/promot.png">Promote Your Profile <span class="litcolor">to the world</span></p><br>
                                        <p class="link_upld chngpding1"><img src="<?php echo base_url()?>assets/images/chat.png">Chat with <span class="litcolor">prospective colleagues or employers</span></p>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </footer>

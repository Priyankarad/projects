<!--=============footer===========-->
<?php 
$authUrl = $this->facebook->login_url();
$loginURL = $this->googleplus->loginURL();
$sessionData = '';
if($this->session->userdata('sessionData')){
    $sessionData = $this->session->userdata('sessionData');
}
?>

<footer class="myfooter">

    <div class="footers">
        <div class="container">
            <div class="row">
                <div class="col s3">
                    <div class="fotbox">
                        <h5>About Us</h5>
                        <ul>
                            <li><a href="">About Us</a></li>
                            <li><a href="">Careers</a></li>
                            <li><a href="">Our Team</a></li>
                            <!-- <li><a href="" class="soon_W">Media Center</a></li>
                            <li><a href="" class="soon_W">CEO Message</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="col s3">
                    <div class="fotbox">
                        <h5>What We offer</h5>
                        <ul>
                            <li><a href="">Property Search</a></li>
                            <!-- <li><a href="">Property Consultancy</a></li> -->
                            <li><a href="">Property Listing</a></li>
                            <li><a href="">Agents Listing</a></li>
                            <li><a href="">Real Estate Updates</a></li>
                            <!-- <li><a href="" class="soon_W">Pioneer Agent</a></li>
                            <li><a href="" class="soon_W">Mawjuud Tags</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="col s3">
                    <div class="fotbox">
                        <h5>Site Map</h5>
                        <ul>
                            <li><a href="">Home</a></li>
                            <li><a href="">Properties</a></li>
                            <li><a href="">Rent</a></li>
                            <li><a href="">Buy</a></li>
                            <li><a href="">Agents</a></li>
                            <!-- <li><a href="" class="soon_W">Developers</a></li>
                            <li><a href="" class="soon_W">Mortgages</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="col s3">
                    <div class="fotbox">
                        <h5>Advertise with Us</h5>
                        <ul>
                            <li><a href="">List you Property For Free</a></li>
                            <li><a href="">List you Project For Free</a></li>
                            <!-- <li><a href="" class="soon_W">Offers</a></li>
                            <li><a href="" class="soon_W">Pricing and Subscriptions</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <hr/>
        </div> 
    </div> 



    <div class="middle_footers">
        <div class="container">
            <div class="row">
                <div class="col s4">
                    <div class="fotbox">
                        <h5>Subscribe to our updates</h5>
                        <p>Stay Up to date with our latest updates / News</p>
                        <div class="newsletter_F">
                            <form>
                                <input type="email" name="" placeholder="Email Address" required="">
                                <button type="submit" id="submit_btns">Subscribe</button>
                            </form>
                            <p class="unscbS"><a href="">Unsubscribe</a>, or <a href="">Change your Preference</a></p>
                            <p class="unscbS"><a href="">Our Privacy Policy,</a> and How we use our information</p>
                        </div>
                        <div class="bl_lftF">
                            <img src="<?php echo base_url()?>assets/images/cbs.png" alt="images"/>
                            Best Real <br/>Estate Portal<br/> 2018
                        </div>
                    </div>
                </div>
                <div class="col s4">
                    <div class="fotbox">
                        <h5>Mawjuud App</h5>
                        <p>Manage / Search Properties everywhere</p>
                        <div class="download_pa">
                            <a href=""><img src="<?php echo base_url()?>assets/images/googleplay.png" alt="images"/></a>
                            <a href=""><img src="<?php echo base_url()?>assets/images/app-download.png" alt="images"/></a>
                        </div>
                    </div>
                </div>
                <div class="col s4">
                    <div class="fotbox">
                        <h5>Connect with Us</h5>
                        <p>Reach out to us</p>
                        <div class="social_connectX">
                            <a href=""><span class="ti-facebook"></span></a>
                            <a href=""><span class="ti-twitter"></span></a>
                            <a href=""><span class="ti-youtube"></span></a>
                            <a href=""><span class="ti-linkedin"></span></a>
                            <a href=""><span class="ti-instagram"></span></a>
                            <a href=""><span class="ti-google"></span></a>
                        </div>
                    </div>
                </div>

            </div>
            <hr/>
        </div>
    </div>




    <div class="footer_btm">
        <div class="container">
            <div class="row">
                <div class="col s8">
                    <ul class="link_ft">
                       <!--  <li><a href="<?php echo base_url('accessibility');?>">Accessibility</a></li> -->
                        <li><a href="<?php echo base_url('contact_us');?>">Contact Us</a></li>
                        <li><a href="<?php echo base_url('privacy_policy');?>">Privacy Policy</a></li>
                        <li><a href="<?php echo base_url('terms_and_conditions');?>">Terms and Conditions</a></li>
                        <li><a href="<?php echo base_url('cookie_policy');?>">Cookie Policy</a></li>
                    </ul>
                </div>
                <div class="col s4">
                    <p>© 2018 Mawjuud FZE – All rights Reserved </p>
                </div>
            </div>
        </div> 
        <div class="img_footerL">
            <img src="<?php echo base_url()?>assets/images/footer_logo.png" alt="images"/>
        </div> 
    </div>
</footer>
<!--=============footer===========-->


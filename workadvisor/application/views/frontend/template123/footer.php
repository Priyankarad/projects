<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
?>
<footer class="main_footer">
   <form method="post">
   <div class="container wow fadeInleft animate">
   
 <div class="main_category">
<!--   <hr>  -->
 <div class="row">
 
 <div class="col-md-3 col-xs-12">
   <div class="social_links">
   <h2>Countries</h2>
   <ul>
     <li><a href="#">Australia</a></li>
     <li><a href="#">Brasil</a></li>
     <li><a href="#">Canada</a></li>
     <li><a href="#">Chile</a></li>
     <li><a href="#">Czech Republic</a></li>
     <li><a href="#">India</a></li>
     <li><a href="#">Indonesia</a></li>
     <li><a href="#">Ireland</a></li>
     <li><a href="#">Italy</a></li>
     <li><a href="#">Lebanon</a></li>
   </ul>
   </div>
 </div>
 <div class="col-md-2 col-xs-12">
    <div class="social_links">
   <h2>For user</h2>
   <ul>
    <li><a href="#">Code of Conduct</a></li>
     <li><a href="#">Community</a></li>
     <li><a href="#">Verified Users</a></li>
     <li><a href="#">Blogger Help</a></li>
     <li><a href="#">Mobile Apps</a></li>
     </ul>
   </div>
 </div>
  <div class="col-md-2 col-xs-12">
     <div class="social_links">
   <h2>Connect</h2>
   <ul>
    <li><a href="#"> Linked In</a></li>
     <li><a href="#">Google Plus</a></li>
     <li><a href="#">Twitter</a></li>
     </ul>
   </div>
  </div>



   <div class="col-md-3 col-xs-12">
       <div class="social_links">
   <h2>For business</h2>
   <ul>
    <li><a href="#"> Add a Restaurant</a></li>
     <li><a href="#">Claim your Listing</a></li>
     <li><a href="#">Business App</a></li>
     <li><a href="#">Business Owner Guidelines</a></li>
     <li><a href="#">Business Blog</a></li>
     <li><a href="#">Restaurant Widgets</a></li>
     <li><a href="#">Products for Businesses</a></li>
     </ul>
   </div>
   </div>
   <div class="col-md-2 col-xs-12">
     <div class="social_links">
   <h2>Quick links</h2>
   <ul>
    <li><a href="#">About Us</a></li>
     <li><a href="#">Culture</a></li>
     <li><a href="#">Blog</a></li>
     <li><a href="#">Careers</a></li>
     <li><a href="#">Contact </a></li>
     </ul>
   </div>
   </div>

<p class="copy"><a href="#"> © 2018 All rights reserved   Privacy Policy</a></p>
</div>
</div>
<!--main_category clsoe-->

  </div>
 </form>
 <!--Login Popup-->
 <div id="LoginModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
		<div class="form_start">
     <?php echo $this->session->flashdata('loginmsg'); ?>
    <h2>LogIn to Work Advisor</h2>
    <p>By logging in, you agree to our <a href="#">Terms of Service</a> and
<a href="#">Privacy Policy</a></p>
<a href="<?php echo $authUrl; ?>" class="fbbtn">
<i class="fa fa-facebook-f"></i><span>Sign in with Facebook</span></a>
<a href="javascript:void(0)" onclick="linkedinAuth();" class="fbbtn link_in">
<img src="<?php echo base_url(); ?>assets/images/googl1e.png"> <span>Sign in with LinkedIn</span></a>
<a href="<?php echo $loginURL; ?>" class="fbbtn google">
<img src="<?php echo base_url(); ?>assets/images/google.png">
<span>Sign in with Google plus</span></a>
<div class="or_imag">
  <img src="<?php echo base_url(); ?>assets/images/or.png">
</div>
<div class="form-group">
<input type="email" name="email" class="form-control" placeholder="youremail@example.com" required>
</div>
<div class="form-group">
<input type="text" name="password" class="form-control" placeholder="password" required>
</div>
<a class="forget_pss" href="#" data-target="#pwdModal" data-toggle="modal">
  forget password?
</a>
<button type="login" class="log_inbtn">login</button>
<p>
Don’t have an account? <a href="<?php echo site_url(); ?>register" class="sin_up">Sign up</a></p>
    </div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 <!-- / Login Popup-->
</footer>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">As an Employer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="emp_popups">
			<p><i class="fa fa-asterisk" aria-hidden="true"></i> Able to review employees based on performance</p>
			<p><i class="fa fa-asterisk" aria-hidden="true"></i> Connect with employees by sending job request</p>
			<p><i class="fa fa-asterisk" aria-hidden="true"></i> Chat with your employees through messaging</p>
			<p><i class="fa fa-asterisk" aria-hidden="true"></i> Keep track of employee ratings to gage employment opportunities</p>
			<p><i class="fa fa-asterisk" aria-hidden="true"></i> Post highlights of what your company is up to, engaging interested audiences.</p>
			
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">As a Performer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="emp_popups">
			<p><i class="fa fa-asterisk" aria-hidden="true"></i> Earn stars and reviews from customers, colleagues or employers</p>
			<p><i class="fa fa-asterisk" aria-hidden="true"></i> Get instant positive recognition for your job performance</p>
			<p><i class="fa fa-asterisk" aria-hidden="true"></i> Post highlights of photos or documents related to your work</p>
			<p><i class="fa fa-asterisk" aria-hidden="true"></i> Upload and download shareable PDFs among profiles</p>
			<p><i class="fa fa-asterisk" aria-hidden="true"></i> Create job related photo albums while connected with employer’s profile</p>
			
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->




    <!-- jQuery first, then Popper.<?php echo base_url();?>assets/js, then Bootstrap JS -->
    <script src="<?php echo base_url();?>assets/js/jquery-3.2.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/wow.js"></script>
    <script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/progresscircle.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>  
    <script src="<?php echo base_url();?>assets/js/simple-lightbox.js"></script>
    <script src="<?php echo base_url();?>assets/js/owl.carousel.min.js"></script>    
    <script src="<?php echo base_url();?>assets/js/bootstrap-tagsinput.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/custom.js"></script>


	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJOMIKWJalIMrYmvfEm-gvEptfSV-ezb8&libraries=places&callback=initAutocomplete&sensor=false"
        async defer></script>
<!--   <script src="<?php echo base_url();?>assets/js/jquery.fancybox.min.js"></script>    
 -->  <script src="<?php echo base_url();?>assets/js/helpers/fancybox-media.js"></script> 
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
   <script type="text/javascript">
    jQuery(document).ready(function ( $ ) {
    $.fn.progress = function() {
    var percent = this.data("percent");
    this.css("width", percent+"%");
     };
    }( jQuery ));
  </script>

 <?php if($this->session->userdata('loggedIn')){ ?>
 <script>
 setInterval(function(){ checkNotification(); }, 9000);
</script>
 <?php } ?>

 
  <?php if(!$this->session->userdata('id')){ ?>
<script>
 var loader_div='<div class="loader_outer"><div class="loader_inner"><img src="<?php echo base_url('/assets/images/ajax-loader.gif'); ?>" alt="loading image" /></div></div>';
</script>
<script type="text/javascript" src="https://platform.linkedin.com/in.js">
    api_key: 8199q87zzowmbj
    authorize: true
    onLoad: onLinkedInLoad
    
</script>
<script type="text/javascript">
function linkedinAuth(){
     IN.User.authorize(function(){
           onLinkedInLoad();
     });
}
function onLinkedInLoad(){
    IN.Event.on(IN, "auth", getProfileData);
}
    // Use the API call wrapper to request the member's profile data
    function getProfileData() {
      
        IN.API.Profile("me").fields("id", "first-name", "last-name", "headline", "location", "picture-url", "picture-urls::(original)", "public-profile-url", "email-address").result(ShowProfileData).error(onError);
    
         
    }

    function onError(error) {
        console.log(error);
    }


function ShowProfileData(profiles) {
    var member = profiles.values[0];
    var id=member.id;
    var firstName=member.firstName; 
    var lastName=member.lastName; 
    var photo=member.pictureUrl;
    var emailAddress =member.emailAddress; 
              var userdata={};
               userdata['type']='linkedin';
               userdata['id']=id;
               userdata['first_name']=firstName;
               userdata['last_name']=lastName;
               userdata['email']=emailAddress;
               userdata['picture']=photo;
               var jsonString = JSON.stringify(userdata);
             
              $.ajax({
                    type:'POST',
                    url:'<?php echo base_url(); ?>User/social_authentication',
                    data: { userdata: jsonString },
                    dataType: 'json',
                    success:function(res){
                       if(res.result == 0){
                          alert(res.msg);
                       }
                       else if(res.userdata==''){
                       
                         window.location.href = "<?php echo base_url(); ?>User/social_createcategory/"+res.email;
                          //location.reload(); 
                          logout();
                       }
                       else if(res.userdata=='Performer'){
                           window.location.href = "<?php echo base_url(); ?>profile";
                           logout();
                       }
                       else
                       {                   
                          window.location.href = "<?php echo base_url(); ?>businessprofile";
                          logout();
                       }
                    }
               });
       }

 function logout(){
    IN.User.logout(onLogout);
  }

  function onLogout(){
    console.log('Logout successfully');
  }
</script>
<?php } ?>
<script>
   $('.icon_fclick').click(function(){
    $(this).toggleClass('fclickopenF');
    $('.history_cont').toggleClass('hcontopen');
  });
  $('body').on('click', '.history_cont.hcontopen a', function(){
    $('.history_cont').removeClass('hcontopen');
    $('.icon_fclick').removeClass('fclickopenF');
  });
/************/
// var vids = $("video"); 
// $.each(vids, function(){
//   this.autoplay = false;
//   this.controls = false; 
//   this.controlsList="nodownload";
// }); 

$("video").click(function() {
  //console.log(this); 
  if (this.paused) {
    this.play();
  } else {
    this.pause();
  }
});
</script> 
<script>
    $('.circlechart').circlechart(); // Initialization
  </script>

<script>
	$(function(){
		var $galleryF = $('.fansy-gallry a').simpleLightbox();

		$galleryF.on('show.simplelightbox', function(){
			console.log('Requested for showing');
		})
		.on('shown.simplelightbox', function(){
			console.log('Shown');
		})
		.on('close.simplelightbox', function(){
			console.log('Requested for closing');
		})
		.on('closed.simplelightbox', function(){
			console.log('Closed');
		})
		.on('change.simplelightbox', function(){
			console.log('Requested for change');
		})
		.on('next.simplelightbox', function(){
			console.log('Requested for next');
		})
		.on('prev.simplelightbox', function(){
			console.log('Requested for prev');
		})
		.on('nextImageLoaded.simplelightbox', function(){
			console.log('Next image loaded');
		})
		.on('prevImageLoaded.simplelightbox', function(){
			console.log('Prev image loaded');
		})
		.on('changed.simplelightbox', function(){
			console.log('Image changed');
		})
		.on('nextDone.simplelightbox', function(){
			console.log('Image changed to next');
		})
		.on('prevDone.simplelightbox', function(){
			console.log('Image changed to prev');
		})
		.on('error.simplelightbox', function(e){
			console.log('No image found, go to the next/prev');
			console.log(e);
		});
	});
$(".mod2Hv .click_Qt").hover(function () {
    $('#exampleModalCenter').modal({
      show: true,
      backdrop: false
    })
  });
  $(".mod1Hv .click_Qt").hover(function () {
    $('#exampleModalCenter1').modal({
      show: true,
      backdrop: false
    })
  });
  

</script>


  </body>
</html>
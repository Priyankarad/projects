<?php

 defined('BASEPATH') OR exit('No direct script access allowed');

 if( isset($user_data->user_role) && $user_data->user_role == 'Performer'){ ?>

    <div class="modal fade" id="albums_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalCenterTitle">Albums</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <div class="emp_popups">

      <p><i class="fa fa-asterisk" aria-hidden="true"></i>Photos posted in highlights will go to album associated with job or industry.</p>

      

    </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>

</div>

  <div class="modal fade" id="ranking_mdls" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalCenterTitle">Ranking</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <div class="emp_popups">

      <p><i class="fa fa-asterisk" aria-hidden="true"></i>See rank amongst others in the same category.</p>

      

    </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>

</div>



<?php }else{ ?>



 <div class="modal fade" id="albums_mdl1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalCenterTitle">Albums</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <div class="emp_popups">

      <p><i class="fa fa-asterisk" aria-hidden="true"></i>Photos posted in highlights will appear in album.</p>

      

    </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>

</div>

<?php } ?>



<?php if(isset($user_data->user_role)  && $user_data->user_role == 'Performer'){ ?>

 <div class="modal fade" id="doc_files" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalCenterTitle">Documents-Files</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <div class="emp_popups">

      <p>Upload and store work documents.</p>

      <p><i class="fa fa-asterisk" aria-hidden="true"></i>Option for public to view and download from your profile.</p>

      <p><i class="fa fa-asterisk" aria-hidden="true"></i>Keep private and store work related documents for personal view only.</p>

      

    </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>

</div>

<?php }else{ ?>



 <div class="modal fade" id="doc_files1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalCenterTitle">Documents-Files</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <div class="emp_popups">

      <p>Upload and store work documents.</p>

      <p><i class="fa fa-asterisk" aria-hidden="true"></i>Option for public to view and download from your profile.</p>

      <p><i class="fa fa-asterisk" aria-hidden="true"></i>Keep private and store work related documents for personal view only.</p>

      <p><i class="fa fa-asterisk" aria-hidden="true"></i>Upload example (work schedules, excel sheets etc.) for employee view only.</p>

    </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>

</div>

<?php } 





//if (strpos($_SERVER['REQUEST_URI'], "viewdetails/profile") === false){





?>

<footer class="main_footer">


   <div class="container wow fadeInleft animate">

   

 <div class="main_category">

<!--   <hr>  -->

 <div class="row">

 

<div class="col-md-5">
<div id="newsletter_status"></div>
    <h2 class="ftSbsI">Subscribe For The Latest Info</h2>

  <div class="newsletter_im">
    
    <form class="form-inline" id="newsletter" action="<?php echo base_url();?>user/newsletter" method="post">

      <input type="email" name="semail" id="semail" placeholder="Stay updated with WorkAdvisor.co">

      <button type="submit" class="send_wnewsL"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>

    </form>

  </div>

  <img src="<?php echo base_url()?>assets/images/workadvisorfooterlogo.png" alt="images_logo" class="footerupdatelogo"/>

</div>  



 <div class="col-md-4 col-xs-12">

   <div class="social_links">

    <h1>Hard Work Pays Off</h1>

   </div>

 </div>







<!--  <div class="col-md-4 col-xs-12">

   <div class="social_links">

   <h2>Countries</h2>

   <ul>

     <li><a href="#">USA</a></li>

     <li><a href="#">Greece</a></li>

     <li><a href="#">Cyprus</a></li>

     <li><a href="#">India</a></li>

   </ul>

   </div>

 </div> -->







<!--   <div class="col-md-4 col-xs-12">

     <div class="social_links">

   <h2>Connect</h2>

   <ul>

    <li><a href="https://www.facebook.com/workadvisor.co/" target="_blank">Facebook</a></li>

    <li><a href="https://www.instagram.com/workadvisor.co/" target="_blank">Instagram</a></li>

    <li><a href="#" target="_blank"> LinkedIn</a></li>

     <li><a href="#" target="_blank">Google Plus</a></li>

     <li><a href="#" target="_blank">Twitter</a></li>

     </ul>

   </div>

  </div> -->





   <div class="col-md-3 col-xs-12">

     <div class="social_links">

   <h2>Links</h2>

   <ul class="inline-listWa">

    <li><a href="<?php echo site_url('settings/about_us');?>">About Us</a></li>

    <li><a href="<?php echo site_url('settings/how_it_works');?>">How It Works</a></li>

    <li><a href="<?php echo site_url('settings/faq');?>">FAQ</a></li>

    

     </ul>
     
     <ul class="inline-listWa">
        <li><a href="<?php echo site_url('settings/privacy_policy');?>">Privacy Policy </a></li>

    <li><a href="<?php echo site_url('settings/terms_of_service');?>">Terms & Conditions </a></li>

    <li><a href="<?php echo site_url('settings/contact_us');?>">Contact </a></li> 
     </ul>

   </div>

   </div>

<!--

<p class="copy">© 2018 All rights reserved   Privacy Policy | Design and Developed by  <a href="https://www.pixlritllc.com/" target="_blank">Pixlr It Inc </a></p>-->

<p class="copy">© 2018 All rights reserved</a></p>

</div>

</div>

<!--main_category clsoe-->



  </div>



 </footer>

<?php // } ?>

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

    <h2>Login to Workadvisor</h2>

    <p>By logging in, you agree to our <a href="#">Terms of Service</a> and

<a href="#">Privacy Policy</a></p>

<a href="<?php echo $authUrl; ?>" class="fbbtn">

<i class="fa fa-facebook-f"></i><span>Sign in with Facebook</span></a>

<a href="javascript:void(0)" onclick="linkedinAuth();" class="fbbtn link_in">

<img src="<?php echo base_url(); ?>assets/images/googl1e.png"> <span>Sign in with LinkedIn</span></a>

<form method="post" action="<?php echo base_url()?>user/loginprocess/review">



  <input type="hidden" id="userURL" name="userURL" value="<?php echo isset($actual_link)?$actual_link:'';?>">

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

<input type="password" name="password" class="form-control" placeholder="password" required>

</div>

<a class="forget_pss" href="#" data-target="#pwdModal" data-toggle="modal">

  Forgot Password?

</a>

<button type="login" class="log_inbtn">login</button></form>

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



  <div class="modal fade" id="qrCodeQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalCenterTitle">QR Code</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <div class="emp_popups">

      <p><i class="fa fa-asterisk" aria-hidden="true"></i>Print QR Code for promotional goods, flyers and business cards to direct traffic to your profile and boost your reviews.</p>

      

    </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>

</div>

<!-- Modal -->







<div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalCenterTitle">As an Employee</h5>

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



<div class="modal fade" id="history_" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalCenterTitle">Work History</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <div class="emp_popups">

      <p><i class="fa fa-asterisk" aria-hidden="true"></i>Performers reviews from category/industry or recent job.</p>

      

    </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>

</div>





    <!-- jQuery first, then Popper.<?php echo base_url();?>assets/js, then Bootstrap JS -->

    <!-- <script src="<?php echo base_url();?>assets/js/jquery-3.2.1.slim.min.js"></script> -->

    <!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->

    <!-- <script src="<?php //echo base_url();?>assets/js/wow.js"></script> -->

    <script src="<?php echo base_url();?>assets/js/popper.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/progresscircle.js"></script>

    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>  

    <script src="<?php echo base_url();?>assets/js/jquery.fancybox.min.js"></script> 
    <!-- <script src="<?php echo base_url();?>assets/js/simple-lightbox.js"></script> -->

    <script src="<?php echo base_url();?>assets/js/owl.carousel.min.js"></script>    

    <script src="<?php echo base_url();?>assets/js/bootstrap-tagsinput.min.js"></script>

    <script src="https://rawgit.com/select2/select2/master/dist/js/select2.js"></script>



    <script src="<?php echo base_url();?>assets/js/custom.js"></script>

    <script src="<?php echo base_url();?>assets/js/cus.js"></script>



	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJOMIKWJalIMrYmvfEm-gvEptfSV-ezb8&libraries=places&callback=initAutocomplete&sensor=false"

        async defer></script>

  

 

 <!--  <script src="<?php echo base_url();?>assets/js/helpers/fancybox-media.js"></script>  -->

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

 setInterval(function(){ checkMessages(); }, 15000);

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
// Hide submenus
$('#body-row .collapse').collapse('hide'); 

// Collapse/Expand icon
$('#collapse-icon').addClass('fa-angle-double-left'); 

// Collapse click
$('[data-toggle=sidebar-colapse]').click(function() {
    SidebarCollapse();
});

function SidebarCollapse () {
    $('.menu-collapsed').toggleClass('d-none');
    $('.sidebar-submenu').toggleClass('d-none');
    $('.submenu-icon').toggleClass('d-none');
    $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');
    
    // Treating d-flex/d-none on separators with title
    var SeparatorTitle = $('.sidebar-separator-title');
    if ( SeparatorTitle.hasClass('d-flex') ) {
        SeparatorTitle.removeClass('d-flex');
    } else {
        SeparatorTitle.addClass('d-flex');
    }
    
    // Collapse/Expand icon
    $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right');
}
    $(document).ready(function(){
        $("#newsletter").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type:'POST',
                url:'<?php echo base_url(); ?>user/newsletter',
                data: $(this).serialize(),
                dataType: 'json',
                success:function(res){
                  $('#semail').val('');
                  $('#newsletter_status').html(res.message);
                }
            });
        });
    });


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

  setInterval(function () {

    newNotifications();

}, 15000); // Execute somethingElse() every 2 seconds.



function newNotifications(){

    $.ajax({

        type:'POST',

        url:site_url+'/user/newNotifications',

        data: {},

        dataType: 'json',

        success:function(res){

            if(res.count>0){

                $('#notifications_ul').html(res.html);

                $('.notification_bell').html(res.count);

            }else{

                $('.notification_bell').html(0);

                $('#notifications_ul').html(res.html);

            }

        }

    });

}



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

    $('.qrCodeQuestion').hover(function(){

      $('#qrCodeQuestion').modal({

        show: true,

        backdrop: false

      });

    });





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



<?php if(isset($user_data->user_role) && $user_data->user_role == 'Performer'){ ?>

  $('.albums').hover(function(){

    $('#albums_mdl').modal({

      show: true,

      backdrop: false

    });

  });

  $('.doc_files').hover(function(){

    $('#doc_files').modal({

      show: true,

      backdrop: false

    });

  });





    

$('.other_ranking').hover(function(){

    $('#ranking_mdls').modal({

      show: true,

      backdrop: false

    });

  });

<?php } else{ ?>

  $('.albums').hover(function(){

    $('#albums_mdl1').modal({

      show: true,

      backdrop: false

    });

  });

  $('.doc_files').hover(function(){

    $('#doc_files1').modal({

      show: true,

      backdrop: false

    });

  });



<?php } ?>

$('.history_').hover(function(){

    $('#history_').modal({

      show: true,

      backdrop: false

    });

  });



  

/********************************************/

/********************************************/

 /*************AUTO-SCROLL*****************/

/********************************************/

/********************************************/

 $(document).ready(function(){

   autoscrollnow('conversation');

});

 var is_group = $('#is_group').val();

 function autoscrollnow(classofdiv){

  $('.'+classofdiv).animate({

   scrollTop: $('.'+classofdiv).get(0).scrollHeight}, 2000);

}

 function callpreviouse(){

  if($(".conversation").scrollTop()==0){

   var topid=$('.topId').val();

   var userId=$("#conversation").attr("data-id");

    getoldermessage(topid,userId);

     $("#conversation").scrollTop(1);

  } 

 }



 $(".conversation").scroll(function(){

  if($(".conversation").scrollTop()==0){

    console.log($(".conversation").scrollTop());

   var topid=$('.topId').val();

   var userId=$("#conversation").attr("data-id");

    getoldermessage(topid,userId)

     

     $("#conversation").scrollTop(1); 

   }  

   });

  

 function getoldermessage(topid,userId){

  $('.serch_profile').find(".chatuser").removeClass('activechat');  

   $.ajax({

    type:'POST',

     url:site_url+'/user/indivisualMessageOld',

     data: {userid:userId,top_id:topid,group:is_group},

     dataType: 'json',

   success:function(res){

     // $('.topId').remove();

       $('.conversation').prepend(res.msg);

       $('#friendlistmenu'+res.userid).addClass('activechat');

      $("#latestMessageCount_"+res.userid).html('');

       $("#latestMessageCount_"+res.userid).removeClass('cuircl2');

     if(res.msg!=""){

    $('#chatBox').scrollTop(30);

     }

     },

     error:function(){

       $(".loader").css("transform", 'scale(0)'); 

       alert('An error has occurred');

     }

   });  

 }





/********************************************/

/********************************************/

/*************END-AUTO-SCROLL****************/

/********************************************/

/********************************************/

</script>

<script type="text/javascript">

  setInterval(function () {

    newNotifications();

}, 15000); // Execute somethingElse() every 2 seconds.



function newNotifications(){

    $.ajax({

        type:'POST',

        url:site_url+'/user/newNotifications',

        data: {},

        dataType: 'json',

        success:function(res){

            if(res.count>0){

                $('#notifications_ul').html(res.html);

                $('.notification_bell').html(res.count);

            }else{

                $('.notification_bell').html(0);

                $('#notifications_ul').html(res.html);

            }

        }

    });

}



function googleTranslateElementInit() {

  new google.translate.TranslateElement({pageLanguage: 'en',includedLanguages: 'el,en,zh-TW,zh-CN,es,it,de,fr'}, 'google_translate_element');

}

</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/59f63dc9af87e51c961fcde29/8129a2f62a46c20df34b0c1ed.js");</script>  

  </body>

</html>
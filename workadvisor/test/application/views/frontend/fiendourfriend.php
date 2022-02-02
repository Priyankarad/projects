<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.css">
     <link rel="stylesheet" href="<?php echo base_url()?>assets/css/animate.css">
     <link rel="stylesheet" href="<?php echo base_url()?>assets/css/hover-min.css">
      <link rel="stylesheet" href="<?php echo base_url()?>assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="<?php echo base_url()?>assets/css/owl.carousel.min.css">
    <title>work adviser</title>
  </head>

  <body>
<!--  <div class="loader">
 <img src="<?php echo base_url()?>assets/images/screenshot.jpg" class="img-responsive">
</div> -->

<!--section log_inheder start-->
<section class="profile_page">

  <div class="container">
  <form method="post">
       <div class="profl_logo">
      <a href="index.html"><img src="<?php echo base_url()?>assets/images/profl.png"></a>
     </div>
    <div class="row">
    
     <div class="col-md-4 col-12 text-center not_pdng">
       <div class="city_contnt zip">
        <img src="<?php echo base_url()?>assets/images/addres.png">
        <input type="text" name="city" class="form-control" placeholder="City/Zipcode">
        </div>
    </div>
    <div class="col-md-4 col-12 text-center not_pdrth">
      <div class="city_con1 zip">
        <img src="<?php echo base_url()?>assets/images/Shape.png">
        <input type="text" name="city" class="form-control" placeholder="What you are looking for">
      </div>
   </div>
   <div class="col-md-4 col-12 text-center not_pdrth">
    <div class="city_con1 select">
        <button class="find extra bns">
send
</button>
      <!-- <select class="form-control">
        <option>Category</option>
        <option>Category</option>
        <option>Category</option>
        <option>Category</option>
      </select> -->
  <!--     <button class="usre bt_chhc">
 <i class="fa fa-user"></i>
</button> -->
      </div>

   </div>

    </div>

      </form>
  </div>

</section>
<!--section log_inheder close-->


<!--section log_inheder start-->
<section class="profile_tab">
  <div class="container">
    <div class="row">
   <div class="col-md-12 col-12 pl_inlft">
    <div class="tab_list">
      <!-- Nav tabs --><div class="card">
      <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">My account</a></li>
          <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Notification</a></li>
          <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Create Category</a></li>
        
      </ul>

      <!-- Tab panes -->
     
            </div>
          </div>
         </div>
        </div>
        </div>
   </section>
 <!--log_inheder start-->

 
 <section id="fiend-ourfriend">
   <div class="container">
     <div class="row">
	  <?php if(!empty($category_data['result'])){ foreach($category_data['result'] as $cats){ ?>
     <div class="col-md-3 col-sm-3 col-12">
     <a href="<?php echo site_url('category/'.$cats->slug.''); ?>">
       <div class="tz-friend">
         <div class="our-frienss">
         <img src="<?php echo base_url().$cats->category_image_thumb; ?>" class="img-fluid" alt="find1">
         </div>
         <p><?php echo $cats->name; ?></p>
       </div>
     </a>
     </div>
	 <?php } } ?>
    
   </div>
  </div>
 </section>




<!--section main_footer strat-->
<footer class="main_footer">
   <form method="post">
   <div class="container wow fadeInleft animate">

<!--      <div class="row dsgnvb">
      <div class="col-md-12">
      <div class="new_heding">
        <h2>Subscribe to our newsletter:</h2>
        <ul>
          <li class="miss_out">
            <a href="#">
            <img src="<?php //echo base_url()?>assets/images/right.png">
             Don't miss out on our great offers
           </a>
          </li>
          <li class="miss_out anf">
            <a href="#">
            <img src="<?php //echo base_url()?>assets/images/right.png">
             Receive deals from all our top brands via e-mail 
           </a>
          </li>
        
        </ul>
      </div>
 <div class="row wow  fadeInleft animate">
        <div class="col-md-4 col-xs-12">
          <div class="enter_name">
           <input type="text" name="Enter name" class="form-control" placeholder="Enter name">
         </div>
       </div>

        <div class="col-md-4 col-xs-12">
          <div class="enter_name chnfb">
           <input type="text" name="Email" class="form-control" placeholder="Enter Email Id">
         </div>
       </div>
          
       <div class="col-md-4 col-xs-12">
         <div class="enter_name">
           <button type="submit" class="find">
            submit
          </button>
         </div>
       </div>
   </div>
   </div>
  </div> -->

<!--main_category start-->
 <div class="main_category">
 <!--  <hr> --> 
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
</footer>





    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.slim.min.js"></script>
     <script src="<?php echo base_url()?>assets/js/wow.js"></script>
    <script src="<?php echo base_url()?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
       
    <script src="<?php echo base_url()?>assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/custom.js"></script>



 <script type="text/javascript">
   $(window).on('load', function () {
    $(".loader").css("transform", 'scale(0)');
  });
</script>

 <script>
  new WOW().init();
  </script>

 <script type="text/javascript">
    jQuery(document).ready(function(){
      $('#servh_scc').click(function(){
        $('.searchnoxx input').slideToggle();
      });
    });
  </script>
  <script type="text/javascript">
    jQuery(document).ready(function ( $ ) {
  $.fn.progress = function() {
    var percent = this.data("percent");
    this.css("width", percent+"%");
  };
}( jQuery ));

jQuery(document).ready(function(){
  jQuery(".bar-one .bar").progress();
  jQuery(".bar-two .bar").progress();
  jQuery(".bar-three .bar").progress();
});
  </script>
  </body>
</html>
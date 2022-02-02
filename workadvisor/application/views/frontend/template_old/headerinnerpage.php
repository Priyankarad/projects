<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
	<link rel="icon" href="https://webandappdevelopers.com/workadviser_ci/assets/images/fav.png" type="image/gif" sizes="18x12">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style2.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/hover-min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.carousel.min.css">
	  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fancybox.min.css">
<!--     <link rel="stylesheet" href="<?php echo base_url();?>assets/css/stripe.css">
 -->    <link href="<?php echo base_url(); ?>assets/admin/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <title>Workadvisor</title>
	<script> var site_url='<?php echo site_url(); ?>'; </script>
  </head>
  <body>
<!--  <div class="loader">
 <img src="<?php echo base_url();?>assets/images/screenshot.jpg" class="img-responsive">
</div> -->

<!--section log_inheder start-->
<section class="profile_page">
  <div class="container">
      <div class="row">
	     <div class="col-md-1">
       <div class="profl_logo">
      <a href="<?php echo site_url(); ?>"><img src="<?php echo base_url();?>assets/images/profl.png"></a>
     </div>
       </div>
	    <div class="col-md-9">
		<div class="row">
      <form method="post" action="<?php echo site_url('search/search/') ?>" onsubmit="return checkBlank()" style="display:inherit">
     <div class="col-md-5">
      <?php $data = $this->session->userdata('searchResults');?>
       <div class="city_contnt zip">
        <img src="<?php echo base_url();?>assets/images/Shape.png">
        <input type="text" id="searchTags" name="searchTags" class="form-control" placeholder="What you are looking for" value="<?php echo isset($data['tags'])?$data['tags']:'';?>">
		<div id="tagList" style=""></div>
        </div>
        <?php //pr($this->session->userdata('searchResults'));?>
    </div>
    <div class="col-md-5">
      <div class="city_con1 zip">
        <img src="<?php echo base_url();?>assets/images/addres.png">
        <input type="text" onFocus="geolocate()" id="autocomplete" name="city" class="form-control" placeholder="City/Zipcode" value="<?php echo isset($data['locality'])?$data['locality']:'';?>">
		  <i class="fa fa-location-arrow locality" aria-hidden="true" onclick="currLocation()" title="Current Location"></i>
    <input type="hidden" name="street_number" value="" id="street_number" >
								  <input type="hidden" name="locality" value="" id="locality" >
								  <input type="hidden" name="postal_code" value="" id="postal_code" >
								  <input type="hidden" name="country" value="" id="country" >
								  <input type="hidden" name="state" value="" id="administrative_area_level_1" >
								  <input type="hidden" name="route" value="" id="route" >
      </div>
   </div>
   <div class="col-md-2">
    <div class="city_con1 select">
        <button type="submit" class="find extra bns">Search</button>
      </div>

   </div>
    </form>
	</div>
	</div>
	
   <div class="col-md-2 col-12 text-center not_pdrth">
   <div class="write_riwe flot_right">
                     <?php if ($this->session->userdata('loggedIn')){ ?>
                     <a href="<?php echo site_url(); ?>logout">Logout</a>
                     <a href="<?php echo site_url('profile'); ?>"><i class="fa fa-user"></i> Profile</a>
                     <?php  }else{  ?>
                     <a href="<?php echo site_url(); ?>login" class="log_in sf">Login</a>
                    <!--- <a href="<?php echo site_url(); ?>register">Create your Profile</a>--->
                     <?php  }
                        ?>
                  </div>
   </div>

   
    </div>
  </div>
</section>
<!--section log_inheder close-->

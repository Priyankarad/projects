<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>

<html lang="en">
   <head>
   <meta name="p:domain_verify" content="897278edaa35cd39054ff1549de68be2"/>
   <!-- <title> Company Review | Employee, Employment Review - WorkAvisor</title> -->
   <title> View my profile, see my work and leave me a review!</title>
      <meta name="keywords" content="Employment agency,job search,job seeker,workadvisor reviews,employee reviews company, review your workplace, employee review, work advisor leave review, workadvisor employment agency,complete employment agency, company review, employment review , employee review agency, effective employee review, work agencies near me, recruitment agencies near me,employment agencies near me,employee performance review "/>
         <?php 
         if(isset($seo)){
         if($seo=='home'){ ?>
            <meta name="description" content=" WorkAdvisor is a complete employment 
             site which offers a work opportunity, you can review company as well as the employee of any categories. You can rate Real estate, Medical, Finance, Education, Jewellery. Anyone can find the job of your interest also you can review your workplace too."/> 
         <?php } else if($seo == 'about'){ ?>
            <meta  name="description" content="Here , you can rate, hire & promote your performer , review your workplace . Keep the track of the company star performer. You can also analyse  best performer in your key area based on reviews."/>
         <?php }
         else if($seo == 'category'){ ?>
            <meta name="description" content=" You can review 100+ employee of different flied. Explore you favorite job with different sector or in same sector. Besides this you choose your favorite company to work on the bases of review & rating.  "/>
         <?php }
    }?>
      <meta charset="utf-8">
	  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121196125-1"></script>

<script>

window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-121196125-1');
</script> 

   <meta property="og:image" content="<?php echo base_url()?>assets/images/header-mainH.png" />
   <meta property="og:url" content="<?php echo current_url(); ?>"/>
   <meta property="og:type" content="article" >
    <meta property="fb:app_id" content="966276300208479" > 
    <meta property="og:description" content="Workadvisor" > 
    <meta property="og:image:width" content="941" > 
   <meta property="og:image:height" content="628" >
   <meta property="og:updated_time" content="<?=time()?>" />
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="icon" href="<?php echo base_url();?>assets/images/favi-iconN.png" type="image/gif" sizes="18x12">
	  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/select2.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style2.css">
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.carousel.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/simplelightbox.min.css">

      <link href="<?php echo base_url(); ?>assets/admin/css/dataTables.bootstrap.min.css" rel="stylesheet">
       <script src="<?php echo base_url();?>assets/js/jquery.js"></script> 
      <script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap.min.js"></script>
      <title>Workadvisor</title>
	  	  <script> var site_url='<?php echo site_url(); ?>'; </script>
		  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   </head>
   <body>
      <!--enu_section section strat-->
      <section class="menu_section">
         <div class="container">
            <div class="row">
               <div class="col-sm-6 col-5">
                  <div class="write_riwe">
                     <?php 
                        $email=isset($this->session->userdata['userData']['email'])?$this->session->userdata['userData']['email']:'';
                        if(!empty($email) && isset($email)){
                           $url = base_url().'search/searchresults';
                        }else{
                           $url = base_url().'login';
                        }
                     ?>
                     <a href="<?php echo $url;?>" class="log_in_cjnn">Write a review</a>
                  </div>
               </div>
               <div class="col-sm-6 col-7 in_cjnn">
                  <div class="write_riwe flot_right homepageXlg">
                     <?php if ($this->session->userdata('loggedIn')){ ?>
                     <a href="<?php echo site_url(); ?>logout" class="font-srt">Logout</a>
                     <a href="<?php echo site_url('profile'); ?>">My Profile</a>
                     <?php  }else{  ?>
                     <a href="<?php echo site_url(); ?>login" class="log_in sf">Login</a>
                     <a href="<?php echo site_url(); ?>register">Create your Profile</a>
                     <?php  }
                        ?>
                  </div>
                  <div id="google_translate_element"></div>
              </div>
            </div>
         </div>
      </section>
      <!--enu_section section strat-->
      <!--banner_section section strat-->
      


      <section class="banner_section">
         
            <div id="banner_sliderImg" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                     <?php if(!empty($sliders['result'])){
                        $count = 0;
                        foreach($sliders['result'] as $row){
                           $count++;
                           $class = '';
                           if($count == 1){
                              $class="active";
                           }
                           ?>
                        <div class="carousel-item <?php echo $class;?>">
                              <div class="banner_itemsF" style="background:url(<?php echo base_url().$row->path;?>)">
                                    <div class="back_reound"></div>                      
                              </div>
                        </div>
                     <?php }
                     } ?>
                     <!--    <div class="carousel-item">
                              <div class="banner_itemsF" style="background:url('https://workadvisor.co/test/assets/images/banner.jpg')">
                                    <div class="back_reound"></div>    
                              </div>
                        </div>
                        <div class="carousel-item">
                              <div class="banner_itemsF" style="background:url('https://workadvisor.co/test/assets/images/banner.jpg')">
                                    <div class="back_reound"></div>    
                              </div>
                        </div> -->
                        </div>
                        <a class="carousel-control-prev" href="#banner_sliderImg" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#banner_sliderImg" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                        </a>
                  </div>
            </div>



            <div class="banner_formsF">
               <!--second row start-->
               <form method="post" action="<?php echo site_url('search/search/') ?>" onsubmit="return checkBlank()">
                  <div class="contnt_widht">
                     <div class="row">
                        <div class="logoss">
                           <img src="<?php echo base_url();?>assets/images/logomainlatest2.png">
                        </div>
                        <div class="col-md-10 col-xs-12 pd_right">
						<div class="row">
							<div class="col-lg-8 col-md-7 col-xs-12 pdright0H">
							   <div class="city_con1">
								  <img src="<?php echo base_url();?>assets/images/Shape.png">
								  <input type="text" id="searchTags" name="searchTags" placeholder="Job search, keywords, or company" autocomplete="off">
                          <!-- What you are looking for -->
								  <div id="tagList" style="top:80px;"></div>
							   </div>
							</div>
							<div class="col-lg-4 col-md-5 col-xs-12 pdleft0H">
							   <div class="city_contnt">
								  <img src="<?php echo base_url();?>assets/images/addres.png">
								  <input type="text"  onFocus="geolocate()" id="autocomplete" name="city" placeholder="City/Zip">
                          <i class="fa fa-location-arrow locality" aria-hidden="true" onclick="currLocation()" title="Current Location"></i>
								  <input type="hidden" name="street_number" value="" id="street_number" >
								  <input type="hidden" name="locality" value="" id="locality" >
								  <input type="hidden" name="postal_code" value="" id="postal_code" >
								  <input type="hidden" name="country" value="" id="country" >
								  <input type="hidden" name="state" value="" id="administrative_area_level_1" >
								  <input type="hidden" name="route" value="" id="route" >
							   </div>
							</div>
						 </div>
                        </div>
                        <div class="col-md-2 col-xs-12 pd_left">
                        <button type="submit" class="find">Find<i class="fa fa-search"></i></button>
                        </div>
                     </div>
                  </div>
               </form>
               <!--second row start-->
            </div>
         
      </section>








      <!--main_page section strat-->
      <!--header section strat-->
<!--       <section id="site_header">
         <div class="food_menu">
            <nav class="navbar navbar-default">
               <div class="container">
                  <nav class="navbar navbar-expand-lg navbar-light bg-light">
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                     </button>
                     <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                           <li class="nav-item hvr-pulse-grow active">
                              <a class="nav-link" href="#">
                              <img src="<?php /*echo base_url();?>assets/images/1.png" class="fl_left">
                              Food</a>
                           </li>
                           <li class="nav-item hvr-pulse-grow">
                              <img src="<?php echo base_url();?>assets/images/5.png" class="fl_left topvzx">
                              <a class="nav-link" href="#">Drink</a>
                           </li>
                           <li class="nav-item hvr-pulse-grow">
                              <a class="nav-link" href="#">
                              <img src="<?php echo base_url();?>assets/images/3.png" class="fl_left ">Household</a>
                           </li>
                           <li class="nav-item hvr-pulse-grow">
                              <a class="nav-link" href="#">
                              <img src="<?php echo base_url();?>assets/images/2.png" class="fl_left">
                              Medical</a>
                           </li>
                           <li class="nav-item hvr-pulse-grow">
                              <a class="nav-link" href="#">
                              <img src="<?php echo base_url();?>assets/images/4.png" class="fl_left">
                              Fashion</a>
                           </li>
                           <li class="nav-item hvr-pulse-grow">
                              <a class="nav-link" href="#">
                              <img src="<?php echo base_url(); */?>assets/images/6.png" class="fl_left xbn"></a>
                           </li>
                        </ul>
                     </div>
                  </nav>
               </div>
            </nav>
         </div>
      </section> -->

      <!-- hm_banner start -->
      <!--main_page section close-->
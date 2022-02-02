<link href="<?php echo base_url();?>assets/css/main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />

    
<!-- <script src="https://www.script-tutorials.com/demos/316/js/jquery.min.js"></script> -->
 <script src="<?php echo base_url();?>assets/js/jquery.js"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.Jcrop.js"></script>
<script src="<?php echo base_url();?>assets/js/jcrop.js"></script>
<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
<!doctype html>
<html lang="en">
  <head>

    <!-- <title>Company Review | Employee Review| Employment agency - WorkAvisor</title> -->
    <title>View my profile, see my work and leave me a review!</title>
     <meta name="keywords" content="Employment agency,job search,job seeker,workadvisor reviews,employee reviews company, review your workplace, work advisor employee review, work advisor performer review, work advisor leave review, work advisor website review, workadvisor employment agency, workadvisor  job search, workadvisor job seeker, worker, employee, staff, server, employer, performance,ranking, stars, review, performer, working, industry, job"/>
    <meta charset="utf-8">
       <?php 

       if(isset($seo)){
         if($seo=='home'){ ?>
            <meta name="description" content=" WorkAdvisor is a  top review site which offers a work opportunity, you can review company as well as the employee of any categories. You can rate Real estate, Medical, Finance, Education, Jewellery. Anyone can find the job of your interest also you can review your workplace too."/> 
         <?php } else if($seo == 'about'){ ?>
            <meta  name="description" content="Here , you can rate, hire & promote your performer , review your workplace . Keep the track of the company star performer. You can also analyse  best performer in your key area based on reviews."/>
         <?php }
         else if($seo == 'category'){ ?>
            <meta name="description" content=" You can review 100+ employee of different flied. Explore you favorite job with different sector or in same sector. Besides this you choose your favorite company to work on the bases of review & rating.  "/>
         <?php }
    }?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121196125-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'UA-121196125-1');

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  }
</script>
<?php //pr($user_data->user_role); ?>

<?php 
$fbsharetitles = '';
if(!empty($user_data)) {
//$fbsharetitles = (($user_data->user_role == 'Employer') ? $user_data->business_name : $user_data->firstname. ' '.$user_data->lastname); 
  if($user_data->user_role == 'Employer'){
    $fbsharetitles = $user_data->business_name;
  }else{
    $fbsharetitles = $user_data->firstname. ' '.$user_data->lastname;
  }
} 
?> 
<meta property="og:image" content="<?php echo !empty($user_data) ? $user_data->profile :''; ?>" />
<meta property="og:url" content="<?php echo current_url(); ?>"/>
<meta property="og:type" content="article" >
<meta property="fb:app_id" content="966276300208479" > 
<meta property="og:title" content="<?php echo $fbsharetitles; ?>" > 
<!-- <meta property="og:description" content="User profile of workadvisor" >  -->
<meta property="og:description" content="View my profile, see my work and leave me a review!" > 
 <!--    <meta property="og:image:width" content="941" > 
	<meta property="og:image:height" content="628" > -->
  <meta property="og:image:width" content="800" > 
  <meta property="og:image:height" content="500" >

	<meta property="og:updated_time" content="<?=time()?>" />

	<link rel="image_src" type="image/jpeg" href="<?php echo !empty($user_data) ? $user_data->profile :''; ?>" />
	<link rel="icon" href="<?php echo base_url();?>assets/images/favi-iconN.png" type="image/gif" sizes="18x12">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style2.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/hover-min.css"> -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/simplelightbox.min.css">    
	  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fancybox.min.css">
	  
	        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/flatpickr.min.css"> 
	  <link href="<?php echo base_url();?>assets/css/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
	  

<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/stripe.css"> -->
     <link href="<?php echo base_url(); ?>assets/admin/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <title>Workadvisor</title>
	<script> var site_url='<?php echo site_url(); ?>'; </script>
<!--   <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  </head>
  <body>
  <?php 
  //pr($user_data);
  ?>
<!--  <div class="loader">
 <img src="<?php echo base_url();?>assets/images/screenshot.jpg" class="img-responsive">
</div> -->
<?php //pr($user_data->profile); ?>
<!--section log_inheder start-->
<section class="profile_page">
  <div class="container">
      <div class="row">
	     <div class="col-md-3">
       <div class="profl_logo te">
        <a href="<?php echo site_url(); ?>"><img src="<?php echo base_url();?>assets/images/workadvisor-logo-whiteimp.png" alt="Post Image"> <!--<span>WorkAdvisor</span>--></a>
       </div>
       </div>
<!--        <div class="icon_fclick newChnBtns">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div> -->
	    <div class="col-md-7">
		<div class="row">
      <form method="post" class="mt5fix" action="<?php echo site_url('search/search/') ?>" onsubmit="return checkBlank()" style="display:inherit">
     <div class="col-md-5 pdrightX0">
      <?php $data = $this->session->userdata('searchResults');?>
       <div class="city_contnt zip">
        <img src="<?php echo base_url();?>assets/images/Shape.png">
        <input type="text" id="searchTags" name="searchTags" class="form-control" placeholder="Job search, keywords, or company" value="<?php echo isset($data['tags'])?$data['tags']:'';?>" autocomplete="off">
		<div id="tagList" style=""></div>
        </div>
        <?php //pr($this->session->userdata('searchResults'));?>
    </div>
    <div class="col-md-5 pdrightX0">
      <div class="city_con1 zip">
        <img src="<?php echo base_url();?>assets/images/addres.png">
      <!--   <input type="text" onFocus="geolocate()" id="autocomplete" name="city" class="form-control" placeholder="City/Zipcode" value="
        <?php if(isset($data['country']) && $data['country']!=''){
          echo $data['country'];
          }else if(isset($data['state']) && $data['state']!=''){
          echo $data['state'];
        }else if(isset($data['city']) && $data['city']!=''){
          echo $data['city'];
        }else if(isset($data['locality'])  && $data['locality']!=''){
          echo $data['locality'];
        } ?>

        "> -->
        <input type="text" onFocus="geolocate()" id="autocomplete" name="city" class="form-control" placeholder="City/Zip Code" value="<?php if(isset($data['city']) && $data['city']!=''){echo $data['city'];} ?>" />

		  <i class="fa fa-location-arrow locality" aria-hidden="true" onclick="currLocation()" title="Current Location"></i>
    <input type="hidden" name="street_number" value="" id="street_number" >
								  <input type="hidden" name="locality" value="" id="locality" >
								  <input type="hidden" name="postal_code" value="" id="postal_code" >
								  <input type="hidden" name="country" value="" id="country" >
								  <input type="hidden" name="state" value="" id="administrative_area_level_1" >
								  <input type="hidden" name="route" value="" id="route" >
      </div>
   </div>
   <div class="col-md-2 pdrightX0">
    <div class="city_con1 select">
        <button type="submit" class="find extra bns onlyfixbtnsX">Search</button>
      </div>

   </div>
    </form>
	</div>
	</div>
	
   <div class="col-md-2 col-12 text-center not_pdrth">
   <div class="write_riwe flot_right">
                     <?php if ($this->session->userdata('loggedIn')){ ?>
                     <a href="<?php echo site_url(); ?>logout">Logout</a>
                     <a href="<?php echo site_url('profile'); ?>" class="hundpx130"><i class="fa fa-user"></i>My Profile</a>
                     <?php  }else{  ?>
                     <a href="<?php echo site_url(); ?>login" class="log_in sf">Login</a>
                    <!--- <a href="<?php echo site_url(); ?>register">Create your Profile</a>--->
                     <?php  }
                        ?>
                  </div>
                  <div id="google_translate_element"></div>
   </div>

   
    </div>
  </div>
</section>
<!--section log_inheder close-->

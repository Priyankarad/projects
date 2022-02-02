<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--enu_section section strat-->
  <section class="food_contant">
    <div class="container">
     <div class="row">
      <div class="main_hdng">
      <meta name="description" content=" WorkAdvisor is a  top review site which offers a work opportunity, you can review company as well as the employee of any categories. You can rate Real estate, Medical, Finance, Education, Jewellery. Anyone can find the job of your interest also you can review your workplace too."/>

<!-- <h1>Find the best profile near you </h1> -->
      <!-- <h1>Browse profile by industry</h1> -->
      <h1>Browse By Industry</h1>
    </div>
     <!--slider section strat-->
               <div class="owl-carousel owl-theme" id="owl-shu">
                       <?php if(!empty($category_data)){ foreach($category_data as $cats){ 

                        if($cats['id']!=1){

                         ?>
                          <div class="item">
                             <div class="our_team text-center">
                                <div class="img_team">
                                  <!--  <a href="<?php echo site_url('category/'.$cats->slug.''); ?>"> -->
                                     <a href="<?php echo site_url('search/search/'.$cats['slug'].''); ?>">
                                    <img src="<?php echo base_url().$cats['category_image_thumb']; ?>" class="img-responsive"></a>
                             
                               <div class="food_name">
                                 <?php echo $cats['name']; ?>
                               </div>
                              </div>

                             </div>
                          </div>
					   <?php }

              } } ?>
                     </div>
    <!--slider section strat-->

    <div class="btnfind">
      <a href="<?php echo base_url('category'); ?>" class="hvr-curl-bottom-left">Find out more</a>
    </div>
     </div>
    </div>
  </section>
 <!--enu_section section strat-->

 


   <!--Recent Reviews strat-->
<section class="Recent_Reviews">
    <div class="container">
     <h1 class="cont">Top 6 performers near you</h1>
    <div class="main_know">
<?php if(!empty($userRankRatings)){ 
  $i = 0;
  $count = 0;
  foreach($userRankRatings as $performer){ 
    $i++;
    $count++;
    if($count>6){
      break;
    }
    ?>
    <?php if($i == 1){ ?>
  <div class="row top_margin">
    <?php } ?>
     <div class="col-md-6">
        <?php 
             $userProfileUrl = site_url('viewdetails/profile/'.encoding($performer['id']));
         ?>
       <a href="<?php echo $userProfileUrl; ?>">
      <div class="main_id">
       <div class="id_sectionimg">
        <?php if(!empty($performer['profile'])){ ?>
         <img src="<?php echo $performer['profile'];?>">
         <?php }else{ ?>
         <img src="<?php echo base_url().DEFAULT_IMAGE;?>">
         <?php } ?>
       </div>
      <div class="id_section">
         <h1><?php echo $performer['firstname'].' '.$performer['lastname']; ?></h1>
            <p class="fl_lft">Current Position  - </p>
            <span class="Paul">
              <strong>
                <?php if(!empty($performer['current_position'])) { echo $performer['current_position']; } ?></strong> 
                <strong> <?php if(!empty($performer['workingAt'])) { 
                  $companyProfileURL = site_url('viewdetails/profile/'.encoding($performer['workingAt_id']));
                  echo '<small> At </small><a href="'.$companyProfileURL.'"> '.$performer['workingAt'].'</a>'; } ?>

                </strong>
              </span>
         <p><?php 
         $address = array();
          if(isset($performer['city']) && !empty($performer['city']))
            $address[] = $performer['city'];
          if(isset($performer['country']) && !empty($performer['country']))
            $address[] = $performer['country'];
          if(isset($performer['zip']) && !empty($performer['zip']))
            $address[] = $performer['zip'];
          if(!empty($address)){
            $address = implode(",", $address);
            echo $address;
          }
         //echo $performer->city.', '.$performer->country.' '.$performer->zip; 

          ?></p>
        <div class="maink">
         <?php echo isset($performer['star_rating'])?$performer['star_rating']:'';?>
        </div>
               <!--    <div class="current">
            <p class="fl_lft">Current Position  - </p>
            <span class="Paul">
              <strong>
                <?php if(!empty($performer['current_position'])) { echo $performer['current_position']; } ?></strong> 
                <strong> <?php if(!empty($performer['workingAt'])) { 
                  $companyProfileURL = site_url('viewdetails/profile/'.encoding($performer['workingAt_id']));
                  echo '<small> At </small><a href="'.$companyProfileURL.'"> '.$performer['workingAt'].'</a>'; } ?>

                </strong>
              </span>
            </div> -->
       </div>
       </div>
       </a>
     </div>
     <?php if($i == 2){ ?>
   </div>
   <?php $i = 0; } ?>
<?php }} ?>
  </div>
  <br/>
  <div class="col-md-12 text-center">
<!-- work_advisor_footer -->
<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3979824042791728" data-ad-slot="4138288232" data-ad-format="auto" 
     data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
  </div>
  
  <!---
  <div class="app_store_logo">
    <a href="">
      <img src="<?php echo base_url() ?>/assets/images/itunes.png"/>
    </a>
    <a href="">
      <img src="<?php echo base_url() ?>/assets/images/play_store.png"/>
    </a>
  </div>
  _----->
</section>
  <!--Recent Reviews close-->


  
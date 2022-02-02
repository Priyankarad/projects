<?php
/*
Template name:villa-senin
*/

session_start();
$currency = 'dummy';
if(!empty($_SESSION['to_currency'])){
   $currency = $_SESSION['to_currency'];
}
require_once( get_parent_theme_file_path( 'countrylist1.php' ) );
$propertyID = '113867';
$currenDate = date('Y-m-d');
$oneYearDate = date('Y-m-d',strtotime('+1 years'));
$result =  getAvailability($propertyID,$currenDate,$oneYearDate); 
$rooms = $result['RoomsAvailability']['RoomAvailability']['DayAvailability'];
$alottedRooms = array();
$roomPrice = array();
if(!empty($rooms)){
   foreach($rooms as $room){
      if($room['Alot'] == 0){
         $alottedRooms[] = date('d-m-Y',strtotime($room['@attributes']['day']));
      }
      $date = date('d-m-Y',strtotime($room['@attributes']['day']));
      $roomPrice[$date] = number_format($room['Price']);
   }
}

$endDate = $alottedRooms;
$endDateNew = $alottedRooms;
$nextCheckoutDates = array();
foreach($endDate as $key=>$date){
   $prevDate = date('d-m-Y', strtotime($date .' -1 day'));
   if(!in_array($prevDate, $endDate)){
      $endDateNew = array_values(array_diff($endDateNew, array($date)));
      $nextCheckoutDates[] = $date;
   }
}

/*for not higlighting today's date*/
$date = date('d-m-Y');
$endDateNew[] = date('d-m-Y');
$nextCheckoutDates = array_values(array_diff($nextCheckoutDates, array($date)));

if(!empty($_POST['startDateSet'])){
   $dateStart = str_replace('/','-',$_POST['selected']);
   $oldDate =  $dateStart;
   for($i=0;$i<=365;$i++){
      $nextDate = date('d-m-Y', strtotime($oldDate .' +1 day'));
      if(in_array($nextDate,$nextCheckoutDates)){
         break;
      }else{
         $oldDate = $nextDate;
      }
   }
   echo json_encode(array('nextCheckout'=>$nextDate));die;
}

$_SESSION['pool_fence'] = get_field('pool_fence',758);
$_SESSION['image'] = '/assets/images/seninimg2.jpg';
//$_SESSION['name'] = '4 Bedroom - 01B-Villa Selasa';
$_SESSION['name'] = '2 Bedroom - Villa Senin';
$_SESSION['address_line_1'] = 'Jl.Kunti 1, Gang Mangga N.01A';
$_SESSION['address_line_2'] = '80361 Seminyak, Kuta, Bali, Indonesia';
$_SESSION['guest'] = 4;

if(!empty($_POST['currencySet'])){
   $_SESSION['to_currency'] = $_POST['currency'];
   $rates = $_SESSION['exchangeRates']->$_POST['currency'];
   $symbol = $_SESSION['symbols'][$_POST['currency']];
   echo json_encode(array('rates'=>$rates,'symbol'=>$symbol));die;
}

if($_POST){
   $_SESSION['durationPrice'] = $_POST;
   $checkAlottedDates = array();
   $startDate = $start = date('Y-m-d',strtotime(str_replace('/','-',$_POST['start_date'])));
   $startDate = strtotime($startDate);
   $endDate = $end = date('Y-m-d',strtotime(str_replace('/','-',$_POST['end_date'])));
   $endDate = strtotime($endDate);
   $status = 0;
   $_SESSION['durationPrice']['available'] = 'yes';
   for ($i=$startDate; $i<$endDate; $i+=86400) {  
      $dateCheckAlotted =  date("d-m-Y", $i);
      $checkAlottedDates[] =  date("Y-m-d", $i); 
      if(in_array($dateCheckAlotted,$alottedRooms)){
         $status = 1;
         $_SESSION['durationPrice']['available'] = 'no';
      }
   }
   $price = 0;
   $nights = 0;
   if($status == 0){
      foreach($rooms as $room){
         if(($room['Alot'] != 0) && in_array($room['@attributes']['day'],$checkAlottedDates)){
            $nights++;
            $price+=$room['Price'];
         }
      } 
   }
   $_SESSION['durationPrice']['price'] = $price;
   $_SESSION['durationPrice']['propertyID'] = $propertyID;
   $_SESSION['durationPrice']['nights'] = $nights;

   /*price calculation*/
   echo json_encode(array('status'=>$status,'price'=>$price,'nights'=>$nights));die;
}

/*currency conversion code*/ 
$toCurrency = 'USD';
if(!empty($_SESSION['to_currency'])){
   $toCurrency = $_SESSION['to_currency'];
}
$currencies = array();
$rates = 0;
if(!empty($_SESSION['exchangeRates'])){
   $currencies = (array)$_SESSION['exchangeRates'];
   $rates = $currencies[$toCurrency];
}
if(!empty($_SESSION['symbols'])){
   $symbols = $_SESSION['symbols'];
   $symbol = $symbols[$toCurrency];
}
get_header('one');
?>
<input type="hidden" id="symbol" value="<?php echo $symbol;?>">
<input type="hidden" id="currency_rate" value="<?php echo $rates;?>">
<input type="hidden" id="url" value="<?php echo home_url(); ?>">
<section class="VilaTab pd90">
   <div class="container">
      <div class="VilaTabDetail">
         <div class="row">
            <div class="col-md-8 col-sm-8 col-12">
               <div class="TabHeading">
                  <h1 class="villainner_heading"><?php the_field('my_villa_first_section_title_one',758); ?></h1>
                  <p><span class="lnr lnr-map-marker"></span><?php the_field('my_villa_first_section_title_two',758); ?></p>
                  <ul class="nav nav-pills ViaaTabul mb-3" id="pills-tab" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><span class="lnr lnr-home"></span>Overview <span class="lnr lnr-chevron-down"></span></a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><span class="lnr lnr-map-marker"></span>Map <span class="lnr lnr-chevron-down"></span></a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Rates <span class="lnr lnr-chevron-down"></span></a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="Avilabletb-tab" data-toggle="pill" href="#Avilabletb" role="tab" aria-controls="pills-contact" aria-selected="false"><span class="lnr lnr-inbox"></span>Availability <span class="lnr lnr-chevron-down"></span></a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="pills-Gallery-tab" data-toggle="pill" href="#pills-Gallery" role="tab" aria-controls="pills-contact" aria-selected="false"><span class="lnr lnr-picture"></span>Gallery <span class="lnr lnr-chevron-down"></span></a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="pills-Floor-tab" data-toggle="pill" href="#pills-Floor" role="tab" aria-controls="pills-contact" aria-selected="false"><span class="lnr lnr-picture"></span>Floor Plan <span class="lnr lnr-chevron-down"></span></a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="PillReview-tab" data-toggle="pill" href="#PillReview" role="tab" aria-controls="pills-contact" aria-selected="false"><span class="lnr lnr-neutral"></span>Reviews <span class="lnr lnr-chevron-down"></span></a>
                     </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                     <div class="mobiitem">
                        <a class="mobTab"><span class="lnr lnr-home"></span>Overview <span class="lnr lnr-chevron-down"></span></a>
                     </div>
                     <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="SlidSection">
                           <div class="TabSlider">
                              <div class="owl-carousel owl-theme Tabslide">
                                 <?php
// check if the repeater field has rows of data
                                 if( have_rows('my_villa_overview_section_one',758) ):

// loop through the rows of data
                                    while ( have_rows('my_villa_overview_section_one',758) ) : the_row();

// display a sub field value
                                       ?>
                                       <div class="item" style="background-image: url(<?php the_sub_field('my_villa_overview_section_one_image',758); ?>);">
                                       </div>
                                       <?php
                                    endwhile;

                                 else :

// no rows found

                                 endif;

                                 ?>
                                 <!-- ======ITEM END===== -->
                              </div>
                           </div>
                           <div class="Keyfacts TabmainHeading">
                              <h1><?php the_field('overview_keyfacts_title',758); ?></h1>
                              <ul class="room-details-features">
                                 <?php

// check if the repeater field has rows of data
                                 if( have_rows('overview_keyfacts_repeater',758) ):

// loop through the rows of data
                                    while ( have_rows('overview_keyfacts_repeater',758) ) : the_row();

// display a sub field value
                                       ?>
                                       <li class="room-details-features__list-item">
                                          <img src="<?php the_sub_field('overview_keyfacts_new_icon',758); ?>">
                                          <?php the_sub_field('overview_keyfacts_new_title',758); ?>
                                       </li>      

                                       <?php
                                    endwhile;

                                 else :

// no rows found

                                 endif;

                                 ?>
                              </ul>
                              <hr>
                           </div>
                           <div class="DescriptionTab TabmainHeading">
                              <h1><?php the_field('overview_description_title',758); ?></h1>
                              <div class="DesVideo">
                                 <?php the_field('overview_description_video',758); ?>
                              </div>
                              <div class="OverContent">
                                 <?php the_field('overview_long_description_',758); ?>
                              </div>
                              <div class="TabView">
                                 <a href="JavaScript:Void(0)" class="TabViewShow">View More
                                    <span class="lnr lnr-chevron-down"></span>
                                 </a>
                                 <a href="JavaScript:Void(0)" class="TabViewHide">View less
                                    <span class="lnr lnr-chevron-up"></span>
                                 </a>
                                 <hr class="TabHr">
                              </div>
                              <div class="Keyfacts TabmainHeading">
                                 <h1><?php the_field('overview_third_section_title_one',758); ?></h1>
                                 <p><?php the_field('overview_third_section_title_two',758); ?></p>
                                 <hr class="TabHr">
                              </div>
                              <div class="Keyfacts TabmainHeading">
                                 <h1><?php the_field('overview_amenities_title',758); ?></h1>
                                 <div class="MainViewSh OverContent">
                                    <div class="row">
                                       <?php
// check if the repeater field has rows of data
                                       if( have_rows('overview_amenities_repeater',758) ):

// loop through the rows of data
                                          while ( have_rows('overview_amenities_repeater',758) ) : the_row();

// display a sub field value
                                             ?>
                                             <div class="col-md-6">
                                                <div class="SleppingBox">
                                                   <p class="SlpBld"> <img src="<?php the_sub_field('overview_amenities_icon',758); ?>"> <?php the_sub_field('overview_amenities_title_second',758); ?> </p>
                                                   <p><?php the_sub_field('overview_amenities_description',758); ?></p>
                                                </div>
                                             </div>
                                             <?php
                                          endwhile;

                                       else :

// no rows found

                                       endif;

                                       ?>
                                    </div>
                                 </div>
                                 <div class="TabView">
                                    <a href="JavaScript:Void(0)" class="TabViewShow">View More
                                       <span class="lnr lnr-chevron-down"></span>
                                    </a>
                                    <a href="JavaScript:Void(0)" class="TabViewHide">View less
                                       <span class="lnr lnr-chevron-up"></span>
                                    </a>
                                    <hr class="TabHr">
                                 </div>
                              </div>
                              <div class="Keyfacts TabmainHeading">
                                 <h1><?php the_field('overview_facilities_title',758); ?></h1>
                                 <div class="FacultiesTab">
                                    <div class="row">
                                       <?php
// check if the repeater field has rows of data
                                       if( have_rows('overview_facilities_repeater',758) ):

// loop through the rows of data
                                          while ( have_rows('overview_facilities_repeater',758) ) : the_row();

// display a sub field value
                                             ?>
                                             <div class="col-md-6">
                                                <div class="SleppingBox">
                                                   <p class="SlpBld"> <img src="<?php the_sub_field('overview_facilities_image',758); ?>"> <?php the_sub_field('overview_facilities_title_two',758); ?> </p>
                                                   <p><?php the_sub_field('overview_facilities_description',758); ?></p>
                                                </div>
                                             </div>
                                             <?php
                                          endwhile;

                                       else :

// no rows found

                                       endif;

                                       ?>
                                    </div>
                                 </div>
                              </div>
                              <div class="Keyfacts TabmainHeading">
                                 <h1><?php the_field('overview_policies_title_one',758); ?></h1>
                                 <div class="FacultiesTab">
                                    <p><?php the_field('overview_policies_title_two',758); ?> </p>
                                 </div>
                                 <div class="TabCheck">
                                    <ul>
                                       <li>
                                          <img src="<?php the_field('overview_check_in_image',758);?>">
                                          <p> <strong><?php the_field('overview_check_in_title',758); ?></strong><?php the_field('overview_check_in_desc',758); ?></p>
                                       </li>
                                       <li>
                                          <img src="<?php the_field('overview_check_out_image',758);?>">
                                          <p> <strong><?php the_field('overview_check_out_title',758); ?></strong><?php the_field('overview_check_out_desc',758); ?></p>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="mobiitem">
                        <a class="nav-link"><span class="lnr lnr-map-marker"></span>Map <span class="lnr lnr-chevron-down"></span></a>
                     </div>
                     <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="Mapsection">
                           <div class="VilaMap">
                              <?php the_field('overview_map_section_one',758); ?>
                           </div>
                           <div class="LocBox">
                              <div class="loc1In">
                                 <p><?php the_field('map_location_title',758); ?></p>
                                 <p><?php the_field('map_location_description',758); ?></p>
                                 <hr class="TabHr">
                              </div>
                              <div class="loc1In">
                                 <p><?php the_field('map_destanse_title',758); ?></p>
                                 <img src="<?php the_field('map_destanse_image',758);?>">
                                 <p><?php the_field('map_destanse_description',758); ?></p>
                                 <hr class="TabHr">
                              </div>
                              <div class="loc1In">
                                 <p><?php the_field('map_airport_transfer_title_',758); ?></p>
                                 <p><?php the_field('airport_transfer_description',758); ?></p>
                                 <hr class="TabHr">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="mobiitem">
                        <a class="nav-link"><span><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/Dollar.png" class="DollorIcon"></span>Rates <span class="lnr lnr-chevron-down"></span></a>
                     </div>
                     <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div class="RatesTable">
                           <table class="table table-hover">
                              <tr>
                                 <th rowspan="" class="rates_currncy">
                                    <select class="selector ftNselct currency_select11">
                                       <option value="dummy" <?php echo ($currency == 'dummy')?'selected':'';?>>Currency </option>
                                       <?php 
                                       foreach( $age as $x => $x_value ) { ?>
                                          <option value="<?php echo $x; ?>" <?php echo ($currency == $x)?'selected':'';?>><?php echo $x." ".$x_value;?></option> 
                                       <?php } ?>
                                    </select>
                                 </th>
                                 <th class="uprcase" rowspan="1">Daily</th>
                              </tr>
                              <tbody>
                                 <?php
// check if the repeater field has rows of data
                                 if( have_rows('villats_rates_section') ):

// loop through the rows of data
                                    while ( have_rows('villats_rates_section') ) : the_row();

// display a sub field value
                                       ?>
                                       <tr>
                                          <td>
                                             <div class="rate-title"><?php the_sub_field('villats_rates_section_title_one',758); ?></div>
                                             <div class="rate-period"><?php the_sub_field('villats_rates_section_title_two',758); ?></div>
                                          </td>
                                          <td data-title="Daily">
                                             <span class="payment-prices">
                                                <span>  <?php the_sub_field('villats_rates_section_title_three',758); ?> </span>
                                             </span>
                                          </td>
                                       </tr>
                                       <?php
                                    endwhile;

                                 else :

// no rows found

                                 endif;

                                 ?>
                              </tbody>
                           </table>
                           <div class="Keyfacts TabmainHeading">
                              <h1>Policies</h1>
                              <div class="RatesShedTab">
                                 <?php the_field('villats_rates_second_section_desc_one_',758); ?>
                              </div>
                              <div class="RatesShedTab">
                                 <?php the_field('villats_rates_second_section_desc_two',758); ?>
                              </div>
                              <div class="RatesShedTab">
                                 <?php the_field('villats_rates_second_section_desc_three',758); ?>
                              </div>
                           </div>
                           <div class="Keyfacts TabmainHeading OverContent">
                              <h1><?php the_field('villat_rates_notes_title',758); ?></h1>
                              <div class="RatesShedTab">
                                 <?php the_field('villat_rates_notes_description',758); ?>
                              </div>
                           </div>
                           <div class="TabView">
                              <a href="JavaScript:Void(0)" class="TabViewShow">View More
                                 <span class="lnr lnr-chevron-down"></span>
                              </a>
                              <a href="JavaScript:Void(0)" class="TabViewHide">View less
                                 <span class="lnr lnr-chevron-up"></span>
                              </a>
                              <hr class="TabHr">
                           </div>
                        </div>
                     </div>
                     <div class="mobiitem">
                        <a class="nav-link"><span class="lnr lnr-calendar-full"></span>Availability <span class="lnr lnr-chevron-down"></span></a>
                     </div>
                     <div class="tab-pane fade" id="Avilabletb" role="tabpanel" aria-labelledby="Avilabletb-tab">
                        <div class="AllAvblityBox">
                           <form>
                              <div class="row justify-content-center">


                                 <div class="col-md-8 mb_20">
                                    <div id="availability-legend">
                                       <div class="available legend-square"></div>
                                       <span>Available</span>
                                       <div class="unavailable legend-square"></div>
                                       <span>Unavailable</span>
                                    </div>
                                 </div>

                                 <div class="col-md-8 mb_20">
                                    <!-- <input type="text" placeholder="Arrival" class="form-control InlineDate fordis "> -->
                                    <!-- <input type="text" placeholder="dd/mm/yy" class="form-control  " id="available"> -->     <div id="available"></div>                                         
                                 </div>
<!--        <div class="col-md-6 mb_20">
<input type="text" placeholder="Arrival" class="form-control InlineDate fordis ">                                           
</div>
<div class="col-md-6 mb_20">
<input type="text" placeholder="Arrival" class="form-control InlineDate fordis ">                                           
</div>
<div class="col-md-6 mb_20">
<input type="text" placeholder="Arrival" class="form-control InlineDate fordis ">                                           
</div> -->
</div>
<!--   <div class="CalPrNext">
<nav aria-label="Page navigation example">
<ul class="pagination justify-content-end">
<li class="page-item disabled">
<a class="page-link" href="#" tabindex="-1">Previous</a>
</li>
<li class="page-item"><a class="page-link" href="#">1</a></li>
<li class="page-item"><a class="page-link" href="#">2</a></li>
<li class="page-item"><a class="page-link" href="#">3</a></li> 
<li class="page-item">
<a class="page-link" href="#">Next</a>
</li>
</ul>
</nav>
</div> -->
</form>
</div>
</div>
<div class="mobiitem">
   <a class="nav-link"><span class="lnr lnr-picture"></span>Gallery <span class="lnr lnr-chevron-down"></span></a>
</div>
<div class="tab-pane fade" id="pills-Gallery" role="tabpanel" aria-labelledby="Avilabletb-tab">
   <div class="pills-GalleryT">
      <div class="row">
         <?php 
         $images = get_field('villas_gallery_section',758);
$size = 'full'; // (thumbnail, medium, large, full or custom size)

if( $images ): ?>
   <?php foreach( $images as $image ): ?>
      <div class="col-md-3">
         <div class="tabGallery">
            <a data-fancybox="gallery" href="<?php echo $image['url']; ?>">
               <?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
            </a>
         </div>
      </div>
   <?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</div>

<div class="nav-ite mobiitem">
   <a class="nav-link"><span class="lnr lnr-layers"></span>Floor Plan <span class="lnr lnr-chevron-down"></span></a>

</div>
<div class="tab-pane fade" id="pills-Floor" role="tabpanel" aria-labelledby="Avilabletb-tab">
    <div class="pills-GalleryT">
      <div class="row">
         <?php 
         $images = get_field('villas_floor_plan_gallery',758);
$size = 'full'; // (thumbnail, medium, large, full or custom size)

if( $images ): ?>
   <?php foreach( $images as $image ): ?>
      <div class="col-md-3">
         <div class="tabGallery">
            <a data-fancybox="gallery" href="<?php echo $image['url']; ?>">
               <?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
            </a>
         </div>
      </div>
   <?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</div>

<div class="nav-ite mobiitem">
   <a class="nav-link"><span class="lnr lnr-star"></span>Review <span class="lnr lnr-chevron-down"></span></a>
</div>
<!-- <div class="tab-pane fade" id="pills-Floor" role="tabpanel" aria-labelledby="Avilabletb-tab">
</div> -->
<div class="tab-pane fade" id="PillReview" role="tabpanel" aria-labelledby="Avilabletb-tab">
   <div class="Symkheading">
      <h1>Reviews</h1>    
   </div>
   <div class="ReviewUl">
      <ul>
         <?php
         if( have_rows('review_page_first_section',252) ):

            while ( have_rows('review_page_first_section',252) ) : the_row();  ?>   
               <li><img src="<?php the_sub_field('review_image',252); ?>" alt="Image" class="img-fluid"></li>
               <?php
            endwhile;
         else :   
         endif;

         ?>

      </ul>
      <p class="review_para"><?php the_field('review_page_title_one',252); ?></p>
      <p><?php the_field('review_page_title_two',252); ?></p>
      <!-- <a href="<?php the_field('review_button'); ?>" class="btn btn-cta">Write a Review</a>-->
      <a href="http://pixlritllc.com/mingguvillas/write-a-review-page/" class="btn btn-cta">Write a Review</a>
   </div>
   <div class="reviewyBox">
      <form>
         <div class="row">
            <div class="col-md-12 col-sm-12 col-12">

               <?php               
               $custom_args = array(
                  'post_type' => 'review',
                  'posts_per_page' =>-1,                
                  'order'         => 'ASC',
                  'tax_query' => array(
                     array(
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => array ('2-br-01a-villa-senin ')
                     )
                  )
               );             
               $custom_query = new WP_Query( $custom_args );

               ?>
               <?php if ( $custom_query->have_posts() ) : ?>
                  <?php while($custom_query->have_posts()): $custom_query->the_post();
                     ?>
                     <h1 class="center_heading"><?php echo get_the_id();?></h1>
                     <div class="ReviewImg">
                        <img src="<?php the_field('review_image'); ?>">
                     </div>
                  <?php endwhile; endif; ?>
<!--  <?php
// if( have_rows('villas_review_repeater',758) ):
//while ( have_rows('villas_review_repeater',758) ) : the_row();?>
<div class="ReviewImg">
<img src="<?php //the_sub_field('villas_review_images',758); ?>">
</div>
<?php //endwhile; else : endif; ?> -->

</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<!-- ==========COLUMN EIGTH END====== -->
<div class="col-md-3 col-sm-3 col-12">
   <div class="SidebarFrom">
      <form method="post" action="#" id="booking">
         <!-- <p>from 17,471 ₨ per night </p> -->
         <div class="row">
            <div class="side_new">
               <div class="col-md-12 col-sm-12 col-12">
                  <div class="form-group BannrGrup mb_20">
                     <input type="text" placeholder="Check-IN" class="form-control  " id="start_date" name="start_date" autocomplete="off" readonly>   
                     <label class="lnr lnr-calendar-full" for="start_date"></label>
                  </div>
               </div>
               <div class="col-md-12 col-sm-12 col-12">
                  <div class="form-group BannrGrup mb_20">
                     <input type="text" placeholder="Check-OUT" class="form-control  " id="end_date" name="end_date" autocomplete="off" readonly> 
                     <label class="lnr lnr-calendar-full" for="end_date"></label>
                  </div>
               </div>
               <div class="col-md-12 col-sm-12 col-12">
                  <div class="form-group BannrGrup mb_20">
                     <select name="guests" class="form-control guests" id="SlcGust">
                        <option>Guests</option>
                        <?php 
                        for($i=1;$i<=4;$i++){ ?>
                           <option value="<?php echo $i;?>" <?php echo ($i==2)?'selected':''?> ><?php echo $i;?></option>
                        <?php }
                        ?>
                     </select>
                     <label class="lnr lnr-users" for="SlcGust"></label>
                  </div>
               </div>
               <div id="total_rupees">

               </div>
               <div class="col-md-12 col-sm-12 col-12">
                  <div class="form-group BannrGrup mb_20">
                     <button type="button" class="btn SubBtn BkNow">Book Now</button>
                  </div>
               </div>
               <select class="selector ftNselct currency_select1">
                  <option value="dummy" <?php echo ($currency == 'dummy')?'selected':'';?>>Currency </option>
                  <?php 
                  foreach( $age as $x => $x_value ) { ?>
                     <option value="<?php echo $x; ?>" <?php echo ($currency == $x)?'selected':'';?>><?php echo $x." ".$x_value;?></option> 
                  <?php } ?>
               </select>
            </div>
            <div class="LoderBook hide">
               <img src="<?php bloginfo('template_url');?>/assets/images/lg.dual-ring-loader.gif" alt="Load" class="img-fluid">
            </div>
            <div class="col-md-12 col-sm-12 col-12">
               <div class="form-group BannrGrup mb_20">
                  <div class="TabContactSide">
                     <p>Or</p>
                     <button type="button" class="btn nwcntct" id ="SidConbtn">Contact Us</button>
                  </div>
               </div> 
            </div>
         </div>
      </form>
   </div>
</div>
</div>
</div>
</div>
</section>

<?php 
get_footer();
?>
<script type="text/javascript">
   var nextCheckoutDates = <?php echo json_encode($nextCheckoutDates);?>;
   $(document).on('click','.deleteDates',function(){
      $('#total_rupees').html('');
      $("#start_date").datepicker("option","maxDate", '');
      $("#end_date").datepicker("option","minDate", 0);
      $("#start_date").datepicker("option","minDate", 0);
      $("#start_date").datepicker("refresh");
      $("#end_date").datepicker("refresh");
      $('#start_date').val('');
      $('#end_date').val('');
      $("#start_date").datepicker("hide");
      $("#end_date").datepicker("hide");
      $('.LoderBook').hide();
   });
   $('.LoderBook').hide();
   $(function () {
      var currentTime = new Date();
      var startDates = <?php echo json_encode($alottedRooms);?>;
      var roomPrice = <?php echo json_encode($roomPrice);?>;
      var nextCheckout;
      $("#start_date").datepicker({
         beforeShow: addCustomInformation,
         minDate: 0,
         firstDay: 1,
         onChangeMonthYear: addCustomInformation,
         beforeShowDay: function(date){
            $('.deleteDates').show();
            var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
            var year = date.getFullYear();
            var day = ( '0' + (date.getDate()) ).slice( -2 );
            var newdate = day+"-"+month+'-'+year;
            var dateClass = day+month+year;
            if ($.inArray(newdate, startDates) == -1) {
               addCustomInformation(roomPrice[newdate],dateClass,newdate);
               return [true, dateClass];
            } else {
               return [false, "highlight", "Unavailable"];
            }
         },  
         dateFormat:'dd/mm/yy', 
         onSelect: function(selected) {
            $('.LoderBook').show();
            $('#end_date').val('');
            $("#end_date").datepicker("option","minDate", selected);
            $.ajax({
               data: {startDateSet:1,selected:selected},
               type: 'post',
               dataType: 'json',
               success: function(result) {
                  nextCheckout = result.nextCheckout;
               }
            }).done(function(){ 
               checkAvailability();
               $('.LoderBook').hide();
            });

            checkAvailability();
         },
         onClose: function () {
            $('.deleteDates').hide();
         }
      });

      //var endDates = <?php //echo json_encode($endDateNew);?>;
      var endDates = <?php echo json_encode($alottedRooms);?>;
      $("#end_date").datepicker({
         beforeShow: addCustomInformation,
         minDate: 0,
         firstDay: 1,
         onChangeMonthYear: addCustomInformation,
         beforeShowDay: function(date){
            $('.deleteDates').show();
            var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
            var year = date.getFullYear();
            var day = ( '0' + (date.getDate()) ).slice( -2 );
            var newdate = day+"-"+month+'-'+year;
            var dateClass = day+month+year;
            if ($.inArray(newdate, endDates) == -1) {
               addCustomInformation(roomPrice[newdate],dateClass,newdate);
               return [true, dateClass];
            } else {
               if(nextCheckout!=newdate){
                  return [false,"highlight", "Unavailable"];
               }else{
                  return [true, 'largeDivCal'];
               }
            }
         },  
         dateFormat:'dd/mm/yy', 
         onSelect: function(selected) {
            $("#start_date").datepicker("option","maxDate", selected);
            checkAvailability();
         },
         onClose: function () {
            $('.deleteDates').hide();
         }
      });


      $('#available').datepicker({
         inline: true,
         beforeShow: addCustomInformation,
         minDate: 0,
         firstDay: 1,
         numberOfMonths: [2, 1],
         onChangeMonthYear: addCustomInformation,
         dateFormat:'dd/mm/yy', 
         beforeShowDay: function(date){
            var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
            var year = date.getFullYear();
            var day  = ( '0' + (date.getDate()) ).slice( -2 );
            var newdate = day+"-"+month+'-'+year;
            var dateClass = day+month+year;
            if ($.inArray(newdate, startDates) == -1) {
               addCustomInformation(roomPrice[newdate],dateClass+'_available',newdate,'_available');
               return [true, dateClass+'_available'];
            } else {
               return [false,"highlight", "Unavailable"];
            }
         }
      });
   });

   $(document).on('change','.guests',function(){
      checkAvailability();
   });

   var symbol = $('#symbol').val();
   function addCustomInformation(price,dateClass,newdate,available=false) {
      var priceCal;
      var currencyRate = $('#currency_rate').val();
      priceCal = (currencyRate*price).toFixed(1);
      if (($.inArray(newdate, nextCheckoutDates) == -1) && !isNaN(priceCal)) {
      priceCal = numberWithCommas(priceCal);
         setTimeout(function() {
            $("."+dateClass).filter(function() {
               var date = $(this).text();
               return /\d/.test(date);
            }).find("a").attr('data-custom', symbol+' '+priceCal);
            
            if(available){
               $("."+dateClass).addClass('clickdisble');
            }
            /*to show start date highlighted in end date*/
            var start_date = $('#start_date').val();
            if(start_date!=''){
               start_date = start_date.split('/');
               start_date = start_date[0]+start_date[1]+start_date[2];
               if(dateClass==start_date){
                  $('.'+dateClass).find("a").addClass('ui-state-active');
               }
            }

         }, 0);
      }else{
         setTimeout(function() {
            $("."+dateClass).find("a").addClass('largeDiv');
         });
      }
   }

   $(document).on('change','.currency_select1',function(){
      $('.LoderBook').show();
      var currency = $(this).val();
      if(currency!=''){
         var option = $('.currency_select1 .item').text();
         $('.currency_select .item').text(option);
         $('.currency_select .item').attr('data-value',currency);
         $('.currency_select11 .item').text(option);
         $('.currency_select11 .item').attr('data-value',currency);
         setCurrency(currency);
      }
   });
   
   $(document).on('change','.currency_select11',function(){
      var currency = $(this).val();
      if(currency!=''){
         var option = $('.currency_select11 .item').text();
        $('.currency_select .item').text(option);
        $('.currency_select .item').attr('data-value',currency);
        $('.currency_select1 .item').text(option);
        $('.currency_select1 .item').attr('data-value',currency);
        setCurrency(currency);
     }
   });

   function setCurrency(currency){
      $.ajax({
         data: {currency:currency,currencySet:1},
         type: 'post',
         dataType: 'json',
         success: function(result) {
            $('#currency_rate').val(result.rates);
            $('#symbol').val(result.symbol);
            symbol = result.symbol;
         }
      }).done(function(){ 
         checkAvailability();
         $('.LoderBook').hide();
         $('#available').datepicker("refresh");
         $('#start_date').datepicker("refresh");
         $('#end_date').datepicker("refresh");
      });
   }

   function checkAvailability(){
      var startDate = $('#start_date').val();
      var endDate   = $('#end_date').val();
      if((startDate != '') && (endDate != '')){
         var date1 = $('#start_date').val();
         var date2 = $('#end_date').val();
         var d1 = date1.split("/");
         var d2 = date2.split("/");
         d1 = d1[2]+d1[1]+d1[0];
         d2 = d2[2]+d2[1]+d2[0];
         if (parseInt(d2) > parseInt(d1)) {
            $('.LoderBook').show();
            $.ajax({
               data: $('#booking').serialize(),
               type: 'post',
               dataType: 'json',
               success: function(result) {
                  if(result.status == 0){
                     var currencyRate = $('#currency_rate').val();
                     priceCal = (currencyRate*result.price).toFixed(1);
                     var price = result.price.toFixed(2);
                     price = numberWithCommas(price);
                     var night = 'Night';
                     if(result.nights>1){
                        night = 'Nights';
                     }
                     priceCal = numberWithCommas(priceCal);
                     $('#total_rupees').html('<span style="color:#942424;">'+result.nights+' '+night+'/Total '+symbol+priceCal+'</span>');
                     $('.BkNow').prop('disabled',false);
                  }else{
                     $('.BkNow').prop('disabled',true);
                     $('#total_rupees').html('<span style="color:#942424;">The selected days are not available</span>');
                  }
                  $('.LoderBook').hide();
               }
            });
         }else{
            Ply.dialog("alert",'Check-OUT date should be greater than Check-IN date');
            $('#total_rupees').html('');
         }
      }
   }

   function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
   }

   $(document).on('click','.BkNow',function(){
      var url = $('#url').val();
      var startDate = $('#start_date').val();
      var endDate   = $('#end_date').val();
      if((startDate != '') && (endDate != '')){
         var date1 = $('#start_date').val();
         var date2 = $('#end_date').val();
         var d1 = date1.split("/");
         var d2 = date2.split("/");
         d1 = d1[2]+d1[1]+d1[0];
         d2 = d2[2]+d2[1]+d2[0];
         if (parseInt(d2) > parseInt(d1)) {
            window.location.href= url+'/booking';
         }
         else{
            Ply.dialog("alert",'Check-OUT date should be greater than Check-IN date');
            $('#total_rupees').html('');
         }
      }else{
         Ply.dialog("alert",'Please select both the dates');
      }
   });
 $(document).on('click','#SidConbtn',function(){
      var url = $('#url').val();
      var startDate = $('#start_date').val();
      var endDate   = $('#end_date').val();
      if((startDate != '') && (endDate != '')){
         var date1 = $('#start_date').val();
         var date2 = $('#end_date').val();
         var d1 = date1.split("/");
         var d2 = date2.split("/");
         d1 = d1[2]+d1[1]+d1[0];
         d2 = d2[2]+d2[1]+d2[0];
         if (parseInt(d2) > parseInt(d1)) {
            window.location.href= url+'/contact';
         }
         else{
            Ply.dialog("alert",'Check-OUT date should be greater than Check-IN date');
            $('#total_rupees').html('');
         }
      }else{
         Ply.dialog("alert",'Please select both the dates');
      }
   });
      
</script>
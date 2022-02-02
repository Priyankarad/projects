<?php
/*
Template name:ab-villa-senser
*/

session_start();
$propertyID = '562554';
$currenDate = date('Y-m-d');
$oneYearDate = date('Y-m-d',strtotime('+1 years'));
$result =  getAvailability($propertyID,$currenDate,$oneYearDate); 
$rooms = $result['RoomsAvailability']['RoomAvailability']['DayAvailability'];
$alottedRooms = array();
if(!empty($rooms)){
   foreach($rooms as $room){
      if($room['Alot'] == 0){
         $alottedRooms[] = date('d-m-Y',strtotime($room['@attributes']['day']));
      }
   }
}

// $roomsArr = json_encode($alottedRooms);

if($_POST){
   $_SESSION['durationPrice'] = $_POST;
   $checkAlottedDates = array();
   $startDate = $start = date('Y-m-d',strtotime(str_replace('/','-',$_POST['start_date'])));
   $startDate = strtotime($startDate);
   $endDate = $end = date('Y-m-d',strtotime(str_replace('/','-',$_POST['end_date'])));
   $endDate = strtotime($endDate);
   $status = 0;
   $_SESSION['durationPrice']['available'] = 'yes';
   for ($i=$startDate; $i<=$endDate; $i+=86400) {  
      $dateCheckAlotted =  date("d-m-Y", $i); 
      $checkAlottedDates[] =  date("Y-m-d", $i); 
      if(in_array($dateCheckAlotted,$alottedRooms)){
         $status = 1;
         $_SESSION['durationPrice']['available'] = 'no';
      }
   }
   $price = 0;
   if($status == 0){
      foreach($rooms as $room){
         if(($room['Alot'] != 0) && in_array($room['@attributes']['day'],$checkAlottedDates)){
            $price+=$room['Price'];
         }
      } 
   }
   $_SESSION['durationPrice']['price'] = $price;
   $_SESSION['durationPrice']['propertyID'] = $propertyID;

   /*price calculation*/
   echo json_encode(array('status'=>$status,'price'=>$price));die;
}
get_header('one');
?>
<input type="hidden" id="url" value="<?php echo home_url(); ?>">
<section class="VilaTab pd90">
   <div class="container">
      <div class="VilaTabDetail">
         <div class="row">
            <div class="col-md-8 col-sm-8 col-12">
               <div class="TabHeading">
                  <h1><?php the_field('my_villa_first_section_title_one',356); ?></h1>
                  <p><span class="lnr lnr-map-marker"></span><?php the_field('my_villa_first_section_title_two',356); ?></p>
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
                        <a class="nav-link" id="PillReview-tab" data-toggle="pill" href="#PillReview" role="tab" aria-controls="pills-contact" aria-selected="false"><span class="lnr lnr-neutral"></span>Review <span class="lnr lnr-chevron-down"></span></a>
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
                                 if( have_rows('my_villa_overview_section_one',356) ):

// loop through the rows of data
                                    while ( have_rows('my_villa_overview_section_one',356) ) : the_row();

// display a sub field value
                                       ?>
                                       <div class="item" style="background-image: url(<?php the_sub_field('my_villa_overview_section_one_image',356); ?>);">
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
                              <h1><?php the_field('overview_keyfacts_title',356); ?></h1>
                              <ul class="room-details-features">
                                 <?php

// check if the repeater field has rows of data
if( have_rows('overview_keyfacts_repeater',356) ):

   // loop through the rows of data
    while ( have_rows('overview_keyfacts_repeater',356) ) : the_row();

        // display a sub field value
?>
 <li class="room-details-features__list-item">
 <img src="<?php the_sub_field('overview_keyfacts_new_icon',356); ?>">
 <?php the_sub_field('overview_keyfacts_new_title',356); ?>
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
                              <h1><?php the_field('overview_description_title',356); ?></h1>
                              <div class="DesVideo">
                                 <?php the_field('overview_description_video',356); ?>
                              </div>
                              <div class="OverContent">
                                 <?php the_field('overview_long_description_',356); ?>
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
                                 <h1><?php the_field('overview_third_section_title_one',356); ?></h1>
                                 <p><?php the_field('overview_third_section_title_two',356); ?></p>
                                 <hr class="TabHr">
                              </div>
                              <div class="Keyfacts TabmainHeading">
                                 <h1><?php the_field('overview_amenities_title',356); ?></h1>
                                 <div class="MainViewSh OverContent">
                                    <div class="row">
                                       <?php
// check if the repeater field has rows of data
                                       if( have_rows('overview_amenities_repeater',356) ):

// loop through the rows of data
                                          while ( have_rows('overview_amenities_repeater',356) ) : the_row();

// display a sub field value
                                             ?>
                                             <div class="col-md-6">
                                                <div class="SleppingBox">
                                                   <p class="SlpBld"> <img src="<?php the_sub_field('overview_amenities_icon',356); ?>"> <?php the_sub_field('overview_amenities_title_second',356); ?> </p>
                                                   <p><?php the_sub_field('overview_amenities_description',356); ?></p>
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
                                 <h1><?php the_field('overview_facilities_title',356); ?></h1>
                                 <div class="FacultiesTab">
                                    <div class="row">
                                       <?php
// check if the repeater field has rows of data
                                       if( have_rows('overview_facilities_repeater',356) ):

// loop through the rows of data
                                          while ( have_rows('overview_facilities_repeater',356) ) : the_row();

// display a sub field value
                                             ?>
                                             <div class="col-md-6">
                                                <div class="SleppingBox">
                                                   <p class="SlpBld"> <img src="<?php the_sub_field('overview_facilities_image',356); ?>"> <?php the_sub_field('overview_facilities_title_two',356); ?> </p>
                                                   <p><?php the_sub_field('overview_facilities_description',356); ?></p>
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
                                 <h1><?php the_field('overview_policies_title_one',356); ?></h1>
                                 <div class="FacultiesTab">
                                    <p><?php the_field('overview_policies_title_two',356); ?> </p>
                                 </div>
                                 <div class="TabCheck">
                                    <ul>
                                       <li>
                                           <img src="<?php the_field('overview_check_in_image',356);?>">
                                          <p> <strong><?php the_field('overview_check_in_title',356); ?></strong><?php the_field('overview_check_in_desc',356); ?></p>
                                       </li>
                                       <li>
                                          <img src="<?php the_field('overview_check_out_image',356);?>">
                                          <p> <strong><?php the_field('overview_check_out_title',356); ?></strong><?php the_field('overview_check_out_desc',356); ?></p>
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
                              <?php the_field('overview_map_section_one',356); ?>
                           </div>
                           <div class="LocBox">
                              <div class="loc1In">
                                 <p><?php the_field('map_location_title',356); ?></p>
                                 <p><?php the_field('map_location_description',356); ?></p>
                                 <hr class="TabHr">
                              </div>
                              <div class="loc1In">
                                 <p><?php the_field('map_destanse_title',356); ?></p>
                                <img src="<?php the_field('map_destanse_image',356);?>">
                                 <p><?php the_field('map_destanse_description',356); ?></p>
                                 <hr class="TabHr">
                              </div>
                              <div class="loc1In">
                                 <p><?php the_field('map_airport_transfer_title_',356); ?></p>
                                 <p><?php the_field('airport_transfer_description',356); ?></p>
                                 <hr class="TabHr">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="mobiitem">
                        <a class="nav-link"><span class="lnr lnr-map-marker"></span>Rates <span class="lnr lnr-chevron-down"></span></a>
                     </div>
                     <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div class="RatesTable">
                           <table class="table table-hover">
<tr>
<th rowspan="" class="rates_currncy">
<select id="radio_price" class="form-control">
<option value="payment">USD ($)</option>
<option value="user">INR (₨)</option>
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
                                             <div class="rate-title"><?php the_sub_field('villats_rates_section_title_one',356); ?></div>
                                             <div class="rate-period"><?php the_sub_field('villats_rates_section_title_two',356); ?></div>
                                          </td>
                                          <td data-title="Daily">
                                             <span class="payment-prices">
                                                <span>  <?php the_sub_field('villats_rates_section_title_three',356); ?> </span>
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
                                 <?php the_field('villats_rates_second_section_desc_one_',356); ?>
                              </div>
                              <div class="RatesShedTab">
                                 <?php the_field('villats_rates_second_section_desc_two',356); ?>
                              </div>
                              <div class="RatesShedTab">
                                 <?php the_field('villats_rates_second_section_desc_three',356); ?>
                              </div>
                           </div>
                           <div class="Keyfacts TabmainHeading OverContent">
                              <h1><?php the_field('villat_rates_notes_title',356); ?></h1>
                              <div class="RatesShedTab">
                                 <?php the_field('villat_rates_notes_description',356); ?>
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
                        <a class="nav-link"><span class="lnr lnr-map-marker"></span>Availability <span class="lnr lnr-chevron-down"></span></a>
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
   <a class="nav-link"><span class="lnr lnr-map-marker"></span>Gallery <span class="lnr lnr-chevron-down"></span></a>
</div>
<div class="tab-pane fade" id="pills-Gallery" role="tabpanel" aria-labelledby="Avilabletb-tab">
   <div class="pills-GalleryT">
      <div class="row">
         <?php 
         $images = get_field('villas_gallery_section',356);
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
   <a class="nav-link"><span class="lnr lnr-map-marker"></span>Review <span class="lnr lnr-chevron-down"></span></a>
</div>
<div class="tab-pane fade" id="PillReview" role="tabpanel" aria-labelledby="Avilabletb-tab">
   <div class="reviewyBox">
      <form>
         <div class="row">
            <div class="col-md-12 col-sm-12 col-12">
               <?php
// check if the repeater field has rows of data
               if( have_rows('villas_review_repeater',356) ):

// loop through the rows of data
                  while ( have_rows('villas_review_repeater',356) ) : the_row();

// display a sub field value
                     ?>
                     <div class="ReviewImg">
                        <img src="<?php the_sub_field('villas_review_images',356); ?>">
                     </div>
                     <?php
                  endwhile;

               else :

// no rows found

               endif;

               ?>
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
            <div class="col-md-12 col-sm-12 col-12">
               <div class="form-group BannrGrup mb_20">
                  <input type="text" placeholder="dd/mm/yy" class="form-control  " id="start_date" name="start_date" autocomplete="off" readonly="">   
                  <label class="lnr lnr-calendar-full" for="start_date"></label>
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-12">
               <div class="form-group BannrGrup mb_20">
                  <input type="text" placeholder="dd/mm/yy" class="form-control  " id="end_date" name="end_date" autocomplete="off" readonly=""> 
                  <label class="lnr lnr-calendar-full" for="end_date"></label>
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-12">
               <div class="form-group BannrGrup mb_20">
                  <select name="guests" class="form-control guests" id="SlcGust">
                     <option>1</option>
                     <option selected="selected">2</option>
                     <option>3</option>
                     <option>4</option>
                     <option>5</option>
                     <option>6</option>
                     <option>7</option>
                     <option>8</option>
                     <option>9</option>
                     <option>10</option>
                     <option>11</option>
                     <option>12</option>
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
            <div class="LoderBook hide">
               <img src="<?php bloginfo('template_url');?>/assets/images/lg.dual-ring-loader.gif" alt="Load" class="img-fluid">
            </div>

            <div class="TabContactSide">
               <p>Or</p>
                <button type="button" class="btn SubBtn" id ="SidConbtn"><a href="contact">Contact Us<a/></button>
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
   //var alink = 0;
   $('.LoderBook').hide();
   $(function () {
      var currentTime = new Date();
      var startDates = <?php echo json_encode($alottedRooms);?>;
      console.log(startDates);
      $("#start_date").datepicker({
         minDate: 0,
         beforeShowDay: function(date){
            var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
            var year = date.getFullYear();
            var day = ( '0' + (date.getDate()) ).slice( -2 );
            var newdate = day+"-"+month+'-'+year;
            if ($.inArray(newdate, startDates) == -1) {
               return [true, ""];
            } else {
               return [false, "highlight", "Unavailable"];
            }
         },  
         dateFormat:'dd/mm/yy', 
         onSelect: function(selected) {
            $("#end_date").datepicker("option","minDate", selected);
            var startDate = $('#start_date').val();
            var endDate   = $('#end_date').val();
            if(endDate == ''){
               Ply.dialog("alert",'Please select both the dates');
            }else{
               checkAvailability();
            }
         },
      });
      var endDates = <?php echo json_encode($alottedRooms);?>;
      $("#end_date").datepicker({
         minDate: 0,
         beforeShowDay: function(date){
            var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
            var year = date.getFullYear();
            var day = ( '0' + (date.getDate()) ).slice( -2 );
            var newdate = day+"-"+month+'-'+year;
            if ($.inArray(newdate, endDates) == -1) {
               return [true, ""];
            } else {
               return [false,"highlight", "Unavailable"];
            }
         },  
         dateFormat:'dd/mm/yy', 
         onSelect: function(selected) {
            var startDate = $('#start_date').val();
            var endDate   = $('#end_date').val();
            if(startDate == ''){
               Ply.dialog("alert",'Please select both the dates');
            }else{
               checkAvailability();
            }
         },
      });

      $('#available').datepicker({
         inline: true,
         minDate: 0,
         dateFormat:'dd/mm/yy', 
         beforeShowDay: function(date){
            var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
            var year = date.getFullYear();
            var day  = ( '0' + (date.getDate()) ).slice( -2 );
            var newdate = day+"-"+month+'-'+year;
            if ($.inArray(newdate, endDates) == -1) {
               return [true, ""];
            } else {
               return [false,"highlight", "Unavailable"];
            }
         }
      });

   });

   $(document).on('change','.guests',function(){
      checkAvailability();
   });

   function checkAvailability(){
      $('.LoderBook').show();
      $.ajax({
         data: $('#booking').serialize(),
         type: 'post',
         dataType: 'json',
         success: function(result) {
            if(result.status == 0){
               var price = result.price.toFixed(2);
               price = numberWithCommas(price);
               //$('#total_rupees').html('<span style="color:#942424;">Total '+price+' Rs</span>');
               $('#total_rupees').html('<span style="color:#942424;">Total $'+price+'</span>');
               //alink = 1;
            }else{
               $('#total_rupees').html('<span style="color:#942424;">No availability found for the dates provided</span>');
               //alink = 0;
            }
            $('.LoderBook').hide();
         }
      });
   }

   function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
   }

   $(document).on('click','.BkNow',function(){
      var url = $('#url').val();
      //if(alink == 1){
         window.location.href= url+'/booking';
      //}
   });
</script>




<?php
/*
  Template name:kerobokan
*/
// session_destroy();
session_start();
require_once( get_parent_theme_file_path( 'countrylist1.php' ) );
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
if($symbol == ''){
  $symbol = 'USD $';
}
get_header('new');

?>

<section class="SemiyakSec SecKrseyMr">
  <div class="container">
       <div class="row">

      <?php

// check if the repeater field has rows of data
if( have_rows('kerobokan_second_section_repeater') ):

  // loop through the rows of data
    while ( have_rows('kerobokan_second_section_repeater') ) : the_row();

        // display a sub field value
        ?>
        
         <div class="col-md-3 col-sm-3 col-12">
            <div class="smiyakBox">
              <div class="SymakImg">
                <img src="<?php the_sub_field('kerobokan_first_section_image'); ?>" alt="image" class="img-fluid">
                <p><?php the_sub_field('kerobokan_first_section_title'); ?></p>
              </div>
              <div class="SimyakPara">
                <p><?php the_sub_field('kerobokan_first_section_description'); ?></p>
              </div>
            </div>
          </div>
        <?php
    endwhile;

else :

    // no rows found

endif;

?>
      

          
    </div>
       <hr class="SemiHr">
  </div>
</section>

<section class="RusterBanner">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-12"> 
        <div class="RusterImg" style="background-image: url('<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/kerbiplex.jpeg');">
         <!-- <p>unforgettable Bali sunset</p>-->
        </div>
      </div>
    </div>
     <hr class="SemiHr">
  </div>
</section> 


<section class="LuxuryFun">
  <div class="container">
       <div class="row justify-content-center">
                     <div class="col-md-11 col-sm-11 col-12"> 
                       <div class="Luxerycontent">
                          <h2><?php the_field('kerobokan_first_section_title_one',129); ?></h2>
                          <h4><?php the_field('kerobokan_first_section_title_two',129); ?></h4>
                      </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 col-sm-6 col-12">
            <div class="Lpara">
<ul class="LuxeryUl">
              <?php

// check if the repeater field has rows of data
if( have_rows('kerobokan_first_section_repeater',129) ):

  // loop through the rows of data
    while ( have_rows('kerobokan_first_section_repeater',129) ) : the_row();

        // display a sub field value
  ?>
       
       <li><img src="<?php the_sub_field('kerobokan_first_section_image',129); ?>" alt="image" class="img-fluid"></li>
  <?php
    endwhile;

else :

    // no rows found

endif;

?>
              
            </ul>
              <?php the_field('kerobokan_first_section_description',129); ?>
            </div>
          </div>
           <div class="col-md-6 col-sm-6 col-12">
            <div class="Lpara MobLpara">
             <?php the_field('kerobokan_first_section_video',129); ?>
            </div>
            
          </div>
        </div>
       <hr class="SemiHr">
  </div>
</section>





<section class="RusterBanner">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-12"> 
        <div class="RusterImg" style="background-image: url('<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/Besakih.jpeg');">
          <!--<p>the island of Gods</p>-->
        </div>
      </div>
    </div>
     <hr class="SemiHr">
  </div>
</section> 

<section class="vila_section">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="Symkheading semiRPd4">
    <h1><?php the_field('kerobokan_second_section_title'); ?></h1>
  </div>
    <hr class="SemiHr">
    </div>
  </div>

 <div class="row justify-content-center custom-border-cls">
   
   <?php
              $args = array( 
                'post_type' => 'kerobokan', 
                'posts_per_page' => 8, 
                'order' => 'DESC'
                 );
              
$loop = new WP_Query( $args );
$count = 0;
while ( $loop->have_posts() ) : $loop->the_post();
  $metaData = get_post_meta(get_the_id());
  $villaID = $metaData['villa_id'][0];
  $count++;
  $minPrice = $wpdb->get_row("SELECT price FROM min_price WHERE villa_id=".$villaID);
  $price = $minPrice->price*$rates;

            ?>
   <div class="col-md-5">
      <div class="video_section"><?php the_field('karebokan_post_video'); ?></div>
      <div class="Vtext_section NwVtxSct">
          <div class="Vinner_text">
         <h4><span><?php the_title(); ?></span></h4>
         
       </div>
       <div class="AgnHalf agnhalf22Pad">
        <button class=" room_btn roombtnMaxw rombrrad ">
      <span>Start From</span> 
      <span><?php echo number_format($price,1).' '.$symbol; ?> </span>
      <a href="<?php home_url().the_field('page_url')?>?villa=1" class="btn btn-cta room_anchor VilaSrchSt">Book Now</a>
     </button>
        <!--  <h6><a href="<?php home_url().the_field('page_url')?>?villa=1" class="btn btn-cta">Start From <?php echo number_format($price,1).' '.$symbol; ?>
           <button class="HvrSymBkk">Book Now</button>
           </a>
         </h6> -->
         <a href="<?php home_url().the_field('page_url')?>?villa=1" class="btn btn-cta rombrrad2a">Book Now</a>
       </div>
        
         <p><?php the_field('karebokan_post_description'); ?></p>
      </div>
   </div>
 <?php
 if($count%2 == 0)
{
  echo '</div><div class="row justify-content-center custom-border-cls">';
} 
endwhile;
?>  
  <div class="col-md-5">
      <div class="video_section ">
        <div id="map1"></div>
      </div>
     
       </div>


 

</div>

<!-- <div class="row justify-content-center mt_20 mb_20">
  <div class="col-md-5">
    <div class="Main_vd">
      <div class="video_section">
         <img src="<?php //bloginfo( 'stylesheet_directory' ); ?>/assets/images/Archdalel.png" alt="image" class="img-fluid">
      </div>
     </div>
   </div>
 </div>
</div> -->
</section>

<?php 
get_footer();
$_SESSION['city'] = 'Kerobokan';?>

<script type="text/javascript">
  $(function () {
  $("#start_date").datepicker({
    minDate: 0,
    dateFormat:'dd/mm/yy',
    onSelect: function(selected) {
      $("#end_date").datepicker("option","minDate", selected)
    }
  });
  $("#end_date").datepicker({
    minDate: 0,
    dateFormat:'dd/mm/yy', 
    onSelect: function (selected) {
      $("#start_date").datepicker("option","maxDate", selected)
    }
  });
  });
  $(document).on('click','.deleteDates',function(){
        $('#start_date').val('');
        $('#end_date').val('');
        $("#start_date").datepicker("hide");
        $("#end_date").datepicker("hide");
    });
  var myLatlng = new google.maps.LatLng(-8.340539,115.091949);
    $(window).load(function(){
        var img_url = $('#img_url').val();

        var myOptions = {
            zoom: 8,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map1 = new google.maps.Map(document.getElementById("map1"), myOptions);
        var url = img_url+'blue-dot.png';
        var myLatLng1 = {lat: -8.670317, lng: 115.166442};
        var marker = new google.maps.Marker({
            position: myLatLng1,
            map: map1,
            icon:url
        });
        google.maps.event.addListener( marker, 'click', function(e){
            map1.setZoom(13);
            map1.panTo(this.position);
        }.bind( marker ) );
    });

</script>

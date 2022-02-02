<?php
/**
* The front page template file
*
* If the user has selected a static page for their homepage, this is what will
* appear.
* Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package WordPress
* @subpackage Twenty_Seventeen
* @since 1.0
* @version 1.0
*/

get_header(); 
session_start();
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
?>

<!-- section-comment-by-shubham -->

<section class="SemiyakSec Semif8Bk">
    <div class="container">
        <div class="semi_extra_con">

            <div class="row">
                <?php


                if( have_rows('home_page_third_section_repeater') ):


                    while ( have_rows('home_page_third_section_repeater') ) : the_row();


                        ?>

                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="smiyakBox">
                                <div class="SymakImg">
                                    <img src="<?php the_sub_field('home_page_third_section_image'); ?>" alt="image" class="img-fluid">
                                    <p><?php the_sub_field('home_page_third_section_title'); ?></p>
                                </div>
                                <div class="SimyakPara">
                                    <?php the_sub_field('home_page_fourth_section_description'); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;

                else :



                endif;

                ?>


            </div>
            <hr class="SemiHr">
        </div>
    </div>
</section>
<!-- section-comment-by-shubham -->

<!-- section-creat-by-shubham -->
<section class="mainpage-secvice_werapper">
    <div class="container">

        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title" data-id="h41">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="collapseMain">
                                    <p> <img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/12/I-0001.svg" class="imggsecvice">fav location</p>
                                </a>
                            </h4>
                        </div>
                        <!--   -->
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title" data-id="h42">
                                <a class="collapsed collapseMain" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/12/I-0002.svg" class="imggsecviceone">best rates</p>
                                </a>
                            </h4>
                        </div>
                        <!--  -->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title" data-id="h43">
                                <a class="collapsed collapseMain" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/12/I-0003.svg" class="imggsecviceyhree">inclusions</p>
                                </a>
                            </h4>
                        </div>
                        <!--  -->
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingfour">
                            <h4 class="panel-title" data-id="h44">
                                <a class="collapsed collapseMain" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                    <p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/12/I-0004.svg" class="imggsecvice">extra services</p>
                                </a>
                            </h4>
                        </div>
                        <!--  -->
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <div class="contant-pergrap">
                                <p>Located in a peaceful and strategic position in the most exclusive area of Seminyak, just a few step away to many bars, restaurants, shops and SPAs, only 1.4 km from the beach.</p> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <div class="contant-pergrap">
                                <p>Always with stunning service and 20% less than any nearby same bedroom villa, choose your favourite one between many different price budgets, sizes and architectural designs.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <div class="contant-pergrap">
                                <p> Unlimited Wi-Fi internet connection, freshly prepared daily breakfast***, local SIM smartphone with flat 3G internet connection and more.</p>
                                <small>***verify each villa details for inclusions.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="collapsefour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfour">
                        <div class="panel-body">
                            <div class="contant-pergrap">
                                <p>On request we organize the followings: private dinners, birthdays and wedding events, massages and beauty treatments, private drivers, tours and special activities.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- section-creat-by-shubham -->

<section class="RusterBanner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-12"> 
                <div class="RusterImg" style="background-image: url('<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/shortimg-min.jpeg');">
                    <!--<p>Explore the traditions of Bali</p>-->
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
                    <h2><?php the_field('home_page_second_section_title'); ?></h2>
                    <h4><?php the_field('home_page_second_section_title_two'); ?></h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12 col-12">
                <div class="Lpara">
                    <ul class="LuxeryUl">
                        <?php

// check if the repeater field has rows of data
                        if( have_rows('home_page_second_section_repeater') ):

// loop through the rows of data
                            while ( have_rows('home_page_second_section_repeater') ) : the_row();

// display a sub field value
                                ?>

                                <li>
                                    <img src="<?php the_sub_field('home_page_second_section_image_repeater'); ?>" alt="image" class="img-fluid">
                                </li>
                                <?php
                            endwhile;

                        else :

// no rows found

                        endif;

                        ?>




                    </ul>
                    <?php the_field('home_page_second_section_description'); ?>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-12">
                <div class="Lpara MobLpara">
                    <?php the_field('home_page_second_section_video'); ?>
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
                <div class="RusterImg" style="background-image: url('<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/Ubud-min.jpeg');">
                    <!-- <p>Explore the nature of Bali</p>-->
                </div>
            </div>
        </div>
        <hr class="SemiHr">
    </div>
</section>




<?php 
$count=0;
if( have_rows('home_page_fifth_section_repeater') ):
    while ( have_rows('home_page_fifth_section_repeater') ) : the_row();       
        $count++;?>
        <section class="vila_section">
            <div class="container-fluid">
                <div class="MainVilaNw container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="MainLocNw">
                                <a href="<?php the_sub_field('home_page_fifth_section_page_link');?>" class="Kerbo"><?php the_sub_field('home_page_fifth_section_title'); ?></a>        
                            </div>
                        </div>
                    </div>

                    <div class="DiscovrRow">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-12">
                                <div class="video_section Video2secM">
                                    <p><?php the_sub_field('home_page_fifth_section_video'); ?><!-- <iframe width="100%" height="350" src="https://www.youtube.com/embed/7KPpf_b5h1g?rel=0&amp;wmode=transparent&amp;wmode=transparent" frameborder="0" allowfullscreen=""> </iframe> -->
                                    </p>
                                </div>
                            </div>
                            <!--  =========COLUMN SIX END==== -->
                            <div class="col-md-6 col-sm-12 col-12">
                                <div class="video_section">
                                    <p><?php //the_sub_field('home_page_fifth_section_map'); ?><!-- <iframe width="100%" height="350" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=-8.689489, 115.168726&amp;key=AIzaSyA-CKe_OdxuiL0kLktBC1ajet6gICk94EE"></iframe> --> 
                                        <?php 
                                        if($count == 1){
                                            ?>
                                            <div id="map1"></div>
                                        <?php } else{
                                            ?>
                                            <div id="map2"></div>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                            <!--  =========COLUMN SIX END==== -->
                        </div>
                    </div>




                    <div class="DiscovrRow">
                        <div class="row">
                            <div class="col-md-8 col-sm-9 col-12">

                                <div class="Vinner_text">
                                    <p><?php the_sub_field('home_page_fifth_section_description_one'); ?></p>
                                    <!--<a href="search-listing.html" class="btn btn-cta">Book Now</a>-->
                                </div> 
                            </div>
                            <!--  =========COLUMN SIX END==== -->
                            <div class="col-md-2 col-sm-3 col-12">
                                <button class=" room_btn RoomBtn223">
                                    <span>Start From</span> <span>
                                        <?php 
                                        $city = 'Kerobokan';
                                        if($count == 1){
                                            $city = 'Seminyak';
                                        }

                                        $minPrice = $wpdb->get_row("SELECT min(price) as price FROM min_price WHERE city='".$city."'");
                                        $price = $minPrice->price*$rates;
                                        echo number_format($price,1).' '.$symbol;
                                        ?>
                                    </span>
                                    <a href="<?php home_url()?>/new/villas" class="btn btn-cta room_anchor"><?php the_sub_field('home_book_now_button');?></a>
                                </input>
                            </button>
                        </div>
                        <!--  =========COLUMN SIX END==== -->
                        <!--  =========COLUMN SIX END==== -->
                        <div class="col-md-2 col-sm-3 col-12">
                            <div class="videoBkBtn btnvidbkrad">
                                <a href="<?php home_url()?>/new/villas" class="btn btn-cta"><?php the_sub_field('home_book_now_button');?></a>
                            </div>
                        </div>
                        <!--  =========COLUMN SIX END==== -->
                    </div>
                </div>
            </div>
            <?php if($count==1){?><hr>
            <section class="RusterBanner remvcontaFLuid">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12"> 
                            <div class="RusterImg" style="background-image: url('<?php the_field('home_page_fourth_section_background_image'); ?>');">
                                <!--<p><?php //the_field('home_page_fourth_section_title'); ?></p>-->
                            </div>
                        </div>
                    </div>
                    <hr class="SemiHr">
                </div>
            </section>
        <?php  } ?>   
    </div>
</section>
<?php
endwhile;
else :   

endif;

?>
<!-- <section class="vila_section">
<div class="container">
<hr class="SemiHr">
<div class="row">
<div class="col-md-12">
<div class="Symkheading">
<h1><?php the_field('home_page_fourth_section_heading'); ?></h1>
</div>
</div>
</div>


<div class="row justify-content-center">

<?php


if( have_rows('home_page_fifth_section_repeater') ):


while ( have_rows('home_page_fifth_section_repeater') ) : the_row();


?>

<div class="col-md-5">

<div class="MainLoc">
<a href="#" class="Kerbo"><?php the_sub_field('home_page_fifth_section_title'); ?></a>
<div class="video_section">
<p><?php the_sub_field('home_page_fifth_section_video'); ?>
</p>
</div>
<div class="Vtext_section"> -->
<!--  <div class="Vinner_text">
<h4><span>5 Bedroom - 04-VILLA SABTU</span></h4>
<a href="" class="btn btn-cta">Book Now</a>
</div> -->
<!-- <h6>Prices start from US$ 455 per night</h6> -->
<!--  <p><?php the_sub_field('home_page_fifth_section_description_one'); ?></p>
</div>


<div class="KerMap">
<?php the_sub_field('home_page_fifth_section_map'); ?>

<div class="MapButton">
<a href="<?php the_sub_field('home_page_fifth_section_button'); ?>" class="btn btn-cta">Discover Seminyak</a>
</div>

<div class="Vinner_text">
<p><?php the_sub_field('home_page_fifth_section_description_two'); ?></p>
<a href="<?php the_sub_field('home_book_now_button'); ?>" class="btn btn-cta">Book Now</a>
</div> 

</div>


</div></div>
<?php
endwhile;

else :



endif;

?>


</div>
</div>
</section> -->


<div class="BodyModel">
    <!-- Trigger the modal with a button -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button> -->
    <!-- Modal -->
    <div class="modal BodyPoUp">
        <div class="modal-dialog" role="document">
            <div class="modal-content PopDis">
                <div class="modal-cross">
                    <!--  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="popup-logo">
                        <!-- <img class="popup-logo-img" src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/Minggu_Villas_Logo.png"> -->
                        <img class="popup-logo-img" src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/logo-island.png">
                    </div>

                    <h1 class="pop-header">Make a direct Booking Through Our website and choose 1 benefit:</h1>
                    <div class="PpulModel">
                        <ul class="editable-items">
                            <li class="offer-benefit">Private charter to any destination with our exclusive car with driver</li>
                            <li class="offer-benefit">Traditional balinese massages with our therapists directly at your villa</li>

                        </ul>
                    </div>

                    <div id="popupfoot"> <a href="<?php echo home_url();?>/villas/" class="pop-up-cta">BOOK NOW</a>

                        <div class="ps-notes">
                            <span class="footer-note">***every villa has a minimum of nights required to qualify (3 to 10)</span>
                            <span class="footer-note">***to find out about your benefit please contact our reservation office</span>
                            <span class="footer-note">***cannot be combined with any other offer or last minute rate</span>

                        </div>
                    </div>
                </div>
<!--   <div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary">Save changes</button>
</div> -->
</div>
</div>
</div>

</div>

<?php
get_footer();
?>

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
        var map = new google.maps.Map(document.getElementById("map1"), myOptions);
        var myLatLng1 = {lat: -8.689860, lng: 115.168840};
        var url = img_url+'red-dot.png';
        var marker = new google.maps.Marker({
            position: myLatLng1,
            map: map,
            icon:url
        });

        google.maps.event.addListener( marker, 'click', function(e){
            map.setZoom(13);
            map.panTo(this.position);
        }.bind( marker ) );

        var myOptions = {
            zoom: 8,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map1 = new google.maps.Map(document.getElementById("map2"), myOptions);
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


/*******************************
ACCORDION WITH TOGGLE ICONS
*******************************/

function callback () { document.querySelector('video').play(); } 
window.addEventListener("load", callback, false);
$(document).on('click','.collapseMain',function(){
    $('.panel-collapse').removeClass('show');
});

var h41 = 0;
var h42 = 0;
var h43 = 0;
var h44 = 0;
$(document).ready(function() {
    $(document).on('click',".panel-title",function () {
        $(".panel-title").removeClass("active");
        var currentId = $(this).data('id');
        if(currentId == 'h41'){
            ++h41;
            if(h41%2 == 0){
                $(this).removeClass('active');
                h41 = 0;
            }else{
                $(this).addClass("active");
                h42 = 0;
                h43 = 0;
                h44 = 0;
            }
        }

        if(currentId == 'h42'){
            ++h42;
            if(h42%2 == 0){
                $(this).removeClass('active');
                h42 = 0;
            }else{
                $(this).addClass("active");
                h41 = 0;
                h43 = 0;
                h44 = 0;
            }
        }

        if(currentId == 'h43'){
            ++h43;
            if(h43%2 == 0){
                $(this).removeClass('active');
                h43 = 0;
            }else{
                $(this).addClass("active");
                h41 = 0;
                h42 = 0;
                h44 = 0;
            }
        }

        if(currentId == 'h44'){
            ++h44;
            if(h44%2 == 0){
                $(this).removeClass('active');
                h44 = 0;
            }else{
                $(this).addClass("active");
                h41 = 0;
                h42 = 0;
                h43 = 0;
            }
        }
    });
});
</script>

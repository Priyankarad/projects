<?php

/**

* The header for our theme

*

* This is the template that displays all of the <head> section and everything up until <div id="content">

*

* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials

*

* @package WordPress

* @subpackage Twenty_Seventeen

* @since 1.0

* @version 1.0

*/



?>

<!DOCTYPE html>

<?php

$timeStamp = strtotime("now");

?>

<html <?php language_attributes(); ?> class="no-js no-svg">

<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/bootstrap.min.css' type='text/css' media='all'/>

    <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/owl.carousel.min.css' type='text/css' media='all'/>

    <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/font-awesome.min.css' type='text/css' media='all'/>

    <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/aos.css' type='text/css' media='all'/>

    <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/style.css?ver=<?php echo $timeStamp;?>' type='text/css' media='all'/>

    <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/responsive.css' type='text/css' media='all'/>

    <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/global.css' type='text/css' media='all'/>

    <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/jquery-ui.css' type='text/css' media='all'/>

    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">

    <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/jquery.fancybox.min.css' type='text/css' media='all'/>

<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/selectize.css">



    <?php wp_head(); ?>

    <style>

    h1.bannercontent {

        color: #fff;

    }

    .page-id-135 section.BannerSection, .page-id-129 section.BannerSection {

        padding: 0;

    }

    .page-id-5 #menu-item-345 a{

        display: none;

    }

</style>

</head>



<body <?php body_class(); ?>>

    <header class="main-header header-three">

        <div class="our_menus">

            <div class="container-fluid">

                <nav class="navbar navbar-expand-lg navbar-light">
                    <!-- <a class="navbar-brand logot" href="<?php echo esc_url( home_url( '/' ) ); ?>"> <img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/logo-island.png" alt="images"></a> -->

                    <a class="navbar-brand logot" href="<?php echo esc_url( home_url( '/' ) ); ?>"> <img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/logo-island.png" alt="images"></a>

                    <ul class="mobiserch">

                        <li><a href="tel:+62 878 6191 6870 "><span class="lnr lnr-phone-handset"></span></a></li>

                        <li class="mobi_serch"><span class="lnr lnr-magnifier"></span></li>

                    </ul>

                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >

                        <span class="navbar-toggler-icon"></span>

                    </button>



                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <ul class="navbar-nav main_menu ml-auto">

                            <?php $defaults = array(

                                'theme_location'  => '',

                                'menu'            => 'Main Menu',

                                'menu_class'      => '',

                                'echo'            => true,

                                'fallback_cb'     => 'wp_page_menu',

                                'items_wrap'      => '<ul id="%1$s" class="navbar-nav main_menu ml-auto">%3$s</ul>',

                                'depth'           => 0,

                                'walker'          => '',

                            );

                            wp_nav_menu( $defaults ); ?>



                        </ul>

                   <div class="footer">

  <div class="footer_section">

<div class="container">



<div class="row">

<div class="col">

<div class="currency_selector text-center">

  <form id="currencyForm" action="#" method="post">

  <select class="selector ftNselct currency_select select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true">

    

  <option value="dummy" selected="" data-select2-id="3">Currency </option>

           <option value="ARS">ARS Argentina Peso</option> 

             <option value="AED">AED United Arab Emirates Dirham</option> 

             <option value="AUD">AUD Australia Dollar</option> 

             <option value="BSD">BSD Bahamas Dollar</option> 

             <option value="BGN">BGN Bulgaria Lev</option> 

             <option value="BRL">BRL Brazil Real</option> 

             <option value="CAD">CAD Canada Dollar</option> 

             <option value="CLP">CLP Chile Peso</option> 

             <option value="CNY">CNY China Yuan Renminbi</option> 

             <option value="COP">COP Colombia Peso</option> 

             <option value="HRK">HRK Croatia Kuna</option> 

             <option value="CZK">CZK Czech Republic Koruna</option> 

             <option value="DKK">DKK Denmark Krone</option> 

             <option value="DOP">DOP Dominican Republic Peso</option> 

             <option value="EGP">EGP Egypt Pound</option> 

             <option value="EUR">EUR Euro Member Countries</option> 

             <option value="FJD">FJD Fiji Dollar</option> 

             <option value="GTQ">GTQ Guatemala Quetzal</option> 

             <option value="HKD">HKD Hong Kong Dollar</option> 

             <option value="HUF">HUF Hungary Forint</option> 

             <option value="ISK">ISK Iceland Krona</option> 

             <option value="INR">INR India Rupee</option> 

             <option value="IDR">IDR Indonesia Rupiah</option> 

             <option value="ILS">ILS Israel Shekel</option> 

             <option value="JPY">JPY Japan Yen</option> 

             <option value="KZT">KZT Kazakhstan Tenge</option> 

             <option value="KRW">KRW Korea (South) Won</option> 

             <option value="MYR">MYR Malaysia Ringgit</option> 

             <option value="MXN">MXN Mexico Peso</option> 

             <option value="NZD">NZD New Zealand Dollar</option> 

             <option value="NOK">NOK Norway Krone</option> 

             <option value="PKR">PKR Pakistan Rupee</option> 

             <option value="PAB">PAB Panama Balboa</option> 

             <option value="PYG">PYG Paraguay Guarani</option> 

             <option value="PEN">PEN Peru Nuevo Sol</option> 

             <option value="PHP">PHP Philippines Peso</option> 

             <option value="PLN">PLN Poland Zloty</option> 

             <option value="RON">RON Romania New Leu</option> 

             <option value="RUB">RUB Russia Ruble</option> 

             <option value="SAR">SAR Saudi Arabia Riyal</option> 

             <option value="SGD">SGD Singapore Dollar</option> 

             <option value="ZAR">ZAR South Africa Rand</option> 

             <option value="SEK">SEK Sweden Krona</option> 

             <option value="CHF">CHF Switzerland Franc</option> 

             <option value="TWD">TWD Taiwan New Dollar</option> 

             <option value="THB">THB Thailand Baht</option> 

             <option value="TRY">TRY Turkey Lira</option> 

             <option value="UAH">UAH Ukraine Hryvna</option> 

             <option value="GBP">GBP United Kingdom Pound</option> 

             <option value="USD">USD United States Dollar</option> 

             <option value="UYU">UYU Uruguay Peso</option> 

             <option value="VND">VND Viet Nam Dong</option> 

           </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="2" style="width: 113px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-p1e3-container"><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>

  </form>





</div>



 <div class="PayFooter text-center">

            <ul class="nav-pay">

                 <li>

                  <a href="javascript:void(0)"> <img src="<?php  bloginfo('template_url');?>/assets/images/pay1.png" alt="Image"></a>

                </li>



                   <li>

                  <a href="javascript:void(0)"> <img src="<?php  bloginfo('template_url');?>/assets/images/pay2.png" alt="Image"></a>

                </li>

                   <li>

                  <a href="javascript:void(0)"> <img src="<?php  bloginfo('template_url');?>/assets/images/jcb.png" alt="Image"></a>

                </li>

                          </ul>

                      </div>

   <div class="bankttranS_logo">

          <img src="<?php  bloginfo('template_url');?>/assets/images/bank_transfr.png" alt="Image">

 <img src="<?php  bloginfo('template_url');?>/assets/images/pay-pal-logo.png" alt="Image">

</div>

</div>

  

    





<div class="col">

   

                      <div class="hedtochp text-center"> <p class="TouchP"> Touch here to Chat with us</p></div>

                      

          

</div>

<div class="col">

    <div class="social_link text-center">

            <ul class="nav-social">

                 <li>
                                <a class="facebook" href="https://www.facebook.com/mingguvillas" title="" rel="external" target="_blank"><img src="<?php  bloginfo('template_url');?>/assets/images/fb.png" alt="Image"></a>
                            </li>

                            <li>
                                <a class="instagram" href="https://www.instagram.com/mingguvillasbali/" title="" rel="external" target="_blank"><img src="<?php  bloginfo('template_url');?>/assets/images/instagram.png" alt="Image"></a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?phone=6287861916870&amp;text=Hello Minggu Villas,"><img src="<?php  bloginfo('template_url');?>/assets/images/whtsap.png" alt="Image"></a>

                            </li>
                            <li>
                                <a class="instagram" href="weixin://dl/chat?mingguvillas"  title="" rel="external"><img src="<?php  bloginfo('template_url');?>/assets/images/wecht.png" alt="Image"></a>
                            </li>
                            <li>
                                <a class="instagram" href="http://telegram.me/mingguvillas?text=Hello Minggu Villas," title="" rel="external"><img src="<?php  bloginfo('template_url');?>/assets/images/telegrm.png" alt="Image"></a>
                            </li>
                            <li>
                                <a class="instagram" href="line://oaMessage/@mingguvillas/?Hello Minggu Villas," title="" rel="external"><img src="<?php  bloginfo('template_url');?>/assets/images/linee.png" alt="Image"></a>
                            </li>

                   </ul>

            </div>

          

</div>





<div class="col">

  <div class="contact text-center">

        <a class="clickable-phone phone" href="tel:+62 878 6191 6870 " itemprop="telephone">

           <i class="fa fa-phone" aria-hidden="true"></i>

              <span>+62 878 6191 6870 </span>

            </a>



  </div>

</div>

    <p class="Vila2019">©2019 Minggu Villas Seminyak - Bali. All rights reserved <!-- Powered by <a href="http://www.lodgify.com">Lodgify.com</a> --></p>

</div>

  </div>



  </div>



</div>

<!--                       <div class="mobi_bottom">

   <div class="social_link text-center mobi_social">

      <div class="contact mobi_contact">

         <a class="clickable-phone phone" href="tel:+62 878 6191 6870 " itemprop="telephone">

         <i class="fa fa-phone" aria-hidden="true"></i>

         <span>+62 878 6191 6870 </span>

         </a>

      </div>

      <ul class="nav-social mobi_fb">

         <li>

            <a class="facebook" href="https://www.facebook.com/mingguvillas" title="" rel="external" target="_blank"> <i class="fa fa-facebook" aria-hidden="true"></i></a>

         </li>

         <li>

            <a class="instagram" href="https://www.instagram.com/mingguvillasbali/" title="" rel="external" target="_blank"> <i class="fa fa-instagram" aria-hidden="true"></i>

            </a>

         </li>

      </ul>

   </div>

</div> -->

               

                </nav>

            </div>

       







        </div>

    </header>

    <section class="BannerSection">

        <div class="container-fluid">

            <div class="row">

                <div class="owl-carousel owl-theme banner-slide">







                    <?php



// check if the repeater field has rows of data

                    if( have_rows('home_banner_repeater') ):



// loop through the rows of data

                        while ( have_rows('home_banner_repeater') ) : the_row();



// display a sub field value

                            ?>



                            <div class="item banner_bg" style="background: url(<?php the_sub_field('home_banner_image'); ?>)">

                                <!--  <h1 class="bannercontent"><?php //the_sub_field('home_banner_title',135); ?></h1> -->



                            </div>

                            <?php

                        endwhile;



                    else :



// no rows found



                    endif;



                    ?>











                </div>



                <div class="FixedFrom">







                    <div class="container">

                        <div class="row justify-content-center">

                            <div class="col-md-12 col-sm-12 col-12"> 

                                <div class="bannercontent"> 



                                    <h1>

                                        <?php the_field('home_banner_main_title',5); ?>                

                                    </h1> 



                                    <div class="BannerFrom slideSel">
                                            <span class="check_available1" style="display: none;">Check Availability</span>
                                        <form method="post" action="<?php echo site_url('villas');?>">

                                            <div class="row">

                                                <div class="col-md-2 col-sm-2 col-12">

                                                    <div class="form-group BannrGrup">

                                                        <!--  <label>Selecte Date:</label> -->

                                                        <select name="city" class="form-control" id="city">

                                                            <!-- <option>Destination</option> -->

                                                            <option selected="selected" value="all">All Destinations</option>

                                                            <option value="seminyak" <?php echo (!empty($_SESSION['city']) && $_SESSION['city']=='Seminyak')?'selected':''; ?>>Seminyak</option>
                                                            <option value="kerobokan" <?php echo (!empty($_SESSION['city']) && $_SESSION['city']=='Kerobokan')?'selected':''; ?>>Kerobokan</option>




                                                        </select>

                                                        <label for="label1"><span class="lnr lnr-map-marker"></span></label> 

                                                    </div>

                                                </div>

                                                <div class="col-md-2 col-sm-2 col-12">

                                                    <div class="form-group BannrGrup calInput">

                                                        <!--  <label>Selecte Date:</label> -->

                                                        <!-- <input type="text" id="start_date1" name="start_date" placeholder="Check-IN" class="form-control BannerInput" readonly="" value="<?php echo date('d/m/Y');?>"> -->

                                                        <input type="text" id="start_date" name="start_date" placeholder="Check-IN" class="form-control BannerInput" readonly="">

                                                        <label for="date_ex5"><span class="lnr lnr-calendar-full"></span></label>

                                                    </div>

                                                </div>

                                                <div class="col-md-2 col-sm-2 col-12">

                                                    <div class="form-group BannrGrup calInput">

                                                        <!--  <label>Selecte Date:</label> -->

                                                        <!-- <input type="text" id="end_date1" name="end_date" placeholder="Check-OUT" class="form-control BannerInput" readonly="" value="<?php echo date('d/m/Y', strtotime("+1 day"));?>"> -->

                                                        <input type="text" id="end_date" name="end_date" placeholder="Check-OUT" class="form-control BannerInput" readonly="">

                                                        <label for="date_ex6"> <span class="lnr lnr-calendar-full"></span></label></div>

                                                    </div>





                                                    <div class="col-md-2 col-sm-2 col-12">

                                                        <div class="form-group BannrGrup">

                                                            <!--  <label>Selecte Date:</label> -->

                                                            <select name="room" id="room" class="form-control">

                                                                <option selected="selected" value="0">All Rooms</option>

                                                                <?php 

                                                                for($i=1;$i<=8;$i++){ ?>

                                                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>

                                                                <?php }

                                                                ?>

                                                            </select>

                                                            <label for="label2"><span><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/Bed_1.png" class="img-fluid bediconImg" alt="Icon"></span></label>

                                                        </div>

                                                    </div>



                                                    <div class="col-md-2 col-sm-2 col-12">

                                                        <div class="form-group BannrGrup">

                                                            <!--  <label>Selecte Date:</label> -->

                                                            <select name="guest" id="guest" class="form-control">

                                                                <option selected="selected">All Guests</option>

                                                                <?php 

                                                                for($i=1;$i<=16;$i++){ ?>

                                                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>

                                                                <?php }

                                                                ?>

                                                            </select>

                                                            <label for="label3"><span class="lnr lnr-users"></span></label>

                                                        </div>

                                                    </div>



                                                    <div class="col-md-2 col-sm-2 col-12">

                                                        <div class="form-group BannrGrup">

                                                            <button type="submit" class="btn SubBtn sbpad"> <span class="lnr lnr-magnifier"></span>

                                                            </button>

                                                        </div>

                                                    </div>

                                                </div>

                                            </form>

                                        </div>

                                    </div>              

                                </div>

                            </div>

                        </div>



                    </div>

                </div>

            </div>

        </section>


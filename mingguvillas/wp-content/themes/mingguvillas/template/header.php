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
    <header class="main-header">
        <div class="our_menus">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg navbar-light">

                    <a class="navbar-brand logot" href="<?php echo esc_url( home_url( '/' ) ); ?>"> <img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/logo.png" alt="images"></a>
                    <ul class="mobiserch">
                        <li><a href="tel:+62 878 6191 6870 "><span class="lnr lnr-phone-handset"></span></a></li>
                        <li class="mobi_serch"><span class="lnr lnr-magnifier"></span></li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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


                    </div>
               
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
                                        <form method="post" action="<?php echo site_url('villas');?>">
                                            <div class="row">
                                                <div class="col-md-2 col-sm-2 col-12">
                                                    <div class="form-group BannrGrup">
                                                        <!--  <label>Selecte Date:</label> -->
                                                        <select name="city" class="form-control" id="city">
                                                            <!-- <option>Destination</option> -->
                                                            <option selected="selected">All Destinations</option>
                                                            <option value="kerobokan">Kerobokan</option>
                                                            <option value="seminyak">Seminyak</option>

                                                        </select>
                                                        <label for="label1"><span class="lnr lnr-map-marker"></span></label> 
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-12">
                                                    <div class="form-group BannrGrup calInput">
                                                        <!--  <label>Selecte Date:</label> -->
                                                        <!-- <input type="text" id="start_date1" name="start_date" placeholder="Check-IN" class="form-control BannerInput" readonly="" value="<?php echo date('d/m/Y');?>"> -->
                                                        <input type="text" id="start_date1" name="start_date" placeholder="Check-IN" class="form-control BannerInput" readonly="">
                                                        <label for="date_ex5"><span class="lnr lnr-calendar-full"></span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-12">
                                                    <div class="form-group BannrGrup calInput">
                                                        <!--  <label>Selecte Date:</label> -->
                                                        <!-- <input type="text" id="end_date1" name="end_date" placeholder="Check-OUT" class="form-control BannerInput" readonly="" value="<?php echo date('d/m/Y', strtotime("+1 day"));?>"> -->
                                                        <input type="text" id="end_date1" name="end_date" placeholder="Check-OUT" class="form-control BannerInput" readonly="">
                                                        <label for="date_ex6"> <span class="lnr lnr-calendar-full"></span></label></div>
                                                    </div>


                                                    <div class="col-md-2 col-sm-2 col-12">
                                                        <div class="form-group BannrGrup">
                                                            <!--  <label>Selecte Date:</label> -->
                                                            <select name="room" id="room" class="form-control">
                                                                <option selected="selected">All Rooms</option>
                                                                <?php 
                                                                for($i=1;$i<=8;$i++){ ?>
                                                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                <?php }
                                                                ?>
                                                            </select>
                                                            <label for="label2"><span><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/sleeping.png" class="img-fluid bediconImg" alt="Icon"></span></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 col-sm-2 col-12">
                                                        <div class="form-group BannrGrup">
                                                            <!--  <label>Selecte Date:</label> -->
                                                            <select name="guest" id="guest" class="form-control">
                                                                <option selected="selected">All Guests</option>
                                                                <?php 
                                                                for($i=1;$i<=12;$i++){ ?>
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

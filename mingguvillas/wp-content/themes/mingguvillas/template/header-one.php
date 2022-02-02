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

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/bootstrap.min.css' type='text/css' media='all'/>
  <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/owl.carousel.min.css' type='text/css' media='all'/>
  <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/font-awesome.min.css' type='text/css' media='all'/>
  <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/aos.css' type='text/css' media='all'/>
  <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/style.css' type='text/css' media='all'/>
  <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/responsive.css' type='text/css' media='all'/>
   <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/global.css' type='text/css' media='all'/>
   <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/jquery-ui.css' type='text/css' media='all'/>
   <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
   <link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/jquery.fancybox.min.css' type='text/css' media='all'/>
<link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/flatpickr.min.css' type='text/css' media='all'/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel='stylesheet' href='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/css/ply.css' type='text/css' media='all'/>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<header class="main-header">
  <div class="our_menus">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-light">
        
       <a class="navbar-brand logot" href="<?php echo esc_url( home_url( '/' ) ); ?>"> <img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/logo.png" alt="images"><span>
        <?php 
         
         echo 'h------'.$_SESSION['city'];
         $pageID =  get_the_ID();
         $cityName = get_field('city',$pageID);
         if($cityName!=''){
          the_field('city',$pageID);
         }else if(!empty($_SESSION['city'])){
          echo $_SESSION['city'];
         }
         ?>
       </span></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
                               
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav main_menu ml-auto">
          <?php
			 
			  $defaults = array(
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
      <!--<li class="nav-item">
        <a class="nav-link active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Home</a>
         <ul class="sub-menu">
           <li class="nav-item">
              <a class="nav-link" href="bedroom-villa.html">Hangology Dorms</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Hangology kids</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Hangology adults</a>
            </li>
         </ul>

      </li>
            <li class="nav-item">
              <a class="nav-link" href="search-listing.html">Villas</a>
            </li>

           

            <li class="nav-item">
        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Destination</a>
         <ul class="sub-menu">
           <li class="nav-item">
              <a class="nav-link" href="kerobokan.html">Kerobokan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="seminyak.html">Seminyak</a>
            </li>
       
         </ul>

      </li>

          
               <li class="nav-item">
        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Gallery</a>
         <ul class="sub-menu">
           <li class="nav-item">
              <a class="nav-link" href="gallery.html">Photo Gallery</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="foodgallery.html">Food Gallery</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="galleryvideo.html">Video Gallery</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="floreplans.html">Floor Plans</a>
            </li>
       
         </ul>

      </li>

            <li class="nav-item">
              <a class="nav-link" href="about-us.html">Review</a> 
              
            </li>

            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact</a> 
            </li>-->

          </ul>

         
        </div>
       </nav>
    </div>
  </div>
</header>

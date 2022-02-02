<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */
require_once( get_parent_theme_file_path( 'countrylist.php' ) );
?>

<section class="footer">
  <div class="footer_section">
<div class="container">

<div class="row">
<div class="col-md-3 col-sm-3 col-12">
<div class="currency_selector text-center">
  <form>
  <select class="selector ftNselct">
  <option value="dummy">Currency </option>
  <?php foreach( $age as $x => $x_value ) { ?>
         <option value="<?php echo $x." ".$x_value; ; ?>"><?php echo $x." ".$x_value; ; ?></option> 
    <?php } ?>
       </select>
  </form>


</div>
</div>

<div class="col-md-3 col-sm-3 col-12">
    <div class="PayFooter text-center">
            <ul class="nav-pay">
                 <li>
                  <a href="#" target="_blank"> <img src="<?php  bloginfo('template_url');?>/assets/images/pay1.png" alt="Image"></a>
                </li>

                   <li>
                  <a href="#" target="_blank"> <img src="<?php  bloginfo('template_url');?>/assets/images/pay2.png" alt="Image"></a>
                </li>
                   <li>
                  <a href="#" target="_blank"> <img src="<?php  bloginfo('template_url');?>/assets/images/jcb.png" alt="Image"></a>
                </li>
                          </ul>
                      </div>
          
</div>
<div class="col-md-3 col-sm-3 col-12">
    <div class="social_link text-center">
            <ul class="nav-social">
                 <li>
                  <a class="facebook" href="https://www.facebook.com/mingguvillas" title="" rel="external" target="_blank"> <i class="fa fa-facebook" aria-hidden="true"></i></a>
                </li>

                 <li>
                  <a class="instagram" href="https://www.instagram.com/mingguvillasbali/" title="" rel="external" target="_blank"> <i class="fa fa-instagram" aria-hidden="true"></i>
                   </a>
                </li>
                          </ul>
                      </div>
          
</div>


<div class="col-md-3 col-sm-3 col-12">
  <div class="contact text-center">
        <a class="clickable-phone phone" href="tel:+62 878 6191 6870 " itemprop="telephone">
           <i class="fa fa-phone" aria-hidden="true"></i>
              <span>+62 878 6191 6870 </span>
            </a>

  </div>
</div>

</div>
  </div>

  </div>

</section>

<section class="footer_rights">
  <div class="container-fluid">
    <div class="row">
  <div class="col-md-12">
  <div class="all_rights">
    <p>©2019 Minggu Villas Seminyak - Bali. All rights reserved <!-- Powered by <a href="http://www.lodgify.com">Lodgify.com</a> --></p>
  </div>
</div>
</div>
  </div>
  


</section>


<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/jquery-3.2.1.slim.min.js"></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/popper.min.js"></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/jquery.fancybox.min.js"></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/aos.js"></script>
<script type='text/javascript' src='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/smoothscroll.js'></script>
<script type='text/javascript' src='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/owl.carousel.min.js'></script>
<script type='text/javascript' src='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/jquery-ui.js'></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/custom.js"></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/flatpickr.js"></script>
<script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>

<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/ply.js"></script>
  <script type="text/javascript">
  /*============aos==========*/

AOS.init({
    easing: 'ease-in-out-sine'
});

</script>
<script type="text/javascript">
  $(window).scroll(function() {    
    var scroll = $(window).scrollTop();

     //>=, not <=
    if (scroll >= 50) {
        
        $(".main-header").addClass("headerbg");
    }
 else {
   $(".main-header").removeClass("headerbg");
}
});
</script>
<script>
  $(function() {
    $( "#date_ex5" ).datepicker();
  });
  </script>

<script>
  $(function() {
    $( "#date_ex" ).datepicker();
  });
  </script>

<script>
  $(function() {
    $( "#date_ex6" ).datepicker();
  });
  </script>

  <script>
  $(function() {
    $( "#date_ex2" ).datepicker();
  });
  </script>

  <script>
  $(function() {
    $( "#date_ex3" ).datepicker();
  });
  </script>

  <script>
  $(function() {
    $( "#date_ex4" ).datepicker();
  });
  </script>

<script>
  $(function() {
    $( "#date_exnew" ).datepicker();
  });
  </script>
      <script>
        $(window).load(function(){
          alert(665);
          $('.BodyModel').modal('show');
        });
         $(document).ready(function(){
           $(".TabViewShow").click(function(){
             $(this).parent().siblings(".OverContent").addClass('OverContentUp');
             $(this).siblings('.TabViewHide').show();
             $(this).hide();
           });
         
           $(".TabViewHide").click(function(){
             $(this).parent().siblings(".OverContent").removeClass('OverContentUp');
            $(this).siblings('.TabViewShow').show();
             $(this).hide();
           });
         });

$(document).ready(function(){
   if ($(window).width() <767) {
      $('#pills-tabContent > div').removeClass('show active');
      $('.mobiitem').click(function(){
         $(this).next('.tab-pane').toggleClass('show active');
      })
   }
})


</script>
 
<?php wp_footer(); ?>

</body>
</html>

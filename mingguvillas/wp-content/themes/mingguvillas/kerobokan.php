<?php
/*
  Template name:kerobokan
*/
session_destroy();
session_start();
get_header('new');

?>


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
              <?php the_field('kerobokan_first_section_description',129); ?>
            </div>
          </div>
           <div class="col-md-6 col-sm-6 col-12">
            <div class="Lpara">
             <?php the_field('kerobokan_first_section_video',129); ?>
            </div>
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
          </div>
        </div>
    
  </div>
</section>


<section class="SemiyakSec">
  <div class="container">
    <hr class="SemiHr">
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
  </div>
</section>

<section class="vila_section">
  <div class="container">
<hr class="SemiHr">
  <div class="row">
    <div class="col-md-12">
      <div class="Symkheading">
    <h1><?php the_field('kerobokan_second_section_title'); ?></h1>
  </div>
    </div>
  </div>

 <div class="row justify-content-center">
   
   <?php
              $args = array( 
                'post_type' => 'kerobokan', 
                'posts_per_page' => 8, 
                'order' => 'ASC'
                 );
              
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
            ?>
  <div class="col-md-5">
  <div class="Main_vd">
      <div class="video_section">
         <p><?php the_field('karebokan_post_video'); ?></p>
         <img src="" class="img-fluid">
      </div>
      <div class="Vtext_section">
          <div class="Vinner_text">
         <h4><span><a href="<?php the_field('karebokan_post_book_button'); ?>"><?php the_title(); ?></a></span></h4>
         <a href="<?php the_field('karebokan_post_book_button'); ?>" class="btn btn-cta">Book Now</a>
       </div>
         <h6><?php the_field('karebokan_post_title'); ?></h6>
         <p><?php the_field('karebokan_post_description'); ?></p>
      </div>
   </div>
 </div>
<?php 
endwhile;
?>  



 

</div>
<div class="row justify-content-center mt_20 mb_20">
  <div class="col-md-5">
    <div class="Main_vd">
      <div class="video_section">
         <img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/Archdalel.png" alt="image" class="img-fluid">
      </div>
     </div>
   </div>
 </div>
</div>
</section>

<?php 
get_footer();
$_SESSION['city'] = 'Kerobokan';?>


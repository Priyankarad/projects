<?php
/*
  Template name:review
*/

get_header('one');
?>
<section class="ContactSection">
  <div class="BdBack ReviwPage">
  <div class="container">
    <div class="Symkheading">
    <h1>Reviews</h1>    
  </div>

  <div class="ReviewUl">
    <ul>
      <?php

// check if the repeater field has rows of data
if( have_rows('review_page_first_section') ):

 	// loop through the rows of data
    while ( have_rows('review_page_first_section') ) : the_row();

        // display a sub field value
?>
       
       <li><img src="<?php the_sub_field('review_image'); ?>" alt="Image" class="img-fluid"></li>
<?php
    endwhile;

else :

    // no rows found

endif;

?>
      
    </ul>
    <p class="review_para"><?php the_field('review_page_title_one'); ?></p>
    <p><?php the_field('review_page_title_two'); ?></p>
   <!-- <a href="<?php the_field('review_button'); ?>" class="btn btn-cta">Write a Review</a>-->
    <a href="<?php echo home_url();?>/write-a-review-page/" class="btn btn-cta">Write a Review</a>
  </div>


<!-- <div class="row justify-content-center">
<?php
     if( have_rows('review_page_third_section') ): 	
    while ( have_rows('review_page_third_section') ) : the_row(); ?> 
 
       <div class="col-md- 7 col-sm-7 col-12">
       <div class="ReviewCon">
       <p>319</p>
       <img src="<?php the_sub_field('review_page_third_section_image'); ?>" alt="Image" class="img-fluid">
       </div>
       </div>
<?php
    endwhile; else : endif; ?>
</div> -->

<div class="row justify-content-center">
        <?php  
$count = 1;
$count_posts = wp_count_posts( 'review' )->publish;            
                 $custom_args = array(
                'post_type' => 'review',
                'posts_per_page' =>-1,                
                'order'         => 'DESC',

              );             
        $custom_query = new WP_Query( $custom_args );?>
        <?php if ( $custom_query->have_posts() ) : ?>
<?php if($count<$count_posts) : ?>
        <?php while($custom_query->have_posts()): $custom_query->the_post();?>           
       
       <div class="col-md- 7 col-sm-7 col-12">
       <div class="ReviewCon">
        <p><?php echo $count_posts; ?></p>
       <!-- <p><?php the_field('review_number');?></p> -->
       <img src="<?php the_field('review_image');?>"  class="img-fluid">
       </div>
       </div>
<?php
$count_posts--;
    endwhile;  endif; endif; ?>
 
</div> 
 
  </div>
</section>
<?php 
get_footer();
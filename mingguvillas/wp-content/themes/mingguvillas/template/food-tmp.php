<?php 
/*
  Template name:food
*/

get_header('one');
?>
<section class="GalleryPageSection bodybkf6 pd90">
         <div class="container">
            <div class="GalleryDetail">
               <div class="Symkheading">
                  <h1>Food Gallery</h1>

                  <p>Minggu Villas make it a mission to treat their guests to exclusivity and comfort also organizing
private lunches and dinners prepared and served by personal chefs and waiters <a href="#" class="seemenu">(see the menu)</a></p>
               </div>
               <div class="row">
                <?php                  
                     $custom_args = array(
                          'post_type' => 'foodgallery',
                          'status'    => 'publish',
                          'posts_per_page' =>-1,
                          'order'         => 'ASC',                          
                        );

            $custom_query = new WP_Query( $custom_args ); ?>
            <?php if ( $custom_query->have_posts() ) : ?>
              <?php while($custom_query->have_posts()): $custom_query->the_post();?>
                      
                      <div class="col-md-4 col-sm-4 col-12 custom-cls-gallery" id="mylif" style="display:block">
                       
                       <div class="galleryDBox">
                        <a href="<?php the_permalink();?>">
                          <?php the_post_thumbnail('full');?>
                        </a>
                      </div>
                        <div class="galActCont">
                        <h1><?php the_title();?></h1>
                        </div> 
                        </div>
                   <?php endwhile;
          endif;?> 
          </div>
      </div>
        <p class="bootem-disscbsn">Choose between our different food set-ups to fully enjoy great life in a private villa</p>                          
</section>
<?php 
get_footer();
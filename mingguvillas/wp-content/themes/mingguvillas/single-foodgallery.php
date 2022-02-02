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
        <div class="row justify-content-center PicRowBk"> 
        <?php                  
                     $custom_args = array(
                          'post_type' => 'foodgallery',
                          'posts_per_page' =>-1,
                          'order'         => 'ASC',
                          
                        );

            $custom_query = new WP_Query( $custom_args ); ?>
            <?php if ( $custom_query->have_posts() ) : ?>        
          <?php 
          $images = get_field('food_gallery_img');
          $size = 'large'; 
          if( $images ){ ?>
            <?php foreach( $images as $image_id ): 
              ?>
              <div class="col-md-4 col-sm-4 col-12 custom-cls-gallery single_glry_img" id="mylif" style="display:block" data-caption="<?php the_title();?>">
                <div class="galleryDBox">
                  <a data-fancybox="gallery" href="<?php echo $image_id['url']; ?>" title="Twilight Memories (doraartem)" data-caption="<?php the_title();?>">
                    <img src="<?php echo $image_id['url']; ?>">
                  </a> 
                </div>                                                           
              </div>
            <?php endforeach; ?>
          <?php } ?>  
          <?php  endif;?>
        </div>
      </div>
      <p class="bootem-disscbsn">Choose between our different food set-ups to fully enjoy great life in a private villa</p>                          
    </section>
<?php 
get_footer();
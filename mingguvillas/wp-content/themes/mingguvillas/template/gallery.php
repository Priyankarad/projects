<?php
/*
Template name:gallery
*/

get_header('one');
?>
<style type="text/css">
    a.left_arow_glry_img i {
    position: absolute;
    margin-top: 100px;
    color: #fff;
}
a.right_arow_glry_img i {
    position: absolute;
    margin-top: 100px;
    color: #fff;
    margin-left: -15px;
}
</style>
<section class="GalleryPageSection pd90">
    <div class="container">
        <div class="GalleryDetail">
            <div class="Symkheading">
                <h1>Photo Gallery</h1>
                <p>Minggu Villas takes care of its clients in every possible way organizing and providing many activities and facilties to make your vacation a Real Holiday</p>
            </div>
            <div class="row">
                <?php 
                $wpb_all_query = new WP_Query(array(
                    'post_type'=>'photogallery',
                    'post_status'=>'publish',
                    'order'         => 'DESC',
                    'posts_per_page'=>-1
                )); ?>

                <?php if ( $wpb_all_query->have_posts() ) : ?>
                    <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
                        <div class="col-md-4 col-sm-4 col-12 Newgallery" id="mylif<?php echo $i; ?>" style="display:block" >
                            <div class="galleryDBox">
                                <!-- <a href="<?php the_permalink(); ?>"  class="FadH4" data-caption="">  -->
                                    <a href="<?php the_permalink(); ?>" class="left_arow_glry_img"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                                    <?php the_post_thumbnail( 'large' ); ?> 
                                     <a href="<?php the_permalink(); ?>" class="right_arow_glry_img"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>                                           
                                <!-- </a> -->
                            </div>
                            <div class="galActCont">
                                <h1><?php the_title();?></h1>
                                <p></p>
                            </div>
                        </div>

                    <?php endwhile; ?> 
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>      

            </div>
            <p class="bootem-disscbsn">Don’t miss your chance</p>
        </div>
    </section>




<?php 
get_footer();
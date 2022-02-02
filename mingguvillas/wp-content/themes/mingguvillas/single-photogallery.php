<?php
get_header('one');
?>
<section class="GalleryPageSection pd90">
    <div class="container">
        <div class="GalleryDetail">
            <div class="Symkheading">
                <h1>Photo Gallery</h1>
                <p>Minggu Villas takes care of its clients in every possible way organizing and providing many activities and facilties to make your vacation a Real Holiday</p>
            </div>
            <div class="row justify-content-center PicRowBk">
                <?php 
                $images = get_field('gallery');
                $size = 'large'; 
                if( $images ){ ?>
                    <?php foreach( $images as $image_id ): 
                        ?>
                        <div class="col-md-4 col-sm-4 col-12 Newgallery single_glry_img" id="mylif" style="display:block" data-caption="">
                            <div class="galleryDBox">
                                <a data-fancybox="gallery" href="<?php echo $image_id['url']; ?>"  class="FadH4"  data-caption="<?php 
                                        $title = $image_id['title'];
                                        if (strpos($title, '_') !== false) {
                                            the_title();
                                        }else{
                                            echo $image_id['title'];
                                        }
                                        ?>">
                                    <img src="<?php echo $image_id['url']; ?>">
                                </a> 
                            </div>                                                           
                        </div>
                    <?php endforeach; ?>
                <?php } ?> 

            </div>
        </div>
        <p class="bootem-disscbsn">Don’t miss your chance</p>
    </div>
</section>


<?php get_footer();?>
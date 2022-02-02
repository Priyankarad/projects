<?php
/*
  Template name:galleryvideo
*/

get_header('one');
?>
<section class="GalleryPageSection bodybkf6 pd90">
         <div class="container">
            <div class="GalleryDetail">
               <div class="Symkheading">
                  <h1>Video Gallery</h1>
               </div>
               <div class="row">
<?php

// check if the repeater field has rows of data
if( have_rows('gallery_video') ):

 	// loop through the rows of data
    while ( have_rows('gallery_video') ) : the_row();

        // display a sub field value
        ?>
        
        <div class="col-md-4 col-sm-4 col-12 youtube-video-single">
                     <div class="galleryvideo">
                      <?php the_sub_field('gallery_videos_upload'); ?>
                      <p><?php the_sub_field('gallery_video_title'); ?></p>

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
             </div>
           </section>
<?php 
get_footer();
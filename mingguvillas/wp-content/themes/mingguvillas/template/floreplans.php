<?php
/*
  Template name:floreplans
*/

get_header('one');
?>
<section class="GalleryPageSection bodybkf6 pd90">
         <div class="container">
            <div class="GalleryDetail">
               <div class="Symkheading">
                  <h1>Floor Plans</h1>
               </div>
               <div class="row">

                  <?php

// check if the repeater field has rows of data
if( have_rows('floreplans_image',20) ):

 	// loop through the rows of data
    while ( have_rows('floreplans_image',20) ) : the_row();

        // display a sub field value
        ?>
        
        <div class="col-md-6 col-sm-6 col-12">
                     <div class="FlorImg">
                      <img src="<?php the_sub_field('floreplans_image_upload',20); ?>" alt="Image" class="img-fluid">

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
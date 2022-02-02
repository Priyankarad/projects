<!--log_inheder start-->
 <section id="fiend-ourfriend">
   <div class="container">
     <div class="row">
	  <?php if(!empty($category_data)){ foreach($category_data as $cats){

    if($cats['id']!=1 ){ ?>
     <div class="col-md-3 col-sm-3 col-12">
     <a href="<?php echo site_url('category/'.$cats['slug'].''); ?>">
       <div class="tz-friend">
         <div class="our-frienss">
         <img src="<?php echo base_url().$cats['category_image_thumb']; ?>" class="img-fluid" alt="find1">
         </div>
         <p><?php echo $cats['name']; ?></p>
       </div>
     </a>
     </div>
	 <?php } }
   } ?>
   </div>
  </div>
 </section>
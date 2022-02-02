<!--========header=============-->
<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">

    <div class="link_section">
        <h1>Articles</h1>
    </div>
</section>
<!-- ======INFORMATION SECTION========== -->
<section class="news-section pd_all">
   <div class="container">
      <div class="row">
	  			<?php if(!empty($articles)){ $i=$offset; foreach($articles as $row){ $i++;
                 $mid=encoding($row->id);
				?>
				<?php
						$string=$row->description;
						$string = strip_tags($string);
						if (strlen($string) > 500) {
						// truncate string
						$stringCut = substr($string, 0, 500);
						$endPoint = strrpos($stringCut, ' ');

						//if the string doesn't contain any space then it will cut without word basis.
						$string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
						$string .= '...';
						}
						
					?>
         <div class="col-md-6 col-sm-6 col-12 mar_bottom20">
            <div class="left-news-main">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-12">
                     <div class="inner-news2">
                        <div class="lft-in-img">
                           <a href="<?php echo site_url('articledetails/'.encoding($row->id)); ?>"><img src="<?php echo BASEURL.'uploads/article/'.$row->image;  ?>" class="img-fluid" alt="<?php echo $row->title; ?>"></a>
                        </div>
                     <!-- =====Image end===== -->
                    </div>                     
                  </div>
                  <!-- ======COLUMN SEVEN END===== -->
                  <div class="col-md-12 col-sm-12 col-12">
                     <div class="lft-in-content">          
                          <p><span class="Categories-artc">
                          <i class="fa fa-info" aria-hidden="true"></i><a href="#" class="Categories-artc-link"></a>
                           <a href="#" class="Categories-artc-link"><?php echo $row->title; ?></a></span></p>
                          <h2><a href="<?php echo site_url('articledetails/'.encoding($row->id)); ?>"><?php echo $string; ?></a></h2>

                          <div class="subheadline-date">
                           <span class="btArticleDate"><?php echo date('M-d-Y',strtotime($row->postdate)); ?> </span>
                           <a href="#"><i class="fa fa-comment" aria-hidden="true"></i>0</a>
                        </div>
                        <?php /*** ?>
                        <div class="blog-social-box">
                           <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                           <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                           <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                           <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i>  </a>
                           <div class="Continue-Reading">
                              <a class="btn_public cnred" href="#">Continue Reading</a>
                           </div>
                        </div>
                   <?php ****/  ?>
                        
                     </div>
                     <!-- =====Content end===== -->
                    </div> 
                     
               </div>
            </div>
             <!-- ======FRIST POST END===== -->
         </div>
		<?php } } ?> 
         <!-- ==========COLUMN 6 END======== -->
        
<!-- ===============COL SIX END======== -->
         
<!-- ===============COL SIX END======== -->

        
<!-- ===============COL SIX END======== -->

         
<!-- ===============COL SIX END======== -->
       
      </div>
	  <div class="row">
	  <div class="col-md-12 col-sm-12 col-12 text-right">
	    <?php echo $pagination; ?>
	  </div>
	  </div>
   </div>
</section>
<!-- ============MAIN NEWS START============ -->
<!-- ======INFORMATION SECTION========== -->
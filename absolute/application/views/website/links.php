<!--========header=============-->
<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">

    <div class="link_section">
        <h1>Links</h1>
    </div>
</section>
<!-- ======INFORMATION SECTION========== -->
<section class="news-section link_section pd_all">
   <div class="container">
      <div class="row">
         <div class="col-sm-4">
              
		</div>
		<div class="col-sm-8">
            <h3>Links:</h3>
    	    <ul class="links_view">
			<?php if(!empty($links)){ $i=$offset; foreach($links as $row){ $i++;
                 $mid=encoding($row->id);
				?>
                <li><a href="<?php echo $row->url;  ?>" target="_blank"><strong><?php echo $row->title;  ?></strong></a></li> 
			<?php } } ?>
    	    </ul> 
          <div class="box-footer clearfix">
              <?php echo $pagination; ?>
            </div>			
		</div>
		
      </div>
   </div>
</section>
<!-- ============MAIN NEWS START============ -->
<!-- ======INFORMATION SECTION========== -->
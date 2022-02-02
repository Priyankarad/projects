<!--======== Banner Start =============-->
<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">
    <div class="link_section">
        <h1>Markets</h1>
    </div>
</section>
<!--======== Banner Start =============-->
<section class="product_shope pd_all">
    <div class="container">
   <!--<div class="row justify-content-end">
      <div class="col-md-5 col-sm-12 col-12">
        <div class="search_box">
          <form method="post">
            <input type="text" name="" class="form-control" placeholder="search">
            <button type="submit" class="search_btn"><img src="<?php echo BASEURL; ?>assets/web/images/search.png"></button>
          </form>
        </div>
      </div>
      </div>-->
      <div class="row all_search_item">
        <div class="col-md-5 col-sm-3 col-xl-3 col-lg-4">
          
         
          <div class="product-sidebar-wrap mb-30">
              <div class="shop-widget">
                  <h4 class="shop-sidebar-title">Markets</h4>
                   <div class="shop-list-style my_cate mt-20">
                      <div id="vertical-menu">
    <ul>
	 <?php if(!empty($markets)){ foreach($markets as $mkts){ ?>
        <li>
          <a href="<?php echo site_url('market/viewmarket/'.encoding($mkts->id)) ?>">  <h3><?php echo $mkts->name; ?></h3></a>
        </li>
		<?php } } ?>
    </ul>
</div>
                  </div>
              </div>
          </div>
        </div>

        <div class="col-md-7 col-lg-8 col-xl-9 col-12">
            <div class="row">
			   <?php
   			     if(!empty($markets2)){ $i=$offset; foreach($markets2 as $row){ $i++;
                 $mid=encoding($row->id);
				?>	
              <div class="col-md-6 col-lg-4 col-xl-4 col-sm-6 col-12 products_detail aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">
                <div class="stamp_product">
                  <div class="post_thumb zoom">
                    <a href="<?php echo site_url('market/viewmarket/'.$mid); ?>"><img src="<?php echo BASEURL.'uploads/market/'.$row->image;  ?>" class="img-fluid" alt="images"></a>
					<p><?php echo $row->name; ?></p>
                  </div>
                </div>
              </div>
			<?php } } ?>
               <div class="col-md-12">
                <ul class="pagination my_pagination float-right">
				 <?php echo $pagination; ?>
              </div>
          </div>
        </div>
		
      </div>
    </div>
  </section>
  <!--=================Banner END-=====================-->
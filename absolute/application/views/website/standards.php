<!--========header=============-->
<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">

    <div class="link_section">
        <h1>Standards</h1>
    </div>
</section>
<!-- ======INFORMATION SECTION========== -->
<section class="news-section pd_all">
   <div class="container">
      <div class="row">
         <div class="col-sm-4">
    	    <div class="product-sidebar-wrap mb-30">
              <div class="shop-widget">
                  <h4 class="shop-sidebar-title">Standards</h4>
                   <div class="shop-list-style my_cate mt-20">
                      <div id="vertical-menu">
    <ul>
	 <?php if(!empty($standards)){ foreach($standards as $stand){ ?>
        <li>
          <a href="<?php echo site_url('standard/view/'.encoding($stand->id)) ?>">  <h3><?php echo $stand->name; ?> </h3></a>
        </li>
		<?php } } ?>
    </ul>
					</div>
                  </div>
              </div>
          </div> 
		</div>
		
		<div class="col-sm-8 right_side_data">
            <h4 class="shop-sidebar-title">Products</h4>
				<?php
	if(!empty($products)){ $i=$offset;; foreach($products as $row){ $i++;
    $mid=encoding($row->id);
	?>
    	    <div class="row product_detail">
			<div class="col-sm-2 plz">
			<a href="<?php echo site_url('product/singleproduct/'.$mid); ?>">
			 <img src="<?php echo BASEURL.'uploads/products/'.$row->images;  ?>" class="img-fluid">
			</a>
            </div>
            <div class="col-sm-10">
             <div class="descrip_detail">
			<p><?php echo $row->description;  ?></p>
</div>
                        <div class="listProductItemLink">
      <a href="<?php echo site_url('product/singleproduct/'.$mid); ?>" class="next">Read More <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
    </div>
            </div>			
		   </div> 
     <?php } } ?>
    	    <div class="row">
			<div class="col-sm-12 text-right">
			<br>
			 <?php echo $pagination; ?>			
		   </div> 
      </div>
	  
   </div>
</section>
<!-- ============MAIN NEWS START============ -->
<!-- ======INFORMATION SECTION========== -->
<!--======== Banner Start =============-->
<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">
    <div class="link_section">
        <h1><?php echo $mktdtl->name; ?></h1>
    </div>
</section>
<!--======== Banner Start =============-->


<section class="product_shope IndusSection pd_all">
    <div class="container">
    <!--<div class="row justify-content-end">
      <div class="col-md-5 col-sm-12 col-12">
        <div class="search_box mar_btm">
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
          <a href="<?php echo site_url('market/viewmarket/'.encoding($mkts->id)) ?>">  <h3><?php echo $mkts->name; ?> <!--<span class="plus">+</span> --></h3></a>
        </li>
		<?php } } ?>
    </ul>
                     </div>
                  </div>
              </div>
          </div>
         

          <div class="single-banner">
              <p>
                  <a href="shop.html">
                      <img src="<?php echo BASEURL; ?>assets/web/img/banner/banner-10.png" alt="">
                  </a>
              </p>
          </div>
        </div>




                     <div class="col-md-7 col-lg-8 col-xl-9 col-12">
                    <div class="wrapper_my row">
                        <div class="preview col-md-6 col-sm-12 col-12">
                    <div class="owl-carousel owl-theme" id="pslider">
                     <div class="item">
                               <div class="preview-pic BkWhite">
                                <div class="img_thumb1 SinIndus"><img src="<?php echo BASEURL.'uploads/market/'.$mktdtl->image;  ?>" /></div>
                               <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="view_larg view_img">view larger</a>
                            </div>
                      </div>

                   </div>

                       <div class="col-md-12 col-sm-12 col-12">
                          <div class="single-product Induper">
                            <ul class="nav">
                              <li><a><img src="<?php echo BASEURL.'uploads/market/'.$mktdtl->image;  ?>" class="active"></a>
                                  </li>
                              
                            </ul>        
                          </div>
                        </div>
                            
                        </div>
                        <div class="col-md-6 col-sm-12 col-12">
                            <div class="details">
                                   <h3 class="product-title"><?php echo $mktdtl->name; ?> </h3>
                                <div class="share_link">
                                   <p><?php echo $mktdtl->description; ?></p>
                                </div>                             

                            </div>

                        </div>

                    


                      <div class="col-md-12 col-sm-12 col-12 product_all_detaill">
 

                        <div class="panel panel-default">
                          <div class="panel-heading">OTHER PRODUCTS IN THE SAME CATEGORY:</div>
                        </div>
                      </div>



                    </div>
                </div>
</div>
</div>
</section>
  <!--=================Banner END-=====================-->

  <!-- ======INFORMATION SECTION========== -->
<section class="RelatedSection pd_all">
	<div class="container">
		<div class="RelatedPro">
			<div class="heading mar_bottom20">
                    <h2>Related Products</h2>
                </div>
			<div class="owl-carousel owl-theme" id="ProRelted">
	<?php
	if(!empty($relatedproducts)){ $j=0; foreach($relatedproducts as $row){ $j++;
    $mid=encoding($row->id);
	?>
                 <div class="item">
	                <div class="stamp_product">
                  <div class="post_thumb zoom">
                    <a href="<?php echo site_url('product/singleproduct/'.$mid); ?>"><img src="<?php echo BASEURL.'uploads/products/'.$row->images;  ?>" class="img-fluid" alt="images"></a>
                  </div>

                  <div class="post_content">
                    <div class="text-center">
                      <h3><?php echo $row->product;  ?></h3>
                    </div>
                    <?php if($row->quote==1){ ?>
					<h4>-</h4>
                    <a href="" class="add_cart">Quote Price</a>
					<?php } else{
					if(in_cart($mid)){ ?>
					<h4>$<?php echo $row->price;  ?></h4>
					<a href="<?php echo site_url('cart'); ?>" id="btn-<?php echo $mid;  ?>" class="add_cart">Added to cart</a>
					<?php }else{ ?>
					<button onclick="addtocart('<?php echo site_url('product/addtoCart') ?>','<?php echo $mid;  ?>','<?php echo $row->price;  ?>','<?php echo $row->product;  ?>','1')" id="btn-<?php echo $mid;  ?>" class="add_cart">Add to cart</button>
					<?php } } ?>
                  </div>
                </div>
                 </div>
 <?php } } ?>
                <!--  ======ITEM END======= -->
               
				
			</div>
		</div>
	</div>
</section>
<!-- ======INFORMATION SECTION========== -->
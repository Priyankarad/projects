 <!--======== Banner Start =============-->
    <section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">
        <div class="link_section">
            <h1><?php echo $productdtl->product;	?></h1>
        </div>
    </section>
    <!--======== Banner Start =============-->
<?php
$gallery=getdataByCondition(array('image'),GALLERY,array('product_id'=>$productdtl->id));
?>
    <section class="product_shope pd_all">
        <div class="container">
         
            <div class="row all_search_item">
             

                <div class="col-md-12 col-sm-12 col-xl-12 col-lg-12 col-12">
                    <div class="wrapper_my row">
                        <div class="preview col-md-6 col-sm-12 col-12">
                   <div class="owl-carousel owl-theme" id="pslider">
                    <div class="item">
                               <div class="preview-pic">
                                <div class="img_thumb1">
								<img src="<?php echo BASEURL; ?>uploads/products/<?php echo $productdtl->images; ?>" alt="<?php echo $productdtl->product;	?>" />
								</div>
                            </div>
                    </div>
					<?php if(!empty($gallery)){ $g=0; foreach($gallery as $gal){ $g++; ?>
                    <div class="item">
                               <div class="preview-pic">
                                <div class="img_thumb1"><img src="<?php echo BASEURL; ?>uploads/products/<?php echo $gal['image']; ?>" alt="Gallery <?php echo $productdtl->product;	?>" /></div>
                            </div>
                    </div>
					<?php } } ?>
                   </div>
                            
                        </div>
                        <div class="col-md-6 col-sm-12 col-12">
                            <div class="details">
                                <h3 class="product-title"><?php echo $productdtl->product; ?></h3>
<?php
/****
							   <div class="share_link">
                                  <div class="sher_text">
                                    <p>Share:</p>
                                  </div>
                                  <div class="link_here">
                                    <ul class="nav">
                                      <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                      <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                      <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                      <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                    </ul>
                                  </div>
                                </div>
***/ ?>
                                <div class="conditon">
                                  <p>Description  <span>-</span></p>
								  <p></p>
                                </div>

                                <div class="list_detail">
                                  <p><?php echo $productdtl->description;	?></p>
                                </div>

                                <div class="price_with_text">
                                    <div class="rent">
                                      <p><?php echo $productdtl->product;	?></p>
                                    </div>
                                    <?php /***
                                    <div class="price_set">
                                      <p><?php if($productdtl->price != 'Get Quote'){ echo "$ ".$productdtl->price; }else{ echo $productdtl->price; }  ?></p>
                                    </div>
									****/ ?>

                      <div class="price_set">  
					  
					<?php /*** if($productdtl->quote==1){ ?>
                    <a href="" class="add_cart">Quote Price</a>
					<?php } else{ ?>
					<a href="<?php echo site_url('cart/add'); ?>" class="btn_public">Add to cart</a>
					<?php } ***/ ?>
					
					<?php
                      $mids=encoding($productdtl->id);
					if(in_cart($mids)){ ?>
					<a href="<?php echo site_url('cart'); ?>" id="btn-<?php echo $mids;  ?>" class="btn_public">Added to cart</a>
					<?php }else{ ?>
					<button onclick="addtocart('<?php echo site_url('product/addtoCart') ?>','<?php echo $mids;  ?>','<?php echo $productdtl->price;  ?>','<?php echo $productdtl->product;  ?>','1')" id="btn-<?php echo $mids;  ?>" class="btn_public">Add to cart</button>
					<?php } ?>
						</div>			
						

                                </div>
<div class="row">
<?php 
//print_r($productdtl);die;
$files=$productdtl->files;
 if(!empty($files)){ 
  $files = unserialize($files);
  if(!empty($files)){
  foreach($files as $file){
  ?>
<div class="col-md-2">
<a target="_blank"  href="<?php echo BASEURL.'uploads/files/'.$file['document'];  ?>"><img src="<?php echo BASEURL.'uploads/download.png';  ?>" class="img-responsive img-circle" height="100px"></a>
<p style="font-size: 10px;" class="text-center"><?php echo $file['doc_name'];?></p>
</div>
<?php } }
} ?>
 </div>
 <div class="row">
<?php 
//print_r($productdtl);die;
$videos=$productdtl->videos;
 if(!empty($videos)){ ?>
<div class="col-md-12">
<!-- <a target="_blank" download href="<?php echo BASEURL.'uploads/videos/'.$videos;  ?>"><img src="<?php echo BASEURL.'uploads/videoicon.png';  ?>" class="img-responsive img-circle" height="100px"></a> -->

<iframe width="300" height="200" src="<?php echo $videos;?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>
<?php } ?>
</div>


                            </div>

                        </div>

                        <div class="col-md-12 col-sm-12 col-12">
                          <div class="single-product">
                            <ul class="nav">
							
                              <li><a><img src="<?php echo BASEURL; ?>uploads/products/<?php echo $productdtl->images; ?>" class="active" alt="<?php echo $productdtl->product;	?>"></a>
                                  </li>
							<?php if(!empty($gallery)){ $g=0; foreach($gallery as $gal){ $g++; ?>	  
                              <li><a><img src="<?php echo BASEURL; ?>uploads/products/<?php echo $gal['image']; ?>" alt="<?php echo $productdtl->product;	?>"></a>
                                  </li>
							<?php } } ?>	  
                            </ul>        
                          </div>
                        </div>


                      <div class="col-md-12 col-sm-12 col-12 product_all_detaill">
                        <div class="panel panel-default">
                          <div class="panel-heading">SPECIFICATIONS</div>
                            
                            <div class="panel-body col-md-12 col-sm-12 col-12">
                              <div class="row">
                               <?php echo $productdtl->full_description; ?>
                              </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                          <div class="panel-heading">OTHER PRODUCTS IN THE SAME CATEGORY:</div>
                        </div>
                      </div>



                    </div>
                </div>

            </div>

            <!-- other product list -->
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                    <div class="row mz">
                        
                        
                        	<div class="owl-carousel owl-theme" id="ProRelted">
	<?php
 if(!empty($products)){ foreach($products as $prd){ 
    
     $mid=encoding($prd->id); 
   // $mid=encoding($row->id);
	?>
                 <div class="item">
	                <div class="stamp_product">
                  <div class="post_thumb zoom">
                    <a href="<?php echo site_url('product/singleproduct/'.$mid); ?>"><img src="<?php echo BASEURL; ?>uploads/products/<?php echo $prd->images; ?>" class="img-fluid" alt="images"></a>
                  </div>

                  <div class="post_content">
                    <div class="text-center">
                      <h3><?php echo $prd->product; ?></h3>
                    </div>
                   <?php if(in_cart($mid)){ ?>
									<a href="<?php echo site_url('cart'); ?>" id="btn-<?php echo $mid;  ?>" class="add_cart">Added to cart</a>
									<?php }else{ ?>
									<button onclick="addtocart('<?php echo site_url('product/addtoCart') ?>','<?php echo $mid;  ?>','<?php echo $prd->price;  ?>','<?php echo $prd->product;  ?>','1')" id="btn-<?php echo $mid;  ?>" class="add_cart">Add to cart</button>
									<?php } ?>
                  </div>
                </div>
                 </div>
 <?php } } ?>
                <!--  ======ITEM END======= -->
               
				
			</div>
                        
                        
                        
					 
                        
                    </div>
                </div>

            </div>
    </section>
    <!--=================Banner END-=====================-->
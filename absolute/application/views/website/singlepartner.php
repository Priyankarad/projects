    <!--========header=============-->



    <!--======== Banner Start =============-->

    <section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">

        <div class="link_section">

            <h1><?=$partnerdata->title?></h1>

        </div>

    </section>

    <!--======== Banner Start =============-->



    <section class="product_shope pd_all">

        <div class="container">

         

            <div class="row all_search_item">

             <div class="col-md-5 col-sm-3 col-xl-3 col-lg-4">

          

         

          <div class="product-sidebar-wrap mb-30">

              <div class="shop-widget">

                  <h4 class="shop-sidebar-title">Catagories</h4>

                   <div id="vertical-menu">
    <ul>
   <?php if(!empty($categories)){ foreach($categories as $cats){ ?>
        <li>
            <h3><a href="<?php echo site_url('category/viewcategory/'.encoding($cats->id)) ?>"><?php echo $cats->category; ?>
    <?php
    $getchild=getDataByCondition(array('category','id','parent_id'),'category',array('parent_id'=>$cats->id)); ?></a>
      <?php if(!empty($getchild)){?>
      <span class="plus">+</span> 
       <?php } ?> 
      </h3>

    <?php if(!empty($getchild)){ ?>
            <ul>
    <?php foreach($getchild as $childs){ ?>
                <li><a href="<?php echo site_url('category/viewcategory/'.encoding($childs['id'])); ?>"><?php echo $childs['category']; ?></a></li>
        <?php } ?>
            </ul>
       <?php } ?> 
        </li>
    <?php } } ?>
     
       

    </ul>
</div>

              </div>

          </div>

         

      <!--     <div class="product-sidebar-wrap mb-30">

              <div class="section-title mb-10">

                  <h4 class="shop-sidebar-title">Information</h4>

              </div>

              <div class="popular-tags mt-20">

                  <ul class="nav">

                      <li><a class="tag" href="#">Shipping & Delivery</a></li>

                      <li><a class="tag" href="#">Contact Us</a></li>

                       <li><a class="tag" href="#"> Terms and Conditions</a></li>

                      <li><a class="tag" href="#">About</a></li>

                      <li><a class="tag" href="#"> Secure payment</a></li>

                    

                  </ul>

              </div>

          </div> -->

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

                                <div class="img_thumb1 SinIndus"><img src="<?php echo BASEURL; ?><?=$partnerdata->images?>" /></div>

                               <!--<a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="view_larg view_img">view larger</a>-->

                            </div>

                      </div>
                      
                   </div>

                            

                        </div>

                        <div class="col-md-6 col-sm-12 col-12">

                            <div class="details">

                                <h3 class="product-title"><?=$partnerdata->title?></h3>

                                
                                <div class="list_detail">

                                  <?=$partnerdata->content;?>
                                  

                                </div>




                            </div>



                        </div>






                      <div class="col-md-12 col-sm-12 col-12 product_all_detaill">

                       <!--  <div class="panel panel-default">

                          <div class="panel-heading">SPECIFICATIONS</div>

                            

                            <div class="panel-body col-md-6 col-sm-12 col-12">

                              <div class="row">

                                <div class="col-md-6 col-sm-6 col-6">

                                  <p>Frequency Range</p>

                                </div>

                                <div class="col-md-6 col-sm-6 col-6">

                                  <p>3 - 6.5 GHz</p>

                                </div>



                                <div class="col-md-6 col-sm-6 col-6">

                                  <p>Polarity</p>

                                </div>

                                <div class="col-md-6 col-sm-6 col-6">

                                  <p>Single linear</p>

                                </div>



                                <div class="col-md-6 col-sm-6 col-6">

                                  <p>Dimensions</p>

                                </div>

                                <div class="col-md-6 col-sm-6 col-6">

                                  <p>197 x 197 x 630</p>

                                </div>



                                <div class="col-md-6 col-sm-6 col-6">

                                  <p>Connector type</p>

                                </div>

                                <div class="col-md-6 col-sm-6 col-6">

                                  <p>PC 3.5 Female</p>

                                </div>



                                <div class="col-md-6 col-sm-6 col-6">

                                  <p>Weight</p>

                                </div>

                                <div class="col-md-6 col-sm-6 col-6">

                                  <p>2</p>

                                </div>



                                <div class="col-md-6 col-sm-6 col-6">

                                  <p>Display Interface</p>

                                </div>

                                <div class="col-md-6 col-sm-6 col-6">

                                  <p>Circular 110m</p>

                                </div>



                              </div>

                            </div>

                        </div> -->



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
  if(!empty($partnersProduct)) {
                        $count = 0;
                        foreach($partnersProduct as $product){
                          $mid=encoding($product->id); 
                          if($count<=20){
                          $count++; ?>
                 <div class="item">
	                <div class="stamp_product">
                  <div class="post_thumb zoom">
                    <a href="<?php echo site_url('product/singleproduct/'.$mid); ?>"><img src="<?php echo BASEURL.'uploads/products/'.$product->images;  ?>" class="img-fluid" alt="images"></a>
                  </div>

                  <div class="post_content">
                    <div class="text-center">
                      <h3><?php echo ucwords($product->product); $pid=encoding($product->id); ?></h3>
                    </div>
                    <?php if(in_cart($pid)){ ?>
                      <a href="<?php echo site_url("cart"); ?>" class="add_cart">Add to cart</a>
                      <?php }else{ ?>
                      	<button onclick="addtocart('<?php echo site_url('product/addtoCart') ?>','<?php echo $pid;  ?>','<?php echo $product->price;  ?>','<?php echo $product->product;  ?>','1')" id="btn-<?php echo $pid;  ?>" class="add_cart">Add to cart</button>
                      <?php } ?>
                  </div>
                </div>
                 </div>
 <?php } } } else{ ?>
   <div>No products available</div>
            <?php } ?>
            </div>

                </div>



            </div>

    </section>

    <!--=================Banner END-=====================-->
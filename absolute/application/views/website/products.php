<!--======== Banner Start =============-->
<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">
    <div class="link_section">
        <h1>Our Products</h1>
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
                  <h4 class="shop-sidebar-title">Catagories</h4>
                   <div class="shop-list-style my_cate mt-20">
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
          </div>
         
        </div>

        <div class="col-md-7 col-lg-8 col-xl-9 col-12">
            <div class="row">	
	<?php
	if(!empty($products)){ $i=$offset;; foreach($products as $row){ $i++;
    $mid=encoding($row->id);
	?>
              <div class="col-md-6 col-lg-4 col-xl-4 col-sm-6 col-12 products_detail aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">
                <div class="stamp_product">
                  <div class="post_thumb zoom">
                    <a href="<?php echo site_url('product/singleproduct/'.$mid); ?>"><img src="<?php echo BASEURL.'uploads/products/'.$row->images;  ?>" class="img-fluid" alt="images"></a>
                  </div>

                  <div class="post_content">
                    <div class="productList">
                    <div class="text-center">
                      <h3><?php echo $row->product;  ?></h3>
                    </div>
<?php 
$string = $row->description;
$stringCut = substr($string, 0, 20);
 ?>
<p><?php echo $stringCut; ?>... <a href="<?php echo site_url('product/singleproduct/'.$mid); ?>">Read More</a></p>

 <?php /***        
 <h4><?php if($row->price != '' && $row->quote==0){ echo "$ ".$row->price; }else{ echo''; }  ?></h4> 
					
					<?php if($row->quote==1){ ?>
                    <a href="javascript:void(0)" onclick="getQuote('<?php echo $mid; ?>','<?php echo site_url('product/getQuote/'); ?>')" class="add_cart">Quote Price</a>
					<?php } else{
					if(in_cart($mid)){ ?>
					<a href="<?php echo site_url('cart'); ?>" id="btn-<?php echo $mid;  ?>" class="add_cart">Added to cart</a>
					<?php }else{ ?>
					<button onclick="addtocart('<?php echo site_url('product/addtoCart') ?>','<?php echo $mid;  ?>','<?php echo $row->price;  ?>','<?php echo $row->product;  ?>','1')" id="btn-<?php echo $mid;  ?>" class="add_cart">Add to cart</button>
					<?php } } ?>
**/ ?>
       <?php if(in_cart($mid)){ ?>
		<a href="<?php echo site_url('cart'); ?>" id="btn-<?php echo $mid;  ?>" class="add_cart">Added to cart</a>
		<?php }else{ ?>
    </div>
		<button onclick="addtocart('<?php echo site_url('product/addtoCart') ?>','<?php echo $mid;  ?>','<?php echo $row->price;  ?>','<?php echo $row->product;  ?>','1')" id="btn-<?php echo $mid;  ?>" class="add_cart">Add to cart</button>
		<?php }	?>			
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
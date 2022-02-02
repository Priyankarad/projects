<section class="page-header" style="background:  url(<?php echo BASEURL.'assets/web/images/page-title.gif'; ?>) repeat center center;">
                <div class="container"><h1>Cart</h1></div></section>

<!--=============== Contact Section Start============ -->
<section class="add_to_cart pd_all">
	<div class="container contain_new">
		<div class="row">
			<table class="table table-bordered">
			    <thead>
			      <tr>
			        <th>Image</th>
			        <th>Product</th>
			        <th><i class="fa fa-trash" aria-hidden="true"></i></th>
			      </tr>
			    </thead>
			    <tbody>
				<?php
				$totals=0;
				if(!empty($cartdata)){ foreach($cartdata as $item){
					$rowid=$item['rowid'];
					$pid=$item['id'];
					$id=decoding($pid);
					$alldta=getSingleRecord(PRODUCT,array('id'=>$id));
					$rowid=$item['rowid'];
					$qty=$item['qty'];
					$price=$item['price'];
					$name=$item['name'];
					$image=$alldta->images;
					?>
			      <tr>
			        <td>
					<div class="img_cart">
					<img src="<?php echo BASEURL.'uploads/products/'.$image; ?>" class="img-fluid" alt="images">
					</div>
					</td>
			        <td><?php echo $name; ?></td>
			        <td><a href="javascript:void(0)" onclick="removefromCart('<?php echo $rowid; ?>','<?php echo site_url('product/removefromCart');?>')"  class="remove mfp-close icon-cross2" aria-label="Remove this item" data-product_id="60" data-product_sku="p-09">×</a></td>
			      </tr>
				<?php } } ?>  
			    </tbody>
			  </table>
			  
		</div>

		<div class="row justify-content-end totoal_price">
			<div class="col-md-5 col-sm-5 col-12 pz">
				  <div class="check_out">				  <?php if(!empty($cartdata)){ ?>
					<a href="<?php echo site_url('checkout'); ?>" class="btn_public update_cart w-100 text-uppercase  bfn">Proceed to checkout</a>				 <?php } ?>
				  </div>
				</form>  
			</div>
		</div>
	</div>
</section>
<!--=============== Contact Section Start============ -->
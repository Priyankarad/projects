<section class="page-header" style="background:  url(<?php echo BASEURL.'assets/web/images/page-title.gif'; ?>) repeat center center;">

                <div class="container"><h1>Cart</h1></div></section>



<!--=============== Contact Section Start============ -->

<section class="add_to_cart pd_all">

	<div class="container contain_new">

		<div class="row">

			<table class="table table-bordered">

			    <thead>

			      <tr>

			        <th>

				    </th>



			        <th>Product</th>

			        <th>Price</th>

			        <th>Quantity</th>

			        <th>Total</th>

			        <th><i class="fa fa-trash" aria-hidden="true"></i>

				    </th>

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

			        <td>$<?php echo $price; ?></td>

			        <td><input type="number" min="1" value="<?php echo $qty; ?>" onchange="calculations('<?php echo $id; ?>','<?php echo $price; ?>',this.value,'<?php echo $rowid; ?>','<?php echo site_url('product/updatecart');?>')" class="form-control item_numb bfn"></td>

			        <td>$ <span class="ttls" id="ttl-<?php echo $id; ?>" ><?php $at=$price*$qty; echo $at;   ?></span></td>

			        <td><a href="javascript:void(0)" onclick="removefromCart('<?php echo $rowid; ?>','<?php echo site_url('product/removefromCart');?>')"  class="remove mfp-close icon-cross2" aria-label="Remove this item" data-product_id="60" data-product_sku="p-09">×</a></td>



			      </tr>

				<?php $totals+=$at; } } ?>  



			      <tr class="coupon_cord">

			      	<td colspan="4">

			      		<div class="row">

			      			<div class="col-md-3 col-sm-4 col-12">

								<input type="text" placeholder="Coupon Code" class="form-control bfn" name="">

							</div>

							<div class="col-md-3 col-sm-4 col-12">

								<button type="button" class="btn_public bfn">Apply Coupon</button>

							</div>

			      		</div>

			      	</td>



			      	<td colspan="2" class="text-center">

			      		<!-- <a href="#" class="btn_public update_cart  bfn">Update Cart</a> -->

			      	</td>

			      </tr>

			     

			    </tbody>

			  </table>

			  

		</div>



		<div class="row justify-content-end totoal_price">

			<div class="col-md-5 col-sm-5 col-12 pz">

			<form action="<?php echo site_url('proceed'); ?>" method="post" name="CartProceed" id="CartProceed" >

			<input type="hidden" name="alltotal" id="alltotal" value="<?php echo $totals; ?>">

			<input type="hidden" name="discount" id="discount" value="">

			<input type="hidden" name="promocode" id="promocode" value="">

				<h4>CART TOTALS</h4>

				<table class="table table-bordered">

				    <thead>

				      <tr>

				        <td><strong>Subtotal</strong></td>

				        <td>$<span id="subtotal"><?php echo number_format($totals,2); ?></span></td>

				      </tr>

				    </thead>

				    <tbody>

				      <tr>

				        <td><strong>Total</strong></td>

				        <td><strong>$<span id="total"><?php echo number_format($totals,2); ?></span></strong></td>

				      </tr>

				    </tbody>

				  </table>



				  <div class="check_out">

					<button class="btn_public update_cart w-100 text-uppercase  bfn">Proceed to checkout</button>

				  </div>

				</form>  

			</div>

		</div>

	</div>

</section>

<!--=============== Contact Section Start============ -->
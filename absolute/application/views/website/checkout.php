<section class="page-header" style="background:  url(http://themepiko.com/demo/wooxon/default/wp-content/themes/wooxon/assets/images/page-title.gif) repeat center center;">
<div class="container"><h1>Checkout</h1></div></section>
<!--=============== Contact Section Start============ -->
<section class="check_section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-12 have_code">
				<!--- <p class="coupon_cord_clik"><img src="<?php echo BASEURL ?>assets/images/giftbox.png">Have a coupon? <a href="#"> Click here to enter your code</a></p> --->
			</div>

			<div class="col-md-12 col-sm-12 col-12">
				<div class="billing_detail" id="checkoutResponse">
				<h3>BILLING DETAILS</h3>
				<form action="javascript:void(0)" method="post" id="getquoteid">
              <div class="row"> 
              <div class="col-md-6 col-sm-6 col-12 form-group">
              <label for="Form-first">First Name*</label>
              <input type="text" name="firstname" id="Form-first" class="form-control check_empty">
			  <p class="input_error_msg">Please fill First Name.</p>
              </div>
                <div class="col-md-6 col-sm-6 col-12 form-group">
                  <label for="Form-sec">Last Name*</label>
                  <input type="text" name="lastname" id="Form-sec" class="form-control check_empty">
				  <p class="input_error_msg">Please fill Last Name.</p>
                </div>
                <div class="col-md-6 col-sm-6 col-12 form-group">
                  <label for="Form-Phone">Phone*</label>
                  <input type="text" name="phone" id="Form-Phone" class="form-control check_empty">
				  <p class="input_error_msg">Please fill Phone.</p>
                </div>

                <div class="col-md-6 col-sm-6 col-12 form-group">
                  <label for="Form-email1">Email address*</label>
                  <input type="text" name="email" id="Form-email1" class="form-control check_empty">
				  <p class="input_error_msg">Please fill Email address.</p>
                </div>
				
                <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-Company">Company name* </label>
                  <input type="text" name="company" id="Form-Company" class="form-control check_empty" required>
				  <p class="input_error_msg">Please select company.</p>
                </div>
 <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-pass1">Street address</label>
                  <input name="address" type="text" class="form-control">
				  <p class="input_error_msg">Please fill Street address.</p>
                </div>
                
                
                <div class="col-md-12 col-sm-12 col-12 form-group">
                <label for="Form-Country">Country*</label>
                <select class="form-control check_empty" id="scountry" name="country" onchange="getRelated('scountry','sstate','<?php echo site_url('product/getstate'); ?>')">
				  <option value="">Select Country</option>
				  <?php echo $allcountries; ?>
				</select>
				<p class="input_error_msg">Please select Country.</p>
                </div>
                
                <div class="col-md-4 col-sm-4 col-12 form-group">
                  <label for="Form-Company">Town / City*</label>
                  <input type="text" name="city" id="Form-email1" class="form-control check_empty">
				  <p class="input_error_msg">Please fill City.</p>
                </div>
                
             <div class="col-md-4 col-sm-4 col-12 form-group">
               <label for="Form-State">State *</label>
               <select id="sstate" class="form-control check_empty" name="state">
                <option value="">Select State</option>
				</select>
				<p class="input_error_msg">Please select State.</p>
             </div>

                <div class="col-md-4 col-sm-4 col-12 form-group">
                  <label for="Form-Postcode">Postcode / ZIP*</label>
                  <input type="text" name="zipcode" id="Form-Postcode" class="form-control check_empty" >
				  <p class="input_error_msg">Please fill zipcode.</p>
                </div>
 <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-Postcode">Please tell us more about your application/requirements (Optional)</label>
                  <textarea class="form-control" name="requirement"></textarea>
				  <p class="input_error_msg">Please fill zipcode.</p>
                </div>
                <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-email1"></label>
                  <input type="button" name="submit" value="Submit" class="btn btn-info btn-block" onclick="saveData('getquoteid','<?php echo site_url('product/quoteproducts');?>','checkoutResponse')" >
                </div>
              </div>
              </form>
			</div>
		</div>
		</div>
	</div>
</section>
<!--=============== Contact Section Start============ -->
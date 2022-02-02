<!--========header=============-->

<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">

    <div class="link_section">
        <h1>Create RMA / Ticket</h1>
    </div>

</section>
<form action="<?php echo site_url('pages/rmatickets/form'); ?>" id="ticket-form">
<section class="create-rma">
	<div class="container contain_new">
		<div class="row">
			<div class="col-md-4 col-sm-12">
				<div class="form-group">
					<label>First Name </label>
					<input type="text" name="fname" class="form-control" required="" />
				</div>
			</div>
			<div class="col-md-4 col-sm-12">
				<div class="form-group">
					<label>Last Name </label>
					<input type="text" name="lname" class="form-control" required="" />
				</div>
			</div>
			<div class="col-md-4 col-sm-12">
				<div class="form-group">
					<label>Company </label>
					<input type="text" name="company" class="form-control" required="" />
				</div>
			</div>
			<div class="col-md-12 col-sm-12">
				<div class="form-group">
					<label>Address - Provide Address below where unit should be returned. No P.O. Boxes *  </label>
					<textarea class="form-control" required="" name="address"  rows="5"></textarea>
				</div>
			</div>
			<div class="col-md-3 col-sm-12">
				<div class="form-group">
					<label>City </label>
					<input type="text" name="city" class="form-control" required="" />
				</div>
			</div>
			<div class="col-md-3 col-sm-12">
				<div class="form-group">
					<label>State / Territory </label>
					<input type="text" name="state" class="form-control" required="" />
				</div>
			</div>
			<div class="col-md-3 col-sm-12">
				<div class="form-group">
					<label>Country </label>
					<input type="text" name="country" class="form-control" required="" />
				</div>
			</div>
			<div class="col-md-3 col-sm-12">
				<div class="form-group">
					<label>Zip / Territory Code</label>
					<input type="text" name="zip" class="form-control" required="" />
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label>Phone</label>
					<input type="text" name="phone" class="form-control" required="" />
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label>Email </label>
					<input type="email" name="email" class="form-control" required="" />
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label>Select RMA  </label>
					<select class="form-control" name="rma" required="" >
						<option>Calibration</option>
						<option>Repair</option>
						<option>Upgrade</option>
					</select>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label>Model / Part Number </label>
					<input type="text" name="modal_no" class="form-control" required="" />
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label>Part Description </label>
					<input type="text" name="description" class="form-control" required="" />
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label>Serial#</label>
					<input type="text" name="serial" class="form-control" required="" />
				</div>
			</div>
			<div class="col-md-12 col-sm-12">
				<div class="form-group">
					<label>Detailed description of failure or if Calibration Only is required</label>
					<textarea class="form-control" name="calibration" required=""  rows="5"></textarea>
				</div>
			</div>
			<div class="col-md-12 col-sm-12">
				<div class="form-group">
					<input type="submit" style="cursor:pointer" class="btn_public" value="Create RMA Ticket"/>
				</div>
			</div>
		</div>	
	</div>
</section>
</form>
 

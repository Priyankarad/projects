<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            	<div class="tile">
                    <div class="t-header">
                        <div class="th-title"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span> Change Password</div>
                    </div>
                    
                    <div class="t-body tb-padding">
                        <div class="row">
                        	<form method="post" id="password_form" class="profile_form" novalidate="novalidate">
	                          <div class="form-group col-sm-12">
	                          <div class="col-sm-3">
	                          	<label>New Password</label>
	                          </div>
	                          <div class="col-sm-5">
	                          	<input type="password" placeholder="New Password" class="form-control" id="new_pswd" name="new_pswd" required>
	                          </div>
	                          </div>

	                          <div class="form-group col-sm-12">
	                          <div class="col-sm-3">
	                          	<label>Confirm Password</label>
	                          </div>
	                          <div class="col-sm-5">
	                          	<input type="password" placeholder="Confirm Password" class="form-control" id="confirm_pswd" name="confirm_pswd" required>
	                          </div>
	                          </div>
                                <div class="form-group col-sm-12 text-center">
                                    <button class="btn btn-primary create_btn" >Update</button>
                                    <button type="button" class="btn btn-danger cancel-btn">Reset</button>
	                            </div>
                            <form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>asset/admin/js/custom/myprofile.js"></script>

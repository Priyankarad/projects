<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Administrator</a></li>
        <li>Vendors</li>
        <li class="active">Add Vendor</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
<?php alert(); ?>
         <div class="box">
	      <div class="box-header with-border">
              <h3 class="box-title">Add Vendor</h3>
           </div>
         <form class="form-horizontal" action="<?php echo site_url('administrator/insertvendor') ?>" method="post">
                  <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">First Name</label>

                    <div class="col-sm-10">
                      <input type="text" name="firstname"  class="form-control" id="firstname" placeholder="First Name">
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="lastname" class="col-sm-2 control-label">Last Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control"  name="lastname" id="lastname" placeholder="Last Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" name="email"  class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" name="password"  class="form-control" id="password" placeholder="Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ConfirmPassword" class="col-sm-2 control-label">Confirm Password</label>
                    <div class="col-sm-10">
                      <input type="password" name="confirmpassword"  class="form-control" id="ConfirmPassword" placeholder="Confirm Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mobile" class="col-sm-2 control-label">Mobile</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control"  name="mobile" id="mobile" placeholder="Mobile">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="currency" class="col-sm-2 control-label">Currency</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="currency" id="currency" >
					  <option value="">Select Currency</option>
					  <?php if(!empty($currency)){ foreach($currency as $curr){ ?>
					  <option value="<?php echo $curr->id; ?>"><?php echo $curr->currency; ?> ( <?php echo $curr->symbol; ?> )</option>
					  <?php } } ?>
					  </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
         </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
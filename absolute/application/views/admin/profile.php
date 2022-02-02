 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Administrator</a></li>
        <li class="active">User profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo BASEURL ?>assets/img/user4-128x128.jpg" alt="User profile picture">
              <h3 class="profile-username text-center"><?php echo $userdata->firstname .' '.$userdata->lastname;  ?></h3>

              

              
            </div>
            <!-- /.box-body -->
          </div>
		  <p class="text-muted text-center"><?php echo $userdata->email;  ?></p>
		  <p><a href="javascipt:void(0)"  data-toggle="modal" data-target="#changePassword" class="btn btn-primary btn-block"><b>Change Password</b></a></p>
          <!-- /.box -->
          <!-- /.box -->
        </div>
        <!-- /.col -->
    <div class="col-md-9">
    <?php alert() ?>
    
	<form class="form-horizontal" action="<?php echo site_url('administrator/updateprofile') ?>" method="post">
                  <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">First Name</label>

                    <div class="col-sm-10">
                      <input type="text" name="firstname" value="<?php echo $userdata->firstname; ?>" class="form-control" id="firstname" placeholder="First Name">
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="lastname" class="col-sm-2 control-label">Last Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $userdata->lastname; ?>" name="lastname" id="lastname" placeholder="Last Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" name="email" value="<?php echo $userdata->email; ?>" class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mobile" class="col-sm-2 control-label">Mobile</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $userdata->mobile; ?>" name="mobile" id="mobile" placeholder="Mobile">
                    </div>
                  </div>
                
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
            
         
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <div id="changePassword" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Password</h4>
      </div>
      <div class="modal-body">
         <form action="<?php echo site_url('administrator/changepassword'); ?>" method="post" onsubmit="return checkpass()" class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Old Password</label>

                    <div class="col-sm-10">
                      <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Old Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">New Password</label>

                    <div class="col-sm-10">
                      <input type="password" name="new_password" class="form-control" id="new_password" placeholder="New password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Confirm password</label>

                    <div class="col-sm-10">
                      <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm password">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                  </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

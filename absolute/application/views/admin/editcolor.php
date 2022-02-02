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
        <li>Colors</li>
        <li class="active">Edit Color</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
<?php alert(); ?>
         <div class="box">
		  <div class="box-header with-border">
              <h3 class="box-title">Edit Color</h3>
           </div>
         <form class="form-horizontal" action="<?php echo site_url('administrator/updatecolor') ?>" method="post" enctype="multipart/form-data">
		 <input type="hidden" name="id" value="<?php echo encoding($userdata->id) ?>" >
                  <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">Color Name</label>

                    <div class="col-sm-10">
                      <input type="text" name="color" value="<?php echo $userdata->color; ?>" class="form-control" id="color" placeholder="Color Name">
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <label for="lastname" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                      <img src="<?php echo BASEURL.'uploads/colors/'.$userdata->image;  ?>" class="img-responsive img-circle" style="width:50px">
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <label for="lastname" class="col-sm-2 control-label">Color Image</label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control" name="image" id="image" >
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
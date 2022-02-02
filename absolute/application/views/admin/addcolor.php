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
        <li class="active">Add Color</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
<?php alert(); ?>
         <div class="box">
	      <div class="box-header with-border">
              <h3 class="box-title">Add Color</h3>
           </div>
         <form class="form-horizontal" action="<?php echo site_url('administrator/insertcolor') ?>" enctype="multipart/form-data" method="post">
                  <div class="form-group">
                    <label for="Color" class="col-sm-2 control-label">Color Name</label>

                    <div class="col-sm-10">
                      <input type="text" name="color"  class="form-control" id="Color" placeholder="Color Name">
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="Colorimage" class="col-sm-2 control-label">Image</label>

                    <div class="col-sm-10">
                      <input type="file" class="form-control"  name="image" id="Colorimage" required>
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
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
        <li>Size</li>
        <li class="active">Add Size</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
<?php alert(); ?>
         <div class="box">
	      <div class="box-header with-border">
              <h3 class="box-title">Add Size</h3>
           </div>
         <form class="form-horizontal" action="<?php echo site_url('administrator/insertsize') ?>" method="post">
                  <div class="form-group">
                    <label for="size" class="col-sm-2 control-label">Size</label>
                    <div class="col-sm-10">
                      <input type="text" name="size"  class="form-control" id="size" placeholder="Size">
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
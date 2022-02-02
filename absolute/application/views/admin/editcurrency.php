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
        <li>Currency</li>
        <li class="active">Edit Currency</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
     <?php alert(); ?>
         <div class="box">
		  <div class="box-header with-border">
              <h3 class="box-title">Edit Customer</h3>
           </div>
				<form class="form-horizontal" action="<?php echo site_url('administrator/updatecurrency') ?>" method="post">
				<input type="hidden" name="id" value="<?php echo encoding($userdata->id) ?>" >
                  <div class="form-group">
                    <label for="currency" class="col-sm-2 control-label">Currency</label>
                    <div class="col-sm-10">
                      <input type="text" name="currency" value="<?php echo $userdata->currency; ?>" class="form-control" id="currency" placeholder="Currency">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="currency" class="col-sm-2 control-label">Symbol</label>
                    <div class="col-sm-10">
                      <input type="text" name="symbol" value="<?php echo $userdata->symbol; ?>" class="form-control" id="symbol" placeholder="Symbol">
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
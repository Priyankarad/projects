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
        <li>LINK</li>
        <li class="active">Edit Link</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
<?php alert(); ?>
         <div class="box">
		  <div class="box-header with-border">
              <h3 class="box-title">Edit Link</h3>
           </div>
         <form class="form-horizontal" action="<?php echo site_url('administrator/updatelink') ?>" method="post" enctype='multipart/form-data'>
		 <input type="hidden" name="id" value="<?php echo encoding($userdata->id) ?>" >
                  <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                      <input type="text" name="title" value="<?php echo $userdata->title; ?>" class="form-control" id="title" placeholder="Title">
                    </div>
                  </div>
				   
				 <div class="form-group">
					<label for="marketimage" class="col-sm-2 control-label">URL</label>
					<div class="col-sm-10">
					  <input type="url" name="url" value="<?php echo $userdata->url; ?>" class="form-control" id="url" placeholder="URL">
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
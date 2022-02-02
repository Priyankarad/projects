  <script src="<?php echo BASEURL; ?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
    tinymce.init({
      selector: "#description",
      plugins: "link image"
    });
  </script>
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
        <li>Article</li>
        <li class="active">Add Article</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
<?php alert(); ?>
         <div class="box">
	      <div class="box-header with-border">
              <h3 class="box-title">Add Article</h3>
           </div>
         <form class="form-horizontal" action="<?php echo site_url('administrator/insertarticle') ?>" method="post" enctype='multipart/form-data'>
		  <div class="form-group">
			<label for="title" class="col-sm-2 control-label"> Title</label>
			<div class="col-sm-10">
			  <input type="text" name="title" class="form-control" id="title" placeholder="Title">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="marketimage" class="col-sm-2 control-label">Image</label>
			<div class="col-sm-10">
			  <input type="file" class="form-control"  name="marketimage" id="marketimage" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="description" class="col-sm-2 control-label">Description</label>
			<div class="col-sm-10">
			  <textarea class="form-control"  name="description" id="description"></textarea>
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
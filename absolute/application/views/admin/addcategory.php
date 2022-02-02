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
        <li>Category</li>
        <li class="active">Add Category</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
<?php alert(); ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">

         <div class="box">
	      <div class="box-header with-border">
              <h3 class="box-title">Add Category</h3>
           </div>
         <form class="form-horizontal" action="<?php echo site_url('administrator/insertcategory') ?>" method="post">
                  <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10">
                      <input type="text" name="category"  class="form-control" id="category" placeholder="Category">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="parent_category" class="col-sm-2 control-label">Parent Category</label>
                    <div class="col-sm-10">
                      <select class="form-control"  name="parent_category" id="parent_category">
					  <option value="">Select parent category</option>
					  <?php if(!empty($category)){ foreach($category as $cat){ ?>
					  <option value="<?php echo $cat->id; ?>"><?php echo $cat->category; ?></option>
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
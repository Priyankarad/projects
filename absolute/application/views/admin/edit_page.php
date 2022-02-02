<script src="<?php echo BASEURL; ?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: ".timymce_editor",
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
            <li>Page Settings</li>
            <li class="active">Edit Page</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <?php alert(); ?>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Page</h3>
                </div>
                <form class="form-horizontal" action="<?php echo site_url('administrator/updatepage') ?>" method="post" enctype='multipart/form-data'>
                    <input type="hidden" name="id" value="<?php echo encoding($pageData->id) ?>" >
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="<?php echo $pageData->name; ?>" class="form-control" id="name" placeholder="Name" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Contents</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor"  name="contents" id="contents"><?php echo $pageData->contents; ?></textarea>
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

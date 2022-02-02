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
            <li class="active">Edit Services Page</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <?php alert(); ?>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Services Page</h3>
                </div>
                <form class="form-horizontal" action="<?php echo site_url('administrator/updatepage') ?>" method="post" enctype='multipart/form-data'>
                    <input type="hidden" name="page" value="services">
                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Consulting</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="consulting" name="consulting"><?php echo $pageData[0]->value;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Service and Calibration</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="service_and_calibration" name="service_and_calibration"><?php echo $pageData[1]->value;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Quality Statement</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="quality_statement" name="quality_statement"><?php echo $pageData[2]->value;?></textarea>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Investment</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="investment" name="investment"><?php echo $pageData[3]->value;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Investment Image</label>
                        <div class="col-sm-10">
                            <input type="file"  class="form-control" accept="image/*" name="investment_image" id="investment_image" >
                            <img src="<?php echo base_url().$pageData[7]->value;?>" height="50" width="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Prove Your Setup</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="prove_your_setup" name="prove_your_setup"><?php echo $pageData[4]->value;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Prove Your Setup Image</label>
                        <div class="col-sm-10">
                            <input type="file"  class="form-control" accept="image/*" name="prove_your_setup_image" id="prove_your_setup_image" >
                            <img src="<?php echo base_url().$pageData[8]->value;?>" height="50" width="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Onsite Or Remote</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="onsite_or_remote" name="onsite_or_remote"><?php echo $pageData[5]->value;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Onsite Or Remote Image</label>
                        <div class="col-sm-10">
                            <input type="file"  class="form-control" accept="image/*" name="onsite_or_remote_image" id="onsite_or_remote_image" >
                            <img src="<?php echo base_url().$pageData[9]->value;?>" height="50" width="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Take The Next Step</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="take_the_next_step" name="take_the_next_step"><?php echo $pageData[6]->value;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Take The Next Step Image</label>
                        <div class="col-sm-10">
                            <input type="file"  class="form-control" accept="image/*" name="take_the_next_step_image" id="take_the_next_step_image">
                            <img src="<?php echo base_url().$pageData[10]->value;?>" height="50" width="50">
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

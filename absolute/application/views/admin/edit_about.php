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
            <li class="active">Edit About Us Page</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <?php alert(); ?>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit About Us Page</h3>
                </div>
                <form class="form-horizontal" action="<?php echo site_url('administrator/updatepage') ?>" method="post" enctype='multipart/form-data'>
                    <input type="hidden" name="page" value="about">
                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">About Absolute EMC</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="timymce_editor" name="about_absolute_emc"><?php echo $pageData[0]->value;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">About Absolute EMC Image</label>
                        <div class="col-sm-10">
                            <input type="file"  class="form-control" accept="image/*" name="emc_image" id="emc_image" >
                            <img src="<?php echo base_url().$pageData[6]->value;?>" height="50" width="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Biography</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="biography" name="biography"><?php echo $pageData[1]->value;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Biography Image</label>
                        <div class="col-sm-10">
                            <input type="file"  class="form-control" accept="image/*" name="bio_image" id="bio_image" >
                            <img src="<?php echo base_url().$pageData[7]->value;?>" height="50" width="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Fast Response</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="fast_response"  name="fast_response"><?php echo $pageData[2]->value;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Fast Response Image</label>
                        <div class="col-sm-10">
                            <input type="file"  class="form-control" accept="image/*" name="fast_image" id="fast_image" >
                            <img src="<?php echo base_url().$pageData[8]->value;?>" height="50" width="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Attention To Detail</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="attention_to_detail" name="attention_to_detail"><?php echo $pageData[3]->value;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Attention To Detail Image</label>
                        <div class="col-sm-10">
                            <input type="file"  class="form-control" accept="image/*" name="attention_image" id="attention_image" >
                            <img src="<?php echo base_url().$pageData[9]->value;?>" height="50" width="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Cut Through It All</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="cut_through_it_all" name="cut_through_it_all"><?php echo $pageData[4]->value;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Cut Through It All Image</label>
                        <div class="col-sm-10">
                            <input type="file"  class="form-control" accept="image/*" name="cut_image" id="cut_image" >
                            <img src="<?php echo base_url().$pageData[10]->value;?>" height="50" width="50">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Quality Statement</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="quality_statement"  name="quality_statement"><?php echo $pageData[5]->value;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Quality Statement Image</label>
                        <div class="col-sm-10">
                            <input type="file"  class="form-control" accept="image/*" name="quality_image" id="quality_image" >
                            <img src="<?php echo base_url().$pageData[11]->value;?>" height="50" width="50">
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

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
            <li>Partners</li>
            <li class="active">Add Partner</li>
        </ol>
        <?php echo   $this->session->flashdata('erro_msg'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <?php alert(); ?>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Partner</h3>
                </div>
                
                <form class="form-horizontal" action="<?php echo site_url('administrator/addpartner') ?>" method="post" enctype="multipart/form-data">
                    <?php
                    if(!empty($userdata)){
                     echo '<input type="hidden" name="partnerid" value="'.encoding($userdata->id).'"/>';
                    }
                    ?>
                    <div class="form-group">
                        <label for="Product" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="partnertitle"  class="form-control" id="partnertitle" placeholder="Title" value="<?=(isset($userdata) ? $userdata->title : '')?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="timymce_editor" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control timymce_editor" id="timymce_editor" name="partner_desc"><?=(isset($userdata) ? $userdata->content : '')?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Images" class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-10">
                            <?php if(isset($userdata) && $userdata->images!=''){
echo '<input type="hidden" name="oldimage" value="'.($userdata->images).'"/>';
echo '<div class="col-sm-10">
            <div class="col-sm-2">
                <a target="_blank" href="'.BASEURL.$userdata->images.'"><img src="'.BASEURL.$userdata->images.'" class="img-responsive img-circle"></a>
            </div>

        </div>';
        echo '<input type="file" name="partnerimage" id="partnerimage"/>';
                            }else{
                               echo '<input type="file" name="partnerimage" id="partnerimage"/>'; 
                            } ?>
                            
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
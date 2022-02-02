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
            <li class="active">Edit Download Page</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Download Page</h3>
            </div>
            <form class="form-horizontal" action="<?php echo site_url('administrator/updateDownload') ?>" method="post" enctype='multipart/form-data'>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Brochure Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" accept="image/*" name="brochure_image" id="brochure_image" >
                        <?php if(!empty($download['result'][0]->image)){ ?>
                            <img src="<?php echo BASEURL.$download['result'][0]->image?>" height="50px" width="50px">
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Brochure Sub Files</label>
                    <div class="col-sm-10">
                        <input type="button" class="addBrochure" value="+Add Brochures">
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10 brochureClass">
                        <?php 
                        if(!empty($downloadDcouments['result'])){
                            foreach($downloadDcouments['result'] as $img){
                                if($img->type_id == 1){ ?>
                                    <div class="col-sm-2">
                                        <a target="_blank" href="<?php echo BASEURL.$img->image; ?>"><img src="<?php echo BASEURL;?>uploads/download.png" class="img-responsive img-circle"></a>
                                        <p class="text-center"><span><?php echo ucwords($img->doc_name);?></span></p>
                                        <p class="text-center"><a href="<?php echo BASEURL.'administrator/deleteDocument/'.$img->id.'/4'?>" class="text-danger" style="cursor:pointer" onclick="return confirm('Are you sure?')"> <i class="fa fa-trash" aria-hidden="true"></i></a></p>
                                    </div>
                                <?php }
                            }
                        }
                        ?>
                    </div>
                </div>


                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Manuals Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" accept="image/*" name="manual_image" id="manual_image" >
                        <?php if(!empty($download['result'][1]->image)){ ?>
                            <img src="<?php echo BASEURL.$download['result'][1]->image?>" height="50px" width="50px">
                        <?php } ?>
                    </div>
                </div>


                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Manuals Sub Files</label>
                    <div class="col-sm-10">
                        <input type="button" class="addManuals" value="+Add Manuals">
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10 manualsClass">
                        <?php 
                        if(!empty($downloadDcouments['result'])){
                            foreach($downloadDcouments['result'] as $img){
                                if($img->type_id == 2){ ?>
                                    <div class="col-sm-2">
                                        <a target="_blank" href="<?php echo BASEURL.$img->image; ?>"><img src="<?php echo BASEURL;?>uploads/download.png" class="img-responsive img-circle"></a>
                                        <p class="text-center"><span><?php echo ucwords($img->doc_name);?></span></p>
                                        <p class="text-center"><a href="<?php echo BASEURL.'administrator/deleteDocument/'.$img->id.'/4'?>" class="text-danger" style="cursor:pointer" onclick="return confirm('Are you sure?')"> <i class="fa fa-trash" aria-hidden="true"></i></a></p>
                                    </div>
                                <?php }
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Software/Firmware Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" accept="image/*" name="software_image" id="software_image" >
                    </div>
                </div>

                <?php if(!empty($download['result'][2]->image)){ ?>
                            <img src="<?php echo BASEURL.$download['result'][2]->image?>" height="50px" width="50px">
                        <?php } ?>
                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Software/Firmware Sub Files</label>
                    <div class="col-sm-10">
                        <input type="button" class="addSoftware" value="+Add Software/Firmware">
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10 softwareClass">
                        <?php 
                        if(!empty($downloadDcouments['result'])){
                            foreach($downloadDcouments['result'] as $img){
                                if($img->type_id == 3){ ?>
                                    <div class="col-sm-2">
                                        <a target="_blank" href="<?php echo BASEURL.$img->image; ?>"><img src="<?php echo BASEURL;?>uploads/download.png" class="img-responsive img-circle"></a>
                                        <p class="text-center"><span><?php echo ucwords($img->doc_name);?></span></p>
                                        <p class="text-center"><a href="<?php echo BASEURL.'administrator/deleteDocument/'.$img->id.'/4'?>" class="text-danger" style="cursor:pointer" onclick="return confirm('Are you sure?')"> <i class="fa fa-trash" aria-hidden="true"></i></a></p>
                                    </div>
                                <?php }
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Fliers Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" accept="image/*" name="fliers_image" id="fliers_image" >
                        <?php if(!empty($download['result'][3]->image)){ ?>
                            <img src="<?php echo BASEURL.$download['result'][3]->image?>" height="50px" width="50px">
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Fliers Sub Files</label>
                    <div class="col-sm-10">
                        <input type="button" class="addFlier" value="+Add Fliers">
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10 flierClass">
                        <?php 
                        if(!empty($downloadDcouments['result'])){
                            foreach($downloadDcouments['result'] as $img){
                                if($img->type_id == 4){ ?>
                                    <div class="col-sm-2">
                                        <a target="_blank" href="<?php echo BASEURL.$img->image; ?>"><img src="<?php echo BASEURL;?>uploads/download.png" class="img-responsive img-circle"></a>
                                        <p class="text-center"><span><?php echo ucwords($img->doc_name);?></span></p>
                                        <p class="text-center"><a href="<?php echo BASEURL.'administrator/deleteDocument/'.$img->id.'/4'?>" class="text-danger" style="cursor:pointer" onclick="return confirm('Are you sure?')"> <i class="fa fa-trash" aria-hidden="true"></i></a></p>
                                    </div>
                                <?php }
                            }
                        }
                        ?>
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

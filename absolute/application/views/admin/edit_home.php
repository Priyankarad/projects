<script src="<?php echo BASEURL; ?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
<style>
    .custom-dynamic-table td{ padding:5px; }
</style>
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
            <li class="active">Edit Home Page</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Home Page</h3>
            </div>
            <form class="form-horizontal" action="<?php echo site_url('administrator/updatepage') ?>" method="post" enctype='multipart/form-data'>
                <?php 
                $imagesArr = !empty($pageData[14]->value)?explode('|',$pageData[14]->value):'';
                ?>
                <input type="hidden" id="scount" value="<?php echo !empty($imagesArr)?count($imagesArr):0;?>">
                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Fast Response</label>
                    <input type="button" id="addNew" value="+ Add more"><br/><br/>
                    <div class="col-sm-10">
                        <ul id="bkup_doc_rw">
                            <?php if(!empty($sliderData['result'])){
                                $sscount = 0;
                                foreach($sliderData['result'] as $row){ 
                                    $sscount++; ?>
                                    <li>
                                        <div><table class="custom-dynamic-table"><tr><td width="250"><img id="img<?php echo $sscount;?>"  src="<?php echo base_url().$row->image;?>" width="100%" ></td><td><input value="<?php echo $row->url; ?>" type="url" name="url[]"></td><td><a style="text-decoration: none;cursor: pointer;" href="<?php echo base_url()?>administrator/deleteSlider/<?php echo $row->id;?>/3"> x </a></td></tr></table>
                                        </div>
                                    </li>
                                <?php }
                            }else{ ?>
                                <li id="">
                                    <div><input type="file" onchange="readURL(this,1);" accept=".png, .jpg, .jpeg, .gif" name="files[]" id="bkup_doc_proof" required/><img id="img1" width="20%" >
                                    </div>
                                </li> 
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <input type="hidden" name="page" value="home">
                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Fast Response</label>
                    <div class="col-sm-10">
                        <textarea class="form-control timymce_editor" id="fast_response"  name="fast_response"><?php echo $pageData[0]->value;?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Fast Response Image</label>
                    <div class="col-sm-10">
                        <input type="file"  class="form-control" accept="image/*" name="fast_image" id="fast_image" >
                        <img src="<?php echo BASEURL.$pageData[1]->value;?>" height="50" width="50">
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Attention To Detail</label>
                    <div class="col-sm-10">
                        <textarea class="form-control timymce_editor" id="attention_to_detail" name="attention_to_detail"><?php echo $pageData[2]->value;?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Attention To Detail Image</label>
                    <div class="col-sm-10">
                        <input type="file"  class="form-control" accept="image/*" name="attention_image" id="attention_image" >
                        <img src="<?php echo BASEURL.$pageData[3]->value;?>" height="50" width="50">
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
                        <img src="<?php echo BASEURL.$pageData[5]->value;?>" height="50" width="50">
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Image 1</label>
                    <div class="col-sm-10">
                        <input type="file"  class="form-control" accept="image/*" name="image_1" id="image_1" >
                        <img src="<?php echo BASEURL.$pageData[6]->value;?>" height="50" width="50">
                    </div>
                </div>
                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Image 2</label>
                    <div class="col-sm-10">
                        <input type="file"  class="form-control" accept="image/*" name="image_2" id="image_2" >
                        <img src="<?php echo BASEURL.$pageData[7]->value;?>" height="50" width="50">
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">EMC & RF Market Knowledge</label>
                    <div class="col-sm-10">
                        <textarea class="form-control timymce_editor" id="emc_rf" name="emc_rf"><?php echo $pageData[8]->value;?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">EMC & RF Market Knowledge Image</label>
                    <div class="col-sm-10">
                        <input type="file"  class="form-control" accept="image/*" name="emc_rf_image" id="emc_rf_image" >
                        <img src="<?php echo BASEURL.$pageData[9]->value;?>" height="50" width="50">
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Standards & Equipment</label>
                    <div class="col-sm-10">
                        <textarea class="form-control timymce_editor" id="standards_equipment" name="standards_equipment"><?php echo $pageData[10]->value;?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Standards & Equipment Image</label>
                    <div class="col-sm-10">
                        <input type="file"  class="form-control" accept="image/*" name="standards_equipment_image" id="standards_equipment_image" >
                        <img src="<?php echo BASEURL.$pageData[11]->value;?>" height="50" width="50">
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Test Setup Products</label>
                    <div class="col-sm-10">
                        <textarea class="form-control timymce_editor" id="test_setup_products" name="test_setup_products"><?php echo $pageData[12]->value;?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="timymce_editor" class="col-sm-2 control-label">Test Setup Products Image</label>
                    <div class="col-sm-10">
                        <input type="file"  class="form-control" accept="image/*" name="test_setup_products_image" id="test_setup_products_image" >
                        <img src="<?php echo BASEURL.$pageData[13]->value;?>" height="50" width="50">
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

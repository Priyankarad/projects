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
            <li>Products</li>
            <li class="active">Edit Product</li>
        </ol>
        <?php echo   $this->session->flashdata('erro_msg');
        ?>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <?php alert(); ?>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Product</h3>
                    <div class="text-right"><a href="<?php echo site_url('administrator/products'); ?>" class="btn btn-info"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></div>
                </div>
                <form class="form-horizontal" action="<?php echo site_url('administrator/updateproduct') ?>" method="post" onsubmit="reeturn addProductValidation()" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo encoding($userdata->id) ?>" >
                    <div class="form-group">
                        <label for="Product" class="col-sm-2 control-label">Product</label>
                        <div class="col-sm-10">
                            <input type="text" name="product"  class="form-control" value="<?php echo $userdata->product; ?>" id="Product" placeholder="Product">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Category" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10">

                            <?php
                            if(!empty($category)){ foreach($category as $cat){
                              $carray=array(); if(!empty($userdata->category)){ $carray=explode(',',$userdata->category); } ?>
                              <div class="col-sm-3">
                                <input type="checkbox" name="category[]" <?php if(in_array($cat->id,$carray)){ echo 'checked'; }?> id="Category" value="<?php echo $cat->id; ?>"><?php echo $cat->category; ?>
                            </div>
                        <?php } } ?>

</div>
</div>
<div class="form-group">
    <label for="market" class="col-sm-2 control-label">Market</label>
    <div class="col-sm-10">
        <?php
        if(!empty($market)){ foreach($market as $mark){
            $marray=array(); if(!empty($userdata->market)){ $marray=explode(',',$userdata->market); }	
            ?>
            <div class="col-sm-3">
                <input type="checkbox" <?php if(in_array($mark->id,$marray)){ echo 'checked'; }?> name="market[]" id="market"  value="<?php echo $mark->id; ?>"><?php echo $mark->name; ?>
            </div>
        <?php } } ?>

</div>
</div>
<div class="form-group">
    <label for="standard" class="col-sm-2 control-label">Standard</label>
    <div class="col-sm-10">
        <?php
        if(!empty($standard)){ foreach($standard as $stan){
            $sarray=array(); if(!empty($userdata->standard)){ $sarray=explode(',',$userdata->standard); }
            ?>
            <div class="col-sm-3">
                <input type="checkbox" name="standard[]" <?php if(in_array($stan->id,$sarray)){ echo 'checked'; }?> id="standard"  value="<?php echo $stan->id; ?>"><?php echo $stan->name; ?>
            </div>
        <?php } } ?>
    </div>
</div>
<div class="form-group">
    <label for="manufacture" class="col-sm-2 control-label">Manufacture</label>
    <div class="col-sm-10">
        <input type="text" name="manufacture"  class="form-control" value="<?php echo $userdata->manufacture; ?>" id="manufacture" placeholder="Manufacture">
    </div>
</div>
<div class="form-group">
    <label for="Price" class="col-sm-2 control-label">Price</label>
    <div class="col-sm-10">
        <input type="text" name="price"  class="form-control" value="<?php echo $userdata->price; ?>" id="Price" placeholder="Price">
    </div>
</div>
<div class="form-group">
    <label for="quote" class="col-sm-2 control-label">Request Quote</label>
    <div class="col-sm-10">
        <input type="checkbox" name="quote" <?php if($userdata->quote==1){ echo 'checked';} ?>   value="1" id="quote" placeholder="quote">
    </div>
</div>

<div class="form-group">
    <label for="Price" class="col-sm-2 control-label">Partner</label>
    <div class="col-sm-10">
        <select id="partner" name="partners[]" multiple="" class="form-control">
            <option value="">Select Partner</option>
            <?php 
            if(!empty($partners)){
                $partners1 = !empty($userdata->partners)?explode(',',$userdata->partners):array();
                foreach($partners as $partner){ ?>
                    <option value="<?php echo $partner->id;?>" <?php echo in_array($partner->id,$partners1)?'selected':'';?>><?php echo $partner->title;?></option>
                <?php }
            }
            ?>
        </select>
    </div>
</div>

<?php $images=$userdata->images; if(!empty($images)){ ?>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
            <div class="col-sm-2">
                <img src="<?php echo BASEURL.'uploads/products/'.$userdata->images;  ?>" class="img-responsive img-circle">
            </div>

        </div>
    </div>
<?php } ?>				  
<div class="form-group">
    <label for="Images" class="col-sm-2 control-label">Image</label>
    <div class="col-sm-10">
        <input type="file" class="form-control" name="image" id="Images" >
    </div>
</div>

<div class="form-group">
    <label for="Description" class="col-sm-2 control-label">Small Description</label>
    <div class="col-sm-10">
        <textarea class="form-control" name="description" id="Description" ><?php echo $userdata->description; ?></textarea>
    </div>
</div>
<div class="form-group">
    <label for="timymce_editor" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        <textarea class="form-control timymce_editor" id="timymce_editor" name="full_description" ><?php echo $userdata->full_description; ?></textarea>
    </div>
</div>
<div class="form-group">
    <label for="gallery" class="col-sm-2 control-label"></label>
    <div class="col-sm-10">
        <?php
        $imgd=getAllwhere(GALLERY,array('product_id'=>$userdata->id),'id','DESC');
        $images=$imgd['result'];
        if(!empty($images)){
            foreach($images as $img){

                echo '<div class="col-md-2 text-center img'.$img->id.'"> <img src="'.BASEURL.'uploads/products/'.$img->image.'" class="img-responsive img-thumbnail" >
                <span class="text-danger" onclick="return deleteproductimage(\''.$img->id.'\',\''.site_url('administrator/deleteproductimage').'\',\''.site_url('administrator/editproduct/'.encoding($userdata->id)).'\')"> <i class="fa fa-trash" aria-hidden="true"></i></span>
                </div>
                ';
            } 
        };
        ?>

    </div>
</div>

<div class="form-group">
    <label for="gallery" class="col-sm-2 control-label">Gallery</label>
    <div class="col-sm-10">
        <input type="file" class="form-control" name="gallery[]" id="gallery" multiple >
        <p><small>Select multiple files.</small></p>
    </div>
</div>



<?php 
//print_r($userdata);die;
$files=$userdata->files;
if(!empty($files)){ $filearr=unserialize($files);  ?>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">Old Document</label>
        <div class="col-sm-10">
		<?php
        if(!empty($filearr)){
          foreach($filearr as $file){ ?>
        
        <div class="col-sm-2" id="">
		<input type="hidden" class="form-control" name="old_doc_name[]" value="<?php echo $file['doc_name'];  ?>" id="doc_name">
        <input type="hidden" class="form-control" name="old_doc_files[]" value="<?php echo $file['document'];  ?>" id="doc_files">
                <a target="_blank" href="<?php echo BASEURL.'uploads/files/'.$file['document']; ?>"><img src="<?php echo BASEURL.'uploads/download.png';  ?>" class="img-responsive img-circle"></a>
				<p class="text-center"><span><?php echo $file['doc_name'];  ?></span></p>
				<p class="text-center"><span class="text-danger" style="cursor:pointer" onclick="return deletedocument('<?php echo $file['doc_name'];  ?>','<?php echo $file['document'];  ?>','<?php echo encoding($userdata->id) ?>','<?php echo site_url('administrator/deleteproductdoc') ?>','<?php echo site_url('administrator/editproduct/'.encoding($userdata->id)) ?>',this)"> <i class="fa fa-trash" aria-hidden="true"></i></span></p>
        </div>
        <?php }
        } ?>
        </div>
    </div>
<?php } ?>


<div class="form-group">
    <label for="files" class="col-sm-2 control-label">Document</label>
    <div class="col-sm-10">
	<!-------
        <input type="text" class="form-control" name="doc_name" id="doc_name" value="<?php echo $userdata->doc_name;?>"><br/><br/>
        <textarea class="form-control timymce_editor" name="doc_description" id="timymce_editor"><?php echo $userdata->doc_description;?></textarea><br/><br/>
		------------>
        <input type="button" id="add_more" value="+Add More Docs"><br/><br/>
		<input type="text" class="form-control" name="doc_name[]" id="doc_name" placeholder="Document Name">
        <input type="file" class="form-control" name="doc_files[]" id="doc_files">
		
        <p><small><b>Supported type of document doc,docx,html,xls,xlsx,pdf.</b></small></p>
        <div id="add_docs">
           
        </div>
    </div>
</div>

<div class="form-group">
    <label for="files" class="col-sm-2 control-label">Video</label>

    <div class="col-sm-10">
        <input type="text" class="form-control" name="videos" id="videos" value="<?php echo $userdata->videos; ?>">
        <!-- <input type="file" class="form-control" name="videos" id="videos">
        <input type="hidden" name="old_videos" value="<?php echo $userdata->videos; ?>">
        <p><small><b>Support only two type of video mp4,webm.</b></small></p> -->
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
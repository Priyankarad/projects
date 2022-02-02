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
            <li class="active">Add Product</li>
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
                    <h3 class="box-title">Add Product</h3>
                </div>
                <form class="form-horizontal" action="<?php echo site_url('administrator/insertproduct') ?>" method="post" onsubmit="return addProductValidation()" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="Product" class="col-sm-2 control-label">Product</label>
                        <div class="col-sm-10">
                            <input type="text" name="product" class="form-control" id="Product" placeholder="Product">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Category" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10">
                            <?php if(!empty($category)){ foreach($category as $cat){ ?>
                                <div class="col-sm-3">
                                    <input type="checkbox" name="category[]" id="Category"  value="<?php echo $cat->id; ?>"><?php echo $cat->category; ?>
                                </div>
                            <?php } } ?>

</div>
</div>
<div class="form-group">
    <label for="market" class="col-sm-2 control-label">Market</label>
    <div class="col-sm-10">
        <?php if(!empty($market)){ foreach($market as $mark){ ?>
            <div class="col-sm-3">
                <input type="checkbox" name="market[]" id="market"  value="<?php echo $mark->id; ?>"><?php echo $mark->name; ?>
            </div>
        <?php } } ?>

</div>
</div>
<div class="form-group">
    <label for="standard" class="col-sm-2 control-label">Standard</label>
    <div class="col-sm-10">
        <?php if(!empty($standard)){ foreach($standard as $stan){ ?>
            <div class="col-sm-3">
                <input type="checkbox" name="standard[]" id="standard"  value="<?php echo $stan->id; ?>"><?php echo $stan->name; ?>
            </div>
        <?php } } ?>
    </div>
</div>
<div class="form-group">
    <label for="manufacture" class="col-sm-2 control-label">Manufacture</label>
    <div class="col-sm-10">
        <input type="text" name="manufacture"  class="form-control"  id="manufacture" placeholder="Manufacture">
    </div>
</div>

<div class="form-group">
    <label for="Price" class="col-sm-2 control-label">Price</label>
    <div class="col-sm-10">
        <input type="text" name="price"  class="form-control" id="Price" required placeholder="Price">
    </div>
</div>
<div class="form-group">
    <label for="Price" class="col-sm-2 control-label">Request Quote</label>
    <div class="col-sm-10">
        <input type="checkbox" name="quote"  value="1" id="quote" placeholder="Quote">
    </div>
</div>

<div class="form-group">
    <label for="Price" class="col-sm-2 control-label">Partner</label>
    <div class="col-sm-10">
        <select id="partner" name="partners[]" multiple="" class="form-control">
            <option value="">Select Partner</option>
            <?php 
            if(!empty($partners)){
                foreach($partners as $partner){ ?>
                    <option value="<?php echo $partner->id;?>"><?php echo $partner->title;?></option>
                <?php }
            }
            ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label for="Images" class="col-sm-2 control-label">Image</label>
    <div class="col-sm-10">
        <input type="file" class="form-control" name="image" id="Images" required>
    </div>
</div>
<div class="form-group">
    <label for="Description" class="col-sm-2 control-label">Small Description</label>
    <div class="col-sm-10">
        <textarea class="form-control" name="description" id="Description" ></textarea>
    </div>
</div>
<div class="form-group">
    <label for="timymce_editor" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        <textarea class="form-control timymce_editor" id="timymce_editor" name="full_description"></textarea>
    </div>
</div>
<div class="form-group">
    <label for="gallery" class="col-sm-2 control-label">Gallery</label>
    <div class="col-sm-10">
        <input type="file" class="form-control" name="gallery[]" id="gallery" multiple >
    </div>
</div>

<div class="form-group">
    <label for="files" class="col-sm-2 control-label">Document</label>
    <div class="col-sm-10">
	    <!--------
        <input type="text" class="form-control" name="doc_name" id="doc_name"><br/><br/>
        <textarea class="form-control timymce_editor" name="doc_description" id="timymce_editor"></textarea><br/><br/>
		 --------->
        <input type="button" id="add_more" value="+Add More Docs"><br/><br/>
		
		<input type="text" class="form-control" name="doc_name[]" id="doc_name" placeholder="Document Name">
        <input type="file" class="form-control" name="doc_files[]" id="doc_files" required>
		
        <p><small><b>Supported type of document doc,docx,html,xls,xlsx,pdf.</b></small></p>
        <div id="add_docs">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="files" class="col-sm-2 control-label">Video</label>

    <div class="col-sm-10">
        <input type="text" class="form-control" name="videos" id="videos">
        <!-- <input type="file" class="form-control" name="videos" id="videos"> -->
        <!-- <p><small><b>Support only two type of video mp4,webm.</b></small></p> -->
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
<?php include('header.php'); 

$id = $_REQUEST['id'];
$mode = $_REQUEST['mode'];

$getdet = "SELECT PG.*, ML.image_path FROM ".TABLE_PREFIX."pages AS PG LEFT JOIN ".TABLE_PREFIX."media_library AS ML ON ML.id = PG.media_id WHERE PG.id = '".$id."'";
$getdet = mysqli_query($con,$getdet) or die(mysqli_error());
$rowdet = mysqli_fetch_array($getdet);

if(isset($_POST['doedit']) && $_POST['doedit'] != "")
{
	
	//echo '<pre>'; print_r($_POST); exit;
	
	$updateQry = "UPDATE ".TABLE_PREFIX."pages SET
				  media_id = '".$_POST['media_id']."',
				  page_slug = '".$_POST['page_slug']."'
				  WHERE id = '".$id."'";
				  
	mysqli_query($con,$updateQry) or die(mysqli_error());
	
	
	$getLanguages = "SELECT * FROM ".TABLE_PREFIX."languages WHERE flag = '1'";
	$getLanguages = mysqli_query($con,$getLanguages) or die(mysqli_error());
	
	while($rowlang = mysqli_fetch_array($getLanguages)){
		
		$language_id = $rowlang['id'];
		$page_id = $id;
		
		$checkexists = "SELECT * FROM ".TABLE_PREFIX."page_content WHERE page_id = '".$page_id."' AND language_id = '".$language_id."'";
		$checkexists = mysqli_query($con,$checkexists) or die(mysqli_error());
		$checkexists = mysqli_num_rows($checkexists);
		
		$page_title = $_POST['page_title'][$language_id];
		$page_desc = $_POST['page_desc'][$language_id];
		
		if($checkexists){
			
			$updateQry = "UPDATE ".TABLE_PREFIX."page_content SET
						  page_title = '".addslashes($page_title)."',
						  page_desc = '".addslashes($page_desc)."'
						  WHERE page_id = '".$page_id."' AND language_id = '".$language_id."'";
						  
			mysqli_query($con,$updateQry) or die(mysqli_error());
		}
		else{
			
			$updateQry = "INSERT INTO ".TABLE_PREFIX."page_content SET
						  page_title = '".addslashes($page_title)."',
						  page_desc = '".addslashes($page_desc)."',
						  page_id = '".$page_id."',
						  language_id = '".$language_id."'";
						  
			mysqli_query($con,$updateQry) or die(mysqli_error());
		}
	}
	
	header('location:pages.php?action=updated');
}
?>

<div class="wrapper row-offcanvas row-offcanvas-left">

  <!-- Left side column. contains the logo and sidebar -->
  <?php include('leftpanel.php'); ?>
  
  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="glyphicon glyphicon-list-alt"></i> <?=$title?> ( <?php echo(utf8_encode($rowdet['page_name'])); ?> ) </h1>
	  
      <?php include('breadcrumb.php'); ?>
	  
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
	  
	  <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12">
		  
		  <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" role="form" id="frmpage" onsubmit="return valcheck();">
		  <input type="hidden" name="do<?=$mode?>" value="yes" />
	      <input type="hidden" name="id" value="<?=$id?>" />
	      <input type="hidden" name="media_id" value="<?php echo($rowdet['media_id']); ?>" />
		  
		  <?php
		  if($rowdet['type'] == 'banner' || $rowdet['type'] == 'page'){
		  ?>
		  <!-- Chat box -->
		  <div class="box box-success">
			
			<div class="box-header"> 
			  <h3 class="box-title">Choose Image <?php echo($rowdet['type'] != 'banner' ? '(Optional)' : ''); ?></h3>
			</div>
			<div class="box-body">
				
				<div class="form-group">
					<button class="btn btn-danger" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Choose</button>
				</div>
				
				<div class="form-group">
					
					<?php
					$display = isset($mode) && $mode == 'edit' && !empty($rowdet['image_path']) ? 'block' : 'none';						
					$image = isset($mode) && $mode == 'edit' && !empty($rowdet['image_path']) ? ADMIN_URL.'userfiles/'.stripslashes($rowdet['image_path']) : '';						
					?>
					
					<div><img src="<?php echo($image); ?>" style="width:300px; display:<?php echo($display); ?>" id="chosenimage"></div>
				</div>
				
				<?php
				if($rowdet['type'] == 'banner'){
				?>
				<div class="form-group">
					<p style="color:#ff0000">* Banner dimension must be of <?php echo($config['banner_width']); ?> X <?php echo($config['banner_height']); ?> pixels.</p>
				</div>
				<?php
				}
				?>
				
			</div>
			<!-- /.chat -->
			
		  </div>
		  <!-- /.box (chat box) -->
		  <?php
		  }
		  ?>
		  
		  <?php
		  if($rowdet['type'] == 'page'){
		  ?>
		  <!-- Chat box -->
		  <div class="box box-success">
			
			<div class="box-header"> 
			  <h3 class="box-title">Page Slug</h3>
			</div>
			<div class="box-body">
				
				<div class="form-group">
					<input type="text" class="form-control" required placeholder="Page Slug" id="page_slug" name="page_slug" value="<?php echo stripslashes($rowdet['page_slug']); ?>" />
				</div>
				
			</div>
			<!-- /.chat -->
			
		  </div>
		  <!-- /.box (chat box) -->
		  <?php
		  }
		  ?>
		  
		  
		  <?php
		  if($rowdet['type'] == 'page' || $rowdet['type'] == 'content'){
		  
			  $getLanguages = "SELECT * FROM ".TABLE_PREFIX."languages WHERE flag = '1'";
			  $getLanguages = mysqli_query($con,$getLanguages) or die(mysqli_error());

			  while($rowlang = mysqli_fetch_array($getLanguages)){
				  
					$getPageContent = "SELECT * FROM ".TABLE_PREFIX."page_content WHERE page_id = '".$id."' AND language_id = '".$rowlang['id']."'";
					$getPageContent = mysqli_query($con,$getPageContent) or die(mysqli_error());
					$getPageContent = mysqli_fetch_assoc($getPageContent);

					$page_title = trim(stripslashes($getPageContent['page_title']));
					$page_desc = trim(stripslashes($getPageContent['page_desc']));
				  ?>
				  
				  <!-- Chat box -->
				  <div class="box box-success">
					
					<div class="box-header"> 
					  <h3 class="box-title">Content for <?php echo(ucfirst(stripslashes($rowlang['language']))); ?></h3>
					</div>
					<div class="box-body">
						
						<div class="form-group">
							<label>Page Title</label>
							<input type="text" class="form-control" placeholder="Page Title" name="page_title[<?php echo($rowlang['id']); ?>]" required value="<?php echo stripslashes($page_title); ?>" />
						</div>
						
						<div class="form-group">
							<label>Page Description</label>
							<textarea name="page_desc[<?php echo($rowlang['id']); ?>]" class="ckeditor" required rows="50" cols="80"><?=stripslashes($page_desc)?></textarea>
						</div>
						
					</div>
					<!-- /.chat -->
					
				  </div>
				  <!-- /.box (chat box) -->
				  
				  <?php
			  }
		  }
		  ?>
		  
		  <div class="box-footer"> 
			<button class="btn btn-primary" type="submit">Update</button>
			<button class="btn btn-primary" type="button" onClick="location.href='pages.php'">Cancel</button>
		  </div>
		  
		  
		  </form>
		  
        </section>
        <!-- /.Left col -->
      </div>
      <!-- /.row (main row) -->
	  
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
  
</div>
<!-- ./wrapper -->

<?php include('commonjs.php'); ?>

<!-- CK Editor -->
<script src="js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	/* CKEDITOR.replace('page_desc',{
		height: 300	
	}); */
	
	CKEDITOR.config.toolbar = [
	   ['Bold','Italic','Underline'],
	   ['NumberedList','BulletedList'],
	   ['Image'],
	   ['Source']
	] ;
});

$('#page_slug').on('keyup',function(){
	
	var val = $(this).val();
	val = val.replace(/[^\w\s-]/gi, '');
	val = val.replace(/\s+/g, '-').toLowerCase();
	$(this).val(val);
});

stringToReplace.replace(/[^\w\s]/gi, '')

function valcheck(){
	
	<?php
	if($rowdet['type'] != 'banner'){
		
		?>
		return true;
		<?php
	}
	else{
		
		?>
		var image = $('#chosenimage').attr('src');
	
		if(image == '' || image == undefined){
			
			alert('Choose image from media library');
		}
		else{
			
			var myImage = new Image();
			myImage.src = image;
			
			var imagewidth = myImage.width;
			var imageheight = myImage.height;
			
			//alert(imagewidth);
			//alert(imageheight);
			
			if(imagewidth == '<?php echo($config['banner_width']); ?>' && imageheight == '<?php echo($config['banner_height']); ?>'){
				
				return true;
			}
			else{
				
				alert('Banner dimension mismatch');
			}
		}
		
		return false;
		<?php
	}
	?>
}

</script>

<?php include('footer.php'); ?>
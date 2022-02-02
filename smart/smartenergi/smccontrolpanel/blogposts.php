<?php include('header.php'); 

$id = $_REQUEST['id'];
$mode = $_REQUEST['mode'];

$getdet = "SELECT BP.*, ML.image_path FROM ".TABLE_PREFIX."blog_posts AS BP LEFT JOIN ".TABLE_PREFIX."media_library AS ML ON ML.id = BP.media_id WHERE BP.id = '".$id."' and ML.status=0";
$getdet = mysqli_query($con,$getdet) or die(mysqli_error());
$rowdet = mysqli_fetch_array($getdet);

if(isset($_POST['doadd']) && $_POST['doadd'] != "")
{
	$blog_slug = clean($_POST['blog_title'][1]);
	
	$updateQry = "INSERT INTO ".TABLE_PREFIX."blog_posts SET
				  blog_slug = '".$blog_slug."',
				  media_id = '".$_POST['media_id']."',
				  createdate = '".time()."'";
				  
	mysqli_query($con,$updateQry) or die(mysqli_error());
	
	$blog_id = mysqli_insert_id();
	
	$getLanguages = "SELECT * FROM ".TABLE_PREFIX."languages WHERE flag = '1'";
	$getLanguages = mysqli_query($con,$getLanguages) or die(mysqli_error());
	
	while($rowlang = mysqli_fetch_array($getLanguages)){
		
		$language_id = $rowlang['id'];
		
		$blog_title = $_POST['blog_title'][$language_id];
		$blog_desc = $_POST['blog_desc'][$language_id];
		
		$updateQry = "INSERT INTO ".TABLE_PREFIX."blog_contents SET
					  blog_title = '".addslashes($blog_title)."',
					  blog_desc = '".addslashes($blog_desc)."',
					  blog_id = '".$blog_id."',
					  language_id = '".$language_id."'";
					  
		mysqli_query($con,$updateQry) or die(mysqli_error());
	}
	
	header('location:'.$pagenav.'.php?action=added');
}

if(isset($_POST['doedit']) && $_POST['doedit'] != "")
{
	$blog_slug = clean($_POST['blog_title'][1]);
	
	if($_POST['is_featured'] == 'Yes'){
		
		$updateQry = "UPDATE ".TABLE_PREFIX."blog_posts SET
				  is_featured = 'No'";
				  
		mysqli_query($con,$updateQry) or die(mysqli_error());
	}	
	
	$updateQry = "UPDATE ".TABLE_PREFIX."blog_posts SET
				  blog_slug = '".$blog_slug."',
				  media_id = '".$_POST['media_id']."',
				  is_featured = '".$_POST['is_featured']."',
				  flag = '".$_POST['flag']."'
				  WHERE id = '".$id."'";
				  
	mysqli_query($con,$updateQry) or die(mysqli_error());
	
	$getLanguages = "SELECT * FROM ".TABLE_PREFIX."languages WHERE flag = '1'";
	$getLanguages = mysqli_query($con,$getLanguages) or die(mysqli_error());
	
	while($rowlang = mysqli_fetch_array($getLanguages)){
		
		$language_id = $rowlang['id'];
		
		$checkexists = "SELECT * FROM ".TABLE_PREFIX."blog_contents WHERE blog_id = '".$id."' AND language_id = '".$language_id."'";
		$checkexists = mysqli_query($con,$checkexists) or die(mysqli_error());
		$checkexists = mysqli_num_rows($checkexists);
		
		$blog_title = $_POST['blog_title'][$language_id];
		$blog_desc = $_POST['blog_desc'][$language_id];
		
		if($checkexists){
			
			$updateQry = "UPDATE ".TABLE_PREFIX."blog_contents SET
						  blog_title = '".addslashes($blog_title)."',
						  blog_desc = '".addslashes($blog_desc)."'
						  WHERE blog_id = '".$id."' AND language_id = '".$language_id."'";
						  
			mysqli_query($con,$updateQry) or die(mysqli_error());
		}
		else{
			
			$updateQry = "INSERT INTO ".TABLE_PREFIX."blog_contents SET
						  blog_title = '".addslashes($blog_title)."',
						  blog_desc = '".addslashes($blog_desc)."',
						  blog_id = '".$id."',
						  language_id = '".$language_id."'";
						  
			mysqli_query($con,$updateQry) or die(mysqli_error());
		}
	}
	
	header('location:'.$pagenav.'.php?action=updated');
}

if(isset($_POST['mode']) && $_POST['mode'] == "delsel")
{
	$getids = $_POST['chk_id'];
	
	foreach($getids as $valids)
	{
		$del = "DELETE FROM ".TABLE_PREFIX."blog_posts WHERE id = '".$valids."'";
		mysqli_query($con,$del) or die(mysqli_error());
	}
	
	header('location:'.$pagenav.'.php?action=deleted');
}

if(isset($_POST['mode']) && $_POST['mode'] == "del")
{
	$del = "DELETE FROM ".TABLE_PREFIX."blog_posts WHERE id = '".$id."'";
	mysqli_query($con,$del) or die(mysqli_error());
	
	header('location:'.$pagenav.'.php?action=deleted');
}
?>

<div class="wrapper row-offcanvas row-offcanvas-left">

  <!-- Left side column. contains the logo and sidebar -->
  <?php include('leftpanel.php'); ?>
  
  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="glyphicon glyphicon-pencil"></i> <?=$title?> </h1>
	  
      <?php include('breadcrumb.php'); ?>
	  
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
	  
	  <?php
	  if($mode == ''){
		  
		  ?>
		  <!-- Main row -->
		  <div class="row">
			<!-- Left col -->
			<section class="col-lg-12">
			  
				
				<?php
				if($_REQUEST['action']=='updated'){
				?>
				<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?=$title?> Updated
				</div>
				<?php
				}
				if($_REQUEST['action']=='added'){
				?>
				<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?=$title?> Added
				</div>
				<?php
				}
				if($_REQUEST['action']=='deleted'){
				?>
				<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?=$title?> Deleted
				</div>
				<?php
				}
				?>
			  
			  
			  <button type="button" class="btn btn-danger btn-sm" onclick="delsel()"><i class='glyphicon glyphicon-trash'></i> Delete Selected</button>
			  <button type="button" class="btn btn-primary btn-sm" onclick="location.href = '<?php echo($_SERVER['PHP_SELF'].'?mode=add'); ?>'"><i class='glyphicon glyphicon-plus'></i> Add</button>
			  
			  <br><br>
			  
			  <!-- Chat box -->
			  <div class="box box-success">
				
				<form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" name="frmlisting">
				<input type="hidden" name="mode" value="" />
				<input type="hidden" name="id" value="" />
				
				<div class="box-header"> 
				  
				  
				  
				</div>
				<div class="box-body table-responsive">
					
					<table id="example1" class="table table-bordered table-striped table-mailbox">
					<thead>
					  <tr>	
						<th><input type="checkbox" value="" id="check-all" ></th>
						<th>Sl No.</th>
						<th>Blog Title</th>
						<th>Posted On</th>
						<th>Featured</th>
						<th>Active</th>
						<th>Actions</th>
					  </tr>
					</thead>
					<tbody>
					  
					  <?php
						$sl = 1;
						
						$getDefaultLang = "SELECT id FROM ".TABLE_PREFIX."languages WHERE is_default = '1'";
						
						$getrows = "SELECT BP.*, BC.blog_title, BC.blog_desc FROM ".TABLE_PREFIX."blog_posts AS BP LEFT JOIN ".TABLE_PREFIX."blog_contents AS BC ON BC.blog_id = BP.id  WHERE BC.language_id = (".$getDefaultLang.") ORDER BY id DESC";
								   
						$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
						while($row = mysqli_fetch_array($getrows)){
							
							?>
							
							<tr >
								<td class="center"><input type="checkbox" value="<?=$row['id']?>" name="chk_id[]"></td>
								<td class="center"><?=$sl?></td>
								<td class="center"><?=stripslashes($row['blog_title'])?></td>
								<td class="center"><?=date('dS M Y',stripslashes($row['createdate']))?></td>
								<td class="center"><?=$row['is_featured'] == 'No' ? 'No' : 'Yes'?></td>
								<td class="center"><?=$row['flag'] == '0' ? 'No' : 'Yes'?></td>
								<td class="center">
									<div class="btn-group">
										<button type="button" class="btn btn-warning btn-sm" onclick="location.href='<?php echo($_SERVER['PHP_SELF'].'?mode=edit&id='.$row['id']); ?>'"><i class='glyphicon glyphicon-edit'></i> Edit</button>
										<button type="button" class="btn btn-danger btn-sm" onclick="del('<?=$row['id']?>')"><i class='glyphicon glyphicon-trash'></i> Delete</button>
									</div>
								</td>
							</tr>
							
							<?php
							$sl++;
						}
						?>
							
					  
					</tbody>
				  </table>
					
				</div>
				<!-- /.chat -->
				
				</form>
				
			  </div>
			  <!-- /.box (chat box) -->
			  
			</section>
			<!-- /.Left col -->
		  </div>
		  <!-- /.row (main row) -->
		  <?php		  
	  }
	  else{
		  
		  ?>
		  <!-- Main row -->
		  <div class="row">
			<!-- Left col -->
			<section class="col-lg-12">
			  
				<form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" role="form" id="frmpage">
				<input type="hidden" name="do<?=$mode?>" value="yes" />
				<input type="hidden" name="id" value="<?=$id?>" />
				<input type="hidden" name="media_id" value="<?php echo($rowdet['media_id']); ?>" />
				  
				  <!-- Chat box -->
				  <div class="box box-success">
					
					<div class="box-header"> 
					  <h3 class="box-title">Choose Image (Optional)</h3>
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
						
					</div>
					<!-- /.chat -->
					
				  </div>
				  <!-- /.box (chat box) -->
				  
				  <?php
				  $getLanguages = "SELECT * FROM ".TABLE_PREFIX."languages WHERE flag = '1'";
				  $getLanguages = mysqli_query($con,$getLanguages) or die(mysqli_error());

				  while($rowlang = mysqli_fetch_array($getLanguages)){
					  
						$getBlogContent = "SELECT * FROM ".TABLE_PREFIX."blog_contents WHERE blog_id = '".$id."' AND language_id = '".$rowlang['id']."'";
						$getBlogContent = mysqli_query($con,$getBlogContent) or die(mysqli_error());
						$getBlogContent = mysqli_fetch_assoc($getBlogContent);

						$blog_title = trim(stripslashes($getBlogContent['blog_title']));
						$blog_desc = trim(stripslashes($getBlogContent['blog_desc']));
					  ?>
					  
					  <!-- Chat box -->
					  <div class="box box-success">
						
						<div class="box-header"> 
						  <h3 class="box-title">Content for <?php echo(ucfirst(stripslashes($rowlang['language']))); ?></h3>
						</div>
						<div class="box-body">
							
							<div class="form-group">
								<label>Blog Title</label>
								<input type="text" class="form-control" placeholder="Blog Title" name="blog_title[<?php echo($rowlang['id']); ?>]" required value="<?php echo stripslashes($blog_title); ?>" />
							</div>
							
							<div class="form-group">
								<label>Blog Description</label>
								<textarea name="blog_desc[<?php echo($rowlang['id']); ?>]" class="ckeditor" required rows="50" cols="80"><?=stripslashes($blog_desc)?></textarea>
							</div>
							
						</div>
						<!-- /.chat -->
						
					  </div>
					  <!-- /.box (chat box) -->
					  
					  <?php
				  }
				  ?>
				 

				 <?php
				 if($mode == 'edit'){
				 ?>
				 <!-- Chat box -->
				  <div class="box box-success">
					
					<div class="box-body">
						
						<div class="form-group">
							<label>Featured</label><br>
							
							<input type="radio" class="form-control" name="is_featured" value="Yes" required <?php echo($rowdet['is_featured'] == 'Yes' ? 'checked' : ''); ?> />&nbsp;Yes&nbsp;&nbsp;						
							<input type="radio" class="form-control" name="is_featured" value="No" required <?php echo($rowdet['is_featured'] == 'No' ? 'checked' : ''); ?> />&nbsp;No&nbsp;&nbsp;	
							
						</div>
						
					</div>
					<!-- /.chat -->
					
				  </div>
				  <!-- /.box (chat box) -->
				  
				  <!-- Chat box -->
				  <div class="box box-success">
					
					<div class="box-body">
						
						<div class="form-group">
							<label>Active</label><br>
							
							<input type="radio" class="form-control" name="flag" value="1" required <?php echo($rowdet['flag'] == '1' ? 'checked' : ''); ?> />&nbsp;Yes&nbsp;&nbsp;						
							<input type="radio" class="form-control" name="flag" value="0" required <?php echo($rowdet['flag'] == '0' ? 'checked' : ''); ?> />&nbsp;No&nbsp;&nbsp;	
							
						</div>
						
					</div>
					<!-- /.chat -->
					
				  </div>
				  <!-- /.box (chat box) -->
				  
				 <?php } ?>
				
				<div class="box-footer"> 
				  <button class="btn btn-primary" type="submit"><?php echo($mode == 'add' ? 'Add' : 'Update'); ?></button>
				  <button class="btn btn-primary" type="button" onClick="history.back(-1)">&laquo;&nbsp;Back</button>
				</div>
				
				</form>
				
			  </div>
			  <!-- /.box (chat box) -->
			  
			</section>
			<!-- /.Left col -->
		  </div>
		  <!-- /.row (main row) -->
		  <?php
	  }
	  ?>	  
	  
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
	   ['Source']
	] ;
});
</script>

<?php include('footer.php'); ?>
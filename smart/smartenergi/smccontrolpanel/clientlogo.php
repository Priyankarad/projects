<?php include('header.php'); 

$id = $_REQUEST['id'];
$mode = $_REQUEST['mode'];

$getdet = "SELECT * FROM ".TABLE_PREFIX."media_library WHERE id = '".$id."'";
$getdet = mysqli_query($con,$getdet) or die(mysqli_error());
$rowdet = mysqli_fetch_array($getdet);
$image_path=explode(" |",$rowdet['image_path']);
if(isset($_POST['doadd']) && $_POST['doadd'] != "")
{
	
	$filePathString="";
	for($i=0;$i<count($_FILES["imagefile"]["name"]);$i++)
	{

		$fileName = $_FILES['imagefile']['name'][$i];
		$fileExt = end(explode(".",$fileName));
		$filePath = time().$i.'.'.$fileExt;
		$fileUploadPath = 'userfiles/'.$filePath;
		
		if(!empty($fileName)){
			//unlink('userfiles/'.$rowdet['image_path']);
			$tmp_name = $_FILES['imagefile']['tmp_name'][$i];
			move_uploaded_file($tmp_name, $fileUploadPath);
			$filePathString .= $filePath." | ";
		}
	
	}
	
	$filePathString = trim(rtrim($filePathString," | "));
	
	$update = "INSERT INTO ".TABLE_PREFIX."media_library SET
			   image_title = '".addslashes($_POST['image_title'])."',
			   image_path = '".addslashes($filePathString)."',
			   createdate = '".time()."',
			   status=1";
			   
	mysqli_query($con,$update) or die(mysqli_error());
	
	header('location:'.$pagenav.'.php?action=added');
}

if(isset($_POST['doedit']) && $_POST['doedit'] != "")
{
	$j=0;
	if(isset($_POST['hiddenFiles']) && !empty($_POST['hiddenFiles'])){
		$j =count(explode(" |", $_POST['hiddenFiles']));
	};
	
	$filePathString="";
	for($i=0;$i<count($_FILES["imagefile"]["name"]);$i++)
	{
		$fileName = $_FILES['imagefile']['name'][$i];
		$fileExt = end(explode(".",$fileName));
		$filePath = time().$j.'.'.$fileExt;
		$fileUploadPath = 'userfiles/'.$filePath;
		
		if(!empty($fileName)){
			//unlink('userfiles/'.$rowdet['image_path']);
			$tmp_name = $_FILES['imagefile']['tmp_name'][$i];
			move_uploaded_file($tmp_name, $fileUploadPath);
			$filePathString .= $filePath." | ";
		}
		$j++;
	}
	
	$filePathString = trim(rtrim($filePathString," | "));
	//echo $filePathString."<br/>";
	if(isset($_POST['hiddenFiles']) && !empty($_POST['hiddenFiles'])){
		if($filePathString!="")
			$filePathString =$filePathString." | ";
		$filePathString =$filePathString.$_POST['hiddenFiles'];
	};
//echo $_POST['hiddenFiles']."<br/>";
	$update = "UPDATE ".TABLE_PREFIX."media_library SET
			   image_path = '".addslashes($filePathString)."'
			   WHERE id = '".$id."'";

//echo $filePathString."<br/>";		   
	mysqli_query($con,$update) or die(mysqli_error());
	//die();	
	header('location:'.$pagenav.'.php?action=updated');
}

if(isset($_POST['mode']) && $_POST['mode'] == "delsel")
{
	$getids = $_POST['chk_id'];
	foreach($getids as $valids)
	{
		$getdet = "SELECT * FROM ".TABLE_PREFIX."media_library WHERE id = '".$valids."'";
		$getdet = mysqli_query($con,$getdet) or die(mysqli_error());
		$rowdet = mysqli_fetch_array($getdet);
		
		unlink('userfiles/'.$rowdet['image_path']);
		
		$del = "DELETE FROM ".TABLE_PREFIX."media_library WHERE id = '".$valids."'";
		mysqli_query($con,$del) or die(mysqli_error());
	}
	header('location:'.$pagenav.'.php?action=deleted');
}

if(isset($_POST['mode']) && $_POST['mode'] == "del")
{
	unlink('userfiles/'.$rowdet['image_path']);
	$del = "DELETE FROM ".TABLE_PREFIX."media_library WHERE id = '".$id."'";
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
      <h1> <i class="glyphicon glyphicon-picture"></i> <?=$title?> </h1>
	  
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
						<th>Title</th>
						<th>Image</th>
						<th>link</th>
						<th>Uploaded On</th>
						<th>Actions</th>
					  </tr>
					</thead>
					<tbody>
					  
					  <?php
						$sl = 1;
						$getrows = "SELECT * FROM ".TABLE_PREFIX."media_library where status=1 ORDER BY id DESC";
								   
						$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
						while($row = mysqli_fetch_array($getrows)){
							
							$link = ADMIN_URL.'userfiles/'.stripslashes($row['image_path']);
							?>
							
							<tr >
								<td class="center"><input type="checkbox" value="<?=$row['id']?>" name="chk_id[]"></td>
								<td class="center"><?=$sl?></td>
								<td class="center"><?=stripslashes($row['image_title'])?></td>
								<td class="center"><img src="<?php echo($link); ?>" style="width:200px;"></td>
								<td class="center"><?=$link?></td>
								<td class="center"><?=date('dS M Y',stripslashes($row['createdate']))?></td>
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
			  
			  <!-- Chat box -->
			  <div class="box box-success">
				
				<form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" role="form">
				<input type="hidden" name="do<?=$mode?>" value="yes" />
				<input type="hidden" name="id" value="<?=$id?>" />
				
				<div class="box-header"> 
				  
				</div>
				<div class="box-body">
					
					<div class="form-group">
						<label>Image Title</label>
						<input disabled="" type="text" class="form-control" placeholder="Image Title" name="image_title" id="image_title" value="<?php echo stripslashes($rowdet['image_title']); ?>" required />
					</div>
					<div class="form-group">
					<div class="images_fsta">
					<div class="mnDiv">
						<?php
					if($mode == 'edit'){
						$previousimages="";
						foreach($image_path as $path){
						$previousimages .=trim($path)." | ";
						?>
						
					<div class="s">
							<img imageVal="<?=trim($path)?>" class="imageThumb" src="<?php echo(ADMIN_URL.'userfiles/'.trim($path)); ?>"/>
							<span onclick="remove(this)"><i class="fa fa-close"></i></span>
						</div>
						<?php
					  }
					}
					?>
<input type="hidden" class="hiddenFiles" name="hiddenFiles" value="<?=rtrim($previousimages," |");?>"/>
						<div class="img_div"></div>
						<label class="upld_lbl">
						<label>Add Images</label>
						<input class="files" name="imagefile[]" accept=".png, .jpg, .jpeg, .gif" type="file" multiple="">
						</label>
					</div>
</div>
		</div>

					
				</div>
				<!-- /.chat -->
				
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

<?php include('footer.php'); ?>
<script>
if(window.File && window.FileList && window.FileReader) {
	jQuery(".files").on("change",function(e) {
			_this = jQuery(this);
			jQuery('.alrdy_pic > img').hide();
			var files = e.target.files ,
			filesLength = files.length ;
			
				for (var i = 0; i <= filesLength ; i++) {
					var f = files[i]
					var fileReader = new FileReader();
					fileReader.onload = (function(e) {
						var file = e.target;
						htmlele = "<div class='s'><img class='imageThumb' src='"+e.target.result+"' title='"+file.name+ "'></img><span onclick=remove(this)><i class='fa fa-close'></i></span></div>"; 
						_this.closest(".mnDiv").find(".img_div").before(htmlele);

						
					});
					fileReader.readAsDataURL(f);
				}
				
	});
}
function remove(r) {

	_this = jQuery(r);
	var attr = _this.prev().attr('imageval');
	if (typeof attr !== typeof undefined && attr !== false) {
		var hiddenFiles=$.trim($('.hiddenFiles').val());
		
		if(hiddenFiles.includes(_this.prev().attr('imageval'))){
			console.log(hiddenFiles);
		hiddenFiles = $.trim(hiddenFiles.replace(_this.prev().attr('imageval')+" | ", ''));
			hiddenFiles = $.trim(hiddenFiles.replace(_this.prev().attr('imageval'), ''));
			if(hiddenFiles.substr(-1)=="|"){
				hiddenFiles=hiddenFiles.slice(0, -1);
			}
			console.log(hiddenFiles);
			if(hiddenFiles.substr(0,1)=="|"){
				hiddenFiles = hiddenFiles.substr(1);
				//hiddenFiles=hiddenFiles.slice(0,1);
			}
			
			$('.hiddenFiles').val(hiddenFiles);
		}
		
		//_this.contains('Money').remove();​
	}
	_this.closest(".s").remove();
}
</script>
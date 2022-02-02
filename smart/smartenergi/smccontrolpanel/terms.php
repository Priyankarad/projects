<?php include('header.php'); 

$id = $_REQUEST['id'];
$mode = $_REQUEST['mode'];

$getdet = "SELECT * FROM ".TABLE_PREFIX."terms WHERE id = '".$id."'";
$getdet = mysqli_query($con,$getdet) or die(mysqli_error());
$rowdet = mysqli_fetch_array($getdet);

if(isset($_POST['doadd']) && $_POST['doadd'] != "")
{
	$update = "INSERT INTO ".TABLE_PREFIX."terms SET
			   term = '".addslashes($_POST['term'])."'";
			   
	mysqli_query($con,$update) or die(mysqli_error());
	
	header('location:'.$pagenav.'.php?action=added');
}

if(isset($_POST['doedit']) && $_POST['doedit'] != "")
{
	$update = "UPDATE ".TABLE_PREFIX."terms SET
			   term = '".addslashes($_POST['term'])."',
			   flag = '".addslashes($_POST['flag'])."'
			   WHERE id = '".$id."'";
			   
	mysqli_query($con,$update) or die(mysqli_error());
	
	header('location:'.$pagenav.'.php?action=updated');
}

if(isset($_POST['mode']) && $_POST['mode'] == "delsel")
{
	$getids = $_POST['chk_id'];
	
	foreach($getids as $valids)
	{
		$del = "DELETE FROM ".TABLE_PREFIX."terms WHERE id = '".$valids."'";
		mysqli_query($con,$del) or die(mysqli_error());
	}
	
	header('location:'.$pagenav.'.php?action=deleted');
}

if(isset($_POST['mode']) && $_POST['mode'] == "del")
{
	$del = "DELETE FROM ".TABLE_PREFIX."terms WHERE id = '".$id."'";
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
      <h1> <i class="glyphicon glyphicon-font"></i> <?=$title?> </h1>
	  
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
						<th>Term</th>
						<th>Active</th>
						<th>Actions</th>
					  </tr>
					</thead>
					<tbody>
					  
					  <?php
						$sl = 1;
						$getrows = "SELECT * FROM ".TABLE_PREFIX."terms ORDER BY id DESC";
								   
						$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
						while($row = mysqli_fetch_array($getrows)){
							
							?>
							
							<tr >
								<td class="center"><input type="checkbox" value="<?=$row['id']?>" name="chk_id[]"></td>
								<td class="center"><?=$sl?></td>
								<td class="center" width="60%"><?=stripslashes($row['term'])?></td>
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
			  
			  <!-- Chat box -->
			  <div class="box box-success">
				
				<form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" role="form">
				<input type="hidden" name="do<?=$mode?>" value="yes" />
				<input type="hidden" name="id" value="<?=$id?>" />
				
				<div class="box-header"> 
				  
				</div>
				<div class="box-body">
					
					<div class="form-group">
						<label>Term</label>
						<input type="text" class="form-control" placeholder="Term" name="term" id="term" value="<?php echo stripslashes($rowdet['term']); ?>" required />
					</div>
					
					<?php
					if($mode == 'edit'){
						
						?>
						<div class="form-group">
							<label>Active</label><br>
							
							<input type="radio" class="form-control" name="flag" value="1" required <?php echo($rowdet['flag'] == '1' ? 'checked' : ''); ?> required/>&nbsp;Yes&nbsp;&nbsp;						
							<input type="radio" class="form-control" name="flag" value="0" required <?php echo($rowdet['flag'] == '0' ? 'checked' : ''); ?> required/>&nbsp;No&nbsp;&nbsp;	
							
						</div>
						<?php
					}
					?>
					
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
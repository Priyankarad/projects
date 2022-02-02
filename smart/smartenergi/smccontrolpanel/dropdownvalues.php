<?php include('header.php'); 

$id = $_REQUEST['id'];
$mode = $_REQUEST['mode'];

$getdet = "SELECT * FROM ".TABLE_PREFIX."dropdown_values WHERE id = '".$id."'";
$getdet = mysqli_query($con,$getdet) or die(mysqli_error());
$rowdet = mysqli_fetch_array($getdet);

if(isset($_POST['doadd']) && $_POST['doadd'] != "")
{
	$update = "INSERT INTO ".TABLE_PREFIX."dropdown_values SET
			   value = '".addslashes($_POST['value'])."',
			   type = '".addslashes($_POST['type'])."'";
			   
	mysqli_query($con,$update) or die(mysqli_error());
	
	header('location:'.$pagenav.'.php?action=added');
}

if(isset($_POST['doedit']) && $_POST['doedit'] != "")
{
	$update = "UPDATE ".TABLE_PREFIX."dropdown_values SET
			   value = '".addslashes($_POST['value'])."',
			   type = '".addslashes($_POST['type'])."',
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
		$del = "DELETE FROM ".TABLE_PREFIX."dropdown_values WHERE id = '".$valids."'";
		mysqli_query($con,$del) or die(mysqli_error());
	}
	
	header('location:'.$pagenav.'.php?action=deleted');
}

if(isset($_POST['mode']) && $_POST['mode'] == "del")
{
	$del = "DELETE FROM ".TABLE_PREFIX."dropdown_values WHERE id = '".$id."'";
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
						<th>Value</th>
						<th>Type</th>
						<th>Active</th>
						<th>Actions</th>
					  </tr>
					</thead>
					<tbody>
					  
					  <?php
						$sl = 1;
						$getrows = "SELECT * FROM ".TABLE_PREFIX."dropdown_values ORDER BY id DESC";
								   
						$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
						while($row = mysqli_fetch_array($getrows)){
							
							$typetext = '';
							
							switch($row['type']){
								
								case "employment_type":
									$typetext = 'Employment Type';
									break;
								case "living_status":
									$typetext = 'Living Status';
									break;
								case "marital_status":
									$typetext = 'Marital Status';
									break;
								case "service_type":
									$typetext = 'Service Type';
									break;
								case "security_questions":
									$typetext = 'Security Question';
									break;
								case "merchant_prod_type":
									$typetext = 'Merchant Product Type';
									break;
								case "area_activity_type":
									$typetext='Area Activity Type';
									break;	
							}
							
							?>
							
							<tr >
								<td class="center"><input type="checkbox" value="<?=$row['id']?>" name="chk_id[]"></td>
								<td class="center"><?=$sl?></td>
								<td class="center" width="50%"><?=stripslashes($row['value'])?></td>
								<td class="center"><?=stripslashes($typetext)?></td>
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
						<label>Value</label>
						<input type="text" class="form-control" placeholder="Term" name="value" id="value" value="<?php echo stripslashes($rowdet['value']); ?>" required />
					</div>
					
					<div class="form-group">
						<label>Type</label>
						
						<select name="type" id="type" required class="form-control" >
							
							<option value="">Choose</option>
							<option value="employment_type" <?php echo $rowdet['type'] == 'employment_type' ? 'selected' : '' ?>>Employment Type</option>
							<option value="living_status" <?php echo $rowdet['type'] == 'living_status' ? 'selected' : '' ?>>Living Status</option>
							<option value="marital_status" <?php echo $rowdet['type'] == 'marital_status' ? 'selected' : '' ?>>Marital Status</option>
							<option value="service_type" <?php echo $rowdet['type'] == 'service_type' ? 'selected' : '' ?>>Service Type</option>
							<option value="security_questions" <?php echo $rowdet['type'] == 'security_questions' ? 'selected' : '' ?>>Security Question</option>
							<option value="merchant_prod_type" <?php echo $rowdet['type'] == 'merchant_prod_type' ? 'selected' : '' ?>>Merchant Product Type</option>
							<option value="area_activity_type" <?php echo $rowdet['type'] == 'area_activity_type' ? 'selected' : '' ?>>Area Activity Type</option>
							
						</select>
						
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
<?php include('header.php'); 

if(isset($_POST['doedit']) && $_POST['doedit'] != "")
{
	$getrows = "SELECT * FROM ".TABLE_PREFIX."dropdown_values ORDER BY id DESC";
								   
	$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
	while($row = mysqli_fetch_array($getrows)){
		
		$getLanguages = "SELECT * FROM ".TABLE_PREFIX."languages WHERE flag = '1'";
		$getLanguages = mysql_query($getLanguages) or die(mysql_error());
		
		while($rowlang = mysql_fetch_array($getLanguages)){
			
			$language_id = $rowlang['id'];
			$value_id = $row['id'];
			
			$checkexists = "SELECT * FROM ".TABLE_PREFIX."dropdown_values_translations WHERE value_id = '".$value_id."' AND language_id = '".$language_id."'";
			$checkexists = mysqli_query($con,$checkexists) or die(mysqli_error());
			$checkexists = mysqli_num_rows($checkexists);
			
			$value = $_POST['value'][$language_id][$value_id];
			
			if($checkexists){
				
				$updateQry = "UPDATE ".TABLE_PREFIX."dropdown_values_translations SET
							  value = '".addslashes($value)."'
							  WHERE value_id = '".$value_id."' AND language_id = '".$language_id."'";
							  
				mysqli_query($con,$updateQry) or die(mysqli_error());
			}
			else{
				
				$updateQry = "INSERT INTO ".TABLE_PREFIX."dropdown_values_translations SET
							  value = '".addslashes($value)."',
							  value_id = '".$value_id."',
							  language_id = '".$language_id."'";
							  
				mysqli_query($con,$updateQry) or die(mysqli_error());
			}
		}
	}
	
	header('location:'.$pagenav.'.php?action=updated');
}
?>

<style>
.translation_text{
	width:100%;
	min-height:40px;
	border:1px solid #CCC;
	padding:5px;
}
</style>

<div class="wrapper row-offcanvas row-offcanvas-left">

  <!-- Left side column. contains the logo and sidebar -->
  <?php include('leftpanel.php'); ?>
  
  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="glyphicon glyphicon-bullhorn"></i> <?=$title?> </h1>
	  
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
			  
			  
			  <!-- Chat box -->
			  <div class="box box-success">
				
				<form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" name="frmlisting">
				<input type="hidden" name="doedit" value="yes" />
				
				<div class="box-header"> 
				  
				  
				  
				</div>
				<div class="box-body table-responsive">
					
					<table id="example3" class="table table-bordered table-striped table-mailbox">
					<thead>
					  <tr>	
						<th>Sl No.</th>
						<th>Dropdown Value</th>
						<th>Type</th>
						
						<?php
						$getLanguages = "SELECT * FROM ".TABLE_PREFIX."languages WHERE flag = '1'";
						$getLanguages = mysqli_query($con,$getLanguages) or die(mysqli_error());
						
						while($rowlang = mysqli_fetch_array($getLanguages)){
							
							?>
							<th><?php echo(ucfirst(stripslashes($rowlang['language']))); ?></th>
							<?php
						}
						?>
						
					  </tr>
					</thead>
					<tbody>
					  
					  <?php
						$sl = 1;
						$getrows = "SELECT * FROM ".TABLE_PREFIX."dropdown_values WHERE flag = '1' ORDER BY id DESC";
								   
						$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
						$cntrows = mysqli_num_rows($getrows);
						
						if($cntrows){
							
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
									<td class="center"><?=$sl?></td>
									<td class="center" width="30%"><?=stripslashes($row['value'])?></td>
									<td class="center"><?=stripslashes($typetext)?></td>
									
									<input type="hidden" name="dropdown_values[]" value="<?php echo($row['id']); ?>">
									<?php
									$getLanguages = "SELECT * FROM ".TABLE_PREFIX."languages WHERE flag = '1'";
									$getLanguages = mysqli_query($con,$getLanguages) or die(mysqli_error());
									
									while($rowlang = mysqli_fetch_array($getLanguages)){
										
										$getTermLanguage = "SELECT * FROM ".TABLE_PREFIX."dropdown_values_translations WHERE value_id = '".$row['id']."' AND language_id = '".$rowlang['id']."'";
										$getTermLanguage = mysqli_query($con,$getTermLanguage) or die(mysqli_error());
										$getTermLanguage = mysqli_fetch_assoc($getTermLanguage);
										
										$value = trim(stripslashes($getTermLanguage['value']));
										?>
										<td class="center"><textarea name="value[<?php echo($rowlang['id']); ?>][<?php echo($row['id']); ?>]" class="translation_text"><?php echo($value); ?></textarea></td>
										<?php
									}
									?>
									
								</tr>
								
								<?php
								$sl++;
							}
						}
						else{
							
							?>
							<tr>
								<td colspan="20">No Term(s)</td>
							</tr>
							<?php
						}
						?>
							
					  
					</tbody>
				  </table>
					
				</div>
				<!-- /.chat -->
				
				<div class="box-footer"> 
				  <button class="btn btn-primary" type="submit">Update</button>
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
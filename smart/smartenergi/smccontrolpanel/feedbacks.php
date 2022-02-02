<?php include('header.php'); 

$id = $_REQUEST['id'];
$mode = $_REQUEST['mode'];

if(isset($_POST['mode']) && $_POST['mode'] == "delsel")
{
	$getids = $_POST['chk_id'];
	
	foreach($getids as $valids)
	{
		$del = "DELETE FROM ".TABLE_PREFIX."feedback WHERE id = '".$valids."'";
		mysqli_query($con,$del) or die(mysqli_error());
	}
	
	header('location:'.$pagenav.'.php?action=deleted');
}

if(isset($_POST['mode']) && $_POST['mode'] == "del")
{
	$del = "DELETE FROM ".TABLE_PREFIX."feedback WHERE id = '".$id."'";
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
      <h1> <i class="glyphicon glyphicon-user"></i> <?=$title?> </h1>
	  
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
						<th>Name</th>
						<th>Email</th>
						<th>Message</th>
						<th>Sent On</th>
						<th>Actions</th>
					  </tr>
					</thead>
					<tbody>
					  
					  <?php
						$sl = 1;
						$getrows = "SELECT * FROM ".TABLE_PREFIX."feedback ORDER BY id DESC";
								   
						$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
						while($row = mysqli_fetch_array($getrows)){
							
							?>
							
							<tr >
								<td class="center"><input type="checkbox" value="<?=$row['id']?>" name="chk_id[]"></td>
								<td class="center"><?=$sl?></td>
								<td class="center"><?=stripslashes(ucwords($row['name']))?></td>
								<td class="center"><?=stripslashes($row['email'])?></td>
								<td class="center"><?=stripslashes($row['message'])?></td>
								<td class="center"><?=date('d/m/Y h:i:s A',stripslashes($row['createdate']))?></td>
								<td class="center">
									<div class="btn-group">
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
	  ?>	  
	  
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
  
</div>
<!-- ./wrapper -->

<?php include('commonjs.php'); ?>

<?php include('footer.php'); ?>
<?php include('header.php'); 

if(isset($_POST['doedit']) && $_POST['doedit'] != "")
{
	$update = "UPDATE ".TABLE_PREFIX."submission SET
			   name = '".addslashes($_POST['name'])."',
			   email = '".addslashes($_POST['email'])."',
			   mobile = '".addslashes($_POST['mobile'])."',
			   current_pos = '".addslashes($_POST['current_pos'])."',
			   message = '".addslashes($_POST['message'])."'
			   WHERE id = '".$_POST['id']."'";
			   
	mysqli_query($con,$update) or die(mysqli_error());
	
	header('location:'.$pagenav.'.php?action=updated');
}

if(isset($_POST['mode']) && $_POST['mode'] == "delsel")
{
	$getids = $_POST['chk_id'];
	
	foreach($getids as $valids)
	{
		$del = "DELETE FROM ".TABLE_PREFIX."submission WHERE id = '".$valids."'";
		mysqli_query($con,$del) or die(mysqli_error());
	}
	
	header('location:'.$pagenav.'.php?action=deleted');
}

if(isset($_POST['mode']) && $_POST['mode'] == "del")
{
	$id = $_POST['id'];
	
	$del = "DELETE FROM ".TABLE_PREFIX."submission WHERE id = '".$id."'";
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
      <h1> <i class="fa fa-gear"></i> <?=$title?> </h1>
	  
      <?php include('breadcrumb.php'); ?>
	  
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
	  
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
		  
		  
          <button type="button" class="btn btn-danger btn-sm" onclick="delsel()"><i class='glyphicon glyphicon-trash'></i> Delete Selected</button><br><br>
          
          <!-- Chat box -->
          <div class="box box-success">
		  	
			<form action="submission.php" method="post" name="frmlisting">
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
                    <th>Mobile</th>
				    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
				  
				  <?php
					$sl = 1;
					$getrows = "SELECT * FROM ".TABLE_PREFIX."submission ORDER BY id DESC";
							   
					$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
					while($row = mysqli_fetch_array($getrows)){
						?>
						
						<tr >
                        	<td class="<?=$row['read'] == 'No' ? 'unread' : ''?>"><input type="checkbox" value="<?=$row['id']?>" name="chk_id[]"></td>
							<td class="<?=$row['read'] == 'No' ? 'unread' : ''?>"><?=$sl?></td>
							<td class="center <?=$row['read'] == 'No' ? 'unread' : ''?>"><?=stripslashes($row['name'])?></td>
                            <td class="center <?=$row['read'] == 'No' ? 'unread' : ''?>"><?=stripslashes($row['email'])?></td>
                            <td class="center <?=$row['read'] == 'No' ? 'unread' : ''?>"><?=stripslashes($row['mobile'])?></td>
							<td class="center <?=$row['read'] == 'No' ? 'unread' : ''?>">
								<div class="btn-group">
									<button type="button" class="btn btn-warning btn-sm" onclick="location.href='managesubmission.php?mode=edit&id=<?=$row['id']?>'"><i class='glyphicon glyphicon-search'></i> View</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="del('<?=$row['id']?>')"><i class='glyphicon glyphicon-trash'></i> Delete</button>
								</div>
							</td>
						</tr>
						
						<?php
						$sl++;
					}
					?>
						
				  
                </tbody>
                <tfoot>
                  <tr>
                  	<th><input type="checkbox" value="" ></th>
                    <th>Sl No.</th>
				    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
				    <th>Actions</th>
                  </tr>
                </tfoot>
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
	  
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
  
</div>
<!-- ./wrapper -->

<?php include('commonjs.php'); ?>

<?php include('footer.php'); ?>
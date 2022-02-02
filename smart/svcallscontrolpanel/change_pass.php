<?php include('header.php'); 

$old_password = isset($_REQUEST['old_password'])?$_REQUEST['old_password']:"";
$new_password = isset($_REQUEST['new_password'])?$_REQUEST['new_password']:"";
$retype_password =isset($_REQUEST['retype_password'])?$_REQUEST['retype_password']:"";
$submit =isset($_REQUEST['submit'])?$_REQUEST['submit']:"";

if(isset($_REQUEST['changepass']) && $_REQUEST['changepass'] == 'yes')
{
   if($new_password != $retype_password){
   		header('location:change_pass.php?retcode=3');
   }
   else
   {
	   $chk_query = "SELECT * FROM ".TABLE_PREFIX."admin where `id`='".$_SESSION[base64_encode(PROJECT_NAME).'userid']."' and `password`='".$old_password."'";
	   $result = mysql_query($chk_query);
	   if(mysql_num_rows($result)==1)
	   {
		
		$update_qry = "UPDATE ".TABLE_PREFIX."admin set `password`='".$new_password."' WHERE `id`='".$_SESSION[base64_encode(PROJECT_NAME).'userid']."' and `password`='".$old_password."'";
		mysql_query($update_qry);
		   if($update_qry)
		   {		   
				header('location:change_pass.php?retcode=1');
		   }
		   else
		   {
				header('location:change_pass.php?retcode=2');
		   }
		}
		else
		{
				header('location:change_pass.php?retcode=2');
		}
	}
}

$retcode=isset($_REQUEST['retcode'])?$_REQUEST['retcode']:"";

if($retcode==1)
{
	$msg="Your password is saved.";
}
if($retcode==2)
{
	$msg="Your password is not saved.";
}
if($retcode==3)
{
	$msg="Your password is not confirmed";
}
?>

<div class="wrapper row-offcanvas row-offcanvas-left">

  <!-- Left side column. contains the logo and sidebar -->
  <?php include('leftpanel.php'); ?>
  
  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="fa fa-key"></i> <?=$title?> </h1>
	  
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
			if($retcode==1){
			?>
			<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$msg?>
			</div>
			<?php 
			}
			if($retcode==2){
			?>
			<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$msg?>
			</div>
			<?php
			}
			if($retcode==3){
			?>
			<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$msg?>
			</div>
			<?php
			}
			?>
		  
		  
          <!-- Chat box -->
          <div class="box box-success">
		  	
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" role="form">
		  	<input type="hidden" name="changepass" value="yes" />
			
            <div class="box-header"> 
              
            </div>
            <div class="box-body">
				
				<div class="form-group">
					<label>Old Password</label>
					<input type="password" class="form-control" placeholder="Old Password" name="old_password" id="old_password" value="" required/>
				</div>
				
				<div class="form-group">
					<label>New Password</label>
					<input type="password" class="form-control" placeholder="New Password" name="new_password" id="new_password" value="" required/>
				</div>
				
				<div class="form-group">
					<label>Confirm Password</label>
					<input type="password" class="form-control" placeholder="Confirm Password" name="retype_password" id="retype_password" value="" required/>
				</div>
				
            </div>
            <!-- /.chat -->
			
			<div class="box-footer"> 
              <button class="btn btn-primary" type="submit">Submit</button>
            </div>
			
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
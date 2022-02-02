<?php include('header.php'); 

if(isset($_POST['dosaveconfig']) && $_POST['dosaveconfig'] == 'yes')
{
	foreach($config as $keycon=>$valcon)
	{
		if(isset($_POST[$keycon]) && $_POST[$keycon] != ""){
			
			$updatecon = "UPDATE ".TABLE_PREFIX."config SET config_val = '".$_POST[$keycon]."' WHERE config_type = '".$keycon."'";
			mysqli_query($con,$updatecon) or die(mysqli_error());
		}
		if($keycon == 'brochure'){
			if($_FILES[$keycon]['name'] != ""){
				@unlink($config[$keycon]);
				$filename = rand(0,9999).time().str_replace(" ","",$_FILES[$keycon]['name']);
				$filenameorig = $_FILES[$keycon]['name'];
				$filepath = "uploads/".$filename;
				move_uploaded_file($_FILES[$keycon]['tmp_name'],$filepath);
				
				$updatecon = "UPDATE ".TABLE_PREFIX."config SET config_val = '".$filepath."' WHERE config_type = '".$keycon."'";
				mysqli_query($con,$updatecon) or die(mysqli_error());
				
				$updatecon = "UPDATE ".TABLE_PREFIX."config SET config_val = '".$filenameorig."' WHERE config_type = 'brochure_filename'";
				mysqli_query($con,$updatecon) or die(mysqli_error());
			}
		}
	}
	
	header('location:settings.php?action=updated');
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
			?>
		  
		  
          <!-- Chat box -->
          <div class="box box-success">
		  	
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" role="form">
		  	<input type="hidden" name="dosaveconfig" value="yes" />
			
            <div class="box-header"> 
              
            </div>
            <div class="box-body">
				
				<div class="form-group">
					<label>Project Name</label>
					<input type="text" class="form-control" placeholder="Project Name" name="project_name" id="project_name" value="<?=$config['project_name']?>"/>
				</div>
				
				<div class="form-group">
					<label>Contact Email</label>
					<input type="text" class="form-control" placeholder="Contact Email" name="contact_email" id="contact_email" value="<?=$config['contact_email']?>"/>
				</div>
				
				<div class="form-group">
					<label>Facebook URL</label>
					<input type="text" class="form-control" placeholder="Facebook URL" name="facebook_url" id="facebook_url" value="<?=$config['facebook_url']?>"/>
				</div>
				
				<div class="form-group">
					<label>Twitter URL</label>
					<input type="text" class="form-control" placeholder="Twitter URL" name="twitter_url" id="twitter_url" value="<?=$config['twitter_url']?>"/>
				</div>
				
				<div class="form-group">
					<label>Google Plus URL</label>
					<input type="text" class="form-control" placeholder="Youtube URL" name="googleplus_url" id="googleplus_url" value="<?=$config['googleplus_url']?>"/>
				</div>
                
                <div class="form-group">
					<label>Linkedin URL</label>
					<input type="text" class="form-control" placeholder="Linkedin URL" name="linkedin_url" id="linkedin_url" value="<?=$config['linkedin_url']?>"/>
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
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
				
				<div class="form-group">
					<label>Country Prefix</label>
					<input type="text" class="form-control" placeholder="Country Prefix" name="country_prefix" id="country_prefix" value="<?=$config['country_prefix']?>"/>
				</div>
				
				<div class="form-group">
					<label>Mobile Length</label>
					<input type="text" class="form-control" placeholder="Mobile Length" name="mobile_length" id="mobile_length" value="<?=$config['mobile_length']?>"/>
				</div>
								
				<div class="form-group">
					<label>Company Number</label>
					<input type="text" class="form-control" placeholder="Company Number" name="company_number" id="company_number" value="<?=$config['company_number']?>"/>
				</div>
				
				<div class="form-group">
					<label>Company Phone Number</label>
					<input type="text" class="form-control" placeholder="Company Phone Number" name="company_phone_no" id="company_phone_no" value="<?=$config['company_phone_no']?>"/>
				</div>
				
				<div class="form-group">
					<label>Company Address</label>
					<textarea class="form-control" placeholder="Company Address" name="company_address" id="company_address"><?=$config['company_address']?></textarea>
				</div>
				
				<div class="form-group">
					<label>Company Official Email Address</label>
					<input type="text" class="form-control" placeholder="Company Official Email Address" name="company_official_email_address" id="company_official_email_address" value="<?=$config['company_official_email_address']?>"/>
				</div>
				
				<div class="form-group">
					<label>Company Web URL</label>
					<input type="text" class="form-control" placeholder="Company Web URL" name="company_web_url" id="company_web_url" value="<?=$config['company_web_url']?>"/>
				</div>
								
				<div class="form-group">
					<label>Minimum Amount</label>
					<input type="text" class="form-control" placeholder="Minimum Amount" name="minimum_amount" id="minimum_amount" value="<?=$config['minimum_amount']?>"/>
				</div>
				
				<div class="form-group">
					<label>Maximum Amount</label>
					<input type="text" class="form-control" placeholder="Maximum Amount" name="maximum_amount" id="maximum_amount" value="<?=$config['maximum_amount']?>"/>
				</div>
				
				<div class="form-group">
					<label>Loan Months (Separated by commas)</label>
					<input type="text" class="form-control" placeholder="Loan Months (Separated by commas)" name="loan_months" id="loan_months" value="<?=$config['loan_months']?>"/>
				</div>
			
				<div class="form-group">
					<label>Smartcredit wallet</label>
					<input type="text" disabled="" class="form-control" value="<?=$config['smartcredit_wallet']?>"/>
				</div>
				
				<div class="form-group">
					<label>Default APR(%) [ Addition of smartcredit interest and investor interest ]</label>
					<input type="text" class="form-control" placeholder="Default APR(%)" name="default_apr" id="default_apr" value="<?=$config['default_apr']?>"/>
				</div>

				<div class="form-group">
					<label>Smartcredit Interest (%)</label>
					<input type="text" class="form-control" placeholder="Default Fees" name="smartcredit_interest" id="smartcredit_interest" value="<?=$config['smartcredit_interest']?>"/>
				</div>
				

				<div class="form-group">
					<label>Investor Interest (%)</label>
					<input type="text" class="form-control" placeholder="Investor Interest" name="investor_interest" id="investor_interest" value="<?=$config['investor_interest']?>"/>
				</div>

				<div class="form-group">
					<label>Default rate (%)</label>
					<input type="text" class="form-control" placeholder="Default Fees" name="default_rate" id="default_rate" value="<?=$config['default_rate']?>"/>
				</div>
				
				<div class="form-group">
					<label>Default Fees (€)</label>
					<input type="text" class="form-control" placeholder="Default Fees" name="default_fee" id="default_fee" value="<?=$config['default_fee']?>"/>
				</div>
				
				<div class="form-group">
					<label>Initial Fee (€)</label>
					<input type="text" class="form-control" placeholder="Default Fees" name="initial_fee" id="initial_fee" value="<?=$config['initial_fee']?>"/>
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
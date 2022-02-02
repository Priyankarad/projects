<?php include('header.php');
if(isset($_POST['submit'])){
      
 $admin_subject =isset($_POST['admin_subject']) ? $_POST['admin_subject'] : '';
 $admin_content =isset($_POST['borrower_email_content']) ? $_POST['borrower_email_content'] : ''; 

 $merchant_subject =isset($_POST['merchant_subject']) ? $_POST['merchant_subject'] : '';
 $merchant_content =isset($_POST['merchant_email_content']) ? $_POST['merchant_email_content'] : ''; 
       $flag=1;
       
        if(empty($admin_subject)){
            
          $errors['type'] = 'admin_subject';
          $errors['msg'] = '* Enter admin email subject';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
        
        if(empty($admin_content)){
            
          $errors['type'] = 'borrower_email_content';
          $errors['msg'] = '* Enter admin email content';
          $errorsFinal[] = $errors;
          $flag = 0;

        }

        if(empty($merchant_subject)){
            
          $errors['type'] = 'merchant_subject';
          $errors['msg'] = '* Enter merchant email subject';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
        
        if(empty($merchant_content)){
            
          $errors['type'] = 'merchant_email_content';
          $errors['msg'] = '* Enter merchant email content';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
      $errstr = json_encode($errorsFinal);
      if($flag==1){  
          $adminUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                    email_content = '".addslashes(trim($admin_content))."',
                    email_subject = '".($admin_subject)."'
                    WHERE  email_template_name = 'admin_notify_merchant_registration'";
            mysqli_query($con,$adminUpdateQry) or die(mysqli_error());

          $merchantUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                    email_content = '".addslashes(trim($merchant_content))."',
                    email_subject = '".($merchant_subject)."'
                    WHERE  email_template_name = 'merchant_agreement_notify'";
            mysqli_query($con,$merchantUpdateQry) or die(mysqli_error());  

            
      }
    }

    $adminEmail = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'admin_notify_merchant_registration'";
    $adminEmail = mysqli_query($con,$adminEmail) or die(mysqli_error());
    $adminEmail = mysqli_fetch_assoc($adminEmail);

    $merchantEmail = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'merchant_agreement_notify'";
    $merchantEmail = mysqli_query($con,$merchantEmail) or die(mysqli_error());
    $merchantEmail = mysqli_fetch_assoc($merchantEmail);
 ?>

<div class="wrapper row-offcanvas row-offcanvas-left">

  <!-- Left side column. contains the logo and sidebar -->
  <?php include('leftpanel.php'); ?>
  
  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="fa fa-envelope"></i> <?=$title?> </h1>
	  
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
        <p>Merchant email :  {{ email }}</p>
        <p>Product name : {{ product_name }}</p>
        <p>Merchant name : {{ merchant_name }}</p>
        <p>Merchant CIF : {{ merchant_cif }}</p>
        <p>Project name :  {{ projectname }}</p>
        <p>Unique identifier :  {{ unique_identifier }}</p>
        
			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
        <h3>Email to admin when merchant Register</h3>
        <div class="form-group">
            <label>Email subject</label>
            <input class="form-control" name="admin_subject" id="admin_subject" value='<?=($adminEmail["email_subject"]!="") ? stripcslashes($adminEmail["email_subject"]) : "";?>'/>
        </div>

        <div class="form-group">
            <label>Email content</label>
            <textarea class="form-control" name="borrower_email_content" id="borrower_email_content"><?=($adminEmail['email_content']!="") ? stripcslashes($adminEmail['email_content']) : "";?></textarea>
        </div>

        <h3>Email to Merchant when merchant Register</h3>
        <div class="form-group">
            <label>Email subject</label>
            <input class="form-control" name="merchant_subject" id="merchant_subject" value='<?=($merchantEmail["email_subject"]!="") ? stripcslashes($merchantEmail["email_subject"]) : "";?>'/>
        </div>

        <div class="form-group">
            <label>Email content</label>
            <textarea class="form-control" name="merchant_email_content" id="merchant_email_content"><?=($merchantEmail['email_content']!="") ? stripcslashes($merchantEmail['email_content']) : "";?></textarea>
        </div>

        <div class="box-footer"> 
              <input class="btn btn-primary" type="submit" name="submit" value="submit"/>
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
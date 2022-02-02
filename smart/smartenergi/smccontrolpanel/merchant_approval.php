<?php include('header.php');
if(isset($_POST['submit'])){
      
 $merchant_approval_subject =isset($_POST['merchant_approval_subject']) ? $_POST['merchant_approval_subject'] : '';
 $merchant_approval_content =isset($_POST['merchant_email_content']) ? $_POST['merchant_email_content'] : ''; 
       $flag=1;
       
        if(empty($merchant_approval_subject)){
            
          $errors['type'] = 'merchant_approval_subject';
          $errors['msg'] = '* Enter email subject';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
        
        if(empty($merchant_approval_content)){
            
          $errors['type'] = 'merchant_email_content';
          $errors['msg'] = '* Enter email content';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
      $errstr = json_encode($errorsFinal);
      if($flag==1){  
          $merchantApprovalUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                    email_content = '".addslashes(trim($merchant_approval_content))."',
                    email_subject = '".($merchant_approval_subject)."'
                    WHERE  email_template_name = 'merchant_approval'";
            mysqli_query($con,$merchantApprovalUpdateQry) or die(mysqli_error());
      }
    }

    $getMerchantApprovalSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'merchant_approval'";
    $getMerchantApprovalQry = mysqli_query($con,$getMerchantApprovalSql) or die(mysqli_error());
    $getMerchantApprovalRow = mysqli_fetch_assoc($getMerchantApprovalQry);
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
        <p>Merchant email :  {{ merchant_email }}</p>
        <p>Product name : {{ product_name }}</p>
        <p>Merchant name : {{ merchant_name }}</p>
        <p>Project name :  {{ projectname }}</p>
        <p>Unique identifier :  {{ unique_identifier }}</p>
        
			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">

        <div class="form-group">
            <label>Merchant approval email subject</label>
            <input class="form-control" name="merchant_approval_subject" id="merchant_approval_subject" value='<?=($getMerchantApprovalRow["email_subject"]!="") ? stripcslashes($getMerchantApprovalRow["email_subject"]) : "";?>'/>
        </div>

        <div class="form-group">
            <label>Merchant approval email content</label>
            <textarea class="form-control" name="merchant_email_content" id="merchant_email_content"><?=($getMerchantApprovalRow['email_content']!="") ? stripcslashes($getMerchantApprovalRow['email_content']) : "";?></textarea>
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
<?php include('header.php');
if(isset($_POST['submit'])){
      
 $notify_subject =isset($_POST['notify_subject']) ? $_POST['notify_subject'] : '';
 $notify_content =isset($_POST['merchant_email_content']) ? $_POST['merchant_email_content'] : ''; 
       $flag=1;
       
        if(empty($notify_subject)){
            
          $errors['type'] = 'notify_subject';
          $errors['msg'] = '* Enter email subject';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
        
        if(empty($notify_content)){
            
          $errors['type'] = 'merchant_email_content';
          $errors['msg'] = '* Enter email content';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
      $errstr = json_encode($errorsFinal);
      if($flag==1){  
          $loanNotifyUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                    email_content = '".addslashes(trim($notify_content))."',
                    email_subject = '".($notify_subject)."'
                    WHERE  email_template_name = 'loan_application_notify'";
            mysqli_query($con,$loanNotifyUpdateQry) or die(mysqli_error());
      }
    }

    $getLoanNotifySql = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'loan_application_notify'";
    $getLoanNotifyQry = mysqli_query($con,$getLoanNotifySql) or die(mysqli_error());
    $getLoanNotifyRow = mysqli_fetch_assoc($getLoanNotifyQry);
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
        <p>Loan id :  {{ loanid }}</p>
        <p>Borrower firstname :  {{ firstname }} </p>
        <p>Borrower middlename : {{ middlename }}</p>
        <p>Borrower surname :  {{ surname }}</p>
        <p>Borrower email :  {{ borrower_email }}</p>
        <p>Borrower mobile : {{ borrower_mobile }}</p>
        <p>Product name : {{ product_name }}</p>
        <p>Emailto : {{ toemail }}</p>
        <p>Merchant name : {{ merchant_name }}</p>
        <p>Loan date :  {{ loan_date }}</p>
        <p>Loan terms :  {{ loan_terms }} </p>
        <p>Loan amount : {{ loan_amount }}</p>
        <p>Loan apr :  {{ loan_apr }}</p>
        <p>Project name :  {{ projectname }}</p>
        

			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">

        <div class="form-group">
            <label>Notify installment email subject</label>
            <input class="form-control" name="notify_subject" id="notify_subject" value='<?=($getLoanNotifyRow["email_subject"]!="") ? stripcslashes($getLoanNotifyRow["email_subject"]) : "";?>'/>
        </div>

        <div class="form-group">
            <label>Notify email content</label>
            <textarea class="form-control" name="merchant_email_content" id="merchant_email_content"><?=($getLoanNotifyRow['email_content']!="") ? stripcslashes($getLoanNotifyRow['email_content']) : "";?></textarea>
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
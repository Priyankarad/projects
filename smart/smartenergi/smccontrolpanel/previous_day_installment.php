<?php include('header.php');
if(isset($_POST['submit'])){
      
 $previousday_installment_subject =isset($_POST['previousday_installment_subject']) ? $_POST['previousday_installment_subject'] : '';
 $previousday_installment_content =isset($_POST['merchant_email_content']) ? $_POST['merchant_email_content'] : ''; 
       $flag=1;
       
        if(empty($previousday_installment_subject)){
            
          $errors['type'] = 'previousday_installment_subject';
          $errors['msg'] = '* Enter email content';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
        
        if(empty($previousday_installment_content)){
            
          $errors['type'] = 'merchant_email_content';
          $errors['msg'] = '* Enter email subject';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
      $errstr = json_encode($errorsFinal);
      if($flag==1){  
          $defaultCommunicationUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                    email_content = '".addslashes(trim($previousday_installment_content))."',
                    email_subject = '".($previousday_installment_subject)."'
                    WHERE  email_template_name = 'previous_day_installment'";
            mysqli_query($con,$defaultCommunicationUpdateQry) or die(mysqli_error());
      }
    }

    $getDefaultCommunicationSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'previous_day_installment'";
    $getDefaultCommunicationQry = mysqli_query($con,$getDefaultCommunicationSql) or die(mysqli_error());
    $getDefaultCommunicationRow = mysqli_fetch_assoc($getDefaultCommunicationQry);
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
        <p>Loan id :  {{ unique_id }}</p>
        <p>Borrower firstname :  {{ firstname }} </p>
        <p>Borrower middlename : {{ middlename }}</p>
        <p>Borrower surname :  {{ surname }}</p>
        <p>Borrower email :  {{ emailaddress }}</p>
        <p>Merchant name : {{ merchant_name }}</p>
        <p>Loan date :  {{ loan_date }}</p>
        <p>Loan terms :  {{ loan_terms }} </p>
        <p>Loan amount : {{ loan_amount }}</p>
        <p>Loan apr :  {{ loan_apr }}</p>
        <p>Emi amount :  {{ emi_amount }}</p>
        <p>Due days : {{ duedays }}</p>
        <p>Project name :  {{ projectname }}</p>
        <p>Company phone no. : {{ company_phone_no }}</p>

			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">

        <div class="form-group">
            <label>Previousday installment email subject</label>
            <input class="form-control" name="previousday_installment_subject" id="previousday_installment_subject" value='<?=($getDefaultCommunicationRow["email_subject"]!="") ? stripcslashes($getDefaultCommunicationRow["email_subject"]) : "";?>'/>
        </div>

        <div class="form-group">
            <label>Previousday installment email content</label>
            <textarea class="form-control" name="merchant_email_content" id="merchant_email_content"><?=($getDefaultCommunicationRow['email_content']!="") ? stripcslashes($getDefaultCommunicationRow['email_content']) : "";?></textarea>
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
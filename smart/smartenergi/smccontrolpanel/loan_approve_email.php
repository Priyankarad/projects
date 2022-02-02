<?php include('header.php');
if(isset($_POST['submit'])){
      
 $borrower_email_content =isset($_POST['borrower_email_content']) ? $_POST['borrower_email_content'] : '';
 $merchant_email_content =isset($_POST['merchant_email_content']) ? $_POST['merchant_email_content'] : '';
 $borrower_email_subject =isset($_POST['borrower_email_subject']) ? $_POST['borrower_email_subject'] : '';
 $merchant_email_subject =isset($_POST['merchant_email_subject']) ? $_POST['merchant_email_subject'] : '';
 $investor_email_subject =isset($_POST['investor_email_subject']) ? $_POST['investor_email_subject'] : '';
 $investor_email_content =isset($_POST['investor_email_content']) ? $_POST['investor_email_content'] : ''; 

       $flag=1;
       if(empty($borrower_email_content)){
    
          $errors['type'] = 'borrower_email_subject';
          $errors['msg'] = '* Enter Borrower email content';
          $errorsFinal[] = $errors;
          $flag = 0;
        }

        if(empty($merchant_email_content)){
            
          $errors['type'] = 'merchant_email_content';
          $errors['msg'] = '* Enter Merchant email content';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
        if(empty($borrower_email_subject)){
          
          $errors['type'] = 'borrower_email_subject';
          $errors['msg'] = '* Enter Borrower email subject';
          $errorsFinal[] = $errors;
          $flag = 0;
        }

        if(empty($merchant_email_subject)){
            
          $errors['type'] = 'merchant_email_subject';
          $errors['msg'] = '* Enter Merchant email subject';
          $errorsFinal[] = $errors;
          $flag = 0;
        }

         if(empty($investor_email_subject)){
              $errors['type'] = 'investor_email_subject';
              $errors['msg'] = '* Enter Investor email subject';
              $errorsFinal[] = $errors;
              $flag = 0;
        }

        if(empty($investor_email_content)){
            $errors['type'] = 'investor_email_content';
            $errors['msg'] = '* Enter Investor email content';
            $errorsFinal[] = $errors;
            $flag = 0;
        }

      $errstr = json_encode($errorsFinal);
      if($flag==1){  
          $borrowerUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                    email_content = '".addslashes(trim($borrower_email_content))."',
                    email_subject = '".($borrower_email_subject)."'
                    WHERE  email_template_name = 'borrower_loan_approval'";
            mysqli_query($con,$borrowerUpdateQry) or die(mysqli_error());

          $merchantUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                    email_content = '".addslashes(trim($merchant_email_content))."',
                    email_subject = '".($merchant_email_subject)."'
                    WHERE  email_template_name = 'merchant_loan_approval'";
            mysqli_query($con,$merchantUpdateQry) or die(mysqli_error());

          $investorUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                    email_content = '".addslashes(trim($investor_email_content))."',
                    email_subject = '".($investor_email_subject)."'
                    WHERE  email_template_name = 'investor_loan_notification'";
            mysqli_query($con,$investorUpdateQry) or die(mysqli_error());  
      }
    }

    $getBorrowerSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'borrower_loan_approval'";
    $getBorrowerQry = mysqli_query($con,$getBorrowerSql) or die(mysqli_error());
    $getBorrowerRow = mysqli_fetch_assoc($con,$getBorrowerQry);

    $getMerchantSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'merchant_loan_approval'";
    $getMerchantQry = mysqli_query($con,$getMerchantSql) or die(mysqli_error());
    $getMerchantRow = mysqli_fetch_assoc($getMerchantQry);

    $getInvestorSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'investor_loan_notification'";
    $getInvestorQry = mysqli_query($con,$getInvestorSql) or die(mysqli_error());
    $getInvestorRow = mysqli_fetch_assoc($getInvestorQry);
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
          <p>Borrower City :  {{ borrower_email }}</p>
          <p>Borrower Employment : {{ merchant_name }}</p>
          <p>Borrower age : {{ age }}</p>
          <p>Merchant name : {{ merchant_name }}</p>
          <p>Investor name : {{ investor_name }}</p>
          <p>Project name : {{ projectname }}</p>

          <p>Loan ID : {{ loanid }}</p>
          <p>Loan Amount : {{ loan_amount }}</p>
          <p>Loan Terms : {{ loan_rems }}</p>
          <p>Loan APR : {{ loan_apr }}</p>
          

	<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
      <div class="form-group">
          <label>Borrower email subject</label>
          <input class="form-control" id="borrower_email_subject" name="borrower_email_subject" value='<?=($getBorrowerRow["email_subject"]!="") ? stripcslashes($getBorrowerRow["email_subject"]) : "";?>'/>
      </div>

      <div class="form-group">
          <label>Borrower email content</label>
          <textarea name="borrower_email_content" class="form-control" id="borrower_email_content"><?=($getBorrowerRow['email_content']!="") ? stripcslashes($getBorrowerRow['email_content']) : "";?>
        </textarea>
      </div>

      <div class="form-group">
          <label>Merchant email subject</label>
          <input class="form-control" name="merchant_email_subject" id="merchant_email_subject" value='<?=($getMerchantRow["email_subject"]!="") ? stripcslashes($getMerchantRow["email_subject"]) : "";?>'/>
      </div>

      <div class="form-group">
          <label>Merchant email content</label>
          <textarea class="form-control" name="merchant_email_content" id="merchant_email_content"><?=($getMerchantRow['email_content']!="") ? stripcslashes($getMerchantRow['email_content']) : "";?></textarea>
      </div>

      <div class="form-group">
          <label>Investor email subject</label>
          <input class="form-control" name="investor_email_subject" id="investor_email_subject" value='<?=($getInvestorRow["email_subject"]!="") ? stripcslashes($getInvestorRow["email_subject"]) : "";?>'/>
      </div>

      <div class="form-group">
          <label>Investor email content</label>
          <textarea class="form-control" name="investor_email_content" id="investor_email_content"><?=($getInvestorRow['email_content']!="") ? stripcslashes($getInvestorRow['email_content']) : "";?></textarea>
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
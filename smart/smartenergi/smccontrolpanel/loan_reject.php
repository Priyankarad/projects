<?php include('header.php');
if(isset($_POST['submit'])){
      
 $loan_rejected_subject =isset($_POST['loan_rejected_subject']) ? $_POST['loan_rejected_subject'] : '';
 $loan_rejected_content =isset($_POST['merchant_email_content']) ? $_POST['merchant_email_content'] : ''; 
       $flag=1;
       
        if(empty($loan_rejected_subject)){
                $errors['type'] = 'loan_rejected_subject';
                $errors['msg'] = '* Enter email subject';
                $errorsFinal[] = $errors;
                $flag = 0;
        }
        
        if(empty($loan_rejected_content)){
                $errors['type'] = 'merchant_email_content';
                $errors['msg'] = '* Enter email content';
                $errorsFinal[] = $errors;
                $flag = 0;
        }

      $errstr = json_encode($errorsFinal);
      if($flag==1){  
          $loanRejectedUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                                    email_content = '".addslashes(trim($loan_rejected_content))."',
                                    email_subject = '".($loan_rejected_subject)."'
                                    WHERE  email_template_name = 'loan_rejected'";
            mysqli_query($con,$loanRejectedUpdateQry) or die(mysqli_error());
      }
    }

    $getloanRejectedSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'loan_rejected'";
    $getloanRejectedQry = mysqli_query($con,$getloanRejectedSql) or die(mysqli_error());
    $getloanRejectedRow = mysqli_fetch_assoc($getloanRejectedQry);
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
		  
		    <?php if($_REQUEST['action']=='updated'){ ?>
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
        <p>Borrower firstname :  {{ firstname }}</p>
        <p>Borrower middlename : {{ middlename }}</p>
        <p>Borrower surname : {{ surname }}</p>
        <p>Borrower emailaddress :  {{ emailaddress }}</p>
        <p>Projectname :  {{ projectname }}</p>
        <p>Loanid : {{ loanid }}</p>
        
			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">

        <div class="form-group">
            <label>Loan rejected email subject</label>
            <input class="form-control" name="loan_rejected_subject" id="loan_rejected_subject" value='<?=($getloanRejectedRow["email_subject"]!="") ? stripcslashes($getloanRejectedRow["email_subject"]) : "";?>'/>
        </div>

        <div class="form-group">
            <label>Loan rejected email content</label>
            <textarea class="form-control" name="merchant_email_content" id="merchant_email_content"><?=($getloanRejectedRow['email_content']!="") ? stripcslashes($getloanRejectedRow['email_content']) : "";?></textarea>
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
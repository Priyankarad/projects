<?php include('header.php');
if(isset($_POST['submit'])){
      
 $loan_closed_subject =isset($_POST['loan_closed_subject']) ? $_POST['loan_closed_subject'] : '';
 $loan_closed_content =isset($_POST['merchant_email_content']) ? $_POST['merchant_email_content'] : ''; 
       $flag=1;
       
        if(empty($loan_closed_subject)){
                $errors['type'] = 'loan_closed_subject';
                $errors['msg'] = '* Enter email subject';
                $errorsFinal[] = $errors;
                $flag = 0;
        }
        
        if(empty($loan_closed_content)){
                $errors['type'] = 'merchant_email_content';
                $errors['msg'] = '* Enter email content';
                $errorsFinal[] = $errors;
                $flag = 0;
        }
      $errstr = json_encode($errorsFinal);
      if($flag==1){  
          $loanClosedUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                                    email_content = '".addslashes(trim($loan_closed_content))."',
                                    email_subject = '".addslashes($loan_closed_subject)."'
                                    WHERE  email_template_name = 'loan_closed'";
            mysqli_query($con,$loanClosedUpdateQry) or die(mysqli_error());
      }
    }

    $getloanClosedSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'loan_closed'";
    $getloanClosedQry = mysqli_query($con,$getloanClosedSql) or die(mysqli_error());
    $getloanClosedRow = mysqli_fetch_assoc($getloanClosedQry);
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
        <p>Project name : {{ projectname }}</p>
        
      <form method="post" action="<?=$_SERVER['REQUEST_URI']?>">

        <div class="form-group">
            <label>Loan closed email subject</label>
            <input class="form-control" name="loan_closed_subject" id="loan_closed_subject" value='<?=($getloanClosedRow["email_subject"]!="") ? stripcslashes($getloanClosedRow["email_subject"]) : "";?>'/>
        </div>

        <div class="form-group">
            <label>Loan closed email content</label>
            <textarea class="form-control" name="merchant_email_content" id="merchant_email_content"><?=($getloanClosedRow['email_content']!="") ? stripcslashes($getloanClosedRow['email_content']) : "";?></textarea>
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
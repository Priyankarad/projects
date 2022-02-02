<?php include('header.php');
if(isset($_POST['submit'])){
      
 $bearch_of_contract_subject =isset($_POST['bearch_of_contract_subject']) ? $_POST['bearch_of_contract_subject'] : '';
 $bearch_of_contract_content =isset($_POST['merchant_email_content']) ? $_POST['merchant_email_content'] : ''; 
       $flag=1;
       
        if(empty($bearch_of_contract_subject)){
            
          $errors['type'] = 'bearch_of_contract_subject';
          $errors['msg'] = '* Enter Merchant email content';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
        
        if(empty($bearch_of_contract_content)){
            
          $errors['type'] = 'merchant_email_content';
          $errors['msg'] = '* Enter Merchant email subject';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
      $errstr = json_encode($errorsFinal);
      if($flag==1){  
          $merchantUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                    email_content = '".addslashes(trim($bearch_of_contract_content))."',
                    email_subject = '".($bearch_of_contract_subject)."'
                    WHERE  email_template_name = 'breach_of_contract'";
            mysqli_query($con,$merchantUpdateQry) or die(mysqli_error());
      }
    }

    $getBearchOfContractSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'breach_of_contract'";
    $getBearchOfContractQry = mysqli_query($con,$getBearchOfContractSql) or die(mysqli_error());
    $getBearchOfContractRow = mysqli_fetch_assoc($getBearchOfContractQry);
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
            <label>Bearch of contract email subject</label>
            <input class="form-control" name="bearch_of_contract_subject" id="bearch_of_contract_subject" value='<?=($getBearchOfContractRow["email_subject"]!="") ? stripcslashes($getBearchOfContractRow["email_subject"]) : "";?>'/>
        </div>

        <div class="form-group">
            <label>Bearch of contract email content</label>
            <textarea class="form-control" name="merchant_email_content" id="merchant_email_content"><?=($getBearchOfContractRow['email_content']!="") ? stripcslashes($getBearchOfContractRow['email_content']) : "";?></textarea>
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
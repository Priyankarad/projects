<?php include('header.php');
if(isset($_POST['submit'])){
      
 $investor_email_subject =isset($_POST['investor_email_subject']) ? $_POST['investor_email_subject'] : '';
 $investor_email_content =isset($_POST['investor_email_content']) ? $_POST['investor_email_content'] : ''; 
       $flag=1;
       
        if(empty($investor_email_subject)){
            
          $errors['type'] = 'investor_email_subject';
          $errors['msg'] = '* Enter Investor email content';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
        
        if(empty($investor_email_content)){
            
          $errors['type'] = 'investor_email_content';
          $errors['msg'] = '* Enter Investor email subject';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
      $errstr = json_encode($errorsFinal);
      if($flag==1){  
          $investorUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                    email_content = '".addslashes(trim($investor_email_content))."',
                    email_subject = '".($investor_email_subject)."'
                    WHERE  email_template_name = 'lender_email_verification'";
            mysqli_query($con,$investorUpdateQry) or die(mysqli_error());
      }
    }

    $getInvestorSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'lender_email_verification'";
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
        <p>Investor email :  {{ email }}</p>
        <p>Investor name :  {{ lender_name }} </p>
        <p>Investor national id number: {{ nat_id_num }}</p>
        <p>Investor country of residence :  {{ country_of_residence }}</p>
        <p>Investor occupation :  {{ occupation }}</p>
        <p>Investor country of document origin : {{ country_of_doc_origin }}</p>
        <p>Investor unique identifier :  {{ unique_identifier }}</p>
        <p>Project name : {{ projectname }}</p>

			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">

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
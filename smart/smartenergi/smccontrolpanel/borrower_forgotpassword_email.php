<?php include('header.php');
if(isset($_POST['submit'])){
      
 $borrower_email_content =isset($_POST['borrower_email_content']) ? $_POST['borrower_email_content'] : '';
 $borrower_email_subject =isset($_POST['borrower_email_subject']) ? $_POST['borrower_email_subject'] : '';

       $flag=1;
       
        if(empty($borrower_email_content)){
            
          $errors['type'] = 'borrower_email_content';
          $errors['msg'] = '* Enter Borrower email content';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
        
        if(empty($borrower_email_subject)){
            
          $errors['type'] = 'borrower_email_subject';
          $errors['msg'] = '* Enter Borrower email subject';
          $errorsFinal[] = $errors;
          $flag = 0;

        }
      $errstr = json_encode($errorsFinal);
      if($flag==1){  
          $borrowerUpdateQry = "UPDATE ".TABLE_PREFIX."backoffice_email_templates SET
                    email_content = '".addslashes(trim($borrower_email_content))."',
                    email_subject = '".($borrower_email_subject)."'
                    WHERE  email_template_name = 'borrower_forgotpassword'";
            mysqli_query($con,$borrowerUpdateQry) or die(mysqli_error());
      }
    }

    $getBorrowerSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_email_templates
     WHERE email_template_name = 'borrower_forgotpassword'";
    $getBorrowerQry = mysqli_query($con,$getBorrowerSql) or die(mysqli_error());
    $getBorrowerRow = mysqli_fetch_assoc($getBorrowerQry);
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
        <p>Borrower email :  {{ emailaddress }}</p>
        <p>Borrower username :  {{ username }}</p>
        <p>Borrower firstname :  {{ firstname }} </p>
        <p>Borrower middlename : {{ middlename }}</p>
        <p>Borrower surname :  {{ surname }}</p>
        <p>Borrower second surname :  {{ second_surname }}</p>
        <p>Borrower unique identifier :  {{ unique_identifier }}</p>
        <p>Project name : {{ projectname }}</p>

			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">

        <div class="form-group">
            <label>Borrower email subject</label>
            <input class="form-control" name="borrower_email_subject" id="borrower_email_subject" value='<?=($getBorrowerRow["email_subject"]!="") ? stripcslashes($getBorrowerRow["email_subject"]) : "";?>'/>
        </div>

        <div class="form-group">
            <label>Borrower email content</label>
            <textarea class="form-control" name="borrower_email_content" id="borrower_email_content"><?=($getBorrowerRow['email_content']!="") ? stripcslashes($getBorrowerRow['email_content']) : "";?></textarea>
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
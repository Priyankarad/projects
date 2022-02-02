<?php 
require_once('header.php');

if(isset($_REQUEST['doregister']) && !empty($_REQUEST['doregister']) && $_REQUEST['doregister'] == 'yes'){
	
	if(count($_POST)){
			
		foreach($_POST as $key=>$val){
			
			$_POST[$key] = trim(htmlspecialchars($val));
		}
	}
	
	$email 				= isset($_POST['email']) ? $_POST['email'] : '';
	$password 			= isset($_POST['password']) ? $_POST['password'] : '';
	$confirmpassword 	= isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';
	$merchant_name 		= isset($_POST['merchant_name']) ? $_POST['merchant_name'] : '';
	$contact_person 	= isset($_POST['contact_person']) ? $_POST['contact_person'] : '';
	$mobile_no 			= isset($_POST['mobile_no']) ? $_POST['mobile_no'] : '';
	$merchant_cif 		= isset($_POST['merchant_cif']) ? $_POST['merchant_cif'] : '';
	$sector 			= isset($_POST['sector']) ? $_POST['sector'] : '';
	$bank_name 			= isset($_POST['bank_name']) ? $_POST['bank_name'] : '';
	$bank_account_no 	= isset($_POST['bank_account_no']) ? $_POST['bank_account_no'] : '';
	
	$flag = 1;
	
	if(empty($email)){
		
		$errors['type'] = 'email';
		$errors['msg'] = '* Enter email address';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		
		$errors['type'] = 'email';
		$errors['msg'] = ' Enter proper email address';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	else{
			
		$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE email = '".$email."'";
		$checkemailSql = mysql_query($checkemailQry) or die(mysql_error());
		$checkemailRow = mysql_fetch_row($checkemailSql);
		
		if(!empty($checkemailRow)){
			
			$errors['type'] = 'email';
			$errors['msg'] = '* Email address is already registered';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
	}
	if(empty($password)){
			
		$errors['type'] = 'password';
		$errors['msg'] = '* Enter password';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	if(empty($confirmpassword)){
		
		$errors['type'] = 'confirmpassword';
		$errors['msg'] = '* Confirm your password';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	else if($confirmpassword != $password){
		
		$errors['type'] = 'confirmpassword';
		$errors['msg'] = '* Passwords mismatch';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	if(empty($merchant_name)){
		
		$errors['type'] = 'merchant_name';
		$errors['msg'] = '* Enter Merchant name';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	else{
			
		$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE merchant_name = '".$merchant_name."'";
		$checkemailSql = mysql_query($checkemailQry) or die(mysql_error());
		$checkemailRow = mysql_fetch_row($checkemailSql);
		
		if(!empty($checkemailRow)){
			
			$errors['type'] = 'merchant_name';
			$errors['msg'] = '* Merchant name is already registered';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
	}
	if(empty($contact_person)){
		
		$errors['type'] = 'contact_person';
		$errors['msg'] = '* Enter contact person name';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	if(empty($mobile_no)){
			
		$errors['type'] = 'mobile_no';
		$errors['msg'] = '* Enter contact person mobile number';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	else if(!is_numeric($mobile_no)){
		
		$errors['type'] = 'mobile_no';
		$errors['msg'] = '* Mobile number must be digits';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	else if(strlen($mobile_no) != MOBILE_LENGTH){
		
		$errors['type'] = 'mobile_no';
		$errors['msg'] = '* Mobile number must be of '.MOBILE_LENGTH.' digits';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	if(empty($merchant_cif)){
		
		$errors['type'] = 'merchant_cif';
		$errors['msg'] = '* Enter Merchant CIF/ID number';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	else{
		
		$regex = '/^[A-Z][0-9]{8}$/';

		preg_match_all($regex, $merchant_cif, $matches, PREG_SET_ORDER, 0);
		
		if(!count($matches)){
			
			$errors['type'] = 'merchant_cif';
			$errors['msg'] = '* Merchant CIF/ID number must be of 1 Capital Letter and 8 Digits';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
	}
	if(empty($sector)){
		
		$errors['type'] = 'sector';
		$errors['msg'] = '* Enter Sector';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	if(empty($bank_name)){
		
		$errors['type'] = 'bank_name';
		$errors['msg'] = '* Enter bank name';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	if(empty($bank_account_no)){
		
		$errors['type'] = 'bank_account_no';
		$errors['msg'] = '* Enter bank account no';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	else{
		
		$regex = '/^[A-Z]{2}[0-9]{22}$/';

		preg_match_all($regex, $bank_account_no, $matches, PREG_SET_ORDER, 0);
		
		if(!count($matches)){
			
			$errors['type'] = 'bank_account_no';
			$errors['msg'] = '* Bank account no must be of 2 Capital Letters and 22 Digits';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
	}
	
	$errstr = json_encode($errorsFinal);
	
	//echo '<pre>'; print_r($errorsFinal); //exit;
	
	if($flag == 1){
		
		$time = time();
		
		$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_merchants SET
					  email = '".addslashes($email)."',
					  password = '".addslashes(md5($password))."',
					  merchant_name = '".addslashes($merchant_name)."',
					  contact_person = '".addslashes($contact_person)."',
					  mobile_no = '".addslashes($mobile_no)."',
					  merchant_cif = '".addslashes($merchant_cif)."',
					  sector = '".addslashes($sector)."',
					  bank_name = '".addslashes($bank_name)."',
					  bank_account_no = '".addslashes($bank_account_no)."',
					  createdate = '".$time."',
					  status = 'pending'";
					  
		$insertQry = mysql_query($insertSql) or die(mysql_error());
		
		$_SESSION['merchant_account_created'] = 'yes';
		
		header("Location:".BASE_URL.$_SESSION['currentLang'].'/accountcreated');
		exit;
	}
}

if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/myaccount/opportunities');
	exit;
}
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major">
			<h2><?php echo($transArr['Merchant Signup']); ?></h2>
			<p><?php echo($transArr['Please fill up the below form and submit to create your free account. Once your account is created and approved you can send loan application on behalf of your customer.']); ?>.</p>
		</header>
		
		<section class="investorsignup">
			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
			
				<input type="hidden" name="doregister" value="yes">
				
				<div class="row uniform 50%" style="text-align:left">
					
					<div class="12u$">
						<input type="text" name="email" id="email" value="<?php echo($email); ?>" placeholder="<?php echo($transArr['Email']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="password" name="password" id="password" value="<?php echo($password); ?>" placeholder="<?php echo($transArr['Password']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="password" name="confirmpassword" id="confirmpassword" value="<?php echo($confirmpassword); ?>" placeholder="<?php echo($transArr['Confirm Password']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="text" name="merchant_name" id="merchant_name" value="<?php echo($merchant_name); ?>" placeholder="<?php echo($transArr['Merchant Name']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="text" name="contact_person" id="contact_person" value="<?php echo($contact_person); ?>" placeholder="<?php echo($transArr['Contact Person']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="text" name="mobile_no" id="mobile_no" value="<?php echo($mobile_no); ?>" placeholder="<?php echo($transArr['Mobile Phone']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="text" name="merchant_cif" id="merchant_cif" value="<?php echo($merchant_cif); ?>" placeholder="CIF/ID" />
					</div>
					
					<div class="12u$">
						<input type="text" name="sector" id="sector" value="<?php echo($sector); ?>" placeholder="<?php echo($transArr['Sector']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="text" name="bank_name" id="bank_name" value="<?php echo($bank_name); ?>" placeholder="<?php echo($transArr['Bank Name']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="text" name="bank_account_no" id="bank_account_no" value="<?php echo($bank_account_no); ?>" placeholder="<?php echo($transArr['Bank Account No']); ?>" />
					</div>
					
				</div>
				
				<div class="12u$ formbtn">
					<ul class="actions">
						<li><input type="submit" value="<?php echo($transArr['Register']); ?>" class="special" /></li>
					</ul>
				</div>
				
				<div class="row uniform 50% signupsigninblock">
					
					<div class="12u$"><span class="orclass"><?php echo($transArr['OR']); ?><span></div>
					
					<div class="12u$">
						<p><?php echo($transArr['If you are already registered']); ?>, <a href="<?=BASE_URL.$getLang?>/merchant-signin"><?php echo($transArr['Click here']); ?></a> <?php echo($transArr['to signin']); ?>.</p>
					</div>
					
				</div>

			</form>
		</section>
		
	</div>
</section>

<script>
window.onload = function(){
	
	var errstr = JSON.parse('<?php echo($errstr); ?>');

	console.log(errstr);
	
	if(errstr.length > 0){
	
		errstr.forEach(function(err){
			
			$('#' + err.type).addClass('errbrdr');
			$('#' + err.type).after('<div class="errtxt">' + err.msg + '</div>');
			
		});
	}
	
	$('html,body').animate({scrollTop : $('.errbrdr:first').offset().top-50},600);
	
	//$('.errbrdr:first').click();
	$('.errbrdr:first').focus();
}

$(document).ready(function(){
	
	$('select,input[type=text],input[type=password],input[type=file]').on('keyup change keypress blur',function(){
		
		var val = $(this).val();
		
		if(val != ''){
			
			$(this).removeClass('errbrdr');
			$(this).next('.errtxt').remove();
		}
		
	});
	
});
</script>

<?php 
require_once('footer.php');
?>
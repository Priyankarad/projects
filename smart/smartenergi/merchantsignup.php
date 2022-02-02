<?php 
require_once('header.php');

$step = isset($_REQUEST['step']) ? $_REQUEST['step'] : '';

if(isset($_REQUEST['doregister']) && !empty($_REQUEST['doregister']) && $_REQUEST['doregister'] == 'yes'){
	
	if(count($_POST)){
			
		foreach($_POST as $key=>$val){
			
			$_POST[$key] = trim(htmlspecialchars($val));
		}
	}
	
	$email 				= isset($_POST['email']) ? $_POST['email'] : '';
	$password 			= isset($_POST['password']) ? $_POST['password'] : '';
	$confirmpassword 	= isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';
	
	
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
			
		$checkemailRow = checkEmail($email,$con);
		//echo count($checkemailRow);
		if(($checkemailRow) > 0){
			
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

	
	
	$errstr = json_encode($errorsFinal);
	
	//echo '<pre>'; print_r($errorsFinal); //exit;
	
	if($flag == 1){
		
		$time = time();
			
		$lastid = insertQuery("backoffice_merchants",array("email"=>addslashes($email),"password"=>addslashes(md5($password)),"createdate"=>$time),$con);

		$uniqueid = md5(uniqid($lastid, true));

		$updateSql = updateQuery("backoffice_merchants",
					array("id"=>$lastid),
					array("unique_identifier"=>$uniqueid),
					$con);
		// Send Email Verification Email
		
		$request = curl_init(BASE_URL.'backoffice/merchantemailverify/'.$lastid);
		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($request);
		curl_close($request);		
		
		$_SESSION['email_verification_sent'] = 'yes';
		
		header("Location:".BASE_URL.$_SESSION['currentLang'].'/merchant-signup/verify/email');
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
		
		<?php
		if($step == 'step1'){
		?>
		
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
					
				</div>

				<div class="12u$ formbtn">
					<ul class="actions">
						<li><input type="submit" value="<?php echo($transArr['Continue']); ?>" class="special" /></li>
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
		
		<?php
		}
		if($step == 'step2'){
		?>
		
		<header class="major">
			<h2><?php echo($transArr['Provide Your Account Information']); ?></h2>
			<p><?php echo($transArr['Provide some more account related information to successfully register your account']); ?>.</p>
		</header>
		
		<section class="investorsignup">
			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
			
				<input type="hidden" name="doregister" value="yes">
				
				<div class="row uniform 50%" style="text-align:left">
					
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
					
				</div>

				<div class="12u$ formbtn">
					<ul class="actions">
						<li><input type="submit" value="<?php echo($transArr['Register']); ?>" class="special" /></li>
					</ul>
				</div>

			</form>
		</section>
		
		<?php
		}
		?>
		
	</div>
</section>


<script>

window.onload = function(){
	
	var errstr = JSON.parse('<?php echo($errstr); ?>');
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
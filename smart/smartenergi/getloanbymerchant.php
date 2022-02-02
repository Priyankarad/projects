<?php 
require_once('header.php');		

$step = isset($_REQUEST['step']) ? $_REQUEST['step'] : '';

if($step == 'step1')	require_once('getloanbanner.php');

$type = isset($_SESSION['userid']) && !empty($_SESSION['userid']) ? $_SESSION['usertype'] : '';

$stepscovered = isset($_SESSION['steps']) && !empty($_SESSION['steps']) ? array_unique($_SESSION['steps']) : ['step1'];


$_SESSION['steps'] = array_values($_SESSION['steps']);

if(!isset($_SESSION['steps']) && $step != 'step1'){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloanbymerchant/step1');
	exit;
}
else{
	
	$lastStepCovered = $_SESSION['steps'][count($_SESSION['steps'])-1];
	
	if($step != $lastStepCovered && $lastStepCovered != '' && $step != 'step1'){
		
		header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloanbymerchant/'.$lastStepCovered);
		exit;
	}
}

$terms = explode(",",$config['loan_months']);

$values = [

	'months' => [
		
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		'July',
		'August',
		'September',
		'October',
		'November',
		'December'
	]
];

$variables = getVariables($langID);
$values = array_merge($variables,$values);

$errors = array();
$errorsFinal = array();

if(isset($_REQUEST['stepcount']) && !empty($_REQUEST['stepcount'])){
	
	$stepcount = $_REQUEST['stepcount'];
	
	$currentsteps = [];
	
	if($stepcount == 'step1'){
		
		$stepscovered[] = 'step2';
		$_SESSION['steps'] = $stepscovered;
		
		$_SESSION['customerdata'] = [
			
			'amount' => $_POST['loanamount'],
			'term' => $_POST['loanterm'],
			'type' => $_POST['type']
		];
		
		header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloanbymerchant/step2');
		exit;
	}
	else if($stepcount == 'step2'){
		
		if(count($_POST)){
			
			foreach($_POST as $key=>$val){
				
				$_POST[$key] = trim(htmlspecialchars($val));
			}
		}
		
		$firstname 				= isset($_POST['firstname']) ? $_POST['firstname'] : '';
		$middlename 			= isset($_POST['middlename']) ? $_POST['middlename'] : '';
		$surname 				= isset($_POST['surname']) ? $_POST['surname'] : '';
		$second_surname 		= isset($_POST['second_surname']) ? $_POST['second_surname'] : ''; 
		$homelanguage 			= isset($_POST['homelanguage']) ? $_POST['homelanguage'] : '';
		$dob 					= isset($_POST['dob']) ? $_POST['dob'] : '';
		$status 				= isset($_POST['status']) ? $_POST['status'] : '';
		$maritalstatus 			= isset($_POST['maritalstatus']) ? $_POST['maritalstatus'] : '';
		$noofdependants 		= isset($_POST['noofdependants']) ? $_POST['noofdependants'] : '';
		$bankname 				= isset($_POST['bankname']) ? $_POST['bankname'] : '';
		
		$merchantnamecontactorwebsite = isset($_POST['merchantnamecontactorwebsite']) ? $_POST['merchantnamecontactorwebsite'] : '';
		
		
		$cellphonenumber 		= isset($_POST['cellphonenumber']) ? $_POST['cellphonenumber'] : '';
		$alternatenumber 		= isset($_POST['alternatenumber']) ? $_POST['alternatenumber'] : '';
		$emailaddress 			= isset($_POST['emailaddress']) ? $_POST['emailaddress'] : '';
		$confirmemailaddress 	= isset($_POST['confirmemailaddress']) ? $_POST['confirmemailaddress'] : '';
				
		$merchantidnumber 		= isset($_POST['merchantidnumber']) ? $_POST['merchantidnumber'] : '';		
		$merchantname 			= isset($_POST['merchantname']) ? $_POST['merchantname'] : '';
		$merchantprodname 		= isset($_POST['merchantprodname']) ? $_POST['merchantprodname'] : '';

		$username 				= isset($_POST['username']) ? $_POST['username'] : '';
		$password 				= isset($_POST['password']) ? $_POST['password'] : '';
		$confirmpassword 		= isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';
		
		$flag = 1;
		
		if(empty($firstname)){
			
			$errors['type'] = 'firstname';
			$errors['msg'] = '* Enter first name';
			$errorsFinal[] = $errors;
			$flag = 0;
		}

		if(empty($surname)){
			
			$errors['type'] = 'surname';
			$errors['msg'] = '* Enter surname';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($second_surname)){
			
			$errors['type'] = 'second_surname';
			$errors['msg'] = '* Enter second surname';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		
		if($_FILES['idproof']['name'] != ''){
			
			$allowedExt = array('pdf','jpg','jpeg');
			
			$ext = end(explode(".",$_FILES['idproof']['name']));
			
			if(!in_array($ext,$allowedExt)){
				
				$errors['type'] = 'idproof';
				$errors['msg'] = '* ID Proof attachment must be in '.implode(', ',$allowedExt).' format';
				$errorsFinal[] = $errors;
				$flag = 0;
			}
		}
		
		if(empty($dob)){
			
			$errors['type'] = 'dob';
			$errors['msg'] = '* Enter Date of Birth';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($status)){
			
			$errors['type'] = 'status';
			$errors['msg'] = '* Choose status';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($maritalstatus)){
			
			$errors['type'] = 'maritalstatus';
			$errors['msg'] = '* Choose marital status';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if($noofdependants == ''){
			
			$errors['type'] = 'noofdependants';
			$errors['msg'] = '* Enter no of dependants';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(!is_numeric($noofdependants)){
			
			$errors['type'] = 'noofdependants';
			$errors['msg'] = '* No of dependants must be numeric';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		
			
		if(empty($merchantidnumber)){
		
			$errors['type'] = 'merchantidnumber';
			$errors['msg'] = '* Enter merchant ID number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($merchantname)){
		
			$errors['type'] = 'merchantname';
			$errors['msg'] = '* Enter merchant name';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($merchantprodname)){
		
			$errors['type'] = 'merchantprodname';
			$errors['msg'] = '* Enter merchant product name';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($bankname)){
			
			$errors['type'] = 'bankname';
			$errors['msg'] = '* Select bank name';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
				
		if($_FILES['lastpayslip']['name'] == ''){
			
			$errors['type'] = 'lastpayslip';
			$errors['msg'] = '* Attach your last payslip';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else{
			
			$allowedExt = array('pdf');
			
			$ext = end(explode(".",$_FILES['lastpayslip']['name']));
			
			if(!in_array($ext,$allowedExt)){
				
				$errors['type'] = 'lastpayslip';
				$errors['msg'] = '* Payslip must be in '.implode(', ',$allowedExt).' format';
				$errorsFinal[] = $errors;
				$flag = 0;
			}
		}
		if(empty($cellphonenumber)){
			
			$errors['type'] = 'cellphonenumber';
			$errors['msg'] = '* Enter cell phone number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(!is_numeric($cellphonenumber)){
			
			$errors['type'] = 'cellphonenumber';
			$errors['msg'] = '* Cell phone number must be digits';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(strlen($cellphonenumber) != MOBILE_LENGTH){
			
			$errors['type'] = 'cellphonenumber';
			$errors['msg'] = '* Cell phone number must be of '.MOBILE_LENGTH.' digits';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else{
			
			
				$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_borrowers WHERE cellphonenumber = '".$cellphonenumber."'";
				$checkemailSql = mysqli_query($con,$checkemailQry) or die(mysqli_error());
				$checkemailRow = mysqli_fetch_row($checkemailSql);
				
				if(!empty($checkemailRow)){
					
					$errors['type'] = 'cellphonenumber';
					$errors['msg'] = '* Cell phone is already registered';
					$errorsFinal[] = $errors;
					$flag = 0;
				}
			
		}

		if(empty($username)){
			
			$errors['type'] = 'username';
			$errors['msg'] = '* Enter username';
			$errorsFinal[] = $errors;
			$flag = 0;
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
		
		if(empty($emailaddress)){
			
			$errors['type'] = 'emailaddress';
			$errors['msg'] = '* Enter email address';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(!filter_var($emailaddress, FILTER_VALIDATE_EMAIL)){
			
			$errors['type'] = 'emailaddress';
			$errors['msg'] = '* Enter proper email address';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(empty($confirmemailaddress)){
			
			$errors['type'] = 'confirmemailaddress';
			$errors['msg'] = '* Enter confirm email address';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if($emailaddress != $confirmemailaddress){
			
			$errors['type'] = 'confirmemailaddress';
			$errors['msg'] = '* Email address mismatch';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else{
							
			$checkemailRow = checkEmail($emailaddress,$con);			
			if(($checkemailRow) > 0){
				
				$errors['type'] = 'emailaddress';
				$errors['msg'] = '* Email address is already registered';
				$errorsFinal[] = $errors;
				$flag = 0;
			}
			
		}

		
		$errstr = json_encode($errorsFinal);
		
		
		if($flag == 1){
			
			$lastpayslip = '';
			$idproof = '';
			$budgetattachment = '';
			
			if($_FILES['lastpayslip']['name'] != ''){
				
				$randomStr = md5(uniqid(rand(), true));
				
				$filenameorig = $_FILES['lastpayslip']['name'];
				$filetmpname = $_FILES['lastpayslip']['tmp_name'];
				
				$ext = end(explode(".",$filenameorig));
				$filename = $randomStr.'.'.$ext;
				
				move_uploaded_file($filetmpname, 'backoffice/userfiles/'.$filename);
				
				$lastpayslip = $filename;
			}
			
			if($_FILES['idproof']['name'] != ''){
				
				$randomStr = md5(uniqid(rand(), true));
				
				$filenameorig = $_FILES['idproof']['name'];
				$filetmpname = $_FILES['idproof']['tmp_name'];
				
				$ext = end(explode(".",$filenameorig));
				$filename = $randomStr.'.'.$ext;
				
				move_uploaded_file($filetmpname, 'backoffice/userfiles/'.$filename);
				
				$idproof = $filename;
			}
			
			
			unset($_POST['stepcount']);
			
			
			$merchant_id = $_SESSION['userid'];	

				/*** Create Borrower wallet ****/
					$payerWallet = uniqid("PHP-Borrower-");
					$response = RegisterWallet(array(
						    "wlLogin" 			=> LOGIN,
						    "wlPass" 			=> PASSWORD,
						    "language" 			=> LANGUAGE,
						    "version" 			=> VERSION,
						    "walletIp" 			=> getUserIP(),
						    "walletUa" 			=> UA,
						    "wallet" 			=> $payerWallet,
						    "clientMail" 		=> $_POST['emailaddress'],
							"clientFirstName" 	=> $_POST['firstname'],
							"clientLastName" 	=> $_POST['surname']
						));

					if(isset($response->RegisterWalletResult->E)){
							if($response->RegisterWalletResult->E->Code==204){
			                    $GetWalletbyemailDetails= GetWalletbyemailDetails($customerdata['emailaddress']);
			                    if(!empty($GetWalletbyemailDetails->GetWalletDetailsResult->WALLET->ID)){
			                    	$receiverwalletid=$GetWalletbyemailDetails->GetWalletDetailsResult->WALLET->ID;
			                    	$wallet_balance=$GetWalletbyemailDetails->GetWalletDetailsResult->WALLET->BAL;
			                    }
							}else{
								$errors['type'] = 'emailaddress';
								$errors['msg'] =$response->RegisterWalletResult->E->Msg;
								$errorsFinal[] = $errors;
								$flag = 0;
								$errstr = json_encode($errorsFinal);
							}
						
					}else{
						$receiverwalletid=	$response->RegisterWalletResult->WALLET->ID;
						$wallet_balance=0.00;
						$checkStatus=UpdateWalletStatus($borrowerWalletid,6);
						if(isset($checkStatus->UpdateWalletStatusResult->E)){
							//$errors[]=$checkStatus->UpdateWalletStatusResult->E->Msg;
							$errors['type'] = 'emailaddress';
							$errors['msg'] = "There is some error";
							$errorsFinal[] = $errors;
							$flag = 0;
							$errstr = json_encode($errorsFinal);
						}
					}

					/*if(isset($response->RegisterWalletResult->E)){
						$errors[]=$response->RegisterWalletResult->E->Msg;
					}else{
						$receiverwalletid=	$response->RegisterWalletResult->WALLET->ID;
						$wherarr=array("id"=>$borrower_id);
						$updatearr=array("wallet_id"=>$receiverwalletid);
						updateQuery("backoffice_borrowers",$wherarr,$updatearr);
					}*/
				/*** Create Borrower wallet ****/

				if(!empty($receiverwalletid)){
					$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_borrowers SET
									  username = '".addslashes($_POST['username'])."',
									  firstname = '".addslashes($_POST['firstname'])."',
									  middlename = '".addslashes($_POST['middlename'])."',
									  surname = '".addslashes($_POST['surname'])."',
									  second_surname = '".addslashes($_POST['second_surname'])."',
									  homelanguage = '".addslashes($_POST['homelanguage'])."',
									  status = '".addslashes($_POST['status'])."',
									  maritalstatus = '".addslashes($_POST['maritalstatus'])."',
									  noofdependants = '".addslashes($_POST['noofdependants'])."',
									  workphonenumber = '".addslashes($_POST['workphonenumber'])."',
									  cellphonenumber = '".addslashes($_POST['cellphonenumber'])."',
									  alternatenumber = '".addslashes($_POST['alternatenumber'])."',
									  emailaddress = '".addslashes($_POST['emailaddress'])."',
									  password = '".addslashes(md5($_POST['password']))."',
									  hasmerchantid = '".addslashes($_POST['hasmerchantid'])."',
									  merchantidnumber = '".addslashes($_POST['merchantidnumber'])."',
									  merchantnamecontactorwebsite = '".addslashes($_POST['merchantnamecontactorwebsite'])."',
									  wallet_id= '".addslashes($receiverwalletid)."',
									  dob = '".addslashes($_POST['dob'])."',
									  createdate = '".addslashes(time())."'";
							  
					$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());					
					$borrower_id = mysqli_insert_id();
					if($borrower_id){
					

							$product_name = $_POST['merchantprodname'];											
							$from_merchant = '1';
							$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_loan_applications SET
										  loan_amount = '".addslashes($_SESSION['customerdata']['amount'])."',
										  loan_terms = '".addslashes($_SESSION['customerdata']['term'])."',
										  loan_apr = '".$config['default_apr']."',
										  borrower_id = '".addslashes($borrower_id)."',
										  merchant_id = '".addslashes($merchant_id)."',
										  product_name = '".addslashes($product_name)."',
										  createdate = '".addslashes(time())."',
										  from_merchant = '".addslashes($from_merchant)."',
										  bank_id = '".addslashes($bankname)."',
										  status = 'borrower_pending'";
										  
							$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());					
							$loan_id = mysqli_insert_id();

							if($loan_id){
								$request = curl_init(BASE_URL.'backoffice/borrowerlogindetails/'.$borrower_id.'/'.$_POST['password']."/".$loan_id);
								curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
								$response = curl_exec($request);
								curl_close($request);
							}
										
							$loan_unique_id = 'SC-'.date('Y').'-'.(str_pad($loan_id,2,0,STR_PAD_LEFT));
							
							$updateSql = "UPDATE ".TABLE_PREFIX."backoffice_loan_applications SET 
										  unique_id = '".addslashes($loan_unique_id)."'
										  WHERE id = '".$loan_id."'";
										  
							mysqli_query($con,$updateSql) or die(mysqli_error());	
							
							
							$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_loan_documents SET
										  loan_id = '".addslashes($loan_id)."',
										  document_type = 'lastpayslip',
										  type = 'useruploaded',
										  document_path = '".addslashes($lastpayslip)."',
										  createdate = '".addslashes($time)."'";
										  
							$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());	


							
							if(!empty($idproof)){
								
								$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_loan_documents SET
											  loan_id = '".addslashes($loan_id)."',
											  document_type = 'idproof',
											  type = 'useruploaded',
											  document_path = '".addslashes($idproof)."',
											  createdate = '".addslashes(time())."'";
											  
								$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());	
							}
							
							/*			
							$request = curl_init(BASE_URL.'backoffice/generatepdf/'.$loan_id);
							curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
							$response = curl_exec($request);
							curl_close($request);
							*/
							
							
							$stepscovered[] = 'step3';
							$_SESSION['steps'] = $stepscovered;
							
							$stepscovered[] = 'thankyou';
							$_SESSION['steps'] = $stepscovered;
							header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloanbymerchant/thankyou');
							exit;
				  }
				}else{

				}				
	}

	/*else if($stepcount == 'step3'){
		
		$privacy_agree 			= isset($_POST['privacy_agree']) ? $_POST['privacy_agree'] : '';
		$legal_information 		= isset($_POST['legal_information']) ? $_POST['legal_information'] : '';
		
		$flag = 1;
		
		if(empty($privacy_agree)){
			
			$errors['type'] = 'privacy_agree_label';
			$errors['msg'] = '* Check if you agree to our privacy policy';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($legal_information)){
			
			$errors['type'] = 'legal_information_label';
			$errors['msg'] = '* Check if you agree to our legal information';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		
		$errstr = json_encode($errorsFinal);
		
		//echo '<pre>'; print_r($errorsFinal); //exit;
		if($flag == 1){
			unset($_POST['stepcount']);
			$_SESSION['customerdata'] = array_merge($_SESSION['customerdata'],$_POST);
			
			$stepscovered[] = 'step4';
			$_SESSION['steps'] = $stepscovered;
			
			$mobile = COUNTRY_PREFIX.$_SESSION['customerdata']['cellphonenumber'];
			
			$randomCode = rand(100000,999999);
			
			$message = $randomCode." is your 6 digit verification code for ".PROJECT_NAME;
			
			$_SESSION['customerdata']['otpsent'] = $randomCode;
			
			sendsms($mobile,$message);
			
			header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloanbymerchant/step6');
			exit;
		}
	}
	else if($stepcount == 'step4'){
		
		$verify_code 			= isset($_POST['verify_code']) ? $_POST['verify_code'] : '';
		
		$flag = 1;
		
		if(empty($verify_code)){
			
			$errors['type'] = 'verify_code';
			$errors['msg'] = '* Enter mobile verification code';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(!is_numeric($verify_code)){
			
			$errors['type'] = 'verify_code';
			$errors['msg'] = '* Mobile verification code must be numeric';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(strlen($verify_code) != 6){
			
			$errors['type'] = 'verify_code';
			$errors['msg'] = '* Mobile verification code must be of 6 digits';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if($verify_code != $_SESSION['customerdata']['otpsent']){
			
			$errors['type'] = 'verify_code';
			$errors['msg'] = '* Invalid verification code';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		
		$errstr = json_encode($errorsFinal);
		if($flag == 1){
		
			$updateQry = "UPDATE ".TABLE_PREFIX."backoffice_borrowers SET
						  mobile_verified = '1'
						  WHERE id = '".$_SESSION['customerdata']['borrowerid']."'";
			
			mysql_query($updateQry) or die(mysql_error());	
			
			$stepscovered[] = 'thankyou';
			$_SESSION['steps'] = $stepscovered;
			
			header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloanbymerchant/thankyou');
			exit;
		}
	}*/
 }
}

?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container loanpagecontainer">
	
		<!-- Form -->
		<?php
		if($step == 'step1'){
			
			unset($_SESSION['steps']);
			unset($_SESSION['customerdata']);
			
			?>
			<section>
				<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
				
					<input type="hidden" name="stepcount" value="<?=$step?>">
					<input type="hidden" name="type" value="<?=$type?>">
						
					<table class="getrates">
						
						<tr>
							
							<td colspan="3" class="loanamountheading">
								
								<span><?php echo($transArr['I want to get a loan for']); ?> </span><input type="number" name="loanamount" id="loanamount" value="<?php echo($config['minimum_amount']); ?>" step="100" min="<?php echo($config['minimum_amount']); ?>" max="<?php echo($config['maximum_amount']); ?>" required>
								
								<div id="slider"></div>
							
							</td>
						
						</tr>
						
						<tr>
							<th><?php echo($transArr['Term']); ?></th>
							<th><?php echo($transArr['Annual Interest']); ?></th>
							<th><?php echo($transArr['Monthly Cost']); ?></th>
						</tr>
						
						<?php
						foreach($terms as $vterm){
							
							?>
							<tr>
								<td>
									
									<input type="radio" name="loanterm" id="loanterm<?=$vterm?>" value="<?=$vterm?>" required <?=$vterm == 3 ? 'checked' : ''?>>
									<label for="loanterm<?=$vterm?>" class="termlabel"><?=$vterm?> <?php echo($transArr['months']); ?></label>
									
								</td>
								<td><span class="calcapr" data-val="<?=$vterm?>"></span></td>
								<td><span class="calcmoncost" data-val="<?=$vterm?>"></span></td>
							</tr>
							<?php
						}
						?>
						
					</table>
					
					<div class="12u$ formbtn">
						<ul class="actions">
							<li><input type="submit" value="<?php echo($transArr['Continue']); ?>" class="special" /></li>
						</ul>
					</div>

				</form>
			</section>
			<footer>
				<h2><?php echo($allcontents[50]['sectionTitle']); ?></h2>
				<p><?php echo($allcontents[50]['sectionDesc']); ?></p>
			</footer>
			<?php
		}
		else if($step == 'step2'){
			
			?>
			<header class="major personaldetails">
				<h2 class="loantakeninfo"><?php echo($transArr['You have chosen a loan amount of']); ?> <?=$_SESSION['customerdata']['amount']?>&euro; <?php echo($transArr['for the period of']); ?> <?=$_SESSION['customerdata']['term']?> <?php echo($transArr['months']); ?>.</h2>
				<p><?php echo($transArr['Provide your personal details below']); ?>.</p>
			</header>
			
			<section>
				
				<form method="post" action="<?=$_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
				
					<input type="hidden" name="stepcount" value="<?=$step?>">
					<input type="hidden" name="merchant_id" value="<?=$_SESSION['userid']?>">
				
					<h2><?php echo($transArr['Personal Details']); ?></h2>
				
					<h3><?php echo($transArr['Your Name']); ?></h3>
					<div class="row uniform 50%">
						
						<div class="4u 12u$(4)">
							<input type="text" name="firstname" id="firstname" value="<?php echo($firstname); ?>" placeholder="<?php echo($transArr['First Name']); ?>" <?php echo(in_array('firstname',$readonly) ? 'class="disabled"' : ''); ?> />
						</div>
						<?php /* ?><div class="4u 12u$(4)">
							<input type="text" name="middlename" id="middlename" value="<?php echo($middlename); ?>" placeholder="<?php echo($transArr['Middle Name']); ?>" />
						</div><?php */ ?>
						<div class="4u 12u$(4)">
							<input type="text" name="surname" id="surname" value="<?php echo($surname); ?>" placeholder="<?php echo($transArr['Surname']); ?>"  <?php echo(in_array('surname',$readonly) ? 'class="disabled"' : ''); ?> />
						</div>
						<div class="4u 12u$(4)">
							<input type="text" name="second_surname" id="second_surname" value="<?php echo($second_surname); ?>" placeholder="<?php echo($transArr['Second Surname']); ?>"  <?php echo(in_array('second_surname',$readonly) ? 'class="disabled"' : ''); ?> />
						</div>
						<div class="4u$ 12u$(4)">
							<input type="text" name="dob" id="dob" value="<?php echo($dob); ?>" placeholder="<?php echo($transArr['Date of Birth']); ?>" readonly <?php echo(in_array('dob',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
					</div>
					
					<h3>Your Details</h3>
					
					<div class="row uniform 50%">						
						<div class="12u$ 12u$(6)">
							<div class="fileholder"><?php echo($transArr['ID proof Attachment (Optional)']); ?> : <input type="file" name="idproof" id="idproof"></div>
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<div class="4u 12u$(4)">
							<div class="select-wrapper">
								<select name="status" id="status" <?php echo(in_array('status',$readonly) ? 'class="disabled"' : ''); ?> >
									<option value="">- <?php echo($transArr['Status']); ?> -</option>
									
									<?php
									foreach($values['status'] as $key=>$val){
										
										?>
										<option value="<?=$key?>" <?php echo($status == $key ? 'selected' : ''); ?>><?=$val?></option>
										<?php
									}
									?>
									
								</select>
							</div>
						</div>
						<div class="4u 12u$(4)">
							<div class="select-wrapper">
								<select name="maritalstatus" id="maritalstatus" <?php echo(in_array('maritalstatus',$readonly) ? 'class="disabled"' : ''); ?>>
									<option value="">- <?php echo($transArr['Marital Status']); ?> -</option>
									
									<?php
									foreach($values['marital_status'] as $key=>$val){
										
										?>
										<option value="<?=$key?>" <?php echo($maritalstatus == $key ? 'selected' : ''); ?>><?=$val?></option>
										<?php
									}
									?>
									
								</select>
							</div>
						</div>
						<div class="4u$ 12u$(4)">
							<?php /* ?><input type="text" name="noofdependants" id="noofdependants" value="<?php echo($noofdependants); ?>" placeholder="<?php echo($transArr['Number of Dependants']); ?>" /><?php */ ?>
							
							<div class="select-wrapper">
								<select name="noofdependants" id="noofdependants" <?php echo(in_array('noofdependants',$readonly) ? 'class="disabled"' : ''); ?>>
									<option value="0">- <?php echo($transArr['Number of Dependants']); ?> -</option>
									
									<?php
									for($i=1;$i<=5;$i++){
										
										?>
										<option value="<?=$i?>" <?php echo($noofdependants == $i ? 'selected' : ''); ?>><?=$i?></option>
										<?php
									}
									?>
									
								</select>
							</div>
							
						</div>
					</div>
					
					<h3><?php echo($transArr['Merchant Details']); ?></h3>
					<div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input type="text" name="merchantidnumber" id="merchantidnumber" value="<?php echo($_SESSION['id']); ?>" readonly placeholder="<?php echo($transArr['ID Number']); ?>" />
						</div>
						<div class="6u$ 12u$(6)">
							<input type="text" name="merchantname" id="merchantname" value="<?php echo($_SESSION['name']); ?>" readonly placeholder="<?php echo($transArr['Merchant Name']); ?>" />
						</div>
					</div>
					<div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input type="text" name="merchantprodname" id="merchantprodname" value="<?php echo($merchantprodname); ?>" placeholder="<?php echo($transArr['Product Name']); ?>" />
						</div>
						
					</div>
					
					<?php if($_SESSION['customerdata']['type'] == 'merchant'){ ?>
						<h3><?php echo($transArr['Bank List']); ?></h3>
						<div class="row uniform 50%">						
							<div class="6u 12u$(6)">
								<div class="select-wrapper">
								<select name="bankname" id="bankname">
									<option value="0">- <?php echo($transArr['Bank List Option']); ?> -</option>
									
									<?php
									foreach($values['bank_list'] as $key=>$val){
										
										?>
										<option value="<?=$key?>" <?php echo($bankname == $key ? 'selected' : ''); ?>><?=$val?></option>
										<?php
									}
									?>
									
								</select>
							</div>
							</div>
							
						</div>
					<?php } ?>
					
					<h3>Contacting You</h3>

					<div class="row uniform 50%">						
						<div class="12u$">
							<div class="fileholder"><?php echo($transArr['Doctor budget']); ?> : <input type="file" name="lastpayslip" id="lastpayslip"></div>
						</div>
					</div>

					<div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input type="text" name="cellphonenumber" id="cellphonenumber" value="<?php echo($cellphonenumber); ?>" placeholder="<?php echo($transArr['Cell Phone Number']); ?>"  <?php echo(in_array('cellphonenumber',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						<div class="6u$ 12u$(6)">
							<input type="text" name="alternatenumber" id="alternatenumber" value="<?php echo($alternatenumber); ?>" placeholder="<?php echo($transArr['Alternate Number']); ?>"  <?php echo(in_array('alternatenumber',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input type="text" name="emailaddress" id="emailaddress" value="<?php echo($emailaddress); ?>" placeholder="<?php echo($transArr['Email Address']); ?>"  <?php echo(in_array('emailaddress',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						<div class="6u$ 12u$(6)">
							<input type="text" name="confirmemailaddress" id="confirmemailaddress" value="<?php echo($confirmemailaddress); ?>" placeholder="<?php echo($transArr['Confirm Email Address']); ?>"  <?php echo(in_array('emailaddress',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
					</div>

					<div class="row uniform 50%">
						
						<div class="12u$">
							<input type="text" name="username" id="username" value="<?php echo($username); ?>" placeholder="<?php echo($transArr['User Name']); ?>" />
						</div>
						<div class="12u$">
							<input type="password" name="password" id="password" value="<?php echo($password); ?>" placeholder="<?php echo($transArr['Choose Password']); ?>" />
						</div>
						<div class="12u$">
							<input type="password" name="confirmpassword" id="confirmpassword" value="<?php echo($confirmpassword); ?>" placeholder="<?php echo($transArr['Confirm Password']); ?>" />
						</div>
						
						
					</div>

					
										
					<div class="row uniform 50%">						
						<div class="12u$">
							<ul class="actions">
								<li><input type="submit" value="<?php echo($transArr['Continue']); ?>" class="special" /></li>
							</ul>
						</div>
					</div>
					
				</form>
				
			</section>
			<?php
		}else if($step == 'step3'){ ?>
			
			<header class="major">
				<h2 class="loansuccesstxt"><?php echo($transArr['You are almost there']); ?>!</h2>
			</header>
			
			<section>
				
				<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
					
					<input type="hidden" name="stepcount" value="<?=$step?>">
					
					<div class="row uniform 50%">						
						<div class="12u$">
							<p><?php echo($transArr['For your loan approval you need to accept our privacy policy and terms and conditions. Please tick the checkboxes below if you agree.']); ?>.</p>
						</div>
					</div>
					
					<div class="row uniform 50% successterms">						
						<div class="12u$">
							<input type="checkbox" name="privacy_agree" value="yes" id="privacy_agree"/>
							<label for="privacy_agree" class="termlabel" id="privacy_agree_label">&nbsp; <?php echo($transArr['By clicking I do agree with the']); ?> <a href="<?=BASE_URL.$getLang?>/p/privacy-policy" target="_blank"><?php echo($transArr['Privacy Policy']); ?></a> <?php echo($transArr['of the website']); ?>.</label>
						</div>
						<div class="12u$">
							<input type="checkbox" name="legal_information" value="yes" id="legal_information"/>
							<label for="legal_information" class="termlabel" id="legal_information_label">&nbsp; <?php echo($transArr['By clicking I do agree with the']); ?> <a href="<?=BASE_URL.$getLang?>/p/terms-conditions" target="_blank"><?php echo($transArr['Legal Information']); ?></a> <?php echo($transArr['of the website']); ?>.</label>
						</div>
					</div>
					
					<div class="row uniform 50% successnotes">						
						<div class="12u$">
							
							
							<h4><?php echo($allcontents[53]['sectionTitle']); ?></h4>
							<?php echo($allcontents[53]['sectionDesc']); ?>
							
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<div class="12u$">
							<ul class="actions">
								<li><input type="submit" value="<?php echo($transArr['Submit Application']); ?>" class="special" /></li>
							</ul>
						</div>
					</div>
					
				</form>
				
			</section>
			
			<?php
		}
		else if($step == 'step6'){
			?>
			
			<header class="major">
				<h2><?php echo($transArr['Mobile Verification']); ?></h2>
				<p><?php echo($transArr['A 6 digit verification code has been sent to your mobile number. Please enter it in the below textbox to verify your cell number.']); ?>.</p>
				<p><?php echo($transArr['Mobile verification confirmation']); ?>.</p>
			</header>
			
			<section>
				
				<form method="post" action="<?=$_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
					
					<input type="hidden" name="stepcount" value="<?=$step?>">
				
					<div class="row uniform 50%">
						
						<div class="12u$">
							<input type="text" name="verify_code" id="verify_code" value="" placeholder="<?php echo($transArr['Enter Verification Code']); ?>" />
						</div>
						
					</div>
					
					<div class="row uniform 50%">						
						<div class="12u$">
							<ul class="actions">
								<li><input type="submit" value="<?php echo($transArr['Submit']); ?>" class="special" /></li>
							</ul>
						</div>
					</div>
					
				</form>
				
			</section>
			
			<?php
		}
		else if($step == 'thankyou'){
			
			unset($_SESSION['steps']);
			unset($_SESSION['customerdata']);
			?>
			<header class="major">
				<h2 class="loansuccesstxt"><?php echo($transArr['Success']); ?>!</h2>
			</header>
			
			<section>
				
				<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
					
					<input type="hidden" name="stepcount" value="<?=$step?>">
				
					<div class="row uniform 50%">						
						<div class="12u$ loansuccess">
							<p class="loanacceptedtxt"><?php echo($transArr['Your loan application has been submitted']); ?>!</p>
						</div>
					</div>
					<div class="row uniform 50%">						
						<div class="12u$ loansuccess">
							<p class="loanacceptedtxt"><?php echo($transArr['You will receive an answer in your email address, shortly.']); ?></p>
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<div class="12u$">
							<p><?php echo($transArr['Contractual information will be sent to your email address once your loan application is approved. It will take short time to review your details. Please be patient.']); ?>.</p>
						</div>
					</div>
					
					<div class="row uniform 50% successnotes">						
						<div class="12u$">
							<h4><?php echo($transArr['Important Notes']); ?>:</h4>
							<ul>
								<li><?php echo($transArr['Once the loan is approved, the amount will be sent to the account of the establishment with which you have contracted.']); ?></li>
								<li><?php echo($transArr['Depending on the bank with which the establishment works, the transfer may take more or less time to become effective.']); ?></li>
								<li><?php echo($transArr['Remember to pay every day 1 of each month.']); ?></li>
							</ul>
						</div>
					</div>
					
				</form>
				
			</section>
			
			<?php
		}
		?>
		
	</div>
</section>

<script>

$( function() {
	$( "#slider" ).slider({
	  
		min: parseInt('<?php echo($config['minimum_amount']); ?>'),
		max: parseInt('<?php echo($config['maximum_amount']); ?>'),
		step: 100,
		slide: function( event, ui ) {
			$('#loanamount').val( ui.value );
			
			popaprandcost(ui.value);
		}
		
	});
	
	$( "#dob" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1940:<?php echo(date('Y')); ?>",
		dateFormat: 'dd/mm/yy',
		showAnim : 'drop'
	});
	
} );


var months = [<?php echo($config['loan_months']); ?>];

var resultcalc = [];

var apr = parseInt('<?php echo($config['default_apr']); ?>');

var amount = parseInt('<?php echo($config['minimum_amount']); ?>');

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
	
	popaprandcost(amount);
	
	$(document).on('change','#loanamount',function(){
		
		var amt = $(this).val();
		
		popaprandcost(amt);
	});
	
	$('select,input[type=text],input[type=password],input[type=file]').on('keyup change keypress blur',function(){
		
		var val = $(this).val();
		
		if(val != ''){
			
			$(this).removeClass('errbrdr');
			$(this).next('.errtxt').remove();
		}
		
	});
	
	$('#privacy_agree, #legal_information').on('change',function(){
		
		$(this).next().removeClass('errbrdr');
		$(this).next().next('.errtxt').remove();
		
	});
	
	$('.hasmerchantid').on('change',function(){
		
		$(this).parent().removeClass('errbrdr');
		$(this).parent().next('.errtxt').remove();
		
	});
	
	$('.btngetloanbymerchantstart').click(function(){
		
		$('html,body').animate({scrollTop: $('.loanpagecontainer').offset().top-40}, 1000);
		
	});
	
	$('.hasmerchantid').change(function(){
		
		var val = $(this).val();
		
		$('.merchntdet').hide();
		
		if(val == 'yes'){
			
			$('#merchantidcontainer').fadeIn('fast');
		}
		else if(val == 'no'){
			
			$('#merchantdetailscontainer').fadeIn('fast');
		}
		
	});
	
});

function popaprandcost(amount){
	
	var initialcalc = calculatemonthlyamount(amount);
	
	$('.calcapr').each(function(){
		
		var dataval = $(this).attr('data-val');
		
		var valtopop = initialcalc[dataval].apr+'%';
		
		$(this).text(valtopop);
		
	});
	
	$('.calcmoncost').each(function(){
		
		var dataval = $(this).attr('data-val');
		
		var valtopop = (initialcalc[dataval].monthlycost).toFixed(2)+' €';
		
		$(this).text(valtopop);
		
	});
}

function calculatemonthlyamount(amount){
	
	months.forEach(function(month){
		
		var p = parseInt(amount);
		var j = apr/(12*100);
		var n = month;

		var m = (p*j)/(1-Math.pow((1+j),-n));
		
		resultcalc[month] = {
			
			apr : apr,
			monthlycost : m
		}
		
	});
	
	return resultcalc;
}

</script>

<?php 
require_once('footer.php');
?>
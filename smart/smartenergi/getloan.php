<?php 
require_once('header.php');
$step = isset($_REQUEST['step']) ? $_REQUEST['step'] : '';

if($step == 'step1')	require_once('getloanbanner.php');

$type = isset($_SESSION['userid']) && !empty($_SESSION['userid']) ? $_SESSION['usertype'] : '';

$stepscovered = isset($_SESSION['steps']) && !empty($_SESSION['steps']) ? array_unique($_SESSION['steps']) : ['step1'];


$_SESSION['steps'] = array_values($_SESSION['steps']);

//echo '<pre>'; print_r($_SESSION['steps']); exit;


if(!isset($_SESSION['steps']) && $step != 'step1'){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloan/step1');
	exit;
}
else{
	
	$lastStepCovered = $_SESSION['steps'][count($_SESSION['steps'])-1];
	
	if($step != $lastStepCovered && $lastStepCovered != '' && $step != 'step1'){
		
		header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloan/'.$lastStepCovered);
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

$variables = getVariables($langID,$con);

$values = array_merge($variables,$values);

//echo '<pre>'; print_r($values); exit;


// Get Borrower Details

$borrowerdata = [];

if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
	
	$getborrowerdata = "SELECT * FROM ".TABLE_PREFIX."backoffice_borrowers WHERE id = '".$_SESSION['userid']."'";
				   
	$getborrowerdata = mysqli_query($con,$getborrowerdata) or die(mysqli_error());

	$getborrowerdata = mysqli_fetch_assoc($getborrowerdata);
	
	$borrowerdata = $getborrowerdata;
	
	unset($borrowerdata['merchantidnumber']);
	unset($borrowerdata['hasmerchantid']);
	unset($borrowerdata['merchantidnumber']);
	unset($borrowerdata['loanpurpose']);
	unset($borrowerdata['merchantnamecontactorwebsite']);
	
	$firstname 				= isset($borrowerdata['firstname']) ? $borrowerdata['firstname'] : '';
	$middlename 			= isset($borrowerdata['middlename']) ? $borrowerdata['middlename'] : '';
	$surname 				= isset($borrowerdata['surname']) ? $borrowerdata['surname'] : '';
	$second_surname 		= isset($borrowerdata['second_surname']) ? $borrowerdata['second_surname'] : '';
	$idnumber 				= isset($borrowerdata['idnumber']) ? $borrowerdata['idnumber'] : '';
	$homelanguage 			= isset($borrowerdata['homelanguage']) ? $borrowerdata['homelanguage'] : '';
	$dob 					= isset($borrowerdata['dob']) ? $borrowerdata['dob'] : '';
	$status 				= isset($borrowerdata['status']) ? $borrowerdata['status'] : '';
	$maritalstatus 			= isset($borrowerdata['maritalstatus']) ? $borrowerdata['maritalstatus'] : '';
	$noofdependants 		= isset($borrowerdata['noofdependants']) ? $borrowerdata['noofdependants'] : '';
	
	$hasmerchantid 			= isset($borrowerdata['hasmerchantid']) ? $borrowerdata['hasmerchantid'] : '';
	$merchantidnumber 		= isset($borrowerdata['merchantidnumber']) ? $borrowerdata['merchantidnumber'] : '';
	$loanpurpose 			= isset($borrowerdata['loanpurpose']) ? $borrowerdata['loanpurpose'] : '';
	$merchantnamecontactorwebsite = isset($borrowerdata['merchantnamecontactorwebsite']) ? $borrowerdata['merchantnamecontactorwebsite'] : '';
	
	$employmenttype 		= isset($borrowerdata['employmenttype']) ? $borrowerdata['employmenttype'] : '';
	$employercompanyname 	= isset($borrowerdata['employercompanyname']) ? $borrowerdata['employercompanyname'] : '';
	$grossmonthlyincome 	= isset($borrowerdata['grossmonthlyincome']) ? $borrowerdata['grossmonthlyincome'] : '';
	$netmonthlyincome 		= isset($borrowerdata['netmonthlyincome']) ? $borrowerdata['netmonthlyincome'] : '';
	$servicetype 			= isset($borrowerdata['servicetype']) ? $borrowerdata['servicetype'] : '';
	$timewithemployer 		= isset($borrowerdata['timewithemployer']) ? $borrowerdata['timewithemployer'] : '';
	$university 			= isset($borrowerdata['university']) ? $borrowerdata['university'] : '';
	$timeatuniversity 		= isset($borrowerdata['timeatuniversity']) ? $borrowerdata['timeatuniversity'] : '';
	$division 				= isset($borrowerdata['division']) ? $borrowerdata['division'] : '';
	$timeinservice 			= isset($borrowerdata['timeinservice']) ? $borrowerdata['timeinservice'] : '';
	$workphonenumber 		= isset($borrowerdata['workphonenumber']) ? $borrowerdata['workphonenumber'] : '';
	$frequencyofincome 		= isset($borrowerdata['frequencyofincome']) ? $borrowerdata['frequencyofincome'] : '';
	$nextpaydate 			= isset($borrowerdata['nextpaydate']) ? $borrowerdata['nextpaydate'] : '';
	$cellphonenumber 		= isset($borrowerdata['cellphonenumber']) ? $borrowerdata['cellphonenumber'] : '';
	$alternatenumber 		= isset($borrowerdata['alternatenumber']) ? $borrowerdata['alternatenumber'] : '';
	$emailaddress 			= isset($borrowerdata['emailaddress']) ? $borrowerdata['emailaddress'] : '';
	$confirmemailaddress 	= isset($borrowerdata['emailaddress']) ? $borrowerdata['emailaddress'] : '';
	$housenumber 			= isset($borrowerdata['housenumber']) ? $borrowerdata['housenumber'] : '';
	$streetname 			= isset($borrowerdata['streetname']) ? $borrowerdata['streetname'] : '';
	$suburb 				= isset($borrowerdata['suburb']) ? $borrowerdata['suburb'] : '';
	$city 					= isset($borrowerdata['city']) ? $borrowerdata['city'] : '';
	$province 				= isset($borrowerdata['province']) ? $borrowerdata['province'] : '';
	$postcode 				= isset($borrowerdata['postcode']) ? $borrowerdata['postcode'] : '';
	
	$bankname 				= isset($borrowerdata['bankname']) ? $borrowerdata['bankname'] : '';
	//$accountnumber 			= isset($borrowerdata['accountnumber']) ? $borrowerdata['accountnumber'] : '';
	//$bicnumber 				= isset($borrowerdata['bicnumber']) ? $borrowerdata['bicnumber'] : '';
	$ibannumber 			= isset($borrowerdata['ibannumber']) ? $borrowerdata['ibannumber'] : '';
	$nameofaccountholder 	= isset($borrowerdata['nameofaccountholder']) ? $borrowerdata['nameofaccountholder'] : '';
	$timewithbank 			= isset($borrowerdata['timewithbank']) ? $borrowerdata['timewithbank'] : '';
	$nameoncard 			= isset($borrowerdata['nameoncard']) ? $borrowerdata['nameoncard'] : '';
	$cardnumber 			= isset($borrowerdata['cardnumber']) ? $borrowerdata['cardnumber'] : '';
	$expirymonth 			= isset($borrowerdata['expirymonth']) ? $borrowerdata['expirymonth'] : '';
	$expiryyear 			= isset($borrowerdata['expiryyear']) ? $borrowerdata['expiryyear'] : '';
	$cvvnumber 				= isset($borrowerdata['cvvnumber']) ? $borrowerdata['cvvnumber'] : '';
	$dninie        			= isset($borrowerdata['dninie']) ? $borrowerdata['dninie'] : '';
	
	$readonly = [];
	
	foreach($borrowerdata as $kdata=>$vdata){
		
		$readonly[] = $kdata;
	}
}

//echo '<pre>'; print_r($borrowerdata); //exit;


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
		$userlogininapi=userLogin();
		$_SESSION['userlogininapi']=$userlogininapi;
		header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloan/step2');
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
		$idnumber 				= isset($_POST['idnumber']) ? $_POST['idnumber'] : '';
		$homelanguage 			= isset($_POST['homelanguage']) ? $_POST['homelanguage'] : '';
		$dob 					= isset($_POST['dob']) ? $_POST['dob'] : '';
		$status 				= isset($_POST['status']) ? $_POST['status'] : '';
		$maritalstatus 			= isset($_POST['maritalstatus']) ? $_POST['maritalstatus'] : '';
		$noofdependants 		= isset($_POST['noofdependants']) ? $_POST['noofdependants'] : '';
		
		$hasmerchantid 			= isset($_POST['hasmerchantid']) ? $_POST['hasmerchantid'] : '';
		$merchantidnumber 		= isset($_POST['merchantidnumber']) ? $_POST['merchantidnumber'] : '';
		$loanpurpose 			= isset($_POST['loanpurpose']) ? $_POST['loanpurpose'] : '';
		$merchantnamecontactorwebsite = isset($_POST['merchantnamecontactorwebsite']) ? $_POST['merchantnamecontactorwebsite'] : '';
		
		$employmenttype 		= isset($_POST['employmenttype']) ? $_POST['employmenttype'] : '';
		$employercompanyname 	= isset($_POST['employercompanyname']) ? $_POST['employercompanyname'] : '';
		$grossmonthlyincome 	= isset($_POST['grossmonthlyincome']) ? $_POST['grossmonthlyincome'] : '';
		$netmonthlyincome 		= isset($_POST['netmonthlyincome']) ? $_POST['netmonthlyincome'] : '';
		$servicetype 			= isset($_POST['servicetype']) ? $_POST['servicetype'] : '';
		$timewithemployer 		= isset($_POST['timewithemployer']) ? $_POST['timewithemployer'] : '';
		$university 			= isset($_POST['university']) ? $_POST['university'] : '';
		$timeatuniversity 		= isset($_POST['timeatuniversity']) ? $_POST['timeatuniversity'] : '';
		$division 				= isset($_POST['division']) ? $_POST['division'] : '';
		$timeinservice 			= isset($_POST['timeinservice']) ? $_POST['timeinservice'] : '';
		$workphonenumber 		= isset($_POST['workphonenumber']) ? $_POST['workphonenumber'] : '';
		$frequencyofincome 		= isset($_POST['frequencyofincome']) ? $_POST['frequencyofincome'] : '';
		$nextpaydate 			= isset($_POST['nextpaydate']) ? $_POST['nextpaydate'] : '';
		$cellphonenumber 		= isset($_POST['cellphonenumber']) ? $_POST['cellphonenumber'] : '';
		$alternatenumber 		= isset($_POST['alternatenumber']) ? $_POST['alternatenumber'] : '';
		$emailaddress 			= isset($_POST['emailaddress']) ? $_POST['emailaddress'] : '';
		$confirmemailaddress 	= isset($_POST['confirmemailaddress']) ? $_POST['confirmemailaddress'] : '';
		$housenumber 			= isset($_POST['housenumber']) ? $_POST['housenumber'] : '';
		$streetname 			= isset($_POST['streetname']) ? $_POST['streetname'] : '';
		$suburb 				= isset($_POST['suburb']) ? $_POST['suburb'] : '';
		$city 					= isset($_POST['city']) ? $_POST['city'] : '';
		$province 				= isset($_POST['province']) ? $_POST['province'] : '';
		$postcode 				= isset($_POST['postcode']) ? $_POST['postcode'] : '';
		
		$merchantidnumber 		= isset($_POST['merchantidnumber']) ? $_POST['merchantidnumber'] : '';
		$merchantname 			= isset($_POST['merchantname']) ? $_POST['merchantname'] : '';
		$merchantprodname 		= isset($_POST['merchantprodname']) ? $_POST['merchantprodname'] : '';
		$merchantamountlended 	= isset($_POST['merchantamountlended']) ? $_POST['merchantamountlended'] : '';
		$dninie        			= isset($_POST['dninie']) ? $_POST['dninie'] : '';

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
		/*if(empty($second_surname)){
			
			$errors['type'] = 'second_surname';
			$errors['msg'] = '* Enter second surname';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($idnumber)){
			
			$errors['type'] = 'idnumber';
			$errors['msg'] = '* Enter ID number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}*/

		if(empty($dninie)){
					$errors['type'] = 'dninie';
					$errors['msg'] = '* Select Borrower DNI/NIE Type';
					$errorsFinal[] = $errors;
					$flag = 0;
		}else{
			if(empty($idnumber)){	
				$errors['type'] = 'idnumber';
				$errors['msg'] = '* Enter Borrower '.ucfirst($dninie).' number';
				$errorsFinal[] = $errors;
				$flag = 0;
			}else{
				if($dninie=="dni"){
					$regex = '/^[0-9]{8}[A-Z]$/';
					preg_match_all($regex, $idnumber, $matches, PREG_SET_ORDER, 0);		
					if(!count($matches)){			
						$errors['type'] = 'idnumber';
						$errors['msg'] = '* Borrower '.ucfirst($dninie).' number must be of 8 Digits and 1 Capital Letter ';
						$errorsFinal[] = $errors;
						$flag = 0;
					}
				}else if($dninie=="nie"){
					$regex = '/^[A-Z][0-8]{7}[A-Z]$/';
					preg_match_all($regex,$idnumber, $matches, PREG_SET_ORDER, 0);		
					if(!count($matches)){			
						$errors['type'] = 'idnumber';
						$errors['msg'] = '* Borrower '.ucfirst($dninie).' number must be of 1 Capital Letter , 7 Digits and 1 Capital Letter';
						$errorsFinal[] = $errors;
						$flag = 0;
					}
				}
			}
		}

		/* else{
		
			$regex = '/^[0-9]{8}[A-Z]$/';

			preg_match_all($regex, $idnumber, $matches, PREG_SET_ORDER, 0);
			
			if(!count($matches)){
				
				$errors['type'] = 'idnumber';
				$errors['msg'] = '* ID must be of 8 numbers and 1 letters';
				$errorsFinal[] = $errors;
				$flag = 0;
			}
		} */
		/* if(empty($homelanguage)){
			
			$errors['type'] = 'homelanguage';
			$errors['msg'] = '* Enter home language';
			$errorsFinal[] = $errors;
			$flag = 0;
		} */
		
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
		
		if($_SESSION['customerdata']['type'] == 'merchant'){
			
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
			if(empty($merchantamountlended)){
			
				$errors['type'] = 'merchantamountlended';
				$errors['msg'] = '* Enter amount lended';
				$errorsFinal[] = $errors;
				$flag = 0;
			}
			else if(!is_numeric($merchantamountlended)){
			
				$errors['type'] = 'merchantamountlended';
				$errors['msg'] = '* Amount lended must be numeric';
				$errorsFinal[] = $errors;
				$flag = 0;
			}
		}else{
			if(empty($hasmerchantid)){
			
			$errors['type'] = 'hasmerchantid';
			$errors['msg'] = '* Choose Merchant Option';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else{
			
			if($hasmerchantid == 'yes'){
			
				if(empty($merchantidnumber)){
					
					$errors['type'] = 'merchantidnumber';
					$errors['msg'] = '* Enter Merchant ID';
					$errorsFinal[] = $errors;
					$flag = 0;
				}
				else{
					
					$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE merchant_cif = '".$merchantidnumber."' OR merchant_nie ='".$merchantidnumber."'";
					$checkemailSql = mysqli_query($con,$checkemailQry) or die(mysqli_error());
					$checkemailRow = mysqli_fetch_row($checkemailSql);
					
					if(empty($checkemailRow)){
				
						$errors['type'] = 'merchantidnumber';
						$errors['msg'] = '* Merchant ID not exists';
						$errorsFinal[] = $errors;
						$flag = 0;
					}
				}
			}
			else if($hasmerchantid == 'no'){
			
				if(empty($loanpurpose)){
					
					$errors['type'] = 'loanpurpose';
					$errors['msg'] = '* Enter purpose of the loan';
					$errorsFinal[] = $errors;
					$flag = 0;
				}
				if(empty($merchantnamecontactorwebsite)){
					
					$errors['type'] = 'merchantnamecontactorwebsite';
					$errors['msg'] = '* Enter merchant information';
					$errorsFinal[] = $errors;
					$flag = 0;
				}
				if($_FILES['budgetattachment']['name'] == ''){
			
					$errors['type'] = 'budgetattachment';
					$errors['msg'] = '* Attach your budget proof';
					$errorsFinal[] = $errors;
					$flag = 0;
				}
				else{
					
					$allowedExt = array('pdf','jpg','jpeg');
					
					$ext = end(explode(".",$_FILES['budgetattachment']['name']));
					
					if(!in_array($ext,$allowedExt)){
						
						$errors['type'] = 'budgetattachment';
						$errors['msg'] = '* Budget attachment must be in '.implode(', ',$allowedExt).' format';
						$errorsFinal[] = $errors;
						$flag = 0;
					}
				}
			}
		}
		
	}	
		if(empty($employmenttype)){
			
			$errors['type'] = 'employmenttype';
			$errors['msg'] = '* Choose employment type';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($employercompanyname)){
			
			$errors['type'] = 'employercompanyname';
			$errors['msg'] = '* Enter employer companyname';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($grossmonthlyincome)){
			
			$errors['type'] = 'grossmonthlyincome';
			$errors['msg'] = '* Enter gross monthly income';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(!is_numeric($grossmonthlyincome)){
			
			$errors['type'] = 'grossmonthlyincome';
			$errors['msg'] = '* Gross monthly income must be numeric';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($netmonthlyincome)){
			
			$errors['type'] = 'netmonthlyincome';
			$errors['msg'] = '* Enter net monthly income';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(!is_numeric($netmonthlyincome)){
			
			$errors['type'] = 'netmonthlyincome';
			$errors['msg'] = '* Net monthly income must be numeric';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($servicetype)){
			
			$errors['type'] = 'servicetype';
			$errors['msg'] = '* Choose servicetype';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($timewithemployer)){
			
			$errors['type'] = 'timewithemployer';
			$errors['msg'] = '* Enter time with employer';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(!is_numeric($timewithemployer)){
			
			$errors['type'] = 'timewithemployer';
			$errors['msg'] = '* Time in years with employer must be numeric';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		/* if(empty($university)){
			
			$errors['type'] = 'university';
			$errors['msg'] = '* Enter university';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($timeatuniversity)){
			
			$errors['type'] = 'timeatuniversity';
			$errors['msg'] = '* Enter time at university';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($division)){
			
			$errors['type'] = 'division';
			$errors['msg'] = '* Enter division';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($timeinservice)){
			
			$errors['type'] = 'timeinservice';
			$errors['msg'] = '* Enter time in service';
			$errorsFinal[] = $errors;
			$flag = 0;
		} */
		if(empty($workphonenumber)){
			
			$errors['type'] = 'workphonenumber';
			$errors['msg'] = '* Enter work phone number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(!is_numeric($workphonenumber)){
			
			$errors['type'] = 'workphonenumber';
			$errors['msg'] = '* Work phone number must be digits';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		/* if(empty($frequencyofincome)){
			
			$errors['type'] = 'frequencyofincome';
			$errors['msg'] = '* Enter frequency of income';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($nextpaydate)){
			
			$errors['type'] = 'nextpaydate';
			$errors['msg'] = '* Enter next pay date';
			$errorsFinal[] = $errors;
			$flag = 0;
		} */

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
		/*else{
			
			if(!isset($_SESSION['userid'])){
			
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
		}*/
		
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
			if(!isset($_SESSION['userid'])){
				$checkemailRow = checkEmail($emailaddress,$con);
				if(($checkemailRow) > 0){
					
					$errors['type'] = 'emailaddress';
					$errors['msg'] = '* Email address is already registered';
					$errorsFinal[] = $errors;
					$flag = 0;
				}
			}
		}
		if(empty($housenumber)){
			
			$errors['type'] = 'housenumber';
			$errors['msg'] = '* Enter house number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($streetname)){
			
			$errors['type'] = 'streetname';
			$errors['msg'] = '* Enter street name';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		
		if(empty($city)){
			
			$errors['type'] = 'city';
			$errors['msg'] = '* Enter city';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($province)){
			
			$errors['type'] = 'province';
			$errors['msg'] = '* Enter province';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($postcode)){
			
			$errors['type'] = 'postcode';
			$errors['msg'] = '* Enter postcode';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(!is_numeric($postcode)){
			
			$errors['type'] = 'postcode';
			$errors['msg'] = '* Postcode must be numeric';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(strlen($postcode) != 5){
			
			$errors['type'] = 'postcode';
			$errors['msg'] = '* Postcode must be of 5 digits';
			$errorsFinal[] = $errors;
			$flag = 0;
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
			
			if($_FILES['budgetattachment']['name'] != ''){
				
				$randomStr = md5(uniqid(rand(), true));
				
				$filenameorig = $_FILES['budgetattachment']['name'];
				$filetmpname = $_FILES['budgetattachment']['tmp_name'];
				
				$ext = end(explode(".",$filenameorig));
				$filename = $randomStr.'.'.$ext;
				
				move_uploaded_file($filetmpname, 'backoffice/userfiles/'.$filename);
				
				$budgetattachment = $filename;
			}
			
			unset($_POST['stepcount']);
			$_SESSION['customerdata'] = array_merge($_SESSION['customerdata'],$_POST);
			$_SESSION['customerdata']['lastpayslip'] = $lastpayslip;
			$_SESSION['customerdata']['idproof'] = $idproof;
			$_SESSION['customerdata']['budgetattachment'] = $budgetattachment;

			/****** Do Petition *********/

			$customerdata = $_SESSION['customerdata'];			
			if(isset($_SESSION['userlogininapi']) && $_SESSION['userlogininapi']!=""){
				    $insertArr=array();
					$doInstantPetition=array(
											 "productID"=>1,
											 "yourReference"=>$customerdata['idnumber'],
											 "nationalID"=>$customerdata['idnumber'],
											 "productBehaviour"=>0,
											 "firstSurname"=>$customerdata['surname'],
											 "postalCode"=>$customerdata['postcode'],
											 "name"=>$customerdata['firstname'],
											 "secondSurname"=>$customerdata['second_surname'],
											 'birthDate'=>$customerdata['dob'],
											 'phones'=>$customerdata['cellphonenumber']
											);

				$xmlString =doInstantPetition($doInstantPetition);
				$xmlString = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xmlString);
				$xml = SimpleXML_Load_String($xmlString);
                if($xml===FALSE) {
						$errors['type'] = 'idnumber';
						$errors['msg'] = stripslashes($xmlString);
						$errorsFinal[] = $errors;
						$flag = 0;
						$errstr = json_encode($errorsFinal);
						//$stepscovered[] = 'step2';
						//$_SESSION['steps'] = $stepscovered;
						
						//header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloan/step2');
						//exit;
					} else {
						$_SESSION['customerdata']['xmlstring']=$xmlString;
						$merchant_id = '';
			
						if(!empty($merchantidnumber)){
							
							$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE merchant_cif = '".$merchantidnumber."'";
							$checkemailSql = mysqli_query($con,$checkemailQry) or die(mysqli_error());
							$checkemailRow = mysqli_fetch_assoc($checkemailSql);
							
							$merchant_id = $checkemailRow['id']; //die();
						}
						
						$_SESSION['customerdata']['merchant_id'] = $merchant_id;
									
						$stepscovered[] = 'step3';
						$_SESSION['steps'] = $stepscovered;
						
						header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloan/step3');
						exit;
								
					}	
				
				/*else{
					updateQuery(TABLE_PREFIX."backoffice_loan_applications",
							array("id"=>$loan_id),array("status"=>"rejected"));
					$stepscovered[] = 'step3';
					$_SESSION['steps'] = $stepscovered;
				}*/
			}
			/****** Do Petition *********/
			
			
			
		}
	}
	else if($stepcount == 'step3'){
		
		if(count($_POST)){
			
			foreach($_POST as $key=>$val){
				
				$_POST[$key] = trim(htmlspecialchars($val));
			}
		}
		
		$username 				= isset($_POST['username']) ? $_POST['username'] : '';
		$password 				= isset($_POST['password']) ? $_POST['password'] : '';
		$confirmpassword 		= isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';
		$secretquestion 		= isset($_POST['secretquestion']) ? $_POST['secretquestion'] : '';
		$secretanswer 			= isset($_POST['secretanswer']) ? $_POST['secretanswer'] : '';
		
		$flag = 1;
		
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
		if(empty($secretquestion)){
			
			$errors['type'] = 'secretquestion';
			$errors['msg'] = '* Choose security question';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($secretanswer)){
			
			$errors['type'] = 'secretanswer';
			$errors['msg'] = '* Enter secret answer';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		
		$errstr = json_encode($errorsFinal);
		
		//echo '<pre>'; print_r($errorsFinal); //exit;
		
		if($flag == 1){
			
			unset($_POST['stepcount']);
			$_SESSION['customerdata'] = array_merge($_SESSION['customerdata'],$_POST);
			
			//echo '<pre>'; print_r($_SESSION['customerdata']); exit;
			
			$stepscovered[] = 'step4';
			$_SESSION['steps'] = $stepscovered;
			
			header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloan/step4');
			exit;
		}		
	}
	else if($stepcount == 'step4'){
		
		if(count($_POST)){
			
			foreach($_POST as $key=>$val){
				
				$_POST[$key] = trim(htmlspecialchars($val));
			}
		}
		
		$bankname 				= isset($_POST['bankname']) ? $_POST['bankname'] : '';
		$nameofaccountholder 	= isset($_POST['nameofaccountholder']) ? $_POST['nameofaccountholder'] : '';
		$ibannumber 			= isset($_POST['ibannumber']) ? $_POST['ibannumber'] : '';
		$timewithbank 			= isset($_POST['timewithbank']) ? $_POST['timewithbank'] : '';
		$nameoncard 			= isset($_POST['nameoncard']) ? $_POST['nameoncard'] : '';
		$cardnumber 			= isset($_POST['cardnumber']) ? $_POST['cardnumber'] : '';
		$expirymonth 			= isset($_POST['expirymonth']) ? $_POST['expirymonth'] : '';
		$expiryyear 			= isset($_POST['expiryyear']) ? $_POST['expiryyear'] : '';
		$cvvnumber 				= isset($_POST['cvvnumber']) ? $_POST['cvvnumber'] : '';
		$street_bank_branch 	= isset($_POST['street_bank_branch']) ? $_POST['street_bank_branch'] : '';
		
		$flag = 1;
		
		if(empty($ibannumber)){
			
			$errors['type'] = 'ibannumber';
			$errors['msg'] = '* Enter IBAN number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}else{

			if(!empty($ibannumber)){
			
				$regex = '/^[A-Z]{2}[0-9]{22}$/';

				preg_match_all($regex, $ibannumber, $matches, PREG_SET_ORDER, 0);
				
				if(!count($matches)){			
					$errors['type'] = 'ibannumber';
					$errors['msg'] = '* IBAN account number no must be of 2 Capital Letters and 22 Digits';
					$errorsFinal[] = $errors;
					$flag = 0;
				}else if(!checkIBAN($ibannumber)){
					
					$errors['type'] = 'ibannumber';
					$errors['msg'] = '* Enter valid IBAN account number';
					$errorsFinal[] = $errors;
					$flag = 0;
				}
			}
		}
		
		if(empty($bankname)){			
			$errors['type'] = 'bankname';
			$errors['msg'] = '* Enter bank name';
			$errorsFinal[] = $errors;
			$flag = 0;
		}

		if(empty($street_bank_branch)){			
			$errors['type'] = 'street_bank_branch';
			$errors['msg'] = '* Enter street bank branch';
			$errorsFinal[] = $errors;
			$flag = 0;
		}

		if(empty($nameofaccountholder)){
			
			$errors['type'] = 'nameofaccountholder';
			$errors['msg'] = '* Enter name of account holder';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		
		if($_FILES['bankcertificate']['name'] == ''){
			
			$errors['type'] = 'bankcertificate';
			$errors['msg'] = '* Attach your bank certificate';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else{
			
			$allowedExt = array('pdf');
			
			$ext = end(explode(".",$_FILES['bankcertificate']['name']));
			
			if(!in_array($ext,$allowedExt)){
				
				$errors['type'] = 'bankcertificate';
				$errors['msg'] = '* Bank certificate must be in '.implode(', ',$allowedExt).' format';
				$errorsFinal[] = $errors;
				$flag = 0;
			}
		}
		if(empty($nameoncard)){
			
			$errors['type'] = 'nameoncard';
			$errors['msg'] = '* Enter name on card';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($cardnumber)){
			
			$errors['type'] = 'cardnumber';
			$errors['msg'] = '* Enter card number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(!is_numeric($cardnumber)){
			
			$errors['type'] = 'cardnumber';
			$errors['msg'] = '* Card number must be numeric';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($expirymonth)){
			
			$errors['type'] = 'expirymonth';
			$errors['msg'] = '* Choose expiry month';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($expiryyear)){
			
			$errors['type'] = 'expiryyear';
			$errors['msg'] = '* Choose expiry year';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		if(empty($cvvnumber)){
			
			$errors['type'] = 'cvvnumber';
			$errors['msg'] = '* Enter CVV number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else if(!is_numeric($cvvnumber)){
			
			$errors['type'] = 'cvvnumber';
			$errors['msg'] = '* CVV number must be numeric';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		
		$errstr = json_encode($errorsFinal);
			
		if($flag == 1){
			
			$bankcertificate = '';
			
			if($_FILES['bankcertificate']['name'] != ''){
				
				$randomStr = md5(uniqid(rand(), true));
				
				$filenameorig = $_FILES['bankcertificate']['name'];
				$filetmpname = $_FILES['bankcertificate']['tmp_name'];
				
				$ext = end(explode(".",$filenameorig));
				$filename = $randomStr.'.'.$ext;
				
				move_uploaded_file($filetmpname, 'backoffice/userfiles/'.$filename);
				
				$bankcertificate = $filename;
			}
			
			unset($_POST['stepcount']);
			$_SESSION['customerdata'] = array_merge($_SESSION['customerdata'],$_POST);
			$_SESSION['customerdata']['bankcertificate'] = $bankcertificate;
			
			// Insert to DB			
			$time = time();
			
			$customerdata = $_SESSION['customerdata'];
			
			if(!isset($_SESSION['userid'])){
				$bankaccountval= substr($customerdata['ibannumber'], -20);	
								$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_borrowers SET
									  username = '".addslashes($customerdata['username'])."',
									  firstname = '".addslashes($customerdata['firstname'])."',
									  middlename = '".addslashes($customerdata['middlename'])."',
									  surname = '".addslashes($customerdata['surname'])."',
									  second_surname = '".addslashes($customerdata['second_surname'])."',
									  idnumber = '".addslashes($customerdata['idnumber'])."',
									  homelanguage = '".addslashes($customerdata['homelanguage'])."',
									  status = '".addslashes($customerdata['status'])."',
									  maritalstatus = '".addslashes($customerdata['maritalstatus'])."',
									  noofdependants = '".addslashes($customerdata['noofdependants'])."',
									  employmenttype = '".addslashes($customerdata['employmenttype'])."',
									  employercompanyname = '".addslashes($customerdata['employercompanyname'])."',
									  grossmonthlyincome = '".addslashes($customerdata['grossmonthlyincome'])."',
									  netmonthlyincome = '".addslashes($customerdata['netmonthlyincome'])."',
									  servicetype = '".addslashes($customerdata['servicetype'])."',
									  timewithemployer = '".addslashes($customerdata['timewithemployer'])."',
									  workphonenumber = '".addslashes($customerdata['workphonenumber'])."',
									  cellphonenumber = '".addslashes($customerdata['cellphonenumber'])."',
									  alternatenumber = '".addslashes($customerdata['alternatenumber'])."',
									  emailaddress = '".addslashes($customerdata['emailaddress'])."',
									  housenumber = '".addslashes($customerdata['housenumber'])."',
									  streetname = '".addslashes($customerdata['streetname'])."',
									  suburb = '".addslashes($customerdata['suburb'])."',
									  city = '".addslashes($customerdata['city'])."',
									  province = '".addslashes($customerdata['province'])."',
									  postcode = '".addslashes($customerdata['postcode'])."',
									  password = '".addslashes(md5($customerdata['password']))."',
									  secretquestion = '".addslashes($customerdata['secretquestion'])."',
									  secretanswer = '".addslashes($customerdata['secretanswer'])."',
									  bankname = '".addslashes($customerdata['bankname'])."',
									  ibannumber = '".addslashes($customerdata['ibannumber'])."',
									  accountnumber= '".addslashes($bankaccountval)."',
									  nameofaccountholder = '".addslashes($customerdata['nameofaccountholder'])."',
									  nameoncard = '".addslashes($customerdata['nameoncard'])."',
									  cardnumber = '".addslashes($customerdata['cardnumber'])."',
									  expirymonth = '".addslashes($customerdata['expirymonth'])."',
									  expiryyear = '".addslashes($customerdata['expiryyear'])."',
									  cvvnumber = '".addslashes($customerdata['cvvnumber'])."',
									  hasmerchantid = '".addslashes($customerdata['hasmerchantid'])."',
									  merchantidnumber = '".addslashes($customerdata['merchantidnumber'])."',
									  street_bank_branch='".addslashes($customerdata['street_bank_branch'])."',
									  loanpurpose = '".addslashes($customerdata['loanpurpose'])."',
									  merchantnamecontactorwebsite = '".addslashes($customerdata['merchantnamecontactorwebsite'])."',
									  dninie='".($dninie)."',
									  dob = '".addslashes($customerdata['dob'])."',
									  createdate = '".addslashes($time)."'";
									$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());							
									$borrower_id = mysqli_insert_id();

									$request = curl_init(BASE_URL.'backoffice/borrowerlogindetails/'.$borrower_id.'/'.$customerdata['password']);
									curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
									$response = curl_exec($request);
									curl_close($request);
			}else{
				$borrower_id = $_SESSION['userid'];
			}
			//$loan_unique_id = 'SMC-'.$time.'-'.$borrower_id.rand(100000,999999);
			if(!empty($borrower_id)){
			$merchant_id = isset($customerdata['merchant_id']) ? $customerdata['merchant_id'] : '';
			
			$product_name = !empty($customerdata['merchantprodname']) ? $customerdata['merchantprodname'] : $customerdata['loanpurpose'];
			
			
			$from_merchant = '0';
			
			if($_SESSION['customerdata']['type'] == 'merchant'){
				
				$from_merchant = '1';
			}

			$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_loan_applications SET
												  loan_amount = '".addslashes($customerdata['amount'])."',
												  loan_terms = '".addslashes($customerdata['term'])."',
												  loan_apr = '".$config['default_apr']."',
												  borrower_id = '".addslashes($borrower_id)."',
												  merchant_id = '".addslashes($merchant_id)."',
												  product_name = '".addslashes($product_name)."',
												  createdate = '".addslashes($time)."',
												  from_merchant = '".addslashes($from_merchant)."',
												  status = 'pending'";
						  
			$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());		
			$loan_id =mysqli_insert_id();

			if($loan_id){
				/****************/
				if(isset($_SESSION['customerdata']['xmlstring']) && $_SESSION['customerdata']['xmlstring']!=""){
					
					$xml=$_SESSION['customerdata']['xmlstring'];

					$xml = simplexml_load_string($xml);
					$xml = new SimpleXMLElement($xml->asXML());

					$soapval="";
					if(isset($xml->soapbody)){
					    $soapval="soapbody";
					}else if(isset($xml->soapBody)){
					    $soapval="soapBody";
					}

					if(!empty($xml->$soapval->ns2doinstantpetitionresponse)){
						$checkVari=$xml->$soapval->ns2doinstantpetitionresponse;
						$petitionid=(array)$xml->$soapval->ns2doinstantpetitionresponse->return->petitionid;
					}else if(!empty($xml->$soapval->ns2doInstantPetitionResponse)){
						$checkVari=$xml->$soapval->ns2doInstantPetitionResponse;
						$petitionid=(array)$xml->$soapval->ns2doInstantPetitionResponse->return->petitionid;
					}


					if(!empty($checkVari)){
						$xmlproductresult=$checkVari->return->xmlproductresult;
						
						$nationalid=(array)$xml->$soapval->ns2doInstantPetitionResponse->return->nationalid;
						$insertArr['nationalid']=$nationalid[0];

						//$petitionid=(array)$xml->$soapval->ns2doinstantpetitionresponse->return->petitionid;
						$insertArr['petitionid']=$petitionid[0];
						if(!empty($xmlproductresult)){
							$xmlproductresultresponse='<xmlproductresult>'.$xmlproductresult.'</xmlproductresult>';
							$productxml = simplexml_load_string($xmlproductresultresponse);
							$productxml= (array) $productxml;
							foreach($productxml as $key=>$values){
								    $insertArr[$key]=$values;
							}
						}
						$insertArr['petition_date']=time();
						if(!empty($insertArr)){
							$insertArr["loan_id"]=$loan_id;
							insertQuery("loan_petitions",$insertArr);
						}else{
							
							//$stepscovered[] = 'step2';
							//$_SESSION['steps'] = $stepscovered;
						}

						if(!empty($insertArr['scoring']) && $insertArr['scoring']=="BBB"){
							
							updateQuery("backoffice_loan_applications",
							array("id"=>$loan_id),array("status"=>"rejected"),$con);
							//$stepscovered[] = 'step3';
							//$_SESSION['steps'] = $stepscovered;
						}
					}
				}else if(isset($customerdata['xmlstring']) && $customerdata['xmlstring']==""){
					updateQuery("backoffice_loan_applications",
							array("id"=>$loan_id),array("status"=>"rejected"),$con);
					//$stepscovered[] = 'step3';
					//$_SESSION['steps'] = $stepscovered;
				}
				

				/***************/
					$loan_unique_id = 'SC-'.date('Y').'-'.(str_pad($loan_id,2,0,STR_PAD_LEFT));
					
					$updateSql = "UPDATE ".TABLE_PREFIX."backoffice_loan_applications SET 
								  unique_id = '".addslashes($loan_unique_id)."'
								  WHERE id = '".$loan_id."'";
					mysqli_query($con,$updateSql) or die(mysqli_error());	
					
					
					$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_loan_documents SET
								  loan_id = '".addslashes($loan_id)."',
								  document_type = 'lastpayslip',
								  type = 'useruploaded',
								  document_path = '".addslashes($customerdata['lastpayslip'])."',
								  createdate = '".addslashes($time)."'";
								  
					$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());	


					$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_loan_documents SET
								  loan_id = '".addslashes($loan_id)."',
								  document_type = 'bankcertificate',
								  type = 'useruploaded',
								  document_path = '".addslashes($customerdata['bankcertificate'])."',
								  createdate = '".addslashes($time)."'";
								  
					$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());	
					
					
					if(!empty($customerdata['idproof'])){
						
						$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_loan_documents SET
									  loan_id = '".addslashes($loan_id)."',
									  document_type = 'idproof',
									  type = 'useruploaded',
									  document_path = '".addslashes($customerdata['idproof'])."',
									  createdate = '".addslashes($time)."'";
									  
						$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());	
					}
					
					if(!empty($customerdata['budgetattachment'])){
						
						$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_loan_documents SET
									  loan_id = '".addslashes($loan_id)."',
									  document_type = 'budgetattachment',
									  type = 'useruploaded',
									  document_path = '".addslashes($customerdata['budgetattachment'])."',
									  createdate = '".addslashes($time)."'";
									  
						$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());	
					}
					
					    // Generate Files and Send Mail
					
						$request = curl_init(BASE_URL.'backoffice/generatepdf/'.$loan_id);
						curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
						$response = curl_exec($request);
						curl_close($request);
						
						$_SESSION['customerdata']['loanid'] = $loan_id;
						$_SESSION['customerdata']['borrowerid'] = $borrower_id;
						$stepscovered[] = 'step5';
						$_SESSION['steps'] = $stepscovered;
						//header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloan/'.end($_SESSION['steps']));
					header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloan/step5');
					exit;
				}
			}
			
			
		}
	}
	else if($stepcount == 'step5'){
		
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
			
			$stepscovered[] = 'step6';
			$_SESSION['steps'] = $stepscovered;
			
			$mobile = COUNTRY_PREFIX.$_SESSION['customerdata']['cellphonenumber'];
			
			$randomCode = rand(100000,999999);
			
			$message = $randomCode." is your 6 digit verification code for ".PROJECT_NAME;
			
			$_SESSION['customerdata']['otpsent'] = $randomCode;
			
			sendsms($mobile,$message);
			
			header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloan/step6');
			exit;
		}
	}
	else if($stepcount == 'step6'){
		
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
		
		//echo '<pre>'; print_r($errorsFinal); //exit;
		
		if($flag == 1){
		
			$updateQry = "UPDATE ".TABLE_PREFIX."backoffice_borrowers SET
						  mobile_verified = '1'
						  WHERE id = '".$_SESSION['customerdata']['borrowerid']."'";
			
			mysqli_query($con,$updateQry) or die(mysqli_error());
			$stepscovered[] = 'thankyou';
			$_SESSION['steps'] = $stepscovered;
			
			header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloan/thankyou');
			exit;
		}
	}
}

/* define('FINANCIAL_MAX_ITERATIONS', 128);
define('FINANCIAL_PRECISION', 1.0e-08);


function RATE($nper, $pmt, $pv, $fv = 0.0, $type = 0, $guess = 0.1) {

    $rate = $guess;
    if (abs($rate) < FINANCIAL_PRECISION) {
        $y = $pv * (1 + $nper * $rate) + $pmt * (1 + $rate * $type) * $nper + $fv;
    } else {
        $f = exp($nper * log(1 + $rate));
        $y = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
    }
    $y0 = $pv + $pmt * $nper + $fv;
    $y1 = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;

    // find root by secant method
    $i  = $x0 = 0.0;
    $x1 = $rate;
    while ((abs($y0 - $y1) > FINANCIAL_PRECISION) && ($i < FINANCIAL_MAX_ITERATIONS)) {
        $rate = ($y1 * $x0 - $y0 * $x1) / ($y1 - $y0);
        $x0 = $x1;
        $x1 = $rate;

        if (abs($rate) < FINANCIAL_PRECISION) {
            $y = $pv * (1 + $nper * $rate) + $pmt * (1 + $rate * $type) * $nper + $fv;
        } else {
            $f = exp($nper * log(1 + $rate));
            $y = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
        }

        $y0 = $y1;
        $y1 = $y;
        ++$i;
    }
    return $rate;
}   //  function RATE()

$rate = RATE(12,-270.77,(3000-90),0,0);
echo $tae = (pow((1 + $rate),12)-1)*100;
die(); */

//print "<pre>"; print_r($allcontents); exit;
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
						<div class="12u 12u$(6)">						
							<div class="select-wrapper">
								<select name="dninie" id="dninie">
									<option value="">Select Type</option>
									<option <?= ($dninie=="dni") ? 'selected' : '' ?>  value="dni">DNI</option>
									<option <?= ($dninie=="nie") ? 'selected' : '' ?>  value="nie">NIE</option>					
								</select>
							</div>						
						</div>

						<div class="12u 12u$(6)">
							<input type="text" name="idnumber" id="idnumber" value="<?php echo($idnumber); ?>" placeholder="<?php echo($transArr['ID Number']); ?>"  <?php echo(in_array('idnumber',$readonly) ? 'class="disabled"' : ''); ?> />
						</div>
												
						<div class="12u 12u$(6)">
							
						</div>
						<?php /* ?><div class="6u$ 12u$(6)">
							<input type="text" name="homelanguage" id="homelanguage" value="<?php echo($homelanguage); ?>" placeholder="<?php echo($transArr['Home Language']); ?>" />
						</div><?php */ ?>
					</div>
					
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
					
					<?php
					if($_SESSION['customerdata']['type'] == 'merchant'){
					?>
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
						<div class="6u$ 12u$(6)">
							<input type="text" name="merchantamountlended" id="merchantamountlended" value="<?php echo($merchantamountlended); ?>" placeholder="<?php echo($transArr['Amount Lended']); ?>" />
						</div>
					</div>
					<?php
					}
					else{
					?>
					<h3><?php echo($transArr['Merchant Details']); ?></h3>
					<div class="row uniform 50%">	
					
						<div class="12u 12u$(12)">
							
							<span style="margin-right:10px;"><?php echo($transArr['Do you have a merchant id?']); ?></span>
							
							<span id="hasmerchantid" style="padding:5px;">
								<input id="hasmerchantid-yes" name="hasmerchantid" type="radio" value="yes" class="hasmerchantid" <?php echo($hasmerchantid == 'yes' ? 'checked' : ''); ?>>
								<label for="hasmerchantid-yes"><?php echo($transArr['Yes']); ?></label>

								<input id="hasmerchantid-no" name="hasmerchantid" type="radio" value="no" class="hasmerchantid" <?php echo($hasmerchantid == 'no' ? 'checked' : ''); ?>>
								<label for="hasmerchantid-no"><?php echo($transArr['No']); ?></label>
							</span>
							
						</div>
						
					</div>
					
					<div class="row uniform 50% merchntdet" id="merchantidcontainer" style="display:<?php echo($hasmerchantid == 'yes' ? 'block' : 'none'); ?>;">	
					
						<div class="12u 12u$(12)">
							<select name="merchantidnumber" id="merchantidnumber">
								<option value="0"><?php echo($transArr['Merchant ID Number']); ?></option>
							<?php

$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE status='approved'";
$checkemailSql = mysqli_query($con,$checkemailQry) or die(mysqli_error());

if(!empty(mysqli_fetch_array($checkemailSql))){
	while ($row = mysqli_fetch_array($checkemailSql))  
	{
		if($row["merchant_cif"]){
		?>
	<option value="<?=$row["merchant_cif"]?>" <?=($merchantidnumber == $row["merchant_cif"] ? 'selected' : '');?>><?=$row["merchant_name"]?></option>
		<?php
	}else{
		?>
	<option value="<?=$row["merchant_nie"]?>" <?=($merchantidnumber == $row["merchant_nie"] ? 'selected' : '');?>><?=$row["merchant_name"]?></option>
		<?php
	}
	}
}
							?>
							</select>
							
						</div>
						<div class="12u$ 12u$(6)">
							<div class="fileholder"><?php echo($transArr['Budget Attachment']); ?> : <input type="file" name="budgetattachment" id="budgetattachment"></div>
						</div>
						
						
					</div>
					
					<div class="row uniform 50% merchntdet" id="merchantdetailscontainer" style="display:<?php echo($hasmerchantid == 'no' ? 'block' : 'none'); ?>;">
						
						<div class="12u 12u$(12)">
							<input type="text" name="loanpurpose" id="loanpurpose" value="<?php echo($loanpurpose); ?>" placeholder="<?php echo($transArr['Purpose of the Loan']); ?>" />
						</div>
						<div class="12u 12u$(12)">
							<input type="text" name="merchantnamecontactorwebsite" id="merchantnamecontactorwebsite" value="<?php echo($merchantnamecontactorwebsite); ?>" placeholder="<?php echo($transArr['Merchant Name and Contact Number or Merchant Website']); ?>" />
						</div>
						<div class="12u$ 12u$(6)">
							<div class="fileholder"><?php echo($transArr['Budget Attachment']); ?> : <input type="file" name="budgetattachment" id="budgetattachment"></div>
						</div>
						
					</div>
					
					<?php
					}
					?>
					
					
					<h3><?php echo($transArr['Employment Details']); ?></h3>
					<div class="row uniform 50%">						
						<div class="12u$">
							<div class="select-wrapper">
								<select name="employmenttype" id="employmenttype" <?php echo(in_array('employmenttype',$readonly) ? 'class="disabled"' : ''); ?>>
									<option value="">- <?php echo($transArr['Employment Type']); ?> -</option>
									
									<?php
									foreach($values['employment_status'] as $key=>$val){
										
										?>
										<option value="<?=$key?>" <?php echo($employmenttype == $key ? 'selected' : ''); ?>><?=$val?></option>
										<?php
									}
									?>
									
								</select>
							</div>
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<div class="4u 12u$(4)">
							<input type="text" name="employercompanyname" id="employercompanyname" value="<?php echo($employercompanyname); ?>" placeholder="<?php echo($transArr['Employer Company Name']); ?>"  <?php echo(in_array('employercompanyname',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						<div class="4u 12u$(4)">
							<input type="text" name="grossmonthlyincome" id="grossmonthlyincome" value="<?php echo($grossmonthlyincome); ?>" placeholder="<?php echo($transArr['Gross Monthly Income']); ?>"  <?php echo(in_array('grossmonthlyincome',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						<div class="4u$ 12u$(4)">
							<input type="text" name="netmonthlyincome" id="netmonthlyincome" value="<?php echo($netmonthlyincome); ?>" placeholder="<?php echo($transArr['Net Monthly Income']); ?>"  <?php echo(in_array('netmonthlyincome',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<div class="12u$">
							<div class="select-wrapper">
								<select name="servicetype" id="servicetype" <?php echo(in_array('servicetype',$readonly) ? 'class="disabled"' : ''); ?>>
									<option value="">- <?php echo($transArr['Service Type']); ?> -</option>
									
									<?php
									foreach($values['service_type'] as $key=>$val){
										
										?>
										<option value="<?=$key?>" <?php echo($servicetype == $key ? 'selected' : ''); ?>><?=$val?></option>
										<?php
									}
									?>
									
								</select>
							</div>
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input type="text" name="timewithemployer" id="timewithemployer" value="<?php echo($timewithemployer); ?>" placeholder="<?php echo($transArr['Time With Employer in Years']); ?>"  <?php echo(in_array('timewithemployer',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						<div class="6u$ 12u$(6)">
							<input type="text" name="workphonenumber" id="workphonenumber" value="<?php echo($workphonenumber); ?>" placeholder="<?php echo($transArr['Work Phone Number']); ?>"  <?php echo(in_array('workphonenumber',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						<?php /* ?><div class="6u$ 12u$(6)">
							<input type="text" name="university" id="university" value="<?php echo($university); ?>" placeholder="<?php echo($transArr['University']); ?>" />
						</div><?php */ ?>
					</div>
					
					<div class="row uniform 50%">						
						<div class="12u$">
							<div class="fileholder"><?php echo($transArr['Attach your last payslip']); ?> : <input type="file" name="lastpayslip" id="lastpayslip"></div>
						</div>
					</div>
					
					<?php /* ?><div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input type="text" name="timeatuniversity" id="timeatuniversity" value="<?php echo($timeatuniversity); ?>" placeholder="<?php echo($transArr['Time at University']); ?>" />
						</div>
						<div class="6u$ 12u$(6)">
							<input type="text" name="division" id="division" value="<?php echo($division); ?>" placeholder="<?php echo($transArr['Division']); ?>" />
						</div>
					</div><?php */ ?>
					
					<div class="row uniform 50%">						
						<?php /* ?><div class="6u 12u$(6)">
							<input type="text" name="timeinservice" id="timeinservice" value="<?php echo($timeinservice); ?>" placeholder="<?php echo($transArr['Time in Service']); ?>" />
						</div><?php */ ?>						
					</div>
					
					<?php /* ?><div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input type="text" name="frequencyofincome" id="frequencyofincome" value="<?php echo($frequencyofincome); ?>" placeholder="<?php echo($transArr['Frequency of Income']); ?>" />
						</div>
						<div class="6u$ 12u$(6)">
							<input type="text" name="nextpaydate" id="nextpaydate" value="<?php echo($nextpaydate); ?>" placeholder="<?php echo($transArr['Next Pay Date']); ?>" />
						</div>
					</div><?php */ ?>

					
					
					<h3>Contacting You</h3>
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
					
					<h2><?php echo($transArr['Address Details']); ?></h2>
					
					<div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input type="text" name="housenumber" id="housenumber" value="<?php echo($housenumber); ?>" placeholder="<?php echo($transArr['House Number']); ?>"  <?php echo(in_array('housenumber',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						<div class="6u$ 12u$(6)">
							<input type="text" name="streetname" id="streetname" value="<?php echo($streetname); ?>" placeholder="<?php echo($transArr['Street Name']); ?>"  <?php echo(in_array('streetname',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<?php /* ?><div class="6u 12u$(6)">
							<input type="text" name="suburb" id="suburb" value="<?php echo($suburb); ?>" placeholder="<?php echo($transArr['Suburb']); ?>" />
						</div><?php */ ?>
						<div class="12u$ 12u$(6)">
							<input type="text" name="city" id="city" value="<?php echo($city); ?>" placeholder="<?php echo($transArr['City']); ?>"  <?php echo(in_array('city',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input type="text" name="province" id="province" value="<?php echo($province); ?>" placeholder="<?php echo($transArr['Province']); ?>"  <?php echo(in_array('province',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						<div class="6u$ 12u$(6)">
							<input type="text" name="postcode" id="postcode" value="<?php echo($postcode); ?>" placeholder="<?php echo($transArr['Postcode']); ?>"  <?php echo(in_array('postcode',$readonly) ? 'class="disabled"' : ''); ?>/>
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
		}
		else if($step == 'step3'){
			
			if(isset($_SESSION['userid']) && $_SESSION['usertype'] == 'borrower'){
			
				$stepscovered[] = 'step4';
				$_SESSION['steps'] = $stepscovered;
				
				header("Location:".BASE_URL.$_SESSION['currentLang'].'/getloan/step4');
				exit;
			}
			
			?>
			<header class="major">
				<h2><?php echo($transArr['Provide Your Account Information']); ?></h2>
			</header>
			
			<section>
				
				<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
				
					<input type="hidden" name="stepcount" value="<?=$step?>">
				
					<h2><?php echo($transArr['Account Setup']); ?></h2>
				
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
						<div class="12u$">
							<div class="select-wrapper">
								<select name="secretquestion" id="secretquestion">
									<option value="">- <?php echo($transArr['Secret Question']); ?> -</option>									
									
									<?php
									foreach($values['security_questions'] as $key=>$val){
										
										?>
										<option value="<?=$key?>" <?php echo($secretquestion == $key ? 'selected' : ''); ?>><?=$val?></option>
										<?php
									}
									?>
									
								</select>
							</div>
						</div>
						<div class="12u$">
							<input type="text" name="secretanswer" id="secretanswer" value="<?php echo($secretanswer); ?>" placeholder="<?php echo($transArr['Secret Answer']); ?>" />
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
		}
		else if($step == 'step4'){
			
			?>
			<header class="major">
				<h2><?php echo($transArr['Provide Your Bank Details']); ?></h2>
			</header>
			
			<section>
				
				<form method="post" action="<?=$_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
					
					<input type="hidden" name="stepcount" value="<?=$step?>">
				
					<h2><?php echo($transArr['Bank Details']); ?></h2>
				
					<div class="row uniform 50%">
						
						
						<!----
						<div class="12u$">
							<input type="text" name="accountnumber" id="accountnumber" value="<?php echo($accountnumber); ?>" placeholder="<?php //echo($transArr['Account Number']); ?>"  <?php //echo(in_array('accountnumber',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						<?php //echo(in_array('nameofaccountholder',$readonly) ? 'class="disabled"' : ''); ?>
						--->
						<div class="12u$">
							<input type="text" name="nameofaccountholder" id="nameofaccountholder" value="<?php echo($nameofaccountholder); ?>" placeholder="<?php echo($transArr['Name of Account Holder']); ?>"  />
						</div>
						<?php /* ?><div class="12u$">
							<input type="text" name="timewithbank" id="timewithbank" value="<?php echo($timewithbank); ?>" placeholder="<?php echo($transArr['Time with Bank']); ?>" />
						</div><?php */ ?>
						<div class="12u$">
							<input type="text" name="bankname" id="bankname" value="<?php echo($bankname); ?>" placeholder="<?php echo($transArr['Bank Name']); ?>"  <?php echo(in_array('bankname',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>

						<!--<div class="12u$">
							<input type="text" name="bank_branch" id="bank_branch" value="<?php echo($bank_branch); ?>" placeholder="<?php echo($transArr['Bank Branch Name']); ?>" />
						</div>-->

						<div class="12u$">
							<input type="text" name="street_bank_branch" id="street_bank_branch" value="<?php echo($street_bank_branch); ?>" placeholder="<?php echo($transArr['Bank Branch Street']); ?>" />
						</div>
					</div>

					<div class="row uniform 50%">
						<!----
						<div class="12u$">
							<input type="text" name="bicnumber" id="bicnumber" value="<?php echo($bicnumber); ?>" placeholder="<?php //echo($transArr['BIC Number']); ?>"  <?php //echo(in_array('bicnumber',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						<?php //echo(in_array('ibannumber',$readonly) ? 'class="disabled"' : ''); ?>
					-->
						<div class="12u$">
							<input type="text" name="ibannumber" id="ibannumber" value="<?php echo($ibannumber); ?>" placeholder="<?php echo($transArr['IBAN Number']); ?>"  />
						</div>
						
					</div>
					
					<h3><?php echo($transArr['Attach your bank certificate']); ?></h3>
					<div class="row uniform 50%">						
						<div class="12u$">
							<input type="file" name="bankcertificate" id="bankcertificate">
						</div>
					</div>
					
					<h2><?php echo($transArr['Credit Card Details']); ?></h2>
				
					<div class="row uniform 50%">
						
						<div class="12u$">
							<input type="text" name="nameoncard" id="nameoncard" value="<?php echo($nameoncard); ?>" placeholder="<?php echo($transArr['Name on Card']); ?>"  <?php echo(in_array('nameoncard',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						<div class="12u$">
							<input type="text" name="cardnumber" id="cardnumber" value="<?php echo($cardnumber); ?>" placeholder="<?php echo($transArr['Card Number']); ?>"  <?php echo(in_array('cardnumber',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						<div class="6u 12u$(6)">
							<div class="select-wrapper">
								<select name="expirymonth" id="expirymonth" <?php echo(in_array('expirymonth',$readonly) ? 'class="disabled"' : ''); ?>>
									<option value="">- <?php echo($transArr['Expiry Month']); ?> -</option>									
									
									<?php
									foreach($values['months'] as $key=>$val){
										
										?>
										<option value="<?=$key+1?>" <?php echo($expirymonth == $key+1 ? 'selected' : ''); ?>><?=$val?></option>
										<?php
									}
									?>
									
								</select>
							</div>
						</div>
						<div class="6u 12u$(6)">
							<div class="select-wrapper">
								<select name="expiryyear" id="expiryyear" <?php echo(in_array('expiryyear',$readonly) ? 'class="disabled"' : ''); ?>>
									<option value="">- <?php echo($transArr['Expiry Year']); ?> -</option>									
									
									<?php
									for($y=date('Y');$y<(date('Y')+10);$y++){
										
										?>
										<option value="<?=$y?>" <?php echo($expiryyear == $y ? 'selected' : ''); ?>><?=$y?></option>
										<?php
									}
									?>
									
								</select>
							</div>
						</div>
						<div class="12u$">
							<input type="text" name="cvvnumber" id="cvvnumber" value="<?php echo($cvvnumber); ?>" placeholder="CVV"  <?php echo(in_array('cvvnumber',$readonly) ? 'class="disabled"' : ''); ?>/>
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
		}
		else if($step == 'step5'){
			
			?>
			
			<?php /* ?><header class="major">
				<h2><?php echo($transArr['Please Wait']); ?>...</h2>
			</header>
			
			<section>
				
				<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
					
					<input type="hidden" name="stepcount" value="<?=$step?>">
				
					<div class="row uniform 50%">						
						<div class="12u$" style="text-align:center">
							<p><img src="images/loader_big.svg"></p>
							<p><?php echo($transArr['Your risk scoring is being done']); ?></p>
						</div>
					</div>
					
				</form>
				
			</section>
			
			<script>
				
				setTimeout(function(){
					
					$('form').submit();
					
				},4000);
			
			</script><?php */ ?>
			
			
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
							<?php /* ?><h4><?php echo($transArr['Important Notes']); ?>:</h4>
							<ul>
								<li><?php echo($transArr['Once approved the amount will be sent to your account within 15 minutes']); ?>.</li>
								<li><?php echo($transArr['Depending on the bank you work with, the transfer may take a bit longer']); ?>.</li>
								<li><?php echo($transArr['Remember to payback on the agreed date']); ?>. <?php echo($transArr['See']); ?> <a href="<?=BASE_URL.$getLang?>/p/payment-policy" target="_blank"><?php echo($transArr['Payment Policy']); ?></a></li>
							</ul><?php */ ?>
							
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
					<!------
					<div class="row uniform 50%">						
						<div class="12u$">
							<p><?php echo($transArr['Contractual information will be sent to your email address once your loan application is approved. It will take short time to review your details. Please be patient.']); ?>.</p>
						</div>
					</div>--->
					
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
	
	$('.btngetloanstart').click(function(){
		
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
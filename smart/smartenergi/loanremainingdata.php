<?php
require_once('header.php');

if(!isset($_SESSION['usertype']) && $_SESSION['usertype'] != 'borrower'){
	$_SESSION['loan_id']=$_GET['loanid'];
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/borrower-signin');
	exit;
}else if(isset($_SESSION['usertype']) && $_SESSION['usertype'] != 'borrower'){
	header("Location:".BASE_URL.$_SESSION['currentLang']);
	exit;
}


if(isset($_GET['loanid'])){	
	$loanid=$_GET['loanid'];

	$getloandata = "SELECT * FROM ".TABLE_PREFIX."backoffice_loan_applications WHERE id = '".$_GET['loanid']."'";
	$getloandata = mysqli_query($con,$getloandata) or die(mysqli_error());
	$getloandata = mysqli_fetch_assoc($getloandata);
	if($getloandata['borrower_id']!=$_SESSION['userid'] || $getloandata['status']!="borrower_pending"){
		unset($_SESSION['loan_id']);
		header("Location:".BASE_URL.$_SESSION['currentLang'].'/borrower-signin');
	}

}else{
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/borrower-signin');
	exit;
}


$step = isset($_REQUEST['step']) ? $_REQUEST['step'] : '';

if($step == 'step1')
	require_once('getloanbanner.php');

$type = isset($_SESSION['userid']) && !empty($_SESSION['userid']) ? $_SESSION['usertype'] : '';

$stepscovered =isset($_SESSION['steps']) && !empty($_SESSION['steps']) ? array_unique($_SESSION['steps']) : ['step1'];

$_SESSION['steps'] = array_values($_SESSION['steps']);


if(!isset($_SESSION['steps']) && $step != 'step1'){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/loanremainingdata/'.$loanid.'/step1');
	exit;
}
else{
	
	$lastStepCovered = $_SESSION['steps'][count($_SESSION['steps'])-1];
	
	if($step != $lastStepCovered && $lastStepCovered != '' && $step != 'step1'){
		header("Location:".BASE_URL.$_SESSION['currentLang'].'/loanremainingdata/'.$loanid.'/'.$lastStepCovered);
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

//echo '<pre>'; print_r($values); exit;


// Get Borrower Details

$borrowerdata = [];

if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
	
	$getborrowerdata = "SELECT * FROM ".TABLE_PREFIX."backoffice_borrowers WHERE id = '".$_SESSION['userid']."'";
	$getborrowerdata = mysqli_query($con,$getborrowerdata) or die(mysqli_error());
	$getborrowerdata = mysqli_fetch_assoc($getborrowerdata);
	$borrowerdata = $getborrowerdata;
	
	$firstname 				= isset($borrowerdata['firstname']) ? $borrowerdata['firstname'] : '';
	$middlename 			= isset($borrowerdata['middlename']) ? $borrowerdata['middlename'] : '';
	$surname 				= isset($borrowerdata['surname']) ? $borrowerdata['surname'] : '';
	$second_surname 		= isset($borrowerdata['second_surname']) ? $borrowerdata['second_surname'] : '';
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

	$username 				= isset($borrowerdata['username']) ? $borrowerdata['username'] : '';
	$secretquestion 		= isset($borrowerdata['secretquestion']) ? $borrowerdata['secretquestion'] : '';
	$secretanswer 			= isset($borrowerdata['secretanswer']) ? $borrowerdata['secretanswer'] : '';
	
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
		//$emailaddress 			= isset($_POST['emailaddress']) ? $_POST['emailaddress'] : '';
		$housenumber 			= isset($_POST['housenumber']) ? $_POST['housenumber'] : '';
		$streetname 			= isset($_POST['streetname']) ? $_POST['streetname'] : '';
		$suburb 				= isset($_POST['suburb']) ? $_POST['suburb'] : '';
		$city 					= isset($_POST['city']) ? $_POST['city'] : '';
		$province 				= isset($_POST['province']) ? $_POST['province'] : '';
		$postcode 				= isset($_POST['postcode']) ? $_POST['postcode'] : '';
				
		
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
		/*
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
		*/
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
			
			if(isset($_SESSION['userid'])){
			
				$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_borrowers WHERE cellphonenumber = '".$cellphonenumber."' and id NOT IN (".$_SESSION['userid'].")";
				$checkemailSql = mysqli_query($con,$checkemailQry) or die(mysqli_error());
				$checkemailRow = mysqli_fetch_row($checkemailSql);
				
				if(!empty($checkemailRow)){
					
					$errors['type'] = 'cellphonenumber';
					$errors['msg'] = '* Cell phone is already registered';
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
		//print_r($errorsFinal);
		$errstr = json_encode($errorsFinal);
		
		//echo '<pre>'; print_r($errorsFinal); //exit;
		
		if($flag == 1){
			
			
			/*
			$lastpayslip = '';
			if($_FILES['lastpayslip']['name'] != ''){
				
				$randomStr = md5(uniqid(rand(), true));
				
				$filenameorig = $_FILES['lastpayslip']['name'];
				$filetmpname = $_FILES['lastpayslip']['tmp_name'];
				
				$ext = end(explode(".",$filenameorig));
				$filename = $randomStr.'.'.$ext;
				
				move_uploaded_file($filetmpname, 'backoffice/userfiles/'.$filename);
				
				$lastpayslip = $filename;
			}
			*/
			/*
			$idproof = '';
			if($_FILES['idproof']['name'] != ''){
				
				$randomStr = md5(uniqid(rand(), true));
				
				$filenameorig = $_FILES['idproof']['name'];
				$filetmpname = $_FILES['idproof']['tmp_name'];
				
				$ext = end(explode(".",$filenameorig));
				$filename = $randomStr.'.'.$ext;
				
				move_uploaded_file($filetmpname, 'backoffice/userfiles/'.$filename);
				
				$idproof = $filename;
			}
			*/
			$budgetattachment = '';
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
			
			$_SESSION['customerdata'] = array_merge($_SESSION['customerdata'],$_POST);
			$stepscovered[] = 'step2';
			$_SESSION['steps'] = $stepscovered;
			
			header("Location:".BASE_URL.$_SESSION['currentLang'].'/loanremainingdata/'.$loanid.'/step2');
			exit;
		}
	}
	else if($stepcount == 'step2'){
		
		if(count($_POST)){
			
			foreach($_POST as $key=>$val){
				
				$_POST[$key] = trim(htmlspecialchars($val));
			}
		}
		
		$username 				= isset($_POST['username']) ? $_POST['username'] : '';
		//$password 				= isset($_POST['password']) ? $_POST['password'] : '';
		//$confirmpassword 		= isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';
		$secretquestion 		= isset($_POST['secretquestion']) ? $_POST['secretquestion'] : '';
		$secretanswer 			= isset($_POST['secretanswer']) ? $_POST['secretanswer'] : '';
		
		$flag = 1;
		
		if(empty($username)){
			
			$errors['type'] = 'username';
			$errors['msg'] = '* Enter username';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		/*
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
		*/
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
			
			$stepscovered[] = 'step3';
			$_SESSION['steps'] = $stepscovered;
			
			header("Location:".BASE_URL.$_SESSION['currentLang'].'/loanremainingdata/'.$loanid.'/step3');
			exit;
		}		
	}
	else if($stepcount == 'step3'){
		
		if(count($_POST)){
			
			foreach($_POST as $key=>$val){
				
				$_POST[$key] = trim(htmlspecialchars($val));
			}
		}
		
		$bankname 				= isset($_POST['bankname']) ? $_POST['bankname'] : '';
		//$accountnumber 			= isset($_POST['accountnumber']) ? $_POST['accountnumber'] : '';
		$nameofaccountholder 	= isset($_POST['nameofaccountholder']) ? $_POST['nameofaccountholder'] : '';
		//$bicnumber 				= isset($_POST['bicnumber']) ? $_POST['bicnumber'] : '';
		$ibannumber 			= isset($_POST['ibannumber']) ? $_POST['ibannumber'] : '';
		$timewithbank 			= isset($_POST['timewithbank']) ? $_POST['timewithbank'] : '';
		$nameoncard 			= isset($_POST['nameoncard']) ? $_POST['nameoncard'] : '';
		$cardnumber 			= isset($_POST['cardnumber']) ? $_POST['cardnumber'] : '';
		$expirymonth 			= isset($_POST['expirymonth']) ? $_POST['expirymonth'] : '';
		$expiryyear 			= isset($_POST['expiryyear']) ? $_POST['expiryyear'] : '';
		$cvvnumber 				= isset($_POST['cvvnumber']) ? $_POST['cvvnumber'] : '';
		
		$flag = 1;
		
		if(empty($ibannumber)){
			
			$errors['type'] = 'ibannumber';
			$errors['msg'] = '* Enter IBAN number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}else if(!checkIBAN($ibannumber)){
		
			$errors['type'] = 'ibannumber';
			$errors['msg'] = '* Enter valid IBAN account number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
/*
		if(empty($bicnumber)){
			
			$errors['type'] = 'bicnumber';
			$errors['msg'] = '* Enter BIC number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}else if(!checkBic($bicnumber)){
		
			$errors['type'] = 'bicnumber';
			$errors['msg'] = '* Enter valid bic number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		*/
		if(empty($bankname)){
			
			$errors['type'] = 'bankname';
			$errors['msg'] = '* Enter bank name';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		/*
		if(empty($accountnumber)){
			
			$errors['type'] = 'accountnumber';
			$errors['msg'] = '* Enter account number';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		else{
		
			$regex = '/^[A-Z]{2}[0-9]{22}$/';

			preg_match_all($regex, $accountnumber, $matches, PREG_SET_ORDER, 0);
			
			if(!count($matches)){
				
				$errors['type'] = 'accountnumber';
				$errors['msg'] = '* Bank account no must be of 2 Capital Letters and 22 Digits';
				$errorsFinal[] = $errors;
				$flag = 0;
			}
		}
		*/
		if(empty($nameofaccountholder)){
			
			$errors['type'] = 'nameofaccountholder';
			$errors['msg'] = '* Enter name of account holder';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
		/* if(empty($timewithbank)){
			
			$errors['type'] = 'timewithbank';
			$errors['msg'] = '* Enter time with bank';
			$errorsFinal[] = $errors;
			$flag = 0;
		} */
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

		if(isset($_SESSION['wallet_id']) && $_SESSION['wallet_id']!="" && $flag==1){
			$num_padded = sprintf("%02d", $expirymonth);
			
			$RegisterBorrowerCard=	RegisterCard(array("wlLogin" => LOGIN,
											    "wlPass" 	=> PASSWORD,
											    "language" 	=> LANGUAGE,
											    "version" 	=> VERSION,
											    "walletIp" 	=> getUserIP(),
											    "walletUa" 	=> UA,
											    "wallet" 	=> $_SESSION['wallet_id'],
											    "cardType" 	=> "1",
											    "cardNumber" => trim($cardnumber),
											    "cardCode" 	=> trim($cvvnumber),
											    "cardDate" 	=> trim($num_padded."/".$expiryyear)
											));
			
			if(isset($RegisterBorrowerCard->RegisterCardResult->E->Msg)){
				$errors['type'] = 'cardnumber';
				$errors['msg'] = $RegisterBorrowerCard->RegisterCardResult->E->Msg;
				$errorsFinal[] = $errors;
				$flag = 0;
			}else{
				$cardid=$RegisterBorrowerCard->RegisterCardResult->CARD->ID;
			}
/*
			$RegisteredIBAN=RegisterIBAN($_SESSION['wallet_id'],$ibannumber,$accountholder);
			if(isset($RegisteredIBAN->RegisterIBANResult->E->Msg)){
				$errors['type'] = 'ibannumber';
				$errors['msg'] = $RegisteredIBAN->RegisterIBANResult->E->Msg;
				$errorsFinal[] = $errors;
				$flag = 0;
			}else{

			}*/
		}

		
		$errstr = json_encode($errorsFinal);
		
		//echo '<pre>'; print_r($errorsFinal); //exit;
		
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
			
			
			
			$stepscovered[] = 'step4';
			$_SESSION['steps'] = $stepscovered;
			
			
			
			// Insert to DB
			
			$time = time();
			
			$customerdata = $_SESSION['customerdata'];
			//echo '<pre>'; print_r($customerdata); exit;
			
			if(isset($_SESSION['userid'])){
				// bicnumber = '".addslashes($customerdata['bicnumber'])."',
				// accountnumber = '".addslashes($customerdata['accountnumber'])."',
				$insertSql = "UPDATE ".TABLE_PREFIX."backoffice_borrowers SET
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
									  housenumber = '".addslashes($customerdata['housenumber'])."',
									  streetname = '".addslashes($customerdata['streetname'])."',
									  suburb = '".addslashes($customerdata['suburb'])."',
									  city = '".addslashes($customerdata['city'])."',
									  province = '".addslashes($customerdata['province'])."',
									  postcode = '".addslashes($customerdata['postcode'])."',
							  		  secretquestion = '".addslashes($customerdata['secretquestion'])."',
									  secretanswer = '".addslashes($customerdata['secretanswer'])."',
									  bankname = '".addslashes($customerdata['bankname'])."',
									  ibannumber = '".addslashes($customerdata['ibannumber'])."',
									  nameofaccountholder = '".addslashes($customerdata['nameofaccountholder'])."',
									  nameoncard = '".addslashes($customerdata['nameoncard'])."',
									  cardnumber = '".addslashes($customerdata['cardnumber'])."',
									  expirymonth = '".addslashes($customerdata['expirymonth'])."',
									  expiryyear = '".addslashes($customerdata['expiryyear'])."',
									  cvvnumber = '".addslashes($customerdata['cvvnumber'])."',
									  dob = '".addslashes($customerdata['dob'])."',
									  cardid = '".addslashes($cardid)."'

							  		  WHERE id='".$_SESSION['userid']."'";
							 
				$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());
				$borrower_id =  $_SESSION['userid'];
				/*if($borrower_id){
						$payerWallet = uniqid("PHP-Borrower-");
						$response = RegisterWallet(array(
							    "wlLogin" 			=> LOGIN,
							    "wlPass" 			=> PASSWORD,
							    "language" 			=> LANGUAGE,
							    "version" 			=> VERSION,
							    "walletIp" 			=> getUserIP(),
							    "walletUa" 			=> UA,
							    "wallet" 			=> $payerWallet,
							    "clientMail" 		=> $customerdata['emailaddress'],
								"clientFirstName" 	=> $customerdata['firstname'],
								"clientLastName" 	=> $customerdata['surname']
							));
						if(isset($response->RegisterWalletResult->E)){
							$errors[]=$response->RegisterWalletResult->E->Msg;
						}else{
							$receiverwalletid=	$response->RegisterWalletResult->WALLET->ID;
							$wherarr=array("id"=>$borrower_id);
							$updatearr=array("wallet_id"=>$receiverwalletid);
							updateQuery("backoffice_borrowers",$wherarr,$updatearr);
						}
				}*/		
			}
			else{
				
				$borrower_id = $_SESSION['userid'];
			}
			
			//$loan_unique_id = 'SMC-'.$time.'-'.$borrower_id.rand(100000,999999);
			
						
			$insertSql = "UPDATE  ".TABLE_PREFIX."backoffice_loan_documents SET
						  document_path = '".addslashes($customerdata['lastpayslip'])."'
						  WHERE loan_id=".$loanid." and document_type = 'lastpayslip'";
			$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());	

			$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_loan_documents SET
						  loan_id = '".addslashes($loanid)."',
						  document_type = 'bankcertificate',
						  type = 'useruploaded',
						  document_path = '".addslashes($customerdata['bankcertificate'])."',
						  createdate = '".addslashes($time)."'";
			$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());
			
			if(!empty($customerdata['idproof'])){
				
				$insertSql = "UPDATE  ".TABLE_PREFIX."backoffice_loan_documents SET
							  document_path = '".addslashes($customerdata['idproof'])."'
							  WHERE loan_id=".$loanid." and document_type = 'idproof'";
				$insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());	
			}
			/*
			if(!empty($customerdata['budgetattachment'])){
				
				$insertSql = "INSERT INTO ".TABLE_PREFIX."backoffice_loan_documents SET
							  loan_id = '".addslashes($loan_id)."',
							  document_type = 'budgetattachment',
							  type = 'useruploaded',
							  document_path = '".addslashes($customerdata['budgetattachment'])."',
							  createdate = '".addslashes($time)."'";
							  
				$insertQry = mysql_query($insertSql) or die(mysql_error());	
			}
			*/
			
			// Generate Files and Send Mail
			
			$request = curl_init(BASE_URL.'backoffice/generatepdf/'.$loan_id);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($request);
			curl_close($request);
			
			$_SESSION['customerdata']['loanid'] = $loan_id;
			$_SESSION['customerdata']['borrowerid'] = $borrower_id;
			
			
			header("Location:".BASE_URL.$_SESSION['currentLang'].'/loanremainingdata/'.$loanid.'/step4');
			exit;
		}
	}
	else if($stepcount == 'step4'){
		
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
			
			$stepscovered[] = 'step5';
			$_SESSION['steps'] = $stepscovered;
			
			$mobile = COUNTRY_PREFIX.$_SESSION['customerdata']['cellphonenumber'];
			
			$randomCode = rand(100000,999999);
			
			$message = $randomCode." is your 6 digit verification code for ".PROJECT_NAME;
			
			$_SESSION['customerdata']['otpsent'] = $randomCode;
			
			sendsms($mobile,$message);
			
			header("Location:".BASE_URL.$_SESSION['currentLang'].'/loanremainingdata/'.$loanid.'/step5');
			exit;
		}
	}
	else if($stepcount == 'step5'){
		
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

			$updateQry = "UPDATE ".TABLE_PREFIX."backoffice_loan_applications SET
						  status = 'pending'
						  WHERE id = '".$loanid."'";
			
			mysqli_query($con,$updateQry) or die(mysqli_error());	
			
			$stepscovered[] = 'thankyou';
			$_SESSION['steps'] = $stepscovered;
			
			header("Location:".BASE_URL.$_SESSION['currentLang'].'/loanremainingdata/'.$loanid.'/thankyou');
			exit;
		}
	}
}

?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container loanpagecontainer">
	
		<!-- Form -->
		<?php
		if($step == 'step1'){
			
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
							<input type="text" name="firstname" id="firstname" value="<?php echo($firstname); ?>" placeholder="<?php echo($transArr['First Name']); ?>"/>
						</div>
						
						<div class="4u 12u$(4)">
							<input type="text" name="surname" id="surname" value="<?php echo($surname); ?>" placeholder="<?php echo($transArr['Surname']); ?>"/>
						</div>
						<div class="4u 12u$(4)">
							<input type="text" name="second_surname" id="second_surname" value="<?php echo($second_surname); ?>" placeholder="<?php echo($transArr['Second Surname']); ?>"/>
						</div>
						<div class="4u$ 12u$(4)">
							<input type="text" name="dob" id="dob" value="<?php echo($dob); ?>" placeholder="<?php echo($transArr['Date of Birth']); ?>"/>
						</div>
					</div>
					
					<h3>Your Details</h3>
					
					
					<div class="row uniform 50%">						
						<div class="4u 12u$(4)">
							<div class="select-wrapper">
								<select name="status" id="status">
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
								<select name="maritalstatus" id="maritalstatus">
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
							
							<div class="select-wrapper">
								<select name="noofdependants" id="noofdependants">
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
					
					
					<h3><?php echo($transArr['Employment Details']); ?></h3>
					<div class="row uniform 50%">						
						<div class="12u$">
							<div class="select-wrapper">
								<select name="employmenttype" id="employmenttype">
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
							<input type="text" name="employercompanyname" id="employercompanyname" value="<?php echo($employercompanyname); ?>" placeholder="<?php echo($transArr['Employer Company Name']); ?>"/>
						</div>
						<div class="4u 12u$(4)">
							<input type="text" name="grossmonthlyincome" id="grossmonthlyincome" value="<?php echo($grossmonthlyincome); ?>" placeholder="<?php echo($transArr['Gross Monthly Income']); ?>"/>
						</div>
						<div class="4u$ 12u$(4)">
							<input type="text" name="netmonthlyincome" id="netmonthlyincome" value="<?php echo($netmonthlyincome); ?>" placeholder="<?php echo($transArr['Net Monthly Income']); ?>"  />
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<div class="12u$">
							<div class="select-wrapper">
								<select name="servicetype" id="servicetype">
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
							<input type="text" name="timewithemployer" id="timewithemployer" value="<?php echo($timewithemployer); ?>" placeholder="<?php echo($transArr['Time With Employer in Years']); ?>"/>
						</div>
						<div class="6u$ 12u$(6)">
							<input type="text" name="workphonenumber" id="workphonenumber" value="<?php echo($workphonenumber); ?>" placeholder="<?php echo($transArr['Work Phone Number']); ?>"/>
						</div>
						
					</div>
										
					<h3>Contacting You</h3>
					<div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input type="text" name="cellphonenumber" id="cellphonenumber" value="<?php echo($cellphonenumber); ?>" placeholder="<?php echo($transArr['Cell Phone Number']); ?>"/>
						</div>
						<div class="6u$ 12u$(6)">
							<input type="text" name="alternatenumber" id="alternatenumber" value="<?php echo($alternatenumber); ?>" placeholder="<?php echo($transArr['Alternate Number']); ?>"/>
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input disabled="" type="text" name="emailaddress" id="emailaddress" value="<?php echo($emailaddress); ?>" placeholder="<?php echo($transArr['Email Address']); ?>"/>
						</div>
						
					</div>
					
					<h2><?php echo($transArr['Address Details']); ?></h2>
					
					<div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input type="text" name="housenumber" id="housenumber" value="<?php echo($housenumber); ?>" placeholder="<?php echo($transArr['House Number']); ?>"/>
						</div>
						<div class="6u$ 12u$(6)">
							<input type="text" name="streetname" id="streetname" value="<?php echo($streetname); ?>" placeholder="<?php echo($transArr['Street Name']); ?>"/>
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<?php /* ?><div class="6u 12u$(6)">
							<input type="text" name="suburb" id="suburb" value="<?php echo($suburb); ?>" placeholder="<?php echo($transArr['Suburb']); ?>" />
						</div><?php */ ?>
						<div class="12u$ 12u$(6)">
							<input type="text" name="city" id="city" value="<?php echo($city); ?>" placeholder="<?php echo($transArr['City']); ?>"/>
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<div class="6u 12u$(6)">
							<input type="text" name="province" id="province" value="<?php echo($province); ?>" placeholder="<?php echo($transArr['Province']); ?>"/>
						</div>
						<div class="6u$ 12u$(6)">
							<input type="text" name="postcode" id="postcode" value="<?php echo($postcode); ?>" placeholder="<?php echo($transArr['Postcode']); ?>"/>
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
		else if($step == 'step2'){
			
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
		else if($step == 'step3'){
			
			?>
			<header class="major">
				<h2><?php echo($transArr['Provide Your Bank Details']); ?></h2>
			</header>
			
			<section>
				
				<form method="post" action="<?=$_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
					
					<input type="hidden" name="stepcount" value="<?=$step?>">
				
					<h2><?php echo($transArr['Bank Details']); ?></h2>
				
					<div class="row uniform 50%">
						
						<div class="12u$">
							<input type="text" name="bankname" id="bankname" value="<?php echo($bankname); ?>" placeholder="<?php echo($transArr['Bank Name']); ?>"/>
						</div>
						
						<div class="12u$">
							<input type="text" name="nameofaccountholder" id="nameofaccountholder" value="<?php echo($nameofaccountholder); ?>" placeholder="<?php echo($transArr['Name of Account Holder']); ?>"/>
						</div>
						
					</div>
					<div class="row uniform 50%">
						
						<div class="12u$">
							<input type="text" name="ibannumber" id="ibannumber" value="<?php echo($ibannumber); ?>" placeholder="<?php echo($transArr['IBAN Number']); ?>"/>
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
							<input type="text" name="nameoncard" id="nameoncard" value="<?php echo($nameoncard); ?>" placeholder="<?php echo($transArr['Name on Card']); ?>"/>
						</div>
						<div class="12u$">
							<input type="text" name="cardnumber" id="cardnumber" value="<?php echo($cardnumber); ?>" placeholder="<?php echo($transArr['Card Number']); ?>"/>
						</div>
						<div class="6u 12u$(6)">
							<div class="select-wrapper">
								<select name="expirymonth" id="expirymonth">
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
								<select name="expiryyear" id="expiryyear">
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
							<input type="text" name="cvvnumber" id="cvvnumber" value="<?php echo($cvvnumber); ?>" placeholder="CVV"/>
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
		else if($step == 'step5'){
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
							<p class="loanacceptedtxt"><?php echo($transArr['The loan application form has been sent successfully!']); ?>!</p>
						</div>
					</div>
					<div class="row uniform 50%">						
						<div class="12u$ loansuccess">
							<p class="loanacceptedtxt"><?php echo($transArr['The patient must continue with the hiring process following the link that has been sent to his / her inbox, he / she must fill in the information until the contracting process is finished.']); ?></p>
						</div>
					</div>
					
					<div class="row uniform 50%">						
						<div class="12u$">
							<p><?php echo($transArr['If the requested loan is approved, we will confirm the acceptance of the loan as soon as possible, and you will be able to check all the information in your own "User Area".']); ?>.</p>
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
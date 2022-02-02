<?php 
require_once('header.php');

if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/borrower-signin');
	exit;
}

$getdetailsRow = selectQuery("backoffice_borrowers","id = '".$_SESSION['userid']."'",$con);

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

$username=trim(stripslashes($getdetailsRow['username']));
$firstname = trim(stripslashes($getdetailsRow['firstname']));
$surname = trim(stripslashes($getdetailsRow['surname']));
$second_surname = trim(stripslashes($getdetailsRow['second_surname']));
$emailaddress = trim(stripslashes($getdetailsRow['emailaddress']));
$dob = trim(stripslashes($getdetailsRow['dob']));
$idnumber = trim(stripslashes($getdetailsRow['idnumber']));
$status = trim(stripslashes($getdetailsRow['status']));
$maritalstatus = trim(stripslashes($getdetailsRow['maritalstatus']));
$noofdependants = trim(stripslashes($getdetailsRow['noofdependants']));
$employmenttype = trim(stripslashes($getdetailsRow['employmenttype']));
$employercompanyname = trim(stripslashes($getdetailsRow['employercompanyname']));
$grossmonthlyincome = trim(stripslashes($getdetailsRow['grossmonthlyincome']));

$netmonthlyincome = trim(stripslashes($getdetailsRow['netmonthlyincome']));
$servicetype = trim(stripslashes($getdetailsRow['servicetype']));
$timewithemployer = trim(stripslashes($getdetailsRow['timewithemployer']));
$workphonenumber = trim(stripslashes($getdetailsRow['workphonenumber']));
$cellphonenumber = trim(stripslashes($getdetailsRow['cellphonenumber']));
$alternatenumber = trim(stripslashes($getdetailsRow['alternatenumber']));
$streetname = trim(stripslashes($getdetailsRow['streetname']));
$city = trim(stripslashes($getdetailsRow['city']));

$province = trim(stripslashes($getdetailsRow['province']));
$postcode = trim(stripslashes($getdetailsRow['postcode']));
$secretquestion = trim(stripslashes($getdetailsRow['secretquestion']));
$secretanswer = trim(stripslashes($getdetailsRow['secretanswer']));

$bankname = trim(stripslashes($getdetailsRow['bankname']));
//$accountnumber = trim(stripslashes($getdetailsRow['accountnumber']));
$ibannumber = trim(stripslashes($getdetailsRow['ibannumber']));
//$bicnumber = trim(stripslashes($getdetailsRow['bicnumber']));
$nameofaccountholder = trim(stripslashes($getdetailsRow['nameofaccountholder']));

$nameoncard = trim(stripslashes($getdetailsRow['nameoncard']));
$cardnumber = trim(stripslashes($getdetailsRow['cardnumber']));
$expirymonth = trim(stripslashes($getdetailsRow['expirymonth']));
$expiryyear = trim(stripslashes($getdetailsRow['expiryyear']));
$cvvnumber = trim(stripslashes($getdetailsRow['cvvnumber']));

if(isset($_POST["submit"])){
//print_r($_POST);

if(count($_POST)){
			
foreach($_POST as $key=>$val){
	
	$_POST[$key] = trim(htmlspecialchars($val));
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
$housenumber 			= isset($_POST['housenumber']) ? $_POST['housenumber'] : '';
$streetname 			= isset($_POST['streetname']) ? $_POST['streetname'] : '';
$suburb 				= isset($_POST['suburb']) ? $_POST['suburb'] : '';
$city 					= isset($_POST['city']) ? $_POST['city'] : '';
$province 				= isset($_POST['province']) ? $_POST['province'] : '';
$postcode 				= isset($_POST['postcode']) ? $_POST['postcode'] : '';


$bankname 				= isset($_POST['bankname']) ? $_POST['bankname'] : '';
$nameofaccountholder 	= isset($_POST['nameofaccountholder']) ? $_POST['nameofaccountholder'] : '';
$nameoncard 			= isset($_POST['nameoncard']) ? $_POST['nameoncard'] : '';
$cardnumber 			= isset($_POST['cardnumber']) ? $_POST['cardnumber'] : '';
$expirymonth 			= isset($_POST['expirymonth']) ? $_POST['expirymonth'] : '';
$expiryyear 			= isset($_POST['expiryyear']) ? $_POST['expiryyear'] : '';
$cvvnumber 				= isset($_POST['cvvnumber']) ? $_POST['cvvnumber'] : '';
$password 			    = isset($_POST['password']) ? $_POST['password'] : '';
$ibannumber 			= isset($_POST['ibannumber']) ? $_POST['ibannumber'] : '';
$secretquestion 		= isset($_POST['secretquestion']) ? $_POST['secretquestion'] : '';
$secretanswer 			= isset($_POST['secretanswer']) ? $_POST['secretanswer'] : '';
//$bicnumber 			    = isset($_POST['bicnumber']) ? $_POST['bicnumber'] : '';


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
		}*/

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

		if(empty($bankname)){
			
			$errors['type'] = 'bankname';
			$errors['msg'] = '* Enter bank name';
			$errorsFinal[] = $errors;
			$flag = 0;
		}

		if(empty($nameofaccountholder)){
			
			$errors['type'] = 'nameofaccountholder';
			$errors['msg'] = '* Enter name of account holder';
			$errorsFinal[] = $errors;
			$flag = 0;
		}

		$errstr = json_encode($errorsFinal);


if($flag == 1){
						 // bicnumber  = '".addslashes($bicnumber)."',
	$updateSql = "UPDATE ".TABLE_PREFIX."backoffice_borrowers SET 
					  username = '".addslashes($username)."',
					  firstname = '".addslashes($firstname)."',
					  middlename = '".addslashes($middlename)."',
					  surname = '".addslashes($surname)."',
					  second_surname = '".addslashes($second_surname)."',
					  homelanguage = '".addslashes($homelanguage)."',
					  status = '".addslashes($status)."',
					  maritalstatus = '".addslashes($maritalstatus)."',
					  noofdependants = '".addslashes($noofdependants)."',	
					  employmenttype = '".addslashes($employmenttype)."',
					  employercompanyname = '".addslashes($employercompanyname)."',
					  grossmonthlyincome = '".addslashes($grossmonthlyincome)."',
					  netmonthlyincome = '".addslashes($netmonthlyincome)."',
					  servicetype = '".addslashes($servicetype)."',
					  timewithemployer = '".addslashes($timewithemployer)."',
					  workphonenumber = '".addslashes($workphonenumber)."',
					  housenumber = '".addslashes($housenumber)."',
					  streetname = '".addslashes($streetname)."',
					  suburb = '".addslashes($suburb)."',
					  city = '".addslashes($city)."',
					  province = '".addslashes($province)."',
					  postcode = '".addslashes($postcode)."',
					  secretquestion = '".addslashes($secretquestion)."',
					  secretanswer = '".addslashes($secretanswer)."',
					  bankname = '".addslashes($bankname)."',
					  ibannumber = '".addslashes(str_replace(" ","",$ibannumber))."',
					  nameoncard = '".addslashes($nameoncard)."',
					  cardnumber = '".addslashes($cardnumber)."',
					  expirymonth = '".addslashes($expirymonth)."',
					  expiryyear = '".addslashes($expiryyear)."',
					  cvvnumber = '".addslashes($cvvnumber)."'

					  WHERE id = '".$_SESSION['userid']."'";
					  mysqli_query($con,$updateSql) or die(mysqli_error());
					
}
//echo $updateSql;

if(!empty($password)){

			$updateSql = updateQuery("backoffice_borrowers",
									array("id"=>$_SESSION['userid']),
									array("password"=>addslashes(md5($password))),
									$con);
						  
		}

}
}

?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container loanpagecontainer">
	
		<header class="major myaccountheader">
			<h2><?php echo($transArr['My Account']); ?></h2>
		</header>
		
		<section>
			
			<?php if(empty($getdetailsRow['cardnumber'])){ ?>
				<form method="post" action="<?=$_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
				
				<input type="hidden" name="stepcount" value="<?=$step?>">
				<input type="hidden" name="borrower_id" value="<?=$_SESSION['userid']?>">
			
				<h2><?php echo($transArr['Personal Details']); ?></h2>
			
				<h3><?php echo($transArr['Your Name']); ?></h3>
				<div class="row uniform 50%">
					
					<div class="4u 12u$(4)">
						<input type="text" name="firstname" id="firstname" value="<?php echo($firstname); ?>" placeholder="<?php echo($transArr['First Name']); ?>" />
					</div>
					<?php /* ?><div class="4u 12u$(4)">
						<input type="text" name="middlename" id="middlename" value="<?php echo($middlename); ?>" placeholder="<?php echo($transArr['Middle Name']); ?>" />
					</div><?php */ ?>
					<div class="4u 12u$(4)">
						<input type="text" name="surname" id="surname" value="<?php echo($surname); ?>" placeholder="<?php echo($transArr['Surname']); ?>" />
					</div>
					<div class="4u 12u$(4)">
						<input type="text" name="second_surname" id="second_surname" value="<?php echo($second_surname); ?>" placeholder="<?php echo($transArr['Second Surname']); ?>" />
					</div>
					<div class="4u$ 12u$(4)">
						<input type="text" name="dob" id="dob" value="<?php echo($dob); ?>" placeholder="<?php echo($transArr['Date of Birth']); ?>" />
					</div>
				</div>
				
				<h3>Your Details</h3>
				<div class="row uniform 50%">						
					<div class="12u 12u$(6)">
						<input type="text" name="idnumber" id="idnumber" value="<?php echo($idnumber); ?>" placeholder="<?php echo($transArr['ID Number']); ?>" />
					</div>
					<?php /* ?><div class="6u$ 12u$(6)">
						<input type="text" name="homelanguage" id="homelanguage" value="<?php echo($homelanguage); ?>" placeholder="<?php echo($transArr['Home Language']); ?>" />
					</div><?php */ ?>
				</div>
				
				
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
						<?php /* ?><input type="text" name="noofdependants" id="noofdependants" value="<?php echo($noofdependants); ?>" placeholder="<?php echo($transArr['Number of Dependants']); ?>" /><?php */ ?>
						
						<div class="select-wrapper">
							<select name="noofdependants" id="noofdependants">
								<option value="">- <?php echo($transArr['Number of Dependants']); ?> -</option>
								
								<?php
								for($i=0;$i<=5;$i++){
									
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
						<input type="text" name="employercompanyname" id="employercompanyname" value="<?php echo($employercompanyname); ?>" placeholder="<?php echo($transArr['Employer Company Name']); ?>" />
					</div>
					<div class="4u 12u$(4)">
						<input type="text" name="grossmonthlyincome" id="grossmonthlyincome" value="<?php echo($grossmonthlyincome); ?>" placeholder="<?php echo($transArr['Gross Monthly Income']); ?>" />
					</div>
					<div class="4u$ 12u$(4)">
						<input type="text" name="netmonthlyincome" id="netmonthlyincome" value="<?php echo($netmonthlyincome); ?>" placeholder="<?php echo($transArr['Net Monthly Income']); ?>" />
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
						<input type="text" name="timewithemployer" id="timewithemployer" value="<?php echo($timewithemployer); ?>" placeholder="<?php echo($transArr['Time With Employer in Years']); ?>" />
					</div>
					<div class="6u$ 12u$(6)">
						<input type="text" name="workphonenumber" id="workphonenumber" value="<?php echo($workphonenumber); ?>" placeholder="<?php echo($transArr['Work Phone Number']); ?>" />
					</div>
					<?php /* ?><div class="6u$ 12u$(6)">
						<input type="text" name="university" id="university" value="<?php echo($university); ?>" placeholder="<?php echo($transArr['University']); ?>" />
					</div><?php */ ?>
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
						<input disabled="" type="text" name="cellphonenumber" id="cellphonenumber" value="<?php echo($cellphonenumber); ?>" placeholder="<?php echo($transArr['Cell Phone Number']); ?>" />
					</div>
					<div class="6u$ 12u$(6)">
						<input disabled="" type="text" name="alternatenumber" id="alternatenumber" value="<?php echo($alternatenumber); ?>" placeholder="<?php echo($transArr['Alternate Number']); ?>" />
					</div>
				</div>
				
				<div class="row uniform 50%">						
					<div class="6u 12u$(6)">
						<input disabled="" type="text" name="emailaddress" id="emailaddress" value="<?php echo($emailaddress); ?>" placeholder="<?php echo($transArr['Email Address']); ?>" />
					</div>					
				</div>
				
				<h2><?php echo($transArr['Address Details']); ?></h2>
				
				<div class="row uniform 50%">						
					<div class="6u 12u$(6)">
						<input type="text" name="housenumber" id="housenumber" value="<?php echo($housenumber); ?>" placeholder="<?php echo($transArr['House Number']); ?>" />
					</div>
					<div class="6u$ 12u$(6)">
						<input type="text" name="streetname" id="streetname" value="<?php echo($streetname); ?>" placeholder="<?php echo($transArr['Street Name']); ?>" />
					</div>
				</div>
				
				<div class="row uniform 50%">						
					<?php /* ?><div class="6u 12u$(6)">
						<input type="text" name="suburb" id="suburb" value="<?php echo($suburb); ?>" placeholder="<?php echo($transArr['Suburb']); ?>" />
					</div><?php */ ?>
					<div class="12u$ 12u$(6)">
						<input type="text" name="city" id="city" value="<?php echo($city); ?>" placeholder="<?php echo($transArr['City']); ?>" />
					</div>
				</div>
				
				<div class="row uniform 50%">						
					<div class="6u 12u$(6)">
						<input type="text" name="province" id="province" value="<?php echo($province); ?>" placeholder="<?php echo($transArr['Province']); ?>" />
					</div>
					<div class="6u$ 12u$(6)">
						<input type="text" name="postcode" id="postcode" value="<?php echo($postcode); ?>" placeholder="<?php echo($transArr['Postcode']); ?>" />
					</div>
				</div>
				
				
				<h2><?php echo($transArr['Account Setup']); ?></h2>
				
				<div class="row uniform 50%">
					
					<div class="12u$">
						<input type="text" name="username" id="username" value="<?php echo($username); ?>" placeholder="<?php echo($transArr['User Name']); ?>" />
					</div>
					<div class="12u$">
						<input type="password" name="password" id="password" value="<?php echo($password); ?>" placeholder="<?php echo($transArr['Choose Password']); ?>" />
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
				
				
				
				<h2><?php echo($transArr['Bank Details']); ?></h2>
				
				<div class="row uniform 50%">
					
					<div class="12u$">
						<input type="text" name="bankname" id="bankname" value="<?php echo($bankname); ?>" placeholder="<?php echo($transArr['Bank Name']); ?>" />
					</div>
					<!-----
					<div class="12u$">
						<input disabled="" type="text" name="accountnumber" id="accountnumber" value="<?php //echo($accountnumber); ?>" placeholder="<?php //echo($transArr['Account Number']); ?>" />
					</div>
					--->
					<div class="12u$">
						<input type="text" name="nameofaccountholder" id="nameofaccountholder" value="<?php echo($nameofaccountholder); ?>" placeholder="<?php echo($transArr['Name of Account Holder']); ?>" />
					</div>
					<?php /* ?><div class="12u$">
						<input type="text" name="timewithbank" id="timewithbank" value="<?php echo($timewithbank); ?>" placeholder="<?php echo($transArr['Time with Bank']); ?>" />
					</div><?php */ ?>
				</div>
				<div class="row uniform 50%">
						<!----
						<div class="12u$">
							<input type="text" name="bicnumber" id="bicnumber" value="<?php echo($bicnumber); ?>" placeholder="<?php //echo($transArr['BIC Number']); ?>"  <?php //echo(in_array('bicnumber',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						---->
						<div class="12u$">
							<input class="iban_format" type="text" name="ibannumber" id="ibannumber" value="<?php echo($ibannumber); ?>" placeholder="<?php echo($transArr['IBAN Number']); ?>"  <?php echo(in_array('ibannumber',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						
					</div>
				
				
				<h2><?php echo($transArr['Credit Card Details']); ?></h2>
			
				<div class="row uniform 50%">
					
					<div class="12u$">
						<input type="text" name="nameoncard" id="nameoncard" value="<?php echo($nameoncard); ?>" placeholder="<?php echo($transArr['Name on Card']); ?>" />
					</div>
					<div class="12u$">
						<input type="text" name="cardnumber" id="cardnumber" value="<?php echo($cardnumber); ?>" placeholder="<?php echo($transArr['Card Number']); ?>" />
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
						<input type="text" name="cvvnumber" id="cvvnumber" value="<?php echo($cvvnumber); ?>" placeholder="CVV" />
					</div>
				</div>

				
				<div class="row uniform 50%">						
					<div class="12u$">
						<ul class="actions">
							<li><input name="submit" type="submit" value="<?php echo($transArr['Continue']); ?>" class="special" /></li>
						</ul>
					</div>
				</div>
				</form>
				

<?php			}else{ ?>
					<form method="post" action="<?=$_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
				
				<input type="hidden" name="stepcount" value="<?=$step?>">
				<input type="hidden" name="borrower_id" value="<?=$_SESSION['userid']?>">
			
				<h2><?php echo($transArr['Personal Details']); ?></h2>
			
				<h3><?php echo($transArr['Your Name']); ?></h3>
				<div class="row uniform 50%">
					
					<div class="4u 12u$(4)">
						<input disabled="" type="text" name="firstname" id="firstname" value="<?php echo($firstname); ?>" placeholder="<?php echo($transArr['First Name']); ?>" />
					</div>
					<?php /* ?><div class="4u 12u$(4)">
						<input type="text" name="middlename" id="middlename" value="<?php echo($middlename); ?>" placeholder="<?php echo($transArr['Middle Name']); ?>" />
					</div><?php */ ?>
					<div class="4u 12u$(4)">
						<input disabled="" type="text" name="surname" id="surname" value="<?php echo($surname); ?>" placeholder="<?php echo($transArr['Surname']); ?>" />
					</div>
					<div class="4u 12u$(4)">
						<input disabled="" type="text" name="second_surname" id="second_surname" value="<?php echo($second_surname); ?>" placeholder="<?php echo($transArr['Second Surname']); ?>" />
					</div>
					<div class="4u$ 12u$(4)">
						<input disabled="" type="text" name="dob" id="dob" value="<?php echo($dob); ?>" placeholder="<?php echo($transArr['Date of Birth']); ?>" readonly />
					</div>
				</div>
				
				<h3>Your Details</h3>
				<div class="row uniform 50%">						
					<div class="12u 12u$(6)">
						<input disabled="" type="text" name="idnumber" id="idnumber" value="<?php echo($idnumber); ?>" placeholder="<?php echo($transArr['ID Number']); ?>" />
					</div>
					<?php /* ?><div class="6u$ 12u$(6)">
						<input type="text" name="homelanguage" id="homelanguage" value="<?php echo($homelanguage); ?>" placeholder="<?php echo($transArr['Home Language']); ?>" />
					</div><?php */ ?>
				</div>
			
				<div class="row uniform 50%">						
					<div class="4u 12u$(4)">
						<div class="select-wrapper">
							<select name="status" id="status" disabled="">
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
							<select disabled="" name="maritalstatus" id="maritalstatus">
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
							<select disabled="" name="noofdependants" id="noofdependants">
								<option value="">- <?php echo($transArr['Number of Dependants']); ?> -</option>
								
								<?php
								for($i=0;$i<=5;$i++){
									
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
							<select disabled="" name="employmenttype" id="employmenttype">
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
						<input disabled="" type="text" name="employercompanyname" id="employercompanyname" value="<?php echo($employercompanyname); ?>" placeholder="<?php echo($transArr['Employer Company Name']); ?>" />
					</div>
					<div class="4u 12u$(4)">
						<input disabled="" type="text" name="grossmonthlyincome" id="grossmonthlyincome" value="<?php echo($grossmonthlyincome); ?>" placeholder="<?php echo($transArr['Gross Monthly Income']); ?>" />
					</div>
					<div class="4u$ 12u$(4)">
						<input disabled="" type="text" name="netmonthlyincome" id="netmonthlyincome" value="<?php echo($netmonthlyincome); ?>" placeholder="<?php echo($transArr['Net Monthly Income']); ?>" />
					</div>
				</div>
				
				<div class="row uniform 50%">						
					<div class="12u$">
						<div class="select-wrapper">
							<select disabled="" name="servicetype" id="servicetype">
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
						<input disabled="" type="text" name="timewithemployer" id="timewithemployer" value="<?php echo($timewithemployer); ?>" placeholder="<?php echo($transArr['Time With Employer in Years']); ?>" />
					</div>
					<div class="6u$ 12u$(6)">
						<input disabled="" type="text" name="workphonenumber" id="workphonenumber" value="<?php echo($workphonenumber); ?>" placeholder="<?php echo($transArr['Work Phone Number']); ?>" />
					</div>
					<?php /* ?><div class="6u$ 12u$(6)">
						<input type="text" name="university" id="university" value="<?php echo($university); ?>" placeholder="<?php echo($transArr['University']); ?>" />
					</div><?php */ ?>
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
						<input disabled="" type="text" name="cellphonenumber" id="cellphonenumber" value="<?php echo($cellphonenumber); ?>" placeholder="<?php echo($transArr['Cell Phone Number']); ?>" />
					</div>
					<div class="6u$ 12u$(6)">
						<input disabled="" type="text" name="alternatenumber" id="alternatenumber" value="<?php echo($alternatenumber); ?>" placeholder="<?php echo($transArr['Alternate Number']); ?>" />
					</div>
				</div>
				
				<div class="row uniform 50%">						
					<div class="6u 12u$(6)">
						<input disabled="" type="text" name="emailaddress" id="emailaddress" value="<?php echo($emailaddress); ?>" placeholder="<?php echo($transArr['Email Address']); ?>" />
					</div>
					
				</div>
				
				<h2><?php echo($transArr['Address Details']); ?></h2>
				
				<div class="row uniform 50%">						
					<div class="6u 12u$(6)">
						<input disabled="" type="text" name="housenumber" id="housenumber" value="<?php echo($housenumber); ?>" placeholder="<?php echo($transArr['House Number']); ?>" />
					</div>
					<div class="6u$ 12u$(6)">
						<input disabled="" type="text" name="streetname" id="streetname" value="<?php echo($streetname); ?>" placeholder="<?php echo($transArr['Street Name']); ?>" />
					</div>
				</div>
				
				<div class="row uniform 50%">						
					<?php /* ?><div class="6u 12u$(6)">
						<input type="text" name="suburb" id="suburb" value="<?php echo($suburb); ?>" placeholder="<?php echo($transArr['Suburb']); ?>" />
					</div><?php */ ?>
					<div class="12u$ 12u$(6)">
						<input disabled="" type="text" name="city" id="city" value="<?php echo($city); ?>" placeholder="<?php echo($transArr['City']); ?>" />
					</div>
				</div>
				
				<div class="row uniform 50%">						
					<div class="6u 12u$(6)">
						<input disabled="" type="text" name="province" id="province" value="<?php echo($province); ?>" placeholder="<?php echo($transArr['Province']); ?>" />
					</div>
					<div class="6u$ 12u$(6)">
						<input disabled="" type="text" name="postcode" id="postcode" value="<?php echo($postcode); ?>" placeholder="<?php echo($transArr['Postcode']); ?>" />
					</div>
				</div>
				
				
				<h2><?php echo($transArr['Account Setup']); ?></h2>
				
				<div class="row uniform 50%">
					
					<div class="12u$">
						<input disabled="" type="text" name="username" id="username" value="<?php echo($username); ?>" placeholder="<?php echo($transArr['User Name']); ?>" />
					</div>
					<div class="12u$">
						<input type="password" name="password" id="password" value="<?php echo($password); ?>" placeholder="<?php echo($transArr['Choose Password']); ?>" />
					</div>
					<div class="12u$">
						<div class="select-wrapper">
							<select disabled="" name="secretquestion" id="secretquestion">
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
						<input disabled="" type="text" name="secretanswer" id="secretanswer" value="<?php echo($secretanswer); ?>" placeholder="<?php echo($transArr['Secret Answer']); ?>" />
					</div>
				</div>
				
				
				
				<h2><?php echo($transArr['Bank Details']); ?></h2>
				
				<div class="row uniform 50%">
					
					<div class="12u$">
						<input disabled="" type="text" name="bankname" id="bankname" value="<?php echo($bankname); ?>" placeholder="<?php echo($transArr['Bank Name']); ?>" />
					</div>
					<!-----
					<div class="12u$">
						<input disabled="" type="text" name="accountnumber" id="accountnumber" value="<?php //echo($accountnumber); ?>" placeholder="<?php //echo($transArr['Account Number']); ?>" />
					</div>
					--->
					<div class="12u$">
						<input disabled="" type="text" name="nameofaccountholder" id="nameofaccountholder" value="<?php echo($nameofaccountholder); ?>" placeholder="<?php echo($transArr['Name of Account Holder']); ?>" />
					</div>
					<?php /* ?><div class="12u$">
						<input type="text" name="timewithbank" id="timewithbank" value="<?php echo($timewithbank); ?>" placeholder="<?php echo($transArr['Time with Bank']); ?>" />
					</div><?php */ ?>
				</div>
				<div class="row uniform 50%">
						<!----
						<div class="12u$">
							<input type="text" name="bicnumber" id="bicnumber" value="<?php echo($bicnumber); ?>" placeholder="<?php //echo($transArr['BIC Number']); ?>"  <?php //echo(in_array('bicnumber',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						---->
						<div class="12u$">
							<input disabled="" type="text" name="ibannumber" id="ibannumber" value="<?php echo($ibannumber); ?>" placeholder="<?php echo($transArr['IBAN Number']); ?>"  <?php echo(in_array('ibannumber',$readonly) ? 'class="disabled"' : ''); ?>/>
						</div>
						
					</div>
				
				
				<h2><?php echo($transArr['Credit Card Details']); ?></h2>
			
				<div class="row uniform 50%">
					
					<div class="12u$">
						<input disabled="" type="text" name="nameoncard" id="nameoncard" value="<?php echo($nameoncard); ?>" placeholder="<?php echo($transArr['Name on Card']); ?>" />
					</div>
					<div class="12u$">
						<input disabled="" type="text" name="cardnumber" id="cardnumber" value="<?php echo($cardnumber); ?>" placeholder="<?php echo($transArr['Card Number']); ?>" />
					</div>
					<div class="6u 12u$(6)">
						<div class="select-wrapper">
							<select disabled="" name="expirymonth" id="expirymonth">
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
							<select disabled="" name="expiryyear" id="expiryyear">
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
						<input disabled="" type="text" name="cvvnumber" id="cvvnumber" value="<?php echo($cvvnumber); ?>" placeholder="CVV" />
					</div>
				</div>

				<!----
				<div class="row uniform 50%">						
					<div class="12u$">
						<ul class="actions">
							<li><input name="submit" type="submit" value="<?php echo($transArr['Continue']); ?>" class="special" /></li>
						</ul>
					</div>
				</div>
				</form>
				--->

			<?php } ?>	
			
			
			
			
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

$.extend( true, $.fn.dataTable.defaults, {
    "searching": false
} );

$(document).ready(function() {
    $('#example').DataTable();
	$('#example_length').hide();
});
</script>

<?php 
require_once('footer.php');
?>
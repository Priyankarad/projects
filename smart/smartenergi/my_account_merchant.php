<?php 
require_once('header.php');

if($_SESSION['usertype'] != 'merchant'){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/merchant-signin');
	exit;
}


$getdetailsSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE id = '".$_SESSION['userid']."'";
$getdetailsQry = mysqli_query($con,$getdetailsSql) or die(mysqli_error());
$getdetailsRow = mysqli_fetch_assoc($getdetailsQry);

$merchant_name = trim(stripslashes($getdetailsRow['merchant_name']));
$contact_person = trim(stripslashes($getdetailsRow['contact_person']));
$mobile_no = trim(stripslashes($getdetailsRow['mobile_no']));
$merchant_cif = trim(stripslashes($getdetailsRow['merchant_cif']));
$sector = trim(stripslashes($getdetailsRow['sector']));
$profile_image = trim(stripslashes($getdetailsRow['profile_image']));
$url = trim(stripslashes($getdetailsRow['url']));
$address = trim(stripslashes($getdetailsRow['address']));

$email = trim(stripslashes($getdetailsRow['email']));

/**********/
$company_name = trim(stripslashes($getdetailsRow['company_name']));
$company_email = trim(stripslashes($getdetailsRow['company_email']));
$company_phone = trim(stripslashes($getdetailsRow['company_phone']));
$company_address = trim(stripslashes($getdetailsRow['company_address']));
$shop_address = trim(stripslashes($getdetailsRow['shop_address']));
$shop_phone = trim(stripslashes($getdetailsRow['shop_phone']));
$medical_number=trim(stripslashes($getdetailsRow['collegiate_number']));

$merchant_surname 	=trim(stripslashes($getdetailsRow['merchant_surname'])); 
$bank_account_no = trim(stripslashes($getdetailsRow['iban_number']));
$iban_number	=trim(stripslashes($getdetailsRow['iban_number']));
$account_holder        =trim(stripslashes($getdetailsRow['account_holder'])); 
$street_bank_branch =trim(stripslashes($getdetailsRow['street_bank_branch']));
$bank_branch        =trim(stripslashes($getdetailsRow['bank_branch'])); 
/*********/
$agreement=BASE_URL."backoffice/merchantgeneratedfiles/".trim(stripslashes($getdetailsRow['agreement']));

$values = getVariables($langID,$con);

if(isset($_REQUEST['doupdate']) && !empty($_REQUEST['doupdate']) && $_REQUEST['doupdate'] == 'yes'){
	
	if(count($_POST)){
			
		foreach($_POST as $key=>$val){
			
			$_POST[$key] = trim(htmlspecialchars($val));
		}
	}
	$merchant_name 		= isset($_POST['merchant_name']) ? $_POST['merchant_name'] : '';
	$contact_person 	= isset($_POST['contact_person']) ? $_POST['contact_person'] : '';
	$mobile_no 			= isset($_POST['mobile_no']) ? $_POST['mobile_no'] : '';
	$merchant_cif 		= isset($_POST['merchant_cif']) ? $_POST['merchant_cif'] : '';
	$sector 			= isset($_POST['sector']) ? $_POST['sector'] : '';
	$profile_image		= isset($_FILES['imagefile']['name']) ? $_FILES['imagefile']['name'] : '';
	$url 				= isset($_POST['url']) ? $_POST['url'] : '';
	$address 			= isset($_POST['address']) ? $_POST['address'] : '';
	$password 			= isset($_POST['password']) ? $_POST['password'] : '';
	$confirmpassword 	= isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';
	$bank_account_no 	= isset($_POST['bank_account_no']) ? $_POST['bank_account_no'] : '';
	//$iban_number		= isset($_POST['iban_number']) ? $_POST['iban_number'] : '';

	/**** Pixlr *****/
	$company_name 	= isset($_POST['company_name']) ? $_POST['company_name'] : '';
	$company_email 	= isset($_POST['company_email']) ? $_POST['company_email'] : '';	
	$company_phone 	= isset($_POST['company_phone']) ? $_POST['company_phone'] : '';
	$company_address = isset($_POST['company_address']) ? $_POST['company_address'] : '';
	$shop_address 	= isset($_POST['shop_address']) ? $_POST['shop_address'] : '';
	$shop_phone 	= isset($_POST['shop_phone']) ? $_POST['shop_phone'] : '';
    /**** Pixlr *****/	
    $medical_number=isset($_POST['medical_number']) ? $_POST['medical_number'] : '';

    $merchant_surname 	= isset($_POST['merchant_surname']) ? $_POST['merchant_surname'] : '';
    $account_holder        = isset($_POST['account_holder']) ? $_POST['account_holder'] : '';
	$street_bank_branch = isset($_POST['street_bank_branch']) ? $_POST['street_bank_branch'] : '';
	$bank_branch        = isset($_POST['bank_branch']) ? $_POST['bank_branch'] : '';
	
	$flag = 1;
	
	if(empty($merchant_name)){
		
		$errors['type'] = 'merchant_name';
		$errors['msg'] = '* Enter Merchant First name';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	if(empty($merchant_surname)){
		
		$errors['type'] = 'merchant_surname';
		$errors['msg'] = '* Enter Merchant surname';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	/*else{
			
		$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE merchant_name = '".$merchant_name."' AND id != '".$_SESSION['userid']."'";
		$checkemailSql = mysql_query($checkemailQry) or die(mysql_error());
		$checkemailRow = mysql_fetch_row($checkemailSql);
		
		if(!empty($checkemailRow)){
			
			$errors['type'] = 'merchant_name';
			$errors['msg'] = '* Merchant name is already registered';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
	}*/

	/**** Pixlr ****/
	if(empty($company_name)){
		
		$errors['type'] = 'company_name';
		$errors['msg'] = '* Enter company name';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	if(empty($company_address)){
		
		$errors['type'] = 'company_address';
		$errors['msg'] = '* Enter company address';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	if(empty($company_email)){
		
		$errors['type'] = 'company_email';
		$errors['msg'] = '* Enter company email';
		$errorsFinal[] = $errors;
		$flag = 0;
	}else if(!filter_var($company_email, FILTER_VALIDATE_EMAIL)){
		
		$errors['type'] = 'company_email';
		$errors['msg'] = ' Enter proper company email address';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	if(empty($company_phone)){
		
		$errors['type'] = 'company_phone';
		$errors['msg'] = '* Enter company phone';
		$errorsFinal[] = $errors;
		$flag = 0;
	}else if(is_numeric(empty($company_phone))){
		$errors['type'] = 'company_phone';
		$errors['msg'] = '* Enter company phone must be digits';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	if(empty($shop_address)){
		
		$errors['type'] = 'shop_address';
		$errors['msg'] = '* Enter shop address';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	if(empty($shop_phone)){
		
		$errors['type'] = 'shop_phone';
		$errors['msg'] = '* Enter shop phone';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
    /**** Pixlr ****/

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
/*
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
*/
/*	if(empty($merchant_nie)){
		
		$errors['type'] = 'merchant_nie';
		$errors['msg'] = '* Enter Merchant DNI/NIE number';
		$errorsFinal[] = $errors;
		$flag = 0;
	}else{
		
		$regex = '/^[A-Z][0-8]{7}$/';
		preg_match_all($regex, $merchant_nie, $matches, PREG_SET_ORDER, 0);		
		if(!count($matches)){			
			$errors['type'] = 'merchant_nie';
			$errors['msg'] = '* Merchant DNI/NIE number must be of 1 Capital Letter and 7 Digits';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
	}
*/
	/*if(empty($iban_number)){
		
		$errors['type'] = 'iban_number';
		$errors['msg'] = '* Enter IBAN number';
		$errorsFinal[] = $errors;
		$flag = 0;
	}else{
		if(!checkIBAN($iban_number)){
			
			$errors['type'] = 'iban_number';
			$errors['msg'] = '* Enter correct IBAN Number.';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
	}*/

	if(empty($sector)){
		
		$errors['type'] = 'sector';
		$errors['msg'] = '* Enter Sector';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	if(empty($address)){
		
		$errors['type'] = 'address';
		$errors['msg'] = '* Enter Address';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	if(empty($profile_image) && empty(trim(stripslashes($getdetailsRow['profile_image'])))){
		$errors['type'] = 'imagefile';
		$errors['msg'] = '* Upload Profile Image';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	

	if(empty($bank_account_no)){
		
		$regex = '/^[A-Z]{2}[0-9]{22}$/';

		preg_match_all($regex, $bank_account_no, $matches, PREG_SET_ORDER, 0);
		
		if(!count($matches)){
			
			$errors['type'] = 'bank_account_no';
			$errors['msg'] = '* Bank account no must be of 2 Capital Letters and 22 Digits';
			$errorsFinal[] = $errors;
			$flag = 0;
		}else if(!checkIBAN($bank_account_no)){
				
				$errors['type'] = 'bank_account_no';
				$errors['msg'] = '* Enter correct Bank account no';
				$errorsFinal[] = $errors;
				$flag = 0;
			}
	}
	

	if(empty($account_holder)){			
			$errors['type'] = 'account_holder';
			$errors['msg'] = '* Enter Account holder';
			$errorsFinal[] = $errors;
			$flag = 0;
	}

	if(empty($street_bank_branch)){
			
		$errors['type'] = 'street_bank_branch';
		$errors['msg'] = '* Enter street bank branch';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	if(empty($bank_branch)){
			
		$errors['type'] = 'bank_branch';
		$errors['msg'] = '* Enter bank branch';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	if(!empty($bank_account_no)){
		
		$regex = '/^[A-Z]{2}[0-9]{22}$/';

		preg_match_all($regex, $bank_account_no, $matches, PREG_SET_ORDER, 0);
		
		if(!count($matches)){
			
			$errors['type'] = 'bank_account_no';
			$errors['msg'] = '* Bank account no must be of 2 Capital Letters and 22 Digits';
			$errorsFinal[] = $errors;
			$flag = 0;
		}else if(!checkIBAN($bank_account_no)){
				
				$errors['type'] = 'bank_account_no';
				$errors['msg'] = '* Enter correct Bank account no';
				$errorsFinal[] = $errors;
				$flag = 0;
			}
	}

	if(!empty($password)){
			
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
	}	
	
	$errstr = json_encode($errorsFinal);
	 $aExtraInfo = getimagesize($_FILES['image']['tmp_name']);
	if($flag == 1){
		
		if(!empty($profile_image)){
			$fileExt = end(explode(".",$profile_image));
			$filePath = time().'.'.$fileExt;
			$fileUploadPath = 'images/merchants_pictures/'.$filePath;
			if(!empty($profile_image)){

				$tmp_name = $_FILES['imagefile']['tmp_name'];
				move_uploaded_file($tmp_name, $fileUploadPath);
			}
			$profile_image=$filePath;
		}else{
			$profile_image=trim(stripslashes($getdetailsRow['profile_image']));
			$filePath=trim(stripslashes($getdetailsRow['profile_image']));
		}

		$bankaccountval= substr($bank_account_no, -20);
		$updateSql = "UPDATE ".TABLE_PREFIX."backoffice_merchants SET 
						
					  merchant_name = '".addslashes($merchant_name)."',
					  merchant_surname = '".addslashes($merchant_surname)."',
					  contact_person = '".addslashes($contact_person)."',
					  mobile_no = '".addslashes($mobile_no)."',
					  merchant_cif = '".addslashes($merchant_cif)."',
					  sector = '".addslashes($sector)."',
					  profile_image='".addslashes($filePath)."',
					  url = '".addslashes($url)."',
					  address = '".addslashes($address)."',
					  company_name = '".addslashes($company_name)."',
					  company_email='".addslashes($company_email)."',
					  company_phone = '".addslashes($company_phone)."',
					  company_address = '".addslashes($company_address)."',
					  shop_address = '".addslashes($shop_address)."',
					  shop_phone = '".addslashes($shop_phone)."',
					  bank_branch = '".addslashes($bank_branch)."',
					  street_bank_branch='".($street_bank_branch)."',
					  bank_account_no = '".addslashes($bankaccountval)."',
					  iban_number='".addslashes($bank_account_no)."',
					  account_holder='".addslashes($account_holder)."'

					  WHERE id = '".$_SESSION['userid']."'";
					  
					 mysqli_query($con,$updateSql) or die(mysqli_error());

					

					if(!empty($password)){
						
						$updateSql = "UPDATE ".TABLE_PREFIX."backoffice_merchants SET 
									  password = '".addslashes(md5($password))."'
									  WHERE id = '".$_SESSION['userid']."'";
									  
						mysqli_query($con,$updateSql) or die(mysqli_error());
					}

					/*$request = curl_init(BASE_URL.'backoffice/merchantregister/'.$identifier);
					curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
					$response = curl_exec($request);
					curl_close($request);*/
					
					
					
				//	$_SESSION['merchant_account_created'] = 'yes';
				//	header("Location:".BASE_URL.$_SESSION['currentLang'].'/myaccount/merchant/myprofile?act=updated');
				//	exit;
			
	}
}
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container loanpagecontainer">
		<div class="row 100%">
					<div class="6u 12u$(medium)">
						<header class="major myaccountheader">
							<h2><?php echo($transArr['My Account']); ?></h2>
						</header>
					</div>
					<!----<div class="6u 12u$(medium)">
						<div class="Dinvest-bx">
							
							<h3>MY WALLET <!-- <img src="images/myibtns.svg">  <i class="fa fa-info-circle"></i></h3>
							<div class="Dbody-box">
							<div class="dprice-invest">
								<h1>€ <?php
	if(isset($getdetailsRow['wallet_balance']) && $getdetailsRow['wallet_balance']!="")
	 	echo $getdetailsRow['wallet_balance'];
	else 
		echo "0.00"; 							
								 ?></h1>
							</div>
							<button type="button" class="collaspe_btns"> Details </button>
							<div class="collaspeable_div">
								<table class="table">
								   <tbody>
								        <tr>
								         <td class="info-tooltip text-center"><a href="#"><i class="fa fa-info-circle"></i></a></td>
								         <td>Joined</td>
								         <td class="success nowrap">€ 0.00</td>
								        </tr>
								        <tr>
								         <td class="info-tooltip text-center"><a href="#"><i class="fa fa-info-circle"></i></a></td>
								         <td>Joined</td>
								         <td class="success nowrap">€ 0.00</td>
								        </tr>
								        <tr>
								         <td class="info-tooltip text-center"><a href="#"><i class="fa fa-info-circle"></i></a></td>
								         <td>Joined</td>
								         <td class="success nowrap">€ 0.00</td>
								        </tr>
								        <tr>
								         <td class="info-tooltip text-center"><a href="#"><i class="fa fa-info-circle"></i></a></td>
								         <td>Joined</td>
								         <td class="success nowrap">€ 0.00</td>
								        </tr>
								        <tr>
								         <td class="info-tooltip text-center"><a href="#"><i class="fa fa-info-circle"></i></a></td>
								         <td>Joined</td>
								         <td class="success nowrap">€ 0.00</td>
								        </tr>
								   </tbody>
								</table>
							</div>

							<div class="botones-monedero">
					            
					            <a class="" href="<?=BASE_URL.$_SESSION['currentLang'].'/merchant/withdrawal'?>">Retirar</a>
					        </div>

						</div>
						</div>
					</div>---->
				</div>
	
		
		<section>
			
			<?php
			if($_REQUEST['act'] == 'updated'){
			?>
			<div id="message-success">
			 <i class="icon-ok"></i><?php echo($transArr['Information updated successfully']); ?><br />
			</div>
			<?php
			}
			if(!empty($agreement)){
			?>
				<h2>Terms Agreement PDF</h2>
				<a target="_blank" href="<?=$agreement?>" class="button">Open PDF</a>
			<?php } ?>

			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
			
				<input type="hidden" name="doupdate" value="yes">
				
				<h2 id="personaldetails"><?php echo($transArr['Personal Details']); ?></h2>
				
				<div class="row uniform 50%" style="text-align:left">
					
					<div class="6u 12u$(6)">
						<input type="text" name="merchant_name" id="merchant_name" value="<?php echo($merchant_name); ?>" placeholder="<?php echo($transArr['Merchant Name']); ?>" />						
					</div>

					<div class="6u 12u$(6)">
						<input type="text" name="merchant_surname" id="merchant_surname" value="<?php echo($merchant_surname); ?>" placeholder="<?php echo($transArr['Merchant Surname']); ?>" />						
					</div>

					<div class="6u 12u$(6)">
						<input type="text" name="mobile_no" id="mobile_no" value="<?php echo($mobile_no); ?>" placeholder="<?php echo($transArr['Mobile Phone']); ?>" />
					</div>
					
					
					<div class="12u$">
						<input type="text" name="email" id="email" value="<?php echo($email); ?>" placeholder="<?php echo($transArr['Email']); ?>" readonly/>
					</div>
				</div>
				
				
				<div class="row uniform 50%" style="text-align:left">

					<div class="6u 12u$(6)">
						<input type="text" name="url" id="url" value="<?php echo($url); ?>" placeholder="<?php echo($transArr['URL']); ?>" />
					</div>

					<div class="6u 12u$(6)">
						<input type="text" name="address" id="address" value="<?php echo($address); ?>" placeholder="<?php echo($transArr['Address']); ?>" />
					</div>

					
					<div class="12u$">
						<input type="text" name="medical_number" id="medical_number" value="<?php echo($medical_number); ?>" placeholder="<?php echo($transArr['Medical Collegiate Number']); ?>"  readonly/>
					</div>
					
				</div>


				
				<div class="row uniform 50%" style="text-align:left">
					
					<div class="12u$">
						<div class="images_fsta">
					<div class="mnDiv">
					
						<div class="img_div">
							


							<?php
if(!empty($profile_image)){ ?>
						<div class="s">
							<img class="imageThumb" src="<?php echo(BASE_URL.'images/merchants_pictures/'.trim($profile_image)); ?>"/>
							<span onclick="remove(this)"><i class="fa fa-close"></i></span>
						</div>
					<?php } ?>	
						</div>
						<label class="upld_lbl">
						<label>Upload Profile Image</label>
						<input id="imagefile" name="imagefile" accept=".png, .jpg, .jpeg, .gif" type="file">
						</label>
					</div>
</div>
					</div>
					
				</div>
		<!--- Pixlr ---->		
				<h2 id="companydetails"><?php echo($transArr['Company Details']); ?></h2>
				
				<div class="row uniform 50%" style="text-align:left">
					<div class="6u 12u$(6)">
						<input type="text" name="company_name" id="company_name" value="<?php echo($company_name); ?>" placeholder="Company Name" />
					</div>

					<div class="6u 12u$(6)">
						<input type="email" name="company_email" id="company_email" value="<?php echo($company_email); ?>" placeholder="Company Email" />
					</div>
				</div>

				<div class="row uniform 50%" style="text-align:left">
					<div class="6u 12u$(6)">
						<input type="text" name="merchant_cif" id="merchant_cif" value="<?php echo($merchant_cif); ?>" placeholder="CIF/ID" />
					</div>

					<div class="6u 12u$(6)">
						<input type="text" name="company_phone" id="company_phone" value="<?php echo($company_phone); ?>" placeholder="Company Phone" />
					</div>
				</div>


				<div class="row uniform 50%" style="text-align:left">
					
					<div class="6u 12u$(6)">
						<input type="text" name="contact_person" id="contact_person" value="<?php echo($contact_person); ?>" placeholder="<?php echo($transArr['Contact Person']); ?>" />					
					</div>


					<div class="6u 12u$(6)">
						<div class="select-wrapper">
							<select name="sector" id="sector">
								<option value="">- <?php echo($transArr['Sector']); ?> -</option>
								
								<?php
								foreach($values['merchant_prod_type'] as $key=>$val){
									
									?>
									<option value="<?=$key?>" <?php echo($sector == $key ? 'selected' : ''); ?>><?=$val?></option>
									<?php
								}
								?>
								
							</select>
						</div>
					</div>

					<div class="6u 12u$(6)">
						<input type="text" name="company_address" id="company_address" value="<?php echo($company_address); ?>" placeholder="<?php echo($transArr['Address']); ?>" />
					</div>
					
				</div>

				<h2 id="shop_center"><?php echo($transArr['Shop Center']); ?></h2>
				
				<div class="row uniform 50%" style="text-align:left">
					<div class="6u 12u$(6)">
						<input type="text" name="shop_address" id="shop_address" value="<?php echo($shop_address); ?>" placeholder="Shop Address" />
					</div>

					<div class="6u 12u$(6)">
						<input type="text" name="shop_phone" id="shop_phone" value="<?php echo($shop_phone); ?>" placeholder="Shop Phone" />
					</div>
				</div>

		<!---- Pixlr ---->		
				<h2 id="bankdetails"><?php echo($transArr['Bank Details']); ?></h2>
				
				<div class="row uniform 50%" style="text-align:left">
					
					<div class="12u$">
						<input type="text" name="bank_account_no" id="bank_account_no" value="<?php echo($bank_account_no); ?>" placeholder="<?php echo($transArr['Bank Account No']); ?>" />
					</div>

					<div class="12u$">
						<input type="text" name="bank_branch" id="bank_branch" value="<?php echo($bank_branch); ?>" placeholder="<?php echo($transArr['Bank Branch Name']); ?>" />
					</div>

					<div class="12u$">
						<input type="text" name="street_bank_branch" id="street_bank_branch" value="<?php echo($street_bank_branch); ?>" placeholder="<?php echo($transArr['Bank Branch Street']); ?>" />
					</div>

					<div class="12u$">
						<input type="text" name="account_holder" id="account_holder" value="<?php echo($account_holder); ?>" placeholder="<?php echo($transArr['IBAN Holder']); ?>" />
					</div>

					<!---<div class="12u$">
							<input type="text" name="iban_number" id="iban_number" value="<?php echo($iban_number); ?>" placeholder="<?php echo($transArr['IBAN Number']); ?>" />
						</div>--->
					
				</div>
				
				
				<h2 id="accountdetails"><?php echo($transArr['Account Details']); ?></h2>
				
				<div class="row uniform 50%" style="text-align:left">
					
					
					<div class="12u$">
						<input type="password" name="password" id="password" value="" placeholder="<?php echo($transArr['Password']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="password" name="confirmpassword" id="confirmpassword" value="" placeholder="<?php echo($transArr['Confirm Password']); ?>" />
					</div>
					
				</div>
				
				
				<div class="12u$ formbtn">
					<ul class="actions">
						<li><input type="submit" value="<?php echo($transArr['Update']); ?>" class="special" /></li>
					</ul>
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
	
	
	var hash = window.location.hash.substring(1);
	
	if(hash == 'bank'){
		
		$('html,body').animate({ scrollTop : $('#bankdetails').offset().top-50 }, 1000);
		
		$('#bank_name').focus();
	}
	
});
</script>

<?php 
require_once('footer.php');
?>
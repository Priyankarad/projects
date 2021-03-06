<?php 
require_once('header.php');
//13576
//FR1420041010050500013M02606
//Jean Dupont
//PHP-Merchant-5c37284bb1ef5

$identifier = isset($_REQUEST['identifier']) ? $_REQUEST['identifier'] : '';

$checkexistsSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE unique_identifier = '".$identifier."' AND ((status IS NULL) OR (status='pending')) and email_verified='0'";

$checkexistsQry = mysqli_query($con,$checkexistsSql) or die(mysqli_error());
$checkexistsRow = mysqli_num_rows($checkexistsQry);
$checkstatus=mysqli_fetch_assoc($checkexistsQry);


if(is_numeric($checkexistsRow) && $checkexistsRow > 0)
{
	//echo "hello";die();
	$updateSql = "UPDATE ".TABLE_PREFIX."backoffice_merchants SET 
				  email_verified = '1'
				  WHERE unique_identifier = '".$identifier."'";
				  
	mysqli_query($con,$updateSql) or die(mysqli_error());
	if(trim($checkstatus['status'])=="pending")
	{
        header("Location:".BASE_URL.$_SESSION['currentLang'].'/accountcreated');
		exit;
	}	
}
else{	
	header("Location:".BASE_URL.$_SESSION['currentLang']);
	exit;	
}

if(isset($_REQUEST['doregister']) && !empty($_REQUEST['doregister']) && $_REQUEST['doregister'] == 'yes'){
	
	if(count($_POST)){
			
		foreach($_POST as $key=>$val){
			
			$_POST[$key] = trim(htmlspecialchars($val));
		}
	}
	$company_name 		= isset($_POST['company_name']) ? $_POST['company_name'] : '';
	$merchant_name 		= isset($_POST['merchant_name']) ? $_POST['merchant_name'] : '';
	$merchant_surname 	= isset($_POST['merchant_surname']) ? $_POST['merchant_surname'] : '';
	$medical_number     = isset($_POST['medical_number']) ? $_POST['medical_number'] : '';
	$merchant_nie 		= isset($_POST['merchant_nie']) ? $_POST['merchant_nie'] : '';
	$contact_person 	= isset($_POST['contact_person']) ? $_POST['contact_person'] : '';
	$mobile_no 			= isset($_POST['mobile_no']) ? $_POST['mobile_no'] : '';
	$merchant_cif 		= isset($_POST['merchant_cif']) ? $_POST['merchant_cif'] : '';	
	$sector 			= isset($_POST['sector']) ? $_POST['sector'] : '';
	$url 				= isset($_POST['url']) ? $_POST['url'] : '';
	$address 			= isset($_POST['address']) ? $_POST['address'] : '';
	$terms              = isset($_POST['terms']) ? $_POST['terms'] : '';
	$privacy 			= isset($_POST['privacy']) ? $_POST['privacy'] : '';
	$self_employed      = isset($_POST['self_employed']) ? $_POST['self_employed'] : '';
	$dninie        		= isset($_POST['dninie']) ? $_POST['dninie'] : '';

	$street_bank_branch = isset($_POST['street_bank_branch']) ? $_POST['street_bank_branch'] : '';
	$bank_branch        = isset($_POST['bank_branch']) ? $_POST['bank_branch'] : '';
	$iban_holder        = isset($_POST['iban_holder']) ? $_POST['iban_holder'] : '';
	$bank_account_no 	= isset($_POST['bank_account_no']) ? $_POST['bank_account_no'] : '';	
		
	$flag = 1;
	

	if(empty($merchant_name)){		
		$errors['type'] = 'merchant_name';
		$errors['msg'] = '* Enter Merchant name';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	/*else{
			
		$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE merchant_name = '".$merchant_name."'";
		$checkemailSql = mysql_query($checkemailQry) or die(mysql_error());
		$checkemailRow = mysql_fetch_row($checkemailSql);
		
		if(!empty($checkemailRow)){
			
			$errors['type'] = 'merchant_name';
			$errors['msg'] = '* Merchant name is already registered';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
	}*/
	
	if(empty($merchant_surname)){
		
		$errors['type'] = 'merchant_surname';
		$errors['msg'] = '* Enter merchant surname';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	if(empty($contact_person)){
		
		$errors['type'] = 'contact_person';
		$errors['msg'] = '* Enter contact person name';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	if(empty($company_name)){
		
		$errors['type'] = 'company_name';
		$errors['msg'] = '* Enter company name';
		$errorsFinal[] = $errors;
		$flag = 0;
	}

	if(empty($mobile_no)){
			
		$errors['type'] = 'mobile_no';
		$errors['msg'] = '* Enter contact person mobile number';
		$errorsFinal[] = $errors;
		$flag = 0;
	}else if(!is_numeric($mobile_no)){
		
		$errors['type'] = 'mobile_no';
		$errors['msg'] = '* Mobile number must be digits';
		$errorsFinal[] = $errors;
		$flag = 0;
	}else if(strlen($mobile_no) != MOBILE_LENGTH){
		
		$errors['type'] = 'mobile_no';
		$errors['msg'] = '* Mobile number must be of '.MOBILE_LENGTH.' digits';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	
	if(empty($self_employed)){		
		$errors['type'] = 'self_employed';
		$errors['msg'] = '* Select Are you self employed?';
		$errorsFinal[] = $errors;
		$flag = 0;
	}else{
		if($self_employed=="no"){
				if(empty($merchant_cif)){		
					$errors['type'] = 'merchant_cif';
					$errors['msg'] = '* Enter Merchant CIF/ID number';
					$errorsFinal[] = $errors;
					$flag = 0;
				}else{		
					$regex = '/^[A-Z][0-9]{8}$/';
					preg_match_all($regex, $merchant_cif, $matches, PREG_SET_ORDER, 0);		
					if(!count($matches)){			
						$errors['type'] = 'merchant_cif';
						$errors['msg'] = '* Merchant CIF/ID number must be of 1 Capital Letter and 8 Digits';
						$errorsFinal[] = $errors;
						$flag = 0;
					}
				}

				if(!empty($merchant_nie)){
					if(empty($dninie)){
						$errors['type'] = 'dninie';
						$errors['msg'] = '* Select merchant DNI/NIE type Or leave this field empty';
						$flag = 0;
						$errorsFinal[] = $errors;
					}else{
						if(!empty($dninie) && $dninie=="dni"){
							$regex = '/^[0-9]{8}[A-Z]$/';
							preg_match_all($regex, $merchant_nie, $matches, PREG_SET_ORDER, 0);		
							if(!count($matches)){			
								$errors['type'] = 'merchant_nie';
								$errors['msg'] = '* Merchant '.ucfirst($dninie).' number must be of 8 Digits and 1 Capital Letter ';
								$errorsFinal[] = $errors;
								$flag = 0;
							}
						}else if(!empty($dninie) && $dninie=="nie"){
							$regex = '/^[A-Z][0-8]{7}[A-Z]$/';
							preg_match_all($regex, $merchant_nie, $matches, PREG_SET_ORDER, 0);		
							if(!count($matches)){			
								$errors['type'] = 'merchant_nie';
								$errors['msg'] = '* Merchant '.ucfirst($dninie).' number must be of 1 Capital Letter , 7 Digits and 1 Capital Letter';
								$errorsFinal[] = $errors;
								$flag = 0;
							}
						}
					}
				}
				if(!empty($dninie)){
					if(empty($merchant_nie)){
						$errors['type'] = 'merchant_nie';
						$errors['msg'] = '* Select merchant DNI/NIE type Or leave this field empty';
						$errorsFinal[] = $errors;
						$flag = 0;
					}
				}		

		}else if($self_employed=="yes"){
				if(empty($dninie)){
					$errors['type'] = 'dninie';
					$errors['msg'] = '* Select merchant DNI/NIE';
					$errorsFinal[] = $errors;
					$flag = 0;
				}else{
					if(empty($merchant_nie)){	
						$errors['type'] = 'merchant_nie';
						$errors['msg'] = '* Enter Merchant '.ucfirst($dninie).' number';
						$errorsFinal[] = $errors;
						$flag = 0;
					}else{
						if($dninie=="dni"){
							$regex = '/^[0-9]{8}[A-Z]$/';
							preg_match_all($regex, $merchant_nie, $matches, PREG_SET_ORDER, 0);		
							if(!count($matches)){			
								$errors['type'] = 'merchant_nie';
								$errors['msg'] = '* Merchant '.ucfirst($dninie).' number must be of 8 Digits and 1 Capital Letter ';
								$errorsFinal[] = $errors;
								$flag = 0;
							}
						}else if($dninie=="nie"){
							$regex = '/^[A-Z][0-8]{7}[A-Z]$/';
							preg_match_all($regex, $merchant_nie, $matches, PREG_SET_ORDER, 0);		
							if(!count($matches)){			
								$errors['type'] = 'merchant_nie';
								$errors['msg'] = '* Merchant '.ucfirst($dninie).' number must be of 1 Capital Letter , 7 Digits and 1 Capital Letter';
								$errorsFinal[] = $errors;
								$flag = 0;
							}
						}
					}
				}

				if(empty($medical_number)){			
					$errors['type'] = 'medical_number';
					$errors['msg'] = '* Enter Collegiate number';
					$errorsFinal[] = $errors;
					$flag = 0;
				}else if(!is_numeric($medical_number)){		
					$errors['type'] = 'medical_number';
					$errors['msg'] = '* Collegiate number must be digits';
					$errorsFinal[] = $errors;
					$flag = 0;
				}
		}					
				
				
				
		}
	

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

	if(empty($terms)){
			
			$errors['type'] = 'terms';
			$errors['msg'] = '* Agree terms & conditions';
			$errorsFinal[] = $errors;
			$flag = 0;
	}

	if(empty($privacy)){
			
			$errors['type'] = 'privacy';
			$errors['msg'] = '* Agree Privacy';
			$errorsFinal[] = $errors;
			$flag = 0;
	}
/*
	if(empty($iban_holder)){			
			$errors['type'] = 'iban_holder';
			$errors['msg'] = '* Agree terms & conditions';
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

	if(empty($bank_account_no)){
			$errors['type'] = 'bank_account_no';
			$errors['msg'] = '* Enter Bank account no number';
			$errorsFinal[] = $errors;
			$flag = 0;
	}else{

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
	}
	*/

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

	$errstr = json_encode($errorsFinal);
	
	if($flag == 1){
			$checkexistsSql = "SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE unique_identifier = '".$identifier."'";

		$checkexistsQry = mysqli_query($con,$checkexistsSql) or die(mysqli_error());
		$checkexistsRow = mysqli_fetch_array($checkexistsQry);
//print_r($checkexistsRow);


		if(!empty($checkexistsRow)){

			/***** Create Merchant Wallet ********/
							
							$updateSql = "UPDATE ".TABLE_PREFIX."backoffice_merchants SET 
												  company_name = '".addslashes($company_name)."',	
												  merchant_name = '".addslashes($merchant_name)."',
												  merchant_surname = '".addslashes($merchant_surname)."',
												  contact_person = '".addslashes($contact_person)."',
												  mobile_no = '".addslashes($mobile_no)."',
												  self_employed= '".addslashes($self_employed)."',
												  merchant_cif = '".addslashes($merchant_cif)."',
												  dninie='".addcslashes($dninie)."',
												  merchant_nie = '".addslashes($merchant_nie)."',
												  sector = '".addslashes($sector)."',
												  url = '".addslashes($url)."',
												  address = '".addslashes($address)."',
												  collegiate_number='".addslashes($medical_number)."',
												  account_holder= '".addslashes($iban_holder)."',
												  bank_account_no = '".addslashes($bankaccountval)."',
												  iban_number='".addslashes($bank_account_no)."',
												  street_bank_branch='".addslashes($street_bank_branch)."',
												  bank_branch='".addslashes($bank_branch)."',
												  status = 'pending'
												  WHERE unique_identifier = '".$identifier."'";
											  
								mysqli_query($con,$updateSql) or die(mysqli_error());
								$_SESSION['merchant_account_created'] = 'yes';
								unset($_SESSION['merchantdata']);
								
								$request = curl_init(BASE_URL.'backoffice/merchantregister/'.$identifier);
									curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
									$response = curl_exec($request);
									curl_close($request);
								header("Location:".BASE_URL.$_SESSION['currentLang'].'/accountcreated');
								exit;
					}
			}
/*


			if(!empty($merchantWalletid)){

				
			}
			*/
			/***** Create Merchant Wallet ********/
						
		}
}

$values = getVariables($langID,$con);
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major">
			<h2><?php echo($transArr['Email address verified!']); ?></h2>
			<p><?php echo($transArr['Provide some more account related information to successfully register your account']); ?></p>
		</header>
		
		<section class="investorsignup">
			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
			
				<input type="hidden" name="doregister" value="yes">
				
				<div class="row uniform 50%" style="text-align:left">
					<div class="12u$">
						<input type="text" name="company_name" id="company_name" value="<?php echo($company_name); ?>" placeholder="Company Name" />
					</div>

					<div class="12u$">
						<input type="text" name="merchant_name" id="merchant_name" value="<?php echo($merchant_name); ?>" placeholder="<?php echo($transArr['Merchant Name']); ?>" />
					</div>

					<div class="12u$">
						<input type="text" name="merchant_surname" id="merchant_surname" value="<?php echo($merchant_surname); ?>" placeholder="<?php echo($transArr['Merchant Surname']); ?>" />
					</div>

					<div class="12u$">						
						<div class="select-wrapper">
							<select name="dninie" id="dninie">
								<option value="">Select Type</option>
								<option <?= ($dninie=="dni") ? 'selected' : '' ?>  value="dni">DNI</option>
								<option <?= ($dninie=="nie") ? 'selected' : '' ?>  value="nie">NIE</option>					
							</select>
						</div>						
					</div>

					<div class="12u$">
						<input type="text" name="merchant_nie" id="merchant_nie" value="<?php echo($merchant_nie); ?>" placeholder="DNI/NIE" />
					</div>

						<div class="12u$">
							<input type="text" name="medical_number" id="medical_number" value="<?php echo($medical_number); ?>" placeholder="<?php echo($transArr['Medical Collegiate Number']); ?>" />
						</div>
					
					<div class="12u$">
						<input type="text" name="contact_person" id="contact_person" value="<?php echo($contact_person); ?>" placeholder="<?php echo($transArr['Contact Person']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="text" name="mobile_no" id="mobile_no" value="<?php echo($mobile_no); ?>" placeholder="<?php echo($transArr['Mobile Phone']); ?>" />
					</div>

					<div class="12u$">
                             <p><strong><?php echo($transArr['Are you self employed information']); ?></strong></p>
                        </div>
										
					<div class="12u$">
						<label><?=$transArr['Are you self employed']?></label>
						<div id="self_employed">
						<div class="check_15">
							<input type="radio" name="self_employed" value="yes" id="self_employed1" <?php echo($self_employed == 'yes' ? 'checked' : ''); ?>> 
							<label for="self_employed1">Yes</label>
						</div>
						<div class="check_15" >
							<input type="radio" name="self_employed" value="no" id="self_employed2" <?php echo($self_employed == 'no' ? 'checked' : ''); ?>>
							 <label for="self_employed2">No</label>
						</div>
						</div>
					</div>
					
					<div class="12u$">
						<input type="text" name="merchant_cif" id="merchant_cif" value="<?php echo($merchant_cif); ?>" placeholder="CIF/ID" />
					</div>
					
					<div class="12u$">
						
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
					
					<div class="12u$">
						<input type="text" name="url" id="url" value="<?php echo($url); ?>" placeholder="<?php echo($transArr['URL']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="text" name="address" id="address" value="<?php echo($address); ?>" placeholder="<?php echo($transArr['Address']); ?>" />
					</div>
						
					<!----<div class="12u$">
						<input type="text" name="bank_name" id="bank_name" value="<?php echo($bank_name); ?>" placeholder="<?php //echo($transArr['Bank Name']); ?>" />
					</div>--->
					

					<!----	<div class="12u$">
							<input type="text" name="iban_number" id="iban_number" value="<?php echo($iban_number); ?>" placeholder="<?php //echo($transArr['IBAN Number']); ?>" />
						</div>---->
						
						 <div class="12u$">
                             <p><strong><?php echo($transArr['Merchant Bank Information']); ?></strong></p>
                        </div>


								<div class="12u$">
                                        <input type="text" name="iban_holder" id="iban_holder" value="<?php echo($iban_holder); ?>" placeholder="<?php echo($transArr['IBAN Holder']); ?>" />
                                </div>


                                <div class="12u$">
                                        <input type="text" name="bank_branch" id="bank_branch" value="<?php echo($bank_branch); ?>" placeholder="<?php echo($transArr['Bank Branch Name']); ?>" />
                                </div>

                                <div class="12u$">
                                        <input type="text" name="street_bank_branch" id="street_bank_branch" value="<?php echo($street_bank_branch); ?>" placeholder="<?php echo($transArr['Bank Branch Street']); ?>" />
                                </div>

                                <div class="12u$">
                                        <input type="text" name="bank_account_no" id="bank_account_no" value="<?php echo($bank_account_no); ?>" placeholder="<?php echo($transArr['Bank Account No']); ?>" />
                                </div>	
					
				</div>
				
				<div class="row uniform 100%" style="text-align:left">
		            <div class="12u 12u$(medium) pd10X" id="terms">
		            	<div class="checkboxess">
		            		<input type="checkbox" name="terms" class="checkboxes" id="poenpP2">
							<label for="poenpP2"><?=$transArr['Merchant Signup Terms']?></label>
						</div>
		            </div>
		            <div class="12u 12u$(medium) pd10X" id="privacy">
		            	<div class="checkboxess">
						<input class="checkboxes" type="checkbox" id="poenpP3" name="privacy">
						<label for="poenpP3"><?=$transArr['Merchant Signup Privacy']?></label>
						</div>
		            </div>
		        </div>
				
				<div class="12u$ formbtn">
					<ul class="actions">
						<li><input type="submit" value="<?php echo($transArr['Register']); ?>" class="special" /></li>
					</ul>
				</div>

			</form>
		</section>
		
	</div>
</section>


<div id="myModal3" class="modalIn">
  <!-- Modal content -->
  <div class="modal-contentIn">
	<div class="my_cntp">
		<div class="cmscontents">
			<p><strong>1. Datos de car??cter personal del Centro M??dico del Sitio Web</strong></p>
			<p>Con el objeto de garantizar y proteger la privacidad y la confidencialidad de los datos de car??cter personal de los Usuarios de nuestra p??gina web, de colaboradores y potenciales clientes, etc. y con el fin de proteger su intimidad y privacidad, y sobre todo con el objeto de facilitar la informaci??n requerida por el Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo, de 27 de abril de 2016, relativo a la protecci??n de las personas f??sicas en lo que respecta al tratamiento de datos personales y a la libre circulaci??n de estos datos (RGPD), hemos redactado, de conformidad con la legislaci??n vigente, la presente Pol??tica de Privacidad ??? RGPD, que engloba toda la informaci??n de todos los tratamientos que realizamos.
			</p>

			<p>Los t??rminos recogidos a continuaci??n y en especial el deber de confidencialidad ser??n de obligado cumplimiento para todo el personal interno o externo que trabaje o pudiera trabajar con nosotros y que tengan acceso a los datos de los intereses, bien durante la navegaci??n en nuestra Web, por la utilizaci??n de nuestros formularios o durante la contrataci??n o prestaci??n de los productos o servicios</p>

			<p>Nos reservamos el derecho a modificar el contenido de la presente Pol??tica de Privacidad ??? RGPD, con el objeto de adaptarlo a las novedades legislativas o jurisprudenciales, as?? como a los informes o dict??menes emitidos por la Agencia Espa??ola de Protecci??n de Datos o el Grupo de Trabajo del Art??culo 29.</p>

			<p>En caso de que vayamos a utilizar los datos personales de una manera distinta a lo aqu?? establecido haremos el esfuerzo posible para contactarte como interesado, informarte adecuadamente sobre el nuevo tratamiento y recabar el consentimiento expreso e informado para poder realizarlo. En caso contrario, no usaremos los datos para finalidades distintas.</p>

			<p>Las finalidades de la recogida de sus Datos de Car??cter Personal son las siguientes: (i) prestar, gestionar, administrar, ampliar y mejorar el Servicio y mantener la relaci??n establecida entre <strong>SMARTCREDIT</strong> y Usted y (ii) atender su petici??n y prestarle el servicio solicitado as?? como para mantenerle informado, incluso por medios electr??nicos, de cualquier informaci??n que pudiera ser de su inter??s sobre la actividad de la empresa y de sus servicios.</p>

			<p>Usted podr?? ejercer sus derechos de acceso, rectificaci??n, cancelaci??n y oposici??n al tratamiento de dichos Datos de Car??cter Personal, as?? como revocar el consentimiento prestado para el env??o de comunicaciones comerciales electr??nicas ante SMARTCREDIT, S.L., CIF n?? B-67193698 sita en<strong> EDIFICIO SANT JUST-DIAGONAL.</strong> C. Constituci??, 2. 1a Planta Despacho n?? 3. Sant Just Desvern. 08960. Barcelona (Espa??a), en los t??rminos establecidos en la normativa de vigente. Para su mayor comodidad, y sin perjuicio de que se deban cumplir con determinados requisitos formales establecidos por la GDPD, <strong>SMARTCREDIT</strong> le ofrece la posibilidad de ejercer los derechos antes referidos a trav??s del correo electr??nico: info@smartcredit.es.</p>

			<p>RESPONSABLE DEL TRATAMIENTO- SMARTCREDIT, S.L., CIF n?? B-67193698 sita en<strong> EDIFICIO SANT JUST-DIAGONAL.</strong> C. Constituci??, 2. 1a Planta Despacho n?? 3. Sant Just Desvern. 08960. Barcelona (Espa??a).</p>
			
		</div>
		<div class="close_appendbt">
				<button type="button" popupcheckbox="poenpP3" class="close_ic">Agree</button>
				<button type="button" class="close_ic">DisAgree</button>
		</div>
	</div>
  </div>
</div>

<div id="myModal4" class="modalIn">
  <!-- Modal content -->
  <div class="modal-contentIn">
	<div class="my_cntp">
		<div class="cmscontents">
			

<h2>Condiciones de uso</h2>

<p>Estas Condiciones de Uso regulan el acceso y utilizaci??n del portal de Internet (en adelante, el "Portal")
que SMARTCREDIT, S.L. (en adelante, ???SMARTCREDIT???), sociedad mercantil con sede social en Calle Constituci??n n?? 2 1?? 08960, Sant Just Desvern. Barcelona. con CIF B67193698 pone a disposici??n de los usuarios y/o potenciales clientes.</p>

<p>La utilizaci??n del Portal atribuye la condici??n de usuario del Portal (en adelante, el ???Usuario???) e implica la aceptaci??n de todas las normas de uso contenidas en estas Condiciones. Es conveniente que el Usuario consulte las presentes Condiciones en cada una de las ocasiones en que se proponga utilizar el Portal, ya que ??ste puede haber variado desde la ??ltima vez que se visit??.</p>

<p>SMARTCREDIT no garantiza a los usuarios la disponibilidad o el mantenimiento en el futuro de los servicios accesibles a trav??s del Portal pudiendo decidir en cualquier momento la interrupci??n, suspensi??n o cancelaci??n definitiva del Portal sin que por ello se derive ninguna clase de compensaci??n para los Usuarios. La exenci??n de responsabilidad frente a los usuarios se realiza sin perjuicio de las
responsabilidades que haya adquirido SMARTCREDIT con el centro Afiliado (en adelante, el "Merchant") con el que mantenga un contrato o convenio de colaboraci??n u otros terceros.
Las presentes Condiciones de Uso del Portal se establecen sin perjuicio de las Condiciones Generales del Servicio de Plataforma online de pr??stamos entre particulares, que regulan los t??rminos y condiciones aplicables a aquellos Usuarios que contraten dicho servicio. Tambi??n se establecen sin perjuicio de las condiciones contractuales que pueda adquirir el Usuario con el Afiliado y/o la entidad final que preste el servicio de financiaci??n como resultado de la solicitud y en su caso aprobaci??n del pr??stamo.</p>


<p><strong>1. CONDICIONES DE USO DEL PORTAL</strong></p>

<p><strong>1.1.	General</strong></p>

<p>Los Usuarios del Portal se obligan a hacer un uso correcto del Portal de conformidad con la Ley y las presentes Condiciones de Uso. El Usuario que incumpla la Ley o las presentes Condiciones de Uso
responder?? frente a SMARTCREDIT o frente a terceros de cualesquiera da??os y perjuicios que pudieran causarse como consecuencia del incumplimiento de dicha obligaci??n. Queda expresamente prohibido el uso del Portal con fines lesivos de bienes o intereses de SMARTCREDIT o que de cualquier otra forma sobrecarguen, da??en o inutilicen las redes, servidores y dem??s equipos inform??ticos (hardware) o productos y aplicaciones inform??ticas (software) de SMARTCREDIT o de terceros.</p>

<p><strong>1.2.	Introducci??n de enlaces al Portal</strong></p>

<p>Los Usuarios de Internet o prestadores de Servicios de la Sociedad de la Informaci??n que quieran introducir enlaces desde sus propias p??ginas web al Portal deber??n cumplir con las condiciones que se
detallan a continuaci??n: No se realizar??n desde la p??gina que introduce el enlace ning??n tipo de manifestaci??n falsa, inexacta o incorrecta sobre SMARTCREDIT, sus socios, empleados, miembros o sobre la calidad de los servicios que ofrece a los usuarios.</p>

<p>En ning??n caso, se expresar?? en la p??gina donde se ubique el enlace que SMARTCREDIT ha prestado su consentimiento para la inserci??n del enlace o que de otra forma patrocina, colabora, verifica o supervisa los servicios del remitente. Est?? prohibida la utilizaci??n de cualquier marca denominativa, gr??fica o mixta o cualquier otro signo distintivo de SMARTCREDIT salvo en los casos permitidos por la ley o expresamente autorizados por SMARTCREDIT y siempre que se permita, en estos casos, un enlace directo con el Portal en la forma establecida en esta cl??usula.</p>

<p><strong>1.3.	Propiedad intelectual e industrial</strong></p>

<p>El Portal, as?? como todos los contenidos del Portal, entendiendo por estos, a t??tulo meramente enunciativo, los textos, fotograf??as, gr??ficos, im??genes, iconos, tecnolog??a, software, links y dem??s contenidos, as??
como su dise??o gr??fico y c??digos fuente (en adelante, los ???Contenidos???), son propiedad intelectual de sus leg??timos titulares, sin que puedan entenderse cedidos a los Usuarios ninguno de los derechos de explotaci??n reconocidos por la normativa vigente en materia de propiedad intelectual. No obstante lo anterior, durante el tiempo que los Usuarios permanezcan conectados al Portal podr??n hacer uso del Portal y de dichos Contenidos en la medida que resulte necesario para la navegaci??n y s??lo en cuanto dichos contenidos se encuentren accesibles de acuerdo con las normas previstas en ??stas Condiciones de Uso. En particular, los Usuarios deber??n de abstenerse de reproducir, copiar, distribuir, poner a disposici??n, comunicar p??blicamente, transformar o modificar los Contenidos salvo en la medida que sea estrictamente necesario para su descarga en aquellos casos ??sta se ofrezca a trav??s del Portal o en aquellos casos autorizados en la ley u otros expresamente consentidos por el Afiliado o SMARTCREDIT. Las marcas, nombres comerciales o signos distintivos son titularidad de SMARTCREDIT o sus leg??timos titulares sin que pueda entenderse que el acceso al Portal atribuya a los Usuarios ning??n derecho sobre las citadas marcas, nombres comerciales y/o signos distintivos.</p>

<p><strong>2.	EXCLUSI??N DE RESPONSABILIDAD</strong></p>

<p>2.1. De la calidad del servicio La conexi??n al Portal se realiza a trav??s de redes abiertas de manera que SMARTCREDIT no controla la seguridad de la comunicaci??n de datos ni de los equipos conectados a Internet. Corresponde al Usuario, disponer de las herramientas adecuadas para la prevenci??n, detecci??n y desinfecci??n de programas inform??ticos da??inos o software malicioso. Puede obtener informaci??n sobre herramientas gratuitas de detecci??n de software malicioso, tales como virus, troyanos, etc. </p>

<p>SMARTCREDIT no se responsabiliza de los da??os
producidos en los equipos inform??ticos de los Usuarios o de terceros por actos de terceros durante la conexi??n al Portal.</p>

<p><strong>2.2. De la disponibilidad del Servicio</strong></p>

<p>El acceso al Portal requiere de servicios y suministros de terceros, incluidos el transporte a trav??s de redes de telecomunicaciones cuya fiabilidad, calidad, seguridad, continuidad y funcionamiento no corresponde a SMARTCREDIT ni se encuentra bajo su control. SMARTCREDIT no se responsabilizar??n de los da??os o perjuicios de cualquier tipo producidos en el Usuario que traigan causa de fallos o desconexiones en las redes de telecomunicaciones que produzcan la suspensi??n, cancelaci??n o interrupci??n del Portal durante la prestaci??n del mismo o con car??cter previo.</p>

<p>2.3. De los contenidos y servicios enlazados a trav??s del Portal
El Portal puede incluir enlaces o links que permiten al Usuario acceder a otras p??ginas y portales de Internet (en adelante, ???Sitios Enlazados???). En estos casos, SMARTCREDIT act??a como prestador de servicios de intermediaci??n de conformidad con el art??culo 17 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Informaci??n y el Comercio Electr??nico (???LSSI???) y s??lo ser?? responsable de los contenidos y servicios suministrados en los Sitios Enlazados en la medida en que tenga conocimiento efectivo de la
ilicitud y no haya desactivado el enlace con la diligencia debida.
En ning??n caso, la existencia de Sitios Enlazados debe presuponer la existencia de acuerdos con los responsables o titulares de los mismos, ni la recomendaci??n, promoci??n o identificaci??n de SMARTCREDIT con las manifestaciones, contenidos o servicios provistos.</p>

<p>SMARTCREDIT no conoce los contenidos y servicios de los Sitios Enlazados y por tanto no se hace responsable por los da??os producidos por la ilicitud, calidad, desactualizaci??n, indisponibilidad, error e inutilidad de los contenidos y/o servicios de los Sitios Enlazados ni por cualquier otro da??o que no sea directamente
imputable a SMARTCREDIT por sus propios servicios.</p>

<p>2.4. De la confidencialidad de la informaci??n transmitida a trav??s del Portal SMARTCREDIT tiene adoptadas las medidas de seguridad exigidas legalmente para garantizar la confidencialidad y secreto de los datos de car??cter personal que los Usuarios facilitan en nuestro Portal. No obstante lo anterior, la transmisi??n de dichos datos a SMARTCREDIT circula por redes de telecomunicaciones de terceros no controladas por SMARTCREDIT. Adicionalmente, la existencia de Software malicioso en su equipo puede conllevar que dicha informaci??n pueda ser reenviada o recuperada sin su conocimiento.</p>

<p>SMARTCREDIT no responde de la falta de confidencialidad de la informaci??n transmitida por equipos y redes de telecomunicaciones de terceros ni por las vulnerabilidades de software o hardware de los propios equipos de los Usuarios.</p>

<p><strong>3. PROTECCI??N DE DATOS</strong></p>

<p>Los Usuarios que quieran conocer qu?? tratamientos de datos se realizan en el Portal pueden consultar nuestra Pol??tica de Privacidad. Los usuarios podr??n ejercer sus derechos de acuerdo con la regulaci??n en materia de protecci??n de datos, vigente. </p>

<p><strong>4. ATENCI??N AL CLIENTE</strong></p>

<p>Si tiene cualquier duda, sugerencia, reclamaci??n o quiere realizar alguna consulta sobre nuestro Portal,
contacte con SMARTCREDIT por cualquiera de los siguientes medios:</p>

<p>or correo electr??nico a la direcci??n: <a href="mailto:merchants@smartcredit.es">merchants@smartcredit.es </a></p>

<p><strong>5. LEGISLACI??N APLICABLE</strong></p>
<p>La Ley aplicable a las presentes Condiciones de Uso ser?? la Ley Espa??ola.</p>
			
		</div>
		<div class="close_appendbt">
				<button type="button" popupcheckbox="poenpP2" class="close_ic">Agree</button>
				<button type="button" class="close_ic">DisAgree</button>
		</div>
	</div>
  </div>
</div>

<script>
	$('.checkboxes').on('click',function(){       
	   if($(this).is(":checked")) {
	   	  $(this).prop('checked', false);
	      return;
	   } 
	});

$(".close_ic").on("click",function(){
  var popcheckbox=$(this).attr('popupcheckbox');
  if (typeof popcheckbox !== typeof undefined && popcheckbox !== false) {
  	 $("#"+$(this).attr('popupcheckbox')).prop('checked', true);
  }

})

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

	/*$('input[name="self_employed"]').change(function(){		
		var val = $(this).val();
		if(val == 'no'){			
			$('#merchant_cif').parent().show();
		}
		else if(val == 'yes'){			
			$('#merchant_cif').parent().hide();
		}		
	});*/
	
});
</script>

<?php 
require_once('footer.php');
?>
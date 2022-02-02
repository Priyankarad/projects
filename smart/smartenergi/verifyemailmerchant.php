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
			<p><strong>1. Datos de carácter personal del Centro Médico del Sitio Web</strong></p>
			<p>Con el objeto de garantizar y proteger la privacidad y la confidencialidad de los datos de carácter personal de los Usuarios de nuestra página web, de colaboradores y potenciales clientes, etc. y con el fin de proteger su intimidad y privacidad, y sobre todo con el objeto de facilitar la información requerida por el Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo, de 27 de abril de 2016, relativo a la protección de las personas físicas en lo que respecta al tratamiento de datos personales y a la libre circulación de estos datos (RGPD), hemos redactado, de conformidad con la legislación vigente, la presente Política de Privacidad – RGPD, que engloba toda la información de todos los tratamientos que realizamos.
			</p>

			<p>Los términos recogidos a continuación y en especial el deber de confidencialidad serán de obligado cumplimiento para todo el personal interno o externo que trabaje o pudiera trabajar con nosotros y que tengan acceso a los datos de los intereses, bien durante la navegación en nuestra Web, por la utilización de nuestros formularios o durante la contratación o prestación de los productos o servicios</p>

			<p>Nos reservamos el derecho a modificar el contenido de la presente Política de Privacidad – RGPD, con el objeto de adaptarlo a las novedades legislativas o jurisprudenciales, así como a los informes o dictámenes emitidos por la Agencia Española de Protección de Datos o el Grupo de Trabajo del Artículo 29.</p>

			<p>En caso de que vayamos a utilizar los datos personales de una manera distinta a lo aquí establecido haremos el esfuerzo posible para contactarte como interesado, informarte adecuadamente sobre el nuevo tratamiento y recabar el consentimiento expreso e informado para poder realizarlo. En caso contrario, no usaremos los datos para finalidades distintas.</p>

			<p>Las finalidades de la recogida de sus Datos de Carácter Personal son las siguientes: (i) prestar, gestionar, administrar, ampliar y mejorar el Servicio y mantener la relación establecida entre <strong>SMARTCREDIT</strong> y Usted y (ii) atender su petición y prestarle el servicio solicitado así como para mantenerle informado, incluso por medios electrónicos, de cualquier información que pudiera ser de su interés sobre la actividad de la empresa y de sus servicios.</p>

			<p>Usted podrá ejercer sus derechos de acceso, rectificación, cancelación y oposición al tratamiento de dichos Datos de Carácter Personal, así como revocar el consentimiento prestado para el envío de comunicaciones comerciales electrónicas ante SMARTCREDIT, S.L., CIF nº B-67193698 sita en<strong> EDIFICIO SANT JUST-DIAGONAL.</strong> C. Constitució, 2. 1a Planta Despacho nº 3. Sant Just Desvern. 08960. Barcelona (España), en los términos establecidos en la normativa de vigente. Para su mayor comodidad, y sin perjuicio de que se deban cumplir con determinados requisitos formales establecidos por la GDPD, <strong>SMARTCREDIT</strong> le ofrece la posibilidad de ejercer los derechos antes referidos a través del correo electrónico: info@smartcredit.es.</p>

			<p>RESPONSABLE DEL TRATAMIENTO- SMARTCREDIT, S.L., CIF nº B-67193698 sita en<strong> EDIFICIO SANT JUST-DIAGONAL.</strong> C. Constitució, 2. 1a Planta Despacho nº 3. Sant Just Desvern. 08960. Barcelona (España).</p>
			
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

<p>Estas Condiciones de Uso regulan el acceso y utilización del portal de Internet (en adelante, el "Portal")
que SMARTCREDIT, S.L. (en adelante, “SMARTCREDIT”), sociedad mercantil con sede social en Calle Constitución nº 2 1ª 08960, Sant Just Desvern. Barcelona. con CIF B67193698 pone a disposición de los usuarios y/o potenciales clientes.</p>

<p>La utilización del Portal atribuye la condición de usuario del Portal (en adelante, el “Usuario”) e implica la aceptación de todas las normas de uso contenidas en estas Condiciones. Es conveniente que el Usuario consulte las presentes Condiciones en cada una de las ocasiones en que se proponga utilizar el Portal, ya que éste puede haber variado desde la última vez que se visitó.</p>

<p>SMARTCREDIT no garantiza a los usuarios la disponibilidad o el mantenimiento en el futuro de los servicios accesibles a través del Portal pudiendo decidir en cualquier momento la interrupción, suspensión o cancelación definitiva del Portal sin que por ello se derive ninguna clase de compensación para los Usuarios. La exención de responsabilidad frente a los usuarios se realiza sin perjuicio de las
responsabilidades que haya adquirido SMARTCREDIT con el centro Afiliado (en adelante, el "Merchant") con el que mantenga un contrato o convenio de colaboración u otros terceros.
Las presentes Condiciones de Uso del Portal se establecen sin perjuicio de las Condiciones Generales del Servicio de Plataforma online de préstamos entre particulares, que regulan los términos y condiciones aplicables a aquellos Usuarios que contraten dicho servicio. También se establecen sin perjuicio de las condiciones contractuales que pueda adquirir el Usuario con el Afiliado y/o la entidad final que preste el servicio de financiación como resultado de la solicitud y en su caso aprobación del préstamo.</p>


<p><strong>1. CONDICIONES DE USO DEL PORTAL</strong></p>

<p><strong>1.1.	General</strong></p>

<p>Los Usuarios del Portal se obligan a hacer un uso correcto del Portal de conformidad con la Ley y las presentes Condiciones de Uso. El Usuario que incumpla la Ley o las presentes Condiciones de Uso
responderá frente a SMARTCREDIT o frente a terceros de cualesquiera daños y perjuicios que pudieran causarse como consecuencia del incumplimiento de dicha obligación. Queda expresamente prohibido el uso del Portal con fines lesivos de bienes o intereses de SMARTCREDIT o que de cualquier otra forma sobrecarguen, dañen o inutilicen las redes, servidores y demás equipos informáticos (hardware) o productos y aplicaciones informáticas (software) de SMARTCREDIT o de terceros.</p>

<p><strong>1.2.	Introducción de enlaces al Portal</strong></p>

<p>Los Usuarios de Internet o prestadores de Servicios de la Sociedad de la Información que quieran introducir enlaces desde sus propias páginas web al Portal deberán cumplir con las condiciones que se
detallan a continuación: No se realizarán desde la página que introduce el enlace ningún tipo de manifestación falsa, inexacta o incorrecta sobre SMARTCREDIT, sus socios, empleados, miembros o sobre la calidad de los servicios que ofrece a los usuarios.</p>

<p>En ningún caso, se expresará en la página donde se ubique el enlace que SMARTCREDIT ha prestado su consentimiento para la inserción del enlace o que de otra forma patrocina, colabora, verifica o supervisa los servicios del remitente. Está prohibida la utilización de cualquier marca denominativa, gráfica o mixta o cualquier otro signo distintivo de SMARTCREDIT salvo en los casos permitidos por la ley o expresamente autorizados por SMARTCREDIT y siempre que se permita, en estos casos, un enlace directo con el Portal en la forma establecida en esta cláusula.</p>

<p><strong>1.3.	Propiedad intelectual e industrial</strong></p>

<p>El Portal, así como todos los contenidos del Portal, entendiendo por estos, a título meramente enunciativo, los textos, fotografías, gráficos, imágenes, iconos, tecnología, software, links y demás contenidos, así
como su diseño gráfico y códigos fuente (en adelante, los “Contenidos”), son propiedad intelectual de sus legítimos titulares, sin que puedan entenderse cedidos a los Usuarios ninguno de los derechos de explotación reconocidos por la normativa vigente en materia de propiedad intelectual. No obstante lo anterior, durante el tiempo que los Usuarios permanezcan conectados al Portal podrán hacer uso del Portal y de dichos Contenidos en la medida que resulte necesario para la navegación y sólo en cuanto dichos contenidos se encuentren accesibles de acuerdo con las normas previstas en éstas Condiciones de Uso. En particular, los Usuarios deberán de abstenerse de reproducir, copiar, distribuir, poner a disposición, comunicar públicamente, transformar o modificar los Contenidos salvo en la medida que sea estrictamente necesario para su descarga en aquellos casos ésta se ofrezca a través del Portal o en aquellos casos autorizados en la ley u otros expresamente consentidos por el Afiliado o SMARTCREDIT. Las marcas, nombres comerciales o signos distintivos son titularidad de SMARTCREDIT o sus legítimos titulares sin que pueda entenderse que el acceso al Portal atribuya a los Usuarios ningún derecho sobre las citadas marcas, nombres comerciales y/o signos distintivos.</p>

<p><strong>2.	EXCLUSIÓN DE RESPONSABILIDAD</strong></p>

<p>2.1. De la calidad del servicio La conexión al Portal se realiza a través de redes abiertas de manera que SMARTCREDIT no controla la seguridad de la comunicación de datos ni de los equipos conectados a Internet. Corresponde al Usuario, disponer de las herramientas adecuadas para la prevención, detección y desinfección de programas informáticos dañinos o software malicioso. Puede obtener información sobre herramientas gratuitas de detección de software malicioso, tales como virus, troyanos, etc. </p>

<p>SMARTCREDIT no se responsabiliza de los daños
producidos en los equipos informáticos de los Usuarios o de terceros por actos de terceros durante la conexión al Portal.</p>

<p><strong>2.2. De la disponibilidad del Servicio</strong></p>

<p>El acceso al Portal requiere de servicios y suministros de terceros, incluidos el transporte a través de redes de telecomunicaciones cuya fiabilidad, calidad, seguridad, continuidad y funcionamiento no corresponde a SMARTCREDIT ni se encuentra bajo su control. SMARTCREDIT no se responsabilizarán de los daños o perjuicios de cualquier tipo producidos en el Usuario que traigan causa de fallos o desconexiones en las redes de telecomunicaciones que produzcan la suspensión, cancelación o interrupción del Portal durante la prestación del mismo o con carácter previo.</p>

<p>2.3. De los contenidos y servicios enlazados a través del Portal
El Portal puede incluir enlaces o links que permiten al Usuario acceder a otras páginas y portales de Internet (en adelante, “Sitios Enlazados”). En estos casos, SMARTCREDIT actúa como prestador de servicios de intermediación de conformidad con el artículo 17 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y el Comercio Electrónico (“LSSI”) y sólo será responsable de los contenidos y servicios suministrados en los Sitios Enlazados en la medida en que tenga conocimiento efectivo de la
ilicitud y no haya desactivado el enlace con la diligencia debida.
En ningún caso, la existencia de Sitios Enlazados debe presuponer la existencia de acuerdos con los responsables o titulares de los mismos, ni la recomendación, promoción o identificación de SMARTCREDIT con las manifestaciones, contenidos o servicios provistos.</p>

<p>SMARTCREDIT no conoce los contenidos y servicios de los Sitios Enlazados y por tanto no se hace responsable por los daños producidos por la ilicitud, calidad, desactualización, indisponibilidad, error e inutilidad de los contenidos y/o servicios de los Sitios Enlazados ni por cualquier otro daño que no sea directamente
imputable a SMARTCREDIT por sus propios servicios.</p>

<p>2.4. De la confidencialidad de la información transmitida a través del Portal SMARTCREDIT tiene adoptadas las medidas de seguridad exigidas legalmente para garantizar la confidencialidad y secreto de los datos de carácter personal que los Usuarios facilitan en nuestro Portal. No obstante lo anterior, la transmisión de dichos datos a SMARTCREDIT circula por redes de telecomunicaciones de terceros no controladas por SMARTCREDIT. Adicionalmente, la existencia de Software malicioso en su equipo puede conllevar que dicha información pueda ser reenviada o recuperada sin su conocimiento.</p>

<p>SMARTCREDIT no responde de la falta de confidencialidad de la información transmitida por equipos y redes de telecomunicaciones de terceros ni por las vulnerabilidades de software o hardware de los propios equipos de los Usuarios.</p>

<p><strong>3. PROTECCIÓN DE DATOS</strong></p>

<p>Los Usuarios que quieran conocer qué tratamientos de datos se realizan en el Portal pueden consultar nuestra Política de Privacidad. Los usuarios podrán ejercer sus derechos de acuerdo con la regulación en materia de protección de datos, vigente. </p>

<p><strong>4. ATENCIÓN AL CLIENTE</strong></p>

<p>Si tiene cualquier duda, sugerencia, reclamación o quiere realizar alguna consulta sobre nuestro Portal,
contacte con SMARTCREDIT por cualquiera de los siguientes medios:</p>

<p>or correo electrónico a la dirección: <a href="mailto:merchants@smartcredit.es">merchants@smartcredit.es </a></p>

<p><strong>5. LEGISLACIÓN APLICABLE</strong></p>
<p>La Ley aplicable a las presentes Condiciones de Uso será la Ley Española.</p>
			
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
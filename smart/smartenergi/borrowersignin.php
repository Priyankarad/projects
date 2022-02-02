<?php 
require_once('header.php');

/*
$customerdata = $_SESSION['customerdata'];
			
			$userlogininapi=userLogin();
			if($userlogininapi){
				    $insertArr=array();
					$doInstantPetition=array("productID"=>1,
											"yourReference"=>$customerdata['idnumber'],
											"nationalID"=>$customerdata['idnumber'],
											"productBehaviour"=>0,
											"firstSurname"=>$customerdata['surname'],
											"postalCode"=>$customerdata['postcode'],
											"name"=>$customerdata['firstname']." ".$customerdata['surname'],
											"secondSurname"=>$customerdata['second_surname'],
											"address"=>"C. Constitució nº 2 1 3. Sant Just Desvern. 08960. Barcelona"
										);
				$xmlString =doInstantPetition($doInstantPetition);

				if(!empty($xmlstring)){
					$xmlString = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xmlstring);
					$xml = SimpleXML_Load_String($xmlString);
					$xml = new SimpleXMLElement($xml->asXML());
					$xmlproductresult=$xml->soapbody->ns2doinstantpetitionresponse->return->xmlproductresult;

					$nationalid=(array)$xml->soapbody->ns2doinstantpetitionresponse->return->nationalid;
					$insertArr['nationalid']=$nationalid[0];

					$petitionid=(array)$xml->soapbody->ns2doinstantpetitionresponse->return->petitionid;
					$insertArr['petitionid']=$petitionid[0];
					if(!empty($xmlproductresult)){
						$xmlproductresultresponse='<xmlproductresult>'.$xmlproductresult.'</xmlproductresult>';
						$productxml = simplexml_load_string($xmlproductresultresponse);
						$productxml= (array) $productxml;
						foreach($productxml as $key=>$values){
							    $insertArr[$key]=$values;
						}
					}
					if(!empty($insertArr)){
						$insertArr["loan_id"]=$loan_id;
							insertQuery("loan_petitions",$insertArr);
					}
				}
			}

$test=
(object)array(
    'address' => 'C. CONSTITUCIO Nº 2 1 3. SANT JUST DESVERN. 08960. BARCELONA',
    'city' => '',
    'clientid' => 200,
    'firstquerydate' => '2018-12-05T07:22:36.151+01:00',
    'firstquerytime' => '2018-12-05T07:22:36.151+01:00',
    'firstsurname'=> 'CALLS',
    'name' => 'SILVIA CALLS INSA',
    'nationalid' => '46145437P',
    'petitiondate' => '2018-12-05T00:00:00+01:00',
    'petitionid' => '2185553',
    'petitiontime' => '1970-01-01T07:22:33.947+01:00',
    'phones' => '',
    'postalcode' => '08960',
    'productbehaivour' => 0,
    'productid' => 1,
    'provincecode' => 08,
    'resolutiondate' => '2018-12-05T00:00:00+01:00',
    'resolutiontime' => '1970-01-01T07:22:35.879+01:00',
    'secondsurname' => 'INSA',
    'statepetitionid' => 4,
    'xmlproductresult' => '0averageaverageB027.04upper2.5lower',
    'yourreference' => '46145437P'
);


$xml = simplexml_load_string('<foo>Text1 &amp; XML entities</foo>'); 
print_r($xml); 
die();
*/
/*
Petition Number:2181306
stdClass Object
(
    [return] => stdClass Object
        (
            [address] => C. CONSTITUCIO Nº 2 1 3. SANT JUST DESVERN. 08960. BARCELONA
            [city] => 
            [clientid] => 200
            [firstquerydate] => 2018-12-04T07:13:33.368+01:00
            [firstquerytime] => 2018-12-04T07:13:33.368+01:00
            [firstsurname] => CALLS
            [name] => SILVIA CALLS INSA
            [nationalid] => 46145437P
            [petitiondate] => 2018-12-04T00:00:00+01:00
            [petitionid] => 2181306
            [petitiontime] => 1970-01-01T07:13:30.938+01:00
            [phones] => 
            [postalcode] => 08960
            [productbehaivour] => 0
            [productid] => 1
            [provincecode] => 08
            [resolutiondate] => 2018-12-04T00:00:00+01:00
            [resolutiontime] => 1970-01-01T07:13:33.119+01:00
            [secondsurname] => 
            [statepetitionid] => 4
            [xmlproductresult] => averagelower027.0402.5upperaverageB
            [yourreference] => 46145437P
        )

)
17+3+7+6+15+16+16+10
(228,229,230,231,232,233,234,235,236,332,219,220,221,213,214,217,218,252,253,254,200,201,202,207,208,209,212,191,192,193,194,195,196,255,256,257,258,259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,300,301,302,303,304,305,306,307,308,309,310,311,312,323,328,333,334,335,337,340,342,343,344,345,346,348,349,362,361,382,384,385,392,391,393,395,396,397,412,415,416)

<soap:envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:body><ns2:doinstantpetitionresponse xmlns:ns2="http://WebServerIncofisa/"><return><address>C. CONSTITUCIO Nº 2 1 3. SANT JUST DESVERN. 08960. BARCELONA</address><city></city><clientid>200</clientid><firstquerydate>2018-12-05T08:51:01.810+01:00</firstquerydate><firstquerytime>2018-12-05T08:51:01.810+01:00</firstquerytime><firstsurname>CALLS</firstsurname><name>SILVIA CALLS INSA</name><nationalid>46145437P</nationalid><petitiondate>2018-12-05T00:00:00+01:00</petitiondate><petitionid>2185648</petitionid><petitiontime>1970-01-01T08:50:59.495+01:00</petitiontime><phones></phones><postalcode>08960</postalcode><productbehaivour>0</productbehaivour><productid>1</productid><provincecode>08</provincecode><resolutiondate>2018-12-05T00:00:00+01:00</resolutiondate><resolutiontime>1970-01-01T08:51:01.559+01:00</resolutiontime><secondsurname>INSA</secondsurname><statepetitionid>4</statepetitionid><xmlproductresult>&lt;known_addresses&gt;upper&lt;/known_addresses&gt;&lt;debt_recovery_companies_queries&gt;0&lt;/debt_recovery_companies_queries&gt;&lt;default_probability&gt;27.04&lt;/default_probability&gt;&lt;familiar_help_probability&gt;lower&lt;/familiar_help_probability&gt;&lt;scoring_numeric&gt;2.5&lt;/scoring_numeric&gt;&lt;credit_companies_queries&gt;0&lt;/credit_companies_queries&gt;&lt;phone_contact_probability&gt;average&lt;/phone_contact_probability&gt;&lt;last_address_stay_duration&gt;average&lt;/last_address_stay_duration&gt;&lt;scoring&gt;B&lt;/scoring&gt;</xmlproductresult><yourreference>46145437P</yourreference></return></ns2:doinstantpetitionresponse></soap:body></soap:envelope>
*/

//print_r(availableProducts());
/*
	
		
}
*/

	
/*		
$xmlstring='<soap:envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:body><ns2:doinstantpetitionresponse xmlns:ns2="http://WebServerIncofisa/"><return><address></address><city></city><clientid>200</clientid><firstquerydate>2018-12-06T14:02:50.391+01:00</firstquerydate><firstquerytime>2018-12-06T14:02:50.391+01:00</firstquerytime><firstsurname>FABRA</firstsurname><name>JOSEP</name><nationalid>38142625T</nationalid><petitiondate>2018-12-06T00:00:00+01:00</petitiondate><petitionid>2189829</petitionid><petitiontime>1970-01-01T14:02:47.862+01:00</petitiontime><phones></phones><postalcode>     </postalcode><productbehaivour>0</productbehaivour><productid>1</productid><provincecode></provincecode><resolutiondate>2018-12-06T00:00:00+01:00</resolutiondate><resolutiontime>1970-01-01T14:02:50.128+01:00</resolutiontime><secondsurname>CARDONA</secondsurname><statepetitionid>4</statepetitionid><xmlproductresult>&lt;known_addresses&gt;upper&lt;/known_addresses&gt;&lt;last_address_stay_duration&gt;upper&lt;/last_address_stay_duration&gt;&lt;phone_contact_probability&gt;lower&lt;/phone_contact_probability&gt;&lt;debt_recovery_companies_queries&gt;5&lt;/debt_recovery_companies_queries&gt;&lt;familiar_help_probability&gt;lower&lt;/familiar_help_probability&gt;&lt;credit_companies_queries&gt;0&lt;/credit_companies_queries&gt;&lt;default_probability&gt;51.48&lt;/default_probability&gt;&lt;scoring&gt;BB&lt;/scoring&gt;&lt;scoring_numeric&gt;1.948&lt;/scoring_numeric&gt;</xmlproductresult><yourreference>38142625T</yourreference></return></ns2:doinstantpetitionresponse></soap:body></soap:envelope>';
*/
/*
<pre>SimpleXMLElement Object
(
    [soapBody] =&gt; SimpleXMLElement Object
        (
            [ns2doInstantPetitionResponse] =&gt; SimpleXMLElement Object
                (
                    [return] =&gt; SimpleXMLElement Object
                        (
                            [address] =&gt; SimpleXMLElement Object
                                (
                                )

                            [city] =&gt; SimpleXMLElement Object
                                (
                                )

                            [clientid] =&gt; 200
                            [firstquerydate] =&gt; 2018-12-06T14:20:35.230+01:00
                            [firstquerytime] =&gt; 2018-12-06T14:20:35.230+01:00
                            [firstsurname] =&gt; INSA
                            [name] =&gt; SILVIA
                            [nationalid] =&gt; B67193698
                            [petitiondate] =&gt; 2018-12-06T00:00:00+01:00
                            [petitionid] =&gt; 2189862
                            [petitiontime] =&gt; 1970-01-01T14:20:33.429+01:00
                            [phones] =&gt; SimpleXMLElement Object
                                (
                                )

                            [postalcode] =&gt; SimpleXMLElement Object
                                (
                                    [0] =&gt;      
                                )

                            [productbehaivour] =&gt; 0
                            [productid] =&gt; 1
                            [provincecode] =&gt; SimpleXMLElement Object
                                (
                                )

                            [resolutiondate] =&gt; 2018-12-06T00:00:00+01:00
                            [resolutiontime] =&gt; 1970-01-01T14:20:35.043+01:00
                            [secondsurname] =&gt; CARDONA
                            [statepetitionid] =&gt; 4
                            [xmlproductresult] =&gt; <scoring>B</scoring><credit_companies_queries>1</credit_companies_queries><scoring_numeric>2.474</scoring_numeric><known_addresses>upper</known_addresses><default_probability>28.88</default_probability><last_address_stay_duration>upper</last_address_stay_duration><familiar_help_probability>average</familiar_help_probability><phone_contact_probability>average</phone_contact_probability><debt_recovery_companies_queries>0</debt_recovery_companies_queries>
                            [yourreference] =&gt; B67193698
                        )

                )

        )

)
</pre>
$checklog=userLogin();
if($checklog){
		$doInstantPetition=array(	"productID"=>1,
									"yourReference"=>"b67193698",
									"nationalID"=>"b67193698",
									"productBehaviour"=>0,
									"firstSurname"=>"Insa",
									//"postalCode"=>"28500",
									"name"=>"silvia",
									"secondSurname"=>"cardona"
								);
		$petitionresult=doInstantPetition($doInstantPetition);
		echo "<pre>";
		print_r($petitionresult);
		echo "</pre>";

$xmlstring=$petitionresult;	
if(!empty($xmlstring)){
					$xmlString = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xmlstring);
					
					$xml = SimpleXML_Load_String($xmlString);
					

					$xml = new SimpleXMLElement($xml->asXML());
					if(!empty($xml->soapbody->ns2doinstantpetitionresponse))
						$checkVari=$xml->soapbody->ns2doinstantpetitionresponse;
					else if(!empty($xml->soapbody->ns2doInstantPetitionResponse))
						$checkVari=$xml->soapbody->ns2doInstantPetitionResponse;
					
					if(!empty($checkVari)){}
						$xmlproductresult=$checkVari->return->xmlproductresult;
						
						$nationalid=(array)$xml->soapbody->ns2doInstantPetitionResponse->return->nationalid;
						$insertArr['nationalid']=$nationalid[0];

						$petitionid=(array)$xml->soapbody->ns2doinstantpetitionresponse->return->petitionid;
						$insertArr['petitionid']=$petitionid[0];
						if(!empty($xmlproductresult)){
							$xmlproductresultresponse='<xmlproductresult>'.$xmlproductresult.'</xmlproductresult>';
							$productxml = simplexml_load_string($xmlproductresultresponse);
							$productxml= (array) $productxml;
							foreach($productxml as $key=>$values){
								    $insertArr[$key]=$values;
							}
						}
						if(!empty($insertArr)){
							$insertArr["loan_id"]=13;
								insertQuery("loan_petitions",$insertArr);
						}
					 }
				}
			}
			
}
*/

if($_SESSION['usertype'] == 'borrower'){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/myaccount/borrower/myloans');
	exit;
}

if(isset($_REQUEST['dologin']) && !empty($_REQUEST['dologin']) && $_REQUEST['dologin'] == 'yes'){
	
	if(count($_POST)){
			
		foreach($_POST as $key=>$val){
			
			$_POST[$key] = trim(htmlspecialchars($val));
		}
	}
	
	$email 				= isset($_POST['email']) ? $_POST['email'] : '';
	$password 			= isset($_POST['password']) ? $_POST['password'] : '';

	
	$flag = 1;
	
	if(empty($email)){
		
		$errors['type'] = 'email';
		$errors['msg'] = '* Enter email address';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		
		$errors['type'] = 'email';
		$errors['msg'] = '* Enter proper email address';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	if(empty($password)){
			
		$errors['type'] = 'password';
		$errors['msg'] = '* Enter password';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	
	
	if($flag == 1){
		
		$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_borrowers WHERE emailaddress = '".$email."' AND password = '".md5($password)."'";
		$checkemailSql = mysqli_query($con,$checkemailQry) or die(mysqli_error());
		$checkemailRow = mysqli_fetch_assoc($checkemailSql);
		
		$borrower_id = $checkemailRow['id']; 
		
		if(!empty($borrower_id)){
			
			$_SESSION['userid'] = $borrower_id;
			$_SESSION['wallet_id'] = $checkemailRow['wallet_id'];
			$_SESSION['usertype'] = 'borrower';
			

							
			
				if(isset($_SESSION['loan_id']) && $_SESSION['loan_id']!=""){

						header("Location:".BASE_URL.$_SESSION['currentLang'].'/loanremainingdata/'.$_SESSION['loan_id'].'/step1');
					
				}else{
					
						header("Location:".BASE_URL.$_SESSION['currentLang'].'/myaccount/borrower/myloans');

				}
				
			

			exit;
		}
		else{
			
			$errors['type'] = 'accountmessage';
			$errors['msg'] = $transArr['Invalid username or password'];
			$errorsFinal[] = $errors;
		}
	}
	
	$errstr = json_encode($errorsFinal);
	
	//echo '<pre>'; print_r($errorsFinal); //exit;
}
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major">
			<h2><?php echo($transArr['Welcome back']); ?></h2>
			<p><?php echo($transArr['To sign in, please enter your details. Not got an account?']); ?> <a href="<?=BASE_URL.$getLang?>/getloan/step1"><?php echo($transArr['Click here']); ?></a> <?php echo($transArr['to signup']); ?>.</p>
		</header>
		
		<section class="investorsignup">
			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>"">
			
				<input type="hidden" name="dologin" value="yes">
					
				<h2><?php echo($transArr['Borrower Signin']); ?></h2>
				
				<div id="accountmessage" style="display:none;"></div>
				
				<div class="row uniform 50%" style="text-align:left;">
					
					<div class="12u$">
						<input type="text" name="email" id="email" value="<?php echo($email); ?>" placeholder="<?php echo($transArr['Email']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="password" name="password" id="password" value="<?php echo($password); ?>" placeholder="<?php echo($transArr['Password']); ?>" />
					</div>
					
				</div>
				
				<div class="12u$" style="margin-top:25px;">
					<?php /* ?><input type="checkbox" name="rememberme" id="rememberme" value="yes" checked>
					<label for="rememberme" class="termlabel"><?php echo($transArr['Remember Me']); ?></label><?php */ ?>
				</div>
				
				<div class="12u$ formbtn">
					<ul class="actions">
						<li><input type="submit" value="<?php echo($transArr['Sign in Securely']); ?>" class="special" /></li>
					</ul>
				</div>
				
				<div class="12u$" style="margin-top:25px;">
					<a href="<?=BASE_URL.$getLang?>/borrower-forgot-password"><?php echo($transArr['Forgot Password']); ?>?</a>
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
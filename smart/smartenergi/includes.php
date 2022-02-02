<?php
define('DIRECTKIT_WS', 'https://sandbox-api.lemonway.fr/mb/demo/dev/directkitxml/Service.asmx');
define('INCOFISA_WSDL', 'https://api.grupoincofisa.com/WebServerIncofisa/WSPeticiones?wsdl');
define('LOGIN', 'society');
define('PASSWORD', '123456');
define('VERSION', '1.8');
define('LANGUAGE', 'en');
define('UA', isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'ua');
define('DIRECTKIT_WSDL', DIRECTKIT_WS."?wsdl");

define('INCOFISA_LOGIN', 'B67193698');
define('INCOFISA_PASSWORD', 'NTXYP');
/**
 * Get real IP
 * @return real IP
 */
function getUserIP() {
    $ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = "127.0.0.1";
    }
    return $ip;
}

/**
* check if service is online. This method is useless.
* you should simple try catch the "SoapFault" exception when calling "new SoapClient()" and other services
*/
function checkServiceOnline() {
    $options = array(
        CURLOPT_URL            => DIRECTKIT_WSDL,
        CURLOPT_CONNECTTIMEOUT => 60,
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_HEADER         => true,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_AUTOREFERER    => true,
    );
    
    $ch = curl_init();
    curl_setopt_array( $ch, $options );
    $response = curl_exec($ch); 
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ( $httpCode == 200 ){
        return true;
    } else {
        $errmsg = "Service unavailable: ".$httpCode." - ".curl_error($ch);
        throw new Exception($errmsg);
    }
}

function userLogin(){
    $client = new SoapClient(INCOFISA_WSDL, array("trace"=>true, "exceptions"=>true));
    $response=$client->userLogin(array("user"=>INCOFISA_LOGIN,"pass"=>INCOFISA_PASSWORD));
    if($response->return==1){
       
        if(isset($_COOKIE["JSESSIONID"]) && !empty($_COOKIE["JSESSIONID"]))
            $_COOKIE["JSESSIONID"]=$client->_cookies['JSESSIONID'][0];
        else
            setcookie("JSESSIONID",$client->_cookies['JSESSIONID'][0]);
       return true;
    }else
        return false;
}

function doInstantPetition($doInstantPetition=array()){  
        try{
            $client = new SoapClient(INCOFISA_WSDL, array("trace"=>1, "exceptions"=>true));
            $client->__setCookie("JSESSIONID",$_COOKIE["JSESSIONID"]);
            $result=$client->doInstantPetition($doInstantPetition);
            return $client->__getLastResponse();   
        }catch (SoapFault $e) {
            echo $e->faultstring;      
        }     
}

function availableProducts(){  

        try{
            $client = new SoapClient(INCOFISA_WSDL, array("trace"=>false, "exceptions"=>true));
            $client->__setCookie("JSESSIONID",$_COOKIE["JSESSIONID"]);
            $result=$client->availableProducts();
            return $result;   
        }catch (SoapFault $e) {
            echo $e->faultstring;           
        }     
}

function RegisterWallet($wallerArr=array()){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response=$client->RegisterWallet($wallerArr);
    return $response;
}


function RegisterCard($RegisterCard=array()){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response=$client->RegisterCard($RegisterCard);
    return $response;
}


function MoneyInWithCardId($MoneyInWithCardId=array()){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response=$client->MoneyInWithCardId($MoneyInWithCardId);
    return $response;
}

function GetWalletDetails($wallet_id){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response=$client->GetWalletDetails(array(
                                                "wlLogin"   => LOGIN,
                                                "wlPass"    => PASSWORD,
                                                "language"  => LANGUAGE,
                                                "version"   => VERSION,
                                                "walletIp"  => getUserIP(),
                                                "walletUa"  => UA,
                                                "wallet"    => $wallet_id
                                            ));
    return $response;
}

function GetWalletbyemailDetails($email){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response=$client->GetWalletDetails(array(
                                                "wlLogin"   => LOGIN,
                                                "wlPass"    => PASSWORD,
                                                "language"  => LANGUAGE,
                                                "version"   => VERSION,
                                                "walletIp"  => getUserIP(),
                                                "walletUa"  => UA,
                                                "email"    => $email
                                            ));
    return $response;
}
//print_r(GetWalletbyemailDetails('pixlritdeveloper@gmail.com'));
function SendPayment($payerWallet,$receiverWallet,$amount,$payername,$receivername){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response = $client->SendPayment(array(
            "wlLogin"       => LOGIN,
            "wlPass"        => PASSWORD,
            "language"      => LANGUAGE,
            "version"       => VERSION,
            "walletIp"      => getUserIP(),
            "walletUa"      => UA,
            "debitWallet"   => $payerWallet,
            "creditWallet"  => $receiverWallet,
            "amount"        => $amount,
            "message"       => "SendPayment €".$amount." from ".$payername." to ".$receivername
        ));
    return $response;
}

function UnregisterCard($walletid,$cardId){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response = $client->UnregisterCard(array(
            "wlLogin"       => LOGIN,
            "wlPass"        => PASSWORD,
            "language"      => LANGUAGE,
            "version"       => VERSION,
            "walletIp"      => getUserIP(),
            "walletUa"      => UA,
            "wallet"   => $walletid,
            "cardId"  => $cardId,
        ));
    return $response;
}

function RegisterIBAN($wallet,$iban,$holder,$bank_branch,$street_bank_branch,$bic=""){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $ibnarr=array(
                    "wlLogin"  => LOGIN,
                    "wlPass"   => PASSWORD,
                    "language" => LANGUAGE,
                    "version"  => VERSION,
                    "walletIp" => getUserIP(),
                    "walletUa" => UA,
                    "wallet"   => $wallet,
                    "holder"   => $holder,
                    "iban"     =>$iban,
                    "ignoreIbanFormat"=>0,
                    "dom1"=>$bank_branch,
                    "dom2"=>$street_bank_branch
                );
    if($bic!="'")
         $ibnarr["bic"] =$bic;
    $response = $client->RegisterIBAN($ibnarr);
    return $response;
}


//$RegisterCardResponse =
//RegisterIBAN("PHP-Merchant-5b8e653a62edb","ES4320808875485674526458","neha last","CANTON CLAUDINO PITA 2","BETANZOS");

//print_r($RegisterCardResponse);

function RegisterIBANExtended(){

    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $ibnarr=array(
                    "wlLogin"  => LOGIN,
                    "wlPass"   => PASSWORD,
                    "language" => LANGUAGE,
                    "version"  => VERSION,
                    "walletIp" => getUserIP(),
                    "walletUa" => UA,
                    "wallet"   => $wallet,
                    "accountType"   => 1,
                    "holderName"     =>$holderName,
                    "accountNumber"=>$accountNumber,
                    "holderCountry"=>$holderCountry,
                    "bankCountry"=>$bankCountry,
                    "bicCode"=>""
                );
    
    $response = $client->RegisterIBANExtended($ibnarr);
    return $response;
}

function UpdateWalletDetails($updatearray=array()){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response = $client->UpdateWalletDetails($updatearray);
    return $response;
}

function MoneyOut($wallet,$amountTot,$ibanid){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response = $client->MoneyOut(array(
                                            "wlLogin"  => LOGIN,
                                            "wlPass"   => PASSWORD,
                                            "language" => LANGUAGE,
                                            "version"  => VERSION,
                                            "walletIp" => getUserIP(),
                                            "walletUa" => UA,
                                            "wallet"   => $wallet,
                                            "amountTot"   => $amountTot,
                                            "autoCommission"     =>0,
                                            "ibanId"=>$ibanid
                                        ));
    return $response;
        
}


function GetWalletTransHistory($wallet,$startDate="",$endDate=""){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response = $client->GetWalletTransHistory(array(
                                            "wlLogin"  => LOGIN,
                                            "wlPass"   => PASSWORD,
                                            "language" => LANGUAGE,
                                            "version"  => VERSION,
                                            "walletIp" => getUserIP(),
                                            "walletUa" => UA,
                                            "wallet"   => $wallet,
                                           // "startDate"   => $startDate,
                                            //"endDate"     =>$endDate

                                        ));
    return $response;
        
}

function UpdateWalletStatus($wallet,$newStatus){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response = $client->UpdateWalletStatus(array("wlLogin"  => LOGIN,
                                                        "wlPass"   => PASSWORD,
                                                        "language" => LANGUAGE,
                                                        "version"  => VERSION,
                                                        "walletIp" => getUserIP(),
                                                        "walletUa" => UA,
                                                        "wallet"   => $wallet,
                                                        "newStatus"   => $newStatus,
                                                    ));
    return $response;
}
/*
function RegisterSddMandate($wallet,$holder,$bic,$iban){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response = $client->GetWalletTransHistory(array(
                                            "wlLogin"  => LOGIN,
                                            "wlPass"   => PASSWORD,
                                            "language" => LANGUAGE,
                                            "version"  => VERSION,
                                            "walletIp" => getUserIP(),
                                            "walletUa" => UA,
                                            "wallet"   => $wallet,
                                            "holder"  => $holder,
                                            "bic" => $bic,
                                            "iban" => $iban,
                                            "isRecurring"   => 1,
                                            "mandateLanguage"=>"es"
                                        ));
    return $response;
        
}

function MoneyInSddInit($wallet,$amountTot,$sddMandateId,$autoCommission,$collectionDate){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response = $client->GetWalletTransHistory(array(
                                            "wlLogin"  => LOGIN,
                                            "wlPass"   => PASSWORD,
                                            "language" => LANGUAGE,
                                            "version"  => VERSION,
                                            "walletIp" => getUserIP(),
                                            "walletUa" => UA,
                                            "wallet"   => $wallet,
                                            "amountTot"  => $amountTot,
                                            "autoCommission" => $autoCommission,
                                            "sddMandateId" => $sddMandateId,
                                            "collectionDate"=>$collectionDate
                                        ));
    return $response;
        
}

function SignDocumentInit($wallet,$mobileNumber,$sddMandateId,$returnUrl,$errorUrl){
    $client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));
    $response = $client->GetWalletTransHistory(array(
                                            "wlLogin"  => LOGIN,
                                            "wlPass"   => PASSWORD,
                                            "language" => LANGUAGE,
                                            "version"  => VERSION,
                                            "walletIp" => getUserIP(),
                                            "walletUa" => UA,
                                            "wallet"   => $wallet,
                                            "mobileNumber"  => $mobileNumber,
                                            "documentId" => $sddMandateId,
                                            "documentType" => 21,
                                            "returnUrl"=>$returnUrl,
                                            "errorUrl"=>$errorUrl
                                        ));
    return $response;
        
}

*/
function updateQuery($table_name,$whereArr,$updateArr,$con){
    $datastring="";
    foreach($whereArr as $key=> $data){
        $datadatastring .=$key.'='.$data." and";
    }
    $updatedatastring="";
    foreach($updateArr as $key=>$updatedata){
        $updatedatastring .= $key.'='.'"'.$updatedata.'",';
    }
    $updateSql = "UPDATE ".TABLE_PREFIX.$table_name." SET ".rtrim($updatedatastring,",") ." WHERE ".rtrim($datadatastring," and");
    $updateQry = mysqli_query($con,$updateSql) or die(mysqli_error());
    
    return $updateQry;
}

function selectQuery($table_name,$wherestring,$con){
    $checkwalletQry = "SELECT * FROM ".TABLE_PREFIX.$table_name." WHERE ".$wherestring;
    //echo $checkwalletQry;
    $checkwalletSql = mysqli_query($con,$checkwalletQry) or die(mysqli_error());

    $checkwalletRow = mysqli_fetch_assoc($checkwalletSql);
    return $checkwalletRow;
}

function selectQueryWithJoin($query,$con){
    $selectQueryWithJoin = $query;
    $selectQueryWithJoinSql = mysqli_query($con,$selectQueryWithJoin) or die(mysqli_error());
    return $selectQueryWithJoinSql;
}

function insertQuery($table_name,$insertarr,$con){
    $updatedatastring="";
    foreach($insertarr as $key=>$updatedata){
        $updatedatastring .= $key.'='.'"'.$updatedata.'",';
    }
    $insertSql = "INSERT INTO ".TABLE_PREFIX.$table_name." SET ".rtrim($updatedatastring,",");
                              
    $insertQry = mysqli_query($con,$insertSql) or die(mysqli_error());

    return mysqli_insert_id($con);
}


function checkEmail($email,$con){
    $sql="select sum(usercount) as usercount
                from (
                    select count(*) as usercount from smc_backoffice_merchants where email = '".$email."'
                    union all
                    select count(*) as usercount from smc_backoffice_borrowers where emailaddress = '".$email."'
                    union all
                    select count(*) as usercount from smc_backoffice_lenders where email = '".$email."'
                ) as usercounts";
             //   echo $sql;
    $countemail = mysqli_query($con,$sql) or die(mysqli_error());
    $countEmails=    mysqli_fetch_assoc($countemail);
    return $countEmails['usercount'];            
}

function getNameUsingWallet($wallet_id,$role,$con){
    if($role=="borrower"){
        $sql="select firstname,surname,emailaddress from ".TABLE_PREFIX."backoffice_borrowers where wallet_id = '".$wallet_id."'";
                   
    }else if($role=="merchant"){
        $sql="select merchant_name,email from ".TABLE_PREFIX."backoffice_merchants where wallet_id = '".$wallet_id."'";

    }else if($role=="lender"){
        $sql="select a.lender_name,email from ".TABLE_PREFIX."backoffice_lenders as a join smc_backoffice_lenders_wallet as b on  b.lender_id=a.id where b.wallet_id = '".$wallet_id."'";
    }    
    
    $getNameUsingWallet = mysqli_query($con,$sql) or die(mysqli_error());
    $username=    mysqli_fetch_assoc($getNameUsingWallet);
    return $username;            
}

function getContents($str, $startDelimiter, $endDelimiter) {
  $contents = array();
  $startDelimiterLength = strlen($startDelimiter);
  $endDelimiterLength = strlen($endDelimiter);
  $startFrom = $contentStart = $contentEnd = 0;
  while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
    $contentStart += $startDelimiterLength;
    $contentEnd = strpos($str, $endDelimiter, $contentStart);
    if (false === $contentEnd) {
      break;
    }

    $value = substr($str, $contentStart, $contentEnd - $contentStart) ;
    $str = str_replace("{".$value."}",$_POST[$value],$str);
    //$contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
    $startFrom = $contentEnd + $endDelimiterLength;
  }

return $str ;
}

function getCreditCardType($str, $format = 'string')
    {
        if (empty($str)) {
            return false;
        }

        $matchingPatterns = array(
           "0"=> '/^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/',
           "1"=> '/^4[0-9]{12}(?:[0-9]{3})?$/',
           "2"=> '/^5[1-5][0-9]{14}$/'
        );

        $ctr = 1;
        foreach ($matchingPatterns as $key=>$pattern) {
            if (preg_match($pattern, $str)) {
                return $format == 'string' ? $key : $ctr;
            }
            $ctr++;
        }
    }
   // print_r(getCreditCardType("5100000000000016"));
/*
function getcardtype($number){
   $cardarray= array(
                'maestro'=> /^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/,
                'visa'=> /^4[0-9]{12}(?:[0-9]{3})?$/,
                'mastercard'=> /^5[1-5][0-9]{14}$/
              )

   if(in_array($number, $cardarray)){
        return true;
   }else{
        return false;
   }
   
}
*/
function checkIBAN($iban)
{
    $iban = strtolower(str_replace(' ','',$iban));
    $Countries = array('al'=>28,'ad'=>24,'at'=>20,'az'=>28,'bh'=>22,'be'=>16,'ba'=>20,'br'=>29,'bg'=>22,'cr'=>21,'hr'=>21,'cy'=>28,'cz'=>24,'dk'=>18,'do'=>28,'ee'=>20,'fo'=>18,'fi'=>18,'fr'=>27,'ge'=>22,'de'=>22,'gi'=>23,'gr'=>27,'gl'=>18,'gt'=>28,'hu'=>28,'is'=>26,'ie'=>22,'il'=>23,'it'=>27,'jo'=>30,'kz'=>20,'kw'=>30,'lv'=>21,'lb'=>28,'li'=>21,'lt'=>20,'lu'=>20,'mk'=>19,'mt'=>31,'mr'=>27,'mu'=>30,'mc'=>27,'md'=>24,'me'=>22,'nl'=>18,'no'=>15,'pk'=>24,'ps'=>29,'pl'=>28,'pt'=>25,'qa'=>29,'ro'=>24,'sm'=>27,'sa'=>24,'rs'=>22,'sk'=>24,'si'=>19,'es'=>24,'se'=>24,'ch'=>21,'tn'=>24,'tr'=>26,'ae'=>23,'gb'=>22,'vg'=>24);
    $Chars = array('a'=>10,'b'=>11,'c'=>12,'d'=>13,'e'=>14,'f'=>15,'g'=>16,'h'=>17,'i'=>18,'j'=>19,'k'=>20,'l'=>21,'m'=>22,'n'=>23,'o'=>24,'p'=>25,'q'=>26,'r'=>27,'s'=>28,'t'=>29,'u'=>30,'v'=>31,'w'=>32,'x'=>33,'y'=>34,'z'=>35);

    if(strlen($iban) == $Countries[substr($iban,0,2)]){

        $MovedChar = substr($iban, 4).substr($iban,0,4);
        $MovedCharArray = str_split($MovedChar);
        $NewString = "";

        foreach($MovedCharArray AS $key => $value){
            if(!is_numeric($MovedCharArray[$key])){
                $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
            }
            $NewString .= $MovedCharArray[$key];
        }

        if(bcmod($NewString, '97') == 1)
        {
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }   
}

function checkBic($bic)
{
    if (preg_match("/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i", $bic)) {
        return true;
    } else {
        return false;
    }
}

function ccMasking($number, $maskingCharacter = 'X') {
    return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
}

function removespecialcharacter($error){
    $error = str_replace(' ', '-',$error);
    $error= preg_replace('/[^A-Za-z0-9\-]/', '', $error);
    return $error;
}

/*
function checkEditProfile($id,$role){

    $notin="";
    if($role=="borrower")
        $notin .=" and NOT IN  id('".$id."')";
    else if($role=="merchant")
        $notin .=" and NOT IN  id('".$id."')";
    else if($role=="lender")
        $notin .=" and NOT IN  id('".$id."')";

    $sql="select sum(usercount) as usercount
                from (
                    select count(*) as usercount from smc_backoffice_merchants where email = '".$email."'".$notin."
                    union all
                    select count(*) as usercount from smc_backoffice_borrowers where emailaddress = '".$email."'".$notin."
                    union all
                    select count(*) as usercount from smc_backoffice_lenders where email = '".$email."'".$notin."
                ) as usercounts";
     echo $sql;           
    $countemail = mysql_query($sql) or die(mysql_error());

    return $countemail;            
}*/
function isValidXml($content)
{
    $content = trim($content);
    if (empty($content)) {
        return false;
    }
    //html go to hell!
    if (stripos($content, '<!DOCTYPE html>') !== false) {
        return false;
    }

    libxml_use_internal_errors(true);
    simplexml_load_string($content);
    $errors = libxml_get_errors();          
    libxml_clear_errors();  

    return empty($errors);
}
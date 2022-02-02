<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use SoapClient;
use DB;
/*
define('DIRECTKIT_WS', 'https://sandbox-api.lemonway.fr/mb/demo/dev/directkitxml/Service.asmx');
define('LOGIN', 'society');
define('PASSWORD', '123456');
define('VERSION', '1.8');
define('LANGUAGE', 'en');
define('UA', isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'ua');
define('DIRECTKIT_WSDL', config('constants.DIRECTKIT_WS')."?wsdl");
*/

class Lemonway
{
	public static function getUserIP() {
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
	
	public static function RegisterWallet($wallerArr=array()){
	    $client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));
	    $response=$client->RegisterWallet($wallerArr);
	    return $response;
	}

	public static function RegisterCard($RegisterCard=array()){
	   $client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));

	    $response=$client->RegisterCard($RegisterCard);
	    return $response;
	}

	public static function MoneyInWithCardId($MoneyInWithCardId=array()){
	    $client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));

	    $response=$client->MoneyInWithCardId($MoneyInWithCardId);
	    return $response;
	}

	public static function GetWalletDetails($wallet_id){
	    $client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));

	    $response=$client->GetWalletDetails(array(
	                                                "wlLogin"   => config('constants.LOGIN'),
	                                                "wlPass"    => config('constants.PASSWORD'),
	                                                "language"  => config('constants.LANGUAGE'),
	                                                "version"   => config('constants.VERSION'),
	                                                "walletIp"  => self::getUserIP(),
	                                                "walletUa"  => config('constants.UA'),
	                                                "wallet"    => $wallet_id
	                                            ));
	    return $response;
	}

	public static function GetWalletbyemailDetails($wallet_id){
	    $client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));

	    $response=$client->GetWalletDetails(array(
	                                                "wlLogin"   => config('constants.LOGIN'),
	                                                "wlPass"    => config('constants.PASSWORD'),
	                                                "language"  => config('constants.LANGUAGE'),
	                                                "version"   => config('constants.VERSION'),
	                                                "walletIp"  => self::getUserIP(),
	                                                "walletUa"  => config('constants.UA'),
	                                                "email"    => $wallet_id
	                                            ));
	    return $response;
	}

	public static function SendPayment($payerWallet,$receiverWallet,$amount,$payername,$receivername){
	    $client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));

	    $response = $client->SendPayment(array(
	            "wlLogin"       => config('constants.LOGIN'),
	            "wlPass"        => config('constants.PASSWORD'),
	            "language"      => config('constants.LANGUAGE'),
	            "version"       => config('constants.VERSION'),
	            "walletIp"      => self::getUserIP(),
	            "walletUa"      => config('constants.UA'),
	            "debitWallet"   => $payerWallet,
	            "creditWallet"  => $receiverWallet,
	            "amount"        => $amount,
	            "message"       => "SendPayment €".$amount." from ".$payername." to ".$receivername
	        ));
	    return $response;
	}

	public static function UnregisterCard($walletid,$cardId){
	    $client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));

	    $response = $client->UnregisterCard(array(
	            "wlLogin"       => config('constants.LOGIN'),
	            "wlPass"        => config('constants.PASSWORD'),
	            "language"      => config('constants.LANGUAGE'),
	            "version"       => config('constants.VERSION'),
	            "walletIp"      => self::getUserIP(),
	            "walletUa"      => config('constants.UA'),
	            "wallet"   => $walletid,
	            "cardId"  => $cardId,
	        ));
	    return $response;
	}

	public static function RegisterIBAN($wallet,$iban,$holder,$bank_branch,$street_bank_branch,$bic=""){
	    $client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));
	    $ibnarr=array(
	                    "wlLogin"  => config('constants.LOGIN'),
	                    "wlPass"   => config('constants.PASSWORD'),
	                    "language" => config('constants.LANGUAGE'),
	                    "version"  => config('constants.VERSION'),
	                    "walletIp" => self::getUserIP(),
	                    "walletUa" => config('constants.UA'),
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

	public static function MoneyOut($wallet,$amountTot,$ibanid){
	    
		$client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));
	    $response = $client->MoneyOut(array(
	                                            "wlLogin"  => config('constants.LOGIN'),
	                                            "wlPass"   => config('constants.PASSWORD'),
	                                            "language" => config('constants.LANGUAGE'),
	                                            "version"  => config('constants.VERSION'),
	                                            "walletIp" => self::getUserIP(),
	                                            "walletUa" => config('constants.UA'),
	                                            "wallet"   => $wallet,
	                                            "amountTot"   => $amountTot,
	                                            "autoCommission"     =>0,
	                                            "ibanId"=>$ibanid
	                                        ));
	    return $response;
	        
	}

	public static function GetWalletTransHistory($wallet,$startDate="",$endDate=""){
	    $client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));

	    $response = $client->GetWalletTransHistory(array(
	                                            "wlLogin"  => config('constants.LOGIN'),
	                                            "wlPass"   => config('constants.PASSWORD'),
	                                            "language" => config('constants.LANGUAGE'),
	                                            "version"  => config('constants.VERSION'),
	                                            "walletIp" => self::getUserIP(),
	                                            "walletUa" => config('constants.UA'),
	                                            "wallet"   => $wallet,
	                                           // "startDate"   => $startDate,
	                                            //"endDate"     =>$endDate

	                                        ));
	    return $response;
	        
	}

	public static function RegisterSddMandate($wallet,$holder,$bic,$iban){
	    $client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));

	    $response = $client->RegisterSddMandate(array(
	                                            "wlLogin"  => config('constants.LOGIN'),
	                                            "wlPass"   => config('constants.PASSWORD'),
	                                            "language" => config('constants.LANGUAGE'),
	                                            "version"  => config('constants.VERSION'),
	                                            "walletIp" => self::getUserIP(),
	                                            "walletUa" => config('constants.UA'),
	                                            "wallet"   => $wallet,
	                                            "holder"   => $holder,
	                                            "bic"     =>$bic,
	                                            "iban"   => $iban,
	                                            "isRecurring"   => 0,
	                                            "isB2B"=>0,
		                                        "mandateLanguage"=>"en"
	                                        ));
	    return $response;
	        
	}

	public static function MoneyInSddInit($creditwallet,$amountTot,$sddMandateId){
			$client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));

		    $response = $client->MoneyInSddInit(array(
		                                            "wlLogin"  => config('constants.LOGIN'),
		                                            "wlPass"   => config('constants.PASSWORD'),
		                                            "language" => config('constants.LANGUAGE'),
		                                            "version"  => config('constants.VERSION'),
		                                            "walletIp" => self::getUserIP(),
		                                            "walletUa" => config('constants.UA'),
		                                            "wallet"   => $creditwallet,
		                                            "amountTot"   => $amountTot,
		                                            "autoCommission"=>0,
		                                            "sddMandateId" =>$sddMandateId,

		                                        ));
		    return $response;
	}

	public static function UpdateWalletStatus($wallet,$newStatus){
			$client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));
		    $response = $client->UpdateWalletStatus(array("wlLogin"  => config('constants.LOGIN'),
	                                                        "wlPass"   => config('constants.PASSWORD'),
	                                                        "language" => config('constants.LANGUAGE'),
	                                                        "version"  => config('constants.VERSION'),
	                                                        "walletIp" => self::getUserIP(),
	                                                        "walletUa" => config('constants.UA'),
	                                                        "wallet"   => $wallet,
	                                                        "newStatus"   => $newStatus,
		                                                  ));
		    return $response;
	}

	public static function SignDocumentInit($wallet,$documentId,$mob){
			$client = new SoapClient(config('constants.DIRECTKIT_WS')."?wsdl", array("trace"=>true, "exceptions"=>true));
		    $response = $client->SignDocumentInit(array(
                                            "wlLogin"  => config('constants.LOGIN'),
                                            "wlPass"   => config('constants.PASSWORD'),
                                            "language" => config('constants.LANGUAGE'),
                                            "version"  => config('constants.VERSION'),
                                            "walletIp" => self::getUserIP(),
                                            "walletUa" => config('constants.UA'),
                                            "wallet"   => $wallet,
                                            "mobileNumber"=>"919827546202",
                                            "documentId"   => $documentId,
                                            "documentType"  =>"21",
                                            "returnUrl"   => "https://www.smartcredit.es/es/p/about-us",
                                            "errorUrl"   => "https://www.smartcredit.es"
		                                        		));
		    return $response;

	}
	
    public static function checkIBAN($iban)
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

	public static function checkEmail($email){

	    $sql="select sum(usercount) as usercount
	                from (
	                    select count(*) as usercount from smc_backoffice_merchants where email = '".$email."'
	                    union all
	                    select count(*) as usercount from smc_backoffice_borrowers where emailaddress = '".$email."'
	                    union all
	                    select count(*) as usercount from smc_backoffice_lenders where email = '".$email."'
	                ) as usercounts";
	    $countemail = DB::select($sql); 
	    //print_r();           
	             //   echo $sql;
	    //$countemail = mysql_query($sql) or die(mysql_error());
	    //$countEmails=    mysql_fetch_assoc($countemail);
	    return $countemail[0]->usercount;            
	}

	public static function getCreditCardType($str, $format = 'string')
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
}
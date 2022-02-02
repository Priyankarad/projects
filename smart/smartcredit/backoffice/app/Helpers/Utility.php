<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use DB;
use PDF;

define('FINANCIAL_MAX_ITERATIONS', 128);
define('FINANCIAL_PRECISION', 1.0e-08);

class Utility
{
    public static function variables()
    {
        // Get Variables
		
		$variables = array();
		$status = array();
		$marital_status = array();
		$employment_type = array();
		$service_type = array();
		$security_questions = array();
		$merchant_prod_type = array();
		
		// Status
		$records = DB::table('dropdown_values')
				   ->where('flag','=','1')
				   ->where('type','=','living_status')
				   ->get();
		
		if(count($records)){
			
			foreach($records as $val){
				
				$status[$val->id] = $val->value;
			}
		}
		
		// Marital Status
		$records = DB::table('dropdown_values')
				   ->where('flag','=','1')
				   ->where('type','=','marital_status')
				   ->get();
		
		if(count($records)){
			
			foreach($records as $val){
				
				$marital_status[$val->id] = $val->value;
			}
		}
		
		// Employment Type
		$records = DB::table('dropdown_values')
				   ->where('flag','=','1')
				   ->where('type','=','employment_type')
				   ->get();
		
		if(count($records)){
			
			foreach($records as $val){
				
				$employment_type[$val->id] = $val->value;
			}
		}
		
		// Service Type
		$records = DB::table('dropdown_values')
				   ->where('flag','=','1')
				   ->where('type','=','service_type')
				   ->get();
		
		if(count($records)){
			
			foreach($records as $val){
				
				$service_type[$val->id] = $val->value;
			}
		}
		
		// Security Questions
		$records = DB::table('dropdown_values')
				   ->where('flag','=','1')
				   ->where('type','=','security_questions')
				   ->get();
		
		if(count($records)){
			
			foreach($records as $val){
				
				$security_questions[$val->id] = $val->value;
			}
		}
		
		// Merchant Product Type
		$records = DB::table('dropdown_values')
				   ->where('flag','=','1')
				   ->where('type','=','merchant_prod_type')
				   ->get();
		
		if(count($records)){
			
			foreach($records as $val){
				
				$merchant_prod_type[$val->id] = $val->value;
			}
		}
		
		$variables['status'] = $status;
		$variables['marital_status'] = $marital_status;
		$variables['employment_status'] = $employment_type;
		$variables['service_type'] = $service_type;
		$variables['security_questions'] = $security_questions;
		$variables['merchant_prod_type'] = $merchant_prod_type;
		$variables['months'] = [
		
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
		];

		return $variables;
    }
	
	public static function getloanstatuscount(){
		
		$countarr = array();
		
		// Pending Count
		$records = DB::table('backoffice_loan_applications')
				   ->select(DB::raw("COUNT(id) AS countno"))
				   ->where('status','=','pending')
				   ->first();
				   
		$countarr['pending'] = $records->countno;
		
		// Approved Count
		$records = DB::table('backoffice_loan_applications')
				   ->select(DB::raw("COUNT(id) AS countno"))
				   ->where('status','=','approved')
				   ->first();
				   
		$countarr['approved'] = $records->countno;
		
		// Rejected Count
		$records = DB::table('backoffice_loan_applications')
				   ->select(DB::raw("COUNT(id) AS countno"))
				   ->where('status','=','rejected')
				   ->first();
				   
		$countarr['rejected'] = $records->countno;
		
		// Closed Count
		$records = DB::table('backoffice_loan_applications')
				   ->select(DB::raw("COUNT(id) AS countno"))
				   ->where('status','=','closed')
				   ->first();
				   
		$countarr['closed'] = $records->countno;
		
		// All Count
		$records = DB::table('backoffice_loan_applications')
				   ->select(DB::raw("COUNT(id) AS countno"))
				   ->first();
				   
		$countarr['all'] = $records->countno;
		
		return (object) $countarr;
	}
	
	public static function getloanstatuscountpercentage(){
		
		$countarrPer = array();
		
		$countarr = Utility::getloanstatuscount();
		
		$pending = $countarr->pending;
		$approved = $countarr->approved;
		$rejected = $countarr->rejected;
		$closed = $countarr->closed;
		$all = $countarr->all;
		
		if($all > 0){
			
			$pendingPer = round((100/$all)*$pending);
			$approvedPer = round((100/$all)*$approved);
			$rejectedPer = round((100/$all)*$rejected);
			$closedPer = round((100/$all)*$closed);
		}
		else{
			
			$pendingPer = 0;
			$approvedPer = 0;
			$rejectedPer = 0;
			$closedPer = 0;
		}
		
		$countarrPer['pending'] = $pendingPer;
		$countarrPer['approved'] = $approvedPer;
		$countarrPer['rejected'] = $rejectedPer;
		$countarrPer['closed'] = $closedPer;
		
		return (object) $countarrPer;
	}
	
	public static function getloan($loan_id){
		$recorddetails = DB::table('backoffice_loan_applications AS LA')
						 ->leftJoin("backoffice_borrowers AS BO","BO.id", "=", "LA.borrower_id")
						 ->leftJoin("backoffice_merchants AS BM","BM.id", "=", "LA.merchant_id")
						 ->leftJoin("dropdown_values AS DV","BO.employmenttype", "=", "DV.id")
						 ->leftJoin("loan_petitions AS LP","LP.loan_id", "=", "LA.id")
						 ->select("LA.*","BO.firstname","BO.middlename","BO.surname","BO.emailaddress","BO.city as borrowercity","DV.value as employmenttype","BO.dob","BO.housenumber","BO.streetname","BO.suburb","BO.city","BO.province","BO.postcode","BM.merchant_name","BM.merchant_cif","BM.contact_person","BM.email AS merchant_email","BO.cellphonenumber","LP.scoring")
						 ->where('LA.id', $loan_id)
						 ->first();
				 
		
		// Get first pay date
		
		$firstpaydetails = DB::table('backoffice_loan_payments')
							->where('loan_id', '=', $loan_id)
							->first();
		
		$recorddetails->firstpaydate = !empty($firstpaydetails) ? date('d/m/Y', $firstpaydetails->emi_timestamp) : '';
		
		// Get first pay date
		
		$lastpaydetails = DB::table('backoffice_loan_payments')
							->where('loan_id', '=', $loan_id)
							->orderBy('id','desc')
							->first();
		
		$recorddetails->lastpaydate = !empty($lastpaydetails) ? date('d/m/Y', $lastpaydetails->emi_timestamp) : '';
		
		// Get Contractual Document
		
		$getfile = DB::table('backoffice_loan_documents')
					->where('loan_id', '=', $loan_id)
					->where('document_type', '=', 'contractual_document')
					->first();
					
		//dd($getfile);
		
		$recorddetails->contractual_document = !empty($getfile) ? $getfile->document_path : '';
		
		// Get Pre Contractual Document
		
		$getfile = DB::table('backoffice_loan_documents')
					->where('loan_id', '=', $loan_id)
					->where('document_type', '=', 'pre_contractual_document')
					->first();
					
		//dd($getfile);
		
		$recorddetails->pre_contractual_document = !empty($getfile) ? $getfile->document_path : '';
		
		// Get SECCIS Document
		
		$getfile = DB::table('backoffice_loan_documents')
					->where('loan_id', '=', $loan_id)
					->where('document_type', '=', 'seccis_document')
					->first();
					
		//dd($getfile);
		
		$recorddetails->seccis_document = !empty($getfile) ? $getfile->document_path : '';
		
		//dd($recorddetails);
		
		return $recorddetails;
	}
	
	public static function getconfig(){
		
		$config = array();
		
		$recorddetails = DB::table('config')->get();
				 
		if(count($recorddetails)){
			
			foreach($recorddetails as $record){
				
				$config[$record->config_type] = $record->config_val;
			}
		}
		
		return (object) $config;
	}

	
	
	public static function generatepdf($type,$loan_id){
		
		$loandata = Utility::getloan($loan_id);
		
		$config = Utility::getconfig();
		
		$name = $loandata->firstname.' '.$loandata->middlename.' '.$loandata->surname;
		
		$address = '';
										
		$housenumber = $loandata->housenumber;
		$streetname = $loandata->streetname;
		$suburb = $loandata->suburb;
		$city = $loandata->city;
		$province = $loandata->province;
		$postcode = $loandata->postcode;
		
		$address = $housenumber.' '.$streetname.', '.$city.', '.$province.', '.$postcode;
		
		$loandate = date('d/m/Y', $loandata->createdate);
		$loanterm = $loandata->loan_terms;
		$loanamount = $loandata->loan_amount;
		$loanapr = $loandata->loan_apr;
		$loanfirstdate = $loandata->firstpaydate;
		$loanlastdate = $loandata->lastpaydate;
		$loan_unique_id = $loandata->unique_id;
		$merchantname = $loandata->merchant_name;
		$merchantid = $loandata->merchant_cif;
		
		$data['name'] = $name;
		$data['address'] = $address;
		$data['date'] = $loandate;
		$data['amount'] = $loanamount;
		$data['apr'] = $loanapr;
		$data['term'] = $loanterm;
		$data['firstdate'] = $loanfirstdate;
		$data['lastdate'] = $loanlastdate;
		$data['merchant'] = !empty($merchantname) ? $merchantname.' [ID: '.$merchantid.']' : 'N/A';
		
		$data['project_name'] = $config->project_name;
		$data['company_number'] = $config->company_number;
		$data['company_phone_no'] = $config->company_phone_no;
		$data['company_address'] = nl2br((trim(stripslashes($config->company_address))));
		$data['company_official_email_address'] = $config->company_official_email_address;
		$data['company_web_url'] = $config->company_web_url;
		
		//$loan_fees = $loanamount*0.03;
		$loan_fees = $config->default_fee;
		
		$data['default_fees'] = $loan_fees;
		$data['default_apr'] = $config->default_apr;
		
		// Calculate Monthly Cost
		
		$p = intval($loanamount);
		$j = $loanapr/(12*100);
		$n = $loanterm;
		
		$m = ($p*$j)/(1-pow((1+$j),-$n));
		
		$m = round($m,2);
		
		$data['monthly_cost'] = $m;
		
		// Calculate APR/TAE
		
		$rate = $config = Utility::rate($n,-$m,($p-$loan_fees),0,0);
		$tae = round((pow((1 + $rate),12)-1)*100,2);
		
		$data['tae'] = $tae;
		
		
		if($type == 'contractual_document'){
			
			$filename = 'contractual_document_'.$loan_unique_id.'.pdf';
		
			$pdf = PDF::loadView('templates.contract', $data);
			$pdf->save(base_path().'/generatedfiles/'.$filename);
			
			DB::table('backoffice_loan_documents')->insert(				
				[
					'loan_id' => $loan_id,
					'document_type' => 'contractual_document',
					'document_path' => $filename,
					'type' => 'systemgenerated',
					'createdate' => time()
				]
			);
		}
		else if($type == 'pre_contractual_document'){
			
			$filename = 'pre_contractual_document_'.$loan_unique_id.'.pdf';
		
			$pdf = PDF::loadView('templates.precontract', $data);
			$pdf->save(base_path().'/generatedfiles/'.$filename);
			
			DB::table('backoffice_loan_documents')->insert(				
				[
					'loan_id' => $loan_id,
					'document_type' => 'pre_contractual_document',
					'document_path' => $filename,
					'type' => 'systemgenerated',
					'createdate' => time()
				]
			);
		}
		else if($type == 'seccis_document'){
			
			$filename = 'seccis_document_'.$loan_unique_id.'.pdf';
		
			$pdf = PDF::loadView('templates.seccis', $data);
			$pdf->save(base_path().'/generatedfiles/'.$filename);
			
			DB::table('backoffice_loan_documents')->insert(				
				[
					'loan_id' => $loan_id,
					'document_type' => 'seccis_document',
					'document_path' => $filename,
					'type' => 'systemgenerated',
					'createdate' => time()
				]
			);
		}
	}
	
	public static function rate($nper, $pmt, $pv, $fv = 0.0, $type = 0, $guess = 0.1) {
		
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
	}

	//$rate = RATE(12,-270.77,(3000-35),0,0);
	//$tae = (pow((1 + $rate),12)-1)*100;

	public static function getLoanTemplate($template_name){
			$getLoanTemplate = DB::table('backoffice_email_templates')
					->where('email_template_name', '=', $template_name)
					->first();
					
			return $getLoanTemplate;
	}

	public static function getContents($str, $startDelimiter, $endDelimiter,$direcval="") {
		  $contents = array();
		  
			$str=str_replace("{{&nbsp;","{{ ", $str);
			$str=str_replace("&nbsp;}}"," }}", $str);
			$str=str_replace("â€‹"," ", $str);
		  $startDelimiterLength = strlen($startDelimiter);
		  $endDelimiterLength = strlen($endDelimiter);
		  $startFrom = $contentStart = $contentEnd = 0;

		  while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
		    $contentStart += $startDelimiterLength;
		    $contentEnd = strpos($str, $endDelimiter, $contentStart);
		    if (false === $contentEnd) {
		      break;
		    }
		    //$value = substr($str, $contentStart, $contentEnd - $contentStart);
		    $startFrom = $contentEnd + $endDelimiterLength;

		    $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
		  }
		  if(!empty($contents)){
		  	foreach($contents as $value){
		  	$str = str_replace("{{ ".$value." }}",$direcval[$value],$str);
		  	}
		  }
		  return $str;
		  //echo $str."<br/>";
		 // print_r($contents);
		  
  //return $contents;
/*
		$contents = array();
		$startDelimiterLength = strlen($startDelimiter);
		$endDelimiterLength = strlen($endDelimiter);
		$startFrom = $contentStart = $contentEnd = 0;
		echo $str;
		if(!empty($direcval)){
			if($contentStart = strpos($str, $startDelimiter, $startFrom)){
				while (false !== ($contentStart)) {
				    $contentStart += $startDelimiterLength;
				    $contentEnd = strpos($str, $endDelimiter, $contentStart);
				    if (false === $contentEnd) {
				      break;
				    }

					$value = substr($str, $contentStart, $contentEnd - $contentStart) ;
					echo $value."<br/>";
					$str = str_replace("{{ ".$value." }}",$direcval[$value],$str);
				    $startFrom = $contentEnd + $endDelimiterLength;
				}
			}
		}else{
			if($contentStart = strpos($str, $startDelimiter, $startFrom)){
				while (false !== ($contentStart)) {
				    $contentStart += $startDelimiterLength;
				    $contentEnd = strpos($str, $endDelimiter, $contentStart);
				    if (false === $contentEnd) {
				      break;
				    }

					$value = substr($str, $contentStart, $contentEnd - $contentStart) ;
					$str = str_replace("{{ ".$value." }}","{{ $".$value." }}",$str);
				    $startFrom = $contentEnd + $endDelimiterLength;
				}
			}
		}
		return $str ;*/
	}

	public static function sendsms($mobile,$message){
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		
		  CURLOPT_URL => "https://api.esendex.com/v1.0/messagedispatcher",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode(array(
			"accountreference" => "EX0247265",
			"messages" => array(
				0 => array(			
					"to" => $mobile,
					"body" => $message
				)
			)
		  )),
		  CURLOPT_HTTPHEADER => array(
			"authorization: Basic c2lsdmlhQHNtYXJ0Y3JlZGl0LmVzOkNlbGVzdGUxMCE=",
			"cache-control: no-cache",
			"content-type: application/json",
			"postman-token: f738539d-13e7-facf-f4f3-a6eb634e4027"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
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

}

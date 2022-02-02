<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use DB;
use Mail;
use View;
use PDF;

class Mails
{

	public static function merchantregister($merchant_id){

		$merchantData = DB::table('backoffice_merchants')->where('unique_identifier', $merchant_id)->first();
		$admin_notify_merchant_registration= Utility::getLoanTemplate("admin_notify_merchant_registration");
		$merchant_agreement_notify= Utility::getLoanTemplate("merchant_agreement_notify");
		$filename = 'merchant_agreement_'.$merchantData->id.'.pdf';
		$config = Utility::getconfig();
		$mailData = array(
							'merchant_name' =>$merchantData->merchant_name,
							'merchant_cif' => $merchantData->merchant_cif,
							'email' => $merchantData->email,
							'projectname' => $config->project_name,
							'createdate'=>$merchantData->createdate,
							'url'=>$merchantData->url,
							'mobile_no'=>$merchantData->mobile_no,
							'contact_person'=>$merchantData->contact_person,
							'agreement'=>base_path().'/merchantgeneratedfiles/'.$filename,
							'toemail' => $config->company_official_email_address
						);

		
		$pdf = PDF::loadView('templates.merchantterms', $mailData);
		$pdf->save(base_path().'/merchantgeneratedfiles/'.$filename);

		DB::table('backoffice_merchants')
					->where('id', $merchantData->id)
					->update(
					[
						'agreement' => $filename
					]
				);
		
$subject = Utility::getContents(utf8_decode($admin_notify_merchant_registration->email_subject), "{{ "," }}",$mailData);
$email_content= Utility::getContents(stripcslashes($admin_notify_merchant_registration->email_content),"{{ ", " }}",$mailData);

$mailData['subject']=$subject;
$mailData['email_content']=($email_content);

$merchantsubject = Utility::getContents(utf8_decode($merchant_agreement_notify->email_subject), "{{ "," }}",$mailData);
$merchantcontent= Utility::getContents(stripcslashes($merchant_agreement_notify->email_content),"{{ ", " }}",$mailData);

		$mailData['merchant_subject']=$merchantsubject;
		$mailData['merchant_content']=$merchantcontent;		

		Mail::send('emails.adminmerchantregistration', $mailData, function($message) use ($mailData)
		{
			$message->attach($mailData['agreement'],['as' => 'Terms agreement']);
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['toemail'], $mailData['merchant_name'])->subject($mailData['subject']);
		});

		Mail::send('emails.merchantregistration', $mailData, function($message) use ($mailData)
		{
			$message->attach($mailData['agreement'],['as' => 'Terms agreement']);
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['email'], $mailData['merchant_name'])->subject($mailData['subject']);
		});
	}

    public static function loanrejected($loan_id){
		
		$loanData = Utility::getloan($loan_id);
		$getLoanRejectedTemplate= Utility::getLoanTemplate("loan_rejected");
		$config = Utility::getconfig();
		$mailData = array(
							'firstname' =>$loanData->firstname,
							'middlename' => $loanData->middlename,
							'surname' => $loanData->surname,
							'emailaddress' => $loanData->emailaddress,
							'projectname' => $config->project_name,
							'loanid' => $loanData->unique_id,
						);

		
$subject = Utility::getContents(utf8_decode($getLoanRejectedTemplate->email_subject), "{{ "," }}",$mailData);
$email_content= Utility::getContents(stripcslashes($getLoanRejectedTemplate->email_content),"{{ ", " }}",$mailData);

		$mailData['subject']=$subject;
		$mailData['email_content']=($email_content);

		Mail::send('emails.loanrejected', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['emailaddress'], $mailData['firstname'].' '.$mailData['surname'])->subject($mailData['subject']);
		});
	}
	
	public static function loanclosed($loan_id){
		
		$loanData = Utility::getloan($loan_id);
		$getLoanClosedTemplate= Utility::getLoanTemplate("loan_closed");
		$config = Utility::getconfig();
		
		$subject = 'Comunicación de finalización de deuda con '.$config->project_name;
		$mailData = array(
							'firstname' =>$loanData->firstname,
							'middlename' => $loanData->middlename,
							'surname' => $loanData->surname,
							'emailaddress' => $loanData->emailaddress,
							'projectname' => $config->project_name,
							'loanid' => $loanData->unique_id,
						);

		$subject = Utility::getContents(utf8_decode($getLoanClosedTemplate->email_subject), "{{ "," }}",$mailData);
$email_content= Utility::getContents(stripcslashes($getLoanClosedTemplate->email_content),"{{ ", " }}",$mailData);

		$mailData['subject']=$subject;
		$mailData['email_content']=($email_content);

		
		Mail::send('emails.loanclosed', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['emailaddress'], $mailData['firstname'].' '.$mailData['surname'])->subject($mailData['subject']);
		});
	}
	/*
public static function loanapproved($loan_id){
		
		$loanData = Utility::getloan($loan_id);		
		$config = Utility::getconfig();
        $getBorrowerLoanTemplate= Utility::getLoanTemplate("borrower_loan_approval");
        $getMerchantLoanTemplate= Utility::getLoanTemplate("merchant_loan_approval");

	$firstname = $loanData->firstname;
	$middlename = $loanData->middlename;
	$surname = $loanData->surname;
	$emailaddress = $loanData->emailaddress;
	$loanid = $loanData->unique_id;
	$unique_id = $loanData->unique_id;
	$merchant_name = $loanData->merchant_name;
	$contact_person = $loanData->contact_person;
	$merchant_email = $loanData->merchant_email;
	$borrower_email_content= stripcslashes($getBorrowerLoanTemplate->email_content);
	$merchant_email_content= stripcslashes($getMerchantLoanTemplate->email_content);
	$name = $firstname.' '.$surname;

		$contractual_document = base_path().'/generatedfiles/'.$loanData->contractual_document;
		$mailData = array(
						'name' => $name,			
						'firstname' => $firstname,
						'middlename' => $middlename,
						'surname' => $surname,
						'unique_id' => $unique_id,
						'borrower_email_content' =>html_entity_decode($borrower_email_content),
						'merhcant_email_content' => html_entity_decode($merchant_email_content),
						'contact_person' => $contact_person,
						'emailaddress' => $emailaddress,
						'merchant_email' => $merchant_email,
						'projectname' => $config->project_name,
						'loanid' => $loanid,
						'contractual_document' => $contractual_document
					);

		$subject = $getBorrowerLoanTemplate->email_subject;
		$merchant_subject = $getMerchantLoanTemplate->email_subject;

		$mailData['subject']=$subject;
		$mailData['merchant_subject']=$merchant_subject;
		
		Mail::send('emails.loanapproved', $mailData, function($message) use ($mailData)
		{
			$message->attach($mailData['contractual_document'],['as' => 'Contractual Document']);
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['emailaddress'], $mailData['name'])->subject($mailData['subject']);
		});
		die();
		if(!empty($merchant_name)){
			
			Mail::send('emails.loanapprovedmerchant', $mailData, function($message) use ($mailData)
			{
				$message->from(config('constants.from_email'), $mailData['projectname']);
				$message->to($mailData['merchant_email'], $mailData['contact_person'])->subject($mailData['merchant_subject']);
			});
		}
	}
	*/
	public static function loanapproved($loan_id){
		
		$allinvestors = DB::table('backoffice_lenders')->get();
	
		$loanData = Utility::getloan($loan_id);		
		$config = Utility::getconfig();
        $getBorrowerLoanTemplate= Utility::getLoanTemplate("borrower_loan_approval");
        $getMerchantLoanTemplate= Utility::getLoanTemplate("merchant_loan_approval");
        $getInvestorLoanTemplate= Utility::getLoanTemplate("investor_loan_notification");

		$merchant_name = $loanData->merchant_name;

		$contractual_document = base_path().'/generatedfiles/'.$loanData->contractual_document;

		if(!empty($loanData->dob)){
			$now = time();
			$dob = strtotime($loanData->dob);		 
			$difference = $now - $dob;
			$age = floor($difference / 31556926);
		}else{
			$age = "";
		}

		if($loanData->scoring!=""){
			$scoring=$loanData->scoring;
		}else{
			$scoring="";
		}
		

		$mailData = array('firstname' => $loanData->firstname,
							'middlename' => $loanData->middlename,
							'surname' => $loanData->surname,
							'loanid' => $loanData->unique_id,
							'contact_person' => $loanData->contact_person,
							'merchant_name' => $loanData->merchant_name,
							'borrower_email' => $loanData->emailaddress,
							'merchant_email' => $loanData->merchant_email,
							'borrower_mobile' => $loanData->cellphonenumber,
							'product_name' => $loanData->product_name,
							'projectname' => $config->project_name,
							'contractual_document' => $contractual_document,
							'loan_amount'=>$loanData->loan_amount,
							'loan_terms'=>$loanData->loan_terms,
							'loan_apr'=>$loanData->loan_apr,
							'city'=>$loanData->borrowercity,
							'age'=>$age,
							'employment'=>$loanData->employmenttype,
							'scoring'=>$scoring
						);

		foreach($allinvestors as $investordata){
			$mailData['investor_email']=$investordata->email;
			$mailData['investor_name']=$investordata->lender_name;
			$investor_subject = Utility::getContents(utf8_decode($getInvestorLoanTemplate->email_subject), "{{ "," }}",$mailData);
			$investor_email_content = Utility::getContents(stripcslashes($getInvestorLoanTemplate->email_content), "{{ "," }}",$mailData);
			$mailData['investor_subject']=$investor_subject;
			$mailData['investor_email_content']=$investor_email_content;
			Mail::send('emails.lenderloanapprovenotify', $mailData, function($message) use ($mailData)
			{
				$message->from(config('constants.from_email'), $mailData['projectname']);
				$message->to($mailData['investor_email'], $mailData['investor_name'])->subject($mailData['investor_subject']);
			});

		}

$subject = Utility::getContents(utf8_decode($getBorrowerLoanTemplate->email_subject), "{{ "," }}",$mailData);
$merchant_subject = Utility::getContents(utf8_decode($getMerchantLoanTemplate->email_subject), "{{ "," }}",$mailData);

$borrower_email_content= Utility::getContents($getBorrowerLoanTemplate->email_content,"{{ ", " }}",$mailData);
$merchant_email_content= Utility::getContents($getMerchantLoanTemplate->email_content,"{{ ", " }}",$mailData);

		$mailData['subject']=$subject;
		$mailData['merchant_subject']=$merchant_subject;
		
		$mailData['borrower_email_content']=($borrower_email_content);
		$mailData['merhcant_email_content']=($merchant_email_content);
		
		Mail::send('emails.loanapproved', $mailData, function($message) use ($mailData)
		{
			$message->attach($mailData['contractual_document'],['as' => 'Contractual Document']);
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['borrower_email'], $mailData['firstname'].' '.$mailData['surname'])->subject($mailData['subject']);
		});
		
		if(!empty($merchant_name)){
			
			Mail::send('emails.loanapprovedmerchant', $mailData, function($message) use ($mailData)
			{
				$message->from(config('constants.from_email'), $mailData['projectname']);
				$message->to($mailData['merchant_email'], $mailData['contact_person'])->subject($mailData['merchant_subject']);
			});
		}

		
	}
	
	public static function loanpreapproval($loan_id){
		
		$loanData = Utility::getloan($loan_id);
		
		$config = Utility::getconfig();
		
		$firstname = $loanData->firstname;
		$surname = $loanData->surname;
		$emailaddress = $loanData->emailaddress;
		$loanid = $loanData->unique_id;
		
		$name = $firstname.' '.$surname;
		
		$subject = 'Hemos recibido la solicitud de préstamo (ID: '.$loanid.')';
		
		$pre_contractual_document = base_path().'/generatedfiles/'.$loanData->pre_contractual_document;
		$seccis_document = base_path().'/generatedfiles/'.$loanData->seccis_document;
		
		$mailData = array(
							'name' => $name,
							'emailaddress' => $emailaddress,
							'projectname' => $config->project_name,
							'loanid' => $loanid,
							'subject' => $subject,
							'pre_contractual_document' => $pre_contractual_document,
							'seccis_document' => $seccis_document
						);
		
		Mail::send('emails.loanpreapproval', $mailData, function($message) use ($mailData)
		{
			$message->attach($mailData['pre_contractual_document'],['as' => 'Pre Contractual Document']);
			$message->attach($mailData['seccis_document'],['as' => 'SECCIS Document']);
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['emailaddress'], $mailData['name'])->subject($mailData['subject']);
		});
	}

	public static function borrowerlogindetails($borrowerid,$pwd,$loanid=""){
		$borrowerData = DB::table('backoffice_borrowers')->where('id', $borrowerid)->first();
		$config = Utility::getconfig();
		
		$firstname = $borrowerData->firstname;
		$surname = $borrowerData->surname;
		$emailaddress = $borrowerData->emailaddress;
		
		$name = $firstname.' '.$surname;
		
		$subject = 'Login details';
				
		$mailData = array(
							'name' => $name,
							'emailaddress' => $emailaddress,
							'projectname' => $config->project_name,
							'subject' => $subject,
							'password'=>$pwd,
						);
		if(!empty($loanid))
			$mailData['url']="https://www.smartcredit.es/es/loanremainingdata/".$loanid."/step1";
		else
			$mailData['url']="https://www.smartcredit.es/es/borrower-signin";

		
		Mail::send('emails.borrowerlogindetails', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['emailaddress'], $mailData['name'])->subject($mailData['subject']);
		});
	}
	
	public static function loanapplicationnotifymail($loan_id){
		
		$loanData = Utility::getloan($loan_id);
		$getLoanApplicationNotifyTemplate= Utility::getLoanTemplate("loan_application_notify");
		$config = Utility::getconfig();
		
		//dd($loanData);
		$toemail = $config->company_official_email_address;
		$merchant_name = !empty($loanData->merchant_name) ? $loanData->merchant_name.' (ID: '.$loanData->merchant_cif.')' : 'N/A';
		$product_name = !empty($loanData->product_name) ? $loanData->product_name : 'N/A';
		
		$mailData = array('firstname' => $loanData->firstname,
							'middlename' => $loanData->middlename,
							'surname' => $loanData->surname,
							'borrower_mobile' => $loanData->cellphonenumber,
							'borrower_email' => $loanData->emailaddress,
							'merchant_name' => $merchant_name,
							'product_name' => $product_name,
							'projectname' => $config->project_name,
							'loanid' => $loanData->unique_id,
							'toemail' => $config->company_official_email_address
						);

		$subject = Utility::getContents(utf8_decode($getLoanApplicationNotifyTemplate->email_subject), "{{ "," }}",$mailData);
		$email_content= Utility::getContents(stripcslashes($getLoanApplicationNotifyTemplate->email_content),"{{ ", " }}",$mailData);

		$mailData['subject']=$subject;
		$mailData['email_content']=$email_content;

		/* $view = View::make('emails.loanapplicationnotify',$mailData);		
		echo $view->render();		
		exit; */
		
		Mail::send('emails.loanapplicationnotify', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['toemail'], 'Administrator')->subject($mailData['subject']);
		});
	}
	
	
	public static function merchantemailverifymail($merchantid){
		
		$merchantdata = DB::table('backoffice_merchants')->where('id', $merchantid)->first();
		$getMerchantemailVerifyTemplate= Utility::getLoanTemplate("merchant_email_verification");
		$config = Utility::getconfig();
		
		$mailData = array(
					'projectname' => $config->project_name,
					'email' => $merchantdata->email,
					'merchant_name'=>$merchantdata->merchant_name,
					'contact_person' => $merchantdata->contact_person,
					'merchant_cif' => $merchantdata->merchant_cif,
					'company_name' => $merchantdata->company_name,
					'unique_identifier'=> $merchantdata->unique_identifier
				);

		$subject = Utility::getContents(utf8_decode($getMerchantemailVerifyTemplate->email_subject), "{{ "," }}",$mailData);
		$merchant_email_content= Utility::getContents(stripcslashes($getMerchantemailVerifyTemplate->email_content),"{{ ", " }}",$mailData);

		$mailData['subject']=$subject;
		$mailData['merhcant_email_content']=($merchant_email_content);
		
		Mail::send('emails.merchantemailverification', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['email'], '')->subject($mailData['subject']);
		});
	}
	
	public static function merchantapprovalmail($merchantid){
		
		$merchantdata = DB::table('backoffice_merchants')->where('id', $merchantid)->first();
		$getMerchantApprovalTemplate= Utility::getLoanTemplate("merchant_approval");
		$config = Utility::getconfig();
		
		$mailData = array('merchant_email' => $merchantdata->email,
							'merchant_name' => $merchantdata->merchant_name,
							'projectname' => $config->project_name,
							'unique_identifier'=>$merchantdata->unique_identifier
						);

		$subject = Utility::getContents(utf8_decode($getMerchantApprovalTemplate->email_subject), "{{ "," }}",$mailData);
		$email_content= Utility::getContents(stripcslashes($getMerchantApprovalTemplate->email_content),"{{ ", " }}",$mailData);

		$mailData['subject']=$subject;
		$mailData['email_content']=$email_content;
		
		Mail::send('emails.merchantupdatebankdetailsmail', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['merchant_email'], $mailData['merchant_name'])->subject($mailData['subject']);
		});
	}
	
	public static function merchantforgotpassword($merchantid){
		
		$merchantdata = DB::table('backoffice_merchants')->where('id', $merchantid)->first();
        $getMerchantForgotpasswordTemplate= Utility::getLoanTemplate("merchant_forgotpassword");
		$config = Utility::getconfig();
		
		$mailData = array(
			'projectname' => $config->project_name,
			'email' => $merchantdata->email,
			'merchant_name'=>$merchantdata->merchant_name,
			'contact_person' => $merchantdata->contact_person,
			'merchant_cif' => $merchantdata->merchant_cif,
			'company_name' => $merchantdata->company_name,
			'unique_identifier'=> $merchantdata->unique_identifier
		);

		$subject = Utility::getContents(utf8_decode($getMerchantForgotpasswordTemplate->email_subject), "{{ "," }}",$mailData);
		$merchant_email_content= Utility::getContents(stripcslashes($getMerchantForgotpasswordTemplate->email_content),"{{ ", " }}",$mailData);

		$mailData['subject']=$subject;
		$mailData['merhcant_email_content']=($merchant_email_content);

		Mail::send('emails.merchantforgotpassword', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['email'], '')->subject($mailData['subject']);
		});
	}

	public static function investorforgotpassword($investorid){
		
		$investordata = DB::table('backoffice_lenders')->where('id', $investorid)->first();
		$getInvestorForgotpasswordTemplate= Utility::getLoanTemplate("investor_forgotpassword");
		$config = Utility::getconfig();
		
		$mailData = array('email' => $investordata->email,
						  'unique_identifier' =>$investordata->unique_identifier,
						  'lender_name' => $investordata->lender_name,
						  'nat_id_num' => $investordata->nat_id_num,
						  'occupation' =>$investordata->occupation,
						  'country_of_doc_origin' =>$investordata->country_of_doc_origin,
						  'country_of_residence' => $investordata->country_of_residence,
						  'projectname' => $config->project_name,
						);

		$subject = Utility::getContents(utf8_decode($getInvestorForgotpasswordTemplate->email_subject), "{{ "," }}",$mailData);
		$investor_email_content= Utility::getContents(stripcslashes($getInvestorForgotpasswordTemplate->email_content),"{{ ", " }}",$mailData);

		$mailData['subject']=$subject;
		$mailData['investor_email_content']=($investor_email_content);
		
		Mail::send('emails.investorforgotpassword', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['email'], '')->subject($mailData['subject']);
		});
	}
	
	public static function borrowerforgotpassword($borrowerid){
		
		$borrowerdata = DB::table('backoffice_borrowers')->where('id', $borrowerid)->first();
		$getBorrowerForgotpasswordTemplate= Utility::getLoanTemplate("borrower_forgotpassword");
		$config = Utility::getconfig();
		
		$mailData = array(
							'email' => $borrowerdata->emailaddress,
							'unique_identifier' => $borrowerdata->unique_identifier,
							'username' => $borrowerdata->username,
							'firstname' => $borrowerdata->firstname,
							'middlename' => $borrowerdata->middlename,
							'surname' => $borrowerdata->surname,
							'second_surname' => $borrowerdata->second_surname,
							'projectname' => $config->project_name
						);

		$subject = Utility::getContents(utf8_decode($getBorrowerForgotpasswordTemplate->email_subject), "{{ "," }}",$mailData);
		$borrower_email_content= Utility::getContents(stripcslashes($getBorrowerForgotpasswordTemplate->email_content),"{{ ", " }}",$mailData);

		$mailData['subject']=$subject;
		$mailData['borrower_email_content']=($borrower_email_content);
		
		Mail::send('emails.borrowerforgotpassword', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['email'], '')->subject($mailData['subject']);
		});
	}
	
	public static function defaultcommunicationmail($loan_id,$emi_amount,$statusflag){
		
		$loanData = Utility::getloan($loan_id);
		$getBreachofContract= Utility::getLoanTemplate("breach_of_contract");
		$getdefaultcommunication= Utility::getLoanTemplate("default_communication");
		$getpreviousdayinstallment= Utility::getLoanTemplate("previous_day_installment");
		$config = Utility::getconfig();
		
		$loandate = date('d/m/Y',$loanData->createdate);
		
		$subject = utf8_decode($getdefaultcommunication->email_subject);
		
		$duedays = '';
		$emailtemplate = 'defaultcommunication';
		$content=stripcslashes($getdefaultcommunication->email_content);
		switch($statusflag){
			
			case "-1":
				$duedays = '';
				$subject = utf8_decode($getpreviousdayinstallment->email_subject);
				$emailtemplate = 'previousdayinstallment';
				$content= stripcslashes($getpreviousdayinstallment->email_content);
				break;
			case "+3":
				$duedays = '3';
				break;
			case "+7":
				$duedays = '7';
				break;
			case "+10":
				$duedays = '10';
				break;
			case "+15":
				$duedays = '15';
				break;
			case "+25":
				$duedays = '25';
				break;
			case "+35":
				$duedays = '35';
				break;
			case "+60":
				$subject = 'Comunicación de Reclamación de deuda de más de 35 días';
				$duedays = '60';
				break;
			case "+90":
				$subject = utf8_decode($getBreachofContract->email_subject);
				$duedays = '90';
				$emailtemplate = 'breachofcontact';
				$content= stripcslashes($getBreachofContract->email_content);
				break;
		}
		
		$mailData = array('firstname' => $loanData->firstname,
						  'middlename' => $loanData->middlename,
							'surname' => $loanData->surname,
							'emailaddress' => $loanData->emailaddress,
							'loanid' => $loanData->unique_id,
							'loan_date' => $loandate,
							'loan_terms' => $loanData->loan_terms,
							'loan_amount' => $loanData->loan_amount,
							'loan_apr' => $loanData->loan_apr.'%',
							'emi_amount' => $emi_amount,
							'duedays' => $duedays,
							'projectname' => $config->project_name,
							'company_phone_no' => $config->company_phone_no,
						);

		$subject = Utility::getContents($subject, "{{ "," }}",$mailData);
		$email_content= Utility::getContents($content,"{{ ", " }}",$mailData);

		$mailData['subject']=$subject;
		$mailData['email_content']=$email_content;
		//echo View::make('emails.'.$emailtemplate, $mailData)->render();
		//die();
		
		Mail::send('emails.'.$emailtemplate, $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['emailaddress'], $mailData['firstname'].' '.$mailData['surname'])->subject($mailData['subject']);
		});
	}

	public static function lendersemailverifymail($lenderid){
		
		$investordata = DB::table('backoffice_lenders')->where('id', $lenderid)->first();
		$getLenderemailVerifyTemplate= Utility::getLoanTemplate("lender_email_verification");
		$config = Utility::getconfig();
		
		$mailData = array('email' => $investordata->email,
						  'unique_identifier' =>$investordata->unique_identifier,
						  'lender_name' => $investordata->lender_name,
						  'nat_id_num' => $investordata->nat_id_num,
						  'occupation' =>$investordata->occupation,
						  'country_of_doc_origin' =>$investordata->country_of_doc_origin,
						  'country_of_residence' => $investordata->country_of_residence,
						  'projectname' => $config->project_name,
						);

		$subject = Utility::getContents(utf8_decode($getLenderemailVerifyTemplate->email_subject), "{{ "," }}",$mailData);
		$lender_email_content= Utility::getContents($getLenderemailVerifyTemplate->email_content,"{{ ", " }}",$mailData);

		$mailData['subject']=$subject;
		$mailData['lender_email_content']=($lender_email_content);

		
		/*$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: <".config('constants.from_email').">\r\n";

		mail("neha.pixlr@gmail.com",$mailData['subject'],$lender_email_content,$headers);*/
		
		Mail::send('emails.lenderemailverification', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['email'], '')->subject($mailData['subject']);
		});
	}
	
	public static function lenderapprovalmail($lenderid){
		
		$merchantdata = DB::table('backoffice_lenders')->where('id', $lenderid)->first();
		
		$config = Utility::getconfig();
		
		$lender_email = $merchantdata->email;
		$lender_name = $merchantdata->lender_name;
		$unique_identifier = $merchantdata->unique_identifier;
		
		$url = URL();
		$url = str_replace('/backoffice','',$url);
		
		$subject = 'Su cuenta de comerciante ahora está activa';
		
		$updatebanklink = $url.'/es/updatebankdetails/'.$unique_identifier;
		
		$mailData = array(
						
			'merchant_email' => $merchant_email,
			'merchant_name' => $merchant_name,
			'projectname' => $config->project_name,
			'subject' => $subject,
			'updatebanklink' => $updatebanklink
		);
		
		Mail::send('emails.merchantupdatebankdetailsmail', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['merchant_email'], $mailData['merchant_name'])->subject($mailData['subject']);
		});
	}

	public static function merchantFundedEmailNotify($loanid){
		
		$loanData = Utility::getloan($loanid);		
		$getMerchantemailVerifyTemplate= Utility::getLoanTemplate("merchant_fund_email_notify");
		$config = Utility::getconfig();
	//	print_r($loanData);
		$mailData = array('firstname' => $loanData->firstname,
							'middlename' => $loanData->middlename,
							'surname' => $loanData->surname,
							'loanid' => $loanData->unique_id,
							'contact_person' => $loanData->contact_person,
							'borrower_email' => $loanData->emailaddress,
							'merchant_email' => $loanData->merchant_email,
							'projectname' => $config->project_name,
							'borrower_mobile' => $loanData->cellphonenumber,
							'emailaddress' => $loanData->emailaddress,
							'product_name' => $loanData->product_name,
							'loan_date' => date('d/m/Y',$loanData->createdate),
							'loan_terms' => $loanData->loan_terms,
							'loan_amount' => $loanData->loan_amount,
							'loan_apr' => $loanData->loan_apr,
							'merchant_name' => $loanData->merchant_name
						);

		$subject = Utility::getContents(utf8_decode($getMerchantemailVerifyTemplate->email_subject), "{{ "," }}",$mailData);
$convertedString=$getMerchantemailVerifyTemplate->email_content;
		$merchant_email_content= Utility::getContents(stripcslashes($convertedString),"{{ ", " }}",$mailData);

		$mailData['subject']=$subject;
		$mailData['merhcant_email_content']=($merchant_email_content);
		
		Mail::send('emails.merchantFundedEmailNotify', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['merchant_email'], '')->subject($mailData['subject']);
		});
	}


/*
	public static function lenderapprovalmail($lenderid){
		
		$lenderdata = DB::table('backoffice_lenders')->where('id', $lenderid)->first();
		
		$config = Utility::getconfig();
		
		$lender_email = $lenderdata->email;
		$lender_name = $lenderdata->lender_name;
		$unique_identifier = $lenderdata->unique_identifier;
		
		$url = URL();
		$url = str_replace('/backoffice','',$url);
		
		$subject = 'Su cuenta de invertir ahora está activa';
		
		//$updatebanklink = $url.'/es/updatebankdetails/'.$unique_identifier;
		
		$mailData = array(
						
			'lender_email' => $lender_email,
			'lender_name' => $lender_name,
			'projectname' => $config->project_name,
			'subject' => $subject,
			//'updatebanklink' => $updatebanklink
		);
		
		Mail::send('emails.lenderupdatebankdetailsmail', $mailData, function($message) use ($mailData)
		{
			$message->from(config('constants.from_email'), $mailData['projectname']);
			$message->to($mailData['lender_email'], $mailData['lender_name'])->subject($mailData['subject']);
		});
	}
	*/
}
<?php 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Adminlogin;
use Session;
use Spreadsheet_Excel_Reader;
use Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Mails;
use Utility;
use File;
use Excel;
use Lemonway;

class LenderController extends Controller {

	protected $mode = '';
	
	public function __construct()
	{
		$this->middleware('guest');
		
		if(!Adminlogin::isloggedin()){
			
			return redirect()->route('adminlogin')->send();
			exit;
		}
	}

	public function index(Request $request, $mode = null, $id = null)
	{
/*
		if($id){
			Mails::lendersemailverifymail($id);
			//Mails::merchantapprovalmail($id);
			die();
		}
		
	*/	
		$errors = array();
		
		$type = $request->input('type');
		
		//dd($type);
		
		$config = Utility::getconfig();
		
		if($mode == 'delete'){
			
			DB::table('backoffice_lenders')->where('id', '=', $id)->delete();
			
			return redirect()->route('adminlender', array('mode'=>'','id'=>'','type'=>$type))->with('action','deleted');
		}
		
		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			$email = $request->input('email');
			$password = $request->input('password');
			$lender_name = $request->input('lender_name');
			$mobile_no = $request->input('mobile_no');
			$status = $request->input('status');

			$birth_day 				= $request->input('birth_day');
			$birth_month 			= $request->input('birth_month');
			$birth_year 			= $request->input('birth_year');
			$gender 				= $request->input('gender');
			$nat_id_num 			= $request->input('nat_id_num');
			$country_of_residence	= $request->input('country_of_residence');
			$address 				= $request->input('address');
			$city 					= $request->input('city');
			$postal_code 			= $request->input('postal_code');
			$area_of_activity		= $request->input('area_of_activity');
			$occupation     		= $request->input('occupation');
			$issued_diff_country				= $request->input('issued_diff_country');
			$pep     		= $request->input('pep');
		    $country_of_doc_origin	= $request->input('country_of_doc_origin');
		    $dninie= $request->input('dninie');

    		$birthdate=$birth_day.'/'.$birth_month.'/'.$birth_year;
			$flag = 0;
			
			if(empty($email)){
				
				$errors[] = 'Enter email';
				$flag = 1;
			}
			else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				
				$errors[] = 'Enter proper email address';
				$flag = 0;
			}
			
			if($act == 'doadd'){

				if(empty($password)){
					
					$errors[] = 'Enter password';
					$flag = 1;
				}
			}

			if(!is_numeric($issued_diff_country)){
		
				$errors[] = '* Choose passports';
				$flag = 1;
			}else if(($issued_diff_country==1) && empty($country_of_doc_origin)){
				$errors[] = '* Choose country of document origin';
				$flag = 1;
			}

			if(empty($occupation)){
				
				$errors[] = '* Enter occupation';
				$flag = 1;
			}

			if(!is_numeric($pep)){
				
				$errors[] = '* Choose Politically Exposed Person (PEP)';
				$flag = 1;
			}
			if(empty($dninie)){
				//$errors['type'] = 'dninie';
				$errors[] = '* Select DNI/NIE Type';
				//$errors[] = $errors;
				$flag = 0;
			}else{
				if(empty($nat_id_num)){	
					//$errors['type'] = 'nationalid';
					$errors[] = '* Enter '.ucfirst($dninie).' number';
					//$errors[] = $errors;
					$flag = 1;
				}else{
					if($dninie=="dni"){
						$regex = '/^[0-9]{8}[A-Z]$/';
						preg_match_all($regex, $nat_id_num, $matches, PREG_SET_ORDER, 0);		
						if(!count($matches)){			
							//$errors['type'] = 'nationalid';
							$errors[] = '* '.ucfirst($dninie).' number must be of 8 Digits and 1 Capital Letter ';
							//$errors[] = $errors;
							$flag = 1;
						}
					}else if($dninie=="nie"){
						$regex = '/^[A-Z][0-8]{7}[A-Z]$/';
						preg_match_all($regex,$nat_id_num, $matches, PREG_SET_ORDER, 0);		
						if(!count($matches)){			
							//$errors['type'] = 'nationalid';
							$errors[] = '* '.ucfirst($dninie).' number must be of 1 Capital Letter , 7 Digits and 1 Capital Letter';
							//$errors[] = $errors;
							$flag = 1;
						}
					}
				}
			}	
			/*if(empty($nationalid)){
				
				$errors[] = '* Enter national id number';
				$flag = 1;
			}*/

			if(empty($gender)){
				
				$errors[] = '* Choose gender';
				$flag = 1;
			}

			if(empty($birth_day)){
				
				$errors[] = '* Enter birth day';
				$flag = 1;
			}

			if(!is_numeric($birth_month)){
				
				$errors[] = '* Enter birth month';
				$flag = 1;
			}
			if(!is_numeric($birth_year)){
				
				$errors[] = '* Enter birth year';
				$flag = 1;
			}


			if(empty($area_of_activity)){
				
				$errors[] = '* Select area of activity';
				$flag = 1;
			}

			if(empty($country_of_residence)){
				
				$errors[] = '* Select country of residence';
				$flag = 1;
			}

			if(empty($postal_code)){
				
				$errors[] = '* Enter postal code';
				$flag = 1;
			}

			if(empty($city)){
				
				$errors[] = '* Enter city';
				$flag = 1;
			}

			if(empty($address)){
				
				$errors[] = '* Enter address';
				$flag = 1;
			}
			
			if(empty($lender_name)){
				
				$errors[] = 'Enter lender name';
				$flag = 1;
			}
			
			if(empty($mobile_no)){
				
				$errors[] = 'Enter mobile no';
				$flag = 1;
			}
			else if(!is_numeric($mobile_no)){
				
				$errors[] = 'Mobile no must be numeric';
				$flag = 1;
			}
			else if(strlen($mobile_no) != $config->mobile_length){
				
				$errors[] = 'Mobile no must be of '.$config->mobile_length.' digits';
				$flag = 1;
			}

			if(!$request->hasFile('investor_identity') && empty($request->input('proofVal'))){
					
				$errors[] = 'Attach Lenders ID Proof';
				$flag = 1;
			}
			$fileName="";
			if($flag == 0 && $request->hasFile('investor_identity')){
				$origFileName = $request->file('investor_identity')->getClientOriginalName();
				$fileext = File::extension($origFileName);
				
				$destinationPath = 'investor_proof/';
				$fileName = time().".".$fileext;

                $request->file('investor_identity')->move($destinationPath,$fileName);
			}
			
			if($act == 'doadd' && $flag == 0){
				$checkEmail=DB::table('backoffice_lenders')
					->where('email',  $email)->get();
				if(!empty($checkEmail)){
					$request->session()->flash('errorMsg', 'Email already exist!');
					return redirect()->route('adminlender',array('id'=>$id, 'mode'=>'add', 'type'=>$type))->with('action','error');
				}else{

					$investorWalletid = uniqid("PHP-INVESTOR-");
					$response =Lemonway::RegisterWallet(array(
												"wlLogin"   => config('constants.LOGIN'),
                                                "wlPass"    => config('constants.PASSWORD'),
                                                "language"  => config('constants.LANGUAGE'),
                                                "version"   => config('constants.VERSION'),
                                                "walletIp"  => Lemonway::getUserIP(),
                                                "walletUa"  => config('constants.UA'),
												"wallet" 			=> $investorWalletid,
												"clientMail" 		=> $email,
												"clientFirstName" 	=> $lender_name,
												"clientLastName" 	=> "Investor",
												'payerOrBeneficiary'=>'1',
												'ctry'=>$country_of_residence,
												'birthdate'=>$birthdate,
												'isCompany'=>'0',
												'nationality'=>$country_of_residence,
										));
					if(isset($response->RegisterWalletResult->E)){
							if($response->RegisterWalletResult->E->Code==204){
			                    $GetWalletbyemailDetails= Lemonway::GetWalletbyemailDetails($emailaddress);
			                    if(!empty($GetWalletbyemailDetails->GetWalletDetailsResult->WALLET->ID)){
			                    	$investorWalletid=$GetWalletbyemailDetails->GetWalletDetailsResult->WALLET->ID;
			                    	$wallet_balance=$GetWalletbyemailDetails->GetWalletDetailsResult->WALLET->BAL;
			                    }
							}else{
								$errors[] =$response->RegisterWalletResult->E->Msg;
								$flag = 0;
							}						
					}else{
						$investorWalletid=	$response->RegisterWalletResult->WALLET->ID;
						$wallet_balance=0.00;
						$checkStatus=Lemonway::UpdateWalletStatus($investorWalletid,6);
						if(isset($checkStatus->UpdateWalletStatusResult->E)){
							$errors[] = "There is some error";
							$flag = 0;
						}
					}
					if($investorWalletid){
						$time = time();
						$uniqueid = md5(uniqid(rand(), true));
						
						DB::table('backoffice_lenders')->insert(
							[
								'email' => $email, 
								'password' => md5($password), 
								'lender_name' => $lender_name, 
								'mobile_no' => $mobile_no,
								'investor_id'=>$fileName,
								'dob' => $birthdate,
								'wallet_id'=>$investorWalletid,
								'address' => $address, 
								'city' => $city, 
								'postal_code' => $postal_code,
								'area_of_activity'=>$area_of_activity,
								'country_of_residence' => $country_of_residence, 
								'pep' =>$pep, 
								'gender' => $gender, 
								'dninie'=>$dninie,
								'nat_id_num' => $nat_id_num,
								'occupation'=>$occupation,
								'issued_diff_country' => $issued_diff_country, 
								'country_of_doc_origin'=>$country_of_doc_origin,
								'step2' =>1, 
								'step3' =>1, 
								'createdate' => time(),
								'status' => 'pending',
								'unique_identifier' => $uniqueid
							]
						);
						return redirect()->route('adminlender',array('mode'=>'','id'=>'','type'=>$type))->with('action','added');
					}
				}
				
				
				
			}
			
			if($act == 'doedit' && $flag == 0){
				
				$id = $request->input('id');
				
				$checkEmail=DB::table('backoffice_lenders')
					->where('email',  $email)
					->whereNotIn('id', [$id])->get();
				if(!$checkEmail->isEmpty()){
					$request->session()->flash('errorMsg', 'Email already exist!');
					return redirect()->route('adminlender',array('id'=>$id, 'mode'=>'edit', 'type'=>$type))->with('action','error');
				}else{
					
					$updateArr=array('email' => $email, 
									 'lender_name' => $lender_name, 
									 'mobile_no' => $mobile_no,'dob' => $birthdate, 
									'address' => $address, 
									'city' => $city, 
									'postal_code' => $postal_code,
									'area_of_activity'=>$area_of_activity,
									'country_of_residence' => $country_of_residence, 
									'pep' =>$pep, 
									'gender' => $gender, 
									'nat_id_num' => $nat_id_num,
									'occupation'=>$occupation,
									'issued_diff_country' => $issued_diff_country, 
									'country_of_doc_origin'=>$country_of_doc_origin);

					if($fileName!="")
						$updateArr['investor_id']=$fileName;
					DB::table('backoffice_lenders')
						->where('id', $id)
						->update($updateArr);
				}
				
				if(!empty($password)){
					
					DB::table('backoffice_lenders')
					->where('id', $id)
					->update(
						[
							'password' => md5($password)
						]
					);
				}
				
				if(!empty($status)){
					
					DB::table('backoffice_lenders')
					->where('id', $id)
					->update(
						[
							'status' => $status
						]
					);
				}
				//echo $status;die();
				if($status == 'approved'){
					
					//Mails::lenderapprovalmail($id);
				}
				
				return redirect()->route('adminlender',array('mode'=>'','id'=>'','type'=>$type))->with('action','updated');
			}
			
			if($act == 'delsel'){
				
				$ids = $request->input('chk_id');
				
				//echo '<pre>'; print_r($ids); exit;
				
				if(count($ids)){
					
					foreach($ids as $valid){
						
						DB::table('backoffice_lenders')->where('id', '=', $valid)->delete();
					}
				}
				
				return redirect()->route('adminlender',array('mode'=>'','id'=>'','type'=>$type))->with('action','deleted');
			}
			
			$data['recorddetails'] = (object) $request->all();
		}
		
		if($mode == 'edit'){
			
			$recorddetails = DB::table('backoffice_lenders')
							 ->where('id', $id)
							 ->first();

			$data['recorddetails'] = $recorddetails;
		}

		$activity_type = DB::table('dropdown_values')
			            ->leftJoin('dropdown_values_translations', 'dropdown_values_translations.value_id', '=', 'dropdown_values.id')
			            ->select('dropdown_values_translations.value', 'dropdown_values.id')
			            ->where('dropdown_values.type', 'area_activity_type')
			            ->where('dropdown_values.flag', '1')
			            ->where('dropdown_values_translations.language_id', '1')
			            ->get();

		$records = DB::table('backoffice_lenders AS BM')
				   ->where(array("status"=>$type,"email_verified"=>'1'))
				   ->orderBy('id', 'desc')
				   ->get();
		
		//echo '<pre>'; print_r($records); exit; 
		
		//Get current page form url e.g. &page=6
			
		if($request->has('page')){
			$currentPage = LengthAwarePaginator::resolveCurrentPage();
		}
		else{
			$currentPage = 1;
		}

		//Create a new Laravel collection from the array data
		$collection = new Collection($records);

		//Define how many items we want to be visible in each page
		$per_page = 50;

		//Slice the collection to get the items to display in current page
		$currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
		
		//echo '<pre>'; print_r($currentPageResults); exit;

		//Create our paginator and add it to the data array
		$data['records'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);

		//Set base url for pagination links to follow e.g custom/url?page=6
		$data['records']->setPath($request->url());
		
		$statusArr = array(
			
			'approved' => 'Approve',
			'pending' => 'Pending'
		);
		
		$variables = Utility::variables();
		$countriesData = DB::table('countries')
							 ->get();

					 
		for($i=(date('Y')-150); date('Y') >= $i;$i++){
		     $yearArr[]=$i;						
		}

		$months = array(
				 "01"=>   'January',
				 "02"=>   'February',
				 "03"=>  'March',
				 "04"=>  'April',
				 "05"=>   'May',
				 "06"=>  'June',
				 "07"=>  'July ',
				 "08"=>  'August',
				 "09"=>  'September',
				 "10"=>  'October',
				 "11"=>  'November',
				 "12"=>  'December',
				);

		 for($i=1; 31 >= $i;$i++){
			$monthdates[]=$i;
						};

		$data['loggedinadminid'] = Session::get('adminid');				
        $data['activity_type'] = $activity_type;
		$data['monthdates'] = $monthdates;
		$data['monthlist'] = $months;	
		$data['yearlist'] = $yearArr;										 
		$data['countriesData'] = $countriesData;
		$data['mode'] = $mode;
		$data['per_page'] = $per_page;
		$data['currentPage'] = $currentPage;
		$data['errors'] = $errors;
		$data['type'] = $type;
		$data['id'] = $id;
		$data['statusarr'] = $statusArr;
		$data['variables'] = $variables;
		$data['totcount'] = count($records);
		$data['sectionname'] = 'Lenders';
		$data['pagetitle'] = ucfirst($mode).' Lenders - '.config('constants.project_name');
		$data['pagedescription'] = ucfirst($mode).' Lenders - '.config('constants.project_name');
		
		return view('admin.lender',$data);
	}


	public function lendercashin(Request $request){

		$records = DB::table('backoffice_lenders_payments')
			            ->leftJoin('backoffice_lenders', 'backoffice_lenders.id', '=', 'backoffice_lenders_payments.lender_id')
			            ->leftJoin('backoffice_loan_applications', 'backoffice_loan_applications.id', '=', 'backoffice_lenders_payments.loan_id')
			            ->where('backoffice_lenders_payments.payment_mode',"deposit")
			            ->select('*')
			            ->get();

		if($request->has('page')){
			$currentPage = LengthAwarePaginator::resolveCurrentPage();
		}
		else{
			$currentPage = 1;
		}

		//Create a new Laravel collection from the array data
		$collection = new Collection($records);

		//Define how many items we want to be visible in each page
		$per_page = 10;

		//Slice the collection to get the items to display in current page
		$currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
		
		//echo '<pre>'; print_r($currentPageResults); exit;

		//Create our paginator and add it to the data array
		$data['records'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);

		//Set base url for pagination links to follow e.g custom/url?page=6
		$data['records']->setPath($request->url());
         // echo "yes";
		$data['per_page'] = $per_page;
		$data['totcount'] = count($records);
		$data['currentPage'] = $currentPage;
        $data['sectionname'] = 'Lenders - Cash In';
		$data['pagetitle'] = ' Cash In';
		$data['pagedescription'] = ' Lenders - '.config('constants.project_name');
        return view('admin.lendercashin',$data);
	}

	public function lendercashout(Request $request){
          $records = DB::table('backoffice_lenders_payments')
			            ->leftJoin('backoffice_lenders', 'backoffice_lenders.id', '=', 'backoffice_lenders_payments.lender_id')
			            ->leftJoin('backoffice_loan_applications', 'backoffice_loan_applications.id', '=', 'backoffice_lenders_payments.loan_id')
			            ->where('backoffice_lenders_payments.payment_mode',"withdrawal")
			            ->select('*')
			            ->get();

		if($request->has('page')){
			$currentPage = LengthAwarePaginator::resolveCurrentPage();
		}
		else{
			$currentPage = 1;
		}

		//Create a new Laravel collection from the array data
		$collection = new Collection($records);

		//Define how many items we want to be visible in each page
		$per_page = 10;

		//Slice the collection to get the items to display in current page
		$currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
		
		//echo '<pre>'; print_r($currentPageResults); exit;

		//Create our paginator and add it to the data array
		$data['records'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);

		//Set base url for pagination links to follow e.g custom/url?page=6
		$data['records']->setPath($request->url());
         // echo "yes";
		$data['totcount'] = count($records);
		$data['per_page'] = $per_page;
		$data['currentPage'] = $currentPage;
        $data['sectionname'] = 'Lenders - Cash Out';
		$data['pagetitle'] = ' Cash Out';
		$data['pagedescription'] = ' Lenders - '.config('constants.project_name');
          return view('admin.lendercashout',$data);
	}

	public function lenderaccounting(Request $request){

		$records = DB::table('backoffice_investores_bid as BIB')
			            ->Join('backoffice_lenders as BL', 'BL.id', '=', 'BIB.investor_id')
			            ->Join('backoffice_loan_applications as BLA', 'BLA.id', '=', 'BIB.loan_id')
			            ->select('*')
			            ->orderBy('BIB.id', 'desc')
			            ->get();

		if($request->has('page')){
			$currentPage = LengthAwarePaginator::resolveCurrentPage();
		}
		else{
			$currentPage = 1;
		}

		//Create a new Laravel collection from the array data
		$collection = new Collection($records);

		//Define how many items we want to be visible in each page
		$per_page = 10;

		//Slice the collection to get the items to display in current page
		$currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
		
		//echo '<pre>'; print_r($currentPageResults); exit;

		//Create our paginator and add it to the data array
		$data['records'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);

		//Set base url for pagination links to follow e.g custom/url?page=6
		$data['records']->setPath($request->url());
         // echo "yes";
		$data['totcount'] = count($records);
		$data['per_page'] = $per_page;
		$data['currentPage'] = $currentPage;
        $data['sectionname'] = 'Investor Accounting';
		$data['pagetitle'] = 'Investor Accounting';
		$data['pagedescription'] = ' Investor Accounting - '.config('constants.project_name');
          return view('admin.lendoraccounting',$data);

	}

    public function downloadExcel2($type)
    {
	  // $selecttsring="BL.wallet_id","BLA.unique_id","BL.lender_name","BIB.investment_date","BIB.bid_amount","BLA.status";
	    $data = DB::table('backoffice_investores_bid as BIB')
			            ->Join('backoffice_lenders as BL', 'BL.id', '=', 'BIB.investor_id')
			            ->Join('backoffice_loan_applications as BLA', 'BLA.id', '=', 'BIB.loan_id')
			            ->select("BL.wallet_id","BLA.unique_id","BL.lender_name","BIB.investment_date","BIB.bid_amount","BLA.status")
			            ->orderBy('BIB.id', 'desc')
			            ->get();
		$data = collect($data)->map(function($x){ return (array) $x; })->toArray();	            

	     Excel::create('investorsaccounting', function($excel) use ($data) {
	     $excel->sheet('mySheet', function($sheet) use ($data)
	             {
	     $sheet->fromArray($data);
	             });
	     })->download($type);
	     
	    return redirect()->action('LenderController@lenderaccounting');
    }

    public function investoradmininvestment(Request $request){

    	if($request->has('act')){

    		$loan_bid_amount=$request->input('loan_bid_amount');
    		$investorid=$request->input('investorid');
    		$loan_id=$request->input('loan_id');
    		$remaining_amount=$request->input('remaining_amount');

    		$flag = 0;
    		if(!empty($loan_bid_amount) && $loan_bid_amount > $remaining_amount){				
				$errors[] = "Only €".$remaining_amount." is missing";
				$flag = 1;
			}

    		if(empty($loan_bid_amount)){				
				$errors[] = '* Select Bid amount';
				$flag = 1;
			}

			if(empty($loan_id)){				
				$errors[] = '* Loan id not available';
				$flag = 1;
			}

			if(empty($remaining_amount)){				
				$errors[] = '* remaining amount not found.';
				$flag = 1;
			}

			if(empty($investorid)){				
				$errors[] = '* Select investor name';
				$flag = 1;
			}

			if($flag==0){
				$loandetails = DB::table('backoffice_loan_applications as a')
								->join('backoffice_borrowers as b', 'a.borrower_id', '=', 'b.id')
								->join('backoffice_merchants as c', 'a.merchant_id', '=', 'c.id')
					            ->select("*",'b.wallet_id as wallet_id','c.wallet_id as merchant_wallet','c.iban_id as merchnatibanid')
					            ->where('a.id',$loan_id)
					            ->first(); 

				$investordetails = DB::table('backoffice_lenders')
						            ->select("*")
						            ->where('id',$investorid)
						            ->first();

			    $investorwalletid=$investordetails->wallet_id;     
			    $merchantwalletid=$loandetails->merchant_wallet;     
			    $receiverwalletid=  $loandetails->wallet_id; 
			    $receivername=$loandetails->firstname." ".$loandetails->surname; 
			    $merchnatibanid=$loandetails->merchnatibanid;
			    $cardid=$loandetails->cardid;
				$GetInvestorWalletDetails = Lemonway::GetWalletDetails($investordetails->wallet_id);
				$paymentresponse="";
				if(isset($GetInvestorWalletDetails->GetWalletDetailsResult->E)){
					$errors[]=$GetInvestorWalletDetails->GetWalletDetailsResult->E->Msg;
				}else{
					$wallet_balance=$GetInvestorWalletDetails->GetWalletDetailsResult->WALLET->BAL;
					if($loan_bid_amount < $wallet_balance){				
						$paymentresponse=	Lemonway::SendPayment($investorwalletid,$receiverwalletid, sprintf('%0.2f', $loan_bid_amount),$investordetails->lender_name,$receivername);
		
					}else{
						$paymentresponse1=Lemonway::MoneyInWithCardId(array(
						                                    "wlLogin"   => config('constants.LOGIN'),
			                                                "wlPass"    => config('constants.PASSWORD'),
			                                                "language"  => config('constants.LANGUAGE'),
			                                                "version"   => config('constants.VERSION'),
						                                    "walletIp"  => Lemonway::getUserIP(),
						                                    "walletUa"  => config('constants.UA'),
						                                    "wallet"    => $investorwalletid,
						                                    "cardId"=>$investordetails->card_id,
						                                    "amountTot"  =>sprintf('%0.2f',$loan_bid_amount),
						                                    "autoCommission"=>0
						                                ));
						if(isset($paymentresponse1->MoneyInResult->E)){
							$errors[]=$paymentresponse1->MoneyInResult->E->Msg;
						}else{
							$paymentresponse=	Lemonway::SendPayment($investorwalletid,$receiverwalletid, sprintf('%0.2f', $loan_bid_amount),$investordetails->lender_name,$receivername);
						}
						
					}
				}

					if(!empty($paymentresponse)){

						if(isset($paymentresponse->SendPaymentResult->E)){
							$errors[]=$paymentresponse->SendPaymentResult->E->Msg;
						}else{
							$GetInvestorWalletDetails = Lemonway::GetWalletDetails($investorwalletid);
						
							if(isset($GetInvestorWalletDetails->GetWalletDetailsResult->E)){
								$errors[]=$GetInvestorWalletDetails->GetWalletDetailsResult->E->Msg;

							}else{

								$wallet_balance=$GetInvestorWalletDetails->GetWalletDetailsResult->WALLET->BAL;
								/**** update investor wallet *****/
								DB::table('backoffice_lenders')
										->where('id', $investorid)
										->update(
											[
												'wallet_balance' => $wallet_balance
											]
										);
								/**** update investor wallet *****/
								
								/**** add borrower wallet amounts for loans *****/							
								DB::table('backoffice_borrowers_wallet')
										->insert(
											[
												'borrower_id' => $loandetails->borrower_id,
												'lender_id' => $investorid,
												'bid_amount' => sprintf('%0.2f', $loan_bid_amount),
												'loan_id' => $loan_id
											]
										);

								/**** add borrower wallet amounts for loans *****/

								$GetBorrowerWalletDetails = Lemonway::GetWalletDetails($receiverwalletid);
								if(isset($GetBorrowerWalletDetails->GetWalletDetailsResult->E)){
									$errors[]=$GetBorrowerWalletDetails->GetWalletDetailsResult->E->Msg;

								}else{
									$receiver_balance=$GetBorrowerWalletDetails->GetWalletDetailsResult->WALLET->BAL;
									/**** update borrower wallet *****/
									DB::table('backoffice_borrowers')
										->where('id', $loandetails->borrower_id)
										->update(
											[
												'wallet_balance' => $receiver_balance
											]
										);
									/**** update borrower wallet *****/

									/**** add login investor bid for loan *****/							
									DB::table('backoffice_investores_bid')
											->insert(
												[
													'investor_id' => $investorid,
													'bid_amount' => sprintf('%0.2f', $loan_bid_amount),
													'loan_id' => $loan_id
												]
											);	

									/**** add login investor bid for loan *****/

									/**** add login investor bid for loan *****/							
									DB::table('backoffice_lenders_payments')
											->insert(
												[
													'lender_id' => $investorid,
													'loan_id' => $loan_id,
													'amount' => sprintf('%0.2f', $loan_bid_amount),
													'payment_type' => "loan_bid",
													'payment_mode' =>"withdrawal"
												]
											);
									/**** add login investor bid for loan *****/
								}		
							}
						}
						/****** check loan covered or not ********/
						$getLoanCoveredAmount = DB::table('backoffice_investores_bid')
										            ->select("*",DB::raw('sum(bid_amount) as covered'))
										            ->where('loan_id',$loan_id)
										            ->first();

						if($getLoanCoveredAmount->covered==$loandetails->loan_amount){

							/***** forward mail to doctor when loan 100% covered *****/
								
			$senttomerchant=Lemonway::SendPayment($receiverwalletid,$merchantwalletid,sprintf('%0.2f', $loandetails->loan_amount),$receivername,$loandetails->merchant_name);
			if(isset($senttomerchant->SendPaymentResult->E)){
				$errors[]=$senttomerchant->SendPaymentResult->E->Msg;
			}else{
				$MoneyOut=	Lemonway::MoneyOut($merchantwalletid,sprintf('%0.2f', $loandetails->loan_amount),$merchnatibanid);

				if(isset($MoneyOut->MoneyOutResult->E->Msg)){
					$errors[]=$MoneyOut->MoneyOutResult->E->Msg;
				}else{
					$borrower_wallet_balance=0;
					$GetborrowerWalletDetails = Lemonway::GetWalletDetails($receiverwalletid);						
					if(isset($GetborrowerWalletDetails->GetWalletDetailsResult->E)){
						$errors[]=$GetborrowerWalletDetails->GetWalletDetailsResult->E->Msg;
					}else{
						$borrower_wallet_balance=$GetborrowerWalletDetails->GetWalletDetailsResult->WALLET->BAL;
						/**** update borrower wallet *****/
						DB::table('backoffice_borrowers')
							->where('id', $loandetails->borrower_id)
							->update(
								[
									'wallet_balance' => $borrower_wallet_balance
								]
							);
						/**** update borrower wallet *****/
						
						$GetmerchantWalletDetails = Lemonway::GetWalletDetails($merchantwalletid);						
						if(isset($GetmerchantWalletDetails->GetWalletDetailsResult->E)){
							$errors[]=$GetmerchantWalletDetails->GetWalletDetailsResult->E->Msg;
						}else{
							$wallet_balance=$GetmerchantWalletDetails->GetWalletDetailsResult->WALLET->BAL;
							/**** update borrower wallet *****/
							DB::table('backoffice_merchants')
								->where('id', $loandetails->merchant_id)
								->update(
									[
										'wallet_balance' => $wallet_balance
									]
								);
							/**** update borrower wallet *****/
								DB::table('backoffice_merchants_wallet')
									->insert(
										[
											'merchant_id' => $loandetails->merchant_id,
											'borrower_id' =>$loandetails->borrower_id,
											'loan_id' => $loan_id,
											'lender_id' => $investorid,
											'bid_amount' => sprintf('%0.2f', $loandetails->loan_amount)
										]
									);
								
							}

							/**** update loan status  *****/
								$rowupdated=DB::table('backoffice_loan_applications')
										->where('id', $loan_id)
										->update(
											[
												'status' => "covered"
											]
										);
								/**** update borrower  *****/

								/****** Create Emis ******/
								$p = intval($loandetails->loan_amount);
								$j = ($loandetails->loan_apr)/(12*100);
								$n = $loandetails->loan_terms;					
								$m = ($p*$j)/(1-pow((1+$j),-$n));					
								$m = round($m,2);					
								$emis = array();

								$currentMonth = date('m');
								$currentYear = date('Y');
								
								$nextMonth = $currentMonth == 12 ? 1 : $currentMonth+1;
								$nextYear = $currentMonth == 12 ? $currentYear+1 : $currentYear;
								
								$firstEmiDate = '1-'.$nextMonth.'-'.$nextYear;
								$timestampfirstemidate = strtotime($firstEmiDate);
								for($i=0;$i<$n;$i++){						
									$time = strtotime("+$i month", $timestampfirstemidate);
									$emis[] = array(							
														'amount' => $m,
														'date' => date('d-m-Y',$time),
														'day' => date('d',$time),
														'month' => date('m',$time),
														'year' => date('Y',$time)
													);
								}

								if(count($emis)){
									$emi_count=1;
									foreach($emis as $emi){
										DB::table('backoffice_loan_payments')
												->insert(
													[
														'loan_id' => $loan_id,
														'emi_amount' =>$emi['amount'],
														'emi_day' => $emi['day'],
														'emi_month' => $emi['month'],
														'emi_year' => $emi['year'],
														'emi_order' => $emi_count,
														'emi_timestamp' =>strtotime($emi['date'])
													]
												);
										$emi_count++;
									}

									$getinvestorpayments = DB::table('backoffice_loan_applications as a')
													->join('backoffice_investores_bid as b', 'b.loan_id', '=', 'a.id')
										            ->select("*",DB::raw('sum(bid_amount) as totalbid'))
										            ->where('b.loan_id',$loan_id)
										            ->groupBy('b.investor_id')
										            ->get();

									foreach ($getinvestorpayments as $getinvestorpaymentsrows){
										$inp = intval($getinvestorpaymentsrows->totalbid);
										$inj = (7)/(12*100);
										$in = $getinvestorpaymentsrows->loan_terms;					
										$inm = ($inp*$inj)/(1-pow((1+$inj),-$in));
										$inm = round($inm,2);					
										$inemis = array();
										
										$currentMonth = date('m');
										$currentYear = date('Y');
										
										$nextMonth = $currentMonth == 12 ? 1 : $currentMonth+1;
										$nextYear = $currentMonth == 12 ? $currentYear+1 : $currentYear;
										
										$firstEmiDate = '1-'.$nextMonth.'-'.$nextYear;
										$timestampfirstemidate = strtotime($firstEmiDate);
										
										for($i=1;$i<=$in;$i++){	

										     DB::table('backoffice_investor_installment')
												->insert(
													[
														'loan_id'=>$loan_id,
														'lender_id'=>$getinvestorpaymentsrows->investor_id,
														'installment_amount'=>$inm,
														'installment_order'=>$i
													]
												);					
										}
									}
								}
						/***** forward mail to doctor when loan 100% covered *****/
								if($rowupdated && !empty($loandetails->merchant_id)){
									   $request =Mails::merchantFundedEmailNotify($loan_id);
								}

						/****** Get intial fee from borrower *******/
						$get_initial_fee=DB::table('config')
								->where('config_type', 'initial_fee')
								->select("*")
								->first();
						$initial_fee=$get_initial_fee->config_val;
						

						if(!empty($cardid) && !empty($initial_fee)){	
							if($borrower_wallet_balance < $initial_fee){
								$initial_fee=($initial_fee)-($borrower_wallet_balance);
								$MoneyInWithCardId=	Lemonway::MoneyInWithCardId(array(
							                                    "wlLogin"   => config('constants.LOGIN'),
				                                                "wlPass"    => config('constants.PASSWORD'),
				                                                "language"  => config('constants.LANGUAGE'),
				                                                "version"   => config('constants.VERSION'),
				                                                "walletIp"  => Lemonway::getUserIP(),
				                                                "walletUa"  => config('constants.UA'),
							                                    "wallet"    => $receiverwalletid,
							                                    "cardId"=>$cardid,
							                                    "amountTot"  =>sprintf('%0.2f',$initial_fee),
							                                    "autoCommission"=>0
							                                ));
								if(isset($MoneyInWithCardId->MoneyInResult->E)){
										$errors[]=$MoneyInWithCardId->MoneyInResult->E->Msg;								
								}else{
									$SendPaymentSmartcredit=Lemonway::SendPayment($receiverwalletid,"Smartcredit-5bb36e62c9b1f",sprintf('%0.2f', $initial_fee),$receivername,"Smartcredit");
									if(isset($SendPaymentSmartcredit->SendPaymentResult->E)){
										$errors[]=$SendPaymentSmartcredit->SendPaymentResult->E->Msg;
									}else{
										DB::table('backoffice_borrowers')
												->where('id', $loandetails->borrower_id)
												->update(
													[
														'wallet_balance' => $remaining_amount
													]
												);
									}
								}
							}else if($borrower_wallet_balance > $initial_fee){
								$remaining_amount=($borrower_wallet_balance)-($initial_fee);
								$SendPaymentSmartcredit=Lemonway::SendPayment($receiverwalletid,"Smartcredit-5bb36e62c9b1f",sprintf('%0.2f', $initial_fee),$receivername,"Smartcredit");
									if(isset($SendPaymentSmartcredit->SendPaymentResult->E)){
										$errors[]=$SendPaymentSmartcredit->SendPaymentResult->E->Msg;
									}else{
										DB::table('backoffice_borrowers')
												->where('id', $loandetails->borrower_id)
												->update(
													[
														'wallet_balance' => $remaining_amount
													]
												);
									}
								}
						}	
						
					}

				}			/****** Create Emis ******/

								
								

			}
						}				            
						/****** check loan covered or not ********/
						
					}
			}
			if(!empty($errors)){
			   echo json_encode(array("status"=>0,'errors'=>$errors));
			   exit();
			   //return redirect('investoradmininvestment')->with('errors',$errors);
			}
			else{
				//$request->session()->flash('successMsg', 'Amount invested successfully.');
			//	return redirect('investoradmininvestment')->with('errors',$errors);;
				echo json_encode(array("status"=>1,'redirecturl'=>'https://www.smartcredit.es/backoffice/investoradmininvestment'));
				exit();
				//return redirect('investoradmininvestment');
			}
    	}else{
    		
    		$records = DB::table('backoffice_loan_applications as a')
		            ->leftJoin('backoffice_borrowers as b', 'a.borrower_id', '=', 'b.id')
		            ->leftJoin('backoffice_investores_bid as c', 'c.loan_id', '=', 'a.id')
		            ->select("a.*",DB::raw('count(distinct(smc_c.investor_id)) as total_investor'),'b.firstname','b.surname',DB::raw('sum(smc_c.bid_amount) as total_bid'))
		            ->whereIn('a.status',array('approved','covered'))
		            ->groupBy('a.id')
		            ->orderBy('a.id','desc')
		            ->get();
		            
			$investorlist = DB::table('backoffice_lenders')
				            ->select("*")
				            ->where('card_id',"!=","")
				            ->where('invest_automatically',1)
				            ->orderBy('id', 'desc')
				            ->get();
			if(!empty($request->has('page'))){
				$currentPage = LengthAwarePaginator::resolveCurrentPage();
			}else{
				$currentPage = 1;
			}

			$collection = new Collection($records);
			$per_page = 10;
			$currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
			
			$data['records'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);
			$data['records']->setPath($request->url());
			$data['loggedinadminid'] = Session::get('adminid');
			$data['totcount'] = count($records);
			$data['per_page'] = $per_page;
			$data['currentPage'] = $currentPage;
			$data['investorlist']=$investorlist;
	        $data['sectionname'] = 'Investor Automatic Investment';
			$data['pagetitle'] = 'Investor Automatic Investment';
			$data['pagedescription'] = ' Investor Automatic Investment - '.config('constants.project_name');
	        return view('admin.automaticinvestment',$data);
    	}
    	  	
    }

     public function loaninvestors(Request $request,$loanid){
     	if(!empty($loanid) && is_numeric($loanid)){
     		//sum(distinct o.ShippingCost) as TotalShipping
     		//DB::enableQueryLog();
     			$records = DB::table('backoffice_loan_applications as a')		            
				            ->join('backoffice_investores_bid as b', 'b.loan_id', '=', 'a.id')
				            ->join('backoffice_lenders as c', 'c.id', '=', 'b.investor_id')
				            ->select("*")
				            ->where('b.loan_id',$loanid)
				            ->orderBy('c.id','desc')
				            ->get();
				if(count($records)==0){
					return redirect('investoradmininvestment');
				}       

				$totalinvestors = DB::table('backoffice_investores_bid')		            
						            ->select(DB::raw("count(distinct investor_id) as totalinvestors"),DB::raw("SUM(bid_amount) as totalbidamount"))
						            ->where('loan_id',$loanid)
						            ->first();
				                        
				           // $laQuery = DB::getQueryLog();
				            //print_r($laQuery);
		        $unique_id=$records[0]->unique_id;  
		        $loan_amount=$records[0]->loan_amount;  
		        if(!empty($request->has('page'))){
					$currentPage = LengthAwarePaginator::resolveCurrentPage();
				}else{
					$currentPage = 1;
				}

				$collection = new Collection($records);
				$per_page = 10;
				$currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
				
				$data['records'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);
				$data['records']->setPath($request->url()); 
				$data['totcount'] = count($records);
				$data['per_page'] = $per_page;
				$data['currentPage'] = $currentPage;
				$data['loanid'] = $loanid;
				$data['loan_amount'] = 'Loan amount - €'.$loan_amount;
				$data['total_investors'] = 'Total Investors - '.$totalinvestors->totalinvestors;
				$data['total_funded_amount'] = 'Total Funded Amount - €'.$totalinvestors->totalbidamount;
				$data['sectionname'] = $unique_id.' - Investors List';
				$data['pagetitle'] = $unique_id.' Investors List';
				$data['pagedescription'] = $unique_id.' Investors List - '.config('constants.project_name');
		        return view('admin.loaninvestorlist',$data);   
     	}

     }
}
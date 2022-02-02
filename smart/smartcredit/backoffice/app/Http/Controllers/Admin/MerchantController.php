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
use Lemonway;

class MerchantController extends Controller {

	protected $mode = '';
	
	public function __construct()
	{
		$this->middleware('guest');
		
		if(!Adminlogin::isloggedin()){
			
			return redirect()->route('adminlogin')->send();
			exit;
		}
	}

	public function bankagregator(Request $request,$mode= null){
		$records = DB::table('backoffice_loan_applications AS LA')
				   ->leftJoin('backoffice_borrowers AS BO', 'BO.id', '=', 'LA.borrower_id')
				   ->leftJoin('backoffice_merchants AS BM', 'BM.id', '=', 'LA.merchant_id')
				   ->leftJoin('bank_list AS BL', 'BL.id', '=', 'LA.bank_id')
				   ->select('LA.*','BO.firstname','BO.surname','BM.merchant_name','BM.merchant_cif','BO.merchantnamecontactorwebsite as merchant_info','BL.bank_name')
				   //->where('LA.status','=',$type)
				   ->whereRaw("smc_LA.bank_id != ''")
				   ->orderBy('LA.id', 'desc')
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
		

		$data['mode'] = $mode;
		$data['per_page'] = $per_page;
		$data['currentPage'] = $currentPage;
		$data['totcount'] = count($records);
		$data['sectionname'] = 'Bank agregator';
		$data['pagetitle'] = 'Bank agregator';
		$data['pagedescription'] = 'Bank agregator';
		
		return view('admin.bankassignloan',$data);

	}

	public function index(Request $request, $mode = null, $id = null)
	{
		/*
		if($id){
			Mails::merchantemailverifymail($id);
			//Mails::merchantapprovalmail($id);
			die();
		}
		*/
		// print_r(Lemonway::checkEmail("priyanka.pixlrit@gmail.com"));
		$errors = array();
		
		$type = $request->input('type');
		
		//dd($type);
		
		$config = Utility::getconfig();
		
		if($mode == 'delete'){
			
			DB::table('backoffice_merchants')->where('id', '=', $id)->delete();
			
			return redirect()->route('adminmerchant', array('mode'=>'','id'=>'','type'=>$type))->with('action','deleted');
		}


		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			$email = $request->input('email');
			$password = $request->input('password');
			$merchant_name = $request->input('merchant_name');
			$merchant_surname = $request->input('merchant_surname');			
			$contact_person = $request->input('contact_person');
			$company_name = $request->input('company_name');
			$company_email = $request->input('company_email');
			$company_phone = $request->input('company_phone');
			$company_address = $request->input('company_address');
			$shop_address = $request->input('shop_address');
			$shop_phone = $request->input('shop_phone');
			$mobile_no = $request->input('mobile_no');
			$merchant_cif = $request->input('merchant_cif');
			$dninie= $request->input('dninie');
			$merchant_nie = $request->input('merchant_nie');
			$sector = $request->input('sector');
			//$bank_name = $request->input('bank_name');
			$iban_number = $request->input('iban_number');
			$status = $request->input('status');
			$url = $request->input('url');
			$address = $request->input('address');
			$merchant_nie=$request->input('merchant_nie');
			$collegiate_number=$request->input('collegiate_number');
			$iban_holder=$request->input('account_holder');
			$street_bank_branch=$request->input('street_bank_branch');
			$bank_branch=$request->input('bank_branch');
			$self_employed=$request->input('self_employed');
			$country_of_residence=$request->input('country_of_residence');
			$dob=$request->input('dob');


			$flag = 0;
			if($act == 'doadd'){	
				if(empty($email)){
					
					$errors[] = 'Enter email';
					$flag = 1;
				}
				else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					
					$errors[] = 'Enter proper email address';
					$flag = 1;
				}else{
					
					$checkemailRow = Lemonway::checkEmail($email);
					if(($checkemailRow) > 0){
						$errors[] = '* Email address is already registered';
						$flag = 1;
				}
				}
			}
			if($act == 'doadd'){

				if(empty($password)){
					
					$errors[] = 'Enter password';
					$flag = 1;
				}
			}
			
			if(empty($merchant_name)){
				
				$errors[] = 'Enter merchant first name';
				$flag = 1;
			}

			if(empty($country_of_residence)){
				
				$errors[] = 'Enter country of residence';
				$flag = 1;
			}

			if(empty($dob)){
				
				$errors[] = 'Enter ddate of birth';
				$flag = 1;
			}

			if(empty($merchant_surname)){
				
				$errors[] = 'Enter merchant surname';
				$flag = 1;
			}
			
			if(empty($contact_person)){
				
				$errors[] = 'Enter contact person';
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

			if(empty($self_employed)){		
				$errors[] = '* Select Are you self employed?';
				$flag = 1;
			}else{
				if($self_employed=="no"){
						if(empty($merchant_cif)){		
							$errors[] = 'Enter merchant CIF/ID';
							$flag = 1;
						}else{		
							$regex = '/^[A-Z][0-9]{8}$/';
							preg_match_all($regex, $merchant_cif, $matches, PREG_SET_ORDER, 0);
							
							if(!count($matches)){
								$errors[] = '* Merchant CIF/ID number must be of 1 Capital Letter and 8 Digits';
								$flag = 1;
							}
						}

						
							if(!empty($merchant_nie)){
								if(empty($dninie)){
									$errors[] = '* Select merchant DNI/NIE type Or leave this field empty';
									$flag = 1;
								}else{
									if(!empty($dninie) && $dninie=="dni"){
										$regex = '/^[0-9]{8}[A-Z]$/';
										preg_match_all($regex, $merchant_nie, $matches, PREG_SET_ORDER, 0);		
										if(!count($matches)){			
											$errors[] = '* Merchant '.ucfirst($dninie).' number must be of 8 Digits and 1 Capital Letter ';
											$flag = 1;
										}
									}else if(!empty($dninie) && $dninie=="nie"){
										$regex = '/^[A-Z][0-8]{7}[A-Z]$/';
										preg_match_all($regex, $merchant_nie, $matches, PREG_SET_ORDER, 0);		
										if(!count($matches)){			
											$errors[] = '* Merchant '.ucfirst($dninie).' number must be of 1 Capital Letter , 7 Digits and 1 Capital Letter';
											$flag = 1;
										}
									}
								}
							}
							if(!empty($dninie)){
								if(empty($merchant_nie)){
									$errors[] = '* Select merchant DNI/NIE type Or leave this field empty';
									$flag = 1;
								}
							}

				}else if($self_employed=="yes"){
						if(empty($dninie)){
							$errors[] = '* Select merchant DNI/NIE';
							$flag = 1;
						}else{	
						    if($dninie=="dni"){
								$regex = '/^[0-9]{8}[A-Z]$/';
								preg_match_all($regex, $merchant_nie, $matches, PREG_SET_ORDER, 0);		
								if(!count($matches)){			
									$errors[] = '* Merchant '.ucfirst($dninie).' number must be of 8 Digits and 1 Capital Letter ';
									$flag = 1;
								}
							}else if($dninie=="nie"){
								$regex = '/^[A-Z][0-8]{7}[A-Z]$/';
								preg_match_all($regex, $merchant_nie, $matches, PREG_SET_ORDER, 0);		
								if(!count($matches)){			
									$errors[] = '* Merchant '.ucfirst($dninie).' number must be of 1 Capital Letter , 7 Digits and 1 Capital Letter';
									$flag = 1;
								}
							}			
							
						}

						if(empty($collegiate_number)){				
							$errors[] = 'Enter Collegiate number';
							$flag = 1;
						}else if(!is_numeric($collegiate_number)){		
							$errors[] = '* Collegiate number must be digits';
							$flag = 1;
						}
							
							

				}
			}

			if(empty($sector)){				
				$errors[] = 'Enter merchant sector';
				$flag = 1;
			}

			

			if(empty($address)){				
				$errors[] = 'Enter merchant address';
				$flag = 1;
			}

		/*

			if(empty($iban_holder)){				
				$errors[] = 'Enter account holder';
				$flag = 1;
			}

			if(empty($street_bank_branch)){				
				$errors[] = 'Enter street bank branch';
				$flag = 1;
			}

			if(empty($bank_branch)){				
				$errors[] = 'Enter bank branch name';
				$flag = 1;
			}

			if(empty($iban_number)){				
				$errors[] = 'Enter Bank Account Number';
				$flag = 1;
			}
			*/


			
			if(!empty($iban_number)){
		
				$regex = '/^[A-Z]{2}[0-9]{22}$/';

				preg_match_all($regex, $iban_number, $matches, PREG_SET_ORDER, 0);
				
				if(!count($matches)){
					
					$errors[] = 'Bank account no must be of 2 Capital Letters and 22 Digits';
					$flag = 1;
				}else if(!Lemonway::checkIBAN($iban_number)){
				
					$errors['type'] = 'iban_number';
					$errors['msg'] = '* Enter correct Bank account no';
					$errorsFinal[] = $errors;
					$flag = 0;
				}
			}
			
			
			if($act == 'doadd' && $flag == 0){

				/***** Create Merchant Wallet ********/
						$ibanid="";
						$merchantWalletid="";
						$bankaccountval="";
						$merchantWallet = uniqid("PHP-Merchant-");
						$response = Lemonway::RegisterWallet(array(
															"wlLogin"   => config('constants.LOGIN'),
			                                                "wlPass"    => config('constants.PASSWORD'),
			                                                "language"  => config('constants.LANGUAGE'),
			                                                "version"   => config('constants.VERSION'),
			                                                "walletIp"  => Lemonway::getUserIP(),
			                                                "walletUa"  => config('constants.UA'),
															"wallet" 			=> $merchantWallet,
															"clientMail" 		=> $email,
															"clientFirstName" 	=> $merchant_name,
															"clientLastName" 	=> $merchant_surname,
															'payerOrBeneficiary'=>'1',
															'ctry'=>$country_of_residence,
															'birthdate'=>$dob,
															'isCompany'=>'0',
															'nationality'=>$country_of_residence,
													));
						if(isset($response->RegisterWalletResult->E)){
							if($response->RegisterWalletResult->E->Code==204){
				                    $GetWalletbyemailDetails= Lemonway::GetWalletbyemailDetails($email);
				                    if(!empty($GetWalletbyemailDetails->GetWalletDetailsResult->WALLET->ID)){
				                    	$merchantWalletid=$GetWalletbyemailDetails->GetWalletDetailsResult->WALLET->ID;
				                    	$wallet_balance=$GetWalletbyemailDetails->GetWalletDetailsResult->WALLET->BAL;
				                    }

								}else{
									$errors[] =$response->RegisterWalletResult->E->Msg;
									$flag = 1;
								}
								
						}else{
							$merchantWalletid=	$response->RegisterWalletResult->WALLET->ID;
							$checkStatus=Lemonway::UpdateWalletStatus($merchantWalletid,6);
							if(isset($checkStatus->UpdateWalletStatusResult->E)){
								$errors[] =$checkStatus->UpdateWalletStatusResult->E->Msg;
								$flag = 1;
							}
						}
						/***** Create Merchant Wallet ********/

						if(!empty($merchantWalletid)){
							if(!empty($iban_number)){
							$RegisteredIBAN=Lemonway::RegisterIBAN($merchantWalletid,$iban_number,$iban_holder,$bank_branch,$street_bank_branch);
								if(isset($RegisteredIBAN->RegisterIBANResult->E->Msg)){
									$errors[] =$RegisteredIBAN->RegisterIBANResult->E->Msg;
									$flag = 1;
									
								}else{
									$ibanid=$RegisteredIBAN->RegisterIBANResult->IBAN->ID;
								}
							}
						}

						if($flag==0){
								$time = time();
								$uniqueid = md5(uniqid(rand(), true));
								if(!empty($iban_number))
									$bankaccountval= substr($iban_number, -20);	
								$lastid=DB::table('backoffice_merchants')->insertGetId(
									[
										'email' => $email, 
										'password' => md5($password),
										'iban_number' => $iban_number, 
										'iban_id'=>$ibanid,
										'account_holder'=> $iban_holder,
										'merchant_name' => $merchant_name, 
										'merchant_surname'=>$merchant_surname,
										'collegiate_number'=>$collegiate_number,
										'contact_person' => $contact_person,
										'company_name' => $company_name,
										'company_email' => $company_email,
										'company_phone' => $company_phone,
										'company_address' => $company_address,
										'shop_address' => $shop_address,
										'shop_phone' => $shop_phone,
										'mobile_no' => $mobile_no,
										'self_employed'=>$self_employed,
										'merchant_cif' => $merchant_cif,
										'merchant_nie' => $merchant_nie,
										'dninie'=>$dninie,
										'sector' => $sector,
										'country_of_residence'=>$country_of_residence,
										'dob'=>$dob,
										'bank_account_no' => $bankaccountval,
										'street_bank_branch'=>$street_bank_branch,
										'bank_branch'=>$bank_branch,
										'url' => $url,
										'address' => $address,
										'createdate' => time(),
										'status' => 'pending',
										'unique_identifier' => $uniqueid
									]
								);
								Mails::merchantemailverifymail($lastid);
							}
				return redirect()->route('adminmerchant',array('mode'=>'','id'=>'','type'=>$type))->with('action','added');
			}
			
			if($act == 'doedit' && $flag == 0){

				/***** Create Merchant Wallet ********/
				$ibanid="";
						$merchantWalletid="";
						$bankaccountval="";
				$merchantWallet = uniqid("PHP-Merchant-");
				$response = Lemonway::RegisterWallet(array(
													"wlLogin"   => config('constants.LOGIN'),
	                                                "wlPass"    => config('constants.PASSWORD'),
	                                                "language"  => config('constants.LANGUAGE'),
	                                                "version"   => config('constants.VERSION'),
	                                                "walletIp"  => Lemonway::getUserIP(),
	                                                "walletUa"  => config('constants.UA'),
													"wallet" 			=> $merchantWallet,
													"clientMail" 		=> $email,
													"clientFirstName" 	=> $merchant_name,
													"clientLastName" 	=> $merchant_surname,
													'payerOrBeneficiary'=>'1',
													//'ctry'=>$getuserdetals['country_of_residence'],
													'birthdate'=>$getuserdetals['dob'],
													'isCompany'=>'0',
													//'nationality'=>$getuserdetals['country_of_residence']
											));
				if(isset($response->RegisterWalletResult->E)){
					if($response->RegisterWalletResult->E->Code==204){
		                    $GetWalletbyemailDetails= Lemonway::GetWalletbyemailDetails($email);
		                    if(!empty($GetWalletbyemailDetails->GetWalletDetailsResult->WALLET->ID)){
		                    	$merchantWalletid=$GetWalletbyemailDetails->GetWalletDetailsResult->WALLET->ID;
		                    	$wallet_balance=$GetWalletbyemailDetails->GetWalletDetailsResult->WALLET->BAL;
		                    }

						}else{
							$errors[] =$response->RegisterWalletResult->E->Msg;
							$flag = 1;
						}
						
				}else{
					$merchantWalletid=	$response->RegisterWalletResult->WALLET->ID;
					$checkStatus=Lemonway::UpdateWalletStatus($merchantWalletid,6);
					if(isset($checkStatus->UpdateWalletStatusResult->E)){
						$errors[] =$checkStatus->UpdateWalletStatusResult->E->Msg;
						$flag = 1;
					}
				}
				/***** Create Merchant Wallet ********/
				if(!empty($merchantWalletid)){
					if(!empty($iban_number)){
							$RegisteredIBAN=Lemonway::RegisterIBAN($merchantWalletid,$iban_number,$iban_holder,$bank_branch,$street_bank_branch);
								if(isset($RegisteredIBAN->RegisterIBANResult->E->Msg)){
									$errors[] =$RegisteredIBAN->RegisterIBANResult->E->Msg;
									$flag = 1;
									
								}else{
									$ibanid=$RegisteredIBAN->RegisterIBANResult->IBAN->ID;
								}
							}
						}

						if($flag == 0){

								$id = $request->input('id');
							    $bankaccountval= substr($iban_number, -20);	
								DB::table('backoffice_merchants')
									->where('id', $id)
									->update(
									[
										'iban_number' => $iban_number, 
										'iban_id'=>$ibanid,
										'account_holder'=> $iban_holder,
										'merchant_name' => $merchant_name, 
										'merchant_surname'=>$merchant_surname,
										'merchant_name' => $merchant_name, 
										'contact_person' => $contact_person,
										'company_name' => $company_name,
										'company_email' => $company_email,
										'company_phone' => $company_phone,
										'company_address' => $company_address,
										'shop_address' => $shop_address,
										'shop_phone' => $shop_phone,
										'mobile_no' => $mobile_no,
										'self_employed'=>$self_employed,
										'merchant_cif' => $merchant_cif,
										'dninie'=>$dninie,
										'merchant_nie' => $merchant_nie,
										'country_of_residence'=>$country_of_residence,
										'dob'=>$dob,
										'sector' => $sector,
										'bank_account_no' => $bankaccountval,
										'street_bank_branch'=>$street_bank_branch,
										'bank_branch'=>$bank_branch,
										'url' => $url,
										'address' => $address
									]
								);
						}
				if(!empty($password)){
					
					DB::table('backoffice_merchants')
					->where('id', $id)
					->update(
						[
							'password' => md5($password)
						]
					);
				}
				
				if(!empty($status)){
					
					DB::table('backoffice_merchants')
					->where('id', $id)
					->update(
						[
							'status' => $status
						]
					);
				}
				
				if($status == 'approved'){
					
					Mails::merchantapprovalmail($id);
				}
				
				return redirect()->route('adminmerchant',array('mode'=>'','id'=>'','type'=>$type))->with('action','updated');
			}
			
			if($act == 'delsel'){
				
				$ids = $request->input('chk_id');
				
				//echo '<pre>'; print_r($ids); exit;
				
				if(count($ids)){
					
					foreach($ids as $valid){
						
						DB::table('backoffice_merchants')->where('id', '=', $valid)->delete();
					}
				}
				
				return redirect()->route('adminmerchant',array('mode'=>'','id'=>'','type'=>$type))->with('action','deleted');
			}
			
			$data['recorddetails'] = (object) $request->all();
		}
		
		if($mode == 'edit'){
			
			$recorddetails = DB::table('backoffice_merchants')
							 ->where('id', $id)
							 ->first();
					 
			//dd($recorddetails);
			
			$data['recorddetails'] = $recorddetails;
		}
		
		
$records = DB::table('backoffice_merchants AS BM')
		   ->leftJoin('dropdown_values AS DV','DV.id','=','BM.sector')
		   ->leftJoin('backoffice_loan_applications AS LA','LA.merchant_id','=','BM.id')		   
		   ->select('BM.*','DV.value AS sector',
			DB::raw("count(smc_LA.merchant_id) as total_sales"),
			DB::raw('sum(CASE WHEN `smc_LA`.status="approved" THEN 1 ELSE 0 END) as total_approved_sales'))
		   ->where("BM.status","=",$type)
		   ->where("BM.email_verified","=",'1')
		   ->orderBy('BM.id', 'desc')
		   ->groupBy('BM.id')
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
			'pending' => 'Pending',
		);
		
		$variables = Utility::variables();
		$countriesData = DB::table('countries')
							 ->get();
		
		$data['loggedinadminid'] = Session::get('adminid');
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
		$data['sectionname'] = 'Merchants';
		$data['pagetitle'] = ucfirst($mode).' Merchants - '.config('constants.project_name');
		$data['pagedescription'] = ucfirst($mode).' Merchants - '.config('constants.project_name');
		
		return view('admin.merchant',$data);
	}
	
	public function processedloans(Request $request, $id)
	{
		
		$records = DB::table('backoffice_loan_applications AS LA')
				   ->leftJoin('backoffice_borrowers AS BO', 'BO.id', '=', 'LA.borrower_id')
				   ->leftJoin('backoffice_merchants AS BM', 'BM.id', '=', 'LA.merchant_id')
				   ->select('LA.*','BO.firstname','BO.surname','BM.merchant_name','BM.merchant_cif','BO.merchantnamecontactorwebsite as merchant_info')
				   //->where('LA.status','=',$type)
				   ->where('LA.merchant_id',$id)
				   ->orderBy('LA.id', 'desc')
				   ->get();
				   
		$getmerchant = DB::table('backoffice_merchants')->where('id',$id)->first();
		
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
		
		$merchant_name = $getmerchant->merchant_name;
		$merchant_cif = $getmerchant->merchant_cif;
		$merchant_status = $getmerchant->status;
		
		$data['per_page'] = $per_page;
		$data['currentPage'] = $currentPage;
		$data['merchant_status'] = $merchant_status;
		$data['id'] = $id;
		$data['totcount'] = count($records);
		$data['sectionname'] = 'Loan Applications of "'. $merchant_name . ' [CIF: '.$merchant_cif.']"';
		$data['pagetitle'] = 'Loan Applications of "'. $merchant_name . ' [CIF: '.$merchant_cif.']'.'" - '.config('constants.project_name');
		$data['pagedescription'] = 'Loan Applications of "'. $merchant_name . ' [CIF: '.$merchant_cif.']'.'" - '.config('constants.project_name');
		
		return view('admin.merchantprocessedloans',$data);
	}


	public function merchanttransaction(Request $request,$id){
		$records = DB::table('backoffice_merchants AS LA')
				   ->select('LA.*')
				   ->where('LA.id',$id)
				   ->first();
		if(!empty($records->wallet_id)){		   
			$GetWalletTransHistory= Lemonway::GetWalletTransHistory($records->wallet_id);
			if(isset($GetWalletTransHistory->GetWalletTransHistoryResult->TRANS)){
				if(!empty($GetWalletTransHistory->GetWalletTransHistoryResult->E->Msg))
					$data['errors'] =$GetWalletTransHistory->GetWalletTransHistoryResult->E->Msg;
				else
					$data['errors'] ="Data not found.";

				$data['totcount'] = 0;
				$data['records']= [];
			}else{
				//$result1=$GetWalletTransHistory->GetWalletTransHistoryResult->TRANS->HPAY;
				if(!empty($GetWalletTransHistory->GetWalletTransHistoryResult->TRANS->HPAY)){
					$result[]=$GetWalletTransHistory->GetWalletTransHistoryResult->TRANS->HPAY;
				}else
				    $result=array();

					if($request->has('page')){
						$currentPage = LengthAwarePaginator::resolveCurrentPage();
					}
					else{
						$currentPage = 1;
					}

					//Create a new Laravel collection from the array data
					$collection = new Collection($result);

					//Define how many items we want to be visible in each page
					$per_page = 50;

					//Slice the collection to get the items to display in current page
					$currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
					
					//Create our paginator and add it to the data array
					$data['records'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);

					//Set base url for pagination links to follow e.g custom/url?page=6
						$data['records']->setPath($request->url());
						$data['per_page'] = $per_page;
						$data['currentPage'] = $currentPage;
						$data['totcount'] = count($result);
			}
		}else{
			$data['totcount'] = 0;
			$data['records']= [];
			$data['errors'] = "Wallet id not available.";
		}
		
		$merchant_name = $records->merchant_name;
		$merchant_cif = $records->merchant_cif;
		$merchant_status = $records->status;
		
		
		$data['merchant_status'] = $merchant_status;
		$data['id'] = $id;
		
		$data['sectionname'] = 'Transactions of "'. $merchant_name . ' [CIF: '.$merchant_cif.']"';
		$data['pagetitle'] = 'Transactions of "'. $merchant_name . ' [CIF: '.$merchant_cif.']'.'" - '.config('constants.project_name');
		$data['pagedescription'] = 'Transactions of "'. $merchant_name . ' [CIF: '.$merchant_cif.']'.'" - '.config('constants.project_name');
		return view('admin.merchanttransactions',$data);
	}
}

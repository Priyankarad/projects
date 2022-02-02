<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Mail;
use Response;
use Login;
use Session;
use URL;
use View;

class AjaxController extends Controller {

	public function __construct()
	{
		
	}

	public function dologin(Request $request)
	{	
		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			$email = $request->input('email');
			$password = $request->input('password');
			
			if($act == 'dologin'){
				
				// Check Exists
				
				$checklogin = Login::checklogin($email,$password);
							 
				if(!empty($checklogin)){
					
					$userDetails = Login::loggedinuserdetails($checklogin->id);
					
					$userActive = $userDetails->active;
					
					if($userActive == 'No'){
						
						$response = ['status' => 'notactive'];
					}
					else{
						
						Session::put('userid', $checklogin->id);
						
						$name = $userDetails->firstname.(!empty($userDetails->lastname) ? ' '.$userDetails->lastname : '');
					
						$response = ['id' => $checklogin->id, 'name' => $name, 'status' => 'success'];
					}
				}
				else{
					
					$response = ['status' => 'notexists'];
				}
				
				return response()->json($response);
			}
		}
	}
	
	public function doregister(Request $request)
	{	
		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			$firstname = $request->input('firstname');
			$lastname = $request->input('lastname');
			$email = $request->input('email');
			$password = $request->input('password');
			
			$response = array();
			
			if($act == 'doregister'){
				
				// Check Exists
				
				$checkexists = DB::table('user')
							 ->where('email', $email)
							 ->first();
							 
				if(empty($checkexists)){
					
					// Insert Into Table
				
					$lastid = DB::table('user')->insertGetId(
						[
							'firstname' => $firstname, 
							'lastname' => $lastname, 
							'email' => $email,
							'password' => $password,
							'createdate' => time()
						]
					);
					
					// Send Welcome Mail
					
					$emailverifylink = URL::route('emailverify', array('id'=>base64_encode($lastid)));
					
					$name = $firstname.(!empty($lastname) ? ' '.$lastname : '');
					
					$mailData = array(
						
						'name' => $name,
						'projectname' => config('constants.project_name'),
						'emailverifylink' => $emailverifylink,
						'email' => $email,
						'password' => 'Your chosen Password'
					);
					
					Mail::send('emails.afterregistration', $mailData, function($message) use ($mailData)
					{
						$message->from(config('constants.from_email'), config('constants.project_name'));
						$message->to($mailData['email'], $mailData['name'])->subject('Welcome to '.config('constants.project_name').'!');
					});
					
					$response = ['name' => $name, 'status' => 'success'];
				}
				else{
					
					$response = ['status' => 'exists'];
				}
				
				return response()->json($response);
			}
		}
	}
	
	public function fetchnearbylatlng(Request $request)
	{	
		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			$id = $request->input('id');
			
			if($act == 'dofetch'){
				
				$fetchData = DB::table('property')
							->select('*')
							->where('id', $id)
							->first();
							
				if(!empty($fetchData)){
					
					$lat = $fetchData->lat;
					$lng = $fetchData->lng;
					
					$fetchOtherData = DB::table('property')
										->select(DB::raw('*, ( 3959 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin(radians(lat)) ) ) AS distance'))
										//->where('Status','Sold')
										->having('distance', '<', 1)
										->having('lat', '<>', $lat)
										->having('lng', '<>', $lng)
										->groupBy('lat','lng')
										->orderBy('distance','asc')
										->get();
								
					//echo '<pre>'; print_r($fetchOtherData); exit;
								
					$latlngarr = array();
					
					$propLinks = [];
					
					if(count($fetchOtherData)){
						
						foreach($fetchOtherData as $vdata){
							
							$latlngarr[] = [ 'lat' => $vdata->lat, 'lng' => $vdata->lng ];
							
							$propLinks[$vdata->id] = URL::route('details',[ 'id' => $vdata->id ]);
						}
					}
					
					$propLinks[$fetchData->id] = URL::route('details',[ 'id' => $fetchData->id ]);
					
					$response = ['status' => 'success', 'latlngarr' => $latlngarr, 'totaldata' => $fetchOtherData, 'maindata' => $fetchData, 'proplinks' => $propLinks];
				}
				else{
					
					$response = ['status' => 'failed'];
				}
				
				return response()->json($response);
			}
		}
	}
	
	public function loadproperty(Request $request){
		
		$limit = 10;
		
		if($request->has('act')){
			
			$act = $request->input('act');
			
			if($act == 'loadmore'){
				
				$start = $request->input('start');
				$beds = $request->input('beds');
				$baths = $request->input('baths');
				$maxprice = $request->input('maxprice');
				$minprice = $request->input('minprice');
				$maxarea = $request->input('maxarea');
				$minarea = $request->input('minarea');
				
				$maxspsqft = $request->input('maxspsqft');
				$minspsqft = $request->input('minspsqft');
				$maxsqftheated = $request->input('maxsqftheated');
				$minsqftheated = $request->input('minsqftheated');
				$maxcdom = $request->input('maxcdom');
				$mincdom = $request->input('mincdom');
				$maxlotsizesqft = $request->input('maxlotsizesqft');
				$minlotsizesqft = $request->input('minlotsizesqft');
				$closingdate = $request->input('closingdate');
				$daystoclose = $request->input('daystoclose');
				$spclsaleprov = $request->input('spclsaleprov');
				$pool = $request->input('pool');
				$yearbuilt = $request->input('yearbuilt');
				
				$minyearbuilt = $request->input('minyearbuilt');
				$maxyearbuilt = $request->input('maxyearbuilt');
				
				$statustext = $request->input('status');
				$radius = $request->input('radius');
				$addlat = $request->input('addlat');
				$addlng = $request->input('addlng');
				$propertychosen = $request->input('propertychosen');
				$mode = !empty($request->input('mode')) ? $request->input('mode') : '';
				$addid = $request->input('addid');
				
				$maindata = DB::table('property');
				
				$secondHighestSpSqft = '0';
				$centerDataSqftheated = '0';
				
				if($propertychosen == 'true'){
					
					$maindata->select(DB::raw('*, ( 3959 * acos( cos( radians('.$addlat.') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('.$addlng.') ) + sin( radians('.$addlat.') ) * sin(radians(lat)) ) ) AS distance'))->having('distance', '<', $radius);
					
					if($mode == ''){
					
						$maindata->whereNotIn('id', [$addid]);
						
						$getCenterData = DB::table('property')
										 ->where("id", $addid)
										 ->get();
										 
						if(!empty($getCenterData)){
							
							$centerDataSqftheated = $getCenterData[0]->Sq_Ft_Heated;
						}
					}
				}
				
				if($beds != ''){
					
					$maindata->where("Beds", $beds);
				}
				if($baths != ''){
					
					$maindata->where("Total_Baths", $baths);
				}
				
				if($closingdate != ''){
					
					$maindata->where("Close_Date", $closingdate);
				}
				if($daystoclose != ''){
					
					$maindata->where("Days_To_Closed", $daystoclose);
				}
				if($spclsaleprov != ''){
					
					$maindata->where("Special_Sale_Provision", $spclsaleprov);
				}
				if($pool != ''){
					
					$maindata->where("Pool", "LIKE", "%".$pool."%");
				}
				if($yearbuilt != ''){
					
					$maindata->where("Year_Built", $yearbuilt);
				}
				if($minyearbuilt != '' && $maxyearbuilt != ''){
					
					$maindata->whereBetween("Year_Built", [ $minyearbuilt, $maxyearbuilt ]);
				}
				
				if($statustext != ''){
					
					$maindata->where("Status", $statustext);
				}
				if($maxprice != '' && $minprice != ''){
					
					$maindata->whereBetween("List_Price", [ $minprice, $maxprice ]);
				}
				if($maxarea != '' && $minarea != ''){
					
					$maindata->whereBetween("Sq_Ft_Total", [ $minarea, $maxarea ]);
				}
				
				if($maxspsqft != '' && $minspsqft != ''){
					
					$maindata->whereBetween("Sp_Sq_Ft", [ $minspsqft, $maxspsqft ]);
				}
				if($maxsqftheated != '' && $minsqftheated != ''){
					
					$maindata->whereBetween("Sq_Ft_Heated", [ $minsqftheated, $maxsqftheated ]);
				}
				if($maxcdom != '' && $mincdom != ''){
					
					$maindata->whereBetween("Cdom", [ $mincdom, $maxcdom ]);
				}
				if($maxlotsizesqft != '' && $minlotsizesqft != ''){
					
					$maindata->whereBetween("Lot_Size_Sq_Ft", [ $minlotsizesqft, $maxlotsizesqft ]);
				}
				
				$maindata->where("lat", "<>", 'null');
				$maindata->where("lng", "<>", 'null');
				//$maindata->groupBy('lat','lng');
				
				$dbdatacount = $maindata->get();
				
				if($propertychosen == 'true' && $mode == ''){
					
					$dbdatacount = array_merge($getCenterData, $dbdatacount);
				}			
				
				$latlngarr = [];
				$propLinks = [];
				
				$totcount = count($dbdatacount);
				
				if($totcount > 0){
					
					foreach($dbdatacount as $vald){
						
						$latlngarr[] = [
							'lat' => $vald->lat,
							'lng' => $vald->lng
						];
						
						$propLinks[$vald->id] = URL::route('details',[ 'id' => $vald->id ]);
					}
				}
				
				if($propertychosen == 'true' && $start == 0 && $mode == ''){

					$getsecondHighestspsqft = $maindata->orderBy('Sp_Sq_Ft', 'desc')->skip(1)->take(1)->first();
					
					//print_r($getsecondHighestspsqft); exit;
						
					if(!empty($getsecondHighestspsqft)){
						
						$secondHighestSpSqft = $getsecondHighestspsqft->Sp_Sq_Ft or 0;
					}
				}
				
				$dbdata = $maindata->skip($start)->take($limit)->get();	

				if($propertychosen == 'true' && $start == 0 && $mode == ''){
					
					$dbdata = array_merge($getCenterData, $dbdata);
				}
				
				if($propertychosen == 'true' && $start == 0 && $mode == ''){
					
					$remaining = ($totcount-1) - (($start/$limit)+1)*$limit;
				}
				else{
					
					$remaining = $totcount - (($start/$limit)+1)*$limit;
				}
				
				$nextstart = $remaining > 0 ? $start+$limit : '';
				
				$data['itemdata'] = $dbdata;
				$data['remaining'] = $remaining;
				$data['nextstart'] = $nextstart;
				$data['propertychosen'] = $propertychosen;
				$data['addid'] = $addid;
				
				$view = View::make('partials.itemsingle', $data);
				$content = $view->render();
		
				$status['htmldata'] = $content;
				$status['jsondata'] = $dbdata;
				$status['remaining'] = $remaining;
				$status['totcount'] = $totcount;
				$status['latlngarr'] = $latlngarr;
				$status['totdataarr'] = $dbdatacount;
				$status['secondHighestSpSqft'] = $secondHighestSpSqft;
				$status['centerDataSqftheated'] = $centerDataSqftheated;
				$status['proplinks'] = $propLinks;
				
				return response()->json($status);
			}
		}
	}
	
	public function fetchaddress(Request $request)
	{	
		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			$text = $request->input('text');
			
			if($act == 'dofetch'){
				
				$fetchData = DB::table('property')
							->select(DB::raw('id, lat, lng, Street_Number, Street_Name, City, State_Or_Province, Zip_Code, CONCAT_WS(" ", Street_Number, Street_Name, City, State_Or_Province, Zip_Code) AS street_address'))
							/* ->orWhere('Street_Number', $text)
							->orWhere('Street_Name', $text)
							->orWhere('City', $text)
							->orWhere('State_Or_Province', $text)
							->orWhere('Zip_Code', $text) */
							->having("street_address", "LIKE", "%".$text."%")
							//->groupBy("street_address")
							->get();
							
				$finalArr = [];
							
				if(count($fetchData)){
					
					foreach($fetchData as $kdata=>$vdata){
						
						$finalArr[$kdata] = array(
							'id' => $vdata->id,
							'lat' => ucwords(strtolower($vdata->lat)),
							'lng' => ucwords(strtolower($vdata->lng)),
							'street_address' => ucwords(strtolower($vdata->Street_Number.' '.$vdata->Street_Name.', '.$vdata->City.', '.$vdata->State_Or_Province.' '.$vdata->Zip_Code)),
						);
					}
				}
				
				//echo '<pre>'; print_r($finalArr); exit;
							
				if(!empty($finalArr)){
					
					$response = ['status' => 'success', 'maindata' => $finalArr];
				}
				else{
					
					$response = ['status' => 'failed'];
				}
				
				return response()->json($response);
			}
		}
	}
	
	public function addtocomparelist(Request $request){
		
		if($request->has('act')){
			
			$act = $request->input('act');
			
			if($act == 'doaddtocomparelist'){
				
				$id = $request->input('id');
				
				$getCompareList = Session::get('comparelist');
				
				if(empty($getCompareList)){
					
					$compareList[] = $id;
					
					Session::put('comparelist', $compareList);
					
					$response = ['status' => 'added', 'count' => 1];
				}
				else{
					
					$checkcount = count($getCompareList);
					
					if($checkcount < 6){
						
						$compareList = $getCompareList;
						
						if(in_array($id, $compareList)){
							
							$response = ['status' => 'alreadyadded', 'count' => count(Session::get('comparelist'))];
						}
						else{
							
							$compareList[] = $id;
						
							Session::put('comparelist', $compareList);
							
							$response = ['status' => 'added', 'count' => count(Session::get('comparelist'))];
						}
					}
					else{
						
						$response = ['status' => 'full', 'count' => count(Session::get('comparelist'))];
					}
				}
			}
			else{
			
				$response = ['status' => 'failed'];
			}
		}
		else{
			
			$response = ['status' => 'failed'];
		}
		
		return response()->json($response);
	}
	
	public function addbulktocomparelist(Request $request){
		
		if($request->has('act')){
			
			$act = $request->input('act');
			
			if($act == 'doaddbulktocomparelist'){
				
				$ids = $request->input('ids');
				
				$ids = json_decode($ids);
				
				//print_r($ids); exit;
				
				$getCompareList = Session::get('comparelist');
				
				if(empty($getCompareList)){
					
					$compareList = $ids;
					
					Session::put('comparelist', $compareList);
					
					$response = ['status' => 'added', 'count' => count($compareList)];
				}
				else{
					
					$checkcount = count($getCompareList);
					
					if($checkcount < 6){
						
						$compareList = $getCompareList;
						
						if(count($ids)){
							
							foreach($ids as $valid){
								
								if(!in_array($valid, $compareList)){
							
									$compareList[] = $valid;
								
									Session::put('comparelist', $compareList);
								}
							}
						}
						
						$response = ['status' => 'added', 'count' => count(Session::get('comparelist'))];
					}
					else{
						
						$response = ['status' => 'full', 'count' => count(Session::get('comparelist'))];
					}
				}
			}
			else{
			
				$response = ['status' => 'failed'];
			}
		}
		else{
			
			$response = ['status' => 'failed'];
		}
		
		return response()->json($response);
	}
	
	public function comparewithmain(Request $request){
		
		if($request->has('act')){
			
			$act = $request->input('act');
			
			if($act == 'comparewithmain'){
				
				$id = $request->input('id');
				$comparewith = $request->input('comparewith');
				
				$comparelist = [ $comparewith, $id ];
		
				$dbfinal = [];
				
				if(count($comparelist)){
					
					$listids = implode(',', $comparelist);
					
					$dbdata = DB::table('property')
							  ->whereIn('id', $comparelist)
							  ->orderByRaw(DB::raw("FIELD(id, ".$listids.")"))
							  ->get();
						
					//dd($dbdata);
					
					if(count($dbdata)){
						
						foreach($dbdata as $item){
							
							$dbfinal[] = [
								
								'ID' => $item->id,
								'Name' => 'Property #'.$item->id,
								'Address' => ucwords(strtolower($item->Street_Number.' '.$item->Street_Name.', '.$item->City.', '.$item->State_Or_Province.', '.$item->Zip_Code)),
								'Status' => $item->Status,
								'Close_Date' => $item->Close_Date,
								'List_Price' => number_format($item->List_Price),
								'Close_Price' => number_format($item->Close_Price),
								'Sp_Sq_Ft' => $item->Sp_Sq_Ft,
								'Days_To_Closed' => $item->Days_To_Closed,
								'Cdom' => number_format($item->Cdom),
								'Beds' => $item->Beds,
								'Total_Baths' => $item->Total_Baths,						
								'Special_Sale_Provision' => $item->Special_Sale_Provision,						
								'Pool' => $item->Pool,						
								'Year_Built' => $item->Year_Built,						
								'Sq_Ft_Heated' => number_format($item->Sq_Ft_Heated),						
								'Lot_Size_Sq_Ft' => number_format($item->Lot_Size_Sq_Ft)						
							];
						}
					}
				}
				
				$data['comparedata'] = $dbfinal;
				
				$data['comparefields'] = [
					
					'Address' => 'Address',
					'Status' => 'Status',
					'Closing Date' => 'Close_Date',
					'List Price' => 'List_Price',
					'Sold Price' => 'Close_Price',
					'SP/SQ Ft' => 'Sp_Sq_Ft',
					'Days to Close' => 'Days_To_Closed',
					'CDOM' => 'Cdom',
					'Beds' => 'Beds',
					'Total Baths' => 'Total_Baths',
					'Special Scale Provision' => 'Special_Sale_Provision',
					'Pool' => 'Pool',
					'Year Built' => 'Year_Built',
					'SQ/FT Heated' => 'Sq_Ft_Heated',
					'Lot Size SQ/FT' => 'Lot_Size_Sq_Ft'
				];
				
				$view = View::make('partials.compare', $data);
				$content = $view->render();
				
				$response = ['status' => 'success', 'content' => $content];
			}
			else{
			
				$response = ['status' => 'failed'];
			}
		}
		else{
			
			$response = ['status' => 'failed'];
		}
		
		return response()->json($response);
	}
	
	public function fetchpropertiesinzipcode(Request $request)
	{	
		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			$zipcode = $request->input('zipcode');
			
			if($act == 'dofetch'){
				
				$fetchData = DB::table('property')
							->select('*')
							->where('Zip_Code', $zipcode)
							->get();
							
				$latlngarr = array();
					
				$propLinks = [];
				
				if(count($fetchData)){
					
					foreach($fetchData as $vdata){
						
						$latlngarr[] = [ 'lat' => $vdata->lat, 'lng' => $vdata->lng ];
						
						$propLinks[$vdata->id] = URL::route('details',[ 'id' => $vdata->id ]);
					}
				}
							
				$response = ['status' => 'success', 'latlngarr' => $latlngarr, 'totaldata' => $fetchData, 'proplinks' => $propLinks];
				
				return response()->json($response);
			}
			else{
					
				$response = ['status' => 'failed'];
			}
		}
	}
}

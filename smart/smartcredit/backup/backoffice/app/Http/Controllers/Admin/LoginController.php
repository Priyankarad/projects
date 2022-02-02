<?php 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Login;
use Session;

class LoginController extends Controller {
	
	public function __construct()
	{
		$this->middleware('guest');
		
		if(Login::isloggedin()){
			
			return redirect()->route('adminuser')->send();
		}
	}

	
	public function index(Request $request)
	{
		//die('ssss');
		
		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			$username = $request->input('username');
			$password = $request->input('password');
			
			if($act == 'dologin'){
				
				$checklogin = Login::checklogin($username,$password);
				
				if(!empty($checklogin)){
					
					Session::put('adminid', $checklogin->id);
					
					return redirect()->route('adminuser');
				}
				else{
					
					return redirect()->route('login')->with('action','invalid');
				}
			}
		}
		
		$data['sectionname'] = 'Admin Login';
		$data['pagetitle'] = 'Admin Login - '.config('constants.project_name');
		$data['pagedescription'] = 'Admin Login - '.config('constants.project_name');
		
		return view('admin.login',$data);
	}
	
	public function logout(){
		
		Session::forget('adminid');
		
		return redirect()->route('login');
	}

}

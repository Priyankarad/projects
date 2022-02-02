<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request, $id)
	{	
		/* echo $request->input('id'); 
		echo $id; 
		
		die('Front'); */
		
		$users = DB::table('user')->lists('name');
		
		echo '<pre>'; print_r($users); exit;
		
		return view('demo');
	}

}

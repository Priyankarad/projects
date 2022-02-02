<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use DB;
use Session;

class Login
{
    public static function checklogin($username,$password)
    {
        $recorddetails = DB::table('admin')
						 ->where('username', $username)
						 ->where('password', $password)
						 ->first();
						 
		//echo '<pre>'; print_r($recorddetails); exit;
		
		return $recorddetails;
    }
	
	public static function loggedinadmindetails($id)
    {
        $recorddetails = DB::table('admin')
						 ->where('id', $id)
						 ->first();
						 
		//echo '<pre>'; print_r($recorddetails); exit;
		
		return $recorddetails;
    }
	
	public static function isloggedin()
    {
        $status = !empty(Session::get('adminid')) ? 1 : 0;
		
		return $status;
    }
}
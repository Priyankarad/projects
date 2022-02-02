<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use DB;
use Session;

class Login
{
    public static function checklogin($email,$password)
    {
        $recorddetails = DB::table('user')
						 ->where('email', $email)
						 ->where('password', $password)
						 ->where('is_archived', 'No')
						 ->first();
						 
		//echo '<pre>'; print_r($recorddetails); exit;
		
		return $recorddetails;
    }
	
	public static function loggedinuserdetails($id)
    {
        $recorddetails = DB::table('user')
						 ->where('id', $id)
						 ->first();
						 
		//echo '<pre>'; print_r($recorddetails); exit;
		
		return $recorddetails;
    }
	
	public static function loggedinuserid()
    {
        return Session::get('userid');
    }
	
	public static function isloggedin()
    {
        $status = !empty(Session::get('userid')) ? 1 : 0;
		
		return $status;
    }
}
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index(){
		require FCPATH.'application/libraries/stripe/Stripe.php';

		$params = array(
			//"testmode"   => "on",
			"private_live_key" => "sk_live_x1gf6hyhxZEAYZV52SfH4g2r",//neil
			"public_live_key"  => "pk_live_HJP56RwjnEx8yWec5eCtIqiM",//neil

			//"private_live_key" => "sk_live_K5d33aaX1hM56IYzVhFo6cnm",//_uhafeez
		   // "public_live_key"  => "pk_live_Fj6R1TMZz5JIxRaq3JJugy8Q",//_uhafeez

			//"private_test_key" => 'sk_test_m1ooyFLIWne5iV23n2CCqk2v',//neil
			//"private_test_key" => 'sk_test_lQkosqhXqjKBoIJjxg1PX3xL',test_uhafeez

			//"public_test_key"  => 'pk_test_62wGntoUuYmrN78lAySTRZ0c'//neil
			//"public_test_key"  => 'pk_test_VDGIcjZGmIhc2M969dF8NZhb'//test_uhafeez
		);

		if (isset($params['testmode']) && $params['testmode'] == "on") {
			Stripe::setApiKey($params['private_test_key']);
			$pubkey = $params['public_test_key'];
		} else {
			Stripe::setApiKey($params['private_live_key']);
			$pubkey = $params['public_live_key'];
		}

		if(isset($_POST['stripeToken']))
		{
			try {

				$charge = Stripe_Charge::create(array(		 
					"amount" => ($_POST['amount']*100),
					"currency" => "usd",
					"source" => $_POST['stripeToken'])
			);
				if(!empty($charge)){
					if (isset($charge->card->address_zip_check) && $charge->card->address_zip_check == "fail") {
						throw new Exception("zip_check_invalid");
					} else if (isset($charge->card->address_line1_check) && $charge->card->address_line1_check == "fail") {
						throw new Exception("address_check_invalid");
					} else if (isset($charge->card->cvc_check) && $charge->card->cvc_check == "fail") {
						throw new Exception("cvc_check_invalid");
					}
				}
				$result = "success";
			} catch(Stripe_CardError $e) {			
				$error = $e->getMessage();
				$result = "declined";

			} catch (Stripe_InvalidRequestError $e) {
				$result = "declined";		  
			} catch (Stripe_AuthenticationError $e) {
				$result = "declined";
			} catch (Stripe_ApiConnectionError $e) {
				$result = "declined";
			} catch (Stripe_Error $e) {
				$result = "declined";
			} catch (Exception $e) {
				if ($e->getMessage() == "zip_check_invalid") {
					$result = "declined";
				} else if ($e->getMessage() == "address_check_invalid") {
					$result = "declined";
				} else if ($e->getMessage() == "cvc_check_invalid") {
					$result = "declined";
				} else {
					$result = "declined";
				}		  
			}

			$dataArr['user_id'] = get_current_user_id();
			$dataArr['amount'] = $_POST['amount'];	
			if($result == 'success'){
				if(!empty($charge)){
					$charge = $charge->__toArray(TRUE);
					$data['status'] = "success";	
					$dataArr['status'] = "SUCCESS";	
					$dataArr['created_date'] = date('y-m-d H:i:s', $charge['created']);
					$dataArr['txn_id'] = $charge['balance_transaction'];
				}
			}else{
				$dataArr['created_date'] = date('y-m-d H:i:s');
				$data['status'] = "declined";
				$dataArr['status'] = 'FAILED';
			}

			if($this->input->post('start_dates') && $this->input->post('end_dates')){
				$start_date = $this->input->post('start_dates');
				$dataArr['start_date'] = date("Y-m-d", strtotime($start_date));
				$end_date = $this->input->post('end_dates');
				$dataArr['end_date'] = date("Y-m-d", strtotime($end_date));
				$dataArr['payment_type'] = 'CUSTOMIZED';
			}else{
				$dataArr['payment_type'] = 'FIXED';
				$dataArr['no_of_days'] = $this->input->post('no_of_days'); 
			}
			$this->common_model->insertData(PAYMENT_DETAILS,$dataArr);
			$this->load->view('frontend/payment',$data); 
		}
	}
}
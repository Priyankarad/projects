<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Push Notifications Helper
* Author: Sorav Garg
* Author Email: soravgarg123@gmail.com
* Description: This helper is used to send push notifications.
* version: 1.0
*/

if(!function_exists('send_android_notification')) {
	function send_android_notification($data, $target,$badges = 0,$update_badges_condition = array()){
		$CI = & get_instance();

		$fields = array
        (
        	'data' => $data
    	);

	    if(is_array($target)){
			$fields['registration_ids'] = $target;
		} else {
			$fields['to'] = $target;
		}
	    $server_key = 'AIzaSyDEiGNYzs9FYa9M7L7u6dOTM9vtdukLTJg';

	    $headers = array
	        (
	        'Authorization: key=' . $server_key,
	        'Content-Type: application/json'
	    );

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	    $result = curl_exec($ch);
	    $resp   = json_decode($result);
	    if($resp->success == 1){
	    	log_message('ERROR',"GCM - Message send successfully, message - ".$data['body']);
	    }else{
	    	log_message('ERROR',"GCM - Message failed, message - ".$data['body']);
	    }
	    curl_close($ch);

		/* To update user badges */
		/*if(!empty($update_badges_condition) && isset($update_badges_condition['user_id'])){
			$device_badges = $badges + 1;
			$CI->Common_model->updateFields(USERS, array('badges' => $device_badges), array('id' => $update_badges_condition['user_id']));
		}*/
	}
}

if(!function_exists('send_ios_notification')) {
	function send_ios_notification($deviceToken, $message,$params = array(),$badges = 0,$update_badges_condition = array()) {
		$CI = & get_instance();
		// Put your private key's passphrase here:
		$passphrase = '123';
		$user_certificate_path = APPPATH . "/third_party/swpush.certi.pem";
		
		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', $user_certificate_path);
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		// Open a connection to the APNS server
		$fp = stream_socket_client(APNS_GATEWAY_URL, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

		if (!$fp) {
			log_message('ERROR',"APN: Maybe some errors: $err: $errstr, message - ".$message);
		} else {
			log_message('ERROR',"Connected to APNS, message - ".$message);
		}

		
		// Create the payload body
		$body['aps'] = array(
			'alert' => $message,
			'params'=> $params,
			'badge'=> (int)$badges,
			'sound' => 'default'
			);

		// Encode the payload as JSON
		$payload = json_encode($body);

		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));

		if (!$result) {
			log_message('ERROR',"APN: Message not delivered, message - ".$message);
		} else {
			/* To update user badges */
			/*if(!empty($update_badges_condition) && isset($update_badges_condition['user_id'])){
				$device_badges = $badges + 1;
				$CI->Common_model->updateFields(USERS, array('badges' => $device_badges), array('id' => $update_badges_condition['user_id']));
			}*/
			log_message('ERROR',"APN: Message successfully delivered, message - ".$message);
		}

		// Close the connection to the server
		fclose($fp);
	}
}


/* End of file push_notification_helper.php */
/* Location: ./system/application/helpers/push_notification_helper.php */

?>
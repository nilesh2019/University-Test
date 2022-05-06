<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SendNotification{

	function sendfcmNotification($userId,$msg) 
    {
    	$CI=& get_instance();
    	$CI->load->model('model_basic');

    	define( 'API_ACCESS_KEY', 'AAAAlqhHLn0:APA91bF4yrGgfyVHMiMRMfQ7eENB18X1HZIHrS6QiQGNrgkN4oOxumJX4CQi8KlCbiRe2aiCfKtr5iSQgjwJB4xxCISutkFXhi3p2ORe1gtKsqs4eU2X-Jzt-AmGan705Dq0mXKl2sZ6' );
		$deviceId = $this->model_basic->getValue('users','deviceId',"`id` = '".$userId."'");
		if(isset($deviceId)&&$deviceId!='')
		{
		  $gcmToken = $this->model_basic->getValue('gcm','gcmToken',"`deviceId` = '".$deviceId."'");
			if(isset($gcmToken)&& $gcmToken!='')
			{		
				$registrationIds = array($gcmToken);
				$fields = array
				(
					//'to'		=> $registrationIds,// at a time for single user
					'registration_ids'		=> $registrationIds,// at a time for multiple users
					'data'	=> $msg
				);		
		
				$headers = array
						(
							'Authorization: key=' . API_ACCESS_KEY,
							'Content-Type: application/json'
						);
				#Send Reponse To FireBase Server	
				$ch = curl_init();
				curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
				curl_setopt( $ch,CURLOPT_POST, true );
				curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
				curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
				curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
				$result = curl_exec($ch );
				curl_close( $ch );
				#Echo Result Of FireBase Server
				/*print_r($msg);
				echo $result;*/
			}
		}
    }
}
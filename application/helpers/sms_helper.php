<?php 
    
    function send_sms($mob,$msg){
        if(!SMS_SEND_STATUS)
        return FALSE;
        
        $url = "http://msg.icloudsms.com/rest/services/sendSMS/sendGroupSms?";
        $params = [
        'AUTH_KEY'=>"2938fc71d5ccee2d557e338e185668",
        'mobileNos'=>$mob,
        'message'=>$msg,
        'senderId'=>"ESYCBN",
        'routeId'=>1,
        "smsContentType"=>"English"
        ];
        
        $options = array(
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0
        );
        //echo $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($params);exit;
        $defaults = array(
        CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($params),
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT =>56
        );
        
        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        $result = curl_exec($ch);
        if(!$result)
        {
            trigger_error(curl_error($ch));
            $flag=0;
		}
        else
        {	                
            $flag=1;
		}
        curl_close($ch);
        //echo $result;
	}
    
    function otp_registration($otp,$para1=''){
        return "Hi, ".$otp." is your verification code. Thanks for using EASYCELEBRATIONS.";
	}
	
    function registration_success($name,$username){
        return "Welcome ".$name." to the world of EASYCELEBRATIONS. Your ".$username." username to log in to www.easycelebrations.org. Happy Ordering EASYCELEBRATIONS";
	}
    
    function forgotPassword($name,$password){		
		return  "Hi, " . $name. " Your Password for log in to www.easycelebrations.org is "  .$password. ". Happy to help! EASYCELEBRATIONS" ;		
	}

    

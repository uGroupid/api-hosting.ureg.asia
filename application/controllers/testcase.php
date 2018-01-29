<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH .'/libraries/ISPConfig_Controller.php';
class Testcase extends ISPConfig_Controller {
	function __construct(){
		parent::__construct();
		$this->consumer_key = CONSUMER_KEY();
		$this->consumer_secret = CONSUMER_SECRET();
		$this->consumer_ttl = CONSUMER_TTL();
	}
	
	public function index(){
		$uid = "123";
		$param = array(
			'full_name' => 'handesk',
			'age' => 26,
			'addr' => '132/62 Cầu Diễn - Minh Khai - Quận Bắc Từ Liêm - Hà Nội ',
			'phone' => '093-233-7122',
			'auth',
		);
		$param_json = json_encode($param,true);
		$token = $this->Initialize_Token($uid,$param_json);
		$validate_token = $this->validate($token);
		if($validate_token==true){
			$token_json = $this->decode($token);
			var_dump($token_json);
		}
	}
	
	private function validate($token)
    {
        try {
            $decodeToken = $this->jwt->decode($token, $this->consumer_secret);
            $ttl_time = strtotime($decodeToken->expires_in);
            $now_time = strtotime(date(DATE_ISO8601, strtotime("now")));
            if(($now_time - $ttl_time) > $decodeToken->ttl) {
				 return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
	private function decode($token)
    {
        try{
            $decodeToken = $this->jwt->decode($token, $this->consumer_secret);
            return $decodeToken;
        }catch (Exception $e) {
            return false;
        }
    }
	private function Initialize_Token($uid,$param){
       $token = $this->jwt->encode(array(
            'key' => $this->consumer_secret,
            'uid' => $uid,
            'param' => $param,
            'expires_in' => date(DATE_ISO8601, strtotime("now")),
            'ttl' => $this->consumer_ttl,
        ), $this->consumer_secret);
        return $token;
	}
		
	
}

?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Token extends REST_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('global_model', 'GlobalMD');	
		$this->consumer_key = CONSUMER_KEY();
		$this->consumer_secret = CONSUMER_SECRET();
		$this->consumer_ttl = CONSUMER_TTL();
	}
	public function index_post(){
		$uid = "123";
		$param = array(
			'full_name' => 'handesk',
			'age' => 26,
			'addr' => '132/62 Cầu Diễn - Minh Khai - Quận Bắc Từ Liêm - Hà Nội ',
			'phone' => '093-233-7122',
			'auth'=> false,
		);
		$param_json = json_encode($param,true);
		$token = $this->GlobalMD->Initialize_Token($uid,$param_json);
		$response = array('data' => $param_json, );
		$this->response($response);
	}
	
	public function check_get(){
		$response = array('');
		$this->response($response);
	}
	
	public function create_get(){
		$response = array('');
		$this->response($response);
	}
	
	public function info_get(){
		$response = array('');
		$this->response($response);
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
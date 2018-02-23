<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Token extends REST_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('global_model', 'GlobalMD');	
	
	}
	public function index_get(){
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
	
	
}
?>
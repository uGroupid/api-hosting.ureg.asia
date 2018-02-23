<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Token extends REST_Controller {
	public $uid;
	public $token;
	public $param;
	
	function __construct(){
		parent::__construct();
		$this->load->model('global_model', 'GlobalMD');	
		$this->uid = null;
		$this->token = null;
		$this->param  = null;
	}
	public function index_get(){
		if(isset($_GET['param'])){
			if(!empty($_GET['param'])){
				if(isset($_GET['param']['username']) || !empty($_GET['param']['username'])){
					if(isset($_GET['param']['password']) || !empty($_GET['param']['password'])){
						$this->uid = "123";
						$this->param  = array(
							'full_name' => 'handesk',
							'age' => 26,
							'addr' => '132/62 Cầu Diễn - Minh Khai - Quận Bắc Từ Liêm - Hà Nội ',
							'phone' => '093-233-7122',
							'auth',
						);
					}
				}
			}
		}
		$param_json = json_encode($this->param,true);
		$this->token = $this->GlobalMD->Initialize_Token($this->uid,$param_json);
		$response = array(
			'data' => $this->token
		);
		$this->response($response);
	}
	
	public function check_get(){
		if(isset($_GET['token'])){
			if(!empty($_GET['token'])){
				$this->token = $_GET['token'];
			}
		}
		$this->params = $this->GlobalMD->validate($this->token);
		$response = array(
			'data' => $this->params,
		);
		$this->response($response);
	}
	
	public function info_get(){
		if(isset($_GET['token'])){
			if(!empty($_GET['token'])){
				$this->token = $_GET['token'];
			}
		}
		$this->params = $this->GlobalMD->decode($this->token);
		$response = array(
			'data' => $this->params,
		);
		$this->response($response);
	}
	
	
}
?>
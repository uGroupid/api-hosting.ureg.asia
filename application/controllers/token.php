<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Token extends REST_Controller {
	public $uid;
	public $token;
	public $param;
	public $username;
	public $password;
	public $message;
	function __construct(){
		parent::__construct();
		$this->load->model('global_model', 'GlobalMD');	
		$this->uid = null;
		$this->token = null;
		$this->param  = null;
		$this->username = null;
		$this->password = '';
		$this->message = null;
		
	}
	
	public function index_get(){
		$core_private  = new Core_Private;
		if(isset($_GET['username']) || !empty($_GET['username'])){
			if(isset($_GET['password']) || !empty($_GET['password'])){
				$this->username = $_GET['username'];
				$this->password = $_GET['password'];
				$this->param = $core_private->Token_Create($this->username,$this->password);
			}
		}
		$response = array(
			'result' => array(
				'message' => $this->GlobalMD->msg(2001),
			),
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

class Core_Private extends MY_Controller {
	public $username;
	public $password;
	function __construct()
	{
		parent::__construct();
		$config =  array('server' => "http://id.ugroup.asia");
		$this->rest->initialize($config);
		$this->username = null;
		$this->password = null;
		
	}
	public function Token_Create($username=null,$password=null){
		$this->username = $username;
		$this->password = $password;
		$param = array(
			'param' => json_encode(array(
				'username' => $this->username,
				'password' => $this->password,
			)),
		);
		$response = $this->rest->get('token/create',$param);
		return $response;
	}
}
?>
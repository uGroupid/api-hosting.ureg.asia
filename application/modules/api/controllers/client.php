<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Client extends REST_Controller {
	function __construct(){
		parent::__construct();
		
	}
	public function index_get(){
		$response = array('');
		$this->response($response);
	}
	
}
?>
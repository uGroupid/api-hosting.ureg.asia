<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Api extends REST_Controller {
	function __construct(){
		parent::__construct();
		
	}
	public function index_get(){
		$response = array(
			'status_api' => 
				api_message(00), 
				api_message(01), 
				api_message(02), 
				api_message(03), 
				api_message(04), 
			);
		$this->response($response);
	}
	
}
?>
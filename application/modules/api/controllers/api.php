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
				api_message(99), 
				api_message(01), 
				api_message(02), 
				api_message(03), 
				api_message(04), 
				api_message(05), 
				api_message(06), 
				api_message(07), 
				api_message(08), 
				api_message(09), 
				api_message(10), 
				api_message(11), 
				api_message(12), 
			);
		$this->response($response);
	}
	
}
?>
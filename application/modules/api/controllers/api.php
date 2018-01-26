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
				array(
				  'code' => '20-29',
				  'msg' => 'Error FTP Syntax',
				 ),
				array(
				  'code' => '30-39',
				  'msg' => 'Error DATABASE Syntax',
				 ),
				array(
				  'code' => '40-49',
				  'msg' => 'Error Website Syntax',
				 ),
				 array(
				  'code' => '50-59',
				  'msg' => 'Error Clients Syntax',
				 ),
				 array(
				  'code' => '60-69',
				  'msg' => 'Error Email Syntax',
				 ),
				  array(
				  'code' => '70-79',
				  'msg' => 'Error Disk Syntax',
				 ),
				  array(
				  'code' => '80-89',
				  'msg' => 'Error Payment Syntax',
				 ),
				 array(
				  'code' => '90-98',
				  'msg' => 'Monitor Server Syntax',
				 ),
			);
		$this->response($response);
	}
	
}
?>
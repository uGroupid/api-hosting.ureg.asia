<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Api extends REST_Controller {
	function __construct(){
		parent::__construct();
		
	}
	
	public function index_get(){
		$response = array(
			'status_api' = > array(''),
		);
		
		$this->response($response);
	}
	
	
////------End Class Api---------------////	
}
////------Start Class Core Apps-------////	
class APIcore extends MY_Controller{
	function __construct(){
		parent::__construct();
	}
	
	
	
////-------End Class Apps------------////	
}
?>
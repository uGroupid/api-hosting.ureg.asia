<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH .'/libraries/ISPConfig_Controller.php';
class Testcase extends ISPConfig_Controller {
	function __construct(){
		parent::__construct();
		
	}
	
	public function index(){
	 
	 echo "echo hello";
		
	}
}

?>
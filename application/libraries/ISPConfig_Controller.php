<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class ISPConfig_Controller extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		ob_clean();
	}
	
	public function ISPConfig_Testcase(){
		return __DIR__.'/GDM/ISPConfig/';
	}
	
}


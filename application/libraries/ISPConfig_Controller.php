<?php defined('BASEPATH') OR exit('No direct script access allowed');
// require './vendor/autoload.php';
Class ISPConfig_Controller extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function ISPConfig_Testcase(){
		return __DIR__;
	}
	
}
// $cp       = new \GDM\ISPConfig\SoapClient('https://127.0.0.1:8080/remote/index.php', 'admin', 'mysecurepassword');
// $clientId = $cp->clientAdd("My Client", "My Clients Company", "myclient", "myclientspassword", "contact@myclient.com", "000000");
// $siteId   = false;
// if ($clientId) {
    // $siteId = $cp->sitesWebDomainAdd($clientId, "myclient.com", "255.255.255.1");
// } else {
    // echo "Failed to create client " . $cp->getLastException()->getMessage();
// }

// if ($siteId) {
    // echo "Created client with id $clientId ";
    // echo "Created site with id $siteId ";
// } else {
    // echo "Failed to create site " . $cp->getLastException()->getMessage();
// }


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Client extends REST_Controller {
	public $token ;
	public $username ;
	public $passwords;
	public $email;
	/////////////////////////////////
	public $street;
	public $zip;
	public $city;
	public $state;
	public $country;
	public $telephone;
	public $mobile;
	public $fax;
	//////////////////////////////////
	public $company_name;
	public $vat_id;
	public $customer_no;
	public $contact_name;
	public $language;
	public $usertheme;
	public $notes;
	public $created_at;
	//////////////////////////////////
	
	function __construct($token=''){
		parent::__construct();
		if(!empty($token)){
			$this->token = $token;
		}else{
			$response = array('msg' => api_message(05),);
			$this->response($response);
		}
	}
	public function index_get(){
		$response = array('');
		$this->response($response);
	}
	
}
?>
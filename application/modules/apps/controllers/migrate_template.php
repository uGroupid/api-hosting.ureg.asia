<?php
class Migrate_template extends MY_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('rest');
		$this->load->model('global_model', 'GlobalMD');	
		$this->config_server =  array('server' => 'http://192.168.1.221/apps',);
		$this->rest->initialize($this->config_server);
	}
	
	public function addRedirect(){
		$xml = simplexml_load_file("/var/www/clients/client0/web1/web/mingrate_cpanel/domain_redirect_url.xml");
		foreach ($xml->RECORD as $zone) {
			$name_zone = (string)$zone->name_zone;
			$data_record = (string)$zone->url;
			$response = $this->mongo_db->where(array('name_zone' => $name_zone))->get('ureg_zone');
			if(isset($response[0])==true){
				$id_zone = (string)$response[0]['_id'];
				$id_clients = (string)$response[0]['client_id'];
				$params_record1 = array(
						"id_zone" => $id_zone,
						"client_id" =>  $id_clients,
						"resller_id" => "59995d7745fbbed1233e1db4",
						"name_record" => $name_zone,
						"type_record" =>  "IURL",
						"data_record" => $data_record,
						"aux" => "10",
						"ttl" => 3600,
						"stamp" => time(),
						"active" => "Active",
						"status" => "Active"
					);
				$this->mongo_db->insert('ureg_zone_record', $params_record1);
				log_convert('addRedirect-yes_active-',$name_zone);	
			}else{
				log_convert('addRedirect-not_active-',$name_zone);	
			}
		}
	}
	protected function isValidatorDomain($domain_row){
		$regexp = '/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/';
		$check_domain =  preg_match($regexp,$domain_row);
		return $check_domain;
	}	
	
	public function convert_string($string){
		$str = trim(strtolower($string));
		$str = str_replace(" ","",$str);
		return $str;
	}
	
	public function xml_zone(){
		$xml = simplexml_load_file("/var/www/clients/client0/web1/web/mingrate_cpanel/account_dns_redirect.xml");
		foreach ($xml->RECORD as $account) {
			$name_zone =  $this->convert_string((string)$account->domain_name);
			$response = $this->mongo_db->where(array('user_domain' => $name_zone))->get('ureg_users');
			if(isset($response[0])==true){
				$id_clients = (string)$response[0]['_id'];
				$params = array(
					'name_zone' => trim($name_zone),
					'client_id' => $id_clients,
					'resller_id' => '59995d7745fbbed1233e1db4',
					'active' => 'active',
					'auth' => sha1($id_clients),
					'status' => 'update',
				);
				$response = $this->mongo_db->where(array('name_zone' => $name_zone))->get('ureg_zone');
				if(empty($response)==true){
					$result = $this->mongo_db->insert('ureg_zone', $params);
					$id_zone = (string)$result;
					$params_record1 = array(
						"id_zone" => $id_zone,
						"client_id" =>  $id_clients,
						"resller_id" => "59995d7745fbbed1233e1db4",
						"name_record" => $name_zone,
						"type_record" =>  "A",
						"data_record" => "113.190.247.18",
						"aux" => "10",
						"ttl" => 3600,
						"stamp" => time(),
						"active" => "Active",
						"status" => "Active"
					);
					$this->mongo_db->insert('ureg_zone_record', $params_record1);
					$params_record2 = array(
						"id_zone" => $id_zone,
						"client_id" =>  $id_clients,
						"resller_id" => "59995d7745fbbed1233e1db4",
						"name_record" => 'www',
						"type_record" =>  "CNAME",
						"data_record" => $name_zone,
						"aux" => "10",
						"ttl" => 3600,
						"stamp" => time(),
						"active" => "Active",
						"status" => "Active"
					);
					$this->mongo_db->insert('ureg_zone_record', $params_record2);
					$params_record3 = array(
						"id_zone" => $id_zone,
						"client_id" =>  $id_clients,
						"resller_id" => "59995d7745fbbed1233e1db4",
						"name_record" => $name_zone,
						"type_record" =>  "NS",
						"data_record" => "ns1.it.vn",
						"aux" => "10",
						"ttl" => 3600,
						"stamp" => time(),
						"active" => "Active",
						"status" => "Active"
					);
					$this->mongo_db->insert('ureg_zone_record', $params_record3);
					$params_record4 = array(
						"id_zone" => $id_zone,
						"client_id" =>  $id_clients,
						"resller_id" => "59995d7745fbbed1233e1db4",
						"name_record" => $name_zone,
						"type_record" =>  "NS",
						"data_record" => "ns2.it.vn",
						"aux" => "10",
						"ttl" => 3600,
						"stamp" => time(),
						"active" => "Active",
						"status" => "Active"
					);
					$this->mongo_db->insert('ureg_zone_record', $params_record4);
					$params_record5 = array(
						"id_zone" => $id_zone,
						"client_id" =>  $id_clients,
						"resller_id" => "59995d7745fbbed1233e1db4",
						"name_record" => $name_zone,
						"type_record" =>  "NS",
						"data_record" => "ns3.it.vn",
						"aux" => "10",
						"ttl" => 3600,
						"stamp" => time(),
						"active" => "Active",
						"status" => "Active"
					);
					$this->mongo_db->insert('ureg_zone_record', $params_record5);
					core_logs_mingrate('insert-zone==>'.$id_zone);
					//print_r($params);
				}
			}
			core_logs_mingrate('da_ton_tai_insert-zone==>'.$name_zone);
		}
	}
	
	
	
	
//////////////////////////	
}


?>


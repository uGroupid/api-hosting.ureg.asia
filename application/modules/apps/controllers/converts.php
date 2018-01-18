<?php
class Converts extends MY_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('rest');
		$this->load->model('global_model', 'GlobalMD');	
		$this->config_server =  array('server' => 'http://192.168.1.221/apps',);
		$this->rest->initialize($this->config_server);
	}
	
	public function domain_dns(){
		$xml = simplexml_load_file("/var/www/clients/client0/web1/web/mingrate_cpanel/renames_db.xml");
		foreach ($xml->RECORD as $zone) {
			$domain_name = (string)$zone->domain_name;
			$file_old = '/var/named/zone/zone_tmtv/dbpri.'.$domain_name;
			if(file_exists($file_old)){
				$file_new = '/var/named/zone/zone_tmtv/pri.'.$domain_name;
				rename($file_old, $file_new);
				log_convert('rename_zone-yes', $domain_name);
			}else{
				log_convert('rename_zone-no', $domain_name);
			}
			
			
			
		}
	}
	
public function file_zone_renew(){
	$file = fopen("/var/www/clients/client0/web1/web/mingrate_cpanel/rename_zone-yes.txt", "r");
		while (!feof($file)) {
			$zone = fgets($file);
			$filenew = '/var/named/uzone/pri.'.$zone;
			if(file_exists($filenew)){
				unlink($filenew);
				log_convert('renew_del_zone-yes', $zone);
			}else{
				log_convert('renew_del_zone-none', $zone);
			}
		}
	fclose($file);
}
	public function load_no_zone(){
	$filname_local = "/var/www/clients/client0/web1/web/mingrate_cpanel/remnames.sh";
		$file = fopen("/var/www/clients/client0/web1/web/mingrate_cpanel/rename_zone-yes.txt", "r");
			while (!feof($file)) {
			   $zone = fgets($file);
			   $option = '/var/named/uname/rem.pl '.$zone;
			   file_put_contents($filname_local,$option, FILE_APPEND | LOCK_EX);
			}
		chmod($filname_local,0755);
	fclose($file);
	}
	
	public function load_zone_waiting($limit,$offset){
		// $total = 201760/10000; 20.176[
		$response = $this->mongo_db->where(array('status'=>'waiting'))->limit($limit)->offset($offset)->get('ureg_zone');
		foreach($response as $value){
			$domain_zone =  $value['name_zone'];
			log_convert('get-tasks-', 'running-task-'.$limit.'===>'.$domain_zone);
			$file_zone = '/var/named/uzone/pri.'.$domain_zone;
			if(file_exists($file_zone)){
				log_convert('checktasks', 'running-task-zone-yes-'.$limit.'===>'.$domain_zone);
				log_convert('zone-yes', $domain_zone);
			}else{
				log_convert('checktasks', 'running-task-zone-no-'.$limit.'===>'.$domain_zone);
				log_convert('zone-no', $domain_zone);
			}
		}
		
	}
	
	
	public function convert_string($string){
		$str = trim(strtolower($string));
		$str = str_replace(" ","",$str);
		return $str;
	}
	public function check_user($zone){
		$check_response = $this->mongo_db->where(array('user_domain'=>$zonem))->get('ureg_users');
		$params = array(
			'username'  => $zone,
			'user_domain'  => $zone,
			'password'  => md5($zone),
			'email'  => 'info@'.$zone,
			'phone'  => '01237744777',
			'id_levels'  => 1,
			'id_reseller'  => '59995d7745fbbed1233e1db4',
			'create_date'  => date("Y-m-d H:i:s",time()),
			'update_date'  => date("Y-m-d H:i:s",time()),
			'status'  => 1,
			'auth'  => sha1(md5($zone)),
		);
		if(empty($check_response)){
			$install = $this->mongo_db->insert('ureg_users', $params);
			return $install;
		}else{
			//$del_response = $this->mongo_db->where(array('user_domain'=>$zone))->delete('ureg_users');
			return $check_response;
		}
		
	}
	public function check_zone($zone,$id_clients){
		$check_response = $this->mongo_db->where(array('name_zone'=>$zone))->get('ureg_zone');
		$params = array(
				'name_zone' => $zone,
				'client_id' => $id_clients,
				'resller_id' => '59995d7745fbbed1233e1db4',
				'active' => 'active',
				'auth' => sha1($id_clients),
				'status' => 'waiting',
			);
		if(empty($check_response)){
			$install = $this->mongo_db->insert('ureg_zone', $params);
			return $install;
		}else{
			return $check_response;
		}
		
	}
	public function check_zone_record($id_zone){
		$check_response = $this->mongo_db->where(array('id_zone'=>$id_zone))->get('ureg_zone_record');
		return $check_response;
	}
	
	public function load_active_zone(){
		// $file = fopen("/var/www/clients/client0/web1/web/mingrate_cpanel/zone_active.txt", "r");
		$file = fopen("/var/www/clients/client0/web1/web/mingrate_cpanel/zone-no.txt", "r");
		$members = array();
		while (!feof($file)) {
		   $members[] = fgets($file);
		}
		fclose($file);
		return $members;
	}
	
	public function migrate_zone(){
		$zone = $this->load_active_zone();
		$total = count($zone);
		
		$persen = ($total/2);
		$x=0;
		foreach($zone as $value){
			
			if($x <= $persen){
				$domain = $this->convert_string($value);
				echo $x."</br>";
				echo $domain."</br>";
				$name_zone = $this->punny_code($domain);
				echo $domain_idn."</br>";
				$reponse_clients = $this->check_user($name_zone);
				if(isset($reponse_clients[0])==true){
					$id_clients = (string)$reponse_clients[0]['_id'];
					$params = array(
						'name_zone' => trim($name_zone),
						'client_id' => $id_clients,
						'resller_id' => '59995d7745fbbed1233e1db4',
						'active' => 'active',
						'auth' => sha1($id_clients),
						'status' => 'waiting',
					);
					$response_zone = $this->mongo_db->where(array('name_zone' => $name_zone))->get('ureg_zone');
					if(empty($response_zone)==true){
						$result = $this->mongo_db->insert('ureg_zone', $params);
						$id_zone = (string)$result;
						$params_record1 = array(
							"id_zone" => $id_zone,
							"client_id" =>  $id_clients,
							"resller_id" => "59995d7745fbbed1233e1db4",
							"name_record" => $name_zone,
							"type_record" =>  "A",
							"data_record" => "101.99.20.162",
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
						core_logs_mingrate('insert-zone_new==>'.$name_zone);
					}else{
						$id_zone = (string)$response_zone[0]['_id'];
						$check_response_record = $this->mongo_db->where(array('id_zone'=>$id_zone))->get('ureg_zone_record');
						if(empty($check_response_record)==true){
							$params_record1 = array(
								"id_zone" => $id_zone,
								"client_id" =>  $id_clients,
								"resller_id" => "59995d7745fbbed1233e1db4",
								"name_record" => $name_zone,
								"type_record" =>  "A",
								"data_record" => "101.99.20.162",
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
							core_logs_mingrate('insert-zone_new==>'.$name_zone);
						}
					}
				}
				echo $id_account."</br>";
				
			}else{
				break;
			}
			$x++;
		}
	}
	
	public function convert_zone_sign(){
		$zone = $this->load_active_zone();
		$total = count($zone);
		$persen = ($total/2);
		foreach($zone as $zone_name){
				$name_zone = $this->convert_string($this->punny_code($zone_name));
				$response_zone = $this->mongo_db->where(array('name_zone' => $name_zone,'status'=>'waiting'))->get('ureg_zone');
				if(!empty($response_zone)){
					$zone_id = (string)$response_zone[0]["_id"];
					$client_id = (string)$response_zone[0]["client_id"];
					$params = array(
						'data' => array(
							'zone_id'	=> $zone_id,
							'client_id'	=> $client_id,
						)
					);
					$response = $this->rest->post('apps/api/tasks',$params);
					if(isset($response->results)==true){
					$response_soa = $this->TmpSOAdefault($name_zone);
					$soa_recordx = $response->results;
					$response_soa .= $this->TmpRecord($soa_recordx);
					$this->create_file_record($name_zone,$response_soa);
					$prams_update = array(
						'status'=> "zone_active",
					);
					$update_zone =	$this->mongo_db->where(array('_id'=>  new \MongoId($zone_id)))->set($prams_update)->update('ureg_zone');
	$filname_local = "/var/named/uname/named.conf.local";
	$domain = trim(strtolower($name_zone));
	$option = 'zone "'.$domain.'" {
	type master;   				
	file "/var/named/uzone/pri.'.$domain.'";
	};';
	file_put_contents($filname_local,print_r($option, TRUE)."\n", FILE_APPEND | LOCK_EX);
					log_convert('zone-sign_yes', $name_zone);
					}else{
						log_convert('zone-not_active-',$name_zone);	
					}
				}else{
					log_convert('zone-sign_no', $name_zone);	
				}	
		
		}
	}
	
	private function punny_code($domain_name){
		mb_internal_encoding('utf-8');
		$Punycode = new Idna_convert();
		$domain_name_space = $Punycode->encode($domain_name);
		return $domain_name_space;
	}
	
	private function deletel_zone($zone_name){
		return exec('/var/named/uname/rem.pl '.$zone_name );
	}
	private function write_zone($zone_name){
		return exec('grep '.$zone_name.' /var/named/uname/named.conf.local');
		
	}
protected function create_file_record($name_zone,$params){
$file = "/var/named/uzone/pri.$name_zone";
$filenew = "/var/named/uzone/pri.$name_zone.new";
if(file_exists($filenew)){
unlink($filenew);
file_put_contents($filenew,print_r($params, TRUE)."\n", FILE_APPEND | LOCK_EX);
if(file_exists($file)){
	unlink($file);
}
rename($filenew, $file);
}else{
file_put_contents($filenew,print_r($params, TRUE)."\n", FILE_APPEND | LOCK_EX);
if(file_exists($file)){
	unlink($file);
}
rename($filenew, $file);
}
}

protected function TmpRecord($response){
$option = '';
foreach($response as $respons){
$type_record = (string)$respons->type_record;
$data_record = $respons->data_record;
$name_record = $respons->name_record;
$aux = (int)$respons->aux;
if($type_record == "A" || $type_record == 'AAAA'){
$CheckDomain = $this->isValidatorDomain($name_record);
if($CheckDomain = 1){
$option .= "\n$name_record.   IN   A  $data_record\n";
}else{
$option .= "\n$name_record   IN    A   $data_record\n";
}
}
if($type_record == 'RURL'){
$option .= "@   IN   A   123.123.123.123\n";
}
if($type_record == 'RURL'){
$option .= "@    IN   A   123.123.123.123\n";
$option .= "www    IN   A   123.123.123.123\n";
}
if($type_record == 'IURL'){
$option .= "@   IN   A   123.123.123.123\n";
$option .= "www    IN   A   123.123.123.123\n";
}
if($type_record == 'CNAME'){
$option .= "\n$name_record    IN    CNAME   $data_record.\n";
}
if($type_record == 'MX'){
$option .= "\n$name_record.  3600   IN   MX  $aux  $data_record.\n";
}
if($type_record == 'TXT'){
$option .= "\n$name_record.   IN   TXT  ".'"'.$data_record.'"'."\n";
}

if($type_record == 'NS'){
	$option .= "\n$name_record.   IN   NS  $data_record.\n";
}
}

return $option;
}	
protected function TmpSOAdefault($name_zone){
$serial = time();
$option = '$TTL 3600';
$option .="\n@	IN SOA	root.ugroup.asia ns.$name_zone. (
$serial	; serial
3600	; refresh
3600	; retry
84600	; expire
3600 )	; minimum
";
$option .= "\n$name_zone.   IN  NS    ns1.ugroup.asia. \n";
$option .= "\n$name_zone.   IN  NS    ns2.ugroup.asia. \n";
$option .= "\n$name_zone.   IN  NS    ns3.ugroup.asia. \n";
return $option;
}
protected function isValidatorDomain($domain_row){
	$regexp = '/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/';
	$check_domain =  preg_match($regexp,$domain_row);
	return $check_domain;
}










		
	
}

/* 
<tbl_login>
        <id_user>11</id_user>
        <username>bigcity.vn</username>
        <userdomain>bigcity.vn</userdomain>
        <address></address>
        <phone_number></phone_number>
        <email></email>
        <exp_domain>2009-10-22</exp_domain>
        <user_password>2f6d228b27cb84e9fb4ac4e0ba393c8b</user_password>
        <id_premission>3</id_premission>
        <statur>1</statur>
        <client_dns></client_dns>
        <Auth></Auth>
   </tbl_login>
*/


?>


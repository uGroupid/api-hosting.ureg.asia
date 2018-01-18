<?php
class Monitor extends MY_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('rest');
		$this->load->model('global_model', 'GlobalMD');	
		$this->config_server =  array('server' => 'http://192.168.1.221/apps',);
		$this->rest->initialize($this->config_server);
	}



	
	
	
	
	
	
	
	
	
public function sign_zone(){
$result = $this->mongo_db->where(array('status' => 'Active'))->get('ureg_zone');
$file = "/var/named/uname/named.conf.local";
$filenew = "/var/named/uname/named.conf.local.new";
if (file_exists($filenew)){
unlink($filenew);
foreach($result as $value){
$zone_id = (string)$value["_id"];
$name_zone = (string)$value['name_zone'];
$domain = trim(strtolower($name_zone));
$option = 'zone "'.$domain.'" {
type master;	
file "/var/named/uzone/pri.'.$domain.'";
};';
file_put_contents($filenew,print_r($option, TRUE)."\n", FILE_APPEND | LOCK_EX);
$prams_update = array(
	'status'=> "Active",
);
$update_zone =	$this->mongo_db->where(array('_id'=>  new \MongoId($zone_id)))->set($prams_update)->update('ureg_zone');
}
}else{
foreach($result as $value){
$zone_id = (string)$value["_id"];
$name_zone = (string)$value['name_zone'];	
$domain = trim(strtolower($name_zone));
$option = 'zone "'.$domain.'" {
type master;   				
file "/var/named/uzone/pri.'.$domain.'";
};';
file_put_contents($filenew,print_r($option, TRUE)."\n", FILE_APPEND | LOCK_EX);
$prams_update = array(
	'status'=> "Active",
);
$update_zone =	$this->mongo_db->where(array('_id'=>  new \MongoId($zone_id)))->set($prams_update)->update('ureg_zone');
}
unlink($file);
rename($filenew, $file);
}
}
public function task(){
$result = $this->mongo_db->where(array('status' => 'CreateNewZone'))->get('ureg_zone');
foreach($result as $value){
$zone_id = (string)$value["_id"];
$client_id = (string)$value["client_id"];
$name_zone = (string)$value["name_zone"];
	$params = array(
		'data' => array(
		'zone_id'	=> $zone_id,
		'client_id'	=> $client_id,
	)
);
$params_nameserver = array(
	'params' => array(
		'client_id' => $client_id,
	)
);
$response_name_server = $this->rest->post('apps/api/nameserver',$params_nameserver);
$response = $this->rest->post('apps/api/tasks',$params);
if(isset($response->results)){
$details_params_nameserver = array(
		$response_name_server->ns1,
		$response_name_server->ns2,
		$response_name_server->ns3,
	);
$response_soa = $this->TmpSOAdefault($name_zone,$details_params_nameserver);
$response_soa .= $this->TmpRecord($response->results);
$this->create_file_record($name_zone,$response_soa);
}
$prams_update = array(
	'status'=> "Active",
);
$update_zone =	$this->mongo_db->where(array('_id'=>  new \MongoId($zone_id)))->set($prams_update)->update('ureg_zone');	
}
}

protected function create_file_record($name_zone,$params){
$file = "/var/named/uzone/pri.$name_zone";
$filenew = "/var/named/uzone/pri.$name_zone.new";
if(file_exists($filenew)){
unlink($filenew);
file_put_contents($filenew,print_r($params, TRUE)."\n", FILE_APPEND | LOCK_EX);
unlink($file);
rename($filenew, $file);
}else{
file_put_contents($filenew,print_r($params, TRUE)."\n", FILE_APPEND | LOCK_EX);
unlink($file);
rename($filenew, $file);
}
}
protected function TmpRecord($response){
$option = '';
foreach($response as $respons){
	
$type_record = $respons->type_record;
$data_record = $respons->data_record;
$name_record = $respons->name_record;
$aux = $respons->aux;
if($type_record == 'A' ){
$CheckDomain = $this->isValidatorDomain($name_record);
if($CheckDomain == 1){
	$option .= "\n$name_record.   IN   A  $data_record\n";
}else{
	$option .= "\n$name_record   IN    A   $data_record\n";
}
}
if($type_record == 'AAAA'){
$option .= "\n$name_record    IN    CNAME   $data_record.\n";
}
if($type_record == 'CNAME'){
$option .= "\n$name_record    IN    CNAME   $data_record.\n";
}
if($type_record == 'MX'){
$option .= "\n$name_record.  3600   IN   MX  $aux  $data_record.\n";
}
if($type_record == 'TXT'){
$option .= "\n$name_record.   IN   TXT  ".'"$data_record"'."\n";
}
if($type_record == 'NS'){
//$option .= "\n$name_record.   IN   NS  $data_record.\n";
}

}
return $option;
}	
protected function TmpSOAdefault($name_zone,$namserver){
$ns1 = $namserver[0];
$ns2 = $namserver[1];
$ns3 = $namserver[2];
$serial = time();
$option = '$TTL 3600';
$option .="\n@	IN SOA	root.ugroup.asia ns.$name_zone. (
$serial	; serial
3600	; refresh
3600	; retry
84600	; expire
3600 )	; minimum
";
$option .= "\n$name_zone.   IN  NS    $ns1. \n";
$option .= "\n$name_zone.   IN  NS    $ns2. \n";
$option .= "\n$name_zone.   IN  NS    $ns3. \n";
return $option;
}
protected function isValidatorDomain($domain_row){
	$regexp = '/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/';
	$check_domain =  preg_match($regexp,$domain_row);
	return $check_domain;
}

}

?>


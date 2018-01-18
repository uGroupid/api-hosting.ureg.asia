<?php
class Migrate_signzone extends MY_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('rest');
		$this->load->model('global_model', 'GlobalMD');	
		$this->config_server =  array('server' => 'http://192.168.1.221/apps',);
		$this->rest->initialize($this->config_server);
	}
	
public function sign_zone(){
$result = $this->mongo_db->where(array('status' => 'Activity'))->get('ureg_zone');
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
	'status'=> "Signzone",
);
$update_zone =	$this->mongo_db->where(array('_id'=>  new \MongoId($zone_id)))->set($prams_update)->update('ureg_zone');
core_logs_mingrate('Signzone_active-'.$name_zone);	
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
	'status'=> "Signzone",
);
$update_zone =	$this->mongo_db->where(array('_id'=>  new \MongoId($zone_id)))->set($prams_update)->update('ureg_zone');
core_logs_mingrate('Signzone_active-'.$name_zone);	
}
}
if (file_exists($file)){
	unlink($file);
}
rename($filenew, $file);
}	

	
public function convert_string($string){
	$str = trim(strtolower($string));
	$str = str_replace(" ","",$str);
	return $str;
}
	
	
	
	
	
	
	
	
	
	
////////////////
}

?>


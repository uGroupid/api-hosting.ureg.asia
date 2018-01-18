<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(! function_exists('microsecond')){
	function microsecond() {
		 $ts = gettimeofday(true);
		 $ts = sprintf("%.5f", $ts);
		 $s = strftime("%Y-%m-%dT%H:%M:%S", $ts);
		return $s; 
	}
}
if(! function_exists('isValidatorDomain')){
	function isValidatorDomain($domain_row){
		$regexp = '/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/';
		$check_domain =  preg_match($regexp,$domain_row);
		return $check_domain;
	}
}
if(! function_exists('TmpCreateFileZone')){
	function TmpCreateFileZone($name_zone,$params){
	$file = "/var/named/uzone/$name_zone";
	$filenew = "/var/named/uzone/$name_zone.new";
		if(file_exists($filenew)){
			unlink($filenew);
			file_put_contents($filenew,print_r($params, TRUE)."\n", FILE_APPEND | LOCK_EX);
				if(file_exists($file)){
					unlink($file);
				}
			
			// copy($filenew, $filenewnamed);
			rename($filenew, $file);
			chown($file,"named");
			chmod($file,0777);
		}else{
			file_put_contents($filenew,print_r($params, TRUE)."\n", FILE_APPEND | LOCK_EX);
			if(file_exists($file)){
				unlink($file);
			}
			// copy($filenew, $filenewnamed);
			rename($filenew, $file);
			chown($file,"named");
			chmod($file,0777);
		}
	}
}
if(! function_exists('TmpRecord')){
	 function TmpRecord($response){
		$option = '';
		foreach($response as $respons){
		$type_record = (string)$respons["type_record"];
		$data_record = $respons["data_record"];
		$name_record = $respons["name_record"];
		$aux = (int)$respons["aux"];
		if($type_record == "A" || $type_record == 'AAAA'){
		$CheckDomain = isValidatorDomain($name_record);
		if($CheckDomain == 1){
		$option .= "\n$name_record.   IN   A  $data_record\n";
		}else{
		$option .= "\n$name_record   IN    A   $data_record\n";
		}
		}
		if($type_record == 'RURL'){
		$option .= "@   IN   A   123.16.190.157\n";
		}
		if($type_record == 'RURL'){
		$option .= "@    IN   A   123.16.190.157\n";
		
		$option .= "www    IN   A   123.16.190.157\n";
		}
		if($type_record == 'IURL'){
		$option .= "@   IN   A   123.16.190.157\n";
		
		$option .= "www    IN   A   123.16.190.157\n";
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
}
if(! function_exists('TmpSOAdefault')){
		function TmpSOAdefault($name_zone){
		$serial = time();
		$option = '$TTL 3600';
		$option .="\n@	IN SOA	root.udns.asia root.$name_zone. (
		$serial	; serial
		3600	; refresh
		3600	; retry
		84600	; expire
		3600 )	; minimum
		";
		$option .= "\n$name_zone.   IN  NS    ns1.udns.asia. \n";
		$option .= "\n$name_zone.   IN  NS    ns2.udns.asia. \n";
		$option .= "\n$name_zone.   IN  NS    ns3.udns.asia. \n";
		return $option;
		}
}
/////////////////////////////////////
if(! function_exists('core_encrypt_convert')){
	function core_encrypt_convert($string){
		$ci = &get_instance();
		$ci->load->library('encrypt');
		$param = json_encode($string);
			return $ci->encrypt->encode($param);
	}
}
/////////////////////////////////////
if(! function_exists('core_decrypt_convert')){
	function core_decrypt_convert($string){
		$ci = &get_instance();
		$ci->load->library('encrypt');
		$params =  $ci->encrypt->decode($string);
			return json_decode($params);
	}
}

if(! function_exists('random_auth_core')){
    function random_auth_core(){
		$length = 12;
		$lengthc = 16;
		$randoms = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		$randomc = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $lengthc);
		$username = "AT-".$randomc.time().$randoms;
		return $username;
    }
  }
/////////////////////////////////////
// if(! function_exists('validate_label_domain')){
	// function validate_label_domain($label){
		// if (!$label) {
			// return 'You must enter a domain name';
		// }
		// if (strlen($label) > 63) {
			// return 'Total lenght of your domain must be less then 63 characters';
		// }
		// if (strlen($label) < 2) {
			// return 'Total lenght of your domain must be greater then 2 characters';
		// }
		// if (preg_match("/[^A-Z0-9\-]/",$label) {
			// return 'Invalid domain name format';
		// }
		// if (preg_match("/^xn--/",$label) {
			// if (preg_match("/^-|-$|\.$/",$label) {
				// return 'Invalid domain name format, cannot begin or end with a hyphen (-)';
			// }
		// }
		// else {
			// if (preg_match("/^-|--|-$|\.$/",$label) {
				// return 'Invalid domain name format, cannot begin or end with a hyphen (-)';
			// }
		// }
	// }
// }

if(! function_exists('debug')){
	function debug($array){
		echo '<pre>';
			print_r($array);
		echo '</pre>';
	}
}
/////////////////////////////////////
if(! function_exists('debug_dump')){
	function debug_dump($array){
		echo '<pre>';
			var_dump($array);
		echo '</pre>';
	}
}
/////////////////////////////////////
if(! function_exists('core_token_csrf')){
	function core_token_csrf(){
		$ci = &get_instance();
			return $ci->security->get_csrf_hash();
	}
}
/////////////////////////////////////
if(! function_exists('core_csrf_name')){
	function core_csrf_name(){
		$ci = &get_instance();
			return $ci->security->get_csrf_token_name();
	}
}
/////////////////////////////////////
if(! function_exists('core_encode')){
	function core_encode($str){
		$encode_str = urlencode(base64_encode(core_encrypt($str)));
			return $encode_str;
	}
}
/////////////////////////////////////
if(! function_exists('core_decode')){
	function core_decode($str){
		$decode_str = core_decrypt(base64_decode(urldecode($str)));
			return $decode_str;
	}
}
/////////////////////////////////////
if(! function_exists('url_base64_encode')){
	function url_base64_encode($str){
		return urlencode(base64_encode($str));
	}
}
/////////////////////////////////////
if(! function_exists('url_base64_decode')){
	function url_base64_decode($str){
		return base64_decode(urldecode($str));
	}
}
/////////////////////////////////////
if(! function_exists('core_encrypt')){
	function core_encrypt($string){
		$ci = &get_instance();
		$ci->load->library('encrypt');
			return $ci->encrypt->encode($string);
	}
}
/////////////////////////////////////
if(! function_exists('core_decrypt')){
	function core_decrypt($string){
		$ci = &get_instance();
		$ci->load->library('encrypt');
			return $ci->encrypt->decode($string);
	}
}
/////////////////////////////////////
if(! function_exists('core_path_logs')){
	function core_path_logs($directory){
		$dir = FCPATH .'/logs/'.$directory.'/'.date('Y'). '/' . date('m'). '/' . date('d');
		$create_path_month = FCPATH .'/logs/'.$directory.'/'.date('Y'). '/' . date('m');
		$create_path_years = FCPATH .'/logs/'.$directory.'/'.date('Y');
		if(!is_dir($dir)){
			umask(0);
			mkdir($dir, 0777, true);
				return $dir;
		}else{
			umask(0);
				return $dir;
		}
	}
}
if ( ! function_exists('log_convert')){
	function log_convert($file,$msg = null) {
		file_put_contents("/var/www/clients/client0/web1/web/mingrate_cpanel/".$file.".txt", print_r($msg, TRUE)."\n", FILE_APPEND | LOCK_EX);
	}
}
/////////////////////////////////////
if ( ! function_exists('core_logs_mingrate')){
	function core_logs_mingrate($msg = null) {
		
		$logs_handesk = $msg;
		file_put_contents("/var/www/clients/client0/web1/web/mingrate_cpanel/log_zone_account.txt", print_r($logs_handesk, TRUE)."\n", FILE_APPEND | LOCK_EX);
	}
}
/////////////////////////////////////
if ( ! function_exists('core_logs')){
	function core_logs($msg = null) {
		$ci = & get_instance();
		$logs_handesk = array(
			'header' => $ci->session->all_userdata(),
			'content' => $msg,
		);
		file_put_contents(core_path_logs($ci->router->fetch_class()).'/'.$ci->router->fetch_method().'-'.date("d-m-Y",time()).".txt", date("d/m/Y H:i:s",time()).": ".print_r($logs_handesk, TRUE)."\n", FILE_APPEND | LOCK_EX);
	}
}
<?php
class Service extends MY_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('rest');
		$this->conf = $config = array('server' => 'http://192.168.1.221/apps',
			'api_key'         => 'ureg1234567890@@',
			'api_name'        => 'app_key',
		);
	}
	private function update_task($id_task,$namespace){
		try{
			$params =	array(
				'status' => $namespace,
				'date_process' => date("Y-m-d-H:i:s A",time()),
				
			);
			$update_zone =	$this->mongo_db->where(array('_id'=>  new \MongoId($id_task)))->set($params)->update('ureg_task_process');
		}catch (Exception $e) {
			
		}
	}
	private function update_monitor($status){
		$id_monitor = "5a12b1387d57140e4c806695";
		try{
			$params =	array(
				'status' => $status,
			);
			$update_zone =	$this->mongo_db->where(array('_id'=>  new \MongoId($id_monitor)))->set($params)->update('ureg_monitor');
		}catch (Exception $e) {
			
		}
	}
	private function GetInfoZone($id_zone){
		try{
			$result = $this->mongo_db->get_where('ureg_zone', array('_id' => new \MongoId($id_zone)));
			return $result;
		}catch (Exception $e) {
			return null;
		}
	}
	private function GetInfoRecordOfZone($id_zone){
		try{
			$result = $this->mongo_db->get_where('ureg_zone_record', array('id_zone' => $id_zone));
			return $result;
		}catch (Exception $e) {
			return null;
		}
	}
	private function punny_code($domain_name){
		mb_internal_encoding('utf-8');
		$Punycode = new Idna_convert();
		$domain_name_space = $Punycode->encode($domain_name);
		return $domain_name_space;
	}
	public function monitor(){
		$result = $this->mongo_db->where(array('status' => 1))->get('ureg_monitor');
		if(!empty($result)){
			$this->update_monitor(0);
			shell_exec("/var/named/ssh/master_dns.sh");
			$command = 'rndc reload';
			exec($command);
		}
	}
	public function check_zonefile($zone_name){
		$check = shell_exec("named-checkzone -j $zone_name /var/named/uzone/$zone_name");
		var_dump($check);
		// if($check=="OK"){
			// echo "TRUE";
		// }else{
			// echo "COMMAND FALSE";
		// }
	}
	public function task(){
		$tmpZoneFile = '';
		$result = $this->mongo_db->where(array('status' => 1))->get('ureg_task_process');
		if(!empty($result)){
			foreach($result as $reponse){
				$id_task = (string)$reponse["_id"];
				if(!empty($reponse["params"])){
					if(!empty($reponse["params"]["id_zone"])){
						$id_zone = $reponse["params"]["id_zone"];
						$ReponseInfoZone = $this->GetInfoZone($id_zone);
						if(!empty($ReponseInfoZone)){
							$name_zone = $this->punny_code($ReponseInfoZone[0]["name_zone"]);
							$SOAtmp = TmpSOAdefault($name_zone);
							$ReponseInfoRecordOfZone = $this->GetInfoRecordOfZone($id_zone);
							if(!empty($ReponseInfoRecordOfZone)){
								$ZoneRecordtmp = TmpRecord($ReponseInfoRecordOfZone);
								$tmpZoneFile = $SOAtmp;
								$tmpZoneFile .= $ZoneRecordtmp;
								TmpCreateFileZone($name_zone,$tmpZoneFile);
								$this->update_task($id_task,0);
								
							}else{
								$tmpZoneFile = $SOAtmp;
								TmpCreateFileZone($name_zone,$tmpZoneFile);
								$this->update_task($id_task,0);
							}
						}else{
							$this->update_task($id_task,0);
						}
						
					}
				}
			}
			$this->update_monitor(1);
		}
		
	}
	
}
?>
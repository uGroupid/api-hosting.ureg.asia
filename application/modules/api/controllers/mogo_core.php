<?php
class Mogo_core extends MY_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('rest');
		//$this->load->model('global_model', 'GlobalMD');	
		$this->conf = $config = array('server' => 'http://register.vn/apps',
			'api_key'         => '800f5dd9c89fb4c96db5837c893c1010',
			'api_name'        => 'app_key',
		);
	}
	
	

	
	public function test_update(){
		$id = "5999d61c45fbbed1233e1dca";
		$params = array(
			'domain_config' => 'http://cpanel.it.vn',
			'ip_addresses' => '113.190.247.18',
		);
		// $this->mongo_db->update('',$params);
		// $update =  $this->mongo_db->where(array('_id' =>$id)->set($params)->update('');
		$update = $this->mongo_db->where(array('_id' => new \MongoId($id)))->set($params)->update('ureg_api_keys');
		var_dump($update);
	}
	public function create_administrator_key(){
		$this->mongo_db->delete_all('ureg_api_keys');	
		$params = array(
			'user_id' => '0',
			'key' => 'handesk1234567890@@',
			'level' => 0,
			'ignore_limits' => 0,
			'is_private_key' => 0,
			'ip_addresses' => '1.55.164.1',
			'date_created' => date("Y-m-d h:i:s",time()),
			'id_reseller' => "59995d7745fbbed1233e1db3",
		);
		$intall_tabl_key_api = $this->mongo_db->insert('ureg_api_keys', $params);	
		echo $intall_tabl_key_api;
	}
	public function truncate_ureg_zone(){
		$this->mongo_db->delete_all('ureg_zone');
	}
	public function truncate_ureg_zone_record(){
		$this->mongo_db->delete_all('ureg_zone_record');
	}
	
	public function truncate_ureg_users(){
		$this->mongo_db->delete_all('ureg_users');
	}
	
	public function truncate_ureg_api_keys(){
			// $this->mongo_db->delete_all('ureg_api_keys');
		 $this->mongo_db->delete_all('ureg_api_limits');
		 $this->mongo_db->delete_all('ureg_api_logs');
	}
	public function create_table_resseller(){
		$params = array(
			array('name_reseller'=> 'ureg'),
			array('name_reseller'=> 'dotvn'),
		);
		$intall_tabl_level = $this->mongo_db->batch_insert('ureg_reseller', $params);
		if($intall_tabl_level==true){
			$reponse_level = $this->mongo_db->get('ureg_reseller');
			var_dump($reponse_level);
		}
	}

	public function create_table_level(){
		$truncate = $this->truncate_table_level();
		if($truncate==true){
			$params = array(
				array('name_levels'=> 'admin','id_levels'=>99),
				array('name_levels'=> 'monitor','id_levels'=>2),
				array('name_levels'=> 'customer','id_levels'=>0),
				array('name_levels'=> 'reseller','id_levels'=>1),
			);
			$intall_tabl_level = $this->mongo_db->batch_insert('ureg_level', $params);
			if($intall_tabl_level==true){
				$reponse_level = $this->mongo_db->get('ureg_level');
				var_dump($reponse_level);
			}
		}
	}
	public function truncate_table_logs(){
		return $this->mongo_db->delete_all('ureg_api_logs');
	}	
	private function truncate_table_level(){
		// deletel all row ureg_level or truncate all table ureg_level //
		return $this->mongo_db->delete_all('ureg_level');
	}
}
?>
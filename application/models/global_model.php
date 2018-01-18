<?php

class Global_model extends CI_Model{
		function __construct(){
			parent::__construct();
				$this->load->driver('cache');
	}
	public function country(){
		$sql = "SELECT * FROM `hk_country`"; 
		$query = $this->db->query($sql);
          return $query->result_array();
	}
	public function vat_percent(){
		$sql = "SELECT * FROM `hk_vat_percent`"; 
		$query = $this->db->query($sql);
          return $query->result_array();
	}
	
	public function query_global($sql){
     $query = $this->db->query($sql);
          return $query->result_array();
	}
	public function update_notify($data,$id){
		$this->db->where('id', $id);
		$this->db->update('hitek_jobs_monitor', $data); 
		return true;
	}
	
	function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('hitek_jobs_domain_notify');
        $this->db->order_by('id','desc');
		$this->db->where('epp', 0);
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }
	public function update_domain_sync($domain_id){
		$CI = &get_instance();
		$this->db2 = $CI->load->database('dbold', TRUE);
		$data = array(
			'snapshort' => 1,
		);
		$this->db2->where('domain_id', $domain_id);
		$this->db2->update('tbl_domain', $data); 
	}
	public function query_global_domain($sql){
	  $CI = &get_instance();
		$this->db2 = $CI->load->database('dbold', TRUE);
     $query = $this->db2->query($sql);
          return $query->result_array();
	}
/////////////////// End Noi dung ////////////

}
?>
<?php

class Global_model extends CI_Model{
	public $auth;
	function __construct(){
		parent::__construct();
		$this->load->driver('cache');
		$this->consumer_key = CONSUMER_KEY();
		$this->consumer_secret = CONSUMER_SECRET();
		$this->consumer_ttl = CONSUMER_TTL();
		$this->auth = false;
	}
	
	public function query_global($sql){
     $query = $this->db->query($sql);
          return $query->result_array();
	}
	
	public function validate($token)
    {
        try {
            $decodeToken = $this->jwt->decode($token, $this->consumer_secret);
            $ttl_time = strtotime($decodeToken->expires_in);
            $now_time = strtotime(date(DATE_ISO8601, strtotime("now")));
            if(($now_time - $ttl_time) > $decodeToken->ttl) {
				 return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
	public function decode($token)
    {
        try{
            $decodeToken = $this->jwt->decode($token, $this->consumer_secret);
            return $decodeToken;
        }catch (Exception $e) {
            return false;
        }
    }
	public function Initialize_Token($uid,$param){
		if(isset($uid)){
			if(!empty($uid)){
				$this->auth = true;
			}
		}
       $token = $this->jwt->encode(array(
            'key' => $this->consumer_secret,
            'uid' => $uid,
            'param' => $param,
            'auth' => $this->auth,
            'expires_in' => date(DATE_ISO8601, strtotime("now")),
            'ttl' => $this->consumer_ttl,
        ), $this->consumer_secret);
        return $token;
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
	
/////////////////// End Noi dung ////////////

}
?>
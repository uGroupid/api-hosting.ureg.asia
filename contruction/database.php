<?php 
class Database_contruct {
    public function cfg_role_server(){
        $params = array(
            array('name_role_server' => 'Linux Centos [ISP Control Panel]',),
            array('name_role_server' => 'Java [BlueOneyx Control Panel]',),
            array('name_role_server' => 'Windown 2008 [Plesk Control Panel]',),
        );
        return json_encode($params,true);
    }

    public function host_cfg_server(){
        $params = array(
            array(
                array(
                    'label_server' => 'VPS1',
                    'name_server' => '192.168.1.221',
                    'ip_server' => '192.168.1.221',
                    'username' => '192.168.1.221',
                    'password' => '192.168.1.221',
                    'soap_uri' => '192.168.1.221',
                    'soap_location' => '192.168.1.221',
                    'role_server' => '192.168.1.221',
                ),
            ),  
        );
        return json_encode($params,true);
    }
    public function host_service(){
        $params = array(
            array(
                'NameService',
                'Price',
                'đ/tháng',
                'Discount',
                'SaleOff',
            ),
        );
    }
    public function host_package(){

    }
}
?>
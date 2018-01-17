<?php 
class Database_contruct {
    public function cfg_role_server(
        $params = array(
            array('name_role_server' => 'Linux Centos [ISP Control Panel]',),
            array('name_role_server' => 'Java [BlueOneyx Control Panel]',),
            array('name_role_server' => 'Windown 2008 [Plesk Control Panel]',),
        );
        return json_encode($params,true);
    );

    public function host_server();
    public function host_service();
    public function host_package();
}
?>
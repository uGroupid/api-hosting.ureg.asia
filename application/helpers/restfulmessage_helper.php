<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(! function_exists('api_message')){
	function api_message($i){
		switch ($i) {
			case 00:
				return array(
					'code' => 00,
					'msg' => 'Thành công',
				);
				break;
			case 99:
				return array(
					'code' => 99,
					'msg' => 'Thất bại',
				);
				break;
			case 2:
				echo "i equals 2";
				break;
		}
	}
}
//////////////////////////////////////

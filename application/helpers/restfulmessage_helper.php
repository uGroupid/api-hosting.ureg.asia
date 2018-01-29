<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(! function_exists('api_message')){
	function api_message($i){
		switch ($i) {
			case 00:
				return array(
					'code' => 00,
					'msg' => 'Command Successful Transaction',
				);
				break;
			case 99:
				return array(
					'code' => 99,
					'msg' => 'Command Transaction Failed',
				);
				break;
			case 01:
				return array(
					'code' => 01,
					'msg' => 'Command Syntax Error',
				);
				break;
			case 02:
				return array(
					'code' => 02,
					'msg' => 'Token Syntax Error',
				);
				break;
			case 03:
				return array(
					'code' => 03,
					'msg' => 'Secret do not exist',
				);
				break;
			case 04:
				return array(
					'code' => 04,
					'msg' => 'keys do not exist',
				);
				break;
			case 05:
				return array(
					'code' => 05,
					'msg' => 'Token do not exist',
				);
				break;
			case 06:
				return array(
					'code' => 06,
					'msg' => 'Token has expired',
				);
				break;
			case 07:
				return array(
					'code' => 07,
					'msg' => 'username do not exist',
				);
				break;
			case 08:
				return array(
					'code' => 08,
					'msg' => 'password do not exist',
				);
				break;
			case 09:
				return array(
					'code' => 09,
					'msg' => 'Not authoritative access',
				);
				break;
			case 10:
				return array(
					'code' => 10,
					'msg' => 'Error Connect Server',
				);
				break;
			case 11:
				return array(
					'code' => 11,
					'msg' => 'Error Transaction Server',
				);
				break;
			case 12:
				return array(
					'code' => 12,
					'msg' => 'Server Command Syntax Error',
				);
				break;
		}
	}
}
//////////////////////////////////////

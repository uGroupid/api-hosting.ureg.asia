<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH .'/libraries/ISPConfig_Controller.php';
class Testcase extends ISPConfig_Controller {
	public $access_token;
	function __construct(){
		parent::__construct();
		$config =  array('server' => "http://id.ugroup.asia");
		$this->rest->initialize($config);
		$this->access_token = null;
	}
	
	public function index(){
		$param = array(
			'param' => json_encode(array(
				'username' => 'Reseller',
				'password' => '123123fF',
			)),
		);
		$response = $this->rest->get('token/create',$param);
		echo "<pre>";
			print_r($response);
		echo "</pre>";
		if(!empty($response->responses->result->data->access_token)){
			$param = array(
				'param' => json_encode(array(
					'access_token' => $response->responses->result->data->access_token,
				)),
			);
			$response = $this->rest->get('token/info',$param);
			echo "<pre>";
				print_r($response);
			echo "</pre>";
		}
	}
	
	public function info_token(){
		$param = array(
				'param' => json_encode(array(
					'access_token' => 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJrZXkiOiI5SkZrNTlUams5U2ROSjR6TjBOWkRCTmxEa1ZIenNvcnBKSm5JTXlxZmdya3l2NllyaFdlQjlhQXo2UUMiLCJpZF90b2tlbiI6IjVhOTNjYzVjNDVmYmJlNDE2ZDRjOTRmMyIsInVpZCI6IjVhN2NlMWQ2OGQyOTYxMmZmYzNhOWQ0NSIsInBhcmFtIjp7Il9pZCI6eyIkaWQiOiI1YTdjZTFkNjhkMjk2MTJmZmMzYTlkNDUifSwibmFtZSI6IlJlc2VsbGVyIiwiY29kZSI6IlJlc2VsbGVyMDAxIiwidXNlcm5hbWUiOiJSZXNlbGxlciIsImNvbnRhY3RfZGVmYXVsdHMiOnsiJGlkIjoiNWE3YzEyNWNlMDEzNWIwZjFhMDAwMDM3In0sImNvbnRhY3Rfb3duZXIiOnsiJGlkIjoiNWE3Y2RkMzQ4ZDI5NjEyZmZjM2E5Y2Y2In0sImNvbnRhY3RfYmlsbCI6eyIkaWQiOiI1YTdjZGQ5ZDhkMjk2MTJmZmMzYTljZjcifSwiY29udGFjdF90ZWNoIjp7IiRpZCI6IjVhN2NkZGFiOGQyOTYxMmZmYzNhOWNmOCJ9LCJjb250YWN0X2FkbWluIjp7IiRpZCI6IjVhN2NkZGIyOGQyOTYxMmZmYzNhOWNmOSJ9LCJjb250YWN0X21vZGVyYXRvciI6eyIkaWQiOiI1YTdjZGRiNjhkMjk2MTJmZmMzYTljZmEifSwiYmFsYW5jZXIiOjk5OTk5OTk5OSwic3RhdHVzIjoxLCJpZF9yZWxsIjp7IiRpZCI6IjVhN2MxMjVjZTAxMzViMGYxYTAwMDAzOCJ9fSwiZXhwaXJlc19pbiI6IjIwMTgtMDItMjZUMTc6NTk6MDkrMDcwMCIsInR0bCI6NzIwMH0.oqTuuAfcBH8kJL3TBEKJ3rUIiXOmk0vEsv259uFCFGU',
				)),
			);
			$response = $this->rest->get('token/info',$param);
			echo "<pre>";
				print_r($response);
			echo "</pre>";
	}
	public function info_check(){
		$param = array(
				'param' => json_encode(array(
					'access_token' => 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJrZXkiOiI5SkZrNTlUams5U2ROSjR6TjBOWkRCTmxEa1ZIenNvcnBKSm5JTXlxZmdya3l2NllyaFdlQjlhQXo2UUMiLCJpZF90b2tlbiI6IjVhOTNjYzVjNDVmYmJlNDE2ZDRjOTRmMyIsInVpZCI6IjVhN2NlMWQ2OGQyOTYxMmZmYzNhOWQ0NSIsInBhcmFtIjp7Il9pZCI6eyIkaWQiOiI1YTdjZTFkNjhkMjk2MTJmZmMzYTlkNDUifSwibmFtZSI6IlJlc2VsbGVyIiwiY29kZSI6IlJlc2VsbGVyMDAxIiwidXNlcm5hbWUiOiJSZXNlbGxlciIsImNvbnRhY3RfZGVmYXVsdHMiOnsiJGlkIjoiNWE3YzEyNWNlMDEzNWIwZjFhMDAwMDM3In0sImNvbnRhY3Rfb3duZXIiOnsiJGlkIjoiNWE3Y2RkMzQ4ZDI5NjEyZmZjM2E5Y2Y2In0sImNvbnRhY3RfYmlsbCI6eyIkaWQiOiI1YTdjZGQ5ZDhkMjk2MTJmZmMzYTljZjcifSwiY29udGFjdF90ZWNoIjp7IiRpZCI6IjVhN2NkZGFiOGQyOTYxMmZmYzNhOWNmOCJ9LCJjb250YWN0X2FkbWluIjp7IiRpZCI6IjVhN2NkZGIyOGQyOTYxMmZmYzNhOWNmOSJ9LCJjb250YWN0X21vZGVyYXRvciI6eyIkaWQiOiI1YTdjZGRiNjhkMjk2MTJmZmMzYTljZmEifSwiYmFsYW5jZXIiOjk5OTk5OTk5OSwic3RhdHVzIjoxLCJpZF9yZWxsIjp7IiRpZCI6IjVhN2MxMjVjZTAxMzViMGYxYTAwMDAzOCJ9fSwiZXhwaXJlc19pbiI6IjIwMTgtMDItMjZUMTc6NTk6MDkrMDcwMCIsInR0bCI6NzIwMH0.oqTuuAfcBH8kJL3TBEKJ3rUIiXOmk0vEsv259uFCFGU',
				)),
			);
			$response = $this->rest->get('token/check',$param);
			echo "<pre>";
				print_r($response);
			echo "</pre>";
	}
	
	
	public function contact_info(){
		$this->access_token =  'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJrZXkiOiI5SkZrNTlUams5U2ROSjR6TjBOWkRCTmxEa1ZIenNvcnBKSm5JTXlxZmdya3l2NllyaFdlQjlhQXo2UUMiLCJpZF90b2tlbiI6IjVhOTUwZWI0NDVmYmJlNDQ2ZDRjOTRmYyIsInVpZCI6IjVhN2NlMWQ2OGQyOTYxMmZmYzNhOWQ0NSIsInBhcmFtIjp7Il9pZCI6eyIkaWQiOiI1YTdjZTFkNjhkMjk2MTJmZmMzYTlkNDUifSwibmFtZSI6IlJlc2VsbGVyIiwiY29kZSI6IlJlc2VsbGVyMDAxIiwidXNlcm5hbWUiOiJSZXNlbGxlciIsImNvbnRhY3RfZGVmYXVsdHMiOnsiJGlkIjoiNWE3YzEyNWNlMDEzNWIwZjFhMDAwMDM3In0sImNvbnRhY3Rfb3duZXIiOnsiJGlkIjoiNWE3Y2RkMzQ4ZDI5NjEyZmZjM2E5Y2Y2In0sImNvbnRhY3RfYmlsbCI6eyIkaWQiOiI1YTdjZGQ5ZDhkMjk2MTJmZmMzYTljZjcifSwiY29udGFjdF90ZWNoIjp7IiRpZCI6IjVhN2NkZGFiOGQyOTYxMmZmYzNhOWNmOCJ9LCJjb250YWN0X2FkbWluIjp7IiRpZCI6IjVhN2NkZGIyOGQyOTYxMmZmYzNhOWNmOSJ9LCJjb250YWN0X21vZGVyYXRvciI6eyIkaWQiOiI1YTdjZGRiNjhkMjk2MTJmZmMzYTljZmEifSwiYmFsYW5jZXIiOjk5OTk5OTk5OSwic3RhdHVzIjoxLCJpZF9yZWxsIjp7IiRpZCI6IjVhN2MxMjVjZTAxMzViMGYxYTAwMDAzOCJ9fSwiZXhwaXJlc19pbiI6IjIwMTgtMDItMjdUMTY6NTQ6MjgrMDcwMCIsInR0bCI6NzIwMH0.rFYAA-GCOP1l2FjMExn9V_-CRc4Ni-9QGegHkxNdZ3s';
		$param = array(
			'access_token' => $this->access_token,
			'param' => json_encode(array(
				'contact_id' => '5a7cddb68d29612ffc3a9cfa',
			)),
		);
		$response = $this->rest->get('contact/info',$param);
		echo "<pre>";
			print_r($response);
		echo "</pre>";
	}
	
		
	
}

?>
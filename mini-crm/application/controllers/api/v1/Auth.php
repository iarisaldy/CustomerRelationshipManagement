<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Auth extends REST_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Model_login');
		date_default_timezone_set("Asia/Jakarta");
	}

	public function index_post(){
		$username = $this->post('username');
		$password = $this->post('password');

		$get_user = $this->Model_login->get_user($username, $password);
		if($get_user){
			$data = array();
			$date = new DateTime();
			$data['user_id'] = $get_user->USER_ID;
			$data['role_id'] = $get_user->ROLE_ID;
			$data['name'] = $get_user->NAME;
			$data['username'] = $get_user->USERNAME;
			$data['role'] = $get_user->ROLE_NAME;
			$data['iat'] = $date->format('U');
			$data['exp'] = $date->format('U') + 60*60*24*14;

			$output['token']  = AUTHORIZATION::generateToken($data);
			$this->response(array("status" => "success", "data" => $output));
		} else {
			$this->response(array("status" => "error", "message" => "Username / Password Anda Salah"));
		}
		
	}

	public function validate(){
		$date = new DateTime();
		$token = $this->input->get_request_header('token');
		if($token != NULL){
			$decodedToken = AUTHORIZATION::validateToken($token);
			$date_now = $date->format('U');
			if($decodedToken == true){
				if($date_now <= $decodedToken->exp){
					// $this->response(array("status" => "success", "data" => $decodedToken));
				} else {
					$this->response(array("status" => "expired", "message" => "Token is Expired"));
				}
			} else {
				$this->response(array("status" => "error", "message" => "Token Not Valid"));
			}
		} else {
			$this->response(array("status" => "error", "message" => "Token Not Found"));
		}
	}

	public function refresh_token_get(){
		$token = $this->input->get_request_header('token');
		if($token != NULL){
			$data = array();
			$date = new DateTime();
			$date_now = $date->format('U');

			$decodedToken = AUTHORIZATION::validateToken($token);

			if($date_now >= $decodedToken->exp){
				$this->response(array("status" => "expired", "message" => "Your Token is Expired"));
			} else {
				$data['user_id'] = $decodedToken->user_id;
				$data['role_id'] = $decodedToken->role_id;
				$data['name'] = $decodedToken->name;
				$data['username'] = $decodedToken->username;
				$data['role'] = $decodedToken->role;
				$data['iat'] = $date->format('U');
				$data['exp'] = $date->format('U') + 60*60*24*14;

				$output['token']  = AUTHORIZATION::generateToken($data);
				$this->response(array("status" => "success", "data" => $output));
			}
		} else {
			$this->response(array("status" => "error", "message" => "Token not found"));
		}
	}

	public function print_api($response){
		$content = $this->input->get_request_header('Content-Type');
		// echo $content;
		if($content == NULL){
			echo json_encode($response);
		} else if($content == "gzip" || $content == "application/gzip"){
			$data = gzcompress(json_encode($response));
			echo $data;
		} else {
			echo json_encode($response);
		}
	}
}

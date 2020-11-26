<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/helpers/authorization_helper.php';
require APPPATH . '/helpers/jwt_helper.php';

    class Auth extends REST_Controller {

        function __construct(){
            parent::__construct();
            date_default_timezone_set("Asia/Jakarta");
            $this->load->model('apis/Model_auth', 'mAuth');
        }

        public function index_post(){
            $username = $this->post("username");
            $password = $this->post("password");

            $checkUser = $this->mAuth->checkUser($username, $password);
			
            if($checkUser){
                $data = array();
                $date = new DateTime();
                $data['id_user'] 		= $checkUser->ID_USER;
                $data['nama'] 			= $checkUser->NAMA;
                $data['id_jenis_user'] 	= $checkUser->ID_JENIS_USER;
                $data['jenis_user'] 	= $checkUser->JENIS_USER;
				$data['email'] 			= $checkUser->EMAIL;
				$data['id_region'] 		= $checkUser->ID_REGION;
				
				$data['area']			= $this->mAuth->User_area($checkUser->ID_USER);
				$data['provinsi']		= $this->mAuth->User_provinsi($checkUser->ID_USER);
				$data['distributor'] 	= $this->mAuth->User_distributor($checkUser->ID_USER);
                
				//penambahan cek user SBI atau SMI
                if ($checkUser->ID_JENIS_USER == 1003){
                    $data['jenis_sales'] = 'SMI';
                } else {
                    $data['jenis_sales'] = 'SBI';
                }
				
                $data['iat'] = $date->format('U') + 60;
                $data['exp'] = $date->format('U') + 60*60*24*14;
				
				$output['token']  = AUTHORIZATION::generateToken($data);

                $this->response(array("status" => "success", "data" => $output));
            } else {
                $this->response(array("status" => "error", "message" => "Username / Password Anda Salah"));
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
                    $data['id_user'] = $decodedToken->id_user;
                    $data['nama'] = $decodedToken->nama;
                    $data['id_jenis_user'] = $decodedToken->id_jenis_user;
                    $data['jenis_user'] = $decodedToken->jenis_user;
                    $data['email'] = $decodedToken->email;
                    $data['id_region'] = $decodedToken->id_region;

                    $data['area'] = $decodedToken->area;
                    $data['provinsi'] = $decodedToken->provinsi;
                    $data['distributor'] = $decodedToken->distributor;
                    
                    //penambahan cek user SBI atau SMI
                    if ($checkUser->ID_JENIS_USER == 1003){
                        $data['jenis_sales'] = 'SMI';
                    } else {
                        $data['jenis_sales'] = 'SBI';
                    }

                    $data['iat'] = $date->format('U');
                    $data['exp'] = $date->format('U') + 60*60*24*14;

                    $output['token']  = AUTHORIZATION::generateToken($data);
                    $this->response(array("status" => "success", "data" => $output));
                }
            } else {
                $this->response(array("status" => "error", "message" => "Token not found"));
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

    }
?>
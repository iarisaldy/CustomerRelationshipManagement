<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/helpers/authorization_helper.php';
require APPPATH . '/helpers/jwt_helper.php';

    class Token_access_crm extends REST_Controller {

        function __construct(){
            parent::__construct();
            date_default_timezone_set("Asia/Jakarta");
        }

        public function validasi(){
            $token = $this->input->get_request_header('token');
            if($token != NULL){
                if($token == "SUKSES"){
                   
                } else {
                    $this->response(array("status" => "error", "message" => "Token Not Valid"));
                }
            } else {
                $this->response(array("status" => "error", "message" => "Token Not Found"));
            }
        }

    }
	
?>
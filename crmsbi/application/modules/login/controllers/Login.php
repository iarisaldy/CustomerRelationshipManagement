<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('is_login')) {
            redirect('administrator/Home');
        }
    }

    function index($param = '') {
        if ($param == 'error') {
            $param = 'error';
        }
        $data = array('title' => 'Login', 'message' => $param, 'base_url' => base_url());
        $this->load->view('login_crm', $data);
    }

    function action(){
        $this->load->model('Login_model');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $checkUser = $this->Login_model->checkUser($username, $password);
        if($checkUser){
            if($checkUser->ID_JENIS_USER == "1002" || $checkUser->ID_JENIS_USER == "1005" || $checkUser->ID_JENIS_USER == "1003" || $checkUser->ID_JENIS_USER == "1007" || $checkUser->ID_JENIS_USER == "1004"){
                $checkUserDist = $this->Login_model->checkUserDistributor($checkUser->ID_USER);
                $userDist = array(
                    "kode_dist" => $checkUserDist->KODE_DISTRIBUTOR,
                    "nama_dist" => $checkUserDist->NAMA_DISTRIBUTOR
                );
                $this->session->set_userdata($userDist);
            }

            if($checkUser->ID_JENIS_USER == "1003" || $checkUser->ID_JENIS_USER == "1005" || $checkUser->ID_JENIS_USER == "1007"){
                $checkUserProv = $this->Login_model->checkUserProvinsi($checkUser->ID_USER);
                $userProv = array(
                    "id_provinsi" => $checkUserProv->ID_PROVINSI
                );
                $this->session->set_userdata($userProv);
            }

            $userData = array(
                "id_region" => $checkUser->ID_REGION,
                "user_id" => $checkUser->ID_USER,
                "name" => $checkUser->NAMA,
                "id_jenis_user" => $checkUser->ID_JENIS_USER,
                "jenis_user" => $checkUser->JENIS_USER,
                "is_login" => true
            );
            $this->session->set_userdata($userData);
            
            redirect('administrator/Home');
        } else {
            redirect('login/index/error');
        }        
    }
}

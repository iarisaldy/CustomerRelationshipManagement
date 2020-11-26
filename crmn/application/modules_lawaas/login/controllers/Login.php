<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('is_login')) {
            redirect('dashboard');
        }
    }

    function index($param = '') {
        if ($param == 'error') {
            $param = 'Username atau Password salah';
        }
        $data = array('title' => 'Login', 'message' => $param, 'base_url' => base_url());
        $this->load->view('login_view', $data);
    }

    function do_login() {
        $this->load->model('Login_model');
        $data = $this->input->post(null, true);
        $user = $data['username'];
        $pass = $data['password'];
        $username = $user . "@semenindonesia.com";

        $ldap['user'] = $user . "@smig.corp"; // di tambahn @semenindonesia
        if (empty($pass)) {
            $ldap['pass'] = $pass . 'aascs'; //biar error
        } else {
            $ldap['pass'] = $pass;
        }
        if (null !== $this->session->userdata('link')) {
            $link = $this->session->userdata('link');
        }

        //  print_r($ldap);
        $ldap['host'] = 'smig.corp';
        $ldap['port'] = 389;
        $ldap['conn'] = ldap_connect($ldap['host'], $ldap['port'])or die("Could not conenct to {$ldap['host']}");
        ldap_set_option($ldap['conn'], LDAP_OPT_PROTOCOL_VERSION, 3);
        @$ldap['bind'] = ldap_bind($ldap['conn'], $ldap['user'], $ldap['pass']);
        if ($ldap['bind']) {
            $data_karyawan = $this->Login_model->getDataKaryawan($username);
            $data_karyawan2 = $this->Login_model->getDataUser(strtolower($user));
            if (isset($data_karyawan)) {
                $opco = $this->cekOpco($data_karyawan->company);
                $session_set = array(
                    'is_login' => true,
                    'opco' => $opco,
                    'usernamescm' => $user,
                    'namalengkapscm' => $user,
                    'akses' => 0
                );
                if(isset($data_karyawan2)){
                    $opco = $this->cekOpco($data_karyawan2->COMPANY);
                    $session_set['akses'] = $data_karyawan2->AKSES;
                    $session_set['opco'] = $opco;
                }
                $this->Login_model->insertLoginHis($user,$data_karyawan->company,'Berhasil');
                $this->session->set_userdata($session_set);
            } else {
                $data_karyawan = $this->Login_model->getDataUser(strtolower($user));
                if (isset($data_karyawan)) {
                    $opco = $this->cekOpco($data_karyawan->COMPANY);
                    $session_set = array(
                        'is_login' => true,
                        'opco' => $opco,
                        'usernamescm' => $user,
                        'namalengkapscm' => $user,
                        'akses' => $data_karyawan->AKSES
                    );
                    $this->Login_model->insertLoginHis($user,$data_karyawan->COMPANY,'Berhasil');
                    $this->session->set_userdata($session_set);
                }else{
                    redirect('login/index/error');
                }
            }
            if(isset($link)){
                redirect($link);
            }else{
                redirect('dashboard');
            }
        } else {
            $this->Login_model->insertLoginHis($user,'0','Gagal');
            redirect('login/index/error');
        }
        ldap_close($ldap['conn']);
    }

    function cekOpco($opco){
        if($opco == '5000'){
            return '7000';
        }else{
            return $opco;
        }
    }
    function test(){
        //echo 'asdsac';
        $this->load->model('Login_model');
        $username = 'aunur.rosyidi';
        $data = $this->Login_model->getDataUser($username);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}

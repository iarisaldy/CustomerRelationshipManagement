<?php if(!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class StokTuban extends CI_Controller {
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('is_login'))redirect('login');
        $this->load->model('StokTuban_model');
    }
    
    function index(){
        $data = array('title'=>'Stok Tuban');
        $this->template->display('StokTuban_view',$data);
    }
}
<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');

class StokGresik extends CI_Controller {
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('is_login'))redirect('login');
        $this->load->model('StokGresik_model');
    }
    
    function index(){
        $data = array("title"=>"Stok Gresik");
        $this->template->display('StokGresik_view',$data);
    }
}
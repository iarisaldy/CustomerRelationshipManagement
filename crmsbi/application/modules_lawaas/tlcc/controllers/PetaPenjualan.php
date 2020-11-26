<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');

class PetaPenjualan extends CI_Controller {
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('is_login'))redirect('login');
    }
    
    function index(){
        $data = array("title"=>"Peta Penjualan");
        $this->template->display('PetaPenjualan_view',$data);
    }
}
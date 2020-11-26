<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');

class MarineTraffic extends CI_Controller {
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('is_login'))redirect('login');
    }
    
    function index(){
        $data = array('title'=>'Marine Traffic');
        $this->template->display('MarineTraffic_view',$data);
    }
    
    
}
<?php if(!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class StatusPabrik extends CI_Controller {
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('is_login'))redirect('login');
    }
    
    function index(){
        $data = array('title'=>'Status Pabrik');
        $this->template->display('StatusPabrik_view',$data);
    }
}
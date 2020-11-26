<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller{
	
	public function __construct(){
		
		parent::__construct();
		$this->load->model('Logout_model');
	}
	
	public function index(){		
		// $username = $this->session->userdata('usernamescm');
		// $this->Logout_model->updateLoginHis($username);
		$this->session->sess_destroy();
		redirect('login');
	}


}

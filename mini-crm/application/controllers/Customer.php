<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	function __construct(){
		parent::__construct();
    }

    public function index(){
    	// $this->load->view('vtemplate');
        $this->template->load('vtemplate', 'vcustomer');
    }
}

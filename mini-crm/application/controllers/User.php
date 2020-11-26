<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
    }

    public function index(){
        $this->template->load('vtemplate', 'vuser');
    }

    public function add(){
    	$this->template->load('vtemplate', 'vuser-add');
    }

    public function edit(){
    	$this->template->load('vtemplate', 'vuser-edit');
    }
}

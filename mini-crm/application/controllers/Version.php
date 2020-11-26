<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Version extends CI_Controller {

	function __construct(){
		parent::__construct();
    }

    public function index(){
        $this->template->load('vtemplate', 'vversion');
    }

    public function add(){
        $this->template->load('vtemplate', 'vversion-add');
    }

    public function edit($version_id){
        $this->template->load('vtemplate', 'vversion-edit');
    }

}

<?php
	class Koordinat_lock extends CI_Controller {

		public function __construct(){
			parent::__construct();
			//$this->load->model("Koordinat_lock_model", "KLM");
		}
		
		public function index(){
			$data = array("title" => "Dashboard CRM Administrator");
			
			$this->template->display('Koordinat_lock_view', $data);
		}
		
	}
?>
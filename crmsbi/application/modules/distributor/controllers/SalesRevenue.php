<?php
	/**
	 * 
	 */
	class SalesRevenue extends CI_Controller{
		
		function __construct(){
			parent::__construct();
		}

		public function index(){
			$data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('SalesRevenue_view', $data);
		}
	}
?>
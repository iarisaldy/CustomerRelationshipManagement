<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Monitoring extends CI_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->model('Monitoring_model');
    }
	
	public function index()
	{
		$data = array("title"=>"PMB Distributor");
		
		$data['dummys'] = $this->Monitoring_model->dummy_data();
		
		 //print_r($data['dummys']);
		 //exit();
		
		$this->template->display('Pmb_distributor_view', $data);
    }
	
	public function Salesman()
	{
		$data = array("title"=>"PMB Salesman");
		
		$data['dummys'] = $this->Monitoring_model->dummy_pmb_sales();
		$this->template->display('Pmb_sales_view', $data);
	}
	
	

}

?>
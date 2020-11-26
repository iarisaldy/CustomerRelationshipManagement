<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Mapping_customer_sales extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('apis/Mapping_customer_sales_model');
    } 
	
	public function index(){
		//echo "Cek i";
		$kd_customer = null;
		if(isset($this->input->post("kd_customer")){
			$kd_customer = $this->input->post("kd_customer");
		}
		$hasil = $this->Mapping_customer_sales_model->getMappingTokoSales();  
		echo json_encode($hasil);
	}

}

?>
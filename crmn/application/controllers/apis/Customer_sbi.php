<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Customer_sbi extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            //$this->load->model('apis/Model_customer', 'mCustomer');
			$this->load->model('apis/Model_customer_sbi', 'mCustomerSbi');
        }
		
		//API SBI get Sales SBI
		public function CustomerAllSbi_post(){
			//$id_sales = null;
			//if($this->input->post('id_sales') != null){
				$id_salesku = $this->input->post('id_sales');//$this->post('id_sales');
			//};
			
			echo $id_salesku;
			exit;
			
			$limit =null;
			if(isset($_POST['limit'])){
				$limit =$_POST['limit'];
			};
			
			$start =null;
			if(isset($_POST['start'])){
				$start =$_POST['start'];
			};
			
			//$id_salesku = 3254;
			
			$hasil = $this->mCustomerSbi->get_data_customer_sbi_full($id_salesku, $start, $limit);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Customer Tidak Ditemukan");
			}
			$this->response($response);
			
		}
		
	}

?>
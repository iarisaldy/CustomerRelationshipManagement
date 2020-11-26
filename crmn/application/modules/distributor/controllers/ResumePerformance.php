<?php
	/**
	 * 
	 */
	class ResumePerformance extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			
			$this->load->model('Model_PerformanceSales');
		}

		public function index(){
			$data = array("title"=>"Dashboard CRM Administrator");
			
			if(isset($_POST['Tahun'])){
				$data['TAHUN'] = $_POST['Tahun'];
			}
			else {
				$data['TAHUN'] = date('Y');
			}
			
			$distributor = $this->session->userdata("kode_dist");
			$HARGA_JUAL_GET 		= $this->Model_PerformanceSales->get_data_harga_beli_distributor($distributor, $data['TAHUN']);
			$data['HARGA_JUAL'] 	= json_encode($HARGA_JUAL_GET);
			$Target_harga_beli 		= $this->Model_PerformanceSales->get_target_harga_beli_distributor($distributor, $data['TAHUN']);
			$data['TARGET_HARGA_JUAL'] 	= json_encode($Target_harga_beli);
			
			
			$VOLUME_JUAL_GET 			= $this->Model_PerformanceSales->get_data_volume_pertahun($distributor, $data['TAHUN']);
			$data['VOLUME_JUAL'] 		= json_encode($VOLUME_JUAL_GET);
			$target_volume 				= $this->Model_PerformanceSales->get_target_volume_distributor($distributor, $data['TAHUN']);
			$data['TARGET_VOLUME_JUAL'] = json_encode($target_volume);
			
			//print_r($target_volume);
			//exit;
			$TOTAL_PENJUALAN 		= $this->Model_PerformanceSales->get_data_harga_pertahun($distributor, $data['TAHUN']);
			$data['TOTAL_JUAL'] 	= json_encode($TOTAL_PENJUALAN);
			$target_penjualan 		= $this->Model_PerformanceSales->get_target_harga_jual_distributor($distributor, $data['TAHUN']);
			$data['TARGET_JUAL'] 	= json_encode($target_penjualan);
			
            $this->template->display('ResumePerformance_view', $data);
		}
	}
?>
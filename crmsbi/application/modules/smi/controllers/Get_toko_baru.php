<?php
	/**
	 * 
	 */
	class Get_toko_baru extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			
			$this->load->model('Get_customer_baru_model');
		}

		public function sales_bulanan(){
			$data = array("title"=>"Dashboard CRM Customer Retantion");

			$data['bulan']	= date('m');
			if(isset($_POST['filterBulan'])){
				$data['bulan'] = $_POST['filterBulan'];
			}

			$data['tahun']	= date('Y');
			if(isset($_POST['filterTahun'])){
				$data['tahun'] = $_POST['filterTahun'];
			}			
			

			$this->template->display('sales_bulanan', $data);
		}
		public function posting(){
			$data = array("title"=>"Dashboard CRM Customer Retantion");

			$data['bulan']	= date('m');
			if(isset($_POST['filterBulan'])){
				$data['bulan'] = $_POST['filterBulan'];
			}

			$data['tahun']	= date('Y');
			if(isset($_POST['filterTahun'])){
				$data['tahun'] = $_POST['filterTahun'];
			}			
			

			$this->template->display('posting', $data);
		}
		public function index(){

			$data = array("title"=>"Dashboard CRM Customer Retantion");

			//$hasil = $this->Get_customer_baru_model->Get_data_customer_baru_smi();
			//print_r($hasil);

			$data['data2017']	= $this->Get_customer_baru_model->Get_data_customer_baru_smi(2017);
			$data['data2018']	= $this->Get_customer_baru_model->Get_data_customer_baru_smi(2018);
			$data['data2019']	= $this->Get_customer_baru_model->Get_data_customer_baru_smi(2019);


			$data['Nondata2017']	= $this->Get_customer_baru_model->Get_data_customer_tidak_beli_smi(2017);
			$data['Nondata2018']	= $this->Get_customer_baru_model->Get_data_customer_tidak_beli_smi(2018);
			$data['Nondata2019']	= $this->Get_customer_baru_model->Get_data_customer_tidak_beli_smi(2019);
			
			
			$this->template->display('get_toko_baru_view', $data);

		}
		public function Distributor_cr(){
			$data = array("title"=>"Dashboard CRM Customer Retantion");

			//$hasil = $this->Get_customer_baru_model->Get_data_customer_baru_smi();
			//print_r($hasil);
			$distributor 	= $_SESSION['kode_dist'];

			$data['data2017']	= json_encode($this->Get_customer_baru_model->Get_data_customer_baru_smi(2017, $distributor));
			$data['data2018']	= json_encode($this->Get_customer_baru_model->Get_data_customer_baru_smi(2018, $distributor));
			$data['data2019']	= json_encode($this->Get_customer_baru_model->Get_data_customer_baru_smi(2019, $distributor));


			$data['Nondata2017']	= json_encode($this->Get_customer_baru_model->Get_data_customer_tidak_beli_smi(2017, $distributor));
			$data['Nondata2018']	= json_encode($this->Get_customer_baru_model->Get_data_customer_tidak_beli_smi(2018, $distributor));
			$data['Nondata2019']	= json_encode($this->Get_customer_baru_model->Get_data_customer_tidak_beli_smi(2019, $distributor));
			
			
			 $this->template->display('get_toko_baru_view', $data);			
		}
		public function Distributor_tb(){

			$data = array("title"=>"Dashboard CRM Customer Retantion");
			$distributor 	= $_SESSION['kode_dist'];

			$data['Get2017'] 	= json_encode($this->Get_customer_baru_model->toko_baru_bulanan(2017, $distributor));
			$data['Get2018'] 	= json_encode($this->Get_customer_baru_model->toko_baru_bulanan(2018, $distributor));
			$data['Get2019'] 	= json_encode($this->Get_customer_baru_model->toko_baru_bulanan(2019, $distributor));

			$data_tahunan = $this->Get_customer_baru_model->toko_baru_tahunan($distributor);
			$tahunan = array();
			$tahunan[0]['LABEL']=$data_tahunan[1]['TAHUN'];
			$tahunan[0]['VALUE']=$data_tahunan[0]['JML_PERTUMBUHAN']+$data_tahunan[1]['JML_PERTUMBUHAN'];
			$tahunan[1]['LABEL']=$data_tahunan[2]['TAHUN'];
			$tahunan[1]['VALUE']=$tahunan[0]['VALUE']+$data_tahunan[2]['JML_PERTUMBUHAN'];
			$tahunan[2]['LABEL']=$data_tahunan[3]['TAHUN'];
			$tahunan[2]['VALUE']=$tahunan[1]['VALUE']+$data_tahunan[3]['JML_PERTUMBUHAN'];
			$data['toko_smi']	= json_encode($tahunan);

			$pertumbuhan = array();
			$pertumbuhan[0]['LABEL']=$data_tahunan[1]['TAHUN'];
			$pertumbuhan[0]['VALUE']=$data_tahunan[1]['JML_PERTUMBUHAN'];
			$pertumbuhan[1]['LABEL']=$data_tahunan[2]['TAHUN'];
			$pertumbuhan[1]['VALUE']=$data_tahunan[2]['JML_PERTUMBUHAN'];
			$pertumbuhan[2]['LABEL']=$data_tahunan[3]['TAHUN'];
			$pertumbuhan[2]['VALUE']=$data_tahunan[3]['JML_PERTUMBUHAN'];
			$data['pertumbuhan_toko'] = json_encode($pertumbuhan);
			//print_r($data['2017']);

			$this->template->display('toko_baru_distributor', $data);
		}
		public function Toko_baru(){

			$data = array("title"=>"Dashboard CRM Customer Retantion");

			//$PROV = $this->Get_customer_baru_model->Get_provinsi();
			//print_r($PROV);

			$data['Get2017'] 	= $this->Get_customer_baru_model->toko_baru_bulanan(2017);
			$data['Get2018'] 	= $this->Get_customer_baru_model->toko_baru_bulanan(2018);
			$data['Get2019'] 	= $this->Get_customer_baru_model->toko_baru_bulanan(2019);

			$data_tahunan = $this->Get_customer_baru_model->toko_baru_tahunan();
			$tahunan = array();
			$tahunan[0]['LABEL']=$data_tahunan[1]['TAHUN'];
			$tahunan[0]['VALUE']=$data_tahunan[0]['JML_PERTUMBUHAN']+$data_tahunan[1]['JML_PERTUMBUHAN'];
			$tahunan[1]['LABEL']=$data_tahunan[2]['TAHUN'];
			$tahunan[1]['VALUE']=$tahunan[0]['VALUE']+$data_tahunan[2]['JML_PERTUMBUHAN'];
			$tahunan[2]['LABEL']=$data_tahunan[3]['TAHUN'];
			$tahunan[2]['VALUE']=$tahunan[1]['VALUE']+$data_tahunan[3]['JML_PERTUMBUHAN'];
			$data['toko_smi']	= json_encode($tahunan);

			$pertumbuhan = array();
			$pertumbuhan[0]['LABEL']=$data_tahunan[1]['TAHUN'];
			$pertumbuhan[0]['VALUE']=$data_tahunan[1]['JML_PERTUMBUHAN'];
			$pertumbuhan[1]['LABEL']=$data_tahunan[2]['TAHUN'];
			$pertumbuhan[1]['VALUE']=$data_tahunan[2]['JML_PERTUMBUHAN'];
			$pertumbuhan[2]['LABEL']=$data_tahunan[3]['TAHUN'];
			$pertumbuhan[2]['VALUE']=$data_tahunan[3]['JML_PERTUMBUHAN'];
			$data['pertumbuhan_toko'] = json_encode($pertumbuhan);
			//print_r($data['2017']);

			$this->template->display('toko_baru', $data);
		}

		private function make_option_prov($data){
			
			foreach ($data as $d) {
				# code...
			}
		}
	}
?>
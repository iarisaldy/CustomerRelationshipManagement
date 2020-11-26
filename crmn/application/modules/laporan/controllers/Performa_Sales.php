<?php

	class Performa_Sales extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->load->model("Performa_Sales_model");
		}

		public function index(){
			$data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('Performa_Sales_TSO', $data);
		}
		
		public function ASM(){
			$data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('Performa_Sales_ASM', $data);
		}
		
		public function RSM(){
			$data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('Performa_Sales_RSM', $data);
		}
		
		public function DIS(){
			$data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('Performa_Sales_DIS', $data);
		}

		public function GetData_TSO(){	
		$tso 			= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Performa_Sales_model->get_data_performa_tso($bulan ,$tahun ,$tso);
		
			
		echo json_encode($hasil);
		}
		
		public function GetData_ASM(){	
		$asm 			= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Performa_Sales_model->get_data_performa_asm($bulan ,$tahun ,$asm);
			
		echo json_encode($hasil);
		}
		
		public function GetData_RSM(){	
		$rsm 			= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Performa_Sales_model->get_data_performa_rsm($bulan ,$tahun ,$rsm);
			
		echo json_encode($hasil);
		}
		
		public function GetData_DIS(){
		$id_user 		= $this->session->userdata('user_id');
		$kode_dis		= $this->Performa_Sales_model->get_kode_dis($id_user);
		
		$id_dis = '';
		$c=1;
		foreach($kode_dis as $dis){
			if(count($kode_dis)>$c){
				$id_dis .= "". $dis['KODE_DISTRIBUTOR'].",";
			}
			else {
				$id_dis .= "". $dis['KODE_DISTRIBUTOR']."";
			}
			$c=$c+1;
		}
		
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Performa_Sales_model->get_data_performa_dis($bulan ,$tahun ,$id_dis);
			
		echo json_encode($hasil);
		}
		
		public function GetData_Persales(){	
		$id 		= $this->input->post("id");
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Performa_Sales_model->GrafikKunjungan($id, $bulan, $tahun);
		
		$data = array();
		foreach ($hasil as $h) {
			array_push($data, 
				array (
					'label' => $h['TANGGAL'],
				)
			);
		}
		$target = array();
		foreach ($hasil as $h) {
			array_push($target, 
				array (
					'value' => $h['TARGET']
				)
			);
		}
		$realisasi = array();
		foreach ($hasil as $h) {
			array_push($realisasi, 
				array (
					'value' => $h['REALISASI']
				)
			);
		}
			
		echo json_encode(array("status" => "success", "data" => $data , "target" => $target , "realisasi" => $realisasi));
		}

	}
?>
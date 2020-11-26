<?php

	class Coba extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->load->model("Coba_m");
		}

		public function index(){
			$data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('Coba_v', $data);
		}
		
		public function r(){
			//echo "aaa";
			$hasil			= $this->Coba_m->h();
			foreach($hasil as $h){
				$a1=$h['KAPASITAS_ZAK'];
				$a2=$h['KAPASITAS_TON'];
				$a3=$h['ID_CUSTOMER'];
				
				echo "UPDATE CRMNEW_CUSTOMER77
						SET KAPASITAS_TOKO='".$a1."',
						KAPASITAS_JUAL='".$a2."',
						IS_UPDATE='1'
						WHERE KODE_CUSTOMER='".$a3."' ; ";
				echo "</br>";
			}
			
			//print_r($hasil);
			
		}
		

		public function GetData_TSO(){	
		$tso 			= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
			
		$hasil			= $this->Coba_m->get_data_performa_tso($bulan ,$tahun ,$tso);
		
		echo json_encode($hasil);
		}
		
		
		public function GetData_Persales(){	
		$id_user 		= $this->input->post("id");
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
			
		$hasil			= $this->Coba_m->GrafikKunjungan($id_user, $bulan, $tahun);
		
			$data = array();
			foreach ($hasil as $h) {
				array_push($data, 
					array (
						number_format($h['TANGGAL'])
					)
				);
			}
			
			$target = array();
			foreach ($hasil as $h) {
				array_push($target, 
					array (
						number_format($h['TARGET'])
					)
				);
			}
			
			$realisasi = array();
			foreach ($hasil as $h) {
				array_push($realisasi, 
					array (
						number_format($h['REALISASI'])
					)
				);
			}
			
			echo json_encode(array('data' => $data , 'target' => $target , 'realisasi' => $realisasi),JSON_NUMERIC_CHECK);
		}
		
		public function GetData_GAP(){	
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
			
		$hasil			= $this->Coba_m->PieDiagram($id_user, $bulan, $tahun);
		
		$Gap = array();
		foreach ($hasil as $h){
			array_push($Gap, 
				array (
					'name' => 'Toko Yang Sudah Dikunjungi',
					'y' => number_format($h['JUMLAHS'])
				)
			);
		}
		foreach ($hasil as $h){
			array_push($Gap, 
				array (
					'name' => 'Toko Yang Belum Dikunjungi',
					'y' => number_format($h['JUMLAH'])
				)
			);
		}
		
		$hasil2			= $this->Coba_m->PieDiagramTSO($id_user, $bulan, $tahun);
		
		$filk = array();
		foreach ($hasil2 as $h){
			array_push($filk, 
				array (
					'name' => 'Total Kunjungan',
					'y' => $h['REALISASI']
				)
			);
		}
		foreach ($hasil2 as $h){
			array_push($filk, 
				array (
					'name' => 'Belum Kunjungan',
					'y' => $h['GAP']
				)
			);
		}
		
		echo json_encode(array('data' => $Gap, 'Gap' => $filk),JSON_NUMERIC_CHECK);
		}

	}
?>
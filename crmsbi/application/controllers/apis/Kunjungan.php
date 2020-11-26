<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    require APPPATH . '/controllers/apis/Auth.php';

    class Kunjungan extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_kunjungan');
        }
		
		public function index_post(){
			
			$id_user 		= null; 
			if(isset($_POST['id_user'])){
				$id_user =$_POST['id_user'];
			};
			
			$tahun =null;
			if(isset($_POST['tahun'])){
				$tahun =$_POST['tahun'];
			};
			
			$bulan =null;
			if(isset($_POST['bulan'])){
				$bulan =$_POST['bulan'];
			};
			
			$hasil 	= $this->Model_kunjungan->get_data_jadwal_kunjungan($id_user, $tahun, $bulan);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Jadwal Kunjungan Tidak Ditemukan");
			}
			
			$this->response($response);
			
        }
		
		public function KeluhanPelanggan_get(){
			
			$hasil = $this->Model_kunjungan->get_data_keluhan_pelanggan();
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Keluhan Pelanggan Tidak Ditemukan");
			}
			
			$this->response($response);
		}
		
		public function ProgramPromosi_get(){
			
			
			$hasil = $this->Model_kunjungan->get_data_promosi();
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Promosi Tidak Ditemukan");
			}
			
			$this->response($response);
		}
		
		public function HasilSurveySales_post(){
			
			print_r($_POST);
			
			
		}
		public function JadwalKunjungan_post(){
			
			$id_user 		= null; 
			if(isset($_POST['id_user'])){
				$id_user =$_POST['id_user'];
			};
			
			$tgl =null;
			if(isset($_POST['tgl_kunjungan'])){
				$tgl =$_POST['tgl_kunjungan'];
				//$tgl = date('d-M-Y', strtotime($tgl));	
			};
			
			$hasil = $this->Model_kunjungan->get_jadwal_kunjungan($id_user, $tgl);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Jadwal Kunjungan Tidak Ditemukan");
			}
			
			$this->response($response);
			
		}

    }
?>
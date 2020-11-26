<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    require APPPATH . '/controllers/apis/Auth.php';

    class Mini extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Mini_model');
        }
		public function Dashboardsales_post(){
			$id_sales 	= $this->input->post('id_sales');
			$tahun 		= $this->input->post('year');
			$bulan 		= $this->input->post('month');
			
			$hasil = $this->Mini_model->get_customer_sales($id_sales, $tahun, $bulan);
			
			if($hasil){
				$response = array("status" => "success", "data" => $hasil);
			}
			else {
				 $response = array("status" => "error", "message" => "Data Tidak Ditemukan");
			}
			
			$this->response($response);
		}
		
		public function DashboardAM_post(){
			$id_user 	= $this->input->post('id_user');
			$tahun 		= $this->input->post('year');
			$bulan 		= $this->input->post('month');
			
			$hasil = $this->Mini_model->get_customer_AM($id_user, $tahun, $bulan);
			
			if($hasil){
				$response = array("status" => "success", "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "message" => "Data Tidak Ditemukan");
			}
			
			$this->response($response);
		}
		
		public function InsertOrder_post(){
			$id_user 	= $this->input->post("id_user");
			$data 		= json_decode($_POST['data'], true);
			
			$hasil = $this->Mini_model->Insert_order_survey($id_user, $data);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Jadwal Kunjungan Tidak Ditemukan");
			}
			$this->response($response);
			
		}
		public function UpdateOrder_post(){
			$id_user 	= $this->input->post("id_user");
			$data 		= json_decode($_POST['data'], true);
			
			$hasil = $this->Mini_model->Update_order_survey($id_user, $data);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Jadwal Kunjungan Tidak Ditemukan");
			}
			$this->response($response);
			
		}
		public function DeleteOrder_post(){
			$id_user 	= $this->input->post("id_user");
			$data 		= json_decode($_POST['data'], true);
			
			$hasil = $this->Mini_model->Delete_order_survey($id_user, $data);
						
			if($hasil){
				 $response = array("status" => "success", "message" => "Delete success");
			}
			else {
				 $response = array("status" => "error", "message" => "Data Gagal Dihapus");
			}
			
			$this->response($response);
			
		}
		public function Getlist_post(){
			$id_user 	= $this->input->post("id_user");
			$limit 		= $this->input->post("limit");
			
			$hasil = $this->Mini_model->Get_list_order($id_user, $limit);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Tidak Ditemukan");
			}
			
			$this->response($response);
		}
		public function Statistik_post(){
			$id_user 	= $this->input->post("id_user");
			$bulan 		= $this->input->post("bulan");
			$tahun 		= $this->input->post("tahun");
			
			$hasil = $this->Mini_model->Statistik_sales($id_user, $tahun, $bulan);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Tidak Ditemukan");
			}
			
			$this->response($response);
		}
		
		public function index123_post(){ //Api sing lawas
			
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
		
		public function mini_post(){
			$id_user = null; 
			if(isset($_POST['id_user'])){
				$id_user = $_POST['id_user'];
			};
			
			$tahun = null;
			if(isset($_POST['tahun'])){
				$tahun = $_POST['tahun'];
			};
			
			$bulan = null;
			if(isset($_POST['bulan'])){
				$bulan = $_POST['bulan'];
			};
			
			$tanggal = null;
			if(isset($_POST['tanggal'])){
				$tanggal = $_POST['tanggal'];
			};
			
			$checkin = null; 					//isi dengan true / false
			if(isset($_POST['checkin'])){
				$checkin = $_POST['checkin'];
			};
			
			$hasil 	= $this->Model_kunjungan->list_jadwal_kunjungan_customer_mini($id_user, $tahun, $bulan, $tanggal, $checkin);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				$response = array("status" => "error", "total" => count($hasil), "message" => "Data Jadwal Kunjungan Tidak Ditemukan");
			}
			$this->response($response);
			
		}
		public function index_post(){ //listKunjungan API Anyar
			$id_user = null; 
			if(isset($_POST['id_user'])){
				$id_user = $_POST['id_user'];
			};
			
			$tahun = null;
			if(isset($_POST['tahun'])){
				$tahun = $_POST['tahun'];
			};
			
			$bulan = null;
			if(isset($_POST['bulan'])){
				$bulan = $_POST['bulan'];
			};
			
			$tanggal = null;
			if(isset($_POST['tanggal'])){
				$tanggal = $_POST['tanggal'];
			};
			
			$checkin = null; 					//isi dengan true / false
			if(isset($_POST['checkin'])){
				$checkin = $_POST['checkin'];
			};
			
			$hasil 	= $this->Model_kunjungan->list_jadwal_kunjungan_customer($id_user, $tahun, $bulan, $tanggal, $checkin);
			
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
		
		public function KeluhanPelangganAll_get(){
			
			$hasil = $this->Model_kunjungan->get_keluhan_pelanggan();
			
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
		
		public function Addkunjungan_post(){
			
			$input = json_decode(file_get_contents("php://input"));
			$data = json_decode(json_encode($input), true);
			
			$hasil = $this->Model_kunjungan->Add_kunjungan($data);
			
			// print_r($data);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				$response = array("status" => "error", "total" => count($hasil), "message" => "Data Gagal disimpan");
			}
			
			$this->response($response);	
		}

    }
?>
<?php
	if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    require APPPATH . '/controllers/apis/Token_access_crm.php';

    class Sales extends Token_access_crm {

        function __construct(){
            parent::__construct();
            $this->validasi();
            $this->load->model('apis/Model_master_sales');
        }
		
		public function Crm_post(){
			
			$id_distributor = null; 
			if(isset($_POST['id_distributor'])){
				$id_distributor = $_POST['id_distributor'];
			};
			
			$id_tso = null;
			if(isset($_POST['id_so'])){
				$id_tso = $_POST['id_so'];
			};
			
			$id_asm = null;
			if(isset($_POST['id_sm'])){
				$id_asm = $_POST['id_sm'];
			};
			
			$id_rsm = null;
			if(isset($_POST['id_ssm'])){
				$id_rsm = $_POST['id_ssm'];
			};
			
			$id_gsm = null;
			if(isset($_POST['id_gsm'])){
				$id_gsm = $_POST['id_gsm'];
			};
			
			$data = array();
			$hasil = $this->Model_master_sales->get_data_sales_dua($id_distributor, $id_tso, $id_asm, $id_rsm, $id_gsm);
			
			
			foreach($hasil as $h){
				array_push($data, array(
					'ID_GSM' 		=> $h['ID_GSM'],
					'NAMA_GSM'		=> $h['NAMA_GSM'],
					'ID_SSM' 		=> $h['ID_SSM'],
					'NAMA_SSM' 		=> $h['NAMA_SSM'],
					'ID_SM' 		=> $h['ID_SM'],
					'NAMA_SM'		=> $h['NAMA_SM'],
					'ID_SO' 		=> $h['ID_SO'],
					'NAMA_SO' 		=> $h['NAMA_SO'],
					'ID_SALES' 		=> $h['ID_SALES'],
					'NAMA_SALES'	=> $h['NAMA_SALES'],
					'USER_SALES' 	=> $h['USER_SALES'],
					'KODE_DISTRIBUTOR' => $h['KODE_DISTRIBUTOR'],
					'NAMA_DISTRIBUTOR' => $h['NAMA_DISTRIBUTOR'],
					'DISTRIK' 		=> $this->Model_master_sales->data_distrik($h['ID_SO'], $h['ID_SALES']),
				));
			}
			
			if($hasil){
				$response = array("status" => "success", "total" => count($data), "data" => $data);
				
			}
			else {
				 $response = array("status" => "success", "total" => count($hasil), "message" => "Data Kosong / Tidak Ditemukan");
			}
			
			$this->response($response);
			
		}
		
		public function index_post(){
			
			$id_distributor = null; 
			if(isset($_POST['id_distributor'])){
				$id_distributor = $_POST['id_distributor'];
			};
			
			$id_tso = null;
			if(isset($_POST['id_tso'])){
				$id_tso = $_POST['id_tso'];
			};
			
			$id_asm = null;
			if(isset($_POST['id_asm'])){
				$id_asm = $_POST['id_asm'];
			};
			
			$id_rsm = null;
			if(isset($_POST['id_rsm'])){
				$id_rsm = $_POST['id_rsm'];
			};
			
			$id_gsm = null;
			if(isset($_POST['id_gsm'])){
				$id_gsm = $_POST['id_gsm'];
			};
			
			$hasil = $this->Model_master_sales->get_data_sales($id_distributor, $id_tso, $id_asm, $id_rsm, $id_gsm);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "success", "total" => count($hasil), "message" => "Data Kosong / Tidak Ditemukan");
			}
			
			$this->response($response);
			
		}
		
		
	}
?>
<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Survey extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            $this->load->model('apis/Survey_model');
        }
		
		public function HasilsurveyKunjungan_post(){
			
			$id_user 	= $this->input->post("id_user");
			$id_kc		= $this->input->post("id_kunjungan_customer");
			
			$hasil = $this->Survey_model->get_hasil_survey_per_kunjungan($id_user, $id_kc);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Kunjungan Tidak Ditemukan");
			}
			
			$this->response($response);
			
			
		}
		public function Hasilsurvey_post(){
			
			$id_user 	= $this->input->post("id_user");
			$tahun 		= $this->input->post("tahun");
			$bulan		= $this->input->post("bulan");
			
			$hasil = $this->Survey_model->get_data_hasil_survey($id_user, $tahun, $bulan);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Customer Tidak Ditemukan");
			}
			
			$this->response($response);
			
			
		}
		
		public function HasilSurveykeluhanKunjungan_post(){
			
			$id_user 	= $this->input->post("id_user");
			$id_kc		= $this->input->post("id_kunjungan_customer");
			
			// print_r($_POST);
			// exit;
			
			$hasil = $this->Survey_model->get_data_survey_keluhan_perkunjungan($id_user, $id_kc);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Customer Tidak Ditemukan");
			}
			
			$this->response($response);
			
		}
		
		public function Hasilsurveykeluhan_post(){
			
			$id_user 	= $this->input->post("id_user");
			$tahun 		= $this->input->post("tahun");
			$bulan		= $this->input->post("bulan");
			
			$hasil = $this->Survey_model->get_data_survey_keluhan_sales($id_user, $tahun, $bulan);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Survey Keluhan Tidak Ditemukan");
			}
			
			$this->response($response);
			
		}
		
		public function HasilSurveyPromosiKunjungan_post(){
			
			$id_user 	= $this->input->post("id_user");
			$id_kc		= $this->input->post("id_kunjungan_customer");
			
			// print_r($_POST);
			// exit;
			
			
			$hasil = $this->Survey_model->get_data_survey_promosi_per_kunjungan($id_user, $id_kc);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Customer Tidak Ditemukan");
			}
			
			$this->response($response);
			
		}
		
		public function Hasilsurveypromosi_post(){
			
			$id_user 	= $this->input->post("id_user");
			$tahun 		= $this->input->post("tahun");
			$bulan		= $this->input->post("bulan");
			
			$hasil = $this->Survey_model->get_data_hasil_survey_promosi($id_user, $tahun, $bulan);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Survey Promosi Tidak Ditemukan");
			}
			
			$this->response($response);
		}
		
		public function AddSurvey_post(){
			
			$id_user 				= $this->input->post("id_user");
			$id_kc 					= $this->input->post("id_kunjungan_customer");
			$id_produk 				= $this->input->post("id_produk");
			
			$Keluhan = json_decode($_POST['Keluhan'], true);
			
			$hasil = $this->Survey_model->Insert_survey_keluhan($id_user, $id_kc, $id_produk, $Keluhan);
			
			if($hasil){
				$response = array("status" => "success", "pesan" => 'Data Berhasil Disimpan');
			}
			else {
				$response = array("status" => "success", "pesan" => 'Data Gagal Disimpan');
			}
			
			$this->response($response);
		}
		public function TampilansurveyKeluhan_post(){
			
			$id_user 				= $this->input->post("id_user");
			$id_kc 					= $this->input->post("id_kunjungan_customer");
			$id_produk 				= $this->input->post("id_produk");
			
			$hasil = $this->Survey_model->Menampilkan_hasil_survey($id_user, $id_kc, $id_produk);
			
			
			$detile = $this->Survey_model->menampilkan_detile_keluhan($id_user, $id_kc, $id_produk);
			
			$hasil[0]['KELUHAN'] = $detile; 
			
			if($hasil){
				$response = array("status" => "success", "data" => $hasil);
			}
			else {
				 $response = array("status" => "error", "message" => "Data Survey Promosi Tidak Ditemukan");
			}
			
			$this->response($response);
			
		}
		public function TampilansurveyKeluhanUser_post(){
			
			$id_user 	= $this->input->post("id_user");
			$tahun 		= $this->input->post("tahun");
			$bulan		= $this->input->post("bulan");
			
			$data_sk = $this->Survey_model->get_data_survey_keluhan($id_user, $tahun, $bulan);
			$detile_keluhan = $this->Survey_model->get_data_survey_detile_keluhan($id_user, $tahun, $bulan);
			
			 // print_r($data_sk);
			// print_r($detile_keluhan);
			// exit;
			$n=0;
			foreach($data_sk as $sk){
				
				$data[$n]['ID_KUNJUNGAN'] 	= $sk['ID_KUNJUNGAN_CUSTOMER'];
				$data[$n]['ID_PRODUK']		= $sk['ID_PRODUK'];
				$data[$n]['NAMA_PRODUK']	= $sk['NAMA_PRODUK'];
				$data[$n]['ID_USER']		= $sk['ID_USER'];
				
				$keluhan = array();
				
				foreach($detile_keluhan as $dk){
					if($sk['ID_KUNJUNGAN_CUSTOMER']==$dk['ID_KUNJUNGAN_CUSTOMER'] && $sk['ID_PRODUK']==$dk['ID_PRODUK']){
						
						$hasil = array(
							'ID_PRODUK'			=> $dk['ID_PRODUK'],
							'ID_SURVEY_KELUHAN' => $dk['ID_SURVEY_KELUHAN'],
							'ID_KELUHAN' 		=> $dk['ID_KELUHAN'],
							'KELUHAN' 			=> $dk['KELUHAN'],
							'JAWABAN' 			=> $dk['JAWABAN']
						);
						
						array_push($keluhan, $hasil);
						// print_r($keluhan);
						
					}
				}
				
				$data[$n]['keluhan'] = $keluhan;
				$n=$n+1;
			}
			
			if($data){
				$response = array("status" => "success", "total" => count($data), "data" => $data);
			}
			else {
				 $response = array("status" => "error", "total" => count($data), "message" => "Data Survey Keluhan Tidak Ditemukan");
			}
			
			$this->response($response);			
			
		}
		
		public function AddSurveyProduk_post(){
			
			$id_user 	= $this->input->post("id_user");
			$produk 	= json_decode($_POST['data'], true);
			
			$hasil = $this->Survey_model->Simpan_survey_produk($id_user, $produk);
			
			// print_r($produk);
			// exit;
			if($hasil){
				$response = array("status" => "success", "data" => $hasil, "message" => 'Data Berhasil Disimpan');
			}
			else {
				$response = array("status" => "success", "data" => $hasil, "message" => 'Data Gagal Disimpan');
			}
			
			$this->response($response);
		}
		
		public function AddsurveyPromosi_post(){
			
			$id_user 	= $this->input->post("id_user");
			
			$promosi = json_decode($_POST['data'], true);
			// print_r($promosi);
			// exit;
			
			$hasil = $this->Survey_model->Add_survey_promosi_per_user($id_user, $promosi);
			
			if($hasil){
				$response = array("status" => "success", "data" => $hasil, "message" => 'Data Berhasil Disimpan');
			}
			else {
				$response = array("status" => "success", "data" => $hasil, "message" => 'Data Gagal Disimpan');
			}
			
			$this->response($response);
		}
		public function AddsurveyKeluhan_post(){
			
			$id_user 	= $this->input->post("id_user");
			$keluhan 	= json_decode($_POST['data'], true);
			
			$hasil = $this->Survey_model->Add_survey_keluhan($id_user, $keluhan);
			
			if($hasil){
				$response = array("status" => "success", "data" => $hasil, "message" => 'Data Berhasil Disimpan');
			}
			else {
				$response = array("status" => "success", "data" => $hasil, "message" => 'Data Gagal Disimpan');
			}
			
			$this->response($response);
			
		}
		public function DelSurveyProduk_post(){
			
			$id_user 			= $this->input->post("id_user");
			$hasil_survey 		= $_POST['data'];
			
			// print_r($_POST);
			// exit;
			
			
			$hasil = $this->Survey_model->Delete_produk($id_user, $hasil_survey);
			
			if($hasil){
				$response = array("status" => "success", "message" => "Data Berhasil Dihapus", "data" => $hasil);
			}
			else {
				$response = array("status" => "success", "message" => "Data Gagal Dihapus", "data" => $hasil);
			}
			
			$this->response($response);
		}
		public function DelsurveyKeluhan_post(){
			
			$id_user 			= $this->input->post("id_user");
			$hasil_survey 		= $_POST['data'];
			
			$hasil = $this->Survey_model->delete_keluhan($id_user, $hasil_survey);
			
			if($hasil){
				$response = array("status" => "success", "message" => "Data Berhasil Dihapus");
			}
			else {
				$response = array("status" => "success", "message" => "Data Gagal Dihapus");
			}
			
			$this->response($response);
			
		}
		public function DelsurveyPromosi_post(){
			
			$id_user 			= $this->input->post("id_user");
			$hasil_survey 		= $_POST['data'];
			
			// print_r($_POST);
			// exit;
			
			
			$hasil = $this->Survey_model->delete_promosi($id_user, $hasil_survey);
			
			if($hasil){
				$response = array("status" => "success", "message" => "Data Berhasil Dihapus");
			}
			else {
				$response = array("status" => "success", "message" => "Data Gagal Dihapus");
			}
			
			$this->response($response);
			
		}
		
		public function TampilandetilesurveyKeluhan_post(){
			
			$id_user 	= $this->input->post("id_user");
			$tahun 		= $this->input->post("tahun");
			$bulan		= $this->input->post("bulan");
			
			$hasil = $this->Survey_model->get_data_survey_detile_keluhan($id_user, $tahun, $bulan);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			
			$this->response($response);
			
		}
		public function TampilandetilesurveyPromosi_post(){
			
			$id_user 	= $this->input->post("id_user");
			$tahun 		= $this->input->post("tahun");
			$bulan		= $this->input->post("bulan");
			
			$hasil = $this->Survey_model->get_data_survey_detile_promosi($id_user, $tahun, $bulan);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			
			$this->response($response);
		}
		public function UphasilSurvey_post(){
			
			$id_user 	= $this->input->post("id_user");
			$hasil_survey 		= json_decode($_POST['data'], true);
			
			$hasil = $this->Survey_model->Update_Hasil_survey($id_user, $hasil_survey);
			
			if($hasil){
				$response = array("status" => "success", "message" => "Data Berhasil Diupdate");
			}
			else {
				$response = array("status" => "success", "message" => "Data Gagal Diupdate");
			}
			
			$this->response($response);
		}
		public function UphasilSurveyKeluhan_post(){
			$id_user 			= $this->input->post("id_user");
			$hasil_survey 		= json_decode($_POST['data'], true);
			
			$hasil = $this->Survey_model->Update_Hasil_survey_keluhan($id_user, $hasil_survey);
			
			if($hasil){
				$response = array("status" => "success", "message" => "Data Berhasil Diupdate");
			}
			else {
				$response = array("status" => "success", "message" => "Data Gagal Diupdate");
			}
			
			$this->response($response);
		}
		public function UphasilSurveyPromosi_post(){
			
			$id_user 			= $this->input->post("id_user");
			$hasil_survey 		= json_decode($_POST['data'], true);
			
			$hasil = $this->Survey_model->Update_Hasil_survey_promosi($id_user, $hasil_survey);
			
			if($hasil){
				$response = array("status" => "success", "message" => "Data Berhasil Diupdate");
			}
			else {
				$response = array("status" => "success", "message" => "Data Gagal Diupdate");
			}
			
			$this->response($response);
		}
		public function ChekIn_post(){
			
			$id_user 			= $this->input->post("id_user");
			$id_kc 				= $this->input->post("id_kunjungan_customer");
			$latitude 			= $this->input->post("checkin_latitude");
			$longtitude 		= $this->input->post("checkin_longitude");
			$Out_latitude 		= $this->input->post("checkout_latitude");
			$Out_longtitude 	= $this->input->post("checkout_longitude");
			
						
			$hasil = $this->Survey_model->Update_Chekin($id_user, $id_kc, $latitude, $longtitude, $Out_latitude, $Out_longtitude);
			
			if($hasil){
				$response = array("status" => "success", "message" => "User Berhasil Chek In");
			}
			else {
				$response = array("status" => "success", "message" => "User Gagal Chek In");
			}
			
			$this->response($response);
			
		}
		public function CheckinUser_post(){
			$id_user 			= $this->input->post("id_user");
			
			$hasil_survey 		= json_decode($_POST['data'], true);
			
			$hasil = $this->Survey_model->update_checkin_user($id_user, $hasil_survey);
			
			if($hasil){
				$response = array("status" => "success", "message" => "User Berhasil Chek In");
			}
			else {
				$response = array("status" => "success", "message" => "User Gagal Chek In");
			}
			
			$this->response($response);
		}
		
		public function UpdateKunjungan_post(){
			$id_user 			= $this->input->post("id_user");
			
			$hasil_survey 		= json_decode($_POST['data'], true);
			
			$hasil = $this->Survey_model->update_kunjungan($id_user, $hasil_survey);
			
			if($hasil){
				$response = array("status" => "success", "message" => "User Berhasil Chek In");
			}
			else {
				$response = array("status" => "success", "message" => "User Gagal Chek In");
			}
			
			$this->response($response);
		}
		
		public function ChekOut_post(){
			
			$id_user 			= $this->input->post("id_user");
			$id_kc 				= $this->input->post("id_kunjungan_customer");
			$latitude 			= $this->input->post("latitude");
			$longtitude 		= $this->input->post("longitude");
			
			$hasil = $this->Survey_model->Update_Chekout($id_user, $id_kc, $latitude, $longtitude);
			
			if($hasil){
				$response = array("status" => "success", "message" => "User Berhasil Chek Out");
			}
			else {
				$response = array("status" => "success", "message" => "User Gagal Chek Out");
			}
			
			$this->response($response);
			
		}
		
		public function TampilanKualitatif_post(){
			
			$id_user 			= $this->input->post("id_user");
			$tahun 				= $this->input->post("tahun");
			$bulan				= $this->input->post("bulan");
			
			$hasil 	= $this->Survey_model->get_tampilan_survey_kualitatif($id_user, $tahun, $bulan);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			
			$this->response($response);
			
		}
		public function AddSurveyKualitatif_post(){
			
			$id_user 			= $this->input->post("id_user");
			$data 				= json_decode($_POST['data'], true);
			
			$insert = array();
			foreach($data as $d){
				$hasil = array(
					'ID_USER'			=> $id_user,
					'JAWABAN' 			=> $d['JAWABAN'],
					'CREATE_BY' 		=> $id_user,
					'CREATE_AT' 		=> date('d-M-y h.s.i A'),
					'DELETE_MARK' 		=> 0
				);
				
				array_push($insert, $hasil);
			}
			
			$hasil = $this->Survey_model->Add_survey_kualitatif($id_user, $insert);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			
			$this->response($response);
			
			
		}
		
		public function DelsurveyKualitatif_post(){
			
			$id_user 			= $this->input->post("id_user");
			$data 				= $this->input->post("data");
			
			$hasil = $this->Survey_model->delete_survey_kualitatif($id_user, $data);
				// exit;
			if($hasil){
				$response = array("status" => "success", "message" => "Data Berhasil di Delete");
			}
			else {
				$response = array("status" => "Error", "message" => "Data Gagal dihapus");
			}
			
			$this->response($response);
			
		}
		public function UpdatesurveyKeluhan_post(){
			
			$id_user 			= $this->input->post("id_user");
			$data 				= json_decode($_POST['data'], true);
			
			$hasil  = $this->Survey_model->update_data_kualitatif($id_user, $data);
			
			if($hasil){
				$response = array("status" => "success", "message" => "Data Berhasil di Update");
			}
			else {
				$response = array("status" => "Error", "message" => "Data Gagal Diupdate");
			}
			
			$this->response($response);
		}
		
		// --------------------------------------------------->>> Terkait fitur Survey Project
		
		public function AddsurveyProject_post(){
			
			$id_user 	= $this->input->post("id_user");
			$project = json_decode($_POST['data'], true);
			//echo json_encode($project);
			
			$hasil = $this->Survey_model->AddSurveyProject($id_user, $project);
			
			if($hasil){
				$response = array("status" => "success", "message" => 'Data Berhasil Disimpan', "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Data Gagal Disimpan', "data" => $hasil);
			}
			$this->response($response);
		}
		
		public function UpdatesurveyProject_post(){
			
			$id_user 	= $this->input->post("id_user");
			$project = json_decode($_POST['data'], true);
			//echo json_encode($hasil);
			
			$hasil = $this->Survey_model->UpdateSurveyProject($id_user, $project);
			
			if($hasil){
				$response = array("status" => "success", "message" => 'Data Berhasil Diupdate', "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Data Gagal Diupdate', "data" => $hasil);
			}
			
			$this->response($response);
		}
		
		public function DeletesurveyProject_post(){
			
			$id_user 			= $this->input->post("id_user");
			$data 				= $this->input->post("data");
			
			$hasil = $this->Survey_model->DeleteSurveyProject($id_user, $data);
			
			if($hasil == true){
				$response = array("status" => "success", "message" => "Data Berhasil di Delete");
			} else {
				$response = array("status" => "Error", "message" => "Data Gagal dihapus");
			}
			
			$this->response($response);
		}
		
		public function GetsurveyProject_post(){
			$id_user = $this->input->post("id_user");
			$limit 	= $this->input->post("limit");
			
			$get_data = $this->Survey_model->GetSurveyProject($id_user, $limit);
			
			$response = array("status" => "success", "total" => count($get_data), "data" => $get_data);
			
			$this->response($response);
		}
		
		// --------------------------------------------------->>> Terkait fitur Survey Project New
		
		public function AddsurveyProjectNew_post(){
			
			$id_user 	= $this->input->post("id_user");
			$project = json_decode($_POST['project'], true);
			//echo json_encode($project);
			
			$hasil = $this->Survey_model->AddSurveyProject($id_user, $project);
			
			if($hasil){
				$response = array("status" => "success", "message" => 'Data Berhasil Disimpan', "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Data Gagal Disimpan', "data" => $hasil);
			}
			$this->response($response);
		}
		
		public function UpdatesurveyProjectNew_post(){
			
			$id_user 	= $this->input->post("id_user");
			$project = json_decode($_POST['project'], true);
			//echo json_encode($hasil);
			
			$hasil = $this->Survey_model->UpdateSurveyProject($id_user, $project);
			
			if($hasil){
				$response = array("status" => "success", "message" => 'Data Berhasil Diupdate', "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Data Gagal Diupdate', "data" => $hasil);
			}
			
			$this->response($response);
		}
		
		public function DeletesurveyProjectNew_post(){
			
			$id_user 			= $this->input->post("id_user");
			$data 				= $this->input->post("id_project");
			
			$hasil = $this->Survey_model->DeleteSurveyProject($id_user, $data);
			
			if($hasil == true){
				$response = array("status" => "success", "message" => "Data Berhasil di Delete");
			} else {
				$response = array("status" => "Error", "message" => "Data Gagal dihapus");
			}
			
			$this->response($response);
		}
		
		public function GetsurveyProjectNew_post(){
			$id_user = $this->input->post("id_user");
			$limit 	= $this->input->post("limit");
			
			$get_data = $this->Survey_model->GetSurveyProject($id_user, $limit);
			
			$response = array("status" => "success", "total" => count($get_data), "data" => $get_data);
			
			$this->response($response);
		}
		
	}


?>
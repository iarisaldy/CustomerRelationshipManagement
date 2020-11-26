<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class History_visited extends Auth {

        public function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_history_visited', "VISITED");
        }
		
		public function getHistoryVisited_post(){

			$id_tso  = $this->input->post("id_user");
			$id_customer  = $this->input->post("id_customer");
			$hasil = $this->VISITED->getHistory($id_tso, $id_customer);
			
			if(count($hasil) != 0){
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            } else {
                $response = array("status" => "error", "total" => count($hasil), "data" => []);
            }
			 $this->response($response);
		}
		
		public function detailHistoryVisited_post(){

			$id_kunjungan  = $this->input->post("id_kunjungan");
			
			$hasil['kunjungan'] = $this->VISITED->getKunjungan($id_kunjungan);
			$hasil['produk_survey'] = $this->VISITED->getProductSurvey($id_kunjungan);
			$hasil['survey_project'] = $this->VISITED->getSurveyProject($id_kunjungan);
			$hasil['photo'] = $this->VISITED->getFoto($id_kunjungan);
			$hasil['alasan_tidak_order'] = $this->VISITED->getAlasanTidakOrder($id_kunjungan);

			
			if($hasil != null){
                $response = array("status" => "success", "data" => $hasil);
            } else {
                $response = array("status" => "error", "data" => []);
            }
			 $this->response($response);
		}
		
		public function getHasilSurvey_post(){

			$id_kunjungan  = $this->input->post("id_kunjungan");
			$id_produk  = $this->input->post("id_produk");
			
			$hasil['hasil_survey'] = $this->VISITED->getHasilSurvey($id_kunjungan, $id_produk);
			$hasil['survey_keluhan'] = $this->VISITED->getSurveyKeluhan($id_kunjungan, $id_produk);
			$hasil['survey_promosi'] = $this->VISITED->getSurveyPromosi($id_kunjungan, $id_produk);

			
			if($hasil != null){
                $response = array("status" => "success", "data" => $hasil);
            } else {
                $response = array("status" => "error", "data" => []);
            }
			 $this->response($response);
		}
		
		
	}
	
?>
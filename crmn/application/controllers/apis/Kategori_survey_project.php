<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Kategori_survey_project extends Auth {

        public function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_kategori_project', "KATEGORI");
        }
		
		public function getKategori_post(){
			
			$id_user 	= $this->input->post("id_user");
			$hasil = $this->KATEGORI->getKategori();

			
			if($hasil != null){
                $response = array("status" => "success", "data" => $hasil);
            } else {
                $response = array("status" => "error", "data" => []);
            }
			 $this->response($response);
		}
		
		public function AddKategoriProjectList_post(){
			
			$id_user 	= $this->input->post("id_user");
			$data = json_decode($_POST['data'], true);
			
			$hasil = $this->KATEGORI->Add_kategori_project($id_user, $data);
			
			if($hasil){
				$response = array("status" => "success", "message" => 'Data Berhasil Disimpan', "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Data Gagal Disimpan', "data" => $hasil);
			}
			$this->response($response);
		}
		
		public function AddKategoriProject_post(){
			
			$id_user 	= $this->input->post("id_user");
			$data = json_decode($_POST['data'], true);
			
			//$this->response($data);
			//exit;
			
			$hasil = $this->KATEGORI->Add_kategori_project($id_user, $data);
			
			if($hasil){
				$response = array("status" => "success", "message" => 'Data Berhasil Disimpan', "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Data Gagal Disimpan', "data" => $hasil);
			}
			$this->response($response);
		}
		
		
	}
	
?>
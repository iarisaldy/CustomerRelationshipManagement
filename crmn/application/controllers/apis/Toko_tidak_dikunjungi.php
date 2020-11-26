<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}
require APPPATH . '/controllers/apis/Auth.php';

    class Toko_tidak_dikunjungi extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Toko_tidak_dikunjungi_model', 'mTtd');
        }

        public function index_post(){
            $mr = $this->mTtd->listToko();
            if($mr){
                foreach ($mr as $mrKey => $mrValue) {
                    $data['ID_TOKO_TIDAK_DIKUNJUNGI'] = $mrValue->ID_TOKO_TIDAK_DIKUNJUNGI;
                    $data['ID_KUNJUNGAN'] = $mrValue->ID_KUNJUNGAN;
                    $data['NO_MR_DETAIL'] = $mrValue->NO_MR_DETAIL;
					$data['NAMA_DETAIL'] = $mrValue->NAMA_DETAIL;
                    $data['DESKRIPSI'] = $mrValue->DESCRIPTION;
                    $json_dt[] = $data;
                }
                $response = array("status" => "success", "data" => $json_dt);
            } else {
                $response = array("status" => "error", "message" => "Data reason tidak ada");
            }
            $this->response($response);
        }
		
		public function getToko_post(){
			$id_user 	= $this->input->post("id_user");
			$hasil = $this->mTtd->getToko($id_user);
			
			if($hasil){
				$response = array("status" => "success", "data" => $hasil);
			}
			else {
				$response = array("status" => "success", "data" => $hasil, "message" => 'Data reason tidak ada');
			}
			
			$this->response($response);
		}
		
		public function AddAlasanTokoTidakDikunjungi_post(){		//save 
			
			$id_user 	= $this->input->post("id_user");
			$reason 	= json_decode($_POST['data'], true);
			
			$hasil = $this->mTtd->Simpan_alasan_tokoTidakDikunjungi($id_user, $reason);
			
			// print_r($reason);
			// exit;
			
			if($hasil){
				$response = array("status" => "success", "data" => $hasil, "message" => 'Data Berhasil Disimpan');
			}
			else {
				$response = array("status" => "success", "data" => $hasil, "message" => 'Data Gagal Disimpan');
			}
			
			$this->response($response);
		}
		
		public function DelAlasanTokoTidakDikunjungi_post(){
			$id_kunjungan = $this->input->post("id_kunjungan");
			$id_mr = $this->input->post("id_mr");
			
			$hasil = $this->mTtd->delTokoTdkDikunjungi($id_kunjungan, $id_mr);
			
			// print_r($reason);
			// exit;
			
			if($hasil){
				$response = array("status" => "success", "rows_del" => $hasil, "message" => 'Data Berhasil Dihapus');
			}
			else {
				$response = array("status" => "error", "rows_del" => $hasil, "message" => 'Data Tidak Ada');
			}
			
			$this->response($response);
		}
		
		public function DelAlasanTokoTidakDikunjungiBynoMr_post(){
			$id_kunjungan = $this->input->post("id_kunjungan");
			$no_mr_detail = $this->input->post("no_mr_detail");
			
			$hasil = $this->mTtd->delTokoTdkDikunjungiBynoMr($id_kunjungan, $no_mr_detail);
			
			// print_r($reason);
			// exit;  
			
			if($hasil){ 
				$response = array("status" => "success", "rows_del" => $hasil, "message" => 'Data Berhasil Dihapus');
			}
			else {
				$response = array("status" => "error", "rows_del" => $hasil, "message" => 'Data Tidak Ada');
			}
			
			$this->response($response);
		}
		 
		public function DelAlasanTokoTidakDikunjungiByidTTD_post(){
			$id_ttd = $this->input->post("data");
			
			$hasil = $this->mTtd->delTokoTdkDikunjungiByidKunjungan($id_ttd);
			
			// print_r($reason); 
			// exit;  
			
			if($hasil){ 
				$response = array("status" => "success", "rows_del" => $hasil, "message" => 'Data Berhasil Dihapus');
			}
			else {
				$response = array("status" => "error", "rows_del" => $hasil, "message" => 'Data Tidak Ada');
			}
			
			$this->response($response);
		}
	}
?>
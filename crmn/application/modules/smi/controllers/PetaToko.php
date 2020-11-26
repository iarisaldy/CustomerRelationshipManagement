<?php
	class PetaToko extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model("Model_PetaToko", "mPetaToko");
		}

		public function index(){
			$data = array("title" => "Dashboard CRM Administrator");
			$this->template->display('PetaToko_view', $data);
		}

		public function masterArea(){
			$area = $this->mPetaToko->masterArea();
			if($area){
				echo json_encode($area);
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Master Area Tidak Ada"));
			}
		}

		public function stokToko($idArea = null){
			$idDistributor = null;
			if($this->session->userdata("id_jenis_user") == "1002"){
				$idDistributor = $this->session->userdata("kode_dist");
			}
			$data = $this->mPetaToko->stokToko($idArea, $idDistributor);
			if($data){
				foreach ($data as $key => $value) {
					$stokToko["ID_CUSTOMER"] = $value->ID_CUSTOMER;
					$stokToko["NAMA_TOKO"] = $value->NAMA_TOKO;
					$stokToko["ID_AREA"] = $value->ID_AREA;
					$stokToko["LATITUDE"] = $value->LATITUDE;
					$stokToko["LONGITUDE"] = $value->LONGITUDE;
					$stokToko["UPDATED"] = $value->UPDATE_DATE;
					$stokToko["KAPASITAS"] = $value->KAPASITAS;
					$stokToko["STOK_SEKARANG"] = $value->STOK_SEKARANG;
					if($value->KAPASITAS == "0"){
						$marker = "BLACK";
					} else {
						$levelStok = ($value->STOK_SEKARANG / $value->KAPASITAS) * 100;
						if($levelStok > 0 && $levelStok <= 30){
							$marker = "RED";
						}  else if($levelStok > 30 && $levelStok <= 70){
							$marker = "YELLOW";
						} else if($levelStok > 70 && $levelStok <= 100) {
							$marker = "GREEN";
						} else if($levelStok > 100) {
							$marker = "BLUE";
						}
					}

					$stokToko["MARKER"] = $marker;
					$json[] = $stokToko;
				}
				echo json_encode($json);
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Stok Tidak Ada"));
			}
		}

		public function toko($idCustomer){
			$data = $this->mPetaToko->stokPerToko($idCustomer);
			if($data){
				echo json_encode(array("status" => "success", "data" => $data));
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Stok Tidak Ada"));
			}
		}

	}
?>
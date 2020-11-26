<?php
	class Region extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model("Model_region", "mRegion");
		}

		public function listRegion(){
			$region = $this->mRegion->listRegion();
			if($region){
				$status = "success";
				foreach ($region as $regionKey => $regionValue) {
					$data["ID_REGION"] = $regionValue->ID_REGION;
					$data["REGION"] = $regionValue->REGION_ID;
					$data["NAMA_REGION"] = $regionValue->REGION_NAME;
					$jsonRegion[] = $data;
				}
			} else {
				$status = "error";
				$jsonRegion[] = array();
			}

			echo json_encode(array("status" => $status, "data" => $jsonRegion));
		}

		public function listProvinsi($idRegion = null){
			$provinsi = $this->mRegion->listProvinsi(null, $idRegion);
			if($provinsi){
				$status = "success";
				foreach ($provinsi as $provinsiKey => $provinsiValue) {
					$data["ID_PROVINSI"] = $provinsiValue->ID_PROVINSI;
					$data["NAMA_PROVINSI"] = $provinsiValue->NAMA_PROVINSI;
					$jsonProvinsi[] = $data;
				}
			} else {
				$status = "error";
				$jsonProvinsi[] = array();
			}

			echo json_encode(array("status" => $status, "data" => $jsonProvinsi));
		}
	}
?>
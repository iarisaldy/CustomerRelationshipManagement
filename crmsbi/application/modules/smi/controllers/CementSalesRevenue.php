<?php
	class CementSalesRevenue extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model("Model_cementRevenue", "mRevenue");
		}

		public function index(){
			$data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('CementSalesRevenue_view', $data);
		}

		public function chartRevenue(){
			$idRegion = $this->input->post("id_region");
			$idProvinsi = $this->input->post("id_provinsi");
			$bulan = $this->input->post("bulan");
			$tahun = $this->input->post("tahun");

			$dataRealisasi = array();
			$dataRencana = array();

			$provinsi = $this->mRevenue->listProvinsi(null, $idRegion);
			$dataFilterRegion = array();
			foreach ($provinsi as $provinsiKey => $provinsiValue) {
				$dataCategory["label"] = $provinsiValue->NAMA_PROVINSI;
				array_push($dataFilterRegion, $provinsiValue->ID_PROVINSI);
				$jsonCategory[] = $dataCategory;
			}
			if($idRegion != "0" || $idRegion == ""){
				$filterRegion = $dataFilterRegion;
			} else {
				$filterRegion = null;
			}

			$realisasi = $this->mRevenue->realVolRevenue($filterRegion, $bulan, $tahun);
			$dataRealisasi["seriesname"] = "Realisasi Revenue";
			$dataRealisasi["data"] = array();
			foreach ($realisasi as $realisasiKey => $realisasiValue) {
				$valueRealisasi["value"] = $realisasiValue->REAL_REVENUE_SDK_JT;
				array_push($dataRealisasi["data"], $valueRealisasi);
			}

			$dataRencana["seriesname"] = "Rencana Revenue";
			$dataRencana["data"] = array();
			foreach ($realisasi as $rencanaKey => $rencanaValue) {
				$valueRencana["value"] = $rencanaValue->RKAP_REVENUE_BLN_JT;
				array_push($dataRencana["data"], $valueRencana);
			}

			echo json_encode(array("status" => "success", "category" => $jsonCategory, "data_realisasi" => array($dataRealisasi), "data_rencana" => array($dataRencana)));
		}
	}
?>
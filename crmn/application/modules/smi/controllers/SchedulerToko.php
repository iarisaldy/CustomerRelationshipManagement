<?php
	class SchedulerToko extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model("Model_schedulerToko", "mScheduler");
		}

		public function nonaktif(){
			$tokoNonaktif = $this->mScheduler->tokoNonaktif();
			if($tokoNonaktif){
				foreach ($tokoNonaktif as $key => $value) {
					$data["KODE_DISTRIBUTOR"] = $value->NOMOR_DISTRIBUTOR;
					$data["ID_PROVINSI"] = $value->KD_PROVINSI;
					$data["NAMA_DISTRIK"] = $value->NM_DISTRIK;
					$data["NAMA_AREA"] = $value->AREA;
					$data["BULAN"] = date('m');
					$data["TAHUN"] = date('Y');
					$data["JUMLAH"] = $value->JUMLAH_TOKO_NAKTIF;
					$data["DELETE_MARK"] = "0";

					$json[] = $data;
				}

				$this->mScheduler->addTokoNonaktif($json);
			}

			print_r($json);
		}
	}
?>
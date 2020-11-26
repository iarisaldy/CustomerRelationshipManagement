<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class TrackCanvasing extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Model_TrackCanvasing", "mTrackCanvasing");
	}

	public function index(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$this->template->display('TrackCanvasing_view', $data);
	}

	public function canvasing(){
		$idSalesDistributor = $this->input->post("id_sales");
		$startDate = $this->input->post("start_date");
		$endDate = $this->input->post("end_date");
		$canvasing = $this->mTrackCanvasing->listCanvasing($idSalesDistributor, $startDate, $endDate);
		if($canvasing){
			$data["status"] = "success";
			foreach ($canvasing as $key => $value) {
				$dataId[] = array("id_kunjungan" => $value->ID_KUNJUNGAN_CUSTOMER);
				$datas[] = array("lat" => (float)$value->CHECKIN_LATITUDE, "lng" => (float)$value->CHECKIN_LONGITUDE);
			}

			$data["kunjungan"] = $dataId;
			$data["data"] = $datas;
		} else {
			$data["status"] = "error";
			$data["data"] = array();
		}
		echo json_encode($data);
	}

	public function detailCanvasing($idKunjungan){
		$detailCanvasing = $this->mTrackCanvasing->detailCanvasing($idKunjungan);
		if($detailCanvasing){
			$data["NAMA_TOKO"] = $detailCanvasing->NAMA_TOKO;
			$data["TGL_KUNJUNGAN"] = $detailCanvasing->TGL_KUNJUNGAN;
			$data["DURASI_KUNJUNGAN"] = $detailCanvasing->DURASI_KUNJUNGAN;
			$data["KETERANGAN"] = $detailCanvasing->KETERANGAN;
			$json[] = $data;
		}

		echo json_encode(array("status" => "success", "data" => $json));
	}

}
?>
<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
class ResumeCanvassing extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("Model_ResumeCanvassing", "mResumeCanvassing");
    }
    
	public function index(){
		$data = array("title" => "Dashboard CRM Administrator");
    	$this->template->display('ResumeCanvassing_view', $data);
	}

	public function survey(){
		$idDistributor = $this->input->post("kode_distributor");
		$idProvinsi = $this->input->post("id_provinsi");
		$idKota = $this->input->post("id_kota");
		$merkProduk = $this->input->post("merk_produk");

		$draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

		$dataSurvey = $this->mResumeCanvassing->resumeSurvey($idDistributor, $idProvinsi, $idKota, $merkProduk);
		if($dataSurvey){
			$i=1;
			foreach ($dataSurvey as $dataSurvey_key => $dataSurvey_value) {
				$data[] = array(
					$i,
					$dataSurvey_value->NAMA_TOKO,
					$dataSurvey_value->NAMA_PRODUK,
					$dataSurvey_value->TGL_KUNJUNGAN,
					$dataSurvey_value->STOK_SAAT_INI,
					$dataSurvey_value->HARGA_PENJUALAN,
					$dataSurvey_value->HARGA_PEMBELIAN,
					$dataSurvey_value->VOLUME_PENJUALAN,
					$dataSurvey_value->VOLUME_PEMBELIAN
				);
				$i++;
			}
		} else {
			$data[] = array("-","-","-","-","-","-","-","-","-");
		}

		$output = array(
            "draw" => $draw,
            "recordsTotal" => count($dataSurvey),
            "recordsFiltered" => count($dataSurvey),
            "data" => $data
        );
        echo json_encode($output);
	}

	public function promotion(){
		$idDistributor = $this->input->post("kode_distributor");
		$idProvinsi = $this->input->post("id_provinsi");
		$idKota = $this->input->post("id_kota");
		$merkProduk = $this->input->post("merk_produk");

		$draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

		$dataPromosi = $this->mResumeCanvassing->resumePromotion($idDistributor, $idProvinsi, $idKota, $merkProduk);
		if($dataPromosi){
			$i = 1;
			foreach ($dataPromosi as $dataPromosiKey => $dataPromosiValue) {
				$data[] = array(
					$i,
					ucwords(strtolower($dataPromosiValue->JENIS_PRODUK)),
					"Rp ".str_replace(",", ".", number_format($dataPromosiValue->POTONGAN_HARGA)),
					$dataPromosiValue->BONUS_SEMEN,
					$dataPromosiValue->POINT_REWARD,
					"Rp ".str_replace(",", ".", number_format($dataPromosiValue->VOUCER)),
					ucwords($dataPromosiValue->BONUS_WISATA)
				);
				$i++;
			}
		} else {
			$data[] = array("-","-","-","-","-","-","-");
		}

		$output = array(
            "draw" => $draw,
            "recordsTotal" => count($dataPromosi),
            "recordsFiltered" => count($dataPromosi),
            "data" => $data
        );
        echo json_encode($output);
	}
}

?>
<?php

class ResumePerformance extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('Model_ResumePerformance',"mResumePerformance");
	}

	public function index(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$this->template->display('ResumePerformance_view', $data);
	}

	public function kuantumPerformance(){
		$month = date('m');
		$year = date('Y');
		for ($i =0; $i < 4; $i++) {
			$lastMonth = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
		}

		$idDistributor = $this->session->userdata("kode_dist");
		$kuantum = $this->mResumePerformance->kuantumToko($idDistributor, $month, $year, $lastMonth);
		$toko = $this->mResumePerformance->tokoJualan($month, $year, $lastMonth);

		$begin = new DateTime(date('Y-m-d', strtotime('-5 month')));
		$end = new DateTime(date('Y-m-d', strtotime('+1 month')));
		$interval = DateInterval::createFromDateString('1 month');
		$period = new DatePeriod($begin, $interval, $end);

		foreach ($toko as $tokoKey => $tokoValue) {
			$data["KD_TOKO"] = $tokoValue->KD_TOKO;
			$data["NM_TOKO"] = $tokoValue->NM_TOKO;
			$data["NM_KECAMATAN"] = $tokoValue->NM_KECAMATAN;
			$data["KUANTUM"] = array();
			foreach ($period as $dt) {
				$tgl = date_format($dt, 'm-Y');
				$qty = array("BULAN" => $tgl, "QTY" => "0");
				foreach ($kuantum as $kuantumKey => $kuantumValue) {
					if($tgl == $kuantumValue->BULAN && $kuantumValue->KD_TOKO == $tokoValue->KD_TOKO){
						$qty = array("BULAN" => $tgl, "QTY" => number_format($kuantumValue->KUANTUM));
					}
				}
				array_push($data["KUANTUM"], $qty);
			}
			$json[] = $data;
		}
		return $json;
	}

	public function dataPerformanceRetail(){
		$retail = $this->kuantumPerformance();

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$i = 1;
		for ($j=0;$j<count($retail);$j++) {
			$data[] = array(
				$retail[$j]['KD_TOKO'],
				$retail[$j]['NM_TOKO'],
				$retail[$j]['NM_KECAMATAN'],
				$retail[$j]['KUANTUM'][0]['QTY'],
				$retail[$j]['KUANTUM'][1]['QTY'],
				$retail[$j]['KUANTUM'][2]['QTY'],
				$retail[$j]['KUANTUM'][3]['QTY'],
				$retail[$j]['KUANTUM'][4]['QTY'],
				$retail[$j]['KUANTUM'][5]['QTY']
			);
			$i++;
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => count($retail),
			"recordsFiltered" => count($retail),
			"data" => $data
		);

		echo json_encode($output);
		exit();
	}
}
?>
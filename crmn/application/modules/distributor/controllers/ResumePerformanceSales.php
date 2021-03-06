<?php
	/**
	 * 
	 */
	class ResumePerformanceSales extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->load->model("Model_PerformanceSales", "mPerformanceSales");
		}

		public function index(){
			$data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('ResumePerformanceSales_view', $data);
		}

		public function canvasingPerformance(){
			$bulan = $this->input->post("bulan");
			$tahun = $this->input->post("tahun");

			$draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

			$canvasingPerformance = $this->mPerformanceSales->canvasingPerformance($bulan, $tahun);
			if($canvasingPerformance){
				$i=1;
				foreach ($canvasingPerformance as $key => $value) {
					$data[] = array(
						$i,
						strtoupper($value->NAMA),
						$value->JML_KUNJUNGAN,
						"<center><button id='detailSales' data-iduser='".$value->ID_USER."' data-nama='".$value->NAMA."' class='btn btn-sm btn-info'><i class='fa fa-info'></i> Detail</button></center>"
					);
					$i++;
				}
			} else {
				 $data[] = array("-","-","-","-");
			}

			$output = array(
                "draw" => $draw,
                "recordsTotal" => count($canvasingPerformance),
                "recordsFiltered" => count($canvasingPerformance),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}

		public function countSunday($bulan = null, $tahun = null){
			$startDate = $tahun."-".$bulan."-01";
			$endDate = $tahun."-".$bulan."-d";

	    	$begin = new DateTime(date($startDate));
	    	$end = new DateTime(date($endDate));
	    	$day = 0;
	    	while ($begin <= $end){
	    		if($begin->format("D") == "Sun"){
	    			$day++;
	    		}
	    		$begin->modify('+1 day');
	    	}

	    	return $day;
	    }

		public function kunjunganHarian($idUser = null, $bulan = null, $tahun = null){
			if($bulan < 10){
				$bulan = "0".$bulan;
			} else {
				$bulan = $bulan;
			}
			
	    	$data = array();

	    	$begin = new DateTime(date(''.$tahun.'-'.$bulan.'-1'));
			$finish = new DateTime(date(''.$tahun.'-'.$bulan.'-t', strtotime($tahun."-".$bulan."-01")));
			$end = $finish->modify( '+1 day' ); 
			$interval = new DateInterval('P1D');
			$period = new DatePeriod($begin, $interval ,$end);
			
			$kunjunganHarian = $this->mPerformanceSales->kunjunganHarian($idUser, $bulan, $tahun);
			$totalKunjungan = $this->mPerformanceSales->totalKunjungan($idUser, $bulan, $tahun);
			if($kunjunganHarian){
				foreach ($period as $key) {
					$loopDate = date_format($key, 'd');
					$data["label"] = $loopDate;
					$data["value"] = 0;
					foreach ($kunjunganHarian as $kunjunganKey => $kunjunganValue) {
						if($loopDate == $kunjunganValue->TGL){
							$data["value"] = $kunjunganValue->TOTAL;
						}
					}
					$json[] = $data;
				}
			} else {
				foreach ($period as $key) {
					$loopDate = date_format($key, 'd');
					$data["label"] = $loopDate;
					$data["value"] = 0;
					$json[] = $data;
				}
			}

			$tglBulan = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
			$sunday = $this->countSunday($bulan, $tahun);
			$date = $tglBulan - $sunday;
			

			$trend = array("line" => array(array("startvalue" => round($totalKunjungan->TOTAL / $date), "color" => "#29C3BE", "thickness" => "2", "dashed" => "1", "dashLen" => "4", "dashGap" => "2")));

			echo json_encode(array("status" => "success", "data" => $json, "trendlines" => array($trend)));
	    }
	}
?>
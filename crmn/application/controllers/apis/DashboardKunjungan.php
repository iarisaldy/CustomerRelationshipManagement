<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class DashboardKunjungan extends Auth {

        public function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_dashboard_kunjungan', 'mKunjungan');
        }

        public function index_post(){
        	$idDistributor = $this->post("id_distributor");
        	$month = $this->post("month");
        	$year = $this->post("year");

        	$data = array();
        	if($month < 10){
        		$month = "0".$month;
        	} else {
        		$month = $month;
        	}

        	$begin = new DateTime(date(''.$year.'-'.$month.'-1'));
        	$finish = new DateTime(date(''.$year.'-'.$month.'-t', strtotime($year."-".$month."-01")));
        	$end = $finish->modify( '+1 day' ); 
        	$interval = new DateInterval('P1D');
        	$period = new DatePeriod($begin, $interval ,$end);

        	$kunjunganHarian = $this->mKunjungan->kunjunganHarian($idDistributor,$month, $year);
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


            $this->response(array("status" => "success", "total" => count($json), "data" => $json));
        }

    }
?>
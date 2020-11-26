<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Model_kunjungan", "mKunjungan");
	}

	public function index(){
		$jenisUser = $this->session->userdata("id_jenis_user");
        $data = array("title"=>"Dashboard CRM Administrator");
        if($jenisUser == "1002" || $jenisUser == "1007"){
        	$this->template->display('HomeDistributor_view', $data);
        } else {
        	$this->template->display('Home_view', $data);
        }
        
    }

    public function getIdentitas($idUser){
    	$idJenisUser = $this->session->userdata("id_jenis_user");
    	if($idJenisUser == "1002"){
    		$identitasUser = $this->mKunjungan->identitasDistributor($idUser);
    	} else {
    		$identitasUser = $this->mKunjungan->identitasUser($idUser);
    	}
    	
    	if($identitasUser){
    		echo json_encode(array("status" => "success", "data" => $identitasUser));
    	} else {
    		echo json_encode(array("status" => "error", "message" => "Data tidak ada"));
    	}
    }

    public function countSunday($bulan, $tahun){
        $fristDate = $tahun.'-'.$bulan.'-01';
        $secondDate = $tahun.'-'.$bulan.'-'.date('d');

    	$begin = new DateTime(date($fristDate));
    	$end = new DateTime(date($secondDate));

    	$day = 0;
    	while ($begin <= $end){
    		if($begin->format("D") == "Sun"){
    			$day++;
    		}
    		$begin->modify('+1 day');
    	}

    	return $day;
    }

    function isWeekend($tanggal, $bulan, $tahun) {
        $dt = $tahun.'-'.$bulan.'-'.$tanggal;
        $dt1 = strtotime($dt);
        $dt2 = date("l", $dt1);
        $dt3 = strtolower($dt2);
        if($dt3 == "sunday"){
            return true;
        }
    }

    public function kunjunganHarian($idUser = null, $bulan1 = null, $tahun = null){
    	$data = array();
    	if($bulan1 < 10){
    		$bulan = "0".$bulan1;
    	} else {
            $bulan = $bulan1;
        }
    	$begin = new DateTime(date(''.$tahun.'-'.$bulan.'-1'));
		$finish = new DateTime(date(''.$tahun.'-'.$bulan.'-t', strtotime($tahun."-".$bulan."-01")));
		$end = $finish->modify( '+1 day' ); 
		$interval = new DateInterval('P1D');
		$period = new DatePeriod($begin, $interval ,$end);
		$getIdentitasUser = $this->mKunjungan->identitasUser($idUser);
		$kunjunganHarian = $this->mKunjungan->kunjunganHarian($idUser, $getIdentitasUser->ID_JENIS_USER, $bulan, $tahun);
		$totalKunjungan = $this->mKunjungan->totalKunjungan($idUser, $getIdentitasUser->ID_JENIS_USER, $bulan, $tahun);
		if($kunjunganHarian){
			foreach ($period as $key) {
				$loopDate = date_format($key, 'd');
                $libur = $this->isWeekend($loopDate, $bulan, $tahun);
                if($libur != true){
                    $data["label"] = $loopDate;
                    $data["value"] = 0;
                    foreach ($kunjunganHarian as $kunjunganKey => $kunjunganValue) {
                        if($loopDate == $kunjunganValue->TGL){
                            $data["value"] = $kunjunganValue->TOTAL;
                        }
                    }
                    $json[] = $data;
                }
			}
		} else {
			foreach ($period as $key) {
				$loopDate = date_format($key, 'd');
				$data["label"] = $loopDate;
				$data["value"] = 0;
				$json[] = $data;
			}
		}

		$sunday = $this->countSunday($bulan, $tahun);
		$date = date('d') - $sunday;

		$trend = array("line" => array(array("startvalue" => round($totalKunjungan->TOTAL / $date), "color" => "#29C3BE", "thickness" => "2", "dashed" => "1", "dashLen" => "4", "dashGap" => "2")));

		echo json_encode(array("status" => "success", "data" => $json, "trendlines" => array($trend)));
    }


}

?>
<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Model_kunjungan", "mKunjungan");
		
	}

	public function index(){
		
		//print_r($this->session->userdata());
		//exit();
		
		$id_user = $this->session->userdata("user_id");
		$jenisUser = $this->session->userdata("id_jenis_user");
		$bulan = date('m');
		$tahun = date('Y');
			
		if (isset($_POST["filterBulan"]) and isset($_POST["filterTahun"])) {
			if($_POST["filterBulan"] < 10){
				$this->session->set_userdata('set_bulan', $bulan);
				$bulan = "0".$_POST["filterBulan"];
			} else {
				$bulan = $_POST["filterBulan"];
			}
			$tahun = $_POST["filterTahun"];
			$this->session->set_userdata('set_tahun', $tahun);
		}
		$this->session->set_userdata('set_bulan', $bulan);
		$this->session->set_userdata('set_tahun', $tahun);
		
        $data = array("title"=>"Dashboard CRM Administrator");
        if($jenisUser == "1002" || $jenisUser == "1007" || $jenisUser == "1005"){
        	$this->template->display('HomeDistributor_view', $data);
        }else if($jenisUser >= "1009"){
			$this->session->set_userdata('set_group', "SBI");
			$data['kunjungans'] = $this->mKunjungan->GrafikKunjungan($jenisUser, $id_user, $bulan, $tahun);
			if (isset($_POST["filterGroup"])){
				if($_POST["filterGroup"] == "SMI"){
					$this->session->set_userdata('set_group', "SMI");
					$data['kunjungans'] = $this->mKunjungan->GrafikKunjunganSmi($bulan, $tahun);
				} else {
					$this->session->set_userdata('set_group', "SBI");
					$data['kunjungans'] = $this->mKunjungan->GrafikKunjungan($jenisUser, $id_user, $bulan, $tahun);
				}
			} 
			
			if($jenisUser == "1013"){
				$dist 						= $this->mKunjungan->userCheckingDist($id_user);
				$kd_dist 					= $dist->KODE_DISTRIBUTOR;
				$nm_dist					= $dist->NAMA_DISTRIBUTOR;
				$this->session->set_userdata('set_dist', $nm_dist);
				$data['kunjungans'] = $this->mKunjungan->GrafikKunjungan($jenisUser, $kd_dist, $bulan, $tahun);
				$this->template->display('Sbi_dist_view', $data);
			} else {
				if($jenisUser == "1009" or $jenisUser == "1016" or $jenisUser == "1017"){
					$filterBy = null; $filterSet = null;
					$this->session->set_userdata('set_filterBy', "ALL");
					$this->session->set_userdata('set_filterSet', "~");
					if (isset($_POST["FilterBy"]) and isset($_POST["FilterSet"])){
						if($_POST["FilterBy"] != 0){
							$By = explode("-",$_POST["FilterBy"]);
							$Set = explode("-",$_POST["FilterSet"]);
							$filterBy = $By[0]; 
							$filterSet = $Set[0];
							$this->session->set_userdata('set_filterBy', $By[1]);
							$this->session->set_userdata('set_filterSet', $Set[1]);
							//print_r($filterBy." ".$filterSet);
							//exit;
						}
					} 
					$data['kunjungans'] = $this->mKunjungan->GrafikKunjunganAdmin($filterBy, $filterSet, $bulan, $tahun);

					$data['sebaran_toko_prov'] = $this->mKunjungan->populasi_toko_by_provinsi();
					$this->template->display('New_sbi_admin_view', $data);
				} else {
					$this->template->display('Sbi_admin_view', $data);
				}
			}
		}else {
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
	
	public function List_region(){
		$data = array();
			
		$list = $this->mKunjungan->getRegion();
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$region = "REGIONAL ".$list_Val->REGION;
				$data[]  = array(
					$list_Val->ID_REGION,
					$region
				);
			}
		} else {
            $data[] = array("","");
        }
		
		$output = array(
            "recordsTotal" => count($list),
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	
	public function List_provinsi(){
		$data = array();
			
		$list = $this->mKunjungan->getProvinsi();
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$data[]  = array(
					$list_Val->ID_PROVINSI,
					$list_Val->NAMA_PROVINSI
				);
			}
		} else {
            $data[] = array("","");
        }
		
		$output = array(
            "recordsTotal" => count($list),
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	
	public function List_area(){
		$data = array();
			
		$list = $this->mKunjungan->getArea();
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$data[]  = array(
					$list_Val->ID_AREA,
					$list_Val->NAMA_AREA
				);
			}
		} else {
            $data[] = array("","");
        }
		
		$output = array(
            "recordsTotal" => count($list),
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	
	public function List_distributor(){
		$data = array();
			
		$list = $this->mKunjungan->getDistributor();
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$data[]  = array(
					$list_Val->KODE_DISTRIBUTOR,
					$list_Val->NAMA_DISTRIBUTOR
				);
			}
		} else {
            $data[] = array("","");
        }
		
		$output = array(
            "recordsTotal" => count($list),
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}


}

?>
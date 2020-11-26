<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    require APPPATH . '/controllers/apis/Auth.php';

    class DashboardKpiDistributor extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model("apis/Model_kpi_distributor", "mKpiDist");
        }
		
		
        public function index_post(){
        	$idDistributor = $this->post("id_distributor");
        	$month = $this->post("month");
        	$year = $this->post("year");

        	$totalDayMonth = $this->calculateDayMonth($month, $year);
            $totalDayAktif = $this->calculateDays(date('d'), $month, $year);
            $prosentaseSdk = (((100 / $totalDayMonth) * $totalDayAktif)/100);

        	$getIndexKpi = $this->mKpiDist->indexKpi($idDistributor, $month, $year);
        	$targetVolume = $this->mKpiDist->targetVolume($idDistributor, $month, $year);
        	$targetHarga = $this->mKpiDist->targetHarga($idDistributor, $month, $year);
        	$realisasiDistributor = $this->mKpiDist->realisasiDistributor($idDistributor, $month, $year);
        	$realisasiKunjungan = $this->mKpiDist->realisasiKunjungan($idDistributor, $month, $year);

        	$data[] = array(
        		"deskripsi_kpi" => "Volume",
        		"satuan" => "ZAK",
        		"index_kpi" => $getIndexKpi->VOLUME,
        		"target" => $targetVolume->VOLUME,
        		"realisasi_bulan" => round($realisasiDistributor->VOLUME),
        		"realisasi_prosentase" => round(($realisasiDistributor->VOLUME / round($prosentaseSdk * $targetVolume->VOLUME)) * 100),
        		"nilai" => round(($realisasiDistributor->VOLUME / round($prosentaseSdk * $targetVolume->VOLUME)) * $getIndexKpi->VOLUME, 1)
        	);

        	$data[] = array(
        		"deskripsi_kpi" => "Harga",
        		"satuan" => "Rupiah/Ton",
        		"index_kpi" => $getIndexKpi->HARGA,
        		"target" => $targetHarga->HARGA * (1.08),
        		"realisasi_bulan" => round($realisasiDistributor->HARGA),
        		"realisasi_prosentase" => round(($realisasiDistributor->HARGA /  ($targetHarga->HARGA * (1.08))) * 100),
        		"nilai" => round(($realisasiDistributor->HARGA /  ($targetHarga->HARGA * (1.08))) * $getIndexKpi->HARGA, 1)
        	);

        	$data[] = array(
        		"deskripsi_kpi" => "Revenue",
        		"satuan" => "Rupiah/Juta",
        		"index_kpi" => $getIndexKpi->REVENUE,
        		"target" => ($targetVolume->VOLUME * $targetHarga->HARGA) / 1000000,
        		"realisasi_bulan" => round($realisasiDistributor->REVENUE / 1000000),
        		"realisasi_prosentase" => round(($realisasiDistributor->REVENUE / round($prosentaseSdk * ($targetVolume->VOLUME * $targetHarga->HARGA))) * 100),
        		"nilai" => round(($realisasiDistributor->REVENUE / round($prosentaseSdk * ($targetVolume->VOLUME * $targetHarga->HARGA))) * $getIndexKpi->REVENUE, 1)
        	);

        	$data[] = array(
        		"deskripsi_kpi" => "Kunjungan",
        		"satuan" => "",
        		"index_kpi" => $getIndexKpi->KUNJUNGAN,
        		"target" => $getIndexKpi->TARGET_KUNJUNGAN,
        		"realisasi_bulan" => $realisasiKunjungan->REALISASI_KUNJUNGAN,
        		"realisasi_prosentase" => round(($realisasiKunjungan->REALISASI_KUNJUNGAN / round($prosentaseSdk * $getIndexKpi->TARGET_KUNJUNGAN)) * 100),
        		"nilai" => round(($realisasiKunjungan->REALISASI_KUNJUNGAN / round($prosentaseSdk * $getIndexKpi->TARGET_KUNJUNGAN)) * $getIndexKpi->KUNJUNGAN, 1)
        	);

			$this->response(array("status"=> "success", "total_kpi" => count($data), "data" => $data));
        }

        function calculateDayMonth($month, $year) {
            error_reporting(0);
            $TotalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $DayCount = array();
            for ($i = 1; $i <= $TotalDays; $i++) {
                $DayOfWeek = date('l', mktime(0, 0, 0, $month, $i, $year));
                $DayCount[$DayOfWeek]++;
            }

            $hariKerja = $DayCount['Sunday'] + $DayCount['Saturday'] + $DayCount['Thursday'] + $DayCount['Friday'] + $DayCount['Monday'] + $DayCount['Tuesday'] + $DayCount['Wednesday'];
            return $hariKerja;
        }

        function calculateDays($day, $month, $year){
            error_reporting(0);
            if($month != date('m')){
                $day = date('t');
            }

            for ($i = 1; $i <= $day; $i++) {
                $DayOfWeek = date('l', mktime(0, 0, 0, $month, $i, $year));
                $DayCount[$DayOfWeek]++;
            }

            $hariKerja = $DayCount['Sunday'] +  $DayCount['Saturday'] + $DayCount['Thursday'] + $DayCount['Friday'] + $DayCount['Monday'] + $DayCount['Tuesday'] + $DayCount['Wednesday'];
            return $hariKerja;
        }

    }
?>
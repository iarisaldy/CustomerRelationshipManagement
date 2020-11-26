<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class DetailKpiSales extends Auth {

        public function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_kpi_sales', "mKpiSales");
        }

        public function index_post(){
            $idUser = $this->post("id_sales");
            $month = $this->post("month");
            $year = $this->post("year");

            $distributor = $this->mKpiSales->userDistributor($idUser);

        	$totalDayMonth = $this->calculateDayMonth($month, $year);
            $totalDayAktif = $this->calculateDays(date('d'), $month, $year);
            $prosentaseSdk = (((100 / $totalDayMonth) * $totalDayAktif)/100);

        	$getIndexKpi = $this->mKpiSales->indexKpi($distributor->KODE_DISTRIBUTOR, $month, $year);
        	$targetSales = $this->mKpiSales->targetSales($idUser, $distributor->KODE_DISTRIBUTOR, $month, $year);
        	$tokoSales = $this->mKpiSales->getTokoSales($idUser);
        	$realisasiVolume = $this->mKpiSales->realisasiVolume($tokoSales->ID_CUSTOMER, $month, $year);
        	$realisasiKunjungan = $this->mKpiSales->realisasiKunjungan($idUser, $month, $year);

        	$data[] = array(
        		"DESKRIPSI" => "Volume",
                "SATUAN" => "ZAK",
        		"INDEX_KPI" => $getIndexKpi->VOLUME,
        		"TARGET_BULAN" => $targetSales->VOLUME,
        		"TARGET_KEMARIN" => round($prosentaseSdk * $targetSales->VOLUME),
        		"TARGET_PROSENTASE" => round($prosentaseSdk * 100),
        		"REALISASI_BULAN" => $realisasiVolume->VOLUME,
        		"REALISASI_PROSENTASE" => round(($realisasiVolume->VOLUME / round($prosentaseSdk * $targetSales->VOLUME)) * 100),
        		"NILAI" => round(($realisasiVolume->VOLUME / round($prosentaseSdk * $targetSales->VOLUME)) * $getIndexKpi->VOLUME, 1)
        	);

        	$data[] = array(
        		"DESKRIPSI" => "HARGA",
                "SATUAN" => "RUPIAH/ZAK",
        		"INDEX_KPI" => $getIndexKpi->HARGA,
        		"TARGET_BULAN" => round($targetSales->HARGA),
        		"TARGET_KEMARIN" => round($targetSales->HARGA),
        		"TARGET_PROSENTASE" => 100,
        		"REALISASI_BULAN" => $realisasiVolume->HARGA,
        		"REALISASI_PROSENTASE" => round(($realisasiVolume->HARGA / $targetSales->HARGA) * 100),
                "NILAI" => round(($realisasiVolume->HARGA / $targetSales->HARGA) * $getIndexKpi->HARGA, 1)
        	);

        	$data[] = array(
        		"DESKRIPSI" => "REVENUE",
                "SATUAN" => "RUPIAH/JUTA",
        		"INDEX_KPI" => $getIndexKpi->REVENUE,
        		"TARGET_BULAN" => round($targetSales->REVENUE / 1000000),
        		"TARGET_KEMARIN" => round(($prosentaseSdk * $targetSales->REVENUE) / 1000000),
        		"TARGET_PROSENTASE" => round($prosentaseSdk * 100),
        		"REALISASI_BULAN" => round($realisasiVolume->REVENUE / 1000000),
        		"REALISASI_PROSENTASE" => round(($realisasiVolume->REVENUE / round($prosentaseSdk * $targetSales->REVENUE)) * 100),
        		"NILAI" => round(($realisasiVolume->REVENUE / round($prosentaseSdk * $targetSales->REVENUE)) * $getIndexKpi->REVENUE, 1)
        	);

        	$data[] = array(
        		"DESKRIPSI" => "KUNJUNGAN",
                "SATUAN" => "",
        		"INDEX_KPI" => $getIndexKpi->KUNJUNGAN,
        		"TARGET_BULAN" => $targetSales->KUNJUNGAN,
        		"TARGET_KEMARIN" => round($prosentaseSdk * $targetSales->KUNJUNGAN),
        		"TARGET_PROSENTASE" => round($prosentaseSdk * 100),
        		"REALISASI_BULAN" => $realisasiKunjungan->TOTAL_KUNJUNGAN,
        		"REALISASI_PROSENTASE" => round(($realisasiKunjungan->TOTAL_KUNJUNGAN / round($prosentaseSdk * $targetSales->KUNJUNGAN)) * 100),
        		"NILAI" => round(($realisasiKunjungan->TOTAL_KUNJUNGAN / round($prosentaseSdk * $targetSales->KUNJUNGAN)) * $getIndexKpi->KUNJUNGAN, 1)
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
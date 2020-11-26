<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class KpiSales extends Auth {

        public function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_kpi_sales', "mKpiSales");
        }


        public function rekapKpi_post(){
        	$idDistributor = $this->post("id_distributor");
        	$start = $this->post("start");
        	$limit = $this->post("limit");
        	$month = $this->post("month");
        	$year = $this->post("year");
        	$jenisOrder = $this->post("jenis_order");
        	$order = $this->post("order");
        	$listSales = $this->mKpiSales->listSales($start, $limit, $idDistributor);
			
			if($listSales) {
				foreach ($listSales as $listSales_key => $listSales_value) {
					$kpi = $this->hitungKpi_get($listSales_value->ID_USER, $listSales_value->KODE_DISTRIBUTOR, $month, $year);
					$dataKpi[] = array(
						"ID_USER" => $listSales_value->ID_USER,
						"NAMA" => $listSales_value->NAMA,
						"DISTRIBUTOR" => $listSales_value->NAMA_DISTRIBUTOR,
						"NILAI_KPI" => $kpi[0][8] + $kpi[1][8] + $kpi[2][8] + $kpi[3][8]
					);
				}

				$orderBy = array();
				foreach ($dataKpi as $user) {
					$orderBy[] = $user[$jenisOrder];
				}

				if($order == "ASC"){
					array_multisort($orderBy, SORT_ASC, $dataKpi);
				} else {
					array_multisort($orderBy, SORT_DESC, $dataKpi);
				}
			}else {
				$dataKpi = null;
			}
        	
        	$response = array("status" => "success", "total" => count($dataKpi), "data" => $dataKpi);
        	$this->response($response);
        }

        public function hitungKpi_get($idUser, $idDistributor, $month, $year){
        	$totalDayMonth = $this->calculateDayMonth($month, $year);
            $totalDayAktif = $this->calculateDays(date('d'), $month, $year);
            $prosentaseSdk = (((100 / $totalDayMonth) * $totalDayAktif)/100);

        	$getIndexKpi = $this->mKpiSales->indexKpi($idDistributor, $month, $year);
        	$targetSales = $this->mKpiSales->targetSales($idUser, $idDistributor, $month, $year);
        	$tokoSales = $this->mKpiSales->getTokoSales($idUser);
        	$realisasiVolume = $this->mKpiSales->realisasiVolume($tokoSales->ID_CUSTOMER, $month, $year);
        	$realisasiKunjungan = $this->mKpiSales->realisasiKunjungan($idUser, $month, $year);
        	$data[] = array(
        		"1",
        		"Volume",
        		$getIndexKpi->VOLUME,
        		$targetSales->VOLUME,
        		round($prosentaseSdk * $targetSales->VOLUME),
        		round($prosentaseSdk * 100),
        		$realisasiVolume->VOLUME,
        		round(($realisasiVolume->VOLUME / round($prosentaseSdk * $targetSales->VOLUME)) * 100),
        		round(($realisasiVolume->VOLUME / round($prosentaseSdk * $targetSales->VOLUME)) * $getIndexKpi->VOLUME, 1)
        	);

        	$data[] = array(
        		"2",
        		"HARGA",
        		$getIndexKpi->HARGA,
        		$targetSales->HARGA,
        		$targetSales->HARGA,
        		100,
        		$realisasiVolume->HARGA,
        		round(($realisasiVolume->HARGA / $targetSales->HARGA) * 100),
                round(($realisasiVolume->HARGA / $targetSales->HARGA) * $getIndexKpi->HARGA, 1)
        	);

        	$data[] = array(
        		"3",
        		"REVENUE",
        		$getIndexKpi->REVENUE,
        		$targetSales->REVENUE,
        		round($prosentaseSdk * $targetSales->REVENUE),
        		round($prosentaseSdk * 100),
        		$realisasiVolume->REVENUE,
        		round(($realisasiVolume->REVENUE / round($prosentaseSdk * $targetSales->REVENUE)) * 100),
        		round(($realisasiVolume->REVENUE / round($prosentaseSdk * $targetSales->REVENUE)) * $getIndexKpi->REVENUE, 1)
        	);

        	$data[] = array(
        		"4",
        		"KUNJUNGAN",
        		$getIndexKpi->KUNJUNGAN,
        		$targetSales->KUNJUNGAN,
        		round($prosentaseSdk * $targetSales->KUNJUNGAN),
        		round($prosentaseSdk * 100),
        		$realisasiKunjungan->TOTAL_KUNJUNGAN,
        		round(($realisasiKunjungan->TOTAL_KUNJUNGAN / round($prosentaseSdk * $targetSales->KUNJUNGAN)) * 100),
        		round(($realisasiKunjungan->TOTAL_KUNJUNGAN / round($prosentaseSdk * $targetSales->KUNJUNGAN)) * $getIndexKpi->KUNJUNGAN, 1)
        	);

        	return $data;
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
        
        public function salesKpi_post(){
			
			$id_tso  = $_POST['id_tso'];
			$bulan	 = $_POST['bulan'];
			$tahun 	 = $_POST['tahun'];
			
			
			$hasil = $this->mKpiSales->get_KPI_sales($id_tso, $bulan, $tahun);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			} else {
				 $response = array("status" => "success", "total" => count($hasil), "message" => "Data Kosong / Tidak Ditemukan");
			}
			
			$this->response($response);
		}
		
		public function grafikKunjungan_post(){
			$id_tso = $_POST['id_tso'];
			$bulan = $_POST['bulan'];
			$tahun = $_POST['tahun'];
			
			//if($bulan < 10){
			//	$bulan = '0'.$bulan;
			//}
			
			$hasil = $this->mKpiSales->GrafikKunjungan($id_tso, $bulan, $tahun);
			
			//if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			//} else {
				 //$response = array("status" => "success", "total" => count($hasil), "message" => "Data Kosong / Tidak Ditemukan");
			//}
			$this->response($response);
		}
		
	}
?>
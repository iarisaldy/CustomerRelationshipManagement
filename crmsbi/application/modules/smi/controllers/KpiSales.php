<?php
    class KpiSales extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Model_KamSales", "mKamSales");
            $this->load->model("Model_kpi", "mKpi");
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
            for ($i = 1; $i <= $day; $i++) {
                $DayOfWeek = date('l', mktime(0, 0, 0, $month, $i, $year));
                $DayCount[$DayOfWeek]++;
            }

            $hariKerja = $DayCount['Sunday'] +  $DayCount['Saturday'] + $DayCount['Thursday'] + $DayCount['Friday'] + $DayCount['Monday'] + $DayCount['Tuesday'] + $DayCount['Wednesday'];
            return $hariKerja;
        }

        public function detailKpiSales($idUser, $bulan, $tahun){
            $level = "0";
            if(isset($bulan)){
                $bulan = $bulan;
            } else {
                $bulan = date('m');
            }

            if(isset($tahun)){
                $tahun = $tahun;
            } else {
                $tahun = date('Y');
            }
            
            if($bulan < 10){
                $bulan = str_replace("0", "", $bulan);
            }

            $getIdentitasUser = $this->mKpi->identitasUser($idUser);
            if($getIdentitasUser){
                $kodeDist = $getIdentitasUser->KODE_DISTRIBUTOR;
                $idRegion = $getIdentitasUser->ID_REGION;
                $tokoBaru = $this->mKpi->getTokoBaru($kodeDist, $bulan, $tahun);
                if($getIdentitasUser->ID_JENIS_USER == "1002"){
                    $idProvinsi = $getIdentitasUser->PROV_DIST;
                } else {
                    $idProvinsi = $getIdentitasUser->ID_PROVINSI;
                }

                if($getIdentitasUser->ID_JENIS_USER == "1003"){
                    $target = $this->mKpi->targetKpiSalesDistributor($idUser, $bulan, $tahun);
                    if($target){
                        $targetHarga = $target->TARGET_HARGA;
                    } else {
                        return 0;
                        exit();
                    }
                    
                    $tokoSales = $this->mKpi->getTokoSales($idUser);
                    if($tokoSales){
                        $realisasi = $this->mKpi->realisasiSales($tokoSales->ID_CUSTOMER, $bulan, $tahun);
                    }
                    if(!$target){
                        $data[] = array("-","-","-","-","-","-","-","-",0);
                        $output = array(array());
                        exit();
                    }
                } else {
                    $target = $this->mKpi->targetVolumeHargaRevenueUser($kodeDist, $idProvinsi, $bulan, $tahun);
                    if($level == "distributor"){
                        $targetHarga = $target->TARGET_HARGA * (1.08);
                    } else {
                        $targetHarga = $target->TARGET_HARGA;
                    }

                    if($level == "distributor"){                        
                        $realisasi = $this->mKpi->realisasiDataDistSidigi($kodeDist, $idProvinsi, $bulan, $tahun);
                    } else {
                        $realisasi = $this->mKpi->realisasiVolumeHarhaRevenueUser($kodeDist, $idProvinsi, $bulan, $tahun);
                    }
                }
            }


            $getIndexKpi = $this->mKpi->indexKpiUser($idRegion, $bulan, $tahun);
            $targetKeep = $this->mKpi->targetKeep($bulan, $tahun, $kodeDist);
            $realisasiKeep = $this->mKpi->realisasiKeep($bulan, $tahun, $kodeDist);
            $targetGrowth = $this->mKpi->targetGrowth($bulan, $tahun, $kodeDist);
            $realisasiGrowth = $this->mKpi->realisasiGrowth($bulan, $tahun, $kodeDist);
            if($getIdentitasUser->ID_JENIS_USER == "1002" || $getIdentitasUser->ID_JENIS_USER == "1007"){
                $idDistributor = $this->session->userdata("kode_dist");
                $kunjungan = $this->mKpi->rekapKunjunganDist($idDistributor, $bulan, $tahun);
            } else {
                $kunjungan = $this->mKpi->kpi_kunjungan($idUser, $idRegion, $bulan, $tahun);
            }

            $realisasiSo = $this->mKpi->realisasiSo($kodeDist, $bulan, $tahun);
            $listGudangDist = $this->mKpi->listGudangDist($kodeDist);
            $getTargetCustomer = $this->mKpi->targetCustomer($bulan, $tahun, $kodeDist);

            $totalDayMonth = $this->calculateDayMonth($bulan, $tahun);
            $totalDayAktif = $this->calculateDays(date('d'), $bulan, $tahun);
            $prosentaseSdk = (((100 / $totalDayMonth) * $totalDayAktif)/100);

            $data[] = array(
                1,
                "Volume (Zak)",
                $getIndexKpi->VOLUME,
                number_format($target->TARGET_VOLUME),
                number_format(round($prosentaseSdk * $target->TARGET_VOLUME)),
                round($prosentaseSdk * 100)."%",
                number_format($realisasi->VOLUME),
                round(($realisasi->VOLUME / round($prosentaseSdk * $target->TARGET_VOLUME)) * 100)."%",
                round(($realisasi->VOLUME / round($prosentaseSdk * $target->TARGET_VOLUME)) * $getIndexKpi->VOLUME, 1)
            );

            $data[] = array(
                2,
                "Harga (Rupiah/Ton)",
                $getIndexKpi->HARGA,
                "Rp ".number_format($targetHarga),
                "Rp ".number_format($targetHarga),
                round(($targetHarga / $targetHarga) * 100, 1)."%",
                "Rp ".number_format($realisasi->HARGA),
                round(($realisasi->HARGA / $targetHarga) * 100)."%",
                round(($realisasi->HARGA / $targetHarga) * $getIndexKpi->HARGA, 1)
            );

            $data[] = array(
                3,
                "Revenue (Rupiah/Juta)",
                $getIndexKpi->REVENUE,
                "Rp ".number_format($target->TARGET_REVENUE / 1000000),
                "Rp ".number_format(round(($prosentaseSdk * $target->TARGET_REVENUE) / 1000000)),
                round($prosentaseSdk * 100)."%",
                "Rp ".number_format($realisasi->REVENUE / 1000000),
                round(($realisasi->REVENUE / round($prosentaseSdk * $target->TARGET_REVENUE)) * 100)."%",
                round(($realisasi->REVENUE / round($prosentaseSdk * $target->TARGET_REVENUE)) * $getIndexKpi->REVENUE, 1)
            );

            if($kunjungan){
                foreach ($kunjungan as $kunjunganKey => $kunjunganValue) {
                    if($getIdentitasUser->ID_JENIS_USER == "1003"){
                        $targetKunjungan = $kunjunganValue->TARGET_SALES_KUNJUNGAN;
                    } else if($getIdentitasUser->ID_JENIS_USER == "1002"){
                        $targetKunjungan = $kunjunganValue->TARGET_KUNJUNGAN;
                    } else {
                        $targetKunjungan = $kunjunganValue->TARGET_KUNJUNGAN;
                    }

                    $rencanaKunjungan = round($targetKunjungan / $totalDayMonth) * $totalDayAktif;
                    $realisasiKunjungan = $kunjunganValue->JUMLAH_REALISASI / $targetKunjungan; 
                    $data[] = array(
                        4,
                        "Kunjungan",
                        $kunjunganValue->INDEX_KUNJUNGAN,
                        $targetKunjungan,
                        round($prosentaseSdk * $targetKunjungan),
                        round($prosentaseSdk * 100)."%",
                        $kunjunganValue->JUMLAH_REALISASI,
                        round(($kunjunganValue->JUMLAH_REALISASI / round($prosentaseSdk * $targetKunjungan)) * 100)."%",
                        round(($kunjunganValue->JUMLAH_REALISASI / round($prosentaseSdk * $targetKunjungan)) * $kunjunganValue->INDEX_KUNJUNGAN, 1)
                    );
                }
            } else {
                $data[] = array("-","-","-","-","-","-","-","-",0);
            }

            $data[] = array(
            	5,
            	"Get",
            	$getIndexKpi->GET,
            	$getTargetCustomer->TARGET_GET,
            	round($prosentaseSdk * $getTargetCustomer->TARGET_GET),
            	round($prosentaseSdk * 100)." %",
            	$tokoBaru->JML_TOKO_BARU,
            	round(($tokoBaru->JML_TOKO_BARU / round($prosentaseSdk * $getTargetCustomer->TARGET_GET)) * 100)."%",
            	round(($tokoBaru->JML_TOKO_BARU / round($prosentaseSdk * $getTargetCustomer->TARGET_GET)) * 10)
            );

            $data[] = array(
            	6,
            	"Keep",
            	$getIndexKpi->KEEP,
            	$targetKeep,
             	$targetKeep,
            	"100 %",
            	$realisasiKeep,
            	round(($realisasiKeep / $targetKeep) * 100)." %",
            	round(($realisasiKeep / $targetKeep) * $getIndexKpi->KEEP)
            );

            $data[] = array(
            	7,
            	"Growth",
            	$getIndexKpi->GROWTH,
            	$targetGrowth->PENJUALAN_TON,
            	round($prosentaseSdk * $targetGrowth->PENJUALAN_TON),
                round($prosentaseSdk * 100)."%",
            	$realisasiGrowth->PENJUALAN_TON,
            	round(((int)$realisasiGrowth->PENJUALAN_TON / round($prosentaseSdk * (int)$targetGrowth->PENJUALAN_TON)) * 100)." %",
            	round(((int)$realisasiGrowth->PENJUALAN_TON / (int)$targetGrowth->PENJUALAN_TON) * $getIndexKpi->GROWTH),
            );

            foreach($realisasiSo as $realisasiSoKey => $realisasiSoValue){
                $data[] = array(
                    8,
                    "Sales Order",
                    $getIndexKpi->SO_DO,
                    $realisasiSoValue->TOTAL,
                    round($prosentaseSdk * $realisasiSoValue->TOTAL),
                    round($prosentaseSdk * 100)."%",
                    $realisasiSoValue->REAL,
                    round($realisasiSoValue->REAL / round($prosentaseSdk * $realisasiSoValue->TOTAL) * 100)."%",
                    round($realisasiSoValue->REAL / round($prosentaseSdk * $realisasiSoValue->TOTAL) * $getIndexKpi->SO_DO, 1)
                );
            }
            
            return round($data[0][8] + $data[1][8] + $data[2][8] + $data[3][8] + $data[4][8] + $data[5][8] + $data[6][8] + $data[7][8]);
        }

    }
?>
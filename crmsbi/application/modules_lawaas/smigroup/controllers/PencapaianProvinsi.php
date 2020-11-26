<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class PencapaianProvinsi extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        $this->load->model('PencapaianProvinsi_model');
        date_default_timezone_set("Asia/Jakarta");
    }

    function index() {
        $data = array('title' => 'Semen Gresik');
        $this->template->display('PencapaianProvinsi_view', $data);
    }

    function scodata($tahun, $bulan, $hari, $region) {
        date_default_timezone_set("Asia/Jakarta");

        $data = $this->PencapaianProvinsi_model->scodataRegion($tahun, $bulan, $hari, $region);
//        echo $this->db->last_query();
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $demand = $this->PencapaianProvinsi_model->getDemandNasionalRegion($tahun, $bulan, $harik, $region);
        $rkapms = $this->PencapaianProvinsi_model->getRKAPMS($tahun);
        $total = $this->PencapaianProvinsi_model->scodatamvSumRegion($tahun, $bulan, $harik, $region);
        //  echo $this->db->last_query();
        foreach ($data as $key => $value) {
            $persenBulan = $this->getPersen($value['REAL'], $value['TARGET']);
            $persenHari = $this->getPersen($value['REAL'], $value['TARGET_REALH']);
            $data[$key]['PERSENBULAN'] = round($persenBulan);
            $data[$key]['PERSENHARI'] = round($persenHari);
            $data[$key]['RKAP_MS'] = str_replace('.', ',', round($data[$key]['RKAP_MS'], 1));
            $data[$key]['MARKETSHARE'] = str_replace('.', ',', round($value['MARKETSHARE'], 1));
        }
        $total['TARGET_REALH'] = round($total['TARGET_REALH']);
        $total['REAL'] = round($total['REAL']);
        $total['PENCSEH'] = round($this->getPersen($total['TARGET_REALH'], $total['TARGET']));

        echo json_encode(array("sales" => $data, "ms" => $demand, "rkapms" => $rkapms, "total" => $total));
    }

    function scodataBag($tahun, $bulan, $hari, $region) {
        date_default_timezone_set("Asia/Jakarta");
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->PencapaianProvinsi_model->scodatasgBagNewRegion($tahun, $bulan, $hari, $region);
        $total = $this->PencapaianProvinsi_model->scodatamvSumRegion($tahun, $bulan, $harik, $region);
        $total['PENCSEH'] = round($this->getPersen($total['TARGET_REALH'], $total['TARGET']));

        $bulanBaru = date('t', strtotime($tahun . "-" . $bulan));
        foreach ($data as $key => $value) {
            $persenBulan = $this->getPersen($value['REAL'], $value['TARGET']);
            $persenHari = $this->getPersen($value['REAL'], $value['TARGET_REALH']);
            $data[$key]['PERSENBULAN'] = round($persenBulan);
            $data[$key]['PERSENHARI'] = round($persenHari);
            // $data[$key]['KABIRO'] = ucwords($value['NAMA_KABIRO']);
        }
        echo json_encode(array('DATAPROV' => $data, 'TOTAL' => $total));
    }

    function scodataBulk($tahun, $bulan, $hari, $region) {
        date_default_timezone_set("Asia/Jakarta");
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->PencapaianProvinsi_model->scodatasgBulkNewRegion($tahun, $bulan, $hari, $region);
        $total = $this->PencapaianProvinsi_model->scodatamvSumRegion($tahun, $bulan, $harik, $region);
        $total['PENCSEH'] = round($this->getPersen($total['TARGET_REALH'], $total['TARGET']));
        
        $bulanBaru = date('t', strtotime($tahun . "-" . $bulan));
//        foreach ($data as $key => $row) {
//            if (empty($row['TARGET_REALH'])) {
//                $tRealH = ($row['TARGET'] * $hari) / $bulanBaru;
//                $data[$key]['TARGET_REALH'] = $tRealH;
//            }
//        }
        foreach ($data as $key => $value) {
            $persenBulan = $this->getPersen($value['REAL'], $value['TARGET']);
            $persenHari = $this->getPersen($value['REAL'], $value['TARGET_REALH']);
            $data[$key]['PERSENBULAN'] = round($persenBulan);
            $data[$key]['PERSENHARI'] = round($persenHari);
            // $data[$key]['KABIRO'] = ucwords($value['NAMA_KABIRO']);
        }
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
        echo json_encode(array('DATAPROV' => $data, 'TOTAL' => $total));
    }

    function getDataChart($tahun, $bulan, $hari, $region) {
//        $tahun = '2016';
//        $bulan = '09';
        $dataset = array();
        $tonase_real = array();
        $tonase_target = array();
        $tonase_targetsd = array();
        $target = array();
        $targetsd = array();
        $kabiro = array();
        $biro = array();
        $labels = array();

        if ($region == 'all') {
            $region = '1,2,3,4';
        } else if ($region == 'curah') {
            $region = '4';
        }
        $data = $this->PencapaianProvinsi_model->get_chart_volume($tahun, $bulan, $hari, $region);
        // echo $this->db->last_query();
        foreach ($data as $key => $value) {
            $real = str_replace(',', '.', $value['REAL']);
            $targetrkap = str_replace(',', '.', $value['TARGET']);
            $target_realh = str_replace(',', '.', $value['TARGET_REALH']);
            //$nilai = round($this->getPersen($real,$targetrkap));
            //$nilaisd = round($this->getPersen($target_realh,$targetrkap));
            array_push($labels, $value['DESC_KABIRO']);
            array_push($kabiro, $value['NAMA_KABIRO']);
            array_push($tonase_target, $targetrkap);
            array_push($tonase_targetsd, $target_realh);
            array_push($tonase_real, $real);
            array_push($dataset, $value['PERSENTARGET']);
            array_push($targetsd, $value['PERSENTARGETH']);
            array_push($target, 100);
        }

        $jmlHari = date('t', strtotime($tahun . "-" . $bulan));

//        if ($region==1)
//        {
//            $labels = array("Biro Penj 1", "Biro Penj 2");
//            $biro = array("Biro Penj 1", "Biro Penj 2");
//            foreach ($biro as $key => $value) {
//                $dataBag[] = $this->PencapaianProvinsi_model->getChartBagNewRegion($tahun, $bulan, $hari, $region,$value);        
//            }
//        }elseif($region==2)
//        {
//            $labels = array("Biro Penj 3", "Biro Penj 4", "Biro Penj 5");
//            $biro = array("Biro Penj 3", "Biro Penj 4", "Biro Penj 5");
//            foreach ($biro as $key => $value) {
//                $dataBag[] = $this->PencapaianProvinsi_model->getChartBagNewRegion($tahun, $bulan, $hari, $region,$value);        
//            }
//        }elseif ($region==3) {
//            $labels = array("Biro Penj 7", "Biro Penj 8", "Biro Penj 9");
//            $biro = array("Biro Penj 7", "Biro Penj 8", "Biro Penj 9");
//            foreach ($biro as $key => $value) {
//                $dataBag[] = $this->PencapaianProvinsi_model->getChartBagNewRegion($tahun, $bulan, $hari, $region,$value);        
//            }
//        }elseif ($region=="all"){
//            $labels = array("Biro Penj 1", "Biro Penj 2", "Biro Penj 3", "Biro Penj 4", "Biro Penj 5", "Biro Penj 7", "Biro Penj 8", "Biro Penj 9","Curah");
//            $biro = array("Biro Penj 1", "Biro Penj 2", "Biro Penj 3", "Biro Penj 4", "Biro Penj 5", "Biro Penj 7", "Biro Penj 8", "Biro Penj 9");
//            foreach ($biro as $key => $value) {
//                $dataBag[] = $this->PencapaianProvinsi_model->getChartBagNewRegion($tahun, $bulan, $hari, $region,$value);
//                 echo $this->db->last_query();
//            }
//            $biro[] = "Biro Penj 6";
//            $dataBulk = $this->PencapaianProvinsi_model->getChartBulkNewRegion($tahun, $bulan, $hari, $region);
//        }elseif(strtolower($region)=="curah"){
//            $labels = array("Curah");
//            $biro = array("Biro Penj 6");
//            $dataBulk = $this->PencapaianProvinsi_model->getChartBulkNewRegion($tahun, $bulan, $hari, $region);
//        }
        // $dataBulk = $this->PencapaianProvinsi_model->getChartBulkNewRegion($tahun, $bulan, $hari, $region);
        // $datasetBag = $this->PencapaianProvinsi_model->getChartBagNewRegion($tahun, $bulan, $hari, $region);
        //mendapatkan nama kabiro
        /*
          $kabiro[0] = $dataBag[0]['NAMA_KABIRO'];
          $kabiro[1] = $dataBag[1]['NAMA_KABIRO'];
          $kabiro[2] = $dataBag[2]['NAMA_KABIRO'];
          $kabiro[3] = $dataBag[3]['NAMA_KABIRO'];pro
          $kabiro[4] = $dataBag[4]['NAMA_KABIRO'];
         */


        /**
         * EDITED DASHBOARD TEAM
         */
        //mendapatkan nama kabiro
        // tambah untuk curah
        // $biro[] = "Biro Penj 6";
//        foreach ($biro as $key => $value) {
//            $kabiro[] = $value;
//        }
//        $data = array();
//        foreach ($dataBag as $key => $value) {
//                $data[$key]['TARGET'] = str_replace(',', '.', $value[0]['TARGET']);
//                $data[$key]['REAL'] = str_replace(',', '.', $value[0]['REAL']);
//                $data[$key]['TARGET_REALH'] = str_replace(',', '.', $value[0]['TARGET_REALH']);            
//        }
//        $idxcurah = count($data);
//        foreach ($dataBulk as $key => $value) {
//                $data[$idxcurah]['TARGET'] = str_replace(',', '.', $value['TARGET']);
//                $data[$idxcurah]['REAL'] = str_replace(',', '.', $value['REAL']);
//                $data[$idxcurah]['TARGET_REALH'] = str_replace(',', '.', $value['TARGET_REALH']);            
//        }
        // $data[0]['TARGET'] = str_replace(',', '.', $dataBag[0]['TARGET']);
        // $data[0]['REAL'] = str_replace(',', '.', $dataBag[0]['REAL']);
        // $data[0]['TARGET_REALH'] = str_replace(',', '.', $dataBag[0]['TARGET_REALH']);
        // $data[1]['TARGET'] = str_replace(',', '.', $dataBag[1]['TARGET']);
        // $data[1]['REAL'] = str_replace(',', '.', $dataBag[1]['REAL']);
        // $data[1]['TARGET_REALH'] = str_replace(',', '.', $dataBag[1]['TARGET_REALH']);
        // $data[2]['TARGET'] = str_replace(',', '.', $dataBag[2]['TARGET']);
        // $data[2]['REAL'] = str_replace(',', '.', $dataBag[2]['REAL']);
        // $data[2]['TARGET_REALH'] = str_replace(',', '.', $dataBag[2]['TARGET_REALH']);
        // $data[3]['TARGET'] = str_replace(',', '.', $dataBag[3]['TARGET']);
        // $data[3]['REAL'] = str_replace(',', '.', $dataBag[3]['REAL']);
        // $data[3]['TARGET_REALH'] = str_replace(',', '.', $dataBag[3]['TARGET_REALH']);
        // $data[4] = $dataBulk[0];
//        foreach ($data as $value) {
//            $real = str_replace(',', '.', $value['REAL']);
//            $targetrkap = str_replace(',', '.', $value['TARGET']);
//            $target_realh = str_replace(',', '.', $value['TARGET_REALH']);
//            $nilai = round($this->getPersen($real,$targetrkap));
//            $nilaisd = round($this->getPersen($target_realh,$targetrkap));
//            array_push($dataset, $nilai);
//            array_push($targetsd, $nilaisd);
//            array_push($target, 100);
//            array_push($tonase_real, round($real));
//            array_push($tonase_target, round($targetrkap));
//            array_push($tonase_targetsd, round($target_realh));
//        }
//        echo '<pre>';
//        print_r(array("dataset"=>$dataset,"labels"=>$labels));
//        echo '</pre>';
        echo json_encode(array(
            "dataset" => $dataset,
            "labels" => $labels,
            "target" => $target,
            "targetsd" => $targetsd,
            "tonase_real" => $tonase_real,
            "tonase_target" => $tonase_target,
            "tonase_targetsd" => $tonase_targetsd,
            "jml_hari" => $jmlHari,
            "kabiro" => $kabiro));
    }

    public function revenueKabiro($tahun, $bulan, $hari, $region) {
        $dataset = array();
        $tonase_real = array();
        $tonase_target = array();
        $tonase_targetsd = array();
        $target = array();
        $targetsd = array();
        $kabiro = array();
        $labels = array("Wil 1", "Wil 2", "Wil 3", "Wil 4", "Curah");
        $jmlHari = date('t', strtotime($tahun . "-" . $bulan));
        $biro = array();
        $data = array();
        if ($region == 1) {
            $labels = array("Biro Penj 1", "Biro Penj 2");
            $biro = array("Biro Penj 1", "Biro Penj 2");
            foreach ($biro as $key => $value) {
                $data[] = $this->PencapaianProvinsi_model->RevenuePerKabiroRegion($tahun, $bulan, $hari, $region, $value);
            }
        } elseif ($region == 2) {
            $labels = array("Biro Penj 3", "Biro Penj 4", "Biro Penj 5");
            $biro = array("Biro Penj 3", "Biro Penj 4", "Biro Penj 5");
            foreach ($biro as $key => $value) {
                $data[] = $this->PencapaianProvinsi_model->RevenuePerKabiroRegion($tahun, $bulan, $hari, $region, $value);
            }
        } elseif ($region == 3) {
            $labels = array("Biro Penj 7", "Biro Penj 8", "Biro Penj 9");
            $biro = array("Biro Penj 7", "Biro Penj 8", "Biro Penj 9");
            foreach ($biro as $key => $value) {
                $data[] = $this->PencapaianProvinsi_model->RevenuePerKabiroRegion($tahun, $bulan, $hari, $region, $value);
            }
        } elseif (strtolower($region) == "all") {
            $labels = array("Biro Penj 1", "Biro Penj 2", "Biro Penj 3", "Biro Penj 4", "Biro Penj 5", "Biro Penj 7", "Biro Penj 8", "Biro Penj 9", "Curah");
            $biro = array("Biro Penj 1", "Biro Penj 2", "Biro Penj 3", "Biro Penj 4", "Biro Penj 5", "Biro Penj 7", "Biro Penj 8", "Biro Penj 9");
            $biro[] = "Biro Penj 6";
            foreach ($biro as $key => $value) {
                $data[] = $this->PencapaianProvinsi_model->RevenuePerKabiroRegion($tahun, $bulan, $hari, $region, $value);
            }
        } elseif (strtolower($region) == "curah") {
            $labels = array("Curah");
            $biro2[] = "Biro Penj 6";
            foreach ($biro2 as $key => $value) {
                $data[] = $this->PencapaianProvinsi_model->RevenuePerKabiroRegion($tahun, $bulan, $hari, $region, $value);
            }
        }

        // $data = $this->PencapaianProvinsi_model->RevenuePerKabiroRegion($tahun, $bulan, $hari, $region);
        // echo '<pre>';
        // print_r($data);
        // exit(); 
        // $biro[] = "Biro Penj 6";
        foreach ($biro as $key => $value) {
            $kabiro[] = $value;
        }

        if (strtolower($region) == "curah") {
            foreach ($data as $key => $datum) {
                // foreach($datum as $value){
                $real = str_replace(',', '.', $datum[1]['REAL_REVENUE']);
                $targetrkap = str_replace(',', '.', $datum[1]['TARGET_REVENUE']);
                $target_realh = str_replace(',', '.', $datum[1]['TARGET_REVENUE_SDK']);
                $nilai = round($this->getPersen($real, $targetrkap));
                $nilaisd = round($this->getPersen($target_realh, $targetrkap));
                array_push($dataset, $nilai);
                array_push($targetsd, $nilaisd);
                array_push($target, 100);
                array_push($tonase_real, round($real));
                array_push($tonase_target, round($targetrkap));
                array_push($tonase_targetsd, round($target_realh));
                // array_push($kabiro,$value['NAMA_KABIRO']);
                // }    
            }
        } else {
            foreach ($data as $key => $datum) {
                // foreach($datum as $value){
                $real = str_replace(',', '.', $datum[0]['REAL_REVENUE']);
                $targetrkap = str_replace(',', '.', $datum[0]['TARGET_REVENUE']);
                $target_realh = str_replace(',', '.', $datum[0]['TARGET_REVENUE_SDK']);
                $nilai = round($this->getPersen($real, $targetrkap));
                $nilaisd = round($this->getPersen($target_realh, $targetrkap));
                array_push($dataset, $nilai);
                array_push($targetsd, $nilaisd);
                array_push($target, 100);
                array_push($tonase_real, round($real));
                array_push($tonase_target, round($targetrkap));
                array_push($tonase_targetsd, round($target_realh));
                // array_push($kabiro,$value['NAMA_KABIRO']);
                // }    
            }
        }

        echo json_encode(array(
            "dataset" => $dataset,
            "labels" => $labels,
            "target" => $target,
            "targetsd" => $targetsd,
            "tonase_real" => $tonase_real,
            "tonase_target" => $tonase_target,
            "tonase_targetsd" => $tonase_targetsd,
            "jml_hari" => $jmlHari,
            "kabiro" => $kabiro));
    }

    function getPersen($a, $b) {
        if ($b == 0 || $b == '') {
            return 0;
        } else {
            return $a / $b * 100;
        }
    }

    function refresh_data() {

        $data = $this->PencapaianProvinsi_model->refresh_mv();
        echo json_encode($data);
    }

}

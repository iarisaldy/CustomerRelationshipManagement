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

    function scodata($tahun, $bulan, $hari) {
        date_default_timezone_set("Asia/Jakarta");

        $data = $this->PencapaianProvinsi_model->scodatasgNew($tahun, $bulan, $hari);
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $demand = $this->PencapaianProvinsi_model->getDemandNasional($tahun, $bulan, $harik);
        $rkapms = $this->PencapaianProvinsi_model->getRKAPMS($tahun);
        $total = $this->PencapaianProvinsi_model->scodatamvSum('7000',$tahun,$bulan,$harik);
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

        echo json_encode(array("sales" => $data, "ms" => $demand,"rkapms"=>$rkapms,"total"=>$total));
    }

    function scodataBag($tahun, $bulan, $hari) {
        date_default_timezone_set("Asia/Jakarta");

        $data = $this->PencapaianProvinsi_model->scodatasgBagNew($tahun, $bulan, $hari);
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
            $data[$key]['KABIRO'] = ucwords($value['NAMA_KABIRO']);
        }
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
        echo json_encode($data);
    }

    function scodataBulk($tahun, $bulan, $hari) {
        date_default_timezone_set("Asia/Jakarta");

        $data = $this->PencapaianProvinsi_model->scodatasgBulkNew($tahun, $bulan, $hari);
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
            $data[$key]['KABIRO'] = ucwords($value['NAMA_KABIRO']);
        }
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
        echo json_encode($data);
    }

    function getDataChart($tahun, $bulan, $hari) {
//        $tahun = '2016';
//        $bulan = '09';
        $dataset = array();
        $tonase_real = array();
        $tonase_target = array();
        $tonase_targetsd = array();
        $target = array();
        $targetsd = array();
        $kabiro = array();
        $labels = array("Wil 1", "Wil 2", "Wil 3", "Wil 4", "Curah");
        $dataBag = $this->PencapaianProvinsi_model->getChartBagNew($tahun, $bulan, $hari);
        $dataBulk = $this->PencapaianProvinsi_model->getChartBulkNew($tahun, $bulan, $hari);
        $jmlHari = date('t',  strtotime($tahun."-".$bulan));
        //mendapatkan nama kabiro
        $kabiro[0] = $dataBag[0]['NAMA_KABIRO'];
        $kabiro[1] = $dataBag[1]['NAMA_KABIRO'];
        $kabiro[2] = $dataBag[2]['NAMA_KABIRO'];
        $kabiro[3] = $dataBag[3]['NAMA_KABIRO'];
        $kabiro[4] = $dataBulk[0]['NAMA_KABIRO'];


        $data[0]['TARGET'] = str_replace(',', '.', $dataBag[0]['TARGET']);
        $data[0]['REAL'] = str_replace(',', '.', $dataBag[0]['REAL']);
        $data[0]['TARGET_REALH'] = str_replace(',', '.', $dataBag[0]['TARGET_REALH']);
        $data[1]['TARGET'] = str_replace(',', '.', $dataBag[1]['TARGET']);
        $data[1]['REAL'] = str_replace(',', '.', $dataBag[1]['REAL']);
        $data[1]['TARGET_REALH'] = str_replace(',', '.', $dataBag[1]['TARGET_REALH']);
        $data[2]['TARGET'] = str_replace(',', '.', $dataBag[2]['TARGET']);
        $data[2]['REAL'] = str_replace(',', '.', $dataBag[2]['REAL']);
        $data[2]['TARGET_REALH'] = str_replace(',', '.', $dataBag[2]['TARGET_REALH']);
        $data[3]['TARGET'] = str_replace(',', '.', $dataBag[3]['TARGET']);
        $data[3]['REAL'] = str_replace(',', '.', $dataBag[3]['REAL']);
        $data[3]['TARGET_REALH'] = str_replace(',', '.', $dataBag[3]['TARGET_REALH']);

        $data[4] = $dataBulk[0];


        foreach ($data as $value) {
            $real = str_replace(',', '.', $value['REAL']);
            $targetrkap = str_replace(',', '.', $value['TARGET']);
            $target_realh = str_replace(',', '.', $value['TARGET_REALH']);
            $nilai = round($this->getPersen($real,$targetrkap));
            $nilaisd = round($this->getPersen($target_realh,$targetrkap));
            array_push($dataset, $nilai);
            array_push($targetsd, $nilaisd);
            array_push($target, 100);
            array_push($tonase_real, round($real));
            array_push($tonase_target, round($targetrkap));
            array_push($tonase_targetsd, round($target_realh));
        }

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

    public function revenueKabiro($tahun, $bulan, $hari) {
        $dataset = array();
        $tonase_real = array();
        $tonase_target = array();
        $tonase_targetsd = array();
        $target = array();
        $targetsd = array();
        $kabiro = array();
        $labels = array("Wil 1", "Wil 2", "Wil 3","Wil 4", "Curah");
        $jmlHari = date('t',  strtotime($tahun."-".$bulan));
        $data = $this->PencapaianProvinsi_model->RevenuePerKabiro($tahun, $bulan, $hari);
        
        foreach($data as $value){
            $real = str_replace(',', '.', $value['REAL_REVENUE']);
            $targetrkap = str_replace(',', '.', $value['TARGET_REVENUE']);
            $target_realh = str_replace(',', '.', $value['TARGET_REVENUE_SDK']);
            $nilai = round($this->getPersen($real,$targetrkap));
            $nilaisd = round($this->getPersen($target_realh,$targetrkap));
            array_push($dataset, $nilai);
            array_push($targetsd, $nilaisd);
            array_push($target, 100);
            array_push($tonase_real, round($real));
            array_push($tonase_target, round($targetrkap));
            array_push($tonase_targetsd, round($target_realh));
            array_push($kabiro,$value['NAMA_KABIRO']);
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
}

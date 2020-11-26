<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class TabelKeputusan extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        $this->load->model('TabelKeputusan_model');
    }

    function index() {
        $data = array(
            'title' => 'DSS',
            'provinsi' => $this->TabelKeputusan_model->getProvinsi()
            );
        $this->template->display('TabelKeputusan_view', $data);
    }

    function getData() {
        set_time_limit(0);
        $transit_hasil = $this->TabelKeputusan_model->getRptReal();
        $aarSql = $this->TabelKeputusan_model->getPeta();

        $sdr = 0;
        $tur = 0;
        $scr = 0;
        //$current_date = date("Y-m-d H:i:s");

        for ($i = 0; $i < sizeof($aarSql); $i++) {
            $kwantum = 0;
            $jml_truk = 0;
            $sisa_so = 0;
            foreach ($transit_hasil as $data) {
                //$tgl_berangkat = $transit_hasil[$i]['TGL_BERANGKAT'];
                //$diff_time = round((strtotime($current_date) - strtotime($tgl_berangkat))/60/60,1);
                if ($data['KODE_DA'] == $aarSql[$i]['KD_GDG']) {
                    //if($diff_time <= ($transit_hasil[$i]['LEAD_TIME']*2)){
                    $kwantum+=$data['KWANTUMX'];
                    $jml_truk = $data['JML_TRUK'];
                    $sisa = $this->TabelKeputusan_model->getSisaSO($data['KODE_DA']);
                    if($sisa){
                        $sisa_so = $sisa['SISA_TO'];    
                    }
                    //}                    
                    // $sisa_so = $data['SISA_TO'];
                }
            }
//            if (is_null($aarSql[$i]['AVGSTOK']) && isset($aarSql[$i]['KD_GDG'])) {
//                //echo $aarSql[$i]['KD_GDG'].'<br/>';
//                $kode = $aarSql[$i]['KD_GDG'];
//
//                $data = $this->StockLevelGudang_model->getStokSebelumnya($kode);
//
//                foreach ($data as $value) {
//                    $aarSql[$i]['AVGSTOK'] = $value['AVGSTOK'];
//                }
//            }
            $demand = $aarSql[$i]['QTY_RILIS'];
            $aarSql[$i]['DEMAND'] = round($demand / 7);
            $leadtime = $this->TabelKeputusan_model->getLeadTime($aarSql[$i]['KD_DISTRIK']);
            if (isset($leadtime)) {
                $aarSql[$i]['LEADTIME'] = round(($leadtime['STANDART_AREA']+8)/24, 2);
            } else {
                $aarSql[$i]['LEADTIME'] = round(8/24, 2);
            }

            $aarSql[$i]['TRANSIT'] = $kwantum;
            $aarSql[$i]['SISA_TO'] = $sisa_so;
            $aarSql[$i]['JML_TRUK'] = $jml_truk;

            if ($aarSql[$i]['STOK'] < 0) {
                $aarSql[$i]['STOK'] = 0;
                $aarSql[$i]['STOK_LEVEL'] = 0;
            } else {
                $aarSql[$i]['STOK'] = round(str_replace(',', '.', $aarSql[$i]['STOK']));
            }
            if ($aarSql[$i]['KAPASITAS'] != 0) {
                $aarSql[$i]['TOTAL_LEVEL'] = floor(($aarSql[$i]['TRANSIT'] + $aarSql[$i]['STOK']) / $aarSql[$i]['KAPASITAS'] * 100);
                $aarSql[$i]['TOTAL_LEVEL_ONHAND'] = round(($aarSql[$i]['STOK'] / $aarSql[$i]['KAPASITAS'] * 100),2);
            } else {
                $aarSql[$i]['TOTAL_LEVEL'] = "";
            }
            if ($aarSql[$i]['LEADTIME'] <= 0 || $aarSql[$i]['DEMAND'] <= 0) {
                $sdr = 0;
            } else {
                $lt = $aarSql[$i]['LEADTIME'];
                if($lt <= 1){
                    $lt = 1;
                }
                $sdr = ($aarSql[$i]['STOK'] + $aarSql[$i]['TRANSIT']) / ($lt * $aarSql[$i]['DEMAND']);
            }
            if ($aarSql[$i]['LEADTIME'] <= 0 || $aarSql[$i]['LOAD_TRUK'] <= 0) {
                $tur = 0;
            } else {
                $lt = $aarSql[$i]['LEADTIME'];
                if($lt <= 1){
                    $lt = 1;
                }
                $tur = ($aarSql[$i]['JML_TRUK']) / ($lt * $aarSql[$i]['LOAD_TRUK']);
            }
            if ($aarSql[$i]['KAPASITAS'] <= 0) {
                $scr = 0;
            } else {
                $lt = $aarSql[$i]['LEADTIME'];
                if($lt <= 1){
                    $lt = 1;
                }
                $scr = ($aarSql[$i]['STOK'] + $aarSql[$i]['TRANSIT'] - $aarSql[$i]['DEMAND'] * $lt) / $aarSql[$i]['KAPASITAS'];
                if($scr<0){
                    $scr = 0;
                }
            }
            $aarSql[$i]['SDR'] = round($sdr, 2);
            $aarSql[$i]['TUR'] = round($tur, 2);
            $aarSql[$i]['SCR'] = round($scr, 2);
            $aarSql[$i]['STOK'] = $aarSql[$i]['STOK'];
            $aarSql[$i]['TRANSIT'] = $aarSql[$i]['TRANSIT'];
            //$aarSql[$i]['KAPASITAS'] = number_format(round(str_replace(',', '.', $aarSql[$i]['KAPASITAS'])), 0, ',', '.');
            $aarSql[$i]['SISA_TO'] = $aarSql[$i]['SISA_TO'];
        }

        $sortby = array();
        foreach ($aarSql as $key => $row) {
            $sortby[$key] = $row['SDR'];
        }
        array_multisort($sortby, SORT_ASC, $aarSql);

        echo json_encode($aarSql);
    }
    function getKota(){
        $data = $this->TabelKeputusan_model->getKota();
        
        echo json_encode($data);
    }
    function coba() {
        $data = $this->TabelKeputusan_model->getRilis('1070010000');

        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

}

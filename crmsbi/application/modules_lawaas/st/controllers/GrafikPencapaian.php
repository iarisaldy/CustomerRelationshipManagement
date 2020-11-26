<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class GrafikPencapaian extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        $this->load->model('GrafikPencapaian_model');
        date_default_timezone_set("Asia/Jakarta");
    }

    function index() {
        $data = array('title' => 'Semen Tonasa');
        $this->template->display('GrafikPencapaian_view', $data);
    }

    function getData($tahun, $bulan, $hari) {
        $data = $this->GrafikPencapaian_model->scodatastNew($tahun, $bulan, $hari);
        $a_date = $tahun."-".$bulan;
        $tgl_akhir = date("t", strtotime($a_date));
        $harisisa = $tgl_akhir-$hari;
        $harisisa = $harisisa!=0?$harisisa:1;
        $target = 0;
        $arr = array();
        $arr['labels'] = array();
        $arr['target_bulan'] = array();
        $arr['target_hari'] = array();
        $arr['realisasi'] = array();
        $arr['harian_max'] = array();
        $arr['target'] = array();
        $arr['warna'] = array();
        $bulanBaru = date('t',  strtotime($tahun."-".$bulan));
        foreach($data as $key=>$row){
            if(empty($row['TARGET_REALH']) || $row['TARGET_REALH']==0){
                $tRealH = ($row['TARGET']*$hari)/$bulanBaru;
                $data[$key]['TARGET_REALH'] = $tRealH;
            }
        }
        foreach ($data as $value) {
            $rkap = round(str_replace(',', '.', $value['TARGET']));
            $realisasi = round(str_replace(',', '.', $value['REAL']));
            $target = round(($rkap-$realisasi)/$harisisa);
            $harian_max = round(str_replace(',', '.', $value['HARIAN_MAX']));
            if($target<0){
                $target=0;
            }
            
            array_push($arr['labels'], $value['NM_PROV_1']);
            array_push($arr['target_bulan'], $rkap);
            array_push($arr['target_hari'], round(str_replace(',', '.', $value['TARGET_REALH'])));            
            if($realisasi<0){
                array_push($arr['realisasi'], 0);
            } else {
                array_push($arr['realisasi'], $realisasi);
            } 
            if($harian_max<0){
                array_push($arr['harian_max'], 0);
            } else {
                array_push($arr['harian_max'], $harian_max);
            }                        
            array_push($arr['target'], $target);
            if($target==0){
                array_push($arr['warna'], '#5eff2c');
            } else {
                array_push($arr['warna'], '#ff4545');
            }
        }
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
        echo json_encode($arr);
    }

}

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
        $data = array('title' => 'Semen Gresik');
        $this->template->display('GrafikPencapaian_view', $data);
    }

    function getData($tahun, $bulan, $hari) {
        $data = $this->GrafikPencapaian_model->scodatasgNew($tahun, $bulan, $hari);
        $dataBag = $this->GrafikPencapaian_model->scodatasgBagNew($tahun, $bulan, $hari);
        $dataBulk = $this->GrafikPencapaian_model->scodatasgBulkNew($tahun, $bulan, $hari);
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
        $arr['bag']['target_bulan'] = array();
        $arr['bag']['target_hari'] = array();
        $arr['bag']['realisasi'] = array();
        $arr['bag']['harian_max'] = array();
        $arr['bag']['target'] = array();
        $arr['bag']['warna'] = array();
        $arr['bulk']['target_bulan'] = array();
        $arr['bulk']['target_hari'] = array();
        $arr['bulk']['realisasi'] = array();
        $arr['bulk']['harian_max'] = array();
        $arr['bulk']['target'] = array();
        $arr['bulk']['warna'] = array();
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
        foreach ($dataBag as $value) {
            $rkap = round(str_replace(',', '.', $value['TARGET']));
            $realisasi = round(str_replace(',', '.', $value['REAL']));
            $target = round(($rkap-$realisasi)/$harisisa);
            $harian_max = round(str_replace(',', '.', $value['HARIAN_MAX']));
            if($target<0){
                $target=0;
            }
            array_push($arr['bag']['target_bulan'], $rkap);
            array_push($arr['bag']['target_hari'], round(str_replace(',', '.', $value['TARGET_REALH'])));
            if($realisasi<0){
                array_push($arr['bag']['realisasi'], 0);
            } else {
                array_push($arr['bag']['realisasi'], $realisasi);
            } 
            if($harian_max<0){
                array_push($arr['bag']['harian_max'], 0);
            } else {
                array_push($arr['bag']['harian_max'], $harian_max);
            }                        
            array_push($arr['bag']['target'], $target);
            if($target==0){
                array_push($arr['bag']['warna'], '#5eff2c');
            } else {
                array_push($arr['bag']['warna'], '#ff4545');
            }
        }
        foreach ($dataBulk as $value) {
            $rkap = round(str_replace(',', '.', $value['TARGET']));
            $realisasi = round(str_replace(',', '.', $value['REAL']));
            $target = round(($rkap-$realisasi)/$harisisa);
            $harian_max = round(str_replace(',', '.', $value['HARIAN_MAX']));
            if($target<0){
                $target=0;
            }
            array_push($arr['bulk']['target_bulan'], $rkap);
            array_push($arr['bulk']['target_hari'], round(str_replace(',', '.', $value['TARGET_REALH'])));
            if($realisasi<0){
                array_push($arr['bulk']['realisasi'], 0);
            } else {
                array_push($arr['bulk']['realisasi'], $realisasi);
            } 
            if($harian_max<0){
                array_push($arr['bulk']['harian_max'], 0);
            } else {
                array_push($arr['bulk']['harian_max'], $harian_max);
            }                        
            array_push($arr['bulk']['target'], $target);
            if($target==0){
                array_push($arr['bulk']['warna'], '#5eff2c');
            } else {
                array_push($arr['bulk']['warna'], '#ff4545');
            }
        }
        echo json_encode($arr);
    }
    
    function coba(){
        $tahun = '2016';
        $bulan = '06';
        $a_date = $tahun."-".$bulan;
        $tgl_akhir = date("t", strtotime($a_date));
        echo $tgl_akhir;
    }

}

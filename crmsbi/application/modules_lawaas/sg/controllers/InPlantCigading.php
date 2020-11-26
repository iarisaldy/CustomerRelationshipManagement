<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class InPlantCigading extends CI_Controller {
	function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        $this->load->model('InPlantCigading_model');
    }

    function index() {
        $data = array('title' => 'Semen Gresik');
        $this->template->display('InPlantCigading_view', $data);
    }

    function detailTruk() {
        $data = array('title' => 'Detail Truk', 'url' => 'sg/InPlantCigading/dataDetailTruk/', 'nm_plant' => 'Cigading');
        $this->template->display('DetailTruk_nontuban_view', $data);
    }

    function dataDetailTruk() {
        $id = $this->uri->segment(4);
        switch ($id) {
            case 0 :
                $data = $this->InPlantCigading_model->detailBagCargo();
                break;
            case 1 :
                $data = $this->InPlantCigading_model->detailBulkCargo();
                break;
            case 2 :
                $data = $this->InPlantCigading_model->detailBagTmbgn();
                break;
            case 3 :
                $data = $this->InPlantCigading_model->detailBulkTmbgn();
                break;
        }

        echo json_encode($data);
    }

    function detailConveyor() {
        $data = array('title' => 'Detail Truk', 'url' => "sg/InPlantCigading/dataDetailConveyor/");
        $this->template->display('DetailConveyor_nontuban_view', $data);
    }

    function dataDetailConveyor() {
        $id = $this->uri->segment(4);
        $data_fix = array();
        $arr = array();
        $data = $this->InPlantCigading_model->detailConveyor($id);
        if (!empty($data)) {
            foreach ($data as $d) {
                if (empty($arr)) {
                    $arr[$d['NO_POLISI']]['NO_POLISI'] = $d['NO_POLISI'];
                    $arr[$d['NO_POLISI']]['PABRIK'] = $d['PABRIK'];
                    $arr[$d['NO_POLISI']]['LSTEL'] = $d['LSTEL'];
                    $arr[$d['NO_POLISI']]['MATNR'] = $d['MATNR'];
                    $arr[$d['NO_POLISI']]['STATUS'] = $d['STATUS'];
                    $arr[$d['NO_POLISI']]['TANGGAL'] = $d['TANGGAL'];
                    $arr[$d['NO_POLISI']]['NAMA_SOPIR'] = $d['NAMA_SOPIR'];
                    $arr[$d['NO_POLISI']]['JAM_MULAI'] = $d['JAM_MULAI'];
                    $arr[$d['NO_POLISI']]['DURASI'] = $d['DURASI'];
                    $arr[$d['NO_POLISI']]['NAMA_EXPEDITUR'] = $d['NAMA_EXPEDITUR'];
                    $arr[$d['NO_POLISI']]['NM_KOTA'] = $d['NM_KOTA'];
                    $arr[$d['NO_POLISI']]['KWANTUMX'] = $d['KWANTUMX'];
                }else{
                    if (isset($arr[$d['NO_POLISI']])) {
                        $arr[$d['NO_POLISI']]['PABRIK'] = $arr[$d['NO_POLISI']]['PABRIK'].', '.$d['PABRIK'];
                    }else{
                        $arr[$d['NO_POLISI']]['NO_POLISI'] = $d['NO_POLISI'];
                        $arr[$d['NO_POLISI']]['PABRIK'] = $d['PABRIK'];
                        $arr[$d['NO_POLISI']]['LSTEL'] = $d['LSTEL'];
                        $arr[$d['NO_POLISI']]['MATNR'] = $d['MATNR'];
                        $arr[$d['NO_POLISI']]['STATUS'] = $d['STATUS'];
                        $arr[$d['NO_POLISI']]['TANGGAL'] = $d['TANGGAL'];
                        $arr[$d['NO_POLISI']]['NAMA_SOPIR'] = $d['NAMA_SOPIR'];
                        $arr[$d['NO_POLISI']]['JAM_MULAI'] = $d['JAM_MULAI'];
                        $arr[$d['NO_POLISI']]['DURASI'] = $d['DURASI'];
                        $arr[$d['NO_POLISI']]['NAMA_EXPEDITUR'] = $d['NAMA_EXPEDITUR'];
                        $arr[$d['NO_POLISI']]['NM_KOTA'] = $d['NM_KOTA'];
                        $arr[$d['NO_POLISI']]['KWANTUMX'] = $d['KWANTUMX'];
                    }
                }
            }
        }

        if (!empty($arr)) {
            foreach ($arr as $a) {
                array_push($data_fix, array('NO_POLISI' => $a['NO_POLISI'], 'PABRIK' => $a['PABRIK'], 'LSTEL' => $a['LSTEL'], 'MATNR' => $a['MATNR'], 'STATUS' => $a['STATUS'], 'TANGGAL' => $a['TANGGAL'], 'NAMA_SOPIR' => $a['NAMA_SOPIR'], 'JAM_MULAI' => $a['JAM_MULAI'], 'DURASI' => $a['DURASI'], 'NAMA_EXPEDITUR' => $a['NAMA_EXPEDITUR'], 'NM_KOTA' => $a['NM_KOTA'], 'KWANTUMX' => $a['KWANTUMX']));
            }
        }

        echo json_encode($data_fix);
    }

    function detailTonase() {
        $data = array('title' => 'Detail Tonase', 'url' => "sg/InPlantCigading/dataDetailTonase/", 'nm_plant' => 'cigading');
        $this->template->display('DetailTonase_nontuban_view', $data);
    }

    function dataDetailTonase() {
        $id = $this->uri->segment(4);
        if ($id == 'bag') {
            $data = $this->InPlantCigading_model->detailBagTonase();
        } else if ($id == 'bulk') {
            $data = $this->InPlantCigading_model->detailBulkTonase();
        }
        $subTotalPOZak = 0;
        $subTotalPOTon = 0;
        $subTotalSalesZak = 0;
        $subTotalSalesTon = 0;
        $grandTotalZak = 0;
        $grandTotalTon = 0;
        $rows = '<tr>';
        $rows .= '<td>PO/STO</td>';
        $rows .= '<td></td>';
        $rows .= '<td></td>';
        $rows .= '<td></td>';
        $rows .= '<td></td>';
        $rows .= '<td></td>';
        $rows .= '</tr>';
        if ($data) {
            foreach ($data as $r) {
                if ($r->ORDER_TYPE == 'ZNL') {
                    $rows .= '<tr>';
                    $rows .= '<td>' . $r->ITEM_NO . '</td>';
                    $rows .= '<td>' . $r->PRODUK . '</td>';
                    $rows .= '<td align="right">' . $r->KWANTUM . '</td>';
                    $rows .= '<td>ZAK</td>';
                    $rows .= '<td align="right">' . $r->KWANTUMX . '</td>';
                    $rows .= '<td>TO</td>';
                    $rows .= '</tr>';
                    $subTotalPOZak += $r->KWANTUM;
                    $subTotalPOTon += $r->KWANTUMX;
                }
            }
        }
        $rows .= '<tr>';
        $rows .= '<td class="warning"></td>';
        $rows .= '<td class="warning" align="right">SUB TOTAL</td>';
        $rows .= '<td class="warning" align="right">' . $subTotalPOZak . '</td>';
        $rows .= '<td class="warning">ZAK</td>';
        $rows .= '<td class="warning" align="right">' . $subTotalPOTon . '</td>';
        $rows .= '<td class="warning">TO</td>';
        $rows .= '</tr>';
        $rows .= '<tr>';
        $rows .= '<td>SALES</td>';
        $rows .= '<td></td>';
        $rows .= '<td></td>';
        $rows .= '<td></td>';
        $rows .= '<td></td>';
        $rows .= '<td></td>';
        $rows .= '</tr>';
        if ($data) {
            foreach ($data as $r) {
                if ($r->ORDER_TYPE == 'ZLF') {
                    $rows .= '<tr>';
                    $rows .= '<td>' . $r->ITEM_NO . '</td>';
                    $rows .= '<td>' . $r->PRODUK . '</td>';
                    $rows .= '<td align="right">' . $r->KWANTUM . '</td>';
                    $rows .= '<td>ZAK</td>';
                    $rows .= '<td align="right">' . $r->KWANTUMX . '</td>';
                    $rows .= '<td>TO</td>';
                    $rows .= '</tr>';
                    $subTotalSalesZak += $r->KWANTUM;
                    $subTotalSalesTon += $r->KWANTUMX;
                }
            }
        }
        $rows .= '<tr>';
        $rows .= '<td class="warning"></td>';
        $rows .= '<td class="warning" align="right">SUB TOTAL</td>';
        $rows .= '<td class="warning" align="right">' . $subTotalSalesZak . '</td>';
        $rows .= '<td class="warning">ZAK</td>';
        $rows .= '<td class="warning" align="right">' . $subTotalSalesTon . '</td>';
        $rows .= '<td class="warning">TO</td>';
        $rows .= '</tr>';
        $grandTotalZak = $subTotalPOZak + $subTotalSalesZak;
        $grandTotalTon = $subTotalPOTon + $subTotalSalesTon;
        $rows .= '<tr>';
        $rows .= '<td class="danger"></td>';
        $rows .= '<td class="danger" align="right">GRAND TOTAL</td>';
        $rows .= '<td class="danger" align="right">' . $grandTotalZak . '</td>';
        $rows .= '<td class="danger">ZAK</td>';
        $rows .= '<td class="danger" align="right">' . $grandTotalTon . '</td>';
        $rows .= '<td class="danger">TO</td>';
        $rows .= '</tr>';

        echo json_encode(array('rows' => $rows));
    }

    function avgcargo() {
        $data = array();
        $data = $this->InPlantCigading_model->avgcargo();

        return $data;
    }

    function avgtmbgn() {
        $data = $this->InPlantCigading_model->avgtmbgn();
        //echo json_encode($data);
        return $data;
    }

    function cntcargo() {
        $data = $this->InPlantCigading_model->cntcargo();
        //echo json_encode($data);
        return $data;
    }

    function cnttmbgn() {
        $data = $this->InPlantCigading_model->cnttmbgn();
        //echo json_encode($data);
        return $data;
    }

    function avgpbrk() {
        $data = $this->InPlantCigading_model->avgpbrk();
        //echo json_encode($data);
        return $data;
    }

    function cntPbrk(){
        $cntPbrk = $this->InPlantCigading_model->get_data_conveyor();
        $data = array();
        $arr = array();
        if (!empty($cntPbrk)) {
            foreach ($cntPbrk as $c) {
                // array_push($data, array('LSTEL' => trim($c['LINE_BOOMER']), 'MATNR' => $c['MATNR'], 'DESKRIPSI' => $c['DESKRIPSI'], 'STATUS' => $c['STATUS'], 'COUNTER' => $c['C_LINE']));
                if (empty($arr)) {
                    $tsel = trim($c['LINE_BOOMER']);
                    $arr[$tsel]['LSTEL'] = $tsel;
                    $arr[$tsel]['MATNR'] = $c['MATNR'];
                    $arr[$tsel]['DESKRIPSI'] = $c['DESKRIPSI'];
                    $arr[$tsel]['STATUS'] = $c['STATUS'];
                    $arr[$tsel]['COUNTER'] = $c['C_LINE']; 
                }else{
                    $tsel = trim($c['LINE_BOOMER']);
                    if (isset($arr[$tsel])) {
                        $arr[$tsel]['MATNR'] = $c['MATNR'];
                        $arr[$tsel]['DESKRIPSI'] = $arr[$tsel]['DESKRIPSI'].', '.$c['DESKRIPSI'];

                        if ($arr[$tsel]['STATUS'] == '' || $arr[$tsel]['STATUS'] == null) {
                            if ($c['STATUS'] != '' || $c['STATUS'] != null) {
                                $arr[$tsel]['STATUS'] = $c['STATUS'];
                            }    
                        }else{
                            if ($arr[$tsel]['STATUS'] == 0 || $arr[$tsel]['STATUS'] == '0') {
                                if ($c['STATUS'] != '' || $c['STATUS'] != null) {
                                    $arr[$tsel]['STATUS'] = $c['STATUS'];
                                }
                            }
                        }
                        
                        $arr[$tsel]['COUNTER'] = $arr[$tsel]['COUNTER'] + $c['C_LINE'];
                    }else{
                        $arr[$tsel]['LSTEL'] = $tsel;
                        $arr[$tsel]['MATNR'] = $c['MATNR'];
                        $arr[$tsel]['DESKRIPSI'] = $c['DESKRIPSI'];
                        $arr[$tsel]['STATUS'] = $c['STATUS'];
                        $arr[$tsel]['COUNTER'] = $c['C_LINE'];
                    }
                }
            }
        }

        if (!empty($arr)) {
            foreach ($arr as $c) {
                array_push($data, array('LSTEL' => trim($c['LSTEL']), 'MATNR' => $c['MATNR'], 'DESKRIPSI' => $c['DESKRIPSI'], 'STATUS' => $c['STATUS'], 'COUNTER' => $c['COUNTER']));
            }
        }

        return $data;
    }

    function waktuUpdate() {
        $data = $this->InPlantCigading_model->waktuUpdate();
        //echo json_encode($data);
        return $data;
    }

    function overall() {
        $aarFromStok = $this->InPlantCigading_model->sql_stok();
        $aarInplant = $this->InPlantCigading_model->tonaseOverall();
        $results = array();
        $results['BAG']['DIST'] = 0;
        $results['BAG']['DA'] = 0;
        $results['BAG']['SG'] = 0;
        $results['BULK']['PORT'] = 0;
        $results['BULK']['LOKAL'] = 0;

        for ($i = 0; $i < sizeof($aarInplant); $i++) {
            $flag = true;
            if ($aarInplant[$i]['TIPE_TRUK'] >= 107 && $aarInplant[$i]['TIPE_TRUK'] < 308) {
                if ($aarInplant[$i]['ORDER_TYPE'] == 'ZNL') {
                    $results['BAG']['SG']+=$aarInplant[$i]['JUMLAHX'];
                    continue;
                }
                for ($j = 0; $j < sizeof($aarFromStok); $j++) {

                    if ($aarFromStok[$j]['KD_GDG'] == $aarInplant[$i]['KODE_DA']) {
                        $results['BAG']['DIST']+=$aarInplant[$i]['JUMLAHX'];
                        if ($flag)
                            $flag = false;
                        break;
                    }
                }
                if ($flag) {
                    $results['BAG']['DA']+=$aarInplant[$i]['JUMLAHX'];
                }
            } else {
                if ($aarInplant[$i]['ORDER_TYPE'] == 'ZNL') {
                    $results['BULK']['PORT']+=$aarInplant[$i]['JUMLAHX'];
                } else if ($aarInplant[$i]['ORDER_TYPE'] == 'ZLF' || $aarInplant[$i]['ORDER_TYPE'] == 'ZLFP') {
                    $results['BULK']['LOKAL']+=$aarInplant[$i]['JUMLAHX'];
                }
            }
        }

        return $results;
    }

    function avgOverall() {
        $data = $this->InPlantCigading_model->avgOverall();
        //echo json_encode($data);
        return $data;
    }
    
    function sisaSO(){
        $data = $this->InPlantCigading_model->sisaSO();
        return $data;
    }

    function load() {
        $avgCargo = $this->avgcargo();
        $avgTmbgn = $this->avgtmbgn();
        $cntCargo = $this->cntcargo();
        $cntTmbgn = $this->cnttmbgn();
        $avgPbrk = $this->avgpbrk();
        $cntPbrk = $this->cntPbrk();
        $waktuUpdate = $this->waktuUpdate();
        $overall = $this->overall();
        $avgOverall = $this->avgOverall();
        $sisaSO = $this->sisaSO();

        $data = json_encode(array(
            "avgCargo" => $avgCargo,
            "avgTmbgn" => $avgTmbgn,
            "cntCargo" => $cntCargo,
            "cntTmbgn" => $cntTmbgn,
            "avgPbrk" => $avgPbrk,
            "cntPbrk" => $cntPbrk,
            "waktuUpdate" => $waktuUpdate,
            "overall" => $overall,
            "avgOverall" => $avgOverall,
            "sisaSO" => $sisaSO
        ));

        echo $data;
    }

    function cek_null($data){
        $c = '';
        if ($data != null || $data != '') {
            $c = $data;
        }

        return $c;
    }
}
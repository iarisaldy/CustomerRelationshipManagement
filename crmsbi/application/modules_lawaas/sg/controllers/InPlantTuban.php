<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class InPlantTuban extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        $this->load->model('InPlantTuban_model');
    }

    function index() {
        $data = array('title' => 'Semen Gresik');
        $this->template->display('InPlantTuban_view', $data);
    }

    function detailTruk() {
        $data = array('title' => 'Detail Truk');
        $this->template->display('DetailTruk_view', $data);
    }

    function dataDetailTruk() {
        $id = $this->uri->segment(4);
        switch ($id) {
            case 0 :
                $data = $this->InPlantTuban_model->detailBagCargo();
                break;
            case 1 :
                $data = $this->InPlantTuban_model->detailBulkCargo();
                break;
            case 2 :
                $data = $this->InPlantTuban_model->detailBagTmbgn();
                break;
            case 3 :
                $data = $this->InPlantTuban_model->detailBulkTmbgn();
                break;
        }

        echo json_encode($data);
    }

    function detailConveyor() {
        $data = array('title' => 'Detail Truk');
        $this->template->display('DetailConveyor_view', $data);
    }

    function dataDetailConveyor() {
        $id = $this->uri->segment(4);
        $data = $this->InPlantTuban_model->detailConveyor($id);

        echo json_encode($data);
    }

    function detailTonase() {
        $data = array('title' => 'Detail Tonase');
        $this->template->display('DetailTonase_view', $data);
    }

    function dataDetailTonase() {
        $id = $this->uri->segment(4);
        if ($id == 'bag') {
            $data = $this->InPlantTuban_model->detailBagTonase();
        } else if ($id == 'bulk') {
            $data = $this->InPlantTuban_model->detailBulkTonase();
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

    function get_waktu() {
        $data = $this->InPlantTuban_model->get_updateTime();
        echo json_encode($data);
    }

    function avgcargo() {
        $data = $this->InPlantTuban_model->avgcargo();
        //echo json_encode($data);
        return $data;
    }

    function cntcargo() {
        $data = $this->InPlantTuban_model->cntcargo();
        //echo json_encode($data);
        return $data;
    }

    function avgtmbgn() {
        $data = $this->InPlantTuban_model->avgtmbgn();
        //echo json_encode($data);
        return $data;
    }

    function cnttmbgn() {
        $data = $this->InPlantTuban_model->cnttmbgn();
        //echo json_encode($data);
        return $data;
    }

    function avgpbrk() {
        $data = $this->InPlantTuban_model->avgpbrk();
        //echo json_encode($data);
        return $data;
    }

    function cntpbrk() {
        $data = $this->InPlantTuban_model->cntpbrk();
        //echo json_encode($data);
        return $data;
    }

    function waktuUpdate() {
        $data = $this->InPlantTuban_model->waktuUpdate();
        //echo json_encode($data);
        return $data;
    }

    function grafikLaporan() {
        $data = array('title' => 'Grafik Laporan');
        $this->template->display('GrafikLaporan', $data);
    }

    function grafRataBag($posisi, $bulan, $tahun) {
        if ($posisi == "kargo") {
            $posisi = "ROUND((avg(DATE_CVY - TGL_ANTRI)*24),2) AVERAGE";
            $batas = 4;
        } else if ($posisi == "tmbm") {
            $posisi = "ROUND((avg(TGL_MASUK - DATE_CVY)*24),2) AVERAGE";
            $batas = 0.5;
        } else if ($posisi == "pbrk") {
            $posisi = "ROUND((avg(TGL_CMPLT - TGL_MASUK)*24),2) AVERAGE";
            $batas = 4;
        } else if ($posisi == "overall") {
            $posisi = "ROUND((avg(TGL_CMPLT - TGL_ANTRI)*24),2) AVERAGE";
            $batas = 8.5;
        }
        $data = $this->InPlantTuban_model->grafRataBag($posisi, $bulan, $tahun);
        $arr["labels"] = array();
        $arr["data"] = array();
        $arr["batas"] = array();
        foreach ($data as $row) {
            array_push($arr["labels"], $row['TANGGAL']);
            array_push($arr["data"], str_replace(',', '.', $row["AVERAGE"]));
            array_push($arr["batas"], $batas);
        }
        return $arr;
    }

    function grafRataBulk($posisi, $bulan, $tahun) {
        if ($posisi == "kargo") {
            $posisi = "ROUND((avg(DATE_CVY - TGL_ANTRI)*24),2) AVERAGE";
            $batas = 2;
        } else if ($posisi == "tmbm"){
            $posisi = "ROUND((avg(TGL_MASUK - DATE_CVY)*24),2) AVERAGE";
            $batas = 0.5;
        }else if ($posisi == "pbrk"){
            $posisi = "ROUND((avg(TGL_CMPLT - TGL_MASUK)*24),2) AVERAGE";
            $batas = 1;
        }else if ($posisi == "overall"){
            $posisi = "ROUND((avg(TGL_CMPLT - TGL_ANTRI)*24),2) AVERAGE";
            $batas = 3.5;
        }
        $data = $this->InPlantTuban_model->grafRataBulk($posisi, $bulan, $tahun);
        $arr["labels"] = array();
        $arr["data"] = array();
        $arr["batas"] = array();
        foreach ($data as $row) {
            array_push($arr["labels"], $row['TANGGAL']);
            array_push($arr["data"], str_replace(',', '.', $row["AVERAGE"]));
            array_push($arr["batas"], $batas);
        }
        return $arr;
    }

    function grafXpBag_old($posisi, $bulan, $tahun) {
        if ($posisi == "kargo")
            $posisi = "ROUND((avg(DATE_CVY - TGL_ANTRI)*24),2) AVERAGE";
        else if ($posisi == "tmbm")
            $posisi = "ROUND((avg(TGL_MASUK - DATE_CVY)*24),2) AVERAGE";
        else if ($posisi == "pbrk")
            $posisi = "ROUND((avg(TGL_CMPLT - TGL_MASUK)*24),2) AVERAGE";
        else if ($posisi == "overall")
            $posisi = "ROUND((avg(TGL_CMPLT - TGL_ANTRI)*24),2) AVERAGE";
        $data = $this->InPlantTuban_model->grafXpBag($posisi, $bulan, $tahun);
        $arr["labels"] = array();
        $arr["data"] = array();
        foreach ($data as $row) {
            array_push($arr["labels"], substr($row["NAMA_EXPEDITUR"], 0, 15));
            array_push($arr["data"], str_replace(',', '.', $row["AVERAGE"]));
        }
        return $arr;
    }

    function grafXpBulk_old($posisi, $bulan, $tahun) {
        if ($posisi == "kargo")
            $posisi = "ROUND((avg(DATE_CVY - TGL_ANTRI)*24),2) AVERAGE";
        else if ($posisi == "tmbm")
            $posisi = "ROUND((avg(TGL_MASUK - DATE_CVY)*24),2) AVERAGE";
        else if ($posisi == "pbrk")
            $posisi = "ROUND((avg(TGL_CMPLT - TGL_MASUK)*24),2) AVERAGE";
        else if ($posisi == "overall")
            $posisi = "ROUND((avg(TGL_CMPLT - TGL_ANTRI)*24),2) AVERAGE";
        $data = $this->InPlantTuban_model->grafXpBulk($posisi, $bulan, $tahun);
        $arr["labels"] = array();
        $arr["data"] = array();
        foreach ($data as $row) {
            array_push($arr["labels"], substr($row["NAMA_EXPEDITUR"], 0, 15));
            array_push($arr["data"], str_replace(',', '.', $row["AVERAGE"]));
        }
        return $arr;
    }
    
    function grafXpBag($posisi, $bulan, $tahun) {
        if ($posisi == "kargo"){
            $posisi = "ROUND((avg(DATE_CVY - TGL_ANTRI)*24),2) AVERAGE";
            $batas = 4;
        }else if ($posisi == "tmbm"){
            $posisi = "ROUND((avg(TGL_MASUK - DATE_CVY)*24),2) AVERAGE";
            $batas = 0.5;
        }else if ($posisi == "pbrk"){
            $posisi = "ROUND((avg(TGL_CMPLT - TGL_MASUK)*24),2) AVERAGE";
            $batas = 4;
        }else if ($posisi == "overall"){
            $posisi = "ROUND((avg(TGL_CMPLT - TGL_ANTRI)*24),2) AVERAGE";
            $batas = 8.5;
        }
        $data = $this->InPlantTuban_model->grafXpBag($posisi, $bulan, $tahun);
        $arr["labels"] = array();
        $arr["data"] = array();
        $arr["batas"] = array();
        foreach ($data as $row) {
            array_push($arr["labels"], substr($row["NAMA_EXPEDITUR"], 0, 15));
            array_push($arr["data"], str_replace(',', '.', $row["AVERAGE"]));
            array_push($arr["batas"],$batas);
        }
        return $arr;
    }

    function grafXpBulk($posisi, $bulan, $tahun) {
        if ($posisi == "kargo") {
            $posisi = "ROUND((avg(DATE_CVY - TGL_ANTRI)*24),2) AVERAGE";
            $batas = 2;
        } else if ($posisi == "tmbm") {
            $posisi = "ROUND((avg(TGL_MASUK - DATE_CVY)*24),2) AVERAGE";
            $batas = 0.5;
        } else if ($posisi == "pbrk") {
            $posisi = "ROUND((avg(TGL_CMPLT - TGL_MASUK)*24),2) AVERAGE";
            $batas = 1;
        } else if ($posisi == "overall") {
            $posisi = "ROUND((avg(TGL_CMPLT - TGL_ANTRI)*24),2) AVERAGE";
            $batas = 3.5;
        }
        $data = $this->InPlantTuban_model->grafXpBulk($posisi, $bulan, $tahun);
        $arr["labels"] = array();
        $arr["data"] = array();
        $arr["batas"] = array();
        foreach ($data as $row) {
            array_push($arr["labels"], substr($row["NAMA_EXPEDITUR"], 0, 15));
            array_push($arr["data"], str_replace(',', '.', $row["AVERAGE"]));
            array_push($arr["batas"],$batas);
        }
        return $arr;
    }


    function overall() {
        $aarFromStok = $this->InPlantTuban_model->sql_stok();
        $aarInplant = $this->InPlantTuban_model->tonaseOverall();
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
                    // if($aarInplant[$i]['ORDER_TYPE']=='ZLF' || $aarInplant[$i]['ORDER_TYPE']=='ZLFP'){
                    // 	$results['BAG']['DIST']+=$aarInplant[$i]['JUMLAHX'];
                    // 	break;
                    // }
                    // if($aarInplant[$i]['ORDER_TYPE']!='ZNL')
                    // {
                    // 	$results['BAG']['DA']+=$aarInplant[$i]['JUMLAHX'];
                    // 	break;
                    // }
                    // echo $aarFromStok['KD_GDG']." ".$aarInplant[$i]['KODE_DA'];

                    if ($aarFromStok[$j]['KD_GDG'] == $aarInplant[$i]['KODE_DA']) {
                        $results['BAG']['DIST']+=$aarInplant[$i]['JUMLAHX'];
                        if ($flag)
                            $flag = false;
                        break;
                        // if($aarInplant[$i]['ORDER_TYPE']!='ZNL' && ($aarFromStok['KD_GDG']['LT']!='X' || $aarFromStok['KD_GDG']['LT']!='x') )
                        // {
                        // 	$results['BAG']['DIST']+=$aarInplant[$i]['JUMLAHX'];
                        // 	break;
                        // }
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
        //echo json_encode($results);
        return $results;
    }

    function avgOverall() {
        $data = $this->InPlantTuban_model->avgOverall();
        //echo json_encode($data);
        return $data;
    }
    
    function sisaSO(){
        $data = $this->InPlantTuban_model->sisaSO();
        return $data;
    }

    function load() {
        $avgCargo = $this->avgcargo();
        $avgTmbgn = $this->avgtmbgn();
        $cntCargo = $this->cntcargo();
        $cntTmbgn = $this->cnttmbgn();
        $avgPbrk = $this->avgpbrk();
        $cntPbrk = $this->cntpbrk();
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

    function grafik($posisi, $bulan, $tahun) {
        $grafRataBag = $this->grafRataBag($posisi, $bulan, $tahun);
        $grafRataBulk = $this->grafRataBulk($posisi, $bulan, $tahun);
        $grafXpBag = $this->grafXpBag($posisi, $bulan, $tahun);
        $grafXpBulk = $this->grafXpBulk($posisi, $bulan, $tahun);

        $data = json_encode(array(
            "grafRataBag" => $grafRataBag,
            "grafRataBulk" => $grafRataBulk,
            "grafXpBag" => $grafXpBag,
            "grafXpBulk" => $grafXpBulk
        ));

        echo $data;
    }

}

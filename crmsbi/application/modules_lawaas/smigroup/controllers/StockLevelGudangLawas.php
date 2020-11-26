<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class StockLevelGudang extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        $this->load->helper('form');
        $this->load->model('StockLevelGudang_model');
        $this->load->model('MasterGudang_model');
        $this->load->model('AdjustmentGudang_model');
    }

    function index() {
        $data = array('title' => 'Stock Level Gudang');
        $this->template->display('StokLevelGudang_view', $data);
    }

    function getSisaSO() {
        $data = $this->StockLevelGudang_model->getSisaSO('1420062000');
        var_dump($data);
    }

    function tes() {
        $transit_hasil = $this->StockLevelGudang_model->getRptReal();
        echo json_encode($transit_hasil);
    }

    function getPeta() {
        // $getFlag = 0;
        error_reporting(E_ALL);
        //Gudang Semen Padang
        $gudSP = array();
        $gudSP = $this->getGudangSP();



        //distributor//
        //===========//

        $transit_hasil = $this->StockLevelGudang_model->getRptReal2();
        foreach ($transit_hasil as $key => $value) {
            $sisa = $this->StockLevelGudang_model->getSisaSO($value['KODE_DA']);
            $transit_hasil[$key]['SISASO'] = $sisa['SISASO'];
            $transit_hasil[$key]['SISA_TO'] = $sisa['SISA_TO'];
        }

        // $gudAdj = $this->StockLevelGudang_model->getAdjGudang();
        // $transit_hasil = $this->StockLevelGudang_model->getRptReal();
        // echo $this->db->query();
        $aarSql = $this->StockLevelGudang_model->getPeta();
        // echo $this->db->query();
        $current_date = date("Y-m-d H:i:s");

        //Gudang Semen Gresik
        //-------------------
        //Elogs
//        $gudSG = array();
//        $gudSG = $this->StockLevelGudang_model->getdataElogs();
//        for ($i = 0; $i < sizeof($aarSql); $i++) {
//            $aarSql[$i]['SOURCE'] = 'CRM';
//            foreach ($gudSG as $key2 => $value2) {
//                if ($value2['KD_CUSTOMER'] == $aarSql[$i]['KD_GDG']) {
//                    $aarSql[$i]['STOK'] = $value2['STOK_TON'];
//                    $aarSql[$i]['KAPASITAS'] = $value2['KAPASITAS'];
//                    $aarSql[$i]['STOK_LEVEL'] = round($aarSql[$i]['STOK'] / $aarSql[$i]['KAPASITAS'], 2) * 100;
//                    $aarSql[$i]['TOTAL_LEVEL'] = round(($aarSql[$i]['STOK'] + ($aarSql[$i]['TRANSIT'] * 1000 / 40)) / $aarSql[$i]['KAPASITAS'], 2) * 100;
//                    $aarSql[$i]['LAST_UPDATE'] = $value2['CREATE_DATE'];
//                    $aarSql[$i]['TGL_UPDATE'] = $value2['CREATE_DATE'];
//                    $aarSql[$i]['SOURCE'] = 'E-LOGS';
//                }
//            }
//        }

        for ($i = 0; $i < sizeof($aarSql); $i++) {
            $aarSql[$i]['FLAG'] = 0;
            $kwantum = 0;
            $jml_truk = 0;
            $sisa_so = 0;
            $stok = array();
            
            $dtElogs = $this->StockLevelGudang_model->getDataStokElogs(TRIM($aarSql[$i]['KD_GDG']));
            $stkElogs = $dtElogs[0]['STOK'];
            if($stkElogs != 0 || $stkElogs != NULL){
                $aarSql[$i]['FLAG']     = 1;
                $aarSql[$i]['STOK']     = $stkElogs;
            }

            // echo '<br> Next Stok '.$aarSql[$i]['KD_GDG'].' - '. $i.' - '.$aarSql[$i]['STOK'] ;

            foreach ($gudSP as $value) {
                if ($value['PLANT'] == (int) $aarSql[$i]['KD_GDG']) {
                    if (!isset($stok[$value['PLANT']])) {
                        $stok[$value['PLANT']] = $value['STOK'];
                    } else {
                        $stok[$value['PLANT']] += $value['STOK'];
                    }

                    $aarSql[$i]['STOK'] = $stok[$value['PLANT']];
                    $aarSql[$i]['STOK_LEVEL'] = round($aarSql[$i]['STOK'] / ($aarSql[$i]['KAPASITAS'] * 40 / 1000), 2) * 100;
                    $aarSql[$i]['LAST_UPDATE'] = date("d-M-Y");
                    $aarSql[$i]['TGL_UPDATE'] = date("Y/m/d");
                }
            }

            // foreach ($gudAdj as $value) {
            //     if ($value['SHIPTO'] == $aarSql[$i]['KD_GDG']) {
            //         $aarSql[$i]['STOK'] += $value['STOK'];
            //     }
            // }

            foreach ($transit_hasil as $data) {
                //$tgl_berangkat = $transit_hasil[$i]['TGL_BERANGKAT'];
                //$diff_time = round((strtotime($current_date) - strtotime($tgl_berangkat))/60/60,1);
                if ($data['KODE_DA'] == $aarSql[$i]['KD_GDG']) {
                    //if($diff_time <= ($transit_hasil[$i]['LEAD_TIME']*2)){
                    $kwantum += $data['KWANTUMX'];
                    $jml_truk = $data['JML_TRUK'];
                    //}
                    $sisa_so = $data['SISA_TO'];
                }
            }


            if (is_null($aarSql[$i]['AVGSTOK']) && isset($aarSql[$i]['KD_GDG'])) {
                //echo $aarSql[$i]['KD_GDG'].'<br/>';
                $kode = $aarSql[$i]['KD_GDG'];

                $data = $this->StockLevelGudang_model->getStokSebelumnya($kode);

                foreach ($data as $value) {
                    $aarSql[$i]['AVGSTOK'] = $value['AVGSTOK'];
                }
            }
            $aarSql[$i]['TRANSIT']  = $kwantum;
            $aarSql[$i]['SISA_TO']  = $sisa_so;
            $aarSql[$i]['JML_TRUK'] = $jml_truk;
            // $aarSql[$i]['FLAG']     = $getFlag;

            if ($aarSql[$i]['STOK'] < 0) {
                $aarSql[$i]['STOK'] = 0;
                $aarSql[$i]['STOK_LEVEL'] = 0;
            }
            if ($aarSql[$i]['KAPASITAS'] != 0) {
                if ($aarSql[$i]['SOURCE'] == 'CRM') {
                    $aarSql[$i]['TOTAL_LEVEL'] = floor(($aarSql[$i]['TRANSIT'] + $aarSql[$i]['STOK']) / $aarSql[$i]['KAPASITAS'] * 100);
                } else {
                    $aarSql[$i]['TOTAL_LEVEL'] = floor(($aarSql[$i]['STOK'] + ($aarSql[$i]['TRANSIT'] * 1000 / 40)) / $aarSql[$i]['KAPASITAS'] * 100);
                }

                $aarSql[$i]['TOTAL_LEVEL_ONHAND'] = ($aarSql[$i]['STOK'] / $aarSql[$i]['KAPASITAS'] * 100);
            } else
                $aarSql[$i]['TOTAL_LEVEL'] = "";
        }
        // echo '<pre>';
        //     print_r($aarSql);
        // echo '</pre>';
        echo json_encode($aarSql);
    }

    function getGudangSP() {
        $data = $this->StockLevelGudang_model->getKdGudang('3000');
        $mat = array(
            '121-301-0050',
            '121-301-0060',
            '121-301-0110',
            '121-301-0120'
        );

        error_reporting(E_ALL);

        $this->load->library('Sap');
        $sap = new SAPConnection();
        $sap->Connect();
        if ($sap->GetStatus() == SAPRFC_OK)
            $sap->Open();
        if ($sap->GetStatus() != SAPRFC_OK) {
            echo 'error Connecting';
            $sap->PrintStatus();

            exit;
        }

        $fce = $sap->NewFunction("ZCMM_MASTER_STOCK_MATERIAL");

        if ($fce == false) {
            echo 'error Connecting';
            // $sap->PrintStatus();
            exit;
        }

        $arr = array(
            "SIGN" => "I",
            "OPTION" => "EQ",
            "LOW" => date("Y"),
        );
        $fce->R_LFGJA->Append($arr);

        $arr = array(
            "SIGN" => "I",
            "OPTION" => "EQ",
            "LOW" => date('m'),
        );
        $fce->R_LFMON->Append($arr);

//        $fce->R_WERKS->row["SIGN"] = 'I';
//        $fce->R_WERKS->row["OPTION"] = 'BT';
//        $fce->R_WERKS->row["LOW"] = '3628';
//        $fce->R_WERKS->row["HIGH"] = '3628';
//        $fce->R_WERKS->Append($fce->R_WERKS->row);
        foreach ($data as $value) {
            $arr = array(
                "SIGN" => "I",
                "OPTION" => "EQ",
                "LOW" => (int) $value['KD_GDG']
            );
            $fce->R_WERKS->Append($arr);
        }
        foreach ($mat as $value) {
            $arr = array(
                "SIGN" => "I",
                "OPTION" => "EQ",
                "LOW" => $value
            );
            $fce->R_MATNR->Append($arr);
        }
        $fce->call();

        $result = array();

        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->T_STOCK->Reset();
            while ($fce->T_STOCK->Next()) {

                $fce2 = $sap->NewFunction("Z_ZAPPSD_LIST_MATERIAL_SALES");
                $fce2->I_VKORG = 3000;
                $fce2->I_MATNR = $fce->T_STOCK->row["MATNR"];
                $fce2->call();
                if ($fce2->GetStatus() == SAPRFC_OK) {
                    $fce2->IT_OUT->Reset();
                    while ($fce2->IT_OUT->Next()) {

                        $row = array(
                            'MATERIAL' => $fce->T_STOCK->row["MATNR"],
                            'BULAN' => $fce->T_STOCK->row["LFMON"],
                            'TAHUN' => $fce->T_STOCK->row["LFGJA"],
                            'PLANT' => $fce->T_STOCK->row["WERKS"],
                            'STOKAWAL' => $fce->T_STOCK->row["LABST"],
                            'SATUAN' => $fce2->IT_OUT->row["NTGEW"],
                            'STOK' => ($fce->T_STOCK->row["LABST"] * $fce2->IT_OUT->row["NTGEW"] / 1000)
                        );
                    }
                }


//                $fce3 = $sap->NewFunction("ZCMM_MAT_PEMAKAIAN_DETAIL");
//                $arr = array(
//                    "SIGN" => "I",
//                    "OPTION" => "BT",
//                    "LOW" => '01.01.2017',
//                    "HIGH" => '31.01.2017'
//                );
//                $fce3->R_BUDAT->Append($arr);
//                $arr = array(
//                    "SIGN" => "I",
//                    "OPTION" => "EQ",
//                    "LOW" => '3000'
//                );
//                $fce3->R_BUKRS->Append($arr);
//                foreach ($mat as $value) {
//                    $arr = array(
//                        "SIGN" => "I",
//                        "OPTION" => "EQ",
//                        "LOW" => $value
//                    );
//                    $fce3->R_MATNR->Append($arr);
//                }
//                $arr = array(
//                    "SIGN" => "I",
//                    "OPTION" => "EQ",
//                    "LOW" => (int) $fce->T_STOCK->row["WERKS"]
//                );
//                $fce3->R_WERKS->Append($arr);
//                $fce3->call();
//                if($fce3->GetStatus() == SAPRFC_OK){
//                    $fc3->IT_DATA->Reset();
//                    $minggulalu = array();
//                    $rilis = array();
//                    $terima = array();
//                    while ($fce3->IT_DATA->Next()) {
//                        echo $fce3->IT_DATA->row['SHKZG']=='H';
//                        $key = str_replace(".","",$fce3->IT_DATA->row['BUDAT']);
//                        if($fce3->IT_DATA->row['SHKZG']=='H'){
//                            if(isset($rilis[$fce->T_STOCK->row["WERKS"]][$key]))
//                                $rilis[$fce->T_STOCK->row["WERKS"]][$key] += $fce3->IT_DATA->row['QTY_TON'];
//                            else {
//                                $rilis[$fce->T_STOCK->row["WERKS"]][$key] = 0; 
//                            }
//                        }else{
//                            if(isset($rilis[$fce->T_STOCK->row["WERKS"]][$key]))
//                                $terima[$fce->T_STOCK->row["WERKS"]][$key] += $fce3->IT_DATA->row['QTY_TON'];
//                            else {
//                                $terima[$fce->T_STOCK->row["WERKS"]][$key] = 0; 
//                            }
//                        }
//                    }
//                    
//                    var_dump($rilis);
//                    var_dump($terima);
//                }

                array_push($result, $row);
            }
            // $fce->Close();
            //$fce2->Close();
            return $result;
        } else {
            echo 'aha';
        }
    }

    function tesRFCtrans() {
        $dataSP = $this->getGudangSP();
        echo '<pre>';
        var_dump($dataSP);
        $this->load->library('Sap');
        $sap = new SAPConnection();
        $sap->Connect();
        $mat = array(
            '121-301-0050',
            '121-301-0060',
            '121-301-0110',
            '121-301-0120'
        );
        $fce3 = $sap->NewFunction("ZCMM_MAT_PEMAKAIAN_DETAIL");
        echo 'haha';
        $arr = array(
            "SIGN" => "I",
            "OPTION" => "BT",
            "LOW" => '20170101',
            "HIGH" => '20170131'
        );
        $fce3->R_BUDAT->Append($arr);
        $arr = array(
            "SIGN" => "I",
            "OPTION" => "EQ",
            "LOW" => '3000'
        );
        $fce3->R_BUKRS->Append($arr);
        foreach ($mat as $value) {
            $arr = array(
                "SIGN" => "I",
                "OPTION" => "EQ",
                "LOW" => $value
            );
            $fce3->R_MATNR->Append($arr);
        }
        $arr = array(
            "SIGN" => "I",
            "OPTION" => "EQ",
            "LOW" => (int) $fce->T_STOCK->row["WERKS"]
        );
        echo 'hehe2';
        $fce3->R_WERKS->Append($arr);
        var_dump($fce);
        $fce3->call();
        print_r($fce3);
        echo 'haha2';
        echo $fce3->GetStatusText();

        if ($fce3->GetStatus() == SAPRFC_OK) {
            $fc3->IT_DATA->Reset();
            $minggulalu = array();
            $rilis = array();
            $terima = array();
            while ($fce3->IT_DATA->Next()) {
                echo $fce3->IT_DATA->row['SHKZG'] == 'H';
                $key = str_replace(".", "", $fce3->IT_DATA->row['BUDAT']);
                if ($fce3->IT_DATA->row['SHKZG'] == 'H') {
                    if (isset($rilis[$fce->T_STOCK->row["WERKS"]][$key]))
                        $rilis[$fce->T_STOCK->row["WERKS"]][$key] += $fce3->IT_DATA->row['QTY_TON'];
                    else {
                        $rilis[$fce->T_STOCK->row["WERKS"]][$key] = 0;
                    }
                } else {
                    if (isset($rilis[$fce->T_STOCK->row["WERKS"]][$key]))
                        $terima[$fce->T_STOCK->row["WERKS"]][$key] += $fce3->IT_DATA->row['QTY_TON'];
                    else {
                        $terima[$fce->T_STOCK->row["WERKS"]][$key] = 0;
                    }
                }
            }

            var_dump($rilis);
            var_dump($terima);
        }
    }

    function tokoJson() {
        $data = '[{"NM_TOKO":"SEMANGAT BARU","LATITUDE":"-8.156739","LONGITUDE":"112.475619","ALAMAT":"JL. JENDRAL SUDIRMAN 164 Kec. Sumberpucung Kota. Malang Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"JALIBAR JAYA","LATITUDE":"-8.103536","LONGITUDE":"112.569628","ALAMAT":"JL. RAYA JALIBAR 09 Kec. Kepanjen Kota. Malang Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"MULYA JAYA","LATITUDE":"-8.01278","LONGITUDE":"112.592937","ALAMAT":"JL. RAYA PARANG ARGO 23 Kec. Wagir Kota. Malang Jawa Timur, 65171 "},'
                . '{"NM_TOKO":"JAYA","LATITUDE":"-7.636693","LONGITUDE":"112.908671","ALAMAT":"JL. SULAWESI 3 Kec. Grati Kota. Pasuruan Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"SAMPURNA","LATITUDE":"-7.698205","LONGITUDE":"112.974656","ALAMAT":"JL. RAYA NGOPAK ARJOSARI REJOSO Kec. Grati Kota. Pasuruan Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"RIZQY","LATITUDE":"-7.662913","LONGITUDE":"112.893778","ALAMAT":"JL. UNTUNG SUROPATI 49 Kec. Pohjentrek Kota. Pasuruan Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"SUMBER JAYA","LATITUDE":"-7.663053","LONGITUDE":"112.895224","ALAMAT":"PASAR BESAR KEBON AGUNG Kec. Pohjentrek Kota. Pasuruan Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"MURAH","LATITUDE":"-7.687871","LONGITUDE":"112.885845","ALAMAT":"JL. RAYA WARUNGDOWO TIMUR 33 Kec. Pohjentrek Kota. Pasuruan Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"DEWI SRI","LATITUDE":"-7.773835","LONGITUDE":"112.744798","ALAMAT":"JL. Raya Purwosari Kec. Purwosari Kota. Pasuruan Jawa Timur, 65171 "},'
                . '{"NM_TOKO":"BANGUN INDAH GRAHA","LATITUDE":"-7.938617","LONGITUDE":"112.625491","ALAMAT":"JL. SOEKARNO HATTA 68 Kec. Donomulyo Kota. Malang Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"47","LATITUDE":"-8.129701","LONGITUDE":"112.571619","ALAMAT":"JL. Raya Kidul Pasar Kepanjen Kec. Kepanjen Kota. Malang Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"SINAR SENGKALING","LATITUDE":"-7.91633","LONGITUDE":"112.582924","ALAMAT":"Jl. Sido Makmur Kec. Dau Kota. Malang Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"SIDO MAKMUR","LATITUDE":"-7.919352","LONGITUDE":"112.582166","ALAMAT":"Jl. Sumber Sari Kec. Dau Kota. Malang Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"SUMBER SEKAR","LATITUDE":"-7.922492","LONGITUDE":"112.576023","ALAMAT":"JL. APEL 1 Kec. Dau Kota. Malang Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"PESANGGRAHAN","LATITUDE":"-7.60796","LONGITUDE":"112.785849","ALAMAT":"Jl. Rambutan Kec. Bangil Kota. Pasuruan Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"MAPAN","LATITUDE":"-7.687647","LONGITUDE":"112.708837","ALAMAT":"JL. RAYA SUWOYUWO Kec. Sukorejo Kota. Pasuruan Jawa Timur, 65172 "},'
                . '{"NM_TOKO":"PANGLIMA","LATITUDE":"-7.599337","LONGITUDE":"112.783929","ALAMAT":"JL. DR SUTOMO 57 Kec. Sukorejo Kota. Pasuruan Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"SINAR MULYA ABADI","LATITUDE":"-7.688537","LONGITUDE":"112.889195","ALAMAT":"JL. RAYA BAJANGAN GONDANGWETAN Kec. Gondangwetan Kota. Pasuruan Jawa Timur, 65170 "},'
                . '{"NM_TOKO":"TB. PRAKARSA","LATITUDE":"-7.946432","LONGITUDE":"112.622573","ALAMAT":"Jl. Cengkeh Kec. Blimbing Kota. Kota Malang Jawa Timur, 65171 "}]';
        echo $data;
    }

    function getStokTransit($kd_gdg) {
        date_default_timezone_set("Asia/Jakarta");
        $current_time_obj = new DateTime();
        $transit_hasil = $this->StockLevelGudang_model->getStokTransit($kd_gdg);
        $spj = $this->StockLevelGudang_model->getSpjAll($kd_gdg);

        $dataspjtrun = array();
        unset($dataspjtrun);
        foreach ($spj as $data) {
            $NO_SPJ = $data["NO_SPJ"];
            $dataspjtrun[$NO_SPJ] = $data;
        }

        for ($i = 0; $i < sizeof($transit_hasil); $i++) {
            $tgl_berangkat = $transit_hasil[$i]['TGL_BERANGKAT'];
            $current_date = date("Y-m-d H:i:s");
            $diff_time = round((strtotime($current_date) - strtotime($tgl_berangkat)) / 60 / 60, 1);
            //if($diff_time <= ($transit_hasil[$i]['LEAD_TIME']*2)){
            if (true) {
                $hasil[$i]['REALISASI'] = $diff_time; //$realisasi;

                $hasil[$i]['NO_SPJ'] = $transit_hasil[$i]['NO_SPJ'];
                $hasil[$i]['NO_POLISI'] = $transit_hasil[$i]['NO_POLISI'];
                //$hasil[$i]['NAMA_SOPIR']=$transit_hasil[$i]['NAMA_SOPIR'];
                $hasil[$i]['NAMA_EXPEDITUR'] = $transit_hasil[$i]['NAMA_EXPEDITUR'];
                //                $hasil[$i]['TGL_CMPLT']=$tgl_spj_formatted;
                //                $hasil[$i]['JAM_CMPLT']=$jam_spj_formatted;
                $hasil[$i]['TGL_BERANGKAT'] = $transit_hasil[$i]['TGL_BERANGKAT'];
                $hasil[$i]['KWANTUM'] = $transit_hasil[$i]['KWANTUM'] * 1;
                $hasil[$i]['KWANTUMX'] = $transit_hasil[$i]['KWANTUMX'] * 1;

                //$hasil[$i]['TGL_MASUK']=$dataspjtrun[$transit_hasil[$i]['NO_SPJ']]['TANGGAL_MASUK'];//$tgl_masuk;

                $hasil[$i]['TGL_KELUAR'] = 0; //$data['TANGGAL_KELUAR'];
                $hasil[$i]['LEAD_TIME'] = $transit_hasil[$i]['LEAD_TIME'];
                $hasil[$i]['PERKIRAAN'] = $transit_hasil[$i]['ETA'];
                $hasil[$i]['TGL'] = $transit_hasil[$i]['TGL'];


                //$tgl_datang = $dataspjtrun[$transit_hasil[$i]['NO_SPJ']]['TANGGAL_MASUK'];
//                if (!empty($dataspjtrun[$transit_hasil[$i]['NO_SPJ']]['TANGGAL_MASUK']) && $dataspjtrun[$transit_hasil[$i]['NO_SPJ']] != '') {
//
//                    //$tgl_masuk = $dataspjtrun[$transit_hasil[$i]['NO_SPJ']]['TANGGAL_MASUK'];//new DateTime($dataspjtrun[$transit_hasil[$i]['NO_SPJ']]['TANGGAL_MASUK']);
//                    $tgl_masuk_obj = new DateTime($dataspjtrun[$transit_hasil[$i]['NO_SPJ']]['TANGGAL_MASUK']);
//
//                    $hasil[$i]['STATUS'] = "Siap Bongkar";
//
//                    $tgl_masuk_obj->modify('+24 hours');
//
//                    if ($tgl_masuk_obj < $current_time_obj) {
//                        $hasil[$i]['STATUS'] = "Inap";
//                    }
//                } else {
//                    $hasil[$i]['STATUS'] = "Perjalanan";
//                    $eta = new DateTime($transit_hasil[$i]['ETA']);
//                    $eta->format('Y-m-d - H:i:s');
//
//                    if ($current_time_obj > $eta) {
//                        $hasil[$i]['STATUS'] = "Perjalanan (terlambat)";
//                    }
//                }
            }
        }
        if (!isset($hasil)) {
            $hasil = array();
            echo json_encode($hasil);
        } else {
            echo json_encode($hasil);
        }
    }

    function getProvinsi() {
        $data = $this->StockLevelGudang_model->getProv();
        echo json_encode($data);
    }

    function getArea() {
        $data = $this->StockLevelGudang_model->getArea();
        echo json_encode($data);
    }

    function testingElogs(){
        echo '<pre>';
            print_r($this->StockLevelGudang_model->getPetaDataElogs());
        echo '<pre>';
    }

    function coba() {
        $transit_hasil = $this->StockLevelGudang_model->getLeadTime();
        $aarSql = $this->StockLevelGudang_model->getPeta();

        $current_date = date("Y-m-d H:i:s");

        for ($i = 0; $i < sizeof($aarSql); $i++) {
            $kwantum = 0;
            $jml_truk = 0;
            $sisa_so = 0;
            foreach ($transit_hasil as $data) {
                $tgl_berangkat = $transit_hasil[$i]['TGL_BERANGKAT'];
                $diff_time = round((strtotime($current_date) - strtotime($tgl_berangkat)) / 60 / 60, 1);
                if ($data['KODE_DA'] == $aarSql[$i]['KD_GDG']) {
                    if ($diff_time <= ($transit_hasil[$i]['LEAD_TIME'] * 2)) {
                        $kwantum += $data['KWANTUMX'];
                        $jml_truk = $data['JML_TRUK'];
                    }
                    $sisa_so = $data['SISA_TO'];
                }
            }
            $aarSql[$i]['TRANSIT'] = $kwantum;
            $aarSql[$i]['SISA_TO'] = $sisa_so;
            $aarSql[$i]['JML_TRUK'] = $jml_truk;

            if ($aarSql[$i]['STOK'] < 0) {
                $aarSql[$i]['STOK'] = 0;
                $aarSql[$i]['STOK_LEVEL'] = 0;
            }
            if ($aarSql[$i]['KAPASITAS'] != 0) {
                $aarSql[$i]['TOTAL_LEVEL'] = floor(($aarSql[$i]['TRANSIT'] + $aarSql[$i]['STOK']) / $aarSql[$i]['KAPASITAS'] * 100);
            } else {
                $aarSql[$i]['TOTAL_LEVEL'] = 0;
            }
        }
        //echo json_encode($aarSql);
        echo '<pre>';
        print_r($aarSql);
        echo '</pre>';
    }

    // function getChart($kode_gudang, $date) {
    function getChart($kode_gudang, $date, $flag) {
        date_default_timezone_set("Asia/Jakarta");
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        $hari = date('t', strtotime($tahun . "-" . $bulan));
        //echo $date;
        //echo '<br/>';
        //echo $hari;
        $tanggal = array();
        for ($i = 1; $i <= $hari; $i++) {
            if (strlen($i) < 2) {
                $tgl = '0' . $i;
            } else {
                $tgl = $i . '';
            }
            array_push($tanggal, $tgl);
        }
        $data = $this->StockLevelGudang_model->getStokRilis($kode_gudang, $date);
        // print_r($data);
        // if($flag == 0){
        //     $dataElogs = $this->StockLevelGudang_model->getStokElogsHarian($kode_gudang, $date);
        // }
        // else {
        //     $dataElogs = $this->StockLevelGudang_model->getStokElogsHarianDist($kode_gudang, $date);
        // }
        // $dataElogs = $this->StockLevelGudang_model->getStokElogsHarian($kode_gudang, $date);

        $arr['KODE_GUDANG'] = $kode_gudang;
        $arr['NAMA_GUDANG'] = $data[0]['NM_GDG'];
        $arr['TANGGAL'] = $tanggal;
        $arr['STOK'] = array();
        $arr['RILIS'] = array();
        $arr['TIGAPULUH'] = array();
        $arr['TUJUHPULUH'] = array();
        $arr['SERATUS'] = array();
        $arr['SOURCE'] = 'CRM';
        $qty = array();
        foreach ($tanggal as $tgl) {
            $qty[$tgl]['STOK'] = 0;
            $qty[$tgl]['RILIS'] = 0;
            foreach ($data as $value) {
                if ($tgl == $value['TANGGAL']) {
                    $qty[$tgl]['STOK'] = $value['QTY_STOK'];
                    $qty[$tgl]['RILIS'] = $value['QTY_RILIS'];
                }
                $qty[$tgl]['KAPASITAS'] = $value['KAPASITAS'];
            }
        }

//        if (!empty($dataElogs)) {
//            $arr['SOURCE'] = 'E-LOGS';
//            foreach ($tanggal as $tgl) {
//                $qty[$tgl]['STOK'] = 0;
//                foreach ($dataElogs as $value) {
//                    if ($tgl == $value['TANGGAL']) {
//                        $qty[$tgl]['STOK'] = $value['QTY_STOK'];
//                    }
//                    $qty[$tgl]['KAPASITAS'] = $value['KAPASITAS'];
//                }
//            }
//        }

//        echo '<pre>';
//        print_r($qty);
//        echo '</pre>';
//        $kapasitas = $data[0]['KAPASITAS'];
        foreach ($qty as $value) {
            array_push($arr['STOK'], $value['STOK']);
            array_push($arr['RILIS'], $value['RILIS']);
            $kapasitas = $value['KAPASITAS'];
            array_push($arr['SERATUS'], $kapasitas);
            $tigapuluh = ($kapasitas * 30) / 100;
            $tujuhpuluh = ($kapasitas * 70) / 100;
            array_push($arr['TIGAPULUH'], $tigapuluh);
            array_push($arr['TUJUHPULUH'], $tujuhpuluh);
        }
//                echo '<pre>';
//        print_r($arr);
//        echo '</pre>';
        echo json_encode($arr);
    }

    //====================== FUNCTION CRUD ENTRY GUDANG ======================\\
    function MasterGudang() {
        // Link ini hanya admin yang dapat mengakses
        if ($this->session->userdata('akses') == 1 || $this->session->userdata('akses') == 2) {
            $data = array('title' => 'Master Gudang');

            $this->template->display('master-gudang', $data);
            // Selain admin diarahkan ke halaman competitor
        } else {
            redirect(base_url() . 'smigroup/StockLevelGudang');
        }
    }

    function ListGudang() {
        $list = $this->MasterGudang_model->ListGudang();
        // echo '<pre>';
        // print_r($list);die;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lists) {
            $no++;
            $row = array();
            $row[] = '<center>' . $no . '</center>';
            $row[] = $lists['NM_DISTR'];
            $row[] = $lists['KD_GDG'];
            $row[] = $lists['NM_GDG'];
            $row[] = $lists['ALAMAT'];
            $row[] = $lists['KAPASITAS'];
            $row[] = $lists['UNLOADING_RATE_TON'];
            $row[] = $lists['ORG'];
            $row[] = '<center>'
                    . '<a class="btn btn-xs btn-warning" style="margin-right: 5px;" href="javascript:void(0)" title="Edit" onclick="edit_gudang(' . "'" . $lists['ID'] . "'" . ')"><i class="fa fa-edit"></i> Edit</a>'
                    . '<a class="btn btn-xs btn-danger" style="margin-right: 5px;" href="javascript:void(0)" title="Hapus" onclick="delete_gudang(' . "'" . $lists['ID'] . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>'
                    . '</center>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->MasterGudang_model->CountGudang(),
            "recordsFiltered" => $this->MasterGudang_model->FilterGudang(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function DetailGudang($id) {
        $data = $this->MasterGudang_model->DetailGudang($id);
        echo json_encode($data);
    }

    function AddGudang() {
//        $max = $this->db->query('select max(KODE_PERUSAHAAN) MAXID FROM ZREPORT_MS_PERUSAHAAN');
        $max = $this->MasterGudang_model->max_id();
        foreach ($max as $maxs) {
            $idmax = $maxs->MAXID;
        }
        $id = $idmax + 1;
//        $kd_perusahaan = $this->input->post('KODE_PERUSAHAAN');
        $kd_distr = htmlspecialchars($this->input->post('KD_DISTR'));
        $nm_distr = htmlspecialchars(strtoupper($this->input->post('NM_DISTR')));
        $kd_gdg = htmlspecialchars($this->input->post('KD_GDG'));
        $nm_gdg = htmlspecialchars(strtoupper($this->input->post('NM_GDG')));
        $alamat = htmlspecialchars($this->input->post('ALAMAT'));
        $kapasitas = htmlspecialchars($this->input->post('KAPASITAS'));
        $kap_bongkar = htmlspecialchars($this->input->post('KAPASITAS_B'));
        // $create_date = date('Y-m-d H:i:s');
        $create_by = strtoupper($this->session->userdata('usernamescm'));
        $kd_disktrik = htmlspecialchars($this->input->post('KD_DISTRIK'));
        $area = htmlspecialchars($this->input->post('AREA'));
        $latitude = htmlspecialchars($this->input->post('LATITUDE'));
        $longitude = htmlspecialchars($this->input->post('LONGITUDE'));
        $org = htmlspecialchars($this->input->post('ORG'));

        $return = $this->MasterGudang_model->AddGudang($id, $kd_distr, $nm_distr, $kd_gdg, $nm_gdg, $alamat, $kapasitas, $kap_bongkar, $create_by, $kd_disktrik, $area, $latitude, $longitude, $org);
        // $return = $this->Competitor_model->AddPerusahaan($kd_perusahaan, $nm_perusahaan, $inisial, $produk, $status, $create_by);
        echo json_encode(array("status" => $return));
    }

    function UpdateGudang() {
        $id = $this->input->post('ID');
        $kd_distr = htmlspecialchars($this->input->post('KD_DISTR'));
        $nm_distr = htmlspecialchars(strtoupper($this->input->post('NM_DISTR')));
        $kd_gdg = htmlspecialchars($this->input->post('KD_GDG'));
        $nm_gdg = htmlspecialchars(strtoupper($this->input->post('NM_GDG')));
        $alamat = htmlspecialchars($this->input->post('ALAMAT'));
        $kapasitas = htmlspecialchars($this->input->post('KAPASITAS'));
        $kap_bongkar = htmlspecialchars($this->input->post('KAPASITAS_B'));
        // $create_date = date('Y-m-d H:i:s');
        $create_by = strtoupper($this->session->userdata('usernamescm'));
        $kd_disktrik = htmlspecialchars($this->input->post('KD_DISTRIK'));
        $area = htmlspecialchars($this->input->post('AREA'));
        $latitude = htmlspecialchars($this->input->post('LATITUDE'));
        $longitude = htmlspecialchars($this->input->post('LONGITUDE'));
        $org = htmlspecialchars($this->input->post('ORG'));

        $return = $this->MasterGudang_model->UpdateGudang($id, $kd_distr, $nm_distr, $kd_gdg, $nm_gdg, $alamat, $kapasitas, $kap_bongkar, $create_by, $kd_disktrik, $area, $latitude, $longitude, $org);
        // $return = $this->Competitor_model->UpdatePerusahaan($kd_perusahaan, $nm_perusahaan, $inisial, $produk, $status, $update_by);
        echo json_encode(array("status" => $return));
    }

    function DeleteGudang($id) {
        $return = $this->MasterGudang_model->DeleteGudang($id);
        echo json_encode(array("status" => $return));
    }

    //====================== FUNCTION CRUD ENTRY GUDANG ======================\\
    function AdjustmentGudang() {
        // Link ini hanya admin yang dapat mengakses
        if ($this->session->userdata('akses') == 1) {
            $data = array('title' => 'Adjustment Gudang');

            $this->template->display('master-adj-gudang', $data);
            // Selain admin diarahkan ke halaman competitor
        } else {
            redirect(base_url() . 'smigroup/StockLevelGudang');
        }
    }

    function pilih_child() {
        $id = $this->input->post('id');
        $this->load->model('AdjustmentGudang_model');

        $data = $this->AdjustmentGudang_model->get_child($id);

        echo form_dropdown("data", $data, '', '');
    }

    function AddAdjGudang() {
//        $max = $this->db->query('select max(KODE_PERUSAHAAN) MAXID FROM ZREPORT_MS_PERUSAHAAN');
        // $max = $this->AdjustmentGudang_model->max_id();
        // foreach ($max as $maxs) {
        //     $idmax = $maxs->MAXID;
        // }
        // $id = $idmax + 1;
//        $kd_perusahaan = $this->input->post('KODE_PERUSAHAAN');
        $company = htmlspecialchars($this->input->post('COMPANY'));
        $gudang = htmlspecialchars($this->input->post('GUDANG'));
        $bulan = htmlspecialchars($this->input->post('BULAN'));
        $tahun = htmlspecialchars($this->input->post('TAHUN'));
        $stok = htmlspecialchars($this->input->post('STOK'));

        $return = $this->AdjustmentGudang_model->AddAdjGudang($company, $gudang, $bulan, $tahun, $stok);
        // $return = $this->Competitor_model->AddPerusahaan($kd_perusahaan, $nm_perusahaan, $inisial, $produk, $status, $create_by);
        echo json_encode(array("status" => $return));
    }

    function ListAdjGudang() {
        $list = $this->AdjustmentGudang_model->ListAdjGudang();
        // echo '<pre>';
        // print_r($list);die;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lists) {
            $no++;
            $row = array();
            $row[] = '<center>' . $no . '</center>';
            if ($lists['COMPANY'] == 4000) {
                $row[] = 'Semen Tonasa';
            } else if ($lists['COMPANY'] == 7000) {
                $row[] = 'Semen Gresik';
            } else {
                $row[] = 'Semen Padang';
            }
            // $row[] = $lists['COMPANY'];
            $row[] = $lists['NM_GDG'];
            $row[] = $lists['TAHUN'];
            $row[] = $lists['BULAN'];
            $row[] = $lists['STOK'];
            $row[] = '<center>'
                    . '<a class="btn btn-xs btn-warning" style="margin-right: 5px;" href="javascript:void(0)" title="Edit" onclick="edit_gudang(' . "'" . $lists['ID'] . "'" . ')"><i class="fa fa-edit"></i> Edit</a>'
                    . '<a class="btn btn-xs btn-danger" style="margin-right: 5px;" href="javascript:void(0)" title="Hapus" onclick="delete_gudang(' . "'" . $lists['ID'] . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>'
                    . '</center>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AdjustmentGudang_model->CountAdjGudang(),
            "recordsFiltered" => $this->AdjustmentGudang_model->FilterAdjGudang(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function DetailAdjGudang($id) {
        $data = $this->AdjustmentGudang_model->DetailAdjGudang($id);
        echo json_encode($data);
    }

    function UpdateAdjGudang() {
        $id = $this->input->post('ID');
        $company = htmlspecialchars($this->input->post('COMPANY'));
        $gudang = htmlspecialchars($this->input->post('GUDANG'));
        $bulan = htmlspecialchars($this->input->post('BULAN'));
        $tahun = htmlspecialchars($this->input->post('TAHUN'));
        $stok = htmlspecialchars($this->input->post('STOK'));

        $return = $this->AdjustmentGudang_model->UpdateAdjGudang($id, $company, $gudang, $bulan, $tahun, $stok);
        // $return = $this->Competitor_model->AddPerusahaan($kd_perusahaan, $nm_perusahaan, $inisial, $produk, $status, $create_by);
        echo json_encode(array("status" => $return));
    }

    function DeleteAdjGudang($id) {
        $return = $this->AdjustmentGudang_model->DeleteAdjGudang($id);
        echo json_encode(array("status" => $return));
    }

}

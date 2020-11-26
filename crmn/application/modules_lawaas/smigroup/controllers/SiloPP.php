<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class SiloPP extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login')) {
            redirect('login');
        }
        $this->load->model('SiloPP_model');
    }

    function index() {
        $data = array('title' => 'Silo PP');
        $this->template->display('SiloPP_view', $data);
    }

    function getDataPlant() {
        set_time_limit(0);
        $data = $this->getNMPlan();
        echo json_encode($data);
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
    }

    ########## MENDAPATKAN STOCK SILO ############

    function getStockSilo() {
        $data = $this->SiloPP_model->getDataPlant();
        $PLANT = array();
        foreach ($data as $key => $value) {
            $data[$key]['SILO']['OPC'] = 0;
            $data[$key]['SILO']['PPC'] = 0;
            $data[$key]['SILO']['PCC'] = 0;
            $data[$key]['REALISASI']['OPC'] = 0;
            $data[$key]['REALISASI']['PPC'] = 0;
            $data[$key]['REALISASI']['PCC'] = 0;
            $data[$key]['REAL_KEMARIN'] = 0;
            $data[$key]['AVERAGE'] = 0;
            $data[$key]['JAM_CREATE'] = 0;
        }
        $silo = $this->SiloPP_model->getStockSilo();
        $padang['OPC'] = 0;
        $padang['PPC'] = 0;
        $padang['PCC'] = 0;
        $tonasa['OPC'] = 0;
        $tonasa['PPC'] = 0;
        $tonasa['PCC'] = 0;
        foreach ($silo as $value) {
            foreach ($data as $key => $val) {
                if ($val['KODE_PLANT'] == 3301 || $val['KODE_PLANT'] == 3302 || $val['KODE_PLANT'] == 3303 || $val['KODE_PLANT'] == 3304) {
                    if ($value['TIPE'] == 'OPC') {
                        $padang['OPC'] += $value['STOCK_SILO'];
                    } else if ($value['TIPE'] == 'PPC') {
                        $padang['PPC'] += $value['STOCK_SILO'];
                    } else if ($value['TIPE'] == 'PCC') {
                        $padang['PCC'] += $value['STOCK_SILO'];
                    }
                } else if ($val['KODE_PLANT'] == 4301 || $val['KODE_PLANT'] == 4302 || $val['KODE_PLANT'] == 4303) {
                    if ($value['TIPE'] == 'OPC') {
                        $tonasa['OPC'] += $value['STOCK_SILO'];
                    } else if ($value['TIPE'] == 'PPC') {
                        $tonasa['PPC'] += $value['STOCK_SILO'];
                    } else if ($value['TIPE'] == 'PCC') {
                        $tonasa['PCC'] += $value['STOCK_SILO'];
                    }
                } else {
                    if ($val['KODE_PLANT'] == $value['NMPLAN']) {
                        if ($value['TIPE'] == 'OPC') {
                            $data[$key]['SILO']['OPC'] = round($value['STOCK_SILO']);
                        } else if ($value['TIPE'] == 'PPC') {
                            $data[$key]['SILO']['PPC'] = round($value['STOCK_SILO']);
                        } else if ($value['TIPE'] == 'PCC') {
                            $data[$key]['SILO']['PCC'] = round($value['STOCK_SILO']);
                        }
                    }
                }
            }
        }
        $stokTuban = $this->getStockSiloSAP();
        foreach ($data as $key => $value) {
            if ($value['KODE_PLANT'] == 3301) {
                $data[$key]['SILO']['OPC'] = round($padang['OPC']);
                $data[$key]['SILO']['PPC'] = round($padang['PPC']);
                $data[$key]['SILO']['PCC'] = round($padang['PCC']);
            } else if ($value['KODE_PLANT'] == 4301) {
                $data[$key]['SILO']['OPC'] = round($tonasa['OPC']);
                $data[$key]['SILO']['PPC'] = round($tonasa['PPC']);
                $data[$key]['SILO']['PCC'] = round($tonasa['PCC']);
            } else if ($value['KODE_PLANT'] == '7404' || $value['KODE_PLANT'] == '2404') {
                $data[$key]['SILO']['OPC'] = round($stokTuban[date('Ymd', strtotime('-1 day'))][$value['KODE_PLANT']]['OPC']);
                $data[$key]['SILO']['PPC'] = round($stokTuban[date('Ymd', strtotime('-1 day'))][$value['KODE_PLANT']]['PPC']);
            }
        }
        foreach ($data as $key => $value) {
            $data[$key]['SILO']['TOTAL'] = $value['SILO']['OPC'] + $value['SILO']['PPC'] + $value['SILO']['PCC'];
        }
        return $data;
    }

    function getStockSiloSAP($range = 'day', $sdate = FALSE, $edate = FALSE) {
        error_reporting(E_ALL);
        $data = array();
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

        $fce = $sap->NewFunction("Z_ZAPPSD_DISPLAY_SILO");

        if ($fce == false) {
            echo 'error Connecting';
            // $sap->PrintStatus();
            exit;
        }

        $date = date('Ymd', strtotime('-1 day'));

        if ($range == 'day') {
            //header entri 
            $fce->FI_CREDA = $date;
            $fce->FI_ENDDA = $date;
            $fce->FI_DAY2DAY = 'X';
        } else if ($range == 'month') {
            $fce->FI_CREDA = $sdate;
            $fce->FI_ENDDA = $edate;
            $fce->FI_DAY2DAY = 'X';
        }
        $fce->call();
        $data = array(
            'CREATE_DATE' => '',
            'OPC' => 0,
            'PPC' => 0,
            'TOTAL' => 0
        );

        $result = array(
            '7404' => $data,
            '2404' => $data
        );

        $final = array();
        $tempdate = FALSE;
        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->FT_DAY->Reset();

            while ($fce->FT_DAY->Next()) {
                if (!$tempdate || $tempdate !== $fce->FT_DAY->row['CREATE_DATE']) {
                    $tempdate = $fce->FT_DAY->row['CREATE_DATE'];
                    $result = array(
                        '7404' => $data,
                        '2404' => $data
                    );
                }

                if ($fce->FT_DAY->row['PACKER'] == 'PELABUHAN') {
                    $result['7404']['OPC'] += ($fce->FT_DAY->row['SILO1_OPC'] + $fce->FT_DAY->row['SILO2_OPC'] + $fce->FT_DAY->row['SILO3_OPC'] + $fce->FT_DAY->row['SILO4_OPC']);
                    $result['7404']['PPC'] += ($fce->FT_DAY->row['SILO1_PPC'] + $fce->FT_DAY->row['SILO2_PPC'] + $fce->FT_DAY->row['SILO3_PPC'] + $fce->FT_DAY->row['SILO4_PPC']);
                    $result['7404']['TOTAL'] += $fce->FT_DAY->row['TOTAL'];
                } else {
                    $result['2404']['OPC'] += ($fce->FT_DAY->row['SILO1_OPC'] + $fce->FT_DAY->row['SILO2_OPC'] + $fce->FT_DAY->row['SILO3_OPC'] + $fce->FT_DAY->row['SILO4_OPC']);
                    $result['2404']['PPC'] += ($fce->FT_DAY->row['SILO1_PPC'] + $fce->FT_DAY->row['SILO2_PPC'] + $fce->FT_DAY->row['SILO3_PPC'] + $fce->FT_DAY->row['SILO4_PPC']);
                    $result['2404']['TOTAL'] += $fce->FT_DAY->row['TOTAL'];
                }
                $final[$fce->FT_DAY->row['CREATE_DATE']] = $result;

//                if ($tempdate != $fce->FT_DAY->row['CREATE_DATE']) {
//                    array_push($final, $result);
//                }
            }
        } else
            $fce->PrintStatus();

        return $final;
    }

    function getNMPlan() {
        $IT_DATA = $this->getRealKemarin();
        $maxDate = array();
        $data = $this->SiloPP_model->getNMPlan();
        foreach ($data as $dt) {
            $maxDate[$dt['NMPLAN']] = $dt['JAM_CREATE'];
        }
        foreach ($IT_DATA as $key => $value) {
            $IT_DATA[$key]['CAP_DETAIL'] = $this->SiloPP_model->getCapacity($value['KODE_PLANT']);
            $IT_DATA[$key]['UTILITY'] = $this->SiloPP_model->getUtilitySDK($value['ORG'], $value['KODE_PLANT']);
            foreach ($maxDate as $k => $val) {
                if ($value['KODE_PLANT'] == $k || ($value['KODE_PLANT'] == '4609' && $k = '4413')) {
                    $tgl = substr($val, 0, 10);
                    $jam = str_replace('.', ':', substr($val, 10, 9));
                    $satuan = substr($val, 26, 2);
                    $create_date = $tgl . " " . $jam . " " . $satuan;
                    $IT_DATA[$key]['JAM_CREATE'] = $create_date;
                }
            }
        }

        return $IT_DATA;
    }

    ####### MENDAPATKAN NILAI GIT $ ETA ############

    function getGit() {
        $IT_DATA = $this->getStockSilo();
        foreach ($IT_DATA as $key => $value) {
            $plant = $value['KODE_PLANT'];
            $git = $this->SiloPP_model->getGit($plant);
            foreach ($git as $gt) {
                $IT_DATA[$key]['GIT'] = $gt['GIT'];
                $IT_DATA[$key]['ETA'] = isset($gt['ETA']) ? $gt['ETA'] : '';
            }
        }
        return $IT_DATA;
    }

    function realisasi() {
        $IT_DATA = $this->getGit();
        $kwn = $this->SiloPP_model->getKwantum();
        foreach ($IT_DATA as $key => $value) {
            foreach ($kwn as $data) {
                if ($value['KODE_PLANT'] == $data['PLANT']) {
                    $IT_DATA[$key]['REALISASI']['OPC'] += $data['KWANTUMX'];
                }
            }
        }
        return $IT_DATA;
//        echo '<pre>';
//        print_r($IT_DATA);
//        echo '</pre>';
    }

    ################ MENDAPATKAN NILAI AVERAGE ###############

    function getAverage() {
        $IT_DATA = $this->realisasi();
        date_default_timezone_set("Asia/Jakarta");
        $date1 = date('Ym');
        $date2 = date('Ymd');
        $avg = $this->SiloPP_model->getAverage($date1, $date2);
        foreach ($IT_DATA as $key => $value) {
            foreach ($avg as $data) {
                $plant = $data['PLANT'];
                $jml_hari = date('d');
                if ($value['KODE_PLANT'] == $plant) {
                    $IT_DATA[$key]['AVERAGE'] = $data['KWANTUMX'] / $jml_hari;
                }
            }
        }
        // echo '<pre>';
        //   echo print_r($IT_DATA);
        //  echo '</pre>';
        return $IT_DATA;
    }

    function getVkorgAverage() {
        $IT_DATA = $this->getAverage();
        date_default_timezone_set("Asia/Jakarta");
        $date1 = date('Ym');
        $date2 = date('Ymd');
        $avg = $this->SiloPP_model->getVkorgAverage($date1, $date2);
        foreach ($IT_DATA as $key => $value) {
            foreach ($avg as $data) {
                $plant = $data['WERKS'];
                $jml_hari = date('d');
                if ($value['KODE_PLANT'] == $plant) {
                    $IT_DATA[$key]['AVERAGE'] = $data['KWANTUMX'] / $jml_hari;
                }
            }
        }
        return $IT_DATA;
    }

    ####################################################################################
    ################## MENDAPATKAN NILAI REALISASI KEMARIN ###############

    function getVkorgRealKemarin() {
        $IT_DATA = $this->getVkorgAverage();
        date_default_timezone_set("Asia/Jakarta");
        $tgl_kemarin = date('Ymd', strtotime("-1 days"));
        $avg = $this->SiloPP_model->getVkorgRealKemarin($tgl_kemarin);
        foreach ($IT_DATA as $key => $value) {
            foreach ($avg as $data) {
                $plant = $data['WERKS'];
                if ($value['KODE_PLANT'] == $plant) {
                    $IT_DATA[$key]['REAL_KEMARIN'] = str_replace(',', '.', $data['KWANTUMX']);
                }
            }
        }
//        echo '<pre>';
//        print_r($IT_DATA);
//        echo '</pre>';
        return $IT_DATA;
    }

    #####################################################################
    ################## MENDAPATKAN NILAI REALISASI HARI INI ###############

    function getVkorgRealisasi() {
        $IT_DATA = $this->getVkorgRealKemarin();
        date_default_timezone_set("Asia/Jakarta");
        $tanggal = date('Ymd');
        $avg = $this->SiloPP_model->getVkorgRealisasi($tanggal);
        foreach ($IT_DATA as $key => $value) {
            foreach ($avg as $data) {
                $plant = $data['WERKS'];
                if ($value['KODE_PLANT'] == $plant) {
                    $IT_DATA[$key]['REALISASI']['OPC'] = floatval(str_replace(',', '.', $data['KWANTUMX']));
                }
            }
        }
        return $IT_DATA;
//        echo '<pre>';
//        print_r($IT_DATA);
//        echo '</pre>';
    }

    ######################################################################
    ################## MENDAPATKAN NILAI REALISASI KEMARIN ###############

    function getRealKemarin() {
        $IT_DATA = $this->getVkorgRealisasi();
        date_default_timezone_set("Asia/Jakarta");
        $tgl_kemarin = date('Ymd', strtotime("-1 days"));
        $avg = $this->SiloPP_model->getRealKemarin($tgl_kemarin);
        foreach ($IT_DATA as $key => $value) {
            foreach ($avg as $data) {
                $plant = $data['PLANT'];
                if ($value['KODE_PLANT'] == $plant) {
                    $IT_DATA[$key]['REAL_KEMARIN'] = str_replace(',', '.', $data['KWANTUMX']);
                }
            }
        }
//        echo '<pre>';
//        print_r($IT_DATA);
//        echo '</pre>';
        return $IT_DATA;
    }

    ######################################################################

    function getInfoPasar() {
        $IT_DATA = $this->getRealKemarin();
        date_default_timezone_set("Asia/Jakarta");
        $tanggal = date('Ymd');
        $avg = $this->SiloPP_model->getInfoPasar($tanggal);
        foreach ($IT_DATA as $key => $value) {
            foreach ($avg as $data) {
                $plant = $data['PLANT'];
                if ($value['KODE_PLANT'] == $plant) {
                    $IT_DATA[$key]['REAL_KEMARIN'] = $data['REALTO'];
                }
            }
            foreach ($avg as $data) {
                $plantICS = $data['PLANT'];
                $plantICSF = $data['SOLD_TOF'];
                $ITEMICSF = $data['ITEMF'];
                if ($plantICS == '7403') {
                    if ($value['KODE_PLANT'] == '2404') {
                        $IT_DATA[$key]['REALICS'][$ITEMICSF][$plantICSF] = $data['REALTO'];
                    }
                } else {
                    if ($value['KODE_PLANT'] == $plantICS) {
                        $IT_DATA[$key]['REALICS'][$ITEMICSF][$plantICSF] = $data['REALTO'];
                    }
                }
            }
        }

        return $IT_DATA;
    }

    function getDataChart($org, $plant, $tahun, $bulan) {
        date_default_timezone_set("Asia/Jakarta");
        $hari = date('t', strtotime($tahun . "-" . $bulan));
        $tanggal_awal = '01' . $bulan . '' . $tahun;
        $tanggal_akhir = $hari . '' . $bulan . '' . $tahun;
        if ($plant == '2404') {
            $orgNew = '2000';
            $plantIn = "7403";
            $plantStock = $plant;
        } else if ($plant == '4301') {
            $orgNew = $org;
            $plantIn ="4301','4302','4303','4402";
            $plantStock = "4301','4302','4303','4402";
        }  else {
            $orgNew = $org;
            $plantIn = $plant;
            $plantStock = $plant;
        }
        $data = $this->SiloPP_model->getChartStock($orgNew, $plantStock, $tanggal_awal, $tanggal_akhir);
         //echo $this->db->last_query();
        $data_rilis = $this->SiloPP_model->getChartRilis($org, $plantIn, $tanggal_awal, $tanggal_akhir);


        //echo $this->db->last_query();
        $arr['plan'] = $this->db->get_where('ZREPORT_PETA_SILOPP', array("KODE_PLANT" => $plant))->row_array();
        $arr['tanggal'] = array();
        $arr['rilisbag'] = array();
        $arr['rilisbulk'] = array();
        $arr['stock'] = array();
        $arr['kapasitas'] = array();
        $arr['rilis'] = array();
        $arr['warna'] = array();
        for ($i = 1; $i <= (int) $hari; $i++) {
            if (strlen($i) == 1) {
                $tgl = '0' . $i;
            } else {
                $tgl = $i;
            }
            array_push($arr['tanggal'], $tgl);
            array_push($arr['rilis'], 0);
            array_push($arr['rilisbag'], 0);
            array_push($arr['rilisbulk'], 0);
            array_push($arr['stock'], 0);
            array_push($arr['warna'], '#aabdca');
        }

        foreach ($arr['tanggal'] as $key => $tgl) {
            foreach ($data as $value) {
                if ($tgl == substr($value['CREATE_DATE'], 0, 2)) {
                    $arr['stock'][$key] = $value['STOCK'];
                    $arr['warna'][$key] = '#3498dc';
                }
                $arr['kapasitas'][$key] = $value['KAPASITAS'];
            }
            foreach ($data_rilis as $value) {
                if ($tgl == substr($value['TGL'], 0, 2)) {
                    $arr['rilisbag'][$key] = (int) $value['BAG'];
                    $arr['rilisbulk'][$key] = (int) $value['BULK'];
                    $arr['rilis'][$key] = (int) $value['RELEASE'];
                }
            }
            if ($arr['plan']['TYPE'] == 2) {
                if (($arr['stock'][$key] == 0 && date('Ym') == $tahun . $bulan && $tgl < date('d')) || ($arr['stock'][$key] == 0 && date('Ym') < $tahun . $bulan)) {
                    if ($key != 0) {
                        $arr['stock'][$key] = $arr['stock'][$key - 1];
                    } else {
//                        $arr['stock'][$key] = $data[$key + 1]['STOCK'];
                    }
                }
            } else {
                if (($arr['stock'][$key] == 0 && date('Ym') == $tahun . $bulan && $tgl < date('d')) || ($arr['stock'][$key] == 0 && date('Ym') < $tahun . $bulan)) {
                    $arr['stock'][$key] = $arr['stock'][$key - 1] - $arr['rilis'][$key - 1];
                } else {
//                    $arr['stock'][$key] = $data[$key + 1]['STOCK'];
                }
            }
        }
        if ($plant == '2404' || $plant == '7404') {
            $dataTuban = $this->getStockSiloSAP('month', $tahun . $bulan . '01', $tahun . $bulan . $hari);
            foreach ($dataTuban as $key => $value) {
                $arr['stock'][(int) substr($key, 6, 2) - 1] = $value[$plant]['TOTAL'];
                $arr['warna'][(int) substr($key, 6, 2) - 1] = '#3498dc';
            }
        }
        echo json_encode($arr);
    }

    function getAverage7Hari() {
        $data = $this->Silo_model->getAverage7Hari();
    }

    function getDataTable() {
        set_time_limit(0);
        //$data = $this->SiloPP_model->getDataPlant();
        //$stokSilo = $this->getStockSilo();
        date_default_timezone_set("Asia/Jakarta");
        $stok = $this->getStockSilo();
        $data = $this->SiloPP_model->getAverage7Hari();
        foreach ($stok as $key => $value) {
            foreach ($data as $val) {
                $average = $val['KWANTUMX'] / 7;
                if ($value['KODE_PLANT'] == $val['PLANT']) {
                    $stok[$key]['AVERAGE'] = $average;
                }
            }
        }
        $maxDate = array();
        $waktu = $this->SiloPP_model->getNMPlan();
        foreach ($waktu as $dt) {
            $maxDate[$dt['NMPLAN']] = $dt['JAM_CREATE'];
        }

        $table = '<table class="table table-bordered" id="table-plant"><thead><tr>'
                . '<th width="2%">No.</th>'
                . '<th width="3%">Kode Plant</th>'
                . '<th width="12%">Lokasi Plant</th>'
                . '<th width="10%">OpCo</th>'
                . '<th width="10%">Stok (ton)</th>'
                . '<th width="10%">Kapasitas (ton)</th>'
                . '<th width="10%">Stock Level</th>'
                . '<th width="10%">Rata-rata Demand (ton)</th>'
                . '<th width="8%">Days of Inventory (day)</th>'
                . '<th width="20%">Last Update</th>'
                . '<th width="5%">Grafik</th>'
                . '</tr></thead><tbody>';
        $no = 1;

        foreach ($stok as $value) {
            $stokSilo = $value['SILO']['TOTAL'];
            $average = round($value['AVERAGE']);
            $level = round($stokSilo / $value['KAPASITAS'] * 100);
            if ($average > 0) {
                $inven = round($stokSilo / $average);
            } else {
                $inven = 0;
            }


            if ($value['TYPE'] == 1) {
                $table .= '<tr>'
                        . '<td>' . $no . '</td>'
                        . '<td>' . $value["KODE_PLANT"] . '</td>'
                        . '<td>' . $value["NAMA_PLANT"] . '</td>'
                        . '<td>' . $value["ORG"] . '</td>'
                        . '<td align="right">' . number_format($stokSilo, 0, ",", ".") . ' ton</td>'
                        . '<td align="right">' . number_format($value["KAPASITAS"], 0, ",", ".") . '</td>';
                if ($level < 30 || $level > 100) {
                    $table .= '<td align="right" class="font-merah">' . $level . '%</td>';
                } else {
                    $table .= '<td align="right">' . $level . '%</td>';
                }
                $table .= '<td align="right">' . number_format($average, 0, ",", ".") . '</td>'
                        . '<td align="center">' . $inven . '</td>';
                foreach ($maxDate as $k => $val) {
                    if ($value['KODE_PLANT'] == $k) {
                        $tgl = substr($val, 0, 10);
                        $jam = str_replace('.', ':', substr($val, 10, 9));
                        $satuan = substr($val, 26, 2);
                        $create_date = $tgl . " " . $jam . " " . $satuan;
                        $table .= '<td align="center">' . $create_date . '</td>';
                    }
                }
                $table .= '<td><button class="btn btn-sm btn-info" onclick="tampilChart(' . $value["ORG"] . ',' . $value["KODE_PLANT"] . ')"><i class="fa fa-bar-chart"></i> Stok & Rilis</button></td>';
            }
            $table .= '</tr>';
            $no++;
        }

        $table .= '</tbody></table>';

        echo json_encode($table);
    }

    function coba() {
        date_default_timezone_set("Asia/Jakarta");
        $stok = $this->getStockSilo();
        $data = $this->SiloPP_model->getAverage7Hari();
//        foreach ($stok as $key => $value) {
//            foreach ($data as $val) {
//                $average = $val['KWANTUMX'] / 7;
//                if ($value['KODE_PLANT'] == $val['PLANT']) {
//                    $stok[$key]['AVERAGE'] = $average;
//                }
//            }
//        }
        echo '<pre>';
        print_r($stok);
        echo '</pre>';
    }

}

<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Demandpl extends CI_Controller {

    private $db2;

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        $this->load->model('Demandpl_model');
        $this->load->model('DemandplMS_model');
        set_time_limit(0);
    }

    public function index() {
        $data = array('title' => 'Sales & Operations Planning');
        $tgl = date("d-m-Y");
        $hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
        $bulan = array(
            "01" => "Januari",
            "02" => "Februari",
            "03" => "Maret",
            "04" => "April",
            "05" => "Mei",
            "06" => "Juni",
            "07" => "Juli",
            "08" => "Agustus",
            "09" => "September",
            "10" => "Oktober",
            "11" => "November",
            "12" => "Desember"
        );
        $n = date("w", strtotime($tgl));
        $data['perusahaan'] = $this->DemandplMS_model->getPerusahaan();
        $data['tanggal'] = $hari[$n] . ", " . date('d') . " " . $bulan[date('m')] . " " . date('Y');
        $data['head'] = array('Produksi Terak', 'Produksi Semen', 'Stok Terak (Plant)', 'Stok Semen (Plant)', 'Vol Penjualan Dom', 'Total'); //, 'Growth Real / Prognose');
        $this->template->display('Demandpl_view', $data);
    }

    public function tahunan() {
        $data = array('title' => 'Sales & Operations Planning per Tahun');
        $tgl = date("d-m-Y");
        $hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
        $bulan = array(
            "01" => "Januari",
            "02" => "Februari",
            "03" => "Maret",
            "04" => "April",
            "05" => "Mei",
            "06" => "Juni",
            "07" => "Juli",
            "08" => "Agustus",
            "09" => "September",
            "10" => "Oktober",
            "11" => "November",
            "12" => "Desember"
        );
        $n = date("w", strtotime($tgl));
        $data['perusahaan'] = $this->DemandplMS_model->getPerusahaan();
        $data['tanggal'] = $hari[$n] . ", " . date('d') . " " . $bulan[date('m')] . " " . date('Y');
        $data['head'] = array('Produksi Terak', 'Produksi Semen', 'Stok Terak (Plant)', 'Stok Semen (Plant)', 'Vol Penjualan Dom', 'Total'); //, 'Growth Real / Prognose');
        $this->template->display('DemandplTahunan_view', $data);
    }

    function getProd($org, $type, $date) {
        $cek = $this->db->query("SELECT * FROM ZREPORT_REAL_PROD_DEMANDPL WHERE ORG = '$org' AND KODE_PRODUK = '$type' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'")->num_rows();
        if ($cek > 0) {
            $data = $this->Demandpl_model->prodTerakSemenMax($org, $type, $date);
        } else {
//            $data = $this->Demandpl_model->prodTerakSemen($org, $type, $date);
            $data = array(
                "RKAP" => 0,
                "RKAP_SD" => 0,
                "REALISASI" => 0
            );
        }
        return $data;
    }

    function getProdTerakSemen($date) {
        //$cek = $this->db->query("SELECT * FROM ZREPORT_REAL_PROD_DEMANDPL WHERE TO_CHAR(TANGGAL,'YYYYMM') = '$date'")->num_rows();

        $terakSG = $this->getProd('7000', 1, $date);
        $terakSG2 = $this->getProd('5000', 1, $date);
        $terakSP = $this->getProd('3000', 1, $date);
        $terakST = $this->getProd('4000', 1, $date);
        $terakTLCC = $this->getProd('6000', 1, $date);
        $semenSG = $this->getProd('7000', 2, $date);
        $semenSG2 = $this->getProd('5000', 2, $date);
        $semenSP = $this->getProd('3000', 2, $date);
        $semenST = $this->getProd('4000', 2, $date);
        $semenTLCC = $this->getProd('6000', 2, $date);

        foreach ($terakSG as $key => $value) {
            if (isset($terakSG2[$key]))
                $terakSG[$key] += $terakSG2[$key];
        }
        foreach ($semenSG as $key => $value) {
            if (isset($semenSG2[$key]))
                $semenSG[$key] += $semenSG2[$key];
        }

        $terakSG['PERSEN'] = $this->getPersen($terakSG['REALISASI'], $terakSG['RKAP_SD']);
        //$terakSG['PROGNOSE_BULAN'] = $terakSG['REALISASI'] + $terakSG['PROGNOSE'];
        $terakSG['DEVIASI'] = ($terakSG['REALISASI'] - $terakSG['RKAP_SD']);
        $terakSP['PERSEN'] = $this->getPersen($terakSP['REALISASI'], $terakSP['RKAP_SD']);
        $terakSP['DEVIASI'] = ($terakSP['REALISASI'] - $terakSP['RKAP_SD']);
//        $terakSP['PROGNOSE_BULAN'] = $terakSP['REALISASI'] + $terakSP['PROGNOSE'];
        $terakST['PERSEN'] = $this->getPersen($terakST['REALISASI'], $terakST['RKAP_SD']);
        $terakST['DEVIASI'] = ($terakST['REALISASI'] - $terakST['RKAP_SD']);
//        $terakST['PROGNOSE_BULAN'] = $terakST['REALISASI'] + $terakST['PROGNOSE'];
        $terakTLCC['PERSEN'] = $this->getPersen($terakTLCC['REALISASI'], $terakTLCC['RKAP_SD']);
        $terakTLCC['DEVIASI'] = ($terakTLCC['REALISASI'] - $terakTLCC['RKAP_SD']);
//        $terakTLCC['PROGNOSE_BULAN'] = $terakTLCC['REALISASI'] + $terakTLCC['PROGNOSE'];
        $semenSG['PERSEN'] = $this->getPersen($semenSG['REALISASI'], $semenSG['RKAP_SD']);
        $semenSG['DEVIASI'] = ($semenSG['REALISASI'] - $semenSG['RKAP_SD']);
//        $semenSG['PROGNOSE_BULAN'] = $semenSG['REALISASI'] + $semenSG['PROGNOSE'];
        $semenSP['PERSEN'] = $this->getPersen($semenSP['REALISASI'], $semenSP['RKAP_SD']);
        $semenSP['DEVIASI'] = ($semenSP['REALISASI'] - $semenSP['RKAP_SD']);
//        $semenSP['PROGNOSE_BULAN'] = $semenSP['REALISASI'] + $semenSP['PROGNOSE'];
        $semenST['PERSEN'] = $this->getPersen($semenST['REALISASI'], $semenST['RKAP_SD']);
        $semenST['DEVIASI'] = ($semenST['REALISASI'] - $semenST['RKAP_SD']);
//        $semenST['PROGNOSE_BULAN'] = $semenST['REALISASI'] + $semenST['PROGNOSE'];
        $semenTLCC['PERSEN'] = $this->getPersen($semenTLCC['REALISASI'], $semenTLCC['RKAP_SD']);
        $semenTLCC['DEVIASI'] = ($semenTLCC['REALISASI'] - $semenTLCC['RKAP_SD']);
//        $semenTLCC['PROGNOSE_BULAN'] = $semenTLCC['REALISASI'] + $semenTLCC['PROGNOSE'];
        $terakSMIG = array();
        $semenSMIG = array();
        $terakSMIG['RKAP_SD'] = $terakSG['RKAP_SD'] + $terakSP['RKAP_SD'] + $terakST['RKAP_SD']; // + $terakTLCC['RKAP'];
//        $terakSMIG['PROGNOSE'] = $terakSG['PROGNOSE'] + $terakSP['PROGNOSE'] + $terakST['PROGNOSE']; // + $terakTLCC['PROGNOSE'];
        $terakSMIG['REALISASI'] = $terakSG['REALISASI'] + $terakSP['REALISASI'] + $terakST['REALISASI']; // + $terakTLCC['REALISASI'];
        $terakSMIG['PERSEN'] = $this->getPersen($terakSMIG['REALISASI'], $terakSMIG['RKAP_SD']);
        $terakSMIG['DEVIASI'] = ($terakSMIG['REALISASI'] - $terakSMIG['RKAP_SD']);
//        $terakSMIG['PROGNOSE_BULAN'] = round($terakSG['PROGNOSE_BULAN'] + $terakSP['PROGNOSE_BULAN'] + $terakST['PROGNOSE_BULAN']); // + $terakTLCC['PROGNOSE_BULAN']);
        $semenSMIG['RKAP_SD'] = $semenSG['RKAP_SD'] + $semenSP['RKAP_SD'] + $semenST['RKAP_SD']; // + $semenTLCC['RKAP'];
//        $semenSMIG['PROGNOSE'] = $semenSG['PROGNOSE'] + $semenSP['PROGNOSE'] + $semenST['PROGNOSE']; // + $semenTLCC['PROGNOSE'];
        $semenSMIG['REALISASI'] = $semenSG['REALISASI'] + $semenSP['REALISASI'] + $semenST['REALISASI']; // + $semenTLCC['REALISASI'];
        $semenSMIG['PERSEN'] = $this->getPersen($semenSMIG['REALISASI'], $semenSMIG['RKAP_SD']);
        $semenSMIG['DEVIASI'] = ($semenSMIG['REALISASI'] - $semenSMIG['RKAP_SD']);
//        $semenSMIG['PROGNOSE_BULAN'] = round($semenSG['PROGNOSE_BULAN'] + $semenSP['PROGNOSE_BULAN'] + $semenST['PROGNOSE_BULAN']); // + $semenTLCC['PROGNOSE_BULAN']);
        $arr = array(
            "terakSMIG" => $terakSMIG,
            "terakSG" => $terakSG,
            "terakSP" => $terakSP,
            "terakST" => $terakST,
            "terakTLCC" => $terakTLCC,
            "semenSMIG" => $semenSMIG,
            "semenSG" => $semenSG,
            "semenSP" => $semenSP,
            "semenST" => $semenST,
            "semenTLCC" => $semenTLCC
        );
        echo json_encode($arr);
//        echo '<pre>';
//        print_r($arr);
//        echo '</pre>';
    }

    function getProdTerak($date) {
        $data = $this->Demandpl_model->prodTerak($date);
        $arr = array();
        $progSMIG = 0;
        $rkapSMIG = 0;
        foreach ($data as $row) {
            $arr[$row['ORG']]['PROGNOSE'] = $row['PROGNOSE'];
            $arr[$row['ORG']]['RKAP'] = $row['RKAP'];
            $arr[$row['ORG']]['PERSEN'] = ($row['PROGNOSE'] / $row['RKAP']) * 100;
            $arr[$row['ORG']]['DEVIASI'] = ($row['PROGNOSE'] - $row['RKAP']);
            $progSMIG += $row['PROGNOSE'];
            $rkapSMIG += $row['RKAP'];
        }
        $arr['1']['PROGNOSE'] = $progSMIG;
        $arr['1']['RKAP'] = $rkapSMIG;
        $arr['1']['PERSEN'] = ($progSMIG / $rkapSMIG) * 100;
        $arr['1']['DEVIASI'] = ($progSMIG - $rkapSMIG);
        echo json_encode($arr);
    }

    function getProdSemen($date) {
        $data = $this->Demandpl_model->prodSemen($date);
        $arr = array();
        $progSMIG = 0;
        $rkapSMIG = 0;
        foreach ($data as $row) {
            $arr[$row['ORG']]['PROGNOSE'] = $row['PROGNOSE'];
            $arr[$row['ORG']]['RKAP'] = $row['RKAP'];
            $arr[$row['ORG']]['PERSEN'] = ($row['PROGNOSE'] / $row['RKAP']) * 100;
            $arr[$row['ORG']]['DEVIASI'] = ($row['PROGNOSE'] - $row['RKAP']);
            $progSMIG += $row['PROGNOSE'];
            $rkapSMIG += $row['RKAP'];
        }
        $arr['1']['PROGNOSE'] = $progSMIG;
        $arr['1']['RKAP'] = $rkapSMIG;
        $arr['1']['PERSEN'] = ($progSMIG / $rkapSMIG) * 100;
        $arr['1']['DEVIASI'] = ($progSMIG - $rkapSMIG);
        echo json_encode($arr);
    }

    function getStokTerak($date) {
        $data = $this->Demandpl_model->stokTerak($date);
        $arr = array();
        $progSMIG = 0;
        $rkapSMIG = 0;
        foreach ($data as $row) {
            $arr[$row['ORG']]['PROGNOSE'] = $row['PROGNOSE'];
            $arr[$row['ORG']]['MAX_STOK'] = $row['MAX_STOK'];
            $arr[$row['ORG']]['PERSEN'] = ($row['PROGNOSE'] / $row['MAX_STOK']) * 100;
            $arr[$row['ORG']]['DEVIASI'] = ($row['PROGNOSE'] - $row['MAX_STOK']);
            $progSMIG += $row['PROGNOSE'];
            $rkapSMIG += $row['MAX_STOK'];
        }
        $arr['1']['PROGNOSE'] = $progSMIG;
        $arr['1']['MAX_STOK'] = $rkapSMIG;
        $arr['1']['PERSEN'] = ($progSMIG / $rkapSMIG) * 100;
        $arr['1']['DEVIASI'] = ($progSMIG - $rkapSMIG);
        echo json_encode($arr);
    }

    function getStokSemen($date) {
        $data = $this->Demandpl_model->stokSemen($date);
        $arr = array();
        $progSMIG = 0;
        $rkapSMIG = 0;
        foreach ($data as $row) {
            $arr[$row['ORG']]['PROGNOSE'] = $row['PROGNOSE'];
            $arr[$row['ORG']]['MAX_STOK'] = $row['MAX_STOK'];
            $arr[$row['ORG']]['PERSEN'] = ($row['PROGNOSE'] / $row['MAX_STOK']) * 100;
            $arr[$row['ORG']]['DEVIASI'] = ($row['PROGNOSE'] - $row['MAX_STOK']);
            $progSMIG += $row['PROGNOSE'];
            $rkapSMIG += $row['MAX_STOK'];
        }
        $arr['1']['PROGNOSE'] = $progSMIG;
        $arr['1']['MAX_STOK'] = $rkapSMIG;
        $arr['1']['PERSEN'] = ($progSMIG / $rkapSMIG) * 100;
        $arr['1']['DEVIASI'] = ($progSMIG - $rkapSMIG);
        echo json_encode($arr);
    }

    function getStokTerakSemenMax($date) {
        //GET TERAK
        $terakSG = $this->Demandpl_model->inisialStokTerakSemen('7000', 1);
        $terakSG2 = $this->Demandpl_model->inisialStokTerakSemen('5000', 1);
        $terakSP = $this->Demandpl_model->inisialStokTerakSemen('3000', 1);
        $terakST = $this->Demandpl_model->inisialStokTerakSemen('4000', 1);
        $terakTLCC = $this->Demandpl_model->inisialStokTerakSemen('6000', 1);


        //GET SEMEN
        $semenSG = $this->Demandpl_model->inisialStokTerakSemen('7000', 2);
        $semenSG2 = $this->Demandpl_model->inisialStokTerakSemen('5000', 2);
        $semenSP = $this->Demandpl_model->inisialStokTerakSemen('3000', 2);
        $semenST = $this->Demandpl_model->inisialStokTerakSemen('4000', 2);
        $semenTLCC = $this->Demandpl_model->inisialStokTerakSemen('6000', 2);

        //cek apakah realisasi terak sudah update untuk setiap opco
        $hari = date("d");
        $tanggal = $date . '' . $hari;
        $cek = $this->db->query("SELECT MAX(TANGGAL) tanggal FROM ZREPORT_REAL_STOK_DEMANDPL WHERE KODE_PRODUK = 1 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '7000'")->row_array();
        if (isset($cek['TANGGAL'])) {
            $terakSG = $this->Demandpl_model->stokTerakSemenMax($date, '7000', 1);
        }
        $cek = $this->db->query("SELECT MAX(TANGGAL) tanggal FROM ZREPORT_REAL_STOK_DEMANDPL WHERE KODE_PRODUK = 1 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '5000'")->row_array();
        if (isset($cek['TANGGAL'])) {
            $terakSG2 = $this->Demandpl_model->stokTerakSemenMax($date, '5000', 1);
        }
        $cek = $this->db->query("SELECT MAX(TANGGAL) tanggal FROM ZREPORT_REAL_STOK_DEMANDPL WHERE KODE_PRODUK = 1 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '3000'")->row_array();
        if (isset($cek['TANGGAL'])) {
            $terakSP = $this->Demandpl_model->stokTerakSemenMax($date, '3000', 1);
        }
        $cek = $this->db->query("SELECT MAX(TANGGAL) tanggal FROM ZREPORT_REAL_STOK_DEMANDPL WHERE KODE_PRODUK = 1 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '4000'")->row_array();
        if (isset($cek['TANGGAL'])) {
            $terakST = $this->Demandpl_model->stokTerakSemenMax($date, '4000', 1);
        }
        $cek = $this->db->query("SELECT MAX(TANGGAL) tanggal FROM ZREPORT_REAL_STOK_DEMANDPL WHERE KODE_PRODUK = 1 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '6000'")->row_array();
        if (isset($cek['TANGGAL'])) {
            $terakTLCC = $this->Demandpl_model->stokTerakSemenMax($date, '6000', 1);
        }

        //cek apakah realisasi semen sudah update untuk setiap opco
        $cek = $this->db->query("SELECT MAX(TANGGAL) tanggal FROM ZREPORT_REAL_STOK_DEMANDPL WHERE KODE_PRODUK = 2 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '7000'")->row_array();
        if (isset($cek['TANGGAL'])) {
            $semenSG = $this->Demandpl_model->stokTerakSemenMax($date, '7000', 2);
        }
        $cek = $this->db->query("SELECT MAX(TANGGAL) tanggal FROM ZREPORT_REAL_STOK_DEMANDPL WHERE KODE_PRODUK = 2 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '5000'")->row_array();
        if (isset($cek['TANGGAL'])) {
            $semenSG2 = $this->Demandpl_model->stokTerakSemenMax($date, '5000', 2);
        }
        $cek = $this->db->query("SELECT MAX(TANGGAL) tanggal FROM ZREPORT_REAL_STOK_DEMANDPL WHERE KODE_PRODUK = 2 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '3000'")->row_array();
        if (isset($cek['TANGGAL'])) {
            $semenSP = $this->Demandpl_model->stokTerakSemenMax($date, '3000', 2);
        }
        $cek = $this->db->query("SELECT MAX(TANGGAL) tanggal FROM ZREPORT_REAL_STOK_DEMANDPL WHERE KODE_PRODUK = 2 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '4000'")->row_array();
        if (isset($cek['TANGGAL'])) {
            $semenST = $this->Demandpl_model->stokTerakSemenMax($date, '4000', 2);
        }
        $cek = $this->db->query("SELECT MAX(TANGGAL) tanggal FROM ZREPORT_REAL_STOK_DEMANDPL WHERE KODE_PRODUK = 2 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '6000'")->row_array();
        if (isset($cek['TANGGAL'])) {
            $semenTLCC = $this->Demandpl_model->stokTerakSemenMax($date, '6000', 2);
        }

        //menyatukan SG
        foreach ($terakSG as $key => $value) {
            if (isset($terakSG2[$key])) {
                $terakSG[$key] += $terakSG2[$key];
                $terakSG[$key] = $terakSG[$key] . '';
            }
        }
        foreach ($semenSG as $key => $value) {
            if (isset($semenSG2[$key])) {
                $semenSG[$key] += $semenSG2[$key];
                $semenSG[$key] = $semenSG[$key] . '';
            }
        }


        $terakSG['PERSEN'] = ($terakSG['REALISASI'] / $terakSG['MAX_STOK']) * 100;
        $terakSP['PERSEN'] = ($terakSP['REALISASI'] / $terakSP['MAX_STOK']) * 100;
        $terakST['PERSEN'] = ($terakST['REALISASI'] / $terakST['MAX_STOK']) * 100;
        $terakTLCC['PERSEN'] = ($terakTLCC['REALISASI'] / $terakTLCC['MAX_STOK']) * 100;
        $terakSMIG['REALISASI'] = $terakSG['REALISASI'] + $terakSP['REALISASI'] + $terakST['REALISASI']; // + $terakTLCC['REALISASI'];
        $terakSMIG['MAX_STOK'] = $terakSG['MAX_STOK'] + $terakSP['MAX_STOK'] + $terakST['MAX_STOK']; // + $terakTLCC['MAX_STOK'];
        $terakSMIG['PERSEN'] = ($terakSMIG['REALISASI'] / $terakSMIG['MAX_STOK']) * 100;

        $semenSG['PERSEN'] = ($semenSG['REALISASI'] / $semenSG['MAX_STOK']) * 100;
        $semenSP['PERSEN'] = ($semenSP['REALISASI'] / $semenSP['MAX_STOK']) * 100;
        $semenST['PERSEN'] = ($semenST['REALISASI'] / $semenST['MAX_STOK']) * 100;
        $semenTLCC['PERSEN'] = ($semenTLCC['REALISASI'] / $semenTLCC['MAX_STOK']) * 100;
        $semenSMIG['REALISASI'] = $semenSG['REALISASI'] + $semenSP['REALISASI'] + $semenST['REALISASI']; // + $semenTLCC['REALISASI'];
        $semenSMIG['MAX_STOK'] = $semenSG['MAX_STOK'] + $semenSP['MAX_STOK'] + $semenST['MAX_STOK']; // + $semenTLCC['MAX_STOK'];
        $semenSMIG['PERSEN'] = ($semenSMIG['REALISASI'] / $semenSMIG['MAX_STOK']) * 100;


        $arr = array(
            "terakSMIG" => $terakSMIG,
            "terakSG" => $terakSG,
            "terakSP" => $terakSP,
            "terakST" => $terakST,
            "terakTLCC" => $terakTLCC,
            "semenSMIG" => $semenSMIG,
            "semenSG" => $semenSG,
            "semenSP" => $semenSP,
            "semenST" => $semenST,
            "semenTLCC" => $semenTLCC
        );
        echo json_encode($arr);
    }

    function getStokTerakSemen($date) {
        if ($date != date('Ym')) {
            $tahun = substr($date, 0, 4);
            $bulan = substr($date, 4, 5);
            $hari = 0;
            if ($bulan == date("m")) {
                $hari = date("d");
            } else {
                $hari = date('t', strtotime($tahun . "-" . $bulan));
            }
            $date = $date . '' . $hari;
        }
        $terakSG = $this->Demandpl_model->stokTerakSemen($date, '7000', 1);
        if ($terakSG['REALISASI'] == 0) {
            $terakSG['REALISASI'] = $terakSG['PROGNOSE'];
        }
        $terakSG['PERSEN'] = ($terakSG['REALISASI'] / $terakSG['MAX_STOK']) * 100;
        $terakSP = $this->Demandpl_model->stokTerakSemen($date, '3000', 1);
        if ($terakSP['REALISASI'] == 0) {
            $terakSP['REALISASI'] = $terakSP['PROGNOSE'];
        }
        $terakSP['PERSEN'] = ($terakSP['REALISASI'] / $terakSP['MAX_STOK']) * 100;
        $terakST = $this->Demandpl_model->stokTerakSemen($date, '4000', 1);
        if ($terakST['REALISASI'] == 0) {
            $terakST['REALISASI'] = $terakST['PROGNOSE'];
        }
        $terakST['PERSEN'] = ($terakST['REALISASI'] / $terakST['MAX_STOK']) * 100;
        $terakTLCC = $this->Demandpl_model->stokTerakSemen($date, '6000', 1);
        if ($terakTLCC['REALISASI'] == 0) {
            $terakTLCC['REALISASI'] = $terakTLCC['PROGNOSE'];
        }
        $terakTLCC['PERSEN'] = ($terakTLCC['REALISASI'] / $terakTLCC['MAX_STOK']) * 100;
        $terakSMIG['REALISASI'] = $terakSG['REALISASI'] + $terakSP['REALISASI'] + $terakST['REALISASI']; // + $terakTLCC['REALISASI'];
        $terakSMIG['MAX_STOK'] = $terakSG['MAX_STOK'] + $terakSP['MAX_STOK'] + $terakST['MAX_STOK']; // + $terakTLCC['MAX_STOK'];
        $terakSMIG['PERSEN'] = ($terakSMIG['REALISASI'] / $terakSMIG['MAX_STOK']) * 100;
        $semenSG = $this->Demandpl_model->stokTerakSemen($date, '7000', 2);
        if ($semenSG['REALISASI'] == 0) {
            $semenSG['REALISASI'] = $semenSG['PROGNOSE'];
        }
        $semenSG['PERSEN'] = ($semenSG['REALISASI'] / $semenSG['MAX_STOK']) * 100;
        $semenSP = $this->Demandpl_model->stokTerakSemen($date, '3000', 2);
        if ($semenSP['REALISASI'] == 0) {
            $semenSP['REALISASI'] = $semenSP['PROGNOSE'];
        }
        $semenSP['PERSEN'] = ($semenSP['REALISASI'] / $semenSP['MAX_STOK']) * 100;
        $semenST = $this->Demandpl_model->stokTerakSemen($date, '4000', 2);
        if ($semenST['REALISASI'] == 0) {
            $semenST['REALISASI'] = $semenST['PROGNOSE'];
        }
        $semenST['PERSEN'] = ($semenST['REALISASI'] / $semenST['MAX_STOK']) * 100;
        $semenTLCC = $this->Demandpl_model->stokTerakSemen($date, '6000', 2);
        if ($semenTLCC['REALISASI'] == 0) {
            $semenTLCC['REALISASI'] = $semenTLCC['PROGNOSE'];
        }
        $semenTLCC['PERSEN'] = ($semenTLCC['REALISASI'] / $semenTLCC['MAX_STOK']) * 100;
        $semenSMIG['REALISASI'] = $semenSG['REALISASI'] + $semenSP['REALISASI'] + $semenST['REALISASI']; // + $semenTLCC['REALISASI'];
        $semenSMIG['MAX_STOK'] = $semenSG['MAX_STOK'] + $semenSP['MAX_STOK'] + $semenST['MAX_STOK']; // + $semenTLCC['MAX_STOK'];
        $semenSMIG['PERSEN'] = ($semenSMIG['REALISASI'] / $semenSMIG['MAX_STOK']) * 100;
        $arr = array(
            "terakSMIG" => $terakSMIG,
            "terakSG" => $terakSG,
            "terakSP" => $terakSP,
            "terakST" => $terakST,
            "terakTLCC" => $terakTLCC,
            "semenSMIG" => $semenSMIG,
            "semenSG" => $semenSG,
            "semenSP" => $semenSP,
            "semenST" => $semenST,
            "semenTLCC" => $semenTLCC
        );
        echo json_encode($arr);
    }

    function getSalesOpco($org, $date, $mv) {
        set_time_limit(0);
        if ($org == '6000') {
            $data = $this->Demandpl_model->sumSales6000($org, $date, $mv);
            //$ekspor = $this->Demandpl_model->sumEksporTLCC($date);
        }
//        else if ($org == '4000') {
//
//            $data = $this->Demandpl_model->sumSalesTonasa($org, $date, $mv);
//        } 
        else {
            $data = $this->Demandpl_model->sumSalesOpco($org, $date, $mv);
        }
        $data['REAL_SDK'] = round($data['REAL_SDK']);
        $data['RKAP_SDK'] = round($data['RKAP_SDK']);

        $data['REAL_SDH'] = $data['REAL_TAHUN_INI'];

        $data['PERSEN'] = round($this->getPersen($data['REAL_SDK'], $data['RKAP_SDK']));

        $data['DEVIASI'] = $data['REAL_SDK'] - $data['RKAP_SDK'];


        $data['PERSEN_EKSPOR'] = round($this->getPersen($data['REAL_EKSPOR_TAHUNINI'], $data['RKAP_EKSPOR']));
        $data['PERSEN_ICS'] = round($this->getPersen($data['REAL_ICS'], $data['RKAP_ICS']));
        $data['PERSEN_TOTAL'] = round($this->getPersen($data['REAL_SDK'] + $data['REAL_EKSPOR_TAHUNINI'], $data['RKAP_EKSPOR'] + $data['RKAP_SDK']));
        ############## MENGHITUNG GROWTH ####################

        $data['GROWTH_DOM_REAL'] = round($this->getPersen(($data['REAL_SDH'] - $data['REAL_SDH_TAHUNLALU']), $data['REAL_SDH_TAHUNLALU']), 1);

        $data['GROWTH_DOM_PROG'] = round($this->getPersen((($data['REAL_SDH'] + $data['PROGNOSE']) - $data['REAL_TAHUNLALU']), $data['REAL_TAHUNLALU']), 1);

        $data['GROWTH_EKSPOR'] = round($this->getPersen(($data['REAL_EKSPOR_TAHUNINI'] - $data['REAL_EKSPOR_TAHUNLALU']), $data['REAL_EKSPOR_TAHUNLALU']), 1);

        $data['GROWTH_TOTAL'] = round($this->getPersen((($data['REAL_EKSPOR_TAHUNINI'] + $data['REAL_SDH']) - ($data['REAL_EKSPOR_TAHUNLALU'] + $data['REAL_TAHUNLALU'])), ($data['REAL_EKSPOR_TAHUNLALU'] + $data['REAL_TAHUNLALU'])), 1);

        ######################################################



        echo json_encode($data);
    }

    function getSalesSMI($date, $mv) {
        $dataSG = $this->Demandpl_model->sumSalesOpco('7000', $date, $mv);

        $dataSP = $this->Demandpl_model->sumSalesOpco('3000', $date, $mv);

//        $dataST = $this->Demandpl_model->sumSalesTonasa('4000', $date, $mv);
        $dataST = $this->Demandpl_model->sumSalesOpco('4000', $date, $mv);

        $dataTLCC = $this->Demandpl_model->sumSales6000('6000', $date, $mv);
//        $eksporSG = $this->Demandpl_model->sumEksporSG($date);
//        $eksporSP = $this->Demandpl_model->sumEksporSP($date);
//        $eksporST = $this->Demandpl_model->sumEksporST($date);

        $dataSMI = $dataSG;
        foreach ($dataSP as $key => $value) {
            $dataSMI[$key] += round($value);
        }
        foreach ($dataST as $key => $value) {
            $dataSMI[$key] += round($value);
        }
        $dataSMI['REAL_SDH'] = $dataSMI['REAL_TAHUN_INI'];


        $dataSMI['PERSEN'] = round($this->getPersen($dataSMI['REAL_SDK'], $dataSMI['RKAP_SDK']));


        $dataSMI['DEVIASI'] = $dataSMI['REAL_SDK'] - $dataSMI['RKAP_SDK'];


        $dataSMI['PERSEN_EKSPOR'] = round($this->getPersen($dataSMI['REAL_EKSPOR_TAHUNINI'], $dataSMI['RKAP_EKSPOR']));

        $dataSMI['PERSEN_TOTAL'] = round($this->getPersen($dataSMI['REAL_SDK'] + $dataSMI['REAL_EKSPOR_TAHUNINI'], $dataSMI['RKAP_EKSPOR'] + $dataSMI['RKAP_SDK']));

        /////////////////////////////////////////////////////
        //DATA SMI + TLCC//
        foreach ($dataTLCC as $key => $value) {
            $dataSMI['SMITLCC_' . $key] = $dataSMI[$key] + $value;
        }
        $dataSMI['SMITLCC_DEVIASI'] = $dataSMI['SMITLCC_REAL_SDK'] - $dataSMI['SMITLCC_RKAP_SDK'];
        $dataSMI['SMITLCC_PERSEN'] = round($this->getPersen($dataSMI['SMITLCC_REAL_SDK'], $dataSMI['SMITLCC_RKAP_SDK']));
        $dataSMI['SMITLCC_PERSEN_EKSPOR'] = round($this->getPersen($dataSMI['SMITLCC_REAL_EKSPOR_TAHUNINI'], $dataSMI['SMITLCC_RKAP_EKSPOR']));
        $dataSMI['SMITLCC_PERSEN_TOTAL'] = round($this->getPersen($dataSMI['SMITLCC_REAL_SDK'] + $dataSMI['SMITLCC_REAL_EKSPOR_TAHUNINI'], $dataSMI['SMITLCC_RKAP_EKSPOR'] + $dataSMI['SMITLCC_RKAP_SDK']));

        ############## MENGHITUNG GROWTH ####################
        ############## MENGHITUNG GROWTH ####################

        $dataSMI['GROWTH_DOM_REAL'] = round($this->getPersen(($dataSMI['REAL_SDH'] - $dataSMI['REAL_SDH_TAHUNLALU']), $dataSMI['REAL_SDH_TAHUNLALU']), 1);

        $dataSMI['GROWTH_DOM_PROG'] = round($this->getPersen((($dataSMI['REAL_SDH'] + $dataSMI['PROGNOSE']) - $dataSMI['REAL_TAHUNLALU']), $dataSMI['REAL_TAHUNLALU']), 1);

        $dataSMI['GROWTH_EKSPOR'] = round($this->getPersen(($dataSMI['REAL_EKSPOR_TAHUNINI'] - $dataSMI['REAL_EKSPOR_TAHUNLALU']), $dataSMI['REAL_EKSPOR_TAHUNLALU']), 1);

        $dataSMI['GROWTH_TOTAL'] = round($this->getPersen((($dataSMI['REAL_EKSPOR_TAHUNINI'] + $dataSMI['REAL_SDH']) - ($dataSMI['REAL_EKSPOR_TAHUNLALU'] + $dataSMI['REAL_TAHUNLALU'])), ($dataSMI['REAL_EKSPOR_TAHUNLALU'] + $dataSMI['REAL_TAHUNLALU'])), 1);

        ######################################################
        #
        $dataSMI['LAST_REFRESH'] = $this->Demandpl_model->get_lastrefresh_mv();
        ######################################################
        echo json_encode($dataSMI);
//        echo '<pre>';
//        print_r($dataSMI);
//        echo '</pre>';
    }

    function getChart($tanggal, $type, $org, $mv) {
        if ($type == 'vol') {
            $tahun = substr($tanggal, 0, 4);
            $bulan = substr($tanggal, 4, 5);
//            $hari = 0;
            if ($tanggal == date("Ym")) {
                $hari = date("d");
                $haritmpl = $hari;
            } else {
                $hari = date('t', strtotime($tahun . "-" . $bulan)) + 1;
                $haritmpl = date('t', strtotime($tahun . "-" . $bulan));
            }
            $data['tanggal'] = ($haritmpl) . '-' . $bulan . '-' . $tahun;
            $data['akumulasi']['REAL'] = array();
            $data['akumulasi']['TARGET'] = array();
            $data['data']['TANGGAL'] = array();
            $data['data']['TARGET'] = array();
            $data['data']['REAL'] = array();
            $data['data']['PROG'] = array();
            $data['data']['WARNA'] = array();
            $data['data']['RADIUS'] = array();
            $data['prog'] = 0;
            $data['rkap'] = 0;
            $data['persen'] = 0;
            $real = 0;
            $target = 0;
            $sumReal = 0;
            $sumProg = 0;
            if ($org == 0) {
                $sales = $this->Demandpl_model->getSalesChartSMIG($tanggal, $mv);
                //var_dump($sales);
                //PTL = Pencapaian Tahun Lalu
                $pencTahunLaluSG = $this->Demandpl_model->getPencTahunLalu('7000', $tanggal, $mv);
                $pencTahunLaluSP = $this->Demandpl_model->getPencTahunLalu('3000', $tanggal, $mv);
                $pencTahunLaluST = $this->Demandpl_model->getPencTahunLalu('4000', $tanggal, $mv);

                $ptl = $pencTahunLaluSG;
                foreach ($pencTahunLaluSP as $key => $value) {
                    if (isset($ptl[$key])) {
                        $ptl[$key] += $value;
                    } else {
                        $ptl[$key] = $value;
                    }
                }

                foreach ($pencTahunLaluST as $key => $value) {
                    if (isset($ptl[$key])) {
                        $ptl[$key] += $value;
                    } else {
                        $ptl[$key] = $value;
                    }
                }

                $ptl['PENCAPAIAN'] = round($ptl['REAL'] / $ptl['TARGET'] * 100);
            } else if ($org == 10000) {
                //PTL = Pencapaian Tahun Lalu
                $pencTahunLaluSG = $this->Demandpl_model->getPencTahunLalu('7000', $tanggal, $mv);
                $pencTahunLaluSP = $this->Demandpl_model->getPencTahunLalu('3000', $tanggal, $mv);
                $pencTahunLaluST = $this->Demandpl_model->getPencTahunLalu('4000', $tanggal, $mv);
                $pencTahunLaluTLCC = $this->Demandpl_model->getPencTahunLalu('6000', $tanggal, $mv);

                $ptl = $pencTahunLaluSG;
                foreach ($pencTahunLaluSP as $key => $value) {
                    if (isset($ptl[$key])) {
                        $ptl[$key] += $value;
                    } else {
                        $ptl[$key] = $value;
                    }
                }

                foreach ($pencTahunLaluST as $key => $value) {
                    if (isset($ptl[$key])) {
                        $ptl[$key] += $value;
                    } else {
                        $ptl[$key] = $value;
                    }
                }

                foreach ($pencTahunLaluTLCC as $key => $value) {
                    if (isset($ptl[$key])) {
                        $ptl[$key] += $value;
                    } else {
                        $ptl[$key] = $value;
                    }
                }
                $ptl['PENCAPAIAN'] = round($ptl['REAL'] / $ptl['TARGET'] * 100);
                $sales = $this->Demandpl_model->getSalesChartSMIGTLCC($tanggal, $mv);
            } else if ($org == 6000) {
                $ptl = $this->Demandpl_model->getPencTahunLalu($org, $tanggal, $mv);
                $sales = $this->Demandpl_model->getSalesChartTLCC($org, $tanggal, $mv);
            } else if ($org == 4000) {
                $ptl = $this->Demandpl_model->getPencTahunLalu($org, $tanggal, $mv);
                $sales = $this->Demandpl_model->getSalesChart($org, $tanggal, $mv);
              //  $sales = $this->Demandpl_model->getSalesChartST($org, $tanggal, $mv);
            } else if ($org == 7000) {
                $ptl = $this->Demandpl_model->getPencTahunLalu($org, $tanggal, $mv);
                $data['data']['REAL5000'] = array();
                $data['data']['REALTOTAL'] = array();
                $data['akumulasi']['REAL5000'] = array();
                $data['akumulasi']['REAL7000'] = array();
                $real5000 = 0;
                $real7000 = 0;
                $sales = $this->Demandpl_model->getSalesChart($org, $tanggal, $mv);

                $sales5000 = $this->Demandpl_model->getSalesChart('5000', $tanggal, $mv);
                foreach ($sales5000 as $key => $value) {
                    array_push($data['data']['REAL5000'], round($value['REAL']));
                    $sales[$key]['TARGET'] += $value['TARGET'];
                    $sales[$key]['PROG'] += $value['PROG'];
                }
            } else {
                $ptl = $this->Demandpl_model->getPencTahunLalu($org, $tanggal, $mv);
                $sales = $this->Demandpl_model->getSalesChart($org, $tanggal, $mv);
            }
            $i = 0;

            $totalreal = 0;


            foreach ($sales as $value) {
                if (strlen($value['TANGGAL']) > 2) {
                    $cektanggal = substr($value['TANGGAL'], 6, 7);
                } else {
                    $cektanggal = $value['TANGGAL'];
                }
                if ($tanggal == date('Ym')) {
                    if ($cektanggal < $hari) {
                        if ($org == '7000') {
                            $data['prog'] += $data['data']['REAL5000'][$i];
                            $real += $data['data']['REAL5000'][$i];
                            array_push($data['data']['REALTOTAL'], round($value['REAL'] + $data['data']['REAL5000'][$i]));
                            $real5000 += $data['data']['REAL5000'][$i++];
                            $real7000 += $value['REAL'];
                        }
                        $real += $value['REAL'];
                        $totalreal = $real;
                        $data['prog'] += $value['REAL'];
                    } else {
                        if ($org == '7000') {
                            if ($cektanggal == $hari)
                                array_push($data['data']['REALTOTAL'], round($value['REAL'] + $data['data']['REAL5000'][$i]));
                            else
                                array_push($data['data']['REALTOTAL'], 0);
                        }
                        $real += $value['PROG'];
                        $data['prog'] += $value['PROG'];
                    }
                } else {
                    if ($org == '7000') {
                        array_push($data['data']['REALTOTAL'], round($value['REAL'] + $data['data']['REAL5000'][$i]));
                        $data['prog'] += $data['data']['REAL5000'][$i];
                        $real += $data['data']['REAL5000'][$i];
                        $real5000 += $data['data']['REAL5000'][$i++];
                        $real7000 += $value['REAL'];
                    }
                    $real += $value['REAL'];
                    $totalreal = $real;
                    $data['prog'] += $value['REAL'];
                }

                $target += $value['TARGET'];
                array_push($data['data']['TANGGAL'], $cektanggal);
                array_push($data['data']['TARGET'], round($value['TARGET']));
                if ($cektanggal <= $hari) {
                    array_push($data['data']['REAL'], round($value['REAL']));
                    if ($cektanggal == $hari) {
                        array_push($data['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                        array_push($data['data']['PROG'], round($value['PROG']));
                    } else {
                        array_push($data['data']['WARNA'], 'rgba(255, 165, 0, 1)');
                        array_push($data['data']['PROG'], 0);
                    }


                    $sumReal += round($value['REAL']);
                    $sumProg += round($value['PROG']);
                } else {
                    array_push($data['data']['REAL'], 0);
                    array_push($data['data']['PROG'], round($value['PROG']));
                    array_push($data['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                }
                if ($org == '7000') {
                    if ($cektanggal <= $hari) {
                        array_push($data['akumulasi']['REAL5000'], $real5000);
                        array_push($data['akumulasi']['REAL7000'], $real7000);
                    }
                }
                array_push($data['akumulasi']['REAL'], $real);
                array_push($data['akumulasi']['TARGET'], $target);
            }
            if ($sumProg == 0) {
                $akurasi = 0;
            } else {
                $akurasi = $sumReal / $sumProg * 100;
            }
            $data['akurasi'] = round($akurasi);
            if ($org == 4000) {
                $tgl_adj = $this->Demandpl_model->lastUpdateAdj($tanggal);
                $data['tgl_adj'] = $tgl_adj['TANGGAL_ADJ'] . '-' . $bulan . '-' . $tahun;
            }
            $data['rkap'] = $target;
            if ($data['rkap'] != 0) {
                $data['persen'] = round(($data['prog'] / $data['rkap'] * 100), 1);
            } else {
                $data['persen'] = 0;
            }


            $data['ave'] = round($totalreal / ($hari - 1));
            $ptl['PENCAPAIAN'] = $ptl['REAL'] != 0 ? round($data['prog'] / $ptl['REAL'] * 100) : '0';
            $data['prog'] = number_format($data['prog'], 0, '', '.');
            $data['rkap'] = number_format($data['rkap'], 0, '', '.');

            $data['ptl'] = $ptl;
        } else if ($type == 'terak') {
            $data['data']['TANGGAL'] = array();
            $data['data']['TARGET'] = array();
            $data['data']['REAL'] = array();
            $data['data']['PROG'] = array();
            $data['data']['WARNA'] = array();
            $data['data']['RADIUS'] = array();
            $data['data']['TARGET_KUM'] = array();
            $data['data']['REAL_KUM'] = array();
            $data['stok']['PROG'] = array();
            $data['stok']['MAX'] = array();
            $data['stok']['MIN'] = array();
            $data['stok']['TIGAPULUHPERSEN'] = array();
            if ($org == 0) {
                $sumReal = 0;
                $sumProg = 0;
                $kumReal = 0;
                $kumTarget = 0;
                $keyAkhir = 0;
                $sg = $this->Demandpl_model->grafProdStokTerak2(7000, $tanggal);

                $sg2 = $this->Demandpl_model->grafProdStokTerak2(5000, $tanggal);
                // echo $this->db->last_query();
                $sp = $this->Demandpl_model->grafProdStokTerak2(3000, $tanggal);
                //echo $this->db->last_query();
                $st = $this->Demandpl_model->grafProdStokTerak2(4000, $tanggal);
                //echo $this->db->last_query();
                //$tlcc = $this->Demandpl_model->grafProdStokTerak2(6000, $tanggal);
                $data['tanggal'] = $sg[0]['CREATE_DATE'];
                foreach ($sg as $value) {
                    array_push($data['data']['TANGGAL'], $value['TANGGAL']);
                    array_push($data['data']['TARGET'], round($value['RKAP_PRODUK']));
                    array_push($data['stok']['MAX'], round($value['MAX_STOK']));
                    $kumTarget += round($value['RKAP_PRODUK']);
                    array_push($data['data']['TARGET_KUM'], $kumTarget);
                    //array_push($data['stok']['MIN'], round($value['MIN_STOK']));
                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        array_push($data['data']['REAL'], round($value['REALISASI_PROD']));
                        array_push($data['data']['PROG'], 0);
                        array_push($data['stok']['PROG'], round($value['REALISASI_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(255, 165, 0, 1)');
                        $kumReal += $value['REALISASI_PROD'];
                        array_push($data['data']['REAL_KUM'], $kumReal);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                    } else {
                        array_push($data['data']['REAL'], 0);
                        array_push($data['data']['PROG'], round($value['PROG_PRODUK']));
                        array_push($data['stok']['PROG'], round($value['PROG_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                        $kumReal += $value['PROG_PRODUK'];
                        array_push($data['data']['REAL_KUM'], $kumReal);
                    }
                }

                $kumRealSG2 = 0;
                $kumTargetSG2 = 0;
                foreach ($sg2 as $key => $value) {
                    $data['data']['TARGET'][$key] += round($value['RKAP_PRODUK']);
                    $kumTargetSG2 += round($value['RKAP_PRODUK']);
                    $data['data']['TARGET_KUM'][$key] += $kumTargetSG2;
                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        $data['data']['REAL'][$key] += round($value['REALISASI_PROD']);
                        $data['stok']['PROG'][$key] += round($value['REALISASI_STOK']);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                        $kumRealSG2 += $value['REALISASI_PROD'];
                        $data['data']['REAL_KUM'][$key] += $kumRealSG2;
                    } else {
                        $data['stok']['PROG'][$key] += round($value['PROG_STOK']);
                        $data['data']['PROG'][$key] += round($value['PROG_PRODUK']);
                        $kumRealSG2 += $value['PROG_PRODUK'];
                        $data['data']['REAL_KUM'][$key] += $kumRealSG2;
                    }
                    $data['stok']['MAX'][$key] += round($value['MAX_STOK']);
                    //$data['stok']['MIN'][$key] += round($value['MIN_STOK']);
                }

                $kumRealSP = 0;
                $kumTargetSP = 0;
                foreach ($sp as $key => $value) {
                    $data['data']['TARGET'][$key] += round($value['RKAP_PRODUK']);
                    $kumTargetSP += round($value['RKAP_PRODUK']);
                    $data['data']['TARGET_KUM'][$key] += $kumTargetSP;
                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        $data['data']['REAL'][$key] += round($value['REALISASI_PROD']);
                        $data['stok']['PROG'][$key] += round($value['REALISASI_STOK']);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                        $kumRealSP += $value['REALISASI_PROD'];
                        $data['data']['REAL_KUM'][$key] += $kumRealSP;
                    } else {
                        $data['stok']['PROG'][$key] += round($value['PROG_STOK']);
                        $data['data']['PROG'][$key] += round($value['PROG_PRODUK']);
                        $kumRealSP += $value['PROG_PRODUK'];
                        $data['data']['REAL_KUM'][$key] += $kumRealSP;
                    }
                    $data['stok']['MAX'][$key] += round($value['MAX_STOK']);
                    //$data['stok']['MIN'][$key] += round($value['MIN_STOK']);
                }
                //var_dump($data);
                $kumRealST = 0;
                $kumTargetST = 0;
                foreach ($st as $key => $value) {
                    $data['data']['TARGET'][$key] += round($value['RKAP_PRODUK']);
                    $kumTargetST += $value['RKAP_PRODUK'];
                    $data['data']['TARGET_KUM'][$key] += $kumTargetST;
                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        $data['data']['REAL'][$key] += round($value['REALISASI_PROD']);
                        $data['stok']['PROG'][$key] += round($value['REALISASI_STOK']);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                        $kumRealST += $value['REALISASI_PROD'];
                        $data['data']['REAL_KUM'][$key] += $kumRealST;
                    } else {
                        $data['stok']['PROG'][$key] += round($value['PROG_STOK']);
                        $data['data']['PROG'][$key] += round($value['PROG_PRODUK']);
                        $kumRealST += $value['PROG_PRODUK'];
                        $data['data']['REAL_KUM'][$key] += $kumRealST;
                    }
                    $data['stok']['MAX'][$key] += round($value['MAX_STOK']);
                    //$data['stok']['MIN'][$key] += round($value['MIN_STOK']);                    
                }
                foreach ($data['data']['TANGGAL'] as $key => $value) {
                    $max = $data['stok']['MAX'][$key];
                    //$min = $data['stok']['MIN'][$key];
                    $persen = $max / 2;
                    array_push($data['stok']['TIGAPULUHPERSEN'], round($persen));
                }

                $data['akurasi'] = $this->getAkurasiPrognose($org, 1, $tanggal);
            } else if ($org == '7000') {
                $sumReal = 0;
                $sumProg = 0;
                $kumReal = 0;
                $kumTarget = 0;
                $produksi7000 = $this->Demandpl_model->grafProdStokTerak2('7000', $tanggal);
                $produksi5000 = $this->Demandpl_model->grafProdStokTerak2('5000', $tanggal);
                $data['tanggal'] = $produksi7000[0]['CREATE_DATE'];
                foreach ($produksi7000 as $value) {
                    array_push($data['data']['TANGGAL'], $value['TANGGAL']);
                    array_push($data['data']['TARGET'], round($value['RKAP_PRODUK']));
                    $kumTarget += round($value['RKAP_PRODUK']);
                    array_push($data['data']['TARGET_KUM'], $kumTarget);
                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        array_push($data['data']['REAL'], round($value['REALISASI_PROD']));
                        array_push($data['data']['PROG'], 0);
                        array_push($data['stok']['PROG'], round($value['REALISASI_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(255, 165, 0, 1)');
                        $kumReal += round($value['REALISASI_PROD']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                    } else {
                        array_push($data['data']['REAL'], 0);
                        array_push($data['data']['PROG'], round($value['PROG_PRODUK']));
                        array_push($data['stok']['PROG'], round($value['PROG_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                        $kumReal += round($value['PROG_PRODUK']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                    }

                    array_push($data['stok']['MAX'], round($value['MAX_STOK']));
                    $persen = $value['MAX_STOK'] / 2;
                    array_push($data['stok']['TIGAPULUHPERSEN'], round($persen));
                }
                $data['akurasi'] = $this->getAkurasiPrognose('7000', 1, $tanggal);
                $result['7000'] = $data;
                $result['TOTAL'] = $data;
                $sumReal = 0;
                $sumProg = 0;
                $kumReal = 0;
                $kumTarget = 0;
                $data = array();
                $data['data']['TANGGAL'] = array();
                $data['data']['TARGET'] = array();
                $data['data']['REAL'] = array();
                $data['data']['PROG'] = array();
                $data['data']['WARNA'] = array();
                $data['data']['RADIUS'] = array();
                $data['data']['TARGET_KUM'] = array();
                $data['data']['REAL_KUM'] = array();
                $data['stok']['PROG'] = array();
                $data['stok']['MAX'] = array();
                $data['stok']['MIN'] = array();
                $data['stok']['TIGAPULUHPERSEN'] = array();
                $sumReal = 0;
                $sumProg = 0;
                $kumReal = 0;
                $kumTarget = 0;


                foreach ($produksi5000 as $key => $value) {
                    if ($key == 0)
                        $data['tanggal'] = $value['CREATE_DATE'];
                    array_push($data['data']['TANGGAL'], $value['TANGGAL']);
                    array_push($data['data']['TARGET'], round($value['RKAP_PRODUK']));
                    $kumTarget += round($value['RKAP_PRODUK']);
                    array_push($data['data']['TARGET_KUM'], $kumTarget);
                    if (isset($result['TOTAL']['data']['TARGET'][$key])) {
                        $result['TOTAL']['data']['TARGET'][$key] += $data['data']['TARGET'][$key];
                        $result['TOTAL']['data']['TARGET_KUM'][$key] += $data['data']['TARGET_KUM'][$key];
                    }

                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        array_push($data['data']['REAL'], round($value['REALISASI_PROD']));
                        array_push($data['data']['PROG'], 0);
                        array_push($data['stok']['PROG'], round($value['REALISASI_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(255, 165, 0, 1)');
                        $kumReal += round($value['REALISASI_PROD']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                        if (isset($result['TOTAL']['data']['REAL'][$key])) {
                            $result['TOTAL']['data']['REAL'][$key] += $data['data']['REAL'][$key];
                            $result['TOTAL']['stok']['PROG'][$key] += $data['stok']['PROG'][$key];
                            $result['TOTAL']['data']['REAL_KUM'][$key] += $data['data']['REAL_KUM'][$key];
                        }
                    } else {
                        array_push($data['data']['REAL'], 0);
                        array_push($data['data']['PROG'], round($value['PROG_PRODUK']));
                        array_push($data['stok']['PROG'], round($value['PROG_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                        $kumReal += round($value['PROG_PRODUK']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                        if (isset($result['TOTAL']['data']['REAL'][$key])) {
                            $result['TOTAL']['data']['PROG'][$key] += $data['data']['PROG'][$key];
                            $result['TOTAL']['stok']['PROG'][$key] += $data['stok']['PROG'][$key];
                            $result['TOTAL']['data']['REAL_KUM'][$key] += $data['data']['REAL_KUM'][$key];
                        }
                    }

                    array_push($data['stok']['MAX'], round($value['MAX_STOK']));
                    $persen = $value['MAX_STOK'] / 2;
                    array_push($data['stok']['TIGAPULUHPERSEN'], round($persen));
                    if (isset($result['TOTAL']['stok']['MAX'])) {
                        $result['TOTAL']['stok']['MAX'][$key] += $data['stok']['MAX'][$key];
                        $result['TOTAL']['stok']['TIGAPULUHPERSEN'][$key] += $data['stok']['TIGAPULUHPERSEN'][$key];
                    }
                }


                $data['akurasi'] = $this->getAkurasiPrognose('5000', 1, $tanggal);
                $result['5000'] = $data;

                $data = $result;
            } else {
                $sumReal = 0;
                $sumProg = 0;
                $kumReal = 0;
                $kumTarget = 0;
                $produksi = $this->Demandpl_model->grafProdStokTerak2($org, $tanggal);
                //echo $this->db->last_query();
                $data['tanggal'] = isset($produksi[0]['CREATE_DATE']) ? $produksi[0]['CREATE_DATE'] : '';
                foreach ($produksi as $value) {
                    array_push($data['data']['TANGGAL'], $value['TANGGAL']);
                    array_push($data['data']['TARGET'], round($value['RKAP_PRODUK']));
                    $kumTarget += round($value['RKAP_PRODUK']);
                    array_push($data['data']['TARGET_KUM'], $kumTarget);
                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        array_push($data['data']['REAL'], round($value['REALISASI_PROD']));
                        array_push($data['data']['PROG'], 0);
                        array_push($data['stok']['PROG'], round($value['REALISASI_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(255, 165, 0, 1)');
                        $kumReal += round($value['REALISASI_PROD']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                    } else {
                        array_push($data['data']['REAL'], 0);
                        array_push($data['data']['PROG'], round($value['PROG_PRODUK']));
                        array_push($data['stok']['PROG'], round($value['PROG_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                        $kumReal += round($value['PROG_PRODUK']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                    }

                    array_push($data['stok']['MAX'], round($value['MAX_STOK']));
                    $persen = $value['MAX_STOK'] / 2;
                    array_push($data['stok']['TIGAPULUHPERSEN'], round($persen));
                }
                $data['akurasi'] = $this->getAkurasiPrognose($org, 1, $tanggal);
            }
        } else if ($type == 'semen') {
            $data['data']['TANGGAL'] = array();
            $data['data']['TARGET'] = array();
            $data['data']['REAL'] = array();
            $data['data']['WARNA'] = array();
            $data['data']['RADIUS'] = array();
            $data['data']['PROG'] = array();
            $data['data']['TARGET_KUM'] = array();
            $data['data']['REAL_KUM'] = array();
            $data['stok']['PROG'] = array();
            $data['stok']['MAX'] = array();
            $data['stok']['MIN'] = array();
            $data['stok']['TIGAPULUHPERSEN'] = array();
            if ($org == 0) {
                $sumReal = 0;
                $sumProg = 0;
                $kumReal = 0;
                $kumTarget = 0;
                $sg = $this->Demandpl_model->grafProdStokSemen2(7000, $tanggal);
                $sp = $this->Demandpl_model->grafProdStokSemen2(3000, $tanggal);
                $st = $this->Demandpl_model->grafProdStokSemen2(4000, $tanggal);
                //$tlcc = $this->Demandpl_model->grafProdStokSemen2(6000, $tanggal);
                $data['tanggal'] = $sg[0]['CREATE_DATE'];
                foreach ($sg as $value) {
                    array_push($data['data']['TANGGAL'], $value['TANGGAL']);
                    array_push($data['data']['TARGET'], round($value['RKAP_PRODUK']));
                    array_push($data['stok']['MAX'], round($value['MAX_STOK']));
                    $kumTarget += round($value['RKAP_PRODUK']);
                    array_push($data['data']['TARGET_KUM'], $kumTarget);
                    //array_push($data['stok']['MIN'], round($value['MIN_STOK']));
                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        array_push($data['data']['REAL'], round($value['REALISASI_PROD']));
                        array_push($data['data']['PROG'], 0);
                        array_push($data['stok']['PROG'], round($value['REALISASI_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(255, 165, 0, 1)');
                        $kumReal += round($value['REALISASI_PROD']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                    } else {
                        array_push($data['data']['REAL'], 0);
                        array_push($data['data']['PROG'], round($value['PROG_PRODUK']));
                        array_push($data['stok']['PROG'], round($value['PROG_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                        $kumReal += round($value['PROG_PRODUK']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                    }
                }
                $kumRealSP = 0;
                $kumTargetSP = 0;
                foreach ($sp as $key => $value) {
                    $data['data']['TARGET'][$key] += round($value['RKAP_PRODUK']);
                    $kumTargetSP += round($value['RKAP_PRODUK']);
                    $data['data']['TARGET_KUM'][$key] += $kumTargetSP;
                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        $data['data']['REAL'][$key] += round($value['REALISASI_PROD']);
                        $data['stok']['PROG'][$key] += round($value['REALISASI_STOK']);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                        $kumRealSP += round($value['REALISASI_PROD']);
                        $data['data']['REAL_KUM'][$key] += $kumRealSP;
                    } else {
                        $data['stok']['PROG'][$key] += round($value['PROG_STOK']);
                        $data['data']['PROG'][$key] += round($value['PROG_PRODUK']);
                        $kumRealSP += round($value['PROG_PRODUK']);
                        $data['data']['REAL_KUM'][$key] += $kumRealSP;
                    }
                    $data['stok']['MAX'][$key] += round($value['MAX_STOK']);
                    //$data['stok']['MIN'][$key] += round($value['MIN_STOK']);
                }
                $kumRealST = 0;
                $kumTargetST = 0;
                foreach ($st as $key => $value) {
                    $data['data']['TARGET'][$key] += round($value['RKAP_PRODUK']);
                    $kumTargetST += round($value['RKAP_PRODUK']);
                    $data['data']['TARGET_KUM'][$key] += $kumTargetST;
                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        $data['data']['REAL'][$key] += round($value['REALISASI_PROD']);
                        $data['stok']['PROG'][$key] += round($value['REALISASI_STOK']);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                        $kumRealST += round($value['REALISASI_PROD']);
                        $data['data']['REAL_KUM'][$key] += $kumRealST;
                    } else {
                        $data['stok']['PROG'][$key] += round($value['PROG_STOK']);
                        $data['data']['PROG'][$key] += round($value['PROG_PRODUK']);
                        $kumRealST += round($value['PROG_PRODUK']);
                        $data['data']['REAL_KUM'][$key] += $kumRealST;
                    }
                    $data['stok']['MAX'][$key] += round($value['MAX_STOK']);
                    //$data['stok']['MIN'][$key] += round($value['MIN_STOK']);
                }
                foreach ($data['data']['TANGGAL'] as $key => $value) {
                    $max = $data['stok']['MAX'][$key];
                    //$min = $data['stok']['MIN'][$key];
                    $persen = $max / 2;
                    array_push($data['stok']['TIGAPULUHPERSEN'], round($persen));
                }
                $data['akurasi'] = $this->getAkurasiPrognose($org, 2, $tanggal);
            } else if ($org == '7000') {

                $sumReal = 0;
                $sumProg = 0;
                $kumReal = 0;
                $kumTarget = 0;
                $produksi7000 = $this->Demandpl_model->grafProdStokSemen2('7000', $tanggal);
                $produksi5000 = $this->Demandpl_model->grafProdStokSemen2('5000', $tanggal);
                $data['tanggal'] = $produksi7000[0]['CREATE_DATE'];
                foreach ($produksi7000 as $value) {
                    array_push($data['data']['TANGGAL'], $value['TANGGAL']);
                    array_push($data['data']['TARGET'], round($value['RKAP_PRODUK']));
                    $kumTarget += round($value['RKAP_PRODUK']);
                    array_push($data['data']['TARGET_KUM'], $kumTarget);

                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        array_push($data['data']['REAL'], round($value['REALISASI_PROD']));
                        array_push($data['data']['PROG'], 0);
                        array_push($data['stok']['PROG'], round($value['REALISASI_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(255, 165, 0, 1)');
                        $kumReal += round($value['REALISASI_PROD']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                    } else {
                        array_push($data['data']['REAL'], 0);
                        array_push($data['data']['PROG'], round($value['PROG_PRODUK']));
                        array_push($data['stok']['PROG'], round($value['PROG_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                        $kumReal += round($value['PROG_PRODUK']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                    }

                    array_push($data['stok']['MAX'], round($value['MAX_STOK']));
                    $persen = $value['MAX_STOK'] / 2;
                    array_push($data['stok']['TIGAPULUHPERSEN'], round($persen));
                }
                $sumReal = 0;
                $sumProg = 0;
                $kumReal = 0;
                $kumTarget = 0;
                $data['akurasi'] = $this->getAkurasiPrognose('7000', 2, $tanggal);
                $result['7000'] = $data;
                $result['TOTAL'] = $data;
                $data = array();
                $data['data']['TANGGAL'] = array();
                $data['data']['TARGET'] = array();
                $data['data']['REAL'] = array();
                $data['data']['WARNA'] = array();
                $data['data']['RADIUS'] = array();
                $data['data']['PROG'] = array();
                $data['data']['TARGET_KUM'] = array();
                $data['data']['REAL_KUM'] = array();
                $data['stok']['PROG'] = array();
                $data['stok']['MAX'] = array();
                $data['stok']['MIN'] = array();
                $data['stok']['TIGAPULUHPERSEN'] = array();

                foreach ($produksi5000 as $key => $value) {
                    if ($key == 0) {
                        $data['tanggal'] = $value['CREATE_DATE'];
                    }
                    array_push($data['data']['TANGGAL'], $value['TANGGAL']);
                    array_push($data['data']['TARGET'], round($value['RKAP_PRODUK']));
                    $kumTarget += round($value['RKAP_PRODUK']);
                    array_push($data['data']['TARGET_KUM'], $kumTarget);
                    if (isset($result['TOTAL']['data']['TARGET'][$key])) {
                        $result['TOTAL']['data']['TARGET'][$key] += $data['data']['TARGET'][$key];
                        $result['TOTAL']['data']['TARGET_KUM'][$key] += $data['data']['TARGET_KUM'][$key];
                    }
                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        array_push($data['data']['REAL'], round($value['REALISASI_PROD']));
                        array_push($data['data']['PROG'], 0);
                        array_push($data['stok']['PROG'], round($value['REALISASI_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(255, 165, 0, 1)');
                        $kumReal += round($value['REALISASI_PROD']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                        if (isset($result['TOTAL']['data']['REAL'][$key])) {
                            $result['TOTAL']['data']['REAL'][$key] += $data['data']['REAL'][$key];
                            $result['TOTAL']['stok']['PROG'][$key] += $data['stok']['PROG'][$key];
                            $result['TOTAL']['data']['REAL_KUM'][$key] += $data['data']['REAL_KUM'][$key];
                        }
                    } else {
                        array_push($data['data']['REAL'], 0);
                        array_push($data['data']['PROG'], round($value['PROG_PRODUK']));
                        array_push($data['stok']['PROG'], round($value['PROG_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                        $kumReal += round($value['PROG_PRODUK']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                        if (isset($result['TOTAL']['data']['REAL'][$key])) {
                            $result['TOTAL']['data']['PROG'][$key] += $data['data']['PROG'][$key];
                            $result['TOTAL']['stok']['PROG'][$key] += $data['stok']['PROG'][$key];
                            $result['TOTAL']['data']['REAL_KUM'][$key] += $data['data']['REAL_KUM'][$key];
                        }
                    }

                    array_push($data['stok']['MAX'], round($value['MAX_STOK']));
                    $persen = $value['MAX_STOK'] / 2;
                    array_push($data['stok']['TIGAPULUHPERSEN'], round($persen));
                    if (isset($result['TOTAL']['stok']['MAX'])) {
                        $result['TOTAL']['stok']['MAX'][$key] += $data['stok']['MAX'][$key];
                        $result['TOTAL']['stok']['TIGAPULUHPERSEN'][$key] += $data['stok']['TIGAPULUHPERSEN'][$key];
                    }
                }
                $data['akurasi'] = $this->getAkurasiPrognose('5000', 2, $tanggal);
                $result['5000'] = $data;

                $data = $result;
            } else {
                $sumReal = 0;
                $sumProg = 0;
                $kumReal = 0;
                $kumTarget = 0;
                $produksi = $this->Demandpl_model->grafProdStokSemen2($org, $tanggal);
                $data['tanggal'] = isset($produksi[0]['CREATE_DATE']) ? $produksi[0]['CREATE_DATE'] : '';
                foreach ($produksi as $value) {
                    array_push($data['data']['TANGGAL'], $value['TANGGAL']);
                    array_push($data['data']['TARGET'], round($value['RKAP_PRODUK']));
                    $kumTarget += round($value['RKAP_PRODUK']);
                    array_push($data['data']['TARGET_KUM'], $kumTarget);
                    if ($value['TANGGAL'] <= $value['MAX_TANGGAL']) {
                        array_push($data['data']['REAL'], round($value['REALISASI_PROD']));
                        array_push($data['data']['PROG'], 0);
                        array_push($data['stok']['PROG'], round($value['REALISASI_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(255, 165, 0, 1)');
                        $kumReal += round($value['REALISASI_PROD']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                        $sumReal += round($value['REALISASI_PROD']);
                        $sumProg += round($value['PROG_PRODUK']);
                    } else {
                        array_push($data['data']['REAL'], 0);
                        array_push($data['data']['PROG'], round($value['PROG_PRODUK']));
                        array_push($data['stok']['PROG'], round($value['PROG_STOK']));
                        array_push($data['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                        $kumReal += round($value['PROG_PRODUK']);
                        array_push($data['data']['REAL_KUM'], $kumReal);
                    }

                    array_push($data['stok']['MAX'], round($value['MAX_STOK']));
                    $persen = $value['MAX_STOK'] / 2;
                    array_push($data['stok']['TIGAPULUHPERSEN'], round($persen));
                }
                $data['akurasi'] = $this->getAkurasiPrognose($org, 2, $tanggal);
            }
        }

        echo json_encode($data);
    }

    function getLastUpdate() {
        $data = $this->Demandpl_model->lastUpdate();
        echo json_encode($data);
    }

    function getChartGrowth($tanggal, $org) {
        $type = $this->input->post(null, true);
        //$type['type'] = 'mom';
        $nPerusahaan = $this->DemandplMS_model->getNumPerusahaan();
        $tahun = substr($tanggal, 0, 4);
        $bulan = substr($tanggal, 4, 5) - 1;
        $tandabulan = 0;
        for ($i = 1; $i <= $bulan; $i++) {
            if ($i <= 9) {
                $keybulan = '0' . $i;
            } else {
                $keybulan = $i;
            }
            $data[$tahun . '' . $keybulan] = $this->DemandplMS_model->getDataASI($tahun, $keybulan);
            $dataDN[$tahun . '' . $keybulan] = $this->DemandplMS_model->getDataASIGDN($tahun, $keybulan);
            $tandabulan = $bulan;
        }
        if ($bulan != 12) {
            $tahun--;
            $bulan++;
            for ($i = $bulan; $i <= 12; $i++) {
                if ($i <= 9) {
                    $keybulan = '0' . $i;
                } else {
                    $keybulan = $i;
                }
                $data[$tahun . '' . $keybulan] = $this->DemandplMS_model->getDataASI($tahun, $keybulan);
                $dataDN[$tahun . '' . $keybulan] = $this->DemandplMS_model->getDataASIGDN($tahun, $keybulan);
            }
        }
        ksort($data);
        $n = 0;
        $arr = array();
        $labels = array();
        foreach ($data[$tahun . '' . $keybulan] as $value) {
            $arr[$n]['label'] = $value['NAMA_PERUSAHAAN'];
            $arr[$n]['data'] = array();
            $arr[$n]['fill'] = false;
            if ($value['KODE_PERUSAHAAN'] != $org) {
                $arr[$n]['hidden'] = true;
            }
            $arr[$n]['lineTension'] = 0;
            $arr[$n]['borderColor'] = $this->warna($n);
            $arr[$n]['backgroundColor'] = $this->warna($n);
            $n++;
        }
        $arr[$nPerusahaan]['label'] = 'SEMEN INDONESIA';
        $arr[$nPerusahaan]['data'] = array();
        $arr[$nPerusahaan]['fill'] = false;
        $arr[$nPerusahaan]['lineTension'] = 0;
        $arr[$nPerusahaan]['borderColor'] = $this->warna($nPerusahaan);
        $arr[$nPerusahaan]['backgroundColor'] = $this->warna($nPerusahaan);
        if ($org != '1') {
            $arr[$n]['hidden'] = true;
        }
        $arr[$nPerusahaan + 1]['label'] = 'DEMAND NASIONAL';
        $arr[$nPerusahaan + 1]['data'] = array();
        $arr[$nPerusahaan + 1]['fill'] = false;
        $arr[$nPerusahaan + 1]['lineTension'] = 0;
        $arr[$nPerusahaan + 1]['borderColor'] = $this->warna($nPerusahaan + 1);
        $arr[$nPerusahaan + 1]['backgroundColor'] = $this->warna($nPerusahaan + 1);
        $m = 0;
        foreach ($data as $key => $value) {
            $realbulaniniSMI = 0;
            $realbulankemarinSMI = 0;
            $realtahunkemarinSMI = 0;
            $realkumtahuniniSMI = 0;
            $realkumtahunSMI = 0;
            $n = 0;
            foreach ($value as $row) {
                $realbulanini = str_replace(',', '.', $row['QTY']);
                $realbulankemarin = str_replace(',', '.', $row['REAL_BULAN']);
                $realtahunkemarin = str_replace(',', '.', $row['REAL_TAHUN']);
                $realkumtahunini = str_replace(',', '.', $row['REAL_TAHUNINI_KUM']);
                $realkumtahun = str_replace(',', '.', $row['REAL_TAHUN_KUM']);
                //$rkap = round(str_replace(',', '.', $row["RKAP"]), 2);
                if ($row['KODE_PERUSAHAAN'] == '102' || $row['KODE_PERUSAHAAN'] == '110' || $row['KODE_PERUSAHAAN'] == '112') {
                    $realbulaniniSMI += $realbulanini;
                    $realbulankemarinSMI += $realbulankemarin;
                    $realtahunkemarinSMI += $realtahunkemarin;
                    $realkumtahuniniSMI += $realkumtahunini;
                    $realkumtahunSMI += $realkumtahun;
                }

                //echo $n;
                if ($type['type'] == 'mom') {
                    if ($realbulankemarin == 0) {
                        $growth = 0;
                    } else {
                        $growth = round((($realbulanini - $realbulankemarin) / $realbulankemarin) * 100, 2);
                    }
                } else if ($type['type'] == 'yoy') {
                    if ($realtahunkemarin == 0) {
                        $growth = 0;
                    } else {
                        $growth = round((($realbulanini - $realtahunkemarin) / $realtahunkemarin) * 100, 2);
                    }
                } else if ($type['type'] == 'kumyoy') {
                    if ($realkumtahun == 0) {
                        $growth = 0;
                    } else {
                        $growth = round((($realkumtahunini - $realkumtahun) / $realkumtahun) * 100, 2);
                    }
                }
                array_push($arr[$n]['data'], $growth);

                //array_push($arr[$n + 1]['data'], $growthYoY);
                //array_push($arr[$n + 2]['data'], $growthkumYoY);
                $n++;
            }



            if ($type['type'] == 'mom') {
                if ($realbulankemarinSMI == 0) {
                    $growth = 0;
                } else {
                    $growth = round((($realbulaniniSMI - $realbulankemarinSMI) / $realbulankemarinSMI) * 100, 2);
                }
            } else if ($type['type'] == 'yoy') {
                if ($realtahunkemarinSMI == 0) {
                    $growth = 0;
                } else {
                    $growth = round((($realbulaniniSMI - $realtahunkemarinSMI) / $realtahunkemarinSMI) * 100, 2);
                }
            } else if ($type['type'] == 'kumyoy') {
                if ($realkumtahunSMI == 0) {
                    $growth = 0;
                } else {
                    $growth = round((($realkumtahuniniSMI - $realkumtahunSMI) / $realkumtahunSMI) * 100, 2);
                }
            }
            //$arr[$nPerusahaan]['data'][$m] = $growth;
            if ($m == 11 && $growth == 0) {
                
            } else {
                array_push($arr[$nPerusahaan]['data'], $growth);
            }

            $m++;
            //$n += 3;
            $keytahun = substr($key, 2, 2);
            $keybulan = substr($key, 4, 2);
            array_push($labels, $keybulan . '/' . $keytahun);
        }
        ksort($dataDN);
        foreach ($dataDN as $key => $value) {
            $n = 0;
            foreach ($value as $row) {
                $realbulanini = str_replace(',', '.', $row['REAL_BLN']);
                $realbulankemarin = str_replace(',', '.', $row['REAL_BLN_K']);
                $realtahunkemarin = str_replace(',', '.', $row['REAL_THN_K']);
                $realkumtahunini = str_replace(',', '.', $row['REAL_THNINI_KUM']);
                $realkumtahun = str_replace(',', '.', $row['REAL_THN_KUM']);
                //$rkap = round(str_replace(',', '.', $row["RKAP"]), 2);
                if ($type['type'] == 'mom') {
                    if ($realbulankemarin == 0) {
                        $growth = 0;
                    } else {
                        $growth = round((($realbulanini - $realbulankemarin) / $realbulankemarin) * 100, 2);
                    }
                } else if ($type['type'] == 'yoy') {
                    if ($realtahunkemarin == 0) {
                        $growth = 0;
                    } else {
                        $growth = round((($realbulanini - $realtahunkemarin) / $realtahunkemarin) * 100, 2);
                    }
                } else if ($type['type'] == 'kumyoy') {
                    if ($realkumtahun == 0) {
                        $growth = 0;
                    } else {
                        $growth = round((($realkumtahunini - $realkumtahun) / $realkumtahun) * 100, 2);
                    }
                }
                array_push($arr[$nPerusahaan + 1]['data'], $growth);

                //array_push($arr[$n + 1]['data'], $growthYoY);
                //array_push($arr[$n + 2]['data'], $growthkumYoY);
                $n++;
            }
        }
//        print_r($type);
//        echo '<pre>';
//        print_r($arr);
//        echo '</pre>';
        echo json_encode(array("labels" => $labels, "growth" => $arr));
    }

    function getChartGrowthSAP($tanggal) {
        $tahun = substr($tanggal, 0, 4);
        $bulan = substr($tanggal, 4, 5);
        $type = $this->input->post(null, true);
        $labels = array();
        $arr[7000]['label'] = 'SEMEN GRESIK';
        $arr[7000]['data'] = array();
        $arr[7000]['fill'] = false;
        $arr[7000]['lineTension'] = 0;
        $arr[7000]['borderColor'] = "#7F00FF";
        $arr[7000]['backgroundColor'] = "#7F00FF";
        $arr[3000]['label'] = 'SEMEN PADANG';
        $arr[3000]['data'] = array();
        $arr[3000]['fill'] = false;
        $arr[3000]['lineTension'] = 0;
        $arr[3000]['borderColor'] = "#FF8000";
        $arr[3000]['backgroundColor'] = "#FF8000";
        $arr[4000]['label'] = 'SEMEN TONASA';
        $arr[4000]['data'] = array();
        $arr[4000]['fill'] = false;
        $arr[4000]['lineTension'] = 0;
        $arr[4000]['borderColor'] = "#FF007F";
        $arr[4000]['backgroundColor'] = "#FF007F";
        $arr[2000]['label'] = 'SEMEN INDONESIA';
        $arr[2000]['data'] = array();
        $arr[2000]['fill'] = false;
        $arr[2000]['lineTension'] = 0;
        $arr[2000]['borderColor'] = "#F0000F";
        $arr[2000]['backgroundColor'] = "#F0000F";
        if ($type['type'] == "mom") {
            $dataSG = $this->DemandplMS_model->getDataMomSG($tahun, $bulan);
            $dataSP = $this->DemandplMS_model->getDataMomSP($tahun, $bulan);
            $dataST = $this->DemandplMS_model->getDataMomST($tahun, $bulan);
            for ($i = 1; $i <= 12; $i++) {
                $keytahun = substr($dataSG[$i]['TGL'], 2, 2);
                $keybulan = substr($dataSG[$i]['TGL'], 4, 2);
                array_push($labels, $keybulan . '/' . $keytahun);
                $bulanlaluSI = 0;
                $bulaniniSI = 0;
                $bulanlalu = str_replace(',', '.', $dataSG[$i - 1]['REALISASI']);
                $bulanini = str_replace(',', '.', $dataSG[$i]['REALISASI']);
                $growth = round((($bulanini - $bulanlalu) / $bulanlalu) * 100, 2);
                $bulanlaluSI += $bulanlalu;
                $bulaniniSI += $bulanini;
                array_push($arr[7000]['data'], $growth);
                $bulanlalu = str_replace(',', '.', $dataSP[$i - 1]['REALISASI']);
                $bulanini = str_replace(',', '.', $dataSP[$i]['REALISASI']);
                $growth = round((($bulanini - $bulanlalu) / $bulanlalu) * 100, 2);
                $bulanlaluSI += $bulanlalu;
                $bulaniniSI += $bulanini;
                array_push($arr[3000]['data'], $growth);
                $bulanlalu = str_replace(',', '.', $dataST[$i - 1]['REALISASI']);
                $bulanini = str_replace(',', '.', $dataST[$i]['REALISASI']);
                $growth = round((($bulanini - $bulanlalu) / $bulanlalu) * 100, 2);
                $bulanlaluSI += $bulanlalu;
                $bulaniniSI += $bulanini;
                array_push($arr[4000]['data'], $growth);
                $growth = round((($bulaniniSI - $bulanlaluSI) / $bulanlaluSI) * 100, 2);
                array_push($arr[2000]['data'], $growth);
            }
        } else if ($type['type'] == "yoy") {
            set_time_limit(0);
            $dataSG = $this->DemandplMS_model->getDataYoySG($tahun, $bulan);
            $dataSP = $this->DemandplMS_model->getDataYoySP($tahun, $bulan);
            $dataST = $this->DemandplMS_model->getDataYoyST($tahun, $bulan);
            for ($i = 12; $i <= 23; $i++) {
                $keytahun = substr($dataSG[$i]['TGL'], 2, 2);
                $keybulan = substr($dataSG[$i]['TGL'], 4, 2);
                array_push($labels, $keybulan . '/' . $keytahun);
                $bulanlaluSI = 0;
                $bulaniniSI = 0;
                $bulanlalu = str_replace(',', '.', $dataSG[$i - 12]['REALISASI']);
                $bulanini = str_replace(',', '.', $dataSG[$i]['REALISASI']);
                $growth = round((($bulanini - $bulanlalu) / $bulanlalu) * 100, 2);
                $bulanlaluSI += $bulanlalu;
                $bulaniniSI += $bulanini;
                array_push($arr[7000]['data'], $growth);
                $bulanlalu = str_replace(',', '.', $dataSP[$i - 12]['REALISASI']);
                $bulanini = str_replace(',', '.', $dataSP[$i]['REALISASI']);
                $growth = round((($bulanini - $bulanlalu) / $bulanlalu) * 100, 2);
                $bulanlaluSI += $bulanlalu;
                $bulaniniSI += $bulanini;
                array_push($arr[3000]['data'], $growth);
                $bulanlalu = str_replace(',', '.', $dataST[$i - 12]['REALISASI']);
                $bulanini = str_replace(',', '.', $dataST[$i]['REALISASI']);
                $growth = round((($bulanini - $bulanlalu) / $bulanlalu) * 100, 2);
                $bulanlaluSI += $bulanlalu;
                $bulaniniSI += $bulanini;
                array_push($arr[4000]['data'], $growth);
                $growth = round((($bulaniniSI - $bulanlaluSI) / $bulanlaluSI) * 100, 2);
                array_push($arr[2000]['data'], $growth);
            }
        } else if ($type['type'] == "kumyoy") {
            set_time_limit(0);
            $dataSG = $this->DemandplMS_model->getDataKumYoySG($tahun, $bulan);
            $dataSP = $this->DemandplMS_model->getDataKumYoySP($tahun, $bulan);
            $dataST = $this->DemandplMS_model->getDataKumYoyST($tahun, $bulan);
            $n_baris = $dataSG->num_rows();
            $data_real_sg = $dataSG->result_array();
            $data_real_sp = $dataSP->result_array();
            $data_real_st = $dataST->result_array();
            for ($i = $n_baris - 12; $i < $n_baris; $i++) {
                $keytahun = substr($data_real_sg[$i]['TGL'], 2, 2);
                $keybulan = substr($data_real_sg[$i]['TGL'], 4, 2);
                array_push($labels, $keybulan . '/' . $keytahun);
                $tgl_max = substr($data_real_sg[$i]['TGL'], 4, 2);
                //echo $tgl_max;
                $bulanlaluSI = 0;
                $bulaniniSI = 0;
                $kumini = 0;
                $kumlalu = 0;
                for ($j = 0; $j < $tgl_max; $j++) {
                    $kumini += str_replace(',', '.', $data_real_sg[$i - $j]['REALISASI']);
                    $kumlalu += str_replace(',', '.', $data_real_sg[($i - 12) - $j]['REALISASI']);
                }
                $growth = round((($kumini - $kumlalu) / $kumlalu) * 100, 2);
                $bulanlaluSI += $kumlalu;
                $bulaniniSI += $kumini;
                array_push($arr[7000]['data'], $growth);
                for ($j = 0; $j < $tgl_max; $j++) {
                    $kumini += str_replace(',', '.', $data_real_sp[$i - $j]['REALISASI']);
                    $kumlalu += str_replace(',', '.', $data_real_sp[($i - 12) - $j]['REALISASI']);
                }
                $growth = round((($kumini - $kumlalu) / $kumlalu) * 100, 2);
                $bulanlaluSI += $kumlalu;
                $bulaniniSI += $kumini;
                array_push($arr[3000]['data'], $growth);
                for ($j = 0; $j < $tgl_max; $j++) {
                    $kumini += str_replace(',', '.', $data_real_st[$i - $j]['REALISASI']);
                    $kumlalu += str_replace(',', '.', $data_real_st[($i - 12) - $j]['REALISASI']);
                }
                $growth = round((($kumini - $kumlalu) / $kumlalu) * 100, 2);
                $bulanlaluSI += $kumlalu;
                $bulaniniSI += $kumini;
                array_push($arr[4000]['data'], $growth);
                $growth = round((($bulaniniSI - $bulanlaluSI) / $bulanlaluSI) * 100, 2);
                array_push($arr[2000]['data'], $growth);
            }
        }
        $dataset[0] = $arr[7000];
        $dataset[1] = $arr[3000];
        $dataset[2] = $arr[4000];
        $dataset[3] = $arr[2000];
        echo json_encode(array("labels" => $labels, "growth" => $dataset));
//        echo '<pre>';
//        print_r($arr);
//        echo '</pre>';
    }

    function getAkurasiPrognose($org, $type, $date) {
        if ($org == 0) {
            $data = $this->Demandpl_model->prodTerakSemenMax(7000, $type, $date);
            $dataSP = $this->Demandpl_model->prodTerakSemenMax(3000, $type, $date);
            $dataST = $this->Demandpl_model->prodTerakSemenMax(4000, $type, $date);
            $data['RKAP'] += $dataSP['RKAP'] + $dataST['RKAP'];
            $data['REALISASI'] += $dataSP['REALISASI'] + $dataST['REALISASI'];
            $data['PROGNOSE'] += $dataSP['PROGNOSE'] + $dataST['PROGNOSE'];
        } else {
            $data = $this->Demandpl_model->prodTerakSemenMax($org, $type, $date);
        }
        $hasil['PROGNOSE'] = number_format($data['REALISASI'] + $data['PROGNOSE'], 0, "", ".");
        $hasil['RKAP'] = number_format($data['RKAP'], 0, "", ".");
        $hasil['PERSEN'] = round($this->getPersen($hasil['PROGNOSE'], $hasil['RKAP']), 1);
        return $hasil;
    }

    function warna($n) {
        $warna = array("#FF0000", "#FFFF00", "#FF8000", "#80FF00", "#00FF00", "#00FF80", "#00FFFF",
            "#0080FF", "#0000FF", "#7F00FF", "#FF00FF", "#FF007F", "#FF9999", "#B266FF", "#F0000F", "#FF9922");
        return $warna[$n];
    }

    function getPersen($a, $b) {
        if ($b == 0 || $b == '') {
            return 0;
        } else {
            return $a / $b * 100;
        }
    }

    function coba() {
        set_time_limit(0);
        //$data = $this->getStokTerakSemen("20161101");
        $date = '201701';
        $org = '7000';
        //$data = $this->Demandpl_model->sumSales6000($org, $date);
        $data = $this->Demandpl_model->getSalesChart($org, $date);
        //echo $tanggal;
        //echo $cek;
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public function getTable($date, $org, $tahunan = FALSE, $mv) {

        $data = array();
        if ($tahunan == 'TRUE') {

            if ($org == '0') {
                for ($i = 0; $i < 12; $i++) {
                    $bulan = sprintf("%02d", ($i + 1));
                    //-- SG --
                    $dataS = $this->Demandpl_model->detailSalesCom('7000', $date . $bulan, $mv);
                    if ($i == 0)
                        $dataSG = $dataS;
                    else {
                        foreach ($dataS as $key => $value) {
                            foreach ($value as $key1 => $value1) {
                                $dataSG[$key][$key1] += $value1;
                            }
                        }
                    }
                    //-- SP --
                    $dataS = $this->Demandpl_model->detailSalesCom('3000', $date . $bulan, $mv);
                    if ($i == 0)
                        $dataSP = $dataS;
                    else {
                        foreach ($dataS as $key => $value) {
                            foreach ($value as $key1 => $value1) {
                                $dataSP[$key][$key1] += $value1;
                            }
                        }
                    }
                    //-- ST --
                     $dataS = $this->Demandpl_model->detailSalesCom('4000', $date . $bulan, $mv);
//                    $dataS = $this->Demandpl_model->detailSales4000('4000', $date . $bulan, $mv);
                    if ($i == 0)
                        $dataST = $dataS;
                    else {
                        foreach ($dataS as $key => $value) {
                            foreach ($value as $key1 => $value1) {
                                $dataST[$key][$key1] += $value1;
                            }
                        }
                    }
                }

                //-- BERSATUUUUU --
                $data = $dataSG;
                foreach ($dataSP as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $data[$key][$key1] += $value1;
                    }
                }
                foreach ($dataST as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $data[$key][$key1] += $value1;
                    }
                }
            } else if ($org == '10000') {
                for ($i = 0; $i < 12; $i++) {
                    $bulan = sprintf("%02d", ($i + 1));
                    //-- SG --
                    $dataS = $this->Demandpl_model->detailSalesCom('7000', $date . $bulan, $mv);
                    if ($i == 0)
                        $dataSG = $dataS;
                    else {
                        foreach ($dataS as $key => $value) {
                            foreach ($value as $key1 => $value1) {
                                $dataSG[$key][$key1] += $value1;
                            }
                        }
                    }
                    //-- SP --
                    $dataS = $this->Demandpl_model->detailSalesCom('3000', $date . $bulan, $mv);
                    if ($i == 0)
                        $dataSP = $dataS;
                    else {
                        foreach ($dataS as $key => $value) {
                            foreach ($value as $key1 => $value1) {
                                $dataSP[$key][$key1] += $value1;
                            }
                        }
                    }
                    //-- ST --
//                    $dataS = $this->Demandpl_model->detailSales4000('4000', $date . $bulan, $mv);
                     $dataS = $this->Demandpl_model->detailSalesCom('4000', $date . $bulan, $mv);
                    if ($i == 0)
                        $dataST = $dataS;
                    else {
                        foreach ($dataS as $key => $value) {
                            foreach ($value as $key1 => $value1) {
                                $dataST[$key][$key1] += $value1;
                            }
                        }
                    }

                    //-- TLCC --
                    $dataS = $this->Demandpl_model->detailSales6000('6000', $date . $bulan, $mv);
                    if ($i == 0)
                        $dataTLCC = $dataS;
                    else {
                        foreach ($dataS as $key => $value) {
                            foreach ($value as $key1 => $value1) {
                                $dataTLCC[$key][$key1] += $value1;
                            }
                        }
                    }
                }

                //-- BERSATUUUUU --
                $data = $dataSG;
                foreach ($dataSP as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $data[$key][$key1] += $value1;
                    }
                }
                foreach ($dataST as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $data[$key][$key1] += $value1;
                    }
                }
                foreach ($dataTLCC as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $data[$key][$key1] += $value1;
                    }
                }
            } else if ($org == '6000') {
                for ($i = 0; $i < 12; $i++) {
                    $bulan = sprintf("%02d", ($i + 1));
                    $dataS = $this->Demandpl_model->detailSales6000($org, $date . $bulan, $mv);
                    if ($i == 0)
                        $data = $dataS;
                    else {
                        foreach ($dataS as $key => $value) {
                            foreach ($value as $key1 => $value1) {
                                $data[$key][$key1] += $value1;
                            }
                        }
                    }
                }
            } 
//            else if ($org == '4000') {
//                for ($i = 0; $i < 12; $i++) {
//                    $bulan = sprintf("%02d", ($i + 1));
//                    $dataS = $this->Demandpl_model->detailSales4000($org, $date . $bulan, $mv);
//                    if ($i == 0)
//                        $data = $dataS;
//                    else {
//                        foreach ($dataS as $key => $value) {
//                            foreach ($value as $key1 => $value1) {
//                                $data[$key][$key1] += $value1;
//                            }
//                        }
//                    }
//                }
//            } 
            else {

                for ($i = 0; $i < 12; $i++) {
                    $bulan = sprintf("%02d", ($i + 1));
                    $dataS = $this->Demandpl_model->detailSalesCom($org, $date . $bulan, $mv);
                    if ($i == 0)
                        $data = $dataS;
                    else {
                        foreach ($dataS as $key => $value) {
                            foreach ($value as $key1 => $value1) {
                                $data[$key][$key1] += $value1;
                            }
                        }
                    }
                }
            }
        } else {
            if ($org == '0') {
                $dataSG = $this->Demandpl_model->detailSalesCom('7000', $date, $mv);
                //   var_dump($dataSG);
                $dataSP = $this->Demandpl_model->detailSalesCom('3000', $date, $mv);
                // var_dump($dataSP);
//                $dataST = $this->Demandpl_model->detailSales4000('4000', $date, $mv);
                $dataSP = $this->Demandpl_model->detailSalesCom('4000', $date, $mv);
                //var_dump($dataST);

                $data = $dataSG;
                foreach ($dataSP as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $data[$key][$key1] += $value1;
                    }
                }
                foreach ($dataST as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $data[$key][$key1] += $value1;
                    }
                }
            } else if ($org == '10000') {
                $dataSG = $this->Demandpl_model->detailSalesCom('7000', $date, $mv);
                $dataSP = $this->Demandpl_model->detailSalesCom('3000', $date, $mv);
                $dataSP = $this->Demandpl_model->detailSalesCom('4000', $date, $mv);
//                $dataST = $this->Demandpl_model->detailSales4000('4000', $date, $mv);
                $dataTLCC = $data = $this->Demandpl_model->detailSales6000('6000', $date, $mv);
                $data = $dataSG;
                foreach ($dataSP as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $data[$key][$key1] += $value1;
                    }
                }
                foreach ($dataST as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $data[$key][$key1] += $value1;
                    }
                }
                foreach ($dataTLCC as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $data[$key][$key1] += $value1;
                    }
                }
            } else if ($org == '6000') {

                $data = $this->Demandpl_model->detailSales6000($org, $date, $mv);
            } 
//            else if ($org == '4000') {
//
//                $data = $this->Demandpl_model->detailSales4000($org, $date, $mv);
//            } 
            else {
                $data = $this->Demandpl_model->detailSalesCom($org, $date, $mv);
            }
        }

        if (isset($data['domestik'])) {
            $result = '<tr><td> Semen </td>';
            $result .= "<td>" . number_format($data['domestik']['REAL_SM_DOMESTIK'], 0, ",", ".") . "</td>";
            $result .= "<td>" . number_format($data['domestik']['RKAP_SM_SDK'], 0, ",", ".") . "</td>";
            $result .= "<td>" . round(($data['domestik']['RKAP_SM_SDK'] != 0) ? $data['domestik']['REAL_SM_DOMESTIK'] / $data['domestik']['RKAP_SM_SDK'] * 100 : '0') . "%</td>";
            $result .= "<td>" . number_format($data['ics']['REAL_SM_ICS'], 0, ",", ".") . "</td>";
            $result .= "<td>" . number_format($data['ics']['RKAP_SM_ICS'], 0, ",", ".") . "</td>";
            $result .= "<td>" . round(($data['ics']['RKAP_SM_ICS'] != 0) ? $data['ics']['REAL_SM_ICS'] / $data['ics']['RKAP_SM_ICS'] * 100 : '0') . "%</td>";
            $result .= "<td>" . number_format($data['ekspor']['REAL_SM_EKSPOR'], 0, ",", ".") . "</td>";
            $result .= "<td>" . number_format($data['ekspor']['RKAP_SM_EKSPOR'], 0, ",", ".") . "</td>";
            $result .= "<td>" . round(($data['ekspor']['RKAP_SM_EKSPOR'] != 0) ? $data['ekspor']['REAL_SM_EKSPOR'] / $data['ekspor']['RKAP_SM_EKSPOR'] * 100 : '0') . "%</td>";
            $result .= "<td>" . number_format($data['ekspor']['REAL_SM_EKSPOR'] + $data['domestik']['REAL_SM_DOMESTIK'], 0, ",", ".") . "</td>";
            $result .= "<td>" . number_format($data['ekspor']['RKAP_SM_EKSPOR'] + $data['domestik']['RKAP_SM_SDK'], 0, ",", ".") . "</td>";
            $result .= "<td>" . round((($data['ekspor']['RKAP_SM_EKSPOR'] + $data['domestik']['RKAP_SM_SDK']) != 0) ? ($data['ekspor']['REAL_SM_EKSPOR'] + $data['domestik']['REAL_SM_DOMESTIK']) / ($data['ekspor']['RKAP_SM_EKSPOR'] + $data['domestik']['RKAP_SM_SDK']) * 100 : '0') . "%</td></tr>";
            $result .= '<tr><td> Clinker </td>';
            $result .= "<td>" . number_format($data['domestik']['REAL_CL_DOMESTIK'], 0, ",", ".") . "</td>";
            $result .= "<td>" . number_format($data['domestik']['RKAP_CL_SDK'], 0, ",", ".") . "</td>";
            $result .= "<td>" . round(($data['domestik']['RKAP_CL_SDK'] != 0) ? $data['domestik']['REAL_CL_DOMESTIK'] / $data['domestik']['RKAP_CL_SDK'] * 100 : '0') . "%</td>";
            $result .= "<td>" . number_format($data['ics']['REAL_CL_ICS'], 0, ",", ".") . "</td>";
            $result .= "<td>" . number_format($data['ics']['RKAP_CL_ICS'], 0, ",", ".") . "</td>";
            $result .= "<td>" . round(($data['ics']['RKAP_CL_ICS'] != 0) ? $data['ics']['REAL_CL_ICS'] / $data['ics']['RKAP_CL_ICS'] * 100 : '0') . "%</td>";
            $result .= "<td>" . number_format($data['ekspor']['REAL_CL_EKSPOR'], 0, ",", ".") . "</td>";
            $result .= "<td>" . number_format($data['ekspor']['RKAP_CL_EKSPOR'], 0, ",", ".") . "</td>";
            $result .= "<td>" . round(($data['ekspor']['RKAP_CL_EKSPOR'] != 0) ? $data['ekspor']['REAL_CL_EKSPOR'] / $data['ekspor']['RKAP_CL_EKSPOR'] * 100 : '0') . "%</td>";
            $result .= "<td>" . number_format($data['ekspor']['REAL_CL_EKSPOR'] + $data['domestik']['REAL_CL_DOMESTIK'], 0, ",", ".") . "</td>";
            $result .= "<td>" . number_format($data['ekspor']['RKAP_CL_EKSPOR'] + $data['domestik']['RKAP_CL_SDK'], 0, ",", ".") . "</td>";
            $result .= "<td>" . round((($data['ekspor']['RKAP_CL_EKSPOR'] + $data['domestik']['RKAP_CL_SDK']) != 0) ? ($data['ekspor']['REAL_CL_EKSPOR'] + $data['domestik']['REAL_CL_DOMESTIK']) / ($data['ekspor']['RKAP_CL_EKSPOR'] + $data['domestik']['RKAP_CL_SDK']) * 100 : '0') . "%</td></tr>";
            $result .= '<tr><td> Total </td>';
            $result .= "<td>" . number_format($data['domestik']['REAL_DOMESTIK_ALL'], 0, ",", ".") . "</td>";
            $result .= "<td>" . number_format($data['domestik']['RKAP_SDK_ALL'], 0, ",", ".") . "</td>";
            $result .= "<td>" . round(($data['domestik']['RKAP_SDK_ALL'] != 0) ? $data['domestik']['REAL_DOMESTIK_ALL'] / $data['domestik']['RKAP_SDK_ALL'] * 100 : '0') . "%</td>";
            $result .= "<td>" . number_format($data['ics']['REAL_ICS_ALL'], 0, ",", ".") . "</td>";
            $result .= "<td>" . number_format($data['ics']['RKAP_ICS_ALL'], 0, ",", ".") . "</td>";
            $result .= "<td>" . round(($data['ics']['RKAP_ICS_ALL'] != 0) ? $data['ics']['REAL_ICS_ALL'] / $data['ics']['RKAP_ICS_ALL'] * 100 : '0') . "%</td>";
            $result .= "<td>" . number_format($data['ekspor']['REAL_EKSPOR_ALL'], 0, ",", ".") . "</td>";
            $result .= "<td>" . number_format($data['ekspor']['RKAP_EKSPOR_ALL'], 0, ",", ".") . "</td>";
            $result .= "<td>" . round(($data['ekspor']['RKAP_EKSPOR_ALL'] != 0) ? $data['ekspor']['REAL_EKSPOR_ALL'] / $data['ekspor']['RKAP_EKSPOR_ALL'] * 100 : '0') . "%</td>";
            $result .= "<td>" . number_format($data['ekspor']['REAL_EKSPOR_ALL'] + $data['domestik']['REAL_DOMESTIK_ALL'], 0, ",", ".") . "</td>";
            $result .= "<td>" . number_format($data['ekspor']['RKAP_EKSPOR_ALL'] + $data['domestik']['RKAP_SDK_ALL'], 0, ",", ".") . "</td>";
            $result .= "<td>" . round((($data['ekspor']['RKAP_EKSPOR_ALL'] + $data['domestik']['RKAP_SDK_ALL']) != 0) ? ($data['ekspor']['REAL_EKSPOR_ALL'] + $data['domestik']['REAL_DOMESTIK_ALL']) / ($data['ekspor']['RKAP_EKSPOR_ALL'] + $data['domestik']['RKAP_SDK_ALL']) * 100 : '0') . "%</td></tr>";
        }
//        foreach ($data as $key => $value) {
//
//            if ($key == 'ics' && ($org == '6000' || $org == '0' || $org == '10000')) {
//                
//            } else {
//                
//                
//                
//                $result .= '<tr>';
//                $result .= '<td>' . strtoupper($key) . '</td>';
////                foreach ($value as $key1 => $value1) {
////                    if ($key1 != 'COM')
////                        $result .= '<td>' . number_format($value1, 0, ",", ".") . '</td>';
////
////                    if (strpos($key1, 'ALL') !== false)
////                        $total = $value1;
////                    else if (strpos($key1, 'RKAP') !== false)
////                        $target = $value1;
////                }
////                $result .= '<td>' . round(($target != 0) ? $total / $target * 100 : '0') . '%</td>';
////                $result .= '</tr>';
//            }
//        }
        //var_dump($data);
        //
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
//            $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $haritmpl = $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan)) + 1;
            $haritmpl = date('t', strtotime($tahun . "-" . $bulan));
        }
        //       $data['tanggal'] = ($haritmpl) . '-' . $bulan . '-' . $tahun;

        $res = array(
            'result' => $result,
            'tanggal' => ($haritmpl) . '-' . $bulan . '-' . $tahun
        );
        echo json_encode($res);
    }

    function getSalesSMITahunan($tahun) {
        $dataSG = $this->Demandpl_model->sumSalesOpcoTahunan('7000', $tahun);
        $dataSP = $this->Demandpl_model->sumSalesOpcoTahunan('3000', $tahun);
        $dataST = $this->Demandpl_model->sumSalesOpcoTahunan('4000', $tahun);
        //$dataST = $this->Demandpl_model->sumSalesTonasaTahunan($tahun);
        $dataTLCC = $this->Demandpl_model->sumSalesTLCCTahunan($tahun);

        $dataSMI = $dataSG;
        foreach ($dataSP as $key => $value) {
            $dataSMI[$key] += $value;
        }
        foreach ($dataST as $key => $value) {
            $dataSMI[$key] += $value;
        }
//        $dataSMI['REAL_SDH'] = $dataSMI['REAL_TAHUN_INI'];


        $dataSMI['PERSEN'] = round($this->getPersen($dataSMI['REAL_SDK'], $dataSMI['RKAP_SDK']));


        $dataSMI['DEVIASI'] = $dataSMI['REAL_SDK'] - $dataSMI['RKAP_SDK'];

        $dataSMI['REAL_EKSPOR_TAHUNINI'] = $dataSMI['REAL_SM_EKSPOR'] + $dataSMI['REAL_TR_EKSPOR'];
        $dataSMI['PERSEN_EKSPOR'] = round($this->getPersen($dataSMI['REAL_EKSPOR_TAHUNINI'], $dataSMI['RKAP_EKSPOR']));
        $dataSMI['PERSEN_TOTAL'] = round($this->getPersen($dataSMI['REAL_SDK'] + $dataSMI['REAL_EKSPOR_TAHUNINI'], $dataSMI['RKAP_EKSPOR'] + $dataSMI['RKAP_SDK']));


        /////////////////////////////////////////////////////
        //DATA SMI + TLCC//
        foreach ($dataTLCC as $key => $value) {
            $dataSMI['SMITLCC_' . $key] = $dataSMI[$key] + $value;
        }
        $dataSMI['SMITLCC_DEVIASI'] = $dataSMI['SMITLCC_REAL_SDK'] - $dataSMI['SMITLCC_RKAP_SDK'];
        $dataSMI['SMITLCC_REAL_EKSPOR_TAHUNINI'] = $dataSMI['SMITLCC_REAL_SM_EKSPOR'] + $dataSMI['SMITLCC_REAL_TR_EKSPOR'];
        $dataSMI['SMITLCC_PERSEN'] = round($this->getPersen($dataSMI['SMITLCC_REAL_SDK'], $dataSMI['SMITLCC_RKAP_SDK']));
        $dataSMI['SMITLCC_PERSEN_EKSPOR'] = round($this->getPersen($dataSMI['SMITLCC_REAL_EKSPOR_TAHUNINI'], $dataSMI['SMITLCC_RKAP_EKSPOR']));
        $dataSMI['SMITLCC_PERSEN_TOTAL'] = round($this->getPersen($dataSMI['SMITLCC_REAL_SDK'] + $dataSMI['SMITLCC_REAL_EKSPOR_TAHUNINI'], $dataSMI['SMITLCC_RKAP_EKSPOR'] + $dataSMI['SMITLCC_RKAP_SDK']));
        ######################################################
        ######################################################
        echo json_encode($dataSMI);
    }

    function getSalesOpcoTahunan($org, $tahun) {
        set_time_limit(0);
        if ($org == '6000') {
            $data = $this->Demandpl_model->sumSalesTLCCTahunan($tahun);
        }
//        else if ($org == '4000') {
//            $data = $this->Demandpl_model->sumSalesTonasaTahunan($tahun);
//        } 
        else {
            $data = $this->Demandpl_model->sumSalesOpcoTahunan($org, $tahun);
        }
        $data['REAL_SDK'] = round($data['REAL_SDK']);
        $data['RKAP_SDK'] = round($data['RKAP_SDK']);

        //$data['REAL_SDH'] = $data['REAL_TAHUN_INI'];

        $data['PERSEN'] = round($this->getPersen($data['REAL_SDK'], $data['RKAP_SDK']));

        $data['DEVIASI'] = $data['REAL_SDK'] - $data['RKAP_SDK'];

        $data['REAL_EKSPOR_TAHUNINI'] = $data['REAL_TR_EKSPOR'] + $data['REAL_SM_EKSPOR'];

        $data['PERSEN_EKSPOR'] = round($this->getPersen($data['REAL_EKSPOR_TAHUNINI'], $data['RKAP_EKSPOR']));
        $data['PERSEN_ICS'] = round($this->getPersen($data['REAL_ICS'], $data['RKAP_ICS']));
        $data['PERSEN_TOTAL'] = round($this->getPersen($data['REAL_SDK'] + $data['REAL_EKSPOR_TAHUNINI'], $data['RKAP_EKSPOR'] + $data['RKAP_SDK']));

        echo json_encode($data);
    }

    function getProdTahunan($org, $type, $date) {
        $cek = $this->db->query("SELECT * FROM ZREPORT_REAL_PROD_DEMANDPL WHERE ORG = '$org' AND KODE_PRODUK = '$type' AND TO_CHAR(TANGGAL,'YYYY') = '$date'")->num_rows();
        if ($cek > 0) {
            $data = $this->Demandpl_model->getProdTahunan($org, $date, $type);
        } else {
//            $data = $this->Demandpl_model->prodTerakSemen($org, $type, $date);
            $data = array(
                "RKAP" => 0,
                "REALISASI" => 0,
                "RKAP_SD" => 0
            );
        }
        return $data;
    }

    function getProdTerakSemenTahunan($date) {
        //$cek = $this->db->query("SELECT * FROM ZREPORT_REAL_PROD_DEMANDPL WHERE TO_CHAR(TANGGAL,'YYYYMM') = '$date'")->num_rows();

        $terakSG = $this->getProdTahunan('7000', 1, $date);
        $terakSG2 = $this->getProdTahunan('5000', 1, $date);
        $terakSP = $this->getProdTahunan('3000', 1, $date);
        $terakST = $this->getProdTahunan('4000', 1, $date);
        $terakTLCC = $this->getProdTahunan('6000', 1, $date);
        $semenSG = $this->getProdTahunan('7000', 2, $date);
        $semenSG2 = $this->getProdTahunan('5000', 2, $date);
        $semenSP = $this->getProdTahunan('3000', 2, $date);
        $semenST = $this->getProdTahunan('4000', 2, $date);
        $semenTLCC = $this->getProdTahunan('6000', 2, $date);

        foreach ($terakSG as $key => $value) {
            if (isset($terakSG2[$key]))
                $terakSG[$key] += $terakSG2[$key];
        }
        foreach ($semenSG as $key => $value) {
            if (isset($semenSG2[$key]))
                $semenSG[$key] += $semenSG2[$key];
        }


        $terakSG['PERSEN'] = $this->getPersen($terakSG['REALISASI'], $terakSG['RKAP_SD']);
        //$terakSG['PROGNOSE_BULAN'] = $terakSG['REALISASI'] + $terakSG['PROGNOSE'];
        $terakSG['DEVIASI'] = ($terakSG['REALISASI'] - $terakSG['RKAP_SD']);
        $terakSP['PERSEN'] = $this->getPersen($terakSP['REALISASI'], $terakSP['RKAP_SD']);
        $terakSP['DEVIASI'] = ($terakSP['REALISASI'] - $terakSP['RKAP_SD']);
//        $terakSP['PROGNOSE_BULAN'] = $terakSP['REALISASI'] + $terakSP['PROGNOSE'];
        $terakST['PERSEN'] = $this->getPersen($terakST['REALISASI'], $terakST['RKAP_SD']);
        $terakST['DEVIASI'] = ($terakST['REALISASI'] - $terakST['RKAP_SD']);
//        $terakST['PROGNOSE_BULAN'] = $terakST['REALISASI'] + $terakST['PROGNOSE'];
        $terakTLCC['PERSEN'] = $this->getPersen($terakTLCC['REALISASI'], $terakTLCC['RKAP_SD']);
        $terakTLCC['DEVIASI'] = ($terakTLCC['REALISASI'] - $terakTLCC['RKAP_SD']);
//        $terakTLCC['PROGNOSE_BULAN'] = $terakTLCC['REALISASI'] + $terakTLCC['PROGNOSE'];
        $semenSG['PERSEN'] = $this->getPersen($semenSG['REALISASI'], $semenSG['RKAP_SD']);
        $semenSG['DEVIASI'] = ($semenSG['REALISASI'] - $semenSG['RKAP_SD']);
//        $semenSG['PROGNOSE_BULAN'] = $semenSG['REALISASI'] + $semenSG['PROGNOSE'];
        $semenSP['PERSEN'] = $this->getPersen($semenSP['REALISASI'], $semenSP['RKAP_SD']);
        $semenSP['DEVIASI'] = ($semenSP['REALISASI'] - $semenSP['RKAP_SD']);
//        $semenSP['PROGNOSE_BULAN'] = $semenSP['REALISASI'] + $semenSP['PROGNOSE'];
        $semenST['PERSEN'] = $this->getPersen($semenST['REALISASI'], $semenST['RKAP_SD']);
        $semenST['DEVIASI'] = ($semenST['REALISASI'] - $semenST['RKAP_SD']);
//        $semenST['PROGNOSE_BULAN'] = $semenST['REALISASI'] + $semenST['PROGNOSE'];
        $semenTLCC['PERSEN'] = $this->getPersen($semenTLCC['REALISASI'], $semenTLCC['RKAP_SD']);
        $semenTLCC['DEVIASI'] = ($semenTLCC['REALISASI'] - $semenTLCC['RKAP_SD']);
//        $semenTLCC['PROGNOSE_BULAN'] = $semenTLCC['REALISASI'] + $semenTLCC['PROGNOSE'];
        $terakSMIG = array();
        $semenSMIG = array();
        $terakSMIG['RKAP_SD'] = $terakSG['RKAP_SD'] + $terakSP['RKAP_SD'] + $terakST['RKAP_SD']; // + $terakTLCC['RKAP'];
//        $terakSMIG['PROGNOSE'] = $terakSG['PROGNOSE'] + $terakSP['PROGNOSE'] + $terakST['PROGNOSE']; // + $terakTLCC['PROGNOSE'];
        $terakSMIG['REALISASI'] = $terakSG['REALISASI'] + $terakSP['REALISASI'] + $terakST['REALISASI']; // + $terakTLCC['REALISASI'];
        $terakSMIG['PERSEN'] = $this->getPersen($terakSMIG['REALISASI'], $terakSMIG['RKAP_SD']);
        $terakSMIG['DEVIASI'] = ($terakSMIG['REALISASI'] - $terakSMIG['RKAP_SD']);
//        $terakSMIG['PROGNOSE_BULAN'] = round($terakSG['PROGNOSE_BULAN'] + $terakSP['PROGNOSE_BULAN'] + $terakST['PROGNOSE_BULAN']); // + $terakTLCC['PROGNOSE_BULAN']);
        $semenSMIG['RKAP_SD'] = $semenSG['RKAP_SD'] + $semenSP['RKAP_SD'] + $semenST['RKAP_SD']; // + $semenTLCC['RKAP'];
//        $semenSMIG['PROGNOSE'] = $semenSG['PROGNOSE'] + $semenSP['PROGNOSE'] + $semenST['PROGNOSE']; // + $semenTLCC['PROGNOSE'];
        $semenSMIG['REALISASI'] = $semenSG['REALISASI'] + $semenSP['REALISASI'] + $semenST['REALISASI']; // + $semenTLCC['REALISASI'];
        $semenSMIG['PERSEN'] = $this->getPersen($semenSMIG['REALISASI'], $semenSMIG['RKAP_SD']);
        $semenSMIG['DEVIASI'] = ($semenSMIG['REALISASI'] - $semenSMIG['RKAP_SD']);
//        $semenSMIG['PROGNOSE_BULAN'] = round($semenSG['PROGNOSE_BULAN'] + $semenSP['PROGNOSE_BULAN'] + $semenST['PROGNOSE_BULAN']); // + $semenTLCC['PROGNOSE_BULAN']);
        $arr = array(
            "terakSMIG" => $terakSMIG,
            "terakSG" => $terakSG,
            "terakSP" => $terakSP,
            "terakST" => $terakST,
            "terakTLCC" => $terakTLCC,
            "semenSMIG" => $semenSMIG,
            "semenSG" => $semenSG,
            "semenSP" => $semenSP,
            "semenST" => $semenST,
            "semenTLCC" => $semenTLCC
        );
        echo json_encode($arr);
//        echo '<pre>';
//        print_r($arr);
//        echo '</pre>';
    }

    public function getChartTahunan($tanggal, $type, $org) {
        $result = array();
        if ($type == 'vol') {

            $result['tanggal'] = date('d-m-Y');
            $result['akumulasi']['REAL'] = array();
            $result['akumulasi']['TARGET'] = array();
            $result['data']['TANGGAL'] = array();
            $result['data']['TAHUNLALU'] = array();
            $result['data']['TARGET'] = array();
            $result['data']['REAL'] = array();
            $result['data']['PROG'] = array();
            $result['data']['WARNA'] = array();
            $result['data']['RADIUS'] = array();
            $result['prog'] = 0;
            $result['rkap'] = 0;
            $result['persen'] = 0;
            $akumulasiRKAP = 0;
            $akumulasiREAL = 0;

            for ($i = 0; $i < 12; $i++) {

                $bulan = sprintf("%02d", ($i + 1));
                if ($tanggal == date("Y") && $bulan == date('m')) {
                    $date = date("Ym");
                } else {
                    $date = $tanggal . $bulan;
                }
                if ($org == '0') {
//                $dataSTL = $this->Demandpl_model->sumSales6000($org, $date);

                    $data = $this->Demandpl_model->sumSalesOpco('7000', $date);
                    $dataSP = $this->Demandpl_model->sumSalesOpco('3000', $date);
                    $dataST = $this->Demandpl_model->sumSalesOpco('4000', $date);
                    //$dataST = $this->Demandpl_model->sumSalesTonasa('4000', $date);

                    $data['REAL_SDK'] += $dataSP['REAL_SDK'];
                    $data['RKAP_SDK'] += $dataSP['RKAP_SDK'];
                    $data['PROGNOSE'] += $dataSP['PROGNOSE'];
                    $data['PROG_ADJ'] += $dataSP['PROG_ADJ'];
                    $data['REAL_TAHUNLALU'] += $dataSP['REAL_TAHUNLALU'];
                    $data['REAL_SDK'] += $dataST['REAL_SDK'];
                    $data['RKAP_SDK'] += $dataST['RKAP_SDK'];
                    $data['PROGNOSE'] += $dataST['PROGNOSE'];
                    $data['PROG_ADJ'] += $dataST['PROG_ADJ'];
                    $data['REAL_TAHUNLALU'] += $dataST['REAL_TAHUNLALU'];
                } else if ($org == '10000') {
                    $data = $this->Demandpl_model->sumSalesOpco('7000', $date);
                    $dataSP = $this->Demandpl_model->sumSalesOpco('3000', $date);
                    $dataST = $this->Demandpl_model->sumSalesOpco('4000', $date);
                    //$dataST = $this->Demandpl_model->sumSalesTonasa('4000', $date);
                    $dataTLCC = $this->Demandpl_model->sumSales6000('6000', $date);

                    $data['REAL_SDK'] += $dataSP['REAL_SDK'];
                    $data['RKAP_SDK'] += $dataSP['RKAP_SDK'];
                    $data['PROGNOSE'] += $dataSP['PROGNOSE'];
                    $data['PROG_ADJ'] += $dataSP['PROG_ADJ'];
                    $data['REAL_TAHUNLALU'] += $dataSP['REAL_TAHUNLALU'];
                    $data['REAL_SDK'] += $dataST['REAL_SDK'];
                    $data['RKAP_SDK'] += $dataST['RKAP_SDK'];
                    $data['PROGNOSE'] += $dataST['PROGNOSE'];
                    $data['PROG_ADJ'] += $dataST['PROG_ADJ'];
                    $data['REAL_TAHUNLALU'] += $dataST['REAL_TAHUNLALU'];
                    $data['REAL_SDK'] += $dataTLCC['REAL_SDK'];
                    $data['RKAP_SDK'] += $dataTLCC['RKAP_SDK'];
                    $data['PROGNOSE'] += $dataTLCC['PROGNOSE'];
                    $data['PROG_ADJ'] += $dataTLCC['PROG_ADJ'];
                    $data['REAL_TAHUNLALU'] += $dataTLCC['REAL_TAHUNLALU'];
                } else if ($org == '6000') {
                    $data = $this->Demandpl_model->sumSales6000($org, $date);
                } 
//                else if ($org == '4000') {
//                    $data = $this->Demandpl_model->sumSalesTonasa($org, $date);
//                } 
                else {
                    $data = $this->Demandpl_model->sumSalesOpco($org, $date);
                }
//                echo $this->db->last_query();
//                echo '<pre>';
//                var_dump($data);
                if ($tanggal == date("Y") && $bulan > date('m')) {
                    $akumulasiREAL += round($data['RKAP_SDK']) + round($data['PROG_ADJ']);
                    array_push($result['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                    array_push($result['data']['PROG'], round($data['PROGNOSE']) + round($data['PROG_ADJ']) + round($data['RKAP_SDK']));
                } else if ($tanggal == date("Y") && $bulan == date('m')) {
                    $akumulasiREAL += round($data['RKAP_SDK']) + round($data['PROG_ADJ']) + round($data['RKAP_SDK']);
                    array_push($result['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                    array_push($result['data']['PROG'], round($data['PROGNOSE']) + round($data['PROG_ADJ']) + round($data['RKAP_SDK']));
                } else {
                    $akumulasiREAL += $data['REAL_SDK'];

                    array_push($result['data']['PROG'], 0);
                    array_push($result['data']['WARNA'], 'rgba(255, 165, 0, 1)');
                }

                $data['RKAP_SDK'] += $data['PROGNOSE'];
                $akumulasiRKAP += $data['RKAP_SDK'];

                array_push($result['data']['TANGGAL'], $bulan);
                array_push($result['data']['TAHUNLALU'], round($data['REAL_TAHUNLALU']));
                array_push($result['data']['TARGET'], round($data['RKAP_SDK']));
                array_push($result['data']['REAL'], round($data['REAL_SDK']));
                array_push($result['akumulasi']['REAL'], round($akumulasiREAL));
                array_push($result['akumulasi']['TARGET'], round($akumulasiRKAP));

                $result['prog'] = number_format($akumulasiREAL, 0, '', '.');
                $result['rkap'] = number_format($akumulasiRKAP, 0, '', '.');
                $result['persen'] = round($this->getPersen($result['prog'], $result['rkap']), 1);
                //array_push($result, $data);
            }
        } else if ($type == 'semen' || $type == 'terak') {
            if ($type == 'semen')
                $kode = '2';
            else
                $kode = '1';
            $result['tanggal'] = date("d-m-Y");
            $result['data']['REAL'] = array();
            $result['data']['PROG'] = array();
            $result['data']['TARGET'] = array();
            $result['data']['RADIUS'] = array();
            $result['data']['WARNA'] = array();
            $result['data']['TANGGAL'] = array();
            $result['data']['TARGET_KUM'] = array();
            $result['data']['REAL_KUM'] = array();
            $result['stok']['PROG'] = array();
            $result['stok']['MIN'] = array();
            $result['stok']['MAX'] = array();
            $result['stok']['LIMAPULUHPERSEN'] = array();
            if ($org == '0') {
                $data = $this->Demandpl_model->detailProdTahunan('7000', $tanggal, $kode);
                $dataSG2 = $this->Demandpl_model->detailProdTahunan('5000', $tanggal, $kode);
                $dataSP = $this->Demandpl_model->detailProdTahunan('3000', $tanggal, $kode);
                $dataST = $this->Demandpl_model->detailProdTahunan('4000', $tanggal, $kode);
                for ($i = 0; $i < count($data); $i++) {
                    foreach ($dataSP as $value) {
                        if ($data[$i]['BULAN'] == $value['BULAN']) {
                            $data[$i]['REALISASI_PROD'] += $value['REALISASI_PROD'];
                            $data[$i]['REALISASI_STOK'] += $value['REALISASI_STOK'];
                            $data[$i]['PROG_STOK'] += $value['PROG_STOK'];
                            $data[$i]['RKAP_PRODUK'] += $value['RKAP_PRODUK'];
                            $data[$i]['PROG_PRODUK'] += $value['PROG_PRODUK'];
                            $data[$i]['MAX_STOK'] += $value['MAX_STOK'];
                        }
                    }
                    foreach ($dataST as $value) {
                        if ($data[$i]['BULAN'] == $value['BULAN']) {
                            $data[$i]['REALISASI_PROD'] += $value['REALISASI_PROD'];
                            $data[$i]['REALISASI_STOK'] += $value['REALISASI_STOK'];
                            $data[$i]['PROG_STOK'] += $value['PROG_STOK'];
                            $data[$i]['RKAP_PRODUK'] += $value['RKAP_PRODUK'];
                            $data[$i]['PROG_PRODUK'] += $value['PROG_PRODUK'];
                            $data[$i]['MAX_STOK'] += $value['MAX_STOK'];
                        }
                    }
                    foreach ($dataSG2 as $value) {
                        if ($data[$i]['BULAN'] == $value['BULAN']) {
                            $data[$i]['REALISASI_PROD'] += $value['REALISASI_PROD'];
                            $data[$i]['REALISASI_STOK'] += $value['REALISASI_STOK'];
                            $data[$i]['PROG_STOK'] += $value['PROG_STOK'];
                            $data[$i]['RKAP_PRODUK'] += $value['RKAP_PRODUK'];
                            $data[$i]['PROG_PRODUK'] += $value['PROG_PRODUK'];
                            $data[$i]['MAX_STOK'] += $value['MAX_STOK'];
                        }
                    }
                }
            } else {
                if ($org == '7000') {
                    $data = $this->Demandpl_model->detailProdTahunan('7000', $tanggal, $kode);
                    $dataSG2 = $this->Demandpl_model->detailProdTahunan('5000', $tanggal, $kode);
                    for ($i = 0; $i < count($data); $i++) {

                        foreach ($dataSG2 as $value) {
                            if ($data[$i]['BULAN'] == $value['BULAN']) {
                                $data[$i]['REALISASI_PROD'] += $value['REALISASI_PROD'];
                                $data[$i]['REALISASI_STOK'] += $value['REALISASI_STOK'];
                                $data[$i]['PROG_STOK'] += $value['PROG_STOK'];
                                $data[$i]['RKAP_PRODUK'] += $value['RKAP_PRODUK'];
                                $data[$i]['PROG_PRODUK'] += $value['PROG_PRODUK'];
                                $data[$i]['MAX_STOK'] += $value['MAX_STOK'];
                            }
                        }
                    }
                } else {
                    $data = $this->Demandpl_model->detailProdTahunan($org, $tanggal, $kode);
                }
            }
            $target_kum = 0;
            $real_kum = 0;

            $prog_kum = 0;
            $rkap_kum = 0;
            $i = 0;
            foreach ($data as $value) {
                if ($value['BULAN'] <= date('m')) {
                    if ($value['BULAN'] == date('m')) {
                        array_push($result['data']['PROG'], round($value['PROG_PRODUK']));
                        array_push($result['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                        $real_kum += $value['PROG_PRODUK'];
                    } else {
                        $real_kum += $value['REALISASI_PROD'];
                        array_push($result['data']['PROG'], 0);
                        array_push($result['data']['WARNA'], 'rgba(255, 165, 0, 1)');
                    }
                    array_push($result['data']['REAL'], round($value['REALISASI_PROD']));

                    array_push($result['stok']['PROG'], round($value['REALISASI_STOK']));
                } else {
                    $real_kum += $value['PROG_PRODUK'];
                    array_push($result['data']['PROG'], round($value['PROG_PRODUK']));
                    array_push($result['data']['REAL'], 0);
                    array_push($result['stok']['PROG'], 0);
                    array_push($result['data']['WARNA'], 'rgba(75, 192, 192, 1)');
                }
                $target_kum += $value['RKAP_PRODUK'];

                array_push($result['data']['TARGET_KUM'], $target_kum);
                array_push($result['data']['REAL_KUM'], $real_kum);
                array_push($result['data']['TANGGAL'], $value['BULAN']);
                array_push($result['data']['TARGET'], round($value['RKAP_PRODUK']));
                array_push($result['stok']['MAX'], round($value['MAX_STOK']));
                array_push($result['stok']['LIMAPULUHPERSEN'], round($value['MAX_STOK'] / 2));

                $akurasi = $this->getAkurasiPrognose($org, $kode, $tanggal . sprintf("%02d", ($i + 1)));
                //var_dump($akurasi);

                $rkap_kum += str_replace('.', '', $akurasi['RKAP']);
                $prog_kum += str_replace('.', '', $akurasi['PROGNOSE']);

                $i++;
            }

            $result['akurasi'] = array(
                'PROGNOSE' => number_format($prog_kum, 0, '', '.'),
                'RKAP' => number_format($rkap_kum, 0, '', '.'),
                'PERSEN' => round($this->getPersen($prog_kum, $rkap_kum)));
        }
        echo json_encode($result);
    }

    function refresh_data() {

        $data = $this->Demandpl_model->refresh_mv();
        echo json_encode($data);
    }

}

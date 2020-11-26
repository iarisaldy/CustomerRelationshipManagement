<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Revenue extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Revenue_model');
    }

    function index() {
        $bulanlalu = date('m', strtotime('-1 month'));
        $bulanskrg = date('m');
        $data = array(
            'title' => 'Revenue',
            'bulanlalu' => $this->bulan[$bulanlalu],
            'bulanskrg' => $this->bulan[$bulanskrg],
        );
        $this->template->display('Revenue_view', $data);
    }

    function getDataTotal($date, $type) {
        set_time_limit(0);

        ####################### VOLUME ########################
        if ($type == '1') {
            $volSG = $this->Revenue_model->getTotalVolsdk('7000', $date);
//            echo $this->db->last_query();
            $volSG2 = $this->Revenue_model->getTotalVolsdk('5000', $date);
            $volSP = $this->Revenue_model->getTotalVolsdk('3000', $date);
            $volST = $this->Revenue_model->getTotalVolsdkTonasa('4000', $date);
            $volTLCC = $this->Revenue_model->getTotalVolTLCCsdk('6000', $date);
            $revSG = $this->Revenue_model->getTotalRevsdk('7000', $date);
//            echo $this->db->last_query();
            $revSG2 = $this->Revenue_model->getTotalRevsdk('5000', $date);
            $revSP = $this->Revenue_model->getTotalRevsdk('3000', $date);
            $revST = $this->Revenue_model->getTotalRevsdk('4000', $date);
            $revTLCC = $this->Revenue_model->getTotalRevTLCCsdk('6000', $date);
            $prcSG = $this->Revenue_model->getTotalPricesdk2('7000', $date);
//            echo $this->db->last_query();
            $prcSG2 = $this->Revenue_model->getTotalPricesdk2('5000', $date);
            $prcSP = $this->Revenue_model->getTotalPricesdk2('3000', $date);
            $prcST = $this->Revenue_model->getTotalPricesdk2('4000', $date);
            $prcTLCC = $this->Revenue_model->getTotalPricesdk2('6000', $date);
            //$prcTLCC = $this->prcTLCC;
        } else if ($type == '2') {
            $volSG = $this->Revenue_model->getDomestikVolsdk('7000', $date);
            $volSG2 = $this->Revenue_model->getDomestikVolsdk('5000', $date);
            $volSP = $this->Revenue_model->getDomestikVolsdk('3000', $date);
            $volST = $this->Revenue_model->getDomestikVolsdkTonasa('4000', $date);
            $volTLCC = $this->volTLCC;
            $revSG = $this->Revenue_model->getDomestikRevsdk('7000', $date);
            $revSG2 = $this->Revenue_model->getDomestikRevsdk('5000', $date);
            $revSP = $this->Revenue_model->getDomestikRevsdk('3000', $date);
            $revST = $this->Revenue_model->getDomestikRevsdk('4000', $date);
            $revTLCC = $this->revTLCC;
            $prcSG = $this->Revenue_model->getDomestikPricesdk2('7000', $date);
            $prcSG2 = $this->Revenue_model->getDomestikPricesdk2('5000', $date);
            $prcSP = $this->Revenue_model->getDomestikPricesdk2('3000', $date);
            $prcST = $this->Revenue_model->getDomestikPricesdk2('4000', $date);
            $prcTLCC = $this->prcTLCC;
        } else if ($type == '3') {
            $volSG = $this->Revenue_model->getEksporVolsdk('7000', $date);
            $volSG2 = $this->Revenue_model->getEksporVolsdk('5000', $date);
            $volSP = $this->Revenue_model->getEksporVolsdk('3000', $date);
            $volST = $this->Revenue_model->getEksporVolsdk('4000', $date);
            $volTLCC = $this->volTLCC;
            $revSG = $this->Revenue_model->getEksporRevsdk('7000', $date);
            $revSG2 = $this->Revenue_model->getEksporRevsdk('5000', $date);
            $revSP = $this->Revenue_model->getEksporRevsdk('3000', $date);
            $revST = $this->Revenue_model->getEksporRevSTsdk('4000', $date);
            $revTLCC = $this->revTLCC;
            $prcSG = $this->Revenue_model->getEksporPricesdk('7000', $date);
            $prcSG2 = $this->Revenue_model->getEksporPricesdk('5000', $date);
            $prcSP = $this->Revenue_model->getEksporPricesdk('3000', $date);
            $prcST = $this->Revenue_model->getEksporPricesdk('4000', $date);
            $prcTLCC = $this->prcTLCC;
        }

        ############### VOLUME ############
        $realBlnKmrn = $volSG['REAL_VOL_SDBK'] + $volSG2['REAL_VOL_SDBK'] + $volSP['REAL_VOL_SDBK'] + $volST['REAL_VOL_SDBK'] + $volTLCC['REAL_VOL_SDBK'];
        $progSisaBln = $volSG['PROGNOSE_SISABULAN'] + $volSG2['PROGNOSE_SISABULAN'] + $volSP['PROGNOSE_SISABULAN'] + $volST['PROGNOSE_SISABULAN'] + $volTLCC['PROGNOSE_SISABULAN'];
        $SMIG['REAL_VOL_SDK'] = $volSG['REAL_VOL'] + $volSG2['REAL_VOL'] + $volSP['REAL_VOL'] + $volST['REAL_VOL'] + $volTLCC['REAL_VOL'];
        $SMIG['RKAP_VOL_SDK'] = $volSG['RKAP_SDK'] + $volSG2['RKAP_SDK'] + $volSP['RKAP_SDK'] + $volST['RKAP_SDK'] + $volTLCC['RKAP_SDK'];
        $SMIG['PROG_VOL_BULAN'] = $SMIG['REAL_VOL_SDK'] + $volSG['PROGNOSE'] + $volSG2['PROGNOSE'] + $volSP['PROGNOSE'] + $volST['PROGNOSE'] + $volTLCC['PROGNOSE'];
        $SMIG['RKAP_VOL_BULAN'] = $volSG['RKAP_BULAN'] + $volSG2['RKAP_BULAN'] + $volSP['RKAP_BULAN'] + $volST['RKAP_BULAN'] + $volTLCC['RKAP_BULAN'];
        $SMIG['PROG_VOL_TAHUN'] = $realBlnKmrn + $progSisaBln;
        $SMIG['RKAP_VOL_TAHUN'] = $volSG['RKAP_TAHUN'] + $volSG2['RKAP_TAHUN'] + $volSP['RKAP_TAHUN'] + $volST['RKAP_TAHUN'] + $volTLCC['RKAP_TAHUN'];
        ############### REVENUE ############
        $realRevBlnKmrn = $revSG['REAL_REV_SDBK'] + $revSG2['REAL_REV_SDBK'] + $revSP['REAL_REV_SDBK'] + $revST['REAL_REV_SDBK'] + $revTLCC['REAL_REV_SDBK'];
        $progRevSisaBln = $revSG['PROGNOSE_SISABULAN'] + $revSG2['PROGNOSE_SISABULAN'] + $revSP['PROGNOSE_SISABULAN'] + $revST['PROGNOSE_SISABULAN'] + $revTLCC['PROGNOSE_SISABULAN'];
        $SMIG['REAL_REV_SDK'] = $revSG['REAL_REV'] + $revSG2['REAL_REV'] + $revSP['REAL_REV'] + $revST['REAL_REV'] + $revTLCC['REAL_REV'];
        $SMIG['RKAP_REV_SDK'] = $revSG['RKAP_SDK'] + $revSG2['RKAP_SDK'] + $revSP['RKAP_SDK'] + $revST['RKAP_SDK'] + $revTLCC['RKAP_SDK'];
        $SMIG['PROG_REV_BULAN'] = $SMIG['REAL_REV_SDK'] + $revSG['PROGNOSE'] + $revSG2['PROGNOSE'] + $revSP['PROGNOSE'] + $revST['PROGNOSE'] + $revTLCC['PROGNOSE'];
        $SMIG['RKAP_REV_BULAN'] = $revSG['RKAP_BULAN'] + $revSG2['RKAP_BULAN'] + $revSP['RKAP_BULAN'] + $revST['RKAP_BULAN'] + $revTLCC['RKAP_BULAN'];
        $SMIG['PROG_REV_TAHUN'] = $realRevBlnKmrn + $progRevSisaBln;
        $SMIG['RKAP_REV_TAHUN'] = $revSG['RKAP_TAHUN'] + $revSG2['RKAP_TAHUN'] + $revSP['RKAP_TAHUN'] + $revST['RKAP_TAHUN'] + $revTLCC['RKAP_TAHUN'];
        ############### PRICE ############
        $SMIG['REAL_PRICE_SDK'] = $this->getPrice($prcSG['REAL_PRICE'], $prcSP['REAL_PRICE'], $prcST['REAL_PRICE'], $prcTLCC['REAL_PRICE']);
        $SMIG['RKAP_PRICE_SDK'] = $this->getNilaiDibagi($SMIG['RKAP_REV_SDK'], $SMIG['RKAP_VOL_SDK']);
        $SMIG['PROG_PRICE_BULAN'] = $SMIG['REAL_PRICE_SDK'];
        $SMIG['RKAP_PRICE_BULAN'] = $this->getNilaiDibagi($SMIG['RKAP_REV_BULAN'], $SMIG['RKAP_VOL_BULAN']);
        $SMIG['PROG_PRICE_TAHUN'] = $SMIG['REAL_PRICE_SDK'];
        $SMIG['RKAP_PRICE_TAHUN'] = $this->getNilaiDibagi($SMIG['RKAP_REV_TAHUN'], $SMIG['RKAP_VOL_TAHUN']);
        //new price extend to BCS.SEMENINDONESIA.COM//
        if ($type != 3) {
            $SMIG['REAL_PRICE_SDK'] = $this->getNilaiDibagi($prcSG['REV'] + $prcSG2['REV'] + $prcSP['REV'] + $prcST['REV'] + $prcTLCC['REV'], $prcSG['QTY'] + $prcSG2['QTY'] + $prcSP['QTY'] + $prcST['QTY'] + $prcTLCC['QTY']);
        }
        ############### PERSEN ###########
        $SMIG['PERSEN_VOL_REAL_BULAN'] = $this->getPersen($SMIG['REAL_VOL_SDK'], $SMIG['RKAP_VOL_SDK']);
        $SMIG['PERSEN_VOL_PROG_BULAN'] = $this->getPersen($SMIG['PROG_VOL_BULAN'], $SMIG['RKAP_VOL_BULAN']);
        $SMIG['PERSEN_VOL_PROG_TAHUN'] = $this->getPersen($SMIG['PROG_VOL_TAHUN'], $SMIG['RKAP_VOL_TAHUN']);
        $SMIG['PERSEN_PRICE_REAL_BULAN'] = $this->getPersen($SMIG['REAL_PRICE_SDK'], $SMIG['RKAP_PRICE_SDK']);
        $SMIG['PERSEN_PRICE_PROG_BULAN'] = $this->getPersen($SMIG['PROG_PRICE_BULAN'], $SMIG['RKAP_PRICE_BULAN']);
        $SMIG['PERSEN_PRICE_PROG_TAHUN'] = $this->getPersen($SMIG['PROG_PRICE_TAHUN'], $SMIG['RKAP_PRICE_TAHUN']);
        $SMIG['PERSEN_REV_REAL_BULAN'] = $this->getPersen($SMIG['REAL_REV_SDK'], $SMIG['RKAP_REV_SDK']);
        $SMIG['PERSEN_REV_PROG_BULAN'] = $this->getPersen($SMIG['PROG_REV_BULAN'], $SMIG['RKAP_REV_BULAN']);
        $SMIG['PERSEN_REV_PROG_TAHUN'] = $this->getPersen($SMIG['PROG_REV_TAHUN'], $SMIG['RKAP_REV_TAHUN']);

//        echo '<pre>';
//        print_r($SMIG);
//        echo '</pre>';
        $tabel_incl = $this->getTable($SMIG, $date, $type);

        echo json_encode($tabel_incl);
    }

    function detailRevenue($date, $type) {
        if ($type == 1) {
            $detail = "SMIG Incl TLCC (Domestik)";
        } else if ($type == 2) {
            $detail = "SMIG Indonesia (Domestik)";
        } else if ($type == 3) {
            $detail = "SMIG Indonesia (Ekspor)";
        }
        $data = array(
            'title' => 'Detail Revenue',
            'tipe' => $type,
            'date' => $date,
            'detail' => $detail);
        $this->template->display('DetailRevenue_view', $data);
    }

    function getDetail($type, $date) {
        set_time_limit(0);
        if ($type == 1) {
            $dataSG = $this->getTotalBulanan('7000', $date);
           
            $dataSP = $this->getTotalBulanan('3000', $date);
           
            $dataST = $this->getTotalBulanan('4000', $date);
           
            $dataTLCC = $this->getTotalBulanan('6000', $date);
           
        } else if ($type == 2) {
            $dataSG = $this->Revenue_model->getDomestikBulanan('7000', $date);
            $dataSP = $this->Revenue_model->getDomestikBulanan('3000', $date);
            $dataST = $this->Revenue_model->getDomestikBulanan('4000', $date);
        } else if ($type == 3) {
            $dataSG = $this->Revenue_model->getEksporBulanan('7000', $date);
            $dataSP = $this->Revenue_model->getEksporBulanan('3000', $date);
            $dataST = $this->Revenue_model->getEksporBulanan('4000', $date);
        }
        $dataSMIG = array();
        $tabel_dom = '';
        $pembagi = array(
            "rkap_bulan" => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
            "rkap_harga" => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
            "harga" => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)
        );
        #### inisialisasi array ####
        foreach ($this->bulan as $key => $value) {
            $dataSMIG[$key]['KWANTUMX'] = 0;
            $dataSMIG[$key]['RKAP_BULAN'] = 0;
            $dataSMIG[$key]['HARGA'] = 0;
            $dataSMIG[$key]['RKAP_HARGA'] = 0;
            $dataSMIG[$key]['REVENUE'] = 0;
            $dataSMIG[$key]['RKAP_REVENUE'] = 0;
        }
        if (isset($dataSG) && count($dataSG > 1)) {
            foreach ($dataSG as $key => $value) {
                $dataSMIG[$value['BULAN']]['KWANTUMX'] = doubleval($value['KWANTUMX']);
                $dataSMIG[$value['BULAN']]['RKAP_BULAN'] = doubleval($value['RKAP_VOL_BULAN']);
                $dataSMIG[$value['BULAN']]['HARGA'] = doubleval($value['PRICE_REAL']);
                $dataSMIG[$value['BULAN']]['RKAP_HARGA'] = doubleval($value['RKAP_PRICE_BULAN']);
                $dataSMIG[$value['BULAN']]['REVENUE'] = doubleval($value['REAL_REV']);
                $dataSMIG[$value['BULAN']]['RKAP_REVENUE'] = doubleval($value['RKAP_REV_BULAN']);
                if (intval($value['RKAP_PRICE_BULAN']) != 0) {
                    $pembagi["rkap_harga"][$key] += 1;
                }
                if (intval($value['PRICE_REAL']) != 0) {
                    $pembagi["harga"][$key] += 1;
                }
            }
        }
        if (isset($dataSP) && count($dataSP > 1)) {
            foreach ($dataSP as $key => $value) {
                $dataSMIG[$value['BULAN']]['KWANTUMX'] += doubleval($value['KWANTUMX']);
                $dataSMIG[$value['BULAN']]['RKAP_BULAN'] += doubleval($value['RKAP_VOL_BULAN']);
                $dataSMIG[$value['BULAN']]['HARGA'] += doubleval($value['PRICE_REAL']);
                $dataSMIG[$value['BULAN']]['RKAP_HARGA'] += doubleval($value['RKAP_PRICE_BULAN']);
                $dataSMIG[$value['BULAN']]['REVENUE'] += doubleval($value['REAL_REV']);
                $dataSMIG[$value['BULAN']]['RKAP_REVENUE'] += doubleval($value['RKAP_REV_BULAN']);
                if (intval($value['RKAP_PRICE_BULAN']) != 0) {
                    $pembagi["rkap_harga"][$key] += 1;
                }
                if (intval($value['PRICE_REAL']) != 0) {
                    $pembagi["harga"][$key] += 1;
                }
            }
        }
        if (isset($dataST) && count($dataST > 1)) {
            foreach ($dataST as $key => $value) {
                $dataSMIG[$value['BULAN']]['KWANTUMX'] += doubleval($value['KWANTUMX']);
                $dataSMIG[$value['BULAN']]['RKAP_BULAN'] += doubleval($value['RKAP_VOL_BULAN']);
                $dataSMIG[$value['BULAN']]['HARGA'] += doubleval($value['PRICE_REAL']);
                $dataSMIG[$value['BULAN']]['RKAP_HARGA'] += doubleval($value['RKAP_PRICE_BULAN']);
                $dataSMIG[$value['BULAN']]['REVENUE'] += doubleval($value['REAL_REV']);
                $dataSMIG[$value['BULAN']]['RKAP_REVENUE'] += doubleval($value['RKAP_REV_BULAN']);
                if (intval($value['RKAP_PRICE_BULAN']) != 0) {
                    $pembagi["rkap_harga"][$key] += 1;
                }
                if (intval($value['PRICE_REAL']) != 0) {
                    $pembagi["harga"][$key] += 1;
                }
            }
        }
        if (isset($dataTLCC)) {
            foreach ($dataTLCC as $key => $value) {
                $dataSMIG[$value['BULAN']]['KWANTUMX'] += doubleval($value['KWANTUMX']);
                $dataSMIG[$value['BULAN']]['RKAP_BULAN'] += doubleval($value['RKAP_VOL_BULAN']);
                $dataSMIG[$value['BULAN']]['HARGA'] += doubleval($value['PRICE_REAL']);
                $dataSMIG[$value['BULAN']]['RKAP_HARGA'] += doubleval($value['RKAP_PRICE_BULAN']);
                $dataSMIG[$value['BULAN']]['REVENUE'] += doubleval($value['REAL_REV']);
                $dataSMIG[$value['BULAN']]['RKAP_REVENUE'] += doubleval($value['RKAP_REV_BULAN']);
                if (intval($value['RKAP_PRICE_BULAN']) != 0) {
                    $pembagi["rkap_harga"][$key] += 1;
                }
                if (intval($value['PRICE_REAL']) != 0) {
                    $pembagi["harga"][$key] += 1;
                }
            }
        }
        foreach ($dataSMIG as $key => $value) {
            $font = '';
            if ($date == date('Ym')) {
                if (intval($key) < intval(date('m'))) {
                    $font = 'font-biru';
                }
            } else {
                $font = 'font-hitam';
            }

            $harga = $this->getNilaiDibagi($value['HARGA'], $pembagi["harga"][$key - 1]);
            $rkap_harga = $this->getNilaiDibagi($value['RKAP_REVENUE'], $value['RKAP_BULAN']);
            $tabel_dom .= "<tr>
                        <td rowspan='3' style='vertical-align: middle;'>" . $this->bulan[$key] . "</td>
                        <td>Volume (ton)</td>
                        <td class='$font'>" . number_format($value['KWANTUMX'], 0, '', '.') . "</td>
                        <td class='$font'>" . number_format($value['RKAP_BULAN'], 0, '', '.') . "</td>
                        <td><span class='" . $this->warnaPersen($this->getPersen($value['KWANTUMX'], $value['RKAP_BULAN'])) . "'>&nbsp;" . number_format(($this->getPersen($value['KWANTUMX'], $value['RKAP_BULAN'])), 2, ',', '') . "&nbsp;</span></td>
                    </tr>
                    <tr>
                        <td>Price (Rp./ton)</td>
                        <td class='$font'>" . number_format($harga, 0, '', '.') . "</td>
                        <td class='$font'>" . number_format($rkap_harga, 0, '', '.') . "</td>
                        <td><span class='" . $this->warnaPersen($this->getPersen($harga, $rkap_harga)) . "'>&nbsp;" . number_format(($this->getPersen($harga, $rkap_harga)), 2, ',', '') . "&nbsp;</span></td>
                    </tr>
                    <tr class='border-bawah'>
                        <td>Revenue (Rp. M)</td>
                        <td class='$font'>" . number_format($value['REVENUE'] / 1000000, 0, '', '.') . "</td>
                        <td class='$font'>" . number_format($value['RKAP_REVENUE'] / 1000000, 0, '', '.') . "</td>
                        <td><span class='" . $this->warnaPersen($this->getPersen($value['REVENUE'] / 1000000, $value['RKAP_REVENUE'] / 1000000)) . "'>&nbsp;" . number_format($this->getPersen($value['REVENUE'] / 1000000, $value['RKAP_REVENUE'] / 1000000), 2, ',', '') . "&nbsp;</span></td>
                    </tr>";
        }


        echo json_encode($tabel_dom);
//        echo '<pre>';
//        print_r($dataSMIG);
//        echo '</pre>';
    }

    function detailOpco($org, $date) {
        if ($org == 7000) {
            $detail = "Semen Gresik";
        } else if ($org == 3000) {
            $detail = "Semen Padang";
        } else if ($org == 4000) {
            $detail = "Semen Tonasa";
        } else if ($org == 6000) {
            $detail = "Thang Long Cement";
        }
        $data = array(
            'title' => 'Detail Revenue ' . $detail,
            'org' => $org,
            'date' => $date,
            'detail' => $detail);
        $this->template->display('DetailRevOpco_view', $data);
    }

    function getDetailOpco($org, $date) {
        set_time_limit(0);
        //$date = date('Ym');
        if ($org == 7000) {
            $dataDom = $this->Revenue_model->getDomestikBulanan_v3($org, $date);
            $dataEks = $this->Revenue_model->getEksporBulanan($org, $date);
        } else if ($org == 3000) {
            $dataDom = $this->Revenue_model->getDomestikBulanan_v3($org, $date);
            $dataEks = $this->Revenue_model->getEksporBulanan($org, $date);
        } else if ($org == 4000) {
            $dataDom = $this->Revenue_model->getDomestikBulanan_v3($org, $date);
            $dataEks = $this->Revenue_model->getEksporBulanan($org, $date);
        } else if ($org == 6000) {
            $dataDom = $this->Revenue_model->getDomestikBulananTLCC($org, $date);
            $dataEks = $this->Revenue_model->getEksporBulanan($org, $date);
        }
        $tabel = '';
        $data = array();
        foreach ($this->bulan as $key => $value) {
            $data[$key]['DOM_KWANTUMX'] = 0;
            $data[$key]['DOM_RKAP_BULAN'] = 0;
            $data[$key]['DOM_HARGA'] = 0;
            $data[$key]['DOM_RKAP_HARGA'] = 0;
            $data[$key]['DOM_REV'] = 0;
            $data[$key]['DOM_RKAP_REV'] = 0;
            $data[$key]['EKS_KWANTUMX'] = 0;
            $data[$key]['EKS_RKAP_BULAN'] = 0;
            $data[$key]['EKS_HARGA'] = 0;
            $data[$key]['EKS_RKAP_HARGA'] = 0;
            $data[$key]['EKS_REV'] = 0;
            $data[$key]['EKS_RKAP_REV'] = 0;
        }

        if (isset($dataDom)) {
            foreach ($dataDom as $value) {
                $data[$value['BULAN']]['DOM_KWANTUMX'] = doubleval($value['KWANTUMX']);
                $data[$value['BULAN']]['DOM_RKAP_BULAN'] = doubleval($value['RKAP_VOL_BULAN']);
                $data[$value['BULAN']]['DOM_HARGA'] = doubleval($value['PRICE_REAL']);
                $data[$value['BULAN']]['DOM_RKAP_HARGA'] = doubleval($value['RKAP_PRICE_BULAN']);
                $data[$value['BULAN']]['DOM_REV'] = doubleval($value['REAL_REV']) / 1000000;
                $data[$value['BULAN']]['DOM_RKAP_REV'] = doubleval($value['RKAP_REV_BULAN']) / 1000000;
            }
        }

        if (isset($dataEks)) {
            foreach ($dataEks as $value) {
                $data[$value['BULAN']]['EKS_KWANTUMX'] = doubleval($value['KWANTUMX']);
                $data[$value['BULAN']]['EKS_RKAP_BULAN'] = doubleval($value['RKAP_VOL_BULAN']);
                $data[$value['BULAN']]['EKS_HARGA'] = doubleval($value['PRICE_REAL']);
                $data[$value['BULAN']]['EKS_RKAP_HARGA'] = doubleval($value['RKAP_PRICE_BULAN']);
                $data[$value['BULAN']]['EKS_REV'] = doubleval($value['REAL_REV']) / 1000000;
                $data[$value['BULAN']]['EKS_RKAP_REV'] = doubleval($value['RKAP_REV_BULAN']) / 1000000;
            }
        }
        //echo '<pre>';
        foreach ($data as $key => $value) {
            //print_r($value);
            //echo $value['DOM_HARGA'];

            $font = '';
            if ($date == date('Ym')) {
                if (intval($key) < intval(date('m'))) {
                    $font = 'font-biru';
                }
            } else {
                $font = 'font-hitam';
            }
            $tabel .= "<tr>
                        <td rowspan='3' style='vertical-align: middle;'>" . $this->bulan[$key] . "</td>
                        <td>Volume (ton)</td>
                        <td class='$font'>" . number_format($value['DOM_KWANTUMX'], 0, '', '.') . "</td>
                        <td class='$font'>" . number_format($value['DOM_RKAP_BULAN'], 0, '', '.') . "</td>
                        <td><span class='" . $this->warnaPersen($this->getPersen($value['DOM_KWANTUMX'], $value['DOM_RKAP_BULAN'])) . "'>&nbsp;" . number_format(($this->getPersen($value['DOM_KWANTUMX'], $value['DOM_RKAP_BULAN'])), 2, ',', '') . "&nbsp;</span></td>
                        <td class='$font'>" . number_format($value['EKS_KWANTUMX'], 0, '', '.') . "</td>
                        <td class='$font'>" . number_format($value['EKS_RKAP_BULAN'], 0, '', '.') . "</td>
                        <td><span class='" . $this->warnaPersen($this->getPersen($value['EKS_KWANTUMX'], $value['EKS_RKAP_BULAN'])) . "'>&nbsp;" . number_format(($this->getPersen($value['EKS_KWANTUMX'], $value['EKS_RKAP_BULAN'])), 2, ',', '') . "&nbsp;</span></td>
                    </tr>
                    <tr>
                        <td>Price (Rp./ton)</td>
                        <td class='$font'>" . number_format($value['DOM_HARGA'], 0, '', '.') . "</td>
                        <td class='$font'>" . number_format($value['DOM_RKAP_HARGA'], 0, '', '.') . "</td>
                        <td><span class='" . $this->warnaPersen($this->getPersen($value['DOM_HARGA'], $value['DOM_RKAP_HARGA'])) . "'>&nbsp;" . number_format(($this->getPersen($value['DOM_HARGA'], $value['DOM_RKAP_HARGA'])), 2, ',', '') . "&nbsp;</span></td>
                        <td class='$font'>" . number_format($value['EKS_HARGA'], 0, '', '.') . "</td>
                        <td class='$font'>" . number_format($value['EKS_RKAP_HARGA'], 0, '', '.') . "</td>
                        <td><span class='" . $this->warnaPersen($this->getPersen($value['EKS_HARGA'], $value['EKS_RKAP_HARGA'])) . "'>&nbsp;" . number_format(($this->getPersen($value['EKS_HARGA'], $value['EKS_RKAP_HARGA'])), 2, ',', '') . "&nbsp;</span></td>
                    </tr>
                    <tr class='border-bawah'>
                        <td>Revenue (Rp. juta)</td>
                        <td class='$font'>" . number_format($value['DOM_REV'], 0, '', '.') . "</td>
                        <td class='$font'>" . number_format($value['DOM_RKAP_REV'], 0, '', '.') . "</td>
                        <td><span class='" . $this->warnaPersen($this->getPersen($value['DOM_REV'], $value['DOM_RKAP_REV'])) . "'>&nbsp;" . number_format(($this->getPersen($value['DOM_REV'], $value['DOM_RKAP_REV'])), 2, ',', '') . "&nbsp;</span></td>
                        <td class='$font'>" . number_format($value['EKS_REV'], 0, '', '.') . "</td>
                        <td class='$font'>" . number_format($value['EKS_RKAP_REV'], 0, '', '.') . "</td>
                        <td><span class='" . $this->warnaPersen($this->getPersen($value['EKS_REV'], $value['EKS_RKAP_REV'])) . "'>&nbsp;" . number_format(($this->getPersen($value['EKS_REV'], $value['EKS_RKAP_REV'])), 2, ',', '') . "&nbsp;</span></td>
                    </tr>";
        }
        //echo '</pre>';
        echo json_encode($tabel);
//        echo '<pre>';
//        print_r($dataDom);
//        echo '</pre>';
//        echo '<pre>';
//        print_r($dataEks);
//        echo '</pre>';
    }

    function getTable($data, $date, $tipe) {
        if ($tipe == 1) {
            $judul = "SMIG Incl TLCC (Domestik)";
        } else if ($tipe == 2) {
            $judul = "SMIG Indonesia (Domestik)";
        } else if ($tipe == 3) {
            $judul = "SMIG Indonesia (Ekspor)";
        }
        $tabel = "<tr>
                        <td rowspan='3' style='vertical-align: middle;'>" . $judul . "</td>
                        <td>Volume (ton)</td>
                        <td>" . number_format($data['REAL_VOL_SDK'], 0, '', '.') . "</td>
                        <td>" . number_format($data['RKAP_VOL_SDK'], 0, '', '.') . "</td>
                        <td class='" . $this->warnaPersen($data['PERSEN_VOL_REAL_BULAN']) . "'>" . number_format(($data['PERSEN_VOL_REAL_BULAN']), 2, ',', '') . "</td>
                        <td>" . number_format($data['PROG_VOL_BULAN'], 0, '', '.') . "</td>
                        <td>" . number_format($data['RKAP_VOL_BULAN'], 0, '', '.') . "</td>
                        <td class='" . $this->warnaPersen($data['PERSEN_VOL_PROG_BULAN']) . "'>" . number_format(($data['PERSEN_VOL_PROG_BULAN']), 2, ',', '') . "</td>
                        <td>" . number_format($data['PROG_VOL_TAHUN'], 0, '', '.') . "</td>
                        <td>" . number_format($data['RKAP_VOL_TAHUN'], 0, '', '.') . "</td>
                        <td class='" . $this->warnaPersen($data['PERSEN_VOL_PROG_TAHUN']) . "'>" . number_format(($data['PERSEN_VOL_PROG_TAHUN']), 2, ',', '') . "</td>
                        <td rowspan='3' style='vertical-align: middle;text-align: center;'><a class='btn btn-info btn-xs' href='" . base_url() . "smigroup/Revenue/detailRevenue/" . $date . "/" . $tipe . "' target='_blank'><i class='fa fa-list'></i> Detail</a></td>
                    </tr>
                    <tr>
                        <td>Price (Rp./ton)</td>
                        <td>" . number_format($data['REAL_PRICE_SDK'], 0, '', '.') . "</td>
                        <td>" . number_format($data['RKAP_PRICE_SDK'], 0, '', '.') . "</td>
                        <td class='" . $this->warnaPersen($data['PERSEN_PRICE_REAL_BULAN']) . "'>" . number_format(($data['PERSEN_PRICE_REAL_BULAN']), 2, ',', '') . "</td>
                        <td>" . number_format($data['PROG_PRICE_BULAN'], 0, '', '.') . "</td>
                        <td>" . number_format($data['RKAP_PRICE_BULAN'], 0, '', '.') . "</td>
                        <td class='" . $this->warnaPersen($data['PERSEN_PRICE_PROG_BULAN']) . "'>" . number_format(($data['PERSEN_PRICE_PROG_BULAN']), 2, ',', '') . "</td>
                        <td>" . number_format($data['PROG_PRICE_TAHUN'], 0, '', '.') . "</td>
                        <td>" . number_format($data['RKAP_PRICE_TAHUN'], 0, '', '.') . "</td>
                        <td class='" . $this->warnaPersen($data['PERSEN_PRICE_PROG_TAHUN']) . "'>" . number_format(($data['PERSEN_PRICE_PROG_TAHUN']), 2, ',', '') . "</td>
                    </tr>
                    <tr class='border-bawah'>
                        <td>Revenue (Rp. juta)</td>
                        <td>" . number_format($data['REAL_REV_SDK'] / 1000000, 0, '', '.') . "</td>
                        <td>" . number_format($data['RKAP_REV_SDK'] / 1000000, 0, '', '.') . "</td>
                        <td class='" . $this->warnaPersen($data['PERSEN_REV_REAL_BULAN']) . "'>" . number_format(($data['PERSEN_REV_REAL_BULAN']), 2, ',', '') . "</td>
                        <td>" . number_format($data['PROG_REV_BULAN'] / 1000000, 0, '', '.') . "</td>
                        <td>" . number_format($data['RKAP_REV_BULAN'] / 1000000, 0, '', '.') . "</td>
                        <td class='" . $this->warnaPersen($data['PERSEN_REV_PROG_BULAN']) . "'>" . number_format(($data['PERSEN_REV_PROG_BULAN']), 2, ',', '') . "</td>
                        <td>" . number_format($data['PROG_REV_TAHUN'] / 1000000, 0, '', '.') . "</td>
                        <td>" . number_format($data['RKAP_REV_TAHUN'] / 1000000, 0, '', '.') . "</td>
                        <td class='" . $this->warnaPersen($data['PERSEN_REV_PROG_TAHUN']) . "'>" . number_format(($data['PERSEN_REV_PROG_TAHUN']), 2, ',', '') . "</td>
                    </tr>";
        return $tabel;
    }

    function getTotalBulanan($org, $date) {
         $dataEkspor = array();
        if ($org != '6000') {
            $dataDomestik = $this->Revenue_model->getDomestikBulanan_v3($org, $date);
            
            //$dataEkspor = $this->Revenue_model->getEksporBulanan($org, $date);
            
            //echo $this->db->last_query();
        } else {
            $dataDomestik = $this->Revenue_model->getDomestikBulananTLCC('6000', $date);
            
           // $dataEkspor = $this->Revenue_model->getEksporBulanan('6000', $date);
        }
        $dataTotal = $dataDomestik;
        //var_dump($dataDomestik);
        //echo 'next';
        foreach ($dataTotal as $key => $value) {
            foreach ($dataEkspor as $keyE => $valE) {
                if ($value['BULAN'] == $valE['BULAN']) {
                    $dataTotal[$key]['KWANTUMX'] += doubleval($valE['KWANTUMX']);
                    $dataTotal[$key]['RKAP_VOL_BULAN'] += doubleval($valE['RKAP_VOL_BULAN']);
                    $dataTotal[$key]['PRICE_REAL'] += doubleval($valE['PRICE_REAL']);
                    $dataTotal[$key]['RKAP_PRICE_BULAN'] += doubleval($valE['RKAP_PRICE_BULAN']);
                    $dataTotal[$key]['RKAP_REV_BULAN'] += doubleval($valE['RKAP_REV_BULAN']);
                    $dataTotal[$key]['REAL_REV'] += doubleval($valE['REAL_REV']);
                   
                }
            }
        }
        
       // var_dump($dataTotal);
        return $dataTotal;
    }

    function getPersen($a, $b) {
        if ($b == 0 || $b == '') {
            return 0;
        } else {
            return $a / $b * 100;
        }
    }

    function getNilaiDibagi($a, $b) {
        if ($b == 0 || $b == '') {
            return 0;
        } else {
            return $a / $b;
        }
    }

    function getPrice($a, $b, $c, $d) {
        $n = 0;
        $prcTotal = 0;
        if ($a != 0) {
            $n++;
            $prcTotal += $a;
        }
        if ($b != 0) {
            $n++;
            $prcTotal += $b;
        }
        if ($c != 0) {
            $n++;
            $prcTotal += $c;
        }
        if ($d != 0) {
            $n++;
            $prcTotal += $d;
        }
        if ($n == 0) {
            $avgPrc = 0;
        } else {
            $avgPrc = $prcTotal / $n;
        }
        return $avgPrc;
    }

    function warnaPersen($persen) {
        if ($persen < 90) {
            return 'label-merah';
        } else if ($persen >= 90 && $persen < 100) {
            return 'label-kuning';
        } else {
            return 'label-hijau';
        }
    }

    private $bulan = array(
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
    private $volTLCC = array(
        "REAL_VOL" => 0,
        "PROGNOSE" => 0,
        "RKAP_SDK" => 0,
        "RKAP_BULAN" => 0,
        "PROGNOSE_SISABULAN" => 0,
        "RKAP_TAHUN" => 0,
        "REAL_VOL_SDBK" => 0
    );
    private $revTLCC = array(
        "REAL_REV" => 0,
        "PROGNOSE" => 0,
        "RKAP_SDK" => 0,
        "RKAP_BULAN" => 0,
        "PROGNOSE_SISABULAN" => 0,
        "RKAP_TAHUN" => 0,
        "REAL_REV_SDBK" => 0
    );
    private $prcTLCC = array(
        "REAL_PRICE" => 0,
        "RKAP_PRICE_BULAN" => 0,
        "RKAP_PRICE_TAHUN" => 0,
        "REV" => 0,
        "QTY" => 0
    );
    private $harga = array("HARGA" => 0, "RKAP_HARGA" => 0);

    function test() {
        //echo date('m', strtotime('-2 month'));
//        $data = array();
        $date = "201702";
        $org = '4000';
//        $hargaSG = $this->Revenue_model->getTotalHargaNetSGsdk($date);
//        $hargaSP = $this->Revenue_model->getTotalHargaNetSPsdk($date);
//        $hargaST = $this->Revenue_model->getTotalHargaNetSTsdk($date);
//        $hargaTLCC = $this->Revenue_model->getTotalHargaNetTLCCsdk($date);
        $data = $this->Revenue_model->getEksporBulanan($org, $date);

        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
    
     function graph() {
        $data = array(
            'title' => 'Grafik Revenue',
            'bulan' => array(
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember'
            )
        );
        $this->template->display('GrafikRevenue', $data);
    }

    function getDataGraph($date = '', $filter = '') {

        $company = array(
            '3000' => 'SP',
            '4000' => 'ST',
            '5000' => 'SG',
            '6000' => 'TLCC',
            '7000' => 'KSO-SG'
        );
        $colorComp = array('3000' => '#7cb5ec', '4000' => '#f7a35c', '5000' => '#56bca7', '6000' => '#eeaaee', '7000' => '#7798BF');
        $colorRKAP = array('#ff0066', '#55BF3B');
        $colorRKAPC = array('3000' => '#36618a', '4000' => '#c45a00', '5000' => '#578a4d', '6000' => '#5b6a7c', '7000' => '#a155a1');
        $date = empty($date) ? date('Ym') : $date;
        $filter = empty($filter) ? 'all' : $filter;
        $this->load->model('GrafikRevenue_model');
        $data = $this->GrafikRevenue_model->monitoring_harian($date, $filter);
        $stacked_data = array();
        $stacked = array();
        $stacked_ak = array();
        $tanggal = array();
        $akumulasi = array();
        $akumulasi_val = array();
        $target = array();
        $target_ak = array();
        $target_ak_val = 0;
        $color = array(
            '3000' => '#b6dbff',
            '4000' => '#ffc99c',
            '5000' => '#c9ffbf',
            '6000' => '#92baea',
            '7000' => '#ffd4ff');
//        $stacked_data['PROGNOSE'] = array(
//            'type' => 'column',
//            'name' => 'PROGNOSE',
//            'color' => '#aaeeee',
//            'data' => array(),
//            'pointPadding' => 0,
//            'pointPlacement' => 0,
//        );
        foreach ($data as $key => $value) {
            if (!isset($stacked_data[$value['VKORG']])) {
                $stacked_data[$value['VKORG']] = array(
                    'type' => 'column',
                    'stacking' => 'normal',
                    'name' => $company[$value['VKORG']],
                    'color' => $colorComp[$value['VKORG']],
                    // 'pointPadding' => 0.24,
                    'pointPadding' => 0.15,
                    'pointPlacement' => 0,
                    'data' => array(),
                );
                $stacked_data['RKAP' . $value['VKORG']] = array(
                    'type' => 'line',
                    'color' => $colorRKAPC[$value['VKORG']],
                    'name' => 'RKAP ' . $company[$value['VKORG']],
                    'visible' => false,
                    'data' => array(),
                );
                $akumulasi[$value['VKORG']] = array(
                    'type' => 'column',
                    'stacking' => 'normal',
                    'color' => $colorComp[$value['VKORG']],
                    'name' => $company[$value['VKORG']],
                    'pointPadding' => 0.15,
                    'pointPlacement' => 0,
                    'data' => array(),
                );

                $akumulasi['RKAP' . $value['VKORG']] = array(
                    'type' => 'line',
                    'color' => $colorRKAPC[$value['VKORG']],
                    'name' => 'RKAP ' . $company[$value['VKORG']],
                    'visible' => false,
                    'data' => array(),
                );

                $akumulasi_val[$value['VKORG']] = 0;
                $akumulasi_val['RKAP' . $value['VKORG']] = 0;
            }
            if (!isset($target[$value['TGL2']])) {
                $target[$value['TGL2']] = 0;
                $target_ak[$value['TGL2']] = 0;
            }


            $target[$value['TGL2']] += $value['TARGET'];
            if (substr($date, 0, 4) == date('Y') && (substr($date, 4, 2) == date('m') && $value['TGL2'] < date('d') || substr($date, 4, 2) < date('m')) || substr($date, 0, 4) < date('Y')) {
                $akumulasi_val[$value['VKORG']] += floatval($value['REV']);
                array_push($akumulasi[$value['VKORG']]['data'], $akumulasi_val[$value['VKORG']]);
            } else {

                $akumulasi_val[$value['VKORG']] += floatval($value['TARGET']);
//                array_push($akumulasi[$value['VKORG']]['data'], array('y' => $akumulasi_val[$value['VKORG']], 'color' => $color[$value['VKORG']]));
                array_push($akumulasi[$value['VKORG']]['data'], array('y' => 0, 'color' => $color[$value['VKORG']]));
            }
            $akumulasi_val['RKAP' . $value['VKORG']] += floatval($value['TARGET']);
            array_push($akumulasi['RKAP' . $value['VKORG']]['data'], $akumulasi_val['RKAP' . $value['VKORG']]);

            array_push($stacked_data[$value['VKORG']]['data'], floatval($value['REV']));
            array_push($stacked_data['RKAP' . $value['VKORG']]['data'], floatval($value['TARGET']));


            if (!in_array($value['TGL2'], $tanggal)) {
                array_push($tanggal, $value['TGL2']);
            }
        }

        $stacked_data['RKAP'] = array(
            'type' => 'line',
            'name' => 'RKAP',
            'color' => $colorRKAP[0],
            'data' => array(),
        );
        $akumulasi['RKAP'] = array(
            'type' => 'line',
            'name' => 'RKAP',
            'color' => $colorRKAP[0],
            'data' => array(),
        );

        foreach ($target as $key => $value) {
            $target_ak_val += floatval($value);
//            if (substr($date, 4, 2) == date('m') && $key < date('d') || substr($date, 4, 2) < date('m')) {
//                array_push($stacked_data['PROGNOSE']['data'], 0);
//            } else {
//                array_push($stacked_data['PROGNOSE']['data'], round($value));
//            }
            array_push($stacked_data['RKAP']['data'], floatval($value));
            array_push($akumulasi['RKAP']['data'], floatval($target_ak_val));
        }
        foreach ($stacked_data as $key => $value) {
            array_push($stacked, $value);
        }
        foreach ($akumulasi as $key => $value) {
            array_push($stacked_ak, $value);
        }

        $pencBulan = $this->GrafikRevenue_model->getPencapaian($date, $filter);
        $pencB = array(
            array(
                'name' => 'RKAP',
                'color' => '#ffc1c1',
                'data' => array(floatval($pencBulan['RKAP'])),
                'pointPadding' => 0.3
            ),
            array(
                'name' => 'REAL REV',
                'color' => '#56bca7',
                'data' => array(floatval($pencBulan['REV'])),
                'pointPadding' => 0.4
            )
        );

        echo json_encode(array(
            'stacked' => $stacked,
            'stacked_ak' => $stacked_ak,
            'tanggal' => $tanggal,
            'pencapaian' => $pencB,
            'date' => $date
        ));
    }

    public function getDataGraphCompare($year1 = '', $year2 = '', $filter = '') {

        $company = array(
            '3000' => 'SP',
            '4000' => 'ST',
            '5000' => 'SG',
            '6000' => 'TLCC',
            '7000' => 'KSO-SG'
        );
        $colorComp = array('3000' => '#7cb5ec', '4000' => '#f7a35c', '5000' => '#56bca7', '6000' => '#eeaaee', '7000' => '#7798BF');
        $colorRKAP = array('#ff0066', '#55BF3B');
        $year1 = empty($year1) ? date('Y') - 1 : $year1;
        $year2 = empty($year2) ? date('Y') : $year2;
        $this->load->model('GrafikRevenue_model');
        $data[0] = $this->GrafikRevenue_model->monitoring_tahunan($year1, $filter);

        $data[1] = $this->GrafikRevenue_model->monitoring_tahunan($year2, $filter);

        $stacked_data = array();
        $stacked = array();
        $akumulasi = array();
        $target = array();
        $bulan = array();
        $year = array();
        $stacked_ak = array();
        $akumulasi_val = array();
        $target_ak = array();
        $akumulasi_val = array();
        $target_ak_val = array();

        foreach ($data as $key => $datas) {
            $stacked_data[$key] = array();
            $target[$key] = array();
            $bulan[$key] = array();
            $akumulasi_val[$key] = array();
            $akumulasi[$key] = array();
            foreach ($datas as $key1 => $value) {
                $year[$key] = $value['THN'];
                if (!isset($stacked_data[$key][$value['ORG']])) {
                    $stacked_data[$key][$value['ORG']] = array(
                        'stacking' => 'normal',
                        'name' => $company[$value['ORG']] . ' ' . $value['THN'],
                        'stack' => $value['THN'],
                        'grouping' => true,
                        'color' => $colorComp[$value['ORG']],
                        'borderWidth' => 1,
                        'data' => array()
                    );
                    $akumulasi[$key][$value['ORG']] = array(
                        'stacking' => 'normal',
                        'name' => $company[$value['ORG']] . ' ' . $value['THN'],
                        'stack' => $value['THN'],
                        'grouping' => true,
                        'color' => $colorComp[$value['ORG']],
                        'borderWidth' => 1,
                        'data' => array()
                    );
                    $akumulasi_val[$key][$value['ORG']] = 0;
                }


                $akumulasi_val[$key][$value['ORG']] += floatval($value['REV']);
                if (date('Y') == $value['THN'] && $value['BLN'] <= date('mm') || date('Y') > $value['THN']) {
                    array_push($akumulasi[$key][$value['ORG']]['data'], $akumulasi_val[$key][$value['ORG']]);
                }

                array_push($stacked_data[$key][$value['ORG']]['data'], floatval($value['REV']));
                if (!isset($target[$key][$value['BLN']])) {
                    $target[$key][$value['BLN']] = 0;
                }
                $target[$key][$value['BLN']] += $value['RKAP'];
                if (!in_array($value['BLN'], $bulan[$key])) {
                    array_push($bulan[$key], $value['BLN']);
                }
            }
        }

        $rkap = array();
        $rkap_ak = array();
        foreach ($stacked_data as $key => $value) {
            $target_ak_val[$key] = 0;
            $rkap[$key] = array(
                'color' => $colorRKAP[$key],
                'type' => 'line',
                'name' => 'RKAP ' . $year[$key],
                'data' => array(),
            );
            $rkap_ak[$key] = array(
                'color' => $colorRKAP[$key],
                'type' => 'line',
                'name' => 'RKAP ' . $year[$key],
                'data' => array(),
            );
            foreach ($target[$key] as $value) {
                $target_ak_val[$key] += $value;
                array_push($rkap_ak[$key]['data'], $target_ak_val[$key]);
                array_push($rkap[$key]['data'], $value);
            }
            foreach ($akumulasi[$key] as $value) {
                array_push($stacked_ak, $value);
            }
            foreach ($stacked_data[$key] as $value) {
                array_push($stacked, $value);
            }
        }
        foreach ($rkap as $key => $value) {
            array_push($stacked, $value);
            array_push($stacked_ak, $rkap_ak[$key]);
        }

        $pencTahun = $this->GrafikRevenue_model->getPencapaianTahun($year2, $filter);
        //echo $this->db->last_query();
        $pencT = array(
            array(
                'name' => 'RKAP',
                'color' => '#ffc1c1',
                'data' => array(floatval($pencTahun['RKAP'])),
                'pointPadding' => 0.3
            ),
            array(
                'name' => 'REAL REV',
                'color' => '#56bca7',
                'data' => array(floatval($pencTahun['REV'])),
                'pointPadding' => 0.4
            )
        );

        $bulan = COUNT($bulan[0]) > COUNT($bulan[0]) ? $bulan[0] : $bulan[1];

        echo json_encode(array(
            'BULAN' => $bulan,
            'STACKED' => $stacked,
            'STACKED_AK' => $stacked_ak,
            'PENCAPAIAN' => $pencT,
            'YEAR' => $year2
        ));
    }

    function updatePenc($type) {
        $this->load->model('GrafikRevenue_model');
        $comp = $this->input->post('company');
        $date = $this->input->post('date');
        $filter = $this->input->post('filter');
        if ($type == 'bulan') {
            
            $pencapaian = $this->GrafikRevenue_model->getPencapaian($date, $filter, $comp);
        } else if($type == 'tahun'){
            $pencapaian = $this->GrafikRevenue_model->getPencapaianTahun($date, $filter, $comp);
        }
        $penc = array(
            array(
                'name' => 'RKAP',
                'color' => '#ffc1c1',
                'data' => array(floatval($pencapaian['RKAP'])),
                'pointPadding' => 0.3
            ),
            array(
                'name' => 'REAL REV',
                'color' => '#56bca7',
                'data' => array(floatval($pencapaian['REV'])),
                'pointPadding' => 0.4
            )
        );
        echo json_encode(array(
            'penc' => $penc,
            'date' => $date
        ));
    }

}

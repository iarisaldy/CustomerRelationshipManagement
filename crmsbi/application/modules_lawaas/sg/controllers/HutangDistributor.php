<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class HutangDistributor extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');

        date_default_timezone_set("Asia/Jakarta");
    }

    function index() {
        $data = array('title' => 'Semen Gresik');
        $this->template->display('HutangDistributor_view', $data);
    }

    function getData() {
        $comp = 7000;
        $this->load->model("HutangDistributor_model");
//        $data = array(
//            "KODE" => array('0000000215','0000000147'),
//            "NAMA" => array('BIG','JAWA','BCS')
//        )
        $result = array();
        $data = $this->HutangDistributor_model->getCustomer($comp);

        $rowBag = '';
        $rowBulk = '';
        $rowICS = '';
        foreach ($data as $key => $value) {
            $kredit = $this->getKredit($comp, $value['KUNNR'], 'kredit');
            $sisa = $this->getKredit($comp, $value['KUNNR'], 'sisa');
            $aging = $this->getAging($comp, $value['KUNNR'], 'future');
            if ($value['JENIS'] == '121-301') {
                $rowBag .= "<tr><td>" . $value['NAME1'] . "</td>" .
                        "<td>" . number_format(($value['KWANTUMX']), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($value['SISA_QTY']), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($kredit / 10000), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($sisa / 10000), 0, ',', '.') . "</td>" .
                        "<td>" . number_format($aging['future'], 0, ',', '.') . "</td>" .
                        "<td>" . number_format($aging['due5'], 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($aging['due10']), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($aging['due15']), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($aging['due20']), 0, ',', '.') . "</td></tr>";
            } else if ($value['JENIS'] == '121-302') {
                $rowBulk .= "<tr><td>" . $value['NAME1'] . "</td>" .
                        "<td>" . number_format(($value['KWANTUMX']), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($value['SISA_QTY']), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($kredit / 10000), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($sisa / 10000), 0, ',', '.') . "</td>" .
                        "<td>" . number_format($aging['future'], 0, ',', '.') . "</td>" .
                        "<td>" . number_format($aging['due5'], 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($aging['due10']), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($aging['due15']), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($aging['due20']), 0, ',', '.') . "</td></tr>";
            } else if ($value['JENIS'] == 'ICS') {
                $rowICS .= "<tr><td>" . $value['NAME1'] . "</td>" .
                        "<td>" . number_format(($value['KWANTUMX']), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($value['SISA_QTY']), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($kredit / 10000), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($sisa / 10000), 0, ',', '.') . "</td>" .
                        "<td>" . number_format($aging['future'], 0, ',', '.') . "</td>" .
                        "<td>" . number_format($aging['due5'], 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($aging['due10']), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($aging['due15']), 0, ',', '.') . "</td>" .
                        "<td>" . number_format(($aging['due20']), 0, ',', '.') . "</td></tr>";
            }
        }
        
        //get Data ARMADA & STOK
        $armada = $this->HutangDistributor_model->getPosisiArmada();
        
        $rowarmada = '<tr>'.
                    '<td>'.number_format(($armada['CARGO_ZAK_30']),0,',','.').'</td>'.
                    '<td>'.number_format(($armada['DAFTAR_ZAK_10']+$armada['DAFTAR_ZAK_20']),0,',','.').'</td>'.
                    '<td>'.number_format(($armada['ALAMAT_ZAK_40']),0,',','.').'</td>'.
                    '<td>'.number_format(($armada['ALAMAT_CURAH_10']),0,',','.').'</td>'.
                    '<td>'.number_format(($armada['CONV_ZAK_50']),0,',','.').'</td>'.
                    '<td>'.number_format(($armada['CONV_CURAH_40']),0,',','.').'</td>'.
                    '<td>'.number_format(($armada['SPJ_ZAK_70']),0,',','.').'</td>'.
                    '<td>'.number_format(($armada['SPJ_CURAH_70']),0,',','.').'</td>'.
                '</tr>';
        
        $stok = $this->HutangDistributor_model->getStok();
        
        $rowstok = '<tr>'.
                    '<td colspan="2">'.number_format(($stok['SILO_PPC']),0,',','.').'</td>'.
                    '<td colspan="2">'.number_format(($stok['SILO_PPC']),0,',','.').'</td>'.
                    '<td colspan="2">'.number_format(($stok['SILO_KHUSUS']),0,',','.').'</td>'.
                    '<td colspan="2">'.number_format(($stok['SILO_PPC']+$stok['SILO_PPC']+$stok['SILO_KHUSUS']),0,',','.').'</td>'.
                    
                '</tr>';
        
        echo json_encode(array(
            'bag' => $rowBag,
            'bulk' => $rowBulk,
            'ics' => $rowICS,
            'armada' => $rowarmada,
            'stok' => $rowstok
        ));
    }

    function getKredit($vkorg, $kunag, $tipe) {

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

        $fce = $sap->NewFunction("Z_CREDIT_EXPOSURE");
        if ($fce == false) {
            $sap->PrintStatus();
            exit;
        }

        if ($vkorg == '2000' || $vkorg == '7000' || $vkorg == '5000') {
            $vkorg = '2000';
        }
        $fce->X_KKBER = $vkorg;
        $fce->X_KUNNR = $kunag;

        $fce->Call();

        if ($tipe == 'sisa')
            return $fce->Z_DELTA_TO_LIMIT;
        else if ($tipe == 'kredit')
            return $fce->Z_CREDITLIMIT;
        else
            return "";
    }

    function getAging($vkorg, $kunag, $tipe) {
        $this->load->library('Sap');
        $sap = new SAPConnection();
        $sap->Connect("include/logon_data.conf");


        if ($sap->GetStatus() == SAPRFC_OK) //$sap->Open ();
            $sap->Open();
        if ($sap->GetStatus() != SAPRFC_OK) {
            $sap->PrintStatus();
            exit;
        }

        $fce = $sap->NewFunction("Z_ZAPPSD_AR_AGING");
        if ($fce == false) {
            $sap->PrintStatus();
            exit;
        }

        $fce->I_DATE = date('Ymd');
        $fce->I_BUKRS = $vkorg;
        $fce->I_KUNNR = $kunag;

        $fce->Call();

        $fce->T_AGING->Reset();
        $fce->T_AGING->Next();

        return array("current" => ($fce->T_AGING->row['TOTAL'] / 1000000),
            "future" => ($fce->T_AGING->row['FUTURE'] / 1000000),
            "due5" => ($fce->T_AGING->row['DUE5'] / 1000000),
            "due10" => ($fce->T_AGING->row['DUE10'] / 1000000),
            "due15" => ($fce->T_AGING->row['DUE15'] / 1000000),
            "due20" => ($fce->T_AGING->row['DUE20'] / 1000000));
    }

}

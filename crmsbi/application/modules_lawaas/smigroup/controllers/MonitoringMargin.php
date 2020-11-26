<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class MonitoringMargin extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        date_default_timezone_set("Asia/Jakarta");
//        $this->load->model('Demandpl_model');
//        $this->load->model('DemandplMS_model');
        set_time_limit(0);
    }

    public function index() {
        $data = array('title' => 'Sales & Operations Planning');
        $this->template->display('MonitoringMargin_view', $data);
    }

    function scodata($region, $tahun, $bulan) {
        $this->load->model('MonitoringMargin_model');
        date_default_timezone_set("Asia/Jakarta");
//        $tahun = date("Y");
//        $bulan = date("m");
        $date = $tahun . '' . $bulan;
        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad( --$hari, 2, '0', STR_PAD_LEFT) : $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        switch ($region) {
            case '1' :
                $subCap = 'Bag/Curah All Sumatera';
                break;
            case '2' :
                $subCap = 'Bag All Jawa Bali';
                break;
            case '3' :
                $subCap = 'Bag/Curah All Kalimantan, Sulawesi, Nusra, Ind. Timur';
                break;
            case '4' :
                $subCap = 'All Jawa & Bali';
                break;
            case '5' :
                $region = "1,2,3,4";
                $subCap = 'All Bag/Curah';
                break;
            default:
                $subCap = '';
                break;
        }

        $arrData = array(
            "chart" => array(
                "caption" => "Realisasi Revenue by Regional Terhadap RKAP s/d " . $hari . " " . $this->bulan($bulan) . " " . $tahun,
                "subcaption" => $subCap,
                "subcaptionFontSize" => 11,
                "theme" => "fint",
                "formatNumberScale" => "0",
                "numberSuffix" => "%",
                "showLabels" => "1",
                "includeNameInLabels" => "1",
                "nullEntityColor" => "#C2C2D6",
                "nullEntityAlpha" => "50",
                "hoverOnNull" => "0",
                "useSNameInLabels" => "1",
                "legendPosition" => "bottom",
                "showToolTip" => "1",
                "baseFontSize" => "14",
                "legendItemFontColor" => "#000",
                "toolTipBgColor" => "#E0E0E0"
            ),
            "colorrange" => array(
                "color" => array(
                    array(
                        "minvalue" => "0",
                        "maxvalue" => "1",
                        "code" => "#edebeb",
                        "displayValue" => "-"
                    ),
                    array(
                        "minvalue" => "1",
                        "maxvalue" => "90",
                        "code" => "#ff4545",
                        "displayValue" => "< 90%"
                    ),
                    array(
                        "minvalue" => "90",
                        "maxvalue" => "100",
                        "code" => "#fef536",
                        "displayValue" => "90%-100%"
                    ),
                    array(
                        "minvalue" => "100",
                        "maxvalue" => "1000000",
                        "code" => "#49ff56",
                        "displayValue" => "> 100%"
                    )
                )
            ),
            "entityDef" => array(
                array(
                    "internalId" => "01",
                    "newId" => "1010"
                ),
                array(
                    "internalId" => "02",
                    "newId" => "1026"
                ),
                array(
                    "internalId" => "35",
                    "newId" => "1017"
                ),
                array(
                    "internalId" => "33",
                    "newId" => "1020"
                ),
                array(
                    "internalId" => "03",
                    "newId" => "1018"
                ),
                array(
                    "internalId" => "07",
                    "newId" => "1023"
                ),
                array(
                    "internalId" => "13",
                    "newId" => "1031"
                ),
                array(
                    "internalId" => "21",
                    "newId" => "1036"
                ),
                array(
                    "internalId" => "08",
                    "newId" => "1025"
                ),
                array(
                    "internalId" => "14",
                    "newId" => "1032"
                ),
                array(
                    "internalId" => "18",
                    "newId" => "1028"
                ),
                array(
                    "internalId" => "34",
                    "newId" => "1038"
                ),
                array(
                    "internalId" => "04",
                    "newId" => "1021"
                ),
                array(
                    "internalId" => "05",
                    "newId" => "1015"
                ),
                array(
                    "internalId" => "15",
                    "newId" => "1019"
                ),
                array(
                    "internalId" => "28",
                    "newId" => "1039"
                ),
                array(
                    "internalId" => "42",
                    "newId" => "1043"
                ),
                array(
                    "internalId" => "29",
                    "newId" => "1040"
                ),
                array(
                    "internalId" => "31",
                    "newId" => "1037"
                ),
                array(
                    "internalId" => "26",
                    "newId" => "1011"
                ),
                array(
                    "internalId" => "36",
                    "newId" => "1041"
                ),
                array(
                    "internalId" => "37",
                    "newId" => "1013"
                ),
                array(
                    "internalId" => "40",
                    "newId" => "1014"
                ),
                array(
                    "internalId" => "22",
                    "newId" => "1035"
                ),
                array(
                    "internalId" => "12",
                    "newId" => "1030"
                ),
                array(
                    "internalId" => "38",
                    "newId" => "1033"
                ),
                array(
                    "internalId" => "32",
                    "newId" => "1016"
                ),
                array(
                    "internalId" => "30",
                    "newId" => "1022"
                ),
                array(
                    "internalId" => "11",
                    "newId" => "1029"
                ),
                array(
                    "internalId" => "17",
                    "newId" => "1027"
                ),
                array(
                    "internalId" => "39",
                    "newId" => "1042"
                ),
                array(
                    "internalId" => "41",
                    "newId" => "1034"
                ),
                array(
                    "internalId" => "24",
                    "newId" => "1012"
                ),
                array(
                    "internalId" => "10",
                    "newId" => "1024"
                )
            )
        );
        $arrData["data"] = array();
        $data = array();

        $data = $this->MonitoringMargin_model->revenueRegion($region, $tahun, $bulan);
//        echo $this->db->last_query();

        foreach ($data as $row) {
            $pencapaian = $this->getPersen($row['REAL_REVENUE'], $row['TARGET_REVENUE']);
            if ($pencapaian >= -100 && $pencapaian <= 90) {
                $color = '#ff4545';
            } else if ($pencapaian >= 90 && $pencapaian < 100) {
                $color = '#fef536';
            } else if ($pencapaian >= 100) {
                $color = '#49ff56';
            }
            if ($row['TARGET_REVENUE'] < round($row['REAL_REVENUE'])) {
                $colorreal = 'green';
            } else {
                $colorreal = 'red';
            }
            $tooltip = "<table style='color:black;width:150px;'>
                            <thead>
                            <tr><th colspan='2' style='background-color:$color'><b>" . $row['NM_PROV'] . "</b></th></tr>
                            </thead>
                            <tbody>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Pencapaian Target RKAP SDK:</td>
                                    <td><span class='pull-right'>" . round($pencapaian) . " %</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>RKAP SDK:</td>
                                    <td><span class='pull-right'>" . number_format($row['TARGET_REVENUE'] / 1000000, 0, '', '.') . " Juta</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Realisasi :</td>
                                    <td><span class='pull-right'>" . number_format($row['REAL_REVENUE'] / 1000000, 0, '', '.') . " Juta</span></td>
                                </tr>
                                <tr><td colspan='2'>&nbsp;</td></tr>
                               
                            </tbody>
                        </table>";
            array_push($arrData["data"], array(
                "id" => $row["ID_PROV"],
                "value" => $pencapaian,
                "tooltext" => $tooltip
            ));
        }
        echo json_encode(array(
            "data" => $arrData
        ));
    }

    function getDistrik($region, $prov, $tahun, $bulan, $tipe, $material) {
        $hari = date('d');
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }

        $matDesign = "'121-301','121-302'";

        if ($material == 'total') {
            $matParams = "'121-301','121-302'";
        } else if ($material == 'bag') {
            $matParams = "'121-301'";
        } else if ($material == 'bulk') {
            $matParams = "'121-302'";
        }

        $this->load->model('MonitoringMargin_model');

        $summ = array();
        if ($tipe == 'volume') {
            $plant = $this->MonitoringMargin_model->getPlant($prov, $bulan, $tahun, $harik, $matDesign);
            $distrik = $this->MonitoringMargin_model->get_distrik($prov, $tahun, $bulan, $matParams);
        } else if ($tipe == 'hbruto') {
            $plant = $this->MonitoringMargin_model->getPlantHbruto($prov, $bulan, $tahun, $harik, $matDesign);
            $distrik = $this->MonitoringMargin_model->getDistrikHbruto($prov, $tahun, $bulan, $matParams);
//            echo $this->db->last_query();
            $summ = $this->MonitoringMargin_model->AvgHBruto($prov, $tahun, $bulan, $matParams);
//            echo $this->db->last_query();
        } else if ($tipe == 'oaton') {
            $plant = $this->MonitoringMargin_model->getKdPlantOA($prov, $bulan, $tahun, $harik, $matDesign);
            $distrik = $this->MonitoringMargin_model->getOA($prov, $tahun, $bulan, $matParams);
        } else if ($tipe == 'hnetto') {
            $plant = $this->MonitoringMargin_model->getPlantHbruto($prov, $bulan, $tahun, $harik, $matDesign);
            $distrik = $this->MonitoringMargin_model->getHNetto($prov, $tahun, $bulan, $matParams);
        } else if ($tipe == 'revenue') {
            $plant = $this->MonitoringMargin_model->getPlantHbruto($prov, $bulan, $tahun, $harik, $matDesign);
            $distrik = $this->MonitoringMargin_model->getRevenue($prov, $tahun, $bulan, $matParams);
        }
        $kdPlant = array();
        foreach ($plant as $key => $value) {
            $kdPlant[$value['PLANT']] = $value['NAME'];
        }
        $semenPutih = $this->MonitoringMargin_model->getSemenPutih($prov, $tahun, $bulan);
        
        $provName = $this->MonitoringMargin_model->getProvince($prov);
        $distrikName = $this->MonitoringMargin_model->getKDDistrik($prov);
        $penSeh = $this->MonitoringMargin_model->getPencapaianS($tahun, $bulan, $prov, "'121-301','121-302'");

        $jml['TARGET'] = 0;
        $jml['REALISASI'] = 0;
        $jml['REALTHNLALU'] = 0;
        foreach ($distrik as $key => $value) {
            $jml['TARGET'] += $value['TARGET'];
            $jml['REALISASI'] += $value['REALISASI'];
            $jml['REALTHNLALU'] += $value['REALTHNLALU'];
            $distrik[$key]['PERSEN'] = round($this->getPersen($value['REALISASI'], $value['TARGET']));
            $distrik[$key]['TARGET'] = number_format($value['TARGET'], 0, ',', '.');
            $distrik[$key]['REALISASI'] = number_format($value['REALISASI'], 0, ',', '.');
            $distrik[$key]['REALTHNLALU'] = number_format($value['REALTHNLALU'], 0, ',', '.');
            $distrik[$key]['PERSENREAL'] = round($this->getPersen($value['REALISASI'], $value['REALTHNLALU']), 1);
            foreach ($distrikName as $key2 => $value2) {
                if ($value['KD_KOTA'] == $value2['BZIRK']) {
                    $distrik[$key]['BZTXT'] = $value2['BZTXT'];
                }
            }
        }

        $jml['TARGET'] = number_format($jml['TARGET'], 0, ',', '.');
        $jml['REALISASI'] = number_format($jml['REALISASI'], 0, ',', '.');
        $jml['REALTHNLALU'] = number_format($jml['REALTHNLALU'], 0, ',', '.');

        $jml['PERSEN'] = round($this->getPersen($jml['REALISASI'], $jml['TARGET']));

        echo json_encode(
                array(
                    'data' => $distrik,
                    'jml' => $jml,
                    'prov' => $provName,
                    'plant' => $kdPlant,
                    'pencSeh' => $penSeh,
                    'summ' => $summ,
                    'semenPutih' => $semenPutih
                )
        );
    }

    function getPersen($a, $b) {
        if ($b == 0 || $b == '') {
            return 0;
        } else {
            return $a / $b * 100;
        }
    }

    function bulan($n) {
        $bulan['01'] = "Januari";
        $bulan['02'] = "Februari";
        $bulan['03'] = "Maret";
        $bulan['04'] = "April";
        $bulan['05'] = "Mei";
        $bulan['06'] = "Juni";
        $bulan['07'] = "Juli";
        $bulan['08'] = "Agustus";
        $bulan['09'] = "September";
        $bulan['10'] = "Oktober";
        $bulan['11'] = "November";
        $bulan['12'] = "Desember";

        return $bulan[$n];
    }

}

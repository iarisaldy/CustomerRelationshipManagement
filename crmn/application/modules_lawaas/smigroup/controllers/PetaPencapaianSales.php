<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class PetaPencapaianSales extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        $this->load->model('PetaPencapaianSales_model');
        error_reporting(0);
    }

    function index() {
        $data = array('title' => 'Realisasi by Sales Regional');
        $this->template->display('PetaPencapaianSales_view', $data);
    }

    function scodata($region, $tahun, $bulan) {
        date_default_timezone_set("Asia/Jakarta");
//        $tahun = date("Y");
//        $bulan = date("m");
        $date = $tahun . '' . $bulan;
        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad(--$hari, 2, '0', STR_PAD_LEFT) : $hari;
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
                $subCap = 'All Bag/Curah';
                break;
            default:
                $subCap = '';
                break;
        }

        $arrData = array(
            "chart" => array(
                "caption" => "Realisasi by Sales Regional Terhadap RKAP s/d " . $hari . " " . $this->bulan($bulan) . " " . $tahun,
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
                        "minvalue" => "-100",
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

        $data = $this->getscodataopco($region, $tahun, $bulan, $hari);

        $bulanBaru = date('t', strtotime($tahun . "-" . $bulan));
        $a_date = $tahun . "-" . $bulan;
        $tgl_akhir = date("t", strtotime($a_date));
        $harisisa = $tgl_akhir - $hari;
        $harisisa = $harisisa != 0 ? $harisisa : 1;
        foreach ($data as $row) {
            if (empty($row['TARGET_REALH']) || $row['TARGET_REALH'] < 1) {
                //kode tambahan

//                echo "<pre>";
//                print_r ($row['TARGET_REALH']);
//                echo "</pre>";
                //akhir
                $tRealH = ($row['TARGET'] * $hari) / $bulanBaru;
            } else {
                $tRealH = $row['TARGET_REALH'];
            }
            if ($tRealH == 0) {
                $persen = 0;
            } else {
                $persen = ($row["REAL"] / $tRealH) * 100;
            }
            $target = round($row['TARGET']);
            if ($target == 0) {
                $tampilpersen = 0;
            } else {
                $tampilpersen = ($row["REAL"] / $target) * 100;
            }
            $target_harian = round(($target - round($row['REAL'])) / $harisisa);
            if ($target_harian <= 0) {
                $target_harian = '-';
            } else {
                $target_harian = number_format($target_harian, 0, '', '.');
            }
            $harian_max = number_format(round($row['HARIAN_MAX']), 0, '', '.');
            $totalreal = number_format(round($row['REAL']), 0, '', '.');
            $totalrealbag = number_format(round($row['REAL_BAG']), 0, '', '.');
            $totalrealbulk = number_format(round($row['REAL_BULK']), 0, '', '.');
            $totalrealtl = number_format(round($row['REAL_THNLALU']), 0, '', '.');
            $totalrealbagtl = number_format(round($row['REAL_BAG_THNLALU']), 0, '', '.');
            $totalrealbulktl = number_format(round($row['REAL_BULK_THNLALU']), 0, '', '.');
            $growthreal =  round($this->getpersen($row['REAL'],$row['REAL_THNLALU']));
            $growthrealbag =  round($this->getpersen($row['REAL_BAG'],$row['REAL_BAG_THNLALU']));
            $growthrealbulk =  round($this->getpersen($row['REAL_BULK'],$row['REAL_BULK_THNLALU']));
            
            $pencapaian = round($persen);
            $pencapaianrkap = round($tampilpersen);
            if ($pencapaian >= -100 && $pencapaian <= 90) {
                $color = '#ff4545';
            } else if ($pencapaian >= 90 && $pencapaian < 100) {
                $color = '#fef536';
            } else if ($pencapaian >= 100) {
                $color = '#49ff56';
            }
            if ($target < round($row['REAL'])) {
                $colorreal = 'green';
            } else {
                $colorreal = 'red';
            }
            
            $warnareal ='';
            $warnarealbag ='';
            $warnarealbulk ='';
            if($growthreal < 100){
                $warnareal = '#ff4545'; 
            }
            
            if($growthrealbag < 100){
                $warnarealbag = '#ff4545';
            }
            
            if($growthrealbulk < 100){
                $warnarealbulk = '#ff4545';
            }
            
            $tooltip = "<table style='color:black;width:150px;'>
                            <thead>
                            <tr><th colspan='2' style='background-color:$color'><b>" . $row['NM_PROV'] . "</b></th></tr>
                            </thead>
                            <tbody>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Pencapaian Target RKAP :</td>
                                    <td><span class='pull-right'>" . $pencapaianrkap . " %</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Pencapaian Target Harian :</td>
                                    <td><span class='pull-right'>" . $pencapaian . " %</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>RKAP :</td>
                                    <td><span class='pull-right'>" . number_format($target, 0, '', '.') . " Ton</span></td>
                                </tr>
                                <tr>
                                    <td colspan='2'>Realisasi</td>
                                </tr>
                                <tr>
                                    <td>Bag :</td>
                                    <td><span class='pull-right'>$totalrealbag Ton</span></td>
                                </tr>
                                <tr>
                                    <td>Bulk :</td>
                                    <td><span class='pull-right'>$totalrealbulk Ton</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Total :</td>
                                    <td><span class='pull-right'>$totalreal Ton</span></td>
                                </tr>
                                <tr>
                                    <td colspan='2'>Realisasi Tahun Lalu</td>
                                </tr>
                                <tr>
                                    <td>Bag :</td>
                                    <td><span class='pull-right'>$totalrealbagtl Ton</span></td>
                                </tr>
                                <tr>
                                    <td>Bulk :</td>
                                    <td><span class='pull-right'>$totalrealbulktl Ton</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Total :</td>
                                    <td><span class='pull-right'>$totalrealtl Ton</span></td>
                                </tr>
                                <tr>
                                    <td colspan='2'>Growth</td>
                                </tr>
                                <tr>
                                    <td>Bag :</td>
                                    <td><span class='pull-right' style='color:$warnarealbag'>$growthrealbag %</span></td>
                                </tr>
                                <tr>
                                    <td>Bulk :</td>
                                    <td><span class='pull-right' style='color:$warnarealbulk'>$growthrealbulk %</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Total :</td>
                                    <td><span class='pull-right' style='color:$warnareal'>$growthreal %</span></td>
                                </tr>
                                <tr>
                                    <td>Max Real / day :</td>
                                    <td><span class='pull-right' style='color:$colorreal'>$harian_max Ton</span></td>
                                </tr>
                                <tr>
                                    <td>Plan Target / day :</td>
                                    <td><span class='pull-right' style='color:$colorreal'>" . $target_harian . " Ton</span></td>
                                </tr>
                            </tbody>
                        </table>";
            array_push($arrData["data"], array(
                "id" => $row["PROV"],
                "value" => $pencapaian,
                "tooltext" => $tooltip
            ));
        }
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
        echo json_encode(array(
            "data" => $arrData
        ));
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

    function getscodataopco($region, $tahun, $bulan, $hari) {
        $data = $this->PetaPencapaianSales_model->scodatamv_region($region, $tahun, $bulan, $hari);
        $maxharian = $this->PetaPencapaianSales_model->maxharianNew($region, $tahun, $bulan, $hari);
//        if ($org == '7000') {
//            $maxharian = $this->PetaPencapaian_model->maxhariansg($tahun, $bulan);
//        } else if ($org == '3000') {
//            $maxharian = $this->PetaPencapaian_model->maxhariansp($tahun, $bulan);
//        } else if ($org == '4000') {
//            $maxharian = $this->PetaPencapaian_model->maxharianst($tahun, $bulan);
//        }

        foreach ($data as $key => $value) {
            $data[$key]['HARIAN_MAX'] = 0;
            foreach ($maxharian as $k => $v) {
                if ($value['PROV'] == $v['PROV']) {
                    $data[$key]['HARIAN_MAX'] = $v['HARIAN_MAX'];
                }
            }
        }

        return $data;
    }

    function getSummary($tahun, $bulan) {
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Jakarta");
//        $tahun = date("Y");
//        $bulan = date("m");
        $date = $tahun . '' . $bulan;
        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad(--$hari, 2, '0', STR_PAD_LEFT) : $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }

        $data = array();
        /* INISIALISASI VARIABLE */

        $region1 = $this->PetaPencapaianSales_model->sumSalesRegion('1', $tahun, $bulan, $hari);

        $region2 = $this->PetaPencapaianSales_model->sumSalesRegion('2', $tahun, $bulan, $hari);
        $region3 = $this->PetaPencapaianSales_model->sumSalesRegion('3', $tahun, $bulan, $hari);
        $curah = $this->PetaPencapaianSales_model->sumSalesRegion('4', $tahun, $bulan, $hari);

        $SMIG = $region1;

        foreach ($SMIG as $key => $value) {
            $SMIG[$key] = $value + $region2[$key] + $region3[$key] + $curah[$key];
        }
        
        $SMIG['PERSEN'] = round($this->getPersen($SMIG['REAL'],$SMIG['TARGET_REALH']));
        $SMIG['PERSENRKAP'] = round($this->getPersen($SMIG['REAL'],$SMIG['TARGET']));


//        echo '<pre>';
//        print_r($arrData);
//        echo '</pre>';
        echo json_encode(array(
            'SMIG' => $SMIG,
            'region1' => $region1,
            'region2' => $region2,
            'region3' => $region3,
            'curah' => $curah
        ));
    }

    function getPersen($a, $b) {
        if ($b == 0 || $b == '') {
            return 0;
        } else {
            return $a / $b * 100;
        }
    }

    function getChart($region, $prov, $tahun, $bulan) {

//        $result = array(
//            'sg' => array(
//                'target'=> 0,
//                'real' =>1,
//                'target'=>2,
//                'rael'=>3),
//            'sp',
//            'st');


        //inisialisasi
        $result['sg']['target'] =array();
        $result['sg']['real'] = array();
        $result['sg']['target_ak'] = array();
        $result['sg']['real_ak'] = array();
        $target_ak_sg = 0;
        $real_ak_sg = 0;
        $result['sp']['target'] = array();
        $result['sp']['real'] = array();
        $result['sp']['target_ak'] = array();
        $result['sp']['real_ak'] = array();
        $target_ak_sp = 0;
        $real_ak_sp = 0;
        $result['st']['target'] = array();
        $result['st']['real'] = array();
        $result['st']['target_ak'] = array();
        $result['st']['real_ak'] = array();
        $target_ak_st = 0;
        $real_ak_st = 0;

        $dataSG = $this->PetaPencapaianSales_model->getChart('7000', $prov, $tahun, $bulan, $region);
        foreach ($dataSG as $key => $value) {
            $target_ak_sg += $value['TARGET'];
            $real_ak_sg += $value['REAL'];
            array_push($result['sg']['target'], floatval($value['TARGET']));
            array_push($result['sg']['real'], floatval($value['REAL']));
            if ($value['TANGGAL'] <= date("d")) {
                array_push($result['sg']['real_ak'], $real_ak_sg);
            }
            array_push($result['sg']['target_ak'], $target_ak_sg);
        }
        //echo $this->db->last_query();
        $dataST = $this->PetaPencapaianSales_model->getChart('4000', $prov, $tahun, $bulan, $region);
        foreach ($dataST as $key => $value) {
            $target_ak_st += $value['TARGET'];
            $real_ak_st += $value['REAL'];
            array_push($result['st']['target'], floatval($value['TARGET']));
            array_push($result['st']['real'], floatval($value['REAL']));
            if ($value['TANGGAL'] <= date("d")) {
                array_push($result['st']['real_ak'], $real_ak_st);
            }
            array_push($result['st']['target_ak'], $target_ak_st);
        }
        //echo $this->db->last_query();
        $dataSP = $this->PetaPencapaianSales_model->getChart('3000', $prov, $tahun, $bulan, $region);
//        echo '<pre>';
//        print_r($dataSP);
//        echo '</pre>';
        exit;
        foreach ($dataSP as $key => $value) {
            $target_ak_sp += $value['TARGET'];
            $real_ak_sp += $value['REAL'];
            array_push($result['sp']['target'], floatval($value['TARGET']));
            array_push($result['sp']['real'], floatval($value['REAL']));
            if ($value['TANGGAL'] <= date("d")) {
                array_push($result['sp']['real_ak'], $real_ak_sp);
            }
            array_push($result['sp']['target_ak'], $target_ak_sp);
        }
        //echo $this->db->last_query();

        $data = $dataSG;
        foreach ($dataST as $key => $value) {
            foreach ($value as $key2 => $value2) {

                if (isset($data[$key][$key2]) && $key2 != 'TANGGAL' && $key2 != 'NM_PROV') {
                    $data[$key][$key2] += $value2;
                } else {
                    $data[$key][$key2] = $value2;
                }
            }
        }

        foreach ($dataSP as $key => $value) {
            foreach ($value as $key2 => $value2) {

                if (isset($data[$key][$key2]) && $key2 != 'TANGGAL' && $key2 != 'NM_PROV') {
                    $data[$key][$key2] += $value2;
                } else {
                    $data[$key][$key2] = $value2;
                }
            }
        }



        $result['tanggal'] = array();
        $result['target'] = array();
        $result['real'] = array();
        $result['target_ak'] = array();
        $result['real_ak'] = array();
        $target_ak = 0;
        $real_ak = 0;
        foreach ($data as $key => $value) {
            $target_ak += $value['TARGET'];
            $real_ak += $value['REAL'];
            array_push($result['tanggal'], $value['TANGGAL']);
            array_push($result['target'], round(floatval($value['TARGET']),2));
            array_push($result['real'], floatval($value['REAL']));
            if ($value['TANGGAL'] <= date("d")) {
                array_push($result['real_ak'], $real_ak);
            }
            array_push($result['target_ak'], $target_ak);
            $result['nm_prov'] = $value['NM_PROV'];
        }

        echo json_encode($result);
    }

}

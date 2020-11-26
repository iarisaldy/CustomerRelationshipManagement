<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class MarketShare extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('MarketShare_model');
        error_reporting(0);
    }

    function index() {
        $data = array('title' => 'Market Share');
        $this->template->display('MarketShare_view', $data);
    }

    function getData($org, $tahun, $bulan) {

        //$tahun = date("Y");
        //$bulan = date("m");
        $arrData = array(
            "chart" => array(
                "caption" => "Realisasi Market Share Terhadap RKAP",
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
                        "maxvalue" => "98",
                        "code" => "#ff4545",
                        "displayValue" => "MS dibawah target > 2%"
                    ),
                    array(
                        "minvalue" => "98",
                        "maxvalue" => "100",
                        "code" => "#fef536",
                        "displayValue" => "MS dibawah target <= 2%"
                    ),
                    array(
                        "minvalue" => "100",
                        "maxvalue" => "1000",
                        "code" => "#49ff56",
                        "displayValue" => "MS >= target"
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
        if ($org == 7000) {
            $data = $this->MarketShare_model->datas('110', $tahun, $bulan);
        } else if ($org == 4000) {
            $data = $this->MarketShare_model->datas('112', $tahun, $bulan);
        } else if ($org == 3000) {
            $data = $this->MarketShare_model->datas('102', $tahun, $bulan);
        } else if ($org == 1) {
            $data = $this->MarketShare_model->datasmig($tahun, $bulan);
        }

        foreach ($data as $row) {
            //$persen = ($row["REAL"]/$row["TARGET_REALH"])*100;
            $ms = round(str_replace(',', '.', $row['MS']));
            $targetrkap = round(str_replace(',', '.', $row["RKAP"]));
            $realrkap = round($row["QTY"]);
            if ($realrkap >= 0 && $realrkap <= 98) {
                $color = '#ff4545';
            } else if ($realrkap >= 98 && $realrkap < 100) {
                $color = '#fef536';
            } else if ($realrkap >= 100) {
                $color = '#49ff56';
            }
//            $tooltip = "<div style='color:black;width:150px;'>"
//                    . "<div style='background-color:$color';><b>" . $row['NM_PROV'] . "</b></div>"
//                    . "<div><span class='pull-right'>" . $ms . " %</span></div>"
//                    . "<div>MS : <span class='pull-right'>" . $targetrkap . " %</span></div>"
//                    . "<div>RKAP : </div>{br}"
//                    . "<div style='font-size:10px;font-style:italic;'>Klik untuk detail</div>"
//                    . "</div>";
            $tooltip = "<div style='color:black;width:150px;'>"
                    . "<div style='background-color:$color';><b>" . $row['NM_PROV'] . "</b></div>"
                    . "<table border=0 style='margin-top:4px;width:100%' class=''>"
                    . "<tr>"
                    . "<td style='text-align:left'>MS :</td>"
                    . "<td style='text-align:right'>".$ms."%</td>"
                    . "</tr>"
                    . "<tr style='padding:8px;'>"
                    . "<td style='text-align:left'>RKAP :</td>"
                    . "<td style='text-align:right'>".$targetrkap."%</td>"
                    . "</tr>"
                    . "<tr style='padding:8px;'>"
                    . "<td></td>"
                    . "<td style='font-size:10px;font-style:italic;text-align:right'>Klik untuk detail</td>"
                    . "</tr>"
                    . "</table>"
                    . "</div>";
            array_push($arrData["data"], array(
                "id" => $row["PROPINSI"],
                "value" => round($row["QTY"]),
                "toolText" => $tooltip
            ));
        }
        echo json_encode($arrData);
    }

    function getDetail($org, $prov, $tahun, $bulan) {
        $data = $this->MarketShare_model->getDetail($prov, $tahun, $bulan);
        $no = 1;
        $table = '';
        $prov = '';
        $qtybulansmi = 0;
        $tahuninikumsmi = 0;
        $realbulaninismi = 0;
        $realbulankemarinsmi = 0;
        $realtahunkemarinsmi = 0;
        $realkumtahuninismi = 0;
        $realkumtahunsmi = 0;
        $qtybagsmi = 0;
        $qtybulksmi = 0;
        $targetrkapsmi = 0;
        foreach ($data['body']->result_array() as $row) {
            if ($org == 1) {
                if ($row['KODE_PERUSAHAAN'] == '110' || $row['KODE_PERUSAHAAN'] == '112' || $row['KODE_PERUSAHAAN'] == '102') {
                    $table .= '<tr class="highlight">';
                } else {
                    $table .= '<tr>';
                }
            } else if ($org == 7000) {
                if ($row['KODE_PERUSAHAAN'] == '110') {
                    $table .= '<tr class="highlight">';
                } else {
                    $table .= '<tr>';
                }
            } else if ($org == 4000) {
                if ($row['KODE_PERUSAHAAN'] == '112') {
                    $table .= '<tr class="highlight">';
                } else {
                    $table .= '<tr>';
                }
            } else if ($org == 3000) {
                if ($row['KODE_PERUSAHAAN'] == '102') {
                    $table .= '<tr class="highlight">';
                } else {
                    $table .= '<tr>';
                }
            }
            $bulanini = round(str_replace(',', '.', $row['QTY_REAL']), 2);
            $bulankemarin = round(str_replace(',', '.', $row['QTY_BULAN']), 2);
            $tahunkemarin = round(str_replace(',', '.', $row['QTY_TAHUN']), 2);
            $tahuninikum = round(str_replace(',', '.', $row['QTY_TAHUNINI_KUM']), 2);
            $targetrkap = round(str_replace(',', '.', $row['TARGET_RKAP']), 2);
            $realbulanini = round(str_replace(',', '.', $row['QTY']));
            $realbulankemarin = str_replace(',', '.', $row['REAL_BULAN']);
            $realtahunkemarin = str_replace(',', '.', $row['REAL_TAHUN']);
            $realkumtahunini = str_replace(',', '.', $row['REAL_TAHUNINI_KUM']);
            $realkumtahun = str_replace(',', '.', $row['REAL_TAHUN_KUM']);
            $qtybag = round(str_replace('.', '.', $row['QTY_BAG']));
            $qtybulk = round(str_replace('.', '.', $row['QTY_BULK']));
            if ($row['KODE_PERUSAHAAN'] == '110' || $row['KODE_PERUSAHAAN'] == '112' || $row['KODE_PERUSAHAAN'] == '102') {
                $qtybulansmi += $bulanini;
                $tahuninikumsmi += $tahuninikum;
                $realbulaninismi += $realbulanini;
                $realbulankemarinsmi += $realbulankemarin;
                $realtahunkemarinsmi += $realtahunkemarin;
                $realkumtahuninismi += $realkumtahunini;
                $realkumtahunsmi += $realkumtahun;
                $qtybagsmi += $qtybag;
                $qtybulksmi += $qtybulk;
                $targetrkapsmi += $targetrkap;
            }
            if ($realtahunkemarin == 0) {
                $gYoY = 0;
            } else {
                $gYoY = round((($realbulanini - $realtahunkemarin) / $realtahunkemarin) * 100, 2);
            }
            if ($realbulankemarin == 0) {
                $gMoM = 0;
            } else {
                $gMoM = round((($realbulanini - $realbulankemarin) / $realbulankemarin) * 100, 2);
            }

            if ($realkumtahun == 0) {
                $growthkumYoY = 0;
            } else {
                $growthkumYoY = round((($realkumtahunini - $realkumtahun) / $realkumtahun) * 100, 2);
            }
            if ($realbulanini > $realbulankemarin) {
                $warnaMoM = 'hijau';
                $levelMoM = 'fa-level-up';
            } else {
                $warnaMoM = 'merah';
                $levelMoM = 'fa-level-down';
            }
            if ($realbulanini > $realtahunkemarin) {
                $warnaYoY = 'hijau';
                $levelYoY = 'fa-level-up';
            } else {
                $warnaYoY = 'merah';
                $levelYoY = 'fa-level-down';
            }
            if ($realkumtahunini > $realkumtahun) {
                $warnakumYoY = 'hijau';
                $levelkumYoY = 'fa-level-up';
            } else {
                $warnakumYoY = 'merah';
                $levelkumYoY = 'fa-level-down';
            }

            $table .= '<td align="center">' . $no . '</td>';
            $table .= '<td>' . $row['NAMA_PERUSAHAAN'] . '</td>';
            $table .= '<td align="right">' . number_format($realbulanini, 0, '', '.') . '</td>';
            $table .= '<td align="right">' . $bulanini . '</td>';
            $table .= '<td align="right">' . $tahuninikum . '</td>';
            $table .= '<td align="right">' . $targetrkap . '</td>';
            $table .= '<td align="right">' . number_format($qtybag, 0, '', '.') . '</td>';
            $table .= '<td align="right">' . number_format($qtybulk, 0, '', '.') . '</td>';
            $table .= '<td align="right"><span class="' . $warnaMoM . '">' . $gMoM . '%<i class="fa ' . $levelMoM . '"></i></span></td>';
            $table .= '<td align="right"><span class="' . $warnaYoY . '">' . $gYoY . '% <i class="fa ' . $levelYoY . '"></i></span></td>';
            $table .= '<td align="right"><span class="' . $warnakumYoY . '">' . $growthkumYoY . '% <i class="fa ' . $levelkumYoY . '"></i></span></td>';
            $table .= '</tr>';
            $no++;
            $prov = $row['NM_PROV'];
        }
        if ($realtahunkemarinsmi == 0) {
            $growthYoYsmi = 0;
        } else {
            $growthYoYsmi = round((($realbulaninismi - $realtahunkemarinsmi) / $realtahunkemarinsmi) * 100, 2);
        }
        if ($realbulankemarinsmi == 0) {
            $growthMoMsmi = 0;
        } else {
            $growthMoMsmi = round((($realbulaninismi - $realbulankemarinsmi) / $realbulankemarinsmi) * 100, 2);
        }
        if ($realkumtahunsmi == 0) {
            $growthkumYoYsmi = 0;
        } else {
            $growthkumYoYsmi = round((($realkumtahuninismi - $realkumtahunsmi) / $realkumtahunsmi) * 100, 2);
        }
        if ($realbulaninismi > $realbulankemarinsmi) {
            $warnaMoMsmi = 'hijau';
            $levelMoMsmi = 'fa-level-up';
        } else {
            $warnaMoMsmi = 'merah';
            $levelMoMsmi = 'fa-level-down';
        }
        if ($realbulaninismi > $realtahunkemarinsmi) {
            $warnaYoYsmi = 'hijau';
            $levelYoYsmi = 'fa-level-up';
        } else {
            $warnaYoYsmi = 'merah';
            $levelYoYsmi = 'fa-level-down';
        }
        if ($realkumtahuninismi > $realkumtahunsmi) {
            $warnakumYoYsmi = 'hijau';
            $levelkumYoYsmi = 'fa-level-up';
        } else {
            $warnakumYoYsmi = 'merah';
            $levelkumYoYsmi = 'fa-level-down';
        }
        $tbl = '<tr style="background-color: #ffc0cb;">';
        $tbl .= '<td></td>';
        $tbl .= '<td><b>SMI GROUP</b></td>';
        $tbl .= '<td align="right"><b>' . number_format($realbulaninismi, 0, '', '.') . '</b></td>';
        $tbl .= '<td align="right"><b>' . $qtybulansmi . '</b></td>';
        $tbl .= '<td align="right"><b>' . $tahuninikumsmi . '</b></td>';
        $tbl .= '<td align="right"><b>' . $targetrkapsmi . '</b></td>';
        $tbl .= '<td align="right"><b>' . number_format($qtybagsmi, 0, '', '.') . '</b></td>';
        $tbl .= '<td align="right"><b>' . number_format($qtybulksmi, 0, '', '.') . '</b></td>';
        $tbl .= '<td align="right"><span class="' . $warnaMoMsmi . '">' . $growthMoMsmi . '%<i class="fa ' . $levelMoMsmi . '"></i></span></td>';
        $tbl .= '<td align="right"><span class="' . $warnaYoYsmi . '">' . $growthYoYsmi . '% <i class="fa ' . $levelYoYsmi . '"></i></span></td>';
        $tbl .= '<td align="right"><span class="' . $warnakumYoYsmi . '">' . $growthkumYoYsmi . '% <i class="fa ' . $levelkumYoYsmi . '"></i></span></td>';
        $tbl .= '</tr>';
        $tbl .= $table;

        foreach ($data['footer']->result_array() as $row) {
            $bulanini = round(str_replace(',', '.', $row['QTY_REAL']), 2);
            $bulankemarin = round(str_replace(',', '.', $row['QTY_BULAN']), 2);
            $tahunkemarin = round(str_replace(',', '.', $row['QTY_TAHUN']), 2);
            $realbulanini = str_replace(',', '.', $row['QTY']);
            $realbulankemarin = str_replace(',', '.', $row['REAL_BULAN']);
            $realtahunkemarin = str_replace(',', '.', $row['REAL_TAHUN']);
            $realkumtahunini = str_replace(',', '.', $row['REAL_TAHUNINI_KUM']);
            $realkumtahun = str_replace(',', '.', $row['REAL_TAHUN_KUM']);

            if ($realtahunkemarin == 0) {
                $growthYoY = 0;
            } else {
                $growthYoY = round((($realbulanini - $realtahunkemarin) / $realtahunkemarin) * 100, 2);
            }
            if ($realbulankemarin == 0) {
                $growthMoM = 0;
            } else {
                $growthMoM = round((($realbulanini - $realbulankemarin) / $realbulankemarin) * 100, 2);
            }
            if ($realkumtahun == 0) {
                $growthkumYoY = 0;
            } else {
                $growthkumYoY = round((($realkumtahunini - $realkumtahun) / $realkumtahun) * 100, 2);
            }
            if ($realbulanini > $realbulankemarin) {
                $warnaMoM = 'hijau';
                $levelMoM = 'fa-level-up';
            } else {
                $warnaMoM = 'merah';
                $levelMoM = 'fa-level-down';
            }
            if ($realbulanini > $realtahunkemarin) {
                $warnaYoY = 'hijau';
                $levelYoY = 'fa-level-up';
            } else {
                $warnaYoY = 'merah';
                $levelYoY = 'fa-level-down';
            }
            if ($realkumtahunini > $realkumtahun) {
                $warnakumYoY = 'hijau';
                $levelkumYoY = 'fa-level-up';
            } else {
                $warnakumYoY = 'merah';
                $levelkumYoY = 'fa-level-down';
            }
            $growMoM = '<span class="' . $warnaMoM . '">' . $growthMoM . '% <i class="fa ' . $levelMoM . '"></i></span>';
            $growYoY = '<span class="' . $warnaYoY . '">' . $growthYoY . '% <i class="fa ' . $levelYoY . '"></i></span>';
            $growkumYoY = '<span class="' . $warnakumYoY . '">' . $growthkumYoY . '% <i class="fa ' . $levelkumYoY . '"></i></span>';
        }
        echo json_encode(array("table" => $tbl, "provinsi" => $prov, "porsi" => number_format($realbulanini, 0, '', '.'), "growthYOY" => $growYoY, "growthMOM" => $growMoM, "growthkumYOY" => $growkumYoY));
    }

    function getSummary($tahun, $bulan) {
        $data = $this->MarketShare_model->getSummary($tahun, $bulan);
        $datarkap = $this->rkapsi($tahun);
        $table = '';
        $no = 1;
        $qtybulansmi = 0;
        $qtykumsmi = 0;
        $realbulaninismi = 0;
        $realbulankemarinsmi = 0;
        $realtahunkemarinsmi = 0;
        $realkumtahuninismi = 0;
        $realkumtahunsmi = 0;
        $rkapsmi = 0;
        foreach ($data['body']->result_array() as $row) {
            $kodeperusahaan = $row['KODE_PERUSAHAAN'];
            $bulanini = round(str_replace(',', '.', $row['QTY_REAL']), 2);
            $bulankemarin = round(str_replace(',', '.', $row['QTY_BULAN']), 2);
            $tahunkemarin = round(str_replace(',', '.', $row['QTY_TAHUN']), 2);
            $tahuninikum = round(str_replace(',', '.', $row['QTY_TAHUNINI_KUM']), 2);
            $realbulanini = str_replace(',', '.', $row['QTY']);
            $realbulankemarin = str_replace(',', '.', $row['REAL_BULAN']);
            $realtahunkemarin = str_replace(',', '.', $row['REAL_TAHUN']);
            $realkumtahunini = str_replace(',', '.', $row['REAL_TAHUNINI_KUM']);
            $realkumtahun = str_replace(',', '.', $row['REAL_TAHUN_KUM']);
            //$rkap = round(str_replace(',', '.', $row["RKAP"]), 2);

            if ($realtahunkemarin == 0) {
                $growthYoY = 0;
            } else {
                $growthYoY = round((($realbulanini - $realtahunkemarin) / $realtahunkemarin) * 100, 2);
            }
            if ($realbulankemarin == 0) {
                $growthMoM = 0;
            } else {
                $growthMoM = round((($realbulanini - $realbulankemarin) / $realbulankemarin) * 100, 2);
            }
            if ($realkumtahun == 0) {
                $growthkumYoY = 0;
            } else {
                $growthkumYoY = round((($realkumtahunini - $realkumtahun) / $realkumtahun) * 100, 2);
            }
            if ($realbulanini > $realbulankemarin) {
                $warnaMoM = 'hijau';
                $levelMoM = 'fa-level-up';
            } else {
                $warnaMoM = 'merah';
                $levelMoM = 'fa-level-down';
            }
            if ($realbulanini > $realtahunkemarin) {
                $warnaYoY = 'hijau';
                $levelYoY = 'fa-level-up';
            } else {
                $warnaYoY = 'merah';
                $levelYoY = 'fa-level-down';
            }
            if ($realkumtahunini > $realkumtahun) {
                $warnakumYoY = 'hijau';
                $levelkumYoY = 'fa-level-up';
            } else {
                $warnakumYoY = 'merah';
                $levelkumYoY = 'fa-level-down';
            }
            if ($kodeperusahaan == '110' || $kodeperusahaan == '112' || $kodeperusahaan == '102') {
                if ($kodeperusahaan == '102') {
                    $rkap = $datarkap['102'];
                } else if ($kodeperusahaan == '110') {
                    $rkap = $datarkap['110'];
                } else if ($kodeperusahaan == '112') {
                    $rkap = $datarkap['112'];
                }
                if ($bulanini < $rkap) {
                    $warnaMS = 'merah';
                } else {
                    $warnaMS = 'hijau';
                }
                if ($tahuninikum < $rkap) {
                    $warnaMSkum = 'merah';
                } else {
                    $warnaMSkum = 'hijau';
                }
                $qtybulansmi += $bulanini;
                $qtykumsmi += $tahuninikum;
                $realbulaninismi += $realbulanini;
                $realbulankemarinsmi += $realbulankemarin;
                $realtahunkemarinsmi += $realtahunkemarin;
                $realkumtahuninismi += $realkumtahunini;
                $realkumtahunsmi += $realkumtahun;
                //$rkapsmi += $rkap;
                $table .= '<tr class="highlight">';
            } else {
                $rkap = '';
                $warnaMS = '';
                $warnaMSkum = '';
                $table .= '<tr>';
            }
            $rkapsmi = $datarkap['smigroup'];
            $table .= '<td>' . $no . '</td>';
            $table .= '<td title="' . $row['PRODUK'] . '">' . $row["INISIAL"] . '</td>';
            $table .= '<td>' . $rkap . '</td>';
            $table .= '<td><span class="' . $warnaMS . '">' . $bulanini . '</span></td>';
            $table .= '<td><span class="' . $warnaMSkum . '">' . $tahuninikum . '</span></td>';
            $table .= '<td align="right"><span class="' . $warnaMoM . '">' . $growthMoM . '% <i class="fa ' . $levelMoM . '"></i></span></td>';
            $table .= '<td align="right"><span class="' . $warnaYoY . '">' . $growthYoY . '% <i class="fa ' . $levelYoY . '"></i></span></td>';
            $table .= '<td align="right"><span class="' . $warnakumYoY . '">' . $growthkumYoY . '% <i class="fa ' . $levelkumYoY . '"></i></span></td>';
            $table .= '</tr>';
            $no++;
        }
        if ($realtahunkemarinsmi == 0) {
            $growthYoY = 0;
        } else {
            $growthYoY = round((($realbulaninismi - $realtahunkemarinsmi) / $realtahunkemarinsmi) * 100, 2);
        }
        if ($realbulankemarinsmi == 0) {
            $growthMoM = 0;
        } else {
            $growthMoM = round((($realbulaninismi - $realbulankemarinsmi) / $realbulankemarinsmi) * 100, 2);
        }
        if ($realkumtahunsmi == 0) {
            $growthkumYoY = 0;
        } else {
            $growthkumYoY = round((($realkumtahuninismi - $realkumtahunsmi) / $realkumtahunsmi) * 100, 2);
        }
        if ($realbulaninismi > $realbulankemarinsmi) {
            $warnaMoM = 'hijau';
            $levelMoM = 'fa-level-up';
        } else {
            $warnaMoM = 'merah';
            $levelMoM = 'fa-level-down';
        }
        if ($realbulaninismi > $realtahunkemarinsmi) {
            $warnaYoY = 'hijau';
            $levelYoY = 'fa-level-up';
        } else {
            $warnaYoY = 'merah';
            $levelYoY = 'fa-level-down';
        }
        if ($realkumtahuninismi > $realkumtahunsmi) {
            $warnakumYoY = 'hijau';
            $levelkumYoY = 'fa-level-up';
        } else {
            $warnakumYoY = 'merah';
            $levelkumYoY = 'fa-level-down';
        }
        if ($qtybulansmi < $rkapsmi) {
            $warnaMSsmi = 'merah';
        } else {
            $warnaMSsmi = 'hijau';
        }
        if ($qtykumsmi < $rkapsmi) {
            $warnaMSkumsmi = 'merah';
        } else {
            $warnaMSkumsmi = 'hijau';
        }
        $tbl = '<tr>';
        $tbl .= '<td></td>';
        $tbl .= '<td><b>SMI GROUP</b></td>';
        $tbl .= '<td><b>' . $rkapsmi . '</b></td>';
        $tbl .= '<td><b><span class="' . $warnaMSsmi . '">' . $qtybulansmi . '</span></b></td>';
        $tbl .= '<td><b><span class="' . $warnaMSkumsmi . '">' . $qtykumsmi . '</span></b></td>';
        $tbl .= '<td align="right"><b><span class="' . $warnaMoM . '">' . $growthMoM . '% <i class="fa ' . $levelMoM . '"></i></span></b></td>';
        $tbl .= '<td align="right"><b><span class="' . $warnaYoY . '">' . $growthYoY . '% <i class="fa ' . $levelYoY . '"></i></span></b></td>';
        $tbl .= '<td align="right"><b><span class="' . $warnakumYoY . '">' . $growthkumYoY . '% <i class="fa ' . $levelkumYoY . '"></i></span></b></td>';
        $tbl .= '</tr>';
        $tbl .= $table;
        foreach ($data['footer']->result_array() as $row) {
            $bulanini = round(str_replace(',', '.', $row['REAL_BLN']));
            $bulankemarin = str_replace(',', '.', $row['REAL_BLN_K']);
            $tahunkemarin = str_replace(',', '.', $row['REAL_THN_K']);
            $realkumtahunini = str_replace(',', '.', $row['REAL_THNINI_KUM']);
            $realkumtahun = str_replace(',', '.', $row['REAL_THN_KUM']);

            if ($tahunkemarin == 0) {
                $growthYoY = 0;
            } else {
                $growthYoY = round((($bulanini - $tahunkemarin) / $tahunkemarin) * 100, 2);
            }
            if ($bulankemarin == 0) {
                $growthMoM = 0;
            } else {
                $growthMoM = round((($bulanini - $bulankemarin) / $bulankemarin) * 100, 2);
            }
            if ($realkumtahun == 0) {
                $growthkumYoY = 0;
            } else {
                $growthkumYoY = round((($realkumtahunini - $realkumtahun) / $realkumtahun) * 100, 2);
            }
            if ($bulanini > $bulankemarin) {
                $warnaMoM = 'hijau';
                $levelMoM = 'fa-level-up';
            } else {
                $warnaMoM = 'merah';
                $levelMoM = 'fa-level-down';
            }
            if ($bulanini > $tahunkemarin) {
                $warnaYoY = 'hijau';
                $levelYoY = 'fa-level-up';
            } else {
                $warnaYoY = 'merah';
                $levelYoY = 'fa-level-down';
            }
            if ($realkumtahunini > $realkumtahun) {
                $warnakumYoY = 'hijau';
                $levelkumYoY = 'fa-level-up';
            } else {
                $warnakumYoY = 'merah';
                $levelkumYoY = 'fa-level-down';
            }
        }
        $growMoM = '<span class="' . $warnaMoM . '">' . $growthMoM . '% <i class="fa ' . $levelMoM . '"></i></span>';
        $growYoY = '<span class="' . $warnaYoY . '">' . $growthYoY . '% <i class="fa ' . $levelYoY . '"></i></span>';
        $growkumYoY = '<span class="' . $warnakumYoY . '">' . $growthkumYoY . '% <i class="fa ' . $levelkumYoY . '"></i></span>';
        echo json_encode(array("table" => $tbl, "porsi" => $bulanini, "growthYOY" => $growYoY, "growthMOM" => $growMoM, "growthkumYOY" => $growkumYoY));
    }

    function getDetail2($org, $prov, $tahun, $bulan) {
        $data = $this->MarketShare_model->getDetail2($prov, $tahun, $bulan);
        $no = 1;
        $table = '';
        $prov = '';
        foreach ($data as $row) {
            if ($org == 1) {
                if ($row['KODE_PERUSAHAAN'] == '110' || $row['KODE_PERUSAHAAN'] == '112' || $row['KODE_PERUSAHAAN'] == '102') {
                    $table .= '<tr class="highlight">';
                } else {
                    $table .= '<tr>';
                }
            } else if ($org == 7000) {
                if ($row['KODE_PERUSAHAAN'] == '110') {
                    $table .= '<tr class="highlight">';
                } else {
                    $table .= '<tr>';
                }
            } else if ($org == 4000) {
                if ($row['KODE_PERUSAHAAN'] == '112') {
                    $table .= '<tr class="highlight">';
                } else {
                    $table .= '<tr>';
                }
            } else if ($org == 3000) {
                if ($row['KODE_PERUSAHAAN'] == '102') {
                    $table .= '<tr class="highlight">';
                } else {
                    $table .= '<tr>';
                }
            }

            $table .= '<td align="center">' . $no . '</td>';
            $table .= '<td>' . $row['NAMA_PERUSAHAAN'] . '</td>';
            $table .= '<td align="right">' . number_format(round($row['QTY_REAL']), 0, '', '.') . '</td>';
            $table .= '<td align="right">' . round($row['QTY'], 2) . ' %</td>';
            $table .= '<td align="right">' . number_format(round($row['BAG']), 0, '', '.') . '</td>';
            $table .= '<td align="right">' . number_format(round($row['BULK']), 0, '', '.') . '</td>';
            $table .= '<td align="right">% <i class="fa fa-level-up"></i></td>';
            $table .= '<td align="right">% <i class="fa fa-level-down"></i></td>';
            $table .= '<td>% <i class="fa fa-level-up"></i></td>';
            $table .= '<td>% <i class="fa fa-level-down"></i></td>';
            $table .= '</tr>';
            $no++;
            $prov = $row['NM_PROV'];
        }
        echo json_encode(array("table" => $table, "provinsi" => $prov));
    }

    function getUpdateDate() {
        $data = $this->MarketShare_model->updateDate();
        echo json_encode($data);
    }

    function rkapsi($tahun) {
        $data = $this->MarketShare_model->getRkap($tahun);
        $target = 0;
        foreach($data as $value){
            $n = str_replace(',', '.', $value['TARGET']);
            $rkap[$value['KODE_PERUSAHAAN']] = $n;
            $target += $n;
        }
        $rkap['smigroup'] = $target;
        return $rkap;
    }


    function coba() {
        $data = $this->MarketShare_model->getSummary('2016', '01');
        echo '<pre>';
        print_r($data['footer']->result_array());
        echo '</pre>';
    }    
    
    function getChartGrowth($org) {
        $type = $this->input->post(null, true);
        $this->load->model('DemandplMS_model');
//        $nPerusahaan = $this->DemandplMS_model->getNumPerusahaan();
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $tahun = substr($awal, 0, 4);
        $bulan = substr($awal, 4, 5);
        $tahunAkhir = substr($akhir, 0, 4);
        $bulanAkhir = substr($akhir, 4, 5);
        $tandabulan = 0;
        
        $awal = $tahun.'-'.$bulan.'-01';
        $akhir = $tahunAkhir.'-'.$bulanAkhir.'-01';
        
        $dateAwal = new DateTime($awal);        
        $dateAkhir = new DateTime($akhir);
        if($dateAwal == $dateAkhir){
            $dateAkhir->modify('+1 months');
        }
        
        for($i = $dateAwal ; $i < $dateAkhir ;){
            $keybulan = $i->format('m');
            $tahun = $i->format('Y');
            $data[$tahun . '' . $keybulan] = $this->DemandplMS_model->getDataASI($tahun, $keybulan);
            $dataDN[$tahun . '' . $keybulan] = $this->DemandplMS_model->getDataASIGDN($tahun, $keybulan);            
            $i->modify('+1 months');                                   
        }
//        echo '<pre>';
//        print_r($data);
//        print_r($dataDN);
//        echo '</pre>';
        /*
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
        }*/
        
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
        $nPerusahaan = $n;
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
//        echo '<pre>';
//        print_r($arr);
//        echo '</pre>';
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
//            echo '<pre>';
//        print_r($arr);
//        echo '</pre>';


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
//        echo count($data).' | '.count($dataDN);
        echo json_encode(array("labels" => $labels, "growth" => $arr));
    }
    
    function marketVolume($kodeperusahaan){
        $smi = array('110','112','102');
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $tipe = $this->input->post('type');
        $data = $this->MarketShare_model->marketVolume($awal,$akhir,$tipe);
        $labels = array();
        $dataPerusahaan = array(
            'SMI' => array('data' => array(),'label'=>'SEMEN INDONESIA'),
            'DN' => array('data' => array(),'label'=>'DEMAND NASIONAL')
        );
        
        foreach($data as $d){
            if(!in_array($d['BULAN'],$labels)){
               array_push($labels,$d['BULAN']); 
            }
            $kodeperusahaan = $d['KODE_PERUSAHAAN'];
            if(!isset($dataPerusahaan[$kodeperusahaan])){
                $dataPerusahaan[$kodeperusahaan] = array('data'=>array(),'label'=>$d['NAMA_PERUSAHAAN']);
            }
            $dataPerusahaan[$kodeperusahaan]['data'][$d['BULAN']] = $d['QTY'];
            if(in_array($kodeperusahaan,$smi)){
                if(!isset($dataPerusahaan['SMI']['data'][$d['BULAN']])){
                    $dataPerusahaan['SMI']['data'][$d['BULAN']] = 0;
                }
                $dataPerusahaan['SMI']['data'][$d['BULAN']] += $d['QTY'];
            }
            if(!isset($dataPerusahaan['DN']['data'][$d['BULAN']])){
                $dataPerusahaan['DN']['data'][$d['BULAN']] = 0;
            }
            $dataPerusahaan['DN']['data'][$d['BULAN']] += $d['QTY'];
        }/*
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
        }*/
        $arr = array();
        $n = 0;
        $khusus = array();
        foreach($dataPerusahaan as $kd => $prsh){            
            $tmp = array(
                'label' => $prsh['label'],
                'data' => array_values($prsh['data']),
                'fill' => false,
                'hidden' => in_array($kd,array('SMI','DN')) ? false : true,
                'lineTension' => 0,
                'borderColor' => $this->warna($n),
                'backgroundColor' => $this->warna($n)
            );            
            $n++;
            if(in_array($kd,array('SMI','DN'))){
                array_push($khusus,$tmp);
            }else{
                array_push($arr,$tmp);
            }            
        }
        
        /* tambahkan untuk SMI dan DN */
        echo json_encode(array("labels" => $labels, "datas" => array_merge($arr,$khusus)));
    }
    
    function dataHistory($awal,$akhir){
        $data = $this->MarketShare_model->dataHistory($awal,$akhir);
        /* grouping berdasarkan bulantahun,propinsi*/
        $dExcel = array();
        $listPerusahaan = array();
        $listPropinsi = array();
        foreach($data as $d){
            $tahunbulan = $d['TAHUNBULAN'];
            $propinsi = $d['PROPINSI'];
            $kodeperusahaan = $d['KODE_PERUSAHAAN'];
            if(!isset($listPerusahaan[$kodeperusahaan])){
                $listPerusahaan[$kodeperusahaan] = $d['NAMA_PERUSAHAAN'];
            }
            if(!isset($listPropinsi[$propinsi])){
                $listPropinsi[$propinsi] = $d['NM_PROV'];
            }
            $tipe = $d['TIPE'];
            if(!isset($dExcel[$tahunbulan])){
                $dExcel[$tahunbulan] = array();
            }
            if(!isset($dExcel[$tahunbulan][$propinsi])){
                $dExcel[$tahunbulan][$propinsi] = array();
            }
            if(!isset($dExcel[$tahunbulan][$propinsi][$kodeperusahaan])){
                $dExcel[$tahunbulan][$propinsi][$kodeperusahaan] = array();
            }
            $dExcel[$tahunbulan][$propinsi][$kodeperusahaan][$tipe] = $d['QTY_REAL'];
        }        
        $jenisKemasan = array('121-301' => 'Bag', '121-302'=>'Bulk');
        /* rubah menjadi excel */
        $this->load->library('Excel');        
        $objPHPExcel = new PHPExcel();        
        $indexSheet = 0;
        foreach($dExcel as $tb => $perbulan){
            $objPHPExcel->setActiveSheetIndex($indexSheet);
            /* buat header */
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Tahun : '.substr($tb,0,4));
            $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Bulan : '.substr($tb,-2));
            
            $objPHPExcel->getActiveSheet()->setCellValue('A4', 'No');
            $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Kode');
            $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Daerah');
            
            $awalheader = ord('D');    
            $indexCell = $awalheader;
            foreach($listPerusahaan as $kp => $np){
                //$objPHPExcel->getActiveSheet()->setCellValue($this->getCellCharacter($indexCell).'4:'.$this->getCellCharacter(++$indexCell).'4', $np);
                $objPHPExcel->getActiveSheet()->setCellValue($this->getCellCharacter($indexCell).'4', $np);
                $indexCell += 2;
            }
            $indexCell = $awalheader;
            foreach($listPerusahaan as $kp => $np){
                foreach($jenisKemasan as $nk){
                    $objPHPExcel->getActiveSheet()->setCellValue($this->getCellCharacter($indexCell).'5', $nk);
                    $indexCell++;
                }                                                    
            }
                                    
            $awalBody = ord('A');            
            $no = 1;
            $indexBaris = 6;
            foreach($perbulan as $kp => $perpropinsi){
                $indexCell = $awalBody;
                $objPHPExcel->getActiveSheet()->setCellValue($this->getCellCharacter($indexCell).$indexBaris, $no++);
                $objPHPExcel->getActiveSheet()->setCellValue($this->getCellCharacter(++$indexCell).$indexBaris, $kp);
                $objPHPExcel->getActiveSheet()->setCellValue($this->getCellCharacter(++$indexCell).$indexBaris, $listPropinsi[$kp]);                                               
                foreach($listPerusahaan as $kp => $np){
                    foreach($jenisKemasan as $nk => $nkemasan){
                        $qty = 0;
                        if(isset($perpropinsi[$kp])){
                           if(isset($perpropinsi[$kp][$nk])){
                               $qty = $perpropinsi[$kp][$nk];
                           } 
                        }                        
                        $objPHPExcel->getActiveSheet()->setCellValue($this->getCellCharacter(++$indexCell).$indexBaris, number_format($qty,0,',','.'));                                                                       
            //            echo $this->getCellCharacter($indexCell);echo ' asli'. $indexCell.'<br >';
                        
                        
                    }                   
                }
                $indexBaris++;
            }           
            $objPHPExcel->getActiveSheet()->setTitle('_sheet '.$tb);
            $indexSheet++;
            $objPHPExcel->createSheet();
        }
        $namafile = 'Marketshare_'.$awal.'_sd_'.$akhir.'.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$namafile.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("php://output");  
    }
    
    public function getCellCharacter($number){
        $max = ord('Z');
        $min = ord('A');
        if($number > $max){
            return 'A'.chr(64 + $number - $max);
        }else{
            return chr($number);
        }
        
    }
    
    function warna($n) {
        $warna = array("#FF0000", "#FFFF00", "#FF8000", "#80FF00", "#00FF00", "#00FF80", "#00FFFF",
            "#0080FF", "#0000FF", "#7F00FF", "#FF00FF", "#FF007F", "#FF9999", "#B266FF", "#F0000F", "#FF9922");
        return $warna[$n];
    }
}

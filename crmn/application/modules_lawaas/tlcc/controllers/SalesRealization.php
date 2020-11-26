<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class SalesRealization extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('SalezRealization_model');
        //
        error_reporting(0);
    }

    function index() {
        $data = array('title' => 'Sales Realization');
        $this->template->display('SalesRealization_view', $data);
    }

    function getData($org, $tahun, $bulan) {
//        $tahun = date("Y");
//        $bulan = date("m");
        $arrData = array(
            "chart" => array(
                "caption" => "Sales Realization of TLCC",
                "theme" => "fint",
                "formatNumberScale" => "0",
                //"numberScaleValue" => "1,1000000,10000000",
                //"numberScaleUnit" => "K,M,B",
                "numberSuffix" => "%",
                "showLabels" => "1",
                "includeNameInLabels" => "1",
                "nullEntityColor" => "#C2C2D6",
                "nullEntityAlpha" => "50",
                "hoverOnNull" => "0",
                "useSNameInLabels" => "1",
                "legendPosition" => "bottom",
                "showToolTip" => "1",
                "baseFontSize" => "11",
                "toolTipBgColor" => "#E0E0E0"
            ),

            //kode asli
           // "colorrange" => array(
             //   "color" => array(
               //     array(
                 //       "minvalue" => "0",
                   //     "maxvalue" => "98",
                     //   "code" => "#e1e1eb",
                      //  "displayValue" => "Belum Ada Realisasi"
                   // ),
                   // array(
                     //   "minvalue" => "100",
                       // "maxvalue" => "1000",
                       // "code" => "#49ff56",
                       // "displayValue" => "Ada Realisasi"
                    //)
                //)
            //)
            "colorrange" => array(
                "color" => array(
                    array(
                        "minvalue" => "-1000",
                        "maxvalue" => "-101",
                        "code" => "#e1e1eb",
                        "displayValue" => " Tidak ada realisasi"
                    ),
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

                ))
            ,
            //kode terakhir asli
            "entityDef" => array(
                array(
                    "internalId" => "VN.AG",
                    "newId" => "6001"
                ),
                array(
                    "internalId" => "VN.BV",
                    "newId" => "6002"
                ),
                array(
                    "internalId" => "VN.BG",
                    "newId" => "6003"
                ),
                array(
                    "internalId" => "VN.BK",
                    "newId" => "6004"
                ),
                array(
                    "internalId" => "VN.BL",
                    "newId" => "6005"
                ),
                array(
                    "internalId" => "VN.BN",
                    "newId" => "6006"
                ),
                array(
                    "internalId" => "VN.BR",
                    "newId" => "6007"
                ),
                array(
                    "internalId" => "VN.BD",
                    "newId" => "6008"
                ),
                array(
                    "internalId" => "VN.BI",
                    "newId" => "6009"
                ),
                array(
                    "internalId" => "VN.BP",
                    "newId" => "6010"
                ),
                array(
                    "internalId" => "VN.BU",
                    "newId" => "6011"
                ),
                array(
                    "internalId" => "VN.CM",
                    "newId" => "6012"
                ),
                array(
                    "internalId" => "VN.CN",
                    "newId" => "6013"
                ),
                array(
                    "internalId" => "VN.CB",
                    "newId" => "6014"
                ),
                array(
                    "internalId" => "VN.DA",
                    "newId" => "6015"
                ),
                array(
                    "internalId" => "VN.DC",
                    "newId" => "6016"
                ),
                array(
                    "internalId" => "VN.DO",
                    "newId" => "6017"
                ),
                array(
                    "internalId" => "VN.DB",
                    "newId" => "6018"
                ),
                array(
                    "internalId" => "VN.DN",
                    "newId" => "6019"
                ),
                array(
                    "internalId" => "VN.DT",
                    "newId" => "6020"
                ),
                array(
                    "internalId" => "VN.GL",
                    "newId" => "6021"
                ),
                array(
                    "internalId" => "VN.HG",
                    "newId" => "6022"
                ),
                array(
                    "internalId" => "VN.HM",
                    "newId" => "6023"
                ),
                array(
                    "internalId" => "VN.HN",
                    "newId" => "6024"
                ),
                array(
                    "internalId" => "VN.HT",
                    "newId" => "6025"
                ),
                array(
                    "internalId" => "VN.HD",
                    "newId" => "6026"
                ),
                array(
                    "internalId" => "VN.HP",
                    "newId" => "6027"
                ),
                array(
                    "internalId" => "VN.HU",
                    "newId" => "6028"
                ),
                array(
                    "internalId" => "VN.HC",
                    "newId" => "6029"
                ),
                array(
                    "internalId" => "VN.HO",
                    "newId" => "6030"
                ),
                array(
                    "internalId" => "VN.HY",
                    "newId" => "6031"
                ),
                array(
                    "internalId" => "VN.KH",
                    "newId" => "6032"
                ),
                array(
                    "internalId" => "VN.KG",
                    "newId" => "6033"
                ),
                array(
                    "internalId" => "VN.KT",
                    "newId" => "6034"
                ),
                array(
                    "internalId" => "VN.LI",
                    "newId" => "6035"
                ),
                array(
                    "internalId" => "VN.LD",
                    "newId" => "6036"
                ),
                array(
                    "internalId" => "VN.LS",
                    "newId" => "6037"
                ),
                array(
                    "internalId" => "VN.LO",
                    "newId" => "6038"
                ),
                array(
                    "internalId" => "VN.LA",
                    "newId" => "6039"
                ),
                array(
                    "internalId" => "VN.ND",
                    "newId" => "6040"
                ),
                array(
                    "internalId" => "VN.NA",
                    "newId" => "6041"
                ),
                array(
                    "internalId" => "VN.NB",
                    "newId" => "6042"
                ),
                array(
                    "internalId" => "VN.NT",
                    "newId" => "6043"
                ),
                array(
                    "internalId" => "VN.PT",
                    "newId" => "6044"
                ),
                array(
                    "internalId" => "VN.PY",
                    "newId" => "6045"
                ),
                array(
                    "internalId" => "VN.QB",
                    "newId" => "6046"
                ),
                array(
                    "internalId" => "VN.QM",
                    "newId" => "6047"
                ),
                array(
                    "internalId" => "VN.QG",
                    "newId" => "6048"
                ),
                array(
                    "internalId" => "VN.QN",
                    "newId" => "6049"
                ),
                array(
                    "internalId" => "VN.QT",
                    "newId" => "6050"
                ),
                array(
                    "internalId" => "VN.ST",
                    "newId" => "6051"
                ),
                array(
                    "internalId" => "VN.SL",
                    "newId" => "6052"
                ),
                array(
                    "internalId" => "VN.TN",
                    "newId" => "6053"
                ),
                array(
                    "internalId" => "VN.TB",
                    "newId" => "6054"
                ),
                array(
                    "internalId" => "VN.TY",
                    "newId" => "6055"
                ),
                array(
                    "internalId" => "VN.TH",
                    "newId" => "6056"
                ),
                array(
                    "internalId" => "VN.TT",
                    "newId" => "6057"
                ),
                array(
                    "internalId" => "VN.TG",
                    "newId" => "6058"
                ),
                array(
                    "internalId" => "VN.TV",
                    "newId" => "6059"
                ),
                array(
                    "internalId" => "VN.TQ",
                    "newId" => "6060"
                ),
                array(
                    "internalId" => "VN.VL",
                    "newId" => "6061"
                ),
                array(
                    "internalId" => "VN.VC",
                    "newId" => "6062"
                ),
                array(
                    "internalId" => "VN.VB",
                    "newId" => "6063"
                )
            )
        );

        $arrData["data"] = array();

        if ($bulan == date('m')) {
            $tanggal = date("Ymd");
            $hari = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }

        $data = $this->SalezRealization_model->SalesProvinceTLCC($tahun, $bulan, $hari);

        foreach ($data as $row) {
            $realbag = round(str_replace(',', '.', $row["REAL_BAG"]));
            $realbulk = round(str_replace(',', '.', $row["REAL_BULK"]));
            $real = round(str_replace(',', '.', $row["TOTAL_REAL"]));
            $maxharian = round(str_replace(',', '.', $row["MAXREAL"]));

            $color = '#fef536';
            $persen = intval($row["TOTAL_REAL"]/$row['RKAP']*100);
            //kode tambahan
              $persenku = round($persen);
            if ($persenku >= -100 && $persenku <= 90) {
                $color = '#ff4545';
            } else if ($persenku >= 90 && $persenku < 100) {
                $color = '#fef536';
            } else if ($persenku >= 100) {
                $color = '#49ff56';
            }
            //

            //
            $tooltip = "<table style='color:black;width:150px;'>
                            <thead>
                            <tr><th colspan='2' style='background-color:$color'><b>" . $row['NM_PROV'] . "</b></th></tr>
                            </thead>
                            <tbody>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Pencapaian Target RKAP :</td>
                                    <td><span class='pull-right'>" . $persen . " %</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Pencapaian Target Harian :</td>
                                    <td><span class='pull-right'>" . '-' . " %</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>RKAP :</td>
                                    <td><span class='pull-right'>" . number_format($row['RKAP'], 0, '', '.') . " Ton</span></td>
                                </tr>
                                <tr>
                                    <td colspan='2'>Realisasi</td>
                                </tr>
                                <tr>
                                    <td>Bag :</td>
                                    <td><span class='pull-right'>$realbag Ton</span></td>
                                </tr>
                                <tr>
                                    <td>Bulk :</td>
                                    <td><span class='pull-right'>$realbulk Ton</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Total :</td>
                                    <td><span class='pull-right'>$real Ton</span></td>
                                </tr>
                                <tr>
                                    <td>Max Real / day :</td>
                                    <td><span class='pull-right' style='color:blue'>$maxharian Ton</span></td>
                                </tr>
                                <tr>
                                    <td>Plan Target / day :</td>
                                    <td><span class='pull-right' style='color:blue'>" . '-' . " Ton</span></td>
                                </tr>
                            </tbody>
                        </table>";
            array_push($arrData["data"], array(
                "id" => $row["PROV"],
//                "value" => '100',
                "value" => round ($persen),
                "toolText" => $tooltip
            ));
        }

        echo json_encode($arrData);
    }

    public function sumSales($tahun, $bulan) {
        $data = $this->SalezRealization_model->sumSalesTLCC($tahun, $bulan);

        $result = array(
            'RKAP' => number_format($data['RKAP'], 0, ",", "."),
            'REAL_SDK' => number_format($data['REAL_SDK'], 0, ",", "."),
            'PERSEN' => ($data['RKAP'] == 0) ? 0 : round($data['REAL_SDK'] / $data['RKAP'] * 100),
            'PERSEN_SDK' => ($data['RKAP_SDK'] == 0) ? 0 : round($data['REAL_SDK'] / $data['RKAP_SDK'] * 100),
        );
        echo json_encode($result);
    }

}

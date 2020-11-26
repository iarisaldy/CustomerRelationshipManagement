<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class MonitoringMargin_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function revenueRegion($region, $tahun, $bulan) {
        $hari = date('d');
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }

        $data = $this->db->query(" 
            SELECT
                    TB0.ID_PROV,
                    TB0.NM_PROV,
                    SUM(TB2.TARGET_REVENUE) TARGET_REVENUE,
                    (
                            CASE
                            WHEN SUM (vol) <= 0 THEN
                                    0
                            ELSE
                                    SUM (HRG) / SUM (vol)
                            END - CASE
                            WHEN SUM (vol) <= 0 THEN
                                    1
                            ELSE
                                    SUM (OA) / SUM (vol)
                            END
                    ) * SUM (vol) REAL_REVENUE
            FROM
                    (
                            SELECT
                                    NO_URUT,
                                    A .ID_KABIRO,
                                    A.ID_PROV,
                                    NM_PROV,
                                    MATERIAL,
                                    NAMA_KABIRO,
                                    DESC_KABIRO
                            FROM
                                    ZREPORT_SCM_M_KABIROREGION A
                            LEFT JOIN ZREPORT_SCM_MATERIALREGION B ON A .ID_REGION = B.ID_REGION
                            LEFT JOIN ZREPORT_SCM_M_KABIRO C ON A .ID_KABIRO = C.ID_KABIRO
                            LEFT JOIN ZREPORT_M_PROVINSI D ON  A.ID_PROV = D.KD_PROV
                            WHERE
                                    A .ID_REGION IN ($region)
                    ) TB0 
            LEFT JOIN (
                    SELECT
                                A .PROPINSI_TO PROV,
                                A .MATERIAL,
                               hrg,
                                hrg_qty,
                                oa,
                                oa_qty,
                                vol
                        FROM
                                (
                                        SELECT
                                                PROPINSI_TO,
                                                SUBSTR(ITEM,1,7) MATERIAL,
                                                SUM (HARGA) HRG,
                                                SUM (KWANTUMX) HRG_QTY
                                        FROM
                                                ZREPORT_SCM_HARGA
                                        WHERE
                                                BULAN = '$bulan'
                                        AND TAHUN = '$tahun'
                                        AND HARI <= '$harik'
                                       
                                        GROUP BY
                                                PROPINSI_TO,
                                                SUBSTR(ITEM,1,7)
                                ) A
                        LEFT JOIN (
                            SELECT
                                    PROV PROPINSI_TO,
                                    SUBSTR(MATERIAL,1,7) MATERIAL,
                                   SUM (QTY) oa_qty,
                                    SUM (OA) oa
                            FROM
                                    ZREPORT_SCM_OA
                            WHERE
                                    TAHUN = '$tahun'
                            AND BULAN = '$bulan'
                            AND HARI <= '$harik'
                            GROUP BY
                                    SUBSTR(MATERIAL,1,7),
                                    PROV
                    ) B ON A .PROPINSI_TO = B.PROPINSI_TO
                    AND A .MATERIAL = B.MATERIAL
                    LEFT JOIN (
                            SELECT
                                    PROPINSI_TO,
                                    SUBSTR(ITEM,1,7) MATERIAL,
                                    SUM (QTY) VOL
                            FROM
                                    ZREPORT_SCM_REAL_SALES
                            WHERE
                                    BULAN = '$bulan'
                            AND HARI <= '$harik'
                            AND TAHUN = '$tahun'
                            
                            GROUP BY
                                    PROPINSI_TO,
                                    SUBSTR(ITEM,1,7)
                    ) C ON A .PROPINSI_TO = C.PROPINSI_TO
                    AND A .MATERIAL = C.MATERIAL
            ) TB1 ON TB1.PROV = TB0.ID_PROV AND TB1.MATERIAL = TB0.MATERIAL
            LEFT JOIN (
                    SELECT
                            prov,
                            TIPE,
                            SUM (TARGET_REVENUE) AS TARGET_REVENUE
                    FROM
                            (
                                    SELECT
                                            *
                                    FROM
                                            (
                                                    SELECT
                                                            A.tipe,
                                                            A .prov,
                                                            c.budat,
                                                            SUM (
                                                                    A .revenue * (c.porsi / D .total_porsi)
                                                            ) AS target_revenue
                                                    FROM
                                                            sap_t_rencana_sales_type A
                                                    LEFT JOIN zreport_m_provinsi b ON A .prov = b.kd_prov
                                                    LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                                    AND c.vkorg = A .co
                                                    AND c.budat LIKE '$tahun$bulan%'
                                                    AND c.tipe = A .tipe
                                                    LEFT JOIN (
                                                            SELECT
                                                                    vkorg,
                                                                    region,
                                                                    tipe,
                                                                    SUM (porsi) AS total_porsi
                                                            FROM
                                                                    zreport_porsi_sales_region
                                                            WHERE
                                                                    budat LIKE '$tahun$bulan%'
                                                            GROUP BY
                                                                    vkorg,
                                                                    region,
                                                                    tipe
                                                    ) D ON c.region = D .region
                                                    AND D .tipe = A .tipe
                                                    AND A .co = D .vkorg
                                                    WHERE
                                                            co IN (
                                                                    '7000',
                                                                    '5000',
                                                                    '4000',
                                                                    '3000'
                                                            )
                                                    AND thn = '$tahun'
                                                    AND bln = '$bulan'
                                                    GROUP BY
                                                            A.tipe,
                                                            co,
                                                            thn,
                                                            bln,
                                                            A .prov,
                                                            c.budat
                                            )
                                    WHERE
                                            budat <= '$tahun$bulan$harik'
                            )
                    GROUP BY
                            TIPE,
                            prov
            ) TB2 ON TB2.PROV = TB0.ID_PROV  AND TB2.TIPE = TB0.MATERIAL
            GROUP BY ID_PROV,NM_PROV
                 ");
        return $data->result_array();
    }

    function get_distrik($prov, $tahun, $bulan, $mat) {
        $hari = date('d');
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $resPlant = $this->getPlant($prov, $bulan, $tahun, $harik, $mat);
        $plantIn = array();
        foreach ($resPlant as $key => $value) {
            $plantIn[] = $value['PLANT'];
        }
        $dtPlant = implode(",", $plantIn);
        $data = $this->getKDDistrik($prov);
        $prov2 = array();
        $tahunlalu = $tahun - 1;

        //sementara
        $provin2 = array();
        //---------
        foreach ($data as $key => $value) {
            $prov2[] = $value['BZIRK'];
            //$provin2 += "sys.odciobject('".$value['BZIRK']."','".$value['BZTXT']."')";
        }

        $provin = implode("','", $prov2);
        $provin2T = implode(",", $provin2);

        $result = $this->db->query("
            SELECT
                    *
            FROM (
                SELECT
                        BZIRK KD_KOTA
                        
                FROM
                        RFC_Z_ZAPPSD_BZIRK
                WHERE BZIRK LIKE '" . substr($prov, 2) . "%'
            ) TB0 LEFT JOIN 
                    (
                            SELECT
                                    KD_KOTA KOTA,
                                    SUM (TARGET) TARGET,
                                    TAHUN,
                                    BULAN
                            FROM
                                    ZREPORT_TARGET_PLANT
                            WHERE
                                    BULAN = '$bulan'
                            AND TAHUN = '$tahun'
                            AND ITEM_NO IN ($mat)
                            GROUP BY
                                    KD_KOTA,
                                    BULAN,
                                    TAHUN
                    ) TB2 ON TB0.KD_KOTA = TB2.KOTA
                LEFT JOIN (
                    SELECT
                            KOTA,
                            SUM (QTY) REALISASI
                    FROM
                            ZREPORT_SCM_REAL_SALES_DISTRIK
                    WHERE
                            BULAN = '$bulan'
                    AND HARI <= '$harik'
                    AND TAHUN = '$tahun'
                    AND ITEM IN ($mat)
                    GROUP BY
                            KOTA
                ) TB1 ON TB1.KOTA =   TB0.KD_KOTA
            LEFT JOIN (
                    SELECT
                            *
                    FROM
                            (
                                    SELECT
                                            KOTA,
                                            PLANT,
                                            SUM (QTY) REALISASI
                                    FROM
                                            ZREPORT_SCM_REAL_SALES_DISTRIK
                                    WHERE
                                            BULAN = '$bulan'
                                    AND TAHUN = '$tahun'
                                    AND HARI <= '$harik'
                                    AND ITEM IN ($mat)
                                    GROUP BY
                                            KOTA,
                                            PLANT
                            ) 
                    PIVOT (
                                    SUM (REALISASI) FOR PLANT IN (
                                                    $dtPlant

                                    )
                            )
            ) TB3 ON TB3.KOTA = TB0.KD_KOTA
            LEFT JOIN (
                 SELECT
                            KOTA,
                            SUM (QTY) REALTHNLALU
                    FROM
                            ZREPORT_SCM_REAL_SALES_DISTRIK
                    WHERE
                            BULAN = '$bulan'
                    AND TAHUN = '$tahunlalu'
                    AND ITEM IN ($mat)
                    GROUP BY
                            KOTA
            ) TB4 ON TB4.KOTA = TB0.KD_KOTA
            WHERE
                REALTHNLALU IS NOT NULL
                OR REALISASI IS NOT NULL
                ORDER BY TB0.KD_KOTA
                ");
//          echo $this->db->last_query();
        return $result->result_array();
    }

    function getDistrikHbruto($prov, $tahun, $bulan, $mat) {
        $hari = date('d');
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $resPlant = $this->getPlant($prov, $bulan, $tahun, $harik, $mat);
        $plantIn = array();
        foreach ($resPlant as $key => $value) {
            $plantIn[] = $value['PLANT'];
        }
        $dtPlant = implode(",", $plantIn);
        $data = $this->getKDDistrik($prov);
        $prov2 = array();
        $tahunlalu = $tahun - 1;

        $distrikin = array();
        foreach ($data as $key => $value) {
            $prov2[] = $value['BZIRK'];
            $distrikin[] = "sys.odciobject ('" . $value['BZIRK'] . "','" . $value['BZTXT'] . "')";
        }

        $disS = implode(",", $distrikin);

        $provin = implode("','", $prov2);
        $result = $this->db->query("
            SELECT
                    *
            FROM    
                    (
                           SELECT
                                    BZIRK kd_kota,
                                    BZTXT nm_kota
                            FROM
                                    RFC_Z_ZAPPSD_BZIRK
                            WHERE BZIRK LIKE '" . substr($prov, 2) . "%'
                    ) TB0
            LEFT JOIN (
                    SELECT
                            KD_KOTA KOTA,
                            SUM (TARGET) TARGET,
                            TAHUN,
                            BULAN
                    FROM
                            ZREPORT_TARGET_PLANT
                    WHERE
                            BULAN = '$bulan'
                    AND TAHUN = '$tahun'
                    AND ITEM_NO IN ($mat)
                    GROUP BY
                            KD_KOTA,
                            BULAN,
                            TAHUN
            ) TB2 ON TB0.KD_KOTA = TB2.KOTA
            LEFT JOIN (
                SELECT
                    A.KOTA,
                    HARGA/VOL REALISASI
                FROM (
                     SELECT
                            KOTA,
                            SUM (QTY) VOL
                    FROM
                            ZREPORT_SCM_REAL_SALES_DISTRIK
                    WHERE
                            BULAN = '$bulan'
                    AND HARI <= '$harik'
                    AND TAHUN = '$tahun'
                    AND ITEM IN ($mat)
                    GROUP BY
                            KOTA
                ) A LEFT JOIN (
                    SELECT
                            KOTA,
                            SUM(HARGA) HARGA,
                            SUM(KWANTUMX) HARGA_QTY
                    FROM
                            ZREPORT_SCM_HARGA
                    WHERE
                            BULAN = '$bulan'
                    AND TAHUN = '$tahun'
                     AND HARI <= '$harik'
                    AND ITEM IN ($mat)
                    GROUP BY
                            KOTA
                ) B ON A.KOTA = B.KOTA
            ) TB1 ON TB1.KOTA = TB0.KD_KOTA
            LEFT JOIN (
                    SELECT
                            *
                    FROM
                            (
                                SELECT 
                                    A.KOTA,
                                    B.NM_KOTA,
                                    A.PLANT,
                                    HARGA/VOL REALISASI
                                FROM (
                                     SELECT
                                            KOTA,
                                            PLANT,
                                            SUM (QTY) VOL
                                    FROM
                                            ZREPORT_SCM_REAL_SALES_DISTRIK
                                    WHERE
                                            BULAN = '$bulan'
                                    AND TAHUN = '$tahun'
                                    AND HARI <= '$harik'
                                    AND ITEM IN ($mat)
                                    GROUP BY
                                            KOTA,
                                            PLANT
                                ) A LEFT JOIN (
                                    SELECT
                                            KOTA,
                                            NM_KOTA,
                                            PLANT,
                                            
                                            SUM(HARGA) HARGA,
                                            SUM(KWANTUMX) HARGA_QTY
                                    FROM
                                            ZREPORT_SCM_HARGA
                                    WHERE
                                            BULAN = '$bulan'
                                    AND TAHUN = '$tahun'
                                     AND HARI <= '$harik'
                                    AND ITEM IN ($mat)
                                    GROUP BY
                                            KOTA,
                                            NM_KOTA,
                                            PLANT
                                ) B ON A.KOTA=B.KOTA AND A.PLANT=B.PLANT
                                WHERE NM_KOTA IS NOT NULL
                            ) PIVOT (
                                    SUM (REALISASI) FOR PLANT IN (
                                            $dtPlant
                                    )
                            )
            ) TB3 ON TB3.KOTA = TB0.KD_KOTA OR TB3.NM_KOTA = TB0.NM_KOTA
            LEFT JOIN (
                    SELECT
                    A.KOTA ,
                    HARGA/VOL REALTHNLALU
                FROM (
                     SELECT
                            KOTA,
                            SUM (QTY) VOL
                    FROM
                            ZREPORT_SCM_REAL_SALES_DISTRIK
                    WHERE
                            BULAN = '$bulan'
                    AND HARI <= '$harik'
                    AND TAHUN = '$tahunlalu'
                    AND ITEM IN ($mat)
                    GROUP BY
                            KOTA
                ) A LEFT JOIN (
                    SELECT
                            KOTA,
                            SUM(HARGA) HARGA,
                            SUM(KWANTUMX) HARGA_QTY
                    FROM
                            ZREPORT_SCM_HARGA
                    WHERE
                            BULAN = '$bulan'
                    AND TAHUN = '$tahunlalu'
                     AND HARI <= '$harik'
                    AND ITEM IN ($mat)
                    GROUP BY
                            KOTA
                ) B ON A.KOTA = B.KOTA
            ) TB4 ON TB4.KOTA = TB0.KD_KOTA
             WHERE
             REALISASI IS NOT NULL
            ORDER BY
                    TB0.KD_KOTA
                 ");
       
        return $result->result_array();
    }

    function getKDDistrik($prov) {
        $this->db2 = $this->load->database('scmproduction', TRUE);
        $this->db2->select('BZIRK, BZTXT');
        $this->db2->from('RFC_Z_ZAPPSD_BZIRK');
        $this->db2->where("BZIRK LIKE '" . substr($prov, 2) . "%'");
        $data = $this->db2->get();
        return $data->result_array();
    }

    function getPlant($prov, $bulan, $tahun, $hari, $mat) {
         $mat = "'121-301','121-302'";
        $plantIn = array();
        $plant = $this->db->query("
                  SELECT
                        PLANT,\"NAME\"
                FROM
                        ZREPORT_SCM_REAL_SALES_DISTRIK
                        LEFT JOIN ZREPORT_M_PLANT ON PLANT= KD_PLANT
                WHERE
                        BULAN = '$bulan'
                AND TAHUN = '$tahun'
                AND HARI <= '$hari'
                AND PROPINSI_TO = '$prov'
                AND ITEM IN ($mat)
                GROUP BY
                        PLANT, \"NAME\"
                ");

        return $plant->result_array();
    }

    function getPlantHbruto($prov, $bulan, $tahun, $hari, $mat) {
        //ganti rule maaf ribet
        $mat = "'121-301','121-302'";
        $plantIn = array();
        $plant = $this->db->query("
                  SELECT
                        PLANT,\"NAME\"
                FROM
                        ZREPORT_SCM_HARGA
                        LEFT JOIN ZREPORT_M_PLANT ON PLANT= KD_PLANT
                WHERE
                        BULAN = '$bulan'
                AND TAHUN = '$tahun'
                AND HARI <= '$hari'
                AND PROPINSI_TO = '$prov'
                AND ITEM IN ($mat)
                GROUP BY
                        PLANT, \"NAME\"
                ");

        return $plant->result_array();
    }

    function getKdPlantOA($prov, $bulan, $tahun, $hari, $mat) {
        $plantIn = array();
         $mat = "'121-301','121-302'";
        $plant = $this->db->query("
                SELECT
                        PLANT,\"NAME\"
                FROM
                        ZREPORT_SCM_OA
                        LEFT JOIN ZREPORT_M_PLANT ON PLANT= KD_PLANT
                WHERE
                        BULAN = '$bulan'
                AND TAHUN = '$tahun'
                AND HARI <= '$hari'
                AND PROV = '$prov'
                AND MATERIAL IN ($mat)
                GROUP BY
                        PLANT, \"NAME\"
            ");
        return $plant->result_array();
    }

    function getProvince($prov) {
        $this->db->select('NM_PROV');
        $this->db->from('ZREPORT_M_PROVINSI');
        $this->db->where('KD_PROV', $prov);
        $data = $this->db->get();
        $data = $data->row_array();
        return $data['NM_PROV'];
    }

    function getPencapaianS($tahun, $bulan, $prov, $tipe) {
        $hari = date('d');
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $result = $this->db->query("
            SELECT
                    TB0.PROV,
                    TARGET,
                    TARGETSDK,
                    ROUND(TARGETSDK/TARGET*100,1) PERSENSEH
            FROM
                    (
                            SELECT
                                    A .prov,
                                    SUM (A .quantum) AS target
                            FROM
                                    sap_t_rencana_sales_type A
                            WHERE
                                    A .thn = '$tahun'
                            AND A .bln = '$bulan'
                            AND A .TIPE IN ($tipe)
                            AND A .prov = '$prov'
                            GROUP BY
                                    A .prov
                    ) TB0
            LEFT JOIN (
                    SELECT
                            prov,
                            SUM (target_realh) TARGETSDK
                    FROM
                            (
                                    SELECT
                                            A .prov,
                                            A .tipe,
                                            c.budat,
                                            SUM (
                                                    A .quantum * (c.porsi / D .total_porsi)
                                            ) AS target_realh
                                    FROM
                                            sap_t_rencana_sales_type A
                                    LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                    AND c.vkorg = A .co
                                    AND c.budat LIKE '$tahun$bulan%'
                                    AND c.tipe = A .tipe
                                    LEFT JOIN (
                                            SELECT
                                                    vkorg,
                                                    region,
                                                    tipe,
                                                    SUM (porsi) AS total_porsi
                                            FROM
                                                    zreport_porsi_sales_region
                                            WHERE
                                                    budat LIKE '$tahun$bulan%'
                                            GROUP BY
                                                    vkorg,
                                                    region,
                                                    tipe
                                    ) D ON c.region = D .region
                                    AND D .tipe = A .tipe
                                    AND A .co = D .vkorg
                                    WHERE
                                            A .thn = '$tahun'
                                    AND A .bln = '$bulan'
                                    AND A .prov = '$prov'
                                    AND A .tipe IN ($tipe)
                                    GROUP BY
                                            A .thn,
                                            A .bln,
                                            A .prov,
                                            A .tipe,
                                            c.budat
                            )
                    WHERE
                            budat <= '$tahun$bulan$hari'
                    GROUP BY
                            PROV
            ) TB1 ON TB1.PROV = TB0.PROV
                ");
        // echo $this->db->last_query();
        return $result->row_array();
    }

    function AvgHBruto($prov, $tahun, $bulan, $mat) {
        $hari = date('d');
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $resPlant = $this->getPlant($prov, $bulan, $tahun, $harik, $mat);
        $plantIn = array();
        foreach ($resPlant as $key => $value) {
            $plantIn[] = $value['PLANT'];
        }
        $dtPlant = implode(",", $plantIn);


        $dataDistrik = $this->getKDDistrik($prov);
        $distrik = array();


        foreach ($dataDistrik as $key => $value) {
            $distrik[] = $value['BZIRK'];
        }

        $provin = implode("','", $distrik);

        $data = $this->db->query("SELECT
                                *
                        FROM
                                (
                                        SELECT
                                                COLUMN_VALUE KD_PROV
                                        FROM
                                                TABLE (
                                                        sys.odcinumberlist (
                                                                '$prov'
                                                        )
                                                )
                                ) TB0
                        LEFT JOIN (
                            SELECT
                                A.PROPINSI_TO,
                                HARGA/VOL REALISASI
                            FROM (
                                 SELECT
                                        PROPINSI_TO,
                                        SUM (QTY) VOL
                                FROM
                                        ZREPORT_SCM_REAL_SALES_DISTRIK
                                WHERE
                                        BULAN = '$bulan'
                                AND HARI <= '$harik'
                                AND TAHUN = '$tahun'
                                AND ITEM IN ($mat)
                                GROUP BY
                                        PROPINSI_TO
                            ) A LEFT JOIN (
                                SELECT
                                        PROPINSI_TO,
                                        SUM (HARGA) HARGA,
                                        SUM (KWANTUMX) HARGA_QTY
                                FROM
                                        ZREPORT_SCM_HARGA
                                WHERE
                                        BULAN = '$bulan'
                                AND TAHUN = '$tahun'
                                AND HARI <= '$harik'
                                AND ITEM IN ($mat)
                                GROUP BY
                                        PROPINSI_TO
                            ) B ON A.PROPINSI_TO=B.PROPINSI_TO
                        ) TB1 ON TB1.PROPINSI_TO = TB0.KD_PROV
                        LEFT JOIN (
                                SELECT
                                        *
                                FROM
                                        (
                                         SELECT
                                                A.PROPINSI_TO,
                                                A.PLANT,
                                                HARGA/VOL REALISASI
                                            FROM (
                                                 SELECT
                                                        PROPINSI_TO,
                                                        PLANT,
                                                        SUM (QTY) VOL
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES_DISTRIK
                                                WHERE
                                                        BULAN = '$bulan'
                                                AND HARI <= '$harik'
                                                AND TAHUN = '$tahun'
                                                AND ITEM IN ($mat)
                                                GROUP BY
                                                        PLANT,
                                                        PROPINSI_TO
                                            ) A LEFT JOIN (
                                                SELECT
                                                        PROPINSI_TO,
                                                        PLANT,
                                                        SUM (HARGA) HARGA,
                                                        SUM (KWANTUMX) HARGA_QTY
                                                FROM
                                                        ZREPORT_SCM_HARGA
                                                WHERE
                                                        BULAN = '$bulan'
                                                AND TAHUN = '$tahun'
                                                AND HARI <= '$harik'
                                               AND KOTA IN('$provin')
                                                AND ITEM IN ($mat)
                                                GROUP BY
                                                        PROPINSI_TO,
                                                        PLANT
                                              ) B ON A.PROPINSI_TO=B.PROPINSI_TO AND A.PLANT=B.PLANT
                                        ) PIVOT (
                                                SUM (REALISASI) FOR PLANT IN ($dtPlant)
                                        )
                        ) TB2 ON TB2.PROPINSI_TO = TB0.KD_PROV
                        ");
//        echo $this->db->last_query();

        return $data->row_array();
    }

    function getOA($prov, $tahun, $bulan, $mat) {
        $hari = date('d');
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        
        $resPlant = $this->getKdPlantOA($prov, $bulan, $tahun,$harik, $mat);
        $plantIn = array();
        foreach ($resPlant as $key => $value) {
            $plantIn[] = $value['PLANT'];
        }
        $dtPlant = implode(",", $plantIn);
        $tahunlalu = $tahun - 1;
        $data = $this->db->query("
            SELECT
                    *
            FROM
                    (
                            SELECT
                                    BZIRK kd_kota,
                                    BZTXT nm_kota
                            FROM
                                    RFC_Z_ZAPPSD_BZIRK
                            WHERE
                                    BZIRK LIKE '" . substr($prov, 2) . "%'
                    ) TB0
            LEFT JOIN (
                    SELECT
                            KD_KOTA KOTA,
                            SUM (TARGET) TARGET,
                            TAHUN,
                            BULAN
                    FROM
                            ZREPORT_TARGET_PLANT
                    WHERE
                            BULAN = '$bulan'
                    AND TAHUN = '$tahun'
                    AND ITEM_NO IN ($mat)
                    GROUP BY
                            KD_KOTA,
                            BULAN,
                            TAHUN
            ) TB2 ON TB0.KD_KOTA = TB2.KOTA
            LEFT JOIN (
                    SELECT
                            A.KOTA,
                            CASE WHEN VOL=0 THEN 0 ELSE OA / VOL  END REALISASI
                    FROM (
                            SELECT
                                KOTA,
                                SUM (QTY) VOL
                            FROM
                                    ZREPORT_SCM_REAL_SALES_DISTRIK
                            WHERE
                                BULAN = '$bulan'
                                AND HARI <= '$harik'
                                AND TAHUN = '$tahun'
                                AND ITEM IN ($mat)
                                GROUP BY
                                        KOTA
                    ) A LEFT JOIN (
                        SELECT
                                KOTA,
                                SUM (OA) OA,
                                SUM (QTY) OA_QTY
                        FROM
                                ZREPORT_SCM_OA
                        WHERE
                                TAHUN = '$tahun'
                        AND BULAN = '$bulan'
                        AND HARI <= '$harik'
                        AND MATERIAL IN ($mat)
                        GROUP BY
                                KOTA
                    ) B ON A.KOTA=B.KOTA
            ) TB1 ON TB1.KOTA = TB0.KD_KOTA
            LEFT JOIN (
                    SELECT
                            *
                    FROM
                            (
                                SELECT
                                        A.KOTA,
                                        A.PLANT,
                                        CASE WHEN VOL=0 THEN 0 ELSE OA / VOL  END REALISASI
                                FROM (
                                        SELECT
                                            KOTA,
                                            PLANT,
                                            SUM (QTY) VOL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES_DISTRIK
                                        WHERE
                                            BULAN = '$bulan'
                                            AND HARI <= '$harik'
                                            AND TAHUN = '$tahun'
                                            AND ITEM IN ($mat)
                                            GROUP BY
                                                    PLANT,
                                                    KOTA
                                ) A LEFT JOIN (
                                    SELECT
                                            KOTA,
                                            PLANT,
                                            SUM (OA) OA,
                                            SUM (QTY) OA_QTY
                                    FROM
                                            ZREPORT_SCM_OA
                                    WHERE
                                            TAHUN = '$tahun'
                                    AND BULAN = '$bulan'
                                    AND HARI <= '$harik'
                                    AND MATERIAL IN ($mat)
                                    GROUP BY
                                            PLANT,
                                            KOTA
                                ) B ON A.KOTA=B.KOTA AND A.PLANT=B.PLANT
                            ) PIVOT (
                                    SUM (REALISASI) FOR PLANT IN ($dtPlant)
                            )
            ) TB3 ON TB3.KOTA = TB0.KD_KOTA
            LEFT JOIN (
                    SELECT
                            A.KOTA,
                            CASE WHEN VOL=0 THEN 0 ELSE OA / VOL  END REALTHNLALU
                    FROM (
                            SELECT
                                KOTA,
                                SUM (QTY) VOL
                            FROM
                                    ZREPORT_SCM_REAL_SALES_DISTRIK
                            WHERE
                                BULAN = '$bulan'
                                AND HARI <= '$harik'
                                AND TAHUN = '$tahunlalu'
                                AND ITEM IN ($mat)
                                GROUP BY
                                        KOTA
                    ) A LEFT JOIN (
                        SELECT
                                KOTA,
                                SUM (OA) OA,
                                SUM (QTY) OA_QTY
                        FROM
                                ZREPORT_SCM_OA
                        WHERE
                                TAHUN = '$tahunlalu'
                        AND BULAN = '$bulan'
                        AND HARI <= '$harik'
                        AND MATERIAL IN ($mat)
                        GROUP BY
                                KOTA
                    ) B ON A.KOTA=B.KOTA
            ) TB4 ON TB4.KOTA = TB0.KD_KOTA
            WHERE
            REALISASI IS NOT NULL
            ORDER BY
                    TB0.KD_KOTA
                ");
        return $data->result_array();
    }
    
    function getHNetto($prov, $tahun, $bulan, $mat){
        $hari = date('d');
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
         $resPlant = $this->getPlant($prov, $bulan, $tahun,$harik, $mat);
        $plantIn = array();
        foreach ($resPlant as $key => $value) {
            $plantIn[] = $value['PLANT'];
        }
        $dtPlant = implode(",", $plantIn);
        $tahunlalu = $tahun - 1;
        $data = $this->db->query("
            SELECT
                    *
            FROM
                    (
                            SELECT
                                    BZIRK kd_kota,
                                    BZTXT nm_kota
                            FROM
                                    RFC_Z_ZAPPSD_BZIRK
                            WHERE
                                    BZIRK LIKE '" . substr($prov, 2) . "%'
                    ) TB0
            LEFT JOIN (
                    SELECT
                            KD_KOTA KOTA,
                            SUM (TARGET) TARGET,
                            TAHUN,
                            BULAN
                    FROM
                            ZREPORT_TARGET_PLANT
                    WHERE
                            BULAN = '$bulan'
                    AND TAHUN = '$tahun'
                    AND ITEM_NO IN ($mat)
                    GROUP BY
                            KD_KOTA,
                            BULAN,
                            TAHUN
            ) TB2 ON TB0.KD_KOTA = TB2.KOTA
            LEFT JOIN (
                    SELECT
                            A.KOTA,
                            (HARGA/VOL)-CASE WHEN VOL=0 THEN 0 ELSE (OA/VOL) END REALISASI
                    FROM
                            (
                                    SELECT
                                        KOTA,
                                        SUM (QTY) VOL
                                    FROM
                                            ZREPORT_SCM_REAL_SALES_DISTRIK
                                    WHERE
                                        BULAN = '$bulan'
                                        AND HARI <= '$harik'
                                        AND TAHUN = '$tahun'
                                        AND ITEM IN ($mat)
                                        GROUP BY
                                                KOTA
                            ) A
                    LEFT JOIN 
                            (
                            
                                    SELECT
                                            KOTA,
                                            SUM (HARGA) HARGA,
                                            SUM (KWANTUMX) HARGA_QTY
                                    FROM
                                            ZREPORT_SCM_HARGA
                                    WHERE
                                            BULAN = '$bulan'
                                    AND TAHUN = '$tahun'
                                    AND HARI <= '$harik'
                                    AND ITEM IN ($mat)
                                    GROUP BY
                                            KOTA
                            ) B ON A .KOTA = B.KOTA
                    LEFT JOIN (
                            SELECT
                                    KOTA,
                                    SUM (OA) OA,
                                    SUM (QTY) OA_QTY
                            FROM
                                    ZREPORT_SCM_OA
                            WHERE
                                    TAHUN = '$tahun'
                            AND BULAN = '$bulan'
                            AND HARI <= '$harik'
                            AND MATERIAL IN ($mat)
                            GROUP BY
                                    KOTA
                    ) C ON A .KOTA = C.KOTA
            ) TB1 ON TB1.KOTA = TB0.KD_KOTA
            LEFT JOIN (
                    SELECT
                            *
                    FROM
                            (
                                    SELECT
                                            A.KOTA,
                                            A.PLANT,
                                            (HARGA/VOL)-CASE WHEN VOL=0 THEN 0 ELSE (OA/VOL) END REALISASI
                                    FROM
                                            (
                                                SELECT
                                                    KOTA,
                                                    PLANT,
                                                    SUM (QTY) VOL
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES_DISTRIK
                                                WHERE
                                                    BULAN = '$bulan'
                                                    AND HARI <= '$harik'
                                                    AND TAHUN = '$tahun'
                                                    AND ITEM IN ($mat)
                                                    GROUP BY
                                                            KOTA,
                                                            PLANT
                                            ) A
                                    LEFT JOIN (
                                                    SELECT
                                                            KOTA,
                                                            PLANT,
                                                            SUM (HARGA) HARGA,
                                                            SUM (KWANTUMX) HARGA_QTY
                                                    FROM
                                                            ZREPORT_SCM_HARGA
                                                    WHERE
                                                            BULAN = '$bulan'
                                                    AND TAHUN = '$tahun'
                                                    AND HARI <= '$harik'
                                                    AND ITEM IN ($mat)
                                                    GROUP BY
                                                            KOTA,
                                                            PLANT
                                            ) B ON A.KOTA=B.KOTA AND A.PLANT=B.PLANT
                                    LEFT JOIN (
                                            SELECT
                                                    KOTA,
                                                    PLANT,
                                                    SUM (OA) OA,
                                                    SUM (QTY) OA_QTY
                                            FROM
                                                    ZREPORT_SCM_OA
                                            WHERE
                                                    TAHUN = '$tahun'
                                            AND BULAN = '$bulan'
                                            AND HARI <= '$harik'
                                            AND MATERIAL IN ($mat)
                                            GROUP BY
                                                    KOTA,
                                                    PLANT
                                    ) C ON A .KOTA = C.KOTA AND A.PLANT=C.PLANT
                                            
                            ) PIVOT (
                                    SUM (REALISASI) FOR PLANT IN ($dtPlant)
                            )
            ) TB3 ON TB3.KOTA = TB0.KD_KOTA
            LEFT JOIN (
                   SELECT
                            A.KOTA,
                            (HARGA/VOL)-CASE WHEN VOL=0 THEN 0 ELSE (OA/VOL) END REALTHNLALU
                    FROM
                            (
                                    SELECT
                                        KOTA,
                                        SUM (QTY) VOL
                                    FROM
                                            ZREPORT_SCM_REAL_SALES_DISTRIK
                                    WHERE
                                        BULAN = '$bulan'
                                        AND HARI <= '$harik'
                                        AND TAHUN = '$tahunlalu'
                                        AND ITEM IN ($mat)
                                        GROUP BY
                                                KOTA
                            ) A
                    LEFT JOIN 
                            (
                            
                                    SELECT
                                            KOTA,
                                            SUM (HARGA) HARGA,
                                            SUM (KWANTUMX) HARGA_QTY
                                    FROM
                                            ZREPORT_SCM_HARGA
                                    WHERE
                                            BULAN = '$bulan'
                                    AND TAHUN = '$tahunlalu'
                                    AND HARI <= '$harik'
                                    AND ITEM IN ($mat)
                                    GROUP BY
                                            KOTA
                            ) B ON A .KOTA = B.KOTA
                    LEFT JOIN (
                            SELECT
                                    KOTA,
                                    SUM (OA) OA,
                                    SUM (QTY) OA_QTY
                            FROM
                                    ZREPORT_SCM_OA
                            WHERE
                                    TAHUN = '$tahunlalu'
                            AND BULAN = '$bulan'
                            AND HARI <= '$harik'
                            AND MATERIAL IN ($mat)
                            GROUP BY
                                    KOTA
                    ) C ON A .KOTA = C.KOTA
            ) TB4 ON TB4.KOTA = TB0.KD_KOTA
            WHERE
            REALISASI IS NOT NULL
            ORDER BY
                    TB0.KD_KOTA
                ");
//        echo $this->db->last_query();
        return $data->result_array();
    }
    
    function getRevenue($prov, $tahun, $bulan, $mat){
        $hari = date('d');
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
         $resPlant = $this->getPlant($prov, $bulan, $tahun,$harik, $mat);
        $plantIn = array();
        foreach ($resPlant as $key => $value) {
            $plantIn[] = $value['PLANT'];
        }
        $dtPlant = implode(",", $plantIn);
        $tahunlalu = $tahun - 1;
        $data = $this->db->query("
            SELECT
                    *
            FROM
                    (
                            SELECT
                                    BZIRK kd_kota,
                                    BZTXT nm_kota
                            FROM
                                    RFC_Z_ZAPPSD_BZIRK
                            WHERE
                                    BZIRK LIKE '" . substr($prov, 2) . "%'
                    ) TB0
            LEFT JOIN (
                    SELECT
                            KD_KOTA KOTA,
                            SUM (TARGET) TARGET,
                            TAHUN,
                            BULAN
                    FROM
                            ZREPORT_TARGET_PLANT
                    WHERE
                            BULAN = '$bulan'
                    AND TAHUN = '$tahun'
                    AND ITEM_NO IN ($mat)
                    GROUP BY
                            KD_KOTA,
                            BULAN,
                            TAHUN
            ) TB2 ON TB0.KD_KOTA = TB2.KOTA
            LEFT JOIN (
                    SELECT
                            A .KOTA,
                            ((HARGA/VOL)-CASE WHEN VOL=0 THEN 0 ELSE (OA/VOL) END)*VOL  REALISASI
                    FROM
                            (
                                 SELECT
                                    KOTA,
                                    SUM (QTY) VOL
                            FROM
                                    ZREPORT_SCM_REAL_SALES_DISTRIK
                            WHERE
                                    BULAN = '$bulan'
                            AND HARI <= '$harik'
                            AND TAHUN = '$tahun'
                            AND ITEM IN ($mat)
                            GROUP BY
                                    KOTA
                            ) A
                    LEFT JOIN (
                            SELECT
                                    KOTA,
                                   SUM (OA) OA,
                                   SUM (QTY) OA_QTY
                            
                            FROM
                                    ZREPORT_SCM_OA
                            WHERE
                                    TAHUN = '$tahun'
                            AND BULAN = '$bulan'
                            AND HARI <= '$harik'
                            AND MATERIAL IN ($mat)
                            GROUP BY
                                    KOTA
                    ) B ON A .KOTA = B.KOTA
                    LEFT JOIN (
                             SELECT
                                            KOTA,
                                            SUM (HARGA) HARGA,
                                            SUM (KWANTUMX) HARGA_QTY
                                    FROM
                                            ZREPORT_SCM_HARGA
                                    WHERE
                                            BULAN = '$bulan'
                                    AND TAHUN = '$tahun'
                                    AND HARI <= '$harik'
                                    AND ITEM IN ($mat)
                                    GROUP BY
                                            KOTA
                           
                    ) C ON A.KOTA = C.KOTA
            ) TB1 ON TB1.KOTA = TB0.KD_KOTA
            LEFT JOIN (
                    SELECT
                            *
                    FROM
                            (
                                SELECT
                                        A .KOTA,
                                        A .PLANT,
                                        ((HARGA/VOL)-CASE WHEN VOL=0 THEN 0 ELSE (OA/VOL) END)*VOL REALISASI
                                FROM
                                        (
                                                 SELECT
                                                KOTA,
                                                PLANT,
                                                SUM (QTY) VOL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES_DISTRIK
                                        WHERE
                                                BULAN = '$bulan'
                                        AND HARI <= '$harik'
                                        AND TAHUN = '$tahun'
                                        AND ITEM IN ($mat)
                                        GROUP BY
                                                PLANT,
                                                KOTA
                                                
                                        ) A
                                LEFT JOIN (
                                        SELECT
                                                KOTA,
                                                PLANT,
                                                SUM (OA) OA,
                                                SUM (QTY) OA_QTY
                                        
                                        FROM
                                                ZREPORT_SCM_OA
                                        WHERE
                                                TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$harik'
                                        AND MATERIAL IN ($mat)
                                        GROUP BY
                                                KOTA,
                                                PLANT
                                ) B ON A .KOTA = B.KOTA
                                AND A .PLANT = B.PLANT
                                LEFT JOIN (
                                       SELECT
                                                        KOTA,
                                                        PLANT,
                                                        SUM (HARGA) HARGA,
                                                        SUM (KWANTUMX) HARGA_QTY
                                                FROM
                                                        ZREPORT_SCM_HARGA
                                                WHERE
                                                        BULAN = '$bulan'
                                                AND TAHUN = '$tahun'
                                                AND HARI <= '$harik'
                                                AND ITEM IN ($mat)
                                                GROUP BY
                                                        KOTA,
                                                        PLANT
                                ) C ON A .KOTA = C.KOTA
                                AND A .PLANT = C.PLANT            
                            ) PIVOT (
                                    SUM (REALISASI) FOR PLANT IN ($dtPlant)
                            )
            ) TB3 ON TB3.KOTA = TB0.KD_KOTA
            LEFT JOIN (
                    SELECT
                            A .KOTA,
                            ((HARGA/VOL)-CASE WHEN VOL=0 THEN 0 ELSE (OA/VOL) END)*VOL  REALTHNLALU
                    FROM
                            (
                                 SELECT
                                    KOTA,
                                    SUM (QTY) VOL
                            FROM
                                    ZREPORT_SCM_REAL_SALES_DISTRIK
                            WHERE
                                    BULAN = '$bulan'
                            AND HARI <= '$harik'
                            AND TAHUN = '$tahunlalu'
                            AND ITEM IN ($mat)
                            GROUP BY
                                    KOTA
                            ) A
                    LEFT JOIN (
                            SELECT
                                    KOTA,
                                   SUM (OA) OA,
                                   SUM (QTY) OA_QTY
                            
                            FROM
                                    ZREPORT_SCM_OA
                            WHERE
                                    TAHUN = '$tahunlalu'
                            AND BULAN = '$bulan'
                            AND HARI <= '$harik'
                            AND MATERIAL IN ($mat)
                            GROUP BY
                                    KOTA
                    ) B ON A .KOTA = B.KOTA
                    LEFT JOIN (
                             SELECT
                                            KOTA,
                                            SUM (HARGA) HARGA,
                                            SUM (KWANTUMX) HARGA_QTY
                                    FROM
                                            ZREPORT_SCM_HARGA
                                    WHERE
                                            BULAN = '$bulan'
                                    AND TAHUN = '$tahunlalu'
                                    AND HARI <= '$harik'
                                    AND ITEM IN ($mat)
                                    GROUP BY
                                            KOTA
                           
                    ) C ON A.KOTA = C.KOTA
            ) TB4 ON TB4.KOTA = TB0.KD_KOTA
            WHERE
            REALISASI IS NOT NULL
            ORDER BY
                    TB0.KD_KOTA
                ");
//        echo $this->db->last_query();
        return $data->result_array();
    }

    function getSemenPutih($prov, $tahun, $bulan){
        $hari = date('d');
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->db->query(" 
            SELECT
                    TB1.PROPINSI_TO,
                    NVL(VOL_ALL - VOL,0) WC_VOL,
                    NVL(HARGA / (VOL_ALL - VOL),0) HARGA,
                    NVL(OA / (VOL_ALL - VOL),0) OA,
                    NVL((HARGA-OA)/(VOL_ALL - VOL),0) NETTO,
                    NVL(HARGA-OA,0) REV
            FROM
                    (
                            SELECT
                                    PROPINSI_TO,
                                    SUM (QTY) VOL_ALL,
                                    ITEM
                            FROM
                                    ZREPORT_SCM_REAL_SALES
                            WHERE
                                    BULAN = '$bulan'
                            AND HARI <= '$harik'
                            AND TAHUN = '$tahun'
                            GROUP BY
                                    PROPINSI_TO,
                                    ITEM
                    ) TB1
            LEFT JOIN (
                    SELECT
                            PROPINSI_TO,
                            SUM (QTY) VOL,
                            ITEM
                    FROM
                            ZREPORT_SCM_REAL_SALES_DISTRIK
                    WHERE
                            BULAN = '$bulan'
                    AND HARI <= '$harik'
                    AND TAHUN = '$tahun'
                    GROUP BY
                            PROPINSI_TO,
                            ITEM
            ) TB2 ON TB1.PROPINSI_TO = TB2.PROPINSI_TO
            AND TB1.ITEM = TB2.ITEM
            LEFT JOIN (
                    SELECT
                            PROPINSI_TO,
                            SUM (HARGA) HARGA,
                            SUM (KWANTUMX) HARGA_QTY,
                            SUBSTR (ITEM, 1, 7) ITEM
                    FROM
                            ZREPORT_SCM_HARGA
                    WHERE
                            BULAN = '$bulan'
                    AND TAHUN = '$tahun'
                    AND HARI <= '$harik'
                    AND ITEM = '121-301-0240'
                    GROUP BY
                            PROPINSI_TO,
                            SUBSTR (ITEM, 1, 7)
            ) TB3 ON TB1.PROPINSI_TO = TB3.PROPINSI_TO
            AND TB3.ITEM = TB1.ITEM
            LEFT JOIN (
                    SELECT
                            PROV PROPINSI_TO,
                            SUM (OA) OA,
                            SUM (QTY) OA_QTY,
                            SUBSTR (MATERIAL, 1, 7) ITEM
                    FROM
                            ZREPORT_SCM_OA
                    WHERE
                            TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND HARI <= '$harik'
                    AND MATERIAL = '121-301-0240'
                    GROUP BY
                            PROV,
                            SUBSTR (MATERIAL, 1, 7)
            ) TB4 ON TB4.PROPINSI_TO = TB1.PROPINSI_TO
            AND TB4.ITEM = TB1.ITEM
            WHERE
                    TB1.PROPINSI_TO = '$prov'
            AND TB1.ITEM = '121-301' 
        ")->row_array();
        return $data;
    }
}

<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access allowed');

class InPlantCigading_model extends CI_Model {
	private $db2;

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db2 = $this->load->database('scmproduction', TRUE);
    }

    function sql_stok() {
        $data = $this->db2->query("select KD_GDG,LT,KD_DISTR from CRM_GUDANG where LT is null");
        return $data->result_array();
    }

    function tonaseOverall() {
        $data = $this->db->query("
            SELECT
                COUNT (NO_TRANSAKSI) COUNTER,
                SUM (KWANTUMX) jumlahx,
                TIPE_TRUK,
                ORDER_TYPE,
                KODE_DA
            FROM
                ZREPORT_RPT_REAL
            WHERE
                (
                    SELECT
                        TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\"
                    FROM
                        DUAL
                ) = TO_CHAR (TGL_SPJ, 'DD-MM-YYYY')
            AND PLANT = 7415
            AND STATUS = 70
            GROUP BY
                TIPE_TRUK,
                ORDER_TYPE,
                KODE_DA
            ");
        return $data->result_array();
    }

    function avgOverall() {
        $data = $this->db->query("
            SELECT
                ROUND (
                    (
                        AVG (TGL_ISI - TGL_ANTRI) * 24 * 60
                    ),
                    2
                ) AVERAGE,
                'BAG' tipe_truk
            FROM
                ZREPORT_RPT_REAL
            WHERE
                (
                    SELECT
                        TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\"
                    FROM
                        DUAL
                ) = TO_CHAR (TGL_SPJ, 'DD-MM-YYYY')
            AND PLANT = 7415
            AND tipe_truk BETWEEN 107
            AND 307
            UNION
                SELECT
                    ROUND (
                        (
                            AVG (TGL_ISI - TGL_ANTRI) * 24 * 60
                        ),
                        2
                    ) AVERAGE,
                    'BULK' tipe_truk
                FROM
                    ZREPORT_RPT_REAL
                WHERE
                    (
                        SELECT
                            TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\"
                        FROM
                            DUAL
                    ) = TO_CHAR (TGL_SPJ, 'DD-MM-YYYY')
                AND PLANT = 7415
                AND kode_da NOT LIKE '0000007%'
                AND tipe_truk = 308
            ");
        return $data->result_array();
    }

    function avgcargo() {
        $data = $this->db->query("
            SELECT
                ROUND (AVG(selisih), 2) AVERAGE,
                'BAG' tipe_truck
            FROM
                (
                    SELECT DISTINCT
                        (NO_POLISI),
                        ((SYSDATE - TGL_ANTRI) * 24 * 60) selisih
                    FROM
                        ZREPORT_RPT_REAL_NON70
                    WHERE
                        STATUS = 10
                    AND DATE_CVY IS NULL
                    AND tipe_truk BETWEEN 107
                    AND 307
                    AND PLANT = '7415'
                )
            UNION
                SELECT
                    ROUND (AVG(selisih), 2) AVERAGE,
                    'BULK' tipe_truck
                FROM
                    (
                        SELECT DISTINCT
                            (NO_POLISI),
                            ((SYSDATE - TGL_ANTRI) * 24 * 60) selisih
                        FROM
                            ZREPORT_RPT_REAL_NON70
                        WHERE
                            STATUS = 10
                        AND DATE_CVY IS NULL
                        AND tipe_truk = 308
                        AND PLANT = '7415'
                    )
                ");
        return $data->result();
    }

    function avgtmbgn() {
        $data = $this->db->query("
            SELECT
                ROUND (
                    (
                        AVG (SYSDATE - DATE_CVY) * 24 * 60
                    ),
                    2
                ) AVERAGE,
                301 tipe_truk
            FROM
                ZREPORT_RPT_REAL_NON70
            WHERE
                date_cvy IS NOT NULL
            AND STATUS >= 20
            AND status <= 40
            AND PLANT = '7415'
            AND tipe_truk BETWEEN 107
            AND 307
            UNION
                SELECT
                    ROUND (
                        (
                            AVG (SYSDATE - DATE_CVY) * 24 * 60
                        ),
                        2
                    ) AVERAGE,
                    308 tipe_truk
                FROM
                    ZREPORT_RPT_REAL_NON70
                WHERE
                    date_cvy IS NOT NULL
                AND STATUS >= 20
                AND status <= 40
                AND PLANT = '7415'
                AND tipe_truk = 308
                ");
        return $data->result();
    }

    function cntcargo() {
        $data = $this->db->query("
            SELECT
                COUNT (DISTINCT(NO_POLISI)) JUML_TRUCK,
                301 tipe_truck
            FROM
                ZREPORT_RPT_REAL_NON70
            WHERE
                STATUS = 10
            AND DATE_CVY IS NULL
            AND tipe_truk BETWEEN 107
            AND 307
            AND PLANT = '7415'
            UNION
                SELECT
                    COUNT (DISTINCT(NO_POLISI)) JUML_TRUCK,
                    308 tipe_truck
                FROM
                    ZREPORT_RPT_REAL_NON70
                WHERE
                    STATUS = 10
                AND DATE_CVY IS NULL
                AND tipe_truk = 308
                AND PLANT = '7415'
                ");
        return $data->result();
    }

    function cnttmbgn() {
        $data = $this->db->query("
            SELECT
                COUNT (DISTINCT(NO_POLISI)) JUML_TRUCK,
                301 tipe_truck
            FROM
                ZREPORT_RPT_REAL_NON70
            WHERE
                STATUS >= 20
            AND STATUS <= 40
            AND DATE_CVY IS NOT NULL
            AND PLANT = '7415'
            AND kode_da NOT LIKE '0000007%'
            AND tipe_truk BETWEEN 107
            AND 307
            UNION
                SELECT
                    COUNT (DISTINCT(NO_POLISI)) JUML_TRUCK,
                    308 tipe_truck
                FROM
                    ZREPORT_RPT_REAL_NON70
                WHERE
                    STATUS >= 20
                AND STATUS <= 40
                AND DATE_CVY IS NOT NULL
                AND PLANT = '7415'
                AND tipe_truk = 308
                ");
        return $data->result();
    }

    function detailBagCargo() {
        $data = $this->db->query("
            SELECT
                tanggal,
                status,
                nama_sopir,
                jam_mulai,
                durasi,
                no_polisi,
                nama_expeditur,
                tipe_truk,
                nm_kota,
                SUM (KWANTUMX) kwantumx
            FROM
                (
                    SELECT
                        kwantumx,
                        nm_kota,
                        tgl_antri AS tanggal,
                        ZREPORT_RPT_REAL_NON70.status,
                        nama_sopir,
                        TO_CHAR (tgl_antri, 'HH24:MI') jam_mulai,
                        ROUND (
                            (SYSDATE - tgl_antri) * 24 * 60,
                            2
                        ) durasi,
                        no_polisi,
                        nama_expeditur,
                        tipe_truk
                    FROM
                        ZREPORT_RPT_REAL_NON70
                    WHERE
                        STATUS = 10
                    AND DATE_CVY IS NULL
                    AND PLANT = 7415
                    AND tipe_truk BETWEEN 107
                    AND 307
                )
            GROUP BY
                tanggal,
                status,
                nama_sopir,
                jam_mulai,
                durasi,
                no_polisi,
                nama_expeditur,
                tipe_truk,
                nm_kota
            ");
        return $data->result();
    }

    function detailBulkCargo() {
        $data = $this->db->query("
            SELECT
                tanggal,
                status,
                nama_sopir,
                jam_mulai,
                durasi,
                no_polisi,
                nama_expeditur,
                tipe_truk,
                nm_kota,
                SUM (KWANTUMX) kwantumx
            FROM
                (
                    SELECT
                        kwantumx,
                        nm_kota,
                        tgl_antri AS tanggal,
                        ZREPORT_RPT_REAL_NON70.status,
                        nama_sopir,
                        TO_CHAR (tgl_antri, 'HH24:MI') jam_mulai,
                        ROUND (
                            (SYSDATE - tgl_antri) * 24 * 60,
                            2
                        ) durasi,
                        no_polisi,
                        nama_expeditur,
                        tipe_truk
                    FROM
                        ZREPORT_RPT_REAL_NON70
                    WHERE
                        STATUS = 10
                    AND DATE_CVY IS NULL
                    AND PLANT = 7415
                    AND tipe_truk = 308
                )
            GROUP BY
                tanggal,
                status,
                nama_sopir,
                jam_mulai,
                durasi,
                no_polisi,
                nama_expeditur,
                tipe_truk,
                nm_kota
            ");
        return $data->result();
    }

    function detailBagTmbgn() {
        $data = $this->db->query("
            SELECT
                tanggal,
                status,
                nama_sopir,
                jam_mulai,
                durasi,
                no_polisi,
                nama_expeditur,
                tipe_truk,
                nm_kota,
                SUM (KWANTUMX) kwantumx
            FROM
                (
                    SELECT
                        kwantumx,
                        nm_kota,
                        date_cvy AS tanggal,
                        nama_sopir,
                        ZREPORT_RPT_REAL_NON70.status,
                        TO_CHAR (date_cvy, 'HH24:MI') jam_mulai,
                        (SYSDATE - date_cvy) * 24 * 60 durasi,
                        no_polisi,
                        nama_expeditur,
                        tipe_truk
                    FROM
                        ZREPORT_RPT_REAL_NON70
                    WHERE
                        STATUS >= 20 AND STATUS <= 40
                    AND DATE_CVY IS NOT NULL
                    AND PLANT = 7415
                    AND tipe_truk BETWEEN 107
                    AND 307
                )
            GROUP BY
                tanggal,
                status,
                nama_sopir,
                jam_mulai,
                durasi,
                no_polisi,
                nama_expeditur,
                tipe_truk,
                nm_kota
            ");
        return $data->result();
    }

    function detailBulkTmbgn() {
        $data = $this->db->query("
            SELECT
                tanggal,
                status,
                nama_sopir,
                jam_mulai,
                durasi,
                no_polisi,
                nama_expeditur,
                tipe_truk,
                nm_kota,
                SUM (KWANTUMX) kwantumx
            FROM
                (
                    SELECT
                        kwantumx,
                        nm_kota,
                        date_cvy AS tanggal,
                        nama_sopir,
                        ZREPORT_RPT_REAL_NON70.status,
                        TO_CHAR (date_cvy, 'HH24:MI') jam_mulai,
                        (SYSDATE - date_cvy) * 24 * 60 durasi,
                        no_polisi,
                        nama_expeditur,
                        tipe_truk
                    FROM
                        ZREPORT_RPT_REAL_NON70
                    WHERE
                        STATUS >= 20 AND STATUS <= 40
                    AND DATE_CVY IS NOT NULL
                    AND PLANT = 7415
                    AND tipe_truk = 308
                )
            GROUP BY
                tanggal,
                status,
                nama_sopir,
                jam_mulai,
                durasi,
                no_polisi,
                nama_expeditur,
                tipe_truk,
                nm_kota
            ");

        return $data->result();
    }

    function avgpbrk() {
        $data = $this->db->query("
            SELECT
                PABRIK,
                MATNR,
                ROUND (
                    (
                        AVG (SYSDATE - TGL_MASUK) * 24 * 60
                    ),
                    2
                ) AVERAGE
            FROM
                (
                    SELECT
                        CVY.PABRIK,
                        SUBSTR (CVY.MATNR, 5, 3) MATNR,
                        rel.TGL_ISI,
                        rel.TGL_MASUK,
                        rel.NO_TRANSAKSI
                    FROM
                        ZREPORT_RPT_REAL_NON70 rel
                    JOIN ZREPORT_M_CVY_MAT CVY ON REL.LSTEL = CVY.LINE_BOOMER
                    WHERE
                    rel.PLANT = '7415'
                    AND CVY.PABRIK IS NOT NULL
                    AND rel.status >= 50
                    AND REL.status <= 60
                    AND rel.kode_da NOT LIKE '0000007%'
                )
            GROUP BY
                PABRIK,
                MATNR
            ");
        return $data->result();
    }

    function get_data_conveyor(){
    	$plant = '7415';
    	$com = '7000';
    	$data = $this->db->query("
    		SELECT DISTINCT
                ZMCM.LINE_BOOMER,
                SUBSTR (ZMCM.MATNR, 5, 3) AS MATNR,
                ZMCM.STATUS,
                ZMCM.DESC2 AS DESKRIPSI,
                (
                    SELECT
                        COUNT (NO_POLISI)
                    FROM
                        (
                            SELECT
                                no_polisi
                            FROM
                                (
                                    SELECT
                                        rel.status,
                                        nama_sopir,
                                        LSTEL,
                                        PABRIK,
                                        SUBSTR (MATNR, 1, 7) MATNR,
                                        NO_TRANSAKSI,
                                        date_cvy,
                                        no_polisi,
                                        nama_expeditur,
                                        kwantumx,
                                        nm_kota
                                    FROM
                                        ZREPORT_RPT_REAL_NON70 REL
                                    JOIN ZREPORT_M_CVY_MAT CVY ON REL.LSTEL = CVY.LINE_BOOMER
                                    WHERE
                                        PLANT = 7415
                                    AND PABRIK IS NOT NULL
                                    AND REL.STATUS >= 50
                                    AND REL.STATUS <= 60
                                    AND LSTEL = ZMCM.LINE_BOOMER
                                    AND kode_da NOT LIKE '0000007%'
                                )
                            GROUP BY
                                no_polisi
                        )
                ) AS C_LINE
            FROM
                ZREPORT_M_CVY_MAT ZMCM
            WHERE
                ZMCM.NMPLAN = '7415'
		");

        return $data->result_array();
    }

    function detailConveyor($tipe) {
        $data = $this->db->query("
            SELECT
                PABRIK,
                LSTEL,
                MATNR,
                STATUS,
                TANGGAL,
                NAMA_SOPIR,
                JAM_MULAI,
                DURASI,
                NO_POLISI,
                NAMA_EXPEDITUR,
                NM_KOTA,
                SUM (KWANTUMX) kwantumx
            FROM
                (
                    SELECT
                        PABRIK,
                        LSTEL,
                        MATNR,
                        STATUS,
                        date_cvy AS tanggal,
                        nama_sopir,
                        TO_CHAR (date_cvy, 'HH24:MI') jam_mulai,
                        (SYSDATE - date_cvy) * 24 * 60 durasi,
                        no_polisi,
                        nama_expeditur,
                        nm_kota,
                        kwantumx
                    FROM
                        (
                            SELECT
                                PABRIK,
                                LSTEL,
                                MATNR,
                                date_cvy,
                                no_polisi,
                                nama_expeditur,
                                nama_sopir,
                                status,
                                kwantumx,
                                nm_kota
                            FROM
                                (
                                    SELECT
                                        rel.status,
                                        nama_sopir,
                                        LSTEL,
                                        PABRIK,
                                        SUBSTR (MATNR, 1, 7) MATNR,
                                        NO_TRANSAKSI,
                                        date_cvy,
                                        no_polisi,
                                        nama_expeditur,
                                        kwantumx,
                                        nm_kota
                                    FROM
                                        ZREPORT_RPT_REAL_NON70 REL
                                    JOIN ZREPORT_M_CVY_MAT CVY ON REL.LSTEL = CVY.LINE_BOOMER
                                    WHERE
                                    PLANT = 7415
                                    AND PABRIK IS NOT NULL
                                    AND REL.STATUS >= 50
                                    AND REL.STATUS <= 60
                                    AND LSTEL = $tipe
                                    AND kode_da NOT LIKE '0000007%'
                                )
                        )
                )
            GROUP BY
                PABRIK,
                LSTEL,
                MATNR,
                STATUS,
                TANGGAL,
                NAMA_SOPIR,
                JAM_MULAI,
                DURASI,
                NO_POLISI,
                NAMA_EXPEDITUR,
                NM_KOTA
            ");
        return $data->result_array();
    }

    function detailBagTonase() {
        $data = $this->db->query("
            SELECT
                ITEM_NO,
                UOM,
                PRODUK,
                SUM (KWANTUM) KWANTUM,
                SUM (KWANTUMX) KWANTUMX,
                'ZNL' ORDER_TYPE
            FROM
                ZREPORT_RPT_REAL
            WHERE
                (
                    SELECT
                        TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\"
                    FROM
                        DUAL
                ) = TO_CHAR (TGL_SPJ, 'DD-MM-YYYY')
            AND PLANT = 7415
            AND TIPE_TRUK BETWEEN 107
            AND 307
            AND ORDER_TYPE = 'ZNL'
            GROUP BY
                ITEM_NO,
                PRODUK,
                UOM
            UNION
                SELECT
                    ITEM_NO,
                    UOM,
                    PRODUK,
                    SUM (KWANTUM) KWANTUM,
                    SUM (KWANTUMX) KWANTUMX,
                    'ZLF' ORDER_TYPE
                FROM
                    ZREPORT_RPT_REAL
                WHERE
                    (
                        SELECT
                            TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\"
                        FROM
                            DUAL
                    ) = TO_CHAR (TGL_SPJ, 'DD-MM-YYYY')
                AND PLANT = 7415
                AND TIPE_TRUK BETWEEN 107
                AND 307
                AND ORDER_TYPE != 'ZNL'
                GROUP BY
                    ITEM_NO,
                    PRODUK,
                    UOM
            ");
        return $data->result();
    }

    function detailBulkTonase() {
        $data = $this->db->query("
            SELECT
                ITEM_NO,
                UOM,
                PRODUK,
                SUM (KWANTUM) KWANTUM,
                SUM (KWANTUMX) KWANTUMX,
                'ZNL' ORDER_TYPE
            FROM
                ZREPORT_RPT_REAL
            WHERE
                (
                    SELECT
                        TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\"
                    FROM
                        DUAL
                ) = TO_CHAR (TGL_SPJ, 'DD-MM-YYYY')
            AND PLANT = 7415
            AND TIPE_TRUK = 308
            AND ORDER_TYPE = 'ZNL'
            GROUP BY
                ITEM_NO,
                PRODUK,
                UOM
            UNION
                SELECT
                    ITEM_NO,
                    UOM,
                    PRODUK,
                    SUM (KWANTUM) KWANTUM,
                    SUM (KWANTUMX) KWANTUMX,
                    'ZLF' ORDER_TYPE
                FROM
                    ZREPORT_RPT_REAL
                WHERE
                    (
                        SELECT
                            TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\"
                        FROM
                            DUAL
                    ) = TO_CHAR (TGL_SPJ, 'DD-MM-YYYY')
                AND PLANT = 7415
                AND TIPE_TRUK = 308
                AND ORDER_TYPE != 'ZNL'
                GROUP BY
                    ITEM_NO,
                    PRODUK,
                    UOM
            ");
        return $data->result();
    }

    function waktuUpdate() {
        $data = $this->db->query("SELECT TO_CHAR(MAX(TGL_LAST_UPDATE),'DD-MM-YYYY HH24:MI:SS') as waktu_update
			FROM ZREPORT_RPT_REAL");
        return $data->result();
    }

    function sisaSO(){
        $data = $this->db->query("
            SELECT
                TB1.NMORG,
                NVL (TB1.SISA_BAG, 0) SISA_BAG,
                NVL (TB2.SISA_BULK, 0) SISA_BULK
            FROM
                (
                    SELECT
                        NMORG,
                        SUM (SISA_TO) SISA_BAG
                    FROM
                        ZREPORT_SO_BUFFER
                    WHERE
                        ITEM_NO LIKE '121-301%'
                    AND NMPLAN = '7415'
                    GROUP BY
                        NMORG
                ) TB1
            LEFT JOIN (
                SELECT
                    NMORG,
                    SUM (SISA_TO) SISA_BULK
                FROM
                    ZREPORT_SO_BUFFER
                WHERE
                    ITEM_NO LIKE '121-302%'
                AND NMPLAN = '7415'
                GROUP BY
                    NMORG
            ) TB2 ON TB1.NMORG = TB2.NMORG
            ");
        return $data->result_array();
    }
}
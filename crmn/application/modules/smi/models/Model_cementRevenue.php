<?php
    class Model_cementRevenue extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }


        public function listProvinsi($idProvinsi = null, $idRegion = null){
            if(isset($idProvinsi)){
                $this->db->where("ID_PROVINSI", $idProvinsi);
            }

            if($idRegion != ""){
                if($idRegion != "0"){
                    $this->db->where("ID_REGION", $idRegion);
                }    
            }
            
            $this->db->select("ID_PROVINSI, NAMA_PROVINSI");
            $this->db->from("CRMNEW_M_PROVINSI");
            $this->db->where("ID_REGION IS NOT NULL");
            $this->db->order_by("ID_PROVINSI", "ASC");

            $provinsi = $this->db->get();
            if($provinsi->num_rows() > 0){
                return $provinsi->result();
            } else {
                return false;
            }
        }

        public function realVolRevenue($region, $bulan, $tahun){
            $this->db2 = $this->load->database("SCM", true);
            if(isset($region) || $region != ""){
                $arrayRegion = implode(",", $region);
                $whereRegion = "WHERE PROVINSI.KD_PROV IN ($arrayRegion)";
            } else {
                $whereRegion = "";
            }

            if($bulan == date('m')){
                $whereSampaiHariIni = "AND HARI BETWEEN '01' AND (TO_CHAR(SYSDATE, 'DD')-1)";
            } else {
                $whereSampaiHariIni = "";
            }

            $sql = "SELECT
                        PROVINSI.KD_PROV,
                        PROVINSI.NM_PROV,
                        ROUND(TARGET.RKAP_VOLUME_BLN, 0) AS RKAP_VOLUME_BLN_TON,
                        ROUND((TARGET.RKAP_REVENUE_BLN/1000000), 0) AS RKAP_REVENUE_BLN_JT,
                        ROUND(REALISASI.VOLUME_TON, 0) REAL_VOLUME_SDK_TON,
                        ROUND(REALISASI.REVENUE_JT, 0) REAL_REVENUE_SDK_JT
                    FROM 
                        (
                            SELECT 
                                PROV.KD_PROV,
                                PROV.NM_PROV
                            FROM ZREPORT_M_PROVINSI PROV
                            WHERE PROV.ID_PULAU!=0
                            ORDER BY PROV.KD_PROV
                        ) PROVINSI
                    LEFT JOIN 
                        (
                            SELECT 
                                SR.PROV AS KD_PROV,
                                SR.THN AS TAHUN,
                                SR.BLN AS BULAN,
                                SUM(SR.QUANTUM) AS RKAP_VOLUME_BLN,
                                SUM(SR.REVENUE) AS RKAP_REVENUE_BLN
                            FROM SAP_T_RENCANA_SALES_TYPE SR
                            WHERE SR.THN=$tahun
                            AND SR.BLN=$bulan
                            GROUP BY 
                                SR.PROV,
                                SR.THN,
                                SR.BLN
                        ) TARGET ON PROVINSI.KD_PROV=TARGET.KD_PROV
                    LEFT JOIN 
                        (
                            SELECT 
                            PROV2.KD_PROV,
                            REAL_SALES.QTY AS VOLUME_TON,
                            ((HARGA.HARGA-OA.OA)/1000000) AS REVENUE_JT
                            FROM 
                                (
                                    SELECT 
                                        PROV.KD_PROV,
                                        PROV.NM_PROV
                                    FROM ZREPORT_M_PROVINSI PROV
                                    WHERE PROV.ID_PULAU!=0
                                    ORDER BY PROV.KD_PROV
                                ) PROV2
                            LEFT JOIN 
                                (
                                    SELECT 
                                    RS.PROPINSI_TO,
                                    SUM(RS.QTY) AS QTY
                                    FROM ZREPORT_SCM_REAL_SALES RS
                                    WHERE RS.TAHUN=$tahun
                                    AND RS.BULAN=$bulan
                                    $whereSampaiHariIni
                                    AND ITEM != '121-200'
                                    GROUP BY
                                    RS.PROPINSI_TO
                                ) REAL_SALES ON PROV2.KD_PROV=REAL_SALES.PROPINSI_TO
                            LEFT JOIN 
                                (
                                    SELECT
                                    HARGA.PROPINSI_TO,
                                    SUM(HARGA.KWANTUMX) AS VOL,
                                    SUM(HARGA.HARGA) AS HARGA
                                    FROM ZREPORT_SCM_HARGA HARGA
                                    WHERE HARGA.TAHUN=$tahun
                                    AND HARGA.BULAN=$bulan
                                    $whereSampaiHariIni
                                    AND SUBSTR (ITEM, 1, 7)!='121-200'
                                    GROUP BY 
                                    HARGA.PROPINSI_TO
                                ) HARGA ON PROV2.KD_PROV=HARGA.PROPINSI_TO
                            LEFT JOIN
                                (
                                    SELECT
                                    PROV,
                                    SUM(OA) AS OA,
                                    SUM(QTY) AS QTY
                                    FROM ZREPORT_SCM_OA
                                    WHERE TAHUN=$tahun
                                    AND BULAN=$bulan
                                    AND SUBSTR (MATERIAL, 1, 7)!='121-200'
                                    $whereSampaiHariIni
                                    GROUP BY
                                    PROV
                                ) OA ON PROV2.KD_PROV=OA.PROV       
                        ) REALISASI ON PROVINSI.KD_PROV=REALISASI.KD_PROV $whereRegion";
            $realisasi = $this->db2->query($sql);
            if($realisasi->num_rows() > 0){
                return $realisasi->result();
            } else {
                return false;
            }
        }

        public function testRealisasi(){
            $sql = "SELECT
                        CMP.NAMA_PROVINSI,
                        CC.JUMLAH 
                    FROM
                        CRMNEW_M_PROVINSI CMP
                        LEFT JOIN ( SELECT ID_PROVINSI, COUNT( ID_CUSTOMER ) AS JUMLAH FROM CRMNEW_CUSTOMER WHERE STATUS_TOKO IN (1,2) GROUP BY ID_PROVINSI ) CC ON CMP.ID_PROVINSI = CC.ID_PROVINSI 
                    WHERE
                        CMP.ID_REGION IS NOT NULL ORDER BY CMP.ID_PROVINSI ASC";
            $realisasi = $this->db->query($sql);
            if($realisasi->num_rows() > 0){
                return $realisasi->result();
            } else {
                return false;
            }
        }

        public function testTarget(){
            $sql = "SELECT
                        CMP.NAMA_PROVINSI,
                        CC.JUMLAH 
                    FROM
                        CRMNEW_M_PROVINSI CMP
                        LEFT JOIN ( SELECT ID_PROVINSI, COUNT( ID_CUSTOMER ) AS JUMLAH FROM CRMNEW_CUSTOMER WHERE STATUS_TOKO = 4 GROUP BY ID_PROVINSI ) CC ON CMP.ID_PROVINSI = CC.ID_PROVINSI 
                    WHERE
                        CMP.ID_REGION IS NOT NULL ORDER BY CMP.ID_PROVINSI ASC";
            $realisasi = $this->db->query($sql);
            if($realisasi->num_rows() > 0){
                return $realisasi->result();
            } else {
                return false;
            }
        }
    }
?>
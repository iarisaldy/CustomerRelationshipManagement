<?php
    class Model_ResumePerformance extends CI_Model {

        public function __construct(){
            parent::__construct();
        }

        public function tokoJualan($month = null, $year = null, $lastMonth = null){
            $kodeDist = $this->session->userdata("kode_dist");
            $this->db_tpl = $this->load->database("marketplace", true);
            $sql = "SELECT DISTINCT
                        KD_TOKO, NM_TOKO, NM_KECAMATAN
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        KD_DISTRIBUTOR = '$kodeDist' AND TO_CHAR(TGL_KIRIM, 'YYYY-MM') BETWEEN '$lastMonth' AND '$year-$month' AND KD_TOKO IS NOT NULL";
            $kuantumToko = $this->db_tpl->query($sql);
            if($kuantumToko->num_rows() > 0){
                return $kuantumToko->result();
            } else {
                return false;
            }
        }

        public function kuantumToko($idDistributor = null, $month = null, $year = null, $lastMonth = null){
            $this->db_tpl = $this->load->database("marketplace", true);
            $sql = "SELECT
                        KD_TOKO,
                        TO_CHAR( TGL_KIRIM, 'MM-YYYY' ) AS BULAN,
                        SUM( QTY ) AS KUANTUM 
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        KD_DISTRIBUTOR = '$idDistributor' 
                        AND TO_CHAR( TGL_KIRIM, 'YYYY-MM' ) BETWEEN '$lastMonth' 
                        AND 'year-$month' 
                    GROUP BY
                        KD_TOKO,
                        TO_CHAR( TGL_KIRIM, 'MM-YYYY' ) 
                    ORDER BY
                        TO_CHAR( TGL_KIRIM, 'MM-YYYY' ) DESC";
            $kuantumToko = $this->db_tpl->query($sql);
            if($kuantumToko->num_rows() > 0){
                return $kuantumToko->result();
            } else {
                return false;
            }
        }
    }
?>
<?php
    class Model_DemandForecast extends CI_Model {

        public function __construct(){
            parent::__construct();
        }

        public function addAdjSales($data){
            $this->load->database();
            $date = date('d-m-Y H:i:s');
            $this->db->set('UPDATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
            $this->db->insert("CRMNEW_ADJ_SALES", $data);
            if($this->db->affected_rows() > 0){
                return $data;
            } else {
                return false;
            }
        }

        public function updateAdjSales($data, $idAdjSales){
            $this->load->database();
            $date = date('d-m-Y H:i:s');
            $this->db->set('UPDATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
            $this->db->where("ID_ADJ_SALES", $idAdjSales)->update("CRMNEW_ADJ_SALES", $data);
            if($this->db->affected_rows() > 0){
                return $data;
            } else {
                return false;
            }
        }

        public function dataAdjSales($kodeDist = null, $idAdj = null){
            $this->load->database();
            if(isset($idAdj)){
                $this->db->where("CRMNEW_ADJ_SALES.ID_ADJ_SALES", $idAdj);
            }

            if(isset($kodeDist)){
                 $this->db->where("CRMNEW_ADJ_SALES.KODE_DISTRIBUTOR", $kodeDist);
            }

            $this->db->select("CRMNEW_ADJ_SALES.ID_ADJ_SALES, CRMNEW_ADJ_SALES.ID_CUSTOMER, CRMNEW_ADJ_SALES.ADJ_SALES, CRMNEW_USER.NAMA AS NAMA_UPDATED");
            $this->db->from("CRMNEW_ADJ_SALES");
            $this->db->join("CRMNEW_USER", "CRMNEW_ADJ_SALES.UPDATED_BY = CRMNEW_USER.ID_USER", "left");
            $this->db->where("CRMNEW_ADJ_SALES.DELETE_MARK", "0");
            $data = $this->db->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }

        public function dataPenjualanToko($kodeDist = null){
            $bulan = date('m');
            $tahun = date('Y');
            $fdate = date('Y-m', strtotime('first day of -2 month'));
            $whereDistributor = "WHERE A.NOMOR_DISTRIBUTOR = '00'";
            if(isset($kodeDist)){
                $whereDistributor = "WHERE A.NOMOR_DISTRIBUTOR = '$kodeDist'";
            }

            $this->db_tpl = $this->load->database("marketplace", true);
            $sql = "SELECT
                        A.ID_CUSTOMER,
                        A.NAMA_TOKO,
                        A.NM_DISTRIK,
                        A.ALAMAT_TOKO,
                        A.NOMOR_DISTRIBUTOR AS KODE_DISTRIBUTOR,
                        B.KUANTUM
                    FROM
                        SIDIGI_M_TOKO A
                        JOIN (
                    SELECT
                        KD_TOKO,
                        ROUND( SUM( QTY ) / 3, 2 ) AS KUANTUM 
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        TO_CHAR( TGL_KIRIM, 'YYYY-MM' ) BETWEEN '$fdate' 
                        AND '$tahun-$bulan' 
                    GROUP BY
                        KD_TOKO 
                        ) B ON A.ID_CUSTOMER = B.KD_TOKO 
                        $whereDistributor
                    ORDER BY
                        B.KUANTUM DESC";
            $jual = $this->db_tpl->query($sql);
            if($jual->num_rows() > 0){
                return $jual->result();
            } else {
                return false;
            }
        }
    }
?>
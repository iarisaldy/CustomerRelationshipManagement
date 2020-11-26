<?php
    class Model_RoutingCanvasing extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database("default", true);
        }

        public function fotoSurvey($idKunjungan){
            $sql = "SELECT FOTO_SURVEY FROM CRMNEW_FOTO_SURVEY WHERE ID_KUNJUNGAN_CUSTOMER = '$idKunjungan' AND DELETE_MARK = '0'";
            $canvasing = $this->db->query($sql);
            if($canvasing->num_rows() > 0){
                return $canvasing->result();
            } else {
                return array();
            }
        }

        public function recordCanvasing(){
            $sql = "SELECT
                        TO_CHAR( CHECKIN_TIME, 'MM' ) AS BULAN,
                        COUNT( CKC.ID_KUNJUNGAN_CUSTOMER ) AS JUMLAH 
                    FROM
                        CRMNEW_KUNJUNGAN_CUSTOMER CKC 
                    WHERE
                        CKC.ID_USER = 1027 
                        AND CHECKIN_TIME IS NOT NULL 
                        AND CHECKOUT_TIME IS NOT NULL 
                        AND TO_CHAR( CHECKIN_TIME, 'YYYY' ) = 2018 
                    GROUP BY
                        TO_CHAR( CHECKIN_TIME, 'MM' ) 
                    ORDER BY
                        TO_CHAR( CHECKIN_TIME, 'MM' ) ASC";

            $canvasing = $this->db->query($sql);
            if($canvasing->num_rows() > 0){
                return $canvasing->result();
            } else {
                return false;
            }
              
        }

        public function checkKunjungan($idSurveyor, $idCustomer, $plannedDate){
            $this->db->select("CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER");
            $this->db->from("CRMNEW_KUNJUNGAN_CUSTOMER");
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER", $idSurveyor);
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO", $idCustomer);
            $this->db->where("TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') = ", $plannedDate);
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK", "0");

            $canvasing = $this->db->get();
            if($canvasing->num_rows() > 0){
                return $canvasing->result();
            } else {
                return false;
            }
        }

        public function addCanvasing($data, $plannedDate){
            $date = date('d-m-Y H:i:s');
            $this->db->set('CREATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
            $this->db->set('TGL_RENCANA_KUNJUNGAN',"TO_DATE('".$plannedDate."','yyyy/mm/dd')", false);
            $canvasing = $this->db->insert("CRMNEW_KUNJUNGAN_CUSTOMER", $data);
            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }

        public function updateCanvassing($id, $data, $plannedDate = null){
            $date = date('d-m-Y H:i:s');
            $this->db->set('UPDATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
            if(isset($plannedDate)){
                $this->db->set('TGL_RENCANA_KUNJUNGAN',"TO_DATE('$plannedDate','yyyy-mm-dd')", false);
            }
            $canvasing = $this->db->where("ID_KUNJUNGAN_CUSTOMER", $id)->update("CRMNEW_KUNJUNGAN_CUSTOMER", $data);
            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }

        public function listCanvasing($idUser = null, $isVisited = null, $idDistributor = null, $startDate = null, $endDate = null, $posisi = null, $provinsi = null, $sales = null){
            $idRegion = $this->session->userdata('id_region');
            if(isset($posisi)){
                if($posisi != ""){
                    $this->db->where("CRMNEW_JENIS_USER.ID_JENIS_USER", $posisi);
                }
            }

            if(isset($provinsi)){
                if($provinsi != ""){
                    $this->db->where("CRMNEW_CUSTOMER.ID_PROVINSI", $provinsi);
                }
            }

            if(isset($sales)){
                if($sales != ""){
                    $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER", $sales);
                }
            }

            if($idRegion != "1003"){
                $this->db->where("CRMNEW_USER.ID_REGION", $idRegion);
            }

            if(isset($idUser)){
                $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER", $idUser);

            }

            if(isset($isVisited)){
                $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME is NOT NULL", NULL, FALSE);
            }

            if(isset($idDistributor)){
                if($idDistributor != ""){
                    $this->db->where("CRMNEW_CUSTOMER.ID_DISTRIBUTOR", $idDistributor);
                    if($this->session->userdata("id_jenis_user") != "1001"){
                        $this->db->where("CRMNEW_USER.ID_JENIS_USER", "1003");
                    }
                }
            }

            if(isset($startDate) && isset($endDate)){
                $this->db->where("TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') BETWEEN '$startDate' AND '$endDate'");
            }

            $this->db->select("
                CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER, CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER, CRMNEW_USER.NAMA,
                CRMNEW_CUSTOMER.ID_DISTRIBUTOR, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR,
                CRMNEW_KUNJUNGAN_CUSTOMER.KETERANGAN,
                CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO, CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_JENIS_USER.JENIS_USER,
                ASSIGN.NAMA AS NAMA_ASSIGN,
                TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL_RENCANA_FORMAT_NEW,
                TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'DD - MONTH - YYYY') AS TGL_RENCANA_KUNJUNGAN, 
                TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'DD - MONTH - YYYY / HH24:MI') AS CHECKIN_TIME,
                CRMNEW_KUNJUNGAN_CUSTOMER.CHECKOUT_TIME,
                (TO_DATE(TO_CHAR(CHECKOUT_TIME, 'DD-MM-YYYY HH24:MI:SS'), 'DD-MM-YYYY HH24:MI:SS') - TO_DATE(TO_CHAR(CHECKIN_TIME, 'DD-MM-YYYY HH24:MI:SS'),'DD-MM-YYYY HH24:MI:SS'))*(24*60) AS SELISIH
                ");
            $this->db->from("CRMNEW_KUNJUNGAN_CUSTOMER");
            $this->db->join("CRMNEW_CUSTOMER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO = CRMNEW_CUSTOMER.ID_CUSTOMER");
            $this->db->join("CRMNEW_USER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER");
            $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_CUSTOMER.ID_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
            $this->db->join("CRMNEW_JENIS_USER", "CRMNEW_USER.ID_JENIS_USER = CRMNEW_JENIS_USER.ID_JENIS_USER");
            $this->db->join("(SELECT ID_USER, NAMA FROM CRMNEW_USER) ASSIGN", "CRMNEW_KUNJUNGAN_CUSTOMER.CREATED_BY = ASSIGN.ID_USER", "left");
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK", 0);
            $this->db->where("CRMNEW_USER.DELETED_MARK", 0);
            $this->db->order_by("CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN", "DESC");

            $canvasing = $this->db->get();
            // echo $this->db->last_query();
            if($canvasing->num_rows() > 0){
                return $canvasing->result();
            } else {
                return false;
            }
        }

        public function detailCanvasing($idKunjungan){
            $this->db->select("
                CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER, CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER, CRMNEW_USER.NAMA, 
                CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO, CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_CUSTOMER.NAMA_PEMILIK,
                CRMNEW_CUSTOMER.ALAMAT,
                CRMNEW_KUNJUNGAN_CUSTOMER.KETERANGAN,
                TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN,
                TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'DD/MM/YYYY HH24:MI') AS CHECKIN_TIME,
                CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_LATITUDE, CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_LONGITUDE,
                (TO_DATE(TO_CHAR(CHECKOUT_TIME, 'DD-MM-YYYY HH24:MI:SS'), 'DD-MM-YYYY HH24:MI:SS') - TO_DATE(TO_CHAR(CHECKIN_TIME, 'DD-MM-YYYY HH24:MI:SS'),'DD-MM-YYYY HH24:MI:SS'))*(24*60) AS SELISIH
                ");
            $this->db->from("CRMNEW_KUNJUNGAN_CUSTOMER");
            $this->db->join("CRMNEW_CUSTOMER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO = CRMNEW_CUSTOMER.ID_CUSTOMER");
            $this->db->join("CRMNEW_USER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER");
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK", 0);
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER", $idKunjungan);
            $this->db->order_by("CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN", "ASC");

            $canvasing = $this->db->get();
            if($canvasing->num_rows() > 0){
                return $canvasing->row();
            } else {
                return false;
            }
        }

        public function isianSurveyKunjungan($idKunjungan = null){
            if(isset($idKunjungan)){
                $this->db->where("ID_KUNJUNGAN_CUSTOMER", $idKunjungan);
            }
            $this->db->select("*");
            $this->db->from("HASIL_SURVEY_CUSTOMER");
            $this->db->join("CRMNEW_PRODUK_SURVEY", "HASIL_SURVEY_CUSTOMER.ID_PRODUK = CRMNEW_PRODUK_SURVEY.ID_PRODUK");

            $data = $this->db->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }

    }
?>
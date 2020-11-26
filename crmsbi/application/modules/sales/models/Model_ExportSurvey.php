<?php
    class Model_ExportSurvey extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }


        public function listCanvasing($idPosisi = null, $idDistributor = null, $provinsi = null, $startDate = null, $endDate = null, $sales = null){
            $idRegion = $this->session->userdata('id_region');
            if(isset($idPosisi)){
                if($idPosisi != ""){
                    if($idPosisi != "undefined"){
                        $this->db->where("CRMNEW_JENIS_USER.ID_JENIS_USER", $idPosisi);
                    }
                }
            }

            if(isset($provinsi)){
                if($provinsi != ""){
                    if($provinsi != "undefined"){
                        $this->db->where("CRMNEW_CUSTOMER.ID_PROVINSI", $provinsi);
                    }
                }
            }

            if(isset($sales)){
                if($sales != ""){
                    if($sales != "undefined"){
                        $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER", $sales);
                    }
                }
            }

            if($idRegion != "1003"){
                $this->db->where("CRMNEW_USER.ID_REGION", $idRegion);
            }

            if(isset($idDistributor)){
                if($idDistributor != ""){
                    if($idDistributor != "undefined"){
                        $this->db->where("CRMNEW_CUSTOMER.ID_DISTRIBUTOR", $idDistributor);
                        if($this->session->userdata("id_jenis_user") != "1001" || $this->session->userdata("id_jenis_user") != "1005"){
                            $this->db->where("CRMNEW_USER.ID_JENIS_USER", "1003");
                        }
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
                CRMNEW_M_PROVINSI.NAMA_PROVINSI, CRMNEW_CUSTOMER.NAMA_DISTRIK AS NAMA_KOTA, CRMNEW_CUSTOMER.NAMA_KECAMATAN,
                TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL_RENCANA_FORMAT_NEW,
                TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'DD - MONTH - YYYY') AS TGL_RENCANA_KUNJUNGAN, 
                TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'DD - MONTH - YYYY / HH24:MI') AS CHECKIN_TIME,
                (TO_DATE(TO_CHAR(CHECKOUT_TIME, 'DD-MM-YYYY HH24:MI:SS'), 'DD-MM-YYYY HH24:MI:SS') - TO_DATE(TO_CHAR(CHECKIN_TIME, 'DD-MM-YYYY HH24:MI:SS'),'DD-MM-YYYY HH24:MI:SS'))*(24*60) AS SELISIH
                ");
            $this->db->from("CRMNEW_KUNJUNGAN_CUSTOMER");
            $this->db->join("CRMNEW_CUSTOMER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO = CRMNEW_CUSTOMER.ID_CUSTOMER");
            $this->db->join("CRMNEW_USER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER");
            $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_CUSTOMER.ID_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
            $this->db->join("CRMNEW_JENIS_USER", "CRMNEW_USER.ID_JENIS_USER = CRMNEW_JENIS_USER.ID_JENIS_USER");
            $this->db->join("(SELECT ID_USER, NAMA FROM CRMNEW_USER) ASSIGN", "CRMNEW_KUNJUNGAN_CUSTOMER.CREATED_BY = ASSIGN.ID_USER", "left");
            $this->db->join("CRMNEW_M_PROVINSI","CRMNEW_CUSTOMER.ID_PROVINSI = CRMNEW_M_PROVINSI.ID_PROVINSI", "left");
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK", 0);
            $this->db->where("CRMNEW_USER.DELETED_MARK", 0);
            $this->db->order_by("CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN", "DESC");
            $this->db->order_by("CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME", "DESC");

            $canvasing = $this->db->get();
            if($canvasing->num_rows() > 0){
                return $canvasing->result();
            } else {
                return false;
            }
        }

    }
?>
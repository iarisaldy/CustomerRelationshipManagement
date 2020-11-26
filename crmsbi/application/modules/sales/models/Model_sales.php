<?php
    class Model_sales extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listSales($idDistributor = null, $idUser = null){
            if(isset($idUser)){
                $this->db->where("CRMNEW_USER.ID_USER", $idUser);
            }
            
            $this->db->select("CRMNEW_USER.ID_USER, CRMNEW_USER.NAMA, 
            LISTAGG(CRMNEW_M_AREA.NAMA_AREA, ',' ) WITHIN GROUP ( ORDER BY CRMNEW_USER_AREA.ID_AREA ) USER_AREA 
            ");
            $this->db->from("CRMNEW_USER");
            $this->db->where_in("CRMNEW_USER.ID_JENIS_USER", array('1003','1007'));
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR", $idDistributor);
            $this->db->join("CRMNEW_USER_DISTRIBUTOR", "CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER");
            $this->db->join("CRMNEW_USER_AREA", "CRMNEW_USER.ID_USER = CRMNEW_USER_AREA.ID_USER", "LEFT");
            $this->db->join("CRMNEW_M_AREA", "CRMNEW_USER_AREA.ID_AREA = CRMNEW_M_AREA.ID_AREA");
            $this->db->group_by("CRMNEW_USER.ID_USER, CRMNEW_USER.NAMA");
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", 0);
            $this->db->where("CRMNEW_USER.DELETED_MARK", 0);
            $sales = $this->db->get();
            if($sales->num_rows() > 0){
                return $sales->result();
            } else {
                return false;
            }
        }

        public function listKAM($idRegion = null){
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1005"){
                $idUser = $this->session->userdata("user_id");
                $this->db->where("CRMNEW_USER.ID_USER", $idUser);
            } else {
                $this->db->where("CRMNEW_USER.ID_REGION", $this->session->userdata("id_region"));
            }
            $this->db->select("CRMNEW_USER.ID_USER, CRMNEW_USER.NAMA, CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR");
            $this->db->from("CRMNEW_USER");
            $this->db->join("CRMNEW_USER_DISTRIBUTOR", "CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER");
            $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
            $this->db->where("CRMNEW_USER.ID_REGION", $idRegion);
            $this->db->where_in("CRMNEW_USER.ID_JENIS_USER", array(1005, 1006));
            $this->db->where("CRMNEW_USER.DELETED_MARK", "0");
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", "0");
            

            $kam = $this->db->get();
            if($kam->num_rows() > 0){
                return $kam->result();
            } else {
                return false;
            }
        }

        public function listAM($idRegion = null){
            if(isset($idRegion)){
                $this->db->where("CRMNEW_USER.ID_REGION", $idRegion);
            }

            $this->db->select("CRMNEW_USER.ID_USER, CRMNEW_USER.NAMA, LISTAGG ( CRMNEW_M_AREA.NAMA_AREA, ',' ) WITHIN GROUP ( ORDER BY CRMNEW_M_AREA.ID_AREA ) USER_AREA ");
            $this->db->from("CRMNEW_USER");
            $this->db->join("CRMNEW_USER_AREA", "CRMNEW_USER.ID_USER = CRMNEW_USER_AREA.ID_USER");
            $this->db->join("CRMNEW_M_AREA", "CRMNEW_USER_AREA.ID_AREA = CRMNEW_M_AREA.ID_AREA");
            $this->db->where("CRMNEW_USER.ID_JENIS_USER", "1006");
            $this->db->where("CRMNEW_USER.DELETED_MARK", "0");
            $this->db->where("CRMNEW_USER_AREA.DELETE_MARK", "0");
            $this->db->group_by("CRMNEW_USER.ID_USER, CRMNEW_USER.NAMA");

            $kam = $this->db->get();
            if($kam->num_rows() > 0){
                return $kam->result();
            } else {
                return false;
            }
        }


    }
?>
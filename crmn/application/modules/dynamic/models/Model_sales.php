<?php
    class Model_sales extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
		
		public function Get_data_Sales($distributor=null, $jenis_user=null, $id_user=null){
			$sql =" 
				SELECT
				CU.ID_USER,
				CU.NAMA,
				CU.ID_JENIS_USER,
				UD.KODE_DISTRIBUTOR,
				UA.ID_AREA,
				A.NAMA_AREA
				FROM CRMNEW_USER CU
				LEFT JOIN CRMNEW_USER_DISTRIBUTOR UD ON CU.ID_USER=UD.ID_USER
				LEFT JOIN CRMNEW_USER_AREA UA ON CU.ID_USER=UA.ID_USER
				LEFT JOIN CRMNEW_M_AREA A ON UA.ID_AREA=A.ID_AREA
				WHERE CU.DELETED_MARK='0'
				AND UD.KODE_DISTRIBUTOR='$distributor'
			";
			if($jenis_user!=null){
				$sql .= "
					AND CU.ID_JENIS_USER='$jenis_user'
				";
			}
			if($id_user!=null){
				$sql .= "
					AND CU.ID_USER='$id_user'
				";
			}
			

			return $this->db->query($sql)->result_array();
		}
		public function get_dt_jenis_produk(){
		
			$sql =" 
				SELECT
				ID_JENIS_PRODUK,
				JENIS_PRODUK
				FROM CRMNEW_JENIS_PRODUK_DIST
				WHERE DELETE_MARK=0
			";

			return $this->db->query($sql)->result_array();		
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
			$this->db->last_query();
			
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
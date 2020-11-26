<?php
    class Model_program extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listProgram($idProgram = null){
			/*
            $idRegion = $this->session->userdata("id_region");
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1003" || $idJenisUser == "1004" || $idJenisUser == "1002" || $idJenisUser == "1007"){
                $idDistributor = $this->session->userdata("kode_dist");
                $this->db->where("CRMNEW_PROGRAM_THEDAY.KODE_DISTRIBUTOR", $idDistributor);
                $this->db->where("CRMNEW_PROGRAM_THEDAY.PIC_PROGRAM", "1002");
            } else if($idJenisUser == "1005" || $idJenisUser == "1006" || $idJenisUser == "1001"){
                $this->db->where_in("CRMNEW_PROGRAM_THEDAY.PIC_PROGRAM", array("1001","1002"));
            }
            
            if(isset($idProgram)){
                $this->db->where("CRMNEW_PROGRAM_THEDAY.ID_PROGRAM", $idProgram);
            }

            if($idRegion != '1003'){
                $this->db->where("CRMNEW_USER.ID_REGION", $idRegion);
            }
			*/
            
            $this->db->select("CRMNEW_PROGRAM_THEDAY.ID_PROGRAM, CRMNEW_PROGRAM_THEDAY.JUDUL_PROGRAM, CRMNEW_PROGRAM_THEDAY.DETAIL_PROGRAM, 
            CRMNEW_PROGRAM_THEDAY.CREATE_AT, CRMNEW_PROGRAM_THEDAY.CREATE_BY, TO_CHAR(CRMNEW_PROGRAM_THEDAY.START_DATE, 'YYYY-MM-DD') AS START_DATE, TO_CHAR(CRMNEW_PROGRAM_THEDAY.END_DATE, 'YYYY-MM-DD') AS END_DATE, CRMNEW_PROGRAM_THEDAY.PIC_PROGRAM, CRMNEW_JENIS_USER.JENIS_USER, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR");
            $this->db->from("CRMNEW_PROGRAM_THEDAY");
            $this->db->join("CRMNEW_JENIS_USER", "CRMNEW_PROGRAM_THEDAY.PIC_PROGRAM = CRMNEW_JENIS_USER.ID_JENIS_USER");
            $this->db->join("CRMNEW_USER", "CRMNEW_PROGRAM_THEDAY.CREATE_BY = CRMNEW_USER.ID_USER", "left");
            $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_PROGRAM_THEDAY.KODE_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR", "left");
            $this->db->where("CRMNEW_PROGRAM_THEDAY.DELETE_MARK", 0);
            $this->db->order_by("CRMNEW_PROGRAM_THEDAY.ID_PROGRAM", "DESC");

            $program = $this->db->get();
            if($program->num_rows() > 0){
                return $program->result();
            } else {
                return array();
            }
        }

        public function addProgram($data, $start, $end){
            $date = date('d-m-Y H:i:s');
            $this->db->set('CREATE_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
            $this->db->set('START_DATE',"TO_DATE('$start','yyyy-mm-dd')", false);
            $this->db->set('END_DATE',"TO_DATE('$end','yyyy-mm-dd')", false);
            $canvasing = $this->db->insert("CRMNEW_PROGRAM_THEDAY", $data);
            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }

        public function updateProgram($idProgram, $data, $start, $end){
            $date = date('d-m-Y H:i:s');
            $this->db->set('UPDATE_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
            $this->db->set('START_DATE',"TO_DATE('$start','yyyy-mm-dd')", false);
            $this->db->set('END_DATE',"TO_DATE('$end','yyyy-mm-dd')", false);
            $canvasing = $this->db->where("ID_PROGRAM", $idProgram)->update("CRMNEW_PROGRAM_THEDAY", $data);
            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }
		public function Delete_program($id_program){
			$ss = " DELETE FROM CRMNEW_PROGRAM_THEDAY WHERE ID_PROGRAM='$id_program' ";
			return $this->db->query($ss);
		}
    }
?>
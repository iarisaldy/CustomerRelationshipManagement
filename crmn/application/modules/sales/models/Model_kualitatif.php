<?php
    class Model_kualitatif extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listSurveyKualitatif($name = null, $id = null, $posisi = null, $distributor = null, $provinsi = null, $startDate = null, $endDate = null){
            $idRegion = $this->session->userdata("id_region");
            // if($idRegion != "1003"){
            //     $this->db->where("CRMNEW_USER.ID_REGION", $idRegion);
            // }
            
            if(isset($id)){
                $this->db->where("CRMNEW_SURVEY_KUALITATIF.".$name, $id);
            }

            if(isset($posisi)){
                if($posisi != ""){
                    $this->db->where("CRMNEW_USER.ID_JENIS_USER", $posisi);
                }
            }

            if(isset($distributor)){
                if($distributor != ""){
                    $this->db->where("CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR", $distributor);
                }
            }

            if(isset($provinsi)){
                if($provinsi != ""){
                    $this->db->where("CRMNEW_M_PROVINSI.ID_PROVINSI", $provinsi);
                }
            }

            if($startDate != "" && $endDate != ""){
                $this->db->where("TO_CHAR(CRMNEW_SURVEY_KUALITATIF.CREATE_AT, 'YYYY-MM-DDD') BETWEEN '$startDate' AND '$endDate'");
            }

            $this->db->select("CRMNEW_SURVEY_KUALITATIF.ID_SURVEY_KUALITATIF, 
            CRMNEW_USER.NAMA, TO_CHAR(CRMNEW_SURVEY_KUALITATIF.CREATE_AT, 'DD-MM-YYYY') AS TGL_SURVEY,
            CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR, CRMNEW_M_PROVINSI.NAMA_PROVINSI,
            CRMNEW_SURVEY_KUALITATIF.JAWABAN");
            $this->db->from("CRMNEW_SURVEY_KUALITATIF");
            $this->db->join("CRMNEW_USER", "CRMNEW_SURVEY_KUALITATIF.ID_USER = CRMNEW_USER.ID_USER");
            $this->db->join("CRMNEW_USER_DISTRIBUTOR", "CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER", "LEFT");
            $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR", "LEFT");
            $this->db->join("CRMNEW_USER_PROVINSI", "CRMNEW_USER.ID_USER = CRMNEW_USER_PROVINSI.ID_USER", "LEFT");
            $this->db->join("CRMNEW_M_PROVINSI", "CRMNEW_USER_PROVINSI.ID_PROVINSI = CRMNEW_M_PROVINSI.ID_PROVINSI", "LEFT");
            // $this->db->join("CRMNEW_USER_AREA", "CRMNEW_USER.ID_USER = CRMNEW_USER_AREA.ID_USER");
            // $this->db->join("CRMNEW_M_AREA", "CRMNEW_USER_AREA.ID_AREA = CRMNEW_M_AREA.ID_AREA");
            $this->db->where("CRMNEW_SURVEY_KUALITATIF.DELETE_MARK", 0);
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", 0);
            $this->db->where("CRMNEW_USER_PROVINSI.DELETE_MARK", 0);
            // $this->db->where("CRMNEW_USER_AREA.DELETE_MARK", 0);

            $survey = $this->db->get();
            if($survey->num_rows() > 0){
                return $survey->result();
            } else {
                return false;
            }
        }

        public function addSurvey($data){
            $date = date('d-m-Y H:i:s');
            $this->db->set('CREATE_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
            $this->db->insert("CRMNEW_SURVEY_KUALITATIF", $data);
            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }

        public function updateSurvey($id, $data){
            $date = date('d-m-Y H:i:s');
            $this->db->set('UPDATE_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
            $this->db->where("ID_SURVEY_KUALITATIF", $id)->update("CRMNEW_SURVEY_KUALITATIF", $data);
            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }

    }
?>
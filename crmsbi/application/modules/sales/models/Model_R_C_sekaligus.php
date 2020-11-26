<?php
    class Model_R_C_sekaligus extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
		
		public function listCustomer($idDistributor = null){
            if(isset($idDistributor)){
                $this->db->where("CRMNEW_CUSTOMER.ID_DISTRIBUTOR", $idDistributor);
            }

            $this->db->select("CRMNEW_CUSTOMER.ID_CUSTOMER, CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_CUSTOMER.ALAMAT");
			$this->db->limit(50);
            $this->db->from("CRMNEW_CUSTOMER");
          
            $customer = $this->db->get();
            //echo $this->db->last_query();
            if($customer->num_rows() > 0){
                return $customer->result();
            } else {
                return false;
            }
        }
		
		public function salesDistributor($idDistributor){
            $this->db->select("CRMNEW_USER.ID_USER, UPPER(CRMNEW_USER.NAMA) AS NAMA");
            $this->db->from("CRMNEW_USER");
            $this->db->join("CRMNEW_USER_DISTRIBUTOR", "CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER");
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR", $idDistributor);
            $this->db->where_in("CRMNEW_USER.ID_JENIS_USER", array("1003", "1007"));
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", "0");

            $jenisUser = $this->db->get();
            if($jenisUser){
                return $jenisUser->result();
            } else {
                return false;
            }
        }
	}
?>
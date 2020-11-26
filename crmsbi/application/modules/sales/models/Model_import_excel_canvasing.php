<?php
    class Model_import_excel_canvasing extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
		
		public function checkKunjungan($idSurveyor, $idCustomer, $plannedDate){
            $this->db->select("CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER");
            $this->db->from("CRMNEW_KUNJUNGAN_CUSTOMER");
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER", $idSurveyor);
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO", $idCustomer);
            $this->db->where("TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'DD-MM-YYYY') = ", $plannedDate);
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK", "0");

            $query = $this->db->get();
            return $query->row();
        }
		
		public function addCanvasing($dt_sales, $dt_customer, $plannedDate, $dt_penugasan){
            $date = date('d-m-Y H:i:s');
            $this->db->set('CREATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
            $this->db->set('ID_USER', $dt_sales);
            $this->db->set('ID_TOKO', $dt_customer);
            $this->db->set('TGL_RENCANA_KUNJUNGAN',"TO_DATE('".$plannedDate."','dd/mm/yyyy')", false);
            $this->db->set('KETERANGAN', $dt_penugasan);
            $this->db->set('DELETED_MARK', 0);
            $this->db->insert("CRMNEW_KUNJUNGAN_CUSTOMER");
        }
        
        public function getSalesPerDistributor($idDistributor = null, $idUser = null){
            if(isset($idUser)){
                $this->db->where("CRMNEW_USER.ID_USER", $idUser);
            }
            
            $this->db->select("CRMNEW_USER.ID_USER, CRMNEW_USER.NAMA, 
            LISTAGG(CRMNEW_M_AREA.NAMA_AREA, ',' ) WITHIN GROUP ( ORDER BY CRMNEW_USER_AREA.ID_AREA ) USER_AREA 
            ");
            $this->db->from("CRMNEW_USER");
            $this->db->where_in("CRMNEW_USER.ID_JENIS_USER", array('1003'));
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
        
        public function getCustomerPerDistributor($id_distributor){
            $this->db->from("CRMNEW_CUSTOMER");
            $this->db->join("CRMNEW_M_PROVINSI","CRMNEW_M_PROVINSI.ID_PROVINSI = CRMNEW_CUSTOMER.ID_PROVINSI");
            $this->db->where("CRMNEW_CUSTOMER.ID_DISTRIBUTOR", $id_distributor);
            $this->db->where("CRMNEW_CUSTOMER.DELETE_MARK", 0);
            $this->db->order_by("CRMNEW_CUSTOMER.ID_CUSTOMER", "ASC");
            $customer = $this->db->get();
            if($customer->num_rows() > 0){
                return $customer->result();
            } else {
                return false;
            }
        }
        
        public function getSales($id_sales){
            $this->db->from("CRMNEW_USER");
            $this->db->where("ID_USER", $id_sales);

            $query = $this->db->get();
			return $query->row();
        }
        
        public function getCustomer($id_customer){
            $this->db->from("CRMNEW_CUSTOMER");
            $this->db->where("ID_CUSTOMER", $id_customer);

            $query = $this->db->get();
			return $query->row();
        }
		
	}
?>
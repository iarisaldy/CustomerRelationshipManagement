<?php
	if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_master_sales extends CI_Model {

        function __construct(){
            parent::__construct();
            //$this->load->database();
			$this->db = $this->load->database('crm', TRUE);
        }
		
		public function get_data_sales($id_distributor = null, $id_tso = null, $id_asm = null, $id_rsm = null, $id_gsm = null){
			$sql = "
				SELECT 
				ID_GSM, NAMA_GSM, ID_SSM, NAMA_SSM, ID_SM, NAMA_SM, ID_SO, NAMA_SO, ID_SALES, NAMA_SALES, KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR
				FROM HIRARCKY_GSM_TO_DISTRIBUTOR WHERE ID_SALES IS NOT NULL
			";
			
			if($id_distributor !=  null ){
				$sql .= " AND KODE_DISTRIBUTOR = '$id_distributor'";
			}
			
			if ($id_tso != null) {
				$sql .= " AND ID_SO = '$id_tso'";
			}
			
			if($id_asm != null){
				$sql .= " AND ID_SM = '$id_asm'";
			}
			
			if ($id_rsm = null){
				$sql .= " AND ID_SSM = '$id_rsm'";
			}
			
			if ($id_gsm = null){
				$sql .= " AND ID_GSM = '$id_gsm'";
			}
			
			return $this->db->query($sql)->result_array();
		}
		public function get_data_sales_dua($id_distributor = null, $id_tso = null, $id_asm = null, $id_rsm = null, $id_gsm = null){
			$sql = "
				SELECT
				ID_GSM, NAMA_GSM, ID_SSM, NAMA_SSM, ID_SM, NAMA_SM, ID_SO, NAMA_SO, ID_SALES, NAMA_SALES, USER_SALES, KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR
				FROM LIFERAY_API_SALES
				WHERE ID_SALES IS NOT NULL
			";
			
			if($id_distributor !=  null ){
				$sql .= " AND KODE_DISTRIBUTOR = '$id_distributor'";
			}
			
			if ($id_tso != null) {
				$sql .= " AND ID_SO = '$id_tso'";
			}
			
			if($id_asm != null){
				$sql .= " AND ID_SM = '$id_asm'";
			}
			
			if ($id_rsm = null){
				$sql .= " AND ID_SSM = '$id_rsm'";
			}
			
			if ($id_gsm = null){
				$sql .= " AND ID_GSM = '$id_gsm'";
			}
			
			return $this->db->query($sql)->result_array();
		}
		public function data_distrik($so=null, $sales=null){
			$sql = "
				SELECT
				ID_DISTRIK,
                NM_DISTRIK
				FROM HIRARCKY_GSM_SALES_DISTRIK
				WHERE ID_SALES IS NOT NULL
			";
			
			if($so !=  null ){
				$sql .= " AND ID_SO = '$so'";
			}
			
			if ($sales != null) {
				$sql .= " AND ID_SALES = '$sales'";
			}
			
			return $this->db->query($sql)->result_array();
		}
		
		
		
	}
	
?>
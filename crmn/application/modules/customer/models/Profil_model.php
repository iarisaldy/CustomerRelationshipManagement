<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Profil_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function getDataCustomer($idCustomer){
		// $sql = " SELECT * FROM VIEW_DATA_TOKO_CUSTOMER WHERE ID_CUTOMER = '$idCustomer' ";
		// return $this->db->query($sql)->result_array();
		
		$this->db->select("*");
        $this->db->from("VIEW_DATA_TOKO_CUSTOMER");
        $this->db->where("ID_CUSTOMER", $idCustomer);

        $hasil = $this->db->get();
        if($hasil->num_rows() > 0){
            return $hasil->result_array();
        } else {
            return false;
        }
	}
	
	public function getDataKunjungUpdate($idCustomer){
		$sql = "
			SELECT ID_KUNJUNGAN_CUSTOMER, TO_CHAR(CHECKIN_TIME, 'HH:MM:SS  |  DD-MM-YYYY') AS UPDATEKUNJUNGAN 
			FROM T_KUNJUNGAN_SALES_KE_TOKO 
			WHERE ID_TOKO = '$idCustomer'
				AND CHECKIN_TIME IS NOT NULL
			ORDER BY CHECKIN_TIME DESC
		";
		
        $hasil = $this->db->query($sql);
        if($hasil->num_rows() > 0){
            return $hasil->result_array();
        } else {
            return false;
        }
	}
	
	public function getMappingCustomer($idCustomer){
		// $sql = "
			// SELECT KD_CUSTOMER, NAMA_TOKO, KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR, ID_SALES, NAMA_SALES, ID_TSO, NAMA_TSO, ID_ASM, NAMA_ASM, ID_RSM, NAMA_RSM FROM R_REPORT_TOKO_SALES WHERE KD_CUSTOMER = '$idCustomer'
		// ";
		
		// $sql = "
			// SELECT DISTINCT(KODE_DISTRIBUTOR), NAMA_DISTRIBUTOR, KD_CUSTOMER, NAMA_TOKO, ID_SALES, NAMA_SALES, ID_TSO, NAMA_TSO, ID_ASM, NAMA_ASM, ID_RSM, NAMA_RSM FROM R_REPORT_TOKO_SALES WHERE KD_CUSTOMER = '$idCustomer'
			
			//DISTINCT(KODE_DISTRIBUTOR),
			
		// ";
		
		$sql = "
			SELECT 
				ID_CUSTOMER, 
				NAMA_TOKO,
				ID_DISTRIBUTOR,
				NAMA_DISTRIBUTOR, 
				ID_SALES,
				USERNAME as NAMA_SALES
			FROM MAPPING_TOKO_DIST_SALES 
			WHERE ID_CUSTOMER = '$idCustomer'

		";
		 
        $hasil = $this->db->query($sql);
        if($hasil->num_rows() > 0){
            return $hasil->result_array();
        } else {
            return false;
        }
	}
	
	public function set_lock_unlock($idCustomer, $aksi){
		$set = null;
		if($aksi == 'lock'){
			$set = 1;
		} else {
			$set = 0;
		}
		$id_user = $this->session->userdata('user_id');
		$sql = "
			UPDATE CRMNEW_LOKASI_CUSTOMER
			SET 
				KOORDINAT_LOCK = $set,
				UPDATE_BY = $id_user,
				UPDATE_DATE = SYSDATE
			WHERE ID_CUSTOMER = '$idCustomer'
		";
        $hasil = $this->db->query($sql);
	}
	
	public function get_his_kunjungan($idCustomer){
			$sql = "
				SELECT
					ID_KUNJUNGAN_CUSTOMER AS ID_KUNJUNGAN,
					TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'DD-MM-YYYY') AS RENCANA,
					TO_CHAR(CHECKIN_TIME, 'HH:MM:SS  |  DD-MM-YYYY') AS DIKUNJUNGI,
					NAMA_USER,
					KETERANGAN 
				FROM T_KUNJUNGAN_SALES_KE_TOKO 
				WHERE ID_TOKO = '$idCustomer'
				ORDER BY TGL_RENCANA_KUNJUNGAN DESC
			";
			return $this->db->query($sql)->result();
		}
	
}

?>
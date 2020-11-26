<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Model_visit_plan_tso extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    } 
	
	public function Get_sales_tso($id_tso, $id_sales = null){
		$sql = "
			SELECT DISTINCT(ID_SALES), NAMA_SALES,  USER_SALES as USERNAME
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SALES IS NOT NULL AND NAMA_SALES IS NOT NULL AND ID_SO = '$id_tso'
		";
		
		if($id_sales != null){
			$sql .= " AND ID_SALES = '$id_sales' ";
		}
		
		$sql .= " ORDER BY USER_SALES ";
		
		return $this->db->query($sql)->result();
	}
	
	
	public function get_toko_sales($id_sales){
		$sql = "
			SELECT 
				MTS.KD_CUSTOMER,
				VDTC.NAMA_TOKO,
				MTS.KODE_DISTRIBUTOR,
				MTS.NAMA_DISTRIBUTOR,
				VDTC.NAMA_KECAMATAN,
				VDTC.NAMA_DISTRIK as NM_KOTA,
				VDTC.NAMA_PROVINSI,
				VDTC.NEW_REGION as REGION_NAME
			FROM MAPPING_TOKO_SALES MTS
				LEFT JOIN VIEW_DATA_TOKO_CUSTOMER VDTC
					ON MTS.KD_CUSTOMER = VDTC.ID_CUSTOMER
			WHERE MTS.ID_SALES = '$id_sales' and VDTC.NAMA_TOKO IS NOT NULL
		";
		return $this->db->query($sql)->result();
	}
	
	public function cek_id_sales($id_sales){
		$sql = "
			SELECT  
				ID_USER as ID_SALES, NAMA as NAMA_SALES, USERNAME as UNAME
			FROM CRMNEW_USER 
			WHERE ID_JENIS_USER = '1015' AND DELETED_MARK = 0
			AND ID_USER = '$id_sales'
		";
		return $this->db->query($sql)->row();
	}
	
	public function cek_id_toko($id_toko){
		$sql = "
			SELECT * FROM VIEW_DATA_TOKO_CUSTOMER
			WHERE ID_CUSTOMER = '$id_toko'
		";
		return $this->db->query($sql)->row();
	}
	
	public function cek_id_distributor($id_distributor){
		$sql = "
			SELECT DISTINCT(KODE_DISTRIBUTOR) as KD, NAMA_DISTRIBUTOR FROM CRMNEW_DISTRIBUTOR 
			WHERE DELETE_MARK = 0 AND KODE_DISTRIBUTOR = '$id_distributor'
		";
		return $this->db->query($sql)->row();
	}
	
	public function cek_kesesuaian_data($id_sales, $id_toko, $id_distributor){
		$sql = "
			SELECT * FROM MAPPING_TOKO_SALES
			WHERE 
				KODE_DISTRIBUTOR = '$id_distributor' AND
				ID_SALES =  '$id_sales' AND
				KD_CUSTOMER = '$id_toko'
		";
		return $this->db->query($sql)->row();
	}
	
	public function visit_plan_batch($id_sales, $id_toko, $id_distributor, $SUN, $MON, $TUE, $WED, $THU, $FRI, $SAT, $WEEK_1, $WEEK_2, $WEEK_3, $WEEK_4, $WEEK_5){
		$date = date('d-m-Y H:i:s');
        	$this->db->set('INSERT_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
			$this->db->set('INSERT_BY', '1009');
			$this->db->set('DELETE_MARK', 0);
			$this->db->set('ID_SALES', $id_sales);
			$this->db->set('ID_CUSTOMER', $id_toko);
			$this->db->set('ID_DISTRIBUTOR', $id_distributor);
			$this->db->set('SUN', $SUN);
			$this->db->set('MON', $MON);
			$this->db->set('TUE', $TUE);
			$this->db->set('WED', $WED);
			$this->db->set('THU', $THU);
			$this->db->set('FRI', $FRI);
			$this->db->set('SAT', $SAT);
			$this->db->set('W1', $WEEK_1);
			$this->db->set('W2', $WEEK_2);
			$this->db->set('W3', $WEEK_3);
			$this->db->set('W4', $WEEK_4);
			$this->db->set('W5', $WEEK_5);
        $this->db->insert("CRMNEW_JADWAL_SALES");
	}
	
	
}

?>
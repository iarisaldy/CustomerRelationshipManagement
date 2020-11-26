<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Visit_plan_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        //$this->load->database();
		$this->db = $this->load->database('crm', TRUE);
		
    }
	
	public function get_user_sales($id_jenis_user){ // tak dipakai lagi
		$sql = "
			SELECT  
				CU.ID_USER as ID_SALES, CU.NAMA as NAMA_SALES, CU.USERNAME
			FROM CRMNEW_USER CU
			LEFT JOIN CRMNEW_MAPPING_HIERARKI_USER CMHU
				ON CU.ID_USER = CMHU.USER_ID AND CMHU.DELETE_MARK IS NULL
			WHERE (CU.ID_JENIS_USER = '$id_jenis_user' AND CU.DELETED_MARK != 1) OR (CU.ID_JENIS_USER = '$id_jenis_user' AND CU.DELETED_MARK IS NULL)
			ORDER BY CU.USERNAME ASC
		";
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
			SELECT * FROM M_CUSTOMER
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
		$ndis = $id_distributor;
		if(strlen($id_distributor)==3){
			if($id_distributor<999){
				$id_distributor='0000000'. $id_distributor;
			}
		}
		if(strlen($id_distributor)==4){
			if($id_distributor<9999){
				$id_distributor='000000'. $id_distributor;
			}
		}
		
		$sql = "
			SELECT * FROM MAPPING_TOKO_SALES
			WHERE 
				( KODE_DISTRIBUTOR = '$id_distributor' OR KODE_DISTRIBUTOR = '$ndis' )
				AND ID_SALES =  '$id_sales' 
				AND KD_CUSTOMER = '$id_toko'
		";
		//echo $sql;
		
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
	
	// ----------------------------------------------------------------------------- 
	
	public function get_data_visit_plan($id_distributor =  null, $id_sales = null){
		$sql = "
			SELECT 
				CJS.NO_JADWAL,
				CJS.ID_SALES,
				MTS.NAMA,
				MTS.USERNAME,
				CJS.ID_CUSTOMER,
				MTS.NAMA_TOKO,
				CJS.ID_DISTRIBUTOR,
				MTS.NAMA_DISTRIBUTOR,
				CJS.SUN,
				CJS.MON,
				CJS.TUE,
				CJS.WED,
				CJS.THU,
				CJS.FRI,
				CJS.SAT,
				CJS.W1,
				CJS.W2,
				CJS.W3,
				CJS.W4,
				CJS.W5
			FROM CRMNEW_JADWAL_SALES CJS
				LEFT JOIN MAPPING_TOKO_SALES MTS 
					ON MTS.KD_CUSTOMER = CJS.ID_CUSTOMER AND
						MTS.ID_SALES = CJS.ID_SALES AND
						MTS.KODE_DISTRIBUTOR = CJS.ID_DISTRIBUTOR
				LEFT JOIN CRMNEW_USER CU
					ON CU.ID_USER = CJS.ID_SALES 
			WHERE CJS.DELETE_MARK = 0 AND MTS.NAMA_TOKO IS NOT NULL AND CU.DELETED_MARK = 0
		";
		
		if($id_distributor != null){
			$sql .= " AND CJS.ID_DISTRIBUTOR = '$id_distributor' ";
		}
		
		if($id_sales != null){
			$sql .= " AND CJS.ID_SALES = '$id_sales' ";
		}
		
		$sql .= " ORDER BY MTS.NAMA_DISTRIBUTOR ASC, MTS.NAMA_TOKO ASC ";
		
		return $this->db->query($sql)->result();
	}
	
}

?>
<?php
    class Route_compliance_report_model extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
		
		 public function User_SALES($id_user = null){
			$sql ="
				SELECT DISTINCT(ID_SALES), NAMA_SALES FROM HIRARCKY_GSM_TO_DISTRIBUTOR
				WHERE ID_SALES IS NOT NULL and NAMA_SALES IS NOT NULL
			";
			
			if($id_user!=null){
				$sql .= "AND ID_SO = '$id_user' ";
			}
			$sql .= " ORDER BY NAMA_SALES ASC";
			return $this->db->query($sql)->result();
		}
		
		public function get_kunjunganHarian($id_sales, $tanggal){
			$sql = "
				SELECT
					ID_KUNJUNGAN_CUSTOMER,
					SEQUEN, 
					NAMA_TOKO,
					LOKASI_LATITUDE, 
					LOKASI_LONGITUDE, 
					TO_CHAR(CHECKIN_TIME,'HH24:MI:SS') AS TIME_IN, 
					TO_CHAR(CHECKOUT_TIME,'HH24:MI:SS') AS TIME_OUT,
					CHECKIN_LATITUDE,
					CHECKIN_LONGITUDE,
					WAKTU_KUNJUNGAN, 
					KETERANGAN 
				FROM V_KUNJUNGAN_HARIAN_SALES 
				WHERE id_user = $id_sales AND TO_CHAR(TGL_RENCANA_KUNJUNGAN,'YYYY-MM-DD') = '$tanggal'
				ORDER BY CHECKIN_TIME ASC
			";
			return $this->db->query($sql)->result();
		}
		
		// list user
	
	public function List_Gsm(){
		$sql = "
			SELECT DISTINCT(ID_GSM), NAMA_GSM FROM HIRARCKY_GSM_TO_DISTRIBUTOR
			WHERE ID_GSM IS NOT NULL  AND NAMA_GSM IS NOT NULL
		";
		$sql .= "ORDER BY NAMA_GSM";
		return $this->db->query($sql)->result();
	} 
		
	public function List_rsm($id_gsm = null){	// SSM
		//$sql = "
			//SELECT DISTINCT (ID_RSM), NAMA_RSM FROM M_SALES_DISTRIBUTOR
			//WHERE ID_RSM IS NOT NULL
		//";
		$sql = "
			SELECT DISTINCT(ID_SSM), NAMA_SSM FROM HIRARCKY_GSM_TO_DISTRIBUTOR
			WHERE ID_SSM IS NOT NULL  AND NAMA_SSM IS NOT NULL
		";
		if($id_gsm != null){
			$sql .= " AND ID_GSM = '$id_gsm'";
		}
		$sql .= "ORDER BY NAMA_SSM";
		return $this->db->query($sql)->result();
	}
	
	public function List_asm($id_gsm = null, $id_rsm = null){
		$sql = "
			SELECT DISTINCT(ID_SM), NAMA_SM FROM HIRARCKY_GSM_TO_DISTRIBUTOR
			WHERE ID_SM IS NOT NULL and NAMA_SM IS NOT NULL
		";
		if($id_gsm != null){
			$sql .= " AND ID_GSM = '$id_gsm'";
		}
		if($id_rsm != null){
			$sql .= " AND ID_SSM = '$id_rsm'";
		}
		$sql .= "ORDER BY NAMA_SM";
		return $this->db->query($sql)->result();
	}
	
	public function List_tso($id_gsm = null, $id_rsm = null, $id_asm = null){	//SO
		$sql = "
			SELECT DISTINCT(ID_SO), NAMA_SO FROM HIRARCKY_GSM_TO_DISTRIBUTOR
			WHERE ID_SO IS NOT NULL and NAMA_SO IS NOT NULL
		";
		if($id_gsm != null){
			$sql .= " AND ID_GSM = '$id_gsm'";
		}
		
		if($id_rsm != null){
			$sql .= " AND ID_SSM = '$id_rsm'";
		}
		
		if($id_asm != null){
			$sql .= " AND ID_SM = '$id_asm'";
		}
		
		$sql .= "ORDER BY NAMA_SO";
		
		return $this->db->query($sql)->result();
	}
	
	public function List_sales($id_gsm = null, $id_rsm = null, $id_asm = null, $id_tso = null){	//SD
        $sql ="
            SELECT DISTINCT(ID_SALES), NAMA_SALES FROM HIRARCKY_GSM_TO_DISTRIBUTOR
			WHERE ID_SALES IS NOT NULL and NAMA_SALES IS NOT NULL
        ";
		if($id_gsm != null){
			$sql .= " AND ID_GSM = '$id_gsm'";
		}
		
		if($id_rsm != null){
			$sql .= " AND ID_SSM = '$id_rsm'";
		}
		
		if($id_asm != null){
			$sql .= " AND ID_SM = '$id_asm'";
		}
		
		if($id_tso != null){
			$sql .= " AND ID_SO = '$id_tso'";
		}
		
		$sql .= "ORDER BY NAMA_SALES";
		
        return $this->db->query($sql)->result();
    }
	}
?>
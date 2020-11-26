<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class User_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	public function set_User($id_user, $id_jenis_user, $nama, $username, $password, $email){
		$hasil = false;
		if($id_user != '0000'){
			$sqlUp = "
				UPDATE CRMNEW_USER
				SET 
					NAMA = '$nama',
					USERNAME = '$username',
					PASSWORD = '$password',
					ID_JENIS_USER = '$id_jenis_user',
					EMAIL = '$email',
					UPDATED_BY = '1000',
					UPDATED_AT = SYSDATE,
					DELETED_MARK = 0
				WHERE ID_USER = '$id_user'
			";
			$this->db->query($sqlUp);
			$hasil = true;
		} else {
			$sqlIn = "
				INSERT INTO CRMNEW_USER (NAMA, USERNAME, PASSWORD, ID_JENIS_USER, EMAIL, CREATED_BY, CREATED_AT, FLAG, DELETED_MARK)
				VALUES 
				('$nama', '$username', '$password', '$id_jenis_user', '$email', '1000', SYSDATE, 'SBI', 0)
			";
			$this->db->query($sqlIn);
			$hasil = true;
		}
		return $hasil;
	}
	
	public function del_User($id_user){
		$sqlnext = "
			UPDATE CRMNEW_MAPPING_HIERARKI_USER
			SET 
				DELETE_MARK = 1
			WHERE USER_ID = '$id_user' OR ID_ATASAN_LANGSUNG = '$id_user'
		";
		$hasil2 = $this->db->query($sqlnext);
		
		$sqlFirst = "
			UPDATE CRMNEW_USER
			SET 
				DELETED_MARK = 1
			WHERE ID_USER = '$id_user'
		";
		$hasil1 = $this->db->query($sqlFirst);
		
		return $hasil1.' dan '.$hasil2;
	}
	
	public function get_GSM($id_user = null){
		$sqlIn = "";
		if($id_user != null){
			$sqlIn = " AND CU.ID_USER = '$id_user' ";
		}
		
		$sql = "
			SELECT  
				CU.ID_USER, CU.NAMA, CU.USERNAME, CU.PASSWORD, CU.ID_JENIS_USER, CU.EMAIL, CMHU.ID_ATASAN_LANGSUNG,CMHU.CAKUPAN_WILAYAH, CCW.LABEL 
			FROM CRMNEW_USER CU
			LEFT JOIN CRMNEW_MAPPING_HIERARKI_USER CMHU
				ON CU.ID_USER = CMHU.USER_ID AND CMHU.DELETE_MARK IS NULL
			LEFT JOIN CRMNEW_CAKUPAN_WILAYAH CCW
				ON CMHU.CAKUPAN_WILAYAH = CCW.KODE AND DELETED_MARK IS NULL
			WHERE CU.ID_JENIS_USER = '1016' AND CU.FLAG = 'SBI' AND CU.DELETED_MARK = 0
			$sqlIn
			ORDER BY CU.NAMA ASC
		"; 
		return $this->db->query($sql)->result();
	}
	
	public function get_user_sales($id_jenis_user){ // tak dipakai lagi
		$sqlCekAtas = "";
		if($id_jenis_user == 1010){
			$sqlCekAtas = ",(SELECT ID_GSM FROM SO_TOPDOWN_RSM WHERE ID_RSM = CU.ID_USER AND ROWNUM = 1) AS ID_ATASAN_ON";
		} else if ($id_jenis_user == 1011){
			$sqlCekAtas = ",(SELECT ID_RSM FROM SO_TOPDOWN_ASM WHERE ID_ASM = CU.ID_USER AND ROWNUM = 1) AS ID_ATASAN_ON";
		} else if ($id_jenis_user == 1012){
			$sqlCekAtas = ",(SELECT ID_ASM FROM SO_TOPDOWN_TSO WHERE ID_TSO = CU.ID_USER AND ROWNUM = 1) AS ID_ATASAN_ON";
		} else if ($id_jenis_user == 1015){
			$sqlCekAtas = ",(SELECT ID_TSO FROM SO_TOPDOWN_SALES WHERE ID_USER = CU.ID_USER AND ROWNUM = 1) AS ID_ATASAN_ON";
		}
		
		$sql = "
			SELECT  
				CU.ID_USER, CU.NAMA, CU.USERNAME, CU.PASSWORD, CU.ID_JENIS_USER, CU.EMAIL, CMHU.ID_ATASAN_LANGSUNG, 
				(SELECT NAMA FROM CRMNEW_USER WHERE ID_USER = CMHU.ID_ATASAN_LANGSUNG) AS ATASAN, CMHU.CAKUPAN_WILAYAH
				$sqlCekAtas
			FROM CRMNEW_USER CU
			LEFT JOIN CRMNEW_MAPPING_HIERARKI_USER CMHU
				ON CU.ID_USER = CMHU.USER_ID AND CMHU.DELETE_MARK IS NULL
			WHERE (CU.ID_JENIS_USER = '$id_jenis_user' AND CU.DELETED_MARK != 1) OR (CU.ID_JENIS_USER = '$id_jenis_user' AND CU.DELETED_MARK IS NULL)
			ORDER BY CU.NAMA ASC
		";
		return $this->db->query($sql)->result();
	}
	
	public function get_user($id_user){
		$sql = "
			SELECT CU.ID_USER, CU.NAMA, CU.USERNAME, CU.PASSWORD, CU.EMAIL, CU.ID_JENIS_USER, 
				(SELECT JENIS_USER FROM CRMNEW_JENIS_USER WHERE ID_JENIS_USER = CU.ID_JENIS_USER) AS JENIS_USER
			FROM CRMNEW_USER CU 
			WHERE CU.ID_USER = '$id_user'
		";
		return $this->db->query($sql)->result_array();
	}
	
	// ----------------------------------------------------------------------------- >>> TERBARU 13/02/2020
	
	public function get_user_ssm_Unmap(){
		$sql = "
			SELECT ID_RSM as ID_USER, NAMA_RSM as NAMA FROM SO_TOPDOWN_RSM
			WHERE ID_GSM IS NULL
			ORDER BY NAMA_RSM
		";
		return $this->db->query($sql)->result();
	}
	
	public function get_user_sm_Unmap(){
		$sql = "
			SELECT ID_ASM as ID_USER, NAMA_ASM as NAMA FROM SO_TOPDOWN_ASM
			WHERE ID_RSM IS NULL
			ORDER BY NAMA_ASM
		";
		return $this->db->query($sql)->result();
	}
	
	public function get_user_so_Unmap(){
		$sql = "
			SELECT ID_TSO as ID_USER, NAMA_TSO as NAMA FROM SO_TOPDOWN_TSO
			WHERE ID_ASM IS NULL
			ORDER BY NAMA_TSO
		";
		return $this->db->query($sql)->result();
	}
	
	public function get_user_sd_Unmap(){
		$sql = "
			SELECT ID_USER, NAMA FROM SO_TOPDOWN_SALES
			WHERE ID_TSO IS NULL
			ORDER BY NAMA
		";
		return $this->db->query($sql)->result();
	}
	
	/*
	public function get_region(){
		$sql = "
			SELECT kode,label FROM CRMNEW_CAKUPAN_WILAYAH WHERE LENGTH(kode)=2 ORDER BY label
		";
		return $this->db->query($sql)->result();
	}
	
	public function set_Wilayah_GSM($id_gsm, $wilayah){
		$sqlCek = "
			SELECT * FROM CRMNEW_MAPPING_HIERARKI_USER
			WHERE USER_ID = '$id_gsm'
		";
		$hasil_cek = $this->db->query($sqlCek)->result_array();
		$hasil = false;
		if(count($hasil_cek) == 1){
			$sqlUp = "
				UPDATE CRMNEW_MAPPING_HIERARKI_USER
				SET 
					CAKUPAN_WILAYAH = '$wilayah',
					UPDATE_BY = '1000',
					UPDATE_AT = SYSDATE
				WHERE USER_ID = '$id_gsm'
			";
			$this->db->query($sqlUp);
			$hasil = true;
		} else {
			$sqlIn = "
				INSERT INTO CRMNEW_MAPPING_HIERARKI_USER (USER_ID, CAKUPAN_WILAYAH, CREATE_BY, CREATE_AT)
				VALUES 
				('$id_gsm', '$wilayah', '1000', SYSDATE)
			";
			$this->db->query($sqlIn);
			$hasil = true;
		}
		return $hasil;
	}
	
	public function set_Atasan($id_user, $atasan){
		$sqlCek = "
			SELECT * FROM CRMNEW_MAPPING_HIERARKI_USER
			WHERE USER_ID = '$id_user'
		";
		$hasil_cek = $this->db->query($sqlCek)->result_array();
		$hasil = false;
		if(count($hasil_cek) == 1){
			$sqlUp = "
				UPDATE CRMNEW_MAPPING_HIERARKI_USER
				SET 
					ID_ATASAN_LANGSUNG = '$atasan',
					UPDATE_BY = '1000',
					UPDATE_AT = SYSDATE
				WHERE USER_ID = '$id_user'
			";
			$this->db->query($sqlUp);
			$hasil = true;
		} else {
			$sqlIn = "
				INSERT INTO CRMNEW_MAPPING_HIERARKI_USER (USER_ID, ID_ATASAN_LANGSUNG, CREATE_BY, CREATE_AT)
				VALUES 
				('$id_user', '$atasan', '1000', SYSDATE)
			";
			$this->db->query($sqlIn);
			$hasil = true;
		}
		return $hasil;
	}
	*/
	
	public function get_jenis_user(){
		$sql = "
			SELECT * FROM CRMNEW_JENIS_USER 
			WHERE CREATED_BY IS NOT NULL
			ORDER BY CREATED_BY DESC
		";
		return $this->db->query($sql)->result();
	}
	
	public function getJenisUser($id_j_u){
        $this->db->from("CRMNEW_JENIS_USER");
        $this->db->where("ID_JENIS_USER", $id_j_u);
        $query = $this->db->get();
		return $query->row();
    }
	
	public function add_user_batch($nama, $username, $password, $id_jenis_user){
		$date = date('d-m-Y H:i:s');
        	$this->db->set('CREATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
			$this->db->set('CREATED_BY', '1009');
			$this->db->set('DELETED_MARK', 0);
			$this->db->set('NAMA', $nama);
            $this->db->set('USERNAME', $username);
            $this->db->set('PASSWORD', $password);
			$this->db->set('ID_JENIS_USER', $id_jenis_user);
			$this->db->set('FLAG', 'SBI');
        $this->db->insert("CRMNEW_USER");
	}
	
	//--------------------------------------------------------------------------------------------
	// TERKAIT USER MAPPING // 
	//-------------------------------------------------------------------------------------------- HIERAKI USER / tidak dipakai lagi
	
		public function list_gsm_user($id_user){
			$sql = "
				SELECT 
					CUG.ID_GSM AS ID, CU.NAMA
				FROM CRMNEW_USER_GSM CUG
				LEFT JOIN CRMNEW_USER CU 
					ON CUG.ID_GSM = CU.ID_USER
				WHERE CUG.ID_USER = '$id_user' AND CUG.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_ssm_user($id_user){
			$sql = "
				SELECT 
					CUR.ID_RSM AS ID, CU.NAMA
				FROM CRMNEW_USER_RSM CUR
				LEFT JOIN CRMNEW_USER CU 
					ON CUR.ID_RSM = CU.ID_USER
				WHERE CUR.ID_USER = '$id_user' AND CUR.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_sm_user($id_user){
			$sql = "
				SELECT 
					CUA.ID_ASM AS ID, CU.NAMA
				FROM CRMNEW_USER_ASM CUA
				LEFT JOIN CRMNEW_USER CU 
					ON CUA.ID_ASM = CU.ID_USER
				WHERE CUA.ID_USER = '$id_user' AND CUA.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_so_user($id_user){
			$sql = "
				SELECT 
					CUT.ID_TSO AS ID, CU.NAMA
				FROM CRMNEW_USER_TSO CUT
				LEFT JOIN CRMNEW_USER CU 
					ON CUT.ID_TSO = CU.ID_USER
				WHERE CUT.ID_USER = '$id_user' AND CUT.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_sd_user($id_user){
			$sql = "
				SELECT 
					CUS.ID_SALES AS ID, CU.NAMA
				FROM CRMNEW_USER_SALESMAN CUS
				LEFT JOIN CRMNEW_USER CU 
					ON CUS.ID_SALES = CU.ID_USER
				WHERE CUS.ID_USER = '$id_user' AND CUS.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		// ------------------------------------------------------------------------------------ >>> NEW UNTUK FITUR HIRARKI
		
		public function list_ssm_userOfGsm($id_user){
			$sql = "
				SELECT 
					CUG.ID_USER AS ID, CU.NAMA
				FROM CRMNEW_USER_GSM CUG
				LEFT JOIN CRMNEW_USER CU 
					ON CUG.ID_USER = CU.ID_USER
				WHERE CUG.ID_GSM = '$id_user' AND CUG.DELETE_MARK = 0
				ORDER BY CU.NAMA ASC
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_sm_userOfSsm($id_user){
			$sql = "
				SELECT 
					CUR.ID_USER AS ID, CU.NAMA
				FROM CRMNEW_USER_RSM CUR
				LEFT JOIN CRMNEW_USER CU 
					ON CUR.ID_USER = CU.ID_USER
				WHERE CUR.ID_RSM = '$id_user' AND CUR.DELETE_MARK = 0
				ORDER BY CU.NAMA ASC
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_so_userOfSm($id_user){
			$sql = "
				SELECT 
					CUA.ID_USER AS ID, CU.NAMA
				FROM CRMNEW_USER_ASM CUA
				LEFT JOIN CRMNEW_USER CU 
					ON CUA.ID_USER = CU.ID_USER
				WHERE CUA.ID_ASM = '$id_user' AND CUA.DELETE_MARK = 0
				ORDER BY CU.NAMA ASC
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_sd_userOfSo($id_user){
			$sql = "
				SELECT 
					CUT.ID_USER AS ID, CU.NAMA
				FROM CRMNEW_USER_TSO CUT
				LEFT JOIN CRMNEW_USER CU 
					ON CUT.ID_USER = CU.ID_USER
				WHERE CUT.ID_TSO = '$id_user' AND CUT.DELETE_MARK = 0
				ORDER BY CU.NAMA ASC
			";
			return $this->db->query($sql)->result();
		}
		
		//------------------------------------------------------------------------------ CAKUPAN WILAYAH
		
		public function get_cakupan_wilayah($DtRequest){
			$sqlEksekusi = "";
			
			$sqlRegion = "
				SELECT DISTINCT(REGION_ID) as ID, REGION_NAME as NAMA FROM WILAYAH_SMI ORDER BY REGION_NAME
			";
			
			$sqlProvinsi = "
				SELECT DISTINCT(ID_PROVINSI) as ID, NAMA_PROVINSI as NAMA FROM WILAYAH_SMI ORDER BY NAMA_PROVINSI
			";
			
			$sqlArea = "
				SELECT DISTINCT(KD_AREA) as ID, NM_AREA as NAMA FROM WILAYAH_SMI WHERE KD_AREA IS NOT NULL ORDER BY KD_AREA
			";
			// SELECT DISTINCT(KD_KOTA) as ID, NM_KOTA as NAMA FROM WILAYAH_SMI WHERE KD_KOTA IS NOT NULL ORDER BY NM_KOTA
			$sqlDistrik = "
				SELECT DISTINCT(KD_KOTA) as ID, NM_KOTA as NAMA FROM DISTRIK_TSO WHERE ID_USER IS NULL ORDER BY NM_KOTA
			";
			
			if($DtRequest == 'region'){
				$sqlEksekusi = $sqlRegion;
			} elseif($DtRequest == 'provinsi'){
				$sqlEksekusi = $sqlProvinsi;
			} elseif($DtRequest == 'area'){
				$sqlEksekusi = $sqlArea;
			} elseif($DtRequest == 'distrik'){
				$sqlEksekusi = $sqlDistrik;
			}
			
			return $this->db->query($sqlEksekusi)->result();
		}
		
		public function list_region_user($id_user){
			$sql = "
				SELECT 
					CUR.ID_REGION AS ID, WS.REGION_NAME AS LABEL
				FROM CRMNEW_USER_REGION CUR
				LEFT JOIN (SELECT DISTINCT(REGION_ID), REGION_NAME FROM WILAYAH_SMI ORDER BY REGION_NAME) WS
					ON CUR.ID_REGION = WS.REGION_ID
				WHERE CUR.ID_USER = '$id_user' AND CUR.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_provinsi_user($id_user){
			$sql = "
				SELECT 
					CUR.ID_PROVINSI AS ID, WS.NAMA_PROVINSI AS LABEL
				FROM CRMNEW_USER_PROVINSI CUR
                LEFT JOIN (SELECT DISTINCT(ID_PROVINSI), NAMA_PROVINSI FROM WILAYAH_SMI ORDER BY NAMA_PROVINSI) WS
					ON CUR.ID_PROVINSI = WS.ID_PROVINSI
				WHERE CUR.ID_USER = '$id_user' AND CUR.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_area_user($id_user){
			$sql = "
				SELECT 
					CUR.KD_AREA AS ID, WS.NM_AREA AS LABEL
				FROM CRMNEW_USER_AREA1 CUR
                LEFT JOIN (SELECT DISTINCT(KD_AREA), NM_AREA FROM WILAYAH_SMI WHERE KD_AREA IS NOT NULL ORDER BY KD_AREA) WS
					ON CUR.KD_AREA = WS.KD_AREA
				WHERE CUR.ID_USER = '$id_user' AND CUR.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
			//olde=: tabel AREA
		}
		
		public function list_distrik_user($id_user){
			$sql = "
				SELECT 
					CUR.ID_DISTRIK AS ID, WS.NM_KOTA AS LABEL
				FROM CRMNEW_USER_DISTRIK CUR
                LEFT JOIN (SELECT DISTINCT(KD_KOTA), NM_KOTA FROM WILAYAH_SMI WHERE KD_KOTA IS NOT NULL ORDER BY NM_KOTA) WS
					ON CUR.ID_DISTRIK = WS.KD_KOTA
				WHERE CUR.ID_USER = '$id_user' AND CUR.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		//------------------------------------------------------------------------------ DISTRIBUTOR DAN GUDANG
		
		public function get_distributor_gudang($DtRequest){
			$sqlEksekusi = "";
			
			$sqlDistributor = "
				SELECT DISTINCT(KODE_DISTRIBUTOR) as KD, NAMA_DISTRIBUTOR as NAMA, ORG FROM CRMNEW_DISTRIBUTOR 
				WHERE DELETE_MARK = 0
				ORDER BY ORG ASC, NAMA_DISTRIBUTOR ASC 
			";
			
			$sqlGudang = "
				SELECT DISTINCT(KD_GUDANG) as KD, NAMA_GUDANG as NAMA FROM CRMNEW_MASTER_GUDANG 
				ORDER BY NAMA_GUDANG ASC 
			";
			
			if($DtRequest == 'distributor'){
				$sqlEksekusi = $sqlDistributor;
			} elseif($DtRequest == 'gudang'){
				$sqlEksekusi = $sqlGudang;
			}
			
			return $this->db->query($sqlEksekusi)->result();
		}
		
		public function list_distributor_user($id_user){
			$sql = "
				SELECT 
					CUD.KODE_DISTRIBUTOR AS KODE, CD.NAMA_DISTRIBUTOR AS NAMA
				FROM CRMNEW_USER_DISTRIBUTOR CUD
				LEFT JOIN CRMNEW_DISTRIBUTOR CD 
					ON CUD.KODE_DISTRIBUTOR = CD.KODE_DISTRIBUTOR
				WHERE CUD.ID_USER = '$id_user' AND CUD.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_gudang_user($id_user){
			$sql = "
				SELECT 
					CUD.KD_GUDANG AS KODE, CD.NAMA_GUDANG AS NAMA
				FROM CRMNEW_USER_GUDANG1 CUD
				LEFT JOIN CRMNEW_MASTER_GUDANG CD 
					ON CUD.KD_GUDANG = CD.KD_GUDANG
				WHERE CUD.ID_USER = '$id_user' AND CUD.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		// ------------------------------------------------------------------------------------> Set IN OR DEL Mapping Hierarki // TIDAK DIPAKAI
		
			public function set_gsm_user($actIn_or_Del, $id_user, $valueIn){
				
			}
			
			public function set_ssm_user($actIn_or_Del, $id_user, $valueIn){ //RSM
				$sqlIn = "
						INSERT INTO CRMNEW_USER_RSM (ID_USER, ID_RSM, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_RSM SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_RSM = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_RSM WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_RSM = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_sm_user($actIn_or_Del, $id_user, $valueIn){ //ASM
				$sqlIn = "
						INSERT INTO CRMNEW_USER_ASM (ID_USER, ID_ASM, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_ASM SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_ASM = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_ASM WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_ASM = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_so_user($actIn_or_Del, $id_user, $valueIn){ //TSO
				$sqlIn = "
						INSERT INTO CRMNEW_USER_TSO (ID_USER, ID_TSO, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_TSO SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_TSO = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_TSO WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_TSO = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_sd_user($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_SALESMAN (ID_USER, ID_SALES, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_SALESMAN SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_SALES = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_SALESMAN WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_SALES = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
		
		// ------------------------------------------------------------------------------------>> Set IN OR DEL Mapping Hierarki
		
			public function set_ssm_userGsm($actIn_or_Del, $id_user, $valueIn){ //RSM
				$sqlIn = "
						INSERT INTO CRMNEW_USER_GSM (ID_USER, ID_GSM, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$valueIn', '$id_user', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_GSM SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$valueIn' AND ID_GSM = '$id_user'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_GSM WHERE DELETE_MARK = 0 AND
						ID_USER = '$valueIn' AND ID_GSM = '$id_user' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_sm_userSsm($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_RSM (ID_USER, ID_RSM, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$valueIn', '$id_user', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_RSM SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$valueIn' AND ID_RSM = '$id_user'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_RSM WHERE DELETE_MARK = 0 AND
						ID_USER = '$valueIn' AND ID_RSM = '$id_user' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_so_userSm($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_ASM (ID_USER, ID_ASM, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$valueIn', '$id_user', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_ASM SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$valueIn' AND ID_ASM = '$id_user'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_ASM WHERE DELETE_MARK = 0 AND
						ID_USER = '$valueIn' AND ID_ASM = '$id_user' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_sd_userSo($actIn_or_Del, $id_user, $valueIn){ // TSO
				$sqlIn = "
						INSERT INTO CRMNEW_USER_TSO (ID_USER, ID_TSO, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$valueIn', '$id_user', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_TSO SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$valueIn' AND ID_TSO = '$id_user'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_TSO WHERE DELETE_MARK = 0 AND
						ID_USER = '$valueIn' AND ID_TSO = '$id_user' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
		
		// ------------------------------------------------------------------------------------> Set IN OR DEL Mapping Wilayah
		
			public function set_region_user($actIn_or_Del, $id_user, $valueIn){
				
				$sqlIn = "
						INSERT INTO CRMNEW_USER_REGION (ID_USER, ID_REGION, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_REGION SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_REGION = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_REGION WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_REGION = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_provinsi_user($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_PROVINSI (ID_USER, ID_PROVINSI, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
				$sqlDel = "
					UPDATE CRMNEW_USER_PROVINSI SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_PROVINSI = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_PROVINSI WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_PROVINSI = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_area_user($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_AREA1 (ID_USER, KD_AREA, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
				$sqlDel = "
					UPDATE CRMNEW_USER_AREA1 SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND KD_AREA = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_AREA1 WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND KD_AREA = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_distrik_user($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_DISTRIK (ID_USER, ID_DISTRIK, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
				$sqlDel = "
					UPDATE CRMNEW_USER_DISTRIK SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_DISTRIK = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_DISTRIK WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_DISTRIK = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
		// ------------------------------------------------------------------------------------> Set IN OR DEL Mapping DISTRIBUTOR dan GUDANG
			
			public function set_distributor_user($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_DISTRIBUTOR (ID_USER, KODE_DISTRIBUTOR, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
				$sqlDel = "
					UPDATE CRMNEW_USER_DISTRIBUTOR SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND KODE_DISTRIBUTOR = '$valueIn'
				";
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND KODE_DISTRIBUTOR = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
				
			}
			
			public function set_gudang_user($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_GUDANG1 (ID_USER, KD_GUDANG, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
				$sqlDel = "
					UPDATE CRMNEW_USER_GUDANG1 SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND KD_GUDANG = '$valueIn'
				";
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_GUDANG1 WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND KD_GUDANG = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
	// ----------------------------------- Pencocokan mapping hierarkki
	
	public function get_gsm_hierarki($datas_id){
		$sql = "
			SELECT ID_RSM AS ID, NAMA_RSM AS NAMA FROM SO_TOPDOWN_RSM 
			WHERE ID_GSM IN ($datas_id)
		";
		$this->db->query($sql)->result_array();;
	}
	
}

?>
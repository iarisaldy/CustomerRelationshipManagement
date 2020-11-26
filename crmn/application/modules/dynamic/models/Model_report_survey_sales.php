<?php

if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Model_report_survey_sales extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	public function List_setDt_select($request){
		$id_user       = $this->session->userdata('user_id');
		$id_jenis_user    = $this->session->userdata('id_jenis_user');
		
		if($request == "1-GSM"){
			$sql = "
				SELECT DISTINCT (ID_GSM) as ID, NAMA_GSM as NAMA FROM REPORT_HASIL_PENILAIAN_SALES
				WHERE ID_GSM IS NOT NULL
				
			";
		} else if($request == "2-SSM"){
			$sql = "
				SELECT DISTINCT (ID_SSM) as ID, NAMA_SSM as NAMA FROM REPORT_HASIL_PENILAIAN_SALES
				WHERE ID_SSM IS NOT NULL
				
			";
		} else if($request == "3-SM"){
			$sql = "
				SELECT DISTINCT (ID_SM) as ID, NAMA_SM as NAMA FROM REPORT_HASIL_PENILAIAN_SALES
				WHERE ID_SM IS NOT NULL
				
			";
		} else if($request == "4-SO"){
			$sql = "
				SELECT DISTINCT (ID_SO) as ID, NAMA_SO as NAMA FROM REPORT_HASIL_PENILAIAN_SALES
				WHERE ID_SO IS NOT NULL
				
			";
		} else if($request == "5-SALES"){
			$sql = "
				SELECT DISTINCT (ID_SALES) as ID, NAMA_SALES as NAMA FROM REPORT_HASIL_PENILAIAN_SALES
				WHERE ID_SALES IS NOT NULL
				
			";
		} else if($request == "6-DISTRIBUTOR"){
			$sql = "
				SELECT DISTINCT (KODE_DISTRIBUTOR) as ID, NAMA_DISTRIBUTOR as NAMA FROM REPORT_HASIL_PENILAIAN_SALES
				WHERE KODE_DISTRIBUTOR IS NOT NULL
				
			";
		} 
		
			if($id_jenis_user == 1016){				//GSM
				$sql .= " AND ID_GSM = '$id_user'";
			} else if($id_jenis_user == 1010){		//SSM
				$sql .= " AND ID_SSM = '$id_user'";
			} else if($id_jenis_user == 1011){		//SM
				$sql .= " AND ID_SM = '$id_user'";
			} else if($id_jenis_user == 1012){		//SO
				$sql .= " AND ID_SO = '$id_user'";  
			} else if($id_jenis_user == 1017){		//SPC
				$sql .= " AND REGION IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE ID_USER = '$id_user' AND DELETE_MARK = 0) ";  
			} 
		
		if($request == "1-GSM"){
			$sql .= " ORDER BY NAMA_GSM";
		} else if($request == "2-SSM"){
			$sql .= " ORDER BY NAMA_SSM";
		} else if($request == "3-SM"){
			$sql .= " ORDER BY NAMA_SM";
		} else if($request == "4-SO"){
			$sql .= " ORDER BY NAMA_SO";
		} else if($request == "5-SALES"){
			$sql .= " ORDER BY NAMA_SALES";
		} else if($request == "6-DISTRIBUTOR"){
			$sql .= " ORDER BY NAMA_DISTRIBUTOR";
		}
		return $this->db->query($sql)->result();
	}
	
	public function getDataSurvei($by, $set, $tahun){
		//admin = 1009, gsm = 1016, rsm/ssm = 1010, asm/sm = 1011, tso/so = 1012
		$id_user 	 	= $this->session->userdata('user_id');
		$id_jenis_user  = $this->session->userdata('id_jenis_user');
		
		if($by == null and $set == null and $tahun == null){
			$sql = "
				SELECT 
				
				NO_VISIT, TO_CHAR(TGL_KUNJUNGAN_TSO, 'DD-MM-YYYY') as TGL_KUNJUNGAN_TSO, ID_SO, NAMA_SO, ID_SALES, NAMA_SALES, KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR, NAMA_TOKO, ID_TOKO, TELP_TOKO, ALAMAT, NAMA_PEMILIK, NAMA_KECAMATAN, NAMA_DISTRIK, NAMA_PROVINSI, NAMA_AREA, REGION, POINT_PEROLEHAN, POINT_MAX, APPROVAL_SALES, KESIMPULAN, ID_GSM, NAMA_GSM, ID_SSM, NAMA_SSM, ID_SM, NAMA_SM, ID_KUNJUNGAN_SALES
				
				FROM REPORT_HASIL_PENILAIAN_SALES
				WHERE ROWNUM <= 500 
			";
			if($id_jenis_user == 1016){				//GSM
				$sql .= " AND ID_GSM = '$id_user'";
			} else if($id_jenis_user == 1010){		//SSM
				$sql .= " AND ID_SSM = '$id_user'";
			} else if($id_jenis_user == 1011){		//SM
				$sql .= " AND ID_SM = '$id_user'";
			} else if($id_jenis_user == 1012){		//SO
				$sql .= " AND ID_SO = '$id_user'";  
			} else if($id_jenis_user == 1017){		//SPC
				$sql .= " AND REGION IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE ID_USER = '$id_user' AND DELETE_MARK = 0) ";  
			} 
			
			$sql .= " ORDER BY TGL_KUNJUNGAN_TSO ASC"; 
		} else {
			$sql = "
				SELECT
				
				NO_VISIT, TO_CHAR(TGL_KUNJUNGAN_TSO, 'DD-MM-YYYY') as TGL_KUNJUNGAN_TSO, ID_SO, NAMA_SO, ID_SALES, NAMA_SALES, KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR, NAMA_TOKO, ID_TOKO, TELP_TOKO, ALAMAT, NAMA_PEMILIK, NAMA_KECAMATAN, NAMA_DISTRIK, NAMA_PROVINSI, NAMA_AREA, REGION, POINT_PEROLEHAN, POINT_MAX, APPROVAL_SALES, KESIMPULAN, ID_GSM, NAMA_GSM, ID_SSM, NAMA_SSM, ID_SM, NAMA_SM, ID_KUNJUNGAN_SALES
				
				FROM REPORT_HASIL_PENILAIAN_SALES
				WHERE NO_VISIT IS NOT NULL AND TO_CHAR(TGL_KUNJUNGAN_TSO, 'YYYY') = '$tahun'
			";
			
			if($by == 0){
				
			} else if($by == 1){
				$sql .= " AND ID_GSM = '$set'";
			} else if($by == 2){
				$sql .= " AND ID_SSM = '$set'";
			} else if($by == 3){
				$sql .= " AND ID_SM = '$set'";
			} else if($by == 4){
				$sql .= " AND ID_SO = '$set'";
			} else if($by == 5){
				$sql .= " AND ID_SALES = '$set'";
			} else if($by == 6){
				$sql .= " AND KODE_DISTRIBUTOR = '$set'";
			}
			
			if($id_jenis_user == 1016){				//GSM
				$sql .= " AND ID_GSM = '$id_user'";
			} else if($id_jenis_user == 1010){		//SSM
				$sql .= " AND ID_SSM = '$id_user'";
			} else if($id_jenis_user == 1011){		//SM
				$sql .= " AND ID_SM = '$id_user'";
			} else if($id_jenis_user == 1012){		//SO
				$sql .= " AND ID_SO = '$id_user'";  
			} else if($id_jenis_user == 1017){		//SPC
				$sql .= " AND REGION IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE ID_USER = '$id_user' AND DELETE_MARK = 0) ";  
			} 
			
			$sql .= " ORDER BY TGL_KUNJUNGAN_TSO ASC";
		}
		return $this->db->query($sql)->result();
	}
	
		public function getDetailSurvei($no_visit){
			$sql = "
				SELECT
				
				NO_VISIT, TO_CHAR(TGL_KUNJUNGAN_TSO, 'DD-MM-YYYY') as TGL_KUNJUNGAN_TSO, ID_SO, NAMA_SO, ID_SALES, NAMA_SALES, KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR, NAMA_TOKO, ID_TOKO, TELP_TOKO, ALAMAT, NAMA_PEMILIK, NAMA_KECAMATAN, NAMA_DISTRIK, NAMA_PROVINSI, NAMA_AREA, REGION, POINT_PEROLEHAN, POINT_MAX, APPROVAL_SALES, KESIMPULAN, ID_GSM, NAMA_GSM, ID_SSM, NAMA_SSM, ID_SM, NAMA_SM, ID_KUNJUNGAN_SALES
				
				FROM REPORT_HASIL_PENILAIAN_SALES
				WHERE NO_VISIT = '$no_visit'
			";
			return $this->db->query($sql)->row();
		}
		
		public function Distinct_jenis_penilaian($no_visit){
			$sql = "
				SELECT 
					DISTINCT(CMPS.ID_JENIS_PENILAIAN),
					CMJP.NM_JENIS_PENILAIAN,
					CMHP.NO_VISIT
				FROM CRMNEW_M_HASIL_PENILAIAN CMHP
					LEFT JOIN CRMNEW_M_PENILAIAN_SALES CMPS
						ON CMHP.ID_PERTANYAAN = CMPS.ID_PERTANYAAN
					LEFT JOIN CRMNEW_M_JENIS_PENILAIAN CMJP
						ON CMPS.ID_JENIS_PENILAIAN = CMJP.ID_JENIS_PENILAIAN
				WHERE CMHP.NO_VISIT = '$no_visit'
				ORDER BY CMJP.NM_JENIS_PENILAIAN
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function List_penilaian($no_visit, $id_jp){
			$sql = "
				SELECT 
					CMPS.ID_JENIS_PENILAIAN,
					CMJP.NM_JENIS_PENILAIAN,
					CMHP.ID_PERTANYAAN,
					CMPS.NM_PERTANYAAN,
					CMHP.ID_JAWABAN,
					CMOJ.OPSIONAL,
					CMOJ.POINT,
					(select max(ss.point) from CRMNEW_M_OPSIONAL_JAWABAN ss where ss.delete_mark = 0 and ss.id_pertanyaan = CMHP.id_pertanyaan) as POINT_MAX
				FROM CRMNEW_M_HASIL_PENILAIAN CMHP
					LEFT JOIN CRMNEW_M_PENILAIAN_SALES CMPS
						ON CMHP.ID_PERTANYAAN = CMPS.ID_PERTANYAAN
					LEFT JOIN CRMNEW_M_JENIS_PENILAIAN CMJP
						ON CMPS.ID_JENIS_PENILAIAN = CMJP.ID_JENIS_PENILAIAN
					LEFT JOIN CRMNEW_M_OPSIONAL_JAWABAN CMOJ
						ON CMHP.ID_JAWABAN = CMOJ.ID_JAWABAN
				WHERE CMHP.NO_VISIT = '$no_visit' AND CMPS.ID_JENIS_PENILAIAN = '$id_jp'
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function List_foto($no_visit){
			$sql = " 
				SELECT NO_VISIT, PATH_FOTO
				FROM CRMNEW_FOTO_VISITING_TSO
					WHERE 
					NO_VISIT = '$no_visit' AND DELETE_MARK = 0
			";
			return $this->db->query($sql)->result_array();
		}

}

?>
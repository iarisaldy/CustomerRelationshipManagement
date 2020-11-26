<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Model_survey_sales extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	public function list_jenis_penilaian($id_jp = null){
		$sql = "
			SELECT 
				aa.ID_JENIS_PENILAIAN AS ID_JP, 
				aa.NM_JENIS_PENILAIAN AS JP,
				(SELECT count(*) FROM CRMNEW_M_PENILAIAN_SALES SS where ss.ID_JENIS_PENILAIAN = aa.ID_JENIS_PENILAIAN and ss.DELETE_MARK = 0) AS JML	
			FROM CRMNEW_M_JENIS_PENILAIAN aa
			WHERE 
				aa.DELETE_MARK = 0
		";
		if($id_jp != null){
			$sql .= " AND aa.ID_JENIS_PENILAIAN = '$id_jp' ";
		}
		$sql .= " ORDER BY aa.NM_JENIS_PENILAIAN";
		
		return $this->db->query($sql)->result(); 
	}
	
	// -------------------------------------------------------- > fungsi untuk JP = Jenis Penilaian
		public function simpanJP($id_jp, $jp){
			$hasil = false;
			if($id_jp != '0000'){
				$sqlUp = "
					UPDATE CRMNEW_M_JENIS_PENILAIAN
					SET 
						ID_JENIS_PENILAIAN = '$id_jp', 
						NM_JENIS_PENILAIAN = '$jp'
					WHERE ID_JENIS_PENILAIAN = '$id_jp'
				";
				$this->db->query($sqlUp);
				$hasil = true;
			} else { 
				$sqlIn = "
					INSERT INTO CRMNEW_M_JENIS_PENILAIAN (NM_JENIS_PENILAIAN, DELETE_MARK, CREATE_BY, CREATE_DATE)
					VALUES 
					('$jp', '0', '1009', SYSDATE)
				";
				$this->db->query($sqlIn);
				$hasil = true;
			}
			return $hasil;
		}
		
		public function hapusJP($id_jp){
			$sqlDel = "
				UPDATE CRMNEW_M_JENIS_PENILAIAN
				SET 
					DELETE_MARK = 1
				WHERE ID_JENIS_PENILAIAN = '$id_jp'
			";
			$hasil = $this->db->query($sqlDel);
			return $hasil;
		}
		
	// ---> Akhir JP
	
	public function List_pertanyaan($id_jp){
		$sql = "
			SELECT 
				CMPS.ID_PERTANYAAN,
				CMPS.NM_PERTANYAAN,
				(SELECT count(*) FROM CRMNEW_M_OPSIONAL_JAWABAN SS where CMPS.ID_PERTANYAAN = SS.ID_PERTANYAAN and ss.DELETE_MARK = 0) AS JML
			FROM CRMNEW_M_PENILAIAN_SALES CMPS
			WHERE CMPS.DELETE_MARK = 0 AND CMPS.ID_JENIS_PENILAIAN = '$id_jp'
			ORDER BY CMPS.ID_PERTANYAAN
		";
		return $this->db->query($sql)->result_array(); 
	}
	
	// -------------------------------------------------------- > fungsi untuk P = Pertanyaan
		public function simpanP($id_p, $p, $id_jp){
			$hasil = false;
			if($id_p != '0000'){
				$sqlUp = "
					UPDATE CRMNEW_M_PENILAIAN_SALES
					SET  
						NM_PERTANYAAN = '$p', 
						ID_JENIS_PENILAIAN = '$id_jp', 
						UPDATE_BY = '1009', 
						UPDATE_DATE = SYSDATE
					WHERE ID_PERTANYAAN = '$id_p'
				";
				$this->db->query($sqlUp);
				$hasil = true;
			} else { 
				$sqlIn = "
					INSERT INTO CRMNEW_M_PENILAIAN_SALES (NM_PERTANYAAN, ID_JENIS_PENILAIAN, CREATE_BY, CREATE_DATE, DELETE_MARK)
					VALUES 
					('$p', '$id_jp', '1009', SYSDATE, 0)
				";
				$this->db->query($sqlIn); 
				$hasil = true;
			}
			return $hasil;
		}
		
		public function hapusP($id_p){
			$sqlDel = "
				UPDATE CRMNEW_M_PENILAIAN_SALES
				SET 
					DELETE_MARK = 1
				WHERE ID_PERTANYAAN = '$id_p'
			";
			$hasil = $this->db->query($sqlDel);
			return $hasil;
		}
	// ---> Akhir Pertanyaan
	
	public function List_jawaban($id_pertanyaan){
		$sql = "
			SELECT  
				CMOJ.ID_JAWABAN, 
				CMOJ.OPSIONAL AS OPSI,
				CMOJ.POINT,
				CMPS.ID_PERTANYAAN,
				CMPS.NM_PERTANYAAN as PERTANYAAN	
			FROM CRMNEW_M_OPSIONAL_JAWABAN CMOJ
				LEFT JOIN CRMNEW_M_PENILAIAN_SALES CMPS
				ON CMPS.ID_PERTANYAAN = CMOJ.ID_PERTANYAAN AND CMPS.DELETE_MARK = 0
			WHERE CMOJ.ID_PERTANYAAN = '$id_pertanyaan' AND CMOJ.DELETE_MARK = 0
            ORDER BY CMOJ.POINT DESC
		";
		return $this->db->query($sql)->result_array();
	}
	
	// -------------------------------------------------------- > fungsi untuk OJ = Opsional Jawaban
		public function simpanOJ($id_oj, $id_pertanyaan, $opsi, $point){
			$hasil = false;
			if($id_oj != '0000'){
				$sqlUp = "
					UPDATE CRMNEW_M_OPSIONAL_JAWABAN
					SET  
						OPSIONAL = '$opsi',
						POINT = '$point'
					WHERE ID_JAWABAN = '$id_oj'
				";
				$this->db->query($sqlUp);
				$hasil = true;
			} else { 
				$sqlIn = "
					INSERT INTO CRMNEW_M_OPSIONAL_JAWABAN (OPSIONAL, POINT, ID_PERTANYAAN, DELETE_MARK)
					VALUES 
					('$opsi', '$point', '$id_pertanyaan', 0)
				";
				$this->db->query($sqlIn); 
				$hasil = true;
			}
			return $hasil;
		} 
		
		public function hapusOJ($id_oj){
			$sqlDel = "
				UPDATE CRMNEW_M_OPSIONAL_JAWABAN
				SET 
					DELETE_MARK = 1
				WHERE ID_JAWABAN = '$id_oj'
			";
			$hasil = $this->db->query($sqlDel);
			return $hasil;
		}
	// ---> Akhir OJ
	
}

?>
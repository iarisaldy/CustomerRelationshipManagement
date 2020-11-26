<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Model_template_quisioner extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	public function list_jenis_penilaian($idtempl = null, $id_jp = null){
		// $sql = "
		// 	SELECT 
		// 		aa.ID AS ID_JP, 
		// 		aa.NAMA_KATEGORY AS JP,
		// 		(SELECT count(*) FROM CRMNEW_DMC_PERTANYAAN SS where ss.ID = aa.ID and ss.DELETED_MARK = 0) AS JML	
		// 	FROM CRMNEW_DMC_KATEGORY aa
		// 	WHERE 
		// 		aa.DELETED_MARK = 0
		// ";
		// if($id_jp != null){
		// 	$sql .= " AND aa.ID = '$id_jp' ";
		// }
		// $sql .= " ORDER BY aa.NAMA_KATEGORY";
		
		// return $this->db->query($sql)->result(); 

		$this->db->select("A.*, B.NAMA AS NAMA_USER_INPUT, C.NAMA AS NAMA_USER_UPDATE, (SELECT count(*) FROM CRMNEW_DMC_PERTANYAAN SS where SS.FK_ID_KATEGORY = A.ID and SS.DELETED_MARK = 0) AS JML");
        $this->db->from('CRMNEW_DMC_KATEGORY A');
        $this->db->join("CRMNEW_USER B", "A.CREATED_BY = B.ID_USER", 'left');
        $this->db->join("CRMNEW_USER C", "A.UPDATED_BY = C.ID_USER", 'left');
        $this->db->where('A.DELETED_MARK', 0);
        if (!empty($idtempl)) {
        	# code...
        	$this->db->where('A.FK_ID_TEMPLATE', $idtempl);
        }
        if (!empty($id_jp)) {
        	# code...
        	$this->db->where('A.ID', $id_jp);
        }
        $this->db->order_by('A.ORDER_KATEGORY', 'ASC');
		return $this->db->get()->result_array();
	}
	
	// -------------------------------------------------------- > fungsi untuk Kategory Pertanyaan = Kategory Pertanyaan

	public function insert_kategory($data)
	{
		# code...
        $dtnow = date("Y-m-d H:i:s");     
        $this->db->set($data);
        $this->db->set("CREATED_AT", "to_date('".$dtnow."','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $query = $this->db->insert('CRMNEW_DMC_KATEGORY');
        return true;
	}

	public function update_kategory($data)
	{
		# code...
        $dtnow = date("Y-m-d H:i:s"); 
        $this->db->where("ID", $data['ID']);
        unset($data['ID']);
        $this->db->set($data);
        $this->db->set("UPDATED_AT", "to_date('".$dtnow."','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $query = $this->db->update('CRMNEW_DMC_KATEGORY');
        $rows = $this->db->affected_rows();
        if ($rows > 0) {
            return true;
        }else{
            return false;
        }
	}

		// public function simpanJP($id_jp, $jp, $post){
		// 	$hasil = false;
		// 	if($id_jp != '0000'){
		// 		$sqlUp = "
		// 			UPDATE CRMNEW_DMC_KATEGORY
		// 			SET 
		// 				ID = '$id_jp', 
		// 				NAMA_KATEGORY = '$jp'
		// 			WHERE ID = '$id_jp'
		// 		";
		// 		$this->db->query($sqlUp);
		// 		$hasil = true;
		// 	} else { 
		// 		$sqlIn = "
		// 			INSERT INTO CRMNEW_DMC_KATEGORY (NAMA_KATEGORY, DELETED_MARK, CREATED_BY, CREATED_AT)
		// 			VALUES 
		// 			('$jp', '0', '".$post['USER_ID']."', SYSDATE)
		// 		";
		// 		$this->db->query($sqlIn);
		// 		$hasil = true;
		// 	}
		// 	return $hasil;
		// }
		
		public function hapusJP($id_jp){
			$sqlDel = "
				UPDATE CRMNEW_DMC_KATEGORY
				SET 
					DELETED_MARK = 1
				WHERE ID = '$id_jp'
			";
			$hasil = $this->db->query($sqlDel);
			return $hasil;
		}
		
	// ---> Akhir JP
	
	public function List_pertanyaan($id_jp){
		// $sql = "
		// 	SELECT 
		// 		CMPS.ID_PERTANYAAN,
		// 		CMPS.NM_PERTANYAAN,
		// 		(SELECT count(*) FROM CRMNEW_DMC_OPSIJAWAB SS where CMPS.ID_PERTANYAAN = SS.ID_PERTANYAAN and ss.DELETED_MARK = 0) AS JML
		// 	FROM CRMNEW_DMC_PERTANYAAN CMPS
		// 	WHERE CMPS.DELETED_MARK = 0 AND CMPS.ID_JENIS_PENILAIAN = '$id_jp'
		// 	ORDER BY CMPS.ID_PERTANYAAN
		// ";
		// return $this->db->query($sql)->result_array(); 


		$this->db->select("CMPS.*, (SELECT count(*) FROM CRMNEW_DMC_OPSIJAWAB SS where CMPS.ID = SS.FK_ID_PERTANYAAN and SS.DELETED_MARK = 0) AS JML");
        $this->db->from('CRMNEW_DMC_PERTANYAAN CMPS');
        $this->db->join("CRMNEW_USER B", "CMPS.CREATED_BY = B.ID_USER", 'left');
        $this->db->join("CRMNEW_USER C", "CMPS.UPDATED_BY = C.ID_USER", 'left');
        $this->db->where('CMPS.DELETED_MARK', 0);
        $this->db->where('CMPS.FK_ID_KATEGORY', $id_jp);
        // $this->db->order_by('A.ORDER_KATEGORY', 'ASC');
		return $this->db->get()->result_array();
	}
	
	// -------------------------------------------------------- > fungsi untuk P = Pertanyaan
		public function simpanP($id_p, $p, $id_jp){
			$hasil = false;
			if($id_p != '0000'){
				$sqlUp = "
					UPDATE CRMNEW_DMC_PERTANYAAN
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
					INSERT INTO CRMNEW_DMC_PERTANYAAN (NM_PERTANYAAN, ID_JENIS_PENILAIAN, CREATED_BY, CREATED_AT, DELETED_MARK)
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
				UPDATE CRMNEW_DMC_PERTANYAAN
				SET 
					DELETED_MARK = 1
				WHERE ID_PERTANYAAN = '$id_p'
			";
			$hasil = $this->db->query($sqlDel);
			return $hasil;
		}
	// ---> Akhir Pertanyaan
	
	public function List_jawaban($id_pertanyaan){
		// $sql = "
		// 	SELECT  
		// 		CMOJ.ID_JAWABAN, 
		// 		CMOJ.OPSIONAL AS OPSI,
		// 		CMOJ.POINT,
		// 		CMPS.ID_PERTANYAAN,
		// 		CMPS.NM_PERTANYAAN as PERTANYAAN	
		// 	FROM CRMNEW_DMC_OPSIJAWAB CMOJ
		// 		LEFT JOIN CRMNEW_DMC_PERTANYAAN CMPS
		// 		ON CMPS.ID_PERTANYAAN = CMOJ.ID_PERTANYAAN AND CMPS.DELETED_MARK = 0
		// 	WHERE CMOJ.ID_PERTANYAAN = '$id_pertanyaan' AND CMOJ.DELETED_MARK = 0
  //           ORDER BY CMOJ.POINT DESC
		// ";
		// return $this->db->query($sql)->result_array();

		$this->db->select("CMOJ.ID_JAWABAN, CMOJ.OPSIONAL AS OPSI, CMOJ.POINT, CMPS.ID_PERTANYAAN, CMPS.NM_PERTANYAAN as PERTANYAAN");
        $this->db->from('CRMNEW_DMC_OPSIJAWAB CMOJ');
        $this->db->join("CRMNEW_DMC_PERTANYAAN CMPS", "CMPS.ID = CMOJ.FK_ID_PERTANYAAN AND CMPS.DELETED_MARK = 0", 'left');
        $this->db->join("CRMNEW_USER B", "CMOJ.CREATED_BY = B.ID_USER", 'left');
        $this->db->join("CRMNEW_USER C", "CMOJ.UPDATED_BY = C.ID_USER", 'left');
        $this->db->where('CMOJ.DELETED_MARK', 0);
        $this->db->where('CMOJ.ID_PERTANYAAN', $id_pertanyaan);
        $this->db->order_by('CMOJ.POINT', 'DESC');
		return $this->db->get()->result_array();
	}
	
	// -------------------------------------------------------- > fungsi untuk OJ = Opsional Jawaban
		public function simpanOJ($id_oj, $id_pertanyaan, $opsi, $point){
			$hasil = false;
			if($id_oj != '0000'){
				$sqlUp = "
					UPDATE CRMNEW_DMC_OPSIJAWAB
					SET  
						OPSIONAL = '$opsi',
						POINT = '$point'
					WHERE ID_JAWABAN = '$id_oj'
				";
				$this->db->query($sqlUp);
				$hasil = true;
			} else { 
				$sqlIn = "
					INSERT INTO CRMNEW_DMC_OPSIJAWAB (OPSIONAL, POINT, ID_PERTANYAAN, DELETED_MARK)
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
				UPDATE CRMNEW_DMC_OPSIJAWAB
				SET 
					DELETED_MARK = 1
				WHERE ID_JAWABAN = '$id_oj'
			";
			$hasil = $this->db->query($sqlDel);
			return $hasil;
		}
	// ---> Akhir OJ
	
}

?>
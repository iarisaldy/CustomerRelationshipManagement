<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Dokument_crm_model extends CI_Model {

		public function __construct()
		{
			parent::__construct();
			$this->db = $this->load->database('default', TRUE);
			$this->db2 = $this->load->database('Point', TRUE);
		}
		
		
		public function get_tampilan_foto_kunjungan($id_user, $id_kunjungan_customer){
			
			$sql ="
				SELECT
				FS.ID_FOTO_KUNJUNGAN,
				FS.FOTO_SURVEY,
				FS.DELETE_MARK,
				FS.ID_KUNJUNGAN_CUSTOMER,
				KC.ID_USER
				FROM CRMNEW_FOTO_SURVEY FS
				LEFT JOIN CRMNEW_KUNJUNGAN_CUSTOMER KC ON FS.ID_KUNJUNGAN_CUSTOMER=KC.ID_KUNJUNGAN_CUSTOMER
				WHERE FS.DELETE_MARK=0
				AND KC.ID_USER='$id_user'
				AND FS.ID_KUNJUNGAN_CUSTOMER IN ($id_kunjungan_customer)
			";
			
			return $this->db->query($sql)->result_array();
			
		}
	
		public function get_data_foto_kunjungan($id_user, $id_kc, $tahun, $bulan){
			
			$sql ="
				SELECT
					FS.ID_FOTO_KUNJUNGAN,
					FS.ID_KUNJUNGAN_CUSTOMER,
					FS.FOTO_SURVEY,
					FS.DELETE_MARK,
					KC.ID_USER
				FROM CRMNEW_FOTO_SURVEY FS
				LEFT JOIN CRMNEW_KUNJUNGAN_CUSTOMER KC ON FS.ID_KUNJUNGAN_CUSTOMER=KC.ID_KUNJUNGAN_CUSTOMER
				WHERE FS.DELETE_MARK=0
				AND KC.ID_USER IS NOT NULL
				AND KC.ID_USER='$id_user'
				AND TO_CHAR(FS.CREATE_DATE, 'YYYY')='$tahun'
                AND TO_CHAR(FS.CREATE_DATE, 'MM')='$bulan'
				
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		public function Tambah_data_foto_kunjungan($data, $id_user, $id_kc, $target_file){
			
			$NSQL = "
				SELECT
				FOTO_SURVEY
				FROM CRMNEW_FOTO_SURVEY
				WHERE DELETE_MARK=0
				AND FOTO_SURVEY='$target_file'
			";
			
			$CEK = $this->db->query($NSQL)->result_array();
			
			
			if(count($CEK)>=1){
				$hasil = true;
			}
			else {
				$hasil = $this->db->insert_batch('CRMNEW_FOTO_SURVEY', $data);
			}
			
			
			if($hasil){
				// $baris = count($data);
				
				$sql ="
					SELECT 
					*
					FROM (					
							SELECT
								FS.ID_FOTO_KUNJUNGAN,
								FS.ID_KUNJUNGAN_CUSTOMER,
								FS.FOTO_SURVEY,
								FS.DELETE_MARK,
								KC.ID_USER
							FROM CRMNEW_FOTO_SURVEY FS
							LEFT JOIN CRMNEW_KUNJUNGAN_CUSTOMER KC ON FS.ID_KUNJUNGAN_CUSTOMER=KC.ID_KUNJUNGAN_CUSTOMER
							WHERE FS.DELETE_MARK=0
							AND FS.ID_KUNJUNGAN_CUSTOMER='$id_kc'
							AND KC.ID_USER IS NOT NULL
							AND KC.ID_USER='$id_user'
							ORDER BY FS.ID_FOTO_KUNJUNGAN DESC
						)
					WHERE ROWNUM=1
					
				";
				
				$response = $this->db->query($sql)->result_array();
				return $response;
			}
			else {
				return null;
			}
			
		}
		public function Tampilan_foto_kunjungan($id_user, $id_kc){
			
			$sql ="
				SELECT
					FS.ID_FOTO_KUNJUNGAN,
					FS.ID_KUNJUNGAN_CUSTOMER,
					FS.FOTO_SURVEY,
					FS.DELETE_MARK,
					KC.ID_USER
				FROM CRMNEW_FOTO_SURVEY FS
				LEFT JOIN CRMNEW_KUNJUNGAN_CUSTOMER KC ON FS.ID_KUNJUNGAN_CUSTOMER=KC.ID_KUNJUNGAN_CUSTOMER
				WHERE FS.DELETE_MARK=0
				AND FS.ID_KUNJUNGAN_CUSTOMER='$id_kc'
				AND KC.ID_USER IS NOT NULL
				AND KC.ID_USER='$id_user'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		public function Update_delete_mark_KC($id_user, $id_kc){
			
			$sql ="
				UPDATE CRMNEW_FOTO_SURVEY
				SET 
					DELETE_MARK=1,
					UPDATE_BY='$id_user',
					UPDATE_DATE=SYSDATE
				WHERE ID_KUNJUNGAN_CUSTOMER='$id_kc'
			";
			
			return $this->db->query($sql);
		}
		
		public function Delete_foto($user, $in){
			
			$sql ="
				UPDATE CRMNEW_FOTO_SURVEY
				SET DELETE_MARK=1,
					UPDATE_BY='$user',
					UPDATE_DATE=SYSDATE
				WHERE ID_FOTO_KUNJUNGAN IN ($in)
			";
			
			return $this->db->query($sql);
		}
		
		public function get_foto_diserver($in){
			
			$sql ="
				SELECT 
					ID_FOTO_KUNJUNGAN,
					FOTO_SURVEY
				FROM CRMNEW_FOTO_SURVEY
				WHERE DELETE_MARK=0
				AND ID_FOTO_KUNJUNGAN IN($in)
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function get_foto_by_id($id_foto){
			
			$sql ="
				SELECT
					ID_FOTO_KUNJUNGAN,
					FOTO_SURVEY
				FROM CRMNEW_FOTO_SURVEY
				WHERE ID_FOTO_KUNJUNGAN='$id_foto'
			";
			
			$hasil = $this->db->query($sql)->result_array();
			// print_r($hasil);
			return $hasil[0]['FOTO_SURVEY'];
		}

    }
?>
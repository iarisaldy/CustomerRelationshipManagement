<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Sync_model extends CI_Model {
		
		public function Sync_image_log($id_user, $data_sync){
			$totData = count($data_sync);
			$setIn = 0;
			foreach($data_sync as $dt){
				//variabel
				$ID_KUNJUNGAN		= $dt['ID_KUNJUNGAN'];
				$ID_FOTO_KUNJUNGAN	= $dt['ID_FOTO_KUNJUNGAN'];
				$TYPE_SYNC			= $dt['TYPE_SYNC'];
				$SUCCESS			= $dt['SUCCESS'];
				$STATUS				= $dt['STATUS'];
				$MESSAGE			= $dt['MESSAGE'];
				$DESC_STATUS		= $dt['DESC_STATUS'];
				$CREATE_BY			= $id_user;
				$DATE_SYNC			= $dt['DATE_SYNC'];
				
				$sqlin = "
						INSERT INTO CRMNEW_SYNC_IMAGE_LOG (
							ID_KUNJUNGAN,
							ID_FOTO_KUNJUNGAN,
							TYPE_SYNC,
							SUCCESS,
							STATUS,
							MESSAGE,
							DESC_STATUS,
							CREATE_AT,
							CREATE_BY,
							DELETE_MARK,
							DATE_SYNC
						)
							VALUES 
						(
							'$ID_KUNJUNGAN', 
							'$ID_FOTO_KUNJUNGAN', 
							'$TYPE_SYNC',
							'$SUCCESS',
							'$STATUS',
							'$MESSAGE',
							'$DESC_STATUS', 
							SYSDATE, 
							'$id_user', 
							0,
							'$DATE_SYNC'
						)
					";
					
					$do_insert = $this->db->query($sqlin);
				
				// print_r($sqlin);
				// exit;
				
				if($do_insert){
					$setIn++; 
				}
			}
			
			return $setIn."-".$totData;
		}
		
		public function get_image_log_survey($id_user = null, $id_sync = null){
			$sql = " 
				SELECT 
					CKC.ID_KUNJUNGAN_CUSTOMER,
					TO_CHAR(CKC.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN,
					CC.KODE_CUSTOMER, 
					CC.NAMA_TOKO, 
					CU.NAMA AS NAMA_SALES, 
					SIL.DATE_SYNC, 
					SIL.ID_SYNC,
					SIL.ID_FOTO_KUNJUNGAN,
					SIL.TYPE_SYNC,
					SIL.STATUS, 
					SIL.MESSAGE, 
					SIL.DESC_STATUS 
				FROM CRMNEW_SYNC_IMAGE_LOG SIL 
					JOIN CRMNEW_KUNJUNGAN_CUSTOMER CKC ON CKC.ID_KUNJUNGAN_CUSTOMER = SIL.ID_KUNJUNGAN
					JOIN CRMNEW_CUSTOMER CC ON CC.KODE_CUSTOMER = CKC.ID_TOKO 
					JOIN CRMNEW_USER CU ON CU.ID_USER = CKC.ID_USER
				WHERE SIL.DELETE_MARK = 0 
			";
			
			if($id_user != null){
				$sql .= " AND SIL.CREATE_BY = $id_user "; 
			}
			
			if($id_sync != null){
				$sql .= " AND SIL.ID_SYNC = $id_sync "; 
			}
			
			$sql .= " ORDER BY SIL.DATE_SYNC DESC";
			
			$list_data = $this->db->query($sql);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return false;
            }
		}
		
		
	}
	
?>
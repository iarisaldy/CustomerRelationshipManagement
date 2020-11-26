<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_tracking_sync extends CI_Model {

		public function get(){
			$sql = "
				SELECT * FROM CRMNEW_TRACKING_SYNC
				";
			 
			return $this->db->query($sql)->result();
		}
		
		public function insert($id_user, $data){
			$response = array();
			
			foreach($data as $p){
				
				$ID_DATA	= $p['ID_DATA'];
				$TYPE_DATA	= $p['TYPE_DATA'];
				$ID_PARENT	= isset($p['ID_PARENT']) ? $p['ID_PARENT'] : NULL;
				$PARENT		= isset($p['PARENT']) ? $p['PARENT'] : NULL;
				$TYPE_SYNC	= isset($p['TYPE_SYNC']) ? $p['TYPE_SYNC'] : NULL;
				$ID_USER	= $id_user;
				$STATUS		= isset($p['STATUS']) ? $p['STATUS'] : NULL;
				$MESSAGE	= isset($p['MESSAGE']) ? $p['MESSAGE'] : NULL;
				$ERROR		= isset($p['ERROR']) ? $p['ERROR'] : NULL;
				$DEVICE		= isset($p['DEVICE']) ? $p['DEVICE'] : NULL;
				$DATE_SYNC	= isset($p['DATE_SYNC']) ? $p['DATE_SYNC'] : NULL;
				$SYNC		= isset($p['SYNC']) ? $p['SYNC'] : NULL;
				$LOCAL		= isset($p['LOCAL']) ? $p['LOCAL'] : NULL;
				$IS_DELETE	= isset($p['IS_DELETE']) ? $p['IS_DELETE'] : NULL;
				$PROGRESS	= isset($p['PROGRESS']) ? $p['PROGRESS'] : NULL;
				$ON_UPDATE	= isset($p['ON_UPDATE']) ? $p['ON_UPDATE'] : NULL;
				$ETC		= isset($p['ETC']) ? $p['ETC'] : NULL;
				
				$sqlIn = "
					INSERT INTO CRMNEW_TRACKING_SYNC
					(ID, 
					ID_DATA, 
					TYPE_DATA, 
					ID_PARENT, 
					PARENT, 
					TYPE_SYNC, 
					ID_USER, 
					STATUS, 
					MESSAGE, 
					ERROR, 
					DEVICE, 
					CREATE_AT, 
					SYNC, 
					LOCAL, 
					IS_DELETE, 
					PROGRESS, 
					ON_UPDATE, 
					DATE_SYNC,
					ETC)
					VALUES
					(NULL,
					'$ID_DATA', 
					'$TYPE_DATA', 
					'$ID_PARENT', 
					'$PARENT', 
					'$TYPE_SYNC', 
					'$ID_USER', 
					'$STATUS', 
					'$MESSAGE', 
					'$ERROR', 
					'$DEVICE', 
					SYSDATE, 
					'$SYNC', 
					'$LOCAL', 
					'$IS_DELETE', 
					'$PROGRESS', 
					'$ON_UPDATE', 
					'$DATE_SYNC',
					'$ETC')
				";
				$setIn = $this->db->query($sqlIn);
					
				
				array_push($response, $setIn);
				
				
			}
			return $response;
		}
		
	}
	
?>
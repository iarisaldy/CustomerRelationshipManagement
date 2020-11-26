<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Android_model extends CI_Model {
		
		
		public function get_data_versi_android($version_code){
			
			$sql = "
				SELECT
				NO_VERSI,
				NM_VERSI,
				LINK,
				DISKRIPSI,
				TIPE_UPDATE,
				VERSION_CODE
				FROM CRMNEW_ANDROID_VERSION
				WHERE VERSION_CODE > '$version_code'
			";
			
			return $this->db->query($sql)->result_array();
			
		}

    }
?>
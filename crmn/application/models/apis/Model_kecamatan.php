<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}
    
    
    class Model_kecamatan extends CI_Model {
				
		public function Get_data_kecamatan($kd_distrik){
			
			$sql ="
				SELECT 
				KD_KECAMATAN,
				NAMA_KECAMATAN,
				SUBSTR(KD_KECAMATAN, 0, 6) AS KD_DISTRIK
				FROM 
				CRMNEW_M_KECAMATAN
			";
			
			if($kd_distrik!=null){
				$sql .= " WHERE SUBSTR(KD_KECAMATAN, 0, 6) ='$kd_distrik' ";	
			}
			
			return $this->db->query($sql)->result_array();
			
		}
    }
?>
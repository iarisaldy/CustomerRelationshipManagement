<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Produk_model extends CI_Model {

        public function get_data_produk($id_group, $smi_group){
			
			$sql ="
				SELECT
				PS.ID_PRODUK,
				PS.NAMA_PRODUK,
				PS.GROUP_ID, 
				PS.KATEGORI,
				JPG.JENIS_PRODUK,
				JPG.SMI_GROUP
				FROM CRMNEW_PRODUK_SURVEY  PS
				LEFT JOIN CRMNEW_JENIS_PRODUK_GROUP JPG ON PS.GROUP_ID=JPG.GROUP_ID
				WHERE PS.DELETE_MARK=0

			";
			
			if($id_group!=null){
				$sql .= " AND PS.GROUP_ID='$id_group' ";
			}
			
			if($smi_group!=null){
				$sql .= " AND JPG.SMI_GROUP='$smi_group' ";
			}
			
			return $this->db->query($sql)->result_array();
			
		}
		

    }
?>
<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_radius_lock extends CI_Model {
        
        public function listRadiusDistrictLock($id_district){
			
            $sql = "
                SELECT 
                    CRD.ID_RADIUS_DISTRIK,
                    CRD.ID_DISTRIK,
                    CMD.ID_PROVINSI,
                    CMD.NAMA_DISTRIK,
                    CMP.NAMA_PROVINSI,
                    CMP.ID_REGION as REGION,
                    CRD.DISTRIK_LOCK
                FROM CRMNEW_RADIUS_DISTRIK CRD
                    JOIN CRMNEW_M_DISTRIK CMD ON CMD.ID_DISTRIK = CRD.ID_DISTRIK
                    JOIN CRMNEW_M_PROVINSI CMP ON CMD.ID_PROVINSI = CMP.ID_PROVINSI
                WHERE CRD.DELETE_MARK != 1
            ";
            
            if($id_district != null){
				$arrId = explode(',', $id_district);
				$arr = implode(',', array_map('intval', $arrId));
                $sql .= " AND CRD.ID_DISTRIK in ($arr)";
            }
            
            $list_data = $this->db->query($sql);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return false;
            }
            
        }

    }
?>
<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_master_reason extends CI_Model {

        public function listMasterReason(){
            $id_mr = null;
            if(isset($_POST['id_mr'])){
                $id_mr = $_POST['id_mr'];
            }
            
            $sql = "
                SELECT 
                    *
                FROM CRMNEW_MASTER_REASON
                WHERE delete_mark = 0
            ";
            
            if($id_mr != null){
                $sql .= " AND ID_MR = '$id_mr'";
            }
            
            $list_data = $this->db->query($sql);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return false;
            }
        }
		
		public function listMasterReasonDetail(){
            $no_detail = null;
            if(isset($_POST['no_detail'])){
                $no_detail = $_POST['no_detail'];
            }
			
			$id_mr = null;
            if(isset($_POST['id_mr'])){
                $id_mr = $_POST['id_mr'];
            }
            
            $sql = "
                SELECT 
                    MRD.NO_DETAIL,
					MRD.NAMA_DETAIL,
					MR.ID_MR,
					MR.NM_MASTER_REASON
                FROM CRMNEW_MR_DETAIL MRD
					JOIN CRMNEW_MASTER_REASON MR ON MRD.ID_MR = MR.ID_MR
                WHERE MRD.delete_mark = 0
            ";
            
            if($no_detail != null){
                $sql .= " AND MRD.NO_DETAIL = '$no_detail'";
            }
			
			if($id_mr != null){
                $sql .= " AND MRD.ID_MR = '$id_mr'";
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
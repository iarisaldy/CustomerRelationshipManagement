<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Mapping_user_tso_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function Jenis_user($id_jenis_user=null){
		$sql ="
			SELECT
			ID_JENIS_USER,
			JENIS_USER
			FROM CRMNEW_JENIS_USER
			WHERE DELETED_MARK='0'
			AND ID_JENIS_USER IN (1009, 1010, 1011, 1012, 1013, 1015, 1016)
			ORDER BY ID_JENIS_USER
		";
		
		return $this->db->query($sql)->result_array();
	}
	
	public function Get_data_user($role=null, $user=null){
		$sql ="
			SELECT
			CU.ID_USER,
			CU.NAMA,
			CU.ID_JENIS_USER,
			JU.JENIS_USER,
            CU.ID_REGION,
            CU.EMAIL,
            CU.USERNAME,
            CU.PASSWORD
			FROM CRMNEW_USER CU
			LEFT JOIN CRMNEW_JENIS_USER JU ON CU.ID_JENIS_USER=JU.ID_JENIS_USER
			WHERE CU.DELETED_MARK='0'
			AND CU.FLAG='SBI'
		";
		if($role!=null){
			$sql .= " AND CU.ID_JENIS_USER='$role' ";
		}
		if($user!=null){
			$sql .= " AND CU.ID_USER='$user' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function User_distributor($id_user=null){
		$sql ="
			SELECT
			UD.ID_USER_DISTRIBUTOR,
			UD.ID_USER,
			UD.KODE_DISTRIBUTOR,
			D.NAMA_DISTRIBUTOR
			FROM CRMNEW_USER_DISTRIBUTOR UD
			LEFT JOIN CRMNEW_DISTRIBUTOR D ON UD.KODE_DISTRIBUTOR=D.KODE_DISTRIBUTOR
			WHERE UD.DELETE_MARK='0'
		";
		
		if($id_user!=null){
			$sql .= " AND UD.ID_USER='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
	
	public function User_distributor_TSO($id_user=null){
		$sql ="
			SELECT 
			UD.ID_USER_DISTRIBUTOR,
			UD.ID_USER,
			UD.KODE_DISTRIBUTOR,
			D.NAMA_DISTRIBUTOR
			FROM CRMNEW_USER_DISTRIBUTOR UD
			LEFT JOIN CRMNEW_DISTRIBUTOR D ON UD.KODE_DISTRIBUTOR=D.KODE_DISTRIBUTOR
			WHERE UD.DELETE_MARK='0'
		";
		
		if($id_user!=null){
			$sql .= " AND UD.ID_USER='$id_user' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function listDistributor($id_user=null){
        $sql ="
            SELECT
            KODE_DISTRIBUTOR,
            NAMA_DISTRIBUTOR
            FROM CRMNEW_DISTRIBUTOR
            WHERE DELETE_MARK='0'
            AND FLAG='SBI'

        ";
        
        if($id_user!=null){
            $sql .= " AND KODE_DISTRIBUTOR NOT IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE ID_USER='$id_user' AND DELETE_MARK='0') ";
        }
        
        return $this->db->query($sql)->result();
    }
    public function addUserDist($data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('CREATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->insert('CRMNEW_USER_DISTRIBUTOR', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }
    public function updateUserDist($idUserDist, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->where("ID_USER_DISTRIBUTOR", $idUserDist)->update('CRMNEW_USER_DISTRIBUTOR', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function User_Area($id_user=null){
		$sql ="
			SELECT
			UA.ID_USER_AREA,
			UA.ID_USER,
			MA.KD_AREA AS ID_AREA,
			MA.NAMA_AREA
			FROM CRMNEW_USER_AREA UA
			LEFT JOIN CRMNEW_M_AREA MA ON UA.ID_AREA=MA.ID_AREA
			WHERE UA.DELETE_MARK='0'		
		";
		
		if($id_user!=null){
			$sql .= " AND UA.ID_USER='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
    public function listArea($idProvinsi=null, $id_user=null){
        $sql ="
            SELECT
            ID_AREA,
            KD_AREA,
            NAMA_AREA
            FROM CRMNEW_M_AREA
             
        ";
        
        if($id_user!=null){
            $sql .= " WHERE ID_AREA NOT IN (SELECT ID_AREA FROM CRMNEW_USER_AREA WHERE ID_USER='$id_user' AND DELETE_MARK = '0') ";
        }
        $sql .= " ORDER BY ID_AREA";
        return $this->db->query($sql)->result();
    }


	public function User_Provinsi($id_user=null){
		$sql ="
			SELECT
			UP.ID_USER_PROVINSI,
			UP.ID_USER,
			UP.ID_PROVINSI,
			P.NAMA_PROVINSI
			FROM CRMNEW_USER_PROVINSI UP
			LEFT JOIN CRMNEW_M_PROVINSI P ON UP.ID_PROVINSI=P.ID_PROVINSI
			WHERE UP.DELETE_MARK='0' 			
		";
		
		if($id_user!=null){
			$sql .= " AND UP.ID_USER='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
	
	public function Region_tso($id_user){
        $sql ="
            SELECT DISTINCT
			NEW_REGION
			FROM M_SALES_DISTRIBUTOR
			WHERE ID_TSO = '$id_user'
			AND NEW_REGION IS NOT NULL
        ";
        
        return $this->db->query($sql)->result();
    }
	
	public function Region_asm($id_user){
        $sql ="
            SELECT DISTINCT
			NEW_REGION
			FROM M_SALES_DISTRIBUTOR
			WHERE ID_ASM = '$id_user'
			AND NEW_REGION IS NOT NULL
        ";
        
        return $this->db->query($sql)->result();
    }
	
	public function Region_rsm($id_user){
        $sql ="
            SELECT DISTINCT
			NEW_REGION
			FROM M_SALES_DISTRIBUTOR
			WHERE ID_RSM = '$id_user'
			AND NEW_REGION IS NOT NULL
        ";
        
        return $this->db->query($sql)->result();
    }
	
	public function Region_gsm(){
        $sql ="
            SELECT DISTINCT NEW_REGION
			FROM CRMNEW_M_PROVINSI
			WHERE ID_REGION IS NOT NULL

        ";
        
        return $this->db->query($sql)->result();
    }
	
	
    public function listProvinsi($idRegion = null, $id_user=null){
        $sql ="
            SELECT
            ID_PROVINSI,
            NAMA_PROVINSI
            FROM CRMNEW_M_PROVINSI
			WHERE NAMA_PROVINSI IS NOT NULL
        ";
		
		if($idRegion == 0){
            $sql .= " AND NEW_REGION IN ('$idRegion')";
        }
        
        if($id_user!=null){
            $sql .= " AND ID_PROVINSI NOT IN (SELECT ID_PROVINSI FROM CRMNEW_USER_PROVINSI WHERE ID_USER='$id_user' AND DELETE_MARK = '0') ";
        }
        
        return $this->db->query($sql)->result();
    }

	public function User_SALES($id_user=null){
		$sql ="
			SELECT
            US.NO_USER_TSO,
			US.ID_USER,
			US.ID_TSO,
			U.USERNAME
			FROM CRMNEW_USER_TSO US
			LEFT JOIN CRMNEW_USER U ON US.ID_USER=U.ID_USER
			WHERE US.DELETE_MARK='0'			
		";
		
		if($id_user!=null){
			$sql .= " AND US.ID_TSO='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
	
    public function listSALES($id_user,$id_dis){
        $sql ="
			SELECT 
				ID_USER,
				USERNAME
			FROM 
				M_SALES_DISTRIBUTOR
			WHERE KODE_DISTRIBUTOR IN ($id_dis)
			AND ID_USER NOT IN (SELECT ID_USER FROM CRMNEW_USER_TSO WHERE DELETE_MARK='0')
			GROUP BY ID_USER,USERNAME           
        ";

        return $this->db->query($sql)->result();
    }
	
	public function User_TSO($id_user=null){
		$sql ="
			SELECT
			UT.NO_USER_ASM,
			UT.ID_USER,
			UT.ID_ASM,
			U.NAMA
			FROM CRMNEW_USER_ASM UT
			LEFT JOIN CRMNEW_USER U ON UT.ID_USER=U.ID_USER
			WHERE UT.DELETE_MARK='0'			
		";
		
		if($id_user!=null){
			$sql .= " AND UT.ID_ASM='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
	
    public function listTSO($id_user=null){
        $sql ="
            SELECT
            CU.ID_USER,
            CU.NAMA
            FROM CRMNEW_USER CU
            WHERE CU.DELETED_MARK='0'
            AND CU.ID_JENIS_USER='1012'
                       
        ";
        
        if($id_user!=null){
            $sql .= " AND CU.ID_USER NOT IN (SELECT ID_USER FROM CRMNEW_USER_ASM WHERE DELETE_MARK='0' ) ";
        }

        return $this->db->query($sql)->result();
    }
	
	public function User_ASM($id_user=null){
		$sql ="
			SELECT
            UA.NO_USER_RSM,
            UA.ID_USER,
            UA.ID_RSM,
            U.NAMA
            FROM CRMNEW_USER_RSM UA
            LEFT JOIN CRMNEW_USER U ON UA.ID_USER=U.ID_USER
            WHERE UA.DELETE_MARK='0'			
		";
		
		if($id_user!=null){
			$sql .= " AND UA.ID_RSM='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
	
    public function listASM($id_user=null){
        $sql ="
            SELECT
            CU.ID_USER,
            CU.NAMA
            FROM CRMNEW_USER CU
            WHERE CU.DELETED_MARK='0'
            AND CU.ID_JENIS_USER='1011'              
        ";
        
        if($id_user!=null){
            $sql .= " AND CU.ID_USER NOT IN (SELECT ID_USER FROM CRMNEW_USER_RSM WHERE DELETE_MARK='0') ";
        }

        return $this->db->query($sql)->result();
    }
	
	public function User_RSM($id_user=null){
		$sql ="
			SELECT
			UR.NO_MAPPING,
			UR.ID_USER,
			UR.ID_GSM,
			U.NAMA
			FROM CRMNEW_USER_GSM UR
			LEFT JOIN CRMNEW_USER U ON UR.ID_USER=U.ID_USER
			WHERE UR.DELETE_MARK='0'			
		";
		
		if($id_user!=null){
			$sql .= " AND UR.ID_GSM='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
	
	public function listRSM($id_user=null){
        $sql ="
            SELECT
            CU.ID_USER,
            CU.NAMA
            FROM CRMNEW_USER CU
            WHERE CU.DELETED_MARK='0'
            AND CU.ID_JENIS_USER='1010'              
        ";
        
        if($id_user!=null){
            $sql .= " AND CU.ID_USER NOT IN (SELECT ID_USER FROM CRMNEW_USER_GSM WHERE DELETE_MARK='0') ";
        }

        return $this->db->query($sql)->result();
    }
	
    public function User_GUDANG($id_user=null){
        $sql ="
            SELECT
            UG.NO_USER_GUDANG,
            UG.ID_USER,
            UG.ID_GUDANG_DISTRIBUTOR,
            GD.KD_GUDANG,
            GD.NM_GUDANG
            FROM CRMNEW_USER_GUDANG UG
            LEFT JOIN CRMNEW_GUDANG_DISTRIBUTOR GD ON UG.ID_GUDANG_DISTRIBUTOR=GD.NO_GD
            WHERE UG.DELETE_MARK='0'                   
        ";
        
        if($id_user!=null){
            $sql .= " AND UG.ID_USER='$id_user' ";
        }
        
        return $this->db->query($sql)->result();
    }
	
    public function listGUDANG($id_user=null){
        $sql ="
            SELECT
            GD.NO_GD,
            GD.KD_GUDANG,
            GD.NM_GUDANG
            FROM CRMNEW_GUDANG_DISTRIBUTOR GD
            WHERE GD.DELETE_MARK='0'
            AND GD.KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE ID_USER='$id_user' AND DELETE_MARK='0' )            
        ";
        
        if($id_user!=null){
            $sql .= " AND GD.NO_GD NOT IN (SELECT ID_GUDANG_DISTRIBUTOR FROM CRMNEW_USER_GUDANG WHERE DELETE_MARK='0' AND  ID_USER='$id_user' ) ";
        }

        return $this->db->query($sql)->result();
    }
	
	public function listRegion($idUser=null) {

		$sql ="
            SELECT
            U.ID_REGION,
            R.REGION_NAME
            FROM CRMNEW_USER U
            LEFT JOIN CRMNEW_REGION R ON U.ID_REGION=R.REGION_ID
            WHERE U.DELETED_MARK='0'
            AND U.ID_USER='$idUser'         
        ";

        return $this->db->query($sql)->result_array();
	}
	
	public function lastUserId(){
        $this->db->select("MAX(ID_USER) AS ID_USER");
        $this->db->from("CRMNEW_USER");
        return $this->db->get()->row();
    }
	

    public function changePassword($id, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $this->db->where("ID_USER", $id)->update("CRMNEW_USER", $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function listUser($param = null, $id = null){
        $idJenisUser = $this->session->userdata("id_jenis_user");
        if($idJenisUser == "1007"){
            $kodeDist = $this->session->userdata("kode_dist");
            $this->db->where("CRMNEW_USER.ID_JENIS_USER", "1003");
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR", $kodeDist);
        }

        if(isset($param)){
            if($param == "iduser"){
                if(isset($id)){
                    $this->db->where('CRMNEW_USER.ID_USER', $id);
                }
            } else if($param == "idrole"){
                if(isset($id) || $id != ""){
                    $this->db->where('CRMNEW_USER.ID_JENIS_USER', $id);
                }
            }
        }
        $this->db->select('CRMNEW_USER.ID_USER, CRMNEW_USER.ID_REGION, CRMNEW_USER.EMAIL, CRMNEW_USER.NAMA, CRMNEW_USER.USERNAME, CRMNEW_USER.PASSWORD, CRMNEW_JENIS_USER.JENIS_USER, CRMNEW_USER.ID_JENIS_USER');
        $this->db->from('CRMNEW_USER');
        $this->db->join('CRMNEW_JENIS_USER', 'CRMNEW_USER.ID_JENIS_USER = CRMNEW_JENIS_USER.ID_JENIS_USER');
        $this->db->join("CRMNEW_USER_DISTRIBUTOR", "CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER", "left");
        $this->db->order_by('CRMNEW_USER.ID_USER', 'DESC');
        $this->db->where('CRMNEW_USER.DELETED_MARK', 0);
        $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", 0);
        $user = $this->db->get();
        if($user->num_rows() > 0){
            return $user->result();
        } else {
            return false;
        }
    }

    public function userDist($idUser = null){
        if(isset($idUser)){
            $this->db->where("CRMNEW_USER.ID_USER", $idUser);
        }
        $this->db->select("CRMNEW_USER_DISTRIBUTOR.ID_USER_DISTRIBUTOR, CRMNEW_USER.ID_USER, CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR");
        $this->db->from("CRMNEW_USER");
        $this->db->join("CRMNEW_USER_DISTRIBUTOR", "CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER");
        $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
        $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", 0);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result();
        } else {
            return false;
        }
    }

    public function userProvinsi($idUser = null){
        if(isset($idUser)){
            $this->db->where("CRMNEW_USER_PROVINSI.ID_USER", $idUser);
        }

        $this->db->select("CRMNEW_USER_PROVINSI.ID_USER_PROVINSI, CRMNEW_USER_PROVINSI.ID_PROVINSI, CRMNEW_M_PROVINSI.NAMA_PROVINSI");
        $this->db->from("CRMNEW_USER_PROVINSI");
        $this->db->join("CRMNEW_M_PROVINSI", "CRMNEW_USER_PROVINSI.ID_PROVINSI = CRMNEW_M_PROVINSI.ID_PROVINSI");
        $this->db->where("CRMNEW_USER_PROVINSI.DELETE_MARK", 0);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result();
        } else {
            return false;
        }
    }

    public function userArea($idUser = null){
        if(isset($idUser)){
            $this->db->where("CRMNEW_USER_AREA.ID_USER", $idUser);
        }

        $this->db->select("CRMNEW_USER_AREA.ID_USER_AREA, CRMNEW_USER_AREA.ID_AREA, CRMNEW_M_AREA.NAMA_AREA");
        $this->db->from("CRMNEW_USER_AREA");
        $this->db->join("CRMNEW_M_AREA", "CRMNEW_USER_AREA.ID_AREA = CRMNEW_M_AREA.ID_AREA");
        $this->db->where("CRMNEW_USER_AREA.DELETE_MARK", 0);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result();
        } else {
            return false;
        }
    }

    public function userRetail($idUser = null){
        if(isset($idUser)){
            $this->db->where("CRMNEW_USER_TOKO.ID_USER", $idUser);
        }

        $this->db->select("CRMNEW_USER_TOKO.ID_USER, CRMNEW_CUSTOMER.ID_CUSTOMER, CRMNEW_CUSTOMER.NAMA_TOKO");
        $this->db->from("CRMNEW_USER_TOKO");
        $this->db->join("CRMNEW_CUSTOMER", "CRMNEW_USER_TOKO.ID_CUSTOMER = CRMNEW_CUSTOMER.ID_CUSTOMER");
        $this->db->where("CRMNEW_USER_TOKO.DELETE_MARK", "0");
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result();
        } else {
            return false;
        }
    }

    public function addNewUser($data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('CREATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->insert('CRMNEW_USER', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function updateUserRetail($idUser, $data){
        $addUser = $this->db->where("ID_USER", $idUser)->update('CRMNEW_USER_TOKO', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function addUserProv($data){
        $addUser = $this->db->insert_batch('CRMNEW_USER_PROVINSI', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function addUserArea($data){
        $addUser = $this->db->insert_batch('CRMNEW_USER_AREA', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }
	
    public function addUserTSO($data){
        $addUser = $this->db->insert_batch('CRMNEW_USER_TSO', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }
	
	public function addUserTSO_ASM($data){
        $addUser = $this->db->insert_batch('CRMNEW_USER_ASM', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }
	
    public function addUserASM($data){
        $addUser = $this->db->insert_batch('CRMNEW_USER_RSM', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }
	
    public function addUserRSM($data){
        $addUser = $this->db->insert_batch('CRMNEW_USER_GSM', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }
	
    public function addUserGUDANG($data){
        $addUser = $this->db->insert_batch('CRMNEW_USER_TSO', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function addUserRetail($data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('CREATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->insert('CRMNEW_USER_TOKO', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function updateUser($idUser, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);

        $this->db->where('CRMNEW_USER.ID_USER', $idUser);
        $this->db->update('CRMNEW_USER', $data);

        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function updateUserProv($idUserProv, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->where("ID_USER_PROVINSI", $idUserProv)->update('CRMNEW_USER_PROVINSI', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function updateUserArea($idUserArea, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->where("ID_USER_AREA", $idUserArea)->update('CRMNEW_USER_AREA', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }
    public function updateUserTSO($idUserTSO, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->where("NO_USER_TSO", $idUserTSO)->update('CRMNEW_USER_TSO', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }
	
	public function updateUserTSO_ASM($idUserTSO, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->where("NO_USER_ASM", $idUserTSO)->update('CRMNEW_USER_ASM', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }
	
    public function updateUserASM($idUserTSO, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->where("NO_USER_RSM", $idUserTSO)->update('CRMNEW_USER_RSM', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }
	
    public function updateUserRSM($idUserTSO, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->where("NO_MAPPING", $idUserTSO)->update('CRMNEW_USER_GSM', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }
	
    public function updateUserGUDANG($idUserTSO, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->where("NO_USER_TSO", $idUserTSO)->update('CRMNEW_USER_TSO', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }
}
?>
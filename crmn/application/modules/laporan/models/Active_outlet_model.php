<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Active_outlet_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data_filter()
	{	
		$sql ="";
		
		return $this->db->query($sql)->result_array();
	}
	public function User_distributor($id_user=null)
	{
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
	public function User_TSO($id_user=null){
		$sql ="
			SELECT
			UT.NO_USER_TSO,
			UT.ID_USER,
			UT.ID_TSO,
			U.NAMA
			FROM CRMNEW_USER_TSO UT
			LEFT JOIN CRMNEW_USER U ON UT.ID_TSO=U.ID_USER
			WHERE UT.DELETE_MARK='0'			
		";
		
		if($id_user!=null){
			$sql .= " AND UT.ID_USER='$id_user' ";
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
            $sql .= " AND CU.ID_USER NOT IN (SELECT ID_ASM FROM CRMNEW_USER_ASM WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
        }

        return $this->db->query($sql)->result();
    }
	public function User_RSM($id_user=null){
		$sql ="
			SELECT
			UR.NO_USER_RSM,
			UR.ID_USER,
			UR.ID_RSM,
			U.NAMA
			FROM CRMNEW_USER_RSM UR
			LEFT JOIN CRMNEW_USER U ON UR.ID_RSM=U.ID_USER
			WHERE UR.DELETE_MARK='0'			
		";
		
		if($id_user!=null){
			$sql .= " AND UR.ID_USER='$id_user' ";
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
    public function User_SALES($id_user=null){
        $sql ="
            SELECT
            US.NO_USER_SALES,
            US.ID_SALES,
            CU.NAMA
            FROM CRMNEW_USER_SALES US
            LEFT JOIN CRMNEW_USER CU ON US.ID_SALES=CU.ID_USER
            WHERE US.DELETE_MARK='0'
        ";
        
        if($id_user!=null){
            $sql .= " AND US.ID_USER='$id_user' ";
        }
        
        return $this->db->query($sql)->result();
    }
	public function Get_data_gudang($tgl_mulai=null, $tgl_selesai=null){
		
		$sql ="
			
		";
		
		return $this->db->query($sql)-result_array();
	}
	
	// public function get_data()
	// {
		// $sql =" 
				
		// ";
		// return $this->db->query($sql)->result_array();
	// }
	
	// public function get_sales()
	// {
		// $sql =" 
			
		// ";
		// return $this->db->query($sql)->result_array();
	// }
	
	// public function get_data_id($id_menu)
	// {

		// $sql =" 

		// ";

		// return $this->db->query($sql)->result_array();
	// }
	
	// public function insert_data()
	// {
		
		// $sql ="
			
		// ";
	
		// $hasil = $this->db->query($sql);
		// return $hasil;
	// }
	
	// public function update_data($id)
	// {
		
		// $sql ="
				
		// ";
	
		// $hasil = $this->db->query($sql);
		// return $hasil;
	// }
	
	// public function hapus_data($id)
	// {
		
		// $sql ="
			
		// ";
		
		// $hasil = $this->db->query($sql);
		// return $hasil;
	// }	
}
?>
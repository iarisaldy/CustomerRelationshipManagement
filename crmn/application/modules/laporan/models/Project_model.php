<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Project_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data_filter_kapasitas($id_tso, $kd_distributor=null)
	{	
		$sql =" 
			SELECT
            MC.ID_CUSTOMER,
            MC.NAMA_TOKO,
            MC.ALAMAT,
			MC.NAMA_DISTRIBUTOR,
            MC.NAMA_PROVINSI,
            MC.NAMA_DISTRIK,
            MC.NAMA_AREA,
            MC.NAMA_KECAMATAN,
            MC.KAPASITAS_ZAK
			FROM M_CUSTOMER MC 
            WHERE MC.ID_DISTRIBUTOR IN (SELECT
                                        KODE_DISTRIBUTOR
                                        FROM HIRARCKY_GSM_TO_DISTRIBUTOR
                                        WHERE KODE_DISTRIBUTOR IS NOT NULL 
                                        AND ID_SO='$id_tso'
                                        GROUP BY KODE_DISTRIBUTOR) 			
		";
		
		if($kd_distributor!=null){
			 $sql .= " AND MC.ID_DISTRIBUTOR='$kd_distributor' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	public function get_data_filter_kapasitas_GSM($ID_USER, $kd_distributor=null)
	{	
		$sql =" 
			SELECT
            MC.ID_CUSTOMER,
            MC.NAMA_TOKO,
            MC.ALAMAT,
			MC.NAMA_DISTRIBUTOR,
            MC.NAMA_PROVINSI,
            MC.NAMA_DISTRIK,
            MC.NAMA_AREA,
            MC.NAMA_KECAMATAN,
            MC.KAPASITAS_ZAK
			FROM M_CUSTOMER MC 
            WHERE MC.ID_DISTRIBUTOR IN (SELECT
                                        KODE_DISTRIBUTOR
                                        FROM HIRARCKY_GSM_TO_DISTRIBUTOR
                                        WHERE KODE_DISTRIBUTOR IS NOT NULL 
                                        AND ID_GSM='$ID_USER'
                                        GROUP BY KODE_DISTRIBUTOR) 			
		";
		
		if($kd_distributor!=null){
			 $sql .= " AND MC.ID_DISTRIBUTOR='$kd_distributor' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	public function get_data_filter_kapasitas_SPC($ID_USER, $kd_distributor=null)
	{	
		$sql =" 
			SELECT
            MC.ID_CUSTOMER,
            MC.NAMA_TOKO,
            MC.ALAMAT,
			MC.NAMA_DISTRIBUTOR,
            MC.NAMA_PROVINSI,
            MC.NAMA_DISTRIK,
            MC.NAMA_AREA,
            MC.NAMA_KECAMATAN,
            MC.KAPASITAS_ZAK
			FROM M_CUSTOMER MC 
            WHERE MC.ID_DISTRIBUTOR IN (SELECT
										KODE_DISTRIBUTOR
										FROM HIRARCKY_GSM_SALES_DISTRIK
										WHERE REGION_ID IN (SELECT ID_REGION 
															FROM CRMNEW_USER_REGION 
															WHERE DELETE_MARK='0' 
															AND ID_USER='$ID_USER')
															GROUP BY KODE_DISTRIBUTOR
																)  			
		";
		
		if($kd_distributor!=null){
			 $sql .= " AND MC.ID_DISTRIBUTOR='$kd_distributor' ";
		}
		
		return $this->db->query($sql)->result_array();
	}

	
	public function get_data_filter_kapasitas_asm($id_asm,$kd_distributor=null)
	{	
		$sql =" 
			SELECT
            MC.ID_CUSTOMER,
            MC.NAMA_TOKO,
            MC.ALAMAT,
			MC.NAMA_DISTRIBUTOR,
            MC.NAMA_PROVINSI,
            MC.NAMA_DISTRIK,
            MC.NAMA_AREA,
            MC.NAMA_KECAMATAN,
            MC.KAPASITAS_ZAK
			FROM M_CUSTOMER MC 
            WHERE MC.ID_DISTRIBUTOR IN (SELECT
                                        KODE_DISTRIBUTOR
                                        FROM HIRARCKY_GSM_TO_DISTRIBUTOR
                                        WHERE KODE_DISTRIBUTOR IS NOT NULL 
                                        AND ID_SM='$id_asm'
                                        GROUP BY KODE_DISTRIBUTOR) 			
		";
		
		if($kd_distributor!=null){
			 $sql .= " AND MC.ID_DISTRIBUTOR='$kd_distributor' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	public function get_data_filter_kapasitas_rsm($id_rsm,$kd_distributor=null)
	{	
		$sql =" 
			SELECT
            MC.ID_CUSTOMER,
            MC.NAMA_TOKO,
            MC.ALAMAT,
			MC.NAMA_DISTRIBUTOR,
            MC.NAMA_PROVINSI,
            MC.NAMA_DISTRIK,
            MC.NAMA_AREA,
            MC.NAMA_KECAMATAN,
            MC.KAPASITAS_ZAK
			FROM M_CUSTOMER MC 
            WHERE MC.ID_DISTRIBUTOR IN (SELECT
                                        KODE_DISTRIBUTOR
                                        FROM HIRARCKY_GSM_TO_DISTRIBUTOR
                                        WHERE KODE_DISTRIBUTOR IS NOT NULL 
                                        AND ID_SSM='$id_rsm'
                                        GROUP BY KODE_DISTRIBUTOR) 			
		";
		
		if($kd_distributor!=null){
			 $sql .= " AND MC.ID_DISTRIBUTOR='$kd_distributor' ";
		}
		
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_filter_kapasitas_dis($id_dis)
	{	
		$sql =" 
			SELECT
            MC.ID_CUSTOMER,
            MC.NAMA_TOKO,
            MC.ALAMAT,
			MC.NAMA_DISTRIBUTOR,
            MC.NAMA_PROVINSI,
            MC.NAMA_DISTRIK,
            MC.NAMA_AREA,
            MC.NAMA_KECAMATAN,
            MC.KAPASITAS_ZAK
			FROM M_CUSTOMER MC 
            WHERE MC.ID_DISTRIBUTOR IN (SELECT
									KODE_DISTRIBUTOR

									FROM CRMNEW_USER_DISTRIBUTOR
									WHERE DELETE_MARK='0'
									AND ID_USER='$id_dis') 			
		";
		
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_filter_kapasitas_admin($id_admin,$kd_distributor=null, $region=null, $provinsi=null)
	{	
		$sql =" 
			SELECT
            MC.ID_CUSTOMER,
            MC.NAMA_TOKO,
            MC.ALAMAT,
			MC.NAMA_DISTRIBUTOR,
            MC.NAMA_PROVINSI,
            MC.NAMA_DISTRIK,
            MC.NAMA_AREA,
            MC.NAMA_KECAMATAN,
            MC.KAPASITAS_ZAK
			FROM M_CUSTOMER MC 
            WHERE	MC.ID_CUSTOMER IS NOT NULL
		";
		
		if($kd_distributor!=null){
			$sql .= " AND MC.ID_DISTRIBUTOR ='$kd_distributor'  ";
		}
		if($region!=null){
			$sql .= " AND MC.NEW_REGION ='$region'  ";
		}
		if($provinsi!=null){
			$sql .= " AND MC.ID_PROVINSI ='$provinsi'  ";
		}
		
		
		return $this->db->query($sql)->result_array();
	}
	
	
	public function Sales_Distributor($id_user){
		
		$sql ="
			SELECT DISTINCT
			M_SALES_USER_DISTRIBUTOR.ID_USER_DISTRIBUTOR,
			R_REPORT_VISIT_SALES.ID_USER, 
			R_REPORT_VISIT_SALES.NAMA_SALES
			FROM
			R_REPORT_VISIT_SALES LEFT JOIN
			M_SALES_USER_DISTRIBUTOR
			ON R_REPORT_VISIT_SALES.KODE_DISTRIBUTOR = M_SALES_USER_DISTRIBUTOR.KODE_DISTRIBUTOR
			WHERE M_SALES_USER_DISTRIBUTOR.ID_USER_DISTRIBUTOR = '$id_user'
		";
		
		return $this->db->query($sql)->result();
	}
	public function Distributor_gsm($id_user=null){
		$sql ="
			SELECT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR,
			ID_GSM
			FROM HIRARCKY_GSM_TO_DISTRIBUTOR
			WHERE KODE_DISTRIBUTOR IS NOT NULL 
		";
		
		if($id_user!=null){
			$sql .= "AND ID_GSM='$id_user' ";
		}
		
		$sql .= " GROUP BY KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR,
			ID_GSM ";

		return $this->db->query($sql)->result();
	}
	
	public function User_distributor($id_user=null, $jenis_user=null){
		$sql ="
			SELECT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK
		";
		
		if($jenis_user!=null){
			if($jenis_user=='GSM'){
				$sql .= " WHERE ID_GSM='$id_user' ";
			}
			else if($jenis_user=='SSM'){
				$sql .= " WHERE ID_SSM='$id_user' ";
			}
			else if($jenis_user=='SM'){
				$sql .= " WHERE ID_SM='$id_user' ";
			}
			else if($jenis_user=='SO'){
				$sql .= " WHERE ID_SO='$id_user' ";
			}
			else if($jenis_user=='SPC'){
				$sql .= " WHERE REGION_ID IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
			}
			else if($jenis_user=='ADMIN'){
				
			}
			
		}
		$sql .= "GROUP BY KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR ";
		
		return $this->db->query($sql)->result();
	}
	public function User_Area($id_user){
		$sql ="
				SELECT distinct
				M_SALES_USER_DISTRIBUTOR.ID_USER_DISTRIBUTOR,
				M_CUSTOMER.ID_AREA,
				M_CUSTOMER.NAMA_AREA
				FROM
				M_CUSTOMER LEFT JOIN
				M_SALES_USER_DISTRIBUTOR
				ON M_CUSTOMER.ID_DISTRIBUTOR = M_SALES_USER_DISTRIBUTOR.KODE_DISTRIBUTOR
				WHERE ID_USER_DISTRIBUTOR = '$id_user'
				AND ID_KECAMATAN IS NOT NULL
				AND ID_KECAMATAN != '0' 		
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function User_Distrik($id_user){
		$sql ="
			SELECT distinct
			M_SALES_USER_DISTRIBUTOR.ID_USER_DISTRIBUTOR,
			M_CUSTOMER.ID_DISTRIK,
			M_CUSTOMER.NAMA_DISTRIK
			FROM
			M_CUSTOMER LEFT JOIN
			M_SALES_USER_DISTRIBUTOR
			ON M_CUSTOMER.ID_DISTRIBUTOR = M_SALES_USER_DISTRIBUTOR.KODE_DISTRIBUTOR
			WHERE ID_USER_DISTRIBUTOR = '$id_user'
			AND ID_KECAMATAN IS NOT NULL
			AND ID_KECAMATAN != '0'
			AND ID_KECAMATAN != 'null' 			
		";
		
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
            $sql .= " AND CU.ID_USER IN (SELECT ID_ASM FROM CRMNEW_USER_ASM WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
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

}
?>
<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Report_visit_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data_filter_visit_exel($id_tso, $bulan=null ,$tahun=null, $kd_distributor=null, $sales=null)
	{	
		$sql =" 
			SELECT 
				MC.ID_SALES,
				MC.NAMA_SALES,
				MC.KODE_DISTRIBUTOR,
				MC.NAMA_DISTRIBUTOR,
				MC.TAHUN,
				MC.BULAN,
				MC.HARI,
				SUM(MC.TARGET) AS TARGET,
				SUM(MC.REALISASI) AS REALISASI,
				SUM(MC.UNPLAN_TARGET) AS UNPLAN_TARGET
				FROM VISIT_SALES_DISTRIBUTOR MC
			LEFT JOIN HIRARCKY_GSM_SALES_DISTRIK DC ON MC.ID_SALES = DC.ID_SALES
				AND MC.ID_DISTRIK=DC.ID_DISTRIK
			WHERE MC.ID_SALES IS NOT NULL
			AND DC.ID_SO = '$id_tso'
			
		";
		
		if($kd_distributor!=null){
			$sql .= " AND MC.KODE_DISTRIBUTOR='$kd_distributor' ";
		}
		
		if($sales!=null){
			$sql .= " AND MC.ID_SALES='$sales' ";
		}
		
		if($tahun!=null){
			$sql .= " AND MC.TAHUN='$tahun' ";
		}
		
		if($bulan!=null){
			$sql .= " AND MC.BULAN='$bulan' ";
		}
		
		$sql .= " 
			GROUP BY 
				MC.ID_SALES,
				MC.NAMA_SALES,
				MC.KODE_DISTRIBUTOR,
				MC.NAMA_DISTRIBUTOR,
				MC.TAHUN,
				MC.BULAN,
				MC.HARI
		";
		//ECHO $sql;
		
		return $this->db->query($sql)->result_array();
	}
	public function get_data_filter_visit($id_tso, $bulan=null ,$tahun=null, $kd_distributor=null, $sales=null)
	{	
		$sql =" 
			SELECT 
				MC.ID_SALES,
				MC.NAMA_SALES,
				MC.KODE_DISTRIBUTOR,
				MC.NAMA_DISTRIBUTOR,
				MC.TAHUN,
				MC.BULAN,
				MC.HARI,
				MC.TARGET,
				MC.REALISASI,
				MC.UNPLAN_TARGET,
				DC.NAMA_SO,
				DC.REGION_ID,
				DC.NAMA_SM,
                DC.NM_AREA,
                DC.NM_DISTRIK 
				FROM VISIT_SALES_DISTRIBUTOR MC
			LEFT JOIN HIRARCKY_GSM_SALES_DISTRIK DC ON MC.ID_SALES = DC.ID_SALES
				AND MC.ID_DISTRIK=DC.ID_DISTRIK
			WHERE MC.ID_SALES IS NOT NULL
			AND DC.ID_SO = '$id_tso'
			
		";
		
		if($kd_distributor!=null){
			$sql .= " AND MC.KODE_DISTRIBUTOR='$kd_distributor' ";
		}
		
		if($sales!=null){
			$sql .= " AND MC.ID_SALES='$sales' ";
		}
		
		if($tahun!=null){
			$sql .= " AND MC.TAHUN='$tahun' ";
		}
		
		if($bulan!=null){
			$sql .= " AND MC.BULAN='$bulan' ";
		}
		//ECHO $sql;
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_filter_visit_asm($id_asm, $bulan=null ,$tahun=null, $kd_distributor=null, $tso=null)
	{	
		$sql =" 
			SELECT 
				MC.ID_SALES,
				MC.NAMA_SALES,
				MC.KODE_DISTRIBUTOR,
				MC.NAMA_DISTRIBUTOR,
				MC.TAHUN,
				MC.BULAN,
				MC.HARI,
				MC.TARGET,
				MC.REALISASI,
				MC.UNPLAN_TARGET,
				DC.NAMA_SO,
				DC.REGION_ID,
				DC.NAMA_SM,
                DC.NM_AREA,
                DC.NM_DISTRIK 
				FROM VISIT_SALES_DISTRIBUTOR MC
			LEFT JOIN HIRARCKY_GSM_SALES_DISTRIK DC ON MC.ID_SALES = DC.ID_SALES
				AND MC.ID_DISTRIK=DC.ID_DISTRIK
			WHERE MC.ID_SALES IS NOT NULL
			AND DC.ID_SM = '$id_asm'
			
		";
		
		if($kd_distributor!=null){
			$sql .= " AND MC.KODE_DISTRIBUTOR='$kd_distributor' ";
		}
		
		if($tso!=null){
			$sql .= " AND DC.ID_SO='$tso' ";
		}
		
		if($tahun!=null){
			$sql .= " AND MC.TAHUN='$tahun' ";
		}
		
		if($bulan!=null){
			$sql .= " AND MC.BULAN='$bulan' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_filter_visit_rsm($id_rsm, $bulan=null ,$tahun=null, $kd_distributor=null, $asm=null)
	{	
		$sql =" 
			SELECT
				MC.ID_SALES,
				MC.NAMA_SALES,
				MC.KODE_DISTRIBUTOR,
				MC.NAMA_DISTRIBUTOR,
				MC.TAHUN,
				MC.BULAN,
				MC.HARI,
				MC.TARGET,
				MC.REALISASI,
				MC.UNPLAN_TARGET,
				DC.NAMA_SO,
				DC.NAMA_SM,
				DC.NAMA_SSM,
				DC.REGION_ID,
				DC.NAMA_GSM,
				DC.NM_AREA,
                DC.NM_DISTRIK 
				FROM VISIT_SALES_DISTRIBUTOR MC
			LEFT JOIN HIRARCKY_GSM_SALES_DISTRIK DC ON MC.ID_SALES = DC.ID_SALES
				AND MC.ID_DISTRIK=DC.ID_DISTRIK
			WHERE MC.ID_SALES IS NOT NULL
			AND DC.ID_SSM = '$id_rsm'
			
		";
		
		if($kd_distributor!=null){
			$sql .= " AND MC.KODE_DISTRIBUTOR='$kd_distributor' ";
		}
		
		if($asm!=null){
			$sql .= " AND DC.ID_SM='$asm' ";
		}
		
		if($tahun!=null){
			$sql .= " AND MC.TAHUN='$tahun' ";
		}
		
		if($bulan!=null){
			$sql .= " AND MC.BULAN='$bulan' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_filter_visit_grm($id_rsm=null,$bulan=null ,$tahun=null, $rsm=null, $id_dis=null)
	{	
		$sql =" 
			SELECT
				MC.ID_SALES,
				MC.NAMA_SALES,
				MC.KODE_DISTRIBUTOR,
				MC.NAMA_DISTRIBUTOR,
				MC.TAHUN,
				MC.BULAN,
				MC.HARI,
				MC.TARGET,
				MC.REALISASI,
				MC.UNPLAN_TARGET,
				DC.NAMA_SO,
				DC.NAMA_SM,
				DC.NAMA_SSM,
				DC.REGION_ID,
				DC.NAMA_GSM,
				DC.NM_AREA,
                DC.NM_DISTRIK 
				FROM VISIT_SALES_DISTRIBUTOR MC
			LEFT JOIN HIRARCKY_GSM_SALES_DISTRIK DC ON MC.ID_SALES = DC.ID_SALES
				AND MC.ID_DISTRIK=DC.ID_DISTRIK
			WHERE MC.ID_SALES IS NOT NULL
			AND DC.ID_SSM IN($id_rsm)
		";
		
		if($rsm!=null){
			$sql .= " AND DC.ID_SSM = '$rsm' ";
		}
		
		if($id_dis!=null){
			$sql .= " AND MC.KODE_DISTRIBUTOR = '$id_dis' ";
		}
		
		if($tahun!=null){
			$sql .= " AND MC.TAHUN='$tahun' ";
		}
		
		if($bulan!=null){
			$sql .= " AND MC.BULAN='$bulan' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	public function get_data_filter_visit_spc($id_user=null,$bulan=null ,$tahun=null)
	{	
		$sql =" 
			SELECT
				MC.ID_SALES,
				MC.NAMA_SALES,
				MC.KODE_DISTRIBUTOR,
				MC.NAMA_DISTRIBUTOR,
				MC.TAHUN,
				MC.BULAN,
				MC.HARI,
				MC.TARGET,
				MC.REALISASI,
				MC.UNPLAN_TARGET,
				DC.NAMA_SO,
				DC.NAMA_SM,
				DC.NAMA_SSM,
				DC.REGION_ID,
				DC.NAMA_GSM,
				DC.NM_AREA,
                DC.NM_DISTRIK 
				FROM VISIT_SALES_DISTRIBUTOR MC
			LEFT JOIN HIRARCKY_GSM_SALES_DISTRIK DC ON MC.ID_SALES = DC.ID_SALES
				AND MC.ID_DISTRIK=DC.ID_DISTRIK
			WHERE MC.ID_SALES IS NOT NULL
			AND DC.REGION_ID IN(SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE ID_USER='$id_user' )
		";
		
		if($tahun!=null){
			$sql .= " AND MC.TAHUN='$tahun' ";
		}
		
		if($bulan!=null){
			$sql .= " AND MC.BULAN='$bulan' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	public function get_data_filter_visit_spcEXEL($id_user=null,$bulan=null ,$tahun=null)
	{	
		$sql =" 
			SELECT
				MC.ID_SALES,
				MC.NAMA_SALES,
				MC.KODE_DISTRIBUTOR,
				MC.NAMA_DISTRIBUTOR,
				MC.TAHUN,
				MC.BULAN,
				MC.HARI,
				DC.NAMA_SO,
				DC.NAMA_SM,
				SUM(MC.TARGET) AS TARGET,
				SUM(MC.REALISASI) AS REALISASI,
				SUM(MC.UNPLAN_TARGET) AS UNPLAN_TARGET
				FROM VISIT_SALES_DISTRIBUTOR MC
			LEFT JOIN HIRARCKY_GSM_SALES_DISTRIK DC ON MC.ID_SALES = DC.ID_SALES
				AND MC.ID_DISTRIK=DC.ID_DISTRIK
			WHERE MC.ID_SALES IS NOT NULL
			AND DC.REGION_ID IN(SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE ID_USER='$id_user' )
		";
		
		if($tahun!=null){
			$sql .= " AND MC.TAHUN='$tahun' ";
		}
		
		if($bulan!=null){
			$sql .= " AND MC.BULAN='$bulan' ";
		}
		
		$sql .= " 
			GROUP BY 
				MC.ID_SALES,
				MC.NAMA_SALES,
				MC.KODE_DISTRIBUTOR,
				MC.NAMA_DISTRIBUTOR,
				MC.TAHUN,
				MC.BULAN,
				MC.HARI,
				DC.NAMA_SO,
				DC.NAMA_SM
		";
		
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_filter_visit_dis($id_user, $bulan=null ,$tahun=null, $idsales=null)
	{	
		$sql =" 
			SELECT
				MC.ID_SALES,
				MC.NAMA_SALES,
				MC.KODE_DISTRIBUTOR,
				MC.NAMA_DISTRIBUTOR,
				MC.TAHUN,
				MC.BULAN,
				MC.HARI,
				MC.TARGET,
				MC.REALISASI,
				MC.UNPLAN_TARGET,
				DC.NAMA_SO,
				DC.NAMA_SM,
				DC.NAMA_SSM,
				DC.REGION_ID,
				DC.NAMA_GSM,
				DC.NM_AREA,
                DC.NM_DISTRIK 
				FROM VISIT_SALES_DISTRIBUTOR MC
			LEFT JOIN HIRARCKY_GSM_SALES_DISTRIK DC ON MC.ID_SALES = DC.ID_SALES
				AND MC.ID_DISTRIK=DC.ID_DISTRIK
			WHERE MC.ID_SALES IS NOT NULL
			AND MC.KODE_DISTRIBUTOR IN(SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0' AND ID_USER='$id_user' )
			
		";
		
		if($idsales!=null){
			$sql .= " AND MC.ID_SALES='$idsales' ";
		}
		
		if($tahun!=null){
			$sql .= " AND  MC.TAHUN='$tahun' ";
		}
		
		if($bulan!=null){
			$sql .= " AND MC.BULAN='$bulan' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function ASM_dis($id_user){
		$sql ="
			SELECT DISTINCT 
				KODE_DISTRIBUTOR,
				NAMA_DISTRIBUTOR 
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SM = '$id_user'			
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function RSM_dis($id_user){
		$sql ="
			SELECT DISTINCT 
				KODE_DISTRIBUTOR, 
				NAMA_DISTRIBUTOR 
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SSM = '$id_user'			
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function GSM_dis($id_user){
		$sql ="
			SELECT DISTINCT 
				KODE_DISTRIBUTOR,
				NAMA_DISTRIBUTOR 
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_GSM = '$id_user'			
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function Sales_Distributor($id_user){
		
		$sql ="
			SELECT
			ID_SALES,
			NAMA_SALES
			FROM SALES_DISTRIBUTOR
			WHERE KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0' AND ID_USER='$id_user' )
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function RSM_GSM($id_user){
		
		$sql ="
			SELECT 
			ID_RSM,NAMA_RSM
			FROM SO_TOPDOWN_RSM
			WHERE ID_GSM = '$id_user'
		";
		
		return $this->db->query($sql)->result_array();
	}
	public function RSMlist($id_user){
		
		$sql ="
			SELECT DISTINCT
			ID_SSM,NAMA_SSM
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_GSM = '$id_user'
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function User_distributor($id_user=null){
		$sql ="
			SELECT DISTINCT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE NAMA_DISTRIBUTOR IS NOT NULL
		";
		
		if($id_user!=null){
			$sql .= " AND ID_SO='$id_user' ORDER BY NAMA_DISTRIBUTOR ASC";
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
	
	public function User_TSO($id_user){
		$sql ="
			SELECT DISTINCT
				ID_SO,
				NAMA_SO
			FROM HIRARCKY_GSM_SALES_DISTRIK
				WHERE ID_SM = '$id_user'		
		";
		return $this->db->query($sql)->result();
	}
	
	public function listASM($id_user=null){
        $sql ="
            SELECT DISTINCT
				ID_SM,
				NAMA_SM
			FROM HIRARCKY_GSM_SALES_DISTRIK
				WHERE ID_SSM = '$id_user'          
        ";

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
	
    public function User_SALES($id_user=null, $id_dis=null){
        $sql ="
            SELECT DISTINCT
            ID_SALES,
            NAMA_SALES
            FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SALES IS NOT NULL
			AND NAMA_SALES IS NOT NULL
        ";
        
        if($id_user!=null){
            $sql .= " AND ID_SO='$id_user' ";
        }
		
		if($id_dis!=null){
			$sql .= " AND KODE_DISTRIBUTOR = '$id_dis' ORDER BY NAMA_SALES ASC";
		}
        
        return $this->db->query($sql)->result();
    }	
}
?>
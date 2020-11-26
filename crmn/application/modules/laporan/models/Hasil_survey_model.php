<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Hasil_survey_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('crm', TRUE);
		//$this->db = $this->load->database('default', TRUE);
		
	}
	
	public function Get_Distributor()
	{	
		$sql =" 
			SELECT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			FROM R1_HASIL_SURVEY_SD
			GROUP BY KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			ORDER BY NAMA_DISTRIBUTOR
		";
		
		return $this->db->query($sql)->result();
	}
	public function get_data_hasil_survey_a1($distributor=null, $mulai, $selesai, $region=null){
		
		
		$sql =" 
			SELECT
			R.*

			FROM R1_HASIL_SURVEY_SD R
			WHERE TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYYMMDD') BETWEEN '$mulai' AND '$selesai'

		";
		if($distributor!=null){
			$sql .=" AND KODE_DISTRIBUTOR='$distributor' ";
		}
		if($region!=null){
			$sql .=" AND REGION_ID='$region' ";
		}
		
		// print_r('<pre>');
		// print_r($sql);exit;
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_hasil_survey($mulai, $selesai, $id_user=null, $jenis=null, $region=null, $distributor=null){
		$sql =" 
			SELECT
			R.*

			FROM R1_HASIL_SURVEY_SD R
			WHERE TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYYMMDD') BETWEEN '$mulai' AND '$selesai'

		";
		if($jenis!=null){
			if($jenis=='SO'){
				$sql .=" AND ID_SO='$id_user' ";
			}
			else if($jenis=='SM'){
				$sql .=" AND ID_SM='$id_user' ";
			}
			else if($jenis=='SSM'){
				$sql .=" AND ID_SSM='$id_user' ";
			}
			else if($jenis=='GSM'){
				$sql .=" AND ID_GSM='$id_user' ";
			}
			else if($jenis=='DIS'){
				$sql .=" AND KODE_DISTRIBUTOR IN (SELECT
			KODE_DISTRIBUTOR
			FROM CRMNEW_USER_DISTRIBUTOR
			WHERE DELETE_MARK='0'
			AND ID_USER='$id_user') ";
			}
			
			else if($jenis=='SPC'){
				$sql .=" AND  REGION_ID IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE ID_USER='$id_user' AND DELETE_MARK='0') ";
			}
			
		}
		if($region!=null){
			$sql .=" AND  REGION_ID='$region' ";
		}
		if($distributor!=null){
			$sql .=" AND KODE_DISTRIBUTOR='$distributor' ";
		}

		// print_r('<pre>');
		// print_r($sql);exit;
		
		return $this->db->query($sql)->result_array();
	}
	public function get_data_admin($tahun=null, $bulan=null, $id_tso=null, $id_gsm=null, $spc=null)
	{	
		$sql =" 
			SELECT
			R.*

			FROM R1_HASIL_SURVEY_SD R
			WHERE TAHUN='$tahun'
			AND BULAN='$bulan'

		";
		
		if($id_tso!=null){
			$sql .=" AND ID_SO='$id_tso' ";
		}
		if($id_gsm!=null){
			$sql .=" AND ID_GSM='$id_gsm' ";
		}
		if($spc!=null){
			$sql .=" AND REGION_ID IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE ID_USER='$spc' ) ";
		}
		
		//ECHO $sql;
		
		//
		// if($id_dis!=null){
		// 	$sql .= " AND KODE_DISTRIBUTOR ='$id_dis' ";
		// }
		
		// if($region!=null){
		// 	$sql .= " AND REGION_ID ='$region' ";
		// }
		
		// if($id_prov!=null){
		// 	$sql .= " AND ID_PROVINSI ='$id_prov' ";
		// }
		
		
		return $this->db->query($sql)->result_array();
	}
	
	
	public function get_data_tso($id_user, $id_dis=null,  $id_sales=null)
	{	
		$sql =" 
			SELECT 
				ID_SALES,
				NAMA_SALES,
				KODE_DISTRIBUTOR,
				NAMA_DISTRIBUTOR,
				NAMA_SO,
				NAMA_SM,
				NAMA_SSM,
				NAMA_PROVINSI,
				REGION_ID,
				NAMA_GSM,
                NM_AREA,
                NM_DISTRIK
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SO = '$id_user'
			AND ID_SALES IS NOT NULL
			AND NAMA_SALES IS NOT NULL
		";
		
		if($id_dis!=null){
			$sql .= " AND KODE_DISTRIBUTOR='$id_dis' ";
		}
		
		if($id_sales!=null){
			$sql .= " AND ID_SALES='$id_sales' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_asm($id_user , $id_dis=null, $id_tso=null)
	{	
		$sql =" 
			SELECT 
				ID_SALES,
				NAMA_SALES,
				NAMA_DISTRIBUTOR,
				NAMA_SO,
				NAMA_SM,
				NAMA_SSM,
				NAMA_PROVINSI,
				REGION_ID,
				NAMA_GSM,
                NM_AREA,
                NM_DISTRIK
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SM = '$id_user'
			AND ID_SALES IS NOT NULL
			AND NAMA_SALES IS NOT NULL
		";
		
		if($id_dis!=null){
			$sql .= " AND KODE_DISTRIBUTOR='$id_dis' ";
		}
		
		if($id_tso!=null){
			$sql .= " AND ID_SO='$id_tso' ";
		}
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_rsm($id_user , $id_dis =null)
	{	
		$sql =" 
			SELECT 
				ID_SALES,
				NAMA_SALES,
				NAMA_DISTRIBUTOR,
				NAMA_SO,
				NAMA_SM,
				NAMA_SSM,
				NAMA_PROVINSI,
				REGION_ID,
				NAMA_GSM,
                NM_AREA,
                NM_DISTRIK
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SSM = '$id_user'
			AND ID_SALES IS NOT NULL
			AND NAMA_SALES IS NOT NULL
		";
		
		if($id_dis!=null){
			$sql .= " AND KODE_DISTRIBUTOR='$id_dis' ";
		}
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_gsm($id_rsm , $rsm =null, $id_dis=null)
	{	
		$sql =" 
			SELECT 
				ID_SALES,
				NAMA_SALES,
				NAMA_DISTRIBUTOR,
				NAMA_SO,
				NAMA_SM,
				NAMA_SSM,
				NAMA_PROVINSI,
				REGION_ID,
                NM_AREA,
                NM_DISTRIK
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SSM IN ($id_rsm)
			AND ID_SALES IS NOT NULL
			AND NAMA_SALES IS NOT NULL
		";
		
		if($rsm!=null){
			$sql .= " AND ID_SSM = '$rsm' ";
		}
		
		if($id_dis!=null){
			$sql .= " AND KODE_DISTRIBUTOR = '$id_dis' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_dis($id_user)
	{	
		$sql =" 
			SELECT 
				MS.ID_SALES AS ID_USER,
				MS.NAMA_SALES AS NAMA,
				MS.NAMA_DISTRIBUTOR,
				MD.NAMA_TSO,
				MD.NAMA_ASM,
				MD.NAMA_RSM,
				MD.NAMA_PROVINSI,
				MD.NEW_REGION,
				MD.NAMA_GSM
			FROM M_SALES_USER_DISTRIBUTOR MS LEFT JOIN M_SALES_DISTRIBUTOR MD
			ON MS.ID_SALES = MD.ID_USER
			WHERE MS.ID_USER_DISTRIBUTOR = '$id_user'
		";

		return $this->db->query($sql)->result_array();
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
			SELECT 
			ID_RSM,NAMA_RSM
			FROM SO_TOPDOWN_RSM
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
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		
		if($id_user!=null){
			$sql .= " AND ID_SO='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
	
	public function ASM_dis($id_user){
		$sql ="
			SELECT DISTINCT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		
		if($id_user!=null){
			$sql .= " AND ID_SM='$id_user' ";
		}
		
		
		return $this->db->query($sql)->result();
	}
	
	public function RSM_dis($id_user){
		$sql ="
			SELECT DISTINCT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		
		if($id_user!=null){
			$sql .= " AND ID_SSM='$id_user' ";
		}
		
		
		return $this->db->query($sql)->result();
	}
	
	public function GSM_dis($id_user){
		$sql ="
			SELECT DISTINCT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		
		if($id_user!=null){
			$sql .= " AND ID_GSM='$id_user' ";
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
	public function listASM($id_user){
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
			WHERE ID_SO = '$id_user'
			AND ID_SALES IS NOT NULL
			AND NAMA_SALES IS NOT NULL
        ";
		
		if($id_dis!=null){
			$sql .= " AND KODE_DISTRIBUTOR = '$id_dis' ORDER BY NAMA_SALES ASC";
		}
        
        return $this->db->query($sql)->result();
    }
	
	public function Get_region_all($id_user=null){
		
		$sql ="
			SELECT
			*
			FROM (
			SELECT DISTINCT 
				NEW_REGION
			FROM 
				CRMNEW_M_PROVINSI
            WHERE 
                NEW_REGION IS NOT NULL
				ORDER BY NEW_REGION ASC )
				
		";
		if($id_user!=null){
			$sql .="
				WHERE NEW_REGION IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE ID_USER='$id_user' AND DELETE_MARK='0')
			";
		}
		
		return $this->db->query($sql)->result();
	}
	
	public function Get_provinsi_all($id_region=null){
		
		$sql ="
			SELECT DISTINCT 
				ID_PROVINSI,
				NAMA_PROVINSI 
			FROM 
				CRMNEW_M_PROVINSI
		";
		
		if($id_region!=null){
			$sql .= " WHERE NEW_REGION = '$id_region' ORDER BY NAMA_PROVINSI ASC";
		}
		
		return $this->db->query($sql)->result();
	}
	
	public function Get_dis_all($id_provinsi=null){
		
		$sql ="
			SELECT DISTINCT 
				KODE_DISTRIBUTOR,
				NAMA_DISTRIBUTOR 
			FROM 
				HIRARCKY_GSM_SALES_DISTRIK
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		
		if($id_provinsi!=null){
			$sql .= " AND ID_PROVINSI = '$id_provinsi' ORDER BY NAMA_DISTRIBUTOR ASC";
		}
		
		return $this->db->query($sql)->result();
	}
}
?>
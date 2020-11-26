<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Report_sales_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('crm', TRUE);
	}
	
	public function get_data_filter_visit($tahun=null, $bulan=null, $region=null, $id_prov=null)
	{	


		$sql =" 
				SELECT
				*
				FROM (
				SELECT DISTINCT
					DC.ID_SALES,
					DC.NAMA_SALES,
					DC.KODE_DISTRIBUTOR,
					DC.NAMA_DISTRIBUTOR,
					MC.TAHUN,
					MC.BULAN,
					MC.HARI,
					MC.TARGET,
					MC.REALISASI,
					MC.UNPLAN_TARGET,
					DC.REGION_ID,
					DC.NAMA_SO,
					DC.NAMA_SM,
					DC.NAMA_SSM,
					DC.NAMA_GSM,
					DC.ID_PROVINSI,
					DC.NAMA_PROVINSI
					FROM HIRARCKY_GSM_SALES_DISTRIK DC 
                    LEFT JOIN VISIT_SALES_DISTRIBUTOR MC ON DC.ID_SALES = MC.ID_SALES
						AND MC.ID_DISTRIK=DC.ID_DISTRIK
					WHERE DC.ID_SALES IS NOT NULL
					AND DC.NAMA_SALES IS NOT NULL 
			";
			
		
		if($tahun!=null){
			$sql .= " AND ( MC.TAHUN = '$tahun' ";

			if($bulan!=null){
				$sql .= " AND MC.BULAN = '$bulan' OR TARGET IS NULL ) ";
			}
			
			$sql .= " ) ";
		}
		
		if($region!=null){
			$sql .= " WHERE REGION_ID = '$region' ";


			if($id_prov!=null){
				$sql .= " AND ID_PROVINSI = '$id_prov' ";
			}
		}
		
		//ECHO $sql;
		
		
		return $this->db->query($sql)->result_array();
	}
	public function get_data_filter_visit_exel($tahun=null, $bulan=null, $region=null, $id_prov=null)
	{	
		$sql =" 
				SELECT
				*
				FROM (
				SELECT DISTINCT
					DC.ID_SALES,
					DC.NAMA_SALES,
					DC.KODE_DISTRIBUTOR,
					DC.NAMA_DISTRIBUTOR,
					DC.REGION_ID,
					DC.ID_PROVINSI,
					DC.NAMA_PROVINSI,
					DC.NAMA_SO,
					DC.NAMA_SM,
					DC.NAMA_SSM,
					MC.TAHUN,
					MC.BULAN,
					MC.HARI,
					SUM(MC.TARGET) AS TARGET,
					SUM(MC.REALISASI) AS REALISASI,
					SUM(MC.UNPLAN_TARGET) AS UNPLAN_TARGET
					
					FROM HIRARCKY_GSM_SALES_DISTRIK DC 
                    LEFT JOIN VISIT_SALES_DISTRIBUTOR MC ON DC.ID_SALES = MC.ID_SALES
						AND MC.ID_DISTRIK=DC.ID_DISTRIK
					WHERE DC.ID_SALES IS NOT NULL
					AND DC.NAMA_SALES IS NOT NULL 
			";
			
		if($bulan!=null){
			$sql .= " AND MC.BULAN = '$bulan' OR TARGET IS NULL";
		}
		
		if($tahun!=null){
			$sql .= " AND MC.TAHUN = '$tahun' OR TARGET IS NULL";
		}
		
		if($region!=null){
			$sql .= " AND DC.REGION_ID = '$region' ";
		}
		
		if($id_prov!=null){
			$sql .= " AND DC.ID_PROVINSI = '$id_prov' ";
		}
		
		$sql .= " 
			GROUP BY 
				DC.ID_SALES,
					DC.NAMA_SALES,
					DC.KODE_DISTRIBUTOR,
					DC.NAMA_DISTRIBUTOR,
					DC.REGION_ID,
					DC.ID_PROVINSI,
					DC.NAMA_PROVINSI,
					DC.NAMA_SO,
					DC.NAMA_SM,
					DC.NAMA_SSM,
					MC.TAHUN,
					MC.BULAN,
					MC.HARI
				
		";
		
		$sql .= " ) ";

		if($region!=null){
			$sql .= " WHERE REGION_ID = '$region' ";


			if($id_prov!=null){
				$sql .= " AND ID_PROVINSI = '$id_prov' ";
			}
		}
		//ECHO $sql;
		return $this->db->query($sql)->result_array();
	}
	
	public function Get_region_all(){
		
		$sql ="
			SELECT DISTINCT 
				NEW_REGION
			FROM 
				CRMNEW_M_PROVINSI
            WHERE 
                NEW_REGION IS NOT NULL
            ORDER BY NEW_REGION ASC 
		";
		
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
	
}
?>
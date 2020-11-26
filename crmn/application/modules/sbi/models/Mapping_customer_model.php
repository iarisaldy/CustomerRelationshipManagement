<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Mapping_customer_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	public function List_rsm(){
		$sql = "
			SELECT DISTINCT (ID_SSM) as ID_RSM, NAMA_SSM as NAMA_RSM FROM HIRARCKY_GSM_TO_DISTRIBUTOR
			WHERE ID_SSM IS NOT NULL
		";
		$sql .= "ORDER BY NAMA_SSM";
		return $this->db->query($sql)->result();
	}
	
	public function List_asm($id_rsm = null){
		$sql = "
			SELECT DISTINCT (ID_SM) as ID_ASM, NAMA_SM as NAMA_ASM FROM HIRARCKY_GSM_TO_DISTRIBUTOR
			WHERE ID_SM IS NOT NULL
		";
		if($id_rsm != null){
			$sql .= " AND ID_SSM = '$id_rsm'";
		}
		$sql .= " ORDER BY NAMA_SM";
		return $this->db->query($sql)->result();
	}
	
	public function List_tso($id_rsm = null, $id_asm = null){
		$sql = "
			SELECT DISTINCT (ID_SO) as ID_TSO, NAMA_SO as NAMA_TSO FROM HIRARCKY_GSM_TO_DISTRIBUTOR
			WHERE ID_SO IS NOT NULL
		";
		if($id_rsm != null){
			$sql .= " AND ID_SSM = '$id_rsm'";
		}
		
		if($id_asm != null){
			$sql .= " AND ID_SM = '$id_asm'";
		}
		
		$sql .= "ORDER BY NAMA_SO";
		
		return $this->db->query($sql)->result();
	}
	
	public function List_sales($id_rsm = null, $id_asm = null, $id_tso = null){
        $sql ="
            SELECT DISTINCT(ID_SALES) AS ID_USER, NAMA_SALES AS NAMA FROM HIRARCKY_GSM_TO_DISTRIBUTOR
        ";
		
		if($id_rsm != null){
			$sql .= " WHERE ID_SSM = '$id_rsm'";
		}
		
		if($id_asm != null){
			$sql .= " WHERE ID_SM = '$id_asm'";
		}
		
		if($id_tso != null){
			$sql .= " WHERE ID_SO = '$id_tso'";
		}
		
		$sql .= "ORDER BY NAMA_SALES";
		
        return $this->db->query($sql)->result();
    }
	
	
	
	public function List_customer_mapping($id_rsm = null, $id_asm = null, $id_tso = null, $id_sales = null){
		$sql =" 
			SELECT 
				KODE_DISTRIBUTOR, 
				NAMA_DISTRIBUTOR,
				KD_CUSTOMER,
				NAMA_TOKO,
				ALAMAT,
				NAMA_DISTRIK,
				ID_SALES,
				NAMA_SALES,
				NAMA_TSO,
				NAMA_ASM,
				NAMA_RSM,
				NAMA_GSM,
				CREATE_DATE
			FROM R_REPORT_TOKO_SALES
			WHERE KD_CUSTOMER IS NOT NULL AND NAMA_TOKO IS NOT NULL
        ";
		//AND rownum <= 11200  /// 
		//SELECT * FROM R_REPORT_TOKO_SALES
		//WHERE KD_CUSTOMER IS NOT NULL
			
		if($id_rsm != null){ 
			$sql .= " AND ID_RSM = '$id_rsm'";
		}
		
		if($id_asm != null){
			$sql .= " AND ID_ASM = '$id_asm'";
		}
		
		if($id_tso != null){
			$sql .= " AND ID_TSO = '$id_tso'";
		}
		
		if($id_sales != null){
			$sql .= " AND ID_SALES = '$id_sales'";
		}
		 
		$sql .= " 
		group by KODE_DISTRIBUTOR, 
				NAMA_DISTRIBUTOR,
				KD_CUSTOMER,
				NAMA_TOKO,
				ALAMAT,
				NAMA_DISTRIK,
				ID_SALES,
				NAMA_SALES,
				NAMA_TSO,
				NAMA_ASM,
				NAMA_RSM,
				NAMA_GSM,
				CREATE_DATE
		ORDER BY KD_CUSTOMER, NAMA_TOKO";
		
		// print_r($sql);
		// exit;
        
        return $this->db->query($sql)->result();
		
	}
	
	public function getRegion(){
            $sql = "
                SELECT 
				REGION_ID AS ID_REGION,
				REGION_ID AS REGION
				FROM WILAYAH_SMI
				GROUP BY REGION_ID, REGION_NAME
				ORDER BY REGION_ID ASC
            ";
            return $this->db->query($sql)->result();
        }
        
        public function getProvinsi(){
            $sql = "
                SELECT ID_PROVINSI, NAMA_PROVINSI FROM CRMNEW_M_PROVINSI
                WHERE ID_REGION IS NOT NULL
            ";
            return $this->db->query($sql)->result();
        }
        
        public function getArea(){
            $sql = "
                SELECT 
				KD_AREA AS ID_AREA,
				NM_AREA AS NAMA_AREA
				FROM WILAYAH_SMI
				WHERE KD_AREA IS NOT NULL

				GROUP BY KD_AREA, NM_AREA
				ORDER BY ID_AREA ASC
            ";
            return $this->db->query($sql)->result();
        }
        
        public function getDistributor(){
            $sql = "
                SELECT 
				KODE_DISTRIBUTOR,
				NAMA_DISTRIBUTOR
				FROM CRMNEW_DISTRIBUTOR
				WHERE FLAG='SBI'
				AND ORG='SBI'
				ORDER BY NAMA_DISTRIBUTOR ASC
            ";
            return $this->db->query($sql)->result();
        }
		
		public function getDataMapping($filterBy = null, $filterSet = null){
			$sql = " 
				SELECT
					KODE_DISTRIBUTOR, 
					NAMA_DISTRIBUTOR,
					KD_CUSTOMER,
					NAMA_TOKO,
					ALAMAT,
					NAMA_DISTRIK,
					NAMA_PROVINSI,
					NAMA_AREA,
					NEW_REGION,
					ID_SALES,
					NAMA_SALES,
					NAMA_TSO,
					NAMA_ASM,
					NAMA_RSM,
					NAMA_GSM,
					CREATE_DATE
				FROM R_REPORT_TOKO_SALES 
				WHERE KD_CUSTOMER IS NOT NULL AND NAMA_TOKO IS NOT NULL
			";
			
				if($filterBy == 1){
                    $sql .= " AND NEW_REGION = '$filterSet' ";
                } else if ($filterBy == 2){
                    $sql .= " AND ID_PROVINSI = '$filterSet' ";
                } else if ($filterBy == 3){
                    
                } else if ($filterBy == 4){
                    $sql .= " AND ID_AREA = '$filterSet' ";
                } else if ($filterBy == 5){
                    $sql .= " AND KODE_DISTRIBUTOR = '$filterSet' ";
                }
			
			$sql .= " 
			group by KODE_DISTRIBUTOR, 
				NAMA_DISTRIBUTOR,
				KD_CUSTOMER,
				NAMA_TOKO,
				ALAMAT,
				NAMA_DISTRIK,
				NAMA_PROVINSI,
				NAMA_AREA,
				NEW_REGION,
				ID_SALES,
				NAMA_SALES,
				NAMA_TSO,
				NAMA_ASM,
				NAMA_RSM,
				NAMA_GSM,
				CREATE_DATE
			ORDER BY KD_CUSTOMER, NAMA_TOKO";
			//print_r($sql);
			//exit;
			return $this->db->query($sql)->result_array();
		}
	
}

?>
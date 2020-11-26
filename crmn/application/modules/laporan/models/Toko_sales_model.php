<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Toko_sales_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data($id_tso,$bulan ,$tahun)
	{	
		$sql =" 
			SELECT
			T.*,
			NVL(TD.JML_KUNJUNGAN, 0)  AS JML_TOKO_DIKUNJUNGI_BULANAN,
			CASE WHEN NVL(TD.JML_KUNJUNGAN, 0) = 0 THEN 'Belum dikunjungi' WHEN NVL(TD.JML_KUNJUNGAN, 0) >= 1 THEN 'Sudah dikunjungi' END AS STATUS
			FROM T_TOKO_SALES_TSO T
			LEFT JOIN   (
							SELECT
							ID_TOKO,
                            KODE_DISTRIBUTOR,
							JML_KUNJUNGAN   
							FROM T_TOKO_DIKUNJUNGI
							WHERE TAHUN='$tahun'
							AND BULAN='$bulan'
						) TD ON T.KD_CUSTOMER=TD.ID_TOKO
                        AND T.KODE_DISTRIBUTOR=TD.KODE_DISTRIBUTOR
			WHERE T.ID_TSO='$id_tso'
			AND NAMA_TOKO IS NOT NULL
		";
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_asm($id_tso,$bulan ,$tahun)
	{	
		$sql =" 
			SELECT
			T.*,
			NVL(TD.JML_KUNJUNGAN, 0)  AS JML_TOKO_DIKUNJUNGI_BULANAN,
			CASE WHEN NVL(TD.JML_KUNJUNGAN, 0) = 0 THEN 'Belum dikunjungi' WHEN NVL(TD.JML_KUNJUNGAN, 0) >= 1 THEN 'Sudah dikunjungi' END AS STATUS
			FROM T_TOKO_SALES_TSO T
			LEFT JOIN   (
							SELECT
							ID_TOKO,
							JML_KUNJUNGAN   
							FROM T_TOKO_DIKUNJUNGI
							WHERE TAHUN='$tahun'
							AND BULAN='$bulan'
						) TD ON T.KD_CUSTOMER=TD.ID_TOKO
			WHERE T.ID_TSO IN (SELECT ID_SO FROM HIRARCKY_GSM_TO_SO WHERE ID_SM='$id_tso')
			AND NAMA_TOKO IS NOT NULL
		";
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_rsm($ID_USER,$bulan ,$tahun)
	{	
		$sql =" 
			SELECT
			T.*,
			NVL(TD.JML_KUNJUNGAN, 0)  AS JML_TOKO_DIKUNJUNGI_BULANAN,
			CASE WHEN NVL(TD.JML_KUNJUNGAN, 0) = 0 THEN 'Belum dikunjungi' WHEN NVL(TD.JML_KUNJUNGAN, 0) >= 1 THEN 'Sudah dikunjungi' END AS STATUS
			FROM T_TOKO_SALES_TSO T
			LEFT JOIN   (
							SELECT
							ID_TOKO,
							JML_KUNJUNGAN   
							FROM T_TOKO_DIKUNJUNGI
							WHERE TAHUN='$tahun'
							AND BULAN='$bulan'
						) TD ON T.KD_CUSTOMER=TD.ID_TOKO
			WHERE T.ID_TSO IN (SELECT ID_SO FROM HIRARCKY_GSM_TO_SO WHERE ID_SSM='$ID_USER')
			AND NAMA_TOKO IS NOT NULL
		";
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_dis($id_dis,$bulan=null ,$tahun=null)
	{	
		$sql ="
			SELECT
			T.*,
			NVL(TD.JML_KUNJUNGAN, 0)  AS JML_TOKO_DIKUNJUNGI_BULANAN,
			CASE WHEN NVL(TD.JML_KUNJUNGAN, 0) = 0 THEN 'Belum dikunjungi' WHEN NVL(TD.JML_KUNJUNGAN, 0) >= 1 THEN 'Sudah dikunjungi' END AS STATUS
			FROM T_TOKO_SALES_TSO T
			LEFT JOIN   (
							SELECT
							ID_TOKO,
							JML_KUNJUNGAN   
							FROM T_TOKO_DIKUNJUNGI
							WHERE TAHUN='$tahun'
							AND BULAN='$bulan'
							AND KODE_DISTRIBUTOR IN (SELECT
															KODE_DISTRIBUTOR
															FROM CRMNEW_USER_DISTRIBUTOR
															WHERE DELETE_MARK='0'
															AND ID_USER='$id_dis')
						) TD ON T.KD_CUSTOMER=TD.ID_TOKO
			WHERE NAMA_TOKO IS NOT NULL
            AND KODE_DISTRIBUTOR IN (SELECT
															KODE_DISTRIBUTOR
															FROM CRMNEW_USER_DISTRIBUTOR
															WHERE DELETE_MARK='0'
															AND ID_USER='$id_dis')
			";
			//echo $sql;
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_admin($bulan ,$tahun,$region=null,$id_prov=null,$id_area=null)
	{	
		$sql =" 
			SELECT
			T.*,
			NVL(TD.JML_KUNJUNGAN, 0)  AS JML_TOKO_DIKUNJUNGI_BULANAN,
			CASE WHEN NVL(TD.JML_KUNJUNGAN, 0) = 0 THEN 'Belum dikunjungi' WHEN NVL(TD.JML_KUNJUNGAN, 0) >= 1 THEN 'Sudah dikunjungi' END AS STATUS
			FROM T_TOKO_SALES_TSO T
			LEFT JOIN   (
							SELECT
							ID_TOKO,
							JML_KUNJUNGAN   
							FROM T_TOKO_DIKUNJUNGI
							WHERE TAHUN='$tahun'
							AND BULAN='$bulan'
						) TD ON T.KD_CUSTOMER=TD.ID_TOKO
			WHERE T.NAMA_TOKO IS NOT NULL
		";
		
		if($region!=null){
			$sql .= " AND T.NEW_REGION ='$region' ";
		}
		
		if($id_prov!=null){
			$sql .= " AND T.ID_PROVINSI ='$id_prov' ";
		}
		
		if($id_area!=null){
			$sql .= " AND T.KD_AREA ='$id_area' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_kode_dis($id_user){
			
			$sql ="
				SELECT
					KODE_DISTRIBUTOR
				FROM 
					M_SALES_USER_DISTRIBUTOR
				WHERE
				ID_USER_DISTRIBUTOR = '$id_user'
				GROUP BY KODE_DISTRIBUTOR
			";
			
			return $this->db->query($sql)->result_array();	
	}
	
	public function get_kode_tso($id_dis){
			
			$sql ="
				SELECT
					ID_SO
				FROM 
					HIRARCKY_GSM_SALES_DISTRIK
				WHERE
				KODE_DISTRIBUTOR IN ('$id_dis')
                AND ID_SO IS NOT NULL
				GROUP BY ID_SO
			";
			
			return $this->db->query($sql)->result_array();	
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
	
	public function Get_provinsi_all(){
		
		$sql ="
			SELECT DISTINCT 
				ID_PROVINSI,
				NAMA_PROVINSI 
			FROM 
				CRMNEW_M_PROVINSI
			ORDER BY NAMA_PROVINSI ASC
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function Get_area_all(){
		
		$sql ="
			SELECT DISTINCT 
				KD_AREA,
				NM_AREA
			FROM 
				HIRARCKY_GSM_SALES_DISTRIK
			ORDER BY NM_AREA ASC
		";
		
		return $this->db->query($sql)->result();
	}
}
?>
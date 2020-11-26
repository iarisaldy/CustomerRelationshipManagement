<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Report_sellin_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('SCM', TRUE);
	}
	public function User_distributor($id_user=null, $jenis=null){
		$sql ="
			SELECT
			KODE_DISTRIBUTOR
			FROM HIRARCKY_GSM_TO_DISTRIBUTOR		
		";

		if($jenis!=null){
			if($jenis=='SO'){
				$sql .= " WHERE ID_SO='$id_user' ";
			}
			else if($jenis=='SM'){
				$sql .= " WHERE ID_SM='$id_user' ";
			}
			else if($jenis=='SSM'){	
				$sql .= " WHERE ID_SSM='$id_user' ";
			}
			else if($jenis=='GSM'){
				$sql .= " WHERE ID_GSM='$id_user' ";
			}
			else if($jenis=='DIS'){
				$sql .= "  WHERE KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
			}
		}

		$sql .= " GROUP BY KODE_DISTRIBUTOR ";
		
		return $this->db->query($sql)->result_array();
	}
	public function User_distrik($id_user=null, $jenis=null){
		$sql ="
			SELECT
			ID_DISTRIK
			FROM HIRARCKY_GSM_SO_DISTRIK		
		";

		if($jenis!=null){
			if($jenis=='SO'){
				$sql .= " WHERE ID_SO='$id_user' ";
			}
			else if($jenis=='SM'){
				$sql .= " WHERE ID_SM='$id_user' ";
			}
			else if($jenis=='SSM'){
				$sql .= " WHERE ID_SSM='$id_user' ";
			}
			else if($jenis=='GSM'){
				$sql .= " WHERE ID_GSM='$id_user' ";
			}
			else if($jenis=='SPC'){
				$sql .= "WHERE REGION_ID IN (SELECT
							ID_REGION
							FROM CRMNEW_USER_REGION
							WHERE DELETE_MARK='0'
							AND ID_USER='$id_user') ";
			}
		}

		$sql .= " GROUP BY ID_DISTRIK ";
		
		return $this->db->query($sql)->result_array();
	}
	public function Get_data_gsm_so($id_user, $jenis=null){
		$sql =" 
				SELECT
				NAMA_GSM,
				NAMA_SSM,
				NAMA_SM,
				ID_SO,
				NAMA_SO,
				ID_DISTRIK
				FROM HIRARCKY_GSM_SO_DISTRIK
				";
		if($jenis!=null){
			if($jenis=='SO'){
				$sql .= "WHERE ID_SO='$id_user' ";
			}
			else if($jenis=='SM'){
				$sql .= "WHERE ID_SM='$id_user' ";
			}
			else if($jenis=='SSM'){
				$sql .= "WHERE ID_SSM='$id_user' ";
			}
			else if($jenis=='GSM'){
				$sql .= "WHERE ID_GSM='$id_user' ";
			}
			else if($jenis=='SPC'){
				$sql .= "WHERE REGION_ID IN (SELECT
							ID_REGION
							FROM CRMNEW_USER_REGION
							WHERE DELETE_MARK='0'
							AND ID_USER='$id_user') ";
			}
			else if($jenis=='DIS'){
				$sql .= "WHERE KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
			}
		}	

		$sql .= " GROUP BY
				NAMA_GSM,
				NAMA_SSM,
				NAMA_SM,
				ID_SO,
				NAMA_SO,
				ID_DISTRIK ";

		return $this->db->query($sql)->result_array();
	}
	public function Get_data_gsm_so_DIS($id_user, $jenis=null){
		$sql =" 
				SELECT
				NAMA_GSM,
				NAMA_SSM,
				NAMA_SM,
				ID_SO,
				NAMA_SO,
				ID_DISTRIK
				FROM HIRARCKY_GSM_SALES_DISTRIK
				WHERE KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0' AND ID_USER='$id_user')
				";
		
		$sql .= " GROUP BY
				NAMA_GSM,
				NAMA_SSM,
				NAMA_SM,
				ID_SO,
				NAMA_SO,
				ID_DISTRIK ";

		return $this->db->query($sql)->result_array();
	}
	
	public function Get_data_msc($mulai=null, $selesai=null, $user, $region=null, $provinsi=null, $distributor=null, $jenis=null){
		$dis_user = $this->User_distributor($user, $jenis);
		$n=1;
		$fild = '';
		foreach($dis_user as $d){
			
			if(count($dis_user)>$n){
				$fild .= "'". $d['KODE_DISTRIBUTOR']."',";
			}
			else {
				$fild .= "'". $d['KODE_DISTRIBUTOR']."'";
			}
			$n=$n+1;		
		}

		$distrik_user = $this->User_distrik($user, $jenis);
		$n=1;
		$fild2 = '';
		foreach($distrik_user as $d){
			
			if(count($distrik_user)>$n){
				$fild2 .= "'". $d['ID_DISTRIK']."',";
			}
			else {
				$fild2 .= "'". $d['ID_DISTRIK']."'";
			}
			$n=$n+1;		
		}


		$sql =" 
				 SELECT
				 DTA.KODE_DISTRIBUTOR,
				 DTA.NM_DISTRIBUTOR,
				 DTA.KODE_GUDANG,
				 DTA.REGION,
				 DTA.KODE_PROVINSI,
				 DTA.NM_PROV,
				 DTA.NM_KOTA,
				 DTA.TAHUN,
				 DTA.BULAN,
				 DTA.TANGGAL,
				 DTA.TIPE_ZAK,
				 DTA.JUMLAH,
				 DTA.ID_DISTRIK,
				 DTA.TOTAL_SELLIN,
				 DTA.TGL,
				 DTA.ITEM_NO,
				 DTA.NM_PRODUK
				 FROM   
				        (
				                SELECT 
									A.SOLD_TO AS KODE_DISTRIBUTOR,
									MD.NM_DISTR AS NM_DISTRIBUTOR,
									A.KODE_SHIPTO AS KODE_GUDANG,
									A.PROPINSI_TO AS KODE_PROVINSI,
				                    MP.NM_PROV,
									A.NM_KOTA,
									A.TAHUN,
									A.BULAN,
									A.HARI AS TANGGAL,
									A.ITEM_TYPE AS TIPE_ZAK,
									A.KWANTUM AS JUMLAH,
									K.KD_KOTA AS ID_DISTRIK,
									FLOOR(A.HARGA)AS TOTAL_SELLIN,
				                    MP.ID_SCM_SALESREG2 AS REGION,
				                    CONCAT(CONCAT(A.TAHUN, A.BULAN), A.HARI) AS TGL,
									A.ITEM_NO,
									SC.NM_PRODUK
								FROM ZREPORT_SCM_REAL_SALES_SIDIGI A
				                LEFT JOIN ZREPORT_M_PROVINSI MP ON MP.KD_PROV = A.PROPINSI_TO
								LEFT JOIN ZREPORT_M_KOTA K ON A.KOTA = K.KD_KOTA
								LEFT JOIN ZREPORT_M_AREA MA ON MA.KD_AREA = K.KD_AREA
								LEFT JOIN MASTER_DISTRIBUTOR MD ON A.SOLD_TO=MD.KD_DISTR
								LEFT JOIN CRMNEW_PRODUK_SIDIGI_CRM SC ON A.ITEM_NO=SC.KD_PRODUK
								WHERE K.KD_KOTA IN ($fild2)
								AND A.SOLD_TO IN ($fild)
				        ) DTA
				        WHERE DTA.TGL BETWEEN '$mulai' AND '$selesai'
				";

				if($region!=null){
					 $sql .= " AND DTA.REGION = '$region' ";
				}
				if($provinsi!=null){
		            $sql .= " AND DTA.KODE_PROVINSI = '$provinsi' ";
		        }
		        if($distributor!=null){
		            $sql .= " AND DTA.KODE_DISTRIBUTOR = '$distributor' ";
		        }
			
			//ECHO $sql;
			
			return $this->db2->query($sql)->result_array();

	}

	public function Get_data_msc_DIS($mulai=null, $selesai=null, $user){
		$dis_user = $this->User_distributor($user, 'DIS');
		$n=1;
		$fild = '';
		foreach($dis_user as $d){
			
			if(count($dis_user)>$n){
				$fild .= "'". $d['KODE_DISTRIBUTOR']."',";
			}
			else {
				$fild .= "'". $d['KODE_DISTRIBUTOR']."'";
			}
			$n=$n+1;		
		}


		$sql =" 
				 SELECT
				 DTA.KODE_DISTRIBUTOR,
				 DTA.NM_DISTRIBUTOR,
				 DTA.KODE_GUDANG,
				 DTA.REGION,
				 DTA.KODE_PROVINSI,
				 DTA.NM_PROV,
				 DTA.NM_KOTA,
				 DTA.TAHUN,
				 DTA.BULAN,
				 DTA.TANGGAL,
				 DTA.TIPE_ZAK,
				 DTA.JUMLAH,
				 DTA.ID_DISTRIK,
				 DTA.TOTAL_SELLIN,
				 DTA.TGL,
				 DTA.ITEM_NO,
				 DTA.NM_PRODUK
				 FROM   
				        (
				                SELECT 
									A.SOLD_TO AS KODE_DISTRIBUTOR,
									MD.NM_DISTR AS NM_DISTRIBUTOR,
									A.KODE_SHIPTO AS KODE_GUDANG,
									A.PROPINSI_TO AS KODE_PROVINSI,
				                    MP.NM_PROV,
									A.NM_KOTA,
									A.TAHUN,
									A.BULAN,
									A.HARI AS TANGGAL,
									A.ITEM_TYPE AS TIPE_ZAK,
									A.KWANTUM AS JUMLAH,
									K.KD_KOTA AS ID_DISTRIK,
									FLOOR(A.HARGA)AS TOTAL_SELLIN,
				                    MP.ID_SCM_SALESREG2 AS REGION,
				                    CONCAT(CONCAT(A.TAHUN, A.BULAN), A.HARI) AS TGL,
									A.ITEM_NO,
									SC.NM_PRODUK
								FROM ZREPORT_SCM_REAL_SALES_SIDIGI A
				                LEFT JOIN ZREPORT_M_PROVINSI MP ON MP.KD_PROV = A.PROPINSI_TO
								LEFT JOIN ZREPORT_M_KOTA K ON A.KOTA = K.KD_KOTA
								LEFT JOIN ZREPORT_M_AREA MA ON MA.KD_AREA = K.KD_AREA
								LEFT JOIN MASTER_DISTRIBUTOR MD ON A.SOLD_TO=MD.KD_DISTR
								LEFT JOIN CRMNEW_PRODUK_SIDIGI_CRM SC ON A.ITEM_NO=SC.KD_PRODUK
								WHERE A.SOLD_TO IN ($fild)
				        ) DTA
				        WHERE DTA.TGL BETWEEN '$mulai' AND '$selesai'
				";
			
			//ECHO $sql;
			
			return $this->db2->query($sql)->result_array();

	}


	
	public function get_data_scm($tanggal, $bulan, $tahun, $fild, $region=null, $provinsi=null)
	{	
		$sql =" 
				SELECT 
					A.SOLD_TO AS KODE_DISTRIBUTOR,
					A.KODE_SHIPTO AS KODE_GUDANG,
					A.PROPINSI_TO AS KODE_PROVINSI,
					A.NM_KOTA,
					A.TAHUN,
					A.BULAN,
					A.HARI AS TANGGAL,
					A.ITEM_TYPE AS TIPE_ZAK,
					A.ITEM_NO,
					A.KWANTUM AS JUMLAH,
					K.KD_KOTA AS ID_DISTRIK,
					FLOOR(A.HARGA)AS TOTAL_SELLIN,
                    MP.ID_SCM_SALESREG2 AS REGION,
					SC.NM_PRODUK
				FROM ZREPORT_SCM_REAL_SALES_SIDIGI A
                LEFT JOIN ZREPORT_M_PROVINSI MP ON MP.KD_PROV = A.PROPINSI_TO
				LEFT JOIN ZREPORT_M_KOTA K ON A.KOTA = K.KD_KOTA
				LEFT JOIN ZREPORT_M_AREA MA ON MA.KD_AREA = K.KD_AREA
				LEFT JOIN CRMNEW_PRODUK_SIDIGI_CRM SC ON A.ITEM_NO=SC.KD_PRODUK
				WHERE A.TAHUN = '$tahun'
				AND A.BULAN = '$bulan'
				AND A.HARI = '$tanggal'
				AND A.SOLD_TO IN ($fild)
				";
				
		if($provinsi!=null){
            $sql .= " AND A.PROPINSI_TO = '$provinsi' ";
        }
		
		if($region!=null){
            $sql .= " AND MP.ID_SCM_SALESREG2 = '$region' ";
        }
		
		
		//ECHO $sql;
				
		return $this->db2->query($sql)->result_array();
		
	}
	
	public function get_data_crm($id_dis=null)
	{	
		$sql ="
			SELECT DISTINCT
				KODE_DISTRIBUTOR,
				NAMA_DISTRIBUTOR,
				ID_PROVINSI,
				NAMA_PROVINSI,
				ID_DISTRIK,
				NAMA_SO,
				NAMA_SM,
				NAMA_SSM,
				NAMA_GSM
			FROM
				HIRARCKY_GSM_SALES_DISTRIK
			";
			
		if($id_dis!=null){
            $sql .= " WHERE KODE_DISTRIBUTOR = '$id_dis' ";
        }
				
		return $this->db->query($sql)->result_array();
		
	}
	
	public function get_data_distributor()
	{	
		$sql =" 
			SELECT DISTINCT
			KODE_DISTRIBUTOR
			FROM
			HIRARCKY_GSM_SALES_DISTRIK
			WHERE KODE_DISTRIBUTOR IS NOT NULL
				";
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
	public function Get_region_SPC($ID_USER){
		
		$sql ="
			SELECT
			ID_REGION AS NEW_REGION
			FROM CRMNEW_USER_REGION
			WHERE DELETE_MARK='0'
			AND ID_USER='$ID_USER' 
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
			$sql .= " AND ID_PROVINSI = '$id_provinsi'";
		}
		
		return $this->db->query($sql)->result();
	}
}
?>
<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Visit_plan_log_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data($idsales =null, $tahun =null, $bulan =null, $USER)
	{
		$sql =" 
			SELECT 
			NAMA_SALES,
			NAMA_DISTRIBUTOR,
			TAHUN,
			BULAN,
			CASE STATUS WHEN 0 THEN 'Pending' WHEN 1 THEN 'Sukses' END AS STATUS
			FROM T_VISIT_PLAN_BULANAN_LOG
			WHERE ID_SALES IN (SELECT ID_SALES FROM SALES_TO_SO WHERE ID_SO = '$USER')
			 
		";
		
		if($idsales!=null){
			$sql .= " AND ID_SALES = '$idsales' ";
		}
		if($tahun!=null){
			$sql .= " AND TAHUN = '$tahun' ";
		}
		if($bulan!=null){
			$sql .= " AND BULAN = '$bulan' ";
		}
		//echo $sql;
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_admin($tahun =null, $bulan =null)
	{
		$sql =" 
			SELECT 
			NO_LOG,
			NAMA_SALES,
			ID_SALES,
			NAMA_DISTRIBUTOR,
			KODE_DISTRIBUTOR,
			TAHUN,
			BULAN,
			CASE STATUS WHEN 0 THEN 'Pending' WHEN 1 THEN 'Sukses' END AS STATUS
			FROM T_VISIT_PLAN_BULANAN_LOG
			WHERE STATUS = 0 
		";
		
		
		if($tahun!=null){
			$sql .= " AND TAHUN = '$tahun' ";
		}
		if($bulan!=null){
			$sql .= " AND BULAN = '$bulan' ";
		}
		return $this->db->query($sql)->result_array();
	}
	
	public function User_SALES($id_user=null){
        $sql ="
            SELECT DISTINCT
            ID_SALES,
            NAMA_SALES
            FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SALES IS NOT NULL
        ";
        
        if($id_user!=null){
            $sql .= " AND ID_SO='$id_user' ORDER BY NAMA_SALES ASC";
        }
        
        return $this->db->query($sql)->result();
    }
	
	public function User_SALES_all(){
        $sql ="
            SELECT DISTINCT
            ID_SALES,
            NAMA_SALES
            FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SALES IS NOT NULL
        ";
        
        return $this->db->query($sql)->result();
    }
	
	public function User_distributor(){
		$sql ="
			SELECT DISTINCT
			UD.KODE_DISTRIBUTOR,
			D.NAMA_DISTRIBUTOR
			FROM CRMNEW_USER_DISTRIBUTOR UD
			LEFT JOIN CRMNEW_DISTRIBUTOR D ON UD.KODE_DISTRIBUTOR=D.KODE_DISTRIBUTOR
			WHERE UD.DELETE_MARK='0'
			AND D.FLAG = 'SBI'
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function dis_sales($id_dis){
        $sql ="
			SELECT ID_USER ,NAMA FROM HIRARCKY_GSM_SALES_DISTRIK WHERE KODE_DISTRIBUTOR = '$id_dis'
		";
        
        return $this->db->query($sql)->result_array();   
    }
	
	public function insert_data($id_sales,$tahun,$bulan,$USER)
	{
		//pengecekan Data
		$cek = $this->get_data($id_sales,$tahun,$bulan,$USER);
		if(count($cek)<1){
			$sql ="
				INSERT INTO
					CRMNEW_VISIT_PLAN_LOG(ID_SALES,TAHUN,BULAN,DELETE_MARK,CREATE_BY,CREATE_DATE,STATUS)
				VALUES 
					('$id_sales','$tahun','$bulan','0','$USER',SYSDATE,'0')
			";
			
			$hasil = $this->db->query($sql);
		}
		
		return $hasil;
	}
	
	public function update_data($no, $USER)
	{
		
		$sql_log = "
			INSERT INTO CRMNEW_KUNJUNGAN_CUSTOMER
			(ID_USER, ID_TOKO, TGL_RENCANA_KUNJUNGAN, DELETED_MARK, KETERANGAN, FLAG_VISIT_PLANT)
			SELECT
				ID_USER,
				ID_TOKO,
				TGL_RENCANA_KUNJUNGAN,
				DELETED_MARK,
				KETERANGAN,
				FLAG_VISIT_PLANT
			FROM SCHEDULER_VISIT_PLANT
			WHERE FLAG_VISIT_PLANT='$no'
			
			";
		
		$SCHEDULLER = $this->db->query($sql_log);
		IF($SCHEDULLER){
			
		}
		
		$sql ="
				UPDATE 
					CRMNEW_VISIT_PLAN_LOG
				SET
					STATUS = '1',
                    UPDATE_DATE = SYSDATE,
                    UPDATE_BY = '$USER'
				WHERE 
					NO_LOG ='$no'
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function hapus_data($no, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_VISIT_PLAN_LOG
				SET
					DELETE_MARK = '1',
                    UPDATE_DATE = SYSDATE,
                    UPDATE_BY = '$USER'
				WHERE 
					NO_LOG ='$no'
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
}
?>
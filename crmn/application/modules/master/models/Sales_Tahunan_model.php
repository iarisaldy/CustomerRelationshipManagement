<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Sales_Tahunan_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data($idsales =null , $USER)
	{
		$sql =" 
			SELECT 
				A.NO_JADWAL,
				A.ID_SALES,
				C.USERNAME AS NAMA,
				A.ID_CUSTOMER,
				B.NAMA_TOKO,
				A.ID_DISTRIBUTOR,
				A.SUN,
				A.MON,
				A.TUE,
				A.WED,
				A.THU,
				A.FRI,
				A.SAT,
				A.W1,
				A.W2,
				A.W3,
				A.W4,
				A.W5
			FROM CRMNEW_JADWAL_SALES A
			LEFT JOIN M_CUSTOMER B ON A.ID_CUSTOMER = B.ID_CUSTOMER AND A.ID_DISTRIBUTOR=B.ID_DISTRIBUTOR
			LEFT JOIN CRMNEW_USER C ON A.ID_SALES = C.ID_USER
			WHERE A.DELETE_MARK = '0'
                AND A.ID_SALES IN (SELECT ID_SALES FROM HIRARCKY_GSM_SALES_DISTRIK WHERE ID_SO='$USER' GROUP BY ID_SALES)
		";
		
		if($idsales!=null){
			$sql .= " AND A.ID_SALES = '$idsales' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_jadwal($nojadwal)
	{
		$sql =" 
			SELECT 
				CRMNEW_JADWAL_SALES.ID_SALES,
				CRMNEW_CUSTOMER.ID_CUSTOMER,
				CRMNEW_JADWAL_SALES.ID_DISTRIBUTOR,
				CRMNEW_JADWAL_SALES.SUN,
				CRMNEW_JADWAL_SALES.MON,
				CRMNEW_JADWAL_SALES.TUE,
				CRMNEW_JADWAL_SALES.WED,
				CRMNEW_JADWAL_SALES.THU,
				CRMNEW_JADWAL_SALES.FRI,
				CRMNEW_JADWAL_SALES.SAT,
				CRMNEW_JADWAL_SALES.W1,
				CRMNEW_JADWAL_SALES.W2,
				CRMNEW_JADWAL_SALES.W3,
				CRMNEW_JADWAL_SALES.W4,
				CRMNEW_JADWAL_SALES.W5
				FROM CRMNEW_JADWAL_SALES 
				LEFT JOIN CRMNEW_CUSTOMER ON CRMNEW_JADWAL_SALES.ID_CUSTOMER = CRMNEW_CUSTOMER.ID_CUSTOMER
				WHERE NO_JADWAL = '$nojadwal'
		";
		return $this->db->query($sql)->result();
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
	public function Toko_sales($id_sales){
        $sql ="
			SELECT
			KD_CUSTOMER,
			NAMA_TOKO,
			KODE_DISTRIBUTOR
			FROM
			MAPPING_TOKO_SALES 
			WHERE ID_SALES = '$id_sales' 
			AND NAMA_TOKO IS NOT NULL
			AND KD_CUSTOMER NOT IN (SELECT ID_CUSTOMER FROM CRMNEW_JADWAL_SALES WHERE ID_SALES='$id_sales' AND ID_CUSTOMER IS NOT NULL AND DELETE_MARK = '0')
		";
        
        return $this->db->query($sql)->result_array();   
    }
	
	public function update_data($no,$sun,$mon,$tue,$wed,$thu,$fri,$sat,$w1,$w2,$w3,$w4,$w5, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_JADWAL_SALES
				SET
					SUN = '$sun',
                    MON = '$mon',
                    TUE = '$tue',
                    WED = '$wed',
                    THU = '$thu',
                    FRI = '$fri',
                    SAT = '$sat',
                    W1 = '$w1',
                    W2 = '$w2',
                    W3 = '$w3',
                    W4 = '$w4',
					W5 = '$w5',
                    UPDATE_AT = SYSDATE,
                    UPDATE_BY = '$USER'
				WHERE 
					NO_JADWAL ='$no'
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	public function insert_data($idsales,$idcustomer,$dis,$sun,$mon,$tue,$wed,$thu,$fri,$sat,$w1,$w2,$w3,$w4,$w5, $USER)
	{
		
		$sql ="
			INSERT INTO
				CRMNEW_JADWAL_SALES(
					ID_SALES,
					ID_CUSTOMER,
					ID_DISTRIBUTOR,
					SUN,
					MON,
					TUE,
					WED,
					THU,
					FRI,
					SAT,
					W1,
					W2,
					W3,
					W4,
					W5,
					DELETE_MARK,
					INSERT_BY,
					INSERT_AT
				)
			VALUES 
				('$idsales','$idcustomer','$dis','$sun','$mon','$tue','$wed','$thu','$fri','$sat','$w1','$w2','$w3','$w4','$w5','0','$USER',SYSDATE)
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function hapus_data($no, $USER)
	{
		
		$sql ="
		UPDATE CRMNEW_JADWAL_SALES
		SET 
			DELETE_MARK='1',
			UPDATE_AT=SYSDATE,
			UPDATE_BY='$USER'
		WHERE
			NO_JADWAL ='$no'
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
}
?>
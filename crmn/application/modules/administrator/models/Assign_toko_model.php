<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Assign_toko_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function User_SALES($id_user=null){
        $sql ="
            SELECT
			US.ID_SALES,
			US.NAMA_SALES AS NAMA
			FROM SALES_TO_SO US
			
        ";
        
        if($id_user!=null){
            $sql .= " WHERE US.ID_SO='$id_user'
						ORDER BY ID_SALES  ";
        }
        
        return $this->db->query($sql)->result();
    }
    public function Toko_sales_tso($id_user=null, $sales=null){
        /*$sql ="
            SELECT
			MS.KD_CUSTOMER AS ID_CUSTOMER,
			MS.NAMA_TOKO,
			MS.ALAMAT,
			MS.KODE_DISTRIBUTOR AS ID_DISTRIBUTOR,
			MS.NAMA_DISTRIBUTOR AS NAMA_DISTRIBUTOR,
			MS.ID_AREA,
			MS.NAMA_AREA,
			MS.NM_KOTA AS NAMA_DISTRIK
			FROM MAPPING_TOKO_SALES MS
			WHERE ID_SALES='$sales'                
        ";*/
		$sql ="
            SELECT
			ID_CUSTOMER,
			NAMA_TOKO,
			ALAMAT,
			ID_DISTRIBUTOR,
			NAMA_DISTRIBUTOR,
			ID_AREA,
			NAMA_AREA,
			NAMA_DISTRIK
			FROM M_CUSTOMER 
			WHERE ID_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM SALES_DISTRIBUTOR WHERE ID_SALES='$sales')
			AND ID_CUSTOMER NOT IN (SELECT KD_CUSTOMER FROM CRMNEW_TOKO_SALES
									WHERE ID_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM SALES_DISTRIBUTOR WHERE ID_SALES='$sales')
									AND DELETE_MARK='0' GROUP BY KD_CUSTOMER)               
					";
					
		//ECHO $sql;
        
        return $this->db->query($sql)->result();   
    }
    public function addAssign($data){
        $this->db->insert_batch("CRMNEW_TOKO_SALES", $data);
        if($this->db->affected_rows()){
            return $data;
        } else {
            return false;
        }
    }
	public function get_distributor($sales=null){
		if($sales!=null){
			 $sql ="
				SELECT KODE_DISTRIBUTOR FROM SALES_DISTRIBUTOR WHERE ID_SALES='$sales'
				";
			
			$hasil = $this->db->query($sql)->result_array();
			if(count($hasil)==1){
				return $hasil[0]['KODE_DISTRIBUTOR'];
			}
		}
	}

    public function listAssignSALES($id_user){
        /*
        $sql =" 
			SELECT
			
            TS.NO_TOKO_SALES,
			TS.ID_SALES,
			TS.NAMA AS NAMA_SALES,
			TS.KD_CUSTOMER,
			TS.NAMA_TOKO,
			TS.NM_KOTA AS KOTA,
			TS.ALAMAT,
			TS.KODE_DISTRIBUTOR AS ID_DISTRIBUTOR,
			TS.NAMA_DISTRIBUTOR,
            SS.ID_SO AS ID_TSO,
            SS.NAMA_SO AS NAMA_TSO
			FROM SALES_TO_SO SS 
            LEFT JOIN MAPPING_TOKO_SALES TS ON SS.ID_SALES=TS.ID_SALES
            
			WHERE SS.ID_SO='$id_user' 
        ";*/
		$sql =" 
			SELECT
			
            TS.NO_TOKO_SALES,
			TS.ID_SALES,
			TS.NAMA AS NAMA_SALES,
			TS.KD_CUSTOMER,
			TS.NAMA_TOKO,
			TS.NM_KOTA AS KOTA,
			TS.ALAMAT,
			TS.KODE_DISTRIBUTOR AS ID_DISTRIBUTOR,
			TS.NAMA_DISTRIBUTOR
			FROM MAPPING_TOKO_SALES TS 
            
			WHERE TS.ID_DISTRIK IN (SELECT KD_KOTA FROM DISTRIK_TSO WHERE ID_USER='$id_user')
        ";
        // ECHO $sql;

        return $this->db->query($sql)->result();        
    }
    public function deleteAssign($idAssign, $data){
        $date = date('Y-m-d H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss')", false);
        $this->db->where("NO_TOKO_SALES", $idAssign)->update("CRMNEW_TOKO_SALES", $data);
        if($this->db->affected_rows()){
            return $data;
        } else {
            return false;
        }
    }
    

    
}
?>
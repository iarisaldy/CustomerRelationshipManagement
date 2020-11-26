<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Upload_Project_model extends CI_Model {
    
    function __construct() { 
        parent::__construct();
        $this->load->database();
    }
	
	public function cekDataProject($PROJECT_NAME, $START_PROJECT, $END_PROJECT, $KECAMATAN, $DISTRIK, $AREA, $PROVINSI, $REGION, $VOLUME){
		$sql = "
			SELECT
				*
			FROM
				CRMNEW_UPLOAD_PROJECT_TOKO
			WHERE
				PROJECT_NAME = '$PROJECT_NAME'
				AND TO_CHAR(START_PROJECT, 'YYYYMMDD') = '$START_PROJECT'
				AND TO_CHAR(END_PROJECT, 'YYYYMMDD') = '$END_PROJECT'
				AND KECAMATAN = TO_NUMBER('$KECAMATAN')
				AND DISTRIK = TO_NUMBER('$DISTRIK')
				AND AREA = TO_NUMBER('$AREA')
				AND PROVINSI = TO_NUMBER('$PROVINSI')
				AND REGION = TO_NUMBER('$REGION')
		";
		return $this->db->query($sql)->row();
	}
	
	public function cek_id_sales($id_sales){
		$sql = "
			SELECT  
				ID_USER as ID_SALES, NAMA as NAMA_SALES, USERNAME as UNAME
			FROM CRMNEW_USER 
			WHERE ID_JENIS_USER = '1015' AND DELETED_MARK = 0
			AND ID_USER = '$id_sales'
		";
		return $this->db->query($sql)->row();
	}
	
	public function cek_id_toko($id_toko){
		$sql = "
			SELECT * FROM VIEW_DATA_TOKO_CUSTOMER
			WHERE ID_CUSTOMER = '$id_toko'
		";
		return $this->db->query($sql)->row();
	}
	
	public function cek_id_distributor($id_distributor){
		$sql = "
			SELECT DISTINCT(KODE_DISTRIBUTOR) as KD, NAMA_DISTRIBUTOR FROM CRMNEW_DISTRIBUTOR 
			WHERE DELETE_MARK = 0 AND KODE_DISTRIBUTOR = '$id_distributor'
		";
		return $this->db->query($sql)->row();
	}
	
	public function cek_kesesuaian_data_sales($id_sales, $id_distributor){
		$sql = "
			SELECT DISTINCT(ID_USER) AS ID_SALES, KODE_DISTRIBUTOR
			FROM CRMNEW_USER_DISTRIBUTOR 
			WHERE 
				KODE_DISTRIBUTOR = '$id_distributor' AND
				ID_USER =  '$id_sales'
		";
		return $this->db->query($sql)->row();
		//SALES_DISTRIBUTOR NAMA_SALES, ,NAMA_DISTRIBUTOR 
	}
	
	public function cek_kesesuaian_data_toko($id_toko, $id_distributor){
		$sql = "
			SELECT ID_CUSTOMER, NAMA_TOKO, ID_DISTRIBUTOR 
			FROM M_CUSTOMER
			WHERE 
				ID_CUSTOMER = '$id_toko' AND
				ID_DISTRIBUTOR =  '$id_distributor'
		";
		return $this->db->query($sql)->row();
	}
	
	public function ready_mapping_toko($id_sales, $id_toko, $id_distributor){
		//CRMNEW_TOKO_SALES
		$sql = "
			SELECT ID_SALES, ID_CUSTOMER AS KD_CUSTOMER 
			FROM MAPPING_TOKO_DIST_SALES
			WHERE 
				ID_CUSTOMER = '$id_toko' AND
				ID_SALES =  '$id_sales' and ID_SALES IS NOT NULL and
				ID_DISTRIBUTOR = '$id_distributor'
				 
		";
		return $this->db->query($sql)->row();
	}
	
	public function cek_do_replacing_mapping($id_toko, $id_sales, $id_distributor){
		$set_return = '4-0-4';
		// 0: no replace, // 1: do replace
		
		$sql_cek = "
			SELECT * 
			FROM MAPPING_TOKO_DIST_SALES
			WHERE 
				ID_CUSTOMER = '$id_toko' AND
				ID_DISTRIBUTOR = '$id_distributor' 
		";
		$hasil = $this->db->query($sql_cek)->result();
		$tot_data = count($hasil);
		if($tot_data > 0){
			$set_return = "Persetujuan Re-mapping!, dari id sales: ";
			$list_sales = '';
			$i= 1;
			foreach($hasil as $dt_geting){
				if($id_sales != $dt_geting->ID_SALES and $dt_geting->ID_SALES != null){
					if($i < $tot_data){
						$list_sales = $list_sales.$dt_geting->ID_SALES.',';
					} else {
						$list_sales = $list_sales.$dt_geting->ID_SALES;
					}
					$i++;
				} else {
					$set_return = '4-0-4';
				}
			}
			$set_return .= $list_sales;
		} 
		
		return $set_return;
	}
	
	public function do_repalacing_data_mapping($data){
		$status_true  = 0;
		$status_false = 0;
		
		//print_r($data);
		//exit();
		
		foreach($data as $d){
			$id_toko = $d['ID_TOKO'];
			$id_dist = $d['ID_DISTRIBUTOR'];
			$list_id_sales = $d['LIST_SALES'];
			
			$sqlup = "
					UPDATE CRMNEW_TOKO_SALES
					SET 
						DELETE_MARK = 1,
						UPDATE_BY = '1009', 
						UPDATE_DATE = SYSDATE
					WHERE 
						KD_CUSTOMER = '$id_toko' and
						ID_DISTRIBUTOR = '$id_dist' and
						ID_SALES in ($list_id_sales)
			";	
			$set = $this->db->query($sqlup);
			
			if($set){
				$status_true++;
			} else {
				$status_false++;
			}
		}
		return $status_true.'_'.$status_false;
	}
	
	public function mapping_toko_batch($id_sales, $id_toko, $id_distributor){
		$retrive = 0;
		$date = date('d-m-Y H:i:s');
		$this->db->trans_start();
        	$this->db->set('CREATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
			$this->db->set('CREATE_BY', '1009');
			$this->db->set('DELETE_MARK', 0);
			$this->db->set('ID_SALES', $id_sales);
			$this->db->set('KD_CUSTOMER', $id_toko);
			$this->db->set('ID_DISTRIBUTOR', $id_distributor); 
        	$this->db->insert("CRMNEW_TOKO_SALES");
		$this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $retrive = 0;
        } else {
            $retrive = 1;
        }
		return $retrive;
	}
}

?>
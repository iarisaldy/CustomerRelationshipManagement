<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Kapasitas_gudang_toko_model extends CI_Model {
		
		public function set_kapasitas_gudang_toko($data_set){
			$status = 0;
			
			$id_customer = $data_set['id_customer'];
			$id_user 	 = $data_set['id_user'];
			
			$kap_zak	 = $data_set['kapasitas_zak'];
			$kap_ton	 = $data_set['kapasitas_ton'];
			
			// echo $id_customer;
			// echo $id_user;
			// echo $ltd;
			// echo $lng;
			
			// exit(); 
			
				//CEK DATA DI DATABASE
				$sql_ceking ="
					SELECT
						*
					FROM CRMNEW_KAPASITAS_TOKO
					WHERE ID_CUSTOMER = '$id_customer'
					AND DELETE_MARK = 0
				";
				
			$ceking = $this->db->query($sql_ceking)->result_array();
			
			// print_r($ceking);
			// exit();
				
			if(count($ceking) == 1){
				//update data
				$sqlup = "
						UPDATE CRMNEW_KAPASITAS_TOKO
						SET 
						KAPASITAS_ZAK = '$kap_zak',
						KAPASITAS_TON = '$kap_ton',
						UPDATE_BY = '$id_user',
						UPDATE_DATE = SYSDATE
						WHERE ID_CUSTOMER = '$id_customer'
						AND DELETE_MARK = 0
				";
					
					$this->db->query($sqlup);
					$status=2;
			} else {
				//insert data
				$sqlin = "
						INSERT INTO CRMNEW_KAPASITAS_TOKO (ID_CUSTOMER, KAPASITAS_ZAK, KAPASITAS_TON, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_customer', '$kap_zak', '$kap_ton', '$id_user', SYSDATE, 0)
					";
					$this->db->query($sqlin);
					$status=1;
			}
			return $status;	
		}
		
		public function get_kapasitas_gudang_toko($id_customer = null){
			$sql = "
				SELECT ID_KAPASITAS_TOKO, ID_CUSTOMER, KAPASITAS_ZAK, KAPASITAS_TON FROM CRMNEW_KAPASITAS_TOKO 
				WHERE DELETE_MARK = 0
			";
			
			if($id_customer!=null){
				$sql .= " AND ID_CUSTOMER IN ($id_customer) "; 
			}
			
			$list_data = $this->db->query($sql);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return false;
            }
		}
		
		public function set_kapasitas_gudang_toko_array($id_user, $kapasitasToko){
			$datacustomer = array();
			$getDatain = "";
			$i = 0;
			foreach($kapasitasToko as $dt){
				
				$id_cus = $dt['ID_CUSTOMER'];
				$kap_sak = $dt['KAPASITAS_ZAK'];
				$kap_ton = $dt['KAPASITAS_TON'];
				
				//CEK DATA DI DATABASE
				$sql_ceking ="
					SELECT
						*
					FROM CRMNEW_KAPASITAS_TOKO
					WHERE ID_CUSTOMER = '$id_cus'
					AND DELETE_MARK = 0
				";	
				$ceking = $this->db->query($sql_ceking)->result_array();
				
				if(count($ceking) == 1){
					$sqlin = "
						UPDATE CRMNEW_KAPASITAS_TOKO
						SET 
						KAPASITAS_ZAK 	= $kap_sak,
						KAPASITAS_TON 	= $kap_ton,
						UPDATE_BY 		= '$id_user',
						UPDATE_DATE 	= SYSDATE
						WHERE 
							ID_CUSTOMER 	= '$id_cus'
							AND DELETE_MARK 	= 0
					";
					$this->db->query($sqlin);
				} else {
					
					$sqlin = "
						INSERT INTO CRMNEW_KAPASITAS_TOKO (ID_CUSTOMER, KAPASITAS_ZAK, KAPASITAS_TON, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_cus', '$kap_sak', '$kap_ton', '$id_user', SYSDATE, 0)
					";
					$this->db->query($sqlin);
				}
				
				// set data idcutomer balikan
				$i++;
				if($i == count($kapasitasToko)){
					$getDatain .= $id_cus;
				} else {
					$getDatain .= $id_cus.",";
				}
				
			}
			
			//print_r($getDatain);
			//exit;
			
			//get data after input --
			$sqlget = "
				SELECT ID_KAPASITAS_TOKO, ID_CUSTOMER, KAPASITAS_ZAK, KAPASITAS_TON
				FROM CRMNEW_KAPASITAS_TOKO
    			WHERE ID_CUSTOMER IN ($getDatain) AND DELETE_MARK = 0
			";
			$list_data = $this->db->query($sqlget);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return false;
            }
		}
		
	}
?>
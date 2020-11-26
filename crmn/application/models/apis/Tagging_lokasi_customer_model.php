<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Tagging_lokasi_customer_model extends CI_Model {
		
		public function set_tangging_lokasi($data_set){
			$status = 0;
			
			$id_customer = $data_set['id_customer'];
			$id_user 	 = $data_set['id_user'];
			$ltd		 = $data_set['ltd'];
			$lng		 = $data_set['lng'];
			
			// echo $id_customer;
			// echo $id_user;
			// echo $ltd;
			// echo $lng;
			
			// exit(); 
			
				//CEK DATA DI DATABASE
				$sql_ceking ="
					SELECT
						ID_CUSTOMER
					FROM CRMNEW_LOKASI_CUSTOMER
					WHERE ID_CUSTOMER = '$id_customer'
					AND DELETE_MARK = 0
				";
				
			$ceking = $this->db->query($sql_ceking)->result_array();
				
			if(count($ceking) == 1){
				//update data
				$sqlup = "
						UPDATE CRMNEW_LOKASI_CUSTOMER
						SET 
						LATITUDE = '$ltd',
						LONGITUDE = '$lng',
						CREATE_BY = '$id_user',
						CREATE_DATE = SYSDATE
						WHERE ID_CUSTOMER = '$id_customer'
						AND DELETE_MARK=0
					";
					
					$this->db->query($sqlup);
					$status=1;
			} else {
				//insert data
				$sqlin = "
						INSERT INTO CRMNEW_LOKASI_CUSTOMER (ID_CUSTOMER, LATITUDE, LONGITUDE, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_customer', '$ltd', '$lng', '$id_user', SYSDATE, 0)
					";
					$this->db->query($sqlin);
					$status=1;
			}
			
			return $status;
				
		}
		
		public function set_TaggingToko_array($id_user, $dataLokasi){
			$datacustomer = array();
			$getDatain = "";
			$i = 0;
			
			foreach($dataLokasi as $dt){
				
				$id_cus = $dt['ID_CUSTOMER'];
				$ltd 	= $dt['LATITUDE'];
				$lng 	= $dt['LONGITUDE'];
				$kl	 	= $dt['KOORDINAT_LOCK'];
				
				//CEK DATA DI DATABASE
				$sql_ceking ="
					SELECT
						*
					FROM CRMNEW_LOKASI_CUSTOMER
					WHERE ID_CUSTOMER = '$id_cus'
					AND DELETE_MARK = 0
				";	
				$ceking = $this->db->query($sql_ceking)->result_array();
				
				if(count($ceking) == 1){
					$sqlin = "
						UPDATE CRMNEW_LOKASI_CUSTOMER
						SET 
						LATITUDE 		= $ltd,
						LONGITUDE 		= $lng,
						KOORDINAT_LOCK	= $kl,
						CREATE_BY 		= '$id_user',
						CREATE_DATE 	= SYSDATE
						WHERE 
							ID_CUSTOMER 	= '$id_cus'
							AND DELETE_MARK = 0
					";
					$this->db->query($sqlin);
				} else {
					$sqlin = "
						INSERT INTO CRMNEW_LOKASI_CUSTOMER (ID_CUSTOMER, LATITUDE, LONGITUDE, KOORDINAT_LOCK, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_cus', '$ltd', '$lng', '$kl', '$id_user', SYSDATE, 0)
					";
					$this->db->query($sqlin);
				}
				
				// set data idcutomer balikan
				$i++;
				if($i == count($dataLokasi)){
					$getDatain .= $id_cus;
				} else {
					$getDatain .= $id_cus.",";
				}
				
			}
			
			//print_r($getDatain);
			//exit;
			
			//get data after input --
			$sqlget = "
				SELECT ID_LOKASI_CUSTOMER, ID_CUSTOMER, LATITUDE, LONGITUDE, KOORDINAT_LOCK
				FROM CRMNEW_LOKASI_CUSTOMER
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
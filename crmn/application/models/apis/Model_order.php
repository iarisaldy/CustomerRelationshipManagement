<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_order extends CI_Model {

		public function AddOrder($id_user, $project){
			$data = array();
			
			//print_r($project);
			//exit();
			
			foreach($project as $d){
			
				$ID_KUNJUNGAN 	= $d['ID_KUNJUNGAN'];
				$ID_PRODUK 		= $d['ID_PRODUK'];
				$JUMLAH_ORDER 	= $d['JUMLAH_ORDER'];
				
				$sqlIn = "
					INSERT INTO CRMNEW_DETILE_PRODUK_ORDER
					(ID_KUNJUNGAN, ID_PRODUK, JUMLAH_ORDER, IS_DELETE)
					VALUES
					('$ID_KUNJUNGAN','$ID_PRODUK','$JUMLAH_ORDER', 0)
				";
				$setIn = $this->db->query($sqlIn);
				
				if($setIn){
					$sqlGet = "
						SELECT ID_ORDER, ID_KUNJUNGAN, ID_PRODUK, JUMLAH_ORDER
						FROM CRMNEW_DETILE_PRODUK_ORDER
						WHERE 
							ID_KUNJUNGAN = '$ID_KUNJUNGAN' AND 
							ID_PRODUK = '$ID_PRODUK' AND
							JUMLAH_ORDER = '$JUMLAH_ORDER'
					";
					$data_get = $this->db->query($sqlGet)->row();
					
					$hasil = array(
						'ID_ORDER'		=> $data_get->ID_ORDER,
						'ID_KUNJUNGAN'	=> $data_get->ID_KUNJUNGAN,
						'ID_PRODUK'		=> $data_get->ID_PRODUK,
						'JUMLAH_ORDER'	=> $data_get->JUMLAH_ORDER
					);
					array_push($data, $hasil);
				}
				
			}
			return $data;
		}
		
		public function UpdateOrder($id_user, $project){
			$data = array();
			
			//print_r($project);
			//exit();
			
			foreach($project as $d){
				
				$ID_ORDER 		= $d['ID_ORDER'];
				$ID_KUNJUNGAN 	= $d['ID_KUNJUNGAN'];
				$ID_PRODUK 		= $d['ID_PRODUK'];
				$JUMLAH_ORDER 	= $d['JUMLAH_ORDER'];
				
				$sqlUp = "
					UPDATE CRMNEW_DETILE_PRODUK_ORDER
					SET 
						ID_KUNJUNGAN	= '$ID_KUNJUNGAN',
						ID_PRODUK		= '$ID_PRODUK',
						JUMLAH_ORDER	= '$JUMLAH_ORDER'
					WHERE ID_ORDER = '$ID_ORDER'
				";
				$setIn = $this->db->query($sqlUp); 
				
				if($setIn){
					$sqlGet = "
						SELECT ID_ORDER, ID_KUNJUNGAN, ID_PRODUK, JUMLAH_ORDER
						FROM CRMNEW_DETILE_PRODUK_ORDER
						WHERE 
							ID_ORDER = '$ID_ORDER'
					";
					$data_get = $this->db->query($sqlGet)->row();
					
					$hasil = array(
						'ID_ORDER'		=> $data_get->ID_ORDER,
						'ID_KUNJUNGAN'	=> $data_get->ID_KUNJUNGAN,
						'ID_PRODUK'		=> $data_get->ID_PRODUK,
						'JUMLAH_ORDER'	=> $data_get->JUMLAH_ORDER
					);
					array_push($data, $hasil);
				}
				
			}
			return $data;
		}
		
		public function DeleteOrder($id_user, $id_orders){
			
			$sql = "
				UPDATE CRMNEW_DETILE_PRODUK_ORDER
				SET 
					IS_DELETE = 1 
				WHERE ID_ORDER IN ($id_orders)
			";
			$hasil = $this->db->query($sql);
			
			if($hasil){
				return true;
			} else {
				return false;
			}
		}
		
		public function GetOrder($id_user, $limit=null){
			
			$sqL2 = "
					SELECT
					*
					FROM (
					SELECT
					A.ID_ORDER,
					A.ID_KUNJUNGAN,
					A.ID_PRODUK,
					A.JUMLAH_ORDER, ROWNUM
					FROM CRMNEW_DETILE_PRODUK_ORDER A
					LEFT JOIN CRMNEW_KUNJUNGAN_CUSTOMER B ON A.ID_KUNJUNGAN=B.ID_KUNJUNGAN_CUSTOMER  
					WHERE B.ID_USER='$id_user'
					AND A.IS_DELETE = 0
					AND ROWNUM < '$limit'
					)
					ORDER BY ID_ORDER DESC
					
				";
				
				return $this->db->query($sqL2)->result_array();
		}
		
	}
?>
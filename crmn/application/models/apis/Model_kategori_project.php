<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_kategori_project extends CI_Model {

		public function getKategori(){
			$sql = "
				SELECT ID_KATEGORI, NAMA_KATEGORI, DESCRIPTION FROM CRMNEW_KATEGORI_SURVEY_PROJECT
				";
			 
			return $this->db->query($sql)->result();
		}
		
		public function Add_kategori_project_list($id_user, $data){
			$response = array();
			
			foreach($data as $p){
				
				$name	= $p['NAMA_KATEGORI'];
				$desc	= $p['DESCRIPTION'];
				
				$sqlCek = "
						SELECT ID_KATEGORI, NAMA_KATEGORI, DESCRIPTION
						FROM CRMNEW_KATEGORI_SURVEY_PROJECT
						WHERE 
							NAMA_KATEGORI LIKE '$name'
					";
				$data_cek = $this->db->query($sqlCek)->row();
					
				if($data_cek){
					
					array_push($response, $data_cek);
					
				}else{

					$sqlIn = "
						INSERT INTO CRMNEW_KATEGORI_SURVEY_PROJECT
						(NAMA_KATEGORI, DESCRIPTION, CREATE_BY, CREATE_AT)
						VALUES
						('$name', '$desc', '$id_user', SYSDATE)
					";
					$setIn = $this->db->query($sqlIn);
					
					if($setIn){
						$sqlGet = "
							SELECT ID_KATEGORI, NAMA_KATEGORI, DESCRIPTION
							FROM CRMNEW_KATEGORI_SURVEY_PROJECT
							WHERE 
								NAMA_KATEGORI = '$name'
						";
						$data_get = $this->db->query($sqlGet)->row();
						
						$hasil = array(
							'ID_KATEGORI'		=> $data_get->ID_KATEGORI,
							'NAMA_KATEGORI'		=> $data_get->NAMA_KATEGORI,
							'DESCRIPTION'		=> $data_get->DESCRIPTION
						);
						array_push($response, $hasil);
					}else{
						array_push($response, $setIn);
					}
				}
				
			}
			return $response;
		}
		
		public function Add_kategori_project($id_user, $data){
			$response;
			
			$name	= $data['NAMA_KATEGORI'];
			$desc	= $data['DESCRIPTION'];
			
			$sqlCek = "
					SELECT ID_KATEGORI, NAMA_KATEGORI, DESCRIPTION
					FROM CRMNEW_KATEGORI_SURVEY_PROJECT
					WHERE 
						NAMA_KATEGORI LIKE '$name'
				";
			$data_cek = $this->db->query($sqlCek)->row();
				
			if($data_cek){
				
				$response = $data_cek;
				
			}else{

				$sqlIn = "
					INSERT INTO CRMNEW_KATEGORI_SURVEY_PROJECT
					(NAMA_KATEGORI, DESCRIPTION, CREATE_BY, CREATE_AT)
					VALUES
					('$name', '$desc', '$id_user', SYSDATE)
				";
				$setIn = $this->db->query($sqlIn);
				
				if($setIn){
					$sqlGet = "
						SELECT ID_KATEGORI, NAMA_KATEGORI, DESCRIPTION
						FROM CRMNEW_KATEGORI_SURVEY_PROJECT
						WHERE 
							NAMA_KATEGORI = '$name'
					";
					$data_get = $this->db->query($sqlGet)->row();
					
					$hasil = array(
						'ID_KATEGORI'		=> $data_get->ID_KATEGORI,
						'NAMA_KATEGORI'		=> $data_get->NAMA_KATEGORI,
						'DESCRIPTION'		=> $data_get->DESCRIPTION
					);
					$response = $hasil;
				}else{
					$response = $setIn;
				}
			}
			return $response;
		}
		
	}
	
?>
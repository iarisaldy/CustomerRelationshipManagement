<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Master_radius_distrik_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db_CRM = $this->load->database('default', TRUE);
		$this->db_BK  = $this->load->database('Point', TRUE);
	}
	
	public function get_distrik_radius_on(){
		$sql = "
			SELECT
				ID_DISTRIK
			FROM CRMNEW_RADIUS_DISTRIK
			WHERE DELETE_MARK = 0
		";
		return $this->db_CRM->query($sql)->result_array();
	}
	
	public function List_radius_distrik(){
		$sql = "
			SELECT
				*
			FROM CRMNEW_RADIUS_DISTRIK
			WHERE DELETE_MARK = 0
			ORDER BY NAMA_DISTRIK
		";
		return $this->db_CRM->query($sql)->result_array();
	}
	
	public function get_distrik_on_BK(){
		$distrik = '';
		$distrik_on = $this->get_distrik_radius_on();
		$datas = count($distrik_on);
		$no = 0;
		foreach($distrik_on as $d){
			$no++;
			$distrik .= $d['ID_DISTRIK'];
			if($no != $datas){
			  $distrik .= ',';
			}
		}
		
		$sql = "
			SELECT
			*
			FROM M_KOTA
			--WHERE KD_KOTA NOT IN ($distrik)
			ORDER BY KOTA
		";
		return $this->db_BK->query($sql)->result_array();
	}
	
	public function set_radius_distrik($id_rd, $id_distrik, $nama_distrik, $radius_lock){
		$id_user = $this->session->userdata('user_id');
		$hasil = '';
		if($id_rd != '0000'){
			$sqlUp = "
				UPDATE CRMNEW_RADIUS_DISTRIK
				SET 
					DISTRIK_LOCK = '$radius_lock',
					UPDATE_BY = '$id_user',
					UPDATE_AT = SYSDATE
				WHERE ID_RADIUS_DISTRIK = '$id_rd'
			";
			$this->db_CRM->query($sqlUp);
			$hasil = "update";
		} else {
			$sqlCek = "
					SELECT * FROM CRMNEW_RADIUS_DISTRIK 
					WHERE DELETE_MARK = 0 AND
					ID_DISTRIK = '$id_distrik' 
			";					
			$hasilCek = $this->db_CRM->query($sqlCek)->result();;
					
			if(count($hasilCek) > 0){
				$hasil = "ready";
			} else {
				$sqlIn = "
					INSERT INTO CRMNEW_RADIUS_DISTRIK (ID_DISTRIK, NAMA_DISTRIK, DISTRIK_LOCK, CREATE_BY, CREATE_AT, DELETE_MARK)
					VALUES 
					('$id_distrik', '$nama_distrik', '$radius_lock', '$id_user', SYSDATE,  0)
				";
				$this->db_CRM->query($sqlIn);
				$hasil = "insert";
			}
		}
		return $hasil;
	} 
	
	public function delete_radius_distrik($id_rd){
		$sqlUp = "
			UPDATE CRMNEW_RADIUS_DISTRIK
			SET 
				DELETE_MARK = 1
			WHERE ID_RADIUS_DISTRIK = '$id_rd'
		";
		$this->db_CRM->query($sqlUp);
		$hasil = "delete";
		return $hasil;
	}
	
	
}

?>
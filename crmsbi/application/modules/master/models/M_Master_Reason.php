<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

class M_Master_Reason extends CI_Model {
	
	var $table = 'CRMNEW_MASTER_REASON';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_master_reason($id_mr = false){
		$this->db->from($this->table);
		$this->db->where('DELETE_MARK',0);
		if($id_mr != false)
		{
			$this->db->where('ID_MR',$id_mr);
			$query = $this->db->get();
			return $query->row();
		} 
		else 
		{
			$query=$this->db->get();
			return $query->result();
		}
	}
	
	public function add_master_reason($data){
		$id_mr 		= $data['id_mr'];
		$nama_mr 	= $data['nama_mr'];
		$deskripsi	= $data['deskripsi'];
		$user 		= $data['user'];
		
		$sql = "
			INSERT INTO ".$this->table."
				 (ID_MR, NM_MASTER_REASON, DISCRIPTION, CREATE_DATE, CREATE_BY, DELETE_MARK)
			VALUES 
				('$id_mr', '$nama_mr', '$deskripsi', SYSDATE, $user, 0)
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_master_reason($data){
		$id_mr_lama = $data['id_mr_lama'];
		
		$id_mr 		= $data['id_mr'];
		$nama_mr 	= $data['nama_mr'];
		$deskripsi	= $data['deskripsi'];
		$user 		= $data['user'];
		
		$sql = "
			UPDATE ".$this->table." SET 
				ID_MR = '$id_mr',
				NM_MASTER_REASON = '$nama_mr',
				DISCRIPTION = '$deskripsi',
				UPDATE_DATE = SYSDATE,
				UPDATE_BY = $user
			WHERE
				ID_MR = $id_mr_lama
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function make_delete_master_reason($id_mr){
		$sql = "
			UPDATE ".$this->table." SET 
				DELETE_MARK = 1
			WHERE
				ID_MR = $id_mr
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
}
?>
<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

class Master_Radius_Area_model extends CI_Model {
	
	var $table = 'CRMNEW_RADIUS_AREA';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_data($id = false)
	{
		$this->db->from($this->table);
		$this->db->where('ID_RADIUS_AREA !=', null);
		$this->db->where('DELETED_MARK', 0);
		if($id != false)
		{
			$this->db->where('ID_RADIUS_AREA',$no_index);
			$query = $this->db->get();
			return $query->row();
		} 
		else 
		{
			$query=$this->db->get();
			return $query->result();
		}
	}
	
	public function add_data($data)
	{
		$id_area 	 = $data['id_area'];
		$radius_lock = $data['radius_lock'];
		$user		 = $data['user'];
		
		$sql = "
			INSERT INTO ".$this->table."
			(ID_AREA, RADIUS_LOCK, CREATED_AT, CREATED_BY, DELETED_MARK)
			VALUES
			($id_area, $radius_lock, SYSDATE, $user, 0)
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_data($data)
	{
		$id_radius_area	= $data['id_radius_area'];
		
		$id_area 	 = $data['id_area'];
		$radius_lock = $data['radius_lock'];
		$user		 = $data['user'];
		
		$sql = "
			UPDATE ".$this->table." SET 
				ID_AREA		= $id_area, 
				RADIUS_LOCK	= $radius_lock,
				UPDATED_AT 	= SYSDATE,
				UPDATED_BY 	= $user
			WHERE
				ID_RADIUS_AREA = $id_radius_area
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function make_delete_data($id_radius_area)
	{
		$sql = "
			UPDATE ".$this->table." SET 
				DELETED_MARK = 1
			WHERE
				ID_RADIUS_AREA = $id_radius_area
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	//get data external untuk data area
	public function get_area($id_area = false){
		$this->db->from('CRMNEW_M_AREA');
		$this->db->where('DELETE_MARK',0);
		if($id_area != false)
		{
			$this->db->where('ID_AREA',$id_area);
			$query = $this->db->get();
			return $query->row();
		} 
		else 
		{
			$query=$this->db->get();
			return $query->result();
		}
	}
	
}
<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

class Faq_supervisor_visit_model extends CI_Model {
	
	var $table = 'CRMNEW_FAQ_SUPERVISOR_VISIT';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_data($id = null)
	{
		$this->db->from($this->table);
		$this->db->where('ID_FAQ !=', null);
		$this->db->where('DELETE_MARK', 0);
		if($id != null)
		{
			$this->db->where('ID_FAQ',$id);
			$query = $this->db->get();
			return $query->result();
		} 
		else 
		{
			$query=$this->db->get();
			return $query->result();
		}
	}

	public function add_data($data)
	{
		$tanya		 = $data['tanya'];
		$jawab		 = $data['jawab'];
		$user		 = $data['user'];
		
		$sql = "
			INSERT INTO ".$this->table."
			(PERTANYAAN, JAWABAN, CREATE_AT, CREATE_BY, DELETE_MARK)
			VALUES 
			('$tanya', '$jawab',  SYSDATE, $user, 0)
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_data($data)
	{
		$id_faq 	 = $data['id_faq'];
		
		$tanya		 = $data['tanya'];
		$jawab		 = $data['jawab'];
		$user		 = $data['user'];
		
		$sql = "
			UPDATE ".$this->table." SET 
				PERTANYAAN 		= '$tanya',
				JAWABAN			= '$jawab',
				UPDATE_AT 		= SYSDATE,
				UPDATE_BY 		= $user
			WHERE
				ID_FAQ = '$id_faq'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function make_delete_data($id_faq)
	{
		$sql = "
			UPDATE ".$this->table." SET 
				DELETE_MARK = 1
			WHERE
				ID_FAQ = '$id_faq'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
}
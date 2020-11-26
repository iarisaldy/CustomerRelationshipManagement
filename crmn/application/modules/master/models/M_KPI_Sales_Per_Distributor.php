<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

class M_KPI_Sales_Per_Distributor extends CI_Model {
	
	var $table = 'CRMNEW_SBI_INDEX_KPI_SALES';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_data($no_index = false)
	{
		$this->db->from($this->table);
		$this->db->where('ID_DISTRIBUTOR !=', null);
		$this->db->where('DELETE_MARK', 0);
		if($no_index != false)
		{
			$this->db->where('NO_INDEX',$no_index);
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
		$id_dist 	= $data['id_dist'];
		$visit		= $data['visit'];
		$c_a		= $data['c_a'];
		$noo		= $data['noo'];
		$vso		= $data['vso'];
		$user		= $data['user'];
		
		$sql = "
			INSERT INTO ".$this->table."
			(ID_DISTRIBUTOR, VISIT, CUSTOMER_AKTIVE, NOO, VOLUME_SEL_OUT, CREATE_DATE, CREATE_BY, DELETE_MARK)
			VALUES
			('$id_dist', $visit, $c_a, $noo, $vso, SYSDATE, $user, 0)
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	
	public function update_data($data)
	{
		$no_index	= $data['no_index'];
		
		$id_dist 	= $data['id_dist'];
		$visit		= $data['visit'];
		$c_a		= $data['c_a'];
		$noo		= $data['noo'];
		$vso		= $data['vso'];
		$user		= $data['user'];
		
		$sql = "
			UPDATE ".$this->table." SET 
				ID_DISTRIBUTOR	= '$id_dist', 
				VISIT 			= $visit, 
				CUSTOMER_AKTIVE	= $c_a, 
				NOO				= $noo, 
				VOLUME_SEL_OUT	= $vso,
				UPDATE_DATE 	= SYSDATE,
				UPDATE_BY 		= $user
			WHERE
				NO_INDEX = $no_index
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function make_delete_data($no_index)
	{
		$sql = "
			UPDATE ".$this->table." SET 
				DELETE_MARK = 1
			WHERE
				NO_INDEX = $no_index
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	//get data external untuk data distributor
	public function get_distributor($id_dist = false){
		$this->db->from('CRMNEW_DISTRIBUTOR');
		$this->db->where('DELETE_MARK',0);
		if($id_dist != false)
		{
			$this->db->where('KODE_DISTRIBUTOR',$id_dist);
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
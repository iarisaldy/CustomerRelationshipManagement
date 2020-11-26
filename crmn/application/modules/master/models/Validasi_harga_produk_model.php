<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

class Validasi_harga_produk_model extends CI_Model {
	
	var $table = 'CRMNEW_VALIDASI_HARGA_PRODUK';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_data($id = null)
	{
		$this->db->from($this->table);
		$this->db->where('ID_PRODUK !=', null);
		$this->db->where('DELETE_MARK', 0);
		if($id != null)
		{
			$this->db->where('ID_PRODUK',$id);
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
		$id_produk 	 = $data['id_produk'];
		$hb_min		 = $data['hb_min'];
		$hb_max		 = $data['hb_max'];
		$hj_min		 = $data['hj_min'];
		$hj_max		 = $data['hj_max'];
		$user		 = $data['user'];
		
		$sql = "
			INSERT INTO ".$this->table."
			(ID_PRODUK, HARGA_BELI_MIN, HARGA_BELI_MAX, HARGA_JUAL_MIN, HARGA_JUAL_MAX, CREATE_AT, CREATE_BY, DELETE_MARK)
			VALUES 
			($id_produk, $hb_min, $hb_max, $hj_min, $hj_max,  SYSDATE, $user, 0)
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_data($data)
	{
		$id_produk 	 = $data['id_produk'];
		
		$hb_min		 = $data['hb_min'];
		$hb_max		 = $data['hb_max'];
		$hj_min		 = $data['hj_min'];
		$hj_max		 = $data['hj_max'];
		$user		 = $data['user'];
		
		$sql = "
			UPDATE ".$this->table." SET 
				HARGA_BELI_MIN = $hb_min,
				HARGA_BELI_MAX = $hb_max,
				HARGA_JUAL_MIN = $hj_min,
				HARGA_JUAL_MAX = $hj_max,
				UPDATE_AT 		= SYSDATE,
				UPDATE_BY 		= $user
			WHERE
				ID_PRODUK = '$id_produk'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function make_delete_data($id_produk)
	{
		$sql = "
			UPDATE ".$this->table." SET 
				DELETE_MARK = 1
			WHERE
				ID_PRODUK = '$id_produk'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	//get data external untuk data produk survei
	public function get_produk($id_produk = false){
		$this->db->from('CRMNEW_PRODUK_SURVEY');
		$this->db->where('DELETE_MARK',0);
		if($id_produk != false)
		{
			$this->db->where('ID_PRODUK',$id_produk);
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
<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

class M_A_Distributor extends CI_Model {
	
	var $table = 'CRMNEW_DISTRIBUTOR';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_distributor($kode = false){
		$this->db->from($this->table);
		$this->db->where('DELETE_MARK',0);
		if($kode != false)
		{
			$this->db->where('KODE_DISTRIBUTOR',$kode);
			$query = $this->db->get();
			return $query->row();
		} 
		else 
		{
			$query=$this->db->get();
			return $query->result();
		}
	}
	
	public function add_distributor($data){
		$kode = $data['kode'];
		$nama = $data['nama'];
		$flag = $data['flag'];
		$user = $data['user'];
		
		$sql = "
			INSERT INTO ".$this->table."
				 (KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR, FLAG, CREATED_DATE, CREATED_BY, DELETE_MARK)
			VALUES 
				('$kode', '$nama','$flag', SYSDATE, $user, 0)
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_distributor($data){
		$kode_lama = $data['kode_lama'];
		
		$kode = $data['kode'];
		$nama = $data['nama'];
		$flag = $data['flag'];
		$user = $data['user'];
		
		$sql = "
			UPDATE ".$this->table." SET 
				KODE_DISTRIBUTOR = '$kode',
				NAMA_DISTRIBUTOR = '$nama',
				FLAG = '$flag',
				UPDATED_DATE = SYSDATE,
				UPDATED_BY = $user
			WHERE
				KODE_DISTRIBUTOR = '$kode_lama'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function make_delete_distributor($kode){
		//$kode = $data['kode'];
		$sql = "
			UPDATE ".$this->table." SET 
				DELETE_MARK = 1
			WHERE
				KODE_DISTRIBUTOR = '$kode'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
}
?>
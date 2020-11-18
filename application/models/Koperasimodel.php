<?php
class Koperasimodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function getdata($no_ktp = null)
	{
		$sql =" 
			SELECT * FROM tbl_koperasi	
		";

		return $this->db->query($sql)->result_array();
	}
	public function insertdata($no_ktp, $nama, $kelamin, $usia, $foto, $alamat)
	{
		$sql ="
			INSERT INTO 
			tbl_koperasi
			(no_ktp, nama, jenis_kelamin, tanggal_lahir, foto, alamat)
			VALUES ('$no_ktp', '$nama', '$kelamin', '$usia', '$foto', '$alamat')
		";

		return $this->db->query($sql);
	}
	public function get_by_id($no_ktp)
	{
        $hsl=$this->db->query("SELECT * FROM tbl_koperasi WHERE no_ktp='$no_ktp'");
        
        if($hsl->num_rows()>0){
            foreach ($hsl->result() as $data) 
            {
                $hasil=array(
                    'no_ktp' => $data->no_ktp,
                    'nama' => $data->nama,
                    'jenis_kelamin' => $data->kelamin,
                    'tanggal_lahir' => $data->usia,
                    'foto' => $data->foto,
                    'alamat' => $data->alamat
                );
            }
        }
        return $hasil;
    }

	public function updatedata($no_ktp, $nama, $kelamin, $usia, $foto, $alamat)
	{

		$sql = " 
			UPDATE 
			tbl_koperasi 
			SET 
			nama='$nama',
			jenis_kelamin='$kelamin',
			tanggal_lahir='$usia',
			foto='$foto',
			alamat='$alamat'
			WHERE 
			no_ktp='$no_ktp'
		";
		
		return $this->db->query($sql);

	}

	public function deletedata($no_ktp)
	{

		$sql = " 
				DELETE * FROM 
				tbl_koperasi 
				WHERE 
				no_ktp = $no_ktp
		";
		
		return $this->db->query($sql);

	}
}
<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Laporan_penugasan_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	public function userCheckingDist($id_user){
		$sql = "
			SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR
			WHERE ID_USER = '$id_user'
		";
		return $this->db->query($sql)->row();
	}
	
	public function listSales($id_user){
		$sql ="
            SELECT
				MSD.ID_USER AS ID_USER,
				MSD.NAMA AS NAMA
			FROM M_SALES_DISTRIBUTOR MSD
				JOIN CRMNEW_USER_DISTRIBUTOR CUD ON msd.kode_distributor = cud.kode_distributor
			WHERE cud.id_user = '$id_user'
			ORDER BY MSD.NAMA
        ";
        
        return $this->db->query($sql)->result();
	}
	
	public function List_kunjungan_sales($tanggalawal ,$tanggalselesai, $kd_distributor=null, $sales=null){
        $sql ="
            SELECT
            ID_KUNJUNGAN_CUSTOMER,
            ID_USER,
            KODE_DISTRIBUTOR,
            NAMA_DISTRIBUTOR,
            NAMA_USER,
            ID_TOKO,
            NAMA_TOKO,
            ALAMAT,
            ID_PROVINSI,
            ID_AREA,
            ID_DISTRIK,
            ID_KECAMATAN,
            NAMA_KECAMATAN,
            NAMA_DISTRIK,
            LOKASI_LATITUDE,
            LOKASI_LONGITUDE,
            TGL_RENCANA_KUNJUNGAN,
            CHECKIN_TIME,
            CHECKIN_LATITUDE,
            CHECKIN_LONGITUDE,
            CHECKOUT_TIME,
            CHECKOUT_LATITUDE,
            CHECKOUT_LONGITUDE,
            SELESAI,
            MULAI,
            WAKTU_KUNJUNGAN,
            JAM,
            MENIT,
            KETERANGAN
            FROM T_KUNJUNGAN_SALES_KE_TOKO
            WHERE KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0')
            AND ID_USER IN (SELECT ID_SALES FROM CRMNEW_USER_SALES WHERE DELETE_MARK='0')
            AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') BETWEEN '$tanggalawal' AND '$tanggalselesai'
            
        ";
        if($kd_distributor!=null){
            $sql .= " AND KODE_DISTRIBUTOR='$kd_distributor' ";
        }

        if($sales!=null){
            $sql .= " AND ID_USER='$sales' ";
        }
		
		$sql .= "ORDER BY TGL_RENCANA_KUNJUNGAN, NAMA_USER";
        //echo $sql;
        return $this->db->query($sql)->result();
    }
}
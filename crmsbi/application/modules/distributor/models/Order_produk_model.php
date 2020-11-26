<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

date_default_timezone_set('Asia/Jakarta');
 
class Order_produk_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('Point', TRUE);
	}
	
	public function get_data_distributor_toko($user){
		$sql ="
			SELECT
			UD.KODE_DISTRIBUTOR,
            CD.NAMA_DISTRIBUTOR
			FROM CRMNEW_USER_DISTRIBUTOR UD
            LEFT JOIN CRMNEW_DISTRIBUTOR CD ON UD.KODE_DISTRIBUTOR=CD.KODE_DISTRIBUTOR 
			WHERE ID_USER='$user'
		";
		
		return $this->db->query($sql)->result_array();
	}
	
	public function insert_data_order_produk($idpd, $stok, $tgl_order, $id_user, $tgl_request){
		
		$sql ="
			INSERT INTO CRMNEW_ORDER_CUSTOMER 
			(
			ID_PRODUK_DISTRIBUTOR, ID_CUSTOMER, QTY_ORDER, TGL_ORDER, STATUS_ORDER,
			DELETE_MARK, CREATE_BY, CREATE_DATE, TGL_REQUEST)
			VALUES 
			('$idpd', (
				SELECT
				ID_CUSTOMER
				FROM
				CRMNEW_USER_TOKO
				WHERE ID_USER='$id_user'
			), '$stok', '$tgl_order', '0', '0', '$id_user', SYSDATE, '$tgl_request')

		";
		
		return $this->db->query($sql);
		
	}
	
	public function get_daftar_produk_dist_list($user){
		
		$sql ="
			SELECT
				PD.ID_PRODUK_DISTRIBUTOR,
				PD.ID_JENIS_PRODUK,
				JPD.JENIS_PRODUK,
				PD.ID_DISTRIBUTOR,
				PD.NAMA_PRODUK,
				PD.QTY_STOK_ZAK,
				PD.HARGA_BELI,
				PD.HARGA_JUAL
			FROM CRMNEW_PRODUK_DISTRIBUTOR PD
			LEFT JOIN CRMNEW_JENIS_PRODUK_DIST JPD ON JPD.ID_JENIS_PRODUK=PD.ID_JENIS_PRODUK
			WHERE PD.DELETE_MARK=0
			AND PD.ID_DISTRIBUTOR=  (
										SELECT
										KODE_DISTRIBUTOR
										FROM CRMNEW_USER_DISTRIBUTOR
										WHERE ID_USER='$user'
									)
		";
		
		return $this->db->query($sql)->result_array();
		
	}

	public function get_data_history_order($id_user){

		$sql ="
			SELECT
				OC.NO_ORDER,
				OC.ID_PRODUK_DISTRIBUTOR,
				PD.NAMA_PRODUK,
				PD.ID_DISTRIBUTOR,
                D.NAMA_DISTRIBUTOR,
				OC.ID_CUSTOMER,
				C.NAMA_TOKO,
				OC.QTY_ORDER,
				TO_CHAR(OC.TGL_ORDER, 'DD-MM-YYYY') AS TGL_ORDER,
				PD.HARGA_JUAL,
				OC.STATUS_ORDER,
                OC.QTY_KONFIRMASI,
                TO_CHAR(OC.TGL_KONFIRMASI, 'DD-MM-YYYY') AS TGL_KONFIRMASI,
                TO_CHAR(OC.TGL_RENCANA_KIRIM, 'DD-MM-YYYY') AS TGL_RENCANA_KIRIM,
                OC.QTY_TERIMA,
                TO_CHAR(OC.WAKTU_TERIMA, 'DD-MM-YYYY') AS WAKTU_TERIMA,
                OC.PENERIMA
			FROM CRMNEW_ORDER_CUSTOMER OC
			LEFT JOIN CRMNEW_PRODUK_DISTRIBUTOR PD ON OC.ID_PRODUK_DISTRIBUTOR=PD.ID_PRODUK_DISTRIBUTOR
			LEFT JOIN CRMNEW_CUSTOMER C ON OC.ID_CUSTOMER=C.ID_CUSTOMER
            LEFT JOIN CRMNEW_DISTRIBUTOR D ON PD.ID_DISTRIBUTOR=D.KODE_DISTRIBUTOR
			WHERE OC.DELETE_MARK=0
            AND OC.ID_CUSTOMER= (
                                    SELECT 
                                        ID_CUSTOMER 
                                    FROM CRMNEW_USER_TOKO
                                    WHERE ID_USER='$id_user'
                                ) 
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_tampil_pengiriman_barang($id_user){

		$sql ="
			SELECT
				OC.NO_ORDER,
				OC.ID_PRODUK_DISTRIBUTOR,
				PD.NAMA_PRODUK,
				PD.ID_DISTRIBUTOR,
                D.NAMA_DISTRIBUTOR,
				OC.ID_CUSTOMER,
				C.NAMA_TOKO,
				OC.QTY_ORDER,
				OC.TGL_ORDER,
				PD.HARGA_JUAL,
				OC.STATUS_ORDER,
                OC.QTY_KONFIRMASI,
                OC.TGL_KONFIRMASI,
                OC.TGL_RENCANA_KIRIM,
                OC.QTY_TERIMA,
                OC.WAKTU_TERIMA,
                OC.PENERIMA
			FROM CRMNEW_ORDER_CUSTOMER OC
			LEFT JOIN CRMNEW_PRODUK_DISTRIBUTOR PD ON OC.ID_PRODUK_DISTRIBUTOR=PD.ID_PRODUK_DISTRIBUTOR
			LEFT JOIN CRMNEW_CUSTOMER C ON OC.ID_CUSTOMER=C.ID_CUSTOMER
            LEFT JOIN CRMNEW_DISTRIBUTOR D ON PD.ID_DISTRIBUTOR=D.KODE_DISTRIBUTOR
			WHERE OC.DELETE_MARK=0
            AND OC.STATUS_ORDER=1
            AND OC.QTY_KONFIRMASI IS NOT  NULL
			AND OC.TGL_KONFIRMASI IS NOT NULL
			AND OC.KONFIRMER IS NOT NULL
			AND OC.PENERIMA IS NULL
            AND OC.ID_CUSTOMER= (
                                    SELECT 
                                        ID_CUSTOMER 
                                    FROM CRMNEW_USER_TOKO
                                    WHERE ID_USER='$id_user'
                                ) 
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function konfirmasi_barang($id_user, $no_order, $qty_konfirmasi){

		$sql ="
			UPDATE CRMNEW_ORDER_CUSTOMER 
			SET
                        STATUS_ORDER='2',
			QTY_TERIMA='$qty_konfirmasi',
			WAKTU_TERIMA=SYSDATE,
			PENERIMA='$id_user'
			WHERE NO_ORDER='$no_order'
		";

		return $this->db->query($sql);

	}
	public function get_data_distributor(){
		
		$sql ="
			SELECT 
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			FROM CRMNEW_DISTRIBUTOR
		";		
		return $this->db->query($sql)->result_array();
	}
	public function get_data_pemenuhan_order($distributor, $tahun, $bulan){
		
		//$distributor='0000000147';
		$sql = "
				SELECT
					PD.ID_PRODUK_DISTRIBUTOR,
					PD.ID_JENIS_PRODUK,
					JPD.JENIS_PRODUK,
					PD.ID_DISTRIBUTOR,
					PD.NAMA_PRODUK,
					PD.QTY_STOK_ZAK,
					PD.SATUAN,
					PD.HARGA_BELI,
					PD.HARGA_JUAL,
					NVL(ORDER_TOKO.QTY_ORDER,0) AS QTY_ORDER,
					NVL(ORDER_TOKO.QTY_KONFIRMASI,0) AS QTY_KONFIRMASI,
					NVL(ORDER_TOKO.QTY_TERIMA, 0) AS QTY_TERIMA
				FROM CRMNEW_PRODUK_DISTRIBUTOR PD
				LEFT JOIN CRMNEW_JENIS_PRODUK_DIST JPD ON JPD.ID_JENIS_PRODUK=PD.ID_JENIS_PRODUK
				LEFT JOIN
							(
								SELECT
									OC.ID_PRODUK_DISTRIBUTOR,
									SUM(OC.QTY_ORDER) AS QTY_ORDER,
									SUM(OC.QTY_KONFIRMASI) AS QTY_KONFIRMASI,
									SUM(OC.QTY_TERIMA) AS QTY_TERIMA
								FROM CRMNEW_ORDER_CUSTOMER OC
								WHERE OC.DELETE_MARK=0
								AND TO_CHAR(OC.TGL_ORDER, 'YYYY')='$tahun'
								AND TO_CHAR(OC.TGL_ORDER, 'MM') = '$bulan'
								GROUP BY 
									OC.ID_PRODUK_DISTRIBUTOR
							) ORDER_TOKO ON PD.ID_PRODUK_DISTRIBUTOR=ORDER_TOKO.ID_PRODUK_DISTRIBUTOR
				WHERE PD.ID_DISTRIBUTOR='$distributor'
		";
		
		return $this->db->query($sql)->result_array();
	}
	public function get_data_detile_customer($idpd){
		
		$sql ="
			SELECT
			OC.NO_ORDER,
			OC.ID_CUSTOMER,
			C.NAMA_TOKO AS NAMA_CUSTOMER,
			OC.ID_PRODUK_DISTRIBUTOR,
			PD.NAMA_PRODUK,
			OC.QTY_ORDER,
			OC.QTY_KONFIRMASI AS QTY_KIRIM,
			OC.QTY_TERIMA
			FROM CRMNEW_ORDER_CUSTOMER OC
			LEFT JOIN CRMNEW_CUSTOMER C ON OC.ID_CUSTOMER=C.ID_CUSTOMER
			LEFT JOIN CRMNEW_PRODUK_DISTRIBUTOR PD ON OC.ID_PRODUK_DISTRIBUTOR=PD.ID_PRODUK_DISTRIBUTOR
			WHERE OC.DELETE_MARK=0
			AND OC.ID_PRODUK_DISTRIBUTOR='$idpd'
		";
		
		return $this->db->query($sql)->result_array();
	}
}


?>
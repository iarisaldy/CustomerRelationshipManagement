<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

date_default_timezone_set('Asia/Jakarta');
 
class Produk_survey_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('Point', TRUE);
	}
	
	public function get_data_produk_distributor($distributor){

		$sql =" 
				SELECT
					PD.ID_PRODUK_DISTRIBUTOR,
					PD.ID_DISTRIBUTOR,
					CD.NAMA_DISTRIBUTOR,
					PD.NAMA_PRODUK,
					JP.JENIS_PRODUK,
					PD.QTY_STOK_ZAK AS QTY_STOK,
					PD.SATUAN,
					TO_CHAR(PD.TGL_STOK_TERAKHIR, 'DD-MM-YYYY') AS TGL_STOK,
					PD.QTY_STOK_ZAK,
					PD.HARGA_BELI,
					PD.HARGA_JUAL
					FROM CRMNEW_PRODUK_DISTRIBUTOR PD
					LEFT JOIN CRMNEW_JENIS_PRODUK_DIST JP ON PD.ID_JENIS_PRODUK=JP.ID_JENIS_PRODUK
					LEFT JOIN CRMNEW_DISTRIBUTOR CD ON PD.ID_DISTRIBUTOR=CD.KODE_DISTRIBUTOR
				WHERE PD.DELETE_MARK=0
				AND PD.ID_DISTRIBUTOR='$distributor'
		";

		return $this->db->query($sql)->result_array();

	}
	public function get_dt_jenis_produk(){
		
		$sql =" 
			SELECT
			ID_JENIS_PRODUK,
			JENIS_PRODUK
			FROM CRMNEW_JENIS_PRODUK_DIST
			WHERE DELETE_MARK=0
		";

		return $this->db->query($sql)->result_array();		
	}
	public function insert_data_produk_dist($jenis_produk, $id_distributor, $user, $nm_produk, $kd_produk, 
		$stok, $satuan, $tgl_stok, $hb_satuan, $hj_satuan){
		
		$sql ="
			INSERT INTO CRMNEW_PRODUK_DISTRIBUTOR (ID_JENIS_PRODUK, ID_DISTRIBUTOR, DELETE_MARK, CREATE_BY, CREATE_DATE, NAMA_PRODUK, KD_PRODUK_SAP,
			QTY_STOK_ZAK, HARGA_BELI, HARGA_JUAL, SATUAN, TGL_STOK_TERAKHIR)
			VALUES ('$jenis_produk', '$id_distributor', 0, '$user', SYSDATE, '$nm_produk', '$kd_produk', '$stok', 
			'$hb_satuan', '$hj_satuan', ' $satuan', '$tgl_stok')
		";
		
		$this->db->query($sql);
		
		$sql2 = "
			SELECT
			ID_PRODUK_DISTRIBUTOR
			FROM CRMNEW_PRODUK_DISTRIBUTOR
			WHERE DELETE_MARK=0
			AND ID_JENIS_PRODUK='$jenis_produk'
			ORDER BY ID_PRODUK_DISTRIBUTOR DESC
		";
		
		$hasil = $this->db->query($sql2)->result_array();
		
		return $hasil[0]['ID_PRODUK_DISTRIBUTOR'];
		
	}
	
	public function insert_history_stok($idpd, $stok, $satuan, $tgl_stok,  $distributor, $id_user, $hb_satuan, $hj_satuan){
		
		$sql ="
			INSERT INTO CRMNEW_HISTORY_STOK (
			ID_PRODUK_DISTRIBUTOR, QTY_STOK, SATUAN, TGL_STOK, ID_DISTRIBUTOR,
			DELETE_MARK, CREATE_BY, CREATE_DATE, HARGA_BELI, HARGA_JUAL
			)
			VALUES ('$idpd', '$stok', '$satuan', '$tgl_stok', '$distributor', 0, '$id_user', SYSDATE, '$hb_satuan', '$hj_satuan')
		";
		
		$this->db->query($sql);
		
		$sql2 ="
		UPDATE CRMNEW_PRODUK_DISTRIBUTOR
			SET
			UPDATE_BY='$id_user',
			UPDATE_DATE=SYSDATE,
			QTY_STOK_ZAK='$stok',
			HARGA_BELI='$hb_satuan',
			HARGA_JUAL='$hj_satuan',
			SATUAN='$satuan',
			TGL_STOK_TERAKHIR='$tgl_stok'
			WHERE ID_PRODUK_DISTRIBUTOR='$idpd'
		";
		$this->db->query($sql2);
		
	}
	
	public function get_history_stok_distributor($idpd){
		
		$sql ="
			SELECT
			HS.ID_PRODUK_DISTRIBUTOR,
			HS.QTY_STOK,
			HS.SATUAN,
			HS.TGL_STOK,
			HS.HARGA_BELI,
            HS.HARGA_JUAL
			FROM CRMNEW_HISTORY_STOK HS
			WHERE HS.DELETE_MARK=0
			AND HS.ID_PRODUK_DISTRIBUTOR='$idpd'
			ORDER BY HS.TGL_STOK
		";
		
		return $this->db->query($sql)->result_array();	
		
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
	public function get_data_order_toko_fixs($distributor=null){
		$sql ="
			SELECT
				OC.NO_ORDER,
				OC.ID_PRODUK_DISTRIBUTOR,
				PD.NAMA_PRODUK,
				PD.ID_DISTRIBUTOR,
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
			WHERE OC.DELETE_MARK=0
			AND OC.QTY_KONFIRMASI IS NOT NULL
			AND OC.TGL_KONFIRMASI IS NOT NULL
			AND OC.KONFIRMER IS NOT NULL
			
		";
		if($distributor!=null){
			$sql .= " AND PD.ID_DISTRIBUTOR='$distributor' ";
		}
		
		return $this->db->query($sql)->result_array();
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
	
	public function get_data_order_toko($distributor){
		
		$sql ="
			SELECT
				OC.NO_ORDER,
				OC.ID_PRODUK_DISTRIBUTOR,
				PD.NAMA_PRODUK,
				PD.ID_DISTRIBUTOR,
				OC.ID_CUSTOMER,
				C.NAMA_TOKO,
				OC.QTY_ORDER,
				TO_CHAR(OC.TGL_ORDER, 'DD-MM-YYYY') AS TGL_ORDER,
				PD.HARGA_JUAL,
				OC.STATUS_ORDER,
				TO_CHAR(OC.TGL_REQUEST, 'DD-MM-YYYY') AS TGL_REQUEST
			FROM CRMNEW_ORDER_CUSTOMER OC
			LEFT JOIN CRMNEW_PRODUK_DISTRIBUTOR PD ON OC.ID_PRODUK_DISTRIBUTOR=PD.ID_PRODUK_DISTRIBUTOR
			LEFT JOIN CRMNEW_CUSTOMER C ON OC.ID_CUSTOMER=C.ID_CUSTOMER
			WHERE OC.DELETE_MARK=0
			AND OC.QTY_KONFIRMASI IS NULL
			AND OC.TGL_KONFIRMASI IS NULL
			AND OC.KONFIRMER IS NULL
			AND PD.ID_DISTRIBUTOR='$distributor'
		";
		
		return $this->db->query($sql)->result_array();
	}
	public function Konfirmasi_order($no_order, $idpd, $qty_konfirmasi, $tgl_rencana, $id_user, $distributor){

		$sql = " 
			UPDATE CRMNEW_ORDER_CUSTOMER 
			SET STATUS_ORDER='1',
			QTY_KONFIRMASI='$qty_konfirmasi',
			TGL_KONFIRMASI=SYSDATE,
			TGL_RENCANA_KIRIM='$tgl_rencana',
			KONFIRMER='$id_user',
			UPDATE_BY='$id_user',
			UPDATE_DATE=SYSDATE
			WHERE NO_ORDER='$no_order'
			AND ID_PRODUK_DISTRIBUTOR='$idpd'
		";
		
		return $this->db->query($sql);

	}
	
	
}


?>
<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_history_visited extends CI_Model {
		
		public function getHistory($id_tso = null, $id_customer = null){
			 $sql = "
				SELECT 
					ID_KUNJUNGAN_CUSTOMER,
					ID_USER,
					NAMA_USER,
					ID_TOKO AS ID_CUSTOMER,
					NAMA_TOKO AS NM_CUSTOMER,
					ALAMAT,
					TELP_TOKO AS TELP_CUSTOMER,
					NAMA_PEMILIK,
					ID_PROVINSI,
					ID_AREA,
					ID_DISTRIK,
					ID_KECAMATAN,
					NAMA_KECAMATAN,
					NAMA_DISTRIK,
					LOKASI_LATITUDE,
					LOKASI_LONGITUDE,
					TO_CHAR(TGL_RENCANA_KUNJUNGAN,'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN,
					TO_CHAR(CHECKIN_TIME,'YYYY-MM-DD HH24:MI:SS') AS CHECKIN_TIME,
					CHECKIN_LATITUDE,
					CHECKIN_LONGITUDE,
					TO_CHAR(CHECKOUT_TIME,'YYYY-MM-DD HH24:MI:SS') AS CHECKOUT_TIME,
					CHECKOUT_LATITUDE,
					CHECKOUT_LONGITUDE,
					SELESAI,
					MULAI,
					WAKTU_KUNJUNGAN,
					JAM,
					MENIT,
					KETERANGAN,
					SEQUEN,
					ALASAN_KUNJUNGAN,
					ORDER_SEMEN,
					SALES.ID_SALES,
					SALES.NAMA_SALES,
					SALES.KODE_DISTRIBUTOR,
					SALES.NAMA_DISTRIBUTOR,
					TO_CHAR(VISIT_GROUP.PLANNED_VISIT,'YYYY-MM-DD') AS PLANNED_VISIT,
					VISIT_GROUP.USER_ID 
				FROM V_KUNJUNGAN_HARIAN_SALES VISIT JOIN
				(
					SELECT DISTINCT(ID_SALES),
					NAMA_SALES,
					KODE_DISTRIBUTOR,
					NAMA_DISTRIBUTOR 
					FROM HIRARCKY_GSM_TO_DISTRIBUTOR
					WHERE ID_SO IS NOT NULL
					AND ID_SO = '$id_tso'
				) SALES  
					ON SALES.ID_SALES = VISIT.ID_USER
				JOIN
				(
					SELECT MAX(TGL_RENCANA_KUNJUNGAN) AS PLANNED_VISIT, ID_USER AS USER_ID FROM CRMNEW_KUNJUNGAN_CUSTOMER
					WHERE ID_USER IN (
						SELECT ID_USER FROM CRMNEW_KUNJUNGAN_CUSTOMER
						WHERE ID_TOKO = '$id_customer' 
						GROUP BY ID_USER
					) AND ID_TOKO = '$id_customer'  
					AND CHECKIN_TIME IS NOT NULL 
					AND CHECKOUT_TIME IS NOT NULL 
					AND TGL_RENCANA_KUNJUNGAN > (CURRENT_DATE-30)
					GROUP BY ID_USER
				) VISIT_GROUP
				ON VISIT_GROUP.PLANNED_VISIT = VISIT.TGL_RENCANA_KUNJUNGAN
				AND VISIT_GROUP.USER_ID = VISIT.ID_USER
				WHERE ID_TOKO = '$id_customer' 
				ORDER BY VISIT.TGL_RENCANA_KUNJUNGAN
			 ";
			 
			 return $this->db->query($sql)->result();
		}
		
		public function getKunjungan($id_kunjungan = null){
			 $sql = "
				SELECT 
					ID_KUNJUNGAN_CUSTOMER,
					ID_USER,
					NAMA_USER AS NAMA_SALES,
					ID_TOKO AS ID_CUSTOMER,
					NAMA_TOKO AS NM_CUSTOMER,
					ALAMAT,
					TELP_TOKO AS TELP_CUSTOMER,
					NAMA_PEMILIK,
					ID_PROVINSI,
					ID_AREA,
					ID_DISTRIK,
					ID_KECAMATAN,
					NAMA_KECAMATAN,
					NAMA_DISTRIK,
					LOKASI_LATITUDE,
					LOKASI_LONGITUDE,
					TO_CHAR(TGL_RENCANA_KUNJUNGAN,'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN,
					TO_CHAR(CHECKIN_TIME,'YYYY-MM-DD HH24:MI:SS') AS CHECKIN_TIME,
					CHECKIN_LATITUDE,
					CHECKIN_LONGITUDE,
					TO_CHAR(CHECKOUT_TIME,'YYYY-MM-DD HH24:MI:SS') AS CHECKOUT_TIME,
					CHECKOUT_LATITUDE,
					CHECKOUT_LONGITUDE,
					SELESAI,
					MULAI,
					WAKTU_KUNJUNGAN,
					JAM,
					MENIT,
					KETERANGAN,
					SEQUEN,
					ALASAN_KUNJUNGAN,
					ORDER_SEMEN
				FROM V_KUNJUNGAN_HARIAN_SALES
				WHERE ID_KUNJUNGAN_CUSTOMER = '$id_kunjungan' 
			 ";
			 
			 return $this->db->query($sql)->row();
		}
		
		public function getProductSurvey($id_kunjungan = null){
			$sql = "
				SELECT ID_HASIL_SURVEY, S.ID_KUNJUNGAN_CUSTOMER, P.ID_PRODUK, P.NAMA_PRODUK 
				FROM CRMNEW_HASIL_SURVEY S
				LEFT JOIN CRMNEW_PRODUK_SURVEY P
				ON S.ID_PRODUK = P.ID_PRODUK
				WHERE ID_KUNJUNGAN_CUSTOMER = '$id_kunjungan' 
					AND S.DELETE_MARK != 1
				";
			 
			return $this->db->query($sql)->result();
		}
		
		public function getSurveyProject($id_kunjungan = null){
			$sql = "
				SELECT ID_SURVEY_PROJECT, NAMA_PROJECT, 
				TO_CHAR(START_PROJECT,'YYYY-MM-DD') AS START_PROJECT, 
				TO_CHAR(END_PROJECT,'YYYY-MM-DD') AS END_PROJECT,
				VOLUME
				FROM CRMNEW_SURVEY_PROJECT_TOKO
				WHERE ID_KUNJUNGAN_CUSTOMER = '$id_kunjungan' 
				";
			 
			return $this->db->query($sql)->row();
		}
		
		public function getFoto($id_kunjungan = null){
			$sql = "
				SELECT ID_FOTO_KUNJUNGAN, FOTO_SURVEY
				FROM CRMNEW_FOTO_SURVEY
				WHERE ID_KUNJUNGAN_CUSTOMER = '$id_kunjungan' AND DELETE_MARK != 1 
				";
			 
			return $this->db->query($sql)->result();
		}
		
		public function getAlasanTidakOrder($id_kunjungan = null){
			$sql = "
				SELECT ID_KUNJUNGAN, NO_MR_DETAIL, MRD.NAMA_DETAIL, DESCRIPTION
				FROM CRMNEW_TOKO_TIDAK_DIKUNJUNGI TTD
				LEFT JOIN CRMNEW_MR_DETAIL MRD
				ON TTD.NO_MR_DETAIL = MRD.NO_DETAIL
				WHERE ID_KUNJUNGAN = '$id_kunjungan'  
				AND MRD.ID_MR 
					IN (SELECT ID_MR FROM CRMNEW_MASTER_REASON WHERE NM_MASTER_REASON LIKE '%TIDAK ORDER')
				";
			 
			return $this->db->query($sql)->result();
		}
		
		public function getHasilSurvey($id_kunjungan = null, $id_produk = null){
			$sql = "
				SELECT 
					ID_HASIL_SURVEY,
					ID_KUNJUNGAN_CUSTOMER,
					ID_USER,
					ID_TOKO AS ID_CUSTOMER,
					HS.ID_PRODUK,
					P.NAMA_PRODUK,
					STOK_SAAT_INI,
					VOLUME_PEMBELIAN,
					HARGA_PEMBELIAN,
					TOP_PEMBELIAN,
					TO_CHAR(TGL_PEMBELIAN, 'YYYY-MM-DD') AS TGL_PEMBELIAN,
					VOLUME_PENJUALAN,
					HARGA_PENJUALAN,
					KAPASITAS_TOKO
				FROM CRMNEW_HASIL_SURVEY HS
				JOIN CRMNEW_PRODUK_SURVEY P ON HS.ID_PRODUK = P.ID_PRODUK
				WHERE ID_KUNJUNGAN_CUSTOMER = '$id_kunjungan' 
					AND HS.ID_PRODUK = '$id_produk'  
					AND HS.DELETE_MARK != 1
				";
			 
			return $this->db->query($sql)->row();
		}
		
		public function getSurveyKeluhan($id_kunjungan = null, $id_produk = null){
			$sql = "
				SELECT ID_SURVEY_KELUHAN, SK.ID_KELUHAN, ID_PRODUK, K.KELUHAN, JAWABAN FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER SK
				JOIN CRMNEW_KELUHAN K ON SK.ID_KELUHAN = K.ID_KELUHAN
				WHERE ID_KUNJUNGAN_CUSTOMER = '$id_kunjungan' 
					AND ID_PRODUK = '$id_produk' 
					AND JAWABAN IS NOT NULL
				";
			 
			return $this->db->query($sql)->result();
		}
		
		public function getSurveyPromosi($id_kunjungan = null, $id_produk = null){
			$sql = "
				SELECT ID_SURVEY_PROMOSI, SP.ID_PROMOSI, ID_PRODUK, P.PROMOSI, JAWABAN FROM CRMNEW_SURVEY_PROMO_CUSTOMER SP
				JOIN CRMNEW_PROMOSI P ON SP.ID_PROMOSI = P.ID_PROMOSI
				WHERE ID_KUNJUNGAN_CUSTOMER = '$id_kunjungan' 
					AND ID_PRODUK = '$id_produk' 
					AND JAWABAN IS NOT NULL
				";
			 
			return $this->db->query($sql)->result();
		}
		
	}
	
?>
<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Survey_model extends CI_Model {

		public function get_hasil_survey_per_kunjungan($id_user, $id_kc){
			
			$sql ="
				SELECT
					HS.ID_HASIL_SURVEY,
					HS.ID_KUNJUNGAN_CUSTOMER,
					HS.ID_USER,
					U.NAMA,
					HS.ID_TOKO AS ID_CUSTOMER,
					C.NAMA_TOKO AS NAMA_CUSTOMER,
					C.ALAMAT,
					HS.ID_PRODUK,
					PS.NAMA_PRODUK,
					HS.STOK_SAAT_INI,
					HS.VOLUME_PEMBELIAN,
					HS.HARGA_PEMBELIAN,
					HS.TOP_PEMBELIAN,
					TO_CHAR(HS.TGL_PEMBELIAN, 'YYYY-MM-DD') AS TGL_PEMBELIAN,
					HS.VOLUME_PENJUALAN,
					HS.HARGA_PENJUALAN,
					HS.KAPASITAS_TOKO
				FROM CRMNEW_HASIL_SURVEY HS
				LEFT JOIN CRMNEW_USER U ON HS.ID_USER=U.ID_USER
				LEFT JOIN CRMNEW_CUSTOMER C ON HS.ID_TOKO=C.ID_CUSTOMER
				LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON HS.ID_PRODUK=PS.ID_PRODUK
				WHERE HS.DELETE_MARK=0
				AND HS.ID_USER='$id_user'
                AND HS.ID_KUNJUNGAN_CUSTOMER IN ($id_kc)
				ORDER BY ID_HASIL_SURVEY
			";
			return $this->db->query($sql)->result_array();
			
		}
        public function get_data_hasil_survey($id_user, $tahun, $bulan){
			
			$sql ="
				SELECT
					HS.ID_HASIL_SURVEY,
					HS.ID_KUNJUNGAN_CUSTOMER,
					HS.ID_USER,
					U.NAMA,
					HS.ID_TOKO AS ID_CUSTOMER,
					C.NAMA_TOKO AS NAMA_CUSTOMER,
					C.ALAMAT,
					HS.ID_PRODUK,
					PS.NAMA_PRODUK,
					HS.STOK_SAAT_INI,
					HS.VOLUME_PEMBELIAN,
					HS.HARGA_PEMBELIAN,
					HS.TOP_PEMBELIAN,
					TO_CHAR(HS.TGL_PEMBELIAN, 'YYYY-MM-DD') AS TGL_PEMBELIAN,
					HS.VOLUME_PENJUALAN,
					HS.HARGA_PENJUALAN,
					HS.KAPASITAS_TOKO
				FROM CRMNEW_HASIL_SURVEY HS
				LEFT JOIN CRMNEW_USER U ON HS.ID_USER=U.ID_USER
				LEFT JOIN CRMNEW_CUSTOMER C ON HS.ID_TOKO=C.ID_CUSTOMER
				LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON HS.ID_PRODUK=PS.ID_PRODUK
				WHERE HS.DELETE_MARK=0
				AND HS.ID_USER='$id_user'
				AND TO_CHAR(HS.CREATE_DATE, 'YYYY')='$tahun'
                AND TO_CHAR(HS.CREATE_DATE, 'MM')='$bulan'
				ORDER BY ID_HASIL_SURVEY
			";
			
			return $this->db->query($sql)->result_array();
		}
		
		public function get_data_survey_keluhan_perkunjungan($id_user, $id_kc){
			
			$sql ="
				SELECT
					SKC.ID_KUNJUNGAN_CUSTOMER,
					SKC.ID_PRODUK,
					PS.NAMA_PRODUK,
					SKC.ID_SURVEY_KELUHAN,
					SKC.ID_KELUHAN,
					K.KELUHAN,
					SKC.JAWABAN,
					TO_CHAR(HS.CREATE_DATE, 'YYYY-MM-DD') AS TGL_SURVEY
				FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER SKC
				LEFT JOIN CRMNEW_HASIL_SURVEY HS ON SKC.ID_KUNJUNGAN_CUSTOMER=HS.ID_KUNJUNGAN_CUSTOMER
					AND SKC.ID_PRODUK=HS.ID_PRODUK 
				LEFT JOIN CRMNEW_KELUHAN K ON SKC.ID_KELUHAN=K.ID_KELUHAN
				LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON SKC.ID_PRODUK=PS.ID_PRODUK
				WHERE HS.DELETE_MARK=0
				AND SKC.DELETE_MARK=0
				--AND HS.ID_USER='$id_user'
				AND SKC.ID_KUNJUNGAN_CUSTOMER IN ($id_kc)
				
				
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		
		public function get_data_survey_keluhan_sales($id_user, $tahun, $bulan){
			
			$sql ="
				SELECT
				SURVEY_KELUHAN.*,
				KC.ID_USER,
				U.NAMA,
				HS.ID_HASIL_SURVEY
				FROM 
					(
						SELECT 
						PRODUK.ID_PRODUK,
						PRODUK.NAMA_PRODUK,
						PRODUK.ID_KUNJUNGAN_CUSTOMER,
						SEMEN_MENBATU.JAWABAN AS SEMEN_MEMBATU,
						STD.JAWABAN AS SEMEN_TERLAMBAT_DATANG,
						KTK.JAWABAN AS KANTONG_TIDAK_KUAT,
						HTS.JAWABAN AS HARGA_TIDAK_STABIL,
						SRSD.JAWABAN AS SEMEN_RUSAK_SAAT_DITERIMA,
						TKL.JAWABAN AS TOP_KURANG_LAMA,
						PS.JAWABAN AS PEMESANAN_SULIT,
						KS.JAWABAN AS KOMPLAIN_SULIT,
						SSK.JAWABAN AS STOK_SERING_KOSONG,
						PPR.JAWABAN AS PROSEDUR_RUMIT,
						TTS.JAWABAN AS TIDAK_SESUAI_SPESIFIKASI,
						TAK.JAWABAN AS TIDAK_ADA_KELUHAN,
						KLL.JAWABAN AS KELUHAN_LAIN_LAIN,
						PRODUK.DELETE_MARK
						FROM 
							(
								SELECT
								DT_PRODUK.ID_PRODUK,
								DT_PRODUK.NAMA_PRODUK,
								DT_PRODUK.ID_KUNJUNGAN_CUSTOMER,
								DT_PRODUK.DELETE_MARK
								FROM 
								(
									SELECT
									KC.ID_SURVEY_KELUHAN,
									KC.ID_KELUHAN,
									KELUHAN.KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN,
									KC.JAWABAN,
									KC.DELETE_MARK
									FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
									LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
									LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
									WHERE KC.DELETE_MARK=0
									ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
								) DT_PRODUK
								GROUP BY 
									DT_PRODUK.ID_PRODUK,
									DT_PRODUK.NAMA_PRODUK,
									DT_PRODUK.ID_KUNJUNGAN_CUSTOMER, 
									DT_PRODUK.DELETE_MARK
							) PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=1
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) SEMEN_MENBATU ON PRODUK.ID_KUNJUNGAN_CUSTOMER=SEMEN_MENBATU.ID_KUNJUNGAN_CUSTOMER
								AND PRODUK.ID_PRODUK=SEMEN_MENBATU.ID_PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=2
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) STD ON PRODUK.ID_KUNJUNGAN_CUSTOMER=STD.ID_KUNJUNGAN_CUSTOMER
								AND PRODUK.ID_PRODUK=STD.ID_PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=3
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) KTK ON PRODUK.ID_KUNJUNGAN_CUSTOMER=KTK.ID_KUNJUNGAN_CUSTOMER 
								AND PRODUK.ID_PRODUK=KTK.ID_PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=4
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) HTS ON PRODUK.ID_KUNJUNGAN_CUSTOMER=HTS.ID_KUNJUNGAN_CUSTOMER 
								AND PRODUK.ID_PRODUK=HTS.ID_PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=5
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) SRSD ON PRODUK.ID_KUNJUNGAN_CUSTOMER=SRSD.ID_KUNJUNGAN_CUSTOMER 
								AND PRODUK.ID_PRODUK=SRSD.ID_PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=6
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) TKL ON PRODUK.ID_KUNJUNGAN_CUSTOMER=TKL.ID_KUNJUNGAN_CUSTOMER 
								AND PRODUK.ID_PRODUK=TKL.ID_PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=7
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) PS ON PRODUK.ID_KUNJUNGAN_CUSTOMER=PS.ID_KUNJUNGAN_CUSTOMER
								AND PRODUK.ID_PRODUK=PS.ID_PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=8
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) KS ON PRODUK.ID_KUNJUNGAN_CUSTOMER=KS.ID_KUNJUNGAN_CUSTOMER
								AND PRODUK.ID_PRODUK=KS.ID_PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=9
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) SSK ON PRODUK.ID_PRODUK=SSK.ID_PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=10
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) PPR ON PRODUK.ID_KUNJUNGAN_CUSTOMER=PPR.ID_KUNJUNGAN_CUSTOMER 
								AND PRODUK.ID_PRODUK=PPR.ID_PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=11
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) TTS ON PRODUK.ID_KUNJUNGAN_CUSTOMER=TTS.ID_KUNJUNGAN_CUSTOMER 
								AND PRODUK.ID_PRODUK=TTS.ID_PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=12
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) TAK ON PRODUK.ID_KUNJUNGAN_CUSTOMER=TAK.ID_KUNJUNGAN_CUSTOMER 
								AND PRODUK.ID_PRODUK=TAK.ID_PRODUK
						LEFT JOIN 
							(
								SELECT
								KC.ID_KELUHAN,
								KC.ID_KUNJUNGAN_CUSTOMER,
								KC.ID_PRODUK,
								PS.NAMA_PRODUK,
								KC.JAWABAN
								FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
								LEFT JOIN CRMNEW_KELUHAN KELUHAN  ON KC.ID_KELUHAN=KELUHAN.ID_KELUHAN
								LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON KC.ID_PRODUK=PS.ID_PRODUK
								WHERE KC.DELETE_MARK=0
								AND KC.ID_KELUHAN=13
								GROUP BY 
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									PS.NAMA_PRODUK,
									KC.JAWABAN
								ORDER BY KC.ID_PRODUK, KC.ID_KELUHAN
							) KLL ON PRODUK.ID_KUNJUNGAN_CUSTOMER=KLL.ID_KUNJUNGAN_CUSTOMER 
								AND PRODUK.ID_PRODUK=KLL.ID_PRODUK
					) SURVEY_KELUHAN 
				LEFT JOIN CRMNEW_KUNJUNGAN_CUSTOMER KC ON KC.ID_KUNJUNGAN_CUSTOMER=SURVEY_KELUHAN.ID_KUNJUNGAN_CUSTOMER
				LEFT JOIN CRMNEW_USER U ON KC.ID_USER=U.ID_USER
				LEFT JOIN CRMNEW_HASIL_SURVEY HS ON KC.ID_KUNJUNGAN_CUSTOMER=HS.ID_KUNJUNGAN_CUSTOMER
                    AND KC.ID_USER=HS.ID_USER AND KC.ID_TOKO=HS.ID_TOKO
				WHERE KC.ID_USER='$id_user'
				AND TO_CHAR(KC.CHECKIN_TIME, 'YYYY')='$tahun'
				AND TO_CHAR(KC.CHECKIN_TIME, 'MM')='$bulan'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		
		public function get_data_survey_promosi_per_kunjungan($id_user, $id_kc){
			
			$sql ="
				SELECT
					PC.ID_SURVEY_PROMOSI,
					PC.ID_KUNJUNGAN_CUSTOMER,
					PC.ID_PRODUK,
					PS.NAMA_PRODUK,
					PC.ID_PROMOSI,
					P.PROMOSI,
					P.TYPE_INPUT,
					PC.JAWABAN,
					P.LABEL_FIELD,
					HS.ID_USER,
					TO_CHAR(HS.CREATE_DATE, 'YYYY-MM-DD') AS TGL_SURVEY
				FROM CRMNEW_SURVEY_PROMO_CUSTOMER PC
				LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PC.ID_PRODUK=PS.ID_PRODUK
				LEFT JOIN CRMNEW_PROMOSI P ON PC.ID_PROMOSI=P.ID_PROMOSI
				LEFT JOIN CRMNEW_HASIL_SURVEY HS ON PC.ID_KUNJUNGAN_CUSTOMER=HS.ID_KUNJUNGAN_CUSTOMER
							AND HS.ID_PRODUK=PC.ID_PRODUK
				WHERE PC.DELETE_MARK=0
				AND HS.ID_USER='$id_user'
				AND PC.ID_KUNJUNGAN_CUSTOMER IN ($id_kc)
			";
			
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function get_data_hasil_survey_promosi($id_user, $tahun, $bulan){
			
			$sql ="
				SELECT
					SURVEY_PROMOSI.*,
					KC.ID_USER,
					U.NAMA,
					TO_CHAR(KC.CHECKIN_TIME, 'YYYY-MM-DD') AS TGL_SURVEY,
					HS.ID_HASIL_SURVEY
					FROM
						(
							SELECT
							P.ID_PRODUK,
							P.NAMA_PRODUK,
							P.ID_KUNJUNGAN_CUSTOMER,
							BS.JAWABAN AS BONUS_SEMEN,
							BW.JAWABAN AS BONUS_WISATA,
							PR.JAWABAN AS POINT_REWARD,
							V.JAWABAN AS VOUCER,
							SP.JAWABAN AS SETIAP_PEMBELIAN,
							PH.JAWABAN AS POTONGAN_HARGA,
							BT.JAWABAN AS BONUS_TOP,
							P.DELETE_MARK
							FROM 
								(
									SELECT
									PRODUK.ID_PRODUK,
									PRODUK.NAMA_PRODUK,
									PRODUK.ID_KUNJUNGAN_CUSTOMER,
									PRODUK.DELETE_MARK
									FROM 
										(
											SELECT
											PC.ID_KUNJUNGAN_CUSTOMER,
											PC.ID_SURVEY_PROMOSI,
											PC.ID_PROMOSI,
											P.PROMOSI,
											PC.ID_PRODUK,
											PS.NAMA_PRODUK,
											PC.JAWABAN,
											PC.DELETE_MARK
											FROM CRMNEW_SURVEY_PROMO_CUSTOMER PC
											LEFT JOIN CRMNEW_PROMOSI P ON PC.ID_PROMOSI=P.ID_PROMOSI
											LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PC.ID_PRODUK=PS.ID_PRODUK
											WHERE PC.DELETE_MARK=0
										) PRODUK
										GROUP BY
										PRODUK.ID_PRODUK,
										PRODUK.NAMA_PRODUK,
										PRODUK.ID_KUNJUNGAN_CUSTOMER,
										PRODUK.DELETE_MARK
								) P
							LEFT JOIN 
								(
									SELECT
									PC.ID_KUNJUNGAN_CUSTOMER,
									PC.ID_PROMOSI,
									PC.ID_PRODUK,
									PC.JAWABAN
									FROM CRMNEW_SURVEY_PROMO_CUSTOMER PC
									LEFT JOIN CRMNEW_PROMOSI P ON PC.ID_PROMOSI=P.ID_PROMOSI
									LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PC.ID_PRODUK=PS.ID_PRODUK
									WHERE PC.DELETE_MARK=0
									AND PC.ID_PROMOSI=1
								) BS ON P.ID_KUNJUNGAN_CUSTOMER=BS.ID_KUNJUNGAN_CUSTOMER
									AND P.ID_PRODUK=BS.ID_PRODUK
							LEFT JOIN 
								(
									SELECT
									PC.ID_KUNJUNGAN_CUSTOMER,
									PC.ID_PROMOSI,
									PC.ID_PRODUK,
									PC.JAWABAN
									FROM CRMNEW_SURVEY_PROMO_CUSTOMER PC
									LEFT JOIN CRMNEW_PROMOSI P ON PC.ID_PROMOSI=P.ID_PROMOSI
									LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PC.ID_PRODUK=PS.ID_PRODUK
									WHERE PC.DELETE_MARK=0
									AND PC.ID_PROMOSI=2
								) BW ON P.ID_KUNJUNGAN_CUSTOMER=BW.ID_KUNJUNGAN_CUSTOMER
									AND P.ID_PRODUK=BW.ID_PRODUK
							LEFT JOIN 
								(
									SELECT
									PC.ID_KUNJUNGAN_CUSTOMER,
									PC.ID_PROMOSI,
									PC.ID_PRODUK,
									PC.JAWABAN
									FROM CRMNEW_SURVEY_PROMO_CUSTOMER PC
									LEFT JOIN CRMNEW_PROMOSI P ON PC.ID_PROMOSI=P.ID_PROMOSI
									LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PC.ID_PRODUK=PS.ID_PRODUK
									WHERE PC.DELETE_MARK=0
									AND PC.ID_PROMOSI=3
								) PR ON P.ID_KUNJUNGAN_CUSTOMER=PR.ID_KUNJUNGAN_CUSTOMER
									AND P.ID_PRODUK=PR.ID_PRODUK
							LEFT JOIN 
								(
									SELECT
									PC.ID_KUNJUNGAN_CUSTOMER,
									PC.ID_PROMOSI,
									PC.ID_PRODUK,
									PC.JAWABAN
									FROM CRMNEW_SURVEY_PROMO_CUSTOMER PC
									LEFT JOIN CRMNEW_PROMOSI P ON PC.ID_PROMOSI=P.ID_PROMOSI
									LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PC.ID_PRODUK=PS.ID_PRODUK
									WHERE PC.DELETE_MARK=0
									AND PC.ID_PROMOSI=4
								) V ON P.ID_KUNJUNGAN_CUSTOMER=V.ID_KUNJUNGAN_CUSTOMER
									AND P.ID_PRODUK=V.ID_PRODUK
							LEFT JOIN 
								(
									SELECT
									PC.ID_KUNJUNGAN_CUSTOMER,
									PC.ID_PROMOSI,
									PC.ID_PRODUK,
									PC.JAWABAN
									FROM CRMNEW_SURVEY_PROMO_CUSTOMER PC
									LEFT JOIN CRMNEW_PROMOSI P ON PC.ID_PROMOSI=P.ID_PROMOSI
									LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PC.ID_PRODUK=PS.ID_PRODUK
									WHERE PC.DELETE_MARK=0
									AND PC.ID_PROMOSI=5
								) SP ON P.ID_KUNJUNGAN_CUSTOMER=SP.ID_KUNJUNGAN_CUSTOMER
									AND P.ID_PRODUK=SP.ID_PRODUK
							LEFT JOIN 
								(
									SELECT
									PC.ID_KUNJUNGAN_CUSTOMER,
									PC.ID_PROMOSI,
									PC.ID_PRODUK,
									PC.JAWABAN
									FROM CRMNEW_SURVEY_PROMO_CUSTOMER PC
									LEFT JOIN CRMNEW_PROMOSI P ON PC.ID_PROMOSI=P.ID_PROMOSI
									LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PC.ID_PRODUK=PS.ID_PRODUK
									WHERE PC.DELETE_MARK=0
									AND PC.ID_PROMOSI=6
								) PH ON P.ID_KUNJUNGAN_CUSTOMER=PH.ID_KUNJUNGAN_CUSTOMER
									AND P.ID_PRODUK=PH.ID_PRODUK
							LEFT JOIN 
								(
									SELECT
									PC.ID_KUNJUNGAN_CUSTOMER,
									PC.ID_PROMOSI,
									PC.ID_PRODUK,
									PC.JAWABAN
									FROM CRMNEW_SURVEY_PROMO_CUSTOMER PC
									LEFT JOIN CRMNEW_PROMOSI P ON PC.ID_PROMOSI=P.ID_PROMOSI
									LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PC.ID_PRODUK=PS.ID_PRODUK
									WHERE PC.DELETE_MARK=0
									AND PC.ID_PROMOSI=7
								) BT ON P.ID_KUNJUNGAN_CUSTOMER=BT.ID_KUNJUNGAN_CUSTOMER
									AND P.ID_PRODUK=BT.ID_PRODUK

						) SURVEY_PROMOSI
					LEFT JOIN CRMNEW_KUNJUNGAN_CUSTOMER KC ON KC.ID_KUNJUNGAN_CUSTOMER=SURVEY_PROMOSI.ID_KUNJUNGAN_CUSTOMER
					LEFT JOIN CRMNEW_USER U ON KC.ID_USER=U.ID_USER
					LEFT JOIN CRMNEW_HASIL_SURVEY HS ON KC.ID_KUNJUNGAN_CUSTOMER=HS.ID_KUNJUNGAN_CUSTOMER
						AND KC.ID_USER=HS.ID_USER AND KC.ID_TOKO=HS.ID_TOKO
					WHERE KC.ID_USER='$id_user'
					AND TO_CHAR(KC.CHECKIN_TIME, 'YYYY')='$tahun'
					AND TO_CHAR(KC.CHECKIN_TIME, 'MM')='$bulan'

			";
			
			return $this->db->query($sql)->result_array();
		}
		
		public function Menampilkan_hasil_survey($id_user, $id_kc, $id_produk){
			
			$sql ="
				SELECT
				HS.ID_PRODUK,
				PS.NAMA_PRODUK,
				HS.ID_KUNJUNGAN_CUSTOMER,
				HS.ID_USER
				FROM CRMNEW_HASIL_SURVEY HS
				LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON HS.ID_PRODUK=PS.ID_PRODUK
				WHERE HS.DELETE_MARK=0
				AND HS.ID_USER='$id_user'
				AND HS.ID_KUNJUNGAN_CUSTOMER='$id_kc'
				AND HS.ID_PRODUK='$id_produk'
			";
			
			return $this->db->query($sql)->result_array();
		}
		
		public function menampilkan_detile_keluhan($id_user, $id_kc, $id_produk){
			
			$sql ="
				SELECT 
				K.ID_KELUHAN,
				K.KELUHAN,
				SKC.JAWABAN
				FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER SKC
				LEFT JOIN CRMNEW_KELUHAN K ON SKC.ID_KELUHAN=K.ID_KELUHAN
				WHERE SKC.DELETE_MARK=0
				AND SKC.ID_KUNJUNGAN_CUSTOMER='$id_kc'
				AND SKC.ID_PRODUK='$id_produk'
				
			";
			
			return $this->db->query($sql)->result_array();
		}
		public function Insert_survey_keluhan($id_user, $id_kc, $id_produk, $Keluhan){
			
			$data = array();
			foreach($Keluhan as $k){
				
				$hasil = array(
					'ID_KELUHAN' 	=> $k['ID_KELUHAN'],
					'DELETE_MARK'	=> '0',
					'CREATE_BY'		=> $id_user,
					'CREATE_DATE'	=> date('d-M-y h.s.i A'),
					'ID_KUNJUNGAN_CUSTOMER' => $id_kc,
					'ID_PRODUK' 	=> $id_produk,
					'JAWABAN'		=> $k['JAWABAN']
				);
				
				array_push($data, $hasil);
				
			}
			
			return $this->db->insert_batch('CRMNEW_SURVEY_KELUHAN_CUSTOMER',$data);
			
		}
		public function Simpan_survey_produk($id_user, $produk){
			
			$data =array();
			foreach($produk as $p){
				
				$hasil = array(
					'ID_USER'					=> $id_user,
					'ID_TOKO'					=> $p['ID_CUSTOMER'],
					'ID_PRODUK'					=> $p['ID_PRODUK'],
					'STOK_SAAT_INI'				=> $p['STOK_SAAT_INI'],
					'VOLUME_PEMBELIAN'			=> $p['VOLUME_PEMBELIAN'],
					'HARGA_PEMBELIAN'			=> $p['HARGA_PEMBELIAN'],
					'TGL_PEMBELIAN'				=> date('d-M-Y', strtotime($p['TGL_PEMBELIAN'])),
					'TOP_PEMBELIAN'				=> $p['TOP_PEMBELIAN'],
					'VOLUME_PENJUALAN'			=> $p['VOLUME_PENJUALAN'],
					'HARGA_PENJUALAN'			=> $p['HARGA_PENJUALAN'],
					'KAPASITAS_TOKO'			=> $p['KAPASITAS_TOKO'],
					'ID_KUNJUNGAN_CUSTOMER'		=> $p['ID_KUNJUNGAN_CUSTOMER'],
					'CREATE_BY'					=> $id_user,
					'CREATE_DATE'				=> date('d-M-y h.s.i A'),
					'DELETE_MARK'				=> 0
				);
				
				array_push($data, $hasil);

			}
			
			$hasil = $this->db->insert_batch('CRMNEW_HASIL_SURVEY',$data);
			if($hasil){
				$baris = count($data);
				
				$sql ="
					SELECT
					PRODUK.*,
					PS.NAMA_PRODUK
					FROM 
						(
									SELECT
										  HASIL.*
										FROM 
										(
											SELECT 
												ID_HASIL_SURVEY,
												ID_USER,
												ID_TOKO,
												ID_PRODUK,
												STOK_SAAT_INI,
												VOLUME_PEMBELIAN,
												HARGA_PEMBELIAN,
												TO_CHAR(TGL_PEMBELIAN, 'YYYY-MM-DD') AS TGL_PEMBELIAN,
												TOP_PEMBELIAN,
												VOLUME_PENJUALAN,
												HARGA_PENJUALAN,
												KAPASITAS_TOKO,
												ID_KUNJUNGAN_CUSTOMER
											FROM CRMNEW_HASIL_SURVEY
											ORDER BY ID_HASIL_SURVEY DESC
										) HASIL
										WHERE ROWNUM <='$baris'    
						) PRODUK
					LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PRODUK.ID_PRODUK=PS.ID_PRODUK

				";
				
				return $this->db->query($sql)->result_array();
			}
			else {
				return null;
			}
			
		}

		
		public function Add_survey_promosi_per_user($id_user, $promosi){
			
			$data = array();
			foreach($promosi as $p){
				
				$hasil = array(
					'ID_PROMOSI'			=> $p['ID_PROMOSI'],
					'DELETE_MARK'			=> 0,
					'CREATE_BY'				=> $id_user,
					'CREATE_DATE'			=> date('d-M-y h.s.i A'),
					'ID_PRODUK'				=> $p['ID_PRODUK'],
					'ID_KUNJUNGAN_CUSTOMER' => $p['ID_KUNJUNGAN_CUSTOMER'],
					'JAWABAN'				=> $p['JAWABAN']
				);
				
				array_push($data, $hasil);
				
			}
			
			$hasil = $this->db->insert_batch('CRMNEW_SURVEY_PROMO_CUSTOMER', $data);
			
			if($hasil){
				$baris = count($data);
				
				$sql ="
					SELECT
					*
					FROM 
						(
							SELECT 
							PC.ID_SURVEY_PROMOSI,
							PC.ID_KUNJUNGAN_CUSTOMER,
							PC.ID_PRODUK,
                            PS.NAMA_PRODUK,
							PC.ID_PROMOSI,
							PC.JAWABAN,P.PROMOSI,
                            P.TYPE_INPUT
							FROM CRMNEW_SURVEY_PROMO_CUSTOMER PC
                            LEFT JOIN CRMNEW_PROMOSI P ON PC.ID_PROMOSI=P.ID_PROMOSI
                            LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PC.ID_PRODUK=PS.ID_PRODUK
                            WHERE PC.DELETE_MARK=0
							ORDER BY PC.ID_SURVEY_PROMOSI DESC   
						)
					WHERE ROWNUM <='$baris'
				";
				
				return $this->db->query($sql)->result_array();
			}
			else {
				return null;
			}
		}
		public function Add_survey_keluhan($id_user, $keluhan){
			
			$data = array();
			foreach($keluhan as $k){
				
				$hasil = array(
					'ID_KELUHAN' 	=> $k['ID_KELUHAN'],
					'CREATE_BY' 	=> $id_user,
					'CREATE_DATE' 	=> date('d-M-y h.s.i A'),
					'DELETE_MARK' 	=> 0,
					'ID_KUNJUNGAN_CUSTOMER' => $k['ID_KUNJUNGAN_CUSTOMER'],
					'ID_PRODUK' 	=> $k['ID_PRODUK'],
					'JAWABAN' 		=> $k['JAWABAN']
					
				);
				
				array_push($data, $hasil);
			}
			
			$hasil = $this->db->insert_batch('CRMNEW_SURVEY_KELUHAN_CUSTOMER', $data);
			
			if($hasil){
				$baris = count($data);
				
				$sql ="
					SELECT
					PRODUK.*,
					PS.NAMA_PRODUK
					FROM 
						(
							SELECT
							*
							FROM 
								(
									SELECT
									KC.ID_SURVEY_KELUHAN,
									KC.ID_KELUHAN,
									KC.ID_KUNJUNGAN_CUSTOMER,
									KC.ID_PRODUK,
									KC.JAWABAN,
									K.KELUHAN
									FROM
									CRMNEW_SURVEY_KELUHAN_CUSTOMER KC
                                    LEFT JOIN CRMNEW_KELUHAN K ON KC.ID_KELUHAN=K.ID_KELUHAN
									WHERE KC.DELETE_MARK=0
									ORDER BY KC.ID_SURVEY_KELUHAN DESC    
								)
							WHERE ROWNUM <='$baris'    
						) PRODUK
					LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PRODUK.ID_PRODUK=PS.ID_PRODUK
				";
				
				
				return $this->db->query($sql)->result_array();
			}
			else {
				return null;
			}
		}
		
		public function get_data_survey_keluhan($id_user, $tahun, $bulan){
			
			$sql ="
				SELECT
				HS.ID_HASIL_SURVEY,
				HS.ID_USER,
				HS.ID_KUNJUNGAN_CUSTOMER,
				HS.ID_TOKO,
				C.NAMA_TOKO,
				HS.ID_PRODUK,
				PS.NAMA_PRODUK,
				TO_CHAR(HS.CREATE_DATE, 'YYYY-MM-DD') AS TGL_SURVEY
				FROM CRMNEW_HASIL_SURVEY HS
				LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON HS.ID_PRODUK=PS.ID_PRODUK
				LEFT JOIN CRMNEW_CUSTOMER C ON HS.ID_TOKO=C.ID_CUSTOMER
				WHERE HS.DELETE_MARK=0
				AND HS.ID_USER='$id_user'
				AND TO_CHAR(HS.CREATE_DATE, 'YYYY')='$tahun'
				AND TO_CHAR(HS.CREATE_DATE, 'MM')='$bulan'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function get_data_survey_detile_keluhan($id_user, $tahun, $bulan){
			
			$sql ="
				SELECT
				SKC.ID_KUNJUNGAN_CUSTOMER,
				SKC.ID_PRODUK,
				PS.NAMA_PRODUK,
				SKC.ID_SURVEY_KELUHAN,
				SKC.ID_KELUHAN,
				K.KELUHAN,
				SKC.JAWABAN,
				TO_CHAR(HS.CREATE_DATE, 'YYYY-MM-DD') AS TGL_SURVEY
				FROM CRMNEW_SURVEY_KELUHAN_CUSTOMER SKC
				LEFT JOIN CRMNEW_HASIL_SURVEY HS ON SKC.ID_KUNJUNGAN_CUSTOMER=HS.ID_KUNJUNGAN_CUSTOMER
					AND SKC.ID_PRODUK=HS.ID_PRODUK 
				LEFT JOIN CRMNEW_KELUHAN K ON SKC.ID_KELUHAN=K.ID_KELUHAN
				LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON SKC.ID_PRODUK=PS.ID_PRODUK
				WHERE HS.DELETE_MARK=0
				AND SKC.DELETE_MARK=0
				AND HS.ID_USER='$id_user'
				AND TO_CHAR(HS.CREATE_DATE, 'YYYY')='$tahun'
				AND TO_CHAR(HS.CREATE_DATE, 'MM')='$bulan'
			";
			
			return $this->db->query($sql)->result_array();
		}
		
		public function Delete_produk($id_user, $hasil_survey){
			
			// $where = '';
			// $n=0;
			
			// for($i=0; $i<count($hasil_survey); $i++){
				// if($i==(count($hasil_survey)-1)){
					// $where .= $hasil_survey[$i]['ID_HASIL_SURVEY']. '';
				// }
				// else {
					// $where .= $hasil_survey[$i]['ID_HASIL_SURVEY']. ',';
				// }
			// }
			
			
			$sql ="
				UPDATE 
				CRMNEW_HASIL_SURVEY
				SET 
					DELETE_MARK=1,
					UPDATE_BY='$id_user',
					UPDATE_DATE=SYSDATE
				WHERE 
				ID_HASIL_SURVEY IN ($hasil_survey)
			";
			
			$hasil = $this->db->query($sql);
			
			if($hasil){
				
				$SQL =" 
					SELECT
					ID_HASIL_SURVEY,
					ID_KUNJUNGAN_CUSTOMER,
					ID_TOKO,
					ID_PRODUK
					FROM CRMNEW_HASIL_SURVEY
					WHERE ID_HASIL_SURVEY IN ($hasil_survey)
				";
				
				return $this->db->query($SQL)->result_array();
				
			}
			else {
				return null;
			}
		}
		public function delete_promosi($id_user, $hasil_survey){
			
			// $where = '';
			// $n=0;
			
			// for($i=0; $i<count($hasil_survey); $i++){
				// if($i==(count($hasil_survey)-1)){
					// $where .= $hasil_survey[$i]['ID_SURVEY_PROMOSI']. '';
				// }
				// else {
					// $where .= $hasil_survey[$i]['ID_SURVEY_PROMOSI']. ',';
				// }
			// }
			
			
			$sql ="
				UPDATE CRMNEW_SURVEY_PROMO_CUSTOMER
				SET 
					DELETE_MARK=1,
					UPDATE_BY='$id_user',
					UPDATE_DATE=SYSDATE
				WHERE ID_SURVEY_PROMOSI IN ($hasil_survey)
					
			";
			
			$hasil = $this->db->query($sql);
			
			if($hasil){
				
				// $SQL =" 
					// SELECT
					// ID_HASIL_SURVEY,
					// ID_KUNJUNGAN_CUSTOMER,
					// ID_TOKO,
					// ID_PRODUK
					// FROM CRMNEW_HASIL_SURVEY
					// WHERE ID_HASIL_SURVEY IN ($where)
				// ";
				
				// return $this->db->query($SQL)->result_array();
				return 1;
			}
			else {
				return null;
			}
		}
		public function delete_keluhan($id_user, $hasil_survey){
			// $where = '';
			// $n=0;
			
			// for($i=0; $i<count($hasil_survey); $i++){
				// if($i==(count($hasil_survey)-1)){
					// $where .= $hasil_survey[$i]['ID_SURVEY_KELUHAN']. '';
				// }
				// else {
					// $where .= $hasil_survey[$i]['ID_SURVEY_KELUHAN']. ',';
				// }
			// }
			
			
			$sql ="
				UPDATE CRMNEW_SURVEY_KELUHAN_CUSTOMER
				SET 
					DELETE_MARK=1,
					UPDATE_BY='$id_user',
					UPDATE_DATE=SYSDATE
				WHERE ID_SURVEY_KELUHAN IN ($hasil_survey)
					
			";
			
			$hasil = $this->db->query($sql);
			
			if($hasil){
				
				// $SQL =" 
					// SELECT
					// ID_HASIL_SURVEY,
					// ID_KUNJUNGAN_CUSTOMER,
					// ID_TOKO,
					// ID_PRODUK
					// FROM CRMNEW_HASIL_SURVEY
					// WHERE ID_HASIL_SURVEY IN ($where)
				// ";
				
				// return $this->db->query($SQL)->result_array();
				return 1;
			}
			else {
				return null;
			}
		}
		public function get_data_survey_detile_promosi($id_user, $tahun, $bulan){
			
			$sql ="
				SELECT
				PC.ID_SURVEY_PROMOSI,
				PC.ID_KUNJUNGAN_CUSTOMER,
				PC.ID_PRODUK,
				PS.NAMA_PRODUK,
				PC.ID_PROMOSI,
				P.PROMOSI,
				P.TYPE_INPUT,
				PC.JAWABAN,
				P.LABEL_FIELD,
				HS.ID_USER,
				TO_CHAR(HS.CREATE_DATE, 'YYYY-MM-DD') AS TGL_SURVEY
				FROM CRMNEW_SURVEY_PROMO_CUSTOMER PC
				LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON PC.ID_PRODUK=PS.ID_PRODUK
				LEFT JOIN CRMNEW_PROMOSI P ON PC.ID_PROMOSI=P.ID_PROMOSI
				LEFT JOIN CRMNEW_HASIL_SURVEY HS ON PC.ID_KUNJUNGAN_CUSTOMER=HS.ID_KUNJUNGAN_CUSTOMER
							AND HS.ID_PRODUK=PC.ID_PRODUK
				WHERE PC.DELETE_MARK=0
				AND HS.ID_USER='$id_user'
				AND TO_CHAR(HS.CREATE_DATE, 'YYYY')='$tahun'
				AND TO_CHAR(HS.CREATE_DATE, 'MM')='$bulan'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function Update_Hasil_survey($id_user, $hasil_survey){
			
			$status =null;
			foreach($hasil_survey as $h){
				$pk 			= $h['ID_HASIL_SURVEY'];
				$id_produk 		= $h['ID_PRODUK'];
				$stok 			= $h['STOK_SAAT_INI'];
				$volume_beli	= $h['VOLUME_PEMBELIAN'];
				$tgl_beli 		= date('d-M-Y', strtotime($h['TGL_PEMBELIAN']));
				$hb				= $h['HARGA_PEMBELIAN'];
				$top 			= $h['TOP_PEMBELIAN'];
				$volume_jual 	= $h['VOLUME_PENJUALAN'];
				$harga_jual     = $h['HARGA_PENJUALAN'];
				
				
				$sql = "
				UPDATE CRMNEW_HASIL_SURVEY
					SET 
					ID_PRODUK='$id_produk',
					STOK_SAAT_INI='$stok',
					VOLUME_PEMBELIAN='$volume_beli',
					HARGA_PEMBELIAN='$hb',
					TGL_PEMBELIAN='$tgl_beli',
					TOP_PEMBELIAN='$top',
					VOLUME_PENJUALAN='$volume_jual',
					HARGA_PENJUALAN='$harga_jual',
					UPDATE_BY='$id_user',
					UPDATE_DATE=SYSDATE
				WHERE ID_HASIL_SURVEY='$pk'
				";
				$hasil = $this->db->query($sql);
				
				if($hasil){
					$status =1;
				}
			}
			
			return $status;
		}
		public function Update_Hasil_survey_keluhan($id_user, $hasil_survey){
			
			$status =null;
			foreach($hasil_survey as $h){
				$pk 			= $h['ID_SURVEY_KELUHAN'];
				$id_produk 		= $h['ID_PRODUK'];
				$idkc 			= $h['ID_KUNJUNGAN_CUSTOMER'];
				$id_keluhan		= $h['ID_KELUHAN'];
				$jawaban 		= $h['JAWABAN'];
				
				
				$sql = "
				UPDATE CRMNEW_SURVEY_KELUHAN_CUSTOMER
				SET 
				ID_KELUHAN='$id_keluhan',
				ID_PRODUK='$id_produk',
				ID_KUNJUNGAN_CUSTOMER='$idkc',
				JAWABAN='$jawaban',
				UPDATE_BY='$id_user',
				UPDATE_DATE=SYSDATE
				WHERE ID_SURVEY_KELUHAN='$pk'
				";
				$hasil = $this->db->query($sql);
				
				if($hasil){
					$status =1;
				}
			}
			
			return $status;
		}
		public function Update_Hasil_survey_promosi($id_user, $hasil_survey){
			
			$status =null;
			foreach($hasil_survey as $h){
				$pk 			= $h['ID_SURVEY_PROMOSI'];
				$id_produk 		= $h['ID_PRODUK'];
				$idkc 			= $h['ID_KUNJUNGAN_CUSTOMER'];
				$id_promosi		= $h['ID_PROMOSI'];
				$jawaban 		= $h['JAWABAN'];
				
				
				$sql = "
				UPDATE CRMNEW_SURVEY_PROMO_CUSTOMER
				SET 
				ID_PROMOSI='$id_promosi',
				ID_PRODUK='$id_produk',
				ID_KUNJUNGAN_CUSTOMER='$idkc',
				JAWABAN='$jawaban',
				UPDATE_BY='$id_user',
				UPDATE_DATE=SYSDATE
				WHERE ID_SURVEY_PROMOSI='$pk'
				";
				$hasil = $this->db->query($sql);
				
				if($hasil){
					$status =1;
				}
			}
			
			return $status;
			
		}
		
		public function Update_Chekin($id_user, $id_kc, $latitude, $longtitude, $Out_latitude, $Out_longtitude, $checkin_time){
			
			$sql ="
				UPDATE CRMNEW_KUNJUNGAN_CUSTOMER
				SET
				CHECKIN_TIME='$checkin_time',
				CHECKIN_LATITUDE='$latitude',
				CHECKIN_LONGITUDE='$longtitude',
				CHECKOUT_TIME=SYSDATE,
				CHECKOUT_LATITUDE='$Out_latitude',
				CHECKOUT_LONGITUDE='$Out_longtitude',
				UPDATED_BY='$id_user',
				UPDATED_AT=SYSDATE
				WHERE ID_KUNJUNGAN_CUSTOMER='$id_kc'
				AND ID_USER='$id_user'
			";
			
			$hasil = $this->db->query($sql);
			
			return $hasil;	
		}
		
		public function update_checkin_user($id_user, $hasil_survey){
			
			$status =null;
			$date = date('Y-m-d H:i:s');
			
			foreach($hasil_survey as $h){
				
				$idkc 				= $h["ID_KUNJUNGAN_CUSTOMER"];
				$latitude 			= $h["CHECKIN_LATITUDE"];
				$longitude 			= $h['CHECKIN_LONGITUDE'];
				$cekout_latitude 	= $h['CHECKOUT_LATITUDE'];
				$cekout_longitude	= $h['CHECKOUT_LONGITUDE'];
				$checkin_time 		= $h['CHECKIN_TIME'];
				$checkout_time 		= $h['CHECKOUT_TIME'];
				
				
				$sql ="
					UPDATE CRMNEW_KUNJUNGAN_CUSTOMER
					SET
					CHECKIN_TIME=TO_DATE('$checkin_time', 'YYYY-MM-DD HH24:MI:SS'),
					CHECKIN_LATITUDE='$latitude',
					CHECKIN_LONGITUDE='$longitude',
					CHECKOUT_TIME=TO_DATE('$checkout_time', 'YYYY-MM-DD HH24:MI:SS'),
					CHECKOUT_LATITUDE='$cekout_latitude',
					CHECKOUT_LONGITUDE='$cekout_longitude',
					UPDATED_BY='$id_user',
					UPDATED_AT=SYSDATE
					WHERE ID_KUNJUNGAN_CUSTOMER='$idkc'
					AND ID_USER='$id_user'
				";
				
				$hasil = $this->db->query($sql);
				
				$status = 1;
			}
			return $status;
		}
		
		public function Update_Chekout($id_user, $id_kc, $latitude, $longtitude){
			
			$sql ="
				UPDATE CRMNEW_KUNJUNGAN_CUSTOMER
				SET
				CHECKOUT_TIME=SYSDATE,
				CHECKOUT_LATITUDE='$latitude',
				CHECKOUT_LONGITUDE='$longtitude',
				UPDATED_BY='$id_user',
				UPDATED_AT=SYSDATE
				WHERE ID_KUNJUNGAN_CUSTOMER='$id_kc'
				AND ID_USER='$id_user'

			";
			
			$hasil = $this->db->query($sql);
			
			return $hasil;	
		}
		public function get_tampilan_survey_kualitatif($user, $tahun, $bulan){
			
			$sql ="
				SELECT
					ID_SURVEY_KUALITATIF,
					ID_USER,
					JAWABAN,
					TO_CHAR(CREATE_AT, 'YYYY-MM-DD') AS CREATE_AT
				FROM CRMNEW_SURVEY_KUALITATIF
				WHERE DELETE_MARK=0
				AND ID_USER='$user'
				AND TO_CHAR(CREATE_AT, 'YYYY')='$tahun'
				AND TO_CHAR(CREATE_AT, 'MM')='$bulan'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		public function Add_survey_kualitatif($id_user, $insert){
			
			$hasil = $this->db->insert_batch('CRMNEW_SURVEY_KUALITATIF', $insert);
			
			if($hasil){
				$baris = count($insert);
				
				$sql ="
					SELECT
							*
							FROM 
								(
									SELECT
										ID_SURVEY_KUALITATIF,
										ID_USER,
										JAWABAN,
										DELETE_MARK,
										CREATE_BY,
										TO_CHAR(CREATE_AT, 'YYYY-MM-DD') AS CREATE_AT
									FROM CRMNEW_SURVEY_KUALITATIF
									WHERE DELETE_MARK=0
									AND ID_USER='$id_user'
									ORDER BY ID_SURVEY_KUALITATIF DESC    
								)
							WHERE ROWNUM <='$baris'  
				";
				
				
				return $this->db->query($sql)->result_array();
			}
			else {
				return null;
			}
		}
		public function delete_survey_kualitatif($user, $data){
			
			$sql ="
				UPDATE CRMNEW_SURVEY_KUALITATIF
				SET 
				UPDATE_BY='$user',
				UPDATE_AT=SYSDATE,
				DELETE_MARK=1
				WHERE ID_SURVEY_KUALITATIF IN ($data)
			";
			
			$hasil = $this->db->query($sql);
			
			if($hasil){
				
				$SQL2=" 
						SELECT
						* 
						FROM CRMNEW_SURVEY_KUALITATIF
						WHERE ID_SURVEY_KUALITATIF IN ($data)
				";
				//echo $SQL2;
				return $this->db->query($SQL2)->result_array();
				
			}
			else {
				
				return null;
			}
		}
		public function update_data_kualitatif($user, $data){
			
			$status = null;
			foreach($data as $d){
				
				$jawaban 	= $d['JAWABAN'];
				$idsk 		= $d['ID_SURVEY_KUALITATIF'];
				
				$sql ="
					UPDATE CRMNEW_SURVEY_KUALITATIF
					SET 
					JAWABAN='$jawaban',
					UPDATE_BY='$user',
					UPDATE_AT=SYSDATE
					WHERE ID_SURVEY_KUALITATIF ='$idsk'
				";
			
				$hasil = $this->db->query($sql);
				
				if($hasil){
					$status=1;
				}
			}
			return $status;
		}
		
	}
?>
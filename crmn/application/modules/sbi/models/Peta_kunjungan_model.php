<?php
    class Peta_kunjungan_model extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
        
        public function jadwalKunjungan($id_customer, $stardate, $enddate){
            $sql ="
				SELECT DISTINCT
					CC.ID_TOKO AS ID_CUSTOMER,
					TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'DD-MM-YYYY') AS TGL_RENCANA_KUNJUNGAN,
					CC.KETERANGAN
				FROM CRMNEW_KUNJUNGAN_CUSTOMER CC
				WHERE CC.DELETED_MARK = 0 AND CC.ID_TOKO IS NOT NULL
				AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') BETWEEN '$stardate' AND '$enddate'
			";
			
			if($id_customer!=null){
				$sql .= " AND CC.ID_TOKO='$id_customer' ";
			}
            
            $data = $this->db->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }
		
		public function Data_Survey($id_survey){
            $sql ="
				SELECT  
				HS.ID_KUNJUNGAN_CUSTOMER,
				PD.NAMA_PRODUK,
				HS.STOK_SAAT_INI,
				HS.VOLUME_PEMBELIAN,
				HS.HARGA_PEMBELIAN,
				HS.TGL_PEMBELIAN,
				HS.VOLUME_PENJUALAN,
				HS.HARGA_PENJUALAN
				FROM 
				HASIL_SURVEY_CUSTOMER HS
				LEFT JOIN CRMNEW_PRODUK_SURVEY PD
				ON HS.ID_PRODUK = PD.ID_PRODUK
				WHERE ID_KUNJUNGAN_CUSTOMER = '$id_survey'
			";
            
            $data = $this->db->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }
		
		public function TotalToko($id_tso){
            $sql ="
				SELECT COUNT(NAMA_TOKO) AS JML FROM R_REPORT_TOKO_SALES WHERE ID_TSO = '$id_tso'
			";
			
			$data = $this->db->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }
		
		public function TotalKunjungan($id_tso, $stardate, $enddate){
			/*
            $sql ="
				SELECT
                COUNT(TD.REALISASI) AS KUNJUNGAN
                FROM CRMNEW_TOKO_SALES TS
                LEFT JOIN M_SALES_DISTRIBUTOR SD ON TS.ID_SALES=SD.ID_USER
                    AND TS.ID_TSO=SD.ID_TSO
                LEFT JOIN M_CUSTOMER MC ON TS.KD_CUSTOMER=MC.ID_CUSTOMER
                    AND SD.KODE_DISTRIBUTOR=MC.ID_DISTRIBUTOR
                LEFT JOIN (
                        SELECT
                        T.ID_KUNJUNGAN_CUSTOMER,
                        T.ID_USER,
                        T.ID_TOKO,
                        T.NAMA_TOKO,
                        T.ALAMAT,
                        T.ID_PROVINSI,
                        T.ID_AREA,
                        R.RENCANA,
                        R.REALISASI
                        FROM
                            (   SELECT  ID_TOKO,
                                        TGL_RENCANA_KUNJUNGAN AS RENCANA,
                                        TO_CHAR(CHECKIN_TIME, 'DD-MM-YYYY') AS REALISASI
                                FROM T_KUNJUNGAN_SALES_KE_TOKO 
                                WHERE TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') BETWEEN '2019-12-19' AND '2020-01-02'
                            )R
                        INNER JOIN T_KUNJUNGAN_SALES_KE_TOKO T ON T.ID_TOKO = R.ID_TOKO AND T.TGL_RENCANA_KUNJUNGAN = R.RENCANA
                        WHERE KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0' AND ID_USER='3239')
                        AND ID_USER IN (SELECT ID_SALES FROM CRMNEW_USER_SALES WHERE DELETE_MARK='0' AND ID_USER='3239')
                            ) TD ON TS.KD_CUSTOMER=TD.ID_TOKO
                WHERE TS.DELETE_MARK='0'
                AND TS.ID_TSO = '3239' AND MC.NAMA_TOKO IS NOT NULL
			";
			*/
			
			$sql = "
			SELECT
				COUNT(TD.REALISASI) AS KUNJUNGAN
                FROM MAPPING_TOKO_DIST_SALES TS
					LEFT JOIN M_CUSTOMER MC ON TS.ID_CUSTOMER=MC.ID_CUSTOMER
						AND TS.ID_DISTRIBUTOR=MC.ID_DISTRIBUTOR
					LEFT JOIN (
                        SELECT
                        T.ID_KUNJUNGAN_CUSTOMER,
                        R.ID_TOKO,
                        R.RENCANA,
                        R.REALISASI
                        FROM
                        (   SELECT  ID_TOKO,
                                MAX(TGL_RENCANA_KUNJUNGAN)AS RENCANA,
                                MAX(TO_CHAR(CHECKIN_TIME, 'DD-MM-YYYY')) AS REALISASI
                            FROM T_KUNJUNGAN_SALES_KE_TOKO 
                            WHERE TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') BETWEEN '$stardate' AND '$enddate'
                            GROUP BY ID_TOKO
                        ) R
						INNER JOIN T_KUNJUNGAN_SALES_KE_TOKO T ON T.ID_TOKO = R.ID_TOKO AND T.TGL_RENCANA_KUNJUNGAN = R.RENCANA	
                    ) TD ON TS.ID_CUSTOMER=TD.ID_TOKO
                WHERE TS.ID_SALES IN (SELECT DISTINCT(ID_SALES) FROM HIRARCKY_GSM_TO_DISTRIBUTOR WHERE ID_SO IS NOT NULL AND ID_SO = '$id_tso')
			";
			
			$data = $this->db->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }
		
        public function petaTokoTso($id_tso, $stardate, $enddate){
			/*
            $sql = "
                SELECT
                TS.ID_SALES, 
                SD.NAMA,
                TS.ID_TSO,
                SD.NAMA_TSO,
                SD.KODE_DISTRIBUTOR,
                SD.NAMA_DISTRIBUTOR,
                TS.KD_CUSTOMER,
                MC.NAMA_TOKO,
                MC.ALAMAT,
                MC.NAMA_PEMILIK,
                MC.TELP_TOKO,
                MC.ID_PROVINSI,
                MC.NAMA_PROVINSI,
                MC.ID_DISTRIK,
                MC.NAMA_DISTRIK,
                MC.ID_AREA,
                MC.NAMA_AREA,
                MC.NAMA_KECAMATAN,
                MC.LATITUDE,
                MC.LONGITUDE,
				MC.KAPASITAS_ZAK,
				TD.ID_KUNJUNGAN_CUSTOMER,
                TD.RENCANA,
                TD.REALISASI AS KUNJUNGAN
                FROM CRMNEW_TOKO_SALES TS
					LEFT JOIN M_SALES_DISTRIBUTOR SD ON TS.ID_SALES=SD.ID_USER
						AND TS.ID_TSO=SD.ID_TSO
					LEFT JOIN M_CUSTOMER MC ON TS.KD_CUSTOMER=MC.ID_CUSTOMER
						AND SD.KODE_DISTRIBUTOR=MC.ID_DISTRIBUTOR
					LEFT JOIN (
                        SELECT
                        T.ID_KUNJUNGAN_CUSTOMER,
                        T.ID_USER,
                        T.ID_TOKO,
                        T.NAMA_TOKO,
                        T.ALAMAT,
                        T.ID_PROVINSI,
                        T.ID_AREA,
                        R.RENCANA,
                        R.REALISASI
                        FROM
                            (   SELECT  ID_TOKO,
                                        MAX(TGL_RENCANA_KUNJUNGAN)AS RENCANA,
                                        MAX(TO_CHAR(CHECKIN_TIME, 'DD-MM-YYYY')) AS REALISASI
                                FROM T_KUNJUNGAN_SALES_KE_TOKO 
                                WHERE TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') BETWEEN '$stardate' AND '$enddate'
                                GROUP BY ID_TOKO
                            ) R
							INNER JOIN T_KUNJUNGAN_SALES_KE_TOKO T ON T.ID_TOKO = R.ID_TOKO AND T.TGL_RENCANA_KUNJUNGAN = R.RENCANA
							WHERE KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0' AND ID_USER='$id_tso')
							AND ID_USER IN (SELECT ID_SALES FROM CRMNEW_USER_SALES WHERE DELETE_MARK='0' AND ID_USER='$id_tso')
                    ) TD ON TS.KD_CUSTOMER=TD.ID_TOKO
                WHERE TS.DELETE_MARK='0'
                AND TS.ID_TSO = '$id_tso' AND MC.NAMA_TOKO IS NOT NULL
            ";
            */
			
			$sql = "
				SELECT
                TS.ID_CUSTOMER as KD_CUSTOMER,
                TS.ID_SALES,
                TS.USERNAME as NAMA,
                TS.ID_DISTRIBUTOR as KODE_DISTRIBUTOR,
                TS.NAMA_DISTRIBUTOR,
                
                MC.NAMA_TOKO,
                MC.ALAMAT,
                MC.NAMA_PEMILIK,
                MC.TELP_TOKO,
                MC.ID_PROVINSI,
                MC.NAMA_PROVINSI,
                MC.ID_DISTRIK,
                MC.NAMA_DISTRIK,
                MC.ID_AREA,
                MC.NAMA_AREA,
                MC.NAMA_KECAMATAN,
                MC.LATITUDE,
                MC.LONGITUDE,
				MC.KAPASITAS_ZAK,
                -- 
				TD.ID_KUNJUNGAN_CUSTOMER,
                TD.RENCANA,
                TD.REALISASI AS KUNJUNGAN
                FROM MAPPING_TOKO_DIST_SALES TS
					LEFT JOIN M_CUSTOMER MC ON TS.ID_CUSTOMER=MC.ID_CUSTOMER
						AND TS.ID_DISTRIBUTOR=MC.ID_DISTRIBUTOR
					LEFT JOIN (
                        SELECT
                        T.ID_KUNJUNGAN_CUSTOMER,
                        R.ID_TOKO,
                        R.RENCANA,
                        R.REALISASI
                        FROM
                        (   SELECT  ID_TOKO,
                                MAX(TGL_RENCANA_KUNJUNGAN)AS RENCANA,
                                MAX(TO_CHAR(CHECKIN_TIME, 'DD-MM-YYYY')) AS REALISASI
                            FROM T_KUNJUNGAN_SALES_KE_TOKO 
                            WHERE TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') BETWEEN '$stardate' AND '$enddate'
                            GROUP BY ID_TOKO
                        ) R
						INNER JOIN T_KUNJUNGAN_SALES_KE_TOKO T ON T.ID_TOKO = R.ID_TOKO AND T.TGL_RENCANA_KUNJUNGAN = R.RENCANA	
                    ) TD ON TS.ID_CUSTOMER=TD.ID_TOKO
                WHERE TS.ID_SALES IN (SELECT DISTINCT(ID_SALES) FROM HIRARCKY_GSM_TO_DISTRIBUTOR WHERE ID_SO IS NOT NULL AND ID_SO = '$id_tso')
                
                ORDER BY TD.ID_KUNJUNGAN_CUSTOMER
			";
            $data = $this->db->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }
		
		
		public function listTsoSm($id_sm){        // list for sm
            $sql = "
                SELECT DISTINCT(ID_SO), NAMA_SO 
                FROM HIRARCKY_GSM_TO_DISTRIBUTOR
                WHERE ID_SO IS NOT NULL AND ID_SM = '$id_sm'
                ORDER BY NAMA_SO
            "; 
            
            $data = $this->db->query($sql)->result_array();
            return $data;
        }
        
        public function listTsoSsm($id_ssm){        // list for ssm
            $sql = "
                SELECT DISTINCT(ID_SO), NAMA_SO 
                FROM HIRARCKY_GSM_TO_DISTRIBUTOR
                WHERE ID_SO IS NOT NULL AND ID_SSM = '$id_ssm'
                ORDER BY NAMA_SO
            ";
            
            $data = $this->db->query($sql)->result_array();
            return $data;
        }
        
        public function listTsoGsm($id_gsm){        // list for gsm
            $sql = "
                SELECT DISTINCT(ID_SO), NAMA_SO 
                FROM HIRARCKY_GSM_TO_DISTRIBUTOR
                WHERE ID_SO IS NOT NULL AND ID_GSM = '$id_gsm'
                ORDER BY NAMA_SO
            ";
            
            $data = $this->db->query($sql)->result_array();
            return $data;
        }
        
        public function listTsoAdmin($id_gsm){        // list for Admin
            $sql = "
                SELECT DISTINCT(ID_SO), NAMA_SO 
                FROM HIRARCKY_GSM_TO_DISTRIBUTOR
                WHERE ID_SO IS NOT NULL 
                ORDER BY NAMA_SO
            ";
            
            $data = $this->db->query($sql)->result_array();
            return $data;
        }
        
	}
	
?>
<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_kpi_sales extends CI_Model {

        public function userDistributor($idUser){
            $this->db->select("KODE_DISTRIBUTOR");
            $this->db->from("CRMNEW_USER_DISTRIBUTOR");
            $this->db->where("ID_USER", $idUser);
            $this->db->where("DELETE_MARK", 0);
            $distributor = $this->db->get();
            if($distributor->num_rows() > 0){
                return $distributor->row();
            } else {
                return false;
            }
        }

    	public function indexKpi($idDistributor, $month, $year){
            $this->db->select("VOLUME, HARGA, REVENUE, KUNJUNGAN");
            $this->db->from("CRMNEW_INDEX_KPI");
            $this->db->where("KODE_DISTRIBUTOR", $idDistributor);
            $this->db->where("DELETE_MARK", "0");
            $this->db->where("ID_JENIS_USER", "1002");
            $this->db->where("BULAN", $month);
            $this->db->where("TAHUN", $year);
            $index = $this->db->get();
            if($index->num_rows() > 0){
                return $index->row();
            } else {
                return false;
            }
        }

    	public function listSales($start, $limit, $idDistributor){
    		if(isset($idDistributor)){
    			$this->db->where("CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR", $idDistributor);
    		}

            $this->db->select("CRMNEW_USER.ID_USER, CRMNEW_USER.NAMA, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR, CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR");
            $this->db->from("CRMNEW_USER");
            $this->db->join("CRMNEW_USER_DISTRIBUTOR", "CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER", "left");
            $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
            $this->db->limit($limit, $start);
            $this->db->where("CRMNEW_USER.DELETED_MARK", "0");
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", "0");
            $this->db->where("CRMNEW_USER.ID_JENIS_USER", "1003");

            $sales = $this->db->get();
            if($sales->num_rows() > 0){
                return $sales->result();
            } else {
                return false;
            }
        }

        public function targetSales($idUser, $idDistributor, $month, $year){
        	$this->db->select("VOLUME, HARGA, KUNJUNGAN, REVENUE");
        	$this->db->from("CRMNEW_KPI_TARGET_SALES");
        	$this->db->where("ID_SALES", $idUser);
        	$this->db->where("KODE_DISTRIBUTOR", $idDistributor);
        	$this->db->where("BULAN", $month);
        	$this->db->where("TAHUN", $year);
        	$this->db->where("DELETE_MARK", "0");
        	$target = $this->db->get();
        	if($target->num_rows() > 0){
        		return $target->row();
        	} else {
        		return false;
        	}
        }

        public function realisasiVolume($idCustomer, $bulan = null, $tahun = null){
            if($bulan < 10){
                $bulan = "0".$bulan;
            }
            $this->db_tpl = $this->load->database("marketplace", true);
            $idCustomer = "'".str_replace(", ","','", $idCustomer)."'";
            $sql = "SELECT
                        NVL((SUM( VOLUME_40_ZAK ) + SUM( VOLUME_50_ZAK ) + SUM( VOLUME_PUTIH_ZAK )),0) AS REALISASI_VOLUME_ZAK,
                        NVL((SUM( VOLUME_40_TON ) + SUM( VOLUME_50_TON ) + SUM( VOLUME_PUTIH_TON )),0) AS VOLUME,
                        NVL((SUM( REVENUE_40_TON ) + SUM( REVENUE_50_TON ) + SUM( REVENUE_PUTIH_TON )),0) AS REVENUE,
                        ROUND(NULLIF((SUM( REVENUE_40_TON ) + SUM( REVENUE_50_TON ) + SUM( REVENUE_PUTIH_TON )),0) / (SUM( VOLUME_40_TON ) + SUM( VOLUME_50_TON ) + SUM( VOLUME_PUTIH_TON ))) AS HARGA
                    FROM
                        (
                    SELECT DISTINCT
                        A.ID_CUSTOMER,
                        A.NAMA_TOKO,
                        NVL( B.VOLUME_40_ZAK, 0 ) AS VOLUME_40_ZAK,
                        NVL( B.VOLUME_40_TON, 0 ) AS VOLUME_40_TON,
                        NVL( B.REVENUE_40, 0 ) AS REVENUE_40_TON,
                        NVL( B.HARGA_40, 0 ) AS HARGA_40_TON,
                        NVL( C.VOLUME_50_ZAK, 0 ) AS VOLUME_50_ZAK,
                        NVL( C.VOLUME_50_TON, 0 ) AS VOLUME_50_TON,
                        NVL( C.REVENUE_50, 0 ) AS REVENUE_50_TON,
                        NVL( C.HARGA_50, 0 ) AS HARGA_50_TON,
                        NVL( D.VOLUME_PUTIH_ZAK, 0 ) AS VOLUME_PUTIH_ZAK,
                        NVL( D.VOLUME_PUTIH_TON, 0 ) AS VOLUME_PUTIH_TON,
                        NVL( D.REVENUE_PUTIH, 0 ) AS REVENUE_PUTIH_TON,
                        NVL( D.HARGA_PUTIH, 0 ) AS HARGA_PUTIH_TON 
                    FROM
                        SIDIGI_M_TOKO A
                        LEFT JOIN (
                    SELECT
                        KD_TOKO,
                        SUM( QTY ) AS VOLUME_40_ZAK,
                        SUM( QTY  ) AS VOLUME_40_TON,
                        SUM(QTY * HARGA ) AS REVENUE_40,
                        ROUND(SUM(QTY  * HARGA ) / SUM(QTY)) AS HARGA_40 
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        KD_TOKO IN ( $idCustomer ) 
                        AND TO_CHAR( TGL_KIRIM, 'YYYY-MM' ) = '$tahun-$bulan' 
                        AND KD_PRODUK IN ( '10110003', '10110004', '121-301-0050', '121-301-0050 ', '121-301-0110', '121-301-0110P', '121-301-0180' ) 
                    GROUP BY
                        KD_TOKO 
                        ) B ON A.ID_CUSTOMER = B.KD_TOKO
                        LEFT JOIN (
                    SELECT
                        KD_TOKO,
                        SUM( QTY ) AS VOLUME_50_ZAK,
                        SUM( QTY ) AS VOLUME_50_TON,
                        SUM(QTY * HARGA ) AS REVENUE_50,
                        ROUND(SUM(QTY * HARGA ) / SUM( QTY )) AS HARGA_50 
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        KD_TOKO IN ( $idCustomer) 
                        AND TO_CHAR( TGL_KIRIM, 'YYYY-MM' ) = '$tahun-$bulan' 
                        AND KD_PRODUK IN ( '10110001', '10110002', '10110005', '121-301-0020', '121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ' ) 
                    GROUP BY
                        KD_TOKO 
                        ) C ON A.ID_CUSTOMER = C.KD_TOKO
                        LEFT JOIN (
                    SELECT
                        KD_TOKO,
                        SUM( QTY ) AS VOLUME_PUTIH_ZAK,
                        SUM( QTY)  AS VOLUME_PUTIH_TON,
                        SUM(QTY  * HARGA ) AS REVENUE_PUTIH,
                        ROUND(SUM(QTY * HARGA ) / SUM( QTY )) AS HARGA_PUTIH 
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        KD_TOKO IN ( $idCustomer) 
                        AND TO_CHAR( TGL_KIRIM, 'YYYY-MM' ) = '$tahun-$bulan' 
                        AND KD_PRODUK IN ( '121-301-0240' ) 
                    GROUP BY
                        KD_TOKO 
                        ) D ON A.ID_CUSTOMER = D.KD_TOKO 
                    WHERE
                        A.ID_CUSTOMER IN ( $idCustomer))";
            $realisasiSales = $this->db_tpl->query($sql);
            return $realisasiSales->row();
        }

        public function realisasiKunjungan($idUser, $month, $year){
        	if($month < 10){
        		$month = "0".$month;
        	}

        	$this->db->select("COUNT(ID_KUNJUNGAN_CUSTOMER) AS TOTAL_KUNJUNGAN");
        	$this->db->from("CRMNEW_KUNJUNGAN_CUSTOMER");
        	$this->db->where("ID_USER", $idUser);
        	$this->db->where("TO_CHAR(CHECKIN_TIME, 'MM') =", $month);
        	$this->db->where("TO_CHAR(CHECKIN_TIME, 'YYYY') =", $year);
        	$this->db->where("CHECKIN_TIME IS NOT NULL");
        	$this->db->where("DELETED_MARK", "0");


        	$kunjungan = $this->db->get();
        	if($kunjungan->num_rows() > 0){
        		return $kunjungan->row();
        	} else {
        		return false;
        	}
        }

        public function getTokoSales($idUser){
            $this->db->select("LISTAGG(ID_CUSTOMER, ',') WITHIN GROUP (ORDER BY ID_CUSTOMER) AS ID_CUSTOMER");
            $this->db->from("CRMNEW_ASSIGN_TOKO_SALES");
            $this->db->where("ID_USER", $idUser);
            $this->db->where("DELETE_MARK", "0");
            $toko = $this->db->get();
            if($toko->num_rows() > 0){
                return $toko->row();
            } else {
                return false;
            }
        }

    }
?>
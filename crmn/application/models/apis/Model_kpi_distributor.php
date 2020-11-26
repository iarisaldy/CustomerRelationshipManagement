<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_kpi_distributor extends CI_Model {

    	public function indexKpi($idDistributor, $month, $year){
            $this->db->select("VOLUME, HARGA, REVENUE, KUNJUNGAN, TARGET_KUNJUNGAN");
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

        public function targetVolume($idDistributor, $month, $year){
        	$this->db->select("VOLUME");
        	$this->db->from("CRMNEW_TARGET_VOLUME_KPI");
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
        public function targetHarga($idDistributor, $month, $year){
            $this->db->select("HARGA");
            $this->db->from("CRMNEW_TARGET_HARGA_KPI");
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

        public function realisasiDistributor($idDistributor, $bulan = null, $tahun = null){
            if($bulan < 10){
                $bulan = "0".$bulan;
            }
            $this->db_tpl = $this->load->database("marketplace", true);
            $sql = "SELECT
                        SUM( QTY / 25 ) AS VOLUME,
                        SUM((QTY / 25 ) * (HARGA) * 25) AS REVENUE,
                        ROUND(SUM((QTY ) * (HARGA) * 25) / SUM( QTY )) AS HARGA 
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        KD_DISTRIBUTOR = '$idDistributor' 
                        AND TO_CHAR( TGL_KIRIM, 'YYYY-MM' ) = '$tahun-$bulan' 
                        AND DELETE_MARK = '0'";
            $realisasiSales = $this->db_tpl->query($sql);
            return $realisasiSales->row();
        }

        public function realisasiKunjungan($idDistributor, $month, $year){
        	if($month < 10){
        		$month = "0".$month;
        	}

        	$sql = "SELECT
                        CRMNEW_CUSTOMER.ID_DISTRIBUTOR,
                        COUNT( CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER ) AS REALISASI_KUNJUNGAN 
                    FROM
                        CRMNEW_KUNJUNGAN_CUSTOMER
                        JOIN CRMNEW_CUSTOMER ON CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO = CRMNEW_CUSTOMER.ID_CUSTOMER
                        JOIN CRMNEW_USER ON CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER 
                    WHERE
                        CRMNEW_CUSTOMER.ID_DISTRIBUTOR = '$idDistributor' 
                        AND TO_CHAR( CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'YYYY' ) = '$year' 
                        AND TO_CHAR( CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'MM' ) = '$month' 
                        AND CRMNEW_USER.ID_JENIS_USER = '1003' 
                        AND CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME IS NOT NULL
                    GROUP BY
                        CRMNEW_CUSTOMER.ID_DISTRIBUTOR";
            $kunjungan = $this->db->query($sql);
        	if($kunjungan->num_rows() > 0){
        		return $kunjungan->row();
        	} else {
        		return false;
        	}
        }

    }
?>
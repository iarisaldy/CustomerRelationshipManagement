<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_dashboard_kunjungan extends CI_Model {
		
		public function kunjunganHarian($idDistributor, $month, $year){
			$sql = "SELECT
                TO_CHAR( CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'DD' ) AS TGL,
                COUNT( CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER ) AS TOTAL 
            FROM
                CRMNEW_KUNJUNGAN_CUSTOMER 
            JOIN CRMNEW_USER ON CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER
            LEFT JOIN CRMNEW_USER_DISTRIBUTOR ON CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER
            WHERE
                TO_CHAR( CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'MM' ) = '$month' 
                AND TO_CHAR( CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'YYYY' ) = '$year'
                AND CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK = '0' AND CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME IS NOT NULL
                AND CRMNEW_USER_DISTRIBUTOR.DELETE_MARK = '0'
                AND CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = '$idDistributor' 
                AND CRMNEW_USER_DISTRIBUTOR.DELETE_MARK = '0' AND CRMNEW_USER.ID_JENIS_USER = '1003'
            GROUP BY
                TO_CHAR(
                CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME,
                'DD')";
			
			$kunjunganHarian = $this->db->query($sql);
            if($kunjunganHarian->num_rows() > 0){
                return $kunjunganHarian->result();
            } else {
                return false;
            }
			
		}

    }
?>
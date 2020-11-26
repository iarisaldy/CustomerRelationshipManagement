<?php
    class Model_cluster extends CI_Model {

        public function __construct(){
            parent::__construct();  
        }

        public function cluster($idProvinsi = null, $month, $idCustomer = null, $kodeLt = null){
        	$db_point = $this->load->database("Point", true);
            $year = date('Y');
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1005" || $idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1007"){
            	$idDistributor = $this->session->userdata("kode_dist");
            	$whereDistributor = "M_CUS.NOMOR_DISTRIBUTOR = '$idDistributor'";
                $whereProvinsi = "";
            } else {
            	$whereDistributor = "M_CUS.NOMOR_DISTRIBUTOR IS NOT NULL";
                $whereProvinsi = "AND M_CUS.KD_PROVINSI = $idProvinsi";
            }

            $whereCustomer = "";
            if(isset($idCustomer)){
                $whereCustomer = "AND M_CUS.KD_CUSTOMER = '$idCustomer'";
            }

            $whereLt = "";
            if(isset($kodeLt)){
                if($kodeLt != ""){
                    $whereLt = "AND M_CUS.KD_LT = '$kodeLt'";
                }
            }

            if(isset($idProvinsi)){
                if($idProvinsi == "1025"){
                    $parameter = "CASE
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 2200 THEN 'SUPER PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 680 AND 2199 THEN 'PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 400 AND 679 THEN 'GOLD' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 280 AND 399 THEN 'SILVER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 279 THEN 'NON CLUSTER' 
                    WHEN NVL(SUM(PP.PENJUALAN + PP.PENJUALAN_SP),0) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR";
                // Parameter Jateng & DIY
                } else if($idProvinsi == "1023" || $idProvinsi == "1024"){
                    $parameter = "CASE
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 320 THEN 'PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 200 AND 319 THEN 'GOLD' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 199 THEN 'NON CLUSTER' 
                    WHEN NVL(SUM(PP.PENJUALAN + PP.PENJUALAN_SP),0) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR";
                // Parameter Jabar, DKI & Banten
                } else if($idProvinsi == "1022" || $idProvinsi == "1021" || $idProvinsi == "1020"){
                    $parameter = "CASE
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 320 THEN 'PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 240 AND 319 THEN 'GOLD' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 120 AND 239 THEN 'SILVER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 119 THEN 'NON CLUSTER' 
                    WHEN NVL(SUM(PP.PENJUALAN + PP.PENJUALAN_SP),0) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR";
                // Parameter Bali
                } else if($idProvinsi == "1026"){
                    $parameter = "CASE
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 400 THEN 'PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 200 AND 399 THEN 'GOLD' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 120 AND 199 THEN 'SILVER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 119 THEN 'NON CLUSTER' 
                    WHEN NVL(SUM(PP.PENJUALAN + PP.PENJUALAN_SP),0) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR";
                }
            } else {
                $whereProvinsi = "";
            }

            $sql = "SELECT
                        M_CUS.KD_CUSTOMER AS ID_CUSTOMER,
                        SUM(PP.PENJUALAN) AS PENJUALAN,
                        $parameter
                    FROM
                        M_CUSTOMER M_CUS
                        LEFT JOIN ( SELECT KD_CUSTOMER, PENJUALAN, PENJUALAN_SP FROM P_POIN WHERE BULAN = $month AND TAHUN = $year AND STATUS != 5 ) PP ON M_CUS.KD_CUSTOMER = PP.KD_CUSTOMER
                        LEFT JOIN P_USER ON M_CUS.KD_CUSTOMER = P_USER.KD_CUSTOMER 
                    WHERE $whereDistributor $whereProvinsi $whereLt $whereCustomer
                    GROUP BY
                        M_CUS.KD_CUSTOMER
                    ORDER BY
                    NVL( SUM( PP.PENJUALAN + PP.PENJUALAN_SP ), 0 ) DESC";

            // $sql = "
            // SELECT
            //     PP.KD_CUSTOMER AS ID_CUSTOMER,
            //     M_CUS.NM_CUSTOMER,
            //     SUM( PP.PENJUALAN ) AS PENJUALAN,
            //     $parameter
            // FROM
            //     P_POIN PP
            //     JOIN ( 
            //         SELECT 
            //             MC.KD_CUSTOMER, MC.NM_CUSTOMER, MC.KD_PROVINSI 
            //         FROM 
            //             M_CUSTOMER MC 
            //         LEFT JOIN 
            //             P_USER PU 
            //         ON 
            //             MC.KD_CUSTOMER = PU.KD_CUSTOMER 
            //         WHERE PU.STATUS IN (1,2) 
            //         AND MC.NOMOR_DISTRIBUTOR IS NOT NULL $whereDistributor $whereProvinsi $whereLt ) M_CUS ON PP.KD_CUSTOMER = M_CUS.KD_CUSTOMER 
            // WHERE 
            //     PP.TAHUN = $year 
            //     AND PP.BULAN = $month 
            //     AND PP.STATUS != 5 $whereCustomer
            // GROUP BY
            //     PP.KD_CUSTOMER,
            //     M_CUS.NM_CUSTOMER ORDER BY SUM( PP.PENJUALAN ) DESC";

            $data = $db_point->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }

        public function tokoTidakLapor($idProvinsi, $month){
            $year = date('Y');

            $db_point = $this->load->database("Point", true);
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1005" || $idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1007"){
            	$idDistributor = $this->session->userdata("kode_dist");
            	$whereDistributor = "AND a.NOMOR_DISTRIBUTOR = '$idDistributor'";
                $whereProvinsi = "";
            } else {
            	$whereDistributor = "";
                $whereProvinsi = "AND a.KD_PROVINSI = $idProvinsi";
            }
            $sql = "SELECT
            count( a.kd_customer ) AS TOTAL
        FROM
            m_customer a
        LEFT JOIN p_user b ON a.KD_CUSTOMER = b.KD_CUSTOMER
        WHERE b.STATUS IN ( 1, 2 ) $whereProvinsi
            AND a.NOMOR_DISTRIBUTOR IS NOT NULL $whereDistributor
            AND a.KD_CUSTOMER NOT IN (SELECT kd_customer FROM p_poin WHERE BULAN = $month AND TAHUN = $year AND STATUS != 5)";
            $data = $db_point->query($sql);;
            if($data->num_rows() > 0){
                return $data->row();
            } else {
                return array();
            }
        }
        
    }
?>
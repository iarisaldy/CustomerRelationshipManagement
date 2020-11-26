<?php
    class Model_cluster extends CI_Model {

        public function __construct(){
            parent::__construct();  
        }

        function _parameterCluster($idProvinsi = null){
            // Parameter Jatim
                if($idProvinsi == "1025"){
                    $parameter = "CASE
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 2200 THEN 'SUPER PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 680 AND 2199 THEN 'PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 400 AND 679 THEN 'GOLD' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 280 AND 399 THEN 'SILVER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 279 THEN 'NON CLUSTER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR";
                // Parameter Jateng & DIY
                } else if($idProvinsi == "1023" || $idProvinsi == "1024"){
                    $parameter = "CASE
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 320 THEN 'PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 200 AND 319 THEN 'GOLD' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 199 THEN 'NON CLUSTER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR";
                // Parameter Jabar, DKI & Banten
                } else if($idProvinsi == "1022" || $idProvinsi == "1021" || $idProvinsi == "1020"){
                    $parameter = "CASE
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 320 THEN 'PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 240 AND 319 THEN 'GOLD' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 120 AND 239 THEN 'SILVER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 119 THEN 'NON CLUSTER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR";
                // Parameter Bali
                } else if($idProvinsi == "1026"){
                    $parameter = "CASE
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 400 THEN 'PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 200 AND 399 THEN 'GOLD' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 120 AND 199 THEN 'SILVER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 119 THEN 'NON CLUSTER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR";
                }
                return $parameter;
        }

        public function _whereCluster($idProvinsi, $cluster){
            $db_point = $this->load->database("Point", true);
            if($idProvinsi == "1025"){
                    if($cluster == "SUPER PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "2200");
                    } else if($cluster == "PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 680 AND 2199");
                    } else if($cluster == "GOLD "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 400 AND 679");
                    } else if($cluster == "SILVER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 280 AND 399");
                    } else if($cluster == "NON CLUSTER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 279");
                    } else if($cluster == "TIDAK ADA PENJUALAN "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                } else if($idProvinsi == "1023" || $idProvinsi == "1024"){
                    if($cluster == "PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "320");
                    } else if($cluster == "GOLD "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 319");
                    } else if($cluster == "NON CLUSTER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                } else if($idProvinsi == "1022" || $idProvinsi == "1021" || $idProvinsi == "1020"){
                    if($cluster == "PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "320");
                    } else if($cluster == "GOLD "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 240 AND 319");
                    } else if($cluster == "SILVER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 239");
                    } else if($cluster == "NON CLUSTER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                } else if($idProvinsi == "1026"){
                    if($cluster == "PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "400");
                    } else if($cluster == "GOLD "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 399");
                    } else if($cluster == "SILVER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 199");
                    } else if($cluster == "NON CLUSTER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 119");
                    } else if($cluster == "TIDAK ADA PENJUALAN "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                }
        }

        public function clusterRegion($idProvinsi = null, $month, $tahun = null){
            if(isset($tahun)){
                $year = $tahun;
            } else {
                $year = date('Y');
            }
        	$db_point = $this->load->database("Point", true);
            // $year = date('Y');
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1005" || $idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1007"){
            	$idDistributor = $this->session->userdata("kode_dist");
            	$whereDistributor = "AND MC.NOMOR_DISTRIBUTOR = '$idDistributor'";
                $whereProvinsi = "";
            } else {
            	$whereDistributor = "";
                $whereProvinsi = "AND MC.KD_PROVINSI = $idProvinsi";
            }

            if(isset($idProvinsi)){
                // $whereProvinsi = "AND M_CUS.KD_PROVINSI = $idProvinsi";
                if($idProvinsi == "1025"){
                    $parameter = "CASE
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 2200 THEN 'SUPER PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 680 AND 2199 THEN 'PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 400 AND 679 THEN 'GOLD' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 280 AND 399 THEN 'SILVER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 279 THEN 'NON CLUSTER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR";
                // Parameter Jateng & DIY
                } else if($idProvinsi == "1023" || $idProvinsi == "1024"){
                    $parameter = "CASE
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 320 THEN 'PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 200 AND 319 THEN 'GOLD' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 199 THEN 'NON CLUSTER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR";
                // Parameter Jabar, DKI & Banten
                } else if($idProvinsi == "1022" || $idProvinsi == "1021" || $idProvinsi == "1020"){
                    $parameter = "CASE
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 320 THEN 'PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 240 AND 319 THEN 'GOLD' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 120 AND 239 THEN 'SILVER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 119 THEN 'NON CLUSTER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR";
                // Parameter Bali
                } else if($idProvinsi == "1026"){
                    $parameter = "CASE
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 400 THEN 'PLATINUM' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 200 AND 399 THEN 'GOLD' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 120 AND 199 THEN 'SILVER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 119 THEN 'NON CLUSTER' 
                    WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR";
                }
            } else {
                $whereProvinsi = "";
            }

            $sql = "SELECT 
            CLUSTERR, 
            COUNT(KD_CUSTOMER) AS JUMLAH
        FROM (
            SELECT
                PP.KD_CUSTOMER,
                M_CUS.NM_CUSTOMER,
                SUM( PP.PENJUALAN ) AS PENJUALAN,
                $parameter
            FROM
                P_POIN PP
                JOIN ( 
                    SELECT 
                        MC.KD_CUSTOMER, MC.NM_CUSTOMER, MC.KD_PROVINSI 
                    FROM 
                        M_CUSTOMER MC 
                    JOIN 
                        P_USER PU 
                    ON 
                        MC.KD_CUSTOMER = PU.KD_CUSTOMER 
                    WHERE PU.STATUS IN (1,2) 
                    AND MC.NOMOR_DISTRIBUTOR IS NOT NULL $whereDistributor $whereProvinsi ) M_CUS ON PP.KD_CUSTOMER = M_CUS.KD_CUSTOMER 
            WHERE 
                PP.TAHUN = $year 
                AND PP.BULAN = $month 
                AND PP.STATUS != 5
            GROUP BY
                PP.KD_CUSTOMER,
                M_CUS.NM_CUSTOMER) WHERE CLUSTERR IS NOT NULL
        GROUP BY CLUSTERR";

            $data = $db_point->query($sql);
			// echo $db_point->last_query();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
        }

        public function tokoTidakLapor($idProvinsi, $month, $year){
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

        public function detailClusterProvinsi($idProvinsi = null, $cluster = null, $bulan = null, $tahun = null){
            $db_point = $this->load->database("Point", true);

            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1005" || $idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1007"){
            	$idDistributor = $this->session->userdata("kode_dist");
            	$db_point->where("M_CUSTOMER.NOMOR_DISTRIBUTOR", $idDistributor);
            } else {
                $db_point->where("M_CUSTOMER.KD_PROVINSI", $idProvinsi);
            }

            if(isset($idProvinsi)){
                
                if($idProvinsi == "1025"){
                    if($cluster == "SUPER PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "2200");
                    } else if($cluster == "PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 680 AND 2199");
                    } else if($cluster == "GOLD "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 400 AND 679");
                    } else if($cluster == "SILVER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 280 AND 399");
                    } else if($cluster == "NON CLUSTER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 279");
                    } else if($cluster == "TIDAK ADA PENJUALAN "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                } else if($idProvinsi == "1023" || $idProvinsi == "1024"){
                    if($cluster == "PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "320");
                    } else if($cluster == "GOLD "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 319");
                    } else if($cluster == "NON CLUSTER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                } else if($idProvinsi == "1022" || $idProvinsi == "1021" || $idProvinsi == "1020"){
                    if($cluster == "PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "320");
                    } else if($cluster == "GOLD "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 240 AND 319");
                    } else if($cluster == "SILVER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 239");
                    } else if($cluster == "NON CLUSTER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                } else if($idProvinsi == "1026"){
                    if($cluster == "PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "400");
                    } else if($cluster == "GOLD "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 399");
                    } else if($cluster == "SILVER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 199");
                    } else if($cluster == "NON CLUSTER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 119");
                    } else if($cluster == "TIDAK ADA PENJUALAN "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                }
            }

            $whereArray = array("P_POIN.BULAN" => $bulan, "P_POIN.TAHUN" => $tahun);

            $db_point->select("M_CUSTOMER.NM_DISTRIK, COUNT(M_CUSTOMER.ID_CUSTOMER) AS JUMLAH");
            $db_point->from("P_POIN");
            $db_point->join("M_CUSTOMER", "P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER");
            $db_point->where($whereArray);
            $db_point->where("P_POIN.STATUS !=", "5");
            $db_point->group_by("M_CUSTOMER.NM_DISTRIK");
            $data = $db_point->get();
            // echo $db_point->last_query();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
        }

        public function detailClusterTdkJualProvinsi($idProvinsi = null, $bulan = null, $tahun = null){
            if(isset($tahun)){
                $tahun = $tahun;
            } else {
                $tahun = date('Y');    
            }
            $db_point = $this->load->database("Point", true);
            
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1007" || $idJenisUser == "1005"){
                $idDistributor = $this->session->userdata("kode_dist");
                $whereDistributor = "AND a.NOMOR_DISTRIBUTOR = '$idDistributor'";
                $whereDistributor2 = "AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$idDistributor'";
                $whereProvinsi = "";
                $whereProvinsi2 = "";
            } else {
                $whereDistributor = "";
                $whereDistributor2 = "";
                $whereProvinsi = "AND a.KD_PROVINSI = $idProvinsi";
                $whereProvinsi2 = "AND M_CUSTOMER.KD_PROVINSI = $idProvinsi";
            }

            $sql = "SELECT
                        NM_DISTRIK,
                        SUM( TOTAL ) AS JUMLAH
                    FROM
                        (
                        SELECT
                        a.NM_DISTRIK,
                        count( a.kd_customer ) AS TOTAL 
                    FROM
                        m_customer a
                        LEFT JOIN p_user b ON a.KD_CUSTOMER = b.KD_CUSTOMER 
                    WHERE
                        b.STATUS IN ( 1, 2 ) 
                        AND a.NOMOR_DISTRIBUTOR IS NOT NULL $whereProvinsi $whereDistributor
                        AND a.KD_CUSTOMER NOT IN ( SELECT kd_customer FROM p_poin WHERE BULAN = $bulan AND TAHUN = $tahun AND STATUS != 5 ) 
                        AND TO_CHAR(a.CREATED_AT, 'MM-YYYY') != '$bulan-$tahun'
                    GROUP BY
                        a.NM_DISTRIK 
                    UNION
                    SELECT
                        M_CUSTOMER.NM_DISTRIK,
                        COUNT( M_CUSTOMER.ID_CUSTOMER ) AS JUMLAH 
                    FROM
                        P_POIN
                        JOIN M_CUSTOMER ON P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER 
                    WHERE
                        P_POIN.STATUS != 5 
                        AND P_POIN.BULAN = $bulan 
                        AND P_POIN.TAHUN = $tahun 
                        AND ( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0 
                        AND TO_CHAR(M_CUSTOMER.CREATED_AT, 'MM-YYYY') != '$bulan-$tahun'
                        $whereProvinsi2 $whereDistributor2
                    GROUP BY
                        M_CUSTOMER.NM_DISTRIK 
                        ) 
                    GROUP BY
                        NM_DISTRIK";

            $data = $db_point->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
        }

        public function tabelTokoCluster($idProvinsi = null, $nmDistrik = null, $cluster = null, $bulan = null){
            $db_point = $this->load->database("Point", true);
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1003"){
                $idDistributor = $this->session->userdata("kode_dist");
                $db_point->where("M_CUSTOMER.NOMOR_DISTRIBUTOR", $idDistributor);
            }
            if(isset($idProvinsi)){
                if($idProvinsi == "1025"){
                    if($cluster == "SUPER PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "2200");
                    } else if($cluster == "PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 680 AND 2199");
                    } else if($cluster == "GOLD "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 400 AND 679");
                    } else if($cluster == "SILVER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 280 AND 399");
                    } else if($cluster == "NON CLUSTER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 279");
                    } else if($cluster == "TIDAK ADA PENJUALAN "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                } else if($idProvinsi == "1023" || $idProvinsi == "1024"){
                    if($cluster == "PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "320");
                    } else if($cluster == "GOLD "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 319");
                    } else if($cluster == "NON CLUSTER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                } else if($idProvinsi == "1022" || $idProvinsi == "1021" || $idProvinsi == "1020"){
                    if($cluster == "PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "320");
                    } else if($cluster == "GOLD "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 240 AND 319");
                    } else if($cluster == "SILVER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 239");
                    } else if($cluster == "NON CLUSTER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                } else if($idProvinsi == "1026"){
                    if($cluster == "PLATINUM "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "400");
                    } else if($cluster == "GOLD "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 399");
                    } else if($cluster == "SILVER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 199");
                    } else if($cluster == "NON CLUSTER "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 119");
                    } else if($cluster == "TIDAK ADA PENJUALAN "){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                }
            }

            if(isset($nmDistrik)){
                $db_point->like("M_CUSTOMER.NM_DISTRIK", $nmDistrik, "both");
            }

            $db_point->select("M_CUSTOMER.NAMA_TOKO, M_CUSTOMER.DISTRIBUTOR AS NAMA_DISTRIBUTOR, 
            M_CUSTOMER.NM_CUSTOMER AS NAMA_PEMILIK, M_CUSTOMER.ALAMAT_TOKO AS ALAMAT, M_CUSTOMER.NM_DISTRIK");
            $db_point->from("P_POIN");
            $db_point->join("M_CUSTOMER", "P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER");
            $whereArray = array(
                "P_POIN.STATUS !=" => "5", 
                "P_POIN.BULAN" => $bulan, 
                "P_POIN.TAHUN" => date('Y')
            );
            $db_point->where($whereArray);            

            $data = $db_point->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }

        }

        public function tabelTokoClusterTdkJual($idProvinsi = null, $nmDistrik = null, $bulan = null){
            $db_point = $this->load->database("Point", true);
            $tahun = date('Y');
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1005" || $idJenisUser == "1007"){
                $idDistributor = $this->session->userdata("kode_dist");
                $whereDistributor = "AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$idDistributor'";
                $whereDistributor2 = "AND a.NOMOR_DISTRIBUTOR = '$idDistributor'";
                $whereProvinsi = "";
                $whereProvinsi2 = "";
            } else {
                $whereDistributor = "";
                $whereDistributor2 = "";
                $whereProvinsi = "AND M_CUSTOMER.KD_PROVINSI = '$idProvinsi'";
                $whereProvinsi2 = "AND a.KD_PROVINSI = '$idProvinsi'";
            }
            $sql = "SELECT
                        M_CUSTOMER.ID_CUSTOMER,
                        M_CUSTOMER.NAMA_TOKO,
                        M_CUSTOMER.DISTRIBUTOR AS NAMA_DISTRIBUTOR,
                        M_CUSTOMER.NM_CUSTOMER AS NAMA_PEMILIK,
                        M_CUSTOMER.ALAMAT_TOKO AS ALAMAT
                    FROM
                        P_POIN
                        JOIN M_CUSTOMER ON P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER 
                    WHERE
                        P_POIN.STATUS != 5 
                        AND P_POIN.BULAN = $bulan 
                        AND P_POIN.TAHUN = $tahun 
                        AND ( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0 
                        $whereProvinsi $whereDistributor
                        AND M_CUSTOMER.NM_DISTRIK LIKE '%$nmDistrik%'
                    UNION
                    SELECT
                        a.ID_CUSTOMER,
                        a.NAMA_TOKO,
                        a.DISTRIBUTOR AS NAMA_DISTRIBUTOR,
                        a.NM_CUSTOMER AS NAMA_PEMILIK,
                        a.ALAMAT_TOKO AS ALAMAT
                    FROM
                        m_customer a
                        LEFT JOIN p_user b ON a.KD_CUSTOMER = b.KD_CUSTOMER 
                    WHERE
                        a.NM_DISTRIK LIKE '%$nmDistrik%'
                        $whereProvinsi2 $whereDistributor2
                        AND b.STATUS IN ( 1, 2 ) 
                        AND a.NOMOR_DISTRIBUTOR IS NOT NULL 
                        AND a.KD_CUSTOMER NOT IN ( SELECT kd_customer FROM p_poin WHERE BULAN = $bulan AND TAHUN = $tahun AND STATUS != 5 )
                        AND TO_CHAR(a.CREATED_AT, 'MM-YYYY') = '$bulan-$tahun'";

            $data = $db_point->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
        }

        public function getTokoTidakLapor($idProvinsi, $nmDistrik, $bulan, $tahun){
            $db_point = $this->load->database("Point", true);
            $idDistributor = $this->session->userdata("kode_dist");
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1005" || $idJenisUser == "1007"){
                $idDistributor = $this->session->userdata("kode_dist");
                $whereDistributor = "AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$idDistributor'";
                $whereProvinsi = "";
            } else {
                $whereDistributor = "";
                $whereProvinsi = "AND M_CUSTOMER.KD_PROVINSI = '$idProvinsi'";
            }

            $sql = "SELECT
                        M_CUSTOMER.ID_CUSTOMER 
                    FROM
                        M_CUSTOMER
                        JOIN P_USER ON M_CUSTOMER.KD_CUSTOMER = P_USER.KD_CUSTOMER 
                    WHERE
                        M_CUSTOMER.KD_CUSTOMER NOT IN ( SELECT kd_customer FROM p_poin WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS != 5 ) 
                        AND M_CUSTOMER.NOMOR_DISTRIBUTOR IS NOT NULL 
                        $whereDistributor $whereProvinsi
                        AND M_CUSTOMER.NM_DISTRIK LIKE '%$nmDistrik%' 
                        AND P_USER.STATUS IN (1,2) AND TO_CHAR(M_CUSTOMER.CREATED_AT, 'MM') != '$bulan' AND TO_CHAR(M_CUSTOMER.CREATED_AT, 'YYYY') != '$tahun'";
            $data = $db_point->query($sql);
            if($data->num_rows() > 0){
                return $data->num_rows();
            } else {
                return array();
            }
        }

        public function tabelTrackTokoTidakLapor($idProvinsi, $nmDistrik, $bulan, $tahun){
            $db_point = $this->load->database("Point", true);
            $idDistributor = $this->session->userdata("kode_dist");
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1005" || $idJenisUser == "1007"){
                $idDistributor = $this->session->userdata("kode_dist");
                $whereDistributor = "AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$idDistributor'";
                $whereProvinsi = "";
            } else {
                $whereDistributor = "";
                $whereProvinsi = "AND M_CUSTOMER.KD_PROVINSI = '$idProvinsi'";
            }

            $sql = "SELECT
                        M_CUSTOMER.ID_CUSTOMER, M_CUSTOMER.NAMA_TOKO, M_CUSTOMER.NM_CUSTOMER, M_CUSTOMER.DISTRIBUTOR, M_CUSTOMER.ALAMAT_TOKO, M_CUSTOMER.KECAMATAN, M_CUSTOMER.GROUP_CUSTOMER, TOKO_LT.NAMA_TOKO AS LT
                    FROM
                        M_CUSTOMER
                        JOIN P_USER ON M_CUSTOMER.KD_CUSTOMER = P_USER.KD_CUSTOMER 
                        LEFT JOIN (SELECT KD_SAP, NAMA_TOKO FROM M_CUSTOMER WHERE GROUP_CUSTOMER = 'LT') TOKO_LT ON M_CUSTOMER.KD_LT = TOKO_LT.KD_SAP
                    WHERE
                        M_CUSTOMER.KD_CUSTOMER NOT IN ( SELECT kd_customer FROM p_poin WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS != 5 ) 
                        AND M_CUSTOMER.NOMOR_DISTRIBUTOR IS NOT NULL 
                        $whereDistributor $whereProvinsi
                        AND M_CUSTOMER.NM_DISTRIK LIKE '%$nmDistrik%' 
                        AND P_USER.STATUS IN (1,2) AND TO_CHAR(M_CUSTOMER.CREATED_AT, 'MM') != '$bulan' AND TO_CHAR(M_CUSTOMER.CREATED_AT, 'YYYY') != '$tahun'";
            $data = $db_point->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
        }

        public function trackRecordCluster($idProvinsi = null, $cluster = null, $nmDistrik = null, $tahun = null){
            $db_point = $this->load->database("Point", true);
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1003" || $idJenisUser == "1005" || $idJenisUser == "1002" || $idJenisUser == "1007"){
                $idDistributor = $this->session->userdata("kode_dist");
                $db_point->where("M_CUSTOMER.NOMOR_DISTRIBUTOR", $idDistributor);
            } else {
                $db_point->where("M_CUSTOMER.KD_PROVINSI", $idProvinsi);
            }

            if(isset($nmDistrik)){
                if($nmDistrik != ""){
                    $db_point->like("M_CUSTOMER.NM_DISTRIK", $nmDistrik, "both");
                }
            }

            $cluster = rtrim($cluster);
            
            if(isset($idProvinsi)){
                if($idProvinsi == "1025"){
                    if($cluster == "SUPER PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) >= ", "2200");
                    } else if($cluster == "PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) BETWEEN 680 AND 2199");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 400 AND 679");
                    } else if($cluster == "SILVER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 280 AND 399");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 279");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                         $db_point->where("NVL(( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ), 0) = 0");
                    }
                } else if($idProvinsi == "1023" || $idProvinsi == "1024"){
                    if($cluster == "PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) >= ", "320");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 319");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                         $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0");
                    }
                } else if($idProvinsi == "1022" || $idProvinsi == "1021" || $idProvinsi == "1020"){
                    if($cluster == "PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) >= ", "320");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 240 AND 319");
                    } else if($cluster == "SILVER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 239");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                         $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0");
                    }
                } else if($idProvinsi == "1026"){
                    if($cluster == "PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) >= ", "400");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 399");
                    }  else if($cluster == "SILVER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 199");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 119");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                         $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0");
                    }
                }
            }

            $db_point->select("TO_CHAR( TO_DATE( P_POIN.BULAN, 'MM' ), 'MONTH' ) AS BULAN, P_POIN.BULAN AS NUM_BULAN, P_POIN.BULAN AS NUMBER_MONTH,
            COUNT( M_CUSTOMER.ID_CUSTOMER ) AS JUMLAH");
            $db_point->from("P_POIN");
            $db_point->join("M_CUSTOMER", "P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER", "RIGHT");
            $db_point->where("P_POIN.STATUS != ", "5");
            $db_point->where("P_POIN.TAHUN", $tahun);
            
            $db_point->group_by("P_POIN.BULAN");
            $db_point->order_by("P_POIN.BULAN", "ASC");
            $data = $db_point->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
        }

        public function tabelTrackRecord($idProvinsi, $bulan, $cluster, $nmDistrik = null, $tahun = null){
            $db_point = $this->load->database("Point", true);
            $cluster = trim($cluster);
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1003" || $idJenisUser == "1005" || $idJenisUser == "1002" || $idJenisUser == "1007"){
                $idDistributor = $this->session->userdata("kode_dist");
                $db_point->where("M_CUSTOMER.NOMOR_DISTRIBUTOR", $idDistributor);
            } else {
                $db_point->where("M_CUSTOMER.KD_PROVINSI", $idProvinsi);
            }

            if(isset($nmDistrik)){
                if($nmDistrik != ""){
                    $db_point->where("M_CUSTOMER.NM_DISTRIK", $nmDistrik);
                }
            }

            if($idProvinsi == "1025"){
                if($cluster == "SUPER PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) >= ", "2200");
                    } else if($cluster == "PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) BETWEEN 680 AND 2199");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 400 AND 679");
                    } else if($cluster == "SILVER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 280 AND 399");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 279");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                         $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0");
                    }
            } else if($idProvinsi == "1023" || $idProvinsi == "1024"){
                if($cluster == "PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) >= ", "320");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 319");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                         $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0");
                    }
            } else if($idProvinsi == "1022" || $idProvinsi == "1021" || $idProvinsi == "1020"){
                if($cluster == "PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) >= ", "320");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 240 AND 319");
                    } else if($cluster == "SILVER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 239");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                         $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0");
                    }
            } else if($idProvinsi == "1026"){
                if($cluster == "PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) >= ", "400");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 399");
                    }  else if($cluster == "SILVER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 199");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 119");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                         $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0");
                    }
            }

            $db_point->select("M_CUSTOMER.ID_CUSTOMER, M_CUSTOMER.NAMA_TOKO, M_CUSTOMER.NM_CUSTOMER, M_CUSTOMER.DISTRIBUTOR, M_CUSTOMER.ALAMAT_TOKO, M_CUSTOMER.KECAMATAN, M_CUSTOMER.GROUP_CUSTOMER, TOKO_LT.NAMA_TOKO AS LT");
            $db_point->from("P_POIN");
            $db_point->join("M_CUSTOMER", "P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER");
            $db_point->join("(SELECT KD_SAP, NAMA_TOKO FROM M_CUSTOMER WHERE GROUP_CUSTOMER = 'LT') TOKO_LT", "M_CUSTOMER.KD_LT = TOKO_LT.KD_SAP", "LEFT");
            $db_point->where("P_POIN.STATUS != ", "5");
            $db_point->where("P_POIN.TAHUN", $tahun);
            $db_point->where("P_POIN.BULAN", $bulan);

            $data = $db_point->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
        }

        public function tabelTrackRecordDistrik($idProvinsi, $bulan, $cluster, $nmDistrik){
            $tahun = date('Y');
            $cluster = trim($cluster);
            $db_point = $this->load->database("Point", true);
            if(isset($cluster)){
                // if($cluster != ""){
                    $db_point->where("M_CUSTOMER.NM_DISTRIK", $nmDistrik);
                // }
            }
            if(isset($idProvinsi)){
                $db_point->where("M_CUSTOMER.KD_PROVINSI", $idProvinsi);
                if($idProvinsi == "1025"){
                    if($cluster == "SUPER PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) >= ", "2200");
                    } else if($cluster == "PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) BETWEEN 680 AND 2199");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 400 AND 679");
                    } else if($cluster == "SILVER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 280 AND 399");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 279");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                         $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0");
                    }
                } else if($idProvinsi == "1023" || $idProvinsi == "1024"){
                    if($cluster == "PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) >= ", "320");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 319");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                         $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0");
                    }
                } else if($idProvinsi == "1022" || $idProvinsi == "1021" || $idProvinsi == "1020"){
                    if($cluster == "PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) >= ", "320");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 240 AND 319");
                    } else if($cluster == "SILVER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 239");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                         $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0");
                    }
                } else if($idProvinsi == "1026"){
                    if($cluster == "PLATINUM"){
                        $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) >= ", "400");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 399");
                    }  else if($cluster == "SILVER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 199");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 119");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                         $db_point->where("( P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP ) = 0");
                    }
                }
            }

            $db_point->select("M_CUSTOMER.ID_CUSTOMER, M_CUSTOMER.NAMA_TOKO, M_CUSTOMER.NM_CUSTOMER, M_CUSTOMER.DISTRIBUTOR, M_CUSTOMER.ALAMAT_TOKO, M_CUSTOMER.KECAMATAN");
            $db_point->from("P_POIN");
            $db_point->join("M_CUSTOMER", "P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER");
            $db_point->where("P_POIN.STATUS != ", "5");
            $db_point->where("P_POIN.TAHUN", date('Y'));
            $db_point->where("P_POIN.BULAN", $bulan);

            $data = $db_point->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
        }

        public function topThreeCluster(){
            $db_point = $this->load->database("Point", true);

            $sql = "SELECT * FROM (SELECT
            M_CUSTOMER.ID_CUSTOMER,
            M_CUSTOMER.NAMA_TOKO,
            M_CUSTOMER.DISTRIBUTOR,
            M_CUSTOMER.NM_CUSTOMER,
            M_CUSTOMER.NM_DISTRIK,
            M_CUSTOMER.ALAMAT_TOKO,
            P_POIN.PENJUALAN,
            P_POIN.PENJUALAN_SP,
            (P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) as TOTAL_PENJUALAN
        FROM
            P_POIN
            JOIN M_CUSTOMER ON P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER 
        WHERE
            M_CUSTOMER.KD_PROVINSI = 1025 
            AND P_POIN.PENJUALAN > 2200 
            AND P_POIN.BULAN = 8 
            AND P_POIN.TAHUN = 2018 
            AND P_POIN.STATUS != 5
        ORDER BY
            P_POIN.PENJUALAN DESC) WHERE ROWNUM < 4";

            $data = $db_point->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
        }
        
    }
?>
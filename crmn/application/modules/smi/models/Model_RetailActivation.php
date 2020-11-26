<?php
    class Model_RetailActivation extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function tokoSize(){
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1005"){
                $idDistributor = $this->session->userdata("kode_dist");
                $whereDistributor = "AND ID_DISTRIBUTOR = '$idDistributor'";
            } else {
                $whereDistributor = "";
            }

            $sql = "SELECT
            CRMNEW_M_PROVINSI.ID_PROVINSI,
            CRMNEW_M_PROVINSI.NAMA_PROVINSI,
            TOKO.JUMLAH 
        FROM
            CRMNEW_M_PROVINSI
            LEFT JOIN ( SELECT ID_PROVINSI, COUNT( ID_CUSTOMER ) AS JUMLAH FROM CRMNEW_CUSTOMER WHERE STATUS_TOKO IN ( 1, 2 ) $whereDistributor GROUP BY ID_PROVINSI ) TOKO ON CRMNEW_M_PROVINSI.ID_PROVINSI = TOKO.ID_PROVINSI 
        WHERE ID_REGION IS NOT NULL
        ORDER BY
            CRMNEW_M_PROVINSI.ID_PROVINSI ASC";
            $data = $this->db->query($sql);
            if($data){
                return $data->result();
            } else {
                return false;
            }
        }

        public function totalTokoAktif(){

            $this->db->select("COUNT(ID_CUSTOMER) AS TOTAL");
            $this->db->from("CRMNEW_CUSTOMER");
            
            $data = $this->db->get();
            if($data){
                return $data->row();
            } else {
                return false;
            }
        }

        public function detailChartActivation($idProvinsi, $status){
            $whereStatus = "";
            $whereDistributor = "";
            $whereProvinsi = "";
			$kodeDist = $this->session->userdata("kode_dist");
            // $db_point = $this->load->database("Point", true);
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1005"){
                $kodeDist = $this->session->userdata("kode_dist");
                $whereDistributor = "AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$kodeDist'";
            } else {
                $whereProvinsi = "AND M_CUSTOMER.KD_PROVINSI = '$idProvinsi'";
            }
			

            if($status == "AKTIF"){
                $whereStatus = "AND P_USER.STATUS IN (1, 2)";
            } else if($status == "NONAKTIF"){
                $whereStatus = "AND P_USER.STATUS = 4";
            }
            $sql = "SELECT
                        TRIM(M_CUSTOMER.NM_DISTRIK) AS NAMA_DISTRIK,
                        COUNT( P_USER.STATUS ) AS JUMLAH 
                    FROM
                        M_CUSTOMER
                        LEFT JOIN P_USER ON M_CUSTOMER.KD_CUSTOMER = P_USER.KD_CUSTOMER 
                    WHERE
                        M_CUSTOMER.NOMOR_DISTRIBUTOR IS NOT NULL 
                        AND M_CUSTOMER.KD_CUSTOMER IS NOT NULL 
                        $whereStatus $whereDistributor
                        $whereProvinsi
                    GROUP BY
                        TRIM(M_CUSTOMER.NM_DISTRIK)";
			
			$sql ="
				SELECT
                        TRIM(NAMA_DISTRIK) AS NAMA_DISTRIK,
                        COUNT( STATUS_TOKO ) AS JUMLAH 
                    FROM
                        CRMNEW_CUSTOMER                         
                    WHERE
                    ID_DISTRIBUTOR IS NOT NULL
                    AND ID_CUSTOMER IS NOT NULL
                    AND NAMA_DISTRIK IS NOT NULL
                    AND ID_PROVINSI='$idProvinsi'
                   AND ID_DISTRIBUTOR='$kodeDist'
                    GROUP BY
                        TRIM(NAMA_DISTRIK)
			";
            $retail = $this->db->query($sql);
            if($retail->num_rows() > 0){
                return $retail->result();
            } else {
                return false;
            }
        }

        public function chartActivation($idProvinsi = null, $bulan = null){
			$idDistributor = $this->session->userdata("kode_dist");
            $db_point = $this->load->database("Point", true);
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1005" || $idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1007"){
                $idDistributor = $this->session->userdata("kode_dist");
                $whereDistributor = "AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$idDistributor'";
                $whereProvinsi = "";
            } else {
                $whereDistributor = "";
                $whereProvinsi = "AND KD_PROVINSI = '$idProvinsi'";
            }
            $sql = "SELECT
                        STATUS_TOKO,
                        SUM( JML_AKTIF ) AS JML
                    FROM
                        (
                    SELECT
                        Regexp_replace( P_USER.STATUS, '1|2', 'AKTIF' ) AS STATUS_TOKO,
                        COUNT( M_CUSTOMER.ID_CUSTOMER ) AS JML_AKTIF 
                    FROM
                        M_CUSTOMER
                        LEFT JOIN P_USER ON M_CUSTOMER.KD_CUSTOMER = P_USER.KD_CUSTOMER 
                    WHERE
                        M_CUSTOMER.NOMOR_DISTRIBUTOR IS NOT NULL 
                        AND M_CUSTOMER.KD_CUSTOMER IS NOT NULL 
                        AND P_USER.STATUS IN ( 1, 2 ) 
                        $whereProvinsi $whereDistributor
                    GROUP BY
                        P_USER.STATUS 
					UNION
                    SELECT
                        Regexp_replace( P_USER.STATUS, '4', 'NONAKTIF' ),
                        COUNT( M_CUSTOMER.ID_CUSTOMER ) AS JML_NAKTIF 
                    FROM
                        M_CUSTOMER
                        LEFT JOIN P_USER ON M_CUSTOMER.KD_CUSTOMER = P_USER.KD_CUSTOMER 
                    WHERE
                        M_CUSTOMER.NOMOR_DISTRIBUTOR IS NOT NULL 
                        AND M_CUSTOMER.KD_CUSTOMER IS NOT NULL 
                        AND P_USER.STATUS NOT IN ( 1, 2 ) 
                        $whereProvinsi $whereDistributor
                    GROUP BY
                        P_USER.STATUS 
                        ) WHERE STATUS_TOKO IN ('AKTIF','NONAKTIF')
                    GROUP BY
                        STATUS_TOKO";
            //$retail = $db_point->query($sql);
			$sql ="
                SELECT
                        STATUS_TOKO,
                        SUM( JML_AKTIF ) AS JML
                    FROM
                        (
                    SELECT
                        Regexp_replace( STATUS_TOKO, '1|2', 'AKTIF' ) AS STATUS_TOKO,
                        COUNT( ID_CUSTOMER ) AS JML_AKTIF 
                    FROM
                        CRMNEW_CUSTOMER
                    WHERE
                        ID_DISTRIBUTOR IS NOT NULL 
                        AND KODE_CUSTOMER IS NOT NULL 
                        AND STATUS_TOKO IN ( 1, 2 ) 
                         AND ID_DISTRIBUTOR = '$idDistributor'
                    GROUP BY
                        STATUS_TOKO 
                    UNION
                    SELECT
                        Regexp_replace( STATUS_TOKO, '4', 'NONAKTIF' ) AS STATUS_TOKO,
                        COUNT( ID_CUSTOMER ) AS JML_NAKTIF 
                    FROM
                       CRMNEW_CUSTOMER
                    WHERE
                        ID_DISTRIBUTOR IS NOT NULL 
                        AND KODE_CUSTOMER IS NOT NULL 
                        AND STATUS_TOKO IN ( 1,2 ) 
                         AND ID_DISTRIBUTOR = '$idDistributor'
                    GROUP BY
                        STATUS_TOKO
                        ) WHERE STATUS_TOKO IN ('AKTIF','NONAKTIF')
                    GROUP BY
                        STATUS_TOKO
            ";
            //echo $sql;
            $retail = $this->db->query($sql);

            if($retail->num_rows() > 0){
                return $retail->result();
            } else {
                return false;
            }
        }

        public function detailRetailDistrik($nmDistrik, $status){
            //$db_point = $this->load->database("Point", true);
			$idDistributor = null;
            $whereStatus = "";
            $whereDistributor = "";
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1005"){
                $idDistributor = $this->session->userdata("kode_dist");
                $whereDistributor = "AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$idDistributor'";
            }
            if($status == "AKTIF"){
                $whereStatus = "AND P_USER.STATUS IN (1,2)";
            } else if($status == "NONAKTIF"){
                $whereStatus = "AND P_USER.STATUS = 4";
            }
            $sql = "SELECT
                        M_CUSTOMER.ID_CUSTOMER,
                        M_CUSTOMER.NAMA_TOKO,
                        M_CUSTOMER.NOMOR_DISTRIBUTOR AS ID_DISTRIBUTOR,
                        M_CUSTOMER.DISTRIBUTOR AS NAMA_DISTRIBUTOR,
                        M_CUSTOMER.NM_CUSTOMER AS NAMA_PEMILIK,
                        M_CUSTOMER.AREA AS ID_AREA,
                        M_CUSTOMER.ALAMAT_TOKO AS ALAMAT,
                        M_CUSTOMER.KECAMATAN,
                        M_CUSTOMER.GROUP_CUSTOMER,
                        TOKO_LT.NAMA_TOKO AS LT
                    FROM
                        M_CUSTOMER
                        LEFT JOIN P_USER ON M_CUSTOMER.KD_CUSTOMER = P_USER.KD_CUSTOMER 
                        LEFT JOIN (SELECT KD_SAP, NAMA_TOKO FROM M_CUSTOMER WHERE GROUP_CUSTOMER = 'LT') TOKO_LT ON M_CUSTOMER.KD_LT = TOKO_LT.KD_SAP
                    WHERE
                        M_CUSTOMER.NM_DISTRIK LIKE '$nmDistrik'
                        AND M_CUSTOMER.NOMOR_DISTRIBUTOR IS NOT NULL 
                        AND M_CUSTOMER.KD_CUSTOMER IS NOT NULL
                        $whereStatus $whereDistributor";
			
			$sql ="
				SELECT
				C.ID_CUSTOMER,
				C.NAMA_TOKO,
				C.ID_DISTRIBUTOR,
				D.NAMA_DISTRIBUTOR,
				C.NAMA_PEMILIK,
				C.ID_AREA,
				C.ALAMAT,
				C.NAMA_KECAMATAN,
				C.GROUP_CUSTOMER,
				C.KD_LT AS LT
				FROM CRMNEW_BK_CUSTOMER C
				LEFT JOIN CRMNEW_DISTRIBUTOR D ON C.ID_DISTRIBUTOR=C.ID_DISTRIBUTOR
				WHERE C.ID_CUSTOMER IS NOT NULL 
				AND C.NAMA_DISTRIK='$nmDistrik'
				AND C.STATUS_TOKO IN (1, 2)
				
			";
			if($idDistributor!=null){
				$sql .= " AND C.ID_DISTRIBUTOR='$idDistributor' ";
			}
			
            $retail = $this->db->query($sql);
            if($retail->num_rows() > 0){
                return $retail->result();
            } else {
                return false;
            }

        }
    }
?>
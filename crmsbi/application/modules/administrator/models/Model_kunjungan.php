<?php
    class Model_kunjungan extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function identitasDistributor($idUser){
            $sql = "SELECT
                        ID_PROVINSI, COUNT(ID_GUDANG_DIST) AS JUMLAH 
                    FROM
                        CRMNEW_USER
                        JOIN CRMNEW_USER_DISTRIBUTOR ON CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER
                        JOIN (
                    SELECT
                        CRMNEW_M_PROVINSI.ID_PROVINSI,
                        CRMNEW_M_GUDANG_DISTRIBUTOR.ID_GUDANG_DIST,
                        CRMNEW_M_GUDANG_DISTRIBUTOR.KODE_DISTRIBUTOR,
                        CRMNEW_M_GUDANG_DISTRIBUTOR.NAMA_DISTRIBUTOR 
                    FROM
                        CRMNEW_M_GUDANG_DISTRIBUTOR
                        JOIN CRMNEW_M_PROVINSI ON SUBSTR( CRMNEW_M_GUDANG_DISTRIBUTOR.KD_DISTRIK, 0, 2 ) = SUBSTR( CRMNEW_M_PROVINSI.ID_PROVINSI, 3, 2 ) 
                    GROUP BY
                        CRMNEW_M_PROVINSI.ID_PROVINSI,
                        CRMNEW_M_GUDANG_DISTRIBUTOR.ID_GUDANG_DIST,
                        CRMNEW_M_GUDANG_DISTRIBUTOR.KODE_DISTRIBUTOR,
                        CRMNEW_M_GUDANG_DISTRIBUTOR.NAMA_DISTRIBUTOR 
                        ) DIST ON CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = DIST.KODE_DISTRIBUTOR 
                    WHERE
                        CRMNEW_USER.ID_USER = '$idUser' 
                        AND CRMNEW_USER_DISTRIBUTOR.DELETE_MARK = 0 
                    GROUP BY ID_PROVINSI ORDER BY COUNT(ID_GUDANG_DIST) DESC";
            $identitasUser = $this->db->query($sql);
            if($identitasUser->num_rows() > 0){
                return $identitasUser->result();
            } else {
                return false;
            }
        }

        public function identitasUser($idUser){
            $sql = "SELECT
                    CRMNEW_USER.ID_USER,
                    CRMNEW_USER.ID_REGION,
                    CRMNEW_USER.ID_JENIS_USER,
                    CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR,
                    USER_PROVINSI.ID_PROVINSI,
                    COUNT( DIST.ID_GUDANG_DIST ) AS JUMLAH,
                    DIST.ID_PROVINSI AS PROV_DIST 
                FROM
                    CRMNEW_USER
                    LEFT JOIN CRMNEW_USER_DISTRIBUTOR ON CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER
                    LEFT JOIN ( SELECT ID_USER, ID_PROVINSI FROM CRMNEW_USER_PROVINSI WHERE DELETE_MARK = '0' ) USER_PROVINSI ON CRMNEW_USER.ID_USER = USER_PROVINSI.ID_USER
                    LEFT JOIN (
                SELECT
                    CRMNEW_M_PROVINSI.ID_PROVINSI,
                    CRMNEW_M_GUDANG_DISTRIBUTOR.ID_GUDANG_DIST,
                    CRMNEW_M_GUDANG_DISTRIBUTOR.KODE_DISTRIBUTOR,
                    CRMNEW_M_GUDANG_DISTRIBUTOR.NAMA_DISTRIBUTOR 
                FROM
                    CRMNEW_M_GUDANG_DISTRIBUTOR
                    LEFT JOIN CRMNEW_M_PROVINSI ON SUBSTR( CRMNEW_M_GUDANG_DISTRIBUTOR.KD_DISTRIK, 0, 2 ) = SUBSTR( CRMNEW_M_PROVINSI.ID_PROVINSI, 3, 2 ) 
                GROUP BY
                    CRMNEW_M_PROVINSI.ID_PROVINSI,
                    CRMNEW_M_GUDANG_DISTRIBUTOR.ID_GUDANG_DIST,
                    CRMNEW_M_GUDANG_DISTRIBUTOR.KODE_DISTRIBUTOR,
                    CRMNEW_M_GUDANG_DISTRIBUTOR.NAMA_DISTRIBUTOR 
                    ) DIST ON CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = DIST.KODE_DISTRIBUTOR 
                WHERE
                    CRMNEW_USER.ID_USER = '$idUser' 
                GROUP BY
                    CRMNEW_USER.ID_USER,
                    CRMNEW_USER.ID_JENIS_USER,
                    CRMNEW_USER.ID_REGION,
                    CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR,
                    USER_PROVINSI.ID_PROVINSI,
                    DIST.ID_PROVINSI 
                ORDER BY
                    COUNT( ID_GUDANG_DIST ) DESC";
            
            $identitas = $this->db->query($sql);
            if($identitas->num_rows() > 0){
                return $identitas->row();
            } else {
                return false;
            }
        }


        public function kunjunganHarian($idUser = null, $idJenisUser = null, $bulan = null, $tahun = null){
            $whereUser = "";
            if($idJenisUser == "1003" || $idJenisUser == "1005" || $idJenisUser == "1006"){
                $whereUser = "AND CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = $idUser";
            } else if($idJenisUser == "1002" || $idJenisUser == "1007"){
                $idDistributor = $this->session->userdata("kode_dist");
                $whereUser = "AND CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = '$idDistributor' 
                AND CRMNEW_USER_DISTRIBUTOR.DELETE_MARK = '0' AND CRMNEW_USER.ID_JENIS_USER = '1003'";
            } else if($idJenisUser == "1001"){
                if($idUser != "null"){
                    $whereUser = "AND CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = $idUser";
                } else {
                    $idRegion = $this->session->userdata("id_region");
                    $whereUser = "AND CRMNEW_USER.ID_JENIS_USER IN (1005,1006) AND CRMNEW_USER.ID_REGION = '$idRegion'";
                }    
            }

            $sql = "SELECT
                TO_CHAR( CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'DD' ) AS TGL,
                COUNT( CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER ) AS TOTAL 
            FROM
                CRMNEW_KUNJUNGAN_CUSTOMER 
            JOIN CRMNEW_USER ON CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER
            LEFT JOIN CRMNEW_USER_DISTRIBUTOR ON CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER
            WHERE
                TO_CHAR( CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'MM' ) = '$bulan' 
                AND TO_CHAR( CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'YYYY' ) = '$tahun'
                AND CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK = '0' AND CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME IS NOT NULL
                AND CRMNEW_USER_DISTRIBUTOR.DELETE_MARK = '0'
                $whereUser
            GROUP BY
                TO_CHAR(
                CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME,
                'DD')";
            $kunjunganHarian = $this->db->query($sql);
            // echo $this->db->last_query();
            if($kunjunganHarian->num_rows() > 0){
                return $kunjunganHarian->result();
            } else {
                return false;
            }
        }

        public function totalKunjungan($idUser = null, $idJenisUser = null, $bulan = null, $tahun = null){
            $whereUser = "";
            if($idJenisUser == "1003" || $idJenisUser == "1005" || $idJenisUser == "1006"){
                $whereUser = "AND CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = $idUser";
            } else if($idJenisUser == "1002" || $idJenisUser == "1007"){
                $idDistributor = $this->session->userdata("kode_dist");
                $whereUser = "AND CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = '$idDistributor' 
                AND CRMNEW_USER_DISTRIBUTOR.DELETE_MARK = '0' AND CRMNEW_USER.ID_JENIS_USER = '1003'";
            } else if($idJenisUser == "1001"){
                if($idUser != "null"){
                    $whereUser = "AND CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = $idUser";
                } else {
                    $idRegion = $this->session->userdata("id_region");
                    $whereUser = "AND CRMNEW_USER.ID_JENIS_USER IN (1005,1006) AND CRMNEW_USER.ID_REGION = '$idRegion'";
                }    
            }

            $sql = "SELECT
                COUNT( CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER ) AS TOTAL 
            FROM
                CRMNEW_KUNJUNGAN_CUSTOMER 
            JOIN CRMNEW_USER ON CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER
            LEFT JOIN CRMNEW_USER_DISTRIBUTOR ON CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER
            WHERE
                TO_CHAR( CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'MM' ) = '$bulan' 
                AND TO_CHAR( CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'YYYY' ) = '$tahun'
                AND CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK = '0' AND CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME IS NOT NULL
                AND CRMNEW_USER_DISTRIBUTOR.DELETE_MARK = '0'
                $whereUser";
            $kunjunganHarian = $this->db->query($sql);
            // echo $this->db->last_query();
            if($kunjunganHarian->num_rows() > 0){
                return $kunjunganHarian->row();
            } else {
                return false;
            }
        }
    }
?>
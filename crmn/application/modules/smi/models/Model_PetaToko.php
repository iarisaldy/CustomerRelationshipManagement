<?php
    class Model_PetaToko extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function masterArea(){
            $this->db->select("ID_AREA, NAMA_AREA, LATITUDE, LONGITUDE, KD_AREA, FLAG_DONE");
            $this->db->from("CRMNEW_M_AREA");
            $data = $this->db->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }

        public function stokPerToko($idCustomer){
            $sql = "SELECT
                        CRMNEW_JENIS_PRODUK_GROUP.JENIS_PRODUK, 
                        TO_CHAR(CRMNEW_HASIL_SURVEY.CREATE_DATE, 'DD-MM-YYYY') AS TGL_UPDATE,
                        SUM(CRMNEW_HASIL_SURVEY.STOK_SAAT_INI) AS STOK_SAAT_INI 
                    FROM
                        (
                    SELECT
                        MAX( CRMNEW_HASIL_SURVEY.ID_HASIL_SURVEY ) AS ID_HASIL_SURVEY,
                        CRMNEW_HASIL_SURVEY.ID_TOKO,
                        CRMNEW_HASIL_SURVEY.ID_PRODUK 
                    FROM
                        CRMNEW_HASIL_SURVEY 
                    WHERE
                        CRMNEW_HASIL_SURVEY.ID_TOKO = '$idCustomer' 
                        AND CRMNEW_HASIL_SURVEY.DELETE_MARK = '0' 
                        AND CRMNEW_HASIL_SURVEY.STOK_SAAT_INI IS NOT NULL 
                    GROUP BY
                        CRMNEW_HASIL_SURVEY.ID_TOKO,
                        CRMNEW_HASIL_SURVEY.ID_PRODUK 
                        ) A
                        JOIN CRMNEW_HASIL_SURVEY ON A.ID_HASIL_SURVEY = CRMNEW_HASIL_SURVEY.ID_HASIL_SURVEY
                        JOIN CRMNEW_PRODUK_SURVEY ON CRMNEW_HASIL_SURVEY.ID_PRODUK = CRMNEW_PRODUK_SURVEY.ID_PRODUK
                        JOIN CRMNEW_JENIS_PRODUK_GROUP ON CRMNEW_PRODUK_SURVEY.GROUP_ID = CRMNEW_JENIS_PRODUK_GROUP.GROUP_ID 
                        GROUP BY 
                            CRMNEW_JENIS_PRODUK_GROUP.JENIS_PRODUK, 
                            CRMNEW_HASIL_SURVEY.CREATE_DATE";
            $data = $this->db->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }

        public function stokToko($idArea = null, $idDistributor = null){
            $whereArea = "";
            if(isset($idArea)){
                $whereArea = "AND CRMNEW_CUSTOMER.ID_AREA = '$idArea'";
            }

            $whereDist = "";
            if(isset($idDistributor)){
                $whereDist = "AND CRMNEW_CUSTOMER.ID_DISTRIBUTOR = '$idDistributor'";
            }


            $sql = "SELECT
                        CRMNEW_CUSTOMER.ID_CUSTOMER,
                        CRMNEW_CUSTOMER.NAMA_TOKO,
                        CRMNEW_CUSTOMER.ID_AREA,
                        CRMNEW_LOKASI_CUSTOMER.LATITUDE,
                        CRMNEW_LOKASI_CUSTOMER.LONGITUDE,
                        STOK.UPDATE_DATE,
                        NVL( STOK.KAPASITAS, 0 ) AS KAPASITAS,
                        NVL( STOK.STOK_SEKARANG, 0 ) AS STOK_SEKARANG
                    FROM
                        CRMNEW_CUSTOMER
                        JOIN CRMNEW_LOKASI_CUSTOMER ON CRMNEW_CUSTOMER.ID_CUSTOMER = CRMNEW_LOKASI_CUSTOMER.ID_CUSTOMER
                        LEFT JOIN (
                    SELECT
                        A.ID_TOKO AS ID_CUSTOMER,
                        NVL( C.KAPASITAS_TOKO, 0 ) AS KAPASITAS,
                        SUM( B.STOK_SAAT_INI ) AS STOK_SEKARANG,
                        B.UPDATE_DATE
                    FROM
                        (
                    SELECT
                        MAX( CRMNEW_HASIL_SURVEY.ID_HASIL_SURVEY ) AS ID_SURVEY,
                        CRMNEW_HASIL_SURVEY.ID_TOKO,
                        CRMNEW_HASIL_SURVEY.ID_PRODUK 
                    FROM
                        CRMNEW_HASIL_SURVEY
                        JOIN CRMNEW_PRODUK_SURVEY ON CRMNEW_HASIL_SURVEY.ID_PRODUK = CRMNEW_PRODUK_SURVEY.ID_PRODUK 
                    WHERE
                        CRMNEW_HASIL_SURVEY.DELETE_MARK = '0' 
                        AND CRMNEW_HASIL_SURVEY.STOK_SAAT_INI IS NOT NULL 
                    GROUP BY
                        CRMNEW_HASIL_SURVEY.ID_TOKO,
                        CRMNEW_HASIL_SURVEY.ID_PRODUK 
                    ORDER BY
                        CRMNEW_HASIL_SURVEY.ID_TOKO,
                        CRMNEW_HASIL_SURVEY.ID_PRODUK 
                        ) A
                        JOIN CRMNEW_HASIL_SURVEY B ON A.ID_SURVEY = B.ID_HASIL_SURVEY
                        JOIN CRMNEW_CUSTOMER C ON A.ID_TOKO = C.ID_CUSTOMER 
                    GROUP BY
                        A.ID_TOKO,
                        C.KAPASITAS_TOKO,
                        B.UPDATE_DATE
                        ) STOK ON CRMNEW_CUSTOMER.ID_CUSTOMER = STOK.ID_CUSTOMER 
                    WHERE
                        CRMNEW_LOKASI_CUSTOMER.DELETE_MARK = '0' $whereArea $whereDist";

            $data = $this->db->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }

    }
?>
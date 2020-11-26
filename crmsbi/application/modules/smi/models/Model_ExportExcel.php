<?php
    class Model_ExportExcel extends CI_Model {

        public function __construct(){
            parent::__construct();
        }

        public function dataToko($status, $distrik, $distributor = null){
            $db_point = $this->load->database("Point", true);
            $whereStatus = "";
            $whereDistributor = "";

            if(isset($distributor)){
                $whereDistributor = "AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$distributor'";
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
                        M_CUSTOMER.NM_DISTRIK LIKE '$distrik'
                        AND M_CUSTOMER.NOMOR_DISTRIBUTOR IS NOT NULL 
                        AND M_CUSTOMER.KD_CUSTOMER IS NOT NULL
                        $whereStatus $whereDistributor";

            $retail = $db_point->query($sql);
            if($retail->num_rows() > 0){
                return $retail->result();
            } else {
                return false;
            }
        }

        public function clusterToko($cluster, $idProvinsi, $bulan, $distrik = null, $tahun){
            $db_point = $this->load->database("Point", true);
            $cluster = trim($cluster);
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1003" || $idJenisUser == "1005" || $idJenisUser == "1002"){
                $idDistributor = $this->session->userdata("kode_dist");
                $db_point->where("M_CUSTOMER.NOMOR_DISTRIBUTOR", $idDistributor);
            }

            if(isset($distrik)){
                if($distrik != ""){
                    $db_point->where("M_CUSTOMER.NM_DISTRIK", $distrik);
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

            $db_point->select("M_CUSTOMER.ID_CUSTOMER, M_CUSTOMER.NAMA_TOKO, M_CUSTOMER.NM_CUSTOMER AS NAMA_PEMILIK, M_CUSTOMER.DISTRIBUTOR AS NAMA_DISTRIBUTOR, M_CUSTOMER.ALAMAT_TOKO AS ALAMAT, M_CUSTOMER.KECAMATAN, M_CUSTOMER.GROUP_CUSTOMER, TOKO_LT.NAMA_TOKO AS LT");
            $db_point->from("P_POIN");
            $db_point->join("M_CUSTOMER", "P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER");
            $db_point->join("(SELECT KD_SAP, NAMA_TOKO FROM M_CUSTOMER WHERE GROUP_CUSTOMER = 'LT') TOKO_LT", "M_CUSTOMER.KD_LT = TOKO_LT.KD_SAP", "LEFT");
            $db_point->where("P_POIN.STATUS != ", "5");
            $db_point->where("P_POIN.TAHUN", $tahun);
            $db_point->where("P_POIN.BULAN", $bulan);
            $db_point->where("M_CUSTOMER.KD_PROVINSI", $idProvinsi);

            $data = $db_point->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
        }
    }
?>
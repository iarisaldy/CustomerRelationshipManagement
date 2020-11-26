<?php
	if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

	class Model_cluster extends CI_Model {

		public function checkProvDist($idDistributor){
			$this->load->database("default", true);
			$sql = "SELECT ID_PROVINSI FROM (
					SELECT
						SUBSTR(KD_DISTRIK, 0, 2) AS ID_PROVINSI,
						COUNT( SUBSTR(KD_DISTRIK, 0, 2) ) AS TOTAL_GUDANG
					FROM
						CRMNEW_M_GUDANG_DISTRIBUTOR 
					WHERE
						KODE_DISTRIBUTOR = $idDistributor
					GROUP BY
						SUBSTR(KD_DISTRIK, 0, 2)) ORDER BY TOTAL_GUDANG DESC";

			$idProvinsi = $this->db->query($sql)->row();
			return $idProvinsi;
		}

		public function clusterTokoDistributor($idDistributor, $idProvinsi, $cluster, $bulan, $tahun){
			$db_point = $this->load->database("Point", true);
			if(isset($idProvinsi)){
                if($idProvinsi == "1025"){
                    if($cluster == "SUPER PLATINUM"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "2200");
                    } else if($cluster == "PLATINUM"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 680 AND 2199");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 400 AND 679");
                    } else if($cluster == "SILVER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 280 AND 399");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 279");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                } else if($idProvinsi == "1023" || $idProvinsi == "1024"){
                    if($cluster == "PLATINUM"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "320");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 319");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                } else if($idProvinsi == "1022" || $idProvinsi == "1021" || $idProvinsi == "1020"){
                    if($cluster == "PLATINUM"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "320");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 240 AND 319");
                    } else if($cluster == "SILVER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 239");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 199");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                } else if($idProvinsi == "1026"){
                    if($cluster == "PLATINUM"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) >=", "400");
                    } else if($cluster == "GOLD"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 200 AND 399");
                    } else if($cluster == "SILVER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 120 AND 199");
                    } else if($cluster == "NON CLUSTER"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) BETWEEN 0.1 AND 119");
                    } else if($cluster == "TIDAK ADA PENJUALAN"){
                        $db_point->where("(P_POIN.PENJUALAN + P_POIN.PENJUALAN_SP) =", "0");
                    }
                }
            }

            $db_point->select("M_CUSTOMER.NM_DISTRIK, M_CUSTOMER.KD_DISTRIK, COUNT(M_CUSTOMER.ID_CUSTOMER) AS JUMLAH");
            $db_point->from("P_POIN");
            $db_point->join("M_CUSTOMER", "P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER");
            $db_point->where(array("P_POIN.BULAN" => $bulan, "P_POIN.TAHUN" => $tahun));
            $db_point->where("M_CUSTOMER.NOMOR_DISTRIBUTOR", $idDistributor);
            $db_point->where("P_POIN.STATUS !=", "5");
            $db_point->group_by("M_CUSTOMER.NM_DISTRIK, M_CUSTOMER.KD_DISTRIK");
            $data = $db_point->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }

		}

		public function trackRecordCluster($idProvinsi, $idDistributor, $cluster, $nmDistrik, $tahun){
            $db_point = $this->load->database("Point", true);

            $db_point->where("M_CUSTOMER.NOMOR_DISTRIBUTOR", $idDistributor);
            $db_point->like("M_CUSTOMER.NM_DISTRIK", $nmDistrik, "both");            
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

        public function listTrackRecordCluster($start = null, $limit = null, $idProvinsi, $idDistributor, $cluster, $idDistrik, $bulan, $tahun, $order = null, $sort = null, $idLt = null, $namaToko = null){
            $db_point = $this->load->database("Point", true);

            if(isset($order) || isset($sort)){
                $db_point->order_by($order, $sort);
            }

            if(isset($start) || isset($limit)){
                $db_point->limit($limit, $start);
            }

            if(isset($idLt)){
                if($idLt != ""){
                    $db_point->where("M_CUSTOMER.KD_LT", $idLt);
                }
            }

            if(isset($namaToko)){
                if($namaToko != ""){
                    $db_point->like("M_CUSTOMER.NAMA_TOKO", strtoupper($namaToko), "both");
                }
            }
                  
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

            $db_point->select("M_CUSTOMER.ID_CUSTOMER, M_CUSTOMER.NAMA_TOKO, M_CUSTOMER.NM_CUSTOMER, M_CUSTOMER.DISTRIBUTOR, M_CUSTOMER.ALAMAT_TOKO, M_CUSTOMER.KECAMATAN, M_CUSTOMER.NM_CUSTOMER AS NAMA_PEMILIK, M_CUSTOMER.GROUP_CUSTOMER, M_CUSTOMER.KD_LT, TOKO_LT.NAMA_TOKO AS LT");
            $db_point->from("P_POIN");
            $db_point->join("M_CUSTOMER", "P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER");
            $db_point->join("(SELECT KD_SAP, NAMA_TOKO FROM M_CUSTOMER WHERE GROUP_CUSTOMER = 'LT') TOKO_LT", "M_CUSTOMER.KD_LT = TOKO_LT.KD_SAP", "LEFT");
            $db_point->where("P_POIN.STATUS != ", "5");
            $db_point->where("P_POIN.TAHUN", $tahun);
            $db_point->where("P_POIN.BULAN", $bulan);
            $db_point->where("M_CUSTOMER.KD_DISTRIK", $idDistrik);
            $db_point->where("M_CUSTOMER.NOMOR_DISTRIBUTOR", $idDistributor);
            $data = $db_point->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
        }


    }
?>
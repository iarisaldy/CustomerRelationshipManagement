<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_toko_aktif extends CI_Model {

        public function detailChartActivation($kodeDist, $idProvinsi, $status){
            $whereStatus = "";
            $whereDistributor = "";
            $whereProvinsi = "";
            $db_point = $this->load->database("Point", true);
            // if($idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1005"){
                // $whereDistributor = "AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$kodeDist'";
            // } else {
                // $whereProvinsi = "AND M_CUSTOMER.KD_PROVINSI = '$idProvinsi'";
            // }

            $whereDistributor = "AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$kodeDist'";
			
			if(isset($idProvinsi)){
                $whereProvinsi = "AND M_CUSTOMER.KD_PROVINSI = '$idProvinsi'";
            }
				
            if($status == "AKTIF"){
                $whereStatus = "AND P_USER.STATUS IN (1, 2)";
            } else if($status == "NONAKTIF"){
                $whereStatus = "AND P_USER.STATUS = 4";
            }
            $sql = "SELECT
                        TRIM(M_CUSTOMER.NM_DISTRIK) AS name,
						M_CUSTOMER.KD_DISTRIK AS kd_distrik,
                        COUNT( P_USER.STATUS ) AS value 
                    FROM
                        M_CUSTOMER
                        LEFT JOIN P_USER ON M_CUSTOMER.KD_CUSTOMER = P_USER.KD_CUSTOMER 
                    WHERE
                        M_CUSTOMER.NOMOR_DISTRIBUTOR IS NOT NULL 
                        AND M_CUSTOMER.KD_CUSTOMER IS NOT NULL 
                        $whereStatus $whereDistributor
                        $whereProvinsi
                    GROUP BY
                        M_CUSTOMER.KD_DISTRIK, TRIM(M_CUSTOMER.NM_DISTRIK)";
            $retail = $db_point->query($sql);
            if($retail->num_rows() > 0){
                return $retail->result();
            } else {
                return false;
            }
        }
		
		public function detailRetailDistrik($idDistributor, $nmDistrik, $status){
            $db_point = $this->load->database("Point", true);
            $whereStatus = "";
            $whereDistributor = "";
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1003" || $idJenisUser == "1002" || $idJenisUser == "1005"){
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

            $retail = $db_point->query($sql);
            if($retail->num_rows() > 0){
                return $retail->result();
            } else {
                return false;
            }

        }
		
		public function listTrackRecordAktif($start = null, $limit = null, $idDistributor, $status, $idDistrik, $order = null, $sort = null, $idLt = null, $namaToko = null){
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
			
            $db_point->select("M_CUSTOMER.ID_CUSTOMER AS ID_CUSTOMER, 
								M_CUSTOMER.ID_CUSTOMER AS KD_CUSTOMER, 
								M_CUSTOMER.NAMA_TOKO, 
								M_CUSTOMER.DISTRIBUTOR, 
								M_CUSTOMER.ALAMAT_TOKO AS ALAMAT, 
								M_CUSTOMER.KECAMATAN AS NAMA_KECAMATAN, 
								M_CUSTOMER.NM_CUSTOMER AS NAMA_PEMILIK, 
								M_CUSTOMER.GROUP_CUSTOMER AS TYPE_TOKO, 
								M_CUSTOMER.KD_LT, 
								TOKO_LT.NAMA_TOKO AS NAMA_LT");
            $db_point->from("M_CUSTOMER");
            $db_point->join("P_USER", "P_USER.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER");
			$db_point->join("(SELECT KD_SAP, NAMA_TOKO FROM M_CUSTOMER WHERE GROUP_CUSTOMER = 'LT') TOKO_LT", "M_CUSTOMER.KD_LT = TOKO_LT.KD_SAP", "LEFT");
            $db_point->where("M_CUSTOMER.KD_DISTRIK", $idDistrik);
			// $db_point->like("M_CUSTOMER.NM_DISTRIK", $idDistrik);
            $db_point->where("M_CUSTOMER.KD_CUSTOMER IS NOT NULL", NULL, FALSE);
            $db_point->where("M_CUSTOMER.NOMOR_DISTRIBUTOR IS NOT NULL", NULL, FALSE);
            $db_point->where("M_CUSTOMER.NOMOR_DISTRIBUTOR", $idDistributor);
			
			if($status == "AKTIF"){
				$db_point->where("P_USER.STATUS IN (1,2)");
            } else if($status == "NONAKTIF"){
				$db_point->where("P_USER.STATUS", 4);
            }
			
            $data = $db_point->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
        }

    }
?>
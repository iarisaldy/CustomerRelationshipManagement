<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Dashboard_model extends CI_Model {
		
		
		public function Insert_update_tagging_lokasi($id_user, $dataLokasi){
			
			$status = null;
			$id_lokasi = null;
			foreach($dataLokasi as $dl){
				
				$id_customer 	= $dl['ID_CUSTOMER'];
				//$lokasi 		= $dl['ID_LOKASI_CUSTOMER'];
				$latitude 		= $dl['LATITUDE'];
				$longitude 		= $dl['LONGITUDE'];
				
				if($id_lokasi==null){
					$id_lokasi = $dl['ID_CUSTOMER'];
				}
				else {
					$id_lokasi = $id_lokasi. ','. $dl['ID_CUSTOMER'];
				}
				
				//CEK DATA DI DATABASE
				$sql ="
					SELECT
						ID_CUSTOMER
					FROM CRMNEW_LOKASI_CUSTOMER
					WHERE ID_CUSTOMER='$id_customer'
					AND DELETE_MARK=0
				";
				
				$hasil = $this->db->query($sql)->result_array();
				
				if(count($hasil)==1){
					//ini harus di update
					$sqld = "
						UPDATE CRMNEW_LOKASI_CUSTOMER
						SET 
						LATITUDE='$latitude',
						LONGITUDE='$longitude',
						CREATE_BY='$id_user',
						CREATE_DATE=SYSDATE
						WHERE ID_CUSTOMER='$id_customer'
						AND DELETE_MARK=0
					";
					
					$this->db->query($sqld);
					$status=1;
				}
				else {
					//ini harus di insert
					$sqli = "
						INSERT INTO CRMNEW_LOKASI_CUSTOMER (ID_CUSTOMER, LATITUDE, LONGITUDE, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_customer', '$latitude', '$longitude', '$id_user', SYSDATE, 0)
					";
					$this->db->query($sqli);
					$status=1;
				}
			}
			
			$SQL_DATA = " 
						SELECT
							ID_CUSTOMER,
							LATITUDE,
							LONGITUDE,
							ID_LOKASI_CUSTOMER
						FROM CRMNEW_LOKASI_CUSTOMER
						WHERE ID_CUSTOMER IN ($id_lokasi) 
						";
			return $this->db->query($SQL_DATA)->result_array();
			//return $status;
		}
		
		public function Get_artikel(){
			
			$sql ="
				SELECT
				* 
				FROM CRMNEW_NEWS
				ORDER BY PUP_DATE DESC
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		public function Tampilan_customer($customer){
			
			$sql =" 
					SELECT 
						LC.*
					FROM CRMNEW_LOKASI_CUSTOMER LC
					WHERE lc.delete_mark=0
					AND lc.id_customer IN ($customer) 
					";
			
			return $this->db->query($sql)->result_array();
			
		}
		public function Insert_data_Taggling_news(){
			
		}
				
		// public function Insert_data_taggig($id_user, $id_customer, $kd_provinsi, $kd_distrik, $kd_area, $Latitude, $longitude){
		public function Insert_data_taggig($data, $dataIdCustomer){
			$data = $this->db->insert_batch("CRMNEW_LOKASI_CUSTOMER", $data);
			if($this->db->affected_rows() > 0){
				$dataHasilInsert = $this->db->select("ID_LOKASI_CUSTOMER, ID_CUSTOMER, LATITUDE, LONGITUDE, CREATE_BY, CREATE_DATE, DELETE_MARK")->from("CRMNEW_LOKASI_CUSTOMER")->where_in("ID_CUSTOMER", $dataIdCustomer)->get()->result();
				return $dataHasilInsert;
			} else {
				return false;
			}

			exit();
			// $SQL2="
			// 	SELECT 
			// 	ID_CUSTOMER
			// 	FROM CRMNEW_LOKASI_CUSTOMER
			// 	WHERE DELETE_MARK=0
			// 	AND ID_CUSTOMER='$id_customer'
			// ";
			// //echo $SQL2;
			// $hasil = $this->db->query($SQL2)->result_array();
			
			// if(count($hasil)==0){
			// 	$sql ="
			// 		INSERT INTO CRMNEW_LOKASI_CUSTOMER 
			// 		(ID_CUSTOMER, KD_PROVINSI, KD_AREA, KD_DISTRIK, LATITUDE, LONGITUDE, CREATE_BY, CREATE_DATE, DELETE_MARK)
			// 		VALUES
			// 		('$id_customer', '$kd_provinsi', '$kd_distrik', '$kd_area', '$Latitude', '$longitude', '$id_user', SYSDATE, '0')
			// 	";
				
			// 	return $this->db->query($sql);
			// }
			// else {
			// 	return null;
			// }
			
		}
		// public function Update_data_tugging($id_user, $id_customer, $kd_provinsi, $kd_distrik, $kd_area, $Latitude, $longitude){
		public function Update_data_tagging($data){
			$data = $this->db->update_batch("CRMNEW_LOKASI_CUSTOMER", $data, "ID_LOKASI_CUSTOMER");
			if($this->db->affected_rows() > 0){
				return true;
			} else {
				return false;
			}

			exit();
			// $sql = " 
			// 	UPDATE CRMNEW_LOKASI_CUSTOMER
			// 	SET
			// 	KD_PROVINSI='$kd_provinsi',
			// 	KD_AREA='$kd_area',
			// 	KD_DISTRIK='$kd_distrik',
			// 	LATITUDE='$Latitude',
			// 	LONGITUDE='$longitude',
			// 	CREATE_BY='$id_user',
			// 	CREATE_DATE=SYSDATE,
			// 	DELETE_MARK=0
			// 	WHERE ID_CUSTOMER='$id_customer'
			// ";
			
			// return $this->db->query($sql);
			
		}
		public function get_data_retail_activation($user, $tahun, $bulan, $kode_provinsi, $kode_distributor){
			
			$this->db = $this->load->database('Point', TRUE); 
			
			$sql ="
				SELECT
					COUNT(*) JML_AKTIF,
					PU.STATUS
				FROM M_CUSTOMER MC
				LEFT JOIN P_USER PU ON MC.KD_CUSTOMER=PU.ID_CUSTOMER
				WHERE PU.STATUS IN ( 1, 2, 4 )
				AND MC.NOMOR_DISTRIBUTOR='$kode_distributor'
				AND MC.KD_PROVINSI='$kode_provinsi'
				GROUP BY PU.STATUS
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		public function get_cluster_toko($idProvinsi, $distributor, $tahun, $bulan){
			$this->db = $this->load->database('Point', TRUE); 
			
			$parameter = ", 0 AS CLUSTERR ";
			
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
			
			if($distributor==null || $distributor==""){
				$dist = " ";
			}
			else {
				$dist = " AND MC.NOMOR_DISTRIBUTOR='$distributor' ";
			}

			$sql ="
				SELECT
			CLUSTERR, 
			COUNT(KD_CUSTOMER) AS JUMLAH
			FROM (
				SELECT
					PP.KD_DISTRIBUTOR,
					PP.KD_CUSTOMER,
					SUM(PP.PENJUALAN + PP.PENJUALAN_SP) AS NILAI,
					M_CUS.KD_PROVINSI,
					$parameter
					
					FROM P_POIN PP
					LEFT JOIN 	(
									SELECT 
										MC.KD_CUSTOMER, 
										MC.NM_CUSTOMER, 
										MC.KD_PROVINSI ,
										MC.NOMOR_DISTRIBUTOR
									FROM 
										M_CUSTOMER MC 
									LEFT JOIN 
										P_USER PU 
									ON 
										MC.KD_CUSTOMER = PU.KD_CUSTOMER 
									WHERE PU.STATUS IN (1,2) 
									 AND MC.NOMOR_DISTRIBUTOR IS NOT NULL 
									   $dist
								) M_CUS ON PP.KD_DISTRIBUTOR=M_CUS.NOMOR_DISTRIBUTOR
									AND PP.KD_CUSTOMER=M_CUS.KD_CUSTOMER 
					--LEFT JOIN M_CUSTOMER MC ON 
					WHERE PP.TAHUN='$tahun'
					AND PP.BULAN='$bulan'
					AND M_CUS.KD_PROVINSI='$idProvinsi'
					AND PP.STATUS != 5
					GROUP BY 
						PP.KD_DISTRIBUTOR,
						PP.KD_CUSTOMER,
						M_CUS.KD_PROVINSI
				)
				WHERE CLUSTERR IS NOT NULL
				GROUP BY CLUSTERR
			
			";
			// echo $sql ;
			// exit;
			return $this->db->query($sql)->result_array();
		}
		
		public function clusterRegion($idProvinsi = null, $distributor, $tahun, $month){
        	$this->db = $this->load->database('Point', TRUE); 
			
            $year = date('Y');
            $idJenisUser = "1002";//$this->session->userdata("id_jenis_user");
			
			$whereProvinsi = "AND M_CUS.KD_PROVINSI = '$idProvinsi' ";
			$whereDistributor = "AND MC.NOMOR_DISTRIBUTOR = '$distributor'";
			
            // if($idJenisUser == "1005" || $idJenisUser == "1003" || $idJenisUser == "1002"){
            	// $idDistributor = $this->session->userdata("kode_dist");
            	// $whereDistributor = "AND MC.NOMOR_DISTRIBUTOR = '$idDistributor'";
                // $whereProvinsi = "";
            // } else {
            	// $whereDistributor = "";
                // $whereProvinsi = "AND M_CUS.KD_PROVINSI = $idProvinsi";
            // }


            if(isset($idProvinsi)){
                $whereProvinsi = "AND M_CUS.KD_PROVINSI = $idProvinsi";
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
                LEFT JOIN ( 
						SELECT 
							MC.KD_CUSTOMER, MC.NM_CUSTOMER, MC.KD_PROVINSI 
						FROM 
							M_CUSTOMER MC 
						LEFT JOIN 
							P_USER PU 
						ON 
							MC.KD_CUSTOMER = PU.KD_CUSTOMER 
						WHERE PU.STATUS IN (1,2) 
						AND MC.NOMOR_DISTRIBUTOR IS NOT NULL $whereDistributor 
					) M_CUS ON PP.KD_CUSTOMER = M_CUS.KD_CUSTOMER 
            WHERE 
                PP.STATUS != 5
                AND PP.TAHUN = '$tahun' 
                AND PP.BULAN = '$month' 
                -- $whereProvinsi
                 
            GROUP BY
                PP.KD_CUSTOMER,
                M_CUS.NM_CUSTOMER) WHERE CLUSTERR IS NOT NULL
        GROUP BY CLUSTERR";
			echo $sql;
            return $this->db->query($sql)->result_array();
			
        }
		
		public function get_toko_tidak_lapor($provinsi, $distributor, $tahun, $bulan){
			$sql = "SELECT
            count( a.kd_customer ) AS TOTAL
        FROM
            m_customer a
        LEFT JOIN p_user b ON a.KD_CUSTOMER = b.KD_CUSTOMER
        WHERE b.STATUS IN ( 1, 2 ) AND a.KD_PROVINSI = '$provinsi'
            AND a.NOMOR_DISTRIBUTOR IS NOT NULL AND a.NOMOR_DISTRIBUTOR = '$distributor'
            AND a.KD_CUSTOMER NOT IN (SELECT kd_customer FROM p_poin WHERE BULAN = $bulan AND TAHUN = $tahun AND STATUS != 5 )";
			// $sql ="
			// 	SELECT
			// 		count( a.kd_customer ) AS TOTAL
			// 	FROM
			// 		m_customer a
			// 	LEFT JOIN p_user b ON a.KD_CUSTOMER = b.KD_CUSTOMER
			// 	WHERE b.STATUS IN ( 1, 2 ) AND a.KD_PROVINSI = '$provinsi'
			// 		AND a.NOMOR_DISTRIBUTOR IS NOT NULL AND a.NOMOR_DISTRIBUTOR = '$distributor'
			// ";
			
			return $this->db->query($sql)->result_array();
		}
		
		public function get_realisasi_kunjungan($id_user){
			
			$sql ="
				SELECT
				COUNT(*) AS REALISASI_KUNJUNGAN
				FROM CRMNEW_KUNJUNGAN_CUSTOMER
				WHERE ID_USER='$id_user'
				AND CHECKIN_TIME IS NOT NULL
			";
			
			return $this->db->query($sql)->result_array();
		}
		
		public function get_target_kunjungan($id_user){
			
			$sql ="
				SELECT
				COUNT(*) AS TARGET_KUNJUNGAN
				FROM CRMNEW_KUNJUNGAN_CUSTOMER
				WHERE ID_USER='$id_user'
			";
			
			return $this->db->query($sql)->result_array();
		}
		public function get_data_index($id_user, $tahun, $bulan){
			
			$sql ="
				SELECT
					DATA_INDEX.*,
					VOL.VOLUME AS TARGET_VOLUME,
					HARGA.HARGA AS TARGET_HARGA,
					(VOL.VOLUME*HARGA.HARGA) AS TARGET_REVENUE
					FROM 
					(
						SELECT
							I.ID_JENIS_USER,
							I.KODE_DISTRIBUTOR,
							I.VOLUME AS INDEX_VOLUME,
							I.HARGA AS INDEX_HARGA,
							I.REVENUE AS INDEX_REVENUE,
							I.KUNJUNGAN AS INDEX_KUNJUNGAN
						FROM CRMNEW_INDEX_KPI I
						WHERE I.DELETE_MARK=0 
						AND I.ID_JENIS_USER='1002'
						AND I.KODE_DISTRIBUTOR=(
													SELECT
														KODE_DISTRIBUTOR
													FROM CRMNEW_USER_DISTRIBUTOR 
													WHERE DELETE_MARK=0
													AND ID_USER='$id_user'
													AND ROWNUM=1
												)
					) DATA_INDEX
					LEFT JOIN CRMNEW_TARGET_VOLUME_KPI VOL ON DATA_INDEX.KODE_DISTRIBUTOR=VOL.KODE_DISTRIBUTOR
						AND VOL.TAHUN='$tahun' AND BULAN='$bulan'
					LEFT JOIN CRMNEW_TARGET_HARGA_KPI HARGA ON DATA_INDEX.KODE_DISTRIBUTOR=HARGA.KODE_DISTRIBUTOR
						AND HARGA.TAHUN='$tahun' AND HARGA.BULAN='$bulan'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
        
		public function get_data_realisasi($distributor, $tahun, $bulan){
			
			$this->db = $this->load->database('SCM', TRUE); 
			
			$sql ="
				SELECT
					SOLD_TO AS KODE_DISTRIBUTOR,
					ROUND(SUM(KWANTUMX), 0) AS REAL_VOLUME,
					ROUND(SUM(HARGA)/SUM(KWANTUMX), 0) AS REAL_HARGA_PER_TON,
					ROUND(SUM(HARGA), 0) AS REAL_REVENUE
				FROM ZREPORT_SCM_HARGA_SOLDTO
				WHERE TAHUN='$tahun'
				AND BULAN='$bulan'
				AND SOLD_TO ='$distributor'
				GROUP BY 
					SOLD_TO
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		
		
		
		
		public function Perubahan_password_user($id_user, $pass_lama, $pass_baru){
			
			$status = null;
			
			$bkl = "
				SELECT 
				PASSWORD
				FROM CRMNEW_USER
				WHERE ID_USER='$id_user'
			";
			
			$hasil = $this->db->query($bkl)->result_array();
			
			if(count($hasil)==1){
				$passdb = $hasil[0]['PASSWORD'];
				if($passdb==$pass_lama){
					$sql ="
						UPDATE CRMNEW_USER 
						SET 
						PASSWORD='$pass_baru',
						UPDATED_BY='$id_user',
						UPDATED_AT=SYSDATE
						WHERE ID_USER='$id_user'
						AND PASSWORD='$pass_lama'
					";
					$cek = $this->db->query($sql);
					if($cek){
						$status=1;
					}
					
				}
			}
			
			return $status;
		}

    }
?>
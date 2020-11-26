<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Dashboard_distributor_model extends CI_Model {
		
		public function ltDistributor($start, $limit, $idDistributor, $namaToko){
            $this->db->select("ID_CUSTOMER, KD_SAP, NAMA_TOKO");
            $this->db->from("CRMNEW_CUSTOMER");
            $this->db->limit($limit, $start);
            $this->db->where("GROUP_CUSTOMER", "LT");
            $this->db->where("ID_DISTRIBUTOR", $idDistributor);
			
			if(isset($namaToko)){
                if($namaToko != ""){
                    $this->db->like("NAMA_TOKO", $namaToko, "both");
                }
            }

            $ltDistributor = $this->db->get();
            if($ltDistributor){
                return $ltDistributor->result();
            } else {
                return false;
            }
        }
		public function get_data_produk($kd_distributor, $id_user, $id_kc){
			$this->db = $this->load->database('crm', TRUE);
			$sql ="
				SELECT 
				PS.NAMA_PRODUK AS NAME
				FROM CRMNEW_HASIL_SURVEY HS
				LEFT JOIN CRMNEW_PRODUK_SURVEY PS ON HS.ID_PRODUK=PS.ID_PRODUK
				WHERE HS.ID_KUNJUNGAN_CUSTOMER='$id_kc'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		public function getProvinsiDist($idDistributor){
			$this->db = $this->load->database('crm', TRUE);
			$sql = "SELECT
						SUBSTR( KD_DISTRIK, 1, 2 ) AS PROVINSI,
						COUNT( ID_GUDANG_DIST ) AS JUMLAH 
					FROM
						CRMNEW_M_GUDANG_DISTRIBUTOR 
					WHERE
						KODE_DISTRIBUTOR = $idDistributor 
					GROUP BY
						SUBSTR( KD_DISTRIK, 1, 2 ) 
					ORDER BY
						COUNT(
						ID_GUDANG_DIST) DESC";
			$dist = $this->db->query($sql)->row();
			return $dist;
		}
		public function get_data_customer_survey($kd_distributor, $id_user, $id_kc){
			$this->db = $this->load->database('crm', TRUE);
			$sql ="
				SELECT
				KC.ID_KUNJUNGAN_CUSTOMER,
				KC.ID_USER,
				CU.NAMA,
				KC.ID_TOKO,
				C.NAMA_TOKO,
				KC.TGL_RENCANA_KUNJUNGAN,
				(TO_DATE(TO_CHAR(KC.CHECKOUT_TIME, 'DD-MM-YYYY HH24:MI:SS'), 'DD-MM-YYYY HH24:MI:SS') - 
				TO_DATE(TO_CHAR(KC.CHECKIN_TIME, 'DD-MM-YYYY HH24:MI:SS'),'DD-MM-YYYY HH24:MI:SS'))*(24*60) AS DURASI_KUNJUNGAN,
				TO_CHAR(KC.CHECKIN_TIME, 'DD-MM-YYYY HH24:MI') AS CHECKIN_TIME,
				TO_CHAR(KC.CHECKOUT_TIME, 'DD-MM-YYYY HH24:MI') AS CHECKOUT_TIME,
				KC.CHECKOUT_LATITUDE,
				KC.CHECKIN_LONGITUDE,
				KC.CHECKOUT_LATITUDE,
				KC.CHECKOUT_LONGITUDE,
				C.NAMA_DISTRIK,
				C.NAMA_KECAMATAN,
				C.ALAMAT
				FROM CRMNEW_KUNJUNGAN_CUSTOMER KC
				LEFT JOIN CRMNEW_CUSTOMER C ON KC.ID_TOKO=C.ID_CUSTOMER
				LEFT JOIN CRMNEW_USER CU ON KC.ID_USER=CU.ID_USER
				WHERE KC.ID_USER='$id_user'
				AND KC.ID_KUNJUNGAN_CUSTOMER='$id_kc'
				AND C.ID_DISTRIBUTOR='$kd_distributor'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		public function Insert_data_error($id_user, $id_kunjungan, $id_customer, $id_error, $ket_log, $status){
			
			$sql ="
				INSERT INTO CRMNEW_LOG_APPS 
				(ID_USER, ID_KUNJUNGAN, ID_CUSTOMER, ID_ERROR, KET_LOG, STATUS, CREATE_AT)
				VALUES
				('$id_user', '$id_kunjungan', '$id_customer', '$id_error', '$ket_log', '$status', SYSDATE)
			
			";
			return $this->db->query($sql);
		}
		public function Add_schedule_kunjungan($id_user, $data){
			
			$data_result = array();
			
			foreach($data as $d){
				$status 			= 0;
				$cek 				= null;
				$id_kunjungan 		= null;
				
				$id_customer 		= $d['ID_CUSTOMER'];
				$tgl_rencana		= $d['TGL_RENCANA_KUNJUNGAN'];
				$keterangan 		= $d['KETERANGAN'];
				$CHECKIN_LATITUDE 	= $d['CHECKIN_LATITUDE'];
				$CHECKIN_LONGITUDE 	= $d['CHECKIN_LONGITUDE'];
				$CHECKOUT_LATITUDE 	= $d['CHECKOUT_LATITUDE'];
				$CHECKOUT_LONGITUDE = $d['CHECKOUT_LONGITUDE'];
				
				if($d['CHECKIN_TIME']==null || $d['CHECKIN_TIME']==''){
					$CHECKIN_TIME 	= null;
					//ECHO "NULL";
				}
				else {
					$CHECKIN_TIME 	= date('d-M-y h.s.i A', strtotime($d['CHECKIN_TIME']));
				}
				if($d['CHECKOUT_TIME']==null || $d['CHECKOUT_TIME']==''){
					$CHECKOUT_TIME 	= null;
				}
				else {
					$CHECKOUT_TIME 	= date('d-M-y h.s.i A', strtotime($d['CHECKOUT_TIME']));
				}
						
				$sql ="
					SELECT 
						TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL
					FROM CRMNEW_KUNJUNGAN_CUSTOMER
					WHERE ID_TOKO='$id_customer'
					AND ID_USER='$id_user'
					AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD')='$tgl_rencana'
				";
				
				$hasil  = $this->db->query($sql)->result_array();
				// print_r($hasil);
				
				// exit;
				$TGL_KUN = date('d-M-y', strtotime($tgl_rencana));
				
				if(count($hasil)==0){
					$sql2 = "
						INSERT INTO CRMNEW_KUNJUNGAN_CUSTOMER 
						(ID_USER, ID_TOKO, TGL_RENCANA_KUNJUNGAN, CREATED_BY, CREATED_AT, CHECKIN_TIME, CHECKIN_LATITUDE, CHECKIN_LONGITUDE, CHECKOUT_TIME, CHECKOUT_LATITUDE, CHECKOUT_LONGITUDE, KETERANGAN, DELETED_MARK)
						VALUES 
						('$id_user', '$id_customer', '$TGL_KUN', '$id_user', SYSDATE, '$CHECKIN_TIME', '$CHECKIN_LATITUDE', '$CHECKIN_LONGITUDE', '$CHECKOUT_TIME', '$CHECKOUT_LATITUDE', '$CHECKOUT_LONGITUDE', '$keterangan', 0)
					";
					$cek = $this->db->query($sql2);
					if($cek){
						$status=1;
						//echo "di insert 1";
					}
					
					$id_kunjungan = $this->get_id_kunjungan($id_user, $id_customer, $TGL_KUN);
				}
				else {
					
					$id_kunjungan = $this->get_id_kunjungan($id_user, $id_customer, $TGL_KUN);
					
					if($d['CHECKIN_TIME']==null || $d['CHECKIN_TIME']==''){
						$sql3 ="
							SELECT
								CC.ID_KUNJUNGAN_CUSTOMER,
								CC.ID_USER,
								JU.JENIS_USER,
								U.NAMA AS NAMA_SALES,
								CC.ID_TOKO AS ID_CUSTOMER,
								C.NAMA_TOKO AS NM_CUSTOMER,
								C.TELP_TOKO AS TELP_CUSTOMER,
								C.ALAMAT,
								C.NAMA_PEMILIK,
								CC.CHECKIN_LATITUDE,
								CC.CHECKIN_LONGITUDE,
								TO_CHAR(CC.CHECKIN_TIME, 'YYYY-MM-DD HH24:MI:SS') AS CHECKIN_TIME,
								CC.CHECKOUT_LATITUDE,
								CC.CHECKOUT_LONGITUDE,
								TO_CHAR(CC.CHECKOUT_TIME, 'YYYY-MM-DD HH24:MI:SS') AS CHECKOUT_TIME,
								TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN,
								CC.KETERANGAN
							FROM CRMNEW_KUNJUNGAN_CUSTOMER CC
							LEFT JOIN CRMNEW_USER U ON CC.ID_USER=U.ID_USER
							LEFT JOIN CRMNEW_JENIS_USER JU ON U.ID_JENIS_USER=JU.ID_JENIS_USER
							LEFT JOIN CRMNEW_CUSTOMER C ON CC.ID_TOKO=C.ID_CUSTOMER
							WHERE CC.ID_TOKO='$id_customer'
							AND CC.ID_USER='$id_user'
							AND TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD')='$tgl_rencana'
							
						";
						
						$result_not_change  = $this->db->query($sql3)->row();
						$status = 2;
						
					}else if($d['CHECKOUT_TIME']==null || $d['CHECKOUT_TIME']==''){
						$sql3 = "
						UPDATE CRMNEW_KUNJUNGAN_CUSTOMER
						SET 
							CHECKIN_TIME='$CHECKIN_TIME',
							CHECKIN_LATITUDE='$CHECKIN_LATITUDE',
							CHECKIN_LONGITUDE='$CHECKIN_LONGITUDE'
						WHERE ID_TOKO='$id_customer'
						AND ID_USER='$id_user'
						AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD')='$tgl_rencana' ";
												//echo $sql3;
						$cek = $this->db->query($sql3);
						if($cek){
							$status=1;
							//echo "di update 1";
						}
					}else {
						$sql3 = "
						UPDATE CRMNEW_KUNJUNGAN_CUSTOMER
						SET 
							CHECKIN_TIME='$CHECKIN_TIME',
							CHECKIN_LATITUDE='$CHECKIN_LATITUDE',
							CHECKIN_LONGITUDE='$CHECKIN_LONGITUDE',
							CHECKOUT_TIME='$CHECKOUT_TIME',
							CHECKOUT_LATITUDE='$CHECKOUT_LATITUDE',
							CHECKOUT_LONGITUDE='$CHECKOUT_LONGITUDE'
						WHERE ID_TOKO='$id_customer'
						AND ID_USER='$id_user'
						AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD')='$tgl_rencana' ";
						//echo $sql3;
						$cek = $this->db->query($sql3);
						if($cek){
							$status=1;
							//echo "di update 1";
						}
					}
					
					
				}
				
				if($status==1){
					array_push($data_result, array(
						'ID_KUNJUNGAN_CUSTOMER' => $id_kunjungan,
						'ID_CUSTOMER' 			=> $id_customer,
						'TGL_RENCANA_KUNJUNGAN' => $tgl_rencana,
						'KETERANGAN' 			=> $keterangan,
						'CHECKIN_LATITUDE' 		=> $CHECKIN_LATITUDE,
						'CHECKIN_LONGITUDE' 	=> $CHECKIN_LONGITUDE,
						'CHECKOUT_LATITUDE'		=> $CHECKOUT_LATITUDE,
						'CHECKOUT_LONGITUDE'	=> $CHECKOUT_LONGITUDE,
						'CHECKIN_TIME' 			=> $CHECKIN_TIME,
						'CHECKOUT_TIME'			=> $CHECKOUT_TIME,
					));
				}else if($status==2){
					array_push($data_result, $result_not_change);
				}					
			}
			
			return $data_result;
			
			
		}
				
		private function get_id_kunjungan($id_user, $id_customer, $TGL_KUN){
			
			$sql ="
					SELECT 
					ID_KUNJUNGAN_CUSTOMER
					FROM CRMNEW_KUNJUNGAN_CUSTOMER
					WHERE ID_TOKO='$id_customer'
					AND ID_USER='$id_user'
					AND TGL_RENCANA_KUNJUNGAN='$TGL_KUN'
				";
				
			$hasil  = $this->db->query($sql)->result_array();
			
			if(count($hasil)>0){
				return $hasil[0]['ID_KUNJUNGAN_CUSTOMER'];
			}
			else {
				return null;
			}
			
		}
		
		public function kuantumToko($idDistributor = null, $month = null, $year = null, $lastMonth = null){
            $this->db_tpl = $this->load->database("marketplace", true);
            $sql = "SELECT
                        KD_TOKO,
                        TO_CHAR( TGL_KIRIM, 'MM-YYYY' ) AS BULAN,
                        SUM( QTY ) AS KUANTUM 
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        KD_DISTRIBUTOR = '$idDistributor' 
                        AND TO_CHAR( TGL_KIRIM, 'YYYY-MM' ) BETWEEN '$lastMonth' 
                        AND 'year-$month' 
                    GROUP BY
                        KD_TOKO,
                        TO_CHAR( TGL_KIRIM, 'MM-YYYY' ) 
                    ORDER BY
                        TO_CHAR( TGL_KIRIM, 'MM-YYYY' ) DESC";
            $kuantumToko = $this->db_tpl->query($sql);
            if($kuantumToko->num_rows() > 0){
                return $kuantumToko->result();
            } else {
                return false;
            }
        }
		
		public function tokoJualan($month = null, $year = null, $lastMonth = null){
            $kodeDist = $this->session->userdata("kode_dist");
            $this->db_tpl = $this->load->database("marketplace", true);
            $sql = "SELECT DISTINCT
                        KD_TOKO, NM_TOKO, NM_KECAMATAN
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        KD_DISTRIBUTOR = '$kodeDist' AND TO_CHAR(TGL_KIRIM, 'YYYY-MM') BETWEEN '$lastMonth' AND '$year-$month' AND KD_TOKO IS NOT NULL";
            $kuantumToko = $this->db_tpl->query($sql);
            if($kuantumToko->num_rows() > 0){
                return $kuantumToko->result();
            } else {
                return false;
            }
        }
		
		
		public function Get_data_resume_performance_ritail($kode_distributor, $limit, $start, $jenis_order, $order){
			
			$sql ="
				SELECT
					*
				FROM (
						SELECT 
						cc.id_customer,
						cc.kode_customer,
						cc.nama_toko,
						cc.alamat,
						cc.nama_pemilik,
						cc.noktp_pemilik,
						cc.telp_toko,
						cc.id_provinsi,
						mp.nama_provinsi,
						cc.nama_distrik,
						cc.id_area,
						ma.nama_area,
						cc.nama_kecamatan,
						cc.latitude,
						cc.longitude,
						ROWNUM AS NOMER
						FROM CRMNEW_CUSTOMER CC
						left join crmnew_m_provinsi mp on cc.id_provinsi=mp.id_provinsi
						left join crmnew_m_area ma on cc.id_area=ma.id_area
						where cc.id_distributor='$kode_distributor'
						 ";

			if($limit!=null){
				$sql .= " AND ROWNUM < '$limit' ";
			}
			
			$sql .="
					) 
			";
			
			if($start!=null){
				$sql .= " where NOMER>='$start' ";
			}
			
			if($jenis_order!=null){
				
				$order = "$jenis_order ". $order;
				$sql .= " order by  $order ";
				
			}
			
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function get_data_retail_activation($kode_distributor){
			
			$this->db = $this->load->database('Point', TRUE); 
			
			$sql ="
				SELECT
					COUNT(*) JML_AKTIF,
					PU.STATUS
				FROM M_CUSTOMER MC
				LEFT JOIN P_USER PU ON MC.KD_CUSTOMER=PU.ID_CUSTOMER
				WHERE PU.STATUS IN ( 1, 2, 4 )
				AND MC.NOMOR_DISTRIBUTOR='$kode_distributor'
				GROUP BY PU.STATUS
			";
			
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
		
		
		public function get_target_harga_jual_distributor($distributor, $tahun){
			
			$this->db = $this->load->database('crm', TRUE); 
			
			$sql ="
				SELECT
				CASE BULAN
					WHEN '1' THEN 'Jan'
					WHEN '2' THEN 'Feb'
					WHEN '3' THEN 'Mar'
					WHEN '4' THEN 'Apr'
					WHEN '5' THEN 'May'
					WHEN '6' THEN 'Jun'
					WHEN '7' THEN 'Jul'
					WHEN '8' THEN 'Aug'
					WHEN '9' THEN 'Sep'
					WHEN '10' THEN 'Oct'
					WHEN '11' THEN 'Nov'
					WHEN '12' THEN 'Dec'
				END AS label,
				ROUND(((HARGA*1.08)/1000), 0) as value
				FROM CRMNEW_TARGET_HARGA_KPI
				WHERE DELETE_MARK=0
				AND KODE_DISTRIBUTOR='0000000147'
				AND TAHUN='$tahun'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function get_target_volume_distributor($distributor, $tahun){
			$this->db2 = $this->load->database('SCM', TRUE);
			
			$sql ="
				SELECT
					CASE DATAKU.BULAN
											WHEN '01' THEN 'Jan'
											WHEN '02' THEN 'Feb'
											WHEN '03' THEN 'Mar'
											WHEN '04' THEN 'Apr'
											WHEN '05' THEN 'May'
											WHEN '06' THEN 'Jun'
											WHEN '07' THEN 'Jul'
											WHEN '08' THEN 'Aug'
											WHEN '09' THEN 'Sep'
											WHEN '10' THEN 'Oct'
											WHEN '11' THEN 'Nov'
											WHEN '12' THEN 'Dec'
										END AS label,
					DATAKU.TOTAL_TARGET AS VALUE
				FROM 
						(
							SELECT
								BULAN,
								SUM(RKAP) AS TOTAL_TARGET
							FROM M_TARGET_DISTRIBUTOR
							WHERE KD_SOLDTO='147'
							AND TAHUN='$tahun'
							GROUP BY 
								KD_SOLDTO,
								BULAN
							ORDER BY 
								BULAN
						) DATAKU
			";
			
			return $this->db2->query($sql)->result_array();
		}
		
		public function get_target_harga_beli_distributor($distributor, $tahun){
			$this->db = $this->load->database('crm', TRUE); 
			$sql ="
				SELECT
				CASE BULAN
					WHEN '1' THEN 'Jan'
					WHEN '2' THEN 'Feb'
					WHEN '3' THEN 'Mar'
					WHEN '4' THEN 'Apr'
					WHEN '5' THEN 'May'
					WHEN '6' THEN 'Jun'
					WHEN '7' THEN 'Jul'
					WHEN '8' THEN 'Aug'
					WHEN '9' THEN 'Sep'
					WHEN '10' THEN 'Oct'
					WHEN '11' THEN 'Nov'
					WHEN '12' THEN 'Dec'
				END AS label,
				ROUND((HARGA/1000), 0) as value
				FROM CRMNEW_TARGET_HARGA_KPI
				WHERE DELETE_MARK=0
				AND KODE_DISTRIBUTOR='0000000147'
				AND TAHUN='$tahun'
				
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
			
			";
			
			// exit;
			return $this->db->query($sql)->result_array();
		}
		
		public function get_data_customer($kode_distributor, $tgl_mulai, $tgl_selesai, $start, $limit, $sort, $sort_by){
			
			$this->db = $this->load->database('crm', TRUE); 
			
			$sql ="
				SELECT 
				*
				FROM 
					(
						SELECT
						C.*,
						KUNJUNGAN.JML_DIKUNJUNGI,
						ROWNUM AS BARIS
						FROM CRMNEW_CUSTOMER C
						LEFT JOIN 
									(
										SELECT 
										KC.ID_TOKO,
										SUM(1) AS JML_DIKUNJUNGI
										FROM CRMNEW_KUNJUNGAN_CUSTOMER KC
										WHERE KC.CHECKIN_TIME IS NOT NULL
										AND TO_CHAR(KC.CHECKIN_TIME, 'DD-MM-YYYY') BETWEEN '$tgl_mulai' AND '$tgl_selesai'     
										GROUP BY 
										KC.ID_TOKO
									) KUNJUNGAN ON C.ID_CUSTOMER=KUNJUNGAN.ID_TOKO
						WHERE C.ID_DISTRIBUTOR='$kode_distributor'
						AND ROWNUM <=100    
					) DATA
					
			";
			if($start!=null){
				$sql .= " WHERE DATA.BARIS >='$start' ";
			}
			if($sort_by!=null && $sort!=null){
				$sql .= " ORDER BY $sort_by $sort NULLS LAST";
			}
			//echo $sql ;
			return $this->db->query($sql)->result_array(); 
			
		}
		public function get_data_resume_sales($kode_distributor, $tahun, $bulan, $nama_sales, $jenis_order, $order){
			
			$sql ="
				SELECT 
				KC.ID_USER,
				U.NAMA AS NAMA_SALES,
				COUNT(KC.TGL_RENCANA_KUNJUNGAN) AS TOTAL_KUNJUNGAN
				FROM CRMNEW_KUNJUNGAN_CUSTOMER KC
				LEFT JOIN CRMNEW_USER_DISTRIBUTOR UD ON KC.ID_USER=UD.ID_USER
				LEFT JOIN CRMNEW_USER U ON KC.ID_USER=U.ID_USER
				WHERE KC.DELETED_MARK=0
				AND TO_CHAR(KC.TGL_RENCANA_KUNJUNGAN, 'YYYY')='$tahun'
				AND TO_CHAR(KC.TGL_RENCANA_KUNJUNGAN, 'MM')='$bulan'
				AND UD.KODE_DISTRIBUTOR='$kode_distributor'
				
			";
			if($nama_sales!=null){
				$sql .= " AND U.NAMA LIKE '%$nama_sales%' ";
			}
			
			$sql .= " GROUP BY 
						KC.ID_USER,
						U.NAMA
				";
				
			if($jenis_order!=null){
				
				if($order!=null){
					$sql .= " ORDER BY $jenis_order   $order ";
				}
				
			}
			
			return $this->db->query($sql)->result_array(); 
		}
		
		public function get_data_harga_beli_distributor($distributor, $tahun){
			
			$this->db = $this->load->database('SCM', TRUE); 
			
			$sql = "
					SELECT
						CASE HS.BULAN
							WHEN '01' THEN 'Jan'
							WHEN '02' THEN 'Feb'
							WHEN '03' THEN 'Mar'
							WHEN '04' THEN 'Apr'
							WHEN '05' THEN 'May'
							WHEN '06' THEN 'Jun'
							WHEN '07' THEN 'Jul'
							WHEN '08' THEN 'Aug'
							WHEN '09' THEN 'Sep'
							WHEN '10' THEN 'Oct'
							WHEN '11' THEN 'Nov'
							WHEN '12' THEN 'Dec'
						END AS month,
						
						--SUM(HS.KWANTUMX) AS KWANTUMX,
						--SUM(HS.HARGA) AS HARGA,
						ROUND((SUM(HS.HARGA)/SUM(HS.KWANTUMX)/1000), 0) AS value
					FROM ZREPORT_SCM_HARGA_SOLDTO HS
					WHERE HS.SOLD_TO='$distributor'
					AND HS.TAHUN='$tahun'
					GROUP BY 
						HS.BULAN
					ORDER BY HS.BULAN
					
			";
			
			return $this->db->query($sql)->result_array();
		}
		public function get_data_volume_pertahun($distributor, $tahun=null){
			
			$this->db3 = $this->load->database('3pl', TRUE);
			
			$sql ="
				SELECT
				--DATA_ALL.LABEL,
				CASE DATA_ALL.LABEL
							WHEN '01' THEN 'Jan'
							WHEN '02' THEN 'Feb'
							WHEN '03' THEN 'Mar'
							WHEN '04' THEN 'Apr'
							WHEN '05' THEN 'May'
							WHEN '06' THEN 'Jun'
							WHEN '07' THEN 'Jul'
							WHEN '08' THEN 'Aug'
							WHEN '09' THEN 'Sep'
							WHEN '10' THEN 'Oct'
							WHEN '11' THEN 'Nov'
							WHEN '12' THEN 'Dec'
						END AS month,
				ROUND(SUM(DATA_ALL.VALUE), 0) AS VALUE
				FROM 
					(
					SELECT
						DATAKU.BULAN AS LABEL,
						DATAKU.VALUE
						FROM 
							(
								
								SELECT
									DATA_HARGA_VOLUME.BULAN,
									SUM(DATA_HARGA_VOLUME.QTY_TON) AS VALUE

									FROM 
										(
											SELECT
											*
											FROM
												(
													SELECT
														TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
														TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
														SUM(JS.QTY) AS QTY_ZAK,
														(SUM(JS.QTY)/25) AS QTY_TON,
														(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
														(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
													FROM TPL_T_JUAL_DTL_SERVICE JS
													WHERE JS.DELETE_MARK=0
													AND JS.KD_DISTRIBUTOR='$distributor'
													AND JS.KD_PRODUK IN  ('10110003','10110004','121-301-0050','121-301-0050 ','121-301-0110','121-301-0110P','121-301-0180')
													AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
													AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
													GROUP BY 
														TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
														TO_CHAR(JS.TGL_KIRIM, 'MM')
													ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
												) DATA40
											UNION ALL
											SELECT
											*
											FROM 
												(
													SELECT
														TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
														TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
														SUM(JS.QTY) AS QTY_ZAK,
														(SUM(JS.QTY)/20) AS QTY_TON,
														(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
														(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/20)) HARGA_TON
													FROM TPL_T_JUAL_DTL_SERVICE JS
													WHERE JS.DELETE_MARK=0
													AND JS.KD_DISTRIBUTOR='$distributor'
													AND JS.KD_PRODUK IN  ('10110001', '10110002', '10110005', '121-301-0020','121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ')
													AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
													AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
													GROUP BY 
														TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
														TO_CHAR(JS.TGL_KIRIM, 'MM')
													ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
												) DATA50
											UNION ALL
											SELECT
											*
											FROM 
												(
													SELECT
														TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
														TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
														SUM(JS.QTY) AS QTY_ZAK,
														(SUM(JS.QTY)/25) AS QTY_TON,
														(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
														(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
													FROM TPL_T_JUAL_DTL_SERVICE JS
													WHERE JS.DELETE_MARK=0
													AND JS.KD_DISTRIBUTOR='$distributor'
													AND JS.KD_PRODUK IN  ('121-301-0240')
													AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
													AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
													GROUP BY 
														TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
														TO_CHAR(JS.TGL_KIRIM, 'MM')
													ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
												) DATAPUTIH	
											
										) DATA_HARGA_VOLUME
									GROUP BY 
										DATA_HARGA_VOLUME.BULAN
									ORDER BY DATA_HARGA_VOLUME.BULAN
								
							) DATAKU
					UNION
						SELECT
							BULAN.LABEL,
							BULAN.VALUE
						FROM 
						(
							SELECT '01' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '02' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '03' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '04' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '05' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '06' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '07' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '08' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '09' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '10' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '11' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '12' LABEL, 0 VALUE FROM DUAL    
						) BULAN
					) DATA_ALL
					GROUP BY
						DATA_ALL.LABEL
					ORDER BY DATA_ALL.LABEL
			";

			return $this->db3->query($sql)->result_array();
			
		}
		public function get_data_revenue_pertahun($distributor, $tahun=null){
			
			$this->db3 = $this->load->database('3pl', TRUE);
			
			$sql ="
				SELECT
				--DATA_ALL.LABEL,
				CASE DATA_ALL.LABEL
							WHEN '01' THEN 'Jan'
							WHEN '02' THEN 'Feb'
							WHEN '03' THEN 'Mar'
							WHEN '04' THEN 'Apr'
							WHEN '05' THEN 'May'
							WHEN '06' THEN 'Jun'
							WHEN '07' THEN 'Jul'
							WHEN '08' THEN 'Aug'
							WHEN '09' THEN 'Sep'
							WHEN '10' THEN 'Oct'
							WHEN '11' THEN 'Nov'
							WHEN '12' THEN 'Dec'
						END AS month,
				ROUND((SUM(DATA_ALL.VALUE))/1000000, 0) AS VALUE
				FROM 
					(
					SELECT
						DATAKU.BULAN AS LABEL,
						DATAKU.VALUE
						FROM 
							(
								
								SELECT
									DATA_HARGA_VOLUME.BULAN,
									SUM(DATA_HARGA_VOLUME.HARGA_TOTAL) AS VALUE

									FROM 
										(
											SELECT
											*
											FROM
												(
													SELECT
														TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
														TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
														SUM(JS.QTY) AS QTY_ZAK,
														(SUM(JS.QTY)/25) AS QTY_TON,
														(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
														(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
													FROM TPL_T_JUAL_DTL_SERVICE JS
													WHERE JS.DELETE_MARK=0
													AND JS.KD_DISTRIBUTOR='$distributor'
													AND JS.KD_PRODUK IN  ('10110003','10110004','121-301-0050','121-301-0050 ','121-301-0110','121-301-0110P','121-301-0180')
													AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
													AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
													GROUP BY 
														TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
														TO_CHAR(JS.TGL_KIRIM, 'MM')
													ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
												) DATA40
											UNION ALL
											SELECT
											*
											FROM 
												(
													SELECT
														TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
														TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
														SUM(JS.QTY) AS QTY_ZAK,
														(SUM(JS.QTY)/20) AS QTY_TON,
														(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
														(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/20)) HARGA_TON
													FROM TPL_T_JUAL_DTL_SERVICE JS
													WHERE JS.DELETE_MARK=0
													AND JS.KD_DISTRIBUTOR='$distributor'
													AND JS.KD_PRODUK IN  ('10110001', '10110002', '10110005', '121-301-0020','121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ')
													AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
													AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
													GROUP BY 
														TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
														TO_CHAR(JS.TGL_KIRIM, 'MM')
													ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
												) DATA50
											UNION ALL
											SELECT
											*
											FROM 
												(
													SELECT
														TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
														TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
														SUM(JS.QTY) AS QTY_ZAK,
														(SUM(JS.QTY)/25) AS QTY_TON,
														(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
														(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
													FROM TPL_T_JUAL_DTL_SERVICE JS
													WHERE JS.DELETE_MARK=0
													AND JS.KD_DISTRIBUTOR='$distributor'
													AND JS.KD_PRODUK IN  ('121-301-0240')
													AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
													AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
													GROUP BY 
														TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
														TO_CHAR(JS.TGL_KIRIM, 'MM')
													ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
												) DATAPUTIH	
											
										) DATA_HARGA_VOLUME
									GROUP BY 
										DATA_HARGA_VOLUME.BULAN
									ORDER BY DATA_HARGA_VOLUME.BULAN
								
							) DATAKU
					UNION
						SELECT
							BULAN.LABEL,
							BULAN.VALUE
						FROM 
						(
							SELECT '01' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '02' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '03' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '04' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '05' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '06' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '07' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '08' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '09' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '10' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '11' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '12' LABEL, 0 VALUE FROM DUAL    
						) BULAN
					) DATA_ALL
					GROUP BY
						DATA_ALL.LABEL
					ORDER BY DATA_ALL.LABEL
			";

			return $this->db3->query($sql)->result_array();
			
		}
		
		public function get_data_harga_pertahun($distributor, $tahun=null){
			
			$this->db3 = $this->load->database('3pl', TRUE);
			
			$sql ="
				SELECT
				--DATA_ALL.LABEL,
				CASE DATA_ALL.LABEL
							WHEN '01' THEN 'Jan'
							WHEN '02' THEN 'Feb'
							WHEN '03' THEN 'Mar'
							WHEN '04' THEN 'Apr'
							WHEN '05' THEN 'May'
							WHEN '06' THEN 'Jun'
							WHEN '07' THEN 'Jul'
							WHEN '08' THEN 'Aug'
							WHEN '09' THEN 'Sep'
							WHEN '10' THEN 'Oct'
							WHEN '11' THEN 'Nov'
							WHEN '12' THEN 'Dec'
						END AS month,
				ROUND((SUM(DATA_ALL.VALUE)), 0) AS VALUE
				FROM 
					(
					SELECT
						DATAKU.BULAN AS LABEL,
						DATAKU.VALUE
						FROM 
							(
								
								SELECT
									DATA_HARGA_VOLUME.BULAN,
									(SUM(DATA_HARGA_VOLUME.HARGA_TON)/COUNT(DATA_HARGA_VOLUME.BULAN)/1000) AS VALUE

									FROM 
										(
											SELECT
											*
											FROM
												(
													SELECT
														TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
														TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
														SUM(JS.QTY) AS QTY_ZAK,
														(SUM(JS.QTY)/25) AS QTY_TON,
														(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
														(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
													FROM TPL_T_JUAL_DTL_SERVICE JS
													WHERE JS.DELETE_MARK=0
													AND JS.KD_DISTRIBUTOR='$distributor'
													AND JS.KD_PRODUK IN  ('10110003','10110004','121-301-0050','121-301-0050 ','121-301-0110','121-301-0110P','121-301-0180')
													AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
													AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
													GROUP BY 
														TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
														TO_CHAR(JS.TGL_KIRIM, 'MM')
													ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
												) DATA40
											UNION ALL
											SELECT
											*
											FROM 
												(
													SELECT
														TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
														TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
														SUM(JS.QTY) AS QTY_ZAK,
														(SUM(JS.QTY)/20) AS QTY_TON,
														(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
														(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/20)) HARGA_TON
													FROM TPL_T_JUAL_DTL_SERVICE JS
													WHERE JS.DELETE_MARK=0
													AND JS.KD_DISTRIBUTOR='$distributor'
													AND JS.KD_PRODUK IN  ('10110001', '10110002', '10110005', '121-301-0020','121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ')
													AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
													AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
													GROUP BY 
														TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
														TO_CHAR(JS.TGL_KIRIM, 'MM')
													ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
												) DATA50
											
										) DATA_HARGA_VOLUME
									GROUP BY 
										DATA_HARGA_VOLUME.BULAN
									ORDER BY DATA_HARGA_VOLUME.BULAN
								
							) DATAKU
					UNION
						SELECT
							BULAN.LABEL,
							BULAN.VALUE
						FROM 
						(
							SELECT '01' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '02' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '03' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '04' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '05' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '06' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '07' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '08' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '09' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '10' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '11' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '12' LABEL, 0 VALUE FROM DUAL    
						) BULAN
					) DATA_ALL
					GROUP BY
						DATA_ALL.LABEL
					ORDER BY DATA_ALL.LABEL
			";
			
			//echo $sql;
			return $this->db3->query($sql)->result_array();
			
		}
		

		public function get_grafik_kunjungan_user($user, $tahun, $bulan){
			
			$sql ="
				SELECT
				TO_CHAR(KC.TGL_RENCANA_KUNJUNGAN, 'DD') AS name,
				COUNT(KC.ID_USER) AS value
				FROM CRMNEW_KUNJUNGAN_CUSTOMER KC
				WHERE KC.DELETED_MARK=0
				AND TO_CHAR(KC.TGL_RENCANA_KUNJUNGAN, 'YYYY')='$tahun'
				AND TO_CHAR(KC.TGL_RENCANA_KUNJUNGAN, 'MM')='$bulan'
				AND KC.ID_USER='$user'
				GROUP BY 
					KC.ID_USER,
					TO_CHAR(KC.TGL_RENCANA_KUNJUNGAN, 'DD')
				ORDER BY NAME
			";
			
			return $this->db->query($sql)->result_array();
			
			
		}
		
		
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
		

    }
?>
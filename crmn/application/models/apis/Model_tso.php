<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_tso extends CI_Model {
		
		public function get_sales($id_tso = null){
			 $sql = "
				SELECT ID_USER AS ID_SALES, NAMA FROM M_SALES_DISTRIBUTOR
				WHERE ID_TSO IS NOT NULL
			 ";
			 
			 if($id_tso != null){
				$sql .= " AND ID_TSO = '$id_tso' ";
			 }
			 $sql .= " ORDER BY NAMA ";
			 return $this->db->query($sql)->result();
		}

		// =================================================== Fauzan Start
		public function Hasil_Penilaian_Sales($id_sales, $limit){
			$sql = "
				SELECT A.NO_ID, A.NO_VISIT, A.ID_PERTANYAAN, A.ID_JAWABAN, B.ID_KUNJUNGAN_SALES, B.ID_SALES
				FROM CRMNEW_M_HASIL_PENILAIAN A
				LEFT JOIN CRMNEW_SUPERVISORY_VISIT B ON B.NO_VISIT = A.NO_VISIT
					WHERE A.DELETE_MARK = 0 
					AND B.ID_SALES = '$id_sales'
					AND ROWNUM <= '$limit'
				ORDER BY A.CREATE_AT DESC
			";
			return $this->db->query($sql)->result_array();
		}

		
		public function get_foto_supervisi_sales($id_sales, $limit){
			$sqlGet = "
				SELECT A.ID_FOTO, A.NO_VISIT, A.PATH_FOTO, TO_CHAR(A.CREATE_AT_APPS,'YYYY-MM-DD HH24:MI:SS') AS CREATE_AT_APPS
				FROM CRMNEW_FOTO_VISITING_TSO A
				LEFT JOIN CRMNEW_SUPERVISORY_VISIT B ON B.NO_VISIT = A.NO_VISIT
				WHERE 
					A.DELETE_MARK = 0 AND
					B.ID_SALES = '$id_sales' AND 
					ROWNUM <= '$limit'
				ORDER BY A.CREATE_AT DESC
			";
			$data = $this->db->query($sqlGet)->result_array();
			return $data;
		}
		// =================================================== Fauzan End
		
		
		public function get_customer($id_tso = null){
			 $sql = "
				SELECT 
					DISTINCT(KD_CUSTOMER),
					NAMA_TOKO,
					ALAMAT,
					NAMA_PROVINSI,
					NAMA_DISTRIK,
					NAMA_AREA
				FROM R_REPORT_TOKO_SALES
				WHERE ID_TSO IS NOT NULL
			 ";
			 
			 if($id_tso != null){
				$sql .= " AND ID_TSO = '$id_tso' ";
			 }
			 $sql .= " ORDER BY NAMA_TOKO ";
			 return $this->db->query($sql)->result();
		}
		
		public function listKunjunganSales($id_tso, $tanggal = null){
			$sqladd = '';
			$tanggalNow = date('Y-m-d');	//;date('d-m-Y');
			if($tanggal != null){
				$sqladd = " AND TO_DATE(VKHS.TGL_RENCANA_KUNJUNGAN,'YYYY-MM-DD') = '$tanggal' ";
			} else {
				$sqladd = " AND TO_CHAR(VKHS.TGL_RENCANA_KUNJUNGAN,'YYYY-MM-DD') = '$tanggalNow' ";
			}
			
			$sql = "
				SELECT 
					VKHS.ID_KUNJUNGAN_CUSTOMER,
					VKHS.ID_USER,
					VKHS.KODE_DISTRIBUTOR,
					VKHS.NAMA_DISTRIBUTOR,
					VKHS.NAMA_USER,
					VKHS.ID_TOKO,
					VKHS.NAMA_TOKO,
					VKHS.ALAMAT,
					VKHS.TELP_TOKO,
					VKHS.NAMA_PEMILIK,
					VKHS.NAMA_KECAMATAN,
					VKHS.NAMA_DISTRIK,
					CSV.ID_KUNJUNGAN_SALES,
					CSV.APPROVAL_SALES, 
					TO_CHAR(VKHS.TGL_RENCANA_KUNJUNGAN,'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN,
					VKHS.CHECKIN_TIME
				FROM V_KUNJUNGAN_HARIAN_SALES VKHS 
					LEFT JOIN CRMNEW_SUPERVISORY_VISIT CSV
						ON CSV.ID_KUNJUNGAN_SALES = VKHS.ID_KUNJUNGAN_CUSTOMER
				WHERE 
					VKHS.ID_USER IN
						(SELECT ID_SALES FROM HIRARCKY_GSM_TO_DISTRIBUTOR WHERE ID_SO IS NOT NULL AND ID_SO = '$id_tso')
					$sqladd
			";
			//print_r($sql);
			//exit();
			return $this->db->query($sql)->result_array();
		}
		
		public function listVisitSales($id_tso, $tanggalStart = null, $tanggalEnd = null){
			$sqladd = '';
			$tanggalNow = date('Y-m-d');	//;date('d-m-Y');
			if($tanggalStart != null && $tanggalEnd != null){
				$sqladd = " AND TO_DATE('$tanggalStart','YYYY-MM-DD') <= trunc(VKHS.TGL_RENCANA_KUNJUNGAN)
							AND TO_DATE('$tanggalEnd','YYYY-MM-DD') >= trunc(VKHS.TGL_RENCANA_KUNJUNGAN ) ";
			} else {
				$sqladd = " AND TO_CHAR(VKHS.TGL_RENCANA_KUNJUNGAN,'YYYY-MM-DD') = '$tanggalNow' ";
			}
			
			$sql = "
				SELECT 
					VKHS.ID_KUNJUNGAN_CUSTOMER,
					VKHS.ID_USER,
					VKHS.KODE_DISTRIBUTOR,
					VKHS.NAMA_DISTRIBUTOR,
					VKHS.NAMA_USER,
					VKHS.ID_TOKO,
					VKHS.NAMA_TOKO,
					VKHS.ALAMAT,
					VKHS.TELP_TOKO,
					VKHS.NAMA_PEMILIK,
					VKHS.NAMA_KECAMATAN,
					VKHS.NAMA_DISTRIK,
					VKHS.ALASAN_KUNJUNGAN,
					VKHS.ORDER_SEMEN,
					VKHS.FLAG_UNPLANNED,
					VKHS.FLAG_TIDAK_ORDER,
					CSV.ID_KUNJUNGAN_SALES,
					CSV.APPROVAL_SALES, 
					TO_CHAR(VKHS.TGL_RENCANA_KUNJUNGAN,'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN,
					VKHS.CHECKIN_TIME
				FROM V_KUNJUNGAN_HARIAN_SALES VKHS 
					LEFT JOIN CRMNEW_SUPERVISORY_VISIT CSV
						ON CSV.ID_KUNJUNGAN_SALES = VKHS.ID_KUNJUNGAN_CUSTOMER
				WHERE 
					VKHS.ID_USER IN
						(SELECT ID_SALES FROM HIRARCKY_GSM_TO_DISTRIBUTOR WHERE ID_SO IS NOT NULL AND ID_SO = '$id_tso')
					$sqladd
			";
			//print_r($sql);
			//exit();
			return $this->db->query($sql)->result_array();
		}
		
		public function Simpan_visiting($id_tso, $data_in, $req = null){
			//print_r($data_in);
			//exit();
			
			$data = array();
			$k_sales = '';
			$baris = 0;
			$data_get = array();
			foreach($data_in as $p){
				$date_TGL_VISIT = date_create($p['TGL_VISIT_TSO']);
				$dating_TGL_VISIT = date_format($date_TGL_VISIT,"d-M-y h.s.i");
				
				$date_APPROVAL_AT = date_create($p['APPROVAL_AT_SALES']);
				$dating_APPROVAL_AT = date_format($date_APPROVAL_AT,"d-M-y h.s.i");
				
				$isi = array(
					'ID_KUNJUNGAN_SALES'		=> $p['ID_KUNJUNGAN_SALES'],
					'ID_TSO'					=> $id_tso,
					'ID_SALES'					=> $p['ID_SALES'],
					'ID_CUSTOMER'				=> $p['ID_CUSTOMER'],
					'KD_DISTRIBUTOR'			=> $p['KD_DISTRIBUTOR'],
					'TGL_VISIT'					=> $dating_TGL_VISIT,
					'CREATE_BY'					=> $id_tso,
					'CREATE_AT'					=> date('d-M-y h.s.i A'),
					'DELETE_MARK'				=> 0,
					'KESIMPULAN'				=> $p['KESIMPULAN'],
					'APPROVAL_SALES'			=> $p['APPROVAL_SALES'],
					'APPROVAL_AT'				=> $dating_APPROVAL_AT
				);
				array_push($data, $isi);
				
				if($baris < (count($data_in)-1)){
					$k_sales = $k_sales.$p['ID_KUNJUNGAN_SALES'].",";
				} else {
					$k_sales = $k_sales.$p['ID_KUNJUNGAN_SALES'];
				}
			
			$baris++;
			}
			
			// print_r($k_sales);
			// exit();
			
			$input = $this->db->insert_batch('CRMNEW_SUPERVISORY_VISIT',$data);
			
			if($input){
				$sql = "
					SELECT NO_VISIT, 
					TO_CHAR(TGL_VISIT,'YYYY-MM-DD HH24:MI:SS') AS TGL_VISIT_TSO,
					ID_SALES, APPROVAL_SALES, 
					TO_CHAR(APPROVAL_AT,'YYYY-MM-DD HH24:MI:SS') AS APPROVAL_AT_SALES, 
					ID_CUSTOMER, KD_DISTRIBUTOR, ID_TSO, KESIMPULAN, ID_KUNJUNGAN_SALES AS ID_KUNJUNGAN_CUSTOMER
					FROM CRMNEW_SUPERVISORY_VISIT
						WHERE 
						DELETE_MARK = 0 AND ID_TSO = '$id_tso' AND ID_KUNJUNGAN_SALES IN ($k_sales)
				";
				if($req != null){
					$data_get = $this->db->query($sql)->row();
				} else {
					$data_get = $this->db->query($sql)->result_array();
				}
			}
			return $data_get;
		}
		
		public function Update_visiting($id_tso, $data_in){
			$data =array();
			$k_id = '';
			$baris = 0;
			$data_get = array();
			foreach($data_in as $p){
				
				$no_visit = $p['NO_VISIT'];
				$id_kc = $p['ID_KUNJUNGAN_CUSTOMER'];
				$id_sales = $p['ID_SALES'];
				$id_customer = $p['ID_CUSTOMER'];
				$kd_distributor = $p['KD_DISTRIBUTOR'];
				//$tgl_visit_tso = $p['TGL_VISIT_TSO'];
				$kesimpulan = $p['KESIMPULAN'];
				$approfal_sales = $p['APPROVAL_SALES'];
				//$aprofal_sales_at = $p['APPROVAL_AT_SALES'];
				
				$date_TGL_VISIT = date_create($p['TGL_VISIT_TSO']);
				$dating_TGL_VISIT = date_format($date_TGL_VISIT,"d-M-y h.s.i");
				
				$date_APPROVAL_AT = date_create($p['APPROVAL_AT_SALES']);
				$dating_APPROVAL_AT = date_format($date_APPROVAL_AT,"d-M-y h.s.i");
				
				$sql = "
					UPDATE CRMNEW_SUPERVISORY_VISIT
					SET 
						
						ID_KUNJUNGAN_SALES	= '$id_kc',
						ID_TSO				= '$id_tso',
						ID_SALES			= '$id_sales',
						ID_CUSTOMER			= '$id_customer',
						KD_DISTRIBUTOR		= '$kd_distributor',
						TGL_VISIT			= '$dating_TGL_VISIT',
						KESIMPULAN			= '$kesimpulan',
						APPROVAL_SALES		= '$approfal_sales',
						APPROVAL_AT			= '$dating_APPROVAL_AT',
						
						UPDATE_BY = '$id_tso',
						UPDATE_AT = SYSDATE
					WHERE NO_VISIT = '$no_visit'
				";
				$hasil = $this->db->query($sql);
				
				if($hasil){
					if($baris < (count($data_in)-1)){
						$k_id = $k_id.$p['NO_VISIT'].",";
					} else {
						$k_id = $k_id.$p['NO_VISIT'];
					}
				}
				
			$baris++;
			}
			
			//if($hasil){
				$sql = "
					SELECT NO_VISIT, 
					TO_CHAR(TGL_VISIT,'YYYY-MM-DD HH24:MI:SS') AS TGL_VISIT_TSO,
					ID_SALES, APPROVAL_SALES, 
					TO_CHAR(APPROVAL_AT,'YYYY-MM-DD HH24:MI:SS') AS APPROVAL_AT_SALES, 
					ID_CUSTOMER, KD_DISTRIBUTOR, ID_TSO, KESIMPULAN, ID_KUNJUNGAN_SALES AS ID_KUNJUNGAN_CUSTOMER
					FROM CRMNEW_SUPERVISORY_VISIT
						WHERE 
						DELETE_MARK = 0 AND ID_TSO = '$id_tso' AND NO_VISIT IN ($k_id)
				";
				$data_get = $this->db->query($sql)->result_array();
			//}
			return $data_get;
		}
		
		public function List_pertanyaan(){
			$sql = "
				SELECT 
					CMPS.ID_PERTANYAAN,
					CMPS.NM_PERTANYAAN, 
					CMJP.ID_JENIS_PENILAIAN,
					CMJP.NM_JENIS_PENILAIAN
				FROM CRMNEW_M_PENILAIAN_SALES CMPS
					LEFT JOIN CRMNEW_M_JENIS_PENILAIAN CMJP
						ON CMJP.ID_JENIS_PENILAIAN = CMPS.ID_JENIS_PENILAIAN AND CMJP.DELETE_MARK = 0
				WHERE CMPS.DELETE_MARK = 0
				ORDER BY CMPS.ID_PERTANYAAN
			 ";
			 return $this->db->query($sql)->result_array();
		}
		
		public function List_jawaban($id_pertanyaan){
			$sql = "
				SELECT  
					CMOJ.ID_JAWABAN, 
					CMOJ.OPSIONAL AS OPSI,
					CMOJ.POINT 
				FROM CRMNEW_M_OPSIONAL_JAWABAN CMOJ
					LEFT JOIN CRMNEW_M_PENILAIAN_SALES CMPS
						ON CMPS.ID_PERTANYAAN = CMOJ.ID_PERTANYAAN AND CMPS.DELETE_MARK = 0
				WHERE CMOJ.ID_PERTANYAAN = '$id_pertanyaan' AND CMOJ.DELETE_MARK = 0
                ORDER BY CMOJ.POINT DESC
			 ";
			 return $this->db->query($sql)->result_array();
		}
		
		public function Simpan_penilaian($id_tso, $data_in){
			$data =array();
			$k_sales = '';
			$baris = 0;
			$data_get = array();
			foreach($data_in as $p){
				$isi = array(
					'NO_VISIT'				=> $p['NO_VISIT'],
					'ID_PERTANYAAN'			=> $p['ID_PERTANYAAN'],
					'ID_JAWABAN'			=> $p['ID_JAWABAN'],
					//'ID_KUNJUNGAN_CUSTOMER'	=> $p['ID_KUNJUNGAN_CUSTOMER'],
					'CREATE_BY'				=> $id_tso,
					'CREATE_AT'				=> date('d-M-y h.s.i A'),
					'DELETE_MARK'			=> 0 
				);
				array_push($data, $isi);
				
				if($baris < (count($data_in)-1)){
					$k_sales = $k_sales.$p['NO_VISIT'].",";
				} else {
					$k_sales = $k_sales.$p['NO_VISIT'];
				}
			
			$baris++;
			}
			
			$hasil = $this->db->insert_batch('CRMNEW_M_HASIL_PENILAIAN',$data);
			//ID_KUNJUNGAN_CUSTOMER
			if($hasil){
				$sql = "
					SELECT NO_ID, NO_VISIT, ID_PERTANYAAN, ID_JAWABAN
				FROM CRMNEW_M_HASIL_PENILAIAN
					WHERE 
					DELETE_MARK = 0 AND CREATE_BY = '$id_tso' AND NO_VISIT IN ($k_sales)
				";
				$data_get = $this->db->query($sql)->result_array();
			}
			return $data_get;
		}
		
		public function Update_penilaian($id_tso, $data_in){
			$data =array();
			$k_id = '';
			$baris = 0;
			$data_get = array();
			foreach($data_in as $p){
				
				$no_id = $p['NO_ID'];
				$no_visit = $p['NO_VISIT'];
				$id_pertanyaan = $p['ID_PERTANYAAN'];
				$id_jawaban = $p['ID_JAWABAN'];
				//$id_kunjungan = $p['ID_KUNJUNGAN_CUSTOMER']; ID_KUNJUNGAN_CUSTOMER = '$id_kunjungan',
				
				$sql = "
					UPDATE CRMNEW_M_HASIL_PENILAIAN
					SET 
						NO_VISIT = '$no_visit',
						
						ID_PERTANYAAN = '$id_pertanyaan',
						ID_JAWABAN = '$id_jawaban',
						UPDATE_BY = '$id_tso',
						UPDATE_AT = SYSDATE
					WHERE NO_ID = '$no_id'
				";
				$hasil = $this->db->query($sql);
				
				if($hasil){
					if($baris < (count($data_in)-1)){
						$k_id = $k_id.$p['NO_ID'].",";
					} else {
						$k_id = $k_id.$p['NO_ID'];
					}
				}
				
			$baris++;
			}
			
			//if($hasil){
				$sql = "
					SELECT NO_ID, NO_VISIT, ID_PERTANYAAN, ID_JAWABAN
				FROM CRMNEW_M_HASIL_PENILAIAN
					WHERE 
					DELETE_MARK = 0 AND CREATE_BY = '$id_tso' AND NO_ID IN ($k_id)
				";
				$data_get = $this->db->query($sql)->result_array();
			//}
			return $data_get;
		}
		
		public function Simpan_kesimpulan($data_in){
			$baris = 0;
			foreach($data_in as $p){
				$no_visit   = $p['NO_VISIT'];
				$kesimpulan = $p['KESIMPULAN'];
				$id_kunjungan = $p['ID_KUNJUNGAN_SALES'];
				
				$sqlUp = "
					UPDATE CRMNEW_SUPERVISORY_VISIT
					SET
						KESIMPULAN = '$kesimpulan'
					WHERE ID_KUNJUNGAN_SALES = '$id_kunjungan'
				";
				
				$setSimpulan = $this->db->query($sqlUp);
				
				if($setSimpulan){
					$baris++;
				}
			}
			return $baris;
		}
		
		//public function Simpan_foto($id_tso, $id_kunjungan, $no_visit, $path_file){
		public function Simpan_foto($id_tso, $no_visit, $path_file, $createAtApps){
			//$AtApps	= ;
			$createAtApps_set = date_format(date_create($createAtApps),"d-M-y h.s.i");
			
			$sqlIn = "
				INSERT INTO CRMNEW_FOTO_VISITING_TSO
				(NO_VISIT, PATH_FOTO, CREATE_BY, CREATE_AT, DELETE_MARK, CREATE_AT_APPS)
				VALUES
				('$no_visit', '$path_file', '$id_tso', SYSDATE, 0, to_date('$createAtApps', 'YYYY-MM-DD HH24:MI:SS'))
			";
			$this->db->query($sqlIn);
			$sqlGet = "
				SELECT ID_FOTO, NO_VISIT, PATH_FOTO, TO_CHAR(CREATE_AT_APPS,'YYYY-MM-DD HH24:MI:SS') AS CREATE_AT_APPS
				FROM CRMNEW_FOTO_VISITING_TSO
					WHERE 
					NO_VISIT = '$no_visit' AND 
					PATH_FOTO = '$path_file'
			";
			$data = $this->db->query($sqlGet)->result_array();
			return $data;
		}
		
		public function get_foto_survey_byPath($no_visit, $path_file){
			$sqlGet = "
				SELECT ID_FOTO, NO_VISIT, PATH_FOTO, TO_CHAR(CREATE_AT_APPS,'YYYY-MM-DD HH24:MI:SS') AS CREATE_AT_APPS
				FROM CRMNEW_FOTO_VISITING_TSO
				WHERE 
					DELETE_MARK = 0 AND
					NO_VISIT = '$no_visit' AND 
					PATH_FOTO = '$path_file'
			";
			$data = $this->db->query($sqlGet)->result_array();
			return $data;
		}
		
		public function get_foto_survey($id_tso, $limit){
			$sqlGet = "
				SELECT ID_FOTO, NO_VISIT, PATH_FOTO, TO_CHAR(CREATE_AT_APPS,'YYYY-MM-DD HH24:MI:SS') AS CREATE_AT_APPS
				FROM CRMNEW_FOTO_VISITING_TSO
				WHERE 
					DELETE_MARK = 0 AND
					CREATE_BY = '$id_tso' AND 
					ROWNUM <= '$limit'
				ORDER BY CREATE_AT DESC
			";
			$data = $this->db->query($sqlGet)->result_array();
			return $data;
		}
		
		public function get_foto_survey_inId($datas_idFoto){
			$sqlGet = "
				SELECT ID_FOTO, NO_VISIT, PATH_FOTO, TO_CHAR(CREATE_AT_APPS,'YYYY-MM-DD HH24:MI:SS') AS CREATE_AT_APPS
				FROM CRMNEW_FOTO_VISITING_TSO
				WHERE 
					ID_FOTO IN ($datas_idFoto)
			";
			$data = $this->db->query($sqlGet)->result_array();
			return $data;
		}
		
		public function Del_foto_survey($id_tso, $datas_idFoto){
			$balikan = 0;
			$sqlDel = "
				UPDATE CRMNEW_FOTO_VISITING_TSO
				SET
					DELETE_MARK = 1
				WHERE CREATE_BY = '$id_tso' AND ID_FOTO IN ($datas_idFoto)
			";
			$eksekusi = $this->db->query($sqlDel);
			
			if($eksekusi){
				$balikan = 1;
			} else {
				$balikan = 0;
			}
			return $balikan;
		}
		
		public function Report_visit($id_tso, $tanggal){
			$sql = "
				SELECT 
					VKHS.ID_KUNJUNGAN_CUSTOMER,
					VKHS.ID_USER,
					VKHS.KODE_DISTRIBUTOR,
					VKHS.NAMA_DISTRIBUTOR,
					VKHS.NAMA_USER,
					VKHS.ID_TOKO,
					VKHS.NAMA_TOKO,
					VKHS.ALAMAT,
					VKHS.TELP_TOKO,
					VKHS.NAMA_PEMILIK,
					VKHS.NAMA_KECAMATAN,
					VKHS.NAMA_DISTRIK,
					CSV.ID_KUNJUNGAN_SALES,
					CSV.NO_VISIT,
					CSV.APPROVAL_SALES, 
					TO_CHAR(CSV.TGL_VISIT,'DD-MM-YYYY') AS TGL_KUNJUNGAN_TSO,
                    CSV.KESIMPULAN
				FROM V_KUNJUNGAN_HARIAN_SALES VKHS 
					JOIN CRMNEW_SUPERVISORY_VISIT CSV
						ON CSV.ID_KUNJUNGAN_SALES = VKHS.ID_KUNJUNGAN_CUSTOMER
				WHERE 
					CSV.ID_TSO = '$id_tso'
			";
			if($tanggal != null){
				$sql .= " AND  TO_CHAR(CSV.TGL_VISIT,'DD-MM-YYYY') = '$tanggal' ";
			} 
			return $this->db->query($sql)->result_array();
		}
		
		public function List_penilaian($id_kunjungan){
			$sql = "
				SELECT 
					CMPS.ID_JENIS_PENILAIAN,
					CMJP.NM_JENIS_PENILAIAN,
					CMHP.ID_PERTANYAAN,
					CMPS.NM_PERTANYAAN,
					CMHP.ID_JAWABAN,
					CMOJ.OPSIONAL,
					CMOJ.POINT
				FROM CRMNEW_M_HASIL_PENILAIAN CMHP
					LEFT JOIN CRMNEW_M_PENILAIAN_SALES CMPS
						ON CMHP.ID_PERTANYAAN = CMPS.ID_PERTANYAAN
					LEFT JOIN CRMNEW_M_JENIS_PENILAIAN CMJP
						ON CMPS.ID_JENIS_PENILAIAN = CMJP.ID_JENIS_PENILAIAN
					LEFT JOIN CRMNEW_M_OPSIONAL_JAWABAN CMOJ
						ON CMHP.ID_JAWABAN = CMOJ.ID_JAWABAN
				WHERE CMHP.ID_KUNJUNGAN_CUSTOMER = '$id_kunjungan'
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function List_foto($id_kunjungan){
			$sql = " 
				SELECT NO_VISIT, PATH_FOTO, ID_KUNJUNGAN_CUSTOMER
				FROM CRMNEW_FOTO_VISITING_TSO
					WHERE 
					ID_KUNJUNGAN_CUSTOMER = '$id_kunjungan'
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function get_sales_tso($id_tso = null){
			 $sql = "
				SELECT DISTINCT(ID_SALES),
					NAMA_SALES,
					KODE_DISTRIBUTOR,
					NAMA_DISTRIBUTOR 
				FROM HIRARCKY_GSM_TO_DISTRIBUTOR
				WHERE ID_SO IS NOT NULL
			 ";
			 
			 if($id_tso != null){
				$sql .= " AND ID_SO = '$id_tso' ";
			 }
			 $sql .= " ORDER BY NAMA_SALES ";
			 return $this->db->query($sql)->result();
		}
		
		public function get_toko_tso($id_tso, $start = null, $limit = null){ 
			$sql = "
			SELECT
				*
				FROM (
				SELECT 
					ROWNUM AS BARIS,
					MTDS.ID_CUSTOMER, 
					MTDS.ID_CUSTOMER AS KODE_CUSTOMER,
					MTDS.NAMA_TOKO,
					VDTC.TELP_TOKO,					
					VDTC.ALAMAT,
					VDTC.KODE_POS,
					VDTC.NAMA_PEMILIK, 
					VDTC.TELP_PEMILIK,
					VDTC.NOKTP_PEMILIK,
					TO_CHAR(VDTC.TGL_LAHIR, 'YYYY-MM-DD') AS TGL_LAHIR,
					VDTC.ID_KECAMATAN, 
					VDTC.NAMA_KECAMATAN, 
					VDTC.ID_DISTRIK, 
					VDTC.NAMA_DISTRIK, 
					VDTC.ID_AREA, 
					VDTC.NAMA_AREA, 
					VDTC.ID_PROVINSI, 
					VDTC.NAMA_PROVINSI, 
					VDTC.NEW_REGION AS REGION, 
					VDTC.LONGITUDE, 
					VDTC.LATITUDE, 
					VDTC.KOORDINAT_LOCK, 
					VDTC.KAPASITAS_ZAK,
					VDTC.KAPASITAS_TON,		
					VDTC.KAPASITAS_JUAL,
					VDTC.KAPASITAS_TOKO,
					VDTC.STATUS_TOKO,
					VDTC.GROUP_CUSTOMER,
					VDTC.KETERANGAN,
					MTDS.ID_DISTRIBUTOR,
					MTDS.NAMA_DISTRIBUTOR,
					MTDS.ID_SALES,
					MTDS.USERNAME
				FROM MAPPING_TOKO_DIST_SALES MTDS
					LEFT JOIN VIEW_DATA_TOKO_CUSTOMER VDTC
						ON VDTC.ID_CUSTOMER = MTDS.ID_CUSTOMER 
				WHERE MTDS.ID_SALES IN (SELECT ID_SALES FROM HIRARCKY_GSM_TO_DISTRIBUTOR WHERE ID_SO IS NOT NULL AND ID_SO = '$id_tso') 
				ORDER BY  MTDS.NAMA_DISTRIBUTOR, MTDS.NAMA_TOKO
			";
			
			$sql .= " ) ";
			
			if($start!=null && $limit!=null){
				$limit=$start+$limit;
				$sql .=" WHERE BARIS > $start AND BARIS <= $limit ";
			} else if($start==null && $limit!=null){
				$start=0;
				$limit=$start+$limit;
				$sql .=" WHERE BARIS > $start AND BARIS <= $limit ";
			} else if($start!=null && $limit==null){
				$sql .=" WHERE BARIS > $start ";
			} else {
				
			}
			
			return $this->db->query($sql)->result();
		}
		
		public function Opsional_Jawaban_Survey_Sales(){
			$sql = "
				SELECT ID_JAWABAN, OPSIONAL, POINT, ID_PERTANYAAN
				FROM CRMNEW_M_OPSIONAL_JAWABAN
					WHERE 
					DELETE_MARK = 0
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function Pertanyaan_Survey_Sales(){
			$sql = "
				SELECT ID_PERTANYAAN, NM_PERTANYAAN, ID_JENIS_PENILAIAN
				FROM CRMNEW_M_PENILAIAN_SALES
					WHERE 
					DELETE_MARK = 0
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function Jenis_Pertanyaan_Survey_Sales(){
			$sql = "
				SELECT ID_JENIS_PENILAIAN, NM_JENIS_PENILAIAN
				FROM CRMNEW_M_JENIS_PENILAIAN
					WHERE 
					DELETE_MARK = 0
				ORDER BY NM_JENIS_PENILAIAN
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function Hasil_Penilaian_Survey_Sales($id_tso){
			$sql = "
				SELECT NO_ID, NO_VISIT, ID_PERTANYAAN, ID_JAWABAN, ID_KUNJUNGAN_CUSTOMER
				FROM CRMNEW_M_HASIL_PENILAIAN
					WHERE 
					DELETE_MARK = 0 AND CREATE_BY = '$id_tso'
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function So_Visit($id_tso){
			$sql = "
				SELECT NO_VISIT, 
				TO_CHAR(TGL_VISIT,'YYYY-MM-DD HH24:MI:SS') AS TGL_VISIT_TSO,
				ID_SALES, APPROVAL_SALES, 
				TO_CHAR(APPROVAL_AT,'YYYY-MM-DD HH24:MI:SS') AS APPROVAL_AT_SALES, 
				ID_CUSTOMER, KD_DISTRIBUTOR, ID_TSO, KESIMPULAN, ID_KUNJUNGAN_SALES AS ID_KUNJUNGAN_CUSTOMER
				FROM CRMNEW_SUPERVISORY_VISIT
					WHERE 
					DELETE_MARK = 0 AND ID_TSO = '$id_tso'
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function Hasil_Penilaian($id_tso, $limit){
			$sql = "
				SELECT NO_ID, NO_VISIT, ID_PERTANYAAN, ID_JAWABAN, ID_KUNJUNGAN_CUSTOMER
				FROM CRMNEW_M_HASIL_PENILAIAN
					WHERE DELETE_MARK = 0 
					AND CREATE_BY = '$id_tso'
					AND ROWNUM <= '$limit'
				ORDER BY CREATE_AT DESC
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function Coaching_Visit($id_tso, $limit){
			$sql = "
				SELECT NO_VISIT, 
				TO_CHAR(TGL_VISIT,'YYYY-MM-DD HH24:MI:SS') AS TGL_VISIT_TSO,
				ID_SALES, APPROVAL_SALES, 
				TO_CHAR(APPROVAL_AT,'YYYY-MM-DD HH24:MI:SS') AS APPROVAL_AT_SALES, 
				ID_CUSTOMER, KD_DISTRIBUTOR, ID_TSO, KESIMPULAN, ID_KUNJUNGAN_SALES AS ID_KUNJUNGAN_CUSTOMER
				FROM CRMNEW_SUPERVISORY_VISIT
					WHERE DELETE_MARK = 0 
					AND ID_TSO = '$id_tso'
					AND ROWNUM <= '$limit'
				ORDER BY CREATE_AT DESC 
			";
				
			return $this->db->query($sql)->result_array();
		}
		public function Coaching_Visit_sales($id_sales, $limit){
			$sql = "
				SELECT NO_VISIT, 
				TO_CHAR(A.TGL_VISIT,'YYYY-MM-DD HH24:MI:SS') AS TGL_VISIT_TSO,
				A.ID_SALES, A.APPROVAL_SALES, 
				TO_CHAR(A.APPROVAL_AT,'YYYY-MM-DD HH24:MI:SS') AS APPROVAL_AT_SALES, 
				A.ID_CUSTOMER, A.KD_DISTRIBUTOR, A.ID_TSO, A.KESIMPULAN, A.ID_KUNJUNGAN_SALES AS ID_KUNJUNGAN_CUSTOMER,
                B.SEQUENCE,
                B.ALASAN_KUNJUNGAN,
                B.ORDER_SEMEN,
                B.FLAG_UNPLANNED,
                B.FLAG_TIDAK_ORDER
				FROM CRMNEW_SUPERVISORY_VISIT A
                LEFT JOIN CRMNEW_KUNJUNGAN_CUSTOMER B ON A.ID_KUNJUNGAN_SALES=B.ID_KUNJUNGAN_CUSTOMER
					WHERE A.DELETE_MARK = 0 
					AND A.ID_SALES='$id_sales'
					AND ROWNUM <= '$limit'
				ORDER BY CREATE_AT DESC 
			";
				
			return $this->db->query($sql)->result_array();
		}
		
	}
	
?>
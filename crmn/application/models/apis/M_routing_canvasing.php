<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class M_routing_canvasing extends CI_Model {

        public function dataCanvassing($start, $limit, $idDistributor, $startDate, $endDate, $idProvinsi = null, $idSales = null, $namaToko = null, $jenisOrder = null, $order = null){

            if(isset($jenisOrder) || isset($order)){
                if($jenisOrder != "" || $order == ""){
                    $this->db->order_by(strtoupper($jenisOrder), $order);
                }
            }

            if(isset($idProvinsi)){
                if($idProvinsi != ""){
                    $this->db->where("CRMNEW_CUSTOMER.ID_PROVINSI", $idProvinsi);
                }
            }

            if(isset($idSales)){
                if($idSales != ""){
                    $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER", $idSales);
                }
            }

            if(isset($namaToko)){
                if($namaToko != ""){
                    $this->db->like("CRMNEW_CUSTOMER.NAMA_TOKO", $namaToko, "both");
                }
            }

            $this->db->select("CRMNEW_USER.ID_USER, CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER, CRMNEW_USER.NAMA AS SURVEYOR, CRMNEW_JENIS_USER.JENIS_USER AS POSISI, CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO AS KODE_CUSTOMER, TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'YYYY-MM-DD HH24:MI:SS') AS TGL_KUNJUNGAN, TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKOUT_TIME, 'YYYY-MM-DD HH24:MI:SS') AS CHECKOUT_TIME, CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_CUSTOMER.ALAMAT, CRMNEW_CUSTOMER.NAMA_PEMILIK, CRMNEW_CUSTOMER.NOKTP_PEMILIK, CRMNEW_CUSTOMER.KAPASITAS_TOKO, CRMNEW_CUSTOMER.TELP_TOKO, CRMNEW_CUSTOMER.TELP_PEMILIK, CRMNEW_M_PROVINSI.NAMA_PROVINSI, CRMNEW_CUSTOMER.NAMA_DISTRIK, CRMNEW_CUSTOMER.ID_AREA AS NAMA_AREA, CRMNEW_CUSTOMER.NAMA_KECAMATAN, TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN, (TO_DATE(TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKOUT_TIME, 'DD-MM-YYYY HH24:MI:SS'), 'DD-MM-YYYY HH24:MI:SS') - TO_DATE(TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'DD-MM-YYYY HH24:MI:SS'),'DD-MM-YYYY HH24:MI:SS'))*(24*60) AS DURASI_KUNJUNGAN, CRMNEW_KUNJUNGAN_CUSTOMER.KETERANGAN AS KETERANGAN_KUNJUNGAN, ASSIGN.NAMA AS ASIGN");
            $this->db->from("CRMNEW_KUNJUNGAN_CUSTOMER");
            $this->db->join("CRMNEW_USER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER");
            $this->db->join("CRMNEW_JENIS_USER", "CRMNEW_USER.ID_JENIS_USER = CRMNEW_JENIS_USER.ID_JENIS_USER");
            $this->db->join("CRMNEW_CUSTOMER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO = CRMNEW_CUSTOMER.ID_CUSTOMER");
            $this->db->join("CRMNEW_M_PROVINSI", "CRMNEW_CUSTOMER.ID_PROVINSI = CRMNEW_M_PROVINSI.ID_PROVINSI", "LEFT");
            $this->db->join("CRMNEW_USER ASSIGN", "CRMNEW_KUNJUNGAN_CUSTOMER.CREATED_BY = ASSIGN.ID_USER", "LEFT");
            $this->db->limit($limit, $start);
            $this->db->where("CRMNEW_CUSTOMER.ID_DISTRIBUTOR", $idDistributor);
            $this->db->where("TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') BETWEEN '$startDate' AND '$endDate'");

            $canvasing = $this->db->get();
            if($canvasing->num_rows() > 0){
                return $canvasing->result();
            } else {
                return false;
            }
        }
		
		public function salesDistributor($idDistributor, $start, $limit, $namaSales = null){
			
			if(isset($namaSales)){
                if($namaSales != ""){
                    $this->db->like("LOWER(CRMNEW_USER.NAMA)", $namaSales, "both");
                }
            }
			
            $this->db->select("CRMNEW_USER.ID_USER AS ID, UPPER(CRMNEW_USER.NAMA) AS NAMA");
            $this->db->from("CRMNEW_USER");
            $this->db->join("CRMNEW_USER_DISTRIBUTOR", "CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER");
            $this->db->limit($limit, $start);
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR", $idDistributor);
            $this->db->where_in("CRMNEW_USER.ID_JENIS_USER", array("1003", "1007"));
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", "0");
			
            $jenisUser = $this->db->get();
            if($jenisUser){
                return $jenisUser->result();
            } else {
                return false;
            }
        }

        public function listCanvasing($idDistributor = null, $startDate = null, $endDate = null, $posisi = null, $provinsi = null, $sales = null){
            $idRegion = $this->session->userdata('id_region');
            if(isset($posisi)){
                if($posisi != ""){
                    $this->db->where("CRMNEW_JENIS_USER.ID_JENIS_USER", $posisi);
                }
            }

            if(isset($provinsi)){
                if($provinsi != ""){
                    $this->db->where("CRMNEW_CUSTOMER.ID_PROVINSI", $provinsi);
                }
            }

            if(isset($sales)){
                if($sales != ""){
                    $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER", $sales);
                }
            }

            if($idRegion != "1003"){
                $this->db->where("CRMNEW_USER.ID_REGION", $idRegion);
            }

            if(isset($idUser)){
                $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER", $idUser);

            }

            if(isset($isVisited)){
                $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME is NOT NULL", NULL, FALSE);
            }

            if(isset($idDistributor)){
                if($idDistributor != ""){
                    $this->db->where("CRMNEW_CUSTOMER.ID_DISTRIBUTOR", $idDistributor);
                    if($this->session->userdata("id_jenis_user") != "1001"){
                        $this->db->where("CRMNEW_USER.ID_JENIS_USER", "1003");
                    }
                }
            }

            if(isset($startDate) && isset($endDate)){
                $this->db->where("TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') BETWEEN '$startDate' AND '$endDate'");
            }

            $this->db->select("
                CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER, CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER, CRMNEW_USER.NAMA,
                CRMNEW_CUSTOMER.ID_DISTRIBUTOR, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR,
                CRMNEW_KUNJUNGAN_CUSTOMER.KETERANGAN,
                CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO, CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_JENIS_USER.JENIS_USER,
                ASSIGN.NAMA AS NAMA_ASSIGN,
                TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL_RENCANA_FORMAT_NEW,
                TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'DD - MONTH - YYYY') AS TGL_RENCANA_KUNJUNGAN, 
                TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'DD - MONTH - YYYY / HH24:MI') AS CHECKIN_TIME,
                CRMNEW_KUNJUNGAN_CUSTOMER.CHECKOUT_TIME,
                (TO_DATE(TO_CHAR(CHECKOUT_TIME, 'DD-MM-YYYY HH24:MI:SS'), 'DD-MM-YYYY HH24:MI:SS') - TO_DATE(TO_CHAR(CHECKIN_TIME, 'DD-MM-YYYY HH24:MI:SS'),'DD-MM-YYYY HH24:MI:SS'))*(24*60) AS SELISIH
                ");
            $this->db->from("CRMNEW_KUNJUNGAN_CUSTOMER");
            $this->db->join("CRMNEW_CUSTOMER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO = CRMNEW_CUSTOMER.ID_CUSTOMER");
            $this->db->join("CRMNEW_USER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER");
            $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_CUSTOMER.ID_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
            $this->db->join("CRMNEW_JENIS_USER", "CRMNEW_USER.ID_JENIS_USER = CRMNEW_JENIS_USER.ID_JENIS_USER");
            $this->db->join("(SELECT ID_USER, NAMA FROM CRMNEW_USER) ASSIGN", "CRMNEW_KUNJUNGAN_CUSTOMER.CREATED_BY = ASSIGN.ID_USER", "left");
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK", 0);
            $this->db->where("CRMNEW_USER.DELETED_MARK", 0);
            $this->db->order_by("CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN", "DESC");

            $canvasing = $this->db->get();
            // echo $this->db->last_query();
            if($canvasing->num_rows() > 0){
                return $canvasing->result();
            } else {
                return false;
            }
		}
		
		public function getProvinsiDist($idDistributor){
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

        public function detailCanvassing($idSales, $idKunjungan){
            $sql = "SELECT
                        CU.NAMA AS SURVEYOR,
                        CC.NAMA_TOKO AS CUSTOMER,
                        CC.NAMA_PEMILIK AS PEMILIK,
                        TO_CHAR( CKC.CHECKIN_TIME, 'YYYY-MM-DD' ) AS TGL_KUNJUNGAN,
                        TO_CHAR( CKC.CHECKIN_TIME, 'YYYY-MM-DD HH24:II:SS' ) AS CHECKIN_TIME,
                        TO_CHAR( CKC.CHECKOUT_TIME, 'YYYY-MM-DD HH24:II:SS' ) AS CHECKOUT_TIME,
                        CKC.CHECKIN_LATITUDE,
                        CKC.CHECKIN_LONGITUDE,
                        CKC.CHECKOUT_LATITUDE,
                        CKC.CHECKOUT_LONGITUDE,
                        CC.NAMA_DISTRIK AS KOTA,
                        CC.NAMA_KECAMATAN AS KECAMATAN,
                        CC.ALAMAT,
                        (
                        TO_DATE( TO_CHAR( CKC.CHECKOUT_TIME, 'DD-MM-YYYY HH24:MI:SS' ), 'DD-MM-YYYY HH24:MI:SS' ) - TO_DATE( TO_CHAR( CKC.CHECKIN_TIME, 'DD-MM-YYYY HH24:MI:SS' ), 'DD-MM-YYYY HH24:MI:SS' )) * ( 24 * 60 ) AS DURASI_KUNJUNGAN 
                    FROM
                        CRMNEW_KUNJUNGAN_CUSTOMER CKC
                        JOIN CRMNEW_USER CU ON CKC.ID_USER = CU.ID_USER
                        JOIN CRMNEW_CUSTOMER CC ON CKC.ID_TOKO = CC.ID_CUSTOMER 
                    WHERE
                        CKC.ID_USER = '$idSales' 
                        AND CKC.ID_KUNJUNGAN_CUSTOMER = '$idKunjungan' 
                        AND CKC.DELETED_MARK = '0'";
            $canvasing = $this->db->query($sql);
            if($canvasing->num_rows() > 0){
                return $canvasing->result();
            } else {
                return false;
            }
        }

        public function produkSurvey($idSales, $idKunjungan){
            $sql = "SELECT
                        CHS.ID_PRODUK,
                        CPS.NAMA_PRODUK AS PRODUK
                    FROM
                        CRMNEW_HASIL_SURVEY CHS 
                        JOIN CRMNEW_PRODUK_SURVEY CPS ON CHS.ID_PRODUK = CPS.ID_PRODUK
                    WHERE
                        CHS.ID_USER = '$idSales' 
                        AND CHS.ID_KUNJUNGAN_CUSTOMER = '$idKunjungan'
                        AND CHS.DELETE_MARK = '0'";
            $produkSurvey = $this->db->query($sql);
            if($produkSurvey->num_rows() > 0){
                return $produkSurvey->result();
            } else {
                return false;
            }
        }

        public function photoSurvey($idSales, $idKunjungan){
            $sql = "SELECT
                        FOTO_SURVEY AS URL_PATH 
                    FROM
                        CRMNEW_FOTO_SURVEY 
                    WHERE
                        ID_KUNJUNGAN_CUSTOMER = '$idKunjungan' 
                        AND DELETE_MARK = '0'";
            $photoSurvey = $this->db->query($sql);
            if($photoSurvey->num_rows() > 0){
                return $photoSurvey->result();
            } else {
                return false;
            }
        }

        public function surveyProduk($idProduk, $idKunjungan){
            $sql = "SELECT
                        STOK_SAAT_INI AS STOK,
                        VOLUME_PENJUALAN AS VOLUME_JUAL,
                        PS.NAMA_PRODUK AS NAMA_PRODUK,
                        VOLUME_PEMBELIAN AS VOLUME_BELI,
                        HARGA_PEMBELIAN AS HARGA_BELI,
                        HARGA_PENJUALAN AS HARGA_JUAL,
                        TOP_PEMBELIAN AS TOP,
                        TO_CHAR(TGL_PEMBELIAN, 'YYYY-MM-DD') AS TGL_PEMBELIAN,
                        KAPASITAS_TOKO
                    FROM
                        CRMNEW_HASIL_SURVEY HS
					JOIN CRMNEW_PRODUK_SURVEY PS ON HS.ID_PRODUK = PS.ID_PRODUK
                    WHERE
                        ID_KUNJUNGAN_CUSTOMER = '$idKunjungan' 
                        AND HS.ID_PRODUK = '$idProduk'
                        AND HS.DELETE_MARK = '0'";
            $surveyProduk = $this->db->query($sql);
            if($surveyProduk->num_rows() > 0){
                return $surveyProduk->result();
            } else {
                return false;
            } 
        }

        public function surveyKeluhan($idProduk, $idKunjungan){
            $sql = "SELECT
                        CSKC.ID_SURVEY_KELUHAN,
                        CK.KELUHAN AS NAMA_KELUHAN,
                        CSKC.JAWABAN
                    FROM
                        CRMNEW_SURVEY_KELUHAN_CUSTOMER CSKC 
                        JOIN CRMNEW_KELUHAN CK ON CSKC.ID_KELUHAN = CK.ID_KELUHAN
                    WHERE
                        CSKC.ID_PRODUK = '$idProduk' 
                        AND CSKC.ID_KUNJUNGAN_CUSTOMER = '$idKunjungan'
                        AND CSKC.DELETE_MARK = '0'
                        AND CSKC.JAWABAN IS NOT NULL";
            $surveyKeluhan = $this->db->query($sql);
            if($surveyKeluhan->num_rows() > 0){
                return $surveyKeluhan->result();
            } else {
                return false;
            }
        }

        public function surveyPromosi($idProduk, $idKunjungan){
            $sql = "SELECT
                        CSPC.ID_SURVEY_PROMOSI,
                        CP.PROMOSI AS NAMA_PROMOSI,
                        CSPC.JAWABAN
                    FROM
                        CRMNEW_SURVEY_PROMO_CUSTOMER CSPC 
                        JOIN CRMNEW_PROMOSI CP ON CSPC.ID_PROMOSI = CP.ID_PROMOSI
                    WHERE
                        CSPC.ID_PRODUK = '$idProduk' 
                        AND CSPC.ID_KUNJUNGAN_CUSTOMER = '$idKunjungan'
                        AND CSPC.DELETE_MARK = '0'
                        AND CSPC.JAWABAN IS NOT NULL";
            $surveyPromosi = $this->db->query($sql);
            if($surveyPromosi->num_rows() > 0){
                return $surveyPromosi->result();
            } else {
                return false;
            }
        }

    }
?>
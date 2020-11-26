<?php
    class Model_kpi extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listGudangDist($kodeDist){
            $this->db_tpl = $this->load->database("marketplace", true);
            $sql = "SELECT
                        KD_GDG,
                        NM_GDG 
                    FROM
                        GUDANG_SIDIGI 
                    WHERE
                        KD_DISTR = $kodeDist";
            $gudang = $this->db_tpl->query($sql);
            if($gudang->num_rows() > 0){
                return $gudang->result();
            } else {
                return false;
            }
        }

        public function realisasiSo($kodeDist, $bulan, $tahun){
            if($bulan < 10){
                $bulan = "0".$bulan;
            }
            
            $this->db_scm = $this->load->database("SCM", true);
            $sql = "SELECT SUM(TOTAL_TO) AS TOTAL, SUM(REAL_TO) AS REAL, SUM(SISA_TO) AS SISA FROM(
                        SELECT
                            TOTAL_TO,
                            REAL_TO,
                            SISA_TO
                        FROM
                            ZREPORT_SO_BUFFER 
                        WHERE
                            SOLD_TO_CODE = '$kodeDist' 
                            AND TO_CHAR( TGL_DELIV, 'YYYY-MM' ) = '$tahun-$bulan' UNION
                        SELECT
                            TOTAL_TO,
                            REAL_TO,
                            SISA_TO 
                        FROM
                            ZREPORT_SO_BUFFER_ALL 
                        WHERE
                            SOLD_TO_CODE = '$kodeDist' 
                            AND TO_CHAR( TGL_DELIV, 'YYYY-MM' ) = '$tahun-$bulan')";
            $real_so = $this->db_scm->query($sql);
            if($real_so->num_rows() > 0){
                return $real_so->result();
            } else {
                return false;
            }
        }

        public function porsiTarget($bulan, $tahun){
            $this->db_scm = $this->load->database("SCM", true);
            $day = date('d');
            $sql = "SELECT
                        VKORG AS ORG,
                        SUM( PORSI ) AS PORSI 
                    FROM
                        ZREPORT_PORSI_SALES_REGION 
                    WHERE
                        VKORG IN ( 7000 ) 
                        AND BUDAT BETWEEN '".$tahun. $bulan."01'
                        AND '".$tahun.$bulan.$day."' 
                    GROUP BY
                        VKORG
                    UNION
                    SELECT
                        VKORG AS ORG,
                        SUM( PORSI ) AS PORSI 
                    FROM
                        ZREPORT_PORSI_SALES_REGION 
                    WHERE
                        VKORG IN (7000 ) 
                        AND BUDAT BETWEEN '".$tahun. $bulan."01'
                        AND '".$tahun. $bulan."31' GROUP BY VKORG";
            $identitas = $this->db_scm->query($sql);
            if($identitas->num_rows() > 0){
                return $identitas->result();
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
                    JOIN CRMNEW_USER_DISTRIBUTOR ON CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER
                    LEFT JOIN ( SELECT ID_USER, ID_PROVINSI FROM CRMNEW_USER_PROVINSI WHERE DELETE_MARK = '0' ) USER_PROVINSI ON CRMNEW_USER.ID_USER = USER_PROVINSI.ID_USER
                    LEFT JOIN (
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
                    CRMNEW_USER.ID_USER = '$idUser' AND CRMNEW_USER_DISTRIBUTOR.DELETE_MARK = '0'
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

        public function indexKpiUser($idRegion, $bulan, $tahun){
            // $bulan = date('m');
            // $tahun = date('Y');
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1001"){
                $sql = "SELECT VOLUME, HARGA, REVENUE, KEEP, GET, GROWTH, SO_DO FROM CRMNEW_INDEX_KPI WHERE ID_REGION = '$idRegion' AND BULAN = '$bulan' AND TAHUN = '$tahun' AND ID_JENIS_USER = '$idJenisUser'";
            } else if($idJenisUser == "1002" || $idJenisUser == "1003" || $idJenisUser == "1005" || $idJenisUser == "1007"){
                $idDistributor = $this->session->userdata("kode_dist");
                $sql = "SELECT VOLUME, HARGA, REVENUE, KEEP, GET, GROWTH, SO_DO FROM CRMNEW_INDEX_KPI WHERE KODE_DISTRIBUTOR = '$idDistributor' AND BULAN = '$bulan' AND TAHUN = '$tahun'";
            }
            
            $indexKpi = $this->db->query($sql);
            if($indexKpi->num_rows() > 0){
                return $indexKpi->row();
            } else {
                return false;
            }
        }

        public function getTokoBaru($idDistributor, $bulan, $tahun){
            $db_poin = $this->load->database("Point", true);

            if($bulan < 10){
                $bulan = "0".$bulan;
            }

            $sql = "SELECT
                        COUNT(ID_CUSTOMER) AS JML_TOKO_BARU 
                    FROM
                        M_CUSTOMER 
                    WHERE
                        TO_CHAR( CREATED_AT, 'MM' ) = '$bulan' 
                        AND TO_CHAR( CREATED_AT, 'YYYY' ) = '$tahun' 
                        AND NOMOR_DISTRIBUTOR = '$idDistributor' 
                        AND KD_CUSTOMER IS NOT NULL";

            $data = $db_poin->query($sql);
            if($data->num_rows() > 0){
                return $data->row();
            } else {
                return false;
            }

        }

        public function rekapKunjunganDist($idDistributor, $bulan1, $tahun){
            if($bulan1 < 10){
                $bulan1 = "0".$bulan1;
            }
            $bulan = "$tahun-$bulan1";

            $sql = "SELECT
                        CRMNEW_INDEX_KPI.KUNJUNGAN AS INDEX_KUNJUNGAN,
                        CRMNEW_INDEX_KPI.TARGET_KUNJUNGAN,
                        TARGET_REKAP_DIST.REKAP_TARGET_KUNJUNGAN_DIST,
                        NVL(REAL_KUNJUNGAN.REALISASI_KUNJUNGAN, 0) AS JUMLAH_REALISASI
                    FROM
                        CRMNEW_INDEX_KPI 
                        LEFT JOIN (SELECT KODE_DISTRIBUTOR, SUM( KUNJUNGAN ) AS REKAP_TARGET_KUNJUNGAN_DIST FROM CRMNEW_KPI_TARGET_SALES WHERE KODE_DISTRIBUTOR = '$idDistributor' AND DELETE_MARK = '0' AND BULAN = '$bulan1' AND TAHUN = '$tahun' GROUP BY KODE_DISTRIBUTOR ) TARGET_REKAP_DIST ON CRMNEW_INDEX_KPI.KODE_DISTRIBUTOR = TARGET_REKAP_DIST.KODE_DISTRIBUTOR
                        LEFT JOIN (SELECT CRMNEW_CUSTOMER.ID_DISTRIBUTOR, COUNT(CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER) AS REALISASI_KUNJUNGAN FROM CRMNEW_KUNJUNGAN_CUSTOMER JOIN CRMNEW_CUSTOMER ON CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO = CRMNEW_CUSTOMER.ID_CUSTOMER JOIN CRMNEW_USER ON CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER WHERE CRMNEW_CUSTOMER.ID_DISTRIBUTOR = '$idDistributor' AND TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME,'YYYY-MM') = '$bulan' AND CRMNEW_USER.ID_JENIS_USER = '1003' AND CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME IS NOT NULL GROUP BY CRMNEW_CUSTOMER.ID_DISTRIBUTOR) REAL_KUNJUNGAN ON CRMNEW_INDEX_KPI.KODE_DISTRIBUTOR = REAL_KUNJUNGAN.ID_DISTRIBUTOR
                    WHERE
                        CRMNEW_INDEX_KPI.KODE_DISTRIBUTOR = '$idDistributor' AND CRMNEW_INDEX_KPI.BULAN = '$bulan1' AND CRMNEW_INDEX_KPI.TAHUN = '$tahun'";
            $kujungan = $this->db->query($sql);
            if($kujungan->num_rows() > 0){
                return $kujungan->result();
            } else {
                return false;
            }
        }

        public function indexKpi($idJenisUser, $kodeDist = null, $bulan = null, $tahun = null){
            $whereJenisUser = "";
            $whereDate = "";
            $whereDistributor = "";
            if(isset($idJenisUser)){
                if($idJenisUser == "1002" || $idJenisUser == "1007"){
                    $whereJenisUser = "AND CRMNEW_INDEX_KPI.ID_JENIS_USER = '1002'";
                    $whereDistributor = "AND CRMNEW_INDEX_KPI.KODE_DISTRIBUTOR = '$kodeDist'";
                } else {
                    $whereJenisUser = "AND CRMNEW_INDEX_KPI.ID_JENIS_USER = '1001'";
                }
            }

            if(isset($bulan) || isset($tahun)){
                $whereDate = "AND CRMNEW_INDEX_KPI.BULAN = '$bulan' AND CRMNEW_INDEX_KPI.TAHUN = '$tahun'";
            }
            $sql = "SELECT
                        CRMNEW_INDEX_KPI.KPI_INDEX_ID,
                        CRMNEW_INDEX_KPI.ID_REGION,
                        CRMNEW_INDEX_KPI.BULAN,
                        CRMNEW_INDEX_KPI.TAHUN,
                        REGION.REGION_NAME,
                        CRMNEW_INDEX_KPI.KODE_DISTRIBUTOR,
                        DISTRIBUTOR.NAMA_DISTRIBUTOR,
                        CRMNEW_INDEX_KPI.VOLUME,
                        CRMNEW_INDEX_KPI.HARGA,
                        CRMNEW_INDEX_KPI.REVENUE,
                        CRMNEW_INDEX_KPI.KUNJUNGAN,
                        CRMNEW_INDEX_KPI.KEEP,
                        CRMNEW_INDEX_KPI.GET,
                        CRMNEW_INDEX_KPI.GROWTH,
                        CRMNEW_INDEX_KPI.SO_DO,
                        CRMNEW_INDEX_KPI.TARGET_KUNJUNGAN
                    FROM
                        CRMNEW_INDEX_KPI
                        LEFT JOIN ( SELECT ID, REGION_NAME FROM CRMNEW_REGION ) REGION ON CRMNEW_INDEX_KPI.ID_REGION = REGION.ID
                        LEFT JOIN ( SELECT KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR FROM CRMNEW_DISTRIBUTOR ) DISTRIBUTOR ON CRMNEW_INDEX_KPI.KODE_DISTRIBUTOR = DISTRIBUTOR.KODE_DISTRIBUTOR 
                    WHERE
                        CRMNEW_INDEX_KPI.DELETE_MARK = 0 $whereJenisUser $whereDistributor $whereDate ORDER BY CRMNEW_INDEX_KPI.ID_REGION ASC";

            $indexKpi = $this->db->query($sql);
            if($indexKpi->num_rows() > 0){
                return $indexKpi->result();
            } else {
                return false;
            }
        }

        public function checkIndex($idJenisUser, $id = null, $bulan = null, $tahun = null){
            $whereIdJenis = "";
            $whereDate = "";

            if($idJenisUser == "1001"){
                $whereIdJenis = "AND ID_REGION = '$id'";
            } else if($idJenisUser == "1002"){
                $whereIdJenis = "AND KODE_DISTRIBUTOR = '$id'";
            }

            if(isset($bulan) || isset($tahun)){
                $whereDate = "AND BULAN = '$bulan' AND TAHUN = '$tahun'";
            }

            $sql = "SELECT
                        KPI_INDEX_ID 
                    FROM
                        CRMNEW_INDEX_KPI 
                    WHERE
                        ID_JENIS_USER = '$idJenisUser' 
                        AND DELETE_MARK = 0 $whereIdJenis $whereDate";
            $indexKpi = $this->db->query($sql);
            if($indexKpi->num_rows() > 0){
                return $indexKpi->result();
            } else {
                return false;
            }
        }

        public function tambahIndex($data){
            $this->db->insert("CRMNEW_INDEX_KPI", $data);
            if($this->db->affected_rows() > 0){
                return true;
            } else {
                return false;
            }
        }

        public function updateIndex($data, $idIndex){
            $this->db->where("KPI_INDEX_ID", $idIndex)->update("CRMNEW_INDEX_KPI", $data);
            if($this->db->affected_rows() > 0){
                return true;
            } else {
                return false;
            }
        }

        public function kpi_kunjungan($idUser = null, $idRegion = null, $bulan = null, $tahun = null){
            if($bulan < 10){
                $bulan = "0".$bulan;
            }
            $whereUser = "";
            $whereBulan = "";
            $whereTahun = "";
            $whereBulanReal = "";
            $whereTahunReal = "";

            $idJenisUser = $this->session->userdata("id_jenis_user");
            $whereDistributor = "";
            $whereJenisUser = "";
            if($idJenisUser == "1002" || $idJenisUser == "1003"){
                $idDistributor = $this->session->userdata("kode_dist");
                $whereDistributor = "AND KODE_DISTRIBUTOR = '$idDistributor'";
            } else {
                $whereJenisUser = "AND ID_JENIS_USER = '1001'";
                $whereDistributor = "AND ID_REGION = '$idRegion'";
            }

            if(isset($idUser)){
                if($idUser != ""){
                    $whereUser = "AND CRMNEW_USER.ID_USER = '$idUser'";
                }
            }

            if(isset($bulan)){
                $whereBulan = "AND TO_CHAR(CHECKIN_TIME, 'MM') = '$bulan'";
                $whereBulanReal = "AND TO_CHAR(CHECKIN_TIME, 'MM') = '$bulan'";
                $whereBulanSurvey = "AND TO_CHAR(CREATE_DATE, 'MM') = '$bulan'";
            }

            if(isset($tahun)){
                $whereTahun = "AND TO_CHAR(CHECKIN_TIME, 'YYYY') = '$tahun'";
                $whereTahunReal = "AND TO_CHAR(CHECKIN_TIME, 'YYYY') = '$tahun'";
                $whereTahunSurvey = "AND TO_CHAR(CREATE_DATE, 'YYYY') = '$tahun'";
            }

            $sql = "SELECT
                        CRMNEW_USER.ID_USER,
                        CRMNEW_USER.NAMA,
                        INDEX_KPI.KUNJUNGAN AS INDEX_KUNJUNGAN,
                        INDEX_KPI.TARGET_KUNJUNGAN,
                        TARGET.KUNJUNGAN AS TARGET_SALES_KUNJUNGAN,
                        NVL(RENCANA_KUNJUNGAN.JUMLAH, 0) AS JUMLAH_RENCANA,
                        NVL(REALISASI_KUNJUNGAN.JUMLAH, 0) AS JUMLAH_REALISASI,
                        NVL(KUNJUNGAN_SURVEY.JML_KUNJUNGAN_SURVEY, 0) AS JUMLAH_ISIAN_SURVEY 
                    FROM
                        CRMNEW_USER
                        LEFT JOIN ( SELECT ID_REGION, KUNJUNGAN, TARGET_KUNJUNGAN FROM CRMNEW_INDEX_KPI WHERE BULAN = '$bulan' AND TAHUN = '$tahun' $whereDistributor $whereJenisUser ) INDEX_KPI ON CRMNEW_USER.ID_REGION = INDEX_KPI.ID_REGION
                        LEFT JOIN ( SELECT ID_USER, COUNT( ID_KUNJUNGAN_CUSTOMER ) AS JUMLAH FROM CRMNEW_KUNJUNGAN_CUSTOMER WHERE DELETED_MARK = 0 $whereBulan $whereTahun GROUP BY ID_USER ) RENCANA_KUNJUNGAN ON CRMNEW_USER.ID_USER = RENCANA_KUNJUNGAN.ID_USER
                        LEFT JOIN ( SELECT ID_USER, COUNT( ID_KUNJUNGAN_CUSTOMER ) AS JUMLAH FROM CRMNEW_KUNJUNGAN_CUSTOMER WHERE CHECKIN_TIME IS NOT NULL  AND DELETED_MARK = 0 $whereBulan $whereTahun GROUP BY ID_USER ) REALISASI_KUNJUNGAN ON CRMNEW_USER.ID_USER = REALISASI_KUNJUNGAN.ID_USER
                        LEFT JOIN ( SELECT ID_USER, COUNT( ID_KUNJUNGAN_CUSTOMER ) AS JML_KUNJUNGAN_SURVEY  FROM ( SELECT DISTINCT ID_USER, ID_KUNJUNGAN_CUSTOMER FROM CRMNEW_HASIL_SURVEY WHERE DELETE_MARK = 0 $whereBulanSurvey $whereTahunSurvey ) GROUP BY ID_USER ) KUNJUNGAN_SURVEY ON CRMNEW_USER.ID_USER = KUNJUNGAN_SURVEY.ID_USER
                        LEFT JOIN ( SELECT ID_SALES, KUNJUNGAN FROM CRMNEW_KPI_TARGET_SALES WHERE ID_SALES = '$idUser' AND BULAN = '$bulan' AND TAHUN = '$tahun' AND DELETE_MARK = '0' ) TARGET ON CRMNEW_USER.ID_USER = TARGET.ID_SALES
                    WHERE
                        CRMNEW_USER.DELETED_MARK = 0 
                        AND CRMNEW_USER.ID_JENIS_USER IN (
                        1003,
                        1005) $whereUser";

            $kujungan = $this->db->query($sql);
            // echo $this->db->last_query();
            if($kujungan->num_rows() > 0){
                return $kujungan->result();
            } else {
                return false;
            }
        }

        public function targetVolumeHargaRevenueUser($kodeDist = null, $idProvinsi = null, $bulan = null, $tahun = null){
            $sql = "SELECT KODE_DISTRIBUTOR, TARGET_VOLUME, TARGET_HARGA, (TARGET_VOLUME * TARGET_HARGA) AS TARGET_REVENUE FROM (SELECT
                        TVK.KODE_DISTRIBUTOR,
                        SUM(TVK.VOLUME) AS TARGET_VOLUME,
                        THK.HARGA AS TARGET_HARGA
                    FROM
                        CRMNEW_TARGET_VOLUME_KPI TVK
                        LEFT JOIN ( SELECT KODE_DISTRIBUTOR, SUM(HARGA) AS HARGA FROM CRMNEW_TARGET_HARGA_KPI WHERE KODE_DISTRIBUTOR = '$kodeDist' AND ID_PROVINSI = '$idProvinsi' AND BULAN = '$bulan' AND TAHUN = '$tahun' GROUP BY KODE_DISTRIBUTOR ) THK ON TVK.KODE_DISTRIBUTOR = THK.KODE_DISTRIBUTOR 
                    WHERE
                        TVK.KODE_DISTRIBUTOR = '$kodeDist' 
                        AND TVK.ID_PROVINSI = '$idProvinsi' 
                        AND TVK.BULAN = '$bulan' 
                        AND TVK.TAHUN = '$tahun' GROUP BY TVK.KODE_DISTRIBUTOR, THK.HARGA)";
            $targetVolume = $this->db->query($sql);
            // echo $this->db->last_query();
            if($targetVolume->num_rows() > 0){
                return $targetVolume->row();
            } else {
                return false;
            }
        }

        public function targetCustomer($bulan, $tahun, $kodeDist = null){
            if(isset($kodeDist)){
                $this->db->where("KODE_DISTRIBUTOR", $kodeDist);
            }

            $this->db->select("TARGET_KEEP, TARGET_GET, TARGET_GROWTH")->from("CRMNEW_TARGET_CUSTOMER_KPI")->where("BULAN", $bulan)->where("TAHUN", $tahun)->where("DELETE_MARK", "0");

            $data = $this->db->get();
            if($data->num_rows() > 0){
                return $data->row();
            } else {
                return false;
            }
        }

        public function realisasiDataDistSidigi($kodeDist = null, $idProvinsi = null, $bulan1 = null, $tahun = null){
            if($bulan1 < 10){
                $bulan = "0".$bulan1;
            } else {
                $bulan = $bulan1;
            }
            
            $this->db_tpl = $this->load->database("marketplace", true);
            $sql = "SELECT
                        SUM( QTY / 25 ) AS VOLUME,
                        SUM((QTY / 25 ) * (HARGA) * 25) AS REVENUE,
                        ROUND(SUM((QTY ) * (HARGA) * 25) / SUM( QTY )) AS HARGA 
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        KD_DISTRIBUTOR = '$kodeDist' 
                        AND TO_CHAR( TGL_KIRIM, 'YYYY-MM' ) = '$tahun-$bulan' 
                        AND DELETE_MARK = '0'";
            $real = $this->db_tpl->query($sql);
            if($real->num_rows() > 0){
                return $real->row();
            } else {
                return false;
            }
        }

        public function realisasiVolumeHarhaRevenueUser($kodeDist = null, $idProvinsi = null, $bulan = null, $tahun = null){
            if($bulan < 10){
                $bulan = "0".$bulan;
            }
            $dbAppbisd = $this->load->database("SCM", true);
            $sql = "SELECT
                        SUM( KWANTUMX ) AS VOLUME,
                        SUM( HARGA ) / SUM( KWANTUMX ) AS HARGA,
                        SUM( HARGA ) AS REVENUE 
                    FROM
                        ZREPORT_SCM_HARGA_SOLDTO 
                    WHERE
                        BULAN = '$bulan' 
                        AND TAHUN = '$tahun' 
                        AND PROPINSI_TO = '$idProvinsi' 
                        AND SOLD_TO = '$kodeDist'";
            $identitas = $dbAppbisd->query($sql);
            if($identitas->num_rows() > 0){
                return $identitas->row();
            } else {
                return false;
            }
        }

        public function targetKeep($bulan, $tahun, $kodeDist){
            if($bulan < 10){
                $tahunAwal = date("Y-m-d", strtotime($tahun."-0".$bulan."-01"));
            } else {
                $tahunAwal = date("Y-m-d", strtotime($tahun."-".$bulan."-01"));
            }

            $fristYear = date("Y", strtotime( date( $tahunAwal )." -1 months"));
            $fristMonth = date("m", strtotime( date( $tahunAwal )." -1 months"));

            $secondYear = date("Y", strtotime( date( $tahunAwal )." -2 months"));
            $secondMonth = date("m", strtotime( date( $tahunAwal )." -2 months"));
            $db_poin = $this->load->database("Point", true);
            $sql = "SELECT DISTINCT
                        KD_CUSTOMER,
                        NAMA_TOKO 
                    FROM
                        (
                    SELECT
                        M_CUSTOMER.KD_CUSTOMER,
                        M_CUSTOMER.NAMA_TOKO,
                        P_POIN.PENJUALAN 
                    FROM
                        P_POIN
                        JOIN M_CUSTOMER ON P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER 
                    WHERE
                        P_POIN.BULAN = '$secondMonth' 
                        AND P_POIN.TAHUN = '$secondYear' 
                        AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$kodeDist' 
                        AND P_POIN.PENJUALAN != 0 AND P_POIN.STATUS != 5 UNION
                    SELECT
                        M_CUSTOMER.KD_CUSTOMER,
                        M_CUSTOMER.NAMA_TOKO,
                        P_POIN.PENJUALAN 
                    FROM
                        P_POIN
                        JOIN M_CUSTOMER ON P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER 
                    WHERE
                        P_POIN.BULAN = '$fristMonth' 
                        AND P_POIN.TAHUN = '$secondYear' 
                        AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$kodeDist' 
                        AND P_POIN.PENJUALAN != 0 AND P_POIN.STATUS != 5)";

            $data = $db_poin->query($sql);
            if($data->num_rows() > 0){
                return $data->num_rows();
            } else {
                return false;
            }
        }

        public function realisasiKeep($bulan, $tahun, $kodeDist){
            if($bulan < 10){
                $tahunAwal = date("Y-m-d", strtotime($tahun."-0".$bulan."-01"));
            } else {
                $tahunAwal = date("Y-m-d", strtotime($tahun."-".$bulan."-01"));
            }

            $fristYear = date("Y", strtotime( date( $tahunAwal )." -1 months"));
            $fristMonth = date("m", strtotime( date( $tahunAwal )." -1 months"));
            $db_poin = $this->load->database("Point", true);
            $sql = "SELECT
                        M_CUSTOMER.KD_CUSTOMER,
                        M_CUSTOMER.NAMA_TOKO,
                        P_POIN.PENJUALAN 
                    FROM
                        P_POIN
                        JOIN M_CUSTOMER ON P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER 
                    WHERE
                        P_POIN.BULAN = '$fristMonth' 
                        AND P_POIN.TAHUN = '$fristYear' 
                        AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$kodeDist' 
                        AND P_POIN.PENJUALAN != 0 AND P_POIN.STATUS != 5";

            $data = $db_poin->query($sql);
            // echo $db_poin->last_query();
            if($data->num_rows() > 0){
                return $data->num_rows();
            } else {
                return false;
            }
        }

        public function targetGrowth($bulan, $tahun, $kodeDist){
            $db_poin = $this->load->database("Point", true);

            if($bulan < 10){
                $tahunAwal = date("Y-m-d", strtotime($tahun."-0".$bulan."-01"));
            } else {
                $tahunAwal = date("Y-m-d", strtotime($tahun."-".$bulan."-01"));
            }

            if($bulan <= 1){
                $fristYear = date("Y", strtotime( date( $tahunAwal )." -2 years"));
            } else {
                $fristYear = date("Y", strtotime( date( $tahunAwal )." -1 years"));
            }

            
            $fristMonth = date("m", strtotime( date( $tahunAwal )." -1 months"));

            $sql = "SELECT
                        SUM(P_POIN.PENJUALAN) AS PENJUALAN_TON
                    FROM
                        P_POIN
                        JOIN M_CUSTOMER ON P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER 
                    WHERE
                        P_POIN.BULAN = '$fristMonth' 
                        AND P_POIN.TAHUN = '$fristYear' 
                        AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$kodeDist' 
                        AND P_POIN.PENJUALAN != 0 
                        AND P_POIN.STATUS != 5";
            $data = $db_poin->query($sql);
            // echo $db_poin->last_query();
            if($data->num_rows() > 0){
                return $data->row();
            } else {
                return false;
            }
        }

        public function realisasiGrowth($bulan, $tahun, $kodeDist){
            $db_poin = $this->load->database("Point", true);

            if($bulan < 10){
                $tahunAwal = date("Y-m-d", strtotime($tahun."-0".$bulan."-01"));
            } else {
                $tahunAwal = date("Y-m-d", strtotime($tahun."-".$bulan."-01"));
            }

            if($bulan < 1){
                $fristYear = date("Y", strtotime( date( $tahunAwal )." -1 years"));
            } else {
                $fristYear = date("Y", strtotime( date( $tahunAwal )." -1 months"));
            }
            
            $fristMonth = date("m", strtotime( date( $tahunAwal )." -1 months"));

            $sql = "SELECT
                        SUM(P_POIN.PENJUALAN) AS PENJUALAN_TON
                    FROM
                        P_POIN
                        JOIN M_CUSTOMER ON P_POIN.KD_CUSTOMER = M_CUSTOMER.KD_CUSTOMER 
                    WHERE
                        P_POIN.BULAN = '$fristMonth' 
                        AND P_POIN.TAHUN = '$fristYear' 
                        AND M_CUSTOMER.NOMOR_DISTRIBUTOR = '$kodeDist' 
                        AND P_POIN.PENJUALAN != 0 
                        AND P_POIN.STATUS != 5";
            $data = $db_poin->query($sql);
            if($data->num_rows() > 0){
                return $data->row();
            } else {
                return false;
            }
        }

        public function targetKpiSalesDistributor($idUser = null, $bulan = null, $tahun = null){
            $sql = "SELECT VOLUME AS TARGET_VOLUME, HARGA AS TARGET_HARGA, REVENUE AS TARGET_REVENUE, KUNJUNGAN FROM CRMNEW_KPI_TARGET_SALES WHERE ID_SALES = '$idUser' AND BULAN = '$bulan' AND TAHUN = '$tahun' AND DELETE_MARK = '0'";
            $target = $this->db->query($sql);
            if($target->num_rows() > 0){
                return $target->row();
            } else {
                return false;
            }
        }

        public function getTokoSales($idUser){
            $this->db->select("LISTAGG(ID_CUSTOMER, ',') WITHIN GROUP (ORDER BY ID_CUSTOMER) AS ID_CUSTOMER");
            $this->db->from("CRMNEW_ASSIGN_TOKO_SALES");
            $this->db->where("ID_USER", $idUser);
            $this->db->where("DELETE_MARK", "0");
            $toko = $this->db->get();
            if($toko->num_rows() > 0){
                return $toko->row();
            } else {
                return false;
            }
        }

        public function realisasiSales($idCustomer, $bulan = null, $tahun = null){
            if($bulan < 10){
                $bulan = "0".$bulan;
            }
            $this->db_tpl = $this->load->database("marketplace", true);
            $idCustomer = "'".str_replace(", ","','", $idCustomer)."'";
            $sql = "SELECT
                        NVL((SUM( VOLUME_40_ZAK ) + SUM( VOLUME_50_ZAK ) + SUM( VOLUME_PUTIH_ZAK )),0) AS REALISASI_VOLUME_ZAK,
                        NVL((SUM( VOLUME_40_TON ) + SUM( VOLUME_50_TON ) + SUM( VOLUME_PUTIH_TON )),0) AS VOLUME,
                        NVL((SUM( REVENUE_40_TON ) + SUM( REVENUE_50_TON ) + SUM( REVENUE_PUTIH_TON )),0) AS REVENUE,
                        ROUND(NULLIF((SUM( REVENUE_40_TON ) + SUM( REVENUE_50_TON ) + SUM( REVENUE_PUTIH_TON )),0) / (SUM( VOLUME_40_TON ) + SUM( VOLUME_50_TON ) + SUM( VOLUME_PUTIH_TON ))) AS HARGA
                    FROM
                        (
                    SELECT DISTINCT
                        A.ID_CUSTOMER,
                        A.NAMA_TOKO,
                        NVL( B.VOLUME_40_ZAK, 0 ) AS VOLUME_40_ZAK,
                        NVL( B.VOLUME_40_TON, 0 ) AS VOLUME_40_TON,
                        NVL( B.REVENUE_40, 0 ) AS REVENUE_40_TON,
                        NVL( B.HARGA_40, 0 ) AS HARGA_40_TON,
                        NVL( C.VOLUME_50_ZAK, 0 ) AS VOLUME_50_ZAK,
                        NVL( C.VOLUME_50_TON, 0 ) AS VOLUME_50_TON,
                        NVL( C.REVENUE_50, 0 ) AS REVENUE_50_TON,
                        NVL( C.HARGA_50, 0 ) AS HARGA_50_TON,
                        NVL( D.VOLUME_PUTIH_ZAK, 0 ) AS VOLUME_PUTIH_ZAK,
                        NVL( D.VOLUME_PUTIH_TON, 0 ) AS VOLUME_PUTIH_TON,
                        NVL( D.REVENUE_PUTIH, 0 ) AS REVENUE_PUTIH_TON,
                        NVL( D.HARGA_PUTIH, 0 ) AS HARGA_PUTIH_TON 
                    FROM
                        SIDIGI_M_TOKO A
                        LEFT JOIN (
                    SELECT
                        KD_TOKO,
                        SUM( QTY ) AS VOLUME_40_ZAK,
                        SUM( QTY  ) AS VOLUME_40_TON,
                        SUM(QTY * HARGA ) AS REVENUE_40,
                        ROUND(SUM(QTY  * HARGA ) / SUM(QTY)) AS HARGA_40 
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        KD_TOKO IN ( $idCustomer ) 
                        AND TO_CHAR( TGL_KIRIM, 'YYYY-MM' ) = '$tahun-$bulan' 
                        AND KD_PRODUK IN ( '10110003', '10110004', '121-301-0050', '121-301-0050 ', '121-301-0110', '121-301-0110P', '121-301-0180' ) 
                    GROUP BY
                        KD_TOKO 
                        ) B ON A.ID_CUSTOMER = B.KD_TOKO
                        LEFT JOIN (
                    SELECT
                        KD_TOKO,
                        SUM( QTY ) AS VOLUME_50_ZAK,
                        SUM( QTY ) AS VOLUME_50_TON,
                        SUM(QTY * HARGA ) AS REVENUE_50,
                        ROUND(SUM(QTY * HARGA ) / SUM( QTY )) AS HARGA_50 
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        KD_TOKO IN ( $idCustomer) 
                        AND TO_CHAR( TGL_KIRIM, 'YYYY-MM' ) = '$tahun-$bulan' 
                        AND KD_PRODUK IN ( '10110001', '10110002', '10110005', '121-301-0020', '121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ' ) 
                    GROUP BY
                        KD_TOKO 
                        ) C ON A.ID_CUSTOMER = C.KD_TOKO
                        LEFT JOIN (
                    SELECT
                        KD_TOKO,
                        SUM( QTY ) AS VOLUME_PUTIH_ZAK,
                        SUM( QTY)  AS VOLUME_PUTIH_TON,
                        SUM(QTY  * HARGA ) AS REVENUE_PUTIH,
                        ROUND(SUM(QTY * HARGA ) / SUM( QTY )) AS HARGA_PUTIH 
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        KD_TOKO IN ( $idCustomer) 
                        AND TO_CHAR( TGL_KIRIM, 'YYYY-MM' ) = '$tahun-$bulan' 
                        AND KD_PRODUK IN ( '121-301-0240' ) 
                    GROUP BY
                        KD_TOKO 
                        ) D ON A.ID_CUSTOMER = D.KD_TOKO 
                    WHERE
                        A.ID_CUSTOMER IN ( $idCustomer))";
            $realisasiSales = $this->db_tpl->query($sql);
            return $realisasiSales->row();
        }
    }
?>
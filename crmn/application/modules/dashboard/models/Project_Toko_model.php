<?php
    class Project_Toko_model extends CI_Model {

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
        
        public function GrafikKunjunganAdmin($filterBy = null, $filterSet = null, $bulan, $tahun){
            $sqlIn = "";
            if($filterBy != 0){
                if($filterBy == 1){
                    $sqlIn = " AND V.REGION_ID = '$filterSet' ";
                } else if ($filterBy == 2){
                    $sqlIn = " AND V.ID_PROVINSI = '$filterSet' ";
                } else if ($filterBy == 3){
                    
                } else if ($filterBy == 4){
                    $sqlIn = " AND V.KD_AREA = '$filterSet' ";
                } else if ($filterBy == 5){
                    $sqlIn = " AND V.KODE_DISTRIBUTOR = '$filterSet' ";
                }
            }

            // print_r($filterBy.' '.$filterSet.' '.$bulan.' '.$tahun);exit;
            
            $sqlAdd = "where bulan = '$bulan' and tahun = '$tahun'";
             
             $sql = "
                SELECT
                KALENDER.HARI AS TANGGAL,
                NVL(VISIT.TARGET, 0) AS TARGET,
                NVL(VISIT.REALISASI, 0) AS REALISASI
                FROM 
                        (
                            SELECT
                            TO_CHAR(TANGGAL, 'DD') AS HARI
                            FROM CALENDER_CRM
                            WHERE TO_CHAR(TANGGAL, 'YYYY') ='$tahun'
                            AND TO_CHAR(TANGGAL, 'MM') ='$bulan'
                            ORDER BY HARI
                        ) KALENDER
                LEFT JOIN 
                        (
                            SELECT
                            V.HARI,
                            SUM(V.TARGET) AS TARGET,
                            SUM(V.REALISASI) AS REALISASI
                            
                            FROM VISIT_SALES_DISTRIBUTOR_A1 V
                            $sqlAdd
                            $sqlIn
                            GROUP BY V.HARI
                            ORDER BY HARI        
                        ) VISIT ON KALENDER.HARI=VISIT.HARI
                ORDER BY TANGGAL
            ";
            
             /*
                WHERE V.TAHUN='2020'
                            AND V.BULAN='02'
                            --AND V.REGION_ID='3'
                            --AND V.ID_PROVINSI='1021'
                            --AND V.KODE_DISTRIBUTOR='0000000142'
            */
             /*
             $sql = "
                SELECT
                    BULAN_TAHUN.TANGGAL,
                    NVL(DATA_VISIT.Target, 0) AS TARGET,
                    NVL(DATA_VISIT.realisasi, 0) AS REALISASI
                    FROM 
                        (
                            SELECT
                            TO_CHAR(TANGGAL, 'DD') AS TANGGAL
                            FROM CALENDER_CRM
                            WHERE TO_CHAR(TANGGAL, 'YYYY') = '$tahun'
                            AND TO_CHAR(TANGGAL, 'MM') = '$bulan'
                        ) BULAN_TAHUN
                    LEFT JOIN
                        (   
                            Select 
                                hari as tanggal, 
                                sum(total_target) as Target,
                                sum(realisasi) as realisasi 
                            from R_REPORT_VISIT_SALES
                                $sqlAdd
                                $sqlIn
                            group by 
                                hari
                            order by tanggal    
                        ) DATA_VISIT ON BULAN_TAHUN.TANGGAL = DATA_VISIT.tanggal
                    ORDER BY TANGGAL  
            ";
            */
            
            $kunjunganHarian = $this->db->query($sql);
            //echo $this->db->last_query();
            if($kunjunganHarian->num_rows() > 0){
                return $kunjunganHarian->result();
            } else {
                return false;
            }
        }
        
        public function getProject($filterBy = null, $filterSet = null){
            $sqlIn = "";
            if($filterBy != 0){
                if($filterBy == 1){
                    $sqlIn = "AND BB.NEW_REGION = '$filterSet' ";
                } else if ($filterBy == 2){
                    $sqlIn = "AND BB.ID_PROVINSI = '$filterSet' ";
                } else if ($filterBy == 3){
                    
                } else if ($filterBy == 4){
                    $sqlIn = "AND BB.ID_AREA = '$filterSet' ";
                } else if ($filterBy == 5){
                    $sqlIn = "AND BB.ID_DISTRIK = '$filterSet' ";
                }
            }
             
            $sql = "
                SELECT
                    AA.ID_SURVEY_PROJECT,
                    AA.NAMA_PROJECT,
                    AA.ID_KUNJUNGAN_CUSTOMER,
                    AA.VOLUME,
                    AA.START_PROJECT,
                    AA.END_PROJECT,
                    AA.JML_HARI,
                    AA.VOL_HARI,
                    BB.ID_KECAMATAN,
                    BB.ID_DISTRIK,
                    BB.ID_AREA,
                    BB.ID_PROVINSI,
                    BB.NEW_REGION AS ID_REGION
                FROM
                    (
                    SELECT
                        A.*,
                        B.JML_HARI,
                        B.VOL_HARI
                    FROM
                        (
                        SELECT
                            *
                        FROM
                            CRMNEW_SURVEY_PROJECT_TOKO
                        WHERE
                            IS_DELETE = '0' ) A
                    LEFT JOIN (
                        SELECT
                            ID_SURVEY_PROJECT,
                            START_PROJECT,
                            END_PROJECT,
                            END_PROJECT - START_PROJECT + 1 AS JML_HARI,
                            VOLUME / (END_PROJECT - START_PROJECT + 1) AS VOL_HARI
                        FROM
                            CRMNEW_SURVEY_PROJECT_TOKO ) B ON
                        A.ID_SURVEY_PROJECT = B.ID_SURVEY_PROJECT
                    ORDER BY
                        A.ID_SURVEY_PROJECT) AA
                LEFT JOIN (
                    SELECT
                        A.ID_KUNJUNGAN_CUSTOMER,
                        A.ID_USER,
                        B.NAMA_TOKO,
                        B.ID_KECAMATAN,
                        B.ID_DISTRIK,
                        B.ID_AREA,
                        B.ID_PROVINSI,
                        B.NEW_REGION
                    FROM
                        CRMNEW_KUNJUNGAN_CUSTOMER A
                    LEFT JOIN VIEW_DATA_TOKO_CUSTOMER B ON
                        A.ID_TOKO = B.ID_CUSTOMER ) BB ON
                    AA.ID_KUNJUNGAN_CUSTOMER = BB.ID_KUNJUNGAN_CUSTOMER
                WHERE
                    BB.ID_KECAMATAN IS NOT NULL
                    AND BB.ID_DISTRIK IS NOT NULL
                    AND BB.ID_AREA IS NOT NULL
                    AND BB.ID_PROVINSI IS NOT NULL
                    AND BB.NEW_REGION IS NOT NULL
                    $sqlIn
            ";
            
            $result = $this->db->query($sql);
            //echo $this->db->last_query();
            return $result->result_array();
        }
        
        public function getListTanggal($start, $end, $bulan, $tahun){

            $start = date('d-m-Y', strtotime($start));
            $end = date('d-m-Y', strtotime($end));

            $sql = "
                SELECT
                    TODAY,
                    TO_CHAR(TODAY, 'YYYY') AS TAHUN,
                    TO_CHAR(TODAY, 'MM') AS BULAN,
                    TO_CHAR(TODAY, 'DD') AS HARI
                FROM
                    (
                    SELECT
                        TO_DATE('$start', 'DD/MM/YYYY') + LEVEL - 1 AS TODAY
                    FROM
                        DUAL
                    CONNECT BY
                        LEVEL <= TO_DATE('$end', 'DD/MM/YYYY') - TO_DATE('$start', 'DD/MM/YYYY') + 1 )
                WHERE
                    TO_CHAR(TODAY, 'YYYY') = '$tahun'
                    AND TO_CHAR(TODAY, 'MM') = '$bulan'
            ";
            
            $result = $this->db->query($sql);
            return $result->result_array();
            
        }
        
        public function getListWeek($bulan, $tahun){

            $sql = "
                SELECT
                    CAL.TANGGAL,
                    TO_CHAR(CAL.TANGGAL, 'YYYY') AS TAHUN,
                    TO_CHAR(CAL.TANGGAL, 'MM') AS BULAN,
                    TO_CHAR(CAL.TANGGAL, 'DD') AS HARI,
                    CAL.WEEKS
                FROM
                    CALENDER_CRM CAL
                WHERE
                    TO_CHAR( CAL.TANGGAL, 'YYYY' ) = '$tahun'
                    AND TO_CHAR( CAL.TANGGAL, 'MM' ) = '$bulan'
                ORDER BY
                    TO_CHAR(CAL.TANGGAL, 'DD')
            ";
            
            $result = $this->db->query($sql);
            return $result->result_array();
            
        }
        
        public function getDistinctWeek($bulan, $tahun){

            $sql = "
                SELECT
                    DISTINCT(WEEKS)
                FROM
                    (
                    SELECT
                        CAL.TANGGAL,
                        TO_CHAR(CAL.TANGGAL, 'YYYY') AS TAHUN,
                        TO_CHAR(CAL.TANGGAL, 'MM') AS BULAN,
                        TO_CHAR(CAL.TANGGAL, 'DD') AS HARI,
                        CAL.WEEKS
                    FROM
                        CALENDER_CRM CAL
                    WHERE
                        TO_CHAR( CAL.TANGGAL, 'YYYY' ) = '$tahun'
                        AND TO_CHAR( CAL.TANGGAL, 'MM' ) = '$bulan'
                    ORDER BY
                        TO_CHAR(CAL.TANGGAL, 'DD') )
            ";
            
            $result = $this->db->query($sql);
            return $result->result_array();
            
        }
        
        public function GrafikKunjungan($id_jenis_user, $id_user, $bulan, $tahun){
            $sqlAdd = "";
            if($id_jenis_user == "1009"){   //admin
                $sqlAdd = "where v.bulan = '$bulan' and v.tahun = '$tahun'";
            } else if($id_jenis_user == "1012"){    //tso
                $sqlAdd = "where hgsd.id_so = '$id_user' and v.bulan = '$bulan' and v.tahun = '$tahun'";
            } else if($id_jenis_user == "1011"){    //asm
                 $sqlAdd = "where hgsd.id_sm = '$id_user' and v.bulan = '$bulan' and v.tahun = '$tahun'";
            } else if($id_jenis_user == "1010"){    //rsm
                 $sqlAdd = "where hgsd.id_ssm = '$id_user' and v.bulan = '$bulan' and v.tahun = '$tahun'";
            } else if ($id_jenis_user == "1013"){
                 $sqlAdd = "where v.kode_distributor = '$id_user' and v.bulan = '$bulan' and v.tahun = '$tahun'";
            }
            
            /* old query
            $sql = "
                SELECT
                    BULAN_TAHUN.TANGGAL,
                    NVL(DATA_VISIT.Target, 0) AS TARGET,
                    NVL(DATA_VISIT.realisasi, 0) AS REALISASI
                    FROM 
                        (
                            SELECT
                            TO_CHAR(TANGGAL, 'DD') AS TANGGAL
                            FROM CALENDER_CRM
                            WHERE TO_CHAR(TANGGAL, 'YYYY') = '$tahun'
                            AND TO_CHAR(TANGGAL, 'MM') = '$bulan'
                        ) BULAN_TAHUN
                    LEFT JOIN
                        (   
                            Select 
                                hari as tanggal, 
                                sum(total_target) as Target,
                                sum(realisasi) as realisasi 
                            from R_REPORT_VISIT_SALES
                                $sqlAdd
                            group by 
                                hari
                            order by tanggal    
                        ) DATA_VISIT ON BULAN_TAHUN.TANGGAL = DATA_VISIT.tanggal
                    ORDER BY TANGGAL  
            ";
            */
            
            $sql = "
                SELECT
                KALENDER.HARI AS TANGGAL,
                NVL(VISIT.TARGET, 0) AS TARGET,
                NVL(VISIT.REALISASI, 0) AS REALISASI
                FROM 
                        (
                            SELECT
                            TO_CHAR(TANGGAL, 'DD') AS HARI
                            FROM CALENDER_CRM
                            WHERE TO_CHAR(TANGGAL, 'YYYY') ='$tahun'
                            AND TO_CHAR(TANGGAL, 'MM') ='$bulan'
                            ORDER BY HARI
                        ) KALENDER
                LEFT JOIN 
                        (
                            SELECT
                            V.HARI,
                            SUM(V.TARGET) AS TARGET,
                            SUM(V.REALISASI) AS REALISASI
                            
                            FROM VISIT_SALES_DISTRIBUTOR_A1 V
                            left join HIRARCKY_GSM_SALES_DISTRIK hgsd
                                on V.ID_SALES = hgsd.ID_SALES
                            $sqlAdd
                            GROUP BY V.HARI
                            ORDER BY HARI        
                        ) VISIT ON KALENDER.HARI=VISIT.HARI
                ORDER BY TANGGAL
            ";
            
           // echo $sql;
            // exit();
            
            $kunjunganHarian = $this->db->query($sql);
            //echo $this->db->last_query();
            if($kunjunganHarian->num_rows() > 0){
                return $kunjunganHarian->result();
            } else {
                return false;
            }
        }
        
        public function GrafikKunjunganSmi($bulan, $tahun){
            $sql = "
                SELECT
                    BULAN_TAHUN.TANGGAL,
                    NVL(DATA_VISIT.Target, 0) AS TARGET,
                    NVL(DATA_VISIT.realisasi, 0) AS REALISASI
                    FROM 
                        (
                            SELECT
                            TO_CHAR(TANGGAL, 'DD') AS TANGGAL
                            FROM CALENDER_CRM
                            WHERE TO_CHAR(TANGGAL, 'YYYY') = '$tahun'
                            AND TO_CHAR(TANGGAL, 'MM') = '$bulan'
                        ) BULAN_TAHUN
                    LEFT JOIN
                        (   
                            Select 
                                hari as tanggal, 
                                sum(total_target) as Target,
                                sum(realisasi) as realisasi 
                            from R_REPORT_VISIT_SALES_SMI
                                where bulan = '$bulan' and tahun = '$tahun'
                            group by 
                                hari
                            order by tanggal    
                        ) DATA_VISIT ON BULAN_TAHUN.TANGGAL = DATA_VISIT.tanggal
                    ORDER BY TANGGAL  
            ";
            
            $kunjunganHarian = $this->db->query($sql);
            //echo $this->db->last_query();
            if($kunjunganHarian->num_rows() > 0){
                return $kunjunganHarian->result();
            } else {
                return false;
            }
        }
        
        public function userCheckingDist($id_user){
            $sql = "
                SELECT CUD.KODE_DISTRIBUTOR, CD.NAMA_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR CUD
                JOIN CRMNEW_DISTRIBUTOR CD ON CUD.KODE_DISTRIBUTOR = CD.KODE_DISTRIBUTOR
                WHERE CUD.ID_USER = '$id_user'
            ";
            return $this->db->query($sql)->row();
        }
        
        public function getRegion(){
            /*$sql = "
                SELECT DISTINCT(NEW_REGION) AS ID_REGION, NEW_REGION AS REGION FROM R_REPORT_VISIT_SALES
                WHERE NEW_REGION IS NOT NULL
                ORDER BY NEW_REGION ASC
            ";
            */
            $sqlNew = "
                SELECT DISTINCT(REGION_ID) AS ID_REGION, REGION_ID AS REGION FROM WILAYAH_SMI
                WHERE REGION_ID IS NOT NULL
                ORDER BY REGION_ID ASC
            ";
            return $this->db->query($sqlNew)->result();
        }
        
        public function getProvinsi(){
            /*
            $sql = "
                SELECT DISTINCT(ID_PROVINSI) AS ID_PROVINSI, NAMA_PROVINSI FROM R_REPORT_VISIT_SALES
                WHERE ID_PROVINSI IS NOT NULL
                ORDER BY NAMA_PROVINSI ASC
            ";
            */
            $sqlNew = "
                SELECT DISTINCT(ID_PROVINSI) AS ID_PROVINSI, NAMA_PROVINSI FROM WILAYAH_SMI
                WHERE ID_PROVINSI IS NOT NULL
                ORDER BY NAMA_PROVINSI ASC
            ";
            return $this->db->query($sqlNew)->result();
        }
        
        public function getArea(){
            /*
            $sql = "
                SELECT DISTINCT(KD_AREA) AS ID_AREA, NAMA_AREA FROM R_REPORT_VISIT_SALES
                WHERE KD_AREA IS NOT NULL
                ORDER BY NAMA_AREA ASC
            ";
            */
            $sqlNew = "
                SELECT DISTINCT(KD_AREA) AS ID_AREA, NM_AREA AS NAMA_AREA FROM WILAYAH_SMI
                WHERE KD_AREA IS NOT NULL
                ORDER BY KD_AREA ASC
            ";
            return $this->db->query($sqlNew)->result();
        }
        
        public function getDistriK(){
            /*
            $sql = "
                SELECT DISTINCT(KODE_DISTRIBUTOR) AS KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR FROM R_REPORT_VISIT_SALES
                WHERE KODE_DISTRIBUTOR IS NOT NULL
                ORDER BY NAMA_DISTRIBUTOR ASC
            ";
            */
            $sqlNew = "
                SELECT
                    DISTINCT(ID_DISTRIK) AS ID_DISTRIK,
                    NAMA_DISTRIK
                FROM
                    CRMNEW_M_DISTRIK
                WHERE
                    DELETE_MARK = '0'
                    AND ID_PROVINSI != '1000'
                ORDER BY
                    ID_DISTRIK ASC
            ";
            return $this->db->query($sqlNew)->result();
        }
        
        public function populasi_toko_by_provinsi(){
            
            $sql = "
                select
                    sebaran_prov.id_provinsi,
                    sebaran_prov.nama_provinsi,
                    nvl(jml_toko.jml, 0) as populasi_toko,
                    sebaran_prov.new_region
                from
                    (select id_provinsi, nama_provinsi, new_region 
                        from crmnew_m_provinsi
                        where new_region is not null
                        order by new_region, urutan_prov
                    ) sebaran_prov
                left join
                    ( select ID_PROVINSI, nama_provinsi, count(id_customer) as jml 
                        from view_data_toko_customer
                        group by ID_PROVINSI, nama_provinsi
                    ) jml_toko 
                    on jml_toko.id_provinsi = sebaran_prov.id_provinsi
            ";
            
            return $this->db->query($sql)->result();
        }
        
        
    }
?>
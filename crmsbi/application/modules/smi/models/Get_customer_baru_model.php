<?php
    class Get_customer_baru_model extends CI_Model {

        public function __construct(){
            parent::__construct();  
        }

        public function Get_data_customer_baru_smi($tahun, $distributor=null){

            $db_point = $this->load->database("Point", true);

            $sql =" 
                SELECT 
                    CASE GET_TOKO.BULAN
                        WHEN 1 THEN 'Jan'
                        WHEN 2 THEN 'Feb'
                        WHEN 3 THEN 'Mar'
                        WHEN 4 THEN 'Apr'
                        WHEN 5 THEN 'May'
                        WHEN 6 THEN 'Jun'
                        WHEN 7 THEN 'Jul'
                        WHEN 8 THEN 'Aug'
                        WHEN 9 THEN 'Sep'
                        WHEN 10 THEN 'Oct'
                        WHEN 11 THEN 'Nov'
                        WHEN 12 THEN 'Dec'
                    END AS label,
                    GET_TOKO.JML_AKTIF AS VALUE
                FROM 
                    (
                        SELECT
                            DATA_POINT.TAHUN,
                            DATA_POINT.BULAN,
                            COUNT(DATA_POINT.PENJUALAN) AS JML_AKTIF
                            FROM 
                                (
                                    SELECT
                                        MC.KD_CUSTOMER,
                                        MC.NM_CUSTOMER,
                                        MC.NAMA_TOKO,
                                        MC.GROUP_CUSTOMER,
                                        MC.KD_PROVINSI,
                                        MC.ID_AREA,
                                        MC.AREA,
                                        MC.KD_DISTRIK,
                                        MC.NM_DISTRIK,
                                        MC.KECAMATAN,
                                        PU.STATUS AS STATUS_TOKO
                                    FROM M_CUSTOMER MC
                                    LEFT JOIN P_USER PU ON mc.id_customer=pu.id_customer
                                    WHERE PU.STATUS IS NOT NULL
                                ) DATA_CUSTOMER
                            LEFT JOIN 
                                (
                                    SELECT
                                        PP.KD_DISTRIBUTOR,
                                        PP.KD_CUSTOMER,
                                        PP.TAHUN,
                                        PP.BULAN,
                                        PP.PENJUALAN,
                                        PP.PENJUALAN_SP,
                                        PP.STATUS AS STATUS_POINT
                                    FROM P_POIN PP
                                ) DATA_POINT ON DATA_CUSTOMER.KD_CUSTOMER=DATA_POINT.KD_CUSTOMER
                            WHERE DATA_CUSTOMER.STATUS_TOKO IN (0, 1, 2)
                            AND DATA_POINT.PENJUALAN >0
                            AND DATA_POINT.TAHUN='$tahun'
            ";

            if($distributor!=null){
                $sql .= "
                     AND DATA_POINT.KD_DISTRIBUTOR='$distributor'
                ";
            }

            $sql .= "
                            AND DATA_POINT.BULAN<13
                            GROUP BY 
                                DATA_POINT.TAHUN,
                                DATA_POINT.BULAN   
                            ORDER BY DATA_POINT.TAHUN, DATA_POINT.BULAN        
                    ) GET_TOKO
                
            ";

            $hasil = $db_point->query($sql)->result_array();
            if(count($hasil)>0){

                $array = array();
                $isi = '';
                $no=1;
                foreach ($hasil as $h) {
                    if($no<count($hasil)){
                        $isi .= $h['VALUE'].',';
                    }
                    else {
                        $isi .= $h['VALUE'];
                    }
                    $no=$no+1;
                }
                return $isi;
            }
        }

        public function Get_data_customer_tidak_beli_smi($tahun, $distributor=null){

            $db_point = $this->load->database("Point", true);

            $sql =" 
                SELECT 
                    CASE GET_TOKO.BULAN
                        WHEN 1 THEN 'Jan'
                        WHEN 2 THEN 'Feb'
                        WHEN 3 THEN 'Mar'
                        WHEN 4 THEN 'Apr'
                        WHEN 5 THEN 'May'
                        WHEN 6 THEN 'Jun'
                        WHEN 7 THEN 'Jul'
                        WHEN 8 THEN 'Aug'
                        WHEN 9 THEN 'Sep'
                        WHEN 10 THEN 'Oct'
                        WHEN 11 THEN 'Nov'
                        WHEN 12 THEN 'Dec'
                    END AS label,
                    GET_TOKO.JML_AKTIF AS VALUE
                FROM 
                    (
                        SELECT
                            DATA_POINT.TAHUN,
                            DATA_POINT.BULAN,
                            COUNT(DATA_POINT.PENJUALAN) AS JML_AKTIF
                            FROM 
                                (
                                    SELECT
                                        MC.KD_CUSTOMER,
                                        MC.NM_CUSTOMER,
                                        MC.NAMA_TOKO,
                                        MC.GROUP_CUSTOMER,
                                        MC.KD_PROVINSI,
                                        MC.ID_AREA,
                                        MC.AREA,
                                        MC.KD_DISTRIK,
                                        MC.NM_DISTRIK,
                                        MC.KECAMATAN,
                                        PU.STATUS AS STATUS_TOKO
                                    FROM M_CUSTOMER MC
                                    LEFT JOIN P_USER PU ON mc.id_customer=pu.id_customer
                                    WHERE PU.STATUS IS NOT NULL
                                ) DATA_CUSTOMER
                            LEFT JOIN 
                                (
                                    SELECT
                                        PP.KD_DISTRIBUTOR,
                                        PP.KD_CUSTOMER,
                                        PP.TAHUN,
                                        PP.BULAN,
                                        PP.PENJUALAN,
                                        PP.PENJUALAN_SP,
                                        PP.STATUS AS STATUS_POINT
                                    FROM P_POIN PP
                                ) DATA_POINT ON DATA_CUSTOMER.KD_CUSTOMER=DATA_POINT.KD_CUSTOMER
                            WHERE DATA_CUSTOMER.STATUS_TOKO IN (0, 1, 2)
                            AND DATA_POINT.PENJUALAN =0
                            AND DATA_POINT.TAHUN='$tahun'
            ";

            if($distributor!=null){
                $sql .= "
                     AND DATA_POINT.KD_DISTRIBUTOR='$distributor'
                ";
            }

            $sql .= "
                            AND DATA_POINT.BULAN<13
                            GROUP BY 
                                DATA_POINT.TAHUN,
                                DATA_POINT.BULAN   
                            ORDER BY DATA_POINT.TAHUN, DATA_POINT.BULAN        
                    ) GET_TOKO
                
            ";

            $hasil = $db_point->query($sql)->result_array();
            if(count($hasil)>0){

                $array = array();
                $isi = '';
                $no=1;
                foreach ($hasil as $h) {
                    if($no<count($hasil)){
                        $isi .= $h['VALUE'].',';
                    }
                    else {
                        $isi .= $h['VALUE'];
                    }
                    $no=$no+1;
                }
                return $isi;
            }
            
        }

        public function toko_baru_bulanan($tahun, $distributor=null){

            $db_point = $this->load->database("Point", true);

            $sql ="
                SELECT 
                    CASE GET.BULAN
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
                    GET.JML_PERTUMBUHAN AS VALUE
                FROM 
                    (
                        SELECT
                            TO_CHAR(MC.CREATED_AT, 'MM') BULAN, 
                            COUNT(ROWNUM) AS JML_PERTUMBUHAN
                        FROM M_CUSTOMER MC
                        LEFT JOIN P_USER PU ON mc.id_customer=pu.id_customer
                        WHERE PU.STATUS IN (0, 1, 2)
                        AND TO_CHAR(MC.CREATED_AT, 'YYYY')='$tahun'
                        --AND MC.KD_PROVINSI='1025'
            ";
            if($distributor!=null){
                $sql .="  AND MC.NOMOR_DISTRIBUTOR='$distributor' ";
            }
            $sql .= "
                        GROUP BY
                             TO_CHAR(MC.CREATED_AT, 'YYYY'),
                             TO_CHAR(MC.CREATED_AT, 'MM')
                        ORDER BY BULAN
                    ) GET
            ";

            $hasil = $db_point->query($sql)->result_array();
            if(count($hasil)>0){

                $array = array();
                $isi = '';
                $no=1;
                foreach ($hasil as $h) {
                    if($no<count($hasil)){
                        $isi .= $h['VALUE'].',';
                    }
                    else {
                        $isi .= $h['VALUE'];
                    }
                    $no=$no+1;
                }
                return $isi;
            }

        }

        public function toko_baru_tahunan($distributor=null){
            
            $db_point = $this->load->database("Point", true);

            $sql ="
                SELECT
                    TO_CHAR(MC.CREATED_AT, 'YYYY') AS TAHUN, 
                    COUNT(ROWNUM) AS JML_PERTUMBUHAN
                FROM M_CUSTOMER MC
                LEFT JOIN P_USER PU ON mc.id_customer=pu.id_customer
                WHERE PU.STATUS IN (0, 1, 2)
                AND TO_CHAR(MC.CREATED_AT, 'YYYY')<2020
                --AND MC.KD_PROVINSI='1025'
            ";
            if($distributor!=null){
                $sql .="  AND MC.NOMOR_DISTRIBUTOR='$distributor' ";
            }
            $sql .= "    
                GROUP BY
                     TO_CHAR(MC.CREATED_AT, 'YYYY')
                ORDER BY TAHUN
            ";

            return $db_point->query($sql)->result_array();
        }
        

        public function Get_provinsi(){

            $db_point = $this->load->database("Point", true);
            
            $sql ="
                SELECT
                    P.KD_PROVINSI,
                    P.PROVINSI
                FROM M_PROVINSI P 
                WHERE P.KD_FORCA!='-'
            ";
            
            return $db_point->query($sql)->result_array();

        }

        
        
        
    }
?>
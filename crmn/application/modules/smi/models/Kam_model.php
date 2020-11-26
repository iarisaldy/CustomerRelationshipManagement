<?php
    class Kam_model extends CI_Model {

        public function __construct(){
            parent::__construct();  
        }

        public function Get_peringkat_kam($tahun, $bulan){
            $db     = $this->load->database("crm", true);
            
            $sql ="
                SELECT
                    CU.ID_USER,
                    CU.NAMA,
                    UD.KODE_DISTRIBUTOR,
                    D.NAMA_DISTRIBUTOR,
                    NVL(KUNJUNGAN.JML_KUNJUNGAN, 0) AS JML_KUNJUNGAN
                FROM CRMNEW_USER CU
                LEFT JOIN CRMNEW_USER_DISTRIBUTOR UD ON CU.ID_USER= UD.ID_USER
                LEFT JOIN CRMNEW_DISTRIBUTOR D ON UD.KODE_DISTRIBUTOR=D.KODE_DISTRIBUTOR
                LEFT JOIN 
                    (   
                        SELECT 
                            DATA.*
                        FROM (
                                SELECT 
                                KC.ID_USER,
                                COUNT(*) AS JML_KUNJUNGAN 
                                FROM CRMNEW_KUNJUNGAN_CUSTOMER KC
                                WHERE KC.CHECKIN_TIME IS NOT NULL
                                AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY')='$tahun'
                                AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'MM')='$bulan'
                                GROUP BY 
                                    KC.ID_USER
                        ) DATA
                        
                    ) KUNJUNGAN ON CU.ID_USER=KUNJUNGAN.ID_USER
                WHERE CU.ID_JENIS_USER='1005'
                ORDER BY JML_KUNJUNGAN DESC
            ";
            return $db->query($sql)->result_array();

        }
        public function get_detile_kam($id_user, $tahun, $bulan){
            $db     = $this->load->database("crm", true);
            
            $sql ="
                SELECT 
                    TO_CHAR(KC.CHECKIN_TIME, 'DD') AS HARI,
                    COUNT(*) AS JML_KUNJUNGAN 
                FROM CRMNEW_KUNJUNGAN_CUSTOMER KC
                WHERE KC.CHECKIN_TIME IS NOT NULL
                AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY')='$tahun'
                AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'MM')='$bulan'
                AND KC.ID_USER='$id_user'
                GROUP BY 
                    TO_CHAR(KC.CHECKIN_TIME, 'DD')
            ";

            return $db->query($sql)->result_array();
        }
        
        
    }
?>
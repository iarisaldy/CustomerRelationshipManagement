<?php
    class Top_salesforce_model extends CI_Model {

        public function __construct(){
            parent::__construct();  
        }

        public function Get_top_salesforce(){
            $db     = $this->load->database("crm", true);
            
            $sql ="
                SELECT 
                *
                FROM 
                    (
                        SELECT 
                            KC.ID_USER,
                            CU.NAMA,
                            UD.KODE_DISTRIBUTOR,
                            D.NAMA_DISTRIBUTOR,
                            COUNT(ROWNUM) AS JML_KUNJUNGAN
                        FROM CRMNEW_KUNJUNGAN_CUSTOMER KC
                        LEFT JOIN CRMNEW_USER CU ON KC.ID_USER=CU.ID_USER
                        LEFT JOIN CRMNEW_USER_DISTRIBUTOR UD ON UD.ID_USER=KC.ID_USER
                        LEFT JOIN CRMNEW_DISTRIBUTOR D ON UD.KODE_DISTRIBUTOR=D.KODE_DISTRIBUTOR
                        WHERE KC.CHECKIN_TIME IS NOT NULL
                        AND KC.DELETED_MARK=0
                        GROUP BY 
                            KC.ID_USER,
                            CU.NAMA,
                            UD.KODE_DISTRIBUTOR,
                            D.NAMA_DISTRIBUTOR
                        ORDER BY JML_KUNJUNGAN DESC
                    ) DATA_TOP_10
                    WHERE ROWNUM <11
            ";
            return $db->query($sql)->result_array();

        }
        
    }
?>
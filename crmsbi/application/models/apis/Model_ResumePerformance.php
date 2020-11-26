<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_ResumePerformance extends CI_Model {

    	public function kuantumSalesRetail($idCustomer = null, $month = null, $year = null, $lastMonth = null){
    		$this->db_tpl = $this->load->database("marketplace", true);
            $sql = "SELECT
                        KD_TOKO,
                        TO_CHAR(TGL_KIRIM, 'YYYY-MM') AS MONTH,
                        TO_CHAR(TGL_KIRIM, 'MM') AS BULAN,
                        TO_CHAR(TGL_KIRIM, 'YYYY') AS TAHUN,
                        SUM( QTY ) AS KUANTUM 
                    FROM
                        TPL_T_JUAL_DTL_SERVICE 
                    WHERE
                        TO_CHAR( TGL_KIRIM, 'YYYY-MM' ) BETWEEN '$lastMonth' 
                        AND '$year-$month' AND KD_TOKO = '$idCustomer'
                    GROUP BY
                        KD_TOKO,
                        TO_CHAR(TGL_KIRIM, 'MM'),
                        TO_CHAR(TGL_KIRIM, 'YYYY'),
                        TO_CHAR(TGL_KIRIM, 'YYYY-MM')
                    ORDER BY
                        TO_CHAR(TGL_KIRIM, 'YYYY-MM') ASC";
            $kuantumToko = $this->db_tpl->query($sql);
            if($kuantumToko->num_rows() > 0){
                return $kuantumToko->result();
            } else {
                return false;
            }
    	}

    }
?>
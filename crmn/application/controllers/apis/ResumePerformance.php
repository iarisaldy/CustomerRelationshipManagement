<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class ResumePerformance extends Auth {

        public function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_ResumePerformance', 'mResumePerformance');
        }

        public function retail_post(){
            $idCustomer = $this->post("id_customer");
            $month = $this->post("month");
            $year = $this->post("year");

            for ($i =0; $i < 6; $i++) {
                $lastMonth = date("Y-m", strtotime( date($year.'-'.$month.'-01' )." -$i months"));
            }
            
            $kuantumSalesRetail = $this->mResumePerformance->kuantumSalesRetail($idCustomer, $month, $year, $lastMonth);
            if($kuantumSalesRetail){
                foreach ($kuantumSalesRetail as $kuantumSalesRetail_key => $kuantumSalesRetail_value) {
                    $data[] = array(
                        "BULAN" => $kuantumSalesRetail_value->BULAN, 
                        "TAHUN" => $kuantumSalesRetail_value->TAHUN, 
                        "VALUE" => $kuantumSalesRetail_value->KUANTUM
                    );
                }
                $response = array("status" => "success", "total" => count($data), "data" => $data);
            } else {
                $response = array("status" => "error", "message" => "Data penjualan pelanggan tidak ada");
            }
            
            $this->response($response);
        }

    }
?>
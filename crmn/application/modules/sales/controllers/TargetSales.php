<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
    class TargetSales extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Model_TargetSales", "mTargetSales");
        }

        public function index(){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('TargetKpiSales_view', $data);
        }

        public function AddTargetSales(){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('AddTargetSales_view', $data);
        }

        public function detail(){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('DetailTargetSales_view', $data);
        }

        public function listTarget($idDistributor,$bulan, $tahun){
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

            $targetSales = $this->mTargetSales->targetSales($idDistributor, $bulan, $tahun);
            if($targetSales){
                $i=1;
                foreach ($targetSales as $targetSalesKey => $targetSalesValue) {
                    $data[] = array(
                        $i,
                        $targetSalesValue->NAMA_SALES,
                        $targetSalesValue->NAMA_DISTRIBUTOR,
                        str_replace(",",".", number_format($targetSalesValue->VOLUME)),
                        "Rp. ".str_replace(",",".", number_format($targetSalesValue->HARGA)),
                        "Rp. ".str_replace(",",".", number_format($targetSalesValue->REVENUE)),
                        $targetSalesValue->KUNJUNGAN,
                        "<a href='".base_url()."sales/TargetSales/detail/".$targetSalesValue->ID_TARGET_SALES."' class='btn btn-sm btn-warning'>Ubah</a>
                        &nbsp;
                        <button id='btnDelete' data-idtarget='$targetSalesValue->ID_TARGET_SALES' class='btn btn-sm btn-danger'>Hapus</button>"
                    );
                    $i++;
                }
            } else {
                $data[] = array("-","-","-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($targetSales),
                "recordsFiltered" => count($targetSales),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }

        public function detailTargetSales($idTarget){
            $targetSales = $this->mTargetSales->detailTargetSales($idTarget);
            if($targetSales){
                echo json_encode(array("status" => "success", "data" =>  $targetSales));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data detail target sales tidak ada"));
            }
        }

        public function actionAddTarget(){
            $idSales = $this->input->post("id_sales");
            $idDistributor = $this->input->post("id_distributor");
            $bulan = $this->input->post("bulan");
            $tahun = $this->input->post("tahun");
            $volume = $this->input->post("volume");
            $revenue = $this->input->post("revenue");
            $kunjungan = $this->input->post("kunjungan");

            $data = array(
                "ID_SALES" => $idSales,
                "KODE_DISTRIBUTOR" => $idDistributor,
                "BULAN" => $bulan,
                "TAHUN" => $tahun,
                "VOLUME" => $volume,
                "REVENUE" => $revenue,
                "HARGA" => ((int)$revenue / (int)$volume),
                "KUNJUNGAN" => $kunjungan,
                "CREATED_BY" => $this->session->userdata("user_id"),
                "DELETE_MARK" => "0"
            );
            
            $addTarget = $this->mTargetSales->AddTargetSales($data);
            if($addTarget){
                echo json_encode(array("status" => "success", "data" =>  $addTarget));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menambahkan target sales"));
            }
        }

        public function actionUpdateTarget(){
            $idTargetSales = $this->input->post("id_target_sales");
            $idSales = $this->input->post("id_sales");
            $bulan = $this->input->post("bulan");
            $tahun = $this->input->post("tahun");
            $volume = $this->input->post("volume");
            $revenue = $this->input->post("revenue");
            $kunjungan = $this->input->post("kunjungan");

            $data = array(
                "ID_SALES" => $idSales,
                "BULAN" => $bulan,
                "TAHUN" => $tahun,
                "VOLUME" => $volume,
                "REVENUE" => $revenue,
                "HARGA" => ((int)$revenue / (int)$volume),
                "KUNJUNGAN" => $kunjungan,
                "UPDATED_BY" => $this->session->userdata("user_id")
            );
            
            $updateTarget = $this->mTargetSales->updateTarget($idTargetSales, $data);
            if($updateTarget){
                echo json_encode(array("status" => "success", "data" =>  $updateTarget));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa mengubah target sales"));
            }
        }

        public function deleteTarget($idTarget){
            $deleteTarget = $this->mTargetSales->updateTarget($idTarget, array("DELETE_MARK" => "1", "UPDATED_BY" => $this->session->userdata("user_id")));
            if($deleteTarget){
                echo json_encode(array("status" => "success", "data" =>  $deleteTarget));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menghapus target sales"));
            }
        }
    }
?>
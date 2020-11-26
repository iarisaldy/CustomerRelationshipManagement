<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
    class AssignToko extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Model_AssignToko", "mAssignToko");
        }
        
        public function index(){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('AssignTokoSales_view', $data);
        }

        public function listCustomer($idDistributor){
            $customer = $this->mAssignToko->listCustomer($idDistributor);
            echo json_encode(array("status" => "success", "data" => $customer));
        }

        public function listAssign($idDistributor){
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

            $listAssign = $this->mAssignToko->listAssign($idDistributor);
            if($listAssign){
                $i=1;
                foreach ($listAssign as $listAssignKey => $listAssignValue) {
                    $data[] = array(
                        "Salesman : <b>".$listAssignValue->NAMA_SALES."</b>",
                        // $listAssignValue->ID_CUSTOMER,
                        $listAssignValue->NAMA_TOKO,
                        $listAssignValue->KOTA,
                        $listAssignValue->NAMA_KECAMATAN,
                        $listAssignValue->ALAMAT,
                        "<button class='btn btn-sm btn-danger' id='btn-delete-assign' data-idassign='$listAssignValue->ID_ASSIGN_TOKO'>Hapus</button>"
                    );
                    $i++;
                }
            } else {
                $data[] = array("-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($listAssign),
                "recordsFiltered" => count($listAssign),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }

        public function addAssign(){
            $idSales = $this->input->post("id_sales");
            $idCustomer = $this->input->post("id_customer");
            for($i=0;$i<count($idCustomer);$i++){
                $dataAssign = array(
                    "ID_USER" => $idSales,
                    "ID_CUSTOMER" => $idCustomer[$i],
                    "CREATED_BY" => $this->session->userdata("user_id"),
                    "DELETE_MARK" => "0"
                );

                $json[] = $dataAssign;
            }
            
            $assignToko = $this->mAssignToko->addAssign($json);
            if($assignToko){
                echo json_encode(array("status" => "success", "data" =>  $assignToko));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menambahkan assign toko"));
            }
        }

        public function deleteAssign($idAssign){
            $deleteAssign = $this->mAssignToko->deleteAssign($idAssign, array("DELETE_MARK" => "1", "UPDATED_BY" => $this->session->userdata("user_id")));
            if($deleteAssign){
                echo json_encode(array("status" => "success", "data" =>  $deleteAssign));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menghapus assign toko"));
            }
        }
    }
?>
<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
    class AssignToko extends CI_Controller {

        public function __construct(){
            parent::__construct();

            $this->load->model("Assign_toko_model");

        }
		
        
        public function index(){
            $data               = array("title"=>"Dashboard CRM Administrator");
            // $id_user            = $this->session->userdata('user_id');
            // $data['list_sales']  = $this->Assign_toko_model->User_SALES($id_user);
            // print_r($data['list_sales']);
            // exit;
            $this->template->display('assign_toko_sales', $data);
        }
        public function salesTSO(){
            $id_user        = $this->session->userdata('user_id');
            $data           = $this->Assign_toko_model->User_SALES($id_user);
            if($data){
                echo json_encode(array("status" => "success", "data" => $data));
            } else {
                echo json_encode(array("status" => "error", "data" => array()));
            }
        }

        public function listCustomer($tso=null, $sales=null){
            $id_user = $this->session->userdata('user_id');
			
            $customer = $this->Assign_toko_model->Toko_sales_tso($id_user, $sales);

            echo json_encode(array("status" => "success", "data" => $customer));
        }

        public function listAssign(){
            $id_user = $this->session->userdata('user_id');
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

            $listAssign = $this->Assign_toko_model->listAssignSALES($id_user);
			
			// print_r($listAssign);
            if($listAssign){
                $i=1;
                foreach ($listAssign as $listAssignKey => $listAssignValue) {
                    $data[] = array(
                        "Salesman : <b>".$listAssignValue->NAMA_SALES."</b>",
                        // $listAssignValue->ID_CUSTOMER,
                        $listAssignValue->NAMA_TOKO,
                        $listAssignValue->KOTA,
                        $listAssignValue->ALAMAT,
                        "<button class='btn btn-sm btn-danger' id='btn-delete-assign' data-idassign='$listAssignValue->NO_TOKO_SALES'>Hapus</button>"
                    );
                    $i++;
                }
            } else {
                $data[] = array("-","-","-","-","-");
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
            $id_user = $this->session->userdata('user_id');
            $idSales = $this->input->post("id_sales");
            $idCustomer = $this->input->post("id_customer");
			
			$distributor = $this->Assign_toko_model->get_distributor($idSales);
			
            for($i=0;$i<count($idCustomer);$i++){
                $dataAssign = array(
                    "ID_SALES" => $idSales,
                    "KD_CUSTOMER" => $idCustomer[$i],
                    "ID_TSO" => $id_user,
                    "CREATE_BY" => $this->session->userdata("user_id"),
                    "DELETE_MARK" => "0",
					"ID_DISTRIBUTOR" => $distributor,
                );

                $json[] = $dataAssign;
            }
            
            $assignToko = $this->Assign_toko_model->addAssign($json);
            if($assignToko){
                echo json_encode(array("status" => "success", "data" =>  $assignToko));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menambahkan assign toko"));
            }
        }

        public function deleteAssign($idAssign){
            $deleteAssign = $this->Assign_toko_model->deleteAssign($idAssign, array("DELETE_MARK" => "1", "UPDATE_BY" => $this->session->userdata("user_id")));
            if($deleteAssign){
                echo json_encode(array("status" => "success", "data" =>  $deleteAssign));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menghapus assign toko"));
            }
        }
		
		public function test(){
			 $data               = array("title"=>"Dashboard CRM Administrator");
            // $id_user            = $this->session->userdata('user_id');
            // $data['list_sales']  = $this->Assign_toko_model->User_SALES($id_user);
            // print_r($data['list_sales']);
            // exit;
            $this->template->display('form', $data);
		}
    }
?>
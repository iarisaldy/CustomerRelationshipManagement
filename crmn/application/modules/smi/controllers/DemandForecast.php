<?php
	class DemandForecast extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model("Model_DemandForecast", "mDemandForecast");
		}

		public function index(){
			$data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('DemandForecast_view', $data);
		}

		public function updateDemandForecast(){
			$idCustomer = $this->input->post("id_customer");
			$idDistributor = $this->input->post("id_distributor");
			$idAdjSales = $this->input->post("id_adj_sales");
			$adjSales = $this->input->post("adj_sales");

			$data = array(
				"ID_CUSTOMER" => $idCustomer,
				"ADJ_SALES" => $adjSales,
				"KODE_DISTRIBUTOR" => $idDistributor,
				"UPDATED_BY" =>  $this->session->userdata("user_id"),
				"DELETE_MARK" => "0"
			);
			if($idAdjSales != "0"){
				$proses = $this->mDemandForecast->updateAdjSales($data, $idAdjSales);
			} else {
				$proses = $this->mDemandForecast->addAdjSales($data);
			}

			if($proses){
				echo json_encode(array("status" => "success", "data" => $data));
			} else {
				echo json_encode(array("status" => "error", "message" => "gagal menambahkan adj sales"));
			}

		}

		public function dataDemandForecast(){
			$draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));

            $kodeDist = $this->input->post("id_distributor");
            if($kodeDist == ""){
            	$kodeDist = $this->session->userdata("kode_dist");
            }

            $adjSales = $this->mDemandForecast->dataAdjSales($kodeDist);
			$demand = $this->mDemandForecast->dataPenjualanToko($kodeDist);
			if($demand){
				$i=1;
				foreach ($demand as $demandKey => $demandValue) {
					$adjSalesNew = $demandValue->KUANTUM;
					$updatedBy = "";
					$idAdjSales = 0;
					foreach($adjSales as $adjSalesKey => $adjSalesValue){
						if($adjSalesValue->ID_CUSTOMER == $demandValue->ID_CUSTOMER){
							$adjSalesNew = $adjSalesValue->ADJ_SALES;
							$updatedBy = $adjSalesValue->NAMA_UPDATED;
							$idAdjSales = $adjSalesValue->ID_ADJ_SALES;
						}
					}
					$data[] = array(
						$i,
						$demandValue->ID_CUSTOMER,
						$demandValue->NAMA_TOKO,
						$demandValue->NM_DISTRIK,
						str_replace(",", ".", number_format($demandValue->KUANTUM)),
						str_replace(",", ".", number_format($adjSalesNew)),
						$updatedBy,
						'<button id="btnEditAdjust" data-iddistributor="'.$demandValue->KODE_DISTRIBUTOR.'" data-idcustomer="'.$demandValue->ID_CUSTOMER.'" data-idadj="'.$idAdjSales.'" class="btn btn-sm btn-info">Update</button>'
					);
					$i++;
				}
			} else {
				$data[] = array("-","-","-","-","-","-","-","-");
			}

			$output = array(
                "draw" => $draw,
                "recordsTotal" => count($demand),
                "recordsFiltered" => count($demand),
                "data" => $data
            );

            echo json_encode($output);
            exit();

		}

		public function detailDemand($idAdjSales){
			$dataAdj = $this->mDemandForecast->dataAdjSales(null, $idAdjSales);
			if($dataAdj){
				echo json_encode(array("status" => "success", "data" => $dataAdj));
			} else {
				echo json_encode(array("status" => "error", "data" => array()));
			}
		}

	}
?>
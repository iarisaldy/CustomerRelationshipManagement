<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    require APPPATH . '/controllers/apis/Auth.php';

    class TokoAktif extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model("apis/Model_toko_aktif", "mAktif");
        }
		
		public function detailChartActivation_post(){
			$idDistributor = $this->post("id_distributor");
			$idProvinsi = $this->post("id_provinsi");
			$status = $this->post("status");
			
            $data = array();
            $data = $this->mAktif->detailChartActivation($idDistributor, $idProvinsi, $status);
			
            if($data){
				$status = "success";
				// foreach ($clusterToko as $clusterKey => $clusterValue) {
					// $data[] = array(
						// "name" => $clusterValue->NM_DISTRIK,
						// "kd_distrik" => $clusterValue->KD_DISTRIK,
						// "value" => $clusterValue->JUMLAH
					// );	
				// }
			} else {
				$status = "error";
				$data = array();
			}

			$response = array("status" => $status, "total" => count($data), "data" => $data);
			$this->response($response);

            
        }
		
		public function listDetailTrackAktif_post(){
        	$start = $this->post("start");
        	$limit = $this->post("limit");
        	$order = $this->post("order");
        	$sort = $this->post("sort");
        	$idLt = $this->post("id_lt");
        	$idDistributor = $this->post("id_distributor");
        	$namaToko = $this->post("nama_toko");
        	$status = $this->post("status");
        	$idDistrik = $this->post("id_district");
			
			// print_r($_POST);

        	$datas = $this->mAktif->listTrackRecordAktif($start, $limit, $idDistributor, strtoupper($status), $idDistrik, $order, $sort, $idLt, $namaToko);
        	if($datas){
        		$status = "success";
        		// foreach ($listTokoTrackCluster as $key => $value) {
        			// $datas[] = array(
        				// "ID_CUSTOMER" => $value->ID_CUSTOMER,
        				// "KD_CUSTOMER" => $value->ID_CUSTOMER,
        				// "NAMA_TOKO" => $value->NAMA_TOKO,
        				// "DISTRIBUTOR" => $value->DISTRIBUTOR,
        				// "ALAMAT" => $value->ALAMAT_TOKO,
        				// "NAMA_PEMILIK" => $value->NAMA_PEMILIK,
        				// "NAMA_KECAMATAN" => $value->KECAMATAN,
        				// "TYPE_TOKO" => $value->GROUP_CUSTOMER,
        				// "NAMA_LT" => $value->LT
        			// );
        		// }
        	} else {
        		$status = "error";
        		$datas = array();
        	}

        	$this->response(array("status" => $status, "total" => count($datas), "data" => $datas));
        }
		
		public function detailRetailDistrik(){
            $nmDistrik = $this->input->post("nm_distrik");
            $status = $this->input->post("status");

            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

            $data = array();

            $retailDistrik = $this->mAktif->detailRetailDistrik($nmDistrik, $status);
            if($retailDistrik){
                $i=1;
                foreach ($retailDistrik as $retailDistrikKey => $retailDistrikValue) {
                    $data[] = array(
                        $i,
                        $retailDistrikValue->NAMA_TOKO,
                        $retailDistrikValue->NAMA_DISTRIBUTOR,
                        $retailDistrikValue->NAMA_PEMILIK,
                        $retailDistrikValue->KECAMATAN,
                        $retailDistrikValue->ALAMAT,
                        $retailDistrikValue->GROUP_CUSTOMER,
                        $retailDistrikValue->LT
                    );
                    $i++;
                }
            } else {
                $data[] = array("-","-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($retailDistrik),
                "recordsFiltered" => count($retailDistrik),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }

    }
?>
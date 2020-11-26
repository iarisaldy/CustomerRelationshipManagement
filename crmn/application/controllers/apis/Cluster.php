<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    require APPPATH . '/controllers/apis/Auth.php';

    class Cluster extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model("apis/Model_cluster", "mCluster");
        }
		
		public function detailClusterDist_post(){
			$idDistributor = $this->post("id_distributor");
			$cluster = $this->post("cluster_toko");
			$bulan = $this->post("bulan");
			$tahun = $this->post("tahun");
			
			$checkProvDist = $this->mCluster->checkProvDist((int)$idDistributor);
			$clusterToko = $this->mCluster->clusterTokoDistributor($idDistributor, "10".$checkProvDist->ID_PROVINSI, strtoupper($cluster), $bulan, $tahun);
			if($clusterToko){
				$status = "success";
				foreach ($clusterToko as $clusterKey => $clusterValue) {
					$data[] = array(
						"NAME" => $clusterValue->NM_DISTRIK,
						"KD_DISTRIK" => $clusterValue->KD_DISTRIK,
						"VALUE" => $clusterValue->JUMLAH
					);	
				}
			} else {
				$status = "error";
				$data = array();
			}

			$response = array("status" => $status, "total" => count($data), "data" => $data);
			$this->response($response);
		}

		public function detailTrackRecordDistrik_post(){
        	$idDistributor = $this->post("id_distributor");
        	$cluster = $this->post("cluster_toko");
        	$distrik = $this->post("distrik");
			$tahun = $this->post("tahun");

			$checkProvDist = $this->mCluster->checkProvDist((int)$idDistributor);
			$trackRecord = $this->mCluster->trackRecordCluster("10".$checkProvDist->ID_PROVINSI, $idDistributor, strtoupper($cluster), $distrik, $tahun);
            if($trackRecord){
                foreach ($trackRecord as $trackRecordKey => $trackRecordValue) {
                    $data["label"] = str_replace(" ", "", $trackRecordValue->BULAN);
                    $data["value"] = $trackRecordValue->JUMLAH;

                    $dataCluster[] = $data;
                }
            }

            $this->response(array("status" => "success", "total" => count($dataCluster), "data" => $dataCluster));
        }

        public function listDetailTrack_post(){
        	$start = $this->post("start");
        	$limit = $this->post("limit");
        	$order = $this->post("order");
        	$sort = $this->post("sort");
        	$idLt = $this->post("id_lt");
        	$idDistributor = $this->post("id_distributor");
        	$namaToko = $this->post("nama_toko");
        	$cluster = $this->post("cluster");
        	$idDistrik = $this->post("id_district");
        	$month = $this->post("month");
        	$year = $this->post("year");
			
			// print_r($_POST);

        	$checkProvDist = $this->mCluster->checkProvDist((int)$idDistributor);
        	$listTokoTrackCluster = $this->mCluster->listTrackRecordCluster($start, $limit, "10".$checkProvDist->ID_PROVINSI, $idDistributor, strtoupper($cluster), $idDistrik, $month, $year, $order, $sort, $idLt, $namaToko);
        	if($listTokoTrackCluster){
        		$status = "success";
        		foreach ($listTokoTrackCluster as $key => $value) {
        			$datas[] = array(
        				"ID_CUSTOMER" => $value->ID_CUSTOMER,
        				"KD_CUSTOMER" => $value->ID_CUSTOMER,
        				"NAMA_TOKO" => $value->NAMA_TOKO,
        				"DISTRIBUTOR" => $value->DISTRIBUTOR,
        				"ALAMAT" => $value->ALAMAT_TOKO,
        				"NAMA_PEMILIK" => $value->NAMA_PEMILIK,
        				"NAMA_KECAMATAN" => $value->KECAMATAN,
        				"TYPE_TOKO" => $value->GROUP_CUSTOMER,
        				"NAMA_LT" => $value->LT
        			);
        		}
        	} else {
        		$status = "error";
        		$datas = array();
        	}

        	$this->response(array("status" => $status, "total" => count($datas), "data" => $datas));
        }

    }
?>
<?php

    class ClusterRetail extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Model_cluster", "mCluster");
            $this->load->model("Model_region", "mRegion");
        }

        public function clusterProvinsi($idProvinsi, $bulan = null, $tahun = null){
        	$jsonCluster = array();
            $tokoTidakLapor = $this->mCluster->tokoTidakLapor($idProvinsi, $bulan, $tahun);
            $cluster = $this->mCluster->clusterRegion($idProvinsi, $bulan, $tahun);
            $checkProvinsi = $this->mRegion->listProvinsi($idProvinsi);

            if($cluster){
            	$jsonCluster[0]["label"] = "TIDAK ADA PENJUALAN";
            	$jsonCluster[0]["value"] = $tokoTidakLapor->TOTAL;
            	$jsonCluster[0]["color"] = "#212F3C";
                
                foreach ($cluster as $clusterKey => $clusterValue) {
                    if($clusterValue->CLUSTERR == "GOLD"){
                        $value = $clusterValue->JUMLAH;
                        $color = "#D4AF37";
                    } else if($clusterValue->CLUSTERR == "PLATINUM"){
                        $value = $clusterValue->JUMLAH;
                        $color = "#776C6C";
                    } else if($clusterValue->CLUSTERR == "SILVER"){
                        $value = $clusterValue->JUMLAH;
                        $color = "#D0D0D0";
                    } else if($clusterValue->CLUSTERR == "NON CLUSTER") {
                        $value = $clusterValue->JUMLAH;
                        $color = "#2BBE13";
                    } else if($clusterValue->CLUSTERR == "SUPER PLATINUM"){
                        $value = $clusterValue->JUMLAH;
                        $color = "#D35400";
                    } else if($clusterValue->CLUSTERR == "TIDAK ADA PENJUALAN") {
                    	unset($jsonCluster[0]);
                        $value = ($clusterValue->JUMLAH + $tokoTidakLapor->TOTAL);
                        $color = "#212F3C";
                    }

                    $data["label"] = $clusterValue->CLUSTERR;
                    $data["value"] = $value;
                    $data["color"] = $color;

                    array_push($jsonCluster, $data);
                }

                echo json_encode(array("status" => "success", "id_provinsi" => $checkProvinsi[0]->ID_PROVINSI, "provinsi" => $checkProvinsi[0]->NAMA_PROVINSI, "data" => $jsonCluster));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data tidak ada"));
            }
        }

        public function detailClusterProvinsi(){
            $data = array();
            $idProvinsi = $this->input->post("id_provinsi");
            $cluster = $this->input->post("cluster");
            $bulan = $this->input->post("bulan");
            $tahun = $this->input->post("tahun");
            if(str_replace(" ", "", $cluster) == "TIDAKADAPENJUALAN"){
                $detailCluster = $this->mCluster->detailClusterTdkJualProvinsi($idProvinsi, $bulan, $tahun);
            } else {
                $detailCluster = $this->mCluster->detailClusterProvinsi($idProvinsi, $cluster, $bulan, $tahun);
            }
            
            $checkProvinsi = $this->mRegion->listProvinsi($idProvinsi);
            if($detailCluster){
                foreach ($detailCluster as $detailClusterKey => $detailClusterValue) {
                    $data["label"] = $detailClusterValue->NM_DISTRIK;
                    $data["value"] = $detailClusterValue->JUMLAH;
                    $data["link"] = "JavaScript:trendByDistrik('".$checkProvinsi[0]->ID_PROVINSI."','".$cluster."','".$detailClusterValue->NM_DISTRIK.",'".$tahun.")";
                    // $data["link"] = "JavaScript:tableClusterProvinsi('".$checkProvinsi[0]->ID_PROVINSI."','".$detailClusterValue->NM_DISTRIK."','".$cluster."')";

                    $jsonCluster[] = $data;
                }
                echo json_encode(array("status" => "success", "id_provinsi" => $checkProvinsi[0]->ID_PROVINSI, "provinsi" => $checkProvinsi[0]->NAMA_PROVINSI, "data" => $jsonCluster));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data tidak ada"));
            }
        }

        public function tabelTokoCluster(){
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

            $idProvinsi = $this->input->post("id_provinsi");
            $nmDistrik = $this->input->post("nm_distrik");
            $cluster = $this->input->post("cluster");
            $bulan = $this->input->post("bulan");

            $data = array();
            if(str_replace(" ", "", $cluster) == "TIDAKADAPENJUALAN"){
                $retailCluster = $this->mCluster->tabelTokoClusterTdkJual($idProvinsi, $nmDistrik, $bulan);
            } else {
                $retailCluster = $this->mCluster->tabelTokoCluster($idProvinsi, $nmDistrik, $cluster, $bulan);
            }
            
            if($retailCluster){
                $i=1;
                foreach ($retailCluster as $retailClusterKey => $retailClusterValue) {
                    $data[] = array(
                        $i,
                        $retailClusterValue->NAMA_TOKO,
                        $retailClusterValue->NAMA_DISTRIBUTOR,
                        $retailClusterValue->NAMA_PEMILIK,
                        $retailClusterValue->ALAMAT
                    );
                    $i++;
                }
            } else {
                $data[] = array("-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($retailCluster),
                "recordsFiltered" => count($retailCluster),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }

        public function trackRecordCluster(){
            $idProvinsi = $this->input->post("id_provinsi");
            $nmDistrik = $this->input->post("distrik");
            $cluster = $this->input->post("cluster");
            $tahun = $this->input->post("tahun");

            $trackRecord = $this->mCluster->trackRecordCluster($idProvinsi, $cluster, $nmDistrik, $tahun);
            if($trackRecord){
                foreach ($trackRecord as $trackRecordKey => $trackRecordValue) {
                    $data["label"] = $trackRecordValue->BULAN;
                    if(str_replace(" ", "", $cluster) == "TIDAKADAPENJUALAN"){
                        $getTokoTidakLapor = $this->mCluster->getTokoTidakLapor($idProvinsi, $nmDistrik, $trackRecordValue->NUM_BULAN, $tahun);
                        $data["value"] = (int)$trackRecordValue->JUMLAH + (int)$getTokoTidakLapor;
                    } else {
                        $data["value"] = $trackRecordValue->JUMLAH;
                    }
                    
                    $data["link"] = "JavaScript:tableTrackRecord('".$idProvinsi."','".$trackRecordValue->NUMBER_MONTH."','".$cluster."','".$nmDistrik.",'".$tahun.")";

                    $dataTrack[] = $data;
                }
                echo json_encode(array("status" => "success", "data" => $dataTrack));
            } else {
                if(str_replace(" ", "", $cluster) == "TIDAKADAPENJUALAN"){
                    $bulan = date('m');
                    if($bulan == 1){
                        $bulan = 12;
                    } else {
                        $bulan = $bulan - 1;
                    }
                    
                    $begin = new DateTime(date(''.$tahun.'-01-1'));
                    $finish = new DateTime(date(''.$tahun.'-'.$bulan.'-01', strtotime($tahun."-".$bulan."-01")));

                    $end = $finish->modify( '+1 month' );
                    $interval = new DateInterval('P1M');
                    $period = new DatePeriod($begin, $interval, $end);
                    foreach ($period as $key) {
                        $loopDate = date_format($key, 'm');
                        $data["label"] = $loopDate;
                        $getTokoTidakLapor = $this->mCluster->getTokoTidakLapor($idProvinsi, $nmDistrik, $loopDate, $tahun);
                        if($getTokoTidakLapor){
                            $data["value"] = $getTokoTidakLapor;
                        } else {
                            $data["value"] = 0;
                        }
                        $data["link"] = "JavaScript:tableTrackRecord('".$idProvinsi."','".$loopDate."','".$cluster."','".$nmDistrik.",'".$tahun.")";

                        $dataTrack[] = $data;
                    }
                    echo json_encode(array("status" => "success", "data" => $dataTrack));
                } else {
                    echo json_encode(array("status" => "error", "message" => "Data tidak ada"));
                }
            }
        }

        public function tabelTrackRecordDistrik(){
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

            $idProvinsi = $this->input->post("id_provinsi");
            $nmDistrik = $this->input->post("nm_distrik");
            $cluster = $this->input->post("cluster");
            $bulan = $this->input->post("bulan");

            $data = array();
            $tabelTrackRecordDistrik = $this->mCluster->tabelTrackRecordDistrik($idProvinsi, $bulan, $cluster, $nmDistrik);
            if($tabelTrackRecordDistrik){
                $i=1;
                foreach ($tabelTrackRecordDistrik as $tabelTrackRecordKey => $tabelTrackRecordDistrikValue) {
                    $data[] = array(
                        $i,
                        $tabelTrackRecordDistrikValue->NAMA_TOKO,
                        $tabelTrackRecordDistrikValue->DISTRIBUTOR,
                        $tabelTrackRecordDistrikValue->NM_CUSTOMER,
                        $tabelTrackRecordDistrikValue->ALAMAT_TOKO,
                        $tabelTrackRecordDistrikValue->KECAMATAN
                    );
                    $i++;
                }
            } else {
                $data[] = array("-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($tabelTrackRecordDistrik),
                "recordsFiltered" => count($tabelTrackRecordDistrik),
                "data" => $data
            );
            echo json_encode($output);
            exit();

        }

        public function topThreeCluster(){
            $topThree = $this->mCluster->topThreeCluster();
            if($topThree){
                foreach ($topThree as $topThreeKey => $topThreeValue) {
                    $data["ID_CUSTOMER"] = $topThreeValue->ID_CUSTOMER;
                    $data["NAMA_TOKO"] = $topThreeValue->NAMA_TOKO;
                    $data["DISTRIBUTOR"] = $topThreeValue->DISTRIBUTOR;
                    $data["NM_CUSTOMER"] = $topThreeValue->NM_CUSTOMER;
                    $data["NM_DISTRIK"] = $topThreeValue->NM_DISTRIK;
                    $data["ALAMAT_TOKO"] = $topThreeValue->ALAMAT_TOKO;

                    $jsonThree[] = $data;
                }

                echo json_encode(array("status" => "success", "data" => $jsonThree));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data tidak ada"));
            }
        }

        public function tabelTrackRecord(){
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

            $idProvinsi = $this->input->post("id_provinsi");
            $bulan = $this->input->post("bulan");
            $nmDistrik = $this->input->post("nm_distrik");
            $cluster = $this->input->post("cluster");
            $tahun = $this->input->post("tahun");

            $data = array();
            $tabelTrackRecord = $this->mCluster->tabelTrackRecord($idProvinsi, $bulan, $cluster, $nmDistrik, $tahun);
            if($tabelTrackRecord){
                $i=1;
                foreach ($tabelTrackRecord as $tabelTrackRecordKey => $tabelTrackRecordValue) {
                    $data[] = array(
                        $i,
                        $tabelTrackRecordValue->NAMA_TOKO,
                        $tabelTrackRecordValue->DISTRIBUTOR,
                        $tabelTrackRecordValue->NM_CUSTOMER,
                        $tabelTrackRecordValue->KECAMATAN,
                        $tabelTrackRecordValue->ALAMAT_TOKO,
                        $tabelTrackRecordValue->GROUP_CUSTOMER,
                        $tabelTrackRecordValue->LT
                    );
                    $i++;
                }

                if(str_replace(" ", "", $cluster) == "TIDAKADAPENJUALAN"){
                    $tabelTrackTokoTidakLapor = $this->mCluster->tabelTrackTokoTidakLapor($idProvinsi, $nmDistrik, $bulan, $tahun);
                    foreach ($tabelTrackTokoTidakLapor as $tabelTrackTokoTidakLapor_key => $tabelTrackTokoTidakLapor_value) {
                        $data[] = array(
                        $i,
                        $tabelTrackTokoTidakLapor_value->NAMA_TOKO,
                        $tabelTrackTokoTidakLapor_value->DISTRIBUTOR,
                        $tabelTrackTokoTidakLapor_value->NM_CUSTOMER,
                        $tabelTrackTokoTidakLapor_value->KECAMATAN,
                        $tabelTrackTokoTidakLapor_value->ALAMAT_TOKO,
                        $tabelTrackTokoTidakLapor_value->GROUP_CUSTOMER,
                        $tabelTrackTokoTidakLapor_value->LT
                    );
                        $i++;
                    }
                }
            } else {
                $i = 1;
                if(str_replace(" ", "", $cluster) == "TIDAKADAPENJUALAN"){
                    $tabelTrackTokoTidakLapor = $this->mCluster->tabelTrackTokoTidakLapor($idProvinsi, $nmDistrik, $bulan, $tahun);
                    foreach ($tabelTrackTokoTidakLapor as $tabelTrackTokoTidakLapor_key => $tabelTrackTokoTidakLapor_value) {
                        $data[] = array(
                        $i,
                        $tabelTrackTokoTidakLapor_value->NAMA_TOKO,
                        $tabelTrackTokoTidakLapor_value->DISTRIBUTOR,
                        $tabelTrackTokoTidakLapor_value->NM_CUSTOMER,
                        $tabelTrackTokoTidakLapor_value->KECAMATAN,
                        $tabelTrackTokoTidakLapor_value->ALAMAT_TOKO,
                        $tabelTrackTokoTidakLapor_value->GROUP_CUSTOMER,
                        $tabelTrackTokoTidakLapor_value->LT
                    );
                        $i++;
                    }
                } else {
                    $data[] = array("-","-","-","-","-","-","-","-");
                }
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($tabelTrackRecord),
                "recordsFiltered" => count($tabelTrackRecord),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }

    }

?>
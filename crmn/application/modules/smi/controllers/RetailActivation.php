<?php
    class RetailActivation extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Model_region", "mRegion");
            $this->load->model("Model_RetailActivation", "mRetailActivation");
        }

        public function index(){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('RetailActivation_view', $data);
        }

        public function tokoSize(){
            $dataPinMarker = array(
                array("id" => "1010", "x" => "40", "y"=> "20"),
                array("id" => "1011", "x" => "90", "y" => "57"),
                array("id" => "1012", "x" => "80", "y" => "120"),
                array("id" => "1013", "x" => "120", "y" => "100"),
                array("id" => "1014", "x" => "229", "y" => "40"),
                array("id" => "1015", "x" => "135", "y" => "135"),
                array("id" => "1016", "x" => "160", "y" => "160"),
                array("id" => "1017", "x" => "220", "y" => "145"),
                array("id" => "1018", "x" => "120", "y" => "175"),
                array("id" => "1019", "x" => "190", "y" => "190"),
                array("id" => "1020", "x" => "180", "y" => "220"),
                array("id" => "1021", "x" => "210", "y" => "210"),
                array("id" => "1022", "x" => "230", "y" => "240"),
                array("id" => "1023", "x" => "265", "y" => "210"),
                array("id" => "1024", "x" => "268", "y" => "242"),
                array("id" => "1025", "x" => "310", "y" => "240"),
                array("id" => "1026", "x" => "348", "y" => "250"),
                array("id" => "1027", "x" => "400", "y" => "250"),
                array("id" => "1028", "x" => "520", "y" => "280"),
                array("id" => "1029", "x" => "280", "y" => "100"),
                array("id" => "1030", "x" => "360", "y" => "170"),
                array("id" => "1031", "x" => "320", "y" => "140"),
                array("id" => "1032", "x" => "380", "y" => "100"),
                array("id" => "1033", "x" => "340", "y" => "185"),
                array("id" => "1034", "x" => "420", "y" => "145"),
                array("id" => "1035", "x" => "480", "y" => "172"),
                array("id" => "1036", "x" => "470", "y" => "130"),
                array("id" => "1037", "x" => "520", "y" => "80"),
                array("id" => "1038", "x" => "475", "y" => "90"),
                array("id" => "1039", "x" => "600", "y" => "160"),
                array("id" => "1040", "x" => "580", "y" => "90"),
                array("id" => "1041", "x" => "750", "y" => "170"),
                array("id" => "1042", "x" => "670", "y" => "125"),
                array("id" => "1043", "x" => "380", "y" => "40")
            );

            $dataToko = $this->mRetailActivation->tokoSize();
            $dataTotal = $this->mRetailActivation->totalTokoAktif();
            if($dataToko){
                $i = 0;
                foreach ($dataPinMarker as $dataPinMarkerKey => $dataPinMarkerValue) {
                    $idMarker = $dataPinMarker[$dataPinMarkerKey]["id"];
                    $dataX = $dataPinMarker[$dataPinMarkerKey]["x"];
                    $dataY = $dataPinMarker[$dataPinMarkerKey]["y"];
                    
                    $data["id"] = $idMarker;
                    $data["shapeid"] = "circle";
                    $data["x"] = $dataX;
                    $data["y"] = $dataY;
                    $data["alpha"] = 75;
                    foreach ($dataToko as $dataTokoKey => $dataTokoValue) {
                        if($idMarker == $dataTokoValue->ID_PROVINSI){
                            $data["radius"] = round(($dataTokoValue->JUMLAH / $dataTotal->TOTAL) * 100);
                        }
                    }
                    $json[] = $data;
                    $i++;
                }
                
                echo json_encode(array("status" => "success", "items" => $json));
            } else {
                echo json_encode(array("status" => "error", "message" => "data tidak ada"));
            }   
        }

        public function chartRetailActivation(){
            error_reporting(0);
            $data = array();
            $idProvinsi = $this->input->post("provinsi");
            $bulan = $this->input->post("bulan");
            $retail = $this->mRetailActivation->chartActivation($idProvinsi, $bulan);
            $checkProvinsi = $this->mRegion->listProvinsi($idProvinsi);
            if($retail){
                $total = (int)$retail[0]->JML + (int)$retail[1]->JML;
                $prosen = round(($retail[0]->JML / ((int)$retail[0]->JML + (int)$retail[1]->JML)) * 100, 2);
                foreach ($retail as $retailKey => $retailValue) {
                    $data["label"] = $retailValue->STATUS_TOKO;
                    $data["value"] = $retailValue->JML;

                    $jsonChart[] = $data;
                }
                echo json_encode(array(
                    "status" => "success", 
                    "id_provinsi" => $checkProvinsi[0]->ID_PROVINSI, 
                    "provinsi" => $checkProvinsi[0]->NAMA_PROVINSI, 
                    "total" => $total, 
                    "prosen" => $prosen, 
                    "data" => $jsonChart
                ));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data tidak ada"));
            }
        }

        public function detailChartActivation($idProvinsi, $status){
            $data = array();
            $detailActivation = $this->mRetailActivation->detailChartActivation($idProvinsi, $status);
            $checkProvinsi = $this->mRegion->listProvinsi($idProvinsi);
            if($detailActivation){
                foreach ($detailActivation as $detailActivationKey => $detailActivationValue) {
                    $data["link"] = "JavaScript:detailRetailDistrik(".$detailActivationValue->NAMA_DISTRIK.", ".$status.", '$detailActivationValue->NAMA_DISTRIK')";
                    $data["label"] = $detailActivationValue->NAMA_DISTRIK;
                    $data["value"] = $detailActivationValue->JUMLAH;

                    $jsonChart[] = $data;
                }
                echo json_encode(array("status" => "success", "provinsi" => $checkProvinsi[0]->NAMA_PROVINSI, "data" => $jsonChart));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data tidak ada"));
            }

            
        }

        public function detailRetailDistrik(){
            $nmDistrik = $this->input->post("nm_distrik");
            $status = $this->input->post("status");

            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

            $data = array();

            $retailDistrik = $this->mRetailActivation->detailRetailDistrik($nmDistrik, $status);
            if($retailDistrik){
                $i=1;
                foreach ($retailDistrik as $retailDistrikKey => $retailDistrikValue) {
                    $data[] = array(
                        $i,
                        $retailDistrikValue->NAMA_TOKO,
                        $retailDistrikValue->NAMA_DISTRIBUTOR,
                        $retailDistrikValue->NAMA_PEMILIK,
                        $retailDistrikValue->NAMA_KECAMATAN,
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

        
        public function markerProvinsi(){
            $provinsi = $this->mRegion->listProvinsi();
            if($provinsi){
                echo json_encode(array("status" => "success", "data" => $provinsi));
            } else {
                echo json_encode(array("status" => "error", "message" => "data provinsi tidak ada"));
            }
        }

    }
?>
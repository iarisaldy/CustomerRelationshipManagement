<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

    class FilterSurvey extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Model_filter", "mFilter");
        }

        public function salesDistributor($idDistributor){
            $salesDistributor = $this->mFilter->salesDistributor($idDistributor);
            if($salesDistributor){
                echo json_encode(array("status" => "success", "data" =>  $salesDistributor));
            } else {
                echo json_encode(array("status" => "error", "message" =>  "Data Sales Distributor Tidak Ada"));
            }
        }

        public function jenisUser(){
            $jenisUser = $this->mFilter->jenisUser();
            if($jenisUser){
                echo json_encode(array("status" => "success", "data" =>  $jenisUser));
            } else {
                echo json_encode(array("status" => "error", "message" =>  "Data Jenis User Tidak Ada"));
            }
        }

        public function distributor(){
            $distributor = $this->mFilter->distributor();
            if($distributor){
                echo json_encode(array("status" => "success", "data" => $distributor));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data Distributor Tidak Ada"));
            }
        }

        public function ltDistributor($idDistributor){
            $ltDistributor = $this->mFilter->ltDistributor($idDistributor);
            if($ltDistributor){
                echo json_encode(array("status" => "success", "data" => $ltDistributor));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data LT Distributor Tidak Ada"));
            }
        }

        public function area(){
            $area = $this->mFilter->area();
            if($area){
                echo json_encode(array("status" => "success", "data" => $area));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data Area Tidak Ada"));
            }
        }

        public function provinsi(){
            $provinsi = $this->mFilter->provinsi();
            if($provinsi){
                echo json_encode(array("status" => "success", "data" => $provinsi));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data Provinsi Tidak Ada"));
            }
        }

        public function kota($idProvinsi){
            $kota = $this->mFilter->kota($idProvinsi);
            if($kota){
                echo json_encode(array("status" => "success", "data" => $kota));
            } else {
                echo json_encode(array("status" => "success", "data" => array()));
            }
        }

        public function kecamatan(){
            $kecamatan = $this->mFilter->kecamatan();
            if($kecamatan){
                echo json_encode(array("status" => "success", "data" => $kecamatan));
            } else {
                echo json_encode(array("status" => "success", "data" => array()));
            }
        }

        public function merkProduk(){
            $merkProduk = $this->mFilter->merkProduk();
            if($merkProduk){
                echo json_encode(array("status" => "success", "data" => $merkProduk));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data Provinsi Tidak Ada"));
            }
        }
    }
?>
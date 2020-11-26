<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Customer extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("Model_customer", "mCustomer");
        $this->load->model("Model_cluster", "mCluster");
    }

    public function index(){
    	$data = array("title"=>"Dashboard CRM Administrator");
    	$this->template->display('CustomerList_view', $data);
    }

    public function dataCustomer($idDistributor, $idProvinsi = null, $kodeLt = null, $startDate = null, $endDate = null){
        $month = (int)date("m", strtotime($startDate))-2;
        $getProvinsiDist = $this->mCustomer->getProvinsiDist($idDistributor);

        $customer = $this->mCustomer->customer($idDistributor, $idProvinsi, $kodeLt, $startDate, $endDate);
        $idProvinsiDist = (int)"10".$getProvinsiDist->PROVINSI;
        $cluster = $this->mCluster->cluster($idProvinsiDist, $month, null, $kodeLt);
        foreach ($cluster as $clusterKey => $clusterValue) {

            $data["id_customer"] = $clusterValue->ID_CUSTOMER;
            $data["penjualan"] = $clusterValue->PENJUALAN;
            $data["cluster"] = $clusterValue->CLUSTERR;
            foreach ($customer as $customerKey => $customerValue) {
                if($customerValue->ID_CUSTOMER == $clusterValue->ID_CUSTOMER){
                    $data["nama_toko"] = $customerValue->NAMA_TOKO;
                    $data["distributor"] = $customerValue->NAMA_DISTRIBUTOR;
                    $data["nama_pemilik"] = $customerValue->NAMA_PEMILIK;
                    $data["provinsi"] = $customerValue->NAMA_PROVINSI;
                    $data["kota"] = $customerValue->NAMA_DISTRIK;
                    $data["kecamatan"] = $customerValue->NAMA_KECAMATAN;
                    $data["tipe_toko"] = $customerValue->GROUP_CUSTOMER;
                    $data["nama_lt"] = $customerValue->NAMA_LT;
                    $data["alamat"] = $customerValue->ALAMAT;
                    $data["dikunjungi"] = $customerValue->TOTAL_DIKUNJUNGI;
                }
            }
            $json[] = $data;
        }
        return $json;
    }

    public function listCustomer(){
        $idDistributor = $this->input->post("id_distributor");
        $idProvinsi = $this->input->post("id_provinsi");
        $kodeLt = $this->input->post("kode_lt");
        $startDate = $this->input->post("start_date");
        $endDate = $this->input->post("end_date");

        $customer = $this->dataCustomer($idDistributor, $idProvinsi, $kodeLt, $startDate, $endDate);

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $j = 1;
        for ($i=0; $i < count($customer); $i++) { 
            $data[] = array(
                $j,
                $customer[$i]["id_customer"],
                $customer[$i]["nama_toko"],
                $customer[$i]["distributor"],
                $customer[$i]["nama_pemilik"],
                $customer[$i]["provinsi"],
                $customer[$i]["kota"],
                $customer[$i]["kecamatan"],
                $customer[$i]["tipe_toko"],
                $customer[$i]["nama_lt"],
                $customer[$i]["cluster"],
                $customer[$i]["alamat"],
                $customer[$i]["dikunjungi"],
                "<center><button id='btnUpdateTagging' data-idcustomer='".$customer[$i]["id_customer"]."' class='btn btn-sm btn-warning'>Update Tagging</button></center>",
            );
            $j++;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($customer),
            "recordsFiltered" => count($customer),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function getDataCustomer(){
        $idDistributor = $this->input->post("id_distributor");
        $idProvinsi = $this->input->post("id_provinsi");
        $kodeLt = $this->input->post("kode_lt");
        $startDate = $this->input->post("start_date");
        $endDate = $this->input->post("end_date");

        $list = $this->mCustomer->get_datatables($idDistributor, $idProvinsi, $startDate, $endDate, $kodeLt);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $cluster = $this->mCluster->cluster(1025, 10, $field->ID_CUSTOMER);
            if($cluster){
                $clusterToko = $cluster->CLUSTERR;
            } else {
                $clusterToko = "TIDAK ADA PENJUALAN";
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->ID_CUSTOMER;
            $row[] = $field->NAMA_TOKO;
            $row[] = $field->NAMA_DISTRIBUTOR;
            $row[] = $field->NAMA_PEMILIK;
            $row[] = $field->NAMA_PROVINSI;
            $row[] = $field->NAMA_DISTRIK;
            $row[] = $field->NAMA_KECAMATAN;
            $row[] = $field->GROUP_CUSTOMER;
            $row[] = $field->NAMA_LT;
            $row[] = $clusterToko;
            $row[] = $field->ALAMAT;
            $row[] = $field->TOTAL_DIKUNJUNGI;
            $row[] = "<center>
            <button id='btnUpdateTagging' data-idcustomer='".$field->ID_CUSTOMER."' class='btn btn-sm btn-warning'>Update Tagging</button>
            </center>";

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mCustomer->count_all(),
            "recordsFiltered" => $this->mCustomer->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function detailCustomer($idCustomer){
    	$detailCustomer = $this->mCustomer->detailCustomer($idCustomer);
    	if($detailCustomer){
    		echo json_encode(array("status" => "success", "data" => $detailCustomer));
    	} else {
    		echo json_encode(array("status" => "error", "message" => "Data tidak ada"));
    	}
    }

    public function updateTagging(){
    	$idCustomer = $this->input->post("id_customer");
    	$latitude = $this->input->post("latitude");
    	$longitude = $this->input->post("longitude");

    	$checkLocation = $this->mCustomer->detailCustomer($idCustomer);
    	if($checkLocation){
    		$idLokasiCustomer = $checkLocation[0]->ID_LOKASI_CUSTOMER;
    		$dataCustomer = array(
    			"LATITUDE" => $latitude,
    			"LONGITUDE" => $longitude
    		);
    		$updateTagging = $this->mCustomer->updateTagging($idLokasiCustomer, $dataCustomer);
    	} else {
    		$dataCustomer = array(
    			"ID_CUSTOMER" =>  $idCustomer,
    			"LATITUDE" => $latitude,
    			"LONGITUDE" => $longitude,
    			"DELETE_MARK" => "0",
    			"CREATE_BY" => $this->session->userdata("user_id")
    		);
    		$updateTagging = $this->mCustomer->addTagging($dataCustomer);
    	}

    	if($updateTagging){
    		echo json_encode(array("status" => "success", "data" => $updateTagging));
    	} else {
    		echo json_encode(array("status" => "error", "message" => "Gagal mengubah tagging"));
    	}
    }

}

?>
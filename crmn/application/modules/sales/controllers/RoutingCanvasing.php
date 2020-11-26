<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

    class RoutingCanvasing extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Model_RoutingCanvasing", "mRouting");
            $this->load->model("Model_Sales", "mSales");
            $this->load->model("Model_customer", "mCustomer");
        }

        public function index(){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('RoutingCanvasing_view', $data);
        }
        public function kam_sales(){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('hasil_kanvasing_sales', $data);
        }

        public function detail($idKunjungan){
            $data = array("title"=>"Dashboard CRM Administrator");
            $data["canvassing"] = $this->mRouting->detailCanvasing($idKunjungan);
            $data["foto_survey"] = $this->mRouting->fotoSurvey($idKunjungan);
            $this->template->display('CanvasingDetail_view', $data);
        }

        public function searchToko(){
            $toko = $this->input->get("term");
            $data = $this->mCustomer->searchToko($this->session->userdata("kode_dist"), $toko);
            foreach ($data as $key => $value) {
                $json[] = array("id" => $value->ID_CUSTOMER, "text" => $value->ID_CUSTOMER." - ".$value->NAMA_TOKO." - ".$value->ALAMAT);
            }
            echo json_encode($json);
        }

        public function addCanvasing(){
            $idRole = $this->session->userdata("id_jenis_user");
            $idRegion = $this->session->userdata("id_region");
            $idDistributor = $this->session->userdata("kode_dist");
			
			// print_r($this->session->userdata());
			// exit;
            $data = array("title"=>"Dashboard CRM Administrator");
            // login SMI ambil data KAM / AM sesuai region
            if($idRole == "1001" || $idRole == "1005"){
                // jika SMI region II
                if($idRole == "1001"){
                    //$data["sales"] = $this->mSales->listKAM($idRegion);
					$data["sales"] = $this->mSales->Get_data_Sales($idDistributor, $jenis_user='1005');
                } else {
                    //$data["sales"] = $this->mSales->listAM($idRegion);
					$idUser = $this->session->userdata("user_id");
					$data["sales"] = $this->mSales->Get_data_Sales($idDistributor, $jenis_user='1003');
                }
				
					
            // jika login sebagai distributor ambil data sales 
            } else if($idRole == "1002" || $idRole == "1007" || $idRole == "1003"){
                if($idRole == "1003"){
                    $idUser = $this->session->userdata("user_id");
                    // $data["sales"] = $this->mSales->listSales($idDistributor, $idUser);
					 $data["sales"] = $this->mSales->Get_data_Sales($idDistributor, null, $idUser);
                } else {
                    $data["sales"] = $this->mSales->Get_data_Sales($idDistributor, $jenis_user='1003');
					// $this->db->last_query();
			// exit;
                }
            }
            // exit;
			// print_r($data);
			// exit;
            $this->template->display('AddCanvasing_view', $data);
        }
		

        public function updateCanvasing($idKunjungan){
            $idDistributor = $this->session->userdata("kode_dist");

            $data = array("title"=>"Dashboard CRM Administrator");
            $data["sales"] = $this->mSales->listSales($idDistributor);
            $data["canvassing"] = $this->mRouting->detailCanvasing($idKunjungan);
            $this->template->display('UpdateCanvasing_view', $data);
        }

        public function actionAddCanvassing(){
            $plannedDate = $this->input->post("planned_date");
            $idSurveyor = $this->input->post("id_surveyor");
            $idCustomer = $this->input->post("id_customer");
            $keterangan = $this->input->post("keterangan");
            $keteranganLain = $this->input->post("keterangan_lain");

            if($plannedDate == ""){
                echo json_encode(array("status" => "error", "message" => "Tanggal rencana kunjungan harus di pilih"));
                exit();
            }

            if($idSurveyor == ""){
                echo json_encode(array("status" => "error", "message" => "Sales harus di pilih"));
                exit();
            }

            if($idCustomer == ""){
                echo json_encode(array("status" => "error", "message" => "Pelanggan harus di pilih"));
                exit();
            }

            $checkKunjungan = $this->mRouting->checkKunjungan($idSurveyor, $idCustomer, $plannedDate);
            if($checkKunjungan){
                echo json_encode(array("status" => "error", "message" => "Data Kunjungan Sudah Ada, Tambahkan Kunjungan Lain"));
            } else {
                $dataCanvassing = array(
                    "ID_USER" => $idSurveyor,
                    "ID_TOKO" => $idCustomer,
                    "CREATED_BY" => $this->session->userdata("user_id"),
                    "KETERANGAN" => implode(" , ", $keterangan)." , ".$keteranganLain,
                    "DELETED_MARK" => 0);

                $addCanvassing = $this->mRouting->addCanvasing($dataCanvassing, $plannedDate);
                if($addCanvassing){
                    echo json_encode(array("status" => "success", "message" => "berhasil menambahkan jadwal kunjungan"));
                } else {
                    echo json_encode(array("status" => "error", "message" => "gagal menambahkan jadwal kunjungan"));
                }
            }
        }

        public function actionUpdateCanvassing(){
            $idCanvassing = $this->input->post("id_kunjungan_customer");
            $plannedDate = $this->input->post("planned_date");
            $idSurveyor = $this->input->post("id_surveyor");
            $idCustomer = $this->input->post("id_customer");
            $keterangan = $this->input->post("keterangan");

            $dataCanvassing = array(
                "ID_USER" => $idSurveyor,
                "ID_TOKO" => $idCustomer,
                "UPDATED_BY" => $this->session->userdata("user_id"),
                "KETERANGAN" => implode(" , ", $keterangan)
            );

            $deleteCanvassing = $this->mRouting->updateCanvassing($idCanvassing, $dataCanvassing, $plannedDate);
            if($deleteCanvassing){
                echo json_encode(array("status" => "success", "message" => "berhasil mengubah jadwal kunjungan"));
            } else {
                echo json_encode(array("status" => "error", "message" => "gagal mengubah jadwal kunjungan"));
            }
        }

        public function recordCanvasing(){
        	$begin = new DateTime("2018-01-01");
			$finish = new DateTime("2019-01-01");
			$interval = DateInterval::createFromDateString('1 month');
			$period = new DatePeriod($begin, $interval, $finish);
			$kunjungan = $this->mRouting->recordCanvasing();

        	if($kunjungan){
        		foreach ($period as $keys) {
        			$loopDate = date_format($keys, 'm');
        			$data["label"] = $loopDate;
        			foreach ($kunjungan as $key => $value) {
        				if($value->BULAN == $loopDate){
	        				$jumlah = $value->JUMLAH;
        				} else {
        					$jumlah = 0;
        				}
        				
        				$data["value"] = $jumlah;
	        		}
	        		
	        		$json[] = $data;
        		}
        		echo json_encode(array("dataset" => $json));
        	}
        }

        public function listCustomer(){
            $idUser = $this->input->post("id_user");
            
            $idArea = $this->input->post("id_area");
			$idDistributor = $this->session->userdata('kode_dist');
			if($idDistributor!=null || $idDistributor!=''){
				$idDistributor = $this->input->post("id_distributor");
			}
			// print_r($this->session->userdata('kode_dist'));
			
			// exit;
            // $getAssignToko = $this->mCustomer->assignToko($idUser);
            // if($getAssignToko){
                // $customer = $getAssignToko;
            // } else {
                $customer = $this->mCustomer->listCustomer($idDistributor, $idArea);   
            // }
         
            if($customer){
                echo json_encode(array("status" => "success", "data" => $customer));
            } else {
                echo json_encode(array("status" => "error", "data" => array()));
            }
        }

        public function listCanvassing_dua(){
            $data = array();

            $posisi = $this->input->post("posisi");
            $distributor = $this->input->post("distributor");
            $provinsi = $this->input->post("provinsi");
            $startDate = $this->input->post("start_date");
            $endDate = $this->input->post("end_date");
            $salesDistributor = $this->input->post("sales_distributor");

            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));
            // login sebagai sales
            if($this->session->userdata("id_jenis_user") == "1005" ) {
                $routingCanvasing = $this->mRouting->listCanvasing(NULL, NULL, $this->session->userdata("kode_dist"), $startDate, $endDate, NULL, $provinsi, $salesDistributor);
            } else {
                $routingCanvasing = $this->mRouting->listCanvasing(NULL, NULL, $distributor, $startDate, $endDate, $posisi, $provinsi, NULL);
            }
            
            if($routingCanvasing){
                $i = 1;
                foreach ($routingCanvasing as $routingCanvasingKey => $routingCanvasingValue) {
                    // echo $i."=".$routingCanvasingValue->CHECKOUT_TIME."<br/>";
                    if($routingCanvasingValue->CHECKIN_TIME != NULL){
                        if($routingCanvasingValue->CHECKOUT_TIME == ""){ 
                            $notif = "<span class='label label-info'>Belum Checkout</span>";
                            $button = "<center><a href=".base_url('sales/RoutingCanvasing/detail')."/".$routingCanvasingValue->ID_KUNJUNGAN_CUSTOMER." class='btn btn-sm btn-info'><i class='fa fa-info'></i> Detail</a></center>";
                        } else {
                            $notif = "<span class='label label-success'>Dikunjungi</span>";
                            $button = "<center><a href=".base_url('sales/RoutingCanvasing/detail')."/".$routingCanvasingValue->ID_KUNJUNGAN_CUSTOMER." class='btn btn-sm btn-info'><i class='fa fa-info'></i> Detail</a></center>";
                        }
                    } else {
                        $startDate = new DateTime($routingCanvasingValue->TGL_RENCANA_FORMAT_NEW);
                        $endDate = new DateTime(date('Y-m-d'));
                        $interval = $startDate->diff($endDate);
                        if($interval->days >= 3){
                            $notif = "<span class='label label-danger'>Kunjungan Tidak Dikunjungi > 3 Hari</span>"; 
                        } else {
                            $notif = "<span class='label label-warning'>Belum Dikunjungi</span>";   
                        }

                        if($this->session->userdata("id_jenis_user") == "1001" || $this->session->userdata("id_jenis_user") == "1002" || $this->session->userdata("id_jenis_user") == "1007" || $this->session->userdata("id_jenis_user") == "1005" ){    
                            $button = "<center>
                            <button id='btnUpdateCanvassing' data-kunjungan='".$routingCanvasingValue->ID_KUNJUNGAN_CUSTOMER."' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i> Update</button>
                            &nbsp;
                            <button id='btnDeleteCanvassing' data-kunjungan='".$routingCanvasingValue->ID_KUNJUNGAN_CUSTOMER."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> Delete</button> 
                            </center>";
                        } else {
                            $button = "";
                        }
                        
                    }

                    $data[]  = array(
                        $i,
                        strtoupper($routingCanvasingValue->NAMA),
                        $routingCanvasingValue->JENIS_USER,
                        $routingCanvasingValue->NAMA_DISTRIBUTOR,
                        $routingCanvasingValue->NAMA_TOKO,
                        $routingCanvasingValue->TGL_RENCANA_KUNJUNGAN,
                        $routingCanvasingValue->CHECKIN_TIME,
                        round($routingCanvasingValue->SELISIH, 2),
                        $notif,
                        strtoupper(str_replace("lain-lain ,", "", $routingCanvasingValue->KETERANGAN)),
                        $routingCanvasingValue->NAMA_ASSIGN,
                        $button
                    );
                $i++;
                }
            } else {
                $data[] = array("-","-","-","-","-","-","-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($routingCanvasing),
                "recordsFiltered" => count($routingCanvasing),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }
        public function listCanvassing(){
            $data = array();

            $posisi = $this->input->post("posisi");
            $distributor = $this->input->post("distributor");
            $provinsi = $this->input->post("provinsi");
            $startDate = $this->input->post("start_date");
            $endDate = $this->input->post("end_date");
            $salesDistributor = $this->input->post("sales_distributor");

            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));
            // login sebagai sales
            if($this->session->userdata("id_jenis_user") == "1003" ){
                $idUser = $this->session->userdata("user_id", NULL, NULL, $startDate, $endDate);
                $routingCanvasing = $this->mRouting->listCanvasing($idUser, NULL, NULL, $startDate, $endDate, NULL, $provinsi, NULL);
            // login sebagai distributor
            } else if($this->session->userdata("id_jenis_user") == "1002" || $this->session->userdata("id_jenis_user") == "1007" || $this->session->userdata("id_jenis_user") == "1005") {
                $routingCanvasing = $this->mRouting->listCanvasing(NULL, NULL, $this->session->userdata("kode_dist"), $startDate, $endDate, NULL, $provinsi, $salesDistributor);
            } else {
                $routingCanvasing = $this->mRouting->listCanvasing(NULL, NULL, $distributor, $startDate, $endDate, $posisi, $provinsi, NULL);
            }
            
            if($routingCanvasing){
                $i = 1;
                foreach ($routingCanvasing as $routingCanvasingKey => $routingCanvasingValue) {
                	// echo $i."=".$routingCanvasingValue->CHECKOUT_TIME."<br/>";
                	if($routingCanvasingValue->CHECKIN_TIME != NULL){
                		if($routingCanvasingValue->CHECKOUT_TIME == ""){ 
                			$notif = "<span class='label label-info'>Belum Checkout</span>";
                			$button = "<center><a href=".base_url('sales/RoutingCanvasing/detail')."/".$routingCanvasingValue->ID_KUNJUNGAN_CUSTOMER." class='btn btn-sm btn-info'><i class='fa fa-info'></i> Detail</a></center>";
                		} else {
	                        $notif = "<span class='label label-success'>Dikunjungi</span>";
	                        $button = "<center><a href=".base_url('sales/RoutingCanvasing/detail')."/".$routingCanvasingValue->ID_KUNJUNGAN_CUSTOMER." class='btn btn-sm btn-info'><i class='fa fa-info'></i> Detail</a></center>";
                    	}
                    } else {
                        $startDate = new DateTime($routingCanvasingValue->TGL_RENCANA_FORMAT_NEW);
                        $endDate = new DateTime(date('Y-m-d'));
                        $interval = $startDate->diff($endDate);
                        if($interval->days >= 3){
                            $notif = "<span class='label label-danger'>Kunjungan Tidak Dikunjungi > 3 Hari</span>"; 
                        } else {
                            $notif = "<span class='label label-warning'>Belum Dikunjungi</span>";   
                        }

                        if($this->session->userdata("id_jenis_user") == "1001" || $this->session->userdata("id_jenis_user") == "1002" || $this->session->userdata("id_jenis_user") == "1007" || $this->session->userdata("id_jenis_user") == "1005" ){    
                            $button = "<center>
                            <button id='btnUpdateCanvassing' data-kunjungan='".$routingCanvasingValue->ID_KUNJUNGAN_CUSTOMER."' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i> Update</button>
                            &nbsp;
                            <button id='btnDeleteCanvassing' data-kunjungan='".$routingCanvasingValue->ID_KUNJUNGAN_CUSTOMER."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> Delete</button> 
                            </center>";
                        } else {
                            $button = "";
                        }
                        
                    }

                    $data[]  = array(
                        $i,
                        strtoupper($routingCanvasingValue->NAMA),
                        $routingCanvasingValue->JENIS_USER,
                        $routingCanvasingValue->NAMA_DISTRIBUTOR,
                        $routingCanvasingValue->NAMA_TOKO,
                        $routingCanvasingValue->TGL_RENCANA_KUNJUNGAN,
                        $routingCanvasingValue->CHECKIN_TIME,
                        round($routingCanvasingValue->SELISIH, 2),
                        $notif,
                        strtoupper(str_replace("lain-lain ,", "", $routingCanvasingValue->KETERANGAN)),
                        $routingCanvasingValue->NAMA_ASSIGN,
                        $button
                    );
                $i++;
                }
            } else {
                $data[] = array("-","-","-","-","-","-","-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($routingCanvasing),
                "recordsFiltered" => count($routingCanvasing),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }

        public function deleteCanvassing(){
            $idCanvassing = $this->input->post("id_kunjungan_customer");
            $dataCanvassing = array(
                "UPDATED_BY" => $this->session->userdata("user_id"),
                "DELETED_MARK" => 1
            );

            $deleteCanvassing = $this->mRouting->updateCanvassing($idCanvassing, $dataCanvassing);
            if($deleteCanvassing){
                echo json_encode(array("status" => "success", "message" => "berhasil menghapus jadwal kunjungan"));
            } else {
                echo json_encode(array("status" => "error", "message" => "gagal menghapus jadwal kunjungan"));
            }
        }

        public function isianSurveyKunjungan($idKunjungan){
            $data = array();
            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));

            $isianSurvey = $this->mRouting->isianSurveyKunjungan($idKunjungan);
            if($isianSurvey){
                $i=1;
                foreach ($isianSurvey as $isianSurveyKey => $isianSurveyValue) {

                	$membatu = ($isianSurveyValue->SEMEN_MENBATU == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $kantong_tdk_kuat = ($isianSurveyValue->KANTONG_TIDAK_KUAT == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $semen_terlambat = ($isianSurveyValue->SEMEN_TERLAMBAT_DATANG == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $harga_tdk_stabil = ($isianSurveyValue->HARGA_TIDAK_STABIL == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $semen_rusak = ($isianSurveyValue->SEMEN_RUSAK_SAAT_DITERIMA == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $top_kurang = ($isianSurveyValue->TOP_KURANG_LAMA == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $pemesanan_sulit = ($isianSurveyValue->PEMESANAN_SULIT == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $komplain = ($isianSurveyValue->KOMPLAIN_SULIT == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $stok_kosong = ($isianSurveyValue->STOK_SERING_KOSONG == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $prosedur = ($isianSurveyValue->PROSEDUR_RUMIT == "Y" ? "<i class='fa fa-check'></i>" : "");

                    $data[] = array(
                        $i,
                        $isianSurveyValue->NAMA_PRODUK,
                        "Rp ".str_replace(",", ".", number_format($isianSurveyValue->HARGA_PENJUALAN)),
                        "Rp ".str_replace(",", ".", number_format($isianSurveyValue->HARGA_PEMBELIAN)),
                        $isianSurveyValue->TOP_PEMBELIAN,
                        $isianSurveyValue->STOK_SAAT_INI,
                        $isianSurveyValue->VOLUME_PENJUALAN,
                        $isianSurveyValue->VOLUME_PEMBELIAN,
                        $membatu,
                        $semen_terlambat,
                        $kantong_tdk_kuat,
                        $harga_tdk_stabil,
                        $semen_rusak,
                        $top_kurang,
                        $pemesanan_sulit,
                        $komplain,
                        $stok_kosong,
                        $prosedur,
                        $isianSurveyValue->BONUS_SEMEN,
                        $isianSurveyValue->BONUS_WISATA,
                        $isianSurveyValue->POINT_REWARD,
                        "Rp ".str_replace(",", ".", number_format($isianSurveyValue->VOUCER)),
                        "Rp ".str_replace(",", ".", number_format($isianSurveyValue->POTONGAN_HARGA))
                    );
                    $i++;
                }
                
            } else {
                $data[] = array("-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($isianSurvey    ),
                "recordsFiltered" => count($isianSurvey),
                "data" => $data
            );
            echo json_encode($output);
            exit();

        }
    }
?>
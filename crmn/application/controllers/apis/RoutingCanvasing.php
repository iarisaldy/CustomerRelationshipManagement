<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class RoutingCanvasing extends Auth {

        public function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/M_routing_canvasing', 'mRouting');
        }
		
		public function salesDistributor_post(){
            $start = $this->input->post("start");
            $limit = $this->input->post("limit");
            $idDistributor = $this->input->post("id_distributor");
            $namaSales = $this->input->post("nama_sales");
            $data = $this->mRouting->salesDistributor($idDistributor, $start, $limit, $namaSales);
			
			if($data){
                $response = array("status" => "success", "total" => count($data), "data" => $data);
            } else {
                $response = array("status" => "error", "message" => "Data Sales Distributor Tidak Ada");
            }
            
            $this->response($response);
        }

        public function listRoutingCanvassing_post(){
            $start = $this->post("start");
            $limit = $this->post("limit");
            $jenisOrder = $this->post("jenis_order");
            $order = $this->post("order");
            $idDistributor = $this->post("id_distributor");
            $idProvinsi = $this->post("id_provinsi");
            $startDate = $this->post("tgl_awal");
            $endDate = $this->post("tgl_akhir");
            $idSales = $this->post("id_sales");
            $namaToko = $this->post("nama_toko");

            $dataCanvassing = $this->mRouting->dataCanvassing($start, $limit, $idDistributor, $startDate, $endDate, $idProvinsi, $idSales, $namaToko, $jenisOrder, $order);
            if($dataCanvassing){
                $status = "success";
                foreach ($dataCanvassing as $key => $value) {
                    if($value->TGL_KUNJUNGAN != NULL && $value->CHECKOUT_TIME != NULL){
                        $statusKunjungan = "Dikunjungi";
                    } else if($value->TGL_KUNJUNGAN != NULL && $value->CHECKOUT_TIME == NULL){
                        $statusKunjungan = "Belum Checkout";
                    } else {
                        $statusKunjungan = "Belum Dikunjungi";
                    }

                    $data[] = array(
                    	"ID_KUNJUNGAN_CUSTOMER" => $value->ID_KUNJUNGAN_CUSTOMER,
                        "ID_USER" => $value->ID_USER,
                        "SURVEYOR" => $value->SURVEYOR,
                        "POSISI" => $value->POSISI,
                        "KODE_CUSTOMER" => $value->KODE_CUSTOMER,
                        "NAMA_TOKO" =>  $value->NAMA_TOKO,
                        "ALAMAT" => $value->ALAMAT,
                        "NAMA_PEMILIK" => $value->NAMA_PEMILIK,
                        "NOKTP_PEMILIK" => $value->NOKTP_PEMILIK,
                        "KAPASITAS_TOKO" => $value->KAPASITAS_TOKO,
                        "TELP_TOKO" => $value->TELP_TOKO,
                        "TELP_PEMILIK" => $value->TELP_PEMILIK,
                        "NAMA_PROVINSI" => $value->NAMA_PROVINSI,
                        "NAMA_DISTRIK" => $value->NAMA_DISTRIK,
                        "NAMA_AREA" => $value->NAMA_AREA,
                        "NAMA_KECAMATAN" => $value->NAMA_KECAMATAN,
                        "TGL_RENCANA_KUNJUNGAN" => $value->TGL_RENCANA_KUNJUNGAN,
                        "TGL_KUNJUNGAN" => $value->TGL_KUNJUNGAN,
                        "CHECKOUT_TIME" => $value->CHECKOUT_TIME,
                        "DURASI_KUNJUNGAN" => round($value->DURASI_KUNJUNGAN, 2),
                        "KETERANGAN_KUNJUNGAN" => $value->KETERANGAN_KUNJUNGAN,
                        "STATUS" => $statusKunjungan,
                        "ASIGN" => $value->ASIGN
                    );
                }
            } else {
                $status = "error";
                $data = array();
            }

            // $orderBy = array();
            // foreach ($data as $kunjungan) {
            //     $orderBy[] = $kunjungan[$jenisOrder];
            // }

            // if($order == "ASC"){
            //     array_multisort($orderBy, SORT_ASC, $data);
            // } else {
            //     array_multisort($orderBy, SORT_DESC, $data);
            // }

            $this->response(array("status" => $status, "total" => count($data), "data" => $data));
        }

        public function listCanvasing_post(){
            $data = array();

            $posisi = $this->input->post("posisi");
            $distributor = $this->input->post("distributor");
            $provinsi = $this->input->post("provinsi");
            $startDate = $this->input->post("start_date");
            $endDate = $this->input->post("end_date");
            $salesDistributor = $this->input->post("sales_distributor");
			
            $data = $this->mRouting->listCanvasing($distributor, $startDate, $endDate, $posisi, $provinsi, NULL);
			
            if($data){
                $response = array("status" => "success", "total" => count($data), "data" => $data);
            } else {
                $response = array("status" => "error", "message" => "Data penjualan pelanggan tidak ada");
            }
            
            $this->response($response);
        }
		
		public function getProvinsiDist_post(){
			$idDistributor = $this->input->post("id_distributor");
			$getProvinsiDist = $this->mRouting->getProvinsiDist($idDistributor);
			$idProvinsiDist = (int)"10".$getProvinsiDist->PROVINSI;
            $response = array("status" => "success", "data" => $idProvinsiDist);
			
            $this->response($response);
		}

		public function detailCanvassing_post(){
			$idSales = $this->post("id_sales");
			$idKunjungan = $this->post("id_kunjungan");

			$canvassing = $this->mRouting->detailCanvassing($idSales, $idKunjungan);
			$produkSurvey = $this->mRouting->produkSurvey($idSales, $idKunjungan);
			$photoSurvey = $this->mRouting->photoSurvey($idSales, $idKunjungan);
			if($canvassing){
				foreach ($canvassing as $canvassingKey => $canvassingValue) {
					$dataCanvassing = array(
						"SURVEYOR" => $canvassingValue->SURVEYOR,
						"CUSTOMER" => $canvassingValue->CUSTOMER,
						"PEMILIK" => $canvassingValue->PEMILIK,
						"TGL_KUNJUNGAN" => $canvassingValue->TGL_KUNJUNGAN,
						"DURASI_KUNJUNGAN" => $canvassingValue->DURASI_KUNJUNGAN,
						"CHECKIN_TIME" => $canvassingValue->CHECKIN_TIME,
						"CHECKOUT_TIME" => $canvassingValue->CHECKOUT_TIME,
						"CHECKIN_LATITUDE" => $canvassingValue->CHECKIN_LATITUDE,
						"CHECKIN_LONGITUDE" => $canvassingValue->CHECKIN_LONGITUDE,
						"CHECKOUT_LATITUDE" => $canvassingValue->CHECKOUT_LATITUDE,
						"CHECKOUT_LONGITUDE" => $canvassingValue->CHECKOUT_LONGITUDE,
						"KOTA" => $canvassingValue->KOTA,
						"KECAMATAN" => $canvassingValue->KECAMATAN,
						"ALAMAT" => $canvassingValue->ALAMAT
					);
				}
			} else {
				$dataCanvassing = array();
			}

			if($produkSurvey){
				foreach ($produkSurvey as $produkSurveyKey => $produkSurveyValue) {
					$dataProdukSurvey[] = array(
						"ID_PRODUK" => $produkSurveyValue->ID_PRODUK,
						"PRODUK" => $produkSurveyValue->PRODUK
					);
				}
			} else {
				$dataProdukSurvey = array();
			}

			if($photoSurvey){
				foreach ($photoSurvey as $photoSurveyKey => $photoSurveyValue) {
					$dataPhotoSurvey[] = array(
						"URL_PATH" => $photoSurveyValue->URL_PATH
					);
				}
			} else {
				$dataPhotoSurvey = array();
			}

			$this->response(
				array(
					"status" => "success", 
					"data" => array(
						"DATA_CANVASING" => $dataCanvassing, 
						"PRODUK_SURVEY" => $dataProdukSurvey, 
						"PHOTO_SURVEY" => $dataPhotoSurvey
					)
				)
			);
		}

		public function detailProduct_post(){
			$idProduk = $this->post("id_produk");
			$idKunjungan = $this->post("id_kunjungan");

			$surveyProduk = $this->mRouting->surveyProduk($idProduk, $idKunjungan);
			$surveyKeluhan = $this->mRouting->surveyKeluhan($idProduk, $idKunjungan);
			$surveyPromosi = $this->mRouting->surveyPromosi($idProduk, $idKunjungan);

			if($surveyProduk){
				foreach($surveyProduk as $produkKey => $produkValue){
					$dataProduk = array(
						"TGL_PEMBELIAN" => $produkValue->TGL_PEMBELIAN,
						"NAMA_PRODUK" => $produkValue->NAMA_PRODUK,
						"HARGA_PEMBELIAN" => $produkValue->HARGA_BELI,
						"HARGA_PENJUALAN" => $produkValue->HARGA_JUAL,
						"TOP_PEMBELIAN" => $produkValue->TOP,
						"KAPASITAS_TOKO" => $produkValue->KAPASITAS_TOKO,
						"STOK_SAAT_INI" =>  $produkValue->STOK,
						"VOLUME_PENJUALAN" => $produkValue->VOLUME_JUAL,
						"VOLUME_PEMBELIAN" => $produkValue->VOLUME_BELI
					);
				}
			} else {
				$dataProduk = array();
			}

			if($surveyKeluhan){
				foreach ($surveyKeluhan as $keluhanKey => $keluhanValue) {
					$dataKeluhan[] = array(
						"ID_SURVEY_KELUHAN" => $keluhanValue->ID_SURVEY_KELUHAN,
						"KELUHAN" => $keluhanValue->NAMA_KELUHAN,
						"JAWABAN" => $keluhanValue->JAWABAN
					);
				}
			} else {
				$dataKeluhan[] = array();
			}

			if($surveyPromosi){
				foreach ($surveyPromosi as $promosiKey => $promosiValue) {
					$dataPromosi[] = array(
						"ID_SURVEY_PROMOSI" => $promosiValue->ID_SURVEY_PROMOSI,
						"PROMOSI" => $promosiValue->NAMA_PROMOSI,
						"JAWABAN" => $promosiValue->JAWABAN
					);
				}
			} else {
				$dataPromosi[] = array();
			}

			$this->response(
				array(
					"status" => "success", 
					"data" => array(
						"SURVEY_PRODUK" => $dataProduk, 
						"KELUHAN" => $dataKeluhan, 
						"PROMOSI" => $dataPromosi
					)
				)
			);
		}

    }
?>
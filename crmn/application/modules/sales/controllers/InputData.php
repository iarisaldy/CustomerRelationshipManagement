<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
    class InputData extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Model_product", "mProduct");
            $this->load->model("Model_RoutingCanvasing", "mRouting");
            $this->load->model("Model_survey", "mSurvey");
            $this->load->model("Model_keluhan", "mKeluhan");
            $this->load->model("Model_promosi", "mPromosi");
        }

        public function surveyToko(){
            $idUser = $this->session->userdata("user_id");
            $data = array("title"=>"Dashboard CRM Administrator");
            $data["product"] = $this->mProduct->listProduct();
            $data["canvasing"] = $this->mRouting->listCanvasing($idUser, "Y");
            $this->template->display('InputSurvey_view', $data);
        }

        public function addSurveyToko(){
            $idKunjungan = $this->input->post("id_kunjungan");
            $idProduk = $this->input->post("id_produk");
            $idToko = $this->input->post("id_toko");
            $stok = $this->input->post("stok");
            $hargaBeli = $this->input->post("harga_beli");
            $hargaJual = $this->input->post("harga_jual");
            $top = $this->input->post("top");
            $tglBeli = $this->input->post("tgl_beli");
            $volBeli = $this->input->post("vol_beli");
            $volJual = $this->input->post("vol_jual");

            $dataSurvey = array(
                "ID_KUNJUNGAN_CUSTOMER" => $idKunjungan,
                "ID_PRODUK" => $idProduk,
                "ID_TOKO" => $idToko,
                "ID_USER" => $this->session->userdata("user_id"),
                "STOK_SAAT_INI" => $stok,
                "VOLUME_PEMBELIAN" => $volBeli,
                "HARGA_PEMBELIAN" => $hargaBeli,
                "TOP_PEMBELIAN" => $top,
                "VOLUME_PENJUALAN" => $volJual,
                "HARGA_PENJUALAN" => $hargaJual,
                "CREATE_BY" => $this->session->userdata("user_id"),
                "DELETE_MARK" => 0
            );

            
            $survey = $this->mSurvey->addSurvey($dataSurvey, $tglBeli);
            if($survey){
                $this->addSurveyKeluhan($idKunjungan, $idProduk);
                $this->addSurveyPromosi($idKunjungan, $idProduk);
                echo json_encode(array("status" => "success", "data" =>  $dataSurvey));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menambahkan isian survey"));
            }
        }

        public function addSurveyKeluhan($idKunjungan, $idProduk){
            for($i=1;$i<=13;$i++){
                $data[$i]["ID_KELUHAN"] = $i;
                $data[$i]["ID_KUNJUNGAN_CUSTOMER"] = $idKunjungan;
                $data[$i]["ID_PRODUK"] = $idProduk;
                $data[$i]["CREATE_BY"] = $this->session->userdata("user_id");
                $data[$i]["DELETE_MARK"] = 0;
            }
            $data["1"]["JAWABAN"] = $this->input->post("semen_membatu");
            $data["2"]["JAWABAN"] = $this->input->post("semen_terlambat_datang");
            $data["3"]["JAWABAN"] = $this->input->post("kantong_semen_tidak_kuat");
            $data["4"]["JAWABAN"] = $this->input->post("harga_tidak_stabil");
            $data["5"]["JAWABAN"] = $this->input->post("semen_rusak");
            $data["6"]["JAWABAN"] = $this->input->post("top_kurang_lama");
            $data["7"]["JAWABAN"] = $this->input->post("pemesanan_sulit");
            $data["8"]["JAWABAN"] = $this->input->post("komplain_sulit");
            $data["9"]["JAWABAN"] = $this->input->post("stok_kosong");
            $data["10"]["JAWABAN"] = $this->input->post("pembayaran_rumit");
            $data["11"]["JAWABAN"] = $this->input->post("tidak_sesuai");
            $data["12"]["JAWABAN"] = $this->input->post("tidak_keluhan");
            $data["13"]["JAWABAN"] = $this->input->post("lain_lain");

            $keluhan = $this->mKeluhan->addSurveyKeluhan($data);
        }

        public function addSurveyPromosi($idKunjungan, $idProduk){
            for($i=1;$i<=7;$i++){
                $data[$i]["ID_PROMOSI"] = $i;
                $data[$i]["ID_KUNJUNGAN_CUSTOMER"] = $idKunjungan;
                $data[$i]["ID_PRODUK"] = $idProduk;
                $data[$i]["DELETE_MARK"] = 0;
                $data[$i]["CREATE_BY"] = $this->session->userdata("user_id");
            }
            $data["1"]["JAWABAN"] = $this->input->post("bonus_semen");
            $data["2"]["JAWABAN"] = $this->input->post("setiap_pembelian");
            $data["3"]["JAWABAN"] = $this->input->post("poin_reward");
            $data["4"]["JAWABAN"] = $this->input->post("voucher");
            $data["5"]["JAWABAN"] = $this->input->post("wisata");
            $data["6"]["JAWABAN"] = $this->input->post("potongan_pembelian");
            $data["7"]["JAWABAN"] = $this->input->post("promosi_lain");

            $promosi = $this->mPromosi->addSurveyPromosi($data);
        }

        public function updateSurvey(){
            $idSurvey = $this->input->post("id_survey");
            $idProduk = $this->input->post("id_produk");
            $stok = $this->input->post("stok");
            $hargaBeli = $this->input->post("harga_beli");
            $hargaJual = $this->input->post("harga_jual");
            $top = $this->input->post("top");
            $tglBeli = $this->input->post("tgl_beli");
            $volBeli = $this->input->post("vol_beli");
            $volJual = $this->input->post("vol_jual");

            $dataSurvey = array(
                "ID_PRODUK" => $idProduk,
                "STOK_SAAT_INI" => $stok,
                "VOLUME_PEMBELIAN" => $volBeli,
                "VOLUME_PENJUALAN" => $volJual,
                "HARGA_PENJUALAN" => $hargaJual,
                "HARGA_PEMBELIAN" => $hargaBeli,
                "TOP_PEMBELIAN" => $top,
                "UPDATE_BY" => $this->session->userdata("user_id")
            );

            $survey = $this->mSurvey->updateSurvey($idSurvey, $dataSurvey, $tglBeli);
            if($survey){
                echo json_encode(array("status" => "success", "data" =>  $dataSurvey));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa mengubah isian survey"));
            }
        }

        public function deleteSurvey(){
            $idSurvey = $this->input->post("id_survey");
            
            $dataSurvey = array(
                "UPDATE_BY" => $this->session->userdata("user_id"),
                "DELETE_MARK" => 1
            );

            $survey = $this->mSurvey->updateSurvey($idSurvey, $dataSurvey);
            if($survey){
                echo json_encode(array("status" => "success", "data" =>  $dataSurvey));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa mengubah isian survey"));
            }
        }

        public function detailSurvey($idSurvey){
            $survey = $this->mSurvey->surveyToko("ID_HASIL_SURVEY", $idSurvey);
            if($survey){
                echo json_encode(array("status" => "success", "data" => $survey));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data survey tidak ada"));
            }
        }

        public function listSurvey(){
            $data = array();
            $idKunjungan = $this->input->post("id_kunjungan");
            $provinsi = $this->input->post("provinsi");
            $merkProduk = $this->input->post("merk");
            $startDate = $this->input->post("start_date");
            $endDate = $this->input->post("end_date");

            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));
            if(isset($idKunjungan)){
                if($this->session->userdata("id_jenis_user") == "1001"){
                    $surveyHarga = $this->mSurvey->surveyToko(NULL, NULL, $provinsi, $merkProduk, $startDate, $endDate);
                } else if($this->session->userdata("id_jenis_user") == "1002" || $this->session->userdata("id_jenis_user") == "1007") {
                     $surveyHarga = $this->mSurvey->surveyToko(NULL, NULL, NULL, $merkProduk, $startDate, $endDate);
                } else{
                    $surveyHarga = $this->mSurvey->surveyToko("ID_KUNJUNGAN_CUSTOMER", $idKunjungan, NULL, $merkProduk, $startDate, $endDate);
                }

                if($surveyHarga){
                    $i=1;
                    foreach ($surveyHarga as $surveyHargaKey => $surveyHargaValue) {
                        if($this->session->userdata("id_jenis_user") == "1001" || $this->session->userdata("id_jenis_user") == "1002" || $this->session->userdata("id_jenis_user") == "1007"){
                            $data[] = array(
                                $i,
                                $surveyHargaValue->TGL_ISI_SURVEY,
                                $surveyHargaValue->NAMA_TOKO,
                                $surveyHargaValue->NAMA_PRODUK,
                                $surveyHargaValue->STOK_SAAT_INI,
                                "Rp. ".str_replace(",", ".", number_format($surveyHargaValue->HARGA_PEMBELIAN)),
                                "Rp. ".str_replace(",", ".", number_format($surveyHargaValue->HARGA_PENJUALAN)),
                                $surveyHargaValue->TOP_PEMBELIAN,
                                $surveyHargaValue->VOLUME_PEMBELIAN,
                                $surveyHargaValue->VOLUME_PENJUALAN,
                                ""
                            );
                        } else {
                            $data[] = array(
                                $i,
                                $surveyHargaValue->NAMA_PRODUK,
                                $surveyHargaValue->STOK_SAAT_INI,
                                "Rp. ".str_replace(",", ".", number_format($surveyHargaValue->HARGA_PEMBELIAN)),
                                "Rp. ".str_replace(",", ".", number_format($surveyHargaValue->HARGA_PENJUALAN)),
                                $surveyHargaValue->TOP_PEMBELIAN,
                                $surveyHargaValue->VOLUME_PEMBELIAN,
                                $surveyHargaValue->VOLUME_PENJUALAN,
                                "<center>
                                    <button id='btnDetailSurvey' data-idsurvey='".$surveyHargaValue->ID_HASIL_SURVEY."' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i> Update</button>
                                    &nbsp;
                                    <button id='btnDeleteSurvey' data-idsurvey='".$surveyHargaValue->ID_HASIL_SURVEY."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> Delete</button>
                                    </center>"
                            );
                        }
                        
                        $i++;
                    }
                } else {
                    $data[] = array("-","-","-","-","-","-","-","-","-","-","-");
                }
            } else {
                $surveyHarga = 0;
                $data[] = array("-","-","-","-","-","-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($surveyHarga),
                "recordsFiltered" => count($surveyHarga),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }
    }
?>
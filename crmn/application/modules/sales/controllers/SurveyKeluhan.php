<?php
    class SurveyKeluhan extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Model_product", "mProduct");
            $this->load->model("Model_RoutingCanvasing", "mRouting");
            $this->load->model("Model_keluhan", "mKeluhan");
        }

        public function index(){
            $idUser = $this->session->userdata("user_id");
            $data = array("title"=>"Dashboard CRM Administrator");
            $data["product"] = $this->mProduct->listProduct();
            $data["quest"] = $this->mKeluhan->questKeluhan();
            $data["canvasing"] = $this->mRouting->listCanvasing($idUser, "Y");
            $this->template->display('SurveyKeluhan_view', $data);
        }

        public function addSurveyKeluhan(){
            for($i=1;$i<=13;$i++){
                $data[$i]["ID_KELUHAN"] = $i;
                $data[$i]["ID_KUNJUNGAN_CUSTOMER"] = $this->input->post("id_kunjungan");
                $data[$i]["ID_PRODUK"] = $this->input->post("id_produk");
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
            if($keluhan){
                echo json_encode(array("status" => "success", "data" => $data));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menambahkan survey keluhan"));
            }
        }

        public function detailSurveyKeluhan(){
            $idKunjungan = $this->input->post("id_kunjungan");
            $idProduk = $this->input->post("id_produk");

            $keluhan = $this->mKeluhan->getListKeluhan($idKunjungan, $idProduk);
            if($keluhan){
                echo json_encode(array("status" => "success", "data" => $keluhan));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data survey keluhan tidak ada"));
            }
        }

        public function updateSurveyKeluhan(){
            $idKunjungan = $this->input->post("id_kunjungan");
            $idProduk = $this->input->post("id_produk");
            $surveyKeluhanId = $this->mKeluhan->checkIdSurveyKeluhan($idKunjungan, $idProduk);
            $i = 1;

            foreach($surveyKeluhanId as $surveyKeluhanIdKey => $surveyKeluhanIdValue){
                $data[$i]["ID_SURVEY_KELUHAN"] = (int)$surveyKeluhanIdValue->ID_SURVEY_KELUHAN;
                $data[$i]["ID_KELUHAN"] = (int)$surveyKeluhanIdValue->ID_KELUHAN;
                $data[$i]["ID_KUNJUNGAN_CUSTOMER"] = (int)$idKunjungan;
                $data[$i]["ID_PRODUK"] = $idProduk;
                $data[$i]["UPDATE_BY"] = $this->session->userdata("user_id");
                $i++;
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

            $keluhan = $this->mKeluhan->updateSurveyKeluhan($data);

            if($keluhan){
                echo json_encode(array("status" => "success", "data" => $data));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menambahkan survey keluhan"));
            }
        }

        public function deleteSurveyKeluhan(){
            $idKunjungan = $this->input->post("id_kunjungan");
            $idProduk = $this->input->post("id_produk");

            $data = array("DELETE_MARK" => 1, "UPDATE_BY" => $this->session->userdata("user_id"));

            $keluhan = $this->mKeluhan->deleteKeluhan($idKunjungan, $idProduk, $data);
            if($keluhan){
                echo json_encode(array("status" => "success", "data" => $keluhan));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menghapus survey"));
            }
        }

        public function listSurveyKeluhan(){
            $data = array();

            $idKunjungan = $this->input->post("id_kunjungan");
            $merk = $this->input->post("merk");
            $provinsi = $this->input->post("provinsi");
            $startDate = $this->input->post("start_date");
            $endDate = $this->input->post("end_date");

            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

            if($this->session->userdata("id_jenis_user") == "1001"){
                $keluhan = $this->mKeluhan->getListKeluhan(NULL, NULL, $provinsi, $merk, $startDate, $endDate);
            } else {
                $keluhan = $this->mKeluhan->getListKeluhan($idKunjungan, NULL, $provinsi, $merk, $startDate, $endDate);
            }
            
            if($keluhan){
                $i=1;
                foreach ($keluhan as $keluhanKey => $keluhanValue) {

                    $membatu = ($keluhanValue->SEMEN_MENBATU == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $kantong_tdk_kuat = ($keluhanValue->KANTONG_TIDAK_KUAT == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $semen_terlambat = ($keluhanValue->SEMEN_TERLAMBAT_DATANG == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $harga_tdk_stabil = ($keluhanValue->HARGA_TIDAK_STABIL == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $semen_rusak = ($keluhanValue->SEMEN_RUSAK_SAAT_DITERIMA == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $top_kurang = ($keluhanValue->TOP_KURANG_LAMA == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $pemesanan_sulit = ($keluhanValue->PEMESANAN_SULIT == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $komplain = ($keluhanValue->KOMPLAIN_SULIT == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $stok_kosong = ($keluhanValue->STOK_SERING_KOSONG == "Y" ? "<i class='fa fa-check'></i>" : "");
                    $prosedur = ($keluhanValue->PROSEDUR_RUMIT == "Y" ? "<i class='fa fa-check'></i>" : "");
                    
                    if($this->session->userdata("id_jenis_user") == "1001"){
                        $data[] = array(
                            $i,
                            $keluhanValue->NAMA_TOKO,
                            $keluhanValue->TANGGAL_SURVEY,
                            $keluhanValue->NAMA_PRODUK,
                            $membatu,
                            $kantong_tdk_kuat,
                            $semen_terlambat,
                            $harga_tdk_stabil,
                            $semen_rusak,
                            $top_kurang,
                            $pemesanan_sulit,
                            $komplain,
                            $stok_kosong,
                            $prosedur,
                            $keluhanValue->KELUHAN_LAIN_LAIN,
                            ""
                        );
                    } else {
                        $data[] = array(
                            $i,
                            $keluhanValue->TANGGAL_SURVEY,
                            $keluhanValue->NAMA_PRODUK,
                            $membatu,
                            $kantong_tdk_kuat,
                            $semen_terlambat,
                            $harga_tdk_stabil,
                            $semen_rusak,
                            $top_kurang,
                            $pemesanan_sulit,
                            $komplain,
                            $stok_kosong,
                            $prosedur,
                            $keluhanValue->KELUHAN_LAIN_LAIN,
                            "<center>
                                <button id='btnDetailSurvey'  data-idproduk='".$keluhanValue->ID_PRODUK."' data-idsurvey='".$keluhanValue->ID_KUNJUNGAN_CUSTOMER."' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i> Update</button>
                                &nbsp;
                                <button id='btnDeleteSurvey' data-idproduk='".$keluhanValue->ID_PRODUK."' data-idsurvey='".$keluhanValue->ID_KUNJUNGAN_CUSTOMER."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> Delete</button>
                            </center>"
                        );
                    }
                    
                    $i++;
                }
            } else {
                $data[] = array("-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($keluhan),
                "recordsFiltered" => count($keluhan),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }

    }
?>
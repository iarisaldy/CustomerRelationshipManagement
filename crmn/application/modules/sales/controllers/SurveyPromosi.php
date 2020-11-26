<?php
    class SurveyPromosi extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Model_product", "mProduct");
            $this->load->model("Model_RoutingCanvasing", "mRouting");
            $this->load->model("Model_promosi", "mPromosi");
        }

        public function index(){
            $idUser = $this->session->userdata("user_id");
            $data = array("title"=>"Dashboard CRM Administrator");
            $data["product"] = $this->mProduct->listProduct();
            $data["canvasing"] = $this->mRouting->listCanvasing($idUser, "Y");
            $this->template->display('SurveyPromosi_view', $data);
        }

        public function addSurveyPromosi(){
            for($i=1;$i<=7;$i++){
                $data[$i]["ID_PROMOSI"] = $i;
                $data[$i]["ID_KUNJUNGAN_CUSTOMER"] = $this->input->post("id_kunjungan");
                $data[$i]["ID_PRODUK"] = $this->input->post("id_produk");
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
            if($promosi){
                echo json_encode(array("status" => "success", "data" => $promosi));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menambahkan survey promosi"));
            }
        }

        public function detailSurveyPromosi(){
            $idKunjungan = $this->input->post("id_kunjungan");
            $idProduk = $this->input->post("id_produk");

            $surveyPromosi = $this->mPromosi->listSurveyPromosi($idKunjungan, $idProduk);
            if($surveyPromosi){
                echo json_encode(array("status" => "success", "data" => $surveyPromosi));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data survey promosi tidak ada"));
            }
        }

        public function updateSurveyPromosi(){
            $idKunjungan = $this->input->post("id_kunjungan");
            $idProduk = $this->input->post("id_produk");
            $surveyPromosiId = $this->mPromosi->checkIdSurveyPromosi($idKunjungan, $idProduk);
            $i = 1;
            foreach($surveyPromosiId as $surveyPromosiIdKey => $surveyPromosiIdValue){
                $data[$i]["ID_SURVEY_PROMOSI"] = (int)$surveyPromosiIdValue->ID_SURVEY_PROMOSI;
                $data[$i]["ID_PROMOSI"] = (int)$i;
                $data[$i]["ID_KUNJUNGAN_CUSTOMER"] = (int)$this->input->post("id_kunjungan");
                $data[$i]["ID_PRODUK"] = (int)$this->input->post("id_produk");
                $data[$i]["UPDATE_BY"] = $this->session->userdata("user_id");
                $i++;
            }
            $data["1"]["JAWABAN"] = $this->input->post("bonus_semen");
            $data["2"]["JAWABAN"] = $this->input->post("setiap_pembelian");
            $data["3"]["JAWABAN"] = $this->input->post("poin_reward");
            $data["4"]["JAWABAN"] = $this->input->post("voucher");
            $data["5"]["JAWABAN"] = $this->input->post("wisata");
            $data["6"]["JAWABAN"] = $this->input->post("potongan_pembelian");
            $data["7"]["JAWABAN"] = $this->input->post("promosi_lain");

            $promosi = $this->mPromosi->updateSurveyPromosi($data);
            if($promosi){
                echo json_encode(array("status" => "success", "data" => $data));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak dapat mengubah survey promosi"));
            }
        }

        public function deleteSurveyPromosi(){
            $idKunjungan = $this->input->post("id_kunjungan");
            $idProduk = $this->input->post("id_produk");

            $data = array(
                "DELETE_MARK" => 1,
                "UPDATE_BY" => $this->session->userdata("user_id")
            );

            $promosi = $this->mPromosi->deleteSurveyPromosi($idKunjungan, $idProduk, $data);
            if($promosi){
                echo json_encode(array("status" => "success", "data" => $promosi));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menghapus survey promosi")); 
            }
        }

        public function listSurveyPromosi(){
            $data = array();
            $idKunjungan = $this->input->post("id_kunjungan");
            $provinsi = $this->input->post("provinsi");
            $merk = $this->input->post("merk");
            $startDate = $this->input->post("start_date");
            $endDate = $this->input->post("end_date");

            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));

            if($this->session->userdata("id_jenis_user") == "1001"){
                $promosi = $this->mPromosi->listSurveyPromosi(NULL, NULL, $provinsi, $merk, $startDate, $endDate);
            } else {
                $promosi = $this->mPromosi->listSurveyPromosi($idKunjungan, NULL, $provinsi, $merk, $startDate, $endDate);
            }

            if($promosi){
                $i=1;
                foreach ($promosi as $promosiKey => $promosiValue) {
                    if($this->session->userdata("id_jenis_user") == "1001"){
                        $data[] = array(
                            $i,
                            $promosiValue->NAMA_TOKO,
                            $promosiValue->TANGGAL_KUNJUNGAN,
                            $promosiValue->NAMA_PRODUK,
                            $promosiValue->BONUS_SEMEN,
                            $promosiValue->SETIAP_PEMBELIAN,
                            $promosiValue->BONUS_WISATA,
                            $promosiValue->POINT_REWARD,
                            $promosiValue->VOUCER,
                            $promosiValue->POTONGAN_HARGA,
                            $promosiValue->PROMOSI_LAIN,
                            ""
                        );
                    } else {
                        $data[] = array(
                            $i,
                            $promosiValue->TANGGAL_KUNJUNGAN,
                            $promosiValue->NAMA_PRODUK,
                            $promosiValue->BONUS_SEMEN,
                            $promosiValue->SETIAP_PEMBELIAN,
                            $promosiValue->BONUS_WISATA,
                            $promosiValue->POINT_REWARD,
                            $promosiValue->VOUCER,
                            $promosiValue->POTONGAN_HARGA,
                            $promosiValue->PROMOSI_LAIN,
                            "<center>
                                <button id='btnDetailSurvey'  data-idproduk='".$promosiValue->ID_PRODUK."' data-idsurvey='".$promosiValue->ID_KUNJUNGAN_CUSTOMER."' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i> Update</button>
                                &nbsp;
                                <button id='btnDeleteSurvey' data-idproduk='".$promosiValue->ID_PRODUK."' data-idsurvey='".$promosiValue->ID_KUNJUNGAN_CUSTOMER."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> Delete</button>
                            </center>"
                        );
                    }
                    
                    $i++;
                }
            } else {
                $data[] = array("-","-","-","-","-","-","-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($promosi),
                "recordsFiltered" => count($promosi),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }
    }
?>
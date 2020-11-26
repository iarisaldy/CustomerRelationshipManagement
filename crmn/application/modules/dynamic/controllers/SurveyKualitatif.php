<?php
    class SurveyKualitatif extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Model_kualitatif", "mKualitatif");
        }

        public function index(){
            $idUser = $this->session->userdata("user_id");
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('SurveyKualitatif_view', $data);
        }

        public function addSurvey(){
            $idUser = $this->input->post("id_user");
            $isianSurvey = $this->input->post("isian_survey");
            $dataSurvey = array(
                "ID_USER" => $idUser,
                "JAWABAN" => $isianSurvey,
                "CREATE_BY" => $this->session->userdata("user_id"),
                "DELETE_MARK" => 0
            );

            $addSurvey = $this->mKualitatif->addSurvey($dataSurvey);
            if($addSurvey){
                echo json_encode(array("status" => "success", "data" => $addSurvey));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menambahkan isian survey"));
            }
        }

        public function detailSurvey($idSurvey){
            $surveyKualitatif = $this->mKualitatif->listSurveyKualitatif("ID_SURVEY_KUALITATIF", $idSurvey);
            if($surveyKualitatif){
                echo json_encode(array("status" => "success", "data" => $surveyKualitatif));
            } else {
                echo json_encode(array("status" => "error", "message" => "data survey tidak ada"));
            }
        }

        public function updateSurvey(){
            $idSurvey = $this->input->post("id_survey");
            $isianSurvey = $this->input->post("isian_survey");
            $dataSurvey = array(
                "JAWABAN" => $isianSurvey,
                "UPDATE_BY" => $this->session->userdata("user_id"),
            );

            $updateSurvey = $this->mKualitatif->updateSurvey($idSurvey, $dataSurvey);
            if($updateSurvey){
                echo json_encode(array("status" => "success", "data" => $updateSurvey));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menghapus survey"));
            }
        }

        public function deleteSurvey(){
            $idSurvey = $this->input->post("id_survey");
            $dataSurvey = array(
                "UPDATE_BY" => $this->session->userdata("user_id"),
                "DELETE_MARK" => 1
            );

            $deleteSurvey = $this->mKualitatif->updateSurvey($idSurvey, $dataSurvey);
            if($deleteSurvey){
                echo json_encode(array("status" => "success", "data" => $deleteSurvey));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menghapus survey"));
            }
        }

        public function listSurvey($idKunjungan = null){
            $data = array();
            $idKunjungan = $this->input->post("id_kunjungan");
            $posisi = $this->input->post("posisi");
            $distributor = $this->input->post("distributor");
            $provinsi = $this->input->post("provinsi");
            $startDate = $this->input->post("start_date");
            $endDate = $this->input->post("end_date");


            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));
            if(isset($idKunjungan)){
                if($this->session->userdata("id_jenis_user") == "1001"){
                    $surveyKualitatif = $this->mKualitatif->listSurveyKualitatif(NULL, NULL, $posisi, $distributor, $provinsi, $startDate, $endDate);
                } else {
                    $surveyKualitatif = $this->mKualitatif->listSurveyKualitatif("ID_USER", $idKunjungan, $posisi, $distributor, $provinsi, $startDate, $endDate);
                }

                if($surveyKualitatif){
                    $i=1;
                    foreach ($surveyKualitatif as $surveyKualitatifKey => $surveyKualitatifValue) {
                        if($this->session->userdata("id_jenis_user") == "1001"){
                            $data[] = array(
                                $i,
                                $surveyKualitatifValue->TGL_SURVEY,
                                $surveyKualitatifValue->NAMA,
                                $surveyKualitatifValue->NAMA_DISTRIBUTOR,
                                $surveyKualitatifValue->NAMA_PROVINSI,
                                // $surveyKualitatifValue->NAMA_AREA,
                                $surveyKualitatifValue->JAWABAN,
                                ""
                            );
                        } else {
                            $data[] = array(
                                $i,
                                $surveyKualitatifValue->JAWABAN,
                                "<center>
                                    <button id='btnDetailSurvey' data-idsurveykualitatif='".$surveyKualitatifValue->ID_SURVEY_KUALITATIF."' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i> Update</button>
                                    &nbsp;
                                    <button id='btnDeleteSurvey' data-idsurveykualitatif='".$surveyKualitatifValue->ID_SURVEY_KUALITATIF."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> Delete</button>
                                </center>"
                            );
                        }
                        $i++;
                    }
                } else {
                    $data[] = array("-","-","-","-","-","-","-","-");
                }
            } else {
                $surveyKualitatif = 0;
                $data[] = array("-","-","-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($surveyKualitatif),
                "recordsFiltered" => count($surveyKualitatif),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }
    }
?>
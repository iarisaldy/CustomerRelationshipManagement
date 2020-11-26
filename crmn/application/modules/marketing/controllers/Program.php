<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

    class Program extends CI_Controller {

        function __construct(){
            parent::__construct();
            $this->load->model("Model_program", "mProgram");
        }

        public function index(){
            $data = array("title"=>"Dashboard CRM");
            $data["program"] = $this->mProgram->listProgram();
            $this->template->display('ProgramOfDay_view', $data);
        }

        public function detail($idProgram){
            $data = array("title"=>"Dashboard CRM");
            $data["program"] = $this->mProgram->listProgram($idProgram);
            $this->template->display('ProgramOfDayUpdate_view', $data);
        }

        public function add(){
            $data = array("title" => "Dashboard CRM");
            $this->template->display("ProgramOfDayAdd_view", $data);
        }

        public function addProgramProses(){
            $judul = $this->input->post("judul_program");
            $detail = $this->input->post("detail_program");
            $start = $this->input->post("startdate");
            $end = $this->input->post("enddate");
            $kdDistributor = null;
            
            $idJenisUser = $this->session->userdata("id_jenis_user");
            if($idJenisUser == "1002"){
                $kdDistributor = $this->session->userdata("kode_dist");
            }

            $dataProgram = array(
                "JUDUL_PROGRAM" => $judul,
                "DETAIL_PROGRAM" => $detail,
                "CREATE_BY" => $this->session->userdata("user_id"),
                "PIC_PROGRAM" => $this->session->userdata("id_jenis_user"),
                "DELETE_MARK" => 0,
                "KODE_DISTRIBUTOR" => $kdDistributor
            );

            $addProgram = $this->mProgram->addProgram($dataProgram, $start, $end);
            if($addProgram){
                echo json_encode(array("status" => "success", "data" => $addProgram));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menyimpan data program"));
            }
        }

        public function updateProgramProses(){
            $idProgram = $this->input->post("id_program");
            $judul = $this->input->post("judul_program");
            $detail = $this->input->post("detail_program");
            $start = $this->input->post("start");
            $end = $this->input->post("end");

            $dataProgram = array(
                "JUDUL_PROGRAM" => $judul,
                "DETAIL_PROGRAM" => $detail,
                "UPDATE_BY" => $this->session->userdata("user_id")
            );

            $updateProgram = $this->mProgram->updateProgram($idProgram, $dataProgram, $start, $end);
            if($updateProgram){
                echo json_encode(array("status" => "success", "data" => $updateProgram));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menyimpan data program"));
            }
        }

        public function deleteProgram(){
            $idProgram = $this->input->post("id_program");
            $dataProgram = array(
                "UPDATE_BY" => $this->session->userdata("user_id"),
                "DELETE_MARK" => 1
            );

            $updateProgram = $this->mProgram->Delete_program($idProgram);
            if($updateProgram){
                echo json_encode(array("status" => "success", "data" => $updateProgram));
            } else {
                echo json_encode(array("status" => "error", "message" => "Tidak bisa menyimpan data program"));
            }
        }
    }
?>
<?php

/*
 * 
 */
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Competitor extends CI_Controller {

    // Atribut array berisikan pulau yang ada di indonesia
    private $pulau = array(
        array("LATITUDE" => -0.639940, "LONGITUDE" => 101.469727, "PULAU" => "Sumatera"),
        array("LATITUDE" => -7.019801, "LONGITUDE" => 109.654541, "PULAU" => "Jawa"),
        array("LATITUDE" => 0.828752, "LONGITUDE" => 113.631592, "PULAU" => "Kalimantan"),
        array("LATITUDE" => -1.961363, "LONGITUDE" => 119.718018, "PULAU" => "Sulawesi"),
        array("LATITUDE" => -8.517363, "LONGITUDE" => 117.237854, "PULAU" => "NTB"),
        array("LATITUDE" => -8.539093, "LONGITUDE" => 121.258850, "PULAU" => "NTT"),
        array("LATITUDE" => -3.892343, "LONGITUDE" => 138.218994, "PULAU" => "Papua")
    );

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        if (!$this->session->userdata('is_login')) {
            redirect('login');
        }

        $this->load->model('Competitor_model');
    }

    function index() {
        $data = array(
            'title' => 'Competitor Facility',
            'listperusahaan' => $this->ceklistPerusahaan(),
            'listfasilitas' => $this->ceklistFasilitas(),
            'listpulau' => $this->pulau,
            'listprov' => $this->Competitor_model->getProv(),
            'totalnews' => $this->Competitor_model->countNews(),
        );
        $this->template->display('Competitor_view', $data);
    }

    function getData() {
        $data = $this->Competitor_model->getDataFasilitas();
        $foto = $this->Competitor_model->getFoto();
        $info = $this->Competitor_model->getInfo();

        foreach ($data as $key => $value) {
            $data[$key]['FOTO'] = array();
            $data[$key]['INFO'] = array();
//            $data[$key]['HEADER'] = array();
//            $data[$key]['TEXT'] = array();

            foreach ($foto as $f) {
                if ($value['ID'] == $f['ID_PRSH_FASILITAS']) {
                    array_push($data[$key]['FOTO'], base_url() . "assets/fasilitas_perusahaan/" . $f['FOTO']);
                }
            }
            foreach ($info as $inf) {
                if ($value['ID'] == $inf['ID_PRSH_FASILITAS']) {
                    $arr = array();
                    $arr['HEADER'] = $inf['HEADER'];
                    $arr['TEXT'] = $inf['TEXT'];
                    array_push($data[$key]['INFO'], $arr);
//                    array_push($data[$key]['HEADER'], $inf['HEADER']);
//                    array_push($data[$key]['TEXT'], $inf['TEXT']);
                }
            }
        }
        echo json_encode($data);
    }

    function ceklistPerusahaan() {
        $data = $this->Competitor_model->getPerusahaan();

        $list = "<form id='fListPerusahaan' style='line-height: 10px;margin-top: -14px;'><ul class='list-group'><li class='list-group-item active' style='z-index: 2;color: #676a6c;background-color: rgba(218, 218, 218, 0.52);border-color: #15a376;font-weight: 700;'><input type='checkbox' style='margin-left: 0px;' id='checkAllPerusahaan' checked/>&nbsp;Check/Uncheck All</li>";

        foreach ($data as $value) {
            $list .= "<li class='list-group-item'>";
            $list .= "<label class='checkbox-inline'>";
            $list .= "<input id='cb" . $value['KODE_PERUSAHAAN'] . "' type='checkbox' value='" . $value['KODE_PERUSAHAAN'] . "' checked style='margin-top: 0px;'>";
            $list .= $value['NAMA_PERUSAHAAN'];
            $list .= "</label>";
            $list .= "</li>";
        }

        $list .= "</ul></form>";

        return $list;
    }

    function ceklistFasilitas() {
        $data = $this->Competitor_model->getFasilitas();

        $list = "<form id='fListFasilitas'><ul class='list-group'><li class='list-group-item active' style='z-index: 2;color: #676a6c;background-color: rgba(218, 218, 218, 0.52);border-color: #15a376;font-weight: 700;'><input type='checkbox' id='checkAllFasilitas' checked style='z-index: 2;color: #676a6c;background-color: #fff;border: 1px solid #e7eaec;margin-left: 0px;font-weight:bold'/>&nbsp;Check/Uncheck All</li>";

        foreach ($data as $value) {
            $list .= "<li class='list-group-item col-md-12'>";
//            $list .= "<label class='checkbox-inline'>";
//            $list .= "<input id='cbf" . $value['ID'] . "' type='checkbox' value='" . $value['ID'] . "' checked>";
//            $list .= $value['NAMA'];
//            $list .= "<label style='background-color:".$value['WARNA']."'></label>";
//            $list .= "</label>";
//            $list .= "<div class='col-md-12'>";
            $list .= "<div class='col-md-1'>";
            $list .= "<div style='width:20px;height:20px;background-color:" . $value['WARNA'] . ";'></div>";
            $list .= "</div>";
            $list .= "<div class='col-md-11'>";
            $list .= "<input id='cbf" . $value['ID'] . "' type='checkbox' value='" . $value['ID'] . "' checked> ".$value['NAMA'];
            $list .= "</div>";
//            $list .= "</div>";
            $list .= "</li>";
        }

        $list .= "</ul></form>";

        return $list;
    }
    //Function yang berisi informasi perusahaan
    function listInformasi() {
        $data = $this->Competitor_model->getNews();
        echo json_encode($data);
    }

//====================== FUNCTION CRUD MASTER FASILITAS ======================\\


    function MasterFasilitas() {
        // Link ini hanya admin yang dapat mengakses
        if ($this->session->userdata('akses') == 1) {
            $data = array('title' => 'Competitor Facility');

            $this->template->display('master-fasilitas', $data);
            // Selain admin diarahkan ke halaman competitor
        } else {
            redirect(base_url() . 'intelligence/Competitor');
        }
    }

    function ListFasilitas() {
        $list = $this->Competitor_model->ListFasilitas();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $fasilitas) {
            $no++;
            $row = array();
            $row[] = '<center>' . $no . '</center>';
            $row[] = $fasilitas->NAMA;
            $row[] = '<center>'
                    . '<a class="btn btn-xs btn-warning" style="margin-right: 5px;" href="javascript:void(0)" title="Edit" onclick="edit_facility(' . "'" . $fasilitas->ID . "'" . ')"><i class="fa fa-edit"></i> Edit</a>'
                    . '<a class="btn btn-xs btn-danger" style="margin-right: 5px;" href="javascript:void(0)" title="Hapus" onclick="delete_facility(' . "'" . $fasilitas->ID . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>'
                    . '</center>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Competitor_model->CountFasilitas(),
            "recordsFiltered" => $this->Competitor_model->FilterFasilitas(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function DetailFasilitas($id) {
        $data = $this->Competitor_model->DetailFasilitas($id);
        echo json_encode($data);
    }

    function AddFasilitas() {
        $data = array(
            'NAMA' => htmlspecialchars(strtoupper($this->input->post('NAMA'))),
            'CREATE_BY' => strtoupper($this->session->userdata('usernamescm')),
            'STATUS' => 0,
        );
        $this->Competitor_model->AddFasilitas($data);
        echo json_encode(array("status" => TRUE));
    }

    function UpdateFasilitas() {
        $data = array(
            'ID' => $this->input->post('ID'),
            'NAMA' => htmlspecialchars(strtoupper($this->input->post('NAMA'))),
            'CREATE_BY' => strtoupper($this->session->userdata('usernamescm')),
            'STATUS' => 0,
        );
        $this->Competitor_model->UpdateFasilitas(array('ID' => $this->input->post('ID')), $data);
        echo json_encode(array("status" => TRUE));
    }

    function DeleteFasilitas($id) {
        $this->Competitor_model->DeleteFasilitas($id);
        echo json_encode(array("status" => TRUE));
    }

//=================== FUNCTION CRUD FASILITAS PERUSAHAAN =====================\\

    function FasilitasPerusahaan() {
        // Link ini hanya admin yang dapat mengakses
        if ($this->session->userdata('akses') == 1) {
            $data = array(
                'title' => 'Competitor Facility',
                'perusahaan' => $this->Competitor_model->get_perusahaan(),
                'jenis_fasilitas' => $this->Competitor_model->get_jenis_fasilitas(),
            );
            $this->template->display('informasi-fasilitas', $data);
            // Selain admin diarahkan ke halaman competitor
        } else {
            redirect(base_url() . 'intelligence/Competitor');
        }
    }

    function ListInfoFasilitas() {
        $list = $this->Competitor_model->ListInfoFasilitas();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $infofasilitas) {
            $no++;
            $row = array();
            $row[] = '<center>' . $no . '</center>';
            $row[] = $infofasilitas->NAMA_PERUSAHAAN;
            $row[] = $infofasilitas->JENIS_FASILITAS;
            $row[] = $infofasilitas->NAMA_FASILITAS;
            $row[] = '<center>' . $infofasilitas->LATITUDE . '</center>';
            $row[] = '<center>' . $infofasilitas->LONGITUDE . '</center>';
            $row[] = '<center style="cursor: pointer;">'
                    . '<a href="javascript:void(0);" onclick="show_info(' . "'" . $infofasilitas->ID . "'" . ')"><i class="fa fa-info-circle" style="font-size: 25px;"></i></a>'
                    . '</center>';
            $row[] = '<center style="cursor: pointer;">'
                    . '<a href="javascript:void(0);" onclick="show_foto(' . "'" . $infofasilitas->ID . "'" . ')"><i class="fa fa-image" style="font-size: 25px;"></i></a>'
                    . '</center>';
            if ($infofasilitas->MARKER != "") {
                $row[] = '<img src="' . base_url() . 'assets/marker/' . $infofasilitas->MARKER . '">';
            } else {
                $row[] = 'Tidak ada marker';
            }
            if ($infofasilitas->STATUS_FASILITAS == 0) {
                $row[] = '<center>Aktif</center>';
            } else {
                $row[] = '<center>Tidak Aktif</center>';
            }
            $row[] = '<center><a class="btn btn-xs btn-warning" href="javascript:void(0)" title="Edit" onclick="edit_infofacility(' . "'" . $infofasilitas->ID . "'" . ')"><i class="fa fa-edit"></i> Edit</a>
                              <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_infofacility(' . "'" . $infofasilitas->ID . "'" . ')"><i class="fa fa-trash"></i> Hapus</a></center>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Competitor_model->CountInfoFasilitas(),
            "recordsFiltered" => $this->Competitor_model->FilterInfoFasilitas(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function AddInfoFasilitas() {
        $config = array(
            'upload_path' => realpath(APPPATH . '../assets/marker'),
            'allowed_types' => "tif|gif|jpg|png|jpeg",
            'file_name' => $_FILES['MARKER']['name'],
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('MARKER');

        $FASILITAS = $this->input->post('FASILITAS');
        $KODE_PERUSAHAAN = $this->input->post('KODE_PERUSAHAAN');
        $LATITUDE = $this->input->post('LATITUDE');
        $LONGITUDE = $this->input->post('LONGITUDE');
        $STATUS_FASILITAS = $this->input->post('STATUS_FASILITAS');
        $CREATE_BY = strtoupper($this->session->userdata('usernamescm'));
        $NAMA = strtoupper($this->input->post('NAMA'));
        $MARKER_UP = $this->input->post('MARKER_UP');
        IF ($MARKER_UP == 'default') {
            $data = $this->Competitor_model->DefaultMarker($FASILITAS, $KODE_PERUSAHAAN);
            foreach ($data as $datas) {
                $MARKER = $datas->MARKER;
            }
        } else {
            $MARKER = $this->upload->file_name;
        }
        //Disimpan ke tabel SCM_MI_PRSH_FASILITAS
        $this->Competitor_model->AddInfoFasilitas($FASILITAS, $KODE_PERUSAHAAN, $LATITUDE, $LONGITUDE, $STATUS_FASILITAS, $CREATE_BY, $NAMA, $MARKER);
        //Disimpan sebagai history
        $this->Competitor_model->HistoryAddInfoFasilitas();
        echo json_encode(array("status" => TRUE));
    }

    function DetailInfoFasilitas($id) {
        $data = $this->Competitor_model->DetailInfoFasilitas($id);
        echo json_encode($data);
    }

    function UpdateInfoFasilitas() {

        $config = array(
            'upload_path' => realpath(APPPATH . '../assets/marker'),
            'allowed_types' => "tif|gif|jpg|png|jpeg",
            'file_name' => $_FILES['MARKER']['name'],
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('MARKER');

        $ID = $this->input->post('ID');
        $MARKER_UP = $this->input->post('MARKER_UP');
        if ($this->upload->file_name == "" && $MARKER_UP == "") {// kondisi tidak update marker
            $FASILITAS = $this->input->post('FASILITAS');
            $KODE_PERUSAHAAN = $this->input->post('KODE_PERUSAHAAN');
            $LATITUDE = $this->input->post('LATITUDE');
            $LONGITUDE = $this->input->post('LONGITUDE');
            $STATUS_FASILITAS = $this->input->post('STATUS_FASILITAS');
            $UPDATE_BY = strtoupper($this->session->userdata('usernamescm'));
            $NAMA = strtoupper($this->input->post('NAMA'));
            //Update ke tabel SCM_MI_PRSH_FASILITAS
            $this->Competitor_model->UpdateInfoFasilitas1($ID, $FASILITAS, $KODE_PERUSAHAAN, $LATITUDE, $LONGITUDE, $STATUS_FASILITAS, $UPDATE_BY, $NAMA);
            //Disimpan sebagai history
            $this->Competitor_model->HistoryUpdateInfoFasilitas($ID);
        } elseif ($this->upload->file_name == "" && $MARKER_UP == 'default') { // kondisi update marker ke default
            $FASILITAS = $this->input->post('FASILITAS');
            $KODE_PERUSAHAAN = $this->input->post('KODE_PERUSAHAAN');
            $LATITUDE = $this->input->post('LATITUDE');
            $LONGITUDE = $this->input->post('LONGITUDE');
            $STATUS_FASILITAS = $this->input->post('STATUS_FASILITAS');
            $UPDATE_BY = strtoupper($this->session->userdata('usernamescm'));
            $NAMA = strtoupper($this->input->post('NAMA'));
            $data = $this->Competitor_model->DefaultMarker($FASILITAS, $KODE_PERUSAHAAN);
            foreach ($data as $datas) {
                $MARKER = $datas->MARKER;
            }
            //Update ke tabel SCM_MI_PRSH_FASILITAS
            $this->Competitor_model->UpdateInfoFasilitas2($ID, $FASILITAS, $KODE_PERUSAHAAN, $LATITUDE, $LONGITUDE, $STATUS_FASILITAS, $UPDATE_BY, $NAMA, $MARKER);
            //Disimpan sebagai history
            $this->Competitor_model->HistoryUpdateInfoFasilitas($ID);
        } else { // kondisi update marker ke marker baru
            $FASILITAS = $this->input->post('FASILITAS');
            $KODE_PERUSAHAAN = $this->input->post('KODE_PERUSAHAAN');
            $LATITUDE = $this->input->post('LATITUDE');
            $LONGITUDE = $this->input->post('LONGITUDE');
            $STATUS_FASILITAS = $this->input->post('STATUS_FASILITAS');
            $UPDATE_BY = strtoupper($this->session->userdata('usernamescm'));
            $NAMA = strtoupper($this->input->post('NAMA'));
            $MARKER = $this->upload->file_name;
            //Update ke tabel SCM_MI_PRSH_FASILITAS
            $this->Competitor_model->UpdateInfoFasilitas2($ID, $FASILITAS, $KODE_PERUSAHAAN, $LATITUDE, $LONGITUDE, $STATUS_FASILITAS, $UPDATE_BY, $NAMA, $MARKER);
            //Disimpan sebagai history
            $this->Competitor_model->HistoryUpdateInfoFasilitas($ID);
        }

        echo json_encode(array("status" => TRUE));
    }

    function DeleteInfoFasilitas($id) {
        $this->Competitor_model->DeleteInfoFasilitas($id);
        //Disimpan sebagai history
        $this->Competitor_model->HistoryDeleteInfoFasilitas($id);
        echo json_encode(array("status" => TRUE));
    }

//=============== FUNCTION CRUD INFORMASI FASILITAS PERUSAHAAN ===============\\

    function ListInfo($id) {
        $list = $this->Competitor_model->ListInfo($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $info) {
            $no++;
            $row = array();
            $row[] = '<center>' . $no . '</center>';
            $row[] = ucfirst($info->HEADER);
            $row[] = ucfirst($info->TEXT);
            $row[] = '<center>'
                    . '<a class="btn btn-xs btn-warning" style="margin-right: 5px;" href="javascript:void(0)" title="Edit" onclick="edit_info(' . "'" . $info->PK . "'" . ')"><i class="fa fa-edit"></i> Edit</a>'
                    . '<a class="btn btn-xs btn-danger" style="margin-right: 5px;" href="javascript:void(0)" title="Hapus" onclick="delete_info(' . "'" . $info->PK . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>'
                    . '</center>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Competitor_model->CountInfo($id),
            "recordsFiltered" => $this->Competitor_model->FilterInfo($id),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function DetailInfo($id) {
        $data = $this->Competitor_model->DetailInfo($id);
        echo json_encode($data);
    }

    function AddInfo() {

        $ID_PRSH_FASILITAS = $this->input->post('ID_PRSH_FASILITAS');
        $HEADER = $this->input->post('HEADER');
        $INFO = $this->input->post('INFO');
        $CREATE_BY = strtoupper($this->session->userdata('usernamescm'));
        $this->Competitor_model->AddInfo($ID_PRSH_FASILITAS, $HEADER, $INFO, $CREATE_BY);
        $this->Competitor_model->HistoryAddInfo($ID_PRSH_FASILITAS);
        echo json_encode(array("status" => TRUE));
    }

    function UpdateInfo() {
        $ID = $this->input->post('ID');
        $ID_PRSH_FASILITAS = $this->input->post('ID_PRSH_FASILITAS');
        $HEADER = $this->input->post('HEADER');
        $INFO = $this->input->post('INFO');
        $UPDATE_BY = strtoupper($this->session->userdata('usernamescm'));
        $this->Competitor_model->UpdateInfo($ID, $ID_PRSH_FASILITAS, $HEADER, $INFO, $UPDATE_BY);
        $this->Competitor_model->HistoryUpdateInfo($ID_PRSH_FASILITAS);
        echo json_encode(array("status" => TRUE));
    }

    function DeleteInfo($id) {
        $idprsh = $this->Competitor_model->IdPrshFasilitas($id);
        foreach ($idprsh as $val) {
            $idprshfasilitas = $val->ID_PRSH_FASILITAS;
        }
        $this->Competitor_model->HistoryDeleteInfo($idprshfasilitas);
        $this->Competitor_model->DeleteInfo($id);
        echo json_encode(array("status" => TRUE));
    }

//================== FUNCTION CRUD FOTO FASILITAS PERUSAHAAN ==================\\

    function ListFoto($id) {
        $list = $this->Competitor_model->ListFoto($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $foto) {
            $no++;
            $row = array();
            $row[] = '<center>' . $no . '</center>';
            $row[] = '<center>'
                    . '<img class="img-responsive" src="' . base_url() . '/assets/fasilitas_perusahaan/' . $foto->FOTO . '" style="width: 30%;">'
                    . '</center>';
            $row[] = '<center>'
                    . '<a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_foto(' . "'" . $foto->ID_FOTO . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>'
                    . '</center>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Competitor_model->CountFoto($id),
            "recordsFiltered" => $this->Competitor_model->FilterFoto($id),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function DetailFoto($id) {
        $data = $this->Competitor_model->DetailFoto($id);
        echo json_encode($data);
    }

    function AddFoto() {
        $config = array(
            'upload_path' => realpath(APPPATH . '../assets/fasilitas_perusahaan'),
            'allowed_types' => "tif|gif|jpg|png|jpeg",
            'file_name' => time() . $_FILES['FOTO']['name'],
            'max_size' => '3072'
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('FOTO')) {
            $ID_PRSH_FASILITAS = $this->input->post('ID_PRSH_FASILITAS');
            $CREATE_BY = strtoupper($this->session->userdata('usernamescm'));
            $FOTO = $this->upload->file_name;

            $this->Competitor_model->AddFoto($ID_PRSH_FASILITAS, $CREATE_BY, $FOTO);
            //Disimpan sebagai history
            $this->Competitor_model->HistoryAddFotoFasilitas($ID_PRSH_FASILITAS);
            echo json_encode(array("status" => TRUE));
        }else{
            echo '<pre>';
            var_dump($this->upload->display_errors());
        }
    }

    function DeleteFoto($id) {
        $this->Competitor_model->DeleteFoto($id);
        //Disimpan sebagai history
        $this->Competitor_model->HistoryDeleteFotoFasilitas($id);
        echo json_encode(array("status" => TRUE));
    }

    //====================== FUNCTION CRUD ENTRY PERUSAHAAN ======================\\


    function MasterPerusahaan() {
        // Link ini hanya admin yang dapat mengakses
        if ($this->session->userdata('akses') == 1) {
            $data = array('title' => 'Master Perusahaan');

            $this->template->display('master-perusahaan', $data);
            // Selain admin diarahkan ke halaman competitor
        } else {
            redirect(base_url() . 'intelligence/Competitor');
        }
    }

    function ListPerusahaan() {
        $list = $this->Competitor_model->ListPerusahaan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lists) {
            $no++;
            $row = array();
            if ($lists->STATUS == 0) {
                $stts = 'ASI';
            } else {
                $stts = 'non-ASI';
            }
            $row[] = '<center>' . $no . '</center>';
            $row[] = $lists->NAMA_PERUSAHAAN;
            $row[] = $lists->INISIAL;
            $row[] = $lists->PRODUK;
            $row[] = '<center>' . $stts . '</center>';
            $row[] = '<center>'
                    . '<a class="btn btn-xs btn-warning" style="margin-right: 5px;" href="javascript:void(0)" title="Edit" onclick="edit_perusahaan(' . "'" . $lists->KODE_PERUSAHAAN . "'" . ')"><i class="fa fa-edit"></i> Edit</a>'
                    . '<a class="btn btn-xs btn-danger" style="margin-right: 5px;" href="javascript:void(0)" title="Hapus" onclick="delete_perusahaan(' . "'" . $lists->KODE_PERUSAHAAN . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>'
                    . '</center>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Competitor_model->CountPerusahaan(),
            "recordsFiltered" => $this->Competitor_model->FilterPerusahaan(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function DetailPerusahaan($id) {
        $data = $this->Competitor_model->DetailPerusahaan($id);
        echo json_encode($data);
    }

    function AddPerusahaan() {
//        $max = $this->db->query('select max(KODE_PERUSAHAAN) MAXID FROM ZREPORT_MS_PERUSAHAAN');
        $max = $this->Competitor_model->max_id();
        foreach ($max as $maxs) {
            $idmax = $maxs->MAXID;
        }
        $kd_perusahaan = $idmax + 1;
//        $kd_perusahaan = $this->input->post('KODE_PERUSAHAAN');
        $nm_perusahaan = htmlspecialchars(strtoupper($this->input->post('NAMA_PERUSAHAAN')));
        $inisial = htmlspecialchars(strtoupper($this->input->post('INISIAL')));
        $produk = htmlspecialchars($this->input->post('PRODUK'));
        $status = htmlspecialchars($this->input->post('STATUS'));
        $create_by = strtoupper($this->session->userdata('usernamescm'));
        $return = $this->Competitor_model->AddPerusahaan($kd_perusahaan, $nm_perusahaan, $inisial, $produk, $status, $create_by);
        echo json_encode(array("status" => $return));
    }

    function UpdatePerusahaan() {
        $kd_perusahaan = $this->input->post('KODE_PERUSAHAAN');
        $nm_perusahaan = htmlspecialchars(strtoupper($this->input->post('NAMA_PERUSAHAAN')));
        $inisial = htmlspecialchars(strtoupper($this->input->post('INISIAL')));
        $produk = htmlspecialchars($this->input->post('PRODUK'));
        $status = htmlspecialchars($this->input->post('STATUS'));
        $update_by = strtoupper($this->session->userdata('usernamescm'));
        $return = $this->Competitor_model->UpdatePerusahaan($kd_perusahaan, $nm_perusahaan, $inisial, $produk, $status, $update_by);
        echo json_encode(array("status" => $return));
    }

    function DeletePerusahaan($id) {
        $return = $this->Competitor_model->DeletePerusahaan($id);
        echo json_encode(array("status" => $return));
    }

    /*
     * Table Log Activity
     */

    function ListLog($id) {
        $list = $this->Competitor_model->ListLog($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $info) {
            $no++;
            $row = array();
            $row[] = '<center>' . $no . '</center>';
            $row[] = ucfirst($info->INFO);
            $row[] = $info->CREATE_DATE;
            $row[] = $info->CREATE_BY;
//            $row[] = '<center>'
//                    . '<a class="btn btn-xs btn-warning" style="margin-right: 5px;" href="javascript:void(0)" title="Edit" onclick="edit_info(' . "'" . $info->PK . "'" . ')"><i class="fa fa-edit"></i> Edit</a>'
//                    . '<a class="btn btn-xs btn-danger" style="margin-right: 5px;" href="javascript:void(0)" title="Hapus" onclick="delete_info(' . "'" . $info->PK . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>'
//                    . '</center>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Competitor_model->CountLog($id),
            "recordsFiltered" => $this->Competitor_model->FilterLog($id),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function downloadExcel() {
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $indexSheet = 0;

        $data = array();

        $dataFasilitas = $this->Competitor_model->getDataFasilitasAll();
        $dataInformasi = $this->Competitor_model->getDataInfoFasilitas();

        foreach ($dataFasilitas as $key => $value) {
            $data[$value['ID']]['JENIS_FASILITAS'] = $value['JENIS_FASILITAS'];
            $data[$value['ID']]['NAMA_PERUSAHAAN'] = $value['NAMA_PERUSAHAAN'];
            $data[$value['ID']]['NAMA'] = $value['NAMA'];
            $data[$value['ID']]['LATITUDE'] = $value['LATITUDE'];
            $data[$value['ID']]['LONGITUDE'] = $value['LONGITUDE'];
            $data[$value['ID']]['STATUS'] = $value['STATUS_FASILITAS'];
            $data[$value['ID']]['INFO'] = array();
        }

        foreach ($dataInformasi as $value) {
            array_push($data[$value['ID']]['INFO'], array("HEADER" => $value['HEADER'], "TEXT" => $value['TEXT']));
        }

        $objPHPExcel->setActiveSheetIndex(0);
        /* buat header */
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Nomor');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Jenis Fasilitas');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Nama Perusahaan');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Nama Fasilitas');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Latitude');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Longitude');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Status');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Informasi');

        $no = 1;
        $row = 2;
        foreach ($data as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['JENIS_FASILITAS']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['NAMA_PERUSAHAAN']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['NAMA']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['LATITUDE']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['LONGITUDE']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['STATUS']);
            $col = 'H';
            if ($value['INFO'] > 0) {
                foreach ($value['INFO'] as $info) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col . '' . $row, $info['HEADER'] . ' : ' . $info['TEXT']);
                    $col++;
                }
            }
            $row++;
            $no++;
        }

        $namafile = 'Data Fasilitas Kompetitor.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $namafile . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        //header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
//        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
//        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("php://output");
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
    }

}

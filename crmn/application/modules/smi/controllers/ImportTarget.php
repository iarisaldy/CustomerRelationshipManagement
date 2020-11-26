<?php
	class ImportTarget extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model("Model_TargetKpi", "mTargetKpi");
		}

		public function listTarget(){
			$distributor = $this->input->post("distributor");
			$provinsi = $this->input->post("provinsi");
			$area = $this->input->post("area");
			$bulan = $this->input->post("bulan");
			$tahun = $this->input->post("tahun");

			$draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

            $target = $this->mTargetKpi->listTarget($bulan, $tahun, $distributor, $provinsi, $area);

            if($target){
            	$i=1;
            	foreach ($target as $targetKey => $targetValue) {
            		$data[] = array(
                        $i,
                        $targetValue->NAMA_DISTRIBUTOR,
                        $targetValue->NAMA_PROVINSI,
                        $targetValue->ID_AREA,
                        $targetValue->VOLUME,
                        "Rp ".number_format($targetValue->HARGA),
                        "Rp ".number_format($targetValue->REVENUE)
                    );
                    $i++;
            	}
            } else {
            	$data[] = array("-","-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($target),
                "recordsFiltered" => count($target),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}

		public function listTargetCustomer(){
			$distributor = $this->input->post("distributor");
			$bulan = $this->input->post("bulan");
			$tahun = $this->input->post("tahun");

			$draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

            $target = $this->mTargetKpi->listTargetCustomer($bulan, $tahun, $distributor);

            if($target){
            	$i=1;
            	foreach ($target as $targetKey => $targetValue) {
            		$data[] = array(
                        $i,
                        $targetValue->NAMA_DISTRIBUTOR,
                        $targetValue->TARGET_KEEP,
                        $targetValue->TARGET_GET,
                        $targetValue->TARGET_GROWTH,
                        "<button class='btn btn-sm btn-warning'>Ubah</button>&nbsp;".
                        "<button class='btn btn-sm btn-danger'>Hapus</button>"
                    );
                    $i++;
            	}
            } else {
            	$data[] = array("-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($target),
                "recordsFiltered" => count($target),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}

		public function volume(){
			$config['upload_path'] = './assets/Survey/';
			$config['allowed_types'] = 'csv|xls|xlsx';

			$this->load->library('upload', $config);
			if(! $this->upload->do_upload('file')){
				echo $this->upload->display_errors();
			} else {
				$filename =  $this->upload->data('file_name');
				$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
				$inputFileName = $config['upload_path'] . $filename;

				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);

				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				$row = 1;
				for ($i=3; $i <= count($allDataInSheet); $i++) {
					$arrayAbjad = array("E","F","G","H","I","J","K","L","M","N","O","P");
					$k = 1;
					$paramTarget = array(
						"KODE_DISTRIBUTOR" => "0000000".$allDataInSheet[$i]['B'], 
						"ID_PROVINSI" => $allDataInSheet[$i]['C'],
						"ID_AREA" => $allDataInSheet[$i]['D'],
						"TAHUN" => $this->input->post("tahun")
					);

					$checkTarget = $this->mTargetKpi->checkTarget($paramTarget, "VOLUME");
					if($checkTarget){
						$deleteTarget = $this->mTargetKpi->deleteTarget($paramTarget, "VOLUME");
					}

					for($j=0;$j<count($arrayAbjad);$j++){
						$data[] = array(
							"KODE_DISTRIBUTOR" => "0000000".$allDataInSheet[$i]['B'],
							"ID_JENIS_USER" => $this->session->userdata("id_jenis_user"),
							"ID_PROVINSI" => $allDataInSheet[$i]['C'],
							"ID_AREA" => $allDataInSheet[$i]['D'],
							"BULAN" => $k,
							"TAHUN" => $this->input->post("tahun"),
							"VOLUME" => $allDataInSheet[$i][$arrayAbjad[$j]],
							"CREATED_BY" => $this->session->userdata("user_id"),
							"DELETE_MARK" => "0"
						);
						$k++;
					}
				}

				$volume = $this->mTargetKpi->insertVolume($data);
				if($volume){
					$this->mTargetKpi->deleteNull("VOLUME");
					echo json_encode(array("status" => "success", "data" => $volume));
				} else {
					echo json_encode(array("status" => "error", "message" => "Data Tidak Bisa Disimpan"));
				}
			}
		}

		public function harga(){
			$config['upload_path'] = './assets/Survey/';
			$config['allowed_types'] = 'csv|xls|xlsx';

			$this->load->library('upload', $config);
			if(! $this->upload->do_upload('harga')){
				echo $this->upload->display_errors();
			} else {
				$filename =  $this->upload->data('file_name');
				$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
				$inputFileName = $config['upload_path'] . $filename;

				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);

				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				$row = 1;
				for ($i=3; $i <= count($allDataInSheet); $i++) {
					$arrayAbjad = array("E","F","G","H","I","J","K","L","M","N","O","P");
					$k = 1;

					$paramTarget = array(
						"KODE_DISTRIBUTOR" => "0000000".$allDataInSheet[$i]['B'], 
						"ID_PROVINSI" => $allDataInSheet[$i]['C'],
						"ID_AREA" => $allDataInSheet[$i]['D'],
						"TAHUN" => $this->input->post("tahun")
					);

					$checkTarget = $this->mTargetKpi->checkTarget($paramTarget, "HARGA");
					if($checkTarget){
						$deleteTarget = $this->mTargetKpi->deleteTarget($paramTarget, "HARGA");
					}

					for($j=0;$j<count($arrayAbjad);$j++){
						$data[] = array(
							"KODE_DISTRIBUTOR" => "0000000".$allDataInSheet[$i]['B'],
							"ID_JENIS_USER" => $this->session->userdata("id_jenis_user"),
							"ID_PROVINSI" => $allDataInSheet[$i]['C'],
							"ID_AREA" => $allDataInSheet[$i]['D'],
							"BULAN" => $k,
							"TAHUN" => $this->input->post("tahun"),
							"HARGA" => $allDataInSheet[$i][$arrayAbjad[$j]],
							"CREATED_BY" => $this->session->userdata("user_id"),
							"DELETE_MARK" => "0"
						);
						$k++;
					}
				}

				$volume = $this->mTargetKpi->insertHarga($data);
				if($volume){
					$this->mTargetKpi->deleteNull("HARGA");
					echo json_encode(array("status" => "success", "data" => $volume));
				} else {
					echo json_encode(array("status" => "error", "message" => "Data Tidak Bisa Disimpan"));
				}
			}
		}

		public function customer(){
			$config['upload_path'] = './assets/Survey/';
			$config['allowed_types'] = 'csv|xls|xlsx';

			$this->load->library('upload', $config);
			if(! $this->upload->do_upload('customer')){
				echo $this->upload->display_errors();
			} else {
				$filename =  $this->upload->data('file_name');
				$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
				$inputFileName = $config['upload_path'] . $filename;

				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);

				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				$row = 1;
				for ($i=2; $i <= count($allDataInSheet); $i++) {
					$data[] = array(
						"KODE_DISTRIBUTOR" => "0000000".$allDataInSheet[$i]['B'], 
						"BULAN" => $allDataInSheet[$i]['C'],
						"TAHUN" => $allDataInSheet[$i]['D'],
						"TARGET_KEEP" => $allDataInSheet[$i]['E'],
						"TARGET_GET" => $allDataInSheet[$i]['F'],
						"TARGET_GROWTH" => $allDataInSheet[$i]['G'],
						"CREATED_BY" => $this->session->userdata("user_id"),
						"DELETE_MARK" => "0"
					);
				}

				$customer = $this->mTargetKpi->insertCustomer($data);
				if($customer){
					echo json_encode(array("status" => "success", "data" => $customer));
				} else {
					echo json_encode(array("status" => "error", "message" => "Data Tidak Bisa Disimpan"));
				}
			}
		}
	}
?>
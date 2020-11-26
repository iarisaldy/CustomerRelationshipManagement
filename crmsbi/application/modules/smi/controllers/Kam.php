<?php
	/**
	 * 
	 */
	 require_once APPPATH . 'modules/smi/controllers/KpiSales.php';
	class Kam extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->load->model("Kam_model");
			
			 $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
            $this->load->library('PHPExcel');
		}
		
		public function Export_exel($bulan = null, $tahun = null){
            if($bulan < 10){
                $bulan = "0".$bulan;
            } else {
                $bulan = $bulan;
            }

            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));

            $data = $this->Kam_model->Get_peringkat_kam($tahun, $bulan);

            echo '<pre>';
            print_r($data);
            echo '</pre>';
            exit;
            //jika user memilih kode material
        
        
            $objPHPExcel = new PHPExcel();

            $objset     = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget     = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $abjad = array(
                    'A','B','C','D','E','F','G','H','I','J'
            );

            $style_center = array(
                    'alignment' => array(
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
            );
            $style_right = array(
                    'alignment' => array(
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
            );
            $style_bg = array(
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'ff0000')
                    ),
                    'font' => array(
                            'color' => array('rgb' => 'ffffff')
                    )
            );
            
            $style_list = array(
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFFF00')
                    ),
                    'font' => array(
                            'color' => array('rgb' => '333333')
                    )
            );

            $style_bg2 = array(
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '#FFFF00')
                    ),
                    'font' => array(
                            'color' => array('rgb' => '#000000')
                    )
            );
            $style_bg3 = array(
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '#FFFFFF')
                    ),
                    'font' => array(
                            'color' => array('rgb' => '#000000')
                    )
            );
            $style_bgformat = array(
                    'font' => array(
                            'color' => array('rgb' => '#FFFFFF')
                    )
            );
            $style_estimasi = array(
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFFACD')
                    )
            );
            $style_realisasi = array(
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFFFFF')
                    )
            );
            
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            //$objDrawing->setPath('./static/img/SI.png');

            $objDrawing->setCoordinates('B1');
            $objDrawing->setHeight(130);
            $objDrawing->setWidth(50);

             $objDrawing->setResizeProportional(true);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

            // $objget->getStyle('B1:F2')->applyFromArray($style_center);
            
            // $objset->setCellValue('A1', "");
            // $objget->getStyle('A1')->applyFromArray($style_bgformat);

            // $objset->setCellValue('B1', "Kunjungan  KAM/AM ");
            // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:H2');
            // $objget->getStyle('B1')->getFont()->setSize(18);
            // $objget->getStyle('B1')->getFont()->setBold(true);
            // $objget->getRowDimension('1')->setRowHeight(18);
            
            
            
            
            
            //TITLE LIST =====================================================================      
            // $baris =5;
            // $bm     = $baris+1;
            // $objset->setCellValue("B".$baris , "NO");
            // $objPHPExcel->setActiveSheetIndex(0)->mergeCells("B". $baris. ":B". $bm);
            // $objget->getStyle('B5')->applyFromArray($style_center);
            // $objget->getColumnDimension('B')->setWidth('5');
            
            // $objset->setCellValue("C".$baris , "Nama KAM/AM");
            // $objPHPExcel->setActiveSheetIndex(0)->mergeCells("C". $baris. ":C". $bm);
            // $objget->getStyle('C5')->applyFromArray($style_center);
            // $objget->getColumnDimension('C')->setWidth('40');
            
            // $objset->setCellValue("D".$baris , "Distributor");
            // $objPHPExcel->setActiveSheetIndex(0)->mergeCells("D". $baris. ":D". $bm);
            // $objget->getStyle('D5')->applyFromArray($style_center);
            // $objget->getColumnDimension('D')->setWidth('50');
            
            // $objset->setCellValue("E".$baris , "Jumlah Kunjungan");
            // $objPHPExcel->setActiveSheetIndex(0)->mergeCells("E". $baris. ":E". $bm);
            // $objget->getStyle('E5')->applyFromArray($style_center);
            // $objget->getColumnDimension('E')->setWidth('20');
            
            // $objget->getStyle('B5:E6')->applyFromArray($style_bg);
            // $objget->getStyle('B5:E6')->applyFromArray($style_center);
            // $objget->getStyle('B5:E6')->getFont()->setBold(true);

            //Menampilkan Isi data
			$baris=7;
			$no=1;
			// foreach($data as $d){
				// $objset->setCellValue("B". $baris, $no);
                // $objset->setCellValue("C". $baris, $d['NAMA']);
                // $objset->setCellValue("D". $baris, $d['NAMA_DISTRIBUTOR']);
                // $objset->setCellValue("E". $baris, $d['JML_KUNJUNGAN']);  
                // $baris = $baris +1; 
				// $no=$no+1;
			// }
            
            // $jml_material   = count($data_material_plant);      
            // $batas_material = $jml_material-1;
            
            // // LIST MATERIAL =====================================================================
            // $jml_material   = count($data_material_plant);
            // $bris_material=7;
            // for($i=0; $i<=$jml_material; $i++){
            //     $objset->setCellValue("P". $bris_material, $data_material_plant[$i]['KD_MATERIAL']);
            //     $objset->setCellValue("Q". $bris_material, $data_material_plant[$i]['NM_MATERIAL']);
                
            //     $bris_material++;
            // }
            
			
            
           $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

            $filename = "Laporan KPI KAM/AM - ".date('Y/m/d H:i:s a').".xls";

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            ob_end_clean();
            ob_start();
            $objWriter->save('php://output');
        }
		
		public function index(){
			$data = array("title"=>"Dashboard CRM VOLUME DISTRIBUTOR");
			
			$data['bulan']	= date('m');
			if(isset($_POST['filterBulan'])){
				$data['bulan'] = $_POST['filterBulan'];
			}

			$data['tahun']	= date('Y');
			if(isset($_POST['filterTahun'])){
				$data['tahun'] = $_POST['filterTahun'];
			}			

			$data['isi_table'] 	= $this->make_table_list_canvasing_kam($this->Kam_model->Get_peringkat_kam($data['tahun'], $data['bulan']));
			
			$this->template->display('kam_view', $data);

		}
		private function make_table_list_canvasing_kam($data){
			$isi = '';
			$no  = 1;
			$b 	 = 'x';
			foreach ($data as $d) {
				$tombol = '<center><button class="btn btn-sm btn-info tampil_grafik_detile_kam" id_user="'.$d['ID_USER'].'"><i class="fa fa-info"></i> Detail</button></center>';
				$isi  .= '<tr class="'.$b.'">';
				$isi  .= '<td>'.$no.'</td>';
				$isi  .= '<td>'.$d['NAMA'].'</td>';
				$isi  .= '<td>'.$d['KODE_DISTRIBUTOR'].'- '.$d['NAMA_DISTRIBUTOR'].'</td>';
				$isi  .= '<td>'.number_format($d['JML_KUNJUNGAN']).'</td>';
				$isi  .= '<td>'.$tombol.'</td>';
				$isi  .= '</tr>';
				$no=$no+1;
				
				if($b=='x'){
					$b='y';
				}
				else {
					$b='x';
				}
			}
			return $isi;
		}

		public function Ajax_tampil_data_bulanan(){
			$id_user 	= $this->input->post('user');
			$tahun 		= $this->input->post('tahun');
			$bulan 		= $this->input->post('bulan');

			$begin 		= '1';
			$finish 	= date('t', strtotime($tahun."-".$bulan."-01"));

			$hasil 		= $this->Kam_model->get_detile_kam($id_user, $tahun, $bulan);

			$data 		= array();
			for($i=1; $i<=$finish; $i++){
				$index = $i-1;

				if($i<10){
					$tgl = '0'. $i;
				}
				else {
					$tgl = $i;
				}

				$data[$index]['LABEL'] = $tgl;
				$data[$index]['VALUE'] = 0;
				foreach ($hasil as $h) {
					if($i==$h['HARI']){
						$data[$index]['VALUE'] = $h['JML_KUNJUNGAN'];
					}	
				}

			}

			echo json_encode($data);
			//print_r($period);

		}


	}
?>
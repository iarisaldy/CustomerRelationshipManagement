<style> .str{ mso-number-format:\@; } </style>

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
            <div class="card" style="padding-bottom: 0;">
				<div class="header bg-cyan">
                    <h2 style="padding-top: 0.2em;">IMPORT MAPPING TOKO SALES DISTRIBUTOR</h2>
                </div>
				<div class="body">
					
                    <div class="row clearfix">
						<div class="col-md-2">
							<a href="<?php echo base_url(); ?>excel/format/TEMPLATE_UPLOADS_PROJECT_TOKO.xlsx"><button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-file-o"></i> &nbsp Download Format Import Project Toko</button></a>
						</div>
						<form action="<?php echo base_url("dashboard/Upload_Project"); ?>" method="post" enctype="multipart/form-data" style="float: right;">
							<div class="col-md-8">
								<input class="form-control" type="file" name="file" accept=".xlsx">
							</div>
							<div class="col-md-2">
								<button name="preview" type="submit" class="btn btn-primary btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-eye"> </i> &nbsp Preview Data</button>  
							</div>
						</form>
					</div>
					
					
					<div class="row clearfix">
						<div class="row">
							<div class="col-md-12">
							
								<center>
							<?php
								if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
									if(isset($upload_error)){ // Jika proses upload gagal
										echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
										die; // stop skrip
									}
									
									echo "<hr>";

									// Buat sebuah tag form untuk proses import data ke database class='noExl'
									/*
									<tr style='background-color: #81ecec;' >
										<th colspan='7'><center>Preview Data Mapping Toko Sales</center></th>
									</tr>
									
									*/
									echo "<form method='post' action='".base_url("dashboard/Upload_Project/import")."'>";

									echo "<table id='tablePreview' class='table table-striped table-bordered' border='1' cellpadding='8' style='font-size: 10px;'>
									
									<tr style='background-color: #95a5a6;' >
										
										<th>ID_SALES</th>
										<th>USERNAME</th>
										<th>ID_TOKO_BK</th>
										<th>NAMA_TOKO</th>
										<th class='str'>KODE_DISTRIBUTOR</th>
										<th>DISTRIBUTOR</th>
										<th>LAPORAN CEK DATA</th>
									</tr>";

									$numrow = 1;
									$kosong = 0;
									$tdk_tersedia = 0;
									$tdk_sesuai = 0;
									$ready_mapping = 0;
									$cek_sesuai = 0;
									$remapping = 0;
									
									//$dataToExcel = array();			//untuk kirim data ke PHP excel
									
									$cek_replacing;
									$dataToReplacing = array();
									$no_cek = 0;
									
									$proses_importing = 0;
									$dataToImporting = array();
									$no_importing = 0;

									// Lakukan perulangan dari data yang ada di excel <th>NO. </th>
									// $sheet adalah variabel yang dikirim dari controller
									foreach($sheet as $row){
										// Ambil data pada excel sesuai Kolom

										$start_hari = str_pad($row['B'],2,"0",STR_PAD_LEFT);
										$start_bulan = str_pad($row['C'],2,"0",STR_PAD_LEFT);
										$end_hari = str_pad($row['E'],2,"0",STR_PAD_LEFT);
										$end_bulan = str_pad($row['F'],2,"0",STR_PAD_LEFT);


										$start = date('Ymd', strtotime($start_hari.'-'.$start_bulan.'-'.$row['D']));
										
										$PROJECT_NAME 	= $row['A']; // Ambil data
										$START_PROJECT 	= date('Ymd', strtotime($start_hari.'-'.$start_bulan.'-'.$row['D'])); // Ambil data
										$END_PROJECT 	= date('Ymd', strtotime($end_hari.'-'.$end_bulan.'-'.$row['G'])); // Ambil data
										$KECAMATAN 		= $row['H']; // Ambil data 
										$DISTRIK 		= $row['I']; 
										$AREA 			= $row['J']; 
										$PROVINSI 		= $row['K']; 
										$REGION 		= $row['L']; 
										$VOLUME 		= $row['M']; 
										
										// print_r('<pre>');
										// print_r($ID_SALES);exit;
										// Cek jika semua data tidak diisi
										if(

											$PROJECT_NAME 	== "" AND 
											$START_PROJECT 	== "" AND 
											$END_PROJECT 	== "" AND 
											$KECAMATAN 		== "" AND 
											$DISTRIK 		== "" AND 
											$AREA 			== "" AND 
											$PROVINSI 		== "" AND 
											$REGION 		== "" AND 
											$VOLUME 		== ""
										){
											continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
										}
										// Cek $numrow apakah lebih dari 1
										// Artinya karena baris pertama adalah nama-nama kolom
										// Jadi dilewat saja, tidak usah diimport
										if($numrow > 2){

											// print_r('<pre>');
											// print_r($START_PROJECT);exit;
											// Validasi apakah semua data telah diisi


											$PROJECT_NAME_td 	= (!empty($PROJECT_NAME))? "" : " style='background: #e84118;'"; 
											$START_PROJECT_td 	= (!empty($START_PROJECT))? "" : " style='background: #e84118;'"; 
											$END_PROJECT_td 	= (!empty($END_PROJECT))? "" : " style='background: #e84118;'"; 
											$KECAMATAN_td 		= (!empty($KECAMATAN))? "" : " style='background: #e84118;'"; 
											$DISTRIK_td 		= (!empty($DISTRIK))? "" : " style='background: #e84118;'"; 
											$AREA_td 			= (!empty($AREA))? "" : " style='background: #e84118;'"; 
											$PROVINSI_td 		= (!empty($PROVINSI))? "" : " style='background: #e84118;'"; 
											$REGION_td 		= (!empty($REGION))? "" : " style='background: #e84118;'"; 
											$VOLUME_td 		= (!empty($VOLUME))? "" : " style='background: #e84118;'"; 
											
											$SESUAI_td = '';

											// Jika salah satu data ada yang kosong
											if(

												$PROJECT_NAME 	== "" OR 
												$START_PROJECT 	== "" OR 
												$END_PROJECT 	== "" OR 
												$KECAMATAN 		== "" OR 
												$DISTRIK 		== "" OR 
												$AREA 			== "" OR 
												$PROVINSI 		== "" OR 
												$REGION 		== "" OR 
												$VOLUME 		== ""

											){
												$kosong++; // Tambah 1 variabel $kosong
											}
											
											$set_username = ''; $set_nama_toko = ''; $set_distributor = ''; $set_kesesuaian = '';
											
											$set_kesesuaiantojson = '';
											
											if($ID_SALES != ""){
												$dt_sales = $this->Upload_Project_model->cek_id_sales($ID_SALES);
												if(sizeof($dt_sales) > 0){
													$set_username = $dt_sales->UNAME;
												} else { 
													$ID_SALES_td = " style='background: #f9ca24;'";
													$USERNAME_td = " style='background: #f9ca24;'";
													$set_username = "<span style='color: red; font-weight: bold;'>Tidak Tersedia</span>";
													$tdk_tersedia++;
												}
											} else {
												$set_username = "<span style='color: red; font-weight: bold;'>Tidak Tersedia</span>";
												$tdk_tersedia++;
												//$set_kesesuaian = "<span style='color: #000; font-weight: bold;'>Tidak Sesuai</span>";
											}
											
											if($ID_TOKO_BK != ""){
												$dt_toko = $this->Upload_Project_model->cek_id_toko($ID_TOKO_BK);
												if(sizeof($dt_toko) > 0){
													$set_nama_toko = $dt_toko->NAMA_TOKO;
												} else {
													$ID_TOKO_BK_td = " style='background: #f9ca24;'";
													$NAMA_TOKO_td = " style='background: #f9ca24;'";
													$set_nama_toko = "<span style='color: red; font-weight: bold;'>Tidak Tersedia</span>";
													$tdk_tersedia++;
												}
											} else {
												$set_nama_toko = "<span style='color: red; font-weight: bold;'>Tidak Tersedia</span>";
												$tdk_tersedia++;
												//$set_kesesuaian = "<span style='color: #000; font-weight: bold;'>Tidak Sesuai</span>";
											}
											
											if($KODE_DISTRIBUTOR != ""){
												$dt_distributor = $this->Upload_Project_model->cek_id_distributor($KODE_DISTRIBUTOR);
												if(sizeof($dt_distributor) > 0){
													$set_distributor = $dt_distributor->NAMA_DISTRIBUTOR;
												} else {
													$KODE_DISTRIBUTOR_td = " style='background: #f9ca24;'";
													$NAMA_DISTRIBUTOR_td = " style='background: #f9ca24;'";
													$set_distributor = "<span style='color: red; font-weight: bold;'>Tidak Tersedia</span>";
													$tdk_tersedia++;
												}
											} else {
												$set_distributor = "<span style='color: red; font-weight: bold;'>Tidak Tersedia</span>";
												$tdk_tersedia++;
												//$set_kesesuaian = "<span style='color: #000; font-weight: bold;'>Tidak Sesuai</span>";
											}
											
											if($KODE_DISTRIBUTOR != "" AND $ID_TOKO_BK != "" AND $ID_SALES != ""){
												$dt_sesuai_sales = $this->Upload_Project_model->cek_kesesuaian_data_sales($ID_SALES, $KODE_DISTRIBUTOR);
												$dt_sesuai_toko = $this->Upload_Project_model->cek_kesesuaian_data_toko($ID_TOKO_BK, $KODE_DISTRIBUTOR);
												if(sizeof($dt_sesuai_sales) > 0 and sizeof($dt_sesuai_toko) > 0){
													$set_kesesuaian = "Sesuai";
													$set_kesesuaiantojson = "Sesuai";
													$proses_importing = 1;
													$cek_sesuai++;
												} else {
													$set_ket1 = ""; $set_ket2 = "";
													if(sizeof($dt_sesuai_sales) == 0){
														$set_ket1 = "Sales & Dist Tdk Sesuai";
													} 
													if(sizeof($dt_sesuai_toko) == 0){
														$set_ket2 = "Toko & Dist Tdk Sesuai";
													}
													
													$hub = "";
													if($set_ket1 != "" and $set_ket2 != ""){
														$hub = " , ";
													}
													
													$SESUAI_td = " style='background: #fa8231;'";
													$set_kesesuaian = "<span style='color: #000; font-weight: bold;'>".$set_ket1.$hub.$set_ket2."</span>";
													$set_kesesuaiantojson = $set_ket1.$hub.$set_ket2;
													$tdk_sesuai++;
													//$cek_sesuai-1;
												}
											} else{
												$SESUAI_td = " style='background: #e84118;'";
												$set_kesesuaian = "<span style='color: #000; font-weight: bold;'>Tidak Sesuai</span>";
												$set_kesesuaiantojson = "Tidak Sesuai";
												$tdk_sesuai++;
												//$cek_sesuai-1;
											}
											
											//if($kosong > 0 or $tdk_tersedia > 0 or $tdk_sesuai > 0){
												//$set_kesesuaian = "<span style='color: red; font-weight: bold;'>Tidak Sesuai</span>";
											//}
											
											if($ID_TOKO_BK != "" AND $ID_SALES != "" and $KODE_DISTRIBUTOR != ""){
												$dt_mapped = $this->Upload_Project_model->ready_mapping_toko($ID_SALES, $ID_TOKO_BK, $KODE_DISTRIBUTOR);
												if(sizeof($dt_mapped) > 0){
													$set_kesesuaian = "<span style='color: red; font-weight: bold;'>Sudah Ter-mapping</span>";
													$SESUAI_td = " style='background: #f9ca24;'";
													$set_kesesuaiantojson = "Sudah Ter-mapping";
													$ready_mapping++;
													$cek_sesuai--;
													$proses_importing = 0;
												}
											}
											
											
											if($set_kesesuaiantojson == "Sesuai"){
												$cek_replacing = $this->Upload_Project_model->cek_do_replacing_mapping($ID_TOKO_BK, $ID_SALES, $KODE_DISTRIBUTOR);
												$lost = '4-0-4';
												
												// preg_match('/\$lost\b/', $cek_replacing)
												
												if($cek_replacing == $lost){
													
												} else {
													$set_kesesuaian = "<span style='color: red; font-weight: bold;'>$cek_replacing</span>";
													$SESUAI_td = " style='background: #ffeaa7;'";
													$set_kesesuaiantojson = $cek_replacing;
													$proses_importing = 1;
													$cek_sesuai--;
													$remapping++;
													//$ready_mapping--;
													
													// ecplode replacing data get id sales;
													$geting_id_sales = explode(': ', $cek_replacing);
													
													$dataToReplacing[$no_cek]['NO'] 			= $no_cek;
													$dataToReplacing[$no_cek]['ID_TOKO'] 		= $ID_TOKO_BK;
													$dataToReplacing[$no_cek]['ID_DISTRIBUTOR'] = $KODE_DISTRIBUTOR;
													$dataToReplacing[$no_cek]['LIST_SALES'] 	= $geting_id_sales[1];
													$no_cek++;
												}
											}

											$cekData = $this->Upload_Project_model->cekDataProject($PROJECT_NAME, $START_PROJECT, $END_PROJECT, $KECAMATAN, $DISTRIK, $AREA, $PROVINSI, $REGION, $VOLUME);
											
											$no = $numrow - 1;
											
											echo "<tr>";
												//echo "<td>".$no."</td>";
												echo "<td".$ID_SALES_td.">".$ID_SALES."</td>";
												echo "<td".$USERNAME_td.">".$set_username."</td>";
												
												echo "<td".$ID_TOKO_BK_td.">".$ID_TOKO_BK."</td>";
												echo "<td".$NAMA_TOKO_td."> ".$set_nama_toko."</td>";
												
												echo "<td class='str' ".$KODE_DISTRIBUTOR_td.">`".$KODE_DISTRIBUTOR."</td>";
												echo "<td".$NAMA_DISTRIBUTOR_td.">".$set_distributor."</td>";
						
												echo "<td".$SESUAI_td.">".$set_kesesuaian."</td>";
											echo "</tr>";
											
											if($proses_importing == 1){
												$dataToImporting[$no_importing]['NO_IMPORT'] 	= $no_importing;
												$dataToImporting[$no_importing]['ID_SALES'] 	= $ID_SALES;
												//$dataToImporting[$no_importing]['USERNAME'] 	= $set_username;
												$dataToImporting[$no_importing]['ID_TOKO'] 		= $ID_TOKO_BK;
												//$dataToImporting[$no_importing]['NAMA_TOKO'] 	= $set_nama_toko;
												$dataToImporting[$no_importing]['ID_DISTRIBUTOR'] = $KODE_DISTRIBUTOR;
												//$dataToImporting[$no_importing]['NAMA_DISTRIBUTOR'] = $set_distributor;
												//$dataToImporting[$no_importing]['CEK_DATA'] = $set_kesesuaiantojson;
												$proses_importing = 0;
												$no_importing++;
											}
										}
										$numrow++; // Tambah 1 setiap kali looping
									}

									echo "</table>";

									$msg = "Terdapat ($kosong) Kolom yang belum diisi & ($tdk_tersedia) Data tidak tesedia. [$tdk_sesuai] Baris data tidak sesuai & [$ready_mapping] Baris data Sudah Ter-mapping & [$cek_sesuai] Baris data sesuai & [$remapping] Baris data persetujuan Re-mapping. Dari total [$no] Baris data import mapping toko sales. Harap Periksa Data Kembali.";
									echo "<script type='text/javascript'>alert('$msg');</script>";
									echo "<p style='text-align: center;'><b>Perhatian:</b><br> $msg </p>";
									
									// Cek apakah variabel kosong lebih dari 0
									// Jika lebih dari 0, berarti ada data yang masih kosong
									//if($kosong > 0 or $tdk_tersedia > 0 or $tdk_sesuai > 0 or $ready_mapping > 0){
									if(count($dataToImporting) == 0){
										
										
									}else{ // Jika semua data sudah diisi
										echo "<hr>";
										
										echo "<input type='hidden' name='list_data_replacing' value='".json_encode($dataToReplacing)."'>";
										
										echo "<input type='hidden' name='list_data_importing' value='".json_encode($dataToImporting)."'>";
										
										// Buat sebuah tombol untuk mengimport data ke database
										echo "<button type='submit' class='btn btn-primary' name='import' onClick='return doconfirm();'><i class='fa fa-cloud-upload' aria-hidden='true'></i> &nbsp Import Data Sesuai dan Persetujuan Re-Mapping Toko Sales</button>";
										//echo "<a href='".base_url("index.php/")."'>Cancel</a>";
									}

									echo "</form>"; 
									
									
									echo "<hr><button id='btnExportPreview' class='btn btn-success btn-sm btn-lg m-l-15 waves-effect'><i class='fa fa-file-excel-o'></i> &nbsp Export Laporan hasil Preview data Mapping Toko Sales</button>";
									
									
									//echo "<hr><a href=''><button class='btn btn-success btn-sm btn-lg m-l-15 waves-effect'><i class='fa fa-file-excel-o'></i> &nbsp Export Laporan hasil Preview data Mapping Toko Sales | PHP Excel</button></a>";
									
									//echo "<hr>";
									//print_r(json_encode($dataToImporting));
									
									//$jsonTo = '[]';
								}
							?>
								</center>
							
							<center>							
							<?php 
								if($this->session->userdata("after_import") == true) { ?>
								<div class="row">
									<hr>
									<div class="container-fluid">
										<h3>Laporan: <small>Hasil Import Data Mapping Toko Sales</small></h3>
										<table class="table table-striped table-bordered" width="100%" border="1" >
											<thead>
												<tr style="background-color: #81ecec;">
													<th style="text-align: center;">Total Baris Data</th>
													<th style="text-align: center;">Data Sukses</th>
													<th style="text-align: center;">Data Fail</th> 
													<th style="text-align: center;">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr style="text-align: center;">
													<td style="text-align: center;"><?= $this->session->userdata("baris_data"); ?></td>
													<td style="text-align: center;"><?= $this->session->userdata("data_sukses"); ?></td>
													<td style="text-align: center;"><?= $this->session->userdata("data_fail"); ?></td>
													<td style="text-align: center;">
														<a href=""><span class="btn btn-success"><i class="fa fa-list-alt "></i> Lihat Hasil</span></a>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<?php } 
									$this->session->set_userdata("after_import", false);
									$this->session->set_userdata("baris_data", null);
									$this->session->set_userdata("data_sukses", null);
									$this->session->set_userdata("data_fail", null);
								?>
								</center>
							
							</div>
						</div>
					</div>
					
			</div>
		</div>
    </div>
</section>

<script src="https://www.jqueryscript.net/demo/Export-Html-Table-To-Excel-Spreadsheet-using-jQuery-table2excel/src/jquery.table2excel.js"></script>

<script>
/*
$(function(){
	$("#submitBtnGo").click(function(){
		
		$.ajax({
			url: '<?php echo site_url(); ?>customer/Mapping/do_replacing_data',
			type: 'POST',
			dataType : 'json',
			data: {
				"data" : <?php echo json_encode($dataToReplacing); ?>
			},
			success: function(datasku){
				alert('suskses');
			},
			error: function(){
				alert('error');
			}
		});
	});
});


$(function(){
	$("#export_preview").click(function(){
		$("#export_preview").click(function(){
		$.ajax({
			url: '<?php echo site_url(); ?>customer/Mapping/export_preview',
			type: 'POST',
			dataType : 'json',
			data: {
				"data" : '<?= $jsonTo; ?>'
			},
			success: function(datasku){
				alert('suskses');
			},
			error: function(){
				alert('error');
			}
		});
	});
});
*/

$(function(){
	$("#btnExportPreview").click(function(){
		job1=confirm("Export data?");
		if(job1!=true){
			return false;
		}
		$("#tablePreview").table2excel({
			exclude: ".noExl",
			name: "Preview Data Mapping Toko",
			filename: "Preview_Data_Mapping_Toko",
	   	  	fileext: ".xlsx",
			exclude_img: true,
			exclude_links: true,
			exclude_inputs: true
		}); 
	});
});


function doconfirm(){
	job=confirm("Anda yakin ingin mengimport data?");
	if(job!=true){
		return false;
	}
}

</script>
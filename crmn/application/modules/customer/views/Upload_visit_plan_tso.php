<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
            <div class="card" style="padding-bottom: 0;">
				<div class="header" style="background-color: #2B982B; ">
                    <h2 style="padding-top: 0.2em; color: #fff;">IMPORT VISIT PLAN SALES DISTRIBUTOR</h2>
                </div>
				<div class="body">
					<div class="row clearfix">
						<p style="margin-left:2em;"><b>Lihat data:</b> &nbsp Sales Distributor dan Mapping Toko &nbsp;
							<span class="btn btn-info btn-sm" id="BtnModalUp">Di sini</span> 
						</p>
						<hr>
					</div>
                    <div class="row clearfix">
						<div class="col-md-2">
							<a href="<?php echo base_url(); ?>excel/format/TEMPLATE_UPLOADS_VISIT_PLAN_SALES.xlsx"><button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-file-excel-o"></i> &nbsp Download Format Import Visit Plan Sales</button></a>
						</div>
						<form action="<?php echo base_url("customer/Visit_plan_tso"); ?>" method="post" enctype="multipart/form-data" style="float: right;">
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

									// Buat sebuah tag form untuk proses import data ke database
									echo "<form method='post' action='".base_url("customer/Visit_plan_tso/import")."'>";

									echo "<table class='table table-striped table-bordered' border='1' cellpadding='8' style='font-size: 10px;'>
									<tr style='background-color: #81ecec;'>
										<th colspan='18'><center>Preview Data Visit Plan Sales</center></th>
									</tr>
									<tr>
										<th>ID_SALES</th>
										<th>USERNAME</th>
										<th>ID_TOKO_BK</th>
										<th>NAMA_TOKO</th>
										<th>DISTRIBUTOR</th>
										<th>SUN	</th>
										<th>MON	</th>
										<th>TUE	</th>
										<th>WED	</th>
										<th>THU	</th>
										<th>FRI	</th>
										<th>SAT	</th>
										<th>WEEK_1	</th>
										<th>WEEK_2	</th>
										<th>WEEK_3	</th>
										<th>WEEK_4	</th>
										<th>WEEK_5  </th>	
										<th>CEK DATA </th>
									</tr>";

									$numrow = 1;
									$kosong = 0;
									$tdk_tersedia = 0;
									$tdk_sesuai = 0;

									// Lakukan perulangan dari data yang ada di excel
									// $sheet adalah variabel yang dikirim dari controller
									foreach($sheet as $row){
										// Ambil data pada excel sesuai Kolom
										
										
										
										$ID_SALES 			= $row['A']; // Ambil data id sales
										$USERNAME 			= $row['B']; // Ambil data
										$ID_TOKO_BK 		= $row['C']; // Ambil data
										$NAMA_TOKO 			= $row['D']; // Ambil data 
										$KODE_DISTRIBUTOR 	= $row['E']; 
										$SUN = $row['F']; 
										$MON = $row['G']; 
										$TUE = $row['H'];
										$WED = $row['I']; 
										$THU = $row['J'];
										$FRI = $row['K']; 
										$SAT = $row['L'];
										$WEEK_1 = $row['M']; 
										$WEEK_2 = $row['N'];
										$WEEK_3 = $row['O']; 
										$WEEK_4 = $row['P'];
										$WEEK_5 = $row['Q']; 

										// Cek jika semua data tidak diisi
										if(
											$ID_SALES == "" AND 
											$USERNAME == "" AND 
											$ID_TOKO_BK == "" AND 
											$NAMA_TOKO == "" AND
											$KODE_DISTRIBUTOR == "" AND
											$SUN == "" AND
											$MON == "" AND
											$TUE == "" AND
											$WED == "" AND
											$THU == "" AND
											$FRI == "" AND 
											$SAT == "" AND
											$WEEK_1 == "" AND 
											$WEEK_2 == "" AND
											$WEEK_3 == "" AND
											$WEEK_4 == "" AND
											$WEEK_5 == "" 
										){
											continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
										}
										// Cek $numrow apakah lebih dari 1
										// Artinya karena baris pertama adalah nama-nama kolom
										// Jadi dilewat saja, tidak usah diimport
										if($numrow > 1){
											// Validasi apakah semua data telah diisi
											
											$ID_SALES_td = ( ! empty($ID_SALES))? "" : " style='background: #e84118;'"; 
											$USERNAME_td = ( ! empty($USERNAME))? "" : " style='background: #e84118;'"; 
											$ID_TOKO_BK_td = ( ! empty($ID_TOKO_BK))? "" : " style='background: #e84118;'";
											$NAMA_TOKO_td = ( ! empty($NAMA_TOKO))? "" : " style='background: #e84118;'";
											$KODE_DISTRIBUTOR_td = ( ! empty($KODE_DISTRIBUTOR))? "" : " style='background: #e84118;'"; 
											
											$SUN_td = ( ! empty($SUN))? "" : " style='background: #e84118;'"; 
											$MON_td = ( ! empty($MON))? "" : " style='background: #e84118;'"; 
											$TUE_td = ( ! empty($TUE))? "" : " style='background: #e84118;'"; 
											$WED_td = ( ! empty($WED))? "" : " style='background: #e84118;'"; 
											$THU_td = ( ! empty($THU))? "" : " style='background: #e84118;'"; 
											$FRI_td = ( ! empty($FRI))? "" : " style='background: #e84118;'"; 
											$SAT_td = ( ! empty($SAT))? "" : " style='background: #e84118;'"; 
						
											$WEEK_1_td = ( ! empty($WEEK_1))? "" : " style='background: #e84118;'"; 
											$WEEK_2_td = ( ! empty($WEEK_2))? "" : " style='background: #e84118;'";
											$WEEK_3_td = ( ! empty($WEEK_3))? "" : " style='background: #e84118;'";
											$WEEK_4_td = ( ! empty($WEEK_4))? "" : " style='background: #e84118;'";
											$WEEK_5_td = ( ! empty($WEEK_5))? "" : " style='background: #e84118;'";
											
											$SESUAI_td = '';

											// Jika salah satu data ada yang kosong
											if(
												$ID_SALES == "" OR 
												$USERNAME == "" OR 
												$ID_TOKO_BK == "" OR 
												$NAMA_TOKO == "" OR
												$KODE_DISTRIBUTOR == "" OR
												$SUN == "" OR
												$MON == "" OR
												$TUE == "" OR
												$WED == "" OR
												$THU == "" OR
												$FRI == "" OR
												$SAT == "" OR
												$WEEK_1 == "" OR
												$WEEK_2 == "" OR
												$WEEK_3 == "" OR
												$WEEK_4 == "" OR
												$WEEK_5 == "" 
											){
												$kosong++; // Tambah 1 variabel $kosong
											}
											
											$set_username = ''; $set_nama_toko = ''; $set_distributor = ''; $set_kesesuaian = '';
											
											if($ID_SALES != ""){
												$dt_sales = $this->Model_visit_plan_tso->cek_id_sales($ID_SALES);
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
											}
											
											if($ID_TOKO_BK != ""){
												$dt_toko = $this->Model_visit_plan_tso->cek_id_toko($ID_TOKO_BK);
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
											}
											
											if($KODE_DISTRIBUTOR != ""){
												$dt_distributor = $this->Model_visit_plan_tso->cek_id_distributor($KODE_DISTRIBUTOR);
												if(sizeof($dt_distributor) > 0){
													$set_distributor = $dt_distributor->NAMA_DISTRIBUTOR;
												} else {
													$KODE_DISTRIBUTOR_td = " style='background: #f9ca24;'";
													$set_distributor = "<span style='color: red; font-weight: bold;'>Tidak Tersedia</span>";
													$tdk_tersedia++;
												}
											} else {
												$set_distributor = "<span style='color: red; font-weight: bold;'>Tidak Tersedia</span>";
												$tdk_tersedia++;
											}
											
											if($KODE_DISTRIBUTOR != "" AND $ID_TOKO_BK != "" AND $ID_SALES != ""){
												$dt_sesuai = $this->Model_visit_plan_tso->cek_kesesuaian_data($ID_SALES,$ID_TOKO_BK, $KODE_DISTRIBUTOR);
												if(sizeof($dt_sesuai) > 0){
													$set_kesesuaian = "Sesuai";
																										
												} else {
													$SESUAI_td = " style='background: #f9ca24;'";
													$set_kesesuaian = "<span style='color: red; font-weight: bold;'>Tidak Sesuai</span>";
													$tdk_sesuai++;
												}
											} else{
												$SESUAI_td = " style='background: #f9ca24;'";
												$set_kesesuaian = "<span style='color: red; font-weight: bold;'>Tidak Sesuai</span>";
												$tdk_sesuai++;
											}
											
											$id_tso = $this->session->userdata('user_id');
													// cek sales
													$cek_sales_tso = $this->Model_visit_plan_tso->Get_sales_tso($id_tso, $ID_SALES);
													if(sizeof($cek_sales_tso) == 0){
														$SESUAI_td = " style='background: #f9ca24;'";
														$set_kesesuaian = "<span style='color: red; font-weight: bold;'>Bukan Sales TSO</span>";
														$tdk_sesuai++;
													}
											
											
											echo "<tr>";
												echo "<td".$ID_SALES_td.">".$ID_SALES."</td>";
												echo "<td".$USERNAME_td.">".$set_username."</td>";
												
												echo "<td".$ID_TOKO_BK_td.">".$ID_TOKO_BK."</td>";
												echo "<td".$NAMA_TOKO_td."> ".$set_nama_toko."</td>";
												
												echo "<td".$KODE_DISTRIBUTOR_td.">[".$KODE_DISTRIBUTOR."] -> ".$set_distributor." </td>";
												
												echo "<td".$SUN_td.">".$SUN."</td>";
												echo "<td".$MON_td.">".$MON."</td>";
												echo "<td".$TUE_td.">".$TUE."</td>";
												echo "<td".$WED_td.">".$WED."</td>";
												echo "<td".$THU_td.">".$THU."</td>";
												echo "<td".$FRI_td.">".$FRI."</td>";
												echo "<td".$SAT_td.">".$SAT."</td>";
												
												echo "<td".$WEEK_1_td.">".$WEEK_1."</td>";
												echo "<td".$WEEK_2_td.">".$WEEK_2."</td>";
												echo "<td".$WEEK_3_td.">".$WEEK_3."</td>";
												echo "<td".$WEEK_4_td.">".$WEEK_4."</td>";
												echo "<td".$WEEK_5_td.">".$WEEK_5."</td>";
												echo "<td".$SESUAI_td.">".$set_kesesuaian."</td>";
											echo "</tr>";
										}
										$numrow++; // Tambah 1 setiap kali looping
									}

									echo "</table>";

									// Cek apakah variabel kosong lebih dari 0
									// Jika lebih dari 0, berarti ada data yang masih kosong
									if($kosong > 0 or $tdk_tersedia > 0 or $tdk_sesuai > 0){
										$msg = "Terdapat ($kosong) Kolom yang Belum Diisi dan ($tdk_tersedia) Data Tidak Tesedia serta ($tdk_sesuai) Data tidak sesuai. Harap Periksa Data Kembali.";
										echo "<script type='text/javascript'>alert('$msg');</script>";
										echo "<p style='text-align: center;'><b>Warning:</b> $msg </p>";
									}else{ // Jika semua data sudah diisi
										echo "<hr>";

										// Buat sebuah tombol untuk mengimport data ke database
										echo "<button type='submit' class='btn btn-primary' name='import' onClick='return doconfirm();'><i class='fa fa-cloud-upload' aria-hidden='true'></i> &nbsp Import Data Visit Plan Sales</button>";
										//echo "<a href='".base_url("index.php/Siswa")."'>Cancel</a>";
									}

									echo "</form>";
								}
							?>
								</center>
							
					<center>							
					<?php 
						if($this->session->userdata("after_import") == true) { ?>
						<div class="row">
							<hr>
							<div class="container-fluid">
								<h3>Laporan: <small>Hasil Import Data Visit Plan Sales</small></h3>
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
												<a href="<?php echo base_url(); ?>/master/Sales_Tahunan"><span class="btn btn-success"><i class="fa fa-list-alt "></i> Lihat Hasil</span></a>
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

<!-- Bootstrap modal Add & Edit User-->
<div class="modal fade" id="modal_list_toko_sales" role="dialog">
    <div class="modal-dialog " style="width: 95%;">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: rgba(112, 161, 255,1.0); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: #000;"> Daftar Toko Sales Distributor :</h2>
			</div>
			<form id="form-in">
			<div class="modal-body form" >
				<div class="form-body">
					<p style="margin-left:2em;">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-8" >
                            <div class="form-group">
                                <div class="form-line" id="ListSalesDistributor"></div>
                             </div>
                        </div>
						<span class="btn btn-info btn-sm" id="BtnPreview"> <i class="fa fa-eye"> </i> &nbsp Preview Toko</span> 
						<span class="btn btn-success btn-sm" id="BtnExport" style="float: right;"> <i class="fa fa-file-excel-o"> </i> &nbsp Export</span>
					</p>
					<br>
					<hr>
					<div id="HiddenViewListTokoSales">
					<p><b>Daftar Toko Sales:</b> <span id="DtSalseNama">[] Nama Sales</span> <span style="float: right;"> <b>Total data: </b><span id="TotalTokoSales">[-----]</span> Toko </span></p>
					<div class="col-md-12" >
						<div class="row"> 
							<div class="table-responsive">
								<table class="table table-striped table-bordered dataTable no-footer" id="daftar_toko_sales" style="font-size: 11px;">
									<thead >
										<tr>
											<th bgcolor="#ffb990" width="2%">NO</th>
											<th bgcolor="#ffb990" width="10%">ID CUSTOMER</th> 
											<th bgcolor="#ffb990">NAMA TOKO</th>
											<th bgcolor="#ffb990" width="13%">ID DISTRIBUTOR</th> 
											<th bgcolor="#ffb990">DISTRIBUTOR</th>
											<th bgcolor="#ffb990">KET.</th>
										</tr>
									</thead>
									<tbody id="show_data_toko_sales"></tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				
			</div>
			</form>
		</div>
	</div>
</div>
<!-- Bootstrap modal Add & Edit User-->

<script>

$(document).on("click", "#BtnModalUp", function(){
	ListSales("#ListSalesDistributor");
	$("#HiddenViewListTokoSales").hide();
	$("#modal_list_toko_sales").modal('show');
});

function ListSales(key){
	$(key).html('<p> Loading data sales. Please wait ...</p>');
	
	var type_list = ''; 
	type_list += '<select id="listSales_set" name="listSales_set" class="form-control selectpicker show-tick" data-size="10" data-live-search="true">';
	$.ajax({
            url: "<?php echo base_url(); ?>customer/Visit_plan_tso/List_sd",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data;
				type_list += '<option value="a404a" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Sales Distributor -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i].ID_SALES+'_'+response[i].NAMA_SALES+'_'+response[i].USERNAME+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ['+response[i].ID_SALES+'] - ['+response[i].USERNAME+'] '+response[i].NAMA_SALES+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
				  
			}
        });
} 

$(document).on("click", "#BtnPreview", function(e){
	e.preventDefault();
	$("#daftar_toko_sales").DataTable().destroy();
	var sdSet = $('#listSales_set option:selected').val();
	
	if(sdSet == 'a404a'){
		alert("Masukkan Pilihan Sales Distributor Terlebih Dahulu.");
	} else {
		var strArray = sdSet.split("_");
		$("#DtSalseNama").text('['+strArray[0]+'] - ['+strArray[2]+'] => '+strArray[1]);
		
		$("#HiddenViewListTokoSales").show();
		List_toko_sales(strArray[0]);
	}
});

function List_toko_sales(id_sales){
	$("#show_data_toko_sales").html('<tr><td colspan="10"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>customer/Visit_plan_tso/List_toko',
			type: 'POST',
			dataType : 'json',
			data: {
				"id_sales" : id_sales
			},
			success: function(datasku){
				$("#TotalTokoSales").text('['+datasku.length+']');
				var data = datasku;
				
				var html = '';
				var i;
				var c = "x"; 
				var no = 1 ;
				var ket = '';
				for(i=0; i<data.length; i++){
					
					ket += data[i].NAMA_KECAMATAN+' - '+data[i].NM_KOTA+' - '+data[i].NAMA_PROVINSI+' - REGION '+data[i].REGION_NAME;  
					html += '<tr class='+c+'>'+
						'<td style="text-align: center;">'+no+'</td>'+
						'<td>'+data[i].KD_CUSTOMER+'</td>'+
						'<td>'+data[i].NAMA_TOKO+'</td>'+
						'<td>'+data[i].KODE_DISTRIBUTOR+'</td>'+
						'<td>'+data[i].NAMA_DISTRIBUTOR+'</td>'+
						'<td>'+ket+'</td>'+
					'</tr>';
					
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
					ket = '';
				}
				$('#show_data_toko_sales').html(html);
				$("#daftar_toko_sales").dataTable(
					//{ paging: false }
					//{"lengthMenu": [ [-1], ["All"] ]}
					
				);
			},
			error: function(){
			}
		});
} 

$(document).on("click", "#BtnExport", function(){
		var id_sales; var nama_sales; var username;
		var sdSet = $('#listSales_set option:selected').val();
		if(sdSet == 'a404a'){
			alert("Masukkan Pilihan Sales Distributor Terlebih Dahulu.");
		} else {
			var strArray = sdSet.split("_");
			id_sales = strArray[0];
			username = strArray[2];
			nama_sales = strArray[1];
			
				var objDate = new Date();
				var todayDate = objDate.getDate()+'-'+objDate.getMonth()+'-'+objDate.getFullYear();
				var todayTime = objDate.getHours()+'-'+objDate.getMinutes()+'-'+objDate.getSeconds();
		
			var nama_file = 'Daftar Mapping Toko Sales - '+id_sales+'_'+username+'_'+todayDate+'_'+todayTime;
			
			window.location.href = '<?php echo site_url(); ?>customer/Visit_plan_tso/Export_mapping_toko/'+id_sales+'/'+nama_file;
		}
});

function doconfirm(){
	job=confirm("Anda yakin ingin mengimport data?");
	if(job!=true){
		return false;
	}
}

</script>
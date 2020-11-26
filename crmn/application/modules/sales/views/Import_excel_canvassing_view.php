<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2> Import Schedule Canvassing </h2>
                    </div>
                    <div class="body">
						<div class="row clearfix">
							<p style="margin-left:2em;">Lihat data Sales &nbsp
							<span class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_sales">di sini</span> &nbsp &nbsp Lihat data Customer &nbsp
							<span class="btn btn-info" data-toggle="modal" data-target="#modal_customer">di sini</span>
							</p>
							<hr>
						</div>
                        <div class="row clearfix">
							<div class="col-md-2">
								<a href="<?php echo base_url(); ?>excel/format/import_data_kunjungan.xlsx"><button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-file-excel-o"></i> &nbsp Download Format Import Data</button></a>
							</div>
							<form action="<?php echo base_url("sales/Import_Excel_Canvassing"); ?>" method="post" enctype="multipart/form-data" style="float: right;">
								<div class="col-md-8">
									<input class="form-control" type="file" name="file">
								</div>
								<div class="col-md-2">
									<button name="preview" type="submit" class="btn btn-primary btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-eye"> </i> &nbsp Preview</button>  
								</div>
							</form>
						
						</div>
						
						<div class="row clearfix">
						<center>
							<?php
								if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
									if(isset($upload_error)){ // Jika proses upload gagal
										echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
										die; // stop skrip
									}

									// Buat sebuah tag form untuk proses import data ke database
									echo "<form method='post' action='".base_url("sales/Import_Excel_Canvassing/import")."'>";

									echo "<table class='table table-striped table-bordered' border='1' cellpadding='8'>
									<tr style='background-color: #81ecec;'>
										<th colspan='6'><center>Preview Data Schedule Canvassing</center></th>
									</tr>
									<tr>
										<th>Kode Sales</th>
										<th>Nama Sales</th>
										<th>Kode Customer</th>
										<th>Nama Customer</th>
										<th>Jadwal Kunjungan</th>
										<th>Keterangan (penugasan)</th>
									</tr>";

									$numrow = 1;
									$kosong = 0;
									$tdk_tersedia = 0;

									// Lakukan perulangan dari data yang ada di excel
									// $sheet adalah variabel yang dikirim dari controller
									foreach($sheet as $row){
										// Ambil data pada excel sesuai Kolom
										$kd_sales = $row['A']; // Ambil data id sales
										$kd_customer = $row['B']; // Ambil data id customer
										$jadwal = $row['C']; // Ambil data tanggal kunjungan
										$penugasan= $row['D']; // Ambil data penugasan

										// Cek jika semua data tidak diisi
										if($kd_sales == "" && $kd_customer == "" && $jadwal == "" && $penugasan == "")
											continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
										
										// Cek $numrow apakah lebih dari 1
										// Artinya karena baris pertama adalah nama-nama kolom
										// Jadi dilewat saja, tidak usah diimport
										if($numrow > 1){
											// Validasi apakah semua data telah diisi
											
											
											$kd_sales_td = ( ! empty($kd_sales))? "" : " style='background: #e84118;'"; // Jika id sales kosong, beri warna merah
											$kd_customer_td = ( ! empty($kd_customer))? "" : " style='background: #e84118;'"; // Jika id customer kosong, beri warna merah
											$jadwal_td = ( ! empty($jadwal))? "" : " style='background: #e84118;'"; // Jika jadwal kosong, beri warna merah
											$penugasan_td = ( ! empty($penugasan))? "" : " style='background: #e84118;'"; // Jika penugasan kosong, beri warna merah

											// Jika salah satu data ada yang kosong
											if($kd_sales == "" or $kd_customer == "" or $jadwal == "" or $penugasan == ""){
												$kosong++; // Tambah 1 variabel $kosong
											}
											
											$nama_sales = "";
											
											if($kd_sales != ""){
												$dt_sales = $this->Model_import_excel_canvasing->getSales($kd_sales);
												if(sizeof($dt_sales) > 0){
													$nama_sales = $dt_sales->NAMA;
												} else {
													$nama_sales = "<span style='color: red; font-weight: bold;'>Data Tidak Tersedia</span>";
													$tdk_tersedia++;
												}
											}
											
											$nama_customer = "";
											if($kd_customer != ""){
												$dt_customer = $this->Model_import_excel_canvasing->getCustomer($kd_customer);
												if(sizeof($dt_customer) > 0){
													$nama_customer = $dt_customer->NAMA_TOKO;
												} else {
													$nama_customer = "<span style='color: red; font-weight: bold;'>Data Tidak Tersedia</span>";
													$tdk_tersedia++;
												}
											}
											
											echo "<tr>";
											echo "<td".$kd_sales_td.">".$kd_sales."</td>";
											echo "<td>".strtoupper($nama_sales)."</td>";
											echo "<td".$kd_customer_td.">".$kd_customer."</td>";
											echo "<td>".strtoupper($nama_customer)."</td>";
											echo "<td".$jadwal_td.">".$jadwal."</td>";
											echo "<td".$penugasan_td.">".$penugasan."</td>";
											echo "</tr>";
										}
										$numrow++; // Tambah 1 setiap kali looping
									}

									echo "</table>";

									// Cek apakah variabel kosong lebih dari 0
									// Jika lebih dari 0, berarti ada data yang masih kosong
									if($kosong > 0 or $tdk_tersedia > 0){
										$msg = "Terdapat ($kosong) Kolom yang Belum Diisi dan ($tdk_tersedia) Data Tidak Tersedia. Harap Periksa Data Kembali.";
										echo "<script type='text/javascript'>alert('$msg');</script>";
									
									}else{ // Jika semua data sudah diisi
										echo "<hr>";

										// Buat sebuah tombol untuk mengimport data ke database
										echo "<button type='submit' class='btn btn-primary' name='import' onClick='return doconfirm();'><i class='fa fa-cloud-upload' aria-hidden='true'></i> &nbsp Import Data</button>";
										//echo "<a href='".base_url("index.php/Siswa")."'>Cancel</a>";
									}

									echo "</form>";
								}
							?>
						</center>
						</div>
						<?php 
						if($this->session->userdata("after_import") == true) { ?>
						<div class="row">
							<hr>
							<div class="container-fluid">
								<h3>Laporan: <small>Hasil Import Data Canvassing</small></h3>
								<table class="table table-striped table-bordered" width="100%" border="1" >
									<thead>
										<tr style="background-color: #81ecec;">
											<th style="text-align: center;">Total Baris Data</th>
											<th style="text-align: center;">Data Sukses</th>
											<th style="text-align: center;">Data Sama</th> 
											<th style="text-align: center;">Action</th>
										</tr>
									</thead>
									<tbody>
										<tr style="text-align: center;">
											<td style="text-align: center;"><?= $this->session->userdata("baris_data"); ?></td>
											<td style="text-align: center;"><?= $this->session->userdata("data_sukses"); ?></td>
											<td style="text-align: center;"><?= $this->session->userdata("data_sama"); ?></td>
											<td style="text-align: center;">
												<span class="btn btn-success"><i class="fa fa-list-alt "></i> Lihat Hasil</span>
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
							$this->session->set_userdata("data_sama", null);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Bootstrap modal Sales-->
<div class="modal fade" id="modal_sales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title"><span class="btn btn-success" onclick="return exportTableToExcel('table_data_sales')"><i class="fa fa-file-excel-o"></i> Export data</span> &nbsp Daftar <?= sizeof($salesku);?> Data Sales Distributor: <span style="color: blue;"><?= $this->session->userdata("nama_dist"); ?></span></h3>
				
			</div>
			
			<div class="modal-body">
				<table id="table_data_sales" class="table table-striped table-bordered" width="100%" border="1">
					<thead>
						<tr>
							<th width="3%">No.</th>
							<th>Kode Sales</th>
							<th>Nama Sales</th>
							<th> Area</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$counting= 1;
					foreach($salesku as $salesKey => $salesValue){ ?>
						<tr>
							<td><?= $counting++; ?></td>
							<td><?= $salesValue->ID_USER; ?></td>
							<td><?= strtoupper($salesValue->NAMA); ?></td>
							<td><?= $salesValue->USER_AREA; ?></td>
						<tr>
					<?php } ?>
					<tbody>
				</table>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal sales-->

<!-- Bootstrap modal Customer-->
<div class="modal fade" id="modal_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 100%;">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title"><span class="btn btn-success" onclick="return exportTableToExcel('table_data_customer')"><i class="fa fa-file-excel-o"></i> Export data</span> &nbsp Daftar <?= sizeof($customerku);?> Data Customer Distributor: <span style="color: blue;"><?= $this->session->userdata("nama_dist"); ?></span></h3>
				
			</div>
			
			<div class="modal-body">
				<table id="table_data_customer" class="table table-striped table-bordered"  width="100%" border="1" style="font-size: 10px;">
					<thead>
						<tr>
							<th width="3%">No.</th>
							<th width="7%">ID Customer</th>
                            <th>Nama Toko</th>
                            <th>Nama Pemilik</th>
							<th width="8%">Provinsi</th>
                            <th>Kota</td>
                            <th>Kecamatan</th>
							<th>Alamat</th>
							<th>Telepon</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$countingg= 1;
					foreach($customerku as $customerKey => $customerValue){ ?>
						<tr>
							<td><?= $countingg++;?></td>
							<td><?= $customerValue->ID_CUSTOMER;?></td>
							<td><?= strtoupper($customerValue->NAMA_TOKO);?></td>
							<td><?= strtoupper($customerValue->NAMA_PEMILIK);?></td>
							<td><?= strtoupper($customerValue->NAMA_PROVINSI);?></td>
							<td><?= strtoupper($customerValue->NAMA_DISTRIK);?></td>
							<td><?= strtoupper($customerValue->NAMA_KECAMATAN);?></td>
							<td><?= strtoupper($customerValue->ALAMAT);?></td>
							<td><?= $customerValue->TELP_PEMILIK;?></td>
						<tr>
					<?php } ?>
					<tbody>
				</table>
			</div>
			
			<div class="modal-footer">
				
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal customer-->

<script>

function exportTableToExcel(tableID){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
	
	var nama_table = '';
	if(tableID == 'table_data_sales'){
		nama_table = 'Sales';
	} else {
		nama_table = 'Customer';
	}
	
	var objDate = new Date();
	var todayDate = objDate.getDate()+'-'+objDate.getMonth()+'-'+objDate.getFullYear();
	var todayTime = objDate.getHours()+'_'+objDate.getMinutes()+'_'+objDate.getSeconds();
	
	var filename = 'Data List '+nama_table+' Distributor (<?= $this->session->userdata("nama_dist");?>)-('+todayDate+ ' '+todayTime+')';
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}

function doconfirm(){
	job=confirm("Anda yakin ingin mengimport data?");
	if(job!=true){
		return false;
	}
}

</script>
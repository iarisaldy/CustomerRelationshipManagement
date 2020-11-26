<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
            <div class="card" style="padding-bottom: 0;">
				<div class="header bg-cyan">
                    <h2 style="padding-top: 0.2em;">IMPORT USER </h2>
                </div>
				<div class="body">
					<div class="row clearfix">
						<p style="margin-left:2em;"><b>Lihat data:</b> &nbsp Jenis User
							<span class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_j_u">Di sini</span> 
						</p>
						<hr>
					</div>
                    <div class="row clearfix">
						<div class="col-md-2">
							<a href="<?php echo base_url(); ?>excel/format/import_data_user.xlsx"><button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-file-excel-o"></i> &nbsp Download Format Import Data User</button></a>
						</div>
						<form action="<?php echo base_url("user/Manajemen_user/Import_excel"); ?>" method="post" enctype="multipart/form-data" style="float: right;">
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
									echo "<form method='post' action='".base_url("user/Manajemen_user/import")."'>";

									echo "<table class='table table-striped table-bordered' border='1' cellpadding='8'>
									<tr style='background-color: #81ecec;'>
										<th colspan='4'><center>Preview Data User</center></th>
									</tr>
									<tr>
										<th>Nama Sales</th>
										<th>Username</th>
										<th>Password</th>
										<th>Jenis User</th>
										
									</tr>";

									$numrow = 1;
									$kosong = 0;
									$tdk_tersedia = 0;

									// Lakukan perulangan dari data yang ada di excel
									// $sheet adalah variabel yang dikirim dari controller
									foreach($sheet as $row){
										// Ambil data pada excel sesuai Kolom
										$nama_sales = $row['A']; // Ambil data id sales
										$username = $row['B']; // Ambil data id customer
										$password = $row['C']; // Ambil data tanggal kunjungan
										$jenis_user = $row['D']; // Ambil data penugasan

										// Cek jika semua data tidak diisi
										if($nama_sales == "" && $username == "" && $password == "" && $jenis_user == "")
											continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
										
										// Cek $numrow apakah lebih dari 1
										// Artinya karena baris pertama adalah nama-nama kolom
										// Jadi dilewat saja, tidak usah diimport
										if($numrow > 1){
											// Validasi apakah semua data telah diisi
											
											
											$nama_sales_td = ( ! empty($nama_sales))? "" : " style='background: #e84118;'"; // Jika nama sales kosong, beri warna merah
											$username_td = ( ! empty($username))? "" : " style='background: #e84118;'"; // Jika username kosong, beri warna merah
											$password_td = ( ! empty($password))? "" : " style='background: #e84118;'"; // Jika password kosong, beri warna merah
											$jenis_user_td = ( ! empty($jenis_user))? "" : " style='background: #e84118;'"; // Jika jenis user kosong, beri warna merah

											// Jika salah satu data ada yang kosong
											if($nama_sales == "" or $username == "" or $password == "" or $jenis_user == ""){
												$kosong++; // Tambah 1 variabel $kosong
											}
											
											$j_user = "";
											
											if($jenis_user != ""){
												$dt_j_user = $this->user_model->getJenisUser($jenis_user);
												if(sizeof($dt_j_user) > 0){
													$j_user = $dt_j_user->JENIS_USER;
												} else {
													$j_user = "<span style='color: red; font-weight: bold;'>Data Tidak Tersedia</span>";
													$tdk_tersedia++;
												}
											}
											
											echo "<tr>";
											echo "<td".$nama_sales_td.">".$nama_sales."</td>";
											echo "<td".$username_td.">".$username."</td>";
											echo "<td".$password_td.">".$password."</td>";
											echo "<td".$jenis_user_td.">[".$jenis_user."] - ".strtoupper($j_user)."</td>";
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
								<h3>Laporan: <small>Hasil Import Data User</small></h3>
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
											<td style="text-align: center;"><?= $this->session->userdata("data_sukses"); ?></td>
											<td style="text-align: center;"><?= $this->session->userdata("data_sukses"); ?></td>
											<td style="text-align: center;"><?= $this->session->userdata("data_sama"); ?></td>
											<td style="text-align: center;">
												<a href="<?php echo base_url(); ?>user/Manajemen_user"><span class="btn btn-success"><i class="fa fa-list-alt "></i> Lihat Hasil</span></a>
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
					
					
                    <div class="row">
						<div class="col-md-12">
						
							
						
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</section>

<!-- Bootstrap modal Sales-->
<div class="modal fade" id="modal_j_u" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title"><span class="btn btn-success" onclick="return exportTableToExcel('table_data_j_u')"><i class="fa fa-file-excel-o"></i> &nbsp; Export data</span> &nbsp Daftar Jenis User: <span style="color: blue;"></span></h3>
				
			</div>
			
			<div class="modal-body">
				<table id="table_data_j_u" class="table table-striped table-bordered" width="100%" border="1">
					<thead>
						<tr>
							<th width="3%">No.</th>
							<th>KODE</th>
							<th>JENIS USER</th>
						</tr>
					</thead>
					<tbody id="show_data">
					<?php 
					$counting= 1;
					foreach($jenis_user_u as $jenis_userKey => $jenis_userValue){ ?>
						<tr>
							<td><?= $counting++; ?></td>
							<td><?= $jenis_userValue->ID_JENIS_USER; ?></td>
							<td><?= strtoupper($jenis_userValue->JENIS_USER); ?></td>
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

<script>

function exportTableToExcel(tableID){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
	
	var nama_table = '';
	if(tableID == 'table_data_j_u'){
		nama_table = 'Jenis User';
	} else {
		nama_table = '';
	}
	
	var objDate = new Date();
	var todayDate = objDate.getDate()+'-'+objDate.getMonth()+'-'+objDate.getFullYear();
	var todayTime = objDate.getHours()+'_'+objDate.getMinutes()+'_'+objDate.getSeconds();
	
	var filename = 'Data List '+nama_table+'-('+todayDate+ ' '+todayTime+')';
    
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
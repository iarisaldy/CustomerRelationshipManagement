<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
            <div class="card" style="padding-bottom: 0;">
				<div class="header bg-cyan">
                    <h2 style="padding-top: 0.2em;">MANAJEMEN USER HIERARKI</h2>
                </div>
					
                <div class="body">
                    <div class="row">
						<div class="col-md-12">
							<div>
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#gsm" aria-controls="gsm" role="tab" data-toggle="tab"><b>GENERAL SALES MANAGER (GSM)</b></a></li>
									<li role="presentation"><a href="#ssm" aria-controls="ssm" role="tab" data-toggle="tab"><b>SENIOR SALES MANAGER (SSM)</b></a></li>
									<li role="presentation"><a href="#sm" aria-controls="sm" role="tab" data-toggle="tab"><b>SALES MANAGER (SM)</b></a></li>
									<li role="presentation"><a href="#so" aria-controls="so" role="tab" data-toggle="tab"><b>AREA MANAGER (AM)</b></a></li>
									<li role="presentation"><a href="#sd" aria-controls="fs" role="tab" data-toggle="tab"><b>SALES DIST (SD)</b></a></li>
									<li role="presentation"><a href="#dist" aria-controls="fs" role="tab" data-toggle="tab"><b>| &nbsp;&nbsp; <i class="fa fa-truck" aria-hidden="true"></i> DISTRIBUTOR (DIST)</b></a></li>
									<li role="presentation"><a href="#spc" aria-controls="fs" role="tab" data-toggle="tab"><b><i class="fa fa-bar-chart" aria-hidden="true"></i> SPC</b></a></li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane fade in active" id="gsm">
										<h4>
											<span id="BtnTambah_gsm" style="float: right; margin: 0 1em 0 1em;" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah GSM</span>
											
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Export_excel/gsm"><span style="float: right; margin-left: 1em;" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> &nbsp; Export GSM</span></a>
											
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Import_excel"><span style="float: right;" class="btn btn-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Import User</span></a>
											<span >Daftar User General Sales Manager (GSM) </span>
										</h4>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_gsm">
												<thead class="w">
													<tr>
														<th width="2%">No</th>
														<th>ID USER</th>
														<th>Nama Sales</th>
														<th>Username</th>
														<th>Password</th>
														<th>Email</th>
														<th style="text-align:center;">Detail</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data"></tbody>
											</table>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane fade in" id="ssm">
										<h4>
											<span>Daftar User Senior Sales Manager (SSM)</span>
											<span id="BtnTambah_ssm" style="float: right; margin: 0 1em 0 1em;" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah SSM</span>
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Export_excel/ssm"><span style="float: right; margin-left: 1em;" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> &nbsp; Export SSM</span></a>
											
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Import_excel"><span style="float: right;" class="btn btn-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Import User</span></a>
										</h4>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_ssm">
												<thead class="w">
													<tr>
														<th width="2%">No</th>
														<th>ID USER</th>
														<th>Nama Sales</th>
														<th>Username</th>
														<th>Password</th>
														<th>Email</th>
														<th style="text-align:center;">Detail</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_ssm"></tbody>
											</table>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane fade in" id="sm">
										<h4>
											<span>Daftar User Sales Manager (SM)</span>
											<span id="BtnTambah_sm" style="float: right; margin: 0 1em 0 1em;" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah SM</span>
											
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Export_excel/sm"><span style="float: right; margin-left: 1em;" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> &nbsp; Export SM</span></a>
											
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Import_excel"><span style="float: right;" class="btn btn-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Import User</span></a>
										</h4>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_sm">
												<thead class="w">
													<tr>
														<th width="2%">No</th>
														<th>ID USER</th>
														<th>Nama Sales</th>
														<th>Username</th>
														<th>Password</th>
														<th>Email</th>
														<th style="text-align:center;">Detail</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_sm"></tbody>
											</table>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane fade in" id="so">
										<h4>
											<span>Daftar User Area Manager (AM)</span>
											<span id="BtnTambah_so" style="float: right; margin: 0 1em 0 1em;" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah AM</span>
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Export_excel/so"><span style="float: right; margin-left: 1em;" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> &nbsp; Export AM</span></a>
											
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Import_excel"><span style="float: right;" class="btn btn-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Import User</span></a>
										</h4>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_so">
												<thead class="w">
													<tr>
														<th width="2%">No</th>
														<th>ID USER</th>
														<th>Nama Sales</th>
														<th>Username</th>
														<th>Password</th>
														<th>Email</th>
														<th style="text-align:center;">Detail</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_so"></tbody>
											</table>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane fade in" id="sd">
										<h4>
											<span>Daftar User Sales Distributor (SD)</span>
											<span id="BtnTambah_sd" style="float: right; margin: 0 1em 0 1em;" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah SD</span>
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Export_excel/sd"><span style="float: right; margin-left: 1em;" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> &nbsp; Export SD</span></a>
											
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Import_excel"><span style="float: right;" class="btn btn-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Import User</span></a>
										</h4>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_sd">
												<thead class="w">
													<tr>
														<th width="2%">No</th>
														<th>ID USER</th>
														<th>Nama Sales</th>
														<th>Username</th>
														<th>Password</th>
														<th>Email</th>
														<th style="text-align:center;">Detail</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_sd"></tbody>
											</table>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane fade in" id="dist">
										<h4>
											<span>Daftar User Distributor (DIST)</span>
											<span id="BtnTambah_dist" style="float: right; margin: 0 1em 0 1em;" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah DIST</span>
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Export_excel/dist"><span style="float: right; margin-left: 1em;" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> &nbsp; Export DIST</span></a>
											
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Import_excel"><span style="float: right;" class="btn btn-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Import User</span></a>
										</h4>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_dist">
												<thead class="w">
													<tr>
														<th width="2%">No</th>
														<th>ID USER</th>
														<th>Nama Distributor</th>
														<th>Username</th>
														<th>Password</th>
														<th>Email</th>
														<th style="text-align:center;">Detail</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_dist"></tbody>
											</table>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane fade in" id="spc">
										<h4>
											<span>Daftar User SPC (SPC)</span>
											<span id="BtnTambah_spc" style="float: right; margin: 0 1em 0 1em;" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah SPC</span>
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Export_excel/spc"><span style="float: right; margin-left: 1em;" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> &nbsp; Export SPC</span></a>
											
											<a target="_blank" target="_blank" href="<?php echo base_url(); ?>user/Manajemen_user/Import_excel"><span style="float: right;" class="btn btn-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Import User</span></a>
										</h4>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_spc">
												<thead class="w">
													<tr>
														<th width="2%">No</th>
														<th>ID USER</th>
														<th>Nama SPC</th>
														<th>Username</th>
														<th>Password</th>
														<th>Email</th>
														<th style="text-align:center;">Detail</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_spc"></tbody>
											</table>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
    </div>
</section>


<!-- Bootstrap modal Add & Edit User-->
<div class="modal fade" id="modal_user_a_u" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: rgba(112, 161, 255,1.0); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: #000;">  </h2>
			</div>
			<form id="form-in">
			<div class="modal-body form" >
				<div class="form-body">
					<input type="hidden" id="id_up_user" name="id_up_user">
					<input type="hidden" id="id_jenis_user" name="id_jenis_user">
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label id="labelNama1" for="name">Nama User : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="nama_user" class="form-control" name="nama_user" placeholder="Masukkan Nama " required>
								</div>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label for="name">Username : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="username_user" class="form-control" name="username_user" placeholder="Masukkan Username " required>
								</div>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label for="name">Password : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="password_user" class="form-control" name="password_user" placeholder="Masukkan Password " required>
								</div>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label for="name">Alamat Email : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="email" id="email_user" class="form-control" name="email_user" placeholder="Masukkan Email " required>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="BtnSimpanUser" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batalkan</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- Bootstrap modal Add & Edit User-->

<!-- End Bootstrap modal Hapus User -->
<div class="modal fade" id="modal_hapus_user" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: rgba(255, 127, 80,1.0); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: #000;">  </h2>
			</div>
			<form>
			<div class="modal-body form" >
				<div class="form-body">
					<input type="hidden" id="id_user_hapus" name="id_user_hapus">
					<p><b>Note:</b> Menghapus data user, dapat mengakibatkan data setting mapping user yang sudah dibuat juga hilang.</p>
					<p>Apakah anda yakin ingin menghapus data?</p>
				</div>
			</div>
			<div class="modal-footer">
				<button id="BtnHapusUser" class="btn btn-danger">Hapus</button>
				<button type="button" class="btn btn-info" data-dismiss="modal">Batalkan</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- End Bootstrap modal Hapus User -->

<!-- Bootstrap modal mapping GSM--
<div class="modal fade" id="modal_mapping_gsm" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: rgba(241, 242, 246,1.0); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: #000;">  </h2>
			</div>
			<form>
			<div class="modal-body form" >
				<div class="form-body">
					<input type="hidden" id="id_user_gsm" name="id_user_gsm">
					<div class="row clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
							<label for="name">Wilayah Cakupan : </label>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
							<div class="form-group">
								<div class="form-line" id="list_opt_region"> 
								 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="BtnSimpanMappingGsm" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batalkan</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- End Bootstrap modal mapping GSM -->

<!-- Bootstrap modal mapping SSM--
<div class="modal fade" id="modal_mapping_ssm" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: rgba(241, 242, 246,1.0); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: #000;">  </h2>
			</div>
			<form>
			<div class="modal-body form" >
				<div class="form-body">
					<input type="hidden" id="jenis_user" name="id_jenis_user">
					<input type="hidden" id="id_user_ssm" name="id_user_ssm">
					<div class="row clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
							<label id="atasan_label" for="name"> </label>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
							<div class="form-group">
								<div class="form-line" id="list_gsm_opt"> 
								 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="BtnSimpanMappingSsm" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batalkan</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- End Bootstrap modal mapping SSM -->

<script>

$(document).ready(function() {
   load_gsm();
   load_ssm();
   load_sm();
   load_so();
   load_sd();
   load_dist();
   load_spc();
});

$(document).on("click", "#BtnTambah_gsm", function(){
	$('#form-in').trigger("reset");
	$("#id_up_user").val(0000);
	$("#id_jenis_user").val(1016);
	$("#modal_user_a_u").modal('show');
	$('#labelNama').text('Nama Sales : ');
	$('.modal-title').text('Tambah User GSM : ');
});

$(document).on("click", "#BtnEdit_gsm", function(){
	$("#modal_user_a_u").modal('show');
	
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	var username = $(this).attr("dt_username");
	var password = $(this).attr("dt_password");
	var email = $(this).attr("dt_email");
	
	$("#email_user").val(email);
	$("#id_up_user").val(id_user);
	$("#id_jenis_user").val(1016);
	$("#nama_user").val(nama_user);
	$("#username_user").val(username);
	$("#password_user").val(password);
	
	
	$('.modal-title').text('Edit User GSM : ['+id_user+'] '+nama_user);
});

$(document).on("click", "#BtnHapus_gsm", function(){
	$("#modal_hapus_user").modal('show');
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	$("#id_user_hapus").val(id_user);
	$('.modal-title').text('Hapus User GSM : ['+id_user+'] '+nama_user);
});

/* 404
$(document).on("click", "#BtnMapping_gsm", function(){
	$("#modal_mapping_gsm").modal('show');
	var in_id_user 	= $(this).attr("dt_id_user");
	var in_nama 	= $(this).attr("dt_nama");
	var in_wilayah	= $(this).attr("dt_wilayah");
	
	//console.log(in_wilayah);  
	$("#id_user_gsm").val(in_id_user);
	list_region('#list_opt_region', in_wilayah); 
	//$("#wil_cakupan_gsm").val(in_wilayah).change();
	$('.modal-title').text('Mapping User GSM : ['+in_id_user+'] '+in_nama); 
});

$(document).on("click", "#BtnSimpanMappingGsm", function(){
	var wilayah_cak = $('#wil_cakupan_gsm option:selected').val();
	var gsm = $("#id_user_gsm").val();
	//console.log(wilayah_cak+'-'+gsm);
	$.ajax({
		url: '<?php echo site_url(); ?>user/Manajemen_user/setWilayahGsm',
		type: 'POST',
		data: {
			"id_gsm"  : gsm,
			"wilayah" : wilayah_cak
		},
		success: function(data){
			$("#modal_mapping_gsm").modal('hide');
			alert("Data Mapping Berhasil Disimpan.");
			$("#daftar_gsm").DataTable().destroy();
			load_gsm();
		},
		error: function(){
			$("#modal_mapping_gsm").modal('hide');
			alert("Data Mapping Gagal Disimpan.");
		}
    });
});
*/

$(document).on("click", "#BtnTambah_ssm", function(){
	$('#form-in').trigger("reset");
	$("#id_up_user").val(0000);
	$("#id_jenis_user").val(1010);
	$("#modal_user_a_u").modal('show');
	$('#labelNama').text('Nama Sales : ');
	$('.modal-title').text('Tambah User SSM : ');
});

$(document).on("click", "#BtnEdit_ssm", function(){
	$("#modal_user_a_u").modal('show');
	
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	var username = $(this).attr("dt_username");
	var password = $(this).attr("dt_password");
	var email = $(this).attr("dt_email");
	
	$("#email_user").val(email);
	$("#id_up_user").val(id_user);
	$("#id_jenis_user").val(1010);
	$("#nama_user").val(nama_user);
	$("#username_user").val(username);
	$("#password_user").val(password);
	
	$('.modal-title').text('Edit User SSM : ['+id_user+'] '+nama_user);
});

$(document).on("click", "#BtnHapus_ssm", function(){
	$("#modal_hapus_user").modal('show');
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	$("#id_user_hapus").val(id_user);
	$('.modal-title').text('Hapus User SSM : ['+id_user+'] '+nama_user);
});

/* 404
$(document).on("click", "#BtnMapping_ssm", function(){
	$("#modal_mapping_ssm").modal('show');
	var in_id_user 	= $(this).attr("dt_id_user");
	var in_nama 	= $(this).attr("dt_nama");
	var in_atasan	= $(this).attr("dt_atasan");
	var in_jenis_user = $(this).attr("dt_jenis_user");
	
	//console.log(in_atasan);  
	$("#id_user_ssm").val(in_id_user);
	$("#jenis_user").val(in_jenis_user);
	list_gsm('#list_gsm_opt', in_atasan); 
	//$("#wil_cakupan_gsm").val(in_wilayah).change();
	$('.modal-title').text('Mapping User SSM : ['+in_id_user+'] '+in_nama); 
	$('#atasan_label').text('Atasan Langsung (GSM):');
});
*/

$(document).on("click", "#BtnTambah_sm", function(){
	$('#form-in').trigger("reset");
	$("#id_up_user").val(0000);
	$("#id_jenis_user").val(1011);
	$("#modal_user_a_u").modal('show');
	$('#labelNama').text('Nama Sales : ');
	$('.modal-title').text('Tambah User SM : ');
});

$(document).on("click", "#BtnEdit_sm", function(){
	$("#modal_user_a_u").modal('show');
	
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	var username = $(this).attr("dt_username");
	var password = $(this).attr("dt_password");
	var email = $(this).attr("dt_email");
	
	$("#email_user").val(email);
	$("#id_up_user").val(id_user);
	$("#id_jenis_user").val(1011);
	$("#nama_user").val(nama_user);
	$("#username_user").val(username);
	$("#password_user").val(password);
	
	$('.modal-title').text('Edit User SM : ['+id_user+'] '+nama_user);
});

$(document).on("click", "#BtnHapus_sm", function(){
	$("#modal_hapus_user").modal('show');
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	$("#id_user_hapus").val(id_user);
	$('.modal-title').text('Hapus User SM : ['+id_user+'] '+nama_user);
});

/* 404
$(document).on("click", "#BtnMapping_sm", function(){
	$("#modal_mapping_ssm").modal('show');
	var in_id_user 	= $(this).attr("dt_id_user");
	var in_nama 	= $(this).attr("dt_nama");
	var in_atasan	= $(this).attr("dt_atasan");
	var in_jenis_user = $(this).attr("dt_jenis_user");
	
	//console.log(in_atasan);  
	$("#id_user_ssm").val(in_id_user);
	$("#jenis_user").val(in_jenis_user);
	list_ssm('#list_gsm_opt', in_atasan); 
	//$("#wil_cakupan_gsm").val(in_wilayah).change();
	$('.modal-title').text('Mapping User SM : ['+in_id_user+'] '+in_nama); 
	$('#atasan_label').text('Atasan Langsung (SSM):');
});
*/

$(document).on("click", "#BtnTambah_so", function(){
	$('#form-in').trigger("reset");
	$("#id_up_user").val(0000);
	$("#id_jenis_user").val(1012);
	$("#modal_user_a_u").modal('show');
	$('#labelNama').text('Nama Sales : ');
	$('.modal-title').text('Tambah User SO : ');
});

$(document).on("click", "#BtnEdit_so", function(){
	$("#modal_user_a_u").modal('show');
	
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	var username = $(this).attr("dt_username");
	var password = $(this).attr("dt_password");
	var email = $(this).attr("dt_email");
	
	$("#email_user").val(email);
	$("#id_up_user").val(id_user);
	$("#id_jenis_user").val(1012);
	$("#nama_user").val(nama_user);
	$("#username_user").val(username);
	$("#password_user").val(password);
	
	$('.modal-title').text('Edit User SO : ['+id_user+'] '+nama_user);
});

$(document).on("click", "#BtnHapus_so", function(){
	$("#modal_hapus_user").modal('show');
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	$("#id_user_hapus").val(id_user);
	$('.modal-title').text('Hapus User SO : ['+id_user+'] '+nama_user);
});

/* 404
$(document).on("click", "#BtnMapping_so", function(){
	$("#modal_mapping_ssm").modal('show');
	var in_id_user 	= $(this).attr("dt_id_user");
	var in_nama 	= $(this).attr("dt_nama");
	var in_atasan	= $(this).attr("dt_atasan");
	var in_jenis_user = $(this).attr("dt_jenis_user");
	
	//console.log(in_atasan);  
	$("#id_user_ssm").val(in_id_user);
	$("#jenis_user").val(in_jenis_user);
	list_sm('#list_gsm_opt', in_atasan); 
	//$("#wil_cakupan_gsm").val(in_wilayah).change();
	$('.modal-title').text('Mapping User SO : ['+in_id_user+'] '+in_nama); 
	$('#atasan_label').text('Atasan Langsung (SM):');
});
*/


$(document).on("click", "#BtnTambah_sd", function(){
	$('#form-in').trigger("reset");
	$("#id_up_user").val(0000);
	$("#id_jenis_user").val(1015);
	$("#modal_user_a_u").modal('show');
	$('#labelNama').text('Nama Sales : ');
	$('.modal-title').text('Tambah User SD : ');
});

$(document).on("click", "#BtnEdit_sd", function(){
	$("#modal_user_a_u").modal('show');
	
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	var username = $(this).attr("dt_username");
	var password = $(this).attr("dt_password");
	var email = $(this).attr("dt_email");
	
	$("#email_user").val(email);
	$("#id_up_user").val(id_user);
	$("#id_jenis_user").val(1015);
	$("#nama_user").val(nama_user);
	$("#username_user").val(username);
	$("#password_user").val(password);
	
	$('.modal-title').text('Edit User SD : ['+id_user+'] '+nama_user);
});

$(document).on("click", "#BtnHapus_sd", function(){
	$("#modal_hapus_user").modal('show');
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	$("#id_user_hapus").val(id_user);
	$('.modal-title').text('Hapus User SD : ['+id_user+'] '+nama_user);
});

//------------------------------------
//------------------------------------

$(document).on("click", "#BtnTambah_dist", function(){
	$('#form-in').trigger("reset");
	$("#id_up_user").val(0000);
	$("#id_jenis_user").val(1013);
	$("#modal_user_a_u").modal('show');
	$('#labelNama').text('Nama : ');
	$('.modal-title').text('Tambah User Distributor : ');
});

$(document).on("click", "#BtnEdit_dist", function(){
	$("#modal_user_a_u").modal('show');
	
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	var username = $(this).attr("dt_username");
	var password = $(this).attr("dt_password");
	var email = $(this).attr("dt_email");
	
	$("#email_user").val(email);
	$("#id_up_user").val(id_user);
	$("#id_jenis_user").val(1013);
	$("#nama_user").val(nama_user);
	$("#username_user").val(username);
	$("#password_user").val(password);
	
	$('.modal-title').text('Edit User DIST : ['+id_user+'] '+nama_user);
});

$(document).on("click", "#BtnHapus_dist", function(){
	$("#modal_hapus_user").modal('show');
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	$("#id_user_hapus").val(id_user);
	$('.modal-title').text('Hapus User DIST : ['+id_user+'] '+nama_user);
});

// fungsi untuk semua
$(document).on("click", "#BtnSimpanUser", function(e){
	e.preventDefault();
	
	var id_user 		= $("#id_up_user").val();
	var nama_user 		= $("#nama_user").val();
	var username 		= $("#username_user").val();
	var password 		= $("#password_user").val();
	var id_jenis_user 	= $("#id_jenis_user").val();
	var email 			= $("#email_user").val();
	
	//console.log(id_user+'-'+nama_user+'-'+username+'-'+password+'-'+id_jenis_user);
	
	$.ajax({
		url: '<?php echo site_url(); ?>user/Manajemen_user/set_user_sales',
		type: 'POST',
		data: {
			"id_user" : id_user,
			"nama" : nama_user,
			"username" : username,
			"password" : password,
			"id_jenis_user" : id_jenis_user,
			"email" : email
		},
		success: function(data){
			$("#modal_user_a_u").modal('hide');
			alert("Data User Berhasil Disimpan.");
			$("#daftar_gsm").DataTable().destroy();
			load_gsm();
			$("#daftar_ssm").DataTable().destroy();
			load_ssm();
			$("#daftar_sm").DataTable().destroy();
			load_sm();
			$("#daftar_so").DataTable().destroy();
			load_so(); 
			$("#daftar_sd").DataTable().destroy();
			load_sd();
			$("#daftar_dist").DataTable().destroy();
			load_dist();
			$("#daftar_spc").DataTable().destroy();
			load_spc();
		},
		error: function(){
			$("#modal_user_a_u").modal('hide');
			alert("Data User Gagal Disimpan.");
		}
    });
});

$(document).on("click", "#BtnHapusUser", function(e){
	e.preventDefault();
	
	var id_user = $("#id_user_hapus").val();
	$.ajax({
		url: '<?php echo site_url(); ?>user/Manajemen_user/del_user_sales',
		type: 'POST',
		data: {
			"id_user" : id_user
		},
		success: function(data){
			$("#modal_hapus_user").modal('hide');
			alert("Data User Berhasil Dihapus.");
			$("#daftar_gsm").DataTable().destroy();
			load_gsm();
			$("#daftar_ssm").DataTable().destroy();
			load_ssm();
			$("#daftar_sm").DataTable().destroy();
			load_sm();
			$("#daftar_so").DataTable().destroy();
			load_so();
			$("#daftar_sd").DataTable().destroy();
			load_sd();
			$("#daftar_dist").DataTable().destroy();
			load_dist();
			$("#daftar_spc").DataTable().destroy();
			load_spc();
		},
		error: function(){
			$("#modal_hapus_user").modal('hide');
			alert("Data User Gagal Dihapus.");
		}
    });
});

/* 404
//mapping untuk semua
$(document).on("click", "#BtnSimpanMappingSsm", function(){
	var atasan;
	var jenis_user = $("#jenis_user").val();
	if(jenis_user == 1010){
		atasan = $('#list_gsm option:selected').val();
	} else if(jenis_user == 1011){
		atasan = $('#list_ssm option:selected').val();
	} else if(jenis_user == 1012){
		atasan = $('#list_sm option:selected').val();
	} else if(jenis_user == 1003){
		atasan = $('#list_so option:selected').val();
	}
	
	var ssm = $("#id_user_ssm").val();
	console.log(jenis_user);
	
	$.ajax({
		url: '<?php echo site_url(); ?>user/Manajemen_user/setAtasan',
		type: 'POST',
		data: {
			"id_user"  : ssm,
			"atasan" : atasan
		},
		success: function(data){
			$("#modal_mapping_ssm").modal('hide');
			alert("Data Mapping Berhasil Disimpan.");
			$("#daftar_gsm").DataTable().destroy();
			load_gsm();
			$("#daftar_ssm").DataTable().destroy();
			load_ssm();
			$("#daftar_sm").DataTable().destroy();
			load_sm();
			$("#daftar_so").DataTable().destroy();
			load_so();
			$("#daftar_sf").DataTable().destroy();
			load_fs();
		},
		error: function(){
			$("#modal_mapping_ssm").modal('hide');
			alert("Data Mapping Gagal Disimpan.");
		}
    });
	
});
*/

/* 404
function list_region(key, value_in){
	$.ajax({
        url: "<?php echo base_url(); ?>user/Manajemen_user/Dt_region",
        type: 'GET',
        dataType: 'JSON',
		success: function(data){
			var type_list = '<select class="form-control selectpicker show-tick" style="width:100%;" name="wil_cakupan_gsm" id="wil_cakupan_gsm" required>';
			type_list += '<option value="" disabled selected>-- Pilih Wilayah Cakupan --</option>';
			for (var i = 0; i < data.length; i++) {
				type_list += '<option value="'+data[i].KODE+'">'+data[i].LABEL+'</option>';
			}
			type_list += '</select>';
			$(key).html(type_list);
			$(".selectpicker").selectpicker("refresh");
			$("#wil_cakupan_gsm").val(value_in).change();	
		}
    });
}
*/

/* 404
function list_gsm(key, value_in){
	$.ajax({
        url: "<?php echo base_url(); ?>user/Manajemen_user/List_gsm",
        type: 'GET',
        dataType: 'JSON',
		success: function(data){
			var type_list = '<select class="form-control selectpicker show-tick" data-size="5" data-live-search="true" style="width:100%;" name="list_gsm" id="list_gsm" required>';
			type_list += '<option value="" disabled selected>-- Pilih Atasan (GSM) --</option>';
			for (var i = 0; i < data.length; i++) {
				type_list += '<option value="'+data[i].ID_USER+'">'+data[i].NAMA+'</option>';
			}
			type_list += '</select>';
			$(key).html(type_list);
			$(".selectpicker").selectpicker("refresh");
			$("#list_gsm").val(value_in).change();	
		}
    });
}

function list_ssm(key, value_in){
	$.ajax({
        url: "<?php echo base_url(); ?>user/Manajemen_user/List_ssm",
        type: 'GET',
        dataType: 'JSON',
		success: function(data){
			var type_list = '<select class="form-control selectpicker show-tick" data-size="5" data-live-search="true" style="width:100%;" name="list_ssm" id="list_ssm" required>';
			type_list += '<option value="" disabled selected>-- Pilih Atasan (SSM) --</option>';
			for (var i = 0; i < data.length; i++) {
				type_list += '<option value="'+data[i].ID_USER+'">'+data[i].NAMA+'</option>';
			}
			type_list += '</select>';
			$(key).html(type_list);
			$(".selectpicker").selectpicker("refresh");
			$("#list_ssm").val(value_in).change();	
		}
    });
}

function list_sm(key, value_in){
	$.ajax({
        url: "<?php echo base_url(); ?>user/Manajemen_user/List_sm",
        type: 'GET',
        dataType: 'JSON',
		success: function(data){
			var type_list = '<select class="form-control selectpicker show-tick" data-size="5" data-live-search="true" style="width:100%;" name="list_sm" id="list_sm" required>';
			type_list += '<option value="" disabled selected>-- Pilih Atasan (SM) --</option>';
			for (var i = 0; i < data.length; i++) {
				type_list += '<option value="'+data[i].ID_USER+'">'+data[i].NAMA+'</option>';
			}
			type_list += '</select>';
			$(key).html(type_list);
			$(".selectpicker").selectpicker("refresh");
			$("#list_sm").val(value_in).change();	
		}
    });
}

function list_so(key, value_in){
	$.ajax({
        url: "<?php echo base_url(); ?>user/Manajemen_user/List_so",
        type: 'GET',
        dataType: 'JSON',
		success: function(data){
			var type_list = '<select class="form-control selectpicker show-tick" data-size="5" data-live-search="true" style="width:100%;" name="list_so" id="list_so" required>';
			type_list += '<option value="" disabled selected>-- Pilih Atasan (SO) --</option>';
			for (var i = 0; i < data.length; i++) {
				type_list += '<option value="'+data[i].ID_USER+'">'+data[i].NAMA+'</option>';
			}
			type_list += '</select>';
			$(key).html(type_list);
			$(".selectpicker").selectpicker("refresh");
			$("#list_so").val(value_in).change();	
		}
    });
}
*/


function load_gsm(){
	$("#show_data").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_user/List_gsm',
			type: 'GET',
			dataType : 'json',
			success: function(data){
				  var html = '';
				  var i;
				  var c = "x";
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					var label = '<td>'+data[i].LABEL+'</td>';
					
					if(data[i].LABEL == null){
						label = '<td style="color: red;">Belum Ditentukan</td>';
					}
					
					var button = '<td style="text-align: center;">'+
								'<a target="_blank" href="<?php echo site_url(); ?>user/Manajemen_user/Mapping/'+data[i].ID_USER+'"><span id="BtnMapping_gsm404" class="btn" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_wilayah="'+data[i].CAKUPAN_WILAYAH+'"><i class="fa fa-sitemap" title="mapping" ></i></span></a> &nbsp;'+
								'<span id="BtnEdit_gsm" class="btn btn-info" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_username="'+data[i].USERNAME+'" dt_password="'+data[i].PASSWORD+'" dt_email="'+data[i].EMAIL+'"><i class="fa fa-edit" title="edit"></i></span> &nbsp;'+
								'<span id="BtnHapus_gsm" class="btn btn-danger" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'"><i class="fa fa-trash" title="hapus"></i></span>'+
							 '</td>'; 
					
					html += '<tr class='+c+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID_USER+'</td>'+
					'<td>'+data[i].NAMA+'</td>'+
					'<td>'+data[i].USERNAME+'</td>'+
					'<td>'+data[i].PASSWORD+'</td>'+
					'<td>'+data[i].EMAIL+'</td>'+
					//label+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
				  }
				$('#show_data').html(html);
				$("#daftar_gsm").dataTable();
			},
			error: function(){
			}
		});
}

function load_ssm(){
	$("#show_data_ssm").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_user/List_ssm_all',
			type: 'GET',
			dataType : 'json',
			success: function(data){
				  var html = '';
				  var i;
				  var c = "x";
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					var label = '<td>'+data[i].ATASAN+'</td>';
					
					if(data[i].ATASAN == null){
						label = '<td style="color: red;">Belum Ditentukan</td>';
					}
					
					var cekInUp = '';
					
					if(data[i].ID_ATASAN_ON == null){
						cekInUp = 'style="background-color: #FFCDD2;"';
					}
					
					var button = '<td style="text-align: center;">'+
								'<a target="_blank" href="<?php echo site_url(); ?>user/Manajemen_user/Mapping/'+data[i].ID_USER+'"><span id="BtnMapping_ssm404" class="btn" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_wilayah="'+data[i].CAKUPAN_WILAYAH+'" dt_atasan="'+data[i].ID_ATASAN_LANGSUNG+'" dt_jenis_user="'+data[i].ID_JENIS_USER+'"><i class="fa fa-sitemap" title="mapping" ></i></span></a> &nbsp;'+
								'<span id="BtnEdit_ssm" class="btn btn-info" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_username="'+data[i].USERNAME+'" dt_password="'+data[i].PASSWORD+'" dt_email="'+data[i].EMAIL+'"><i class="fa fa-edit" title="edit"></i></span> &nbsp;'+
								'<span id="BtnHapus_ssm" class="btn btn-danger" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'"><i class="fa fa-trash" title="hapus"></i></span>'+
							 '</td>'; 
					
					html += '<tr class='+c+' '+cekInUp+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID_USER+'</td>'+
					'<td>'+data[i].NAMA+'</td>'+
					'<td>'+data[i].USERNAME+'</td>'+
					'<td>'+data[i].PASSWORD+'</td>'+
					'<td>'+data[i].EMAIL+'</td>'+
					//label+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
				  }
				$('#show_data_ssm').html(html);
				$("#daftar_ssm").dataTable();
			},
			error: function(){
			}
		});
}

function load_sm(){
	$("#show_data_sm").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_user/List_sm_all',
			type: 'GET',
			dataType : 'json',
			success: function(data){
				  var html = '';
				  var i;
				  var c = "x"; 
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					var label = '<td>'+data[i].ATASAN+'</td>';
					
					if(data[i].ATASAN == null){
						label = '<td style="color: red;">Belum Ditentukan</td>';
					}
					
					var cekInUp = '';
					
					if(data[i].ID_ATASAN_ON == null){
						cekInUp = 'style="background-color: #FFCDD2;"';
					}
					
					var button = '<td style="text-align: center;">'+
								'<a target="_blank" href="<?php echo site_url(); ?>user/Manajemen_user/Mapping/'+data[i].ID_USER+'"><span id="BtnMapping_sm404" class="btn" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_wilayah="'+data[i].CAKUPAN_WILAYAH+'" dt_atasan="'+data[i].ID_ATASAN_LANGSUNG+'" dt_jenis_user="'+data[i].ID_JENIS_USER+'"><i class="fa fa-sitemap" title="mapping" ></i></span></a> &nbsp;'+
								'<span id="BtnEdit_sm" class="btn btn-info" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_username="'+data[i].USERNAME+'" dt_password="'+data[i].PASSWORD+'" dt_email="'+data[i].EMAIL+'"><i class="fa fa-edit" title="edit"></i></span> &nbsp;'+
								'<span id="BtnHapus_sm" class="btn btn-danger" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'"><i class="fa fa-trash" title="hapus"></i></span>'+
							 '</td>'; 
					
					html += '<tr class='+c+' '+cekInUp+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID_USER+'</td>'+
					'<td>'+data[i].NAMA+'</td>'+
					'<td>'+data[i].USERNAME+'</td>'+
					'<td>'+data[i].PASSWORD+'</td>'+
					'<td>'+data[i].EMAIL+'</td>'+
					//label+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
				  }
				$('#show_data_sm').html(html);
				$("#daftar_sm").dataTable();
			},
			error: function(){
			}
		});
}

function load_so(){
	$("#show_data_so").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_user/List_so_all',
			type: 'GET',
			dataType : 'json',
			success: function(data){
				  var html = '';
				  var i;
				  var c = "x";
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					var label = '<td>'+data[i].ATASAN+'</td>';
					
					if(data[i].ATASAN == null){
						label = '<td style="color: red;">Belum Ditentukan</td>';
					}
					
					var cekInUp = '';
					
					if(data[i].ID_ATASAN_ON == null){
						cekInUp = 'style="background-color: #FFCDD2;"';
					}
					
					var button = '<td style="text-align: center;">'+
								'<a target="_blank" href="<?php echo site_url(); ?>user/Manajemen_user/Mapping/'+data[i].ID_USER+'"><span id="BtnMapping_so404" class="btn" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_wilayah="'+data[i].CAKUPAN_WILAYAH+'" dt_atasan="'+data[i].ID_ATASAN_LANGSUNG+'" dt_jenis_user="'+data[i].ID_JENIS_USER+'"><i class="fa fa-sitemap" title="mapping" ></i></span></a> &nbsp;'+
								'<span id="BtnEdit_so" class="btn btn-info" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_username="'+data[i].USERNAME+'" dt_password="'+data[i].PASSWORD+'" dt_email="'+data[i].EMAIL+'"><i class="fa fa-edit" title="edit"></i></span> &nbsp;'+
								'<span id="BtnHapus_so" class="btn btn-danger" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'"><i class="fa fa-trash" title="hapus"></i></span>'+
							 '</td>'; 
					
					html += '<tr class='+c+' '+cekInUp+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID_USER+'</td>'+
					'<td>'+data[i].NAMA+'</td>'+
					'<td>'+data[i].USERNAME+'</td>'+
					'<td>'+data[i].PASSWORD+'</td>'+
					'<td>'+data[i].EMAIL+'</td>'+
					//label+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
				  }
				$('#show_data_so').html(html);
				$("#daftar_so").dataTable();
			},
			error: function(){
			}
		});
}

function load_sd(){
	$("#show_data_sd").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_user/List_sd_all',
			type: 'GET',
			dataType : 'json',
			success: function(data){
				  var html = '';
				  var i;
				  var c = "x";
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					var label = '<td>'+data[i].ATASAN+'</td>';
					
					if(data[i].ATASAN == null){
						label = '<td style="color: red;">Belum Ditentukan</td>';
					}
					
					var cekInUp = '';
					
					// if(data[i].ID_ATASAN_ON == null){
						// cekInUp = 'style="background-color: #FFCDD2;"';
					// }
					
					var button = '<td style="text-align: center;">'+
								'<a target="_blank" href="<?php echo site_url(); ?>user/Manajemen_user/Mapping/'+data[i].ID_USER+'"><span id="BtnMapping_so404" class="btn" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_wilayah="'+data[i].CAKUPAN_WILAYAH+'" dt_atasan="'+data[i].ID_ATASAN_LANGSUNG+'" dt_jenis_user="'+data[i].ID_JENIS_USER+'"><i class="fa fa-sitemap" title="mapping" ></i></span></a> &nbsp;'+
								'<span id="BtnEdit_sd" class="btn btn-info" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_username="'+data[i].USERNAME+'" dt_password="'+data[i].PASSWORD+'" dt_email="'+data[i].EMAIL+'"><i class="fa fa-edit" title="edit"></i></span> &nbsp;'+
								'<span id="BtnHapus_sd" class="btn btn-danger" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'"><i class="fa fa-trash" title="hapus"></i></span>'+
							 '</td>'; 
					
					html += '<tr class='+c+' '+cekInUp+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID_USER+'</td>'+
					'<td>'+data[i].NAMA+'</td>'+
					'<td>'+data[i].USERNAME+'</td>'+
					'<td>'+data[i].PASSWORD+'</td>'+
					'<td>'+data[i].EMAIL+'</td>'+
					//label+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
				  }
				$('#show_data_sd').html(html);
				$("#daftar_sd").dataTable();
			},
			error: function(){
			}
		});
}

function load_dist(){
	$("#show_data_dist").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_user/List_dist',
			type: 'GET',
			dataType : 'json',
			success: function(data){
				  var html = '';
				  var i;
				  var c = "x";
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					var label = '<td>'+data[i].ATASAN+'</td>';
					
					if(data[i].ATASAN == null){
						label = '<td style="color: red;">Belum Ditentukan</td>';
					}
					
					var button = '<td style="text-align: center;">'+
								'<a target="_blank" href="<?php echo site_url(); ?>user/Manajemen_user/Mapping/'+data[i].ID_USER+'"><span id="BtnMapping_so404" class="btn" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_wilayah="'+data[i].CAKUPAN_WILAYAH+'" dt_atasan="'+data[i].ID_ATASAN_LANGSUNG+'" dt_jenis_user="'+data[i].ID_JENIS_USER+'"><i class="fa fa-sitemap" title="mapping" ></i></span></a> &nbsp;'+
								'<span id="BtnEdit_dist" class="btn btn-info" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_username="'+data[i].USERNAME+'" dt_password="'+data[i].PASSWORD+'" dt_email="'+data[i].EMAIL+'"><i class="fa fa-edit" title="edit"></i></span> &nbsp;'+
								'<span id="BtnHapus_dist" class="btn btn-danger" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'"><i class="fa fa-trash" title="hapus"></i></span>'+
							 '</td>'; 
					
					html += '<tr class='+c+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID_USER+'</td>'+
					'<td>'+data[i].NAMA+'</td>'+
					'<td>'+data[i].USERNAME+'</td>'+
					'<td>'+data[i].PASSWORD+'</td>'+
					'<td>'+data[i].EMAIL+'</td>'+
					//label+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
				  }
				$('#show_data_dist').html(html);
				$("#daftar_dist").dataTable();
			},
			error: function(){
			}
		});
}

function load_spc(){
	$("#show_data_spc").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_user/List_spc',
			type: 'GET',
			dataType : 'json',
			success: function(data){
				  var html = '';
				  var i;
				  var c = "x";
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					var label = '<td>'+data[i].ATASAN+'</td>';
					
					if(data[i].ATASAN == null){
						label = '<td style="color: red;">Belum Ditentukan</td>';
					}
					
					var button = '<td style="text-align: center;">'+
								'<a target="_blank" href="<?php echo site_url(); ?>user/Manajemen_user/Mapping/'+data[i].ID_USER+'"><span id="BtnMapping_spc404" class="btn" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_wilayah="'+data[i].CAKUPAN_WILAYAH+'" dt_atasan="'+data[i].ID_ATASAN_LANGSUNG+'" dt_jenis_user="'+data[i].ID_JENIS_USER+'"><i class="fa fa-sitemap" title="mapping" ></i></span></a> &nbsp;'+
								'<span id="BtnEdit_spc" class="btn btn-info" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'" dt_username="'+data[i].USERNAME+'" dt_password="'+data[i].PASSWORD+'" dt_email="'+data[i].EMAIL+'"><i class="fa fa-edit" title="edit"></i></span> &nbsp;'+
								'<span id="BtnHapus_spc" class="btn btn-danger" dt_id_user="'+data[i].ID_USER+'" dt_nama="'+data[i].NAMA+'"><i class="fa fa-trash" title="hapus"></i></span>'+
							 '</td>'; 
					
					html += '<tr class='+c+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID_USER+'</td>'+
					'<td>'+data[i].NAMA+'</td>'+
					'<td>'+data[i].USERNAME+'</td>'+
					'<td>'+data[i].PASSWORD+'</td>'+
					'<td>'+data[i].EMAIL+'</td>'+
					//label+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
				  }
				$('#show_data_spc').html(html);
				$("#daftar_spc").dataTable();
			},
			error: function(){
			}
		});
}

$(document).on("click", "#BtnTambah_spc", function(){
	$('#form-in').trigger("reset");
	$("#id_up_user").val(0000);
	$("#id_jenis_user").val(1017);
	$("#modal_user_a_u").modal('show');
	$('#labelNama').text('Nama Sales : ');
	$('.modal-title').text('Tambah User SPC : ');
});

$(document).on("click", "#BtnEdit_spc", function(){
	$("#modal_user_a_u").modal('show');
	
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	var username = $(this).attr("dt_username");
	var password = $(this).attr("dt_password");
	var email = $(this).attr("dt_email");
	
	$("#email_user").val(email);
	$("#id_up_user").val(id_user);
	$("#id_jenis_user").val(1017);
	$("#nama_user").val(nama_user);
	$("#username_user").val(username);
	$("#password_user").val(password);
	
	
	$('.modal-title').text('Edit User SPC : ['+id_user+'] '+nama_user);
});

$(document).on("click", "#BtnHapus_spc", function(){
	$("#modal_hapus_user").modal('show');
	var id_user = $(this).attr("dt_id_user");
	var nama_user = $(this).attr("dt_nama");
	$("#id_user_hapus").val(id_user);
	$('.modal-title').text('Hapus User SPC : ['+id_user+'] '+nama_user);
});


</script>

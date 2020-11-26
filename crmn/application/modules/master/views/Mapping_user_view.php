<style>
	th, td { white-space: nowrap; }
	.W{
		background-color:#3F51B5 !important;
		font-weight:bolder;
		color:#FFFFFF;
	}
	.y{
		background-color:#FFFFFF !important;
		font-weight:bold;
		color:#222222;
	}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>MAPPING USER DAN KARYAWAN</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        <form action="" method="post">
										<div class="col-md-1">
										<b>Region</b>
											<select id="id_region" name="id_region" class="form-control show-tick" data-live-search="true">
												<option value="">All</option>
												<?php
												foreach ($list_region as $ListSalesValue) { ?>
												<option value="<?php echo $ListSalesValue->NEW_REGION; ?>"><?php echo $ListSalesValue->NEW_REGION; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
										<b>Provinsi</b>
											<select id="id_prov" name="id_prov" class="form-control show-tick" data-live-search="true">
												<option value="">All</option>
												<?php
												foreach ($list_provinsi as $ListSalesValue) { ?>
												<option value="<?php echo $ListSalesValue->ID_PROVINSI; ?>"><?php echo $ListSalesValue->NAMA_PROVINSI; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-3">
										<b>Distributor</b>
											<select id="editkaryawan" name="editkaryawan" class="form-control show-tick" data-live-search="true">
												<option value="">All</option>
												<?php
												foreach ($list_distributor as $ListSalesValue) { ?>
												<option value="<?php echo $ListSalesValue->KODE_DISTRIBUTOR; ?>"><?php echo $ListSalesValue->NAMA_DISTRIBUTOR; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
										<!--
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnTambah" class="btn btn-warning btn-sm btn-lg m-15-30 waves-effect" ><i class="fa fa-plus"></i> Tambah Data Karyawan</button>
										</div>
										-->
										<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
											<b>&nbsp;</b><br/>
											<button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-file-excel-o"></i> Export </button>
										</div>
                                        </form>
                                    </div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTable no-footer" id="tugas_sales" width="100%" style="width: 100%; font-size:11px;">
                                            <thead class="w">
                                                <tr>
													<th width="25%">NO KARYAWAN</th>
                                                    <th width="25%">NAMA KARYAWAN</th>
													<th width="25%">ID USER</th>
													<th width="25%">NAMA USER</th>
													<th><center>KUNCI</center></th>
													<th><center>LEPAS</center></th>
                                                </tr>
                                            </thead>
                                            <tbody class="y" id="show_data">
                                            </tbody>
                                        </table>
										</div>
                                    </div>
                            	</div>
                            <div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
    </div>
</section>
<!-- Modal Edit-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document" style="width:700px;">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #00b0e4;color: white;">
				<h4 class="modal-title" id="headerTableRetail">EDIT DATA MAPPING</h4>
			</div>
			<div class="modal-body">
                <div class="row">
				<input value="" type="hidden" class="form-control" name="id_edit" id="id_edit" >
					<div class="row clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
							<label for="name">KARYAWAN : </label>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
									   <div class="row clearfix">
										<select id="editkaryawan" name="editkaryawan" class="form-control show-tick" data-live-search="true">
											<option value="">Pilih Karyawan</option>
											<?php
											foreach ($list_karyawan as $ListSalesValue) { ?>
											<option value="<?php echo $ListSalesValue->NO_KARYAWAN; ?>"><?php echo $ListSalesValue->NAMA_KARYAWAN; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
							<label for="name">USER : </label>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
									   <div class="row clearfix">
										<select id="edituser" name="edituser" class="form-control show-tick" data-live-search="true">
											<option value="">Pilih User</option>
											<?php
											foreach ($list_user as $ListSalesValue) { ?>
											<option value="<?php echo $ListSalesValue->ID_USER; ?>"><?php echo $ListSalesValue->NAMA; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="EditSimpan" class="btn btn-sm btn-success waves-effect">SIMPAN</button>
					<button type="button" class="btn btn-sm btn-info waves-effect" data-dismiss="modal">CLOSE</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Tambah-->
<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document" style="width:700px;">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #00b0e4;color: white;">
				<h4 class="modal-title" id="headerTableRetail">TAMBAH DATA MAPPING</h4>
			</div>
			<div class="modal-body">
                <div class="row">
					<div class="row clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
							<label for="name">KARYAWAN : </label>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
									   <div class="row clearfix">
										<input value="" type="text" class="form-control" name="id_kar" id="id_kar" disabled>
										<input value="" type="hidden" class="form-control" name="id" id="id">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
							<label for="name">USER SALES: </label>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
									<div class="row clearfix" id="tambahsales">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="TambahSimpan" class="btn btn-sm btn-success waves-effect">SIMPAN</button>
					<button type="button" class="btn btn-sm btn-info waves-effect" data-dismiss="modal">CLOSE</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	tampil_data();
});


function tampil_data(){
	
	idpd 		= $("#editkaryawan option:selected").val();
	id_prov 	= $("#id_prov option:selected").val();
	id_region 	= $("#id_region option:selected").val();
	
	$.ajax({
	url: '<?php echo site_url(); ?>master/Mapping_user/Ajax_tampil_data',
	type: 'POST',
	async : true,
	dataType : 'json',
	data: {
			"id" : idpd,
			"region" : id_region,
			"prov" : id_prov
	},
	success: function(data){
		  var html = '';
		  var i;
		  for(i=0; i<data.length; i++){
			html += '<tr>'+
			'<td>'+data[i].NO_KARYAWAN+'</td>'+
			'<td>'+data[i].NAMA_KARYAWAN+'</td>'+
			'<td>'+data[i].ID_USER+'</td>'+
			'<td>'+data[i].USERNAME+'</td>';
			if(data[i].ID_USER == null ){
				html += '<td><center>'+'<button class="btn btn-success waves-effect" id="Kunci" idpd="'+data[i].KODE_DISTRIBUTOR+'" dt="'+data[i].NAMA_KARYAWAN+'" id_kar="'+data[i].NO_KARYAWAN+'"><span class="fa fa-lock"></span></button>'+'</center></td>'+
						'<td></td>'+
						'</tr>';
			}
			else {
				html += '<td></td>'+
						'<td><center>'+'<button class="btn btn-warning waves-effect" id="Lepas" id_hapus="'+data[i].ID_USER_KARYAWAN+'"><span class="fa fa-unlock"></span></button>'+'</center></td>'+
						'</tr>';
				}
			}
		$('#show_data').html(html);
		$("#tugas_sales").dataTable();
	},
	error: function(){
	}
    });
}

$(document).on("click", "#Lepas", function(){
	idpd = $(this).attr("id_hapus");
	
	console.log(idpd);
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Mapping_user/Ajax_hapus_data',
		type: 'POST',
		data: {
			"id" : idpd
		},
		success: function(data){
		alert("MAPPING SUKSES DILEPAS!")
		tampil_data();
		},
		error: function(){
		}
    });
	
});

$(document).on("click", "#btnFilter", function(){
$("#tugas_sales").DataTable().destroy();
tampil_data();
});

$(document).on("click", "#Kunci", function(){
	$("#modal_tambah").modal('show');
	
	idpd = $(this).attr("idpd");
	data = $(this).attr("dt");
	id = $(this).attr("id_kar");
	
	$("#id_kar").val(data);
	$("#id").val(id);
	
	$.ajax({
		url : "<?php echo site_url();?>master/Mapping_user/Ajax_option_value",
		method : "POST",
		data : {
			"id" : idpd
		},
		async : true,
		dataType : 'json',
		success: function(data){ 
			var a = '';
			var i;
			for(i=0; i<data.length; i++){
				a += '<option value='+data[i].ID_USER+'>'+data[i].NAMA+'</option>';
			}
			var b = '<select id="idsales" name="idsales" class="form-control show-tick">'+a+'</select>';
			$('#tambahsales').html(b);
		}
	});
});

$(document).on("click", "#TambahSimpan", function(){
	id_user = $("#idsales option:selected").val();
	id_kar = $("#id").val();
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Mapping_user/Ajax_tambah_data',
		type: 'POST',
		data: { 
			"id_user" : id_user,
			"id_kar" : id_kar
		},
		success: function(data){
		location.reload(true);
		},
		error: function(){
		}
    });
	
});

$(document).on("click", "#btnExport", function(e){
		e.preventDefault();
        var id	= $('#filterDis option:selected').val();

        window.open("<?php echo base_url()?>master/Mapping_user/toExcel?");
});
</script>
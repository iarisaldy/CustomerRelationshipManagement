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
                        <h2>MASTER DATA KARYAWAN</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        <form action="" method="post">
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                            <b>Distributor</b>
                                            <select id="filterDis" name="filterDis" class="form-control show-tick">
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
										<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
											<b>&nbsp;</b><br/>
											<button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-file-excel-o"></i> Export </button>
										</div>
										<button type="button" id="btnTambah" class="btn btn-warning btn-sm btn-lg m-15-30 waves-effect" style="float: right;"><i class="fa fa-plus"></i> Tambah Data Karyawan</button>
                                        </form>
                                    </div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTable no-footer" id="tugas_sales" width="100%" style="width: 100%; font-size:11px;">
                                            <thead class="w">
                                                <tr>
													<th>NO KARYAWAN</th>
                                                    <th width="25%">NAMA</th>
                                                    <th width="30%">ALAMAT</th>
													<th width="10%">NO TELP</th>
													<th width="5%">EMAIL</th>
													<th width="20%">DISTRIBUTOR</th>
													<th width="5%">EDIT</th>
													<th width="5%">DELETE</th>
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
				<h4 class="modal-title" id="headerTableRetail">EDIT DATA KARYAWAN</h4>
			</div>
			<div class="modal-body">
                <div class="row">
				<input value="" type="hidden" class="form-control" name="id_edit" id="id_edit" >
					<div class="row clearfix">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
							<label for="name">NAMA : </label>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
									<div class="row clearfix">
									<input value="" type="text" class="form-control" name="nama" id="namaedit" placeholder="    NAMA">
									</div>
								</div>
							</div>
					  </div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
							<label for="name">ALAMAT : </label>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
								   <div class="row clearfix">
									<input value="" type="text" class="form-control" name="alamat" id="alamatedit" placeholder="    ALAMAT">
								</div>
							</div>
						</div>
						</div>
					</div>
					<div class="row clearfix">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
						<label for="name">NO TELP : </label>
					</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
								   <div class="row clearfix">
										<input value="" type="text" class="form-control" name="notelp" id="telpedit" placeholder="    NO TELP">
								   </div>
								</div>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
							<label for="name">EMAIL : </label>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
								   <div class="row clearfix">
									<input value="" type="email" class="form-control" name="email" id="imailedit" placeholder="    EMAIL">
								</div>
							</div>
						</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
							<label for="name">DISTRIBUTOR : </label>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
									   <div class="row clearfix">
										<select id="editdis" name="editdis" class="form-control show-tick">
											<option value="">Pilih Distributor</option>
											<?php
											foreach ($list_distributor as $ListSalesValue) { ?>
											<option value="<?php echo $ListSalesValue->KODE_DISTRIBUTOR; ?>"><?php echo $ListSalesValue->NAMA_DISTRIBUTOR; ?></option>
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
				<h4 class="modal-title" id="headerTableRetail">TAMBAH DATA KARYAWAN</h4>
			</div>
			<div class="modal-body">
                <div class="row">
					<div class="row clearfix">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
							<label for="name">NAMA : </label>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
									<div class="row clearfix">
									<input value="" type="text" class="form-control" name="nama" id="tambahnama" placeholder="    NAMA">
									</div>
								</div>
							</div>
					  </div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
							<label for="name">ALAMAT : </label>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
								   <div class="row clearfix">
									<input value="" type="text" class="form-control" name="alamat" id="tambahalamat" placeholder="    ALAMAT">
								</div>
							</div>
						</div>
						</div>
					</div>
					<div class="row clearfix">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
						<label for="name">NO TELP : </label>
					</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
								   <div class="row clearfix">
										<input value="" type="text" class="form-control" name="notelp" id="tambahtelp" placeholder="    NO TELP">
								   </div>
								</div>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
							<label for="name">EMAIL : </label>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
								   <div class="row clearfix">
									<input value="" type="email" class="form-control" name="email" id="tambahimail" placeholder="    EMAIL">
								</div>
							</div>
						</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
							<label for="name">DISTRIBUTOR : </label>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<div class="form-group">
								<div class="form-line">
									   <div class="row clearfix">
										<select id="tambahdis" name="tambahdis" class="form-control show-tick">
											<option value="">Pilih Distributor</option>
											<?php
											foreach ($list_distributor as $ListSalesValue) { ?>
											<option value="<?php echo $ListSalesValue->KODE_DISTRIBUTOR; ?>"><?php echo $ListSalesValue->NAMA_DISTRIBUTOR; ?></option>
											<?php } ?>
										</select>
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
	$("#btnFilter").click();
	  	
});


$(document).on("click", "#btnFilter", function(){
		var id_dis	= $('#filterDis option:selected').val();
		
		$.ajax({
		url: '<?php echo site_url(); ?>master/Master_karyawan/Ajax_tampil_data',
		type: 'POST',
		async : true,
		dataType : 'json',
		data: {
			"id" : id_dis,
		},
		success: function(data){
			  var html = '';
			  var i;
			  for(i=0; i<data.length; i++){
				html += '<tr>'+
				'<td>'+data[i].NO_KARYAWAN+'</td>'+
				'<td>'+data[i].NAMA_KARYAWAN+'</td>'+
				'<td>'+data[i].ALAMAT+'</td>'+
				'<td>'+data[i].NO_HP+'</td>'+
				'<td>'+data[i].EMAIL+'</td>'+
				'<td>'+data[i].NAMA_DISTRIBUTOR+'</td>'+
				'<td>'+'<button class="btn btn-success waves-effect " id="edit" idpd="'+data[i].NO_KARYAWAN+'"><span class="fa fa-cog"></span></button>'+'</td>'+
				'<td>'+'<button class="btn btn-danger waves-effect " id="hapus" idpd="'+data[i].NO_KARYAWAN+'"><span class="fa fa-trash-o"></span></button>'+'</td>'+
				'</tr>';
			  }
			$('#show_data').html(html);
			$("#tugas_sales").dataTable();
		},
		error: function(){
		}
    });
});

$(document).on("click", "#hapus", function(){
	idpd = $(this).attr("idpd");
	$.ajax({
		url: '<?php echo site_url(); ?>master/Master_karyawan/Ajax_hapus_data',
		type: 'POST',
		data: {
			"id" : idpd
		},
		success: function(data){
		alert("DATA SUKSES DIHAPUS!")
		$("#btnFilter").click();
		},
		error: function(){
		}
    });
	
});

$(document).on("click", "#edit", function(){
	$("#modal_edit").modal('show');
	
	idpd = $(this).attr("idpd");
	$("#id_edit").val(idpd);
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Master_karyawan/Ajax_data_id',
		type: 'POST',
		data: {
			"id" : idpd
		},
		success: function(j){
			var dt = JSON.parse(j);
			var data =(dt.html[0]);
			$("#namaedit").val(data.NAMA_KARYAWAN);
			$("#alamatedit").val(data.ALAMAT);
			$("#telpedit").val(data.NO_HP);
			$("#imailedit").val(data.EMAIL);
			$('select[name="editdis"]').append('<option value="'+ data.KODE_DISTRIBUTOR +'" selected>'+ data.NAMA_DISTRIBUTOR +'</option>').trigger('change');
		},
		error: function(){
		}
    });
});

$(document).on("click", "#btnTambah", function(){
	$("#modal_tambah").modal('show');
});


	
$(document).on("click", "#EditSimpan", function(){
	
	id = $("#id_edit").val();
	id_dis = $("#editdis option:selected").val();
	nama = $("#namaedit").val();
	alamat = $("#alamatedit").val();
	telp = $("#telpedit").val();
	imail = $("#imailedit").val();
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Master_karyawan/Ajax_simpan_edit',
		type: 'POST',
		data: { 
			"id" : id,
			"id_dis" : id_dis,
			"nama" : nama,
			"alamat" : alamat,
			"telp" : telp,
			"imail" : imail
		},
		success: function(data){
		$("#btnFilter").click();
		location.reload(true);
		},
		error: function(){
		}
    });
	
});


$(document).on("click", "#TambahSimpan", function(){
	
	id_dis = $("#tambahdis option:selected").val();
	nama = $("#tambahnama").val();
	alamat = $("#tambahalamat").val();
	telp = $("#tambahtelp").val();
	imail = $("#tambahimail").val();
	
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Master_karyawan/Ajax_tambah_data',
		type: 'POST',
		data: { 
			"id" : id_dis,
			"nama" : nama,
			"alamat" : alamat,
			"telp" : telp,
			"imail" : imail
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

        window.open("<?php echo base_url()?>master/Master_karyawan/toExcel?id="+id,"_blank");
});
</script>
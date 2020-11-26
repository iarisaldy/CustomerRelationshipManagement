<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-10 col-md-offset-1">
                <!-- card view -->
                <div class="card">
					<div class="header header-title bg-red bg-cyan-">
                        <h2> Data Master Produk</h2> 
                    </div>

                    <div class="body">
                        <div class="row">
                            <div class="table-responsive">
								<table class="table table-striped table-bordered dataTable no-footer" id="daftar_produk_dist">
									<thead >
										<tr>
											<th bgcolor="#ffb990">NO</th>
											<th bgcolor="#ffb990">KODE PRODUK</th>
											<th bgcolor="#ffb990">NAMA PRODUK</th>
											<th bgcolor="#ffb990">GROUP</th>
											<th bgcolor="#ffb990"><center>OPSI</center></th>
										</tr>
									</thead>
									<tbody id="show_data">
									<?php  
										echo $list_produk;
									?>
									</tbody>
								</table>
							</div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>

<!-- For Tambah Produk -->
<div class="modal fade" id="form_produk_dist" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" id="judul_produk_order">Form Tambah Produk </h4>
            </div>
            <div class="modal-body">
                <div class="row">
						<input type="hidden" name="id_produk" id="id_produk">
						<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">ID PRODUK : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <input type="text" id="id_produk_input" value="" class="form-control" placeholder="ID PRODUK">
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">NAMA PRODUK : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <input type="text" id="nama_produk_input" value="" class="form-control" placeholder="NAMA PRODUK">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                	
                </div>
            </div>
            <div class="modal-footer bg-blue">
                <button type="button" class="btn btn-link waves-effect" id="Simpan"> Ya</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" id="close_order">Tidak</button>
            </div>
        </div>
    </div>
</div>
<!-- For Edit -->
<div class="modal fade" id="form_edit_produk_dist" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" id="judul_produk_order">Edit Data Produk </h4>
            </div>
            <div class="modal-body">
                <div class="row">
						<input type="hidden" name="id_edit" id="id_edit">
						<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">ID PRODUK : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <input type="text" id="id_produk_edit" value="" class="form-control" placeholder="ID PRODUK">
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">NAMA PRODUK : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <input type="text" id="nama_produk_edit" value="" class="form-control" placeholder="NAMA PRODUK">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                	
                </div>
            </div>
            <div class="modal-footer bg-blue">
                <button type="button" class="btn btn-link waves-effect" id="Ubah"> Ya</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" id="close_order">Tidak</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_hapus" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">

                	<div class="col-md-12">
                		<h4>Apakah anda Ingin Menghapus Data Ini ?</h4>
                		<input type="hidden" name="hapus_id_produk" id="hapus_id_produk">
                        
                	</div>
                </div>
            </div>
            <div class="modal-footer bg-red">
                <button type="button" class="btn btn-link waves-effect" id="Hapus_Data"> Ya</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
	$("#daftar_produk_dist").dataTable();


$(document).on("click", "#form", function(){
	$("#form_produk_dist").modal('show');
});

$(document).on("click", "#Simpan", function(){
	$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	$.ajax({
		url: '<?php echo site_url(); ?>master/Aproduk_survey/Ajax_tambah_data_Produk_dist',
		type: 'POST',
		data: {
			"id_produk"   	: $("#id_produk_input").val(),
			"nama_produk"	: $("#nama_produk_input").val()
		},
		success: function(j){
			var dt = JSON.parse(j);
			$("#show_data").html(dt.html);
			$("#daftar_produk_dist").dataTable();
			$("#form_produk_dist").modal('hide');
			
		},
		error: function(){
		}
    });
	
});

$(document).on("click", "#edit_produk", function(){
	$("#form_edit_produk_dist").modal('show');
	
	idpd = $(this).attr("idpd");

	$("#id_edit").val(idpd);
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Aproduk_survey/Ajax_data_Produk_id',
		type: 'POST',
		data: {
			"id_produk" : idpd
		},
		success: function(j){
			var dt = JSON.parse(j);
			var data =(dt.html[0]);
			$("#daftar_produk_dist").dataTable();
			$("#id_produk_edit").val(data.ID_PRODUK);
			$("#nama_produk_edit").val(data.NAMA_PRODUK);	
		},
		error: function(){
		}
    });
});

$(document).on("click", "#Ubah", function(){
	$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	id = $("#id_edit").val();
	$.ajax({
		url: '<?php echo site_url(); ?>master/Aproduk_survey/Ajax_simpan_edit_produk',
		type: 'POST',
		data: {
			"id" 			: id,
			"id_produk"   	: $("#id_produk_edit").val(),
			"nama_produk"	: $("#nama_produk_edit").val()
		},
		success: function(j){
			var dt = JSON.parse(j);
			$("#show_data").html(dt.html);
			
			$("#daftar_produk_dist").dataTable();
			$("#form_edit_produk_dist").modal('hide');
		},
		error: function(){
		}
    });
	
});

$(document).on("click", "#Hapus_produk", function(){
	$("#modal_hapus").modal('show');
	
	idpd = $(this).attr("idpd");

	$("#hapus_id_produk").val(idpd);
});

$(document).on("click", "#Hapus_Data", function(){
	$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	id_produk = $("#hapus_id_produk").val();	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Aproduk_survey/Ajax_hapus_data_Produk',
		type: 'POST',
		data: {
			"id_produk" : id_produk
		},
		success: function(j){
			var dt = JSON.parse(j);
			$("#show_data").html(dt.html);
			$("#daftar_produk_dist").dataTable();
			$("#modal_hapus").modal('hide');

		},
		error: function(){
		}
    });
});
});
</script>
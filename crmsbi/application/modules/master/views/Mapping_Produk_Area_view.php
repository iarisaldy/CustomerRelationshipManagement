<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-10 col-md-offset-1">
                <!-- card view -->
                <div class="card">
					<div class="header header-title bg-red bg-cyan-">
                        <h2>MAPPING PRODUK PERAREA</h2> 
                    </div>
                    <div class="body">
					<div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for=""> AREA : </label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <select id="piliharea" name="area" class="form-control show-tick">
										<option value="">Pilih Area</option>
										<?php
                                        foreach ($list_area as $ListAreaValue) { ?>
                                        <option value="<?php echo $ListAreaValue['ID_AREA']; ?>"><?php echo $ListAreaValue['NAMA_AREA']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for=""> NAMA PRODUK : </label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <select id="pilihproduk" name="produk" class="form-control show-tick">
										<option value="">Pilih Produk</option>
										<?php
                                        foreach ($list_produk as $ListProdukValue) { ?>
                                        <option value="<?php echo $ListProdukValue['ID_PRODUK']; ?>"><?php echo $ListProdukValue['NAMA_PRODUK']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary" id="Simpan"><i class="fa fa-save"></i> Save</button>
							</div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="table-responsive">
								<table class="table table-striped table-bordered dataTable no-footer" id="mapping_produk_area">
									<thead >
										<tr>
											<th bgcolor="#ffb990">NO</th>
											<th bgcolor="#ffb990">ID AREA</th>
											<th bgcolor="#ffb990">NAMA AREA</th>
											<th bgcolor="#ffb990">ID PRODUK</th>
											<th bgcolor="#ffb990">NAMA PRODUK</th>
											<th bgcolor="#ffb990">ACTION</th>
										</tr>
									</thead>
									<tbody id="show_data">
									<?php  
										echo $list;
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

<div class="modal fade" id="form_edit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" id="judul_produk_order">Edit Data Mapping Produk Area</h4>
            </div>
            <div class="modal-body">
                <div class="row">
						<input type="hidden" name="id_edit" id="id_edit">
						<div class="row clearfix">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name"> EDIT AREA : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
											<select id="area_edit" name="area_edit" class="form-control show-tick">
												<option value="">Pilih Area</option>
												<?php
												foreach ($list_area as $ListAreaValue) { ?>
												<option value="<?php echo $ListAreaValue['ID_AREA']; ?>"><?php echo $ListAreaValue['NAMA_AREA']; ?></option>
												<?php } ?>
											</select>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						<div class="row clearfix">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">EDIT NAMA PRODUK: </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
											<select id="produk_edit" name="produk_edit" class="form-control show-tick">
												<option value="">Pilih Produk</option>
												<?php
												foreach ($list_produk as $ListProdukValue) { ?>
												<option value="<?php echo $ListProdukValue['ID_PRODUK']; ?>"><?php echo $ListProdukValue['NAMA_PRODUK']; ?></option>
												<?php } ?>
											</select>
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
                		<input type="hidden" name="hapus_id" id="hapus_id">
                        
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
	$("#mapping_produk_area").dataTable();

$(document).on("click", "#Simpan", function(){
	$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	var id_area = $('#piliharea option:selected').val();
	var id_produk = $('#pilihproduk option:selected').val();
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Mapping_Produk_Area/Ajax_tambah_data',
		type: 'POST',
		data: {
			"id_area"   		: id_area,
			"id_produk"   		: id_produk
		},
		success: function(j){
			var dt = JSON.parse(j);
			$("#show_data").html(dt.html);
			$("#mapping_produk_area").dataTable().api().destroy();
			$("#mapping_produk_area").dataTable();
		},
		error: function(){
		}
    });
	
});

$(document).on("click", "#edit", function(){
	$("#form_edit").modal('show');
	
	idpd = $(this).attr("idpd");
	$("#id_edit").val(idpd);
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Mapping_Produk_Area/Ajax_data_id',
		type: 'POST',
		data: {
			
			"id" : idpd
		},
		success: function(j){
			var dt = JSON.parse(j);
			var data =(dt.html[0]);
			$("#mapping_produk_area").dataTable();
			$('select[name="area_edit"]').append('<option value="'+ data.ID_AREA +'" selected>'+ data.NAMA_AREA +'</option>').trigger('change');
			$('select[name="produk_edit"]').append('<option value="'+ data.ID_PRODUK +'" selected>'+ data.NAMA_PRODUK +'</option>').trigger('change');
		},
		error: function(){
		}
    });
});

$(document).on("click", "#Ubah", function(){
	//$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	id = $("#id_edit").val();
	
	id_area 	= $('#area_edit option:selected').val();
	id_produk 	= $('#produk_edit option:selected').val();
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Mapping_Produk_Area/Ajax_simpan_edit',
		type: 'POST',
		data: {
			"no_map" 			: id,
			"id_area"			: id_area,
			"id_produk"			: id_produk
		},
		success: function(j){
			var dt = JSON.parse(j);
			$("#show_data").html(dt.html);
			$("#mapping_produk_area").dataTable().api().destroy();
			$("#mapping_produk_area").dataTable();
			location.reload(true);
			$("#form_edit").modal('hide');
		},
		error: function(){
		}
    });
	
});

// $(document).on("click", "#Hapus_user", function(){
	// $("#modal_hapus").modal('show');
	// idpd = $(this).attr("idpd");
	// $("#hapus_id").val(idpd);
	
// });

// $(document).on("click", "#Hapus_Data", function(){
	// $("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	// id = $("#hapus_id").val();
	// $.ajax({
		// url: '<?php echo site_url(); ?>master/M_Role_User/Ajax_hapus_data',
		// type: 'POST',
		// data: {
			
			// "id_user" : id
		// },
		// success: function(j){
			// var dt = JSON.parse(j);
			// $("#show_data").html(dt.html);
			// $("#daftar_user_role").dataTable().api().destroy();
			// $("#daftar_user_role").dataTable();
			// location.reload(true);
			// $("#modal_hapus").modal('hide');

		// },
		// error: function(){
		// }
    // });
// });
});
</script>
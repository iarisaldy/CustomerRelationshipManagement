<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-12">
                <!-- card view -->
                <div class="card">
					<div class="header header-title bg-red bg-cyan-">
                        <h2> Data Master Sub Menu</h2> 
                    </div>
                    <div class="body">
					<div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for=""> JENIS USER : </label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <select id="pilihjenis" name="jenis" class="form-control show-tick">
										<option value="">Pilih Jenis User</option>
										<?php
                                        foreach ($list_jenis as $ListJenisValue) { ?>
                                        <option value="<?php echo $ListJenisValue['ID_JENIS_USER']; ?>"><?php echo $ListJenisValue['JENIS_USER']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for=""> NAMA MENU : </label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <select id="pilihmenu" name="menu" class="form-control show-tick">
										<option value="">Pilih Menu</option>
										<?php
                                        foreach ($list_menu as $ListMenuValue) { ?>
                                        <option value="<?php echo $ListMenuValue['ID_MENU']; ?>"><?php echo $ListMenuValue['NAMA_MENU']; ?></option>
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
								<table class="table table-striped table-bordered dataTable no-footer" id="daftar_user_role">
									<thead >
										<tr>
											<th bgcolor="#ffb990">NO</th>
											<th bgcolor="#ffb990">ID USER AKSES</th>
											<th bgcolor="#ffb990">JENIS USER</th>
											<th bgcolor="#ffb990">NAMA MENU</th>
											<th bgcolor="#ffb990"><center>ACTION</center></th>
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
                <h4 class="modal-title" id="judul_produk_order">Edit Data Jenis User </h4>
            </div>
            <div class="modal-body">
                <div class="row">
						<input type="hidden" name="id_edit" id="id_edit">
						<div class="row clearfix">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">EDIT NAMA JENIS USER : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
											<select id="pilihjenis_edit" name="jenis_edit" class="form-control show-tick">
												<option value="">Pilih Jenis User</option>
												<?php
												foreach ($list_jenis as $ListJenisValue) { ?>
												<option value="<?php echo $ListJenisValue['ID_JENIS_USER']; ?>"><?php echo $ListJenisValue['JENIS_USER']; ?></option>
												<?php } ?>
											</select>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						<div class="row clearfix">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">EDIT NAMA MENU: </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
											<select id="pilih_edit" name="menu_edit" class="form-control show-tick">
												<option value="">Pilih Menu</option>
												<?php
												foreach ($list_menu as $ListMenuValue) { ?>
												<option value="<?php echo $ListMenuValue['ID_MENU']; ?>"><?php echo $ListMenuValue['NAMA_MENU']; ?></option>
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

<div class="modal fade" id="modal_sukses" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
					<div class="alert alert-warning">
					<strong>WASPADA!</strong> APAKAH ANDA YAKIN MENYIMPAN INI ?.
					</div>
                </div>
            </div>
			<div class="modal-footer bg-white">
                <button type="button" class="btn btn-link waves-effect" id="OK"> Ya</button>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
	$("#daftar_user_role").dataTable();
	
	// function show_data_tabel(){
            // $.ajax({
                // type  : 'ajax',
                // url   : '<?php echo site_url()?>master/C_V_D/data_tabel',
                // async : true,
                // dataType : 'json',
                // success : function(data){
                // var $isi = '';
				// var $no =1;
				// foreach($data as $d){
					// $btn_edit = '<button class="btn btn-info waves-effect " id="edit_user" idpd="'.$d['ID_USER_AKSES'].'"><span class="fa fa-pencil-square-o"></span></button>';
					// $btn_hapus = '<button class="btn btn-danger waves-effect" id="Hapus_user" idpd="'.$d['ID_USER_AKSES'].'"><span class="fa fa-trash-o "></span></button>';
					// $isi .= '<tr>';
					// $isi .= '<td>'.$no.'</td>';
					// $isi .= '<td>'.$d['ID_USER_AKSES'].'</td>';
					// $isi .= '<td>'.$d['JENIS_USER'].'</td>';
					// $isi .= '<td>'.$d['NAMA_MENU'].'</td>';
					// $isi .= '<td><center>'.$btn_edit. ' ' .$btn_hapus.'</center></td>';
					// $isi .= '</tr>';
					
					// $no=$no+1;
					// }
                    // $('#show_data').html(isi);
                // }
 
            // });

$(document).on("click", "#Simpan", function(){
	$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	$("#daftar_user_role").dataTable();
	var id_jenis = $('#pilihjenis option:selected').val();
	var id_menu = $('#pilihmenu option:selected').val();
	$.ajax({
		url: '<?php echo site_url(); ?>master/C_V_D/Ajax_tambah_data',
		type: 'POST',
		data: {
			"id_jenis"   		: id_jenis,
			"id_menu"   		: id_menu
		},
		success: function(j){
			var dt = JSON.parse(j);
			//$("#modal_sukses").modal('show');
			$("#show_data").html(dt.html);
			$("#daftar_user_role").dataTable().api().destroy();
			$("#daftar_user_role").dataTable();
			location.reload(true);
		},
		error: function(){
		}
    });
	
});

// $(document).on("click", "#OK", function(){
// location.reload(true);
// });

$(document).on("click", "#edit_user", function(){
	$("#form_edit").modal('show');
	
	idpd = $(this).attr("idpd");
	$("#id_edit").val(idpd);
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/C_V_D/Ajax_data_id',
		type: 'POST',
		data: {
			
			"id" : idpd
		},
		success: function(j){
			var dt = JSON.parse(j);			
			var data =(dt.html[0]);
			console.log(data);
			// $('#pilihjenis_edit option[value="'+data.ID_JENIS_USER+'"]').attr('selected', 'selected');
			// $('#pilih_edit option[value="'+data.ID_MENU+'"]').attr('selected', 'selected');
			// $('[name="jenis_edit"]').val(data.ID_JENIS_USER);
			// $('[name="menu_edit"]').val(data.ID_MENU);
			$('select[name="jenis_edit"]').append('<option value="'+ data.ID_JENIS_USER +'" selected>'+ data.JENIS_USER +'</option>').trigger('change');
			$('select[name="menu_edit"]').append('<option value="'+ data.ID_MENU +'" selected>'+ data.NAMA_MENU +'</option>').trigger('change');
		},
		error: function(){
		}
    });
});

$(document).on("click", "#Ubah", function(){
	$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	id = $("#id_edit").val();
	
	id_jenisedit = $('#pilihjenis_edit option:selected').val();
	id_menuedit = $('#pilih_edit option:selected').val();

	console.log(id,id_jenisedit,id_menuedit);
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/C_V_D/Ajax_simpan_edit',
		type: 'POST',
		data: {
			"id_user_akses" 	: id,
			"id_jenis"			: id_jenisedit,
			"id_menu"			: id_menuedit
		},
		success: function(j){
			var dt = JSON.parse(j);
			$("#show_data").html(dt.html);
			$("#daftar_user_role").dataTable().api().destroy();
			$("#daftar_user_role").dataTable();
			location.reload(true);
			$("#form_edit").modal('hide');
		},
		error: function(){
		}
    });
	
});

$(document).on("click", "#Hapus_user", function(){
	$("#modal_hapus").modal('show');
	idpd = $(this).attr("idpd");
	$("#hapus_id").val(idpd);
	
});

$(document).on("click", "#Hapus_Data", function(){
	$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	id = $("#hapus_id").val();
	$.ajax({
		url: '<?php echo site_url(); ?>master/C_V_D/Ajax_hapus_data',
		type: 'POST',
		data: {
			
			"id_user" : id
		},
		success: function(j){
			var dt = JSON.parse(j);
			$("#show_data").html(dt.html);
			$("#daftar_user_role").dataTable().api().destroy();
			$("#daftar_user_role").dataTable();
			location.reload(true);
			$("#modal_hapus").modal('hide');

		},
		error: function(){
		}
    });
});
});
</script>
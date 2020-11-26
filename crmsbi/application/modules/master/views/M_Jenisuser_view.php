<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-10 col-md-offset-1">
                <!-- card view -->
                <div class="card">
					<div class="header header-title bg-red bg-cyan-">
                        <h2> Data Master Jenis User</h2> 
                    </div>
                    <div class="body">
					<div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for=""> NAMA JENIS USER: </label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input value="" type="text" id="nama_jenis" class="form-control" name="nama" placeholder="NAMA JENIS USER">
                                </div>
                            </div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary" id="Simpan"><i class="fa fa-save"></i> Save</button>
							</div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="table-responsive">
								<table class="table table-striped table-bordered dataTable no-footer" id="daftar_jenis_user">
									<thead >
										<tr>
											<th bgcolor="#ffb990">NO</th>
											<th bgcolor="#ffb990">ID JENIS USER</th>
											<th bgcolor="#ffb990">NAMA JENIS USER</th>
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
                <h4 class="modal-title" id="judul">Edit Data Jenis User </h4>
            </div>
            <div class="modal-body">
                <div class="row">
						<input type="hidden" name="id_edit" id="id_edit">
						<div class="row clearfix">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">NAMA JENIS USER : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <input type="text" id="nama_jenis_edit" value="" class="form-control" placeholder="NAMA JENIS USER">
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
	$("#daftar_jenis_user").dataTable();

$(document).on("click", "#Simpan", function(){
	//$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	$.ajax({
		url: '<?php echo site_url(); ?>master/M_Jenis_User/Ajax_tambah_data',
		type: 'POST',
		data: {
			"jenis_user"   		: $("#nama_jenis").val()
		},
		success: function(j){
			var dt = JSON.parse(j);
			$("#show_data").html(dt.html);
			$("#daftar_jenis_user").dataTable().api().destroy();
			$("#daftar_jenis_user").dataTable();
			location.reload(true);
			
			if(dt.notify==1){
                $("#nama_jenis").val("");      
            }
			
		},
		error: function(){
		}
    });
	
});

$(document).on("click", "#edit_jenis", function(){
	$("#form_edit").modal('show');
	
	idpd = $(this).attr("idpd");

	$("#id_edit").val(idpd);
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/M_Jenis_User/Ajax_data_id',
		type: 'POST',
		data: {
			"id" : idpd
		},
		success: function(j){
			var dt = JSON.parse(j);
			var data =(dt.html[0]);
			$("#daftar_jenis_user").dataTable();
			$("#nama_jenis_edit").val(data.JENIS_USER);
		},
		error: function(){
		}
    });
});

$(document).on("click", "#Ubah", function(){
	//$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	id = $("#id_edit").val();
	$.ajax({
		url: '<?php echo site_url(); ?>master/M_Jenis_User/Ajax_simpan_edit',
		type: 'POST',
		data: {
			"$id_jns_user" 			: id,
			"jenis_user"			: $("#nama_jenis_edit").val()
		},
		success: function(j){
			var dt = JSON.parse(j);
			$("#show_data").html(dt.html);
			$("#daftar_jenis_user").dataTable().api().destroy();
			$("#daftar_jenis_user").dataTable();
			location.reload(true);
			$("#form_edit").modal('hide');
		},
		error: function(){
		}
    });
	
});

$(document).on("click", "#Hapus_jenis", function(){
	$("#modal_hapus").modal('show');
	
	idpd = $(this).attr("idpd");

	$("#hapus_id").val(idpd);
});

$(document).on("click", "#Hapus_Data", function(){
	//$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	id = $("#hapus_id").val();	
	$.ajax({
		url: '<?php echo site_url(); ?>master/M_Jenis_User/Ajax_hapus_data',
		type: 'POST',
		data: {
			
			"id" : id
		},
		success: function(j){
			var dt = JSON.parse(j);
			$("#show_data").html(dt.html);
			$("#daftar_jenis_user").dataTable().api().destroy();
			$("#daftar_jenis_user").dataTable();
			location.reload(true);
			if(dt.notify==1){
                $("#hapus_id").val("");      
            }
			
			$("#modal_hapus").modal('hide');
		},
		error: function(){
		}
    });
});
});
</script>
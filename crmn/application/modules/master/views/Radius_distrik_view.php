

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
				<div class="card">
					<div class="header header-title">
						<h2>Setting Radius Lock Distrik</h2>
					</div>
					<div class="body" style="margin: 0 1em 0 1em;">
                        <div class="row">
						
							<button id="btnModal_addRD" class="btn btn-success" style="margin-bottom: 1em; margin-top: 0.5em 0 0.5em 0;"><i class="glyphicon glyphicon-plus"></i> Tambah Setting Radius Distrik</button>

							<table id="table_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th style="width: 5%;">No.</th>
										<th>Nama Distrik</th>
										<th>Radius Lock (meter)</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody id="show_table_data">
								
								</tbody>
							</table>
							
						</div>
					</div>
				</div>
				
			</div>
        </div>
    </div>
</section>

<script>

$(document).ready(function() {
	do_list_radius_distrik();
});

$(document).on("click", "#btnModal_addRD", function(){
	$("#create_at").text('');
	$('#form').get(0).reset(); // reset form on modals
	$("#id_radius_distrik").val('0000');
	$("#id_distrik").val('a404a').change().attr("disabled", false);
	$('#modal_form').modal('show'); // show bootstrap modal
	$('.modal-title').text('Tambah Setting Radius Lock Distrik'); // Set Title to Bootstrap modal title 
});

$(document).on("click", "#btnModal_editRD", function(e){
	e.preventDefault();
	
	var id_rd 		 = $(this).attr("dt_id_rd");
	var id_distrik 	 = $(this).attr("dt_id_distrik");
	var nm_distrik 	 = $(this).attr("dt_nama_distrik");
	var radius_lock  = $(this).attr("dt_radius_lock");
	var create_at 	 = $(this).attr("dt_create_at");	
	//concole.log(id_distrik);
	$("#id_radius_distrik").val(id_rd);
	$("#id_distrik").val(id_distrik+'-'+nm_distrik).change().attr("disabled", true);
	$("#radius_lock").val(radius_lock);
			
	$("#create_at").text('Create at: ' +create_at);
	
	$("#modal_form").modal('show');
	$('.modal-title').text('Edit Setting Radius Lock Distrik : ');
});

$(document).on("click", "#BtnTambah_RD", function(e){
	e.preventDefault();
	 
	var id_rd 	  = $('#id_radius_distrik').val();
	var ditrikSet = $('#id_distrik option:selected').val();
	var radius_lock	= $("#radius_lock").val();
	
	// console.log(id_rd);
	// console.log(ditrikSet);
	// console.log(radius_lock);
	
	if(ditrikSet == 'a404a'){
		alert("Masukkan Pilihan Distrik Terlebih Dahulu.");
	} else {
		var responseIn = '';
		var get_link_akses = '<?php echo site_url(); ?>master/Radius_distrik/Set_radius_distrik';
		$.ajax({
		    url: get_link_akses,
		    type: 'POST',
			data: {
				"id_rd" 		: id_rd,
				"distrik" 		: ditrikSet,
				"radius_lock" 	: radius_lock
			},
			dataType: 'JSON',
		    success: function(datas){
				
                responseIn = datas['pesan'];
				if (responseIn == 'insert'){
					alert("Penambahan Radius Distrik Berhasil.");
					$("#table_data").DataTable().destroy();
					do_list_radius_distrik();
				} else if(responseIn == 'update'){
					alert("Update Radius Distrik Berhasil.");
					$("#table_data").DataTable().destroy();
					do_list_radius_distrik();
				} else if (responseIn == 'ready') {
					alert("Data Sudah Ditambahkan Sebelumnya.");
				} 
				$("#modal_form").modal('hide');
		    }
		});
	}
});

$(document).on("click", "#BtnHapus_RD", function(e){
	e.preventDefault();
	var id_rd 		 = $(this).attr("dt_id_rd");
	var id_distrik 	 = $(this).attr("dt_id_distrik");
	var nm_distrik 	 = $(this).attr("dt_nama_distrik");
	
	if (confirm("Apakah Anda Yakin Ingin Menghapus Data Radius Lock ["+id_distrik+"] "+nm_distrik+"?")) {
		var responseIn = '';
		var get_link_akses = '<?php echo site_url(); ?>master/Radius_distrik/Del_radius_distrik';
		$.ajax({
		    url: get_link_akses,
		    type: 'POST',
			data: {
				"id_rd" 		: id_rd
			},
			dataType: 'JSON',
		    success: function(datas){
                //responseIn = datas['pesan'];
				alert("Hapus Data Radius Distrik Berhasil.");
				$("#table_data").DataTable().destroy();
				do_list_radius_distrik();
		    }
		});
    }

});

function do_list_radius_distrik(){
	
	$("show_table_data").html('<tr><td colspan="5"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	
	var get_link_akses = '<?php echo site_url(); ?>master/Radius_distrik/list_data';
	$.ajax({
		url: get_link_akses,
	    type: 'GET',
		dataType: 'JSON',
	    success: function(datas){
            //var response = datas;
			//console.log(datas);
            var html = '';
			var no = 1 ;
            for (var i = 0; i < datas.length; i++) {
				//console.log(datas[i].ID_DISTRIK);
               var button = '<td style="text-align: center;">'+
								'<span id="btnModal_editRD" class="btn btn-info" dt_id_rd="'+datas[i].ID_RADIUS_DISTRIK+'" dt_id_distrik="'+datas[i].ID_DISTRIK+'" dt_nama_distrik="'+datas[i].NAMA_DISTRIK+'" dt_radius_lock="'+datas[i].DISTRIK_LOCK+'" dt_create_at="'+datas[i].CREATE_AT+'"><i class="fa fa-edit" title="Edit"></i> </span>'+
								'<span id="BtnHapus_RD" class="btn btn-danger"  dt_id_rd="'+datas[i].ID_RADIUS_DISTRIK+'" dt_id_distrik="'+datas[i].ID_DISTRIK+'" dt_nama_distrik="'+datas[i].NAMA_DISTRIK+'"> <i class="fa fa-trash" title="Hapus"></i></span>'+
							 '</td>'; 
					
				html += '<tr>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>['+datas[i].ID_DISTRIK+'] '+datas[i].NAMA_DISTRIK+'</td>'+
					'<td>'+datas[i].DISTRIK_LOCK+'</td>'+
					button+
				'</tr>';
				no++;
        	}
            $('#show_table_data').html(html);
			$('#table_data').dataTable();
		}
	});	
}

</script>


<!-- Bootstrap modal add & edit-->
<div class="modal fade" id="modal_form" role="dialog" >
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: #8c7ae6; padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title">Form</h2>
			</div>
			<form id="form" class="form-horizontal" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<input type="hidden" id="id_radius_distrik" name="id_radius_distrik">
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Pilih Distrik : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                
								<div class="form-line">
                                    <select class="form-control selectpicker show-tick" name="id_distrik" id="id_distrik" data-size="10" data-live-search="true" required>
										<option value="a404a" disabled selected> &nbsp;&nbsp;&nbsp; Masukkan pilihan Distrik</option>
										<?php foreach($distrik as $dt){ ?>
											<option value="<?= $dt['KD_KOTA']; ?>-<?= $dt['KOTA']; ?>"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [<?= $dt['KD_KOTA']; ?>] <?= $dt['KOTA']; ?></option>
										<?php } ?>
									</select>
                                </div>
                            </div>
                        </div>
                    </div>
					<br>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Radius Lock : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8"> 
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="radius_lock" min="0" class="form-control" name="radius_lock" placeholder="Masukkan radius lock (meter)" required>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="modal-footer">
				<span id="create_at" style="float: left; padding: 0.5em 0 0 0.5em"> </span>
				<button id="BtnTambah_RD" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal add-->
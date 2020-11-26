<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
				<div class="card">
				
					<div class="header bg-cyan">
						<h2 style="padding-top: 0.2em;">AKSES MENU => [<?= $id_j_user_in; ?>] <?= $jenis_user_in; ?></h2>
					</div>
						
					<div class="body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group" style="">
									<button style="float: right; margin-right: 1em;" type="button" id="BtnTambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Akses Menu</button>
								</div>
								
							</div>
						
							<div class="col-md-12" > 
								<div class="row">
									<div class="table-responsive" style=" margin-left: 2em; margin-right: 2em;">
										<table class="table table-striped table-bordered dataTable no-footer" id="daftar_akses_user" style="font-size: 12px;">
											<thead >
												<tr>
													<th bgcolor="#ffb990" width="3%">NO</th>
													<th bgcolor="#ffb990">LIST MENU & SUB MENU</th>
													<th bgcolor="#ffb990"><center>ACTION</center></th>
												</tr>
											</thead>
											<tbody id="show_data_akses_user"></tbody>
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
</section>

<!-- Bootstrap modal Add & Edit User-->
<div class="modal fade" id="modal_menu_a_u" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: rgba(112, 161, 255,1.0); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: #000;">  </h2>
			</div>
			<form id="form-in">
			<div class="modal-body form" >
				<div class="form-body">
					<input type="hidden" id="id_up_submenu" name="id_up_submenu" value="0000">
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label id="labelNama1" for="name">Nama Menu : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									 <div class="form-line" id="ListMenus"></div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			<div class="modal-footer">
				<button id="BtnSimpanMenu" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batalkan</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- Bootstrap modal Add & Edit User-->

<script>
var id_j_user_in = <?= $id_j_user_in;?>;
$(document).ready(function() {
   load_akses_ke_menu();
}); 

function ListMenus(key){
	var type_list = '';
	type_list += '<select id="listMenus_set" name="listMenus_set" class="form-control selectpicker show-tick" data-size="10" data-live-search="true">';
	$.ajax({
            url: "<?php echo base_url(); ?>user/Manajemen_menu/List_menu",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data;
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Menu -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i].ID_MENU+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ['+response[i].ID_MENU+'] '+response[i].NAMA_MENU+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        });
}

$(document).on("click", "#BtnTambah", function(){
	$('#form-in').trigger("reset");
	ListMenus("#ListMenus");
	$("#modal_menu_a_u").modal('show');
	$('.modal-title').text('Tambah Menu : ');
});

$(document).on("click", "#BtnSimpanMenu", function(e){
	e.preventDefault();
	var responseIn = '';
	var menuSet = $('#listMenus_set option:selected').val();
	
	$.ajax({
		url: '<?php echo site_url(); ?>user/Manajemen_menu/set_akses_menu_to_user',
		type: 'POST',
		data: {
			"actIn_or_Del" : 'in',
			"id_jenis_user" : id_j_user_in,
			"id_menu" : menuSet
		}, 
		dataType: 'JSON',
		success: function(data){
			responseIn = data['pesan'];
				if (responseIn == 'success'){
					alert("Akses Menu Berhasil Disimpan.");
				} else if (responseIn == 'ready') {
					alert("Data Menu Sudah Ditambahkan Sebelumnya.");
				} else if (responseIn == 'failed') {
					alert("Akses Menu Gagal Disimpan.");
				} 
			$("#modal_menu_a_u").modal('hide');
			//alert("Akses Menu Berhasil Disimpan.");
			$("#daftar_akses_user").DataTable().destroy();
			load_akses_ke_menu();
		},
		error: function(){
			alert("Akses Menu Gagal Disimpan.");
		}
    });
});

$(document).on("click", "#BtnHapus", function(e){
	e.preventDefault();
	var id_menu = $(this).attr("dt_id_menu");
	var nama_menu = $(this).attr("dt_nama_menu");
	if (confirm("Apakah Anda Yakin Ingin Menghapus Data Menu ["+id_menu+" - "+nama_menu+"] ?")) {
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_menu/set_akses_menu_to_user',
			type: 'POST',
			data: {
				"actIn_or_Del" : 'del',
				"id_jenis_user" : id_j_user_in,
				"id_menu" : id_menu
			}, 
			dataType: 'JSON',
			success: function(data){
				responseIn = data['pesan'];
					if (responseIn == 'success'){
						alert("Akses Menu Berhasil Dihapus.");
					} else if (responseIn == 'ready') {
						alert("Data Menu Sudah Ditambahkan Sebelumnya.");
					} else if (responseIn == 'failed') {
						alert("Akses Menu Gagal Dihapus.");
					} 
				$("#modal_menu_a_u").modal('hide');
				//alert("Akses Menu Berhasil Disimpan.");
				$("#daftar_akses_user").DataTable().destroy();
				load_akses_ke_menu();
			},
			error: function(){
				alert("Akses Menu Gagal Disimpan.");
			}
		});
		return true;
    }
});

function load_akses_ke_menu(){
	$("#show_data_akses_user").html('<tr><td colspan="10"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_menu/list_akses_menu_by_jenis_user',
			type: 'POST',
			dataType : 'json',
			data: {
				"id_jenis_user" : id_j_user_in
			},
			success: function(datasku){
				var data = datasku['data'];
				
				  var html = '';
				  var i;
				  var c = "x"; 
				  var no = 1 ;
				  
				  for(i=0; i<data.length; i++){
							 
					var menunya = '';
					if(data[i].MENU != null){
						if(data[i].MENU.length > 0){
							data[i].MENU.forEach(function(isi){
								var button = '<td style="text-align: center;">'+
									'<span id="BtnHapus" class="btn btn-danger" dt_id_menu="'+isi.ID_MENU+'" dt_nama_menu="'+isi.NAMA_MENU+'"><i class="fa fa-trash" title="hapus"></i></span>'+
								 '</td>'; 
								 
								menunya += '<li><b> ['+isi.ID_MENU+'] '+isi.NAMA_MENU+'</b></li>';
								if(isi.SUB_MENU.length > 0){
									isi.SUB_MENU.forEach(function(sub){
										menunya += '<ul>- ['+sub.ID_SUBMENU+'] '+sub.NAMA_SUBMENU+'</ul>';
									});
								}
								html += '<tr class='+c+'>'+
								'<td style="text-align: center;">'+no+'</td>'+
								'<td>'+menunya+'</td>'+
								button+
								'</tr>';
								no++;
								if(c == "x"){
									c = "y"  ;
								}else{
									c = "x" ; 
								}
								menunya = '';
							});
						}
					}
					
			}
				$('#show_data_akses_user').html(html);
				$("#daftar_akses_user").dataTable();
			},
			error: function(){
			}
		});
}

</script>
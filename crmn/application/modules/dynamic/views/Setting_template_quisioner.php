<style>
span.c {
  text-transform: lowercase;
}
</style>

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
				<div class="card" style="padding-bottom: 0; display: none;" id="detail_template">
				
					<div class="header bg-purple">
						<h2 style="padding-top: 0.2em;">MASTER TEMPLATE : <span id="id_template_text"></span> - <span id="nama_template_text"></span></h2><ul class="header-dropdown m-r--5">
							<li class="dropdown">
								<button id="BtnCloseDetail" class="btn btn-danger"><i class="fa fa-times"></i></button>
							</li>
						</ul>
						<!-- <button style="float: right;" id="BtnCloseDetail" class="btn btn-danger"><i class="fa fa-times"></i></button> -->
					</div>
						
					<div class="body">
						<div class="row">
							
							<div class="col-md-3" >
								<div class="card" style="padding-bottom: 0;">
									<div class="header bg-red">
										<h2 style="padding-top: 0.2em;">KATEGORI PERTANYAAN</h2>
										<ul class="header-dropdown m-r--5">
											<li class="dropdown">
												<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Tambah Jenis Penilaian">
													<i class="material-icons">library_add</i>
												</a>
												<ul class="dropdown-menu pull-right">
													<li><a href="javascript:void(0);" id="btnModal_tambahJP">Tambah Kategori Pertanyaan</a></li>
												</ul>
											</li>
										</ul>
									</div>
									<div class="body">
										<div class="list-group" id="list_dt_jp">
											
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-md-9">
								<div class="card" id="list_dt_pertanyaan">
									
								</div>
							</div>
								
						</div>
					</div>
					
				</div>
				
			</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
				<div class="card" id="list_template">
				
					<div class="header bg-cyan">
						<h2 style="padding-top: 0.2em;">MANAJEMEN TEMPLATE </h2>
					</div>
						
					<div class="body">
						<div class="row">
							<div class="col-md-12">
								
								<div class="form-group" style="">
									<button style="float: right; margin-right: 1em;" type="button" id="BtnTambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Template</button>
								</div>
								
							</div>
						
							<div class="col-md-12" >
								<div class="row">
									<div class="table-responsive" style=" margin-left: 2em; margin-right: 2em;">
										<table class="table table-striped table-bordered dataTable no-footer" id="daftar_menu" style="font-size: 12px;">
											<thead >
												<tr>
													<th bgcolor="#ffb990" width="5%">NO</th>
													<th bgcolor="#ffb990" width="40%">NAMA</th>
													<th bgcolor="#ffb990" width="15%">STATUS</th>
													<th bgcolor="#ffb990" width="10%">TANGGAL BUAT</th>
													<th bgcolor="#ffb990" width="15%">DIBUAT OLEH</th>
													<th bgcolor="#ffb990" width="15%"><center>ACTION</center></th>
												</tr>
											</thead>
											<tbody id="show_data_menu"></tbody>
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

<!--1 modal tambah dan edit jenis penilaian -->
<div class="modal fade" id="modal_act_jp" role="dialog">
    <div class="modal-dialog modal-lg">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: rgba(112, 161, 255,1.0); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: #000;">  </h2>
			</div>
			<form id="form-in-jp">
			<div class="modal-body form" >
				<div class="form-body">
					<input type="hidden" id="id_jp" name="id_jp">
					<input type="hidden" id="id_templ_jp" name="id_templ_jp">
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label id="labelNama" for="name">Nama Kategory : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="jp" class="form-control" name="jp" placeholder="Masukkan Nama Kategory" required>
								</div>
							</div>
						</div>
					</div>					
				</div>
			</div>
			<div class="modal-footer">
				<button id="BtnSimpanJP" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batalkan</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- akhir modal 1-->


<!--2 modal tambah dan edit pertanyaan -->
<div class="modal fade" id="modal_act_pertanyaan" role="dialog">
    <div class="modal-dialog modal-lg">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: rgba(112, 161, 255,1.0); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: #000;">  </h2>
			</div>
			<form id="form-in-p">
			<div class="modal-body form" >
				<div class="form-body">
					<input type="hidden" id="id_p" name="id_p">
					<input type="hidden" id="id_jp" name="id_jp">
					<div class="row clearfix">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 form-control-label">
							<label id="labelNama" for="name">Pertanyaan <span style="color: red;">(*)</span> : </label>
						</div>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="p" class="form-control" name="p" placeholder="Masukkan Pertanyaan " required>
								</div>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 form-control-label">
							<label id="labelNama" for="name">Type Jawaban : </label>
						</div>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">
							<div class="form-group">
								<div class="form-check">
									<input class="form-check-input" type="radio" name="questtype" id="questtype1" value="MULTIPLE CHOICE" checked>
									<label class="form-check-label" for="questtype1">
									Multiple Choice
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="questtype" id="questtype2" value="INPUT TEXT">
									<label class="form-check-label" for="questtype2">
									Input Text / Essay
									</label>
								</div>
							</div>
						</div>
					</div>	

					<div class="row clearfix">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 form-control-label">
							<!-- <label id="labelNama" for="name">Type Pertanyaan : </label> -->
						</div>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">
							<div class="form-group">
								<div class="form-check">
									<input type="checkbox" class="form-check-input" id="optional_quest" name="optional_quest">
									<label class="form-check-label" for="optional_quest">Required</label>
								</div>
							</div>
						</div>
					</div>	

				</div>
			</div>
			<div class="modal-footer">
				<button id="BtnSimpanPertanyaan" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batalkan</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- akhir modal 2-->


<!--3 modal tambah dan edit opsional jawaban -->
<div class="modal fade" id="modal_act_opsiJawaban" role="dialog">
    <div class="modal-dialog modal-lg">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: rgba(112, 161, 255,1.0); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: #000;">  </h2>
			</div>
			<form id="form-in-oj">
			<div class="modal-body form" >
				<div class="form-body">
					<input type="hidden" id="id_oj" name="id_oj">
					<input type="hidden" id="id_p" name="id_p">
					<input type="hidden" id="id_jp" name="id_jp">
					<div class="row clearfix">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 form-control-label">
							<label id="labelNama" for="name">Opsi Jawaban : </label>
						</div>
						<div class="col-lg-7 col-md-7 col-sm-7 col-xs-6">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="oj" class="form-control" name="oj" placeholder="Masukkan Opsi Jawaban " required>
								</div>
							</div>
						</div>
						<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 form-control-label">
							<label id="labelNama" for="name">Point : </label>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="form-group">
								<div class="form-line">
									<input type="number" min="0" id="point" class="form-control" name="point" placeholder="Point " required>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			<div class="modal-footer">
				<button id="BtnSimpanOJ" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batalkan</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- akhir modal 3-->

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
					<input type="hidden" id="id_up_templ" name="id_up_templ" value="">
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label id="labelNama1" for="name">Nama Template : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="nama_template" class="form-control" name="nama_template" placeholder="Masukkan Nama Template " required>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label id="labelNama1" for="name">Deskripsi : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="deskripsi_template" class="form-control" name="deskripsi_template" placeholder="Masukkan Deskripsi " required>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-check">
									<input type="checkbox" class="form-check-input" id="active_template" name="active_template">
									<label class="form-check-label" for="active_template">Active</label>
								</div>
							</div>
						</div>
						

					</div>



					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label for="name">Order : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="number" id="order" class="form-control" name="order" placeholder="Masukkan Order " >
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

$(document).ready(function() {
	// do_list_jp();
 //    do_list_pertanyaan(null);
    load_menu();
});

$(document).on("click", "#BtnTambah", function(){
	$('#form-in').trigger("reset");
	$("#id_up_user").val(0000);
	$("#modal_menu_a_u").modal('show');
	$('.modal-title').text('Tambah Template : ');
});

$(document).on("click", "#BtnEdit", function(){
	$("#modal_menu_a_u").modal('show');
	
	var id_up_templ = $(this).attr("dt_id_template");
	var nama_template = $(this).attr("dt_nama_template");
	var deskripsi_template = $(this).attr("dt_deskripsi");
	var active_template = $(this).attr("dt_active");
	var order = $(this).attr("dt_order");
	
	$("#id_up_templ").val(id_up_templ);
	$("#nama_template").val(nama_template);
	$("#deskripsi_template").val(deskripsi_template);
	$("#active_template").prop('checked', false);
	if (parseInt(active_template) == 1) {
		$("#active_template").prop('checked', true);
	}
	$("#order").val(order);
	
	$('.modal-title').text('Edit Template : ['+id_up_templ+'] '+nama_template);
});

$(document).on("click", "#BtnDetail", function(){
	$("#list_template").hide();
	$("#detail_template").show();
	var id_up_templ = $(this).attr("dt_id_template");
	var nama_template = $(this).attr("dt_nama_template");
	$("#id_template_text").html(id_up_templ);
	$("#nama_template_text").html(nama_template);	
	do_list_jp();
    do_list_pertanyaan(null);

});

$(document).on("click", "#BtnCloseDetail", function(){
	$("#detail_template").hide();
	$("#list_template").show();
});


$(document).on("click", "#BtnSimpanMenu", function(e){
	e.preventDefault();
	$.ajax({
		url: '<?php echo site_url(); ?>dynamic/TemplateQuisioner/set_template',
		type: 'POST',
		data: {
			"ID" : $("#id_up_templ").val(),
			"NAMA_TEMPLATE" : $("#nama_template").val(),
			"DESKRIPSI" : $("#deskripsi_template").val(),
			"IS_ACTIVE" : ($("#active_template").prop("checked") == true) ? 1 : 0,
			"ORDER_TEMPLATE" : $("#order").val()
		}, 
		success: function(data){
			$("#modal_menu_a_u").modal('hide');
			alert("Data Template Berhasil Disimpan.");
			$("#daftar_menu").DataTable().destroy();
			load_menu();
			$("#id_up_templ").val('');
		},
		error: function(){
			alert("Data Template Gagal Disimpan.");
		}
    });
});

$(document).on("click", "#BtnHapus", function(e){
	e.preventDefault();
	var id_templ = $(this).attr("dt_id_template");
	var nama_templ = $(this).attr("dt_nama_template");
	if (confirm("Apakah Anda Yakin Ingin Menghapus Data Template ["+id_templ+" - "+nama_templ+"] ?")) {
		$.ajax({
			url: '<?php echo site_url(); ?>dynamic/TemplateQuisioner/del_template',
			type: 'POST',
			data: {
				"ID" : id_templ
			},
			success: function(data){
				$("#daftar_menu").DataTable().destroy();
				load_menu();
				alert("Data Template Berhasil Dihapus.");
			},
			error: function(){
				alert("Data Template Gagal Dihapus.");
			}
		});
		return true;
    }
});

function load_menu(){
	$("#show_data_menu").html('<tr><td colspan="10"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>dynamic/TemplateQuisioner/list_template',
			type: 'GET',
			dataType : 'json',
			success: function(datasku){
				
				var html = '';
				if (datasku['data']) {
					var data = datasku['data'];
					var i;
					var c = "x";
					var no = 1 ;
					  
					var link; var order;
					var setIcon; var setLink; var setOrder;
					  
					for(i=0; i<data.length; i++){
						
						var button = '<td style="text-align: center;">'+
									'<span id="BtnEdit" class="btn btn-info" dt_id_template="'+data[i].ID+'" dt_nama_template="'+data[i].NAMA_TEMPLATE+'" dt_deskripsi="'+data[i].DESKRIPSI+'" dt_active="'+data[i].IS_ACTIVE+'" dt_order="'+data[i].ORDER_TEMPLATE+'" ><i class="fa fa-edit" title="edit"></i></span> &nbsp;'+
									'<span id="BtnHapus" class="btn btn-danger" dt_id_template="'+data[i].ID+'" dt_nama_template="'+data[i].NAMA_TEMPLATE+'"><i class="fa fa-trash" title="hapus"></i></span> &nbsp;'+
									'<span id="BtnDetail" class="btn btn-success" dt_id_template="'+data[i].ID+'" dt_nama_template="'+data[i].NAMA_TEMPLATE+'"><i class="fa fa-list" title="detail"></i></span>'+
								 '</td>'; 
								 
						var sub_menunya = '';
						
						html += '<tr class='+c+'>'+
						'<td style="text-align: center;">'+no+'</td>'+
						// '<td>'+data[i].ID+'</td>'+
						'<td>'+data[i].NAMA_TEMPLATE+'</td>'+						
						'<td>'+((data[i].IS_ACTIVE == 1) ? 'ACTIVE' : 'NON-ACTIVE')+'</td>'+		
						'<td>'+data[i].CREATED_AT+'</td>'+	
						'<td>'+data[i].CREATED_BY+'</td>'+
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

				}

				$('#show_data_menu').html(html);
				$("#daftar_menu").dataTable();
			},
			error: function(){
			}
		});
}


// -------------------------------------------------------------- > JENIS PERTANYAAN

$(document).on("click", "#btnAct_List_jp", function(e){
	e.preventDefault();
	var id_jp = $(this).attr("dt_id_jp");
	do_list_pertanyaan(id_jp);
});

$(document).on("click", "#btnModal_tambahJP", function(e){
	e.preventDefault();
	$('#form-in-jp').trigger("reset");
	$("#id_jp").val();
	$("#id_templ_jp").val($("#id_template_text").text());	
	$("#modal_act_jp").modal('show');
	$('#labelNama').text('Kategory Pertanyaan : ');
	$('.modal-title').text('Tambah Kategory Pertanyaan : ');
});

$(document).on("click", "#btnModal_editJP", function(e){
	e.preventDefault();
	
	var id_jp = $(this).attr("dt_id_jp");
	var jp = $(this).attr("dt_jp");
	
	$("#id_jp").val(id_jp);
	$("#jp").val(jp);
	$("#id_templ_jp").val($("#id_template_text").text());	
	
	$("#modal_act_jp").modal('show');
	$('#labelNama').text('Kategori Pertanyaan : ');
	$('.modal-title').text('Edit Kategori Pertanyaan : ');
});

$(document).on("click", "#BtnSimpanJP", function(e){
	e.preventDefault();
	
	var id_jp 		= $("#id_jp").val();
	var id_templ 	= $("#id_templ_jp").val();
	var jp			= $("#jp").val();
	
	if(jp != "" && jp != null && jp != ''){
		$.ajax({
			url: '<?php echo site_url(); ?>dynamic/TemplateQuisioner/simpanJenisPenilaian',
			type: 'POST',
			data: {
				"ID" : $("#id_jp").val(),
				"FK_ID_TEMPLATE" : $("#id_templ_jp").val(),
				"NAMA_KATEGORY" : $("#jp").val()
			}, 
			success: function(data){
				$("#modal_act_jp").modal('hide');
				alert("Data Kategori Pertanyaan Berhasil Disimpan.");
				do_list_jp(); 
			},
			error: function(){
				alert("Data Kategori Pertanyaan Gagal Disimpan.");
			}
		});
	} else {
		alert("Kolom Kategori Pertanyaan tidak boleh kosong.");
	}
});

$(document).on("click", "#btnAct_hapusJP", function(e){
	e.preventDefault();
	var id_jp = $(this).attr("dt_id_jp");
	var jp = $(this).attr("dt_jp");
	if (confirm("Apakah Anda Yakin Ingin Menghapus Jenis Penilaian ["+id_jp+" - "+jp+"] ?")) {
		$.ajax({
			url: '<?php echo site_url(); ?>dynamic/TemplateQuisioner/hapusJenisPenilaian',
			type: 'POST',
			data: {
				"ID" : id_jp
			},
			success: function(data){
				do_list_jp();
				do_list_pertanyaan(null);
				alert("Data Jenis Penilaian Berhasil Dihapus.");
			},
			error: function(){
				alert("Data Jenis Penilaian Gagal Dihapus.");
			}
		});
		return true;
    }
});

function do_list_jp(){
	$("#list_dt_jp").html('<br><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center><br>');
	
	var get_link_akses = '<?php echo site_url(); ?>dynamic/TemplateQuisioner/list_jp_full_pertanyaan/'+$("#id_template_text").text();
	$.ajax({
		url: get_link_akses,
	    type: 'GET',
		dataType: 'JSON',
	    success: function(datas){
            var response = datas['data'];
 
            var list_dt_jp = '';
            for (var i = 0; i < response.length; i++) {
                list_dt_jp += '<a href="javascript:void(0);" id="btnAct_List_jp" dt_id_jp="'+response[i].ID_JP+'" class="list-group-item">'+response[i].JP+' ['+response[i].JML_SOAL+']</a>';
        	}
            $('#list_dt_jp').html(list_dt_jp);
		}
	});	
}

// ----------------------------------------------------------------------->  PERTANYAAN

$(document).on("click", "#btnModal_tambahPertanyaan", function(e){
	e.preventDefault();
	$('#form-in-p').trigger("reset");
	
	var id_jp = $(this).attr("dt_id_jp");
	var jp = $(this).attr("dt_jp");
	
	$("#id_jp").val(id_jp);
	$("#id_p").val(0000);
	$("#p").val('');
	
	$("#modal_act_pertanyaan").modal('show');
	$('#labelNama').text('Pertanyaan : ');
	$('.modal-title').text('Tambah Pertanyaan ['+jp+']: ');
});

$(document).on("click", "#btnModal_editPertanyaan", function(e){
	e.preventDefault();
	
	var id_jp = $(this).attr("dt_id_jp");
	var jp = $(this).attr("dt_jp");
	var id_p = $(this).attr("dt_id_p");
	var p = $(this).attr("dt_p");
	
	$("#id_p").val(id_p);
	$("#id_jp").val(id_jp);
	$("#p").val(p);
	
	$("#modal_act_pertanyaan").modal('show');
	$('#labelNama').text('Pertanyaan : ');
	$('.modal-title').text('Edit Pertanyaan ['+jp+']: ');
});

$(document).on("click", "#BtnSimpanPertanyaan", function(e){
	e.preventDefault();
	
	var id_jp 	= $("#id_jp").val();
	var id_p	= $("#id_p").val();
	var p		= $("#p").val();
	
	if(p != "" && p != null && p != ''){
		$.ajax({
			url: '<?php echo site_url(); ?>sales/SurveySales/simpanPertanyaan',
			type: 'POST',
			data: {
				"id_jp" : id_jp,
				"id_p"  : id_p,
				"p"		: p
			}, 
			success: function(data){
				$("#modal_act_pertanyaan").modal('hide');
				alert("Data Pertanyaan Berhasil Disimpan.");
				do_list_pertanyaan(id_jp); 
			},
			error: function(){
				alert("Data Pertanyaan Gagal Disimpan.");
			}
		});
	} else {
		alert("Kolom pertanyaan tidak boleh kosong.");
	}
});

$(document).on("click", "#btnAct_hapusPertanyaan", function(e){
	e.preventDefault();
	var id_jp = $(this).attr("dt_id_jp");
	var id_p = $(this).attr("dt_id_p"); 
	var p = $(this).attr("dt_p");
	
	if (confirm("Apakah Anda Yakin Ingin Menghapus Pertanyaan ["+id_p+" - "+p+"] ?")) {
		$.ajax({
			url: '<?php echo site_url(); ?>sales/SurveySales/hapusPertanyaan',
			type: 'POST',
			data: {
				"id_p" : id_p
			},
			success: function(data){
				do_list_pertanyaan(id_jp);
				alert("Data Pertanyaan Berhasil Dihapus.");
			},
			error: function(){
				alert("Data Pertanyaan Gagal Dihapus.");
			}
		});
		return true;
    }
});
 
function do_list_pertanyaan(id_jp_in){
	$("#list_dt_pertanyaan").html('<br><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center><br>');
	
	var get_link_akses = '<?php echo site_url(); ?>dynamic/TemplateQuisioner/list_jp_full_pertanyaan/'+$("#id_template_text").text();
	$.ajax({
		url: get_link_akses,
	    type: 'POST',
		dataType: 'JSON',
		data: {
			"id_jp" : id_jp_in
		},
	    success: function(datas){
            var response = datas['data'];
 
			var list_dt_tanya = '';
			var i;
			for (i = 0; i < response.length; i++) {
                if(i == 0){
					list_dt_tanya += 
						'<div class="header bg-red">'+
							'<h2 style="padding-top: 0.2em;">DAFTAR PERTANYAAN: '+response[i].JP.toUpperCase()+'</h2>'+
							'<ul class="header-dropdown m-r--5">'+
									'<li class="dropdown">'+
										'<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Action"><i class="material-icons">more_vert</i>'+
										'</a>'+
										'<ul class="dropdown-menu pull-right">'+
											'<li id="btnModal_tambahPertanyaan" dt_id_jp="'+response[i].ID_JP+'" dt_jp="'+response[i].JP.toUpperCase()+'"><a href="javascript:void(0);">Tambah Pertanyaan</a></li>'+
											'<li id="btnModal_editJP" dt_id_jp="'+response[i].ID_JP+'" dt_jp="'+response[i].JP+'"><a href="javascript:void(0);"><i class="fa fa-pencil-square-o" style="color: #000;" aria-hidden="true"></i> Edit Kategory Pertanyaan</a></li>'+
											'<li id="btnAct_hapusJP" dt_id_jp="'+response[i].ID_JP+'" dt_jp="'+response[i].JP.toUpperCase()+'"><a href="javascript:void(0);"><i class="fa fa-trash" style="color: #000;" aria-hidden="true"></i> Hapus Kategory Pertanyaan</a></li>'+						
										'</ul>'+
									'</li>'+
							'</ul>'+
						'</div>'+
						'<div class="body">'+
							'<div class="row clearfix">'+
								'<div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">'+
									'<div class="panel-group full-body" id="accordion_500" role="tablist" aria-multiselectable="true">';
										
										var response_tanya = response[i].LIST_PERTANYAAN;
										var list_pertanyaan = '';
										if(response[i].JML_SOAL != 0){
										
										  var lp; 
										  
										  for (lp = 0; lp < response_tanya.length; lp++) {
											var klas_collapsed = ""; 
											var expanded = "false";
											var ini = "";
											if(lp == 0){
												expanded = "true";
												ini = "in";
												klas_collapsed = "collapsed";
											}
											
											//console.log(expanded);
											  
											list_pertanyaan += 
												'<div class="panel panel-col-cyan">'+
													'<div class="panel-heading" role="tab" id="headingOn'+response_tanya[lp].ID_PERTANYAAN+'_500">'+
														'<h4 class="panel-title">'+
															'<a class="'+klas_collapsed+'" role="button"  data-toggle="collapse" data-parent="#accordion_500" href="#collapseOn'+response_tanya[lp].ID_PERTANYAAN+'_500" aria-expanded="'+expanded+'" aria-controls="collapseOn'+response_tanya[lp].ID_PERTANYAAN+'_500"><i class="material-icons">live_help</i> <span class="">'+response_tanya[lp].PERTANYAAN+'</span> </a>'+
														'</h4>'+
													'</div>'+
													
													'<div id="collapseOn'+response_tanya[lp].ID_PERTANYAAN+'_500" class="panel-collapse collapse '+ini+' " role="tabpanel" aria-labelledby="headingOn'+response_tanya[lp].ID_PERTANYAAN+'_500">'+
														
														'<div style="float: right;padding: 1em 1em 0 0;">'+
															'<button id="btnModal_editPertanyaan" dt_id_jp="'+response[i].ID_JP+'" dt_jp="'+response[i].JP.toUpperCase()+'" dt_id_p="'+response_tanya[lp].ID_PERTANYAAN+'" dt_p="'+response_tanya[lp].PERTANYAAN+'" type="button" title="Edit Pertanyaan" class="btn btn-success waves-effect">'+
																'<i class="material-icons">edit</i>'+
															'</button> &nbsp;'+
															'<button id="btnAct_hapusPertanyaan" dt_id_p="'+response_tanya[lp].ID_PERTANYAAN+'" dt_id_jp="'+response[i].ID_JP+'" dt_p="'+response_tanya[lp].PERTANYAAN+'" type="button" title="Hapus Pertanyaan" class="btn btn-danger waves-effect">'+
																'<i class="material-icons">delete</i>'+
															'</button>'+
														'</div>'+
														
														'<div class="panel-body" style="background-color: #fff; color: #2f3542;">'+
															'<button id="btnModal_tambahOJ" type="button" title="Tambah Opsional Jawaban" class="btn bg-cyan waves-effect" dt_id_p="'+response_tanya[lp].ID_PERTANYAAN+'" dt_p="'+response_tanya[lp].PERTANYAAN+'" dt_id_jp="'+response[i].ID_JP+'">'+ 
																'<i class="material-icons">add</i>'+
															'</button>'+
															'<b>&nbsp; &nbsp;Opsional Jawaban Atas Pertanyaan:</b>'+
															'<div class="table-responsive">'+
																'<table class="table table-striped table-bordered dataTable no-footer" id="daftar_opsi_jawaban" style="font-size: 12px;">'+
																	'<thead >'+
																		'<tr>'+
																			'<th bgcolor="#ffb990">No.</th>'+
																			'<th bgcolor="#ffb990">Jawaban</th>'+
																			'<th bgcolor="#ffb990">Point</th>'+
																			'<th bgcolor="#ffb990"><center>ACTION</center></th>'+
																		'</tr>'+
																	'</thead>'+
																	'<tbody id="show_opsi_jawaban_'+response_tanya[lp].ID_PERTANYAAN+'">';
																	
																		var response_opsi = response_tanya[lp].OPSI_JAWABAN;
																		var list_opsi = '';
																		if(response_tanya[lp].JML_OPSI != 0){
																		
																		  var lo;
																		  var no_opsi = 1;
																		  for (lo = 0; lo < response_opsi.length; lo++) {
																			
																			list_opsi += 
																				'<tr>'+
																					'<td width="4%"><center>'+no_opsi+'</center></td>'+
																					'<td>'+response_opsi[lo].OPSI+'</td>'+
																					'<td>'+response_opsi[lo].POINT+'</td>'+
																					'<td> <center>'+
																					'<a id="btnModal_editOJ" dt_id_oj="'+response_opsi[lo].ID_JAWABAN+'" dt_oj="'+response_opsi[lo].OPSI+'" dt_point="'+response_opsi[lo].POINT+'" dt_id_p="'+response_tanya[lp].ID_PERTANYAAN+'" dt_p="'+response_tanya[lp].PERTANYAAN+'" dt_id_jp="'+response[i].ID_JP+'" class="btn btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>'+
																					//'&nbsp; | &nbsp;'+
																					'<a id="btnAct_hapusOJ" dt_id_oj="'+response_opsi[lo].ID_JAWABAN+'" dt_oj="'+response_opsi[lo].OPSI+'" dt_point="'+response_opsi[lo].POINT+'" dt_id_p="'+response_tanya[lp].ID_PERTANYAAN+'" dt_p="'+response_tanya[lp].PERTANYAAN+'" class="btn btn-sm" style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i> Hapus</a>'+
																					'</center></td>'+
																				'</tr>';
																			
																			no_opsi++;
																		  }
																		} else {
																			list_opsi = 
																				'<tr>'+
																					'<td colspan="4"><center>Opsional jawaban tidak tersedia.</center></td>'+
																				'</tr>';
																		}
																		
											list_pertanyaan += list_opsi;
											
											list_pertanyaan +=
																	'</tbody>'+
																'</table>'+
															'</div>'+
														'</div>'+
														
													'</div>';
													
											list_pertanyaan +=
												'</div>';
											
										  }
										} else {
											list_pertanyaan = '<p style="padding-top: 1em; text-align: center; color: #2f3640;">Daftar Pertanyaan Tidak Tersedia pada Jenis Penilaian Ini.</p>';
										}
					
					list_dt_tanya += list_pertanyaan;
										
					list_dt_tanya +=		
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>';
				}
        	}
            $('#list_dt_pertanyaan').html(list_dt_tanya);
			//console.log(list_pertanyaan);
		}
	});	
}

// ----------------------------------------------------------------------->  OPSI JAWABAN

$(document).on("click", "#btnModal_tambahOJ", function(e){
	e.preventDefault();
	$('#form-in-oj').trigger("reset");
	
	var id_p = $(this).attr("dt_id_p"); 
	var p = $(this).attr("dt_p");
	var id_jp = $(this).attr("dt_id_jp");
	
	console.log(id_p);
	console.log(p);
	console.log(id_jp);
	
	$("#id_oj").val(0000);  
	$("#id_p").val(id_p);
	$("#id_jp").val(id_jp);
	
	$("#modal_act_opsiJawaban").modal('show'); 
	$('#labelNama').text('Opsi Jawaban : ');
	$('.modal-title').text('Tambah Opsional Jawaban ['+p+'] : ');
});

$(document).on("click", "#btnModal_editOJ", function(e){
	e.preventDefault();
	$('#form-in-oj').trigger("reset");
	
	var id_jp = $(this).attr("dt_id_jp"); 
	var id_p = $(this).attr("dt_id_p"); 
	var p = $(this).attr("dt_p");
	var id_oj = $(this).attr("dt_id_oj");
	var oj = $(this).attr("dt_oj");
	var point = $(this).attr("dt_point");
	
	$("#id_jp").val(id_jp);
	$("#id_p").val(id_p);
	$("#id_oj").val(id_oj); 
	$("#oj").val(oj);
	$("#point").val(point);
	
	$("#modal_act_opsiJawaban").modal('show'); 
	$('#labelNama').text('Opsi Jawaban : ');
	$('.modal-title').text('Edit Opsional Jawaban ['+p+'] : ');
});

$(document).on("click", "#BtnSimpanOJ", function(e){
	e.preventDefault();
	
	var id_jp	= $("#id_jp").val();
	var id_p	= $("#id_p").val();
	var id_oj 	= $("#id_oj").val();
	var oj		= $("#oj").val();
	var point	= $("#point").val();
	
	if(oj != "" && oj != null && oj != '' && point != "" && point != null && point != ''){
		$.ajax({
			url: '<?php echo site_url(); ?>sales/SurveySales/simpanOJ',
			type: 'POST',
			data: {
				"id_oj" : id_oj,
				"id_p"  : id_p,
				"oj"	: oj,
				"point" : point
			}, 
			success: function(data){
				$("#modal_act_opsiJawaban").modal('hide');
				alert("Data Opsional Jawaban Berhasil Disimpan.");
				do_list_opsi_jawaban_set(id_p); 
			},
			error: function(){
				alert("Data Opsional Jawaban Gagal Disimpan.");
			}
		});
	} else {
		alert("Kolom isian tidak boleh kosong.");
	}
});

$(document).on("click", "#btnAct_hapusOJ", function(e){
	e.preventDefault();
	
	var id_p = $(this).attr("dt_id_p"); 
	var p = $(this).attr("dt_p");
	var id_oj = $(this).attr("dt_id_oj");
	var oj = $(this).attr("dt_oj");
	var point = $(this).attr("dt_point");
	
	if (confirm("Apakah Anda Yakin Ingin Menghapus Opsional Jawaban ["+oj+" - ("+point+")], dari Pertanyaan {"+p+"} ?")) {
		$.ajax({
			url: '<?php echo site_url(); ?>sales/SurveySales/hapusOJ',
			type: 'POST',
			data: {
				"id_oj" : id_oj
			},
			success: function(data){
				do_list_opsi_jawaban_set(id_p);
				alert("Data Opsional Jawaban Berhasil Dihapus.");
			},
			error: function(){
				alert("Data Opsional Jawaban Gagal Dihapus.");
			}
		});
		return true;
    }
	
});

function do_list_opsi_jawaban_set(id_p){
	$("#show_opsi_jawaban_"+id_p).html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	
	$.ajax({
		url: '<?php echo site_url(); ?>sales/SurveySales/list_opsional_jawaban',
		type: 'POST',
		dataType: 'JSON',
		data: {
			"id_p"  : id_p
		}, 
		success: function(datas){
			var response_opsi = datas;
 			if(response_opsi.length != 0){
				
				var show_opsi_jawaban = '';
				var no_opsi = 1;
				for (var lo = 0; lo < response_opsi.length; lo++) {
					
					show_opsi_jawaban +=
					'<tr>'+
						'<td width="4%"><center>'+no_opsi+'</center></td>'+
							'<td>'+response_opsi[lo].OPSI+'</td>'+
							'<td>'+response_opsi[lo].POINT+'</td>'+
							'<td> <center>'+
								'<a id="btnModal_editOJ" dt_id_oj="'+response_opsi[lo].ID_JAWABAN+'" dt_oj="'+response_opsi[lo].OPSI+'" dt_point="'+response_opsi[lo].POINT+'" dt_id_p="'+response_opsi[lo].ID_PERTANYAAN+'" dt_p="'+response_opsi[lo].PERTANYAAN+'"  class="btn btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>'+
								//'&nbsp; | &nbsp;'+
								'<a id="btnAct_hapusOJ" dt_id_oj="'+response_opsi[lo].ID_JAWABAN+'" dt_oj="'+response_opsi[lo].OPSI+'" dt_point="'+response_opsi[lo].POINT+'" dt_id_p="'+response_opsi[lo].ID_PERTANYAAN+'" dt_p="'+response_opsi[lo].PERTANYAAN+'" class="btn btn-sm" style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i> Hapus</a>'+
							'</center></td>'+
					'</tr>';
					no_opsi++;
				}	
				
			} else {
				show_opsi_jawaban = 
				'<tr>'+
					'<td colspan="4"><center>Opsional jawaban tidak tersedia.</center></td>'+
				'</tr>';
			}
        	
            $('#show_opsi_jawaban_'+id_p).html(show_opsi_jawaban);
		}
	});
}

</script>
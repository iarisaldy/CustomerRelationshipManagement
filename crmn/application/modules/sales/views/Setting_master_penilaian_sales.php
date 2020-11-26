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
				<div class="card" style="padding-bottom: 0;">
				
					<div class="header bg-purple">
						<h2 style="padding-top: 0.2em;">MASTER PENILAIAN SALES</h2>
					</div>
						
					<div class="body">
						<div class="row">
							
							<div class="col-md-3" >
								<div class="card" style="padding-bottom: 0;">
									<div class="header bg-red">
										<h2 style="padding-top: 0.2em;">JENIS PENILAIAN</h2>
										<ul class="header-dropdown m-r--5">
											<li class="dropdown">
												<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Tambah Jenis Penilaian">
													<i class="material-icons">library_add</i>
												</a>
												<ul class="dropdown-menu pull-right">
													<li><a href="javascript:void(0);" id="btnModal_tambahJP">Tambah Jenis Penilaian</a></li>
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
		</div>
    </div>
</section>

<!--1 modal tambah dan edit jenis penilaian -->
<div class="modal fade" id="modal_act_jp" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: rgba(112, 161, 255,1.0); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: #000;">  </h2>
			</div>
			<form id="form-in-jp">
			<div class="modal-body form" >
				<div class="form-body">
					<input type="hidden" id="id_jp" name="id_jp">
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label id="labelNama" for="name">Jenis Penilaian : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="jp" class="form-control" name="jp" placeholder="Masukkan Jenis Penilaian " required>
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
							<label id="labelNama" for="name">Pertanyaan : </label>
						</div>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="p" class="form-control" name="p" placeholder="Masukkan Pertanyaan " required>
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

<script>

$(document).ready(function() {
	do_list_jp();
    do_list_pertanyaan(null);
});

// -------------------------------------------------------------- > JENIS PERTANYAAN

$(document).on("click", "#btnAct_List_jp", function(e){
	e.preventDefault();
	var id_jp = $(this).attr("dt_id_jp");
	do_list_pertanyaan(id_jp);
});

$(document).on("click", "#btnModal_tambahJP", function(e){
	e.preventDefault();
	$('#form-in-jp').trigger("reset");
	$("#id_jp").val(0000);
	$("#modal_act_jp").modal('show');
	$('#labelNama').text('Jenis Penilaian : ');
	$('.modal-title').text('Tambah Jenis Penilaian : ');
});

$(document).on("click", "#btnModal_editJP", function(e){
	e.preventDefault();
	
	var id_jp = $(this).attr("dt_id_jp");
	var jp = $(this).attr("dt_jp");
	
	$("#id_jp").val(id_jp);
	$("#jp").val(jp);
	
	$("#modal_act_jp").modal('show');
	$('#labelNama').text('Jenis Penilaian : ');
	$('.modal-title').text('Edit Jenis Penilaian : ');
});

$(document).on("click", "#BtnSimpanJP", function(e){
	e.preventDefault();
	
	var id_jp 	= $("#id_jp").val();
	var jp		= $("#jp").val();
	
	if(jp != "" && jp != null && jp != ''){
		$.ajax({
			url: '<?php echo site_url(); ?>sales/SurveySales/simpanJenisPenilaian',
			type: 'POST',
			data: {
				"id_jp" : id_jp,
				"jp" : jp
			}, 
			success: function(data){
				$("#modal_act_jp").modal('hide');
				alert("Data Jenis Penilaian Berhasil Disimpan.");
				do_list_jp(); 
			},
			error: function(){
				alert("Data Jenis Penilaian Gagal Disimpan.");
			}
		});
	} else {
		alert("Kolom jenis penilaian tidak boleh kosong.");
	}
});

$(document).on("click", "#btnAct_hapusJP", function(e){
	e.preventDefault();
	var id_jp = $(this).attr("dt_id_jp");
	var jp = $(this).attr("dt_jp");
	if (confirm("Apakah Anda Yakin Ingin Menghapus Jenis Penilaian ["+id_jp+" - "+jp+"] ?")) {
		$.ajax({
			url: '<?php echo site_url(); ?>sales/SurveySales/hapusJenisPenilaian',
			type: 'POST',
			data: {
				"id_jp" : id_jp
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
	
	var get_link_akses = '<?php echo site_url(); ?>sales/SurveySales/list_jp_full_pertanyaan';
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
	
	var get_link_akses = '<?php echo site_url(); ?>sales/SurveySales/list_jp_full_pertanyaan';
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
											'<li id="btnModal_editJP" dt_id_jp="'+response[i].ID_JP+'" dt_jp="'+response[i].JP+'"><a href="javascript:void(0);"><i class="fa fa-pencil-square-o" style="color: #000;" aria-hidden="true"></i> Edit Jenis Penilaian</a></li>'+
											'<li id="btnAct_hapusJP" dt_id_jp="'+response[i].ID_JP+'" dt_jp="'+response[i].JP.toUpperCase()+'"><a href="javascript:void(0);"><i class="fa fa-trash" style="color: #000;" aria-hidden="true"></i> Hapus Jenis Penilaian</a></li>'+						
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
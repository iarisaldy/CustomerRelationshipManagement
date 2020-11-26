<?php 

	$id_user = $this->session->userdata("user_id");
	$id_jenis_user = $this->session->userdata("id_jenis_user");

	// print_r($disabled);exit;
    
     if($this->session->userdata('status_act') != NULL){ ?>
      <div class="alert alert-success" role="alert" style="position: fixed; top: 72px; right:4%; width: 45%; vertical-align: middle; border-radius: 0.3em;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>INFO!</strong> <?= $this->session->userdata('status_act');?>
      </div>
      <script type="text/javascript">
        $(document).ready (function(){
          window.setTimeout(function() {
              $(".alert").fadeTo(500, 0).slideUp(500, function(){
                  $(this).remove(); 
              });
          }, 6000);
        });
      </script>
      <?php 
        $this->session->set_userdata('status_act', null);
} ?>

<style type="text/css">
		.bootstrap-notify-container {
			z-index : 1050 !important;
		}
	</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
				<div class="card">
					<div class="header header-title">
						<h2>Setting Target KPI Salesman</h2>
					</div>
					<div class="body" style="margin: 0 1em 0 1em;">
                        <div class="row">
                        	<?php if ($id_jenis_user == '1012') { ?>
							<button id="btn_add" onclick="tambah();" class="btn btn-success" style="margin-bottom: 1em; margin-top: 0.5em 0 0.5em 0;"><i class="glyphicon glyphicon-plus"></i> Setting Target KPI</button>
							<?php } ?>
							<table id="tabel" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th style="width: 1%;">No.</th>
										<th></th>
										<th></th>
										<th>Salesman</th>
										<th>Toko Unit</th>
										<th>Visit</th>
										<th>Toko Aktif</th>
										<th>Toko Baru</th>
										<th>Volume Sell out (Sidigi)</th>
										<th>Volume Sell out (BK)</th>
										<th>Created By</th>
										<th>Tahun</th>
										<th>Updated By</th>
										<th>Bulan</th>
                        				<?php if ($id_jenis_user == '1012') { ?>
										<th style="width: 10%;">Aksi</th>
										<?php } ?>
									</tr>
								</thead>
							</table>
							
						</div>
					</div>
				</div>
				
			</div>
        </div>
    </div>
</section>

<div class="modal fade" id="dlg" role="dialog" >
    <div class="modal-dialog" style="width: 750px;">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: #8c7ae6; padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 id="judul_input" class="modal-title">Form</h2>
			</div>
			<form id="form" class="form-horizontal" action="/" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<input type="hidden" id="id_tso" name="id_tso">
					<input type="hidden" id="thn" name="thn">
					<input type="hidden" id="bln" name="bln">
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Salesman : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
									<select class='form-control selectpicker form-control-sm' data-live-search='true' data-size="10" id='sales'>
										<option value='' data-hidden='true' selected='selected'>-- Pilih Salesman --</option>
									</select>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Tahun : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
									<select class='form-control selectpicker form-control-sm' data-live-search='false' data-size="10" id='tahun'>
										<option value='' data-hidden='true' selected='selected'>-- Pilih Tahun --</option>
									</select>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Bulan : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
									<select class='form-control selectpicker form-control-sm' data-live-search='false' data-size="10" id='bulan'>
										<option value='' data-hidden='true' selected='selected'>-- Pilih Bulan --</option>
									</select>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Toko Unit : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
									<input type="number" id="tu" class="form-control" name="tu" placeholder="Masukkan Toko Unit" style="padding-left: 30px;" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<!--<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Visit : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="visit" class="form-control" name="visit" placeholder="Masukkan Visit" required>
                                </div>
                            </div>
                        </div>
                    </div>-->
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Toko Aktif : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="ta" class="form-control" name="ta" placeholder="Masukkan Toko Aktif" style="padding-left: 30px;" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Toko Baru : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="tb" class="form-control" name="tb" placeholder="Masukkan Toko Baru" style="padding-left: 30px;" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Volume Sell Out (Sidigi) : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="vso" class="form-control" name="vso" placeholder="Masukkan VSO Sidigi" style="padding-left: 30px;" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Volume Sell Out (BK) : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="vso_bk" class="form-control" name="vso_bk" placeholder="Masukkan VSO BK" style="padding-left: 30px;" required>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="modal-footer">
				<span id="create_at" style="float: left; padding: 0.5em 0 0 0.5em"> </span>
				<button type="button" class="btn btn-primary btn-simpan" onclick='simpan();' id='input_simpan'>Simpan</button>
				<button type="button" class="btn btn-success btn-edit" onclick='update();' id='input_update'>Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
			</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="dlg_hapus" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: #8c7ae6; padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title">Hapus  </h2>
			</div>
			<input type="hidden" id="id_hapus" name="id_hapus">
			<div class="modal-body form">
				<div class="form-body">
					<p id='dihapus'></p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id='input_hapus' onclick ="hapus();" class="btn btn-primary btn-hapus">Ya</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo site_url(); ?>/assets/js/plugins/bootstrap-notify/bootstrap-notify.js"></script>
<script>
	var TabelData;
	var jns_user = <?php echo $id_jenis_user; ?>;
	$(document).ready(function() {
		// refreshSO();
		if (jns_user == '1012') {
			TabelData = $("#tabel").DataTable({
				"processing": true,
				"serverSide": true,
				"recordsTotal": 20,
				"recordsFiltered": 20,
				"serverSide": true,
				"ajax": {
					"url": "<?php echo site_url(); ?>master/Target_selling_out/get_data_salesman",
					"type": "POST"
				},
				"drawCallback": function(settings) {
					if(settings.aiDisplay.length > 0) {
						$(".btn-tooltip").tooltip({"trigger": "hover"});
					}
				},
				"order": [[0, "desc"]],
				"columnDefs": [
					{"targets": 14, "orderable": false},
					{"targets": 1, "visible": false},
					{"targets": 2, "visible": false},
					{"targets": 10, "visible": false},
					// {"targets": 11, "visible": false},
					{"targets": 12, "visible": false},
					// {"targets": 14, "visible": false}
				]
				// "dom": "<'row'<'col-sm-2'<l>><'col-sm-4'<'#tombol'>><'col-sm-6'f>><'row'<'col-sm-12'<'table-responsive't>r>><'row'<'col-sm-5'i><'col-sm-7'p>>"
			});
		} else {
			TabelData = $("#tabel").DataTable({
				"processing": true,
				"serverSide": true,
				"recordsTotal": 20,
				"recordsFiltered": 20,
				"serverSide": true,
				"ajax": {
					"url": "<?php echo site_url(); ?>master/Target_selling_out/get_data_salesman",
					"type": "POST"
				},
				"drawCallback": function(settings) {
					if(settings.aiDisplay.length > 0) {
						$(".btn-tooltip").tooltip({"trigger": "hover"});
					}
				},
				"order": [[0, "desc"]],
				"columnDefs": [
					{"targets": 14, "orderable": false},
					{"targets": 1, "visible": false},
					{"targets": 2, "visible": false},
					{"targets": 10, "visible": false},
					// {"targets": 11, "visible": false},
					{"targets": 12, "visible": false},
					{"targets": 14, "visible": false}
				]
				// "dom": "<'row'<'col-sm-2'<l>><'col-sm-4'<'#tombol'>><'col-sm-6'f>><'row'<'col-sm-12'<'table-responsive't>r>><'row'<'col-sm-5'i><'col-sm-7'p>>"
			});
		}
		
		// $("#tombol").html("<button type='button' class='btn btn-success btn_tambah' style='text-align:right;' onclick='tambah();'><span class='fa fa-plus'></span>&nbsp;Add</button>");
	});
	
	function tambah() {
		refreshSales();
		refreshTahun();
		refreshBulan();
		$("#tu, #ta, #tb, #vso, #vso_bk, #sales").val("");
		$(".btn-simpan").show();
		$(".btn-edit").hide(); 
		$("#judul_input").html("<b><i class='fa fa-pencil-alt'></i>&nbsp;Form Add</b>"); 
		$("#dlg").modal("show");
	}
	
	function edit(baris) {
		var kolom = TabelData.row(baris).data();    
		$("#id_tso, #tahun, #bulan, #tu, #ta, #tb, #vso, #vso_bk, #sales").val("");
		$("#id_tso").val(kolom[2]);
		$("#thn").val(kolom[11]);
		$("#bln").val(kolom[13]);
		refreshSales(kolom[2]);
		refreshTahun(kolom[11]);
		refreshBulan(kolom[13]);
		// $("#so option[value='"+kolom[2]+"']").attr("selected","selected");
		$("#tu").val(kolom[4]);
		// $("#visit").val(kolom[5]);
		$("#ta").val(kolom[6]);
		$("#tb").val(kolom[7]);
		$("#vso").val(kolom[8]);
		$("#vso_bk").val(kolom[9]);
		$(".btn-simpan").hide();
		$(".btn-edit").show(); 
		$("#judul_input").html("<b><i class='fa fa-pencil-alt'></i>&nbsp;Form Update</b>"); 
		$("#dlg").modal("show");
	}
	
    function simpan() {
		var sales = $("#sales").val();
		var tahun = $("#tahun").val();
		var bulan = $("#bulan").val();
		var tu = $("#tu").val();
		// var visit = $("#visit").val();
		var ta = $("#ta").val();
		var tb = $("#tb").val();
		var vso = $("#vso").val();
		var vso_bk = $("#vso_bk").val();
		if (sales == "" || tu == "" || ta == "" || tb == "" || vso == "" || vso_bk == "") {
            show_toaster(3, "Form cannot be empty") 
            return;
        }
        $('#input_simpan, .btn-tutup').attr('disabled', true);
        $('#input_simpan').html('<i class="fa fa-spinner fa-spin" ></i> Processing');
        $.post("<?php echo site_url(); ?>master/Target_selling_out/simpan_salesman", { 
            "sales": sales,
            "tahun": tahun,
            "bulan": bulan,
            "tu": tu,
            // "visit": visit,
            "ta": ta,
            "tb": tb,
            "vso": vso,
            "vso_bk": vso_bk
        }, function (datas) {
            var data = JSON.parse(datas);
            if (data.notif == "1") {
                $("#dlg").modal("hide");
                show_toaster(data.notif, data.message);
				TabelData.draw();
            } else { 
                show_toaster(data.notif, data.message);
            }
        }).fail(function () {
				show_toaster(2, "Error Server.");
        }).always(function () {
            $('#input_simpan').html("<i class='fa fa-save'></i>&nbsp;Simpan"); 
            $('#input_simpan, .btn-tutup').attr('disabled', false);
        });
    }
	
    function update() {
		var id_tso = $("#id_tso").val();
		var thn = $("#thn").val();
		var bln = $("#bln").val();
		var sales = $("#sales").val();
		var tahun = $("#tahun").val();
		var bulan = $("#bulan").val();
		var tu = $("#tu").val();
		// var visit = $("#visit").val();
		var ta = $("#ta").val();
		var tb = $("#tb").val();
		var vso = $("#vso").val();
		var vso_bk = $("#vso_bk").val();
		if (sales == "" || tu == "" || ta == "" || tb == "" || vso == "" || vso_bk == "" || id_tso == "") {
            show_toaster(3, "Form cannot be empty"); 
            return;
        }
        $('#input_update, .btn-tutup').attr('disabled', true);
        $('#input_update').html('<i class="fa fa-spinner fa-spin" ></i> Processing');
        $.post("<?php echo site_url(); ?>master/Target_selling_out/update_salesman", {
            "id": id_tso,
            "thn": thn,
            "bln": bln,
            "sales": sales,
            "tahun": tahun,
            "bulan": bulan,
            "tu": tu,
            // "visit": visit,
            "ta": ta,
            "tb": tb,
            "vso": vso,
            "vso_bk": vso_bk
        }, function (datas) {
            var data = JSON.parse(datas);
            if (data.notif == "1") {
                $("#dlg").modal("hide");
				show_toaster(data.notif, data.message);
				TabelData.draw(false);
            } else {
                show_toaster(data.notif, data.message);
            }
        }).fail(function () {
                show_toaster(2, "Server Error.");
        }).always(function () {
            $('#input_update').html("<i class='fa fa-save'></i>&nbsp;Update"); 
            $('#input_update, .btn-tutup').attr('disabled', false);
        });
    }
	
	function konfirmasi(baris) { 
		var kolom = TabelData.row(baris).data();     
		$("#id_hapus").val(kolom[2]);
		// $("#judul_hapus").html("<b><i class='fa fa-pencil-alt'></i>&nbsp;Delete</b>");
		$("#dihapus").html("Anda yakin ingin menghapus Target Sales dengan Kode " + kolom[2] + " ?" );
		$("#dlg_hapus").modal("show"); 
	}
	
    function hapus() {
        var id = $("#id_hapus").val();
		$('.btn-hapus, .btn-tutup').attr('disabled', true);
        $.post("<?php echo base_url(); ?>master/Target_selling_out/hapus_salesman", {"id": id}, function (datas) {
            var data = JSON.parse(datas);
            if (data.notif == "1") {
                show_toaster(data.notif, data.message);
                TabelData.draw(false);
                $("#dlg_hapus").modal("hide"); 
            } else {
               show_toaster(data.notif, data.message);
            }
        }).fail(function () {
            show_toaster(2, "Server Error.");
        }).always(function () {
            $('.btn-hapus, .btn-tutup').attr('disabled', false);
        });
    }

	function refreshSales(id='') {
		$.post("<?php echo site_url(); ?>master/Target_selling_out/refreshSalesman", function(data) {
			$("#sales").html(data);
		}).fail(function() {
			// Nope
		}).always(function() {
			$("#sales").val(id);
			$(".selectpicker").selectpicker("refresh");
		});
	}

	function refreshTahun(id='') {
		$.post("<?php echo site_url(); ?>master/Target_selling_out/refreshTahun", function(data) {
			$("#tahun").html(data);
		}).fail(function() {
			// Nope
		}).always(function() {
			$("#tahun").val(id);
			$(".selectpicker").selectpicker("refresh");
		});
	}

	function refreshBulan(id='') {
		$.post("<?php echo site_url(); ?>master/Target_selling_out/refreshBulan", function(data) {
			$("#bulan").html(data);
		}).fail(function() {
			// Nope
		}).always(function() {
			$("#bulan").val(id);
			$(".selectpicker").selectpicker("refresh");
		});
	}
function show_toaster(colorName, text) {
	if (colorName == 1) { colorName = 'bg-green'; }
	else if (colorName == 2) { colorName = 'bg-red'; }
	else if (colorName == 3) { colorName = 'bg-orange'; }
	else { colorName = 'bg-black'; }
    if (text === null || text === '') { text = 'Error'; }
    var allowDismiss = true;

    $.notify({
        message: text
    },
        {
            type: colorName,
            allow_dismiss: allowDismiss,
            newest_on_top: true,
            timer: 300,
            placement: {
                from: "top",
                align: "right"
            },
            animate: {
                enter: "animated zoomInRight",
                exit: "animated zoomOutRight"
            },
            template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
}
	
</script>
<?php 
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
						<h2>Target Selling Out</h2>
					</div>
					<div class="body" style="margin: 0 1em 0 1em;">
                        <div class="row">
							<button id="btn_add" onclick="tambah();" class="btn btn-success" style="margin-bottom: 1em; margin-top: 0.5em 0 0.5em 0;"><i class="glyphicon glyphicon-plus"></i> Tambah Target Selling Out</button>
							<table id="tabel" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th style="width: 1%;">No.</th>
										<th></th>
										<th></th>
										<th>Sales Officer</th>
										<th>Volume</th>
										<th>Revenue</th>
										<th>CA</th>
										<th>Visit</th>
										<th>NOO</th>
										<th>Market Share</th>
										<th>Created By</th>
										<th>Created At</th>
										<th>Updated By</th>
										<th>Last Updated</th>
										<th style="width: 10%;">Aksi</th>
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
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: #8c7ae6; padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 id="judul_input" class="modal-title">Form</h2>
			</div>
			<form id="form" class="form-horizontal" action="/" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<input type="hidden" id="id_tso" name="id_tso">
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Sales Officer : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
									<select class='form-control selectpicker form-control-sm' data-live-search='false' data-size="10" id='so'>
										<option value='' data-hidden='true' selected='selected'>-- Pilih Sales Officer --</option>
									</select>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Volume : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
									<input type="number" id="volume" class="form-control" name="volume" placeholder="Masukkan Volume" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Revenue : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="revenue" class="form-control" name="revenue" placeholder="Masukkan Revenue" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">CA : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="ca" class="form-control" name="ca" placeholder="Masukkan CA" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- <div class="row clearfix">
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
                            <label for="Radius Lock">NOO : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="noo" class="form-control" name="noo" placeholder="Masukkan NOO" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Market Share : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="market_share" class="form-control" name="market_share" placeholder="Masukkan Market Share" required>
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
<script src="../assets/js/plugins/bootstrap-notify/bootstrap-notify.js"></script>
<script>
	var TabelData;
	$(document).ready(function() {
		// refreshSO();
		TabelData = $("#tabel").DataTable({
			"processing": true,
			"serverSide": true,
			"recordsTotal": 20,
			"recordsFiltered": 20,
			"serverSide": true,
			"ajax": {
				"url": "<?php echo site_url(); ?>master/Target_selling_out/get_data",
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
				// {"targets": 13, "visible": false}
			]
			// "dom": "<'row'<'col-sm-2'<l>><'col-sm-4'<'#tombol'>><'col-sm-6'f>><'row'<'col-sm-12'<'table-responsive't>r>><'row'<'col-sm-5'i><'col-sm-7'p>>"
		});
		
		// $("#tombol").html("<button type='button' class='btn btn-success btn_tambah' style='text-align:right;' onclick='tambah();'><span class='fa fa-plus'></span>&nbsp;Add</button>");
	});
	
	function tambah() {
		refreshSO();
		$("#volume, #revenue, #ca, #noo, #market_share, #so").val("");
		$(".btn-simpan").show();
		$(".btn-edit").hide(); 
		$("#judul_input").html("<b><i class='fa fa-pencil-alt'></i>&nbsp;Form Add</b>"); 
		$("#dlg").modal("show");
	}
	
	function edit(baris) {
		var kolom = TabelData.row(baris).data();    
		$("#id_tso, #revenue, #ca, #noo, #market_share, #so").val("");
		$("#id_tso").val(kolom[1]);
		refreshSO(kolom[2]);
		// $("#so option[value='"+kolom[2]+"']").attr("selected","selected");
		$("#volume").val(kolom[4]);
		$("#revenue").val(kolom[5]);
		$("#ca").val(kolom[6]);
		// $("#visit").val(kolom[7]);
		$("#noo").val(kolom[8]);
		$("#market_share").val(kolom[9]);
		$(".btn-simpan").hide();
		$(".btn-edit").show(); 
		$("#judul_input").html("<b><i class='fa fa-pencil-alt'></i>&nbsp;Form Update</b>"); 
		$("#dlg").modal("show");
	}
	
    function simpan() {
		var so = $("#so").val();
		var volume = $("#volume").val();
		var revenue = $("#revenue").val();
		var ca = $("#ca").val();
		// var visit = $("#visit").val();
		var noo = $("#noo").val();
		var market_share = $("#market_share").val();
		if (so == "" || volume == "" || revenue == "" || ca == "" || noo == "" || market_share == "") {
            show_toaster(3, "Form cannot be empty") 
            return;
        }
        $('#input_simpan, .btn-tutup').attr('disabled', true);
        $('#input_simpan').html('<i class="fa fa-spinner fa-spin" ></i> Processing');
        $.post("<?php echo site_url(); ?>master/Target_selling_out/simpan", { 
            "so": so,
            "volume": volume,
            "revenue": revenue,
            "ca": ca,
            // "visit": visit,
            "noo": noo,
            "market_share": market_share
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
		var so = $("#so").val();
		var volume = $("#volume").val();
		var revenue = $("#revenue").val();
		var ca = $("#ca").val();
		// var visit = $("#visit").val();
		var noo = $("#noo").val();
		var market_share = $("#market_share").val();
		if (so == "" || volume == "" || revenue == "" || ca == "" || noo == "" || market_share == "" || id_tso == "") {
            show_toaster(3, "Form cannot be empty"); 
            return;
        }
        $('#input_update, .btn-tutup').attr('disabled', true);
        $('#input_update').html('<i class="fa fa-spinner fa-spin" ></i> Processing');
        $.post("<?php echo site_url(); ?>master/Target_selling_out/update", {
            "id": id_tso,
            "so": so,
            "volume": volume,
            "revenue": revenue,
            "ca": ca,
            // "visit": visit,
            "noo": noo,
            "market_share": market_share
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
		$("#id_hapus").val(kolom[1]);
		// $("#judul_hapus").html("<b><i class='fa fa-pencil-alt'></i>&nbsp;Delete</b>");
		$("#dihapus").html("Anda yakin ingin menghapus Target Selling Out baris " + kolom[0] + " ?" );
		$("#dlg_hapus").modal("show"); 
	}
	
    function hapus() {
        var id = $("#id_hapus").val();
		$('.btn-hapus, .btn-tutup').attr('disabled', true);
        $.post("<?php echo base_url(); ?>master/Target_selling_out/hapus", {"id": id}, function (datas) {
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

	function refreshSO(id='') {
		$.post("<?php echo site_url(); ?>master/Target_selling_out/refreshSO", function(data) {
			$("#so").html(data);
		}).fail(function() {
			// Nope
		}).always(function() {
			$("#so").val(id);
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
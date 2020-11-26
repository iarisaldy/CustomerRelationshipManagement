
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2 style="padding-top: 0.2em;">Action Log</h2>
						
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid"> 
								
								<div class="body" >
									<div class="row">  	 								
										<div class="col-sm-12"> 
											<table id="tabel" class="table table-striped table-bordered" style="width:100%;">
												<thead>
													<tr>
														<th>No</th>
														<th>Topik</th>
														<th style="width:120px;">Isu</th>
														<th>Solusi</th>
														<th>Tanggal Buat</th>
														<th>Dateline</th>
														<th>Progress</th>
														<th>Status</th>
														<th style="width:120px;">Aksi</th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>  
										</div> 	
									</div>  
								</div>
								
						
                               
							
                              
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>
<div class="modal" id='dlg'  tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style='background-color: rgba(112, 161, 255,1.0); padding-bottom:1.5em;'>

			<div class='modal-title' style='font-size: 16px;   font-weight: bold;' id='judul_input'></div> 
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body"> 
				<div class="form-group row">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
						<label id="labelNama1" for="name">Topik : </label>
					</div>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="form-line">
								<select class="form-control selectpicker" data-live-search="true" data-size="10" id="topik">
										<option value="" data-hidden="true">-- Pilih Topik --</option>
										<option value="1" >Penjualan</option>
										<option value="2" >Stok </option>
										<option value="3" >Program </option>
										<option value="4" >Komplain </option>
										<option value="5" >Administrasi </option>	
										 
									</select>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
						<label id="labelNama1" for="name">Isu : </label>
					</div>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
						<div class="form-group">
						
							<textarea  id="isu" rows="5" cols="50%"   ></textarea> 
							<input type="hidden" class="form-control form-control-sm" id="id_action" > 
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
						<label id="labelNama1" for="name">Rencana Solusi : </label>
					</div>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
						<div class="form-group">
							<textarea  id="solusi" rows="5" cols="50%"   ></textarea>  
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
						<label id="labelNama1" for="name">Dateline : </label>
					</div>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="form-line">
								<input type="text" class="form-control form-control-sm" id="dateline" >
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
						<label id="labelNama1" for="name">Progress: </label>
					</div>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
						<div class="form-group">
							<textarea  id="progress" rows="5" cols="50%"   ></textarea>   
						</div>
					</div>
					<div id='status_form'>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label id="labelNama1" for="name">Status: </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<select class="form-control selectpicker" data-live-search="true" data-size="10" id="status">
										<option value="" data-hidden="true">-- Pilih Status --</option>
										<option value="1" >Open</option>
										<option value="2" >On Progress </option>
										<option value="3" >Done </option>
										 
									</select>
								</div>
							</div>
						</div>
					</div>
				 
				</div>
			</div>

			<div class='modal-footer'>
				<button type='button' class='btn btn-success  btn-simpan' onclick='simpan();' id='input_simpan'><i class='fa fa-save'></i>&nbsp;Simpan</button>
				<button type='button' class='btn btn-primary  btn-edit' onclick='update();' id='input_update'><i class='fa fa-save'></i>&nbsp;Update</button>
				<button type='button' class='btn btn-secondary  btn-tutup' data-dismiss='modal'><i class='fa fa-times'></i>&nbsp;Tutup</button>
			</div>
		</div>
	</div>
</div>


<div class="modal" id='dlg_hapus'  tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style='background-color: rgba(112, 161, 255,1.0); padding-bottom:1.5em;'> 
        <div class='modal-title' style='    font-size: 16px;   font-weight: bold;' id='judul_hapus'></div> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
            <input type='hidden' id='id_hapus'>
            <p id='dihapus'></p>
      </div>
     
        <div class='modal-footer'>
            <button type='button' class='btn btn-danger btn-hapus' onclick='hapus();' id='input_hapus'><i class='fa fa-trash'></i>&nbsp;Hapus</button> 
            <button type='button' class='btn btn-secondary btn-tutup' data-dismiss='modal'><i class='fa fa-times'></i>&nbsp;Tutup</button>
        </div>
    </div>
  </div>
</div>

<div class="modal" id='dlg_approve'  tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style='background-color: rgba(112, 161, 255,1.0); padding-bottom:1.5em;'> 
        <div class='modal-title' style='    font-size: 16px;   font-weight: bold;' id='judul_approve'></div> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
            <input type='hidden' id='id_approve'>
            <p id='diapprove'></p>
      </div>
     
        <div class='modal-footer'>
            <button type='button' class='btn btn-info btn-approve' onclick='action_approve();' id='input_approve'><i class='fa fa-thumbs-up'></i>&nbsp;Approve</button> 
            <button type='button' class='btn btn-danger btn-reject' onclick='action_reject();' id='input_reject'><i class='fa fa-thumbs-down'></i>&nbsp;Reject</button> 
            <button type='button' class='btn btn-secondary btn-tutup' data-dismiss='modal'><i class='fa fa-times'></i>&nbsp;Tutup</button>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	var TabelData;
	$(document).ready(function() {
		TabelData = $("#tabel").DataTable({
			"processing": true,
			"serverSide": true, 
			"ajax": {
				"url": "<?php echo base_url(); ?>actionlog/action_log/get_data",
				"type": "POST"
			},
			"drawCallback": function(settings) {
				if(settings.aiDisplay.length > 0) {
					$(".btn-tooltip").tooltip({"trigger": "hover"});
				}
			},
			"order": [[0, "asc"]],
			"columnDefs": [
				{"targets": 8, "orderable": false},
				{"targets": 9, "visible": false}
			],
			"dom": "<'row'<'col-sm-2'<l>><'col-sm-4'<'#tombol'>><'col-sm-6'f>><'row'<'col-sm-12'<'table-responsive't>r>><'row'<'col-sm-5'i><'col-sm-7'p>>"
		});
		
		$("#tombol").html("<button type='button' class='btn btn-info btn_tambah' style='text-align:right;' onclick='tambah();'><span class='fa fa-plus'></span>&nbsp;Add</button>&nbsp;<button type='button' class='btn btn-success' style='text-align:right;' onclick='load_export();'><span class='fa  fa-file-excel-o'></span>&nbsp;Export</button>");
		
		if(<?php echo $_SESSION['id_jenis_user'] ?> == '1016' || <?php echo $_SESSION['id_jenis_user'] ?> == '1010' ){
			$(".btn_tambah").hide();
		}
	});
	
	function tambah() {
		$("#status_form").hide();
		$("#id_action, #topik,#isu, #solusi, #dateline, #progress, #status").val("");
		$(".selectpicker").selectpicker("refresh");
		$(".btn-simpan").show();
		$(".btn-edit").hide(); 
		$("#judul_input").html("<b><i class='fa fa-pencil-alt'></i>&nbsp;Form Add</b>"); 
		$("#dlg").modal("show");
	}
	
	function edit(baris) {
		var kolom = TabelData.row(baris).data();  
		$("#status_form").show();  
		$("#id_action, #topik,#isu, #solusi, #dateline, #progress, #status").val(""); 
		$("#topik").val(kolom[9][2]); 
		$("#isu").val(kolom[2]); 
		$("#solusi").val(kolom[3]);  
		$("#dateline").val(kolom[5]);
		$("#progress").val(kolom[6]);  
		$("#id_action").val(kolom[9][0]); 
		$("#status").val(kolom[9][1]);
		$(".selectpicker").selectpicker("refresh");
		$(".btn-simpan").hide();
		$(".btn-edit").show(); 
		$("#judul_input").html("<b><i class='fa fa-pencil-alt'></i>&nbsp;Form Update</b>"); 
		$("#dlg").modal("show");
	}
	
    function simpan() {
		var topik = $("#topik").val(); 
		var isu = $("#isu").val(); 
		var solusi = $("#solusi").val(); 
		var dateline = $("#dateline").val(); 
		var progress = $("#progress").val(); 
		var status = $("#status").val();  
		if (isu == "" || dateline == "") {
            alert("Form cannot be empty") 
            return;
        }
        $('#input_simpan, .btn-tutup').attr('disabled', true);
        $('#input_simpan').html('<i class="fa fa-spinner fa-spin" ></i> Processing');
        $.post("<?php echo base_url(); ?>actionlog/action_log/simpan", { 
            "topik": topik,
            "isu": isu,
            "solusi": solusi,
            "dateline": dateline,
            "progress": progress,
            "status": status
        }, function (datas) {
            var data = JSON.parse(datas);
            if (data.notif == "1") {
                $("#dlg").modal("hide");
                alert( data.message);
				TabelData.draw();
            } else { 
                alert( data.message);
            }
        }).fail(function () {
                alert("Error Server.");
        }).always(function () {
            $('#input_simpan').html("<i class='fa fa-save'></i>&nbsp;Simpan"); 
            $('#input_simpan, .btn-tutup').attr('disabled', false);
        });
    }
	
    function update() {
		var id_action = $("#id_action").val();
		var topik = $("#topik").val(); 
		var isu = $("#isu").val(); 
		var solusi = $("#solusi").val(); 
		var dateline = $("#dateline").val(); 
		var progress = $("#progress").val(); 
		var status = $("#status").val();  
		if (isu == "" || dateline == "") {
            alert("Form cannot be empty") 
            return;
        }
        $('#input_update, .btn-tutup').attr('disabled', true);
        $('#input_update').html('<i class="fa fa-spinner fa-spin" ></i> Processing');
        $.post("<?php echo base_url(); ?>actionlog/action_log/update", {
            "id": id_action,
            "topik": topik,
            "isu": isu,
            "solusi": solusi,
            "dateline": dateline,
            "progress": progress,
            "status": status
        }, function (datas) {
            var data = JSON.parse(datas);
            if (data.notif == "1") {
                $("#dlg").modal("hide");
                alert(data.message);
				TabelData.draw(false);
            } else {
                alert(data.message);
            }
        }).fail(function () {
               alert("Server Error.");
        }).always(function () {
            $('#input_update').html("<i class='fa fa-save'></i>&nbsp;Update"); 
            $('#input_update, .btn-tutup').attr('disabled', false);
        });
    }
	
	function approve(baris) { 
		var kolom = TabelData.row(baris).data();     
		$("#id_approve").val(kolom[9][0]);
		$("#judul_approve").html("<b><i class='fa fa-thumbs-up'></i>&nbsp;Approve</b>");
		$("#diapprove").html("Anda yakin ingin Approve " + kolom[1] + " ?" );
		$("#dlg_approve").modal("show"); 
	}
	
    function action_approve() {
        var id = $("#id_approve").val();
		$('.btn-approve, .btn-tutup').attr('disabled', true);
        $.post("<?php echo base_url(); ?>actionlog/action_log/approve", {"id": id}, function (datas) {
            var data = JSON.parse(datas);
            if (data.notif == "1") {
                alert(data.message);
                TabelData.draw(false);
                $("#dlg_approve").modal("hide"); 
            } else {
                alert(data.message);
            }
        }).fail(function () {
            alert('Server Error') 
        }).always(function () {
            $('.btn-approve, .btn-tutup').attr('disabled', false);
        });
    } 
    function action_reject() {
        var id = $("#id_approve").val();
		$('.btn-approve, .btn-tutup').attr('disabled', true);
        $.post("<?php echo base_url(); ?>actionlog/action_log/reject", {"id": id}, function (datas) {
            var data = JSON.parse(datas);
            if (data.notif == "1") {
                alert(data.message);
                TabelData.draw(false);
                $("#dlg_approve").modal("hide"); 
            } else {
                alert(data.message);
            }
        }).fail(function () {
            alert('Server Error') 
        }).always(function () {
            $('.btn-approve, .btn-tutup').attr('disabled', false);
        });
    } 
	
	function konfirmasi(baris) { 
		var kolom = TabelData.row(baris).data();     
		$("#id_hapus").val(kolom[9][0]);
		$("#judul_hapus").html("<b><i class='fa fa-pencil-alt'></i>&nbsp;Delete</b>");
		$("#dihapus").html("Anda yakin ingin menghapus Action " + kolom[1] + " ?" );
		$("#dlg_hapus").modal("show"); 
	}
	
    function hapus() {
        var id = $("#id_hapus").val();
		$('.btn-hapus, .btn-tutup').attr('disabled', true);
        $.post("<?php echo base_url(); ?>actionlog/action_log/hapus", {"id": id}, function (datas) {
            var data = JSON.parse(datas);
            if (data.notif == "1") {
                alert(data.message);
                TabelData.draw(false);
                $("#dlg_hapus").modal("hide"); 
            } else {
                alert(data.message);
            }
        }).fail(function () {
            alert('Server Error') 
        }).always(function () {
            $('.btn-hapus, .btn-tutup').attr('disabled', false);
        });
    } 
	
     function load_export() {          
			var page    =   "<?php echo base_url(); ?>actionlog/action_log/export_excel";
			// e.preventDefault();
			$.ajax({
				url: page,
				type: 'GET',	
				data: { 
			   },
				success: function() {
					 window.open(page,'_blank' );
					// window.location = page;
				}
			});
                
     }
	$(function() {
            $('#dateline').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
            });  
        });
		
</script>
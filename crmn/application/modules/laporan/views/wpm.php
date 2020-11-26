<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
	th { font-size: 11px; }
	td { font-size: 10px; }
	th, td { white-space: nowrap; }
	.W{
		background-color:#3F51B5 !important;
		font-weight:bolder;
		color:#FFFFFF;
	}
	.y{
		background-color:#FFFFFF !important;
		font-weight:bold;
		color:#222222;
	}
	.x{
		background-color:#E3F2FD !important;
		font-weight:bold;
		color:#222222;
	}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>Setting toko WPM</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        <form action="" method="post">
										<div class="col-lg-1">
											<div class="form-group">
												<div class="form-line">
													<b>REGION</b>
													<select id="pilihregion" name="region" class="form-control show-tick">
														<option value="">All</option>
														<?php
														foreach ($list_region as $ListJenisValue) { ?>
														<option value="<?php echo $ListJenisValue->NEW_REGION; ?>"><?php echo $ListJenisValue->NEW_REGION; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<b>PROVINSI</b>
											<div class="form-line" id="pilihprovinsi">
											</div>
										</div>
										</div>
                                        <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
                                        </form>
                                    </div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTable no-footer" id="daftar_report" width="100%">
                                            <thead class="w">
                                                <tr>
													<th>NO</th>
                                                    <th width="5%">KD CUSTOMER</th>
													<th width="10%">NAMA TOKO</th>
													<th width="15%">NAMA DISTRIBUTOR</th>
													<th width="15%">REGION</th>
													<th width="15%">NAMA PROVINSI</th>
													<th width="10%">NAMA DISTRIK</th>
													<th width="15%">NAMA KECAMATAN</th>
													<th width="10%">STATUS</th>
													<th width="10%">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody class="y" id="show_data">
                                            </tbody>
                                        </table>
										</div>
                                    </div>
                            	</div>
                            <div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
    </div>
</section>
<script>
$(document).ready(function() {
	//tampil_data();
	 listProvinsi("#pilihprovinsi");
	$('#pilihregion').change(function(){
    listProvinsi("#pilihprovinsi");
	})
});
function listProvinsi(key){
	var idRegion = $('#pilihregion option:selected').val();
	$.ajax({
		url: "<?php echo base_url(); ?>laporan/Data_sales/ListProvinsi/",
		type: 'POST',
		data: {
			"id_region"    : idRegion,
		},
		dataType: 'JSON',
		success: function(data){
			var response = data['data'];

			var type_list = '';
			type_list += '<select id="listProvinsi" class="form-control selectpicker show-tick" data-live-search="true">';
			type_list += '<option value="">All</option>';
			for (var i = 0; i < response.length; i++) {
				type_list += '<option value="'+response[i]['ID_PROVINSI']+'">'+response[i]['NAMA_PROVINSI']+'</option>';
			}
			type_list += '</select>';

			$(key).html(type_list);
			$(".selectpicker").selectpicker("refresh");
			document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
			
		}
	});
}
$(document).on("click", "#btnFilter", function(){
	$("#daftar_report").DataTable().destroy();
	tampil_data();
});

function tampil_data(){
$("#show_data").html('<tr><td colspan="12"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	var region = $('#pilihregion option:selected').val();
	var id_prov = $('#listProvinsi option:selected').val();
		
		$.ajax({
		url: '<?php echo site_url(); ?>laporan/Wpm/datawpm',
		type: 'POST',
		dataType : 'json',
		data: {
			"region" : region,
			"id_prov" : id_prov
		},
		success: function(data){
			  
			$('#show_data').html(data);
			$("#daftar_report").dataTable();
		},
		error: function(){
		}
    });
}
function Delete(a){
	$.ajax({
		url: "<?php echo base_url(); ?>laporan/Wpm/Delete_wpm",
		type: 'POST',
		data: {
			"id_customer"    : a,
		},
		dataType: 'JSON',
		success: function(data){
			alert(data);
			tampil_data();
			
		}
	});
}
function SAVE(a){
	$.ajax({
		url: "<?php echo base_url(); ?>laporan/Wpm/SIMPAN_wpm",
		type: 'POST',
		data: {
			"id_customer"    : a,
		},
		dataType: 'JSON',
		success: function(data){
			alert(data);
			tampil_data();
		}
	});
}
</script>
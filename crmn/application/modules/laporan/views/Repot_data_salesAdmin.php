<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
	th { font-size: 12px; }
	td { font-size: 11px; }
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
                        <h2>REPORT DATA SALES</h2>
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
										<div class="col-lg-3">
											<div class="form-group">
												<b>DISTRIBUTOR</b>
											<div class="form-line" id="pilihdistributor">
											</div>
										</div>
										</div>
                                        <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
										<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
											<button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect" ><span class="fa fa-file-excel-o"></span> Export </button>
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
													<th width="5%">ID SALES</th>
                                                    <th width="10%">NAMA SALES</th>
													<th width="10%">USERNAME</th>
													<th width="5%">REGION</th>
													<th width="10%">PROVINSI</th>
													<th width="15%">NAMA DISTRIBUTOR</th>
													<th width="15%">NAMA SO</th>
													<th width="15%">NAMA SM</th>
													<th width="15%">NAMA SSM</th>
													<th>NAMA GSM</th>
													<th>NAMA AREA</th>
													<th>NAMA DISTRIK</th>
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
	tampil_data();
	listProvinsi("#pilihprovinsi");
	listDistributor("#pilihdistributor");
	
	$('#pilihregion').change(function(){
    listProvinsi("#pilihprovinsi");
	})
	
	$('#pilihprovinsi').change(function(){
    listDistributor("#pilihdistributor");
	})
});

function tampil_data(){
$("#show_data").html('<tr><td colspan="12"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	var id = $('#listDistributor option:selected').val();
	var region = $('#pilihregion option:selected').val();
	var id_prov = $('#listProvinsi option:selected').val();
		
		$.ajax({
		url: '<?php echo site_url(); ?>laporan/Data_sales/ambildataall',
		type: 'POST',
		dataType : 'json',
		data: {
			"id" : id,
			"region" : region,
			"id_prov" : id_prov
		},
		success: function(data){
			  var html = '';
			  var i;
			  var c = "x";
			  var no = 1 ;
			  for(i=0; i<data.length; i++){
				html += '<tr class='+c+'>'+
				'<td>'+no+'</td>'+
				'<td>'+data[i].ID_SALES+'</td>'+
				'<td>'+data[i].NAMA_SALES+'</td>'+
				'<td>'+data[i].USER_SALES+'</td>'+
				'<td>'+data[i].REGION_ID+'</td>'+	
				'<td>'+data[i].NAMA_PROVINSI+'</td>'+			
				'<td>'+data[i].NAMA_DISTRIBUTOR+'</td>'+
				'<td>'+data[i].NAMA_SO+'</td>'+
				'<td>'+data[i].NAMA_SM+'</td>'+
				'<td>'+data[i].NAMA_SSM+'</td>'+
				'<td>'+data[i].NAMA_GSM+'</td>'+
				'<td>'+data[i].NM_AREA+'</td>'+
				'<td>'+data[i].NM_DISTRIK+'</td>'+
				'</tr>';
				no++;
				if(c == "x"){
					c = "y"  ;
				}else{
					c = "x" ;
				}
			  }
			$('#show_data').html(html);
			$("#daftar_report").dataTable();
		},
		error: function(){
		}
    });
}

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

function listDistributor(key){
	var idProvinsi = $('#listProvinsi option:selected').val();
	$.ajax({
		url: "<?php echo base_url(); ?>laporan/Data_sales/ListDistributor/",
		type: 'POST',
		data: {
			"id_provinsi"    : idProvinsi,
		},
		dataType: 'JSON',
		success: function(data){
			var response = data['data'];

			var type_list = '';
			type_list += '<select id="listDistributor" class="form-control selectpicker show-tick" data-live-search="true">';
			type_list += '<option value="">All</option>';
			for (var i = 0; i < response.length; i++) {
				type_list += '<option value="'+response[i]['KODE_DISTRIBUTOR']+'">'+response[i]['NAMA_DISTRIBUTOR']+'</option>';
			}
			type_list += '</select>';

			$(key).html(type_list);
			$(".selectpicker").selectpicker("refresh");
			document.getElementsByClassName("bs-searchbox")[1].getElementsByTagName("input")[0].style.marginLeft = "5px";
		}
	});
}

$(document).on("click", "#btnFilter", function(){
	$("#daftar_report").DataTable().destroy();
	tampil_data();
});

$(document).on("click", "#btnExport", function(e){
	e.preventDefault();
	var region = $('#pilihregion option:selected').val();
	var id_prov = $('#listProvinsi option:selected').val();
	var id = $('#listDistributor option:selected').val();

    window.open("<?php echo base_url()?>laporan/Data_sales/toExcel_Admin?id="+id+"&region="+region+"&id_prov="+id_prov,"_blank");
});
</script>
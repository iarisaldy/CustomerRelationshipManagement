<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
	th { font-size: 9px; }
	td { font-size: 8px; }
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
                        <h2>REPORT VOLUME SELLOUT SALES</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        <form action="" method="post">
										<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Region</b>
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
										<div class="col-lg-3 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<b>Provinsi</b>
											<div class="form-line" id="pilihprovinsi">
											</div>
										</div>
										</div>
										<div class="col-lg-3 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<b>Distributor</b>
											<div class="form-line" id="pilihdistributor">
											</div>
										</div>
										</div>
										<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Tanggal Awal</b>
													<input type="text" id="startDate" value="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Tanggal Awal">
												</div>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Tanggal Akhir</b>
													<input type="text" id="endDate" value="<?php $currentDateTime = date('Y-m-d'); echo $currentDateTime; ?>" class="form-control" placeholder="Tanggal Akhir">
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
                                        <table id="daftar_report" class="table table-striped table-bordered" width="100%">
                                            <thead class="w">
                                                <tr>
													<th>NO</th>
                                                    <th width="5%">KD CUSTOMER</th>
													<th width="10%">NM CUSTOMER</th>
													<th width="5%">REGION</th>
                                                    <th width="5%">PROVINSI</th>
													<th width="5%">AREA</th>
													<th width="5%">DISTRIK</th>
													<th width="10%">SALES DISTRIBUTOR</th>
													<th width="10%">SALES OFFICER</th>
													<th width="10%">SALES MANAJER</th>
													<th width="10%">SENIOR SALES MANAJER</th>
													<th width="10%">GENERAL SALES MANAJER</th>
													<th width="5%">PRODUK</th>
                                                    <th width="5%">QTY ZAK</th>
													<th width="5%">HARGA PERZAK</th>
													<th width="5%">TOTAL</th>
													<th width="5%">SUMBER TRANSAKSI</th>
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
$("document").ready(function() {
	//tampil_data();
	$('#startDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    $('#endDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	
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
	$("#show_data").html('<tr><td colspan="15"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	var startDate = $("#startDate").val();
	var endDate = $("#endDate").val();
	var id_distributor = $('#listDistributor option:selected').val();
	var id_provinsi = $('#listProvinsi option:selected').val();
	var region = $('#pilihregion option:selected').val();
	
	
	$.ajax({
		type  : 'POST',
		url   : '<?php echo base_url()?>laporan/Report_Volume/getdataAdmin',
		dataType : 'json',
		data: {
			"startDate" : startDate,
			"endDate" : endDate,
			"id_distributor" : id_distributor,
			"id_provinsi" : id_provinsi,
			"region" : region
		},
		success : function(data){
			var html = '';
			var i;
			var c = "x";
			var no = 1 ;
			for(i=0; i<data.length; i++){
				html += '<tr class='+c+'>'+
						'<td>'+no+'</td>'+
						'<td>'+data[i].KD_CUSTOMER+'</td>'+
						'<td>'+data[i].NAMA_TOKO+'</td>'+
						'<td>'+data[i].NEW_REGION+'</td>'+
						'<td>'+data[i].NAMA_PROVINSI+'</td>'+
						'<td>'+data[i].NAMA_AREA+'</td>'+
						'<td>'+data[i].NAMA_DISTRIK+'</td>'+
						'<td>'+data[i].NM_SALES+'</td>'+
						'<td>'+data[i].NAMA_TSO+'</td>'+
						'<td>'+data[i].NAMA_ASM+'</td>'+
						'<td>'+data[i].NAMA_RSM+'</td>'+
						'<td>'+data[i].NAMA_GSM+'</td>'+
						'<td>'+data[i].NM_PRODUK+'</td>'+
						'<td>'+data[i].QTY_SELL_OUT+'</td>'+
						'<td>'+data[i].HARGA_PER_ZAK+'</td>'+
						'<td>'+data[i].HARGA_SELL_OUT+'</td>'+
						'<td>'+data[i].AKSES_TOKO+'</td>'+
						'</tr>';
						no++;
				if(c == "x"){
					c = "y"  ;
				}else{
					c = "x" ;
				}
			}
			$('#show_data').html(html);
			$("#daftar_report").DataTable();
		}

	});
}

function listProvinsi(key){
	var idRegion = $('#pilihregion option:selected').val();
	$.ajax({
		url: "<?php echo base_url(); ?>laporan/Report_Volume/ListProvinsi/",
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
		url: "<?php echo base_url(); ?>laporan/Report_Volume/ListDistributor/",
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
		var startDate = $("#startDate").val();
		var endDate = $("#endDate").val();
		var id_distributor = $('#listDistributor option:selected').val();
		var id_provinsi = $('#listProvinsi option:selected').val();
		var region = $('#pilihregion option:selected').val();

        window.open("<?php echo base_url()?>laporan/Report_Volume/toExcelAdmin?startDate="+startDate+"&endDate="+endDate+"&id_distributor="+id_distributor+"&id_provinsi="+id_provinsi+"&region="+region,"_blank");
});
</script>
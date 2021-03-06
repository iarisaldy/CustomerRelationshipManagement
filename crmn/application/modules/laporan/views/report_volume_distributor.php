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
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div id="pilihsales" class="form-line">
												<b>Sales</b>
												<select class="form-control show-tick" id="id_sales">
													<option value="">Pilih Sales Distributor</option>
													<?php
														foreach ($list_sales as $ListJenisValue) { ?>
														<option value="<?php echo $ListJenisValue->ID_SALES; ?>"><?php echo $ListJenisValue->NAMA_SALES; ?></option>
														<?php } ?>
												</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Tanggal Awal</b>
													<input type="text" id="startDate" value="<?php echo date('Y-m-d', strtotime('-3 days')); ?>" class="form-control" placeholder="Tanggal Awal">
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
													<th width="5%">SALES</th>
													<th width="10%">DISTRIBUTOR</th>
													<th width="10%">GUDANG</th>
                                                    <th width="5%">SPJ</th>
													<th width="5%">TANGGAL</th>
                                                    <th width="10%">PRODUK</th>
													<th width="5%">QTY SELLOUT</th>
													<th width="5%">HARGA PER ZAK</th>
													<th width="5%">KD TOKO</th>
													<th width="5%">NAMA TOKO</th>
													<th width="20%">ALAMAT</th>
													<th width="5%">REGION</th>
													<th width="5%">PROVINSI</th>
													<th width="5%">AREA</th>
													<th width="5%">DISTRIK</th>
													<th width="5%">Sales Officer</th>
													<th width="5%">Sales Manajer</th>
													<th width="5%">Senior Sales Manajer</th>
													<th width="5%">General Sales Manajer</th>
													
													
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
	
		
});	

function tampil_data(){
	//$("#show_data").html('<tr><td colspan="12"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	var startDate = $("#startDate").val();
	var endDate = $("#endDate").val();
	var idsales	= $('#disales option:selected').val();
	$.ajax({
		type  : 'POST',
		url   : '<?php echo base_url()?>laporan/Report_Volume/get_data_dis',
		dataType : 'json',
		data: {
			"startDate" : startDate,
			"endDate" : endDate,
			"idsales" : idsales
		},
		success : function(data){
			var html = '';
			var i;
			var c = "x";
			var no = 1 ;
			for(i=0; i<data.length; i++){
				html += '<tr class='+c+'>'+
						'<td>'+no+'</td>'+
						'<td>'+data[i].NAMA_SALES+'</td>'+
						'<td>'+data[i].NM_DISTRIBUTOR+'</td>'+
						'<td>'+data[i].NM_GUDANG+'</td>'+
						'<td>'+data[i].NO_SPJ+'</td>'+
						'<td>'+data[i].TGL_SPJ+'</td>'+
						'<td>'+data[i].NM_PRODUK+'</td>'+
						'<td>'+data[i].QTY_SELL_OUT+'</td>'+
						'<td>'+data[i].HARGA_PER_ZAK+'</td>'+
						'<td>'+data[i].KD_CUSTOMER+'</td>'+
						'<td>'+data[i].NM_CUSTOMER+'</td>'+
						'<td>'+data[i].ALAMAT+'</td>'+
						'<td>'+data[i].REGION+'</td>'+
						'<td>'+data[i].NM_PROVINSI+'</td>'+
						'<td>'+data[i].NM_AREA+'</td>'+
						'<td>'+data[i].NM_DISTRIK+'</td>'+
						'<td>'+data[i].NAMA_SO+'</td>'+
						'<td>'+data[i].NAMA_SM+'</td>'+
						'<td>'+data[i].NAMA_SSM+'</td>'+
						'<td>'+data[i].NAMA_GSM+'</td>'+
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

$(document).on("click", "#btnFilter", function(){
	$("#daftar_report").DataTable().destroy();
	tampil_data();
});

$(document).on("click", "#btnExport", function(e){
		e.preventDefault();
		var startDate = $("#startDate").val();
		var endDate = $("#endDate").val();
        var id = $('#id_sales').val();

        window.open("<?php echo base_url()?>laporan/Report_Volume/toExcel_DIS?startDate="+startDate+"&endDate="+endDate+"&id="+id,"_blank");
});
</script>
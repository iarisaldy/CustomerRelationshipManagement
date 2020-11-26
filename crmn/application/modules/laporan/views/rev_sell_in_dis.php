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
                        <h2>REPORT REVENUE SELLIN DISTRIBUTOR</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        <form action="" method="post">
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
                                        <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
										<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12">
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
													<th width="5%">TANGGAL</th>
													<th width="5%">BULAN</th>
													<th width="5%">TAHUN</th>
													<th width="5%">KODE DISTRIBUTOR</th>
													<th width="20%">NAMA DISTRIBUTOR</th>
													<th width="5%">KODE GUDANG</th>
													<th width="5%">REGION</th>
													<th width="15%">PROVINSI</th>
													<th width="10%">KOTA</th>
													<th width="5%">TIPE ZAK</th>
													<th width="5%">REVENUE</th>
													<th width="5%">SO</th>
													<th width="5%">SM</th>
													<th width="5%">SSM</th>
													<th width="5%">GSM</th>
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
	
	//document.getElementsByClassName("bs-searchbox")[1].getElementsByTagName("input")[0].style.marginLeft = "5px";
});	

function tampil_data(){
	$("#show_data").html('<tr><td colspan="15"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	var Date1 = $("#startDate").val();
	var Date2 = $("#endDate").val();
	var cobatanggal = Date1.split('-');
	var cobatanggal2 = Date2.split('-');

	var mulai = cobatanggal[0]+cobatanggal[1]+cobatanggal[2];
	var selesai = cobatanggal2[0]+cobatanggal2[1]+cobatanggal2[2];

	
	
	$.ajax({
		type  : 'POST',
		url   : '<?php echo base_url()?>laporan/Report_Sellin/Get_data_sell_in_DIS',
		dataType : 'json',
		data: {
			"MULAI" 	: mulai,
			"SELESAI" 	: selesai
		},
		success : function(data){
			var html = '';
			var i;
			var c = "x";
			var no = 1 ;
			for(i=0; i<data.length; i++){
				html += '<tr class='+c+'>'+
						'<td>'+no+'</td>'+
						'<td>'+data[i].TANGGAL+'</td>'+
						'<td>'+data[i].BULAN+'</td>'+
						'<td>'+data[i].TAHUN+'</td>'+
						'<td>'+data[i].KODE_DISTRIBUTOR+'</td>'+
						'<td>'+data[i].NM_DISTRIBUTOR+'</td>'+
						'<td>'+data[i].KODE_GUDANG+'</td>'+
						'<td>'+data[i].REGION+'</td>'+
						'<td>'+data[i].NM_PROV+'</td>'+
						'<td>'+data[i].NM_KOTA+'</td>'+
						'<td>'+data[i].TIPE_ZAK+'</td>'+
						'<td>'+data[i].TOTAL_SELLIN+'</td>'+
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
		var Date1 = $("#startDate").val();
		var Date2 = $("#endDate").val();
		var cobatanggal = Date1.split('-');
		var cobatanggal2 = Date2.split('-');

		var mulai = cobatanggal[0]+cobatanggal[1]+cobatanggal[2];
		var selesai = cobatanggal2[0]+cobatanggal2[1]+cobatanggal2[2];

        window.open("<?php echo base_url()?>laporan/Report_Sellin/toExcel_DIS_REV?MULAI="+mulai+"&SELESAI="+selesai,"_blank");
});
</script>
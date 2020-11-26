<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
	th { font-size: 13px; }
	td { font-size: 12px; }
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>SALES RESUME PERFORMANCE</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                            			<b>Bulan</b>
                            			<select data-size="5" id="filterBulan" class="form-control show-tick">
                                            <option>Pilih Bulan</option>
                                            <?php 
                                            for($j=1;$j<=12;$j++){
                                                $dateObj   = DateTime::createFromFormat('!m', $j);
                                                $monthName = $dateObj->format('F');
                                                ?>
                                                <option value="<?php echo $j; ?>" <?php if($j == date('m')){ echo "selected";} ?>><?php echo $monthName; ?></option>
                                            <?php } ?>
                                        </select>
                            		</div>
                            		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                            			<b>Tahun</b>
                            			<select id="filterTahun" class="form-control show-tick">
                                            <option>Pilih Tahun</option>
                                            <?php $year = date('Y')-1;
                                                for ($i=$year; $i <= $year+2 ; $i++) { ?>
                                                    <option value="<?php echo $i; ?>" <?php if($i==date('Y')){echo "selected";} ?>><?php echo $i; ?></option>
                                            <?php } ?>    
                                        </select>
                            		</div>
                            		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            			<b>&nbsp;</b><br/>
                            			<button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                            		</div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="performanceSales" class="table table-bordered" width="100%">
                                            <thead class="w">
                                                <tr>
                                                    <th>No</th>
                                                    <th width="30%">NAMA SALES</th>
                                                    <th width="30%">NAMA DISTRIBUTOR</th>
                                                    <th width="10%">TAHUN</th>
													<th width="10%">BULAN</th>
													<th width="10%">TARGET</th>
													<th width="10%">REALISASI</th>
													<th width="10%">DETAIL</th>
                                                </tr>
                                            </thead>
											<tbody class="y" id="show_data">
                                            </tbody>
                                        </table>
                                    </div>
                            	</div>
								<div class="col-md-6" id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
								<div class="col-md-6" id="container1" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
                <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
	                <div class="modal-dialog modal-lg" role="document">
	                    <div class="modal-content">
	                        <div class="modal-header" style="background-color: #00b0e4;color: white;">
	                            <h4 class="modal-title" id="defaultModalLabel">Grafik Kunjungan Harian</h4>
	                        </div>
	                        <div class="modal-body">
	                        	<div id="chartCanvasingSales"></div>
	                        </div>
	                        <div class="modal-footer">
	                            <button type="button" class="btn waves-effect btn-info" data-dismiss="modal">CLOSE</button>
	                        </div>
	                    </div>
	                </div>
	            </div>
            </div>
        </div>
    </div>
</section>
<script>
	$("document").ready(function(){
	tampil_data();
	var bulan	= $('#filterBulan option:selected').val();
	var tahun = $('#filterTahun option:selected').val();
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Coba/GetData_GAP',
		type: 'POST',
		dataType : 'json',
		data: {
			"bulan" : bulan,
			"tahun" : tahun
		},
		success: function(data){
		console.log(data);
		Highcharts.chart('container1', {
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: 'Persentase Toko Dikunjungi'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.percentage:.1f} %'
				},
				showInLegend: true
			}
		},
		series: [{
			name: 'Kunjungan Toko',
			colorByPoint: true,
			data: data.data
		}]
	});
	
	Highcharts.chart('container', {
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: 'Persentase Kunjungan Sales '
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.percentage:.1f} %'
				},
				showInLegend: true
			}
		},
		series: [{
			name: 'Kunjungan',
			colorByPoint: true,
			data: data.Gap
		}]
	});
		},
		error: function(){
		}
	});
	
	
	
	});
	
	function tampil_data(){
	$("#show_data").html('<tr><td colspan="5"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	var bulan	= $('#filterBulan option:selected').val();
	var tahun = $('#filterTahun option:selected').val();
		
		$.ajax({
		url: '<?php echo site_url(); ?>master/Coba/GetData_TSO',
		type: 'POST',
		dataType : 'json',
		data: {
			"bulan" : bulan,
			"tahun" : tahun
		},
		success: function(data){
			  var html = '';
			  var i;
			  var c = "x";
			  for(i=1; i<data.length; i++){
				html += '<tr class='+c+'>'+
				'<td>'+i+'</td>'+
				'<td>'+data[i].NAMA_SALES+'</td>'+
				'<td>'+data[i].NAMA_DISTRIBUTOR+'</td>'+
				'<td>'+data[i].TAHUN+'</td>'+
				'<td>'+data[i].BULAN+'</td>'+
				'<td>'+data[i].TARGET+'</td>'+
				'<td>'+data[i].REALISASI+'</td>'+
				'<td><center><button type="button" id="detailSales" nama='+data[i].NAMA_SALES+' idpd='+data[i].ID_USER+' class="btn btn-sm btn-info"><i class="fa fa-info"> Detail</i></button></center></td>'+
				'</tr>';
				if(c == "x"){
					c = "y"  ;
				}else{
					c = "x" ;
				}
			  }
			$('#show_data').html(html);
			$("#performanceSales").dataTable();
		},
		error: function(){
		}
	});
	}

	$(document).on("click", "#btnFilter", function(){
		$("#performanceSales").DataTable().destroy();
		tampil_data();
	});

	$(document).on("click", "#detailSales", function(e){
		var id = $(this).attr("idpd");
		var nama = $(this).attr("nama");
		var bulan	= $('#filterBulan option:selected').val();
		var tahun = $('#filterTahun option:selected').val();
		$("#defaultModal").modal("show");
		detailCanvasingSales(id, bulan, tahun,nama);
	});

	function detailCanvasingSales(id, bulan, tahun , nama){
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

		$.ajax({
            url: "<?php echo base_url(); ?>master/Coba/GetData_Persales",
            type: "POST",
            dataType: "JSON",
			data: {
			"bulan" : bulan,
			"tahun" : tahun,
			"id" : id
		},
		success: function(data){
		Highcharts.chart('chartCanvasingSales' , {
			chart: {
				type: 'line'
			},
			title: {
				text: 'Grafik Kunjungan Sales '+nama + 'bulan-' + monthNames[bulan-1]
			},
			subtitle: {
				text: 'crm.semenindonesia.com'
			},
			xAxis: {
				categories: data.data
			},
			yAxis: {
				title: {
					text: 'Kunjungan'
				}
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					},
					enableMouseTracking: false
				}
			},
			series: [{
				name: 'Realisasi',
				colors: '#4572A7',
				data: data.realisasi
			}, {
				name: 'Target',
				data: data.target
			}]
		});
	}
});
}
</script>
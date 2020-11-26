s<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>Sales Resume Performance</h2>
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
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Nama</th>
                                                    <th width="15%">Total Kunjungan</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                            	</div>
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
<script type="text/javascript">
	$("document").ready(function(){
		$('#startDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#endDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
		performanceSales(<?php echo date('m');?>, <?php echo date('Y'); ?>);
	});

	$(document).on("click", "#btnFilter", function(e){
		e.preventDefault();
		var bulan = $("#filterBulan").val();
		var tahun = $("#filterTahun").val();
		performanceSales(bulan, tahun);
	});

	$(document).on("click", "#detailSales", function(e){
		var idUser = $(this).data("iduser");
        var nama = $(this).data("nama");
		var bulan = $("#filterBulan").val();
		var tahun = $("#filterTahun").val();
		$("#defaultModal").modal("show");
		detailCanvasingSales(idUser, nama, bulan, tahun);
	});

	function detailCanvasingSales(idUser, nama, bulan, tahun){
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

		$.ajax({
            url: "<?php echo base_url(); ?>distributor/ResumePerformanceSales/kunjunganHarian/"+idUser+"/"+bulan+"/"+tahun,
            type: "GET",
            dataType: "JSON",
            success: function(data){
				console.log(data);
                FusionCharts.ready(function(){
                    var fusioncharts = new FusionCharts({
                        type: 'line',
                        renderAt: 'chartCanvasingSales',
                        width: '100%',
                        height: '400',
                        dataFormat: 'json',
                        dataSource: {
                            "chart": {
                                "theme": "fusion",
                                "caption": "Kunjungan Harian "+nama+" Bulan "+monthNames[bulan-1],
                                "subCaption": "",
                                "xAxisName": "Tanggal",
                                "yAxisName": "Total Kunjungan",
                                "lineThickness": "2",
                                "bgColor": "#ffffff",
                                "showBorder": "0",
                                "drawcrossline": "1",
                                "showCanvasBorder": "0",
                                "palettecolors": "#D45704",
                                "formatNumber": "0",
                                "formatNumberScale": "0"
                            },
                            "data": data.data,
                            "trendlines" : data.trendlines
                        }
                    });
                    fusioncharts.render();
                });
            }
        });
	}

	function performanceSales(bulan = null, tahun = null){
		$("#performanceSales").dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('distributor/ResumePerformanceSales/canvasingPerformance'); ?>",
                type: "POST",
                data: {
                	"bulan": bulan,
                	"tahun": tahun
                }
            }
        });
	}
</script>
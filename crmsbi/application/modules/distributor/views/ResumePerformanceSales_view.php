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
                            		<div class="col-md-1">
                            			<b>&nbsp;</b><br/>
                            			<button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                            		</div>
									<div class="col-md-1">
                                        <br/>
										<!--
                                        <button id="tombol_export_exel" class="btn btn-success"><span class="fa fa-file-excel-o"></span> Export with PHP</button>
										-->
										<button class="btn btn-success" onclick="exportTableToExcel('performanceSales')"><span class="fa fa-file-excel-o"></span> Export Excel</button>
									</div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="performanceSales" class="table table-bordered" width="100%" border="1">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Nama</th>
													<th>Distributor</th>
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
		performanceSales_excel(<?php echo date('m');?>, <?php echo date('Y'); ?>);
	});

	$(document).on("click", "#btnFilter", function(e){
		e.preventDefault();
		var bulan = $("#filterBulan").val();
		var tahun = $("#filterTahun").val();
		performanceSales(bulan, tahun);
		performanceSales_excel(bulan, tahun);
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
			"lengthMenu": [[-1, 10, 25, 50, 100], ["All", 10, 25, 50, 100]],
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
	
	$(document).on('click', '#tombol_export_exel', function(){
        Bulan           = $('#filterBulan').val();
        Tahun           = $('#filterTahun').val();
        link            =  '<?php echo base_url(); ?>distributor/ResumePerformanceSales/Export_exel/'+ Bulan + '/'+ Tahun;
        location.href   = link;
    });
</script>

<script>

function exportTableToExcel(tableID){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
	
	var bulan = $('#filterBulan').val();
    var tahun = $('#filterTahun').val();
	var uniq_title = 'bulan '+bulan+' tahun '+tahun;
	
	var objDate = new Date();
	var todayDate = objDate.getDate()+'-'+objDate.getMonth()+'-'+objDate.getFullYear();
	var todayTime = objDate.getHours()+'_'+objDate.getMinutes()+'_'+objDate.getSeconds();
	
	var filename = 'Laporan CRM Sales Resume Performance '+uniq_title+' ('+todayDate+ ' '+todayTime+')';
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}

</script>
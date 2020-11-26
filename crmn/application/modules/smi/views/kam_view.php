<style type="text/css">
	th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }
	
	div.dataTables_wrapper {
		width: 100%; 
		margin: 0 auto;
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
	.W{
		background-color:#3F51B5 !important;
		font-weight:bolder;
		color:#FFFFFF;
	}
	.T{
		background-color:#000000 !important;
		font-weight:bolder;
		color:#f5f5f5;
	}
	.N{
		background-color:#757575 !important;
		font-weight:bolder;
		color:#f5f5f5;
	}
</style>

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>Dashboard Kanvasing KAM</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        <form action="" method="post">
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                            <b>Bulan</b>
                                            <select data-size="5" id="filterBulan" name="filterBulan" class="form-control show-tick">
                                                <option>Pilih Bulan</option>
                                                <?php 
                                                for($j=1;$j<=12;$j++){
                                                    $dateObj   = DateTime::createFromFormat('!m', $j);
                                                    $monthName = $dateObj->format('F');
                                                    if($j<10){
                                                        $b='0'. $j;
                                                    }
                                                    else {
                                                        $b=$j;
                                                    }
                                                    ?>
                                                    <option value="<?php echo $b; ?>" <?php if($j == $bulan){ echo "selected";} ?>><?php echo $monthName; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                            <b>Tahun</b>
                                            <select id="filterTahun" name="filterTahun" class="form-control show-tick">
                                                <option>Pilih Tahun</option>
                                                <?php $year = date('Y')-1;
                                                    for ($i=$year; $i <= $year+2 ; $i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if($i==$tahun){echo "selected";} ?>><?php echo $i; ?></option>
                                                <?php } ?>    
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="submit" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                                        </div>
                                        </form>
										<div class="col-md-1">
											<!--
											<br/>
											<button id="tombol_export_exel" class="btn btn-success"><span class="fa fa-file-excel-o"></span> Export </button>
											-->
										</div>
                                    </div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="performanceSales" class="table table-bordered" width="100%">
                                            <thead class="w">
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Nama</th>
                                                    <th width="40%">Distributor</th>
                                                    <th width="15%">Total Kunjungan</th>
                                                    <th width="10%"><center>Action</center></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    echo $isi_table;
                                                 ?>
                                            </tbody>
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
    $(document).on('click', '.tampil_grafik_detile_kam', function(){

        $("#defaultModal").modal("show");
        $.ajax({
            url: "<?php echo base_url(); ?>smi/Kam/Ajax_tampil_data_bulanan",
            type: 'POST',
            data: {
                "user"      : $(this).attr('id_user'),
                "tahun"     : $("#filterTahun").val(),
                "bulan"     : $("#filterBulan").val(),
            },
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
                                "caption": "Kunjungan Harian ",
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
                            "data": data,

                        }
                    });
                    fusioncharts.render();
                });
            }
        });
    });
	$(document).on('click', '#tombol_export_exel', function(){
        Bulan           = $('#filterBulan').val();
        Tahun           = $('#filterTahun').val();
        link            =  '<?php echo base_url(); ?>smi/Kam/Export_exel/'+ Bulan + '/'+ Tahun;
        location.href   = link;
    });
</script>
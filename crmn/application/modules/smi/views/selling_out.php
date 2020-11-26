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

<script src="<?php echo base_url(); ?>assets/js/plugins/highcharts/js/highcharts.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <a href=""></a>
                <div class="card">
					          <div class="header bg-cyan">
                        <h2>Volume Distributor Selling OUT </h2>
                    </div>
                    <div class="body">
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
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
									<a href="<?php echo base_url(); ?>smi/Volume_distributor/Sellinginout/1" class="btn btn-success" role="button">Selling IN</a>  
									<a href="<?php echo base_url(); ?>smi/Volume_distributor/Sellinginout/2" class="btn btn-danger" role="button">Selling OUT</a>
                        		</div>
                        	</div>
              							<div class="col-md-12">
              								<div class="table-responsive">
              									<table id="table_vd" class="table table-striped table-bordered table-hover" >
              	                                    <thead>
              										    <tr class="w">
              										        <th><center>NO</center></th>
              										        <th><center>KODE DISTRIBUTOR</center></th>
              										        <th><center>NAMA DISTRIBUTOR</center></th>
              										        <th><center>VOLUME</center></th>
              										        <th><center>HARGA</center></th>
              										        <th><center>REVENUE</center></th>
                                          <th><center>DETILE</center></th>
              										    </tr>
              									    </thead>
              	                                    <tbody>
              	                                    	<?php 
              	                                    		echo $isi_table;
              	                                    	?>
              	                                        <!-- data di load disini -->
              	                                    </tbody>
              	                                </table>
              	                            </div>          
              							</div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                <h4 class="modal-title" id="defaultModalLabel">DETILE SELLING OUT GUDANG</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                  <table id="table_vd" class="table table-striped table-bordered table-hover" >
                      <thead>
                        <tr class="w">
                            <th><center>NO</center></th>
                            <th><center>KODE GUDANG</center></th>
                            <th><center>NAMA GUDANG</center></th>
                            <th><center>VOLUME</center></th>
                            <th><center>HARGA</center></th>
                            <th><center>REVENUE</center></th>
                            <th><center>GRAFIK</center></th>
                            <th><center>TOKO</center></th>
                        </tr>
                      </thead>
                      <tbody id="detile_gudang">
                          <!-- data di load disini -->
                      </tbody>
                  </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect btn-info" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Grafik_gudang" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                <h4 class="modal-title" id="defaultModalLabel">Growth Volume Gudang</h4>
            </div>
            <div class="modal-body">
                <div id="GROWTH_volume_gudang"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect btn-info" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Tampilan_penjualan_toko" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                <h4 class="modal-title" id="defaultModalLabel">DETILE PENJUALAN TOKO</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                  <table id="table_vd" class="table table-striped table-bordered table-hover" >
                      <thead>
                        <tr class="w">
                            <th><center>NO</center></th>
                            <th><center>KODE TOKO</center></th>
                            <th><center>NAMA TOKO</center></th>
                            <th><center>VOLUME</center></th>
                            <th><center>HARGA</center></th>
                            <th><center>REVENUE</center></th>
                            <th><center>GRAFIK</center></th>
                        </tr>
                      </thead>
                      <tbody id="detile_toko">
                          <!-- data di load disini -->
                      </tbody>
                  </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect btn-info" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Grafik_toko" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                <h4 class="modal-title" id="defaultModalLabel">Growth Volume TOKO</h4>
            </div>
            <div class="modal-body">
                <div id="GROWTH_volume_toko"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect btn-info" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<script>
$("document").ready(function(){
	//$('#table_vd').dataTable();
	// hargaJualDist();
	// salesDistributor();
});

$(document).on('click', '.Tampilkan_form_growth', function(){
    $('#defaultModal').modal('show');
    var nama_distributor = $(this).attr('nm_dist');
    var kode_distributor = $(this).attr('distributor');
    $.ajax({
        url: "<?php echo base_url(); ?>smi/Volume_distributor/AJax_tampil_detile_gudang",
        type: 'POST',
        data: {
            "distributor"       : $(this).attr('distributor'),
            "tahun"             : $('#filterTahun').val(),
            "bulan"             : $('#filterBulan').val()
        },
        success: function(data){
            $("#detile_gudang").html(data);
        }
    });
});

$(document).on('click', '.Tampilkan_grafik_per_gudang', function(){
    $('#Grafik_gudang').modal('show');

    var gudang = $(this).attr('gudang');
    var nm_gudang = $(this).attr('nm_gudang');
    $.ajax({
        url: "<?php echo base_url(); ?>smi/Volume_distributor/Ajax_tampil_grafik_gudang",
        type: 'POST',
        data: {
            "gudang"       : gudang,
        },
        dataType: "JSON",
        success: function(hasil){

            Highcharts.chart('GROWTH_volume_gudang', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'GROWTH VOLUME '+ gudang + '- '+ nm_gudang
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: [
                        'Jan',
                        'Feb',
                        'Mar',
                        'Apr',
                        'May',
                        'Jun',
                        'Jul',
                        'Aug',
                        'Sep',
                        'Oct',
                        'Nov',
                        'Dec'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'QTY (TON)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:6px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.0f} TON</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: hasil                
            });          
            // FusionCharts.ready(function() {
            //   var visitChart = new FusionCharts({
            //     type: 'mscolumn2d',
            //     renderAt: 'GROWTH_volume_gudang',
            //     width: '100%',
            //     height: '400',
            //     dataFormat: 'json',
            //     dataSource: {
            //       "chart": {
            //         "theme": "fusion",
            //         "caption": "GROWTH VOLUME "+ gudang + " - "+ nm_gudang,
            //         "subCaption": "",
            //         "xAxisName": "Bulan",
            //         "yAxisName": "Volume",
            //         "showValues": "1",
            //         "placeValuesInside": "1",
            //          "rotateValues": "1",
                     
            //          // "valueFont": "Arial",
            //           // "valueFontColor": "#ffffff",
            //           // "valueFontSize": "12",
            //           // "valueBgColor": "#cccccc",
            //           // "valueBgAlpha": "90",
                     
            //       },
            //       "categories": [{
            //         "category": [{
            //             "label": "Jan"
            //           },
            //           {
            //             "label": "Feb"
            //           },
            //           {
            //             "label": "Mar"
            //           },
            //           {
            //             "label": "Apr"
            //           },
            //           {
            //             "label": "May"
            //           },
            //           {
            //             "label": "Jun"
            //           },
            //           {
            //             "label": "Jul"
            //           },
            //           {
            //             "label": "Aug"
            //           },
            //           {
            //             "label": "Sep"
            //           },
            //           {
            //             "label": "Oct"
            //           },
            //           {
            //             "label": "Nov"
            //           },
            //           {
            //             "label": "Dec"
            //           }
            //         ]
            //       }],
            //       "dataset": [
            //         {
            //           "seriesname": "2018",
            //           "data": data.h2018
            //         },
            //         {
            //           "seriesname": "2019",
            //           "data": data.h2019
            //         },
            //       ],
            //       // "trendlines": [{
            //         // "line": [{
            //           // "startvalue": "17022",
            //           // "color": "#62B58F",
            //           // "valueOnRight": "1",
            //           // "displayvalue": "Average"
            //         // }]
            //       // }]
            //     }
            //   }).render();
            // });
        }
    });

});

$(document).on('click', '.Tampilkan_detile_toko', function(){
    $('#Tampilan_penjualan_toko').modal('show');
    var gudang = $(this).attr('gudang');
    var nm_gudang = $(this).attr('nm_gudang');

    $.ajax({
        url: "<?php echo base_url(); ?>smi/Volume_distributor/Ajax_tampil_detile_toko_gudang",
        type: 'POST',
        data: {
            "gudang"            : gudang,
            "tahun"             : $('#filterTahun').val(),
            "bulan"             : $('#filterBulan').val()
        },
        success: function(data){
            $("#detile_toko").html(data);
        }
    });


});

$(document).on('click', '.Tampilkan_form_growth_toko', function(){
    $('#Grafik_toko').modal('show');
    
    var kd_toko   = $(this).attr('kd_toko');
    var nm_toko   = $(this).attr('nm_toko');

    $.ajax({
        url: "<?php echo base_url(); ?>smi/Volume_distributor/Ajax_tampil_grafik_toko",
        type: 'POST',
        data: {
            "kd_toko"            : kd_toko
        },
        dataType: "JSON",
        success: function(hasil){

            Highcharts.chart('GROWTH_volume_toko', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'GROWTH VOLUME '+ kd_toko + '- '+ nm_toko
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: [
                        'Jan',
                        'Feb',
                        'Mar',
                        'Apr',
                        'May',
                        'Jun',
                        'Jul',
                        'Aug',
                        'Sep',
                        'Oct',
                        'Nov',
                        'Dec'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'QTY (TON)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:6px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.0f} TON</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: hasil                
            });
            // FusionCharts.ready(function() {
            //   var visitChart = new FusionCharts({
            //     type: 'mscolumn2d',
            //     renderAt: 'GROWTH_volume_toko',
            //     width: '100%',
            //     height: '400',
            //     dataFormat: 'json',
            //     dataSource: {
            //       "chart": {
            //         "theme": "fusion",
            //         "caption": "GROWTH VOLUME "+ kd_toko + " - "+ nm_toko,
            //         "subCaption": "",
            //         "xAxisName": "Bulan",
            //         "yAxisName": "Volume",
            //         "showValues": "1",
            //         "placeValuesInside": "1",
            //          "rotateValues": "1",
                     
            //          // "valueFont": "Arial",
            //           // "valueFontColor": "#ffffff",
            //           // "valueFontSize": "12",
            //           // "valueBgColor": "#cccccc",
            //           // "valueBgAlpha": "90",
                     
            //       },
            //       "categories": [{
            //         "category": [{
            //             "label": "Jan"
            //           },
            //           {
            //             "label": "Feb"
            //           },
            //           {
            //             "label": "Mar"
            //           },
            //           {
            //             "label": "Apr"
            //           },
            //           {
            //             "label": "May"
            //           },
            //           {
            //             "label": "Jun"
            //           },
            //           {
            //             "label": "Jul"
            //           },
            //           {
            //             "label": "Aug"
            //           },
            //           {
            //             "label": "Sep"
            //           },
            //           {
            //             "label": "Oct"
            //           },
            //           {
            //             "label": "Nov"
            //           },
            //           {
            //             "label": "Dec"
            //           }
            //         ]
            //       }],
            //       "dataset": [
            //         {
            //           "seriesname": "2018",
            //           "data": hasil.h2018
            //         },
            //         {
            //           "seriesname": "2019",
            //           "data": hasil.h2019
            //         },
            //       ],
            //       // "trendlines": [{
            //         // "line": [{
            //           // "startvalue": "17022",
            //           // "color": "#62B58F",
            //           // "valueOnRight": "1",
            //           // "displayvalue": "Average"
            //         // }]
            //       // }]
            //     }
            //   }).render();
            // });
        }
    });    
});

</script>
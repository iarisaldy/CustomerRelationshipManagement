<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <a href=""></a>
                <div class="card">
					<div class="header bg-cyan">
                        <h2>Sales Revenue Distributor</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div id="chartRevenue"></div>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>
<script>
	$("document").ready(function(){
		salesRevenue();
	});

	function salesRevenue() {
		FusionCharts.ready(function(){
			var fusioncharts = new FusionCharts({
				type: 'line',
				renderAt: 'chartRevenue',
				width: '100%',
				height: '450',
				dataFormat: 'json',
				dataSource: {
					"chart": {
						"theme": "fusion",
						"caption": "Grafik Revenue Distributor 2018",
						"subCaption": "Data masih dummy",
						"xAxisName": "Bulan",
						"yAxisName": "Revenue (Rupiah)",
						"lineThickness": "2",
						"bgColor": "#ffffff",
						"showBorder": "0",
						"drawcrossline": "1",
						"showCanvasBorder": "0",
						"formatNumberScale": "0",
						"decimalSeparator": ",",
						"thousandSeparator": ".",
						"palettecolors": "#00BCD4"
					},
					"data": [{
						"label": "Januari",
						"value": "15123"
					},{
						"label": "Februari",
						"value": "14233"
					},{
						"label": "Maret",
						"value": "23507"
					},{
						"label": "April",
						"value": "9110"
					},{
						"label": "Mei",
						"value": "15529"
					},{
						"label": "Juni",
						"value": "20803"
					},{
						"label": "Juli",
						"value": "19202"
					},{
						"label": "Agustus",
						"value": "19202"
					},{
						"label": "September",
						"value": "19202"
					},{
						"label": "Oktober",
						"value": "0"
					},{
						"label": "November",
						"value": "0"
					},{
						"label": "Desember",
						"value": "0"
					}]
				}
			});
			fusioncharts.render();
		});
	}
</script>
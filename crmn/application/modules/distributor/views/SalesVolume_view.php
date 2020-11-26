<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <a href=""></a>
                <div class="card">
					<div class="header bg-cyan">
                        <h2>Sales Volume Distributor</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div id="chartVolume"></div>
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
		salesVolume();
	});

	function salesVolume() {
		FusionCharts.ready(function(){
			var fusioncharts = new FusionCharts({
				type: 'line',
				renderAt: 'chartVolume',
				width: '100%',
				height: '450',
				dataFormat: 'json',
				dataSource: {
					"chart": {
						"theme": "fusion",
						"caption": "Grafik Volume Distributor 2018",
						"subCaption": "Data masih dummy",
						"xAxisName": "Bulan",
						"yAxisName": "Volume (TON)",
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
						"value": "100"
					},{
						"label": "Februari",
						"value": "90"
					},{
						"label": "Maret",
						"value": "70"
					},{
						"label": "April",
						"value": "60"
					},{
						"label": "Mei",
						"value": "90"
					},{
						"label": "Juni",
						"value": "80"
					},{
						"label": "Juli",
						"value": "80"
					},{
						"label": "Agustus",
						"value": "70"
					},{
						"label": "September",
						"value": "90"
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
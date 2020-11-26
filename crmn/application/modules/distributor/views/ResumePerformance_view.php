<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <a href=""></a>
                <div class="card">
					<div class="header bg-cyan">
                        <h2>Resume Performance Distributor</h2>
                    </div>
                    <div class="body">
                        <div class="row">
							<div class="col-md-12">
								<form action="" method="post">
									<div class="row clearfix">
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<select name="Tahun" id="tahun">
													<option value="0" deselected>Pilih Tahun</option>
													<?php
														for($i=2018; $i<2020; $i++){
															if($TAHUN==$i){
																echo '<option  value="'.$i.'" selected>'.$i.'</option>';
															}
															else {
																echo '<option value="'.$i.'">'.$i.'</option>';
															}
															
														}
														
													?>
												</select>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-2 col-xs-12">
											<input type="submit" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect" value="View">
										</div>
									</div>
								</form>
							</div>
                            <div class="container-fluid">
                            	<div class="col-md-6">
                            		<div id="hargaBeliDist"></div>
                            	</div>
                            	<div class="col-md-6">
                            		<div id="hargaJualDist"></div>
                            	</div>
                            	<div class="col-md-12">
                            		<div id="salesDistributor"></div>
                            	</div>
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
		hargaBeliDist();
		hargaJualDist();
		salesDistributor();
	});

	function salesDistributor(){
		FusionCharts.ready(function() {
		  var visitChart = new FusionCharts({
			type: 'mscolumnline3d',
			renderAt: 'salesDistributor',
			width: '100%',
			height: '400',
			dataFormat: 'json',
			dataSource: {
			  "chart": {
				"theme": "fusion",
				"caption": "VOLUME PENJUALAN DISTRIBUTOR <?php echo $TAHUN; ?>",
				"subCaption": "",
				"xAxisName": "Bulan",
				"yAxisName": "Volume (TON)",
				"showValues": "1",
				"placeValuesInside": "1",
				 "rotateValues": "1",
				 "bgColor": "#ffffff",
				"showBorder": "0",
				
			  },
			  "categories": [{
				"category": [{
					"label": "Jan"
				  },
				  {
					"label": "Feb"
				  },
				  {
					"label": "Mar"
				  },
				  {
					"label": "Apr"
				  },
				  {
					"label": "May"
				  },
				  {
					"label": "Jun"
				  },
				  {
					"label": "Jul"
				  },
				  {
					"label": "Aug"
				  },
				  {
					"label": "Sep"
				  },
				  {
					"label": "Oct"
				  },
				  {
					"label": "Nov"
				  },
				  {
					"label": "Dec"
				  }
				]
			  }],
			  "dataset": [{
				  "seriesname": "Target Volume Distributor",
				  "data": <?php echo $TARGET_VOLUME_JUAL; ?>
				},
				{
				  "seriesname": "Realisasi Volume Distributor",
				  "data": <?php echo $VOLUME_JUAL; ?>
				}
			  ],
			  // "trendlines": [{
				// "line": [{
				  // "startvalue": "17022",
				  // "color": "#62B58F",
				  // "valueOnRight": "1",
				  // "displayvalue": "Average"
				// }]
			  // }]
			}
		  }).render();
		});
		// FusionCharts.ready(function(){
			// var fusioncharts = new FusionCharts({
				// type: 'column2d',
				// renderAt: 'salesDistributor',
				// width: '100%',
				// height: '400',
				// dataFormat: 'json',
				// dataSource: {
					// "chart": {
						// "caption": "VOLUME PENJUALAN DISTRIBUTOR <?php echo $TAHUN; ?>",
						// "subCaption": "",
						// "xAxisName": "Bulan",
						// "yAxisName": "Penjualan (TON)",
						// "theme": "fusion",
						// "bgColor": "#ffffff",
						// "showBorder": "0",
						// "drawcrossline": "1",
						// "showCanvasBorder": "0",
						// "formatNumberScale": "0",
						// "decimalSeparator": ",",
						// "thousandSeparator": ".",
						// "palettecolors": "#E76838",
						// "usePlotGradientColor": "1",
						// "plotGradientColor":"#DB2D43",
						// "showPlotBorder": "0"
					// },
					// "data": <?php echo $VOLUME_JUAL; ?>
				// }
			// });
			// fusioncharts.render();
		// });
	}

	function hargaBeliDist() {
		FusionCharts.ready(function() {
		  var visitChart = new FusionCharts({
			type: 'mscolumn2d',
			renderAt: 'hargaBeliDist',
			width: '700',
			height: '400',
			dataFormat: 'json',
			dataSource: {
			  "chart": {
				"theme": "fusion",
				"caption": "HARGA BELI DISTRIBUTOR <?php echo $TAHUN; ?>",
				"subCaption": "",
				"xAxisName": "Bulan",
				"yAxisName": "Harga (Ribu) / TON",
				"showValues": "1",
				"placeValuesInside": "1",
				 "rotateValues": "1",
				 
				 // "valueFont": "Arial",
				  // "valueFontColor": "#ffffff",
				  // "valueFontSize": "12",
				  // "valueBgColor": "#cccccc",
				  // "valueBgAlpha": "90",
				 
			  },
			  "categories": [{
				"category": [{
					"label": "Jan"
				  },
				  {
					"label": "Feb"
				  },
				  {
					"label": "Mar"
				  },
				  {
					"label": "Apr"
				  },
				  {
					"label": "May"
				  },
				  {
					"label": "Jun"
				  },
				  {
					"label": "Jul"
				  },
				  {
					"label": "Aug"
				  },
				  {
					"label": "Sep"
				  },
				  {
					"label": "Oct"
				  },
				  {
					"label": "Nov"
				  },
				  {
					"label": "Dec"
				  }
				]
			  }],
			  "dataset": [{
				  "seriesname": "Target harga Beli Distributor",
				  "data": <?php echo $TARGET_HARGA_JUAL; ?>
				},
				{
				  "seriesname": "Realisasi Harga Beli Distributor",
				  "data": <?php echo $HARGA_JUAL; ?>
				},
				// {
				  // "seriesname": "Realisasi Jual Beli",
				  // "data": <?php echo $HARGA_JUAL; ?>
				// }
			  ],
			  // "trendlines": [{
				// "line": [{
				  // "startvalue": "17022",
				  // "color": "#62B58F",
				  // "valueOnRight": "1",
				  // "displayvalue": "Average"
				// }]
			  // }]
			}
		  }).render();
		});
	}

	function hargaJualDist() {
		FusionCharts.ready(function() {
		  var visitChart = new FusionCharts({
			type: 'mscolumn2d',
			renderAt: 'hargaJualDist',
			width: '700',
			height: '400',
			dataFormat: 'json',
			dataSource: {
			  "chart": {
				"theme": "fusion",
				"caption": "HARGA JUAL DISTRIBUTOR <?php echo $TAHUN; ?>",
				"subCaption": "",
				"yAxisName": "Harga (Ribu) / TON",
				"xAxisName": "Bulan",
				"showValues": "1",
				"placeValuesInside": "1",
				 "rotateValues": "1",
				 
			  },
			  "categories": [{
				"category": [{
					"label": "Jan"
				  },
				  {
					"label": "Feb"
				  },
				  {
					"label": "Mar"
				  },
				  {
					"label": "Apr"
				  },
				  {
					"label": "May"
				  },
				  {
					"label": "Jun"
				  },
				  {
					"label": "Jul"
				  },
				  {
					"label": "Aug"
				  },
				  {
					"label": "Sep"
				  },
				  {
					"label": "Oct"
				  },
				  {
					"label": "Nov"
				  },
				  {
					"label": "Dec"
				  }
				]
			  }],
			  "dataset": [{
				  "seriesname": "Target harga Jual Distributor",
				  "data": <?php echo $TARGET_JUAL; ?>
				},
				{
				  "seriesname": "Realisasi Harga Jual Distributor",
				  "data": <?php echo $TOTAL_JUAL; ?>
				}
			  ],
			  // "trendlines": [
					// {
						// "line": [
							// {
								// "startvalue": "12250",
								// "color": "#5D62B5",
								// "displayvalue": "Previous{br}Average",
								// "valueOnRight": "1",
								// "thickness": "1",
								// "showBelow": "1",
								// "tooltext": "Previous year quarterly target  : $13.5K"
							// },
							// {
								// "startvalue": "25950",
								// "color": "#29C3BE",
								// "displayvalue": "Current{br}Average",
								// "valueOnRight": "1",
								// "thickness": "1",
								// "showBelow": "1",
								// "tooltext": "Current year quarterly target  : $23K"
							// }
						// ]
					// }
				// ]
			}
		  }).render();
		});
		
		
		
		// FusionCharts.ready(function(){
			// var fusioncharts = new FusionCharts({
				// type: 'line',
				// renderAt: 'hargaJualDist',
				// width: '100%',
				// height: '300',
				// dataFormat: 'json',
				// dataSource: {
					// "chart": {
						// "theme": "fusion",
						// "caption": "Grafik Harga Jual Distributor <?php echo $TAHUN; ?>",
						// "subCaption": "",
						// "xAxisName": "Bulan",
						// "yAxisName": "Harga (Ribu) / TON",
						// "lineThickness": "2",
						// "bgColor": "#ffffff",
						// "showBorder": "0",
						// "drawcrossline": "1",
						// "showCanvasBorder": "0",
						// "formatNumberScale": "0",
						// "decimalSeparator": ",",
						// "thousandSeparator": ".",
						// "palettecolors": "#A8026F"
					// },
					// "data": <?php echo $TOTAL_JUAL; ?>,
					// "trendlines": [{
						// "line": [{
						  // "startvalue": "18500",
						  // "color": "#29C3BE",
						  // "displayvalue": "Average{br}weekly{br}footfall",
						  // "valueOnRight": "1",
						  // "thickness": "2"
						// }]
					// }]
				// }
			// });
			// fusioncharts.render();
		// });
	}
</script>
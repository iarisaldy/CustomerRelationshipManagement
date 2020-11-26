<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <a href=""></a>
                <div class="card">
					<div class="header bg-cyan">
                        <h2>GET Toko Baru</h2>
                    </div>
                    <div class="body">
                        <div class="row">
							<div class="col-md-12">
								
							</div>
                            <div class="container-fluid">
                            	<div class="col-md-6">
                            		<div id="Toko_smi"></div>
                            	</div>
                            	<div class="col-md-6">
                            		<div id="Toko_baru_smi"></div>
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
		
		Get_toko_baru();
		Toko_smi();

		//Toko_tidak_aktiv();
		// hargaJualDist();
		// salesDistributor();
	});


	function Get_toko_baru() {
		FusionCharts.ready(function() {
		  var visitChart = new FusionCharts({
			type: 'mscolumn2d',
			renderAt: 'Toko_baru_smi',
			width: '100%',
			height: '400',
			dataFormat: 'json',
			dataSource: {
			  "chart": {
				"theme": "fusion",
				"caption": "GET TOKO BARU",
				"subCaption": "",
				"xAxisName": "Bulan",
				"yAxisName": "Jumlah Toko",
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
				  "seriesname": "Pertumbuhan 2017",
				  "data": <?php echo $Get2017; ?>
				},
				{
				  "seriesname": "Pertumbuhan 2018",
				  "data": <?php echo $Get2018; ?>
				},
				{
				  "seriesname": "Pertumbuhan 2019",
				  "data": <?php echo $Get2019; ?>
				}
			  ],
			 //  "trendlines": [{
				// "line": [{
				//   "startvalue": "172",
				//   "color": "#62B58F",
				//   "valueOnRight": "1",
				//   "displayvalue": "Average"
				// },
				// {
				//   "startvalue": "1082",
				//   "color": "#62B58F",
				//   "valueOnCenter": "1",
				//   "displayvalue": "% 2018"
				// }]
			 //  }]
			}
		  }).render();
		});
	}

	function Toko_smi() {
		FusionCharts.ready(function() {
		  var visitChart = new FusionCharts({
			type: 'mscolumn2d',
			renderAt: 'Toko_smi',
			width: '100%',
			height: '400',
			dataFormat: 'json',
			dataSource: {
			  "chart": {
				"theme": "fusion",
				"caption": "Pertumbuhan Toko DISTRIBUTOR",
				"subCaption": "",
				"xAxisName": "Bulan",
				"yAxisName": "Jumlah Toko",
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
					"label": "2017"
				  },
				  {
					"label": "2018"
				  },
				  {
					"label": "2019"
				  }
				]
			  }],
			  "dataset": [{
				  "seriesname": "Pertumbuhan Toko",
				  "data": <?php echo $pertumbuhan_toko; ?>
				},
				{
				  "seriesname": "TOKO SMI",
				  "data": <?php echo $toko_smi; ?>
				}
				
			  ],
			 //  "trendlines": [{
				// "line": [{
				//   "startvalue": "172",
				//   "color": "#62B58F",
				//   "valueOnRight": "1",
				//   "displayvalue": "Average"
				// },
				// {
				//   "startvalue": "1082",
				//   "color": "#62B58F",
				//   "valueOnCenter": "1",
				//   "displayvalue": "% 2018"
				// }]
			 //  }]
			}
		  }).render();
		});
	}

	


</script>
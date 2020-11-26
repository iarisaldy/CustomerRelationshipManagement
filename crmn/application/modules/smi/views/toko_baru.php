<script src="<?php echo base_url(); ?>assets/js/plugins/highcharts/js/highcharts.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <a href=""></a>
                <div class="card">
					<div class="header bg-cyan">
                        <h2>Pertumbuhan Toko SMI</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                        	<!--
							<div class="col-md-12">
								<form action="" method="post">
	                        		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
	                        			<b>Provinsi</b>
	                        			<select data-size="5" id="filterBulan" name="filterBulan" class="form-control show-tick">
	                                        <option>Pilih Provinsi</option>
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
	                        			<b>AREA</b>
	                        			<select id="filterTahun" name="filterTahun" class="form-control show-tick">
	                                        <option>Pilih Area</option>
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
							</div>
							-->
							<div class="col-md-12">
								<div class="col-md-6">
                            		<div id="Toko_smi"></div>
                            	</div>
								<div class="container-fluid">
	                    			<div class="col-md-6">
		                    			<div id="container"></div>
		                    		</div>
	                    		</div>
							</div>
                            <div class="container-fluid">
                            	
                            	<div class="col-md-6">
                            		<div id="Toko_baru_smi"></div>
                            	</div>
                            	
                            	<div class="col-md-6">
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
		
		// Get_toko_baru();
		Toko_smi();

		//Toko_tidak_aktiv();
		// hargaJualDist();
		// salesDistributor();
	});

	var tahun2017 = [<?php echo $Get2017; ?>];
	var tahun2018 = [<?php echo $Get2018; ?>];
	var tahun2019 = [<?php echo $Get2019; ?>];
	Highcharts.chart('container', {
	    chart: {
	        type: 'column'
	       
	    },
	    title: {
	        text: 'GET TOKO BARU'
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
	 //    labels: {
		//     items: [{
		//       html: 'Total fruit consumption',
		//       style: {
		//         left: '50px',
		//         top: '18px',
		//         color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
		//       }
		//     }]
		// },
	    yAxis: {
	        min: 0,
	        title: {
	            text: 'Jumlah Toko'
	        }
	    },
	    plotOptions: {
	        column: {
	            pointPadding: 0.2,
	            borderWidth: 0
	        }
	    },
	    series: [{
	        name: '2017',
	        data: tahun2017

	    }, {
	        name: '2018',
	        data: tahun2018

	    }, {
	        name: '2019',
	        data: tahun2019

	    }
	 //    , {
		//     type: 'pie',
		//     name: 'Total consumption',
		//     data: [{
		//       name: '2017',
		//       y: 13,
		//       color: Highcharts.getOptions().colors[0] // Jane's color
		//     }, {
		//       name: '2018',
		//       y: 23,
		//       color: Highcharts.getOptions().colors[1] // John's color
		//     }, {
		//       name: '2019',
		//       y: 19,
		//       color: Highcharts.getOptions().colors[2] // Joe's color
		//     }],
		//     center: [100, 80],
		//     size: 100,
		//     showInLegend: false,
		//     dataLabels: {
		//       enabled: false
		//     }
		// }
		]
	});

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
				"caption": "Pertumbuhan Toko SMI",
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
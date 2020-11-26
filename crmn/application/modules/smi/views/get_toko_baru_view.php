<script src="<?php echo base_url(); ?>assets/js/plugins/highcharts/js/highcharts.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <a href=""></a>
                <div class="card">
					<div class="header bg-cyan">
                        <h2>Customer Retention </h2>
                    </div>
                    <div class="body">
                    	<div class="row">
                    		<div class="container-fluid">
                    			<div class="col-md-12">
	                    			<div id="container" style="width:100%; height:350px;"></div>
	                    		</div>
                    		</div>
                    		<div class="container-fluid">
                    			<div class="col-md-12">
	                    			<div id="container2"></div>
	                    		</div>
                    		</div>
                    	</div>
                        <div class="row">
                        	<!--
							<div class="col-md-12">
								
							</div>
                            <div class="container-fluid">
                            	<div class="col-md-6">
                            		<div id="Toko_aktiv_smi"></div>
                            	</div>
                            	<div class="col-md-6">
                            		<div id="Toko_tidak_aktiv"></div>
                            	</div>
                            	<div class="col-md-12">
                            		<div id="salesDistributor"></div>
                            	</div>
                            <div>
                            -->
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
	var tahun2017 = [<?php echo $data2017; ?>];
	var tahun2018 = [<?php echo $data2018; ?>];
	var tahun2019 = [<?php echo $data2019; ?>];
	Highcharts.chart('container', {
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'Toko Aktiv Dengan Penjualan > 0'
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
	            text: 'Jumlah Toko'
	        }
	    },
	    tooltip: {
	        headerFormat: '<span style="font-size:6px">{point.key}</span><table>',
	        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	            '<td style="padding:0"><b>{point.y:.0f} toko</b></td></tr>',
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
	    series: [{
	        name: '2017',
	        data: tahun2017

	    }, {
	        name: '2018',
	        data: tahun2018

	    }, {
	        name: '2019',
	        data: tahun2019

	    }]
	});

	var Nondata2017 = [<?php echo $Nondata2017; ?>];
	var Nondata2018 = [<?php echo $Nondata2018; ?>];
	var Nondata2019 = [<?php echo $Nondata2019; ?>];

	Highcharts.chart('container2', {
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'Toko Tidak Setor'
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
	            text: 'Jumlah Toko'
	        }
	    },
	    tooltip: {
	        headerFormat: '<span style="font-size:8px">{point.key}</span><table>',
	        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	            '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
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
	    series: [{
	        name: '2017',
	        data: Nondata2017

	    }, {
	        name: '2018',
	        data: Nondata2018

	    }, {
	        name: '2019',
	        data: Nondata2019

	    }]
	});

</script>

<script>
	// $("document").ready(function(){
	// 	//Toko_aktiv_smi();
	// 	//Toko_tidak_aktiv();
	// 	// hargaJualDist();
	// 	// salesDistributor();
	// });


	// function Toko_aktiv_smi() {
	// 	FusionCharts.ready(function() {
	// 	  var visitChart = new FusionCharts({
	// 		type: 'mscolumn2d',
	// 		renderAt: 'Toko_aktiv_smi',
	// 		width: '100%',
	// 		height: '400',
	// 		dataFormat: 'json',
	// 		dataSource: {
	// 		  "chart": {
	// 			"theme": "fusion",
	// 			"caption": "TOKO AKTIV SMI DENGAN PENJUALAN > 0",
	// 			"subCaption": "",
	// 			"xAxisName": "Bulan",
	// 			"yAxisName": "Jumlah Toko",
	// 			"showValues": "1",
	// 			"placeValuesInside": "1",
	// 			 "rotateValues": "1",
				 
	// 			 // "valueFont": "Arial",
	// 			  // "valueFontColor": "#ffffff",
	// 			  // "valueFontSize": "12",
	// 			  // "valueBgColor": "#cccccc",
	// 			  // "valueBgAlpha": "90",
				 
	// 		  },
	// 		  "categories": [{
	// 			"category": [{
	// 				"label": "Jan"
	// 			  },
	// 			  {
	// 				"label": "Feb"
	// 			  },
	// 			  {
	// 				"label": "Mar"
	// 			  },
	// 			  {
	// 				"label": "Apr"
	// 			  },
	// 			  {
	// 				"label": "May"
	// 			  },
	// 			  {
	// 				"label": "Jun"
	// 			  },
	// 			  {
	// 				"label": "Jul"
	// 			  },
	// 			  {
	// 				"label": "Aug"
	// 			  },
	// 			  {
	// 				"label": "Sep"
	// 			  },
	// 			  {
	// 				"label": "Oct"
	// 			  },
	// 			  {
	// 				"label": "Nov"
	// 			  },
	// 			  {
	// 				"label": "Dec"
	// 			  }
	// 			]
	// 		  }],
	// 		  "dataset": [{
	// 			  "seriesname": "2017",
	// 			  "data": <?php// echo $data2017; ?>
	// 			},
	// 			{
	// 			  "seriesname": "2018",
	// 			  "data": <?php //echo $data2018; ?>
	// 			},
	// 			{
	// 			  "seriesname": "2019",
	// 			  "data": <?php //echo $data2019; ?>
	// 			}
	// 		  ],
	// 		  // "trendlines": [{
	// 			// "line": [{
	// 			  // "startvalue": "17022",
	// 			  // "color": "#62B58F",
	// 			  // "valueOnRight": "1",
	// 			  // "displayvalue": "Average"
	// 			// }]
	// 		  // }]
	// 		}
	// 	  }).render();
	// 	});
	// }

	// function Toko_tidak_aktiv() {
	// 	FusionCharts.ready(function() {
	// 	  var visitChart = new FusionCharts({
	// 		type: 'mscolumn2d',
	// 		renderAt: 'Toko_tidak_aktiv',
	// 		width: '100%',
	// 		height: '400',
	// 		dataFormat: 'json',
	// 		dataSource: {
	// 		  "chart": {
	// 			"theme": "fusion",
	// 			"caption": "TOKO TIDAK SETOR",
	// 			"subCaption": "",
	// 			"xAxisName": "Bulan",
	// 			"yAxisName": "Jumlah Toko",
	// 			"showValues": "1",
	// 			"placeValuesInside": "1",
	// 			 "rotateValues": "1",
				 
	// 			 // "valueFont": "Arial",
	// 			  // "valueFontColor": "#ffffff",
	// 			  // "valueFontSize": "12",
	// 			  // "valueBgColor": "#cccccc",
	// 			  // "valueBgAlpha": "90",
				 
	// 		  },
	// 		  "categories": [{
	// 			"category": [{
	// 				"label": "Jan"
	// 			  },
	// 			  {
	// 				"label": "Feb"
	// 			  },
	// 			  {
	// 				"label": "Mar"
	// 			  },
	// 			  {
	// 				"label": "Apr"
	// 			  },
	// 			  {
	// 				"label": "May"
	// 			  },
	// 			  {
	// 				"label": "Jun"
	// 			  },
	// 			  {
	// 				"label": "Jul"
	// 			  },
	// 			  {
	// 				"label": "Aug"
	// 			  },
	// 			  {
	// 				"label": "Sep"
	// 			  },
	// 			  {
	// 				"label": "Oct"
	// 			  },
	// 			  {
	// 				"label": "Nov"
	// 			  },
	// 			  {
	// 				"label": "Dec"
	// 			  }
	// 			]
	// 		  }],
	// 		  "dataset": [{
	// 			  "seriesname": "2017",
	// 			  "data": <?php echo $Nondata2017; ?>
	// 			},
	// 			{
	// 			  "seriesname": "2018",
	// 			  "data": <?php echo $Nondata2018; ?>
	// 			},
	// 			{
	// 			  "seriesname": "2019",
	// 			  "data": <?php echo $Nondata2019; ?>
	// 			}
	// 		  ],
	// 		  // "trendlines": [{
	// 			// "line": [{
	// 			  // "startvalue": "17022",
	// 			  // "color": "#62B58F",
	// 			  // "valueOnRight": "1",
	// 			  // "displayvalue": "Average"
	// 			// }]
	// 		  // }]
	// 		}
	// 	  }).render();
	// 	});
	// }


</script>
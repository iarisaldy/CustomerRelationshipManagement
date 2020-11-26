<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
 <style>
.highcharts-figure, .highcharts-data-table table {
    min-width: 310px; 
    max-width: 800px;
    margin: 1em auto;
}

#pesertaChart {
    height: 418px;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2 style="padding-top: 0.2em;">Dashboard Level Stok</h2>
						
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid"> 
								
								<div class="body" >
									<div class="row">
										<div class="col-md-12"> 
											 <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
                                                <div class="form-group">
                                                    <div class="form-line" id="ListFilterBy"></div>
                                                </div>
                                            </div>
											<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
                                                <div class="form-group">
                                                    <div class="form-line" id="ListFilterSet"></div>
                                                </div>
                                            </div>
											
											<div class="col-md-2">
												Filter Tahun : 
												<select id="filterTahun" name="filterTahun" class="form-control show-tick" data-size="5">
													
													<?php for($j=date('Y')-4;$j<=date('Y');$j++){ ?>
													<option value="<?php echo $j; ?>" 
														<?php if($this->session->userdata("set_tahun") == $j){ 
																	echo "selected";
																} ?>>
													<?php echo $j; ?>
													</option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-2">
												Filter Bulan : 
												<select id="filterBulan" name="filterBulan" class="form-control show-tick" data-size="5">
													
													<option value="ALL">ALL</option>
													<?php 
													for($j=1;$j<=12;$j++){
														$dateObj   = DateTime::createFromFormat('!m', $j);
														$monthName = $dateObj->format('F');
														?>
														<option value="<?php echo $j; ?>"> <?php echo $monthName; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-2">
												Filter Minggu : 
												<select id="filterMinggu" name="filterMinggu" class="form-control show-tick" data-size="5">
													
													<option value="ALL">ALL</option>
													<?php 
													for($j=1;$j<=5;$j++){ 
														?>
														<option value="<?php echo $j; ?>">Minggu <?php echo $j; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-1">
												<br/>
												<button id="btnFilter" class="btn btn-success"><span class="fa fa-eye"></span>&nbsp; View</button>
											</div> 
										</div>
									</div> 				
									<div class="col-sm-12">
										<h4 class="card-title">Level Stok</h4>
										<figure class="highcharts-figure">
											 <div id="stokChart"></div>
										</figure>
									</div> 	 

									
								</div>
								
						
                               
							
                              
                                <!-- </div> -->
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
$(document).ready(function() {  
	ListFilterBy("#ListFilterBy");
	ListFilterSet();
	// monitoring()

	$("#btnFilter").click(function(){
	  monitoring()
	}); 
})

function monitoring(){
	var listFilterByVal = $("#listFilterByVal").val();
	var listFilterSetVal = $("#listFilterSetVal").val();
	var filterTahun = $("#filterTahun").val();
	var filterBulan = $("#filterBulan").val();
	var filterMinggu = $("#filterMinggu").val();
	
	$("#stokChart ").html('<tr><td colspan="20"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
			$.post("<?php echo base_url(); ?>dashboard/level_stok/monitoring", {  
				'listFilterByVal' : listFilterByVal,
				'listFilterSetVal' : listFilterSetVal,
				'filterTahun' : filterTahun,
				'filterBulan' : filterBulan,
				'filterMinggu' : filterMinggu,
				}, function (datas) {
				var data = JSON.parse(datas);
				 Highcharts.chart('stokChart', {
					chart: {
						type: 'column'
					},
					title: {
						text: 'Level Stok All'
					},
					subtitle: {
						text: ' '
					},
					xAxis: {
						categories: data.dataTitle,
						crosshair: true
					},
					yAxis: {
						min: 0,
						max : 100, 
						title : ''
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0"> </td>' +
							'<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
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
					showInLegend: false,
						data: data.dataValue 

					}]
				});
				 
			}).fail(function () {
				// show_toaster('2', "", 'Server Error') 
			}).always(function () {
				$(".selectpicker").selectpicker("refresh");
			}); 
}

function ListFilterBy(key){
	var type_list = 'Detail By :';
    type_list += '<select id="listFilterByVal" name="FilterBy" class="form-control selectpicker show-tick">';
    type_list += '<option value="1-REGION">REGION</option>';
	type_list += '<option value="2-PROVINSI">PROVINSI</option>';
	type_list += '<option value="3-DISTRIK">DISTRIK</option>';
	type_list += '<option value="4-AREA">AREA</option>'; 
    type_list += '</select>';
	
    $(key).html(type_list);
    $(".selectpicker").selectpicker("refresh");
}
 

function ListFilterSet(){
	var response;
	var key = "#ListFilterSet";
	var type_list = 'Brand :';
	type_list += '<select id="listFilterSetVal" name="FilterSet" class="form-control selectpicker show-tick" data-size="10" data-live-search="true">';
	 
		$.ajax({
            url: "<?php echo base_url(); ?>dashboard/level_stok/List_sig",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - ALL -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        }); 
}
</script>


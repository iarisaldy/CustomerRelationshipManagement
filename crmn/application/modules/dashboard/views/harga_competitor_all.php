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
                        <h2 style="padding-top: 0.2em;">Dashboard Harga Competitor</h2>
						
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid"> 
								
								<div class="body" >
									<div class="row">
										<div class="col-md-12"> 
											<div class="col-md-3">
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
													<div class="form-group">
														<div class="form-line" id="ListFilterBy"></div>
													</div>
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
													<div class="form-group">
														<div class="form-line" id="ListFilterSet"></div>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="col-md-6">
												Kemasan
												<select class="form-control selectpicker" data-live-search="true" data-size="10" id="kemasan">
													<option value="" data-hidden="true">-- Pilih kemasan --</option>
													<option value="50" >50</option>
													<option value="40" >40 </option>
													<option value="25" >25 </option> 
												</select>
												</div>
												<div class="col-md-6">
												Kategori
												<select class="form-control selectpicker" data-live-search="true" data-size="10" id="kategori">
													<option value="" data-hidden="true">-- Pilih Kategori --</option>
													<option value="SEMEN" >SEMEN</option>
													<option value="APP-SEMEN" >APP-SEMEN </option>
													<option value="SEMEN-PUTIH" >SEMEN-PUTIH </option> 
													<option value="NON-SEMEN" >NON-SEMEN </option> 
												</select>
												</div>
											</div>
											<div class="col-md-1">
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
									<div id='bungkus' style='display:none'>									
										<div class="col-sm-12">
											<h4 class="card-title">Monitoring Harga</h4>
											<div id='monitoring'></div>
										</div> 	
										<div class="col-sm-12"  id='cardPesertaDetail'>
											<h4 class="card-title">Harga Beli</h4>
											<figure class="highcharts-figure">
												 <div id="beliChart"></div>
											</figure>
										</div> 
										<div class="col-sm-12">
											<h4 class="card-title">Harga Jual</h4>
											<figure class="highcharts-figure">
												<div id="jualChart"></div> 
											</figure>
										</div> 
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
	ListFilterSet("0-ALL");
	// monitoring()

	$("#btnFilter").click(function(){
	  monitoring()
	  $("#bungkus").show();
	}); 
})

function monitoring(){ 
	var listFilterByVal = $("#listFilterByVal").val();
	var listFilterSetVal = $("#listFilterSetVal").val();
	var filterTahun = $("#filterTahun").val();
	var filterBulan = $("#filterBulan").val();
	var filterMinggu = $("#filterMinggu").val();
	var kemasan = $("#kemasan").val();
	var kategori = $("#kategori").val();
	
	$("#monitoring, #jualChart, #beliChart").html('<table><tr><td colspan="40"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr></table>');
			$.post("<?php echo base_url(); ?>dashboard/harga_competitor_all/monitoring", {
				'listFilterByVal' : listFilterByVal,
				'listFilterSetVal' : listFilterSetVal,
				'filterTahun' : filterTahun,
				'filterBulan' : filterBulan,
				'kemasan' : kemasan,
				'filterMinggu' : filterMinggu,
				'kategori' : kategori,
				}, function (datas) {
				var data = JSON.parse(datas);
				var html_data =  "<table style='font-size: 12px;' class='table table-striped table-bordered dataTable no-footer' id='tabel_monitoring' role='grid'><thead><tr><td>Produk</td><td>Harga Beli</td><td>Harga Jual</td><td>Margin</td><td>Gap Harga beli vs SG</td><td>Gap Harga beli vs Dynamix</td><td>Gap Harga beli vs SP</td><td>Gap Harga beli vs ST</td></thead></tr><tbody>"; 
				$.each(data.data, function(k, v) {
					var Bsp = parseInt(v["HARGA_BELI"])-parseInt(data.Bsp);
					var Bst = parseInt(v["HARGA_BELI"])-parseInt(data.Bst);
					var Bsg = parseInt(v["HARGA_BELI"])-parseInt(data.Bsg);
					var Bsbi = parseInt(v["HARGA_BELI"])-parseInt(data.Bsbi);
					html_data += "<tr><td>"+v["JENIS_PRODUK"]+"</td>";
					html_data += "<td>"+v["HARGA_BELI"]+"</td>";
					html_data += "<td>"+v["HARGA_JUAL"]+"</td>";
					html_data += "<td>"+v["MARGIN"]+"</td>";
					html_data += "<td>"+Bsg+"</td>";
					html_data += "<td>"+Bsbi+"</td>"; 
					html_data += "<td>"+Bsp+"</td>";
					html_data += "<td>"+Bst+"</td>";
					html_data += "</tr>"; 
				});  
				html_data += "</tbody></table>" 
				$("#monitoring").html(html_data)
				
				 $('#tabel_monitoring').DataTable({
					  "ordering": false
					} );
					
					
					Highcharts.chart('beliChart', { 
					title: {
						text: 'Harga Beli'
					},

					subtitle: {
						text: ' '
					},

					yAxis: {
						title: {
							text: 'Harga'
						}
					},

					xAxis: { 
						categories: data.labelBM,
							crosshair: true
					}, 

					legend: {
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom'
					},

					plotOptions: {
						series: {
							label: {
								connectorAllowed: false
							},
						}
					},

					series: data.GrafikBeli, 
					responsive: {
						rules: [{
							condition: {
								maxWidth: 500
							},
							chartOptions: {
								legend: {
									layout: 'horizontal',
									align: 'center',
									verticalAlign: 'bottom'
								}
							}
						}]
					}

				});
					Highcharts.chart('jualChart', { 
					title: {
						text: 'Harga Jual'
					},

					subtitle: {
						text: ' '
					},

					yAxis: {
						title: {
							text: 'Harga'
						}
					},

					xAxis: { 
						categories: data.labelBM,
							crosshair: true
					}, 

					legend: {
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom'
					},

					plotOptions: {
						series: {
							label: {
								connectorAllowed: false
							},
						}
					},

					series: data.GrafikJual, 
					responsive: {
						rules: [{
							condition: {
								maxWidth: 500
							},
							chartOptions: {
								legend: {
									layout: 'horizontal',
									align: 'center',
									verticalAlign: 'bottom'
								}
							}
						}]
					}

				});
			}).fail(function () {
				// show_toaster('2', "", 'Server Error') 
			}).always(function () {
				$(".selectpicker").selectpicker("refresh");
			}); 
}



function ListFilterBy(key){
	var type_list = 'Filter By :';
    type_list += '<select id="listFilterByVal" name="FilterBy" class="form-control selectpicker show-tick">';
    type_list += '<option value="0-ALL">ALL</option>';
    type_list += '<option value="1-REGION">REGION</option>';
	type_list += '<option value="2-PROVINSI">PROVINSI</option>';
	type_list += '<option value="3-DISTRIK">DISTRIK</option>';
	type_list += '<option value="4-AREA">AREA</option>';
	// type_list += '<option value="5-DISTRIBUTOR">DISTRIBUTOR</option>';
    type_list += '</select>';
	
    $(key).html(type_list);
    $(".selectpicker").selectpicker("refresh");
}

$(document).on("change", "#listFilterByVal", function(){
	var FilterBy = $(this).val();
	//console.log(FilterBy);
	ListFilterSet(FilterBy);
});

function ListFilterSet(pilihan){
	var response;
	var key = "#ListFilterSet";
	var type_list = 'Filter Set :';
	type_list += '<select id="listFilterSetVal" name="FilterSet" class="form-control selectpicker show-tick" data-size="10" data-live-search="true">';
	console.log(pilihan);
	if(pilihan == "0-ALL"){
		console.log('ALL');
		//type_list += '<option value="0">-</option>';
		type_list += '</select>';
		$(key).html(type_list);
		$(".selectpicker").selectpicker("refresh");
	} else if(pilihan == "1-REGION"){
		console.log('REGION');
		$.ajax({
            url: "<?php echo base_url(); ?>dashboard/harga_competitor_all/List_region",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected>- Pilih Regional -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'">'+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        });
	} else if(pilihan == "2-PROVINSI"){
		console.log('PROVINSI');
		$.ajax({
            url: "<?php echo base_url(); ?>dashboard/harga_competitor_all/List_provinsi",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Provinsi -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        });
	} else if(pilihan == "3-DISTRIK"){
		console.log('AREA');
		$.ajax({
            url: "<?php echo base_url(); ?>dashboard/harga_competitor_all/List_distrik",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Distrik -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        });
		
	} else if(pilihan == "4-AREA"){
		console.log('AREA');
		$.ajax({
            url: "<?php echo base_url(); ?>dashboard/harga_competitor_all/List_area",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Area -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        });
	}  
}

</script>


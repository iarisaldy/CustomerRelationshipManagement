<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				
				 <div class="card">
                    <div class="header bg-cyan">
                        <h2 style="padding-top: 0.2em;">PENJUALAN PER AREA <span style="float: right;" id="labelTotalToko">  </span></h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
								<div class="body" >
									<div class="row">
										<div class="col-md-12">
											<form method="post" action="<?php echo base_url();?>administrator/Home" enctype="multipart/form-data">
											<!--
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
												Filter Set:
												<select id="filterSet" name="filterSet" class="form-control show-tick" data-size="10">
													<option value="-">-</option>
												</select>
											</div>
											-->
											
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
												<select id="filterBulan" name="filterBulan" class="form-control show-tick" data-size="12">
													
													<?php 
													for($j=1;$j<=12;$j++){
														$dateObj   = DateTime::createFromFormat('!m', $j);
														$moon = '';
														if($j < 10){
															$moon = '0'.$j;
														} else {
															$moon = $j;
														}
														$monthName = '['.$moon.'] '.$dateObj->format('F');
														
														?>
														<option value="<?php echo $j; ?>" <?php if($j == $this->session->userdata("set_bulan")){ echo "selected";} ?>><?php echo $monthName; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-1">
												<br/>
												<button id="btnFilter" type="submit" class="btn btn-success"><span class="fa fa-eye"></span>&nbsp; View</button>
											</div>
											</form>
										</div>
									</div>
									<div class="col-md-12">
										<center>
											<div id="penjualan_area" width="100%" style="min-width: 100%; height: 450px; margin: 0"></div>
										</center>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
            </div>
        </div>
    </div>
</section>



<script>

$(document).ready(function(){
	ListFilterBy("#ListFilterBy");
	ListFilterSet("0-ALL");
});

function ListFilterBy(key){
	var type_list = 'Filter By :';
    type_list += '<select id="listFilterByVal" name="FilterBy" class="form-control selectpicker show-tick">';
    type_list += '<option value="0-ALL">ALL</option>';
    type_list += '<option value="1-REGION">REGION</option>';
	type_list += '<option value="2-PROVINSI">PROVINSI</option>';
	//type_list += '<option value="3">DISTRIK</option>';
	type_list += '<option value="4-AREA">AREA</option>';
	type_list += '<option value="5-DISTRIBUTOR">DISTRIBUTOR</option>';
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
            url: "<?php echo base_url(); ?>administrator/Home/List_region",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected>- Pilih Regional -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'">'+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        });
	} else if(pilihan == "2-PROVINSI"){
		console.log('PROVINSI');
		$.ajax({
            url: "<?php echo base_url(); ?>administrator/Home/List_provinsi",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Provinsi -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        });
	} else if(pilihan == "3-DISTRIK"){
		console.log('DISTRIK');
		
	} else if(pilihan == "4-AREA"){
		console.log('AREA');
		$.ajax({
            url: "<?php echo base_url(); ?>administrator/Home/List_area",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Area -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        });
	} else if(pilihan == "5-DISTRIBUTOR"){
		console.log('DISTRIBUTOR');
		$.ajax({
            url: "<?php echo base_url(); ?>administrator/Home/List_distributor",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Distributor -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        });
	}
}

$(document).on("change", "#listFilterSetVal", function(){
	var FilterSet = $(this).val();
	console.log(FilterSet);
});


// Grafik

var widthku = 87/100*screen.width;

<?php
	$dating = new DateTime();
	$dating->setDate($this->session->userdata("set_tahun"), $this->session->userdata("set_bulan"), 1);
?>

</script>

<script>

Highcharts.chart('penjualan_area', {
    chart: {
        type: 'column',
		width: widthku
    },
    title: {
        text: 'Grafik Penjualan Per Area'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '12px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah ( Item )'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Jumlah item: <b>{point.y:.f}</b>'
    },
    series: [{
		colorByPoint: true, 
        name: 'Total',
        data: [
			<?php
					$jmlTotToko = 0;
					$jmlDTstp = count($penjualan_area);
					$i = 0;
					foreach ($penjualan_area as $dtstp){
						$i++;
						echo '["'.$dtstp->NAMA_PROVINSI.'",'.$dtstp->POPULASI_TOKO.']';
						if($i != $jmlDTstp){
							echo ',';
						}
						$jmlTotToko += $dtstp->POPULASI_TOKO;
					}
			?>
			
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '12px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});

$('#labelTotalToko').text('[<?= number_format($jmlTotToko);?>]');


</script>
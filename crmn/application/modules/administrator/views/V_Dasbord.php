<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
 
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2 style="padding-top: 0.2em;">CUSTOMER RELATIONSHIP MANAGEMENT SMI GROUP</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
								<div class="body" style="margin: 0 1em 0 1em;">
										<div class="row">
											
											<div class="col-md-12">
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
														<div class="form-group">
															<div class="form-line">
																<b>Tanggal Awal</b>
																<input type="text" id="startDate" value="<?php echo date('Y-m-d', strtotime('-14 days')); ?>" class="form-control" placeholder="Tanggal Awal">
															</div>
														</div>
													</div>
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
														<div class="form-group">
															<div class="form-line">
																<b>Tanggal Akhir</b>
																<input type="text" id="endDate" value="<?php $currentDateTime = date('Y-m-d'); echo $currentDateTime; ?>" class="form-control" placeholder="Tanggal Akhir">
															</div>
														</div>
													</div>	
													<div class="col-md-1">
														<br/>
														<button id="btnFilter" class="btn btn-info"><span class="fa fa-eye"></span> View</button>
													</div>
													<div class="col-md-2" style="float: right;">
														<br/>
														<button style="float: right;" id="tombol_export_exel" class="btn btn-success"><span class="fa fa-file-excel-o"></span> Export to Excel </button>
													</div>
											</div>
											<div class="col-md-12">
											<div class="table-responsive">
											<table id="table_data" class="table table-striped table-bordered" cellspacing="0" width="100%" border="1" style="font-size:12px;">
												<thead>
													<tr>
														<th colspan="20"><span style="float:center;font-weight: normal; "><b>SUMMARY HARGA TEMBUS DAN HARGA PRODUK DI AREA 51</b></span>  </th>
														
														<th colspan="8"> Update Per : <b><?= date('d-m-Y', strtotime('-14 days')) ?></b> sd <b><?= date('d-m-Y') ?></b> <span style="float:right;"></span> </th>
													</tr>
													<tr>
														<th style="width: 5%; text-align: center; vertical-align: middle;" rowspan="2">No.</th>
														<th style="text-align: center; vertical-align: middle;" rowspan="4">PRODUK</th>
														<th style="text-align: center; background: #feca57;" colspan="12">HARGA TEMBUS</th>
														<th style="text-align: center; background: #a29bfe;" colspan="12">HARGA JUAL</th>
													</tr>
													<tr>
														<th style="text-align: center; background: #feca57;" colspan="4">HARGA MIN</th>
														<th style="text-align: center; background: #feca57;" colspan="4">RATA RATA</th>
														<th style="text-align: center; background: #feca57;" colspan="4">HARGA MAX</th>
														
														<th style="text-align: center; background: #a29bfe;" colspan="4">HARGA MIN</th>
														<th style="text-align: center; background: #a29bfe;" colspan="4">RATA RATA</th>
														<th style="text-align: center; background: #a29bfe;" colspan="4">HARGA MAX</th>
														
													</tr>
												</thead>
												<tbody>
													<tr>
														<td style="text-align: center;"></td>
														<td></td>
														
														<td></td>
														<td></td>
														<td style="text-align: center;"></td>
														
														<td></td>
														<td></td>
														<td style="text-align: center;"></td>
													</tr>
												</tbody>
											</table>
											<table id="table_data" class="table table-striped table-bordered" cellspacing="0" width="100%" border="1" style="font-size:12px;">
												<thead>
													<tr>
														<th colspan="20"><span style="float:center;font-weight: normal; "><b>SUMMARY HARGA TEMBUS DAN HARGA PRODUK DI AREA 52</b></span>  </th>
														
														<th colspan="8"> Update Per : <b><?= date('d-m-Y', strtotime('-14 days')) ?></b> sd <b><?= date('d-m-Y') ?></b> <span style="float:right;"></span> </th>
													</tr>
													<tr>
														<th style="width: 5%; text-align: center; vertical-align: middle;" rowspan="2">No.</th>
														<th style="text-align: center; vertical-align: middle;" rowspan="4">PRODUK</th>
														<th style="text-align: center; background: #feca57;" colspan="12">HARGA TEMBUS</th>
														<th style="text-align: center; background: #a29bfe;" colspan="12">HARGA JUAL</th>
													</tr>
													<tr>
														<th style="text-align: center; background: #feca57;" colspan="4">HARGA MIN</th>
														<th style="text-align: center; background: #feca57;" colspan="4">RATA RATA</th>
														<th style="text-align: center; background: #feca57;" colspan="4">HARGA MAX</th>
														
														<th style="text-align: center; background: #a29bfe;" colspan="4">HARGA MIN</th>
														<th style="text-align: center; background: #a29bfe;" colspan="4">RATA RATA</th>
														<th style="text-align: center; background: #a29bfe;" colspan="4">HARGA MAX</th>
														
													</tr>
												</thead>
												<tbody>
													<tr>
														<td style="text-align: center;"></td>
														<td></td>
														
														<td></td>
														<td></td>
														<td style="text-align: center;"></td>
														
														<td></td>
														<td></td>
														<td style="text-align: center;"></td>
													</tr>
												</tbody>
											</table>
											</div>
											</div>
										</div>
									</div>
								<div class="body" >
									<div class="row">
										<div class="col-md-12">
											<form method="post" action="<?php echo base_url();?>administrator/Home" enctype="multipart/form-data">
											
											<div class="col-md-2" 
											<?php if($this->session->userdata("id_jenis_user") != "1009"){ ?>
											style="display: none;"
											<?php } ?>
											>
												Filter SMI/SBI:
												<select id="filterGroup" name="filterGroup" class="form-control show-tick" data-size="2">
													
													<option value="SBI" <?php if($this->session->userdata("set_group") == "SBI"){ 
																	echo "selected";
																} ?>>SBI</option>
													<option value="SMI" <?php if($this->session->userdata("set_group") == "SMI"){ 
																	echo "selected";
																} ?>>SMI</option>
												</select>
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
													
													<?php 
													for($j=1;$j<=12;$j++){
														$dateObj   = DateTime::createFromFormat('!m', $j);
														$monthName = $dateObj->format('F');
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
										<div id="container1" width="100%" style="min-width: 100%; height: 450px; margin: 0"></div>
										</center>
										
									</div>
									<div class="col-md-12">
										
									</div>
								
									<table border="1" style="float:right; display: none;">
										<tr>
											<td width="50em" style="background: rgba(251, 197, 49,1.0);"></td><td>&nbsp;Target&nbsp;</td>
											<td width="50em" style="background: rgba(68, 189, 50,1.0);"><td>&nbsp;Realisasi&nbsp;</td>
										</tr>
									</table>
									<canvas id="line_chart" height="100" style="display: none;"></canvas>
								</div>
								
								
						
                                <div class="col-md-12">
                                    <div id="chart-container1"></div>
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
    var idUser = <?php echo $this->session->userdata("user_id"); ?>;

    $("document").ready(function(){
		$('#startDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#endDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        var bulan = <?php echo date('m')-1 ?>;
        var bulanSkrang = <?php echo date('m') ?>;
        var tahun = <?php echo date('Y') ?>;
        $.ajax({
            url: "<?php echo base_url() ?>administrator/Home/getIdentitas/"+idUser,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                var idJenisUser = <?php echo $this->session->userdata("id_jenis_user"); ?>;
                if(idJenisUser == "1002"){
                    var idProvinsi = data.data[0]["ID_PROVINSI"];
                } else {
                    var idProvinsi = data.data["ID_PROVINSI"];
                }
                
                //pieCharRetail(bulan, idProvinsi);
                //countDownCluster(bulanSkrang, idProvinsi);
            }
        });
        //speed();
        //nilaiKpi();
        //lineChart(bulanSkrang, tahun);
    });

</script>

<script>
$(function () {
    new Chart(document.getElementById("line_chart").getContext("2d"), getChartJs('line'));
	
});

function getChartJs(type) {
    var config = null;

    if (type === 'line') {
        config = {
            type: 'line',
            data: {
                //labels: ["01", "02", "03", "04", "05", "06", "07", "09", "10", "11", "12", "13", "14","15","16","17","18","19","20","21"],
				labels: [
					<?php
						$jmlDT = count($kunjungans);
						$i = 0;
						foreach ($kunjungans as $dtku){
							$i++;
							echo '"'.$dtku->TANGGAL.'"';
							if($i != $jmlDT){
								echo ',';
							}
						}
					?>
				],
                datasets: [{
                    label: "Target",
                    //data: [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56, 55, 40, 28, 48, 40, 19, 86, 27, 90],
					data: [
						<?php
						//$jmlDT = count($kunjungans);
						$i = 0;
						foreach ($kunjungans as $dtku){
							$i++;
							echo $dtku->TARGET;
							if($i != $jmlDT){
								echo ',';
							}
						}
					?>
					],
                    borderColor: 'rgba(251, 197, 49,1.0)',
                    backgroundColor: 'rgba(255, 234, 167,0.3)',
                    pointBorderColor: 'rgba(0, 188, 212, 0)',
                    pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                    pointBorderWidth: 1
                }, {
                        label: "Realisasi",
                        //data: [28, 48, 40, 19, 86, 27, 90, 65, 59, 10, 8, 5, 55, 40, 56, 55, 40, 28, 48, 40, 19],
						data: [
						<?php
						//$jmlDT = count($kunjungans);
						$i = 0;
						foreach ($kunjungans as $dtku){
							$i++;
							echo $dtku->REALISASI;
							if($i != $jmlDT){
								echo ',';
							}
						}
					?>
					],
                        borderColor: 'rgba(68, 189, 50,1.0)',
                        backgroundColor: 'rgba(85, 239, 196,0.3)',
                        pointBorderColor: 'rgba(233, 30, 99, 0)',
                        pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                        pointBorderWidth: 1
                    }]
            },
            options: {
				
					dataLabels: {
						enabled: true
					},
					
                responsive: true,
                legend: true
            }
        }
    }
    return config;
}

var widthku = 87/100*screen.width;

<?php
	$dating = new DateTime();
	$dating->setDate($this->session->userdata("set_tahun"), $this->session->userdata("set_bulan"), 1);
?>

	Highcharts.chart('container1', {
		chart: {
			type: 'line',
			width: widthku
		},
		title: {
			text: 'Grafik Kunjungan Harian Sales SMI GROUP'
		},
		subtitle: {
			text: '<?= $this->session->userdata("set_dist"); ?> [BULAN: <?= strtoupper($dating->format('F')); ?> - TAHUN: <?= $this->session->userdata("set_tahun"); ?>]'
		},
		xAxis: {
			categories: [
				<?php
					$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($kunjungans as $dtku){
						$i++;
						echo '"'.$dtku->TANGGAL.'"';
						if($i != $jmlDT){
							echo ',';
						}
					}
				?>
			]
		},
		yAxis: {
			title: {
				text: 'Jumlah Kunjungan (Kali)'
			}
		},
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				},
				enableMouseTracking: true
			}
		},
		series: [{
			name: 'Target',
			color: '#e67e22',
			lineColor: '#e67e22',
			data: [
				<?php
							//$jmlDT = count($kunjungans);
							$i = 0;
							foreach ($kunjungans as $dtku){
								$i++;
								echo $dtku->TARGET;
								if($i != $jmlDT){
									echo ',';
								}
							}
						?>
			]
		}, {
			name: 'Realisasi',
			color: '#3498db',
			lineColor: '#3498db',
			data: [
				<?php
							//$jmlDT = count($kunjungans);
							$i = 0;
							foreach ($kunjungans as $dtku){
								$i++;
								echo $dtku->REALISASI;
								if($i != $jmlDT){
									echo ',';
								}
							}
				?>
			]
		}]
	});
</script>
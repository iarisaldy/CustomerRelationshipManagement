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
                        <h2 style="padding-top: 0.2em;">Dashboard Home</h2>
						
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid"> 
								
								<div class="body" >
									<div class="row filterClass">
										<div class="col-md-12"> 
											<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
                                                <div class="form-group">
                                                    <div class="form-line" id="ListFilterBy1"></div>
                                                </div>
                                            </div>
											<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
                                                <div class="form-group">
                                                    <div class="form-line" id="ListFilterSet1"></div>
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
												
										<div class="col-sm-6">
											<h4 class="card-title">Hasil Survey Brand TR</h4>
											<figure class="highcharts-figure">
												 <div id="keluhanChart"></div>
											</figure>
										</div> 
										<div class="col-sm-6">
											<h4 class="card-title">Keluhan Brand TR</h4>
											<figure class="highcharts-figure">
												 <div id="daftarKeluhanChart"></div>
											</figure>
										</div> 	 
										<div class="col-sm-6">
											<h4 class="card-title">Hasil Survey Brand TR</h4>
											<figure class="highcharts-figure">
												 <div id="promosiChart"></div>
											</figure>
										</div> 
										<div class="col-sm-6">
											<h4 class="card-title">Promosi Brand TR</h4>
											<figure class="highcharts-figure">
												 <div id="daftarPromosiChart"></div>
											</figure>
										</div> 	 
									</div> 
									<div style="width:100%; height:34px; background-color: #ff0000;margin-bottom:20px;"><center><b><span style="color:white; font-size:24px;">DASHBOARD</span></b></center></div>
									<?php 
									$coverage_percentage = isset($coverage[0]["JUMLAH"]) && $coverage[0]["JUMLAH"] > 0 && isset($target[0]["COVERAGE"]) ? ($coverage[0]["JUMLAH"] > $target[0]["COVERAGE"] ? "100%" : number_format(($coverage[0]["JUMLAH"]/$target[0]["COVERAGE"])*100)."%") : "0%";
									$visit_percentage = isset($visit[0]["JUMLAH"]) && $visit[0]["JUMLAH"] > 0 && isset($visit[0]["TARGET"]) ? ($visit[0]["JUMLAH"] > $visit[0]["TARGET"] ? "100%" : number_format(($visit[0]["JUMLAH"]/$visit[0]["TARGET"])*100)."%") : "0%";
									$coverage_percentage2 = $coverage_percentage;
									$noo_percentage = isset($noo[0]["JUMLAH"]) && $noo[0]["JUMLAH"] > 0 && isset($target2[0]["NOO"]) ? ($noo[0]["JUMLAH"] > $target2[0]["NOO"] ? "100%" : number_format(($noo[0]["JUMLAH"]/$target2[0]["NOO"])*100)."%") : "0%";
									$sell_in_percentage = isset($sell_in[0]["JUMLAH"]) && $sell_in[0]["JUMLAH"] > 0 && isset($target[0]["SELL_IN"]) ? ($sell_in[0]["JUMLAH"] > $target[0]["SELL_IN"] ? "100%" : number_format(($sell_in[0]["JUMLAH"]/$target[0]["SELL_IN"])*100)."%") : "0%";
									$revenue_percentage = isset($revenue[0]["JUMLAH"]) && $revenue[0]["JUMLAH"] > 0 && isset($target[0]["REVENUE"]) ? ($revenue[0]["JUMLAH"] > $target[0]["REVENUE"] ? "100%" : number_format(($revenue[0]["JUMLAH"]/$target[0]["REVENUE"])*100)."%") : "0%";
									$sell_out_percentage = isset($sell_out[0]["JUMLAH"]) && $sell_out[0]["JUMLAH"] > 0 && isset($target[0]["SELL_OUT"]) ? ($sell_out[0]["JUMLAH"] > $target[0]["SELL_OUT"] ? "100%" : number_format(($sell_out[0]["JUMLAH"]/$target[0]["SELL_OUT"])*100)."%") : "0%";
									$so_cc_percentage = isset($so_cc[0]["JUMLAH"]) && $so_cc[0]["JUMLAH"] > 0 && isset($target[0]["SO_CC"]) ? ($so_cc[0]["JUMLAH"] > $target[0]["SO_CC"] ? "100%" : number_format(($so_cc[0]["JUMLAH"]/$target[0]["SO_CC"])*100)."%") : "0%";
									$acp_percentage = "0%";
									$average_percentage = number_format((intval($coverage_percentage)+intval($visit_percentage)+intval($coverage_percentage2)+intval($noo_percentage)+intval($sell_in_percentage)+intval($revenue_percentage)+intval($sell_out_percentage)+intval($so_cc_percentage)+intval($acp_percentage))/9)."%";
									?>
									<table border="1" cellspacing="0" cellpadding="0" width="100%" bordercolor="#fff">
										<tr>
											<td style="background-color: #00bcd4; text-align: center;vertical-align: middle;padding: 5px;position: relative; border:3px solid; border-color: #fff; width:50px;" rowspan="4" class="avg_persen">
												<span><?php echo $average_percentage; ?></span>
											</td>
											<td style="background-color: #538dd5; text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #fff; height: 70px;">
												<span style="color:white;font-size:32px"><?php echo isset($coverage[0]["JUMLAH"]) ?  number_format($coverage[0]["JUMLAH"]) : "0"; ?></span>
											</td>
											<td style="background-color: #538dd5; text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-color: #fff;">
												<span style="color:white;font-size:18px"><?php echo $coverage_percentage; ?></span>
											</td>
											<td style="background-color: #92d050; text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #fff;">
												<span style="color:white;font-size:32px"><?php echo isset($visit[0]["JUMLAH"]) ?  number_format($visit[0]["JUMLAH"]) : "0"; ?></span>
											</td>
											<td style="background-color: #92d050; text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-color: #fff;">
												<span style="color:white;font-size:18px"><?php echo $visit_percentage; ?></span>
											</td>
											<td style="background-color: #ffc000; text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #fff;">
												<span style="color:white;font-size:32px"><?php echo isset($coverage[0]["JUMLAH"]) ?  number_format($coverage[0]["JUMLAH"]) : "0"; ?></span>
											</td>
											<td style="background-color: #ffc000; text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-right:3px solid; border-color: #fff;">
												<span style="color:white;font-size:18px"><?php echo $coverage_percentage2; ?></span>
											</td>
										</tr>
										<tr style="height: 30px;">
											<td style="background-color: #538dd5; text-align: center;vertical-align: middle;position: relative;" colspan="2">
												<span style="color:white;font-size:12px">Coverage</span>
											</td>
											<td style="background-color: #92d050; text-align: center;vertical-align: middle;position: relative;" colspan="2">
												<span style="color:white;font-size:12px">Kunjungan Salesman</span>
											</td>
											<td style="background-color: #ffc000; text-align: center;vertical-align: middle;position: relative; width:20%;border-right:3px solid; border-color: #fff;" colspan="2">
												<span style="color:white;font-size:12px">Coverage</span>
											</td>
										</tr>
										<tr>
											<td style="background-color: #538dd5; text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid;  border-color: #fff;height: 70px;">
												<span style="color:white;font-size:32px"><?php echo isset($noo[0]["JUMLAH"]) ?  number_format($noo[0]["JUMLAH"]) : "0"; ?></span>
											</td>
											<td style="background-color: #538dd5; text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-color: #fff;">
												<span style="color:white;font-size:18px"><?php echo $noo_percentage; ?></span>
											</td>
											<td style="background-color: #92d050; text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #fff;">
												<span style="color:white;font-size:32px"><?php echo isset($sell_in[0]["JUMLAH"]) ?  number_format($sell_in[0]["JUMLAH"]) : "0"; ?></span>
											</td>
											<td style="background-color: #92d050; text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-color: #fff;">
												<span style="color:white;font-size:18px"><?php echo $sell_in_percentage; ?></span>
											</td>
											<td style="background-color: #ffc000; text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #fff;">
												<span style="color:white;font-size:32px"><?php echo isset($revenue[0]["JUMLAH"]) ?  number_format($revenue[0]["JUMLAH"]/1000000) : "0"; ?></span>
											</td>
											<td style="background-color: #ffc000; text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-right:3px solid; border-color: #fff;">
												<span style="color:white;font-size:18px"><?php echo $revenue_percentage; ?></span>
											</td>
										</tr>
										<tr style="height: 30px;">
											<td style="background-color: #538dd5; text-align: center;vertical-align: middle;position: relative;" colspan="2">
												<span style="color:white;font-size:12px">NOO</span>
											</td>
											<td style="background-color: #92d050; text-align: center;vertical-align: middle;position: relative;" colspan="2">
												<span style="color:white;font-size:12px">Sell In</span>
											</td>
											<td style="background-color: #ffc000; text-align: center;vertical-align: middle;position: relative; border-right:3px solid; border-color: #fff;" colspan="2">
												<span style="color:white;font-size:12px">Revenue (Juta)</span>
											</td>
										</tr>
										<tr>
											<td rowspan="2" style="background-color: #00bcd4; text-align: center;vertical-align: middle;padding: 5px;position: relative; border:3px solid; border-color: #fff;">
												<span>REG PROP AREA DISTRIK</span>
											</td>
											<td style="background-color: #538dd5; text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #fff; height: 70px;">
												<span style="color:white;font-size:32px"><?php echo isset($sell_out[0]["JUMLAH"]) ?  number_format($sell_out[0]["JUMLAH"]) : "0"; ?></span>
											</td>
											<td style="background-color: #538dd5; text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-color: #fff;">
												<span style="color:white;font-size:18px"><?php echo $sell_out_percentage; ?></span>
											</td>
											<td style="background-color: #92d050; text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #fff;">
												<span style="color:white;font-size:32px"><?php echo isset($so_cc[0]["JUMLAH"]) ?  number_format($so_cc[0]["JUMLAH"]) : "0"; ?></span>
											</td>
											<td style="background-color: #92d050; text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-color: #fff;">
												<span style="color:white;font-size:18px"><?php echo $so_cc_percentage; ?></span>
											</td>
											<td style="background-color: #ffc000; text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #fff;">
												<span style="color:white;font-size:32px">0</span>
											</td>
											<td style="background-color: #ffc000; text-align: center;vertical-align: middle; width:5%; border-top:3px solid;border-right:3px solid; border-color: #fff;">
												<span style="color:white;font-size:18px"><?php echo $acp_percentage; ?></span>
											</td>
										</tr>
										<tr style="height: 30px;">
											<td style="background-color: #538dd5; text-align: center;vertical-align: middle;position: relative; border-bottom:3px solid; border-color: #fff;" colspan="2">
												<span style="color:white;font-size:12px">Sell Out</span>
											</td>
											<td style="background-color: #92d050; text-align: center;vertical-align: middle;position: relative; border-bottom:3px solid; border-color: #fff;" colspan="2">
												<span style="color:white;font-size:12px">SO Clean & Clear</span>
											</td>
											<td style="background-color: #ffc000; text-align: center;vertical-align: middle;position: relative; border-bottom:3px solid; border-right:3px solid; border-color: #fff;" colspan="2">
												<span style="color:white;font-size:12px">APC (Hari)</span>
											</td>
										</tr>
									</table>									
								</div>
								
						
                               
							
                              
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
				<div class="card">
                    <div class="header bg-cyan">
                        <h2 style="padding-top: 0.2em;">PMB Salesman</h2>
						
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid"> 
								
								<div class="body" >			
									<div class="row">
										<div class="col-md-12"> 
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6" >
                                                <div class="form-group">
                                                    <div class="form-line" id="ListFilterBy_1"></div>
                                                </div>
                                            </div>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6" >
                                                <div class="form-group">
                                                    <div class="form-line" id="ListFilterSet_1"></div>
                                                </div>
                                            </div>
											<div class="col-lg-4 col-md-3 col-sm-3 col-xs-6" >
                                                <div class="form-group">
                                                    <div class="form-line">
														Filter Distributor :
														<select class='form-control selectpicker form-control-sm' data-live-search='false' data-size="10" id='listFilterDist'>
															<option value='' data-hidden='true' selected='selected'>-- Pilih Distributor --</option>
														</select>
													</div>
                                                </div>
                                            </div>
											
											<div class="col-md-3">
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
											<div class="col-md-3">
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
											<div class="col-md-4">
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
											<div class="col-md-2">
												<br/>
												<button id="btnFilter" class="btn btn-success"><span class="fa fa-eye"></span>&nbsp; View</button>
											</div> 
										</div>
										<div class="filterClass">		
										<div class="col-sm-6">
											<h4 class="card-title">Hasil Survey Brand TR</h4>
											<figure class="highcharts-figure">
												 <div id="keluhanChart"></div>
											</figure>
										</div> 
										<div class="col-sm-6">
											<h4 class="card-title">Keluhan Brand TR</h4>
											<figure class="highcharts-figure">
												 <div id="daftarKeluhanChart"></div>
											</figure>
										</div> 	 
										<div class="col-sm-6">
											<h4 class="card-title">Hasil Survey Brand TR</h4>
											<figure class="highcharts-figure">
												 <div id="promosiChart"></div>
											</figure>
										</div> 
										<div class="col-sm-6">
											<h4 class="card-title">Promosi Brand TR</h4>
											<figure class="highcharts-figure">
												 <div id="daftarPromosiChart"></div>
											</figure>
										</div> 
										</div>
										<div class="col-sm-12">
											<table id="tabel_sales" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th bgcolor="#538dd5" rowspan="2" style="width: 1%;">No.</th>
														<th bgcolor="#538dd5" rowspan="2">Salesman</th>
														<th bgcolor="#ffc000" colspan="3">Toko Unit (Coverage) (BK)</th>
														<th bgcolor="#92d050" colspan="3">Kunjungan Salesman</th>
														<th bgcolor="#ffc000" colspan="3">Toko Aktif (BK)</th>
														<th bgcolor="#ffc000" colspan="3">Toko Baru (NOO) (BK)</th>
														<th bgcolor="#92d050" colspan="3">Volume Selling Out (Sidigi)</th>
														<th bgcolor="#ffc000" colspan="3">Volume Selling Out (BK)</th>
													</tr>
													<tr>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
													</tr>
												</thead>
											</table>
										</div>
									</div> 
								</div>
								
						
                               
							
                              
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
				<div class="card">
                    <div class="header bg-cyan">
                        <h2 style="padding-top: 0.2em;">PMB Distributor</h2>
						
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid"> 
								
								<div class="body" >			
									<div class="row">
										<div class="col-md-12"> 
											 <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
                                                <div class="form-group">
                                                    <div class="form-line" id="ListFilterBy_2"></div>
                                                </div>
                                            </div>
											<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
                                                <div class="form-group">
                                                    <div class="form-line" id="ListFilterSet_2"></div>
                                                </div>
                                            </div>
											
											<div class="col-md-2">
												Filter Tahun : 
												<select id="filterTahun_dist" name="filterTahun_dist" class="form-control show-tick" data-size="5">
													
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
												<select id="filterBulan_dist" name="filterBulan_dist" class="form-control show-tick" data-size="5">
													
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
												<select id="filterMinggu_dist" name="filterMinggu_dist" class="form-control show-tick" data-size="5">
													
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
												<button id="btnFilter_dist" class="btn btn-success"><span class="fa fa-eye"></span>&nbsp; View</button>
											</div> 
										</div>
										<div class="col-sm-12">
											<table id="tabel_dist" style="font-size:12px;" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th bgcolor="#538dd5" rowspan="2" style="width: 1%;">No.</th>
														<th bgcolor="#538dd5" rowspan="2">Distributor</th>
														<th bgcolor="#ffc000" colspan="3">Toko Unit (Coverage) (BK)</th>
														<th bgcolor="#ffc000" colspan="3">Toko Aktif (BK)</th>
														<th bgcolor="#92d050" colspan="3">SO Clean & Clear (Ton)</th>
														<th bgcolor="#92d050" colspan="3">Volume (Sell In)</th>
														<th bgcolor="#92d050" colspan="3">Revenue (Juta)</th>
														<th bgcolor="#ffc000" colspan="3">Volume Selling Out (BK)</th>
														<th colspan="3">ACP (hari)</th>
													</tr>
													<tr>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
														<th>Target</th>
														<th>Actual</th>
														<th>%</th>
													</tr>
												</thead>
											</table>
										</div>
									</div> 
								</div>
								
						
                               
							
                              
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
				<div class="card">
                    <div class="header bg-cyan">
                        <h2 style="padding-top: 0.2em;">PMB Regional & Nasional</h2>
						
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid"> 
								
								<div class="body" >			
									<div class="row">
										<div class="col-sm-5">
											<div class="row">
												<div class="col-sm-12">
													<button id="btn_bk" onclick="show_region_bk();" class="btn btn-block btn-danger">Bisnis Kokoh</button>
													<table id="tabel_bk" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
															<tr bgcolor="#7f7f7f" style="color:white">
																<th>NASIONAL</th>
																<th>MAR</th>
																<th>APR</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Jumlah Toko Terdaftar</td>
																<td></td>
																<td></td>
															</tr>
															<tr>
																<td>Jumlah Toko Aktif (dengan IBK)</td>
																<td></td>
																<td></td>
															</tr>
															<tr>
																<td>Toko Baru</td>
																<td></td>
																<td></td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="col-sm-12">
													<button id="btn_sdg" onclick="show_region_sdg();" class="btn btn-block btn-danger">SIDIGI</button>
												</div>
												<div class="col-sm-12">
													<table id="tabel_sdg" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
															<tr bgcolor="#7f7f7f" style="color:white">
																<th>NASIONAL</th>
																<th>MAR</th>
																<th>APR</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Jumlah Toko Aktif (Semua Toko)</td>
																<td></td>
																<td></td>
															</tr>
															<tr>
																<td>Volume Sell Out</td>
																<td></td>
																<td></td>
															</tr>
															<tr>
																<td>% Level Stok Gudang Distributor</td>
																<td></td>
																<td></td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="col-sm-12">
													<button id="btn_crm" onclick="show_region_crm();" class="btn btn-block btn-danger">CRM Retail</button>
												</div>
												<div class="col-sm-12">
													<table id="tabel_crm" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
															<tr bgcolor="#7f7f7f" style="color:white">
																<th>NASIONAL</th>
																<th>MAR</th>
																<th>APR</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Jumlah Salesman Terdaftar</td>
																<td></td>
																<td></td>
															</tr>
															<tr>
																<td>Jumlah Salesman Berkunjung</td>
																<td></td>
																<td></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="col-sm-2">
										</div>
										<div class="col-sm-5">
											<div class="row regionDetail">
											<?php for($i=1; $i<=4; $i++) {?>
												<div class="col-sm-12">
													<button id="btn_reg_<?php echo $i; ?>" onclick="show_detail_region(<?php echo $i; ?>);" class="btn btn-block btn-danger">Region <?php echo $i; ?></button>
												</div>
												<div class="col-sm-12">
													<table id="tabel_reg<?php echo $i; ?>" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
															<tr bgcolor="#7f7f7f" style="color:white">
																<th>REGION <?php echo $i; ?></th>
																<th>MAR</th>
																<th>APR</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Jumlah Toko Terdaftar</td>
																<td></td>
																<td></td>
															</tr>
															<tr>
																<td>Jumlah Toko Aktif (dengan IBK)</td>
																<td></td>
																<td></td>
															</tr>
															<tr>
																<td>Volume Sell In</td>
																<td></td>
																<td></td>
															</tr>
															<tr>
																<td>Volume Sell Out</td>
																<td></td>
																<td></td>
															</tr>
														</tbody>
													</table>
												</div>
												<?php } ?>
											</div>
										</div>
									</div> 
								</div>
								
						
                               
							
                              
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="dlg_detail" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: #8c7ae6; padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title">Region  </h2>
			</div>
			<div class="modal-body">
				<table id="tabel_reg_dlg" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr bgcolor="#7f7f7f" style="color:white">
							<th>REGION</th>
							<th>MAR</th>
							<th>APR</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Jumlah Toko Terdaftar</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Jumlah Toko Baru</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Jumlah Toko Aktif (dengan IBK)</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Jumlah Toko Aktif (via Aksestoko)</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Jumlah Toko Aktif (semua toko)</td>
							<td></td>
							<td></td>
						</tr>
						
						<tr>
							<td>Jumlah Toko Non-VMS</td>
							<td></td>
							<td></td>
						</tr>
						
						<tr>
							<td>Jumlah Toko Lelang</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Total Volume Sell In (Ton)</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Total Volume Sell Out (Ton)</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Tot Vol Sell Out - via Aksestoko</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Tot Vol Sell Out - via ERP</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Total Revenue Sell Out (Rp)</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Tot Rev Sell Out - via Aksestoko</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Tot Rev Sell Out - via ERP</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>% Level Stock Gudang</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Jumlah Salesman Terdaftar</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Jumlah Salesman Berkunjung</td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var TabelData, TabelData2;
$(document).ready(function() { 
	$('.filterClass').hide();
	$('.regionDetail').hide();
	ListFilterBy("#ListFilterBy_1", 1);
	ListFilterBy("#ListFilterBy_2", 2);
	ListFilterSet("0-ALL", 1);
	ListFilterSet("0-ALL", 2);
	refreshDist();
	// monitoring()

	$("#btnFilter").click(function(){
	  // monitoring()
	}); 
	
	var listFilterByVal_dist = $("#listFilterByVal_2").val();
	var listFilterSetVal_dist = $("#listFilterSetVal_2").val();
	var filterTahun_dist = $("#filterTahun_dist").val();
	var filterBulan_dist = $("#filterBulan_dist").val();
	var filterMinggu_dist = $("#filterMinggu_dist").val();
	
	TabelData = $("#tabel_dist").DataTable({
			"processing": true,
			"serverSide": true,
			"recordsTotal": 20,
			"recordsFiltered": 20,
			"serverSide": true,
			"ajax": {
				"url": "<?php echo site_url(); ?>dashboard/pmb_dashboard/get_data_dist",
				"type": "POST"
			},
			"drawCallback": function(settings) {
				if(settings.aiDisplay.length > 0) {
					$(".btn-tooltip").tooltip({"trigger": "hover"});
				}
			},
			"order": [[1, "asc"]],
			"columnDefs": [
				{"targets": 0, "orderable": false},
				{"targets": 2, "orderable": false},
				{"targets": 3, "orderable": false},
				{"targets": 4, "orderable": false},
				{"targets": 5, "orderable": false},
				{"targets": 6, "orderable": false},
				{"targets": 7, "orderable": false},
				{"targets": 8, "orderable": false},
				{"targets": 9, "orderable": false},
				{"targets": 10, "orderable": false},
				{"targets": 11, "orderable": false},
				{"targets": 12, "orderable": false},
				{"targets": 13, "orderable": false},
				{"targets": 14, "orderable": false},
				{"targets": 15, "orderable": false},
				{"targets": 16, "orderable": false},
				{"targets": 17, "orderable": false},
				{"targets": 18, "orderable": false},
				{"targets": 19, "orderable": false},
				{"targets": 20, "orderable": false},
				{"targets": 21, "orderable": false},
				{"targets": 22, "orderable": false},
				{"targets": 20, "visible": false},
				{"targets": 21, "visible": false},
				{"targets": 22, "visible": false}
				// {"targets": 2, "visible": false},
			]
			// "dom": "<'row'<'col-sm-2'<l>><'col-sm-4'<'#tombol'>><'col-sm-6'f>><'row'<'col-sm-12'<'table-responsive't>r>><'row'<'col-sm-5'i><'col-sm-7'p>>"
		});
		
		TabelData2 = $("#tabel_sales").DataTable({
			"processing": true,
			"serverSide": true,
			"recordsTotal": 20,
			"recordsFiltered": 20,
			"serverSide": true,
			"ajax": {
				"url": "<?php echo site_url(); ?>dashboard/pmb_dashboard/get_data_sales",
				"type": "POST"
			},
			"drawCallback": function(settings) {
				if(settings.aiDisplay.length > 0) {
					$(".btn-tooltip").tooltip({"trigger": "hover"});
				}
			},
			"order": [[1, "asc"]],
			"columnDefs": [
				{"targets": 0, "orderable": false},
				{"targets": 2, "orderable": false},
				{"targets": 3, "orderable": false},
				{"targets": 4, "orderable": false},
				{"targets": 5, "orderable": false},
				{"targets": 6, "orderable": false},
				{"targets": 7, "orderable": false},
				{"targets": 8, "orderable": false},
				{"targets": 9, "orderable": false},
				{"targets": 10, "orderable": false},
				{"targets": 11, "orderable": false},
				{"targets": 12, "orderable": false},
				{"targets": 13, "orderable": false},
				{"targets": 14, "orderable": false},
				{"targets": 15, "orderable": false},
				{"targets": 16, "orderable": false},
				{"targets": 17, "orderable": false},
				{"targets": 18, "orderable": false},
				{"targets": 19, "orderable": false}
				// {"targets": 2, "visible": false},
			]
			// "dom": "<'row'<'col-sm-2'<l>><'col-sm-4'<'#tombol'>><'col-sm-6'f>><'row'<'col-sm-12'<'table-responsive't>r>><'row'<'col-sm-5'i><'col-sm-7'p>>"
		});
})

function show_region_bk() {
	$('.regionDetail').hide();
	$('.regionDetail').show();
}
function show_region_sdg() {
	$('.regionDetail').hide();
	$('.regionDetail').show();
}
function show_region_crm() {
	$('.regionDetail').hide();
	$('.regionDetail').show();
}
function show_detail_region(num) {
	$('#dlg_detail').modal("show");
}

// function monitoring(){
// 	var listFilterByVal = $("#listFilterByVal").val();
// 	var listFilterSetVal = $("#listFilterSetVal").val();
// 	var filterTahun = $("#filterTahun").val();
// 	var filterBulan = $("#filterBulan").val();
// 	var filterMinggu = $("#filterMinggu").val();
	
// 	$("#keluhanChart, #daftarKeluhanChart, #promosiChart, #daftarPromosiChart").html('<tr><td colspan="20"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
// 			$.post("<?php echo base_url(); ?>dashboard/keluhan/monitoring", {  
// 				'listFilterByVal' : listFilterByVal,
// 				'listFilterSetVal' : listFilterSetVal,
// 				'filterTahun' : filterTahun,
// 				'filterBulan' : filterBulan,
// 				'filterMinggu' : filterMinggu,
// 				}, function (datas) {
// 				var data = JSON.parse(datas);
// 				console.log(data.keluhan )
// 				Highcharts.chart('keluhanChart', {
// 					chart: {
// 						plotBackgroundColor: null,
// 						plotBorderWidth: null,
// 						plotShadow: false,
// 						type: 'pie'
// 					},
// 					title: {
// 						text: 'Keluhan Brand'
// 					},
// 					tooltip: {
// 						pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
// 					},
// 					accessibility: {
// 						point: {
// 							valueSuffix: '%'
// 						}
// 					},
// 					plotOptions: {
// 						pie: {
// 							allowPointSelect: true,
// 							cursor: 'pointer',
// 							dataLabels: {
// 								enabled: true,
// 								 format: '<b>{point.percentage:.1f} %'
// 							},
// 							showInLegend: true
// 						}
// 					},
// 					colors: ['#5B9CD6', '#ED7D31'],
// 					series: [{
// 						name: 'Total',
// 						colorByPoint: true,
// 						data: data.keluhan 
// 					}]
// 				});
				
				
// 				Highcharts.chart('daftarKeluhanChart', {
// 					chart: {
// 						type: 'bar'
// 					},
// 					title: {
// 						text: 'Daftar Keluhan Brand'
// 					},
// 					xAxis: {
// 						categories: data.daftarKeluhan,
// 						title: {
// 							text: null
// 						}
// 					},
// 					yAxis: {
// 						min: 0,
// 						title: {
// 							text: 'Jumlah Keluhan',
// 							align: 'high'
// 						},
// 						labels: {
// 							overflow: 'justify'
// 						}
// 					},
// 					tooltip: {
// 						valueSuffix: ' Keluhan'
// 					},
// 					plotOptions: {
// 						bar: {
// 							dataLabels: {
// 								enabled: true
// 							}
// 						}
// 					},
// 					credits: {
// 						enabled: false
// 					},
// 					series: [{
// 						name: 'Jumlah Keluhan',
// 						data: data.dataDaftarKeluhan
// 					}]
// 				});
				
// 				Highcharts.chart('promosiChart', {
// 					chart: {
// 						plotBackgroundColor: null,
// 						plotBorderWidth: null,
// 						plotShadow: false,
// 						type: 'pie'
// 					},
// 					title: {
// 						text: 'Promosi Brand'
// 					},
// 					tooltip: {
// 						pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
// 					},
// 					accessibility: {
// 						point: {
// 							valueSuffix: '%'
// 						}
// 					},
// 					plotOptions: {
// 						pie: {
// 							allowPointSelect: true,
// 							cursor: 'pointer',
// 							dataLabels: {
// 								enabled: true,
// 								 format: '<b>{point.percentage:.1f} %'
// 							},
// 							showInLegend: true
// 						}
// 					},
// 					colors: ['#5B9CD6', '#ED7D31'],
// 					series: [{
// 						name: 'Total',
// 						colorByPoint: true,
// 						data: data.promosi 
// 					}]
// 				});
				
				
// 				Highcharts.chart('daftarPromosiChart', {
// 					chart: {
// 						type: 'bar'
// 					},
// 					title: {
// 						text: 'Daftar Promosi Brand'
// 					},
// 					xAxis: {
// 						categories: data.daftarPromosi,
// 						title: {
// 							text: null
// 						}
// 					},
// 					yAxis: {
// 						min: 0,
// 						title: {
// 							text: 'Jumlah Promosi',
// 							align: 'high'
// 						}
// 						// stacking: 'percent',
// 						// dataLabels: {
// 							// enabled: true, 
// 							// formatter: function() {
// 								// var pcnt = (this.y / this.series.data.map(p => p.y).reduce((a, b) => a + b, 0)) * 100;
// 								// return Highcharts.numberFormat(pcnt) + '%';
// 							// }
// 						// }
// 					},
// 					tooltip: {
// 						pointFormat: false
// 					},
// 					plotOptions: {
// 						bar: {
// 							// stacking: 'percent',
// 							dataLabels: {
// 								enabled: true,
// 								// formatter: function() {
// 									// var pcnt = (this.y / this.series.data.map(p => p.y).reduce((a, b) => a + b, 0)) * 100;
// 									// return Highcharts.numberFormat(pcnt) + '%';
// 								// }
// 							}
// 						}
// 					},
// 					// legend: {
// 						// layout: 'vertical',
// 						// align: 'right',
// 						// verticalAlign: 'top',
// 						// x: -40,
// 						// y: 80,
// 						// floating: true,
// 						// borderWidth: 1,
// 						// backgroundColor:
// 							// Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
// 						// shadow: true
// 					// },
// 					credits: {
// 						enabled: false
// 					},
// 					series: [{
// 						name: 'Jumlah Promosi',
// 						data: data.dataDaftarPromosi
// 					}]
// 				});
// 			}).fail(function () {
// 				// show_toaster('2', "", 'Server Error') 
// 			}).always(function () {
// 				$(".selectpicker").selectpicker("refresh");
// 			}); 
// }

function refreshDist() {
		$.post("<?php echo site_url(); ?>dashboard/pmb_dashboard/refreshDist", function(data) {
			$("#listFilterDist").html(data);
		}).fail(function() {
			// Nope
		}).always(function() {
			// $("#listFilterDist").val(id);
			$(".selectpicker").selectpicker("refresh");
		});
	}
	
function ListFilterBy(key, id){
	var type_list = 'Filter By :';
    type_list += '<select id="listFilterByVal_'+id+'" name="FilterBy" class="form-control selectpicker show-tick">';
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

$(document).on("change", "#listFilterByVal_1", function(){
	var FilterBy = $(this).val();
	//console.log(FilterBy);
	ListFilterSet(FilterBy, 1);
});
$(document).on("change", "#listFilterByVal_2", function(){
	var FilterBy = $(this).val();
	//console.log(FilterBy);
	ListFilterSet(FilterBy, 2);
});

function ListFilterSet(pilihan, id){
	var response;
	var key = "#ListFilterSet_"+id;
	var type_list = 'Filter Set :';
	type_list += '<select id="listFilterSetVal'+id+'" name="FilterSet" class="form-control selectpicker show-tick" data-size="10" data-live-search="true">';
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
            url: "<?php echo base_url(); ?>dashboard/keluhan/List_region",
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
            url: "<?php echo base_url(); ?>dashboard/keluhan/List_provinsi",
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
            url: "<?php echo base_url(); ?>dashboard/keluhan/List_distrik",
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
            url: "<?php echo base_url(); ?>dashboard/keluhan/List_area",
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


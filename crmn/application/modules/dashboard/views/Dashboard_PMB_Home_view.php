
<?php 
$coverage_percentage = isset($coverage[0]["JUMLAH"]) && $coverage[0]["JUMLAH"] > 0 && isset($target[0]["COVERAGE"]) ? ($coverage[0]["JUMLAH"] > $target[0]["COVERAGE"] ? "100%" : number_format(($coverage[0]["JUMLAH"]/$target[0]["COVERAGE"])*100)."%") : "0%";

$visit_percentage = isset($visit[0]["JUMLAH"]) && $visit[0]["JUMLAH"] > 0 && isset($visit[0]["TARGET"]) ? ($visit[0]["JUMLAH"] > $visit[0]["TARGET"] ? "100%" : number_format(($visit[0]["JUMLAH"]/$visit[0]["TARGET"])*100)."%") : "0%";

$tokoaktif_percentage = isset($sell_out[0]["TA"]) && $sell_out[0]["TA"] > 0 && isset($target[0]["TA"]) ? ($sell_out[0]["TA"] > $target[0]["TA"] ? "100%" : number_format(($sell_out[0]["TA"]/$target[0]["TA"])*100)."%") : "0%";

$noo_percentage = isset($noo[0]["JUMLAH"]) && $noo[0]["JUMLAH"] > 0 && isset($target2[0]["NOO"]) ? ($noo[0]["JUMLAH"] > $target2[0]["NOO"] ? "100%" : number_format(($noo[0]["JUMLAH"]/$target2[0]["NOO"])*100)."%") : "0%";

$sell_in_percentage = isset($sell_in[0]["JUMLAH"]) && $sell_in[0]["JUMLAH"] > 0 && isset($target[0]["SELL_IN"]) ? ($sell_in[0]["JUMLAH"] > $target[0]["SELL_IN"] ? "100%" : number_format(($sell_in[0]["JUMLAH"]/$target[0]["SELL_IN"])*100)."%") : "0%";

$revenue_percentage = isset($revenue[0]["JUMLAH"]) && $revenue[0]["JUMLAH"] > 0 && isset($target[0]["REVENUE"]) ? ($revenue[0]["JUMLAH"] > $target[0]["REVENUE"] ? "100%" : number_format(($revenue[0]["JUMLAH"]/$target[0]["REVENUE"])*100)."%") : "0%";

$sell_out_percentage = isset($sell_out[0]["JUMLAH"]) && $sell_out[0]["JUMLAH"] > 0 && isset($target[0]["SELL_OUT"]) ? ($sell_out[0]["JUMLAH"] > $target[0]["SELL_OUT"] ? "100%" : number_format(($sell_out[0]["JUMLAH"]/$target[0]["SELL_OUT"])*100)."%") : "0%";

$so_cc_percentage = '0%';

$acp_percentage = "0%";


// print_r('<pre>');
// print_r($arr_grafik);exit;


// print_r('<pre>');
// print_r($arr_grafik_per);exit;

?>
<style type="text/css">
	.donutContainer {
	    position: relative;
	    float: center;
	}

	.donutContainer h2 {
	    text-align:center;
	    position: absolute;
	    line-height: 125px;
	    width: 100%;
	}

	svg {
	    transform: rotate(-90deg);
	}

	.donut {
	  stroke-dasharray: 440;
	  -webkit-animation: donut 1s ease-out forwards;
	  animation: donut 1s ease-out forwards;
	}

	@-webkit-keyframes donut {
	  from {
	    stroke-dashoffset: 440;
	  }
	}

	@keyframes donut {
	  from {
	    stroke-dashoffset: 440;
	  }
	}
</style>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
	            <div class="card" style="padding-bottom: 0;">
					<div class="header bg-cyan">
	                    <h2 style="padding-top: 0.2em;">PMB DASHBOARD</h2>
	                </div>
						
	                <div class="body">
	                    <div class="row">
							<div class="col-md-12">
								<div>
									<ul class="nav nav-tabs" role="tablist">
										<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><b>HOME</b></a></li>
									</ul>
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane fade in active" id="home">
											<h4>
												<button id="nas_reg_page" style="float: right; margin-left: 1em;" class="btn btn-primary">Nasional & Regional</button>
												<button id="sls_dis_page" style="float: right; margin-left: 1em;" class="btn btn-primary">Salesman & Distributor</button>
												<button id="home_page" style="float: right; margin-left: 1em; background-color: grey; color: white;" class="btn btn" disabled>Home</button>
												<span>Home PMB Dashboard</span>
											</h4>
											<br>
											<div class="row">
												<div class="col-md-12">
													<form method="post" action="<?php echo base_url();?>dashboard/Dashboard_PMB/PMB_Home" enctype="multipart/form-data">
														<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
			                                                <div class="form-group">
			                                                    <div class="form-line" id="ListFilterBy3"></div>
			                                                </div>
			                                            </div>
														<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
			                                                <div class="form-group">
			                                                    <div class="form-line" id="ListFilterSet3"></div>
			                                                </div>
			                                            </div>
														<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
															Filter Tahun : 
															<select id="Tahun3" name="Tahun3" class="form-control show-tick" data-size="5">
																
																<?php for($j=date('Y')-4;$j<=date('Y');$j++){ ?>
																<option value="<?php echo $j; ?>" 
																	<?php if($tahun == $j){ 
																				echo "selected";
																			} ?>>
																<?php echo $j; ?>
																</option>
																<?php } ?>
															</select>
														</div>
														<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
															Filter Bulan : 
															<select id="Bulan3" name="Bulan3" class="form-control show-tick" data-size="12">
																
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
																<option value="<?php echo $j; ?>" <?php if($j == $bulan){ echo "selected";} ?>><?php echo $monthName; ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="col-md-1">
															<br/>
															<button id="btnFilter3" type="submit" class="btn btn-info"><span class="fa fa-eye"></span>&nbsp; View</button>
														</div>
													</form>
												</div>
											</div>
											<hr>
											<div style="text-align: center; position: relative;">
												<span>[FILTER BY: <b><?php echo $FilterBy; ?></b> - FILTER SET: <b><?php echo $FilterSet; ?></b>] - [BULAN: <b><?php echo strtoupper(date('M',strtotime($tahun.'-'.$bulan))); ?></b> - TAHUN: <b><?php echo $tahun; ?></b>]</span>
											</div>
											<hr>
											<div class="table-responsive">
												<table class="table table-striped table-bordered dataTable no-footer" border="0" cellspacing="0" cellpadding="0" width="100%" bordercolor="#000" style="background-image: url(<?php echo base_url(); ?>assets/img/background_pmb_home3.jpg); background-position:center center; background-repeat:no-repeat; width: 100%; height: auto;">
													<tr style="background-color: transparent;">
														<td width="25%" rowspan="6" style="text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-bottom:3px solid; border-left:3px solid; border-right:3px solid; border-color: #000;">
															<div class="donutContainer css">
															    <h2><?php echo $prsn_HariKerja; ?>%</h2>
															    <svg width="160" height="160" xmlns="http://www.w3.org/2000/svg">
															     <g>
															      <title>Layer 1</title>
															      <circle id="circle" style="stroke-dashoffset: <?php echo $chart_HariKerja; ?>;/* 160 of 440 */" class="donut" r="69.85699" cy="81" cx="81" stroke-width="10" stroke="#00bcd4" fill="none"/>
															     </g>
															    </svg>
															</div>
															
												            <!-- DONUT CHART -->
											                <!-- <canvas id="donutChart" style="height:100px; min-height:100px; vertical-align: middle;"></canvas> -->
															<!-- <span><?php echo $hari_kerja; ?></span> -->
														</td>
														<td width="20%" style="text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #000; height: 70px;">
															<span style="color: black;font-size:32px"><?php echo isset($coverage[0]["JUMLAH"]) ?  number_format($coverage[0]["JUMLAH"]) : "0"; ?></span>
														</td>
														<td width="5%" style="text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-color: #000;">
															<span style="color:black;font-size:18px"><?php echo $coverage_percentage; ?></span>
														</td>
														<td width="20%" style="text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #000;">
															<span style="color:black;font-size:32px"><?php echo isset($visit[0]["JUMLAH"]) ?  number_format($visit[0]["JUMLAH"],2) : "0"; ?></span>
														</td>
														<td width="5%" style="text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-color: #000;">
															<span style="color:black;font-size:18px"><?php echo $visit_percentage; ?></span>
														</td>
														<td width="20%" style="text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #000;">
															<span style="color:black;font-size:32px"><?php echo isset($sell_out[0]["TA"]) ?  number_format($sell_out[0]["TA"]) : "0"; ?></span>
														</td>
														<td width="5%" style="text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-right:3px solid; border-color: #000;">
															<span style="color:black;font-size:18px"><?php echo $tokoaktif_percentage; ?></span>
														</td>
													</tr>
													<tr style="height: 30px; background-color: transparent;">
														<td style="text-align: center;vertical-align: middle;position: relative; border-color: #000;" colspan="2">
															<span style="color:black;font-size:12px">Coverage</span>
														</td>
														<td style="text-align: center;vertical-align: middle;position: relative; border-color: #000;" colspan="2">
															<span style="color:black;font-size:12px">Kunjungan Salesman</span>
														</td>
														<td style="text-align: center;vertical-align: middle;position: relative; width:20%;border-right:3px solid; border-color: #000;" colspan="2">
															<span style="color:black;font-size:12px">Toko Aktif</span>
														</td>
													</tr>
													<tr style="background-color: transparent;">
														<td style="text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid;  border-color: #000;height: 70px;">
															<span style="color:black;font-size:32px"><?php echo isset($noo[0]["JUMLAH"]) ?  number_format($noo[0]["JUMLAH"]) : "0"; ?></span>
														</td>
														<td style="text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-color: #000;">
															<span style="color:black;font-size:18px"><?php echo $noo_percentage; ?></span>
														</td>
														<td style="text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #000;">
															<span style="color:black;font-size:32px"><?php echo isset($sell_in[0]["JUMLAH"]) ?  number_format($sell_in[0]["JUMLAH"],2) : "0"; ?></span>
														</td>
														<td style="text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-color: #000;">
															<span style="color:black;font-size:18px"><?php echo $sell_in_percentage; ?></span>
														</td>
														<td style="text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #000;">
															<span style="color:black;font-size:32px"><?php echo isset($revenue[0]["JUMLAH"]) ?  number_format($revenue[0]["JUMLAH"],2) : "0"; ?></span>
														</td>
														<td style="text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-right:3px solid; border-color: #000;">
															<span style="color:black;font-size:18px"><?php echo $revenue_percentage; ?></span>
														</td>
													</tr>
													<tr style="height: 30px; background-color: transparent;">
														<td style="text-align: center;vertical-align: middle;position: relative; border-color: #000;" colspan="2">
															<span style="color:black;font-size:12px">NOO</span>
														</td>
														<td style="text-align: center;vertical-align: middle;position: relative; border-color: #000;" colspan="2">
															<span style="color:black;font-size:12px">Sell In</span>
														</td>
														<td style="text-align: center;vertical-align: middle;position: relative; border-right:3px solid; border-color: #000;" colspan="2">
															<span style="color:black;font-size:12px">Revenue (Juta)</span>
														</td>
													</tr>
													<tr style="background-color: transparent;">
														<td style="text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #000; height: 70px;">
															<span style="color:black;font-size:32px"><?php echo isset($sell_out[0]["JUMLAH"]) ?  number_format($sell_out[0]["JUMLAH"],2) : "0"; ?></span>
														</td>
														<td style="text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-color: #000;">
															<span style="color:black;font-size:18px"><?php echo $sell_out_percentage; ?></span>
														</td>
														<td style="text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #000;">
															<span style="color:black;font-size:32px">0</span>
														</td>
														<td style="text-align: center;vertical-align: middle; width:5%; border-top:3px solid; border-color: #000;">
															<span style="color:black;font-size:18px"><?php echo $so_cc_percentage; ?></span>
														</td>
														<td style="text-align: center;vertical-align: middle;padding: 5px;position: relative; border-top:3px solid; border-color: #000;">
															<span style="color:black;font-size:32px">0</span>
														</td>
														<td style="text-align: center;vertical-align: middle; width:5%; border-top:3px solid;border-right:3px solid; border-color: #000;">
															<span style="color:black;font-size:18px"><?php echo $acp_percentage; ?></span>
														</td>
													</tr>
													<tr style="height: 30px; background-color: transparent;";">
														<td style="text-align: center;vertical-align: middle;position: relative; border-bottom:3px solid; border-color: #000;" colspan="2">
															<span style="color:black;font-size:12px">Sell Out</span>
														</td>
														<td style="text-align: center;vertical-align: middle;position: relative; border-bottom:3px solid; border-color: #000;" colspan="2">
															<span style="color:black;font-size:12px">SO Clean & Clear</span>
														</td>
														<td style="text-align: center;vertical-align: middle;position: relative; border-bottom:3px solid; border-right:3px solid; border-color: #000;" colspan="2">
															<span style="color:black;font-size:12px">APC (Hari)</span>
														</td>
													</tr>
												</table>
											</div>
										</div>
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

<!-- End Bootstrap modal mapping distributor -->

<script src="<?php echo base_url(); ?>assets/chartjs2/Chart.min.js"></script>
<script type="text/javascript">

var d = new Date();
var FilterBy = '0-ALL';
var FilterSet = 'ALL';

var tahun1  = $('#tahun1').val();
var bulan1 	= $('#bulan1').val();
var tahun2  = $('#tahun2').val();
var bulan2 	= $('#bulan2').val();
var FilterBy2 	= '0-ALL';
var FilterSet2 	= 'ALL';

var FilterBy3 	= '0-ALL';
var FilterSet3 	= 'ALL';

var ftr_set = '<?php echo $Fset; ?>';
var substr3 = ftr_set.substr(0, 4);

var jns_user = '<?php echo $jenis_user; ?>';

$(document).ready(function(){
	$('.regionDetail').hide();

	// $('#Tanggal').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	// $('#Tanggal2').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	$('#Tanggal1_1').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    $('#Tanggal1_2').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	$('#Tanggal2_1').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    $('#Tanggal2_2').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

	ListFilterBy("#ListFilterBy");
	ListFilterSet("0-ALL");

	ListFilterBy2("#ListFilterBy2");
	ListFilterSet2("0-ALL");

	ListFilterBy3("#ListFilterBy3");
	ListFilterSet3("0-ALL");
});

function ListFilterBy(key){
	var type_list = 'Filter By :';
    type_list += '<select id="listFilterByVal" name="FilterBy" class="form-control selectpicker show-tick">';
    type_list += '<option value="0-ALL">ALL</option>';
    type_list += '<option value="1-REGION">REGION</option>';
	type_list += '<option value="2-PROVINSI">PROVINSI</option>';
	//type_list += '<option value="3">DISTRIK</option>';
	type_list += '<option value="4-AREA">AREA</option>';
	type_list += '<option value="5-DISTRIK">DISTRIK</option>';
	type_list += '<option value="6-DISTRIBUTOR">DISTRIBUTOR</option>';
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
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_region",
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
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_provinsi",
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
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_area",
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
	} else if(pilihan == "5-DISTRIK"){
		console.log('DISTRIK');
		$.ajax({
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_distrik",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Distrik -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        });
	} else if(pilihan == "6-DISTRIBUTOR"){
		console.log('DISTRIBUTOR');
		$.ajax({
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_distributor",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Distrbutor -</option>';
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

function ListFilterBy2(key){
	var type_list = 'Filter By :';
    type_list += '<select id="listFilterByVal2" name="FilterBy2" class="form-control selectpicker show-tick">';
    type_list += '<option value="0-ALL">ALL</option>';
    type_list += '<option value="1-REGION">REGION</option>';
	type_list += '<option value="2-PROVINSI">PROVINSI</option>';
	//type_list += '<option value="3">DISTRIK</option>';
	type_list += '<option value="4-AREA">AREA</option>';
	type_list += '<option value="5-DISTRIK">DISTRIK</option>';
    type_list += '</select>';
	
    $(key).html(type_list);
    $(".selectpicker").selectpicker("refresh");
}

$(document).on("change", "#listFilterByVal2", function(){
	var FilterBy2 = $(this).val();
	//console.log(FilterBy);
	ListFilterSet2(FilterBy2);
});

function ListFilterSet2(pilihan){
	var response;
	var key = "#ListFilterSet2";
	var type_list = 'Filter Set :';
	type_list += '<select id="listFilterSetVal2" name="FilterSet2" class="form-control selectpicker show-tick" data-size="10" data-live-search="true">';
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
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_region",
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
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_provinsi",
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
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_area",
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
	} else if(pilihan == "5-DISTRIK"){
		console.log('DISTRIK');
		$.ajax({
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_distrik",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Distrik -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        });
	} else if(pilihan == "6-DISTRIBUTOR"){
		console.log('DISTRIBUTOR');
		$.ajax({
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_distributor",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Distrbutor -</option>';
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

$(document).on("change", "#listFilterSetVal2", function(){
	var FilterSet2 = $(this).val();
	console.log(FilterSet2);
});

function ListFilterBy3(key){
	var type_list = 'Filter By :';
    type_list += '<select id="listFilterByVal3" name="FilterBy3" class="form-control selectpicker show-tick">';
    type_list += '<option value="0-ALL">ALL</option>';
    type_list += '<option value="1-REGION">REGION</option>';
	type_list += '<option value="2-PROVINSI">PROVINSI</option>';
	//type_list += '<option value="3">DISTRIK</option>';
	type_list += '<option value="4-AREA">AREA</option>';
	type_list += '<option value="5-DISTRIK">DISTRIK</option>';
    type_list += '</select>';
	
    $(key).html(type_list);
    $(".selectpicker").selectpicker("refresh");
}

$(document).on("change", "#listFilterByVal3", function(){
	var FilterBy3 = $(this).val();
	//console.log(FilterBy);
	ListFilterSet3(FilterBy3);
});

function ListFilterSet3(pilihan){
	var response;
	var key = "#ListFilterSet3";
	var type_list = 'Filter Set :';
	type_list += '<select id="listFilterSetVal3" name="FilterSet3" class="form-control selectpicker show-tick" data-size="10" data-live-search="true">';
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
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_region",
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
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_provinsi",
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
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_area",
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
	} else if(pilihan == "5-DISTRIK"){
		console.log('DISTRIK');
		$.ajax({
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_distrik",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Distrik -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
			}
        });
	} else if(pilihan == "6-DISTRIBUTOR"){
		console.log('DISTRIBUTOR');
		$.ajax({
            url: "<?php echo base_url(); ?>dashboard/Dashboard_PMB/List_distributor",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Distrbutor -</option>';
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

$(document).on("change", "#listFilterSetVal3", function(){
	var FilterSet3 = $(this).val();
	console.log(FilterSet3);
});

$(function () {

    $('#home_page').click(function () {

        window.location.href = '<?php echo site_url(); ?>dashboard/Dashboard_PMB/PMB_Home';
    	return false;

    });

    $('#sls_dis_page').click(function () {

        window.location.href = '<?php echo site_url(); ?>dashboard/Dashboard_PMB/Sls_Dis';
    	return false;

    });

    $('#nas_reg_page').click(function () {

        window.location.href = '<?php echo site_url(); ?>dashboard/Dashboard_PMB/Nas_REG';
    	return false;

    });


});

// $(document).on("click", "#BtnTambah_spc", function(){
// 	$('#form-in').trigger("reset");
// 	$("#id_up_user").val(0000);
// 	$("#id_jenis_user").val(1017);
// 	$("#modal_user_a_u").modal('show');
// 	$('#labelNama').text('Nama Sales : ');
// 	$('.modal-title').text('Tambah User SPC : ');
// });

// $(document).on("click", "#BtnEdit_spc", function(){
// 	$("#modal_user_a_u").modal('show');
	
// 	var id_user = $(this).attr("dt_id_user");
// 	var nama_user = $(this).attr("dt_nama");
// 	var username = $(this).attr("dt_username");
// 	var password = $(this).attr("dt_password");
// 	var email = $(this).attr("dt_email");
	
// 	$("#email_user").val(email);
// 	$("#id_up_user").val(id_user);
// 	$("#id_jenis_user").val(1017);
// 	$("#nama_user").val(nama_user);
// 	$("#username_user").val(username);
// 	$("#password_user").val(password);
	
	
// 	$('.modal-title').text('Edit User SPC : ['+id_user+'] '+nama_user);
// });

// $(document).on("click", "#BtnHapus_spc", function(){
// 	$("#modal_hapus_user").modal('show');
// 	var id_user = $(this).attr("dt_id_user");
// 	var nama_user = $(this).attr("dt_nama");
// 	$("#id_user_hapus").val(id_user);
// 	$('.modal-title').text('Hapus User SPC : ['+id_user+'] '+nama_user);
// });



var widthku = 87/100*screen.width;
console.log(widthku+'width');


</script>

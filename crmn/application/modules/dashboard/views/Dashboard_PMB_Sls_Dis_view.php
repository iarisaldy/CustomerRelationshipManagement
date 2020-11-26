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
										<li role="presentation" class="active"><a href="#distributor" aria-controls="distributor" role="tab" data-toggle="tab"><b>PMB DISTRIBUTOR</b></a></li>
										<li role="presentation"><a href="#salesman" aria-controls="salesman" role="tab" data-toggle="tab"><b>PMB SALESMAN</b></a></li>
									</ul>
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane fade in active" id="distributor">
											<h4>
												<button id="nas_reg_page2" style="float: right; margin-left: 1em;" class="btn btn-primary">Nasional & Regional</button>
												<button id="sls_dis_page2" style="float: right; margin-left: 1em; background-color: grey; color: white;" class="btn btn" disabled>Salesman & Distributor</button>
												<button id="home_page2" style="float: right; margin-left: 1em;" class="btn btn-primary">Home</button>
												<span>PMB Distributor</span>
											</h4>
											<br>
											<div class="row">
												<div class="col-md-12">
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
		                                                <div class="form-group">
		                                                    <div class="form-line" id="ListFilterBy2"></div>
		                                                </div>
		                                            </div>
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
		                                                <div class="form-group">
		                                                    <div class="form-line" id="ListFilterSet2"></div>
		                                                </div>
		                                            </div>
													<!-- <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
														<div class="form-group">
															<div class="form-line">
																<b>Tanggal Awal</b>
																<input type="text" id="Tanggal2_1" name="tanggal2_1" value="<?php echo date('Y-m-d', strtotime('-7 days')); ?>" class="form-control" placeholder="Tanggal Awal">
															</div>
														</div>
													</div>
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
														<div class="form-group">
															<div class="form-line">
																<b>Tanggal Akhir</b>
																<input type="text" id="Tanggal2_2" name="tanggal2_2" value="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Tanggal Akhir">
															</div>
														</div>
													</div> -->
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
														Filter Tahun : 
														<select id="tahun2" name="tahun2" class="form-control show-tick" data-size="5">
															
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
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
														Filter Bulan : 
														<select id="bulan2" name="bulan2" class="form-control show-tick" data-size="12">
															
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
																<option value="<?php echo $j; ?>" <?php if($j == date('m')){ echo "selected";} ?>><?php echo $monthName; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="col-md-1">
														<br/>
														<button id="btnFilter2" type="submit" class="btn btn-info"><span class="fa fa-eye"></span>&nbsp; View</button>
													</div>
												</div>
											</div>
											<h4>												
												<a target="_blank" target="_blank" id="export_distributor"><span style="float: right; margin-left: 1em;" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> &nbsp; Export Excel</span></a>
												<span>&nbsp;</span>
											</h4>
											<hr>
											<div class="table-responsive">
												<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_distributor">
													<thead class="w">
														<tr>
															<th rowspan="2" style="vertical-align: middle; text-align: center;" bgcolor="#00bcd4">No</th>
															<th rowspan="2" style="vertical-align: middle; text-align: center;" bgcolor="#00bcd4">Distributor</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;" bgcolor="#ffc000">Toko Unit (Coverage) (BK)</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;" bgcolor="#ffc000">Toko Aktif (BK)</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;" bgcolor="#92d050">SO Clean & Clear (Ton)</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;" bgcolor="#92d050">Volume Sell In (Ton)</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;" bgcolor="#92d050">Revenue (Juta)</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;" bgcolor="#ffc000">Volume Selling Out BK (Ton)</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;">ACP (hari)</th>
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
													<tbody class="y" id="show_data_distributor"></tbody>
												</table>
											</div>
											<br>
											<div>
												<table style="font-size: 12px;">
													<tr height="30px">
														<th style="text-align: left; width: 200px; padding-left: 10px;">Keterangan Data :</th>
													</tr>
													<tr height="30px">
														<th style="text-align: left; background-color: #92d050; width: 200px; padding-left: 10px;">Update Bulanan</th>
													</tr>
													<tr height="30px">
														<th style="text-align: left; background-color: #ffc000; width: 200px; padding-left: 10px;">Update Mingguan / Tahapan</th>
													</tr>
												</table>
											</div>
										</div>
										<div role="tabpanel" class="tab-pane fade in" id="salesman">
											<h4>
												<button id="nas_reg_page" style="float: right; margin-left: 1em;" class="btn btn-primary">Nasional & Regional</button>
												<button id="sls_dis_page" style="float: right; margin-left: 1em; background-color: grey; color: white;" class="btn btn" disabled>Salesman & Distributor</button>
												<button id="home_page" style="float: right; margin-left: 1em;" class="btn btn-primary">Home</button>
												<span >PMB Salesman </span>
											</h4>
											<br>
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
													<!-- <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
														<div class="form-group">
															<div class="form-line">
																<b>Tanggal Awal</b>
																<input type="text" id="Tanggal1_1" name="tanggal1_1" value="<?php echo date('Y-m-d', strtotime('-7 days')); ?>" class="form-control" placeholder="Tanggal Awal">
															</div>
														</div>
													</div>
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
														<div class="form-group">
															<div class="form-line">
																<b>Tanggal Akhir</b>
																<input type="text" id="Tanggal1_2" name="tanggal1_2" value="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Tanggal Akhir">
															</div>
														</div>
													</div> -->
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
														Filter Tahun : 
														<select id="tahun1" name="tahun1" class="form-control show-tick" data-size="5">
															
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
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
														Filter Bulan : 
														<select id="bulan1" name="bulan1" class="form-control show-tick" data-size="12">
															
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
																<option value="<?php echo $j; ?>" <?php if($j == date('m')){ echo "selected";} ?>><?php echo $monthName; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="col-md-1">
														<br/>
														<button id="btnFilter" type="submit" class="btn btn-info"><span class="fa fa-eye"></span>&nbsp; View</button>
													</div>
												</div>
											</div>
											<h4>
												<a target="_blank" target="_blank" id="export_salesman"><span style="float: right; margin-left: 1em;" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> &nbsp; Export Excel</span></a>
												<span>&nbsp;</span>
											</h4>
											<hr>
											<div class="table-responsive">
												<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_salesman">
													<thead class="w">
														<tr>
															<th rowspan="2" style="vertical-align: middle; text-align: center;" bgcolor="#00bcd4">No</th>
															<th rowspan="2" style="vertical-align: middle; text-align: center;" bgcolor="#00bcd4">Salesman</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;" bgcolor="#ffc000">Toko Unit (Coverage) (BK)</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;" bgcolor="#92d050">Kunjungan Salesman</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;" bgcolor="#ffc000">Toko Aktif (BK)</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;" bgcolor="#ffc000">Toko Baru (NOO) (BK)</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;" bgcolor="#92d050">Volume Selling Out Sidigi (Ton)</th>
															<th colspan="3" style="vertical-align: middle; text-align: center;" bgcolor="#ffc000">Volume Selling Out BK (Ton)</th>
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
													<tbody class="y" id="show_data"></tbody>
												</table>
											</div>
											<br>
											<div>
												<table style="font-size: 12px;">
													<tr height="30px">
														<th style="text-align: left; width: 200px; padding-left: 10px;">Keterangan Data :</th>
													</tr>
													<tr height="30px">
														<th style="text-align: left; background-color: #92d050; width: 200px; padding-left: 10px;">Update Bulanan</th>
													</tr>
													<tr height="30px">
														<th style="text-align: left; background-color: #ffc000; width: 200px; padding-left: 10px;">Update Mingguan / Tahapan</th>
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

var substr1 = FilterSet.substr(0, 4);
var substr2 = FilterSet2.substr(0, 4);

var jns_user = '<?php echo $jenis_user; ?>';


$('#export_distributor').hide();
$('#export_salesman').hide();

// console.log(FilterBy);

$(document).ready(function(){
	$('.regionDetail').hide();

	// $('#Tanggal').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	// $('#Tanggal2').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	$('#Tanggal1_1').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    $('#Tanggal1_2').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	$('#Tanggal2_1').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    $('#Tanggal2_2').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

	ListFilterBy("#ListFilterBy");
	ListFilterSet(FilterBy);

	ListFilterBy2("#ListFilterBy2");
	ListFilterSet2(FilterBy2);

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
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'">'+response[i][1]+'</option>';
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
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'">'+response[i][1]+'</option>';
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

function load_distributor(){

	$('#export_distributor').show();

    var oTable = $('#daftar_distributor').DataTable({
        processing: false,
        select: true,
        destroy: true,
        searching: true,
        lengthChange: false,
        ajax:{
            url: '<?php echo site_url(); ?>dashboard/Dashboard_PMB/ListDistributor/' + FilterBy2 + '/' + FilterSet2 + '/' + tahun2 + '/' + bulan2,
            type:'GET',
            dataSrc : function(json){
                var return_data = new Array()
                $.each(json['response'], function(i, item){

                    return_data.push({
                        'No' : (i+1),
                        'DISTRIBUTOR' : item['DISTRIBUTOR'],
                        'A_TARGET' : item['A_TARGET'],
                        'A_ACTUAL' : item['A_ACTUAL'],
                        'A_PERSEN' : item['A_PERSEN'],
                        'B_TARGET' : item['B_TARGET'],
                        'B_ACTUAL' : item['B_ACTUAL'],
                        'B_PERSEN' : item['B_PERSEN'],
                        'C_TARGET' : item['C_TARGET'],
                        'C_ACTUAL' : item['C_ACTUAL'],
                        'C_PERSEN' : item['C_PERSEN'],
                        'D_TARGET' : item['D_TARGET'],
                        'D_ACTUAL' : item['D_ACTUAL'],
                        'D_PERSEN' : item['D_PERSEN'],
                        'E_TARGET' : item['E_TARGET'],
                        'E_ACTUAL' : item['E_ACTUAL'],
                        'E_PERSEN' : item['E_PERSEN'],
                        'F_TARGET' : item['F_TARGET'],
                        'F_ACTUAL' : item['F_ACTUAL'],
                        'F_PERSEN' : item['F_PERSEN'],
                        'G_TARGET' : item['G_TARGET'],
                        'G_ACTUAL' : item['G_ACTUAL'],
                        'G_PERSEN' : item['G_PERSEN'],
                    })
                })
                return return_data;
            }
        },
        columns : [
            {data : 'No'},
            {data : 'DISTRIBUTOR'},
            {data : 'A_TARGET'},
            {data : 'A_ACTUAL'},
            {data : 'A_PERSEN'},
            {data : 'B_TARGET'},
            {data : 'B_ACTUAL'},
            {data : 'B_PERSEN'},
            {data : 'C_TARGET'},
            {data : 'C_ACTUAL'},
            {data : 'C_PERSEN'},
            {data : 'D_TARGET'},
            {data : 'D_ACTUAL'},
            {data : 'D_PERSEN'},
            {data : 'E_TARGET'},
            {data : 'E_ACTUAL'},
            {data : 'E_PERSEN'},
            {data : 'F_TARGET'},
            {data : 'F_ACTUAL'},
            {data : 'F_PERSEN'},
            {data : 'G_TARGET'},
            {data : 'G_ACTUAL'},
            {data : 'G_PERSEN'},
        ]
    })
}

function load_salesman(){

	$('#export_salesman').show();

    var oTable = $('#daftar_salesman').DataTable({
        processing: false,
        select: true,
        destroy: true,
        searching: true,
        lengthChange: false,
        ajax:{
            url: '<?php echo site_url(); ?>dashboard/Dashboard_PMB/ListSalesman/' + FilterBy + '/' + FilterSet + '/' + tahun1 + '/' + bulan1,
            type:'GET',
            dataSrc : function(json){
                var return_data = new Array()
                $.each(json['response'], function(i, item){

                    return_data.push({
                        'No' : (i+1),
                        'SALESMAN' : item['SALESMAN'],
                        'A_TARGET' : item['A_TARGET'],
                        'A_ACTUAL' : item['A_ACTUAL'],
                        'A_PERSEN' : item['A_PERSEN'],
                        'B_TARGET' : item['B_TARGET'],
                        'B_ACTUAL' : item['B_ACTUAL'],
                        'B_PERSEN' : item['B_PERSEN'],
                        'C_TARGET' : item['C_TARGET'],
                        'C_ACTUAL' : item['C_ACTUAL'],
                        'C_PERSEN' : item['C_PERSEN'],
                        'D_TARGET' : item['D_TARGET'],
                        'D_ACTUAL' : item['D_ACTUAL'],
                        'D_PERSEN' : item['D_PERSEN'],
                        'E_TARGET' : item['E_TARGET'],
                        'E_ACTUAL' : item['E_ACTUAL'],
                        'E_PERSEN' : item['E_PERSEN'],
                        'F_TARGET' : item['F_TARGET'],
                        'F_ACTUAL' : item['F_ACTUAL'],
                        'F_PERSEN' : item['F_PERSEN'],
                    })
                })
                return return_data;
            }
        },
        columns : [
            {data : 'No'},
            {data : 'SALESMAN'},
            {data : 'A_TARGET'},
            {data : 'A_ACTUAL'},
            {data : 'A_PERSEN'},
            {data : 'B_TARGET'},
            {data : 'B_ACTUAL'},
            {data : 'B_PERSEN'},
            {data : 'C_TARGET'},
            {data : 'C_ACTUAL'},
            {data : 'C_PERSEN'},
            {data : 'D_TARGET'},
            {data : 'D_ACTUAL'},
            {data : 'D_PERSEN'},
            {data : 'E_TARGET'},
            {data : 'E_ACTUAL'},
            {data : 'E_PERSEN'},
            {data : 'F_TARGET'},
            {data : 'F_ACTUAL'},
            {data : 'F_PERSEN'},
        ]
    })
}

$(function () {
    load_distributor();
    // load_salesman();

    $('#btnFilter').click(function () {
        FilterBy   = $('#listFilterByVal').val();
        FilterSet   = $('#listFilterSetVal').val();
        tahun1   = $('#tahun1').val();
        bulan1   = $('#bulan1').val();

        load_salesman();
    });

    $('#btnFilter2').click(function () {
        FilterBy2   = $('#listFilterByVal2').val();
        FilterSet2   = $('#listFilterSetVal2').val();
        tahun2   = $('#tahun2').val();
        bulan2   = $('#bulan2').val();

        load_distributor();
    });

    $('#export_salesman').click(function () {
        FilterBy   = $('#listFilterByVal').val();
        FilterSet   = $('#listFilterSetVal').val();
        tahun1   = $('#tahun1').val();
        bulan1   = $('#bulan1').val();

        var win = window.open('<?php echo site_url(); ?>dashboard/Dashboard_PMB/Export_excel_salesman/' + FilterBy + '/' + FilterSet + '/' + tahun1 + '/' + bulan1, '_blank');
        if (win) {
		    //Browser has allowed it to be opened
		    win.focus();
		} else {
		    //Browser has blocked it
		    alert('Please allow popups for this website');
		}

    });

    $('#export_distributor').click(function () {
        FilterBy2   = $('#listFilterByVal2').val();
        FilterSet2   = $('#listFilterSetVal2').val();
        tahun2   = $('#tahun2').val();
        bulan2   = $('#bulan2').val();

        var win = window.open('<?php echo site_url(); ?>dashboard/Dashboard_PMB/Export_excel_distributor/' + FilterBy2 + '/' + FilterSet2 + '/' + tahun2 + '/' + bulan2, '_blank');
        if (win) {
		    //Browser has allowed it to be opened
		    win.focus();
		} else {
		    //Browser has blocked it
		    alert('Please allow popups for this website');
		}

    });

    $('#home_page').click(function () {

        window.location.href = '<?php echo site_url(); ?>dashboard/Dashboard_PMB';
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

    $('#home_page2').click(function () {

        window.location.href = '<?php echo site_url(); ?>dashboard/Dashboard_PMB';
    	return false;

    });

    $('#sls_dis_page2').click(function () {

        window.location.href = '<?php echo site_url(); ?>dashboard/Dashboard_PMB/Sls_Dis';
    	return false;

    });

    $('#nas_reg_page2').click(function () {

        window.location.href = '<?php echo site_url(); ?>dashboard/Dashboard_PMB/Nas_REG';
    	return false;

    });


});

</script>

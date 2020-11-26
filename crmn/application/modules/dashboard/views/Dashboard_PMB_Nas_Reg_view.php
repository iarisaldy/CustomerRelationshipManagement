
<?php 

$dtl_arr = array(
	'0' =>	'Jumlah Toko Terdaftar',
	'1' =>	'Jumlah Toko Baru',
	'2' =>	'Jumlah Toko Aktif (dengan IBK)',
	'3' =>	'Jumlah Toko Aktif (via Aksestoko)',
	'4' =>	'Jumlah Toko Aktif (semua toko)',
	'5' =>	'Jumlah Toko Non-VMS',
	'6' =>	'Jumlah Toko Lelang',
	'7' =>	'Total Volume Sell In (Ton)',
	'8' =>	'Total Volume Sell Out (Ton)',
	'9' =>	'Tot Vol Sell Out - via Aksestoko',
	'10' =>	'Tot Vol Sell Out - via ERP',
	'11' =>	'Total Revenue Sell Out (Juta)',
	'12' =>	'Tot Rev Sell Out - via Aksestoko (Juta)',
	'13' =>	'Tot Rev Sell Out - via ERP (Juta)',
	'14' =>	'% Level Stock Gudang',
	'15' =>	'Jumlah Salesman Terdaftar',
	'16' =>	'Jumlah Salesman Berkunjung'
);

foreach ($dtl_arr as $k_j => $v_j) {
	foreach ($dt_grafik as $v_g) {
		if ($v_g['ID_DATA'] == $k_j) {
			$arr_grafik[] = array(
	            'ID_REGION' 	=> $v_g['ID_REGION'],
	            'ID_DATA' 		=> $v_g['ID_DATA'],
	            'JENIS_DATA'	=> $v_j,
	            'BULAN' 		=> $v_g['BULAN'],
	            'DATA' 			=> $v_g['DATA']
			);
		}
	}
}

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
										<li role="presentation" class="active"><a href="#regional" aria-controls="regional" role="tab" data-toggle="tab"><b>NASIONAL & REGIONAL</b></a></li>
									</ul>
									<div class="tab-content">
										
										<div role="tabpanel" class="tab-pane fade in active" id="regional">
											<div class="row">
												<div class="col-sm-12">
													<button id="nas_reg_page" style="float: right; margin-left: 1em; background-color: grey; color: white;" class="btn btn" disabled>Nasional & Regional</button>
													<button id="sls_dis_page" style="float: right; margin-left: 1em;" class="btn btn-primary">Salesman & Distributor</button>
													<button id="home_page" style="float: right; margin-left: 1em;" class="btn btn-primary">Home</button>
												</div>
											</div>
											<h4>
												<span>DATA NASIONAL</span>
											</h4>
											<div class="row">
												<div class="col-sm-12">
													<table id="tabel_bk" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
															<tr style="color: white; background-color: #00bcd4;" onclick="show_region();">
																<th colspan="<?php echo date('m') + 1; ?>" style=" text-align: center; font-size: 14px;">
																	Bisnis Kokoh
																</th>
															</tr>
															<tr bgcolor="#7f7f7f" style="color:white">
																<th width="20%">NASIONAL</th>
																<?php 
																for($j=1;$j<=date('m');$j++){
																	$dateObj   = DateTime::createFromFormat('!m', $j);
																	$moon = '';
																	if($j < 10){
																		$moon = '0'.$j;
																	} else {
																		$moon = $j;
																	}
																	$monthName = $dateObj->format('F');
																	
																	?>
																	<th width="<?php echo 80 / date('m') ?>%" style="text-align: center;"><?php echo $monthName; ?></th>
																<?php } ?>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Jumlah Toko Terdaftar</td>
																<?php 
																for($j = 1;$j <= date('m');$j++){
																	foreach ($dt_nasional as $nas) {
																		if ($nas['ID_DATA'] == '0' && $nas['BULAN'] == date('M', strtotime(date('Y').'-'.$j))) {
																	?>
																	<td style="text-align: right;"><?php echo number_format($nas['DATA']); ?></td>
																<?php
																		}
																	}
																}
																?>
															</tr>
															<tr>
																<td>Jumlah Toko Aktif (dengan IBK)</td>
																<?php 
																for($j = 1;$j <= date('m');$j++){
																	foreach ($dt_nasional as $nas) {
																		if ($nas['ID_DATA'] == '2' && $nas['BULAN'] == date('M', strtotime(date('Y').'-'.$j))) {
																	?>
																	<td style="text-align: right;"><?php echo number_format($nas['DATA']); ?></td>
																<?php
																		}
																	}
																}
																?>
															</tr>
															<tr>
																<td>Jumlah Toko Baru</td>
																<?php 
																for($j = 1;$j <= date('m');$j++){
																	foreach ($dt_nasional as $nas) {
																		if ($nas['ID_DATA'] == '1' && $nas['BULAN'] == date('M', strtotime(date('Y').'-'.$j))) {
																	?>
																	<td style="text-align: right;"><?php echo number_format($nas['DATA']); ?></td>
																<?php
																		}
																	}
																}
																?>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="col-sm-12">
													<table id="tabel_sdg" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
															<tr style="color: white; background-color: #00bcd4;" onclick="show_region();">
																<th colspan="<?php echo date('m') + 1; ?>" style=" text-align: center; font-size: 14px;">
																	SIDIGI
																</th>
															</tr>
															<tr bgcolor="#7f7f7f" style="color:white">
																<th width="20%">NASIONAL</th>
																<?php 
																for($j=1;$j<=date('m');$j++){
																	$dateObj   = DateTime::createFromFormat('!m', $j);
																	$moon = '';
																	if($j < 10){
																		$moon = '0'.$j;
																	} else {
																		$moon = $j;
																	}
																	$monthName = $dateObj->format('F');
																	
																	?>
																	<th width="<?php echo 80 / date('m') ?>%" style="text-align: center;"><?php echo $monthName; ?></th>
																<?php } ?>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Jumlah Toko Aktif (semua toko)</td>
																<?php 
																for($j = 1;$j <= date('m');$j++){
																	foreach ($dt_nasional as $nas) {
																		if ($nas['ID_DATA'] == '4' && $nas['BULAN'] == date('M', strtotime(date('Y').'-'.$j))) {
																	?>
																	<td style="text-align: right;"><?php echo number_format($nas['DATA']); ?></td>
																<?php
																		}
																	}
																}
																?>
															</tr>
															<tr>
																<td>Total Volume Sell Out (Ton)</td>
																<?php 
																for($j = 1;$j <= date('m');$j++){
																	foreach ($dt_nasional as $nas) {
																		if ($nas['ID_DATA'] == '8' && $nas['BULAN'] == date('M', strtotime(date('Y').'-'.$j))) {
																	?>
																	<td style="text-align: right;"><?php echo number_format($nas['DATA']); ?></td>
																<?php
																		}
																	}
																}
																?>
															</tr>
															<tr>
																<td>% Level Stock Gudang</td>
																<?php 
																for($j = 1;$j <= date('m');$j++){
																	foreach ($dt_nasional as $nas) {
																		if ($nas['ID_DATA'] == '14' && $nas['BULAN'] == date('M', strtotime(date('Y').'-'.$j))) {
																	?>
																	<td style="text-align: right;"><?php echo number_format($nas['DATA']); ?></td>
																<?php
																		}
																	}
																}
																?>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="col-sm-12">
													<table id="tabel_crm" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
															<tr style="color: white; background-color: #00bcd4;" onclick="show_region();">
																<th colspan="<?php echo date('m') + 1; ?>" style=" text-align: center; font-size: 14px;">
																	CRM
																</th>
															</tr>
															<tr bgcolor="#7f7f7f" style="color:white">
																<th width="20%">NASIONAL</th>
																<?php 
																for($j=1;$j<=date('m');$j++){
																	$dateObj   = DateTime::createFromFormat('!m', $j);
																	$moon = '';
																	if($j < 10){
																		$moon = '0'.$j;
																	} else {
																		$moon = $j;
																	}
																	$monthName = $dateObj->format('F');
																	
																	?>
																	<th width="<?php echo 80 / date('m') ?>%" style="text-align: center;"><?php echo $monthName; ?></th>
																<?php } ?>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Jumlah Salesman Terdaftar</td>
																<?php 
																for($j = 1;$j <= date('m');$j++){
																	foreach ($dt_nasional as $nas) {
																		if ($nas['ID_DATA'] == '15' && $nas['BULAN'] == date('M', strtotime(date('Y').'-'.$j))) {
																	?>
																	<td style="text-align: right;"><?php echo number_format($nas['DATA']); ?></td>
																<?php
																		}
																	}
																}
																?>
															</tr>
															<tr>
																<td>Jumlah Salesman Berkunjung</td>
																<?php 
																for($j = 1;$j <= date('m');$j++){
																	foreach ($dt_nasional as $nas) {
																		if ($nas['ID_DATA'] == '16' && $nas['BULAN'] == date('M', strtotime(date('Y').'-'.$j))) {
																	?>
																	<td style="text-align: right;"><?php echo number_format($nas['DATA']); ?></td>
																<?php
																		}
																	}
																}
																?>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

											<hr>
											<hr>

											<h4>
												<span>DATA REGION</span>
											</h4>
											<div class="row">
												<?php
												for($rgn = 1; $rgn <= 4; $rgn++){
												?>
												<div class="col-sm-12">
													<table id="tabel_bk" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
															<tr style="cursor: pointer; color: white; background: radial-gradient(circle, rgba(0,188,212,1) 50%, rgba(16,133,255,1) 100%);" onclick="show_detail_region(<?php echo $rgn; ?>)">
																<th colspan="<?php echo date('m') + 1; ?>" style=" text-align: center; font-size: 14px;">
																	Region <?php echo $rgn; ?>
																</th>
															</tr>
															<tr bgcolor="#7f7f7f" style="color:white">
																<th width="20%">Data</th>
																<?php 
																for($j=1;$j<=date('m');$j++){
																	$dateObj   = DateTime::createFromFormat('!m', $j);
																	$moon = '';
																	if($j < 10){
																		$moon = '0'.$j;
																	} else {
																		$moon = $j;
																	}
																	$monthName = $dateObj->format('F');
																	
																	?>
																	<th width="<?php echo 80 / date('m') ?>%" style="text-align: center;"><?php echo $monthName; ?></th>
																<?php } ?>
															</tr>
														</thead>
														<tbody>
															<?php
																$month_a = '';
																foreach ($dtl_arr as $dtl_k_a => $dtl_v_a) {
																	if ($dtl_k_a == '0' || $dtl_k_a == '2' || $dtl_k_a == '7' || $dtl_k_a == '8') {
															?>
															<tr>
																<td><?php echo $dtl_v_a; ?></td>
																<?php 
																	for($j_a = 0;$j_a < date('m');$j_a++){
																		$month_a = "'".str_pad($j_a+1,2,"0",STR_PAD_LEFT)."'";
																?>
																<td style="text-align: right;">
																	<?php
																		foreach ($dt_regional as $v_dt_a) {
																			if ($v_dt_a['ID_REGION'] == $rgn && $v_dt_a['ID_DATA'] == $dtl_k_a && isset($v_dt_a)) {

																				$nilai_a = 0;

																				// print_r('<pre>');
																				// print_r($v_dt);exit;
																				if (!empty($v_dt_a["$month_a"])) {

																					$nilai_a = number_format($v_dt_a["$month_a"]);
																					// if ($dtl_k_a == '7' || $dtl_k_a == '8' || $dtl_k_a == '9' || $dtl_k_a == '10' || $dtl_k_a == '11' || $dtl_k_a == '12' || $dtl_k_a == '13' || $dtl_k_a == '14') {
																					// 	$nilai_a = number_format($v_dt_a["$month_a"],2);
																					// }
																				}

																				echo $nilai_a;
																			}

																		}
																	?>
																</td>
																<?php } ?>
															</tr>
															<?php
																	}
																}
															?>
														</tbody>
													</table>
												</div>
												<?php
												}
												?>
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
<div class="modal fade" id="dlg_detail1" role="dialog">
    <div class="modal-dialog modal-lg" style="height: 70%;">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background: linear-gradient(90deg, rgba(0,188,212,1) 50%, rgba(16,133,255,1) 100%); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: white;">REGION 1</h2>
			</div>
			<div class="modal-body" style="overflow-y: scroll; max-height: 100%;">
				<table id="tabel_reg_dlg" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr bgcolor="#7f7f7f" style="color:white">
							<th width="20%">Data</th>
							<?php 
							for($j=1;$j<=date('m');$j++){
								$dateObj   = DateTime::createFromFormat('!m', $j);
								$moon = '';
								if($j < 10){
									$moon = '0'.$j;
								} else {
									$moon = $j;
								}
								$monthName = $dateObj->format('F');
								
								?>
								<th style="text-align: center;" width="<?php echo 80 / date('m') ?>%"><?php echo $monthName; ?></th>
							<?php } ?>
							<th style="text-align: center;">Chart</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dtl_arr as $dtl_k => $dtl_v) {
						?>
						<tr>
							<th style="cursor: pointer;"><?php echo $dtl_v; ?></th>

							<?php 
							for($j = 0;$j < date('m');$j++){
								
								$month1 = "'".str_pad($j+1,2,"0",STR_PAD_LEFT)."'";
							?>
								<td style="text-align: right;">
								<?php
								foreach ($dt_regional as $v_dt) {
									if ($v_dt['ID_REGION'] == 1 && $v_dt['ID_DATA'] == $dtl_k && isset($v_dt)) {

										$nilai = 0;

										// print_r('<pre>');
										// print_r($v_dt);exit;
										if (!empty($v_dt["$month1"])) {
											$nilai = number_format($v_dt["$month1"]);
											// if ($dtl_k == '7' || $dtl_k == '8' || $dtl_k == '9' || $dtl_k == '10' || $dtl_k == '11' || $dtl_k == '12' || $dtl_k == '13' || $dtl_k == '14') {
											// 	$nilai = number_format($v_dt["$month1"],2);
											// }
										}

										echo $nilai;
									}

								}

								$mdl_grafik1 = "show_grafik_1_".$dtl_k."('1','".$dtl_k."')";
								?>
								</td>
							<?php } ?>
							<td><button type="submit" class="btn btn-info" onclick="<?php echo $mdl_grafik1; ?>"><span class="fa fa-line-chart"></span></button></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="dlg_detail2" role="dialog">
    <div class="modal-dialog modal-lg" style="height: 70%;">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background: linear-gradient(90deg, rgba(0,188,212,1) 50%, rgba(16,133,255,1) 100%); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: white;">REGION 2</h2>
			</div>
			<div class="modal-body" style="overflow-y: scroll; max-height: 100%;">
				<table id="tabel_reg_dlg" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr bgcolor="#7f7f7f" style="color:white">
							<th width="20%">Data</th>
							<?php 
							for($j=1;$j<=date('m');$j++){
								$dateObj   = DateTime::createFromFormat('!m', $j);
								$moon = '';
								if($j < 10){
									$moon = '0'.$j;
								} else {
									$moon = $j;
								}
								$monthName = $dateObj->format('F');
								
								?>
								<th style="text-align: center;" width="<?php echo 80 / date('m') ?>%"><?php echo $monthName; ?></th>
							<?php } ?>
							<th style="text-align: center;">Chart</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dtl_arr as $dtl_k => $dtl_v) {
						?>
						<tr>
							<th style="cursor: pointer;"><?php echo $dtl_v; ?></th>

							<?php 
							for($j = 0;$j < date('m');$j++){
								
								$month2 = "'".str_pad($j+1,2,"0",STR_PAD_LEFT)."'";
							?>
								<td style="text-align: right;">
								<?php
								foreach ($dt_regional as $v_dt) {
									if ($v_dt['ID_REGION'] == 2 && $v_dt['ID_DATA'] == $dtl_k && isset($v_dt)) {

										$nilai = 0;

										// print_r('<pre>');
										// print_r($v_dt);exit;
										if (!empty($v_dt["$month2"])) {
											$nilai = number_format($v_dt["$month2"]);
											// if ($dtl_k == '7' || $dtl_k == '8' || $dtl_k == '9' || $dtl_k == '10' || $dtl_k == '11' || $dtl_k == '12' || $dtl_k == '13' || $dtl_k == '14') {
											// 	$nilai = number_format($v_dt["$month2"],2);
											// }
										}

										echo $nilai;
									}

								}

								$mdl_grafik2 = "show_grafik_2_".$dtl_k."('2','".$dtl_k."')";
								?>
								</td>
							<?php } ?>
							<td><button type="submit" class="btn btn-info" onclick="<?php echo $mdl_grafik2; ?>"><span class="fa fa-line-chart"></span></button></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="dlg_detail3" role="dialog">
    <div class="modal-dialog modal-lg" style="height: 70%;">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background: linear-gradient(90deg, rgba(0,188,212,1) 50%, rgba(16,133,255,1) 100%); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: white;">REGION 3</h2>
			</div>
			<div class="modal-body" style="overflow-y: scroll; max-height: 100%;">
				<table id="tabel_reg_dlg" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr bgcolor="#7f7f7f" style="color:white">
							<th width="20%">Data</th>
							<?php 
							for($j=1;$j<=date('m');$j++){
								$dateObj   = DateTime::createFromFormat('!m', $j);
								$moon = '';
								if($j < 10){
									$moon = '0'.$j;
								} else {
									$moon = $j;
								}
								$monthName = $dateObj->format('F');
								
								?>
								<th style="text-align: center;" width="<?php echo 80 / date('m') ?>%"><?php echo $monthName; ?></th>
							<?php } ?>
							<th style="text-align: center;">Chart</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dtl_arr as $dtl_k => $dtl_v) {
						?>
						<tr>
							<th style="cursor: pointer;"><?php echo $dtl_v; ?></th>

							<?php 
							for($j = 0;$j < date('m');$j++){
								
								$month3 = "'".str_pad($j+1,2,"0",STR_PAD_LEFT)."'";
							?>
								<td style="text-align: right;">
								<?php
								foreach ($dt_regional as $v_dt) {
									if ($v_dt['ID_REGION'] == 3 && $v_dt['ID_DATA'] == $dtl_k && isset($v_dt)) {

										$nilai = 0;

										// print_r('<pre>');
										// print_r($v_dt);exit;
										if (!empty($v_dt["$month3"])) {
											$nilai = number_format($v_dt["$month3"]);
											// if ($dtl_k == '7' || $dtl_k == '8' || $dtl_k == '9' || $dtl_k == '10' || $dtl_k == '11' || $dtl_k == '12' || $dtl_k == '13' || $dtl_k == '14') {
											// 	$nilai = number_format($v_dt["$month3"],2);
											// }
										}

										echo $nilai;
									}

								}

								$mdl_grafik3 = "show_grafik_3_".$dtl_k."('3','".$dtl_k."')";
								?>
								</td>
							<?php } ?>
							<td><button type="submit" class="btn btn-info" onclick="<?php echo $mdl_grafik3; ?>"><span class="fa fa-line-chart"></span></button></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="dlg_detail4" role="dialog">
    <div class="modal-dialog modal-lg" style="height: 70%;">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background: linear-gradient(90deg, rgba(0,188,212,1) 50%, rgba(16,133,255,1) 100%); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: white;">REGION 4</h2>
			</div>
			<div class="modal-body" style="overflow-y: scroll; max-height: 100%;">
				<table id="tabel_reg_dlg" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr bgcolor="#7f7f7f" style="color:white">
							<th width="20%">Data</th>
							<?php 
							for($j=1;$j<=date('m');$j++){
								$dateObj   = DateTime::createFromFormat('!m', $j);
								$moon = '';
								if($j < 10){
									$moon = '0'.$j;
								} else {
									$moon = $j;
								}
								$monthName = $dateObj->format('F');
								
								?>
								<th style="text-align: center;" width="<?php echo 80 / date('m') ?>%"><?php echo $monthName; ?></th>
							<?php } ?>
							<th style="text-align: center;">Chart</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dtl_arr as $dtl_k => $dtl_v) {
						?>
						<tr>
							<th style="cursor: pointer;"><?php echo $dtl_v; ?></th>

							<?php 
							for($j = 0;$j < date('m');$j++){
								
								$month4 = "'".str_pad($j+1,2,"0",STR_PAD_LEFT)."'";
							?>
								<td style="text-align: right;">
								<?php
								foreach ($dt_regional as $v_dt) {
									if ($v_dt['ID_REGION'] == 4 && $v_dt['ID_DATA'] == $dtl_k && isset($v_dt)) {

										$nilai = 0;

										// print_r('<pre>');
										// print_r($v_dt);exit;
										if (!empty($v_dt["$month4"])) {
											$nilai = number_format($v_dt["$month4"]);
											// if ($dtl_k == '7' || $dtl_k == '8' || $dtl_k == '9' || $dtl_k == '10' || $dtl_k == '11' || $dtl_k == '12' || $dtl_k == '13' || $dtl_k == '14') {
											// 	$nilai = number_format($v_dt["$month4"],2);
											// }
										}

										echo $nilai;
									}

								}

								$mdl_grafik4 = "show_grafik_4_".$dtl_k."('4','".$dtl_k."')";
								?>
								</td>
							<?php } ?>
							<td><button type="submit" class="btn btn-info" onclick="<?php echo $mdl_grafik4; ?>"><span class="fa fa-line-chart"></span></button></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?php
$mdl_id = '';
$div_id = '';
$hdr_mdl = '';

for ($reg=1; $reg <= 4; $reg++) { 

	for ($grf=0; $grf <= 16; $grf++) { 

		$mdl_id = 'dlg_grafik_'.$reg.'_'.$grf;
		$div_id = 'line-grafik_'.$reg.'_'.$grf;
		foreach ($dtl_arr as $jns_k => $jns_v) {
			if ($jns_k == $grf) {
				$hdr_mdl = $jns_v;
?>
<div class="modal fade" id="<?php echo $mdl_id; ?>" role="dialog">
    <div class="modal-dialog modal-lg">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background: linear-gradient(90deg, rgba(0,188,212,1) 50%, rgba(16,133,255,1) 100%); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: white;"><?php echo 'GRAFIK '.strtoupper($hdr_mdl).' - REGION '.$reg; ?></h2>
			</div>
			<div class="modal-body">
				<center>
					<canvas id="<?php echo $div_id; ?>"></canvas>
				</center>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" onclick="fun_back('<?php echo $mdl_id; ?>','<?php echo $reg; ?>')">Back</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?php
			}
		}
	}
}
?>

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

function fun_back(mod_graf, reg) {

	$('#'+mod_graf).modal("hide");
	$('#'+mod_graf).hide();
	
	$('#dlg_detail'+reg).modal("show");
	
}

function show_detail_region(num) {
	
	if (num == 1) {
		$('#dlg_detail1').modal("show");
	} else if (num == 2) {
		$('#dlg_detail2').modal("show");
	} else if (num == 3) {
		$('#dlg_detail3').modal("show");
	} else if (num == 4) {
		$('#dlg_detail4').modal("show");
	}
	
}

function jenis_data(dt) {

	var jns_dt = '';
	
	if (dt == 0) {
		jns_dt = 'Jumlah Toko Terdaftar';
	} else if (dt == 1) {
		jns_dt = 'Jumlah Toko Baru';
	} else if (dt == 2) {
		jns_dt = 'Jumlah Toko Aktif (dengan IBK)';
	} else if (dt == 3) {
		jns_dt = 'Jumlah Toko Aktif (via Aksestoko)';
	} else if (dt == 4) {
		jns_dt = 'Jumlah Toko Aktif (semua toko)';
	} else if (dt == 5) {
		jns_dt = 'Jumlah Toko Non-VMS';
	} else if (dt == 6) {
		jns_dt = 'Jumlah Toko Lelang';
	} else if (dt == 7) {
		jns_dt = 'Total Volume Sell In (Ton)';
	} else if (dt == 8) {
		jns_dt = 'Total Volume Sell Out (Ton)';
	} else if (dt == 9) {
		jns_dt = 'Tot Vol Sell Out - via Aksestoko';
	} else if (dt == 0) {
		jns_dt = 'Tot Vol Sell Out - via ERP';
	} else if (dt == 10) {
		jns_dt = 'Total Revenue Sell Out (Rp)';
	} else if (dt == 11) {
		jns_dt = 'Tot Rev Sell Out - via Aksestoko';
	} else if (dt == 12) {
		jns_dt = 'Tot Rev Sell Out - via ERP';
	} else if (dt == 14) {
		jns_dt = '% Level Stock Gudang';
	} else if (dt == 15) {
		jns_dt = 'Jumlah Salesman Terdaftar';
	} else if (dt == 16) {
		jns_dt = 'Jumlah Salesman Berkunjung';
	}

	return jns_dt;
	
}

//-----------------REGION 1---------------------------------

function show_grafik_1_0(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_0').modal("hide");
	$('#dlg_grafik_1_0').modal("show");


	var ctx = $("#line-grafik_1_0");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_0 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 0) {
						$arr_grafik_per_1_0[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_0 = count($arr_grafik_per_1_0);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_0 as $dtku_1_0){
					$i++;
					echo '"'.$dtku_1_0->BULAN.'"';
					if($i != $jmlDT_1_0){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_0 as $dtku_1_0){
						$i++;
						echo $dtku_1_0->DATA;
						if($i != $jmlDT_1_0){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_1(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_1').modal("hide");
	$('#dlg_grafik_1_1').modal("show");


	var ctx = $("#line-grafik_1_1");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_1 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 1) {
						$arr_grafik_per_1_1[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_1 = count($arr_grafik_per_1_1);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_1 as $dtku_1_1){
					$i++;
					echo '"'.$dtku_1_1->BULAN.'"';
					if($i != $jmlDT_1_1){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_1 as $dtku_1_1){
						$i++;
						echo $dtku_1_1->DATA;
						if($i != $jmlDT_1_1){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_2(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_2').modal("hide");
	$('#dlg_grafik_1_2').modal("show");


	var ctx = $("#line-grafik_1_2");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_2 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 2) {
						$arr_grafik_per_1_2[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_2 = count($arr_grafik_per_1_2);
				
				// print_r('<pre>');
				// print_r($arr_grafik_per);exit;

				$i = 0;
				foreach ($arr_grafik_per_1_2 as $dtku_1_2){
					$i++;
					echo '"'.$dtku_1_2->BULAN.'"';
					if($i != $jmlDT_1_2){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_2 as $dtku_1_2){
						$i++;
						echo $dtku_1_2->DATA;
						if($i != $jmlDT_1_2){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_3(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_3').modal("hide");
	$('#dlg_grafik_1_3').modal("show");


	var ctx = $("#line-grafik_1_3");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_3 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 3) {
						$arr_grafik_per_1_3[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_3 = count($arr_grafik_per_1_3);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_3 as $dtku_1_3){
					$i++;
					echo '"'.$dtku_1_3->BULAN.'"';
					if($i != $jmlDT_1_3){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_3 as $dtku_1_3){
						$i++;
						echo $dtku_1_3->DATA;
						if($i != $jmlDT_1_3){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_4(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_4').modal("hide");
	$('#dlg_grafik_1_4').modal("show");


	var ctx = $("#line-grafik_1_4");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_4 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 4) {
						$arr_grafik_per_1_4[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_4 = count($arr_grafik_per_1_4);
				
				// print_r('<pre>');
				// print_r($arr_grafik_per);exit;

				$i = 0;
				foreach ($arr_grafik_per_1_4 as $dtku_1_4){
					$i++;
					echo '"'.$dtku_1_4->BULAN.'"';
					if($i != $jmlDT_1_4){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_4 as $dtku_1_4){
						$i++;
						echo $dtku_1_4->DATA;
						if($i != $jmlDT_1_4){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_5(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_5').modal("hide");
	$('#dlg_grafik_1_5').modal("show");


	var ctx = $("#line-grafik_1_5");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_5 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 5) {
						$arr_grafik_per_1_5[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_5 = count($arr_grafik_per_1_5);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_5 as $dtku_1_5){
					$i++;
					echo '"'.$dtku_1_5->BULAN.'"';
					if($i != $jmlDT_1_5){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_5 as $dtku_1_5){
						$i++;
						echo $dtku_1_5->DATA;
						if($i != $jmlDT_1_5){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_6(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_6').modal("hide");
	$('#dlg_grafik_1_6').modal("show");


	var ctx = $("#line-grafik_1_6");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_6 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 6) {
						$arr_grafik_per_1_6[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_6 = count($arr_grafik_per_1_6);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_6 as $dtku_1_6){
					$i++;
					echo '"'.$dtku_1_6->BULAN.'"';
					if($i != $jmlDT_1_6){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_6 as $dtku_1_6){
						$i++;
						echo $dtku_1_6->DATA;
						if($i != $jmlDT_1_6){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_7(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_7').modal("hide");
	$('#dlg_grafik_1_7').modal("show");


	var ctx = $("#line-grafik_1_7");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_7 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 7) {
						$arr_grafik_per_1_7[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_7 = count($arr_grafik_per_1_7);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_7 as $dtku_1_7){
					$i++;
					echo '"'.$dtku_1_7->BULAN.'"';
					if($i != $jmlDT_1_7){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_7 as $dtku_1_7){
						$i++;
						echo $dtku_1_7->DATA;
						if($i != $jmlDT_1_7){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_8(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_8').modal("hide");
	$('#dlg_grafik_1_8').modal("show");


	var ctx = $("#line-grafik_1_8");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_8 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 8) {
						$arr_grafik_per_1_8[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_8 = count($arr_grafik_per_1_8);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_8 as $dtku_1_8){
					$i++;
					echo '"'.$dtku_1_8->BULAN.'"';
					if($i != $jmlDT_1_8){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_8 as $dtku_1_8){
						$i++;
						echo $dtku_1_8->DATA;
						if($i != $jmlDT_1_8){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_9(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_9').modal("hide");
	$('#dlg_grafik_1_9').modal("show");


	var ctx = $("#line-grafik_1_9");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_9 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 9) {
						$arr_grafik_per_1_9[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_9 = count($arr_grafik_per_1_9);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_9 as $dtku_1_9){
					$i++;
					echo '"'.$dtku_1_9->BULAN.'"';
					if($i != $jmlDT_1_9){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_9 as $dtku_1_9){
						$i++;
						echo $dtku_1_9->DATA;
						if($i != $jmlDT_1_9){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_10(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_10').modal("hide");
	$('#dlg_grafik_1_10').modal("show");


	var ctx = $("#line-grafik_1_10");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_10 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 10) {
						$arr_grafik_per_1_10[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_10 = count($arr_grafik_per_1_10);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_10 as $dtku_1_10){
					$i++;
					echo '"'.$dtku_1_10->BULAN.'"';
					if($i != $jmlDT_1_10){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_10 as $dtku_1_10){
						$i++;
						echo $dtku_1_10->DATA;
						if($i != $jmlDT_1_10){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_11(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_11').modal("hide");
	$('#dlg_grafik_1_11').modal("show");


	var ctx = $("#line-grafik_1_11");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_11 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 10) {
						$arr_grafik_per_1_11[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_11 = count($arr_grafik_per_1_11);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_11 as $dtku_1_11){
					$i++;
					echo '"'.$dtku_1_11->BULAN.'"';
					if($i != $jmlDT_1_11){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_11 as $dtku_1_11){
						$i++;
						echo $dtku_1_11->DATA;
						if($i != $jmlDT_1_11){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_12(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_12').modal("hide");
	$('#dlg_grafik_1_12').modal("show");


	var ctx = $("#line-grafik_1_12");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_12 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 12) {
						$arr_grafik_per_1_12[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_12 = count($arr_grafik_per_1_12);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_12 as $dtku_1_12){
					$i++;
					echo '"'.$dtku_1_12->BULAN.'"';
					if($i != $jmlDT_1_12){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_12 as $dtku_1_12){
						$i++;
						echo $dtku_1_12->DATA;
						if($i != $jmlDT_1_12){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_13(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_13').modal("hide");
	$('#dlg_grafik_1_13').modal("show");


	var ctx = $("#line-grafik_1_13");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_13 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 13) {
						$arr_grafik_per_1_13[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_13 = count($arr_grafik_per_1_13);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_13 as $dtku_1_13){
					$i++;
					echo '"'.$dtku_1_13->BULAN.'"';
					if($i != $jmlDT_1_13){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_13 as $dtku_1_13){
						$i++;
						echo $dtku_1_13->DATA;
						if($i != $jmlDT_1_13){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_14(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_14').modal("hide");
	$('#dlg_grafik_1_14').modal("show");


	var ctx = $("#line-grafik_1_14");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_14 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 14) {
						$arr_grafik_per_1_14[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_14 = count($arr_grafik_per_1_14);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_14 as $dtku_1_14){
					$i++;
					echo '"'.$dtku_1_14->BULAN.'"';
					if($i != $jmlDT_1_14){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_14 as $dtku_1_14){
						$i++;
						echo $dtku_1_14->DATA;
						if($i != $jmlDT_1_14){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_15(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_15').modal("hide");
	$('#dlg_grafik_1_15').modal("show");


	var ctx = $("#line-grafik_1_15");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_15 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 15) {
						$arr_grafik_per_1_15[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_15 = count($arr_grafik_per_1_15);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_15 as $dtku_1_15){
					$i++;
					echo '"'.$dtku_1_15->BULAN.'"';
					if($i != $jmlDT_1_15){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_15 as $dtku_1_15){
						$i++;
						echo $dtku_1_15->DATA;
						if($i != $jmlDT_1_15){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_1_16(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_1_16').modal("hide");
	$('#dlg_grafik_1_16').modal("show");


	var ctx = $("#line-grafik_1_16");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_1_16 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 1 && $gr['ID_DATA'] == 16) {
						$arr_grafik_per_1_16[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_1_16 = count($arr_grafik_per_1_16);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_1_16 as $dtku_1_16){
					$i++;
					echo '"'.$dtku_1_16->BULAN.'"';
					if($i != $jmlDT_1_16){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_1_16 as $dtku_1_16){
						$i++;
						echo $dtku_1_16->DATA;
						if($i != $jmlDT_1_16){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

//-----------------REGION 2---------------------------------

function show_grafik_2_0(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_0').modal("hide");
	$('#dlg_grafik_2_0').modal("show");


	var ctx = $("#line-grafik_2_0");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_0 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 0) {
						$arr_grafik_per_2_0[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_0 = count($arr_grafik_per_2_0);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_0 as $dtku_2_0){
					$i++;
					echo '"'.$dtku_2_0->BULAN.'"';
					if($i != $jmlDT_2_0){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_0 as $dtku_2_0){
						$i++;
						echo $dtku_2_0->DATA;
						if($i != $jmlDT_2_0){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_1(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_1').modal("hide");
	$('#dlg_grafik_2_1').modal("show");


	var ctx = $("#line-grafik_2_1");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_1 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 1) {
						$arr_grafik_per_2_1[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_1 = count($arr_grafik_per_2_1);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_1 as $dtku_2_1){
					$i++;
					echo '"'.$dtku_2_1->BULAN.'"';
					if($i != $jmlDT_2_1){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_1 as $dtku_2_1){
						$i++;
						echo $dtku_2_1->DATA;
						if($i != $jmlDT_2_1){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_2(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_2').modal("hide");
	$('#dlg_grafik_2_2').modal("show");


	var ctx = $("#line-grafik_2_2");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_2 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 2) {
						$arr_grafik_per_2_2[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_2 = count($arr_grafik_per_2_2);
				
				// print_r('<pre>');
				// print_r($arr_grafik_per);exit;

				$i = 0;
				foreach ($arr_grafik_per_2_2 as $dtku_2_2){
					$i++;
					echo '"'.$dtku_2_2->BULAN.'"';
					if($i != $jmlDT_2_2){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_2 as $dtku_2_2){
						$i++;
						echo $dtku_2_2->DATA;
						if($i != $jmlDT_2_2){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_3(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_3').modal("hide");
	$('#dlg_grafik_2_3').modal("show");


	var ctx = $("#line-grafik_2_3");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_3 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 3) {
						$arr_grafik_per_2_3[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_3 = count($arr_grafik_per_2_3);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_3 as $dtku_2_3){
					$i++;
					echo '"'.$dtku_2_3->BULAN.'"';
					if($i != $jmlDT_2_3){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_3 as $dtku_2_3){
						$i++;
						echo $dtku_2_3->DATA;
						if($i != $jmlDT_2_3){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_4(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_4').modal("hide");
	$('#dlg_grafik_2_4').modal("show");


	var ctx = $("#line-grafik_2_4");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_4 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 4) {
						$arr_grafik_per_2_4[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_4 = count($arr_grafik_per_2_4);
				
				// print_r('<pre>');
				// print_r($arr_grafik_per);exit;

				$i = 0;
				foreach ($arr_grafik_per_2_4 as $dtku_2_4){
					$i++;
					echo '"'.$dtku_2_4->BULAN.'"';
					if($i != $jmlDT_2_4){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_4 as $dtku_2_4){
						$i++;
						echo $dtku_2_4->DATA;
						if($i != $jmlDT_2_4){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_5(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_5').modal("hide");
	$('#dlg_grafik_2_5').modal("show");


	var ctx = $("#line-grafik_2_5");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_5 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 5) {
						$arr_grafik_per_2_5[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_5 = count($arr_grafik_per_2_5);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_5 as $dtku_2_5){
					$i++;
					echo '"'.$dtku_2_5->BULAN.'"';
					if($i != $jmlDT_2_5){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_5 as $dtku_2_5){
						$i++;
						echo $dtku_2_5->DATA;
						if($i != $jmlDT_2_5){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_6(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_6').modal("hide");
	$('#dlg_grafik_2_6').modal("show");


	var ctx = $("#line-grafik_2_6");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_6 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 6) {
						$arr_grafik_per_2_6[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_6 = count($arr_grafik_per_2_6);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_6 as $dtku_2_6){
					$i++;
					echo '"'.$dtku_2_6->BULAN.'"';
					if($i != $jmlDT_2_6){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_6 as $dtku_2_6){
						$i++;
						echo $dtku_2_6->DATA;
						if($i != $jmlDT_2_6){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_7(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_7').modal("hide");
	$('#dlg_grafik_2_7').modal("show");


	var ctx = $("#line-grafik_2_7");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_7 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 7) {
						$arr_grafik_per_2_7[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_7 = count($arr_grafik_per_2_7);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_7 as $dtku_2_7){
					$i++;
					echo '"'.$dtku_2_7->BULAN.'"';
					if($i != $jmlDT_2_7){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_7 as $dtku_2_7){
						$i++;
						echo $dtku_2_7->DATA;
						if($i != $jmlDT_2_7){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_8(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_8').modal("hide");
	$('#dlg_grafik_2_8').modal("show");


	var ctx = $("#line-grafik_2_8");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_8 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 8) {
						$arr_grafik_per_2_8[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_8 = count($arr_grafik_per_2_8);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_8 as $dtku_2_8){
					$i++;
					echo '"'.$dtku_2_8->BULAN.'"';
					if($i != $jmlDT_2_8){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_8 as $dtku_2_8){
						$i++;
						echo $dtku_2_8->DATA;
						if($i != $jmlDT_2_8){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_9(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_9').modal("hide");
	$('#dlg_grafik_2_9').modal("show");


	var ctx = $("#line-grafik_2_9");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_9 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 9) {
						$arr_grafik_per_2_9[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_9 = count($arr_grafik_per_2_9);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_9 as $dtku_2_9){
					$i++;
					echo '"'.$dtku_2_9->BULAN.'"';
					if($i != $jmlDT_2_9){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_9 as $dtku_2_9){
						$i++;
						echo $dtku_2_9->DATA;
						if($i != $jmlDT_2_9){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_10(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_10').modal("hide");
	$('#dlg_grafik_2_10').modal("show");


	var ctx = $("#line-grafik_2_10");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_10 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 10) {
						$arr_grafik_per_2_10[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_10 = count($arr_grafik_per_2_10);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_10 as $dtku_2_10){
					$i++;
					echo '"'.$dtku_2_10->BULAN.'"';
					if($i != $jmlDT_2_10){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_10 as $dtku_2_10){
						$i++;
						echo $dtku_2_10->DATA;
						if($i != $jmlDT_2_10){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_11(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_11').modal("hide");
	$('#dlg_grafik_2_11').modal("show");


	var ctx = $("#line-grafik_2_11");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_11 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 10) {
						$arr_grafik_per_2_11[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_11 = count($arr_grafik_per_2_11);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_11 as $dtku_2_11){
					$i++;
					echo '"'.$dtku_2_11->BULAN.'"';
					if($i != $jmlDT_2_11){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_11 as $dtku_2_11){
						$i++;
						echo $dtku_2_11->DATA;
						if($i != $jmlDT_2_11){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_12(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_12').modal("hide");
	$('#dlg_grafik_2_12').modal("show");


	var ctx = $("#line-grafik_2_12");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_12 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 12) {
						$arr_grafik_per_2_12[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_12 = count($arr_grafik_per_2_12);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_12 as $dtku_2_12){
					$i++;
					echo '"'.$dtku_2_12->BULAN.'"';
					if($i != $jmlDT_2_12){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_12 as $dtku_2_12){
						$i++;
						echo $dtku_2_12->DATA;
						if($i != $jmlDT_2_12){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_13(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_13').modal("hide");
	$('#dlg_grafik_2_13').modal("show");


	var ctx = $("#line-grafik_2_13");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_13 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 13) {
						$arr_grafik_per_2_13[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_13 = count($arr_grafik_per_2_13);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_13 as $dtku_2_13){
					$i++;
					echo '"'.$dtku_2_13->BULAN.'"';
					if($i != $jmlDT_2_13){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_13 as $dtku_2_13){
						$i++;
						echo $dtku_2_13->DATA;
						if($i != $jmlDT_2_13){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_14(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_14').modal("hide");
	$('#dlg_grafik_2_14').modal("show");


	var ctx = $("#line-grafik_2_14");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_14 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 14) {
						$arr_grafik_per_2_14[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_14 = count($arr_grafik_per_2_14);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_14 as $dtku_2_14){
					$i++;
					echo '"'.$dtku_2_14->BULAN.'"';
					if($i != $jmlDT_2_14){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_14 as $dtku_2_14){
						$i++;
						echo $dtku_2_14->DATA;
						if($i != $jmlDT_2_14){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_15(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_15').modal("hide");
	$('#dlg_grafik_2_15').modal("show");


	var ctx = $("#line-grafik_2_15");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_15 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 15) {
						$arr_grafik_per_2_15[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_15 = count($arr_grafik_per_2_15);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_15 as $dtku_2_15){
					$i++;
					echo '"'.$dtku_2_15->BULAN.'"';
					if($i != $jmlDT_2_15){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_15 as $dtku_2_15){
						$i++;
						echo $dtku_2_15->DATA;
						if($i != $jmlDT_2_15){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_2_16(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_2_16').modal("hide");
	$('#dlg_grafik_2_16').modal("show");


	var ctx = $("#line-grafik_2_16");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_2_16 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 2 && $gr['ID_DATA'] == 16) {
						$arr_grafik_per_2_16[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_2_16 = count($arr_grafik_per_2_16);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_2_16 as $dtku_2_16){
					$i++;
					echo '"'.$dtku_2_16->BULAN.'"';
					if($i != $jmlDT_2_16){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_2_16 as $dtku_2_16){
						$i++;
						echo $dtku_2_16->DATA;
						if($i != $jmlDT_2_16){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

//-----------------REGION 3---------------------------------

function show_grafik_3_0(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_0').modal("hide");
	$('#dlg_grafik_3_0').modal("show");


	var ctx = $("#line-grafik_3_0");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_0 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 0) {
						$arr_grafik_per_3_0[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_0 = count($arr_grafik_per_3_0);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_0 as $dtku_3_0){
					$i++;
					echo '"'.$dtku_3_0->BULAN.'"';
					if($i != $jmlDT_3_0){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_0 as $dtku_3_0){
						$i++;
						echo $dtku_3_0->DATA;
						if($i != $jmlDT_3_0){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_1(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_1').modal("hide");
	$('#dlg_grafik_3_1').modal("show");


	var ctx = $("#line-grafik_3_1");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_1 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 1) {
						$arr_grafik_per_3_1[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_1 = count($arr_grafik_per_3_1);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_1 as $dtku_3_1){
					$i++;
					echo '"'.$dtku_3_1->BULAN.'"';
					if($i != $jmlDT_3_1){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_1 as $dtku_3_1){
						$i++;
						echo $dtku_3_1->DATA;
						if($i != $jmlDT_3_1){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_2(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_2').modal("hide");
	$('#dlg_grafik_3_2').modal("show");


	var ctx = $("#line-grafik_3_2");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_2 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 2) {
						$arr_grafik_per_3_2[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_2 = count($arr_grafik_per_3_2);
				
				// print_r('<pre>');
				// print_r($arr_grafik_per);exit;

				$i = 0;
				foreach ($arr_grafik_per_3_2 as $dtku_3_2){
					$i++;
					echo '"'.$dtku_3_2->BULAN.'"';
					if($i != $jmlDT_3_2){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_2 as $dtku_3_2){
						$i++;
						echo $dtku_3_2->DATA;
						if($i != $jmlDT_3_2){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_3(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_3').modal("hide");
	$('#dlg_grafik_3_3').modal("show");


	var ctx = $("#line-grafik_3_3");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_3 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 3) {
						$arr_grafik_per_3_3[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_3 = count($arr_grafik_per_3_3);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_3 as $dtku_3_3){
					$i++;
					echo '"'.$dtku_3_3->BULAN.'"';
					if($i != $jmlDT_3_3){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_3 as $dtku_3_3){
						$i++;
						echo $dtku_3_3->DATA;
						if($i != $jmlDT_3_3){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_4(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_4').modal("hide");
	$('#dlg_grafik_3_4').modal("show");


	var ctx = $("#line-grafik_3_4");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_4 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 4) {
						$arr_grafik_per_3_4[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_4 = count($arr_grafik_per_3_4);
				
				// print_r('<pre>');
				// print_r($arr_grafik_per);exit;

				$i = 0;
				foreach ($arr_grafik_per_3_4 as $dtku_3_4){
					$i++;
					echo '"'.$dtku_3_4->BULAN.'"';
					if($i != $jmlDT_3_4){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_4 as $dtku_3_4){
						$i++;
						echo $dtku_3_4->DATA;
						if($i != $jmlDT_3_4){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_5(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_5').modal("hide");
	$('#dlg_grafik_3_5').modal("show");


	var ctx = $("#line-grafik_3_5");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_5 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 5) {
						$arr_grafik_per_3_5[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_5 = count($arr_grafik_per_3_5);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_5 as $dtku_3_5){
					$i++;
					echo '"'.$dtku_3_5->BULAN.'"';
					if($i != $jmlDT_3_5){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_5 as $dtku_3_5){
						$i++;
						echo $dtku_3_5->DATA;
						if($i != $jmlDT_3_5){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_6(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_6').modal("hide");
	$('#dlg_grafik_3_6').modal("show");


	var ctx = $("#line-grafik_3_6");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_6 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 6) {
						$arr_grafik_per_3_6[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_6 = count($arr_grafik_per_3_6);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_6 as $dtku_3_6){
					$i++;
					echo '"'.$dtku_3_6->BULAN.'"';
					if($i != $jmlDT_3_6){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_6 as $dtku_3_6){
						$i++;
						echo $dtku_3_6->DATA;
						if($i != $jmlDT_3_6){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_7(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_7').modal("hide");
	$('#dlg_grafik_3_7').modal("show");


	var ctx = $("#line-grafik_3_7");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_7 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 7) {
						$arr_grafik_per_3_7[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_7 = count($arr_grafik_per_3_7);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_7 as $dtku_3_7){
					$i++;
					echo '"'.$dtku_3_7->BULAN.'"';
					if($i != $jmlDT_3_7){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_7 as $dtku_3_7){
						$i++;
						echo $dtku_3_7->DATA;
						if($i != $jmlDT_3_7){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_8(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_8').modal("hide");
	$('#dlg_grafik_3_8').modal("show");


	var ctx = $("#line-grafik_3_8");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_8 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 8) {
						$arr_grafik_per_3_8[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_8 = count($arr_grafik_per_3_8);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_8 as $dtku_3_8){
					$i++;
					echo '"'.$dtku_3_8->BULAN.'"';
					if($i != $jmlDT_3_8){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_8 as $dtku_3_8){
						$i++;
						echo $dtku_3_8->DATA;
						if($i != $jmlDT_3_8){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_9(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_9').modal("hide");
	$('#dlg_grafik_3_9').modal("show");


	var ctx = $("#line-grafik_3_9");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_9 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 9) {
						$arr_grafik_per_3_9[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_9 = count($arr_grafik_per_3_9);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_9 as $dtku_3_9){
					$i++;
					echo '"'.$dtku_3_9->BULAN.'"';
					if($i != $jmlDT_3_9){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_9 as $dtku_3_9){
						$i++;
						echo $dtku_3_9->DATA;
						if($i != $jmlDT_3_9){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_10(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_10').modal("hide");
	$('#dlg_grafik_3_10').modal("show");


	var ctx = $("#line-grafik_3_10");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_10 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 10) {
						$arr_grafik_per_3_10[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_10 = count($arr_grafik_per_3_10);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_10 as $dtku_3_10){
					$i++;
					echo '"'.$dtku_3_10->BULAN.'"';
					if($i != $jmlDT_3_10){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_10 as $dtku_3_10){
						$i++;
						echo $dtku_3_10->DATA;
						if($i != $jmlDT_3_10){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_11(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_11').modal("hide");
	$('#dlg_grafik_3_11').modal("show");


	var ctx = $("#line-grafik_3_11");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_11 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 10) {
						$arr_grafik_per_3_11[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_11 = count($arr_grafik_per_3_11);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_11 as $dtku_3_11){
					$i++;
					echo '"'.$dtku_3_11->BULAN.'"';
					if($i != $jmlDT_3_11){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_11 as $dtku_3_11){
						$i++;
						echo $dtku_3_11->DATA;
						if($i != $jmlDT_3_11){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_12(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_12').modal("hide");
	$('#dlg_grafik_3_12').modal("show");


	var ctx = $("#line-grafik_3_12");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_12 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 12) {
						$arr_grafik_per_3_12[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_12 = count($arr_grafik_per_3_12);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_12 as $dtku_3_12){
					$i++;
					echo '"'.$dtku_3_12->BULAN.'"';
					if($i != $jmlDT_3_12){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_12 as $dtku_3_12){
						$i++;
						echo $dtku_3_12->DATA;
						if($i != $jmlDT_3_12){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_13(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_13').modal("hide");
	$('#dlg_grafik_3_13').modal("show");


	var ctx = $("#line-grafik_3_13");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_13 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 13) {
						$arr_grafik_per_3_13[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_13 = count($arr_grafik_per_3_13);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_13 as $dtku_3_13){
					$i++;
					echo '"'.$dtku_3_13->BULAN.'"';
					if($i != $jmlDT_3_13){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_13 as $dtku_3_13){
						$i++;
						echo $dtku_3_13->DATA;
						if($i != $jmlDT_3_13){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_14(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_14').modal("hide");
	$('#dlg_grafik_3_14').modal("show");


	var ctx = $("#line-grafik_3_14");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_14 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 14) {
						$arr_grafik_per_3_14[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_14 = count($arr_grafik_per_3_14);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_14 as $dtku_3_14){
					$i++;
					echo '"'.$dtku_3_14->BULAN.'"';
					if($i != $jmlDT_3_14){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_14 as $dtku_3_14){
						$i++;
						echo $dtku_3_14->DATA;
						if($i != $jmlDT_3_14){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_15(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_15').modal("hide");
	$('#dlg_grafik_3_15').modal("show");


	var ctx = $("#line-grafik_3_15");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_15 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 15) {
						$arr_grafik_per_3_15[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_15 = count($arr_grafik_per_3_15);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_15 as $dtku_3_15){
					$i++;
					echo '"'.$dtku_3_15->BULAN.'"';
					if($i != $jmlDT_3_15){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_15 as $dtku_3_15){
						$i++;
						echo $dtku_3_15->DATA;
						if($i != $jmlDT_3_15){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_3_16(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_3_16').modal("hide");
	$('#dlg_grafik_3_16').modal("show");


	var ctx = $("#line-grafik_3_16");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_3_16 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 3 && $gr['ID_DATA'] == 16) {
						$arr_grafik_per_3_16[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_3_16 = count($arr_grafik_per_3_16);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_3_16 as $dtku_3_16){
					$i++;
					echo '"'.$dtku_3_16->BULAN.'"';
					if($i != $jmlDT_3_16){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_3_16 as $dtku_3_16){
						$i++;
						echo $dtku_3_16->DATA;
						if($i != $jmlDT_3_16){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

//-----------------REGION 4---------------------------------

function show_grafik_4_0(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_0').modal("hide");
	$('#dlg_grafik_4_0').modal("show");


	var ctx = $("#line-grafik_4_0");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_0 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 0) {
						$arr_grafik_per_4_0[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_0 = count($arr_grafik_per_4_0);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_0 as $dtku_4_0){
					$i++;
					echo '"'.$dtku_4_0->BULAN.'"';
					if($i != $jmlDT_4_0){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_0 as $dtku_4_0){
						$i++;
						echo $dtku_4_0->DATA;
						if($i != $jmlDT_4_0){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_1(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_1').modal("hide");
	$('#dlg_grafik_4_1').modal("show");


	var ctx = $("#line-grafik_4_1");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_1 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 1) {
						$arr_grafik_per_4_1[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_1 = count($arr_grafik_per_4_1);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_1 as $dtku_4_1){
					$i++;
					echo '"'.$dtku_4_1->BULAN.'"';
					if($i != $jmlDT_4_1){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_1 as $dtku_4_1){
						$i++;
						echo $dtku_4_1->DATA;
						if($i != $jmlDT_4_1){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_2(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_2').modal("hide");
	$('#dlg_grafik_4_2').modal("show");


	var ctx = $("#line-grafik_4_2");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_2 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 2) {
						$arr_grafik_per_4_2[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_2 = count($arr_grafik_per_4_2);
				
				// print_r('<pre>');
				// print_r($arr_grafik_per);exit;

				$i = 0;
				foreach ($arr_grafik_per_4_2 as $dtku_4_2){
					$i++;
					echo '"'.$dtku_4_2->BULAN.'"';
					if($i != $jmlDT_4_2){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_2 as $dtku_4_2){
						$i++;
						echo $dtku_4_2->DATA;
						if($i != $jmlDT_4_2){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_3(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_3').modal("hide");
	$('#dlg_grafik_4_3').modal("show");


	var ctx = $("#line-grafik_4_3");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_3 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 3) {
						$arr_grafik_per_4_3[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_3 = count($arr_grafik_per_4_3);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_3 as $dtku_4_3){
					$i++;
					echo '"'.$dtku_4_3->BULAN.'"';
					if($i != $jmlDT_4_3){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_3 as $dtku_4_3){
						$i++;
						echo $dtku_4_3->DATA;
						if($i != $jmlDT_4_3){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_4(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_4').modal("hide");
	$('#dlg_grafik_4_4').modal("show");


	var ctx = $("#line-grafik_4_4");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_4 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 4) {
						$arr_grafik_per_4_4[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_4 = count($arr_grafik_per_4_4);
				
				// print_r('<pre>');
				// print_r($arr_grafik_per);exit;

				$i = 0;
				foreach ($arr_grafik_per_4_4 as $dtku_4_4){
					$i++;
					echo '"'.$dtku_4_4->BULAN.'"';
					if($i != $jmlDT_4_4){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_4 as $dtku_4_4){
						$i++;
						echo $dtku_4_4->DATA;
						if($i != $jmlDT_4_4){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_5(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_5').modal("hide");
	$('#dlg_grafik_4_5').modal("show");


	var ctx = $("#line-grafik_4_5");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_5 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 5) {
						$arr_grafik_per_4_5[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_5 = count($arr_grafik_per_4_5);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_5 as $dtku_4_5){
					$i++;
					echo '"'.$dtku_4_5->BULAN.'"';
					if($i != $jmlDT_4_5){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_5 as $dtku_4_5){
						$i++;
						echo $dtku_4_5->DATA;
						if($i != $jmlDT_4_5){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_6(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_6').modal("hide");
	$('#dlg_grafik_4_6').modal("show");


	var ctx = $("#line-grafik_4_6");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_6 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 6) {
						$arr_grafik_per_4_6[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_6 = count($arr_grafik_per_4_6);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_6 as $dtku_4_6){
					$i++;
					echo '"'.$dtku_4_6->BULAN.'"';
					if($i != $jmlDT_4_6){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_6 as $dtku_4_6){
						$i++;
						echo $dtku_4_6->DATA;
						if($i != $jmlDT_4_6){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_7(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_7').modal("hide");
	$('#dlg_grafik_4_7').modal("show");


	var ctx = $("#line-grafik_4_7");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_7 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 7) {
						$arr_grafik_per_4_7[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_7 = count($arr_grafik_per_4_7);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_7 as $dtku_4_7){
					$i++;
					echo '"'.$dtku_4_7->BULAN.'"';
					if($i != $jmlDT_4_7){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_7 as $dtku_4_7){
						$i++;
						echo $dtku_4_7->DATA;
						if($i != $jmlDT_4_7){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_8(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_8').modal("hide");
	$('#dlg_grafik_4_8').modal("show");


	var ctx = $("#line-grafik_4_8");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_8 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 8) {
						$arr_grafik_per_4_8[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_8 = count($arr_grafik_per_4_8);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_8 as $dtku_4_8){
					$i++;
					echo '"'.$dtku_4_8->BULAN.'"';
					if($i != $jmlDT_4_8){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_8 as $dtku_4_8){
						$i++;
						echo $dtku_4_8->DATA;
						if($i != $jmlDT_4_8){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_9(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_9').modal("hide");
	$('#dlg_grafik_4_9').modal("show");


	var ctx = $("#line-grafik_4_9");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_9 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 9) {
						$arr_grafik_per_4_9[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_9 = count($arr_grafik_per_4_9);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_9 as $dtku_4_9){
					$i++;
					echo '"'.$dtku_4_9->BULAN.'"';
					if($i != $jmlDT_4_9){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_9 as $dtku_4_9){
						$i++;
						echo $dtku_4_9->DATA;
						if($i != $jmlDT_4_9){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_10(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_10').modal("hide");
	$('#dlg_grafik_4_10').modal("show");


	var ctx = $("#line-grafik_4_10");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_10 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 10) {
						$arr_grafik_per_4_10[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_10 = count($arr_grafik_per_4_10);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_10 as $dtku_4_10){
					$i++;
					echo '"'.$dtku_4_10->BULAN.'"';
					if($i != $jmlDT_4_10){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_10 as $dtku_4_10){
						$i++;
						echo $dtku_4_10->DATA;
						if($i != $jmlDT_4_10){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_11(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_11').modal("hide");
	$('#dlg_grafik_4_11').modal("show");


	var ctx = $("#line-grafik_4_11");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_11 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 10) {
						$arr_grafik_per_4_11[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_11 = count($arr_grafik_per_4_11);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_11 as $dtku_4_11){
					$i++;
					echo '"'.$dtku_4_11->BULAN.'"';
					if($i != $jmlDT_4_11){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_11 as $dtku_4_11){
						$i++;
						echo $dtku_4_11->DATA;
						if($i != $jmlDT_4_11){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_12(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_12').modal("hide");
	$('#dlg_grafik_4_12').modal("show");


	var ctx = $("#line-grafik_4_12");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_12 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 12) {
						$arr_grafik_per_4_12[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_12 = count($arr_grafik_per_4_12);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_12 as $dtku_4_12){
					$i++;
					echo '"'.$dtku_4_12->BULAN.'"';
					if($i != $jmlDT_4_12){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_12 as $dtku_4_12){
						$i++;
						echo $dtku_4_12->DATA;
						if($i != $jmlDT_4_12){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_13(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_13').modal("hide");
	$('#dlg_grafik_4_13').modal("show");


	var ctx = $("#line-grafik_4_13");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_13 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 13) {
						$arr_grafik_per_4_13[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_13 = count($arr_grafik_per_4_13);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_13 as $dtku_4_13){
					$i++;
					echo '"'.$dtku_4_13->BULAN.'"';
					if($i != $jmlDT_4_13){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_13 as $dtku_4_13){
						$i++;
						echo $dtku_4_13->DATA;
						if($i != $jmlDT_4_13){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_14(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_14').modal("hide");
	$('#dlg_grafik_4_14').modal("show");


	var ctx = $("#line-grafik_4_14");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_14 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 14) {
						$arr_grafik_per_4_14[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_14 = count($arr_grafik_per_4_14);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_14 as $dtku_4_14){
					$i++;
					echo '"'.$dtku_4_14->BULAN.'"';
					if($i != $jmlDT_4_14){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_14 as $dtku_4_14){
						$i++;
						echo $dtku_4_14->DATA;
						if($i != $jmlDT_4_14){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_15(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_15').modal("hide");
	$('#dlg_grafik_4_15').modal("show");


	var ctx = $("#line-grafik_4_15");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_15 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 15) {
						$arr_grafik_per_4_15[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_15 = count($arr_grafik_per_4_15);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_15 as $dtku_4_15){
					$i++;
					echo '"'.$dtku_4_15->BULAN.'"';
					if($i != $jmlDT_4_15){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_15 as $dtku_4_15){
						$i++;
						echo $dtku_4_15->DATA;
						if($i != $jmlDT_4_15){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

function show_grafik_4_16(rgn, dt_baris) {
	console.log(rgn+'-'+dt_baris);
	$('#dlg_detail1').modal("hide");
	$('#dlg_detail2').modal("hide");
	$('#dlg_detail3').modal("hide");
	$('#dlg_detail4').modal("hide");
	$('#dlg_grafik_4_16').modal("hide");
	$('#dlg_grafik_4_16').modal("show");


	var ctx = $("#line-grafik_4_16");
	var lineChart = new Chart(ctx, {
	  type: 'line',
	  data: {
	    labels: [
			<?php

				$arr_grafik_per_4_16 = array();

				foreach ($arr_grafik as $gr) {
					if ($gr['ID_REGION'] == 4 && $gr['ID_DATA'] == 16) {
						$arr_grafik_per_4_16[] = (object)array(
				            'ID_REGION' 	=> $gr['ID_REGION'],
				            'ID_DATA' 		=> $gr['ID_DATA'],
				            'JENIS_DATA'	=> $gr['JENIS_DATA'],
				            'BULAN' 		=> $gr['BULAN'],
				            'DATA' 			=> $gr['DATA']
						);
					}
					
				}

				$jmlDT_4_16 = count($arr_grafik_per_4_16);
				
				// print_r('<pre>');
				// print_r($kunjungans);exit;
				$i = 0;
				foreach ($arr_grafik_per_4_16 as $dtku_4_16){
					$i++;
					echo '"'.$dtku_4_16->BULAN.'"';
					if($i != $jmlDT_4_16){
						echo ',';
					}
				}
			?>
	    ],
	    datasets: [
	      {
	        label: jenis_data(dt_baris),
	        data: [
				<?php
					//$jmlDT = count($kunjungans);
					$i = 0;
					foreach ($arr_grafik_per_4_16 as $dtku_4_16){
						$i++;
						echo $dtku_4_16->DATA;
						if($i != $jmlDT_4_16){
							echo ',';
						}
					}
				?>
	        ]
	      }
	    ]
	  }
	});

}

$(function () {

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


});


</script>

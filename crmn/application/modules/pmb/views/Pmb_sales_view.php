

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
				<div class="card">
					<div class="header header-title">
						<h2>performance monitoring board (PMB) salesman</h2> 
					</div>
					<div class="body" style="margin: 0 1em 0 1em;">
                        <div class="row">
							
							<div class="col-md-12">
                                    <div class="col-md-2">
                                        Filter Bulan : 
                                        <select id="filterBulan" class="form-control show-tick" data-size="5">
                                            <option>Pilih Bulan</option>
                                            <?php 
                                            for($j=1;$j<=12;$j++){
                                                $dateObj   = DateTime::createFromFormat('!m', $j);
                                                $monthName = $dateObj->format('F');
                                                ?>
                                                <option value="<?php echo $j; ?>" <?php if($j == date('m')){ echo "selected";} ?>><?php echo $monthName; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        Filter Tahun : 
                                        <select id="filterTahun" class="form-control show-tick" data-size="5">
                                            <option>Pilih Tahun</option>
                                            <?php for($j=date('Y')-4;$j<=date('Y');$j++){ ?>
                                            <option value="<?php echo $j; ?>" <?php if(date('Y') == $j){ echo "selected";} ?>><?php echo $j; ?></option>
                                            <?php } ?>
                                        </select>
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
										<?php
											$today = date('d-M-Y');
											$dateOfTheDay = date('d');
											$lastDateOfMonth = date("t", strtotime($today));
											$hariBerjalan = $dateOfTheDay; 
											$persenHB = ($hariBerjalan/$lastDateOfMonth)*100;
											$sisaHari = $lastDateOfMonth-$dateOfTheDay;
											$persenSH = ($sisaHari/$lastDateOfMonth)*100;
										?>
										<th colspan="8"> Tanggal cetak: <?= $today; ?> <span style="float:right;font-weight: normal; ">(Data PMB Bulan <b><?= date('F') ?></b> Tahun <b><?= date('Y') ?></b>)</span>  </th>
										
										<th colspan="6"> Hari Berjalan : <?= $hariBerjalan; ?>  hari <span style="float:right;">[ <?= number_format(round($persenHB, 2),2,',','.'); ?>% ]</span> </th>
										<th colspan="6"> Sisa Hari : <?= $sisaHari; ?> hari <span style="float:right;">[ <?= number_format(round($persenSH, 2),2,',','.'); ?>% ]</span> </th>
									</tr>
									<tr>
										<th style="width: 5%; text-align: center; vertical-align: middle;" rowspan="2">No.</th>
										<th style="text-align: center; vertical-align: middle;" rowspan="2">SALESMAN</th>
										<th style="text-align: center; background: #feca57;" colspan="3">Toko (Unit)</th>
										<th style="text-align: center; background: #a29bfe;" colspan="3">Kunjungan (Kali)</th>
										<th style="text-align: center; background: #48dbfb;" colspan="3">Kunjungan Efektif (Kali)</th>
										<th style="text-align: center; background: #1dd1a1;" colspan="3">Toko Aktif (Unit)</th>
										<th style="text-align: center; background: #55efc4;" colspan="3">Toko Baru (Unit)</th>
										<th style="text-align: center; background: #e67e22;" colspan="3">Volume (Ton)</th>
									</tr>
									<tr>
										<th style="text-align: center; background: #feca57;">Target</th>
										<th style="text-align: center; background: #feca57;">Actual</th>
										<th style="text-align: center; background: #feca57;">%</th>
										
										<th style="text-align: center; background: #a29bfe;">Target</th>
										<th style="text-align: center; background: #a29bfe;">Actual</th>
										<th style="text-align: center; background: #a29bfe;">%</th>
										
										<th style="text-align: center; background: #48dbfb;">Target</th>
										<th style="text-align: center; background: #48dbfb;">Actual</th>
										<th style="text-align: center; background: #48dbfb;">%</th>
										
										<th style="text-align: center; background: #1dd1a1;">Target</th>
										<th style="text-align: center; background: #1dd1a1;">Actual</th>
										<th style="text-align: center; background: #1dd1a1;">%</th>
										
										<th style="text-align: center; background: #55efc4;">Target</th>
										<th style="text-align: center; background: #55efc4;">Actual</th>
										<th style="text-align: center; background: #55efc4;">%</th>
										
										<th style="text-align: center; background: #e67e22;">Target</th>
										<th style="text-align: center; background: #e67e22;">Actual</th>
										<th style="text-align: center; background: #e67e22;">%</th>
									</tr>
								</thead>
								<tbody>
								
								<?php 
								$count = 1;
								
								$toko_t_tot 		= 0; 	$toko_a_tot 		= 0;
								$kunjungan_t_tot 	= 0; 	$kunjungan_a_tot 	= 0;
								$ke_t_tot 			= 0; 	$ke_a_tot 			= 0;
								$ta_t_tot			= 0;	$ta_a_tot			= 0;
								$tb_t_tot 			= 0; 	$tb_a_tot 			= 0;
								$vol_t_tot			= 0;	$vol_a_tot			= 0;
								
								foreach($dummys as $dt_pmb){  ?>
									<tr>
										<td style="text-align: center;"><?= $count; ?> </td>
										<td> <?= $dt_pmb['salesman'] ?> </td>
										
										<td> <?= number_format($dt_pmb['toko_t'],0,',','.'); ?> </td>
										<td> <?= number_format($dt_pmb['toko_a'],0,',','.'); ?> </td>
										<td style="text-align: center;"> <?= number_format(round((($dt_pmb['toko_a']/$dt_pmb['toko_t'])*100),2),2,',','.'); ?>%</td>
										
										<td> <?= number_format($dt_pmb['kunjungan_t'],0,',','.'); ?> </td>
										<td> <?= number_format($dt_pmb['kunjungan_a'],0,',','.'); ?> </td>
										<td style="text-align: center;"> <?= number_format(round((($dt_pmb['kunjungan_a']/$dt_pmb['kunjungan_t'])*100),2),2,',','.'); ?>%</td>
										
										<td> <?= number_format($dt_pmb['ke_t'],0,',','.'); ?> </td>
										<td> <?= number_format($dt_pmb['ke_a'],0,',','.'); ?> </td>
										<td style="text-align: center;"> <?= number_format(round((($dt_pmb['ke_a']/$dt_pmb['ke_t'])*100),2),2,',','.'); ?>%</td>
										
										<td> <?= number_format($dt_pmb['ta_t'],0,',','.'); ?> </td>
										<td> <?= number_format($dt_pmb['ta_a'],0,',','.'); ?> </td>
										<td style="text-align: center;"> <?= number_format(round((($dt_pmb['ta_a']/$dt_pmb['ta_t'])*100),2),2,',','.'); ?>%</td>
										
										<td> <?= number_format($dt_pmb['tb_t'],0,',','.'); ?> </td>
										<td> <?= number_format($dt_pmb['tb_a'],0,',','.'); ?> </td>
										<td style="text-align: center;"> <?= number_format(round((($dt_pmb['tb_a']/$dt_pmb['tb_t'])*100),2),2,',','.'); ?>%</td>
										
										<td> <?= number_format($dt_pmb['vol_t'],0,',','.'); ?> </td>
										<td> <?= number_format($dt_pmb['vol_a'],0,',','.'); ?> </td>
										<td style="text-align: center;"> <?= number_format(round((($dt_pmb['vol_a']/$dt_pmb['vol_t'])*100),2),2,',','.'); ?>%</td>
									</tr>
								<?php 
								$count++;
								
								$toko_t_tot 		+= $dt_pmb['toko_t']; 		$toko_a_tot 		+= $dt_pmb['toko_a'];
								$kunjungan_t_tot 	+= $dt_pmb['kunjungan_t']; 	$kunjungan_a_tot 	+= $dt_pmb['kunjungan_a'];;
								$ke_t_tot 			+= $dt_pmb['ke_t']; 		$ke_a_tot 			+= $dt_pmb['ke_a'];
								$ta_t_tot			+= $dt_pmb['ta_t'];			$ta_a_tot			+= $dt_pmb['ta_a'];
								$tb_t_tot 			+= $dt_pmb['tb_t']; 		$tb_a_tot 			+= $dt_pmb['tb_a'];
								$vol_t_tot			+= $dt_pmb['vol_t'];		$vol_a_tot			+= $dt_pmb['vol_a'];
								
								}  ?>
								
								</tbody>
								<tfoot>
								
									<tr>
										<th colspan="2" style="text-align: center; vertical-align: middle;"> TOTAL </th>
										
										<th style="text-align: center; background: #feca57;"> <?= number_format($toko_t_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #feca57;"> <?= number_format($toko_a_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #feca57;"> <?= number_format(round((($toko_a_tot/$toko_t_tot)*100),2),2,',','.'); ?>% </th>
										
										<th style="text-align: center; background: #a29bfe;"> <?= number_format($kunjungan_t_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #a29bfe;"> <?= number_format($kunjungan_a_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #a29bfe;"> <?= number_format(round((($kunjungan_a_tot/$kunjungan_t_tot)*100),2),2,',','.'); ?>% </th>
										
										<th style="text-align: center; background: #48dbfb;"> <?= number_format($ke_t_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #48dbfb;"> <?= number_format($ke_a_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #48dbfb;"> <?= number_format(round((($ke_a_tot/$ke_t_tot)*100),2),2,',','.'); ?>% </th>
										
										<th style="text-align: center; background: #1dd1a1;"> <?= number_format($ta_t_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #1dd1a1;"> <?= number_format($ta_a_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #1dd1a1;"> <?= number_format(round((($ta_a_tot/$ta_t_tot)*100),2),2,',','.'); ?>% </th>
										
										<th style="text-align: center; background: #55efc4;"> <?= number_format($tb_t_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #55efc4;"> <?= number_format($tb_a_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #55efc4;"> <?= number_format(round((($tb_a_tot/$tb_t_tot)*100),2),2,',','.'); ?>% </th>
										
										<th style="text-align: center; background: #e67e22;"> <?= number_format($vol_t_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #e67e22;"> <?= number_format($vol_a_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #e67e22;"> <?= number_format(round((($vol_a_tot/$vol_t_tot)*100),2),2,',','.'); ?>% </th>
									</tr>
								
								</tfoot>
							</table>
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
	$(document).ready(function() {
    	$('#table_data').DataTable({
			"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
		});
	});
</script>
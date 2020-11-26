

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
				<div class="card">
					<div class="header header-title">
						<h2>performance monitoring board (PMB) distributor</h2> 
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
										
										<th colspan="3"> Hari Berjalan : <?= $hariBerjalan; ?>  hari <span style="float:right;">[ <?= number_format(round($persenHB, 2),2,',','.'); ?>% ]</span> </th>
										<th colspan="3"> Sisa Hari : <?= $sisaHari; ?> hari <span style="float:right;">[ <?= number_format(round($persenSH, 2),2,',','.'); ?>% ]</span> </th>
									</tr>
									<tr>
										<th style="width: 5%; text-align: center; vertical-align: middle;" rowspan="2">No.</th>
										<th style="text-align: center; vertical-align: middle;" rowspan="2">DISTRIBUTOR</th>
										<th style="text-align: center; background: #feca57;" colspan="3">Volume (Ton)</th>
										<th style="text-align: center; background: #ff6b6b;" colspan="3">SO Clean & Clear (Ton)</th>
										<th style="text-align: center; background: #48dbfb;" colspan="3">Revenue (Rp Juta)</th>
										<th style="text-align: center; background: #1dd1a1;" colspan="3">ACP (Hari)</th>
									</tr>
									<tr>
										<th style="text-align: center; background: #feca57;">Target</th>
										<th style="text-align: center; background: #feca57;">Actual</th>
										<th style="text-align: center; background: #feca57;">%</th>
										
										<th style="text-align: center; background: #ff6b6b;">Target</th>
										<th style="text-align: center; background: #ff6b6b;">Actual</th>
										<th style="text-align: center; background: #ff6b6b;">%</th>
										
										<th style="text-align: center; background: #48dbfb;">Target</th>
										<th style="text-align: center; background: #48dbfb;">Actual</th>
										<th style="text-align: center; background: #48dbfb;">%</th>
										
										<th style="text-align: center; background: #1dd1a1;">Target</th>
										<th style="text-align: center; background: #1dd1a1;">Actual</th>
										<th style="text-align: center; background: #1dd1a1;">%</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$count = 1;
								
								$volume_t_tot 	= 0; 	$volume_a_tot 	= 0;
								$so_t_tot 		= 0; 	$so_a_tot 		= 0;
								$revenue_t_tot 	= 0; 	$revenue_a_tot 	= 0;
								$acp_t_tot		= 0;	$acp_a_tot		= 0;
								
								foreach($dummys as $dt_pmb){  ?>
									<tr>
										<td style="text-align: center;"><?= $count; ?> </td>
										<td> <?= $dt_pmb['distributor'] ?> </td>
										
										<td> <?= number_format($dt_pmb['volume_t'],0,',','.'); ?> </td>
										<td> <?= number_format($dt_pmb['volume_a'],0,',','.'); ?> </td>
										<td style="text-align: center;"> <?= number_format(round((($dt_pmb['volume_a']/$dt_pmb['volume_t'])*100),2),2,',','.'); ?>%</td>
										
										<td> <?= number_format($dt_pmb['so_t'],0,',','.'); ?> </td>
										<td> <?= number_format($dt_pmb['so_a'],0,',','.'); ?> </td>
										<td style="text-align: center;"> <?= number_format(round((($dt_pmb['so_a']/$dt_pmb['so_t'])*100),2),2,',','.'); ?>%</td>
										
										<td> <?= number_format($dt_pmb['revenue_t'],0,',','.'); ?> </td>
										<td> <?= number_format($dt_pmb['revenue_a'],0,',','.'); ?> </td>
										<td style="text-align: center;"> <?= number_format(round((($dt_pmb['revenue_a']/$dt_pmb['revenue_t'])*100),2),2,',','.'); ?>%</td>
										
										<td> <?= number_format($dt_pmb['acp_t'],0,',','.'); ?> </td>
										<td> <?= number_format($dt_pmb['acp_a'],0,',','.'); ?> </td>
										<td style="text-align: center;"> <?= number_format(round((($dt_pmb['acp_a']/$dt_pmb['acp_t'])*100),2),2,',','.'); ?>%</td>
									</tr>
								<?php 
								$count++;
								
								$volume_t_tot 	+= $dt_pmb['volume_t']; 	$volume_a_tot 	+= $dt_pmb['volume_a']; ;
								$so_t_tot 		+= $dt_pmb['so_t']; 		$so_a_tot 		+= $dt_pmb['so_a'];
								$revenue_t_tot 	+= $dt_pmb['revenue_t']; 	$revenue_a_tot 	+= $dt_pmb['revenue_a'];
								$acp_t_tot		+= $dt_pmb['acp_t'];		$acp_a_tot			+= $dt_pmb['acp_a'];
								
								}  ?>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="2" style="text-align: center; vertical-align: middle;"> TOTAL </th>
										
										<th style="text-align: center; background: #feca57;"> <?= number_format($volume_t_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #feca57;"> <?= number_format($volume_a_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #feca57;"> <?= number_format(round((($volume_a_tot/$volume_t_tot)*100),2),2,',','.'); ?>% </th>
										
										<th style="text-align: center; background: #ff6b6b;"> <?= number_format($so_t_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #ff6b6b;"> <?= number_format($so_a_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #ff6b6b;"> <?= number_format(round((($so_a_tot/$so_t_tot)*100),2),2,',','.'); ?>% </th>
										
										<th style="text-align: center; background: #48dbfb;"> <?= number_format($revenue_t_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #48dbfb;"> <?= number_format($revenue_a_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #48dbfb;"> <?= number_format(round((($revenue_a_tot/$revenue_t_tot)*100),2),2,',','.'); ?>% </th>
										
										<th style="text-align: center; background: #1dd1a1;"> <?= number_format($acp_t_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #1dd1a1;"> <?= number_format($acp_a_tot,0,',','.'); ?> </th>
										<th style="text-align: center; background: #1dd1a1;"> <?= number_format(round((($acp_a_tot/$acp_t_tot)*100),2),2,',','.'); ?>% </th>
									</tr>
								</tfoot>
							</table>
							
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
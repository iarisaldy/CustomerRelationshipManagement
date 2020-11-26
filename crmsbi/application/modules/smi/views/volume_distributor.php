<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <a href=""></a>
                <div class="card">
					<div class="header bg-cyan">
                        <h2>Volume Distributor </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                        	<div class="col-md-12">
                        		<form action="" method="post">
                        		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                        			<b>Bulan</b>
                        			<select data-size="5" id="filterBulan" name="filterBulan" class="form-control show-tick">
                                        <option>Pilih Bulan</option>
                                        <?php 
                                        for($j=1;$j<=12;$j++){
                                            $dateObj   = DateTime::createFromFormat('!m', $j);
                                            $monthName = $dateObj->format('F');
                                            if($j<10){
                                            	$b='0'. $j;
                                            }
                                            else {
                                            	$b=$j;
                                            }
                                            ?>
                                            <option value="<?php echo $b; ?>" <?php if($j == $bulan){ echo "selected";} ?>><?php echo $monthName; ?></option>
                                        <?php } ?>
                                    </select>
                        		</div>
                        		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                        			<b>Tahun</b>
                        			<select id="filterTahun" name="filterTahun" class="form-control show-tick">
                                        <option>Pilih Tahun</option>
                                        <?php $year = date('Y')-1;
                                            for ($i=$year; $i <= $year+2 ; $i++) { ?>
                                                <option value="<?php echo $i; ?>" <?php if($i==$tahun){echo "selected";} ?>><?php echo $i; ?></option>
                                        <?php } ?>    
                                    </select>
                        		</div>
                        		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        			<b>&nbsp;</b><br/>
                        			<button type="submit" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                        		</div>
                        		</form>
                        	</div>
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="table_vd" class="table table-striped table-bordered table-hover" >
	                                    <thead>
										    <tr>
										        <th rowspan="2"><center>NO</center></th>
										        <th rowspan="2" width="10%"><center>KODE DISTRIBUTOR</center></th>
										        <th rowspan="2" width="30%"><center>NAMA DISTRIBUTOR</center></th>
										        <th colspan="3"><center>SHELLING IN</center></th>
										        <th colspan="3"><center>SHELLING OUT</center></th>
										        <th rowspan="2"><center>DETILE</center></th>
										    </tr>
										    <tr>
										    	<th>VOLUME</th>
										        <th>HARGA</th>
										        <th>REVENUE</th>
										        <th>VOLUME</th>
										        <th>HARGA</th>
										        <th>REVENUE</th>
										    </tr>
									    </thead>
	                                    <tbody>
	                                    	<?php 
	                                    		echo $isi_table;
	                                    	?>
	                                        <!-- data di load disini -->
	                                    </tbody>
	                                </table>
	                            </div>          
							</div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>
<script>
	$("document").ready(function(){
		//$('#table_vd').dataTable();
		// hargaJualDist();
		// salesDistributor();
	});




</script>
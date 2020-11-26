<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
	th { font-size: 11px; }
	td { font-size: 10px; }
	th, td { white-space: nowrap; }
	.W{
		background-color:#3F51B5 !important;
		font-weight:bolder;
		color:#FFFFFF;
	}
	.y{
		background-color:#FFFFFF !important;
		font-weight:bold;
		color:#222222;
	}
	.x{
		background-color:#E3F2FD !important;
		font-weight:bold;
		color:#222222;
	}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>REPORT SYNC CUSTOMER</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" id="daftar_report" width="100%">
                                            <thead class="w">
                                                <tr>
													<th width="5%">NO</th>
													<th width="35%">DISTRIBUTOR</th>
													<th width="20%">TGL SYNC</th>
													<th width="20%">STATUS</th>
													<th width="20%">CREATE BY </th>
                                                </tr>
                                            </thead>
                                            <tbody class="y" id="show_data">
												<?php
												$no=1;
												$isi = '';
												foreach($hasil as $h){
													$isi .= '<tr>';
													$isi .= '<td>'.$no.'</td>';
													$isi .= '<td>'.$h['NAMA_DISTRIBUTOR'].'</td>';
													$isi .= '<td>'.$h['CREATE_DATE'].'</td>';
													if($h['STATUS']=='DONE'){
														$isi .= '<td><span class="label label-success">'.$h['STATUS'].'</span></td>';
													}
													else {
														$isi .= '<td><span class="label label-danger">'.$h['STATUS'].'</span></td>';
													}
													
													$isi .= '<td>'.$h['NAMA'].'</td>';
													$isi .= '</tr>';
													
													$no=$no+1;
												}
												echo $isi;
												?>
                                            </tbody>
                                        </table>
										</div>
                                    </div>
                            	</div>
                            <div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
    </div>
</section>

<script>

$(document).ready(function() {
	$('#daftar_report').dataTable();
	
});

</script>
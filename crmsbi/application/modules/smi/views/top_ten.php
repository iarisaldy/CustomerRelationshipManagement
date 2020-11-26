<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <a href=""></a>
                <div class="card">
					<div class="header bg-cyan">
                        <h2>Top 10 Sales Force  </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                        	<div class="col-md-12">
                        		<h4>Top 10 Sales Force Berdasarkan Kunjungan</h4>
                        	</div>
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="table_vd" class="table table-striped table-bordered table-hover" >
	                                    <thead>
										    <tr>
										        <th><center>NO</center></th>
										        <th>Nama Sales</th>
										        <th>Distributor</th>
                                                <th><center>JML Kunjungan</center></th>
                                            </tr>
									    </thead>
	                                    <tbody>
	                                    	<?php 
	                                    		echo $list_top;
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
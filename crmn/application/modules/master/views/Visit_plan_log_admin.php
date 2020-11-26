<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
	th, td { white-space: nowrap; }
	.W{
		background-color:#3F51B5 !important;
		font-weight:bolder;
		color:#FFFFFF;
	}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>VISIT PLAN LOCKED ADMIN</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        <form action="" method="post">
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Tahun</b>
													<select id="filterTahun" name="filterTahun" class="form-control show-tick">
														<option>Pilih Tahun</option>
														<?php for($j=date('Y');$j<=date('Y')+4;$j++){ ?>
														<option value="<?php echo $j; ?>" <?php if(date('Y') == $j){ echo "selected";} ?>><?php echo $j; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Bulan</b>
													<select id="filterBulan" name="filterTahun" class="form-control show-tick">
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
											</div>
										</div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
                                        </form>
                                    </div>
								</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTable no-footer" id="daftar_plan" width="100%">
                                            <thead class="w">
                                                <tr>
													<th width="35%">NAMA SALES</th>
													<th width="50%">NAMA DISTRIBUTOR</th>
													<th width="10%">TAHUN</th>
													<th width="10%">BULAN</th>
													<th width="20%">STATUS</th>
													<th width="20%">LOCKED</th>
													<th width="20%">DELETE</th>
                                                </tr>
                                            </thead>
                                            <tbody id="show_data">
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
	$("#btnFilter").click();
});

$(document).on("click", "#btnFilter", function(){
	$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	var tahun = $('#filterTahun option:selected').val();
	var bulan	= $('#filterBulan option:selected').val();
	
		
		$.ajax({
		url: '<?php echo site_url(); ?>master/Visit_plan_log/tampildataall',
		type: 'POST',
		dataType : 'json',
		data: {
			"bulan" : bulan,
			"tahun" : tahun
		},
		success: function(data){
			  var html = '';
			  var i;
			  for(i=0; i<data.length; i++){
				html += '<tr>'+
				'<td>'+data[i].NAMA_SALES+'</td>'+
				'<td>'+data[i].NAMA_DISTRIBUTOR+'</td>'+
				'<td>'+data[i].TAHUN+'</td>'+
				'<td>'+data[i].BULAN+'</td>'+
				'<td><span class="label label-warning">'+data[i].STATUS+'</span></td>'+
				'<td><button type="button" id="datalog" idpd='+data[i].NO_LOG+' class="btn btn-sm btn-success waves-effect"><i class="fa fa-unlock-alt"></i> LOCKED</button></td>'+
				'<td><button type="button" id="delete_data" idpd='+data[i].NO_LOG+' class="btn btn-sm btn-danger waves-effect"><i class="fa fa-trash-o"></i>DELETE</button></td>'+
				'</tr>';
			  }
			//console.log(html);
			$('#show_data').html(html);
			$("#daftar_plan").dataTable();
		},
		error: function(){
		}
    });
});

$(document).on("click", "#datalog", function(){
	idpd = $(this).attr("idpd");
		$.ajax({
		url: '<?php echo site_url(); ?>master/Visit_plan_log/Ajax_simpan_edit',
		type: 'POST',
		data: { 
			"no" : idpd
		},
		success: function(data){
		alert("DATA SUDAH DIKUNCI!");
		$("#btnFilter").click();
		},
		error: function(){
		}
	});
});
$(document).on("click", "#delete_data", function(){
	idpd = $(this).attr("idpd");
	$.ajax({
		url: '<?php echo site_url(); ?>master/Visit_plan_log/Ajax_hapus',
		type: 'POST',
		data: { 
			"no" : idpd
		},
		success: function(data){
		alert("DATA TELAH DIHAPUS!");
		$("#btnFilter").click();
		},
		error: function(){
		}
	});
});
</script>
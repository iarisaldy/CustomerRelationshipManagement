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
                        <h2>VISIT PLAN LOCKED</h2>
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
													<b>Sales</b>
													<select id="pilihsales" name="sales" class="form-control show-tick">
														<option value="">Pilih Sales</option>
														<?php
														foreach ($list_sales as $ListJenisValue) { ?>
														<option value="<?php echo $ListJenisValue->ID_SALES; ?>"><?php echo $ListJenisValue->NAMA_SALES; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
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
                                        <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
										<button type="button" id="btnTambah" class="btn btn-warning btn-sm btn-lg m-15-30 waves-effect" style="float: right;"><i class="fa fa-plus"></i> Tambah Visit Lock</button>
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
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" id="judul_produk_order">TAMBAH VISIT PLAN LOCK</h4>
            </div>
            <div class="modal-body">
                <div class="row">
						<input type="hidden" name="id_edit" id="id_edit">
						<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">SALES : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <select id="TambahSales" name="TambahSales" class="form-control show-tick">
                                                <option value ="">Pilih Sales</option>
												<?php
												foreach ($list_sales as $ListSalesValue) { ?>
												<option value="<?php echo $ListSalesValue->ID_SALES; ?>"><?php echo $ListSalesValue->NAMA_SALES; ?></option>
												<?php } ?>
											</select>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">TAHUN : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <select id="TambahTahun" name="TambahTahun" class="form-control show-tick">
                                                <option value ="">Pilih Tahun</option>
												<option value ="2019">2019</option>
												<option value ="2020">2020</option>
												<option value ="2021">2021</option>
												<option value ="2022">2022</option>
											</select>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Bulan : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <select id="TambahBulan" name="TambahBulan" class="form-control show-tick">
                                                <option value ="">Pilih Bulan</option>
												<option value ="1">Januari</option>
												<option value ="2">februari</option>
												<option value ="3">Maret</option>
												<option value ="4">April</option>
												<option value ="5">Mei</option>
												<option value ="6">Juni</option>
												<option value ="7">Juli</option>
												<option value ="8">Agustus</option>
												<option value ="9">Sebtember</option>
												<option value ="10">Oktober</option>
												<option value ="11">November</option>
												<option value ="12">Desember</option>
											</select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
				<button type="button" id="TambahSimpan" class="btn btn-sm btn-success waves-effect">SIMPAN</button>
                <button type="button" class="btn btn-sm btn-info waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
	//$("#daftar_plan").dataTable();
	
	$("#btnFilter").click();
});

$(document).on("click", "#btnTambah", function(){
	$("#modaltambah").modal('show');
});

$(document).on("click", "#btnFilter", function(){
	$("#show_data").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	var sales	= $('#pilihsales option:selected').val();
	var tahun = $('#filterTahun option:selected').val();
	var bulan	= $('#filterBulan option:selected').val();
		
		$.ajax({
		url: '<?php echo site_url(); ?>master/Visit_plan_log/tampildata',
		type: 'POST',
		dataType : 'json',
		data: {
			"bulan" : bulan,
			"tahun" : tahun,
			"idsales" : sales
		},
		success: function(data){
			  var html = '';
			  var i;
			  for(i=0; i<data.length; i++){
				html += '<tr>'+
				'<td>'+data[i].NAMA_SALES+'</td>'+
				'<td>'+data[i].NAMA_DISTRIBUTOR+'</td>'+
				'<td>'+data[i].TAHUN+'</td>'+
				'<td>'+data[i].BULAN+'</td>';
				if(data[i].STATUS == 'Pending'){
					html += '<td><span class="label label-warning">'+data[i].STATUS+'</span></td>'+
					'</tr>';
				}
				else {
					html += '<td><span class="label label-success">'+data[i].STATUS+'</span></td>'+
					'</tr>';
				}
				
				
			  }
			$('#show_data').html(html);
			$("#daftar_plan").dataTable();
		},
		error: function(){
		}
    });
});
$(document).on("click", "#TambahSimpan", function(){
	
	$("#TambahSimpan").html('<center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center>');	
	var idsales = $('#TambahSales option:selected').val();
	var bulan	= $('#TambahBulan option:selected').val();
	var tahun = $('#TambahTahun option:selected').val();
	if(idsales=='' || bulan=='' || tahun==''){
		alert("Data tidak lengkap");
		$("#TambahSimpan").html('SIMPAN');
	}
	else {
		$.ajax({
			url: '<?php echo site_url(); ?>master/Visit_plan_log/tampildata',
			type: 'POST',
			dataType : 'json',
			data: {
				"bulan" : bulan,
				"tahun" : tahun,
				"idsales" : idsales
			},
			success: function(dataku){
				$("#TambahSimpan").html('SIMPAN');
				var a = dataku.length;
				console.log(dataku);
				console.log(a);
				if (a < 1){
				$.ajax({
					url: '<?php echo site_url(); ?>master/Visit_plan_log/Ajax_tambah_data',
					type: 'POST',
					data: { 
							"idsales" : idsales,
							"tahun" : tahun,
							"bulan" : bulan
					},
					success: function(data){
					alert("SUKSES");
					location.reload(true);
					},
					error: function(){
					}
				});
				}else{
					alert("DATA SUDAH ADA!")
				}
			},
			error: function(){
			}
		});
	}

});
</script>
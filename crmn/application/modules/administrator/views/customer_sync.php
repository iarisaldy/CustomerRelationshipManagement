<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-pink">
                        <h2> Sync Data Customer Distributor</h2>
                    </div>
                    <div class="body">
						<div class="col-md-12">
							<div class="col-md-4">
								<select class="selectpicker" name="distributor" id="distributor" >
									<?php echo $pilihan_distributor; ?>
								</select>
							</div>
							<div class="col-md-1">
								<button class="btn btn-primary waves-light" id="Cari_customer_by_distributor" ><span class="fa fa-search"></span> Cari</button>
							</div>
							<div class="col-md-1">
								<button class="btn btn-success waves-light" id="SYNC_customer_distributor"> <i class="fa fa-download"></i>  SYNC</button>
							</div>
						</div>
						
                        <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
                        <div class="header">
                            <h2>
                                Data Customer Distributor
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
											<th>Kode Customer</th>
                                            <th>Nama Customer</th>
                                            <th>Alamat</th>
                                            <th>No Telp</th>
                                            <th>Nama Pemilik</th>
                                            <th>No KTP</th>
                                        </tr>
                                    </thead>
                                    <tbody id="isi_data_customer_distributor">
                                        <tr>
											<td colspan="7"><center>Tidak Ada Record </center></td>
										</tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
            
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>

<script>

 $(document).on("click", "#Cari_customer_by_distributor", function(){
	distributor = $("#distributor").val();
	$("#isi_data_customer_distributor").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	
	$.ajax({
		url: '<?php echo site_url(); ?>administrator/Customer_sync/Ajax_tampil_data_customer_toko',
		type: 'POST',
		data: {
			"distributor"   : distributor,
		},
		success: function(j){
			var dt = JSON.parse(j);
			
			$("#isi_data_customer_distributor").html(dt.html);
			// $("#detile_resume_bm").html(j);
			// $("#resume_bm_title").html('<b>REALISASI BONGKAR MUAT SDK DI '+ b +' </b>');
			
			show_toaster(1,'','Data Berhasil Ditampilkan');
		},
		error: function(){
			//show_toaster(2,'','Data Gagal Diproses');
		}
    });
	
 });
 
$(document).on("click", "#SYNC_customer_distributor", function(){
	distributor = $("#distributor").val();
	$("#isi_data_customer_distributor").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	
	$.ajax({
		url: '<?php echo site_url(); ?>administrator/Customer_sync/Ajax_sync_customer_distributor',
		type: 'POST',
		data: {
			"distributor"   : distributor,
		},
		success: function(j){
			alert(j);
			//var dt = JSON.parse(j);
			
			//$("#isi_data_customer_distributor").html(dt.html);
			// $("#detile_resume_bm").html(j);
			// $("#resume_bm_title").html('<b>REALISASI BONGKAR MUAT SDK DI '+ b +' </b>');
			
			show_toaster(1,'','Data Berhasil Ditampilkan');
		},
		error: function(){
			//show_toaster(2,'','Data Gagal Diproses');
		}
    });
});
	
</script>
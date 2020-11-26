<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2> SYNC DATA TOKO</h2>
                    </div>
                    <div class="body">
						<div class="col-md-12">
							<div class="col-md-4">
								<select class="selectpicker" name="distributor" id="distributor" data-live-search="true">
									<?php echo $pilihan_distributor; ?>
								</select>
							</div>
							<div class="col-md-2">
								<button class="btn btn-primary waves-light" id="Cari_customer_by_distributor" ><span class="fa fa-search"></span> Cari</button>
							</div>
							<div class="col-md-1">
								<button class="btn btn-warning waves-light" id="SYNC_customer_distributor"> <i class="fa fa-download"></i>  SYNC</button>
							</div>
							<div class="col-md-1">
								<button id="btnExport" class="btn btn-success waves-light" ><span class="fa fa-file-excel-o"></span> Export </button>
							</div>
						</div>
						
                        <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
                        <div class="header">
                            <h2>
                                Data Toko
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
                                <table id="daftar_toko" class="table table-striped table-bordered dataTable no-footer" >
                                    <thead>
                                        <tr>
                                            <th>NO</th>
											<th>Kode Customer</th>
                                            <th>Nama Customer</th>
											<th>Region</th>
											<th>No Telp Customer</th>
											<th>Nama Pemilik</th>
											<th>No Telp Pemilik</th>
											<th>Provinsi</th>
											<th>Area</th>
											<th>Distrik</th>
                                            <th>Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody id="isi_data_customer_distributor">
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
$(document).ready(function() {
document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
});

function tampil_data(){
	$("#isi_data_customer_distributor").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
		distributor = $("#distributor").val();
		$.ajax({
		url: '<?php echo site_url(); ?>scheduler/Toko_Sync/Ajax_tampil_data_customer_toko_admin',
		type: 'POST',
		dataType : 'json',
		data: {
			"distributor"   : distributor
		},
		success: function(data){
			  var html = '';
			  var i;
			  var c = "x";
			  for(i=1; i<data.length; i++){
				html += '<tr class='+c+'>'+
				'<td>'+i+'</td>'+
				'<td>'+data[i].KODE_CUSTOMER+'</td>'+
				'<td>'+data[i].NAMA_TOKO+'</td>'+
				'<td>'+data[i].NEW_REGION+'</td>'+
				'<td>'+data[i].TELP_TOKO+'</td>'+
				'<td>'+data[i].NAMA_PEMILIK+'</td>'+
				'<td>'+data[i].TELP_PEMILIK+'</td>'+
				'<td>'+data[i].NAMA_PROVINSI+'</td>'+
				'<td>'+data[i].NAMA_AREA+'</td>'+
				'<td>'+data[i].NAMA_DISTRIK+'</td>'+
				'<td>'+data[i].ALAMAT+'</td>'+
				'</tr>';
				if(c == "x"){
					c = "y"  ;
				}else{
					c = "x" ;
				}
			  }
			$('#isi_data_customer_distributor').html(html);
			$("#daftar_toko").dataTable();
		},
		error: function(){
		}
    });
}

 $(document).on("click", "#Cari_customer_by_distributor", function(){
	$("#daftar_toko").DataTable().destroy();
	tampil_data();
	
});
 
$(document).on("click", "#SYNC_customer_distributor", function(){
	$("#daftar_toko").DataTable().destroy();
	distributor = $("#distributor").val();
	$("#isi_data_customer_distributor").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	$.ajax({
		url: '<?php echo site_url(); ?>scheduler/Toko_Sync/Ajax_Delete_Mark',
		type: 'POST',
		data: {
			"distributor"   : distributor,
		},
		success: function(data){
			alert("PROSES SYNC DATA CUSTOMER BK");
			$.ajax({
				url: '<?php echo site_url(); ?>scheduler/Toko_Sync/Ajax_sync_customer_distributor',
				type: 'POST',
				data: {
					"distributor"   : distributor,
				},
				success: function(data){
					alert("PROSES SYNC DATA CUSTOMER BK SUKSES");
					tampil_data();
				},
				error: function(){
				}
			});
		},
		error: function(){
		}
    });
	
});

$(document).on("click", "#btnExport", function(e){
	e.preventDefault();
    distributor = $("#distributor").val();

    window.open("<?php echo base_url()?>scheduler/Toko_Sync/toExcel?distributor="+distributor,"_blank");
});
	
</script>
<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
	th { font-size: 12px; }
	td { font-size: 11px; }
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
                        <h2>REPORT HASIL SURVEY</h2>
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
                                        <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
										<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
											<button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect" ><span class="fa fa-file-excel-o"></span> Export </button>
										</div>
                                        </form>
                                    </div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTable no-footer" id="daftar_report" width="100%">
                                            <thead class="w">
                                                <tr>
													<th>NO</th>
													<th width="5%">TGL KUNJUNGAN</th>
													<th width="10%">KD TOKO</th>
                                                    <th width="10%">NAMA TOKO</th>
													<th width="10%">DISTRIK</th>
													<th width="5%">AREA</th>
													<th width="10%">PROVINSI</th>
													<th width="15%">REGION</th>
													<th width="15%">KD PRODUK</th>
													<th width="15%">NAMA PRODUK</th>
													<th width="15%">NAMA PRODUK</th>
													<th>STOK SAAT INI</th>
													<th>VOLUME PEMBELIAN</th>
													<th>HARGA PEMBELIAN</th>
													<th>TGL PEMBELIAN</th>
													<th>TOP PEMBELIAN</th>
													<th>VOLUME PENJUALAN</th>
													<th>HARGA PENJUALAN</th>
													<th>KAPASITAS TOKO</th>
													<th>SEMEN MEMBATU</th>
													<th>SEMEN_TERLAMBAT_DATANG</th>
													<th>KANTONG_TIDAK_KUAT</th>
													<th>HARGA_TIDAK_STABIL</th>
													<th>SEMEN_RUSAK_SAAT_DITERIMA</th>
													<th>TOP_KURANG_LAMA</th>
													<th>PEMESANAN_SULIT</th>
													<th>KOMPLAIN_SULIT</th>
													<th>STOK_SERING_KOSONG</th>
													<th>PROSEDUR_RUMIT</th>
													<th>TIDAK_SESUAI_SPESIFIKASI</th>
													<th>TIDAK_ADA_KELUHAN</th>
													<th>KELUHAN_LAIN_LAIN</th>
													<th>BONUS_SEMEN</th>
													<th>BONUS_WISATA</th>
													<th>POINT_REWARD</th>
													<th>VOUCER</th>
													<th>POTONGAN_HARGA</th>
                                                </tr>
                                            </thead>
                                            <tbody class="y" id="show_data">
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
	//tampil_data();
	listProvinsi("#pilihprovinsi");
	listDistributor("#pilihdistributor");
	
	$('#pilihregion').change(function(){
    listProvinsi("#pilihprovinsi");
	})
	
	$('#pilihprovinsi').change(function(){
    listDistributor("#pilihdistributor");
	})
});

function tampil_data(){
$("#show_data").html('<tr><td colspan="12"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	var id = $('#listDistributor option:selected').val();
	var region = $('#pilihregion option:selected').val();
	var id_prov = $('#listProvinsi option:selected').val();
		
		$.ajax({
		url: '<?php echo site_url(); ?>laporan/Hasil_survey/ambildataall',
		type: 'POST',
		dataType : 'json',
		data: {
			"id" : id,
			"tahun" : $('#filterTahun').val(),
			"bulan" : $('#filterBulan').val(),
		},
		success: function(data){
			  var html = '';
			  var i;
			  var c = "x";
			  var no = 1 ;
			  for(i=0; i<data.length; i++){
				html += '<tr class='+c+'>'+
				'<td>'+no+'</td>'+
				'<td>'+data[i].TGL_RENCANA_KUNJUNGAN+'</td>'+
				'<td>'+data[i].ID_TOKO+'</td>'+
				'<td>'+data[i].NAMA_TOKO+'</td>'+
				'<td>'+data[i].NAMA_DISTRIK+'</td>'+	
				'<td>'+data[i].NAMA_AREA+'</td>'+			
				'<td>'+data[i].NAMA_PROVINSI+'</td>'+
				'<td>'+data[i].REGION_ID+'</td>'+
				'<td>'+data[i].ID_PRODUK+'</td>'+
				'<td>'+data[i].NAMA_PRODUK+'</td>'+
				'<td>'+data[i].STOK_SAAT_INI+'</td>'+
				'<td>'+data[i].VOLUME_PEMBELIAN+'</td>'+
				'<td>'+data[i].HARGA_PEMBELIAN+'</td>'+
				'<td>'+data[i].TGL_PEMBELIAN+'</td>'+
				'<td>'+data[i].TOP_PEMBELIAN+'</td>'+
				'<td>'+data[i].VOLUME_PENJUALAN+'</td>'+
				'<td>'+data[i].HARGA_PENJUALAN+'</td>'+
				'<td>'+data[i].KAPASITAS_TOKO+'</td>'+
				'<td>'+data[i].SEMEN_MENBATU+'</td>'+
				'<td>'+data[i].SEMEN_TERLAMBAT_DATANG+'</td>'+
				'<td>'+data[i].KANTONG_TIDAK_KUAT+'</td>'+
				'<td>'+data[i].HARGA_TIDAK_STABIL+'</td>'+
				'<td>'+data[i].SEMEN_RUSAK_SAAT_DITERIMA+'</td>'+
				'<td>'+data[i].TOP_KURANG_LAMA+'</td>'+
				'<td>'+data[i].PEMESANAN_SULIT+'</td>'+
				'<td>'+data[i].KOMPLAIN_SULIT+'</td>'+
				'<td>'+data[i].STOK_SERING_KOSONG+'</td>'+
				'<td>'+data[i].PROSEDUR_RUMIT+'</td>'+
				'<td>'+data[i].TIDAK_SESUAI_SPESIFIKASI+'</td>'+
				'<td>'+data[i].TIDAK_ADA_KELUHAN+'</td>'+
				'<td>'+data[i].KELUHAN_LAIN_LAIN+'</td>'+
				'<td>'+data[i].BONUS_SEMEN+'</td>'+
				'<td>'+data[i].BONUS_WISATA+'</td>'+
				'<td>'+data[i].POINT_REWARD+'</td>'+
				'<td>'+data[i].VOUCER+'</td>'+
				'<td>'+data[i].SETIAP_PEMBELIAN+'</td>'+
				'<td>'+data[i].POTONGAN_HARGA+'</td>'+
				'</tr>';
				no++;
				if(c == "x"){
					c = "y"  ;
				}else{
					c = "x" ;
				}
			  }
			$('#show_data').html(html);
			$("#daftar_report").dataTable();
		},
		error: function(){
		}
    });
}

function listProvinsi(key){
	var idRegion = $('#pilihregion option:selected').val();
	$.ajax({
		url: "<?php echo base_url(); ?>laporan/Data_sales/ListProvinsi/",
		type: 'POST',
		data: {
			"id_region"    : idRegion,
		},
		dataType: 'JSON',
		success: function(data){
			var response = data['data'];

			var type_list = '';
			type_list += '<select id="listProvinsi" class="form-control selectpicker show-tick" data-live-search="true">';
			type_list += '<option value="">All</option>';
			for (var i = 0; i < response.length; i++) {
				type_list += '<option value="'+response[i]['ID_PROVINSI']+'">'+response[i]['NAMA_PROVINSI']+'</option>';
			}
			type_list += '</select>';

			$(key).html(type_list);
			$(".selectpicker").selectpicker("refresh");
		}
	});
}

function listDistributor(key){
	var idProvinsi = $('#listProvinsi option:selected').val();
	$.ajax({
		url: "<?php echo base_url(); ?>laporan/Data_sales/ListDistributor/",
		type: 'POST',
		data: {
			"id_provinsi"    : idProvinsi,
		},
		dataType: 'JSON',
		success: function(data){
			var response = data['data'];

			var type_list = '';
			type_list += '<select id="listDistributor" class="form-control selectpicker show-tick" data-live-search="true">';
			type_list += '<option value="">All</option>';
			for (var i = 0; i < response.length; i++) {
				type_list += '<option value="'+response[i]['KODE_DISTRIBUTOR']+'">'+response[i]['NAMA_DISTRIBUTOR']+'</option>';
			}
			type_list += '</select>';

			$(key).html(type_list);
			$(".selectpicker").selectpicker("refresh");
		}
	});
}

$(document).on("click", "#btnFilter", function(){
	$("#daftar_report").DataTable().destroy();
	tampil_data();
});

$(document).on("click", "#btnExport", function(e){
	e.preventDefault();
	var tahun = $('#filterTahun').val();
	var bulan = $('#filterBulan').val();

    window.open("<?php echo base_url()?>laporan/Hasil_survey/toExcel_Admin?tahun="+tahun+"&bulan="+bulan,"_blank");
});
</script>
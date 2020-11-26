<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
	th { font-size: 9px; }
	td { font-size: 8px; }
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
                        <h2>REPORT TOKO NOO</h2>
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
													<b>Distributor</b>
													<select id="pilihdistributor" name="distributor" class="form-control show-tick">
														<option value="">Pilih Distributor</option>
														<?php
														foreach ($list_distributor as $ListJenisValue) { ?>
														<option value="<?php echo $ListJenisValue->KODE_DISTRIBUTOR; ?>"><?php echo $ListJenisValue->NAMA_DISTRIBUTOR; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
										<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
											<button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect" ><span class="fa fa-file-excel-o"></span> Export </button>
										</div>
										<input type="hidden" id="bulan" value="<?php echo date('m')-1; ?>" class="form-control" >
										<input type="hidden" id="tahun" value="<?php echo date('Y'); ?>" class="form-control" >
                                        </form>
                                    </div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="daftar_report" class="table table-striped table-bordered" width="100%">
                                            <thead class="w">
                                                <tr>
													<th>NO</th>
                                                    <th width="5%">AKUISISI DATE</th>
													<th width="10%">ID CUSTOMER</th>
                                                    <th width="5%">NAMA TOKO</th>
													<th width="5%">ID DISTRIBUTOR</th>
                                                    <th width="10%">NAMA DISTRIBUTOR</th>
													<th width="5%">NAMA PEMILIK</th>
													<th width="5%">ALAMAT TOKO</th>
													<th width="5%">KECAMATAN</th>
													<th width="5%">DISTRIK</th>
													<th width="20%">PROVINSI</th>
													<th width="5%">AREA</th>
													<th width="5%">VOLUME PENJUALAN/TON</th>
													<th width="5%">VOLUME PENJUALAN SP/TON</th>
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
$("document").ready(function() {
	tampil_data(); 	
});	

function tampil_data(){
	$("#show_data").html('<tr><td colspan="12"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	var bulan = $("#bulan").val();
	var tahun = $("#tahun").val();
	var id_distributor = $('#pilihdistributor option:selected').val();
	
	$.ajax({
		type  : 'POST',
		url   : '<?php echo base_url()?>laporan/Repot_toko_noo/getdata',
		dataType : 'json',
		data: {
			"bulan" : bulan,
			"tahun" : tahun,
			"id_distributor" : id_distributor
		},
		success : function(data){
			var html = '';
			var i;
			var c = "x";
			var no = 1 ;
			for(i=0; i<data.length; i++){
				html += '<tr class='+c+'>'+
						'<td>'+no+'</td>'+
						'<td>'+data[i].AKUISISI_DATE+'</td>'+
						'<td>'+data[i].KD_CUSTOMER+'</td>'+
						'<td>'+data[i].NAMA_TOKO+'</td>'+
						'<td>'+data[i].NOMOR_DISTRIBUTOR+'</td>'+
						'<td>'+data[i].NM_DISTRIBUTOR+'</td>'+
						'<td>'+data[i].NM_CUSTOMER+'</td>'+
						'<td>'+data[i].ALAMAT_TOKO+'</td>'+
						'<td>'+data[i].KECAMATAN+'</td>'+
						'<td>'+data[i].NM_DISTRIK+'</td>'+
						'<td>'+data[i].PROVINSI+'</td>'+
						'<td>'+data[i].AREA+'</td>'+
						'<td><center>'+data[i].PENJUALAN+'</center></td>'+
						'<td><center>'+data[i].PENJUALAN_SP+'</center></td>'+
						'</tr>';
						no++;
				if(c == "x"){
					c = "y"  ;
				}else{
					c = "x" ;
				}
			}
			$('#show_data').html(html);
			$("#daftar_report").DataTable();
		}

	});
}

$(document).on("click", "#btnFilter", function(){
	$("#daftar_report").DataTable().destroy();
	tampil_data();
});

$(document).on("click", "#btnExport", function(e){
		e.preventDefault();
		var bulan = $("#bulan").val();
		var tahun = $("#tahun").val();
		var id = $('#pilihdistributor option:selected').val();

        window.open("<?php echo base_url()?>laporan/Repot_toko_noo/toExcelTSO?bulan="+bulan+"&tahun="+tahun+"&id="+id,"_blank");
});
</script>
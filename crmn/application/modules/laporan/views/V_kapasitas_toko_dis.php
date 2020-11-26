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
                        <h2>REPORT KAPASITAS TOKO</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        <form action="" method="post">
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
                                                    <th width="10%">ID CUSTOMER</th>
													<th width="15%">NAMA TOKO</th>
													<th width="45%">ALAMAT</th>
													<th width="15%">NAMA DISTRIBUTOR</th>
													<th width="10%">PROVINSI</th>
													<th width="5%">DISTRIK</th>
													<th width="5%">AREA</th>
													<th width="5%">KECAMATAN</th>
													<th width="5%">KAPASITAS(ZAK)</th>
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
	tampil_data();
});

function tampil_data(){
	$("#show_data").html('<tr><td colspan="10"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	var distrik	= '';
		
		$.ajax({
		url: '<?php echo site_url(); ?>laporan/Report_kapasitas_toko/filterdatadis',
		type: 'POST',
		dataType : 'json',
		data: {
			"distrik" : distrik
		},
		success: function(data){
			  var html = '';
			  var i;
			  var c = "x";
			  var no = 1 ;
			  for(i=0; i<data.length; i++){
				html += '<tr class='+c+'>'+
				'<td>'+no+'</td>'+
				'<td>'+data[i].ID_CUSTOMER+'</td>'+
				'<td>'+data[i].NAMA_TOKO+'</td>'+
				'<td>'+data[i].ALAMAT+'</td>'+
				'<td>'+data[i].NAMA_DISTRIBUTOR+'</td>'+
				'<td>'+data[i].NAMA_PROVINSI+'</td>'+
				'<td>'+data[i].NAMA_DISTRIK+'</td>'+
				'<td>'+data[i].NAMA_AREA+'</td>'+
				'<td>'+data[i].NAMA_KECAMATAN+'</td>'+
				'<td>'+data[i].KAPASITAS_ZAK+'</td>'+
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

$(document).on("click", "#btnFilter", function(){
	$("#daftar_report").DataTable().destroy();
	tampil_data();
});

$(document).on("click", "#btnExport", function(e){
		e.preventDefault();
        var id = $('#pilihdistributor option:selected').val();

        window.open("<?php echo base_url()?>laporan/Report_kapasitas_toko/toExce_DIS","_blank");
});
</script>
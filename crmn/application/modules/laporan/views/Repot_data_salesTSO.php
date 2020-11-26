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
                        <h2>REPORT DATA SALES</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        <form action="" method="post">
										<div class="col-lg-3">
											<div class="form-group">
												<div class="form-line">
													<b>DISTRIBUTOR</b>
													<select id="pilihdistributor" name="distributor" class="form-control show-tick" data-live-search="true">
														<option value="">All</option>
														<?php
														foreach ($list_distributor as $ListJenisValue) { ?>
														<option value="<?php echo $ListJenisValue->KODE_DISTRIBUTOR; ?>"><?php echo $ListJenisValue->NAMA_DISTRIBUTOR; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
													<b>SALES</b>
												<div class="form-line" id="pilihsales">
												</div>
											</div>
										</div>
                                        <div class="col-lg-1">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
										<div class="col-lg-1">
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
													<th width="10%">ID SALES</th>
                                                    <th width="10%">SALES</th>
													<th width="20%">NAMA DISTRIBUTOR</th>
													<th width="20%">SALES OFFICER</th>
													<th width="20%">SALES MANAJER</th>
													<th width="20%">SENIOR SALES MANAJER</th>
													<th>GSM</th>
													<th>REGION</th>
													<th>PROVINSI</th>
													<th>AREA</th>
													<th>DISTRIK</th>
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
	listSales("#pilihsales");
	
	$('#pilihdistributor').change(function(){
    listSales("#pilihsales");
	});
	document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
});

function tampil_data(){
	$("#show_data").html('<tr><td colspan="9"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	var id = $('#pilihdistributor option:selected').val();
	var id_sales = $('#listSales option:selected').val();
		
		$.ajax({
		url: '<?php echo site_url(); ?>laporan/Data_sales/ambildatatso',
		type: 'POST',
		dataType : 'json',
		data: {
			"id" : id,
			"id_sales" : id_sales
		},
		success: function(data){
			  var html = '';
			  var i;
			  var c = "x";
			  var no = 1 ;
			  for(i=0; i<data.length; i++){
				html += '<tr class='+c+'>'+
				'<td>'+no+'</td>'+
				'<td>'+data[i].ID_SALES+'</td>'+
				'<td>'+data[i].NAMA_SALES+'</td>'+
				'<td>'+data[i].NAMA_DISTRIBUTOR+'</td>'+
				'<td>'+data[i].NAMA_SO+'</td>'+
				'<td>'+data[i].NAMA_SM+'</td>'+
				'<td>'+data[i].NAMA_SSM+'</td>'+
				'<td>'+data[i].NAMA_GSM+'</td>'+
				'<td>'+data[i].REGION_ID+'</td>'+
				'<td>'+data[i].NAMA_PROVINSI+'</td>'+
				'<td>'+data[i].NM_AREA+'</td>'+
				'<td>'+data[i].NM_DISTRIK+'</td>'+
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

function listSales(key){
	var idDis = $('#pilihdistributor option:selected').val();
	$.ajax({
		url: "<?php echo base_url(); ?>laporan/Data_sales/ListSalesDIS/",
		type: 'POST',
		data: {
			"id_dis"    : idDis,
		},
		dataType: 'JSON',
		success: function(data){
			var response = data['data'];

			var type_list = '';
			type_list += '<select id="listSales" class="form-control selectpicker show-tick" data-live-search="true">';
			type_list += '<option value="">All</option>';
			for (var i = 0; i < response.length; i++) {
				type_list += '<option value="'+response[i]['ID_SALES']+'">'+response[i]['NAMA_SALES']+'</option>';
			}
			type_list += '</select>';

			$(key).html(type_list);
			$(".selectpicker").selectpicker("refresh");
			document.getElementsByClassName("bs-searchbox")[1].getElementsByTagName("input")[0].style.marginLeft = "5px";
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
		var id_sales = $('#listSales option:selected').val();

        window.open("<?php echo base_url()?>laporan/Data_sales/toExcel?id="+id+"&id_sales="+id_sales,"_blank");
});
</script>
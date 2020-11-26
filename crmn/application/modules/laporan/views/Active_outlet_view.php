<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>REPORT ACTIVE OUTLET</h2>
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
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Sales</b>
													<select id="pilihsales" name="sales" class="form-control show-tick">
														<option value="">Pilih Sales</option>
														<?php
														foreach ($list_sales as $ListJenisValue) { ?>
														<option value="<?php echo $ListJenisValue->ID_SALES; ?>"><?php echo $ListJenisValue->NAMA; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Tanggal Awal</b>
													<input type="text" id="startDate" value="<?php echo date('Y')."-".date('m')."-"."27" ?>" class="form-control" placeholder="Tanggal Awal">
												</div>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Tanggal Akhir</b>
													<input type="text" id="endDate" value="<?php $lastDayThisMonth = date("Y-m-t"); echo $lastDayThisMonth; ?>" class="form-control" placeholder="Tanggal Akhir">
												</div>
											</div>
										</div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
											<button class="btn btn-success btn-sm btn-lg m-l-15 waves-effect" onclick="exportTableToExcel('daftar_report')"><span class="fa fa-file-excel-o"></span> Export </button>
										</div>
                                        </form>
                                    </div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTable no-footer" id="daftar_report" width="100%">
                                            <thead class="w">
                                                <tr>
                                                    <th>ID SALES</th>
													<th width="20%">KD CUSTOMER</th>
													<th width="20%">NM CUSTOMER</th>
													<th width="20%">KD DISTRIBUTOR</th>
													<th width="10%">NM DISTRIBUTOR</th>
													<th width="10%"></th>
													<th width="10%">PERSENTASI</th>
                                                </tr>
                                            </thead>
                                            <tbody id="show_data">
                                                <?php
                                                    //echo $list;
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
	$("#daftar_report").dataTable();
	$('#startDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    $('#endDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
});

$(document).on("click", "#btnFilter", function(){
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
		var sales	= $('#pilihsales option:selected').val();
		var kd_distributor = $('#pilihdistributor option:selected').val();
		
		//data = [startDate,endDate,sales,kd_distributor];
		//console.log(data);
		
		$.ajax({
		url: '<?php echo site_url(); ?>laporan/Report_Visit/filterdata',
		type: 'POST',
		async : true,
		dataType : 'json',
		data: {
			"start_date" : startDate,
			"end_date" : endDate,
			"sales" : sales,
			"kd_distributor" : kd_distributor
		},
		success: function(data){
			  console.log(data);
			  var html = '';
			  var i;
			  for(i=0; i<data.length; i++){
				html += '<tr>'+
				'<td>'+data[i].ID_USER+'</td>'+
				'<td>'+data[i].NAMA+'</td>'+
				'<td>'+data[i].KODE_DISTRIBUTOR+'</td>'+
				'<td>'+data[i].NAMA_DISTRIBUTOR+'</td>'+
				'<td>'+data[i].TOTAL_TARGET+'</td>'+
				'<td>'+data[i].REALISASI+'</td>'+
				'<td>'+data[i].PERSENTASI+'</td>'+
				'</tr>';
			  }
			$('#show_data').html(html);
			// var dt = JSON.parse(j);
			// $("#show_data").html(dt.html);
			// $("#daftar_report").dataTable();
			// console.log(dt);
		},
		error: function(){
		}
    });
});
</script>
<script>

function exportTableToExcel(tableID){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
	
	var startDate = $("#startDate").val();
	var endDate = $("#endDate").val();
	
	var uniq_title = 'mulai '+startDate+' sampai '+endDate;
	
	var objDate = new Date();
	var todayDate = objDate.getDate()+'-'+objDate.getMonth()+'-'+objDate.getFullYear();
	var todayTime = objDate.getHours()+'_'+objDate.getMinutes()+'_'+objDate.getSeconds();
	
	var filename = 'Laporan CRM Report Visit '+uniq_title+' ('+todayDate+ ' '+todayTime+')';
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}

</script>
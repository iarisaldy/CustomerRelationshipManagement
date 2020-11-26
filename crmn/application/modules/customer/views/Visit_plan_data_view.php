<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>VISIT PLAN SALES DISTRIBUTOR</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-8" style="margin-bottom: 0;">
											<div class="form-group">
												<div class="form-line" id="ListSalesDistributor"></div>
											</div>
										</div>
										
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" style="margin-bottom: 0;">
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
											<button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-file-excel-o"></i> Export </button>
										</div>
										
                                    </div>
                            	</div>
								<hr>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTable no-footer" id="daftar_visit_plan" width="100%" style="width: 100%; font-size:9px;">
                                            <thead class="w">
                                                <tr>
													<th width="3%">NO</th>
													<th width="10%">ID SALES</th>
                                                    <th>NAMA SALES</th>
													<th width="15%">USERNAME</th>
													<th width="15%">ID CUSTOMER</th>
                                                    <th>NAMA TOKO</th>
													<th width="15%">ID DISTRIBUTOR</th>
													<th>NAMA DISTRIBUTOR</th>
													<th width="3%">SUN</th>
													<th width="3%">MON</th>
													<th width="3%">TUE</th>
													<th width="3%">WED</th>
													<th width="3%">THU</th>
													<th width="3%">FRI</th>
													<th width="3%">SAT</th>
													<th width="3%">W1</th>
													<th width="3%">W2</th>
													<th width="3%">W3</th>
													<th width="3%">W4</th>
													<th width="3%">W5</th>
													<th style="display: none;">EDIT</th>
													<th style="display: none;">HAPUS</th>
                                                </tr>
                                            </thead>
                                            <tbody class="y" id="show_data_visit_plan">
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
	ListSales("#ListSalesDistributor");
    load_visit_plan(8105317, null);
	//load_visit_plan(null, null);
});

$(document).on("click", "#btnFilter", function(e){
	e.preventDefault();
	$("#daftar_visit_plan").DataTable().destroy();
	var sdSet = $('#listSales_set option:selected').val();
	
	if(sdSet == 'a404a'){
		alert("Masukkan Pilihan Sales Distributor Terlebih Dahulu.");
	} else {
		var strArray = sdSet.split("_");
		$("#DtSalseNama").text('['+strArray[0]+'] - ['+strArray[2]+'] => '+strArray[1]);
		load_visit_plan(null, strArray[0]);
	}
});

$(document).on("click", "#btnExport", function(){
		var id_sales; var nama_sales; var username;
		var sdSet = $('#listSales_set option:selected').val();
		if(sdSet == 'a404a'){
			alert("Masukkan Pilihan Sales Distributor Terlebih Dahulu.");
		} else {
			var strArray = sdSet.split("_");
			id_sales = strArray[0];
			username = strArray[2];
			nama_sales = strArray[1];
			
				var objDate = new Date();
				var todayDate = objDate.getDate()+'-'+objDate.getMonth()+'-'+objDate.getFullYear();
				var todayTime = objDate.getHours()+'-'+objDate.getMinutes()+'-'+objDate.getSeconds();
		
			var nama_file = 'Daftar Visit Plan Sales - '+id_sales+'_'+username+'_'+todayDate+'_'+todayTime;
			
			window.location.href = '<?php echo site_url(); ?>customer/Visit_plan/Export_visit_plan/'+id_sales+'/'+nama_file;
		}
});

function ListSales(key){
	$(key).html('<p> Loading data sales. Please wait ...</p>');
	
	var type_list = ''; 
	type_list += '<select id="listSales_set" name="listSales_set" class="form-control selectpicker show-tick" data-size="10" data-live-search="true">';
	$.ajax({
            url: "<?php echo base_url(); ?>customer/Visit_plan/List_sd",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data;
				type_list += '<option value="a404a" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Pilih Sales Distributor -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i].ID_SALES+'_'+response[i].NAMA_SALES+'_'+response[i].USERNAME+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ['+response[i].ID_SALES+'] - ['+response[i].USERNAME+'] '+response[i].NAMA_SALES+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
				  
			}
        });
} 

function load_visit_plan(id_distributor, id_sales){
	$("#show_data_visit_plan").html('<tr><td colspan="20"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>customer/Visit_plan/List_visit_plan',
			type: 'POST',
			dataType : 'json',
			data: {
				"id_distributor" : id_distributor,
				"id_sales" 	: id_sales
			},
			success: function(datasku){
				var data = datasku;
				
				  var html = '';
				  var i;
				  var c = "x"; 
				  var no = 1 ;
				  
				  for(i=0; i<data.length; i++){
					  
					var buttonE = '<td style="text-align: center; display: none;">'+
								'<span id="BtnEdit" class="btn btn-info"><i class="fa fa-edit" title="edit"></i></span> &nbsp;'+
							 '</td>'; 
							 
					var buttonH = '<td style="text-align: center; display: none;">'+
								'<span id="BtnHapus" class="btn btn-danger"><i class="fa fa-trash" title="hapus"></i></span>'+
							 '</td>'; 
							 
					html += '<tr class='+c+'>'+
						'<td style="text-align: center;">'+no+'</td>'+
						'<td>'+data[i].ID_SALES+'</td>'+
						'<td>'+data[i].NAMA+'</td>'+
						'<td>'+data[i].USERNAME+'</td>'+
						'<td>'+data[i].ID_CUSTOMER+'</td>'+
						'<td>'+data[i].NAMA_TOKO+'</td>'+
						'<td>'+data[i].ID_DISTRIBUTOR+'</td>'+
						'<td>'+data[i].NAMA_DISTRIBUTOR+'</td>'+
						'<td>'+data[i].SUN+'</td>'+
						'<td>'+data[i].MON+'</td>'+
						'<td>'+data[i].TUE+'</td>'+
						'<td>'+data[i].WED+'</td>'+
						'<td>'+data[i].THU+'</td>'+
						'<td>'+data[i].FRI+'</td>'+
						'<td>'+data[i].SAT+'</td>'+
						'<td>'+data[i].W1+'</td>'+
						'<td>'+data[i].W2+'</td>'+
						'<td>'+data[i].W3+'</td>'+
						'<td>'+data[i].W4+'</td>'+
						'<td>'+data[i].W5+'</td>'+
						buttonE+
						buttonH+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
			}
				$('#show_data_visit_plan').html(html);
				$("#daftar_visit_plan").dataTable();
			},
			error: function(){
			}
		});
}

</script>
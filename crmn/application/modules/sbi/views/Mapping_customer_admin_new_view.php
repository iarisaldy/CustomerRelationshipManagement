<style>
	.blink {
    -webkit-animation: blink 1s step-end infinite;
            animation: blink 1s step-end infinite;
}
@-webkit-keyframes blink { 50% { visibility: hidden; }}
        @keyframes blink { 50% { visibility: hidden; }}

    
	.y{
		background-color:#FFFFFF !important;
		font-weight:normal;
		color:#222222;
	}
	.x{
		background-color:#E3F2FD !important;
		font-weight:normal;
		color:#222222;
	}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header header-title">
                        <h2 style="padding-top: 0.2em;">CUSTOMER MAPPING</h2>
                    </div>
                    <div class="body">
                        
                            <div class="container-fluid">

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form action="" method="post">
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
														<div class="form-group">
															<div class="form-line" id="ListFilterBy"></div>
														</div>
													</div>
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
														<div class="form-group">
															<div class="form-line" id="ListFilterSet"></div>
														</div>
													</div>
												
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <b>&nbsp;</b><br/>
                                                        <button style="float: left;" type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                                                        <button style="float: left; " id="btnToExcel" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect" ><span class="fa fa-file-excel-o"></span> Export </button>
                                                    </div>
													
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table id="tableMapping" class="table table-striped table-bordered table-hover" border="1" width="100%" style="font-size: 12px;">
                                                        <thead>
                                                            <tr>
                                                                <th width="3%">No</th>
																<th>Kode Customer</th>
                                                                <th>Nama Customer</th>
																<th>Alamat</th>
                                                                <th>Distributor</th>
																<th>SALES</th>
                                                                <th>SO</th>
                                                                <th>SM</td>
                                                                <th>SSM</th>
																<th>GSM</th>
																<th>CREATE-AT</th>
                                                            </tr>
                                                        </thead>
														<tbody class="y" id="show_data">
														</tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        <div>
                                    </div>
                                </div>
                          
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>

<script>

$(document).ready(function(){
	ListFilterBy("#ListFilterBy");
	ListFilterSet("0-ALL");
	//tampil_data("2-PROVINSI","1021-DKI JAKARTA");
	//tampil_data(0,0); 
});

function ListFilterBy(key){
	var type_list = 'Filter By :';
    type_list += '<select id="listFilterByVal" name="FilterBy" class="form-control selectpicker show-tick">';
    type_list += '<option value="0-ALL">ALL</option>';
    type_list += '<option value="1-REGION">REGION</option>';
	type_list += '<option value="2-PROVINSI">PROVINSI</option>';
	//type_list += '<option value="3">DISTRIK</option>';
	type_list += '<option value="4-AREA">AREA</option>';
	type_list += '<option value="5-DISTRIBUTOR">DISTRIBUTOR</option>';
    type_list += '</select>';
	
    $(key).html(type_list);
    $(".selectpicker").selectpicker("refresh");
}

$(document).on("change", "#listFilterByVal", function(){
	var FilterBy = $(this).val();
	//console.log(FilterBy);
	ListFilterSet(FilterBy);
});

function ListFilterSet(pilihan){
	var response;
	var key = "#ListFilterSet";
	var type_list = 'Filter Set :';
	type_list += '<select id="listFilterSetVal" name="FilterSet" class="form-control selectpicker show-tick" data-size="10" data-live-search="true">';
	console.log(pilihan);
	if(pilihan == "0-ALL"){
		console.log('ALL');
		//type_list += '<option value="0">-</option>';
		type_list += '</select>';
		$(key).html(type_list);
		$(".selectpicker").selectpicker("refresh");
	} else if(pilihan == "1-REGION"){
		console.log('REGION');
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Mapping_customer/List_region",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected>- Pilih Regional -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'">'+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
				document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
			
			}
        });
	} else if(pilihan == "2-PROVINSI"){
		console.log('PROVINSI');
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Mapping_customer/List_provinsi",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected>- Pilih Provinsi -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'">'+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
				document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
			
			}
        });
	} else if(pilihan == "3-DISTRIK"){
		console.log('DISTRIK');
		
	} else if(pilihan == "4-AREA"){
		console.log('AREA');
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Mapping_customer/List_area",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected>- Pilih Area -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'">'+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
				document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
			
			}
        });
	} else if(pilihan == "5-DISTRIBUTOR"){
		console.log('DISTRIBUTOR');
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Mapping_customer/List_distributor",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected>- Pilih Distributor -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'">'+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
				document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
			
			}
        });
	}
}

$(document).on("change", "#listFilterSetVal", function(){
	var FilterSet = $(this).val();
	console.log(FilterSet);
});

$(document).on("click", "#btnFilter", function(){
	//$("#tableMapping").DataTable().destroy();
	var By = $('#listFilterByVal option:selected').val();
	var Set = $('#listFilterSetVal option:selected').val();
	if(By == "0-ALL"){
		Set = 0;
	}
	tampil_data(By, Set);
});

function tampil_data(filterBy, filterSet){
	$("#show_data").html('<tr><td colspan="11"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	//console.log(provinsi);
	console.log(filterBy);
	console.log(filterSet);
	$.ajax({
		url: '<?php echo site_url(); ?>sbi/Mapping_customer/TampilData',
		type: 'POST',
		dataType : 'json',
		data: {
			"By"  : filterBy,
			"Set" : filterSet
		},
		success: function(data){
			  response = data['data'];
			  var html = '';
			  var i;
			  var c = "x";
			  var no = 1 ;
			  for(i=0; i<response.length; i++){
				 var times = "-";
				 if(response[i].CREATE_DATE != null){
					 times = response[i].CREATE_DATE;
				 }
				  
				html += 
				'<tr class='+c+'>'+
					'<td>'+no+'</td>'+
					'<td>'+response[i].KD_CUSTOMER+'</td>'+
					'<td>'+response[i].NAMA_TOKO+'</td>'+
					'<td>'+response[i].ALAMAT+' - '+response[i].NAMA_DISTRIK+' - '+response[i].NAMA_PROVINSI+' ['+response[i].NAMA_AREA+' - REGION '+response[i].NEW_REGION+']</td>'+
					'<td>'+response[i].NAMA_DISTRIBUTOR+'</td>'+
					'<td>'+response[i].NAMA_SALES.toUpperCase()+'</td>'+
					'<td>'+response[i].NAMA_TSO+'</td>'+
					'<td>'+response[i].NAMA_ASM+'</td>'+
					'<td>'+response[i].NAMA_RSM+'</td>'+
					'<td>'+response[i].NAMA_GSM+'</td>'+
					'<td>'+times+'</td>'+
				'</tr>';
				no++;
				if(c == "x"){
					c = "y"  ;
				}else{
					c = "x" ; 
				}
			  }
			$('#show_data').html(html);
			$("#tableMapping").dataTable();
		},
		error: function(){
		}
    });
}

$(document).on("click", "#btnToExcel", function(e){
	e.preventDefault();
	var By = $('#listFilterByVal option:selected').val();
	var Set = $('#listFilterSetVal option:selected').val();
	if(By == "0-ALL"){
		Set = 0;
	} 
	window.open("<?php echo base_url()?>sbi/Mapping_customer/to_Excel_point?by="+By+"&set="+Set,"_blank");
});

</script>
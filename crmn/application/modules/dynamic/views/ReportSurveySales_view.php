<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
				<div class="card" style="padding-bottom: 0;">
				
					<div class="header bg-purple">
						<h2 style="padding-top: 0.2em;">Report Supervisory Visit</h2>
					</div>
						
					<div class="body">

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
									<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
										Filter Tahun : 
										<select id="ListFilterTahun" name="ListFilterTahun" class="form-control show-tick" data-size="5">
													
											<?php for($j=date('Y')-4;$j<=date('Y');$j++){ ?>
											<option value="<?php echo $j; ?>" 
												<?php if($this->session->userdata("set_tahun") == $j){ 
													echo "selected";
												} ?>>
											<?php echo $j; ?>
											</option>
											<?php } ?>
										</select>
									</div>
												
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <b>&nbsp;</b><br/>
                                        <button style="float: left;" type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                                         <button style="float: left; " id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect" ><span class="fa fa-file-excel-o"></span> Export </button>
                                    </div>			
                                </form>
                            </div>	
						</div>
						
						<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
                                <table id="tableSurvei" class="table table-striped table-bordered table-hover" border="1" width="100%" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th width="3%">NO SURVEI</th>
											<th>TANGGAL</th>
											<th>SALES</th>
                                            <th>SO</th>
											<th>DISTRIBUTOR</th>
                                            <th>CUSTOMER</th>
											<th>ALAMAT</th>
											<th>NILAI</th>
											
											<th width="3%" style="text-align: center;">DETAIL</th>
                                        </tr>
                                    </thead>
									<tbody id="show_data">
									</tbody>
                                </table>
                            </div>
						</div>
						</div>
						
					</div>
					
				</div>
				
			</div>
		</div>
    </div>
</section>

<script>

var id_ju = '<?= $this->session->userdata("id_jenis_user"); ?>';
//console.log(id_ju);

$(document).ready(function(){
	ListFilterBy("#ListFilterBy");
	ListFilterSet("b404d");
	
	tampil_data(null,null,null);
});

function ListFilterBy(key){
	var type_list = 'Filter By :';
    type_list += '<select id="listFilterByVal" name="FilterBy" class="form-control selectpicker show-tick">';
	type_list += '<option disabled selected value="b404d">Nothing selected</option>';
    type_list += '<option value="0-ALL">ALL</option>';
	
	if(id_ju != 1016 && id_ju != 1010 && id_ju != 1011 && id_ju != 1012){
    	type_list += '<option value="1-GSM">GSM</option>';
	}
	if(id_ju != 1010 && id_ju != 1011 && id_ju != 1012){
		type_list += '<option value="2-SSM">SSM</option>';
	}
	if(id_ju != 1011 && id_ju != 1012){
		type_list += '<option value="3-SM">SM</option>';
	}
	if(id_ju != 1012){
		type_list += '<option value="4-SO">SO</option>';
	}
	
	type_list += '<option value="5-SALES">SALES</option>';
	type_list += '<option value="6-DISTRIBUTOR">DISTRIBUTOR</option>';
    type_list += '</select>';
	
    $(key).html(type_list);
    $(".selectpicker").selectpicker("refresh");
}

$(document).on("change", "#listFilterByVal", function(){
	var FilterBy = $(this).val();
	ListFilterSet(FilterBy);
});

function ListFilterSet(pilihan){
	var response;
	var key = "#ListFilterSet";
	var type_list = 'Filter Set :';
	type_list += '<select id="listFilterSetVal" name="FilterSet" class="form-control selectpicker show-tick" data-size="10" data-live-search="true">';
	if(pilihan == "b404d"){
		type_list += '</select>';
		$(key).html(type_list);
		$(".selectpicker").selectpicker("refresh");
	} else if(pilihan == "0-ALL"){
		type_list += '</select>';
		$(key).html(type_list);
		$(".selectpicker").selectpicker("refresh");
	} else if(pilihan == "1-GSM"){
		$.ajax({
			url: "<?php echo base_url(); ?>sales/ReportSurveySales/List_dt_select",
			type: 'POST',
			dataType: 'JSON',
			data: {
				"dt_set_in"  : pilihan,
			},
			success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected>- Pilih GSM -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'">['+response[i][0]+'] '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
				document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
			}
		});
	} else if(pilihan == "2-SSM"){
		$.ajax({
			url: "<?php echo base_url(); ?>sales/ReportSurveySales/List_dt_select",
			type: 'POST',
			dataType: 'JSON',
			data: {
				"dt_set_in"  : pilihan,
			},
			success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected>- Pilih SSM -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'">['+response[i][0]+'] '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
				document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
			}
		});
	} else if(pilihan == "3-SM"){
		$.ajax({
			url: "<?php echo base_url(); ?>sales/ReportSurveySales/List_dt_select",
			type: 'POST',
			dataType: 'JSON',
			data: {
				"dt_set_in"  : pilihan,
			},
			success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected>- Pilih SM -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'">['+response[i][0]+'] '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
				document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
			}
		});
	} else if(pilihan == "4-SO"){
		$.ajax({
			url: "<?php echo base_url(); ?>sales/ReportSurveySales/List_dt_select",
			type: 'POST',
			dataType: 'JSON',
			data: {
				"dt_set_in"  : pilihan,
			},
			success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected>- Pilih SO -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'">['+response[i][0]+'] '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
				document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
			}
		});
	} else if(pilihan == "5-SALES"){
		$.ajax({
			url: "<?php echo base_url(); ?>sales/ReportSurveySales/List_dt_select",
			type: 'POST',
			dataType: 'JSON',
			data: {
				"dt_set_in"  : pilihan,
			},
			success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected>- Pilih SALES -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'">['+response[i][0]+'] '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
				document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
			}
		});
	} else if(pilihan == "6-DISTRIBUTOR"){
		$.ajax({
			url: "<?php echo base_url(); ?>sales/ReportSurveySales/List_dt_select",
			type: 'POST',
			dataType: 'JSON',
			data: {
				"dt_set_in"  : pilihan,
			},
			success: function(data){
				response = data['data'];
				type_list += '<option value="0" disabled selected>- Pilih DISTRIBUTOR -</option>';
				for (var i = 0; i < response.length; i++) {
					type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'">['+response[i][0]+'] '+response[i][1]+'</option>';
				}
				type_list += '</select>';
				$(key).html(type_list);
				$(".selectpicker").selectpicker("refresh");
				document.getElementsByClassName("bs-searchbox")[0].getElementsByTagName("input")[0].style.marginLeft = "5px";
			}
		});
	}
}

$(document).on("click", "#btnFilter", function(){
	var By = $('#listFilterByVal option:selected').val();
	var Set = $('#listFilterSetVal option:selected').val();
	var Tahun = $('#ListFilterTahun option:selected').val();
	
	if(By == 'b404d'){
		alert("Masukkan Pilihan Terlebih Dahulu.");
	} else {
		if(By == "0-ALL"){
			Set = "0-ALL";
		} 
		tampil_data(By, Set, Tahun);
	}
});

$(document).on("click", "#btnExport", function(e){
	e.preventDefault();
    var By = $('#listFilterByVal option:selected').val();
	var Set = $('#listFilterSetVal option:selected').val();
	var Tahun = $('#ListFilterTahun option:selected').val();
	
	if(By == 'b404d'){
		alert("Masukkan Pilihan Terlebih Dahulu.");
	} else {
		if(By == "0-ALL"){
			Set = "0-ALL";
		}
		 window.open("<?php echo base_url()?>sales/ReportSurveySales/to_excel_survey?by="+By+"&set="+Set+"&tahun="+Tahun,"_blank");
	}
});

function tampil_data(by, set, tahun){
	$("#show_data").html('<tr><td colspan="10"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	
	$.ajax({
		url: '<?php echo site_url(); ?>sales/ReportSurveySales/TampilData',
		type: 'POST',
		dataType : 'json',
		data: {
			"by"  : by,
			"set" : set,
			"tahun" : tahun
		},
		success: function(data){
			  response = data['data'];
			  var html = '';
			  var i;
			  var no = 1 ;
			  if(response.length != 0){
				  for(i=0; i<response.length; i++){
					  
					var nilai = (response[i].POINT_PEROLEHAN/response[i].POINT_MAX) * 100;
					var exp_tgl = response[i].TGL_KUNJUNGAN_TSO;
					
					html += 
					'<tr >'+
						'<td style="text-align: center;">'+response[i].NO_VISIT+'</td>'+
						'<td>'+exp_tgl+'</td>'+
						'<td>'+response[i].NAMA_SALES+'</td>'+
						'<td>'+response[i].NAMA_SO+'</td>'+
						'<td>'+response[i].NAMA_DISTRIBUTOR+'</td>'+
						'<td>'+response[i].NAMA_TOKO.toUpperCase()+'</td>'+
						'<td>'+response[i].ALAMAT+' - '+response[i].NAMA_KECAMATAN+' - '+response[i].NAMA_DISTRIK+' - '+response[i].NAMA_PROVINSI+' ['+response[i].NAMA_AREA+' - REGION '+response[i].REGION+']</td>'+
						'<td>'+nilai.toFixed(2)+'</td>'+
						'<td><center><a target="_blank" href="<?php echo base_url();?>sales/ReportSurveySales/detail/'+response[i].NO_VISIT+'/'+exp_tgl+'"><button type="button" class="btn btn-info"><span class="fa fa-eye"></span></button></a></center></td>'+
					'</tr>';
					no++;
					
				  }
			  } else {
				  html += 
					'<tr><td colspan="10"><center><i class=""></i><p style="margin-top: 1em;"> Data tidak tersedia. </p></center></td></tr>';
			  }
			$('#show_data').html(html);
			$("#tableSurvei").dataTable();
		},
		error: function(){
		}
    });
}

</script>


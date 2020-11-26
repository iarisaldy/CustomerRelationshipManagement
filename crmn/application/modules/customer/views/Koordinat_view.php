<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
	th { font-size: 9px; }
	td { font-size: 9px; }
	th, td { white-space: nowrap; }
	.W{
		background-color:#3F51B5 !important;
		font-weight:bolder;
		color:#FFFFFF;
	}
	.y{
		background-color:#FFFFFF !important;
		
		color:#222222;
	}
	.x{
		background-color:#E3F2FD !important;
		
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
                        <h2 style="padding-top: 0.2em;">CUSTOMER KOODINAT LOCK</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	
                            	<div class="col-md-12">
									<div class="row">
									
											<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" style="margin-top: 1em;">
                                                <div class="form-group">
                                                    <div class="form-line" id="ListFilterBy"></div>
                                                </div>
                                            </div>
											<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" style="margin-top: 1em;">
                                                <div class="form-group">
                                                    <div class="form-line" id="ListFilterSet"></div>
                                                </div>
                                            </div>
											
                                        <form action="" method="post">
										
                                        <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12" style="margin-top: 1em;">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
                                        </form>
										<div style="float: right;" class="col-lg-3 col-md-3">
											<div class="col-lg-8 col-md-8 col-sm-3 col-xs-6">
												<div class="form-group">
													<div class="form-line">
														<b>CARI CUSTOMER</b>
														<input type="text" id="textCari" name="textCari" class="form-control" placeholder="ID CUSTOMER" required>
													</div>
												</div>
											</div>
											<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
												<b>&nbsp;</b><br/>
												<button type="button" id="btnSearch" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-search"></i> Cari</button>
											</div>
										</div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTable no-footer" id="daftar_report" width="100%">
                                            <thead class="w">
                                                <tr>
													<th>NO</th>
                                                    <th width="10%">ID CUSTOMER</th>
													<th width="15%">NAMA TOKO</th>
													<th width="45%">ALAMAT</th>
													<th width="10%">PROVINSI</th>
													<th width="5%">DISTRIK</th>
													<th width="5%">AREA</th>
													<th width="5%">KECAMATAN</th>
													<th width="5%">KOODINAT</th>
													<th width="5%">STATUS LOCK</th>
													<th width="20%">DETAIL</th>
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
	tampil_data("1-PROVINSI","1021-DKI JAKARTA");
	ListFilterBy("#ListFilterBy");
	ListFilterSet("0-NOT");
}); 

function ListFilterBy(key){
	var type_list = '<b>FILTER BY:</b>';
    type_list += '<select id="listFilterByVal" name="FilterBy" class="form-control selectpicker show-tick">';
	type_list += '<option value="0" disabled selected>- Masukkan Pilihan -</option>';
	type_list += '<option value="1-PROVINSI">PROVINSI</option>';
	type_list += '<option value="2-AREA">AREA</option>';
    type_list += '</select>';
	
    $(key).html(type_list);
    $(".selectpicker").selectpicker("refresh");
}

$(document).on("change", "#listFilterByVal", function(){
	var FilterBy = $(this).val();
	console.log(FilterBy);
	ListFilterSet(FilterBy);
});

function ListFilterSet(pilihan){
	var response;
	var key = "#ListFilterSet";
	var type_list = '<b>FILTER SET:</b>';
	type_list += '<select id="listFilterSetVal" name="FilterSet" class="form-control selectpicker show-tick" data-size="10" data-live-search="true">';
	console.log(pilihan);
	if(pilihan == "1-PROVINSI"){
		console.log('PROVINSI');
		$.ajax({
            url: "<?php echo base_url(); ?>customer/Koordinat/Provinsi",
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
	} else if(pilihan == "2-AREA"){
		console.log('AREA');
		$.ajax({
            url: "<?php echo base_url(); ?>customer/Koordinat/Area",
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
	} else {
		//type_list += '<option value="0">-</option>';
		type_list += '</select>';
		$(key).html(type_list);
		$(".selectpicker").selectpicker("refresh");
	}
}

$(document).on("change", "#listFilterSetVal", function(){
	var FilterSet = $(this).val();
	console.log(FilterSet);
});

$(document).on("click", "#btnFilter", function(){
	$("#daftar_report").DataTable().destroy();
	var By = $('#listFilterByVal option:selected').val();
	var Set = $('#listFilterSetVal option:selected').val();
	tampil_data(By, Set);
});

$(document).on("click", "#btnSearch", function(){
	$("#daftar_report").DataTable().destroy();
	var id_customerToko = $('#textCari').val();
	console.log(id_customerToko);
	cari_data(id_customerToko);
});

function tampil_data(filterBy, filterSet){
	$("#show_data").html('<tr><td colspan="11"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	//console.log(provinsi);
	$.ajax({
		url: '<?php echo site_url(); ?>customer/Koordinat/TampilData',
		type: 'POST',
		dataType : 'json',
		data: {
			"By"  : filterBy,
			"Set" : filterSet
		},
		success: function(data){
			  var html = '';
			  var i;
			  var c = "x";
			  var no = 1 ;
			  for(i=0; i<data.length; i++){
				var status = "";
				var koorToko = '<td>Ltd: '+data[i].LATITUDE+' | Lng: '+data[i].LONGITUDE+'</td>';
				if(data[i].KOORDINAT_LOCK != 1){
					status = "UNLOCKED";
				} else {
					status = "LOCKED";
				}
				
				if(data[i].LATITUDE == null){
					koorToko = '<td>BELUM DITENTUKAN</td>';
					status = "-";
				}
				
				html += '<tr class='+c+'>'+
				'<td>'+no+'</td>'+
				'<td>'+data[i].ID_CUSTOMER+'</td>'+
				'<td>'+data[i].NAMA_TOKO+'</td>'+
				'<td>'+data[i].ALAMAT+'</td>'+
				'<td>'+data[i].NAMA_PROVINSI+'</td>'+
				'<td>'+data[i].NAMA_DISTRIK+'</td>'+
				'<td>'+data[i].NAMA_AREA+'</td>'+
				'<td>'+data[i].NAMA_KECAMATAN+'</td>'+
				koorToko+
				'<td>'+status+'</td>'+
				'<td><center><a target="_blank" href="<?php echo base_url();?>customer/Profil/detail/'+data[i].ID_CUSTOMER+'"><button type="button" class="btn btn-info"><span class="fa fa-eye"></span></button></a></center></td>'+
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
 
function cari_data(customer_in){
	$("#show_data").html('<tr><td colspan="11"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	
	$.ajax({
		url: '<?php echo site_url(); ?>customer/Koordinat/CariData',
		type: 'POST',
		dataType : 'json',
		data: {
			"customer" : customer_in
		},
		success: function(data){
			  var html = '';
			  var i;
			  var c = "x";
			  var no = 1 ;
			  for(i=0; i<data.length; i++){
				var status = "";
				var koorToko = '<td>Ltd: '+data[i].LATITUDE+' | Lng: '+data[i].LONGITUDE+'</td>';
				if(data[i].KOORDINAT_LOCK != 1){
					status = "UNLOCKED";
				} else {
					status = "LOCKED";
				}
				
				if(data[i].LATITUDE == null){
					koorToko = '<td>BELUM DITENTUKAN</td>';
					status = "-";
				}
				
				html += '<tr class='+c+'>'+
				'<td>'+no+'</td>'+
				'<td>'+data[i].ID_CUSTOMER+'</td>'+
				'<td>'+data[i].NAMA_TOKO+'</td>'+
				'<td>'+data[i].ALAMAT+'</td>'+
				'<td>'+data[i].NAMA_PROVINSI+'</td>'+
				'<td>'+data[i].NAMA_DISTRIK+'</td>'+
				'<td>'+data[i].NAMA_AREA+'</td>'+
				'<td>'+data[i].NAMA_KECAMATAN+'</td>'+
				koorToko+
				'<td>'+status+'</td>'+
				'<td><center><a target="_blank" href="<?php echo base_url();?>customer/Profil/detail/'+data[i].ID_CUSTOMER+'"><button type="button" class="btn btn-info"><span class="fa fa-eye"></span></button></a></center></td>'+
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

</script>
<style>
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
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>VISIT PLAN SALES</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        <form action="" method="post">
                                        <div class="col-lg-3 col-md-2 col-sm-3 col-xs-6">
                                            <b>Sales</b>
                                            <select id="filterSales" name="filterSales" class="form-control show-tick">
                                                <option value="">All</option>
												<?php
												foreach ($list_sales as $ListSalesValue) { ?>
												<option value="<?php echo $ListSalesValue->ID_SALES; ?>"><?php echo $ListSalesValue->NAMA_SALES; ?></option>
												<?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
										<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
											<b>&nbsp;</b><br/>
											<button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-file-excel-o"></i> Export </button>
										</div>
										<button type="button" id="btnTambah" class="btn btn-warning btn-sm btn-lg m-15-30 waves-effect" style="float: right;"><i class="fa fa-plus"></i> Tambah Visit Plan</button>
                                        </form>
                                    </div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTable no-footer" id="tugas_sales" width="100%" style="width: 100%; font-size:11px;">
                                            <thead class="w">
                                                <tr>
                                                    <th width="15%">NAMA SALES</th>
                                                    <th width="30%">NAMA TOKO</th>
													<th width="5%">ID DISTRIBUTOR</th>
													<th width="5%">SUN</th>
													<th width="5%">MON</th>
													<th width="5%">TUE</th>
													<th width="5%">WED</th>
													<th width="5%">THU</th>
													<th width="5%">FRI</th>
													<th width="5%">SAT</th>
													<th width="5%">WEEK1</th>
													<th width="5%">WEEK2</th>
													<th width="5%">WEEK3</th>
													<th width="5%">WEEK4</th>
													<th width="5%">WEEK5</th>
													<th width="5%">UPDATE</th>
													<th width="1%">DELETE</th>
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
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document" style="width:1200px;">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #00b0e4;color: white;">
                        <h4 class="modal-title" id="headerTableRetail"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <table id="tableDaftarTokoDistrik" class="table table-bordered table-striped" style="width: 100%; font-size:10px;">
                                    <thead>
                                        <tr>
                                            <th>NAMA SALES</th>
											<th>ID CUSTOMER</th>
											<th>ID DISTRIBUTOR</th>
											<th>SUN</th>
											<th>MON</th>
											<th>TUE</th>
											<th>WED</th>
											<th>THU</th>
											<th>FRI</th>
											<th>SAT</th>
											<th>WEEK1</th>
											<th>WEEK2</th>
											<th>WEEK3</th>
											<th>WEEK4</th>
											<th>WEEK5</th>
                                        </tr>
                                    </thead>
									<tbody id="checkis_data">
										 <tr>
                                            <th><input type="text" id="id_sales_edit" value ="" class="filled-in" disabled></th>
											<th><input type="text" id="id_cus_edit" value ="" class="filled-in" disabled></th>
											<th><input type="text" id="tahun_edit" value ="" class="filled-in" disabled></th>
											<th><input type="text" id="sun_edit" value ="" class="filled-in" size="4" maxlength="1"></th>
											<th><input type="text" id="mon_edit" value ="" class="filled-in" size="4" maxlength="1"></th>
											<th><input type="text" id="tue_edit" value ="" class="filled-in" size="4" maxlength="1"></th>
											<th><input type="text" id="wed_edit" value ="" class="filled-in" size="4" maxlength="1"></th>
											<th><input type="text" id="thu_edit" value ="" class="filled-in" size="4" maxlength="1"></th>
											<th><input type="text" id="fri_edit" value ="" class="filled-in" size="4" maxlength="1"></th>
											<th><input type="text" id="sat_edit" value ="" class="filled-in" size="4" maxlength="1"></th>
											<th><input type="text" id="week1_edit" value ="" class="filled-in" size="4" maxlength="1"></th>
											<th><input type="text" id="week2_edit" value ="" class="filled-in" size="4" maxlength="1"></th>
											<th><input type="text" id="week3_edit" value ="" class="filled-in" size="4" maxlength="1"></th>
											<th><input type="text" id="week4_edit" value ="" class="filled-in" size="4" maxlength="1"></th>
											<th><input type="text" id="week5_edit" value ="" class="filled-in" size="4" maxlength="1"></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
							<b>FORMAT MENGGUNAKAN HURUF BESAR CONTOH : Y/N</b>
                        </div>
                    </div>
                    <div class="modal-footer">
						<button type="button" id="EditSimpan" class="btn btn-sm btn-success waves-effect" data-dismiss="modal">SIMPAN</button>
                        <button type="button" class="btn btn-sm btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
		
<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document" style="width:1200px;">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #00b0e4;color: white;">
                        <h4 class="modal-title" id="headerTableRetail">TAMBAH VISIT PLAN SALES</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
							<input type="hidden" name="id_edit" id="id_edit">
                                <table id="tableDaftarTokoDistrik" class="table table-bordered table-stripedx" style="width: 100%; font-size:10px;">
                                    <thead>
                                        <tr>
                                            <th>NAMA SALES</th>
											<th>NAMA TOKO</th>
											<th>ID DISTRIBUTOR</th>
											<th>SUN</th>
											<th>MON</th>
											<th>TUE</th>
											<th>WED</th>
											<th>THU</th>
											<th>FRI</th>
											<th>SAT</th>
											<th>WEEK1</th>
											<th>WEEK2</th>
											<th>WEEK3</th>
											<th>WEEK4</th>
											<th>WEEK5</th>
                                        </tr>
                                    </thead>
									<tbody id="checkis_data">
										 <tr>
                                            <th> 
												<select id="TambahSales" name="TambahSales" class="form-control show-tick">
                                                <option value ="">Pilih Sales</option>
												<?php
												foreach ($list_sales as $ListSalesValue) { ?>
												<option value="<?php echo $ListSalesValue->ID_SALES; ?>"><?php echo $ListSalesValue->NAMA_SALES; ?></option>
												<?php } ?>
												</select>
											</th>
											<th id="tambahtoko">
											</th>
											<th id="distributor">
											</th>
											<th><input type="checkbox" id="sun_tambah" value ="N"><label for="sun_tambah"></label></th>
											<th><input type="checkbox" id="mon_tambah" value ="N"><label for="mon_tambah"></label></th>
											<th><input type="checkbox" id="tue_tambah" value ="N"><label for="tue_tambah"></label></th>
											<th><input type="checkbox" id="wed_tambah" value ="N"><label for="wed_tambah"></label></th>
											<th><input type="checkbox" id="thu_tambah" value ="N"><label for="thu_tambah"></label></th>
											<th><input type="checkbox" id="fri_tambah" value ="N"><label for="fri_tambah"></label></th>
											<th><input type="checkbox" id="sat_tambah" value ="N"><label for="sat_tambah"></label></th>
											<th><input type="checkbox" id="week1_tambah" value ="N"><label for="week1_tambah"></label></th>
											<th><input type="checkbox" id="week2_tambah" value ="N"><label for="week2_tambah"></label></th>
											<th><input type="checkbox" id="week3_tambah" value ="N"><label for="week3_tambah"></label></th>
											<th><input type="checkbox" id="week4_tambah" value ="N"><label for="week4_tambah"></label></th>
											<th><input type="checkbox" id="week5_tambah" value ="N"><label for="week5_tambah"></label></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
						<button type="button" id="TambahSimpan" class="btn btn-sm btn-success waves-effect" data-dismiss="modal">SIMPAN</button>
                        <button type="button" class="btn btn-sm btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
<script>
$(document).ready(function() {
	$("#btnFilter").click();
	
	$('#TambahSales').change(function(){ 
		var id=$(this).val();
		//console.log(id);
		$.ajax({
			url : "<?php echo site_url();?>master/Sales_Tahunan/toko_sales_tso",
			method : "POST",
			data : {
				"id" : id
			},
			async : true,
			dataType : 'json',
			success: function(data){ 
				var a = '';
				var i;
				for(i=0; i<data.length; i++){
					a += '<option value='+data[i].KD_CUSTOMER+'>'+data[i].NAMA_TOKO+'</option>';
					c = data[i].KODE_DISTRIBUTOR;
				}
				var b = '<select id="dicus" name="a" class="form-control show-tick">'+a+'</select>';
				var x = '<input type="text" id="iddis" value ='+c+' class="filled-in" disabled>';
				$('#tambahtoko').html(b);
				$('#distributor').html(x);
			}
		});
    return false;
    });    	
});


$(document).on("click", "#btnFilter", function(){
		$("#tugas_sales").DataTable().destroy();	
		$("#show_data").html('<tr><td colspan="17"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	
		var idsales	= $('#filterSales option:selected').val();
		
		$.ajax({
		url: '<?php echo site_url(); ?>master/Sales_Tahunan/tampildata',
		type: 'POST',
		async : true,
		dataType : 'json',
		data: {
			"idsales" : idsales,
		},
		success: function(data){
			  var html = '';
			  var i;
			  for(i=0; i<data.length; i++){
				html += '<tr>'+
				'<td>'+data[i].NAMA+'</td>'+
				'<td>'+data[i].NAMA_TOKO+'</td>'+
				'<td>'+data[i].ID_DISTRIBUTOR+'</td>'+
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
				'<td>'+'<button class="btn btn-success waves-effect " id="edit" idpd="'+data[i].NO_JADWAL+'"><span class="fa fa-cog"></span></button>'+'</td>'+
				'<td>'+'<button class="btn btn-danger waves-effect " id="hapus" idpd="'+data[i].NO_JADWAL+'"><span class="fa fa-trash-o"></span></button>'+'</td>'+
				'</tr>';
			  }
			$('#show_data').html(html);
			$("#tugas_sales").dataTable();
		},
		error: function(){
		}
    });
});
$(document).on("click", "#hapus", function(){
	idpd = $(this).attr("idpd");
	$.ajax({
		url: '<?php echo site_url(); ?>master/Sales_Tahunan/Ajax_hapus_data',
		type: 'POST',
		data: {
			"no" : idpd
		},
		success: function(data){
		alert("DATA SUKSES DIHAPUS!")
		$("#btnFilter").click();
		},
		error: function(){
		}
    });
	
});

$(document).on("click", "#edit", function(){
	$("#modal_edit").modal('show');
	
	idpd = $(this).attr("idpd");
	
	$("#id_edit").val(idpd);
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Sales_Tahunan/Ajax_data_id',
		type: 'POST',
		data: {
			"nojadwal" : idpd
		},
		success: function(j){
			var dt = JSON.parse(j);
			var data =(dt.html[0]);
			$("#id_sales_edit").val(data.ID_SALES);
			$("#id_cus_edit").val(data.ID_CUSTOMER);
			$("#tahun_edit").val(data.ID_DISTRIBUTOR);
			$("#sun_edit").val(data.SUN);
			$("#mon_edit").val(data.MON);
			$("#tue_edit").val(data.TUE);
			$("#wed_edit").val(data.WED);
			$("#thu_edit").val(data.THU);
			$("#fri_edit").val(data.FRI);
			$("#sat_edit").val(data.SAT);
			$("#week1_edit").val(data.W1);
			$("#week2_edit").val(data.W2);
			$("#week3_edit").val(data.W3);
			$("#week4_edit").val(data.W4);
			$("#week5_edit").val(data.W5);
		},
		error: function(){
		}
    });
});

$(document).on("click", "#btnTambah", function(){
	$("#modal_tambah").modal('show');
});


	
$(document).on("click", "#EditSimpan", function(){
	no = $("#id_edit").val();
	sun = $("#sun_edit").val();
	mon = $("#mon_edit").val();
	tue = $("#tue_edit").val();
	wed = $("#wed_edit").val();
	thu = $("#thu_edit").val();
	fri = $("#fri_edit").val();
	sat = $("#sat_edit").val();
	week1 = $("#week1_edit").val();
	week2 = $("#week2_edit").val();
	week3 = $("#week3_edit").val();
	week4 = $("#week4_edit").val();
	week5 = $("#week5_edit").val();
	
	// data = [no,sun,mon,tue,wed,thu,fri,sat,week1,week2,week3,week4,week5]
	// console.log(data);
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Sales_Tahunan/Ajax_simpan_edit',
		type: 'POST',
		data: { 
			"no" : no,
			"sun" : sun,
			"mon" : mon,
			"tue" : tue,
			"wed" : wed,
			"thu" : thu,
			"fri" : fri,
			"sat" : sat,
			"w1" : week1,
			"w2" : week2,
			"w3" : week3,
			"w4" : week4,
			"w5" : week5
		},
		success: function(data){
		$("#btnFilter").click();
		},
		error: function(){
		}
    });
	
});
$("#sun_tambah").click(function () {
    if ($(this).prop("checked")) {
        $("#sun_tambah").val("Y");
    }
    else {
        $("#sun_tambah").val("N");
    }
});
$("#mon_tambah").click(function () {
    if ($(this).prop("checked")) {
        $("#mon_tambah").val("Y");
    }
    else {
        $("#mon_tambah").val("N");
    }
});
$("#tue_tambah").click(function () {
    if ($(this).prop("checked")) {
        $("#tue_tambah").val("Y");
    }
    else {
        $("#tue_tambah").val("N");
    }
});
$("#wed_tambah").click(function () {
    if ($(this).prop("checked")) {
        $("#wed_tambah").val("Y");
    }
    else {
        $("#wed_tambah").val("N");
    }
});
$("#thu_tambah").click(function () {
    if ($(this).prop("checked")) {
        $("#thu_tambah").val("Y");
    }
    else {
        $("#thu_tambah").val("N");
    }
});
$("#fri_tambah").click(function () {
    if ($(this).prop("checked")) {
        $("#fri_tambah").val("Y");
    }
    else {
        $("#fri_tambah").val("N");
    }
});
$("#sat_tambah").click(function () {
    if ($(this).prop("checked")) {
        $("#sat_tambah").val("Y");
    }
    else {
        $("#sat_tambah").val("N");
    }
});
$("#week1_tambah").click(function () {
    if ($(this).prop("checked")) {
        $("#week1_tambah").val("Y");
    }
    else {
        $("#week1_tambah").val("N");
    }
});
$("#week2_tambah").click(function () {
    if ($(this).prop("checked")) {
        $("#week2_tambah").val("Y");
    }
    else {
        $("#week2_tambah").val("N");
    }
});
$("#week3_tambah").click(function () {
    if ($(this).prop("checked")) {
        $("#week3_tambah").val("Y");
    }
    else {
        $("#week3_tambah").val("N");
    }
});
$("#week4_tambah").click(function () {
    if ($(this).prop("checked")) {
        $("#week4_tambah").val("Y");
    }
    else {
        $("#week4_tambah").val("N");
    }
});
$("#week5_tambah").click(function () {
    if ($(this).prop("checked")) {
        $("#week5_tambah").val("Y");
    }
    else {
        $("#week5_tambah").val("N");
    }
});

$(document).on("click", "#TambahSimpan", function(){
	idsales = $("#TambahSales option:selected").val();
	idcus = $("#dicus option:selected").val();
	dis = $("#iddis").val();
	
	sun = $("#sun_tambah").val();
	mon = $("#mon_tambah").val();
	tue = $("#tue_tambah").val();
	wed = $("#wed_tambah").val();
	thu = $("#thu_tambah").val();
	fri = $("#fri_tambah").val();
	sat = $("#sat_tambah").val();
	week1 = $("#week1_tambah").val();
	week2 = $("#week2_tambah").val();
	week3 = $("#week3_tambah").val();
	week4 = $("#week4_tambah").val();
	week5 = $("#week5_tambah").val();
	
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Sales_Tahunan/Ajax_tambah_data',
		type: 'POST',
		data: { 
			"idsales" : idsales,
			"idcus" : idcus,
			"dis" : dis,
			"sun" : sun,
			"mon" : mon,
			"tue" : tue,
			"wed" : wed,
			"thu" : thu,
			"fri" : fri,
			"sat" : sat,
			"w1" : week1,
			"w2" : week2,
			"w3" : week3,
			"w4" : week4,
			"w5" : week5
		},
		success: function(data){
		location.reload(true);
		},
		error: function(){
		}
    });
	
});

$(document).on("click", "#btnExport", function(e){
		e.preventDefault();
        var idsales	= $('#filterSales option:selected').val();

        window.open("<?php echo base_url()?>master/Sales_Tahunan/toExcel?idsales="+idsales,"_blank");
});
</script>
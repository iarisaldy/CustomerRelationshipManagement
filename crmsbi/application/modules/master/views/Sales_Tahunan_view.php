td{
    position:relative;
    border:1px solid grey;
    overflow:hidden;
}
label{
    background:red;
    text-align:center;
    position:relative;
    padding:50px;
    margin:-5px;
}
input{
    position:absolute;
}
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>JADWAL VISIT SALES TAHUNAN</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        <form action="" method="post">
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                            <b>Sales</b>
                                            <select id="filterSales" name="filterSales" class="form-control show-tick">
                                                <option>Pilih Sales</option>
												<?php
												foreach ($list_sales as $ListSalesValue) { ?>
												<option value="<?php echo $ListSalesValue->ID_USER; ?>"><?php echo $ListSalesValue->NAMA; ?></option>
												<?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
										<button type="button" id="btnTambah" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-plus"></i>Tambah</button>
                                        </form>
                                    </div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTable no-footer" id="tugas_sales" width="100%">
                                            <thead class="w">
                                                <tr>
                                                    <th width="15%">ID SALES</th>
                                                    <th width="30%">NAMA TOKO</th>
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
													<th width="5%">SET</th>
                                                </tr>
                                            </thead>
                                            <tbody id="show_data">
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
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog">
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
									<th>ID SALES</th>
									<th>NAMA TOKO</th>
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
								</tr>
							</thead>
							<tbody id="checkis_data">
								 <tr>
									<th><input type="text" id="id_sales" value ="" class="filled-in" disabled></th>
									<th><input type="text" id="nama_toko" value ="" class="filled-in"disabled></th>
									<th><input type="text" id="sun" value ="" class="filled-in" size="4" maxlength="1"></th>
									<th><input type="text" id="mon" value ="" class="filled-in" size="4" maxlength="1"></th>
									<th><input type="text" id="tue" value ="" class="filled-in" size="4" maxlength="1"></th>
									<th><input type="text" id="wed" value ="" class="filled-in" size="4" maxlength="1"></th>
									<th><input type="text" id="thu" value ="" class="filled-in" size="4" maxlength="1"></th>
									<th><input type="text" id="fri" value ="" class="filled-in" size="4" maxlength="1"></th>
									<th><input type="text" id="sat" value ="" class="filled-in" size="4" maxlength="1"></th>
									<th><input type="text" id="week1" value ="" class="filled-in" size="4" maxlength="1"></th>
									<th><input type="text" id="week2" value ="" class="filled-in" size="4" maxlength="1"></th>
									<th><input type="text" id="week3" value ="" class="filled-in" size="4" maxlength="1"></th>
									<th><input type="text" id="week4" value ="" class="filled-in" size="4" maxlength="1"></th>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-success waves-effect" data-dismiss="modal">SIMPAN</button>
				<button type="button" class="btn btn-sm btn-info waves-effect" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog">
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
				<button type="button" id="btnSave" class="btn btn-sm btn-success waves-effect" >SIMPAN</button>
				<button type="button" class="btn btn-sm btn-info waves-effect" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	$("#tugas_sales").dataTable();
	
$(document).on("click", "#btnFilter", function(){
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
			  //console.log(data);
			  var html = '';
			  var i;
			  for(i=0; i<data.length; i++){
				html += '<tr>'+
				'<td>'+data[i].ID_SALES+'</td>'+
				'<td>'+data[i].NAMA_TOKO+'</td>'+
				'<td>'+data[i].SUN+'</td>'+
				'<td>'+data[i].MON+'</td>'+
				'<td>'+data[i].TUE+'</td>'+
				'<td>'+data[i].WED+'</td>'+
				'<td>'+data[i].THU+'</td>'+
				'<td>'+data[i].FRI+'</td>'+
				'<td>'+data[i].SAT+'</td>'+
				'<td>'+data[i].WEEK1+'</td>'+
				'<td>'+data[i].WEEK2+'</td>'+
				'<td>'+data[i].WEEK3+'</td>'+
				'<td>'+data[i].WEEK4+'</td>'+
				'<td>'+'<button class="btn btn-success waves-effect " id="edit" idpd="'+data[i].NO_JADWAL+'"><span class="fa fa-cog"></span></button>'+'</td>'+
				'</tr>';
			  }
			$('#show_data').html(html);
			$("#tugas_sales").dataTable();
		},
		error: function(){
		}
    });
});

$(document).on("click", "#edit", function(){
	$("#modaledit").modal('show');
	
	idpd = $(this).attr("idpd");

	
	
	$.ajax({
		url: '<?php echo site_url(); ?>master/Sales_Tahunan/Ajax_data_id',
		type: 'POST',
		data: {
			"nojadwal" : idpd
		},
		success: function(j){
			var dt = JSON.parse(j);
			var data =(dt.html[0]);
			console.log(data);
			$("#id_sales").val(data.ID_SALES);
			$("#nama_toko").val(data.NAMA_TOKO);
			$("#sun").val(data.SUN);
			$("#mon").val(data.MON);
			$("#tue").val(data.TUE);
			$("#wed").val(data.WED);
			$("#thu").val(data.THU);
			$("#fri").val(data.FRI);
			$("#sat").val(data.SAT);
			$("#week1").val(data.WEEK1);
			$("#week2").val(data.WEEK2);
			$("#week3").val(data.WEEK3);
			$("#week4").val(data.WEEK4);
		},
		error: function(){
		}
    });
});

$(document).on("click", "#btnTambah", function(){
	$("#modaltambah").modal('show');
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
$(document).on("click", "#btnSave", function(){
	minggu = $("#sun_tambah").val();
	senin = $("#mon_tambah").val();
	selasa = $("#tue_tambah").val();
	rabo = $("#wed_tambah").val();
	kamis = $("#thu_tambah").val();
	jumat = $("#fri_tambah").val();
	sabtu = $("#sat_tambah").val();
	week1 = $("#week1_tambah").val();
	week2 = $("#week2_tambah").val();
	week3 = $("#week3_tambah").val();
	week4 = $("#week4_tambah").val();
	week5 = $("#week5_tambah").val();
	
	data=[minggu,senin,selasa,rabo,kamis,jumat,sabtu,week1,week2,week3,week4,week5];
	
	console.log(data);
	
	
});
// $('td').click(function(){
    // $(this).children('input').click();
	// $(this).find('input[type="checkbox:checked"]').val("");	
	// $(this).find('input[type="checkbox"]').val("YA");	
// });
// $(document).on('click', 'td', function(){
    // var target = $(this).find('input[type="checkbox"]');

    // target.prop('checked', !target.prop('checked'));
	// if(target.prop('checked')){
	// target.val("YA");
	// }else{
	// target.val("");
	// }
	
// });


	// $(document).on("click", "#Simpan", function(){
	// $.ajax({
		// url: '<?php echo site_url(); ?>master/Master_Menu/Ajax_tambah_data',
		// type: 'POST',
		// data: {
			
			// "idsales"   	: idsales,
			// "senin"   		: senin,
			// "selasa"   		: selasa,
			// "rabo"   		: rabo,
			// "kamis"   		: kamis,
			// "jumat"   		: jumat,
			// "sabtu"   		: sabtu,
			// "minggu"   		: minggu,
			// "week1"   		: week1,
			// "week2"   		: week2,
			// "week3"   		: week3,
			// "week4"   		: week4
		// },
		// success: function(j){
			// var dt = JSON.parse(j);
			// $("#show_data").html(dt.html);
			// $("#daftar_manu").dataTable().api().destroy();
			// $("#daftar_manu").dataTable();
			// location.reload(true);
			
			// if(dt.notify==1){
                // $("#nama_menu").val("");
                // $("#order_menu").val("");      
            // }
		// },
		// error: function(){
		// }
    // });
	
// });
});
	
	
	
	

// $('td').click(function(){
    // $(this).children('input').click();
	// $(this).find('input[type="checkbox:checked"]').val("");	
	// $(this).find('input[type="checkbox"]').val("YA");	
	// senin = $("#senin").val();
	// selasa = $("#selasa").val();
	// rabo = $("#rabo").val();
	// kamis = $("#kamis").val();
	// jumlat = $("#jumat").val();
	// sabtu = $("#sabtu").val();
	// minggu = $("#minggu").val();
	// week1 = $("#week1").val();
	// week2 = $("#week2").val();
	// week3 = $("#week3").val();
	// week4 = $("#week4").val();
	
	// data = [senin,selasa,rabo,kamis,jumlat,sabtu,minggu,week1,week2,week3,week4];
	// console.log(data);
// });
</script>
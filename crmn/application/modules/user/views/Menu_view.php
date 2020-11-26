<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
				<div class="card">
				
					<div class="header bg-cyan">
						<h2 style="padding-top: 0.2em;">MANAJEMEN MENU </h2>
					</div>
						
					<div class="body">
						<div class="row">
							<div class="col-md-12">
								
								<div class="form-group" style="">
									<button style="float: right; margin-right: 1em;" type="button" id="BtnTambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Menu</button>
								</div>
								
							</div>
						
							<div class="col-md-12" >
								<div class="row">
									<div class="table-responsive" style=" margin-left: 2em; margin-right: 2em;">
										<table class="table table-striped table-bordered dataTable no-footer" id="daftar_menu" style="font-size: 12px;">
											<thead >
												<tr>
													<th bgcolor="#ffb990" width="3%">NO</th>
													<th bgcolor="#ffb990" width="8%">ID MENU</th>
													<th bgcolor="#ffb990">NAMA MENU</th>
													<th bgcolor="#ffb990" width="11%" style="display: none;">ICON MENU</th>
													<th bgcolor="#ffb990">LINK</th>
													<th bgcolor="#ffb990" width="5%">ORDER</th>
													<th bgcolor="#ffb990">LIST SUB MENU</th>
													<th bgcolor="#ffb990"><center>ACTION</center></th>
												</tr>
											</thead>
											<tbody id="show_data_menu"></tbody>
										</table>
									</div>
								</div>
							</div>
						
						</div>
					</div>
					
				</div>
				
			</div>
		</div>
    </div>
</section>

<!-- Bootstrap modal Add & Edit User-->
<div class="modal fade" id="modal_menu_a_u" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: rgba(112, 161, 255,1.0); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: #000;">  </h2>
			</div>
			<form id="form-in">
			<div class="modal-body form" >
				<div class="form-body">
					<input type="hidden" id="id_up_menu" name="id_up_menu" value="0000">
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label id="labelNama1" for="name">Nama Menu : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="nama_menu" class="form-control" name="nama_menu" placeholder="Masukkan Nama Menu " required>
								</div>
							</div>
						</div>
					</div>
					<div class="row clearfix" style="display: none;">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label for="name">Icon : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="" id="icon" class="form-control" name="icon" placeholder="Masukkan Icon " >
								</div>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label for="name">Link : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="link" class="form-control" name="link" placeholder="Masukkan Link " >
								</div>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label for="name">Order : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="number" id="order" class="form-control" name="order" placeholder="Masukkan Order " >
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="BtnSimpanMenu" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batalkan</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- Bootstrap modal Add & Edit User-->

<script>
$(document).ready(function() {
   load_menu();
});

$(document).on("click", "#BtnTambah", function(){
	$('#form-in').trigger("reset");
	$("#id_up_user").val(0000);
	$("#modal_menu_a_u").modal('show');
	$('.modal-title').text('Tambah Menu : ');
});

$(document).on("click", "#BtnEdit", function(){
	$("#modal_menu_a_u").modal('show');
	
	var id_menu = $(this).attr("dt_id_menu");
	var nama_menu = $(this).attr("dt_nama_menu");
	var icon = $(this).attr("dt_icon");
	var link = $(this).attr("dt_link");
	var order = $(this).attr("dt_order");
	
	$("#id_up_menu").val(id_menu);
	$("#nama_menu").val(nama_menu);
	$("#icon").val(icon);
	$("#link").val(link);
	$("#order").val(order);
	
	$('.modal-title').text('Edit Menu : ['+id_menu+'] '+nama_menu);
});

$(document).on("click", "#BtnSimpanMenu", function(e){
	e.preventDefault();
	
	var id_menu 	= $("#id_up_menu").val();
	var nama_menu	= $("#nama_menu").val();
	var icon		= $("#icon").val();
	var link		= $("#link").val();
	var order		= $("#order").val();
	
	$.ajax({
		url: '<?php echo site_url(); ?>user/Manajemen_menu/set_menu',
		type: 'POST',
		data: {
			"id_menu" : id_menu,
			"nama_menu" : nama_menu,
			"icon" : icon,
			"link" : link,
			"order" : order
		}, 
		success: function(data){
			$("#modal_menu_a_u").modal('hide');
			alert("Data Menu Berhasil Disimpan.");
			$("#daftar_menu").DataTable().destroy();
			load_menu();
			$("#id_up_menu").val(0000);
		},
		error: function(){
			alert("Data Menu Gagal Disimpan.");
		}
    });
});

$(document).on("click", "#BtnHapus", function(e){
	e.preventDefault();
	var id_menu = $(this).attr("dt_id_menu");
	var nama_menu = $(this).attr("dt_nama_menu");
	if (confirm("Apakah Anda Yakin Ingin Menghapus Data Menu ["+id_menu+" - "+nama_menu+"] ?")) {
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_menu/del_menu',
			type: 'POST',
			data: {
				"id_menu" : id_menu
			},
			success: function(data){
				$("#daftar_menu").DataTable().destroy();
				load_menu();
				alert("Data Menu Berhasil Dihapus.");
			},
			error: function(){
				alert("Data Menu Gagal Dihapus.");
			}
		});
		return true;
    }
});

function load_menu(){
	$("#show_data_menu").html('<tr><td colspan="10"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_menu/list_menu_and_sub',
			type: 'GET',
			dataType : 'json',
			success: function(datasku){
				var data = datasku['data'];
				
				  var html = '';
				  var i;
				  var c = "x"; 
				  var no = 1 ;
				  
				  var link; var order;
				  var setIcon; var setLink; var setOrder;
				  
				  for(i=0; i<data.length; i++){
					  
					if(data[i].ICON == null){
						setIcon = '';
					} else {
						setIcon = data[i].ICON;
					}
					
					if(data[i].LINK == null){
						link = '-';
						setLink = '';
					} else {
						link = data[i].LINK;
						setLink = data[i].LINK;
					}
					
					if(data[i].ORDER_MENU == null){
						order = '-';
						setOrder = '';
					} else {
						order = data[i].ORDER_MENU;
						setOrder = data[i].ORDER_MENU;
					}
					
					var button = '<td style="text-align: center;">'+
								'<a target="_blank" href="<?php echo site_url(); ?>user/Manajemen_menu/Submenu/'+data[i].ID_MENU+'/'+data[i].NAMA_MENU+'"><span id="BtnMapping" class="btn"><i class="fa fa-sitemap" title="mapping sub menu" ></i></span></a> &nbsp;'+
								'<span id="BtnEdit" class="btn btn-info" dt_id_menu="'+data[i].ID_MENU+'" dt_nama_menu="'+data[i].NAMA_MENU+'" dt_icon="'+setIcon+'" dt_link="'+setLink+'" dt_order="'+setOrder+'"><i class="fa fa-edit" title="edit"></i></span> &nbsp;'+
								'<span id="BtnHapus" class="btn btn-danger" dt_id_menu="'+data[i].ID_MENU+'" dt_nama_menu="'+data[i].NAMA_MENU+'"><i class="fa fa-trash" title="hapus"></i></span>'+
							 '</td>'; 
							 
					var sub_menunya = '';
					if(data[i].SUB_MENU.length > 0){
						data[i].SUB_MENU.forEach(function(isi){
							sub_menunya += '- ['+isi.ID_SUBMENU+'] '+isi.NAMA_SUBMENU+'<br>';
						});
					}
					
					html += '<tr class='+c+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID_MENU+'</td>'+
					'<td>'+data[i].NAMA_MENU+'</td>'+
					
					'<td style="text-align: center; display: none;"><i class="fa '+data[i].ICON+'"></i></td>'+
					
					
					'<td>'+link+'</td>'+
					'<td>'+order+'</td>'+
	
					'<td>'+sub_menunya+'</td>'+
					//label+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
			}
				$('#show_data_menu').html(html);
				$("#daftar_menu").dataTable();
			},
			error: function(){
			}
		});
}

</script>


<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
				<div class="card" style="padding-bottom: 0;">
				
					<div class="header bg-cyan">
						<h2 style="padding-top: 0.2em;">MANAJEMEN ROLE USER</h2>
					</div>
						
					<div class="body">
						<div class="row">
						
							<div class="col-md-12">
								<div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
									<label for="" id="labelSetInUp"> TAMBAH JENIS USER : </label>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input id="id_jenis_user" type="hidden" value="0000">
											<input id="jenis_user" type="text" class="form-control" placeholder="NAMA JENIS USER">
										</div>
									</div>
								</div>
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
									<div class="form-group">
										<button type="button" id="BtnSimpan" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
										<button type="button" id="BtnBatal" class="btn btn-danger"><i class="fa fa-times"></i> Batal</button>
									</div>
								</div>
							</div>
								
							<div class="col-md-12" >
								<div class="row">
									<div class="table-responsive" style="margin-left: 2em; margin-right: 2em;">
										<table class="table table-striped table-bordered dataTable no-footer" id="daftar_jenis_user">
											<thead >
												<tr>
													<th bgcolor="#ffb990">NO</th>
													<th bgcolor="#ffb990">ID JENIS USER</th>
													<th bgcolor="#ffb990">NAMA JENIS USER</th>
													<th bgcolor="#ffb990"><center>ACTION</center></th>
												</tr>
											</thead>
											<tbody id="show_data_jenis_user"></tbody>
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
<div class="modal fade" id="modal_a_u" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: rgba(112, 161, 255,1.0); padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" style="color: #000;">  </h2>
			</div>
			<form id="form-in">
			<div class="modal-body form" >
				<div class="form-body">
					<input type="hidden" id="id_j_user" name="id_j_user">
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
							<label for="name">Jenis User : </label>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="j_user" class="form-control" name="link" placeholder="Masukkan nama .. " >
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			<div class="modal-footer">
				<button id="BtnSimpanUp" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batalkan</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- Bootstrap modal Add & Edit User-->

<script>
$(document).ready(function() {
   load_jenis_user();
   $("#BtnBatal").hide();
});

$(document).on("click", "#BtnBatal", function(){
	$('#labelSetInUp').text('TAMBAH JENIS USER : ');
	$("#id_jenis_user").val(0000);
	$("#jenis_user").val(null);
	$("#BtnBatal").hide();
});

$(document).on("click", "#BtnEdit", function(){
	
	var id 	 = $(this).attr("dt_id_Jenis_user");
	var nama =  $(this).attr("dt_nama");
	
	/* Old function
	$('#labelSetInUp').text('EDIT JENIS USER ['+id+'] : ');
	$("#id_jenis_user").val(id);
	$("#jenis_user").val(nama);
	$("#BtnBatal").show();
	*/
	
	$("#modal_a_u").modal('show');
	
	
	$("#id_j_user").val(id);
	$("#j_user").val(nama);
	
	$('.modal-title').text('Edit Menu : ['+id+'] '+nama);
});

$(document).on("click", "#BtnSimpanUp", function(e){
	e.preventDefault();
	
	var id 		= $("#id_j_user").val();
	var nama	= $("#j_user").val();
	
	$.ajax({
		url: '<?php echo site_url(); ?>user/Jenis_user/set_jenis_user',
		type: 'POST',
		data: {
			"id_jenis_user" : id,
			"jenis_user" : nama
		},
		success: function(data){
			alert("Data Jenis User Berhasil Disimpan.");
			$("#daftar_jenis_user").DataTable().destroy();
			load_jenis_user();
			$("#modal_a_u").modal('hide');
		},
		error: function(){
			alert("Data Jenis User Gagal Disimpan.");
		}
    });
});

$(document).on("click", "#BtnSimpan", function(e){
	e.preventDefault();
	
	var id 		= $("#id_jenis_user").val();
	var nama	= $("#jenis_user").val();
	
	$.ajax({
		url: '<?php echo site_url(); ?>user/Jenis_user/set_jenis_user',
		type: 'POST',
		data: {
			"id_jenis_user" : id,
			"jenis_user" : nama
		},
		success: function(data){
			alert("Data Jenis User Berhasil Disimpan.");
			$("#daftar_jenis_user").DataTable().destroy();
			load_jenis_user();
			$('#labelSetInUp').text('TAMBAH JENIS USER : ');
			$("#id_jenis_user").val(0000);
			$("#jenis_user").val(null);
			$("#BtnBatal").hide();
		},
		error: function(){
			alert("Data Jenis User Gagal Disimpan.");
		}
    });
});

$(document).on("click", "#BtnHapus", function(e){
	e.preventDefault();
	
	var id 		= $(this).attr("dt_id_Jenis_user");
	
	if (confirm("Apakah Anda Yakin Ingin Menghapus Data?")) {
		$.ajax({
			url: '<?php echo site_url(); ?>user/Jenis_user/del_jenis_user',
			type: 'POST',
			data: {
				"id_jenis_user" : id
			},
			success: function(data){
				$("#daftar_jenis_user").DataTable().destroy();
				load_jenis_user();
				alert("Data Jenis User Berhasil Dihapus.");
			},
			error: function(){
				alert("Data Jenis User Gagal Dihapus.");
			}
		});
		return true;
    }
	
});

function load_jenis_user(){
	$("#show_data_jenis_user").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Jenis_user/List_jenis_user',
			type: 'GET',
			dataType : 'json',
			success: function(data){
				  var html = '';
				  var i;
				  var c = "x"; 
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					
					var button = '<td style="text-align: center;">'+
								
								'<span id="BtnEdit" class="btn btn-info" dt_id_jenis_user="'+data[i].ID_JENIS_USER+'" dt_nama="'+data[i].JENIS_USER+'" ><i class="fa fa-edit" title="edit"></i></span> &nbsp;'+
								'<span id="BtnHapus" class="btn btn-danger" dt_id_jenis_user="'+data[i].ID_JENIS_USER+'" dt_nama="'+data[i].JENIS_USER+'"><i class="fa fa-trash" title="hapus"></i></span>'+
							 '</td>'; 
					
					html += '<tr class='+c+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID_JENIS_USER+'</td>'+
					'<td>'+data[i].JENIS_USER+'</td>'+
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
				$('#show_data_jenis_user').html(html);
				$("#daftar_jenis_user").dataTable();
			},
			error: function(){
			}
		});
}
</script>
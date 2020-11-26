<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
				<div class="card">
				
					<div class="header bg-cyan">
						<h2 style="padding-top: 0.2em;">MANAJEMEN AKSES MENU</h2>
					</div>
						
					<div class="body">
						<div class="row">
							<div class="col-md-12" style="display: none;">
								<div class="form-group" style="">
									<button style="float: right; margin-right: 1em;" type="button" id="BtnTambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Akses Menu</button>
								</div>
								
							</div>
						
							<div class="col-md-12" >
								<div class="row">
									<div class="table-responsive" style=" margin-left: 2em; margin-right: 2em;">
										<table class="table table-striped table-bordered dataTable no-footer" id="daftar_akses_user" style="font-size: 12px;">
											<thead >
												<tr>
													<th bgcolor="#ffb990" width="3%">NO</th>
													<th bgcolor="#ffb990" width="10%">ID JENIS USER</th>
													<th bgcolor="#ffb990">JENIS USER</th>
													<th bgcolor="#ffb990">LIST MENU & SUB MENU</th>
													<th bgcolor="#ffb990"><center>ACTION</center></th>
												</tr>
											</thead>
											<tbody id="show_data_akses_user"></tbody>
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

<script>

$(document).ready(function() {
   load_akses_menu();
});  

function load_akses_menu(){
	$("#show_data_akses_user").html('<tr><td colspan="10"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_menu/list_akses_menu_by_jenis_user',
			type: 'GET',
			dataType : 'json',
			success: function(datasku){
				var data = datasku['data'];
				
				  var html = '';
				  var i;
				  var c = "x"; 
				  var no = 1 ;
				  
				  for(i=0; i<data.length; i++){
					  
					
					var button = '<td style="text-align: center;">'+
								'<a target="_blank" href="<?php echo site_url(); ?>user/Manajemen_menu/Konfigurasi_akses/'+data[i].ID_JENIS_USER+'/'+data[i].JENIS_USER+'"><span id="BtnMapping" class="btn"><i class="fa fa-cog" title="konfigurasi menu" ></i></span></a> &nbsp;'+
							 '</td>'; 
							 
					var menunya = '';
					
					if(data[i].MENU != null){
						if(data[i].MENU.length != 0){
							data[i].MENU.forEach(function(isi){
								menunya += '<li><b> ['+isi.ID_MENU+'] '+isi.NAMA_MENU+'</b></li>';
								if(isi.SUB_MENU.length > 0){
									isi.SUB_MENU.forEach(function(sub){
										menunya += '<ul>- ['+sub.ID_SUBMENU+'] '+sub.NAMA_SUBMENU+'</ul>';
									});
								}
							});
						}
					}
					
					html += '<tr class='+c+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID_JENIS_USER+'</td>'+
					'<td>'+data[i].JENIS_USER+'</td>'+
	
					'<td>'+menunya+'</td>'+
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
				$('#show_data_akses_user').html(html);
				$("#daftar_akses_user").dataTable();
			},
			error: function(){
			}
		});
}

</script>
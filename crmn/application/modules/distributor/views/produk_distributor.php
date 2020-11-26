<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header header-title bg-green">
                        <h2> Data Produk Distributor</h2>
                    </div>
                    <?php
                        $dataMenu = $menus['dataMenu']; 
                        $subMenus = $menus['subMenu'];

                        foreach ($dataMenu as $menusKey => $menusValue) { 
                            // echo ' - '.$menusValue->ID_MENU;
                         if($menusValue->ID_MENU == '1008'){ 
                    ?>
                        <ul class="submenus">
                        <?php 
                            foreach ($subMenus as $subMenusKey => $subMenusValue) {
                                if($subMenusValue->ID_MENU == $menusValue->ID_MENU){
                        ?>
                            <li><a href="<?php echo base_url().$subMenusValue->LINK; ?>"><?php echo $subMenusValue->NAMA_MENU; ?></a></li>
                            <?php } } ?>
                        </ul>
                    <?php }
                    } ?>
                    
						
                        <!-- Basic Examples -->
            <div class="row clearfix">
                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card-">

                        
                        <div class="body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Data Master Distributor</h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="pull-right">
                                        <button class="btn btn-success waves-effect" id="Tampilkan_form_tambah_distributor"> <i class="fa fa-plus"></i>  Tambah Produk </button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered dataTable no-footer" id="Table_distributor">
                                    <thead>
                                        <tr>
                                            <th bgcolor="#ffb990">NO</th>
											<th bgcolor="#ffb990">Kode Produk</th>
                                            <th bgcolor="#ffb990">Nama Produk</th>
                                            <th bgcolor="#ffb990">Jenis Produk</th>
                                            <th bgcolor="#99baf7">QTY</th>
                                            <th bgcolor="#99baf7">Satuan</th>
                                            <th bgcolor="#99baf7">TGL STOK</th>
                                            <th bgcolor="#a3f799">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="isi_data_hasil_survey">
                                    	<?php  
                                    		echo $Stok_distributor;
                                    	 ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
            
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>

</section>



<!-- For Material Design Colors -->
<div class="modal fade" id="modal_distributor" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <h4 class="modal-title" id="defaultModalLabel">Form Tambah Produk Distributor</h4>
            </div>
            <div class="modal-body">
                <div class="row">

                	<div class="col-md-12">
                		<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Jenis Produk: </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="selectpicker" name="jenis_produk" id="jenis_produk" >
                                           <?php 
                                            echo $jenis_produk;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Produk : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="nm_produk" class="form-control" name="nm_produk" placeholder="Nama Produk">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">STOK : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="stok" class="form-control" name="stok" placeholder="Qty Stok">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">SATUAN : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="satuan" class="form-control" name="satuan" placeholder="Satuan ">
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Harga Beli Satuan : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="hb_satuan" class="form-control" name="hb_satuan" placeholder="Harga Beli Satuan ">
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Harga Jual Satuan : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="hj_satuan" class="form-control" name="hb_satuan" placeholder="Harga Jual Satuan ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix" id="tmp_kd_sap">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">KD Produk SAP : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="kd_produk_sap" class="form-control" name="kd_produk_sap" placeholder="Kode Produk SAP">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">TGL STOK : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <input type="text" id="plannedDate" value="<?php echo date('Y-m-d'); ?>" class="datepicker form-control" placeholder="Please choose a date...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        
                	</div>
                </div>
            </div>
            <div class="modal-footer bg-green">
                <button type="button" class="btn btn-link waves-effect" id="Save_penambahan_distributor"> SAVE</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- For Material Design Colors -->
<div class="modal fade" id="form_tambah_stok_produk_dist" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" id="defaultModalLabel">Form Update Stok </h4>
            </div>
            <div class="modal-body">
                <div class="row">
						<input type="hidden" name="id_pd" id="idpd">
						
						<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">STOK : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="stok_history" class="form-control" name="stok_history" placeholder="Qty Stok">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">SATUAN : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="satuan_history" class="form-control" name="satuan_history" placeholder="Satuan ">
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Harga Beli Satuan : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="hbs_satuan" class="form-control" name="hb_satuan" placeholder="Harga Beli Satuan ">
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Harga Jual Satuan : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="hjs_satuan" class="form-control" name="hb_satuan" placeholder="Harga Jual Satuan ">
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">TGL STOK : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <input type="text" id="tgl_stok_history" value="<?php echo date('Y-m-d'); ?>" class="datepicker form-control" placeholder="Please choose a date...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                	
                </div>
            </div>
            <div class="modal-footer bg-blue">
                <button type="button" class="btn btn-link waves-effect" id="Tambah_stok_history"> Ya</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" id="close_update_stok">Tidak</button>
            </div>
        </div>
    </div>
</div>

<!-- For Material Design Colors -->
<div class="modal fade" id="form_history_stok_produk_dist" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <h4 class="modal-title" id="defaultModalLabel">History Stok Produk Distributor </h4>
            </div>
            <div class="modal-body">
                <div class="row">
					
					<table class="table table-striped table-bordered dataTable no-footer" id="Table_history_stok">
						<thead>
							<tr>
								<th>No</th>
								<th>Tgl Stok</th>
								<th>QTY Stok</th>
								<th>Satuan</th>
								<th>Harga Beli</th>
								<th>Harga Jual</th>
							</tr>
						</thead>
						<tbody id="isi_data_history_stok">
							<?php  
								//echo $Stok_distributor;
							 ?>
						</tbody>
					</table>
					
                </div>
            </div>
            <div class="modal-footer bg-green">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- For Material Design Colors -->
<div class="modal fade" id="modal_hapus_distributor" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h4 class="modal-title" id="defaultModalLabel">Form Hapus Data Distributor</h4>
            </div>
            <div class="modal-body">
                <div class="row">

                	<div class="col-md-12">
                		<h4>Apakah anda Ingin Menghapus Data Ini ?</h4>
                		<input type="hidden" name="h_id_distributor" id="h_id_distributor">
                        
                	</div>
                </div>
            </div>
            <div class="modal-footer bg-red">
                <button type="button" class="btn btn-link waves-effect" id="Hapus_Data_distributor"> Ya</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
	$('#Table_distributor').dataTable();
    $('#plannedDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	$('#tgl_stok_history').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	
});

$(document).on("change", "#jenis_produk", function(){
	jenis_produk = $("#jenis_produk").val();
	if(jenis_produk==2){
		$('#tmp_kd_sap').hide();
		
	}
	else {
		$('#tmp_kd_sap').show();
	}
	
});




$(document).on("click", "#Tampilkan_form_tambah_distributor", function(){
	$("#modal_distributor").modal('show');
});

$(document).on("click", "#Save_penambahan_distributor", function(){
	$("#isi_data_customer_distributor").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	
	$.ajax({
		url: '<?php echo site_url(); ?>distributor/Produk_distributor/Ajax_tambah_data_Produk_dist',
		type: 'POST',
		data: {
			"Id_jenis_produk"   	: $("#jenis_produk").val(),
			"nm_produk"				: $("#nm_produk").val(),
			"stok"					: $("#stok").val(),
			"satuan"				: $("#satuan").val(),
			"hb_satuan"				: $("#hb_satuan").val(),
			"hj_satuan"				: $("#hj_satuan").val(),
			"kd_produk_sap"			: $("#kd_produk_sap").val(),
			"tgl_stok"				: $("#plannedDate").val()
		},
		success: function(j){
			var dt = JSON.parse(j);

			$("#isi_data_hasil_survey").html(dt.html);
			$('#Table_distributor').dataTable();
			
			$("#modal_distributor").modal('hide');
			//showNotification('bg-blue', 'Data Berhasil Disimpan', 'top', 'right', 'animated lightSpeedIn', 'animated lightSpeedOut');
			if(dt.notify=='1'){
				$("#nm_produk").val("");
				$("#stok").val("");
				$("#satuan").val("");
				$("#hb_satuan").val("");
				$("#hj_satuan").val("");
				$("#kd_produk_sap").val("");				
			}
		},
		error: function(){
			//show_toaster(2,'','Data Gagal Diproses');
		}
    });
});


$(document).on("click", ".Tambah_stok_history", function(){
	
	$("#form_tambah_stok_produk_dist").modal("show");
	idpd = $(this).attr("idpd");
	
	$('#idpd').val(idpd);
	
	
});

$(document).on("click", "#Tambah_stok_history", function(){
	
	$.ajax({
		url: '<?php echo site_url(); ?>distributor/Produk_distributor/Ajax_tambah_stok_history',
		type: 'POST',
		data: {
			"id_pd"   				: $("#idpd").val(),
			"stok"					: $("#stok_history").val(),
			"satuan"				: $("#satuan_history").val(),
			"hb_satuan"				: $("#hbs_satuan").val(),
			"hj_satuan"				: $("#hjs_satuan").val(),
			"tgl_stok"				: $("#tgl_stok_history").val()
		},
		success: function(j){
			var dt = JSON.parse(j);

			$("#isi_data_hasil_survey").html(dt.html);
			$('#Table_distributor').dataTable();
			//showNotification('bg-blue', 'Data Berhasil Disimpan', 'top', 'right', 'animated lightSpeedIn', 'animated lightSpeedOut');
			if(dt.notify==1){
				$("#stok_history").val("");
				$("#satuan_history").val("");
				$("#hbs_satuan").val("");
				$("#hjs_satuan").val("");
				
			}
			$("#close_update_stok").click();
			
		},
		error: function(){
			//show_toaster(2,'','Data Gagal Diproses');
		}
    });
	
});

$(document).on("click", "#Tampilkan_history_distributor", function(){
	
	$("#form_history_stok_produk_dist").modal("show");
	
	idpd = $(this).attr("idpd");
	
	$.ajax({
		url: '<?php echo site_url(); ?>distributor/Produk_distributor/Ajax_tampil_stok_history',
		type: 'POST',
		data: {
			"id_pd"   				: idpd
		},
		success: function(j){
			var dt = JSON.parse(j);

			$("#isi_data_history_stok").html(dt.html);
			$('#Table_history_stok').dataTable();
			//showNotification('bg-blue', 'Data Berhasil Disimpan', 'top', 'right', 'animated lightSpeedIn', 'animated lightSpeedOut');

		},
		error: function(){
			//show_toaster(2,'','Data Gagal Diproses');
		}
    });
});















$(document).on("click", ".Tampilkan_delete", function(){
	$("#modal_hapus_distributor").modal('show');
	dist_id = $(this).attr("kd_distributor");

	$("#h_id_distributor").val(dist_id);

});
$(document).on("click", "#Hapus_Data_distributor", function(){
	id_distributor = $("#h_id_distributor").val();	

	$("#isi_data_customer_distributor").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	$.ajax({
		url: '<?php echo site_url(); ?>administrator/Master_distributor/Ajax_Hapus_data_distributor',
		type: 'POST',
		data: {
			"kd_distributor"   	: id_distributor
		},
		success: function(j){
			var dt = JSON.parse(j);

			$("#isi_data_customer_distributor").html(dt.html);
			$('#Table_distributor').dataTable();
			showNotification('bg-red', 'Data Berhasil Di Hapus', 'top', 'right', 'animated lightSpeedIn', 'animated lightSpeedOut');

		},
		error: function(){
			//show_toaster(2,'','Data Gagal Diproses');
		}
    });

});




 $(document).on("click", "#Cari_customer_by_distributor", function(){
	distributor = $("#distributor").val();
	$("#isi_data_customer_distributor").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	
	

	$.ajax({
		url: '<?php echo site_url(); ?>administrator/Customer_sync/Ajax_tampil_data_customer_toko',
		type: 'POST',
		data: {
			"distributor"   : distributor,
		},
		success: function(j){
			var dt = JSON.parse(j);

			$("#isi_data_customer_distributor").html(dt.html);
			$('#Table_customer').dataTable();
			showNotification('bg-blue', 'Data Berhasil Ditampilkan', 'top', 'right', 'animated lightSpeedIn', 'animated lightSpeedOut');

		},
		error: function(){
			//show_toaster(2,'','Data Gagal Diproses');
		}
    });
	
 });
 
$(document).on("click", "#SYNC_customer_distributor", function(){
	distributor = $("#distributor").val();
	$("#isi_data_customer_distributor").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	
	$.ajax({
		url: '<?php echo site_url(); ?>administrator/Customer_sync/Ajax_sync_customer_distributor',
		type: 'POST',
		data: {
			"distributor"   : distributor,
		},
		success: function(j){
			var dt = JSON.parse(j);

			$("#isi_data_customer_distributor").html(dt.html);
			$('#Table_customer').dataTable();
			showNotification('bg-green', 'Data Berhasil di Perbarui.', 'top', 'right', '', '');

		},
		error: function(){
			//show_toaster(2,'','Data Gagal Diproses');
		}
    });
});

$(document).on("click", "#Clear_customer_distributor", function(){
	distributor = $("#distributor").val();
	$("#isi_data_customer_distributor").html('<tr><td colspan="7"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
	
	$.ajax({
		url: '<?php echo site_url(); ?>administrator/Customer_sync/Ajax_Clear_customer_distributor',
		type: 'POST',
		data: {
			"distributor"   : distributor,
		},
		success: function(j){
			var dt = JSON.parse(j);

			$("#isi_data_customer_distributor").html(dt.html);
			$('#Table_customer').dataTable();
			showNotification('bg-red', 'Data Berhasil di hapus.', 'top', 'right', '', '');


		},
		error: function(){

		}
    });
});	

</script>
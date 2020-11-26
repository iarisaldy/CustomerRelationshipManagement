<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header header-title bg-green">
                        <h2> DAFTAR PRODUK DISTRIBUTOR :  <?php echo $distributor; ?></h2>
                    </div>
                    <?php
                        $dataMenu = $menus['dataMenu']; 
                        $subMenus = $menus['subMenu'];

                        foreach ($dataMenu as $menusKey => $menusValue) { 
                         if($menusValue->ID_MENU == '1009'){ 
                    ?>
                        <ul class="submenus">
                        <?php 
                            foreach ($subMenus as $subMenusKey => $subMenusValue) {
                                if($subMenusValue->ID_MENU == $menusValue->ID_MENU && $subMenusValue->ID_MENU == '1009'){
                        ?>
                            <li><a href="<?php echo base_url().$subMenusValue->LINK; ?>"><?php echo $subMenusValue->NAMA_MENU; ?></a></li>
                            <?php } } ?>
                        </ul>
                    <?php }
                    } ?>
                    <div class="body">
						
						<!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card-">
                       
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered dataTable no-footer" id="daftar_produk_dist">
                                    <thead>
                                        <tr>
                                            <th bgcolor="#ffb990">NO</th>
											<th bgcolor="#ffb990">Kode Produk</th>
                                            <th bgcolor="#ffb990">Nama Produk</th>
                                            <th bgcolor="#ffb990">Jenis Produk</th>
                                            <th bgcolor="#99baf7">QTY</th>
                                            <th bgcolor="#99baf7">Harga</th>
                                            <th bgcolor="#a3f799">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="isi_data_hasil_survey">
                                    	<?php  
                                    		echo $daftar_produk;
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
<div class="modal fade" id="form_Order_produk_dist" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" id="judul_produk_order">Form Order Produk </h4>
            </div>
            <div class="modal-body">
                <div class="row">
						<input type="hidden" name="id_pd" id="idpd">
						
						<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Qty Order : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="order_stok" class="form-control" name="order_stok" placeholder="Jumlah Order ">
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">TGL Order : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <input type="text" id="tgl_order" value="<?php echo date('Y-m-d'); ?>" class="datepicker form-control" placeholder="Please choose a date...">
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">TGL Request Delivery : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <input type="text" id="tgl_delivery" value="<?php echo date('Y-m-d'); ?>" class="datepicker form-control" placeholder="Please choose a date...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                	
                </div>
            </div>
            <div class="modal-footer bg-blue">
                <button type="button" class="btn btn-link waves-effect" id="Simpan_order_produk"> Ya</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" id="close_order">Tidak</button>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {
	$('#daftar_produk_dist').dataTable();
    // $('#plannedDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	$('#tgl_order').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	$('#tgl_delivery').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	
});

$(document).on("click", "#Tampilkan_form_tambah_distributor", function(){
	$("#modal_distributor").modal('show');
});



$(document).on("click", ".Tambah_Order_produk", function(){
	
	$("#form_Order_produk_dist").modal("show");
	nmpd = $(this).attr("nmpd");
	
	$("#idpd").val($(this).attr("idpd"));
	
	$("#judul_produk_order").html("FORM ORDER PRODUK "+ nmpd);
	
});

$(document).on("click", "#Simpan_order_produk", function(){
	
	$.ajax({
		url: '<?php echo site_url(); ?>distributor/Order_produk/Ajax_Simpan_order_produk',
		type: 'POST',
		data: {
			"Id_jenis_produk"   	: $("#idpd").val(),
			"stok"					: $("#order_stok").val(),
			"tgl_order"				: $("#tgl_order").val(),
			"tgl_request"			: $("#tgl_delivery").val()
		},
		success: function(j){
			var dt = JSON.parse(j);
			if(dt.notify==1){
                alert(dt.pesan);
                $("#order_stok").val("");
                $("#tgl_order").val("");      
            }
			$("#close_order").click();
			
		},
		error: function(){
			//show_toaster(2,'','Data Gagal Diproses');
		}
    });
	
});





</script>
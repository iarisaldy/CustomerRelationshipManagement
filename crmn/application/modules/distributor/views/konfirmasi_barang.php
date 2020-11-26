<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header header-title bg-blue">
                        <h2> Daftar Pengeriman Barang Order Toko </h2>
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
                                <table class="table table-striped table-bordered dataTable no-footer" id="Konfirmasi_order_customer">
                                    <thead>
                                        <tr>
                                            <th bgcolor="#ffb990">NO</th>
                                            <th bgcolor="#ffb990">Produk</th>
                                            <th bgcolor="#ffb990">Qty Order</th>
                                            <th bgcolor="#ffb990">Tgl Order</th>
                                            <th bgcolor="#ffb990">Qty Kirim</th>
                                            <th bgcolor="#ffb990">Tgl Kirim</th>
                                            <th bgcolor="#99baf7">QTY Terima</th>
                                            <th bgcolor="#99baf7">Harga</th>
											<th bgcolor="#a3f799">Status Order</th>
											<th bgcolor="#a3f799">Konfirm</th>
                                        </tr>
                                    </thead>
                                    <tbody id="isi_data_order_produk">
                                    	<?php  
                                    		echo $list_order;
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
<div class="modal fade" id="form_konfirmasi_order_toko" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" id="judul_produk_order">TOKO A => ORDER SEMEN BAG PCC</h4>
            </div>
            <div class="modal-body">
                <div class="row">
						<input type="hidden" name="id_pd" id="idpd">
						<input type="hidden" name="no_order" id="no_order">
						
						<div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Qty Konfirmasi: </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="qty_konfirmasi" class="form-control" name="qty_konfirmasi" placeholder="Jumlah Konfirmasi Penerimaan">
                                    </div>
                                </div>
                            </div>
                        </div>
                	
                </div>
            </div>
            <div class="modal-footer bg-blue">
                <button type="button" class="btn btn-link waves-effect" id="Simpan_Konfirmasi_order"> Ya</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" id="close">Tidak</button>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
	$('#Konfirmasi_order_customer').dataTable();
	$('#tgl_rencana_kirim').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	
});

$(document).on("click", ".Konfirmasi_order_toko", function(){
	$("#form_konfirmasi_order_toko").modal("show");

    $('#no_order').val($(this).attr("no_order"));
    $('#idpd').val($(this).attr("idpd"));

    toko    = $(this).attr("toko");
    produk  = $(this).attr("produk");

    $("#judul_produk_order").html("FORM KONFIRMASI PENERIMAAN BARANG "+ produk );

});

$(document).on("click", "#Simpan_Konfirmasi_order", function(){

    $.ajax({
        url: '<?php echo site_url(); ?>distributor/Order_produk/Ajax_Konfirmasi_barang',
        type: 'POST',
        data: {
            "no_order"          : $("#no_order").val(),
            "qty_konfirmasi"    : $("#qty_konfirmasi").val(),
        },
        success: function(j){
            var dt = JSON.parse(j);
            $("#isi_data_order_produk").html(dt.html);
            $('#Konfirmasi_order_customer').dataTable();
            alert(dt.pesan);
            if(dt.notify==1){
                $("#qty_konfirmasi").val("");
                $("#close").click();
            }

        },
        error: function(){
            //show_toaster(2,'','Data Gagal Diproses');
        }
    });

});

</script>
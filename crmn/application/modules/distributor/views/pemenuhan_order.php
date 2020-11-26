<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header header-title">
                        <h2> Laporan Status Pemenuhan Order Distributor </h2>
                    </div>
                    <?php
                        $dataMenu = $menus['dataMenu']; 
                        $subMenus = $menus['subMenu'];

                        foreach ($dataMenu as $menusKey => $menusValue) { 
                            // echo $menusValue->ID_MENU;
                         if($menusValue->ID_MENU == '1011'){ 
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
        
		<div class="body">
							
						<!-- Basic Examples -->
						<div class="row clearfix" id="cardDistributor">
							<div class="col-md-6">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
									<label for="email_address_2">Distributor Name : </label>
								</div>
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
										<select data-size="5" id="listDistributor" name="distributor" class="form-control show-tick" data-live-search="true">
											<option value="">Select your distributor</option>
											<?php echo $distributor; ?>
										</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
									<select data-size="5" id="tahun" name="tahun" class="form-control show-tick">
										<option value="">Tahun</option>
										<?php
											for($i=2017; $i<=(date('Y')); $i++){
												if($i==2018){
													echo '<option value="'.$i.'" selected>'.$i.'</option>';
												}
												else {
													echo '<option value="'.$i.'">'.$i.'</option>';
												}
											}
											
										?>
									</select>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
									<select data-size="5" id="bulan" name="bulan" class="form-control show-tick">
										<option value="">Bulan</option>
										<?php
											foreach($bulan as $b => $c){
												if($b==date('m')){
													echo '<option value="'.$b.'" selected>'.$c.'</option>';
												}
												else{
													echo '<option value="'.$b.'">'.$c.'</option>';
												}
											}
											// for($i=2017; $i<=(date('Y')); $i++){
												// echo '<option value="'.$i.'">'.$i.'</option>';
											// }
										?>
									</select>
									</div>
								</div>
							</div>
							<div class="col-md-1">
								<button class="btn btn-primary waves-light" id="Cari_Pemenuhan_order" ><span class="fa fa-search"></span> Cari</button>
							</div>
						</div>
						
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
											<th bgcolor="#ffb990">Jenis Produk</th>
                                            <th bgcolor="#ffb990">Stok Saat Ini</th>
                                            <th bgcolor="#ffb990">JML Permintaan BLN</th>
											<th bgcolor="#ffb990">JML Pemenuhan BLN</th>
											<th bgcolor="#ffb990">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody id="isi_data_pemenuhan_order">
                                    	<?php  
                                    		//echo $daftar_produk;
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
<div class="modal fade" id="Detile_toko_pemenuhan_order" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" id="judul_produk_order">List Daftar Customer </h4>
            </div>
            <div class="modal-body">
                <div class="row">
					<table class="table table-striped table-bordered dataTable no-footer" id="detile_customer">
						<thead>
							<tr>
								<th bgcolor="#ffb990">NO</th>
								<th bgcolor="#ffb990">Nama Customer</th>
								<th bgcolor="#ffb990">Produk</th>
								<th bgcolor="#ffb990">Qty Order</th>
								<th bgcolor="#ffb990">Qty Kirim</th>
								<th bgcolor="#ffb990">Qty Terima</th>
							</tr>
						</thead>
						<tbody id="Isi_data_detile_pemenuhan_order">
							<?php  
								//echo $daftar_produk;
							 ?>
						</tbody>
					</table>                	
                </div>
            </div>
            <div class="modal-footer bg-blue">
                <button type="button" class="btn btn-link waves-effect" id="Simpan_Konfirmasi_order"> Ya</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Tidak</button>
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

    $("#judul_produk_order").html("FORM KONFIRMASI TOKO "+ toko +" ORDER PRODUK "+ produk );

});

$(document).on("click", "#Simpan_Konfirmasi_order", function(){

    $.ajax({
        url: '<?php echo site_url(); ?>distributor/Produk_distributor/Ajax_Konfirmasi_Order_toko',
        type: 'POST',
        data: {
            "no_order"          : $("#no_order").val(),
            "idpd"              : $("#idpd").val(),
            "qty_konfirmasi"    : $("#qty_konfirmasi").val(),
            "tgl_rencana"       : $("#tgl_rencana_kirim").val()
        },
        success: function(j){
            var dt = JSON.parse(j);
            $("#isi_data_order_produk").html(dt.html);
            $('#Konfirmasi_order_customer').dataTable();
            alert(dt.pesan);
            if(dt.notify==1){
                $("#qty_konfirmasi").val("");
                $("#tgl_rencana_kirim").val("");
                $("#close").click();
            }

        },
        error: function(){
            //show_toaster(2,'','Data Gagal Diproses');
        }
    });

});

$(document).on("click", "#Cari_Pemenuhan_order", function(){
	
	$.ajax({
        url: '<?php echo site_url(); ?>distributor/Order_produk/Ajax_laporan_pemenuhan_order',
        type: 'POST',
        data: {
            "distributor"   : $("#listDistributor").val(),
            "tahun"         : $("#tahun").val(),
            "bulan"    		: $("#bulan").val()
        },
        success: function(j){
			
            var dt = JSON.parse(j);
            $("#isi_data_pemenuhan_order").html(dt.html);
            $('#Konfirmasi_order_customer').dataTable();
            alert(dt.pesan);

        },
        error: function(){
            //show_toaster(2,'','Data Gagal Diproses');
        }
    });
});
$(document).on("click", ".Detile_order_produk", function(){
	
	$('#Detile_toko_pemenuhan_order').modal('show');
	idpd = $(this).attr('idpd');
	
	$.ajax({
        url: '<?php echo site_url(); ?>distributor/Order_produk/Ajax_detile_order',
        type: 'POST',
        data: {
            "id_pd"   		: idpd
        },
        success: function(j){
			
            var dt = JSON.parse(j);
            $("#Isi_data_detile_pemenuhan_order").html(dt.html);
            $('#detile_customer').dataTable();
            alert(dt.pesan);

        },
        error: function(){
            //show_toaster(2,'','Data Gagal Diproses');
        }
    });
	$('#Isi_data_detile_pemenuhan_order').html();
	
});

</script>
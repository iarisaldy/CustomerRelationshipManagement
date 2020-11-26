<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header header-title bg-pink-">
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


<script>

$(document).ready(function() {
	$('#daftar_produk_dist').dataTable();
	
});

</script>
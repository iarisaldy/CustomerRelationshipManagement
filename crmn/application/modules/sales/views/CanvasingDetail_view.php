<style type="text/css">
#locationCanvasing {
	height: 350px;
	position: relative;
	overflow: hidden;
	width: 100%;
}
table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2> Detail Canvasing</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header bg-pink"><h2>Data Canvasing</h2></div>
                                        <div class="body">
                                        <a href="<?php echo base_url('administrator/Penugasan/Harian'); ?>" class="btn btn-xs btn-info"><i class="fa fa-arrow-left"></i> Back</a>
                                        <br/>&nbsp;<br/>
                                        <div class="row">

                                            <!-- panel pertama -->
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-light-blue hover-zoom-effect">
                                                    <div class="icon">
                                                        <i class="material-icons">perm_identity</i>
                                                    </div>
                                                    <div class="content">
                                                        <div class="text"><b>Surveyor</b></div>
                                                        <div class="number" style="font-size: 18px; margin-top: 12px;"><?php echo $canvassing->NAMA; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end panel pertama -->

                                            <!-- panel kedua -->
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-light-blue hover-zoom-effect">
                                                    <div class="icon">
                                                        <i class="material-icons">date_range</i>
                                                    </div>
                                                    <div class="content">
                                                        <div class="text"><b>Tanggal Kunjungan</b></div>
                                                        <div class="number" style="font-size: 20px; margin-top: 12px;"><?php echo $canvassing->CHECKIN_TIME; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end panel kedua -->

                                             <!-- panel pertama -->
                                             <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-light-blue hover-zoom-effect">
                                                    <div class="icon">
                                                        <i class="material-icons">query_builder</i>
                                                    </div>
                                                    <div class="content">
                                                        <div class="text"><b>Durasi Kunjungan</b></div>
                                                        <div class="number" style="font-size: 20px; margin-top: 12px;"><?php echo round($canvassing->SELISIH, 2); ?> Menit</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end panel pertama -->

                                            <!-- panel pertama -->
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-light-blue hover-zoom-effect">
                                                    <div class="icon">
                                                        <i class="material-icons">store</i>
                                                    </div>
                                                    <div class="content">
                                                        <div class="text"><b>Customer</b></div>
                                                        <div class="number" style="font-size: 18px;margin-top: 3px;"><?php echo $canvassing->NAMA_TOKO; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end panel pertama -->

                                            <!-- panel pertama -->
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-light-blue hover-zoom-effect">
                                                    <div class="icon">
                                                        <i class="material-icons">person_pin</i>
                                                    </div>
                                                    <div class="content">
                                                        <div class="text"><b>Nama Pemilik</b></div>
                                                        <div class="number" style="font-size: 18px;margin-top: 5px;"><?php echo $canvassing->NAMA_PEMILIK; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end panel pertama -->

                                            <!-- panel pertama -->
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box bg-light-blue hover-zoom-effect">
                                                    <div class="icon">
                                                        <i class="material-icons">place</i>
                                                    </div>
                                                    <div class="content">
                                                        <div class="text"><b>Alamat</b></div>
                                                        <div class="number" style="font-size: 14px;margin-top: 4px;"><?php echo $canvassing->ALAMAT; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end panel pertama -->

                                        </div>
                                            
                                            
                                            <div class="card">
                                                <div class="header bg-pink"><h2>Detail Survey</h2></div>
                                                <div class="body">
                                                    <div>
                                                        <table id="detailSurvey" class="table table-responsive table-striped table-bordered" width="100%" style="text-align: center;">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2" style="text-align: center;vertical-align: middle;">No</th>
                                                                    <th rowspan="2" style="text-align: center;vertical-align: middle;">Produk</th>
                                                                    <th colspan="3" style="text-align: center;">Harga</th>
                                                                    <th rowspan="2" style="text-align: center;vertical-align: middle;">Stok<sub>/zak</sub></th>
                                                                    <th colspan="2" style="text-align: center;">Volume<sub>/zak</sub></th>
                                                                    <th colspan="10" style="text-align: center;">Keluhan</th>
                                                                    <th colspan="6" style="text-align: center;">Program Promosi</th>
                                                                </tr>
                                                                <tr>
                                                                    <!-- quest harga -->
                                                                    <th>Jual</th>
                                                                    <th>Beli</th>
                                                                    <th>TOP<sub>/hari</sub></th>
                                                                    <!-- quest volume -->
                                                                    <th>Penjualan</th>
                                                                    <th>Pembelian</th>
                                                                    <!-- keluhan -->
                                                                    <th>Semen Membatu</th>
                                                                    <th>Semen Telambat Datang</th>
                                                                    <th>Kantong Tidak Kuat</th>
                                                                    <th>Harga Tidak Stabil</th>
                                                                    <th>Semen Rusak Saat Diterima</th>
                                                                    <th>TOP Kurang Lama</th>
                                                                    <th>Pemesanan Sulit</th>
                                                                    <th>Komplain Sulit</th>
                                                                    <th>Stok Sering Kosong</th>
                                                                    <th>Prosedur Pembayaran Rumit</th>
                                                                    <!-- Program promosi -->
                                                                    <th>Bonus Semen</th>
                                                                    <th>Wisata</th>
                                                                    <th>Point Reward</th>
                                                                    <th>Voucher</th>
                                                                    <th>Potongan Harga</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header bg-pink">
                                            <h2>Location</h2>
                                        </div>
                                        <div class="body">
                                            <div id="locationCanvasing"></div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="header bg-pink">
                                            <h2>Foto Survey</h2>
                                        </div>
                                        <div class="body">
                                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    <?php if(count($foto_survey) > 0){ $i=0; foreach ($foto_survey as $fotoKey => $fotoValue) { ?>
                                                        <div class="item <?php if($i==0){ echo "active";} ?>">
                                                            <img width="100%" src="<?php echo base_url().$fotoValue->FOTO_SURVEY; ?>" alt="Foto Survey">
                                                        </div>
                                                    <?php $i++; } } ?>
                                                </div>

                                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDLcPZk5_QNfhUDokPNILm_jnB7-B7yvoY"></script>
<script>
    $('#detailSurvey').dataTable();
    $('document').ready(function(){
        locationCanvasing();
        tableIsianSurvey(<?php echo $this->uri->segment('4'); ?>);
    });

    function locationCanvasing(){
        var latitude = <?php echo ($canvassing->CHECKIN_LATITUDE == "" ? 0 : $canvassing->CHECKIN_LATITUDE); ?>;
        var longitude = <?php echo ($canvassing->CHECKIN_LONGITUDE == "" ? 0 : $canvassing->CHECKIN_LONGITUDE); ?>;
        var myLatLng = {lat: latitude, lng: longitude};
        
        var options = {
            zoom: 15,
            center: myLatLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
		};
        
        map = new google.maps.Map(document.getElementById('locationCanvasing'), options);
        var marker = {
            position: myLatLng,
            map: map,
        }
            
        mapmarker = new google.maps.Marker(marker);
		mapmarker.setAnimation(google.maps.Animation.BOUNCE);
    }

    function tableIsianSurvey(idKunjungan = null){
        $("#detailSurvey").dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('sales/RoutingCanvasing/isianSurveyKunjungan'); ?>/"+idKunjungan,
                type: "GET"
            },
        });
    }
        
</script>
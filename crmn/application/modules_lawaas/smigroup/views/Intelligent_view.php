<style>
    .konten{
        position: relative;
        width: 110%;
        right: 5%;
        padding-top: 0%;
    }
    .info-window{
        width: 100%;
        min-width:300px;
        max-width:500px;
        float: left;
        overflow: hidden;
        background:#ecf0f1;
        padding-bottom:5px;
    }
    .judul{
        /*float: left;*/
        width: 100%;
        padding:2px 1%;
        background: -webkit-linear-gradient(#16a085, #1abc9c);
        background: -o-linear-gradient(#16a085, #1abc9c);
        background: -moz-linear-gradient(#16a085, #1abc9c);
        background: linear-gradient(#16a085, #1abc9c);
        color:#FFF;
        margin-bottom:3px;
    }
    .judul_data{
        padding-left: 3%;
        font-size: 13px;
        font-weight: 500;
    }
    .isi_data{
        padding-right: 5%;
        float: right;
        font-size: 13px;
        font-weight: 500;
    }
    .modal-dialog{
        /*width: 100%;*/
    }
    #wrap_progress{
        width:94%;
        overflow:hidden;
        float:left;
        background:#FFF;
        box-shadow: 0px 1px 6px #7f8c8d;
        margin-top:-50px;
        margin-left:0px;
        z-index:80;
        position:absolute;
    }

    #wrap_progress:before{
        content: "";
        display: block;
        padding-bottom: 1%;
    }
    #progress_judul, .kpi_progress_judul{
        overflow:hidden;
        float:left;
        width:93%;
        margin:0px 3.5% 0 3.5%;
        text-align:center;
        font-family: "Segoe UI","Segoe",Tahoma,Helvetica,Arial,sans-serif !important;
        font-size: 15px;
        font-size: 1vw;
        font-weight:600;
        color:#16a085;
    }

    #progress_judul{
        letter-spacing:-0.5px;
        border-bottom:2px solid #16a085;
        padding:0px 0px;
        margin:0px 3.5%;
        margin-top: -0.5%;
    }
    #legend_stok td {
        height:26px;
        padding:0px 0px 0px 20px !important;
        text-align:left;
        font-size: 1vw;
        border-bottom:1px solid #d0d0d0;
        vertical-align:middle;
        color:#555555;
        background-color:#ffffff;
    }
    .box-legend{
        width:30px;
        height:15px;
        border: 0px solid;
        background-color: #49ff56;
        float:left;
    }
    .font-merah{
        color: #ff4545;
    }
</style>
<div class="konten">
    <div class="panel">
        <div class="panel-body pn" >
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <i class="fa fa-globe"></i> Fasilitas Perusahaan
                    </div>
                    <div class="col-md-6"  style="margin-top: -1%;">
                        <div class="col-md-6">
                            <div class="input-group" id="perusahaan">
                                <span class="input-group-addon gray-bg">Perusahaan</span>
                                <input class="input-sm form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group" id="fasilitas">
                                <span class="input-group-addon gray-bg">Fasilitas</span>
                                <input class="input-sm form-control">
                            </div>
                        </div>  
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            <div class="row">
                <div id="map_luar" style="width:100%;margin:auto;">
                    <div id="gudang_canvas" class="map" style="height: 530px;"></div>
                    <!--                    <div id="wrap_progress">  
                                            <div class="col-md-12">
                                                <div class="col-xs-12">
                                                    <span id="progress_judul">KETERANGAN</span>                    
                                                    <table id="legend_stok">
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td style="text-align: center;"><img src="<?php //echo base_url();      ?>assets/img/map_icons/putih_new.png" width="90%"></img></td>
                                                            <td>: Packing Plant</td>
                                                            <td style="text-align: center;"><img src="<?php //echo base_url();      ?>assets/img/map_icons/map-marker-white.png" width="90%"></img></td>
                                                            <td>: Pabrik</td>
                                                            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                                                            <td style="text-align: center;"><span class="box-legend" style="background-color: #ff4545;"></span></td>
                                                            <td>: Stok Level < 30%</td>
                                                            <td style="text-align: center;"><span class="box-legend" style="background-color: #fff637;"></span></td>
                                                            <td>: Stok Level 30% - 60%</td>
                                                            <td style="text-align: center;"><span class="box-legend"></span></td>
                                                            <td>: Stok Level 60% - 100%</td>
                                                                                    <td style="text-align: center;"><img src="<?php // echo base_url();      ?>assets/img/map_icons/hitam.png" width="90%"></img></td>
                                                            <td>: Last Update > 5 hari</td>
                                                            
                                                        </tr>
                                                    </table>                    
                                                </div>
                                            </div>                    
                                        </div>-->
                </div></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-list">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><span id="modal-title-list"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row" id="wadahPerusahaan">
                    <?php echo $listperusahaan; ?>
                </div>
                <div class="row" id="wadahFasilitas">
                    <?php echo $listfasilitas; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="modal-chart">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><span id="modal-title"></span></h4>
            </div>
            <div class="modal-body">
                <div id="pleasewait">Please Wait . . .</div>
                <div class="row" id="grafik">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <label>Bulan</label>
                                <select id="bulan" class="form-control" name="bulan">
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Tahun</label>
                                <select id="tahun" class="form-control" name="tahun">
                                    <?php
                                    for ($i = 2015; $i <= Date('Y'); $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>    
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button id="filter" class="btn btn-success" style="margin-top:23px"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <canvas id="Chart1" width="100%" height="70%"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="Chart2" width="100%" height="70%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="<?= base_url('assets/chartjs/dist/Chart.js') ?>" type="text/javascript"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBBZXrepkX3AgeIBs1IwWfhu2aMg-5G0_A "></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.fixedHeader.min.js"></script>
<script>
    function formatNumb(n) {
        var rx = /(\d+)(\d{3})/;
        return String(n).replace(/^\d+/, function (w) {
            while (rx.test(w)) {
                w = w.replace(rx, '$1.$2');
            }
            return w;
        });
    }
    var Chart1;
    var Chart2;
    var ctx1 = document.getElementById("Chart1");
    var ctx2 = document.getElementById("Chart2");
    var map;
    var ctaLayer;
    var org;
    var plant;
    var idList;
    var month = new Array(12);
    month[1] = "01";
    month[2] = "02";
    month[3] = "03";
    month[4] = "04";
    month[5] = "05";
    month[6] = "06";
    month[7] = "07";
    month[8] = "08";
    month[9] = "09";
    month[10] = "10";
    month[11] = "11";
    month[12] = "12";
    var d = new Date();
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -7.11234440, lng: 112.41742430},
            zoom: 11
        });
    }

    $(function () {
        var kodeperusahaan = [];
        var kodefasilitas = [];
        var n = 0;
        $("#fListPerusahaan input:checkbox:checked").each(function () {
            kodeperusahaan[n] = this.value;
            n++;
        });
        var m = 0;
        $("#fListFasilitas input:checkbox:checked").each(function () {
            kodefasilitas[m] = this.value;
            m++;
        });
        var url = base_url + 'smigroup/Intelligent/getData';
        var options = {
            zoom: 5, //level zoom
            //posisi tengah peta
            center: new google.maps.LatLng(-3.300923, 117.645717),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map;
        var markers = [];
        $.ajax({
            url: url,
            dataType: 'json',
            success: function (data) {
                var marker;
                map = new google.maps.Map(document.getElementById('gudang_canvas'), options);
                var infowindow = new google.maps.InfoWindow();
                function show(perusahaan, fasilitas) {
                    for (var i = 0; i < data.length; i++) {
                        console.log(perusahaan + " " + fasilitas);
                        if (data[i]['KODE_PERUSAHAAN'] == perusahaan && data[i]['KODE_FASILITAS'] == fasilitas) {
                            markers[i].setVisible(true);
                        }
                    }
                }
                function hide() {
                    for (var i = 0; i < data.length; i++) {
                        markers[i].setVisible(false);
                    }
                }
                $('#modal-list').on('hidden.bs.modal', function () {
                    var n = 0;
                    hide();
                    if (idList == "#fListPerusahaan") {
                        kodeperusahaan = [];
                    } else {
                        kodefasilitas = [];
                    }
                    $(idList + " input:checkbox:checked").each(function () {
                        //console.log(this.value); // do your staff with each checkbox
                        if (idList == "#fListPerusahaan") {
                            kodeperusahaan[n] = this.value;
                        } else {
                            kodefasilitas[n] = this.value;
                        }
                        n++;
                    });
                    $.each(kodeperusahaan, function (key, valper) {
                        $.each(kodefasilitas, function (k, valfas) {
                            show(valper, valfas);
                        });
                    });
                });
                $.each(data, function (key, val) {
                    var latitude = val.LATITUDE.replace(',', '.');
                    var longitude = val.LONGITUDE.replace(',', '.');

                    var icons;

                    if (val.KODE_FASILITAS == 1) {
                        icons = base_url + 'assets/img/map_icons/marker/factory.png';
                    } else if (val.KODE_FASILITAS == 2) {
                        icons = base_url + 'assets/img/map_icons/marker/foodcan.png';
                    } else if (val.KODE_FASILITAS == 3) {
                        icons = base_url + 'assets/img/map_icons/marker/museum_industry.png';
                    } else if (val.KODE_FASILITAS == 4) {
                        icons = base_url + 'assets/img/map_icons/marker/bunker-2-2.png';
                    } else if (val.KODE_FASILITAS == 5) {
                        icons = base_url + 'assets/img/map_icons/marker/database.png';
                    } else if (val.KODE_FASILITAS == 6) {
                        icons = base_url + 'assets/img/map_icons/marker/observatory.png';
                    } else if (val.KODE_FASILITAS == 7) {
                        icons = base_url + 'assets/img/map_icons/marker/coldstorage.png';
                    } else if (val.KODE_FASILITAS == 8) {
                        icons = base_url + 'assets/img/map_icons/marker/powersubstation.png';
                    } else if (val.KODE_FASILITAS == 9) {
                        icons = base_url + 'assets/img/map_icons/marker/bunker.png';
                    }

                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(latitude, longitude),
                        map: map,
                        icon: icons
                    });

                    markers.push(marker);

                    google.maps.event.addListener(marker, 'click', (function (marker, key) {
                        return function () {
                            var info = '<table class="info-window">' +
                                    '<thead><tr><th class="judul" colspan="2">' + val.NAMA_PERUSAHAAN + ' | '+val.FASILITAS+' | '+val.NAMA_FASILITAS+'</th></tr></thead>' +
                                    '<tbody><tr><td>';
                            $.each(val.FOTO, function(keyF,valF){
                                info += '<img width="100%" src="'+valF+'">';
                            });
                            info += '</td></tr><tr><td class="judul_data">'+val.NAMA_FASILITAS+'</td></tr>' +
                                    '</tbody></table>';


                            infowindow.setContent(info);
                            infowindow.open(map, marker);
                        };
                    })(marker, key));
                });
            }
        });
        // Buat peta di 


        $("#perusahaan").click(function () {
            $('#wadahPerusahaan').show();
            $('#wadahFasilitas').hide();
            $('#modal-list').modal('show');
            idList = "#fListPerusahaan";
        });
        $("#fasilitas").click(function () {
            $('#wadahPerusahaan').hide();
            $('#wadahFasilitas').show();
            $('#modal-list').modal('show');
            idList = "#fListFasilitas";
        });

    });
</script>

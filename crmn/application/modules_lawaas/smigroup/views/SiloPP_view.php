<style>
    .konten{
        position: relative;
        width: 110%;
        right: 5%;
        padding-top: 0%;
    }
    .info-window{
        width: 100%;
        min-width:250px;
        max-width:250px;
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
        width: 100%;
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

    .legend{
        float:left;
        display:inline;
    }
    .box-legend{
        width:30px;
        height:15px;
        border: 0px solid;
        background-color: #49ff56;
        float:left;
    }
</style>
<div class="konten">
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="col-md-4">
                    <i class="fa fa-globe"></i> Stock Silo PP   
                </div>
                <div class="col-md-8">
                    <div class="col-md-3">
                        <label class="checkbox-inline">
                            <input id="checkbox" class="cb1" type="checkbox" value="7000">
                            Semen Gresik
                        </label> 
                    </div>
                    <div class="col-md-3">
                        <label class="checkbox-inline">
                            <input id="checkbox" class="cb2" type="checkbox" value="3000">
                            Semen Padang
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="checkbox-inline">
                            <input id="checkbox" class="cb3" type="checkbox" value="4000">
                            Semen Tonasa
                        </label>
                    </div> 
                    <div class="col-md-3">
                        <label class="checkbox-inline">
                            <input id="checkbox" class="cb4" type="checkbox" value="6000">
                            Thang Long Cement
                        </label>
                    </div>                                                                              
                </div>
            </div>
        </div>  
        <div class="panel-body pn" >
            <div id="map_luar" style="width:100%;margin:auto;">
                <div id="gudang_canvas" class="map" style="height: 550px;"></div>
                <div id="wrap_progress">  
                    <div class="col-md-12">
                        <div class="col-xs-1">
                            <button id="btn-list" class="btn btn-info"><i class="fa fa-list"></i> Silo PP</button> 
                        </div>
                        <div class="col-xs-11">
                            <span id="progress_judul">KETERANGAN</span>                    
                            <table id="legend_stok">
                                <tr>
                                    <td>&nbsp;</td>
                                    <td style="text-align: center;"><img src="<?php echo base_url(); ?>assets/img/map_icons/putih_new.png" width="90%"></img></td>
                                    <td>: Packing Plant</td>
                                    <td style="text-align: center;"><img src="<?php echo base_url(); ?>assets/img/map_icons/map-marker-white.png" width="90%"></img></td>
                                    <td>: Pabrik</td>
                                    <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                                    <td style="text-align: center;"><span class="box-legend" style="background-color: #ff4545;"></span></td>
                                    <td>: Stok Level < 30%</td>
                                    <td style="text-align: center;"><span class="box-legend" style="background-color: #fff637;"></span></td>
                                    <td>: Stok Level 30% - 70%</td>
                                    <td style="text-align: center;"><span class="box-legend"></span></td>
                                    <td>: Stok Level 70% - 100%</td>
                                    <td style="text-align: center;"><img src="<?php echo base_url(); ?>assets/img/map_icons/hitam_big.png" width="90%"></img></td>
                                    <td>: Last Update > 1 hari</td>
                                    <!--                        <td style="text-align: center;"><img src="<?php echo base_url(); ?>assets/img/map_icons/hitam.png" width="90%"></img></td>
                                    <td>: Last Update > 5 hari</td>
                                    -->
                                </tr>
                            </table>                    
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-list">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><span id="modal-title-list"></span></h4>
            </div>
            <div class="modal-body">
                <div class="pleasewait">Please Wait . . .</div>
                <div class="row" class="grafik">
                    <!--                    <div class="row">
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
                                        </div>-->
                    <div class="row">
                        <div class="col-md-12">
                            <div id="table-list"></div>
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
                                <div style="margin-left: 20%;" id="legendDiv"></div>
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
    function setChart() {
        var lineChartData = {
            labels: ['TANGGAL'],
            datasets: [{
                    label: "RKAP",
                    data: [0],
                    fill: false,
                    lineTension: 0,
                    borderColor: '#98210f',
                    backgroundColor: '#98210f'
                }, {
                    label: "REALISASI",
                    data: [0],
                    fill: false,
                    lineTension: 0,
                    borderColor: 'green',
                    backgroundColor: 'green'
                }]
        };
        var lineChartData2 = {
            labels: ['TANGGAL'],
            datasets: [{
                    label: "RKAP",
                    data: [0],
                    fill: false,
                    lineTension: 0,
                    borderColor: '#98210f',
                    backgroundColor: '#98210f'
                }, {
                    label: "REALISASI BULK",
                    data: [0],
                    fill: false,
                    lineTension: 0,
                    borderColor: 'green',
                    backgroundColor: 'green'
                }, {
                    label: "REALISASI BAG",
                    data: [0],
                    fill: false,
                    lineTension: 0,
                    borderColor: 'green',
                    backgroundColor: 'green'
                }, {
                    label: "REALISASI",
                    data: [0],
                    fill: false,
                    lineTension: 0,
                    borderColor: 'green',
                    backgroundColor: 'green'
                }]
        };

        Chart1 = new Chart(ctx1, {
            type: 'line',
            data: lineChartData,
            options: {
                title: {
                    display: true,
                    text: "Grafik Target Dan Realisasi"
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                }
            }
        });

        Chart2 = new Chart(ctx2, {
            type: 'line',
            data: lineChartData2,
            options: {
                title: {
                    display: true,
                    text: "Grafik Target Dan Realisasi"
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                }
            }
        });
    }
    function chart(org1, plant1, tahun, bulan) {
        org = org1;
        plant = plant1;
        var url = base_url + 'smigroup/SiloPP/getDataChart/' + org1 + '/' + plant1 + '/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            dataType: 'json',
            beforeSend: function () {
                $("#modal-chart").modal('show');
                $("#pleasewait").show();
                $("#grafik").hide();
            },
            success: function (datas) {
                $('#pleasewait').hide();
                $("#grafik").show();
                $("#modal-title").html(datas['plan']['NAMA_PLANT']);
                Chart1.destroy();
                Chart2.destroy();
                var lineChartData = {
                    labels: datas['tanggal'],
                    datasets: [{
                            type: "line",
                            label: "KAPASITAS",
                            data: datas['kapasitas'],
                            fill: false,
                            lineTension: 0,
                            borderColor: '#F64747',
                            backgroundColor: '#F64747'
                        }, {
                            label: "STOCK",
                            data: datas['stock'],
                            fillColor: 'green',
                            borderWidth: 1.5,
                            borderColor: datas['warna'],
                            backgroundColor: datas['warna']
                        }]
                };
                var lineChartData2 = {
                    labels: datas['tanggal'],
                    datasets: [
                        {
                            label: "RILIS BULK",
                            data: datas['rilisbulk'],
                            fillColor: 'green',
                            borderWidth: 1.5,
                            borderColor: '#bb4b3a',
                            backgroundColor: '#bb4b3a'
                        },
                        {
                            label: "RILIS BAG",
                            data: datas['rilisbag'],
                            fillColor: 'green',
                            borderWidth: 1.5,
                            borderColor: 'rgba(255, 115, 115, 0.89)',
                            backgroundColor: 'rgba(255, 115, 115, 0.89)'
                        },

                        {
                            label: "RILIS",
                            data: datas['rilis'],
                            fillColor: 'green',
                            borderWidth: 1.5,
                            borderColor: '#ffc3a0',
                            backgroundColor: '#ffc3a0'
                        }
                    ]
                };

                Chart1 = new Chart.Bar(ctx1, {
                    data: lineChartData,
                    options: {
                        title: {
                            display: true,
                            text: "STOK SEMEN"
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + formatNumb(tooltipItem.yLabel) + ' TON';
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    stacked: true,
                                    ticks: {
                                        fontSize: 11
                                    }
                                }],
                            yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Ton'
                                    },
                                    ticks: {
                                        suggestedMin: 0,
                                        callback: function (value, index, values) {
                                            return formatNumb(value);
                                        }
                                    }
                                }]
                        },
                        legend: {
                            display: false
                        }
                    }
                });
                Chart2 = new Chart.Bar(ctx2, {
                    data: lineChartData2,
                    options: {
                        title: {
                            display: true,
                            text: "DATA RILIS"
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + formatNumb(tooltipItem.yLabel) + ' TON';
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    stacked: true,
                                    ticks: {
                                        fontSize: 11
                                    }
                                }],
                            yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Ton'
                                    },
                                    ticks: {
                                        suggestedMin: 0,
                                        callback: function (value, index, values) {
                                            return formatNumb(value);
                                        }
                                    }
                                }]
                        },
                        legend: {
                            display: false
                        }
                    }
                });
            }
        });

        var text = "<div class='legend'><div class='box-legend' style='background-color:rgba(255, 115, 115, 0.89);'> </div>&nbsp;Rilis Bag&nbsp;&nbsp;&nbsp;</div>" +
                "<div class='legend'><div class='box-legend' style='background-color:#bb4b3a'> </div>&nbsp;Rilis Bulk&nbsp;&nbsp;&nbsp;</div>" +
                "<div class='legend'><div class='box-legend' style='background-color:#ffc3a0'> </div>&nbsp;Rilis Total&nbsp;&nbsp;&nbsp;</div>";
        $('#legendDiv').html(text);

    }
    function tampilChart(org, plant) {
        $('#bulan').val(month[d.getUTCMonth() + 1]);
        $('#tahun').val(d.getUTCFullYear());
        var tahun = $('#tahun').val();
        var bulan = $('#bulan').val();
        chart(org, plant, tahun, bulan);
    }
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -7.11234440, lng: 112.41742430},
            zoom: 12
        });
    }

    $(function () {
        $('.cb1').prop('checked', true);
        $('.cb2').prop('checked', true);
        $('.cb3').prop('checked', true);
        $('.cb4').prop('checked', true);
        $('#bulan').val(month[d.getUTCMonth() + 1]);
        $('#tahun').val(d.getUTCFullYear());
        setChart();
        var options = {
            zoom: 5, //level zoom
            //posisi tengah peta
            center: new google.maps.LatLng(0.0549351, 117.7126278),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        // Buat peta di 

        var url = base_url + 'smigroup/SiloPP/getDataPlant';
        var markers = new Array();
        var kondisiAwal = new Array();
        $.ajax({
            url: url,
            dataType: 'json',
            success: function (data) {
                var marker;
                var map = new google.maps.Map(document.getElementById('gudang_canvas'), options);
                var infowindow = new google.maps.InfoWindow();
                function show(category) {
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['ORG'] == category) {
                            markers[i].setVisible(true);
                        }
                    }
                }
                function hide(category) {
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['ORG'] == category) {
                            markers[i].setVisible(false);
                        }
                    }
                }
                function updatePosition(kode, aksi) {
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['KODE_PLANT'] == kode) {
                            if (aksi === 'kurang') {
                                var lat = (markers[i].getPosition().lat()) - 0.2;
                            } else {
                                var lat = (markers[i].getPosition().lat()) + 0.2;
                            }
                            var lng = markers[i].getPosition().lng();
                            var newLatLng = new google.maps.LatLng(lat, lng);
                            //console.log(lat);
                            //console.log(lng);
                            //console.log(newLatLng);
                            markers[i].setPosition(newLatLng);
                        }
                    }
                }
                function posisiAwal() {
                    for (var i = 0; i < data.length; i++) {
                        for (var j = 0; j < kondisiAwal.length; j++) {
                            if (data[i]['KODE_PLANT'] == kondisiAwal[j]['KODE_PLANT']) {
                                var lat = kondisiAwal[j]['LATITUDE'].replace(',', '.');
                                ;
                                var lng = kondisiAwal[j]['LONGITUDE'].replace(',', '.');
                                ;
                                var newLatLng = new google.maps.LatLng(lat, lng);
                                //console.log(lat);
                                //console.log(lng);
                                //console.log(newLatLng);
                                markers[i].setPosition(newLatLng);
                            }
                        }
                    }
                }
                $(".cb1").click(function () {
                    var cat = $(this).attr("value");
                    // If checked
                    if ($(this).is(":checked")) {
                        show(cat);
                    } else {
                        hide(cat);
                    }
                });
                $(".cb2").click(function () {
                    var cat = $(this).attr("value");
                    // If checked
                    if ($(this).is(":checked")) {
                        show(cat);
                    } else {
                        hide(cat);
                    }
                });
                $(".cb3").click(function () {
                    var cat = $(this).attr("value");
                    // If checked
                    if ($(this).is(":checked")) {
                        show(cat);
                    } else {
                        hide(cat);
                    }
                });
                $(".cb4").click(function () {
                    var cat = $(this).attr("value");
                    // If checked
                    if ($(this).is(":checked")) {
                        show(cat);
                    } else {
                        hide(cat);
                    }
                });
                $.each(data, function (key, val) {

                    var latitude = val.LATITUDE.replace(',', '.');
                    if (val.KODE_PLANT == '2404' || val.KODE_PLANT == '3405' || val.KODE_PLANT == '3402' || val.KODE_PLANT == '4402' || val.KODE_PLANT == '4403') {
                        //console.log(latitude);
                        kondisiAwal.push(val);
                        latitude = parseFloat(latitude) - 1;
                        //console.log(latitude);
                    }
                    var longitude = val.LONGITUDE.replace(',', '.');
                    var stok = Math.round((val.SILO['TOTAL'] / val.KAPASITAS) * 100);
                    //console.log(stok);
                    var icons;
                    if (val.TYPE == 1) {
                        if (stok < 30) {
                            icons = base_url + 'assets/img/map_icons/merah_new.png';
                        } else if (stok >= 30 && stok < 70) {
                            icons = base_url + 'assets/img/map_icons/kuning_new.png';
                        } else if (stok >= 70) {
                            icons = base_url + 'assets/img/map_icons/hijau_new.png';
                        }
                    } else if (val.TYPE == 2) {
                        if (stok < 30) {
                            icons = base_url + 'assets/img/map_icons/map-marker-red.png';
                        } else if (stok >= 30 && stok < 70) {
                            icons = base_url + 'assets/img/map_icons/map-marker-yellow.png';
                        } else if (stok >= 70) {
                            icons = base_url + 'assets/img/map_icons/map-marker-green.png';
                        }
                    }

                    var th = val.JAM_CREATE.substring(0, 4);
                    var bl = val.JAM_CREATE.substring(5, 7);
                    var hr = val.JAM_CREATE.substring(8, 10);

                    var last_update = new Date(th + '/' + bl + '/' + hr);
                    var current_date = new Date();
                    var one_day = 1000 * 60 * 60 * 24;
                    var difference_ms = current_date.getTime() - last_update.getTime();

                    var different_day = (difference_ms / one_day);

                    var Diff = (current_date.getDay() - 1 == 0) ? 2.5 : 1.5;
                    if ((current_date.getHours() >= '12' && different_day >= Diff) || different_day >= Diff) {
                        if (val.TYPE == 1) {
                            icons = base_url + 'assets/img/map_icons/hitam_big.png';
                        } else if (val.TYPE == 2) {
                            icons = base_url + 'assets/img/map_icons/hitam.png';
                        }


                    }
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(latitude, longitude),
                        map: map,
                        icon: icons
                    });

                    markers.push(marker);

//                    if (val.TYPE == 1) {
                        marker.addListener('click', function () {
                            var tahun = $('#tahun').val();
                            var bulan = $('#bulan').val();
                            org = val.ORG;
                            plant = val.KODE_PLANT;
                            chart(val.ORG, val.KODE_PLANT, tahun, bulan);
                        });
//                    }

                    google.maps.event.addListener(marker, 'mouseover', (function (marker, key) {
                        return function () {
                            var info = '';
                            if (val.TYPE == 1 || val.KODE_PLANT == '6402') {
                                info = '<table class="info-window">' +
                                        '<thead><tr><th class="judul" colspan="2">' + val.KODE_PLANT + ' - ' + val.NAMA_PLANT + '<br/>' + val.JAM_CREATE + '</th></tr></thead>' +
                                        '<tbody>' +
                                        '<tr><td class="judul_data">SILO OPC</td><td class="isi_data">' + formatNumb(val.SILO['OPC']) + ' ton</td></tr>' +
                                        '<tr><td class="judul_data">SILO PPC</td><td class="isi_data">' + formatNumb(val.SILO['PPC']) + ' ton</td></tr>' +
                                        '<tr style="border-bottom: 1px solid black;"><td class="judul_data">SILO PCC</td><td class="isi_data">' + formatNumb(val.SILO['PCC']) + ' ton</td></tr>' +
                                        '<tr><td class="judul_data">TOTAL</td><td class="isi_data">' + formatNumb(val.SILO['TOTAL']) + ' ton</td></tr>' +
                                        '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>' +
                                        '<tr><td class="judul_data">KAPASITAS</td><td class="isi_data">' + formatNumb(val.KAPASITAS) + ' ton</td></tr>' +
                                        '<tr><td class="judul_data">STOK</td><td class="isi_data">' + stok + '%</td></tr>' +
                                        '<tr><td class="judul_data">REAL HARI INI</td><td class="isi_data">' + formatNumb(Math.round((val.REALISASI['OPC'] + val.REALISASI['PPC'] + val.REALISASI['PCC']))) + ' ton</td></tr>' +
                                        //'<tr><td class="judul_data">REAL HARI INI</td><td class="isi_data"> ton</td></tr>' +
                                        '<tr><td class="judul_data">REAL HARI KEMARIN</td><td class="isi_data">' + formatNumb(Math.round(val.REAL_KEMARIN)) + ' ton</td></tr>' +
                                        //'<tr><td class="judul_data">REAL HARI KEMARIN</td><td class="isi_data"> ton</td></tr>' +
                                        '<tr><td class="judul_data">AVERAGE REAL</td><td class="isi_data">' + formatNumb(Math.round(val.AVERAGE)) + ' ton</td></tr>' +
                                        //'<tr><td class="judul_data">AVERAGE REAL</td><td class="isi_data"> ton</td></tr>' +
                                        //'<tr><td class="judul_data">GIT</td><td class="isi_data"> ton</td></tr>' +
                                        //'<tr><td class="judul_data">ETA</td><td class="isi_data"></td></tr>' +
                                        '<tr><td class="judul_data">GIT</td><td class="isi_data">' + formatNumb(val.GIT) + ' ton</td></tr>' +
                                        '<tr><td class="judul_data">ETA</td><td class="isi_data">' + val.ETA + '</td></tr>' +
                                        '</tbody></table>';
                            } else if (val.TYPE == 2) {
                                info = '<table class="info-window">' +
                                        '<thead><tr><th class="judul" colspan="2">' + val.NAMA_PLANT + '<br/>' + val.JAM_CREATE + '</th></tr></thead>' +
                                        '<tbody>' +
                                        '<tr><td class="judul_data">SILO OPC</td><td class="isi_data">' + formatNumb(val.SILO['OPC']) + ' ton</td></tr>' +
                                        '<tr><td class="judul_data">SILO PPC</td><td class="isi_data">' + formatNumb(val.SILO['PPC']) + ' ton</td></tr>' +
                                        '<tr style="border-bottom: 1px solid black;"><td class="judul_data">SILO PCC</td><td class="isi_data">' + formatNumb(val.SILO['PCC']) + ' ton</td></tr>' +
                                        '<tr><td class="judul_data">TOTAL</td><td class="isi_data">' + formatNumb(val.SILO['TOTAL']) + ' ton</td></tr>' +
                                        '<tr><td class="judul_data">KAPASITAS</td><td class="isi_data">' + formatNumb(val.KAPASITAS) + ' ton</td></tr>' +
                                        '<tr><td class="judul_data">STOK</td><td class="isi_data">' + Math.round((val.SILO['TOTAL'] / val.KAPASITAS) * 100) + '%</td></tr>' +
                                        '</tbody></table>';
                            }

                            infowindow.setContent(info);
                            infowindow.open(map, marker);
                        };
                    })(marker, key));
                    google.maps.event.addListener(marker, 'mouseout', function () {
                        infowindow.close();
                    });
                });
                var tempZoom = 4;
                google.maps.event.addListener(map, 'zoom_changed', function () {
                    var nZoom = map.getZoom();
                    if (tempZoom > nZoom) {
                        //dikurangi
                        var aksi = 'kurang';
                    } else if (tempZoom < nZoom) {
                        //ditambah
                        var aksi = 'tambah';
                    }
                    tempZoom = nZoom;
                    if (nZoom >= 4 && nZoom <= 9) {
                        updatePosition('2404', aksi);
                        updatePosition('3405', aksi);
                        updatePosition('3402', aksi);
                        updatePosition('4402', aksi);
                        updatePosition('4403', aksi);
                    } else {
                        posisiAwal();
                    }
                    //console.log(nZoom);
                });
                //console.log(markers[0].getPosition());
            }
        });

        $('#filter').click(function () {
            var tahun = $('#tahun').val();
            var bulan = $('#bulan').val();
            chart(org, plant, tahun, bulan);
        });

        function createTable() {
            var url = base_url + 'smigroup/SiloPP/getDataTable';
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                beforeSend: function () {
                    $("#modal-list").modal('show');
                    $(".pleasewait").show();
                    $("#table-list").hide();
                },
                success: function (data) {
                    $('.pleasewait').hide();
                    $("#table-list").show();
                    $("#modal-title").html("asdv");
                    $("#table-list").html(data);
                    $('#table-plant').DataTable({
                        "bDestroy": true,
                        "paging": false,
                        "searching": false,
                        "fixedHeader": true
                    });
                }
            });
        }
        $("#btn-list").click(function () {
            createTable();
        });
    });
</script>

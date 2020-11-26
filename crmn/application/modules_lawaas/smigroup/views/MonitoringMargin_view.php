<style>
    .panel{
        position: relative;
        width: 110%;
        right: 5%;
        margin-top: 0%;
    }

    #loading_purple {
        position:fixed;
        top:0;
        left:0;
        background:url('<?php echo base_url(); ?>assets/img/loading.gif')no-repeat center center;
        z-index:9999;
        text-align:center;
        width:100%;
        height:100%;
        padding-top:70px;
        font:bold 50px Calibri,Arial,Sans-Serif;
        color:#000;
        display:none;
    }
    .modal-dialog{
        width: 100%;

    }
    .header-kolom {
        background: linear-gradient(to left, #1ab394, #036C13);
        color: #fff;
    }
    .summary-back{
        position: absolute;
        bottom: 50px;
        left: 10px;
    }
    .summary{
        position: relative;

        width: 80%;
        height: 230px;
        font-size: 0.65vw;
        box-shadow: 0px 1px 6px #7f8c8d;
        background-color: white;
        border-radius: 10px;
        color: black;
    }
    .summary tbody{
        font-size: 0.7vw;
    }
    .footer-summary{
        position:relative;
        margin-top: -20px;
        margin-left: 5px;
        margin-right: 20px;
    }
    .font-kecil{
        font-size: 2vw;
    }
    .hijau{
        color: green;
    }
    .kuning{
        color: orange;
    }
    .merah{
        color: red;
    }
    .tabelDialog{
        max-height: 80%;
    }

    .btn-margin{
        margin-right: 0.5%;
    }

</style>
<link href="<?php echo base_url(); ?>assets/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/fixedHeader.dataTables.min.css" rel="stylesheet">

<div id="loading_purple"></div>
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="col-md-1"></div>
            <div class="col-md-3" style="margin-top: 1.8%; border-right: #005fbf; border-right-style: dotted;border-right-width: thin;">
                <select id="org" class="form-control">
                    <option value="5">SMIG</option>
                    <option value="1">Region 1</option>
                    <option value="2">Region 2</option>
                    <option value="3">Region 3</option>
                    <option value="4">Curah</option>
                </select>
            </div>    
            <div class="col-md-1"></div>
            <div class="col-md-3">
                <label>Bulan</label>
                <select id="bulan" class="form-control" name="bulan">
                    <option value="00">-- Pilih Bulan --</option>
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
                    for ($i = 2014; $i <= Date('Y'); $i++) {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    ?>    
                </select>
            </div>
            <div class="col-md-1">
                <button id="filter" class="btn btn-success" style="margin-top:24px"><i class="fa fa-search"></i></button>
            </div>
        </div>        
    </div>
    <div class="panel-body">
        <div id="chart1"></div>

    </div>
</div>

<div id="tabelDialog">
    <div class="row">
        <div class="col-md-3" id="penc">
            <h3 >Pencapaian Seharusnya : <span id="penSeh"></span></h3>
        </div>
        <div class="col-md-9">
            <button class="btn btn-sm btn-default btn-margin pull-right btn-def disabled">Margin/Ton</button>
            <button class="btn btn-sm btn-default btn-margin pull-right btn-def disabled">HPP</button>
            <button class="btn btn-sm btn-default btn-margin pull-right btn-def" id="revenue">Revenue</button>
            <button class="btn btn-sm btn-default btn-margin pull-right btn-def" id="hnetto">H. Netto</button>
            <button class="btn btn-sm btn-default btn-margin pull-right btn-def" id="oaton">OA/Ton</button>
            <button class="btn btn-sm btn-default btn-margin pull-right btn-def" id="hbruto">H. Bruto</button>
            <button class="btn btn-sm btn-success btn-margin pull-right btn-def active"  id="volume">Volume</button>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="tabel_distrik"  class="table table-striped table-bordered table-hover" style="margin-bottom: 0px;display:block;width:100%">
                <thead>

                </thead>
                <tbody>

                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-sm btn-default btn-margin pull-right btn-mat" id="bulk">Bulk</button>
            <button class="btn btn-sm btn-default btn-margin pull-right btn-mat" id="bag">Bag</button>
            <button class="btn btn-sm btn-success btn-margin pull-right btn-mat" id="total">Total</button>
            
            <div id='SemenPutih'></div>
        </div>

    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.fixedheadertable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/floatThead.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts-jquery-plugin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.maps.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/maps/fusioncharts.indonesia.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
<!--<script src="<?= base_url('assets/chartjs/dist/Chart.js') ?>" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.bundle_1.js"></script>
<script>

    var Chart1, Chart2;
    var ctx1 = document.getElementById("Chart");
    var ctx2 = document.getElementById("Chart2");
    var org = 5, prov, tab = null, idTipe;
    var month = new Array(12);
    month[0] = "01";
    month[1] = "02";
    month[2] = "03";
    month[3] = "04";
    month[4] = "05";
    month[5] = "06";
    month[6] = "07";
    month[7] = "08";
    month[8] = "09";
    month[9] = "10";
    month[10] = "11";
    month[11] = "12";
    var d = new Date();
    var tahun = d.getUTCFullYear();
    var bulan = month[d.getUTCMonth()];

    function formatAngka(n) {
        var num = parseInt(n);
        return (num + '').replace(/(\d)(?=(\d{3})+$)/g, '$1.');
    }
    function formatWarna(val) {
        if (val < 90) {
            return 'merah';
        } else if (val >= 90 && val < 100) {
            return 'kuning';
        } else if (val >= 100) {
            return 'hijau';
        } else {
            return '';
        }
    }
    function formatWarnaRKAP(val) {
        var baru = new Date(tahun, d.getUTCMonth() + 2, 0);
        var tglSkrg = d.getUTCDate();
        var tglAkhir = baru.getUTCDate();
        var bulanparam = month[d.getUTCMonth()];
        var param;
        if (bulan == bulanparam) {
            param = (tglSkrg / tglAkhir) * 100;
        } else {
            param = 100;
        }
        var param2 = param - 10;
        if (val < param2) {
            return 'merah';
        } else if (val >= param2 && val < param) {
            return 'kuning';
        } else if (val >= param) {
            return 'hijau';
        } else {
            return '';
        }
    }
    function peta() {
        //alert(org);
        var peta;
        var url = base_url + 'smigroup/MonitoringMargin/scodata/' + org + '/' + tahun + '/' + bulan;
        //console.log('ini urlnya '+ ' => '+url);
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
                $('#summary').hide();
                $('#Vsummary').hide();
            },
            success: function (data) {
                peta = new FusionCharts("maps/indonesia", "chartobject-1", "100%", "500", "chart1", "json");
                peta.setChartData(data['data']);
                peta.addEventListener("entityClick", function (e, d) {
                    getDetail(d.id, 'volume', 'total');
//                      $('#volume').click();
//                    $('#chart1').attrFusionCharts({
//                        "showToolTip": "1"
//                    });
                });
//                                peta.addEventListener("entityClick", function (e, d) {
//                                    $('#chart1').attrFusionCharts({
//                                        "showToolTip": "0"
//                                    });
//                                });
                peta.render("chart1");
                $('#loading_purple').hide();
                if (is_mobile()) {
                    //$('#summary').hide();
                    $('#summary').removeClass('summary');
                    $('#summary').addClass('font-kecil');
                    //$('#summary').show();
                    //tlcc
                    $('#Vsummary').hide();
                } else {
                    //$('#summary').show();
                    //tlcc
                    $('#Vsummary').hide();
                }
            }
        });
    }
    function updatePeta() {
        var baru = new Date(tahun, d.getUTCMonth() + 2, 0);
        var tglSkrg = d.getUTCDate();
        var tglAkhir = baru.getUTCDate();
        var param = (tglSkrg / tglAkhir) * 100;
        var dataPeta;
        var url = base_url + 'smigroup/MonitoringMargin/scodata/' + org + '/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $('#chart1').updateFusionCharts({"dataSource": data['data'], "dataFormat": "json"});
                $('#loading_purple').hide();
                $('#bulansummary').html($('#bulan option:selected').text().toUpperCase());

            }
        });
    }


    function is_mobile() {
        if (navigator.userAgent.match(/Android/i) ||
                navigator.userAgent.match(/webOS/i) ||
                navigator.userAgent.match(/iPhone/i) ||
                navigator.userAgent.match(/iPod/i)
                ) {
            return true;
        } else {
            return false;
        }
    }

    function setChart() {
        ctx1 = document.getElementById("Chart");
        ctx2 = document.getElementById("Chart2");
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

    function createTableVolume(datas) {
        // $("#tabel_distrik").dataTable().fnDestroy();
        $('#penc').css('display', 'block');

        var thead = '<tr>' +
//                '<th id="kdd" style="background-color: rgb(192, 192, 192);text-align: center">Kode Distrik</th>' +
                '<th id="nmd" style="background-color: rgb(192, 192, 192);text-align: center">Nama Distrik</th>' +
                '<th id="reallalu" style="background-color: #68d06f;text-align: center">Real Tahun Lalu (A)</th>' +
                '<th id="real" style="background-color: #68d06f;text-align: center">Real Bulan Ini (B)</th>' +
                '<th id="persenreal" style="background-color: #68d06f;text-align: center">% Real (B/A) </th>' +
                '</tr>';
        $('#tabel_distrik thead').html(thead);

        var htmlbody = '';
        var data = [], ind = [];
        for (var i = 0; i < datas.data.length; i++) {

            htmlbody += '<tr><td nowrap class="nmd">' + datas.data[i]['BZTXT'] + '</td>';
            //                    htmlbody += '<td style="text-align: right;">' + datas.data[i]['TARGET'] + '</td>';
            htmlbody += '<td class="reallalu" style="text-align: right;">' + datas.data[i]['REALTHNLALU'] + '</td>';
            htmlbody += '<td class="real" style="text-align: right;">' + datas.data[i]['REALISASI'] + '</td>';
            var color = (parseFloat(datas.data[i]['PERSENREAL']) < parseFloat(datas.pencSeh['PERSENSEH']) ? 'red' : 'green')
            htmlbody += '<td class="" style="text-align: center;color: ' + color + '">' + datas.data[i]['PERSENREAL'] + '</td>';
            //                    htmlbody += '<td style="text-align: center;">' + datas.data[i]['PERSEN'] + '%</td>';

            $.each(datas.data[i], function (index, value) {

                if (!isNaN(parseFloat(index))) {

                    if (i == 0) {
                        ind.push(index);
                        data[index] = 0;
                        $('#tabel_distrik thead tr').append('<th class="tes" style="width:15%;background-color: #cbeca1;text-align: center" nowrap>' + datas.plant[index] + '</th>');
                    }

                    htmlbody += '<td style="text-align: right;">' + (value == null ? '' : Math.round(value).toLocaleString(['ban', 'id'])) + '</td>';
                    data[index] += Math.round(value);
                }
            });
            htmlbody += '</tr>';
        }
        if (datas.data.length > 0) {
            var htmlfoot = '';
            htmlbody += '<tr><td colspan="1" style="text-align: center;background-color: rgb(192, 192, 192);">JUMLAH</td> <td style="display: none;"></td><td style="display: none;"></td><td style="text-align: right;background-color: #68d06f;">' + datas.jml['REALTHNLALU'] + '</td><td style="text-align: right;background-color: #68d06f;">' + datas.jml['REALISASI']
                    + '</td><td style="background-color: #68d06f;text-align:center">' + parseFloat(datas.jml['REALISASI'] / datas.jml['REALTHNLALU'] * 100).toFixed(1) + '</td>';
            $.each(ind, function (index, value) {
                htmlbody += '<td style="text-align: right;background-color: #cbeca1;">' + data[value].toLocaleString(['ban', 'id']) + '</td>';
            });
            htmlbody += '</tr><tr><td colspan="4" style="background-color:  rgb(192, 192, 192);text-align:center"></td><td style="display: none;"></td><td style="display: none;"></td><td style="display: none;"></td><td style="display: none;"></td>';
            $.each(ind, function (index, value) {
                var pers = data[value] / Math.round(datas.jml['REALISASI'].toString().replace('.', '')) * 100;
                htmlbody += '<td style="text-align: right;background-color: #cbeca1;color: blue">' + pers.toFixed(1) + '%</td>';
            });
            htmlbody += '</tr>';
        }
        $('#tabel_distrik tbody').html(htmlbody);
        $('#tabel_distrik tfoot').html(htmlfoot);

//        $('#kdd').css('width', '10%');
//        $('#nmd').css('width', '30%');
//        $('#real').css('width', '20%');
//        $('#reallalu').css('width', '20%');

        tab = $('#tabel_distrik').DataTable({
            "scrollY": "300px",
            "searching": false,
            "scrollCollapse": true,
            "paging": false,
            "ordering": false,
            "autoWidth": true
        });

    }

    function createTableOA(datas) {
        // $("#tabel_distrik").dataTable().fnDestroy();
//       $('#penc').css('display','none');
        var thead = '<tr>' +
//                '<th id="kdd" style="background-color: rgb(192, 192, 192);text-align: center">Kode Distrik</th>' +
                '<th id="nmd" style="background-color: rgb(192, 192, 192);text-align: center">Nama Distrik</th>' +
                '<th id="real" style="background-color: #68d06f;text-align: center">Real OA (Rp/Ton)</th>' +
//                '<th id="persenreal" style="background-color: #68d06f;text-align: center">% Real Bulan Ini / Tahun Lalu</th>' +
                '</tr>';
        $('#tabel_distrik thead').html(thead);

        var htmlbody = '';
        var data = [], ind = [];
        for (var i = 0; i < datas.data.length; i++) {

            htmlbody += '<tr><td nowrap class="nmd">' + datas.data[i]['BZTXT'] + '</td>';
            //                    htmlbody += '<td style="text-align: right;">' + datas.data[i]['TARGET'] + '</td>';
            htmlbody += '<td class="real" style="text-align: right;">' + datas.data[i]['REALISASI'] + '</td>';
            var color = (parseFloat(datas.data[i]['PERSENREAL']) < parseFloat(datas.pencSeh['PERSENSEH']) ? 'red' : 'green')
//            htmlbody += '<td class="" style="text-align: center;color: ' + color + '">' + datas.data[i]['PERSENREAL'] + '</td>';
            //                    htmlbody += '<td style="text-align: center;">' + datas.data[i]['PERSEN'] + '%</td>';

            $.each(datas.data[i], function (index, value) {

                if (!isNaN(parseFloat(index))) {

                    if (i == 0) {
                        ind.push(index);
                        data[index] = 0;
                        $('#tabel_distrik thead tr').append('<th class="tes" style="width:15%;background-color: #cbeca1;text-align: center" nowrap>' + datas.plant[index] + '</th>');
                    }

                    htmlbody += '<td style="text-align: right;">' + (value == null ? '' : Math.round(value).toLocaleString(['ban', 'id'])) + '</td>';
                    data[index] += Math.round(value);
                }
            });
            htmlbody += '</tr>';
        }

//        var htmlfoot = '';
//        htmlbody += '<tr><td colspan="1" style="text-align: center;background-color: rgb(192, 192, 192);">JUMLAH</td> <td style="display: none;"></td><td style="display: none;"></td><td style="text-align: right;background-color: #68d06f;">' + datas.jml['REALTHNLALU'] + '</td><td style="text-align: right;background-color: #68d06f;">' + datas.jml['REALISASI'] + '</td><td style="background-color: #68d06f;"></td>';
//        $.each(ind, function (index, value) {
//            htmlbody += '<td style="text-align: right;background-color: #cbeca1;">' + data[value].toLocaleString(['ban', 'id']) + '</td>';
//        });
//        htmlbody += '</tr><tr><td colspan="3" style="background-color:  rgb(192, 192, 192);text-align:center"></td><td style="display: none;"></td><td style="display: none;"></td><td style="display: none;"></td><td style="display: none;"></td>';
//        $.each(ind, function (index, value) {
//            var pers = data[value] / Math.round(datas.jml['REALISASI'].toString().replace('.', '')) * 100;
//            htmlbody += '<td style="text-align: right;background-color: #cbeca1;color: blue">' + pers.toFixed(1) + '%</td>';
//        });
//        htmlbody += '</tr>';

        $('#tabel_distrik tbody').html(htmlbody);
//        $('#tabel_distrik tfoot').html(htmlfoot);

//        $('#kdd').css('width', '10%');
//        $('#nmd').css('width', '30%');
//        $('#real').css('width', '20%');
//        $('#reallalu').css('width', '20%');

        tab = $('#tabel_distrik').DataTable({
            "scrollY": "300px",
            "searching": false,
            "scrollCollapse": true,
            "paging": false,
            "ordering": false,
            "autoWidth": true
        });

    }


    function createTableRevenue(datas) {
        var thead = '<tr>' +
//                '<th id="kdd" style="background-color: rgb(192, 192, 192);text-align: center">Kode Distrik</th>' +
                '<th id="nmd" style="background-color: rgb(192, 192, 192);text-align: center">Nama Distrik</th>' +
                '<th id="real" style="background-color: #68d06f;text-align: center">Real Revenue </th>' +
                '</tr>';
        $('#tabel_distrik thead').html(thead);

        var htmlbody = '';
        var data = [], ind = [];
        for (var i = 0; i < datas.data.length; i++) {

            htmlbody += '<tr><td nowrap>' + datas.data[i]['BZTXT'] + '</td>';
            htmlbody += '<td  style="text-align: right;">' + datas.data[i]['REALISASI'] + '</td>';

            $.each(datas.data[i], function (index, value) {

                if (!isNaN(parseFloat(index))) {

                    if (i == 0) {
                        ind.push(index);
                        data[index] = 0;
                        $('#tabel_distrik thead tr').append('<th class="tes" style="width:15%;background-color: #cbeca1;text-align: center" nowrap>' + datas.plant[index] + '</th>');
                    }

                    htmlbody += '<td style="text-align: right;">' + (value == null ? '' : Math.round(value).toLocaleString(['ban', 'id'])) + '</td>';
                    data[index] += Math.round(value);
                }
            });
            htmlbody += '</tr>';


        }
        if (datas.data.length > 0) {
            var htmlfoot = '';
            htmlbody += '<tr><td colspan="1" style="text-align: center;background-color: rgb(192, 192, 192);">JUMLAH</td> <td style="display: none;"></td><td style="text-align: right;background-color: #68d06f;">' + datas.jml['REALISASI']
                    + '</td>';
            $.each(ind, function (index, value) {
                htmlbody += '<td style="text-align: right;background-color: #cbeca1;">' + data[value].toLocaleString(['ban', 'id']) + '</td>';
            });
            htmlbody += '</tr>';
        }
        $('#tabel_distrik tbody').html(htmlbody);

        tab = $('#tabel_distrik').DataTable({
            "scrollY": "300px",
            "searching": false,
            "scrollCollapse": true,
            "paging": false,
            "ordering": false
        });
    }

    function createTableHnetto(datas) {
        var thead = '<tr>' +
//                '<th id="kdd" style="background-color: rgb(192, 192, 192);text-align: center">Kode Distrik</th>' +
                '<th id="nmd" style="background-color: rgb(192, 192, 192);text-align: center">Nama Distrik</th>' +
                '<th id="real" style="background-color: #68d06f;text-align: center">Real H. Netto <br>(Rp/Ton)</th>' +
                '</tr>';
        $('#tabel_distrik thead').html(thead);

        var htmlbody = '';
        var data = [], ind = [];
        for (var i = 0; i < datas.data.length; i++) {

            htmlbody += '<tr><td nowrap>' + datas.data[i]['BZTXT'] + '</td>';
            htmlbody += '<td  style="text-align: right;">' + datas.data[i]['REALISASI'] + '</td>';

            $.each(datas.data[i], function (index, value) {

                if (!isNaN(parseFloat(index))) {

                    if (i == 0) {
                        ind.push(index);
                        data[index] = 0;
                        $('#tabel_distrik thead tr').append('<th class="tes" style="width:15%;background-color: #cbeca1;text-align: center" nowrap>' + datas.plant[index] + '</th>');
                    }

                    htmlbody += '<td style="text-align: right;">' + (value == null ? '' : Math.round(value).toLocaleString(['ban', 'id'])) + '</td>';
                    data[index] += Math.round(value);
                }
            });
            htmlbody += '</tr>';


        }
//        htmlbody += '<tr><td colspan="1" style="text-align: center;background-color: rgb(192, 192, 192);">RATA-RATA</td><td style="display: none;"></td>';
//        htmlbody += '<td style="background-color: #68d06f;text-align: right"">' + Math.round(datas.summ['REALISASI']).toLocaleString(['ban', 'id']) + '</td>';
//        $.each(datas.summ, function (index, value) {
//            if (!isNaN(parseFloat(index))) {
//                htmlbody += '<td style="text-align: right;background-color: #cbeca1;">' + Math.round(value).toLocaleString(['ban', 'id']) + '</td>';
//            }
//        });
//        htmlbody += '</tr>';
        $('#tabel_distrik tbody').html(htmlbody);

        tab = $('#tabel_distrik').DataTable({
            "scrollY": "300px",
            "searching": false,
            "scrollCollapse": true,
            "paging": false,
            "ordering": false
        });
    }

    function createTableHbruto(datas) {
//        $('#penc').css('display','none');
        var thead = '<tr>' +
//                '<th id="kdd" style="background-color: rgb(192, 192, 192);text-align: center">Kode Distrik</th>' +
                '<th id="nmd" style="background-color: rgb(192, 192, 192);text-align: center">Nama Distrik</th>' +
                '<th id="real" style="background-color: #68d06f;text-align: center">Real H. Bruto <br>(Rp/Ton)</th>' +
                '</tr>';
        $('#tabel_distrik thead').html(thead);

        var htmlbody = '';
        var data = [], ind = [];
        for (var i = 0; i < datas.data.length; i++) {

            htmlbody += '<tr><td nowrap>' + datas.data[i]['BZTXT'] + '</td>';
            htmlbody += '<td  style="text-align: right;">' + datas.data[i]['REALISASI'] + '</td>';

            $.each(datas.data[i], function (index, value) {

                if (!isNaN(parseFloat(index))) {

                    if (i == 0) {
                        ind.push(index);
                        data[index] = 0;
                        $('#tabel_distrik thead tr').append('<th class="tes" style="width:15%;background-color: #cbeca1;text-align: center" nowrap>' + datas.plant[index] + '</th>');
                    }

                    htmlbody += '<td style="text-align: right;">' + (value == null ? '' : Math.round(value).toLocaleString(['ban', 'id'])) + '</td>';
                    data[index] += Math.round(value);
                }
            });
            htmlbody += '</tr>';


        }

        if (datas.data.length > 0) {
            htmlbody += '<tr><td colspan="1" style="text-align: center;background-color: rgb(192, 192, 192);">RATA-RATA</td><td style="display: none;"></td>';
            htmlbody += '<td style="background-color: #68d06f;text-align: right"">' + Math.round(datas.summ['REALISASI']).toLocaleString(['ban', 'id']) + '</td>';
            $.each(datas.summ, function (index, value) {
                if (!isNaN(parseFloat(index))) {
                    htmlbody += '<td style="text-align: right;background-color: #cbeca1;">' + Math.round(value).toLocaleString(['ban', 'id']) + '</td>';
                }
            });
            htmlbody += '</tr>';
        }
        $('#tabel_distrik tbody').html(htmlbody);

        tab = $('#tabel_distrik').DataTable({
            "scrollY": "300px",
            "searching": false,
            "scrollCollapse": true,
            "paging": false,
            "ordering": false
        });

    }

    function getDetail(prov1, tipe, material) {
        if (tab != null) {
            tab.destroy();
        }
        prov = prov1;
        idTipe = tipe;
        ctx1 = document.getElementById("Chart");
        ctx2 = document.getElementById("Chart2");

        $('.btn-def').removeClass('active');
        $('.btn-def').removeClass('btn-success');
        $('.btn-def').removeClass('btn-default');
        $('.btn-def').addClass('btn-default');
        $('#' + tipe).removeClass('btn-default');
        $('#' + tipe).addClass('btn-success');
        $('#' + tipe).addClass('active');

        $('.btn-mat').removeClass('active');
        $('.btn-mat').removeClass('btn-success');
        $('.btn-mat').removeClass('btn-default');
        $('.btn-mat').addClass('btn-default');
        $('#' + material).removeClass('btn-default');
        $('#' + material).addClass('btn-success');
        $('#' + material).addClass('active');

        var url = base_url + 'smigroup/MonitoringMargin/getDistrik/' + org + '/' + prov + '/' + tahun + '/' + bulan + '/' + tipe + '/' + material;

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (datas) {

                $('#loading_purple').hide();
                $('#penSeh').html(datas.pencSeh['PERSENSEH']);

                if (tipe == 'volume') {
                     $('#SemenPutih').html('Volume Semen Putih : ' + datas.semenPutih['WC_VOL'] + ' Ton');
                    createTableVolume(datas);
                } else if (tipe == 'hbruto') {
                    $('#SemenPutih').html('Harga bruto Semen Putih : ' + Math.round(datas.semenPutih['HARGA']).toLocaleString(['ban', 'id']));
                    createTableHbruto(datas);
                } else if (tipe == 'oaton') {
                    $('#SemenPutih').html('Ongkong Angkut Semen Putih : ' + Math.round(datas.semenPutih['OA']).toLocaleString(['ban', 'id']));
                    createTableOA(datas);
                } else if (tipe == 'hnetto') {
                    $('#SemenPutih').html('Harga Netto Semen Putih : ' + Math.round(datas.semenPutih['NETTO']).toLocaleString(['ban', 'id']));
                    createTableHnetto(datas);
                } else if (tipe == 'revenue') {
                    $('#SemenPutih').html('Revenue Semen Putih : ' + Math.round(datas.semenPutih['REV']).toLocaleString(['ban', 'id']));
                    createTableRevenue(datas);
                }
                
               

                $('#tabelDialog').dialog({
                    autoOpen: false,
                    title: "Daftar SPJ",
                    show: "blind",
                    hide: "explode",
                    modal: true,
                    width: 'auto',
                    maxHeight: 600,
                    overflow: 'auto',
                    responsive: true
                });

                $('#tabelDialog').dialog('option', 'title', prov + ' - ' + datas.prov + ' (' + material.toString().toUpperCase() + ')');
                $('#tabelDialog').dialog("open");
                tab.columns.adjust().draw();

            }
        });
    }



    $(function () {
        org = '5';
        peta();
        $('#tahun').val(tahun);
        $('#bulan').val(bulan);
        $('#bulansummary').html($('#bulan option:selected').text().toUpperCase());
        $('#org').change(function () {
            org = $('#org').val();

            $('.summary').css('height', '230px');

            updatePeta();

        });
        $('#filter').click(function () {
            tahun = $('#tahun').val();
            bulan = $('#bulan').val();
            org = $('#org').val();
            //peta();
            updatePeta();
            getSummary();

        });

        $('.btn-def').click(function () {
            if ($(this).attr('id') != undefined) {
                var id = $(this).attr('id');
                getDetail(prov, id, 'total');
            }
        });

        $('.btn-mat').click(function () {
            if ($(this).attr('id') != undefined) {
                var matt = $(this).attr('id');
                getDetail(prov, idTipe, matt);
            }
        });
//        $('#volume').click(function () {
//            getDetail(prov, 'volume');
//            $('.btn-def').removeClass('btn-success');
//            $('.btn-def').removeClass('btn-default');
//            $('.btn-def').addClass('btn-default');
//            $('.btn-def').removeClass('active');
//            $('#volume').removeClass('btn-default');
//            $('#volume').addClass('btn-success');
//            $('#volume').addClass('active');
//
//        });
//        
//        $('#oaton').click(function () {
//            getDetail(prov, 'oaton');
//            $('.btn-def').removeClass('btn-success');
//            $('.btn-def').removeClass('btn-default');
//            $('.btn-def').addClass('btn-default');
//            $('.btn-def').removeClass('active');
//            $('#oaton').removeClass('btn-default');
//            $('#oaton').addClass('btn-success');
//            $('#oaton').addClass('active');
//
//        });
        setChart();

        //        $("#tabel_distrik").floatThead({scrollingTop: 0});
        $('#tabelDialog').dialog({
            autoOpen: false,
            title: "Daftar SPJ",
            show: "blind",
            hide: "explode",
            modal: true,
            width: 'auto',
            maxHeight: 600,
            overflow: 'auto',
            responsive: true
        });
    });

</script>

<div class="modal fade" id="modalChart">
    <div class="modal-dialog">
        <div class="modal-content" id="content">
            <div class="modal-header header-kolom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span id="modal-titletabel"></span>
                </h4>
            </div>
            <div class="modal-body">
                <div id="pleasewait">Please Wait . . .</div>
                <div class="row" id="view">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <canvas id="Chart" width="100%" height="50%" ></canvas>
                            <div style="margin-left: 30%;" id="legendDiv"></div><br/>
                        </div>
                        <div class="col-md-6">
                            <canvas id="Chart2" width="100%" height="50%"></canvas>
                            <div style="margin-left: 30%;" id="legendDiv2"></div><br/>
                        </div>
                        <div class="col-md-6">
                            <span style="font-style: italic"><strong><div id="textFooter" ></div></strong></span>
                        </div>
                    </div>

                </div>

                <!--                    <div class="modal-footer">                                             
                                    </div>-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>


<!-- <div class="table-popup" id="Vtable-dialog">
    <table class="table table-hover border-bottom white-bg" id="data-table">
        <thead>
        <th>#</th>
        <th>NAMA PERUSAHAAN</th>
        <th>REALISASI (TO)</th>
        <th>% MS</th>
        <th>% BAG</th>
        <th>% BULK</th>
        <th>% MS MoM</th>
        <th>% MS YoY</th>
        </thead>
        <tbody>
        </tbody>       
    </table>
    <table class="table border-bottom white-bg" id="">
        <tbody>
            <tr>
                <td width="30%">Porsi Demand</td>
                <td width="5%">:</td>
                <td>30%</td>
            </tr>
            <tr>
                <td>MoM</td>
                <td>:</td>
                <td><span style="color: green;">30% <i class="fa fa-level-up"></i></span></td>
            </tr>
            <tr>
                <td>YoY</td>
                <td>:</td>
                <td><span style="color: red">30% <i class="fa fa-level-down"></i></span></td>
            </tr>
        </tbody>       
    </table>
</div> -->

<div class="summary" id="Vsummary" style="position:fixed">
    <div style="text-align: center"><b>SUMMARY DOMESTIC SALES <span id="Vbulansummary"></span></b></div>
    <table class="table table-hover border-bottom center" style="text-align: center">
        <thead>
            <tr class="info">
                <th>REAL UP TO NOW (TON)</th>
                <th>RKAP (TON)</th>
                <th>REAL UP TO NOW (%)</th>
                <th>REAL / RKAP (%)</th>
            </tr>            
        </thead>
        <tbody>
            <tr>
                <td><span id="VrealSMIG"></span></td>
                <td><span id="VrkapSMIG"></span></td>
                <td><span id="VpersenRealSMIG"></span></td>
                <td><span id="VpersenRKAPSMIG"></span></td>
            </tr>            
        </tbody>     
    </table>
    <!--    <div class="footer-summary">
            <div>Total Demand <span class="pull-right">20% </span></div>
            <div>MoM <span class="pull-right">20% <i class="fa fa-level-up"></i></span></div>
            <div>YoY <span class="pull-right">20% <i class="fa fa-level-down"></i></span></div>
        </div>    -->
</div>
<style>
    .ibox-title.title-desc,.panel-heading {
        background: linear-gradient(to left, #1ab394, #036C13);
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

    tbody, thead tr {
        display: table;
        width: 100%;

    }
    * {box-sizing:border-box;}
    .btn-default {
        color: inherit;
        background: #cecccc;
        border: 1px solid #6c6c6c;
    }

    .btn-default.disabled{
        color: #030303;
    }

    .ibox-content {
        padding: 15px 20px 2px 20px;
    }
    .container {
        padding-right: 0px; 
        padding-left: 0px; 
    }
    th,h2 {
        text-align: center;
    }
    .ibox{
        color: black;
    }
    .ibox1,.panel{
        width: 110%;
        margin-left: -5%;
    }
    .ibox2{
        width: 110%;
        margin-left: -10%;
    }
    .ibox3{
        width: 110%;
        /*margin-left: -5%;*/
    }
    .label{
        color: black;
    }
    .label-merah{
        background-color: #ff4545;
        color: white;
        font-size: 12px;
    }
    .label-kuning{
        background-color: #fef536;
        font-size: 12px;
    }
    .label-hijau{
        background-color: #49ff56;
        font-size: 12px;
    }
    .merah{
        background-color: #ff4545;
    }
    .kuning{
        background-color: #fef536;
    }
    .hijau{
        background-color: #49ff56;
    }
    .kotak{
        float:left;
        width:2vw;
        height:1vw;
        border-radius: 3px;
        /*display: inline;*/
    }
    td{
        white-space:nowrap;
    }
    #title-region{
        font-weight:bold;
        text-align: center;
        padding-top:15px;
        font-size:16px;
        border-top:solid 1px #e7eaec;
    }
    .target_harian_revenue td{
        font-size:9px;
    }

    table.floatThead-table {
        border-top: none;
        border-bottom: none;
        background-color: #fff;
        table-layout: auto !important;
    }
    @media (min-width: 1200px){
        .container {
            width: 1200px;
        }
    }
</style>
<link href="<?php echo base_url(); ?>assets/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/fixedHeader.dataTables.min.css" rel="stylesheet">
<div id="loading_purple"></div>
<div class="row">    
    <div class="col-lg-12">        
        <div class="ibox ibox1 float-e-margins" style="margin-bottom: 0px">            
            <div class="ibox-title title-desc">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-line-chart"></i> OPTIMASI MARGIN</span></h4>            
            </div>
            <div class="ibox-content">     
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-5" style="">
                            <div class="col-md-2"><img src="<?= base_url() . 'assets/img/menu/semen_indonesia.JPG' ?>" style="width:90px;"></div>
                            <div class="col-md-10"><h2 style="text-align:left;line-height: 315%;text-indent:20px;"><b>SMI GROUP</b></h2></div>
                        </div>
                        <div class="col-md-2">
                            <label>Region</label>
                            <select id="region" class="form-control" name="region">
                                <option value="all">All</option>
                                <option value="1">Region 1</option>
                                <option value="2">Region 2</option>
                                <option value="3">Region 3</option>
                                <option value="curah">Curah Jawa & Bali</option>
                            </select>
                        </div>
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
                                for ($i = 2014; $i <= date("Y"); $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button id="filter" class="btn btn-success" style="margin-top:24px;"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 pull-right">
                        <a href="<?= base_url(); ?>smigroup/PencapaianProvinsi" class="btn btn-info  pull-right" style="margin-left:10px;margin-right:20px">Realisasi per Provinsi</a>
                        <a href="" class="btn btn-default  pull-right disabled" disabled >Optimasi Margin</a>

                    </div>
                </div>

                <h3 style="margin-bottom: 0px"><strong>PENCAPAIAN SEHARUSNYA SDK : <span id="pencSeh"></span></strong></h3>
                <h1 id="title-region"></h1>        

                <div id="page-info">
                    <ul class="list-group clear-list">

                    </ul>
                </div>



            </div>            
        </div>        
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="ibox ibox2 float-e-margins">            
            <div class="ibox-title title-desc">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-line-chart"></i> URUTAN MARGIN OPTIMUM BAG PER PROVINSI</span></h4>            
            </div>
            <div class="ibox-content">                             
                <div class="row">
                    <div class="col-md-12">
                        <span style="margin-bottom: 0px" class="pull-right"><strong>Menggunakan Margin Bulan <span class="dateMrg"></span></strong></span>
                        <table class="table table-responsive" id="table-bag" style="margin-bottom: 0px;display:block;">
                            <thead  style="display:block;position: sticky; background-color: #d6d6d6">
                                <tr>
                                    <th style="width: 25%;">Provinsi</th>
                                    <th style="width: 41%;">Pencapaian<br> Volume</th>
                                    <th style=" width: 16%;">Margin<br>(Rp/Ton)</th>
                                    <th style="width: 13%; ">Selisih Volume</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4"><div id="chartbag" style="min-width: 400px; min-height: 1000px; margin: 0 auto"></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pull-right">

                </div>
                <div id="page-info">
                    <ul class="list-group clear-list">

                    </ul>
                </div>
            </div>            
        </div> 
    </div>
    <div class="col-md-6">
        <div class="ibox ibox3 float-e-margins">            
            <div class="ibox-title title-desc">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-line-chart"></i> URUTAN MARGIN OPTIMUM CURAH PER PROVINSI</span></h4>            
            </div>
            <div class="ibox-content">                                 
                <div class="row">
                    <div class="col-md-12">
                        <span style="margin-bottom: 0px" class="pull-right"><strong>Menggunakan Margin Bulan <span class="dateMrg"></span></strong></span>
                        <table class="table table-responsive" id="table-bulk" style="margin-bottom: 0px">
                            <thead style="; background-color: #d6d6d6">
                                <tr>
                                    <th style="width: 25%;">Provinsi</th>
                                    <th style="width: 41%;">Pencapaian <br> Volume</th>
                                    <th style=" width: 16%;">Margin <br> (Rp/Ton)</th>
                                    <th style="width: 13%; ">Selisih Volume</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan='4'>
                                        <div id="chartbulk" style="min-width: 400px; min-height: 1000px; margin: 0 auto"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pull-right">

                </div>
                <div id="page-info">
                    <ul class="list-group clear-list">

                    </ul>
                </div>
            </div>            
        </div> 
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.fixedheadertable.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/highchart/highcharts.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/highchart/exporting.js"></script>-->
<script src="<?php echo base_url(); ?>assets/js/floatThead.js"></script>
<script>



//    $(document).ready(function () {
//
//        $(".sticky-header").floatThead({scrollingTop: 50});
//
//    });


    function formatAngka(n) {
        var num = parseInt(n);
        return (num + '').replace(/(\d)(?=(\d{3})+$)/g, '$1.');
    }
    function getLastDate(Year, Month) {
        var date = new Date((new Date(Year, Month, 1)) - 1);
        var lastDay = date.getUTCDate();
        return lastDay;
    }

    function isRealValue(obj) {
        return obj && obj !== "null" && obj !== "undefined";
    }

    function newChart(idchart, title, datas, vis) {

        Highcharts.chart(idchart, {
            chart: {
                type: 'bar'
            },
            title: {
                text: title,
                style: {
                    display: 'none'
                }
            },
            xAxis: {
                categories: datas['PROV'],
                labels: {
                    align: 'left',
                    reserveSpace: true
                },
                plotLines: [{
                        color: 'red', // Color value
                        dashStyle: 'shortdash', // Style of the plot line. Default to solid
                        value: datas['PERSENSEH'][0], // Value of where the line will appear
                        width: 2, // Width of the line
                        label: {
                            text: 'Last quarter minimum'
                        }
                    }]
            },

            yAxis: [{
                    min: 0,
                    max: 150,
                    title: {
                        text: 'Ton'
                    }
                }, {
                    title: {
                        text: ''
                    },
                    opposite: true
                }],
            legend: {
                shadow: false
            },
            tooltip: {

                useHTML: true,
                headerFormat: '',
                formatter: function () {
                    //console.log(this);
                    var color = (datas.MARGIN[this.point['index']] < 0 ? 'red' : 'black')
                    var s = '<strong>' + this.key + '</strong><table style=""><tr style="color:'+color+'"><td>Target 1 Bln </td><td>:</td><td>' + datas.TARGET[this.point['index']] + ' Ton</td></tr>' +
                            '<tr><td>Target SDK (Vol)</td><td>:</td><td>' + datas.TARGETSDK[this.point['index']] + ' Ton</td></tr>' +
                            '<tr><td>Penc SDK (Vol)</td><td>:</td><td>' + datas.REAL[this.point['index']] + ' Ton</td></tr>' +
                            '<tr><td>Persen Real SDK (Vol)&nbsp;</td><td>:</td><td>' + datas.PERSENSDK[this.point['index']] + '%</td></tr></table>';

                    console.log(s);
                    return s;

                },
                valueDecimals: 2
            },
            plotOptions: {
                bar: {
                    grouping: false,
                    shadow: false,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function () {

                            if (this.series.index == 0) {
                                var max = this.series.yAxis.max,
                                        color = parseFloat(datas['SELISIH'][this.point.index]) > 0 ? 'black' : 'red'; // 5% width
                                return '<span style="color: ' + color + '">' + datas['SELISIH'][this.point.index] + ' </span>';
                            } else if (this.series.index == 1) {
                                 color = parseFloat(datas['MARGIN'][this.point.index]) > 0 ? 'black' : 'red';
                                return '<span style="color: ' + color + '">' + datas['MARGIN'][this.point.index] + ' </span>';
                            }
                        },
                    },
                },

            },
            series: [{
                    name: '',
                    color: 'white',
                    data: datas['TES2'],
                    showInLegend: false,
                    // pointPadding: 0.3,
                    pointPlacement: 0
                }, {
                    name: 'Target 1 Bulan',
                    color: '#0095c2',
                    data: datas['PERSENTARGET'],
                    // pointPadding: 0.3,
                    pointPlacement: 0
                }, {
                    name: 'Target SDK',
                    color: '#ff4545',
                    data: datas['PERSENSEH'],
                    showInLegend: vis,
                    //pointPadding: 0.2,
                    pointPlacement: 0,
                    visible: vis
                }, {
                    name: 'Realisasi',
                    color: '#5eff2c',
                    data: datas['PERSENBLNGF'],
                    pointPadding: 0.1,
                    pointPlacement: 0
                }, ]
        });
    }


    function chart(tahun, bulan, hari, region) {


        var ctx1 = document.getElementById('chartbag').getContext("2d");
        var url = base_url + 'smigroup/OptimasiMargin/getDataChart/all';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function (datas) {
                //chart bar 1
                var barChartData1 = {
                    labels: datas.bag['PROV'],
                    datasets: [
                        {
                            label: 'REALISASI S/D KEMARIN',
                            backgroundColor: "#5eff2c",
                            data: datas.bag['REAL']
                        }, {
                            label: 'TARGET S/D KEMARIN',
                            backgroundColor: "#ff4545",
                            data: datas.bag['TARGETSDK']
                        }, {
                            label: 'TARGET 1 BULAN',
                            backgroundColor: "#0095c2",
                            data: datas.bag['TARGET']
                        },
                    ]
                };
                /* cari selisih antara target dan tonase_real */


                var options1 = {
                    title: {
                        display: true,
                        text: "Grafik Target Dan Realisasi"
                    },
                    scaleLabel: "<%=value%>%",
                    responsive: true,
                    scales: {

                        xAxes: [{
                                scaleLabel: {

                                    display: true,
                                    labelString: 'Prosentase Seharusnya ' + datas['pencSeharusnya'] + '%'
                                },
                                ticks: {
                                    max: 110,
                                    suggestedMin: 0,
                                    callback: function (value, index, values) {
                                        return formatAngka(value);
                                    }
                                },
                                barPercentage: 2
                            }],
                        yAxes: [{
                                display: true,
                                stacked: true
                            }]
                    },
                    tooltips: {
                        mode: 'single',
                        callbacks: {
                            title: function (tooltipItem, data) {
                                //var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                var label = tooltipItem[0].yLabel;
                                var wilayah;
                                if (label == 'Biro Penj 1') {
                                    wilayah = 'Sumbar, Riau, Jambi Bengkulu';
                                } else if (label == 'Biro Penj 2') {
                                    wilayah = 'Aceh, Sumut, Rikep, Sumbagsel';
                                } else if (label == 'Biro Penj 3') {
                                    wilayah = 'Jatim & Bali';
                                } else if (label == 'Biro Penj 4') {
                                    wilayah = 'Jateng & DIY';
                                } else if (label == 'Biro Penj 5') {
                                    wilayah = 'Banten, DKI, Jabar';
                                } else if (label == 'Biro Curah Jawa Bali') {
                                    wilayah = 'Curah Jawa & Bali';
                                } else if (label == 'Biro Penj 7') {
                                    wilayah = 'Sulawesi';
                                } else if (label == 'Biro Penj 8') {
                                    wilayah = 'Kalimantan';
                                } else if (label == 'Biro Penj 9') {
                                    wilayah = 'Maluku, Papua & Nusa Tenggara';
                                }
                                return wilayah;
                            },
//                            label: function (tooltipItem, data) {
//                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
//                                var tonase;
//                                if (tooltipItem.datasetIndex === 0) {
//                                    tonase = datas['tonase_real'];
//                                } else if (tooltipItem.datasetIndex === 1) {
//                                    tonase = datas['tonase_targetsd'];
//                                } else if (tooltipItem.datasetIndex === 2) {
//                                    tonase = datas['tonase_target'];
//                                }
//                                return datasetLabel + ' : ' + tooltipItem.xLabel + ' % (' + formatAngka(tonase[tooltipItem.index]) + ' Ton)';
//                            }
                        }
                    },
//                    animation: {
//                        onComplete: function () {
//                            var chartInstance = this.chart;
//                            var ctx = chartInstance.ctx;
//                            ctx.textAlign = "left";
//
//                            Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
//                                var meta = chartInstance.controller.getDatasetMeta(i);
//                                Chart.helpers.each(meta.data.forEach(function (bar, index) {
//                                    //console.log(i);
//                                    if (i === 2) {
//                                        ctx.fillText(datas['kabiro'][index], bar._model.x + 5, bar._model.y - 5);
//                                    }
//
//                                }), this);
//                            }), this);
//                        }
//                    }
                };
                chartBar1 = new Chart(ctx1, {
                    type: 'horizontalBar',
                    data: barChartData1,
                    options: options1
                });
            }
        });
    }

    function getData(region, bulan, tahun, hari) {
        var url = base_url + 'smigroup/OptimasiMargin/getDataChart/' + region + '/' + tahun + '/' + bulan + '/' + hari;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (datas) {
                $('#loading_purple').hide();
                $('#pencSeh').html(datas.pencSeharusnya + '%');
                $('.dateMrg').html(datas.dateMargin);

                if (region == 1) {
                    $('#title-region').html('Bag/Curah All Sumatera');
                } else if (region == 2) {
                    $('#title-region').html('Bag All Jawa Bali');
                } else if (region == 3) {
                    $('#title-region').html('Bag/Curah All Kalimantan, Sulawesi, Nusra, Ind. Timur');
                } else if (region == 'curah') {
                    $('#title-region').html('Curah All Jawa & Bali');
                } else {
                    $('#title-region').html('Bag & Curah All Provinsi');
                }

                newChart('chartbag', 'Pencapaian Bag', datas.bag, datas.sdkVis);
                newChart('chartbulk', 'Pencapaian Bulk', datas.bulk, datas.sdkVis);
                $("#table-bag").floatThead({scrollingTop: 0});
                $("#table-bulk").floatThead({scrollingTop: 0});
            }
        });
    }

    $(function () {
        var d = new Date();
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
        var n = month[d.getMonth()];
        $('#loading_purple').hide();
        $('#tahun').val(d.getUTCFullYear());
        $('#bulan').val(n);

        var region = $('#region').val();
        var tahun = $('#tahun').val();
        var bulan = $('#bulan').val();
        var hari = d.getDate() + '';
        if (hari.length == 1) {
            hari = '0' + hari;
        }

        getData(region, bulan, tahun, hari);

        $('#filter').click(function () {
            var region = $('#region').val();
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            var hari = getLastDate(tahun, bulan);
            if (tahun == d.getUTCFullYear() && bulan == month[d.getUTCMonth()]) {
                hari = d.getDate() + '';
            }
            if (hari.length == 1) {
                hari = '0' + hari;
            }

            getData(region, bulan, tahun, hari);

        });
    });
</script>


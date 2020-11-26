<style>
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
    .chart1{
        color: black;
    }
</style>
<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.bundle.js"></script>
<div id="loading_purple"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><span class="text-navy"><i class="fa fa-truck"></i> IN PLANT TUBAN</span></h4>             
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban" type="button" class="btn btn-primary pull-left">
                            <i class="fa fa-arrow-circle-left"></i> Kembali
                        </a>
                        <center><h2><b>Grafik Laporan Perbulan</b></h2></center>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <label>Tahun</label>
                            <select id="tahun" class="form-control" name="tahun">
                                <!--                                <option value="2014">2014</option>
                                                                <option value="2015">2015</option>
                                                                <option value="2016">2016</option>-->
                                <?php
                                for ($i = 2014; $i <= Date('Y'); $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>  
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Poin</label>
                            <select id="posisi" class="form-control" name="posisi">
                                <option value="kargo">Kargo</option>
                                <option value="tmbm">Timbang Masuk</option>
                                <option value="pbrk">Pemuatan</option>
                                <option value="overall">Waktu Total Satu Siklus</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button id="graf" class="btn btn-success" style="margin-top:24px"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <canvas id="chart1" height="200"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="chart2" height="200"></canvas>
                        </div>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <canvas id="chart3" height="250"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="chart4" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts-jquery-plugin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
<script>
    var chartLine1, chartLine2, chartBar1, chartBar2;
    Chart.defaults.global.defaultFontColor = '#000';
    function chart1(datas) {
        var ctx = document.getElementById('chart1').getContext("2d");
        var data = {
            labels: datas['grafRataBag']['labels'],
            datasets: [
                {
                    label: 'Rata-rata Jam',
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "red",
                    pointBorderWidth: 10,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: datas['grafRataBag']['data']
                }, {
                    type: 'line',
                    label: 'Standar Waktu Maksimal',
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "#ff0000",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#ff0000",
                    pointBackgroundColor: "red",
                    pointBorderWidth: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#ff0000",
                    pointHoverBorderColor: "#ff0000",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: datas['grafRataBag']['batas']
                }
            ]
        };
        chartLine1 = Chart.Line(ctx, {
            data: data,
            options: {
                responsive: true,
                responsiveAnimationDuration: 1000,
                title: {
                    display: true,
                    text: 'Grafik rata-rata waktu truk Bag',
                    fontColor: "#000"
                },
                legend: {
                    display: false
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                            display: true,
                            color: "#ff0000",
                            scaleLabel: {
                                display: true,
                                labelString: 'Tanggal',
                                fontColor: "#000"
                            }
                        }],
                    yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Jam',
                                fontColor: "#000"
                            },
                            ticks: {
                                suggestedMin: 0
                            }
                        }]
                }
            }
        });
    }
    function chart2(datas) {
        var ctx = document.getElementById('chart2').getContext("2d");
        var data = {
            labels: datas['grafRataBulk']['labels'],
            datasets: [
                {
                    label: 'rata-rata jam',
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "red",
                    pointBorderWidth: 10,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: datas['grafRataBulk']['data']
                }, {
                    type: 'line',
                    label: 'Standar Waktu Maksimal',
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "#ff0000",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#ff0000",
                    pointBackgroundColor: "red",
                    pointBorderWidth: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#ff0000",
                    pointHoverBorderColor: "#ff0000",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: datas['grafRataBulk']['batas']
                }
            ]
        };
        chartLine2 = Chart.Line(ctx, {
            data: data,
            options: {
                responsive: true,
                responsiveAnimationDuration: 1000,
                title: {
                    display: true,
                    text: 'Grafik rata-rata waktu truk Bulk',
                    fontColor: "#000"
                },
                legend: {
                    display: false,
                    fontColor: "#000"
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Tanggal',
                                fontColor: "#000"
                            }
                        }],
                    yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Jam',
                                fontColor: "#000"
                            },
                            ticks: {
                                suggestedMin: 0
                            }
                        }]
                }
            }
        });
    }
    function chart3(datas) {
        var ctx = document.getElementById('chart3').getContext("2d");
        var data = {
            labels: datas['grafXpBag']['labels'],
            datasets: [
                {
                    label: 'rata-rata jam',
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "red",
                    pointBorderWidth: 10,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: datas['grafXpBag']['data']
                }, {
                    type: 'line',
                    label: 'Standar Waktu Maksimal',
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "#ff0000",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#ff0000",
                    pointBackgroundColor: "red",
                    pointBorderWidth: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#ff0000",
                    pointHoverBorderColor: "#ff0000",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: datas['grafXpBag']['batas']
                }
            ]
        };
        chartBar1 = Chart.Bar(ctx, {
            data: data,
            options: {
                responsive: true,
                responsiveAnimationDuration: 1000,
                title: {
                    display: true,
                    text: '10 terlama ekspeditur truk Bag'
                },
                legend: {
                    display: false
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Nama Ekspeditur',
                                fontColor: "#000"
                            }
                        }],
                    yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Jam',
                                fontColor: "#000"
                            },
                            ticks: {
                                suggestedMin: 0
                            }
                        }]
                }
            }
        });
    }
    function chart4(datas) {
        var ctx = document.getElementById('chart4').getContext("2d");
        var data = {
            labels: datas['grafXpBulk']['labels'],
            datasets: [
                {
                    label: 'rata-rata jam',
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "red",
                    pointBorderWidth: 10,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: datas['grafXpBulk']['data']
                }, {
                    type: 'line',
                    label: 'Standar Waktu Maksimal',
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "#ff0000",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#ff0000",
                    pointBackgroundColor: "red",
                    pointBorderWidth: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#ff0000",
                    pointHoverBorderColor: "#ff0000",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: datas['grafXpBulk']['batas']
                }
            ]
        };
        chartBar2 = Chart.Bar(ctx, {
            data: data,
            options: {
                responsive: true,
                responsiveAnimationDuration: 1000,
                title: {
                    display: true,
                    text: '10 terlama ekspeditur truk Bulk'
                },
                legend: {
                    display: false
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                            display: true,
                            fontColor: "#000",
                            scaleLabel: {
                                display: true,
                                labelString: 'Nama Ekspeditur',
                                fontColor: "#000"
                            }
                        }],
                    yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Jam',
                                fontColor: "#000"
                            },
                            ticks: {
                                suggestedMin: 0
                            }
                        }]
                }
            }
        });
    }

    function updateChart1(datas) {
        chartLine1.data.labels = datas['grafRataBag']['labels'];
        //$.each(chartLine1.data.datasets, function (i, dataset) {
        chartLine1.data.datasets[0].data = datas['grafRataBag']['data'];
        chartLine1.data.datasets[1].data = datas['grafRataBag']['batas'];
        //});
        chartLine1.update();
    }

    function updateChart2(datas) {
        chartLine2.data.labels = datas['grafRataBulk']['labels'];
        //$.each(chartLine2.data.datasets, function (i, dataset) {
        chartLine2.data.datasets[0].data = datas['grafRataBulk']['data'];
        chartLine2.data.datasets[1].data = datas['grafRataBulk']['batas'];
        //});
        chartLine2.update();
    }
    function updateChart3(datas) {
        chartBar1.data.labels = datas['grafXpBag']['labels'];
        $.each(chartBar1.data.datasets, function (i, dataset) {
            dataset.data = datas['grafXpBag']['data'];
        });
        chartBar1.update();
    }
    function updateChart4(datas) {
        chartBar2.data.labels = datas['grafXpBulk']['labels'];
        $.each(chartBar2.data.datasets, function (i, dataset) {
            dataset.data = datas['grafXpBulk']['data'];
        });
        chartBar2.update();
    }

    function loadChart(posisi, bulan, tahun) {
        var url = base_url + 'sg/InPlantTuban/grafik/' + posisi + '/' + bulan + '/' + tahun;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (datas) {
                chart1(datas);
                chart2(datas);
                chart3(datas);
                chart4(datas);
                $('#loading_purple').hide();
            }
        });
    }

    function updateChart(posisi, bulan, tahun) {
        var url = base_url + 'sg/InPlantTuban/grafik/' + posisi + '/' + bulan + '/' + tahun;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (datas) {
                updateChart1(datas);
                updateChart2(datas);
                updateChart3(datas);
                updateChart4(datas);
                $('#loading_purple').hide();
            }
        });
    }

    $(function () {
        var d = new Date()
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
        var n = month[d.getUTCMonth()];
        $('#bulan').val(n);
        $('#tahun').val(d.getUTCFullYear());
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        var posisi = $('#posisi').val();
        loadChart(posisi, bulan, tahun);
        //chart1(posisi, bulan, tahun);
        //chart2(posisi, bulan, tahun);
        //chart3(posisi, bulan, tahun);
        //chart4(posisi, bulan, tahun);
        $('#graf').click(function () {
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            var posisi = $('#posisi').val();
            updateChart(posisi, bulan, tahun);
//            updateChart1(posisi, bulan, tahun);
//            updateChart2(posisi, bulan, tahun);
//            updateChart3(posisi, bulan, tahun);
//            updateChart4(posisi, bulan, tahun);
        });
    });
</script>
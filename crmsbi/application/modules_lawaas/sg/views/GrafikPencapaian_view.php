<style>
    .ibox-title.title-desc,.panel-heading {
    background: linear-gradient(to left, #1ab394, #036C13);
    }
    #grafik_panel{
        position: relative;
        width: 115%;
        right: 6%;
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

    .tooltip {
        opacity: 0;
        position: absolute;
        background: rgba(0, 0, 0, .7);
        color: white;
        padding: 3px;
        border-radius: 3px;
        -webkit-transition: all .1s ease;
        transition: all .1s ease;
        pointer-events: none;
        -webkit-transform: translate(-50%, 0);
        transform: translate(-50%, 0);
    }
</style>

<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.bundle.js"></script>
<div id="loading_purple"></div>
<div class="row" id="grafik_panel">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-bar-chart-o"></i> PENCAPAIAN VOLUME PER PROVINSI SEMEN GRESIK</span></h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
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
                            <select id="tahun" class="form-control" name="tahun">
                                <?php
                                for ($i = 2014; $i <= date("Y"); $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button id="filter" class="btn btn-success" style="margin-top:0px"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <canvas id="chart1" height="260"></canvas>
                            <div class="tooltip" id="tooltip1"></div>
                        </div>
                        <div class="col-md-6">
                            <canvas id="chart2" height="260"></canvas>
                            <div class="tooltip" id="tooltip1"></div>
                        </div>
                    </div>
                </div><br/>   
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <canvas id="chart3" height="260"></canvas>
                            <div class="tooltip" id="tooltip1"></div>
                        </div>
                        <div class="col-md-6">
                            <canvas id="chart5" height="260"></canvas>
                            <div class="tooltip" id="tooltip1"></div>
                        </div>
                    </div>
                </div><br/>   
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <canvas id="chart4" height="260"></canvas>
                            <div class="tooltip" id="tooltip1"></div>
                        </div>
                        <div class="col-md-6">
                            <canvas id="chart6" height="260"></canvas>
                            <div class="tooltip" id="tooltip1"></div>
                        </div>
                    </div>
                </div><br/> 
            </div>
        </div>
    </div>
</div>
<script>
    var chartBar1;
    var chartBar2;
    var chartBar3;
    var chartBar4;
    var chartBar5;
    var chartBar6;
    Chart.defaults.global.defaultFontColor = '#000';
    Chart.defaults.global.defaultFontFamily = 'Times New Roman';
    function formatAngka(n) {
        var num = parseInt(n);
        return (num + '').replace(/(\d)(?=(\d{3})+$)/g, '$1.');
    }
    function getLastDate(Year,Month){
        var date = new Date((new Date(Year, Month,1))-1);
        var lastDay = date.getUTCDate();
        return lastDay;
    }

    function chart(tahun, bulan, hari) {
        var ctx1 = document.getElementById('chart1').getContext("2d");
        var ctx2 = document.getElementById('chart2').getContext("2d");
        var ctx3 = document.getElementById('chart3').getContext("2d");
        var ctx4 = document.getElementById('chart4').getContext("2d");
        var ctx5 = document.getElementById('chart5').getContext("2d");
        var ctx6 = document.getElementById('chart6').getContext("2d");
        var url = base_url + 'sg/GrafikPencapaian/getData/' + tahun + '/' + bulan + '/' + hari;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (datas) {
                //chart bar 1
                var barChartData1 = {
                    labels: datas['labels'],
                    datasets: [{
                            label: 'REALISASI S/D KEMARIN',
                            backgroundColor: "#5eff2c",
                            data: datas['realisasi']
                        }, {
                            label: 'TARGET S/D KEMARIN',
                            backgroundColor: "#ff4545",
                            data: datas['target_hari']
                        }, {
                            label: 'TARGET 1 BULAN',
                            backgroundColor: "#0095c2",
                            data: datas['target_bulan']
                        }]
                };
                var options1 = {
                    title: {
                        display: true,
                        text: "Grafik Target Dan Realisasi"
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                                stacked: true
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
                                        return formatAngka(value);
                                    }
                                }
                            }]
                    },
                    tooltips: {
                        mode: 'label',
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                            }
                        }
                    }
                };
                chartBar1 = new Chart.Bar(ctx1, {
                    data: barChartData1,
                    options: options1
                });
                
                //chart bar 2
                var barChartData2 = {
                    labels: datas['labels'],
                    datasets: [{
                            type: 'line',
                            label: 'MAX REAL',
                            fill: false,
                            backgroundColor: "#ff4545",
                            borderColor: "rgba(0,0,255,0)",
                            pointBorderColor: datas['warna'],
                            pointBackgroundColor: datas['warna'],
                            pointRadius: 6,
                            pointHoverRadius: 7,
                            data: datas['harian_max']
                        },{
                            type: 'line',
                            label: 'MENCAPAI TARGET',
                            fill: false,
                            backgroundColor: "#5eff2c",
                            data: ''
                        },{
                            label: 'TARGET',
                            backgroundColor: "#0095c2",
                            data: datas['target']
                        }]
                };
                var options2 = {
                    title: {
                        display: true,
                        text: "Grafik Max Realisasi Harian Dan Target Harian"
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                                stacked: true
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
                                        return formatAngka(value);
                                    }
                                }
                            }]
                    },
                    tooltips: {
                        mode: 'label',
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                            }
                        }
                    }
                };
                chartBar2 = new Chart.Bar(ctx2, {
                    data: barChartData2,
                    options: options2
                });
                //chartbar 3
                var barChartData3 = {
                    labels: datas['labels'],
                    datasets: [{
                            label: 'REALISASI S/D KEMARIN',
                            backgroundColor: "#5eff2c",
                            data: datas['bag']['realisasi']
                        }, {
                            label: 'TARGET S/D KEMARIN',
                            backgroundColor: "#ff4545",
                            data: datas['bag']['target_hari']
                        }, {
                            label: 'TARGET 1 BULAN',
                            backgroundColor: "#0095c2",
                            data: datas['bag']['target_bulan']
                        }]
                };
                var options3 = {
                    title: {
                        display: true,
                        text: "Grafik Target Dan Realisasi Bag"
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                                stacked: true
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
                                        return formatAngka(value);
                                    }
                                }
                            }]
                    },
                    tooltips: {
                        mode: 'label',
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                            }
                        }
                    }
                };
                chartBar3 = new Chart.Bar(ctx3, {
                    data: barChartData3,
                    options: options3
                });
                //chartbar 4
                var barChartData4 = {
                    labels: datas['labels'],
                    datasets: [{
                            label: 'REALISASI S/D KEMARIN',
                            backgroundColor: "#5eff2c",
                            data: datas['bulk']['realisasi']
                        }, {
                            label: 'TARGET S/D KEMARIN',
                            backgroundColor: "#ff4545",
                            data: datas['bulk']['target_hari']
                        }, {
                            label: 'TARGET 1 BULAN',
                            backgroundColor: "#0095c2",
                            data: datas['bulk']['target_bulan']
                        }]
                };
                var options4 = {
                    title: {
                        display: true,
                        text: "Grafik Target Dan Realisasi Bulk"
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                                stacked: true
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
                                        return formatAngka(value);
                                    }
                                }
                            }]
                    },
                    tooltips: {
                        mode: 'label',
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                            }
                        }
                    }
                };
                chartBar4 = new Chart.Bar(ctx4, {
                    data: barChartData4,
                    options: options4
                });
                //chart bar 5
                var barChartData5 = {
                    labels: datas['labels'],
                    datasets: [{
                            type: 'line',
                            label: 'MAX REAL',
                            fill: false,
                            backgroundColor: "#ff4545",
                            borderColor: "rgba(0,0,255,0)",
                            pointBorderColor: datas['bag']['warna'],
                            pointBackgroundColor: datas['bag']['warna'],
                            pointRadius: 6,
                            pointHoverRadius: 7,
                            data: datas['bag']['harian_max']
                        },{
                            type: 'line',
                            label: 'MENCAPAI TARGET',
                            fill: false,
                            backgroundColor: "#5eff2c",
                            data: ''
                        },{
                            label: 'TARGET',
                            backgroundColor: "#0095c2",
                            data: datas['bag']['target']
                        }]
                };
                var options5 = {
                    title: {
                        display: true,
                        text: "Grafik Max Realisasi Bag Harian Dan Target Bag Harian"
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                                stacked: true
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
                                        return formatAngka(value);
                                    }
                                }
                            }]
                    },
                    tooltips: {
                        mode: 'label',
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                            }
                        }
                    }
                };
                chartBar5 = new Chart.Bar(ctx5, {
                    data: barChartData5,
                    options: options5
                });
                //chart bar 6
                var barChartData6 = {
                    labels: datas['labels'],
                    datasets: [{
                            type: 'line',
                            label: 'MAX REAL',
                            fill: false,
                            backgroundColor: "#ff4545",
                            borderColor: "rgba(0,0,255,0)",
                            pointBorderColor: datas['bulk']['warna'],
                            pointBackgroundColor: datas['bulk']['warna'],
                            pointRadius: 6,
                            pointHoverRadius: 7,
                            data: datas['bulk']['harian_max']
                        },{
                            type: 'line',
                            label: 'MENCAPAI TARGET',
                            fill: false,
                            backgroundColor: "#5eff2c",
                            data: ''
                        },{
                            label: 'TARGET',
                            backgroundColor: "#0095c2",
                            data: datas['bulk']['target']
                        }]
                };
                var options6 = {
                    title: {
                        display: true,
                        text: "Grafik Max Realisasi Bulk Harian Dan Target Bulk Harian"
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                                stacked: true
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
                                        return formatAngka(value);
                                    }
                                }
                            }]
                    },
                    tooltips: {
                        mode: 'label',
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                            }
                        }
                    }
                };
                chartBar6 = new Chart.Bar(ctx6, {
                    data: barChartData6,
                    options: options6
                });
                $('#loading_purple').hide();
            }
        });
    }
    function update(tahun,bulan,hari){
        var url = base_url + 'sg/GrafikPencapaian/getData/' + tahun + '/' + bulan + '/' + hari;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function(datas){
                chartBar1.data.labels = datas['labels'];
                chartBar1.data.datasets[0].data = datas['realisasi'];
                chartBar1.data.datasets[1].data = datas['target_hari'];
                chartBar1.data.datasets[2].data = datas['target_bulan'];
                chartBar2.data.labels = datas['labels'];
                chartBar2.data.datasets[0].data = datas['harian_max'];
                chartBar2.data.datasets[2].data = datas['target'];
                chartBar2.data.datasets[0].pointBorderColor = datas['warna'];
                chartBar2.data.datasets[0].pointBackgroundColor = datas['warna'];
                chartBar3.data.datasets[0].data = datas['bag']['realisasi'];
                chartBar3.data.datasets[1].data = datas['bag']['target_hari'];
                chartBar3.data.datasets[2].data = datas['bag']['target_bulan'];
                chartBar4.data.datasets[0].data = datas['bulk']['realisasi'];
                chartBar4.data.datasets[1].data = datas['bulk']['target_hari'];
                chartBar4.data.datasets[2].data = datas['bulk']['target_bulan'];
                chartBar5.data.datasets[0].data = datas['bag']['harian_max'];
                chartBar5.data.datasets[2].data = datas['bag']['target'];
                chartBar5.data.datasets[0].pointBorderColor = datas['bag']['warna'];
                chartBar5.data.datasets[0].pointBackgroundColor = datas['bag']['warna'];
                chartBar6.data.datasets[0].data = datas['bulk']['harian_max'];
                chartBar6.data.datasets[2].data = datas['bulk']['target'];
                chartBar6.data.datasets[0].pointBorderColor = datas['bulk']['warna'];
                chartBar6.data.datasets[0].pointBackgroundColor = datas['bulk']['warna'];
                chartBar1.update();
                chartBar2.update();
                chartBar3.update();
                chartBar4.update();
                chartBar5.update();
                chartBar6.update();
                $('#loading_purple').hide();
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
        var n = month[d.getUTCMonth()];
        $('#loading_purple').hide();
        $('#tahun').val(d.getUTCFullYear());
        $('#bulan').val(n);
        
        var tahun = $('#tahun').val();
        var bulan = $('#bulan').val();
        var hari = d.getUTCDate()+'';
        if(hari.length == 1){            
            hari = '0'+hari;
        }
        chart(tahun, bulan, hari);
        $('#filter').click(function(){
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            var hari = getLastDate(tahun,bulan);
            if (tahun == d.getUTCFullYear() && bulan == month[d.getUTCMonth()]) {
                hari = d.getUTCDate()+'';
            }
            if(hari.length == 1){            
                hari = '0'+hari;
            }
            //alert(tahun+'-'+bulan+'-'+hari);
            update(tahun,bulan,hari);
        });
    });
</script>
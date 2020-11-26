<style>
    .ibox-title.title-desc, .panel-heading {
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
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <h2 style="text-align: center; font-weight: bold;"><i class="fa fa-line-chart" style="color: #fff;"></i>&nbsp;<span class="text-navy" style="color: #fff;">Stok Per Area (<span id="judulTgl"></span>)</span></h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4" style="">
                            <div class="col-md-2"><img src="//10.15.5.150/dev/scm/assets/img/menu/semen_gresik.png" style="width:90px;"></div>
                            <div class="col-md-10"><h2 style="text-align:left;line-height: 220%;padding-left: 30px;"><b>SEMEN GRESIK</b></h2></div>
                            </div>
                      <div class="col-md-4" style="    margin-top: 26px;">
                        <select id="history" class="form-control">
                            <option value="1">Sehari Sebelumnya</option>
                            <option value="2">7 Hari Sebelumnya</option>
                            <option value="3">14 Hari Sebelumnya</option>
                            <option value="4">1 Bulan Sebelumnya</option>
                        </select>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <canvas id="chart1" height="200"></canvas>
                            <div class="tooltip" id="tooltip1"></div>
                        </div>
                        <div class="col-md-6">
                            <canvas id="chart2" height="200"></canvas>
                            <div class="tooltip" id="tooltip2"></div>
                        </div>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <canvas id="chart3" height="200"></canvas>
                            <div class="tooltip" id="tooltip3"></div>
                        </div>
                        <div class="col-md-6">
                            <canvas id="chart4" height="200"></canvas>
                            <div class="tooltip" id="tooltip4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var chartBar1, chartBar2, chartBar3, chartBar4;
    function formatAngka(n) {
        var num = parseInt(n);
        return (num + '').replace(/(\d)(?=(\d{3})+$)/g, '$1.');
    }

    function chart() {
        var ctx1 = document.getElementById('chart1').getContext("2d");
        var ctx2 = document.getElementById('chart2').getContext("2d");
        var ctx3 = document.getElementById('chart3').getContext("2d");
        var ctx4 = document.getElementById('chart4').getContext("2d");
        var url = base_url + 'sg/CrmGudangService/dataStokAwal';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (datas) {
                $('#judulTgl').html(datas['tanggal']);
                var data = {
                    labels: datas['today']['0']['labels'],
                    datasets: [{
                            label: 'Stok hari ini',
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
                            data: datas['today']['0']['stok']
                        }, {
                            type: 'line',
                            label: 'Stok sebelumnya',
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "#0c0",
                            borderColor: "rgba(75,192,192,0)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "#0c0",
                            pointBackgroundColor: "#0c0",
                            pointBorderWidth: 10,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "#0c0",
                            pointHoverBorderColor: "#0c0",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: datas['yesterday']['0']['stok']
                        }
                    ]
                };
                var options = {
                    responsive: true,
                    responsiveAnimationDuration: 1000,
                    title: {
                        display: true,
                        text: 'PROVINSI JATIM'
                    },
                    legend: {
                        display: true
                    },
                    hover: {
                        mode: 'label'
                    },
                    scales: {
                        xAxes: [{
                                display: true
                            }],
                        yAxes: [{
                                display: true,
                                ticks: {
                                    suggestedMin: 0
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
                    data: data,
                    options: options
                });

                var data = {
                    labels: datas['today']['1']['labels'],
                    datasets: [{
                            label: 'Stok hari ini',
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
                            data: datas['today']['1']['stok']
                        }, {
                            type: 'line',
                            label: 'Stok sebelumnya',
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "#0c0",
                            borderColor: "rgba(75,192,192,0)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "#0c0",
                            pointBackgroundColor: "#0c0",
                            pointBorderWidth: 10,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "#0c0",
                            pointHoverBorderColor: "#0c0",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: datas['yesterday']['1']['stok']
                        }
                    ]
                };
                var options = {
                    responsive: true,
                    responsiveAnimationDuration: 1000,
                    title: {
                        display: true,
                        text: 'PROVINSI JATENG & DIY'
                    },
                    legend: {
                        display: true
                    },
                    hover: {
                        mode: 'label'
                    },
                    scales: {
                        xAxes: [{
                                display: true
                            }],
                        yAxes: [{
                                display: true,
                                ticks: {
                                    suggestedMin: 0
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
                chartBar2 = Chart.Bar(ctx2, {
                    data: data,
                    options: options
                });

                var data = {
                    labels: datas['today']['2']['labels'],
                    datasets: [{
                            label: 'Stok hari ini',
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
                            data: datas['today']['2']['stok']
                        }, {
                            type: 'line',
                            label: 'Stok sebelumnya',
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "#0c0",
                            borderColor: "rgba(75,192,192,0)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "#0c0",
                            pointBackgroundColor: "#0c0",
                            pointBorderWidth: 10,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "#0c0",
                            pointHoverBorderColor: "#0c0",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: datas['yesterday']['2']['stok']
                        }
                    ]
                };
                var options = {
                    responsive: true,
                    responsiveAnimationDuration: 1000,
                    title: {
                        display: true,
                        text: 'PROVINSI JABAR DKI & BANTEN'
                    },
                    legend: {
                        display: true
                    },
                    hover: {
                        mode: 'label'
                    },
                    scales: {
                        xAxes: [{
                                display: true
                            }],
                        yAxes: [{
                                display: true,
                                ticks: {
                                    suggestedMin: 0
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
                chartBar3 = Chart.Bar(ctx3, {
                    data: data,
                    options: options
                });

                var data = {
                    labels: ['BALI', '', '', '', '', '', ''],
                    datasets: [{
                            label: 'Stok hari ini',
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
                            data: datas['today']['3']['stok']
                        }, {
                            type: 'line',
                            label: 'Stok sebelumnya',
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "#0c0",
                            borderColor: "rgba(75,192,192,0)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "#0c0",
                            pointBackgroundColor: "#0c0",
                            pointBorderWidth: 10,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "#0c0",
                            pointHoverBorderColor: "#0c0",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: datas['yesterday']['3']['stok']
                        }
                    ]
                };
                var options = {
                    responsive: true,
                    responsiveAnimationDuration: 1000,
                    title: {
                        display: true,
                        text: 'PROVINSI BALI NUSRA'
                    },
                    legend: {
                        display: true
                    },
                    hover: {
                        mode: 'label'
                    },
                    scales: {
                        xAxes: [{
                                display: true
                            }],
                        yAxes: [{
                                display: true,
                                ticks: {
                                    suggestedMin: 0
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
                chartBar4 = Chart.Bar(ctx4, {
                    data: data,
                    options: options
                });
                $('#loading_purple').hide();
            }
        });
    }

    function update1(n) {
        var url = base_url + 'sg/CrmGudangService/dataStok/' + n;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (datas) {
                chartBar1.data.datasets[1].data = datas['0']['stok'];
                chartBar2.data.datasets[1].data = datas['1']['stok'];
                chartBar3.data.datasets[1].data = datas['2']['stok'];
                chartBar4.data.datasets[1].data = datas['3']['stok'];
                chartBar1.update();
                chartBar2.update();
                chartBar3.update();
                chartBar4.update();
                $('#loading_purple').hide();
            }
        });
    }
    $(function () {
        $('#history').change(function () {
            var n = $('#history').val();
            update1(n);
        });
        //chart1();
        chart();
    });
</script>

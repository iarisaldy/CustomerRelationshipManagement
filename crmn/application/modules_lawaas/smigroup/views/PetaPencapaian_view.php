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
        height: 200px;
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
</style>
<div id="loading_purple"></div>
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="col-md-1"></div>
            <div class="col-md-3" style="margin-top: 1.8%; border-right: #005fbf; border-right-style: dotted;border-right-width: thin;">
                <select id="org" class="form-control">
                    <option value="1">SMI Group</option>
                    <option value="7000">Semen Gresik</option>
                    <option value="3000">Semen Padang</option>
                    <option value="4000">Semen Tonasa</option>
                    <option value="6000">TLCC</option>
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


<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts-jquery-plugin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.maps.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/maps/fusioncharts.indonesia.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
<!--<script src="<?= base_url('assets/chartjs/dist/Chart.js') ?>" type="text/javascript"></script>-->
<!--<script src="http://www.chartjs.org/dist/2.7.1/Chart.bundle.js"></script>-->
<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.bundle_1.js"></script>
<script>

    var Chart1, Chart2;
    var ctx1 = document.getElementById("Chart");
    var ctx2 = document.getElementById("Chart2");
    var org = 1;
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
        var url = base_url + 'smigroup/PetaPencapaian/scodata/' + org + '/' + tahun + '/' + bulan;
        //console.log('ini urlnya '+ ' => '+url);
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
//                $('#summary').hide();
//                $('#Vsummary').hide();
            },
            success: function (data) {
                peta = new FusionCharts("maps/indonesia", "chartobject-1", "100%", "500", "chart1", "json");
                peta.setChartData(data['data']);
                peta.addEventListener("entityClick", function (e, d) {
                    getDetail(d.id);
                    console.log(d);
                });
//                peta.addEventListener("entityRollOut", function (e, d) {
//                    $('#chart1').attrFusionCharts({
//                        "showToolTip": "0"
//                    });
//                });
                peta.render("chart1");
                $('#loading_purple').hide();
                if (is_mobile()) {
                    //$('#summary').hide();
                    $('#summary').removeClass('summary');
                    $('#summary').addClass('font-kecil');
                   // $('#summary').show();
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
        var url = base_url + 'smigroup/PetaPencapaian/scodata/' + org + '/' + tahun + '/' + bulan;
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

                if (org == 1) {
                    $('#realSMIG').html(formatAngka(Math.round(data['realSMIG'])));
                    $('#realSG').html(formatAngka(Math.round(data['realSG'])));
                    $('#realSP').html(formatAngka(Math.round(data['realSP'])));
                    $('#realST').html(formatAngka(Math.round(data['realST'])));
                    $('#rkapSMIG').html(formatAngka(Math.round(data['rkapSMIG'])));
                    $('#rkapSG').html(formatAngka(Math.round(data['rkapSG'])));
                    $('#rkapSP').html(formatAngka(Math.round(data['rkapSP'])));
                    $('#rkapST').html(formatAngka(Math.round(data['rkapST'])));
                    $('#persenRealSMIG').html(data['persenRealSMIG'] + ' %');
                    $('#persenRealSG').html(data['persenRealSG'] + ' %');
                    $('#persenRealSP').html(data['persenRealSP'] + ' %');
                    $('#persenRealST').html(data['persenRealST'] + ' %');
                    $('#persenRKAPSMIG').html(data['persenRKAPSMIG'] + ' %');
                    $('#persenRKAPSG').html(data['persenRKAPSG'] + ' %');
                    $('#persenRKAPSP').html(data['persenRKAPSP'] + ' %');
                    $('#persenRKAPST').html(data['persenRKAPST'] + ' %');
                    $('#persenRealSMIG').removeClass();
                    $('#persenRealSG').removeClass();
                    $('#persenRealSP').removeClass();
                    $('#persenRealST').removeClass();
                    $('#persenRKAPSMIG').removeClass();
                    $('#persenRKAPSG').removeClass();
                    $('#persenRKAPSP').removeClass();
                    $('#persenRKAPST').removeClass();
                    $('#persenRealSMIG').addClass(formatWarna(data['persenRealSMIG']));
                    $('#persenRealSG').addClass(formatWarna(data['persenRealSG']));
                    $('#persenRealSP').addClass(formatWarna(data['persenRealSP']));
                    $('#persenRealST').addClass(formatWarna(data['persenRealST']));
                    $('#persenRKAPSMIG').addClass(formatWarnaRKAP(data['persenRKAPSMIG'], param));
                    $('#persenRKAPSG').addClass(formatWarnaRKAP(data['persenRKAPSG'], param));
                    $('#persenRKAPSP').addClass(formatWarnaRKAP(data['persenRKAPSP'], param));
                    $('#persenRKAPST').addClass(formatWarnaRKAP(data['persenRKAPST'], param));
                }
            }
        });
    }

    function getSummary() {
        var baru = new Date(tahun, d.getUTCMonth() + 2, 0);
        var tglSkrg = d.getUTCDate();
        var tglAkhir = baru.getUTCDate();
        var param = (tglSkrg / tglAkhir) * 100;
        var url = base_url + 'smigroup/PetaPencapaian/getSummary/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            dataType: 'json',
            success: function (data) {
                $('#bulansummary').html($('#bulan option:selected').text().toUpperCase());

                $('#realSMIG').html(formatAngka(data['realSMIG']));
                $('#realSG').html(formatAngka(data['realSG']));
                $('#realSP').html(formatAngka(data['realSP']));
                $('#realST').html(formatAngka(data['realST']));
                $('#rkapSMIG').html(formatAngka(data['rkapSMIG']));
                $('#rkapSG').html(formatAngka(data['rkapSG']));
                $('#rkapSP').html(formatAngka(data['rkapSP']));
                $('#rkapST').html(formatAngka(data['rkapST']));
                $('#persenRealSMIG').html(data['persenRealSMIG'] + ' %');
                $('#persenRealSG').html(data['persenRealSG'] + ' %');
                $('#persenRealSP').html(data['persenRealSP'] + ' %');
                $('#persenRealST').html(data['persenRealST'] + ' %');
                $('#persenRKAPSMIG').html(data['persenRKAPSMIG'] + ' %');
                $('#persenRKAPSG').html(data['persenRKAPSG'] + ' %');
                $('#persenRKAPSP').html(data['persenRKAPSP'] + ' %');
                $('#persenRKAPST').html(data['persenRKAPST'] + ' %');
                $('#persenRealSMIG').removeClass();
                $('#persenRealSG').removeClass();
                $('#persenRealSP').removeClass();
                $('#persenRealST').removeClass();
                $('#persenRKAPSMIG').removeClass();
                $('#persenRKAPSG').removeClass();
                $('#persenRKAPSP').removeClass();
                $('#persenRKAPST').removeClass();
                $('#persenRealSMIG').addClass(formatWarna(data['persenRealSMIG']));
                $('#persenRealSG').addClass(formatWarna(data['persenRealSG']));
                $('#persenRealSP').addClass(formatWarna(data['persenRealSP']));
                $('#persenRealST').addClass(formatWarna(data['persenRealST']));
                $('#persenRKAPSMIG').addClass(formatWarnaRKAP(data['persenRKAPSMIG'], param));
                $('#persenRKAPSG').addClass(formatWarnaRKAP(data['persenRKAPSG'], param));
                $('#persenRKAPSP').addClass(formatWarnaRKAP(data['persenRKAPSP'], param));
                $('#persenRKAPST').addClass(formatWarnaRKAP(data['persenRKAPST'], param));

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
                tooltips: {
                    mode: 'label',
                    intersect: true
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

    function getDetail(prov) {
        ctx1 = document.getElementById("Chart");
        ctx2 = document.getElementById("Chart2");
        var url = base_url + 'smigroup/PetaPencapaian/getChart/' + org + '/' + prov + '/' + tahun + '/' + bulan;

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#pleasewait').css('display', 'block');
            },
            success: function (datas) {
                $('#pleasewait').css('display', 'none');
                if (org == 1) {
                    $('#textFooter').html('* Untuk melihat detail bag and bulk, pilih menu per opco');
                    var lineChartData = {
                        labels: datas['tanggal'],
                        datasets: [{
                                type: "line",
                                label: "RKAP",
                                data: datas['target'],
                                fill: false,
                                lineTension: 0,
                                borderColor: '#98210f',
                                backgroundColor: '#98210f'
                            }, {
                                label: "REAL SG",
                                data: datas['sg']['real'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgb(26, 188, 156)',
                                backgroundColor: 'rgb(26, 188, 156)'
                            }, {
                                label: "REAL ST",
                                data: datas['st']['real'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgb(255, 195, 0)',
                                backgroundColor: 'rgb(255, 195, 0)'
                            }, {
                                label: "REAL SP",
                                data: datas['sp']['real'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgb(218, 247, 166)',
                                backgroundColor: 'rgb(218, 247, 166)'
                            }]
                    };
                } else {
                    $('#textFooter').html();
                    var lineChartData = {
                        labels: datas['tanggal'],
                        datasets: [{
                                type: "line",
                                label: "RKAP",
                                data: datas['target'],
                                fill: false,
                                lineTension: 0,
                                borderColor: '#98210f',
                                backgroundColor: '#98210f'
                            }, {
                                label: "REAL BULK",
                                data: datas['real_bulk'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgb(26, 188, 156)',
                                backgroundColor: 'rgb(26, 188, 156)'
                            }, {
                                label: "REAL BAG",
                                data: datas['real_bag'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgba(255, 165, 0, 1)',
                                backgroundColor: 'rgba(255, 165, 0, 1)'
                            }]
                    };
                }

                var lineChartData2 = {
                    labels: datas['tanggal'],
                    datasets: [{
                            type: "line",
                            label: "RKAP",
                            data: datas['target_ak'],
                            fill: false,
                            lineTension: 0,
                            borderColor: '#98210f',
                            backgroundColor: '#98210f'
                        }, {
                            type: "line",
                            label: "REAL",
                            data: datas['real_ak'],
                            fill: false,
                            lineTension: 0,
                            //pointRadius: datas['data']['RADIUS'],
                            //pointBorderColor: datas['data']['WARNA'],
                            //pointBackgroundColor: datas['data']['WARNA'],
                            borderColor: 'rgba(255, 165, 0, 1)',
                            backgroundColor: 'rgba(255, 165, 0, 1)'
                        }]
                };

                Chart1.destroy();
                Chart2.destroy();

                Chart1 = new Chart.Bar(ctx1, {
                    data: lineChartData,
                    options: {
                        title: {
                            display: true,
                            text: 'Realisasi Penjualan ' + datas['nm_prov']
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                afterTitle: function () {
                                    window.total = 0;
                                },
                                label: function (tooltipItem, data) {
                                    var lbl = data.datasets[tooltipItem.datasetIndex].label;
                                    var valor = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    if (lbl != 'RKAP')
                                        window.total += Math.round(valor);
                                    return lbl + ": " + Math.round(valor).toString();
                                },
                                footer: function () {
                                    return "TOTAL REAL: " + window.total.toString();
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    stacked: true,
                                }],
                            yAxes: [{
                                    stacked: true
                                }]
                        },
                        legend: {
                            display: true
                        },

                    }
                });

                Chart2 = new Chart.Bar(ctx2, {
                    type: 'line',
                    data: lineChartData2,
                    options: {
                        title: {
                            display: true,
                            text: 'Akumulasi Realisasi Penjualan ' + datas['nm_prov']
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
                                            return formatAngka(value);
                                        }
                                    }
                                }]
                        },
                        legend: {
                            display: true
                        },

                    }
                });
                $('#modalChart').modal('show');

            }
        });
    }

    $(function () {
        org = '1';
        peta();
        getSummary();
        $('#tahun').val(tahun);
        $('#bulan').val(bulan);
        $('#bulansummary').html($('#bulan option:selected').text().toUpperCase());
        $('#org').change(function () {
            org = $('#org').val();
            if (org == '6000') {
                Vpeta();
                VsumSales(tahun, bulan);
                VupdatePeta(org, tahun, bulan);
                $('.summary').css('height', '100px');
            } else {
                $('.summary').css('height', '200px');
                if (org == "1") {
                    peta();
                } else {
                    peta();
                    updatePeta();
                }
            }
            /*                if(org == '6000'){
             Vpeta();
             VsumSales(tahun, bulan);
             VupdatePeta(org, tahun, bulan);
             }else{
             peta();
             updatePeta();
             }*/
        });
        $('#filter').click(function () {
            tahun = $('#tahun').val();
            bulan = $('#bulan').val();
            org = $('#org').val();
            if (org == '6000') {
                Vpeta();
                VsumSales(tahun, bulan);
                VupdatePeta(org, tahun, bulan);
            } else {
                peta();
                updatePeta();
                getSummary();
            }
        });
        $('#resume_btn').click(function(){
           if($('#summary').is(":visible")){
               $('#resume_btn').text('Show Summary');
               $('#summary').fadeOut();
           } else{
               $('#resume_btn').text('Hide Summary');
               $('#summary').fadeIn();
           }
        });
        setChart();
    });
    //
    function Vpeta() {
        var peta;
        var url = base_url + 'tlcc/SalesRealization/getData/' + org + '/' + tahun + '/' + bulan;
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
                peta = new FusionCharts("maps/vietnam", "chartobject-1", "100%", "650", "chart1", "json");
                peta.setChartData(data);
                peta.render("chart1");
                $('#loading_purple').hide();

                if (is_mobile()) {
                    $('#Vsummary').hide();
                    $('#Vsummary').removeClass('summary');
                    //$('#summary').show();
                } else {
                    $('#Vsummary').show();
                    $('#summary').hide();
                    // $('#Vsummary').hide();
                }
                //$('.summary').show();
            }
        });
    }

    function VupdatePeta(org, tahun, bulan) {
        var dataPeta;
        var url = base_url + 'tlcc/SalesRealization/getData/' + org + '/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $('#chart1').updateFusionCharts({"dataSource": data, "dataFormat": "json"});
                $('#loading_purple').hide();
            }
        });
    }

    function VsumSales(tahun, bulan) {
        var bulanText = ['', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];

        var url = base_url + 'tlcc/SalesRealization/sumSales/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (data) {
                $('#Vbulansummary').html(bulanText[parseInt(bulan)]);
                $('#VrealSMIG').html(data.REAL_SDK);
                $('#VrkapSMIG').html(data.RKAP);
                $('#VpersenRealSMIG').html(data.PERSEN_SDK + '%');
                $('#VpersenRKAPSMIG').html(data.PERSEN + '%');
            }
        });
    }

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
<div class="summary-back">
    <button id='resume_btn' style="margin-bottom: 7px" class="btn btn-sm btn-info" >Show Summary</button>
    <div style="display: none" class="summary" id="summary" >
        <div style="text-align: center"><b>SUMMARY DOMESTIC SALES <span id="bulansummary"></span></b></div>
        <table class="table table-hover border-bottom center" style="text-align: center">
            <thead>
                <tr class="info">
                    <th>COMPANY</th>
                    <th>REAL UP TO YESTERDAY (TON)</th>
                    <th>RKAP (TON)</th>
                    <th>REAL UP TO YESTERDAY (%)</th>
                    <th>REAL / RKAP (%)</th>
                </tr>            
            </thead>
            <tbody>
                <tr>
                    <td>SMIG</td>
                    <td><span id="realSMIG"></span></td>
                    <td><span id="rkapSMIG"></span></td>
                    <td><span id="persenRealSMIG"></span></td>
                    <td><span id="persenRKAPSMIG"></span></td>
                </tr>
                <tr>
                    <td>SG</td>
                    <td><span id="realSG"></span></td>
                    <td><span id="rkapSG"></span></td>
                    <td><span id="persenRealSG"></span></td>
                    <td><span id="persenRKAPSG"></span></td>
                </tr>
                <tr>
                    <td>SP</td>
                    <td><span id="realSP"></span></td>
                    <td><span id="rkapSP"></span></td>
                    <td><span id="persenRealSP"></span></td>
                    <td><span id="persenRKAPSP"></span></td>
                </tr>
                <tr>
                    <td>ST</td>
                    <td><span id="realST"></span></td>
                    <td><span id="rkapST"></span></td>
                    <td><span id="persenRealST"></span></td>
                    <td><span id="persenRKAPST"></span></td>
                </tr>
            </tbody>     
        </table>
        <!--    <div class="footer-summary">
                <div>Total Demand <span class="pull-right">20% </span></div>
                <div>MoM <span class="pull-right">20% <i class="fa fa-level-up"></i></span></div>
                <div>YoY <span class="pull-right">20% <i class="fa fa-level-down"></i></span></div>
            </div>    -->
    </div>
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
    <div style="text-align: center"><b>SUMMARY DOMESTIC SALES <span id="Vbulansummary"></span></b><span class="pull-right"> <i class="fa fa-close"></i></span></div>
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
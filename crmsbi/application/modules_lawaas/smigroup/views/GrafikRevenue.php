<style>
    #loading_purple {
        position:fixed;
        top:0;
        left:0;
        background:url('<?php echo base_url(); ?>assets/img/loading.gif')no-repeat center center;
        z-index:1;
        text-align:center;
        width:100%;
        height:100%;
        padding-top:70px;
        font:bold 50px Calibri,Arial,Sans-Serif;
        color:#000;
        display:none;
    }

    .footer{
        position: fixed;
    }

    .small-box {
        border-radius: 5px;
        position: relative;
        display: block;
        margin-bottom: 10px;
        margin-top: 12px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    }

    .small-box>.inner {
        padding: 10px !important;
        overflow:hidden;

    }

    .small-box>.inner>h1 {
        margin: 0px;
        font-weight: 600;
        padding-left: 7% !important;
        font-size: 28px;
    }
    .small-box>.inner>p {
        margin: 0 !important;
    }

    .bg-aqua, .callout.callout-info, .alert-info, .label-info, .modal-info .modal-body {
        background-color: #00c0ef !important;
    }

    .bg-green, .callout.callout-success, .alert-success, .label-success, .modal-success .modal-body {
        background-color: #01d876 !important;
    }
    .bg-yellow, .callout.callout-warning, .alert-warning, .label-warning, .modal-warning .modal-body {
        background-color: #f39c12 !important;
    }

    .bg-red, .callout.callout-danger, .alert-danger, .alert-error, .label-danger, .modal-danger .modal-body {
        background-color: #fc6957 !important;
    }

    .small-box .icon {
        -webkit-transition: all .3s linear;
        -o-transition: all .3s linear;
        transition: all .3s linear;
        position: absolute;
        top: -10px;
        right: 10px;
        z-index: 0;
        font-size: 90px;
        color: rgba(0,0,0,0.15);
    }

    .small-box>.small-box-footer {
        position: relative;
        text-align: center;
        padding: 3px 0;
        color: #fff;
        color: rgba(255,255,255,0.8);
        display: block;
        z-index: 10;
        background: rgba(0,0,0,0.1);
        text-decoration: none;
    }

    .ibox-title.title-desc,.panel-heading {
        background: linear-gradient(to left, #1ab394, #036C13);
    }
    .text-legend{
        padding-left: 5px;
        padding-right:20px;

    }
    hr {
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .circle {
        width: 13px;
        height: 13px;
        -moz-border-radius: 50px;
        -webkit-border-radius: 50px;
        border-radius: 50px;
        display: -webkit-inline-box;
    }
    #grafik_panel {
        position: relative;
        width: 131%;
        right: 14%;
        margin-top: 0%;
        height: 100%;
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

    .input-group-addon {
        background-color: #e1e1e1;
        border: 1px solid #E5E6E7;
    }
    .input-sm{
        padding: 3px 6px !important;
    }
    hr {
        margin-top: 10px;
        margin-bottom: 10px;
    }
    h4 {
        font-size: 18px;
    }
    .panel-body {
        padding: 5px;
    }
    .top-navigation .wrapper.wrapper-content {
        padding: 0px;
    }
</style>

<!--<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.bundle.js"></script>-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div class="row" id="grafik_panel">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <h4><span class="text-navy" fo style="color:#ffffff"><i class="fa fa-bar-chart-o"></i> Grafik Revenue</span></h4>
            </div>
            <div class="panel-body">

                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <select id="bulan1" class="form-control input-sm" name="bulan">
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
                            <select id="tahun1" class="form-control input-sm" name="tahun">
                                <?php
                                for ($i = 2016; $i <= date("Y"); $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select id="filter1" class="form-control input-sm" name="filter1">
                                <option selected value="all">All</option>
                                <option value="domestik">Domestik</option>
                                <option value="ekspor">Ekspor</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button id="filter1" class="btn btn-success btn-sm" style="margin-top:0px" onclick="updateHarian();"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col-md-2 ">
                            <button id="filter1" class="btn btn-success btn-sm pull-right" style="margin-top:0px" onclick="updatePencBulanan();"><i class="fa fa-search"></i></button>
                            <div class="button-group pull-right" style="padding-right: 10%" >
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-check"></span> Company<span class="caret"></span></button>
                                <ul class="dropdown-menu dd1">
                                    <li><a href="#" class="small" data-value="3000" tabIndex="-1"><input type="checkbox"/>&nbsp;Semen Padang</a></li>
                                    <li><a href="#" class="small" data-value="4000" tabIndex="-1"><input type="checkbox"/>&nbsp;Semen Tonasa</a></li>
                                    <li><a href="#" class="small" data-value="5000" tabIndex="-1"><input type="checkbox"/>&nbsp;Semen Gresik</a></li>
                                    <li><a href="#" class="small" data-value="6000" tabIndex="-1"><input type="checkbox"/>&nbsp;TLCC</a></li>
                                    <li><a href="#" class="small" data-value="7000" tabIndex="-1"><input type="checkbox"/>&nbsp;KSO - SG</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-10">
                        <div class="col-md-6">
                            <div id="container1" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
                            <div class="tooltip" id="tooltip1"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="container2" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
                            <div class="tooltip" id="tooltip2"></div>
                        </div>
                    </div>
                    <div class="col-md-2" style="padding-left: 0px">
                        <div id="container5" style="height: 300px;"></div>
                        <div class="legend5" id="legend5" ></div>
                        <!--                        <div class="col-md-12">
                                                    <div class="small-box bg-aqua">
                                                        <a href="#" class="small-box-footer">Pencapaian Bulan ini sd tgl <?= date('d', strtotime("-1 days")); ?></a>
                                                        <div class="inner">
                                                            <p>IDR</p>
                                                            <h1 id="pencBulanan">0</h1>
                                                            <p class="pull-right"><strong id="pencBulanan_persen">.</strong></p>
                        
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-bag"></i>
                                                        </div>
                        
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="small-box bg-green">
                                                        <a href="#" class="small-box-footer">Gap Bulan ini sd tgl <?= date('d', strtotime("-1 days")); ?></a>
                                                        <div class="inner">
                                                            <p>IDR</p>
                                                            <h1 id="gapBulanan">0</h1>
                                                            <p class="pull-right"><strong >.</strong></p>
                        
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-bag"></i>
                                                        </div>
                        
                                                    </div>
                                                </div>-->
                    </div>
                </div><br/>   
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4">
                            <div class="input-daterange input-group" id="datepicker">
                                <select id="year1" class="form-control input-sm" name="year1">
                                    <?php
                                    for ($i = 2016; $i <= date("Y"); $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-group-addon input-sm">compare</span>
                                <select id="year2" class="form-control input-sm" name="year2">
                                    <?php
                                    for ($i = 2016; $i <= date("Y"); $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <select id="filter2" class="form-control input-sm" name="filter2">
                                <option selected value="all">All</option>
                                <option value="domestik">Domestik</option>
                                <option value="ekspor">Ekspor</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button id="" onclick="updateBulanan()" class="btn btn-success btn-sm" style="margin-top:0px"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col-md-2">
                            <button id="filter1" class="btn btn-success btn-sm pull-right" style="margin-top:0px" onclick="updatePencTahunan();"><i class="fa fa-search"></i></button>

                            <div class="button-group pull-right" style="padding-right: 10%"  >
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-check"></span> Company<span class="caret"></span></button>
                                <ul class="dropdown-menu dd2">
                                    <li><a href="#" class="small" data-value="3000" tabIndex="-1"><input type="checkbox"/>&nbsp;Semen Padang</a></li>
                                    <li><a href="#" class="small" data-value="4000" tabIndex="-1"><input type="checkbox"/>&nbsp;Semen Tonasa</a></li>
                                    <li><a href="#" class="small" data-value="5000" tabIndex="-1"><input type="checkbox"/>&nbsp;Semen Gresik</a></li>
                                    <li><a href="#" class="small" data-value="6000" tabIndex="-1"><input type="checkbox"/>&nbsp;TLCC</a></li>
                                    <li><a href="#" class="small" data-value="7000" tabIndex="-1"><input type="checkbox"/>&nbsp;KSO - SG</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-10">
                        <div class="col-md-6">
                            <div id="loading_purple"></div>
                            <div id="container3" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
                            <div class="legend3" id="legend3"></div>
                        </div>
                        <div class="col-md-6">

                            <div id="container4" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
                            <div class="legend4" id="legend4"></div>
                        </div>
                    </div>
                    <div class="col-md-2" style="padding-left: 0px">

                        <div id="container6" style="min-width: 150px; height: 300px;"></div>
                        <div class="legend6" id="legend6" ></div>
                        <!--                            <div class="small-box bg-yellow">
                                                        <a href="#" class="small-box-footer">Pencapaian Tahun ini sd <?= $bulan[date('m')] ?> tgl <?= date('d', strtotime("-1 days")); ?></a>
                                                        <div class="inner">
                                                            <p>IDR</p>
                                                            <h1 id="pencTahunan">0</h1>
                                                            <p class="pull-right"><strong id="pencTahunan_persen">IDR</strong></p>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-bag"></i>
                                                        </div>
                        
                                                    </div>-->


                    </div>
                </div><br/>   
                <hr>
            </div>
        </div>
    </div>
</div>
<script>
    var options = [];
    var options2 = [];
    var bulanText = {
        '01': 'Januari',
        '02': 'Februari',
        '03': 'Maret',
        '04': 'April',
        '05': 'Mei',
        '06': 'Juni',
        '07': 'Juli',
        '08': 'Agustus',
        '09': 'September',
        '10': 'Oktober',
        '11': 'November',
        '12': 'Desember',
    };


    function setTheme() {
        Highcharts.theme = {
            colors: ['#7cb5ec', '#f7a35c', '#90ee7e', '#7798BF', '#eeaaee', '#ff0066',
                '#aaeeee', '#55BF3B', '#DF5353', '#2b908f', '#f45b5b', '#7798BF', '#aaeeee'],
            chart: {
                backgroundColor: null,
                style: {
                    fontFamily: 'Dosis, sans-serif'
                }
            },
            title: {
                style: {
                    fontSize: '13px',
                    fontWeight: 'bold',
                    textTransform: 'uppercase'
                }
            },
            tooltip: {

                borderWidth: 0,
                backgroundColor: 'rgb(219,219,216)',
                shadow: false
            },
            legend: {
                itemStyle: {
                    fontWeight: 'bold',
                    fontSize: '13px'
                }
            },
            xAxis: {
                gridLineWidth: 1,
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yAxis: {
                minorTickInterval: 'auto',
                title: {
                    style: {
                        textTransform: 'uppercase'
                    }
                },
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                },
                stackLabels: {
                    allowOverlap: true,
                    rotation: -90,
                    x: 3,
                    y: -15,
                    enabled: true,
                    formatter: function () {
                        return  this.stack;
                    }
                }
            },
            plotOptions: {
                candlestick: {
                    lineColor: '#404048'
                }
            },

            // General
            background2: '#F0F0EA'

        };

// Apply the theme
        Highcharts.setOptions(Highcharts.theme);

    }
    function chart(id, title, x, data, lgd, tooltip = false, valx) {
        Highcharts.chart(id, {
            chart: {
                type: 'column'
            },
            title: {
                text: title
            },
            legend: {
                enabled: lgd
            },

            xAxis: {

                categories: x
            },

            credits: {
                enabled: false
            },
            yAxis: {
                labels: {
                    formatter: function () {
                        if (valx == 'M') {
                            return this.value + ' M';
                        } else if (valx == 'T') {
                            return this.value / 1000 + ' T';
                        } else {
                            return this.value;
                        }

                    },
                },
                min: 0,
                title: {
                    text: 'Revenue'
                }
            },
            tooltip: {
//                valueSuffix: ' M',
//                footerFormat: 'Total: <b>{point.total}</b>',
                formatter: function () {
                    if (tooltip) {
                        var s = '<b>' + this.x + '</b>';
                        var gap, percent, rkap, real;
                        $.each(this.points, function (i, point) {
                            if (point.series.name.indexOf('RKAP') == -1) {
                                real = point.y;
                            } else {
                                point.series.color = '#e94e4e';
                                rkap = point.y;
                            }

                            s += '<br/> <span style="color:' + point.series.color + ';font-weight:500">' + point.series.name + '</span>: ' +
                                    point.y.toLocaleString(['ban', 'id']) + ' M<b>';
                        });
                        gap = Math.round(real - rkap, 2);
                        percent = Math.round(real / rkap * 100, 2);
                        s += '<br/> <span style="font-weight:500">Gap</span>: ' +
                                gap.toLocaleString(['ban', 'id']) + ' M<b>';
                        s += '<br/> <span style="font-weight:500">Pencapaian</span>: ' +
                                percent + ' %<b>';
                        return s;
                    } else {
                        var s = '<b>' + this.x + '</b>',
                                sum = 0,
                                sum2 = 0;

                        var stackKey, key, key2;
                        $.each(this.points, function (i, point) {
                            if (point.series.name.indexOf('RKAP') == -1) {
                                if (sum == 0)
                                    stackKey = point.series.stackKey;

                                s += '<br/> <span style="color:' + point.series.color + ';font-weight:500">' + point.series.name + '</span>: ' +
                                        point.y.toLocaleString(['ban', 'id']) + ' M <b> (' + Math.round(point.percentage, 2).toLocaleString(['ban', 'id']) + '%)</b>';
                                if (stackKey == point.series.stackKey) {
                                    key = point.series.stackKey.toString().replace('column', 'Tahun ');
                                    sum = point.total;
                                } else {
                                    key2 = point.series.stackKey.toString().replace('column', 'Tahun ');
                                    sum2 = point.total;
                                }
                            }
                        });
                        if (key2 != undefined) {
                            s += '<br/><b>Total ' + key + ' :</b>' + sum.toLocaleString(['ban', 'id']) + ' M';
                            s += '<br/><b>Total ' + key2 + ' :</b>' + sum2.toLocaleString(['ban', 'id']) + ' M';
                        } else {
                            s += '<br/><b>Total :</b>' + sum.toLocaleString(['ban', 'id']) + ' M';
                        }

                        $.each(this.points, function (i, point) {
                            if (point.series.name.indexOf('RKAP') !== -1) {
                                if (sum == 0)
                                    stackKey = point.series.stackKey;

                                s += '<br/> <span style="color:' + point.series.color + ';font-weight:500">' + point.series.name + '</span>: ' +
                                        point.y.toLocaleString(['ban', 'id']) + ' M<b>';

                            }
                        });
                        return s;
                    }
                },
//                pointFormat: '<strong><span style="color:{series.color}">{series.name}</span></strong>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                column: {
                    //stacking: 'normal',
                    grouping: false,
                    shadow: false,
                    borderWidth: 0
                }
            },
            series: data
        });
    }

    function getMonitoringHarian(date, filter) {
        $.ajax({
            url: '<?= base_url() ?>smigroup/Revenue/getDataGraph/' + date + '/' + filter,
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                $('.dd1 a input').prop('checked', true);
                options = ['3000', '4000', '5000', '6000', '7000'];
                chart('container1', 'Monitoring Harian', data.tanggal, data.stacked, true, false, 'M');
                chart('container2', 'Monitoring Harian Kumulatif', data.tanggal, data.stacked_ak, true, false, 'T');
                var satuan = (data.pencapaian[0].data[0] >= 1000 || data.pencapaian[1].data[0] >= 1000) ? 'T' : 'M';
                var bulan = bulanText[data.date.substring(4, 7)];
                var tahun = data.date.substring(0, 4);
                chart('container5', 'Pencapaian Bulan ' + bulan + ' ' + tahun, ['s.d kemaren'], data.pencapaian, true, true, satuan);
//                $('#pencBulanan').html(Math.round(parseInt(data.pencapaian.REV) / 1000000000).toLocaleString(['ban', 'id']) + 'M');
//                $('#pencBulanan_persen').html(data.pencapaian.PENC + '%');
//                $('#gapBulanan').html(Math.round(parseInt(data.pencapaian.GAP) / 1000000000).toLocaleString(['ban', 'id']) + 'M');
            }
        });
    }

    function getMonitoringTahunan(year1, year2, filter) {
        if (year1 == '' && year2 == '') {
            var d = new Date();
            year1 = d.getFullYear() - 1;
            year2 = d.getFullYear();
        }
        $.ajax({
            url: '<?= base_url() ?>smigroup/Revenue/getDataGraphCompare/' + year1 + '/' + year2 + '/' + filter,
            dataType: 'json',
            beforeSend: function (data) {
                $('#loading_purple').css('display', 'block');
            },
            success: function (data) {
                $('#loading_purple').css('display', 'none');
                $('.dd2 a input').prop('checked', true);
                options2 = ['3000', '4000', '5000', '6000', '7000'];
                chart('container3', 'Monitoring Bulanan', data.BULAN, data.STACKED, true, false, 'T');
                chart('container4', 'Monitoring Bulanan Kumulatif', data.BULAN, data.STACKED_AK, true, false, 'T');

                var tahun = data.YEAR;
                var satuan = (data.PENCAPAIAN[0].data[0] >= 1000 || data.PENCAPAIAN[1].data[0] >= 1000) ? 'T' : 'M';
                chart('container6', 'Pencapaian Tahun ' + tahun, ['s.d kemaren'], data.PENCAPAIAN, true, true, satuan);
                var legend = "<strong><div style='text-align: center;'><div class='circle' style='background-color:#7cb5ec'></div><span class='text-legend'>SP</span>" +
                        "<div class='circle' style='background-color:#f7a35c'></div><span class='text-legend'>ST</span>" +
                        "<div class='circle' style='background-color:#90ee7e'></div><span class='text-legend'>SG</span>" +
                        "<div class='circle' style='background-color:#7798BF'></div><span class='text-legend'>TLCC</span>" +
                        "<div class='circle' style='background-color:#eeaaee'></div><span class='text-legend'>KSO-SG</span>" +
                        "<div class='circle' style='background-color:#ff0066'></div><span class='text-legend'>RKAP " + year1 + "</span>" +
                        "<div class='circle' style='background-color:#55BF3B'></div><span class='text-legend'>RKAP " + year2 + "</span></div></strong>";
//                $('#legend3').html(legend);
//                $('#legend4').html(legend);
//                $('#pencTahunan').html(Math.round(parseInt(data.PENCAPAIAN.REV) / 1000000000).toLocaleString(['ban', 'id']) + 'M');
//                $('#pencTahunan_persen').html(data.PENCAPAIAN.PENC + '%');
//                $('#gapTahunan').html(Math.round(parseInt(data.PENCAPAIAN.GAP) / 1000000000).toLocaleString(['ban', 'id']) + 'M');
            }
        });
    }

    function updateHarian() {

        var tahun = $('#tahun1').val();
        var bulan = $('#bulan1').val();
        var filter = $('#filter1').val();
        getMonitoringHarian(tahun + bulan, filter);
    }

    function updateBulanan() {
        var tahun1 = $('#year1').val();
        var tahun2 = $('#year2').val();
        var filter = $('#filter2').val();
        if (tahun1 != tahun2) {
            getMonitoringTahunan(tahun1, tahun2, filter);
        } else {
            alert('Data Tahun Tidak Boleh Sama');
        }

    }

    function updatePencBulanan() {
        var tahun = $('#tahun1').val();
        var bulan = $('#bulan1').val();
        var filter = $('#filter1').val();
        $.ajax({
            url: '<?= base_url() ?>smigroup/Revenue/updatePenc/bulan',
            data: {'company': options, 'date': tahun + bulan, 'filter': filter},
            type: 'POST',
            dataType: 'json',
            beforeSend: function (data) {
                $('#loading_purple').css('display', 'block');
            },
            success: function (data) {
                $('#loading_purple').css('display', 'none');
                var satuan = (data.penc[0].data[0] >= 1000 || data.penc[1].data[0] >= 1000) ? 'T' : 'M';
                var bulan = bulanText[data.date.substring(4, 7)];
                var tahun = data.date.substring(0, 4);
                chart('container5', 'Pencapaian Bulan ' + bulan + ' ' + tahun, ['s.d kemaren'], data.penc, true, true, satuan);
            }
        });
    }

    function updatePencTahunan() {

        var tahun1 = $('#year1').val();
        var filter = $('#filter2').val();
        $.ajax({

            url: '<?= base_url() ?>smigroup/Revenue/updatePenc/tahun',
            data: {'company': options2, 'date': tahun1, 'filter': filter},
            type: 'POST',
            dataType: 'json',
            beforeSend: function (data) {
                $('#loading_purple').css('display', 'block');
            },
            success: function (data) {
                $('#loading_purple').css('display', 'none');
                var satuan = (data.penc[0].data[0] >= 1000 || data.penc[1].data[0] >= 1000) ? 'T' : 'M';
                 var tahun = data.date;
                chart('container6', 'Pencapaian Tahun', ['s.d kemaren'], data.penc, true, true, satuan);
            }
        });
    }

    $(function () {
//        var data;
//        var dat = [{
//                name: 'John',
//                data: [5, 3, 4, 7, 2]
//            }, {
//                name: 'Jane',
//                data: [2, 2, 3, 2, 1]
//            }, {
//                name: 'Joe',
//                data: [3, 4, 4, 2, 5]
//            }];
//        data['stacked'] = dat;
//        data['company'] = ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas'];
        var d = new Date();

        $('#tahun1').val(d.getFullYear());
        $('#bulan1').val(("0" + (d.getMonth() + 1)).slice(-2));
        $('#year1').val(d.getFullYear() - 1);
        $('#year2').val(d.getFullYear());
        setTheme();
        getMonitoringHarian('', '');
        getMonitoringTahunan('', '', '');



        $('.dd1 a').on('click', function (event) {

            var $target = $(event.currentTarget),
                    val = $target.attr('data-value'),
                    $inp = $target.find('input'),
                    idx;

            if ((idx = options.indexOf(val)) > -1) {
                options.splice(idx, 1);
                setTimeout(function () {
                    $inp.prop('checked', false)
                }, 0);
            } else {
                options.push(val);
                setTimeout(function () {
                    $inp.prop('checked', true)
                }, 0);
            }

            $(event.target).blur();

            return false;
        });

        $('.dd2 a').on('click', function (event) {

            var $target = $(event.currentTarget),
                    val = $target.attr('data-value'),
                    $inp = $target.find('input'),
                    idx;

            if ((idx = options2.indexOf(val)) > -1) {
                options2.splice(idx, 1);
                setTimeout(function () {
                    $inp.prop('checked', false)
                }, 0);
            } else {
                options2.push(val);
                setTimeout(function () {
                    $inp.prop('checked', true)
                }, 0);
            }

            $(event.target).blur();

            return false;
        });

    });
</script>
<style>
    .panel{
        position: relative;
        width: 110%;
        right: 5%;
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
    .radio-inline{
        color:#000;
    }
    .modal-dialog{
        width: 100%;
        
    }
    .modal-header {
        
        background: linear-gradient(to left, #1ab394, #036C13);
        
     }
    #modal-chart .modal-dialog{
        max-height: 300px;
    }
    .highlight{
        background-color: #fff68f;
    }
    th{
        text-align: center;
    }
    .update{
        text-align: center;
        padding-top: 15%;
    }
    .table-popup{
        font-size: 12px;
    }
    table {
        border-collapse: collapse; /* IE7 and lower */
        border-spacing: 0; 
        border-radius: 6px;
    }
    th:first-child {
        border-radius: 6px 0 0 0;
    }
    th:last-child {
        border-radius: 0 6px 0 0;
    }
    th:only-child{
        border-radius: 6px 6px 0 0;
    }
    .summary{
        display: none;
        position: absolute;
        bottom: 70px;
        left: 5px;
        /*width: 50%;
        height: 260px;*/
        font-size: 0.75vw;
        box-shadow: 0px 1px 6px #7f8c8d;
        background-color: white;
        border-radius: 10px;
        color: black;
    }
    .footer-summary{
        position:relative;
        margin-top: -20px;
        margin-left: 5px;
        margin-right: 20px;
    }
    .footer-summary div{
        width: 300px;
    }
    .merah{
        color: red;
    }
    .hijau{
        color: green;
    }
    .tooltip{
        color: black;
    }
    #small-chat2 {
        bottom: 20px;
        left: 20px;
        position: fixed;
        z-index: 100;
    }
    #small-chat {
        position: fixed;
        bottom: 60px;
        left: 20px;
        z-index: 100;
    }
    .style-form { 
        padding: 6px 12px;
        font-size: 12px;        
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
             -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
      }
    
</style>

<div id="loading_purple"></div>
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="col-md-1">
<!--                <div class="update">
                    Last Update : 
                    <span id="updateDate"></span>
                </div>                -->
            </div>
            <div class="col-md-3" style="margin-top: 1.8%; border-right: #005fbf; border-right-style: dotted;border-right-width: thin;">
                <select id="org" class="form-control">
                    <option value="1">SMI Group</option>
                    <option value="7000">Semen Gresik</option>
                    <option value="3000">Semen Padang</option>
                    <option value="4000">Semen Tonasa</option>
                </select>
            </div>      
             <div class="col-md-1">
                <?php if ($this->session->userdata('akses') == 1) { ?>
                <a href="<?=base_url('intelligence/Upload')?>" target="_blank"><button class="btn btn-info" style="margin-top:24px"><i class="fa fa-upload"></i> Upload</button></a>
                <?php } ?>
            </div>
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
                    for ($i = 2011; $i <= Date('Y'); $i++) {
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
        <div class="row">
            <div id="chart1"></div>
        </div>        
    </div>
</div>

<div class="table-popup" id="table-dialog">
    <table class="table table-hover border-bottom white-bg" id="data-table">
        <thead>
        <th>#</th>
        <th>COMPANY</th>
        <th>REALISASI (TON)</th>
        <th>% MS <span class="mms"></span></th>
        <th>% MS Jan-<span class="mms"></span> <span class="yys"></span></th>
        <th>% Target MS</th>
        <th>BAG (TON)</th>
        <th>BULK (TON)</th>        
        <th>Growth Vol MoM</th>
        <th>Growth Vol YoY</th>
        <th>Growth Vol Kum YoY</th>
        </thead>
        <tbody>
            <!-- DATA WILL LOAD HERE -->
        </tbody>       
    </table>
    <table class="table border-bottom white-bg" id="">
        <tbody>
            <tr>
                <td width="30%">Total Demand <span class="provinsi"></span> (TON)</td>
                <td width="5%">:</td>
                <td><span id="porsi">0</span></td>
            </tr>
            <tr>
                <td>Growth Demand <span class="provinsi"></span> MoM</td>
                <td>:</td>
                <td id="growthmom"></td>
            </tr>
            <tr>
                <td>Growth Demand <span class="provinsi"></span> YoY</td>
                <td>:</td>
                <td id="growthyoy"></td>
            </tr>
            <tr>
                <td>Growth Kumulatif <span class="provinsi"></span> YoY</td>
                <td>:</td>
                <td id="growthkumyoy"></td>
            </tr>
        </tbody>       
    </table>
</div>

<div id="small-chat">
    <a class="btn btn-success">
        <i class="fa fa-list"></i> Summary Market Share
    </a>
</div>
<div id="small-chat2" onclick="showHistoryChart(1)">
    <a class="btn btn-success">
        <i class="fa fa-list"></i> Grafik Growth dan Volume
    </a>
</div>
<!-- <div class="small-chat-box fadeInRight animated"> -->

    <div class="table-popup" id="summary">
        <div style="text-align: center"><b>SUMMARY MARKET SHARE NASIONAL</b></div>
        <table id="tbl-summary" class="table table-hover border-bottom white-bg" style="text-align: center">
            <thead>
                <tr class="info">
                    <th>#</th>
                    <th>COMPANY</th>
                    <th>Target RKAP</th>
                    <th>% MS <span class="mms"></span>-<span class="yys"></span></th>
                    <th>% MS Jan-<span class="mms"></span>16</th>
                    <th>Growth Vol MoM</th>
                    <th>Growth Vol YoY</th>
                    <th>Growth Vol Kum YoY</th>
                </tr>            
            </thead>
            <tbody>
                <!-- DATA WILL LOAD HERE -->            
            </tbody>     
        </table>
        <div class="footer-summary">
            <div>Total Demand Nasional (TON)<span class="pull-right" id="porsisummary">20 </span></div>
            <div>Growth Demand Nasional MoM<span class="pull-right" id="gmom">0</span></div>
            <div>Growth Demand Nasional YoY<span class="pull-right" id="gyoy">0</span></div>
            <div>Growth Demand Kumulatif Nasional YoY<span class="pull-right" id="gkumyoy">0</span></div>
        </div>    
    </div>
<!-- untuk menampilkan grafik -->
    <div class="modal fade" id="modal-chart">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <!--    <h4 class="modal-title">
                            <span id="modal-title"></span>&nbsp;&nbsp;| &nbsp;&nbsp;
                            <span id="lu-time">Last Update : <span id="lastupdateChart"></span></span>&nbsp;&nbsp;| &nbsp;&nbsp;
                            <span id="lu-adj">Last Adjustment : <span id="lastadjChart"></span></span>
                        </h4>
                    -->
                    </div>
                    <div class="modal-body">
                        <div class="period">
                            <div class="col-md-12 text-center" style="margin-bottom:15px">                                                              
                                <select class="style-form" name="bulanAwal">
                                    <option value="">-- Pilih Bulan --</option>
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
                                <select class="style-form" name="tahunAwal">
                                        <?php
                                        $tahunSekarang = Date('Y');
                                        for ($i = 2011; $i <= $tahunSekarang; $i++) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                        ?>    
                                </select>
                                <label>&nbsp; s.d. &nbsp;</label>                                                
                                <select class="style-form" name="bulanAkhir">
                                    <option value="">-- Pilih Bulan --</option>
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
                            
                            
                            <select class="style-form" name="tahunAkhir">
                                    <?php
                                    $tahunSekarang = Date('Y');
                                    for ($i = 2011; $i <= $tahunSekarang; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>    
                            </select>
                            <span class="btn btn-default" onclick="showHistoryChart(1)">Cari</span>    
                            <span class="btn btn-default" onclick="saveXls()">Download</span>
                        </div>
                          
                        </div>
                        <div id="pleasewait">Please Wait . . .</div>
                        <div class="row" id="grafik">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div id="pleasewait-growth-asi">Please Wait . . .</div>                                    
                                    <div class="text-center"><b>Growth By ASI</b></div>
                                    <div id="judul-growth-asi" style="text-align: center">                                        
                                        <label class="radio-inline"><input type="radio" name="optradio" value="mom">MoM</label>
                                        <label class="radio-inline"><input type="radio" name="optradio" value="yoy">YoY</label>
                                        <label class="radio-inline"><input type="radio" name="optradio" value="kumyoy">YoY Kumulatif</label> 
                                    </div>                                    
                                    <canvas id="Chart1-popup" width="50%" height="25%"></canvas>
                                    <div style="margin-left: 30%;" id="legendDiv"></div><br/>
                                    <!-- <div style="text-align: center;" id="akurasi-prognose">Akurasi Prognose : <span id="akurasi"></span> %</div> -->
                                </div>
                                <div class="col-md-6">                                    
                                    <div id="judul-growth-sap" style="text-align: center">
                                        <div><b>Grafik Volume</b></div>
                                        <label class="radio-inline"><input type="radio" name="optradio2" value="">Volume Total</label>
                                        <label class="radio-inline"><input type="radio" name="optradio2" value="121-301">Bag</label>
                                        <label class="radio-inline"><input type="radio" name="optradio2" value="121-302">Bulk</label> 
                                    </div> 
                                    <div id="pleasewait-growth-sap">Please Wait . . .</div>
                                    <canvas id="Chart2-popup" width="50%" height="25%"></canvas>                                    
                                    <div style="margin-left: 20%;" id="legendDiv2"></div>
                                </div>
                            </div>                                   
                        </div>
                    </div>
<!--                    <div class="modal-footer">
                                               
                    </div>-->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts-jquery-plugin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.maps.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/maps/fusioncharts.indonesia.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
<script src="<?= base_url('assets/chartjs/dist/Chart.js') ?>" type="text/javascript"></script>
<script>
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
    var initialmonth = new Array();
    initialmonth["01"] = "Jan";
    initialmonth["02"] = "Feb";
    initialmonth["03"] = "Mar";
    initialmonth["04"] = "Apr";
    initialmonth["05"] = "Mei";
    initialmonth["06"] = "Jun";
    initialmonth["07"] = "Jul";
    initialmonth["08"] = "Agu";
    initialmonth["09"] = "Sep";
    initialmonth["10"] = "Okt";
    initialmonth["11"] = "Nop";
    initialmonth["12"] = "Des";
   // var Chart;
    var d = new Date();
    var d = new Date();
    d.setMonth(d.getMonth() - 1);
    var tahun = d.getUTCFullYear();
    var bulan = month[d.getUTCMonth()];
/*    
    var tahun = d.getUTCFullYear();
    var bulan = month[d.getUTCMonth() - 1];
*/    
    function formatAngka(n) {
        var num = parseInt(n);
        return (num + '').replace(/(\d)(?=(\d{3})+$)/g, '$1.');
    }
    function formatWarnaGrowth(id, val) {
        $('#' + id).removeClass();
        if (val > 0) {
            $('#' + id).addClass('font-hijau');
        } else if (val < 0) {
            $('#' + id).addClass('font-merah');
        }
    }
    
    function peta() {
        var peta;
        var url = base_url + 'intelligence/MarketShare/getData/' + org + '/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
                $('#summary').hide();
            },
            success: function (data) {
                peta = new FusionCharts("maps/indonesia", "chartobject-1", "100%", "500", "chart1", "json");
                peta.setChartData(data);
                peta.addEventListener("entityClick", function (e, d) {
                    //alert(d.id);
                    getDetail(d.id);
                });
//                peta.addEventListener("entityRollOut", function (e, d) {
//                    $('#chart1').attrFusionCharts({
//                        "showToolTip":"0"
//                    });
//                });
                peta.render("chart1");
                $('#loading_purple').hide();

                if (is_mobile()) {
                    //$('#summary').hide();
                    $('#summary').removeClass('summary');
                    $('#summary').show();
                } else {
                    $('#summary').show();
                }
                //$('.summary').show();
            }
        });
    }

    function getDetail(prov) {
        var url = base_url + 'intelligence/MarketShare/getDetail/' + org + '/' + prov + '/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $("#data-table tbody").html(data.table);
                $("#porsi").html(data.porsi);
                $("#growthmom").html(data.growthMOM);
                $("#growthyoy").html(data.growthYOY);
                $("#growthkumyoy").html(data.growthkumYOY);
                $(".provinsi").html(data.provinsi);
                $('#table-dialog').dialog({
                    autoOpen: false,
                    title: "Detail",
                    show: "fade",
                    hide: "explode",
                    modal: true,
                    width: 'auto',
                    responsive: true
                });

                $('#table-dialog').dialog('option', 'title', 'Detail ' + data.provinsi);
                $('#table-dialog').dialog("open");
                $('#loading_purple').hide();
            }
        });
    }

    function updatePeta(org) {
        var dataPeta;
        var url = base_url + 'intelligence/MarketShare/getData/' + org + '/' + tahun + '/' + bulan;
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

    function updateTime() {
        var url = base_url + 'intelligence/MarketShare/getUpdateDate';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                $('#updateDate').html(data[0].TGL_UPDATE);
            }
        });
    }

    function summary() {
        var url = base_url + 'intelligence/MarketShare/getSummary/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                $('#tbl-summary tbody').html(data.table);
                $('#porsisummary').html(formatAngka(data.porsi));
                $('#gmom').html(data.growthMOM);
                $('#gyoy').html(data.growthYOY);
                $('#gkumyoy').html(data.growthkumYOY);
                $( "#summary" ).dialog({
                    autoOpen: false,
                    title: "Detail",
                    show: "fade",
                    hide: "explode",
                    modal: true,
                    width: 'auto',
                    responsive: true

                });
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
    var Chart1_popup, Chart2_popup;
    var ctx1_popup = document.getElementById("Chart1-popup");
    var ctx2_popup = document.getElementById("Chart2-popup");
    var lineChartData;
    var lineChartDataVolume;
    function getGrowthASI(kd_perusahaan){
        $("input[value='kumyoy']" ).prop('checked',true);
        /* set default bulan awal dan blan akhir */
        var _period = $('#modal-chart .period');
        if(_period.find('select[name=bulanAwal]').val() == ''){
            _period.find('select[name=tahunAwal]').val($('#tahun').val() - 1);
            _period.find('select[name=tahunAkhir]').val($('#tahun').val());
            _period.find('select[name=bulanAwal]').val($('#bulan').val());
            _period.find('select[name=bulanAkhir]').val($('#bulan').val());
        }                
        var _tglAwal = _period.find('select[name=tahunAwal]').val()+''+_period.find('select[name=bulanAwal]').val();
        var _tglAkhir = _period.find('select[name=tahunAkhir]').val()+''+_period.find('select[name=bulanAkhir]').val();
        // kode_perusahaan = kd_perusahaan;
        //var tanggal = ($('#tanggal').val()).substr(6, 9) + '' + ($('#tanggal').val()).substr(3, 2);
        var url = base_url + 'intelligence/MarketShare/getChartGrowth/'+kd_perusahaan;
        $.ajax({
            url: url,
            type: 'post',
            data:{
                "type":"kumyoy",
                "awal" : _tglAwal,
                "akhir" : _tglAkhir,
            },
            dataType: 'json',
            beforeSend: function () { 
                $("#modal-chart").modal('show');
                $("#pleasewait-growth-asi").show();
                $("#grafik").show();
                $('#judul-growth-asi').hide();
                //$(".chk-perusahaan").prop('checked',false);
                if(Chart1_popup !== undefined){
                    Chart1_popup.destroy(); 
                }
                
            },
            success: function (datas) {
                //$("#lastupdateChart").html(datas['tanggal']);
                //$('#pilih-perusahaan').show();
                $("#pleasewait-growth-asi").hide();
                $('#judul-growth-asi').show();
                lineChartData = {
                    labels: datas['labels'],
                    datasets: datas['growth']
                };
                
                Chart1_popup = new Chart.Line(ctx1_popup, {
                    data: lineChartData,
                    options: {
                        title: {
                            display: false,
                            text: 'Growth by ASI'
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + tooltipItem.yLabel + ' %';
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
                                        labelString: '%'
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
                            display: true,
                            position: 'bottom',
                            labels: {
                                fontSize:10,
                                boxWidth:10
                            }
                        }
                    }
                });
                $("#grafik").show();
            }
        });
    }
    function getMarketVolume(kd_perusahaan){
        $("input:radio[name=optradio2][value='']" ).prop('checked',true);
        /* set default bulan awal dan blan akhir */
        var _period = $('#modal-chart .period');
        /*
        if(_period.find('select[name=bulanAwal]').val() == ''){
            _period.find('select[name=tahunAwal]').val($('#tahun').val());
            _period.find('select[name=tahunAkhir]').val($('#tahun').val());
            _period.find('select[name=bulanAwal]').val($('#bulan').val());
            _period.find('select[name=bulanAkhir]').val($('#bulan').val());
        } */               
        var _tglAwal = _period.find('select[name=tahunAwal]').val()+''+_period.find('select[name=bulanAwal]').val();
        var _tglAkhir = _period.find('select[name=tahunAkhir]').val()+''+_period.find('select[name=bulanAkhir]').val();
        // kode_perusahaan = kd_perusahaan;
        //var tanggal = ($('#tanggal').val()).substr(6, 9) + '' + ($('#tanggal').val()).substr(3, 2);
        var url = base_url + 'intelligence/MarketShare/marketVolume/'+kd_perusahaan;
        $.ajax({
            url: url,
            type: 'post',
            data:{
                "type":"",
                "awal" : _tglAwal,
                "akhir" : _tglAkhir,
            },
            dataType: 'json',
            beforeSend: function () { 
                // $("#modal-chart").modal('show');
                $("#pleasewait-growth-sap").show();
                $("#grafik").show();
                // $('#judul-growth-asi').hide();
                //$(".chk-perusahaan").prop('checked',false);
                if(Chart2_popup !== undefined){
                    Chart2_popup.destroy(); 
                }                
            },
            success: function (datas) {
                //$("#lastupdateChart").html(datas['tanggal']);
                //$('#pilih-perusahaan').show();
                $("#pleasewait-growth-sap").hide();
                $('#judul-growth-asi').show();
                lineChartDataVolume = {
                    labels: datas['labels'],
                    datasets: datas['datas']
                };
                
                Chart2_popup = new Chart.Line(ctx2_popup, {
                    data: lineChartDataVolume,
                    
                    options: {
                        title: {
                            display: false,
                            text: 'Volume'
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) ;
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
                                        labelString: ''
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
                            display: true,
                            position: 'bottom',
                            labels: {
                                fontSize:10,
                                boxWidth:10
                            }
                        }
                    }
                });
                $("#grafik").show();
            }
        });
    }
    
    function showHistoryChart(kd_perusahaan){
        $("#pleasewait").hide();
        $('#legendDiv').hide();   
        $('#legendDiv2').hide();
        if($('#small-chat2').find('i').hasClass('fa-remove')){
                $('#small-chat2').find('i').removeClass('fa-remove').addClass('fa-list');
            }
       // $('#akurasi-prognose').hide();  
        $('.judul-growth').hide();
        getGrowthASI(kd_perusahaan);
        getMarketVolume(kd_perusahaan);
    }
    
    function saveXls(){
        var _period = $('#modal-chart .period');        
        var _tglAwal = _period.find('select[name=tahunAwal]').val()+''+_period.find('select[name=bulanAwal]').val();
        var _tglAkhir = _period.find('select[name=tahunAkhir]').val()+''+_period.find('select[name=bulanAkhir]').val();
        // kode_perusahaan = kd_perusahaan;
        //var tanggal = ($('#tanggal').val()).substr(6, 9) + '' + ($('#tanggal').val()).substr(3, 2);
        var url = base_url + 'intelligence/MarketShare/dataHistory/'+_tglAwal+'/'+_tglAkhir;
        window.open(url);   
    }
    
    $(function () {           
        // Chart.defaults.global.defaultFontColor = '#000';
        updateTime();
        $('#table-dialog').hide();
        $('#summary').hide();
        peta();
        summary();
        $('#tahun').val(tahun);
        $('#bulan').val(bulan);
        tanggal = $('#tahun').val() + '' + $('#bulan').val();
        $('#org').change(function () {
            org = $('#org').val();
            updatePeta(org);
        });
        var mmlalu = month[bulan - 2];
        var mmskrg = bulan;
        var tahunlalu = (tahun - 1).toString().substring(2);
        var tahunskrg = tahun.toString().substring(2);
        $('.mml').html(initialmonth[mmlalu]);
        $('.yyl').html(tahunlalu);
        $('.mms').html(initialmonth[mmskrg]);
        $('.yys').html(tahunskrg);
        $('#filter').click(function () {
            tahun = $('#tahun').val();
            bulan = $('#bulan').val();
            org = $('#org').val();
            updatePeta(org);
            summary();
            mmlalu = month[bulan - 2];
            mmskrg = bulan;
            tahunlalu = (tahun - 1).toString().substring(2);
            tahunskrg = tahun.toString().substring(2);
            $('.mml').html(initialmonth[mmlalu]);
            $('.yyl').html(tahunlalu);
            $('.mms').html(initialmonth[mmskrg]);
            $('.yys').html(tahunskrg);
        });
        
        $( "#small-chat" ).on( "click", function() {
          $( "#summary" ).dialog( "open" );
          
            if($(this).find('i').hasClass('fa-remove')){
                $(this).find('i').removeClass('fa-remove').addClass('fa-list');
            }
          
        });
        
        $("input[name='optradio']").click(function(){
            var tipe = $("input[name='optradio']:checked").val();
            var _period = $('#modal-chart .period');                
            var _tglAwal = _period.find('select[name=tahunAwal]').val()+''+_period.find('select[name=bulanAwal]').val();
            var _tglAkhir = _period.find('select[name=tahunAkhir]').val()+''+_period.find('select[name=bulanAkhir]').val();
            var url = base_url + 'intelligence/MarketShare/getChartGrowth/1';
            $.ajax({
                url: url,
                type: 'post',
                data:{
                    "type":tipe,
                    "awal" : _tglAwal,
                    "akhir" : _tglAkhir,
                },
                dataType: 'json',
                success:function(datas){
                    lineChartData.datasets = datas['growth'];
                    Chart1_popup.update();
                    //console.log(tipe);
                }
            });
        });
        
        $("input[name='optradio2']").click(function(){
            var tipe = $("input[name='optradio2']:checked").val();
            var _period = $('#modal-chart .period');                
            var _tglAwal = _period.find('select[name=tahunAwal]').val()+''+_period.find('select[name=bulanAwal]').val();
            var _tglAkhir = _period.find('select[name=tahunAkhir]').val()+''+_period.find('select[name=bulanAkhir]').val();
            var url = base_url + 'intelligence/MarketShare/marketVolume/1';
            $.ajax({
                url: url,
                type: 'post',
                data:{
                    "type":tipe,
                    "awal" : _tglAwal,
                    "akhir" : _tglAkhir,
                },
                dataType: 'json',
                success:function(datas){
                    lineChartDataVolume.datasets = datas['datas'];
                    Chart2_popup.update();
                    //console.log(tipe);
                }
            });
        });
        
    });
</script>


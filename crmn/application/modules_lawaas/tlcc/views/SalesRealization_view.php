<style>
    .panel{
        position: relative;
        width: 110%;
        right: 5%;
        top: -10px;
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
    .highlight{
        background-color: #f8efc0;
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
        *border-collapse: collapse; /* IE7 and lower */
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
   
    .footer-summary{
        position:relative;
        margin-top: -20px;
        margin-left: 5px;
        margin-right: 20px;
    }
    .font-kecil{
        font-size: 2vw;
    }
    .summary{
        position: fixed;
        bottom: 25px;
        left: 5px;
        width: 26%;
        height: 100px;
        font-size: 0.65vw;
        box-shadow: 0px 1px 6px #7f8c8d;
        background-color: white;
        border-radius: 10px;
        color: black;
    }
</style>

<div id="loading_purple"></div>
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="col-md-2" style="margin-top: 1.8%; border-right: #005fbf; border-right-style: dotted;border-right-width: thin;">
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
        <div class="row">
            <div id="chart1"></div>
        </div>        
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts-jquery-plugin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.maps.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/maps/fusioncharts.vietnam.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
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
    var d = new Date();
    var tahun = d.getUTCFullYear();
    var bulan = month[d.getUTCMonth()];

    function peta() {
        var peta;
        var url = base_url + 'tlcc/SalesRealization/getData/' + org + '/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
                $('#summary').hide();
            },
            success: function (data) {
                peta = new FusionCharts("maps/vietnam", "chartobject-1", "100%", "650", "chart1", "json");
                peta.setChartData(data);
//                peta.addEventListener("entityClick", function (e, d) {
//                    //alert(d.id);
//                    getDetail(d.id);
//                });
//                peta.addEventListener("entityRollOut", function (e, d) {
//                    $('#chart1').attrFusionCharts({
//                        "showToolTip":"0"
//                    });
//                });
                peta.render("chart1");
                $('#loading_purple').hide();

                if (is_mobile()) {
                    $('#summary').hide();
                    $('#summary').removeClass('summary');
                    //$('#summary').show();
                } else {
                    $('#summary').show();
                    //$('#summary').hide();
                }
                //$('.summary').show();
            }
        });
    }

    function updatePeta(org, tahun, bulan) {
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

    function sumSales(tahun, bulan) {
        var bulanText = ['','JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];

        var url = base_url + 'tlcc/SalesRealization/sumSales/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (data) {
                $('#bulansummary').html(bulanText[parseInt(bulan)]);
                $('#realSMIG').html(data.REAL_SDK);
                $('#rkapSMIG').html(data.RKAP);
                $('#persenRealSMIG').html(data.PERSEN_SDK + '%');
                $('#persenRKAPSMIG').html(data.PERSEN + '%');
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

    $(function () {
        //updateTime();
        $('#table-dialog').hide();
        $('#summary').show();
        peta();
        sumSales(tahun, bulan);
        $('#tahun').val(tahun);
        $('#bulan').val(bulan);
        $('#org').val(org);
        $('#org').change(function () {
            org = $('#org').val();
            sumSales(tahun, bulan);
            updatePeta(org, tahun, bulan);

        });
        $('#filter').click(function () {
            tahun = $('#tahun').val();
            bulan = $('#bulan').val();
            org = $('#org').val();
            sumSales(tahun, bulan);
            updatePeta(org, tahun, bulan);

        });
    });
</script>


<div class="table-popup" id="table-dialog">
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
            <!-- DATA WILL LOAD HERE -->
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
</div>

<div class="summary" id="summary" style="position:fixed">
    <div style="text-align: center"><b>SUMMARY DOMESTIC SALES <span id="bulansummary"></span></b></div>
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
                <td><span id="realSMIG"></span></td>
                <td><span id="rkapSMIG"></span></td>
                <td><span id="persenRealSMIG"></span></td>
                <td><span id="persenRKAPSMIG"></span></td>
            </tr>            
        </tbody>     
    </table>
    <!--    <div class="footer-summary">
            <div>Total Demand <span class="pull-right">20% </span></div>
            <div>MoM <span class="pull-right">20% <i class="fa fa-level-up"></i></span></div>
            <div>YoY <span class="pull-right">20% <i class="fa fa-level-down"></i></span></div>
        </div>    -->
</div>
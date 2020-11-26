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
    .summary{
        position: absolute;
        bottom: 50px;
        left: 10px;
        width: 25%;
        height: 200px;
        font-size: 0.65vw;
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
            <div class="col-md-2">
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/maps/fusioncharts.indonesia.js"></script>
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

    function formatAngka(n) {
        var num = parseInt(n);
        return (num + '').replace(/(\d)(?=(\d{3})+$)/g, '$1.');
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
        //alert(param+' | '+param2);
    }
    function peta() {
        var peta;
        var url = base_url + 'smigroup/PetaRevenue/getRevenue/' + org + '/' + tahun + '/' + bulan;
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
                peta.setChartData(data['data']);

                $('#bulansummary').html($('#bulan option:selected').text().toUpperCase());
                var revenueSMIG = Math.round(data['revenueSMIG']);
                var revenueSG = Math.round(data['revenueSG']);
                var revenueSP = Math.round(data['revenueSP']);
                var revenueST = Math.round(data['revenueST']);
                var rkapSMIG = Math.round(data['rkapSMIG']);
                var rkapSG = Math.round(data['rkapSG']);
                var rkapSP = Math.round(data['rkapSP']);
                var rkapST = Math.round(data['rkapST']);
                var persenSMIG = Math.round((revenueSMIG / rkapSMIG) * 100);
                var persenSG = Math.round((revenueSG / rkapSG) * 100);
                var persenSP = Math.round((revenueSP / rkapSP) * 100);
                var persenST = Math.round((revenueST / rkapST) * 100);
                $('#realSMIG').html(formatAngka(revenueSMIG));
                $('#realSG').html(formatAngka(revenueSG));
                $('#realSP').html(formatAngka(revenueSP));
                $('#realST').html(formatAngka(revenueST));
                $('#rkapSMIG').html(formatAngka(rkapSMIG));
                $('#rkapSG').html(formatAngka(rkapSG));
                $('#rkapSP').html(formatAngka(rkapSP));
                $('#rkapST').html(formatAngka(rkapST));
                $('#persenRKAPSMIG').html(persenSMIG + ' %');
                $('#persenRKAPSG').html(persenSG + ' %');
                $('#persenRKAPSP').html(persenSP + ' %');
                $('#persenRKAPST').html(persenST + ' %');
                $('#persenRKAPSMIG').removeClass();
                $('#persenRKAPSG').removeClass();
                $('#persenRKAPSP').removeClass();
                $('#persenRKAPST').removeClass();
                $('#persenRKAPSMIG').addClass(formatWarnaRKAP(persenSMIG));
                $('#persenRKAPSG').addClass(formatWarnaRKAP(persenSG));
                $('#persenRKAPSP').addClass(formatWarnaRKAP(persenSP));
                $('#persenRKAPST').addClass(formatWarnaRKAP(persenST));

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

    function getDetail(prov) {
        var url = base_url + 'smigroup/MarketShare/getDetail/' + org + '/' + prov + '/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $("#data-table tbody").html(data.table);
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

    function updatePeta(org, tahun, bulan) {
        var dataPeta;
        var url = base_url + 'smigroup/PetaRevenue/getRevenue/' + org + '/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $('#chart1').updateFusionCharts({"dataSource": data['data'], "dataFormat": "json"});
                $('#bulansummary').html($('#bulan option:selected').text().toUpperCase());
                if (org == 1) {
                    var revenueSMIG = Math.round(data['revenueSMIG']);
                    var revenueSG = Math.round(data['revenueSG']);
                    var revenueSP = Math.round(data['revenueSP']);
                    var revenueST = Math.round(data['revenueST']);
                    var rkapSMIG = Math.round(data['rkapSMIG']);
                    var rkapSG = Math.round(data['rkapSG']);
                    var rkapSP = Math.round(data['rkapSP']);
                    var rkapST = Math.round(data['rkapST']);
                    var persenSMIG = Math.round((revenueSMIG / rkapSMIG) * 100);
                    var persenSG = Math.round((revenueSG / rkapSG) * 100);
                    var persenSP = Math.round((revenueSP / rkapSP) * 100);
                    var persenST = Math.round((revenueST / rkapST) * 100);
                    $('#realSMIG').html(formatAngka(revenueSMIG));
                    $('#realSG').html(formatAngka(revenueSG));
                    $('#realSP').html(formatAngka(revenueSP));
                    $('#realST').html(formatAngka(revenueST));
                    $('#rkapSMIG').html(formatAngka(rkapSMIG));
                    $('#rkapSG').html(formatAngka(rkapSG));
                    $('#rkapSP').html(formatAngka(rkapSP));
                    $('#rkapST').html(formatAngka(rkapST));
                    $('#persenRKAPSMIG').html(persenSMIG + ' %');
                    $('#persenRKAPSG').html(persenSG + ' %');
                    $('#persenRKAPSP').html(persenSP + ' %');
                    $('#persenRKAPST').html(persenST + ' %');
                    $('#persenRKAPSMIG').removeClass();
                    $('#persenRKAPSG').removeClass();
                    $('#persenRKAPSP').removeClass();
                    $('#persenRKAPST').removeClass();
                    $('#persenRKAPSMIG').addClass(formatWarnaRKAP(persenSMIG));
                    $('#persenRKAPSG').addClass(formatWarnaRKAP(persenSG));
                    $('#persenRKAPSP').addClass(formatWarnaRKAP(persenSP));
                    $('#persenRKAPST').addClass(formatWarnaRKAP(persenST));
                }


                $('#loading_purple').hide();
            }
        });
    }

    function updateTime() {
        var url = base_url + 'smigroup/MarketShare/getUpdateDate';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                $('#updateDate').html(data[0].TGL_UPDATE);
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
        updateTime();
        $('#table-dialog').hide();
        $('#summary').show();
        peta();
        $('#tahun').val(tahun);
        $('#bulan').val(bulan);
        $('#org').val(org);
        $('#org').change(function () {
            org = $('#org').val();
            updatePeta(org, tahun, bulan);
        });
        $('#filter').click(function () {
            tahun = $('#tahun').val();
            bulan = $('#bulan').val();
            org = $('#org').val();
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

<div class="summary" id="summary">
    <div style="text-align: center"><b>SUMMARY DOMESTIC REVENUE <span id="bulansummary"></span></b></div>
    <table class="table table-hover border-bottom center" style="text-align: center">
        <thead>
            <tr class="info">
                <th>COMPANY</th>
                <th>REAL S/D SEKARANG (Rp)</th>
                <th>RKAP (Rp)</th>
                <th>REAL / RKAP (%)</th>
                <th>UPDATE</th>
            </tr>            
        </thead>
        <tbody>
            <!-- DATA WILL LOAD HERE -->
            <tr>
                <td>SMIG</td>
                <td style="text-align: right"><span id="realSMIG"></span></td>
                <td style="text-align: right"><span id="rkapSMIG"></span></td>
                <td><span id="persenRKAPSMIG"></span></td>
                <td></td>
            </tr>
            <tr>
                <td>SG</td>
                <td style="text-align: right"><span id="realSG"></span></td>
                <td style="text-align: right"><span id="rkapSG"></span></td>
                <td><span id="persenRKAPSG"></span></td>
                <td></td>
            </tr>
            <tr>
                <td>SP</td>
                <td style="text-align: right"><span id="realSP"></span></td>
                <td style="text-align: right"><span id="rkapSP"></span></td>
                <td><span id="persenRKAPSP"></span></td>
                <td></td>
            </tr>
            <tr>
                <td>ST</td>
                <td style="text-align: right"><span id="realST"></span></td>
                <td style="text-align: right"><span id="rkapST"></span></td>
                <td><span id="persenRKAPST"></span></td>
                <td></td>
            </tr>
        </tbody>     
    </table>
</div>
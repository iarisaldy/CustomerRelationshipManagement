<style>
    body {
        padding-top:0px !important;
    }
    #content_wrapper {min-height:600px;}
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
    #wrap_luar{
        margin:0 auto;
        overflow:hidden;
        float:left;
        width:100%;
        min-width:1000px;
    }

    #grafik_luar{
        overflow:hidden;
        float:left;
        width:100%;
        padding:5px 5px;
        margin-top:10px;
    }

    #map_luar{
        width:99%;
        overflow:hidden;
        float:left;
        margin:1px 0.5%;
    }

    #map{
        z-index:0;
    }
    .square-box{
        position: absolute;
        width: 10%;
        left: 25%;
        top: 20%;
        overflow: hidden;
        background: #4679BD;        
    }
    .square-box:before{
        content: "";
        display: block;
        padding-bottom: 20%;
    }
    .square-content{
        position:  absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        border-color: black;
    }
    .square-content div {
        display: table;
        width: 100%;
        height: 100%;
    }
    .square-content span {
        display: table-cell;
        text-align: center;
        vertical-align: middle;
    }
    #wrap_progress{
        width:94%;
        overflow:hidden;
        float:left;
        background:#FFF;
        box-shadow: 0px 1px 6px #7f8c8d;
        margin-top:-36px;
        margin-left:0px;
        z-index:80;
        position:absolute;
    }

    #wrap_progress:before{
        content: "";
        display: block;
        padding-bottom: 1%;
    }

    /*    #wrap_progress a{
            width: 100%;
            overflow: hidden;
            float: left;
            background: #FFF;
            box-shadow: 0px 1px 6px #7f8c8d;
            text-align: center;
            padding: 5px;
            text-decoration:none;
            color:#2c3e50;
        }*/

    #progress_judul, .kpi_progress_judul{
        overflow:hidden;
        float:left;
        width:93%;
        margin:0px 3.5% 0 3.5%;
        text-align:center;
        font-family: "Segoe UI","Segoe",Tahoma,Helvetica,Arial,sans-serif !important;
        font-size: 15px;
        font-size: 1vw;
        font-weight:600;
        color:#16a085;
    }

    #progress_judul{
        letter-spacing:-0.5px;
        border-bottom:2px solid #16a085;
        padding:0px 0px;
        margin:0px 3.5%;
        margin-top: -0.5%;
    }

    .data_progress{
        overflow: hidden;
        float: left;
        width: 46%;
        padding: 10px 2%;
    }

    .judulData_progress, .isiData_progress{
        overflow:hidden;
        float:left;
        width:100%;
        font-family: "Segoe UI","Segoe",Tahoma,Helvetica,Arial,sans-serif !important;
        font-size: 11px;
        font-weight:bold;
        color:#34495e;
        letter-spacing:-0.5px;
        text-align:center;
    }

    .isiData_progress{
        font-size: 36px;
        color:#1abc9c;
    }

    .luar_peta{
        width: 100%;
        min-width:500px;
        max-width:500px;
        float: left;
        overflow: hidden;
        background:#ecf0f1;
        padding-bottom:5px;
    }

    .judul_peta{
        /*float: left;*/
        width: 100%;
        padding:2px 1%;
        background: -webkit-linear-gradient(#16a085, #1abc9c);
        background: -o-linear-gradient(#16a085, #1abc9c);
        background: -moz-linear-gradient(#16a085, #1abc9c);
        background: linear-gradient(#16a085, #1abc9c);
        color:#FFF;
        margin-bottom:3px;
    }

    .judul_peta a{
        color:#FFF;
        text-decoration:none;
        font-weight:500;
    }

    .spicpiwrap, .planrealwrap, .durationprogresswrap{
        width:24%;
        float:left;
        margin-left:1%;
        overflow:hidden;
    }

    .durationprogresswrap{
        width:49%;
    }

    .judul_data_peta{
        float:left;
        width:100%;
        font-size:10px;
        font-weight:500;
        color:#2c3e50;
    }

    .isi_data_peta, .isi_data_tbudeac{
        width: 100%;
        clear: left;
        float: left;
        font-size: 14px;
        font-weight: 600;
    }

    .tbudeacwrap{
        width:49%;
        float:left;
        overflow:hidden;
        margin-left:1%;
        margin-top:5px;        
    }

    .tmbdetail{
        position: absolute;
        left: 25%;
        top: 50%;
    }
    .tmbgrafik{
        position: absolute;
        left: 25%;
        top: 70%;
    }

    .panah{
        font-size: 20px;
    }

    .ket-panah{
        display: block;
        font-size: 9px;
        font-style: italic;
        width: 100px;
    }

    .judul_data_tbudeac{
        float:left;
        width:100%;
        font-size:10px;
        font-weight:500;
        color:#2c3e50;
    }

    #legend_stok td {
        height:26px;
        padding:0px 0px 0px 20px !important;
        text-align:left;
        font-size: 15px;
        border-bottom:1px solid #d0d0d0;
        vertical-align:middle;
        color:#555555;
        background-color:#ffffff;
    }
    .konten{
        position: relative;
        width: 110%;
        right: 5%;
        padding-top: 0%;
    }
    .progres-judul{
        text-align:center;
        font-family: 'Segoe UI','Segoe',Tahoma,Helvetica,Arial,sans-serif !important;
        font-size: 16px;
        font-size: 1vw;
        font-weight:600;
        color:#16a085;
        letter-spacing:-0.5px;
        border-bottom:2px solid #16a085;
        margin:0px 3.5%;
        margin-top: -10px;
    }
    .judul_data{
        padding-left: 1%;
        padding-top: 1%;
        font-size:10px;
        font-weight:500;
        color:#2c3e50;
    }
    .isi_data{
        padding-left: 1%;
        font-size: 14px;
        font-weight: 600;
    }
    .logo-menu {
        height: 20px;
        width: 24px;
    }

</style>
<div id="loading_purple"></div>
<div>
    <div class="konten">
        <div class="panel">

            <div class="panel-heading" style="padding: 3px 15px;">
                <h5 style="text-align: center; font-weight: bold;"><i class="fa fa-line-chart" style="color: #fff;"></i>&nbsp;<span class="text-navy" style="color: #fff;">Stok Level Gudang </span></h5>
            </div>
            <div class="col-md-3" style="margin-top: -21px;"><span class="label label-primary" style="font-size:20px;background: linear-gradient(to left, #1ab394, #036C13);padding: 6px 26px;"><i class="fa fa-line-chart" style="color: #fff;"></i>&nbsp;Stok Level Gudang</span></div>
            <div class="col-md-8" style="margin-top: -22px;margin-left: 400px;">
                <div class="col-md-3">
                    <label class="checkbox-inline">
                        <input id="checkbox" class="cb1" type="checkbox" value="7000"><img class="logo-menu" src="<?=base_url()?>assets/img/menu/semen_gresik.png">
                        Semen Gresik
                    </label> 
                </div>
                <div class="col-md-3">
                    <label class="checkbox-inline">
                        <input id="checkbox" class="cb2" type="checkbox" value="3000"><img class="logo-menu" src="<?=base_url()?>assets/img/menu/semen_padang.png">
                        Semen Padang
                    </label>
                </div>
                <div class="col-md-3">
                    <label class="checkbox-inline">
                        <input id="checkbox" class="cb3" type="checkbox" value="4000"><img class="logo-menu" src="<?=base_url()?>/assets/img/menu/semen_tonasa.png">
                        Semen Tonasa
                    </label>
                </div>
                <div class="col-md-3">
                    <label class="checkbox-inline">
                        <input id="checkbox" class="cb4" type="checkbox" value="6000"><img class="logo-menu" src="<?=base_url()?>/assets/img/menu/thang_long.jpg">
                        Thang Long Cement
                    </label>
                </div>                                                                               
            </div>
            <div class="col-md-3"></div>
            <div class="panel-body pn">
                <div id="map_luar" style="width:100%;margin:auto;">
                    <div id="gudang_canvas" class="map" style="height: 500px;"></div>
                    <div id="wrap_progress">
                        <span id="progress_judul" style="
                              margin: 0px 0.5%;
                              color: #555555;
                              font-size: 14px;
                              margin-top: -12px;">KETERANGAN</span>
                        <table id="legend_stok" style="margin-left: 16px;">
                            <tr>
                                <td style="text-align: center;"><img src="<?php echo base_url(); ?>assets/img/map_icons/merah_new.png" width="90%"></img></td>
                                <td style="font-weight: bold;">: Stok Level < 30%</td>
                                <td style="text-align: center;"><img src="<?php echo base_url(); ?>assets/img/map_icons/kuning_new.png" width="90%"></img></td>
                                <td style="font-weight: bold;">: Stok Level 30% - 70%</td>
                                <td style="text-align: center;"><img src="<?php echo base_url(); ?>assets/img/map_icons/hijau_new.png" width="90%"></img></td>
                                <td style="font-weight: bold;">: Stok Level 70% - 100%</td>
                                <td style="text-align: center;"><img src="<?php echo base_url(); ?>assets/img/map_icons/biru_new.png" width="90%"></img></td>
                                <td style="font-weight: bold;">: Stok Level > 100%</td>
                                <td style="text-align: center;"><img src="<?php echo base_url(); ?>assets/img/map_icons/hitam.png" width="90%"></img></td>
                                <td>: Jawa Bali > 1 Hari, Non Jawa Bali > 7 Hari</td>
                                <td>
<!--                                    <a href="<?php echo base_url() . 'smigroup/TabelKeputusan'; ?>" target="_blank" class="btn btn-success btn-xs dim" role="button" style="margin-left: 117px;
                                       width: 121px;
                                       height: 42px;
                                       margin-top: -25px;
                                       font-size: 17px;
                                       padding-top: 7px;
                                       "><i class="fa fa-table"></i> DSS Table</a>-->
                                </td>


                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tabelDialog">
    <table>
<!--        <tr>
            <td>Koordinat</td>
            <td>:</td>
            <td><div id="latlong" style="margin-left: 10px"></div></td>
        </tr>-->
        <tr>
            <td>Total Volume 3 hari Terakhir (Ton)</td>
            <td>:</td>
            <td><div id="sum_sdp" style="margin-left: 10px"></div></td>
        </tr>
        <tr>
            <td>Total Rilis Hari Ini</td>
            <td>:</td>
            <td><div id="sum_hr" style="margin-left: 10px"></div></td>
        </tr>
        <tr>
            <td>Total Truk 3 hari terakhir</td>
            <td>:</td>
            <td><div id="truk_sdp" style="margin-left: 10px"></div></td>
        </tr>
        <tr>
            <td>Kemampuan Bongkar harian</td>
            <td>:</td>
            <td><div id="truk_sdp" style="margin-left: 10px"> ... TRUK</div></td>
        </tr>
        
<!--        <tr>
            <td>Total Truk Terlambat Datang</td>
            <td>:</td>
            <td><div id="truk_late" style="margin-left: 10px"></div></td>
        </tr>-->
<!--        <tr>
            <td>Total Truk Inap</td>
            <td>:</td>
            <td><div id="truk_inap" style="margin-left: 10px"></div></td>
        </tr>-->
    </table>
    <br/>
    <table id="tabel_spj" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>NO</th>
                <th>NO SPJ</th>
                <th>NOPOL</th>
                <th>Ekspeditur</th>
                <th>Waktu Berangkat</th>
                <th>Tonase</th>
                <th>Zak</th>
                <th>Tonase</th>
                <th>Status</th>
                <th>Standard Lead Time (jam)</th>
                <th>Durasi (jam)</th>
                <th>Perkiraan Kedatangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<?php if ($this->session->userdata('akses') == 1 || $this->session->userdata('akses') == 2) { ?>
    <div class="col-lg-3">
        <div class="panel panel-success" style="position: fixed;bottom: 1px;left: 50px;z-index: 100;">
            <div class="panel-heading" id="showEntry" style="font-weight:bold;background: #337ab7;color:#fff">
                Show Entry Gudang
            </div>
            <br>
            <table id="tableGudang" style="display:none">
                <tr>
                    <td><a target="_blank" href="<?php echo site_url('smigroup/StockLevelGudang/MasterGudang') ?>" style="color:#fff;"><button class="btn btn-success dim btn-xs" style="margin: 0px 15px;background: #337ab7"><i class="fa fa-plus-circle"></i> Master Gudang</button></a></td>
                </tr>
                <tr>
                    <td><a target="_blank" href="<?php echo site_url('smigroup/StockLevelGudang/AdjustmentGudang') ?>" style="color:#fff;"><button class="btn btn-success dim btn-xs" style="margin: 0px 15px;background: #337ab7"><i class="fa fa-plus-circle"></i> Adjustment Gudang</button></a></td>
                </tr>
            </table>
        </div>
    </div>
<?php } ?>

<script src="<?php echo base_url('assets/chartjs/dist/Chart.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBBZXrepkX3AgeIBs1IwWfhu2aMg-5G0_A "></script>
<script>
    function isRealValue(obj) {
        return obj && obj !== "null" && obj !== "undefined";
    }

    function formatLocal(n) {
        var result = formatNumb(n);
        result = result.replace(/,/g, '#');
        result = result.replace(/\./g, ',')
        result = result.replace(/#/g, '.');

        return result;
    }

    function formatNumb(n) {
        var rx = /(\d+)(\d{3})/;
        return String(n).replace(/^\d+/, function (w) {
            while (rx.test(w)) {
                w = w.replace(rx, '$1,$2');
            }
            return w;
        });
    }

    function create_table(obj_data) {
        var now = new Date();
        $("#tabel_spj").dataTable().fnDestroy();
        var table_string = "<thead><tr>" +
                "<th>NO</th>" +
                "<th>NO SPJ</th>" +
                "<th>NOPOL</th>" +
                "<th>Ekspeditur</th>" +
                "<th>Waktu Berangkat</th>" +
                "<th>Tonase</th>" +
                "<th>Zak</th>" +
//                "<th>Status</th>" +
                "<th>Lead Time (jam)</th>" +
//                "<th>Durasi (jam)</th>" +
                "<th>Perkiraan Kedatangan</th>" +
                "</tr></thead><tbody>";
        var count = 0;
        var sum_sdp = 0;
        var sum_ton = 0;
        var truk_telat = 0;
        var truk_inap = 0;
        var sum_ton_today=0;
        var sum_zak_today=0;
        var tgltemp = 0;
        var iterator=0;
        var color= ['#badbc5','#d1d1d1', '#badbc5', '#bacfdb', '#edcfdb'];
        if (isRealValue(obj_data)) {
            $.each(obj_data, function (key, val) {
                count++;
                
                if(tgltemp !=val.TGL){
                    iterator++;
                }
               
                table_string += "<tr style='background-color:"+color[iterator]+"'>" +
                        "<td>" + count + "</td>" +
                        "<td>" + val.NO_SPJ + "</td>" +
                        "<td>" + val.NO_POLISI + "</td>" +
                        "<td>" + val.NAMA_EXPEDITUR + "</td>" +
                        "<td>" + val.TGL_BERANGKAT + "</td>" +
                        "<td>" + formatLocal(val.KWANTUMX) + "</td>" +
                        "<td>" + formatLocal(val.KWANTUM) + "</td>" +
//                        "<td>" + val.STATUS + "</td>" +
                        "<td>" + val.LEAD_TIME + "</td>" +
//                        "<td>" + val.REALISASI + "</td>" +
                        "<td>" + val.PERKIRAAN + "</td>" +
                        "</tr>";
                tgltemp=val.TGL;
                if(val.TGL == now.getDate()){
                    sum_ton_today+=val.KWANTUMX;
                    sum_zak_today+=val.KWANTUM;
                }
                sum_sdp += val.KWANTUM;
                sum_ton += val.KWANTUMX;
                if (val.STATUS == 'Perjalanan (terlambat)') {
                    truk_telat++;
                } else if (val.STATUS == 'Inap') {
                    truk_inap++;
                }
            });
        }

        $("#sum_sdp").html(formatLocal(sum_sdp) + ' ZAK/' + formatLocal(sum_ton) + ' TON');
        $("#truk_sdp").html(count + ' TRUK');
        $("#sum_hr").html(formatLocal(sum_zak_today) + ' ZAK/' + formatLocal(sum_ton_today) + ' TON');
//        $("#truk_late").html(truk_telat);
//        $("#truk_inap").html(truk_inap);

        table_string += "</tbody>";
        $("#tabel_spj").html(table_string);

        // Init Datatables with Tabletools Addon    
        $('#tabel_spj').dataTable({
            "aoColumnDefs": [{'bSortable': false, 'aTargets': [-1]}],
            "oLanguage": {"oPaginate": {"sPrevious": "", "sNext": ""}},
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "bDestroy": true
        });
    }

    function dialog_spj(kd_gdg, nm_gdg, kota, latlong) {
        //  $('#latlong').html(latlong);

        var url_data = base_url + "smigroup/StockLevelGudang/getStokTransit/" + kd_gdg;

        $.ajax({
            url: url_data,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                create_table(data);
                $('#loading_purple').hide();
            },
            error: function () {
                $('#loading_purple').hide();
                alert("Error saat mengambil data");
            }
        });

        $('#tabelDialog').dialog({
            autoOpen: false,
            title: "Daftar SPJ",
            show: "blind",
            hide: "explode",
            modal: true,
            width: 'auto',
            responsive: true
        });

        $('#tabelDialog').dialog('option', 'title', kd_gdg + ' - ' + nm_gdg);
        $('#tabelDialog').dialog("open");
    }

    var Chart1;
    jQuery(document).ready(function () {
        //$('#tabelDialog').hide();
        $('.cb1').prop("checked", true);
        $('.cb2').prop("checked", true);
        $('.cb3').prop("checked", true);
        $('.cb4').prop("checked", true);

        $('#loading_purple').hide();

        $('#tabelDialog').dialog({
            autoOpen: false,
            title: "Daftar SPJ",
            show: "blind",
            hide: "explode",
            modal: true,
            width: 'auto',
            responsive: true
        });
        // Init Datatables with Tabletools Addon    
        $('#tabel_spj').dataTable({
            "aoColumnDefs": [{'bSortable': false, 'aTargets': [-1]}],
            "oLanguage": {"oPaginate": {"sPrevious": "", "sNext": ""}},
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "bDestroy": true
        });
        var ctx1 = document.getElementById("Chart1");
        var lineChartData = {
            labels: ['asda'],
            datasets: [{
                    label: "STOK GUDANG",
                    data: ['0'],
                    fill: false,
                    borderColor: '#98210f',
                    backgroundColor: '#98210f'
                }]
        };
        Chart1 = new Chart.Bar(ctx1, {
            data: lineChartData,
            options: {
                title: {
                    display: true,
                    text: 'Stok Gudang'
                }
            }
        });

        // Initilize Gmap2 - clickable movements
        $(function () {
            var url_data = base_url + 'smigroup/StockLevelGudang/getPeta';
            var click = false;
            var markers = new Array();
            var provMarkers = new Array();
            var areaMarkers = new Array();
            $('#loading_purple').show();
            $('#showEntry').click(function () {
                if ($('#tableGudang').is(":visible")) {
                    $('#showEntry').text('Show Entry Gudang');
                    $('#tableGudang').fadeOut();
                } else {
                    $('#showEntry').text('Hide Entry Gudang');
                    $('#tableGudang').fadeIn();
                }
            });

            $.getJSON(url_data, function (data) {
                function hitungLevelProv(provinsi) {
                    provinsi = provinsi.trim();
                    var nilai;
                    var temp = 0;
                    var n = 0;
                    for (var i = 0; i < data.length; i++) {
                        var totalLevel = parseInt(data[i]['TOTAL_LEVEL_ONHAND']) || 0;
                        if (data[i]['KD_PROVINSI'] == provinsi) {
                            temp += totalLevel;
                            n++;
                        }
                    }
                    nilai = temp / n;
                    return Math.round(nilai);
                }
                function hitungJumlahGudang(provinsi) {
                    provinsi = provinsi.trim();
                    var nilai = 0;
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['KD_PROVINSI'] == provinsi) {
                            nilai++;
                        }
                    }
                    return nilai;
                }
                function hitungLevelArea(area) {
                    var nilai;
                    var temp = 0;
                    var n = 0;
                    for (var i = 0; i < data.length; i++) {
                        var totalLevel = parseInt(data[i]['TOTAL_LEVEL_ONHAND']) || 0;
                        if (data[i]['AREA'] == area) {
                            temp += totalLevel;
                            n++;
                        }
                    }
                    nilai = temp / n;
                    return Math.round(nilai);
                }
                function hitungJumlahGudangArea(area) {
                    //var kd_area = area.trim();
                    var nilai = 0;
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['AREA'] == area) {
                            nilai++;
                        }
                    }
                    return nilai;
                }
                function show(category) {
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['ORG'] == category) {
                            markers[i].setVisible(true);
                        }
                    }
                }
                function showMarkers() {
                    var cat1 = $(".cb1").attr("value");
                    var cat2 = $(".cb2").attr("value");
                    var cat3 = $(".cb3").attr("value");
                    var cat4 = $(".cb4").attr("value");
                    if (($(".cb1").is(":checked"))) {
                        show(cat1);
                    }
                    if (($(".cb2").is(":checked"))) {
                        show(cat2);
                    }
                    if (($(".cb3").is(":checked"))) {
                        show(cat3);
                    }
                    if (($(".cb4").is(":checked"))) {
                        show(cat4);
                    }
                }
                function showProvGud(provinsi) {
                    provinsi = provinsi.trim();
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['KD_PROVINSI'] == provinsi) {
                            markers[i].setVisible(true);
                        } else {
                            markers[i].setVisible(false);
                        }
                    }
                }
                function showArea(area) {
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['AREA'] == area) {
                            markers[i].setVisible(true);
                        } else {
                            markers[i].setVisible(false);
                        }
                    }
                }
                function hide(category) {
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['ORG'] == category) {
                            markers[i].setVisible(false);
                        }
                    }
                }
                function hideMarkers() {
                    var cat1 = $(".cb1").attr("value");
                    var cat2 = $(".cb2").attr("value");
                    var cat3 = $(".cb3").attr("value");
                    var cat4 = $(".cb4").attr("value");
                    if (!($(".cb1").is(":checked"))) {
                        hide(cat1);
                    }
                    if (!($(".cb2").is(":checked"))) {
                        hide(cat2);
                    }
                    if (!($(".cb3").is(":checked"))) {
                        hide(cat3);
                    }
                    if (!($(".cb4").is(":checked"))) {
                        hide(cat3);
                    }
                }
                function hideMarkersAll() {
                    for (var i = 0; i < data.length; i++) {
                        markers[i].setVisible(false);
                    }
                }
                $(".cb1").click(function () {
                    var cat = $(this).attr("value");
                    // If checked
                    if ($(this).is(":checked")) {
                        show(cat);
                    } else {
                        hide(cat);
                    }
                });
                $(".cb2").click(function () {
                    var cat = $(this).attr("value");
                    // If checked
                    if ($(this).is(":checked")) {
                        show(cat);
                    } else {
                        hide(cat);
                    }
                });
                $(".cb3").click(function () {
                    var cat = $(this).attr("value");
                    // If checked
                    if ($(this).is(":checked")) {
                        show(cat);
                    } else {
                        hide(cat);
                    }
                });
                $(".cb4").click(function () {
                    var cat = $(this).attr("value");
                    // If checked
                    if ($(this).is(":checked")) {
                        show(cat);
                    } else {
                        hide(cat);
                    }
                });
                var options = {
                    zoom: 5, //level zoom
                    //posisi tengah peta
                    center: new google.maps.LatLng(-3.700923, 113.645717),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                // Buat peta di 
                var map = new google.maps.Map(document.getElementById('gudang_canvas'), options);

                var infowindow = new google.maps.InfoWindow();

                var marker;

                $.each(data, function (key, val) {
                    var kd_gdg = String(val.KD_GDG);
                    var nm_gdgdistr = String(val.NM_DISTRIK + ' - ' + val.NM_DISTR);//escape(String(val.NM_GDG+'-'+val.NM_DISTR));
                    var kd_distrik = String(val.KD_DISTRIK);
                    var latlong = String(val.LATITUDE + ',' + val.LONGITUDE);

                    var last_update = new Date(val.TGL_UPDATE);


                    var current_date = new Date();
                    var one_day = 1000 * 60 * 60 * 24;
                    var difference_ms = current_date.getTime() - last_update.getTime();

                    // Convert back to days and return
                    var different_day = (difference_ms / one_day);




                    var icons;
                    if(val.FLAG == 0){
                        if (val.TOTAL_LEVEL_ONHAND <= 30) {
                            icons = base_url + 'assets/img/map_icons/merah_new.png';
                            //var color_stok = '#e74c3c';
                        } else if (val.TOTAL_LEVEL_ONHAND > 30 && val.TOTAL_LEVEL_ONHAND <= 70) {
                            icons = base_url + 'assets/img/map_icons/kuning_new.png';
                            //var color_stok = '#fcff00';
                        } else if (val.TOTAL_LEVEL_ONHAND > 70 && val.TOTAL_LEVEL_ONHAND < 100) {
                            icons = base_url + 'assets/img/map_icons/hijau_new.png';
                            //var color_stok = '#27ae60';
                        } else if (val.TOTAL_LEVEL_ONHAND >= 100) {
                            icons = base_url + 'assets/img/map_icons/biru_new.png';
                            //var color_stok = '#1735f0';
                        }
    //                    if (different_day > 30) {
    //                        icons = base_url + 'assets/img/map_icons/hitam.png';
    //                    }
    //                    if(val.ORG == '3000' || val.ORG == '4000'){
    //                        icons=base_url+'assets/img/map_icons/abu.png';
    //                    }


                        var jawabali = ['1022', '1026', '1021', '1024', '1023', '1025', '1020'];

                        if (jawabali.indexOf(val.KD_PROVINSI)) {
                            var Diff = (current_date.getDay() - 1 == 0 ||current_date.getDay() == 0) ? 2.5 : 1.5;
                            if ((current_date.getHours() >= '12' && different_day >= Diff) || different_day >= Diff) {
                                icons = base_url + 'assets/img/map_icons/hitam.png';
                            }
                            // console.log();
                        } else {
                            if (current_date.getHours() >= '12' && different_day > 7) {
                                icons = base_url + 'assets/img/map_icons/hitam.png';
                            }
                        }
                    }
                    else if(val.FLAG == 1){
                        if (val.TOTAL_LEVEL_ONHAND <= 30) {
                            icons = base_url + 'assets/img/map_icons/Pin-merah.png';
                            //var color_stok = '#e74c3c';
                        } else if (val.TOTAL_LEVEL_ONHAND > 30 && val.TOTAL_LEVEL_ONHAND <= 70) {
                            icons = base_url + 'assets/img/map_icons/Pin-kuning.png';
                            //var color_stok = '#fcff00';
                        } else if (val.TOTAL_LEVEL_ONHAND > 70 && val.TOTAL_LEVEL_ONHAND < 100) {
                            icons = base_url + 'assets/img/map_icons/Pin-hijau.png';
                            //var color_stok = '#27ae60';
                        } else if (val.TOTAL_LEVEL_ONHAND >= 100) {
                            icons = base_url + 'assets/img/map_icons/Pin-biru.png';
                            //var color_stok = '#1735f0';
                        }
    //                    if (different_day > 30) {
    //                        icons = base_url + 'assets/img/map_icons/hitam.png';
    //                    }
    //                    if(val.ORG == '3000' || val.ORG == '4000'){
    //                        icons=base_url+'assets/img/map_icons/abu.png';
    //                    }


                        var jawabali = ['1022', '1026', '1021', '1024', '1023', '1025', '1020'];

                        if (jawabali.indexOf(val.KD_PROVINSI)) {
                            var Diff = (current_date.getDay() - 1 == 0 ||current_date.getDay() == 0) ? 2.5 : 1.5;
                            if ((current_date.getHours() >= '12' && different_day >= Diff) || different_day >= Diff) {
                                icons = base_url + 'assets/img/map_icons/Pin-hitam.png';
                            }
                            // console.log();
                        } else {
                            if (current_date.getHours() >= '12' && different_day > 7) {
                                icons = base_url + 'assets/img/map_icons/Pin-hitam.png';
                            }
                        }
                    }
                    

                    var latitude = val.LATITUDE.replace(',', '.');
                    var longitude = val.LONGITUDE.replace(',', '.');

                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(latitude, longitude),
                        map: map,
                        icon: icons
                    });

                    markers.push(marker);

                    //menambahkan event clik untuk menampikan infowindows dengan isi sesuai dengan marker yang di klik
                    google.maps.event.addListener(marker, 'click', (function (marker, key) {
                        return function () {
                            if (Math.round(val.STOK) > Math.round(val.AVGSTOK)) {
                                var panah = "<i class='fa fa-arrow-circle-o-up' style='color:green; font-size:50px;'></i>";
                            } else if (Math.round(val.STOK) < Math.round(val.AVGSTOK)) {
                                var panah = "<i class='fa fa-arrow-circle-o-down' style='color:red; font-size:50px;'></i>";
                            } else {
                                var panah = "<i class='fa fa-arrows-h' style='font-size:50px;'></i>";
                            }
                            var color_stok = 'black';
                            if(val.FLAG == 0){
                                var info2 = "<table class='luar_peta'>" +
                                    "<tbody>" +
                                    "<tr>" +
                                    "<input type = 'hidden' id='inpFlags' value='"+ val.FLAG+"'>"+
                                    "<td colspan='4' class='judul_peta'><a href='#'>" + val.KD_GDG + " - " + val.NM_DISTRIK + " - " + val.NM_DISTR + "</a></td>" +
                                    "</tr>" +
                                    "<tr style='line-height: 30%;'>" +
                                    "<td class='judul_data'>Stok on Hand ("+  +")</td>" +
                                    "<td class='judul_data'>SPJ Hari Ini</td>" +
                                    "<td class='judul_data'>Stok Level on Hand</td>" +
                                    "<td></td>" +
                                    "</tr>" +
                                    "<tr>" +
                                    //"<td class='isi_data'>" + formatLocal(Math.round(val.STOK)) + " " + (val.SOURCE == 'E-LOGS' ? 'ZAK' : 'TON') + "</td>" +
                                    "<td class='isi_data'>" + formatLocal(Math.round(val.STOK)) + " Ton</td>" +
                                    "<td class='isi_data'>" + formatLocal(val.TRANSIT) + " TON/" + formatLocal(val.JML_TRUK) + " Truk</td>" +
                                    "<td class='isi_data'>" +
                                    "<span style='color:" + color_stok + "'>" + val.STOK_LEVEL + "% </span>" +
                                    "</td>" +
                                    "<td>" +
                                    "<span class='btn btn-primary btn-xs' onclick='dialog_spj(\"" + kd_gdg + "\",\"" + nm_gdgdistr + "\",\"" + kd_distrik + "\",\"" + latlong + "\")'>" +
                                    "<i class='fa fa-truck'></i> In Transit &nbsp;&nbsp;&nbsp;" +
                                    "</span>" +
                                    "</td>" +
                                    "</tr>" +
                                    "<tr style='line-height: 30%;'>" +
                                    "<td class='judul_data'>Kapasitas Gudang</td>" +
                                    "<td rowspan='3'>" +
                                    "<span class=''>" + panah + "</span>" +
                                    "</td>" +
                                    "<td class='judul_data'>Sisa SO</td>" +
                                    "<td>&nbsp;</td>" +
                                    "</tr>" +
                                    "<tr>" +
                                    "<td class='isi_data'>" + formatLocal(val.KAPASITAS) + " " + (val.SOURCE == 'E-LOGS' ? 'ZAK' : 'TON') + "</td>" +
                                    "<td class='isi_data'>" + formatLocal(val.SISA_TO) + " TON</td>" +
                                    "<td>" +
                                    // "<span class='btn btn-success btn-xs' onclick='chart(" + kd_gdg + ")'>" +
                                    "<span class='btn btn-success btn-xs' onclick='chart(" + kd_gdg +','+ val.FLAG +")'>" +
                                    "<i class='fa fa-area-chart'></i> Stok & Rilis" +
                                    "</span>" +
                                    "</td>" +
                                    "<td></td>" +
                                    "</tr>" +
                                    "<tr style='line-height: 30%;'>" +
                                    "<td class='judul_data'>Last Update</td>" +
                                    "<td class='judul_data'>Stok 7 Hari yang Lalu</td>" +
                                    "<td>&nbsp;</td>" +
                                    "<td></td>" +
                                    "</tr>" +
                                    "<tr>" +
                                    "<td class='isi_data'>" + val.LAST_UPDATE + "</td>" +
                                    "<td style='font-size: 9px;'>*Perbandingan dengan stok <br/>7 hari yang lalu</td>" +
                                    "<td class='isi_data'>" + formatLocal(Math.round(val.AVGSTOK)) + " TON</td>" +
                                    "<td>&nbsp;" +
                                    "</td>" +
                                    "</tr>" +
                                    "</tbody>" +
                                    "</table>";
                            }
                            else{
                                var info2 = "<table class='luar_peta'>" +
                                    "<tbody>" +
                                    "<tr>" +
                                    "<input type = 'hidden' id='inpFlags' value='"+ val.FLAG+"'>"+
                                    "<td colspan='4' class='judul_peta'><a href='#'>" + val.KD_GDG + " - " + val.NM_DISTRIK + " - " + val.NM_DISTR + "</a></td>" +
                                    "</tr>" +
                                    "<tr style='line-height: 30%;'>" +
                                    "<td class='judul_data'>Stok on Hand ("+  +")</td>" +
                                    "<td class='judul_data'>SPJ Hari Ini</td>" +
                                    "<td class='judul_data'>Stok Level on Hand</td>" +
                                    "<td></td>" +
                                    "</tr>" +
                                    "<tr>" +
                                    //"<td class='isi_data'>" + formatLocal(Math.round(val.STOK)) + " " + (val.SOURCE == 'E-LOGS' ? 'ZAK' : 'TON') + "</td>" +
                                    "<td class='isi_data'>" + formatLocal(Math.round(val.STOK)) + " Ton</td>" +
                                    "<td class='isi_data'>" + formatLocal(val.TRANSIT) + " TON/" + formatLocal(val.JML_TRUK) + " Truk</td>" +
                                    "<td class='isi_data'>" +
                                    "<span style='color:" + color_stok + "'>" + val.STOK_LEVEL + "% </span>" +
                                    "</td>" +
                                    "<td>" +
                                    "<span class='btn btn-primary btn-xs' onclick='dialog_spj(\"" + kd_gdg + "\",\"" + nm_gdgdistr + "\",\"" + kd_distrik + "\",\"" + latlong + "\")'>" +
                                    "<i class='fa fa-truck'></i> In Transit &nbsp;&nbsp;&nbsp;" +
                                    "</span>" +
                                    "</td>" +
                                    "</tr>" +
                                    "<tr style='line-height: 30%;'>" +
                                    "<td class='judul_data'>Kapasitas Gudang</td>" +
                                    "<td rowspan='3'>" +
                                    "<span class=''>" + panah + "</span>" +
                                    "</td>" +
                                    "<td class='judul_data'>Sisa SO</td>" +
                                    "<td>&nbsp;</td>" +
                                    "</tr>" +
                                    "<tr>" +
                                    "<td class='isi_data'>" + formatLocal(val.KAPASITAS) + " " + (val.SOURCE == 'E-LOGS' ? 'ZAK' : 'TON') + "</td>" +
                                    "<td class='isi_data'>" + formatLocal(val.SISA_TO) + " TON</td>" +
                                    "<td>" +
                                    // "<span class='btn btn-success btn-xs' onclick='chartElogs(" + kd_gdg + ")'>" +
                                    "<span class='btn btn-success btn-xs' onclick='chartElogs(" + kd_gdg +','+ val.FLAG +")'>" +
                                    "<i class='fa fa-area-chart'></i> Stok & Rilis" +
                                    "</span>" +
                                    "</td>" +
                                    "<td></td>" +
                                    "</tr>" +
                                    "<tr style='line-height: 30%;'>" +
                                    "<td class='judul_data'>Last Update</td>" +
                                    "<td class='judul_data'>Stok 7 Hari yang Lalu</td>" +
                                    "<td>&nbsp;</td>" +
                                    "<td></td>" +
                                    "</tr>" +
                                    "<tr>" +
                                    "<td class='isi_data'>" + val.LAST_UPDATE + "</td>" +
                                    "<td style='font-size: 9px;'>*Perbandingan dengan stok <br/>7 hari yang lalu</td>" +
                                    "<td class='isi_data'>" + formatLocal(Math.round(val.AVGSTOK)) + " TON</td>" +
                                    "<td>&nbsp;" +
                                    "</td>" +
                                    "</tr>" +
                                    "</tbody>" +
                                    "</table>";
                            }
                            
                            infowindow.setContent(info2);
                            infowindow.open(map, marker);
                        };
                    })(marker, key));

                    google.maps.event.addListener(marker, 'dblclick', function () {
                        dialog_spj(val.KD_GDG, val.NM_GDG + '-' + val.NM_DISTR, val.KD_DISTRIK, val.LATITUDE + ',' + val.LONGITUDE);
                    }.bind(this));
                });

                //markers di hiden terlebih dahulu
                hideMarkersAll();

                /* toko di off kan dulu
                 var toko = base_url+'smigroup/StockLevelGudang/tokoJson';
                 $.getJSON(toko, function(data) {
                 // kode untuk menampilkan banyak marker
                 $.each(data, function( key, val ) { 
                 var icons=base_url+'assets/img/map_icons/bg_map_icon.png';
                 
                 marker = new google.maps.Marker({
                 position: new google.maps.LatLng(val.LATITUDE, val.LONGITUDE),
                 map: map,
                 icon: icons
                 });
                 
                 //menambahkan event clik untuk menampikan
                 //infowindows dengan isi sesuai denga
                 //marker yang di klik
                 google.maps.event.addListener(marker, 'click', (function(marker, i) {
                 return function() {
                 infowindow.setContent(
                 "<table class='zebra-table'> <tr><td>Nama Toko</td><td>:</td><td>"+val.NM_TOKO+"</td></tr>"+
                 "<tr><td>Alamat</td><td>:</td><td>"+val.ALAMAT+"</td></tr></table>"
                 );
                 infowindow.open(map, marker);
                 }
                 })(marker, key));
                 });
                 }); */

                //marker tiap area
                var area = base_url + 'smigroup/StockLevelGudang/getArea';
                $.getJSON(area, function (data) {
                    /* kode untuk menampilkan banyak marker */
                    var marker;
                    $.each(data, function (key, val) {
                        var level = hitungLevelArea(val.KD_AREA);
                        var warnaLevel = '';
                        if (level <= 30) {
                            icons = base_url + 'assets/img/map_icons/merah_big.png';
                            warnaLevel = '<h1 class="no-margins" style="color:red; font-weight:bold;">' + level + '%</h1>';
                        } else if (level > 30 && level <= 70) {
                            icons = base_url + 'assets/img/map_icons/kuning_big.png';
                            warnaLevel = '<h1 class="no-margins" style="color:#eaec00; font-weight:bold;">' + level + '%</h1>';
                        } else if (level > 70 && level < 100) {
                            icons = base_url + 'assets/img/map_icons/hijau_big.png';
                            warnaLevel = '<h1 class="no-margins" style="color:green; font-weight:bold;">' + level + '%</h1>';
                        } else if (level >= 100) {
                            icons = base_url + 'assets/img/map_icons/biru_big.png';
                            warnaLevel = '<h1 class="no-margins" style="color:blue; font-weight:bold;">' + level + '%</h1>';
                        } else {
                            icons = base_url + '';
                        }

                        var n = hitungJumlahGudangArea(val.KD_AREA);

                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(val.LATITUDE, val.LONGITUDE),
                            map: map,
                            icon: icons
                        });

                        areaMarkers.push(marker);

                        /* menambahkan event clik untuk menampikan
                         infowindows dengan isi sesuai denga
                         marker yang di klik */
                        google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
                            return function () {
                                infowindow.setContent(
                                        '<h5 class="border-bottom">' + val.DESCH + '</h5>' +
                                        '<small>Stok Level On Hand</small>' +
                                        warnaLevel +
                                        '<small>' + n + ' Gudang</small>'
                                        );
                                infowindow.open(map, marker);
                            };
                        })(marker, key));
                        google.maps.event.addListener(marker, 'mouseout', function () {
                            infowindow.close(map, marker);
                        }.bind(this));
                        google.maps.event.addListener(marker, 'click', (function (marker, i) {
                            return function () {
                                click = true;
                                showArea(val.KD_AREA);
                                map.setCenter(marker.getPosition());
                                map.setZoom(9);
                            };
                        })(marker, key));
                    });
                    for (var i = 0; i < data.length; i++) {
                        areaMarkers[i].setVisible(false);
                    }

                    function showProv(provinsi) {
                        provinsi = provinsi.trim();
                        var n = 0;
                        for (var i = 0; i < data.length; i++) {
                            if (data[i]['ID_PROV'] == provinsi) {
                                areaMarkers[i].setVisible(true);
                                n++;
                            } else {
                                areaMarkers[i].setVisible(false);
                            }
                        }
                        return n;
                    }
                    //marker tiap provinsi
                    var prov = base_url + 'smigroup/StockLevelGudang/getProvinsi';
                    $.getJSON(prov, function (data) {
                        /* kode untuk menampilkan banyak marker */
                        var marker;
                        $.each(data, function (key, val) {
                            var level = hitungLevelProv(val.KD_PROV);
                            var warnaLevel = '';
                            if (level <= 30) {
                                icons = base_url + 'assets/img/map_icons/merah_big.png';
                                warnaLevel = '<h1 class="no-margins" style="color:red; font-weight:bold;">' + level + '%</h1>';
                            } else if (level > 30 && level <= 70) {
                                icons = base_url + 'assets/img/map_icons/kuning_big.png';
                                warnaLevel = '<h1 class="no-margins" style="color:#eaec00; font-weight:bold;">' + level + '%</h1>';
                            } else if (level > 70 && level < 100) {
                                icons = base_url + 'assets/img/map_icons/hijau_big.png';
                                warnaLevel = '<h1 class="no-margins" style="color:green; font-weight:bold;">' + level + '%</h1>';
                            } else if (level >= 100) {
                                icons = base_url + 'assets/img/map_icons/biru_big.png';
                                warnaLevel = '<h1 class="no-margins" style="color:blue; font-weight:bold;">' + level + '%</h1>';
                            } else {
                                icons = base_url + '';
                            }

                            var n = hitungJumlahGudang(val.KD_PROV);

                            marker = new google.maps.Marker({
                                position: new google.maps.LatLng(val.LATITUDE, val.LONGITUDE),
                                map: map,
                                icon: icons
                            });

                            provMarkers.push(marker);

                            /* menambahkan event clik untuk menampikan
                             infowindows dengan isi sesuai denga
                             marker yang di klik */
                            google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
                                return function () {
                                    if (n > 0) {
                                        infowindow.setContent(
                                                '<h5 class="border-bottom" style="color: black">' + val.NM_PROV + '</h5>' +
                                                '<small>Stok Level On Hand</small>' +
                                                warnaLevel +
                                                '<small style="color: black">' + n + ' Gudang</small>'
                                                //"<center><h3>"+val.NM_PROV+"<br/>"+n+" GUDANG</h3></center>"
                                                );
                                        infowindow.open(map, marker);
                                    }
                                };
                            })(marker, key));
                            google.maps.event.addListener(marker, 'mouseout', function () {
                                infowindow.close(map, marker);
                            }.bind(this));
                            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                                return function () {
                                    click = true;
                                    hideMarkersAll();
                                    if (showProv(val.KD_PROV) <= 0) {
                                        showProvGud(val.KD_PROV);
                                    }
                                    ;
                                    map.setCenter(marker.getPosition());
                                    map.setZoom(8);
                                    for (var i = 0; i < provMarkers.length; i++) {
                                        provMarkers[i].setVisible(false);
                                    }
                                };
                            })(marker, key));
                        });
                    });//getjson
                });//getjson

                google.maps.event.addListener(map, 'zoom_changed', function () {
                    var nZoom = map.getZoom();
                    if (nZoom <= 6) {
                        click = false;
                        for (var i = 0; i < provMarkers.length; i++) {
                            provMarkers[i].setVisible(true);
                        }

                        hideMarkersAll();
                    } else if (nZoom > 6 && nZoom < 8) {
                        for (var i = 0; i < provMarkers.length; i++) {
                            provMarkers[i].setVisible(false);
                        }
                        //showMarkers();
                    }
                    if (nZoom === 7 && click === false) {
                        for (var i = 0; i < areaMarkers.length; i++) {
                            areaMarkers[i].setVisible(true);
                        }
                        hideMarkersAll();
                    } else if (nZoom < 7 || nZoom >= 8) {
                        if ((nZoom === 8 || nZoom === 7) && click === false) {
                            for (var i = 0; i < areaMarkers.length; i++) {
                                areaMarkers[i].setVisible(false);
                            }
                        } else if (nZoom < 7) {
                            for (var i = 0; i < areaMarkers.length; i++) {
                                areaMarkers[i].setVisible(false);
                            }
                        } else if (nZoom > 8 && click === true) {
                            for (var i = 0; i < areaMarkers.length; i++) {
                                areaMarkers[i].setVisible(false);
                            }
                        }
                    }
                    if (nZoom >= 8 && click === false) {
                        showMarkers();
                    }
                });
            }).done(function () {
                $('#loading_purple').hide();
            }).fail(function () {
                alert("Error : Gagal mengambil data");
                $('#loading_purple').hide();
            });

        });
    });

</script>
<div class="modal fade" id="modal-chart">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1c84c6;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Chart</h4>
            </div>
            <div class="modal-body">

                <div id="pleasewait">Please Wait . . .</div>
                <div class="row" id="grafik">
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
                            <div class="col-md-2">
                                <label>Tahun</label>
                                <select id="tahun" class="form-control" name="tahun">
                                    <?php
                                    for ($i = 2015; $i <= Date('Y'); $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>    
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button id="filter" class="btn btn-success" style="margin-top:23px"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="Chart1" width="100%" height="50"></canvas>
                            <span id="text-source" style="display: block;text-align: center"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    var month = new Array(12);
    month[1] = "01";
    month[2] = "02";
    month[3] = "03";
    month[4] = "04";
    month[5] = "05";
    month[6] = "06";
    month[7] = "07";
    month[8] = "08";
    month[9] = "09";
    month[10] = "10";
    month[11] = "11";
    month[12] = "12";

    var g_type;
    var g_kdgdg;
    $(function () {
        $('#filter').click(function () {
            var tahun = $('#tahun').val();
            var bulan = $('#bulan').val();
            var flags = $('#inpFlags').val();
            var tanggal = tahun + '' + bulan;
            if(flags == 0){
                alert('Alert ' + flags);
                updateChart(g_kdgdg, tanggal, flags);
            }
            else{
                alert('Alert ' + flags);
                updateChartElogs(g_kdgdg, tanggal, flags);
            }
        });


    });
    function chart(kd_gdg, flag) {
        // alert('Kode - Gudang '+kd_gdg + ' - ' + flag);
        //alert(kd_gdg);        
        //g_type = type;
        g_kdgdg = kd_gdg;
        var d = new Date();
        var tahun = d.getUTCFullYear();
        var bulan = month[d.getUTCMonth() + 1];
        $('#bulan').val(bulan);
        $('#tahun').val(tahun);
        var tanggal = tahun + '' + bulan;
        var ctx1 = document.getElementById("Chart1");
        // var url = base_url + 'smigroup/StockLevelGudang/getChart/' + kd_gdg + '/' + tanggal;
        var url = base_url + 'smigroup/StockLevelGudang/getChart/' + kd_gdg + '/' + tanggal + '/' + flag;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $("#modal-chart").modal('show');
                $("#pleasewait").show();
                $("#grafik").hide();
                //Chart1.destroy();
                //Chart2.destroy();
            },
            success: function (data) {
                $('.modal-title').text(data['KODE_GUDANG'] + ' - ' + data['NAMA_GUDANG']);
                $('#text-source').html('Source Data : Area Manager' );
                var lineChartData = {
                    labels: data['TANGGAL'],
                    datasets: [
                        {
                            label: "30% KAPASITAS",
                            type: "line",
                            data: data['TIGAPULUH'],
                            fill: false,
                            pointRadius: 0,
                            borderColor: 'rgba(255, 33, 15, 1)',
                            backgroundColor: 'rgba(255, 33, 15, 1)'
                        }, {
                            label: "70% KAPASITAS",
                            type: "line",
                            data: data['TUJUHPULUH'],
                            fill: false,
                            pointRadius: 0,
                            borderColor: 'rgba(152, 255, 15, 1)',
                            backgroundColor: 'rgba(152, 255, 15, 1)'
                        }, {
                            label: "100% KAPASITAS",
                            type: "line",
                            data: data['SERATUS'],
                            fill: false,
                            pointRadius: 0,
                            borderColor: 'rgba(152, 33, 255, 1)',
                            backgroundColor: 'rgba(152, 33, 255, 1)'
                        }, {
                            label: "STOK GUDANG",
                            data: data['STOK'],
                            fill: false,
                            lineTension: 0,
                            borderColor: '#98210f',
                            backgroundColor: 'rgba(152, 33, 15, 1)'
                        }, {
                            label: "RILIS GUDANG",
                            data: data['RILIS'],
                            fill: false,
                            lineTension: 0,
                            borderColor: 'rgba(255, 255, 0, 1)',
                            backgroundColor: 'rgba(255, 255, 0, 1)'
                        }]
                };
                Chart1.destroy();
                Chart1 = new Chart.Bar(ctx1, {
                    data: lineChartData,
                    options: {
                        title: {
                            display: true,
                            text: 'Stok Gudang'
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + formatNumb(tooltipItem.yLabel) + ' TON';
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    stacked: false,
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
                                            return formatNumb(value);
                                        }
                                    }
                                }]
                        }
                    }
                });
                $("#pleasewait").hide();
                $("#grafik").show();
            }
        });
    }
    function updateChart(kd_gdg, tanggal, flags) {
        var ctx1 = document.getElementById("Chart1");
        // var url = base_url + 'smigroup/StockLevelGudang/getChart/' + kd_gdg + '/' + tanggal;
        var url = base_url + 'smigroup/StockLevelGudang/getChart/' + kd_gdg + '/' + tanggal + '/' + flags;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                //$("#modal-chart").modal('show');
                $("#pleasewait").show();
                $("#grafik").hide();
                //Chart1.destroy();
                //Chart2.destroy();
            },
            success: function (data) {
                //$('.modal-title').text(data['KODE_GUDANG']+' - '+data['NAMA_GUDANG']);
                var lineChartData = {
                    labels: data['TANGGAL'],
                    datasets: [
                        {
                            label: "30% KAPASITAS",
                            type: "line",
                            data: data['TIGAPULUH'],
                            fill: false,
                            lineTension: 0,
                            borderColor: 'rgba(255, 33, 15, 1)',
                            backgroundColor: 'rgba(255, 33, 15, 1)'
                        }, {
                            label: "70% KAPASITAS",
                            type: "line",
                            data: data['TUJUHPULUH'],
                            fill: false,
                            lineTension: 0,
                            borderColor: 'rgba(152, 255, 15, 1)',
                            backgroundColor: 'rgba(152, 255, 15, 1)'
                        }, {
                            label: "100% KAPASITAS",
                            type: "line",
                            data: data['SERATUS'],
                            fill: false,
                            lineTension: 0,
                            borderColor: 'rgba(152, 33, 255, 1)',
                            backgroundColor: 'rgba(152, 33, 255, 1)'
                        }, {
                            label: "STOK GUDANG",
                            data: data['STOK'],
                            fill: false,
                            lineTension: 0,
                            borderColor: '#98210f',
                            backgroundColor: 'rgba(152, 33, 15, 1)'
                        }, {
                            label: "RILIS GUDANG",
                            data: data['RILIS'],
                            fill: false,
                            lineTension: 0,
                            borderColor: 'rgba(255, 255, 0, 1)',
                            backgroundColor: 'rgba(255, 255, 0, 1)'
                        }]
                };
                Chart1.destroy();
                Chart1 = new Chart.Bar(ctx1, {
                    data: lineChartData,
                    options: {
                        title: {
                            display: true,
                            text: 'Stok Gudang'
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + formatNumb(tooltipItem.yLabel) + ' TON';
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    stacked: false,
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
                                            return formatNumb(value);
                                        }
                                    }
                                }]
                        }
                    }
                });
                $("#pleasewait").hide();
                $("#grafik").show();
            }
        });
    }

    function chartElogs(kd_gdg, flag) {
        // alert('Kode - Gud ang '+kd_gdg + ' - ' + flag);
        //alert(kd_gdg);        
        //g_type = type;
        g_kdgdg = kd_gdg;
        var d = new Date();
        var tahun = d.getUTCFullYear();
        var bulan = month[d.getUTCMonth() + 1];
        $('#bulan').val(bulan);
        $('#tahun').val(tahun);
        var tanggal = tahun + '' + bulan;
        var ctx1 = document.getElementById("Chart1");
        // var url = base_url + 'smigroup/StockLevelGudang/getChart/' + kd_gdg + '/' + tanggal;
        var url = base_url + 'smigroup/StockLevelGudang/getChart/' + kd_gdg + '/' + tanggal + '/' + flag;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $("#modal-chart").modal('show');
                $("#pleasewait").show();
                $("#grafik").hide();
                //Chart1.destroy();
                //Chart2.destroy();
            },
            success: function (data) {
                $('.modal-title').text(data['KODE_GUDANG'] + ' - ' + data['NAMA_GUDANG']);
                $('#text-source').html('Source Data : Data By Distriutor' );
                var lineChartData = {
                    labels: data['TANGGAL'],
                    datasets: [
                        {
                            label: "30% KAPASITAS",
                            type: "line",
                            data: data['TIGAPULUH'],
                            fill: false,
                            pointRadius: 0,
                            borderColor: 'rgba(255, 33, 15, 1)',
                            backgroundColor: 'rgba(255, 33, 15, 1)'
                        }, {
                            label: "70% KAPASITAS",
                            type: "line",
                            data: data['TUJUHPULUH'],
                            fill: false,
                            pointRadius: 0,
                            borderColor: 'rgba(152, 255, 15, 1)',
                            backgroundColor: 'rgba(152, 255, 15, 1)'
                        }, {
                            label: "100% KAPASITAS",
                            type: "line",
                            data: data['SERATUS'],
                            fill: false,
                            pointRadius: 0,
                            borderColor: 'rgba(152, 33, 255, 1)',
                            backgroundColor: 'rgba(152, 33, 255, 1)'
                        }, {
                            label: "STOK GUDANG",
                            data: data['STOK'],
                            fill: false,
                            lineTension: 0,
                            borderColor: '#98210f',
                            backgroundColor: 'rgba(152, 33, 15, 1)'
                        }]
                };
                Chart1.destroy();
                Chart1 = new Chart.Bar(ctx1, {
                    data: lineChartData,
                    options: {
                        title: {
                            display: true,
                            text: 'Stok Gudang'
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + formatNumb(tooltipItem.yLabel) + ' TON';
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    stacked: false,
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
                                            return formatNumb(value);
                                        }
                                    }
                                }]
                        }
                    }
                });
                $("#pleasewait").hide();
                $("#grafik").show();
            }
        });
    }
    function updateChartElogs(kd_gdg, tanggal, flags) {
        var ctx1 = document.getElementById("Chart1");
        // var url = base_url + 'smigroup/StockLevelGudang/getChart/' + kd_gdg + '/' + tanggal;
        var url = base_url + 'smigroup/StockLevelGudang/getChart/' + kd_gdg + '/' + tanggal + '/' + flags;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                //$("#modal-chart").modal('show');
                $("#pleasewait").show();
                $("#grafik").hide();
                //Chart1.destroy();
                //Chart2.destroy();
            },
            success: function (data) {
                //$('.modal-title').text(data['KODE_GUDANG']+' - '+data['NAMA_GUDANG']);
                var lineChartData = {
                    labels: data['TANGGAL'],
                    datasets: [
                        {
                            label: "30% KAPASITAS",
                            type: "line",
                            data: data['TIGAPULUH'],
                            fill: false,
                            lineTension: 0,
                            borderColor: 'rgba(255, 33, 15, 1)',
                            backgroundColor: 'rgba(255, 33, 15, 1)'
                        }, {
                            label: "70% KAPASITAS",
                            type: "line",
                            data: data['TUJUHPULUH'],
                            fill: false,
                            lineTension: 0,
                            borderColor: 'rgba(152, 255, 15, 1)',
                            backgroundColor: 'rgba(152, 255, 15, 1)'
                        }, {
                            label: "100% KAPASITAS",
                            type: "line",
                            data: data['SERATUS'],
                            fill: false,
                            lineTension: 0,
                            borderColor: 'rgba(152, 33, 255, 1)',
                            backgroundColor: 'rgba(152, 33, 255, 1)'
                        }, {
                            label: "STOK GUDANG",
                            data: data['STOK'],
                            fill: false,
                            lineTension: 0,
                            borderColor: '#98210f',
                            backgroundColor: 'rgba(152, 33, 15, 1)'
                        }]
                };
                Chart1.destroy();
                Chart1 = new Chart.Bar(ctx1, {
                    data: lineChartData,
                    options: {
                        title: {
                            display: true,
                            text: 'Stok Gudang'
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + formatNumb(tooltipItem.yLabel) + ' TON';
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    stacked: false,
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
                                            return formatNumb(value);
                                        }
                                    }
                                }]
                        }
                    }
                });
                $("#pleasewait").hide();
                $("#grafik").show();
            }
        });
    }
</script>
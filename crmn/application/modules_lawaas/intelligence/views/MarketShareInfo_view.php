<link href="<?php echo base_url(); ?>assets/css/plugins/slick/slick.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/plugins/slick/slick-theme.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/plugins/slick/slick.min.js"></script>

<style>
    .panel{
        position: relative;
        width: 110%;
        right: 5%;
    }
    td {

        vertical-align: middle !important;
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
        z-index:1010 !important;
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
        left: 95px;
        position: fixed;
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

    .ui-dialog{
        min-width: 500px;
    }
    .lightBoxGallery {
        text-align: left;
    }
    .lightBoxGallery img {
        margin: 5px;
    }
    #blueimp-gallery .title{
        bottom: 25px !important;
        top: auto !important;
    }

    .set-pop{
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
    }

    #right-sidebar{
        top :30px;
        z-index:100!important;
    }

    .intermark{
        padding-left: 0;
        padding-right: 0;
        padding-top: 24px;
    }

    .intermark-text{
        display: inline-block;
        font-weight: 700;
        padding-left: 5px;
        vertical-align: middle;
        padding-top: 10px;
    }
    .intermark-img{
        display: inline-block;
    }

</style>

<div class="lightBoxGallery" id="lightBoxGallery">
    <div id="blueimp-gallery" class="blueimp-gallery" style="background: #000;">
        <div class="slides"></div>
        <h3 class="title" style="display: block;"></h3>
        <a class="prev" style="display: block;">‹</a>
        <a class="next" style="display: block;">›</a>
        <a class="close" style="display: block;">×</a>
        <a class="play-pause" style="display: block;"></a>
        <ol class="indicator" style="display: block;"></ol>
    </div>
</div>


<div id="loading_purple"></div>
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="col-md-12">
                <div class="col-md-1">

                </div>


                <div class="col-md-11">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Company</label>
                            <select id="org" class="form-control">
                                <option value="1">SMI Group</option>
                                <option value="7000">Semen Gresik</option>
                                <option value="3000">Semen Padang</option>
                                <option value="4000">Semen Tonasa</option>
                            </select>
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
                        <div class="col-md-3">
                            <label>Tahun</label>
                            <select id="tahun" class="form-control" name="tahun">
                                <?php
                                $tahunSekarang = Date('Y');
                                for ($i = 2016; $i <= $tahunSekarang; $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>   
                            </select>
                        </div>
                        <div class="col-md-1" style="padding-right:0;width:7% !important">
                            <button id="filter" class="btn btn-success" style="margin-top:24px"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col-md-2 intermark">
                            <a href="javascript:void(0)" onclick="getDetail('0001');"><img src="<?= base_url() ?>assets/img/globe-icon.png" width="18%" class="intermark-img"/><span class="intermark-text">International Market </span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    <div class="panel-body">
        <div class="row">
            <div id="chart1"></div>
            <div class="" style="text-align:center;font-size: 11px;"><strong>* Persen realisasi volume s.d kemarin terhadap RKAP</strong></div>
        </div>   
        <div class="row">

        </div> 
    </div>
</div>
<!--Icon Notifikasi-->
<div id="small-chat" style="left: 96.5%;" >
    <span class="badge badge-warning pull-right">

        <?= $countNews ?>

    </span>
    <a class="open-small-chat right-sidebar-toggle">
        <i class="fa fa-list-alt"></i>
    </a>
</div>	
<!--Start Notifikasi-->
<div id="right-sidebar" class="small-chat-box fadeInRight animated" style="height:592px;margin-right: 3.7%;margin-top: 2%;">

    <div class="heading" draggable="true" style="background:#ec4758">
<!--                <small class="chat-date pull-right">
        <?= date('d-m-Y') ?>
                </small>-->
        Notification
    </div>
    <div class="form-chat">
        <div class="input-group input-group-sm"><span class="input-group-addon" id="reset-news"  style="cursor:pointer">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" class="form-control date" id="sort-news"> </div>
    </div>

    <div class="scrollbar" id="style-1" style="overflow:auto ;height: 86%;overflow-x: hidden;">
        <!--<div class="left">-->
        <div class="tab-pane active list-group elements-list news-list" id="info2" style="margin-top: -10px"></div>
        <!--</div>-->


    </div>

</div>
<!--End Notifikasi-->
<div class="table-popup" id="table-dialog">
    <table class="table table-hover border-bottom white-bg" id="data-table">

        <tbody>
            <!-- DATA WILL LOAD HERE -->
        </tbody>       
    </table>
</div>

<div class="table-popup" id="detail_foto">
    <div class='row'>


    </div>
</div>


<?php if ($this->session->userdata('akses') == 1) { ?>
    <div class="row">
        <div class="col-lg-3">
            <div class="panel panel-success" style="position: fixed;bottom: 1px;left: 50px;z-index: 100; width:20%">
                <div class="panel-heading" style="font-weight:bold;background: #337ab7;color:#fff">
                    <i class="fa fa-info-circle"></i> Entry Market Info
                </div>
                <br>
                <table>
                    <tr>
                        <td><a target="_blank" href="<?php echo site_url('intelligence/MarketInfo/masterInformasi') ?>" style="color:#fff;"><button class="btn btn-success dim btn-xs" style="margin: 0px 15px;background: #337ab7"><i class="fa fa-plus-circle"></i> Master Market Info</button></a></td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
<?php } ?>
<!-- <div id="small-chat">
    <a class="open-small-chat">
        <i class="fa fa-list"></i>
    </a>
</div>
<div id="small-chat2" onclick="showHistoryChart(1)">
    <a class="open-small-chat">
        <i class="fa fa-list"></i>
    </a>
</div> -->
<!-- <div class="small-chat-box fadeInRight animated"> -->


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
    var tahun = d.getUTCFullYear();
    var bulan = month[d.getUTCMonth()];
    function peta() {
        var peta;
        var url = base_url + 'intelligence/MarketInfo/scodata/' + org + '/' + tahun + '/' + bulan + '/';
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
        var url = base_url + 'intelligence/MarketInfo/detailProv/' + prov + '/' + org + '/' + bulan + '/' + tahun;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $("#data-table tbody").html(data.data);
                //$("#porsi").html(data.porsi);
                // $("#growthmom").html(data.growthMOM);
                //$("#growthyoy").html(data.growthYOY);
//                $("#growthkumyoy").html(data.growthkumYOY);
//                $(".provinsi").html(data.provinsi);
                $('#table-dialog').dialog({
                    autoOpen: false,
                    title: "Detail",
                    show: "fade",
                    hide: "explode",
                    modal: true,
                    width: 'auto',
                    responsive: true
                });

                $('#table-dialog').dialog('option', 'title', 'Detail ' + data.prov);
                $('#table-dialog').dialog("open");
                $(window).scrollTop(0);
                $('#loading_purple').hide();
            }
        });
    }

    function detailFoto(prov, tipe) {
        $.ajax({
            url: base_url + 'intelligence/MarketInfo/getFoto/' + prov + '/' + tipe,
            type: 'post',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $("#detail_foto .row").html(data);
                $('#detail_foto').dialog({
                    autoOpen: false,
                    title: "Detail",
                    show: "fade",
                    hide: "fade",
                    modal: true,
                    width: 'auto',
                    responsive: true
                });

                $('#detail_foto').dialog('option', 'title', (tipe == 'LAPANGAN' ? 'Foto Lapangan' : 'Gambar Grafik'));
                $('[aria-describedby="detail_foto"]').addClass('set-pop');
                $('#detail_foto').dialog("open");
                // jumps browser window to the top when modal is fired
                $(window).scrollTop(0);

                $('#loading_purple').hide();
            }
        });
    }

    //fungsi untuk update peta
    function updatePeta(org) {
        var dataPeta;
        var url = base_url + 'intelligence/MarketInfo/scodata/' + org + '/' + tahun + '/' + bulan;
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
            }
        });
    }

//    function updatePeta(org) {
//        var dataPeta;
//        var url = base_url + 'intelligence/MarketShare/getData/' + org + '/' + tahun + '/' + bulan;
//        $.ajax({
//            url: url,
//            type: 'post',
//            dataType: 'json',
//            beforeSend: function () {
//                $('#loading_purple').show();
//            },
//            success: function (data) {
//                $('#chart1').updateFusionCharts({"dataSource": data, "dataFormat": "json"});
//                $('#loading_purple').hide();
//            }
//        });
//    }


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

    function getNotif() {
        $.ajax({
            type: 'GET',
            url: base_url + 'intelligence/MarketInfo/getNews',
            contentType: 'application/json',
            dataType: 'json',
            success: function (data) {
                var list = '';
                for (var i = 0; i < data.length; i++) {
                    list += '<li class="sidebar-message list-group-item news-info" data-category="' + data[i]['LOGTIME'] + '">' +
                            '<strong> Provinsi ' + data[i]['NM_PROV'] + '</strong>' +
                            '<br>' +
                            '<strong>' + (data[i]['NAMA_INFO'] == null ? (data[i]['TIPE'] == 'LAPANGAN' ? 'Foto Lapangan' : 'Gambar Grafik') : data[i]['NAMA_INFO']) + '</strong>' +
                            '<br>' +
                            '<small class="text-muted">' + data[i]['LOGTIME'] + '</small>' +
                            '<div class="small m-t-xs" id="zoom">' + '<p style="margin: 0 0 5px;width: 195px;">'
                            + data[i]['AUTHOR'] + ' telah ' + data[i]['ACTION'].toString().toLowerCase() + '.'
                            + '</p>' + '<a href="javascript:void(0)" onClick="getDetail(\'' + data[i]['PROVID'] + '\')" >'
                            + '<p class="m-b-none">' + '<i class="fa fa-map-marker"></i>' + ' Show Information</p></a>' + '</div>' + '</li>';
                }
                $('#info2').html(list);
            }
        });
        //  Reset tanggal
        $("#reset-news").click(function () {
            $('.date').val("");
            var list = $(".news-list .news-info");
            $(list).fadeOut("fast");
            $(".news-list").find("li").each(function (p) {
                $(this).delay(200).slideDown("fast");
            }).on('changeDate', function (e) {
            });
        });

        // Memanggil proses filter
        $('#sort-news').change(function () {
            var filter = $(this).val();
            filterList(filter);
        });

    }


    // Proses filter notifikasi sidebar berdasarkan tanggal
    function filterList(filter) {
        var list = $(".news-list .news-info");
        $(list).fadeOut("fast");
        if (filter === "") {
            $(".news-list").find("li").each(function (p) {
                $(this).delay(200).slideDown("fast");
            });
        } else {
            $(".news-list").find('li[data-category="' + filter + '"]').each(function (x) {
                $(this).delay(200).slideDown("fast");
            });
        }
    }


    $(function () {
        // Chart.defaults.global.defaultFontColor = '#000';
        //updateTime();
        $('#tahun').val(tahun);
        $('#bulan').val(bulan);
        $('#table-dialog').hide();
        $('#summary').hide();
        peta();
        getNotif();
        //summary();
        ///$('#tahun').val(tahun);
        //$('#bulan').val(bulan);
        //tanggal = $('#tahun').val() + '' + $('#bulan').val();


        $('#filter').click(function () {
            tahun = $('#tahun').val();
            bulan = $('#bulan').val();
            org = $('#org').val();
            updatePeta(org);
        });


        $("#small-chat").on("click", function () {
            $("#summary").dialog("open");

            if ($(this).find('i').hasClass('fa-remove')) {
                $(this).find('i').removeClass('fa-remove').addClass('fa-list');
            }

        });



        $('.slick_demo_1').slick({
            dots: true
        });

        $('.slick_demo_2').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            centerMode: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('.slick_demo_3').slick({
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear',
            adaptiveHeight: true
        });



    });
</script>


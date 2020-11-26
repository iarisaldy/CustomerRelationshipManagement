<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2 style="float: right;">Bulan : <?php echo date('F'); ?></h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-md-3">
                                    <div style="background-color: #009688; color: #fff;">
                                       <div class="topcard" style="background-color: #05b1a1; padding: 20px; ">
                                           <p><strong>VOLUME (TON)</strong></p>
                                           <h1 id="real_volume" style="margin-top: 10px;"></h1>
                                       </div>
                                       <div class="btcard" style="text-align: right; padding: 15px 20px;">
                                           <h2 style="margin-top: 10px;"><span id="nilai_volume"></span> &nbsp;&nbsp;<span id="indikator_vol" class="glyphicon pull-right"></span></h2>
                                       </div> 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    <div style="background-color: #F44336; color: #fff;">
                                       <div class="topcard" style="background-color: #f3594e; padding: 20px; ">
                                           <p><strong>HARGA</strong></p>
                                           <h1 id="real_harga" style="margin-top: 10px;"></h1>
                                       </div>
                                       <div class="btcard" style="text-align: right; padding: 15px 20px;">
                                           <h2 style="margin-top: 10px;"><span id="nilai_harga"></span> &nbsp;&nbsp;<span id="indikator_harga" class="glyphicon pull-right"></span></h2>
                                       </div> 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    <div style="background-color: #2196F3; color: #fff;">
                                       <div class="topcard" style="background-color: #33a1f9; padding: 20px; ">
                                           <p><strong>REVENUE (JUTA)</strong></p>
                                           <h1 id="real_revenue" style="margin-top: 10px;"></h1>
                                       </div>
                                       <div class="btcard" style="text-align: right; padding: 15px 20px;">
                                           <h2 style="margin-top: 10px;"><span id="nilai_revenue"></span> &nbsp;&nbsp;<span id="indikator_rev" class="glyphicon pull-right"></span></h2>
                                       </div> 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    <div style="background-color: #FF9800; color: #fff;">
                                       <div class="topcard" style="background-color: #ffa015; padding: 20px; ">
                                           <p><strong>KUNJUNGAN</strong></p>
                                           <h1 id="real_kunjungan" style="margin-top: 10px;"></h1>
                                       </div>
                                       <div class="btcard" style="text-align: right; padding: 15px 20px;">
                                           <h2 style="margin-top: 10px;"><span id="nilai_kunjungan"></span> &nbsp;&nbsp;<span id="indikator_kun" class="glyphicon pull-right"></span></h2>
                                       </div> 
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="chart-container"></div>
                                </div>

                                <!-- <div class="col-md-12"> -->
                                    <div class="col-md-4">
                                        <div id="pie-container"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="pie2-container"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="line-mini-container"></div>
                                    </div>
                                <!-- </div> -->
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var idUser = <?php echo $this->session->userdata("user_id"); ?>;

    $("document").ready(function(){
        var bulan = <?php echo date('m')-1 ?>;
        var bulanSkrang = <?php echo date('m') ?>;
        var tahun = <?php echo date('Y') ?>;
        $.ajax({
            url: "<?php echo base_url() ?>administrator/Home/getIdentitas/"+idUser,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                var idJenisUser = <?php echo $this->session->userdata("id_jenis_user"); ?>;
                if(idJenisUser == "1002"){
                    var idProvinsi = data.data[0]["ID_PROVINSI"];
                } else {
                    var idProvinsi = data.data["ID_PROVINSI"];
                }
                
                pieCharRetail(bulan, idProvinsi);
                countDownCluster(bulanSkrang, idProvinsi);
            }
        });
        speed();
        nilaiKpi();
        lineChart(bulanSkrang, tahun);
    });

    function nilaiKpi(){
        $.ajax({
            url : "<?php echo base_url(); ?>smi/KeyPerformanceIndicator/detailKpi",
            type : "POST",
            data: {
                "id_user" : idUser
            },
            dataType: "JSON",
            success: function(data){
                var prosen_target_vol = data.data[0][5];
                var real_volume = data.data[0][6];
                var prosen_volume = data.data[0][7];

                var prosen_target_harga = data.data[1][5];
                var real_harga = data.data[1][6];
                var prosen_harga = data.data[1][7];

                var prosen_target_rev = data.data[2][5];
                var real_revenue = data.data[2][6];
                var prosen_revenue = data.data[2][7];

                var prosen_target_kunjungan = data.data[3][5];
                var real_kunjungan = data.data[3][6];
                var prosen_kunjungan = data.data[3][7];

                if(parseInt(prosen_volume) >= 100){
                    $("#indikator_vol").addClass("glyphicon-circle-arrow-up");
                } else {
                    $("#indikator_vol").addClass("glyphicon-circle-arrow-down");
                }

                if(parseInt(prosen_harga) >= 100){
                    $("#indikator_harga").addClass("glyphicon-circle-arrow-up");
                } else {
                    $("#indikator_harga").addClass("glyphicon-circle-arrow-down");
                }

                if(parseInt(prosen_revenue) >= 100){
                    $("#indikator_rev").addClass("glyphicon-circle-arrow-up");
                } else {
                    $("#indikator_rev").addClass("glyphicon-circle-arrow-down");
                }

                if(parseInt(prosen_kunjungan) >= 100){
                    $("#indikator_kun").addClass("glyphicon-circle-arrow-up");
                } else {
                    $("#indikator_kun").addClass("glyphicon-circle-arrow-down");
                }

                $("#real_volume").html(real_volume);
                $("#nilai_volume").html(prosen_volume);
                $("#real_harga").html(real_harga);
                $("#nilai_harga").html(prosen_harga);
                $("#real_revenue").html(real_revenue);
                $("#nilai_revenue").html(prosen_revenue);
                $("#real_kunjungan").html(real_kunjungan);
                $("#nilai_kunjungan").html(prosen_kunjungan);
            }
        });
    }

    function speed(){
        $.ajax({
            url: "<?php echo base_url(); ?>smi/KeyPerformanceIndicator/detailKpi",
            type: "POST",
            data : {
                "id_user" : idUser
            },
            dataType: "JSON",
            success: function(data){
                var total = parseInt(data.data[0][8]) + parseInt(data.data[1][8]) + parseInt(data.data[2][8]) + parseInt(data.data[3][8]);
                FusionCharts.ready(function(){
                    var fusioncharts = new FusionCharts({
                        type: 'angulargauge',
                        renderAt: 'line-mini-container',
                        width: '100%',
                        height: '250',
                        dataFormat: 'json',
                        dataSource: {
                            "chart": {
                                "caption": "Nilai Total KPI",
                                "subcaption": "(<?php echo date('F') ?>)",
                                "lowerLimit": "0",
                                "upperLimit": "100",
                                "theme": "fusion",
                                "bgColor": "#ffffff",
                                "showBorder": "0"
                            },
                            "colorRange": {
                                "color": [{
                                    "minValue": "0",
                                    "maxValue": "50",
                                    "code": "#e44a00"
                                },{
                                    "minValue": "50",
                                    "maxValue": "75",
                                    "code": "#f8bd19"
                                },{
                                    "minValue": "75",
                                    "maxValue": "100",
                                    "code": "#6baa01"
                                }]
                            },
                            "dials": {
                                "dial": [{
                                    "value": total
                                }]
                            }
                        }
                    });
                    fusioncharts.render();
                });
            }
        });
    }

    function pieCharRetail(bulan, provinsi){
        $.ajax({
            url: "<?php echo base_url() ?>smi/RetailActivation/chartRetailActivation",
            type: "POST",
            dataType: "JSON",
            data: {
                "bulan" : bulan,
                "provinsi" : provinsi,
            },
            success: function(data){
                FusionCharts.ready(function(){
                    var fusioncharts = new FusionCharts({
                        type: 'pie2d',
                        renderAt: 'pie-container',
                        width: '100%',
                        height: '350',
                        dataFormat: 'json',
                        dataSource: {
                            "chart": {
                            "caption": "Grafik Toko Aktif & Nonaktif",
                            "subCaption" : "(<?php echo date('F') ?>)",
                            "drawcrossline": "1",
                            "bgColor": "#ffffff",
                            "showBorder": "0",
                            "showLabels": "0",
                            "showCanvasBorder": "0",
                            "palettecolors": "#008ee4,#f8bd19",
                            "usePlotGradientColor": "0",
                            "valueFontColor": "#000000",
                            "use3dlighting": "0",
                            "showlegend": "1",
                            "showshadow": "0",
                            "legendbgcolor": "#CCCCCC",
                            "legendbgalpha": "20",
                            "legendborderalpha": "0",
                            "legendshadow": "0",
                            "legendnumcolumns": "3",
                            "enableRotation" : "0",
                            "formatNumberScale": "0",
                            "legendBgColor": "#ffffff",
                            "legendPosition": "right"
                        },
                        "data": data.data
                    }
                });
                    fusioncharts.render();
                });
            }
        });
    }

    var countDownCluster = function(bulan, provinsi){
        var day = "<?php echo date('d'); ?>";
        var tahun = "<?php echo date('Y');  ?>";
        if(bulan == 1){
            tahun = tahun-1;
            bulan = 12;

            if(day < 20){
                bulan = bulan-1;
            }
        }
       
       $.ajax({
            url: "<?php echo base_url() ?>smi/ClusterRetail/clusterProvinsi/"+provinsi+"/"+bulan+"/"+tahun,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                if(data.status == "error"){
                    return countDownCluster(bulan-1, provinsi);
                } else {
                    var bulanLast = parseInt(bulan);
                    pieChartCluster(data, bulanLast);
                }
            }
        });
    }

    function pieChartCluster(data, bulan){
        const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"];

        FusionCharts.ready(function(){
            var fusioncharts = new FusionCharts({
                type: 'pie2d',
                renderAt: 'pie2-container',
                width: '100%',
                height: '350',
                dataFormat: 'json',
                dataSource: {
                    "chart": {
                        "caption": "Cluster Volume Penjualan Toko",
                        "subCaption" : "("+monthNames[bulan]+")",
                        "drawcrossline": "1",
                        "bgColor": "#ffffff",
                        "showBorder": "0",
                        "showLabels": "0",
                        "showCanvasBorder": "0",
                        "formatNumber": "0",
                        "usePlotGradientColor": "0",
                        "valueFontColor": "#000000",
                        "use3dlighting": "0",
                        "showlegend": "1",
                        "showshadow": "0",
                        "legendbgcolor": "#CCCCCC",
                        "legendbgalpha": "20",
                        "legendborderalpha": "0",
                        "legendshadow": "0",
                        "legendnumcolumns": "3",
                        "enableRotation" : "0",
                        "formatNumberScale": "0",
                        "legendBgColor": "#ffffff",
                        "legendPosition": "right"
                    },
                    "data": data.data
                }
            });
            fusioncharts.render();
        });
    }

    function lineChart(bulan, tahun){
        var idJenisUser = <?php echo $this->session->userdata("id_jenis_user") ?>;
        if(idJenisUser == "1001"){
            idUser = <?php echo $this->session->userdata("user_id") ?>;
        }
        $.ajax({
            url: "<?php echo base_url(); ?>administrator/home/kunjunganHarian/"+idUser+"/"+bulan+"/"+tahun,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                FusionCharts.ready(function(){
                    var fusioncharts = new FusionCharts({
                        type: 'line',
                        renderAt: 'chart-container',
                        width: '100%',
                        height: '400',
                        dataFormat: 'json',
                        dataSource: {
                            "chart": {
                                "theme": "fusion",
                                "caption": "Kunjungan Harian",
                                "subCaption": "",
                                "xAxisName": "Tanggal",
                                "yAxisName": "Total Kunjungan",
                                "lineThickness": "2",
                                "bgColor": "#ffffff",
                                "showBorder": "0",
                                "drawcrossline": "1",
                                "showCanvasBorder": "0",
                                "palettecolors": "#D45704",
                                "formatNumber": "0",
                                "formatNumberScale": "0"
                            },
                            "data": data.data,
                            "trendlines": data.trendlines
                        }
                    });
                    fusioncharts.render();
                });
            }
        });
    }
</script>
<style>
#mapsRetailActivation {
    height: 450px;
	position: relative;
	overflow: hidden;
	width: 100%;
}
.gm-style-mtc {
    display: none;
}
.info-header{
    width:400px;
    overflow:hidden;
}
.modal {
    text-align: center;
    padding: 0!important;
    overflow-y:auto;
}
.modal:before {
    content: '';
    display: inline-block;
    height: 100%;
    vertical-align: middle;
    margin-right: -4px; /* Adjusts for spacing */
}
.modal-dialog {
    display: inline-block;
    text-align: left;
    vertical-align: middle;
}
.headerDivider {
    border-left:1px solid #38546d; 
    border-right:1px solid #16222c; 
    height:80px;
    position:absolute;
    right:249px;
    top:10px; 
}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header header-title">
                        <h2>Retail Activation</h2>
                    </div>
                    <?php
                        $dataMenu = $menus['dataMenu']; 
                        $subMenus = $menus['subMenu'];

                        foreach ($dataMenu as $menusKey => $menusValue) { 
                            // echo $menusValue->ID_MENU;
                         if($menusValue->ID_MENU == '1011'){ 
                    ?>
                        <ul class="submenus">
                        <?php 
                            foreach ($subMenus as $subMenusKey => $subMenusValue) {
                                if($subMenusValue->ID_MENU == $menusValue->ID_MENU){
                        ?>
                            <li><a href="<?php echo base_url().$subMenusValue->LINK; ?>"><?php echo $subMenusValue->NAMA_MENU; ?></a></li>
                            <?php } } ?>
                        </ul>
                    <?php }
                    } ?>
                    
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                                <?php if($this->session->userdata("id_jenis_user") == "1002" || $this->session->userdata("id_jenis_user") == "1003" || $this->session->userdata("id_jenis_user") == "1005"){ ?>
                                <div style="float: right; width: 15%;">
                                    Filter Bulan : 
                                    <select id="filterBulan2" class="form-control show-tick" data-size="5">
                                        <option>Pilih Bulan</option>
                                        <?php for($i=1;$i<=12;$i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div style="float: right;width: 15%;">
                                    Filter Tahun : 
                                    <select id="filterTahun2" class="form-control show-tick" data-size="5">
                                        <option>Pilih Tahun</option>
                                        <?php for($j=date('Y')-1;$j<=date('Y')+1;$j++){ ?>
                                        <option value="<?php echo $j; ?>" <?php if(date('Y') == $j){ echo "selected";} ?>><?php echo $j; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php } ?>
                                <div id="mapsRetailActivation"></div>
                                <div id="chart-sales">
                                	<div class="col-md-6">
                                		<div id="chart-container-sales" style="margin-top: 55px;"></div>
                                	</div>
                                	<div class="col-md-6">
                                		<div id="chart-cluster-sales"></div>
                                	</div>
                                </div>
                                <input type="hidden" id="id_provinsi_filter">
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>

        <!-- Modal add survey -->
                <div class="modal fade" id="defaultModal" tabindex="0" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                                <h4 class="modal-title" id="defaultModalLabel">GRAFIK TOKO <span id="headerDetailChart"></span></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="card">
                                            <div class="body">
                                            <div id="chart-detail"></div>
                                            </div>
                                        </div>
                                        
                                        <hr/>
                                        <div class="card" id="cardTrackRecord">
                                            <div class="body">
                                            <div id="chart-track-record"></div>
                                            </div>
                                        </div>
                                        
                                        <center>
                                            <div class="preloader pl-size-xl" id="detailProgress" style="display:block;">
                                                <div class="spinner-layer">
                                                    <div class="circle-clipper left">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="circle-clipper right">
                                                        <div class="circle"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- end modal add survey -->

        <!-- Modal Grafik Awal -->
            <div class="modal fade" id="detailActivationProvinsi" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #00b0e4;color: white;">
                            <h4 class="modal-title" id="detailActivationProvinsiLabel"></h4>
                            <div style="float: right;width: 20%;">
                                <select id="filterBulan" class="form-control show-tick" data-size="5">
                                        <option>Pilih Bulan</option>
                                    <?php for($i=1;$i<=12;$i++){ ?>
                                        <option value="<?php echo $i; ?>" <?php if(date('m') == $i){ echo "selected";} ?>><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div style="float: right;width: 20%;margin-right: 12px;">
                                <select id="filterTahun" class="form-control show-tick" data-size="5">
                                        <option>Pilih Tahun</option>
                                    <?php for($i=date('Y')-1;$i<=date('Y')+1;$i++){ ?>
                                        <option value="<?php echo $i; ?>" <?php if(date('Y') == $i){ echo "selected";} ?>><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div style="color:red;margin-top:20px;">
                                <center>
                                <h4>
                                Total Toko : <b id="total" style="margin-right: 20px;"></b><br/>
                                Prosentase Toko Aktif : <b id="prosen"></b>
                                </h4>
                                <div id="progress" style="display:block">
                                </center>
                                </div>
                                
                                <div id="chart-container"></div>
                                <center>
                                    <div class="preloader pl-size-xl" id="detailProgressAwal" style="display:block;">
                                        <div class="spinner-layer">
                                            <div class="circle-clipper left">
                                                <div class="circle"></div>
                                            </div>
                                            <div class="circle-clipper right">
                                                <div class="circle"></div>
                                            </div>
                                        </div>
                                    </div>
                                </center>
                            </div>
                            
                            <div class="col-md-6" style="border-left: 3px dashed #00b0e4;height: 500px;">
                                <center><h4 style="color:red;">Cluster Penjualan Toko Aktif</h4></center>
                                <center>
                                    <div class="preloader pl-size-xl" id="clusterProgress" style="display:block;">
                                        <div class="spinner-layer">
                                            <div class="circle-clipper left">
                                                <div class="circle"></div>
                                            </div>
                                            <div class="circle-clipper right">
                                                <div class="circle"></div>
                                            </div>
                                        </div>
                                    </div>
                                </center>
                                <div id="chart-cluster" style="margin-top:50px;"></div>
                            </div>
                        </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End Modal Grafik Awal  -->

        <!-- Modal Data Toko -->
        <div class="modal fade" id="detailTokoRetailDistrik" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document" style="width:1200px;">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #00b0e4;color: white;">
                        <h4 class="modal-title" id="headerTableRetail"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <button id="btnExport" class="btn btn-info"><i class="fa fa-file-excel-o"></i> Download Data Toko</button>
                            <p>&nbsp;</p>
                            <div class="row">
                                <table id="tableDaftarTokoDistrik" class="table table-bordered table-striped" style="width: 100%; font-size:10px;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Toko</th>
                                            <th>Distributor</th>
                                            <th>Pemilik</th>
                                            <th>Kecamatan</th>
                                            <th>Alamat</th>
                                            <th>Tipe Toko</th>
                                            <th>Nama LT</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Data Toko -->

        <!-- Modal Track Record Perdistrik -->
        <div class="modal fade" id="detailTrackRecordDistrik" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document" style="width:1200px;">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #00b0e4;color: white;">
                        <h4 class="modal-title" id="headerTrackPerdistrik"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div id="chartTrackRecordDistrik"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Track Record Perdistrik -->

    </div>
</section>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDLcPZk5_QNfhUDokPNILm_jnB7-B7yvoY"></script>
<script>
    var marker_prov = new google.maps.Marker();
    var area_marker_prov = new Array();
    var infowindow = new google.maps.InfoWindow();
    $('document').ready(function(){
    	var idRole = "<?php echo $this->session->userdata('id_jenis_user'); ?>";
        var bulanLalu = "<?php echo date('m')-1;?>";
    	if(idRole == "1003" || idRole == "1002" || idRole == "1005"){
    		var idProvinsi = "<?php echo $this->session->userdata('id_provinsi'); ?>";
            console.log(idProvinsi);
    		$("#mapsRetailActivation").css("display", "none");
            var day = "<?php echo date('d'); ?>";
            if(day < 20){
                var bulanLalu = "<?php echo date('m'); ?>";
                var bulanLalu = parseInt(bulanLalu)-2;
                $("#filterBulan2").val(bulanLalu).change();
            } else {
                var bulanLalu = "<?php echo date('m'); ?>";
                var bulanLalu = parseInt(bulanLalu)-1;
                $("#filterBulan2").val(bulanLalu).change();
            }

    		clusterRetailProvinsi(idProvinsi, bulanLalu, "chart-cluster-sales");
    		retailActivationChart(idProvinsi, bulanLalu, "chart-container-sales");
    	} else {
    		$("#chart-sales").css("display", "none");
    		loadMapsChart();
    	}
    });

    $(document).on("click", "#btnExport", function(e){
        e.preventDefault();
        var jenis = $(this).data("jenis");
        var status = $(this).data("status");
        var distrik = $(this).data("distrik");
        var cluster = $(this).data("cluster");
        var bulan = $(this).data("bulan");
        var provinsi = $(this).data("provinsi");
        var tahun = $("#filterTahun2").val();

        window.open("<?php echo base_url() ?>smi/ExportExcel/toko?jenis="+jenis+"&status="+status+"&distrik="+distrik+"&cluster="+cluster+"&bulan="+bulan+"&provinsi="+provinsi+"&tahun="+tahun, "_blank");
    });

    $(document).on('show.bs.modal', '#detailTokoRetailDistrik', function(e){
    	var header = $("#headerTableRetail").html();
    	// console.log(header);
    });

    $(document).on('show.bs.modal', '.modal', function (event) {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });

    $(document).on("click", "#filterAction", function(e){
        e.preventDefault();
        var filterBulan = $("#filterBulan").val();
        var filterTahun = $("#filterTahun").val();
    });

    $(document).on("change", "#filterBulan", function(e){
        var idProvinsi = $("#id_provinsi_filter").val();
        var tahun = $("#filterTahun").val();
        var bulan = $(this).val();
        clusterRetailProvinsi(idProvinsi, bulan, null, tahun);
    });

    $(document).on("change", "#filterBulan2", function(e){
        var idProvinsi = 1025;
        var bulan = $(this).val();
        var tahun = $("#filterTahun2").val()
        clusterRetailProvinsi(idProvinsi, bulan, "chart-cluster-sales", tahun);
    });

    // Grafik Maps Awal
    function loadMapsChart(){
        $.ajax({
            url: "<?php echo base_url(); ?>smi/RetailActivation/tokoSize",
            type: "GET",
            dataType: "JSON",
            success: function(data){
                FusionCharts.ready(function(){
                    var fusioncharts = new FusionCharts({
                        type: 'maps/indonesia',
                        renderAt: 'mapsRetailActivation',
                        width: '100%',
                        height: '450',
                        dataFormat: 'json',
                        dataSource: {
                            "chart": {
                                "caption": "",
                                "theme": "fusion",
                                "formatNumberScale": "0",
                                "markerBgColor": "#00BCD4",
                                "entityFillColor": "#E9E9E9",
                                "entityFillHoverColor": "#C2C0C0",
                                "showMarkerLabels": "1",
                                "formatNumberScale": "0",
                                "includeNameInLabels": "1",
                                "legendItemFontColor": "#000",
                                "showCanvasBorder": "0"
                            },
                            "markers": { "items" : data.items }      
                        },
                        "events": {
                            "markerClick": function(evt, data){
                                var idProvinsi = data.id;
                                var bulanFilter = "<?php echo date('m'); ?>";
                                var tahunFilter = "<?php echo date('Y') ?>";
                                if(bulanFilter == 1){
                                    bulanFilter = 12;
                                    tahunFilter = parseInt(tahunFilter) - 1;
                                } else {
                                    bulanFilter = bulanFilter;
                                    tahunFilter = tahunFilter;
                                }
                                retailActivationProvinsi(idProvinsi, bulanFilter);
                                clusterRetailProvinsi(idProvinsi, bulanFilter, null, tahunFilter);
                                $("#id_provinsi_filter").val(idProvinsi);
                            },
                        }
                    });
                    fusioncharts.render();
                });
            }
        });
    }
    // End grafik maps awal

    // function klik menampilakan pie toko aktif/non aktif
    function retailActivationProvinsi(idProvinsi = null, bulan){
        $("#detailActivationProvinsi").modal("show");
        retailActivationChart(idProvinsi, bulan);
    }
    // end function klik menampilakan pie toko aktif/non aktif

    // Grafik pie awal sebelah kanan
    function clusterRetailProvinsi(idProvinsi = null, filterBulan = null, render, tahun = null){
        var idJenisUser = "<?php echo $this->session->userdata('id_jenis_user') ?>";
        // sementara hardcode
    	if(render == undefined){
    		 var rendered = "chart-cluster";
    	} else {
    		var rendered = "chart-cluster-sales";
    	}

        if(idJenisUser == "1002"){
            var idProvinsi = 1025;
        }

        $.ajax({
            url: "<?php echo base_url() ?>smi/ClusterRetail/clusterProvinsi/"+idProvinsi+"/"+filterBulan+"/"+tahun,
            type: "GET",
            dataType: "JSON",
            beforeSend: function(xhr){
                $("#clusterProgress").css("display", "block");
                $("#chart-cluster").css("display", "none");
            },
            success: function(data){
                $("#chart-cluster").css("display", "block");
                $("#clusterProgress").css("display", "none");
                const dataSource = {
                    "chart": {
                        "caption": "Cluster Volume Penjualan Toko",
                        "subCaption" : "(POIN)",
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
                        "formatNumberScale": "0"
                    },
                    "data": data.data
                };
                
                FusionCharts.ready(function() {
                    var myChart = new FusionCharts({
                        type: "pie2d",
                        renderAt: rendered,
                        width: "100%",
                        height: "400px",
                        dataFormat: "json",
                        dataSource,
                        events :  {
                            dataplotClick: function (eventObj, dataObj){
                                var text = dataObj.toolText;
                                if(idJenisUser == "1003" || idJenisUser == "1005" || idJenisUser == "1006" || idJenisUser == "1002"){
                                    var bulan = $("#filterBulan2").val();
                                    var tahun = $("#filterTahun2").val();
                                } else {
                                    var bulan = $("#filterBulan").val(); 
                                    var tahun = $("#filterTahun2").val(); 
                                }
                                
                                text = text.replace(/[0-9.,/%]/g, '');
                                detailClusterProvinsi(data.id_provinsi, text, bulan, tahun);
                            },
                            LegendItemClicked: function(eventObj, argsObj){
                                if(idJenisUser == "1003" || idJenisUser == "1005" || idJenisUser == "1006" || idJenisUser == "1002"){
                                    var bulan = $("#filterBulan2").val();
                                    var tahun = $("#filterTahun2").val();
                                } else {
                                    var bulan = $("#filterBulan").val();
                                    var tahun = $("#filterTahun").val(); 
                                }
                            	detailClusterProvinsi(data.id_provinsi, argsObj.datasetName+" ", bulan, tahun);
                            }
                        }
                    }).render();
                });
            }            
        });
    }
    // End grafik pie awal sebelah kanan

    // Grafik Batang setelah klik pie cluster
    function detailClusterProvinsi(idProvinsi, text, bulan, tahun){
        $("#chart-track-record").html("");
        $("#cardTrackRecord").css("display", "none");
        if(text == "SUPER PLATINUM "){
            $("#cardTrackRecord").css("display", "block");
            trackRecordCluster(idProvinsi, "SUPER PLATINUM", tahun);
            color = "#D45704";
        } else if(text == "PLATINUM "){
            color = "776C6C";
            $("#cardTrackRecord").css("display", "block");
            trackRecordCluster(idProvinsi, "PLATINUM", tahun);
            color = "#D45704";
        } else if(text == "GOLD "){
        	$("#cardTrackRecord").css("display", "block");
            trackRecordCluster(idProvinsi, "GOLD", tahun);
            color = "#D4AF37";
        } else if(text == "SILVER "){
        	$("#cardTrackRecord").css("display", "block");
            trackRecordCluster(idProvinsi, "SILVER", tahun);
            color = "#D0D0D0";
        } else if(text == "NON CLUSTER "){
        	$("#cardTrackRecord").css("display", "block");
            trackRecordCluster(idProvinsi, "NON CLUSTER", tahun);
            color = "#2BBE13";
        } else if(text == "TIDAK ADA PENJUALAN ", tahun){
            color = "#212F3C";
            color = "776C6C";
            $("#cardTrackRecord").css("display", "block");
            trackRecordCluster(idProvinsi, "TIDAK ADA PENJUALAN", tahun);
        }

        $("#defaultModal").modal("show");
        $.ajax({
            url: "<?php echo base_url() ?>smi/ClusterRetail/detailClusterProvinsi",
            type: "POST",
            dataType: "JSON",
            data: {
                "id_provinsi" : idProvinsi,
                "cluster" : text,
                "bulan" : bulan,
                "tahun" : tahun
            },
            beforeSend:function(xhr){
                $("#detailProgress").css("display", "block");
                $("#chart-detail").css("display", "none");
            },
            success:function(data){
                $("#detailProgress").css("display", "none");
                $("#chart-detail").css("display", "block");
                $("#headerDetailChart").html(" "+text+" PROVINSI "+data.provinsi);
                const dataDetail = {
                    "chart": {
                        "caption": "",
                        "xAxisName": "",
                        "yAxisName": "Total Toko",
                        "theme": "fusion",
                        "bgColor": "#ffffff",
                        "showBorder": "0",
                        "showCanvasBorder": "0",
                        "palettecolors": color,
                        "usePlotGradientColor": "0",
                        "valueFontColor": "#FF0000",
                        "labelDisplay": "rotate",
                        "slantLabels": "1",
                        "showToolTip": "0"
                    },
                    "data": data.data
                };

                FusionCharts.ready(function() {
                    var myChartDetail = new FusionCharts({
                        type: "column2d",
                        renderAt: "chart-detail",
                        width: "100%",
                        height: "420px",
                        dataFormat: "json",
                        dataSource: dataDetail,
                    }).render();
                });
            }
        })
    }
    // End Grafik Batang setelah klik pie cluster

    function trackRecordCluster(idProvinsi, type = null, tahun = null){
        $.ajax({
            url: "<?php echo base_url() ?>smi/ClusterRetail/trackRecordCluster",
            type: "POST",
            dataType: "JSON",
            data: {
                "id_provinsi" : idProvinsi,
                "cluster" : type,
                "tahun" : tahun
            },
            success: function(data){
                FusionCharts.ready(function(){
                    var fusioncharts = new FusionCharts({
                        type: 'line',
                        renderAt: 'chart-track-record',
                        width: '100%',
                        height: '400',
                        dataFormat: 'json',
                        dataSource: {
                            "chart": {
                                "theme": "fusion",
                                "caption": "TRACK RECORD TOKO "+type,
                                "xAxisName": "Bulan",
                                "yAxisName": "Jumlah Toko",
                                "lineThickness": "2",
                                "bgColor": "#ffffff",
                                "showBorder": "0",
                                "drawcrossline": "1",
                                "showCanvasBorder": "0",
                                "palettecolors": "#D45704",
                                "formatNumber": "0",
                                "formatNumberScale": "0",
                                "showToolTip" : "0"
                            },
                            "data": data.data
                        },
                        events: {
                        	dataplotClick: function (eventObj, dataObj){
                        		tableTrackRecord(idProvinsi, dataObj.index, type, tahun);
                        	}
                        }
                    });
                    fusioncharts.render();
                });     
            }
        });
    }

    function trendByDistrik(idProvinsi, cluster, nmDistrik, tahun){
        $("#detailTrackRecordDistrik").modal("show");
        $("#headerTrackPerdistrik").html("TRACK RECORD TOKO "+cluster+" KOTA "+nmDistrik);
        $.ajax({
            url: "<?php echo base_url('smi/ClusterRetail/trackRecordCluster'); ?>",
            type: "POST",
            dataType: "JSON",
            data:{
                "id_provinsi" : idProvinsi,
                "distrik" : nmDistrik,
                "cluster" : cluster,
                "tahun" : tahun
            },
            success: function(data){
                FusionCharts.ready(function(){
                    var fusioncharts = new FusionCharts({
                        type: 'line',
                        // type: 'spline'
                        renderAt: 'chartTrackRecordDistrik',
                        width: '100%',
                        height: '400',
                        dataFormat: 'json',
                        dataSource: {
                            "chart": {
                                "theme": "fusion",
                                "caption": "",
                                "subCaption": "",
                                "xAxisName": "Bulan",
                                "yAxisName": "Jumlah Toko",
                                "lineThickness": "2",
                                "bgColor": "#ffffff",
                                "showBorder": "0",
                                "drawcrossline": "1",
                                "showCanvasBorder": "0",
                                "palettecolors": "#D45704",
                                "formatNumber": "0",
                                "formatNumberScale": "0",
                                "divLineDashed": "1",
                                "divLineDashLen": "1",
                                "xAxisLineThickness": "1",
                                "showToolTip" : "0"
                            },
                            "data": data.data
                        }
                    });
                    fusioncharts.render();
                });
            }
        })
    }

     // Tabel daftar toko aktif/non aktif
    function tableClusterProvinsi(idProvinsi, nmDistrik, cluster){
        var bulan = $("#filterBulan").val();
        $("#detailTokoRetailDistrik").modal("show");
        $('#tableDaftarTokoDistrik').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('smi/ClusterRetail/tabelTokoCluster'); ?>",
                type: "POST",
                data: {
                    "id_provinsi" : idProvinsi,
                    "nm_distrik" : nmDistrik,
                    "cluster" : cluster,
                    "bulan" : bulan
                }
            },
        });
    }
    // End Tabel daftar toko aktif/non aktif

    function tableTrackRecord(idProvinsi, bulan, type, nmDistrik = null, tahun = null){
        const monthNames = ["JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI",
        "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"];

        $("#btnExport").data("jenis", "cluster");
        $("#btnExport").data("cluster", type);
        $("#btnExport").data("bulan", bulan);
        $("#btnExport").data("provinsi", idProvinsi);
        $("#btnExport").data("distrik", nmDistrik);

    	$("#detailTokoRetailDistrik").modal("show");
        $("#headerTableRetail").html("DATA TOKO "+type+" BULAN "+monthNames[bulan-1]);
        $('#tableDaftarTokoDistrik').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('smi/ClusterRetail/tabelTrackRecord'); ?>",
                type: "POST",
                data: {
                    "bulan" : (bulan),
                    "id_provinsi" : idProvinsi,
                    "cluster" : type,
                    "nm_distrik" : nmDistrik,
                    "tahun" : tahun
                }
            },
        });
    }

    // Grafik pie awal sebelah kiri
    function retailActivationChart(idProvinsi = null, bulan, render){
    	if(render == undefined){
    		var rendered = "chart-container";
    	} else {
    		var rendered = "chart-container-sales";
    	}

        <?php if($this->session->userdata("id_jenis_user") == "1002"){ ?>
            var idProvinsi = 1025;
        <?php } ?>
        $.ajax({
            url: "<?php echo base_url() ?>smi/RetailActivation/chartRetailActivation",
            type: "POST",
            dataType: "JSON",
            data: {
                "provinsi": idProvinsi,
                // "distibutor": distibutor,
                "bulan": bulan
            },
            beforeSend: function(xhr){
                $("#chart-container").css("display", "none");
                $("#detailProgressAwal").css("display", "block")
            },
            success: function(data){
                $("#detailProgressAwal").css("display", "none");
                $("#chart-container").css("display", "block");
                $("#detailActivationProvinsiLabel").html("RETAIL ACTIVATION PROVINSI "+data.provinsi);
                $("#total").html(data.total);
                $("#prosen").html(data.prosen+"%");
                const dataSource = {
                    "chart": {
                        "caption": "Grafik Toko Aktif & Tidak Aktif",
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
                        "formatNumberScale": "0"
                    },
                    "data": data.data
                };
                
                FusionCharts.ready(function() {
                    var myChart = new FusionCharts({
                        type: "pie2d",
                        renderAt: rendered,
                        width: "100%",
                        height: "400px",
                        dataFormat: "json",
                        dataSource,
                        events :  {
                            dataplotClick: function (eventObj, dataObj){
                                var text = dataObj.toolText;
                                text = text.replace(/[0-9.,/ %]/g, '');
                                detailChart(data.id_provinsi, text);
                            }
                        }
                    }).render();
                });
            }            
        });
    }
    // End grafik pie awal sebelah kiri

    // Tabel daftar toko aktif/non aktif
    function detailRetailDistrik(nmDistrik, status, distrik){
        $("#btnExport").data("status", status);
        $("#btnExport").data("distrik", distrik);
        $("#btnExport").data("jenis", "aktif");
        $("#headerTableRetail").html("DAFTAR TOKO "+status+" DISTRIK "+distrik);
        $("#detailTokoRetailDistrik").modal("show");
        $('#tableDaftarTokoDistrik').dataTable({
            "destroy" : true,
            // "pageLength" : 8,
            "ajax" : {
                url: "<?php echo base_url('smi/RetailActivation/detailRetailDistrik'); ?>",
                type: "POST",
                data: {
                    "nm_distrik" : nmDistrik,
                    "status" : status
                }
            },
        });
    }
    // End Tabel daftar toko aktif/non aktif

    // Grafik batang setelah klik pie aktif/non aktif
    function detailChart(idProvinsi, status){
        var idJenisUser = "<?php echo $this->session->userdata('id_jenis_user') ?>";
        if(idJenisUser == "1005"){
            idProvinsi = "<?php echo $this->session->userdata('id_provinsi') ?>";
        }

        if(status == "AKTIF"){
            var colorChart = "#008ee4";
        } else {
            var colorChart = "#f8bd19";
        }
        
        $.ajax({
            url: "<?php echo base_url() ?>smi/RetailActivation/detailChartActivation/"+idProvinsi+"/"+status,
            type: "GET",
            dataType: "JSON",
            beforeSend(xhr){
                $("#chart-detail").css("display", "none");
                $("#detailProgress").css("display", "block");
                $("#cardTrackRecord").css("display", "none");
            },
            success: function(data){
                $("#detailProgress").css("display", "none");
                $("#chart-detail").css("display", "block");
                $("#headerDetailChart").html(status+" PROVINSI "+data.provinsi);
                const dataDetail = {
                    "chart": {
                        "caption": "",
                        "xAxisName": "",
                        "yAxisName": "Total Toko",
                        "theme": "fusion",
                        "bgColor": "#ffffff",
                        "showBorder": "0",
                        "showCanvasBorder": "0",
                        "palettecolors": colorChart,
                        "usePlotGradientColor": "0",
                        "valueFontColor": "#000000",
                        "labelDisplay": "rotate",
                        "slantLabels": "1",
                        "showToolTip": "0"
                    },
                    "data": data.data
                };

                FusionCharts.ready(function() {
                    var myChartDetail = new FusionCharts({
                        type: "column2d",
                        renderAt: "chart-detail",
                        width: "100%",
                        height: "420px",
                        dataFormat: "json",
                        dataSource: dataDetail,
                        events: {
                            dataplotClick: function (eventObj, dataObj){
                                // console.log(dataObj);
                            }
                        }
                    }).render();
                });
            }
        });

        $("#defaultModal").modal("show");
    }
    // End Grafik batang setelah klik pie aktif/non aktif
</script>
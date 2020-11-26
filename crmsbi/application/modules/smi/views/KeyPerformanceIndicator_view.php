<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header header-title">
                        <h2>Key Performance Indicators</h2>
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
                        <?php if($this->session->userdata("id_jenis_user") == "1001"){ ?>
                            <a href="<?php echo base_url('smi/KeyPerformanceIndicator/indexKpi'); ?>" class="btn btn-sm btn-danger">Index KPI KAM / AM</a>
                            <a href="<?php echo base_url('smi/KeyPerformanceIndicator/targetKpi'); ?>" class="btn btn-sm btn-warning">Target Volume, Harga & Revenue KPI</a>
                            <a href="<?php echo base_url('smi/KeyPerformanceIndicator/targetCustomer'); ?>" class="btn btn-sm btn-success">Target Keep, Get & Growth</a>
                            <p>&nbsp;</p>
                        <?php } else if( $this->session->userdata("id_jenis_user") == "1002" || $this->session->userdata("id_jenis_user") == "1007"){ ?>
                            <a href="<?php echo base_url('smi/KeyPerformanceIndicator/indexKpi'); ?>" class="btn btn-sm btn-info">Index KPI Sales</a>
                            <a href="<?php echo base_url('sales/AssignToko'); ?>" class="btn btn-sm btn-success">Assign Toko Sales</a>
                            <a href="<?php echo base_url('sales/TargetSales'); ?>" class="btn btn-sm btn-warning">Target KPI Sales</a>
                            <p>&nbsp;</p>
                        <?php } ?>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        Filter Bulan : 
                                        <select id="filterBulan" class="form-control show-tick" data-size="5">
                                            <option>Pilih Bulan</option>
                                            <?php for($i=1;$i<=12;$i++){ ?>
                                            <option value="<?php echo $i; ?>" <?php if(date('m') == $i){ echo "selected";} ?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        Filter Tahun : 
                                        <select id="filterTahun" class="form-control show-tick" data-size="5">
                                            <option>Pilih Tahun</option>
                                            <?php for($j=date('Y')-1;$j<=date('Y')+1;$j++){ ?>
                                            <option value="<?php echo $j; ?>" <?php if(date('Y') == $j){ echo "selected";} ?>><?php echo $j; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <br/>
                                        <button id="btnFilter" class="btn btn-info">View</button>
                                    </div>
                                    <div class="col-md-1">
                                        <br/>
                                        <button id="tombol_export_exel" class="btn btn-success"><span class="fa fa-file-excel-o"></span> Export </button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        
                                    <table id="kamSales" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>Nama</th>
                                                <th>Distributor</th>
                                                <th width="8%" style="white-space: nowrap;">Nilai KPI</th>
                                                <th width="22%" style="white-space: nowrap;">Detail</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    </div>
                                </div>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
                <!-- start modal tabel -->
                <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document" style="width: 80%;">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                                <h4 class="modal-title" id="largeModalLabel">Detail KPI</h4>
                            </div>
                            <div class="modal-body">
                            	<div class="table-responsive" style="width: 100%">
                            		<table id="detailKpi" class="table table-bordered table-striped" width="100%">
	                                    <thead>
	                                        <tr>
	                                            <th>No</th>
	                                            <th>Deskripsi</th>
	                                            <th>Index KPI</th>
	                                            <th>Target/Bulan</th>
	                                            <th>Target s/d Kemarin</th>
	                                            <th>Prosentase Target</th>
	                                            <th>Realisasi/Bulan</th>
	                                            <th>Realisasi</th>
	                                            <th>Nilai</th>
	                                        </tr>
	                                    </thead>
	                                    <tfoot>
	                                        <tr>
	                                            <th colspan="8" style="text-align:right">Total Nilai KPI</th>
	                                            <th></th>
	                                        </tr>
	                                    </tfoot>
	                                </table>
                            	</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal tabel -->
                <!-- start modal grafik -->
                <div class="modal fade" id="grafikModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document" style="width: 80%;">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #2b982b;color: white;">
                                <h4 class="modal-title" id="largeModalLabel">Detail Grafik KPI</h4>
                            </div>
                            <div class="modal-body">
                                <div style="width: 100%">
                                    <div class="row">
                                        <div id="loader">
                                            <div class="progress col-md-12">
                                                <div class="progress-bar bg-cyan progress-bar-striped active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: 100%">
                                                    PLEASE WAIT...
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                            <div class="col-md-3">
                                                <div style="background-color: #009688; color: #fff;">
                                                   <div class="topcard" style="background-color: #05b1a1; padding: 20px; ">
                                                       <p><strong>VOLUME (ZAK)</strong></p>
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
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="body">
                                                    <div id="chart-container"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal grafik -->
            </div>
        </div>
    </div>
</section>
<script>
    $("document").ready(function(){
        var bulan = $("#filterBulan").val();
        var tahun = $("#filterTahun").val();
        kamSales(bulan, tahun);
    });

    $(document).on("click", "#btnFilter", function(e){
        e.preventDefault();
        var bulan = $("#filterBulan").val();
        var tahun = $("#filterTahun").val();
        kamSales(bulan, tahun);
    });

    function kamSales(bulan = null, tahun = null){
        $("#kamSales").dataTable({
            "destroy": "true",
            "ajax": {
                url: "<?php echo base_url('smi/KeyPerformanceIndicator/listKamSales'); ?>/"+bulan+"/"+tahun,
                type: "GET"
            }
        });
    }

    function detailGrafikKpi(idUser, bulan, tahun){
        console.log(bulan+"-"+tahun);
        $("#grafikModal").modal("show");
        kunjunganHarian(idUser, bulan, tahun);
        
        $.ajax({
            url: "<?php echo base_url('smi/KeyPerformanceIndicator/detailKpi'); ?>/"+bulan+"/"+tahun,
            type: "POST",
            dataType: "JSON",
            data: {
                "id_user" : idUser
            },
            beforeSend:function(xhr){
                $("#loader").css("display", "block");
            },
            success:function(data){
                $("#loader").css("display", "none");
                if(data.recordsTotal > 1){
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
                } else {
                    $("#real_volume, #nilai_volume, #real_harga, #nilai_harga, #real_revenue, #nilai_revenue, #real_kunjungan, #nilai_kunjungan").html("");
                }
            },
            error: function(xhr){
                $("#loader").css("display", "none");
                $("#real_volume, #nilai_volume, #real_harga, #nilai_harga, #real_revenue, #nilai_revenue, #real_kunjungan, #nilai_kunjungan").html("");
            }
        });
    }

    function kunjunganHarian(idUser, bulan, tahun){
        $.ajax({
            url: "<?php echo base_url(); ?>administrator/home/kunjunganHarian/"+idUser+"/"+bulan+"/"+tahun,
            type: "GET",
            dataType: "JSON",
            beforeSend: function(xhr){
                $("#chart-container").html("");
            },
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
                            "trendlines" : data.trendlines
                        }
                    });
                    fusioncharts.render();
                });
            }
        });
    }

    function detailKpi(idUser, bulan, tahun){
        $("#largeModal").modal("show");
        $("#detailKpi").dataTable({
            destroy: true,
            searching: false,
            paging: false,
            ajax: {
                url: "<?php echo base_url('smi/KeyPerformanceIndicator/detailKpi'); ?>/"+bulan+"/"+tahun,
                type: "POST",
                data: {
                    "id_user" : idUser
                }
            },
            footerCallback: function(row, data, start, end, display){
                var api = this.api(), data;

                var intVal = function(i){
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof 1 === 'number' ?
                        i : 0;
                };

                total = api.column(8).data().reduce(function(a, b){
                    return intVal(a) + intVal(b);
                }, 0);

                pageTotal = api.column(8, {page : 'current'}).data().reduce(function(a, b){
                    return intVal(a) + intVal(b);
                }, 0);

                $(api.column(8).footer()).html(
                    Math.round(total)
                );
            }
        });
    }
	$(document).on('click', '#tombol_export_exel', function(){
        Bulan           = $('#filterBulan').val();
        Tahun           = $('#filterTahun').val();
        link            =  '<?php echo base_url(); ?>smi/KeyPerformanceIndicator/Export_exel/'+ Bulan + '/'+ Tahun;
        location.href   = link;
    });
</script>
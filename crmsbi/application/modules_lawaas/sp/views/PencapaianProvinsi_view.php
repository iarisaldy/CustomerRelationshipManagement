<style>
    .ibox-title.title-desc,.panel-heading {
        background: linear-gradient(to left, #1ab394, #036C13);
    }

    .dataTables_scrollBody{
        direction :rtl;
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
    th,h2 {
        text-align: center;
    }
    .kanan {
        text-align: right;
    }
    .ibox{
        color: black;
    }
    .ibox1,.panel{
        width: 110%;
        margin-left: -5%;
    }
    .ibox2{
        width: 110%;
        margin-left: -10%;
    }
    .ibox3{
        width: 110%;
        /*margin-left: -5%;*/
    }
    .label{
        color: black;
    }
    .label-merah{
        background-color: #ff4545;
        color: white;
        /*font-size: 12px;*/
    }
    .label-kuning{
        background-color: #fef536;
        /*font-size: 12px;*/
    }
    .label-hijau{
        background-color: #49ff56;
        /*font-size: 12px;*/
    }
    .merah{
        background-color: #ff4545;
    }
    .kuning{
        background-color: #fef536;
    }
    .hijau{
        background-color: #49ff56;
    }
    .kotak{
        float:left;
        width:2vw;
        height:1vw;
        border-radius: 3px;
        /*display: inline;*/
    }

</style>
<link href="<?php echo base_url(); ?>assets/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/fixedHeader.dataTables.min.css" rel="stylesheet">
<div id="loading_purple"></div>
<div class="row">    
    <div class="col-lg-12">        
        <div class="ibox ibox1 float-e-margins">            
            <div class="ibox-title title-desc">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-line-chart"></i> PENCAPAIAN PER PROVINSI</span></h4>            
            </div>
            <div class="ibox-content">     
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-7" style="">
                            <div class="col-md-2"><center><img src="<?= base_url() . 'assets/img/menu/semen_padang.png' ?>" style="width:90px;"></center></div>
                            <div class="col-md-10"><h2 style="text-align:left;line-height: 315%;"><b>SEMEN PADANG</b></h2></div>
                        </div>
                        <div class="col-md-2">
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
                                for ($i = 2014; $i <= date("Y"); $i++) {
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
                <br/>                                
                <div class="table-responsive">                        
                    <table id="table_pencapaian" class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th class='success' width='5%'>NO</th>
                                <th class='success' width='15%'>PROVINSI</th>
                                <th class='danger' width='10%'>TARGET BULAN INI</th>
                                <th class='danger' width='10%'>TARGET SALES SDK</th>
                                <th class='danger' width='10%'>REAL SALES SDK</th>
                                <th class='danger' width='10%'>BULAN INI(%)</th>
                                <th class='danger' width='10%'>PERSENTASE SDK</th>
<!--                                <th class='warning' width='10%'>TARGET REVENUE SDK</th>
                                <th class='warning' width='10%'>REAL REVENUE SDK</th>
                                <th class='info' width='10%'>TARGET MARKETSHARE</th>
                                <th class='info' width='10%'>MARKETSHARE HARIAN</th>
                                <th class='success' width='20%'>KABIRO PENJUALAN</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- data di load disini -->
                        </tbody>
                    </table>                    
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <div class="kotak merah"></div> &nbsp;&nbsp;: Real < 90%
                        </div>
                        <div class="col-md-2">
                            <div class="kotak kuning"></div> &nbsp;&nbsp;: Real 90 - 100%
                        </div>
                        <div class="col-md-2">
                            <div class="kotak hijau"></div> &nbsp;&nbsp;: Real &ge; 100%
                        </div>               
                    </div>
                </div>
                <div class="pull-right">

                </div>
                <div id="page-info">
                    <ul class="list-group clear-list">

                    </ul>
                </div>
            </div>            
        </div>        
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="ibox ibox2 float-e-margins">            
            <div class="ibox-title title-desc">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-line-chart"></i> PENCAPAIAN BAG PER PROVINSI</span></h4>            
            </div>
            <div class="ibox-content">                             
                <div class="">                        
                    <table id="table_pencapaian_bag" class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th class='success' width='5%'>NO</th>
                                <th class='success' width='20%'>PROV</th>
                                <th class='success' width='20%'>TARGET BULAN INI</th>
                                <th class='success' width='20%'>TARGET S/D KEMARIN</th>
                                <th class='success' width='20%'>REAL S/D KEMARIN</th>
                                <th class='success' width='20%'>% TARGET BULAN INI</th>
                                <th class='success' width='20%'>% TARGET S/D KEMARIN</th>
                                <!--<th class='success' width='20%'>KABIRO PENJUALAN</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- data di load disini -->
                        </tbody>
                    </table>                    
                </div>
                <div class="pull-right">

                </div>
                <div id="page-info">
                    <ul class="list-group clear-list">

                    </ul>
                </div>
            </div>            
        </div> 
    </div>
    <div class="col-md-6">
        <div class="ibox ibox3 float-e-margins">            
            <div class="ibox-title title-desc">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-line-chart"></i> PENCAPAIAN BULK PER PROVINSI</span></h4>            
            </div>
            <div class="ibox-content">                                 
                <div class="">                        
                    <table id="table_pencapaian_bulk" class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th class='success' width='5%'>NO</th>
                                <th class='success' width='20%'>PROV</th>
                                <th class='success' width='20%'>TARGET BULAN INI</th>
                                <th class='success' width='20%'>TARGET S/D HARI INI</th>
                                <th class='success' width='20%'>REAL</th>
                                <th class='success' width='20%'>% TARGET BULAN INI</th>
                                <th class='success' width='20%'>% TARGET s/d HARI INI</th>
                                <!--<th class='success' width='20%'>KABIRO PENJUALAN</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- data di load disini -->
                        </tbody>
                    </table>                    
                </div>
                <div class="pull-right">

                </div>
                <div id="page-info">
                    <ul class="list-group clear-list">

                    </ul>
                </div>
            </div>            
        </div> 
    </div>
</div>
<!--<div class="row">    
    <div class="col-lg-12">        
        <div class="panel">            
            <div class="panel-heading">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-bar-chart-o"></i> PENCAPAIAN MASING-MASING BIRO PENJUALAN</span></h4>            
            </div>
            <div class="panel-body">   
                <div class="row">
                    <div class="col-md-12">
                        <canvas height="70%" id="chart"></canvas>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-11">
                        <table width="100%">
                            <tr><td colspan="7">Target harian untuk mencapai RKAP :</td></tr>
                            <tr class="target_harian">

                            </tr>
                            <tr><td colspan="7">Keterangan :</td></tr>
                            <tr>
                                <td width="2%">Wil 1 : </td>
                                <td width="16%">&nbsp;Sumbar, Riau, Jambi, Sumsel, Babel, Bengkulu, Lampung</td>
                                <td width="2%">Wil 2 : </td> 
                                <td width="8%">&nbsp;Aceh, Sumut, Kepri</td>
                                <td width="2%">Wil 3 : </td>
                                <td width="8%">&nbsp;DKI, Jabar, Banten, Jateng</td>
                                <td width="2%">&nbsp;</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>            
        </div>        
    </div>
</div>-->

<!--<div class="row">    
    <div class="col-lg-12">        
        <div class="panel">            
            <div class="panel-heading">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-bar-chart-o"></i> PENCAPAIAN REVENUE MASING-MASING BIRO PENJUALAN</span></h4>            
            </div>
            <div class="panel-body">   
                <div class="row">
                    <div class="col-md-12">
                        <canvas height="70%" id="chartRevenue"></canvas>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-11">
                        <table width="100%">
                            <tr><td colspan="7">Target harian untuk mencapai RKAP :</td></tr>
                            <tr class="target_harian_revenue">

                            </tr>
                            <tr><td colspan="7">Keterangan :</td></tr>
                            <tr>
                                <td width="2%">Wil 1 : </td>
                                <td width="16%">&nbsp;Sumbar, Riau, Jambi, Sumsel, Babel, Bengkulu, Lampung</td>
                                <td width="2%">Wil 2 : </td> 
                                <td width="8%">&nbsp;Aceh, Sumut, Kepri</td>
                                <td width="2%">Wil 3 : </td>
                                <td width="8%">&nbsp;DKI, Jabar, Banten, Jateng</td>
                                <td width="2%">&nbsp;</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>            
        </div>        
    </div>
</div>-->
<script src="<?php echo base_url(); ?>assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.bundle.js"></script>
<script>
    function formatAngka(n) {
        var num = parseInt(n);
        return (num + '').replace(/(\d)(?=(\d{3})+$)/g, '$1.');
    }
    function getLastDate(Year, Month) {
        var date = new Date((new Date(Year, Month, 1)) - 1);
        var lastDay = date.getUTCDate();
        return lastDay;
    }

    function isRealValue(obj) {
        return obj && obj !== "null" && obj !== "undefined";
    }

    function create_table(obj_data) {
        $("#table_pencapaian").dataTable().fnDestroy();
        var table_string = "<thead><tr>" +
                "<th class='success' width='5%'>NO</th>" +
                "<th class='success' width='15%'>PROVINSI</th>" +
                "<th class='danger' width='10%'>TARGET BULAN INI</th>" +
                "<th class='danger' width='10%'>TARGET SALES SDK</th>" +
                "<th class='danger' width='10%'>REAL SALES SDK</th>" +
                "<th class='danger' width='10%'>BULAN INI(%)</th>" +
                "<th class='danger' width='10%'>PERSENTASE SDK</th>" +
//                "<th class='warning' width='10%'>TARGET REVENUE SDK (Miliar)</th>" +
//                "<th class='warning' width='10%'>REAL REVENUE SDK (Miliar)</th>" +
//                "<th class='info' width='10%'>TARGET MARKETSHARE</th>" +
//                "<th class='info' width='10%'>MARKETSHARE HARIAN</th>" +
//                "<th class='success' width='15%'>KABIRO PENJUALAN</th>" +
                "</tr></thead><tbody>";
        var count = 0;
        if (typeof obj_data['ms']['DEMAND_NASIONAL'] == 'undefined' || obj_data['ms']['DEMAND_NASIONAL'] == null) {
            var demand = 0;
        } else {
            var demand = Math.round(obj_data['ms']['DEMAND_NASIONAL'].toString().replace(',', '.'));
        }
        var totalReal = obj_data.total.REAL;
        var totalTarget = obj_data.total.TARGET;
        var totalTargetRealH = obj_data.total.TARGET_REALH;
        var totalTargetRevenue = 0;
        var totalRealRevenue = 0;
        // var rkapms = obj_data['rkapms']['TARGET'].toString().replace('.', ',');
        var rkapms = (obj_data.hasOwnProperty('rkapms') && obj_data['rkapms'] != null) ? obj_data['rkapms']['TARGET'].toString().replace('.', ',') : '';
        if (isRealValue(obj_data)) {
            $.each(obj_data.sales, function (key, val) {
                count++;
                if (val.PERSENHARI < 95) {
                    var warnaH = "class='label label-merah'";
                } else if (val.PERSENHARI >= 95 && val.PERSENHARI < 100) {
                    var warnaH = "class='label label-kuning'";
                } else {
                    var warnaH = "class='label label-hijau'";
                }
                //pewarnaan real revenue
                if (parseFloat(val.REAL_REVENUE) < parseFloat(val.TARGET_REVENUE)) {
                    var warnaRealrev = "class='label label-merah'";
                } else if (parseFloat(val.REAL_REVENUE) == parseFloat(val.TARGET_REVENUE)) {
                    var warnaRealrev = "class='label label-kuning'";
                } else {
                    var warnaRealrev = "class='label label-hijau'";
                }
                //pewarnaan ms harian
                if (val.RKAP_MS.toString().replace(',', '.') - val.MARKETSHARE.toString().replace(',', '.') >= 2) {
                    var warnamsHarian = "class='label label-merah'";
                } else if (val.RKAP_MS.toString().replace(',', '.') - val.MARKETSHARE.toString().replace(',', '.') < 2 && val.RKAP_MS.toString().replace(',', '.') - val.MARKETSHARE.toString().replace(',', '.') >= 0) {
                    var warnamsHarian = "class='label label-kuning'";
                } else if (val.RKAP_MS.toString().replace(',', '.') - val.MARKETSHARE.toString().replace(',', '.') < 0) {
                    var warnamsHarian = "class='label label-hijau'";
                }
                var target = Math.round(val.TARGET.toString().replace(',', '.'));
                var targetRealH = Math.round(val.TARGET_REALH.toString().replace(',', '.'));
                var real = Math.round(val.REAL.toString().replace(',', '.'));
                totalTargetRevenue += parseFloat(val.TARGET_REVENUE);
                totalRealRevenue += parseFloat(val.REAL_REVENUE);
                table_string += "<tr>" +
                        "<td>" + count + "</td>" +
                        "<td>" + val.NM_PROV + "</td>" +
                        "<td class='kanan'>" + formatAngka(target) + "</td>" +
                        "<td class='kanan'>" + formatAngka(targetRealH) + "</td>" +
                        "<td class='kanan'>" + formatAngka(real) + "</td>" +
                        "<td class='kanan'>% " + val.PERSENBULAN + "</td>" +
                        "<td class='kanan'><span " + warnaH + ">% " + val.PERSENHARI + "</span></td>" +
//                        "<td class='kanan'>" + formatAngka(Math.round(val.TARGET_REVENUE / 1000000)) + "</td>" +
//                        "<td class='kanan'><span " + warnaRealrev + ">" + formatAngka(Math.round(val.REAL_REVENUE / 1000000)) + "</span></td>" +
//                        "<td class='kanan'>" + val.RKAP_MS + " %</td>" +
//                        "<td class='kanan'><span " + warnamsHarian + ">" + val.MARKETSHARE + " %</span></td>" +
//                        "<td>" + val.KABIRO + "</td>" +
                        "</tr>";
            });
        }
        table_string += "</tbody>";
        var persenTotalH = Math.round((totalReal / totalTargetRealH) * 100);
        if (persenTotalH < 95) {
            var warna = "class='label label-merah'";
        } else if (persenTotalH >= 95 && persenTotalH < 100) {
            var warna = "class='label label-kuning'";
        } else {
            var warna = "class='label label-hijau'";
        }
        //pewarnaan total real revenue
        if (totalRealRevenue < totalTargetRevenue) {
            var warnaRealrev = "class='label label-merah'";
        } else if (totalRealRevenue == totalTargetRevenue) {
            var warnaRealrev = "class='label label-kuning'";
        } else {
            var warnaRealrev = "class='label label-hijau'";
        }
        var mstotal = Math.round(((totalReal / demand) * 100) * 10) / 10;
        //pewarnaan total ms harian
        var selisih = Math.round(rkapms.toString().replace(',', '.') - mstotal);
        if (selisih >= 2) {
            var warnamsHarian = "class='label label-merah'";
        } else if (selisih < 2 && selisih >= 0) {
            var warnamsHarian = "class='label label-kuning'";
        } else if (selisih < 2) {
            var warnamsHarian = "class='label label-hijau'";
        }
        table_string += "<tfoot><tr>" +
                "<td colspan='2' class='success' align='center'><b>TOTAL</b></td>" +
                "<td class='kanan success'><b>" + formatAngka(totalTarget) + "</b></td>" +
                "<td class='kanan success'><b>" + formatAngka(totalTargetRealH) + "</b></td>" +
                "<td class='kanan success'><b>" + formatAngka(totalReal) + "</b></td>" +
                "<td class='kanan success'><b>" + Math.round((totalReal / totalTarget) * 100) + " %</b></td>" +
                "<td class='kanan success'><span " + warna + "><b>" + persenTotalH + " %</b></span></td>" +
//                "<td class='success kanan'><b>" + formatAngka(Math.round(totalTargetRevenue / 1000000)) + "</b></td>" + //
//                "<td class='success kanan'><span " + warnaRealrev + "><b>" + formatAngka(Math.round(totalRealRevenue / 1000000)) + "</b></span></td>" + //
//                "<td class='kanan success'><b>" + rkapms + " %</b></td>" +
//                "<td class='kanan success'><span " + warnamsHarian + "><b>" + mstotal.toString().replace('.', ',') + " %</b></span></td>" +
//                "<td class='success'>&nbsp;</td>" +
                "</tr></tfoot>";
        $("#table_pencapaian").html(table_string);

        // Init Datatables with Tabletools Addon	
        $('#table_pencapaian').DataTable({
            "bDestroy": true,
            "paging": false,
            "searching": false,
            "fixedHeader": true,
            "language": {
                "decimal": ",",
                "thousands": "."
            }
        });
    }
    function create_table_bag(obj_data) {
        $("#table_pencapaian_bag").dataTable().fnDestroy();
        var table_string = "<thead><tr>" +
//                "<th class='success'>KABIRO PENJUALAN</th>" +
//                "<th class='success'>% TARGET S/D KEMARIN</th>" +
//                "<th class='success'>% TARGET BULAN INI</th>" +
//                "<th class='success'>REAL S/D KEMARIN</th>" +
//                "<th class='success'>TARGET S/D KEMARIN</th>" +
//                "<th class='success'>TARGET BULAN INI</th>" +
//                "<th class='success'>PROV</th>" +
//                "<th class='success'>NO</th>" +
                "<th class='success'>NO</th>" +
                "<th class='success'>PROV</th>" +
                "<th class='success'>TARGET BULAN INI</th>" +
                "<th class='success'>TARGET S/D KEMARIN</th>" +
                "<th class='success'>REAL S/D KEMARIN</th>" +
                "<th class='success'>% TARGET BULAN INI</th>" +
                "<th class='success'>% TARGET S/D KEMARIN</th>" +
                "</tr></thead><tbody>";
        var count = 0;
        var totalTarget = 0;
        var totalTargetRealH = 0;
        var totalReal = 0;
        if (isRealValue(obj_data)) {
            $.each(obj_data, function (key, val) {
                count++;
                if (val.PERSENHARI < 95) {
                    var warnaH = "class='label label-merah'";
                } else if (val.PERSENHARI >= 95 && val.PERSENHARI < 100) {
                    var warnaH = "class='label label-kuning'";
                } else {
                    var warnaH = "class='label label-hijau'";
                }
                var target = Math.round(val.TARGET.toString().replace(',', '.'));
                var targetRealH = Math.round(val.TARGET_REALH.toString().replace(',', '.'));
                var real = Math.round(val.REAL.toString().replace(',', '.'));
                totalTarget += target;
                totalTargetRealH += targetRealH;
                totalReal += real;
                table_string += "<tr>" +
//                        "<td>" + val.KABIRO + "</td>" +

                        "<td>" + count + "</td>" +
                        "<td>" + val.NM_PROV_1 + "</td>" +
                        "<td align='right'>" + formatAngka(target) + "</td>" +
                        "<td align='right'>" + formatAngka(targetRealH) + "</td>" +
                        "<td align='right'>" + formatAngka(real) + "</td>" +
                        "<td align='right'>" + val.PERSENBULAN + " %</td>" +
                        "<td align='right'><span " + warnaH + ">" + val.PERSENHARI + " %</span></td>" +
                        "</tr>";
            });
        }
        table_string += "</tbody>";
        var persenTotalH = Math.round((totalReal / totalTargetRealH) * 100);
        if (persenTotalH < 95) {
            var warna = "class='label label-merah'";
        } else if (persenTotalH >= 95 && persenTotalH < 100) {
            var warna = "class='label label-kuning'";
        } else {
            var warna = "class='label label-hijau'";
        }
        table_string += "<tfoot><tr>" +
                "<td class='success' colspan='2' align='center'><b>TOTAL</b></td>" +
                "<td class='success' align='right'><b>" + formatAngka(totalTarget) + "</b></td>" +
                "<td class='success' align='right'><b>" + formatAngka(totalTargetRealH) + "</b></td>" +
                "<td class='success' align='right'><b>" + formatAngka(totalReal) + "</b></td>" +
                "<td class='success' align='right'><b>" + Math.round((totalReal / totalTarget) * 100) + " %</b></td>" +
                "<td class='success' align='right'><span " + warna + "><b>" + persenTotalH + " %</b></span></td>" +
//                "<td class='success'>&nbsp;</td>" +
                "</tr></tfoot>";
        $("#table_pencapaian_bag").html(table_string);

        // Init Datatables with Tabletools Addon	
        $('#table_pencapaian_bag').DataTable({
            "bDestroy": true,
            "ordering": true,
            "paging": false,
            "searching": false,
            //"scrollX": true,
            "fixedHeader": true,
            "language": {
                "decimal": ",",
                "thousands": "."
            }
        });
    }
    function create_table_bulk(obj_data) {
        $("#table_pencapaian_bulk").dataTable().fnDestroy();
        var table_string = "<thead><tr>" +
//                "<th class='success'>KABIRO PENJUALAN</th>" +
                "<th class='success'>NO</th>" +
                "<th class='success'>PROV</th>" +
                "<th class='success'>TARGET BULAN INI</th>" +
                "<th class='success'>TARGET S/D KEMARIN</th>" +
                "<th class='success'>REAL S/D KEMARIN</th>" +
                "<th class='success'>% TARGET BULAN INI</th>" +
                "<th class='success'>% TARGET S/D KEMARIN</th>" +
                "</tr></thead><tbody>";
        var count = 0;
        var totalTarget = 0;
        var totalTargetRealH = 0;
        var totalReal = 0;
        if (isRealValue(obj_data)) {
            $.each(obj_data, function (key, val) {
                count++;
                if (val.PERSENHARI < 95) {
                    var warnaH = "class='label label-merah'";
                } else if (val.PERSENHARI >= 95 && val.PERSENHARI < 100) {
                    var warnaH = "class='label label-kuning'";
                } else {
                    var warnaH = "class='label label-hijau'";
                }
                var target = Math.round(val.TARGET.toString().replace(',', '.'));
                var targetRealH = Math.round(val.TARGET_REALH.toString().replace(',', '.'));
                var real = Math.round(val.REAL.toString().replace(',', '.'));
                totalTarget += target;
                totalTargetRealH += targetRealH;
                totalReal += real;
                table_string += "<tr>" +
//                        "<td align='left'>" + val.KABIRO + "</td>" +
                        "<td>" + count + "</td>" +
                        "<td align='left'>" + val.NM_PROV_1 + "</td>" +
                        "<td align='right'>" + formatAngka(target) + "</td>" +
                        "<td align='right'>" + formatAngka(targetRealH) + "</td>" +
                        "<td align='right'>" + formatAngka(real) + "</td>" +
                        "<td align='right'>" + val.PERSENBULAN + " %</td>" +
                        "<td align='right'><span " + warnaH + ">" + val.PERSENHARI + " %</span></td>" +
                        "</tr>";
            });
        }
        table_string += "</tbody>";
        var persenTotalH = Math.round((totalReal / totalTargetRealH) * 100);
        if (persenTotalH < 95) {
            var warna = "class='label label-merah'";
        } else if (persenTotalH >= 95 && persenTotalH < 100) {
            var warna = "class='label label-kuning'";
        } else {
            var warna = "class='label label-hijau'";
        }
        table_string += "<tfoot><tr>" +
                "<td class='success' colspan='2' align='center'><b>TOTAL</b></td>" +
                "<td class='success' align='right'><b>" + formatAngka(totalTarget) + "</b></td>" +
                "<td class='success' align='right'><b>" + formatAngka(totalTargetRealH) + "</b></td>" +
                "<td class='success' align='right'><b>" + formatAngka(totalReal) + "</b></td>" +
                "<td class='success' align='right'><b>" + Math.round((totalReal / totalTarget) * 100) + " %</b></td>" +
                "<td class='success' align='right'><span " + warna + "><b>" + persenTotalH + " %</b></span></td>" +
//                "<td class='success'>&nbsp;</td>" +
                "</tr></tfoot>";
        $("#table_pencapaian_bulk").html(table_string);

        // Init Datatables with Tabletools Addon	
        $('#table_pencapaian_bulk').DataTable({
            "bDestroy": true,
            "ordering": true,
            "paging": false,
            "searching": false,
            "fixedHeader": true,
            //"scrollX": true,
            "language": {
                "decimal": ",",
                "thousands": "."
            }
        });
    }
    function get_pencapaian(tahun, bulan, hari) {
        var url = base_url + 'sp/PencapaianProvinsi/scodata/' + tahun + '/' + bulan + '/' + hari;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $('#loading_purple').hide();
                create_table(data);
            }
        });
    }
    function get_pencapaian_bag(tahun, bulan, hari) {
        var url = base_url + 'sp/PencapaianProvinsi/scodataBag/' + tahun + '/' + bulan + '/' + hari;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $('#loading_purple').hide();
                create_table_bag(data);
            }
        });
    }
    function get_pencapaian_bulk(tahun, bulan, hari) {
        var url = base_url + 'sp/PencapaianProvinsi/scodataBulk/' + tahun + '/' + bulan + '/' + hari;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $('#loading_purple').hide();
                create_table_bulk(data);
            }
        });
    }
    function chart(tahun, bulan, hari) {
        var ctx1 = document.getElementById('chart').getContext("2d");
        var url = base_url + 'sp/PencapaianProvinsi/getDataChart/' + tahun + '/' + bulan + '/' + hari;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function (datas) {
                //chart bar 1
                var barChartData1 = {
                    labels: datas['labels'],
                    datasets: [{
                            label: 'REALISASI S/D KEMARIN',
                            backgroundColor: "#5eff2c",
                            data: datas['dataset']
                        }, {
                            label: 'TARGET S/D KEMARIN',
                            backgroundColor: "#ff4545",
                            data: datas['targetsd']
                        }, {
                            label: 'TARGET 1 BULAN',
                            backgroundColor: "#0095c2",
                            data: datas['target']
                        }]
                };
                /* cari selisih antara target dan tonase_real */
                var tonase_target = datas['tonase_target'];
                var tonase_real = datas['tonase_real'];
                var jml_hari = datas['jml_hari'];
                var selisih_hari = jml_hari - (hari - 1);
                var target_harian = [];
                for (var i in tonase_target) {
                    if (selisih_hari > 0) {
                        var _selisih_target = tonase_target[i] - tonase_real[i];
                        if (_selisih_target > 0) {
                            target_harian.push(_selisih_target / selisih_hari);
                        } else {
                            target_harian.push(0);
                        }
                    } else {
                        target_harian.push(0);
                    }
                }
                var _td = [];
                for (var i in datas['labels']) {
                    _td.push('<td>' + datas['labels'][i] + ' :</td>');
                    _td.push('<td><span class="badge badge-primary">' + formatAngka(target_harian[i]) + '</span></td>');
                }
                $('tr.target_harian').html(_td.join(''));
                var options1 = {
                    title: {
                        display: true,
                        text: "Grafik Target Dan Realisasi"
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: '%'
                                },
                                ticks: {
                                    max: 110,
                                    suggestedMin: 0,
                                    callback: function (value, index, values) {
                                        return formatAngka(value);
                                    }
                                }
                            }],
                        yAxes: [{
                                display: true,
                                stacked: true
                            }]
                    },
                    tooltips: {
                        mode: 'single',
                        callbacks: {
                            title: function (tooltipItem, data) {
                                //var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                var label = tooltipItem[0].yLabel;
                                var wilayah;
                                if (label == 'Wil 1') {
                                    wilayah = 'Sumbar, Riau, Jambi, Sumsel, Babel, Bengkulu, Lampung';
                                } else if (label == 'Wil 2') {
                                    wilayah = 'Aceh, Sumut, Kepri';
                                } else if (label == 'Wil 3') {
                                    wilayah = 'DKI, Jabar, Banten, Jateng';
                                }
                                //console.log(tooltipItem[0].yLabel);
                                return wilayah;
                            },
                            label: function (tooltipItem, data) {
                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                var tonase;
                                if (tooltipItem.datasetIndex === 0) {
                                    tonase = datas['tonase_real'];
                                } else if (tooltipItem.datasetIndex === 1) {
                                    tonase = datas['tonase_targetsd'];
                                } else if (tooltipItem.datasetIndex === 2) {
                                    tonase = datas['tonase_target'];
                                }
                                return datasetLabel + ' : ' + tooltipItem.xLabel + ' % (' + formatAngka(tonase[tooltipItem.index]) + ' Ton)';
                            }
                        }
                    },
                    animation: {
                        onComplete: function () {
                            var chartInstance = this.chart;
                            var ctx = chartInstance.ctx;
                            ctx.textAlign = "left";

                            Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                    //console.log(i);
                                    if (i === 2) {
                                        ctx.fillText(datas['kabiro'][index], bar._model.x + 5, bar._model.y - 5);
                                    }

                                }), this);
                            }), this);
                        }
                    }
                };
                chartBar1 = new Chart(ctx1, {
                    type: 'horizontalBar',
                    data: barChartData1,
                    options: options1
                });
            }
        });
    }
    function chartRevenue(tahun, bulan, hari) {
        var ctx2 = document.getElementById('chartRevenue').getContext("2d");
        var url = base_url + 'sp/PencapaianProvinsi/revenueKabiro/' + tahun + '/' + bulan + '/' + hari;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function (datas) {
                //chart bar 1
                var barChartData2 = {
                    labels: datas['labels'],
                    datasets: [{
                            label: 'REALISASI S/D KEMARIN',
                            backgroundColor: "#5eff2c",
                            data: datas['dataset']
                        }, {
                            label: 'TARGET S/D KEMARIN',
                            backgroundColor: "#ff4545",
                            data: datas['targetsd']
                        }, {
                            label: 'TARGET 1 BULAN',
                            backgroundColor: "#0095c2",
                            data: datas['target']
                        }]
                };
                /* cari selisih antara target dan tonase_real */
                var tonase_target = datas['tonase_target'];
                var tonase_real = datas['tonase_real'];
                var jml_hari = datas['jml_hari'];
                var selisih_hari = jml_hari - (hari - 1);
                var target_harian = [];
                for (var i in tonase_target) {
                    if (selisih_hari > 0) {
                        var _selisih_target = tonase_target[i] - tonase_real[i];
                        if (_selisih_target > 0) {
                            target_harian.push(_selisih_target / selisih_hari);
                        } else {
                            target_harian.push(0);
                        }
                    } else {
                        target_harian.push(0);
                    }
                }
                var _td = [];
                for (var i in datas['labels']) {
                    _td.push('<td>' + datas['labels'][i] + ' :</td>');
                    _td.push('<td><span class="badge badge-primary">Rp. ' + formatAngka(target_harian[i]) + '</span></td>');
                }
                $('tr.target_harian').html(_td.join(''));
                var options2 = {
                    title: {
                        display: true,
                        text: "Grafik Target Dan Realisasi"
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: '%'
                                },
                                ticks: {
                                    max: 110,
                                    suggestedMin: 0,
                                    callback: function (value, index, values) {
                                        return formatAngka(value);
                                    }
                                }
                            }],
                        yAxes: [{
                                display: true,
                                stacked: true
                            }]
                    },
                    tooltips: {
                        mode: 'single',
                        callbacks: {
                            title: function (tooltipItem, data) {
                                //var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                var label = tooltipItem[0].yLabel;
                                var wilayah;
                                if (label == 'Wil 1') {
                                    wilayah = 'Sumbar, Riau, Jambi, Sumsel, Babel, Bengkulu, Lampung';
                                } else if (label == 'Wil 2') {
                                    wilayah = 'Aceh, Sumut, Kepri';
                                } else if (label == 'Wil 3') {
                                    wilayah = 'DKI, Jabar, Banten, Jateng';
                                }
                                //console.log(tooltipItem[0].yLabel);
                                return wilayah;
                            },
                            label: function (tooltipItem, data) {
                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                var tonase;
                                if (tooltipItem.datasetIndex === 0) {
                                    tonase = datas['tonase_real'];
                                } else if (tooltipItem.datasetIndex === 1) {
                                    tonase = datas['tonase_targetsd'];
                                } else if (tooltipItem.datasetIndex === 2) {
                                    tonase = datas['tonase_target'];
                                }
                                return datasetLabel + ' : ' + tooltipItem.xLabel + ' % (Rp. ' + formatAngka(tonase[tooltipItem.index]) + ')';
                            }
                        }
                    },
                    animation: {
                        onComplete: function () {
                            var chartInstance = this.chart;
                            var ctx = chartInstance.ctx;
                            ctx.textAlign = "left";

                            Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                    //console.log(i);
                                    if (i === 2) {
                                        ctx.fillText(datas['kabiro'][index], bar._model.x + 5, bar._model.y - 5);
                                    }

                                }), this);
                            }), this);
                        }
                    }
                };
                chartBar2 = new Chart(ctx2, {
                    type: 'horizontalBar',
                    data: barChartData2,
                    options: options2
                });
            }
        });
    }

    function updateChart(tahun, bulan, hari) {
        var url = base_url + 'sp/PencapaianProvinsi/getDataChart/' + tahun + '/' + bulan + '/' + hari;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (datas) {
                chartBar1.data.labels = datas['labels'];
                chartBar1.data.datasets[0].data = datas['dataset'];
                chartBar1.data.datasets[1].data = [0, 0, 0];
                chartBar1.data.datasets[2].data = datas['target'];
                chartBar1.update();
                chartBar1.options.tooltips.callbacks();
                /* cari selisih antara target dan tonase_real */
                var tonase_target = datas['tonase_target'];
                var tonase_real = datas['tonase_real'];
                var jml_hari = datas['jml_hari'];
                var selisih_hari = jml_hari - (hari - 1);
                var target_harian = [];
                for (var i in tonase_target) {
                    if (selisih_hari > 0) {
                        var _selisih_target = tonase_target[i] - tonase_real[i];
                        if (_selisih_target > 0) {
                            target_harian.push(_selisih_target / selisih_hari);
                        } else {
                            target_harian.push(0);
                        }
                    } else {
                        target_harian.push(0);
                    }
                }
                var _td = [];
                for (var i in datas['labels']) {
                    _td.push('<td>' + datas['labels'][i] + ' :</td>');
                    _td.push('<td><span class="badge badge-primary">' + formatAngka(target_harian[i]) + '</span></td>');
                }
                $('tr.target_harian_revenue').html(_td.join(''));
                $('#loading_purple').hide();
            }
        });
    }

    function updateChartRevenue(tahun, bulan, hari) {
        var url = base_url + 'sp/PencapaianProvinsi/revenueKabiro/' + tahun + '/' + bulan + '/' + hari;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (datas) {
                chartBar2.data.labels = datas['labels'];
                chartBar2.data.datasets[0].data = datas['dataset'];
                chartBar2.data.datasets[1].data = [0, 0, 0];
                chartBar2.data.datasets[2].data = datas['target'];
                chartBar2.update();
                chartBar2.options.tooltips.callbacks();
                /* cari selisih antara target dan tonase_real */
                var tonase_target = datas['tonase_target'];
                var tonase_real = datas['tonase_real'];
                var jml_hari = datas['jml_hari'];
                var selisih_hari = jml_hari - (hari - 1);
                var target_harian = [];
                for (var i in tonase_target) {
                    if (selisih_hari > 0) {
                        var _selisih_target = tonase_target[i] - tonase_real[i];
                        if (_selisih_target > 0) {
                            target_harian.push(_selisih_target / selisih_hari);
                        } else {
                            target_harian.push(0);
                        }
                    } else {
                        target_harian.push(0);
                    }
                }
                var _td = [];
                for (var i in datas['labels']) {
                    _td.push('<td>' + datas['labels'][i] + ' :</td>');
                    _td.push('<td><span class="badge badge-primary">' + formatAngka(target_harian[i]) + '</span></td>');
                }
                $('tr.target_harian_revenue').html(_td.join(''));
                $('#loading_purple').hide();
            }
        });
    }

    $(function () {
        var d = new Date();
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
        var n = month[d.getUTCMonth()];
        $('#loading_purple').hide();
        $('#tahun').val(d.getUTCFullYear());
        $('#bulan').val(n);

        var tahun = $('#tahun').val();
        var bulan = $('#bulan').val();
        var hari = d.getUTCDate() + '';
        if (hari.length == 1) {
            hari = '0' + hari;
        }
        get_pencapaian(tahun, bulan, hari);
        get_pencapaian_bag(tahun, bulan, hari);
        get_pencapaian_bulk(tahun, bulan, hari);
//        chart(tahun, bulan, hari);
//        chartRevenue(tahun, bulan, hari);
        $('#filter').click(function () {
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            var hari = getLastDate(tahun, bulan);
            if (tahun == d.getUTCFullYear() && bulan == month[d.getUTCMonth()]) {
                hari = d.getUTCDate() + '';
            }
            if (hari.length == 1) {
                hari = '0' + hari;
            }
            get_pencapaian(tahun, bulan, hari);
            get_pencapaian_bag(tahun, bulan, hari);
            get_pencapaian_bulk(tahun, bulan, hari);
//            updateChart(tahun, bulan, hari);
//            updateChartRevenue(tahun, bulan, hari);
        });
        var tableOffset = $("#table_pencapaian").offset().top;
        var $header = $("#table_pencapaian > thead").clone();
        var $fixedHeader = $("#header-fixed").append($header);

        $(window).bind("scroll", function () {
            var offset = $(this).scrollTop();

            if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
                $fixedHeader.show();
            } else if (offset < tableOffset) {
                $fixedHeader.hide();
            }
        });
    });
</script>

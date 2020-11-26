<style>
    .ibox-title.title-desc,.panel-heading {
        background: linear-gradient(to left, #1ab394, #036C13);
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

    .btn-default {
        color: inherit;
        background: #cecccc;
        border: 1px solid #6c6c6c;
    }
    .container {
        padding-right: 0px; 
        padding-left: 0px; 
    }
    th,h2 {
        text-align: center;
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
        /*background-color: #ff4545;*/
        color: #ff4545;
        /*font-size: 12px;*/
    }
    .label-kuning{
        /*background-color: #fef536;*/
        color: #fef536;
        /*font-size: 12px;*/
    }
    .label-hijau{
        /*background-color: #49ff56;*/
        color: #49ff56;
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
    .btn-default.disabled{
        color: #030303;
    }
    td{
        white-space:nowrap;
    }
    #title-region{
        font-weight:bold;
        text-align: center;
        padding-top:15px;
        font-size:16px;
        border-top:solid 1px #e7eaec;
    }
    .target_harian_revenue td{
        font-size:9px;
    }

    .bold {
        font-weight: 700;
    }

    @media (min-width: 1200px){
        .container {
            width: 1200px;
        }
    }
</style>
<link href="<?php echo base_url(); ?>assets/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/fixedHeader.dataTables.min.css" rel="stylesheet">
<div id="loading_purple"></div>
<div class="row">    
    <div class="col-lg-12">        
        <div class="ibox ibox1 float-e-margins">            
            <div class="ibox-title title-desc">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-line-chart"></i> PENCAPAIAN PER REGION</span></h4>            
            </div>
            <div class="ibox-content">     
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-5" style="">
                            <div class="col-md-2"><img src="<?= base_url() . 'assets/img/menu/semen_indonesia.JPG' ?>" style="width:90px;"></div>
                            <div class="col-md-10"><h2 style="text-align:left;line-height: 315%;text-indent:20px;"><b>SMIG GROUP</b></h2></div>
                        </div>
                        <div class="col-md-2">
                            <label>Region</label>
                            <select id="region" class="form-control" name="region">
                                <option value="all">All</option>
                                <option value="1">Region 1</option>
                                <option value="2">Region 2</option>
                                <option value="3">Region 3</option>
                                <option value="curah">Curah Jawa & Bali</option>
                            </select>
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
                            <button id="filter" class="btn btn-success" style="margin-top:24px;"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-4"><button id="refresh_btn" class="btn btn-info" style="margin-top:0px">Syncronize</button></div>
                    </div>
                    <div class="col-md-6 pull-right">
                        <a class="btn btn-default  pull-right disabled" style="margin-left:10px;margin-right:20px" disabled>Realisasi per Provinsi</a>
                        <a href="<?= base_url(); ?>smigroup/OptimasiMargin" class="btn btn-info  pull-right"   >Optimasi Margin</a>

                    </div>
                </div>
                <h3 style="margin-bottom: 0px"><strong>PENCAPAIAN SEHARUSNYA SDK : <span id="pencSeh"></span></strong></h3>
                <div class="table-responsive"> 
                    <h1 id="title-region"></h1>                  
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
                                <th class='warning' width='10%'>TARGET REVENUE SDK</th>
                                <th class='warning' width='10%'>REAL REVENUE SDK</th>
                                <th class='info' width='10%'>TARGET MARKETSHARE</th>
                                <th class='info' width='10%'>MARKETSHARE HARIAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- data di load disini -->
                        </tbody>
                    </table>                    
                </div>

                <!--                <div class="row">
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
                                </div>-->

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
<div class="row" id="tableBag">
    <div class="col-md-12">
        <div class="ibox ibox1 float-e-margins">            
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
                                <!-- <th class='success' width='20%'>KABIRO PENJUALAN</th> -->
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
<div class="row"  id="tableBulk">
    <div class="col-md-12">
        <div class="ibox ibox1 float-e-margins">            
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
                                <th class='success' width='20%'>KABIRO PENJUALAN</th>
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
<div class="row">    
    <div class="col-lg-12">        
        <div class="panel">            
            <div class="panel-heading">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-bar-chart-o"></i> PENCAPAIAN MASING-MASING BIRO PENJUALAN</span></h4>            
            </div>
            <div class="panel-body">   
                <div class="row">
                    <div class="col-md-12">
                        <canvas height="100%" id="chart"></canvas>
                    </div>
                </div>
                <div class="row">
                    <!-- <div class="col-md-1"></div> -->
                    <div class="col-md-12">
                        <table width="100%">
                            <tr><td colspan="10"><strong><u>Target harian untuk mencapai RKAP :</u></strong></td></tr>
                            <tr class="target_harian">

                            </tr>
                            <!-- <tr><td colspan="15">Keterangan :</td></tr>
                            <tr>
                                <td width="2%">Wil 1 : </td>
                                <td width="5%">&nbsp;Jatim</td>
                                <td width="2%">Wil 2 : </td> 
                                <td width="15%">&nbsp;Jateng, DIY</td>
                                <td width="2%">Wil 3 : </td> 
                                <td width="15%">&nbsp;DKI, Jabar, Banten</td>
                                <td width="2%">Wil 4 : </td>
                                <td width="10%">&nbsp;Luar Pulau</td>
                                <td width="2%">Curah : </td>
                                <td width="5%">&nbsp;Curah</td>
                                <td width="10%">&nbsp;</td>
                            </tr> -->
                        </table>
                    </div>
                </div>
            </div>            
        </div>        
    </div>
</div>
<!--<div class="row">    
    <div class="col-lg-12">        
        <div class="panel">            
            <div class="panel-heading">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-bar-chart-o"></i> PENCAPAIAN REVENUE MASING-MASING BIRO PENJUALAN</span></h4>            
            </div>
            <div class="panel-body">   
                <div class="row">
                    <div class="col-md-12">
                        <canvas height="70%" id="chart1"></canvas>
                    </div>
                </div>
                <div class="row">
                     <div class="col-md-1"></div> 
                    <div class="col-md-12">
                        <table width="100%">
                            <tr><td colspan="10">Target harian untuk mencapai RKAP :</td></tr>
                            <tr class="target_harian_revenue">

                            </tr>
                             <tr><td colspan="15">Keterangan :</td></tr>
                            <tr>
                                <td width="2%">Wil 1 : </td>
                                <td width="5%">&nbsp;Jatim</td>
                                <td width="2%">Wil 2 : </td> 
                                <td width="15%">&nbsp;Jateng, DIY</td>
                                <td width="2%">Wil 3 : </td> 
                                <td width="15%">&nbsp;DKI, Jabar, Banten</td>
                                <td width="2%">Wil 4 : </td>
                                <td width="10%">&nbsp;Luar Pulau</td>
                                <td width="2%">Curah : </td>
                                <td width="5%">&nbsp;Curah</td>
                                <td width="10%">&nbsp;</td>
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

    $("#refresh_btn").click(function () {
        var url = base_url + 'smigroup/PencapaianProvinsi/refresh_data';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function (xhr) {
                $('#loading_purple').show();
            },
            success: function (data) {
                $('#loading_purple').hide();
                $('#update-btn').click();
            }
        });
    });
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

    function getPersen(a, b) {
        if (b == 0) {
            return 0;
        } else {
            return Math.round(a / b * 100);
        }
    }

    function create_table(obj_data) {
        $("#table_pencapaian").dataTable().fnDestroy();
        var table_string = "<thead><tr>" +
                "<th class='success' width='5%'>NO</th>" +
                "<th class='success' width='15%'>PROVINSI</th>" +
                "<th class='success'>TARGET VOLUME DOM</th>" +
//                "<th class='success'>TARGET VOLUME SDK</th>" +
                "<th class='success'>REAL VOLUME SDK</th>" +
                "<th class='success' width='10%'>% REAL VOLUME</th>" +
//                "<th class='danger' width='10%'>% THD. TARGET SDK</th>" +
                "<th class='danger' width='10%'>TARGET HARGA NETTO (Rp/Ton)</th>" +
                "<th class='danger' width='10%'>REAL HARGA NETTO (Rp/Ton)</th>" +
                "<th class='danger' width='10%'>% HARGA NETTO</th>" +
                "<th class='warning' width='10%'>TARGET REVENUE DOM (JT)</th>" +
                "<th class='warning' width='10%'>REAL REVENUE SDK (JT)</th>" +
                "<th class='warning' width='10%'>% REAL REVENUE</th>" +
//                "<th class='info' width='10%'>TARGET MARKETSHARE</th>" +
//                "<th class='info' width='10%'>MARKETSHARE HARIAN</th>" +
                "</tr></thead><tbody>";
        var count = 0;
        //alert(obj_data['ms']['DEMAND_NASIONAL']);
        if (typeof obj_data['ms']['DEMAND_NASIONAL'] == 'undefined' || obj_data['ms']['DEMAND_NASIONAL'] == null) {
            var demand = 0;
        } else {
            var demand = Math.round(obj_data['ms']['DEMAND_NASIONAL'].toString().replace(',', '.'));
        }
        var rkapms = (obj_data.hasOwnProperty('rkapms') && obj_data['rkapms'] != null) ? obj_data['rkapms']['TARGET'].toString().replace('.', ',') : '';
        var totalReal = obj_data.total.REAL;
        var totalTarget = obj_data.total.TARGET;
        var totalTargetRealH = obj_data.total.TARGET_REALH;
        var totalTargetRevenue = 0;
        var totalRealRevenue = 0;
        if (isRealValue(obj_data)) {
            $.each(obj_data.sales, function (key, val) {
                count++;
                if (val.PERSENBULAN < obj_data.total['PENCSEH']) {
                    var warnaB = "class='bold label-merah'";
                } else {
                    var warnaB = "class='bold '";
                }
                if (val.PERSENHARI < 100) {
                    var warnaH = "class='bold label-merah'";
                } else {
                    var warnaH = "class='bold '";
                }
                //pewarnaan real revenue
                var warnaRealrev
                if ((parseFloat(val.REAL_REVENUE) / parseFloat(val.TARGET_REVENUE) * 100) < obj_data.total['PENCSEH']) {

                    warnaRealrev = "class='bold label-merah'";
                } else {
                    warnaRealrev = "class='bold '";
//                    var warnaRealrev = "class=' label-hijau'";
                }
                //pewarnaan ms harian
//                var warnamsHarian
//                if (val.RKAP_MS.toString().replace(',', '.') - val.MARKETSHARE.toString().replace(',', '.') >= 2) {
//
//                    warnamsHarian = "class=' label-merah'";
//                } else if (val.RKAP_MS.toString().replace(',', '.') - val.MARKETSHARE.toString().replace(',', '.') < 2 && val.RKAP_MS.toString().replace(',', '.') - val.MARKETSHARE.toString().replace(',', '.') >= 0) {
////                    var warnamsHarian = "class=' label-kuning'";
//                } else if (val.RKAP_MS.toString().replace(',', '.') - val.MARKETSHARE.toString().replace(',', '.') < 0) {
////                    var warnamsHarian = "class=' label-hijau'";
//                }
                

                var target = Math.round(val.TARGET.toString().replace(',', '.'));
                var targetRealH = Math.round(val.TARGET_REALH.toString().replace(',', '.'));
                var real = Math.round(val.REAL.toString().replace(',', '.'));
                totalTargetRevenue += parseFloat(val.TARGET_REVENUE);
                totalRealRevenue += parseFloat(val.REAL_REVENUE);
                //pewarnaan harga nett
                var warnaRealharga
                if (isNaN(Math.round(val.REAL_REVENUE / real/val.RKAP_HARGA*100)) || Math.round(val.REAL_REVENUE / real/val.RKAP_HARGA*100)<100) {
                    warnaRealharga = "class='bold label-merah'";
                } else {
                    warnaRealharga = "class='bold '";
//                    var warnaRealrev = "class=' label-hijau'";
                }
                
                table_string += "<tr>" +
                        "<td>" + count + "</td>" +
                        "<td>" + val.NM_PROV + "</td>" +
                        "<td align='right'>" + formatAngka(target) + "</td>" +
//                        "<td align='right'>" + formatAngka(targetRealH) + "</td>" +
                        "<td align='right'>" + formatAngka(real) + "</td>" +
                        "<td align='right'><span " + warnaB + ">" + val.PERSENBULAN + " %</span></td>" +
//                        "<td align='right'><span " + warnaH + ">" + val.PERSENHARI + " %</span></td>" +
                        "<td align='right'>" + formatAngka(Math.round(val.RKAP_HARGA)) + "</td>" +
                        "<td align='right'>" + formatAngka(isNaN(Math.round(val.REAL_REVENUE / real)) ? 0 : Math.round(val.REAL_REVENUE / real)) + "</td>" +
                        "<td align='right'><span " + warnaRealharga + ">" + formatAngka(isNaN(Math.round(val.REAL_REVENUE / real/val.RKAP_HARGA*100))? 0 : Math.round(val.REAL_REVENUE / real/val.RKAP_HARGA*100)) + " %</span></td>" +
                        "<td align='right'>" + formatAngka(Math.round(val.TARGET_REVENUE / 1000000)) + "</td>" +
                        "<td align='right'>" + formatAngka(Math.round(val.REAL_REVENUE / 1000000)) + "</td>" +
                        "<td align='right'><span " + warnaRealrev + ">" + Math.round(parseFloat(val.REAL_REVENUE) / parseFloat(val.TARGET_REVENUE) * 100) + " %</span></td>" +
//                        "<td align='right'>" + val.RKAP_MS + " %</td>" +
//                        "<td align='right'><span " + warnamsHarian + ">" + val.MARKETSHARE + " %</span></td>" +
                        "</tr>";
            });
        }
        table_string += "</tbody>";
        var persenTotalH = Math.round((totalReal / totalTargetRealH) * 100);
        var warna;
        if (persenTotalH < 90) {
            warna = "class=' label-merah'";
        } else if (persenTotalH >= 90 && persenTotalH < 100) {
//            var warna = "class='label label-kuning'";
        } else {
//            var warna = "class='label label-hijau'";
        }
        //pewarnaan total real revenue
        
        
        var warnaRealrev;
        if (totalRealRevenue / totalTargetRevenue < obj_data.total['PENCSEH']) {
            warnaRealrev = "class='bold label-merah'";
        } else if (totalRealRevenue == totalTargetRevenue) {
            var warnaRealrev = "class='bold '";
        } else {
            var warnaRealrev = "class='bold'";
        }
        
        var warnaRealVol = Math.round((totalReal / totalTarget) * 100) < obj_data.total['PENCSEH'] ?"class='bold label-merah'" :  "class='bold '";
        var warnaRealHarga ;
        if((totalRealRevenue/totalReal)/(totalTargetRevenue/totalTarget)< obj_data.total['PENCSEH']){
             warnaRealrev = "class='bold label-merah'";
        }else{
            warnaRealrev = "class='bold '";
        }

        var mstotal = Math.round(((totalReal / demand) * 100) * 10) / 10;
        //pewarnaan total ms harian
        var selisih = Math.round(rkapms.toString().replace(',', '.') - mstotal);
        var warnamsHarian;
        if (selisih >= 2) {
            warnamsHarian = "class='label-merah'";
        } else if (selisih < 2 && selisih >= 0) {
//            var warnamsHarian = "class='label label-kuning'";
        } else if (selisih < 2) {
//            var warnamsHarian = "class='label label-hijau'";
        }
        
        console.log(totalRealRevenue);
        
        table_string += "<tfoot><tr>" +
                "<td class='success' colspan='2' align='center'><b>TOTAL</b></td>" +
                "<td class='success' align='right'><b>" + formatAngka(totalTarget) + "</b></td>" +
//                "<td class='success' align='right'><b>" + formatAngka(totalTargetRealH) + "</b></td>" +
                "<td class='success' align='right'><b>" + formatAngka(totalReal) + "</b></td>" +
                "<td class='success' align='right'><span " + warnaRealVol + "><b>" + Math.round((totalReal / totalTarget) * 100) + " %</b></span></td>" +
//                "<td class='success' align='right'><span " + warna + "><b>" + persenTotalH + " %</b></span></td>" +
                "<td class='success' align='right'><b> "+ formatAngka(Math.round(totalTargetRevenue/totalTarget)) +" </b></td>" + //
                "<td class='success' align='right'><b> "+ formatAngka(Math.round(totalRealRevenue/totalReal)) +" </b></td>" +
                "<td class='success' align='right'><span " + warnaRealHarga + "><b>"+ Math.round((totalRealRevenue/totalReal)/(totalTargetRevenue/totalTarget)*100) +" %</b></span></td>" +
                "<td class='success' align='right'><b>" + formatAngka(Math.round(totalTargetRevenue / 1000000)) + "</b></td>" + //
                "<td class='success' align='right'><b> "+formatAngka(Math.round(totalRealRevenue / 1000000))+" </b></td>" +
                "<td class='success' align='right'><span " + warnaRealrev + "><b>"+Math.round( totalRealRevenue /totalTargetRevenue *100)+ " %</b></span></td>" +
                ////
//                "<td class='success' align='right'><b>" + rkapms + " %</b></td>" +
//                "<td class='success' align='right'><span " + warnamsHarian + "><b>" + mstotal.toString().replace(',', '.') + " %</b></span></td>" +
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
                "<th class='success'>NO</th>" +
                "<th class='success'>PROV</th>" +
                "<th class='success'>TARGET VOLUME DOM</th>" +
//                "<th class='success'>TARGET VOLUME SDK</th>" +
                "<th class='success'>REAL VOLUME SDK</th>" +
                "<th class='success'>% REAL VOLUME</th>" +
                "<th class='danger' width='10%'>TARGET HARGA NETTO (Rp/Ton)</th>" +
                "<th class='danger' width='10%'>REAL HARGA NETTO (Rp/Ton)</th>" +
                "<th class='danger' width='10%'>% HARGA NETTO</th>" +
//                "<th class='success'>% TARGET S/D KEMARIN</th>" +
                // "<th class='success'>JABATAN</th>" +
                "<th class='warning' width='10%'>TARGET REVENUE DOM (JT)</th>" +
                "<th class='warning' width='10%'>REAL REVENUE SDK (JT)</th>" +
                "<th class='warning' width='10%'>% REAL REVENUE</th>" +
                "</tr></thead><tbody>";
        var count = 0;
        var totalTarget = 0;
        var totalTargetRealH = 0;
        var totalTargetRevenue = 0;
        var totalRevenue = 0;
        var totalReal = 0;
        if (isRealValue(obj_data)) {
            $.each(obj_data.DATAPROV, function (key, val) {
                count++;
//                if (val.PERSENHARI < 90) {
//                    var warnaH = "class='label label-merah'";
//                } else if (val.PERSENHARI >= 90 && val.PERSENHARI < 100) {
//                    var warnaH = "class='label label-kuning'";
//                } else {
//                    var warnaH = "class='label label-hijau'";
//                }

                if (parseInt(val.PERSENBULAN) < obj_data.TOTAL['PENCSEH']) {
                    var warna = "class='bold label-merah'";
                } else {
                    var warna = "class='bold '";
                }
                if (parseInt(val.PERSENHARI) < 100) {
                    var warnaH = "class='bold label-merah'";
                } else {
                    var warnaH = "class='bold '";
                }
                if (getPersen(val.REAL_REVENUE, val.TARGET_REVENUE) < obj_data.TOTAL['PENCSEH']) {
                    var warnaR = "class='bold label-merah'";
                } else {
                    var warnaR = "class='bold '";
                }
                var target = Math.round(val.TARGET.toString().replace(',', '.'));
                var targetRealH = Math.round(val.TARGET_REALH.toString().replace(',', '.'));
                var real = Math.round(val.REAL.toString().replace(',', '.'));
                totalTarget += target;
                totalTargetRealH += targetRealH;
                totalReal += real;
                totalRevenue += parseFloat(val.REAL_REVENUE);
                totalTargetRevenue += parseFloat(val.TARGET_REVENUE);
                
                var warnaHarga = (Math.round(val.REAL_REVENUE / real) < Math.round(val.TARGET_REVENUE / target) ?  "class='bold label-merah'":"class='bold '");
                
                table_string += "<tr>" +
                        "<td>" + count + "</td>" +
                        "<td>" + val.NM_PROV_1 + "</td>" +
                        "<td align='right'>" + formatAngka(target) + "</td>" +
//                        "<td align='right'>" + formatAngka(targetRealH) + "</td>" +
                        "<td align='right'>" + formatAngka(real) + "</td>" +
                        "<td align='right'><span " + warna + ">" + val.PERSENBULAN + "%</span></td>" +
                        "<td align='right'>" + formatAngka(isNaN(Math.round(val.TARGET_REVENUE/target))?0:Math.round(val.TARGET_REVENUE/target)) + "</td>" +
                        "<td align='right'>" + formatAngka(isNaN(Math.round(val.REAL_REVENUE / real)) ? 0 : Math.round(val.REAL_REVENUE / real)) + "</td>" +
                        "<td align='right'><span " + warnaHarga + ">" + (isNaN(Math.round(val.REAL_REVENUE / real/(val.TARGET_REVENUE/target)*100))? 0 : Math.round((val.REAL_REVENUE / real)/(val.TARGET_REVENUE/target)*100)) + " %</span></td>" +
                        "<td align='right'>" + Math.round(val.TARGET_REVENUE / 1000000).toLocaleString(['ban', 'id']) + "</span></td>" +
                        "<td align='right'>" + Math.round(val.REAL_REVENUE / 1000000).toLocaleString(['ban', 'id']) + "</span></td>" +
                        "<td align='right'><span " + warnaR + ">" + getPersen(val.REAL_REVENUE, val.TARGET_REVENUE) + "%</span></td>" +
//                        "<td align='right'><span " + warnaH + ">% " + val.PERSENHARI + "</span></td>" +
                        // "<td>" + val.KABIRO + "</td>" +
                        "</tr>";
            });
        }
        table_string += "</tbody>";
        var persenTotalH = Math.round((totalReal / totalTargetRealH) * 100);
//        if (persenTotalH < 90) {
//            var warna = "class='label label-merah'";
//        } else if (persenTotalH >= 90 && persenTotalH < 100) {
//            var warna = "class='label label-kuning'";
//        } else {
//            var warna = "class='label label-hijau'";
//        }
        if (Math.round((totalReal / totalTarget) * 100) < obj_data.TOTAL['PENCSEH']) {
            var warna = "class='bold label-merah'";
        } else {
            var warna = "class='bold '";
        }
        if (persenTotalH < 100) {
            var warnaH = "class='bold label-merah'";
        } else {
            var warnaH = "class='bold '";
        }
        if (getPersen(totalRevenue, totalTargetRevenue) < obj_data.TOTAL['PENCSEH']) {
            var warnaR = "class='bold label-merah'";
        } else {
            var warnaR = "class='bold '";
        }
        
        var warnaHarga = Math.round((totalRevenue/totalReal)/(totalTargetRevenue/totalTarget)*100) < 100 ? "class='bold label-merah'" : "class='bold '" ;
        
        table_string += "<tfoot><tr>" +
                "<td class='success' colspan='2' align='center'><b>TOTAL</b></td>" +
                "<td class='success' align='right'><b>" + formatAngka(totalTarget) + "</b></td>" +
//                "<td class='success' align='right'><b>" + formatAngka(totalTargetRealH) + "</b></td>" +
                "<td class='success' align='right'><b>" + formatAngka(totalReal) + "</b></td>" +
                
                "<td class='success' align='right'><span " + warna + "><b>" + Math.round((totalReal / totalTarget) * 100) + " %</b></span></td>" +
                "<td class='success' align='right'><b> "+ formatAngka(Math.round(totalTargetRevenue/totalTarget)) +" </b></td>" + //
                "<td class='success' align='right'><b> "+ formatAngka(Math.round(totalRevenue/totalReal)) +" </b></td>" +
                "<td class='success' align='right'><span " + warnaHarga + "><b>"+ Math.round((totalRevenue/totalReal)/(totalTargetRevenue/totalTarget)*100) +" %</b></span></td>" +
                "<td class='success' align='right'><b>" + Math.round(totalTargetRevenue / 1000000).toLocaleString(['ban', 'id']) + "</b></td>" +
                "<td class='success' align='right'><b>"+formatAngka(Math.round(totalRevenue/1000000))+"</b></td>" +
                "<td class='success' align='right'><span " + warnaR + "><b>"+Math.round(totalRevenue/totalTargetRevenue*100)+" %</b></span></td>" +
//                "<td class='success' align='right'><span " + warnaH + "><b>" + persenTotalH + " %</b></span></td>" +
                // "<td class='success'>&nbsp;</td>" +
                "</tr></tfoot>";
        $("#table_pencapaian_bag").html(table_string);

        // Init Datatables with Tabletools Addon	
        $('#table_pencapaian_bag').DataTable({
            "bDestroy": true,
            "ordering": false,
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
    function create_table_bulk(obj_data) {
        $("#table_pencapaian_bulk").dataTable().fnDestroy();
        var table_string = "<thead><tr>" +
                "<th class='success'>NO</th>" +
                "<th class='success'>PROV</th>" +
                "<th class='success'>TARGET VOLUME DOM</th>" +
//                "<th class='success'>TARGET VOLUME SDK</th>" +
                "<th class='success'>REAL VOLUME SDK</th>" +
                "<th class='success'>% REAL VOLUME</th>" +
                 "<th class='danger' width='10%'>TARGET HARGA NETTO (Rp/Ton)</th>" +
                "<th class='danger' width='10%'>REAL HARGA NETTO (Rp/Ton)</th>" +
                "<th class='danger' width='10%'>% HARGA NETTO</th>" +
//                "<th class='success'>% TARGET S/D KEMARIN</th>" +
                // "<th class='success'>JABATAN</th>" +
                "<th class='warning' width='10%'>TARGET REVENUE DOM (JT)</th>" +
                "<th class='warning' width='10%'>REAL REVENUE SDK (JT)</th>" +
                "<th class='warning' width='10%'>% REAL REVENUE</th>" +
                "</tr></thead><tbody>";
        var count = 0;
        var totalTarget = 0;
        var totalTargetRealH = 0;
        var totalTargetRevenue = 0;
        var totalRevenue = 0;
        var totalReal = 0;
        if (isRealValue(obj_data)) {
            $.each(obj_data.DATAPROV, function (key, val) {
                count++;
//                if (val.PERSENHARI < 90) {
//                    var warnaH = "class='label label-merah'";
//                } else if (val.PERSENHARI >= 90 && val.PERSENHARI < 100) {
//                    var warnaH = "class='label label-kuning'";
//                } else {
//                    var warnaH = "class='label label-hijau'";
//                }
                if (parseInt(val.PERSENBULAN) < obj_data.TOTAL['PENCSEH']) {
                    var warna = "class='bold label-merah'";
                } else {
                    var warna = "class='bold '";
                }
                if (parseInt(val.PERSENHARI) < 100) {
                    var warnaH = "class='bold label-merah'";
                } else {
                    var warnaH = "class='bold '";
                }
                if (getPersen(val.REAL_REVENUE, val.TARGET_REVENUE) < obj_data.TOTAL['PENCSEH']) {
                    var warnaR = "class='bold label-merah'";
                } else {
                    var warnaR = "class='bold '";
                }
                
                
                var target = Math.round(val.TARGET.toString().replace(',', '.'));
                var targetRealH = Math.round(val.TARGET_REALH.toString().replace(',', '.'));
                var real = Math.round(val.REAL.toString().replace(',', '.'));
                totalRevenue += parseFloat(val.REAL_REVENUE);
                totalTargetRevenue += parseFloat(val.TARGET_REVENUE);
                totalTarget += target;
                totalTargetRealH += targetRealH;
                totalReal += real;
                
                var warnaHarga = (Math.round(val.REAL_REVENUE / real) < Math.round(val.TARGET_REVENUE / target) ?  "class='bold label-merah'":"class='bold '");
                table_string += "<tr>" +
                        "<td>" + count + "</td>" +
                        "<td align='left'>" + val.NM_PROV_1 + "</td>" +
                        "<td align='right'>" + formatAngka(target) + "</td>" +
//                        "<td align='right'>" + formatAngka(targetRealH) + "</td>" +
                        "<td align='right'>" + formatAngka(real) + "</td>" +
                        "<td align='right'><span " + warna + ">" + val.PERSENBULAN + "%</span></td>" +
                        "<td align='right'>" + formatAngka(isNaN(Math.round(val.TARGET_REVENUE/target))? 0 : Math.round(val.TARGET_REVENUE/target)) + "</td>" +
                        "<td align='right'>" + formatAngka(isNaN(Math.round(val.REAL_REVENUE / real)) ? 0 : Math.round(val.REAL_REVENUE / real)) + "</td>" +
                        "<td align='right'><span " + warnaHarga + ">" + (isNaN(Math.round(val.REAL_REVENUE / real/(val.TARGET_REVENUE/target)*100))? 0 : Math.round((val.REAL_REVENUE / real)/(val.TARGET_REVENUE/target)*100)) + " %</span></td>" +
                        "<td align='right'>" + Math.round(val.TARGET_REVENUE / 1000000).toLocaleString(['ban', 'id']) + "</span></td>" +
                        "<td align='right'>" + Math.round(val.REAL_REVENUE / 1000000).toLocaleString(['ban', 'id']) + "</span></td>" +
                        "<td align='right'><span " + warnaR + ">" + getPersen(val.REAL_REVENUE, val.TARGET_REVENUE) + "%</span></td>" +
//                        "<td align='right'><span " + warnaH + ">% " + val.PERSENHARI + "</span></td>" +
                        // "<td align='left'>" + val.KABIRO + "</td>" +
                        "</tr>";
            });
        }
        table_string += "</tbody>";
        var persenTotalH = Math.round((totalReal / totalTargetRealH) * 100);
//        if (persenTotalH < 90) {
//            var warna = "class='label label-merah'";
//        } else if (persenTotalH >= 90 && persenTotalH < 100) {
//            var warna = "class='label label-kuning'";
//        } else {
//            var warna = "class='label label-hijau'";
//        }
        if (Math.round((totalReal / totalTarget) * 100) < obj_data.TOTAL['PENCSEH']) {
            var warna = "class='bold label-merah'";
        } else {
            var warna = "class='bold '";
        }
        if (persenTotalH < 100) {
            var warnaH = "class='bold label-merah'";
        } else {
            var warnaH = "class='bold '";
        }
        if (getPersen(totalRevenue, totalTargetRevenue) < obj_data.TOTAL['PENCSEH']) {
            var warnaR = "class='bold label-merah'";
        } else {
            var warnaR = "class='bold '";
        }
        var warnaHarga = Math.round((totalRevenue/totalReal)/(totalTargetRevenue/totalTarget)*100) < 100 ? "class='bold label-merah'" : "class='bold '" ;
        
        table_string += "<tfoot><tr>" +
                "<td class='success' colspan='2' align='center'><b>TOTAL</b></td>" +
                "<td class='success' align='right'><b>" + formatAngka(totalTarget) + "</b></td>" +
//                "<td class='success' align='right'><b>" + formatAngka(totalTargetRealH) + "</b></td>" +
                "<td class='success' align='right'><b>" + formatAngka(totalReal) + "</b></td>" +
                "<td class='success' align='right'><span " + warna + "><b>" + Math.round((totalReal / totalTarget) * 100) + " %</b></span></td>" +
                 "<td class='success' align='right'><b> "+ formatAngka(Math.round(totalTargetRevenue/totalTarget)) +" </b></td>" + //
                "<td class='success' align='right'><b> "+ formatAngka(Math.round(totalRevenue/totalReal)) +" </b></td>" +
                "<td class='success' align='right'><span " + warnaHarga + "><b>"+ Math.round((totalRevenue/totalReal)/(totalTargetRevenue/totalTarget)*100) +" %</b></span></td>" +
                "<td class='success' align='right'><b>" + Math.round(totalTargetRevenue / 1000000).toLocaleString(['ban', 'id']) + " </b></td>" +
                "<td class='success' align='right'><b> "+formatAngka( Math.round(totalRevenue/1000000))+"</b></td>" +
                "<td class='success' align='right'><span " + warnaR + "><b>" +Math.round(totalRevenue/totalTargetRevenue*100)+ " %</b></span></td>" +
//                "<td class='success' align='right'><span " + warnaH + "><b>" + persenTotalH + " %</b></span></td>" +
                // "<td class='success'>&nbsp;</td>" +
                "</tr></tfoot>";
        $("#table_pencapaian_bulk").html(table_string);

        // Init Datatables with Tabletools Addon	
        $('#table_pencapaian_bulk').DataTable({
            "bDestroy": true,
            "ordering": false,
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
    function get_pencapaian(tahun, bulan, hari, region) {
        var url = base_url + 'smigroup/PencapaianProvinsi/scodata/' + tahun + '/' + bulan + '/' + hari + '/' + region;
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
    function get_pencapaian_bag(tahun, bulan, hari, region) {
        var url = base_url + 'smigroup/PencapaianProvinsi/scodataBag/' + tahun + '/' + bulan + '/' + hari + '/' + region;
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
    function get_pencapaian_bulk(tahun, bulan, hari, region) {
        var url = base_url + 'smigroup/PencapaianProvinsi/scodataBulk/' + tahun + '/' + bulan + '/' + hari + '/' + region;
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
    function chart(tahun, bulan, hari, region) {

        if (region == 'curah') {
            console.log(1);
            $('#chart').css('width', '33%');

        } else if (region == 1) {
            $('#chart').css('width', '67%');
        } else if (region == 2 || region == 3 || region == 'all') {
            $('#chart').css('width', '100%');
        }
        var ctx1 = document.getElementById('chart').getContext("2d");
        var url = base_url + 'smigroup/PencapaianProvinsi/getDataChart/' + tahun + '/' + bulan + '/' + hari + '/' + region;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function (datas) {
                //chart bar 1
                if (region == 1) {
                    $('#title-region').html('Bag/Curah All Sumatera');
                } else if (region == 2) {
                    $('#title-region').html('Bag All Jawa Bali');
                } else if (region == 3) {
                    $('#title-region').html('Bag/Curah All Kalimantan, Sulawesi, Nusra, Ind. Timur');
                } else if (region == 'curah') {
                    $('#title-region').html('Curah All Jawa & Bali');
                } else {
                    $('#title-region').html('Bag & Curah All Provinsi');
                }
                $('#pencSeh').html(datas['targetsd'][0] + '%');
                var barChartData1 = {
                    labels: datas['labels'],
                    datasets: [
                        {
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
                        },
                    ]
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
                    scaleLabel: "<%=value%>%",
                    responsive: true,
                    scales: {

                        xAxes: [{
                                scaleLabel: {

                                    display: true,
                                    labelString: 'Prosentase Seharusnya ' + datas['targetsd'][0] + '%'
                                },
                                ticks: {
                                    max: 110,
                                    suggestedMin: 0,
                                    callback: function (value, index, values) {
                                        return formatAngka(value);
                                    }
                                },
                                barPercentage: 2
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
                                if (label == 'Biro Penj 1') {
                                    wilayah = 'Sumbar, Riau, Jambi Bengkulu';
                                } else if (label == 'Biro Penj 2') {
                                    wilayah = 'Aceh, Sumut, Rikep, Sumbagsel';
                                } else if (label == 'Biro Penj 3') {
                                    wilayah = 'Jatim & Bali';
                                } else if (label == 'Biro Penj 4') {
                                    wilayah = 'Jateng & DIY';
                                } else if (label == 'Biro Penj 5') {
                                    wilayah = 'Banten, DKI, Jabar';
                                } else if (label == 'Biro Curah Jawa Bali') {
                                    wilayah = 'Curah Jawa & Bali';
                                } else if (label == 'Biro Penj 7') {
                                    wilayah = 'Sulawesi';
                                } else if (label == 'Biro Penj 8') {
                                    wilayah = 'Kalimantan';
                                } else if (label == 'Biro Penj 9') {
                                    wilayah = 'Maluku, Papua & Nusa Tenggara';
                                }
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
    function chart1(tahun, bulan, hari, region) {
        var ctx2 = document.getElementById('chart1').getContext("2d");
        var url = base_url + 'smigroup/PencapaianProvinsi/revenueKabiro/' + tahun + '/' + bulan + '/' + hari + '/' + region;
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
                        },
                        {
                            type: "line",
                            label: 'TARGET S/D KEMARIN',
                            backgroundColor: "red",
                            data: datas['targetsd']
                        }
                    ]
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
                $('tr.target_harian_revenue').html(_td.join(''));
                var options2 = {
                    title: {
                        display: true,
                        text: "Grafik Target Dan Realisasi Revenue"
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
                                if (label == 'Biro Penj 1') {
                                    wilayah = 'Sumbar, Riau, Jambi Bengkulu';
                                } else if (label == 'Biro Penj 2') {
                                    wilayah = 'Aceh, Sumut, Rikep, Sumbagsel';
                                } else if (label == 'Biro Penj 3') {
                                    wilayah = 'Jatim & Bali';
                                } else if (label == 'Biro Penj 4') {
                                    wilayah = 'Jateng & DIY';
                                } else if (label == 'Biro Penj 5') {
                                    wilayah = 'Banten, DKI, Jabar';
                                } else if (label == 'Biro Penj 6') {
                                    wilayah = 'Curah';
                                } else if (label == 'Biro Penj 7') {
                                    wilayah = 'Sulawesi';
                                } else if (label == 'Biro Penj 8') {
                                    wilayah = 'Kalimantan & Nusa Tenggara';
                                } else if (label == 'Biro Penj 9') {
                                    wilayah = 'Maluku & Papua';
                                }
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
                                return datasetLabel + ' : ' + tooltipItem.xLabel + ' % (Rp. ' + formatAngka(tonase[tooltipItem.index]) + ' )';
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
                                    console.log(i);
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

    function updateChart(tahun, bulan, hari, region) {
        var url = base_url + 'smigroup/PencapaianProvinsi/getDataChart/' + tahun + '/' + bulan + '/' + hari + '/' + region;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (datas) {
                var d = new Date();
                chartBar1.data.labels = datas['labels'];
                chartBar1.data.datasets[0].data = datas['dataset'];
                if (tahun == d.getFullYear() && parseInt(bulan) == d.getMonth() + 1) {
                    console.log('1');
                    chartBar1.data.datasets[1].data = datas['targetsd'];
                } else {
                    console.log('2' + tahun + bulan);
                    chartBar1.data.datasets[1].data = [0, 0, 0, 0];
                }

                chartBar1.data.datasets[2].data = datas['target'];
                chartBar1.options.animation = {
                    onComplete: function () {
                        var chartInstance = this.chart;
                        var ctx = chartInstance.ctx;
                        ctx.textAlign = "left";

                        Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                console.log(i);
                                if (i === 2) {
                                    ctx.fillText(datas['kabiro'][index], bar._model.x + 5, bar._model.y - 5);
                                }

                            }), this);
                        }), this);
                    }
                }

                chartBar1.update();

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
                $('#loading_purple').hide();
                //  chartBar1.options.tooltips.callbacks();
            }
        });
    }

    function updateChartRevenue(tahun, bulan, hari, region) {
        var url = base_url + 'smigroup/PencapaianProvinsi/revenueKabiro/' + tahun + '/' + bulan + '/' + hari + '/' + region;
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
                chartBar2.data.datasets[1].data = [0, 0, 0, 0]
                chartBar2.data.datasets[2].data = datas['target'];
                chartBar2.update();

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
                console.log(datas['labels']);
                for (var i in datas['labels']) {
                    _td.push('<td>' + datas['labels'][i] + ' :</td>');
                    _td.push('<td><span class="badge badge-primary">' + formatAngka(target_harian[i]) + '</span></td>');
                }
                $('tr.target_harian_revenue').html(_td.join(''));
                $('#loading_purple').hide();
                chartBar2.options.tooltips.callbacks();
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
        var n = month[d.getMonth()];
        $('#loading_purple').hide();
        $('#tahun').val(d.getUTCFullYear());
        $('#bulan').val(n);

        var region = $('#region').val();
        var tahun = $('#tahun').val();
        var bulan = $('#bulan').val();
        var hari = d.getDate() + '';
        if (hari.length == 1) {
            hari = '0' + hari;
        }
        get_pencapaian(tahun, bulan, hari, region);
        get_pencapaian_bag(tahun, bulan, hari, region);
        get_pencapaian_bulk(tahun, bulan, hari, region);
        chart(tahun, bulan, hari, region);
        //chart1(tahun, bulan, hari, region);
        $('#filter').click(function () {
            var region = $('#region').val();
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            var hari = getLastDate(tahun, bulan);
            if (tahun == d.getUTCFullYear() && bulan == month[d.getUTCMonth()]) {
                hari = d.getDate() + '';
            }
            if (hari.length == 1) {
                hari = '0' + hari;
            }
            get_pencapaian(tahun, bulan, hari, region);
            if (region == '2' || region == 'curah') {
                $('#tableBag').hide();
                $('#tableBulk').hide();

            } else {
                $('#tableBag').show();
                $('#tableBulk').show();
                get_pencapaian_bag(tahun, bulan, hari, region);
                get_pencapaian_bulk(tahun, bulan, hari, region);
            }
            chartBar1.destroy();
            chart(tahun, bulan, hari, region);
            //updateChart(tahun, bulan, hari, region);
            //updateChartRevenue(tahun, bulan, hari, region);


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


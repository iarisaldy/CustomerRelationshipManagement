<style>
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
    .ibox{
        color: black;
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
    td.details-control {
        background: url('<?php echo base_url(); ?>assets/img/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('<?php echo base_url(); ?>assets/img/details_close.png') no-repeat center center;
    }
    #table_keputusan{
        color: #000;
    }
    #table_keputusan tbody{
        text-align: right;
    }
    .konten{
        position: relative;
        width: 115%;
        right: 6%;
        padding-top: 0%;
    }
    .font-merah {
        color: #ff4545;
    }
</style>
<link href="<?php echo base_url(); ?>assets/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/fixedHeader.dataTables.min.css" rel="stylesheet">
<!--<link href="<?php echo base_url(); ?>assets/datatables/css/fixedColumns.dataTables.min.css" rel="stylesheet">-->
<div id="loading_purple"></div>
<div class="row konten">    
    <div class="col-lg-12">        
        <div class="panel">            
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><span class="text-navy"> DECISION SUPPORT SYSTEM</span></h4>            
                </div>                
            </div>
            <div class="panel-body">  
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <label>Opco</label>
                            <select id="opco" class="pilihan form-control" name="opco">
                                <option value="0">All Opco</option>
                                <option value="7000">Semen Gresik</option>
                                <option value="3000">Semen Padang</option>
                                <option value="4000">Semen Tonasa</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Provinsi</label>
                            <select id="provinsi" class="pilihan form-control" name="provinsi">
                                <option value="0">All Provinsi</option>
                                <?php
                                foreach ($provinsi as $value) {
                                    echo '<option value="' . $value['KD_PROV'] . '">' . $value['NM_PROV'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Kota</label>
                            <select id="kota" class="pilihan form-control" name="kota">

                            </select>
                        </div>                        
                        <div class="col-md-2">
                            <label>Stock Level</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="pilihan" id="cek30"> < 30%
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>SDR Maks</label>
                            <select id="sdr-maks" class="pilihan form-control" name="sdr-maks">
                                <option value="0">All</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label>TUR</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="cekBox" id="cekTUR"> < 1
                                </label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label>SCR</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="cekBox" id="cekSCR"> < 1
                                </label>
                            </div>
                        </div>
                    </div>
                </div><br/>                               
                <div class="table-responsive">                        
                    <table id="table_keputusan" class="table table-bordered table-stripped" >
                        <thead>
                            <tr>
                                <th class='success' width='3%'>NO</th>
                                <th class='success' width='10%'>KODE GUDANG</th>
                                <th class='success' width='10%'>DISTRIBUTOR</th>
                                <th class='success' width='10%'>KOTA</th>
                                <th class='success' width='10%' data-toggle="tooltip" data-placement="left" title="Stok On Hand">STOK OH (ton)</th>
                                <th class='success' width='10%' data-toggle="tooltip" data-placement="left" title="Stok In Transit">STOK IT (ton)</th>
                                <th class='success' width='5%'>TRUCK IN TRANSIT</th>
                                <th class='success' width='10%' data-toggle="tooltip" data-placement="left" title="Kapasitas">KAPS</th>
                                <th class='success' width='10%' data-toggle="tooltip" data-placement="left" title="Stok Level On Hand">SL (OH)</th>
                                <th class='success' width='10%' data-toggle="tooltip" data-placement="left" title="Demand">D</th>
                                <th class='success' width='5%' data-toggle="tooltip" data-placement="left" title="Lead Time">LT</th>
                                <th class='success' width='10%'>KAPASITAS BONGKAR / HARI (ton)</th>
                                <th class='danger' width='5%'>SDR</th>
                                <th class='danger' width='5%'>TUR</th>
                                <th class='danger' width='5%'>SCR</th>
                                <th class='success' width='10%'>SISA SO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- data di load disini -->
                        </tbody>
                        <tfoot>

                        </tfoot>
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

<script src="<?php echo base_url(); ?>assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.fixedHeader.min.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.fixedColumns.min.js"></script>-->
<script>
    var table;
    var dataChild = new Array();
    var dataBaris;
    var kota = new Array();
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
        $("#table_keputusan").dataTable().fnDestroy();
        var table_string = "";
        var footer_string = "";
        var count = 0;
        var stok = 0;
        var transit = 0;
        var jml_truk = 0;
        var kapasitas = 0;
        var demand = 0;
        var leadtime = 0;
        var loadtruk = 0;
        var sisa_to = 0;
        if (isRealValue(obj_data)) {
            $.each(obj_data, function (key, val) {
                dataChild.push(val);
                count++;
                var stoklevel = (Math.round((val.STOK / val.KAPASITAS * 100) * 10) / 10).toString().replace('.', ',');
                table_string += "<tr>" +
                        //"<td class='details-control'></td>" +
                        "<td>" + count + "</td>" +
                        "<td>" + val.KD_GDG + "</td>" +
                        "<td>" + val.NM_DISTR + "</td>" +
                        "<td>" + val.NM_DISTRIK + "</td>" +
                        "<td>" + formatAngka(val.STOK) + "</td>" +
                        "<td>" + val.TRANSIT + "</td>" +
                        "<td>" + val.JML_TRUK + "</td>" +
                        "<td>" + formatAngka(val.KAPASITAS) + "</td>";
                if (val.TOTAL_LEVEL_ONHAND <= 30) {
                    table_string += "<td class='font-merah'>" + val.TOTAL_LEVEL_ONHAND.toString().replace('.', ',') + " %</td>";
                } else {
                    table_string += "<td>" + formatAngka(val.TOTAL_LEVEL_ONHAND.toString().replace('.', ',')) + " %</td>";
                }
                table_string += "<td>" + val.DEMAND + "</td>" +
                        "<td>" + val.LEADTIME.toString().replace('.', ',') + "</td>" +
                        "<td>" + formatAngka(val.LOAD_TRUK) + "</td>" +
                        "<td>" + val.SDR.toString().replace('.', ',') + "</td>";
                if (val.TUR < 1) {
                    table_string += "<td class='font-merah'>" + val.TUR.toString().replace('.', ',') + "</td>";
                } else {
                    table_string += "<td>" + val.TUR.toString().replace('.', ',') + "</td>";
                }
                if (val.SCR < 1) {
                    table_string += "<td class='font-merah'>" + val.SCR.toString().replace('.', ',') + "</td>";
                } else {
                    table_string += "<td>" + val.SCR.toString().replace('.', ',') + "</td>";
                }
                table_string += "<td>" + formatAngka(val.SISA_TO) + "</td>" +
                        "</tr>";
                stok += parseInt(val.STOK);
                transit += parseInt(val.TRANSIT);
                jml_truk += parseInt(val.JML_TRUK);
                kapasitas += parseInt(val.KAPASITAS);
                demand += parseInt(val.DEMAND);
                leadtime += parseFloat(val.LEADTIME);
                loadtruk += parseFloat(val.LOAD_TRUK);
                sisa_to += parseFloat(val.SISA_TO);
            });
        }
        var stockleveltotal = (Math.round((stok / kapasitas * 100) * 10) / 10).toString().replace('.', ',');
        footer_string += "<tr>" +
                "<td class='success' colspan='4' align='center'><b>TOTAL</b></td>" +
                "<td align='center'><b>" + formatAngka(stok) + "</b></td>" +
                "<td align='center'><b>" + formatAngka(transit) + "</b></td>" +
                "<td align='center'><b>" + formatAngka(jml_truk) + "</b></td>" +
                "<td align='center'><b>" + formatAngka(kapasitas) + "</b></td>" +
                "<td align='center'><b>" + stockleveltotal + " %</b></td>" +
                "<td align='center'><b>" + formatAngka(demand) + "</b></td>" +
                "<td align='center'><b>" + (Math.round((leadtime) * 10) / 10).toString().replace('.', ',') + "</b></td>" +
                "<td align='center'><b>" + formatAngka(loadtruk) + "</b></td>" +
                "<td align='center'><b>&nbsp;</b></td>" +
                "<td align='center'><b>&nbsp;</b></td>" +
                "<td align='center'><b>&nbsp;</b></td>" +
                "<td align='center'><b>" + formatAngka((Math.round((sisa_to) * 10) / 10).toString().replace('.', ',')) + "</b></td>" +
                "</tr>";
        $("#table_keputusan tbody").html(table_string);
        $("#table_keputusan tfoot").html(footer_string);
        // Init Datatables with Tabletools Addon	
        dataBaris = dataChild;
        table = $('#table_keputusan').DataTable({
            bDestroy: true,
            paging: false,
            searching: false,
            fixedHeader: true
        });
    }
    function update_table(opco, prov, cek30, kota, sdr) {
        $("#table_keputusan").dataTable().fnDestroy();
        var table_string = "";
        var footer_string = "";
        var count = 0;
        var stok = 0;
        var transit = 0;
        var jml_truk = 0;
        var kapasitas = 0;
        var demand = 0;
        var leadtime = 0;
        var sisa_to = 0;
        //var dataBaris = new Array();
        dataBaris = new Array();
        if (isRealValue(dataChild)) {
            $.each(dataChild, function (key, val) {
                if (cek30) {
                    if (sdr > 0) {
                        if (val.SDR <= sdr) {
                            var stoklevel = (Math.round((val.STOK / val.KAPASITAS * 100) * 10) / 10);
                            if (stoklevel < 30) {
                                if (opco == 0 && prov == 0 && kota == 0) {
                                    dataBaris.push(val);
                                } else if (opco == 0 && prov != 0 && kota == 0) {
                                    if (val.KD_PROVINSI == prov) {
                                        dataBaris.push(val);
                                    }
                                } else if (opco != 0 && prov == 0 && kota == 0) {
                                    if (val.ORG == opco) {
                                        dataBaris.push(val);
                                    }
                                } else if (opco != 0 && prov != 0 && kota == 0) {
                                    if (val.ORG == opco && val.KD_PROVINSI == prov) {
                                        dataBaris.push(val);
                                    }
                                } else if (opco != 0 && prov == 0 && kota != 0) {
                                    if (val.ORG == opco && val.KD_DISTRIK == kota) {
                                        dataBaris.push(val);
                                    }
                                } else if (opco == 0 && prov != 0 && kota != 0) {
                                    if (val.KD_PROVINSI == prov && val.KD_DISTRIK == kota) {
                                        dataBaris.push(val);
                                    }
                                } else {
                                    if (val.ORG == opco && val.KD_PROVINSI == prov && val.KD_DISTRIK == kota) {
                                        dataBaris.push(val);
                                    }
                                }
                            }
                        }
                    } else {
                        var stoklevel = (Math.round((val.STOK / val.KAPASITAS * 100) * 10) / 10);
                        if (stoklevel < 30) {
                            if (opco == 0 && prov == 0 && kota == 0) {
                                dataBaris.push(val);
                            } else if (opco == 0 && prov != 0 && kota == 0) {
                                if (val.KD_PROVINSI == prov) {
                                    dataBaris.push(val);
                                }
                            } else if (opco != 0 && prov == 0 && kota == 0) {
                                if (val.ORG == opco) {
                                    dataBaris.push(val);
                                }
                            } else if (opco != 0 && prov != 0 && kota == 0) {
                                if (val.ORG == opco && val.KD_PROVINSI == prov) {
                                    dataBaris.push(val);
                                }
                            } else if (opco != 0 && prov == 0 && kota != 0) {
                                if (val.ORG == opco && val.KD_DISTRIK == kota) {
                                    dataBaris.push(val);
                                }
                            } else if (opco == 0 && prov != 0 && kota != 0) {
                                if (val.KD_PROVINSI == prov && val.KD_DISTRIK == kota) {
                                    dataBaris.push(val);
                                }
                            } else {
                                if (val.ORG == opco && val.KD_PROVINSI == prov && val.KD_DISTRIK == kota) {
                                    dataBaris.push(val);
                                }
                            }
                        }
                    }
                } else {
                    if (sdr > 0) {
                        if (val.SDR <= sdr) {
                            if (opco == 0 && prov == 0 && kota == 0) {
                                dataBaris.push(val);
                            } else if (opco == 0 && prov != 0 && kota == 0) {
                                if (val.KD_PROVINSI == prov) {
                                    dataBaris.push(val);
                                }
                            } else if (opco != 0 && prov == 0 && kota == 0) {
                                if (val.ORG == opco) {
                                    dataBaris.push(val);
                                }
                            } else if (opco != 0 && prov != 0 && kota == 0) {
                                if (val.ORG == opco && val.KD_PROVINSI == prov) {
                                    dataBaris.push(val);
                                }
                            } else if (opco != 0 && prov == 0 && kota != 0) {
                                if (val.ORG == opco && val.KD_DISTRIK == kota) {
                                    dataBaris.push(val);
                                }
                            } else if (opco == 0 && prov != 0 && kota != 0) {
                                if (val.KD_PROVINSI == prov && val.KD_DISTRIK == kota) {
                                    dataBaris.push(val);
                                }
                            } else {
                                if (val.ORG == opco && val.KD_PROVINSI == prov && val.KD_DISTRIK == kota) {
                                    dataBaris.push(val);
                                }
                            }
                        }
                    } else {
                        if (opco == 0 && prov == 0 && kota == 0) {
                            dataBaris.push(val);
                        } else if (opco == 0 && prov != 0 && kota == 0) {
                            if (val.KD_PROVINSI == prov) {
                                dataBaris.push(val);
                            }
                        } else if (opco != 0 && prov == 0 && kota == 0) {
                            if (val.ORG == opco) {
                                dataBaris.push(val);
                            }
                        } else if (opco != 0 && prov != 0 && kota == 0) {
                            if (val.ORG == opco && val.KD_PROVINSI == prov) {
                                dataBaris.push(val);
                            }
                        } else if (opco != 0 && prov == 0 && kota != 0) {
                            if (val.ORG == opco && val.KD_DISTRIK == kota) {
                                dataBaris.push(val);
                            }
                        } else if (opco == 0 && prov != 0 && kota != 0) {
                            if (val.KD_PROVINSI == prov && val.KD_DISTRIK == kota) {
                                dataBaris.push(val);
                            }
                        } else {
                            if (val.ORG == opco && val.KD_PROVINSI == prov && val.KD_DISTRIK == kota) {
                                dataBaris.push(val);
                            }
                        }
                    }
                }
            });
            $.each(dataBaris, function (key, val) {
                count++;
                var stoklevel = (Math.round(((val.STOK / val.KAPASITAS) * 100) * 10) / 10).toString().replace('.', ',');
                table_string += "<tr>" +
                        //"<td class='details-control'></td>" +
                        "<td>" + count + "</td>" +
                        "<td>" + val.KD_GDG + "</td>" +
                        "<td>" + val.NM_DISTR + "</td>" +
                        "<td>" + val.NM_DISTRIK + "</td>" +
                        "<td>" + formatAngka(val.STOK) + "</td>" +
                        "<td>" + val.TRANSIT + "</td>" +
                        "<td>" + val.JML_TRUK + "</td>" +
                        "<td>" + formatAngka(val.KAPASITAS) + "</td>";
                if (val.TOTAL_LEVEL_ONHAND <= 30) {
                    table_string += "<td class='font-merah'>" + val.TOTAL_LEVEL_ONHAND.toString().replace('.', ',') + " %</td>";
                } else {
                    table_string += "<td>" + val.TOTAL_LEVEL_ONHAND.toString().replace('.', ',') + " %</td>";
                }
                table_string += "<td>" + val.DEMAND + "</td>" +
                        "<td>" + val.LEADTIME.toString().replace('.', ',') + "</td>" +
                        "<td>" + formatAngka(val.LOAD_TRUK) + "</td>" +
                        "<td>" + val.SDR.toString().replace('.', ',') + "</td>";
                if (val.TUR < 1) {
                    table_string += "<td class='font-merah'>" + val.TUR.toString().replace('.', ',') + "</td>";
                } else {
                    table_string += "<td>" + val.TUR.toString().replace('.', ',') + "</td>";
                }
                if (val.SCR < 1) {
                    table_string += "<td class='font-merah'>" + val.SCR.toString().replace('.', ',') + "</td>";
                } else {
                    table_string += "<td>" + val.SCR.toString().replace('.', ',') + "</td>";
                }
                table_string += "<td>" + formatAngka(val.SISA_TO) + "</td>" +
                        "</tr>";
                stok += parseInt(val.STOK);
                transit += parseInt(val.TRANSIT);
                jml_truk += parseInt(val.JML_TRUK);
                kapasitas += parseInt(val.KAPASITAS);
                demand += parseInt(val.DEMAND);
                leadtime += parseFloat(val.LEADTIME);
                sisa_to += parseFloat(val.SISA_TO);
            });
        }
        var stockleveltotal = (Math.round((stok / kapasitas * 100) * 10) / 10).toString().replace('.', ',');
        footer_string += "<tr>" +
                "<td class='success' colspan='4' align='center'><b>TOTAL</b></td>" +
                "<td align='center'><b>" + formatAngka(stok) + "</b></td>" +
                "<td align='center'><b>" + formatAngka(transit) + "</b></td>" +
                "<td align='center'><b>" + jml_truk + "</b></td>" +
                "<td align='center'><b>" + formatAngka(kapasitas) + "</b></td>" +
                "<td align='center'><b>" + stockleveltotal + " %</b></td>" +
                "<td align='center'><b>" + formatAngka(demand) + "</b></td>" +
                "<td align='center'><b>" + (Math.round((leadtime) * 10) / 10).toString().replace('.', ',') + "</b></td>" +
                "<td align='center'><b>&nbsp;</b></td>" +
                "<td align='center'><b>&nbsp;</b></td>" +
                "<td align='center'><b>&nbsp;</b></td>" +
                "<td align='center'><b>&nbsp;</b></td>" +
                "<td align='center'><b>" + formatAngka((Math.round((sisa_to) * 10) / 10).toString().replace('.', ',')) + "</b></td>" +
                "</tr>";
        $("#table_keputusan tbody").html(table_string);
        $("#table_keputusan tfoot").html(footer_string);

        // Init Datatables with Tabletools Addon	
        table = $('#table_keputusan').DataTable({
            bDestroy: true,
            paging: false,
            searching: false,
            fixedHeader: true
        });
    }
    function update_table_scr_tur(scr,tur) {
        var nSCR = 1000;
        var nTUR = 1000;
        if (scr) {
            nSCR = 1;
        }
        if (scr) {
            nTUR = 1;
        }
        //console.log(nSCR);
        $("#table_keputusan").dataTable().fnDestroy();
        var table_string = "";
        var footer_string = "";
        var count = 0;
        var stok = 0;
        var transit = 0;
        var jml_truk = 0;
        var kapasitas = 0;
        var demand = 0;
        var leadtime = 0;
        var sisa_to = 0;
        //var dataBaris = new Array();
        //dataBaris = new Array();
        if (isRealValue(dataBaris)) {
            $.each(dataBaris, function (key, val) {

                //var stoklevel = (Math.round(((val.STOK / val.KAPASITAS) * 100) * 10) / 10).toString().replace('.', ',');
                if (parseFloat(val.SCR) < nSCR && parseFloat(val.TUR) < nTUR) {
                    count++;
                    table_string += "<tr>" +
                            //"<td class='details-control'></td>" +
                            "<td>" + count + "</td>" +
                            "<td>" + val.KD_GDG + "</td>" +
                            "<td>" + val.NM_DISTR + "</td>" +
                            "<td>" + val.NM_DISTRIK + "</td>" +
                            "<td>" + formatAngka(val.STOK) + "</td>" +
                            "<td>" + val.TRANSIT + "</td>" +
                            "<td>" + val.JML_TRUK + "</td>" +
                            "<td>" + formatAngka(val.KAPASITAS) + "</td>";
                    if (val.TOTAL_LEVEL_ONHAND <= 30) {
                        table_string += "<td class='font-merah'>" + val.TOTAL_LEVEL_ONHAND.toString().replace('.', ',') + " %</td>";
                    } else {
                        table_string += "<td>" + val.TOTAL_LEVEL_ONHAND.toString().replace('.', ',') + " %</td>";
                    }
                    table_string += "<td>" + val.DEMAND + "</td>" +
                            "<td>" + val.LEADTIME.toString().replace('.', ',') + "</td>" +
                            "<td>" + formatAngka(val.LOAD_TRUK) + "</td>" +
                            "<td>" + val.SDR.toString().replace('.', ',') + "</td>";
                    if (val.TUR < 1) {
                        table_string += "<td class='font-merah'>" + val.TUR.toString().replace('.', ',') + "</td>";
                    } else {
                        table_string += "<td>" + val.TUR.toString().replace('.', ',') + "</td>";
                    }
                    if (val.SCR < 1) {
                        table_string += "<td class='font-merah'>" + val.SCR.toString().replace('.', ',') + "</td>";
                    } else {
                        table_string += "<td>" + val.SCR.toString().replace('.', ',') + "</td>";
                    }
                    table_string += "<td>" + formatAngka(val.SISA_TO) + "</td>" +
                            "</tr>";
                    stok += parseInt(val.STOK);
                    transit += parseInt(val.TRANSIT);
                    jml_truk += parseInt(val.JML_TRUK);
                    kapasitas += parseInt(val.KAPASITAS);
                    demand += parseInt(val.DEMAND);
                    leadtime += parseFloat(val.LEADTIME);
                    sisa_to += parseFloat(val.SISA_TO);
                }
            });
        }
        var stockleveltotal = (Math.round((stok / kapasitas * 100) * 10) / 10).toString().replace('.', ',');
        footer_string += "<tr>" +
                "<td class='success' colspan='4' align='center'><b>TOTAL</b></td>" +
                "<td align='center'><b>" + formatAngka(stok) + "</b></td>" +
                "<td align='center'><b>" + formatAngka(transit) + "</b></td>" +
                "<td align='center'><b>" + jml_truk + "</b></td>" +
                "<td align='center'><b>" + formatAngka(kapasitas) + "</b></td>" +
                "<td align='center'><b>" + stockleveltotal + " %</b></td>" +
                "<td align='center'><b>" + formatAngka(demand) + "</b></td>" +
                "<td align='center'><b>" + (Math.round((leadtime) * 10) / 10).toString().replace('.', ',') + "</b></td>" +
                "<td align='center'><b>&nbsp;</b></td>" +
                "<td align='center'><b>&nbsp;</b></td>" +
                "<td align='center'><b>&nbsp;</b></td>" +
                "<td align='center'><b>&nbsp;</b></td>" +
                "<td align='center'><b>" + formatAngka((Math.round((sisa_to) * 10) / 10).toString().replace('.', ',')) + "</b></td>" +
                "</tr>";
        $("#table_keputusan tbody").html(table_string);
        $("#table_keputusan tfoot").html(footer_string);

        // Init Datatables with Tabletools Addon	
        table = $('#table_keputusan').DataTable({
            bDestroy: true,
            paging: false,
            searching: false,
            fixedHeader: true
        });
    }
    function get_pencapaian() {
        var url = base_url + 'smigroup/TabelKeputusan/getData';
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
    function get_kota() {
        var url = base_url + 'smigroup/TabelKeputusan/getKota';
        var isikota = '<option value="0">All Kota</option>';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                $.each(data, function (key, val) {
                    kota.push(val);
                    isikota += '<option value="' + val.KD_KOTA + '">' + val.NM_KOTA + '</option>';
                });
            },
            complete: function () {
                $('#kota').html(isikota);
            }
        });
    }
    function update_kota(prov) {
        var isikota = '<option value="0">All Kota</option>';
        $.each(kota, function (key, val) {
            if (prov == 0) {
                isikota += '<option value="' + val.KD_KOTA + '">' + val.NM_KOTA + '</option>';
            } else {
                if (val.KD_PROP == prov) {
                    isikota += '<option value="' + val.KD_KOTA + '">' + val.NM_KOTA + '</option>';
                }
            }
        });
        $('#kota').html(isikota);
    }
    $(function () {

        $('#loading_purple').hide();

        get_pencapaian();
        get_kota();
        $('.pilihan').change(function () {
            var prov = $('#provinsi').val();
            var opco = $('#opco').val();
            var cek30 = $("#cek30").is(":checked");
            var kota = $('#kota').val();
            var sdr = $('#sdr-maks').val();
            update_table(opco, prov, cek30, kota, sdr);
            $('.cekBox').prop('checked', false);
        });
        $('#provinsi').change(function () {
            var prov = $('#provinsi').val();
            update_kota(prov);
        });

//        $.fn.dataTable.ext.search.push(
//                function (settings, data, dataIndex) {
//                    //var tur = $("#cekTUR").is(":checked");
//                    var scr = $("#cekSCR").is(":checked");
//                    //var nTUR = parseFloat(data[14]) || 0; // use data for the age column
//                    var nSCR = parseFloat(data[14]) || 0; // use data for the age column
//                    console.log(scr);
//                    if(scr){                        
//                        if (nSCR < 1) {
//                            return true;
//                        } else {
//                            return false;
//                        }
//                    } else {
//                        return false;
//                    }
//                }
//        );

        $('.cekBox').click(function () {
            var cekSCR = $("#cekSCR").is(":checked");
            var cekTUR = $("#cekTUR").is(":checked");
            update_table_scr_tur(cekSCR,cekTUR);
        });
//        $('#table_keputusan tbody').on('click', 'td.details-control', function () {
//            var tr = $(this).closest('tr');
//            var row = table.row(tr);
//
//            if (row.child.isShown()) {
//
//                // This row is already open - close it
//                row.child.hide();
//
//                tr.removeClass('shown');
//            } else {
//                // Open this row
//                //console.log(row.data()[1]);
//                row.child(format(row.data()[2])).show();
//                tr.addClass('shown');
//            }
//        });

    });
</script>


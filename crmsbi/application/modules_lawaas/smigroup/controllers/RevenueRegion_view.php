<style type="text/css">
    img{
        width:90%;
        margin-left:4px;
    }
    #loading_purple {
        position:fixed;
        top:0;
        left:0;
        background:url('<?php echo base_url(); ?>assets/img/loading.gif')no-repeat center center;
        z-index:1;
        text-align:center;
        width:100%;
        height:100%;
        padding-top:70px;
        font:bold 50px Calibri,Arial,Sans-Serif;
        color:#000;
        display:none;
    }
    .table-demand{
        /*font-size: 11px;*/
        /*background: linear-gradient(to bottom right, red , white);  Standard syntax*/ 
        background-image: url("<?php echo base_url(); ?>assets/img/patternSI.png");
        background-position-x: -39px;
        background-position-y: 10px;
        background-size: 84%;
        background-repeat: no-repeat;
        /*background-color : rgba(76, 175, 80, 0.1);*/
        font-weight: bold;
        color: #333;
        border-radius: 10px;
        box-shadow: 1px 1px 1px #888888;
        line-height: 80%;
    }
    .foot-demand{
        line-height: 50%;
    }
    .table-demand tr td{
        padding: 5px;
    }
    .modal-dialog{
        width: 100%;
        height: 200%;
    }
    .font-merah{
        color: #ff4545;
    }
    .font-merah:hover{
        /*color:white;*/
    }
    .merah{
        border: 0.2vw solid #ff4545;
        background-color: rgba(255, 69, 69, 0.15);
        /*        background: linear-gradient(135deg, rgba(243,55,26,1) 0%,rgba(243,55,26,1) 50%,rgba(234,40,3,1) 51%,rgba(255,102,0,1) 75%,rgba(199,34,0,1) 100%);
                color: white;*/
    }
    .merah:hover{
        /*        background-color: #ff4545;*/
        background-color: rgba(255,69,69,0.5);
        color:#000;
    }
    .merah:hover .font-merah{
        /*background-color: #ff4545;*/
        /*background-color: rgba(255,69,69,0.5);*/
        color:white;
    }
    .kotak{
        float:left;
        width:1vw;
        height:1vw;
        border-radius: 3px;
        /*display: inline;*/
    }
    .font-kuning{
        color: rgb(255, 191, 0);;
        font-weight: bold;
    }
    .kuning{
        border: 0.2vw solid #fef536;
        background-color: rgba(254, 245, 54, 0.18);
        /*        background: linear-gradient(135deg, rgb(247, 229, 13) 50%,rgb(247, 229, 13) 50%,rgb(234, 206, 3) 51%,rgb(255, 247, 0) 75%,rgb(206, 199, 0) 100%);
                color: black;    */
    }    
    .kuning:hover{
        /*background-color: #fef536;*/
        background-color: rgba(254,245,54,0.5);
    }
    .kuning:hover .font-kuning{
        color: #000;
    }
    .biru{
        border: 0.2vw solid #5f62ff;
    }    
    .biru:hover{
        background-color: #5f62ff;
        color:white;
    }
    .font-hijau{
        color: #00a90c;
    }
    .infin{
        color: #00a90c;
        font-size: 1.5vw;
    }
    .hijau{
        border: 0.2vw solid #49ff56;
        background-color: rgba(73, 255, 86, 0.17);
        /*        background : linear-gradient(135deg, rgb(28, 199, 7) 0%,rgb(41, 222, 7) 50%,rgb(35, 167, 3) 51%,rgb(0, 255, 31) 75%,rgb(40, 136, 0) 100%);
                color: white;*/
    }    
    .hijau:hover{
        /*background-color: #49ff56;*/
        background-color: rgba(73,255,86,0.5);
        color: #000;
    }
    .hijau:hover .font-hijau{
        color: #000;
    }

    .hijautua{
        border: 0.2vw solid #1ab394;
        background-color: rgba(156, 204, 161, 0.55);
        /*        background : linear-gradient(135deg, rgb(28, 199, 7) 0%,rgb(41, 222, 7) 50%,rgb(35, 167, 3) 51%,rgb(0, 255, 31) 75%,rgb(40, 136, 0) 100%);
                color: white;*/
    }    
    .hijautua:hover{
        /*background-color: #49ff56;*/
        background-color: rgba(156, 204, 161, 0.55);
        color: #000;
    }
    .hijautua:hover .font-hijau{
        color: #000;
    }
    #pleasewait{
        display: none;
    }
    .legend{
        float:left;
        display:inline;
    }
    .box-legend{
        width:30px;
        height:15px;
        border: 0px solid;
        background-color: #49ff56;
        float:left;
    }
    .container{
        width: 103%;
        margin-left: -1.5%;
        font-size: 0.9vw;
    }
    .head-sales{
        background-color: #1ab394;
        color: white;
    }
    .bg-tlcc{
        background-color: #e5e5e5;
    }
    .border-bawah{
        border-bottom: 3px solid black;
    }
    .container{
        color:black;
    }
    .panel-heading{
        background: linear-gradient(to right, #1ab394, #036C13);
    }
    .header-kolom {
        background: linear-gradient(to left, #1ab394, #036C13);
        color: #fff;
    }
    .kotak-footer{
        width: 25%; 
        background-color: #e5e5e5;
        border-radius: 10px;
        /*background: linear-gradient(to left, #1ab394, #036C13);*/
    }
    .kotak-footer tr td{
        padding-right: 20px;
        padding-left: 20px;
        padding-bottom: 5px;
    }
    .abuabu {
        border: 0.2vw solid #888888;
        background-color: rgba(215, 214, 216, 0.39);
    }
    #tabel-rev tr td,#tabel-rev tr th {
        color: black;
    }
    #content-table{
        width: 70%;
        left: 15%;
        top: 5%;
    }
    th {
        text-align: center;
        vertical-align: middle;
    }

    .table-left-header{
        font-weight: bold;
    }
    .left-top{
        font-size: 15px;
        font-weight: bold;
        padding-bottom: 2px;
    }
    .title-red {
        color: #eb2424;
    }
    .title-green {
        color: #33bb28;
    }
</style>
<div id="loading_purple"></div>
<div class="container">
    <div class="row">
        <div class="modal fade" id="modal-chart">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header header-kolom">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">
                            <span id="modal-title"></span>&nbsp;&nbsp;| &nbsp;&nbsp;
                            <span id="lu-time">Last Update : <span id="lastupdateChart"></span></span>&nbsp;&nbsp;| &nbsp;&nbsp;
                            <span id="lu-adj">Last Adjustment : <span id="lastadjChart"></span></span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div id="pleasewait">Please Wait . . .</div>
                        <div class="row" id="grafik">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div id="pleasewait-growth-asi">Please Wait . . .</div>
                                    <div id="judul-growth-asi" style="text-align: center">
                                        <p><b>Growth By ASI</b></p>
                                        <label class="radio-inline"><input type="radio" name="optradio" value="mom">MoM</label>
                                        <label class="radio-inline"><input type="radio" name="optradio" value="yoy">YoY</label>
                                        <label class="radio-inline"><input type="radio" name="optradio" value="kumyoy">YoY Kumulatif</label> 
                                    </div>                                    
                                    <canvas id="Chart1" width="50%" height="200%"></canvas>
                                    <div style="margin-left: 20%;" id="legendDiv"></div><br/>
                                    <!-- <div style="text-align: center;" id="akurasi-prognose">Akurasi Prognose : <span id="akurasi"></span> %</div> -->
                                </div>
                                <div class="col-md-6">                                    
                                    <div id="judul-growth-sap" style="text-align: center">
                                        <p><b>Growth By SAP</b></p>
                                        <label class="radio-inline"><input type="radio" name="optradio2" value="mom">MoM</label>
                                        <label class="radio-inline"><input type="radio" name="optradio2" value="yoy">YoY</label>
                                        <label class="radio-inline"><input type="radio" name="optradio2" value="kumyoy">YoY Kumulatif</label> 
                                    </div> 
                                    <div id="pleasewait-growth-sap">Please Wait . . .</div>
                                    <canvas id="Chart2" width="100%" height="1000"></canvas>                                    
                                    <div style="margin-left: 20%;" id="legendDiv2"></div>
                                </div>
                            </div>    
                            <div id="produksigresik">
                                <div class="col-md-12">
                                    <div class="col-md-6">

                                        <canvas id="Chart3" width="50%" height="200%"></canvas>
                                        <div style="margin-left: 30%;" id="legendDiv3"></div><br/>
                                        <!-- <div style="text-align: center;" id="akurasi-prognose">Akurasi Prognose : <span id="akurasi"></span> %</div> -->
                                    </div>
                                    <div class="col-md-6">                                    

                                        <canvas id="Chart4" width="100%" height="1000"></canvas>                                    
                                        <div style="margin-left: 20%;" id="legendDiv4"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">

                                        <canvas id="Chart5" width="50%" height="200%"></canvas>
                                        <div style="margin-left: 30%;" id="legendDiv5"></div><br/>
                                        <!-- <div style="text-align: center;" id="akurasi-prognose">Akurasi Prognose : <span id="akurasi"></span> %</div> -->
                                    </div>
                                    <div class="col-md-6">                                    

                                        <canvas id="Chart6" width="100%" height="1000"></canvas>                                    
                                        <div style="margin-left: 20%;" id="legendDiv6"></div>
                                    </div>
                                </div>
                            </div><br/>
                        </div><br/>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="footer-vol">
                                    <table class="kotak-footer" align="center">
                                        <tr>
                                            <td><b>Prognose </b></td>
                                            <td align="center"><b>:</b></td>
                                            <td align="right"><b><span id="foot-prog">&nbsp;</span></b></td>
                                        </tr>
                                        <tr>
                                            <td><b>RKAP Bulan </b></td>
                                            <td align="center"><b>:</b></td>
                                            <td align="right"><b><span id="foot-rkap">&nbsp;</span></b></td>
                                        </tr>
                                        <tr>
                                            <td><b>% Prognose </b></td>
                                            <td align="center"><b>:</b></td>
                                            <td align="right"><b><span id="foot-persen">&nbsp;</span></b></td>
                                        </tr>

                                        <tr >
                                            <td><b>Rata2 Harian SDK </b></td>
                                            <td align="center"><b>:</b></td>
                                            <td align="right"><b><span id="foot-ave">&nbsp;</span></b></td>
                                        </tr>
                                        <tr class='sales-foot'>
                                            <td><b>Real Tahun Lalu </b></td>
                                            <td align="center"><b>:</b></td>
                                            <td align="right"><b><span id="foot-rtl">&nbsp;</span></b></td>
                                        </tr>
                                        <tr class='sales-foot'>
                                            <td><b>Penc. Tahun Lalu </b></td>
                                            <td align="center"><b>:</b></td>
                                            <td align="right"><b><span id="foot-ptl">&nbsp;</span></b></td>
                                        </tr>

                                    </table>               
                                </div> 
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="modal-footer">
                                                                   
                                        </div>-->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade" id="modal-table">
            <div class="modal-dialog">
                <div class="modal-content" id="content-table">
                    <div class="modal-header header-kolom">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">
                            <span id="modal-titletabel"></span>&nbsp;&nbsp;| &nbsp;&nbsp;
                            <span id="lu-timetabel">Last Update : <span id="lastupdatetabel"></span></span>&nbsp;&nbsp;| &nbsp;&nbsp;
                            <span id="lu-adjtabel">Last Adjustment : <span id="lastadjtabel"></span></span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div id="pleasewaittabel">Please Wait . . .</div>
                        <div class="row" id="table-view">
                            <div class="col-md-12">
                                <table class="table table-bordered" id="tabel-rev">
                                    <thead>
                                        <tr>
                                            <th valign="middle" rowspan="2" style="">&nbsp;</th>
                                            <th valign="middle" colspan="3" class="info">Domestik sdk (a)</th>
                                            <th valign="middle" colspan="3" class="success">ICS</th>
                                            <th valign="middle" colspan="3" class="danger">Ekspor</th>
                                            <th valign="middle" colspan="3" class="default">Total Domestik + Ekspor</th>

                                        </tr>
                                        <tr class='border-bawah'>
                                            <th valign="middle" class="info">Real</th>
                                            <th valign="middle" class="info">RKAP</th>
                                            <th valign="middle" class="info">%</th>
                                            <th valign="middle" class="success">Real</th>
                                            <th valign="middle" class="success">RKAP</th>
                                            <th valign="middle" class="success">%</th>
                                            <th valign="middle" class="danger">Real</th>
                                            <th valign="middle" class="danger">RKAP</th>
                                            <th valign="middle" class="danger">%</th>
                                            <th valign="middle" class="default">Real</th>
                                            <th valign="middle" class="default">RKAP</th>
                                            <th valign="middle" class="default">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- DATA WILL LOAD HERE -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="modal-footer">
                                                                   
                                        </div>-->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-line-chart"></i> Monitoring Revenue</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="margin-top:-6px">
                                <div class="col-md-5">
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
                                <div class="col-md-5">
                                    <select id="tahun" class="form-control" name="tahun">
                                        <?php
                                        for ($i = 2016; $i <= (Date('Y') + 1); $i++) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                        ?>    
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button id="update-btn" class="btn btn-default" style="margin-top:0px"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-md-3">
                            <div class="col-md-8" style="padding-right: 5px;padding-left: 5px;"><h3><i class="fa fa-calendar"></i>&nbsp;<b class="tgl"><?php echo $tanggal; ?></b></h3></div>

                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:5px">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-responsive table-condensed ">
                                <thead class="header-kolom">
                                    <tr class="border-bawah ">
                                        <th class="col-md-1" style='text-align: center;width:14%'></th>
                                        <?php
                                        foreach ($head as $row) {
                                            echo "<th style='text-align: center;width:17%'>$row</th>";
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="border-bawah">
                                        <td>
                                            <table width='100%' id="tabelProdTerakSG" style="border-radius: 4px" class="table-left-header">                                                        
                                                <tr><td class="left-top title-red">RKAP</td></tr>
                                                <tr><td>Region 1</td></tr>
                                                <tr><td>Region 2</td></tr>
                                                <tr><td>Region 3</td></tr> 
                                                <tr><td>Curah (Jawa Bali)</td></tr> 
                                            </table>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '7000', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelProdTerakSG" style="border-radius: 4px;">                                                        
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '7000', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelProdSemenSG" style="border-radius: 4px;">                                                        
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>                     
                                                    </table>
                                                </div>
                                            </a>
                                        </td>

                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '7000')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelStokTerakSG" style="border-radius: 4px;">
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '7000')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelStokSemenSG" style="border-radius: 4px;">
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('vol', '7000')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelSalesSG" style="border-radius: 4px;">                                                        
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <table width='100%' id="tabelProdTerakSG" style="border-radius: 4px" class="table-left-header">                                                        
                                                <tr><td class="left-top title-green">REALISASI</td></tr>
                                                <tr><td>Region 1</td></tr>
                                                <tr><td>Region 2</td></tr>
                                                <tr><td>Region 3</td></tr> 
                                                <tr><td>Curah (Jawa Bali)</td></tr> 
                                            </table>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '3000', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelProdTerakSP" style="border-radius: 4px;">                                                        
                                                         <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '3000', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelProdSemenSP" style="border-radius: 4px;">                                                        
                                                         <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>

                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '3000')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelStokTerakSP" style="border-radius: 4px;">
                                                       <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td><td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '3000')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelStokSemenSP" style="border-radius: 4px;">
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('vol', '3000')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelSalesSP" style="border-radius: 4px;">                                                        
                                                         <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>                                       
                                                    </table>
                                                </div>
                                            </a>
                                        </td>

                                    </tr>
                                    <tr >
                                        <td>
                                            <table width='100%' id="tabelProdTerakSG" style="border-radius: 4px" class="table-left-header">                                                        
                                                <tr><td class="left-top title-green">% REALISASI</td></tr>
                                                <tr><td>Region 1</td></tr>
                                                <tr><td>Region 2</td></tr>
                                                <tr><td>Region 3</td></tr> 
                                                <tr><td>Curah (Jawa Bali)</td></tr> 
                                            </table>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '4000', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelProdTerakST" style="border-radius: 4px;">                                                        
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '4000', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelProdSemenST" style="border-radius: 4px;">                                                        
                                                         <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>

                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '4000')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelStokTerakST" style="border-radius: 4px;">
                                                       <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td><td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '4000')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelStokSemenST" style="border-radius: 4px;">
                                                         <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('vol', '4000')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelSalesST" style="border-radius: 4px;">                                                        
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td >
                                            <table width='100%' id="tabelProdTerakSG" style="border-radius: 4px" class="table-left-header">                                                        
                                                <tr><td class="left-top title-green">SELISIH REALISASI</td></tr>
                                                <tr><td>Region 1</td></tr>
                                                <tr><td>Region 2</td></tr>
                                                <tr><td>Region 3</td></tr> 
                                                <tr><td>Curah (Jawa Bali)</td></tr> 
                                            </table>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '0', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelProdTerakSMIG" style="border-radius: 4px;">                                                        
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '0', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelProdSemenSMIG" style="border-radius: 4px;">                                                        
                                                       <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
<!--                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '0', '1')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelProdTerakSMIG">
                                                        <tr><td>Prognose</td><td align='right'><span id="persenProdTerakSMIG"></span> %</td></tr>
                                                        <tr><td>Vol. Prog</td><td align='right'><span id="volProgTerakSMIG"></span> </td></tr>
                                                        <tr><td>+/(-)</td><td align='right'><span id="deviasiProdTerakSMIG"></span> </td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '0', '1')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelProdSemenSMIG" style="border-radius: 4px;">
                                                        <tr><td>Prognose</td><td align='right'><span id="persenProdSemenSMIG"></span> %</td></tr>
                                                        <tr><td>Vol. Prog</td><td align='right'><span id="volProgSemenSMIG"></span> </td></tr>
                                                        <tr><td>+/(-)</td><td align='right'><span id="deviasiProdSemenSMIG"></span> </td></tr>                                                        
                                                    </table>
                                                </div>                                            
                                            </a>
                                        </td>-->
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '0')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelStokTerakSMIG" style="border-radius: 4px;">
                                                      <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '0')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelStokSemenSMIG" style="border-radius: 4px;">
                                                         <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('vol', '0')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelSalesSMIG" style="border-radius: 4px;">                                                        
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>
                                                        <tr><td>&nbsp;</td></tr>  
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>

                                    </tr>
                                </tbody>
                                <tfoot>
                                   
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="<?php echo base_url('assets/datepicker/datepicker3.css'); ?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/chartjs/dist/Chart.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/datepicker/bootstrap-datepicker.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
                                                function formatAngka(n) {
                                                    var num = parseInt(n);
                                                    return (num + '').replace(/(\d)(?=(\d{3})+$)/g, '$1.');
                                                }
                                                function formatWarnaGrowth(id, val) {
                                                    $('#' + id).removeClass();
                                                    if (val > 0) {
                                                        $('#' + id).addClass('font-hijau');
                                                    } else if (val < 0) {
                                                        $('#' + id).addClass('font-merah');
                                                    }
                                                }
                                                function formatWarnaSales(value) {
                                                    if (value <= 90) {
                                                        return 'merah';
                                                    } else if (value > 90 && value < 100) {
                                                        return 'kuning';
                                                    } else {
                                                        return 'hijau';
                                                    }
                                                }
                                                function formatWarnaPersenSales(value) {
                                                    if (value <= 90) {
                                                        return 'font-merah';
                                                    } else if (value > 90 && value < 100) {
                                                        return 'font-kuning';
                                                    } else {
                                                        return 'font-hijau';
                                                    }
                                                }
                                                function formatWarnaProd(value) {
                                                    if (value < 90) {
                                                        return 'merah';
                                                    } else if (value >= 90 && value < 100) {
                                                        return 'kuning';
                                                    } else {
                                                        return 'hijau';
                                                    }
                                                }
                                                function formatWarnaStok(value) {
                                                    if (value <= 50) {
                                                        return 'merah';
                                                    } else if (value > 50 && value < 80) {
//                                                        return 'hijau';
                                                        return 'kuning';
                                                    } else if (value >= 80 && value < 100) {
//                                                        return 'kuning';
                                                        return 'hijau';
                                                    } else if (value >= 100) {
                                                        return 'hijautua';
                                                    } else {
                                                        return 'merah';
                                                    }
                                                }
                                                var Chart1, Chart2;
                                                var ctx1 = document.getElementById("Chart1");
                                                var ctx2 = document.getElementById("Chart2");
                                                var ctx3 = document.getElementById("Chart3");
                                                var ctx4 = document.getElementById("Chart4");
                                                var ctx5 = document.getElementById("Chart5");
                                                var ctx6 = document.getElementById("Chart6");
                                                var d = new Date();
                                                var datamv;
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

                                                function openTip(oChart, pointIndex, jml) {
                                                    if (oChart.tooltip._active == undefined)
                                                        oChart.tooltip._active = []
                                                    var activeElements = oChart.tooltip._active;
                                                    var requestedElem = [];
                                                    for (var i = 0; i < jml; i++) {
                                                        requestedElem[i] = oChart.getDatasetMeta(i).data[pointIndex];
                                                    }
//                                                    var requestedElem = oChart.getDatasetMeta(0).data[pointIndex];
//                                                    var requestedElem1 = oChart.getDatasetMeta(1).data[pointIndex];
//                                                    if (jml == 3) {
//                                                        var requestedElem2 = oChart.getDatasetMeta(2).data[pointIndex];
//                                                    } else if (jml == 5) {
//                                                        var requestedElem2 = oChart.getDatasetMeta(2).data[pointIndex];
//                                                        var requestedElem3 = oChart.getDatasetMeta(3).data[pointIndex];
//                                                        var requestedElem4 = oChart.getDatasetMeta(4).data[pointIndex];
//                                                    }
                                                    for (var i = 0; i < activeElements.length; i++) {
                                                        if (requestedElem[i]._index == activeElements[i]._index)
                                                            return;
                                                    }
                                                    for (var i = 0; i < requestedElem.length; i++) {
                                                        activeElements.push(requestedElem[i]);
                                                    }

//                                                    activeElements.push(requestedElem);
//                                                    activeElements.push(requestedElem1);
//                                                    if (jml == 3) {
//                                                        activeElements.push(requestedElem2);
//                                                    } else if (jml == 5) {
//                                                        activeElements.push(requestedElem2);
//                                                        activeElements.push(requestedElem3);
//                                                        activeElements.push(requestedElem4);
//                                                    }

                                                    oChart.tooltip._active = activeElements;
                                                    oChart.tooltip.update(true);
                                                    oChart.draw();
                                                }

                                                function getProdTerakSemen(tanggal) {
                                                    var url = base_url + 'dashboard/Demandpl/getProdTerakSemen/' + tanggal;
                                                    $.ajax({
                                                        url: url,
                                                        type: 'post',
                                                        dataType: 'json',
                                                        beforeSend: function () {
                                                            //alert('asdasdv');
                                                        },
                                                        success: function (data) {
                                                            $('#persenProdTerakSMIG').html(Math.round(data['terakSMIG']['PERSEN']));
                                                            $('#persenProdTerakSG').html(Math.round(data['terakSG']['PERSEN']));
                                                            $('#persenProdTerakSP').html(Math.round(data['terakSP']['PERSEN']));
                                                            $('#persenProdTerakST').html(Math.round(data['terakST']['PERSEN']));
                                                            $('#persenProdTerakTLCC').html(Math.round(data['terakTLCC']['PERSEN']));
                                                            $('#deviasiProdTerakSMIG').html(formatAngka(Math.round(data['terakSMIG']['DEVIASI'])));
                                                            $('#deviasiProdTerakSG').html(formatAngka(Math.round(data['terakSG']['DEVIASI'])));
                                                            $('#deviasiProdTerakSP').html(formatAngka(Math.round(data['terakSP']['DEVIASI'])));
                                                            $('#deviasiProdTerakST').html(formatAngka(Math.round(data['terakST']['DEVIASI'])));
                                                            $('#deviasiProdTerakTLCC').html(formatAngka(Math.round(data['terakTLCC']['DEVIASI'])));
                                                            $('#tabelProdTerakSMIG').removeClass();
                                                            $('#tabelProdTerakSG').removeClass();
                                                            $('#tabelProdTerakSP').removeClass();
                                                            $('#tabelProdTerakST').removeClass();
                                                            $('#tabelProdTerakTLCC').removeClass();
                                                            $('#tabelProdTerakSMIG').addClass(formatWarnaProd(Math.round(data['terakSMIG']['PERSEN'])));
                                                            $('#tabelProdTerakSG').addClass(formatWarnaProd(Math.round(data['terakSG']['PERSEN'])));
                                                            $('#tabelProdTerakSP').addClass(formatWarnaProd(Math.round(data['terakSP']['PERSEN'])));
                                                            $('#tabelProdTerakST').addClass(formatWarnaProd(Math.round(data['terakST']['PERSEN'])));
                                                            $('#tabelProdTerakTLCC').addClass(formatWarnaProd(Math.round(data['terakTLCC']['PERSEN'])));
                                                            $('#persenProdSemenSMIG').html(Math.round(data['semenSMIG']['PERSEN']));
                                                            $('#persenProdSemenSG').html(Math.round(data['semenSG']['PERSEN']));
                                                            $('#persenProdSemenSP').html(Math.round(data['semenSP']['PERSEN']));
                                                            $('#persenProdSemenST').html(Math.round(data['semenST']['PERSEN']));
                                                            $('#persenProdSemenTLCC').html(Math.round(data['semenTLCC']['PERSEN']));
                                                            $('#deviasiProdSemenSMIG').html(formatAngka(Math.round(data['semenSMIG']['DEVIASI'])));
                                                            $('#deviasiProdSemenSG').html(formatAngka(Math.round(data['semenSG']['DEVIASI'])));
                                                            $('#deviasiProdSemenSP').html(formatAngka(Math.round(data['semenSP']['DEVIASI'])));
                                                            $('#deviasiProdSemenST').html(formatAngka(Math.round(data['semenST']['DEVIASI'])));
                                                            $('#deviasiProdSemenTLCC').html(formatAngka(Math.round(data['semenTLCC']['DEVIASI'])));
                                                            $('#tabelProdSemenSMIG').removeClass();
                                                            $('#tabelProdSemenSG').removeClass();
                                                            $('#tabelProdSemenSP').removeClass();
                                                            $('#tabelProdSemenST').removeClass();
                                                            $('#tabelProdSemenTLCC').removeClass();
                                                            $('#tabelProdSemenSMIG').addClass(formatWarnaProd(Math.round(data['semenSMIG']['PERSEN'])));
                                                            $('#tabelProdSemenSG').addClass(formatWarnaProd(Math.round(data['semenSG']['PERSEN'])));
                                                            $('#tabelProdSemenSP').addClass(formatWarnaProd(Math.round(data['semenSP']['PERSEN'])));
                                                            $('#tabelProdSemenST').addClass(formatWarnaProd(Math.round(data['semenST']['PERSEN'])));
                                                            $('#tabelProdSemenTLCC').addClass(formatWarnaProd(Math.round(data['semenTLCC']['PERSEN'])));
                                                            $('#volProgTerakSMIG').html(formatAngka(data['terakSMIG']['REALISASI']));
                                                            $('#volProgTerakSG').html(formatAngka(data['terakSG']['REALISASI']));
                                                            $('#volProgTerakSP').html(formatAngka(data['terakSP']['REALISASI']));
                                                            $('#volProgTerakST').html(formatAngka(data['terakST']['REALISASI']));
                                                            $('#volProgTerakTLCC').html(formatAngka(data['terakTLCC']['REALISASI']));
                                                            $('#volProgSemenSMIG').html(formatAngka(data['semenSMIG']['REALISASI']));
                                                            $('#volProgSemenSG').html(formatAngka(data['semenSG']['REALISASI']));
                                                            $('#volProgSemenSP').html(formatAngka(data['semenSP']['REALISASI']));
                                                            $('#volProgSemenST').html(formatAngka(data['semenST']['REALISASI']));
                                                            $('#volProgSemenTLCC').html(formatAngka(data['semenTLCC']['REALISASI']));
                                                            $('#targetProdTerakSMIG').html(formatAngka(data['terakSMIG']['RKAP_SD']));
                                                            $('#targetProdTerakSG').html(formatAngka(data['terakSG']['RKAP_SD']));
                                                            $('#targetProdTerakSP').html(formatAngka(data['terakSP']['RKAP_SD']));
                                                            $('#targetProdTerakST').html(formatAngka(data['terakST']['RKAP_SD']));
                                                            $('#targetProdTerakTLCC').html(formatAngka(data['terakTLCC']['RKAP_SD']));
                                                            $('#targetProdSemenSMIG').html(formatAngka(data['semenSMIG']['RKAP_SD']));
                                                            $('#targetProdSemenSG').html(formatAngka(data['semenSG']['RKAP_SD']));
                                                            $('#targetProdSemenSP').html(formatAngka(data['semenSP']['RKAP_SD']));
                                                            $('#targetProdSemenST').html(formatAngka(data['semenST']['RKAP_SD']));
                                                            $('#targetProdSemenTLCC').html(formatAngka(data['semenTLCC']['RKAP_SD']));
                                                        }
                                                    });
                                                }
                                                function getStokTerakSemenMax() {
                                                    var url = base_url + 'dashboard/Demandpl/getStokTerakSemenMax/' + tanggal;
                                                    $.ajax({
                                                        url: url,
                                                        type: 'post',
                                                        dataType: 'json',
                                                        beforeSend: function () {
                                                            //alert('asdasdv');
                                                        },
                                                        success: function (data) {
                                                            $('#persenStokTerakSMIG').html(Math.round(data['terakSMIG']['PERSEN']));
                                                            $('#persenStokTerakSG').html(Math.round(data['terakSG']['PERSEN']));
                                                            $('#persenStokTerakSP').html(Math.round(data['terakSP']['PERSEN']));
                                                            $('#persenStokTerakST').html(Math.round(data['terakST']['PERSEN']));
                                                            $('#persenStokTerakTLCC').html(Math.round(data['terakTLCC']['PERSEN']));
                                                            $('#maxStokTerakSMIG').html(formatAngka(data['terakSMIG']['MAX_STOK']));
                                                            $('#maxStokTerakSG').html(formatAngka(data['terakSG']['MAX_STOK']))
                                                            $('#maxStokTerakSP').html(formatAngka(data['terakSP']['MAX_STOK']))
                                                            $('#maxStokTerakST').html(formatAngka(data['terakST']['MAX_STOK']))
                                                            $('#maxStokTerakTLCC').html(formatAngka(data['terakTLCC']['MAX_STOK']))
                                                            $('#deviasiStokTerakSMIG').html(formatAngka(Math.round((data['terakSMIG']['REALISASI']).toString().replace(',', '.'))));
                                                            $('#deviasiStokTerakSG').html(formatAngka(Math.round((data['terakSG']['REALISASI']).replace(',', '.'))));
                                                            $('#deviasiStokTerakSP').html(formatAngka(Math.round((data['terakSP']['REALISASI']).replace(',', '.'))));
                                                            $('#deviasiStokTerakST').html(formatAngka(Math.round((data['terakST']['REALISASI']).replace(',', '.'))));
                                                            $('#deviasiStokTerakTLCC').html(formatAngka(Math.round((data['terakTLCC']['REALISASI']).replace(',', '.'))));
                                                            $('#tabelStokTerakSMIG').addClass(formatWarnaStok(Math.round(data['terakSMIG']['PERSEN'])));
                                                            $('#tabelStokTerakSG').addClass(formatWarnaStok(Math.round(data['terakSG']['PERSEN'])));
                                                            $('#tabelStokTerakSP').addClass(formatWarnaStok(Math.round(data['terakSP']['PERSEN'])));
                                                            $('#tabelStokTerakST').addClass(formatWarnaStok(Math.round(data['terakST']['PERSEN'])));
                                                            $('#tabelStokTerakTLCC').addClass(formatWarnaStok(Math.round(data['terakTLCC']['PERSEN'])));
                                                            $('#lastdateStokTerakSG').html(data['terakSG']['MAX_DATE']);
                                                            $('#lastdateStokTerakSP').html(data['terakSP']['MAX_DATE']);
                                                            $('#lastdateStokTerakST').html(data['terakST']['MAX_DATE']);
                                                            $('#lastdateStokTerakTLCC').html(data['terakTLCC']['MAX_DATE']);
                                                            $('#persenStokSemenSMIG').html(Math.round(data['semenSMIG']['PERSEN']));
                                                            $('#persenStokSemenSG').html(Math.round(data['semenSG']['PERSEN']));
                                                            $('#persenStokSemenSP').html(Math.round(data['semenSP']['PERSEN']));
                                                            $('#persenStokSemenST').html(Math.round(data['semenST']['PERSEN']));
                                                            $('#persenStokSemenTLCC').html(Math.round(data['semenTLCC']['PERSEN']));
                                                            $('#maxStokSemenSMIG').html(formatAngka(data['semenSMIG']['MAX_STOK']));
                                                            $('#maxStokSemenSG').html(formatAngka(data['semenSG']['MAX_STOK']))
                                                            $('#maxStokSemenSP').html(formatAngka(data['semenSP']['MAX_STOK']))
                                                            $('#maxStokSemenST').html(formatAngka(data['semenST']['MAX_STOK']))
                                                            $('#maxStokSemenTLCC').html(formatAngka(data['semenTLCC']['MAX_STOK']))
                                                            $('#deviasiStokSemenSMIG').html(formatAngka(Math.round((data['semenSMIG']['REALISASI']).toString().replace(',', '.'))));
                                                            $('#deviasiStokSemenSG').html(formatAngka(Math.round((data['semenSG']['REALISASI']).replace(',', '.'))));
                                                            $('#deviasiStokSemenSP').html(formatAngka(Math.round((data['semenSP']['REALISASI']).replace(',', '.'))));
                                                            $('#deviasiStokSemenST').html(formatAngka(Math.round((data['semenST']['REALISASI']).replace(',', '.'))));
                                                            $('#deviasiStokSemenTLCC').html(formatAngka(Math.round((data['semenTLCC']['REALISASI']).replace(',', '.'))));
                                                            $('#tabelStokSemenSMIG').addClass(formatWarnaStok(Math.round(data['semenSMIG']['PERSEN'])));
                                                            $('#tabelStokSemenSG').addClass(formatWarnaStok(Math.round(data['semenSG']['PERSEN'])));
                                                            $('#tabelStokSemenSP').addClass(formatWarnaStok(Math.round(data['semenSP']['PERSEN'])));
                                                            $('#tabelStokSemenST').addClass(formatWarnaStok(Math.round(data['semenST']['PERSEN'])));
                                                            $('#tabelStokSemenTLCC').addClass(formatWarnaStok(Math.round(data['semenTLCC']['PERSEN'])));
                                                            $('#lastdateStokSemenSG').html(data['semenSG']['MAX_DATE']);
                                                            $('#lastdateStokSemenSP').html(data['semenSP']['MAX_DATE']);
                                                            $('#lastdateStokSemenST').html(data['semenST']['MAX_DATE']);
                                                            $('#lastdateStokSemenTLCC').html(data['semenTLCC']['MAX_DATE']);
                                                        }
                                                    });
                                                }
                                                function getStokTerakSemen(date) {
                                                    var url = base_url + 'dashboard/Demandpl/getStokTerakSemen/' + date;
                                                    $.ajax({
                                                        url: url,
                                                        type: 'post',
                                                        dataType: 'json',
                                                        beforeSend: function () {
                                                            //alert('asdasdv');
                                                        },
                                                        success: function (data) {
                                                            $('#persenStokTerakSMIG').html(Math.round(data['terakSMIG']['PERSEN']));
                                                            $('#persenStokTerakSG').html(Math.round(data['terakSG']['PERSEN']));
                                                            $('#persenStokTerakSP').html(Math.round(data['terakSP']['PERSEN']));
                                                            $('#persenStokTerakST').html(Math.round(data['terakST']['PERSEN']));
                                                            $('#persenStokTerakTLCC').html(Math.round(data['terakTLCC']['PERSEN']));
                                                            $('#maxStokTerakSMIG').html(formatAngka(data['terakSMIG']['MAX_STOK']));
                                                            $('#maxStokTerakSG').html(formatAngka(data['terakSG']['MAX_STOK']))
                                                            $('#maxStokTerakSP').html(formatAngka(data['terakSP']['MAX_STOK']))
                                                            $('#maxStokTerakST').html(formatAngka(data['terakST']['MAX_STOK']))
                                                            $('#maxStokTerakTLCC').html(formatAngka(data['terakTLCC']['MAX_STOK']))
                                                            $('#deviasiStokTerakSMIG').html(formatAngka(Math.round((data['terakSMIG']['REALISASI']).toString().replace(',', '.'))));
                                                            $('#deviasiStokTerakSG').html(formatAngka(Math.round((data['terakSG']['REALISASI']).replace(',', '.'))));
                                                            $('#deviasiStokTerakSP').html(formatAngka(Math.round((data['terakSP']['REALISASI']).replace(',', '.'))));
                                                            $('#deviasiStokTerakST').html(formatAngka(Math.round((data['terakST']['REALISASI']).replace(',', '.'))));
                                                            $('#deviasiStokTerakTLCC').html(formatAngka(Math.round((data['terakTLCC']['REALISASI']).replace(',', '.'))));
                                                            $('#tabelStokTerakSMIG').removeClass();
                                                            $('#tabelStokTerakSG').removeClass();
                                                            $('#tabelStokTerakSP').removeClass();
                                                            $('#tabelStokTerakST').removeClass();
                                                            $('#tabelStokTerakTLCC').removeClass();
                                                            $('#tabelStokTerakSMIG').addClass(formatWarnaStok(Math.round(data['terakSMIG']['PERSEN'])));
                                                            $('#tabelStokTerakSG').addClass(formatWarnaStok(Math.round(data['terakSG']['PERSEN'])));
                                                            $('#tabelStokTerakSP').addClass(formatWarnaStok(Math.round(data['terakSP']['PERSEN'])));
                                                            $('#tabelStokTerakST').addClass(formatWarnaStok(Math.round(data['terakST']['PERSEN'])));
                                                            $('#tabelStokTerakTLCC').addClass(formatWarnaStok(Math.round(data['terakTLCC']['PERSEN'])));
                                                            $('#persenStokSemenSMIG').html(Math.round(data['semenSMIG']['PERSEN']));
                                                            $('#persenStokSemenSG').html(Math.round(data['semenSG']['PERSEN']));
                                                            $('#persenStokSemenSP').html(Math.round(data['semenSP']['PERSEN']));
                                                            $('#persenStokSemenST').html(Math.round(data['semenST']['PERSEN']));
                                                            $('#persenStokSemenTLCC').html(Math.round(data['semenTLCC']['PERSEN']));
                                                            $('#maxStokSemenSMIG').html(formatAngka(data['semenSMIG']['MAX_STOK']));
                                                            $('#maxStokSemenSG').html(formatAngka(data['semenSG']['MAX_STOK']))
                                                            $('#maxStokSemenSP').html(formatAngka(data['semenSP']['MAX_STOK']))
                                                            $('#maxStokSemenST').html(formatAngka(data['semenST']['MAX_STOK']))
                                                            $('#maxStokSemenTLCC').html(formatAngka(data['semenTLCC']['MAX_STOK']))
                                                            $('#deviasiStokSemenSMIG').html(formatAngka(Math.round((data['semenSMIG']['REALISASI']).toString().replace(',', '.'))));
                                                            $('#deviasiStokSemenSG').html(formatAngka(Math.round((data['semenSG']['REALISASI']).replace(',', '.'))));
                                                            $('#deviasiStokSemenSP').html(formatAngka(Math.round((data['semenSP']['REALISASI']).replace(',', '.'))));
                                                            $('#deviasiStokSemenST').html(formatAngka(Math.round((data['semenST']['REALISASI']).replace(',', '.'))));
                                                            $('#deviasiStokSemenTLCC').html(formatAngka(Math.round((data['semenTLCC']['REALISASI']).replace(',', '.'))));
                                                            $('#tabelStokSemenSMIG').removeClass();
                                                            $('#tabelStokSemenSG').removeClass();
                                                            $('#tabelStokSemenSP').removeClass();
                                                            $('#tabelStokSemenST').removeClass();
                                                            $('#tabelStokSemenTLCC').removeClass();
                                                            $('#tabelStokSemenSMIG').addClass(formatWarnaStok(Math.round(data['semenSMIG']['PERSEN'])));
                                                            $('#tabelStokSemenSG').addClass(formatWarnaStok(Math.round(data['semenSG']['PERSEN'])));
                                                            $('#tabelStokSemenSP').addClass(formatWarnaStok(Math.round(data['semenSP']['PERSEN'])));
                                                            $('#tabelStokSemenST').addClass(formatWarnaStok(Math.round(data['semenST']['PERSEN'])));
                                                            $('#tabelStokSemenTLCC').addClass(formatWarnaStok(Math.round(data['semenTLCC']['PERSEN'])));
                                                        }
                                                    });
                                                }
                                                function getSales(opco, tanggal) {
                                                    var op;
                                                    if (opco == '2000') {
                                                        op = 'SMIG';
                                                        var url = base_url + 'dashboard/Demandpl/getSalesSMI/' + tanggal + '/' + datamv;
                                                    } else {
                                                        if (opco == '7000') {
                                                            op = 'SG';
                                                        } else if (opco == '3000') {
                                                            op = 'SP';
                                                        } else if (opco == '4000') {
                                                            op = 'ST';
                                                        } else if (opco == '6000') {
                                                            op = 'TLCC';
                                                        }
                                                        var url = base_url + 'dashboard/Demandpl/getSalesOpco/' + opco + '/' + tanggal + '/' + datamv;
                                                    }

                                                    $.ajax({
                                                        url: url,
                                                        dataType: 'json',
                                                        beforeSend: function () {
                                                            $('#loading_purple').show();
                                                        },
                                                        success: function (data) {
                                                            $('#persenSales' + op).html(data['PERSEN']);
                                                            $('#deviasiSales' + op).html(formatAngka(data['DEVIASI']));
                                                            $('#realSales' + op).html(formatAngka(data['REAL_SDK']));
                                                            $('#targetSales' + op).html(formatAngka(data['RKAP_SDK']));
//                $('#realSales'+op).removeClass();
//                $('#realSales'+op).addClass(formatWarnaPersenSales(data['PERSEN']));
//                $('#targetSales'+op).removeClass();
//                $('#targetSales'+op).addClass(formatWarnaPersenSales(data['PERSEN']));
                                                            $('#tabelSales' + op).removeClass();
                                                            $('#tabelSales' + op).addClass(formatWarnaSales(data['PERSEN']));
                                                            var realEkspor = parseFloat(data['REAL_SM_EKSPOR']) + parseFloat(data['REAL_TR_EKSPOR']);
                                                            var realTotal = realEkspor + data['REAL_SDK'];
                                                            $('#totalSalesDomestik' + op).html(formatAngka(data['REAL_SDK']) + ' (' + data['PERSEN'] + '%)');
                                                            $('#totalSalesEkspor' + op).html(formatAngka(realEkspor) + ' (' + data['PERSEN_EKSPOR'] + '%)');
                                                            $('#totalSalesIcs' + op).html(formatAngka(data['REAL_ICS']) + ' (' + data['PERSEN_ICS'] + '%)');
                                                            $('#totalSales' + op).html(formatAngka(realTotal) + ' (' + data['PERSEN_TOTAL'] + '%)');
                                                            $('#totalSalesDomestik' + op).removeClass();
                                                            $('#totalSalesEkspor' + op).removeClass();
                                                            $('#totalSalesIcs' + op).removeClass();
                                                            $('#totalSalesDomestik' + op).addClass(formatWarnaPersenSales(data['PERSEN']));
                                                            $('#totalSalesEkspor' + op).addClass(formatWarnaPersenSales(data['PERSEN_EKSPOR']));
                                                            $('#totalSalesIcs' + op).addClass(formatWarnaPersenSales(data['PERSEN_ICS']));
//                $('#totalSales'+op).html(formatAngka(realTotal));
//                $('#targetSalesEkspor'+op).html(formatAngka(data['RKAP_EKSPOR']));
//                $('#realSalesEksporSm'+op).html(formatAngka(data['REAL_SM_EKSPOR']));
//                $('#realSalesEksporTr'+op).html(formatAngka(data['REAL_TR_EKSPOR']));
//                $('#persenSalesEkspor'+op).html(data['PERSEN_EKSPOR']);
//                $('#tabelSalesEkspor'+op).removeClass();
//                $('#tabelSalesEkspor'+op).addClass(formatWarnaSales(data['PERSEN_EKSPOR']));
                                                            if (opco == 2000) {
                                                                $("#lastupadate_mv").html('Last Update ' + data['LAST_REFRESH']['LAST_REFRESH_DATE']);
                                                                var realEksporSMITLCC = parseFloat(data['SMITLCC_REAL_SM_EKSPOR']) + parseFloat(data['SMITLCC_REAL_TR_EKSPOR']);
                                                                var realTotalSMITLCC = realEksporSMITLCC + data['SMITLCC_REAL_SDK'];
                                                                $('#totalSalesDomestik' + op + 'TLCC').html(formatAngka(data['SMITLCC_REAL_SDK']) + ' (' + data['SMITLCC_PERSEN'] + '%)');
                                                                $('#totalSalesEkspor' + op + 'TLCC').html(formatAngka(realEksporSMITLCC) + ' (' + data['SMITLCC_PERSEN_EKSPOR'] + '%)');
                                                                $('#totalSales' + op + 'TLCC').html(formatAngka(realTotalSMITLCC) + ' (' + data['SMITLCC_PERSEN_TOTAL'] + '%)');
                                                                $('#totalSalesDomestik' + op + 'TLCC').removeClass();
                                                                $('#totalSalesEkspor' + op + 'TLCC').removeClass();
                                                                $('#totalSalesDomestik' + op + 'TLCC').addClass(formatWarnaPersenSales(data['SMITLCC_PERSEN']));
                                                                $('#totalSalesEkspor' + op + 'TLCC').addClass(formatWarnaPersenSales(data['SMITLCC_PERSEN_EKSPOR']));

                                                                $('#persenSales' + op + 'TLCC').html(data['SMITLCC_PERSEN']);
                                                                $('#deviasiSales' + op + 'TLCC').html(formatAngka(data['SMITLCC_DEVIASI']));
                                                                $('#realSales' + op + 'TLCC').html(formatAngka(data['SMITLCC_REAL_SDK']));
                                                                $('#targetSales' + op + 'TLCC').html(formatAngka(data['SMITLCC_RKAP_SDK']));
                                                                $('#tabelSales' + op + 'TLCC').addClass(formatWarnaSales(data['SMITLCC_PERSEN']));
                                                            }

                                                            /* GROWTH */
                                                            $('#growthDomestik' + op).html(data['GROWTH_DOM_REAL'] + '%');
                                                            $('#growthDomestik' + op + 'kum').html(data['GROWTH_DOM_PROG'] + '%');
                                                            formatWarnaGrowth('growthDomestik' + op, data['GROWTH_DOM_REAL']);
                                                            formatWarnaGrowth('growthDomestik' + op + 'kum', data['GROWTH_DOM_PROG']);
                                                            $('#growthEkspor' + op).html(data['GROWTH_EKSPOR'] + '%');
                                                            formatWarnaGrowth('growthEkspor' + op, data['GROWTH_EKSPOR']);
                                                            $('#totalGrowth' + op).html(data['GROWTH_TOTAL'] + '%');
                                                            formatWarnaGrowth('totalGrowth' + op, data['GROWTH_TOTAL']);

                                                            $('#loading_purple').hide();
                                                        }
                                                    });
                                                }

                                                function growthSMIG() {
                                                    var growthDomestik = Math.round((((realisasiSMIG - realisasiSMIGtl) / realisasiSMIGtl) * 100) * 10) / 10;
                                                    var growthDomestikKum = Math.round(((((realisasiSMIG + prognoseSMIG) - realisasiSMIGtlkum) / realisasiSMIGtlkum) * 100) * 10) / 10;
                                                    var growthEkspor = Math.round((((realeksporSMIG - realeksporSMIGtl) / realeksporSMIGtl) * 100) * 10) / 10;
                                                    $('#growthDomestikSMIG').html(growthDomestik + '%');
                                                    $('#growthDomestikSMIGkum').html(growthDomestikKum + '%');
                                                    $('#growthEksporSMIG').html(growthEkspor + '%');
                                                    formatWarnaGrowth('growthDomestikSMIG', growthDomestik);
                                                    formatWarnaGrowth('growthDomestikSMIGkum', growthDomestikKum);
                                                    formatWarnaGrowth('growthEksporSMIG', growthEkspor);
                                                    var realTahunIni = realisasiSMIG + realeksporSMIG;
                                                    var realTahunLalu = realisasiSMIGtl + realeksporSMIGtl;
                                                    var totalGrowth = Math.round((((realTahunIni - realTahunLalu) / realTahunLalu) * 100) * 10) / 10;
                                                    $('#totalGrowthSMIG').html(totalGrowth + '%');
                                                    formatWarnaGrowth('totalGrowthSMIG', totalGrowth);
//        console.log('Realisasi SMIG : '+realisasiSMIG);
//        console.log('Realisasi SMIG TL : '+realisasiSMIGtl);
//        console.log('Ekspor SMIG : '+realeksporSMIG);
//        console.log('Ekspor SMIG TL : '+realeksporSMIGtl);
                                                }
                                                function setChart() {
                                                    var lineChartData = {
                                                        labels: ['TANGGAL'],
                                                        datasets: [{
                                                                label: "RKAP",
                                                                data: [0],
                                                                fill: false,
                                                                lineTension: 0,
                                                                borderColor: '#98210f',
                                                                backgroundColor: '#98210f'
                                                            }, {
                                                                label: "REALISASI",
                                                                data: [0],
                                                                fill: false,
                                                                lineTension: 0,
                                                                borderColor: 'green',
                                                                backgroundColor: 'green'
                                                            }]
                                                    };
                                                    var lineChartData2 = {
                                                        labels: ['TANGGAL'],
                                                        datasets: [{
                                                                label: "RKAP",
                                                                data: [0],
                                                                fill: false,
                                                                lineTension: 0,
                                                                borderColor: '#98210f',
                                                                backgroundColor: '#98210f'
                                                            }, {
                                                                label: "REALISASI",
                                                                data: [0],
                                                                fill: false,
                                                                lineTension: 0,
                                                                borderColor: 'green',
                                                                backgroundColor: 'green'
                                                            }]
                                                    };

                                                    var lineChartData3 = {
                                                        labels: ['TANGGAL'],
                                                        datasets: [{
                                                                label: "RKAP",
                                                                data: [0],
                                                                fill: false,
                                                                lineTension: 0,
                                                                borderColor: '#98210f',
                                                                backgroundColor: '#98210f'
                                                            }, {
                                                                label: "REALISASI",
                                                                data: [0],
                                                                fill: false,
                                                                lineTension: 0,
                                                                borderColor: 'green',
                                                                backgroundColor: 'green'
                                                            }]
                                                    };
                                                    var lineChartData4 = {
                                                        labels: ['TANGGAL'],
                                                        datasets: [{
                                                                label: "RKAP",
                                                                data: [0],
                                                                fill: false,
                                                                lineTension: 0,
                                                                borderColor: '#98210f',
                                                                backgroundColor: '#98210f'
                                                            }, {
                                                                label: "REALISASI",
                                                                data: [0],
                                                                fill: false,
                                                                lineTension: 0,
                                                                borderColor: 'green',
                                                                backgroundColor: 'green'
                                                            }]
                                                    };

                                                    var lineChartData5 = {
                                                        labels: ['TANGGAL'],
                                                        datasets: [{
                                                                label: "RKAP",
                                                                data: [0],
                                                                fill: false,
                                                                lineTension: 0,
                                                                borderColor: '#98210f',
                                                                backgroundColor: '#98210f'
                                                            }, {
                                                                label: "REALISASI",
                                                                data: [0],
                                                                fill: false,
                                                                lineTension: 0,
                                                                borderColor: 'green',
                                                                backgroundColor: 'green'
                                                            }]
                                                    };
                                                    var lineChartData6 = {
                                                        labels: ['TANGGAL'],
                                                        datasets: [{
                                                                label: "RKAP",
                                                                data: [0],
                                                                fill: false,
                                                                lineTension: 0,
                                                                borderColor: '#98210f',
                                                                backgroundColor: '#98210f'
                                                            }, {
                                                                label: "REALISASI",
                                                                data: [0],
                                                                fill: false,
                                                                lineTension: 0,
                                                                borderColor: 'green',
                                                                backgroundColor: 'green'
                                                            }]
                                                    };

                                                    Chart1 = new Chart(ctx1, {
                                                        type: 'line',
                                                        data: lineChartData,
                                                        options: {
                                                            title: {
                                                                display: true,
                                                                text: "Grafik Target Dan Realisasi"
                                                            },
                                                            scales: {
                                                                yAxes: [{
                                                                        ticks: {
                                                                            beginAtZero: true
                                                                        }
                                                                    }]
                                                            }
                                                        }
                                                    });

                                                    Chart2 = new Chart(ctx2, {
                                                        type: 'line',
                                                        data: lineChartData2,
                                                        options: {
                                                            title: {
                                                                display: true,
                                                                text: "Grafik Target Dan Realisasi"
                                                            },
                                                            scales: {
                                                                yAxes: [{
                                                                        ticks: {
                                                                            beginAtZero: true
                                                                        }
                                                                    }]
                                                            }
                                                        }
                                                    });

                                                    Chart3 = new Chart(ctx3, {
                                                        type: 'line',
                                                        data: lineChartData3,
                                                        options: {
                                                            title: {
                                                                display: true,
                                                                text: "Grafik Target Dan Realisasi"
                                                            },
                                                            scales: {
                                                                yAxes: [{
                                                                        ticks: {
                                                                            beginAtZero: true
                                                                        }
                                                                    }]
                                                            }
                                                        }
                                                    });
                                                    Chart4 = new Chart(ctx4, {
                                                        type: 'line',
                                                        data: lineChartData4,
                                                        options: {
                                                            title: {
                                                                display: true,
                                                                text: "Grafik Target Dan Realisasi"
                                                            },
                                                            scales: {
                                                                yAxes: [{
                                                                        ticks: {
                                                                            beginAtZero: true
                                                                        }
                                                                    }]
                                                            }
                                                        }
                                                    });
                                                    Chart5 = new Chart(ctx5, {
                                                        type: 'line',
                                                        data: lineChartData5,
                                                        options: {
                                                            title: {
                                                                display: true,
                                                                text: "Grafik Target Dan Realisasi"
                                                            },
                                                            scales: {
                                                                yAxes: [{
                                                                        ticks: {
                                                                            beginAtZero: true
                                                                        }
                                                                    }]
                                                            }
                                                        }
                                                    });
                                                    Chart6 = new Chart(ctx6, {
                                                        type: 'line',
                                                        data: lineChartData6,
                                                        options: {
                                                            title: {
                                                                display: true,
                                                                text: "Grafik Target Dan Realisasi"
                                                            },
                                                            scales: {
                                                                yAxes: [{
                                                                        ticks: {
                                                                            beginAtZero: true
                                                                        }
                                                                    }]
                                                            }
                                                        }
                                                    });
                                                }
                                                function getUpdateTime() {
                                                    var url = base_url + 'dashboard/Demandpl/getLastUpdate';
                                                    $.ajax({
                                                        url: url,
                                                        type: 'post',
                                                        dataType: 'json',
                                                        success: function (data) {
                                                            $('#lastupdate').html(data['TANGGAL']);

                                                        }
                                                    });
                                                }
                                                $(function () {
                                                    var tahun = d.getUTCFullYear();
                                                    var bulan = d.getUTCMonth() + 1;
                                                    datamv = $('#datatbl').val();
                                                    bulan = bulan.toString().length < 2 ? '0' + bulan : bulan;
                                                    var day = d.getUTCDate();
                                                    var hari;
                                                    hari = day.toString().length < 2 ? '0' + day : day;
                                                    $('#tahun').val(tahun);
                                                    $('#bulan').val(bulan);
                                                    setChart();
                                                    tanggal = $('#tahun').val() + '' + $('#bulan').val();
                                                    var date = $('#tahun').val() + '' + $('#bulan').val() + '' + hari;
//                                                    getStokTerakSemenMax();
//                                                    getProdTerakSemen(tanggal);
//                                                    getSales('7000', tanggal, datamv);
//                                                    getSales('3000', tanggal, datamv);
//                                                    getSales('4000', tanggal, datamv);
//                                                    getSales('6000', tanggal, datamv);
//                                                    getSales('2000', tanggal, datamv);
                                                    $('#update-btn').click(function () {
                                                        datamv = $('#datatbl').val();
                                                        tanggal = $('#tahun').val() + '' + $('#bulan').val();
                                                        var arrHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu'];
                                                        var arrBulan = ['Januari', 'Februai', 'Maret', 'April', 'Mei', "Juni", 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                                        // var tgl = tahun + '' + bulan;
                                                        var tgl = tahun + '' + bulan;
                                                        if (tanggal == tgl) {
                                                            $('.tgl').html("<?= $tanggal ?>");
                                                            getStokTerakSemenMax();
                                                        } else {
                                                            var dt = new Date($('#tahun').val(), $('#bulan').val(), 0);
                                                            $('.tgl').html(arrHari[dt.getDay()] + ', ' + dt.getDate() + ' ' + arrBulan[dt.getMonth()] + ' ' + dt.getUTCFullYear());
                                                            getStokTerakSemen(tanggal);
                                                        }
                                                        getProdTerakSemen(tanggal);
                                                        getSales('7000', tanggal, datamv);
                                                        getSales('3000', tanggal, datamv);
                                                        getSales('4000', tanggal, datamv);
                                                        getSales('6000', tanggal, datamv);
                                                        getSales('2000', tanggal, datamv);
                                                    });

                                                    $("#refresh_btn").click(function () {
                                                        var url = base_url + 'dashboard/Demandpl/refresh_data';
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
                                                    var horizonalLinePlugin = {
                                                        afterDraw: function (chartInstance) {
                                                            var yScale = chartInstance.scales["y-axis-0"];
                                                            var canvas = chartInstance.chart;
                                                            var ctx = canvas.ctx;
                                                            var index;
                                                            var line;
                                                            var style;

                                                            if (chartInstance.options.horizontalLine) {
                                                                for (index = 0; index < chartInstance.options.horizontalLine.length; index++) {
                                                                    line = chartInstance.options.horizontalLine[index];

                                                                    if (!line.style) {
                                                                        style = "rgba(169,169,169, 1)";
                                                                    } else {
                                                                        style = line.style;
                                                                    }

                                                                    if (line.y) {
                                                                        yValue = yScale.getPixelForValue(line.y);
                                                                    } else {
                                                                        yValue = 0;
                                                                    }

                                                                    ctx.lineWidth = 3;

                                                                    if (yValue) {
                                                                        ctx.beginPath();
                                                                        ctx.moveTo(80, yValue);
                                                                        ctx.lineTo(canvas.width, yValue);
                                                                        ctx.strokeStyle = style;
                                                                        ctx.stroke();
                                                                    }

                                                                    if (line.text) {
                                                                        ctx.fillStyle = style;
                                                                        ctx.fillText(line.text, 0, yValue + ctx.lineWidth);
                                                                    }
                                                                }
                                                                return;
                                                            }
                                                            ;
                                                        }
                                                    };
                                                    Chart.pluginService.register(horizonalLinePlugin);
                                                });
</script>
<script type="text/javascript">
    function test(kd_perusahaan) {
        var url = base_url + 'dashboard/Demandpl/coba';
        $.ajax({
            url: url,
            type: 'post',
            data: {
                "kd_perusahaan": kd_perusahaan
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
            }
        });
    }
    function getValueUsingClass() {
        /* declare an checkbox array */
        var chkArray = [];

        /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
        $(".chk-perusahaan:checked").each(function () {
            chkArray.push($(this).val());
        });

        return chkArray;
    }
    var lineChartData;
    var lineChartData2;
    var kode_perusahaan;
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });
        $('.chk-perusahaan').change(function () {
            chartGrowth(getValueUsingClass());
        });
        $("input[value='kumyoy']").prop('checked', true);
        $("input[name='optradio']").click(function () {
            var tipe = $("input[name='optradio']:checked").val();
            var url = base_url + 'dashboard/Demandpl/getChartGrowth/' + tanggal + '/' + kode_perusahaan;
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "type": tipe
                },
                dataType: 'json',
                success: function (datas) {
                    lineChartData.datasets = datas['growth'];
                    Chart1.update();
                    //console.log(tipe);
                }
            });
        });
        $("input[name='optradio2']").click(function () {
            var tipe = $("input[name='optradio2']:checked").val();
            var url = base_url + 'dashboard/Demandpl/getChartGrowthSAP/' + tanggal;
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "type": tipe
                },
                dataType: 'json',
                beforeSend: function () {
                    $("#pleasewait-growth-sap").show();
                    $("#Chart2").hide();
                },
                success: function (datas) {
                    $("#pleasewait-growth-sap").hide();
                    $("#Chart2").show();
                    lineChartData2.datasets = datas['growth'];
                    Chart2.update();
                }
            });
        });
        var title = "Growth &rArr; Growth bulan ini s.d tanggal sekarang terhadap bulan s.d tanggal yang sama di tahun sebelumnya / Growth prognose bulan ini s.d akhir bulan terhadap realisasi bulan yang sama tahun sebelumnya";
        $('.growth').tooltip({title: title, html: true, placement: 'left'});
    });
</script>
<script>
    function getGrowthSAP() {
        $("#lu-time").hide();
        $("#modal-title").html("Grafik Growth Market Share");
        $("input[value='kumyoy']").prop('checked', true);
        //var tanggal = ($('#tanggal').val()).substr(6, 9) + '' + ($('#tanggal').val()).substr(3, 2);
        var url = base_url + 'dashboard/Demandpl/getChartGrowthSAP/' + tanggal;
        $.ajax({
            url: url,
            type: 'post',
            data: {
                "type": "kumyoy"
            },
            dataType: 'json',
            beforeSend: function () {
                $("#modal-chart").modal('show');
                $("#pleasewait-growth-sap").show();
                $("#grafik").show();
                $('#judul-growth-sap').hide();
                //$(".chk-perusahaan").prop('checked',false);
                Chart2.destroy();
            },
            success: function (datas) {
                $("#pleasewait-growth-sap").hide();
                $('#judul-growth-sap').show();
                lineChartData2 = {
                    labels: datas['labels'],
                    datasets: datas['growth']
                };

                Chart2 = new Chart(ctx2, {
                    type: 'line',
                    data: lineChartData2,
                    options: {
                        title: {
                            display: false,
                            text: 'Growth by Data SAP'
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + tooltipItem.yLabel + ' %';
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    stacked: true,
                                    ticks: {
                                        fontSize: 11
                                    }
                                }],
                            yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: '%'
                                    },
                                    ticks: {
                                        suggestedMin: 0,
                                        callback: function (value, index, values) {
                                            return formatAngka(value);
                                        }
                                    }
                                }]
                        },
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                fontSize: 10,
                                boxWidth: 10
                            }
                        }
                    }
                });
            }
        });
    }
    function getGrowthASI(kd_perusahaan) {
        $("input[value='kumyoy']").prop('checked', true);
        kode_perusahaan = kd_perusahaan;
        //var tanggal = ($('#tanggal').val()).substr(6, 9) + '' + ($('#tanggal').val()).substr(3, 2);
        var url = base_url + 'dashboard/Demandpl/getChartGrowth/' + tanggal + '/' + kd_perusahaan;
        $.ajax({
            url: url,
            type: 'post',
            data: {
                "type": "kumyoy"
            },
            dataType: 'json',
            beforeSend: function () {
                $("#modal-chart").modal('show');
                $("#pleasewait-growth-asi").show();
                $("#grafik").show();
                $('#judul-growth-asi').hide();
                //$(".chk-perusahaan").prop('checked',false);
                Chart1.destroy();
            },
            success: function (datas) {
                //$("#lastupdateChart").html(datas['tanggal']);
                //$('#pilih-perusahaan').show();
                $("#pleasewait-growth-asi").hide();
                $('#judul-growth-asi').show();
                lineChartData = {
                    labels: datas['labels'],
                    datasets: datas['growth']
                };

                var lineChartData2 = {
                    labels: datas['labels'],
                    datasets: datas['growth']
                };


                Chart1 = new Chart.Line(ctx1, {
                    data: lineChartData,
                    options: {
                        title: {
                            display: false,
                            text: 'Growth by ASI'
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + tooltipItem.yLabel + ' %';
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    stacked: true,
                                    ticks: {
                                        fontSize: 11
                                    }
                                }],
                            yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: '%'
                                    },
                                    ticks: {
                                        suggestedMin: 0,
                                        callback: function (value, index, values) {
                                            return formatAngka(value);
                                        }
                                    }
                                }]
                        },
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                fontSize: 10,
                                boxWidth: 10
                            }
                        }
                    }
                });
                $("#grafik").show();
            }
        });
    }
    function chartGrowth(kd_perusahaan) {
        $("#pleasewait").hide();
        $('#legendDiv').hide();
        $('#legendDiv2').hide();
        $('#akurasi-prognose').hide();
        $('.judul-growth').hide();
        getGrowthASI(kd_perusahaan);
        getGrowthSAP();
    }
    function iniChart(type, org, prod = 0) {

        Chart1.destroy();
        Chart2.destroy();
        Chart3.destroy();
        Chart4.destroy();
        Chart5.destroy();
        Chart6.destroy();
        $("#lu-time").show();
        var judul, judulChart1, judulChart2;
        if (type === 'terak') {
            if (org == '7000')
                $('#produksigresik').css('display', 'block');
            judul = 'Produksi dan Stok Terak ';
            judulChart1 = 'Produksi Terak ';
            if (prod == 1) {
                judulChart2 = 'Akumulasi Produksi Terak ';
            } else {
                judulChart2 = 'Stok Terak ';
            }
        } else if (type === 'semen')
        {
            if (org == '7000')
                $('#produksigresik').css('display', 'block');
            judul = 'Produksi dan Stok Semen ';
            judulChart1 = 'Produksi Semen ';
            if (prod == 1) {
                judulChart2 = 'Akumulasi Produksi Semen ';
            } else {
                judulChart2 = 'Stok Semen ';
            }
        } else {
            $('#produksigresik').css('display', 'none');
            judul = 'Realisasi Penjualan Domestik ';
            judulChart1 = 'Sales ';
            judulChart2 = 'Akumulasi Sales ';
        }
        if (org === '0') {
            judul += 'PT. Semen Indonesia';
            judulChart1 += 'PT. Semen Indonesia ';
            judulChart2 += 'PT. Semen Indonesia ';
        } else if (org === '7000') {
            judul += 'PT. Semen Gresik';
            judulChart1 += 'PT. Semen Gresik ';
            judulChart2 += 'PT. Semen Gresik ';
        } else if (org === '3000') {
            judul += 'Semen Padang';
            judulChart1 += 'PT. Semen Padang ';
            judulChart2 += 'PT. Semen Padang ';
        } else if (org === '4000') {
            judul += 'Semen Tonasa';
            judulChart1 += 'PT. Semen Tonasa ';
            judulChart2 += 'PT. Semen Tonasa ';
        } else if (org === '6000') {
            judul += 'Thang Long Cement';
            judulChart1 += 'Thang Long Cement ';
            judulChart2 += 'Thang Long Cement ';
        }

        if (type == 'vol') {
            judulChart1 += 'Domestik';
            judulChart2 += 'Domestik';
        }
        $('.judul-growth').hide();
        $('#judul-growth-asi').hide();
        $('#judul-growth-sap').hide();
        $('#modal-title').text(judul);
        datamv = $('#datatbl').val();
        //var tanggal = ($('#tanggal').val()).substr(6, 9) + '' + ($('#tanggal').val()).substr(3, 2);
        var url = base_url + 'dashboard/Demandpl/getChart/' + tanggal + '/' + type + '/' + org + '/' + datamv;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $("#modal-chart").modal('show');
                $("#pleasewait").show();
                $("#pleasewait-growth-sap").hide();
                $("#pleasewait-growth-asi").hide();
                $("#grafik").hide();
                $("#table-view").hide();
                $('#pilih-perusahaan').hide();
                if (org == 4000) {
                    $("#lu-adj").show();
                } else {
                    $("#lu-adj").hide();
                }
                if (type == 'vol' || prod == 1) {
                    $("#footer-vol").show();
                } else {
                    $("#footer-vol").hide();
                }
            },
            success: function (datas) {
                $('#akurasi-prognose').show();
                $('#legendDiv').show();
                $('#legendDiv2').show();
                if (type != 'vol' && org == '7000') {
                    $("#lastupdateChart").html(datas['TOTAL']['tanggal']);
                } else {
                    $("#lastupdateChart").html(datas['tanggal']);
                }
                if (org == 4000) {
                    $("#lastadjChart").html(datas['tgl_adj']);
                }
                if (type == 'vol' && org == '7000' && prod == '0') {
                    var lineChartData = {
                        labels: datas['data']['TANGGAL'],
                        datasets: [{
                                type: "line",
                                label: "RKAP",
                                data: datas['data']['TARGET'],
                                fill: false,
                                lineTension: 0,
                                borderColor: '#98210f',
                                backgroundColor: '#98210f'
                            }, {
                                label: "REAL 5000",
                                data: datas['data']['REAL5000'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgba(193, 113, 38, 1)',
                                backgroundColor: 'rgba(193, 113, 38, 1)'
                            }, {
                                label: "REAL 7000",
                                data: datas['data']['REAL'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgb(226, 134, 49)',
                                backgroundColor: 'rgb(226, 134, 49)'
                            },
                            {
                                label: "REAL TOTAL",
                                data: datas['data']['REALTOTAL'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgba(255, 165, 0, 1)',
                                backgroundColor: 'rgba(255, 165, 0, 1)'
                            }, {
                                label: "PROGNOSE",
                                data: datas['data']['PROG'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.6)'
                            }]
                    };
                } else if ((type === 'terak' && org == '7000') || (type === 'semen' && org == '7000')) {
                    var lineChartData = {
                        labels: datas['TOTAL']['data']['TANGGAL'],
                        datasets: [{
                                type: "line",
                                label: "RKAP",
                                data: datas['TOTAL']['data']['TARGET'],
                                fill: false,
                                lineTension: 0,
                                borderColor: '#98210f',
                                backgroundColor: '#98210f'
                            }, {
                                label: "REALISASI",
                                data: datas['TOTAL']['data']['REAL'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgba(255, 165, 0, 1)',
                                backgroundColor: 'rgba(255, 165, 0, 1)'
                            }, {
                                label: "PROGNOSE",
                                data: datas['TOTAL']['data']['PROG'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.6)'
                            }]
                    };

                    var lineChartData3 = {
                        labels: datas['7000']['data']['TANGGAL'],
                        datasets: [{
                                type: "line",
                                label: "RKAP",
                                data: datas['7000']['data']['TARGET'],
                                fill: false,
                                lineTension: 0,
                                borderColor: '#98210f',
                                backgroundColor: '#98210f'
                            }, {
                                label: "REALISASI",
                                data: datas['7000']['data']['REAL'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgba(255, 165, 0, 1)',
                                backgroundColor: 'rgba(255, 165, 0, 1)'
                            }, {
                                label: "PROGNOSE",
                                data: datas['7000']['data']['PROG'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.6)'
                            }]
                    };

                    var lineChartData5 = {
                        labels: datas['5000']['data']['TANGGAL'],
                        datasets: [{
                                type: "line",
                                label: "RKAP",
                                data: datas['5000']['data']['TARGET'],
                                fill: false,
                                lineTension: 0,
                                borderColor: '#98210f',
                                backgroundColor: '#98210f'
                            }, {
                                label: "REALISASI",
                                data: datas['5000']['data']['REAL'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgba(255, 165, 0, 1)',
                                backgroundColor: 'rgba(255, 165, 0, 1)'
                            }, {
                                label: "PROGNOSE",
                                data: datas['5000']['data']['PROG'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.6)'
                            }]
                    };

                } else {
                    console.log('Oke2');
                    var lineChartData = {
                        labels: datas['data']['TANGGAL'],
                        datasets: [{
                                type: "line",
                                label: "RKAP",
                                data: datas['data']['TARGET'],
                                fill: false,
                                lineTension: 0,
                                borderColor: '#98210f',
                                backgroundColor: '#98210f'
                            }, {
                                label: "REALISASI",
                                data: datas['data']['REAL'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgba(255, 165, 0, 1)',
                                backgroundColor: 'rgba(255, 165, 0, 1)'
                            }, {
                                label: "PROGNOSE",
                                data: datas['data']['PROG'],
                                fillColor: 'green',
                                borderWidth: 1.5,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.6)'
                            }]
                    };

                }
                if (type == 'vol' && org == '7000' && prod == '0') {
                    var lineChartData2 = {
                        labels: datas['data']['TANGGAL'],
                        datasets: [{
                                label: "RKAP",
                                data: datas['akumulasi']['TARGET'],
                                fill: false,
                                lineTension: 0,
                                borderColor: '#98210f',
                                backgroundColor: '#98210f'
                            }, {
                                label: "REAL 5000",
                                data: datas['akumulasi']['REAL5000'],
                                fill: false,
                                lineTension: 0,
                                borderColor: 'rgba(193, 113, 38, 1)',
                                backgroundColor: 'rgba(193, 113, 38, 1)'
                            }, {
                                label: "REAL 7000",
                                data: datas['akumulasi']['REAL7000'],
                                fill: false,
                                lineTension: 0,
                                borderColor: 'rgb(226, 134, 49)',
                                backgroundColor: 'rgb(226, 134, 49)'
                            }, {
                                label: "REAL TOTAL",
                                data: datas['akumulasi']['REAL'],
                                fill: false,
                                lineTension: 0,
                                pointRadius: datas['data']['RADIUS'],
                                pointBorderColor: datas['data']['WARNA'],
                                pointBackgroundColor: datas['data']['WARNA'],
                                borderColor: 'rgba(255, 165, 0, 1)',
                                backgroundColor: 'rgba(255, 165, 0, 1)'
                            }]
                    };
                } else if (type == 'vol') {
                    var lineChartData2 = {
                        labels: datas['data']['TANGGAL'],
                        datasets: [{
                                label: "RKAP",
                                data: datas['akumulasi']['TARGET'],
                                fill: false,
                                lineTension: 0,
                                borderColor: '#98210f',
                                backgroundColor: '#98210f'
                            }, {
                                label: "REALISASI",
                                data: datas['akumulasi']['REAL'],
                                fill: false,
                                lineTension: 0,
                                pointRadius: datas['data']['RADIUS'],
                                pointBorderColor: datas['data']['WARNA'],
                                pointBackgroundColor: datas['data']['WARNA'],
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 1)'
                            }]
                    };
                } else if ((type == 'terak' && org == '7000') || (type == 'semen' && org == '7000')) {
                    if (prod == 1) {
                        var lineChartData2 = {
                            labels: datas['TOTAL']['data']['TANGGAL'],
                            datasets: [{
                                    label: "RKAP",
                                    data: datas['TOTAL']['data']['TARGET_KUM'],
                                    fill: false,
                                    lineTension: 0,
                                    borderColor: '#98210f',
                                    backgroundColor: '#98210f'
                                }, {
                                    label: "REALISASI",
                                    data: datas['TOTAL']['data']['REAL_KUM'],
                                    fill: false,
                                    lineTension: 0,
                                    pointRadius: datas['TOTAL']['data']['RADIUS'],
                                    pointBorderColor: datas['TOTAL']['data']['WARNA'],
                                    pointBackgroundColor: datas['TOTAL']['data']['WARNA'],
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 1)'
                                }]
                        };

                        var lineChartData4 = {
                            labels: datas['7000']['data']['TANGGAL'],
                            datasets: [{
                                    label: "RKAP",
                                    data: datas['7000']['data']['TARGET_KUM'],
                                    fill: false,
                                    lineTension: 0,
                                    borderColor: '#98210f',
                                    backgroundColor: '#98210f'
                                }, {
                                    label: "REALISASI",
                                    data: datas['7000']['data']['REAL_KUM'],
                                    fill: false,
                                    lineTension: 0,
                                    pointRadius: datas['7000']['data']['RADIUS'],
                                    pointBorderColor: datas['7000']['data']['WARNA'],
                                    pointBackgroundColor: datas['7000']['data']['WARNA'],
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 1)'
                                }]
                        };

                        var lineChartData6 = {
                            labels: datas['5000']['data']['TANGGAL'],
                            datasets: [{
                                    label: "RKAP",
                                    data: datas['5000']['data']['TARGET_KUM'],
                                    fill: false,
                                    lineTension: 0,
                                    borderColor: '#98210f',
                                    backgroundColor: '#98210f'
                                }, {
                                    label: "REALISASI",
                                    data: datas['5000']['data']['REAL_KUM'],
                                    fill: false,
                                    lineTension: 0,
                                    pointRadius: datas['5000']['data']['RADIUS'],
                                    pointBorderColor: datas['5000']['data']['WARNA'],
                                    pointBackgroundColor: datas['5000']['data']['WARNA'],
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 1)'
                                }]
                        };
                    } else {
                        var lineChartData2 = {
                            labels: datas['TOTAL']['data']['TANGGAL'],
                            datasets: [{
                                    label: "PROG",
                                    data: datas['TOTAL']['stok']['PROG'],
                                    fill: false,
                                    lineTension: 0,
                                    pointRadius: datas['TOTAL']['data']['RADIUS'],
                                    pointBorderColor: datas['TOTAL']['data']['WARNA'],
                                    pointBackgroundColor: datas['TOTAL']['data']['WARNA'],
                                    borderColor: '#98210f',
                                    backgroundColor: '#98210f'
                                }, {
                                    label: "100% CAP",
                                    data: datas['TOTAL']['stok']['MAX'],
                                    fill: false,
                                    lineTension: 0,
                                    borderColor: 'green',
                                    backgroundColor: 'green'
                                }, {
                                    label: "50% CAP",
                                    data: datas['TOTAL']['stok']['TIGAPULUHPERSEN'],
                                    fill: false,
                                    lineTension: 0,
                                    borderColor: 'red',
                                    backgroundColor: 'red'
                                }]
                        };

                        var lineChartData4 = {
                            labels: datas['7000']['data']['TANGGAL'],
                            datasets: [{
                                    label: "PROG",
                                    data: datas['7000']['stok']['PROG'],
                                    fill: false,
                                    lineTension: 0,
                                    pointRadius: datas['7000']['data']['RADIUS'],
                                    pointBorderColor: datas['7000']['data']['WARNA'],
                                    pointBackgroundColor: datas['7000']['data']['WARNA'],
                                    borderColor: '#98210f',
                                    backgroundColor: '#98210f'
                                }, {
                                    label: "100% CAP",
                                    data: datas['7000']['stok']['MAX'],
                                    fill: false,
                                    lineTension: 0,
                                    borderColor: 'green',
                                    backgroundColor: 'green'
                                }, {
                                    label: "50% CAP",
                                    data: datas['7000']['stok']['TIGAPULUHPERSEN'],
                                    fill: false,
                                    lineTension: 0,
                                    borderColor: 'red',
                                    backgroundColor: 'red'
                                }]
                        };

                        var lineChartData6 = {
                            labels: datas['5000']['data']['TANGGAL'],
                            datasets: [{
                                    label: "PROG",
                                    data: datas['5000']['stok']['PROG'],
                                    fill: false,
                                    lineTension: 0,
                                    pointRadius: datas['5000']['data']['RADIUS'],
                                    pointBorderColor: datas['5000']['data']['WARNA'],
                                    pointBackgroundColor: datas['5000']['data']['WARNA'],
                                    borderColor: '#98210f',
                                    backgroundColor: '#98210f'
                                }, {
                                    label: "100% CAP",
                                    data: datas['5000']['stok']['MAX'],
                                    fill: false,
                                    lineTension: 0,
                                    borderColor: 'green',
                                    backgroundColor: 'green'
                                }, {
                                    label: "50% CAP",
                                    data: datas['5000']['stok']['TIGAPULUHPERSEN'],
                                    fill: false,
                                    lineTension: 0,
                                    borderColor: 'red',
                                    backgroundColor: 'red'
                                }]
                        };
                    }
                } else {
                    if (prod == 1) {
                        var lineChartData2 = {
                            labels: datas['data']['TANGGAL'],
                            datasets: [{
                                    label: "RKAP",
                                    data: datas['data']['TARGET_KUM'],
                                    fill: false,
                                    lineTension: 0,
                                    borderColor: '#98210f',
                                    backgroundColor: '#98210f'
                                }, {
                                    label: "REALISASI",
                                    data: datas['data']['REAL_KUM'],
                                    fill: false,
                                    lineTension: 0,
                                    pointRadius: datas['data']['RADIUS'],
                                    pointBorderColor: datas['data']['WARNA'],
                                    pointBackgroundColor: datas['data']['WARNA'],
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 1)'
                                }]
                        };
                    } else {
                        var lineChartData2 = {
                            labels: datas['data']['TANGGAL'],
                            datasets: [{
                                    label: "PROG",
                                    data: datas['stok']['PROG'],
                                    fill: false,
                                    lineTension: 0,
                                    pointRadius: datas['data']['RADIUS'],
                                    pointBorderColor: datas['data']['WARNA'],
                                    pointBackgroundColor: datas['data']['WARNA'],
                                    borderColor: '#98210f',
                                    backgroundColor: '#98210f'
                                }, {
                                    label: "100% CAP",
                                    data: datas['stok']['MAX'],
                                    fill: false,
                                    lineTension: 0,
                                    borderColor: 'green',
                                    backgroundColor: 'green'
                                }, {
                                    label: "50% CAP",
                                    data: datas['stok']['TIGAPULUHPERSEN'],
                                    fill: false,
                                    lineTension: 0,
                                    borderColor: 'red',
                                    backgroundColor: 'red'
                                }]
                        };
                    }
                }


                Chart1 = new Chart.Bar(ctx1, {
                    data: lineChartData,
                    options: {
                        title: {
                            display: true,
                            text: judulChart1
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {

                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    stacked: true,
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
                                            return formatAngka(value);
                                        }
                                    }
                                }]
                        },
                        legend: {
                            display: false
                        }
                    }
                });

                if ((type == 'terak' && org == '7000') || (type == 'semen' && org == '7000')) {
                    Chart3 = new Chart.Bar(ctx3, {
                        data: lineChartData3,
                        options: {
                            title: {
                                display: true,
                                text: judulChart1 + ' (7000)'
                            },
                            tooltips: {
                                mode: 'label',
                                callbacks: {
                                    label: function (tooltipItem, data) {

                                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                        return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                                    }
                                }
                            },
                            scales: {
                                xAxes: [{
                                        stacked: true,
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
                                                return formatAngka(value);
                                            }
                                        }
                                    }]
                            },
                            legend: {
                                display: false
                            }
                        }
                    });

                    Chart4 = new Chart(ctx4, {
                        type: 'line',
                        data: lineChartData4,
                        options: {
                            title: {
                                display: true,
                                text: judulChart2 + ' (7000)'
                            },
                            tooltips: {
                                mode: 'label',
                                callbacks: {
                                    label: function (tooltipItem, data) {
                                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';

                                        return ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';

                                    }
                                }
                            },
                            scales: {
                                xAxes: [{
                                        stacked: true,
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
                                                return formatAngka(value);
                                            }
                                        }
                                    }]
                            },
                            animation: {
                                onComplete: function () {
                                    if (prod == 1) {
                                        var chartInstance = this.chart;
                                        var ctx = chartInstance.ctx;
                                        ctx.textAlign = "right";

                                        Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                            var meta = chartInstance.controller.getDatasetMeta(i);
                                            Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                                //console.log(i);

                                                if (index === dataset.data.length - 1 && i === 1) {
                                                    ctx.fillText(datas['7000']['akurasi']['PROGNOSE'] + ' Ton', bar._model.x, bar._model.y - 20);
                                                }

                                            }), this);
                                        }), this);
                                    }
                                }
                            },

                            legend: {
                                display: false
                            },
                            "horizontalLine": [{
                                    "y": -1,
                                    "style": "rgba(255, 0, 0, .4)"
                                }]
                        }
                    });


                    Chart5 = new Chart.Bar(ctx5, {
                        data: lineChartData5,
                        options: {
                            title: {
                                display: true,
                                text: judulChart1 + ' Rembang (5000)'
                            },
                            tooltips: {
                                mode: 'label',
                                callbacks: {
                                    label: function (tooltipItem, data) {

                                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                        return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                                    }
                                }
                            },
                            scales: {
                                xAxes: [{
                                        stacked: true,
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
                                                return formatAngka(value);
                                            }
                                        }
                                    }]
                            },
                            legend: {
                                display: false
                            }
                        }
                    });

                    Chart6 = new Chart(ctx6, {
                        type: 'line',
                        data: lineChartData6,
                        options: {
                            title: {
                                display: true,
                                text: judulChart2 + ' (5000)'
                            },
                            tooltips: {
                                mode: 'label',
                                callbacks: {
                                    label: function (tooltipItem, data) {
                                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                        return ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';

                                    }
                                }
                            },
                            scales: {
                                xAxes: [{
                                        stacked: true,
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
                                                return formatAngka(value);
                                            }
                                        }
                                    }]
                            },
                            animation: {
                                onComplete: function () {
                                    if (prod == 1) {
                                        var chartInstance = this.chart;
                                        var ctx = chartInstance.ctx;
                                        ctx.textAlign = "right";

                                        Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                            var meta = chartInstance.controller.getDatasetMeta(i);
                                            Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                                //console.log(i);
                                                if (index === dataset.data.length - 1 && i === 1) {
                                                    ctx.fillText(datas['5000']['akurasi']['PROGNOSE'] + ' Ton', bar._model.x, bar._model.y - 20);
                                                }
                                            }), this);
                                        }), this);
                                    }
                                }
                            },

                            legend: {
                                display: false
                            },
                            "horizontalLine": [{
                                    "y": -1,
                                    "style": "rgba(255, 0, 0, .4)"
                                }]
                        }
                    });
                }

                if (type == 'vol' && org == '7000' && prod == '0') {
                    var text = "<div class='legend'><div class='box-legend' style='background-color:#98210f;'> </div>&nbsp;RKAP&nbsp;&nbsp;&nbsp;</div>" +
                            "<div class='legend'><div class='box-legend' style='background-color:rgba(193, 113, 38, 1);'> </div>&nbsp;REAL 5000&nbsp;&nbsp;&nbsp;</div>" +
                            "<div class='legend'><div class='box-legend' style='background-color:rgb(226, 134, 49);'> </div>&nbsp;REAL 7000&nbsp;&nbsp;&nbsp;</div>" +
                            "<div class='legend'><div class='box-legend' style='background-color:rgba(255, 165, 0, 1);'> </div>&nbsp;REAL TOTAL&nbsp;&nbsp;&nbsp;</div>" +
                            "<div class='legend'><div class='box-legend' style='background-color:rgba(75, 192, 192, 0.6);'> </div>&nbsp;PROGNOSE&nbsp;&nbsp;&nbsp;</div>";
                } else {
                    var text = "<div class='legend'><div class='box-legend' style='background-color:#98210f;'> </div>&nbsp;RKAP&nbsp;&nbsp;&nbsp;</div>" +
                            "<div class='legend'><div class='box-legend' style='background-color:rgba(255, 165, 0, 1);'> </div>&nbsp;REALISASI&nbsp;&nbsp;&nbsp;</div>" +
                            "<div class='legend'><div class='box-legend' style='background-color:rgba(75, 192, 192, 0.6);'> </div>&nbsp;PROGNOSE&nbsp;&nbsp;&nbsp;</div>";
                }
                $('#legendDiv').html(text);

//                $('#akurasi').html(datas['akurasi']);

                Chart2 = new Chart(ctx2, {
                    type: 'line',
                    data: lineChartData2,
                    options: {
                        title: {
                            display: true,
                            text: judulChart2
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    if (type == 'vol' && org == '7000' && prod == '0') {
                                        if (tooltipItem.datasetIndex == 3 && data.datasets[3].pointBackgroundColor[parseInt(tooltipItem.xLabel) - 1] == "rgba(75, 192, 192, 1)") {
                                            return 'PROGNOSE' + ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                                        } else {
                                            return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                                        }
                                    } else if (type == 'vol') {
                                        return ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                                    } else {
                                        return ' : ' + formatAngka(tooltipItem.yLabel) + ' TON';
                                    }
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    stacked: true,
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
                                            return formatAngka(value);
                                        }
                                    }
                                }]
                        },
                        animation: {
                            onComplete: function () {
                                if (type === 'vol') {
                                    var chartInstance = this.chart;
                                    var ctx = chartInstance.ctx;
                                    ctx.textAlign = "right";

                                    Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                        var meta = chartInstance.controller.getDatasetMeta(i);
                                        Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                            //console.log(i);
                                            if (index === dataset.data.length - 1 && i === 1) {
                                                ctx.fillText(formatAngka(dataset.data[index]) + ' Ton', bar._model.x, bar._model.y - 20);
                                            }
                                        }), this);
                                    }), this);
                                } else if (prod == 1) {
                                    var chartInstance = this.chart;
                                    var ctx = chartInstance.ctx;
                                    ctx.textAlign = "right";

                                    Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                        var meta = chartInstance.controller.getDatasetMeta(i);
                                        Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                            //console.log(i);
                                            if (org == '7000' && type != 'vol') {
                                                if (index === dataset.data.length - 1 && i === 1) {
                                                    ctx.fillText(datas['TOTAL']['akurasi']['PROGNOSE'] + ' Ton', bar._model.x, bar._model.y - 20);
                                                }
                                            } else {
                                                if (index === dataset.data.length - 1 && i === 1) {
                                                    ctx.fillText(datas['akurasi']['PROGNOSE'] + ' Ton', bar._model.x, bar._model.y - 20);
                                                }
                                            }

                                        }), this);
                                    }), this);
                                }
                            }
                        },

                        legend: {
                            display: false
                        },
                        "horizontalLine": [{
                                "y": -1,
                                "style": "rgba(255, 0, 0, .4)"
                            }]
                    }
                });

                if (type == 'vol') {
                    if (org == '7000') {
                        var text2 = "<div class='legend'><div class='box-legend' style='background-color:#98210f;'> </div>&nbsp;RKAP&nbsp;&nbsp;&nbsp;</div>" +
                                "<div class='legend'><div class='box-legend' style='background-color:rgba(193, 113, 38, 1);'> </div>&nbsp;REAL 5000&nbsp;&nbsp;&nbsp;</div>" +
                                "<div class='legend'><div class='box-legend' style='background-color:rgb(226, 134, 49);'> </div>&nbsp;REAL 7000&nbsp;&nbsp;&nbsp;</div>" +
                                "<div class='legend'><div class='box-legend' style='background-color:rgba(255, 165, 0, 1);'> </div>&nbsp;REAL TOTAL&nbsp;&nbsp;&nbsp;</div>" +
                                "<div class='legend'><div class='box-legend' style='background-color:rgba(75, 192, 192, 0.6);'> </div>&nbsp;PROGNOSE&nbsp;&nbsp;&nbsp;</div>";

                    } else {
                        var text2 = "<div class='legend'><div class='box-legend' style='background-color:#98210f;'> </div>&nbsp;RKAP&nbsp;&nbsp;&nbsp;</div>" +
                                "<div class='legend'><div class='box-legend' style='background-color:rgba(255, 165, 0, 1);'> </div>&nbsp;REALISASI&nbsp;&nbsp;&nbsp;</div>" +
                                "<div class='legend'><div class='box-legend' style='background-color:rgba(75, 192, 192, 0.6);'> </div>&nbsp;PROGNOSE&nbsp;&nbsp;&nbsp;</div>";
                    }
                    $('#foot-prog').html(datas['prog'] + ' ton');
                    $('#foot-rkap').html(datas['rkap'] + ' ton');
                    $('#foot-persen').html(datas['persen'].toString().replace('.', ',') + ' %');
                    $('.sales-foot').css('display', '');
                    $('#foot-ave').html(formatAngka(datas['ave']) + ' ton');
                    $('#foot-rtl').html(formatAngka(datas['ptl']['REAL']) + ' ton');
                    $('#foot-ptl').html(datas['ptl']['PENCAPAIAN'] + ' %');

                } else {
                    if (prod == 1) {
                        $('.sales-foot').css('display', 'none');
                        var text2 = "<div class='legend'><div class='box-legend' style='background-color:#98210f;'> </div>&nbsp;RKAP&nbsp;&nbsp;&nbsp;</div>" +
                                "<div class='legend'><div class='box-legend' style='background-color:rgba(255, 165, 0, 1);'> </div>&nbsp;REALISASI&nbsp;&nbsp;&nbsp;</div>" +
                                "<div class='legend'><div class='box-legend' style='background-color:rgba(75, 192, 192, 0.6);'> </div>&nbsp;PROGNOSE&nbsp;&nbsp;&nbsp;</div>";
                        if (org == 7000) {
                            $('#foot-prog').html(datas['TOTAL']['akurasi']['PROGNOSE'] + ' ton');
                            $('#foot-rkap').html(datas['TOTAL']['akurasi']['RKAP'] + ' ton');
                            $('#foot-persen').html(datas['TOTAL']['akurasi']['PERSEN'].toString().replace('.', ',') + ' %');
                        } else {
                            $('#foot-prog').html(datas['akurasi']['PROGNOSE'] + ' ton');
                            $('#foot-rkap').html(datas['akurasi']['RKAP'] + ' ton');
                            $('#foot-persen').html(datas['akurasi']['PERSEN'].toString().replace('.', ',') + ' %');
                        }
                    } else {
                        var text2 = "<div class='legend'><div class='box-legend' style='background-color:rgba(255, 165, 0, 1);'> </div>&nbsp;REALISASI&nbsp;&nbsp;&nbsp;</div>" +
                                "<div class='legend'><div class='box-legend' style='background-color:rgba(75, 192, 192, 0.6);'> </div>&nbsp;PROGNOSE&nbsp;&nbsp;&nbsp;</div>" +
                                "<div class='legend'><div class='box-legend' style='background-color:green;'> </div>&nbsp;100% CAP&nbsp;&nbsp;&nbsp;</div>" +
                                "<div class='legend'><div class='box-legend' style='background-color:red;'> </div>&nbsp;50% CAP</div>";
                    }
                }

                $('#legendDiv2').html(text2);
                $("#pleasewait").hide();
                $("#grafik").show();
                var k = new Date()
//                setTimeout(function () {
//                    if (type == 'vol' && org == '7000' && prod == '0') {
//                        openTip(Chart1, k.getUTCDate() - 1, 5);
//                    } else {
//                        openTip(Chart1, k.getUTCDate() - 1, 3);
//                    }
//                    if (type == 'vol' && org == '7000' && prod == '0') {
//                        openTip(Chart2, k.getUTCDate() - 1, 4);
//                    } else if ((type === 'semen' || type === 'terak') && prod === 0) {
//                        openTip(Chart2, k.getUTCDate() - 1, 3);
//                    } else {
//                        openTip(Chart2, k.getUTCDate() - 1, 2);
//                    }
//                }, 500);

                if ((type == 'terak' && org == '7000') || (type == 'semen' && org == '7000')) {
                    $('#produksigresik').css('display', 'block');
                    $('#legendDiv3').html(text);
                    $('#legendDiv4').html(text2);
                    $('#legendDiv5').html(text);
                    $('#legendDiv6').html(text2);
                } else {
                    $('#produksigresik').css('display', 'none');
                }

                //openTip(Chart2, k.getUTCDate() - 1);
            }
        });
    }

    function iniTable(name, org) {
        datamv = $('#datatbl').val();
        var url = base_url + 'dashboard/Demandpl/getTable/' + tanggal + '/' + org + '/FALSE/' + datamv;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $("#modal-table").modal('show');
                $("#pleasewaittabel").show();
                $("#pleasewait-growth-sap").hide();
                $("#pleasewait-growth-asi").hide();
                $("#grafik").hide();
                $("#footer-vol").hide();
                $("#table-view").show();
                $("#tabel-rev tbody").html("");
            },
            success: function (datas) {
                //console.log(datas);
                $("#lu-timetabel").show();
                $("#lu-adjtabel").hide();
                $("#modal-titletabel").text("Detail Total S&OP " + name).show();
                $("#lastupdatetabel").html(datas.tanggal);

                $("#pleasewaittabel").hide();
                $("#tabel-rev tbody").html(datas.result);
            },
        });
    }


</script>
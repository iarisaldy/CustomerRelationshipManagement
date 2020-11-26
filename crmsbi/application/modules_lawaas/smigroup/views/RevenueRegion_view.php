<style type="text/css">
    img{
        width:90%;
        margin-left:2px;
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
        color: red;
    }
    .font-hitam{
        color: black;
    }
    .font-merah:hover{
        /*color:white;*/
    }
    .merah{
        /*border: 0.2vw solid #ff4545;*/
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
        /*border: 0.2vw solid #49ff56;*/
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
    
    hr { 
        display: block;
        margin-top: 0.5em;
        margin-bottom: 0em;
        /*margin-left: auto;*/
        /*margin-right: auto;*/
        border-style: inset;
        border-width: 1px;
    } 

    hr.style1 { 
        display: block;
        margin-top: 0.5em;
        margin-bottom: 0em;
        /*margin-left: auto;*/
        /*margin-right: auto;*/
        border-style: initial;
        border-width: 1px;
   

</style>
<div id="loading_purple"></div>
<div class="container">
    <div class="row">
        <div class="modal fade" id="modal-chart">
            <div class="modal-dialog">
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
                            <table class="table table-responsive table-condensed">
                                <thead class="header-kolom">
                                    <tr class="border-bawah">
                                        <th class="col-md-1" style='text-align: center;width:14%'></th>
                                        <?php
                                        foreach ($head as $row) {
                                            echo "<th style='text-align: center; width:10%'>$row</th>";
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="border-bawah">
                                        <td>
                                            <table width='100%' id="tabelProdTerakSG" style="border-radius: 2px" class="table-left-header">                                                        
                                                <tr><td class="left-top title-red" style="color: blue">RKAP TOTAL DOM<hr class="style1"></td></tr>
                                                <tr><td>Region 1</td></tr>
                                                <tr><td>Region 2</td></tr>
                                                <tr><td>Region 3</td></tr> 
                                                <tr><td>Curah (Jawa Bali)</td></tr> 
                                            </table>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '7000', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' style="border-radius: 2px;" id="tabelRkapVol">                                                        
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800"  id="totalRKAP" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '7000', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelRkapHarga" style="border-radius: 2px;">                                                        
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800"  id="totalRKAP" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>

                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '7000')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelRkapOa" style="border-radius: 2px;">
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800"  id="totalRKAP" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '7000')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelRkapNetto" style="border-radius: 2px;">
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800"  id="totalRKAP" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('vol', '7000')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelRkapRev" style="border-radius: 2px;">                                                        
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800"  id="totalRKAP" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td style="font-size: 17px; background: #3498DB; color: white;"><b>&nbsp;PENC. VOL & REV SEHARUSNYA&nbsp;</b></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td style="font-size: 17px; background: #1A5276; color: white; display:inline-block"> &nbsp;&nbsp;&nbsp;<b id="pencSeh"> %</b>&nbsp;&nbsp;&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width='100%' id="tabelProdTerakSG" style="border-radius: 2px" class="table-left-header" >                                                        
                                                <tr><td class="left-top title-green">REAL s.d KEMARIN <hr class="style1"></td></tr>
                                                <tr><td>Region 1</td></tr>
                                                <tr><td>Region 2</td></tr>
                                                <tr><td>Region 3</td></tr> 
                                                <tr><td>Curah (Jawa Bali)</td></tr> 
                                            </table>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '3000', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' style="border-radius: 2px;" id="tabelVolume">                                                        
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800"  id="totalRKAP" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '3000', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelHarga" style="border-radius: 2px;">                                                        
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800"  id="totalRKAP" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>

                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '3000')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelOa" style="border-radius: 2px;">
                                                       <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right;" class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right;" class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right;" class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right;" class="curah">&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td><td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '3000')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelNet" style="border-radius: 2px;">
                                                       <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('vol', '3000')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelRev" style="border-radius: 2px;">                                                        
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>                                     
                                                    </table>
                                                </div>
                                            </a>
                                        </td>

                                    </tr>
                                    <tr >
                                        <td>
                                            <table width='100%' id="tabelProdTerakSG" style="border-radius: 2px" class="table-left-header">                                                        
                                                <tr><td class="left-top title-green">% REAL THP RKAP<hr class="style1"></td></tr>
                                                <!-- <tr><td>&nbsp;</td></tr> -->
                                                <tr><td>Region 1</td></tr>
                                                <tr><td>Region 2</td></tr>
                                                <tr><td>Region 3</td></tr> 
                                                <tr><td>Curah (Jawa Bali)</td></tr> 
                                            </table>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '4000', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' style="border-radius: 2px;" id="tabelPersenVol">                                                        
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '4000', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelpersenHarga" style="border-radius: 2px;">                                                        
                                                         <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>            
                                                    </table>
                                                </div>
                                            </a>
                                        </td>

                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '4000')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelpersenOa" style="border-radius: 2px;">
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>            
                                                    </table>
                                                </div>
                                            </a>
                                        </td><td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '4000')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelpersenNetto" style="border-radius: 2px;">
                                                         <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>            
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('vol', '4000')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelpersenRev" style="border-radius: 2px;">                                                        
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>            
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td >
                                            <table width='100%' id="tabelProdTerakSG" style="border-radius: 2px" class="table-left-header">                                                        
                                                <tr><td class="left-top title-green">SELISIH REAL (±)<hr class="style1"></td></tr>
                                                <!-- <tr><td>&nbsp;</td></tr> -->
                                                <tr><td>Region 1</td></tr>
                                                <tr><td>Region 2</td></tr>
                                                <tr><td>Region 3</td></tr> 
                                                <tr><td>Curah (Jawa Bali)</td></tr> 
                                            </table>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('terak', '0', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' style="border-radius: 2px;" id="tabelSelisihVol">
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>         
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '0', '1')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelSelisihHarga" style="border-radius: 2px;">                                                        
                                                        <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>   
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
                                                    <table width='100%' id="tabelProdSemenSMIG" style="border-radius: 2px;">
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
                                                    <table width='100%' id="tabelSelisihOA" style="border-radius: 2px;">
                                                       <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>   
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('semen', '0')">
                                                <div class='table-demand'>
                                                    <table width='100%' id="tabelSelisihNetto" style="border-radius: 2px;">
                                                         <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>   
                                                    </table>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='javascript:void(0)' onclick="iniChart('vol', '0')">
                                                <div class="table-demand">
                                                    <table width='100%' id="tabelSelisihRevenue" style="border-radius: 2px;">                                                        
                                                         <tr><td style="text-align: right; font-size: 17px; font-weight: 800" class="smig">&nbsp;<hr></td></tr>
                                                        <tr><td style="text-align: right; " class="reg1">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg2">&nbsp;</td></tr>
                                                        <tr><td style="text-align: right; " class="reg3">&nbsp;</td></tr>  
                                                        <tr><td style="text-align: right; " class="curah">&nbsp;</td></tr>   
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
    var d, tahun, bulan;
    
    function formatAngka(n) {
        var num = parseInt(n);
        return (num + '').replace(/(\d)(?=(\d{3})+$)/g, '$1.');
    }
   
    $(function () {
        d = new Date();
        tahun = d.getUTCFullYear();
        bulan = d.getUTCMonth() + 1;
        bulan = bulan.toString().length < 2 ? '0' + bulan : bulan;
        var day = d.getUTCDate();
        var hari;
        hari = day.toString().length < 2 ? '0' + day : day;
        $('#tahun').val(tahun);
        $('#bulan').val(bulan);
        get_data();
        
        $('#update-btn').click(function () {
            tahun = $('#tahun').val();
            bulan = $('#bulan').val();
            get_data();
        });

      });
      
      function get_data(){
        var url = base_url + 'smigroup/RevenueRegion/getHVR/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
               
                $('#loading_purple').hide()
                
                 $("#pencSeh").html(parseFloat(data.Pencapaian[0]['PENC_SEH']).toFixed(1) +' %');
                 
                //RKAP H. Bruto
                var rkapBrutoSmig = ((parseFloat(data.DataHargaOA['SMIG']['TARGET_REALH']) + parseFloat(data.DataRevenue['SMIG']['TARGET_REALH']))/parseFloat(data.DataRKAP['SMIG']['TARGET']));
                var rkapBrutoReg1 = ((parseFloat(data.DataHargaOA['REGION1']['TARGET_REALH']) + parseFloat(data.DataRevenue['REGION1']['TARGET_REALH']))/parseFloat(data.DataRKAP['REGION1']['TARGET']));
                var rkapBrutoReg2 = ((parseFloat(data.DataHargaOA['REGION2']['TARGET_REALH']) + parseFloat(data.DataRevenue['REGION2']['TARGET_REALH']))/parseFloat(data.DataRKAP['REGION2']['TARGET']));
                var rkapBrutoReg3 = ((parseFloat(data.DataHargaOA['REGION3']['TARGET_REALH']) + parseFloat(data.DataRevenue['REGION3']['TARGET_REALH']))/parseFloat(data.DataRKAP['REGION3']['TARGET']));
                var rkapBrutoCurah = ((parseFloat(data.DataHargaOA['CURAH']['TARGET_REALH']) + parseFloat(data.DataRevenue['CURAH']['TARGET_REALH']))/parseFloat(data.DataRKAP['CURAH']['TARGET']));
                
                //RKAP OA
                var rkapOASmig = ((parseFloat(data.DataHargaOA['SMIG']['TARGET_REALH']) )/parseFloat(data.DataRKAP['SMIG']['TARGET']));
                var rkapOAReg1 = ((parseFloat(data.DataHargaOA['REGION1']['TARGET_REALH']))/parseFloat(data.DataRKAP['REGION1']['TARGET']));
                var rkapOAReg2 = ((parseFloat(data.DataHargaOA['REGION2']['TARGET_REALH']))/parseFloat(data.DataRKAP['REGION2']['TARGET']));
                var rkapOAReg3 = ((parseFloat(data.DataHargaOA['REGION3']['TARGET_REALH']))/parseFloat(data.DataRKAP['REGION3']['TARGET']));
                var rkapOACurah = ((parseFloat(data.DataHargaOA['CURAH']['TARGET_REALH']))/parseFloat(data.DataRKAP['CURAH']['TARGET']));
                
                //RKAP Netto 
                var rkapNettoSmig = (( parseFloat(data.DataRevenue['SMIG']['TARGET_REALH']))/parseFloat(data.DataRKAP['SMIG']['TARGET']));
                var rkapNettoReg1 = (( parseFloat(data.DataRevenue['REGION1']['TARGET_REALH']))/parseFloat(data.DataRKAP['REGION1']['TARGET']));
                var rkapNettoReg2 = (( parseFloat(data.DataRevenue['REGION2']['TARGET_REALH']))/parseFloat(data.DataRKAP['REGION2']['TARGET']));
                var rkapNettoReg3 = (( parseFloat(data.DataRevenue['REGION3']['TARGET_REALH']))/parseFloat(data.DataRKAP['REGION3']['TARGET']));
                var rkapNettoCurah = (( parseFloat(data.DataRevenue['CURAH']['TARGET_REALH']))/parseFloat(data.DataRKAP['CURAH']['TARGET']));
                
                //RKAP revenue
                var rkapRevSmig = parseFloat(data.DataRevenue['SMIG']['TARGET_REALH']/1000000);
                var rkapRevReg1 = parseFloat(data.DataRevenue['REGION1']['TARGET_REALH']/1000000);
                var rkapRevReg2 = parseFloat(data.DataRevenue['REGION2']['TARGET_REALH']/1000000);
                var rkapRevReg3 = parseFloat(data.DataRevenue['REGION3']['TARGET_REALH']/1000000);
                var rkapRevCurah = parseFloat(data.DataRevenue['CURAH']['TARGET_REALH']/1000000);
                
                //RKAP Volume
                $('#tabelRkapVol td.smig').html(Math.round(data.DataRKAP['SMIG']['TARGET']).toLocaleString(['ban', 'id']) + '<hr>');
                $('#tabelRkapVol td.reg1').html(Math.round(data.DataRKAP['REGION1']['TARGET']).toLocaleString(['ban','id']));
                $('#tabelRkapVol td.reg2').html(Math.round(data.DataRKAP['REGION2']['TARGET']).toLocaleString(['ban','id']));
                $('#tabelRkapVol td.reg3').html(Math.round(data.DataRKAP['REGION3']['TARGET']).toLocaleString(['ban','id']));
                $('#tabelRkapVol td.curah').html(Math.round(data.DataRKAP['CURAH']['TARGET']).toLocaleString(['ban','id']));
                
                //RKAP Harga
                $('#tabelRkapHarga td.smig').html(Math.round(rkapBrutoSmig).toLocaleString(['ban', 'id']) + '<hr>');
                $('#tabelRkapHarga td.reg1').html(Math.round(rkapBrutoReg1).toLocaleString(['ban','id']));
                $('#tabelRkapHarga td.reg2').html(Math.round(rkapBrutoReg2).toLocaleString(['ban','id']));
                $('#tabelRkapHarga td.reg3').html(Math.round(rkapBrutoReg3).toLocaleString(['ban','id']));
                $('#tabelRkapHarga td.curah').html(Math.round(rkapBrutoCurah).toLocaleString(['ban','id']));
                
                //RKAP OA
                $('#tabelRkapOa td.smig').html(Math.round(rkapOASmig).toLocaleString(['ban', 'id']) + '<hr>');
                $('#tabelRkapOa td.reg1').html(Math.round(rkapOAReg1).toLocaleString(['ban','id']));
                $('#tabelRkapOa td.reg2').html(Math.round(rkapOAReg2).toLocaleString(['ban','id']));
                $('#tabelRkapOa td.reg3').html(Math.round(rkapOAReg3).toLocaleString(['ban','id']));
                $('#tabelRkapOa td.curah').html(Math.round(rkapOACurah).toLocaleString(['ban','id']));
                
                //RKAP Netto
                $('#tabelRkapNetto td.smig').html(Math.round(rkapNettoSmig).toLocaleString(['ban', 'id']) + '<hr>');
                $('#tabelRkapNetto td.reg1').html(Math.round(rkapNettoReg1).toLocaleString(['ban','id']));
                $('#tabelRkapNetto td.reg2').html(Math.round(rkapNettoReg2).toLocaleString(['ban','id']));
                $('#tabelRkapNetto td.reg3').html(Math.round(rkapNettoReg3).toLocaleString(['ban','id']));
                $('#tabelRkapNetto td.curah').html(Math.round(rkapNettoCurah).toLocaleString(['ban','id']));
                
                //RKAP Revenue
                $('#tabelRkapRev td.smig').html(Math.round(rkapRevSmig).toLocaleString(['ban', 'id']) + '<hr>');
                $('#tabelRkapRev td.reg1').html(Math.round(rkapRevReg1).toLocaleString(['ban','id']));
                $('#tabelRkapRev td.reg2').html(Math.round(rkapRevReg2).toLocaleString(['ban','id']));
                $('#tabelRkapRev td.reg3').html(Math.round(rkapRevReg3).toLocaleString(['ban','id']));
                $('#tabelRkapRev td.curah').html(Math.round(rkapRevCurah).toLocaleString(['ban','id']));
                
                // Volume
                $('#tabelVolume td.smig').html(Math.round(data.DataRKAP['SMIG']['REAL']).toLocaleString(['ban', 'id']) + '<hr>');
                $('#tabelVolume td.reg1').html(Math.round(data.DataRKAP['REGION1']['REAL']).toLocaleString(['ban','id']));
                $('#tabelVolume td.reg2').html(Math.round(data.DataRKAP['REGION2']['REAL']).toLocaleString(['ban','id']));
                $('#tabelVolume td.reg3').html(Math.round(data.DataRKAP['REGION3']['REAL']).toLocaleString(['ban','id']));
                $('#tabelVolume td.curah').html(Math.round(data.DataRKAP['CURAH']['REAL']).toLocaleString(['ban','id']));
                
                //Revenue
                $('#tabelRev td.smig').html(Math.round(data.SMIG['REVENUE']).toLocaleString(['ban', 'id']) + '<hr>');
                $('#tabelRev td.reg1').html(Math.round(data.REGION1['REVENUE']).toLocaleString(['ban','id']));
                $('#tabelRev td.reg2').html(Math.round(data.REGION2['REVENUE']).toLocaleString(['ban','id']));
                $('#tabelRev td.reg3').html(Math.round(data.REGION3['REVENUE']).toLocaleString(['ban','id']));
                $('#tabelRev td.curah').html(Math.round(data.CURAH['REVENUE']).toLocaleString(['ban','id']));
                
                 //Nett
                $('#tabelNet td.smig').html(Math.round(data.SMIG['NETTO']).toLocaleString(['ban', 'id']) + '<hr>');
                $('#tabelNet td.reg1').html(Math.round(data.REGION1['NETTO']).toLocaleString(['ban','id']));
                $('#tabelNet td.reg2').html(Math.round(data.REGION2['NETTO']).toLocaleString(['ban','id']));
                $('#tabelNet td.reg3').html(Math.round(data.REGION3['NETTO']).toLocaleString(['ban','id']));
                $('#tabelNet td.curah').html(Math.round(data.CURAH['NETTO']).toLocaleString(['ban','id']));
                
                 //OA
                $('#tabelOa td.smig').html(Math.round(data.SMIG['OA']).toLocaleString(['ban', 'id']) + '<hr>');
                $('#tabelOa td.reg1').html(Math.round(data.REGION1['OA']).toLocaleString(['ban','id']));
                $('#tabelOa td.reg2').html(Math.round(data.REGION2['OA']).toLocaleString(['ban','id']));
                $('#tabelOa td.reg3').html(Math.round(data.REGION3['OA']).toLocaleString(['ban','id']));
                $('#tabelOa td.curah').html(Math.round(data.CURAH['OA']).toLocaleString(['ban','id']));
                
                 //Bruto
                $('#tabelHarga td.smig').html(Math.round(data.SMIG['HARGA']).toLocaleString(['ban', 'id']) + '<hr>');
                $('#tabelHarga td.reg1').html(Math.round(data.REGION1['HARGA']).toLocaleString(['ban','id']));
                $('#tabelHarga td.reg2').html(Math.round(data.REGION2['HARGA']).toLocaleString(['ban','id']));
                $('#tabelHarga td.reg3').html(Math.round(data.REGION3['HARGA']).toLocaleString(['ban','id']));
                $('#tabelHarga td.curah').html(Math.round(data.CURAH['HARGA']).toLocaleString(['ban','id']));
                
                //Warna Volume
                var warnaVolSmig = data.DataRKAP['SMIG']['REAL']-data.Pencapaian[0]['PENC_SEH']/100*data.DataRKAP['SMIG']['TARGET'] < 0 ? 'font-merah':'font-black';
                var warnaVolReg1 = data.DataRKAP['REGION1']['REAL']-data.Pencapaian[0]['PENC_SEH']/100*data.DataRKAP['REGION1']['TARGET'] < 0 ? 'font-merah':'font-black';
                var warnaVolReg2 = data.DataRKAP['REGION2']['REAL']-data.Pencapaian[0]['PENC_SEH']/100*data.DataRKAP['REGION2']['TARGET'] < 0 ? 'font-merah':'font-black';
                var warnaVolReg3 = data.DataRKAP['REGION3']['REAL']-data.Pencapaian[0]['PENC_SEH']/100*data.DataRKAP['REGION3']['TARGET'] < 0 ? 'font-merah':'font-black';
                var warnaVolCurah = data.DataRKAP['CURAH']['REAL']-data.Pencapaian[0]['PENC_SEH']/100*data.DataRKAP['CURAH']['TARGET'] < 0 ? 'font-merah':'font-black';
                
                //Warna Harga Bruto
                var warnaHargaSmig = (parseFloat(data.SMIG['HARGA'])/rkapBrutoSmig*100)<100 ? 'smig font-merah':'smig font-black';
                var warnaHargaReg1 = (parseFloat(data.REGION1['HARGA'])/rkapBrutoReg1*100)<100 ? 'reg1 font-merah':'reg1 font-black';
                var warnaHargaReg2 = (parseFloat(data.REGION2['HARGA'])/rkapBrutoReg2*100)<100 ? 'reg2 font-merah':'reg2 font-black';
                var warnaHargaReg3 = (parseFloat(data.REGION3['HARGA'])/rkapBrutoReg3*100)<100 ? 'reg3 font-merah':'reg3 font-black';
                var warnaHargaCurah = (parseFloat(data.CURAH['HARGA'])/rkapBrutoCurah*100)<100 ? 'curah font-merah':'curah font-black';
                
                //Warna OA
                var warnaOASmig = (parseFloat(data.SMIG['OA'])/rkapOASmig*100) > 100 ? 'smig font-merah':'smig font-black';
                var warnaOAReg1 = (parseFloat(data.REGION1['OA'])/rkapOAReg1*100) > 100 ? 'reg1 font-merah':'reg1 font-black';
                var warnaOAReg2 = (parseFloat(data.REGION2['OA'])/rkapOAReg2*100) > 100 ? 'reg2 font-merah':'reg2 font-black';
                var warnaOAReg3 = (parseFloat(data.REGION3['OA'])/rkapOAReg3*100) > 100 ? 'reg3 font-merah':'reg3 font-black';
                var warnaOACurah = (parseFloat(data.CURAH['OA'])/rkapOACurah*100) > 100 ? 'curah font-merah':'curah font-black';
                
                //Warna Harga Netto
                var warnaNettoSmig = (parseFloat(data.SMIG['NETTO'])/rkapNettoSmig*100) < 100 ? 'smig font-merah':'smig font-black';
                var warnaNettoReg1 = (parseFloat(data.REGION1['NETTO'])/rkapNettoReg1*100) < 100 ? 'reg1 font-merah':'reg1 font-black';
                var warnaNettoReg2 = (parseFloat(data.REGION2['NETTO'])/rkapNettoReg2*100) < 100 ? 'reg2 font-merah':'reg2 font-black';
                var warnaNettoReg3 = (parseFloat(data.REGION3['NETTO'])/rkapNettoReg3*100) < 100 ? 'reg3 font-merah':'reg3 font-black';
                var warnaNettoCurah = (parseFloat(data.CURAH['NETTO'])/rkapNettoCurah*100) < 100 ? 'curah font-merah':'curah font-black';
                
                //warna Revenue
                var warnaRevSmig = parseFloat(data.SMIG['REVENUE'])- data.Pencapaian[0]['PENC_SEH']/100*rkapRevSmig < 0 ? 'smig font-merah':'smig font-black';
                var warnaRevReg1 = parseFloat(data.REGION1['REVENUE'])- data.Pencapaian[0]['PENC_SEH']/100*rkapRevReg1 < 0 ? 'reg1 font-merah':'reg1 font-black';
                var warnaRevReg2 = parseFloat(data.REGION2['REVENUE'])- data.Pencapaian[0]['PENC_SEH']/100*rkapRevReg2 < 0 ? 'reg2 font-merah':'reg2 font-black';
                var warnaRevReg3 = parseFloat(data.REGION3['REVENUE'])- data.Pencapaian[0]['PENC_SEH']/100*rkapRevReg3 < 0 ? 'reg3 font-merah':'reg3 font-black';
                var warnaRevCurah =parseFloat(data.CURAH['REVENUE'])- data.Pencapaian[0]['PENC_SEH']/100*rkapRevCurah < 0 ? 'curah font-merah':'curah font-black';
                
                //persen Volume
                $('#tabelPersenVol td.smig').html(parseFloat(parseFloat(data.DataRKAP['SMIG']['REAL']/data.DataRKAP['SMIG']['TARGET']*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' % <hr>').attr('class',warnaNettoSmig);
                $('#tabelPersenVol td.reg1').html(parseFloat(parseFloat(data.DataRKAP['REGION1']['REAL']/data.DataRKAP['REGION1']['TARGET']*100).toFixed(1)).toLocaleString(['ban','id'])+ ' %').attr('class',warnaNettoReg1);
                $('#tabelPersenVol td.reg2').html(parseFloat(parseFloat(data.DataRKAP['REGION2']['REAL']/data.DataRKAP['REGION2']['TARGET']*100).toFixed(1)).toLocaleString(['ban','id'])+ ' %').attr('class',warnaNettoReg2);
                $('#tabelPersenVol td.reg3').html(parseFloat(parseFloat(data.DataRKAP['REGION3']['REAL']/data.DataRKAP['REGION3']['TARGET']*100).toFixed(1)).toLocaleString(['ban','id'])+ ' %').attr('class',warnaNettoReg3);
                $('#tabelPersenVol td.curah').html(parseFloat(parseFloat(data.DataRKAP['CURAH']['REAL']/data.DataRKAP['CURAH']['TARGET']*100).toFixed(1)).toLocaleString(['ban','id'])+ ' %').attr('class',warnaNettoCurah);
                
                //Persen Harga Bruto
                $('#tabelpersenHarga td.smig').html( parseFloat((parseFloat(data.SMIG['HARGA'])/rkapBrutoSmig*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %<hr>').attr('class',warnaHargaSmig);
                $('#tabelpersenHarga td.reg1').html( parseFloat((parseFloat(data.REGION1['HARGA'])/rkapBrutoReg1*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaHargaReg1);
                $('#tabelpersenHarga td.reg2').html( parseFloat((parseFloat(data.REGION2['HARGA'])/rkapBrutoReg2*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaHargaReg2);
                $('#tabelpersenHarga td.reg3').html( parseFloat((parseFloat(data.REGION3['HARGA'])/rkapBrutoReg3*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaHargaReg3);
                $('#tabelpersenHarga td.curah').html( parseFloat((parseFloat(data.CURAH['HARGA'])/rkapBrutoCurah*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaHargaCurah);
                
                
                //Persen OA
                $('#tabelpersenOa td.smig').html( parseFloat((parseFloat(data.SMIG['OA'])/rkapOASmig*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %<hr>').attr('class',warnaOASmig);
                $('#tabelpersenOa td.reg1').html( parseFloat((parseFloat(data.REGION1['OA'])/rkapOAReg1*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaOAReg1);
                $('#tabelpersenOa td.reg2').html( parseFloat((parseFloat(data.REGION2['OA'])/rkapOAReg2*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaOAReg2);
                $('#tabelpersenOa td.reg3').html( parseFloat((parseFloat(data.REGION3['OA'])/rkapOAReg3*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaOAReg3);
                $('#tabelpersenOa td.curah').html( parseFloat((parseFloat(data.CURAH['OA'])/rkapOACurah*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaOACurah);
                
                
                //Persen Netto
                $('#tabelpersenNetto td.smig').html( parseFloat((parseFloat(data.SMIG['NETTO'])/rkapNettoSmig*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %<hr>').attr('class',warnaNettoSmig);
                $('#tabelpersenNetto td.reg1').html( parseFloat((parseFloat(data.REGION1['NETTO'])/rkapNettoReg1*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaNettoReg1);
                $('#tabelpersenNetto td.reg2').html( parseFloat((parseFloat(data.REGION2['NETTO'])/rkapNettoReg2*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaNettoReg2);
                $('#tabelpersenNetto td.reg3').html( parseFloat((parseFloat(data.REGION3['NETTO'])/rkapNettoReg3*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaNettoReg3);
                $('#tabelpersenNetto td.curah').html( parseFloat((parseFloat(data.CURAH['NETTO'])/rkapNettoCurah*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaNettoCurah);
                
                
                //Persen Revenue
                $('#tabelpersenRev td.smig').html( parseFloat((parseFloat(data.SMIG['REVENUE'])/ rkapRevSmig * 100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %<hr>').attr('class',warnaRevSmig);
                $('#tabelpersenRev td.reg1').html( parseFloat((parseFloat(data.REGION1['REVENUE'])/ rkapRevReg1*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaRevReg1);
                $('#tabelpersenRev td.reg2').html( parseFloat((parseFloat(data.REGION2['REVENUE'])/ rkapRevReg2*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaRevReg2);
                $('#tabelpersenRev td.reg3').html( parseFloat((parseFloat(data.REGION3['REVENUE'])/ rkapRevReg3*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaRevReg3);
                $('#tabelpersenRev td.curah').html( parseFloat((parseFloat(data.CURAH['REVENUE'])/ rkapRevCurah*100).toFixed(1)).toLocaleString(['ban', 'id']) + ' %').attr('class',warnaRevCurah);
                
                //Selisih Volume
                $('#tabelSelisihVol td.smig').html(Math.round(data.DataRKAP['SMIG']['REAL']-data.Pencapaian[0]['PENC_SEH']/100*data.DataRKAP['SMIG']['TARGET']).toLocaleString(['ban', 'id']) + '<hr>').attr('class',warnaVolSmig);
                $('#tabelSelisihVol td.reg1').html(Math.round(data.DataRKAP['REGION1']['REAL']-data.Pencapaian[0]['PENC_SEH']/100*data.DataRKAP['REGION1']['TARGET']).toLocaleString(['ban','id'])).attr('class',warnaVolReg1);
                $('#tabelSelisihVol td.reg2').html(Math.round(data.DataRKAP['REGION2']['REAL']-data.Pencapaian[0]['PENC_SEH']/100*data.DataRKAP['REGION2']['TARGET']).toLocaleString(['ban','id'])).attr('class',warnaVolReg2);
                $('#tabelSelisihVol td.reg3').html(Math.round(data.DataRKAP['REGION3']['REAL']-data.Pencapaian[0]['PENC_SEH']/100*data.DataRKAP['REGION3']['TARGET']).toLocaleString(['ban','id'])).attr('class',warnaVolReg3);
                $('#tabelSelisihVol td.curah').html(Math.round(data.DataRKAP['CURAH']['REAL']-data.Pencapaian[0]['PENC_SEH']/100*data.DataRKAP['CURAH']['TARGET']).toLocaleString(['ban','id'])).attr('class',warnaVolCurah);
                
                
                //Selisih Harga
                $('#tabelSelisihHarga td.smig').html( Math.round(parseFloat(data.SMIG['HARGA'])-rkapBrutoSmig).toLocaleString(['ban', 'id']) + '<hr>').attr('class',warnaHargaSmig);
                $('#tabelSelisihHarga td.reg1').html( Math.round(parseFloat(data.REGION1['HARGA'])-rkapBrutoReg1).toLocaleString(['ban', 'id']) ).attr('class',warnaHargaReg1);
                $('#tabelSelisihHarga td.reg2').html( Math.round(parseFloat(data.REGION2['HARGA'])-rkapBrutoReg2).toLocaleString(['ban', 'id']) ).attr('class',warnaHargaReg2);
                $('#tabelSelisihHarga td.reg3').html( Math.round(parseFloat(data.REGION3['HARGA'])-rkapBrutoReg3).toLocaleString(['ban', 'id']) ).attr('class',warnaHargaReg3);
                $('#tabelSelisihHarga td.curah').html( Math.round(parseFloat(data.CURAH['HARGA'])-rkapBrutoCurah).toLocaleString(['ban', 'id']) ).attr('class',warnaHargaCurah);
                
                //Selisih OA
                $('#tabelSelisihOA td.smig').html( Math.round(parseFloat(data.SMIG['OA'])-rkapOASmig).toLocaleString(['ban', 'id']) + '<hr>').attr('class',warnaOASmig);
                $('#tabelSelisihOA td.reg1').html( Math.round(parseFloat(data.REGION1['OA'])-rkapOAReg1).toLocaleString(['ban', 'id'])).attr('class',warnaOAReg1);
                $('#tabelSelisihOA td.reg2').html( Math.round(parseFloat(data.REGION2['OA'])-rkapOAReg2).toLocaleString(['ban', 'id'])).attr('class',warnaOAReg2);
                $('#tabelSelisihOA td.reg3').html( Math.round(parseFloat(data.REGION3['OA'])-rkapOAReg3).toLocaleString(['ban', 'id'])).attr('class',warnaOAReg3);
                $('#tabelSelisihOA td.curah').html( Math.round(parseFloat(data.CURAH['OA'])-rkapOACurah).toLocaleString(['ban', 'id'])).attr('class',warnaOACurah);
                
                //Selisih Netto
                $('#tabelSelisihNetto td.smig').html( Math.round(parseFloat(data.SMIG['NETTO'])-rkapNettoSmig).toLocaleString(['ban', 'id']) + ' <hr>').attr('class',warnaNettoSmig);
                $('#tabelSelisihNetto td.reg1').html( Math.round(parseFloat(data.REGION1['NETTO'])-rkapNettoReg1).toLocaleString(['ban', 'id']) ).attr('class',warnaNettoReg1);
                $('#tabelSelisihNetto td.reg2').html( Math.round(parseFloat(data.REGION2['NETTO'])-rkapNettoReg2).toLocaleString(['ban', 'id']) ).attr('class',warnaNettoReg2);
                $('#tabelSelisihNetto td.reg3').html( Math.round(parseFloat(data.REGION3['NETTO'])-rkapNettoReg3).toLocaleString(['ban', 'id']) ).attr('class',warnaNettoReg3);
                $('#tabelSelisihNetto td.curah').html( Math.round(parseFloat(data.CURAH['NETTO'])-rkapNettoCurah).toLocaleString(['ban', 'id']) ).attr('class',warnaNettoCurah);
                
                //Selisih Revenue
                $('#tabelSelisihRevenue td.smig').html( Math.round(parseFloat(data.SMIG['REVENUE'])- data.Pencapaian[0]['PENC_SEH']/100*rkapRevSmig ).toLocaleString(['ban', 'id']) + ' <hr>').attr('class',warnaRevSmig);
                $('#tabelSelisihRevenue td.reg1').html( Math.round(parseFloat(data.REGION1['REVENUE'])- data.Pencapaian[0]['PENC_SEH']/100*rkapRevReg1).toLocaleString(['ban', 'id']) ).attr('class',warnaRevReg1);
                $('#tabelSelisihRevenue td.reg2').html( Math.round(parseFloat(data.REGION2['REVENUE'])- data.Pencapaian[0]['PENC_SEH']/100*rkapRevReg2).toLocaleString(['ban', 'id']) ).attr('class',warnaRevReg2);
                $('#tabelSelisihRevenue td.reg3').html( Math.round(parseFloat(data.REGION3['REVENUE'])- data.Pencapaian[0]['PENC_SEH']/100*rkapRevReg3).toLocaleString(['ban', 'id']) ).attr('class',warnaRevReg3);
                $('#tabelSelisihRevenue td.curah').html( Math.round(parseFloat(data.CURAH['REVENUE'])- data.Pencapaian[0]['PENC_SEH']/100*rkapRevCurah).toLocaleString(['ban', 'id']) ).attr('class',warnaRevCurah);
                
                
            }
        });
      }
</script>
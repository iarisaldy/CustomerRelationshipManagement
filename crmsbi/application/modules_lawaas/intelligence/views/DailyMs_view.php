<style>
    .colorsmig,.colorsg,.colorsp,.colorst{
        color:black;
        font-weight: bold; 
    }
    .panel{
        position: relative;
        width: 110%;
        right: 5%;
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
    #md-dialog{
        width: 100%;
        height: 200%;
    }
    .modal-header {

        /*background-color: orange;*/
        background: linear-gradient(to left, #1ab394, #036C13);
        color: #ffffff;
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
        /*display: none;*/
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
    #tabel-upload{
        font-size: 10px;
    }
    tfoot {
        display: table-header-group;
    } 
</style>

<div id="loading_purple"></div>
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-11">
                            <label>Company</label>
                            <select id="org" class="form-control">
                                <option value="1">SMI Group</option>
                                <option value="7000">Semen Gresik</option>
                                <option value="3000">Semen Padang</option>
                                <option value="4000">Semen Tonasa</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <?php if ($this->session->userdata('akses') == 1) { ?>
                        <button onclick="upload_modal()" class="btn btn-info" style="margin-top:24px"><i class="fa fa-upload"></i> Upload</button>
                    <?php } ?>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <div class="col-md-4">
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
                                for ($i = 2016; $i <= Date('Y'); $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>    
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button id="filter" class="btn btn-success" style="margin-top:24px"><i class="fa fa-search"></i></button>
                            <button onclick="grafik_msH()" class="btn btn-primary" type="button" style="float:right;margin-top: 24px;"><i class="fa fa-bar-chart-o"></i> Grafik MS</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    <div class="panel-body">
        <div class="row">
            <div id="chart1"></div>
        </div>        
    </div>
</div>

<!--modal ins detail prov-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none; width: 100%">
    <div class="modal-dialog" id="md-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Survey Harga Semen Provinsi <span id="prov"></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-5">
                            <div class="col-md-12" id="myradio">
                                <label class="radio-inline">
                                    <input class="pilihkilo" type="radio" name="kilo" value="40" checked=""> Semen 40 Kg
                                </label>
                                <label class="radio-inline">
                                    <input class="pilihkilo" type="radio" name="kilo" value="50"> Semen 50 Kg
                                </label>  
                                <label class="radio-inline">
                                    <input class="pilihkilo" type="radio" name="kilo" value="curah"> Curah
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select id="pilih-kota-trend" class="filterprice pilih-kota form-control" name="pilih-kota">

                            </select>
                        </div>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#price" aria-controls="home" role="tab" data-toggle="tab">Price</a></li>
                            <li role="presentation"><a href="#trend" aria-controls="profile" role="tab" data-toggle="tab">Trend</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="price">
                                <br/>
                                <div class="row">
                                    <!--<div class="col-md-12">-->
                                    <div class="col-md-6">
                                        <div id="wadahBoxplotjual"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="wadahBoxplottebus"></div>
                                    </div>
                                    <!--</div>-->
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="trend">
                                <br/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" style="">
                                            <div class="col-md-3">
                                                <div class="col-md-12" id="myradio">
                                                    <label class="radio-inline">
                                                        <input class="pilihprice" type="radio" name="pilihprice" value="1" checked=""> Lowest
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input class="pilihprice" type="radio" name="pilihprice" value="2"> Median
                                                    </label>     
                                                    <label class="radio-inline">
                                                        <input class="pilihprice" type="radio" name="pilihprice" value="3"> Highest
                                                    </label>     
                                                </div>
                                            </div>
                                            <div class="col-md-2">

                                            </div>
                                            <div class="col-md-7">
                                                <div class="col-lg-12">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-3">
                                                        <select id="bulan-awal" class="filterprice form-control" name="bulan-awal">
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
                                                    <div class="col-md-2">
                                                        <select id="tahun-awal" class="filterprice form-control" name="tahun-awal">
                                                            <?php
                                                            for ($i = 2016; $i <= Date('Y'); $i++) {
                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                            }
                                                            ?>    
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1"><label style="margin-top:25%">s.d.</label></div>
                                                    <div class="col-md-3">
                                                        <select id="bulan-akhir" class="filterprice form-control" name="bulan-akhir">
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
                                                    <div class="col-md-2">
                                                        <select id="tahun-akhir" class="filterprice form-control" name="tahun-akhir">
                                                            <?php
                                                            for ($i = 2016; $i <= Date('Y'); $i++) {
                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                            }
                                                            ?>    
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <canvas id="myChartTrend" width="100%" height="100%"></canvas>
                                        </div>
                                        <div class="col-md-6">
                                            <canvas id="myChartTrendDua" width="100%" height="100%"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--            <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        </div>-->
        </div>
    </div>
</div>

<!--modal grafik-->
<div class="modal inmodal fade" id="myModal1" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 15px;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><i class="fa fa-bar-chart-o"></i> Grafik Ms Harian</h4>
                <!--<small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>-->
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group" style="">
                        <div class="col-md-4">
                            <div class="col-md-12" id="myradio">
                                <label class="radio-inline">
                                    <input type="radio" name="msj" value="harian" checked=""> Harian
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="msj" value="akumulasi"> Akumulasi
                                </label>     
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select id="bulan1" class="form-control" name="bulan">
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
                            <select id="tahun1" class="form-control" name="tahun">
                                <?php
                                for ($i = 2016; $i <= Date('Y'); $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>    
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button id="filter2" class="btn btn-success" style=""><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div id="charthar">
                    <canvas id="myChart" width="100%" height="50%"></canvas>
                </div>
                <div id="chartkum"> 
                    <canvas id="myChartakum" width="100%" height="50%"></canvas>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--Tabel summary-->
<div class="summary" id="">
    <div style="text-align: center"><b>SUMMARY MARKET SHARE <span id="bulanini"></span></b></div>
    <table class="table table-hover border-bottom center" style="text-align: center">
        <thead>
            <tr class="info">
                <th>COMPANY</th>
                <th>TARGET</th>
                <th>MARKET SHARE</th>
                <th>REALISASI</th>
            </tr>            
        </thead>
        <tbody>
            <tr>
                <td>SMIG</td>
                <td id="targetsmig"></td>
                <td><span class="label" id="mssmig"></span></td>
                <td id="realsmig"></td>
            </tr>
            <tr>
                <td>SG</td>
                <td id="targetsg"></td>
                <td><span class="label" id="mssg"></span></td>
                <td id="realsg"></td>
            </tr>
            <tr>
                <td>SP</td>
                <td id="targetsp"></td>
                <td><span class="label" id="mssp"></span></td>
                <td id="realsp"></td>
            </tr>
            <tr>
                <td>ST</td>
                <td id="targetst"></td>
                <td><span class="label" id="msst"></span></td>
                <td id="realst"></td>
            </tr>
        </tbody>     
    </table>
</div>
<!-- modal upload -->
<!--modal ins detail prov-->
<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:85%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload Data Price</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="ibox collapsed">
                        <div class="ibox-title collapse-link">
                            <h5 style="cursor: pointer;"><i class="fa fa-plus" style="color:#1ab394"></i> Upload data price</h5>
                            <div class="ibox-tools">
                            </div>
                        </div>
                        <div class="ibox-content" style="display: none;">
                            <form method="post" id="frmFile" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <input name="userfile" id="userfile" type="file" >
                                    <p class="help-block">Download template upload data price <a href="<?php echo base_url(); ?>assets/template/template_upload_price.xls" class="btn btn-xs btn-primary"><i class="fa fa-download"></i></a></p>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" onclick="uploadFiles()"><i class="fa fa-upload"></i> Upload</button>
                            </form>
                        </div>
                    </div>
                </div><br/>
                <div class="row">
                    <div id="contain-upload">
                        <table id="tabel-upload" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PROVINSI</th>
                                    <th>KOTA</th>
                                    <th>BRAND</th>
                                    <th>TANGGAL</th>
                                    <th>HARGA TEBUS</th>
                                    <th>HARGA JUAL</th>
                                    <th>TIPE</th>
                                    <th>PESAN</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label>Provinsi</label>
                            <select class="form-control" name="provinsi" id="provinsi"  onchange="provinsi()">
                                <option value="0">-- Pilih Provinsi --</option>
                                <?php foreach ($prov as $provs) { ?>
                                    <option value="<?= $provs['KD_PROV'] ?>"><?= $provs['NM_PROV'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Kota</label>
                            <select class="form-control" name="kota" id="kota">
                                <option value="0">-- Pilih Kota --</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Bulan</label>
                            <select id="bulan_fil" class="form-control" name="bulan">
                                <option value="0">-- Pilih Bulan --</option>
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
                            <select class="form-control" id="tahun_fil" name="tahun">
                                <option value="0">-- Pilih Tahun --</option>
                                <?php
                                for ($i = 2016; $i <= Date('Y'); $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>    
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary pull-right" style="margin-top: 21px;" onclick="downloadPrice()"><i class="glyphicon glyphicon-export"></i> Export Excel</button>
                        </div>
                    </div>
                </div>
                <br>
                <table id="tabelprice" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PROVINSI</th>
                            <th>KOTA</th>
                            <th>BRAND</th>
                            <th>TANGGAL</th>                                   
                            <th>HARGA TEBUS</th>
                            <th>HARGA JUAL</th>
                            <th>TIPE</th>
                            <th>OPSI</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap modal for  -->
<div class="modal inmodal" id="modal_form" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title">Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <div class="form-body">
                        <input type="hidden" value="" name="ID"/> 
                        <div class="form-group">
                            <label class="control-label col-md-3">Harga Tebus</label>
                            <div class="col-md-9">
                                <input name="HARGA_TEBUS" class="form-control" required="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Harga Jual</label>
                            <div class="col-md-9">
                                <input name="HARGA_JUAL" class="form-control" required="" type="text">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts-jquery-plugin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.maps.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/maps/fusioncharts.indonesia.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
<!-- Plotly -->
<script src="<?php echo base_url(); ?>assets/plotly/plotly-latest.min.js"></script>
<script src="<?= base_url('assets/chartjs/dist/Chart.js') ?>" type="text/javascript"></script>
<?php require_once('js_DailyMs.php'); ?> <!-- javascriptnya diletakkan di file ini, ben gak akeh2 sak halaman-->

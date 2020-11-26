<style>
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
    .panel{
        position: relative;
        width: 110%;
        right: 5%;
        margin-top: -2%;
    }
    .panel-heading{
        background: linear-gradient(to left, #1ab394, #036C13);
    }
    table {
        color: black;
    }
    #tabel-rev tbody{
        text-align: right;
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
    .border-bawah{
        border-bottom: 3px solid black;
    }
    .kotak{
        float:left;
        width:1vw;
        height:1vw;
        border-radius: 3px;
        /*display: inline;*/
    }
    .label-merah{
        background-color: #ff4545;
        color: white;
        /*font-size: 12px;*/
    }
    .label-kuning{
        background-color: #fef536;
        color: black;
        /*font-size: 12px;*/
    }
    .label-hijau{
        background-color: #49ff56;
        color: black;
        /*font-size: 12px;*/
    }
</style>

<div id="loading_purple"></div>
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">   
            <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-list"></i> MONITORING REVENUE</span></h4>            
        </div>        
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <!--<label>Bulan</label>-->
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
                <div class="col-md-2">
                    <!--<label>Tahun</label>-->
                    <select id="tahun" class="form-control" name="tahun">
                        <?php
                        for ($i = 2014; $i <= Date('Y'); $i++) {
                            echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>    
                    </select>
                </div>
                <div class="col-md-1">
                    <button id="filter" class="btn btn-success"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><br/>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover table-responsive" id="tabel-rev">
                    <thead>
                        <tr>
                            <th rowspan="2">&nbsp;</th>
                            <th>&nbsp;</th>
                            <th colspan="3" class="success">Bulan ini (s/d tgl kemarin)</th>
                            <th colspan="3" class="danger">Bulan ini</th>
                            <th colspan="3" class="warning">Prognose sisa bulan <span id="thn-rev"></span></th>
                            <th rowspan="2">Action</th>
                        </tr>
                        <tr class='border-bawah'>
                            <th>Uraian</th>
                            <th class="success">Real</th>
                            <th class="success">RKAP</th>
                            <th class="success">%Real</th>
                            <th class="danger">Prognose</th>
                            <th class="danger">RKAP</th>
                            <th class="danger">%Prog</th>
                            <th class="warning">Prognose</th>
                            <th class="warning">RKAP setahun</th>
                            <th class="warning">%Prog</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DATA WILL LOAD HERE -->
                    </tbody>
                </table>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    <button onclick="bukaDetailOpco('7000')" class="btn btn-sm btn-default"><img src="<?php echo base_url(); ?>assets/img/menu/semen_gresik.png" class="logo-menu"> Semen Gresik</button>
                </div>
                <div class="col-md-2">
                    <button onclick="bukaDetailOpco('3000')" class="btn btn-sm btn-default"><img src="<?php echo base_url(); ?>assets/img/menu/semen_padang.png" class="logo-menu"> Semen Padang</button>
                </div>
                <div class="col-md-2">
                    <button onclick="bukaDetailOpco('4000')" class="btn btn-sm btn-default"><img src="<?php echo base_url(); ?>assets/img/menu/semen_tonasa.png" class="logo-menu"> Semen Tonasa</button>
                </div>
                <div class="col-md-2">
                    <button onclick="bukaDetailOpco('6000')" class="btn btn-sm btn-default"><img src="<?php echo base_url(); ?>assets/img/menu/thang_long.jpg" class="logo-menu"> Thang Long</button>
                </div>                
            </div>
        </div><br/>
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
                <div class="col-md-6">
                    <p class="pull-right" style="color: #005fbf;">Prognose sisa bulan = realisasi Januari s/d <?php echo $bulanlalu; ?> + prognose <?php echo $bulanskrg; ?> s/d Desember </p>
                </div>                
            </div>
        </div>
    </div>
</div>
<script>
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
    var d = new Date();
    var tahun = d.getUTCFullYear();
    var bulan = month[d.getUTCMonth()];
    var tanggal = tahun + '' + bulan;
    function getDataTotal(tanggal) {
        var url = base_url + 'smigroup/Revenue/getDataTotal/' + tanggal+'/1';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                //$('#tabel-incl tbody').html(data);
                $('#tabel-rev tbody').html(data);
                getDataDomestik(tanggal);
            }
        });
    }
    function getDataDomestik(tanggal) {
        var url = base_url + 'smigroup/Revenue/getDataTotal/' + tanggal+'/2';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                //$('#tabel-dom tbody').html(data);
                $('#tabel-rev tbody').append(data);
                getDataEkspor(tanggal);
            }
        });
    }
    function getDataEkspor(tanggal) {
        var url = base_url + 'smigroup/Revenue/getDataTotal/' + tanggal+'/3';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                //$('#tabel-eks tbody').html(data);
                $('#tabel-rev tbody').append(data);
                $('#loading_purple').hide();
            }
        });
    }
    function bukaDetailOpco(opco){
        var url = base_url + 'smigroup/Revenue/detailOpco/' + opco+'/'+tanggal;
        window.open(url, '_blank');
    }
    $(function () {
        $('#tahun').val(tahun);
        $('#bulan').val(bulan);
        $('#thn-rev').val(tahun);
        getDataTotal(tanggal);
        $('#filter').click(function () {
            tahun = $('#tahun').val();
            bulan = $('#bulan').val();
            $('#thn-rev').val(tahun);
            tanggal = tahun + '' + bulan;
            getDataTotal(tanggal);
        });
    });
</script>
<style>
/*    #style-1::-webkit-scrollbar
    {
        width: 9px;
        background-color: #F5F5F5;
    }

    #style-1::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #555;
    }*/
    .konten{
        position: relative;
        width: 110%;
        right: 5%;
        padding-top: 0%;
    }
    .info-window{
        width: 100%;
        min-width:300px;
        max-width:500px;
        float: left;
        overflow: hidden;
        background:#ecf0f1;
        padding-bottom:5px;
        line-height: 20px;
    }
    .judul{
        font-family: 'Open Sans Condensed', sans-serif;
        font-size: 22px;
        font-weight: 400;
        padding: 10px;
        background-color: #337ab7;
        color: white;
        margin: 0;
        border-radius: 2px 2px 0 0;
    }
    .judul_data{
        padding-left: 3%;
        font-size: 13px;
        font-weight: 500;
    }
    .isi_data{
        padding-right: 5%;
        float: right;
        font-size: 13px;
        font-weight: 500;
    }
    #wrap_progress{
        width:94%;
        overflow:hidden;
        float:left;
        background:#FFF;
        box-shadow: 0px 1px 6px #7f8c8d;
        margin-top:-50px;
        margin-left:0px;
        z-index:80;
        position:absolute;
    }

    #wrap_progress:before{
        content: "";
        display: block;
        padding-bottom: 1%;
    }
    #progress_judul, .kpi_progress_judul{
        overflow:hidden;
        float:left;
        width:93%;
        margin:0px 3.5% 0 3.5%;
        text-align:center;
        font-family: "Segoe UI","Segoe",Tahoma,Helvetica,Arial,sans-serif !important;
        font-size: 15px;
        font-size: 1vw;
        font-weight:600;
        color:#16a085;
    }

    #progress_judul{
        letter-spacing:-0.5px;
        border-bottom:2px solid #16a085;
        padding:0px 0px;
        margin:0px 3.5%;
        margin-top: -0.5%;
    }
    #legend_stok td {
        height:26px;
        padding:0px 0px 0px 20px !important;
        text-align:left;
        font-size: 1vw;
        border-bottom:1px solid #d0d0d0;
        vertical-align:middle;
        color:#555555;
        background-color:#ffffff;
    }
    .box-legend{
        width:30px;
        height:15px;
        border: 0px solid;
        background-color: #49ff56;
        float:left;
    }
    .font-merah{
        color: #ff4545;
    }
    #right-sidebar {
        background-color: #fff;
        border-left: 1px solid #e7eaec;
        border-top: 1px solid #e7eaec;
        overflow: hidden;
        position: fixed;
        top: 3px;
        width: 225px !important;
        z-index: 80;
        bottom: 0;
        right: -260px;
    }
    .fh-breadcrumb {
        height: calc(100% - -5px);
        margin: 0 -15px;
        position: relative;
    }
    .label-danger {
        background-color: #ed5565;
        color: #FFFFFF;
        padding: 9px 78px;
    }
    .gm-style img {
        max-width: 110px;
        margin: 0px 101px;
    }
    .lightBoxGallery {
        text-align: left;
    }
    .lightBoxGallery img {
        margin: 5px;
    }  
</style>
<div class="konten">
    <div class="row">
        <div class="ibox pn">
            <div class="col-md-12">
                <div class="ibox-title" style="background: aliceblue;">
                    <div class="col-md-3">
                    <h5><i class="fa fa-info-circle"></i> Fasilitas Perusahaan</h5>
                    </div>
                        <div class="col-md-3" style="">
                            <div class="input-group" id="perusahaan" style="margin-top: -9px;">
                                <span class="input-group-addon gray-bg">Perusahaan</span>
                                <input class="input-sm form-control" style="height: 35px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group" id="fasilitas" style="margin-top: -9px;">
                                <span class="input-group-addon gray-bg">Fasilitas</span>
                                <input class="input-sm form-control" style="height: 35px;">
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                </div>
                <div class="ibox-content">
                    <div id="gudang_canvas" class="google-map" style="height: 530px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Icon Notifikasi-->
<div id="small-chat" style="left: 96.5%;" >
    <span class="badge badge-warning pull-right">
        <?php foreach ($totalnews as $row) { ?>
            <?= $row->TOTAL ?>
        <?php } ?>
    </span>
    <a class="open-small-chat right-sidebar-toggle">
        <i class="fa fa-list-alt"></i>
    </a>
</div>		
<div class="modal inmodal" id="modal-list">
    <div class="modal-dialog" style="margin: 17px auto;">
        <div class="modal-content animated fadeIn">
            <div class="modal-header" style="background:linear-gradient(to left, #1ab394, #036C13);color: #fff;padding: 10px">
                <button class="close" data-dismiss="modal">×</button>
                <h3 id="myModalLabel">&nbsp;</h3>
            </div>
            <div class="modal-body">
                <div class="row" id="wadahPerusahaan">
                    <?php echo $listperusahaan; ?>
                </div>
                <div class="row" id="wadahFasilitas">
                    <?php echo $listfasilitas; ?>
                </div>
            </div>
        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="modal-chart">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><span id="modal-title"></span></h4>
            </div>
            <div class="modal-body">
                <div id="pleasewait">Please Wait . . .</div>
                <div class="row" id="grafik">
                    <div class="row">
                        <div class="col-md-12">
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
                                    for ($i = 2015; $i <= Date('Y'); $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>    
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button id="filter" class="btn btn-success" style="margin-top:23px"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <canvas id="Chart1" width="100%" height="70%"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="Chart2" width="100%" height="70%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Start Menu Lightbox-->
<div class="lightBoxGallery" id="lightBoxGallery">
    <div id="blueimp-gallery" class="blueimp-gallery" style="background: #000;">
        <div class="slides"></div>
        <h3 class="title" style="display: block;"></h3>
        <a class="prev" style="display: block;">‹</a>
        <a class="next" style="display: block;">›</a>
        <a class="close" style="display: block;">×</a>
        <a class="play-pause" style="display: block;"></a>
        <ol class="indicator" style="display: block;"></ol>
    </div>
</div>
<!-- End Menu Lightbox-->


<!--Start Notifikasi-->
<!--<div id="right-sidebar" class="small-chat-box fadeInRight animated" style="height:592px;margin-right: 11%;margin-top: 2%;">
    <div class="fh-breadcrumb" class="">
        <div class="fh-column">
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;">
                <div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">
                    <small class="label label-danger" style="margin: 0px 15px;font-size: 12px;position: fixed;border-radius: 0px;z-index: 9999">Notification</small>
                    <div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">
                        <div class="input-group" style="margin: 0px 15px;top: 29px;position: fixed;width:224px;z-index: 9999" >
                            <span class="input-group-addon" id="reset-news"  style="cursor:pointer">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" class="form-control date" id="sort-news"> 
                        </div>
                        <div class="tab-pane active list-group elements-list news-list" id="info" style="margin-top: 30px;">
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->
<!--End Notifikasi-->
<div id="right-sidebar" class="small-chat-box fadeInRight animated" style="height:592px;margin-right: 3.7%;margin-top: 2%;">

    <div class="heading" draggable="true" style="background:#ec4758">
<!--                <small class="chat-date pull-right">
        <?= date('d-m-Y') ?>
                </small>-->
        Notification
    </div>
    <div class="form-chat">
        <div class="input-group input-group-sm"><span class="input-group-addon" id="reset-news"  style="cursor:pointer">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" class="form-control date" id="sort-news"> </div>
    </div>

    <div class="scrollbar" id="style-1" style="overflow:auto ;height: 86%;overflow-x: hidden;">
        <!--<div class="left">-->
        <div class="tab-pane active list-group elements-list news-list" id="info" style="margin-top: -10px"></div>
        <!--</div>-->


    </div>

</div>

<!-- 2 link dalam tabel ini hanya admin yang dapat mengakses -->
<?php if ($this->session->userdata('akses') == 1) { ?>
    <div class="col-lg-3">
        <div class="panel panel-success" style="position: fixed;bottom: 1px;left: 50px;z-index: 100;">
            <div class="panel-heading" style="font-weight:bold;background: #337ab7;color:#fff">
                <i class="fa fa-info-circle"></i> Entry Competitor Facility
            </div>
            <br>
            <table>
                <tr>
                    <td><a target="_blank" href="<?php echo site_url('intelligence/Competitor/MasterFasilitas') ?>" style="color:#fff;"><button class="btn btn-success dim btn-xs" style="margin: 0px 15px;background: #337ab7"><i class="fa fa-plus-circle"></i> Master Fasilitas</button></a></td>
                </tr>
                <tr>
                    <td><a target="_blank" href="<?php echo site_url('intelligence/Competitor/MasterPerusahaan') ?>" style="color:#fff;"><button class="btn btn-success dim btn-xs" style="margin: 0px 15px;background: #337ab7"><i class="fa fa-plus-circle"></i> Master Perusahaan</button></a></td>
                </tr>
                <tr>
                    <td><a target="_blank" href="<?php echo site_url('intelligence/Competitor/FasilitasPerusahaan') ?>" style="color:#fff;"><button class="btn btn-success dim btn-xs" style="margin: 0px 15px;background: #337ab7"><i class="fa fa-plus-circle"></i> Fasilitas Perusahaan</button></a></td>
                </tr>
            </table>
        </div>
    </div>
<?php } ?>

<script src="<?= base_url('assets/chartjs/dist/Chart.js') ?>" type="text/javascript"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBfrt8HWifiiNZjrUN0KAelgjk0yYuav48"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.fixedHeader.min.js"></script>
<link href="<?php echo base_url(); ?>assets/css/plugins/slick/slick.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/plugins/slick/slick-theme.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/plugins/slick/slick.min.js"></script>
<?php require_once('Competitor_js.php'); ?>

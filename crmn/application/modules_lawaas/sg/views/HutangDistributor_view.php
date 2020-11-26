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

    .table-bordered {
        border: 1px solid #000;
    }

    .table > thead > tr > th {
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
        vertical-align: bottom;
    }
    .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
        border: 1px solid #000;
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
        background-color: #ff4545;
        color: white;
        font-size: 12px;
    }
    .label-kuning{
        background-color: #fef536;
        font-size: 12px;
    }
    .label-hijau{
        background-color: #49ff56;
        font-size: 12px;
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
    .orange-soft{
        background-color: #fae9d6 !important;
    }
    td{
        white-space:nowrap;
    }

</style>
<link href="<?php echo base_url(); ?>assets/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/fixedHeader.dataTables.min.css" rel="stylesheet">
<div id="loading_purple"></div>
<div class="row">    
    <div class="col-lg-12">        
        <div class="ibox ibox1 float-e-margins">            
            <div class="ibox-title title-desc">
                <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-line-chart"></i> SISA CL & HUTANG DISTRIBUTOR</span></h4>            
            </div>
            <div class="ibox-content">     
                <div class="row">

                    <div class="col-md-12">
                        <div class="col-md-7" style="">
                            <div class="col-md-2"><img src="<?= base_url() . 'assets/img/menu/semen_gresik.png' ?>" style="width:90px;"></div>
                            <div class="col-md-10"><h2 style="text-align:left;line-height: 315%;"><b>SEMEN GRESIK</b></h2></div>
                        </div>
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-1">

                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12" style="align:center">

                        <table id="table_bag" class="table table-bordered" >
                            <thead>
                                <tr>
                                     <th class='default' colspan="10">DATA BAG</th>
                                </tr>
                                <tr>
                                    <th class='success' width='10%' rowspan="2">DIST</th>
                                    <th class='danger' width='10%' rowspan="2">REAL</th>
                                    <th class='danger' width='10%' rowspan="2">SISA SO</th>
                                    <th class='danger' width='10%' rowspan="2">KREDIT LIMIT</th>
                                    <th class='danger' width='10%' rowspan="2">SISA CL</th>
                                    <th class='orange-soft' width='50%' rowspan="1" colspan="5">PIUTANG DISTRIBUTOR (JT Rupiah)</th>
                                </tr>
                                <tr>
                                    <th class='info' width='5%'>FUTURE</th>
                                    <th class='info' width='15%' >5 Hari</th>
                                    <th class='info' width='10%'>10 Hari</th>
                                    <th class='info' width='10%' >15 Hari</th>
                                    <th class='info' width='10%' >20 Hari</th>
                                </tr>
                            </thead>
                            <tbody id="table_bag_body">
                                <!-- data di load disini -->
                            </tbody>
                        </table>  
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table id="table_bulk" class="table table-bordered" >
                            <thead>
                                 <tr>
                                     <th class='default' colspan="10">DATA BULK</th>
                                </tr>
                                <tr>
                                    <th class='success' width='10%' rowspan="2">DIST</th>
                                    <th class='danger' width='10%' rowspan="2">REAL</th>
                                    <th class='danger' width='10%' rowspan="2">SISA SO</th>
                                    <th class='danger' width='10%' rowspan="2">KREDIT LIMIT</th>
                                    <th class='danger' width='10%' rowspan="2">SISA CL</th>
                                    <th class='orange-soft' width='50%' rowspan="1" colspan="5">PIUTANG DISTRIBUTOR (JT Rupiah)</th>
                                </tr>
                                <tr>
                                    <th class='info' width='10%'>FUTURE</th>
                                    <th class='info' width='10%' >5 Hari</th>
                                    <th class='info' width='10%'>10 Hari</th>
                                    <th class='info' width='10%' >15  Hari</th>
                                    <th class='info' width='10%' >20 Hari</th>
                                </tr>
                            </thead>
                            <tbody  id="table_bulk_body">
                                <!-- data di load disini -->
                            </tbody>
                        </table>                    

                    </div>
                </div>
                <div class="row">
                    <div class=" col-md-12">
                        <table id="table_ics" class="table table-bordered" >
                            <thead>
                                 <tr>
                                     <th class='default' colspan="10">ICS</th>
                                </tr>
                                <tr>
                                    <th class='success' width='10%' rowspan="2">DIST</th>
                                    <th class='danger' width='10%' rowspan="2">REAL</th>
                                    <th class='danger' width='10%' rowspan="2">SISA SO</th>
                                    <th class='danger' width='10%' rowspan="2">KREDIT LIMIT</th>
                                    <th class='danger' width='10%' rowspan="2">SISA CL</th>
                                    <th class='orange-soft' width='50%' rowspan="1" colspan="5">PIUTANG DISTRIBUTOR (JT Rupiah)</th>
                                </tr>
                                <tr>
                                    <th class='info' width='10%'>FUTURE</th>
                                    <th class='info' width='10%' >5</th>
                                    <th class='info' width='10%'>10</th>
                                    <th class='info' width='10%' >15</th>
                                    <th class='info' width='10%' >20 CL</th>
                                </tr>
                            </thead>
                            <tbody id="table_ics_body" >
                                <!-- data di load disini -->
                            </tbody>
                        </table>                    

                    </div>
                </div>
                <div class="row">

                    <div class=" col-md-12">
                     
                        <table id="posisi_armada" class="table table-bordered" >
                            <thead>
                                <tr><th colspan="8"> POSISI ARMADA</th></tr>
                                <tr>
                                    <th class='info' width='10%' rowspan="2">CHARGO</th>
                                    <th class='info' width='10%' rowspan="2">DAFTAR</th>
                                    <th class='info' width='10%' rowspan="1" colspan="2">ALAMAT</th>
                                    <th class='info' width='10%' rowspan="1" colspan="2">CONF</th>
                                    <th class='info' width='10%' rowspan="1" colspan="2">SPJ</th>
                                </tr>
                                <tr>
                                    <th class='info' width='10%'>BAG</th>
                                    <th class='info' width='10%' >BULK</th>
                                    <th class='info' width='10%'>BAG</th>
                                    <th class='info' width='10%' >BULK</th>
                                    <th class='info' width='10%' >BAG</th>
                                    <th class='info' width='10%' >BULK</th>
                                </tr>
                            </thead>
                            <tbody id="table_armada_body" >
                                <!-- data di load disini -->
                            </tbody>
                            <thead>
                                <tr><th colspan="8"> STOK SEMEN </th></tr>
                                <tr>
                                    <th class='info' width='10%' colspan="2">PPC</th>
                                    <th class='info' width='10%' colspan="2">OPC</th>
                                    <th class='info' width='10%' colspan="2">KHUSUS</th>
                                    <th class='info' width='10%' colspan="2">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="table_stok_body" >
                                
                            </tbody>
                        </table>                    

                    </div>
                </div>

                
                <div class="row pull-right">

                </div>
                <div id="page-info">
                    <ul class="list-group clear-list">

                    </ul>
                </div>
            </div>
        </div>            
    </div>        
</div>\

<script src="<?php echo base_url(); ?>assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/dist/Chart.bundle.js"></script>
<script>
    $(function () {
        var url = base_url + 'sg/HutangDistributor/getData';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $('#loading_purple').hide();
                $('#table_bag_body').html(data.bag);
                $('#table_bulk_body').html(data.bulk);
                $('#table_ics_body').html(data.ics);
                $('#table_armada_body').html(data.armada);
                $('#table_stok_body').html(data.stok);
                $('#table_bag').DataTable({
                    "bDestroy": true,
                    "paging": false,
                    "searching": false,
                    "fixedHeader": true,
                    "scrollX": false,
                    "language": {
                        "decimal": ",",
                        "thousands": "."
                    }
                });
                $('#table_bulk').DataTable({
                    "bDestroy": true,
                    "paging": false,
                    "searching": false,
                    "fixedHeader": true,
                    "scrollX": false,
                    "language": {
                        "decimal": ",",
                        "thousands": "."
                    }
                });
                $('#table_ics').DataTable({
                    "bDestroy": true,
                    "paging": false,
                    "searching": false,
                    "fixedHeader": true,
                    "scrollX": false,
                    "language": {
                        "decimal": ",",
                        "thousands": "."
                    }
                });
            }

        });



    });
</script>


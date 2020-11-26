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
    .center {
        vertical-align: middle !important;
        text-align: center !important;
    }
    .right {
        vertical-align: middle;
        text-align: right;
    }
    .ten {
        vertical-align: middle !important;
        text-align: center !important;
        background: #ff4545 !important;
        color: white !important;
        font-size: 11px;
        border: 1px solid black !important;
    }
    .non70 {
        vertical-align: middle !important;
        text-align: center !important;
        background: #1ab394 !important;
        color: black !important;
        font-size: 9px;
        border: 1px solid black !important;
    }
    .seventy {
        vertical-align: middle !important;
        text-align: center !important;
        background: rgba(254, 245, 54, 0.18) !important;
        color: black !important;
        font-size: 9px !important;
        border: 1px solid black !important;
    }
    .zak {
        background: white !important;
        color: black !important;
        font-size: 11px !important;
        border: 1px solid black !important;
        vertical-align: middle !important;
        text-align: center !important;
    }
    .curah {
        background: #F5F5F6 !important;
        color: black !important;
        font-size: 11px !important;
        border: 1px solid black !important;
        vertical-align: middle !important;
        text-align: center !important;
    }
</style>
<link href="<?php echo base_url(); ?>assets/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/fixedHeader.dataTables.min.css" rel="stylesheet">

<div id="loading_purple"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h4><span class="text-navy"><i class="fa fa-truck"></i> PACKING PLANT <?php echo strtoupper($nm_plant); ?></span></h4>            
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table id="table_packing_plant" class="table table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th class="ten" rowspan="2">PLANT</th>
                                <th class="ten" rowspan="2">KETERANGAN</th>
                                <th class="non70" colspan="2">TRUK DI CARGO<br />(ANTRI DAPAT ALAMAT)</th>
                                <th class="non70" colspan="2">TRUK DAPAT ALAMAT<br />(ANTRI TIMBANG KOSONG)</th>
                                <th class="non70" colspan="2">TRUK DI DALAM PABRIK<br />(PROSES MUAT)</th>
                                <th class="seventy" colspan="2">TRUK SELESAI MUAT<br />(MENDAPAT SPJ)</th>
                                <th class="seventy" colspan="2">VOLUME RILIS UPDATE<br />(TON)</th>
                            </tr>
                            <tr>
                                <th class="zak">ZAK</th>
                                <th class="curah">CURAH</th>
                                <th class="zak">ZAK</th>
                                <th class="curah">CURAH</th>
                                <th class="zak">ZAK</th>
                                <th class="curah">CURAH</th>
                                <th class="zak">ZAK</th>
                                <th class="curah">CURAH</th>
                                <th class="zak">ZAK</th>
                                <th class="curah">CURAH</th>
                            </tr>
                        </thead>
                        <tbody id="table_body" name="table_body">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.fixedHeader.min.js"></script>
<script>
    function create_table(){
        var url = base_url + '<?php echo $url ?>';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $('#loading_purple').hide();
                if(data){
                    console.log(data);
                    $("#table_body").html(data.table);
                    $('#table_packing_plant').dataTable({
                        "ordering": false,
                        "fixedHeader": true
                    });
                }
            }
        });
    }

    $(function () {
        create_table();
    });
    
</script>
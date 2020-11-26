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
        margin-top: 0%;
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
    .font-biru{
        color:#0044cc;
    }
    .font-hitam{
        color:#000000;
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
            <h4><span class="text-navy" style="color:#ffffff"><i class="fa fa-list"></i> DETAIL REVENUE <?php echo $detail; ?></span></h4>            
        </div>        
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover table-responsive" id="tabel-rev">
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align: middle; text-align: center;">Bulan</th>
                            <th rowspan="2" style="vertical-align: middle; text-align: center;">Uraian</th>
                            <th class="success" colspan="3" style="text-align: center;">Domestik</th>
                            <th class="danger" colspan="3" style="text-align: center;">Ekspor ( CL+CMT )</th>
                        </tr>
                        <tr>
                            <th class="success">Prognose</th>
                            <th class="success">RKAP</th>
                            <th class="success">%Prognose</th>
                            <th class="danger">Real/Prognose</th>
                            <th class="danger">RKAP</th>
                            <th class="danger">%Real/Prognose</th>
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
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/StickyTable/jquery.stickytableheaders.js"></script>
<script>
    function getDetail(org) {
        var tanggal = '<?php echo $date; ?>';
        var url = base_url + 'smigroup/Revenue/getDetailOpco/' + org +'/'+tanggal;
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
                $('#loading_purple').hide();
            },
            complete: function(){
                //$('#tabel-rev').DataTable();
                $("table").stickyTableHeaders();
            }
        });
    }
    $(function () {
        var org = '<?php echo $org; ?>';
        getDetail(org);
    });
</script>
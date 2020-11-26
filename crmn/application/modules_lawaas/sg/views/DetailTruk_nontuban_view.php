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
</style>
<div id="loading_purple"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h4><span class="text-navy"><i class="fa fa-truck"></i> IN PLANT <?php echo strtoupper($nm_plant); ?></span></h4>            
            </div>
            <div class="ibox-content">
                <div class="row">   
                    <a href="javascript:history.go(-1)" type="button" class="btn btn-primary">
                        <i class="fa fa-arrow-circle-left"></i> Kembali
                    </a>
                    <center><h2><b>DETAIL TRUK</b></h2></center>
                </div>
                <div class="row">                    
                    <div class="col-md-5">                         
                        <ul class="list-group clear-list m-t">
                            <li class="list-group-item fist-item">
                                <span class="pull-right" id="tonase">
                                    0
                                </span>
                                <span class="label label-primary">#</span>  Total Tonase
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right" id="total">
                                    0
                                </span>
                                <span class="label label-primary">#</span>  Total Truk
                            </li>
                        </ul>
                    </div>
                </div>                              
                <div class="table-responsive">
                    <table id="table_detail_truk" class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>TANGGAL MULAI</th>
                                <th>JAM MULAI</th>
                                <th>NOMOR POLISI</th>
                                <th>NAMA SOPIR</th>
                                <th>NAMA EKSPEDITUR</th>
                                <th>DURASI</th>
                                <th>STATUS</th>
                                <th>TUJUAN</th>
                                <th>TONASE</th>
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

<script>
    function isRealValue(obj) {
        return obj && obj !== "null" && obj !== "undefined";
    }
    function create_table(obj_data) {
        $("#table_detail_truk").dataTable().fnDestroy();
        var table_string = "<thead><tr>" +
                "<th class='success'>NO</th>" +
                "<th class='success'>TANGGAL MULAI</th>" +
                "<th class='success'>JAM MULAI</th>" +
                "<th class='success'>NOMOR POLISI</th>" +
                "<th class='success'>NAMA SOPIR</th>" +
                "<th class='success'>NAMA EKSPEDITUR</th>" +
                "<th class='success'>DURASI</th>" +
                "<th class='success'>STATUS</th>" +
                "<th class='success'>NAMA KOTA</th>" +
                "<th class='success'>TONASE</th>" +
                "</tr></thead><tbody>";
        var count = 0;
        var tonase = 0;
        if (isRealValue(obj_data)) {
            $.each(obj_data, function (key, val) {
                count++;
                var kwantumx = 0;
                var namaKota = '';
                var namaSopir = '';
                if (!val.KWANTUMX) {
                    kwantumx = 0;
                } else {
                    kwantumx = val.KWANTUMX;
                }
                if (!val.NM_KOTA) {
                    namaKota = '-';
                } else {
                    namaKota = val.NM_KOTA;
                }
                if (!val.NAMA_SOPIR) {
                    namaSopir = '-';
                } else {
                    namaSopir = val.NAMA_SOPIR;
                }
                var durasi = val.DURASI.replace(',','.');
                table_string += "<tr>" +
                        "<td>" + count + "</td>" +
                        "<td>" + val.TANGGAL + "</td>" +
                        "<td>" + val.JAM_MULAI + "</td>" +
                        "<td>" + val.NO_POLISI + "</td>" +
                        "<td>" + namaSopir + "</td>" +
                        "<td>" + val.NAMA_EXPEDITUR + "</td>" +
                        "<td>" + Number(durasi).toFixed(2) + "</td>" +
                        "<td>" + val.STATUS + "</td>" +
                        "<td>" + namaKota + "</td>" +
                        "<td>" + kwantumx + "</td>" +
                        "</tr>";
                if (val.KWANTUMX) {
                    tonase += parseInt(val.KWANTUMX);
                }
            });
        }
        table_string += "</tbody>";
        $('#total').html(count);
        $('#tonase').html(tonase);
        $("#table_detail_truk").html(table_string);

        // Init Datatables with Tabletools Addon    
        $('#table_detail_truk').dataTable({
            "aoColumnDefs": [{'bSortable': false, 'aTargets': [-1]}],
            "oLanguage": {"oPaginate": {"sPrevious": "", "sNext": ""}},
            "iDisplayLength": 5,
            "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            "bDestroy": true
        });
    }
    function get_detail_truk() {
        var loc = window.location;
        var id = loc.pathname.substring(loc.pathname.lastIndexOf('/') + 1, loc.pathname.length);
        var url = base_url + '<?php echo $url; ?>' + id;
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
    $(function () {
        $('#loading_purple').hide();
        get_detail_truk();
    });
</script>
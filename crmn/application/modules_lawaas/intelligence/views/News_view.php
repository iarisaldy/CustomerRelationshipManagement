<style>
    .panel-heading, .modal-header {
        background: linear-gradient(to left, #1ab394, #036C13);
        color: white;
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
</style>
<div id="loading_purple"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Daftar Berita</h4>
                </div>
            </div>
            <div class="panel-body">
                <button class="btn btn-success" onclick="sync()"><i class="fa fa-refresh"></i> Sync RSS Feed</button>
                <br />
                <br />
                <div class="ibox-content">
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: center">No</th>
                                <th style="text-align: center">Title</th>
                                <th style="text-align: center">Link</th>
                                <th style="text-align: center">Publication Date</th>
                                <th style="text-align: center">Status</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {

        //datatables
        table = $('#table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "destroy": true,
            "ordering": true,
            "order": [],
            
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_url + 'intelligence/RssParse/getDataNews',
                "type": "POST"
            }
        });
    });


    function reload_table()
    {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function sync() {
        var url = base_url + 'intelligence/RssParse/parseLink';
        $.ajax({
            url: url,
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                reload_table();
                $('#loading_purple').hide();
            }
        });
    }

    function hapus(id) {
        var url = base_url + 'intelligence/RssParse/deleteNews';
        if (confirm('Apakah anda yakin ingin menghapus data ini?'))
        {
            $.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function () {
                    $('#loading_purple').show();
                },
                success: function (data) {
                    reload_table();
                    $('#loading_purple').hide();
                }
            });
        }
    }

    function sembunyikan(id) {
        var url = base_url + 'intelligence/RssParse/hideNews';
        if (confirm('Apakah anda ingin menyembunyikan berita ini?'))
        {
            $.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function () {
                    $('#loading_purple').show();
                },
                success: function (data) {
                    reload_table();
                    $('#loading_purple').hide();
                }
            });
        }
    }

    function tampilkan(id) {
        var url = base_url + 'intelligence/RssParse/showNews';
        if (confirm('Apakah anda ingin menampilkan berita ini?'))
        {
            $.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function () {
                    $('#loading_purple').show();
                },
                success: function (data) {
                    reload_table();
                    $('#loading_purple').hide();
                }
            });
        }
    }
</script>

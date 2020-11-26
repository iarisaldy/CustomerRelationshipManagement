<style>
    .panel-heading, .modal-header {
        background: linear-gradient(to left, #1ab394, #036C13);
    }
    h4{        
        color: #FFF;
    }
    .panel{
        width: 110%;
        margin-left: -5%;
    }
    .pdf{
        width: 100%;
        height: 550px;
    }
    .pdf1{
        width: 134.5%;
        height: 550px;
    }
    .jstree-open > .jstree-anchor > .fa-folder:before {
        content: "\f07c";
    }

    .jstree-default .jstree-icon.none {
        width: 0;
    }
    /*collapse sidebar*/
    #sidebar {
        -webkit-transition: margin 3s ease;
        -moz-transition: margin 3s ease;
        -o-transition: margin 3s ease;
        transition: margin 3s ease;
    }
    .collapsed1 {
        display: none;
    }
    @media (min-width: 992px) {
        .collapsed1 {
            display: block;
            margin-left: -25%;
        }
    }
    #row-main {
        overflow-x: hidden;
    }
    #content {
        -webkit-transition: width 3s ease;
        -moz-transition: width 3s ease;
        -o-transition: width 3s ease;
        transition: width 3s ease;
    }
</style>
<link href="<?php echo base_url(); ?>assets/css/plugins/jsTree/style.min.css" rel="stylesheet">
<div class="row">    
    <div class="col-lg-12 col-md-12">   
        <div class="panel panel-default">            
            <div class="panel-heading">
                <h4><span><i class="fa fa-newspaper-o"></i> HEADLINE NEWS</span></h4>            
            </div>
            <div class="panel-body">
                <div class="row" id="row-main">
                    <div class="col-lg-3 col-md-3" id="sidebar">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <div class="file-manager">
                                    <?= $error ?>
                                    <?php if ($this->session->userdata('akses') == 1) { ?>
                                        <div class="uplod-btn" style="padding-left: 10%;">
                                                <!--<button type="submit" data-toggle="modal" data-target="#modal" id="btn-save" class="btn btn-primary btn-block"><i class="fa fa-upload"></i> Upload Files</button>-->
                                            <button class="btn btn-success  dim" type="button" title="Upload File" data-toggle="modal" data-target="#modal" id="btn-save"><i class="fa fa-upload"></i></button>
                                            <a href="<?= base_url('intelligence/Keyword') ?>" target="_blank" ><button class="btn btn-warning dim" type="button" title="Keyword"><i class="fa fa-key"></i></button></a>
                                            <a href="<?= base_url('intelligence/Link') ?>" target="_blank" ><button class="btn btn-primary  dim" type="button" title="Link"><i class="fa fa-link"></i></button></a>
                                            <a href="<?= base_url('intelligence/RssParse/viewNews') ?>" target="_blank" ><button class="btn btn-info dim" type="button" title="News"><i class="fa fa-newspaper-o"></i></button></a>
                                            <!--<div class="hr-line-dashed"></div>-->
                                        </div>
                                    <?php } ?>
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5><i class="fa fa-archive"></i> File Archives</h5>
                                            <div class="ibox-tools">
                                                <a class="collapse-link">
                                                    <i class="fa fa-chevron-up"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ibox-content">
                                            <div id="using_json" style="margin-left: -10%;"></div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 animated fadeInRight" id="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div style="padding-bottom:2px;"><a class="collepse btn btn-primary btn-bitbucket">
                                        <i class="fa fa-exchange"></i>
                                    </a></div>
                                <div id="msg"></div>
                                <iframe id="pdf" class="pdf" src="<?php echo base_url(); ?>assets/periodicreport/web/viewer.html?file=<?= $newfile ?>" scrolling="no"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>  
    </div>
</div>

<div id="right-sidebar" class="small-chat-box fadeInLeft animated" style="height:83%;margin-right: 93%;margin-top: 2%;">

    <div class="heading" draggable="true" style="background:#ec4758">
<!--                <small class="chat-date pull-right">
        <?= date('d-m-Y') ?>
                </small>-->
        Newsfeed
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
<div id="small-chat" style="right: 96.5%;" >

    <span class="badge badge-warning pull-right">
         <?php foreach ($totalnews as $row) { ?>
            <?= $row->TOTAL ?>
        <?php } ?>
    </span>
    <a class="open-small-chat">
        <i class="fa fa-list-alt"></i>

    </a>
</div>

<!-- treejsview -->
<script src="<?php echo base_url(); ?>assets/js/plugins/jsTree/jstree.min.js"></script>
<script>
    /*
     * upload data report
     */
    function upload() {
        $('#btn-save').attr('disabled', true);
        $('#btn-save').text('Proses');
        $('#icon').addClass('fa-spinner');
        $('#icon').addClass('fa-spin');
        $('#icon').removeClass('fa-check');
        var formData = new FormData($("#form-report")[0]);
        var url = base_url + 'intelligence/HeadlineNews/proses';
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                alert('Upload Berhasil!');
                $('#modal').modal('show');
                reload_table();
                $('#btn-save').attr('disabled', false);
                $('#btn-save').text('Submit');
                $('#icon').removeClass('fa-spinner');
                $('#icon').addClass('fa-check ');
                $('#icon').removeClass('fa-spin');
//                $('#using_json').jstree(true).settings.core.data = new_data;
//                $('#using_json').jstree(true).refresh();
//                jstree.jstree("refresh");
            }
        });
    }
    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }
    /*
     * delete data report
     */
    function delete_report(id) {
        if (confirm('Are you sure delete this data?'))
        {
            var url = base_url + 'intelligence/HeadlineNews/delreport/' + id;
            $.ajax({
                url: url,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {
                    //if success reload ajax table
                    $('#modal').modal('show');
                    reload_table();
//                    $('#using_json').jstree(true).settings.core.data = new_data;
//                    $('#using_json').jstree(true).refresh();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error');
                }
            });

        }
    }

    function getNews() {
        var url = base_url + 'intelligence/RssParse/getDataNewsSidebar';
        $.ajax({
            url: url,
            dataType: 'json',
            success: function (data) {
                $.each(data, function (key, value) {
                    if (value['PUBDATE'] === null) {
                        var dt_tgl = "-";
                    } else {
                        var dt_tgl = value['PUBDATE'];
                        var tgl = value['PUBDATE'].split(' ');
                    }
                    var deskripsi = value['DESCRIPTION'].replace('>','><!--');
                    var deskripsi1 = deskripsi.replace('<','--><');
                    list = $('#info');
                    list.append('<li class="sidebar-message list-group-item news-info" data-category="' + tgl[0] + '" style="height:160px">' +
                            '<strong><a href="'+value['LINK']+'" target="_blank">' + value['TITLE'] + '</a></strong>' +
                            '<br>' +
                            '<small class="text-muted">' + dt_tgl + '</small>' +
                            '<div class="small m-t-xs" id="zoom">' + 
                                '<p style="margin: 0 0 5px;width: 195px;">' +'<!--'+ deskripsi1 +'-->'+ '</p>'+
                            '</div></li>'
                            );
                });
            }
        });
    }
    // Memanggil proses filter
    $('#sort-news').change(function () {
        var filter = $(this).val();
        filterList(filter);
    });
    // Proses filter notifikasi sidebar berdasarkan tanggal
    function filterList(filter) {
        var list = $(".news-list .news-info");
        $(list).fadeOut("fast");
        if (filter === "") {
            $(".news-list").find("li").each(function (p) {
                $(this).delay(200).slideDown("fast");
            });
        } else {
            $(".news-list").find('li[data-category="' + filter + '"]').each(function (x) {
                $(this).delay(200).slideDown("fast");
            });
        }
    }
    $(document).ready(function () {
        /*
         * buat menu tree / tree view
         */
        $('#using_json').jstree({
            'core': {
                'data':<?php echo $jstree ?>
            }
        });
        
        setTimeout(function(){ 
            var value = $(".jstree-clicked").attr("href");
            console.log(value);
            $(".pdf").attr('src', base_url + 'assets/periodicreport/web/viewer.html?file=' + value); 
        }, 1000);
        /*
         * buat toggle sidebar
         */
        $(".collepse").click(function () {
            $("#sidebar").toggleClass("collapsed1");
            $("#content").toggleClass("col-md-12 animated fadeInRight col-md-9");
            $("iframe").toggleClass("pdf1 pdf");

            return false;
        });
        /*
         * event close
         */
        $("#tutup").click(function () {
            window.location.reload(true);
        });
        $("#tutup2").click(function () {
            window.location.reload(true);
        });
        /*
         * ganti file pdf pada iframe dari tree view
         */
        $('#using_json')
                .on('changed.jstree', function () {
                    var value = $(".jstree-clicked").attr("href");
//                    alert(value );
                    $(".pdf").attr('src', base_url + 'assets/periodicreport/web/viewer.html?file=' + value);
                })
                .jstree();
        /*
         * DataTabel File report
         */
        table = $('#table').DataTable({
            "processing": true,
            "serverSide": false,
            "order": [],
            "ajax": {
                "url": base_url + 'intelligence/HeadlineNews/listreport',
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [-1],
                    "orderable": false
                }
            ]
        });

        getNews();
        //  Reset tanggal
                $("#reset-news").click(function () {
                    $('.date').val("");
                    var list = $(".news-list .news-info");
                    $(list).fadeOut("fast");
                    $(".news-list").find("li").each(function (p) {
                        $(this).delay(200).slideDown("fast");
                    }).on('changeDate', function (e) {
                    });
                });

    });
</script>

<div class="modal" id="modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" id="tutup" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" style=""><i class="fa fa-upload"></i> Upload File Report</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox collapsed">
                            <div class="ibox-title collapse-link">
                                <h5 style="cursor: pointer;"><i class="fa fa-plus" style="color:#1ab394"></i> Entry New Report</h5>
                                <div class="ibox-tools">
                                </div>
                            </div>
                            <div class="ibox-content" style="display:none;">
                                <form action="#" enctype="multipart/form-data" id="form-report" class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="col-lg-2 col-md-2 control-label">Judul</label>
                                                <div class="col-lg-9 col-md-9"><input type="text" required="" name="NAMA_REPORT" id="NAMA_REPORT" class="form-control" placeholder="Judul Report"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 col-md-2 control-label">File</label>
                                                <div class="col-lg-9 col-md-9">
                                                    <input type="file" name="NAMA_FILE" id="NAMA_FILE">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5"> 
                                            <div class="form-group">
                                                <label class="col-lg-2 col-md-2 control-label">Tahun</label>
                                                <div class="col-lg-9 col-md-9">
                                                    <select class="form-control" name="TAHUN" id="tahun">
                                                        <option>-- Pilih Tahun --</option>
                                                        <?php
                                                        for ($i = 2016; $i <= Date('Y'); $i++) {
                                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                                        }
                                                        ?>    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 col-md-2 control-label">Bulan</label>
                                                <div class="col-lg-9 col-md-9">
                                                    <select class="form-control" name="BULAN" id="bulan">
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
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button onclick="upload()" id="btn-save" class="btn btn-primary" type="button"><i id="icon" class="fa fa-check"></i> Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No</th>
                                        <th style="text-align: center">Nama Report</th>
                                        <th style="text-align: center">Bulan</th>
                                        <th style="text-align: center">Tahun</th>
                                        <th style="text-align: center">File Report</th>
                                        <th style="text-align: center">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>    
                </div>`
            </div>
        </div>
    </div>
</div>
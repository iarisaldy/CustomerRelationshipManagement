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
    
    iframe {
        overflow-y: scroll;
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
                <h4><span><i class="fa fa-upload"></i> UPLOAD DATA</span></h4>            
            </div>

            <div class="panel-body">
                <div class="row" id="row-main">

                    <div class="col-lg-3 col-md-3" id="sidebar">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <div class="file-manager">

                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5><i class="fa fa-archive"></i> File Upload</h5>
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
                                <iframe id="pdf" class="pdf" src="<?php echo base_url(); ?>/intelligence/Upload/Uview" scrolling="yes"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>  
    </div>
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
                    var deskripsi = value['DESCRIPTION'].replace('>', '><!--');
                    var deskripsi1 = deskripsi.replace('<', '--><');
                    list = $('#info');
                    list.append('<li class="sidebar-message list -group-item news-info" data-category="' + tgl[0] + '" style="height:160px">' +
                            '<strong><a href="' + value['LINK'] + '" target="_blank">' + value['TITLE'] + '</a></strong>' +
                            '<br> ' +
                            '<small class="text-muted">' + dt_tgl + '</small>' +
                            '<div class="small m-t-xs" id="zoom">' +
                            '<p style="margin: 0 0 5px;width: 195px;">' + '<!--'+ deskripsi1 +'-->' + '</p>' +
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
                    var title = $(".jstree-clicked").attr("title");
                    var value = $(".jstree-clicked").attr("href");
                    //                    alert(value );
                    $(".pdf").attr('src', base_url + 'intelligence/Upload/Uview/' +title+'/'+ value);
                })
                .jstree();
        // Initialize jstree - sorry for manual, i've been seraching and its tak too long time and still not found
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

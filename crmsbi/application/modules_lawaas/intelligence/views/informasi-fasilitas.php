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
<script src="<?= base_url('assets/tinymce/js/tinymce/jquery.tinymce.min.js') ?>"></script>
<script src="<?= base_url('assets/tinymce/js/tinymce/tinymce.min.js') ?>"></script>
<div id="loading_purple"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Fasilitas Perusahaan</h4>
                </div>
            </div>
            <div class="panel-body">
                <button class="btn btn-success pull-left" onclick="add_facility()"><i class="glyphicon glyphicon-plus"></i> Tambah Fasilitas Perusahaan</button>
                <button class="btn btn-primary pull-right" onclick="exportExcel()"><i class="glyphicon glyphicon-export"></i> Export Excel</button>
                <br/><br/>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width:25px;text-align: center">No</th>
                                    <th style="text-align: center">Nama Perusahaan</th>
                                    <th style="text-align: center">Jenis Fasilitas</th>
                                    <th style="text-align: center">Nama Fasilitas</th>
                                    <th style="text-align: center">Latitude</th>
                                    <th style="text-align: center">Longitude</th>
                                    <th style="width:25px;text-align: center">Informasi</th>
                                    <th style="width:25px;text-align: center">Foto</th>
                                    <th style="width:25px;text-align: center">Marker</th>
                                    <th style="text-align: center">Status</th>
                                    <th style="width:150px;text-align: center">Action</th>
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
</div>

<script type="text/javascript">

    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url(); ?>';

    $(document).ready(function () {
        $.fn.dataTable.ext.errMode = 'none';
        //datatables
        table = $('#table').DataTable({
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "destroy": true,
            "ordering": false,
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_url + 'intelligence/Competitor/ListInfoFasilitas',
                "type": "POST"
            }
        });

        //set input/textarea/select event when change value, remove class error and remove text help block 
        $("input").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

        /*
         * validasi input LATITUDE dan LONGITUDE, hanya diperbolehkan angka (0-9), titik (.), dan minus (-)
         */
        $(".kordinat").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 45, 109, 189, 173, 190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });


        // event radio button pada marker
        $('#marker_up').hide();
        $("input[type='radio']").click(function () {
            selected_value = $(this).attr("value");
            if (selected_value === 'default') {
                $('#marker_up').hide();
            } else if (selected_value === 'baru') {
                $('#marker_up').show();
            }
        });
    });


    function add_facility()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Fasilitas Perusahaan'); // Set Title to Bootstrap modal title
        $('#edit_al').hide();
    }

    function edit_infofacility(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string



        //Ajax Load data from ajax
        $.ajax({
            url: base_url + 'intelligence/Competitor/DetailInfoFasilitas/' + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {

                $('[name="ID"]').val(data.ID);
                $('[name="KODE_PERUSAHAAN"]').val(data.KODE_PERUSAHAAN);
                $('[name="FASILITAS"]').val(data.FASILITAS);
                $('[name="NAMA"]').val(data.NAMA);
                $('[name="LATITUDE"]').val(data.LATITUDE);
                $('[name="LONGITUDE"]').val(data.LONGITUDE);
                $('[name="STATUS_FASILITAS"]').val(data.STATUS_FASILITAS);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Fasilitas Perusahaan'); // Set title to Bootstrap modal title
                $('#edit_al').show();
                $('#edit_al').text('(Kosongi jika tidak ingin mengganti marker)');

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error');
            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function save()
    {
        $('#btnSave').text('simpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'add') {
            url = base_url + 'intelligence/Competitor/AddInfoFasilitas';
        } else {
            url = base_url + 'intelligence/Competitor/UpdateInfoFasilitas';
        }

        // ajax adding data to database

        var formData = new FormData($('#form')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (data)
            {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                } else
                {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error');
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }

    function delete_infofacility(id)
    {
        if (confirm('Apakah anda yakin ingin menghapus data ini?'))
        {
            // ajax delete data to database
            $.ajax({
                url: base_url + 'intelligence/Competitor/DeleteInfoFasilitas/' + id,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error');
                }
            });

        }
    }
</script>

<script>
// Function CRUD INFO
    var save_method; //for save method string
    var table;
    var table2;
    var base_url = '<?php echo base_url(); ?>';
    var id_global;

    $(document).ready(function () {
        
        tinymce.init({
            selector: '#info-fs',
            menubar: false,
            branding: false,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
            ],
            toolbar1: 'undo redo | insert | styleselect | preview media | forecolor backcolor ',
            toolbar2: 'codesample help | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent ',
            image_advtab: true,
            templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]

        });

    });
    function show_info(id)
    {
        id_global = id;
        $('#modal_info').modal('show'); // show bootstrap modal
        $('.modal-title').text('Data Informasi Fasilitas Perusahaan'); // Set Title to Bootstrap modal title
        $(document).ready(function () {
            $.fn.dataTable.ext.errMode = 'none';

            //datatables
            table = $('#table-informasi').DataTable({
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "destroy": true,
                "ordering": false,
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": base_url + 'intelligence/Competitor/ListInfo/' + id,
                    "type": "POST"
                }
            });
            table2 = $('#table-log').DataTable({
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "destroy": true,
                "ordering": false,
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": base_url + 'intelligence/Competitor/ListLog/' + id,
                    "type": "POST"
                }
            });
            //set input/textarea/select event when change value, remove class error and remove text help block 
            $("input").change(function () {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
        });
    }

    function add_info()
    {

        save_method = 'add';
        $('#form-info')[0].reset(); // reset form on modals
        $('#ID_PRSH_FASILITAS').val(id_global);
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#add_info').modal('show'); // show bootstrap modal
    }

    function edit_info(id)
    {
        var id_info;
        save_method = 'update';
        $('#form-info')[0].reset(); // reset form on modals
        id_info = id;
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url: base_url + 'intelligence/Competitor/DetailInfo/' + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {

                $('[name="ID"]').val(data.ID);
                $('[name="ID_PRSH_FASILITAS"]').val(data.ID_PRSH_FASILITAS);
                $('[name="HEADER"]').val(data.HEADER);
                $('[name="INFO"]').change(function () {
                    //var s = $(this).val();
                    //alert(s);
                    tinyMCE.activeEditor.setContent(data.TEXT);
                }).change();
                $('[name="STATUS"]').val(data.STATUS);
                $('[name="CREATE_DATE"]').val(data.CREATE_DATE);
                $('[name="CREATE_BY"]').val(data.CREATE_BY);
                $('[name="UPDATE_DATE"]').val(data.UPDATE_DATE);
                $('[name="UPDATE_BY"]').val(data.UPDATE_BY);
                $('#ID_INFO').val(id_info);
                $('#ID_PRSH_FASILITAS').val(id_global);

                $('#add_info').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error');
            }
        });
        $('#id-info').val(id);
    }

    function reload_table_info()
    {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function save_info()
    {
        $('#btnSave').text('simpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'add') {
            url = base_url + 'intelligence/Competitor/AddInfo';
        } else {
            url = base_url + 'intelligence/Competitor/UpdateInfo';
        }

        // ajax adding data to database
        tinyMCE.triggerSave();
        var formData = new FormData($('#form-info')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            beforeSend: function () {
                $('#loading_purple').show();
            },
            complete: function () {
                $('#loading_purple').hide();
            },
            success: function (data)
            {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#add_info').modal('hide');
                    reload_table_info();
                } else
                {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error');
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }

    function delete_info(id)
    {
        if (confirm('Apakah anda yakin ingin menghapus data ini?'))
        {
            // ajax delete data to database
            $.ajax({
                url: base_url + 'intelligence/Competitor/DeleteInfo/' + id,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table_info();
                },
                beforeSend: function () {
                    $('#loading_purple').show();
                },
                complete: function () {
                    $('#loading_purple').hide();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error');
                }
            });

        }
    }
</script>

<script>

// Function CRUD FOTO 
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url(); ?>';
    var fasilitas;

    function show_foto(id)
    {
        fasilitas = id;
        $('#modal_foto').modal('show'); // show bootstrap modal
        $('.modal-title').text('Data Foto Fasilitas Perusahaan'); // Set Title to Bootstrap modal title
        $(document).ready(function () {
            $.fn.dataTable.ext.errMode = 'none';

            //datatables
            table = $('#table-foto').DataTable({
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "destroy": true,
                "dom": 'lrtip',
                "ordering": false,
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": base_url + 'intelligence/Competitor/ListFoto/' + id,
                    "type": "POST"
                }
            });

            //set input/textarea/select event when change value, remove class error and remove text help block 
            $("input").change(function () {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
        });
    }

    function add_foto()
    {
        save_method = 'add';
        $('#form-foto')[0].reset(); // reset form on modals
        $('#FASILITAS').val(fasilitas);
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#add_foto').modal('show'); // show bootstrap modal
    }

    function save_foto()
    {
        $('#btnSave').text('simpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'add') {
            url = base_url + 'intelligence/Competitor/AddFoto';
        }

        // ajax adding data to database

        var formData = new FormData($('#form-foto')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            beforeSend: function () {
                $('#loading_purple').show();
            },
            complete: function () {
                $('#loading_purple').hide();
            },
            success: function (data)
            {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#add_foto').modal('hide');
                    reload_table_info();
                } else
                {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error');
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }

    function delete_foto(id)
    {
        if (confirm('Apakah anda yakin ingin menghapus foto ini?'))
        {
            // ajax delete data to database
            $.ajax({
                url: base_url + 'intelligence/Competitor/DeleteFoto/' + id,
                type: "POST",
                dataType: "JSON",
                beforeSend: function () {
                    $('#loading_purple').show();
                },
                complete: function () {
                    $('#loading_purple').hide();
                },
                success: function (data)
                {
                    //if success reload ajax table
                    reload_table_info();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error');
                }
            });

        }
    }

    function exportExcel() {
        location.href = base_url + "intelligence/Competitor/downloadExcel";
    }
    
    
</script>


<!-- Bootstrap modal tambah fasilitas perusahaan -->
<div class="modal" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Form</h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="#" id="form" method="POST">
                    <div class="form-body">
                        <input type="hidden" value="" name="ID"/> 
                        <div class="form-group">
                            <label class="control-label">Nama Perusahaan</label>
                            <select class="input-sm form-control" name="KODE_PERUSAHAAN">
                                <option value="">Pilih</option>
                                <?php foreach ($perusahaan as $row) { ?>
                                    <option value="<?= $row->KODE_PERUSAHAAN ?>"><?= $row->NAMA_PERUSAHAAN ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Jenis Fasilitas</label>
                            <select class="input-sm form-control" name="FASILITAS">
                                <option value="">Pilih</option>
                                <?php foreach ($jenis_fasilitas as $row) { ?>
                                    <option value="<?= $row->ID ?>"><?= $row->NAMA ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nama Fasilitas</label>
                            <input name="NAMA" class="form-control" required="" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Latitude</label>
                            <input name="LATITUDE" class="form-control kordinat" required="" type="text">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Longitude</label>
                            <input name="LONGITUDE" class="form-control kordinat" required="" type="text">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" id="label-photo">Marker <font id="edit_al" style="font-size: 10px;font-weight: 500;"></font></label>
                            <br>
                            <label class="radio-inline">
                                <input type="radio" value="default" name="MARKER_UP"> Default
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="baru" name="MARKER_UP"> Marker Baru
                            </label>
                            <input id="marker_up" name="MARKER" type="file" style="padding-top: 5px;">
                            <p style="padding-top: 5px;">Download template marker <a href="<?php echo base_url(); ?>assets/marker/marker_peta.rar" class="btn btn-xs btn-primary"><i class="fa fa-download"></i></a></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status Fasilitas</label>
                            <select class="input-sm form-control" name="STATUS_FASILITAS">
                                <option value="">Pilih</option>
                                <option value="0">Aktif</option>
                                <option value="1">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-reply"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->



<!-- Bootstrap modal info fasilitas perusahaan-->
<div class="modal" id="modal_info" role="dialog">
    <div class="modal-dialog" style="width: 50%;">
        <div class="modal-content animated fadeIn">
            <div class="modal-header" style=" background: linear-gradient(to left, #1ab394, #036C13);color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form</h3>
            </div>
            <div class="modal-body form">
                <button class="btn btn-success" onclick="add_info()"><i class="glyphicon glyphicon-plus"></i> Tambah Informasi</button>
<!--                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>-->
                <br />
                <br />
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> Info Fasilitas </a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Log Activity</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="table-informasi" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">No</th>
                                                <th style="text-align: center">Header</th>
                                                <th style="text-align: center">Informasi</th>
                                                <th style="text-align: center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="isi">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <table id="table-log" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">No</th>
                                            <th style="text-align: center">Informasi</th>
                                            <th style="text-align: center">Date</th>
                                            <th style="text-align: center">Author</th>
                                            <!--<th style="text-align: center">Action</th>-->
                                        </tr>
                                    </thead>
                                    <tbody class="isi">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                <!--                <div class="table-responsive">
                                    <table id="table-informasi" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">No</th>
                                                <th style="text-align: center">Header</th>
                                                <th style="text-align: center">Informasi</th>
                                                <th style="text-align: center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="isi">
                                        </tbody>
                                    </table>
                                </div>-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<!-- Bootstrap modal tambah info fasiitas perusahaan-->
<div class="modal" id="add_info" role="dialog">
    <div class="modal-dialog" style=width: 666px;">
        <div class="modal-content animated fadeIn">
            <div class="modal-header" style=" background: linear-gradient(to left, #1ab394, #036C13);color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form-info" method="POST" class="form-horizontal">
                    <div class="form-body">
                        <input type="hidden" value="" name="ID"/> 
                        <input type="hidden" name="ID_PRSH_FASILITAS" id="ID_PRSH_FASILITAS"/> 
                        <input type="hidden" value="" name="ID" id="ID_INFO"/> 
                        <div class="form-group">
                            <label class="control-label col-md-2">Header</label>
                            <div class="col-md-9">
                                <input name="HEADER" class="form-control" required="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Informasi Fasilitas</label>
                            <div class="col-md-9">
                                <textarea name="INFO" id="info-fs" class="form-control" required="" type="text" maxlength="280" placeholder="Maximum length 280 characters"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_info()" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-reply"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->





<!-- Bootstrap modal foto fasilitas perusahaan -->
<div class="modal" id="modal_foto" role="dialog">
    <div class="modal-dialog" style="width: 55%;">
        <div class="modal-content animated fadeIn">
            <div class="modal-header" style=" background: linear-gradient(to left, #1ab394, #036C13);color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form</h3>
            </div>
            <div class="modal-body form" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <button class="btn btn-success" onclick="add_foto()"><i class="glyphicon glyphicon-plus"></i> Tambah Foto</button>
<!--                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>-->
                <br />
                <br />
                <div class="table-responsive">
                    <table id="table-foto" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width:25px;text-align: center">No</th>
                                <th style="text-align: center">Foto Fasilitas Perusahaan</th>
                                <th style="width:30px;text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<!-- Bootstrap modal tambah foto fasilitas perusahaan-->
<div class="modal" id="add_foto" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form-foto" method="POST" class="form-horizontal">
                    <div class="form-body">
                        <input type="hidden" value="" name="ID"/> 
                        <input type="hidden" name="ID_PRSH_FASILITAS" id="FASILITAS"/> 
                        <div class="form-group">
                            <label class="control-label col-md-4" id="label-photo">Foto Fasilitas Perusahaan</label>
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <input name="FOTO" type="file">
                                    Upload foto 
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_foto()" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-reply"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


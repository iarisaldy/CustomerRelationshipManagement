<style>
    .panel-heading, .modal-header {
        background: linear-gradient(to left, #1ab394, #036C13);
        color: white;
    }
    .lightBoxGallery {
        text-align: left;
    }
    .lightBoxGallery img {
        margin: 5px;
    } 
    .modal-open .modal {
        overflow-x: hidden;
        overflow-y: auto;
    }
</style>

<link href="<?php echo base_url(); ?>assets/css/plugins/slick/slick.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/plugins/slick/slick-theme.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/plugins/slick/slick.min.js"></script>
<link rel="stylesheet" href="<?= base_url('assets/select/css/bootstrap-select.css') ?>">
<link rel="stylesheet" href="<?= base_url('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css') ?>">
<script src="<?= base_url('assets/select/js/bootstrap-select.js') ?>"></script>
<script src="<?= base_url('assets/tinymce/js/tinymce/jquery.tinymce.min.js') ?>"></script>
<script src="<?= base_url('assets/tinymce/js/tinymce/tinymce.min.js') ?>"></script>

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

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Master Data Market Info</h4>
                </div>
            </div>
            <div class="panel-body">

                <br />
                <br />
                <div class="ibox-content">
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width:25px;text-align: center">No</th>
                                <th style="text-align: center">Pronvinsi</th>
                                <th style="text-align: center">Informasi</th>
                                <th style="text-align: center">Foto Lapangan</th>
                                <th style="text-align: center">Gambar Grafik</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var save_method; //for save method string
    var table, table2;
    var base_url = '<?php echo base_url(); ?>';

    $(document).ready(function () {

        //datatables
        table = $('#table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "destroy": true,
            "ordering": false,
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_url + 'intelligence/MarketInfo/ListMarketInfo',
                "type": "POST"
            }
        });

        tinymce.init({
            selector: '#comment',
            menubar: false,
            branding: false,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
            ],
            toolbar1: 'undo redo | insert | styleselect | preview media | forecolor backcolor | codesample help',
            toolbar2: 'bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent ',
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

        $(document).on('focusin', function (e) {
            if ($(e.target).closest(".mce-window").length) {
                e.stopImmediatePropagation();
            }
        });

        $('.date').datepicker({
            format: "mm-yyyy",
            dateFormat: 'mm-yy'
        });

        //BUG OF MODAL
        $('.modal').on('hidden.bs.modal', function (e) {
            console.log('stiilll outside');
            if ($('.modal').hasClass('in')) {
                console.log('masuk');
                $('body').addClass('modal-open');
            }
        });

    });




    function add_information()
    {
        save_method = 'add';
        $('#form1')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Informasi'); // Set Title to Bootstrap modal title
    }

    function edit_information(id)
    {
        save_method = 'update';
        $('#form1')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            url: base_url + 'intelligence/MarketInfo/DetailInformasi/' + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                $('[name="ID"]').val(data.IDMSINFO);
                $('[name="NAMA_INFO"]').val(data.NAMA_INFO);
                $('[name="INFORMASI"]').val(data.INFORMASI);
                $('[name="URUTAN_INFO"]').val(data.URUTAN_INFO);
                $('[name="PROV_ID"]').val(data.PROV_ID);
                $('[name="INFODATE"]').val(data.INFODATE);
                $('#compInfo').val(data.COMPANY).change();
                $("#comment").change(function () {
                    //var s = $(this).val();
                    //alert(s);
                    tinyMCE.activeEditor.setContent(data.INFORMASI);
                }).change();
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Informasi'); // Set title to Bootstrap modal title
            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null, false); //reload datatable ajax 
        table2.ajax.reload(null, false); //reload datatable ajax 
    }

    function save()
    {
        $('#btnSave').text('simpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'add') {
            url = base_url + 'intelligence/MarketInfo/AddInformasi';
        } else {
            url = base_url + 'intelligence/MarketInfo/UpdateInformasi';
        }
        tinyMCE.triggerSave();
        // ajax adding data to database
        var formData = new FormData($('#form1')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            complete: function (data)
            {
                $('#btnSave').attr('disabled', false); //set button enable 
            },
            success: function (data)
            {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }

    function delete_information(id)
    {
        if (confirm('Apakah anda yakin ingin menghapus data ini?'))
        {
            // ajax delete data to database
            $.ajax({
                url: base_url + 'intelligence/MarketInfo/DeleteInformasi/' + id,
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

    function show_info(nmprov, prov) {
        $(document).ready(function () {
            $.fn.dataTable.ext.errMode = 'none';

            //datatables
            table = $('#table-info').DataTable({
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "destroy": true,
                "dom": 'lrtip',
                "ordering": false,
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": base_url + 'intelligence/MarketInfo/listInformasi/' + prov,
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
                    "url": base_url + 'intelligence/MarketInfo/listLog/' + prov + '/INFORMASI',
                    "type": "POST"
                }
            });

            //set input/textarea/select event when change value, remove class error and remove text help block 
            $("input").change(function () {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
        });

        $('[name="PROV_ID"]').val(prov);
        $('#compInfo').find("option[value='6000']").remove();
        if (prov == '0001') {
            
            $('#compInfo').append($('<option>',
                    {
                        value: '6000',
                        text: 'TLCC'
                    }));
        } 
        $('#title-mi').html('Market Info ' + nmprov);
        $('#modal_info').modal('show');
    }

    function show_fotoLap(nmprov, prov) {
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
                    "url": base_url + 'intelligence/MarketInfo/listGambar/' + prov + '/' + 'LAPANGAN',
                    "type": "POST"
                }
            });

            table2 = $('#table-logfoto').DataTable({
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "destroy": true,
                "ordering": false,
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": base_url + 'intelligence/MarketInfo/listLog/' + prov + '/LAPANGAN',
                    "type": "POST"
                }
            });

            //set input/textarea/select event when change value, remove class error and remove text help block 
            $("input").change(function () {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });


        });

        $('[name="IDPROV"]').val(prov);
        $('#compFoto').find("option[value='6000']").remove();
        if (prov == '0001') {
            $('#compFoto').append($('<option>',
                    {
                        value: '6000',
                        text: 'TLCC'
                    }));
        } 
        $('[name="TIPEFOTO"]').val('LAPANGAN');
        $('#title-ft').html('Foto Lapangan ' + nmprov);
        $('#modal_foto').modal('show');
    }

    function show_gambarGrafik(nmprov, prov) {
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
                    "url": base_url + 'intelligence/MarketInfo/listGambar/' + prov + '/' + 'GRAFIK',
                    "type": "POST"
                }
            });

            table2 = $('#table-logfoto').DataTable({
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "destroy": true,
                "ordering": false,
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": base_url + 'intelligence/MarketInfo/listLog/' + prov + '/GRAFIK',
                    "type": "POST"
                }
            });

            //set input/textarea/select event when change value, remove class error and remove text help block 
            $("input").change(function () {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
        });
       
        $('[name="IDPROV"]').val(prov);
        $('#compFoto').find("option[value='6000']").remove();
        if (prov == '0001') {
            $('#compFoto').append($('<option>',
                    {
                        value: '6000',
                        text: 'TLCC'
                    }));
        }
        $('[name="TIPEFOTO"]').val('GRAFIK');
        $('#title-ft').html('Gambar Grafik ' + nmprov);
        $('#modal_foto').modal('show');
    }

    function add_gambar()
    {
        save_method = 'add';
        $('#form2')[0].reset(); // reset form on modals
        $('#pictPrev').attr('src', '');
        $('#modal_formfoto').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Foto'); // Set Title to Bootstrap modal title
    }

    function edit_Gambar(id)
    {
        save_method = 'update';
        $('#form2')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            url: base_url + 'intelligence/MarketInfo/DetailGambar/' + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                $('[name="ID"]').val(data.IDMSFOTO);
                $('[name="CAPTION"]').val(data.CAPTION);
                //$('[name="FOTO"]').val(data.MSFOTO);
                $('#pictPrev').attr('src', base_url + 'assets/marketshare_gambar/' + data.MSFOTO);
                $('[name="IDPROV"]').val(data.IDPROV).change();
                $('[name="URUTAN_FOTO"]').val(data.URUTAN_FOTO);
                $('[name="FOTODATE"]').val(data.FOTODATE);
                $('#compFoto').val(data.COMPANY).change();
                $('#modal_formfoto').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Gambar'); // Set title to Bootstrap modal title
            }
        });
    }

    function save_gambar()
    {
        $('#btnSave').text('simpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'add') {
            url = base_url + 'intelligence/MarketInfo/AddGambar';
        } else {
            url = base_url + 'intelligence/MarketInfo/UpdateGambar';
        }

        // ajax adding data to database
        var formData = new FormData($('#form2')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            complete: function (data)
            {
                $('#btnSave').attr('disabled', false); //set button enable 
            },
            success: function (data)
            {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_formfoto').modal('hide');
                    reload_table();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }

    function delete_Gambar(id)
    {
        if (confirm('Apakah anda yakin ingin menghapus data ini?'))
        {
            // ajax delete data to database
            $.ajax({
                url: base_url + 'intelligence/MarketInfo/DeleteGambar/' + id,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {
                    //if success reload ajax table
                    $('#modal_formfoto').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error');
                }
            });

        }
    }

    function pict(event) {
        var reader = new FileReader();
        reader.readAsDataURL(event.target.files[0]);
        reader.onload = function () {
            var output = document.getElementById('pictPrev');
            output.src = reader.result;
        };
    }

    function urutanChange(event) {
        $.ajax({
            url: base_url + 'intelligence/MarketInfo/check_urutan/' + $('[name="URUTAN_INFO"]').val() + '/' + $("#compInfo").val() + '/' + $('[name="INFODATE"]').val() + '/' + $('[name="PROV_ID"]').val() + '/' + $('#idinfo').val(),
            type: "POST",
            success: function (data)
            {
                $('#error-urutan').html((data != 0 ? 'Nomor Urut Sudah terpakai' : ''));
                if (data > 0) {
                    $('#btnSave').prop('disabled', true);
                } else {
                    $('#btnSave').prop('disabled', false);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $('#error-urutan').html('Error Checking');
            }
        });
    }

    function urutanFotoChange(event) {
        $.ajax({
            url: base_url + 'intelligence/MarketInfo/check_urutan_foto/' + $('[name="URUTAN_FOTO"]').val() + '/' + $("#compFoto").val() + '/' + $('[name="FOTODATE"]').val() + '/' + $('[name="IDPROV"]').val() + '/' + $('[name="TIPEFOTO"]').val() + '/' + $('#idfoto').val(),
            type: "POST",
            success: function (data)
            {
                $('#error-urutan-foto').html((data != 0 ? 'Nomor Urut Sudah terpakai' : ''));
                if (data > 0) {
                    $('#btnSave').prop('disabled', true);
                } else {
                    $('#btnSave').prop('disabled', false);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $('#error-urutan-foto').html('Error Checking');
            }
        });
    }


</script>

<!-- Bootstrap modal informasi -->
<div class="modal" id="modal_info"  role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header" style=" background: linear-gradient(to left, #1ab394, #036C13);color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 >Master Market Info</h3>
            </div>
            <div class="modal-body form">
                <button class="btn btn-success" onclick="add_information()"><i class="glyphicon glyphicon-plus"></i> Tambah Informasi</button>
<!--                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>-->
                <br />
                <br />
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a id='title-mi' data-toggle="tab" href="#tab-1" aria-expanded="true"> Market Info </a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Log Activity</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="table-info" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <td>No.</td>
                                                <td>Company</td>
                                                <td>No. Urut</td>
                                                <td>Bulan Info</td>
                                                <td>Nama Info</td>
                                                <td>Isi Info</td>
                                                <td>Created By</td>
                                                <td>Created On</td>
                                                <td>Update By</td>
                                                <td>Update On</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>

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


<!-- Bootstrap modal -->
<div class="modal" id="modal_form" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title">Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form1">
                    <div class="form-body">
                        <input type="hidden" value="" id="idinfo" name="ID"/> 
                        <!--                        <div class="form-group">
                                                    <label class="control-label">Provinsi</label>
                        <?php
                        $dd_attribute = 'class="form-control selectpicker" data-live-search="true" id="provid"';
                        echo form_dropdown('PROV_ID', $dropdown, '', $dd_attribute);
                        ?>
                                                </div>-->
                        <input name="PROV_ID" class="form-control" type="hidden" type="text">
                        <div class="form-group">
                            <label class="control-label">Company</label>
                            <select id="compInfo" onchange="urutanChange(this)" name="COMPANY" class="form-control">
                                <option value="" selected disabled>SELECT COMPANY</option>
                                <option value="7000">Semen Gresik</option>
                                <option value="3000">Semen Padang</option>
                                <option value="4000">Semen Tonasa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tanggal</label>
                            <input name="INFODATE" onchange="urutanChange(this)" class="form-control  date" required type="text">
                        </div>

                        <div class="form-group">
                            <label class="control-label">No Urut Informasi</label>
                            <input name="URUTAN_INFO" onkeyup="urutanChange(this)" class="form-control" required type="number">
                            <span class="text-danger" id="error-urutan"></span>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Nama Informasi</label>
                            <input name="NAMA_INFO" class="form-control" required type="text">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Detail Informasi</label>
                            <textarea class="form-control" name="INFORMASI" rows="5" id="comment"></textarea>
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

<!-- Bootstrap modal informasi -->
<div class="modal" id="modal_foto"  role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header" style=" background: linear-gradient(to left, #1ab394, #036C13);color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 >Master Foto Market Info</h3>
            </div>
            <div class="modal-body form">
                <button class="btn btn-success" onclick="add_gambar()"><i class="glyphicon glyphicon-plus"></i> Tambah Foto</button>
<!--                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>-->
                <br />
                <br />
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a id='title-ft' data-toggle="tab" href="#tab-1foto" aria-expanded="true"> Foto Market Info </a></li>
                        <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Log Activity</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1foto" class="tab-pane active">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="table-foto" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <td>No.</td>
                                                <td>Company</td>
                                                <td>Foto</td>
                                                <td>Caption</td>
                                                <td>Bulan Foto</td>
                                                <td>Created By</td>
                                                <td>Created On</td>
                                                <td>Update By</td>
                                                <td>Update On</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane">
                            <div class="panel-body">
                                <table id="table-logfoto" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">No</th>
                                            <th style="text-align: center">Informasi</th>
                                            <th style="text-align: center">Date</th>
                                            <th style="text-align: center">Author</th>
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

<!-- Bootstrap modal -->
<div class="modal" id="modal_formfoto" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title">Edit</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form2">
                    <div class="form-body">
                        <input type="hidden" value="" id="idfoto" name="ID"/> 
                        <input type="hidden" value="" name="IDPROV"/> 
                        <input type="hidden" value="" id="tipefoto" name="TIPEFOTO"> 
                        <!--                        <div class="form-group">
                                                    <label class="control-label">Provinsi</label>
                        <?php
                        $dd_attribute = 'class="form-control selectpicker" data-live-search="true"';
                        echo form_dropdown('IDPROV', $dropdown, '', $dd_attribute);
                        ?>
                                                </div>-->
                        <div class="form-group">
                            <label class="control-label">Company</label>
                            <select id="compFoto" onchange="urutanFotoChange(this)" name="COMPANY" class="company form-control">
                                <option value="" selected disabled>SELECT COMPANY</option>
                                <option value="7000">Semen Gresik</option>
                                <option value="3000">Semen Padang</option>
                                <option value="4000">Semen Tonasa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tanggal</label>
                            <input name="FOTODATE" onchange="urutanFotoChange(this)" class="form-control datepicker date" required type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">No Urut Informasi</label>
                            <input name="URUTAN_FOTO" onkeyup="urutanFotoChange(this)" class="form-control" required type="number">
                            <span class="text-danger" id="error-urutan-foto"></span>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Foto</label>
                            <input name="FOTO" required type="file" onChange="pict(event);">
                        </div>
                        <div class="form-group">
                            <img src="" id="pictPrev" class="img-rounded" alt="" width="300">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Caption</label>
                            <textarea class="form-control" maxlength="255" name="CAPTION" rows="5" id="caption"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_gambar()" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-reply"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->